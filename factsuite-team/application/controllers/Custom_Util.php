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
	  	$this->load->model('clientModel');
	}

	function get_actual_date_formate(){
		echo $this->utilModel->get_actual_date_formate($this->input->post('curr_date'));
	}

	function get_location(){
		if ($this->input->get('term')) {
			$this->db->like('location_name',$this->input->get('term'));
		}
		$data = $this->db->order_by('location_id','DESC')->get('autocomplete_location')->result_array();
		echo json_encode($data);
	}

	function get_segment(){
		if ($this->input->get('term')) {
			$this->db->like('segment_name',$this->input->get('term'));
		}
		$data = $this->db->order_by('segment_id','DESC')->get('autocomplete_segment')->result_array();
		echo json_encode($data);
	}

	function get_custom_filter_number_list() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
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
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-csm');
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

	function get_custom_filter_number_list_v2() {
		echo file_get_contents(base_url().'assets/custom-js/json/custom-filter-list.json');
	}

	function get_ticket_priority_list() {
		echo file_get_contents(base_url().'assets/custom-js/json/ticket-priority-list.json');
	}

	function get_ticket_classification_list() {
		echo file_get_contents(base_url().'assets/custom-js/json/ticket-classification-list.json');
	}

	function get_all_form_fields() {
		echo file_get_contents(base_url().'assets/custom-js/json/form-fields.json');
	}

	function get_all_email_templates() {
		echo file_get_contents(base_url().'assets/custom-js/json/email-templates.json');
	}

	function get_country_code_list() {
		echo file_get_contents(base_url().'assets/custom-js/json/country-code.json');
	}

	function get_all_segments() {
		echo file_get_contents(base_url().'assets/custom-js/json/segments.json');
	}

	function get_all_client_type() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
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

		echo json_encode(array('status'=>'1','all_client_type'=>file_get_contents(base_url().'assets/custom-js/json/client-type.json')));
	}

	function get_custom_actions_list() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
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
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
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
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
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
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
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

		$variable_array = array(
			'client_status' => 1
		);
		if ($this->input->post('client_type') != '') {
			$variable_array['client_type'] = $this->input->post('client_type');
		}
		echo json_encode(array('status'=>'1','all_clients'=>$this->utilModel->get_all_clients($variable_array)));
	}

	function get_all_clients_for_email_templates() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
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

		$where_condition = array(
			'client_status' => 1
		);
		if ($this->input->post('selected_template') != '') {
			if ($this->input->post('selected_template') == 6) {
				$where_condition['notification_to_client_for_insuff_status'] = '1';
				$where_condition['notification_to_client_for_insuff_types REGEXP'] = '2';
			} else if ($this->input->post('selected_template') == 7) {
				$where_condition['notification_to_client_for_insuff_status'] = '1';
				$where_condition['notification_to_client_for_client_clarification_types REGEXP'] = '2';
			}
		}

		$db_result = $this->db->where($where_condition)->get('tbl_client')->result_array();
		echo json_encode(array('status'=>'1','all_clients'=>$db_result));
	}

	function get_all_rule_cirteria() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_finance_request) && $verify_finance_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
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

	function get_all_case_type() {
		echo file_get_contents(base_url().'assets/custom-js/json/case-type.json');
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
		} else {
			redirect($this->config->item('my_base_url').'login');
		}
		$data['generated_report_details'] = $this->get_candidate_versioned_details($candidate_generated_report_log_id,$logged_in_user_details);
		if ($data['generated_report_details'] != '') {
			if ($this->config->item('production') ==1) {
			$this->load->view('bgv-reports/success-final-report-pdf',$data); 
			}else{
			// $this->load->view('bgv-reports/success-final-report-pdf-v2',$data); 	
			$this->load->view('bgv-reports/success-final-report-pdf-v3',$data); 	
			}
		} else {
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format.'));
		}
	}

	function static_loa_pdf() {
		$this->load->view('admin/loa-static-pdf');
	}


	function final_loa_pdf($candidate_id) {
		$data['candidate'] = $this->clientModel->get_single_candidate_details($candidate_id);
		$this->load->view('admin/loa-final-candidate-pdf',$data);
	}
}