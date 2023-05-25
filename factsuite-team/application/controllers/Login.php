<?php
/*
*/
/**
 * 
 */
class Login extends CI_Controller
{
	
	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('loginModel');  
	  $this->load->model('emailModel'); 
	}

	function index(){
		$this->load->view('login');
	}

		function mail(){

				$client_email_id = strtolower('viral.ce15@gmail.com');
				// Send To User Starts
				$client_email_subject = 'Credentials';

				$client_email_message = '<html><body>';
				$client_email_message .= 'Hello : Test<br>';
				$client_email_message .= 'Your account has been created with factsuite team as client : <br>';
				$client_email_message .= 'Login using below credentials : <br>';
				$client_email_message .= 'Email ID : viral.padvi@gmail.com<br>';
				$client_email_message .= 'Password : 1234567<br>';
				$client_email_message .= 'Thank You,<br>';
				$client_email_message .= 'Team FactSuite Test';
				$client_email_message .= '</html></body>';

				$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$client_email_message);

	}

	function valid_login_auth(){ 

		$data = $this->loginModel->valid_login_auth();
		// print_r($data['user']);
		// exit();
		if ($data['status']=='1') {
			$this->session->set_userdata('logged-in-admin');
			$this->session->unset_userdata('logged-in-analyst');
			$this->session->unset_userdata('logged-in-outputqc');
			$this->session->unset_userdata('logged-in-specialist');
			$this->session->unset_userdata('logged-in-inputqc');
			$this->session->unset_userdata('logged-in-am');
			$this->session->unset_userdata('logged-in-csm');
			$this->session->unset_userdata('logged-in-tech-support');
			$this->session->unset_userdata('logged-in-finance');
			$this->session->unset_userdata('logged-in-insuffanalyst');
			$this->loginModel->login_logs($data['user']);
			if(strtolower($data['user']['role']) == 'admin') {
				$this->session->set_userdata('logged-in-admin',$data['user']);
			} else if(strtolower($data['user']['role']) == 'inputqc') {
				$this->session->set_userdata('logged-in-inputqc',$data['user']);
			} else if(strtolower($data['user']['role']) == 'analyst') {
				$this->session->set_userdata('logged-in-analyst',$data['user']);
			} else if(strtolower($data['user']['role']) == 'insuff analyst' || strtolower($data['user']['role']) == 'insuff specialist') {
				$this->session->set_userdata('logged-in-insuffanalyst',$data['user']);
			} else if(strtolower($data['user']['role']) == 'outputqc') {
				$this->session->set_userdata('logged-in-outputqc',$data['user']);
			} else if(strtolower($data['user']['role']) == 'specialist') {
				$this->session->set_userdata('logged-in-specialist',$data['user']);	
			} else if(strtolower($data['user']['role']) == 'am') {
				$this->session->set_userdata('logged-in-am',$data['user']);	
			} else if(strtolower($data['user']['role']) == 'finance') {
				$this->session->set_userdata('logged-in-finance',$data['user']);
			} else if(strtolower($data['user']['role']) == 'csm') {
				$this->session->set_userdata('logged-in-csm',$data['user']);	
			} else if(strtolower($data['user']['role']) == 'tech support team') {
				$this->session->set_userdata('logged-in-tech-support',$data['user']);
			}else{
				$this->session->set_userdata('logged-in-admin',$data['user']);
			}
		}
		// exit();
		echo json_encode($data);
	}
	
}