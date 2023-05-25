<?php

class Finance_Cases extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  // $this->load->model('teamModel');  
	  // $this->load->model('clientModel');  
	  // $this->load->model('packageModel');  
	  // $this->load->model('outPutQcModel');  
	  // $this->load->model('emailModel');  
	  // $this->load->model('analystModel');  
	  // $this->load->model('utilModel');  
	  // $this->load->model('adminViewAllCaseModel');  
	  // $this->load->model('componentModel');
	  $this->load->model('finance_Cases_Model');
	  $this->load->model('notificationModel');
	  $this->load->model('utilModel');

	} 

	function check_finance_login() {
		if(!$this->session->userdata('logged-in-finance')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function get_all_cases() {
		$this->check_finance_login();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		$data['all_cases'] = $this->finance_Cases_Model->get_all_cases();
		$data['selected_datetime_format'] = $selected_datetime_format;
		echo json_encode($data);
	}

	function get_all_completed_cases() {
		$this->check_finance_login();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		$data['all_cases'] = $this->finance_Cases_Model->get_all_completed_cases();
		$data['selected_datetime_format'] = $selected_datetime_format;
		echo json_encode($data);
	}

	function single_case($candidate_id,$status) {
		$this->check_finance_login(); 
		$data['candidate_id'] = $candidate_id; 
		$data['status'] = $status;
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar',$data);
		$this->load->view('outputqc/assigned-case/case-common',$data);
		$this->load->view('outputqc/assigned-case/view-single-case',$data);
		$this->load->view('outputqc/outputqc-common/footer');			
	}

	function get_new_cases_count() {
		$this->check_finance_login(); 
		echo json_encode($this->finance_Cases_Model->get_new_cases_count());
	}

	function get_all_partially_builled_cases() {
		$this->check_finance_login();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		$data['all_cases'] = $this->finance_Cases_Model->get_all_partially_builled_cases();
		$data['selected_datetime_format'] = $selected_datetime_format;
		echo json_encode($data);
	}

	function get_all_saved_summary() {
		$this->check_finance_login();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		$data['all_cases'] = $this->finance_Cases_Model->get_all_saved_summary();
		$data['selected_datetime_format'] = $selected_datetime_format;
		echo json_encode($data);
	}

	function get_new_cases_summary_count() {
		$this->check_finance_login();
		echo json_encode($this->finance_Cases_Model->get_new_cases_summary_count());
	}

}	