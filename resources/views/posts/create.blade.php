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
              <form class="form-horizontal" action="{{ action($data['action']) }}" enctype="multipart/form-data" method="{{$data['method']}}">
                  {{ csrf_field() }}
                  <fieldset>
                      @foreach ($data['fields'] as $name => $field)
                        @if ($field['type'] == 'select')
                            <div class="form-group">
                              <label class="col-md-3 " for="{{$name}}">{{$field['title']}}</label>
                              <div class="col-md-9">
                                <select class="form-control" name="{{$name}}" id="{{$name}}">
                                  @foreach ($field['options'] as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                        @elseif ($field['type'] == 'post_options')
                          <div class="form-group" id="option" style="display:none">
                            <label class="col-md-3 " for="{{$name}}">Add Option</label>
                            <div class="options col-md-12 form-group">
                                <div class="col-md-5">
                                    <input id="{{$name}}" value="{{ old($name) }}" name="option[]" type="{{$field['type']}}" placeholder="Your {{$field['title']}}" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <span class="addoption btn" onclick="add(this)">Add option</span>
                                </div>
                                <div class="col-md-2">
                                    <span class="deleteoption btn" onclick="deletde(this)">Delete option</span>
                                  </div>
                            </div>
                          </div>
                        @else
                          <div class="form-group">
                              <label class="col-md-3 " for="{{$name}}">{{$field['title']}}</label>
                              <div class="col-md-9 option">
                                  <input id="{{$name}}" value="{{ old($name) }}" name="{{$name}}" type="{{$field['type']}}" placeholder="Your {{$field['title']}}" class="form-control">
                              </div>
                          </div>
                        @endif
                      @endforeach
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
  <script>
      function add(self){
        var html = '';
        html += '<div class="options form-group col-md-12">';
          html += jQuery(self).parents('.options').html();
        html += '</div>';
        jQuery(self).parents('.options').parent().append(html);
      };

      function deletde(self){
        jQuery(self).parents('.options').remove();
      }
      $(document).ready(function(){
          $("select[name=post_type]").change(function(){
            var value = $(this).find('option:selected').val();
            if(value == 2){
              $('#option').show(100);
            }else{
              $('#option').hide(100);
            }
          });
      });
  </script>
@endsection
