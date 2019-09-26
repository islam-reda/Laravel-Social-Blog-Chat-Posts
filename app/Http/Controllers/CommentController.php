<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Events\CommentEvent;
use App\Events\ReplyEvent;
use App\Events\NotificationEvent;
use App\Comments;
use App\Posts;
use App\Notification;
use App\Replies as Reply;
use App\PostVote as Vote;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
class CommentController extends Controller
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
    public function comment(Request $request)
    {
      $this->validate($request,[
        'content' => 'required',
        'post_id' => 'required',
      ]);
      $comment =  Comments::create([
        'body'=>$request->content,
        'user_id' => Sentinel::getUser()->id,
        'post_id'=>$request->post_id
      ]);
      $notification = Notification::create([
        'from_user_id' => Sentinel::getUser()->id,
        'to_user_id' => $comment->post->user_id,
        'message' => 'comment',
        'is_read' => false,
      ]);
       event(new CommentEvent($comment));
       event(new NotificationEvent($notification));
       return redirect('/');
    }
    public function reply(Request $request)
    {
      $this->validate($request,[
        'body' => 'required',
        'post_id' => 'required',
        'comment_id' => 'required',
      ]);
      $reply =  Reply::create([
        'body'=>$request->body,
        'user_id' => Sentinel::getUser()->id,
        'comment_id'=>$request->comment_id,
      ]);
      $notification = Notification::create([
        'from_user_id' => Sentinel::getUser()->id,
        'to_user_id' => $reply->comment->user_id,
        'message' => 'reply',
        'is_read' => false,
      ]);
       event(new ReplyEvent($reply));
       event(new NotificationEvent($notification));
       return redirect('/');
    }

    public function vote(Request $request)
    {
      $vote = Vote::where('vote_user_id',Sentinel::getUser()->id)->where('post_id',$request->post_id)->first();
      if(!$vote){
        $vote =  Vote::create([
          'option_id'=>$request->option_id,
          'vote_user_id' => Sentinel::getUser()->id,
          'post_id'=>$request->post_id,
          'status'=>1,
        ]);
        return 'true';
      }
      return 'dublicate';

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
