<script type="text/javascript">
	$(document).ready(function(){
   tbl_user = $('#user_tbl').DataTable({
    destroy:true,
    'ajax':'<?php echo base_url('user/get_all_user_data')?>',
    pageLength: 25,
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: []
  });
   $('form#fileUploadForm').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url:'user/add_user_data',
      method:'POST',
      data:formData,
      dataType:'json',
      success:function(msg){
        if(msg == 'success'){
          Command: toastr['success']("User is successfully saved.");
          close_btn();
          $('#myModal4').modal('hide');
          tbl_user.ajax.reload(null, false);
        }else if(msg == 'error2'){
          $('#username').css({ 'border-color': 'red' });
          $('#username').unbind('focus').bind('focus', function() {
            $(this).removeAttr('style');
          });
          $('#password').css({ 'border-color': 'red' });
          $('#password').unbind('focus').bind('focus', function() {
            $(this).removeAttr('style');
          });
          Command: toastr['info']("Invalid Username and/or Password, please try again.");
        }else{
          if(msg == 'error1'){
            if($('#profile').val() == ''){
              $('#profile').css({ 'border-color': 'red' });
              $('#profile').unbind('focus').bind('focus', function() {
                $(this).removeAttr('style');
              });
            }
            if($('#username').val() == ''){
              $('#username').css({ 'border-color': 'red' });
              $('#username').unbind('focus').bind('focus', function() {
                $(this).removeAttr('style');
              });
            }
            if($('#password').val() == ''){
              $('#password').css({ 'border-color': 'red' });
              $('#password').unbind('focus').bind('focus', function() {
                $(this).removeAttr('style');
              });
            }
            if($('#usertype').val() == ''){
              $('#usertype').css({ 'border-color': 'red' });
              $('#usertype').unbind('focus').bind('focus', function() {
                $(this).removeAttr('style');
              });
            }
            if($('#uname').val() == ''){
              $('#uname').css({ 'border-color': 'red' });
              $('#uname').unbind('focus').bind('focus', function() {
                $('#uname').removeAttr('style');
              });
            }
            Command: toastr['info']("Fields must not be empty...");
          }
          else{
            Command: toastr['info'](msg);
          }
        }
      },
      async: false,
      cache: false,
      contentType: false,
      processData: false
    });
  });
 });

  function close_btn(){
    var nn = ['profile', 'uname', 'username', 'password', 'usertype'];
    for (var i = 0; i < 5; i++) {
      $('#'+nn[i]).val('');
      $('#'+nn[i]).removeAttr('style');
    }
  }
  
  function activation_act(stat, id){
    $.post('user/change_user_status', {stat:stat, id:id}, function(msg){
        if(msg == 'success'){
          if(stat == 1){
              Command: toastr['success']("User is successfully Activated.");
          }else{
              Command: toastr['success']("User is successfully Inactivated.");
          }
           tbl_user.ajax.reload(null, false);
        }else{
              Command: toastr['success'](msg);
        }
    });
  }

  function uTpye(a){
    if(a=="store_conso"){
      $("#locations").show();
      $.ajax({
          url: "<?php echo base_url('setup/get_company')?>",
          dataType:'json',
          async: false,
          cache: false,
          contentType: false,
          processData: false,
          success:function(data){
              var mhtml="";
            mhtml += '<option value="" disabled selected>Select</option>';
            $.each(data.data, function(index, element){
              mhtml += "<option value='"+element.loccode+"/"+element.locname+"'>"+element.locname+"</option>";					
            });
            $('[name="company"]').html(mhtml);
            $('[name="bunit"]').html('<option value="" disabled selected>Select</option>');
          }
      });
    }else{
      $('[name="company"]').html('<option value="" disabled selected>Select</option>');
      $('[name="dept"]').html('<option value="" disabled selected>Select</option>');
      $("#locations").hide();
    }
  }

  function getBunit(cid){
      if(cid){
          $.ajax({
              url: "<?php echo base_url('setup/get_bunit')?>",
              type:"POST",
              data: {cid:cid},
              dataType:'json',
              success:function(data){
                  var mhtml="";
                  mhtml += '<option value="" disabled selected>Select</option>';
                  $.each(data.data, function(index, element){
                      mhtml += "<option value='"+element.bcode+"/"+element.ccode+"/"+element.bname+"'>"+element.bname+"</option>";					
                  });
                  $('[name="bunit"]').html(mhtml);
              }
          });
      }        
    }
</script>

