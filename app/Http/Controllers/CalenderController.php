<?php

namespace App\Http\Controllers;
use App\CalenderEvent;
use App\User;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Http\Request;
use App\Http\Requests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CalenderController extends Controller
{
    public function index(){

        return view('calender.calender');
    }

    public function load(){

        $data= array();
        //return view('calender');

        $calender_events = CalenderEvent::all();

        foreach($calender_events as $row)
        {
            $data[] = array(
                'id'   => $row["id"],
                'title'   => $row["title"],
                'start'   => $row["start"],
                'end'   => $row["end"],
                'color' =>$row['color']
            );
        }

        echo json_encode($data);

    }

    public function insert(Request $request){

        $calenderEvent = new CalenderEvent();

        $calenderEvent->title = $request->title;
        $calenderEvent->start = $request->start;
        $calenderEvent->end = $request->end;
        $calenderEvent->uid ="";

        $calenderEvent->save();

    }

    public function update(Request $request){

        //update.php

        $calender_events = CalenderEvent::findOrFail($request->id);
        $calender_events->update($request->all());


    }

    public function delete(Request $request){

        //delete.php

       // dd($request);

        $calender_events = CalenderEvent::find($request->id);

        $calender_events->delete();

    }

    public function showEventDetails(Request $request){

        $calender_events = CalenderEvent::find($request->id);
        $acceptedRequestsFd  = \App\Request::where('friend_id','=',Sentinel::getUser()->id)->where('approved',1)->get();
        $acceptedRequestsUs  = \App\Request::where('user_id','=',Sentinel::getUser()->id)->where('approved',1)->get();

        return view('calender.event_details',compact(['calender_events','acceptedRequestsFd','acceptedRequestsUs']));

    }


    public function saveCalenderEventsDetails(Request $request){




       $friendsIds =  $request->friendsIds;

       $calenderEvent = CalenderEvent::find($request->event_id);


        foreach ($friendsIds as $friendsId){

         //   dd($friendsId);
            $user =  User::find($friendsId);


            if($calenderEvent->users()->attach($user)){

                return "successfully added";

            }else{
                return "Already  Exist";

            }

       }


    }


}
