<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 7/22/2018
 * Time: 10:58 AM
 */


?>
@extends('layouts.master')
@section('pageTitle', 'Posts')
@section('content')
  <div class="col-sm-12 col-sm-offset-3 col-lg-10 col-lg-offset-2 main mainpostcontainer">
    <div id="main">
          <article class="post">
            <header>
              <div class="title">
                <h2><a href="#">{{$post->title}}</a></h2>
                <p>{{$post->body}}</p>
              </div>
              <div class="meta">
                <time class="published" datetime="2015-11-01">{{$post->created_at}}</time>
                <a href="#" class="author"><span class="name">{{$post->author->first_name}} {{$post->author->last_name}}</span><img src="{{route('user.image',['filename' => $post->author->imagePath])}}" alt="{{$post->author->first_name}} "></a>
              </div>
            </header>
            <a href="#" class="image featured"><img  src="{{url($post->photos->first()->path)}}" height="200" alt=""></a>
              <h2>Comments</h2>
            <form id="send_comment">
              <div class="panel-footer">
                  <div class="input-group">
                      <input name="post_id" value="{{$post->id}}" id="" type="hidden">
                      <input name="content" id="btn-input" type="text" class="form-control input-md" placeholder="Type your comment here...">
                      <span class="input-group-btn">
                          <input class="btn btn-primary btn-md" id="btn-chat" type="submit" value="Submit">
                      </span>
                  </div>
              </div>
            </form>
            @foreach ($post->comments()->orderBy('created_at','desc')->get() as $key => $comment)
              <div class="comments" id="comments">
                <div class="meta">
                  <a href="#" class="author">

                    <img src="{{route('user.image',['filename' => $comment->user->imagePath])}}" alt="{{$comment->user->first_name}} ">
                    <span class="name">
                      {{$comment->user->first_name}} {{$comment->user->last_name}}
                    </span>
                  </a>
                  <p>  {{$comment->body}}</p>
                </div>
              </div>
            @endforeach
            <footer>
              <ul class="stats">
                <li><a href="#">General</a></li>
                <li><a href="#" class="icon fa-heart">28</a></li>
                <li><a href="#" class="icon fa-comment"><?php count($post->comments); ?></a></li>
              </ul>
            </footer>
          </article>
      </div>
    </div>
@stop


@section('script')
    <script type="text/javascript">
        var socket = io(':6003');
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#send_comment').submit(function (event) {
            event.preventDefault();
            var postData ={
                'content':$(this).find('input[name=content]').val(),
                'post_id':$(this).find('input[name=post_id]').val(),
            };
            $.ajax({
                type:'POST',
                url: 'http://192.168.1.107:8024/loyalityapp/public/comment',
                data: postData,
                success: function (response) {
                    $('#btn-input').val("");
                },
                error: function (response) {

                }
            });
        });
        function appendMessage(data) {
            if(data){
              var html = '';
                 html += '<div class="comments">';
                    html += '<div class="meta">';
                      html += '<a href="#" class="author">';
                        html += '<img src='+data.person_photo+' alt="Tarek ">';
                          html += '<span class="name">';
                            html += data.person_name;
                          html += '</span>';
                        html += '</a>';
                      html += '<p>'+data.body+'</p>';
                      html += '</div>';
                  html += '</div>';
              $('#comments').prepend(html);
            }
        }
        socket.on("person:comment",function (data) {
          console.log(data);
              appendMessage(data);

        });
    </script>

@endsection
