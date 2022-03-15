<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><i class="fa fa-list"></i> Location</h5>
                    <div class="ibox-tools">
                    <button type="button" class="btn btn-primary btn-sm float-right" onclick="addLocationModal()"><i class="fa fa-plus"></i> Setup Location</button>                       
                    </div>
                </div>
                <div class="ibox-content">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" onclick="loadTable('Active')" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" onclick="loadTable('Inactive')" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Inactive</a>
                        </li>
                    </ul>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTables-example" width="100%" id="appuser_tbl">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Location Assign</th>
                                    <th>Status</th>
                                    <th>Date Added</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal4" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <h4 class="modal-title">Add Location</h4>
            </div>
            <form method="POST" class="form-action" id="addLocation">
                <div class="modal-body">
                    <div class="form-group  row">
                        <input type="hidden" class="form-control" name="loc_id">
                        <label class="col-sm-3 col-form-label">Company: </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="company" onchange="getBunit(this.value)" required="true">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Business Unit: </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="bunit" onchange="getDept(this.value)" required="true">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-3 col-form-label">Department: </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="dept" onchange="getSection(this.value)" required="true">
                            <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-3 col-form-label">Section: </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="section" required="true">
                                <option value="">Select</option>    
                            </select>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-3 col-form-label">Description: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="rack_desc" required="true" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="Submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal" onclick="close_btn()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal3" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <form method="POST" class="formAction" id="delLocation">
                <div class="modal-body">
                    <p id="confirm-message">Are you sure you want to delete this setup?</p>
                    <input type="hidden" class="form-control"  name="loc_id">
                    <button type="Submit" class="btn btn-danger">Yes</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal" onclick="close_btn()">No</button>                  
                </div>
            </form>
        </div>
    </div>
</div>