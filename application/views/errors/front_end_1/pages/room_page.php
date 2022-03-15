        <!--============= PAGE-COVER =============-->
        <section class="page-cover" id="room-grid-cover">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                    	<h1 class="page-title"><?php echo $page_data->page_heading;?></h1>
                        <ul class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active"><?php echo $page_data->page_heading;?></li>
                        </ul>
                    </div><!-- end columns -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end page-cover -->
        <!--============= INNERPAGE-WRAPPER ============-->
        <section id="rooms-grid" class="innerpage-wrapper">
        
        	<div id="rooms" class="innerpage-section-padding"> 
                <div class="container">
                    <div class="row">
                         <?php foreach ($rt_data as $key => $value): ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="room-block">
                                <div class="room-img">
                                    <img src="<?php echo base_url();?>assets_1/image/<?php echo $value['roomtype_pic'];?>" class="img-reponsive" style="height: 280px; width: 380px;" alt="room-image" />
                                    <div class="room-title">
                                        <a href="#"><h3><?php echo $value['roomtype'];?></h3></a>
                                        <div class="rating">
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                        </div><!-- end rating -->
                                    </div><!-- end room-title -->
                                </div><!-- end room-img -->
                                
                                <div class="room-price">
                                    <ul class="list-unstyled">
                                        <form method="POST" action="room_details_page">
                                                    <li>
                                                        ₱ <?php echo number_format($value['rate'],2);?> / Night 
                                                        <span class="link">
                                                            <input type="hidden" name="rtype_id" id="rtype_id"value="<?php echo $value['roomtype_id'];?>">
                                                            <button class="btn" type="submit">View Details</button>
                                                        </span>
                                                    </li>
                                                </form>
                                    </ul>
                                </div><!-- end room-price -->
                            </div><!-- end room-block -->
                        </div><!-- end columns -->
                         <?php endforeach ?>
                    </div><!-- end row -->
                </div><!-- end container -->
            </div><!-- end rooms -->
            
        </section><!-- end innerpage-wrapper -->
        