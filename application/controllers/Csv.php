<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csv extends CI_Controller {
	public function __construct(){
		parent::__construct();
        // $this->load->model('Setup_model','setup');
	}

    public function get_all_csv_file(){
        $result['data'][] = [ '','','',''];
        echo json_encode($result);
    }

}