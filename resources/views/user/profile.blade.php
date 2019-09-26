<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 7/31/2018
 * Time: 3:30 PM
 */

@extends('layouts.master')

<style type="text/css">

    .profile-img {

        max-width: 150px;
        border: 5px solid #fff;
        border-radius: 100%;
        box-shadow: 0 2px 2px rgba(0,0,0,0.3);
    <!--   -->
    }

</style>

@section('content')

    <div class="row">

        <div class="col-lg-6 col-lg-offset-3">

            <div class="panel panel-default">

                <div class="panel-body text-center">
                    <img src="http://www.lovemarks.com/wp-content/uploads/profile-avatars/default-avatar-knives-ninja.png"
                         alt="" class="profile-img">
                    <h1>{{$user->name}}</h1>
                    <h5>{{$user->email}}</h5>
                    {{--<h5>{{$user->dob}}({{ Carbon\Carbon::createFromFormat('Y-m-d',$user->dob)->age }} years old)</h5>--}}

                    {{--<h5>{{$user->dob->format('l j F y')}} ({{  $user->dob->age }} years old )</h5>--}}

                    <h5>{{$user->dob->format('l j F y')}} ({{  $user->dob->age }} years old )</h5>

                    <button class="btn btn-success">Follow</button>
                </div>

            </div>

        </div>


    </div>

@endsection