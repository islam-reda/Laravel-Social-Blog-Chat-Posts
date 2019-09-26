<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 7/22/2018
 * Time: 10:58 AM
 */


?>
@extends('layouts.master')
@section('pageTitle', 'Notification')
@section('content')
  <div class="col-sm-12 col-sm-offset-3 col-lg-10 col-lg-offset-2 main mainpostcontainer">
    <div id="main">
        <div class="row">
          <div class="col-sm-9">
						<h2>Notifications</h2>
					</div>
        </div>
        <div>
          @foreach ($notifications as $key => $notification)
              <div class="panel panel-default">
                <div class="panel-heading">  {{$notification->fromuser->first_name}} {{$notification->fromuser->last_name}}</div>
                <div class="panel-body">
                  @if($notification->message == 'reply')
                    {{'Replied to your comment'}}
                  @elseif ($notification->message == 'comment')
                    {{'Commented to your Post'}}
                  @else
                    {{'Message You'}}
                  @endif
                </div>
              </div>
          @endforeach
        </div>
      <nav aria-label="Page navigation">
        {{ $notifications->links() }}
      </nav>
    </div>
@stop
