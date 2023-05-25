<?php

class Admin_Priority_Rules extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->model('admin_Priority_Rules_Model');
	  	$this->load->model('clientModel');
	  	$this->load->model('utilModel');
	} 

	function check_admin_login() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function priority_rules() {
		$this->check_admin_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-admin');
		$this->load->view('admin/admin-common/header',$outputqcData);
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/priority-rules/priority-rules-common');
		$this->load->view('admin/priority-rules/index');
		$this->load->view('admin/admin-common/footer');
	}

	function add_new_rule() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','rule_details'=>$this->admin_Priority_Rules_Model->add_new_rule()));
	}

	function get_all_rules() {
		$this->check_admin_login();
		$variable_array = array(
	  		'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		echo json_encode(array('status'=>'1','all_rules'=>$this->admin_Priority_Rules_Model->get_all_tickets(),'all_rule_cirteria'=>file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json'),'selected_datetime_format'=>$selected_datetime_format));
	}

	function get_single_rule_details() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','rule_details'=>$this->admin_Priority_Rules_Model->get_single_rule_details(),'all_rule_cirteria'=>file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json'),'all_remaining_days_type'=>file_get_contents(base_url().'assets/custom-js/json/priority-remaining-days-type.json'),'all_case_priorities'=>file_get_contents(base_url().'assets/custom-js/json/case-priorities.json'),'all_clients'=>$this->utilModel->get_all_clients()));
	}

	function change_rule_status() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','return_status'=>$this->admin_Priority_Rules_Model->change_rule_status()));
	}

	function update_rule() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','rule_details'=>$this->admin_Priority_Rules_Model->update_rule(),'all_rule_cirteria'=>file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json')));
	}
}