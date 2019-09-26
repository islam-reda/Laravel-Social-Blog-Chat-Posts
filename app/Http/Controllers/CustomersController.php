<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use App\Customer;
use DB;
use Session;
use Excel;
class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function export()
   {
      $data = Customer::get()->toArray();
  		return Excel::create('customers', function($excel) use ($data) {
  			$excel->sheet('mySheet', function($sheet) use ($data)
  	        {
  				        $sheet->fromArray($data);
  	        });
  		})->download('csv');
      return redirect('/');
   }
   public function importExcel(Request $request)
    {
        if($request->hasFile('import_file')){
            Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                  var_dump($row['customer_phone']);
                    $data = array(
                      'customer_phone' => $row['customer_phone'],
                      'email' => $row['email'],
                      'active_program_id' => $row['active_program_id'],
                      'prog_accm_points' => $row['prog_accm_points'],
                      'prog_accm_value' => $row['prog_accm_value'],
                      'prog_rdm_points' => $row['prog_rdm_points'],
                      'prog_rdm_value' => $row['prog_rdm_value'],
                      'last_up_invc_datetime' => $row['last_up_invc_datetime'],
                      'last_up_invc_sid' => $row['last_up_invc_sid'],
                      'last_rdm_invc_datetime' => $row['last_rdm_invc_datetime'],
                      'last_rdm_invc_sid' => $row['last_rdm_invc_sid'],
                      'activation_code' => $row['activation_code'],
                      'brand_id' => $row['brand_id'],
                    );
                    if(!empty($data)) {
                        DB::table('loyalty_customers')->insert($data);
                    }
                }
            });
        }

        Session::put('success', 'Youe file successfully import in database!!!');

        return back();
    }
    public function index()
    {
      $data = array(
        'edit' => false,
        'delete' => false,
        'export' => 'CustomersController@export',
        'import' => 'CustomersController@importExcel',
        'deletelink' => 'customers.destroy',
        'add' => false,
        'addlink' => 'CustomersController@create',
        'title' => 'Customers',
        'columns' => array(
          'customer_phone' => array(
            'title'=> 'Phone Number',
          ),
          'email' => array(
            'title'=> 'Email',
          ),
          'activation_code' => array(
            'title'=> 'Activation Code',
          ),
          'prog_accm_points' => array(
            'title'=> 'Points',
          ),
          'prog_accm_value' => array(
            'title'=> 'Points Value',
          ),
          'active' => array(
            'title'=> 'Status',
          ),
        ),
        'key'=> (new Customer)->getKeyName(),
        'link'=> 'customers',
        'data' => DB::table('loyalty_customers')->orderBy('created_date', 'desc')->paginate(7),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
