<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 7/22/2018
 * Time: 10:58 AM
 */


?>
@extends('layouts.master')
@section('pageTitle', $data['title'])
@section('content')
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
      <div class="row">
          <ol class="breadcrumb">
              <li><a href="#">
                      <em class="fa fa-home"></em>
                  </a></li>
              <li class="active">{{$data['title']}}</li>
          </ol>
      </div><!--/.row-->

      <div class="panel panel-default">
          <div class="panel-heading">
            {{$data['title']}}
              <span class="pull-right clickable panel-toggle panel-button-tab-left">
                <em class="fa fa-toggle-up"></em>
              </span>
          </div>
          @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
          @endif
          @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <div class="panel-body">
              <form class="form-horizontal" action="{{ URL::route($data['action'],$data['data']->$data['link'])  }}" enctype="multipart/form-data" method="{{$data['method']}}">
                  {{ csrf_field() }}
                  <input name="_method" type="hidden" value="PUT">
                  <fieldset>
                      @foreach ($data['fields'] as $name => $field)
                          @if ($field['type'] == 'select')
                            <div class="form-group">
                              <label class="col-md-3 " for="{{$name}}">{{$field['title']}}</label>
                              <div class="col-md-9">

                                <select class="form-control" name="{{$name}}" id="{{$name}}">
                                  @foreach ($field['options'] as $key => $value)
                                    @php($selected = '')
                                    @if($data['data']->$name == $key)
                                      <?php $selected = 'selected'; ?>
                                    @endif
                                    <option {{$selected}} value="{{$key}}">{{$value}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                        @elseif($field['type'] == 'file')
                          <div class="form-group">
                              <label class="col-md-3 " for="{{$name}}">{{$field['title']}}</label>
                              <div class="col-md-6">
                                  <input id="{{$name}}" value="{{$data['data']->$name}}" name="{{$name}}" type="{{$field['type']}}" placeholder="Your {{$field['title']}}" class="form-control">
                              </div>
                              <div class="col-md-3">
                                @if(isset($field['secure']))
                                  <a href="{{route('user.image',['filename' => $data['data']->$name])}}"><img src="{{route('user.image',['filename' => $data['data']->$name])}}" class="center-block" height="100"></a>
                                @else
                                  <a href="{{url($data['data']->$name)}}"><img src="{{url($data['data']->$name)}}" class="center-block" height="100"></a>
                                @endif
                              </div>
                          </div>
                        @else
                          <div class="form-group">
                              <label class="col-md-3 " for="{{$name}}">{{$field['title']}}</label>
                              <div class="col-md-9">
                                  <input id="{{$name}}" value="{{$data['data']->$name}}" name="{{$name}}" type="{{$field['type']}}" placeholder="Your {{$field['title']}}" class="form-control">
                              </div>
                          </div>
                        @endif
                      @endforeach
                      @if (isset($data['is_map']))
                        <div class="form-group form-group-lg">
                          <label class="col-md-3">Click On Map choose location</label>
                            <div class="col-sm-9 col-md-6">
                                  @include('map.index')
                            </div>
                        </div>
                      @endif
                      <!-- Form actions -->
                      <div class="form-group">
                          <div class="col-md-12 widget-right">
                              <button type="submit" class="btn btn-default btn-md pull-right">Submit</button>
                          </div>
                      </div>
                  </fieldset>
              </form>
          </div>
      </div>
  </div>	<!--/.main-->

@stop
@section('script')
  @if(isset($data['depends']))
      <?php $dependsarrayjson = json_encode($data['depends']); ?>
      <script>
          jQuery(document).ready(function($){
            var jsonarray = <?php echo $dependsarrayjson; ?>;
            var dependsarray = eval(jsonarray);
              $.each(dependsarray, function(key, item) {
                  $("select[name="+key+"]").change(function(){
                        if($(this).val() == item.when_value){
                            if ( $("input[name="+item.show+"]").is(':visible') ){

                              $("input[name="+item.show+"]").parent().parent().show(200);

                            }else{

                              $("input[name="+item.show+"]").parent().parent().hide(200);

                            }

                            if ( $("input[name="+item.hide+"]").is(':visible') ){

                              $("input[name="+item.hide+"]").parent().parent().hide(200);

                            }else{

                              $("input[name="+item.hide+"]").parent().parent().show(200);
                            }
                            $("input[name="+item.toggle+"]").parent().parent().toggle();
                        }
                  });
              });
          });
      </script>
  @endif
@stop
