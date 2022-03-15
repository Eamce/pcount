<script type="text/javascript">
    $('form#fileUploadForm').submit(function(e){
     e.preventDefault();
     var formData = new FormData(this);
     $.ajax({
        url:'login/validate_login',
        method:'POST',
        data:formData,
        dataType:'json',
        success:function(msg){
            if(msg == 'invalid'){
                $('#msg_log').html('Invalid, username and/or password...');
                $('#msg_log').css({
                    'color': 'red',
                    'font-family': 'adobe hebrew'
                });  
                $('#username').css({ 'border-color': 'red' });
                $('#username').unbind('focus').bind('focus', function() {
                    $(this).removeAttr('style');
                    $('#msg_log').removeAttr('style');
                    $('#msg_log').html('');
                });
                $('#password').css({ 'border-color': 'red' });
                $('#password').unbind('focus').bind('focus', function() {
                    $(this).removeAttr('style');
                    $('#msg_log').removeAttr('style');
                    $('#msg_log').html('');
                });
            }else{
                $('#password').removeAttr('style');
                $('#username').removeAttr('style');
                $('#msg_log').html('');
                $('#btn_login').html('Please wait...');
                setTimeout('window.location.href = "'+msg+'";', 3000);
            }

        },
        async: false,
        cache: false,
        contentType: false,
        processData: false
    });
 });
</script>