@extends('layouts.master')

    @section('style')

    <title>Jquery Fullcalandar Integration with PHP and Mysql</title>
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>--}}

    <script src="{{asset('js/fullcalendar.min.js')}}"></script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable:true,
                header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,agendaWeek,agendaDay',
                },
                events: 'load_calender_events',
                selectable:true,
                selectHelper:true,
                select: function(start, end, allDay)
                {
                    var title = prompt("Enter Event Title");
                    if(title)
                    {
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                        $.ajax({
                            //insert_calender_events
                            url:"insert_calender_events",
                            type:"POST",
                            data:{title:title, start:start, end:end},
                            success:function()
                            {
                                calendar.fullCalendar('refetchEvents');
                                alert("Added Successfully");
                            }
                        })
                    }
                },

                editable:true,
                eventResize:function(event)
                {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url:"update_calender_events",
                        type:"POST",
                        data:{title:title, start:start, end:end, id:id},
                        success:function(){
                            calendar.fullCalendar('refetchEvents');
                            alert('Event Update');
                        }
                    })
                },

                eventDrop:function(event)
                {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url:"update_calender_events",
                        type:"POST",
                        data:{title:title, start:start, end:end, id:id},
                        success:function()
                        {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated");
                        }
                    });
                },

                eventClick:function(event)
                {
                    // if(confirm("Are you sure you want to remove it?"))
                     //{
                        var id = event.id;
                        $.ajax({
                            url:"show_event_details",
                            type:"Get",
                            data:{id:id},
                            success:function(res)
                            {
                                console.log(res);

                                //$( "#btn" ).click();

                                $('#event-details').html('');
                                $('#event-details').append(res);
                                $("#mybutton").click();
                                calendar.fullCalendar('refetchEvents');
                               // alert("Event Removed");
                            }
                        })
                    //}
                },

            });


           // $value = $('.fc-content .fc-time').text();
           // console.log("dfdd");
           // console.log($value);

        });


    </script>

        @endsection
<br />

@section('content')


<div  style="padding: 20px">

    <h2 align="center"><a href="#">Jquery Fullcalandar Integration with PHP and Mysql</a>

    </h2>

    <button style="display: none" type="button" id="mybutton" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" hidden>Open Modal</button>

    <div id="event-details" class="container">


    {{--<h2>Modal Example</h2>--}}
    <!-- Trigger the modal with a button -->

    <!-- Modal -->
    {{--<div class="modal fade" id="myModal" role="dialog">--}}
        {{--<div class="modal-dialog">--}}

            {{--<!-- Modal content-->--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<p>Some text in the modal.</p>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}

</div>

<br />
<div id="calendar">

</div>

<div class="container">
</div>

</div>
@endsection