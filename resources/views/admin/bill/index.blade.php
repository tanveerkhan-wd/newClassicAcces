@extends('layout.app_with_login')
@section('title','Bills')
@section('script', url('public/js/dashboard/bill.js'))
@section('content') 
<!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><a href="{{url('/admin/customer')}}"><span>{{'Customer'}}</span></a> > {{'Bills'}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" id="search" class="form-control without_border icon_control search_control" placeholder="{{'Search'}}">
                <input id="customer_id" type="hidden" name="customer_id" value="{{request()->customer ?? ''}}">
            </div>  
            <div class="col-md-4 text-md-right mb-3">
                
            </div>
            <div class="col-md-2 mb-3">
                <a href="{{url('admin/bill/add')}}?customer={{request()->customer ?? ''}}"><button class="theme_btn full_width small_btn">{{'Add New'}}</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="theme_table">
                    <div class="table-responsive">
                        <table id="listing" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{'Sr. No.'}}</th>
                                    <th>{{'Created at'}}</th>
                                    <th>{{'Bill No.'}}</th>
                                    <th>{{'KM Head'}}</th>
                                    <th>{{'Products'}}</th>
                                    <th>{{'Total Amount'}}</th>
                                    <th>{{'Payment Status'}}</th>
                                    <th><div class="action">{{'Actions'}}</div></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="theme_modal modal fade" id="delete_prompt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{url('public/images/ic_close_bg.png')}}" class="modal_top_bg">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{url('public/images/ic_close_circle_white.png')}}">
                </button>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <h5 class="modal-title" id="exampleModalCenterTitle">{{'Delete'}}</h5>
                        <div class="form-group text-center">
                            <label>{{$translations['gn_delete_prompt'] ?? 'Are you sure you want to delete ?'}}</label>
                            <input type="hidden" id="did">
                        </div>
                        <div class="text-center modal_btn ">
                            <button style="display: none;" class="theme_btn show_delete_modal full_width small_btn" data-toggle="modal" data-target="#delete_prompt">{{$translations['gn_delete'] ?? 'Delete'}}</button>
                            <button type="button" onclick="confirmDelete()" class="theme_btn">{{$translations['gn_yes'] ?? 'Yes'}}</button>
                            <button type="button" data-dismiss="modal" class="theme_btn red_btn">{{$translations['gn_no'] ?? 'No'}}</button>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="theme_modal modal fade" id="status_prompt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{url('public/images/ic_close_bg.png')}}" class="modal_top_bg">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{url('public/images/ic_close_circle_white.png')}}">
                </button>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h5 class="modal-title" id="exampleModalCenterTitle">{{'Change Status'}}</h5>
                            <div class="form-group text-center">
                                <label>{{'Are you sure you want to change status ?'}}</label>
                                <input type="hidden" id="did">
                            </div>
                            <div class="text-center modal_btn ">
                                <button style="display: none;" class="theme_btn show_status_modal full_width small_btn" data-toggle="modal" data-target="#status_prompt">{{$translations['gn_delete'] ?? 'Delete'}}</button>
                                <button type="button" onclick="confirmStatus()" class="theme_btn">{{$translations['gn_yes'] ?? 'Yes'}}</button>
                                <button type="button" data-dismiss="modal" class="theme_btn red_btn">{{$translations['gn_no'] ?? 'No'}}</button>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('custom-scripts')
<script type="text/javascript" src="{{ url('public/js/dashboard/bill.js') }}"></script>
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>

@endpush