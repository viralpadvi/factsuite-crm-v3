<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_Login_Model extends CI_Model {

	function check_admin_login() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url'));
		}
	}

	function check_admin_login_with_status() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url'));
			// echo json_encode(array('status'=>'0','message'=>'Bad Request'));
			// return false;
		}
	}
}