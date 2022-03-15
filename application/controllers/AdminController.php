<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('PHPExcel');
		$this->load->model('AdminModel');
		$this->load->model('setup_model', 'setup');
		$this->load->helper('download');
	}
	public function add_user_data()
	{
		$name = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('uname')))));
		$username = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('username')))));
		$password = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('password')))));
		$usertype = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('usertype')))));
		$company = $this->security->xss_clean(trim(addslashes(@$this->input->post('company'))));
		$bunit = $this->security->xss_clean(trim(addslashes(@$this->input->post('bunit'))));
		$cid  = explode("/", @$_POST['company']);
		$bid  = explode("/", @$_POST['bunit']);
		if ($name == '' || $username == '' || $password == '' || $usertype == '') {
			echo json_encode('error1');
		} else {
			$insz = array('name' => $name);
			$num = $this->AdminModel->getNumData('tbl_users', $insz);
			if ($num > 0) {
				echo json_encode('Employee already have an account.');
			} else {
				$inx = array('username' => $username, 'password' => md5($password));
				$num2 = $this->AdminModel->getNumData('tbl_users', $inx);
				if ($num2 > 0) {
					echo json_encode("error2");
				} else {
					$config['upload_path'] =	 FCPATH . "assets/images/profile/";
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = '5048000';
					$config['max_width'] = '5000';
					$config['max_height'] = '5000';
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('profile')) {
						$error = $this->upload->display_errors();
						echo json_encode($error);
					} else {
						$data = array('upload_data' => $this->upload->data());
						$image = $_FILES['profile']['name'];
						$ins = array(
							'name' => ucwords($name),
							'username' => $username,
							'password' => md5($password),
							'usertype' => $usertype,
							'profile_pic' => 'assets/images/profile/' . $image,
							'status' => 1,
							'company' => @$cid[0],
							'bunit'	=> @$bid[0]
						);
						$res = $this->AdminModel->insert_data('tbl_users', $ins);
						if ($res == 'success') {
							echo json_encode($res);
						} else {
							echo json_encode("Oops, something went wrong...");
						}
					}
				}
			}
		}
	}

	public function get_all_user_data()
	{
		$result = array('data' => []);
		$data = $this->AdminModel->getAllData('tbl_users');
		foreach ($data as $key => $value) {
			if ($value['status'] == 1) {
				$color_btn = 'btn-success';
				$stat = 'Active';
			}
			if ($value['status'] == 0) {
				$color_btn = 'btn-danger';
				$stat = 'Inactive';
			}
			if ($value['user_status'] == 1) {
				$color_btn1 = 'btn-primary';
				$stat1 = 'online';
			}
			if ($value['user_status'] == 0) {
				$color_btn1 = 'btn-danger';
				$stat1 = 'offline';
			}

			$btn = '<div class="btn-group">
			<button data-toggle="dropdown" class="btn ' . $color_btn . ' btn-xs dropdown-toggle">' . $stat . '</button>
			<ul class="dropdown-menu">
			<li><a class="dropdown-item"  onclick="activation_act(\'' . "1" . '\', \'' . $value['user_id'] . '\')" style="color:blue;">Activate</a></li>
			<li><a class="dropdown-item"  onclick="activation_act(\'' . "0" . '\', \'' . $value['user_id'] . '\')" style="color:red;">Inactivate</a></li>
			</ul>
			</div>';

			$status = '<button class="btn ' . $color_btn1 . ' btn-xs">' . $stat1 . '</button>';
			$location	=  $this->setup->getLoc('locate_company', @$value['company']);
			$location1	=  $this->setup->getLoc('locate_business_unit', @$value['company'], @$value['bunit']);
			$company	= @$location->acroname . " - " . @$location1->business_unit;
			$user = '<img alt="image" class="rounded-circle" src="' . $value['profile_pic'] . '" style="width:28px; height:28px; margin-right:10px;">' . ' ' . $value['name'];

			$result['data'][] = [$user, $value['username'], @$company, $value['usertype'], $btn, $status];
		}
		echo json_encode($result);
	}
	public function change_user_status()
	{
		$id = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('id')))));
		$stat = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('stat')))));
		$update_data = array('status' => $stat);
		$ins = array('user_id' => $id);
		$result = $this->AdminModel->update_data('tbl_users', $update_data, $ins);
		if ($result == 'success') {
			echo $result;
		} else {
			echo "Oops, something went wrong...";
		}
	}

	public function get_bunit()
	{
		$id  = explode("/", $_POST['cid']);
		$data = $this->AdminModel->bunitList($id[0]);
		foreach ($data as $key => $value) {

			$result['data'][] = array(
				"bname" => $value['business_unit'],
				"bcode" => $value['bunit_code'],
				"ccode" => $id[0],
			);
		}
		echo json_encode($result);
	}

	public function get_dept()
	{
		$id  = explode("/", $_POST['bid']);
		$data = $this->AdminModel->deptList($id[1], $id[0]);
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

	public function get_dept_()
	{
		$id  = explode("/", $_POST['bid']);
		$data = $this->AdminModel->deptList_($id[0]);
		// var_dump($id);
		foreach ($data as $key => $value) {

			$result['data'][] = array(
				"dname" => $value['dept_name'],
				"dcode" => $value['dept_code'],
				"ccode" => $id[0]
			);
		}
		echo json_encode($result);
	}

	public function get_section()
	{
		$id  = explode("/", $_POST['did']);
		$data = $this->AdminModel->secList($id[2], $id[1], $id[0]);
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

	public function data_report()
	{

		$columns = array(
			0 	=>	'count',
			1 	=>	'user_id',
			2   =>  'file_name',
			3	=> 	'date_uploaded',
			4	=> 	'action'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$totalData = $this->AdminModel->get_report_count();
		$totalFiltered = $totalData;

		$user_id = $this->session->userdata('user_id');

		if (empty($this->input->post('search')['value'])) {
			$items = $this->AdminModel->get_report($limit, $start, $order, $dir, $user_id);
		} else {
			$search = $this->input->post('search')['value'];

			$items =  $this->AdminModel->search_report($limit, $start, $search, $order, $dir);

			$totalFiltered = count($items);
		}
		$data = array();
		if (!empty($items)) {
			$count = 1;
			foreach ($items as $item) {
				$nestedData['count'] = $count++;
				$nestedData['report_id'] = $item->report_id;
				//$nestedData['user_id'] = $item->user_id;
				$nestedData['file_name'] = $item->file_name;
				//$nestedData['report_path'] = $item->report_path;
				$nestedData['date_uploaded'] = $item->date_uploaded;

				$nestedData['action'] = ' <button type="button" class="btn btn-xs btn-primary" onclick="btn_download(\'' . $item->report_id . '\',  \'' . $item->file_name . '\')" ><i class="fa fa-download"></i> PDF </button>';

				$data[] = $nestedData;
			}
		}
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}

	public function tbl_cyclic_report()
	{

		$columns = array(
			0 	=>	'count',
			1 	=>	'user_id',
			2   =>  'file_name',
			3	=> 	'date_uploaded',
			4	=> 	'action'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$totalData = $this->AdminModel->get_cyclic_count();
		$totalFiltered = $totalData;

		$user_id = $this->session->userdata('user_id');

		if (empty($this->input->post('search')['value'])) {
			$items = $this->AdminModel->get_cyclic_report($limit, $start, $order, $dir, $user_id);
		} else {
			$search = $this->input->post('search')['value'];

			$items =  $this->AdminModel->search_cyclic_report($limit, $start, $search, $order, $dir);

			$totalFiltered = count($items);
		}
		$data = array();
		if (!empty($items)) {
			$count = 1;
			foreach ($items as $item) {
				$nestedData['count'] = $count++;
				$nestedData['report_id'] = $item->report_id;
				//$nestedData['user_id'] = $item->user_id;
				$nestedData['file_name'] = $item->file_name;
				//$nestedData['report_path'] = $item->report_path;
				$nestedData['date_uploaded'] = $item->date_uploaded;

				$nestedData['action'] = ' <button type="button" class="btn btn-xs btn-primary" onclick="btn_download_cyclic(\'' . $item->report_id . '\',  \'' . $item->file_name . '\')" ><i class="fa fa-download"></i> PDF </button>';
				// <p></p>

				// <button type="button" class="btn btn-xs btn-primary" onclick="btn_download_excel(\''.$item->report_id.'\',  \''.$item->file_name.'\')" ><i class="fa fa-download"></i> EXCEL </button>

				$data[] = $nestedData;
			}
		}
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}

	public function tbl_update_monthly()
	{

		$columns = array(
			0 	=>	'count',
			1 	=>	'file_name',
			2   =>  'company',
			3	=> 	'business_unit',
			4	=> 	'department',
			5	=>	'section',
			6	=>	'action'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$totalData = $this->AdminModel->update_monthly_count();
		$totalFiltered = $totalData;

		$user_id = $this->session->userdata('user_id');

		if (empty($this->input->post('search')['value'])) {
			$items = $this->AdminModel->update_monthly_report($limit, $start, $order, $dir, $user_id);
		} else {
			$search = $this->input->post('search')['value'];

			$items =  $this->AdminModel->search_update_monthly($limit, $start, $search, $order, $dir);

			$totalFiltered = count($items);
		}
		$data = array();
		if (!empty($items)) {
			$count = 1;
			foreach ($items as $item) {
				$nestedData['count'] = $count++;
				//$nestedData['loc_id'] = $item->loc_id;
				//$nestedData['user_id'] = $item->user_id;
				$nestedData['file_name'] = $item->file_name;
				$nestedData['company'] = $item->company;
				$nestedData['business_unit'] = $item->business_unit;
				$nestedData['department'] = $item->department;
				$nestedData['section'] = $item->section;

				$nestedData['action'] = ' <button type="button" class="btn btn-xs btn-primary" onclick="btn_update_monthly(\'' . $item->loc_id . '\',  \'' . $item->file_name . '\',  \'' . $item->user_id . '\')" ><i class="fa fa-folder"></i> Update </button>';

				$data[] = $nestedData;
			}
		}
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);
		echo json_encode($json_data);
	}

	public function pdf_report()
	{

		$report_id = $this->input->get('report_id');
		$file_name = $this->input->get('file_name');
		// var_dump($report_id);
		$result = $this->AdminModel->check_report($report_id);
		$fname = $file_name . '.pdf';
		if (!empty($result)) {

			ob_clean();
			// disable caching
			$now = gmdate("D, d M Y H:i:s");
			header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
			header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
			header("Last-Modified: {$now} GMT");

			// force download  
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");

			// disposition / encoding on response body
			header("Content-Disposition: attachment;filename={$fname}");
			header("Content-Transfer-Encoding: binary");

			echo @readfile($result);
		} else {

			echo json_encode("Oops, something went wrong...");
		}
	}

	public function cyclic_pdf_report()
	{

		$report_id = $this->input->get('report_id');
		$file_name = $this->input->get('file_name');
		$result = $this->AdminModel->cyclic_report_path($report_id);
		$fname = $file_name . '.pdf';
		if (!empty($result)) {

			ob_clean();
			// disable caching
			$now = gmdate("D, d M Y H:i:s");
			header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
			header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
			header("Last-Modified: {$now} GMT");

			// force download  
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");

			// disposition / encoding on response body
			header("Content-Disposition: attachment;filename={$fname}");
			header("Content-Transfer-Encoding: binary");

			echo @readfile($result);

			// header('Content-type: application/pdf');
			// //header('Content-Disposition: attachment; filename="'.$fn.'"');
			// header('Content-Disposition: attachment; filename="'.$file_name.'"');
			// readfile($result);

			// echo json_encode("success");

		} else {

			echo json_encode("Oops, something went wrong no data");
		}
	}

	public function excel_report()
	{

		$report_id = $this->input->get('report_id');
		$file_name = $this->input->get('file_name');
		$result = $this->AdminModel->excel_report_path($report_id);

		if (!empty($result)) {

			ob_clean();
			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;filename=\"" . $file_name . "\".xls");
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			echo @readfile($result);

			// echo json_encode("success");

		} else {

			echo json_encode("Oops, something went wrong no data");
		}
	}

	public function upload_exel_file()
	{
		$company = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company'))))));
		$bunit = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit'))))));
		$dept = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept'))))));
		$section = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section'))))));

		$date_from = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_from')))));
		$date_to = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_to')))));

		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '8000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$user_id = $this->session->userdata('user_id');

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		$file_locate = array('user_id' => $user_id, 'file_name' => $exelfile, 'company' => $company[1], 'business_unit' => $bunit[2], 'department' => $dept[3], 'section' => $section[4]);

		$result_1 = $this->AdminModel->insert_file_location($file_locate, $company[1], $bunit[2], $dept[3], $section[4]);
		$result_2 = $this->AdminModel->get_loc_id($company[1], $bunit[2], $dept[3], $section[4]);

		foreach ($result_2 as $key => $value) {
			$location_id = $value['loc_id'];
		}

		// if($result_1 == true){
		// 	echo "file name and location inserted  ";
		// }else{
		// 	echo "Upload.  ";
		// }

		$req = is_file(FCPATH . "assets/images/" . $exelfile);
		if ($req == true) {
			echo 'file already exist, please upload other file name.';
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			// var_dump($exelfile);
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();

				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());
				///////////////////////////////////EXCEL START////////////////////////////////////////////////////////////////////
				$item_codes			= array();
				$variant_codes 		= array();
				$descriptions 		= array();
				$uoms 				= array();
				$qtys 				= array();
				$cost_novats 		= array();
				$totalcost_novats 	= array();
				$cost_withvats 		= array();
				$totalcost_withvats = array();
				$divcodes 			= array();
				$qty_cost_novat 	= array();
				$qty_db 			= array();
				$item_codes_db 		= array();

				$xldata = FCPATH . "assets/images/" . $exelfile;

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				if ($highestColumn != 'J') {
					//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
					echo "Error in highest columns please recheck the file if the excel highestColumn is equal to J ";
				} else {
					for ($i = 2; $i <= $highestRow - 1; $i++) {
						$item_code     		=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
						$variant_code    	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
						$description     	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
						$uom     			=   $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
						$qty       			=   str_replace(",", "", $objWorksheet->getCellByColumnAndRow(4, $i)->getValue());
						$cost_novat  		=   str_replace(",", "", $objWorksheet->getCellByColumnAndRow(5, $i)->getValue());
						if ($highestRow == $highestRow) {
							$totalcost_novat 	=	str_replace(",", "", $objWorksheet->getCellByColumnAndRow(6, $i)->getCalculatedValue());
						} else {
							$totalcost_novat   	=   $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
						}
						$cost_withvat  		=   str_replace(",", "", $objWorksheet->getCellByColumnAndRow(7, $i)->getValue());
						$totalcost_withvat 	=   str_replace(",", "", $objWorksheet->getCellByColumnAndRow(8, $i)->getValue());
						$divcode		    =   $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();

						array_push($item_codes, $item_code);
						array_push($variant_codes, $variant_code);
						array_push($descriptions, $description);
						array_push($uoms, $uom);
						array_push($qtys, $qty);
						array_push($cost_novats, $cost_novat);
						array_push($totalcost_novats, $totalcost_novat);
						array_push($cost_withvats, $cost_withvat);
						array_push($totalcost_withvats, $totalcost_withvat);
						array_push($divcodes, $divcode);

						$result = $this->AdminModel->create_insert_table(
							$item_code,
							$variant_code,
							$description,
							$uom,
							$qty,
							$cost_novat,
							$totalcost_novat,
							$cost_withvat,
							$totalcost_withvat,
							$divcode,
							$file_locate,
							$location_id,
							$user_id
						);
					}
					if ($result == true) {
						echo "success";
						unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $exelfile);
					} else {
						echo " data exist ";
						unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $exelfile);
					}
				}
			}
		}
	}

	public function upload_nav()
	{
		$company = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company'))))));
		//$bunit = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit'))))));
		$dept = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept'))))));
		//$section = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section'))))));

		$date_from = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_from')))));
		$date_to = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_to')))));
		// var_dump($date_from);
		// var_dump($date_to);

		//Declare an empty array
		$date_range = array();

		// Use strtotime function
		$from_date = strtotime($date_from);
		$to_date = strtotime($date_to);

		// Use for loop to store dates into array
		// 86400 sec = 24 hrs = 60*60*24 = 1 day
		for ($currentDate = $from_date; $currentDate <= $to_date; $currentDate += (86400)) {

			$store = date('Y-m-d', $currentDate);
			$date_range[] = $store;
		}

		//var_dump($date_range);

		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '8000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$user_id = $this->session->userdata('user_id');

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		$file_locate = array('user_id' => $user_id, 'filename' => $exelfile, 'company' => $company[1], 'department' => $dept[2]);

		$result_1 = $this->AdminModel->insert_cyclic_location($file_locate, $company[1], $dept[2]);
		$result_2 = $this->AdminModel->get_cyclic_locid($company[1], $dept[2]);

		foreach ($result_2 as $key => $value) {
			$location_id = $value->cyclic_id;
		}

		// if($result_1 == true){
		// 	echo "file name and location inserted  ";
		// }else{
		// 	echo "file name and location exist.  ";
		// }

		$req = is_file(FCPATH . "assets/images/" . $exelfile);
		if ($req == true) {
			echo 'file already exist, please upload other file name.';
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();
				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());

				///////////////////////////////////EXCEL START/////////////////////////////////////////////////////////////////////////////////////////////

				$xldata = FCPATH . "assets/images/" . $exelfile;

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				if ($highestColumn != 'M') {
					//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
					echo "Error in highest columns please recheck the excel file if the highestColumn is equal to M ";
				} else {

					$item_codes			= [];
					$barcode_nos		= [];
					$descriptions		= [];
					$uoms				= [];
					$qtys				= [];
					$bunits				= [];
					$depts 				= [];
					$sections			= [];
					$rack_descs			= [];
					$empnos				= [];
					$datetimes_scanned 	= [];
					$datetimes_saved	= [];
					$datetimes_exported	= [];

					$item_codess 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('A2:A' . $highestRow);
					$bar_codess 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('B2:B' . $highestRow);
					$descriptionss 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('C2:C' . $highestRow);
					$uomss 			 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('D2:D' . $highestRow);
					$business_unitss = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('F2:F' . $highestRow);
					$scanned_date    = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('K2:F' . $highestRow);

					$date_scanned 	 = $PHPExcel_Shared_Date::ExcelToPHPObject($scanned_date)->format('Y-m-d');

					$its 	 = [];
					$bcodes  = [];
					$desc 	 = [];
					$um 	 = [];
					$_bunits = [];
					$xl_date = [];

					foreach ($bar_codess as $br_code) {
						$bcodes[] = $br_code[0];
					}

					foreach ($item_codess as $ite) {
						$its[] = $ite[0];
					}

					foreach ($descriptionss as $_desc) {
						$desc[] = $_desc[0];
					}

					foreach ($uomss as $_uomss) {
						$um[] = $_uomss[0];
					}

					foreach ($business_unitss as $_bunit) {
						$_bunits[] = $_bunit[0];
					}

					foreach ($date_scanned as $_date) {
						$xl_date[] = $_date[0];
					}

					$uniq_item_codes 	= array_values(array_unique($its));
					$uniq_brcode 		= array_values(array_unique($bcodes));
					$uniq_desc 		 	= array_values(array_unique($desc));
					$uniq_um 			= array_values(array_unique($um));
					$uniq_bunits		= array_values(array_unique($_bunits));
					$uniq_date			= array_values(array_unique($xl_date));

					$qty_sum = 0.00;
					$qty_merge = [];
					$db_qty_sum = 0.00;
					$db_qty_merge = [];
					$vrince = [];

					$qty_pm_sum 		= 0.00;
					$db_qty_sum 		= 0.00;
					$db_qty_merge 		= [];
					$db_qty_pm_sum 		= 0.00;
					$db_qty_pm 			= [];

					$qty_alta 			= [];
					$qty_alta_sum 		= 0.00;
					$db_qty_alta		= [];
					$db_qty_alta_sum	= 0.00;

					$qty_asc 			= [];
					$qty_asc_sum		= 0.00;
					$db_qty_asc			= [];
					$db_qty_asc_sum 	= 0.00;

					$qty_talibon		= [];
					$qty_talibon_sum	= 0.00;
					$db_qty_talibon		= [];
					$db_qty_talibon_sum = 0.00;

					// $saved_date = array();
					// foreach ($uniq_item_codes as $ndex => $itmcode) {
					// 	// var_dump($uniq_brcode[$ndex]);
					// 	 $date_saved = $this->AdminModel->get_count_data($itmcode, $uniq_brcode[$ndex]);

					// 		foreach ($date_saved as $key => $date_val) {
					//   	    		$saved_date[] = $date_val['datetime_saved'];
					//   	    	}
					// }

					//$range_date = array_values(array_intersect($date_range, $saved_date));

					//var_dump($uniq_date);

					foreach ($uniq_item_codes as $k => $itm) {	//var_dump($range_date[$k]);
						for ($i = 2; $i <= $highestRow; $i++) {

							$item_code     		=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
							$barcode_no     	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
							$description     	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
							$uom     			=   $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
							$qty       			=   $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
							$bunit       		=   $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
							$dept       		=   $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
							$section       		=   $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
							$rack_desc       	=   $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
							$empno       		=   $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
							$datetime_scanned  	=   $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
							$datetime_saved    	=   $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
							$datetime_exported 	=   $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();

							$date_time_scanned 	= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_scanned)->format('Y-m-d');
							$date_time_saved 		= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_saved)->format('Y-m-d');
							$date_time_exported 	= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_exported)->format('Y-m-d');

							array_push($item_codes, $item_code);
							array_push($barcode_nos, $barcode_no);
							array_push($descriptions, $description);
							array_push($uoms, $uom);
							array_push($qtys, $qty);
							array_push($bunits, $bunit);
							array_push($depts, $dept);
							array_push($sections, $section);
							array_push($rack_descs, $rack_desc);
							array_push($empnos, $empno);
							array_push($datetimes_scanned, $date_time_scanned);
							array_push($datetimes_saved, $date_time_saved);
							array_push($datetimes_exported, $date_time_exported);

							//var_dump(array_values(array_intersect($date_range, $datetimes_scanned)));
							// var_dump(array_values(array_unique($date_time_scanned)));
							if ($item_code == $itm  && $bunit == 'ISLAND CITY MALL') {
								$qty_merge[$item_code] = $qty_sum += $qty;
								$bunit_icm = $bunit;
							}
							if ($item_code == $itm  && $bunit == 'PLAZA MARCELA') {
								$qty_pm[$item_code] = $qty_pm_sum += $qty;
								$bunit_pm = $bunit;
							}
							if ($item_code == $itm  && $bunit == 'ALTA CITA') {
								$qty_alta[$item_code] = $qty_alta_sum += $qty;
							}
							if ($item_code == $itm  && $bunit == 'ASC') {
								$qty_asc[$item_code] = $qty_asc_sum += $qty;
							}
							if ($item_code == $itm  && $bunit == 'TALIBON') {
								$qty_talibon[$item_code] = $qty_talibon_sum += $qty;
							}
						}
						$qty_sum = 0;

						//foreach ($range_date as $selected_dates){

						//$result_3 = $this->AdminModel->get_count_items($itm,  $uniq_brcode[$k]);

						//foreach ($result_3 as  $value) {
						//var_dump($uom);
						$datass = array(
							'user_id'			=> $user_id,
							'loc_id'			=> $location_id,
							'itemcode' 			=> $itm,
							'barcode'			=> $uniq_brcode[$k],
							'description' 		=> $uniq_desc[$k],
							'uom'				=> $uom,
							'qty_xl_pm'			=> $qty_pm[$itm],
							'qty_xl_icm'		=> $qty_merge[$itm],
							'qty_xl_asc'		=> $qty_asc[$itm],
							'qty_xl_alta'		=> $qty_alta[$itm],
							'qty_xl_tal'		=> $qty_talibon[$itm],
							'business_unit'		=> $uniq_bunits[$k],
							//'department'		=> $value['department'],
							//'empno'			=> $value['empno'],
							//'variance'		=> $vrince[$value['itemcode']]

						);
						$result_4 = $this->AdminModel->insert_nav($datass, $user_id, $location_id, $itm, $uniq_brcode[$k]);
						//}		
						//}
					}
					if ($result_4 == true) {
						echo " success ";
					} else {
						echo " something went wrong";
					}
				}
			}
		}
	}

	public function nav_report()
	{

		$company = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company')))));
		//$bunit = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit')))));
		$dept = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept')))));
		//$section = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section')))));	

		$result_1 = $this->AdminModel->get_cyclic_id($company, $dept);

		foreach ($result_1 as $key => $value) {
			$location_id = $value['cyclic_id']; //var_dump($value['cyclic_id']);
			$filename = $value['filename'];
			$fname 	= explode(".", $filename);
		}
		if (empty($location_id)) {
			echo 'invalid select of location or no lacation selected';
		} else {
			$result = $this->AdminModel->get_nav($location_id);
			if ($result == null) {
				echo 'error';
			} else {
				foreach ($result as $key => $value) {

					$data['item_code'][]		= $value['itemcode'];
					$data['description'][] 		= $value['description'];
					$data['uom'][]				= $value['uom'];
					$data['qty_pm'][] 			= $value['qty_xl_pm'];
					$data['qty_alta'][]			= $value['qty_xl_alta'];
					$data['qty_asc'][]			= $value['qty_xl_asc'];
					$data['qty_talibon'][]		= $value['qty_xl_tal'];
					$data['qty_icm'][]			= $value['qty_xl_icm'];

					$data['business_unit'][]	= $value['business_unit'];
					$data['department'][]		= $value['department'];
					//$data['variance'][]			= $value['variance'];
					$data['exelfile']			= $fname[0];
				}
				$this->load->view('store_consolidation/pages/nav_report.php', $data);

				echo 'PDF file created see on report table';
			}
			//$response = $this->AdminModel->empty_cyclic();

			$req = is_file(FCPATH . "assets/images/" . $filename);

			if ($req == true) {
				unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $filename);
				$this->AdminModel->empty_nav($location_id);
				$this->AdminModel->empty_cyclic($location_id);
			}
		}
	}

	public function file_nav()
	{
		$company = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company'))))));
		//$bunit = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit'))))));
		$dept = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept'))))));
		//$section = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section'))))));

		$date_from = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_from')))));
		$date_to = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_to')))));

		$date_no = explode("-", $date_from);
		$getmonth = date("F", mktime(0, 0, 0, $date_no[1], 10));
		$year_month = $getmonth . " " . $date_no[0];
		//var_dump($getmonth." ".$date_no[0]);

		//Declare an empty array
		$date_range = array();

		// Use strtotime function
		$from_date = strtotime($date_from);
		$to_date = strtotime($date_to);

		// Use for loop to store dates into array
		// 86400 sec = 24 hrs = 60*60*24 = 1 day
		for ($currentDate = $from_date; $currentDate <= $to_date; $currentDate += (86400)) {
			$store = date('Y-m-d', $currentDate);
			$date_range[] = $store;
		}

		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '8000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$user_id = $this->session->userdata('user_id');

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		$file_locate = array('user_id' => $user_id, 'filename' => $exelfile, 'company' => $company[1], 'department' => $dept[2]);

		$result_1 = $this->AdminModel->insert_cyclic_location($file_locate, $company[1], $dept[2]);
		$result_2 = $this->AdminModel->get_cyclic_locid($company[1], $dept[2]);

		foreach ($result_2 as $key => $value) {
			$location_id = $value->cyclic_id;
		}
		$req = is_file(FCPATH . "assets/images/" . $exelfile);
		if ($req == true) {
			echo 'file already exist, please upload other file name.';
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();
				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());

				///////////////////////////////////EXCEL START/////////////////////////////////////////////////////////////////////////////////////////////

				$xldata = FCPATH . "assets/images/" . $exelfile;

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				if ($highestColumn != 'N') {
					//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
					echo "Error in highest columns please recheck the excel file if the highestColumn is equal to N ";
				} else {

					$item_codes			= [];
					$barcode_nos		= [];
					$descriptions		= [];
					$uoms				= [];
					$stock_rooms		= [];
					$selling_areas		= [];
					$bunits				= [];
					$depts 				= [];
					$sections			= [];
					$rack_descs			= [];
					$empnos				= [];
					$datetimes_scanned 	= [];
					$datetimes_saved	= [];
					$datetimes_exported	= [];

					$item_codess 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('A2:A' . $highestRow);
					$bar_codess 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('B2:B' . $highestRow);
					$descriptionss 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('C2:C' . $highestRow);
					//$uomss 			 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('D2:D'.$highestRow);
					$business_unitss = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('G2:G' . $highestRow);

					for ($i = 2; $i <= $highestRow; $i++) {

						$dates  			= $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
						$date_selected[] 	= PHPExcel_Shared_Date::ExcelToPHPObject($dates)->format('Y-m-d');
						//var_dump($date_selected);          			
					}
					//var_dump($date_selected);
					//var_dump($date_range);

					$date_intersect = array_values(array_intersect($date_range, $date_selected));
					//var_dump($date_intersect);

					$its 	 = [];
					$bcodes  = [];
					$desc 	 = [];
					//$um 	 = [];
					$_bunits = [];

					foreach ($bar_codess as $br_code) {
						$bcodes[] = $br_code[0];
					}

					foreach ($item_codess as $ite) {
						$its[] = $ite[0];
					}

					foreach ($descriptionss as $_desc) {
						$desc[] = $_desc[0];
					}

					// foreach($uomss as $_uomss){
					// 	$um[] = $_uomss[0];
					// }

					foreach ($business_unitss as $_bunit) {
						$_bunits[] = $_bunit[0];
					}

					$uniq_item_codes 	= array_values(array_unique($its));
					$uniq_brcode 		= array_values(array_unique($bcodes));
					$uniq_desc 		 	= array_values(array_unique($desc));
					//$uniq_um 			= array_values(array_unique($um));
					$uniq_bunits		= array_values(array_unique($_bunits));

					$qty_sum 			= 0.00;
					$qty_merge 			= [];
					$db_qty_sum 		= 0.00;
					$db_qty_merge 		= [];
					$sel_area 			= [];
					$sum_sel_area		= 0.00;

					$qty_pm_sum 		= 0.00;
					$db_qty_pm 			= [];
					$sa_pm_sum			= 0.00;
					$sel_area_pm		= [];
					$db_qty_sum 		= 0.00;
					$db_qty_pm_sum 		= 0.00;

					$qty_alta 			= [];
					$qty_alta_sum 		= 0.00;

					$sa_alta_sum		= 0.00;
					$sel_area_alta		= [];

					$db_qty_alta		= [];
					$db_qty_alta_sum	= 0.00;

					$qty_asc 			= [];
					$qty_asc_sum		= 0.00;

					$sa_asc_sum			= 0.00;
					$sel_area_asc		= [];

					$db_qty_asc			= [];
					$db_qty_asc_sum 	= 0.00;

					$qty_talibon		= [];
					$qty_talibon_sum	= 0.00;

					$sa_tal_sum			= 0.00;
					$sel_area_talibon	= [];

					$db_qty_talibon		= [];
					$db_qty_talibon_sum = 0.00;

					$vrince 			= [];

					foreach ($uniq_item_codes as $k => $itm) {
						for ($i = 2; $i <= $highestRow; $i++) {

							$item_code     		=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
							$barcode_no     	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
							$description     	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
							$uom     			=   $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
							$stock_room       	=   $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
							$selling_area       =   $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
							$bunit       		=   $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
							$dept       		=   $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
							$section       		=   $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
							$rack_desc       	=   $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
							$empno 				=   $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();

							$datetime_scanned  	=   $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
							$datetime_saved    	=   $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();
							$datetime_exported 	=   $objWorksheet->getCellByColumnAndRow(13, $i)->getValue();

							$date_time_scanned 		= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_scanned)->format('Y-m-d');
							$date_time_saved 		= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_saved)->format('Y-m-d');
							$date_time_exported 	= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_exported)->format('Y-m-d');

							array_push($item_codes, $item_code);
							array_push($barcode_nos, $barcode_no);
							array_push($descriptions, $description);
							array_push($uoms, $uom);
							array_push($stock_rooms, $stock_room);
							array_push($selling_areas, $selling_area);
							array_push($bunits, $bunit);
							array_push($depts, $dept);
							array_push($sections, $section);
							array_push($rack_descs, $rack_desc);
							array_push($empnos, $empno);
							array_push($datetimes_scanned, $date_time_scanned);
							array_push($datetimes_saved, $date_time_saved);
							array_push($datetimes_exported, $date_time_exported);

							foreach ($date_intersect as $key => $sel_date) {

								if ($item_code == $itm  && $bunit == 'ISLAND CITY MALL' && $sel_date == $date_time_scanned) {
									$qty_merge[$item_code] = $qty_sum += $stock_room;
									$sel_area[$item_code] = $sum_sel_area += $selling_area;
									$bunit_icm = $bunit;
								}
								if ($item_code == $itm  && $bunit == 'PLAZA MARCELA' && $sel_date == $date_time_scanned) {
									$qty_pm[$item_code] = $qty_pm_sum += $stock_room;
									$sel_area_pm[$item_code] = $sa_pm_sum += $selling_area;
									$bunit_pm = $bunit;
								}
								if ($item_code == $itm  && $bunit == 'ALTA CITA' && $sel_date == $date_time_scanned) {
									$qty_alta[$item_code] = $qty_alta_sum += $stock_room;
									$sel_area_alta[$item_code] = $sa_alta_sum += $selling_area;
								}

								if ($item_code == $itm  && $bunit == 'ASC' && $sel_date == $date_time_scanned) {
									$qty_asc[$item_code] = $qty_asc_sum += $stock_room;
									$sel_area_asc[$item_code] = $sa_asc_sum += $selling_area;
								}

								if ($item_code == $itm  && $bunit == 'TALIBON' && $sel_date == $date_time_scanned) {
									$qty_talibon[$item_code] = $qty_talibon_sum += $stock_room;
									$sel_area_talibon[$item_code] = $sa_tal_sum += $selling_area;
								}
							}
						}

						$qty_sum 		 = 0;
						$sum_sel_area	 = 0;

						$qty_pm_sum 	 = 0;
						$sa_pm_sum		 = 0;

						$qty_alta_sum 	 = 0;
						$sa_alta_sum	 = 0;

						$qty_asc_sum 	 = 0;
						$sa_asc_sum		 = 0;

						$qty_talibon_sum = 0;
						$sa_tal_sum		 = 0;

						//var_dump($qty_pm);
						//var_dump($sel_area_pm);

						//foreach ($range_date as $selected_dates){

						//$result_3 = $this->AdminModel->get_count_items($itm,  $uniq_brcode[$k]);

						//foreach ($result_3 as  $value) {

						$datass = array(
							'user_id'				=> $user_id,
							'loc_id'				=> $location_id,
							'itemcode' 				=> $itm,
							'barcode'				=> $uniq_brcode[$k],
							'description' 			=> $uniq_desc[$k],
							'uom'					=> $uom,
							'icm_stock_room'		=> @$qty_merge[$itm],
							'icm_selling_area'		=> @$sel_area[$itm],
							'pm_stock_room'			=> @$qty_pm[$itm],
							'pm_selling_area'		=> @$sel_area_pm[$itm],
							'asc_stock_room'		=> @$qty_asc[$itm],
							'asc_selling_area'		=> @$sel_area_asc[$itm],
							'alta_stock_room'		=> @$qty_alta[$itm],
							'alta_selling_area'		=> @$sel_area_alta[$itm],
							'talibon_stock_room'	=> @$qty_talibon[$itm],
							'talibon_selling_area'	=> @$sel_area_talibon[$itm]

							//'department'		=> $value['department'],
							//'empno'			=> $value['empno'],
							//'variance'		=> $vrince[$value['itemcode']]

						);
						$result_4 = $this->AdminModel->conso_nav($datass, $user_id, $location_id, $itm, $uniq_brcode[$k]);
						//}		
						//}
					}
					if ($result_4 == true) {
						echo " upload success";
					} else {
						echo " success ";
					}
				}
			}
		}
	}

	public function nav_file_report()
	{
		$company = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company')))));
		$dept = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept')))));

		$result_1 = $this->AdminModel->get_cyclic_id($company, $dept);

		foreach ($result_1 as $key => $value) {
			$location_id = $value['cyclic_id'];
			$filename = $value['filename'];
			$fname 	= explode(".", $filename);
		}
		if (empty($location_id)) {
			echo 'invalid select of location or no lacation selected';
		} else {
			$result = $this->AdminModel->get_nav_file($location_id);
			if ($result == null) {
				echo 'error';
			} else {
				foreach ($result as $key => $value) {

					$data['item_code'][]			= $value['itemcode'];
					$data['description'][] 			= $value['description'];
					$data['uom'][]					= $value['uom'];
					$data['pm_stockroom'][] 		= $value['pm_stock_room'];
					$data['pm_sellingarea'][]		= $value['pm_selling_area'];
					$data['asc_stockroom'][]		= $value['asc_stock_room'];
					$data['asc_sellingarea'][]		= $value['asc_selling_area'];
					$data['alta_stockroom'][]		= $value['alta_stock_room'];
					$data['alta_sellingarea'][]		= $value['alta_selling_area'];
					$data['icm_stockroom'][]		= $value['icm_stock_room'];
					$data['icm_sellingarea'][]		= $value['icm_selling_area'];
					$data['tal_stockroom'][]		= $value['talibon_stock_room'];
					$data['tal_sellingarea'][]		= $value['talibon_selling_area'];

					//$data['department'][]			= $value['department'];
					//$data['variance'][]			= $value['variance'];
					$data['exelfile']				= $fname[0];
				}
				$this->load->view('store_consolidation/pages/nav_file_report.php', $data);

				//echo 'PDF file created ';
			}
			//$response = $this->AdminModel->empty_cyclic();

			$req = is_file(FCPATH . "assets/images/" . $filename);

			if ($req == true) {
				unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $filename);
				$this->AdminModel->empty_nav_file($location_id);
				$this->AdminModel->empty_cyclic($location_id);
			}
		}
	}

	public function display_temp_report()
	{
		$file_name = $this->input->get('file');
		$fname = $file_name . '.pdf';
		$file = 'assets/tempfile/' . $fname;

		ob_clean();
		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		// force download  
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$fname}");
		header("Content-Transfer-Encoding: binary");

		echo @readfile($file);

		if (file_exists($file)) {
			unlink($file);
		}
	}

	public function update_monthly()
	{
		$company = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company'))))));
		$bunit = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit'))))));
		$dept = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept'))))));
		$section = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section'))))));
		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '8000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		//var_dump($location_id);
		$req = is_file(FCPATH . "assets/images/" . $exelfile);
		if ($req == true) {
			echo 'file already exist, please upload a different file name.';
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();
				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());

				///////////////////////////////////EXCEL START/////////////////////////////////////////////////////////////////////////////////////////////

				$item_codes	= array();
				$variant_codes = array();
				$descriptions = array();
				$uoms = array();
				$qtys = array();
				$cost_novats = array();
				$totalcost_novats = array();
				$cost_withvats = array();
				$totalcost_withvats = array();
				$divcodes = array();
				$qty_cost_novat = array();
				$qty_db = array();
				$item_codes_db = array();

				$xldata = FCPATH . "assets/images/" . $exelfile;

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				if ($highestColumn != 'J') {
					//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
					echo "Error in highest columns please recheck the file if the excel highestColumn is equal to J ";
				} else {
					for ($i = 2; $i <= $highestRow - 1; $i++) {
						$item_code     		=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
						$variant_code    	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
						$description     	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
						$uom     			=   $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
						$qty       			=   number_format($objWorksheet->getCellByColumnAndRow(4, $i)->getValue(), 2);
						$cost_novat  		=   $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
						if ($highestRow == $highestRow) {
							$totalcost_novat =		number_format(floatval($objWorksheet->getCellByColumnAndRow(6, $i)->getCalculatedValue()), 5);
						} else {
							$totalcost_novat   	=   $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
						}
						$cost_withvat  		=   $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
						$totalcost_withvat 	=  $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
						$divcode		    =   $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();

						array_push($item_codes, $item_code);
						array_push($variant_codes, $variant_code);
						array_push($descriptions, $description);
						array_push($uoms, $uom);
						array_push($qtys, $qty);
						array_push($cost_novats, $cost_novat);
						array_push($totalcost_novats, $totalcost_novat);
						array_push($cost_withvats, $cost_withvat);
						array_push($totalcost_withvats, $totalcost_withvat);
						array_push($divcodes, $divcode);
					}
					$result_2 = $this->AdminModel->get_loc_id($company[1], $bunit[2], $dept[3], $section[4]);

					foreach ($result_2 as $key => $value) {
						$location_id = $value['loc_id'];
					}

					for ($i = 0; $i < count($item_codes); $i++) {
						$codes = $item_codes[$i];
						$response = $this->AdminModel->get_monthly_items($codes, $location_id);
					}
					//var_dump($response);
					$qty_total = 0;
					$sum = 0;
					$qty_cost_novat = 0.00;
					foreach ($response as $key => $value) {

						$qty_total = str_replace(",", "", $value['qty']) + str_replace(",", "", $qtys[$key]);

						$costnovat_qty = $qty_total * str_replace(",", "", $value['cost_novat']);

						//var_dump(number_format($costnovat_qty), 2);

						$qty_cost_novat = number_format($costnovat_qty, 2);

						$sum_qty = array('qty' => $qty_total);
						$qty_cost_novats = array('totalcost_novat' => $qty_cost_novat);

						$items_code = $value['item_code'];

						$res1 = $this->AdminModel->update_qty_cosnovat_totalcostnovat($sum_qty, $items_code, $qty_cost_novats, $location_id);
						//var_dump($qty_total);

					}
					if ($res1 == true) {
						echo 'success data updated';
					} else {
						echo 'something went wrong..';
					}
				}
			}
		}
	}

	public function update_monthly_data()
	{
		$loc_id = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('loc_id')))));
		$user_id = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('user_id')))));

		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '8000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		//var_dump($location_id);
		$req = is_file(FCPATH . "assets/images/" . $exelfile);
		if ($req == true) {
			echo 'file already exist, please upload a different file name.';
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();
				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());

				///////////////////////////////////EXCEL START/////////////////////////////////////////////////////////////////////////////////////////////

				$item_codes	= array();
				$variant_codes = array();
				$descriptions = array();
				$uoms = array();
				$qtys = array();
				$cost_novats = array();
				$totalcost_novats = array();
				$cost_withvats = array();
				$totalcost_withvats = array();
				$divcodes = array();
				$qty_cost_novat = array();
				$qty_db = array();
				$item_codes_db = array();

				$xldata = FCPATH . "assets/images/" . $exelfile;

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				if ($highestColumn != 'J') {
					//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
					echo "Error in highest columns please recheck the file if the excel highestColumn is equal to J ";
				} else {
					for ($i = 2; $i <= $highestRow - 1; $i++) {
						$item_code     		=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
						$variant_code    	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
						$description     	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
						$uom     			=   $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
						$qty       			=   number_format($objWorksheet->getCellByColumnAndRow(4, $i)->getValue(), 2);
						$cost_novat  		=   $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
						if ($highestRow == $highestRow) {
							$totalcost_novat = number_format(floatval($objWorksheet->getCellByColumnAndRow(6, $i)->getCalculatedValue()), 5);
						} else {
							$totalcost_novat   	=   $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
						}
						$cost_withvat  		=   $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
						$totalcost_withvat 	=  $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
						$divcode		    =   $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();

						array_push($item_codes, $item_code);
						array_push($variant_codes, $variant_code);
						array_push($descriptions, $description);
						array_push($uoms, $uom);
						array_push($qtys, $qty);
						array_push($cost_novats, $cost_novat);
						array_push($totalcost_novats, $totalcost_novat);
						array_push($cost_withvats, $cost_withvat);
						array_push($totalcost_withvats, $totalcost_withvat);
						array_push($divcodes, $divcode);
					}
					$qty_total = 0;
					$sum = 0;
					$qty_cost_novat = 0.00;

					for ($i = 0; $i < count($item_codes); $i++) {
						$codes = $item_codes[$i];
						$response = $this->AdminModel->get_monthly_items($codes, $loc_id);
						if (empty($response)) {
							echo 'file does not exist';
						} else {
							$sum_qty = 0.00;
							$qty_total = 0.00;
							foreach ($response as $key => $value) {

								$qty_total = str_replace(",", "", $value['qty']) + str_replace(",", "", $qtys[$i]);

								$costnovat_qty = $qty_total * str_replace(",", "", $value['cost_novat']);
								$cost_withvat_qty = $qty_total * str_replace(",", "", $value['cost_withvat']);

								$qty_cost_novat = number_format($costnovat_qty, 2);
								$qty_cost_withvat = number_format($cost_withvat_qty, 2);

								$sum_qty = array('qty' => $qty_total);
								$qty_cost_novats = array('totalcost_novat' => $qty_cost_novat);
								$qty_cost_withvats = array('totalcost_withvat' => $qty_cost_novat);

								$items_code = $value['item_code'];

								$res1 = $this->AdminModel->update_qty_cosnovat_totalcostnovat(
									$sum_qty,
									$items_code,
									$qty_cost_novats,
									$qty_cost_withvats,
									$loc_id
								);
							}
						}
					}
					if ($res1 == true) {
						echo "success";
					} else {
						echo 'something went wrong..';
					}
				}
			}
		}
	}

	public function generate_variance()
	{
		$date_from = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_from')))));
		$date_to = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_to')))));

		$company = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company'))))));
		$bunit = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit'))))));
		$dept = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept'))))));
		$section = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section'))))));

		$fname = $date_to = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('file_name')))));
		$user_id = $this->session->userdata('user_id');

		// Declare an empty array
		$date_range = array();

		// Use strtotime function
		$from_date = strtotime($date_from);
		$to_date = strtotime($date_to);

		// Use for loop to store dates into array
		// 86400 sec = 24 hrs = 60*60*24 = 1 day
		for ($currentDate = $from_date; $currentDate <= $to_date; $currentDate += (86400)) {
			$store = date('Y-m-d', $currentDate);
			$date_range[] = $store;
		}

		$file_locate = array('user_id' => $user_id, 'filename' => $fname, 'company' => $company[1], 'department' => $dept[3]);

		//$result_1 = $this->AdminModel->insert_cyclic_location($file_locate, $company[1], $dept[3]);
		$result_2 = $this->AdminModel->get_cyclic_locid($company[1], $dept[3]);

		foreach ($result_2 as $key => $value) {
			$location_id = $value->cyclic_id;
		}

		///////////////////////////////////EXCEL START/////////////////////////////////////////////////////////////////////////////////////////////

		$nav_data = $this->AdminModel->get_data_nav();

		foreach ($nav_data as $key => $nav) {

			$item_codess[]	  = $nav['item_code'];
			$descriptionss[]  = $nav['description'];
			$uomss[]  	 	  = $nav['uom'];
			$qtyss[] 		  =	$nav['qty'];
		}

		$uniq_item_codes 	= array_values(array_unique($item_codess));

		$uniq_desc 		 	= array_values(array_unique($descriptionss));
		$uniq_um 			= array_values(array_unique($uomss));
		//$uniq_qty 			= array_values(array_unique($qtyss));
		//$uniq_bunits		= array_values(array_unique($_bunits));

		$qty_sum 			= 0.00;
		$qty_merge 			= [];
		$qty_pm_sum 		= 0.00;
		$qty_pm				= [];

		$db_qty_sum 		= 0.00;
		$db_qty_merge 		= [];
		$db_qty_pm_sum 		= 0.00;
		$db_qty_pm 			= [];

		$qty_alta 			= [];
		$qty_alta_sum 		= 0.00;
		$db_qty_alta		= [];
		$db_qty_alta_sum	= 0.00;

		$qty_asc 			= [];
		$qty_asc_sum		= 0.00;
		$db_qty_asc			= [];
		$db_qty_asc_sum 	= 0.00;

		$qty_talibon		= [];
		$qty_talibon_sum	= 0.00;
		$db_qty_talibon		= [];
		$db_qty_talibon_sum = 0.00;

		$vrince 			= [];
		$pm_variance		= [];
		$alta_variance		= [];
		$asc_variance	 	= [];
		$talibon_variance	= [];
		$saved_date 		= [];

		$qty_sum = 0;
		$qty_pm_sum = 0;
		$qty_alta_sum = 0;
		$qty_asc_sum = 0;
		$qty_talibon_sum  = 0;

		// var_dump($uniq_qty);
		foreach ($uniq_item_codes as $k => $itmcode) {

			$date_saved = $this->AdminModel->pcount_data($itmcode, @$uniq_brcode[$k]);

			foreach ($date_saved as $key => $date_val) {
				$dateonly = explode(" ", $date_val['datetime_scanned']);
				$saved_date[] = $dateonly[0];
			}
			if ($itmcode == $itmcode) {
				$qty_merge[$itmcode] = $qty_sum += $qtyss[$k];
				$bunit_icm = $bunit;
				var_dump($qty_merge);
			}

			$range_date = array_values(array_intersect($date_range, $saved_date));

			foreach ($range_date as $selected_dates) {

				$result_3 = $this->AdminModel->pcount_items($itmcode, $selected_dates, $uniq_brcode[$k]);

				foreach ($result_3 as $key => $value) {
					foreach ($uniq_desc as $k => $udesc) {
						if ($itm == $value['itemcode'] && $value['description'] == $udesc) {

							$db_qty_merge[$itm] = $db_qty_sum += $value['qty'];
							$code_item = $value['itemcode'];
						}
					}
				}

				$db_qty_sum 		= 0;
				$db_qty_pm_sum 	 	= 0;
				$db_qty_alta_sum 	= 0;
				$db_qty_asc_sum  	= 0;
				$db_qty_talibon_sum = 0;

				foreach ($qty_merge as $key_2 => $qty_exel) {

					if ($itm == $key_2) {

						@$vrince[$itm] = $db_qty_merge[$itm] - $qty_exel;
					}
				}

				foreach ($result_3 as $k =>  $value) {
					if ($code_item == $value['itemcode']) {
						$icm_bunit = $value['business_unit'];
						$icm_code   = $value['itemcode'];

						$yrdata = strtotime($value['datetime_scanned']);
						$as_of =  date('M Y', $yrdata);
						//var_dump($as_of);	
						$datass = array(
							'user_id'	=> $user_id,
							'loc_id'		=> $location_id,
							'itemcode' 		=> $value['itemcode'],
							'barcode'		=> $value['barcode'],
							'description' 	=> $value['description'],
							'uom'			=> $value['uom'],
							'qty_db'		=> $db_qty_merge[$code_item],
							'qty_excel'		=> @$qty_merge[$value['itemcode']],
							'business_unit'	=> $icm_bunit,
							'department'	=> $value['department'],
							'section'		=> $value['section'],
							'empno'			=> $value['empno'],
							'variance'		=> @$vrince[$value['itemcode']],
							'date'			=> $as_of
						);
						//$result_4 = $this->AdminModel->insert_cyclic_variance($datass,$user_id,$location_id,$value['itemcode'], $value['barcode']);		
					}
				}
			}
		}
		if (@$result_4 == true) {
			echo "succes";
		} else {
			echo "no match data ";
		}
		//}		
		//}	
		//}
	}

	public function generate_pcount()
	{
		$company = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company'))))));
		//$bunit = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit'))))));
		$dept = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept'))))));
		//$section = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section'))))));

		$date_from = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_from')))));
		$date_to = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_to')))));

		// Declare an empty array
		$date_range = array();

		// Use strtotime function
		$from_date = strtotime($date_from);
		$to_date = strtotime($date_to);

		// Use for loop to store dates into array
		// 86400 sec = 24 hrs = 60*60*24 = 1 day
		for ($currentDate = $from_date; $currentDate <= $to_date; $currentDate += (86400)) {
			$store = date('Y-m-d', $currentDate);
			$date_range[] = $store;
		}

		$user_id = $this->session->userdata('user_id');

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		$file_locate = array('user_id' => $user_id, 'filename' => $exelfile, 'company' => $company[1], 'department' => $dept[2]);

		$result_1 = $this->AdminModel->insert_cyclic_location($file_locate, $company[1], $dept[2]);
		$result_2 = $this->AdminModel->get_cyclic_locid($company[1], $dept[2]);

		foreach ($result_2 as $key => $value) {
			$location_id = $value->cyclic_id;
		}

		///////////////////////////////////EXCEL START/////////////////////////////////////////////////////////////////////////////////////////////

		$its 	 = [];
		$bcodes  = [];
		$desc 	 = [];
		$um 	 = [];
		$_bunits = [];

		$nav_data = $this->AdminModel->get_count_data_nav();

		foreach ($nav_data as $key => $nav) {

			$item_codess	= $nav['itemcode'];
			$bar_codess  	= $nav['barcode'];
			$descriptionss  = $nav['description'];
			$uomss  	 	= $nav['uom'];
			// var_dump($item_codess);

			foreach ($bar_codess as $br_code) {
				$bcodes[] = $br_code[0];
			}

			foreach ($item_codess as $ite) {
				$its[] = $ite[0];
			}

			foreach ($descriptionss as $_desc) {
				$desc[] = $_desc[0];
			}

			foreach ($uomss as $_uomss) {
				$um[] = $_uomss[0];
			}
		}

		$uniq_item_codes 	= array_values(array_unique($its));
		$uniq_brcode 	 	= array_values(array_unique($bcodes));
		$uniq_desc 		 	= array_values(array_unique($desc));
		$uniq_um 			= array_values(array_unique($um));
		//$uniq_bunits		= array_values(array_unique($_bunits));

		$qty_sum 			= 0.00;
		$qty_merge 			= [];
		$qty_pm_sum 		= 0.00;
		$qty_pm				= [];

		$db_qty_sum 		= 0.00;
		$db_qty_merge 		= [];
		$db_qty_pm_sum 		= 0.00;
		$db_qty_pm 			= [];

		$qty_alta 			= [];
		$qty_alta_sum 		= 0.00;
		$db_qty_alta		= [];
		$db_qty_alta_sum	= 0.00;

		$qty_asc 			= [];
		$qty_asc_sum		= 0.00;
		$db_qty_asc			= [];
		$db_qty_asc_sum 	= 0.00;

		$qty_talibon		= [];
		$qty_talibon_sum	= 0.00;
		$db_qty_talibon		= [];
		$db_qty_talibon_sum = 0.00;

		$vrince 			= [];
		$pm_variance		= [];
		$alta_variance		= [];
		$asc_variance	 	= [];
		$talibon_variance	= [];
		$saved_date 		= [];

		$qty_sum = 0;
		$qty_pm_sum = 0;
		$qty_alta_sum = 0;
		$qty_asc_sum = 0;
		$qty_talibon_sum  = 0;

		foreach ($uniq_item_codes as $k => $itmcode) {

			$date_saved = $this->AdminModel->pcount_data($itmcode, @$uniq_brcode[$k]);

			foreach ($date_saved as $key => $date_val) {
				$dateonly = explode(" ", $date_val['datetime_scanned']);
				$saved_date[] = $dateonly[0];
			}
			if ($itmcode == $itmcode) {
				$qty_merge[$itmcode] = $qty_sum += $qty;
				$bunit_icm = $bunit;
			}

			$range_date = array_values(array_intersect($date_range, $saved_date));

			foreach ($range_date as $selected_dates) {

				$result_3 = $this->AdminModel->pcount_items($itmcode, $selected_dates, $uniq_brcode[$k]);

				foreach ($result_3 as $key => $value) {
					foreach ($uniq_desc as $k => $udesc) {
						if ($itm == $value['itemcode'] && $value['description'] == $udesc) {

							$db_qty_merge[$itm] = $db_qty_sum += $value['qty'];
							$code_item = $value['itemcode'];
						}
					}
				}

				$db_qty_sum 		= 0;
				$db_qty_pm_sum 	 	= 0;
				$db_qty_alta_sum 	= 0;
				$db_qty_asc_sum  	= 0;
				$db_qty_talibon_sum = 0;

				foreach ($qty_merge as $key_2 => $qty_exel) {

					if ($itm == $key_2) {

						@$vrince[$itm] = $db_qty_merge[$itm] - $qty_exel;
					}
				}

				foreach ($result_3 as $k =>  $value) {
					if ($code_item == $value['itemcode']) {
						$icm_bunit = $value['business_unit'];
						$icm_code   = $value['itemcode'];

						$yrdata = strtotime($value['datetime_scanned']);
						$as_of =  date('M Y', $yrdata);
						//var_dump($as_of);	
						$datass = array(
							'user_id'	=> $user_id,
							'loc_id'		=> $location_id,
							'itemcode' 		=> $value['itemcode'],
							'barcode'		=> $value['barcode'],
							'description' 	=> $value['description'],
							'uom'			=> $value['uom'],
							'qty_db'		=> $db_qty_merge[$code_item],
							'qty_excel'		=> @$qty_merge[$value['itemcode']],
							'business_unit'	=> $icm_bunit,
							'department'	=> $value['department'],
							'section'		=> $value['section'],
							'empno'			=> $value['empno'],
							'variance'		=> @$vrince[$value['itemcode']],
							'date'			=> $as_of
						);
						$result_4 = $this->AdminModel->insert_cyclic_variance($datass, $user_id, $location_id, $value['itemcode'], $value['barcode']);
					}
				}
			}
		}
		if (@$result_4 == true) {
			echo "succes";
		} else {
			echo "no match data ";
		}
		//}		
		//}	
		//}
	}

	public function upload_cyclic()
	{
		$company = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company'))))));
		$bunit = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit'))))));
		$dept = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept'))))));
		$section = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section'))))));

		$date_from = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_from')))));
		$date_to = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_to')))));

		// Declare an empty array
		$date_range = array();

		// Use strtotime function
		$from_date = strtotime($date_from);
		$to_date = strtotime($date_to);

		// Use for loop to store dates into array
		// 86400 sec = 24 hrs = 60*60*24 = 1 day
		for ($currentDate = $from_date; $currentDate <= $to_date; $currentDate += (86400)) {
			$store = date('Y-m-d', $currentDate);
			$date_range[] = $store;
		}

		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '8000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$user_id = $this->session->userdata('user_id');

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		$file_locate = array('user_id' => $user_id, 'filename' => $exelfile, 'company' => $company[1], 'department' => $dept[3]);

		$result_1 = $this->AdminModel->insert_cyclic_location($file_locate, $company[1], $dept[3]);
		$result_2 = $this->AdminModel->get_cyclic_locid($company[1], $dept[3]);

		foreach ($result_2 as $key => $value) {
			$location_id = $value->cyclic_id;
		}

		// if($result_1 == true){
		// 	echo "file name and location inserted  ";
		// }else{
		// 	echo "Upload.  ";
		// }

		$req = is_file(FCPATH . "assets/images/" . $exelfile);
		if ($req == true) {
			echo 'file already exist, please upload other file name.';
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();
				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());

				///////////////////////////////////EXCEL START/////////////////////////////////////////////////////////////////////////////////////////////

				$xldata = FCPATH . "assets/images/" . $exelfile;

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				//if ($highestColumn != 'M') {
				//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
				//echo "Error in highest columns please recheck the excel file if the highestColumn is equal to J ";
				//}else{

				$item_codes			= array();
				$barcode_nos		= array();
				$descriptions		= array();
				$uoms				= array();
				$qtys				= array();
				$bunits				= array();
				$depts 				= array();
				$sections			= array();
				$rack_descs			= array();
				$empnos				= array();
				$datetimes_scanned 	= array();
				$datetimes_saved	= array();
				$datetimes_exported	= array();

				$item_codess 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('A2:A' . $highestRow);
				$bar_codess 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('B2:B' . $highestRow);
				$descriptionss 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('C2:C' . $highestRow);
				$uomss 			 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('D2:D' . $highestRow);
				//$business_unitss = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('F2:F'.$highestRow);

				$its 	 = [];
				$bcodes  = [];
				$desc 	 = [];
				$um 	 = [];
				$_bunits = [];

				foreach ($bar_codess as $br_code) {
					$bcodes[] = $br_code[0];
				}

				foreach ($item_codess as $ite) {
					$its[] = $ite[0];
				}

				foreach ($descriptionss as $_desc) {
					$desc[] = $_desc[0];
				}

				foreach ($uomss as $_uomss) {
					$um[] = $_uomss[0];
				}

				// foreach($business_unitss as $_bunit){
				// 	$_bunits[] = $_bunit[0];
				// }

				$uniq_item_codes 	= array_values(array_unique($its));
				$uniq_brcode 	 	= array_values(array_unique($bcodes));
				$uniq_desc 		 	= array_values(array_unique($desc));
				$uniq_um 			= array_values(array_unique($um));
				//$uniq_bunits		= array_values(array_unique($_bunits));

				$qty_sum 			= 0.00;
				$qty_merge 			= [];
				$qty_pm_sum 		= 0.00;
				$qty_pm				= [];

				$db_qty_sum 		= 0.00;
				$db_qty_merge 		= [];
				$db_qty_pm_sum 		= 0.00;
				$db_qty_pm 			= [];

				$qty_alta 			= [];
				$qty_alta_sum 		= 0.00;
				$db_qty_alta		= [];
				$db_qty_alta_sum	= 0.00;

				$qty_asc 			= [];
				$qty_asc_sum		= 0.00;
				$db_qty_asc			= [];
				$db_qty_asc_sum 	= 0.00;

				$qty_talibon		= [];
				$qty_talibon_sum	= 0.00;
				$db_qty_talibon		= [];
				$db_qty_talibon_sum = 0.00;

				$vrince 			= [];
				$pm_variance		= [];
				$alta_variance		= [];
				$asc_variance	 	= [];
				$talibon_variance	= [];
				$saved_date 		= [];

				foreach ($uniq_item_codes as $key_code => $itmcode) {

					$date_saved = $this->AdminModel->pcount_data($itmcode, @$uniq_brcode[$key_code]);

					foreach ($date_saved as $key => $date_val) {
						$dateonly = explode(" ", $date_val['datetime_scanned']);
						$saved_date[] = $dateonly[0];
					}
				}

				$range_date = array_values(array_intersect($date_range, $saved_date));

				foreach ($uniq_item_codes as $index => $itm) {

					for ($i = 2; $i <= $highestRow; $i++) {

						$item_code     		=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
						$barcode_no     	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
						$description     	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
						$uom     			=   $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
						$qty       			=   $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
						$bunit       		=   $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
						$dept       		=   $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
						$section       		=   $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
						$rack_desc       	=   $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
						$empno       		=   $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
						$datetime_scanned  	=   $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
						$datetime_saved    	=   $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
						$datetime_exported 	=   $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();

						$date_time_scanned 	= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_scanned)->format('Y-m-d');
						$date_time_saved 	= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_saved)->format('Y-m-d');
						$date_time_exported = PHPExcel_Shared_Date::ExcelToPHPObject($datetime_exported)->format('Y-m-d');

						array_push($item_codes, $item_code);
						array_push($barcode_nos, $barcode_no);
						array_push($descriptions, $description);
						array_push($uoms, $uom);
						array_push($qtys, $qty);
						array_push($bunits, $bunit);
						array_push($depts, $dept);
						array_push($sections, $section);
						array_push($rack_descs, $rack_desc);
						array_push($empnos, $empno);
						array_push($datetimes_scanned, $date_time_scanned);
						array_push($datetimes_saved, $date_time_saved);
						array_push($datetimes_exported, $date_time_exported);

						if ($item_code == $itm) {
							$qty_merge[$item_code] = $qty_sum += $qty;
							$bunit_icm = $bunit;
						}
					}

					$qty_sum = 0;
					$qty_pm_sum = 0;
					$qty_alta_sum = 0;
					$qty_asc_sum = 0;
					$qty_talibon_sum  = 0;

					foreach ($range_date as $selected_dates) {

						$result_3 = $this->AdminModel->pcount_items($itm, $selected_dates, @$uniq_brcode[$index]);

						foreach ($result_3 as $key => $value) {
							foreach ($uniq_desc as $k => $udesc) {
								if ($itm == $value['itemcode'] && $value['description'] == $udesc) {

									$db_qty_merge[$itm] = $db_qty_sum += $value['qty'];
									$code_item = $value['itemcode'];
								}
							}
						}
						$db_qty_sum 		= 0;
						$db_qty_pm_sum 	 	= 0;
						$db_qty_alta_sum 	= 0;
						$db_qty_asc_sum  	= 0;
						$db_qty_talibon_sum = 0;

						foreach ($qty_merge as $key_2 => $qty_exel) {

							if ($itm == $key_2) {

								@$vrince[$itm] = $db_qty_merge[$itm] - $qty_exel;
							}
						}

						foreach ($result_3 as $k =>  $value) {
							if ($code_item == $value['itemcode']) {
								$icm_bunit = $value['business_unit'];
								$icm_code   = $value['itemcode'];

								$yrdata = strtotime($value['datetime_scanned']);
								$as_of =  date('M Y', $yrdata);
								//var_dump($as_of);	
								$datass = array(
									'user_id'	=> $user_id,
									'loc_id'		=> $location_id,
									'itemcode' 		=> $value['itemcode'],
									'barcode'		=> $value['barcode'],
									'description' 	=> $value['description'],
									'uom'			=> $value['uom'],
									'qty_db'		=> $db_qty_merge[$code_item],
									'qty_excel'		=> @$qty_merge[$value['itemcode']],
									'business_unit'	=> $icm_bunit,
									'department'	=> $value['department'],
									'section'		=> $value['section'],
									'empno'			=> $value['empno'],
									'variance'		=> @$vrince[$value['itemcode']],
									'date'			=> $as_of
								);
								$result_4 = $this->AdminModel->insert_cyclic_variance($datass, $user_id, $location_id, $value['itemcode'], $value['barcode']);
							}
						}
					}
				}
				if (@$result_4 == true) {
					echo "succes";
				} else {
					echo "no match data ";
				}
				//}		
			}
		}
	}

	public function cyclic_report()
	{

		$company = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company')))));
		$bunit = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit')))));
		$dept = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept')))));
		$section = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section')))));

		$result_1 = $this->AdminModel->get_cyclic_id($company, $dept);

		foreach ($result_1 as $key => $value) {
			$location_id = $value['cyclic_id'];
			$filename = $value['filename'];
			$fname 	= explode(".", $filename);
		}
		if (empty($location_id)) {
			echo 'invalid select of location or no lacation selected';
		} else {
			$result = $this->AdminModel->get_cyclic_variance($location_id);
			if ($result == null) {
				echo 'error';
			} else {
				foreach ($result as $key => $value) {

					$data['item_code'][]		= $value['itemcode'];
					$data['description'][] 		= $value['description'];
					$data['uom'][]				= $value['uom'];
					$data['qty_db'][] 			= $value['qty_db'];
					$data['qty_excel'][]		= $value['qty_excel'];
					$data['business_unit'][]	= $value['business_unit'];
					$data['section'][]			= $value['section'];
					$data['variance'][]			= $value['variance'];
					$data['exelfile']			= $fname[0];
				}
				$this->load->view('store_consolidation/pages/cyclic_report.php', $data);
				$this->load->view('store_consolidation/pages/excel_monthly_report.php', $data);
				echo 'PDF file created see on report table';
			}
			foreach ($result_1 as $key => $value) {
				$loc_id = $value['cyclic_id'];
				$file_name = $value['filename'];

				$req = is_file(FCPATH . "assets/images/" . $file_name);

				if ($req == true) {
					unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $file_name);
					$this->AdminModel->empty_cyclic($loc_id);
					$this->AdminModel->empty_cyclic_location($loc_id);
				}
			}
		}
	}

	public function physical_report()
	{

		$company = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company')))));
		$bunit = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit')))));
		$dept = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept')))));
		$section = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section')))));

		$result = $this->AdminModel->physical_count_data($bunit, $dept, $section);
		if ($result == null) {
			echo 'error';
		} else {
			foreach ($result as $key => $value) {
				//var_dump($value['business_unit']);
				$data['item_code'][]		= $value['itemcode'];
				$data['description'][] 		= $value['description'];
				$data['uom'][]				= $value['uom'];
				$data['qty_db'][] 			= $value['qty'];
				//$data['qty_excel'][]		= $value['qty_excel'];
				$data['business_unit'][]	= $value['business_unit'];
				$data['section'][]			= $value['section'];
				//$data['variance'][]		= $value['variance'];
				//$data['exelfile']			= $fname[0];

			}
			$this->load->view('store_consolidation/pages/cyclic_report.php', $data);
			//$this->load->view('store_consolidation/pages/excel_monthly_report.php', $data);
			echo 'PDF file created see on report table';
		}

		//$req = is_file(FCPATH."assets/images/".$filename);

		//if($req == true){
		//unlink($_SERVER['DOCUMENT_ROOT']."/pcount/assets/images/".$filename);
		//$this->AdminModel->empty_cyclic($location_id);
		//$this->AdminModel->empty_cyclic_location($location_id);
		//}

	}


	public function pcount()
	{
		$company = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company'))))));
		//$bunit = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit'))))));
		$dept = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept'))))));
		//$section = explode("/", $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section'))))));

		$date_from = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_from')))));
		$date_to = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('date_to')))));

		// Declare an empty array
		$date_range = array();

		// Use strtotime function
		$from_date = strtotime($date_from);
		$to_date = strtotime($date_to);

		// Use for loop to store dates into array
		// 86400 sec = 24 hrs = 60*60*24 = 1 day
		for ($currentDate = $from_date; $currentDate <= $to_date; $currentDate += (86400)) {
			$store = date('Y-m-d', $currentDate);
			$date_range[] = $store;
		}

		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '8000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$user_id = $this->session->userdata('user_id');

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		$file_locate = array('user_id' => $user_id, 'filename' => $exelfile, 'company' => $company[1], 'department' => $dept[2]);

		$result_1 = $this->AdminModel->insert_cyclic_location($file_locate, $company[1], $dept[2]);
		$result_2 = $this->AdminModel->get_cyclic_locid($company[1], $dept[2]);

		foreach ($result_2 as $key => $value) {
			$location_id = $value->cyclic_id;
		}

		// if($result_1 == true){
		// 	echo "file name and location inserted  ";
		// }else{
		// 	echo "Upload.  ";
		// }

		$req = is_file(FCPATH . "assets/images/" . $exelfile);
		if ($req == true) {
			echo 'file already exist, please upload other file name.';
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();
				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());

				///////////////////////////////////EXCEL START/////////////////////////////////////////////////////////////////////////////////////////////

				$xldata = FCPATH . "assets/images/" . $exelfile;

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				if ($highestColumn != 'M') {
					//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
					echo "Error in highest columns please recheck the excel file if the highestColumn is equal to M ";
				} else {

					$item_codes			= array();
					$barcode_nos		= array();
					$descriptions		= array();
					$uoms				= array();
					$qtys				= array();
					$bunits				= array();
					$depts 				= array();
					$sections			= array();
					$rack_descs			= array();
					$empnos				= array();
					$datetimes_scanned 	= array();
					$datetimes_saved	= array();
					$datetimes_exported	= array();

					$item_codess 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('A2:A' . $highestRow);
					$bar_codess 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('B2:B' . $highestRow);
					$descriptionss 	 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('C2:C' . $highestRow);
					$uomss 			 = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('D2:D' . $highestRow);
					$business_unitss = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('F2:F' . $highestRow);

					$its 	 = [];
					$bcodes  = [];
					$desc 	 = [];
					$um 	 = [];
					$_bunits = [];

					foreach ($bar_codess as $br_code) {
						$bcodes[] = $br_code[0];
					}

					foreach ($item_codess as $ite) {
						$its[] = $ite[0];
					}

					foreach ($descriptionss as $_desc) {
						$desc[] = $_desc[0];
					}

					foreach ($uomss as $_uomss) {
						$um[] = $_uomss[0];
					}

					foreach ($business_unitss as $_bunit) {
						$_bunits[] = $_bunit[0];
					}

					$uniq_item_codes 	= array_values(array_unique($its));
					$uniq_brcode 	 	= array_values(array_unique($bcodes));
					$uniq_desc 		 	= array_values(array_unique($desc));
					$uniq_um 			= array_values(array_unique($um));
					$uniq_bunits		= array_values(array_unique($_bunits));

					$qty_sum 			= 0.00;
					$qty_merge 			= [];
					$qty_pm_sum 		= 0.00;
					$qty_pm				= [];

					$db_qty_sum 		= 0.00;
					$db_qty_merge 		= [];
					$db_qty_pm_sum 		= 0.00;
					$db_qty_pm 			= [];

					$qty_alta 			= [];
					$qty_alta_sum 		= 0.00;
					$db_qty_alta		= [];
					$db_qty_alta_sum	= 0.00;

					$qty_asc 			= [];
					$qty_asc_sum		= 0.00;
					$db_qty_asc			= [];
					$db_qty_asc_sum 	= 0.00;

					$qty_talibon		= [];
					$qty_talibon_sum	= 0.00;
					$db_qty_talibon		= [];
					$db_qty_talibon_sum = 0.00;

					$vrince 			= [];
					$pm_variance		= [];
					$alta_variance		= [];
					$asc_variance	 	= [];
					$talibon_variance	= [];
					$saved_date 		= [];

					foreach ($uniq_item_codes as $key_code => $itmcode) {
						//var_dump($uniq_brcode[$key_code]);
						$date_saved = $this->AdminModel->pcount_data($itmcode, @$uniq_brcode[$key_code]);

						foreach ($date_saved as $key => $date_val) {
							$dateonly = explode(" ", $date_val['datetime_scanned']);
							$saved_date[] = $dateonly[0];
						}
					}

					$range_date = array_values(array_intersect($date_range, $saved_date));

					foreach ($uniq_item_codes as $index => $itm) {

						for ($i = 2; $i <= $highestRow; $i++) {

							$item_code     		=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
							$barcode_no     	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
							$description     	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
							$uom     			=   $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
							$qty       			=   $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
							$bunit       		=   $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
							$dept       		=   $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
							$section       		=   $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
							$rack_desc       	=   $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
							$empno       		=   $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
							$datetime_scanned  	=   $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
							$datetime_saved    	=   $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
							$datetime_exported 	=   $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();

							$date_time_scanned 	= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_scanned)->format('Y-m-d');
							$date_time_saved 	= PHPExcel_Shared_Date::ExcelToPHPObject($datetime_saved)->format('Y-m-d');
							$date_time_exported = PHPExcel_Shared_Date::ExcelToPHPObject($datetime_exported)->format('Y-m-d');

							array_push($item_codes, $item_code);
							array_push($barcode_nos, $barcode_no);
							array_push($descriptions, $description);
							array_push($uoms, $uom);
							array_push($qtys, $qty);
							array_push($bunits, $bunit);
							array_push($depts, $dept);
							array_push($sections, $section);
							array_push($rack_descs, $rack_desc);
							array_push($empnos, $empno);
							array_push($datetimes_scanned, $date_time_scanned);
							array_push($datetimes_saved, $date_time_saved);
							array_push($datetimes_exported, $date_time_exported);

							if ($item_code == $itm  && $bunit == 'ISLAND CITY MALL') {
								$qty_merge[$item_code] = $qty_sum += $qty;
								$bunit_icm = $bunit;
							}
							if ($item_code == $itm  && $bunit == 'PLAZA MARCELA') {
								$qty_pm[$item_code] = $qty_pm_sum += $qty;
								$bunit_pm = $bunit;
							}
							if ($item_code == $itm  && $bunit == 'ALTA CITA') {
								$qty_alta[$item_code] = $qty_alta_sum += $qty;
							}
							if ($item_code == $itm  && $bunit == 'ASC') {
								$qty_asc[$item_code] = $qty_asc_sum += $qty;
							}
							if ($item_code == $itm  && $bunit == 'TALIBON') {
								$qty_talibon[$item_code] = $qty_talibon_sum += $qty;
							}
						}

						$qty_sum = 0;
						$qty_pm_sum = 0;
						$qty_alta_sum = 0;
						$qty_asc_sum = 0;
						$qty_talibon_sum  = 0;

						foreach ($range_date as $selected_dates) {

							$result_3 = $this->AdminModel->pcount_items($itm, $selected_dates, @$uniq_brcode[$index]);

							foreach ($result_3 as $key => $value) {
								foreach ($uniq_desc as $k => $udesc) {
									if ($itm == $value['itemcode'] && $value['description'] == $udesc && $value['business_unit'] == 'ISLAND CITY MALL') {
										$db_qty_merge[$itm] = $db_qty_sum += $value['qty'];
										$code_item = $value['itemcode'];
									} elseif ($itm == $value['itemcode']  && $value['description'] == $udesc) {
										$db_qty_merge[$itm] = $db_qty_sum += $value['qty'];
										$code_item = $value['itemcode'];
									}

									if (
										$itm == $value['itemcode'] && $value['description'] == $udesc && $value['business_unit']
										== 'PLAZA MARCELA'
									) {
										$db_qty_pm[$itm] = $db_qty_pm_sum += $value['qty'];
										$code_pm = $value['itemcode'];
									} elseif ($itm == $value['itemcode']  && $value['description'] == $udesc) {
										$db_qty_pm[$itm] = $db_qty_pm_sum += $value['qty'];
										$code_pm = $value['itemcode'];
									}

									if ($itm == $value['itemcode'] && $value['description'] == $udesc && $value['business_unit'] == 'ALTA CITA') {
										$db_qty_alta[$itm] = $db_qty_alta_sum += $value['qty'];
										$alta_code = $value['itemcode'];
									}

									if ($itm == $value['itemcode'] && $value['description'] == $udesc && $value['business_unit'] == 'ASC') {
										$db_qty_asc[$itm] = $db_qty_asc_sum += $value['qty'];
										$code_asc = $value['itemcode'];
									}

									if (
										$itm == $value['itemcode'] && $value['description'] == $udesc && $value['business_unit'] ==
										'TALIBON'
									) {
										$db_qty_talibon[$itm] = $db_qty_talibon_sum += $value['qty'];
										$code_tal = $value['itemcode'];
									}
								}
							}
							$db_qty_sum 		= 0;
							$db_qty_pm_sum 	 	= 0;
							$db_qty_alta_sum 	= 0;
							$db_qty_asc_sum  	= 0;
							$db_qty_talibon_sum = 0;

							foreach ($qty_merge as $key_2 => $qty_exel) {

								if ($itm == $key_2) {
									$vrince[$itm] = $db_qty_merge[$itm] - $qty_exel;
								}
							}
							foreach ($qty_pm as $key_pm => $pm) {
								if ($itm == $key_pm) {
									$pm_variance[$itm] = $db_qty_pm[$itm] - $pm;
								}
							}
							foreach ($qty_alta as $key_alta => $alta) {
								if ($itm == $key_alta) {
									$alta_variance[$itm] = $db_qty_alta[$itm] - $alta;
								}
							}
							foreach ($qty_asc as $key_asc => $asc) {
								if ($itm == $key_asc) {
									$asc_variance[$itm] = $db_qty_asc[$itm] - $asc;
								}
							}
							foreach ($qty_talibon as $key_tal => $talibon) {
								if ($itm == $key_tal) {
									$talibon_variance[$itm] = $db_qty_talibon[$itm] - $talibon;
								}
							}

							foreach ($result_3 as $k =>  $value) {
								if ($itm == $value['itemcode'] && $value['business_unit'] == 'ISLAND CITY MALL') {
									$icm_bunit = $value['business_unit'];
									$icm_code   = $value['itemcode'];

									$datass = array(
										'user_id'	=> $user_id,
										'loc_id'		=> $location_id,
										'itemcode' 		=> $value['itemcode'],
										'barcode'		=> $value['barcode'],
										'description' 	=> $value['description'],
										'uom'			=> $value['uom'],
										'qty_db'		=> $db_qty_merge[$code_item],
										'qty_excel'		=> @$qty_merge[$value['itemcode']],
										'business_unit'	=> $icm_bunit,
										'department'	=> $value['department'],
										'section'		=> $value['section'],
										'empno'			=> $value['empno'],
										'variance'		=> @$vrince[$value['itemcode']]
									);
									$result_4 = $this->AdminModel->insert_cyclic_variance($datass, $user_id, $location_id, $value['itemcode'], $value['barcode']);
								}

								if ($itm == $value['itemcode'] && $value['business_unit'] == 'PLAZA MARCELA') {

									$pm_bunit = $value['business_unit'];
									$pm_code   = $value['itemcode'];

									$pm = array(
										'user_id'	=> $user_id,
										'loc_id'		=> $location_id,
										'itemcode' 		=> $value['itemcode'],
										'barcode'		=> $value['barcode'],
										'description' 	=> $value['description'],
										'uom'			=> $value['uom'],
										'qty_pm'		=> $db_qty_pm[$itm],
										'qty_excel'		=> @$qty_pm[$itm],
										'business_unit'	=> $pm_bunit,
										'department'	=> $value['department'],
										'section'		=> $value['section'],
										'empno'			=> $value['empno'],
										'variance'		=> @$pm_variance[$value['itemcode']]
									);

									$result_pm = $this->AdminModel->insert_cyclic_pm($pm, $user_id, $location_id, $value['itemcode'], $value['barcode']);
								}

								if ($itm == 'ALTA CITA' && $value['itemcode'] == $value['itemcode']) {

									$pm_bunit = $value['business_unit'];
									$alta_code   = $value['itemcode'];

									$alta = array(
										'user_id'	=> $user_id,
										'loc_id'		=> $location_id,
										'itemcode' 		=> $value['itemcode'],
										'barcode'		=> $value['barcode'],
										'description' 	=> $value['description'],
										'uom'			=> $value['uom'],
										'qty_alta'		=> $db_qty_alta[$value['itemcode']],
										'qty_excel'		=> @$qty_alta[$value['itemcode']],
										'business_unit'	=> $value['business_unit'],
										'department'	=> $value['department'],
										'section'		=> $value['section'],
										'empno'			=> $value['empno'],
										'variance'		=> @$alta_variance[$value['itemcode']]
									);

									$result_alta = $this->AdminModel->insert_qty_alta($alta, $user_id, $location_id, $value['itemcode'], $value['barcode']);
								}

								if ($itm == $value['itemcode'] && $value['business_unit'] == 'ASC') {

									$pm_bunit = $value['business_unit'];
									$pm_code   = $value['itemcode'];

									$asc = array(
										'user_id'	=> $user_id,
										'loc_id'		=> $location_id,
										'itemcode' 		=> $value['itemcode'],
										'barcode'		=> $value['barcode'],
										'description' 	=> $value['description'],
										'uom'			=> $value['uom'],
										'qty_asc'		=> $db_qty_asc[$value['itemcode']],
										'qty_excel'		=> @$qty_asc[$value['itemcode']],
										'business_unit'	=> $value['business_unit'],
										'department'	=> $value['department'],
										'section'		=> $value['section'],
										'empno'			=> $value['empno'],
										'variance'		=> @$asc_variance[$value['itemcode']]
									);
									$result_asc = $this->AdminModel->insert_qty_asc($asc, $user_id, $location_id, $value['itemcode'], $value['barcode']);
								}

								if ($itm == $value['itemcode'] && $value['business_unit'] == 'TALIBON') {

									$pm_bunit = $value['business_unit'];
									$pm_code   = $value['itemcode'];

									$talibon = array(
										'user_id'	=> $user_id,
										'loc_id'		=> $location_id,
										'itemcode' 		=> $value['itemcode'],
										'barcode'		=> $value['barcode'],
										'description' 	=> $value['description'],
										'uom'			=> $value['uom'],
										'qty_talibon'	=> $db_qty_talibon[$value['itemcode']],
										'qty_excel'		=> @$qty_talibon[$value['itemcode']],
										'business_unit'	=> $value['business_unit'],
										'department'	=> $value['department'],
										'section'		=> $value['section'],
										'empno'			=> $value['empno'],
										'variance'		=> @$talibon_variance[$value['itemcode']]
									);
									$result_talibon = $this->AdminModel->insert_qty_talibon($talibon, $user_id, $location_id, $value['itemcode'], $value['barcode']);
								}
							}
						}
					}
					if (@$result_4 == true || @$result_pm == true || @$result_alta == true || @$result_asc == true || @$result_talibon == true) {
						echo "succes";
					} else {
						echo "something went wrong";
					}
				}
			}
		}
	}

	public function pcount_report()
	{

		$company = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company')))));
		//$bunit = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit')))));
		$dept = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept')))));
		//$section = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section')))));	

		$result_1 = $this->AdminModel->get_cyclic_id($company, $dept);

		$icm_item_code 	= [];
		$icm_desc	   	= [];
		$icm_uom	   	= [];
		$icm_qty_db	   	= [];
		$icm_excel	   	= [];
		$icm_bunit	   	= [];
		$icm_dept	   	= [];
		$icm_variance  	= [];

		$pm_item_code	= [];
		$pm_desc	   	= [];
		$pm_uom	   		= [];
		$pm_qty_db	   	= [];
		$pm_excel	   	= [];
		$pm_bunit	   	= [];
		$pm_dept	   	= [];
		$pm_variance  	= [];

		// $db_qty_alta	= [];
		// $db_qty_asc		= [];
		// $db_qty_talibon	= [];

		foreach ($result_1 as $key => $value) {
			$location_id[] = $value['cyclic_id'];
			//$filename = $value['filename']; 
			//$fname 	= explode(".", $filename);

		}

		if (empty($location_id)) {
			echo 'invalid select of location or no lacation selected';
		} else {
			//var_dump($location_id);
			foreach ($location_id as $k => $locate_id) {
				//var_dump($locate_id);
				$result = $this->AdminModel->get_cyclic_variance($locate_id);
				$result_pm = $this->AdminModel->get_variance_pm($locate_id);
				$result_alta = $this->AdminModel->get_data_alta($locate_id);
				$result_asc = $this->AdminModel->get_data_asc($locate_id);
				$result_talibon = $this->AdminModel->get_data_talibon($locate_id);

				//var_dump($result);
				if ($result == null && $result_pm == null) {
					echo 'no data please upload file';
				} else {
					foreach ($result as $key => $value) {
						//var_dump($value['itemcode']);
						$icm_item_code['item_code'][]	= $value['itemcode'];
						$icm_desc['description'][] 		= $value['description'];
						$icm_uom['uom'][]				= $value['uom'];
						$icm_qty_db['qty_db'][] 		= $value['qty_db'];
						$icm_excel['qty_excel'][]		= $value['qty_excel'];
						$icm_bunit['business_unit'][]	= $value['business_unit'];
						$icm_dept['department'][]		= $value['department'];
						$icm_sect['section'][]			= $value['section'];
						$icm_variance['variance'][]		= $value['variance'];
					}
					foreach ($result_pm as $key => $val_pm) {
						$pm_item_code['itemcode'][] 	 = $val_pm['itemcode'];
						$pm_desc['description'][]		 = $val_pm['description'];
						$pm_uom['uom'][]				 = $val_pm['uom'];
						$pm_qty_db['qty_pm'][] 			 = $val_pm['qty_pm'];
						$pm_excel['qty_excel'][]		 = $val_pm['qty_excel'];
						$pm_bunit['business_unit'][]	 = $val_pm['business_unit'];
						$pm_dept['department'][]		 = $val_pm['department'];
						$pm_sect['section'][]			 = $val_pm['section'];
						$pm_variance['variance'][]		 = $val_pm['variance'];
					}
					foreach ($result_alta as $key => $val_alta) {
						$alta_item_code['itemcode'][] 	 = $val_alta['itemcode'];
						$alta_uom['uom'][]				 = $val_alta['uom'];
						$alta_desc['description'][]		 = $val_alta['description'];
						$db_qty_alta['qty_alta'][] 		 = $val_alta['qty_alta'];
						$alta_excel['qty_excel'][]		 = $val_alta['qty_excel'];
						$alta_bunit['business_unit'][]	 = $val_alta['business_unit'];
						$alta_dept['department'][]		 = $val_alta['department'];
						$alta_sect['section'][]			 = $val_alta['section'];
						$alta_variance['variance'][]	 = $val_alta['variance'];
					}
					foreach ($result_asc as $key => $val_asc) {
						$asc_item_code['itemcode'][] 	 = $val_asc['itemcode'];
						$asc_uom['uom'][]				 = $val_asc['uom'];
						$asc_desc['description'][]		 = $val_asc['description'];
						$db_qty_asc['qty_asc'][] 		 = $val_asc['qty_asc'];
						$asc_excel['qty_excel'][]		 = $val_asc['qty_excel'];
						$asc_bunit['business_unit'][]	 = $val_asc['business_unit'];
						$asc_dept['department'][]		 = $val_asc['department'];
						$asc_sect['section'][]			 = $val_asc['section'];
						$asc_variance['variance'][]		 = $val_asc['variance'];
					}
					foreach ($result_talibon as $key => $val_talibon) {
						$talibon_item_code['itemcode'][] 	= $val_talibon['itemcode'];
						$talibon_uom['uom'][]				= $val_talibon['uom'];
						$talibon_desc['description'][]	 	= $val_talibon['description'];
						$db_qty_talibon['qty_talibon'][] 	= $val_talibon['qty_talibon'];
						$talibon_excel['qty_excel'][]		= $val_talibon['qty_excel'];
						$talibon_bunit['business_unit'][]	= $val_talibon['business_unit'];
						$talibon_dept['department'][]		= $val_talibon['department'];
						$talibon_sect['section'][]			= $val_talibon['section'];
						$talibon_variance['variance'][]		= $val_talibon['variance'];
					}

					$data['item_code']			= @array_values(array_merge(@$icm_item_code['item_code']));
					$data['pm_itemcode']		= @array_values(array_merge(@$pm_item_code['itemcode']));
					$data['alta_itemcode']		= @array_values(array_merge(@$alta_item_code['itemcode']));
					$data['asc_itemcode']		= @array_values(array_merge(@$asc_item_code['itemcode']));
					$data['talibon_itemcode']	= @array_values(array_merge(@$talibon_item_code['itemcode']));

					$data['description'] 		 = @array_values(array_merge(@$icm_desc['description']));
					$data['pm_description']		 = @array_values(array_merge(@$pm_desc['description']));
					$data['alta_description']	 = @array_values(array_merge(@$alta_desc['description']));
					$data['asc_description']	 = @array_values(array_merge(@$asc_desc['description']));
					$data['talibon_description'] = @array_values(array_merge(@$talibon_desc['description']));

					$data['uom']				= @array_values(array_merge(@$icm_uom['uom']));
					$data['pm_uom']				= @array_values(array_merge(@$pm_uom['uom']));
					$data['alta_uom']			= @array_values(array_merge(@$alta_uom['uom']));
					$data['asc_uom']			= @array_values(array_merge(@$asc_uom['uom']));
					$data['talibon_uom']		= @array_values(array_merge(@$talibon_uom['uom']));

					$data['qty_db'] 			= @array_values(array_merge(@$icm_qty_db['qty_db']));
					$data['qty_pm'] 			= @array_values(array_merge(@$pm_qty_db['qty_pm']));
					$data['qty_alta'] 			= @array_values(array_merge(@$db_qty_alta['qty_alta']));
					$data['qty_asc'] 			= @array_values(array_merge(@$db_qty_asc['qty_asc']));
					$data['qty_talibon'] 		= @array_values(array_merge(@$db_qty_talibon['qty_talibon']));

					$data['vr_icm']				= @array_values(array_merge(@$icm_variance['variance']));
					$data['vr_pm']				= @array_values(array_merge(@$pm_variance['variance']));
					$data['vr_alta']			= @array_values(array_merge(@$alta_variance['variance']));
					$data['vr_asc']				= @array_values(array_merge(@$asc_variance['variance']));
					$data['vr_talibon']			= @array_values(array_merge(@$talibon_variance['variance']));

					$data['excel_icm']			= @array_values(array_merge(@$icm_excel['qty_excel']));
					$data['excel_pm']			= @array_values(array_merge(@$pm_excel['qty_excel']));
					$data['excel_alta']			= @array_values(array_merge(@$alta_excel['qty_excel']));
					$data['excel_asc']			= @array_values(array_merge(@$asc_excel['qty_excel']));
					$data['excel_talibon']		= @array_values(array_merge(@$talibon_excel['qty_excel']));

					$data['icm_section']		= @array_values(array_merge(@$icm_sect['section']));
					$data['pm_section']			= @array_values(array_merge(@$pm_sect['section']));
					$data['alta_section']		= @array_values(array_merge(@$alta_sect['section']));
					$data['asc_section']		= @array_values(array_merge(@$asc_sect['section']));
					$data['talibon_section']	= @array_values(array_merge(@$talibon_sect['section']));

					//$data['qty_excel']		= $icm_excel['qty_excel'];
					//$data['business_unit']	= $icm_bunit['business_unit'];
					//$data['department']		= $icm_dept['department'];
					//$data['variance']			= $icm_variance['variance'];

					foreach ($result_1 as $key_ => $val) {

						$filename = $val['filename'];
						$fname 	= explode(".", $filename);

						$data['exelfile'] = explode(" ", $fname[0]);
					}
					$data['user']	= $this->session->userdata('user_name');
				}
			}
			$this->load->view('store_consolidation/pages/pcount_report.php', $data);
			//$this->load->view('store_consolidation/pages/variance_report.php', $data);
			echo 'PDF file created see on report table';

			foreach ($result_1 as $_key => $file) {
				$loc_id = $file['cyclic_id'];
				$filename = $file['filename'];
				$req = is_file(FCPATH . "assets/images/" . $filename);
				if ($req == true) {
					unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $filename);
					$this->AdminModel->empty_cyclic($loc_id);
					$this->AdminModel->empty_cyclic_location($loc_id);
					$this->AdminModel->delete_pm($loc_id);
					$this->AdminModel->delete_datavar($loc_id);
					$this->AdminModel->delete_alta($loc_id);
					$this->AdminModel->delete_asc($loc_id);
					$this->AdminModel->delete_talibon($loc_id);
				}
			}
		}
	}

	public function report_monthly()
	{
		$company = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('company')))));
		//$bunit = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('bunit')))));
		$dept = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('dept')))));
		//$section = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('section')))));
		$user_id = $this->session->userdata('user_id');
		$result_2 = $this->AdminModel->get_loc_id($company, $dept);

		foreach ($result_2 as $key => $value) {
			$location_id = $value['loc_id']; //var_dump($$value->loc_id);
			$filename = $value['file_name'];
			$fname 	= explode(".", $filename);
		}
		if (empty($location_id)) {
			echo 'invalid select of location or no file to locate, upload first';
		} else {
			$result = $this->AdminModel->get_items($location_id, $user_id);

			if ($result == null) {
				echo 'error';
			} else {
				foreach ($result as $key => $value) {

					$data['item_code'][]			= $value['item_code'];
					$data['variant_code'][] 		= $value['variant_code'];
					$data['description'][] 			= $value['description'];
					$data['uom'][]					= $value['uom'];
					$data['qty'][] 					= $value['qty'];
					$data['cost_novat'][] 			= $value['cost_novat'];
					$data['totalcost_novat'][] 		= $value['totalcost_novat'];
					$data['cost_withvat'][]			= $value['cost_withvat'];
					$data['totalcost_withvat'][] 	= $value['totalcost_withvat'];
					$data['divcode'][]				= $value['divcode'];
					$data['exelfile']				= $fname[0];
				}
				$this->load->view('store_consolidation/pages/store_conso_report.php', $data);
				//$this->load->view('store_consolidation/pages/excel_monthly_report.php', $data);

				echo 'PDF file created see on report table';
			}
			$req = is_file(FCPATH . "assets/images/" . $filename);

			if ($req == true) {
				unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $filename);
				$response = $this->AdminModel->empty_datatable($location_id);
				$this->AdminModel->empty_location($location_id);
			}
		}
	}

	public function btn_report_monthly()
	{
		$loc_id = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('loc_id')))));
		$user_id = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('user_id')))));

		$result_2 = $this->AdminModel->get_loc_id($company, $bunit, $dept, $section);

		foreach ($result_2 as $key => $value) {
			$location_id = $value->loc_id;
			var_dump($value->loc_id);
			$filename = $value->file_name;
			$fname 	= explode(".", $filename);
		}
		if (empty($location_id)) {
			echo 'invalid select of location or no lacation selected';
		} else {
			$result = $this->AdminModel->get_items($location_id);

			if (empty($result)) {
				echo 'invalid location id';
			} else {
				foreach ($result as $key => $value) {

					$data['item_code'][]			= $value['item_code'];
					$data['variant_code'][] 		= $value['variant_code'];
					$data['description'][] 			= $value['description'];
					$data['uom'][]					= $value['uom'];
					$data['qty'][] 					= $value['qty'];
					$data['cost_novat'][] 			= $value['cost_novat'];
					$data['totalcost_novat'][] 		= $value['totalcost_novat'];
					$data['cost_withvat'][]			= $value['cost_withvat'];
					$data['totalcost_withvat'][] 	= $value['totalcost_withvat'];
					$data['divcode'][]				= $value['divcode'];
					$data['exelfile']				= $fname[0];
				}
				//$this->load->view('store_consolidation/pages/store_conso_report.php', $data);

				echo 'PDF file created see on report table';
			}
			$req = is_file(FCPATH . "assets/images/" . $filename);

			if ($req == true) {
				unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $filename);
				//$response = $this->AdminModel->empty_datatable($location_id);
				//$this->AdminModel->empty_location($location_id);
			}
		}
	}

	public function monthly_updated_report()
	{

		$loc_id = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('loc_id')))));
		$user_id = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('user_id')))));
		$file_name = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('file_name')))));
		$fname 	= explode(".", $file_name);
		$result = $this->AdminModel->get_items($loc_id, $user_id);

		if ($result == null) {
			echo 'error';
		} else {
			foreach ($result as $key => $value) {

				$data['item_code'][]			= $value['item_code'];
				$data['variant_code'][] 		= $value['variant_code'];
				$data['description'][] 			= $value['description'];
				$data['uom'][]					= $value['uom'];
				$data['qty'][] 					= $value['qty'];
				$data['cost_novat'][] 			= $value['cost_novat'];
				$data['totalcost_novat'][] 		= $value['totalcost_novat'];
				$data['cost_withvat'][]			= $value['cost_withvat'];
				$data['totalcost_withvat'][] 	= $value['totalcost_withvat'];
				$data['divcode'][]				= $value['divcode'];
				$data['exelfile']				= $fname[0];
			}
			$this->load->view('store_consolidation/pages/store_conso_report.php', $data);

			echo 'PDF file created see on report table';
		}
		$req = is_file(FCPATH . "assets/images/" . $file_name);

		if ($req == true) {

			unlink($_SERVER['DOCUMENT_ROOT'] . "/pcount/assets/images/" . $file_name);
			$res  = $this->AdminModel->empty_datatable($loc_id);
			$res_ = $this->AdminModel->empty_location($loc_id);
		}
	}

	public function for_count()
	{
		//$storename = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('store_name')))));
		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '50000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$status = 1;
		$tran_status = 'transacted';

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		$req = is_file(FCPATH . "assets/images/" . $exelfile);

		if ($req == true) {
			echo 'file already exist, please upload a different file name.';
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();
				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());

				///////////////////////////////////EXCEL START////////////////////////////////////////////////////////////////////////////////////

				$item_nos	 	= array();
				$barcode_nos 	= array();
				$descriptions 	= array();
				$uoms		 	= array();
				$qtys		 	= array();
				$dates		 	= array();

				$xldata = FCPATH . "assets/images/" . $exelfile;

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				if ($highestColumn != 'M') {
					//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
					echo "Error in highest columns please recheck the file if the highestColumn is equal to M ";
				} else {

					for ($i = 2; $i <= $highestRow; $i++) {

						$item_no     	       	=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
						$uom    		       	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
						$conversion_qty        	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
						$barcode_no 	   	   	=   $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
						$description 	   	   	=   $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
						$extended_description 	=   $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
						$vendor 			    =   $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
						$vendor_name 	   		=   $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
						$item_division_code 	=   $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
						$item_division_name 	=   $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
						$item_department_code 	=   $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
						$item_department_name 	=   $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();

						//$date   		=	$objWorksheet->getCellByColumnAndRow(5, $i)->getValue();

						// array_push($item_codes, $item_code);
						// array_push($extended_descriptions, $extended_description);
						// array_push($vendor_nos, $vendor_no);

						$data = array(
							'item_no'		=> $item_no,
							'uom'				=> $uom,
							'conversion_qty'	=> $conversion_qty,
							'barcode_no' 		=> $barcode_no,
							'description' 	=> $description,
							'extended_desc'	=> $extended_description,
							'vendor'			=> $vendor,
							'vendor_name'		=> $vendor_name,
							'item_div_code'	=> $item_division_code,
							'item_div_name'	=> $item_division_name,
							'item_dept_code'	=> $item_department_code,
							'item_dept_name'	=> $item_department_name
						);

						$result = $this->AdminModel->for_count($data, $item_no, $barcode_no);
					}
					if ($result == true) {
						echo "success";
					} else {
						echo "data updated";
					}
				}
			}
		}
	}

	public function master_file()
	{
		$storename = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('store_name')))));
		$config['upload_path'] =	 FCPATH . "assets/images/";
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size'] = '50000';
		$config['max_width'] = '1000';
		$config['max_height'] = '1000';
		$status = 1;
		$tran_status = 'transacted';

		$exelfile = $_FILES['exelfile']['name'];
		$filen = explode(".", $exelfile);

		$req = is_file(FCPATH . "assets/images/" . $exelfile);
		//var_dump($req);
		if ($req == true) {
			echo 'file already exist, please upload a different file name.';
			//die(json_encode(["msg"=>"success"]));
		} else {
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if (!$this->upload->do_upload('exelfile')) {
				$error = $this->upload->display_errors();
				echo json_encode($error);
			} else {
				$data = array('upload_data' => $this->upload->data());

				///////////////////////////////////EXCEL START//////////////////////////////////////////////////////////////////////////////////////////////////

				$item_no	= array();
				$barcode_nos = array();
				$show_items = array();
				$description = array();
				$variant_codes = array();
				$uoms		   = array();

				$xldata = FCPATH . "assets/images/" . $exelfile;
				//var_dump($xldata);

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);

				$objPHPExcel        =   $objReader->load($xldata);
				$objWorksheet       =   $objPHPExcel->getActiveSheet();
				$highestRow         =   $objWorksheet->getHighestRow();
				$highestColumn      =   $objWorksheet->getHighestColumn();
				$highestColumnIndex =   PHPExcel_Cell::columnIndexFromString($highestColumn);

				if ($highestColumn != 'C') {
					//$errorMessage.="Error in highest columns please recheck the file if the highestColumn is equal to F ";
					echo "Error in highest columns please recheck the file if the highestColumn is equal to J ";
				} else {

					for ($i = 2; $i <= $highestRow; $i++) {

						$item_no     	=   $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
						$barcode_no    	=   $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
						$show_item     	=   $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
						$description    =	$objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
						$variant_code   =	$objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
						$uom   			=	$objWorksheet->getCellByColumnAndRow(5, $i)->getValue();

						// array_push($item_codes, $item_code);
						// array_push($extended_descriptions, $extended_description);
						// array_push($vendor_nos, $vendor_no);

						// var_dump($item_code);

						//$data = array('item_code'=> $item_code, 'extended_description' => $extended_description, 'vendor_no' => $vendor_no);

						$data = array('item_code' => $item_code, 'barcode_no' => $barcode_no, 'show_item' => $show_item, 'description' => $description, 'variant_code' => $variant_code, 'uom' => $uom);

						//$result = $this->AdminModel->item_master_file( $data);

						$result = $this->AdminModel->barcode_master_file($data);
					}
					if ($result == true) {
						echo "success";
					}
				}
			}
		}
	}
}
