<?php

/**
 * Created 1-2-2021
 */
class OutPutQc extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');  
	  $this->load->model('outPutQcModel');  
	  $this->load->model('OutPutNewComponents');  
	  $this->load->model('emailModel');  
	  $this->load->model('analystModel');  
	  $this->load->model('utilModel');  
	  $this->load->model('adminViewAllCaseModel');  
	  $this->load->model('componentModel');  
	  $this->load->model('notificationModel');
	  $this->load->model('load_Database_Model');

	} 

	function check_outputqc_login() {
		if(!$this->session->userdata('logged-in-outputqc')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function index(){
		$this->check_outputqc_login();
		$data['client'] = $this->clientModel->get_client_details();
		// $data['package'] = $this->packageModel->get_component_name();
		// print_r($data);
		// exit();
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar');
		$this->load->view('outputqc/case/case-common');
		$this->load->view('outputqc/case/add-case',$data);
		$this->load->view('outputqc/outputqc-common/footer');

	}

	function viewAllCaseList(){
		$this->check_outputqc_login(); 
		$data['case'] =  $this->outPutQcModel->isComponentCompletedCaseList();
		$outputqcData['userData'] = $this->session->userdata('logged-in-outputqc');
		$this->load->view('outputqc/outputqc-common/header',$outputqcData);
		$this->load->view('outputqc/outputqc-common/sidebar');
		$this->load->view('outputqc/assigned-case/case-common');
		$this->load->view('outputqc/assigned-case/all-case',$data);
		$this->load->view('outputqc/outputqc-common/footer');

	}

	function internal_chat(){
		$this->check_outputqc_login();
		$data['title'] = "Internal Chat"; 
		$team = $this->session->userdata('logged-in-outputqc');
		$data['team'] = $this->db->where_not_in('team_id',$team['team_id'])->where('is_Active',1)->get('team_employee')->result_array();  
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar');
		$this->load->view('admin/chat/internal-chat',$data);
		$this->load->view('outputqc/outputqc-common/footer');
	}

 
	function single_case($candidate_id,$status){
		$this->check_outputqc_login(); 
		$data['candidate_id'] = $candidate_id; 
		$data['status'] = $status;
		// $data['candidate_id'] = $candidate_id;
		// $candidateInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		// $new_case_added_notification = $candidateInfo['new_case_added_notification'];
		// $new_case_added_notification = json_decode($new_case_added_notification,true);
		// // print_r($new_case_added_notification);
		// if($new_case_added_notification['inputQc']=='0'){
		// 	$new_case_added_notification['inputQc'] = '1';
		// 	// print_r($new_case_added_notification);	
		// 	$updatedInfo = array('new_case_added_notification'=>json_encode($new_case_added_notification),'updated_date'=>date('Y-m-d H:i:s'));
		// 	$this->db->where('candidate_id',$candidate_id);
		// 	if($this->db->update('candidate',$updatedInfo)){
		// 		$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		// 		$this->db->insert('candidate_log',$updatedCandidatInfo);
		// 	}
		// }

		$output = $this->session->userdata('logged-in-outputqc'); 
		$id = isset($output['team_id'])?$output['team_id']:0; 
		$candidateInfo = $this->db->where('case_id',$candidate_id)->where('assigned_team_id',$id)->get('notifications')->row_array();
		 
		if($candidateInfo['notification_status']=='0'){ 
		 $updatedInfo = array('notification_status'=>'1','updated_date'=>date('Y-m-d H:i:s')); 
		$this->db->where('case_id',$candidate_id)->where('assigned_team_id',$id)->update('notifications',$updatedInfo);
		} 
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar',$data);
		$this->load->view('outputqc/assigned-case/case-common',$data);
		$this->load->view('outputqc/assigned-case/view-single-case',$data);
		$this->load->view('outputqc/outputqc-common/footer');			
	}

	function assignedCaseList(){
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
		$data['case'] = $this->outPutQcModel->getAllAssignedCases_();
		$outputqcData['userData'] = $this->session->userdata('logged-in-outputqc');
		$data['selected_datetime_format'] = $selected_datetime_format;
		$this->load->view('outputqc/outputqc-common/header',$outputqcData);
		$this->load->view('outputqc/outputqc-common/sidebar');
		$this->load->view('outputqc/assigned-case/case-common');
		$this->load->view('outputqc/assigned-case/all-assigned-case',$data);
		$this->load->view('outputqc/outputqc-common/footer');

	}

	function assignedCompletedCaseList(){

		$this->check_outputqc_login(); 
		$data['case'] = $this->outPutQcModel->getAllAssignedCompletedCases_();
		$outputqcData['userData'] = $this->session->userdata('logged-in-outputqc');
		$this->load->view('outputqc/outputqc-common/header',$outputqcData);
		$this->load->view('outputqc/outputqc-common/sidebar');
		$this->load->view('outputqc/assigned-case/case-common');
		$this->load->view('outputqc/assigned-case/all-completed-cases',$data);
		$this->load->view('outputqc/outputqc-common/footer');

	}

	function assignedErrorCaseList(){

		$this->check_outputqc_login(); 
		$data['case'] = $this->outPutQcModel->getAllAssignedCases();
		$outputqcData['userData'] = $this->session->userdata('logged-in-outputqc');
		$this->load->view('outputqc/outputqc-common/header',$outputqcData);
		$this->load->view('outputqc/outputqc-common/sidebar');
		$this->load->view('outputqc/assigned-case/case-common');
		$this->load->view('outputqc/assigned-case/all-error-cases',$data);
		$this->load->view('outputqc/outputqc-common/footer');

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

		$output = $this->session->userdata('logged-in-outputqc'); 
		$id = isset($output['team_id'])?$output['team_id']:0; 
		$candidateInfom = $this->db->where('case_id',$candidate_id)->where('assigned_team_id',$id)->get('notifications')->row_array();
		 
		if($candidateInfom !=null){ 
		if($candidateInfom['notification_status']=='0'){ 
		 $updatedInfo = array('notification_status'=>'1','updated_date'=>date('Y-m-d H:i:s')); 
		$this->db->where('case_id',$candidate_id)->where('assigned_team_id',$id)->update('notifications',$updatedInfo);
		} 
		} 

		$data['status'] = $candidateInfo['is_submitted'];
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar',$data);
		$this->load->view('outputqc/assigned-case/case-common',$data);
		$this->load->view('outputqc/assigned-case/view-single-assigned-case',$data);
		$this->load->view('outputqc/outputqc-common/footer');			
	}

	function htmlGenrateReport($candidate_id){
		// $this->check_outputqc_login(); 
		$data['candidate_data']=$this->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->outPutQcModel->all_components($candidate_id);
		$data['candidate_status'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id); 
		// $this->load->view('outputqc/outputqc-common/header');
		// $this->load->view('outputqc/outputqc-common/sidebar',$data);
		// $this->load->view('outputqc/assigned-case/case-common',$data);
		$this->load->view('outputqc/report/success_report_preview',$data);
		// $this->load->view('outputqc/report/success_report',$data);
		// $this->load->view('outputqc/outputqc-common/footer');			
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

	
	function pdf($candidate_id) {
		extract($_GET);
		$logged_in_user_details = [];

		if ($this->session->userdata('logged-in-admin') != '') {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
		} else if ($this->session->userdata('logged-in-outputqc') != '') {
			$logged_in_user_details = $this->session->userdata('logged-in-outputqc');
		} else if ($authentcation_for != '') {
			// This is for Factsuite Website Client Session
			$where_condition = array(
				'MD5(TO_BASE64(MD5(MD5(spoc_id))))' => $authentcation_for
			);
			$client_spoc_details = $this->db->where($where_condition)->get('tbl_clientspocdetails')->row_array();
			if ($client_spoc_details != '') {
				$where_condition = array(
					'candidate_id' => $candidate_id,
					'client_id' => $client_spoc_details['client_id']
				);

				$client_details = $this->db->where($where_condition)->get('candidate')->row_array();

				$logged_in_user_details = array(
					'team_id' => $client_spoc_details['client_id'],
					'role' => 'Client SPOC'
				);
				if ($client_details == '') {
					echo json_encode(array('status'=>'201','message'=>'Wrong request made.'));
					return false;	
				}
			} else {
				echo json_encode(array('status'=>'201','message'=>'Wrong request made.'));
				return false;
			}
		} else {
			redirect($this->config->item('my_base_url').'login');
		}

		$data['title'] = "Generate PDF" ;
		$data['candidate'] = $this->outPutQcModel->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->outPutQcModel->all_components($candidate_id);
		$data['candidate_status'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id);

		$this->utilModel->store_candidate_generated_report_details($data,$logged_in_user_details);

		// echo json_encode($data);
		/*echo json_encode($data['candidate'][0]['candidaetData']);
		exit();*/
		// $this->load->view('outputqc/report/success_pdf_report',$data);
		// $this->load->view('outputqc/report/final_report_pdf',$data);

		// Use the below for new Report UI
		if ($this->config->item('production') ==1) { 
			$this->load->view('outputqc/report/success_final_report_pdf',$data);
		}else{
			// $this->load->view('outputqc/report/success-final-report-pdf-v2',$data); 	
		}

		// Use the below fr R&D of new Report UI
		$this->load->view('outputqc/report/success-final-report-pdf-v3',$data);
	}
	
	function getComponentBasedData() { 
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

	function insuffUpdateStatus() {
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

	function approveUpdateStatus() {
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
 
	function getMinimumTaskHandleroutputQC() {
		$data = $this->outPutQcModel->getMinimumTaskHandleroutputQC();
	}
 	
 	function getMinimumTaskHandlerAnalyst($table_name,$component_id) {
		$data = $this->outPutQcModel->getMinimumTaskHandlerAnalyst($table_name,$component_id);
	}

	function singleComponentDetail($candidateId,$componentId) {
		// echo $componentId." : ".$candidateId;
		// $this->check_outputqc_login(); 
		$data1 = $this->analystModel->singleComponentDetail($componentId,$candidateId);
		// print_r($data); 
		// exit();
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
		$pageName = $this->utilModel->getComponent_or_PageName($componentId);
		$data['countries'] = $this->analystModel->get_all_countries();
		$data['states'] = $this->analystModel->get_all_states(101); 
		$data['componentData'] = $data1;
		$data['selected_datetime_format'] = $selected_datetime_format;
		if($componentId == '22'){
      		$data['previous_employment'] = $this->db->where('candidate_id',$candidateId)->get('previous_employment')->row_array();
   		}

	    
	    if($componentId == '6' || $componentId == '10'){
	      $data['currency'] = file_get_contents(base_url().'assets/custom-js/json/currency.json');
		}
		$data['gender_list'] = file_get_contents(base_url().'assets/custom-js/json/gender-list.json');
		
		$userData = $this->session->userdata('logged-in-outputqc');
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

		$uploaded_loa = $this->db->select('signature_img')->where('candidate_id',$candidateId)->get('signature')->row_array();
		$data['uploaded_loa'] = isset($uploaded_loa['signature_img'])?$uploaded_loa['signature_img']:'-';
		$url = base_url();
		$data['base_url'] = str_replace('factsuite-team/','',$url);
		// echo '<pre>';
		// print_r($data);
		// exit();


		  if (isset($_GET['v'])) {
		   $v = base64_decode($_GET['v']);
		    $data['param'] = "?v=".$v;
		  }

		  if (isset($_GET['flag'])) {
		     $data['param'] = "?flag=2";
		    }
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar',$data);
		// $this->load->view('outputqc/assigned-case/case-common',$data);
		$this->load->view('outputqc/assigned-case/component-pages/'.$pageName,$data);
		$this->load->view('outputqc/outputqc-common/footer');
	} 

	function get_all_cities($id) {
		$data = $this->analystModel->get_all_cities($id);
		echo json_encode($data);
	}

	function genrateReportStatus() {
		$this->check_outputqc_login(); 
		echo json_encode($this->outPutQcModel->genrateReportStatus());
	}

	function isComponentCompletedCaseList() {
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

	function update_remarks_candidate_civil_check(){
 
 		$data = $this->outPutQcModel->update_remarks_candidate_civil_check();
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

 	function update_landlord_reference(){
 		$data = $this->outPutQcModel->update_landlord_reference();
 		echo json_encode($data);
 	}

 	function update_gd_remarks(){
 		 
 		$data = $this->outPutQcModel->update_globalDb();
 		echo json_encode($data);
 	}

 	function update_social_remarks(){
 		 
 		$data = $this->outPutQcModel->update_social_media();
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

 	function update_remarks_covid_19(){
 
 		$data = $this->outPutQcModel->update_remarks_covid_19();
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
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar',$data); 
		$this->load->view('outputqc/report/outputqc-excel-report',$data);
		$this->load->view('outputqc/outputqc-common/footer');		
	}


	function outPutQcNewCaseNotify(){
		$data = $this->notificationModel->outPutQcNewCaseNotify();
		echo json_encode($data);
	}
	
	function outPutQcClearComponentErrorNotify(){
		$data = $this->notificationModel->outPutQcClearComponentErrorNotify();
		echo json_encode($data);
	}


	/*new components*/


 	function update_sex_offender_remarks(){
 		 
 		// $data = $this->outPutQcModel->update_sex_offender();
 		 $data = $this->update_sex_offender();
 		echo json_encode($data);
 	}
	
 	function update_politically_exposed_remarks(){
 		 
 		$data = $this->OutPutNewComponents->update_politically_exposed();
 		echo json_encode($data);
 	}

	
 	function update_india_civil_litigation_remarks(){
 		 
 		$data = $this->OutPutNewComponents->update_india_civil_litigation();
 		echo json_encode($data);
 	}

	
 	function update_mca_remarks(){
 		 
 		$data = $this->OutPutNewComponents->update_mca();
 		echo json_encode($data);
 	}

	
 	function update_gsa_remarks(){
 		 
 		$data = $this->OutPutNewComponents->update_gsa();
 		echo json_encode($data);
 	}

	
 	function update_oig_remarks(){
 		 
 		$data = $this->OutPutNewComponents->update_oig();
 		echo json_encode($data);
 	}


	
 	function update_nric_remarks(){
 		 
 		$data = $this->OutPutNewComponents->update_nric();
 		echo json_encode($data);
 	}
	
 	function update_remarks_right_to_work(){
 		 
 		$data = $this->OutPutNewComponents->update_right_to_work();
 		echo json_encode($data);
 	}




	function update_sex_offender(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$sex_offender = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment' => $ouputQcComment
		); 
		// if (count($client_docs) > 0) {
		// 	$sex_offender['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($sex_offender);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('sex_offender',$sex_offender)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('sex_offender');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('sex_offender','candidate_id',$candidate_id,$componentId,$userId);


			// if($analyst_status == '3'){
			// 	$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			// }

			// $isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			// $outpuQcUpdateStatus = '0';
			// if($isOutputQcExists == '0'){
			// 	$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
			// 	if($outpuQcUpdateStatus != '1'){
			// 		$outpuQcUpdateStatus = '0';
			// 	}else{
			// 		$outpuQcUpdateStatus = '1';
			// 	}
			// } 

			$sex_offender['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('sex_offender_log',$sex_offender);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

}	