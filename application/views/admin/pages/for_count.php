

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">

                <div class="ibox-title">
                  <h5><i class="fa fa-folder"></i> Upload master file</h5>
                    <div class="ibox-tools">

                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row" style="margin: 0px 8px 10px 8px;">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                      
                    </div>
                    <div id="For counting" class="tabcontent" >
                      <div  style="padding-right:328px; padding-left:328px; margin-top: 30px;">
                        <div id="pageloaders" hidden="">
                          <img src="<?php echo base_url("assets/images/loader.gif");?>" alt="processing..." />
                        </div>
                          <form enctype="multipart/form-data" method="POST" id="fileUploadForm_6">
                    
                          <input type="file" class="form-control" autocomplete="off" placeholder="browse excel file"  id="exelfile" name="exelfile"   required>
                                    
                           <div class="modal-footer">  
                             <button type="submit" class="btn btn-primary" id="btn_form">Submit</button>
                             <!--<button type="button" class="btn btn-white report_btn" id="report_btn" onclick="create_report()">Create  report</button>!-->
                          </div>
                        </form>
                      </div>
                  </div> 
                </div>
            </div>
        </div>
    </div>
</div>