<!DOCTYPE html>
<html>
<!-- Mirrored from chuibility.github.io/inspinia/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Dec 2019 03:52:33 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physical Count Monitoring System</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">SC+</h1>
            </div>
            <form class="m-t" enctype="multipart/form-data" method="POST" id="fileUploadForm">
                <div class="form-group">
                    <input type="text" class="form-control" autocomplete="off" placeholder="Username" name="username" id="username" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" autocomplete="off" placeholder="Password" name="password" id="password" required="">
                </div>
                <button type="submit" class="btn btn-primary ladda-button block full-width m-b" id="btn_login">Login</button>
                <span id="msg_log"></span>
                <!-- <a href="#"><small>Forgot password?</small></a> -->
            </form>
            <p class="m-t"> <small>Upper Room Studio | Store Consolidation &copy; <?php echo date('Y');?></small> </p>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>
<!-- Mirrored from chuibility.github.io/inspinia/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Dec 2019 03:52:33 GMT -->
</html>
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
