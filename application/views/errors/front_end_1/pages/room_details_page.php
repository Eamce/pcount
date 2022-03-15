  <!--============= PAGE-COVER =============-->
  <section class="page-cover" id="room-details-cover">
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
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                        <button type="submit" class="btn btn-default btn-black">Check Availability</button>
                    </div><!-- end columns -->

                </div><!-- end row -->
            </form>

        </div><!-- end columns -->
    </div><!-- end row -->
</div><!-- end container -->
</section><!-- end search-bar -->
<!--=============INNERPAGE-WRAPPER ===========-->
<section id="room-details-page" class="innerpage-wrapper">

    <div id="room-details" class="innerpage-section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 content-side">

                    <div class="room-description">

                        <div id="room-inner-carousel" class="carousel slide" data-ride="carousel">

                            <div class="price-tag">
                                <p><span><?php echo '₱ '.number_format($rtdata['rate'],2);?> /</span> Per Night</p>
                            </div><!-- end price-tag -->
                            <div class="carousel-inner">

                                <div class="item active">
                                    <img src="<?php echo base_url();?>assets_1/image/<?php echo $rtdata['roomtype_pic'];?>" alt="Room Picture" style="width: 900px; height: 600px;">
                                </div><!-- end item -->

                            </div><!-- end carousel-inner -->
                        </div><!-- end room-inner-casrousel -->
                        <div id="room-facilities">
                            <div class="row">
                                <?php foreach ($rtdata['amenity_data'] as $key => $value): ?>
                                   <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2 no-padding">
                                    <div class="facility-block">
                                        <span><i class="fa fa-check"></i></span>
                                        <p><?php echo $value['amenity']?></p>
                                    </div><!-- end facility-block -->
                                </div><!-- end columns -->
                            <?php endforeach ?>
                        </div><!-- end row -->
                    </div><!-- end room-facilities -->
                    <div id="description">
                        <div class="innerpage-heading">
                            <h1><?php echo $rtdata['roomtype'];?></h1>
                            <span class="room-position">A Room with Sea View</span>
                        </div><!-- end innerpage-heading -->

                        <p>Lorem ipsum dolor sit amet, consectetur adipisi cing elit, sed do eius mod tempor incididunt ut labore et dolore magna aliqua. Ut the enim ad minim veniam, quis nostrud exer citation ullamco laboris nisi ut aliquip ex ea com modo conse quat. Duis aute irure dolor in reprehend erit in volupt ate velit esse cillum dolore eu fugiat nulla pari atur. Except eur sint occa ecat cupi datat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit volup tatem accusantium the doloremque lauda ntium, totam rem aper iam, eaque ipsa quae</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam aliquam placerat tortor at suscipit. Nunc iaculis libero a quam consequat molestie. Cras volutpat ornare lectus, ut pulvinar neque pretium eu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam aliquam placerat tortor at suscipit. Nunc iaculis libero a quam consequat molestie.</p>
                        <p>Cras volutpat ornare lectus, ut pulvinar neque pretium eu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam aliquam placerat tortor at suscipit. Nunc iaculis libero a quam consequat molestie.</p>
                        <form method="POST" action="guest_reservation_page">
                            <input type="hidden" name="rtype_id" id="rtype_id" value="<?php echo $rtdata['roomtype_id'];?>">
                            <button class="btn btn-yellow btn-lg btn-block" type="submit">Book Now</button>
                        </form>
                    </div><!-- end description -->

                </div><!-- end room-description -->
            </div><!-- end columns -->

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 side-bar">
                <div class="side-bar-block cart-highlight">
                    <p style="font-weight: bold;"><span><i class="fa fa-building"></i></span>Safari Hotel</p>
                </div><!-- end side-bar-block -->
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                        <div class="side-bar-block support-block">
                            <h3>Contact Support</h3>
                            <p class="query">If you have any question please don't hesitate to contact us</p>
                            <ul class="list-unstyled">
                                <li>
                                    <span><i class="fa fa-phone"></i></span>
                                    <div class="text">
                                        <p>+00 123 4567</p>
                                        <p>+00 123 4568</p>
                                    </div><!-- end text -->
                                </li>

                                <li>
                                    <span><i class="fa fa-envelope"></i></span>
                                    <div class="text">
                                        <p>info@SafariHotel.com</p>
                                        <p>support@SafariHotel.com</p>
                                    </div><!-- end text -->
                                </li>
                            </ul>
                        </div><!-- end side-bar-block -->
                    </div><!-- end columns -->
                </div><!-- end row -->
            </div><!-- end columns -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end room-details -->

<?php if ($rtdata['same_rt'] != NULL): ?>
    <div id="rooms" class="innerpage-section-padding no-pd-top"> 
        <div class="container">
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="innerpage-heading">
                        <h1>Similar Rooms</h1>
                    </div><!-- end innerpage-heading -->
                </div><!-- end columns -->
                <?php foreach ($rtdata['same_rt'] as $key => $value): ?>
                   <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="room-block">
                        <div class="room-img">
                            <img src="<?php echo base_url();?>assets_1/image/<?php echo $value['roomtype_pic'];?>" style="height: 280px; width: 380px;" class="img-reponsive" alt="room-image" />
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
<?php endif ?>


        </section><!-- end innerpage-wrapper -->