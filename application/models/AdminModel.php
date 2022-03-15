<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model{
	  function __construct(){
        parent::__construct();
        $this->db2 = $this->load->database('pis', TRUE);
    }

	public function getData_bs($table, $data){
		$result = $this->db->get_where($table, $data);
		return $result->row();
	}
	public function getNumData($table, $data){
		$result = $this->db->get_where($table, $data);
		return $result->num_rows();
	}
	public function getRequestData($table, $data){
		$result = $this->db->get_where($table, $data);
		return $result->num_rows();
	}
	public function getAllData($table){
		$result = $this->db->get($table);
		return $result->result_array();
	}

	public function insert_data($table, $data){
		$this->db->insert($table, $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			return 'success';
		}else{
			return 'error';
		}
	}

	// public function companyList(){
 //        $this->db2->order_by("company_code","ASC");
 //        $this->db2->select("acroname,company_code");
 //        $query	= $this->db2->get('locate_company');
 //        return $query->result_array();
 //    }

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

    // public function bunitList($cid){
    //     $this->db2->order_by("bunit_code","ASC");
    //     $this->db2->where('company_code', $this->security->xss_clean($cid));
    //     $this->db2->select("business_unit,bunit_code");
    //     $query	= $this->db2->get('locate_business_unit');
    //     return $query->result_array();
    // }

    public function deptList($cid,$bid){
        $this->db2->order_by("dept_code","ASC");
        $this->db2->where('company_code', $this->security->xss_clean($cid));
        $this->db2->where('bunit_code', $this->security->xss_clean($bid));
        $this->db2->select("dept_name,dept_code");
        $query	= $this->db2->get('locate_department');
        return $query->result_array();
    }

    public function deptList_($cid){
        $this->db2->order_by("dept_code","ASC");
        $this->db2->where('company_code', $this->security->xss_clean($cid));
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

	public function insert_conso_items($match_datas,$id){
		$this->db->insert('store_item_conso',$match_datas);
		
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function dir_save($paths){
			$this->db->insert('report_data', $paths);
			$this->db->trans_complete();
			if($this->db->trans_status() == true){
				return true;
			}else{
				return false;
			}
	}
	public function dir_save_cyclic($paths){
			$this->db->insert('tbl_cyclic_report', $paths);
			$this->db->trans_complete();
			if($this->db->trans_status() == true){
				return true;
			}else{
				return false;
			}
	}

	public function save_excel_path($excel_paths, $fname_user){

		$result = $this->db->where($fname_user)->update('tbl_cyclic_report', $excel_paths);
			$this->db->trans_complete();
			if($this->db->trans_status() == true){
				return true;
			}else{
				return false;
			}
	}

	public function item_master_file($data){
			$this->db->insert('item_materfile', $data);
			$this->db->trans_complete();
			if($this->db->affected_rows() > 0){
				return true;
			}else{
				return false;
			}
	}

	public function insert_cyclic_variance($datass){
		$this->db->insert('tbl_app_countdata_variance', $datass);
		$this->db->trans_complete();
		if($this->db->trans_status() == true){
			return true;
		}else{
			return false;
		}
	}

		public function insert_cyclic_icm($datass, $user, $location, $itemcode, $barcode){

		$result = $this->cyclic_icm_match($user, $location, $itemcode, $barcode);

		if($result == true){
			return false;
		}else{
			$res = $this->db->insert('tbl_app_countdata_variance', $datass);

			if($this->db->affected_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		// $this->db->insert('tbl_app_countdata_variance', $datass);
		// $this->db->trans_complete();
		// if($this->db->trans_status() == true){
		// 	return true;
		// }else{
		// 	return false;
		// }
	}

		public function cyclic_icm_match($user, $location, $itemcode, $barcode){
		$result = $this->db->select("tbl_app_countdata_variance.user_id,
									tbl_app_countdata_variance.loc_id,
									tbl_app_countdata_variance.itemcode,
									tbl_app_countdata_variance.barcode
								   ")
								   ->where('tbl_app_countdata_variance.user_id', $user)
								   ->where('tbl_app_countdata_variance.loc_id', $location)
								   ->where('tbl_app_countdata_variance.itemcode', $itemcode)
								   ->where('tbl_app_countdata_variance.barcode', $barcode)
								   ->get('tbl_app_countdata_variance');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function insert_cyclic_pm($pm, $user, $location, $itemcode, $barcode){

		$result = $this->cyclic_pm_match($user, $location, $itemcode, $barcode);

		if($result === TRUE){
			return false;
		}else{
			$this->db->insert('tbl_app_countdata_pm', $pm);

			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE)
			{
				return true;
			}else{
				return false;
			}
		}	
	}

	public function cyclic_pm_match($user, $location, $itemcode, $barcode){
		$result = $this->db->select("tbl_app_countdata_pm.user_id,
									tbl_app_countdata_pm.loc_id,
									tbl_app_countdata_pm.itemcode,
									tbl_app_countdata_pm.barcode
								   ")
								   ->where('tbl_app_countdata_pm.user_id', $user)
								   ->where('tbl_app_countdata_pm.loc_id', $location)
								   ->where('tbl_app_countdata_pm.itemcode', $itemcode)
								   ->where('tbl_app_countdata_pm.barcode', $barcode)
								   ->get('tbl_app_countdata_pm');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function insert_qty_alta($alta, $user, $location, $itemcode, $barcode){

		$result = $this->alta_match($user, $location, $itemcode, $barcode);

		if($result == true){
			return false;
		}else{
			$this->db->insert('tbl_app_countdata_altacita', $alta);

			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE)
			{
				return true;
			}else{
				return false;
			}
		}	
	}

	public function alta_match($user, $location, $itemcode, $barcode){
		$result = $this->db->select("tbl_app_countdata_altacita.user_id,
									tbl_app_countdata_altacita.loc_id,
									tbl_app_countdata_altacita.itemcode,
									tbl_app_countdata_altacita.barcode
								   ")
								   ->where('tbl_app_countdata_altacita.user_id', $user)
								   ->where('tbl_app_countdata_altacita.loc_id', $location)
								   ->where('tbl_app_countdata_altacita.itemcode', $itemcode)
								   ->where('tbl_app_countdata_altacita.barcode', $barcode)
								   ->get('tbl_app_countdata_altacita');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function insert_qty_asc($asc, $user, $location, $itemcode, $barcode){

		$result = $this->asc_match($user, $location, $itemcode, $barcode);

		if($result == true){
			return false;
		}else{
			$this->db->insert('tbl_app_countdata_asc', $asc);

			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE)
			{
				return true;
			}else{
				return false;
			}
		}	
	}

	public function asc_match($user, $location, $itemcode, $barcode){
		$result = $this->db->select("tbl_app_countdata_asc.user_id,
									tbl_app_countdata_asc.loc_id,
									tbl_app_countdata_asc.itemcode,
									tbl_app_countdata_asc.barcode
								   ")
								   ->where('tbl_app_countdata_asc.user_id', $user)
								   ->where('tbl_app_countdata_asc.loc_id', $location)
								   ->where('tbl_app_countdata_asc.itemcode', $itemcode)
								   ->where('tbl_app_countdata_asc.barcode', $barcode)
								   ->get('tbl_app_countdata_asc');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function insert_qty_talibon($talibon, $user, $location, $itemcode, $barcode){

		$result = $this->talibon_match($user, $location, $itemcode, $barcode);

		if($result == true){
			return false;
		}else{
			$this->db->insert('tbl_app_countdata_talibon', $talibon);

			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE)
			{
				return true;
			}else{
				return false;
			}
		}	
	}

	public function talibon_match($user, $location, $itemcode, $barcode){
		$result = $this->db->select("tbl_app_countdata_talibon.user_id,
									tbl_app_countdata_talibon.loc_id,
									tbl_app_countdata_talibon.itemcode,
									tbl_app_countdata_talibon.barcode
								   ")
								   ->where('tbl_app_countdata_talibon.user_id', $user)
								   ->where('tbl_app_countdata_talibon.loc_id', $location)
								   ->where('tbl_app_countdata_talibon.itemcode', $itemcode)
								   ->where('tbl_app_countdata_talibon.barcode', $barcode)
								   ->get('tbl_app_countdata_talibon');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function barcode_master_file($data){
			$this->db->insert('item_masterfile_bardcode', $data);
			$this->db->trans_complete();
			if($this->db->affected_rows() > 0){
				return true;
			}else{
				return false;
			}
	}

	public function for_count($data, $item_no, $barcode_no){

			// $this->db->insert('tbl_for_countdata', $data);
			// $this->db->trans_complete();
			// if($this->db->affected_rows() > 0){
			// 	return true;
			// }else{
			// 	return false;
			// }

		$result = $this->for_count_match($item_no, $barcode_no);
		
		if($result == true){
			return false;
		}else{
			$res = $this->db->insert('tbl_for_countdata', $data);
			$this->db->trans_complete();
			if($this->db->affected_rows() > 0){
				return true;
			}
		}
	}

	public function for_count_match($item_no, $barcode_no){
		$result = $this->db->select("
									tbl_for_countdata.item_no,
									tbl_for_countdata.barcode_no
								   ")
								   ->where('tbl_for_countdata.item_no', $item_no)
								   ->where('tbl_for_countdata.barcode_no', $barcode_no)
								   ->get('tbl_for_countdata');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function update_data($table, $ins_update, $ins){
		$result = $this->db->where($ins)
						   ->update($table, $ins_update);
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			return 'success';
		}else{
			return 'error'; 
		}
	}
	public function update_qty_cosnovat_totalcostnovat($sum_qty, $items_code, $qty_cost_novats, $qty_cost_withvats, $location_id){

		$resnovat = $this->qty_cost_novat($qty_cost_novats, $items_code, $location_id);
		$res_withvat = $this->qty_cost_withvat($qty_cost_withvats, $items_code, $location_id);
		$resqty = $this->qty_update($sum_qty, $items_code, $location_id);
	
		if($resnovat == true || $resqty == true || $res_withvat == true){
			return true;
		}else{
			return false;
		}

		// $this->db->trans_complete();
		// if($this->db->trans_status()==TRUE)
		// 	{
		// 		//generate an error... or use the log_message() function to log your error
		// 		$this->db->trans_rollback(); 
		// 		return false;
		// 	}
		// 	else
		// 	{
		// 		$this->db->trans_commit();
		// 		return true;
		// 	}
	}
	public function qty_cost_withvat($qty_cost_withvats, $items_code, $location_id){
		$user_id = $this->session->userdata('user_id');

		$this->db->set($qty_cost_withvats);
		$this->db->where('user_id', $user_id);
		$this->db->where('loc_id', $location_id);
		$this->db->where('item_code', $items_code);
		$this->db->update('collected_items');

		$this->db->trans_complete();
		if($this->db->trans_status() == true){
			return true;
		}else{
			return false;
		}
	}
	public function qty_cost_novat($qty_cost_novats, $items_code, $location_id){
		$user_id = $this->session->userdata('user_id');

		$this->db->set($qty_cost_novats);
		$this->db->where('user_id', $user_id);
		$this->db->where('loc_id', $location_id);
		$this->db->where('item_code', $items_code);
		$this->db->update('collected_items');

		$this->db->trans_complete();
		if($this->db->trans_status() == true){
			return true;
		}else{
			return false;
		}
	}
	public function qty_update($sum_qty, $items_code, $location_id){
		$user_id = $this->session->userdata('user_id');

		$this->db->set($sum_qty);
		$this->db->where('user_id', $user_id);
		$this->db->where('loc_id', $location_id);
		$this->db->where('item_code', $items_code);
		$this->db->update('collected_items');

		$this->db->trans_complete();
		if($this->db->trans_status() == true){
			return true;
		}else{
			return false;
		}
	}

	public function insert_nav($datass, $user, $location, $itemcode, $barcode){

		$result = $this->nav_match($user, $location, $itemcode, $barcode);

		if($result == true){
			return false;
		}else{
			$res = $this->db->insert('tbl_app_countdata_nav', $datass);

			if($this->db->affected_rows() > 0){
				return true;
			}else{
				return false;
			}
		}
	}

	public function nav_match($user, $location, $itemcode, $barcode){
		$result = $this->db->select("tbl_app_countdata_nav.user_id,
									tbl_app_countdata_nav.loc_id,
									tbl_app_countdata_nav.itemcode,
									tbl_app_countdata_nav.barcode
								   ")
								   ->where('tbl_app_countdata_nav.user_id', $user)
								   ->where('tbl_app_countdata_nav.loc_id', $location)
								   ->where('tbl_app_countdata_nav.itemcode', $itemcode)
								   ->where('tbl_app_countdata_nav.barcode', $barcode)
								   ->get('tbl_app_countdata_nav');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function conso_nav($datass, $user, $location, $itemcode, $barcode){

		$result = $this->file_nav_match($user, $location, $itemcode, $barcode);

		if($result == true){
			return false;
		}else{
			$res = $this->db->insert('nav_file', $datass);

			if($this->db->affected_rows() > 0){
				return true;
			}else{
				return false;
			}
		}
	}

	public function file_nav_match($user, $location, $itemcode, $barcode){
		$result = $this->db->select("nav_file.user_id,
									nav_file.loc_id,
									nav_file.itemcode,
									nav_file.barcode
								   ")
								   ->where('nav_file.user_id', $user)
								   ->where('nav_file.loc_id', $location)
								   ->where('nav_file.itemcode', $itemcode)
								   ->where('nav_file.barcode', $barcode)
								   ->get('nav_file');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function get_nav($location_id){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_app_countdata_nav.user_id,
									 tbl_app_countdata_nav.loc_id,
									 tbl_app_countdata_nav.itemcode,
									 tbl_app_countdata_nav.description,
									 tbl_app_countdata_nav.uom,
									 tbl_app_countdata_nav.qty_xl_pm,
									 tbl_app_countdata_nav.qty_xl_alta,
									 tbl_app_countdata_nav.qty_xl_asc,
									 tbl_app_countdata_nav.qty_xl_tal,
									 tbl_app_countdata_nav.qty_xl_icm,
									 tbl_app_countdata_nav.variance,
									 tbl_app_countdata_nav.business_unit,
									 tbl_app_countdata_nav.department,
									
									")
									->where('tbl_app_countdata_nav.user_id', $user_id)
									->where('tbl_app_countdata_nav.loc_id', $location_id)
									->get('tbl_app_countdata_nav');
		return $result->result_array();
	}

	public function get_nav_file($location_id){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("nav_file.user_id,
									 nav_file.loc_id,
									 nav_file.itemcode,
									 nav_file.barcode,
									 nav_file.description,
									 nav_file.uom,
									 nav_file.pm_stock_room,
									 nav_file.pm_selling_area,
									 nav_file.asc_stock_room,
									 nav_file.asc_selling_area,
									 nav_file.alta_stock_room,
									 nav_file.alta_selling_area,
									 nav_file.icm_stock_room,
									 nav_file.icm_selling_area,
									 nav_file.talibon_stock_room,
									 nav_file.talibon_selling_area,
									
									")
									->where('nav_file.user_id', $user_id)
									->where('nav_file.loc_id', $location_id)
									->get('nav_file');
		return $result->result_array();
	}

	public function create_insert_table($item_code, $variant_code, $description, $uom, $qty, $cost_novat,$totalcost_novat, $cost_withvat, $totalcost_withvat, $divcode, $file_locate, $location_id, $user_id)
	{
		$this->load->dbforge();
		$fields=array(
				    'ci_id' => array(
	 			  			'type' => 'INT',
	 			  			'constraint' => 9,
	 			  			'unsigned' => TRUE,
	 			  			'auto_increment' => TRUE
	   			    ),
				   'item_code' => array(
				   			   'type' => 'VARCHAR',
				   			   'constraint' => 10
				  	),
				   'variant_code' => array(
				   				  'type' => 'VARCHAR',
				   				  'constraint' => 10
				   	),
				   'description' => array(
				   				'type' => 'VARCHAR',
				   				'constraint' => 50
				   	),
				   'uom' => array(
				   		 'type' => 'VARCHAR',
				   		 'constraint' => 10		
				   	),
				   'qty' => array(
				   		 'type' => 'VARCHAR',
				   		 'constraint' => 50
				   	),
				   'cost_novat' => array(
				   				'type' => 'VARCHAR',
				   				'constraint' => 100
				   	),
				   'totalcost_novat' => array(
				   					 'type' => 'VARCHAR',
				   					 'constraint' => 100
				   	),
				   'cost_withvat' => array(
				   				  'type' => 'VARCHAR',
				   				  'constraint' => 100
				   	),
				   'totalcost_withvat' => array(
				   					'type' => 'VARCHAR',
				   					'constraint' => 100
				   	),
				   'divcode' => array(
				   			 'type' => 'VARCHAR',
				   			 'constraint' => 20
				   	)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ci_id', TRUE);
		$table = $this->dbforge->create_table('collected_items', TRUE);
		if ($this->db->table_exists('collected_items'))
		{
		     //echo 'table exist';

		     	$response = $this->get_items_match($item_code);
	
				$code_items = array('user_id'	=> $user_id,
							'loc_id'			=> $location_id,
							'item_code' 		=> $item_code, 
							'variant_code' 		=> @$variant_code,
							'description' 		=> $description,
							'uom' 				=> $uom,
							'qty' 				=> $qty,
							'cost_novat' 		=> $cost_novat,
							'totalcost_novat'	=> $totalcost_novat,
							'cost_withvat'		=> $cost_withvat,
							'totalcost_withvat' => $totalcost_withvat,
							'divcode'			=> $divcode
							);

		     	if($response == true){
					return false;
				}else{
					$this->db->trans_start();
		
					//$this->insert_collected_items($code_items);
		
					//$this->insert_file_location($file_locate);
		
					$this->db->insert('collected_items', $code_items);
					$this->db->trans_complete();
					if($this->db->trans_status() == true){
						return true;
					}else{
						return false;
					}
				}

		} 
	}

	// public function insert_collected_items($code_items){
	// 	$this->db->insert('collected_items', $code_items);
	// 	//$this->db->trans_complete();
	// }

	public function insert_file_location($file_locate, $company, $bunit, $dept, $section){

		$result = $this->file_location_match($company, $bunit, $dept, $section);

		if($result == true){
			return false;
		}else{
			$this->db->insert('tbl_filename_location', $file_locate);

			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE)
			{
				return true;
			}else{
				return false;
			}
		}
	}

	public function file_location_match($company, $bunit, $dept, $section){
		$result = $this->db->select("tbl_filename_location.file_name,
									 tbl_filename_location.company,
									 tbl_filename_location.business_unit,
									 tbl_filename_location.department,
									 tbl_filename_location.section
								   ")
								   ->where('tbl_filename_location.company', $company)
								   ->where('tbl_filename_location.business_unit', $bunit)
								   ->where('tbl_filename_location.department', $dept)
								   ->where('tbl_filename_location.section', $section)
								   ->get('tbl_filename_location');
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function insert_cyclic_location($file_locate, $company,  $dept){

		//$result = $this->cyclic_location_match($company,  $dept);

		//if($result == true){
		//	return false;
		//}else{
			$this->db->insert('tbl_cyclic', $file_locate);

			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE)
			{
				return true;
			}else{
				return false;
			}
		//}
	}

	// public function cyclic_location_match($company,  $dept){
	// 	$result = $this->db->select("tbl_cyclic.filename,
	// 								 tbl_cyclic.company,
	// 								 tbl_cyclic.business_unit,
	// 								 tbl_cyclic.department,
	// 								 tbl_cyclic.section
	// 							   ")
	// 							   ->where('tbl_cyclic.company', $company)
	// 							   ->where('tbl_cyclic.department', $dept)
	// 							   ->get('tbl_cyclic');
	// 	if($result->num_rows()>0){
	// 		return true;
	// 	}else{
	// 		return false;
	// 	}
	// }

	public function get_cyclic_locid($company, $dept){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_cyclic.cyclic_id,
									 tbl_cyclic.filename	 
								   ")
								   ->where('tbl_cyclic.user_id', $user_id)
								   ->where('tbl_cyclic.company', $company)			   
								   ->where('tbl_cyclic.department', $dept)
								   ->get('tbl_cyclic');
			return $result->result();
	}

	public function get_items_match($item_code){
		$result = $this->db->select("collected_items.qty,
									 collected_items.cost_novat,
									 collected_items.totalcost_novat,
									 collected_items.cost_withvat,
									 collected_items.totalcost_withvat,
									 collected_items.item_code,
									 collected_items.variant_code,
									 collected_items.divcode,
									 collected_items.uom,
									 collected_items.description
									")
									->like('collected_items.item_code', $item_code)
									->get('collected_items');
        if($result->num_rows()>0)
	    {
	        return true; 
	    }
	    else
	    {
	        return false;
	    }
	}

	public function get_loc_id($company, $bunit, $dept, $section){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_filename_location.loc_id,
									 tbl_filename_location.user_id,
									 tbl_filename_location.file_name	 
								   ")
								   ->where('tbl_filename_location.user_id', $user_id)
								   ->where('tbl_filename_location.company', $company)
								   ->where('tbl_filename_location.business_unit', $bunit)
								   ->where('tbl_filename_location.department', $dept)
								   ->where('tbl_filename_location.section', $section)
								   ->get('tbl_filename_location');
			return $result->result_array();
	}

	public function empty_datatable($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('collected_items'); 
		
		// $this->db->from('collected_items'); 
		// $this->db->truncate(); 
	}

	public function empty_location($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('tbl_filename_location');
	}

	public function empty_cyclic($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('cyclic_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('tbl_cyclic'); 	
	}

	public function delete_pm($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete(' tbl_app_countdata_pm'); 	
	}

	public function delete_datavar($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('tbl_app_countdata_variance'); 
	}

	public function delete_alta($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('tbl_app_countdata_altacita'); 
	}

	public function delete_asc($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('tbl_app_countdata_asc'); 
	}

	public function delete_talibon($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('tbl_app_countdata_talibon'); 
	}

	public function empty_nav_file($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('nav_file'); 	
	}

	public function empty_cyclic_location($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('tbl_app_countdata_variance'); 	
	}

	public function empty_nav($location_id){
		$user_id = $this->session->userdata('user_id');
		$loc_user_id = array('loc_id' => $location_id, 'user_id' => $user_id);

		$this->db->where($loc_user_id);
		$this->db->delete('tbl_app_countdata_nav'); 	
	}

	public function cyclic_table($item_data, $item_code){
		$result = $this->cyclic_match($item_code);
		if($result == true){
			return false;
		}else{
			$this->db->insert('tbl_cyclic', $item_data);
	
			$this->db->trans_complete();
			if($this->db->trans_status() == true){
				return true;
			}else{
				return false;
			}
		}
	}
	public function get_cyclic_id($company, $dept){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_cyclic.cyclic_id,
									 tbl_cyclic.filename,	
								   ")
								   ->where('tbl_cyclic.company', $company)
								   ->where('tbl_cyclic.department', $dept)
								   ->where('tbl_cyclic.user_id', $user_id)
									->get('tbl_cyclic');
		return $result->result_array();
	}

	public function get_cyclic_variance($location_id){
		//var_dump($location_id);
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_app_countdata_variance.user_id,
									 tbl_app_countdata_variance.loc_id,
									 tbl_app_countdata_variance.itemcode,
									 tbl_app_countdata_variance.description,
									 tbl_app_countdata_variance.uom,
									 tbl_app_countdata_variance.qty_db,
									 tbl_app_countdata_variance.qty_excel,
									 tbl_app_countdata_variance.business_unit,
									 tbl_app_countdata_variance.department,
									 tbl_app_countdata_variance.section,
									 tbl_app_countdata_variance.variance,
									")
									->where('tbl_app_countdata_variance.user_id', $user_id)
									->where('tbl_app_countdata_variance.loc_id', $location_id)
									->get('tbl_app_countdata_variance');
		return $result->result_array();
	}

	public function get_variance_pm($location_id){
		//var_dump($location_id);
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_app_countdata_pm.user_id,
									 tbl_app_countdata_pm.loc_id,
									 tbl_app_countdata_pm.itemcode,
									 tbl_app_countdata_pm.description,
									 tbl_app_countdata_pm.uom,
									 tbl_app_countdata_pm.qty_pm,
									 tbl_app_countdata_pm.qty_excel,
									 tbl_app_countdata_pm.variance,
									 tbl_app_countdata_pm.business_unit,
									 tbl_app_countdata_pm.department,
									 tbl_app_countdata_pm.section
									 
									")
									->where('tbl_app_countdata_pm.user_id', $user_id)
									->where('tbl_app_countdata_pm.loc_id', $location_id)
									->get('tbl_app_countdata_pm');
		return $result->result_array();
	}

	public function get_data_alta($location_id){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_app_countdata_altacita.user_id,
									 tbl_app_countdata_altacita.loc_id,
									 tbl_app_countdata_altacita.itemcode,
									 tbl_app_countdata_altacita.description,
									 tbl_app_countdata_altacita.uom,
									 tbl_app_countdata_altacita.qty_alta,
									 tbl_app_countdata_altacita.qty_excel,
									 tbl_app_countdata_altacita.variance,
									 tbl_app_countdata_altacita.business_unit,
									 tbl_app_countdata_altacita.department,
									 tbl_app_countdata_altacita.section
									 
									")
									->where('tbl_app_countdata_altacita.user_id', $user_id)
									->where('tbl_app_countdata_altacita.loc_id', $location_id)
									->get('tbl_app_countdata_altacita');
		return $result->result_array();
	}

	public function get_data_asc($location_id){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_app_countdata_asc.user_id,
									 tbl_app_countdata_asc.loc_id,
									 tbl_app_countdata_asc.itemcode,
									 tbl_app_countdata_asc.description,
									 tbl_app_countdata_asc.uom,
									 tbl_app_countdata_asc.qty_asc,
									 tbl_app_countdata_asc.qty_excel,
									 tbl_app_countdata_asc.variance,
									 tbl_app_countdata_asc.business_unit,
									 tbl_app_countdata_asc.department,
									 tbl_app_countdata_asc.section
									
									")
									->where('tbl_app_countdata_asc.user_id', $user_id)
									->where('tbl_app_countdata_asc.loc_id', $location_id)
									->get('tbl_app_countdata_asc');
		return $result->result_array();
	}

	public function get_data_talibon($location_id){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("tbl_app_countdata_talibon.user_id,
									 tbl_app_countdata_talibon.loc_id,
									 tbl_app_countdata_talibon.itemcode,
									 tbl_app_countdata_talibon.description,
									 tbl_app_countdata_talibon.uom,
									 tbl_app_countdata_talibon.qty_talibon,
									 tbl_app_countdata_talibon.qty_excel,
									 tbl_app_countdata_talibon.variance,
									 tbl_app_countdata_talibon.business_unit,
									 tbl_app_countdata_talibon.department,
									 tbl_app_countdata_talibon.section
									
									")
									->where('tbl_app_countdata_talibon.user_id', $user_id)
									->where('tbl_app_countdata_talibon.loc_id', $location_id)
									->get('tbl_app_countdata_talibon');
		return $result->result_array();
	}

	public function cyclic_match($item_code){
		$result = $this->db->select("tbl_cyclic.item_code,
									 tbl_cyclic.variant_code,
									 tbl_cyclic.description,
									 tbl_cyclic.uom,
									 tbl_cyclic.qty
									")
									->like('tbl_cyclic.item_code', $item_code)
									->get('tbl_cyclic');
		 if($result->num_rows()>0)
	        	{
	        	    return true; 
	        	}
	        	else
	        	{
	        	    return false;
	        	}
	}
	public function get_items($location_id, $user_id){
		$result = $this->db->select("collected_items.user_id,
									 collected_items.loc_id,
									 collected_items.qty,
									 collected_items.cost_novat,
									 collected_items.totalcost_novat,
									 collected_items.cost_withvat,
									 collected_items.totalcost_withvat,
									 collected_items.item_code,
									 collected_items.variant_code,
									 collected_items.divcode,
									 collected_items.uom,
									 collected_items.description
									")
									->where('collected_items.loc_id', $location_id)
									->where('collected_items.user_id', $user_id)
									->get('collected_items');

		if($result->num_rows()>0)
        {
            return $result->result_array(); 
        }
        else
        {
            return null;
        } 
	
	}	
	public function get_monthly_items($item_code, $location_id){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select("collected_items.user_id,
									 collected_items.loc_id,
									 collected_items.qty,
									 collected_items.cost_novat,
									 collected_items.totalcost_novat,
									 collected_items.cost_withvat,
									 collected_items.totalcost_withvat,
									 collected_items.item_code,
									 collected_items.variant_code,
									 collected_items.divcode,
									 collected_items.uom,
									 collected_items.description
									")
									->where('collected_items.item_code', $item_code)
									->where('collected_items.loc_id', $location_id)
									->where('collected_items.user_id', $user_id)
									->get('collected_items');
		return $result->result_array();
	}

	public function get_count_items($codes, $range_date){
		//$user_id = $this->session->userdata('user_id');
			//var_dump($codes);
		$result = $this->db->select("tbl_app_countdata.itemcode,
								 tbl_app_countdata.barcode,
								 tbl_app_countdata.description,
								 tbl_app_countdata.uom,
								 tbl_app_countdata.qty,
								 tbl_app_countdata.business_unit,
								 tbl_app_countdata.department,
								 tbl_app_countdata.section,
								 tbl_app_countdata.rack_desc,
								 tbl_app_countdata.empno,
								 tbl_app_countdata.datetime_scanned,
								 tbl_app_countdata.datetime_saved,
								 tbl_app_countdata.datetime_exported
							   ")
								->where('tbl_app_countdata.itemcode', $codes)
								->where('tbl_app_countdata.datetime_saved', $range_date)
								->order_by('id', 'asc')
								->get('tbl_app_countdata');
		return $result->result_array();							
	}

		public function pcount_items($codes, $range_date, $brcode){
		//$user_id = $this->session->userdata('user_id');
			//var_dump($codes);
		$result = $this->db->select("tbl_app_countdata.itemcode,
								 tbl_app_countdata.barcode,
								 tbl_app_countdata.description,
								 tbl_app_countdata.uom,
								 tbl_app_countdata.qty,
								 tbl_app_countdata.business_unit,
								 tbl_app_countdata.department,
								 tbl_app_countdata.section,
								 tbl_app_countdata.rack_desc,
								 tbl_app_countdata.empno,
								 tbl_app_countdata.datetime_scanned,
								 tbl_app_countdata.datetime_saved,
								 tbl_app_countdata.datetime_exported
							   ")
								->where('tbl_app_countdata.itemcode', $codes)
								//->where('tbl_app_countdata.barcode', $brcode)
								//->where('tbl_app_countdata.datetime_saved', $range_date)
								->order_by('id', 'asc')
								->get('tbl_app_countdata');
		return $result->result_array();							
	}

	public function get_count_data($itemcodes){
		//$user_id = $this->session->userdata('user_id');
			//var_dump($codes);
		$result = $this->db->select("tbl_app_countdata.itemcode,
								 tbl_app_countdata.barcode,
								 tbl_app_countdata.description,
								 tbl_app_countdata.uom,
								 tbl_app_countdata.qty,
								 tbl_app_countdata.business_unit,
								 tbl_app_countdata.department,
								 tbl_app_countdata.section,
								 tbl_app_countdata.rack_desc,
								 tbl_app_countdata.empno,
								 tbl_app_countdata.datetime_scanned,
								 tbl_app_countdata.datetime_saved,
								 tbl_app_countdata.datetime_exported
							   ")
								->where('tbl_app_countdata.itemcode', $itemcodes)
								//->where('tbl_app_countdata.barcode', $brcode)
								->order_by('id', 'asc')
								
								->get('tbl_app_countdata');
		if($result->num_rows()>0)
        {
           return $result->result_array(); 
        }
        else
        {
            return null;
        }							
	}

	public function pcount_data($itemcodes,$brcode){
		//$user_id = $this->session->userdata('user_id');
			//var_dump($codes);
		$result = $this->db->select("tbl_app_countdata.itemcode,
								 tbl_app_countdata.barcode,
								 tbl_app_countdata.description,
								 tbl_app_countdata.uom,
								 tbl_app_countdata.qty,
								 tbl_app_countdata.business_unit,
								 tbl_app_countdata.department,
								 tbl_app_countdata.section,
								 tbl_app_countdata.rack_desc,
								 tbl_app_countdata.empno,
								 tbl_app_countdata.datetime_scanned,
								 tbl_app_countdata.datetime_saved,
								 tbl_app_countdata.datetime_exported
							   ")
								->where('tbl_app_countdata.itemcode', $itemcodes)
								//->where('tbl_app_countdata.barcode', $brcode)
								->order_by('id', 'asc')
								
								->get('tbl_app_countdata');
		
           return $result->result_array(); 							
	}

	public function physical_count_data($bunit, $dept, $section){

		$result = $this->db->select("tbl_app_countdata.itemcode,
								 tbl_app_countdata.barcode,
								 tbl_app_countdata.description,
								 tbl_app_countdata.uom,
								 tbl_app_countdata.qty,
								 tbl_app_countdata.business_unit,
								 tbl_app_countdata.department,
								 tbl_app_countdata.section,
								 tbl_app_countdata.rack_desc,
								 tbl_app_countdata.empno,
								 tbl_app_countdata.datetime_scanned,
								 tbl_app_countdata.datetime_saved,
								 tbl_app_countdata.datetime_exported
							   ")
								//->where('tbl_app_countdata.itemcode', $itemcodes)
								->where('tbl_app_countdata.business_unit', $bunit)
								->where('tbl_app_countdata.department', $dept)
								->where('tbl_app_countdata.section', $section)
								//->where('tbl_app_countdata.barcode', $brcode)
								->order_by('id', 'asc')
								
								->get('tbl_app_countdata');
		
           return $result->result_array(); 							
	}


	public function get_data_nav(){
		$result = $this->db->select("collected_items.item_code,
								 collected_items.description,
								 collected_items.uom,
								 collected_items.qty,
								 
							   ")
								//->where('collected_items.item_code', $itemcodes)
								->order_by('ci_id', 'asc')
								->get('collected_items');
		
           return $result->result_array(); 							
	}

	public function get_count_data_nav(){

		$result = $this->db->select("tbl_app_countdata_nav.itemcode,
								 tbl_app_countdata_nav.barcode,
								 tbl_app_countdata_nav.description,
								 tbl_app_countdata_nav.uom,
								 tbl_app_countdata_nav.qty_xl_pm,
								 tbl_app_countdata_nav.qty_xl_alta,
								 tbl_app_countdata_nav.qty_xl_asc,
								 tbl_app_countdata_nav.qty_xl_tal,
								 tbl_app_countdata_nav.qty_xl_icm,
								 tbl_app_countdata_nav.business_unit,
								 tbl_app_countdata_nav.department,
								 tbl_app_countdata_nav.section,
								 tbl_app_countdata_nav.rack_desc,
								 tbl_app_countdata_nav.empno,
								 tbl_app_countdata_nav.datetime_scanned,
								 tbl_app_countdata_nav.datetime_saved,
								 tbl_app_countdata_nav.datetime_exported
							   ")
								//->where('tbl_app_countdata_nav.itemcode', $itemcodes)
								//->where('tbl_app_countdata.barcode', $brcode)
								->order_by('id', 'asc')
								
								->get('tbl_app_countdata_nav');
		
           return $result->result_array(); 							
	}


	public function match_item_code($string_codes){
		$result = $this->db->select("
									collected_items.item_code
									
								    ")
									->like('collected_items.item_code', $string_codes)
									
									->get('collected_items');
			 if($result->num_rows()>0)
	        	{
	        	    return true; 
	        	}
	        	else
	        	{
	        	    return false;
	        	}
	}
	public function update_items($code, $datas){
		$result = $this->db->where($code)->update('collected_items', $datas);
		if($this->db->trans_status()==TRUE)
			{
				return true;
			}
			else
			{
				return false;
			}
	}
	public function check_report($report_id){
		var_dump($report_id);
		$result = $this->db->where(array('report_id'=> $report_id))->get('report_data')->row_array();
		return $result['report_path'];
	}

	public function cyclic_report_path($report_id){
		$result = $this->db->where(array('report_id'=> $report_id))->get('tbl_cyclic_report')->row_array();
		return $result['report_path'];
	}

	public function excel_report_path($report_id){
		$result = $this->db->where(array('report_id'=> $report_id))->get('tbl_cyclic_report')->row_array();
		return $result['excel_report'];
	}

	public function get_cyclic_count()
	{
        $query = $this->db->get('tbl_cyclic_report');
        return $query->num_rows(); 
    }	

    public function update_monthly_count(){
    	$query = $this->db->get('tbl_filename_location');
    	return $query->num_rows();
    }

	public function updateuserstatus($users_id, $userstatus){
		$result = $this->db->where($users_id)->update('tbl_users', $userstatus);
	}	
	public function unset_status($userstatus, $users_id){
		$result = $this->db->where($users_id)->update('tbl_users', $userstatus);
	}
    public function get_report_count()
	{
        $query = $this
                ->db
                ->get('report_data');
    
        return $query->num_rows(); 
    }
    public function get_report($limit,$start,$order,$dir,$user_id){
    	$result = $this->db->select("report_data.report_id,
    								 report_data.user_id,
    								 report_data.file_name,
    								 report_data.report_path,
    								 report_data.date_uploaded
    								")
    								->where('report_data.user_id', $user_id)
    								->limit($limit,$start)
    								->order_by('report_data.report_id','ASC')
            						->get('report_data');
        if($result->num_rows()>0)
        {
            return $result->result(); 
        }
        else
        {
            return null;
        } 
    }

    public function search_report($limit,$start,$search,$order,$dir){
    	$result = $this->db->select("report_data.report_id,
    								 report_data.user_id,
    								 report_data.file_name,
    								 report_data.report_path,
    								 report_data.date_uploaded
    								")
    								->like('report_data.report_id', $search)
    								->or_like('report_data.user_id', $search)
    								->or_like('report_data.file_name', $search)
    								->or_like('report_data.report_path', $search)
    								->or_like('report_data.date_uploaded', $search)
    								->limit($limit,$start)
    								->order_by('report_data.report_id','DESC')
            						->get('report_data');
           
        if($result->num_rows()>0)
        {
            return $result->result(); 
        }
        else
        {
            return null;
        }
    }

    public function update_monthly_report($limit,$start,$order,$dir,$user_id){
    	$result = $this->db->select("tbl_filename_location.loc_id,
    								 tbl_filename_location.user_id,
    								 tbl_filename_location.file_name,
    								 tbl_filename_location.company,
    								 tbl_filename_location.business_unit,
    								 tbl_filename_location.department,
    								 tbl_filename_location.section
    								")
    								->where('tbl_filename_location.user_id', $user_id)
    								->limit($limit,$start)
    								->order_by('tbl_filename_location.loc_id','ASC')
            						->get('tbl_filename_location');
        if($result->num_rows()>0)
        {
            return $result->result(); 
        }
        else
        {
            return null;
        } 
    }

    public function get_cyclic_report($limit,$start,$order,$dir,$user_id){
    	$result = $this->db->select("tbl_cyclic_report.report_id,
    								 tbl_cyclic_report.user_id,
    								 tbl_cyclic_report.file_name,
    								 tbl_cyclic_report.report_path,
    								 tbl_cyclic_report.date_uploaded
    								")
    								->where('tbl_cyclic_report.user_id', $user_id)
    								->limit($limit,$start)
    								->order_by('tbl_cyclic_report.report_id','ASC')
            						->get('tbl_cyclic_report');
        if($result->num_rows()>0)
        {
            return $result->result(); 
        }
        else
        {
            return null;
        } 
    }


    public function search_update_monthly($limit,$start,$search,$order,$dir){
    	$result = $this->db->select("tbl_filename_location.loc_id,
    								 tbl_filename_location.user_id,
    								 tbl_filename_location.file_name,
    								 tbl_filename_location.company,
    								 tbl_filename_location.business_unit,
    								 tbl_filename_location.department,
    								 tbl_filename_location.section
    								")
    								->like('tbl_filename_location.file_name', $search)
    								->or_like('tbl_filename_location.company', $search)
    								->or_like('tbl_filename_location.business_unit', $search)
    								->or_like('tbl_filename_location.department', $search)
    								->or_like('tbl_filename_location.section', $search)
    								->limit($limit,$start)
    								->order_by('tbl_filename_location.loc_id','DESC')
            						->get('tbl_filename_location');
           
        if($result->num_rows()>0)
        {
            return $result->result(); 
        }
        else
        {
            return null;
        }
    }

    public function search_cyclic_report($limit,$start,$search,$order,$dir){
    	$result = $this->db->select("tbl_cyclic_report.report_id,
    								 tbl_cyclic_report.user_id,
    								 tbl_cyclic_report.file_name,
    								 tbl_cyclic_report.report_path,
    								 tbl_cyclic_report.date_uploaded
    								")
    								->like('tbl_cyclic_report.report_id', $search)
    								->or_like('tbl_cyclic_report.user_id', $search)
    								->or_like('tbl_cyclic_report.file_name', $search)
    								->or_like('tbl_cyclic_report.report_path', $search)
    								->or_like('tbl_cyclic_report.date_uploaded', $search)
    								->limit($limit,$start)
    								->order_by('tbl_cyclic_report.report_id','DESC')
            						->get('tbl_cyclic_report');
           
        if($result->num_rows()>0)
        {
            return $result->result(); 
        }
        else
        {
            return null;
        }
    }
}