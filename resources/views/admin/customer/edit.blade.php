@extends('layout.app_with_login')
@section('title','Edit Customer')
@section('script', url('public/js/dashboard/customer.js'))
@section('content') 
<!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="content">
            <div class="section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mb-3">
                           <h2 class="title"><a data-slug="admin/customer" href="{{url('/admin/customer')}}"><span>{{'Customer'}}</span></a> > {{' Edit '}}</h2>
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
                                                            <input type="hidden" name="pkCat"  value="{{$editData->id ?? ''}}">
                                                             <div class="form-group ">
                                                                <label>Name
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="name" value="{{$editData->name ?? ''}}">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Mobile Number
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="mobile"  value="{{$editData->mobile ?? ''}}">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Address
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="address"  value="{{$editData->address ?? ''}}">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Bike Name
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="bike_name"  value="{{$editData->bike_name ?? ''}}">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Bike Model
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="bike_model"  value="{{$editData->bike_model ?? ''}}">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Bike Number
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="bike_no"  value="{{$editData->bike_no ?? ''}}">
                                                            </div>
                                                            <div class="col-md-3"></div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <a class="theme_btn red_btn " data-slug="admin/product" href="{{url('admin/product')}}">Cancel</a>
                                                        <button class="theme_btn">Update</button>
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

@push('custom-scripts')
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
<script type="text/javascript" src="{{ url('public/js/dashboard/customer.js') }}"></script>
@endpush