<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physical Count Monitoring System</title>
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
    <style>
		.search-results-header{
			box-shadow: 5px 5px 5px #ccc; 
			margin-top: -1px; 
			background-color: #F1F1F1;
			width : 90%;
			border-radius: 3px 3px 3px 3px;
			font-size: 16px;
			padding: 8px 10px;
			display: block;
			position:absolute;
			z-index:9999;
            /* overflow:auto; */
			max-height:300px;
			overflow-y:scroll;
            overflow-x:hidden;			 
		}
		.search-results-header { display: none; }
        .search-results-header1{
			box-shadow: 5px 5px 5px #ccc; 
			margin-top: -1px; 
			background-color: #F1F1F1;
			width : 90%;
			border-radius: 3px 3px 3px 3px;
			font-size: 16px;
			padding: 8px 10px;
			display: block;
			position:absolute;
			z-index:9999;
            /* overflow:auto; */
			max-height:300px;
			overflow-y:scroll;
            overflow-x:hidden;			 
		}
		.search-results-header1 { display: none; }
		.afont{  color: black;   }
		.afont:hover{  color: red; cursor:pointer;  }
	</style>
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
                                <span class="text-muted text-xs block"><?php echo $this->session->userdata('usertype');?></span>
                            </a>
                            <!-- <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                                <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                                <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" onclick="btn_logOut()">Logout</a></li>
                            </ul> -->
                        </div>
                        <div class="logo-element">
                            BS+
                        </div>
                    </li>
                   <!--  <li class="<?php if($page_title == 'dashboard'){ echo "active"; }?>">
                        <a href="dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li> -->
                    <li class="<?php if($page_title == 'book_setup' || $page_title ==  'location_setup' || $page_title == 'user_setup'){ echo "active"; }?>">
                        <a href=""><i class="fa fa-wrench"></i> <span class="nav-label">Setup</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">                            
                            <li class="<?php if($page_title == 'location_setup'){ echo "active"; }?>"><a href="location_setup">Location</a></li>
                            <li class="<?php if($page_title == 'user_setup'){ echo "active"; }?>"><a href="user_setup">User Setup</a></li>
                           
                        </ul>
                    </li>
                    <!-- <li class="<?php if($page_title == 'book_setup' || $page_title ==  'discount_setup' || $page_title == 'user_setup'){ echo "active"; }?>">
                        <a href=""><i class="fa fa-folder"></i> <span class="nav-label">ADMIN</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            
                            <li class="<?php if($page_title == 'user_setup'){ echo "active"; }?>"><a href="user_setup">User Setup</a></li>
                           
                        </ul>
                    </li> -->
                    <li class="<?php if($page_title == 'upload_csv'){ echo "active"; }?>">
                        <a href=""><i class="fa fa-file"></i> <span class="nav-label">CSV File</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if($page_title == 'upload_csv'){ echo "active"; }?>"><a href="upload_csv">Upload File</a></li>
                        </ul>
                    </li>
                    <li class="<?php if($page_title == 'point_of_sale' || $page_title ==  'home_request' || $page_title == 'adjustment' || $page_title == 'reservation'){ echo "active"; }?>">
                        <a href=""><i class="fa fa-cogs"></i> <span class="nav-label">Transaction </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php if($page_title == 'for_count'){ echo "active"; }?>"><a href="for_count">Upload File For Counting</a>
                            </li>
                          <!--   <li class="<?php if($page_title == 'store_conso'){ echo "active"; }?>"><a href="<?base_url("application/views/store_consolidation/pages/store_conso.php")?>">Link to item consolidation</a>
                            </li> -->
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
                                <input type="text" placeholder="Search Location..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome <?php echo $this->session->userdata('user_name');?>.</span>
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
                    <h2></h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            
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