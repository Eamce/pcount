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
        <!--============= SEARCH-BAR =============-->
<section class="search-bar">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <form method="POST" action="check_availability_page">
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                           <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">    
                                    <input type="text" class="form-control dpd1" value="<?php echo $search_data['date_in']?>" name="date_in" id="date_in" placeholder="Arrival Date" required/>
                                    <span><i class="fa fa-calendar"></i></span>
                                </div>
                            </div><!-- end columns -->

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <input type="text" class="form-control dpd2" value="<?php echo $search_data['date_out']?>" name="date_out" id="date_out" placeholder="Departure Date" required/>
                                    <span><i class="fa fa-calendar"></i></span>
                                </div>
                            </div><!-- end columns -->

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <span><i class="fa fa-angle-down"></i></span>
                                    <select class="form-control" name="adultz" id="adultz">
                                        <option value="" hidden>Adults</option>

                                        <?php for ($i=1; $i <= 4; $i++) { 
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if(floatval($search_data['adultz']) == floatval($i)){ echo "selected"; };?>><?php echo $i;?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                            </div><!-- end columns -->

                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <span><i class="fa fa-angle-down"></i></span>
                                    <select class="form-control" name="childrenz" id="childrenz">
                                        <option value="" hidden>Children</option>
                                        <?php for ($i=1; $i <= 4; $i++) { 
                                            ?>
                                            <option value="<?php echo $i;?>" <?php if(floatval($search_data['childrenz']) == floatval($i)){ echo "selected"; };?>><?php echo $i;?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                            </div><!-- end columns -->
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                        <button href="#" class="btn btn-default btn-black">Check Availability</button>
                    </div><!-- end columns -->

                </div><!-- end row -->
            </form>

        </div><!-- end columns -->
    </div><!-- end row -->
</div><!-- end container -->
</section><!-- end search-bar -->
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
                                        <a href="#"><h3><?php echo $value['roomtype'];?></h3> <span>[<?php echo $value['roomNumz'];?>] Room/s Available</span></a>
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
