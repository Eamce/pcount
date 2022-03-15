<script type="text/javascript">
 function blockSpecialChars(x){
    var z;
    document.all ? z = x.keyCode : z = x.which;
    return ((z > 64 && z < 91) || (z > 96 && z < 123) || z == 46 || z == 44 || z == 8 || z == 32 || (z >= 48 && z <= 57));
  }
  function nameOnly(x){
    var z;
    document.all ? z = x.keyCode : z = x.which;
    return ((z > 64 && z < 91) || (z > 96 && z < 123) || z == 8 || z == 32);
  }
  function numbersOnly(x){
    var z;
    document.all ? z = x.keyCode : z = x.which;
    return (z >= 48 && z <= 57);
  }
  function blockSpecialCharsAdd(x){
    var z;
    document.all ? z = x.keyCode : z = x.which;
    return ((z > 64 && z < 91) || (z > 96 && z < 123) || z == 46 || z == 35 || z == 44 || z == 8 || z == 32 || (z >= 48 && z <= 57));
  }	
  function btn_logOut(){
    $('#myModal_logout').modal('show');
  }
  function logOut_action(){
    $('#myModal_logout').modal('hide');
    setTimeout("window.location.href='logOut'",2000);
    Command: toastr['success']("Logout successfully.");
  }
</script>