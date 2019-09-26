<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Brand;
use Carbon\Carbon;
use Validator;
use Session;
class BrandsController extends Controller
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
          'deletelink' => 'brands.destroy',
          'add' => true,
          'addlink' => 'BrandsController@create',
          'title' => 'Brands',
          'columns' => array(
            'brand_name' => array(
              'title'=> 'Brand Name',
            ),
            'brand_logofile' => array(
              'title'=> 'Logo',
              'type'=> 'image',
            ),
            'activation_code' => array(
              'title'=> 'Code',
            ),
            'active' => array(
              'title'=> 'Active',
            ),
          ),
          'key'=> (new Brand)->getKeyName(),
          'link'=> 'brands',
          'data' => Brand::where('active',1)->orderBy('created_date','desc')->paginate(10),
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
          'title' => 'Add Brand',
          'method' => 'POST',
          'action' => "BrandsController@store",
          'fields' => array(
              'brand_name' => array(
                'type'=>'text',
                'title'=>'Name',
              ),
              'brand_logofile' => array(
                'type'=>'file',
                'title'=>'Logo',
              ),
              'activation_code' => array(
                'type'=>'text',
                'title'=>'Activation Code',
              ),
              'active' => array(
                'type'=>'select',
                'title'=>'Status',
                'options' => array(1=>'Enable',2=>'Disable'),
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
        $realRequest = $request;
        $this->validate($request,[
          'active' => 'required',
          'brand_logofile' => 'required',
          'activation_code' => 'required',
          'brand_name' => 'required',
        ]);
        $file = $request->file('brand_logofile');
        $request = $request->all();
        $request['created_date'] = Carbon::now(new \DateTimeZone('Africa/Cairo'))->toDateTimeString();
        $name = $file->getClientOriginalName();
        $file->move('images',$name);
        $request['brand_logofile'] =  $name;
        $realRequest->session()->flash('message','Brand Added Successfully');
        Brand::create($request);
        return redirect('/brands');
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

      // var_dump(Brand::find($id)->news);die();
      $data = array(
        'title' => 'Update Brand',
        'method' => 'POST',
        'action' => "brands.update",
        'data' => Brand::find($id),
        'link'=> (new Brand)->getKeyName(),
        'fields' => array(
            'brand_name' => array(
              'type'=>'text',
              'title'=>'Name',
            ),
            'brand_logofile' => array(
              'type'=>'file',
              'title'=>'Logo',
            ),
            'activation_code' => array(
              'type'=>'text',
              'title'=>'Activation Code',
            ),
            'active' => array(
              'type'=>'select',
              'title'=>'Status',
              'options' => array(1=>'Enable',2=>'Disable'),
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

      $file = $request->file('brand_logofile');
      $request->session()->flash('message','Brand Updated Successfully');
      $request = $request->all();
      if($file){
          $name = $file->getClientOriginalName();
          $file->move('images',$name);
          $request['brand_logofile'] =  $name;
      }

      $brand = Brand::find($id);
      $brand->update($request);
      return redirect('brands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $brand = Brand::find($id);
      $brand->delete();
      Session::flash('message','Brand Deleted Successfully');
      return redirect('brands');
    }
}
