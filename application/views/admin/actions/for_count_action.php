<script type="text/javascript"> 
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
</script>
