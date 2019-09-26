<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 7/22/2018
 * Time: 11:17 AM
 */
?>

@extends('layouts.master')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">

            <li>
                <a href="#">
                    <em class="fa fa-home"></em>
                </a>
            </li>

            <li class="active">Dashboard</li>

        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">

            <h1 class="page-header">Dashboard</h1>

        </div>
    </div><!--/.row-->

    <div class="panel panel-container">
        <div class="row">
            <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                <div class="panel panel-teal panel-widget border-right">
                    <div class="row no-padding"><em class="fa fa-xl fa-shopping-cart color-blue"></em>
                        <div class="large">120</div>
                        <div class="text-muted">New Orders</div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                <div class="panel panel-blue panel-widget border-right">
                    <div class="row no-padding"><em class="fa fa-xl fa-comments color-orange"></em>
                        <div class="large">52</div>
                        <div class="text-muted">Comments</div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                <div class="panel panel-orange panel-widget border-right">
                    <div class="row no-padding"><em class="fa fa-xl fa-users color-teal"></em>
                        <div class="large">24</div>
                        <div class="text-muted">New Users</div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                <div class="panel panel-red panel-widget ">
                    <div class="row no-padding"><em class="fa fa-xl fa-search color-red"></em>
                        <div class="large">25.2k</div>
                        <div class="text-muted">Page Views</div>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Site Traffic Overview
                    <ul class="pull-right panel-settings panel-button-tab-right">
                        <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-cogs"></em>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <ul class="dropdown-settings">
                                        <li><a href="#">
                                                <em class="fa fa-cog"></em> Settings 1
                                            </a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">
                                                <em class="fa fa-cog"></em> Settings 2
                                            </a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">
                                                <em class="fa fa-cog"></em> Settings 3
                                            </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <span class="pull-right clickable panel-toggle panel-button-tab-left">
                        <em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div class="canvas-wrapper">
                        <canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>New Orders</h4>
                    <div class="easypiechart" id="easypiechart-blue" data-percent="92" ><span class="percent">92%</span></div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>Comments</h4>
                    <div class="easypiechart" id="easypiechart-orange" data-percent="65" >
                        <span class="percent">65%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>New Users</h4>
                    <div class="easypiechart" id="easypiechart-teal" data-percent="56" >

                        <span class="percent">56%</span>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>Visitors</h4>
                    <div class="easypiechart" id="easypiechart-red" data-percent="27" ><span class="percent">27%</span></div>
                </div>
            </div>
        </div>
    </div><!--/.row-->
    <div class="row">
      @include('dashboard/posts')
        <?php $logged_in_user = Sentinel::getUser()->id;?>
        <div class="col-md-6">
            <div id="chat" class="panel panel-default chat">

                <div class="panel-heading">

                    <dev id="subchat">Chat</dev>

                    <ul class="pull-right panel-settings panel-button-tab-right">
                        <li class="dropdown">
                            <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-users"></em>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <ul class="selected-user-to-send-1 dropdown-settings">

                                    @foreach( $acceptedRequestsFd as $acceptedRequest)
                                            <?php
                                            $user = \App\User::find($acceptedRequest->user_id);
                                            $name = $user->first_name.' '.$user->last_name;
                                            $photo = $user->imagePath;
                                            ?>
                                            <li class="selected-user-to-send-1">
                                                <a href="javascript:send_message('{{$name}}',{{$acceptedRequest->user_id}})" >
                                                    <em class="fa fa-cog"></em>
                                                    {{$name}}
                                                </a>
                                            </li>

                                            <li class="divider"></li>

                                    @endforeach

                                    @foreach( $acceptedRequestsUs as $acceptedRequest)

                                        <?php
                                        $user = \App\User::find($acceptedRequest->friend_id);
                                        $name = $user->first_name.' '.$user->last_name;
                                        $photo = $user->imagePath;
                                        ?>

                                        <li>
                                            <a href="javascript:send_message('{{$name}}',{{$acceptedRequest->friend_id}})">
                                                <em class="fa fa-cog"></em> {{$name}}
                                            </a>
                                        </li>

                                        <li class="divider"></li>

                                    @endforeach

                                    </ul>
                                 </li>
                            </ul>
                        </li>
                    </ul>
                    <span class="pull-right clickable panel-toggle panel-button-tab-left">
                        <em class="fa fa-toggle-up"></em></span>
                </div>

                <div id="scrolldown" class="panel-body">

                    <ul class="chat1">


                        {{--<li class="left clearfix">--}}
                            {{--<span class="chat-img pull-left">--}}
								{{--<img src="http://placehold.it/60/30a5ff/fff" alt="User Avatar" class="img-circle" />--}}
                            {{--</span>--}}

                            {{--<div class="chat-body clearfix">--}}
                                {{--<div class="header">--}}
                                    {{--<strong class="primary-font">John Doe</strong>--}}
                                    {{--<small class="text-muted">32 mins ago</small>--}}
                                {{--</div>--}}

                                {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.--}}
                                    {{--Nulla ante turpis, rutrum ut ullamcorper sed, dapibus ac nunc.--}}
                                {{--</p>--}}
                            {{--</div>--}}

                        {{--</li>--}}

                        {{--@foreach($messages as $message)--}}

                            {{--<li class="left clearfix"><span class="chat-img pull-left">--}}

                                    {{--<img src="{{route('user.image',['filename' => $message->imagePath])}}"--}}
                                         {{--alt="User Avatar" class="img-circle" height="60" width="60"/>--}}
                                    {{--</span>--}}
                                {{--<div id="div1" class="chat-body clearfix">--}}

                                    {{--<div id="div2" class="header">--}}


                                        {{--<strong class="primary-font">{{ $message->author }}</strong>--}}
                                        {{--<small id="small" onload="timer();" id="time" class="text-muted">--}}
                                            {{--{{ Carbon\Carbon::parse($message->created_at)->diffForHumans()}}--}}
                                        {{--</small>--}}
                                    {{--</div>--}}
                                    {{--<p>{{  $message->content }}</p>--}}
                                {{--</div>--}}
                            {{--</li>--}}

                        {{--@endforeach--}}

                        Please Select Friend To Chat With.

                    </ul>
                </div>

                <form id="send-message">

                    <div class="panel-footer">

                        <div class="input-group">

                            <input type="hidden" id="to_user_id_value" name="to_user_id_value" value="" />
                            <input name="content" id="btn-input" type="text" class="form-control input-md"
                                   placeholder="Type your message here..." />

                            {{ csrf_field() }}

                            <span class="input-group-btn">

                                    {{--<button >Send 2</button>--}}

                                {{--<p id="time_span">3</p>--}}
                                <input class="btn btn-primary btn-md" id="btn-chat" type="submit" value="Submit">

                            </span>

                        </div>
                    </div>

                </form>

            </div>


        </div><!--/.col-->
        <div class="col-md-6">
          <div class="panel panel-default">

              <div class="panel-heading">
                  To-do List
                  <ul class="pull-right panel-settings panel-button-tab-right">

                      <li class="dropdown">

                          <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                              <em class="fa fa-cogs"></em>
                          </a>

                          <ul class="dropdown-menu dropdown-menu-right">
                              <li>
                                  <ul class="dropdown-settings">
                                      <li><a href="#">
                                              <em class="fa fa-cog"></em> Settings 1
                                          </a></li>
                                      <li class="divider"></li>
                                      <li><a href="#">
                                              <em class="fa fa-cog"></em> Settings 2
                                          </a></li>
                                      <li class="divider"></li>
                                      <li><a href="#">
                                              <em class="fa fa-cog"></em> Settings 3
                                          </a></li>
                                  </ul>
                              </li>
                          </ul>
                      </li>

                  </ul>

                  <span class="pull-right clickable panel-toggle panel-button-tab-left">
                      <em class="fa fa-toggle-up"></em></span></div>

              <div class="panel-body">

                  <ul class="todo-list">
                      <li class="todo-list-item">
                          <div class="checkbox">
                              <input type="checkbox" id="checkbox-1" />
                              <label for="checkbox-1">Make coffee</label>
                          </div>
                          <div class="pull-right action-buttons"><a href="#" class="trash">
                                  <em class="fa fa-trash"></em>
                              </a></div>
                      </li>
                      <li class="todo-list-item">
                          <div class="checkbox">
                              <input type="checkbox" id="checkbox-2" />
                              <label for="checkbox-2">Check emails</label>
                          </div>
                          <div class="pull-right action-buttons"><a href="#" class="trash">
                                  <em class="fa fa-trash"></em>
                              </a></div>
                      </li>
                      <li class="todo-list-item">
                          <div class="checkbox">
                              <input type="checkbox" id="checkbox-3" />
                              <label for="checkbox-3">Reply to Jane</label>
                          </div>
                          <div class="pull-right action-buttons"><a href="#" class="trash">
                                  <em class="fa fa-trash"></em>
                              </a></div>
                      </li>
                      <li class="todo-list-item">
                          <div class="checkbox">
                              <input type="checkbox" id="checkbox-4" />
                              <label for="checkbox-4">Make more coffee</label>
                          </div>
                          <div class="pull-right action-buttons"><a href="#" class="trash">
                                  <em class="fa fa-trash"></em>
                              </a></div>
                      </li>
                      <li class="todo-list-item">
                          <div class="checkbox">
                              <input type="checkbox" id="checkbox-5" />
                              <label for="checkbox-5">Work on the new design</label>
                          </div>
                          <div class="pull-right action-buttons"><a href="#" class="trash">
                                  <em class="fa fa-trash"></em>
                              </a></div>
                      </li>
                      <li class="todo-list-item">
                          <div class="checkbox">
                              <input type="checkbox" id="checkbox-6" />
                              <label for="checkbox-6">Get feedback on design</label>
                          </div>
                          <div class="pull-right action-buttons"><a href="#" class="trash">
                                  <em class="fa fa-trash"></em>
                              </a></div>
                      </li>
                  </ul>
              </div>
              <div class="panel-footer">
                  <div class="input-group">
                      <input id="btn-input" type="text" class="form-control input-md" placeholder="Add new task" /><span class="input-group-btn">
              <button class="btn btn-primary btn-md" id="btn-todo">Add</button>
          </span></div>
              </div>
          </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    Friends

                    <ul class="pull-right panel-settings panel-button-tab-right">

                        <li class="dropdown">

                            <a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-cogs"></em>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>

                                    <ul class="dropdown-settings">
                                        <li>
                                            <a id = "d" href="#">
                                                <em class="fa fa-cog"></em>
                                                Settings 1
                                            </a>
                                        </li>

                                        <li class="divider"></li>
                                        <li>
                                            <a href="#">
                                                <em class="fa fa-cog"></em>
                                                Settings 2
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#">
                                                <em class="fa fa-cog"></em>

                                                Settings 3
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <span class="pull-right clickable panel-toggle panel-button-tab-left">

                        <em class="fa fa-toggle-up"></em>

                    </span>

                </div>

                <div class="panel-body timeline-container">

                    <ul class="timeline">

                        @foreach($requests as $request)

                        <?php
                            $user = \App\User::find($request->friend_id);
                            $name = $user->first_name.' '.$user->last_name;
                            $photo = $user->imagePath;
                           ?>
                            @if($request->approved == 0)

                                    <li>
                                        <div class="timeline-badge">
                                            <img src="{{url('/')}}/userimage/{{$photo}}" alt="{{$name}}" width = '46' height ='46' class="img-circle" />

                                        </div>

                                        <div class="timeline-panel">
                                            <div class="timeline-body">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">
                                                        <?php
                                                        //$user = \App\User::find($request->friend_id);
                                                       // $name = $user->first_name.' '.$user->last_name;
                                                        ?>
                                                        {{$name}}
                                                    </h4>

                                                </div>

                                                <button class="btn btn-primary btn-md">
                                                    waiting for approval
                                                </button>

                                            </div>
                                        </div>

                                    </li>
                                @elseif($request->approved == 1)
                                    <li>
                                        <div class="timeline-badge">
                                            <img src="{{url('/')}}/userimage/{{$photo}}" alt="{{$name}}"
                                                 width = '46' height ='46' class="img-circle" />

                                        </div>

                                        <div class="timeline-panel">

                                            <div class="timeline-body">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">
                                                        {{$name}}
                                                    </h4>
                                                </div>

                                                <button class="btn btn-primary btn-md">
                                                    Approved
                                                </button>

                                            </div>
                                        </div>
                                    </li>
                            @endif
                        @endforeach

                                @foreach($users as $user)
                                    <?php

                                $request = \App\Request::where('friend_id', '=',Sentinel::getUser()->id)
                                    ->where('user_id', '=',$user->id)
                                    ->first();


                                $user = \App\User::find($user->id);
                                $name = $user->first_name.' '.$user->last_name;
                                $photo = $user->imagePath;

                                ?>

                                @if(count($request) <= 0)
                                    <li>
                                        <div class="timeline-badge">

                                            <img src="{{url('/')}}/userimage/{{$photo}}" alt="{{$name}}" width = '46' height ='46' class="img-circle" />
                                        </div>

                                        <div class="timeline-panel">
                                            <div class="timeline-body">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">{{$user->first_name}} {{$user->last_name}}</h4>
                                                </div>
                                                <div class="send-request" friend_id="{{$user->id}}">
                                                    <button class="btn btn-primary btn-md">
                                                        Add Friend
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                 @endif

                            @endforeach
                    </ul>
                </div>
            </div>
        </div><!--/.col-->

       {{ count($friendRequests)}}

        @if(count($friendRequests) != 0 )


        <div class="col-md-6">

            <div class="panel panel-default ">

                <div class="panel-heading">

                    Friend Requests

                    <ul class="pull-right panel-settings panel-button-tab-right">

                        <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-cogs"></em>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>

                                    <ul class="dropdown-settings">
                                        <li><a href="#">
                                                <em class="fa fa-cog"></em> Settings 1
                                            </a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">
                                                <em class="fa fa-cog"></em> Settings 2
                                            </a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">
                                                <em class="fa fa-cog"></em> Settings 3
                                            </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <span class="pull-right clickable panel-toggle panel-button-tab-left">
                        <em class="fa fa-toggle-up"></em>
                    </span>

                </div>
                <div class="panel-body timeline-container">
                    @foreach($friendRequests as $friendRequest)
                        @include('requests.sent-requests')
                    @endforeach
                </div>
            </div>
        </div><!--/.col-->

        @endif

        <div class="col-sm-12">

            <p class="back-link">Loyality Theme by <a href="http://dejavu.shoes">Dejavu</a></p>

        </div>

    </div><!--/.row-->

</div>	<!--/.main-->

@endsection


@section('script')

    <?php
    $messages_array = json_encode($messages);

    ?>

    <script>

        var value = null;

        var $messages_array = <?php echo $messages_array; ?>;

        value = $(this).find('option:selected').val();
        $( "#to_user_id_value" ).val(0);
        $( "#to_user_id" ).change(function () {

            value = $(this).find('option:selected').val();

            $( "#to_user_id_value" ).val( value );
        });

    </script>
    <script src="{{asset('js/socket.io-1.4.5.js')}}"> </script>

    <script type="text/javascript">


        var socket = io(':6003');

        // $('form').on('submit',function () {
        //
        //     var text = $('textarea').val(), msg = {message : text};
        //
        //     socket.send(msg);
        //
        //     appendMessage(msg);
        //
        //     $('textarea').val('');
        //
        //     return false;
        //
        // });
        //

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        ////////////////////////////////

        $('.send-request .btn').click(function (event) {

            event.preventDefault();

            var friend_id = $(this).parent().attr('friend_id');

            //var friend_id = $(this).parent().attr('user_id');

            //alert(friend_id);

            var poatData ={
                'friend_id':friend_id,
            };

            $.ajax({
                type:'POST',
                url: '{{url('/')}}/request',
                data: poatData,
                success: function (response) {

                    $('.send-request[friend_id = '+friend_id+']').html('Request Sent');
                    //console.log(response.return.poatData);
                    //window.location.href = response.redirect
                },
                error: function (response) {
                    //console.log(response);
                    //$('.alert-danger').text(response.responseJSON.error);
                    //$('.alert-danger').show();
                }
            });
        });


        $('.accept-friend-request .btn').click(function (event) {

            event.preventDefault();

            var friend_id = $(this).parent().attr('friend_id');
            var user_id = $(this).parent().attr('user_id');

            //var friend_id = $(this).parent().attr('user_id');
            //alert(friend_id);

            var poatData ={
                'friend_id':friend_id,
                'user_id':user_id,

            };

            $.ajax({
                type:'POST',
                url: '{{url('/')}}/accept-friend-request',
                data: poatData,
                success: function (response) {

                    $('.accept-friend-request[user_id = '+user_id+']').html('You are friends now');
                    //console.log(response.return.poatData);
                    //window.location.href = response.redirect
                },
                error: function (response) {
                    //$('.alert-danger').text(response.responseJSON.error);
                    //$('.alert-danger').show();

                }
            });
        });

        //////////////////////////////

        $('#send-message').submit(function (event) {
            event.preventDefault();
            //console.log($('#to_users_id :selected').val());

            if(value == null){

                alert("please select someone to chat with!!")
                return false;
            }

            //alert("message");
            var poatData ={
                'content':$('input[name=content]').val(),
                'to_users_id':value,
            };

            $.ajax({
                type:'POST',
                url: '{{url('/')}}/chat',
                data: poatData,
                success: function (response) {

                    $('#btn-input').val("");

                    //console.log(response.return.content);
                    //window.location.href = response.redirect

                {{--<div class="send-request" friend_id="{{$user->id}}">--}}
                        {{--<button class="btn btn-primary btn-md">--}}
                        {{--Add Friend--}}
                    {{--</button>--}}
                    {{--</div>--}}
                },
                error: function (response) {
                    //console.log(response);
                    //$('.alert-danger').text(response.responseJSON.error);
                    //$('.alert-danger').show();
                }
            });
        });



        // Append Message
        function appendMessage(data) {

            let created_at = data.created_at;

            var created_at_date = new Date(created_at);

            //console.log(typeof dt);

            var currentDate = new Date();

            var diffDays = created_at_date.getDate() - currentDate.getDate();

            //alert(diffDays);

            if(diffDays === 0){
                var s = "Now";
            }

            //var end   = moment([2007, 0, 10]);
            //end.from(start);       // "in 5 days"
            //end.from(start, true);


            $('.chat1').append(
                $('<li/>').attr("class", "left").append(
                    $('<span/>')
                        .attr('class','chat-img pull-left')
                        .html(
                            '<img  src="{{url('/')}}/userimage/' +
                            data.imagePath +
                            '" alt="User Avatar" class="img-circle" height="60" width="60"/>'
                        ),
                    $('<div/>').attr("class", "chat-body clearfix").append(
                        $('<div/>').attr("class","header").append(
                            $('<strong/>').attr('class','primary-font').text(data.author),
                            $('<small/>').attr('class','text-muted').append('</small>').text(s)
                        ),
                        $('<p/>').text(data.content)
                    )
                )
            );

            $("#scrolldown").animate({
                scrollTop: $('#scrolldown')[0].scrollHeight - $('#scrolldown')[0].clientHeight
            }, 0);

            //window.scrollBy(0,180);

        }

        var logged_in_user = <?php echo $logged_in_user ; ?>;

       // console.log(logged_in_user);

        socket.on("chat:message",function (data) {


           // console.log(value);
           //  console.log("////////////////");

            //alert(friend_id);

            if(data) {
                $messages_array.push(data);

                console.log(data.to_users_id);


                 if( (data.from_user_id == logged_in_user && data.to_users_id == value)

                 || (data.from_user_id == value && data.to_users_id == logged_in_user)
                 ){

                     //alert(value);
                     appendMessage(data);

                 }
            }

        });

        //var el = document.getElementById('time');

        //////////////////////////////////////////////////////

        // setInterval

        setInterval(function() {

            //let counter= 0;
            //counter++;

            var items = [];

            $('.chat1 li').each(function (i, e) {

                //console.log(e);
                //console.log(i);

                items.push( $(e).find('.chat-body .header .text-muted').text() );

                var d = $(e).find('.chat-body .header .text-muted').text();

                //var str = "Now";

                var res = d.split(" ");

                if(res[1] ==='minutes' || res[1] ==='minute' || res[1] ==='mins'){

                    //alert(res[1]);

                    var f = res[0];

                    f =Number(f)+1;

                    //console.log(f);

                    if(res[0] === "59"){

                        $(e).find('.chat-body .header .text-muted').text("1 hour ago");

                    }else {

                        $(e).find('.chat-body .header .text-muted').text(f + " minutes ago");

                    }

                }else if(d === 'Now'){

                    $(e).find('.chat-body .header .text-muted').text("1 minute ago");
                }

            });

            //console.log(items);

            // var currentTime = new Date(),
            //     hours = currentTime.getHours(),
            //     minutes = currentTime.getMinutes(),
            //     sec = currentTime.getSeconds()
            //     ampm = hours > 11 ? 'PM' : 'AM';
            //
            // hours += hours < 10 ? '0' : '';
            // minutes += minutes < 10 ? '0' : '';
            //
            //
            //
            // if(diffDays === 0){
            //    // document.getElementById('time');
            //
            //     var diffDays = dt.getDate() - date1.getDate();
            //
            //     console.log(value);
            //
            //
            // }

            //var value = $('#time').val();

            //el.innerHTML = hours + ":" + minutes +":"+sec+" " + ampm;

        }, 60000);

        // end of setInterval

        $('#to_user_id').on('change', function(event) {

            $('.chat1').html("");
            for (i = 0; i < $messages_array.length; i++) {

                //console.log($messages_array);

                if( ( $messages_array[i]['from_user_id']  == logged_in_user && $messages_array[i]['to_users_id'] == this.value)

                    || ($messages_array[i]['from_user_id']  == this.value && $messages_array[i]['to_users_id']  == logged_in_user)
                ) {

                    //$("#period").val("From " + $messages_array[i]['period_fdate'] + " To " + array_code[i]['period_tdate']);

                    let created_at = $messages_array[i]['created_at'] ;

                    var created_at_date = new Date(created_at);

                    //console.log(typeof dt);

                    var currentDate = new Date();

                    var diffDays = created_at_date.getDate() - currentDate.getDate();

                    //alert(diffDays);

                    if(diffDays === 0){
                        var s = "Now";
                    }

                    //$('.chat1').val("");

                    $('.chat1').append(
                        $('<li/>').attr("class", "left").append(
                            $('<span/>')
                                .attr('class','chat-img pull-left')
                                .html(
                                    '<img  src="{{url('/')}}/userimage/' + $messages_array[i]['imagePath']
                                    +
                                    '" alt="User Avatar" class="img-circle" height="60" width="60"/>'
                                ),
                            $('<div/>').attr("class", "chat-body clearfix").append(
                                $('<div/>').attr("class","header").append(
                                    $('<strong/>').attr('class','primary-font').text($messages_array[i]['author'] ),
                                    $('<small/>').attr('class','text-muted').append('</small>').text(s)
                                ),
                                $('<p/>').text($messages_array[i]['content'])
                            )
                        )
                    );
                }
            }

            //console.log($messages_array);
            // alert('d');

        });

        $( ".selected-user-to-send-1 selected-user-to-send-2 a" ).each(function(index) {
            $(this).on("click", function(){
                // For the boolean value
                var boolKey = $(this).data('selected');
                // For the mammal value
                var mammalKey = $(this).attr('id');
            });
        });

        function send_message(name,id){
            value = id;

            console.log(name);

            $('#subchat').text(name);

            $('.chat1').html("");
            for (i = 0; i < $messages_array.length; i++) {

                //console.log($messages_array);

                if( ( $messages_array[i]['from_user_id']  == logged_in_user && $messages_array[i]['to_users_id'] == id)

                    || ($messages_array[i]['from_user_id']  == id && $messages_array[i]['to_users_id']  == logged_in_user)
                ) {

                    //$("#period").val("From " + $messages_array[i]['period_fdate'] + " To " + array_code[i]['period_tdate']);

                    let created_at = $messages_array[i]['created_at'] ;

                    var created_at_date = new Date(created_at);

                    //console.log(typeof dt);

                    var currentDate = new Date();

                    var diffDays = created_at_date.getDate() - currentDate.getDate();

                    //alert(diffDays);

                    if(diffDays === 0){
                        var s = "Now";
                    }

                    //$('.chat1').val("");

                    $('.chat1').append(
                        $('<li/>').attr("class", "left").append(
                            $('<span/>')
                                .attr('class','chat-img pull-left')
                                .html(
                                    '<img  src="{{url('/')}}/userimage/' + $messages_array[i]['imagePath']
                                    +
                                    '" alt="User Avatar" class="img-circle" height="60" width="60"/>'
                                ),
                            $('<div/>').attr("class", "chat-body clearfix").append(
                                $('<div/>').attr("class","header").append(
                                    $('<strong/>').attr('class','primary-font').text($messages_array[i]['author'] ),
                                    $('<small/>').attr('class','text-muted').append('</small>').text(s)
                                ),
                                $('<p/>').text($messages_array[i]['content'])
                            )
                        )
                    );
                }
            }

            //console.log($messages_array);

            // alert('d');
        }

    </script>

@endsection

{{--<li class="left clearfix">--}}
    {{--<span class="chat-img pull-left">--}}
        {{--<img src="http://placehold.it/60/30a5ff/fff" alt="User Avatar" class="img-circle" />--}}
    {{--</span>--}}

    {{--<div class="chat-body clearfix">--}}

        {{--<div class="header">--}}
            {{--<strong class="primary-font">{{ $message->author }}</strong>--}}
            {{--<small class="text-muted">32 mins ago</small>--}}

        {{--</div>--}}

        {{--<p>{{  $message->content }}</p>--}}

    {{--</div>--}}
{{--</li>--}}
