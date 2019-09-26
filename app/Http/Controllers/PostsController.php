<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Admins as Admin;
use App\Posts as Post;
use Session;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','DESC')->paginate(2);
        $current_user_id = Sentinel::getUser()->id;
        return View('posts.index',compact('posts','current_user_id'));
    }

    public function create()
    {
        $data = array(
          'title' => 'Add Post',
          'method' => 'POST',
          'action' => "PostsController@store",
          'fields' => array(
              'title' => array(
                'type'=>'text',
                'title'=>'Name',
              ),
              'body' => array(
                'type'=>'text',
                'title'=>'Body',
              ),
              'path' => array(
                'type'=>'file',
                'title'=>'Image',
              ),
              'post_type' => array(
                'type'=>'select',
                'title'=>'Type',
                'options' => array(1=>'Normal',2=>'Poll'),
              ),
              'options' => array(
                'type'=>'post_options',
                'title'=>'Option',
              ),
              'status' => array(
                'type'=>'select',
                'title'=>'Status',
                'options' => array(1=>'Enable',2=>'Disable'),
              ),
          ),
        );
        return View('posts.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $realRequest = $request;
        $this->validate($request,[
          'title' => 'required',
          'body' => 'required',
          'status' => 'required',
          'path' => 'required',
        ]);
        $file = $request->file('path');
        $request = $request->all();
        $name = $file->getClientOriginalName();
        $file->move('images',$name);
        $request['user_id'] =  Sentinel::getUser()->id;
        $post = Post::create($request);
        $post->photos()->create(['path'=>$name]);

        foreach ($request['option'] as $value) {
          $post->options()->create(['name'=>$value]);
        }
        Session::flash('message','Post Added Successfully');
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $post = Post::find($id);
      return View('posts.view',compact('post'));
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
