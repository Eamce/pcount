<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->db2 = $this->load->database('pis', TRUE);
    }

    public function companyList(){
        $this->db2->order_by("company_code","ASC");
        $this->db2->select("acroname,company_code");
        $this->db2->where("company_code = '02' OR company_code = '03'");
        $query	= $this->db2->get('locate_company');
        return $query->result_array();
    }

    public function bunitList($cid){
        $this->db2->order_by("bunit_code","ASC");
        
        if($cid=="02"){
            $this->db2->where("
                (company_code = '".$this->security->xss_clean($cid)."' AND bunit_code = '01') OR 
                (company_code = '".$this->security->xss_clean($cid)."' AND bunit_code = '02') OR
                (company_code = '".$this->security->xss_clean($cid)."' AND bunit_code = '03') OR
                (company_code = '".$this->security->xss_clean($cid)."' AND bunit_code = '21') OR
                (company_code = '".$this->security->xss_clean($cid)."' AND bunit_code = '23')
                ");
        }elseif($cid=="03"){
            $this->db2->where("
            (company_code = '".$this->security->xss_clean($cid)."' AND bunit_code = '01')
            ");
        }
        $this->db2->select("business_unit,bunit_code");
        $query	= $this->db2->get('locate_business_unit');
        return $query->result_array();
    }

    public function deptList($cid,$bid){
        $this->db2->order_by("dept_code","ASC");
        $this->db2->where('company_code', $this->security->xss_clean($cid));
        $this->db2->where('bunit_code', $this->security->xss_clean($bid));
        $this->db2->select("dept_name,dept_code");
        $query	= $this->db2->get('locate_department');
        return $query->result_array();
    }
    
    public function secList($cid,$bid,$did){
        $this->db2->order_by("dept_code","ASC");
        $this->db2->where('company_code', $this->security->xss_clean($cid));
        $this->db2->where('bunit_code', $this->security->xss_clean($bid));
        $this->db2->where('dept_code', $this->security->xss_clean($did));
        $this->db2->select("section_name,section_code");
        $query	= $this->db2->get('locate_section');
        return $query->result_array();
    }

    public function getLocations($stat){
        $this->db->order_by("date_added","DESC");
        $this->db->where('status',$this->security->xss_clean($stat));
        $this->db->select("*");
        $query	= $this->db->get('tbl_location');
        return $query->result_array();
    }

    public function insertLocation($ccode,$bcode,$dcode,$scode,$desc,$lcode){
        $data	= array(
            "company"		=> strtoupper($this->security->xss_clean($ccode)),
            "business_unit"	=> strtoupper($this->security->xss_clean($bcode)),
            "department"	=> strtoupper($this->security->xss_clean($dcode)),
            "section"		=> strtoupper($this->security->xss_clean($scode)),
            "loc_code"		=> strtoupper($this->security->xss_clean($lcode)),
            "rack_desc"		=> ucwords($this->security->xss_clean($desc)),
            "date_added"	=> date("Y-m-d H:i:s"),
            "status"		=> 'Active',
        );
        $this->db->insert('tbl_location', $data);
		return $this->db->insert_id();
    }

    public function insertUser($locid,$eid,$name,$eno,$epins,$epost){
        $data	= array(
            "emp_id"		=> $this->security->xss_clean($eid),
            "emp_no"	    => $this->security->xss_clean($eno),
            "emp_pin"	    => $this->security->xss_clean($epins),
            "name"		    => $this->security->xss_clean($name),
            "position"		=> $this->security->xss_clean($epost),
            "location_id"	=> $this->security->xss_clean($locid),
            "date_register"	=> date("Y-m-d H:i:s")
        );
        $this->db->insert('tbl_app_user', $data);
		return true;
    }
    
    public function insertAudit($locid,$eid,$name,$eno,$epins,$epost){
        $data	= array(
            "emp_id"		=> $this->security->xss_clean($eid),
            "emp_no"	    => $this->security->xss_clean($eno),
            "emp_pin"	    => $this->security->xss_clean($epins),
            "name"		    => $this->security->xss_clean($name),
            "position"		=> $this->security->xss_clean($epost),
            "location_id"	=> $this->security->xss_clean($locid),
            "date_register"	=> date("Y-m-d H:i:s")
        );
        $this->db->insert('tbl_app_audit', $data);
		return true;
    }

    public function checkLocation($desc,$lcode){
        $this->db->where('loc_code', strtoupper($this->security->xss_clean($lcode)));		
        $this->db->where('rack_desc', strtoupper($this->security->xss_clean($desc)));

        $query = $this->db->get('tbl_location');        
        if($query->num_rows() == 1){
            return true;
        } else {				
            return false;
        }
    }

    public function delLocation($id){
        $this->db->where('location_id',$this->security->xss_clean($id));
        $this->db->delete('tbl_location');
        return true;
    }

    public function updateLocation($ccode,$bcode,$dcode,$scode,$desc,$lcode,$id){
        $data	= array(
            "company"		=> strtoupper($this->security->xss_clean($ccode)),
            "business_unit"	=> strtoupper($this->security->xss_clean($bcode)),
            "department"	=> strtoupper($this->security->xss_clean($dcode)),
            "section"		=> strtoupper($this->security->xss_clean($scode)),
            "loc_code"		=> strtoupper($this->security->xss_clean($lcode)),
            "rack_desc"		=> ucwords($this->security->xss_clean($desc))
        );

        $this->db->where('location_id',$this->security->xss_clean($id));
        $this->db->update('tbl_location',$data);
        return true;
    }

    public function checkLocationUpdate($desc,$lcode,$locid){
        $this->db->where('loc_code', strtoupper($this->security->xss_clean($lcode)));		
        $this->db->where('rack_desc', strtoupper($this->security->xss_clean($desc)));
        $this->db->where('location_id != ', strtoupper($this->security->xss_clean($locid)));

        $query = $this->db->get('tbl_location');        
        if($query->num_rows() == 1){
            return true;
        } else {				
            return false;
        }
    }

    public function deactivateLocation($locid,$stat){
        $data	= array(
            "status"	=> $stat,
        );

        $this->db->where('location_id',$this->security->xss_clean($locid));
        $this->db->update('tbl_location',$data);
        return true;
    }

    public function searchEmployee($name){
        $this->db2->select("name,emp_id,position,emp_no,emp_pins");
        $this->db2->where("name LIKE '%".$this->security->xss_clean($name)."%'", NULL, FALSE);
        $this->db2->where("current_status","Active");
        $this->db2->limit(10);
        $query	= $this->db2->get('employee3');
        return $query->result_array();
    }

    public function getUserInfoByLocation($loc,$tbl){
        $this->db->select("name,emp_id,position,emp_no,emp_pin");
        $this->db->where("location_id",$this->security->xss_clean($loc));
        $query	= $this->db->get($tbl);
        return $query->row();
    }

    public function userInfoByLocation($locid,$eid,$name,$eno,$epins,$epost,$tbl){
        $data	= array(
            "emp_id"		=> $this->security->xss_clean($eid),
            "emp_no"	    => $this->security->xss_clean($eno),
            "emp_pin"	    => $this->security->xss_clean($epins),
            "name"		    => $this->security->xss_clean($name),
            "position"		=> $this->security->xss_clean($epost)
        );
        $this->db->where('location_id',$this->security->xss_clean($locid));
        $this->db->update($tbl,$data);
        return true;
    }

    public function getloc($tbl,$cid,$bid=null){
        $this->db2->select("*");
        if($bid){
            $this->db2->where("bunit_code",$this->security->xss_clean($bid));
        }
        $this->db2->where("company_code",$this->security->xss_clean($cid));
        $query	= $this->db2->get($tbl);
        return $query->row();
    }
}