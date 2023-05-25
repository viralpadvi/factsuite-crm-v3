<?php
/**
 * 
 */
class Main_Client_Controller extends CI_Controller
{
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('caseModel');  
	  $this->load->model('utilModel');  
	  $this->load->model('loginModel');  
	  $this->load->model('emailModel');  
	  $this->load->model('AdminViewAllCaseModel');  
	  $this->load->model('client_Analytics_Model');
	  $this->load->model('utilModel');
	}

	function check_admin_login() {
		if(!$this->session->userdata('logged-in-client')) {
			redirect($this->config->item('my_base_url').'clientLogin');
		}
	}

	function index(){
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('login');
		} else {
			$this->load->view('login-v2');
		}
	}


	function forgot_password(){
		$this->load->view('forgot-password');
	}

	function sidebar_toggle() {
		if (!$this->session->userdata('sidebar-toggle')) {
			$this->session->set_userdata('sidebar-toggle','sidebar-collapse');
		} else {
			$this->session->unset_userdata('sidebar-toggle');
		}
	}

	function reset_password($email_id,$encoded_date){
		if(isset($email_id) && $email_id != '' && isset($encoded_date) && $encoded_date != '') {
				$reset_password_user = $this->session->userdata('reset-password-user');

				$variable_array = array(
					'email_id' => $email_id,
					'encoded_date' => $encoded_date
				);
				$check_details_for_reset_password = $this->check_input_details_for_reset_password($variable_array);
				if($check_details_for_reset_password['status'] == 1 && $check_details_for_reset_password['verify'] != '') {
					$current_date_time = new DateTime();
					$reset_password_time = new DateTime($check_details_for_reset_password['verify']['reset_password_date']);

					$diff = $current_date_time->diff($reset_password_time);

					if((($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i) < 10) {
						$data['email_id'] = $email_id;
						$data['encoded_date'] = $encoded_date;
						if($this->config->item('live_ui_version') == 1) {
							$this->load->view('reset-password',$data);
						} else {
							$this->load->view('reset-password-v2',$data);
						}
					} else {
						echo "<h6>Invalid Request</h6>";	
					}
				}
		
	}

}


		function check_input_details_for_reset_password($variable_array) {
			if ($variable_array != '') {
				return array('status'=>'1','verify'=>$this->loginModel->check_input_details_for_reset_password($variable_array));
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		}



		function verify_forgot_password_email_id() {
			if (isset($_POST) && $this->input->post('verify_user_request') == '1') {
				echo json_encode(array('status'=>'1','verify'=>$this->loginModel->verify_forgot_password_email_id()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function verify_and_reset_password() {
			if (isset($_POST) && $this->input->post('verify_user_request') == '1' && $this->input->post('email_id') != '' && $this->input->post('encoded_date') != '') {
				$variable_array = array(
					'email_id' => $this->input->post('email_id'),
					'encoded_date' => $this->input->post('encoded_date')
				);
				echo json_encode(array('status'=>'1','reset'=>$this->loginModel->verify_and_reset_password($variable_array)));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}


	function home() {
		// echo "welcome";
		$this->check_admin_login();
		$user = $this->session->userdata('logged-in-client');
		// $data['case'] = $this->caseModel->get_all_cases();
		$data['inventry'] = $this->client_Analytics_Model->get_all_client_wise_inventory_cases();
		$data['total'] = $this->client_Analytics_Model->total_report_count();
		$data['report'] = $this->client_Analytics_Model->all_report_counts();
		$data['client'] = $this->client_Analytics_Model->get_all_clients();
		$data['noman'] = $this->db->where('client_id',$user['client_id'])->order_by('nomenclature_id','DESC')->get('client_nomanclature')->row_array();
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar');
			$this->load->view('dashboard/dashboard',$data);
			$this->load->view('client-common/footer');
		} else {
			if ($this->config->item('dashboard_ui') == 'apex-chart') {
				$this->load->view('client-common/header-v2');
				$this->load->view('client-common/sidebar-v2');
				$this->load->view('dashboard/apex-chart-dashboard-v2',$data);
				$this->load->view('client-common/footer-v2');
			} else {
				$this->load->view('client-common/header-v2');
				$this->load->view('client-common/sidebar-v2');
				$this->load->view('dashboard/dashboard-v2',$data);
				$this->load->view('client-common/footer-v2');
			}
		}
	}

	function add_case(){
		$this->check_admin_login();
		if($this->config->item('live_ui_version') == 2) {
			redirect($this->config->item('my_base_url').'factsuite-client/all-cases');
			return false;
		}
		$data['single_client'] = $this->caseModel->get_single_client_data();
		$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar');
		$this->load->view('client/case/case-common');
		$this->load->view('client/case/add-case',$data);
		$this->load->view('client-common/footer');		
	}
	
	
	function bulk_upload(){
		$this->check_admin_login();
		 
		$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar');
		$this->load->view('client/case/case-common');
		$this->load->view('client/case/bulk-upload');
		$this->load->view('client-common/footer');		
	}
	
	
	function candidate_mis_report(){
		$this->check_admin_login();
		$data['client'] = $this->client_Analytics_Model->get_all_clients();
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar'); 
			$this->load->view('client/report/common-mis');
			$this->load->view('client/report/mis-report',$data);
			$this->load->view('client-common/footer');
		} else {
			$this->load->view('client-common/header-v2');
			$this->load->view('client-common/sidebar-v2');
			$this->load->view('client/report/report-header-2');
			$this->load->view('client/report/mis-report-2',$data);
			$this->load->view('client-common/footer-v2');
		}
	}
	
	
	function candidate_insuff_report(){
		$this->check_admin_login();
		$data['client'] = $this->client_Analytics_Model->get_all_clients();
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar');
			$this->load->view('client/case/case-common');
			$this->load->view('client/report/common-mis');
			$this->load->view('client/report/insuff-report',$data);
			$this->load->view('client-common/footer');
		} else {
			$this->load->view('client-common/header-v2');
			$this->load->view('client-common/sidebar-v2');
			$this->load->view('client/report/report-header-2');
			$this->load->view('client/report/insuff-report-2',$data);
			$this->load->view('client-common/footer-v2');
		}
	}
		
	function candidate_clear_insuff_report(){
		$this->check_admin_login();
		$data['client'] = $this->client_Analytics_Model->get_all_clients();
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar');
			$this->load->view('client/case/case-common');
			$this->load->view('client/report/common-mis');
			$this->load->view('client/report/insuff-clear-report',$data);
			$this->load->view('client-common/footer');
		} else {
			$this->load->view('client-common/header-v2');
			$this->load->view('client-common/sidebar-v2');
			$this->load->view('client/report/report-header-2');
			$this->load->view('client/report/insuff-clear-report-2',$data);
			$this->load->view('client-common/footer-v2');
		}	
	}
	
	
	function bulk_upload_view(){
		$this->check_admin_login();
		$client_id = $this->session->userdata('logged-in-client');
			$this->db->where('uploaded_by',$client_id['client_id']);
		$data['bulk'] = $this->db->select('client_bulk_uploads.*,tbl_client.client_name')->from('client_bulk_uploads')->join('tbl_client','client_bulk_uploads.uploaded_by = tbl_client.client_id','left')->order_by('client_bulk_uploads.bulk_id','DESC')->get('')->result_array();
		$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar');
		$this->load->view('client/case/case-common');
		$this->load->view('client/case/view-bulk-upload',$data);
		$this->load->view('client-common/footer');		
	}

	function get_all_bulk_uploads() {
		if($this->session->userdata('logged-in-client') && isset($_POST) && $this->input->post('verify_client_request') == 1) {
			$client_id = $this->session->userdata('logged-in-client');
			$this->db->where('uploaded_by',$client_id['client_id']);
			echo json_encode(array('status'=>'1','bulk' => $this->db->select('client_bulk_uploads.*,tbl_client.client_name')->join('tbl_client','client_bulk_uploads.uploaded_by = tbl_client.client_id','left')->order_by('client_bulk_uploads.bulk_id','DESC')->get('client_bulk_uploads')->result_array()));
		} else {
			return array('status'=>0,'message'=>'Invalid Request.');
		}
	}

	function view_all_cases() {
		if($this->session->userdata('logged-in-client') && isset($_POST) && $this->input->post('verify_client_request') == 1) {
			echo json_encode(array('status'=>'1','case' => $this->caseModel->get_all_cases()));
		} else {
			return array('status'=>0,'message'=>'Invalid Request.');
		}
	}

	function get_all_cases() {
		if($this->session->userdata('logged-in-client') && isset($_POST) && $this->input->post('verify_client_request') == 1) {
			$client_id = $this->session->userdata('logged-in-client');
			$this->db->where('uploaded_by',$client_id['client_id']);
			echo json_encode(array('status'=>'1','bulk' => $this->db->select('client_bulk_uploads.*,tbl_client.client_name')->join('tbl_client','client_bulk_uploads.uploaded_by = tbl_client.client_id','left')->order_by('client_bulk_uploads.bulk_id','DESC')->get('client_bulk_uploads')->result_array()));
		} else {
			return array('status'=>0,'message'=>'Invalid Request.');
		}
	}
	
	
	function finance_summary(){
		$this->check_admin_login();
		$user = $this->session->userdata('logged-in-client');
		$data['finance'] = $this->db->where('client',$user['client_name'])->where('finance_status',1)->order_by('summary_id','DESC')->get('finance_summary')->result_array(); 
		$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar');
		$this->load->view('client/finance/saved-summary',$data);
		$this->load->view('client-common/footer');		
	}
	
	function finance_summary_cases(){
		$this->check_admin_login();
		$user = $this->session->userdata('logged-in-client');
		$data['finance'] = $this->db->where('client',$user['client_name'])->where('finance_status',1)->order_by('summary_id','DESC')->get('finance_summary')->result_array(); 
		$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar');
		$this->load->view('client/finance/print-all-cases',$data);
		$this->load->view('client-common/footer');		
	}
	
	function edit_case($candidate_id=''){
		$this->check_admin_login();
		if ($candidate_id =='') {
			$candidate_id = $this->input->get('candidate_id');
		}
		$data['case'] = $this->caseModel->get_single_case($candidate_id);
		$data['components'] = $this->caseModel->get_component_details();  
		$data['package'] = $this->caseModel->get_packages(); 
		$data['component_type'] = $this->caseModel->get_component_type();
		$data['single_client'] = $this->caseModel->get_single_client_data();
		$data['candidate_id'] = $candidate_id;
		$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar');
		$this->load->view('client/case/case-common');
		$this->load->view('client/case/edit-case',$data);
		$this->load->view('client-common/footer');		
	}

	function get_single_case_details() {
		if($this->session->userdata('logged-in-client') && isset($_POST) && $this->input->post('verify_client_request') == 1) {
			 
			echo json_encode(array('status'=>'1','case_details' => $this->caseModel->get_single_case($this->input->post('candidate_id')),'package'=>$this->caseModel->get_packages(),'country_code_list'=>$this->utilModel->get_country_code_list()));
		} else {
			return array('status'=>0,'message'=>'Invalid Request.');
		}
	}

	function all_cases() {
		$this->check_admin_login();
		$segment = file_get_contents(base_url().'assets/custom-js/json/segments.json'); 
		if($this->config->item('live_ui_version') == 1) {
			$data['case'] = $this->caseModel->get_all_cases();
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar');
			$this->load->view('client/case/case-common');
			$this->load->view('client/case/all-case',$data);
			$this->load->view('client-common/footer');
		} else {
			$data['single_client'] = $this->caseModel->get_single_client_data();
			$data['client_cost_centers'] = $this->caseModel->get_single_client_cost_centers();
			$data['segment'] = json_decode($segment,true);
			$data['filter_numbers'] = $this->utilModel->get_custom_filter_number_list_v2();
			$this->load->view('client-common/header-v2');
			$this->load->view('client-common/sidebar-v2');
			// $this->load->view('client/case/case-common');
			$this->load->view('client/case/cases-v2',$data);
			$this->load->view('client-common/footer-v2');
		}			
	} 

	function insuff_cases() {
		$this->check_admin_login();
		$segment = file_get_contents(base_url().'assets/custom-js/json/segments.json'); 
		$data['single_client'] = $this->caseModel->get_single_client_data();
		$data['segment'] = json_decode($segment,true);
		$data['filter_numbers'] = $this->utilModel->get_custom_filter_number_list_v2();
		$this->load->view('client-common/header-v2');
		$this->load->view('client-common/sidebar-v2');
		$this->load->view('client/case/insuff-cases-v2',$data);
		$this->load->view('client-common/footer-v2');	
	}

	function client_clarification_cases() {
		$this->check_admin_login();
		$segment = file_get_contents(base_url().'assets/custom-js/json/segments.json'); 
		$data['single_client'] = $this->caseModel->get_single_client_data();
		$data['segment'] = json_decode($segment,true);
		$data['filter_numbers'] = $this->utilModel->get_custom_filter_number_list_v2();
		$this->load->view('client-common/header-v2');
		$this->load->view('client-common/sidebar-v2');
		$this->load->view('client/case/client-clarification-cases-v2',$data);
		$this->load->view('client-common/footer-v2');	
	}

	function client_timezone(){
		$this->check_admin_login();
		$form_data = file_get_contents(base_url().'../factsuite-team/assets/custom-js/json/timezone.json'); 
		$data['timezone'] = json_decode($form_data,true);
		$data['setting'] = $this->caseModel->get_timezone();
		$this->load->view('client-common/header-v2');
		$this->load->view('client-common/sidebar-v2');
		// $this->load->view('client/case/case-common');
		$this->load->view('client/client-setting',$data);
		$this->load->view('client-common/footer-v2');		
	}


	function completed_cases(){
		$this->check_admin_login();
		$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar');
		$this->load->view('client/case/case-common');
		$this->load->view('client/case/all-case');
		$this->load->view('client-common/footer');			
	}

	function single_case($candidate_id='') {
		$this->check_admin_login();
		if ($candidate_id =='') {
			$candidate_id = $this->input->get('candidate_id');
		}
		$data['candidate_id'] = $candidate_id;
		$client_details = $this->session->userdata('logged-in-client');

		$client = $this->session->userdata('logged-in-client');
		$user = $this->session->userdata('logged-in-client');
		$client_ids = array();
	 		if ($user['is_master'] =='0') { 
			$datas = $this->caseModel->get_all_clients(); 
			array_push($client_ids,$datas['parent']['client_id']);
			if (count($datas['child']) > 0) {
				foreach ($datas['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}

			}else{
				array_push($client_ids,$user['client_id']);
			} 
		
		$where_condition = array(
			'candidate_id' => $candidate_id,
			// 'client_id' => $client_details['client_id']
		);
		$candidateInfo = $this->db->where($where_condition)->where_in('client_id',$client_ids)->get('candidate')->row_array();
		if ($candidateInfo != '') {
			$data['single_client'] = $this->caseModel->get_single_client_data();
			$new_case_added_notification = $candidateInfo['new_case_added_notification'];
			$new_case_added_notification = json_decode($new_case_added_notification,true);
			// print_r($new_case_added_notification);
			if($new_case_added_notification['client']=='0'){
				$new_case_added_notification['client'] = '1';
				// print_r($new_case_added_notification);	
				$updatedInfo = array('new_case_added_notification'=>json_encode($new_case_added_notification),'updated_date'=>date('Y-m-d H:i:s'));
				$this->db->where('candidate_id',$candidate_id);
				if($this->db->update('candidate',$updatedInfo)){
					$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
					$this->db->insert('candidate_log',$updatedCandidatInfo);
				}
			}

			if($candidateInfo['case_complated_client_notification']=='1'){
				$updatedInfo = array('case_complated_client_notification'=>'2','updated_date'=>date('Y-m-d H:i:s'));
			$where_array = array(
				'candidate_id'=>$candidate_id,
				'client_spoc_id'=>$client_details['spoc_id'],
				'client_id'=>$client_details['client_id'],
				'notification_status'=>1,
				'notification_type_id'=>2,
			);
				$result = $this->caseModel->new_clear_candidate_notification($where_array);

				if ($result == 0) {  
				$this->db->where('candidate_id',$candidate_id);
				if($this->db->update('candidate',$updatedInfo)){
					$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
					$this->db->insert('candidate_log',$updatedCandidatInfo);
				}

			}
			
			} 

			if($candidateInfo['case_insuff_client_notification']=='1'){
				$updatedInfo = array('case_insuff_client_notification'=>'2','updated_date'=>date('Y-m-d H:i:s'));
				$this->db->where('candidate_id',$candidate_id);
				$where_array = array(
				'candidate_id'=>$candidate_id,
				'client_spoc_id'=>$client_details['spoc_id'],
				'client_id'=>$client_details['client_id'],
				'notification_status'=>1,
				'notification_type_id'=>1,
			);
				$result = $this->caseModel->new_clear_candidate_notification($where_array);
				if ($result == 0) { 
				if($this->db->update('candidate',$updatedInfo)){
					$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
					$this->db->insert('candidate_log',$updatedCandidatInfo);
				}
				}
			} 

			if($candidateInfo['client_case_intrim_notification']=='1'){
				$updatedInfo = array('client_case_intrim_notification'=>'2','updated_date'=>date('Y-m-d H:i:s'));
				$this->db->where('candidate_id',$candidate_id);
				if($this->db->update('candidate',$updatedInfo)){
					$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
					$this->db->insert('candidate_log',$updatedCandidatInfo);
				}
			}
		} 


		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar',$data);
			$this->load->view('client/case/case-common',$data);
			$this->load->view('client/case/view-single-case',$data);
			$this->load->view('client-common/footer');
		} else {
			$this->load->view('client-common/header-v2');
			$this->load->view('client-common/sidebar-v2',$data);
			// $this->load->view('client/case/case-common');
			if ($candidateInfo != '') {
				$this->load->view('client/case/view-single-case-v2',$data);
			} else {
				$this->load->view('404-candidate-not-found');
			}
			$this->load->view('client-common/footer-v2');
		}
	}

	function htmlGenrateReport($candidate_id){ 
		$this->check_admin_login();
		$data['candidate_data']=$this->candidateReportData($candidate_id);
		$data['candidate']=$this->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->caseModel->all_components($candidate_id);
		$data['candidate_status'] = $this->caseModel->getSingleAssignedCaseDetail_s($candidate_id);
		/*$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar',$data);
		$this->load->view('client/case/case-common',$data);*/
		
		// $this->load->view('client-common/footer');		
			// Use the below for new Report UI
		if ($this->config->item('production') ==1) { 
		$this->load->view('client/report/generate_final_report',$data);
		}else{
		$this->load->view('client/report/generate-final-report-v3',$data); 	
		}
	}

	function htmlGenratePDFReport($candidate_id){ 
		$this->check_admin_login();
		$data['candidate']=$this->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->caseModel->all_components($candidate_id);
		$data['candidate_status'] = $this->caseModel->getSingleAssignedCaseDetail_s($candidate_id);
		/*$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar',$data);
		$this->load->view('client/case/case-common',$data);*/
		// $this->load->view('client/report/success_pdf_report',$data);
		
		// $this->load->view('client-common/footer');

			// Use the below for new Report UI
		if ($this->config->item('production') ==1) { 
		$this->load->view('client/report/generate-interim-report',$data);
		}else{
		$this->load->view('client/report/generate-interim-report-v3',$data); 	
		}		
	}

	// Report Genration 
	function candidateReportData($candidate_id){
		$reportData = array();
		$candidaetData = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
 		$candidateInfo= array('candidaetData' => $candidaetData);
		$componentId = explode(",",$candidaetData['component_ids']);
		array_push($reportData,$candidateInfo);
		foreach ($componentId as $key => $componentValue) {
					
			array_push($reportData, $this->getComponentData1($candidate_id,$componentValue) );

		}

		return $reportData;
	}
	 
	function getComponentData1($candidate_id ='',$component_id = '',$status=''){ 
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		 
		  
		$result = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
		if($status == ''){
			return $result = array($table_name => $result);
		}else if($status == '2'){
			return $result;
		}else{
			 
			$ComponentStatus = ['4','6','7','9'];

			// print_r($tmp);
			$analyst_status = isset($result['analyst_status'])?$result['analyst_status']:'0'; 
			if(in_array($analyst_status, $ComponentStatus)){

				return '1';

			}else{
				return '0';
			}


		}
		
		
		 
	}

	function selected_cases($param=''){
		// urldecode(base64_decode($param));
		$user = $this->session->userdata('logged-in-client');
		if ($param =='') {
			$param = $this->input->get('param');
		}
		$candidate_ids = $this->client_Analytics_Model->identify_reports($param); 
		$this->check_admin_login();
		if (count($candidate_ids['ids']) > 0) { 
			$data['case'] = $this->caseModel->get_selected_all_cases($candidate_ids['ids']);
		}else{
			$data['case'] = array();	
		}

		$data['title'] = $candidate_ids['color'];
		$data['status'] = $param;
		$data['noman'] = $this->db->where('client_id',$user['client_id'])->order_by('nomenclature_id','DESC')->get('client_nomanclature')->row_array();
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar');
			// $this->load->view('client/case/case-common');
			$this->load->view('client/case/selected-all-case',$data);
			$this->load->view('client-common/footer');
		} else {
			$this->load->view('client-common/header-v2');
			$this->load->view('client-common/sidebar-v2');
			$this->load->view('client/case/colored-case-list-status-wise-2',$data);
			$this->load->view('client-common/footer-v2');
		}	
	} 
	 

	function status_wise_cases($param='') {
		if ($param =='') {
			$param = $this->input->get('param');
		}
		$user = $this->session->userdata('logged-in-client');
		$data['case'] = $this->caseModel->get_selected_status_all_cases($param);
		$data['title'] = 'Cases';
		$data['status'] = $param;
		$data['noman'] = $this->db->where('client_id',$user['client_id'])->order_by('nomenclature_id','DESC')->get('client_nomanclature')->row_array();
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar');
			// $this->load->view('client/case/case-common');
			$this->load->view('client/case/status-all-case',$data);
			$this->load->view('client-common/footer');
		} else {
			$this->load->view('client-common/header-v2');
			$this->load->view('client-common/sidebar-v2');
			$this->load->view('client/case/case-list-status-wise-2',$data);
			$this->load->view('client-common/footer-v2');
		}	
	}

	function documentation() {
		$this->check_admin_login();
		if($this->config->item('live_ui_version') == 1) {
			$this->load->view('client-common/header');
			$this->load->view('client-common/sidebar'); 
			$this->load->view('client/report/common-mis');
			$this->load->view('client/report/mis-report');
			$this->load->view('client-common/footer');
		} else {
			$this->load->view('client-common/header-v2');
			$this->load->view('client-common/sidebar-v2');
			$this->load->view('client/documentation/documentation-2');
			$this->load->view('client-common/footer-v2');
		}
	}

	function getComponentData($candidate_id ='',$component_id = ''){ 
		$table_name = '';
		 
		switch ($component_id) {
			
			case '1':
				$table_name = 'criminal_checks';
				
				break;

			case '2':
				$table_name = 'court_records';
				
				break;
			case '3':
				$table_name = 'document_check';
				break;

			case '4':
				$table_name = 'drugtest';
				break;

			case '5':
				$table_name = 'globaldatabase';
				break;

			case '6':
				$table_name = 'current_employment';
				break; 
			case '7':
				$table_name = 'education_details';
				break; 
			case '8':
				$table_name = 'present_address';
				break; 
			case '9':
				$table_name = 'permanent_address';
				break; 
			case '10':
				$table_name = 'previous_employment';
				break; 
			case '11':
				$table_name = 'reference';
				break; 
			case '12':
				$table_name = 'previous_address';
			default:
				 
				break;
		}
	}


}