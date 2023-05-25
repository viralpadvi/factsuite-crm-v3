<?php

/**
 * Created 1-2-2021
 */
class AdminViewAllCase extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');   
	  $this->load->model('adminViewAllCaseModel');  
	  $this->load->model('emailModel');  
	  $this->load->model('specialistModel');  
	  $this->load->model('amModel');  
	  $this->load->model('analystModel');  
	  $this->load->model('utilModel');
	  $this->load->model('inputQcModel');
	  $this->load->model('notificationModel');
	}


 	function check_admin_login() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function index(){ 
		$this->check_admin_login();
		$data['case'] = $this->adminViewAllCaseModel->getAllAssignedCases();
		$data['tat'] = $this->db->get('tat')->row_array();
		$data['session'] = $this->session->userdata('logged-in-admin');
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/case-list/all-case',$data);
		$this->load->view('admin/admin-common/footer');  
	}
  

	function singleCase($candidate_id){
		$data['candidate_id'] = $candidate_id;
		$candidateInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		$new_case_added_notification = $candidateInfo['new_case_added_notification'];
		$new_case_added_notification = json_decode($new_case_added_notification,true);
		// print_r($new_case_added_notification);
		$notification_admin = isset($new_case_added_notification['admin'])?$new_case_added_notification['admin']:'0';
		if($notification_admin=='0'){
			$new_case_added_notification['admin'] = '1';
			// print_r($new_case_added_notification);	
			$updatedInfo = array('new_case_added_notification'=>json_encode($new_case_added_notification),'updated_date'=>date('Y-m-d H:i:s'));
			$this->db->where('candidate_id',$candidate_id);
			if($this->db->update('candidate',$updatedInfo)){
				$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
				$this->db->insert('candidate_log',$updatedCandidatInfo);
			}
		}	


		// if($candidateInfo['case_complated_notification'] == '1'){
		// 	$updatedInfo = array('case_complated_notification'=>'0','updated_date'=>date('Y-m-d H:i:s'));
		// 	$this->db->where('candidate_id',$candidate_id);
		// 	if($this->db->update('candidate',$updatedInfo)){
		// 		$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		// 		$this->db->insert('candidate_log',$updatedCandidatInfo);
		// 	}
		// }
		// print_r($this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array());
		// exit();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar',$data); 
		$this->load->view('admin/case-list/view-single-assigned-case',$data);
		$this->load->view('admin/admin-common/footer');			
	}

	function getPackage(){
		// $this->check_inputqc_login();
		$data = $this->inputQcModel->getPackage();
		echo json_encode($data);
	}

	function get_new_cases_count() {
		echo json_encode($this->adminViewAllCaseModel->get_new_cases_count());
	}
	
	function getPackageDetail(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->getPackgeDetail();
		echo json_encode($data);
	}


	function insertCase(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->insertCase();
		echo json_encode($data);
	}

	function checkMobileNumber(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->checkMobileNumerExits();
		echo json_encode($data);
	}
 	
	function get_all_cases(){
		$data = $this->inputQcModel->get_all_cases();
		echo json_encode($data);
	}

	function getAllAssignedCases(){
		if($this->input->post('token') == '3ZGErMDCwxTOZYFp') {
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
			$data['cases'] = $this->adminViewAllCaseModel->getAllAssignedCases();
			$data['selected_datetime_format'] = $selected_datetime_format;
			echo json_encode($data);
		}else{
			echo json_encode(array("stauts"=>'3',"message"=>'Bad Request'));
		}
		
	}


	function get_single_case($candidate_id){
		$data = $this->inputQcModel->get_single_case_details($candidate_id);
		echo json_encode($data);
	}

	
	
	function getComponentBasedData(){
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		// echo $component_id;
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		 
		if($table_name != ''){
			$data = $this->adminViewAllCaseModel->getComponentBasedData($candidate_id,$table_name);
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
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		// echo $component_id;
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		 

		if($table_name != ''){
			$data = $this->inputQcModel->insuffUpdateStatus($candidate_id,$table_name,$component_id);
			 
		}else{
			$data = array('status'=>'0');
		}
 
		echo json_encode($data);
	}

	function approveUpdateStatus(){
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		// echo $component_id;
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		 
		if($table_name != ''){
			$data = $this->inputQcModel->approveUpdateStatus($candidate_id,$table_name,$component_id);
			 
		}else{
			$data = array('status'=>'0');
		}
 
		echo json_encode($data);
	}

 	 

	function getMinimumTaskHandlerInputQC(){
		$data = $this->inputQcModel->getMinimumTaskHandlerInputQC();
	}
 	
 	function getMinimumTaskHandlerAnalyst($table_name,$component_id){
		$data = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,$component_id);
	}

	function priorityUpdate(){
		$data = $this->amModel->priorityUpdate();
		echo  json_encode($data);
	}

	function getSingleAssignedCaseDetails($candidate_id){
		// $candidate_id = $_POST['candidate_id'];
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
		$data['candidate_details'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id);
		$data['selected_datetime_format'] = $selected_datetime_format;
		// $data = $this->adminViewAllCaseModel->getComponentForms($candidate_id);
		// exit();
		// header('Content-Type: application/json');
		echo json_encode($data);
	}

	// function getComponentDetail(){
	// 	$data = $this->adminViewAllCaseModel->getComponentForms();
	// 	echo json_encode($data);
	// }


	function getAnalystAndSpecialistTeamList($component_id){
		$data = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($component_id);
		echo json_encode($data);
	}


	function tatDateUpdate(){
		$data = $this->adminViewAllCaseModel->tatDateUpdate();
		echo json_encode($data);
	}

	function allCaseTatDateUpdate(){
		$data = $this->adminViewAllCaseModel->allCaseTatDateUpdate();
		echo json_encode($data);
	}

	function get_tat_log_data(){
		$str = $this->input->post('candidate_id');
		$candidate_id = base64_decode($str);
		$data = $this->adminViewAllCaseModel->get_tat_log_data($candidate_id);
		echo json_encode($data);
	}

	function getNewAddedCaseNotification(){		
		echo json_encode($this->notificationModel->getNewAddedCaseNotification());
	}

	function completedCaseNotify(){		
		echo json_encode($this->notificationModel->completedCaseNotify());
	}

	function intrrimCaseNotify()
	{
		echo json_encode($this->notificationModel->intrrimCaseNotify());
	}

	function change_case_payment_stauts(){
        $data =  $this->adminViewAllCaseModel->change_case_payment_stauts();
        echo $data;
    }
	
}