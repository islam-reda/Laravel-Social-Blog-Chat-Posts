<ul class="timeline">

                 <?php
                   $user = \App\User::find($friendRequest->user_id);
                    $name = $user->first_name.' '.$user->last_name;
                    $photo = $user->imagePath;

                    ?>
                    <li>
                        <div class="timeline-badge">

                            <img src="{{url('/')}}/userimage/{{$photo}}" alt="{{$name}}" width = '46' height ='46' class="img-circle" />
                        </div>

                        <div class="timeline-panel">
                            <div class="timeline-body">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">{{$user->first_name}} {{$user->last_name}}</h4>
                                </div>
                                <div class="accept-friend-request" user_id="{{$user->id}}" friend_id="{{$friendRequest->friend_id}}">
                                    <button class="btn btn-primary btn-md">
                                        Accept Friend Request
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>

</ul>


