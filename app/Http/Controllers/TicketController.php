<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketArea;
use App\TicketStatus;
use App\TicketType;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;


class TicketController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::orderBy('created_at','DESC')->paginate(10);
        $current_user_id = Sentinel::getUser()->id;
        return View('ticket.index',compact('tickets','current_user_id'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add Ticket',
            'method' => 'POST',
            'action' => "TicketController@store",
            'fields' => array(
                'title' => array(
                    'type'=>'text',
                    'title'=>'Title',
                ),
                'description' => array(
                    'type'=>'text',
                    'title'=>'Description',
                ),
                'area' => array(
                    'type'=>'select',
                    'title'=>'Ticket Area',
                    'options'=>$this->area(),
                ),
                'status' => array(
                    'type'=>'select',
                    'title'=>'Status',
                    'options'=>$this->status(),
                ),
                'type_id' => array(
                    'type'=>'select',
                    'title'=>'Type',
                    'options'=>$this->type(),
                ),
            ),

        );
        return View('base.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 'description', 'title', 'user_id','type_id','area','status'
        $this->validate($request,[
            'description' => 'required',
            'title' => 'required',
            'area' => 'required',
            'status' => 'required',
            'type_id' => 'required'
        ]);

        //$request = $request->all();
        // 'description', 'title', 'user_id','type_id','area','status'

        Ticket::create([
            'description'  => $request->description,
            'title'  => $request->title,
            'user_id' => Sentinel::getUser()->id,
            'type_id' => $request->type_id,
            'area'  => $request->area,
            'status'  => $request->status,
        ]);

        Session::flash('message','Tickets Added Successfully');
        return redirect('/tickets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

        // var_dump(Brand::find($id)->news);die();
        $data = array(

            'title' => 'Update Ticket',
            'method' => 'POST',
            'action' => "tickets.update",
            'data' => Ticket::find($id),
            'link'=> (new Ticket())->getKeyName(),
            'fields' => array(
                'title' => array(
                    'type'=>'text',
                    'title'=>'Title',
                ),
                'description' => array(
                    'type'=>'text',
                    'title'=>'Description',
                ),
                'area' => array(
                    'type'=>'select',
                    'title'=>'Ticket Area',
                    'options'=>$this->area(),
                ),
                'status' => array(
                    'type'=>'select',
                    'title'=>'Type',
                    'options'=>$this->status(),
                ),
                'type_id' => array(
                    'type'=>'select',
                    'title'=>'Type',
                    'options'=>$this->type(),
                ),
            ),
        );
        return View('base.update',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $realRequest = $request;

        //$file = $request->file('imagePath');
        $request = $request->all();

//        if($file){
//            $file_name  = 'user-'.$request['first_name'].'-'.$request['email'].'-'.$file->getClientOriginalName();
//            Storage::disk('local')->put($file_name,File::get($file));
//            $request['imagePath'] = $file_name;
//        }

        $admin = Ticket::find($id);
        $realRequest->session()->flash('message','Ticket Updated Successfully');
        $admin->update($request);
        return redirect('tickets/'. $id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();

        Session::flash('message','Admin Deleted Successfully');
        return redirect('tickets');
    }

    public function area(){
        $ticketAreas = TicketArea::orderBy('name','desc')->get();

        $ticketAreaOptions = array();

        foreach ($ticketAreas as $key => $ticketArea) {
            $ticketAreaOptions[$ticketArea->id] = $ticketArea->name;
        }

        return $ticketAreaOptions;
    }

    //Type
    public function type(){

        $ticketTypes = TicketType::orderBy('name','desc')->get();

        $ticketTypesOptions = array();

        foreach ($ticketTypes as $key => $ticketType) {

            $ticketTypesOptions[$ticketType->id] = $ticketType->name;

        }

        return $ticketTypesOptions;
    }

    public function status(){

        $ticketStatus = TicketStatus::orderBy('name','desc')->get();

        $ticketTypesOptions = array();

        foreach ($ticketStatus as $key => $ticket) {

            $ticketTypesOptions[$ticket->id] = $ticket->name;

        }
        return $ticketTypesOptions;
    }
}
