<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Events\NewMessageEvent;
use App\Message;
use App\User;
use App\Request as req;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{


    public function getIndex()
    {

        $messages = Message::all();

        $requests = \App\Request::where('user_id', '=',Sentinel::getUser()->id)->get();

        $requestsFd = \App\Request::where('friend_id', '=',Sentinel::getUser()->id)
            ->where('friend_id', '=',Sentinel::getUser()->id)
            ->get();

        $friendsids = array();

        foreach ($requests as $request){

            $friendsids[] = $request->friend_id;
        }

        $users = array();

        $users = User::where('id', '!=', Sentinel::getUser()->id)->whereNotIn('id', $friendsids)->get();

        //Friend Requests
        $current_user_id = Sentinel::getUser()->id;
        $friendRequests = \App\Request::where('friend_id','=',Sentinel::getUser()->id)->where('approved',0)->get();

        $acceptedRequestsFd  = \App\Request::where('friend_id','=',Sentinel::getUser()->id)->where('approved',1)->get();

        $acceptedRequestsUs  = \App\Request::where('user_id','=',Sentinel::getUser()->id)->where('approved',1)->get();

        $notifications  = \App\Notification::where('to_user_id','=',Sentinel::getUser()->id)->where('is_read',0)->orderBy('created_at','desc')->paginate(4);
        return view(
            'index',
            compact(['messages','users','requests','friendRequests','acceptedRequestsFd','acceptedRequestsUs','current_user_id','notifications'])
        );
    }

    public function postMessage(Request $request)
    {

       //dd($request->all());


        $imagePath = Sentinel::getUser()->first_name . '-' . Sentinel::getUser()->id . '.jpg';

        //Sentinel::getUser()->first_name;

        //dd(Sentinel::getUser()->id);

    $message = Message::create([
        'content' => $request->content,
        'author' => Sentinel::getUser()->first_name,
        'from_user_id' => Sentinel::getUser()->id,
        'to_users_id' => $request->to_users_id,
        'imagePath' => $imagePath,
    ]);


    //$message->author = Sentinel::getUser()->id;

    //Message::create($request->all());

    event(new NewMessageEvent($message));

        return redirect('/');

        //return redirect()->back();

        //return response()->json(['return' => $message]);

    }

    public function postFriendRequest(Request $request)
    {

        $friendRequests1 = DB::table('requests')
                ->where('user_id',Sentinel::getUser()->id)
                ->where('friend_id',$request->friend_id)->first();


        if ($friendRequests1) {

            return "Duplicated Row.";
        }

        \App\Request::create([
                'friend_id' => $request->friend_id,
                'user_id' => Sentinel::getUser()->id,
                'approved' => 0,
        ]);


        //dd($request);

        return redirect('/');

    }

    //postAcceptFriendRequest

    public function postAcceptFriendRequest(Request $request)
    {

        // update demo
        //$login = (new App\Login)->find(10);
        //$login->username ='updated_username';
        //$login->save();

        $friendRequests1 = \App\Request::where('user_id',$request->user_id)
            ->where('friend_id',Sentinel::getUser()->id)->first();


        $friendRequests1->approved = 1;
        $friendRequests1->save();

        return redirect('/');

    }

}
