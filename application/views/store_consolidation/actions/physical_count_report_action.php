<script type="text/javascript"> 


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

function physical_report(){

    $('#companys').prop('disabled', false);
    $('#bunits').prop('disabled', false);
    $('#depts').prop('disabled', false);
    $('#sections').prop('disabled', false);

    var company  = $('#companys').children(':selected').text();  console.log(company); alert(company);
    var bunit    = $('#bunits').children(':selected').text();    console.log(bunit); alert(bunit);
    var dept     = $('#depts').children(':selected').text();     console.log(dept); alert(dept);
    var section  = $('#sections').children(':selected').text();  console.log(section); alert(section);

    var date_from = $('#date_from').val(); console.log(date_from); alert(date_from);
    var date_to = $('#date_to').val();	console.log(date_to); alert(date_to);

    $('#pageloader').removeAttr('hidden');
    $("#pageloader").show();
    $.ajax({
      url:'request/physical_report',
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
</script>