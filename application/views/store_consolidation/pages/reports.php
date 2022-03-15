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
                  <!-- <button class="tablinks" onclick="tab_setup(event, 'Monthly')" id="defaultOpen">Update existing With Cost Data</button> -->
                  <button class="tablinks" onclick="tab_setup(event, 'Monthly_Report')"id="defaultOpen">With Cost </button>
                  <button class="tablinks" onclick="tab_setup(event, 'Cyclic Reports')">Physical Count  </button>
                  <!-- <button class="tablinks" onclick="tab_setup(event, 'Cyclic')"> Cyclic </button> -->
                </div>

                <div id="Monthly" class="tabcontent" >
                   <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" id="tbl_update_monthly">
                             <thead>
                                 <tr>
                                     <th>Report No</th>
                                     <!--<th>User Id</th>!-->
                                     <th>File Name</th>
                                     <th>Company</th>
                                     <th>Business Unit</th>
                                     <th>department</th>
                                     <th>Section</th>
                                     <th style="width: 30px;">Action</th>
                                 </tr>
                             </thead>
                         </table>
                     </div>
                </div>

                  <div id="Monthly_Report" class="tabcontent" >
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

                <div id="Cyclic Reports" class="tabcontent">
                    </form>
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

              <!--   <div id="Cyclic" class="tabcontent" >
                    <div  style="padding-right:328px; padding-left:328px; margin-top: 30px;">
                      <div id="pageloader" hidden="">
                        <img src="<?php// echo base_url("assets/images/loader.gif");?>" alt="processing..." />
                      </div>
                      <form enctype="multipart/form-data" method="POST" id="fileUploadForm_1">
                        <div class="form-group  row">
                          <label class="col-sm-3 col-form-label">Company: </label>
                          <div class="col-sm-9">
                            <select class="form-control" name="company" id="company" onchange="getBunit(this.value)" required="true">
                              <option value=""  disabled selected>Select</option>
                                <?php //foreach ($company_name as $key => $value): ?>
                                  <option value="<?php //echo $value['company_code'].'/'.$value['acroname']; ?>"><?php echo $value['acroname'];?></option>
                                <?php //endforeach ?>
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
                        <p></p>
                        
                         <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Department: </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="dept" id="dept" onchange="getSection(this.value)" required="true">
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
                        <p></p>
                        <input type="file" class="form-control" autocomplete="off" placeholder="browse excel file"  id="exelfile" name="exelfile"  required>
                
                        <div class="modal-footer">  
                          <button type="submit" class="btn btn-primary" id="btn_form">Submit</button>
                          <button type="button" class="btn btn-white report_btn" id="report_btn" onclick="create_report()">Create report</button>
                        </div>
                      </form>

                     </div>
                </div> -->
               
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal_update" tabindex="1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" name="modaltitle" id='modaltitle'>Update</h4>
            </div>
                <div class="modal-body" >
                   <form enctype="multipart/form-data" method="POST" id="fileUploadForm_2">

                       <input type="hidden" class="form-control" name="loc_id" id="loc_id" value="">
                       <input type="hidden" class="form-control" name="user_id" id="user_id" value="">
                       <input type="hidden" class="form-control" name="file_name" id="file_name" value="">
                        <input type="file" class="form-control" autocomplete="off" placeholder="browse excel file"  id="exelfile" name="exelfile"  required>
                
                        <div class="modal-footer">  
                          <button type="submit" class="btn btn-primary" id="btn_form">Submit</button>
                          <button type="button" class="btn btn-white" onclick="report_btn()">Create report</button>
                        </div>
                      </form>
                </div>
               
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal_iframe" tabindex="1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id='modaltitle'>Update</h4>
            </div>
                <div class="modal-body" >
                   <form enctype="multipart/form-data" method="POST" id="fileUploadForm_2">

                       <input type="hidden" class="form-control" name="loc_id" id="loc_id" value="">
                        <iframe id="fred" style="border:1px solid #666CCC" title="PDF in an i-Frame" src="" frameborder="1" scrolling="auto" height="1000" width="450" ></iframe>
                      <!--   <object data="your_url_to_pdf" type="application/pdf">
                          <embed src="your_url_to_pdf" type="application/pdf" />
                        </object> -->
                        <div class="modal-footer">  
                          <button type="submit" class="btn btn-primary" id="btn_form">Submit</button>
                          <button type="button" class="btn btn-white" onclick="report_btn()">Create report</button>
                        </div>
                      </form>
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
     