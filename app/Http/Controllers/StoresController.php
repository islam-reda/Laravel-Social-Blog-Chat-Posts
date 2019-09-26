<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Stores;
use App\Brand;
use \Session;
class StoresController extends Controller
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
        'deletelink' => 'stores.destroy',
        'add' => true,
        'addlink' => 'StoresController@create',
        'title' => 'Stores',
        'columns' => array(
          'store_code' => array(
            'title'=> 'Code',
          ),
          'store_name' => array(
            'title'=> 'Name',
          ),
          'store_region' => array(
            'title'=> 'Region',
          ),
          'store_addr1' => array(
            'title'=> 'Address',
          ),
          'active' => array(
            'title'=> 'Active',
          ),
        ),
        'key'=> (new Stores)->getKeyName(),
        'link'=> 'stores',
        'data' => Stores::orderBy('store_no','desc')->paginate(10),
      );
      return View('base.index',compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function brands(){
      $brands = Brand::where('active',1)->get();
      $brandsOptions = array();
      foreach ($brands as $key => $brand) {
        $brandsOptions[$brand->brand_id] = $brand->brand_name;
      }
      return $brandsOptions;
    }
    public function create()
    {

        $data = array(
          'title' => 'Add Stores',
          'method' => 'POST',
          'action' => "StoresController@store",
          'is_map' => true,
          'fields' => array(
              'brand_id' => array(
                'type'=>'select',
                'title'=>'Brand',
                'options'=> $this->brands(),
              ),
              'store_code' => array(
                'type'=>'text',
                'title'=>'Code',
              ),
              'store_name' => array(
                'type'=>'text',
                'title'=>'Name',
              ),
              'store_loc_lat' => array(
                'type'=>'text',
                'title'=>'Lat',
              ),
              'store_loc_lon' => array(
                'type'=>'text',
                'title'=>'Long',
              ),
              'store_region' => array(
                'type'=>'text',
                'title'=>'Region',
              ),
              'store_addr1' => array(
                'type'=>'text',
                'title'=>'Address',
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
        $this->validate($request,[
          'brand_id' => 'required',
          'store_code' => 'required',
          'store_name' => 'required',
          'store_loc_lat' => 'required',
          'store_loc_lon' => 'required',
          'store_region' => 'required',
          'store_addr1' => 'required',
          'active' => 'required',
        ]);
        $realRequest = $request;
        Stores::create($request->all());
        Session::flash('message','Stores Added Successfully');
        return redirect('/stores');
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
        'title' => 'Update Store',
        'method' => 'POST',
        'action' => "stores.update",
        'is_map' => true,
        'data' => Stores::find($id),
        'link'=> (new Stores)->getKeyName(),
        'fields' => array(
          'brand_id' => array(
            'type'=>'select',
            'title'=>'Brand',
            'options'=> $this->brands(),
          ),
          'store_code' => array(
            'type'=>'text',
            'title'=>'Code',
          ),
          'store_name' => array(
            'type'=>'text',
            'title'=>'Name',
          ),
          'store_loc_lat' => array(
            'type'=>'text',
            'title'=>'Lat',
          ),
          'store_loc_lon' => array(
            'type'=>'text',
            'title'=>'Long',
          ),
          'store_region' => array(
            'type'=>'text',
            'title'=>'Region',
          ),
          'store_addr1' => array(
            'type'=>'text',
            'title'=>'Address',
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
      $realRequest = $request;

      $store = Stores::find($id);
      $realRequest->session()->flash('message','Store Updated Successfully');
      $store->update($request->all());
      return redirect('stores');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $store = Stores::find($id);
      $store->delete();
      Session::flash('message','Store Deleted Successfully');
      return redirect('stores');
    }
}
