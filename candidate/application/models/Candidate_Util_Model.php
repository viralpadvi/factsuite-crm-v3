<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_Util_Model extends CI_Model {

	function check_candidate_email_id($email) {
		$user = $this->session->userdata('logged-in-candidate');
		$where_condition = array(
			'email_id' => $email,
		);
		$where_not_in_condition = array(
			$user['candidate_id']
		);
		return $this->db->select('COUNT(*) AS count')->where($where_condition)->where_not_in('candidate_id', $where_not_in_condition)->get('candidate')->row_array();
	}

	function random_number($digits) {
		return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
	}

	function get_country_code_list() {
		echo file_get_contents(base_url().'assets/custom-js/json/country-code.json');
	}

	function get_timezone_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$where_condition = array(
			'client_id' => $user['client_id']
		);
		return $this->db->where($where_condition)->get('client_timezone')->row_array();
	}
}