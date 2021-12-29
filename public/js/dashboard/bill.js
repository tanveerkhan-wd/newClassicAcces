
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
            "url": base_url+"/admin/bill",
            "type": "POST",
            "dataType": 'json',
            "data": function ( d ) {
              d.search = $('#search').val();
              d.customer_id = $('#customer_id').val();
              d.payment_status = $('#payment_status').val();
            }
        },
        columns:[
          { "data": "index",className: "text-center"},
          
          { "data": "createdat",className: "text-center",sortable:!1},
          { "data": "id",className: "text-center"},
          { "data": "km_head",className: "text-center",
            render: function (data, type, row) {
              return row.km_head+' KM';
            }
          },
          
          { "data": "products",className: "text-center",sortable:!1,
            render: function (data, type, row) {
              var html = '';
              if (row.products) {
                $.each(row.products,function (key, val) {
                  html += val.product.name+'- ₹'+val.product.price+'<br>'; 
                });

              }
              if (row.accessories) {
                $.each(row.accessories,function (key, val) {
                  html += val.accessory.part_name+'- ₹'+val.accessory.price+'<br>'; 
                });

              }
              return html;
            }
          },
          
          { "data": "total_amt",className: "text-center",
            render: function (data, type, row) {
              return '₹'+row.total_amt;
            }            
          },
          
          { "data": "payment_status",className: "text-center",
              render: function (data, type, row) {
                var html = '';
                var status = '';
                var addclass = '';
                var payment_status = row.payment_status;
                if (payment_status==1) {
                  status = 'Pending';
                  addclass = 'badge badge-warning'; 
                }
                else if(payment_status==2){
                  status = 'Paid';
                  addclass = 'badge badge-success'; 
                }
                else{
                  status = 'Cancel';
                  addclass = 'badge badge-danger'; 
                }

                html ='<span><a href="javascript:void(0)" class="'+addclass+'">'+status+'</span></a>'
                return html;
              }
          },         
          { "data": "action", sortable:!1,
            render: function (data, type, row) {
              var deletes = '<a onclick="triggerDelete('+row.id+')" href="javascript:void(0)"><img src="'+imagepath+'/ic_delete.png"></a>';
              var edit = '<a href="'+base_url+'/admin/bill/edit/'+row.id+'"><img src="'+imagepath+'/ic_mode_edit.png"></a>';
              var downloadbill = '<a href="'+base_url+'/admin/customer/download/singlebill/'+row.id+'"><img src="'+imagepath+'/download.png"></a>';
              var whatsapp = '<a href="https://wa.me/91'+row.customer.mobile+'" target="_blank"><img src="'+imagepath+'/icons8-whatsapp-18.png"></a>';
              return  edit + '&nbsp;&nbsp;&nbsp;'+ deletes+'&nbsp;&nbsp;&nbsp;<br>'+downloadbill + '&nbsp;&nbsp;&nbsp;' + whatsapp;;
            }
          },
      ],

    });
    /*Listing End*/
  
    $("#search").on('keyup', function () {
      $('#listing').DataTable().ajax.reload();
    });

    $("#payment_status").on('change',function () {
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
            url: base_url+'/admin/bill/add',
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
    url: base_url+'/admin/bill/status',
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
    url: base_url+'/admin/bill/destroy',
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


$(function() {
  /*On Check Product and Accssory*/
  $("input[name='check_pro']").on('change',function () {
    if($(this).is(':checked')){
      $(".product_box").removeClass('d-none');
    }
    else{
      $(".product_box").addClass('d-none');
      $(".cloned-products").empty();
      $(".product_id").val('');
    }
  });
  $("input[name='check_accc']").on('change',function () {
    if($(this).is(':checked')){
      $(".accessory_box").removeClass('d-none');
    }
    else{
      $(".accessory_box").addClass('d-none');
      $(".cloned-accessory").empty();
      $(".accessory_id").val('');
    }
  });
  /*End*/

  /*Product Cloning*/
  $(".addmoreproduct").on('click',function(){
    $(".clon-product:first").clone().appendTo("div.cloned-products");
    $(".remove_product:last").removeClass("d-none");
    $(".clon-product:last").find('select.product_id').val('');
    $(".clon-product:last").find('select.product_id').attr('required',true);
    $(".pro-quantity:last").val('');
  });
  /*End*/

  /*Accesoory Cloning*/
  $(".addmoreaccesory").on('click',function(){
    $(".clon-accessory:first").clone().appendTo("div.cloned-accessory");
    $(".remove_accessory:last").removeClass("d-none");
    $(".clon-accessory:last").find('select.accessory_id').val('');
    $(".clon-accessory:last").find('select.accessory_id').attr('required',true);
  });
  /*End*/

});

/*Accessory */
$(document).on("change","select.accessory_id",function () {
  var price = $(this).find('option:selected').attr('data-price');
  $(this).parent().find("input.aceprice").val(price);
  amountCal();
})

$(document).on("click",".remove_accessory",function () {
    $(this).parent().remove();  
    amountCal();
});

/*Products */
$(document).on("change","select.product_id",function () {
  var price = $(this).find('option:selected').attr('data-price');
  $(this).parent().find("input.proprice").val(price);
  amountCal();
})

$(document).on("click",".remove_product",function () {
    $(this).parent().remove();  
    amountCal();
});


$(document).on("change","input[name='service_amount']",function () {
    amountCal();
});

$(document).on("change","input[name='discount']",function () {
    amountCal();
});

/*On Change Product Quantity && Accessories Quantity*/

$(document).on("keyup","input.pro-quantity",function () {
   amountCal(); 
});

$(document).on("keyup","input.acc-quantity",function () {
   amountCal(); 
});
/*end*/
  

function amountCal() {
  /*Product amount */
  var aproduct_price = $('input[name="product_price[]"]').map(function(){return $(this).val();}).get();
  var aproduct_qty = $('input[name="quantity[]"]').map(function(){return $(this).val();}).get();
  var acce_qty = $('.acc-quantity').map(function(){return $(this).val();}).get();

  var total = 0;
  for (var i = 0; i < aproduct_price.length; i++) {
      total += aproduct_price[i]*parseInt(aproduct_qty[i]) << 0;
  }

  /*Accessories amount */
  var aAccesoryPrice = $('input[name="accessory_price[]"]').map(function(){return $(this).val();}).get();

  for (var i = 0; i < aAccesoryPrice.length; i++) {
      total += parseInt(aAccesoryPrice[i])*parseInt(acce_qty[i]) << 0;
  }


  var service_amount = $("input[name='service_amount']").val();
  if (service_amount) {
    total = parseInt(total)+parseInt(service_amount);
  }
  
  $("input[name='sub_amount']").val(total);
  
  var discount = $("input[name='discount']").val();
  if (discount) {
    total = total-discount;
  }

  $("input[name='total_amount']").val(total);
  
}

