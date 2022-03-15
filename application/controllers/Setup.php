<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->model('Setup_model','setup');
	}

    public function get_company(){     
		$data = $this->setup->companyList();
		foreach ($data as $key => $value) {
			
			$result['data'][] = array(
                "locname" => $value['acroname'],
                "loccode" => $value['company_code'],
            );
		}
		echo json_encode($result);
    }

    public function get_bunit(){
        $id  = explode("/",$_POST['cid']);
        $data = $this->setup->bunitList($id[0]);
		foreach ($data as $key => $value) {
			
			$result['data'][] = array(
                "bname" => $value['business_unit'],
                "bcode" => $value['bunit_code'],
                "ccode" => $id[0],
            );
		}
		echo json_encode($result);
    }

    public function get_dept(){
        $id  = explode("/",$_POST['bid']);
        $data = $this->setup->deptList($id[1],$id[0]);
		foreach ($data as $key => $value) {
			
			$result['data'][] = array(
                "dname" => $value['dept_name'],
                "dcode" => $value['dept_code'],
                "bcode" => $id[0],
                "ccode" => $id[1]
            );
		}
		echo json_encode($result);
    }

    public function get_section(){
        $id  = explode("/",$_POST['did']);
        $data = $this->setup->secList($id[2],$id[1],$id[0]);
		foreach ($data as $key => $value) {
			
			$result['data'][] = array(
                "sname" => $value['section_name'],
                "scode" => $value['section_code'],
                "ccode" => $id[2],
                "bcode" => $id[1],
                "dcode" => $id[0],
            );
		}
		echo json_encode($result);
    }

    public function get_location(){
        $stat   = $this->security->xss_clean($_GET['stat']);
        $result = array('data' => []);
		$data = $this->setup->getLocations($stat);
		foreach ($data as $key => $value) {
            if($value['status'] == "Active"){
                $bClass = 'btn-info';
                $list   = '<li><a class="dropdown-item"  onclick="deactLocation(\''.$value['location_id'].'\')">Deactivate</a></li>';
            }else{
                $bClass  = 'btn-warning';
                $list   = '<li><a class="dropdown-item"  onclick="actLocation(\''.$value['location_id'].'\')">Activate</a></li>';
            }
			$btn = '<div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-success btn-xs dropdown-toggle">Action</button>
                        <ul class="dropdown-menu">
                            '.$list.'
                            <li><a class="dropdown-item"  onclick="editLocation(\''.$value['location_id'].'\',\''.$value['loc_code'].'\')">Edit</a></li>
                            <li><a class="dropdown-item"  onclick="delLocation(\''.$value['location_id'].'\')">Delete</a></li>
                        </ul>
                    </div>';
           
			$status = '<button class="btn '.$bClass.' btn-xs">'.$value['status'].'</button>';

			$result['data'][] = [ '<span id="'.$value['location_id'].'_company">'.$value['company'].'</span>', '<span id="'.$value['location_id'].'_bunit">'.$value['business_unit'].'</span>', '<span id="'.$value['location_id'].'_dept">'.$value['department'].'</span>', '<span id="'.$value['location_id'].'_section">'.$value['section'].'</span>','<span id="'.$value['location_id'].'_desc">'.$value['rack_desc'].'</span>',$value['date_added'], $status, $btn];
		}
		echo json_encode($result);
    }

    public function save_location(){
        $company    = $this->security->xss_clean($_POST['company']);
        $company    = explode("/",$company); //0 - CCODE 1 - CNAME
        $bunit      = $this->security->xss_clean($_POST['bunit']);
        $bunit      = explode("/",$bunit); //0 - BCODE 1 - CCODE 2 - Business Unit Name
        $dept       = $this->security->xss_clean($_POST['dept']);
        $dept       = explode("/",$dept); //0 - DCODE 1 - BCODE 2 - CCODE 3 - Department Name
        $section    = $this->security->xss_clean($_POST['section']);
        $section    = explode("/",$section); //0 - SECCODE 1 - DCODE 2 - BCODE 3 - CCODE 4 - Section Name
        $loc_desc   = $this->security->xss_clean($_POST['rack_desc']);
        // echo $company[1]."/".$bunit[2]."/".$dept[3]."/".$section[4];
        $codes = $company[0].".".$bunit[0].".".$dept[0].".".$section[0];
        // User Fields
        $cid        = $this->security->xss_clean($_POST['cid']);
        $name       = $this->security->xss_clean($_POST['name']);
        $eno        = $this->security->xss_clean($_POST['eno']);
        $epins      = $this->security->xss_clean($_POST['epins']);
        $epos       = $this->security->xss_clean($_POST['epos']);
        // Audit Fields
        $cid1       = $this->security->xss_clean($_POST['cid1']);
        $name1      = $this->security->xss_clean($_POST['name1']);
        $eno1       = $this->security->xss_clean($_POST['eno1']);
        $epins1     = $this->security->xss_clean($_POST['epins1']);
        $epos1      = $this->security->xss_clean($_POST['epos1']);
        // Locations
        $locs       = $_POST['loc_details'];
        $locs1       = count($locs) - 1;
        
        if(!empty($company) && !empty($bunit) && !empty($dept) && !empty($section)){
            if($this->setup->checkLocation($loc_desc,$codes) == true){
                $msg	=	array(
                    "status"    => "error",
                    "msg"	    => "Location setup is already exist."
                );
            }elseif($locs1 == 0){
                $msg	=	array(
                    "status"    => "error",
                    "msg"	    => "Location Assign is empty."
                );
            }else{
                for($x = 0; $x < count($locs); $x++ ){
                    if(!empty($locs[$x])){
                        $id = $this->setup->insertLocation($company[1],$bunit[2],$dept[3],$section[4],$locs[$x],$codes);
                        if($id){
                            $user   = $this->setup->insertUser($id,$cid,$name,$eno,$epins,$epos);
                            $audit  = $this->setup->insertAudit($id,$cid1,$name1,$eno1,$epins1,$epos1);
                            if($user && $audit){
                                $msg	=	array(
                                    "status"    => "success",
                                    "msg"	    => "Location successfully save."
                                );
                            }else{
                                $msg	=	array(
                                    "status"    => "error",
                                    "msg"	    => "Unable to save user."
                                );
                            }                                
                        }else{
                            $msg	=	array(
                                "status"    => "error",
                                "msg"	    => "Unable to save location setup."
                            );
                        }
                    }
                }                
            }            
        }else{
            $msg	=	array(
                "status"    => "error",
                "msg"	    => "All fields are required!"
            );
        }
        echo json_encode($msg);
    }

    public function del_location(){
        $loc_id    = $this->security->xss_clean($_POST['loc_id']);
        if($loc_id){
            if($this->setup->delLocation($loc_id) == true){
                $msg	=	array(
                    "status"    => "success",
                    "msg"	    => "Location setup successfully deleted."
                );
            }else{
                $msg	=	array(
                    "status"    => "error",
                    "msg"	    => "Unable to delete location setup."
                );
            }
        }else{
            $msg	=	array(
                "status"    => "error",
                "msg"	    => "Something wrong with the request."
            );
        }
        echo json_encode($msg);
    }

    public function update_location(){
        $company    = $this->security->xss_clean($_POST['company']);
        $company    = explode("/",$company); //0 - CCODE 1 - CNAME
        $bunit      = $this->security->xss_clean($_POST['bunit']);
        $bunit      = explode("/",$bunit); //0 - BCODE 1 - CCODE 2 - Business Unit Name
        $dept       = $this->security->xss_clean($_POST['dept']);
        $dept       = explode("/",$dept); //0 - DCODE 1 - BCODE 2 - CCODE 3 - Department Name
        $section    = $this->security->xss_clean($_POST['section']);
        $section    = explode("/",$section); //0 - SECCODE 1 - DCODE 2 - BCODE 3 - CCODE 4 - Section Name
        $loc_desc   = $this->security->xss_clean($_POST['rack_desc']);
        
        $codes      = $company[0].".".$bunit[0].".".$dept[0].".".$section[0];
        $locid      = $this->security->xss_clean($_POST['loc_id']);
        // User Fields
        $cid        = $this->security->xss_clean($_POST['cid']);
        $name       = $this->security->xss_clean($_POST['name']);
        $eno        = $this->security->xss_clean($_POST['eno']);
        $epins      = $this->security->xss_clean($_POST['epins']);
        $epos       = $this->security->xss_clean($_POST['epos']);
        // Audit Fields
        $cid1       = $this->security->xss_clean($_POST['cid1']);
        $name1      = $this->security->xss_clean($_POST['name1']);
        $eno1       = $this->security->xss_clean($_POST['eno1']);
        $epins1     = $this->security->xss_clean($_POST['epins1']);
        $epos1      = $this->security->xss_clean($_POST['epos1']);

        if(!empty($company) && !empty($bunit) && !empty($dept) && !empty($section) && !empty($loc_desc)){
            if($this->setup->checkLocationUpdate($loc_desc,$codes,$locid) == true){
                $msg	=	array(
                    "status"    => "error",
                    "msg"	    => "Location setup is already exist."
                );
            }else{
                if($this->setup->updateLocation($company[1],$bunit[2],$dept[3],$section[4],$loc_desc,$codes,$locid) == true){
                    $user   = $this->setup->userInfoByLocation($locid,$cid,$name,$eno,$epins,$epos,"tbl_app_user");
                    $audit  = $this->setup->userInfoByLocation($locid,$cid1,$name1,$eno1,$epins1,$epos1,"tbl_app_audit");
                    $msg	=	array(
                        "status"    => "success",
                        "msg"	    => "Location successfully update."
                    );               
                }else{
                    $msg	=	array(
                        "status"    => "error",
                        "msg"	    => "Unable to update location setup."
                    );
                }
            }        
        }else{
            $msg	=	array(
                "status"    => "error",
                "msg"	    => "All fields are required!"
            );
        }
        echo json_encode($msg);
    }

    public function deact_location(){
        $loc_id    = $this->security->xss_clean($_POST['loc_id']);
        if($loc_id){
            if($this->setup->deactivateLocation($loc_id,'Inactive') == true){
                $msg	=	array(
                    "status"    => "success",
                    "msg"	    => "Location setup successfully deactivate."
                );
            }else{
                $msg	=	array(
                    "status"    => "error",
                    "msg"	    => "Unable to deactivate location setup."
                );
            }
        }else{
            $msg	=	array(
                "status"    => "error",
                "msg"	    => "Something wrong with the request."
            );
        }
        echo json_encode($msg);
    }

    public function act_location(){
        $loc_id    = $this->security->xss_clean($_POST['loc_id']);
        if($loc_id){
            if($this->setup->deactivateLocation($loc_id,'Active') == true){
                $msg	=	array(
                    "status"    => "success",
                    "msg"	    => "Location setup successfully activate."
                );
            }else{
                $msg	=	array(
                    "status"    => "error",
                    "msg"	    => "Unable to activate location setup."
                );
            }
        }else{
            $msg	=	array(
                "status"    => "error",
                "msg"	    => "Something wrong with the request."
            );
        }
        echo json_encode($msg);
    }

    public function search_employee(){
        $str    = $this->security->xss_clean($_POST['str']);
        $datas  = $this->setup->searchEmployee($str);
        foreach($datas as $p){
            $data['data'][]	=	array(
                "fname"		=> $p['name'],
                "cid"		=> $p['emp_id'],
                "eno"       => $p['emp_no'],
                "epins"     => $p['emp_pins'],
                "epos"      => $p['position']
            );
        }
       
        echo json_encode($data);
    }

    public function get_emp_info(){
        $loc    = $this->security->xss_clean($_POST['locid']);
        $utype  = $this->security->xss_clean($_POST['utype']);
        $tbl    = ($utype=="user")?'tbl_app_user':'tbl_app_audit';
        $datas   = $this->setup->getUserInfoByLocation($loc,$tbl);
        $data['data'][]	=	array(
            "fname"		=> $datas->name,
            "cid"		=> $datas->emp_id,
            "eno"       => $datas->emp_no,
            "epins"     => $datas->emp_pin,
            "epos"      => $datas->position
        );
        echo json_encode($data);
    }
}