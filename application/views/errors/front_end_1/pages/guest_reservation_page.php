       <style type="text/css">
           .emp_data{
            color: red;
            font-weight: bold;
            font-size: 18px;
        }
        .msz{
            color: red;
            font-weight: bold;
            font-size: 15px;
        }
    </style>
    <!--============= PAGE-COVER =============-->
    <section class="page-cover" id="reservation-cover">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                 <h1 class="page-title"><?php echo $page_data->page_heading;?></h1>
                 <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active"><?php echo $page_data->page_root;?></li>
                </ul>
            </div><!-- end columns -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end page-cover -->


<!--=============INNERPAGE-WRAPPER ===========-->
<section id="reservation-page" class="innerpage-wrapper">
 <div id="reservation" class="search-bar">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
             <div class="space-right">                      
                <div class="innerpage-heading">
                    <h1>Reservation</h1>
                </div><!-- end innerpage-heading -->

                <form>
                    <label><span class="msz">You must be reserve in (1) day advance.</span></label>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> First Name</label>
                            <div class="form-group">    
                                <input type="text" class="form-control" onkeypress="return nameOnly(event)" placeholder="First Name" id="fname" required/>
                                <span><i class="fa fa-user"></i></span>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Last Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" onkeypress="return nameOnly(event)" placeholder="Last Name" id="lname" required/>
                                <span><i class="fa fa-user"></i></span>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Email</label>
                            <div class="form-group">    
                                <input type="email" class="form-control" placeholder="Email" id="email" required/>
                                <span><i class="fa fa-envelope"></i></span>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Phone Number</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Phone Number ex.(09096513429)" id="pnum" maxlength="11" onkeypress="return numbersOnly(event)" required/>
                                <span><i class="fa fa-phone"></i></span>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Birth Date</label> 
                            <div class="form-group">
                                <input type="date" class="form-control dpd" placeholder="Birth Date" id="bday" required/>
                                <input type="hidden" name="age" id="age">
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                        </div><!-- end columns -->
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Country</label>
                            <div class="form-group">    
                                <input type="text" class="form-control typeahead_1" placeholder="Country" id="country" required/>
                                <span><i class="fa fa-flag"></i></span>
                            </div>
                        </div><!-- end columns -->
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Sex</label>
                            <div class="form-group">
                                <span><i class="fa fa-angle-down"></i></span>
                                <select class="form-control" id="gender">
                                    <option value="" hidden>Sex</option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data"></span> Company</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Company" id="company" required/>
                                <span><i class="fa fa-ge"></i></span>
                            </div>
                        </div><!-- end columns -->
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Arrival Date</label>
                            <div class="form-group">    
                                <input type="date" class="form-control" placeholder="Arrival Date"  id="dtfrom" required/>
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Departure Date</label>
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="Departure Date"  id="dtto" required/>
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> No. of Adults</label>
                            <div class="form-group">
                                <span><i class="fa fa-angle-down"></i></span>
                                <select class="form-control" id="adult">
                                    <option value="" hidden>Adults</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data"></span>  No. of Children</label>
                            <div class="form-group">
                                <span><i class="fa fa-angle-down"></i></span>
                                <select class="form-control" id="children">
                                    <option value="" hidden>Children</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div><!-- end columns -->

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span> Address</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Enter Address" id="address"></textarea>
                            </div>
                        </div><!-- end columns -->
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label><span class="emp_data">*</span>  Room No.</label>
                            <div class="form-group">
                                <span><i class="fa fa-angle-down"></i></span>
                                <select class="form-control" id="room_num" disabled>
                                    <option value="" hidden>Select Room No.</option>
                                </select>
                            </div>
                        </div><!-- end columns -->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label>Message</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Enter Message" id="notes"></textarea>
                            </div>
                        </div><!-- end columns -->
                        <input type="hidden" name="rtype_id" id="rtype_id" value="<?php echo $rtdata['roomtype_id']; ?>">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="button" class="btn btn-yellow btn_reserve" id="btn_reserve">Reserve Now</button>
                        </div><!-- end columns -->

                    </div><!-- end row -->
                </form>
            </div><!-- end space-right -->
        </div><!-- end columns -->

        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 side-bar">
         <div class="selected-room-block">
           <div class="selected-room-img">
               <img src="<?php echo base_url();?>assets_1/image/<?php echo $rtdata['roomtype_pic'];?>" class="img-responsive" alt="selected-room" />
           </div><!-- end selected-room-img -->

           <div class="selected-room-detail">
               <h2><?php echo $rtdata['roomtype'];?></h2>
               <div class="rating">
                <span><i class="fa fa-star"></i></span>
                <span><i class="fa fa-star"></i></span>
                <span><i class="fa fa-star"></i></span>
                <span><i class="fa fa-star"></i></span>
                <span><i class="fa fa-star-o"></i></span>
            </div><!-- end rating -->

            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt .</p>
            <ul class="selected-room-features list-unstyled">
                <?php foreach ($rtdata['amenity_data'] as $key => $value): ?>
                    <li><span><i class="fa fa-check"></i></span><p>
                        <?php echo $value['amenity'];?>
                    </p></li>
                <?php endforeach ?>


            </ul><!-- end features -->

            <p class="selected-room-price"><span> ₱ <?php echo number_format($rtdata['rate'],2);?></span> / Night</p>
        </div><!-- end selected-room-detail -->
    </div><!-- end selected-room-block -->
</div><!-- end columns -->
</div><!-- end row -->
</div><!-- end container -->
</div><!-- end reservation -->

<div id="reservation-details"> 
    <div class="container-fluid">
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 reservation-info">
              <div class="reserve-position center">
                <div class="innerpage-heading">
                    <h1>How to make reservation</h1>
                </div><!-- end innerpage-heading -->

                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                <p>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                <span class="hotel-name">The Star Hotel</span>
            </div><!-- end reserve-position -->
        </div><!-- end columns -->

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 reservation-support">
           <div class="center">
            <div class="innerpage-heading">
                <h1>Reservation Support</h1>
            </div><!-- end innerpage-heading -->

            <div class="support-list">
                <div class="icon"><span><i class="fa fa-envelope"></i></span></div>
                <div class="text">
                    <p>If you are on the go and still want to ask a question, simply drop us an e-mail.</p>
                    <p class="bold">support@SafariHotel.com</p>
                </div><!-- end text -->
            </div><!-- end support-list -->

            <div class="support-list">
                <div class="icon"><span><i class="fa fa-phone"></i></span></div>
                <div class="text phone">
                    <p>If you are on the go and still want to ask a question, simply drop us an e-mail.</p>
                    <p class="bold">+222 – 5548 656</p>
                </div><!-- end text -->
            </div><!-- end support-list -->

            <div class="support-list">
                <div class="icon"><span><i class="fa fa-map-marker"></i></span></div>
                <div class="text">
                    <p>Street No: 1234/A, Blu Vard Area, Main Double Road,</p>
                    <p class="bold">United Kingdom</p>
                </div><!-- end text -->
            </div><!-- end support-list -->

        </div><!-- end center -->
    </div><!-- end columns -->
</div><!-- end row -->
</div><!-- end container -->
</div><!-- end reervation-details -->

</section><!-- end innerpage-wrapper -->

<section id="invoice" class="innerpage-wrapper printableArea">
   
</section><!-- end innerpage-wrapper -->

