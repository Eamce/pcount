<style type="text/css">
    .bootstrap-tagsinput {
  width: 100% !important;
  text-align: left !important; ;
}

body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */

.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.emp_data{
         color: red;
         font-weight: bold;
         font-size: 18px;
}

</style>
<!-- page break !-->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
<!-- page break !-->  
                <div class="tab">
                  <!-- <button class="tablinks" onclick="tab_setup(event, 'Datatable')" id="defaultOpen">Monthly Reports</button> -->
                 <!--  <button class="tablinks" onclick="tab_setup(event, 'Monthly')"id="defaultOpen"> Consolidation w/ Cost </button> -->
                  <button class="tablinks" onclick="tab_setup(event, 'cyclic')"id="defaultOpen"> Physical Count </button>
                  <!-- <button class="tablinks" onclick="tab_setup(event, 'Nav Files')"> Nav FIles </button> -->
                  <button class="tablinks" onclick="tab_setup(event, 'NAV')"> NAV per store</button>
                  <button class="tablinks" onclick="tab_setup(event, 'Pcount')"> Consolidate Items </button>
                  <!--<button class="tablinks" onclick="tab_setup(event, 'Cyclic Reports')">Cyclic Reports</button>!-->
                </div>

                <div id="Datatable" class="tabcontent">
                  <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" id="tbs_request_tbl">
                             <thead>
                                 <tr>
                                     <th>Report No</th>
                                     <!--<th>User Id</th>!-->
                                     <th>File Name</th>
                                     <th>Date Uploaded</th>
                                     <th style="width: 30px;">Action</th>
                                 </tr>
                             </thead>
                         </table>
                     </div>
                </div>
       
                <div id="Monthly" class="tabcontent" >
                    <div  style="padding-right:328px; padding-left:328px; margin-top: 30px;">
                      <div id="pageloader" hidden="">
                        <img src="<?php echo base_url("assets/images/loader.gif");?>" alt="processing..." />
                      </div>
                      <form enctype="multipart/form-data" method="POST" id="fileUploadForm3">

                        <!--<div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date From: </label>
                          <div class="col-sm-9">

                              <input type="date" class="form-control" autocomplete="off" placeholder="browse excel file" id="date_from" name="date_from"  >

                          </div>
                        </div>

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date To: </label>
                          <div class="col-sm-9">

                              <input type="date" class="form-control" autocomplete="off" placeholder="browse excel file" id="date_to" name="date_to" >

                          </div>
                        </div>!-->

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Company: </label>
                          <div class="col-sm-9">
                            <select class="form-control" name="company" id="company" onchange="get_bunit(this.value)" required="true">
                              <option value=""  disabled selected>Select</option>
                                <?php foreach ($company_name as $key => $value): ?>
                                  <option value="<?php echo $value['company_code'].'/'.$value['acroname']; ?>"><?php echo $value['acroname'];?></option>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <p></p>

                         <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Business Unit: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="bunit" id="bunit" onchange="getDept(this.value)" required="true">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        <p></p>!
                        
                         <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Department: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="dept" id="dept"  required="true">
                                      <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        <p></p> 
                          <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Section: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="section" id="section" required="true">
                                        <option value="">Select</option>    
                                    </select>
                                </div>
                            </div>
                        <p></p>!
                        <input type="file" class="form-control" autocomplete="off" placeholder="browse excel file"  id="exelfile" name="exelfile"  required>
                
                        <div class="modal-footer">  
                          <button type="submit" class="btn btn-primary" id="btn_form">Submit</button>
                          <!-- <button type="button" class="btn btn-white report_btn" id="report_btn" onclick="create_report()">Create report</button> -->
                        </div>
                      </form>
                     </div>
                </div>  

                <div id="cyclic" class="tabcontent" >
                  <div  style="padding-right:328px; padding-left:328px; margin-top: 30px;">
                    <div id="pageloaderr" hidden="">
                      <img src="<?php echo base_url("assets/images/loader.gif");?>" alt="processing..." />
                    </div>
                      <form enctype="multipart/form-data" method="POST" id="fileUploadForm5">

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date From: </label>
                          <div class="col-sm-9">

                              <input type="date" class="form-control" autocomplete="off" id="date_from" name="date_from"  required>

                          </div>
                        </div>

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date To: </label>
                          <div class="col-sm-9">

                              <input type="date" class="form-control" autocomplete="off" id="date_to" name="date_to"  required>

                          </div>
                        </div>

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Company: </label>
                          <div class="col-sm-9">
                            <select class="form-control" name="company" id="companys" onchange="getBunit(this.value)" required="true">
                              <option value=""  disabled selected>Select</option>
                                <?php foreach ($company_name as $key => $value): ?>
                                  <option value="<?php echo $value['company_code'].'/'.$value['acroname']; ?>"><?php echo $value['acroname'];?></option>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <p></p>

                         <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Business Unit: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="bunit" id="bunits" onchange="getDept(this.value)" required="true">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        <p></p>
                        
                         <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Department: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="dept" id="depts" onchange="getSection(this.value)" required="true" >
                                    <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        <p></p> 
                          <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Section: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="section" id="sections" required="true">
                                        <option value="">Select</option>    
                                    </select>
                                </div>
                            </div>
                        <p></p>

                      <input type="file" class="form-control" autocomplete="off" placeholder="browse excel file" id="exelfile" name="exelfile"  required>
                
                      <div class="modal-footer">  
                          <button type="submit" class="btn btn-primary" id="btn1">Submit</button>
                          <button type="button" class="btn btn-white close_btn2" onclick="cyclic_report()">Create report</button>
                      </div>
                    </form>
                  </div>
                </div>  

                <div id="Nav Files" class="tabcontent" >
                   <div  style="padding-right:328px; padding-left:328px; margin-top: 30px;">
                    <div id="pageloaderr_" hidden="">
                      <img src="<?php echo base_url("assets/images/loader.gif");?>" alt="processing..." />
                    </div>
                      <form enctype="multipart/form-data" method="POST" id="fileUploadForm_nav">
                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date From: </label>
                          <div class="col-sm-9">
                              <input type="date" class="form-control" autocomplete="off" id="date_from" name="date_from"  required>
                          </div>
                        </div>
                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date To: </label>
                          <div class="col-sm-9">
                              <input type="date" class="form-control" autocomplete="off" id="date_to" name="date_to"  required>
                          </div>
                        </div>

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Company: </label>
                          <div class="col-sm-9">
                            <select class="form-control" name="company" id="companyss" onchange="getDept_(this.value)" required="true">
                              <option value=""  disabled selected>Select</option>
                                <?php foreach ($company_name as $key => $value): ?>
                                  <option value="<?php echo $value['company_code'].'/'.$value['acroname']; ?>"><?php echo $value['acroname'];?></option>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <p></p>    
                         <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Department: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="dept" id="deptss"  required="true">
                                    <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        <p></p> 
                      <input type="file" class="form-control" autocomplete="off" placeholder="browse excel file" id="exelfile" name="exelfile"  required>
                
                      <div class="modal-footer">  
                          <button type="submit" class="btn btn-primary" id="btn1">Submit</button>
                          <button type="button" class="btn btn-white close_btn2" onclick="nav_report()">Create report</button>
                      </div>
                    </form>
                  </div>
                </div> 

                <div id="NAV" class="tabcontent" >
                  <div  style="padding-right:328px; padding-left:328px; margin-top: 30px;">
                    <div id="pageloaderrs_" hidden="">
                      <img src="<?php echo base_url("assets/images/loader.gif");?>" alt="processing..." />
                    </div>
                      <form enctype="multipart/form-data" method="POST" id="fileUpload_nav">

                     <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date From: </label>
                          <div class="col-sm-9">

                              <input type="date" class="form-control" autocomplete="off" id="date_from" name="date_from"  required>

                          </div>
                        </div> 

                         <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date To: </label>
                          <div class="col-sm-9">

                              <input type="date" class="form-control" autocomplete="off" id="date_to" name="date_to"  required>

                          </div>
                        </div> 

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Company: </label>
                          <div class="col-sm-9">
                            <select class="form-control" name="company" id="companyss_" onchange="getDept_(this.value)" required="true">
                              <option value=""  disabled selected>Select</option>
                                <?php foreach ($company_name as $key => $value): ?>
                                  <option value="<?php echo $value['company_code'].'/'.$value['acroname']; ?>"><?php echo $value['acroname'];?></option>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <p></p>    
                         <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Department: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="dept" id="deptss_"  >
                                    <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        <p></p> 
                      <input type="file" class="form-control" autocomplete="off" placeholder="browse excel file" id="exelfile" name="exelfile"  required>
                
                      <div class="modal-footer">  
                          <button type="submit" class="btn btn-primary" id="btn1">Submit</button>
                          <button type="button" class="btn btn-white close_btn2" onclick="nav_file_report()">Create report</button>
                      </div>
                    </form>
                  </div>
                </div> 

                <div id="Pcount" class="tabcontent" >
                  <div  style="padding-right:328px; padding-left:328px; margin-top: 30px;">
                    <div id="pageloaderr" hidden="">
                      <img src="<?php echo base_url("assets/images/loader.gif");?>" alt="processing..." />
                    </div>
                      <form enctype="multipart/form-data" method="POST" id="fileUpload_pcount">

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date From: </label>
                          <div class="col-sm-9">

                              <input type="date" class="form-control" autocomplete="off" id="date_from" name="date_from"  required>

                          </div>
                        </div>

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Date To: </label>
                          <div class="col-sm-9">

                              <input type="date" class="form-control" autocomplete="off" id="date_to" name="date_to"  required>

                          </div>
                        </div>

                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Company: </label>
                          <div class="col-sm-9">
                            <select class="form-control" name="company" id="comp" onchange="getDept_(this.value)" required="true">
                              <option value=""  disabled selected>Select</option>
                                <?php foreach ($company_name as $key => $value): ?>
                                  <option value="<?php echo $value['company_code'].'/'.$value['acroname']; ?>"><?php echo $value['acroname'];?></option>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <p></p>  
                       <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Department: </label>
                            <div class="col-sm-9">
                              <select class="form-control" name="dept" id="departs"  >
                                <option value="">Select</option>
                              </select>
                            </div>
                        </div>
                        <p></p> 
                        
                      <input type="file" class="form-control" autocomplete="off" placeholder="browse excel file" id="exelfile" name="exelfile"  required>
                
                      <div class="modal-footer">  
                          <button type="submit" class="btn btn-primary" id="btn1">Submit</button>
                          <button type="button" class="btn btn-white close_btn2" onclick="pcount_report()">Create report</button>
                      </div>
                    </form>
                  </div>
                </div> 

                <div id="Cyclic Reports" class="tabcontent">
                      <!--<form enctype="multipart/form-data" method="POST" id="fileUploadForm4">
                        <div class="modal-body" style="padding-right:400px; padding-left:400px;">
                            <div>
                            <input type="hidden" name="<?php //echo $this->session->userdata('user_id');?>" id="<?php //echo $this->session->userdata('user_id');?>" value="">
                            <label>master file</label>
                            <input type="file" class="form-control" autocomplete="off" placeholder="browse file"  name="exelfile" id="exelfile" required>
                            </div>
                        </div>
                        <div class="modal-footer">  
                            <button type="submit" class="" s="btn btn-primary" id="btn1">Submit</button>
                            <button type="button" class="btn btn-white" data-dismiss="modal" onclick="btn_close2()">cancel</button>
                        </div>
                    </form>!-->
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" id="tbl_cyclic_report">
                             <thead>
                                 <tr>
                                     <th>Report No</th>
                                     <!--<th>User Id</th>!-->
                                     <th>File Name</th>
                                     <th>Date Uploaded</th>
                                     <th style="width: 30px;">Action</th>
                                 </tr>
                             </thead>
                         </table>
                     </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="myModal7" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h5 class="modal-title" id="thebigtitle">Upload excel file</h5>
        </div>
        <form enctype="multipart/form-data" method="POST" id="fileUploadForm3">
            <div class="modal-body">

                
                <input type="file" class="form-control" autocomplete="off" placeholder="browse image"  name="exelfile"  required>
            </div>
            <div class="modal-footer">  
                <button type="submit" class="btn btn-primary" id="btn1">Submit</button>
                <button type="button" class="btn btn-white close_btn2"  >Close</button>
            </div>
        </form>
    </div>
</div>
</div>

<div class="modal inmodal" id="myModal_dL" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id='modaltitle'>Download Pdf</h4>
            </div>
                <div class="modal-body" >
                     <input type="hidden" name="_id" id="_id" value="">
                    <img src="" style="margin-left: 120px;">
                </div>
                <div class="modal-footer">
                    <a href="" id="yes_btn"  class='btn btn-primary fa fa-download' download>Yes</i></a>
                    <button type="button" class="btn btn-white" id="no_btn" data-dismiss="modal">No</button>
                </div>
        </div>
    </div>
</div>
<!-- page end !-->

 <script>
  function tab_setup(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();

  
  </script>
     