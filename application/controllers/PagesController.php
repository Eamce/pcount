<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PagesController extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('AdminModel');
	}
	public function view($page = 'log_page')
	{
		if($page == 'logOut'){
			$array_data = array('user_name','usertype', 'profile_pic', 'logged_in');
			$s_id = $this->session->userdata('user_id');
			$userstatus = array('user_status' => 0);
			$users_id = array('user_id' => $s_id);
			$this->AdminModel->unset_status($userstatus, $users_id);
			$this->session->unset_userdata($array_data);
			$this->session->sess_destroy();
			redirect('../log_page');
			var_dump(redirect('../log_page'));
		}
		if($this->session->userdata('usertype')){
			//var_dump($page);
			$ins = array('page_route' => $page);
			$data['page_title'] = $page;
			$data['my_heading'] = $this->AdminModel->getData_bs('tbl_pages', $ins);
			$data['company_name'] = $this->AdminModel->companyList();
			$data['user_id'] = $this->session->userdata('user_id');
			$this->load->view('store_consolidation/templates/header', $data);
			$this->load->view('store_consolidation/pages/'.$page, $data);
			$this->load->view('store_consolidation/templates/footer', $data);
			$this->load->view('store_consolidation/actions/'.$page.'_action');
			$this->load->view('store_consolidation/actions/main_action');	
		}

		if($page == 'log_page'){	
			if(isset($_SESSION['logged_in'])){
				?>
					<script>window.history.back();</script>
				<?php
			}
				$data['page_title'] = $page;
				$this->load->view('store_consolidation/pages/'.$page, $data);
				$this->load->view('store_consolidation/actions/'.$page.'_action');
		}
		// else{
		// 	if($this->session->userdata('usertype')=='Admin'|| $this->session->userdata('usertype')=='Admin_2'){
		// 		$ins = array('page_route' => $page);
		// 		$data['page_title'] = $page;
		// 		$data['my_heading'] = $this->AdminModel->getData_bs('tbl_pages', $ins);
		// 		$this->load->view('admin/templates/header', $data);
		// 		$this->load->view('admin/pages/'.$page, $data);
		// 		$this->load->view('admin/templates/footer', $data);
		// 		$this->load->view('admin/actions/'.$page.'_action');
		// 		$this->load->view('admin/actions/main_action');		
		// 	}
		// }			
	}	
	public function validate_login(){
	$username = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('username')))));
	$password = $this->security->xss_clean(trim(addslashes(htmlspecialchars($this->input->post('password')))));
	$ins = array('username' => $username, 'password' => md5($password), 'status' => 1);
	$data = $this->AdminModel->getData_bs('tbl_users', $ins);
		if($data != NULL){
			$user_data = array(
				'user_id' => $data->user_id,
				'user_name' => $data->name,
				'usertype' => $data->usertype,
				'profile_pic' => $data->profile_pic,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($user_data);
			if($this->session->userdata('logged_in')){
				$u_id = $this->session->userdata('user_id');
				$userstatus = array('user_status' => 1);
				$users_id = array('user_id' => $u_id);
				$this->AdminModel->updateuserstatus($users_id, $userstatus);
			}
			if ($data->usertype == 'Admin'){
				echo json_encode('location_setup');			
			}elseif ($data->usertype == 'Admin_2'){
				echo json_encode('approving_officer');			
			}elseif ($data->usertype == 'store_conso'){
				echo json_encode('store_conso');
			}else{
				echo json_encode('invalid');	
			}
		}else{
			echo json_encode('invalid');
		}	
	}
}