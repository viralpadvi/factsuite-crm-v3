<?php

class Custom_Util extends CI_Controller {

	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->helper('string');
	  	$this->load->model('outPutQcModel');
	  	$this->load->model('adminViewAllCaseModel');
	  	$this->load->model('utilModel');
	}

	function get_current_date_time($date_time_format = '') {
		if ($date_time_format == '') {
			return date('Y-m-d H:i:s'); 
		} else {
			return date($date_time_format); 
		}
	}

	function get_custom_filter_number_list() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		echo file_get_contents(base_url().'assets/custom-js/json/custom-filter-list.json');
	}

	function get_ticket_priority_list() {
		echo file_get_contents(base_url().'assets/custom-js/json/ticket-priority-list.json');
	}

	function get_ticket_classification_list() {
		echo file_get_contents(base_url().'assets/custom-js/json/ticket-classification-list.json');
	}

	function get_country_code_list() {
		echo json_encode($this->utilModel->get_country_code_list());
	}

	function get_custom_actions_list() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		echo file_get_contents(base_url().'assets/custom-js/json/custom-actions.json');
	}

	function get_all_remaining_days_rules() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		echo file_get_contents(base_url().'assets/custom-js/json/remaining-days-rules.json');
	}

	function get_all_case_priorities() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		echo file_get_contents(base_url().'assets/custom-js/json/case-priorities.json');
	}

	function get_all_clients() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		echo json_encode(array('status'=>'1','all_clients'=>$this->utilModel->get_all_clients()));
	}

	function get_all_rule_cirteria() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		echo file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json');
	}

	function get_candidate_versioned_details($candidate_generated_report_log_id,$logged_in_user_details) {
		$where_condition = array(
			'candidate_generated_report_log_id' => $candidate_generated_report_log_id
		);

		if ($logged_in_user_details['role'] != 'admin') {
			$where_condition['report_generated_by_role'] = $logged_in_user_details['role'];
		}
		return $this->db->where($where_condition)->get('candidate_generated_report_log')->row_array();
	}

	function download_bgv_reports($candidate_generated_report_log_id) {
		if ($this->session->userdata('logged-in-admin') != '') {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
		} else if($this->session->userdata('logged-in-csm')){
			$logged_in_user_details = $this->session->userdata('logged-in-csm');
		}else{
			redirect($this->config->item('my_base_url').'login');

		}
		$data['generated_report_details'] = $this->get_candidate_versioned_details($candidate_generated_report_log_id,$logged_in_user_details);
		if ($data['generated_report_details'] != '') {
			$this->load->view('bgv-reports/success-final-report-pdf',$data);
		} else {
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format.'));
		}
	}

}