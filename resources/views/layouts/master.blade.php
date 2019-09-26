<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 7/22/2018
 * Time: 10:30 AM
 */

?>
        <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Loyality App - @yield('pageTitle')</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/datepicker3.css')}}" rel="stylesheet">
    <link href="{{asset('css/styles.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">



    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />

    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>--}}

    {{--<script src="{{asset('js/bootstrap.min.js')}}"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    @yield('style')


</head>
<body>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>

            <a class="navbar-brand" href="{{url('/')}}"><span>Loyality</span>Admin</a>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                       <em class="fa fa-bell"></em>  {{--<span class="label label-danger">15</span> --}}
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="all-button"><a href="{{url('notifications')}}">
                                    <em class="fa fa-inbox"></em> <strong>All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                {{-- <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <em class="fa fa-bell"></em><span class="label label-info">5</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li><a href="#">
                                <div><em class="fa fa-envelope"></em> 1 New Message
                                    <span class="pull-right text-muted small">3 mins ago</span></div>
                            </a></li>
                        <li class="divider"></li>
                        <li><a href="#">
                                <div><em class="fa fa-heart"></em> 12 New Likes
                                    <span class="pull-right text-muted small">4 mins ago</span></div>
                            </a></li>
                        <li class="divider"></li>
                        <li><a href="#">
                                <div><em class="fa fa-user"></em> 5 New Followers
                                    <span class="pull-right text-muted small">4 mins ago</span></div>
                            </a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

    <div class="profile-sidebar">
        <div class="profile-userpic">

            @if(Storage::disk('local')->has(Sentinel::getUser()->first_name.'-'.Sentinel::getUser()->id. '.jpg'))

                {{--<img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">--}}
                <a href="">
                <img src="{{route('user.image',['filename' => Sentinel::getUser()->first_name.'-'.Sentinel::getUser()->id.'.jpg'])}}"
                       class="avatar" alt="Avatar" style="width:10%;height: 40px; width: 40px;">
                </a>
            @endif

        </div>
        <div class="profile-usertitle">

            <div class="profile-usertitle-name">{{Sentinel::getUser()->first_name }}
            </div>


            <div class="profile-usertitle-status">
                <span class="indicator label-success"></span>
                Online
            </div>

        </div>

        <div class="clear"></div>
    </div>

    <div class="divider"></div>

    <form role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>

    <ul class="nav menu">
        <li><a href="{{url('/')}}/index"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>

        <li><a href="{{url('/')}}/admins"><em class="fa fa-user-circle-o">&nbsp;</em> Users</a></li>
        <li><a href="{{url('/')}}/brands"><em class="fa fa-modx">&nbsp;</em>Brands</a></li>
        <li><a href="{{url('/')}}/brandnews"><em class="fa fa-toggle-off">&nbsp;</em> Brand News</a></li>
        <li><a href="{{url('/')}}/customers"><em class="fa fa-users">&nbsp;</em> Customers </a></li>
        <li><a href="{{url('/')}}/tickets"><em class="fa fa-tasks">&nbsp;</em> Tickets </a></li>
        <li><a href="{{url('/')}}/posts"><em class="fa fa-newspaper-o">&nbsp;</em> Posts </a></li>
        <li class="parent ">
            <a data-toggle="collapse" href="#sub-item-1">
                <em class="fa fa-navicon"></em> Promotions
                <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right">
                    <em class="fa fa-plus"></em></span>
            </a>

            <ul class="children collapse" id="sub-item-1">
                <li>
                    <a class="" href="{{url('/')}}/vouchers">
                        <span class="fa fa-arrow-right">&nbsp;</span>
                        Vouchers
                    </a>
                </li>
                <li>
                    <a class="" href="{{url('/')}}/stores">
                        <span class="fa fa-arrow-right">&nbsp;</span>
                        Stores

                    </a></li>
                <li>
                    <a class="" href="#">
                        <span class="fa fa-arrow-right">&nbsp;</span> Sub Item 3
                    </a>
                </li>
            </ul>
        </li>

        <li><a href="{{url('/')}}/calender"><em class="fa fa-calendar">&nbsp;</em> Calender</a></li>

        <li><a href="{{url('/')}}/logout"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>

    </ul>
</div><!--/.sidebar-->
<div>
<div class="col-sm-12 col-sm-offset-3 col-lg-10 col-lg-offset-2 headeralertsnotification">

</div>

</div>

@yield('content')

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}


{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>--}}


{{--<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>--}}

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
<script src="{{asset('js/bootstrap.min.js')}}"></script>

<script src="{{asset('js/chart.min.js')}}"></script>

<script src="{{asset('js/chart-data.js')}}"></script>

<script src="{{asset('js/easypiechart.js')}}"></script>

<script src="{{asset('js/easypiechart-data.js')}}"></script>

<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>

<script src="{{asset('js/custom.js')}}"></script>

{{--<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>--}}

<script src="{{asset('js/socket.io-1.4.5.js')}}"> </script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

{{--///////////////////--}}


{{--<script src="{{asset('js/custom.js')}}"></script>--}}

{{--<script src="https://code.jquery.com/jquery-3.3.1.min.js"--}}
        {{--integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="--}}
        {{--crossorigin="anonymous">--}}
{{--</script>--}}

<script>
    window.onload = function () {
        var chart1 = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(chart1).Line(lineChartData, {
            responsive: true,
            scaleLineColor: "rgba(0,0,0,.2)",
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleFontColor: "#c5c7cc"
        });
    };

</script>

@yield('script')

<!--[if lt IE 9]>
<!--<script src="js/html5shiv.js"></script>-->
<!--<script src="js/respond.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>-->

{{--<![endif]-->--}}


</body>
</html>
