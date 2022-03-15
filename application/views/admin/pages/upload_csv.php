<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><i class="fa fa-list"></i> CSV File List</h5>
                    <div class="ibox-tools">
                    <button type="button" class="btn btn-primary btn-sm float-right" onclick="uploadCSVFile()"><i class="fa fa-upload"></i> Upload CSV</button>                       
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTables-example" width="100%" id="file_tbl">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>As Of</th>
                                    <th>Date Uploaded</th>
                                    <th>Uploaded By</th>
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
                <h4 class="modal-title">Upload File</h4>
            </div>
            <form method="POST" class="form-action" id="uploadFile">
                <div class="modal-body">
                    <div class="form-group  row">
                        <label class="col-sm-3 col-form-label">Browse CSV: </label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="csv_file" id="csv_file" required>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-3 col-form-label">As of: </label>
                        <div class="col-sm-9">
                            <select class="form-control select2" required name="month" tabindex="6">
                                <option value="">Select Month</option>
                                <?php for($x=1;$x<=12;$x++):?>
                                    <option value="<?= date("F", strtotime(date("Y") ."-". $x ."-01"))?>"><?= date("F", strtotime(date("Y") ."-". $x ."-01"))?></option>
                                <?php endfor;?>
                            </select><br>
                            <select class="form-control select2" required name="year" tabindex="6">
                                <option value="">Select Year</option>
                                <?php 
                                    $year = date("Y");
                                    for($x=$year;$x<=$year;$x++):?>
                                    <option value="<?= $x;?>"><?= $x;?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-white" data-dismiss="modal" onclick="close_btn()">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>