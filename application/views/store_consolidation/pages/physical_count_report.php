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
                  <button class="tablinks" onclick="tab_setup(event, 'pcount_report')"id="defaultOpen">Physical Count </button>
                </div>

                <div id="pcount_report" class="tabcontent" >
                 
                  <div  style="padding-right:328px; padding-left:328px; margin-top: 30px;">
                    <div id="pageloaderr" hidden="">
                      <img src="<?php echo base_url("assets/images/loader.gif");?>" alt="processing..." />
                    </div>
                      <form enctype="multipart/form-data" method="POST" id="fileUploadForm5">

                     <!--    <div class="form-group  row">
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
                        </div> -->

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
                      <div class="modal-footer">  
                        
                          <button type="button" class="btn btn-white close_btn2" onclick="physical_report()">Create report</button>
                      </div>
                    </form>
                  </div>
                
                </div>
               
                </div>
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
     