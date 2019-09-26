<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
          'edit' => false,
          'delete' => true,
          'deletelink' => 'users.destroy',
          'add' => true,
          'addlink' => 'AdminController@create',
          'title' => 'Users',
          'data' => array(),
        );
        return View('base.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
          'title' => 'Add User',
          'method' => 'POST',
          'action' => "AdminController@store",
          'fields' => array(
              'name' => array(
                'type'=>'text',
                'title'=>'Name',
              ),
              'title' => array(
                'type'=>'text',
                'title'=>'Title',
              ),
              'File' => array(
                'type'=>'file',
                'title'=>'Image',
              ),
              'status' => array(
                'type'=>'select',
                'title'=>'Status',
                'options' => array(1=>'Hello',2=>'Bye bye'),
              ),
          ),
        );
        return View('base.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = array(
        'title' => 'Add User',
        'method' => 'POST',
        'action' => "AdminController@store",
        'fields' => array(
            'name' => array(
              'type'=>'text',
              'title'=>'Name',
            ),
            'title' => array(
              'type'=>'text',
              'title'=>'Title',
            ),
            'File' => array(
              'type'=>'file',
              'title'=>'Image',
            ),
            'status' => array(
              'type'=>'select',
              'title'=>'Status',
              'options' => array(1=>'Hello',2=>'Bye bye'),
            ),
        ),
      );
      return View('base.update',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
