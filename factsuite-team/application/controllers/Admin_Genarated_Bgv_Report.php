<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Admin_Genarated_Bgv_Report extends CI_Controller {
		
		function __construct() {
		  	parent::__construct();
		  	$this->load->database();
		  	$this->load->helper('url');
		  	$this->load->model('utilModel');
		}

		function index() {
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
		}

		function check_generated_report_log() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && ($this->session->userdata('logged-in-admin') || $this->session->userdata('logged-in-csm')) ) {
				if ($this->session->userdata('logged-in-admin')) {
					$user = $this->session->userdata('logged-in-admin');
				}else{
					$user = $this->session->userdata('logged-in-csm');
				}
				echo json_encode(array('status'=>'1','generated_report'=>$this->utilModel->check_generated_report_log($user)));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}
	}
?>