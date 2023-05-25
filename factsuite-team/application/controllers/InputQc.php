<?php

/**
 * Created 1-2-2021
 */
class InputQc extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');  
	  $this->load->model('inputQcModel');  
	  $this->load->model('emailModel');  
	  $this->load->model('componentModel');
	  $this->load->model('smsModel');
	  $this->load->model('analystModel');
	  $this->load->model('utilModel');
	  $this->load->model('notificationModel');
	  $this->load->model('adminViewAllCaseModel');

	}

	function check_inputqc_login() {
		if(!$this->session->userdata('logged-in-inputqc')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	  function valid_mail(){
	  	$data = $this->inputQcModel->valid_mail();
		echo json_encode($data);
	  }

	function index(){
		$this->check_inputqc_login();
		$data['client'] = $this->clientModel->get_client_details();
		$data['segment'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/segments.json'),true);
		$data['inputqc'] = $this->db->where('role','inputqc')->where('is_Active',1)->get('team_employee')->result_array();

		$data['client_cost_centers'] = $this->clientModel->get_single_client_cost_centers();
		// $data['package'] = $this->packageModel->get_component_name();
		// print_r($data);
		// exit();
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar');
		$this->load->view('inputqc/case/case-common');
		$this->load->view('inputqc/case/add-case',$data);
		$this->load->view('inputqc/inputqc-common/footer');
	}

	function get_single_client_cost_centers() {
		echo json_encode(array('status'=>1,'cost_center_list'=>$this->clientModel->get_single_client_cost_centers()));
	}

	function add_request_form(){
		$data = $this->inputQcModel->add_request_form();
		echo json_encode($data);
	}


	function edit_case($candidate_id){
		$this->check_inputqc_login();
		$data['client'] = $this->clientModel->get_client_details();
		$data['case'] = $this->inputQcModel->get_single_cases_detail($candidate_id);
		$data['package'] = $this->inputQcModel->get_packages($data['case'][0]['client_id']);
		$data['components'] = $this->componentModel->get_component_details();
		$data['component_type'] = $this->componentModel->get_component_type();
		$data['single_client'] = $this->packageModel->get_single_client($data['case'][0]['client_id']);
		$data['country_code_list'] = file_get_contents(base_url().'assets/custom-js/json/country-code.json');
		$data['segment'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/segments.json'),true);
		$data['client_cost_centers'] = $this->clientModel->get_single_client_cost_centers($data['case'][0]['client_id']);
		// print_r($data); 
		// exit();
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar');
		$this->load->view('inputqc/case/case-common');
		$this->load->view('inputqc/case/edit-case',$data);
		$this->load->view('inputqc/inputqc-common/footer');
	}


	function re_edit_case($candidate_id){
		$this->check_inputqc_login();
		$data['client'] = $this->clientModel->get_client_details();
		$data['case'] = $this->inputQcModel->get_single_cases_detail($candidate_id);
		$data['package'] = $this->inputQcModel->get_packages($data['case'][0]['client_id']);
		$data['components'] = $this->componentModel->get_component_details();
		$data['component_type'] = $this->componentModel->get_component_type();
		$data['single_client'] = $this->packageModel->get_single_client($data['case'][0]['client_id']);
		$data['country_code_list'] = file_get_contents(base_url().'assets/custom-js/json/country-code.json');
		$data['segment'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/segments.json'),true);
		$data['client_cost_centers'] = $this->clientModel->get_single_client_cost_centers($data['case'][0]['client_id']);
		// print_r($data); 
		// exit();
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar');
		// $this->load->view('inputqc/case/case-common');
		$this->load->view('inputqc/case/re-edit-case',$data);
		$this->load->view('inputqc/inputqc-common/footer');
	}

	function viewAllCaseList(){
		$this->check_inputqc_login(); 
		$data['case'] = $this->inputQcModel->get_all_cases();
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar');
		$this->load->view('inputqc/case/case-common');
		$this->load->view('inputqc/case/all-case',$data);
		$this->load->view('inputqc/inputqc-common/footer');

	}


	function viewbulkcases(){
		$this->check_inputqc_login(); 
		$data['bulk'] = $this->db->select('client_bulk_uploads.*,tbl_client.client_name')->from('client_bulk_uploads')->join('tbl_client','client_bulk_uploads.uploaded_by = tbl_client.client_id','left')->order_by('client_bulk_uploads.bulk_id','DESC')->get('')->result_array();
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar');
		$this->load->view('inputqc/case/case-common');
		$this->load->view('inputqc/case/view-bulk-cases',$data);
		$this->load->view('inputqc/inputqc-common/footer');

	}
	
	function single_case($candidate_id){
		$data['candidate_id'] = $candidate_id;
		
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar',$data);
		$this->load->view('inputqc/case/case-common',$data);
		$this->load->view('inputqc/case/view-single-case',$data);
		$this->load->view('inputqc/inputqc-common/footer');			
	}

	function assignedCaseList(){

		$this->check_inputqc_login(); 
		$data['selected_datetime_format'] = $this->utilModel->get_curr_date_time_formate();
		$inputQcDatat['userData'] = $this->session->userdata('logged-in-inputqc');
		$data['case'] = $this->inputQcModel->getAllAssignedmanualCases();
		$this->load->view('inputqc/inputqc-common/header',$inputQcDatat);
		$this->load->view('inputqc/inputqc-common/sidebar');
		$this->load->view('inputqc/assigned-case/case-common');
		$this->load->view('inputqc/assigned-case/all-assigned-case',$data);
		$this->load->view('inputqc/inputqc-common/footer');

	}

	function assignedSingleCase($candidate_id){
		$data['candidate_id'] = $candidate_id;
		$candidateInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		$new_case_added_notification = $candidateInfo['new_case_added_notification'];
		$new_case_added_notification = json_decode($new_case_added_notification,true);
		// print_r($new_case_added_notification);
		if($new_case_added_notification['inputQc']=='0'){
			$new_case_added_notification['inputQc'] = '1';
			// print_r($new_case_added_notification);	
			$updatedInfo = array('new_case_added_notification'=>json_encode($new_case_added_notification),'updated_date'=>date('Y-m-d H:i:s'));
			$this->db->where('candidate_id',$candidate_id);
			if($this->db->update('candidate',$updatedInfo)){
				$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
				$this->db->insert('candidate_log',$updatedCandidatInfo);
			}
		}	

		if($candidateInfo['form_filld_notification']=='1'){
			$updatedInfo = array('form_filld_notification'=>'2','updated_date'=>date('Y-m-d H:i:s'));
			$this->db->where('candidate_id',$candidate_id);
			if($this->db->update('candidate',$updatedInfo)){
				$updatedCandidatInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
				$this->db->insert('candidate_log',$updatedCandidatInfo);
			}
		}
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar',$data);
		$this->load->view('inputqc/assigned-case/case-common',$data);
		$this->load->view('inputqc/assigned-case/view-single-assigned-case',$data);
		$this->load->view('inputqc/inputqc-common/footer');			
	}


	function export_excel(){
		$this->check_inputqc_login(); 
		$data['userData'] = $this->session->userdata('logged-in-inputqc');
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar'); 
		$this->load->view('inputqc/case/excel-report',$data); 
		$this->load->view('inputqc/inputqc-common/footer');			
	}


	function getPackage(){
		// $this->check_inputqc_login();
		$data = $this->inputQcModel->getPackage();
		echo json_encode($data);
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

	function updateCase($date=''){ 
		$data = $this->inputQcModel->updateCase($date);
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
		$data = $this->inputQcModel->getAllAssignedCases();
		echo json_encode($data);
	}


	function get_single_case($candidate_id){
		$data = $this->inputQcModel->get_single_case_details($candidate_id);
		echo json_encode($data);
	}

	function getSingleAssignedCaseDetails($randomString){

		$data = $this->inputQcModel->getSingleAssignedCaseDetails($randomString);
		// exit();
		echo json_encode($data);
	}
	
	function getComponentBasedData(){
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		// echo $component_id;
		$table_name = '';
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		if($table_name != ''){
			$data = $this->inputQcModel->getComponentBasedData($candidate_id,$table_name);
			// echo "Data:";
			// print_r($data);
			// exit;
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

 	function import_excel(){
		 // If file uploaded
 		$user = $this->session->userdata('logged-in-inputqc');
            if(!empty($_FILES['files']['name'])) { 
                // get file extension
                $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
 
                if($extension == 'csv'){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } elseif($extension == 'xlsx') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }
                // file path
                $spreadsheet = $reader->load($_FILES['files']['tmp_name']);
                $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                // $lastRow = $spreadsheet->getHighestRow();
                 
                // array Count
                $arrayCount = count($allDataInSheet);
              	$flag = true;
                $i=0;
                $date = date('Y-m-d');
                $inserdata = array();
                foreach ($allDataInSheet as $value) {
                  if($flag){
                    $flag =false;
                    continue;
                } 

                /*client_id
				package_id
				package_name
				component_id
				form_values
				alacarte_components
				package_component*/
                if ($value['G'] !='' && $value['C'] !='') { 
		                $number = $this->inputQcModel->valid_phone_number($value['F']);
		                if ($number['status'] !='0') { 
	 					$team_id = $this->inputQcModel->getMinimumTaskHandlerInputQC();
				                // $inserdata[$i]['client_id'] = $value['A'];
				                $inserdata[$i]['title'] = $value['A'];
				                $inserdata[$i]['first_name'] = $value['B'];
				                $inserdata[$i]['last_name'] = $value['C'];
				                $inserdata[$i]['father_name'] =$value['D'];
				                $inserdata[$i]['phone_number'] =$value['E'];
				                $inserdata[$i]['email_id'] = $value['F']; 
				                $inserdata[$i]['date_of_birth'] = $value['G'];
				                $inserdata[$i]['date_of_joining'] = $value['H'];
				                $inserdata[$i]['employee_id'] = $value['I']; 
				                // $inserdata[$i]['package_name'] = $value['K'];
				                $inserdata[$i]['remark'] = $value['J']; 
				                $inserdata[$i]['document_uploaded_by'] = $value['K'];
				                $inserdata[$i]['excel_upload'] = 1;
				                $inserdata[$i]['assigned_inputqc_id'] = $team_id;
				                $inserdata[$i]['case_added_by_role'] = 'inputqc';
				                $inserdata[$i]['case_added_by_id'] = $user['team_id'];
				                $inserdata[$i]['client_id'] = $this->input->post('client_id');
				                $inserdata[$i]['package_name'] = $this->input->post('package_id');
				                // $inserdata[$i]['package_name'] = $this->input->post('package_name');
				                $inserdata[$i]['component_ids'] = $this->input->post('component_id');
				                $inserdata[$i]['form_values'] = $this->input->post('form_values');
				                $inserdata[$i]['alacarte_components'] = $this->input->post('alacarte_components');
				                $inserdata[$i]['package_components'] = $this->input->post('package_component');
		                }
		            }
                  $i++;
                }  
                /*client_id
package_name
component_ids
alacarte_components
form_values
package_components*/
                	$tempArr = array_unique(array_column($inserdata, 'phone_number'));
					$inserdata_new = array_intersect_key($inserdata, $tempArr);   

	                if (count($inserdata) > 0) {
	                    $data = $this->inputQcModel->insert_bulk_case($inserdata_new);	 
	               		// $data = array('status'=>'1','products'=>$inserdata_new);// 
	                }else{
	                	$data = array('status'=>'0');
	                } 
    

                } else {
                    $data = array('status'=>'0');
                }
           echo json_encode($data); 

	}

	function getMinimumTaskHandlerInputQC(){
		$data = $this->inputQcModel->getMinimumTaskHandlerInputQC();
	}
 	
 	function getMinimumTaskHandlerAnalyst($table_name,$component_id,$priority){
		$data = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,$component_id,$priority);
		echo json_encode($data);
	}

	function get_request_details(){
		$data = $this->inputQcModel->get_request_details();
		echo json_encode($data);
	}

	// function sendMessage(){
	// 	$first_name = $this->input->post('first_name');
	// 	$client_name = $this->input->post('client_name');
	// 	$ph_number = $this->input->post('ph_number');
	// 	$messageStatus = $this->input->post('messageStatus');
	// 	$data  = $this->smsModel->send_sms($first_name,$client_name,$ph_number,$messageStatus);
	// 	echo json_encode($data); 
	// }

	function getMinimumTaskHandler_Insuff_Analyst_Specialist(){
		$table_name= 'court_records' ;
		$component_id = '2';
		$priority = '1';
		$data = $this->inputQcModel-> getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,$component_id,$priority);
		echo json_encode($data);
	} 


	function export_inputqc_excel(){
		$data['components'] = $this->componentModel->get_component_details();
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar',$data); 
		$this->load->view('inputqc/report/inputqc-excel-report',$data);
		$this->load->view('inputqc/inputqc-common/footer');		
	}

	function getNewCaseAssingedNotification(){		
		echo json_encode($this->notificationModel->getNewCaseAssingedNotification());
	}

	function getFormFilledNotification(){		
		echo json_encode($this->notificationModel->getFormFilledNotification());
	}

	function remove_single_cases_detail(){
		$data = $this->inputQcModel->remove_single_cases_detail();
		echo json_encode($data);
	}

	/*new inputqc*/

	function update_candidate_criminal_check(){
		$data = $this->inputQcModel->update_candidate_criminal_check();
		echo json_encode($data);
	}

	function update_candidate_court_record(){
		$data = $this->inputQcModel->update_candidate_court_record();
		echo json_encode($data);
	}

	function update_candidate_document_check(){
		$data = $this->inputQcModel->update_candidate_document_check();
		echo json_encode($data);
	}

	function update_candidate_drug_test(){
		$data = $this->inputQcModel->update_candidate_drug_test();
		echo json_encode($data);
	}
	function update_candidate_global(){
		$data = $this->inputQcModel->update_candidate_global();
		echo json_encode($data);
	}
	function update_candidate_employment(){
		$data = $this->inputQcModel->update_candidate_employment();
		echo json_encode($data);
	}

	function update_candidate_education_details(){
		$data = $this->inputQcModel->update_candidate_education_details();
		echo json_encode($data);
	}

	function update_candidate_present_address(){
		$data = $this->inputQcModel->update_candidate_present_address();
		echo json_encode($data);
	}


	function update_candidate_previous_address(){
		$data = $this->inputQcModel->update_candidate_previous_address();
		echo json_encode($data);
	}


	function update_candidate_previous_employment(){
		$data = $this->inputQcModel->update_candidate_previous_employment();
		echo json_encode($data);
	}


	function update_candidate_reference(){
		$data = $this->inputQcModel->update_candidate_reference();
		echo json_encode($data);
	}


	function update_candidate_address(){
		$data = $this->inputQcModel->update_candidate_address();
		echo json_encode($data);
	}


	function internal_chat(){
		$this->check_inputqc_login();
		$data['title'] = "Internal Chat"; 
		$team = $this->session->userdata('logged-in-inputqc');
		$data['team'] = $this->db->where_not_in('team_id',$team['team_id'])->where('is_Active',1)->get('team_employee')->result_array();  
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar');
		$this->load->view('admin/chat/internal-chat',$data);
		$this->load->view('inputqc/inputqc-common/footer');
	}


	function resume_pending_case($candidate_id){
		$user = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		$this->session->set_userdata('logged-in-candidate',$user);
		 
			$data['user_name'] = strtolower(trim($user['first_name']).'-'.trim($user['last_name']));
			if ($user['is_submitted'] != '3' && $user['case_reinitiate'] !='1') {
				 
				$component_ids = array();
				$redirect = '0';
				$table = $this->utilModel->all_components($user['candidate_id']); 
				foreach (explode(',', $user['component_ids']) as $key => $value) {
					if (!in_array($value,array('14','15','19','21','24'))) { 
						array_push($component_ids,$value);
						$tabl = $this->utilModel->getComponent_or_PageName($value);
						$criminal_checks = explode(',', isset($table[$tabl]['analyst_status'])?$table[$tabl]['analyst_status']:'NA');
						if ($redirect =='0' && in_array('NA', $criminal_checks)) {
							$redirect = $value;
						} 

					}
				}
			 	$this->session->set_userdata('component_ids',implode(',', $component_ids));
			 	$data['is_submitted'] = '1';
			 	$data['redirect_url'] = base_url().'../candidate/factsuite-candidate/candidate-information';
			 	if ($user['personal_information_form_filled_by_candidate_status'] == 1) {
			 		$data['redirect_url'] = base_url().'../candidate/'.$this->utilModel->redirect_url($redirect);
			 	}
			 	$this->session->set_userdata('is_submitted',1);
			} else {

				$table = $this->utilModel->all_components($user['candidate_id']); 
				 $component = explode(',', $user['component_ids']);
				$status = array(); 
				$criminal_checks = explode(',', isset($table['criminal_checks']['analyst_status'])?$table['criminal_checks']['analyst_status']:'NA');
				if (in_array('1',$component)) {  
					if (in_array('3', $criminal_checks) || in_array('NA', $criminal_checks)) {
						array_push($status,1);
					} 
				}
				$court_records = explode(',', isset($table['court_records']['analyst_status'])?$table['court_records']['analyst_status']:'NA');
				if (in_array('2',$component)) { 
					if (in_array('3', $court_records) || in_array('NA', $court_records)) {
						array_push($status,2);
					}
				}
				$document_check = explode(',', isset($table['document_check']['analyst_status'])?$table['document_check']['analyst_status']:'NA');
				if (in_array('3',$component)) { 
					if (in_array('3', $document_check) || in_array('NA', $document_check)) {
						array_push($status,3);
					}
				}
				$drugtest = explode(',', isset($table['drugtest']['analyst_status'])?$table['drugtest']['analyst_status']:'NA');
				if (in_array('4',$component)) { 
					if (in_array('3', $drugtest) || in_array('NA', $drugtest)) {
						array_push($status,4);
					} 
				} 
				$globaldatabase = explode(',', isset($table['globaldatabase']['analyst_status'])?$table['globaldatabase']['analyst_status']:'NA');
				if (in_array('5',$component)) { 
					if (in_array('3', $globaldatabase) || in_array('NA', $globaldatabase)) {
						array_push($status,5);
					}
				}
 				$current_employment = explode(',', isset($table['current_employment']['analyst_status'])?$table['current_employment']['analyst_status']:'NA');
				if (in_array('6',$component)) { 
					if (in_array('3', $current_employment) || in_array('NA', $current_employment)) {
						array_push($status,6);
					}
				}
				$education_details = explode(',', isset($table['education_details']['analyst_status'])?$table['education_details']['analyst_status']:'NA');
				if (in_array('7',$component)) { 
					if (in_array('3', $education_details) || in_array('NA', $education_details)) {
						array_push($status,7);
					} 
				} 
				$present_address = explode(',', isset($table['present_address']['analyst_status'])?$table['present_address']['analyst_status']:'NA');
				if (in_array('8',$component)) { 
					if (in_array('3', $present_address) || in_array('NA', $present_address)) {
						array_push($status,8);
					}
				}
				$permanent_address = explode(',', isset($table['permanent_address']['analyst_status'])?$table['permanent_address']['analyst_status']:'NA');
				if (in_array('9',$component)) { 
					if (in_array('3', $permanent_address) || in_array('NA', $permanent_address)) {
						array_push($status,9);
					}
				}
				$previous_employment = explode(',', isset($table['previous_employment']['analyst_status'])?$table['previous_employment']['analyst_status']:'NA');
				if (in_array('10',$component)) { 
					if (in_array('3', $previous_employment) || in_array('NA', $previous_employment)) {
						array_push($status,10);
					}
				}
				$reference = explode(',', isset($table['reference']['analyst_status'])?$table['reference']['analyst_status']:'NA');
				if (in_array('11',$component)) { 
					if (in_array('3', $reference) || in_array('NA', $reference)) {
						array_push($status,11);
					}
				}
				$previous_address = explode(',', isset($table['previous_address']['analyst_status'])?$table['previous_address']['analyst_status']:'NA');
				if (in_array('12',$component)) { 
					if (in_array('3', $previous_address) || in_array('NA', $previous_address)) {
						array_push($status,12);
					}
				}
				$driving_licence = explode(',', isset($table['driving_licence']['analyst_status'])?$table['driving_licence']['analyst_status']:'NA');
				if (in_array('16',$component)) { 
					if (in_array('3', $driving_licence) || in_array('NA', $driving_licence)) {
						array_push($status,16);
					}
				}

				$cv_check = explode(',', isset($table['cv_check']['analyst_status'])?$table['cv_check']['analyst_status']:'NA');
				if (in_array('20',$component)) { 
					if (in_array('3', $cv_check) || in_array('NA', $cv_check)) {
						array_push($status,20);
					}
				}

				$gap_check = explode(',', isset($table['employment_gap_check']['analyst_status'])?$table['employment_gap_check']['analyst_status']:'NA');
				if (in_array('20',$component)) { 
					if (in_array('3', $gap_check) || in_array('NA', $gap_check)) {
						array_push($status,22);
					}
				}

				$credit_cibil = explode(',', isset($table['credit_cibil']['analyst_status'])?$table['credit_cibil']['analyst_status']:'NA');
				if (in_array('17',$component)) { 
					if (in_array('3', $credit_cibil) || in_array('NA', $credit_cibil)) {
						array_push($status,17);
					}
				}
				$bankruptcy = explode(',', isset($table['bankruptcy']['analyst_status'])?$table['bankruptcy']['analyst_status']:'NA');
				if (in_array('18',$component)) { 
					if (in_array('3', $bankruptcy) || in_array('NA', $bankruptcy)) {
						array_push($status,18);
					} 
				} 

				$bankruptcy = explode(',', isset($table['bankruptcy']['analyst_status'])?$table['bankruptcy']['analyst_status']:'NA');
				if (in_array('18',$component)) { 
					if (in_array('3', $bankruptcy) || in_array('NA', $bankruptcy)) {
						array_push($status,18);
					} 
				} 

				$landload_reference = explode(',', isset($table['landload_reference']['analyst_status'])?$table['bankruptcy']['analyst_status']:'NA');
				if (in_array('18',$component)) { 
					if (in_array('3', $landload_reference) || in_array('NA', $landload_reference)) {
						array_push($status,23);
					} 
				} 

				$social_media = explode(',', isset($table['social_media']['analyst_status'])?$table['social_media']['analyst_status']:'NA');
				if (in_array('18',$component)) { 
					if (in_array('3', $social_media) || in_array('NA', $social_media)) {
						array_push($status,25);
					} 
				} 

				$civil_check = explode(',', isset($table['civil_check']['analyst_status'])?$table['civil_check']['analyst_status']:'NA');
				if (in_array('18',$component)) { 
					if (in_array('3', $civil_check) || in_array('NA', $civil_check)) {
						array_push($status,26);
					} 
				} 
				sort($status);
				$this->session->set_userdata('component_ids',implode(',', $status));
				$this->session->set_userdata('is_submitted',3);
				$data['is_submitted'] = '3';
				 
				$data['redirect_url'] = base_url().'../candidate/'.$this->utilModel->redirect_url(isset($status[0])?$status[0]:0);
			}	
			$this->session->set_userdata('candidate_details_submitted_by','inputqc'); 
			redirect($data['redirect_url']);
		 
		 
	}

	/* new code for the credit cibil*/

	function update_candidate_credit_cibil(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_credit_cibil();
		echo json_encode($data);
	}

	function update_candidate_driving_licence(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_driving_licence();
		echo json_encode($data);
	}

	function update_candidate_civil_check(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_civil_check();
		echo json_encode($data);
	}

	function update_candidate_sex_offender(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_sex_offender();
		echo json_encode($data);
	}
	function update_candidate_politically_exposed(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_politically_exposed();
		echo json_encode($data);
	}
	function update_candidate_india_civil_litigation(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_india_civil_litigation();
		echo json_encode($data);
	}
	function update_candidate_gsa(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_gsa();
		echo json_encode($data);
	}
	function update_candidate_oig(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_oig();
		echo json_encode($data);
	}
	function update_candidate_mca(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_mca();
		echo json_encode($data);
	}
	function update_candidate_right_to_work(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_right_to_work();
		echo json_encode($data);
	}
	function update_candidate_nric(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_nric();
		echo json_encode($data);
	}

	function update_candidate_bankruptcy(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_bankruptcy();
		echo json_encode($data);
	}
	function update_candidate_landload_reference(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_landload_reference();
		echo json_encode($data);
	}
	function update_candidate_social_media(){
		$this->check_inputqc_login();
		$data = $this->inputQcModel->update_candidate_social_media();
		echo json_encode($data);
	}
 
}