 
                <div id="hero-main">
                    <div class="hero-content">
                        <div class="text-align">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h1 id="welcome">Welcome To Safari Hotel</h1>
                                        <h3 id="tagline">Enjoy Your Life With Us!</h3>
                                        <div class="hero-text">
                                            <form method="POST" action="check_availability_page">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                                        <div class="form-group">    
                                                            <input type="text" class="form-control dpd1" name="date_in" id="date_in" placeholder="Arrival Date" required/>
                                                            <span><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div><!-- end columns -->
                                                    
                                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dpd2" name="date_out" id="date_out" placeholder="Departure Date" required/>
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
                                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
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
                                                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                    <?php
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div><!-- end columns -->
                                                    
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                        <button type="submit" class="btn btn-default btn-lg btn-padding">Check Availability</button>
                                                    </div><!-- end columns -->
                                                    
                                                </div><!-- end row -->
                                            </form>
                                        </div><!-- end hero text -->
                                    </div><!-- end col-sm-12 -->
                                </div><!-- end row -->
                            </div><!-- end container -->
                        </div><!-- end text align -->
                    </div><!-- end hero content -->
                </div><!-- end hero main -->
            </div><!-- end slider -->
        </div><!-- end home-container -->
        
        
        <!--=============== ABOUT ===============-->
        <section id="about"> 
            <div class="container">
                <div class="row" id="about-img">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="about-text">
                        <h2>About Safari Hotel</h2>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        <a href="<?php echo base_url()?>about_us_page" class="btn btn-lg btn-padding">View More</a>
                    </div><!-- end columns -->
                                        
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    
                    </div><!-- end columns -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end about -->
        <!--================ ROOMS ==============-->
        <section id="rooms" class="section-padding"> 
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="page-heading">
                            <h2>Our <span>Best Rooms</span></h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                        </div><!-- end page-heading -->
                        
                        <div class="owl-carousel owl-theme" id="owl-rooms">
                            
                            
                                <?php foreach ($rt_data as $key => $value): ?>
                                    <div>
                                   <div class="grid">
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
                                </div><!-- end grid --> 
                            </div><!-- end item -->
                                <?php endforeach ?>
                        </div><!-- end owl-rooms -->
                    </div><!-- end columns -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end rooms -->
        <!--================ SERVICES ==============-->
        <section id="services" class="section-padding"> 
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="page-heading">
                            <h2>Our <span>Awesome Services</span></h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        </div><!-- end page-heading -->
                        
                        <div class="row">
                            <div id="service-blocks">

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="service-block">
                                        <span><i class="fa fa-coffee"></i></span>
                                        <h2 class="service-name">Restaurant</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti sit dicta quae natus quasi ratione quis id, tenetur atque blanditiis.</p>
                                    </div><!-- end service-block -->
                                </div><!-- end columns -->

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="service-block">
                                        <span><i class="fa fa-leaf"></i></span>
                                        <h2 class="service-name">Spa</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti sit dicta quae natus quasi ratione quis id, tenetur atque blanditiis.</p>
                                    </div><!-- end service-block -->
                                </div><!-- end columns -->

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="service-block">
                                        <span><i class="fa fa-users"></i></span>
                                        <h2 class="service-name">Meeting Rooms</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti sit dicta quae natus quasi ratione quis id, tenetur atque blanditiis.</p>
                                    </div><!-- end service-block -->
                                </div><!-- end columns -->

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="service-block">
                                        <span><i class="fa fa-wifi"></i></span>
                                        <h2 class="service-name">Free Wifi</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti sit dicta quae natus quasi ratione quis id, tenetur atque blanditiis.</p>
                                    </div><!-- end service-block -->
                                </div><!-- end columns -->
                            </div><!-- end service-blocks -->
                        </div><!-- end row -->
                        
                        <div class="butn text-center">
                            <a href="services.html" class="btn btn-lg btn-padding btn-g-border">More Services</a>
                        </div><!-- end butn -->
                        
                    </div><!-- end columns -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end services -->
        
        <!--===================== PHOTO-GALLERY ===================-->
        <section id="photo-gallery" class="section-padding no-pd-top"> 
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="page-heading">
                            <h2>Picture <span>Gallery</span></h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        </div><!-- end page-heading -->
                        
                        <div id="filter-buttons" class="text-center">
                            <button class="btn filter-button active" data-filter="filter">Cafe</button>
                            <button class="btn filter-button first-btn" data-filter="meeting">Meeting Rooms</button>
                            <button class="btn filter-button" data-filter="spa">SPA</button>
                            <button class="btn filter-button" data-filter="pool">Pool</button>
                            <button class="btn filter-button" data-filter="deluxe">Deluxe Rooms</button>
                        </div><!-- end filter-buttons -->
                    </div><!-- end columns -->
                </div><!-- end row -->
            </div><!-- end container -->
            
            
            <div class="container-fluid no-padding">
                <div class="row">
                    <div id="gallery">
                    
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter work video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-1.jpg" title="image-1" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-1.jpg" alt="image-1">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
            
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter cafe video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-2.jpg" title="image-2" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-2.jpg" alt="image-2">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter spa video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-3.jpg" title="image-3" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-3.jpg" alt="image-3">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter pool video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-4.jpg" title="image-4" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-4.jpg" alt="image-4">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter room video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-5.jpg" title="image-5" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-5.jpg" alt="image-5">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter deluxe video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-6.jpg" title="image-6" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-6.jpg" alt="image-6">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter deluxe video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-7.jpg" title="image-7" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-7.jpg" alt="image-7">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter deluxe video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-8.jpg" title="image-8" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-8.jpg" alt="image-8">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter meeting video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-9.jpg" title="image-9" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-9.jpg" alt="image-9">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                        <div class="gallery-product col-xs-12 col-sm-4 col-md-3 col-lg-15  filter cafe video no-padding">
                            <div class="gallery-block">
                                <a href="<?php echo base_url();?>assets/images/gallery-10.jpg" title="image-10" class="with-caption image-link">
                                    <div class="gallery-img">
                                        <img class="img-responsive" src="<?php echo base_url();?>assets/images/gallery-10.jpg" alt="image-10">
                                        
                                        <div class="gallery-mask">
                                            <div class="gallery-title">
                                                <h2>Spa and Beauty</h2>
                                                <p>2 Pictures</p>
                                            </div>  <!-- end gallery-title -->            
                                        </div><!-- end gallery-mask -->
                                    </div><!-- end gallery-img -->
                                </a>
                            </div><!-- end gallery-block -->
                        </div><!-- end gallery-product -->
                        
                    </div><!-- end gallery -->  
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end gallery -->
 