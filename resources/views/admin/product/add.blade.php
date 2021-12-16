@extends('layout.app_with_login')
@section('title','Add Product')
@section('script', url('public/js/dashboard/product.js'))
@section('content') 
<!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="content">
            <div class="section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mb-3">
                           <h2 class="title"><a data-slug="admin/product" href="{{url('/admin/product')}}"><span>{{'Product'}}</span></a> > {{' Add New '}}</h2>
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
                                                             <div class="form-group ">
                                                                <label>Product Name
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="name">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Product Code
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="code">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Product Quantity
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="quantity">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label>Product Price
                                                                <span class="text-danger">*</span>
                                                                </label>
                                                                <input required="" class="form-control" type="text" name="price">
                                                            </div>
                                                            <div class="col-md-3"></div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <a class="theme_btn red_btn " data-slug="admin/product" href="{{url('admin/product')}}">Cancel</a>
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

@push('custom-scripts')
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
<script type="text/javascript" src="{{ url('public/js/dashboard/product.js') }}"></script>
@endpush