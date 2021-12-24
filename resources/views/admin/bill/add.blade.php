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
                           <h2 class="title"><a href="{{url('/admin/customer')}}"><span>{{'Customer'}}</span></a> > <a href="{{url('/admin/bill')}}?customer={{request()->customer ?? ''}}"><span>{{'Bill'}}</span></a> > {{' Add New '}}</h2>
                        </div> 
                        <div class="col-12">
                            <div class="white_box pt-5 pb-5">
                                <div class="container-fliid">
                                    <div class="row">
                                        <div class="col-12">
                                            <form name="add-form">
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-3"></div>
                                                        <div class="col-md-6">
                                                            <input type="hidden" name="pkCat">
                                                            <input type="hidden" name="customer_id" value="{{request()->customer ?? ''}}">

                                                            <div class="form-group clon-product">
                                                                <label>Product</label>
                                                                <div class="remove_product d-none">
                                                                    <img src="{{url('public/images/removepro.png')}}" style="width:32px">
                                                                </div>
                                                                <select class="form-control icon_control dropdown_control product_id" name="product_id[]">
                                                                    <option value="">Select</option>
                                                                    @foreach($product as $kii=> $val)
                                                                    <option data-price="{{$val->price ?? ''}}" value="{{$val->id ?? ''}}">{{$val->name ?? ''}} ---> ₹{{ $val->price ?? '' }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="product_price[]" class="proprice" value="">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 cloned-products">
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group text-right">
                                                                <button type="button" class="theme_btn small_btn addmoreproduct">+Add More Products</button>
                                                            </div>

                                                            <div class="form-group clon-accessory">
                                                                <label>Accessories</label>
                                                                <div class="remove_accessory d-none">
                                                                    <img src="{{url('public/images/removepro.png')}}" style="width:32px">
                                                                </div>
                                                                <select class="form-control icon_control dropdown_control accessory_id" name="accessory_id[]">
                                                                    <option value="">Select</option>
                                                                    @foreach($accessories as $kii=> $val)
                                                                    <option data-price="{{$val->price ?? ''}}" value="{{$val->id ?? ''}}">{{$val->part_name ?? ''}} ---> ₹{{ $val->price ?? '' }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="accessory_price[]" class="aceprice" value="">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 cloned-accessory">
                                                                    
                                                                </div>
                                                            </div>


                                                            <div class="form-group text-right">
                                                                <button type="button" class="theme_btn small_btn addmoreaccesory">+Add More Accessories</button>
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>KM. Head
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="km_head">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Service Amount</label>
                                                                <input class="form-control" type="number" name="service_amount">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Sub Amount
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="sub_amount">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Discount In (Rs.)</label>
                                                                <input class="form-control" type="number" name="discount">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Total Amount
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="total_amount">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Payment Status</label>
                                                                <select required="" class="form-control icon_control dropdown_control" name="payment_status">
                                                                    <option value="">Select</option>
                                                                    @foreach($payment_status as $kii=>$val)
                                                                    <option value="{{$kii}}">{{$val}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Notes</label>
                                                                <textarea class="form-control" name="notes" rows="3" placeholder="Enter any important note here.."></textarea>
                                                            </div>
                                                            <div class="col-md-3"></div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <a class="theme_btn red_btn" href="{{url('/admin/bill')}}?customer={{request()->customer ?? ''}}">Cancel</a>
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
    .remove_product{position:absolute;right: -39px;cursor: pointer;}
    .remove_accessory{position:absolute;right: -39px;cursor: pointer;}
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