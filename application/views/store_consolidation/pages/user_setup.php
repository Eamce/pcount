<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><i class="fa fa-users"> Users</i></h5>
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
                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#myModal4"><i class="fa fa-plus"></i> User</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" id="user_tbl">
                            <thead>
                                <tr>
                                    <th width="25%">System User</th>
                                    <th width="15%">Username</th>
                                    <th>Store</th>
                                    <th>Usertype</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">user Status</th>
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
                <h4 class="modal-title">Add User</h4>
            </div>
            <form method="POST" enctype="multipart/form-data" id="fileUploadForm">

                <div class="modal-body">

                    <div class="form-group  row" style="text-align: right;">
                        <label class="col-sm-3 col-form-label">Profile Picture: </label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="profile" id="profile">
                        </div>
                    </div>
                    <div class="form-group row" style="text-align: right;">
                        <label class="col-sm-3 col-form-label">Name: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" autocomplete="off" placeholder="Name" name="uname" id="uname">
                        </div>
                    </div>
                    <div class="form-group  row" style="text-align: right;">
                        <label class="col-sm-3 col-form-label">Username: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" autocomplete="off" placeholder="Username" name="username" id="username">
                        </div>
                    </div>
                    <div class="form-group  row" style="text-align: right;">
                        <label class="col-sm-3 col-form-label">Password: </label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" autocomplete="off" placeholder="Password" name="password" id="password">
                        </div>
                    </div>
                    <div class="form-group  row" style="text-align: right;">
                        <label class="col-sm-3 col-form-label">Usertype: </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="usertype" id="usertype" onchange="uTpye(this.value)">
                                <option value="" hidden>Select Usertype</option>
                                <option value="Admin">Admin</option>
                                <option value="Retail 1">Retail 1</option>
                                <option value="store_conso">Store User</option>
                            </select>
                        </div>
                    </div>
                    <div id="locations" style="display:none">
                        <div class="form-group  row">
                            <input type="hidden" class="form-control" name="loc_id">
                            <label class="col-sm-3 col-form-label">Company: </label>
                            <div class="col-sm-9">
                                <select class="form-control" name="company" onchange="getBunit(this.value)">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Business Unit: </label>
                            <div class="col-sm-9">
                                <select class="form-control" name="bunit" onchange="getDept(this.value)">
                                    <option value="">Select</option>
                                </select>
                            </div>
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