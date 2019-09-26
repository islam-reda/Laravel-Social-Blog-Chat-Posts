<?php

namespace App\Http\Controllers;

use App\Events\TicketCommentEvent;
use App\TicketComment;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests;

class TicketCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function comment(Request $request){

        $this->validate($request,[
            'content' => 'required',
            'ticket_id' => 'required',
        ]);

        $comment =  TicketComment::create([
            'body'=>$request->content,
            'user_id' => Sentinel::getUser()->id,
            'ticket_id'=>$request->ticket_id
        ]);

//        $notification = Notification::create([
//            'from_user_id' => Sentinel::getUser()->id,
//            'to_user_id' => $comment->post->user_id,
//            'message' => 'comment',
//            'is_read' => false,
//        ]);

        event(new TicketCommentEvent($comment));

        //event(new NotificationEvent($notification));

        return redirect('/');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
