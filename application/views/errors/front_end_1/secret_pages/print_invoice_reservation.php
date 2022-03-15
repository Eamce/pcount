
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
<div class="row" style="margin: 20px 20px 20px 20px;">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="row" style="padding: 20px 20px 20px 20px;">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h3 style="font-weight: bold;">Invoice</h3>
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <ul class="demo">
                  <li><b>Invoice Number</b></li>
                  <li><?php echo $trans_data->rcard_num;?></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="demo">
                  <li><b>Date/Time Of Issue</b></li>
                  <li><?php echo date('m-d-Y g:s:i a', strtotime($trans_data->DateTime_trans));?></li>
                </ul>
              </div>
            </div>
            <div class="row" style="margin-top: 10px;">
              <div class="col-md-6">
                <ul class="demo">
                  <li><b>Billing to</b></li>
                  <li><?php echo $trans_data->full_name;?></li>
                  <li><?php echo $trans_data->address;?></li>
                  <li><?php echo $trans_data->email;?></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="demo">
                  <li><b>Arrival Date: </b> <?php echo date('m-d-Y', strtotime($trans_data->check_in));?></li>
                  <li><b>Departure Date: </b> <?php echo date('m-d-Y', strtotime($trans_data->check_out));?></li>
                  <li><b>Company: </b><?php echo $trans_data->company;?></li>
                  <li><b>No. of Adult/s: </b><?php echo $trans_data->num_adults;?></li>
                  <li><b>No. of Children/s: </b><?php echo $trans_data->num_childs;?></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6"></div>
              <div class="col-md-6">
               <ul class="demo">
                <li><h3><b>SAFARI HOTEL</b></h3></li>
                <li><h5>29 Land St, Lorem City, CA</h5></li>
                <li><h5>info@safarihotel.com</h5></li>
                <li><h5>+00 123 4567</h5></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table" width="100%">
            <thead>
              <tr>
                <th>Description</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Price/Rate</th>
                <th style="text-align: right;">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($g_rooms as $key => $value): ?>
               <tr>
                <td>
                  <?php echo $value['room_num']."  --------------- ".$value['roomtype'];?> <br>
                  <?php echo $value['amenity'];?>
                </td>
                <td style="text-align: center;"><?php 
                $dt = strtotime( $trans_data->check_out) - strtotime($trans_data->check_in);
                $dt_diff = round($dt / (60 * 60 * 24));
                echo $dt_diff.'/ Night';
                ?>
              </td>
              <td style="text-align: right;">
                <?php 
                echo '₱ '.number_format($value['rate'],2).'/ Night';
                ?>
              </td>
              <td style="text-align: right;">
                <?php 
                $totz = $value['rate'] * $dt_diff;
                echo '₱ '.number_format($totz,2);
                ?>
              </td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-md-2"></div>
</div><!-- end row -->
    </div>
    <div class="col-md-2"></div>
</div>
<!-- Page Scripts Starts -->
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.colorpanel.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.flexslider.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url();?>assets/js/custom-gallery.js"></script>
<script src="<?php echo base_url();?>assets/js/custom-navigation.js"></script>
<script src="<?php echo base_url();?>assets/js/custom-date-picker.js"></script>
<script src="<?php echo base_url();?>assets/js/custom-flex.js"></script>
<script src="<?php echo base_url();?>assets/js/custom-owl.js"></script>
<!-- Page Scripts Ends -->
<!--Masked Input [ OPTIONAL ]-->
<script src="<?php echo base_url();?>assets_2/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>

<script src="<?php echo base_url();?>assets_1/plugins/masked-input/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url();?>assets_2/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url();?>assets_2/js/plugins/typehead/bootstrap3-typeahead.min.js"></script>
</body>
</html>
<script type="text/javascript">
    window.print();
    setTimeout("window.location.href='<?php echo base_url();?>home_page';", 3000);
</script>