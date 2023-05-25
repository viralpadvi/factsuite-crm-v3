<?php

/**
 * Created 1-2-2021
 */
class Finance extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');  
	  $this->load->model('outPutQcModel');  
	  $this->load->model('emailModel');  
	  $this->load->model('analystModel');  
	  $this->load->model('utilModel');  
	  $this->load->model('adminViewAllCaseModel');  
	  $this->load->model('componentModel');  
	  $this->load->model('notificationModel');
	  $this->load->model('finance_Cases_Model');
	  $this->load->model('load_Database_Model');

	} 

	function check_outputqc_login() {
		if(!$this->session->userdata('logged-in-finance')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function dashboard() {
		$this->check_outputqc_login();
		$data['title']="Admin Dashboard";
		$this->load->view('finance/finance-common/header');
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/dashboard',$data);
		$this->load->view('finance/finance-common/footer');
	}



	function view_client(){
		// $this->check_admin_login();
		$data['client'] = $this->clientModel->get_master_client_details();
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['team'] = $this->teamModel->get_team_details();
		 $data['package'] = $this->packageModel->get_package_details(); 
		 
		$data['sessionData'] = $this->session->userdata('logged-in-finance');  
		$this->load->view('finance/finance-common/header',$data);
		$this->load->view('finance/finance-common/sidebar',$data);
		 
		$this->load->view('finance/client/client-common');
		$this->load->view('finance/client/view-client',$data);
		$this->load->view('finance/finance-common/footer');			
	}


	function edit_client($client_id){
		// $this->check_admin_login();
		$data['client_id'] = $client_id;
		$data['team'] = $this->teamModel->get_team_details();
		$data['clients'] = $this->clientModel->get_master_client_details();
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-finance');  
		$this->load->view('finance/finance-common/header',$data);
		$this->load->view('finance/finance-common/sidebar',$data);
		}
		$this->load->view('finance/client/client-common');
		$this->load->view('finance/client/edit-client',$data);
		$this->load->view('finance/finance-common/footer');	
	}

	function edit_select_package_client($client_id){
		// $this->check_admin_login();
		$data['client_id'] = $client_id;
		$data['team'] = $this->teamModel->get_team_details();
		$data['clients'] = $this->clientModel->get_master_client_details();
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['clients'] = $this->clientModel->get_client_details();
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-finance');  
		$this->load->view('finance/finance-common/header',$data);
		$this->load->view('finance/finance-common/sidebar',$data);
		}
		$this->load->view('finance/client/client-common');
		$this->load->view('finance/client/edit-select-package-component-client',$data);
		$this->load->view('finance/finance-common/footer');	
	}

	function edit_client_component_packages($client_id){
		// $this->check_admin_login();
		$data['client_id'] = $client_id;
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['clients'] = $this->clientModel->get_master_client_details();
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-finance');  
		$this->load->view('finance/finance-common/header',$data);
		$this->load->view('finance/finance-common/sidebar',$data);
		}
		$this->load->view('finance/client/client-common');
		$this->load->view('finance/client/edit-client-component-packages',$data);
		$this->load->view('finance/finance-common/footer');	
	}

	function edit_client_alacarte_component($client_id){
		// $this->check_admin_login();
		$data['client_id'] = $client_id;
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['clients'] = $this->clientModel->get_master_client_details();
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-finance');  
		$this->load->view('finance/finance-common/header',$data);
		$this->load->view('finance/finance-common/sidebar',$data);
		}
		$this->load->view('finance/client/client-common');
		$this->load->view('finance/client/edit-client-alacarte-component',$data);
		$this->load->view('finance/finance-common/footer');	
	}



	function index(){
		$this->check_outputqc_login();
		$data['client'] = $this->clientModel->get_client_details();
		// $data['package'] = $this->packageModel->get_component_name();
		// print_r($data);
		// exit();
		$this->load->view('finance/finance-common/header');
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/case/case-common');
		$this->load->view('finance/case/add-case',$data);
		$this->load->view('finance/finance-common/footer');

	}

	function viewAllCaseList(){
		$this->check_outputqc_login(); 
		$data['case'] =  $this->outPutQcModel->isComponentCompletedCaseList();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/all-case',$data);
		$this->load->view('finance/finance-common/footer');
	}

	
	function internal_chat(){
		$this->check_outputqc_login();
		$data['title'] = "Internal Chat"; 
		$team = $this->session->userdata('logged-in-finance');
		$data['team'] = $this->db->where_not_in('team_id',$team['team_id'])->where('is_Active',1)->get('team_employee')->result_array();  
		$this->load->view('finance/finance-common/header');
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('admin/chat/internal-chat',$data);
		$this->load->view('finance/finance-common/footer');
	}


	function view_completed_cases() {
		$this->check_outputqc_login(); 
		$data['case'] =  $this->outPutQcModel->isComponentCompletedCaseList();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/view-completed-case-list',$data);
		$this->load->view('finance/finance-common/footer');
	}

	function single_case($candidate_id) {
		$this->check_outputqc_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
		$data['candidate_id'] = $candidate_id;
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
		$data['selected_datetime_format'] = $selected_datetime_format;
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/view-single-case',$data);
		$this->load->view('finance/finance-common/footer');
	}

 
	function request_finance_bill() {
		$this->check_outputqc_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
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
	  	$outputqcData['selected_datetime_format'] = $selected_datetime_format;
		// $data['candidate_id'] = $candidate_id; 
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		// $this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/print-all-cases');
		$this->load->view('finance/finance-common/footer');
	}

	function request_finance_status() {
		$this->check_outputqc_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
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
	  	$outputqcData['selected_datetime_format'] = $selected_datetime_format;
		// $data['candidate_id'] = $candidate_id; 
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		// $this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/print-all-cases-status');
		$this->load->view('finance/finance-common/footer');
	}
	function request_finance_status_price() {
		$this->check_outputqc_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
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
	  	$outputqcData['selected_datetime_format'] = $selected_datetime_format;
		// $data['candidate_id'] = $candidate_id; 
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		// $this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/print-all-price-and-status');
		$this->load->view('finance/finance-common/footer');
	}

 
 
	function request_finance_summary() {
		$this->check_outputqc_login();
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
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance'); 
		$outputqcData['selected_datetime_format'] = $selected_datetime_format; 
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/saved-summary');
		$this->load->view('finance/finance-common/footer');
	}

 
	// function single_case($candidate_id,$status){
	// 	$this->check_outputqc_login(); 
	// 	$data['candidate_id'] = $candidate_id; 
	// 	$data['status'] = $status;
	// 	// $data['candidate_id'] = $candidate_id;
	// 	// $candidateInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
	// 	// $new_case_added_notification = $candidateInfo['new_case_added_notification'];
	// 	// $new_case_added_notification = json_decode($new_case_added_notification,true);
	// 	// // print_r($new_case_added_notification);
	// 	// if($new_case_added_notification['inputQc']=='0'){
	// 	// 	$new_case_added_notification['inputQc'] = '1';
	// 	// 	// print_r($new_case_added_notification);	
	// 	// 	$updatedInfo = array('new_case_added_notification'=>json_encode($new_case_added_notification),'updated_date'=>date('Y-m-d H:i:s'));
	// 	// 	$this->db->where('candidate_id',$candidate_id);
	// 	// 	if($this->db->update('candidate',$updatedInfo)){
	// 	// 		$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
	// 	// 		$this->db->insert('candidate_log',$updatedCandidatInfo);
	// 	// 	}
	// 	// }
	// 	$this->load->view('finance/finance-common/header');
	// 	$this->load->view('finance/finance-common/sidebar',$data);
	// 	$this->load->view('finance/assigned-case/case-common',$data);
	// 	$this->load->view('finance/assigned-case/view-single-case',$data);
	// 	$this->load->view('finance/finance-common/footer');			
	// }

	function assignedInprogressCaseList() {
		$this->check_outputqc_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
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
		$outputqcData['selected_datetime_format'] = $selected_datetime_format; 
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/all-assigned-case');
		$this->load->view('finance/finance-common/footer');
	}

	function assignedCompletedCaseList(){
		$this->check_outputqc_login(); 
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
		$data['case'] = $this->outPutQcModel->getAllAssignedCompletedCases();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/all-completed-cases',$data);
		$this->load->view('finance/finance-common/footer');

	}

	function assignedErrorCaseList(){

		$this->check_outputqc_login(); 
		$data['case'] = $this->outPutQcModel->getAllAssignedCases();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/assigned-case/case-common');
		$this->load->view('finance/assigned-case/all-error-cases',$data);
		$this->load->view('finance/finance-common/footer');

	}

	function assignedSingleCase($candidate_id){
		$this->check_outputqc_login(); 
		$data['candidate_id'] = $candidate_id;

		// assigned_outputqc_notification
		$candidateInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		// print_r($candidateInfo);
		// exit();
		if($candidateInfo['assigned_outputqc_notification']=='1'){
			 
		 $updatedInfo = array('assigned_outputqc_notification'=>'2','updated_date'=>date('Y-m-d H:i:s'));
			$this->db->where('candidate_id',$candidate_id);
			if($this->db->update('candidate',$updatedInfo)){
				$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
				$this->db->insert('candidate_log',$updatedCandidatInfo);
			}
		}

		// if(){

		// }
		$data['status'] = $candidateInfo['is_submitted'];
		$this->load->view('finance/finance-common/header');
		$this->load->view('finance/finance-common/sidebar',$data);
		$this->load->view('finance/assigned-case/case-common',$data);
		$this->load->view('finance/assigned-case/view-single-assigned-case',$data);
		$this->load->view('finance/finance-common/footer');			
	}

	function htmlGenrateReport($candidate_id){
		// $this->check_outputqc_login(); 
		$data['candidate_data']=$this->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->outPutQcModel->all_components($candidate_id);
		$data['candidate_status'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id);
		// $this->load->view('finance/finance-common/header');
		// $this->load->view('finance/finance-common/sidebar',$data);
		// $this->load->view('finance/assigned-case/case-common',$data);
		$this->load->view('finance/report/success_report_preview',$data);
		// $this->load->view('finance/report/success_report',$data);
		// $this->load->view('finance/finance-common/footer');			
	}

	function candidateReportData($candidate_id){
		$data = $this->outPutQcModel->candidateReportData($candidate_id);
		return $data;
	}

	function getPackage(){
		// $this->check_outputqc_login();
		$data = $this->outPutQcModel->getPackage();
		echo json_encode($data);
	}


	function getPackageDetail(){
		$this->check_outputqc_login();
		$data = $this->outPutQcModel->getPackgeDetail();
		echo json_encode($data);
	}


	function insertCase(){
		$this->check_outputqc_login();
		$data = $this->outPutQcModel->insertCase();
		echo json_encode($data);
	}

	function checkMobileNumber(){
		$this->check_outputqc_login();
		$data = $this->outPutQcModel->checkMobileNumerExits();
		echo json_encode($data);
	}
 	
	function get_all_cases(){
		$data = $this->outPutQcModel->get_all_cases();
		echo json_encode($data);
	}

	function getAllAssignedCases(){
		$data = $this->outPutQcModel->getAllAssignedCases();
		echo json_encode($data);
	}


	function get_single_case($candidate_id){
		$data = $this->outPutQcModel->get_single_case_details($candidate_id);
		echo json_encode($data);
	}

	function getSingleAssignedCaseDetails($candidate_id){
		$data = $this->outPutQcModel->getSingleAssignedCaseDetails($candidate_id);
		// exit();
		echo json_encode($data);
	}

	
	function pdf($candidate_id){ 
	$data['title'] = "Generate PDF" ;
	$data['candidate'] = $this->outPutQcModel->candidateReportData($candidate_id);
	$data['candidate_id'] = $candidate_id;
	$data['table'] = $this->outPutQcModel->all_components($candidate_id);
	$data['candidate_status'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id);
	// echo json_encode($data);
	/*echo json_encode($data['candidate'][0]['candidaetData']);
	exit();*/
		// $this->load->view('finance/report/success_pdf_report',$data);
		// $this->load->view('finance/report/final_report_pdf',$data);
		$this->load->view('finance/report/success_final_report_pdf',$data);
	}
	
	function getComponentBasedData(){ 
		$component_id= $this->input->post('component_id');
		// echo $component_id;
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		 

		if($table_name != ''){
			$data = $this->outPutQcModel->getComponentBasedData($candidate_id,$table_name);
			if($data == '' && $data == null){
				$data = array('status'=>'0');
			}else{
				$result = array('status'=>'1','component_data'=>$data);
				$data = $result;
			}
		}else{
			$data = array('status'=>'0');
		}
 
		echo json_encode($data);
	}


	function insuffUpdateStatus(){
		// $candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		// echo $component_id;
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		 

		if($table_name != ''){
			$data = $this->outPutQcModel->insuffUpdateStatus($candidate_id,$table_name,$component_id);
			 
		}else{
			$data = array('status'=>'0');
		}
 
		echo json_encode($data);
	}

	function approveUpdateStatus(){
		// $candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		// echo $component_id;
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		 

		if($table_name != ''){
			$data = $this->outPutQcModel->approveUpdateStatus($candidate_id,$table_name,$component_id);
			 
		}else{
			$data = array('status'=>'0');
		}
 
		echo json_encode($data);
	}
 
	function getMinimumTaskHandleroutputQC(){
		$data = $this->outPutQcModel->getMinimumTaskHandleroutputQC();
	}
 	
 	function getMinimumTaskHandlerAnalyst($table_name,$component_id){
		$data = $this->outPutQcModel->getMinimumTaskHandlerAnalyst($table_name,$component_id);
	}

	function singleComponentDetail($candidateId,$componentId){
		// echo $componentId." : ".$candidateId;
		// $this->check_outputqc_login(); 
		$data1 = $this->analystModel->singleComponentDetail($componentId,$candidateId);
		// print_r($data); 
		// exit();
		$pageName = $this->utilModel->getComponent_or_PageName($componentId);
		$data['countries'] = $this->analystModel->get_all_countries();
		$data['states'] = $this->analystModel->get_all_states(101); 
		$data['componentData'] = $data1;
		if($componentId == '22'){
      		$data['previous_employment'] = $this->db->where('candidate_id',$candidateId)->get('previous_employment')->row_array();
   		}

	    
	    if($componentId == '6' || $componentId == '10'){
	      $data['currency'] = file_get_contents(base_url().'assets/custom-js/json/currency.json');
		}
		$userData = $this->session->userdata('logged-in-finance');
		$component_name = $this->utilModel->getComponent_or_PageName($componentId);
		$getNotification = $this->db->where('case_id',$candidateId)->where('notification_status','0')->where('component_id',$componentId)->where('component_status != ','10')->where('assigned_team_id',$userData['team_id'])->get('notifications')->row_array();
		// echo $this->db->last_query();
		if($getNotification != '' && $getNotification != null){
			if($getNotification['notification_status'] == '0'){
				$updateNotifcationData = array('notification_status'=>'1','manually_seen'=>'1',
					'updated_date'=>date('Y-m-d H:i:s'));
				$this->db->where('case_id',$candidateId)->where('notification_status','0')->where('component_id',$componentId)->where('assigned_team_id',$userData['team_id'])->update('notifications',$updateNotifcationData);
				// echo $this->db->last_query();
				

			}
		}

		// exit();
		$this->load->view('finance/finance-common/header');
		$this->load->view('finance/finance-common/sidebar',$data);
		// $this->load->view('finance/assigned-case/case-common',$data);
		$this->load->view('finance/assigned-case/component-pages/'.$pageName,$data);
		$this->load->view('finance/finance-common/footer');
		 
	} 

	function get_all_cities($id){
		$data = $this->analystModel->get_all_cities($id);
		echo json_encode($data);
	}
	function genrateReportStatus(){
		$this->check_outputqc_login(); 
		$data = $this->outPutQcModel->genrateReportStatus();
		echo json_encode($data);
	}

	function isComponentCompletedCaseList(){
		$data = $this->outPutQcModel->isComponentCompletedCaseList();
		echo json_encode($data);
	} 

	function checkOputputQcApprovedOrNot(){
		$data = $this->outPutQcModel->checkOputputQcApprovedOrNot();
		echo json_encode($data);
	} 

	function update_remarks_candidate_criminal_check(){
 
 		$data = $this->outPutQcModel->update_remarks_candidate_criminal_check();
		echo json_encode($data);	
 	}

 	function update_remarks_candidate_court_record(){
 
 		$data = $this->outPutQcModel->update_remarks_candidate_court_record();
		echo json_encode($data);	
 	}

 	function update_remarks_candidate_permanent_address(){
 		 
 		$data = $this->outPutQcModel->update_remarks_candidate_permanent_address();
		echo json_encode($data); 		
 	}

 	function update_remarks_candidate_present_address(){
 		 
 		$data = $this->outPutQcModel->update_remarks_candidate_present_address();
		echo json_encode($data); 		
 	}

 	function update_remarks_candidate_previous_address(){ 
 		// $this->check_analyst_login();
 

 		$data = $this->outPutQcModel->update_remarks_candidate_previous_address();
		echo json_encode($data); 		
 	}

 	function update_remarks_current_employment(){
  
 		$data = $this->outPutQcModel->update_remarks_current_employment();
		echo json_encode($data); 	
 	}

 	function update_remarks_previous_employment(){

 		 
 		// $this->check_analyst_login();
 		$data = $this->outPutQcModel->update_remarks_previous_employment();
		echo json_encode($data); 	
 	}

 	function update_reference(){
 
 		// $this->check_analyst_login();
 		$data = $this->outPutQcModel->update_reference();
 		echo json_encode($data);
 	}

 	function update_gd_remarks(){
 		 
 		$data = $this->outPutQcModel->update_globalDb();
 		echo json_encode($data);
 	}

 	function remarkForDrugTest(){ 
 		// $this->check_analyst_login();
 		$data = $this->outPutQcModel->remarkForDrugTest();
 		echo json_encode($data);
 	}

 	function remarkForDocuemtCheck(){
 	 
 		$data = $this->outPutQcModel->remarkForDocuemtCheck();
 		echo json_encode($data);
 	}

 	function remarkForEduCheck(){

 	 
 		$data = $this->outPutQcModel->remarkForEduCheck();
 		echo json_encode($data);
 	}


 	function update_remarks_directorship_check(){
 
 		$data = $this->outPutQcModel->update_remarks_directorship_check();
		echo json_encode($data);	
 	}
 	

 	function update_remarks_adverse_database_media_check(){
 
 		$data = $this->outPutQcModel->update_remarks_adverse_database_media_check();
		echo json_encode($data);	
 	}

 	function update_remarks_global_sanctions_aml_check(){
 
 		$data = $this->outPutQcModel->update_remarks_global_sanctions_aml_check();
		echo json_encode($data);	
 	}

 	function update_remarks_health_checkup(){
 
 		$data = $this->outPutQcModel->update_remarks_health_checkup();
		echo json_encode($data);	
 	}


 	function update_remarks_bankruptcy_check(){
 		$data = $this->outPutQcModel->update_remarks_bankruptcy_check();
		echo json_encode($data);
		 
	}

	function update_remarks_credit_cibil_check(){
		$data = $this->outPutQcModel->update_remarks_credit_cibil_check();
		echo json_encode($data); 
	}

	function update_remarks_cv_check(){
		$data = $this->outPutQcModel->update_remarks_cv_check();
		echo json_encode($data);
		 
	}

	function update_remarks_driving_licence_check(){
		$data = $this->outPutQcModel->update_remarks_driving_licence_check();
		echo json_encode($data);
		 
	}

	function update_employment_gap_check(){
		$data = $this->outPutQcModel->update_employment_gap_check();
		echo json_encode($data);
		 
	}

	function export_outputqc_excel(){
		$data['components'] = $this->componentModel->get_component_details();
		$this->load->view('finance/finance-common/header');
		$this->load->view('finance/finance-common/sidebar',$data); 
		$this->load->view('finance/report/finance-excel-report',$data);
		$this->load->view('finance/finance-common/footer');		
	}


	function outPutQcNewCaseNotify(){
		$data = $this->notificationModel->outPutQcNewCaseNotify();
		echo json_encode($data);
	}
	
	function outPutQcClearComponentErrorNotify(){
		$data = $this->notificationModel->outPutQcClearComponentErrorNotify();
		echo json_encode($data);
	}

	function save_finance_case_summary(){
		$data = $this->finance_Cases_Model->save_finance_case_summary();
		echo json_encode($data);
	}


	function selected_request_finance_summary($id){
		$data = $this->finance_Cases_Model->selected_request_finance_summary($id);
		echo json_encode($data);
	}

	function save_selected_finance_case_summary_value($id){
		$data = $this->finance_Cases_Model->save_selected_finance_case_summary_value($id);
		echo json_encode($data);
	}

	function statussummary($id) {
		$summarystatus = $this->input->post('summarystatus');
		$status = $this->finance_Cases_Model->changeStatusSummary($id,$summarystatus);
		if($status['status'] == '1') {
			echo json_encode(array('status'=>'1','return_status'=>$status));
		} else {
			echo json_encode(array('status'=>'0','return_status'=>$status));
		}
	}
}	