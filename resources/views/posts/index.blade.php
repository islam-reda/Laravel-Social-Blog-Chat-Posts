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
      <div class="row">
          <div class="col-sm-9">
						<h2>Posts <b>& Tickets</b></h2>
					</div>
          <div class="col-sm-3 align-top">
            <h2>
              <a href="{{ action('PostsController@create') }}" class="btn btn-default" data-toggle="modal"><span>Add New Post</span></a>
            </h2>
          </div>
        </div>
        @foreach ($posts as $key => $post)
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
            @if ($post->post_type == 2)

              <form class="vote" action="{{url('/vote')}}">
                <input name="post_id" value="{{$post->id}}" id="" type="hidden">
                <div class="panel-footer">
                  <?php $is_voted_user = false ?>
                  <?php $option_id = ''; ?>
                  @foreach ($post->options as $key => $option)
                    @foreach ($post->votes as $key => $vote)
                      @if ($vote->vote_user_id == $current_user_id)
                        <?php $is_voted_user = true ?>
                        <?php $option_id = $vote->option_id ?>
                        <input type="hidden" name="vote_id" value="{{$vote->id}}">
                      @endif
                    @endforeach
                    <div class="radio">
                      <label><input type="radio" name="vote" value="{{$option->id}}" <?php echo ($option_id == $option->id) ? 'checked': '' ?>>{{$option->name}} {{$option->votes->count()}} </label>
                    </div>
                  @endforeach
                </div>
                @if(!$is_voted_user)
                  <input class="btn btn-primary btn-md" id="btn-vote" type="submit" value="Vote">
                @else
                @endif
              </form>
            @endif
            @if (isset($post->photos->first()->path))
              <a href="#" class="image featured"><img src="{{url($post->photos->first()->path)}}" height="200" alt=""></a>
            @endif
              <h2>Comments</h2>
            <form class="send_comment" action="{{url('/comment')}}">
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
            @foreach ($post->comments()->orderBy('created_at','desc')->paginate(5) as $key => $comment)
              <div  class="comments comments_{{$comment->id}}" id="comments_{{$post->id}}">
                <div class="meta">
                  <a href="#" class="author">
                    <img src="{{route('user.image',['filename' => $comment->user->imagePath])}}" alt="{{$comment->user->first_name}} ">
                    <span class="name">
                      {{$comment->user->first_name}} {{$comment->user->last_name}}
                    </span>
                  </a>
                  <p>  {{$comment->body}}</p>
                  <div class="replies">
                    <form class="sendreply" action="{{url('/reply')}}">
                      <div class="panel-footer">
                          <div class="input-group" style="display:none">
                              <input name="post_id" value="{{$post->id}}" id="" type="hidden">
                              <input name="comment_id" value="{{$comment->id}}" id="" type="hidden">

                              <input name="body" id="input-reply_{{$comment->id}}"
                                     type="text" class="form-control input-md"
                                     placeholder="Type your Reply here...">

                              <span class="input-group-btn">
                                  <input class="btn btn-primary btn-md" id="btn-reply" type="submit" value="Submit">
                              </span>
                          </div>
                          <a class="reply" href="#">
                            Reply
                          </a>
                      </div>
                    </form>
                    @foreach ($comment->replies()->orderBy('created_at','desc')->get() as $key => $reply)
                    <div class="meta replies">
                      <a href="#" class="author">
                        <img src="{{route('user.image',['filename' => $reply->user->imagePath])}}" alt="{{$reply->user->first_name}} ">
                        <span class="name">
                          {{$reply->user->first_name}} {{$reply->user->last_name}}
                        </span>
                      </a>
                      <p>  {{$reply->body}}</p>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
            <footer>
              <ul class="actions">
                <li><a href="{{ action('PostsController@show',$post->id) }}" class="button big">read more...</a></li>
              </ul>
              <ul class="stats">
                <li><a href="#">{{$post->types->name}}</a></li>
                <li><a href="#" class="icon fa-comment">{{$post->comments->count()}}</a></li>
              </ul>
            </footer>
          </article>
        @endforeach
      </div>
      <nav aria-label="Page navigation">
        {{ $posts->links() }}
      </nav>
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
        var currentuser = <?php echo $current_user_id; ?>;
        $('.replies a.reply').click(function (event) {
          event.preventDefault();
          $(this).parent().find('.input-group').show(200);
          $(this).hide();
        });
        $('.sendreply').submit(function (event) {
          event.preventDefault();
          var postData ={
              'body':$(this).find('input[name=body]').val(),
              'post_id':$(this).find('input[name=post_id]').val(),
              'comment_id':$(this).find('input[name=comment_id]').val(),
          };
          var url = $(this).attr('action');
          $.ajax({
              type:'POST',
              url: url,
              data: postData,
              success: function (response) {
                  $('#input-reply').val("");
              },
              error: function (response) {

              }
          });
        });
        $('.vote').submit(function (event) {
            event.preventDefault();
            var postData ={
                'option_id':$(this).find('input[name=vote]:checked').val(),
                'post_id':$(this).find('input[name=post_id]').val(),
            };
            var url = $(this).attr('action');
            $.ajax({
                type:'POST',
                url: url,
                data: postData,
                success: function (response) {
                  $('#btn-vote').attr('value',"voted");
                    $('#btn-vote').attr('disabled',true);
                },
                error: function (response) {

                }
            });
        });
        $('.send_comment').submit(function (event) {
            event.preventDefault();
            var postData ={
                'content':$(this).find('input[name=content]').val(),
                'post_id':$(this).find('input[name=post_id]').val(),
            };
            var url = $(this).attr('action');
            $.ajax({
                type:'POST',
                url: url,
                data: postData,
                success: function (response) {
                    $('#btn-input').val("");
                },
                error: function (response) {

                }
            });
        });
        function appendReply(data) {
            if(data){
              $('#input-reply_'+data.comment_id).val('');
              var html = '';
              html += '<div class="meta replies">';
                html += '<a href="#" class="author">';
                  html += '<img src={{url('/')}}/userimage/'+data.person_photo+' alt="Tarek ">';
                    html += '<span class="name">';
                      html += data.person_name;
                    html += '</span>';
                  html += '</a>';
                html += '<p>'+data.body+'</p>';
                html += '</div>';
              $('.comments_'+data.comment_id).find('.meta .replies form').append(html);
            }
        }
        function appendMessage(data) {
            if(data){
              var html = '';
                 html += '<div class="comments">';
                    html += '<div class="meta">';
                      html += '<a href="#" class="author">';
                        html += '<img src={{url('/')}}/userimage/'+data.person_photo+' alt="Tarek ">';
                          html += '<span class="name">';
                            html += data.person_name;
                          html += '</span>';
                        html += '</a>';
                      html += '<p>'+data.body+'</p>';
                      html += '</div>';
                  html += '</div>';
                  if($('div').is('#comments_'+data.post_id+'')){
                    $('#comments_'+data.post_id+'').prepend(html);
                  }else{
                    $('.send_comment').append(html);
                  }
            }
        }
        socket.on("person:comment",function (data) {
              appendMessage(data);
        });
        socket.on("person:reply",function (data) {
              appendReply(data);
        });
        socket.on("person:notification",function (data) {
          if(data){
            if(data.from_user_id != data.to_user_id && data.to_user_id == currentuser){
              var html = '';
               html += '<h5>';
                  html += ' <div class="alert alert-info alert-dismissible fade in">';
                    html += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    html += data.message;
                    html += '<strong> '+data.name+'</strong>';
                    html += '</div>';
                html += '</h5>';
              $('.headeralertsnotification').append(html);
            }
          }
        });
    </script>



@endsection
