<script type="text/javascript"> 
$('#tbs_request_tbl').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax":{
    "url": '<?php echo base_url('request/data_report')?>',
    "dataType": "json",
    "type": "POST"
    },
    "columns": [
        { "data": "count" },
        //{ "data": "user_id" },
        { "data": "file_name" },
        //{ "data": "report_path" },
        { "data": "date_uploaded" },
        { "data": "action" }
        ]
  });  

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
 
 $('#tbl_cyclic_report').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax":{
    "url": '<?php echo base_url('request/tbl_cyclic_report')?>',
    "dataType": "json",
    "type": "POST"
    },
    "columns": [
        { "data": "count" },
        //{ "data": "user_id" },
        { "data": "file_name" },
        //{ "data": "report_path" },
        { "data": "date_uploaded" },
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

  function btn_download(report_id, file_name){
   
      window.open(`request/pdf_report?report_id=${report_id}&file_name=${file_name}`);
    return;
    $.ajax({
      url:'request/pdf_report',
      method:'POST',
      data:{report_id:report_id,
            file_name:file_name
           },
    }); 
  }

  function btn_download_cyclic(report_id, file_name){

     window.open(`request/cyclic_pdf_report?report_id=${report_id}&file_name=${file_name}`);
    return;
    
    $.ajax({
      url:'request/cyclic_pdf_report',
      method:'POST',
      data:{report_id:report_id,
            file_name:file_name
           },
      // success:function(msg){
      //   if(msg == "success"){
      //     Command:toastr['success']("downloading.");
      //     //setTimeout("window.location.reload();",2000);
      //   }else{
      //     Command:toastr['info'](msg);
      //     //setTimeout("window.location.reload();",2000);
      //   }
      //   // if(result.type == "success"){
      //   //   Command:toastr['success']("downloading. . .");
      //   // }else{
      //   //   Command:toastr['info'](msg);
      //   // }
      //   // $('#myModal_dL').modal('show');
      //   // //$('img').attr('src', data);
      //   // $('a').attr('href', data); 
      // }
    }); 
  }

    function btn_download_excel(report_id, file_name){

     window.open(`request/excel_report?report_id=${report_id}&file_name=${file_name}`);
    return;
    
    $.ajax({
      url:'request/cyclic_pdf_report',
      method:'POST',
      data:{report_id:report_id,
            file_name:file_name
           },
      // success:function(msg){
      //   if(msg == "success"){
      //     Command:toastr['success']("downloading.");
      //     //setTimeout("window.location.reload();",2000);
      //   }else{
      //     Command:toastr['info'](msg);
      //     //setTimeout("window.location.reload();",2000);
      //   }
      //   // if(result.type == "success"){
      //   //   Command:toastr['success']("downloading. . .");
      //   // }else{
      //   //   Command:toastr['info'](msg);
      //   // }
      //   // $('#myModal_dL').modal('show');
      //   // //$('img').attr('src', data);
      //   // $('a').attr('href', data); 
      // }
    }); 
  }

  $('.close_btn2').on('click', function(){
    clear_inputext();
  });


  $('form#fileUploadForm_2').submit(function(e){
      
    var loc_id = $('#loc_id').val(); console.log(loc_id); alert(loc_id);
    var user_id = $('#user_id').val(); console.log(user_id); alert(user_id);

    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url:'request/update_monthly_data',
      method:'POST',
      data:formData,
      success:function(msg){ 

      $('input[type=file]').val('');

      $("#pageloader").fadeOut(); 

        if(msg == 'success'){
        
          Command:toastr['success']("file uploaded successfully.");
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

  function clear_inputext(){
      $('#exelfile').val("");
      $('#exelfile').removeAttr('style');
     $('#myModal7').modal('hide');
    }

  function upload_file(id){
    $('#txtfile_id').val(id);
   // $('#btn2').hide();
    $('#myModal7').modal('show');
  }


function create_report(){
    // var loc_id = $('#loc_id').val(); console.log(loc_id); alert(loc_id);
    // var user_id = $('#user_id').val(); console.log(user_id); alert(user_id);
    // var file_name = $('#file_name').val(); console.log(file_name); alert(file_name);
    var company  = $('#company').children(':selected').text(); console.log(company); alert(company);
    var bunit    = $('#bunit').children(':selected').text();    console.log(bunit); alert(bunit);
    var dept     = $('#dept').children(':selected').text();    console.log(dept); alert(dept);
    var section  = $('#section').children(':selected').text(); console.log(section); alert(section);

    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();
    $.ajax({
      url:'request/report_monthly',
      method:'POST',
      data:{company:company,
            bunit:bunit,
            dept:dept,
            section:section
          },
      success:function(msg){

        $('#company').prop('selectedIndex',0);
        $('#bunit').prop('selectedIndex',0);
        $('#dept').prop('selectedIndex',0);
        $('#section').prop('selectedIndex',0);  

        $("#pageloader").fadeOut(); 
        if(msg == 'error'){
          Command: toastr['info'](" error.. No data please upload exel file first");
          //setTimeout("window.location.reload();",2000);
        }else{
          Command: toastr['info'](msg);
        }
      }
    });
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
        }
      }
    });
  }

  $('form#fileUploadForm_1').submit(function(e){
 
    $('#company').prop('disabled', false);
    $('#bunit').prop('disabled', false);
    $('#dept').prop('disabled', false);
    $('#section').prop('disabled', false);

    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();

    e.preventDefault();

    var formData = new FormData(this);
    
    $.ajax({
      url:'request/update_monthly',
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

  $('form#fileUploadForm4').submit(function(e){   
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url:'request/master_file',
      method:'POST',
      data:formData,
      success:function(msg){
        if(msg == 'success'){
          Command:toastr['success']("file successfully saved.");
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