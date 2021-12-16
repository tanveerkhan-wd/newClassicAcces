
$(function() {
  var imagepath= base_url+'/public/images/';
  $('#listing').on( 'processing.dt', function ( e, settings, processing ) {
        if(processing){
          showLoader(true);
        }else{
          showLoader(false);
        }
    } ).DataTable({
        "language": {
          "sLengthMenu": $('#show_txt').val()+" _MENU_ "+$('#entries_txt').val(),
          "info": $('#showing_txt').val()+" _START_ "+$('#to_txt').val()+" _END_ "+$('#of_txt').val()+" _TOTAL_ "+$('#entries_txt').val(),
          "emptyTable": $('#msg_no_data_available_table').val(),
          "paginate": {
            "previous": $('#previous_txt').val(),
            "next": $('#next_txt').val()
          }
        },
        "lengthMenu": [10,20,30,50],
        "searching": false,
        "serverSide": true,
        "deferRender": true,
        "ajax": {
            "url": base_url+"/admin/customer",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search').val();
            }
        },
        columns:[
          { "data": "index",className: "text-center"},
          
          { "data": "createdat",className: "text-center",sortable:!1},
          { "data": "name",className: "text-center"},
          { "data": "mobile",className: "text-center"},
          { "data": "address",className: "text-center"},
          { "data": "bike_name",className: "text-center"},
          { "data": "bike_model",className: "text-center"},
          { "data": "bike_no",className: "text-center"},
          
          /*{ "data": "status",className: "text-center",
              render: function (data, type, row) {
                var html = '';
                var status = row.status==1 ? 'Active' :'Inactive';
                var addClass = status=='Active' ? '' : 'inactiveClass';
                html ='<span><a href="javascript:void(0)" class="changeStatus '+addClass+'" onclick="triggerStatus('+row.id+')">'+status+'</span></a>'
                return html;
              }
          },  */       
          { "data": "action", sortable:!1,
            render: function (data, type, row) {
              var deletes = '<a onclick="triggerDelete('+row.id+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>';
              var edit = '<a href="'+base_url+'/admin/customer/edit/'+row.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>';
              var bill = '<a href="'+base_url+'/admin/bill?customer='+row.id+'" class="badge badge-info"><strong>Bills</strong></a>';
              var downloadbill = '<a href="'+base_url+'/admin/customer/download/'+row.id+'"><img src="'+imagepath+'/download.png"></a>';
              var whatsapp = '<a href="https://wa.me/91'+row.mobile+'" target="_blank"><img src="'+imagepath+'/icons8-whatsapp-18.png"></a>';
              return  edit + '&nbsp;&nbsp;&nbsp;'+ deletes+ '&nbsp;&nbsp;&nbsp;'+ bill +'&nbsp;&nbsp;&nbsp;<br>'+downloadbill + '&nbsp;&nbsp;&nbsp;' + whatsapp;
            }
          },
      ],

    });
    /*Listing End*/
  
    $("#search").on('keyup', function () {
      $('#listing').DataTable().ajax.reload();
    });

    /*==== Add DATA ====*/
    $("form[name='add-form']").validate({
      errorClass: "error_msg",
       rules: {
          name:{
            required:true,
          }
       },
        submitHandler: function(form, event) {
        event.preventDefault();

        showLoader(true);
        var formData = new FormData($(form)[0]);
        $.ajax({
            url: base_url+'/admin/customer/add',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,              
            data: formData,
            success: function(result)
            {
                if(result.status){
                  toastr.success(result.message);
                  location.reload();
                }else{
                  toastr.error(result.message);
                }
                showLoader(false);
            },
            error: function(data)
            {
                toastr.error($('#something_wrong_txt').val());
                showLoader(false);
            }
        });
      }
    });
});

function triggerStatus(cid){
   $('#did').val(cid);   
   $( ".show_status_modal" ).click();
}

function confirmStatus(cid){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/admin/customer/status',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        if(result.status){
          $('#status_prompt').modal('hide');
          $('#listing').DataTable().ajax.reload();
          toastr.success(result.message);
        }else{
          toastr.error(result.message);
        }
        
        showLoader(false);
    },
    error: function(data)
    {
        toastr.error($('#something_wrong_txt').val());
        showLoader(false);
    }
  });
}


function triggerDelete(cid){
   $('#did').val(cid);   
   $( ".show_delete_modal" ).click();
}

function confirmDelete(){
  showLoader(true);
  var cid = $('#did').val();
  $.ajax({
    url: base_url+'/admin/customer/destroy',
    type: 'POST',
    dataType:'json',
    cache: false,              
    data: {'cid':cid},
    success: function(result)
    {
        $('#delete_prompt').modal('hide');
        if(result.status){
          toastr.success(result.message);
          $('#listing').DataTable().ajax.reload();
        }else{
          toastr.error(result.message);
        }
        showLoader(false);
    },
    error: function(data)
    {
        toastr.error($('#something_wrong_txt').val());
        showLoader(false);
    }
  });
}