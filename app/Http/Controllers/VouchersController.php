<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Brand;
use App\BrandNews;
use App\Voucher;
use \DB;
use \Session;
class VouchersController extends Controller
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
        'deletelink' => 'vouchers.destroy',
        'add' => true,
        'addlink' => 'VouchersController@create',
        'title' => 'Vouchers',
        'columns' => array(
          'vou_code' => array(
            'title'=> 'Code',
          ),
          'vou_type' => array(
            'title'=> 'Type',
          ),
          'disc_per' => array(
            'title'=> 'Value',
          ),
          'active_fdate' => array(
            'title'=> 'From',
          ),
          'active_tdate' => array(
            'title'=> 'To',
          ),
          'all_cust' => array(
            'title'=> 'Assign Customers',
          ),
        ),
        'key'=> (new Voucher)->getKeyName(),
        'link'=> 'vouchers',
        'data' => Voucher::orderBy('vou_id','desc')->paginate(10),
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
        'title' => 'Add Vouchers',
        'method' => 'POST',
        'action' => "VouchersController@store",
        'depends' => array(
          'vou_type' => array( // key when 1
            'disc_per' => 'show',
            'disc_value' => 'hide',
          ),
        ),
        'fields' => array(
            'vou_code' => array( // key
              'type'=>'text',
              'title'=>'Code',
            ),
            'vou_type' => array(
              'type'=>'select',
              'title'=>'Type',
              'options' => array(1=>'Percent',2=>'Value'),
            ),
            'disc_per' => array(
              'type'=>'text',
              'title'=>'Discount Percent',
            ),
            'disc_value' => array(
              'type'=>'text',
              'title'=>'Discount Value',
            ),
            'active_fdate' => array(
              'type'=>'date',
              'title'=>'From',
            ),
            'active_tdate' => array(
              'type'=>'date',
              'title'=>'To',
            ),
            'all_cust' => array(
              'type'=>'select',
              'title'=>'All Customer',
              'options' => array(1=>'Yes',2=>'Specific'),
            ),
            'forcust_phone' => array(
              'type'=>'text',
              'title'=>'Specific Phone',
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
        'vou_code' => 'required',
        'vou_type' => 'required',
        'active_fdate' => 'required:date',
        'active_tdate' => 'required:date',
        'all_cust' => 'required',
      ]);
      $voucher = new Voucher();
      $voucher->vou_code = $request->vou_code;
      $voucher->active_fdate = $request->active_fdate;
      $voucher->active_tdate = $request->active_tdate;
      $voucher->vou_type = $request->vou_type;
      if($voucher->vou_type == 1){
        $voucher->disc_per = $request->disc_per;
      }else{
        $voucher->disc_value = $request->disc_value;
      }
      $voucher->all_cust = $request->all_cust;
      if($voucher->all_cust == 1){
        $voucher->forcust_phone = $request->forcust_phone;
      }
      $voucher->save();
      Session::flash('message','Vouchers Added Successfully');
      return redirect('/vouchers');
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
      'title' => 'Update Voucher',
      'method' => 'POST',
      'action' => "vouchers.update",
      'data' => Voucher::find($id),
      'link'=> (new Voucher)->getKeyName(),
      'depends' => array(
        'vou_type' => array( // key when true
          'when_value' => 1,
          'show' => 'disc_per',
          'hide' => 'disc_value',
        ),
        'all_cust' => array( // key when true
          'forcust_phone' => 'toggle',
        ),
      ),
      'fields' => array(
        'vou_code' => array(
          'type'=>'text',
          'title'=>'Code',
        ),
        'vou_type' => array(
          'type'=>'select',
          'title'=>'Type',
          'options' => array(1=>'Percent',2=>'Value'),
        ),
        'disc_per' => array(
          'type'=>'text',
          'title'=>'Discount Percent',
        ),
        'disc_value' => array(
          'type'=>'text',
          'title'=>'Discount Value',
        ),
        'active_fdate' => array(
          'type'=>'date',
          'title'=>'From',
        ),
        'active_tdate' => array(
          'type'=>'date',
          'title'=>'To',
        ),
        'all_cust' => array(
          'type'=>'select',
          'title'=>'All Customer',
          'options' => array(1=>'Yes',2=>'Specific'),
        ),
        'forcust_phone' => array(
          'type'=>'text',
          'title'=>'Specific Phone',
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
    $voucher = Voucher::find($id);
    $voucher->vou_code = $request->vou_code;
    $voucher->active_fdate = $request->active_fdate;
    $voucher->active_tdate = $request->active_tdate;
    $voucher->vou_type = $request->vou_type;
    if($voucher->vou_type == 1){
      $voucher->disc_per = $request->disc_per;
    }else{
      $voucher->disc_value = $request->disc_value;
    }
    $voucher->all_cust = $request->all_cust;
    if($voucher->all_cust == 1){
      $voucher->forcust_phone = $request->forcust_phone;
    }
    $voucher->save();
    $realRequest->session()->flash('message','Voucher Updated Successfully');
    return redirect('vouchers');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $voucher = Voucher::find($id);
    $voucher->delete();
    Session::flash('message','Voucher Deleted Successfully');
    return redirect('vouchers');
  }
}
