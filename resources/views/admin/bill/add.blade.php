@extends('layout.app_with_login')
@section('title','Bill')
@section('script', url('public/js/dashboard/bill.js'))
@section('content') 
@php
$payment_status = Config::get('constant.payment_status');
@endphp
<!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="content">
            <div class="section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mb-3">
                           <h2 class="title">
                            @if(Request::is('admin/bills/add'))
                                <a href="{{url('/admin/bills')}}"><span>{{'Bills'}}</span></a> > {{' Add New '}}</h2>
                            @else
                            <a href="{{url('/admin/customer')}}"><span>{{'Customer'}}</span></a> > <a href="{{url('/admin/bill')}}?customer={{request()->customer ?? ''}}"><span>{{'Bill'}}</span></a> > {{' Add New '}}</h2>
                            @endif
                        </div> 
                        <div class="col-12">
                            <div class="white_box pt-5 pb-5">
                                <div class="container-fliid">
                                    <div class="row">
                                        <div class="col-12">
                                            <form name="add-form">
                                                <div class="box-body">
                                                    <div class="row">
                                                        <input type="hidden" name="pkCat">
                                                        <input type="hidden" name="customer_id" value="{{request()->customer ?? ''}}">

                                                        <div class="col-md-3 check_box">
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="checkbox" name="check_pro">
                                                              <label class="form-check-label">
                                                                + Add Products
                                                              </label>
                                                            </div>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="checkbox" value="1" name="check_accc">
                                                              <label class="form-check-label">
                                                                + Add Accessories
                                                              </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="product_box d-none">
                                                                <div class="form-group d-flex clon-product">
                                                                    <div class="col-8">
                                                                        <label>Product</label>
                                                                        <select class="form-control icon_control dropdown_control product_id" name="product_id[]">
                                                                            <option value="">Select</option>
                                                                            @foreach($product as $kii=> $val)
                                                                            <option data-price="{{$val->price ?? ''}}" value="{{$val->id ?? ''}}">{{$val->name ?? ''}} ---> ₹{{ $val->price ?? '' }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" name="product_price[]" class="proprice" value="">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label mb-2">Quantity</label>
                                                                            <input class="form-control pro-quantity" type="number" min="1" value="1" name="quantity[]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="remove_product d-none">
                                                                        <img src="{{url('public/images/removepro.png')}}" style="width:32px">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 cloned-products">
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="form-group text-right">
                                                                    <button type="button" class="theme_btn small_btn addmoreproduct">+Add More Products</button>
                                                                </div>
                                                            </div>

                                                            <div class="accessory_box d-none">
                                                                <div class="form-group d-flex clon-accessory">
                                                                    <div class="col-8">
                                                                        <label>Accessories</label>
                                                                        <select class="form-control icon_control dropdown_control accessory_id" name="accessory_id[]">
                                                                            <option value="">Select</option>
                                                                            @foreach($accessories as $kii=> $val)
                                                                            <option data-price="{{$val->price ?? ''}}" value="{{$val->id ?? ''}}">{{$val->part_name ?? ''}} ---> ₹{{ $val->price ?? '' }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" name="accessory_price[]" class="aceprice" value="">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label mb-2">Quantity</label>
                                                                            <input class="form-control acc-quantity" type="number" min="1" value="1" name="acc_quantity[]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="remove_accessory d-none">
                                                                        <img src="{{url('public/images/removepro.png')}}" style="width:32px">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 cloned-accessory">
                                                                        
                                                                    </div>
                                                                </div>


                                                                <div class="form-group text-right">
                                                                    <button type="button" class="theme_btn small_btn addmoreaccesory">+Add More Accessories</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <hr class="style14">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label>Bill Number
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="bill_no">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label>KM. Head
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="km_head">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label>Service Amount</label>
                                                                <input class="form-control" type="number" name="service_amount">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label>Sub Amount
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="sub_amount">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group ">
                                                                <label>Discount In (Rs.)</label>
                                                                <input class="form-control" type="number" name="discount">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group ">
                                                                <label>Total Amount
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="total_amount">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Payment Status</label>
                                                                <select required="" class="form-control icon_control dropdown_control" name="payment_status">
                                                                    <option value="">Select</option>
                                                                    @foreach($payment_status as $kii=>$val)
                                                                    <option value="{{$kii}}">{{$val}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-3"></div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group ">
                                                                        <label>Notes</label>
                                                                        <textarea class="form-control" name="notes" rows="3" placeholder="Enter any important note here.."></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        @if(Request::is('admin/bills/add'))
                                                            <a class="theme_btn red_btn" href="{{url('/admin/bills')}}">Cancel</a>
                                                        @else
                                                            <a class="theme_btn red_btn" href="{{url('/admin/bill')}}?customer={{request()->customer ?? ''}}">Cancel</a>
                                                        @endif
                                                        
                                                        <button class="theme_btn">Create</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@push('custom-styles')
<link href="{{url('public/css/select2.css')}}" rel="stylesheet" />
<style type="text/css">
    .select2-container .select2-selection--single{height: 38px;}
    .aks-file-upload-delete{display: none;}
    .remove_product{position:absolute;right: 0px;cursor: pointer;}
    .remove_accessory{position:absolute;right: 0px;cursor: pointer;}
    .check_box{border-right:2px solid rgba(3, 102, 214, 0.3);}
    .small_btn{padding: 2px;font-size: 13px;line-height: 22px;}
    hr.style14 {margin: 10px; border: 0;height: 2px;background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);}

</style>
@endpush
@push('custom-scripts')
<script src="{{url('public/js/select2.js')}}"></script>
<script type="text/javascript">
    $(function() {
        
        $('.select2').select2();

        showLoader(false);

    });
</script>
<script type="text/javascript" src="{{ url('public/js/dashboard/bill.js') }}"></script>
@endpush