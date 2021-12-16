

$(function() {


/*ON CLick tabs change Text*/
$("li.nav-item.tabs a").on('click',function(){
    var vals = $(this).text();
    $('.title').html('Settings > '+vals);  
});
/*END*/

//LOGO IMAGES
$(document).on('change',"#upload_profile", function () {
  var tempId = "#img";
  var defaultImg = base_url+"/public/images/user.png";
  var fileId = "#upload_profile";
  selectProfileDocImage(this,defaultImg,fileId,tempId);
});

$(document).on('change',"#login_upload_profile", function () {
  var tempId = "#login_img";
  var defaultImg = base_url+"/public/images/user.png";
  var fileId = "#login_upload_profile";
  selectProfileDocImage(this,defaultImg,fileId,tempId);
});

function selectProfileDocImage(input,defaultImg,fileId,tempId){
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var filename = input.files[0].name;
      var fileExtension = filename.substr((filename.lastIndexOf('.') + 1));
      var fileExtensionCase = fileExtension.toLowerCase();
      if (fileExtensionCase == 'png' || fileExtensionCase == 'jpeg' || fileExtensionCase == 'jpg' ) {
        reader.onload = function (e) {
            jQuery(tempId).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);        
      }
      /*else if (fileExtensionCase == 'pdf' || fileExtensionCase == 'doc' || fileExtensionCase == 'txt' || fileExtensionCase == 'docx') {
        jQuery(tempId).attr('src',defaultImg);
      }*/
      else{
        toastr.error("Not a valid Extension!");
        $(fileId).val('');
        $(tempId).attr('src', defaultImg);
      }
  }
}


// LOGO FORM
$("form[name='logo-form']").validate({
  errorClass: "error_msg",
   rules: {
      
   },
    submitHandler: function(form, event) {
    event.preventDefault();
    showLoader(true);
    var formData = new FormData($(form)[0]);
    updateSetting(formData);
  }
});


// general setting FORM
$("form[name='general-form']").validate({
    errorClass: "error_msg",
    rules: {
      
    },
    submitHandler: function(form, event) {
    event.preventDefault();
    showLoader(true);
    
    var formData = new FormData($(form)[0]);
    updateSetting(formData);
  }
});


function updateSetting(formData) {
  $.ajax({
      url: base_url+'/admin/setting/update',
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