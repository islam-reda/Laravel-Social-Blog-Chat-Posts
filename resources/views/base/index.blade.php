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

      <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-9">
          						<h2>Manage <b>{{$data['title']}}</b></h2>
          					</div>
                    @if ($data['add'])
                        <div class="col-sm-3 align-top">
                          <h2>
                            <a href="{{ action($data['addlink']) }}" class="btn btn-default" data-toggle="modal"><span>Add New {{$data['title']}}</span></a>
                          </h2>
                        </div>
                    @endif
                    @if (isset($data['export']))
                      <div class="col-sm-3 align-top">
                        <h2>
                          <a href="{{ action($data['export']) }}" class="btn btn-default" data-toggle="modal"><span>Export</span></a>
                        </h2>
                      </div>
                    @endif
                    @if (isset($data['import']))
                      <div class="col-sm-3 align-top">
                        <form  action="{{ action($data['import']) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="file" name="import_file" />
                          <button class="btn btn-default">Import File</button>
                        </form>
                      </div>
                    @endif

                </div>
            </div>
            @if(Session::has('message'))
              <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif
            <table class="table table-striped table-hover">
                <thead>
                  <tr>
                        @foreach ($data['columns'] as $name => $value)
                          	<th>{{$value['title']}}</th>
                        @endforeach
                    </tr>
                </thead>
              <tbody>
                @foreach ($data['data'] as $key => $column)
                  <tr>
                    @foreach ($data['columns'] as $name => $options)

                      @if (isset($options['type']) == 'image')
                          @if(isset($options['secure']))
                            <td><img src="{{route('user.image',['filename' => $column->$name])}}" height="50"></td>
                          @else
                            <td><img src="{{url($column->$name)}}" height="50"></td>
                          @endif

                      @else
                        <td>{{$column->$name}}</td>
                      @endif

                    @endforeach
                    <td>
                        @if ($data['edit'])
                          <a href="{{$data['link']}}/{{$column->$data['key']}}/edit" class="add" ><i class="fa fa-edit"> Edit</i></a>
                        @endif
                        @if ($data['delete'])
                          <form action="{{ URL::route($data['deletelink'],$column->$data['key']) }}" method="POST">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <a href="#" onclick="$(this).closest('form').submit()" class="add" >
                                  <i class="fa fa-trash"> Delete</i>
                              </a>
                          </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
          </table>
          <nav aria-label="Page navigation">
            {{ $data['data']->links() }}
          </nav>
        </div>
    </div>
  </div>	<!--/.main-->
@stop
