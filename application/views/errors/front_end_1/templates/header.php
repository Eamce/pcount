
<!doctype html>
<html lang="en">
<head>
    <title><?php echo $page_data->page_title;?> | HRS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" href="<?php echo base_url();?>images/favicon.png" type="image/x-icon">

    <!-- Google Fonts -->   
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i%7CPlayfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">

    <!-- Bootstrap Stylesheet -->   
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">

    <!-- Font Awesome Stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">

    <!-- Custom Stylesheets --> 
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" id="cpswitch" href="<?php echo base_url();?>assets/css/yellow.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/responsive.css">
    
    <!-- Owl Carousel Stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.theme.css">

    <!-- Flex Slider Stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/flexslider.css" type="text/css" />

    <!--Date-Picker Stylesheet-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css">

    <!-- Magnific Gallery -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/magnific-popup.css">
    
    <!-- Color Panel -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.colorpanel.css">
    <link href="<?php echo base_url();?>assets_2/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
</head>


<body>

    <!--====== LOADER =====-->
    <div class="loader"></div>


    <!--========== COLOR-PANEL ==========-->
    <div id="colorPanel" class="colorPanel">
        <a id="cpToggle" href="#"></a>
        <ul></ul>
    </div><!-- end colorPanel -->
    
    
    <!--========== TOP-BAR ==========-->
    <div id="top-bar">
        <div class="container">
            <div class="row">          
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div id="info">
                        <ul class="list-unstyled list-inline">
                            <li><span><i class="fa fa-map-marker"></i></span>29 Land St, Lorem City, CA</li>
                            <li><span><i class="fa fa-phone"></i></span>+00 123 4567</li>
                        </ul>
                    </div><!-- end info -->
                </div><!-- end columns -->

                <!-- end columns -->              
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end top-bar -->


    <!--== HOME CONTAINER ===-->
<?php if($page_data->page_route == 'home_page'): ?> 
<div class="home-container">
      <div id="header-bottom"> 
<?php endif ?>
    
            <nav class="navbar navbar-default <?php if($page_data->page_route == 'home_page'){ echo 'transparent-nav'; }else{ 
            echo 'black-nav'; }?> navbar-custom black-menu" id="mynavbar">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>                        
                      </button>
                      <a href="#" class="navbar-brand"><span>Safari</span>Hotel</a>
                  </div><!-- end navbar-header -->

                  <div class="collapse navbar-collapse" id="myNavbar1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown <?php if($page_data->page_route == 'home_page'){ echo 'active'; }?>"><a href="<?php echo base_url();?>home_page">Home</a></li>
                        <li class="dropdown <?php if($page_data->page_route == 'room_page'){ echo 'active'; }?>"><a href="<?php echo base_url();?>room_page">Rooms</a></li>
                        <li class="dropdown <?php if($page_data->page_route == 'services_page'){ echo 'active'; }?>"><a href="<?php echo base_url();?>services_page">Services</a></li>
                        <li class="dropdown <?php if($page_data->page_route == 'contact_us_page'){ echo 'active'; }?>"><a href="<?php echo base_url();?>contact_us_page">Contact Us</a></li>
                        <li class="dropdown <?php if($page_data->page_route == 'about_us_page'){ echo 'active'; }?>"><a href="<?php echo base_url();?>about_us_page">About Us</a></li>
                        
                        <li><a href="#">Book Now</a></li>
                    </ul>
                </div><!-- end navbar collapse -->
            </div><!-- end container -->
        </nav><!-- end navbar -->
        <?php if($page_data->page_route == 'home_page'): ?> 
    </div><!-- end header-bottom -->

    <div class="flexslider" id="slider">
        <ul class="slides">
            <li class="item-1"></li>
            <li class="item-2"></li>
        </ul><!-- end slides -->
<?php endif ?>