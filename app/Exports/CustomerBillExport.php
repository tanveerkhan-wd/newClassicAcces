<?php

namespace App\Exports;

use App\Models\Bill;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerBillExport implements FromCollection,WithHeadings
{
    
    use Exportable;

    public $id;

    public function __construct($id)
    {
        $this->id = $id;
        $output = [];
        $data = Bill::where('customer_id',$this->id)->get();
        foreach ($data as $kii=>$val) {

            $products = [];
            foreach ($val->products as $kiii => $valu) {
                $products[] = $valu->product->name;
            }

            $output[$kii][] = $val->created_at;            
            $output[$kii][] = $val->customer->name;            
            $output[$kii][] = $val->customer->mobile;            
            $output[$kii][] = $val->customer->address;            
            $output[$kii][] = $val->customer->bike_name;            
            $output[$kii][] = $val->customer->bike_model;            
            $output[$kii][] = $val->customer->bike_no;            
            $output[$kii][] = $val->km_head;            
            $output[$kii][] = $val->service_amt;            
            $output[$kii][] = $products? implode(",", $products):'--';           
            $output[$kii][] = $val->sub_amt;            
            $output[$kii][] = $val->discount;            
            $output[$kii][] = $val->total_amt;
            if ($val->payment_status==3) {
                $output[$kii][] = 'Canceled';
            }elseif ($val->payment_status==2) {
                $output[$kii][] = 'Paid';
            }else{
                $output[$kii][] = 'Pending';
            }
            $output[$kii][] = $val->notes;

        }
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