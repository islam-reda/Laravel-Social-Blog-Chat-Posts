<div class="modal" id="myModal" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <form id="save">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Title: {{$calender_events->title}}</h4>
            </div>

            <div class="modal-body">

                <p>From:</p> {{Carbon\Carbon::parse($calender_events->start)->format('d M, Y')}}

                <br>
                <br>

                <p>To:</p> {{Carbon\Carbon::parse($calender_events->end)->format('d M, Y')}}
                <br>
                <br>

                <p>Add Guests:</p>


                <input type="text" value="{{$calender_events->id}}" name="event_id" hidden>

                <select id="e2" class="js-example-basic-multiple form-control"
                        name="friendsIds[]" multiple="multiple">

                    @foreach( $acceptedRequestsFd as $acceptedRequest)
                        <?php
                        $user = \App\User::find($acceptedRequest->user_id);
                        $name = $user->first_name.' '.$user->last_name;
                        $photo = $user->imagePath;
                        ?>

                        <option value="{{$acceptedRequest->user_id}}">{{$name}}</option>

                    @endforeach

                        @foreach( $acceptedRequestsUs as $acceptedRequest)

                            <?php
                            $user = \App\User::find($acceptedRequest->friend_id);
                            $name = $user->first_name.' '.$user->last_name;
                            $photo = $user->imagePath;
                            ?>

                            <option value="{{$acceptedRequest->friend_id}}">{{$name}}</option>

                        @endforeach

                    {{--<option value="AL">Alabama</option>--}}
                    {{--<option value="WY">Wyoming</option>--}}
                </select>

            </div>

            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" />
                <button id="delete" type="button" class="btn btn-danger">Delete</button>
                <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

            </form>
        </div>

</div>


</div>

<script>

    $(document).ready(function() {

        $('.js-example-basic-multiple').select2();

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        <?php $id =  $calender_events->id ?>;

        var id  = <?php echo $id ?>

        var calendar = $('#calendar');
        $('#delete').on('click',function() {
                $.ajax({
                    url: "delete_calender_events",
                    type: "POST",
                    data: {id: id},
                    success: function (data) {
                        //alert(data);
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Removed");

                        $("#close").click();
                    }
                })

            }
        );

        //var selectdata =  $("#e2").val();


        $('#save').on('submit',function(event) {
            event.preventDefault();

            $.ajax({
                    url: "save_calender_events_details",
                    type: "POST",
                    data:  $(this).closest('form').serialize(),
                    success: function (data) {
                        //alert(data);

                       // console.log(data);
                       // calendar.fullCalendar('refetchEvents');
                      alert("dd");

                      //  $("#close").click();
                    }
                })
            }
        );


    });




</script>