<?php
/*
*/
/**
 * 
 */
class ClientLogin extends CI_Controller
{
	
	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('loginModel');  
	}

	function index(){
		$this->session->unset_userdata('logged-in-client');
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('login');
		} else {
			$this->load->view('login-v2');
		}
	}

	function valid_login_auth(){ 

		$data = $this->loginModel->valid_login_auth();
		 
		if ($data['status']=='1') { 
			$this->loginModel->login_logs($data['user']);
			$this->session->set_userdata('logged-in-client',$data['user']);	 
		}
		echo json_encode($data);
	}
	
}