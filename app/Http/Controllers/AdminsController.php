<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Admins;
use App\Roles;
use \Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
class AdminsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = array(
      'edit' => true,
      'delete' => true,
      'deletelink' => 'admins.destroy',
      'add' => true,
      'addlink' => 'AdminsController@create',
      'title' => 'Admins',
      'columns' => array(
        'email' => array(
          'title'=> 'Email',
        ),
        'name' => array(
          'title'=> 'Name',
        ),
        'imagePath' => array(
          'title'=> 'Image',
          'type'=> 'image',
          'secure'=> true,
        ),
        'active' => array(
          'title'=> 'Active',
        ),
      ),
      'key'=> (new Admins())->getKeyName(),
      'link'=> 'admins',
      'data' => Admins::orderBy('id','desc')->paginate(10),
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
        'title' => 'Add Admin',
        'method' => 'POST',
        'action' => "AdminsController@store",
        'fields' => array(
            'first_name' => array(
              'type'=>'text',
              'title'=>'First Name',
            ),
            'last_name' => array(
              'type'=>'text',
              'title'=>'Last Name',
            ),
            'email' => array(
              'type'=>'text',
              'title'=>'Email',
            ),
            'password' => array(
              'type'=>'password',
              'title'=>'Password',
            ),
            'imagePath' => array(
              'type'=>'file',
              'title'=>'Image',
              'secure'=>true,
            ),
            'user_level' => array(
              'type'=>'select',
              'title'=>'Role',
              'options'=>$this->roles(),
            ),
            'active' => array(
              'type'=>'select',
              'title'=>'Status',
              'options' => array(1=>'Enable',0=>'Disable'),
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
      $this->validate($request,[
        'active' => 'required',
        'email' => 'required',
        'password' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'imagePath' => 'required:file',
      ]);
      $file = $request->file('imagePath');
      $request = $request->all();

      if($file){
          $file_name  = 'user-'.$request['first_name'].'-'.$request['email'].'-'.$file->getClientOriginalName();
          Storage::disk('local')->put($file_name,File::get($file));
          $request['imagePath'] = $file_name;
      }
      Admins::create($request);
      Session::flash('message','Admin Added Successfully');
      return redirect('/admins');
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
   public function roles(){
     $roles = Roles::orderBy('g_name','desc')->get();
     $rolesOptions = array();
     foreach ($roles as $key => $role) {
       $rolesOptions[$role->level_id] = $role->g_name;
     }
     return $rolesOptions;
   }
  public function edit($id)
  {

    // var_dump(Brand::find($id)->news);die();
    $data = array(
      'title' => 'Update Admin',
      'method' => 'POST',
      'action' => "admins.update",
      'data' => Admins::find($id),
      'link'=> (new Admins)->getKeyName(),
      'fields' => array(
        'first_name' => array(
          'type'=>'text',
          'title'=>'First Name',
        ),
        'last_name' => array(
          'type'=>'text',
          'title'=>'Last Name',
        ),
        'email' => array(
          'type'=>'text',
          'title'=>'Email',
        ),
        'password' => array(
          'type'=>'password',
          'title'=>'Password',
        ),
        'imagePath' => array(
          'type'=>'file',
          'title'=>'Image',
          'secure'=>true,
        ),
        'user_level' => array(
          'type'=>'select',
          'title'=>'Role',
          'options'=>$this->roles(),
        ),
        'active' => array(
          'type'=>'select',
          'title'=>'Status',
          'options' => array(1=>'Enable',0=>'Disable'),
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
    $realRequest = $request;
    $file = $request->file('imagePath');
    $request = $request->all();
    if($file){
        $file_name  = 'user-'.$request['first_name'].'-'.$request['email'].'-'.$file->getClientOriginalName();
        Storage::disk('local')->put($file_name,File::get($file));
        $request['imagePath'] = $file_name;
    }
    $admin = Admins::find($id);
    $realRequest->session()->flash('message','Admin Updated Successfully');
    $admin->update($request);
    return redirect('admins');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $admin = Admins::find($id);
    $admin->delete();
    Session::flash('message','Admin Deleted Successfully');
    return redirect('admins');
  }
}
