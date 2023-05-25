<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_Candidate_Login_Model extends CI_Model {

	function check_candidate_login() {
		if(!$this->session->userdata('logged-in-candidate')) {
			redirect($this->config->item('my_base_url'));
		}
	}
}