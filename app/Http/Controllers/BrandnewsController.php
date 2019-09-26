<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Brand;
use App\BrandNews;
use Validator;
use Session;
use Carbon\Carbon;
class BrandnewsController extends Controller
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
          'deletelink' => 'brandnews.destroy',
          'add' => true,
          'addlink' => 'BrandnewsController@create',
          'title' => 'Brand News',
          'columns' => array(
            'brand_id' => array(
              'title'=> 'Brand',
            ),
            'ad_title' => array(
              'title'=> 'Title',
            ),
            'ad_desc1' => array(
              'title'=> 'Description',
            ),
            'start_date' => array(
              'title'=> 'From',
            ),
            'end_date' => array(
              'title'=> 'To',
            ),
            'active' => array(
              'title'=> 'Active',
            ),
          ),
          'key'=> (new BrandNews)->getKeyName(),
          'link'=> 'brandnews',
          'data' => BrandNews::where('active',1)->orderBy('ad_id','desc')->paginate(10),
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
          'title' => 'Add Brand News',
          'method' => 'POST',
          'action' => "BrandnewsController@store",
          'fields' => array(
              'brand_id' => array(
                'type'=>'select',
                'title'=>'Brand',
                'options'=> $this->brands(),
              ),
              'ad_title' => array(
                'type'=>'text',
                'title'=>'Title',
              ),
              'ad_desc1' => array(
                'type'=>'text',
                'title'=>'Description',
              ),
              'start_date' => array(
                'type'=>'date',
                'title'=>'From',
              ),
              'end_date' => array(
                'type'=>'date',
                'title'=>'To',
              ),
              'ad_img1' => array(
                'type'=>'file',
                'title'=>'Image 1',
              ),
              'ad_img2' => array(
                'type'=>'file',
                'title'=>'Image 2',
              ),
              'ad_img3' => array(
                'type'=>'file',
                'title'=>'Image 3',
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
          'ad_title' => 'required',
          'ad_desc1' => 'required',
          'active' => 'required',
          'start_date' => 'required:date',
          'end_date' => 'required:date',
          'ad_img3' => 'required:file',
          'ad_img2' => 'required:file',
          'ad_img1' => 'required:file',
        ]);
        $realRequest = $request;
        $file1 = $request->file('ad_img1');
        $file2 = $request->file('ad_img2');
        $file3 = $request->file('ad_img3');
        $request = $request->all();
        if($file1 ){
          $name1 = $file1->getClientOriginalName();
          $file1->move('images',$name1);
          $request['ad_img1'] =  $name1;

        }
        if($file2){
          $name2 = $file2->getClientOriginalName();
          $file2->move('images',$name2);
          $request['ad_img2'] =  $name2;
        }
        if($file3){
          $name3 = $file3->getClientOriginalName();
          $file3->move('images',$name3);
          $request['ad_img3'] =  $name3;
        }
        BrandNews::create($request);
        Session::flash('message','Brandnews Added Successfully');
        return redirect('/brandnews');
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
        'action' => "brandnews.update",
        'data' => BrandNews::find($id),
        'link'=> (new BrandNews)->getKeyName(),
        'fields' => array(
          'brand_id' => array(
            'type'=>'select',
            'title'=>'Brand',
            'options'=> $this->brands(),
          ),
          'ad_title' => array(
            'type'=>'text',
            'title'=>'Title',
          ),
          'ad_desc1' => array(
            'type'=>'text',
            'title'=>'Description',
          ),
          'start_date' => array(
            'type'=>'date',
            'title'=>'From',
          ),
          'end_date' => array(
            'type'=>'date',
            'title'=>'To',
          ),
          'ad_img1' => array(
            'type'=>'file',
            'title'=>'Image 1',
          ),
          'ad_img2' => array(
            'type'=>'file',
            'title'=>'Image 2',
          ),
          'ad_img3' => array(
            'type'=>'file',
            'title'=>'Image 3',
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
      $file1 = $request->file('ad_img1');
      $file2 = $request->file('ad_img2');
      $file3 = $request->file('ad_img3');
      $request = $request->all();
      if($file1 ){
        $name1 = $file1->getClientOriginalName();
        $file1->move('images',$name1);
        $request['ad_img1'] =  $name1;

      }
      if($file2){
        $name2 = $file2->getClientOriginalName();
        $file2->move('images',$name2);
        $request['ad_img2'] =  $name2;
      }
      if($file3){
        $name3 = $file3->getClientOriginalName();
        $file3->move('images',$name3);
        $request['ad_img3'] =  $name3;
      }
      $brand = BrandNews::find($id);
      $realRequest->session()->flash('message','Brandnews Updated Successfully');
      $brand->update($request);
      return redirect('brandnews');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $brand = BrandNews::find($id);
      $brand->delete();
      Session::flash('message','Brandnews Deleted Successfully');
      return redirect('brandnews');
    }
}
