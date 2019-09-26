<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 7/22/2018
 * Time: 10:58 AM
 */


?>
@extends('layouts.master')
@section('pageTitle', 'Tickets')
@section('content')

    <div class="col-sm-12 col-sm-offset-3 col-lg-10 col-lg-offset-2 main mainpostcontainer">
        <div id="main">
            <div class="row">
                <div class="col-sm-9">
                    <h2><b>Tickets</b></h2>
                </div>
                <div class="col-sm-3 align-top">
                    <h2>
                        <a href="{{ action('TicketController@create') }}"
                           class="btn btn-default" data-toggle="modal">
                            <span>Add New Ticket</span>
                        </a>
                    </h2>
                </div>
            </div>
            @foreach ($tickets as $key => $ticket)

                <article class="post">

                    <header>

                        <div class="title">
                            <h2><a href="tickets/{{$ticket->id}}/edit">{{$ticket->title}}</a></h2>

                            <p>{{$ticket->description}}</p>

                        </div>

                        <div class="meta">


                            <time class="published" datetime="2015-11-01">{{$ticket->created_at}}</time>
                            {{$ticket->statustb->name}}
                            <a href="#" class="author">
                                  <p>{{$ticket->areatb->name}}</p>
                            </a>
                            <a href="#" class="author"><span class="name">{{$ticket->user->first_name}} {{$ticket->user->last_name}}</span><img src="{{route('user.image',['filename' => $ticket->user->imagePath])}}" alt="{{$ticket->user->first_name}} "></a>
                        </div>
                    </header>


                    <h2>Comments</h2>

                    <form class="send_ticket" action="{{url('/ticket_comment')}}">

                        <div class="panel-footer">

                            <div class="input-group">

                                <input name="ticket_id" value="{{$ticket->id}}" id="" type="hidden">
                                <input name="content" id="btn-input" type="text"
                                       class="form-control input-md"
                                       placeholder="Type your comment here...">

                                <span class="input-group-btn">
                                    <input class="btn btn-primary btn-md"
                                           id="btn-chat" type="submit" value="Submit">
                                </span>

                            </div>
                        </div>
                    </form>

                    @foreach ($ticket->comments()->orderBy('created_at','desc')->get() as $key => $comment)
                        <div  class="comments comments_{{$comment->id}}" id="comments_{{$ticket->id}}">

                            <div class="meta">
                                <a href="#" class="author">

                                    <img src="{{route('user.image',['filename' => $comment->user_id->imagePath])}}"
                                         alt="{{$comment->user_id->first_name}} ">

                                    <span class="name">
                                        {{$comment->user_id->first_name}} {{$comment->user_id->last_name}}
                                    </span>

                                </a>
                                <p>  {{$comment->body}}</p>
                            </div>

                        </div>

                    @endforeach

                    <footer>

                        {{--<ul class="actions">--}}
                            {{--<li>--}}
                                {{--<a href="{{ action('PostsController@show',$post->id) }}" --}}
                                   {{--class="button big">read more...</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}

                        <ul class="stats">
                            <li><a href="#" class="icon fa-comment">{{$ticket->comments->count()}}</a></li>
                        </ul>

                    </footer>
                </article>
            @endforeach
        </div>
        <nav aria-label="Page navigation">
            {{ $tickets->links() }}
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
        var currentuser = <?php echo $current_user_id; ?>

        // $('.replies a.reply').click(function (event) {
        //     event.preventDefault();
        //     $(this).parent().find('.input-group').show(200);
        //     $(this).hide();
        // });
        //
        // $('.sendreply').submit(function (event) {
        //     event.preventDefault();
        //     var postData ={
        //         'body':$(this).find('input[name=body]').val(),
        //         'post_id':$(this).find('input[name=post_id]').val(),
        //         'comment_id':$(this).find('input[name=comment_id]').val(),
        //     };
        //     var url = $(this).attr('action');
        //     $.ajax({
        //         type:'POST',
        //         url: url,
        //         data: postData,
        //         success: function (response) {
        //             $('#input-reply').val("");
        //         },
        //         error: function (response) {
        //
        //         }
        //     });
        // });

        // $('.vote').submit(function (event) {
        //     event.preventDefault();
        //     var postData ={
        //         'option_id':$(this).find('input[name=vote]:checked').val(),
        //         'post_id':$(this).find('input[name=post_id]').val(),
        //     };
        //     var url = $(this).attr('action');
        //     $.ajax({
        //         type:'POST',
        //         url: url,
        //         data: postData,
        //         success: function (response) {
        //             $('#btn-vote').attr('value',"voted");
        //             $('#btn-vote').attr('disabled',true);
        //         },
        //         error: function (response) {
        //
        //         }
        //     });
        // });

        $('.send_ticket').submit(function (event) {
            event.preventDefault();
            var postData ={
                'content':$(this).find('input[name=content]').val(),
                'ticket_id':$(this).find('input[name=ticket_id]').val(),
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

        {{--function appendReply(data) {--}}
            {{--if(data){--}}
                {{--$('#input-reply_'+data.comment_id).val('');--}}
                {{--var html = '';--}}
                {{--html += '<div class="meta replies">';--}}
                {{--html += '<a href="#" class="author">';--}}
                {{--html += '<img src={{url('/')}}/userimage/'+data.person_photo+' alt="Tarek ">';--}}
                {{--html += '<span class="name">';--}}
                {{--html += data.person_name;--}}
                {{--html += '</span>';--}}
                {{--html += '</a>';--}}
                {{--html += '<p>'+data.body+'</p>';--}}
                {{--html += '</div>';--}}
                {{--$('.comments_'+data.comment_id).find('.meta .replies form').append(html);--}}
            {{--}--}}
        {{--}--}}

        function appendMessage(data) {
          console.log(data);

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
                if($('div').is('#comments_'+data.ticket_id+'')){
                    $('#comments_'+data.ticket_id+'').prepend(html);
                }else{
                    $('.send_ticket').append(html);
                }
            }
        }

        socket.on("person:ticketcomment",function (data) {
            console.log(data);
            appendMessage(data);
        });
    </script>

@endsection
