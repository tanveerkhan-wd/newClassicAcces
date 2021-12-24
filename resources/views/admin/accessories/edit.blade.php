@extends('layout.app_with_login')
@section('title','Edit Accessories')
@section('script', url('public/js/dashboard/accessories.js'))
@section('content') 
<!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="content">
            <div class="section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mb-3">
                           <h2 class="title"><a data-slug="admin/accessories" href="{{url('/admin/accessories')}}"><span>{{'Accessories'}}</span></a> > {{' Edit '}}</h2>
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
                                                            <input type="hidden" name="pkCat" value="{{$data->id ?? ''}}">
                                                             <div class="form-group ">
                                                                <label>Firm Name
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="firm_name" value="{{$data->firm_name ?? ''}}">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Part Name
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="part_name" value="{{$data->part_name ?? ''}}">
                                                            </div>

                                                            <div class="form-group ">
                                                                <label>Part Number
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="part_no"  value="{{$data->part_no ?? ''}}">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label> Quantity
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="quantity" min="1"  value="{{$data->quantity ?? ''}}">
                                                            </div>

                                                            <div class="form-group ">
                                                                <label> Rate
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="rate"  value="{{$data->rate ?? ''}}">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Price
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="number" name="price"  value="{{$data->price ?? ''}}">
                                                            </div>
                                                            <div class="col-md-3"></div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <a class="theme_btn red_btn" href="{{url('admin/accessories')}}">Cancel</a>
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
<script type="text/javascript" src="{{ url('public/js/dashboard/accessories.js') }}"></script>
@endpush