<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Appm extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// public function checkConnection(){
	// 	$count = $this->db->from("customer_master_files")->count_all_results();
	// 	return $count;
	// }

	// public function getBannerImage(){
	//    	$this->db->select('*');
	//    	$this->db->from('tbl_banner_image');

	//    	$this->db->order_by('tbl_banner_image.id','asc');
	// 	// $this->db->where('banner_details', '1');
	//    	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	// public function getSpecialDeals(){
	//    	$this->db->select('item_masterfiles.item_masterfiles_id,item_masterfiles.product_name,item_masterfiles.itemcode,item_masterfiles.list_price_wtax,item_masterfiles.uom,item_masterfiles.product_family,tbl_item_image.item_path,item_masterfiles.principal, item_masterfiles.rate,item_masterfiles.status');
	//    	$this->db->from('item_masterfiles');
	//    	$this->db->join('tbl_item_image', 'item_masterfiles.itemcode = tbl_item_image.item_code AND item_masterfiles.uom = tbl_item_image.item_uom');
	//    	// $this->db->join('tbl_category_masterfile','item_masterfiles.product_family = tbl_category_masterfile.id');
	//    	$this->db->where('item_masterfiles.isPromo', 1);
	//    	$this->db->where('item_masterfiles.conversion_qty', 1);
	//    	$this->db->group_by('item_masterfiles.itemcode');
	//    	$this->db->order_by('item_masterfiles.itemcode','asc');
	//    	$this->db->limit(5);

	//    	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return "no records";
	//    	}
	//    }

	//    public function getSpecialDealsAll(){
	//    	$this->db->select('item_masterfiles.item_masterfiles_id,item_masterfiles.product_name,item_masterfiles.itemcode,item_masterfiles.list_price_wtax,item_masterfiles.uom,item_masterfiles.product_family,tbl_item_image.item_path,item_history_logs.price1,item_masterfiles.principal, item_masterfiles.rate, item_masterfiles.status');
	//    	$this->db->from('item_masterfiles');
	//    	$this->db->join('item_history_logs','item_history_logs.log_id = (select max(item_history_logs.log_id) from item_history_logs where item_masterfiles.itemcode = item_history_logs.itemcode AND item_masterfiles.uom = item_history_logs.uom1)',"left");
	//    	$this->db->join('tbl_item_image', 'item_masterfiles.itemcode = tbl_item_image.item_code AND item_masterfiles.uom = tbl_item_image.item_uom');
	//    	// $this->db->join('tbl_category_masterfile','item_masterfiles.product_family = tbl_category_masterfile.id');
	//    	$this->db->where('item_masterfiles.isPromo', 1);
	//    	$this->db->where('item_masterfiles.conversion_qty', 1);
	//    	$this->db->group_by('item_masterfiles.itemcode');
	//    	$this->db->order_by('item_masterfiles.itemcode','asc');

	//    	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return "no records";
	//    	}
	//    }

	//    public function getTopProducts(){
	//    	$this->db->select('item_masterfiles.item_masterfiles_id,tb_tran_line.itm_code, item_masterfiles.product_name,item_masterfiles.list_price_wtax,item_masterfiles.uom,sum(tb_tran_line.req_qty) as tran_qty,tbl_item_image.item_path,item_masterfiles.product_family,item_masterfiles.principal, item_masterfiles.rate,item_masterfiles.status');
	//    	$this->db->from('tb_tran_line');
	//    	$this->db->join('item_masterfiles', 'tb_tran_line.itm_code = item_masterfiles.itemcode AND tb_tran_line.uom = item_masterfiles.uom', "left");
	//    	$this->db->join('tbl_item_image','item_masterfiles.itemcode = tbl_item_image.item_code AND item_masterfiles.uom = tbl_item_image.item_uom',"left");
	//    	// $this->db->where('item_masterfiles.isPromo',0); //1 = Promo, 0 = Products //default 1 for sample
	//    	$this->db->group_by('tb_tran_line.itm_code');
	//    	$this->db->order_by('tran_qty','desc');
	//    	$this->db->limit(5);

	// 	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return "no records";
	//    	}
	//    }

	//    public function getTopProductsAll(){
	//    	$this->db->select('item_masterfiles.item_masterfiles_id,tb_tran_line.itm_code, item_masterfiles.product_name,item_masterfiles.list_price_wtax,item_masterfiles.uom,sum(tb_tran_line.req_qty) as tran_qty,tbl_item_image.item_path,item_masterfiles.product_family,item_masterfiles.principal, item_masterfiles.rate,item_masterfiles.status');
	//    	$this->db->from('tb_tran_line');
	//    	$this->db->join('item_masterfiles', 'tb_tran_line.itm_code = item_masterfiles.itemcode AND tb_tran_line.uom = item_masterfiles.uom', "left");
	//    	$this->db->join('tbl_item_image','item_masterfiles.itemcode = tbl_item_image.item_code AND item_masterfiles.uom = tbl_item_image.item_uom',"left");
	//    	// $this->db->where('item_masterfiles.isPromo',0); //1 = Promo, 0 = Products //default 1 for sample
	//    	$this->db->group_by('tb_tran_line.itm_code');
	//    	$this->db->order_by('tran_qty','desc');
	//    	// $this->db->limit(5);

	// 	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return "no records";
	//    	}
	//    }

	// public function getProductCategories(){
	//    	$this->db->select('*');
	// 	$this->db->from('tbl_category_masterfile');
	// 	//$this->db->where('tbl_category_masterfile.category_name !=', 'PROMO ITEMS');

	// 	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return "no records";
	//    	}
	//    }

	//    public function getProductUOM($productID, $customer){
	//    	$this->db->select('item_masterfiles.item_masterfiles_id,item_masterfiles.product_name,item_masterfiles.uom, item_masterfiles.list_price_wtax,tbl_item_image.item_path, item_masterfiles.rate,item_masterfiles.status, tb_favorites.doc_no');
	//    	$this->db->from('item_masterfiles');
	//    	$this->db->join('tbl_item_image', 'item_masterfiles.itemcode = tbl_item_image.item_code AND item_masterfiles.uom = tbl_item_image.item_uom');
	//    	$this->db->join('tb_favorites', 'tb_favorites.item_code = item_masterfiles.itemcode AND tb_favorites.item_uom = item_masterfiles.uom AND tb_favorites.account_code ="'.$customer.'"', 'left');
	//    	$this->db->where('item_masterfiles.itemcode', $productID);
	//    	$this->db->order_by('item_masterfiles.conversion_qty', 'asc');

	//    	$query = $this->db->get();
	// 	$res = $query->result_array();
	// 	if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return "no records";
	//    	}
	//    }

	//    public function addToFavorites($itemcode, $itemuom, $accountCode){
	// 	$data	= array(
	// 		"item_code"			=> $this->security->xss_clean($itemcode),
	// 		"item_uom"			=> $this->security->xss_clean($itemuom),
	// 		"account_code"		=> $this->security->xss_clean($accountCode),
	// 	);
	// 	$this->db->insert('tb_favorites', $data);
	// 	return true;
	// }

	// public function removeToFavorites($itemcode, $itemuom, $accountCode){
	// 	$this->db->delete('tb_favorites', array('item_code' => $itemcode, 'item_uom' => $itemuom, 'account_code' => $accountCode));

	//    	if($this->db->affected_rows()){
	// 	  return true;
	// 	}
	// 	else{
	// 	  return false;
	// 	}
	// }

	//    public function getProductList($category){
	//    	$this->db->select('item_masterfiles.itemcode, item_masterfiles.item_masterfiles_id,item_masterfiles.product_name,item_masterfiles.itemcode,item_masterfiles.list_price_wtax,item_masterfiles.uom,tbl_item_image.item_path,item_masterfiles.product_family,item_masterfiles.status, item_masterfiles.rate, item_history_logs.price1,item_masterfiles.status');
	//    	$this->db->join('item_history_logs','item_history_logs.log_id = (select max(item_history_logs.log_id) from item_history_logs where item_masterfiles.itemcode = item_history_logs.itemcode AND item_masterfiles.uom = item_history_logs.uom1)',"left");
	//   		$this->db->join('tbl_item_image', 'item_masterfiles.itemcode = tbl_item_image.item_code AND item_masterfiles.uom = tbl_item_image.item_uom', "left");
	//   		$this->db->where('item_masterfiles.product_family', $category);
	//   		$this->db->where('item_masterfiles.conversion_qty', 1);
	//   		$this->db->group_by('item_masterfiles.itemcode');
	//   		$this->db->order_by('item_masterfiles.product_name', 'ASC');

	//   		$query = $this->db->get('item_masterfiles');
	//   		$res = $query->result_array();
	//   		if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return "no records";
	//    	}
	//    }

	//    public function getProductListAll(){
	//    	$this->db->select('item_masterfiles.itemcode,item_masterfiles.barcode, item_masterfiles.item_masterfiles_id,item_masterfiles.product_name,item_masterfiles.itemcode,item_masterfiles.list_price_wtax,item_masterfiles.uom,tbl_item_image.item_path,item_masterfiles.product_family,item_masterfiles.status, item_masterfiles.rate, item_history_logs.price1');
	//    	$this->db->join('item_history_logs','item_history_logs.log_id = (select max(item_history_logs.log_id) from item_history_logs where item_masterfiles.itemcode = item_history_logs.itemcode AND item_masterfiles.uom = item_history_logs.uom1)',"left");
	//   		$this->db->join('tbl_item_image', 'item_masterfiles.itemcode = tbl_item_image.item_code AND item_masterfiles.uom = tbl_item_image.item_uom', "left");
	//   		$this->db->where('item_masterfiles.conversion_qty', 1);
	//   		$this->db->group_by('item_masterfiles.itemcode');
	//   		$this->db->order_by('item_masterfiles.product_name', 'ASC');

	//   		$query = $this->db->get('item_masterfiles');
	//   		$res = $query->result_array();
	//   		if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return "no records";
	//    	}
	//    }

	//    public function searchCustomer($mobile){
	// 	$this->db->select('*');
	// 	$this->db->from('customer_master_files');
	// 	$this->db->where('cus_mobile_number', $mobile);

	// 	$query = $this->db->get();
	// 	$res = $query->row_array();
	// 	if(isset($res))
	// 	{
	// 	    return $res;
	// 	}
	// 	else
	// 	{
	// 		return $res;
	// 	}
	// }

	// public function checkUser($mobile, $password){
	// 	$this->db->select('*');
	// 	$this->db->from('customer_master_files');
	// 	$this->db->where('cus_mobile_number', $mobile);
	// 	$this->db->limit(1);

	// 	$query = $this->db->get();
	// 	$res = $query->row_array();
	// 	if(isset($res))
	// 	{
	// 		if($res['cus_password'] == md5($password)){
	// 	   		return $res;
	// 		}else{
	// 			return "failedp";
	// 		}
	// 	}
	// 	else
	// 	{
	// 		return "failed";
	// 	}
	// }

	// public function checkCusBlock($mobile){
	// 	$this->db->select('*');
	// 	$this->db->from('customer_master_files');
	// 	$this->db->where('cus_mobile_number', $mobile);
	// 	$this->db->where('isBlock',1);
	// 	$this->db->limit(1);

	// 	$query = $this->db->get();
	// 	$res = $query->row_array();
	// 	if(isset($res))
	// 	{
	// 	    return $res;
	// 	}
	// 	else
	// 	{
	// 		return $res;
	// 	}
	// }

	// public function setCustomerBlock($mobile){
	// 	$data	= array(
	// 		"isBlock"			=> 1,
	// 	);
	// 	$this->db->where('cus_mobile_number',$mobile);
	// 	$res = $this->db->update('customer_master_files',$data);
	// 	if($res){
	// 		return "done";
	// 	}
	// }

	// public function saveSMSCode($mobile, $code){
	// 	$data	= array(
	// 		"smsCode"			=> $this->security->xss_clean($code),
	// 	);
	// 	$this->db->where('cus_mobile_number',$mobile);
	// 	$res = $this->db->update('customer_master_files',$data);
	// 	if($res){
	// 		return 1;
	// 	}
	// }

	// public function checkSMSCode($mobile, $code){
	// 	$this->db->select('*');
	// 	$this->db->from('customer_master_files');
	// 	$this->db->where('cus_mobile_number', $mobile);
	// 	$this->db->where('smsCode', $code);
	// 	$this->db->limit(1);
	// 	$query = $this->db->get();

	// 	$res = $query->row_array();

	// 	if(isset($res))
	// 	{
	// 	    return $res;
	// 	}
	// }

	// public function removeLocked($accountCode){
	// 	$data	= array(
	// 		"isBlock"			=> 0,
	// 		"password_date" 	=> date("Y-m-d"),
	// 	);
	// 	$this->db->where('account_code',$accountCode);
	// 	$this->db->update('customer_master_files',$data);
	// 	return "done";
	// }

	// public function changePass($accountCode, $newpass){
	// 	$data	= array(
	// 		"cus_password"		=> $this->security->xss_clean(md5($newpass)),
	// 		"password_date" 	=> date("Y-m-d"),
	// 		"first_log"			=> 'done',
	// 	);
	// 	$this->db->where('account_code',$accountCode);
	// 	$this->db->update('customer_master_files',$data);
	// 	return "done";
	// }

	// public function insertChangePassHistory($accountCode, $pass){
	// 	$data	= array(
	// 		"account_code"	=> $this->security->xss_clean($accountCode),
	// 		"password"			=> $this->security->xss_clean(md5($pass)),
	// 		"date_created"		=> date("Y-m-d"),
	// 		"time_created"		=> date("H:i:s"),
	// 	);
	// 	$this->db->insert('pass_history', $data);
	// 	return true;
	// }

	// public function getMunicipality(){
	// 	$this->db->order_by('mun_name', 'ASC');
	// 	$this->db->select("*");			
	// 	$query	= $this->db->get('tbl_municipality_masterfile');
	// 	return $query->result_array();
	// }

	// public function getBarangay($mcode){
	// 	$muncode	= $this->security->xss_clean($mcode);

	// 	$this->db->order_by('bar_code', 'ASC');
	// 	$this->db->select("*");			
	// 	$this->db->where('bar_mun_code', $muncode);
	// 	$query	= $this->db->get('tbl_barangay_masterfile');
	// 	return $query->result_array();
	// }

	// public function checkMobileExistRegistered($mobileNumber){
	// 	$this->db->select('*');
	// 	$this->db->from('customer_master_files');
	// 	$this->db->where('cus_mobile_number', $mobileNumber);
	// 	$query = $this->db->get();

	// 	$res = $query->row_array();

	// 	if(isset($res))
	// 	{
	// 	    return $res;
	// 	}else{
	// 		return $res;
	// 	}
	// }

	// public function checkMobileExistRequest($mobileNumber){
	// 	$this->db->select('*');
	// 	$this->db->from('tbl_customer_request');
	// 	$this->db->where('mobile_number', $mobileNumber);
	// 	$query = $this->db->get();

	// 	$res = $query->row_array();

	// 	if(isset($res))
	// 	{
	// 	    return $res;
	// 	}else{
	// 		return $res;
	// 	}
	// }

	// public function registerCustomer($ownerName, $mobileNumber, $telephoneNumber, $streeAdd, $landmark, $munCode, $barCode, $storeName, $dtiNo, $bcPhoto, $storePhoto, $tempPassword){
	// 	$data =  (object) array(
	// 	        'store_name' 		=> $storeName,
	// 	        'dti_no'        	=> $dtiNo,
	// 	        'owner_name'        => $ownerName,
	// 	        'mobile_number'     => $mobileNumber,
	// 	        'telephone_number'  => $telephoneNumber,
	// 	        'temp_password'  	=> md5($tempPassword),
	// 	        'temp_plain'  		=> $tempPassword,
	// 	        'street_add'		=> $streeAdd,
	// 	        'landmark'		  	=> $landmark,
	// 	        'bar_code'		    => $barCode,
	// 	        'mun_code'		    => $munCode,
	// 	        'store_photo'		=> $storePhoto,
	// 	        'bc_photo'		    => $bcPhoto,
	// 	        'status'		    => 'Pending',
	// 	        'date_req'          => date('Y-m-d H:i:s'),
	// 	);
	// 	$this->db->insert('tbl_customer_request',$data);
	// 	$query = $this->db->affected_rows();
	//    	if($query == 1)
	//    	{
	//    		return $data;
	//    	}else
	//    	{
	//    		return "failed insert";
	//    	}
	// }

	// public function getExistProductInCart($customer, $productID, $productUOM){
	//   		$this->db->select('*');
	//   		$this->db->from('tbl_customer_cart');
	//   		$this->db->where('tbl_customer_cart.cus_account_code',$customer);
	//   		$this->db->where('tbl_customer_cart.item_code',$productID);
	//   		$this->db->where('tbl_customer_cart.item_uom',$productUOM);

	//   		$query = $this->db->get();
	// 	$res = $query->result_array();
	// 	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	//    public function updateProductCart($customer, $productID, $productUOM, $productQTY){
	//    	$data = array(
	// 	        'cus_account_code' => $customer,
	// 	        'item_code'        => $productID,
	// 	        'item_uom'         => $productUOM,
	// 	        'item_qty'         => $productQTY
	// 	);
	// 	$this->db->set('item_qty',$productQTY,false);
	// 	$this->db->where('cus_account_code',$customer);
	// 	$this->db->where('item_code',$productID);
	// 	$this->db->where('item_uom',$productUOM);
	// 	$this->db->update('tbl_customer_cart');

	// 	$query = $this->db->affected_rows();
	//    	if($query == 1)
	//    	{
	//    		// return $query;
	//    		return "success update";
	//    	}else
	//    	{
	//    		// return FALSE;
	//    		return "failed update";
	//    	}
	//    }

	//    public function insertProductCart($customer, $productID, $productUOM, $productQTY, $productCategory){
	//    	$data =  (object) array(
	// 	        'cus_account_code' => $customer,
	// 	        'item_code'        => $productID,
	// 	        'item_uom'         => $productUOM,
	// 	        'item_qty'         => $productQTY,
	// 	        'item_cat'		   => $productCategory,
	// 	);


	//    	$this->db->insert('tbl_customer_cart',$data);

	//    	$query = $this->db->affected_rows();
	//    	if($query == 1)
	//    	{
	//    		// return $query;
	//    		return $data;
	//    	}else
	//    	{
	//    		// return FALSE;
	//    		return "failed insert";
	//    	}
	//    }

	//    public function getCustomerCart($cuscode){
	//    	$this->db->select('tbl_customer_cart.cus_account_code, tbl_customer_cart.item_code, item_masterfiles.product_name, tbl_customer_cart.item_uom, tbl_customer_cart.item_qty,tbl_customer_cart.chk, item_masterfiles.list_price_wtax,tbl_customer_cart.item_cat, tbl_item_image.item_path,tbl_category_masterfile.category_name');
	//    	$this->db->from('tbl_customer_cart');
	//    	$this->db->join('item_masterfiles', 'item_masterfiles.itemcode = tbl_customer_cart.item_code  AND item_masterfiles.uom = tbl_customer_cart.item_uom');
	//    	$this->db->join('tbl_item_image', 'tbl_item_image.item_code = tbl_customer_cart.item_code AND tbl_item_image.item_uom = tbl_customer_cart.item_uom');
	//    	$this->db->join('tbl_category_masterfile','tbl_category_masterfile.category_name = tbl_customer_cart.item_cat');
	//    	$this->db->where('tbl_customer_cart.chk',1);
	//    	$this->db->where('tbl_customer_cart.cus_account_code', $cuscode);
	// 	$this->db->order_by('tbl_customer_cart.item_cat','asc');	
	// 			// $this->db->group_by('tbl_customer_cart.item_code');

	// 	$query = $this->db->get();
	//    	$res = $query->result_array();

	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	//    public function deleteCustomerCart($cuscode){
	//    	$this->db->delete('tbl_customer_cart', array('cus_account_code' => $cuscode));

	//    	if($this->db->affected_rows()){
	// 	  return true;
	// 	}
	// 	else{
	// 	  return false;
	// 	}
	//    }

	//    public function getMinOrderLimit(){
	// 	$this->db->select("*");
	// 	$this->db->from('tbl_order_limit');

	// 	$query = $this->db->get();
	// 	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	// }

	// public function countOrderByCust($cusCode){
	//    	$this->db->where('account_code', $cusCode);
	//    	$this->db->where("date_format(date_req,'%Y-%m-%d')", date('Y-m-d'));
	//    	$_count = $this->db->get('tb_tran_head')->num_rows();
	//    	if(isset($_count))
	//    	{
	// 		return $_count;
	//    	}else
	//    	{
	//    		return 0;
	//    	}
	//    }

	//    public function insertOrderHead($cusCode, $storeName, $payMethod, $itemCount, $totAmt, $tranStat, $smCode, $reqCount){
	//    	$data =  (object) array(
	// 	        'tran_no' 			  => date('mdy').($reqCount + 1)."-".$cusCode,
	// 	        'date_req'            => date('Y-m-d H:i:s'),
	// 	        'account_code'        => $cusCode,
	// 	        'store_name'          => $storeName,
	// 	        'p_meth'		      => $payMethod,
	// 	        'itm_count'		      => $itemCount,	
	// 	        'tot_amt'		      => $totAmt,
	// 	        'tran_stat'		      => $tranStat,
	// 	        'sm_code'		      => $smCode,
	// 	        'order_by'			  => 'Customer',
	// 	        'flag'				  => 1
	// 	);

	//    	$this->db->insert('tb_tran_head',$data);

	//    	$query = $this->db->affected_rows();
	//    	if($query == 1)
	//    	{
	//    		return $data;
	//    	}
	//    }

	//    public function insertOrderLine($tran_no, $itm_code, $item_desc, $req_qty, $uom , $amt ,$tot_amt , $itm_cat, $customer){
	// 	$data =  array(
	// 	        'tran_no' 			  => $tran_no,
	// 	        'itm_code'            => $itm_code,
	// 	        'item_desc'           => $item_desc,
	// 	        'req_qty'             => $req_qty,
	// 	        'uom'		          => $uom,
	// 	        'amt'		          => $amt,
	// 	        'tot_amt'		      => $tot_amt,
	// 	        'itm_cat'		      => $itm_cat,
	// 	        'flag'				  => 0,
	// 	        'account_code'		  => $customer,
	// 	        'date_req'			  => date('Y-m-d H:i:s')
	// 	);

	// 	$this->db->insert('tb_tran_line',$data);

	//    	$query = $this->db->affected_rows();
	//    	if($query == 1)
	//    	{
	//    		return $query;
	//    	}
	//    }

	//    public function getPendingOrders($cusCode){
	//    	$this->db->select('*');
	//    	$this->db->from('tb_tran_head');
	//    	$this->db->where('account_code',$cusCode);
	//    	$this->db->where('tran_stat','Pending');
	//    	$this->db->order_by('date_req','desc');

	//    	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	//    public function getApprovedOrders($cusCode){
	//    	$this->db->select('*');
	//    	$this->db->from('tb_tran_head');
	//    	$this->db->where('account_code',$cusCode);
	//    	$this->db->where('tran_stat','Approved');
	//    	$this->db->order_by('date_req','desc');

	//    	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	//    public function getDeliveredOrders($cusCode){
	//    	$this->db->select('*');
	//    	$this->db->from('tb_tran_head');
	//    	$this->db->where('account_code',$cusCode);
	//    	$this->db->where('tran_stat','Delivered');
	//    	$this->db->order_by('date_req','desc');

	//    	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	//    public function getReturnedOrders($cusCode){
	//    	$this->db->select('*');
	//    	$this->db->from('tb_tran_head');
	//    	$this->db->where('account_code',$cusCode);
	//    	$this->db->where('tran_stat','Returned');
	//    	$this->db->order_by('date_req','desc');

	//    	$query = $this->db->get();
	//    	$res = $query->result_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	//    public function getOrderDetails($tranNo){
	//    	$this->db->select('tb_tran_line.doc_no,tb_tran_line.tran_no,tb_tran_head.tot_amt,tb_tran_head.tot_del_amt,tb_tran_head.date_req,tb_tran_head.date_app,tb_tran_head.date_transit,tb_tran_head.date_del,tb_tran_line.itm_code,tb_tran_line.item_desc,tb_tran_line.req_qty,tb_tran_line.del_qty,tb_tran_line.uom,tb_tran_line.amt,tb_tran_line.discount,tb_tran_line.tot_amt,tb_tran_line.discounted_amount,tb_tran_line.itm_cat,tb_tran_line.itm_stat,tb_tran_line.flag,tb_tran_head.tran_stat,tbl_item_image.item_path,tbl_category_masterfile.id, (tb_tran_line.req_qty - tb_tran_line.del_qty) as unserved,tb_unserved_items.qty as retQty,tb_unserved_items.itm_stat as unsRet, tb_tran_line.lrate, tb_tran_line.rated');
	//    	$this->db->from('tb_tran_line');
	//    	$this->db->join('tb_tran_head','tb_tran_head.tran_no = tb_tran_line.tran_no');
	//    	$this->db->join('tbl_item_image', 'tbl_item_image.item_code = tb_tran_line.itm_code AND tbl_item_image.item_uom = tb_tran_line.uom');
	//    	$this->db->join('tbl_category_masterfile','tbl_category_masterfile.category_name = tb_tran_line.itm_cat');
	//    	$this->db->join('tb_unserved_items','tb_unserved_items.tran_no = tb_tran_line.tran_no AND tb_unserved_items.itm_code = tb_tran_line.itm_code AND tb_unserved_items.itm_stat = "Returned"','left');
	//    	$this->db->where('tb_tran_line.tran_no',$tranNo);
	// 	$this->db->order_by('tbl_category_masterfile.id','asc');	

	// 	$query = $this->db->get();
	//    	$res = $query->result_array();

	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	//    public function getFavorites($cuscode){
	//    	$this->db->select('tb_favorites.item_code, tb_favorites.item_uom, item_masterfiles.product_name, item_masterfiles.list_price_wtax, tbl_item_image.item_path,tbl_category_masterfile.category_name, item_masterfiles.rate,item_history_logs.price1,item_masterfiles.status');
	//    	$this->db->from('tb_favorites');
	//    	$this->db->join('item_masterfiles', 'item_masterfiles.itemcode = tb_favorites.item_code  AND item_masterfiles.uom = tb_favorites.item_uom');
	//    	$this->db->join('item_history_logs','item_history_logs.log_id = (select max(item_history_logs.log_id) from item_history_logs where item_masterfiles.itemcode = item_history_logs.itemcode AND item_masterfiles.uom = item_history_logs.uom1)',"left");
	//    	$this->db->join('tbl_item_image', 'tbl_item_image.item_code = tb_favorites.item_code AND tbl_item_image.item_uom = tb_favorites.item_uom');
	//    	$this->db->join('tbl_category_masterfile','tbl_category_masterfile.category_name = item_masterfiles.product_family');
	//    	$this->db->where('tb_favorites.account_code', $cuscode);
	// 	$this->db->order_by('tb_favorites.doc_no','asc');	

	// 	$query = $this->db->get();
	//    	$res = $query->result_array();

	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}
	//    }

	//    public function checkExistPassHistory($cusID, $pass){
	// 	$query = $this->db->query("select * from (Select * from pass_history where account_code ='".$cusID."'order by id desc limit 6) tb where password = '".md5($pass)."'");
	// 	$res = $query->result_array();
	// 	return $res;
	// }

	// public function getCustomerActive($customer_id){
	// 	$this->db->where('account_code', $customer_id);

	// 	$query = $this->db->get('customer_active');

	// 	if($query->num_rows() == 1){
	// 		return true;
	// 	} else {				
	// 		return false;
	// 	}
	// }

	// public function getCustomerActiveTimer($customer_id){
	// 	$this->db->select("*");
	// 	$this->db->from('customer_active');
	// 	$this->db->where('account_code', $customer_id);
	// 	$this->db->limit(1);

	// 	$query = $this->db->get();

	// 	$res = $query->row_array();
	//    	if(isset($res))
	//    	{
	//    		return $res;
	//    	}else
	//    	{
	//    		return $res;
	//    	}
	// }

	// public function updateActive($customer_id, $device){
	// 	$data	= array(
	// 		"device"			=> $device,
	// 		"date_active"		=> date("Y-m-d H:i:s"),
	// 	);
	// 	$this->db->where('account_code',$customer_id);
	// 	$this->db->update('customer_active',$data);
	// 	return true;
	// }

	// public function deleteActiveDevice($customer_id){
	//     $this->db->delete('customer_active', array('account_code' => $customer_id));

	//    	if($this->db->affected_rows()){
	// 	  return true;
	// 	}
	// 	else{
	// 	  return false;
	// 	}
	// }

	// public function insertActive($customerID, $device){

	// 	$data =  array(
	// 	        'account_code' 		=> $customerID,
	// 	        'device'            => $device,
	// 	        "date_active"		=> date("Y-m-d H:i:s"),
	// 	);
	// 	$this->db->insert('customer_active', $data);
	// 	return true;
	// }

	// public function checkUserBlock($cusID){
	// 	$this->db->select('*');
	// 	$this->db->from('customer_master_files');
	// 	$this->db->where('account_code', $cusID);
	// 	$this->db->where('isBlock',1);
	// 	$this->db->limit(1);

	// 	$query = $this->db->get();
	// 	$res = $query->row_array();
	// 	if(isset($res))
	// 	{
	// 	    return $res;
	// 	}
	// 	else
	// 	{
	// 		return $res;
	// 	}
	// }

	// public function getAverageRate($itemcode, $uom){
	//    		$rated = "done";
	//    		$this->db->select('AVG( tb_tran_line.lrate) as avg_r');
	//    		$this->db->from('tb_tran_line');
	//    		$this->db->where('tb_tran_line.itm_code',$itemcode);
	//    		$this->db->where('tb_tran_line.uom',$uom);
	//    		$this->db->where('tb_tran_line.rated',$rated);

	//    		$query = $this->db->get();
	//    		$res = $query->result_array();

	//    		if(isset($res))
	//    		{
	//    			return $res;
	//    		}else
	//    		{
	//    			return "no records";
	//    		}
	//    }

	//    public function updateOrderItemRate($tranNo, $itemcode, $uom, $rate){
	//    	// $status = "Rated";
	//    	$data = array(
	// 	        'lrate'      => $rate,
	// 	        'rated'      => 'Done',
	// 	);

	// 	// $this->db->set('rate_status',$status);
	// 	$this->db->where('tran_no',$tranNo);
	// 	$this->db->where('itm_code',$itemcode);
	// 	$this->db->where('uom',$uom);
	// 	$this->db->update('tb_tran_line', $data);

	// 	$query = $this->db->affected_rows();
	//    	if(isset($query))
	//    	{
	//    		// return $query;
	//    		return true;
	//    	}else
	//    	{
	//    		// return FALSE;
	//    		return false;
	//    	}
	//    }

	//    public function updateProductRateMasterfile($itemcode, $uom, $rate){
	//    	// $status = "Rated";
	//    	$data = array(
	// 	        'rate'      => $rate,
	// 	);

	// 	$this->db->where('itemcode',$itemcode);
	// 	$this->db->where('uom',$uom);
	// 	$this->db->update('item_masterfiles', $data);

	// 	$query = $this->db->affected_rows();
	//    	if(isset($query))
	//    	{
	//    		// return $query;
	//    		return "success update";
	//    	}else
	//    	{
	//    		// return FALSE;
	//    		return "failed update";
	//    	}
	//    }

	// // public function removeLocked($cid){
	// // 	$data	= array(
	// // 		"isBlock"			=> 0,
	// // 		"password_date" 	=> date("Y-m-d"),
	// // 	);
	// // 	$this->db->where('account_code',$cid);
	// // 	$this->db->update('customer_master_files',$data);
	// // 	return "done";
	// // }
	//pcount
	public function getFilteredItemMasterfile()
	{
		$this->db->select('id,byCategory,categoryName,byVendor,vendorName,type as ctype');
		$this->db->from('tbl_nav_count');
		// $this->db->where('byCategory',true);
		$query = $this->db->get();
		$res = $query->result_array();
		if (isset($res)) {
			return $res;
		}
	}

	public function getItemMasterfileCount()
	{
		$count = $this->db->from("item_masterfile_bardcode")->count_all_results();
		// $count = $this->db->from("item_masterfile_bardcode_test")->count_all_results();
		return $count;
	}

	public function getItemMasterfileOffset_mod($offset)
	{
		// $this->db->select('item_no, barcode_no, show_item, description, variant_code, uom');
		$this->db->select('item_code, barcode, desc, uom, vendor_name,category,group as ggroup,conversion_qty,variant_code');
		$this->db->from('tbl_item_masterfile');
		$this->db->offset($offset);
		$this->db->limit(50000);
		$this->db->order_by('tbl_item_masterfile.barcode', 'asc');
		$query = $this->db->get();
		$res = $query->result_array();
		if (isset($res)) {
			return $res;
		}
	}

	public function getUnit_mod($haveFilter, $filters)
	{
		$this->db->select('uom');
		$this->db->from('tbl_item_masterfile');
		$this->db->group_by('tbl_item_masterfile.uom');
		//	$this->db->order_by('tbl_item_masterfile.barcode','asc');
		if ($haveFilter == 'true') {
			$this->db->where('group', $filters);
		}
		$query = $this->db->get();
		$res = $query->result_array();
		return $res;
	}

	public function getUserMasterfile()
	{
		$this->db->select('uappid, emp_id, emp_no, emp_pin, name, position, location_id, done, locked');
		$this->db->from('tbl_app_user');
		$this->db->order_by('tbl_app_user.uappid', 'asc');
		$query = $this->db->get();
		$res = $query->result_array();
		if (isset($res)) {
			return $res;
		}
	}

	public function getAuditMasterifle()
	{
		$this->db->select('auappid, emp_id, emp_no, emp_pin, name, position, location_id');
		$this->db->from('tbl_app_audit');
		$this->db->order_by('tbl_app_audit.auappid', 'asc');
		$query = $this->db->get();
		$res = $query->result_array();
		if (isset($res)) {
			return $res;
		}
	}

	public function getLocationMasterfile()
	{
		$this->db->select('location_id, company, business_unit, department, section, rack_desc');
		$this->db->from('tbl_location');
		$this->db->order_by('tbl_location.location_id', 'asc');
		$query = $this->db->get();
		$res = $query->result_array();
		if (isset($res)) {
			return $res;
		}
	}

	public function checkIfFloorPlanIsCreated()
	{
		$count = $this->db->from("tbl_location_floor_plan")->count_all_results();
		return $count;
	}

	public function insertCountData($itemcode, $barcode, $description, $uom, $qty, $business_unit, $department, $section, $rack_desc, $empno, $datetime_scanned, $datetime_saved)
	{
		$data =  (object) array(
			'itemcode' 		    => $itemcode,
			'barcode'           => $barcode,
			'description'       => $description,
			'uom'               => $uom,
			'qty'		        => $qty,
			'business_unit'	    => $business_unit,
			'department'        => $department,
			'section'           => $section,
			'rack_desc'         => $rack_desc,
			'empno'             => $empno,
			'datetime_scanned'  => $datetime_scanned,
			'datetime_saved'    => $datetime_saved,
			'datetime_exported' => date("Y-m-d h:i:s")
		);

		$this->db->insert('tbl_app_countdata', $data);

		$query = $this->db->affected_rows();
		if ($query == 1) {
			return $data;
		} else {
			return "failed insert";
		}
	}

	public function insertFloorPlanData($location_id, $company, $business_unit, $department, $section, $rack_desc, $xP, $yP, $he, $we, $isLandscape)
	{
		$data =  (object) array(
			'location_id' 		 => $location_id,
			'company'        	 => $company,
			'business_unit'      => $business_unit,
			'department'         => $department,
			'section'		     => $section,
			'rack_desc'	 		 => $rack_desc,
			'xP'    		     => $xP,
			'yP'        		 => $yP,
			'he'      			 => $he,
			'we'          		 => $we,
			'isLandscape'        => $isLandscape
		);

		$this->db->truncate('tbl_location_floor_plan');
		$this->db->insert('tbl_location_floor_plan', $data);

		$query = $this->db->affected_rows();
		if ($query == 1) {
			return $data;
		} else {
			return "failed insert";
		}
	}

	public function updateFloorPlanStatus($department, $section, $rack_desc)
	{
		$data	= array(
			"isDone" => 1,
		);
		$this->db->where('department', $department);
		$this->db->where('section', $section);
		$this->db->where('rack_desc', $rack_desc);
		$res = $this->db->update('tbl_location_floor_plan', $data);
		if ($res) {
			return "done";
		}
	}

	public function getFloorPlanData()
	{
		$this->db->select('*');
		$this->db->from('tbl_location_floor_plan');
		$this->db->order_by('tbl_location_floor_plan.location_id', 'asc');
		$query = $this->db->get();
		$res = $query->result_array();
		if (isset($res)) {
			return $res;
		}
	}

	public function updateUserStatus_mod($locationId)
	{
		$this->db->set('done', 'true');
		$this->db->set('locked', 'true');
		$this->db->where('location_id', $locationId);
		$this->db->update('tbl_app_user');
	}

	public function updateAuditStatus_mod($locationId)
	{

		$this->db->set('done', 'true');
		$this->db->where('location_id', $locationId);
		$this->db->update('tbl_app_audit');
	}

	public function updateLocationStatus_mod($locationId)
	{

		$this->db->set('done', 'true');
		$this->db->where('location_id', $locationId);
		$this->db->update('tbl_location');
	}
	//kulang
	public function updateSignature($locationid, $usersig, $auditsig)
	{
		$this->db->set('user_signature', $usersig);
		$this->db->set('audit_sognature', $auditsig);
		$this->db->where('location_id', $locationid);
		$this->db->update('tbl_app_countdata');
	}
}
