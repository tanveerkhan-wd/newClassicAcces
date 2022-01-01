
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PDF</title>
    <style type="text/css">
        *{
            font-size: 13px;
            font-weight: normal;
            font-family: Cambria !important;    
        }
        @font-face {
          font-family: Cambria;
          font-style: normal;
          font-weight: normal;
        }
        .container{
            margin: 10px;
        }
        .btn-1{
            color: #fff;
            background: #138d13de;
            border: none;
            border-radius: 4px;
        }
        .btn-2{
            color: #fff;
            background: #b59009;
            border: none;
            border-radius: 4px;
        }
        .btn-3{
            color: #fff;
            background: #cb1212;
            border: none;
            border-radius: 4px;
        }
        table.w-100{
            border-collapse: collapse;
            width: 100%;
        }

        .table-with-border table, .table-with-border th, .table-with-border td {
          border: 1px solid #CED4DA;
          border-collapse: collapse;
          padding: 8px;
        }
        table.table-no-border, th.table-no-border,  td.table-no-border {
          border: 0px solid #CED4DA;
          border-collapse: collapse;
          padding: 5px;
        }
        .title-1{
            font-weight: bold;
            font-size: 25px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .title-2{
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .uppercase{
            text-transform: uppercase;
        }
        .title-3{
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
        }
        .title-4{
            font-weight: normal;
            font-size: 14px;
            letter-spacing: 1px;
        }
        .text-c{
            text-align: center;
        }
        .text-r{
            text-align: right;
        }
        .text-l{
            text-align: left;
        }
        .underline{
            text-decoration: underline;
        }

        /*TOP HEADER*/
        td.logo{
            margin: auto;
            text-align: center;
        }
        /*END*/

        .page_break{ page-break-before: always; }
        
    </style>
</head>
<body>
    <div class="container">
        <table class="w-100 top-head">
            <tr>
                <td class="logo">
                    <img src="{{public_path('uploads')}}/{{Settings::get('general_setting_bill_pdf_logo') ?? ''}}" style="width:auto;height: 100px;">
                </td>
            </tr>
            <tr>
                <td class="title-1">New Classic Accessories & Service Center</td>
            </tr>
        </table>
        <br>
        <table class="w-100">
            <tr>
                <th class="title-3 text-l underline" width="80%">Our Address:</th>
                <th class="title-3 text-r underline" width="20%">Mobile Number:</th>
            </tr>
            <tr>
                <td class="title-4">Near Honda Agency, Road No. 3, Gudha Mod, <br>Jhunjhunu (Raj.) 333001</td>
                <td class="title-4 text-r"> +91 7597453333 <br> +91 9887453333 </td>
            </tr>
        </table>
        <br>
        <table class="w-100">
            <tr>
                <th class="title-2 underline">INVOICE</th>
            </tr>
        </table>
    </div>
    <hr>
    <div class="container">
        <table class="w-100 top-head">
            <tr>
                <th class="title-3 text-l" width="20%">
                    Bill Number:
                </th>
                <td class="title-3 text-l underline" width="40%">
                    {{ $bill->bill_no ?? '--' }}
                </td>

                <th class="title-3 text-r" width="20%">
                    Bill Date: 
                </th>
                <td class="title-4 text-r" width="20%">
                    {{ date("D d-M-Y",strtotime($bill->created_at)) ?? '--' }}
                </td>
            </tr>
        </table>
        <br>
        <table class="w-100">
            <tr>
                <th class="title-3 text-l" width="10%">
                    Name
                </th>
                <td class="title-4 text-l" width="56%">
                    {{ $bill->customer->name ?? '--' }}
                </td>

                <th class="title-3 text-l" width="17%">
                    Bike Name 
                </th>
                <td class="title-4 text-l" width="17%">
                    {{ $bill->customer->bike_name ?? '--' }}
                </td>
            </tr>
            <tr>
                <th class="title-3 text-l" width="10%">
                    Mobile
                </th>
                <td class="title-4 text-l" width="56%">
                    {{ $bill->customer->mobile ?? '--' }}
                </td>

                <th class="title-3 text-l" width="17%">
                    Bike Model
                </th>
                <td class="title-4 text-l" width="17%">
                    {{ $bill->customer->bike_model ?? '--' }}
                </td>
            </tr>
            <tr>
                <th class="title-3 text-l" width="10%">
                    Address
                </th>
                <td class="title-4 text-l" width="56%">
                    {{ $bill->customer->address ?? '--' }}
                </td>

                <th class="title-3 text-l" width="17%">
                    Bike Number
                </th>
                <td class="title-4 text-l" width="17%">
                    {{ $bill->customer->bike_no ?? '--' }}
                </td>
            </tr>
            
        </table>
        
        <hr>
    </div>
    
    <div class="container table-with-border">

        <table class="table w-100">
            <tr>
                <th class="title-3 text-c" width="10%">
                    S. No.
                </th>
                <th class="title-3 text-c" width="15%">
                    Part Code
                </th>
                <th class="title-3 text-c" width="40%">
                    Part/Accessories/Other Name
                </th>
                <th class="title-3 text-c" width="10%">
                    Quantity
                </th>
                <th class="title-3 text-c" width="10%">
                    MRP
                </th>
                <th class="title-3 text-c" width="15%">
                    Amount
                </th>
            </tr>
            @php
                $cnt = 1;
            @endphp
            @foreach($bill->products as $kii=>$val)
            <tr>
                <td class="title-4 text-c">
                    {{ $cnt+1 }}
                </td>
                <td class="title-4 text-c">
                    {{ $val->product->code ?? '--' }}
                </td>
                <td class="title-4 text-l">
                    {{ $val->product->name ?? '--' }}
                </td>
                <td class="title-4 text-c">
                    {{ $val->quantity ?? '--' }}
                </td>
                <td class="title-4 text-c">
                    {{ $val->product->price ?? '--' }}
                </td>
                <td class="title-4 text-c">
                    @php
                        $totalPro = $val->product->price*$val->quantity;
                    @endphp
                    {{ $totalPro ?? '--' }}
                </td>
            </tr>
            @endforeach
            @foreach($bill->accessories as $key=>$val)
            <tr>
                <td class="title-4 text-c">
                    {{ $cnt+1 }}
                </td>
                <td class="title-4 text-c">
                    {{ $val->accessory->part_no ?? '--' }}
                </td>
                <td class="title-4 text-l">
                    {{ $val->accessory->part_name ?? '--' }}
                </td>
                <td class="title-4 text-c">
                    {{ $val->quantity ?? '--' }}
                </td>
                <td class="title-4 text-c">
                    {{ $val->accessory->price ?? '--' }}
                </td>
                <td class="title-4 text-c">
                    @php
                        $totalAcc = $val->accessory->price*$val->quantity;
                    @endphp
                    {{ $totalAcc ?? '--' }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td class="title-4 text-c">
                    {{ $cnt+1 }}
                </td>
                <td class="title-4 text-c">
                    {{ '--' }}
                </td>
                <td class="title-4 text-l">
                    Service Amount
                </td>
                <td class="title-4 text-c">
                    --
                </td>
                <td class="title-4 text-c">
                    {{ $bill->service_amt ?? '' }}
                </td>
                <td class="title-4 text-c">
                    {{ $bill->service_amt ?? '--' }}
                </td>
            </tr>
            <tr>
                <td class="title-4 text-c">
                    {{ $cnt+1 }}
                </td>
                <td class="title-4 text-c">
                    {{ '--' }}
                </td>
                <td class="title-4 text-l">
                    Discount
                </td>
                <td class="title-4 text-c">
                    --
                </td>
                <td class="title-4 text-c">
                    {{ $bill->discount ?? '' }}
                </td>
                <td class="title-4 text-c">
                    {{ $bill->discount ?? '--' }}
                </td>
            </tr>
            <tr>
                <th colspan="2">
                    <button class="@if($bill->payment_status==1) btn-2 @elseif($bill->payment_status==2) btn-1 @else btn-3 @endif">Payment {{ Config::get('constant.payment_status')[$bill->payment_status] ?? '' }}</button>
                </th>
                <th colspan="2" class="title-3 text-r">
                    Grand Total
                </th>
                <td colspan="2" class="title-2 text-c">
                    <img src="{{public_path('images/ic-rupee-15.png')}}">{{ number_format($bill->total_amt) ?? '--' }}
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        <br><br>
        <table class="table w-100">
            <tr>
                <th width="70%"></th>
                <th class="text-r" width="30%">
                    <img src="{{public_path('uploads')}}/{{Settings::get('general_setting_signature') ?? ''}}" style="width:auto;height:100px;">
                </th>
            </tr>
            <tr>
                <th width="70%"></th>
                <th class="title-3 text-r" width="30%" style="letter-spacing: 3px;">
                    Signature
                </th>
            </tr>
            
        </table>
    </div>
</body>
</html>