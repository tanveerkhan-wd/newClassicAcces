<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\CustomerBillExport;
use App\Helpers\FrontHelper;
use App\Models\Customer;
use DB;

class CustomerController extends Controller
{
    private $data;

    public function __construct(Customer $data)
    {
        $this->data = $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return \View::make('admin.customer.index')->renderSections();
        }
        return view('admin.customer.index');
    }

    /**
     * Used for Admin get
     * @return redirect to Admin->get listing
    */
    public function get(Request $request)
    {
        $data = $request->all();
        $aTable = $this->data->filter($data)->latest();
        $result = FrontHelper::getListing($data,$aTable);
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {   
        return view('admin.customer.add');
    }

    /**
     * Show the form for editing a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $id)
    {
        $editData = $id;
        return view('admin.customer.edit',compact('editData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addpost(Request $request)
    {
        $id = '';
        DB::beginTransaction();
        try {

            if(!empty($request->pkCat) || $request->pkCat != null)
            {
                $id = $request->pkCat;
                $data = Customer::where('id',$request->pkCat)->first();
                $this->data = $data;
                
                if($this->props($request)->save()){
                    DB::commit();
                    $response['status'] = true;
                    $response['message'] = "Customer Successfully Updated";  
                }
                else{
                    DB::rollback();
                    $response['status'] = false;
                    $response['message'] = "Something Went Wrong!";  
                }

            }
            else
            {
                if($this->props($request)->save()){
                    $id = $this->data->id;
                    DB::commit();
                    $response['status'] = true;
                    $response['message'] = "Customer Successfully Added";  
                }
                else{
                    DB::rollback();
                    $response['status'] = false;
                    $response['message'] = "Something Went Wrong!";  
                }

            }
            

        } catch (Exception $e) {
            
            DB::rollback();

            $response['status'] = false;
            $response['message'] = "Error:" . $e->getMessage();    
        }

        return response()->json($response);

    }

    /**
     * change the specified resource from storage.
     *
     */
    public function status(Request $request)
    {
        $input = $request->all();
        $cid = $input['cid'];
        $response = FrontHelper::status($cid,$this->data);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $cid = $input['cid'];
        if(empty($cid)){
             $response['status'] = false;
        }else{
            $data = $this->data->where('id',$cid)->first();
            $data = $data->delete();
            if ($data) {
                $response['status'] = true;
                $response['message'] = "Delete Successfully";
            }else{
                $response['status'] = false;
            }
        }
        return response()->json($response);
    }
    
    private function props(Request $request)
    {
        $this->data->name = $request->name;
        $this->data->mobile = $request->mobile;
        $this->data->address = $request->address;
        $this->data->bike_name = $request->bike_name;
        $this->data->bike_model = $request->bike_model;
        $this->data->bike_no = $request->bike_no;
        return $this;
    }

    private function save()
    {
        $this->data->save();
        return $this;
    }

    public function allBill($id)
    {
        return Excel::download(new CustomerBillExport($id), 'bill.xlsx');
    }
}
