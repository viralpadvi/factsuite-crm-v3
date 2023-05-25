<?php
class Candidate_Util extends CI_Controller
{

	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url'); 
	  	$this->load->model('candidate_Util_Model');
	}

	function check_candidate_email_id() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','email_count'=>$this->candidate_Util_Model->check_candidate_email_id($this->input->post('email'))));
		} else {
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
		}
	}
}