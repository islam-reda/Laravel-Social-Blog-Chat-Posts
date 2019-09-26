{{--@if(count($errors))--}}

    {{--<div class="alert alert-danger">--}}
        {{--<ul>--}}
            {{--@foreach($errors->all() as  $error)--}}
                {{--<li>{{$error}}</li>--}}

            {{--@endforeach--}}
        {{--</ul>--}}
    {{--</div>--}}


{{--@endif--}}




@if(session('error'))

    {{--style="display: none;"--}}
    <div class="alert alert-danger" >
          {{ session('error') }}
    </div>

@endif

@if(session('success'))

    {{--style="display: none;"--}}
    <div class="alert alert-success" >
        {{ session('success') }}
    </div>

@endif