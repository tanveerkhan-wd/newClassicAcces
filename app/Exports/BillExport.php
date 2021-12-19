<?php

namespace App\Exports;

use App\Models\Bill;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BillExport implements FromCollection,WithHeadings
{
    
    use Exportable;

    public $id;

    public function __construct($id)
    {
        $this->id = $id;
        $output = [];
        $data = Bill::where('id',$this->id)->first();
        
        $products = [];
        foreach ($data->products as $kiii => $valu) {
            $products[] = $valu->product->name;
        }

        $output[0][] = date("d-m-Y",strtotime($data->created_at));            
        $output[0][] = $data->customer->name;            
        $output[0][] = $data->customer->mobile;            
        $output[0][] = $data->customer->address;            
        $output[0][] = $data->customer->bike_name;            
        $output[0][] = $data->customer->bike_model;            
        $output[0][] = $data->customer->bike_no;            
        $output[0][] = $data->km_head;            
        $output[0][] = $data->service_amt;            
        $output[0][] = $products? implode(",", $products):'--';           
        $output[0][] = $data->sub_amt;            
        $output[0][] = $data->discount;            
        $output[0][] = $data->total_amt;
        if ($data->payment_status==3) {
            $output[0][] = 'Canceled';
        }elseif ($data->payment_status==2) {
            $output[0][] = 'Paid';
        }else{
            $output[0][] = 'Pending';
        }
        $output[0][] = $data->notes;
        
        $this->id = collect($output);
    }
    
    public function headings(): array {
        return [
            "Date","Name","Mobile","Address","Bike Name","Bike Model","Bike No.","KM Head","Service Amount","Products","Sub Total","Discount","Total Amount","Payment Status","Notes"
        ];
    }

    public function collection()
    {
        return $this->id;
    }

}
