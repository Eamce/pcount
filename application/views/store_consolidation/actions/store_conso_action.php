<script type="text/javascript"> 
tbs_request_tbl = $('#tbs_request_tbl').DataTable({
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

  tbl_cyclic_report = $('#tbl_cyclic_report').DataTable({
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

  function btn_download(report_id, file_name){
    $.ajax({
      url:'request/pdf_report',
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

  function btn_download_cyclic(report_id, file_name){

    
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

    $('#company').prop('disabled', false);
    $('#bunit').prop('disabled', false);
    $('#dept').prop('disabled', false);
    $('#section').prop('disabled', false);

    var company  = $('#company').children(':selected').text(); //console.log(company); alert(company);
    //var bunit    = $('#bunit').children(':selected').text();    //console.log(bunit); alert(bunit);
    var dept     = $('#dept').children(':selected').text();    //console.log(dept); alert(dept);
   // var section  = $('#section').children(':selected').text(); //console.log(section); alert(section);

    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();
    $.ajax({
      url:'request/report_monthly',
      method:'POST',
      data:{company:company,
            //bunit:bunit,
            dept:dept,
            //section:section
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
          //setTimeout("window.location.reload();",2000);
        }
      }
    });
  }

  function cyclic_report(){

    $('#companys').prop('disabled', false);
    $('#bunits').prop('disabled', false);
    $('#depts').prop('disabled', false);
    $('#sections').prop('disabled', false);

    var company  = $('#companys').children(':selected').text();    //console.log(company); alert(company);
    var bunit    = $('#bunits').children(':selected').text();    //console.log(bunit); alert(bunit);
    var dept     = $('#depts').children(':selected').text();       // console.log(dept); alert(dept);
    var section  = $('#sections').children(':selected').text();  //console.log(section); alert(section);

    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();
    $.ajax({
      url:'request/cyclic_report',
      method:'POST',
       data:{company:company,
            bunit:bunit,
            dept:dept,
            section:section
          },
      success:function(msg){

        $('#companys').prop('selectedIndex',0);
        $('#bunits').prop('selectedIndex',0);
        $('#depts').prop('selectedIndex',0);
        $('#sections').prop('selectedIndex',0); 

        $("#pageloader").fadeOut(); 
        if(msg == 'error'){
          Command: toastr['info'](" error.. No data please upload exel file first");
          //setTimeout("window.location.reload();",2000);
        }else{
          Command: toastr['info'](msg);
          //setTimeout("window.location.reload();",2000);
        }
      }
    });
  }

  function pcount_report(){
    $('#comp').prop('disabled', false);
    $('#bunits').prop('disabled', false);
    $('#departs').prop('disabled', false);
    $('#sections').prop('disabled', false);

    var company  = $('#comp').children(':selected').text();  
    var dept     = $('#departs').children(':selected').text();     

    console.log(company); alert(company);
    console.log(dept); alert(dept);
   
    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();
    $.ajax({
      url:'request/pcount_report',
      method:'POST',
       data:{company:company,
            dept:dept,
          },
      success:function(msg){

        $('#comp').prop('selectedIndex',0);
        $('#bunits').prop('selectedIndex',0);
        $('#departs').prop('selectedIndex',0);
        $('#sections').prop('selectedIndex',0); 

        $("#pageloader").fadeOut(); 
        if(msg == 'error'){
          Command: toastr['info'](" error.. No data please upload exel file first");
          //setTimeout("window.location.reload();",2000);
        }else{
          Command: toastr['info'](msg);
          //setTimeout("window.location.reload();",2000);
        }
      }
    });
  }

  $('form#fileUpload_pcount').submit(function(e){

    $('#companys').prop('disabled', false);
    $('#bunits').prop('disabled', false);
    $('#depts').prop('disabled', false);
    $('#sections').prop('disabled', false);
     
    $('#pageloaderr').removeAttr('hidden');
    $("#pageloaderr").show();

    e.preventDefault();

    var formData = new FormData(this);
    
    $.ajax({
      url:'request/pcount',
      method:'POST',
      data:formData,
      success:function(msg){ 

        $('#companys').prop('disabled', true);
        $('#bunits').prop('disabled', true);
        $('#depts').prop('disabled', true);
        $('#sections').prop('disabled', true);

        $('input[type=file]').val('');
        $("#pageloaderr").fadeOut(); 

        if(msg == 'success'){
          Command:toastr['success']("file successfully saved.");

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

  $('form#fileUploadForm5').submit(function(e){

    $('#companys').prop('disabled', false);
    $('#bunits').prop('disabled', false);
    $('#depts').prop('disabled', false);
    $('#sections').prop('disabled', false);
     
    $('#pageloaderr').removeAttr('hidden');
    $("#pageloaderr").show();

    e.preventDefault();

    var formData = new FormData(this);
    
    $.ajax({
      url:'request/upload_cyclic', //generate_pcount
      method:'POST',
      data:formData,
      success:function(msg){ 

        $('#companys').prop('disabled', true);
        $('#bunits').prop('disabled', true);
        $('#depts').prop('disabled', true);
        $('#sections').prop('disabled', true);

        $('input[type=file]').val('');
        $("#pageloaderr").fadeOut(); 

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

  $('form#fileUploadForm_nav').submit(function(e){
    $('#companyss').prop('disabled', false);
    //$('#bunits').prop('disabled', false);
    $('#deptss').prop('disabled', false);
    //$('#sections').prop('disabled', false);
    
    $('#pageloaderr_').removeAttr('hidden');
    $("#pageloaderr_").show();

    e.preventDefault();

    var formData = new FormData(this);
    
    $.ajax({
      url:'request/upload_nav',
      method:'POST',
      data:formData,
      success:function(msg){ 

        $('#companyss').prop('disabled', true);
        //$('#bunits').prop('disabled', true);
        $('#deptss').prop('disabled', true);
        //$('#sections').prop('disabled', true);

        $('input[type=file]').val('');
        $("#pageloaderr_").fadeOut(); 

        if(msg == 'success'){
          Command:toastr['success']("file successfully saved.");

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

  function nav_report(){
    $('#company').prop('disabled', false);
    $('#bunits').prop('disabled', false);
    $('#dept').prop('disabled', false);
    $('#sections').prop('disabled', false);

    var company  = $('#companyss').children(':selected').text();  console.log(company); alert(company);
    //var bunit    = $('#bunits').children(':selected').text();    console.log(bunit); alert(bunit);
    var dept     = $('#deptss').children(':selected').text();     console.log(dept); alert(dept);
    //var section  = $('#sections').children(':selected').text();  console.log(section); alert(section);

    $('#pageloaderr_').removeAttr('hidden');
    $("#pageloaderr_").show();
    $.ajax({
      url:'request/nav_report',
      method:'POST',
       data:{company:company,
            //bunit:bunit,
            dept:dept,
            //section:section
          },
      success:function(msg){

        $('#company').prop('selectedIndex',0);
        $('#bunits').prop('selectedIndex',0);
        $('#dept').prop('selectedIndex',0);
        $('#sections').prop('selectedIndex',0); 

        $("#pageloaderr_").fadeOut(); 
        if(msg == 'error'){
          Command: toastr['info'](" error.. No data please upload exel file first");
          //setTimeout("window.location.reload();",2000);
        }else{
          Command: toastr['info'](msg);
          //setTimeout("window.location.reload();",2000);
        }
      }
    });
  }

  $('form#fileUpload_nav').submit(function(e){

    $('#company').prop('disabled', false);
    //$('#bunits').prop('disabled', false);
    $('#dept').prop('disabled', false);
    //$('#sections').prop('disabled', false);

    $('#pageloaderrs_').removeAttr('hidden');
    $("#pageloaderrs_").show();

    e.preventDefault();

    var formData = new FormData(this);

    var df = formData.get("date_from");
    var dt = formData.get("date_to");
    
    var month_year = new Date(dt).toLocaleString('en-us',{month:'long', year:'numeric', day:'numeric'});
      alert(month_year );

    $.ajax({
      url:'request/file_nav',
      method:'POST',
      data:formData,
      success:function(msg){ 

        $('#company').prop('disabled', true);
        //$('#bunits').prop('disabled', true);
        $('#dept').prop('disabled', true);
        //$('#sections').prop('disabled', true);

        $('input[type=file]').val('');
        $("#pageloaderrs_").fadeOut(); 

        if(msg == 'success'){
          Command:toastr['success']("file successfully saved.");

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

  function nav_file_report(){
    $('#company').prop('disabled', false);
    $('#bunits').prop('disabled', false);
    $('#dept').prop('disabled', false);
    $('#sections').prop('disabled', false);

    var company  = $('#companyss_').children(':selected').text();  console.log(company); alert(company);
    //var bunit    = $('#bunits').children(':selected').text();    console.log(bunit); alert(bunit);
    var dept     = $('#deptss_').children(':selected').text();     console.log(dept); alert(dept);
    //var section  = $('#sections').children(':selected').text();  console.log(section); alert(section);

    $('#pageloaderr_').removeAttr('hidden');
    $("#pageloaderr_").show();
    $.ajax({
      url:'request/nav_file_report',
      method:'POST',
       data:{company:company,
            //bunit:bunit,
            dept:dept,
            //section:section
          },
      success:function(msg){

        $('#company').prop('selectedIndex',0);
        $('#bunits').prop('selectedIndex',0);
        $('#dept').prop('selectedIndex',0);
        $('#sections').prop('selectedIndex',0); 

        $("#pageloaderr_").fadeOut(); 

        let res = JSON.parse(msg);

        console.log(res);
        //alert(msg);

        if(res.type == 'success'){
          Command: toastr['info'](res.msg);
          window.open(`request/display_temp_report?file=${res.file}`);
           return;
        }



        if(msg == 'error'){
          Command: toastr['info'](" error.. No data please upload exel file first");
          //setTimeout("window.location.reload();",2000);
        }else{
          Command: toastr['info'](msg);
          //setTimeout("window.location.reload();",2000);
        }
      }
    });
  }

  // function nav_file_report(){
  //   $('#company').prop('disabled', false);
  //   $('#bunits').prop('disabled', false);
  //   $('#dept').prop('disabled', false);
  //   $('#sections').prop('disabled', false);

  //   var company  = $('#companyss_').children(':selected').text();  console.log(company); alert(company);
  //   //var bunit    = $('#bunits').children(':selected').text();    console.log(bunit); alert(bunit);
  //   var dept     = $('#deptss_').children(':selected').text();     console.log(dept); alert(dept);
  //   //var section  = $('#sections').children(':selected').text();  console.log(section); alert(section);

  //   $('#pageloaderr_').removeAttr('hidden');
  //   $("#pageloaderr_").show();
  //   $.ajax({
  //     url:'request/nav_file_report',
  //     method:'POST',
  //      data:{company:company,
  //           //bunit:bunit,
  //           dept:dept,
  //           //section:section
  //         },
  //     success:function(msg){

  //       $('#company').prop('selectedIndex',0);
  //       $('#bunits').prop('selectedIndex',0);
  //       $('#dept').prop('selectedIndex',0);
  //       $('#sections').prop('selectedIndex',0); 

  //       $("#pageloaderr_").fadeOut(); 
  //       if(msg == 'error'){
  //         Command: toastr['info'](" error.. No data please upload exel file first");
  //         //setTimeout("window.location.reload();",2000);
  //       }else{
  //         Command: toastr['info'](msg);
  //         //setTimeout("window.location.reload();",2000);
  //       }
  //     }
  //   });
  // }

  $('form#fileUploadForm_6').submit(function(e){

    $('#companys').prop('disabled', false);
    //$('#bunits').prop('disabled', false);
    $('#depts').prop('disabled', false);
    //$('#sections').prop('disabled', false);
     
    $('#pageloaders').removeAttr('hidden');
    $("#pageloaders").show();

    e.preventDefault();

    var formData = new FormData(this);
    
    $.ajax({
      url:'request/for_count',
      method:'POST',
      data:formData,
      success:function(msg){ 

        $('#companys').prop('disabled', true);
       // $('#bunits').prop('disabled', true);
        $('#depts').prop('disabled', true);
       // $('#sections').prop('disabled', true);

        $('input[type=file]').val('');
        $("#pageloaders").fadeOut(); 

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