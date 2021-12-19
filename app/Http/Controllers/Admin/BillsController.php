<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BillsExport;
use App\Helpers\FrontHelper;
use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\Product;
use DB;

class BillsController extends Controller
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
            return \View::make('admin.allbill.index')->renderSections();
        }
        return view('admin.allbill.index');
    }

    /**
     * Used for Admin get
     * @return redirect to Admin->get listing
    */
    public function get(Request $request)
    {
        $data = $request->all();
        $aTable = $this->data->with('products','customer')->filterBills($data)->latest();
        $result = FrontHelper::getListing($data,$aTable);
        return response()->json($result);
    }


    public function downloadBill()
    {
        return Excel::download(new BillsExport(), 'bills.xlsx');
    }
    

}
