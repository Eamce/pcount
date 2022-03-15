<script type="text/javascript"> 

  $('#tbl_update_monthly').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax":{
    "url": '<?php echo base_url('request/tbl_update_monthly')?>',
    "dataType": "json",
    "type": "POST"
    },
    "columns": [
        { "data": "count" },
        { "data": "file_name" },
        { "data": "company" },
        { "data": "business_unit" },
        { "data": "department" },
        { "data": "section" },
        { "data": "action" }
      ]
  });

  function getBunit(cid){
    if(cid){
      $.ajax({
        url: "<?php echo base_url('request/get_bunit')?>",
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
          $('[name="section"]').html('<option value="" disabled selected>Select</option>');
        }
      });
    }        
  }

  function getDept(bid){
    if(bid){
      $.ajax({
        url: "<?php echo base_url('request/get_dept')?>",
        type:"POST",
        data: {bid:bid},
        dataType:'json',
        success:function(data){
          var mhtml="";
          mhtml += '<option value="" disabled selected>Select</option>';
          $.each(data.data, function(index, element){
            mhtml += "<option value='"+element.dcode+"/"+element.bcode+"/"+element.ccode+"/"+element.dname+"'>"+element.dname+"</option>"; 
          });
          $('[name="dept"]').html(mhtml);
        }
      });
    }
  }

  function getDept_(bid){
    if(bid){
      $.ajax({
        url: "<?php echo base_url('request/get_dept_')?>",
        type:"POST",
        data: {bid:bid},
        dataType:'json',
        success:function(data){
          var mhtml="";
          mhtml += '<option value="" disabled selected>Select</option>';
          $.each(data.data, function(index, element){
            mhtml += "<option value='"+element.dcode+"/"+element.ccode+"/"+element.dname+"'>"+element.dname+"</option>"; 
          });
          $('[name="dept"]').html(mhtml);
        }
      });
    }
  }

  function getSection(did){
    if(did){
      $.ajax({
        url: "<?php echo base_url('request/get_section')?>",
        type:"POST",
        data: {did:did},
        dataType:'json',
        success:function(data){
          var mhtml="";
          mhtml += '<option value="" disabled selected>Select</option>';
          $.each(data.data, function(index, element){
            mhtml += "<option value='"+element.scode+"/"+element.dcode+"/"+element.bcode+"/"+element.ccode+"/"+element.sname+"'>"+element.sname+"</option>";          
          });
          $('[name="section"]').html(mhtml);
        }
      });
    }
  }

  function btn_update_monthly(loc_id, filename, user_id){
    $('#loc_id').val(loc_id);
    $('#user_id').val(user_id);
    $('#file_name').val(filename);
    $('#modaltitle').val(filename);
    $('#myModal_update').modal('show'); 
  }

  function report_btn(){
    var loc_id = $('#loc_id').val(); console.log(loc_id); alert(loc_id);
    var user_id = $('#user_id').val(); console.log(user_id); alert(user_id);
    var file_name = $('#file_name').val(); console.log(file_name); alert(file_name);

    $.ajax({
      url:'request/monthly_updated_report',
      method:'POST',
      data:{loc_id:loc_id,
            user_id:user_id,
            file_name:file_name
          },
      success:function(msg){

        $("#pageloader").fadeOut(); 
        if(msg == 'error'){
          Command: toastr['info'](" error.. No data please upload exel file first");
          //setTimeout("window.location.reload();",2000);
        }else{
          Command: toastr['info'](msg);
           setTimeout("window.location.reload();",2000);
        }
      }
    });
  }

   $('form#fileUploadForm_2').submit(function(e){
      
    var loc_id = $('#loc_id').val(); //console.log(loc_id); alert(loc_id);
    var user_id = $('#user_id').val(); //console.log(user_id); alert(user_id);

    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url:'request/generate_variance', //update_monthly_data
      method:'POST',
      data:formData,
      success:function(msg){ 

      $('input[type=file]').val('');

      $("#pageloader").fadeOut(); 

        if(msg == 'success'){
        
          Command:toastr['success']("file updated successfully.");
          //setTimeout("window.location.reload();",2000);
        }else{
          Command:toastr['info'](msg);
          //setTimeout("window.location.reload();",6000);
        }
      },
      async: false,
      cache: false,
      contentType: false,
      processData: false
    });
  });

  $('form#fileUploadForm3').submit(function(e){

    $('#company').prop('disabled', false);
    $('#bunit').prop('disabled', false);
    $('#dept').prop('disabled', false);
    $('#section').prop('disabled', false);

    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();

    e.preventDefault();

    var formData = new FormData(this);
    
    $.ajax({
      url:'request/upload_exel_file',
      method:'POST',
      data:formData,
      success:function(msg){ 
      //$('#fileUploadForm3')[0].reset();
      $('#company').prop('disabled', true);
      $('#bunit').prop('disabled', true);
      $('#dept').prop('disabled', true);
      $('#section').prop('disabled', true);

      $('input[type=file]').val('');

      $("#pageloader").fadeOut(); 

        if(msg == 'success'){
        
          Command:toastr['success']("file uploaded successfully.");
          setTimeout("window.location.reload();",2000);
        }else{
          Command:toastr['info'](msg);
          //setTimeout("window.location.reload();",6000);
        }
      },
      async: false,
      cache: false,
      contentType: false,
      processData: false
    });
  });

</script>