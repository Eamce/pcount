<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');
class Appc extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Appm');
		$this->load->library('form_validation');
		$this->load->library('upload');
	}

	// 	function encrypt($string){
	// 		return openssl_encrypt($string, ENCRYPT_METHOD, SECRET_KEY, 0, SECRET_IV);
	// 	}

	// 	function decrypt($string){
	// 		return openssl_decrypt($string, ENCRYPT_METHOD, SECRET_KEY, 0, SECRET_IV);
	// 	}

	// 	public function checkConnection(){
	// 		$result = $this->Appm->checkConnection();
	// 		echo json_encode($result);
	// 	}

	// 	public function getBannerImage(){
	// 		$result = $this->Appm->getBannerImage();
	// 		echo json_encode($result);
	// 	}

	// 	public function getSpecialDeals(){
	// 		$result = $this->Appm->getSpecialDeals();
	// 		echo json_encode($result);
	// 	}

	// 	public function getSpecialDealsAll(){
	// 		$result = $this->Appm->getSpecialDealsAll();
	// 		echo json_encode($result);
	// 	}

	// 	public function getTopProducts(){
	// 		$result = $this->Appm->getTopProducts();
	// 		echo json_encode($result);
	// 	}

	// 	public function getTopProductsAll(){
	// 		$result = $this->Appm->getTopProductsAll();
	// 		echo json_encode($result);
	// 	}

	// 	public function getProductCategories()
	// 	{
	// 		$result = $this->Appm->getProductCategories();
	// 		echo json_encode($result);
	// 	}

	// 	public function getProductUOM()
	// 	{
	// 		$id = $this->decrypt($this->security->xss_clean($this->input->post('itemcode')));
	// 		$customer = $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		// $id = '129737';
	// 		// $customer = 'ALI-00057';
	// 		$result = $this->Appm->getProductUOM($id, $customer);
	// 		echo json_encode($result);
	// 	}

	// 	public function addToFavorites()
	// 	{
	// 		$id = $this->decrypt($this->security->xss_clean($this->input->post('item_code')));
	// 		$uom = $this->decrypt($this->security->xss_clean($this->input->post('item_uom')));
	// 		$customer = $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		$result = $this->Appm->addToFavorites($id, $uom, $customer);
	// 		echo json_encode($result);
	// 	}

	// 	public function removeToFavorites()
	// 	{
	// 		$id = $this->decrypt($this->security->xss_clean($this->input->post('item_code')));
	// 		$uom = $this->decrypt($this->security->xss_clean($this->input->post('item_uom')));
	// 		$customer = $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		$result = $this->Appm->removeToFavorites($id, $uom, $customer);
	// 		echo json_encode($result);
	// 	}

	// 	public function getProductList()
	// 	{
	// 		$category = $this->security->xss_clean($this->input->post('product_family'));
	// 		// $category = "ALL PRODUCTS";
	// 		if($category == "ALL PRODUCTS"){
	// 			$result = $this->Appm->getProductListAll();
	// 		}else{
	// 			$result = $this->Appm->getProductList($category);
	// 		}
	// 		echo json_encode($result);
	// 	}

	// 	public function searchCustomer(){
	// 		$mobile = $this->decrypt($this->security->xss_clean($this->input->post('cus_mobile_number')));
	// 		$seachCustomer = $this->Appm->searchCustomer($mobile);
	// 		echo json_encode($seachCustomer);
	// 	}

	// 	public function logInCustomer(){
	// 		$num = $this->decrypt($this->security->xss_clean($this->input->post('cus_mobile_number')));
	// 		$pass = $this->decrypt($this->security->xss_clean($this->input->post('cus_password')));

	// 		$checkCustomer = $this->Appm->checkUser($num, $pass);

	// 		if($checkCustomer != "failedp" || $checkCustomer != "failed"){
	// 			echo json_encode($checkCustomer);	
	// 		}else{
	// 			$data	=	array(
	// 					"error"	  => "errror",
	// 					"msg"	  => "Account not found.",
	// 					"msg2"    => $checkCustomer,
	// 				);
	// 			echo json_encode($data);
	// 		}
	// 	}

	// 	public function checkCustomerBlock(){
	// 		$mobile = $this->security->xss_clean($this->input->post('cus_mobile_number'));
	// 		$checkCustomerBlock = $this->Appm->checkCusBlock($mobile);
	// 		echo json_encode($checkCustomerBlock);
	// 	}

	// 	public function setCustomerBlock(){
	// 		$mobile = $this->security->xss_clean($this->input->post('cus_mobile_number'));
	// 		$setCustomerBlock = $this->Appm->setCustomerBlock($mobile);
	// 		echo json_encode($setCustomerBlock);
	// 	}

	// 	public function saveSMSCode(){
	// 		$mobile = $this->decrypt($this->security->xss_clean($this->input->post('cus_mobile_number')));
	// 		$smsCode= $this->decrypt($this->security->xss_clean($this->input->post('smsCode')));
	// 		$number = $this->decrypt($this->security->xss_clean($this->input->post('number')));

	// 		if($saveSMS = $this->Appm->saveSMSCode($mobile, $smsCode)){
	// 			$this->sendSMS($number, $smsCode);
	// 			echo json_encode($saveSMS);
	// 		}else{
	// 			echo json_encode($saveSMS);
	// 		}	
	// 	}

	// 	public function sendSMS($number, $code){
	// 		$number = $number;
	// 		$msg = "DISTRIBUTION: Your verification code is ".$code.". DO NOT SHARE THIS WITH ANYONE.";
	// 		$apicode = "PR-ALTUR166130_RHH2A";
	// 		$pswd = "9)h!tc%#y$";

	// 		$sendSMS = $this->itexmo($number, $msg, $apicode, $pswd);
	// 		return $sendSMS;
	// 	}

	// 	public function itexmo($number, $message, $apicode, $passwd){
	// 	        $ch = curl_init();
	// 	        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
	// 	        curl_setopt($ch, CURLOPT_URL, "https://www.itexmo.com/php_api/api.php");
	// 	        curl_setopt($ch, CURLOPT_POST, 1);
	// 	        curl_setopt(
	// 	            $ch,
	// 	            CURLOPT_POSTFIELDS,
	// 	            http_build_query($itexmo)
	// 	        );
	// 	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	        return curl_exec($ch);
	// 	        curl_close($ch);
	//     }

	//     public function checkSMSCode(){
	// 		$mobile = $this->decrypt($this->security->xss_clean($this->input->post('cus_mobile_number')));
	// 		$smsCode= $this->decrypt($this->security->xss_clean($this->input->post('smsCode')));
	// 		$checkSMS = $this->Appm->checkSMSCode($mobile, $smsCode);
	// 		echo json_encode($checkSMS);
	// 	}

	// 	public function changePass(){
	// 		$this->form_validation->set_rules('account_code','account_code','trim');
	// 		$this->form_validation->set_rules('password','password','trim');

	// 		if ($this->form_validation->run() == FALSE){
	// 			$data	=	array(
	// 				"error"	=> "errror",
	// 				"msg"	=> "Pleas check the fields required."
	// 			);
	// 		} else{
	// 			$account_code = $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 			$newPass = $this->decrypt($this->security->xss_clean($this->input->post('password')));

	// 			$this->Appm->removeLocked($account_code);
	// 			$result = $this->Appm->changePass($account_code, $newPass);
	// 			echo json_encode($result);
	// 			$this->Appm->insertChangePassHistory($account_code, $newPass);
	// 		}
	// 	}

	// 	public function getMunicipality(){
	// 		$town		= $this->Appm->getMunicipality();
	// 		if(count($town) > 0){
	// 			foreach($town as $p):
	// 				$id		= $p['mun_code'];
	// 				$arr['data'][] = array(
	// 				'm_name'		=> $p['mun_name'],
	// 				'm_code'		=> $id
	// 			);
	// 			endforeach;
	// 		}else{
	// 			$arr['data'][] = array(
	// 				'm_name'		=> 'No record',
	// 				'm_code'		=> ''
	// 			);
	// 		}
	// 		echo json_encode($arr);
	// 	}

	// 	public function getBarangay(){
	// 		$mcode		= $this->decrypt($this->input->post('mun_code'));
	// 		$brgy		= $this->Appm->getBarangay($mcode);
	// 		if(count($brgy) > 0){
	// 			foreach($brgy as $p):
	// 				$bcode	= $p['bar_code'];
	// 				$arr['data'][] = array(
	// 				'b_name'		=> $p['bar_name'],
	// 				'b_code'		=> $bcode
	// 			);
	// 			endforeach;
	// 		}else{
	// 			$arr['data'][] = array(
	// 				'b_name'		=> 'No record',
	// 				'b_code'		=> ''
	// 			);
	// 		}
	// 		echo json_encode($arr);
	// 	}

	// 	public function checkMobileExist()
	// 	{
	// 		$mobileNumber = $this->decrypt($this->security->xss_clean($this->input->post('mobile_number')));
	// 		// $mobileNumber = "9460817455";
	// 		$resultRequest = $this->Appm->checkMobileExistRequest($mobileNumber);
	// 		if($resultRequest != null){
	// 			echo json_encode($resultRequest);
	// 		}else{
	// 			$resultRegistered = $this->Appm->checkMobileExistRegistered($mobileNumber);
	// 			if($resultRegistered != null){
	// 				echo json_encode($resultRegistered);
	// 			}else{
	// 				echo json_encode($resultRegistered);
	// 			}
	// 		}
	// 	}

	// 	public function registerCustomer(){
	// 		$ownerName = $this->decrypt($this->security->xss_clean($this->input->post('owner_name')));
	// 		$mobileNumber =  $this->decrypt($this->security->xss_clean($this->input->post('mobile_number')));
	// 		$telephoneNumber =$this->decrypt( $this->security->xss_clean($this->input->post('telephone_number')));
	// 		$streeAdd =  $this->decrypt($this->security->xss_clean($this->input->post('street_add')));
	// 		$landmark =  $this->decrypt($this->security->xss_clean($this->input->post('landmark')));
	// 		$munCode =  $this->decrypt($this->security->xss_clean($this->input->post('mun_code')));
	// 		$barCode =  $this->decrypt($this->security->xss_clean($this->input->post('bar_code')));
	// 		$storeName = $this->decrypt( $this->security->xss_clean($this->input->post('store_name')));
	// 		$dtiNo =  $this->decrypt($this->security->xss_clean($this->input->post('dti_no')));
	// 		$bcPhoto =  $this->decrypt($this->security->xss_clean($this->input->post('bc_photo')));
	// 		$storePhoto =  $this->decrypt($this->security->xss_clean($this->input->post('store_photo')));
	// 		$tempPassword =  $this->decrypt($this->security->xss_clean($this->input->post('temp_password')));

	// 		$result = $this->Appm->registerCustomer($ownerName, $mobileNumber, $telephoneNumber, $streeAdd, $landmark, $munCode, $barCode, $storeName, $dtiNo, $bcPhoto, $storePhoto,$tempPassword);
	// 		echo json_encode($result);
	// 	}

	// 	public function uploadStoreImg(){

	// 		$image = $_FILES['image']['name'];
	// 		$name = $this->security->xss_clean($this->input->post('name'));

	// 		$imagePath = './img/store_img/'.$image;
	// 		$tmp_name = $_FILES['image']['tmp_name'];

	// 		move_uploaded_file($tmp_name, $imagePath);
	// 	}

	// 	public function uploadBCImg(){

	// 		$image = $_FILES['image']['name'];
	// 		$name = $this->security->xss_clean($this->input->post('name'));

	// 		$imagePath = './img/bc_img/'.$image;
	// 		$tmp_name = $_FILES['image']['tmp_name'];

	// 		move_uploaded_file($tmp_name, $imagePath);
	// 	}

	// 	public function insertToCustomerCart(){
	// 		$accountCode = $this->decrypt($this->security->xss_clean($this->input->post('cus_account_code')));
	// 		$itemcode = $this->decrypt($this->security->xss_clean($this->input->post('item_code')));
	// 		$uom = $this->decrypt($this->security->xss_clean($this->input->post('item_uom')));
	// 		$qty = $this->decrypt($this->security->xss_clean($this->input->post('item_qty')));
	// 		$category = $this->decrypt($this->security->xss_clean($this->input->post('item_cat')));

	// 		$checkData = $this->Appm->getExistProductInCart($accountCode,$itemcode,$uom);

	// 		if(!empty($checkData)){
	// 				//update
	// 			$result = $this->Appm->updateProductCart($checkData[0]['cus_account_code'], $checkData[0]['item_code'], $checkData[0]['item_uom'], $checkData[0]['item_qty'] + $qty);
	// 		}else{
	// 				//insert
	// 			$result = $this->Appm->insertProductCart($accountCode, $itemcode, $uom, $qty, $category);
	// 		}

	// 		echo json_encode($result);
	// 	}

	// 	public function getCustomerCart(){
	// 		$customer = $this->decrypt($this->security->xss_clean($this->input->post('cus_account_code')));
	// 		$result = $this->Appm->getCustomerCart($customer);
	// 		echo json_encode($result);
	// 	}

	// 	public function deleteCustomerCart(){
	// 		$accountCode = $this->decrypt($this->security->xss_clean($this->input->post('cus_account_code')));
	// 		$deleteCart = $this->Appm->deleteCustomerCart($accountCode);
	// 		echo json_encode($deleteCart);
	// 	}

	// 	public function getMinOrderLimit(){
	// 		$result = $this->Appm->getMinOrderLimit();
	// 		echo json_encode($result);
	// 	}

	// 	public function insertTranHead(){
	// 		$cusCode   =  $this->decrypt($this->security->xss_clean($this->input->post('customer_id')));
	// 		$storeName =  $this->decrypt($this->security->xss_clean($this->input->post('store_name')));
	// 		$payMethod =  $this->decrypt($this->security->xss_clean($this->input->post('p_meth')));
	// 		$itemCount =  $this->decrypt($this->security->xss_clean($this->input->post('itm_count')));
	// 		$totAmt    =  $this->decrypt($this->security->xss_clean($this->input->post('tot_amt')));
	// 		$tranStat  =  $this->decrypt($this->security->xss_clean($this->input->post('tran_stat')));
	// 		$smCode    =  $this->decrypt($this->security->xss_clean($this->input->post('sm_code')));

	// 		$t = $this->Appm->countOrderByCust($cusCode);

	// 		$result = $this->Appm->insertOrderHead($cusCode, $storeName, $payMethod, $itemCount,$totAmt,$tranStat ,$smCode, $t);
	// 		echo json_encode([$result]);
	// 	}

	// 	public function insertTranLine(){
	// 		$tran_no 	 =  $this->decrypt($this->security->xss_clean($this->input->post('tran_no'))); 
	// 		$itm_code     =  $this->decrypt($this->security->xss_clean($this->input->post('itm_code')));
	// 		$item_desc	 =  $this->decrypt($this->security->xss_clean($this->input->post('item_desc')));
	// 		$req_qty	 =  $this->decrypt($this->security->xss_clean($this->input->post('req_qty')));
	// 		$uom  =  $this->decrypt($this->security->xss_clean($this->input->post('uom')));
	// 		$amt  =  $this->decrypt($this->security->xss_clean($this->input->post('amt')));
	// 		$tot_amt  =  $this->decrypt($this->security->xss_clean($this->input->post('tot_amt')));
	// 		$itm_cat  =  $this->decrypt($this->security->xss_clean($this->input->post('itm_cat')));
	// 		$account_code = $this->decrypt($this->security->xss_clean($this->input->post('account_code')));

	// 		$result = $this->Appm->insertOrderLine($tran_no, $itm_code, $item_desc, $req_qty,$uom,$amt ,$tot_amt, $itm_cat, $account_code);
	// 		echo json_encode($result);
	// 	}

	// 	public function getPendingOrders(){
	// 		$cusCode =  $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		$result = $this->Appm->getPendingOrders($cusCode);
	// 		echo json_encode($result);
	// 	}

	// 	public function getApprovedOrders(){
	// 		$cusCode =  $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		$result = $this->Appm->getApprovedOrders($cusCode);
	// 		echo json_encode($result);
	// 	}

	// 	public function getDeliveredOrders(){
	// 		$cusCode =  $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		$result = $this->Appm->getDeliveredOrders($cusCode);
	// 		echo json_encode($result);
	// 	}

	// 	public function getReturnedOrders(){
	// 		$cusCode =  $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		$result = $this->Appm->getReturnedOrders($cusCode);
	// 		echo json_encode($result);
	// 	}

	// 	public function getOrderDetails(){
	// 		$tranNo =  $this->decrypt($this->security->xss_clean($this->input->post('tran_no')));
	// 		$result = $this->Appm->getOrderDetails($tranNo);
	// 		echo json_encode($result);
	// 	}

	// 	public function getFavorites(){
	// 		$customer = $this->decrypt($this->security->xss_clean($this->input->post('cus_account_code')));
	// 		$result = $this->Appm->getFavorites($customer);
	// 		echo json_encode($result);
	// 	}

	// 	public function checkExistPassHistory(){
	// 		$cusID = $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		$pass = $this->decrypt($this->security->xss_clean($this->input->post('password')));
	// 		// $cusID = "ALI-00057";
	// 		// $pass = '123456789Ee#';
	// 		$checkHistory = $this->Appm->checkExistPassHistory($cusID, $pass);
	// 		echo json_encode($checkHistory);
	// 	}

	// 	public function checkActiveDevice(){
	// 		$customer_id = $this->security->xss_clean($this->input->post('account_code'));
	// 		$checkCustomerActiveTimer = $this->Appm->getCustomerActiveTimer($customer_id);
	// 		echo json_encode($checkCustomerActiveTimer);
	// 	}

	// 	public function updateCustomerOnline(){
	// 		$customer_id = $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 		$device= $this->decrypt($this->security->xss_clean($this->input->post('device')));

	// 		if($exist = $this->Appm->getCustomerActive($customer_id, $device)){
	// 			//update
	// 			$res = $this->Appm->updateActive($customer_id, $device);
	// 			echo json_encode($res);
	// 		}else{
	// 			//insert
	// 			$res = $this->Appm->insertActive($customer_id, $device);
	// 			echo json_encode($res);
	// 		}
	// 	}

	// 	public function checkUserBlock(){
	// 		$customer_id = $this->security->xss_clean($this->input->post('account_code'));
	// 		// $uname = "jbongolan_d71";
	// 		$checkCustomerBlock = $this->Appm->checkUserBlock($customer_id);
	// 		echo json_encode($checkCustomerBlock);
	// 	}

	// 	public function updateProductRate(){
	// 	    $tranNo = $this->decrypt($this->security->xss_clean($this->input->post('tran_no')));
	// 	    $rate = $this->decrypt($this->security->xss_clean($this->input->post('rate')));
	// 		$itemcode = $this->decrypt($this->security->xss_clean($this->input->post('itm_code')));
	// 		$uom = $this->decrypt($this->security->xss_clean($this->input->post('uom')));

	// // 		 $tranNo = '1112201-ALI-00035';
	// // 		  $rate = '5';
	// // 		$itemcode = "100648";
	// // 		$uom = "BOX";

	// 		if($this->Appm->updateOrderItemRate($tranNo, $itemcode, $uom, $rate)){
	// 		    $getAvg = $this->Appm->getAverageRate($itemcode, $uom);
	// 		    if(!empty($getAvg)){
	// 			    $result = $this->Appm->updateProductRateMasterfile($itemcode, $uom, $getAvg[0]['avg_r']);
	// 			    echo json_encode($result);
	// 		    }
	// 		}
	// 	}

	// 	// public function changePass(){
	// 	// 	$this->form_validation->set_rules('account_code','account_code','trim');
	// 	// 	$this->form_validation->set_rules('cus_password','cus_password','trim');

	// 	// 	if ($this->form_validation->run() == FALSE){
	// 	// 		$data	=	array(
	// 	// 			"error"	=> "errror",
	// 	// 			"msg"	=> "Pleas check the fields required."
	// 	// 		);
	// 	// 	} else{
	// 	// 		$cusID = $this->decrypt($this->security->xss_clean($this->input->post('account_code')));
	// 	// 		$newPass = $this->decrypt($this->security->xss_clean($this->input->post('cus_password')));

	// 	// 		$this->Appm->removeLocked($cusID);
	// 	// 		$result = $this->Appm->changePass($cusID, $newPass);
	// 	// 		echo json_encode($result);
	// 	// 		$this->Appm->insertChangePassHistory($cusID, $newPass);
	// 	// 	}
	// 	// }


	//pcount
	public function getFilteredItemMasterfile()
	{
		$res = $this->Appm->getFilteredItemMasterfile();
		if ($res[0]['byCategory'] == 'False' && $res[0]['byVendor'] == 'False') {
			echo json_encode($res);
		} elseif ($res[0]['byCategory'] == 'True' && $res[0]['byVendor'] == 'True') {
			echo json_encode($res);
		} elseif ($res[0]['byCategory'] == 'True' && $res[0]['byVendor'] == 'False') {
			echo json_encode($res);
		} elseif ($res[0]['byCategory'] == 'False' && $res[0]['byVendor'] == 'True') {
			echo json_encode($res);
		}
	}

	public function getUnit()
	{
		$haveFilter = $this->security->xss_clean($this->input->post('haveFilter'));
		$filters = $this->security->xss_clean($this->input->post('filters'));
		// $haveFilter = 'True';
		//$filters ="'HAIR CARE'";
		$unit = $this->Appm->getUnit_mod($haveFilter, $filters);
		echo json_encode($unit);
	}

	public function insertNFItemList()
	{
		$nfitems	 		=  $this->security->xss_clean($this->input->post('nfitems'));
		$auditSignature	 	=  $this->security->xss_clean($this->input->post('audit_signature'));
		$userSignature	 	=  $this->security->xss_clean($this->input->post('user_signature'));

		$nfjson = str_replace('&quot;', '"', $nfitems);
		$decodedNfItems = json_decode($nfjson, true);

		$nffinal_ress = array();
		foreach ($decodedNfItems as $nfress) :
			$nffinal_ress = array(
				"barcode" 			=> $nfress['barcode'],
				"uom" 				=> $nfress['uom'],
				"qty" 				=> $nfress['qty'],
				"location_id" 		=> $nfress['location'],
				"datetime_scanned" 	=> $nfress['datetimecreated'],
				//Added 
				"business_unit" 	=> $nfress['business_unit'],
				"department" 		=> $nfress['department'],
				"section" 			=> $nfress['section'],
				"empno" 			=> $nfress['empno'],
				"rack_desc" 		=> $nfress['rack_desc'],
				"audit_signature" 	=> $auditSignature,
				"user_signature" 	=> $userSignature,
				"datetime_exported"	=> date("Y-m-d H:i:s"),
			);
			$nfres = $this->db->insert('tbl_app_nfitem', $nffinal_ress);
		endforeach;
		echo json_encode($nfres);
	}

	public function getItemMasterfileCount()
	{
		$itemCount = $this->Appm->getItemMasterfileCount();
		echo json_encode($itemCount);
	}

	public function getItemMasterfileOffset()
	{
		$offset = $this->security->xss_clean($this->input->post('offset'));
		// $offset = 2;
		$result = $this->Appm->getItemMasterfileOffset_mod($offset);
		echo json_encode($result);
	}

	public function getUserMasterfile()
	{
		$result = $this->Appm->getUserMasterfile();
		echo json_encode($result);
	}

	public function getAuditMasterifle()
	{
		$result = $this->Appm->getAuditMasterifle();
		echo json_encode($result);
	}

	public function getLocationMasterfile()
	{
		$result = $this->Appm->getLocationMasterfile();
		echo json_encode($result);
	}

	public function insertCountData()
	{
		$this->form_validation->set_rules('itemcode', 'itemcode', 'trim');
		$this->form_validation->set_rules('barcode', 'barcode', 'trim');
		$this->form_validation->set_rules('description', 'description', 'trim');
		$this->form_validation->set_rules('uom', 'uom', 'trim');
		$this->form_validation->set_rules('qty', 'qty', 'trim');
		$this->form_validation->set_rules('business_unit', 'business_unit', 'trim');
		$this->form_validation->set_rules('department', 'department', 'trim');
		$this->form_validation->set_rules('section', 'section', 'trim');
		$this->form_validation->set_rules('rack_desc', 'rack_desc', 'trim');
		$this->form_validation->set_rules('empno', 'empno', 'trim');
		$this->form_validation->set_rules('datetime_scanned', 'datetime_scanned', 'trim');
		$this->form_validation->set_rules('datetime_saved', 'datetime_saved', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$data	=	array(
				"error"	=> "errror",
				"msg"	=> "Pleas check the fields required."
			);
		} else {
			$itemcode 		  = $this->security->xss_clean($this->input->post('itemcode'));
			$barcode 		  = $this->security->xss_clean($this->input->post('barcode'));
			$description	  = $this->security->xss_clean($this->input->post('description'));
			$uom 		 	  = $this->security->xss_clean($this->input->post('uom'));
			$qty			  = $this->security->xss_clean($this->input->post('qty'));
			$business_unit	  = $this->security->xss_clean($this->input->post('business_unit'));
			$department		  = $this->security->xss_clean($this->input->post('department'));
			$section		  = $this->security->xss_clean($this->input->post('section'));
			$rack_desc		  = $this->security->xss_clean($this->input->post('rack_desc'));
			$empno			  = $this->security->xss_clean($this->input->post('empno'));
			$datetime_scanned = $this->security->xss_clean($this->input->post('datetime_scanned'));
			$datetime_saved   = $this->security->xss_clean($this->input->post('datetime_saved'));

			$result = $this->Appm->insertCountData($itemcode, $barcode, $description, $uom, $qty, $business_unit, $department, $section, $rack_desc, $empno, $datetime_scanned, $datetime_saved);

			echo json_encode($result);
		}
	}

	public function insertCountDataList_ctrl()
	{
		$items       	 =  $this->security->xss_clean($this->input->post('items'));
		$empno       	 =  $this->security->xss_clean($this->input->post('empno'));
		$user_signature  =  $this->security->xss_clean($this->input->post('user_signature'));
		$audit_signature =  $this->security->xss_clean($this->input->post('audit_signature'));
		$locationId  	 =  $this->security->xss_clean($this->input->post('locationid'));

		$json = str_replace('&quot;', '"', $items);
		$decodedItems = json_decode($json, true);

		$final_ress = array();
		foreach ($decodedItems as $ress) :
			$final_ress = array(
				"itemcode" 			=> $ress['itemcode'],
				"barcode" 			=> $ress['barcode'],
				"description" 		=> $ress['description'],
				"uom" 				=> $ress['uom'],
				"qty" 				=> $ress['qty'],
				"conversion_qty" 	=> $ress['conqty'],
				"location_id" 		=> $ress['location_id'],
				"business_unit" 	=> $ress['business_unit'],
				"department" 		=> $ress['department'],
				"section" 			=> $ress['section'],
				"rack_desc" 		=> $ress['rack_desc'],
				"empno" 			=> $empno,
				"datetime_scanned" 	=> $ress['datetimecreated'],
				"datetime_saved" 	=> $ress['datetimesaved'],
				"datetime_exported"	=> date("Y-m-d H:i:s"),
				"date_expiry" 		=> $ress['expiry'],
				"user_signature"	=> $user_signature,
				"audit_signature"	=> $audit_signature,
			);
			$res = $this->db->insert('tbl_app_countdata', $final_ress);

			$this->Appm->updateUserStatus_mod($locationId);
			$this->Appm->updateAuditStatus_mod($locationId);
			$this->Appm->updateLocationStatus_mod($locationId);
		endforeach;

		echo json_encode($res);
	}

	public function checkIfFloorPlanIsCreated()
	{
		$floor = $this->Appm->checkIfFloorPlanIsCreated();
		echo json_encode($floor);
	}

	public function test()
	{
		echo 'test';
	}

	public function insertFloorPlanData()
	{
		$this->form_validation->set_rules('location_id', 'location_id', 'trim');
		$this->form_validation->set_rules('company', 'company', 'trim');
		$this->form_validation->set_rules('business_unit', 'business_unit', 'trim');
		$this->form_validation->set_rules('department', 'department', 'trim');
		$this->form_validation->set_rules('section', 'section', 'trim');
		$this->form_validation->set_rules('rack_desc', 'rack_desc', 'trim');
		$this->form_validation->set_rules('xP', 'xP', 'trim');
		$this->form_validation->set_rules('yP', 'yP', 'trim');
		$this->form_validation->set_rules('he', 'he', 'trim');
		$this->form_validation->set_rules('we', 'we', 'trim');
		$this->form_validation->set_rules('isLandscape', 'isLandscape', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$data	=	array(
				"error"	=> "errror",
				"msg"	=> "Pleas check the fields required."
			);
		} else {
			$location_id 	= $this->security->xss_clean($this->input->post('location_id'));
			$company 		= $this->security->xss_clean($this->input->post('company'));
			$business_unit 	= $this->security->xss_clean($this->input->post('business_unit'));
			$department 	= $this->security->xss_clean($this->input->post('department'));
			$section 		= $this->security->xss_clean($this->input->post('section'));
			$rack_desc 		= $this->security->xss_clean($this->input->post('rack_desc'));
			$xP 			= $this->security->xss_clean($this->input->post('xP'));
			$yP 			= $this->security->xss_clean($this->input->post('yP'));
			$he 			= $this->security->xss_clean($this->input->post('he'));
			$we				= $this->security->xss_clean($this->input->post('we'));
			$isLandscape 	= $this->security->xss_clean($this->input->post('isLandscape'));

			$result = $this->Appm->insertFloorPlanData($location_id, $company, $business_unit, $department, $section, $rack_desc, $xP, $yP, $he, $we, $isLandscape);

			echo json_encode($result);
		}
	}

	//kulang ug update signature model
	public function updateSignature()
	{
		$locationid = $this->security->xss_clean($this->input->post('location_id'));
		$usersig 	= $this->security->xss_clean($this->input->post('user_sig'));
		$auditsig 	= $this->security->xss_clean($this->input->post('audit_sig'));

		$result = $this->Appm->updateSignature($locationid, $usersig, $auditsig);
		echo json_encode($result);
	}

	public function updateFloorPlanStatus()
	{
		$department = $this->security->xss_clean($this->input->post('department'));
		$section 	= $this->security->xss_clean($this->input->post('section'));
		$rack_desc 	= $this->security->xss_clean($this->input->post('rack_desc'));
		$result 	= $this->Appm->updateFloorPlanStatus($department, $section, $rack_desc);
		echo json_encode($result);
	}

	public function getFloorPlanData()
	{
		$result = $this->Appm->getFloorPlanData();
		echo json_encode($result);
	}

	public function getAuditTrail()
	{
	}
}
