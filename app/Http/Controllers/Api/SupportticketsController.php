<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ticket;
use App\TicketType;
use App\TicketStatus;
use App\TicketArea;
use App\User;
use Illuminate\Http\Response;
use Carbon\Carbon;
class SupportticketsController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getselects(Request $request)
     {
       $areas = array();
       foreach (TicketArea::all() as $key => $area) {
         $areas[] = array(
           'label'=> $area->name,
           'value'=> $area->id,
         );
       }
       $statusarr = array();
       foreach (TicketStatus::all() as $key => $status) {
         $statusarr[] = array(
           'label'=> $status->name,
           'value'=> $status->id,
         );
       }
       $types = array();
       foreach (TicketType::all() as $key => $type) {
         $types[] = array(
           'label'=> $type->name,
           'value'=> $type->id,
         );
       }
       $selects = array(
         'types' => $types,
         'status' => $statusarr,
         'areas' => $areas,
         'success' => true,
       );
       return $selects;
     }
     public function addComment(Request $request)
     {
       if(!$request->ticket_id && $request->body){
         return array(
           'success' => false,
         );
       }
       $ticket = Ticket::find($request->ticket_id);
       $user = User::where('phone',$request->user_id)->first();
       $ticket->comments()->create(['body'=>$request->body,'user_id'=>$user->id]);
        return array(
          'success' => true,
        );

     }
     public function addticket(Request $request)
     {
       if(!$request->user_id){
         return array(
           'success' => false,
         );
       }
       $user_id = User::where('phone',$request->user_id)->first();
       $image = base64_decode($request->image1);
       $encr = rand(1, 100000000).$user_id->id;
       $image_name= $encr.'supporttickets.png';

       if($user_id){
           $path = public_path() . DIRECTORY_SEPARATOR."images" .DIRECTORY_SEPARATOR. $image_name;
           file_put_contents($path, $image);
           $request = $request->all();
           $request['user_id'] = $user_id->id;
           $ticket = Ticket::create($request);
           $ticket->photos()->create(['path'=>$image_name]);
           $added = array(
             'success' => true,
           );
           return $added;
         }
        return array(
          'success' => false,
        );

     }
     public function ticket(Request $request)
     {
       $ticket = Ticket::find($request->id);
       $ticket['area_name'] = $ticket->areatb->name;
       $ticket['status_name'] = $ticket->statustb->name;
       $ticket['type_name'] = $ticket->typetb->name;
       $ticket['created_date'] = Carbon::now($ticket->create_at)->toDateTimeString();
       $ticketsArray = array(
         'images' =>$ticket->photos,
         'ticket_data' =>$ticket,
         'comments' =>$ticket->comments,
         'success' =>true,
       );
       return $ticketsArray;
     }
    public function tickets(Request $request)
    {
      try {
          $tickets = Ticket::orderBy('created_at','desc')->get();
          $ticketsArray = array();
          $ticketsArray['success'] = false;
          foreach ($tickets as $key => $ticket) {
            $ticket['area_name'] = $ticket->areatb->name;
            $ticket['status_name'] = $ticket->statustb->name;
            $ticket['type_name'] = $ticket->typetb->name;
            $ticketsArray['tickets'][] = array(
              'images' =>$ticket->photos,
              'ticket_data' =>$ticket,
            );
          }
          $ticketsArray['success'] = true;
          $ticketsArray['url'] = $request->root();
      }
      catch (\Exception $e) {
          $ticketsArray['success'] = false;
      }
      return response()->json($ticketsArray);
    }
}
