<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\FrontHelper;
use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\Product;
use DB;

class BillController extends Controller
{
    
    private $data;

    public function __construct(Bill $data)
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
            return \View::make('admin.bill.index')->renderSections();
        }
        return view('admin.bill.index');
    }

    /**
     * Used for Admin get
     * @return redirect to Admin->get listing
    */
    public function get(Request $request)
    {
        $data = $request->all();
        $aTable = $this->data->with('products')->filter($data)->latest();
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
        $product = Product::whereStatus(1)->get();
        return view('admin.bill.add',compact('product'));
    }

    /**
     * Show the form for editing a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $id)
    {
        $editData = $id;
        $product = Product::whereStatus(1)->get();
        return view('admin.bill.edit',compact('product','editData'));
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
                $data = Bill::where('id',$request->pkCat)->first();
                $this->data = $data;
                
                if($this->props($request)->save()){
                    $this->addBillProducts($id,$request);
                    DB::commit();
                    $response['status'] = true;
                    $response['message'] = "Bill Successfully Updated";  
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
                    $this->addBillProducts($id,$request);
                    DB::commit();
                    $response['status'] = true;
                    $response['message'] = "Bill Successfully Added";  
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
        $this->data->customer_id = $request->customer_id;
        $this->data->km_head = $request->km_head;
        $this->data->service_amt = $request->service_amount;
        $this->data->sub_amt = $request->sub_amount;
        $this->data->discount = $request->discount;
        $this->data->total_amt = $request->total_amount;
        $this->data->payment_status = $request->payment_status;
        $this->data->notes = $request->notes;
        return $this;
    }

    private function save()
    {
        $this->data->save();
        return $this;
    }

    private function addBillProducts($bill_id,$request)
    {
        $data = [];
        BillProduct::where('bill_id',$bill_id)->delete();
        $products = count($request->product_id);
        if ($products >= 1) {
            for ($i=0; $i < $products ; $i++) { 
                
                $data[$i]['product_id'] =  $request->product_id[$i] ?? '';
                $data[$i]['bill_id'] =  $bill_id;
                $data[$i]['created_at'] =  date("Y-m-d H:i:s");
            }
            BillProduct::insert($data);
        }
    
    }
    
}
