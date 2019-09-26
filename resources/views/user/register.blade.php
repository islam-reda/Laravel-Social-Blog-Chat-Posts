
{{--dsfs--}}
<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 7/22/2018
 * Time: 10:30 AM
 */

?>

@extends('layouts.master')


<br>

@section('content')


    <div class="row">

        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">

                    <form action="{{url('/')}}/register" method="POST">

                        @include('layouts.errors')

                        {{csrf_field()}}

                        <fieldset>

                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="">
                            </div>


                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                    <input type="text" name="password" class="form-control" placeholder="First Name">


                                </div>

                            </div>

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name">

                                </div>

                            </div>

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                                    <input type="password" name="password" class="form-control"
                                           placeholder="Password">

                                </div>

                            </div>

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="Password Confirmation">

                                </div>

                            </div>


                            <input type="submit" value="Register" class="btn btn-primary"/>

                        </fieldset>

                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

@endsection