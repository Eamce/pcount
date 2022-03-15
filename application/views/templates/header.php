<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore_System | <?php echo $page_title; ?></title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="assets/img/favicon.png" rel="icon" type="image/png">
     <link href="assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
     <link href="assets/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <!-- Data Table css -->
    <link href="assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="assets/circle_indicator_spinner/dist/jquery_spinner_min.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle" src="<?php echo $this->session->userdata('profile_pic');?>" style="width: 60px; height: 60px;" />
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold"><?php echo $this->session->userdata('user_name');?></span>
                                <span class="text-muted text-xs block"><?php echo $this->session->userdata('usertype');?> <b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                                <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                                <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" onclick="btn_logOut()">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            SC+
                        </div>
                    </li>
                    <li class="<?php if($page_title == 'dashboard'){ echo "active"; }?>">
                        <a href="dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <?php if($this->session->userdata('usertype')=="Admin"): ?>
                    <li class="<?php if($page_title == 'book_setup' || $page_title ==  'discount_setup' || $page_title == 'user_setup'){ echo "active"; }?>">
                        <a href=""><i class="fa fa-folder"></i> <span class="nav-label">File</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if($page_title == 'book_setup'){ echo "active"; }?>"><a href="book_setup">Book Setup</a></li>
                            <li class="<?php if($page_title == 'discount_setup'){ echo "active"; }?>"><a href="discount_setup">Discount Setup</a></li>
                            <li class="<?php if($page_title == 'user_setup'){ echo "active"; }?>"><a href="user_setup">User Setup</a></li>
                            
                        </ul>
                    </li>
                <?php endif;?>
                    <li class="<?php if($page_title == 'point_of_sale' ||  $page_title == 'adjustment' || $page_title == 'reservation'){ echo "active"; }?>">
                        <a href=""><i class="fa fa-cogs"></i> <span class="nav-label">Transaction </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">

                            <?php if($this->session->userdata('usertype')=="Admin"): ?>
                            <li class="<?php if($page_title == 'point_of_sale'){ echo "active"; }?>"><a href="point_of_sale">Point Of Sale</a></li>
                        <?php endif;?>


                            <?php if($this->session->userdata('usertype')=="Admin"): ?>
                            <li class="<?php if($page_title == 'adjustment'){ echo "active"; }?>"><a href="adjustment">Adjustment</a></li>
                        <?php endif;?>

                        <?php if($this->session->userdata('usertype')=="Admin"): ?>
                            <li class="<?php if($page_title == 'reservation'){ echo "active"; }?>"><a href="reservation">Reservation</a></li>
                        <?php endif;?>

                        </ul>
                    </li>
                    
                    <li class="<?php if($page_title == 'books_inquiry' || $page_title == 'sold_books' || $page_title == 'customers_log'){ echo 'active'; }?>">
                        <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Inquiry</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if($page_title == 'books_inquiry'){ echo "active"; }?>"><a href="books_inquiry">Books Inquiry</a></li>
                            <li class="<?php if($page_title == 'sold_books'){ echo "active"; }?>"><a href="sold_books">Sold Books</a></li>
                            <li class="<?php if($page_title == 'customers_log'){ echo "active"; }?>"><a href="customers_log">Customers Log</a></li>
                            
                        </ul>
                    </li>
                    <li class="<?php if($page_title == 'sales_report' || $page_title == 'stocks_report'){ echo 'active'; }?>">
                        <a href=""><i class="fa fa-desktop"></i> <span class="nav-label">Reports</span>  <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if($page_title == 'sales_report'){ echo "active"; }?>"><a href="sales_report">Sales Report</a></li>
                            <li class="<?php if($page_title == 'stocks_report'){ echo "active"; }?>"><a href="stocks_report">Stocks Report</a></li>
                        </ul>
                    </li>
                    
                </ul>

            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" action="#">
                            <div class="form-group">
                                <input type="text" placeholder="Search for Book..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome <?php echo $this->session->userdata('user_name');?>.</span>
                        </li>
                        <li><span class="m-r-sm text-muted welcome-message"><?php echo $this->session->userdata('usertype');?></span>. </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a class="dropdown-item float-left" href="profile.html">
                                            <img alt="image" class="rounded-circle" src="assets/img/a7.jpg">
                                        </a>
                                        <div>
                                            <small class="float-right">46h ago</small>
                                            <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="#" class="dropdown-item">
                                            <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                            <span class="float-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <div>
                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                            <span class="float-right text-muted small">12 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <div>
                                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                            <span class="float-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="#" class="dropdown-item">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a onclick="btn_logOut()">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2><?php echo $my_heading->page_heading;?></h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <?php echo $my_heading->page_root;?>
                        </li>
                        
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            
            <div class="modal inmodal" id="myModal_logout" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirmation</h4>
                        </div>
                            <div class="modal-body">
                                <h3 style="text-align: center; font-weight: bold;">Are you sure you want to logout?</h3>
                            </div>
                            <div class="modal-footer">
                                <button onclick="logOut_action()" class="btn btn-primary">Yes</button>
                                <button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                            </div>
                    </div>
                </div>
            </div>
<script type="text/javascript">
  
</script>