<?php
/**
 * 01-02-2021	
 */
class OutPutQcModel extends CI_Model
{

	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url');    
	  $this->load->model('emailModel');     
	  $this->load->model('smsModel');
	} 

	function getPackgeDetail() {
		$result =  $this->db->where('package_status',1)->where('package_id',$this->input->post('id'))->get('packages')->row_array();
		 
		$component_names = array();  
		$comp_name = array();
		$fs_website_component_name = array();
		$row['package_name'] = $result['package_name'];
		$row['package_id'] = $result['package_id'];
		$row['package_status'] = $result['package_status'];
		$component_ids = explode(',', $result['component_ids']);
		$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();

		foreach ($component as $key1 => $com) {
			array_push($comp_name, $com['component_name']);
			array_push($fs_website_component_name, $com['fs_website_component_name']);
		}
		 
		$row['component_ids'] =  $component_ids;
		$row['component_name'] =  $comp_name;
		$row['fs_website_component_name'] =  $fs_website_component_name;
		array_push($component_names, $row);
		 
		return $component_names;
	}
 
	function all_components($candidate_id) { 
		$table = array('criminal_checks','court_records','document_check','drugtest','globaldatabase','current_employment','education_details','present_address','permanent_address','previous_employment','reference','previous_address','cv_check','driving_licence','credit_cibil','bankruptcy','directorship_check','global_sanctions_aml','adverse_database_media_check','health_checkup','employment_gap_check','landload_reference','covid_19','social_media','civil_check','right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig');
		$table_data = array(); 
		$candidate = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		$skills = explode(',', $candidate['component_ids']);
		$table_data = array(); 
		foreach ($table as $key => $value) {
			$id = $this->utilModel->getComponentId($value);
			if (in_array($id,$skills)) { 
			$table_data[$value] = $this->db->where('candidate_id',$candidate_id)->get($value)->row_array(); 
			}
		}

		return $table_data; 
	}

	function getPackage() {
		$resultClient = $this->db->where('active_status',1)->where('client_id',$this->input->post('clinet_id'))->get('tbl_client')->row_array();
		 
		$package_name_array = array();
		$pkg_name_array = array();
		$package_ids = explode(',', $resultClient['packages']); 
		$package_name = $this->db->where('package_status',1)->where_in('package_id',$package_ids)->get('packages')->result_array();
 
		foreach ($package_name as $key => $package) {
			array_push($pkg_name_array, $package['package_name']);
		} 
		$row['package_name'] = $pkg_name_array;
		$row['package_ids'] = $package_ids;
		array_push($package_name_array, $row);
		return $package_name_array; 
	}

	function get_all_cases() {
		$outputqc_info = $this->session->userdata('logged-in-outputqc'); 
		return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('case_added_by_role','inputqc')->get()->result_array();
	}

	function getAllAssignedCases() {
		$outputqc_info = $this->session->userdata('logged-in-outputqc');
		if($outputqc_info != null){
			return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('candidate.assigned_outputqc_id',$outputqc_info['team_id'])->get()->result_array();
		}else{
			return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->result_array();
		}
		
		// ->where('is_submitted','1')
	}

	function getAllAssignedCases_() {
		$outputqc_info = $this->session->userdata('logged-in-outputqc');
		$candidateData = array();
		if($outputqc_info != null){
			$candidateData =  $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('candidate.assigned_outputqc_id',$outputqc_info['team_id'])->get()->result_array();
		}else{
			$candidateData =  $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->result_array();
		}
		
		$data= array();
		if(count($candidateData) > 0) {
			foreach ($candidateData as $key => $candidateValue) {
				$row['candidate'] = $candidateValue;

				if($candidateValue['tat_start_date'] != null && $candidateValue['report_generated_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != '' && $candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
						$start_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
				 
					$restart_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_re_start_date'],$candidateValue['report_generated_date']);
				 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != '' && $candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0;
					 
						$restart_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_re_start_date'],$candidateValue['report_generated_date']);
					 
					 
						$start_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
					 
						$start_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_start_date'] != ''){
						if ($candidateValue['report_generated_date'] !='' && $candidateValue['report_generated_date'] !=null) { 
						$row['left_tat_days'] = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['report_generated_date']).' days';
					}else{
						$row['left_tat_days'] = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],date('d-m-Y')).' days';	
					}
					 
				}else{
					$row['left_tat_days'] = '-';
					$row['tat_overdue'] = '-';
				}

				$row['client'] = $this->adminViewAllCaseModel->getClientData($candidateValue['client_id']); 
				$row['inputQc'] = $this->adminViewAllCaseModel->getTeamData(isset($candidateValue['assigned_inputqc_id'])?$candidateValue['assigned_inputqc_id']:0); 
				$row['outputQc'] = $this->adminViewAllCaseModel->getTeamData(isset($candidateValue['assigned_outputqc_id'])?$candidateValue['assigned_outputqc_id']:0);
				$row['package'] = $this->adminViewAllCaseModel->getPackageData($candidateValue['package_name']);
				$row['override_inputqc'] = $this->adminViewAllCaseModel->getTeamData('','inputqc'); 
				$row['override_outputqc'] = $this->adminViewAllCaseModel->getTeamData('','outputqc');
				$row['tat'] =  $this->db->get('tat')->row_array();
				array_push($data,$row);
			}
		} 
		return $data; 
	}

	function getAllAssignedCompletedCases() {
		$outputqc_info = $this->session->userdata('logged-in-outputqc');
		if($outputqc_info != null){
			return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('assigned_outputqc_id',$outputqc_info['team_id'])->where('candidate.is_submitted','2')->get()->result_array();
		}else{
			return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('candidate.is_submitted','2')->get()->result_array();
		}
		
		// ->where('is_submitted','1')
	}

	function getAllAssignedCompletedCases_() {
		$outputqc_info = $this->session->userdata('logged-in-outputqc');
		if($outputqc_info != null){
			$candidateData = $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('assigned_outputqc_id',$outputqc_info['team_id'])->where('candidate.is_submitted','2')->get()->result_array();
		}else{
			$candidateData = $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('candidate.is_submitted','2')->get()->result_array();
		}
		
		
		$data= array();
		if(count($candidateData) > 0) {
			foreach ($candidateData as $key => $candidateValue) {
				$row['candidate'] = $candidateValue;

				if($candidateValue['tat_start_date'] != null && $candidateValue['report_generated_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != '' && $candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
						$start_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
				 
					$restart_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_re_start_date'],$candidateValue['report_generated_date']);
				 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != '' && $candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0;
					 
						$restart_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_re_start_date'],$candidateValue['report_generated_date']);
					 
					 
						$start_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
					 
						$start_date = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_start_date'] != ''){
						if ($candidateValue['report_generated_date'] !='' && $candidateValue['report_generated_date'] !=null) { 
						$row['left_tat_days'] = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['report_generated_date']).' days';
					}else{
						$row['left_tat_days'] = $this->adminViewAllCaseModel->number_of_working_days($candidateValue['tat_start_date'],date('d-m-Y')).' days';	
					}
					 
				}else{
					$row['left_tat_days'] = '-';
					$row['tat_overdue'] = '-';
				}

				$row['client'] = $this->adminViewAllCaseModel->getClientData($candidateValue['client_id']); 
				$row['inputQc'] = $this->adminViewAllCaseModel->getTeamData(isset($candidateValue['assigned_inputqc_id'])?$candidateValue['assigned_inputqc_id']:0); 
				$row['outputQc'] = $this->adminViewAllCaseModel->getTeamData(isset($candidateValue['assigned_outputqc_id'])?$candidateValue['assigned_outputqc_id']:0);
				$row['package'] = $this->adminViewAllCaseModel->getPackageData($candidateValue['package_name']);
				$row['override_inputqc'] = $this->adminViewAllCaseModel->getTeamData('','inputqc'); 
				$row['override_outputqc'] = $this->adminViewAllCaseModel->getTeamData('','outputqc');
				$row['tat'] =  $this->db->get('tat')->row_array();
				array_push($data,$row);
			}
		} 
		return $data; 
	}

	// is_submitted
	function get_single_cases_detail() {
		return $this->db->select("candidate.*,tbl_client.client_name")->from("candidate")->where('candidate_id',$this->input->post('id'))->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->get()->result_array();
	}

	function get_single_case_details($candidate_id) {
 		$result = $this->db->where('candidate_id',$candidate_id)->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();

 		$component_id = explode(',', $result['component_ids']);
 		$component = $this->db->where_in('component_id',$component_id)->get('components')->result_array();

 		 $case_data  = array();
 		foreach ($component as $key => $value) {
 			$row['component_id'] = $value['component_id'];
 			$row['component_name'] = $value[$this->config->item('show_component_name')]; 
 			$row['client_id'] = $result['client_id']; 
 			$row['client_name'] = $result['client_name']; 
 			$row['candidate_id'] = $result['candidate_id']; 
 			$row['title'] = $result['title']; 
 			$row['first_name'] = $result['first_name']; 
 			$row['last_name'] = $result['last_name']; 
 			$row['father_name'] = $result['father_name']; 
 			$row['phone_number'] = $result['phone_number']; 
 			$row['email_id'] = $result['email_id']; 
 			$row['date_of_birth'] = $result['date_of_birth']; 
 			$row['date_of_joining'] = $result['date_of_joining']; 
 			$row['employee_id'] = $result['employee_id']; 
 			$row['package_name'] = $result['package_name']; 
 			$row['remark'] = $result['remark']; 
 			$row['document_uploaded_by'] = $result['document_uploaded_by']; 
 			$row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
 			$row['is_submitted'] = $result['is_submitted'];  
 			array_push($case_data, $row);
 		}

 		return $case_data;
	}

	function getSingleAssignedCaseDetails($candidate_id) {
 		$result = $this->db->where('candidate_id',$candidate_id)->select("candidate.*,tbl_client.client_name,packages.package_name,tbl_client.tv_or_ebgv")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();

 		$component_id = explode(',', $result['component_ids']);
 		$component = $this->db->where_in('component_id',$component_id)->get('components')->result_array();

 		$case_data  = array();
 		foreach ($component as $key => $value) {
 			$row['component_id'] = $value['component_id'];
 			$row['component_name'] = $value[$this->config->item('show_component_name')]; 
 			$row['client_id'] = $result['client_id']; 
 			$row['client_name'] = $result['client_name']; 
 			$row['candidate_id'] = $result['candidate_id']; 
 			$row['is_report_generated'] = $result['is_report_generated']; 
 			$row['title'] = $result['title']; 
 			$row['first_name'] = $result['first_name']; 
 			$row['last_name'] = $result['last_name']; 
 			$row['father_name'] = $result['father_name']; 
 			$row['phone_number'] = $result['phone_number']; 
 			$row['email_id'] = $result['email_id']; 
 			$row['date_of_birth'] = $result['date_of_birth']; 
 			$row['date_of_joining'] = $result['date_of_joining']; 
 			$row['employee_id'] = $result['employee_id']; 
 			$row['package_name'] = $result['package_name']; 
 			$row['remark'] = $result['remark']; 
 			$row['priority'] = $result['priority']; 
 			$row['document_uploaded_by'] = $result['document_uploaded_by']; 
 			$row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
 			$row['created_date'] = date('Y-m-d', strtotime($result['created_date']) );  
 			$row['is_submitted'] = $result['is_submitted'];  
 			$row['tv_or_ebgv'] = $result['tv_or_ebgv'];  
 			// echo "\n |candidate_id: ".$result['candidate_id'];
 			// echo "\n ||component_id: ".$value['component_id'];
 			$row['component_data'] = $this->getStatusFromComponent($result['candidate_id'],$value['component_id']);
 			array_push($case_data, $row);
 		}

 		return $case_data;
	} 

	function getStatusFromComponent($candidate_id ='',$component_id = '') {
		$status = '';
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		$component_fill_date  = '';
		 
		// $result = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();

		$result = $this->db->select('team_employee.*,'.$table_name.'.*')->from($table_name)->join('team_employee','team_employee.team_id = '.$table_name.'.assigned_team_id','left')->where('candidate_id',$candidate_id)->get()->row_array();
		 
		// if(isset($result['analyst_status'])){
		// 	$status = $result['analyst_status'];
		// }else{
		// 	$status = '0';
		// }
		return $result;
	}

	function getComponentBasedData($candidate_id,$table_name) {	 
		$component_based = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
		return $component_based;
	}

	// Report Genration 
	function candidateReportData($candidate_id) {
		$reportData = array();
		$candidaetData = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
 		$candidateInfo= array('candidaetData' => $candidaetData);
		$componentId = explode(",",$candidaetData['component_ids']);
		array_push($reportData,$candidateInfo);
		foreach ($componentId as $key => $componentValue) {
			array_push($reportData, $this->getComponentData($candidate_id,$componentValue));
		}

		return $reportData;
	}
	 
	function getComponentData($candidate_id ='',$component_id = '',$status='') {
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		$result = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
		if($status == '') {
			return $result = array($table_name => $result);
		} else if($status == '2') {
			return $result;
		} else {
			$ComponentStatus = ['4','6','7','9'];
			// print_r($tmp);
			$analyst_status = isset($result['analyst_status'])?$result['analyst_status']:'0'; 
			if(in_array($analyst_status, $ComponentStatus)) {
				return '1';
			} else {
				return '0';
			}
		}		 
	}

	function genrateReportStatus() {
		$candidate_id = $this->input->post('candidate_id');
		$candidateinfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		if($candidateinfo != null) {
			$candidate_email_subject = 'Your verification request is completed!';

			/*$messge = "Dear ".$this->input->post('first_name')." ".$this->input->post('last_name').",
						You will be receiving an SMS/Email to complete your address verification as part of the Background Verification process initiated by <b>”".$client_data['client_name']."”</b>. Kindly click on the link to complete the task.";
		 
			$email_message = '<html><body>';
			$email_message .= 'Hello : '.$messge.'<br>'; 
			$email_message .= 'Thank You,<br>';
			$email_message .= 'Team Factsuite';
			$email_message .= '</html></body>';*/ 
			$client = $this->db->where('tbl_client.client_id',$candidateinfo['client_id'])->select('*')->from('tbl_client')->join('tbl_clientspocdetails',' tbl_client.client_id = tbl_clientspocdetails.client_id','left')->get()->row_array();

			$email_message ='';
			$email_message .= '<html> ';
			$email_message .= '<head>';
			$email_message .= '<style>';
			$email_message .= 'table {';
			$email_message .= 'font-family: arial, sans-serif;';
			$email_message .= 'border-collapse: collapse;';
			$email_message .= 'width: 100%;';
			$email_message .= '}';

			$email_message .= 'td, th {';
			$email_message .= 'border: 1px solid #dddddd;';
			$email_message .= 'text-align: left;';
			$email_message .= 'padding: 8px;';
			$email_message .= '}';

			$email_message .= 'tr:nth-child(even) {';
			$email_message .= 'background-color: #dddddd;';
			$email_message .= '}';
			$email_message .= '</style>';
			$email_message .= '</head>';
			$email_message .= '<body> ';
			$email_message .= "<p>Hi ".$client['client_name']."</p>";
			$email_message .= '<p>Greetings from Factsuite!!</p>';
			$email_message .= '<p>As informed earlier, our superheroes had been at work and collaborated with various teams to finish your verification process requirement as soon as possible. We thank you for your support during the verification process. </p>';

			$email_message .= '<p>We are grateful for choosing us as your verification partner.</p>';
			 
			$email_message .= '<p>Please log in to your profile on our website ';
			if ($candidateinfo['candidate_details_added_from'] == '0') {
				$email_message .= $this->config->item('factsuite_website_main_url');
			} else {
				$email_message .= base_url().'client';
			}
			$email_message .= ' and download the verification report.</p>';

			$email_message .= '<p><b>Yours sincerely,<br>';
			$email_message .= 'Team FactSuite</b></p>';
			$email_message .= '</body>';
			$email_message .= '</html>';
			if ($candidateinfo['candidate_details_added_from'] == '0') {
				$send_email_to_user = $this->emailModel->send_mail($client['spoc_email_id'],$candidate_email_subject,$email_message);
				$this->smsModel->send_complete_sms($client['client_name'],$client['spoc_phone_no']);
			}

			if($candidateinfo['is_submitted'] != 2) {
				$report_generate_data = array(
					'is_report_generated'=>'1',
					'is_submitted'=>'2',
					'case_complated_notification'=>'1',
					'case_complated_client_notification'=>'1',
					'case_close_date'=> date('Y-m-d H:i:s'),
					'report_generated_date'=>date('Y-m-d H:i:s'),
				);
			} else {
				return array('status'=>'1','msg'=>'success');
			}
		} else {
			$report_generate_data = array(
				'is_report_generated'=>'1',
				'is_submitted'=>'2',
				'case_complated_notification'=>'1',
				'case_complated_client_notification'=>'1',
				'report_generated_date'=>date('Y-m-d H:i:s'),
					 
			);	
		}

		$this->db->where('candidate_id',$candidate_id);
		if ($this->db->update('candidate',$report_generate_data)) {	
			$report_generate_log_data = array(
				'candidate_id'=>$candidate_id,
				'is_report_generated'=>'1',
				'is_submitted'=>'2',
				'case_complated_notification'=>'1',
				'case_complated_client_notification'=>'1',
				'report_generated_date'=>date('Y-m-d H:i:s'),
				'updated_date'=>date('Y-m-d H:i:s')
			);
			$this->db->insert('candidate_log',$report_generate_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function isComponentCompletedCaseList(){
		$outputqc_info = $this->session->userdata('logged-in-outputqc');
		$candidateData =  $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('is_submitted !=','2')->where_in('assigned_outputqc_id',array('0',''))->get()->result_array();
		$finalCandidateData = array();
		foreach ($candidateData as $key => $value) {
			$com_id = explode(',',$value['component_ids']);
			foreach ($com_id as $com_key => $com_value) {
				$table_name = $this->utilModel->getComponent_or_PageName($com_value);
				$componentData = $this->db->where('candidate_id',$value['candidate_id'])->get($table_name)->row_array();
				if($componentData != null){ 
					$analyst_status = array_unique(explode(',', $componentData['analyst_status']));
					$positive_status = array('4','5','6','7','9');
					$result=array_intersect($positive_status,$analyst_status);
					if(array_intersect($positive_status,$analyst_status)){
					// if(count($result) == count($analyst_status)){
						array_push($finalCandidateData, $value);
						break;
					}
				}
			}
		} 		
		return $finalCandidateData;
	}


	function isComponentCompletedCaseLists(){
		$outputqc_info = $this->session->userdata('logged-in-outputqc'); 
		
		$candidateData =  $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('is_submitted ','2')->where('assigned_outputqc_id','0')->get()->result_array();
		$finalCandidateData = array();
		foreach ($candidateData as $key => $value) {
			$com_id = explode(',',$value['component_ids']);
			foreach ($com_id as $com_key => $com_value) {
				$table_name = $this->utilModel->getComponent_or_PageName($com_value);
				$componentData = $this->db->where('candidate_id',$value['candidate_id'])->get($table_name)->row_array();
				if($componentData != null){ 
					$analyst_status = explode(',', $componentData['analyst_status']);
					$positive_status = array('4','5','6','7','9');
					$result=array_intersect($analyst_status,$positive_status);
					if(count($result) == count($analyst_status)){
						array_push($finalCandidateData, $value);
						break;
					}
				}
			}
		} 		
		return $finalCandidateData;
	}


	function checkOputputQcApprovedOrNot(){

		$candidate_id = $this->input->post('candidate_id');
		$data = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();	

		$component_ids = explode(',', $data['component_ids']);
		// print_r($component_ids);
		$cData = array();
		$forms_count = array();
		$j = 0;
		foreach ($component_ids as $key => $componentValue) {
			$componentData = $this->getComponentData($candidate_id,$componentValue,'2');
				// echo json_encode($componentData);
				// print_r($componentData);
			$output_coponent_status = explode(',',$componentData['output_status']);
			if(count($output_coponent_status) > 0){
				foreach ($output_coponent_status as $key => $statusValue) {
					if($statusValue == '1'){ 
						array_push($cData,$statusValue);							 
					}  
						array_push($forms_count,$j++);
				}
			}else{
				return array('status'=>'0','msg'=>'failled');
			}
			 
		}


		$totalPending = count($forms_count) - count($cData);
		// print_r($totalPending);
		if(count($forms_count) == count($cData)){

			return array('status'=>'1','msg'=>'success','count'=>count($cData));
		}else{
			return array('status'=>'0','msg'=>'failled','count'=>$totalPending);
		}
		// return $cData;
		
	}
	 

	



	function update_remarks_candidate_criminal_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('op_action_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		$outputQcStatusDate = array(); 
		$output_date = array();
		$data = date('Y-m-d H:i:s');
		foreach ($op_action_status as $key => $value) {
			
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,$data);
		}

		
		$analyst_status = implode(',', $analyst_status);
		$criminal_checks = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		); 
		 
			$criminal_check_id = $this->input->post('criminal_check_id');
			$componentId = $this->utilModel->getComponentId('criminal_checks');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('criminal_checks','criminal_check_id',$criminal_check_id,$componentId,$userId);
			// exit();
			$this->db->where('criminal_check_id',$criminal_check_id);
		if ($this->db->update('criminal_checks',$criminal_checks)) { 
			
			$criminal_checks['criminal_check_id'] = $criminal_check_id;			
			$this->db->insert('criminal_checks_log',$criminal_checks);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
 
	}
	function update_remarks_candidate_court_record(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('op_action_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		$output_date = array();
		$data = date('Y-m-d H:i:s');
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,$data); 
		}

		
		$analyst_status = implode(',', $analyst_status);
		// if($role == 'outputqc' && $op_action_status == '2'){
		// 	$analyst_status = '10';
		// }
		$court_record = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)

		);

		 
			$this->db->where('court_records_id',$this->input->post('court_records_id'));
		if ($this->db->update('court_records',$court_record)) {
 			$court_records_id= $this->input->post('court_records_id');
			$componentId = $this->utilModel->getComponentId('court_records');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('court_records','court_records_id',$court_records_id,$componentId,$userId);

			$court_record['court_records_id'] = $this->input->post('court_records_id');
			$this->db->insert('court_records_log',$court_record);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
 
	}

	function update_remarks_candidate_permanent_address(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('analyst_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
		$permanent_address = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_address'=>$this->input->post('address'),
			'remarks_city'=>$this->input->post('city'),
			'remarks_state'=>$this->input->post('state'),
			'staying_with'=>$this->input->post('staying_with'),
			'initiated_date'=>$this->input->post('initiated_date'),
			'verifier_name'=>$this->input->post('verifier_name'),
			'period_of_stay'=>$this->input->post('period_of_stay'),
			'progress_remarks'=>$this->input->post('progress_remarks'),
			'insuff_remarks'=>$this->input->post('infuff_remarks'),
			'assigned_to_vendor'=>$this->input->post('assigned_to_vendor'),
			'closure_date'=>$this->input->post('closure_date'),
			'relationship'=>$this->input->post('relationship'),
			'property_type'=>$this->input->post('property_type'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s'),
			);
		// if (! in_array('no-file', $doc)) {
		// 	$permanent_address['approved_doc'] = implode(',', $doc);
		// }

			$this->db->where('permanent_address_id',$this->input->post('permanent_address_id'));
		if ($this->db->update('permanent_address',$permanent_address)) {

			$permanent_address_id = $this->input->post('permanent_address_id');
			$componentId = $this->utilModel->getComponentId('permanent_address');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('permanent_address','permanent_address_id',$permanent_address_id,$componentId,$userId);






			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$permanent_address['permanent_address_id'] = $this->input->post('permanent_address_id');
			$this->db->insert('permanent_address_log',$permanent_address);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged' => $isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged' => $isChanged);
		}

		// return $permanent_address;
	
	// formdata.append('permanent_address_id',permanent_address_id);
	}

	function update_remarks_candidate_present_address(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('analyst_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
		$present_address = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_address'=>$this->input->post('address'),
			'remarks_city'=>$this->input->post('city'),
			'remarks_state'=>$this->input->post('state'),
			'staying_with'=>$this->input->post('staying_with'),
			'initiated_date'=>$this->input->post('initiated_date'),
			'verifier_name'=>$this->input->post('verifier_name'),
			'period_of_stay'=>$this->input->post('period_of_stay'),
			'progress_remarks'=>$this->input->post('progress_remarks'),
			'insuff_remarks'=>$this->input->post('infuff_remarks'),
			'assigned_to_vendor'=>$this->input->post('assigned_to_vendor'),
			'closure_date'=>$this->input->post('closure_date'),
			'relationship'=>$this->input->post('relationship'),
			'property_type'=>$this->input->post('property_type'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s'),
		); 
		// if (! in_array('no-file', $doc)) {
		// 	$present_address['approved_doc'] = implode(',', $doc);
		// }

			$this->db->where('present_address_id',$this->input->post('present_address_id'));
		if ($this->db->update('present_address',$present_address)) {


			$present_address_id = $this->input->post('present_address_id');
			$componentId = $this->utilModel->getComponentId('present_address');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('present_address','present_address_id',$present_address_id,$componentId,$userId);


			// if status raised 3(Insuff that time it will go message)
			
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

			$present_address['present_address_id'] = $this->input->post('present_address_id');
			$this->db->insert('present_address_log',$present_address);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged' => $isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged' => $isChanged);
		}

		// return $permanent_address;
	
	// formdata.append('permanent_address_id',permanent_address_id);
	}

	function update_remarks_candidate_previous_address(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$outputQcStatus = $this->input->post('op_action_status');
		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('analyst_status'));
		$output_date = array();
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,date('Y-m-d H:i:s'));
		}

		
		$analyst_status = implode(',', $analyst_status);
		$previous_address = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_address'=>$this->input->post('address'),
			'remarks_city'=>$this->input->post('city'),
			'remarks_state'=>$this->input->post('state'),
			'staying_with'=>$this->input->post('staying_with'),
			'initiated_date'=>$this->input->post('initiated_date'),
			'verifier_name'=>$this->input->post('verifier_name'),
			'period_of_stay'=>$this->input->post('period_of_stay'),
			'progress_remarks'=>$this->input->post('progress_remarks'),
			'insuff_remarks'=>$this->input->post('infuff_remarks'),
			'assigned_to_vendor'=>$this->input->post('assigned_to_vendor'),
			'closure_date'=>$this->input->post('closure_date'),
			'relationship'=>$this->input->post('relationship'),
			'property_type'=>$this->input->post('property_type'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		); 

	 	// echo json_encode($previous_address);
	 	// exit();

			$this->db->where('previos_address_id',$this->input->post('previos_address_id'));
		if ($this->db->update('previous_address',$previous_address)) {
			 

			$previos_address_id = $this->input->post('previos_address_id');
			$componentId = $this->utilModel->getComponentId('previous_address');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('previous_address','previos_address_id',$previos_address_id,$componentId,$userId);




			// if status raised 3(Insuff that time it will go message)
			
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
			$present_address['previos_address_id'] = $this->input->post('previos_address_id');
			$this->db->insert('previous_address_log',$previous_address);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

		// return $permanent_address;
	
	
	}

	function update_remarks_current_employment(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');

		// print_r($analyst_status);
		// exit();

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$current_employment = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_emp_id'=>$this->input->post('remarks_emp_id'),
			'remarks_designation'=>$this->input->post('remarks_designation'),
			'remark_department'=>$this->input->post('remark_department'),
			'remark_date_of_joining'=>$this->input->post('remark_date_of_joining'),
			'remark_date_of_relieving'=>$this->input->post('remark_date_of_relieving'),
			'remark_salary_lakhs'=>$this->input->post('remark_salary_lakhs'),
			'remark_currency'=>$this->input->post('remark_currency'),
			'remark_managers_designation'=>$this->input->post('remark_managers_designation'),
			'remark_managers_contact'=>$this->input->post('remark_managers_contact'),
			'remark_physical_visit'=>$this->input->post('remark_physical_visit'),
			'remark_hr_name'=>$this->input->post('remark_hr_name'),
			'remark_hr_email'=>$this->input->post('remark_hr_email'),
			'remark_hr_phone_no'=>$this->input->post('remark_hr_phone_no'),
			'remark_reason_for_leaving'=>$this->input->post('remark_reason_for_leaving'),
			'remark_eligible_for_re_hire'=>$this->input->post('remark_eligible_for_re_hire'),
			'remark_attendance_punctuality'=>$this->input->post('remark_attendance_punctuality'), 
			'remark_job_performance'=>$this->input->post('remark_job_performance'), 
			// 'remark_exit_status'=>$this->input->post('remark_exit_status'), 
			'remark_disciplinary_issues'=>$this->input->post('remark_disciplinary_issues'), 
			'verification_fee'=>$this->input->post('verification_fee'), 
			'verification_remarks'=>$this->input->post('verification_remarks'), 
			'Insuff_remarks'=>$this->input->post('Insuff_remarks'), 
			'Insuff_closure_remarks'=>$this->input->post('Insuff_closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		);
		// if (count($client_docs) > 0) {
		// 	$current_employment['approved_doc'] = implode(',',$client_docs);
		// } 

		// echo json_encode($current_employment);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('current_employment',$current_employment)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('current_employment');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('current_employment','candidate_id',$candidate_id,$componentId,$userId);




			// if status raised 3(Insuff that time it will go message)
			
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

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('current_employment_log',$current_employment);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_remarks_previous_employment(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$outputQcStatus = $this->input->post('op_action_status');
		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('analyst_status'));
		$output_date = array();
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,date('Y-m-d H:i:s'));
		}

		
		$analyst_status = implode(',', $analyst_status);

		// echo "Fee : ".$this->input->post('verification_fee');
		$previous_employment = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_emp_id'=>$this->input->post('remarks_emp_id'),
			'remarks_designation'=>$this->input->post('remarks_designation'),
			'remark_department'=>$this->input->post('remark_department'),
			'remark_date_of_joining'=>$this->input->post('remark_date_of_joining'),
			'remark_date_of_relieving'=>$this->input->post('remark_date_of_relieving'),
			'remark_salary_lakhs'=>$this->input->post('remark_salary_lakhs'),
			'remark_currency'=>$this->input->post('currency'),
			'remark_salary_type'=>$this->input->post('remark_salary_type'),
			'remark_managers_designation'=>$this->input->post('remark_managers_designation'),
			'remark_managers_contact'=>$this->input->post('remark_managers_contact'),
			'remark_physical_visit'=>$this->input->post('remark_physical_visit'),
			'remark_hr_name'=>$this->input->post('remark_hr_name'),
			'remark_hr_email'=>$this->input->post('remark_hr_email'),
			'remark_hr_phone_no'=>$this->input->post('remark_hr_phone_no'),
			'remark_reason_for_leaving'=>$this->input->post('remark_reason_for_leaving'),
			'remark_eligible_for_re_hire'=>$this->input->post('remark_eligible_for_re_hire'),
			'remark_attendance_punctuality'=>$this->input->post('remark_attendance_punctuality'), 
			'remark_job_performance'=>$this->input->post('remark_job_performance'), 
			'remark_exit_status'=>$this->input->post('remark_exit_status'), 
			'remark_disciplinary_issues'=>$this->input->post('remark_disciplinary_issues'), 
			'verification_remarks'=>$this->input->post('verification_remarks'), 
			'Insuff_remarks'=>$this->input->post('Insuff_remarks'), 
			'Insuff_closure_remarks'=>$this->input->post('Insuff_closure_remarks'),
			'verification_fee'=>$this->input->post('verification_fee'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		); 

		 

		// print_r($current_employment);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('previous_employment',$previous_employment)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('previous_employment');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('previous_employment','candidate_id',$candidate_id,$componentId,$userId);

			// if status raised 3(Insuff that time it will go message)
			 
			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('previous_employment_log',$previous_employment);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


	function update_reference(){

		$isChanged = '0';
		$role = $this->input->post('userRole');
		$outputQcStatus = $this->input->post('op_action_status');
		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('analyst_status'));
		$output_date = array();
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,date('Y-m-d H:i:s'));
		} 
		
		$analyst_status = implode(',', $analyst_status);
 
		$reference_remark_data = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'roles_responsibilities'=>$this->input->post('role_responsibility'),
			'professional_strengths'=>$this->input->post('professional_strengths'),
			'attendance_punctuality'=>$this->input->post('attendance'),
			'mode_exit'=>$this->input->post('mode_of_exit'),
			'communication_skills'=>$this->input->post('communication'),
			'work_attitude'=>$this->input->post('attitude'),
			'honesty_reliability'=>$this->input->post('reliability'),
			'target_orientation'=>$this->input->post('orientation'),
			'people_management'=>$this->input->post('management'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'projects_handled'=>$this->input->post('project_handled'),
			'professional_weakness'=>$this->input->post('professional_weakness'),
			'accomplishments'=>$this->input->post('accomplishments'),
			'job_performance'=>$this->input->post('job_performance'),
			'integrity'=>$this->input->post('integrity'),
			'leadership_quality'=>$this->input->post('quality'), 
			'pressure_handling_nature'=>$this->input->post('pressure'), 
			'team_player'=>$this->input->post('player'), 
			'additional_comments'=>$this->input->post('additional_comments'), 
			'insuff_remarks'=>$this->input->post('insuff_remarks'), 
			'verification_remarks'=>$this->input->post('verification_remarks'), 
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		);

		// if (count($client_docs) > 0) {
		// 	$reference_remark_data['approved_doc'] = json_encode($client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($reference_remark_data);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('reference',$reference_remark_data)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('reference');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('reference','candidate_id',$candidate_id,$componentId,$userId);


			// if status raised 3(Insuff that time it will go message)
			
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
			
			$reference_remark_data['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('reference_log',$reference_remark_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_landlord_reference(){

		$isChanged = '0';
		$role = $this->input->post('userRole');
		$outputQcStatus = $this->input->post('op_action_status');
		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('analyst_status'));
		$output_date = array();
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,date('Y-m-d H:i:s'));
		} 
		
		$analyst_status = implode(',', $analyst_status);
 
		$reference_remark_data = array(
			'tenancy_period'=>$this->input->post('tenancy_period'), 
			'tenancy_period_comment'=>$this->input->post('tenancy_period_comment'), 
			'monthly_rental_amount'=>$this->input->post('monthly_rental_amount'), 
			'monthly_rental_amount_comment'=>$this->input->post('monthly_rental_amount_comment'), 
			'occupants_property'=>$this->input->post('occupants_property'), 
			'occupants_property_comment'=>$this->input->post('occupants_property_comment'), 
			'tenant_consistently_pay_rent_on_time'=>$this->input->post('tenant_consistently_pay_rent_on_time'), 
			'tenant_consistently_pay_rent_on_time_comment'=>$this->input->post('tenant_consistently_pay_rent_on_time_comment'), 
			'utility_bills_paid_on_time'=>$this->input->post('utility_bills_paid_on_time'), 
			'utility_bills_paid_on_time_comment'=>$this->input->post('utility_bills_paid_on_time_comment'), 
			'rental_property'=>$this->input->post('rental_property'), 
			'rental_property_comment'=>$this->input->post('rental_property_comment'), 
			'maintenance_issues'=>$this->input->post('maintenance_issues'), 
			'maintenance_issues_comment'=>$this->input->post('maintenance_issues_comment'), 
			'tenant_leave'=>$this->input->post('tenant_leave'), 
			'tenant_leave_comment'=>$this->input->post('tenant_leave_comment'), 
			'tenant_rent_again'=>$this->input->post('tenant_rent_again'), 
			'tenant_rent_again_comment'=>$this->input->post('tenant_rent_again_comment'), 
			'any_pets'=>$this->input->post('any_pets'), 
			'any_pets_comment'=>$this->input->post('any_pets_comment'), 
			'food_preference'=>$this->input->post('food_preference'), 
			'food_preference_comment'=>$this->input->post('food_preference_comment'), 
			'spare_time'=>$this->input->post('spare_time'), 
			'spare_time_comment'=>$this->input->post('spare_time_comment'), 
			'overall_character'=>$this->input->post('overall_character'), 
			'overall_character_comment'=>$this->input->post('overall_character_comment'),  
			'complaints_from_neighbors'=>$this->input->post('complaints_from_neighbors'),  
			'complaints_from_neighbors_comment'=>$this->input->post('complaints_from_neighbors_comment'),

			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'), 
			'insuff_remarks'=>$this->input->post('insuff_remarks'), 
			'verification_remarks'=>$this->input->post('verification_remarks'), 
			'verified_date'=>$this->input->post('verified_date'),
			'verified_by'=>$this->input->post('verified_by'), 
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			// 'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		);

		// if (count($client_docs) > 0) {
		// 	$reference_remark_data['approved_doc'] = json_encode($client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($reference_remark_data);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('landload_reference',$reference_remark_data)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('landload_reference');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('landload_reference','candidate_id',$candidate_id,$componentId,$userId);


			// if status raised 3(Insuff that time it will go message)
			
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
			
			$reference_remark_data['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('landload_reference_log',$reference_remark_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_globalDb(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$global_db = array(
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
			'ouputqc_comment' => $ouputQcComment,
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		); 
		// if (count($client_docs) > 0) {
		// 	$global_db['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('globaldatabase',$global_db)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('globaldatabase');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('globaldatabase','candidate_id',$candidate_id,$componentId,$userId);


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

			$global_db['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('globaldatabase_log',$global_db);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


	function update_social_media(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$social_media = array(
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
			'ouputqc_comment' => $ouputQcComment,
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		); 
		// if (count($client_docs) > 0) {
		// 	$social_media['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($social_media);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('social_media',$social_media)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('social_media');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('social_media','candidate_id',$candidate_id,$componentId,$userId);


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

			$social_media['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('social_media_log',$social_media);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function remarkForDrugTest(){

		$isChanged = '0';

		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('op_action_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		$output_date = array();
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,date('Y-m-d H:i:s'));
		}

		
		$analyst_status = implode(',', $analyst_status);

		$drugTest_db = array(
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
			'output_status'=>$outputQcStatus,
			'ouputqc_comment' => $this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		);
		 
		// echo json_encode($drugTest_db);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('drugtest',$drugTest_db)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('drugtest');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('drugtest','candidate_id',$candidate_id,$componentId,$userId);


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

			$drugTest_db['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('drugtest_log',$drugTest_db);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}

	function remarkForDocuemtCheck(){
		// echo json_encode($_POST);
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('op_action_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));

		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status); 

		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('op_action_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		$output_date = array();
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,date('Y-m-d H:i:s'));
		}

		
		$analyst_status = implode(',', $analyst_status);

		$doc_data = array(
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
			'output_status'=>$outputQcStatus,
			'ouputqc_comment' =>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		); 
		// return $doc_data;
		// print_r($doc_data);
		// echo json_encode($doc_data);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('document_check',$doc_data)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('document_check');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('document_check','candidate_id',$candidate_id,$componentId,$userId);



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

			$doc_data['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('document_check_log',$doc_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}

	function remarkForEduCheck(){
		$isChanged='0';
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('op_action_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('analyst_status'));
		$output_date = array();
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,date('Y-m-d H:i:s'));
		}

		
		$analyst_status = implode(',', $analyst_status);

		$eduData= array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_roll_no'=>$this->input->post('roll_number'),
			'remark_type_of_dgree'=>$this->input->post('type_of_degree'),
			'remark_institute_name'=>$this->input->post('institute_name'),
			'remark_university_name'=>$this->input->post('university_name'),
			'remark_year_of_graduation'=>$this->input->post('year_of_education'),
			'remark_result'=>$this->input->post('result_grade'),
			'remark_verifier_name'=>$this->input->post('verifier_name'),
			'remark_verifier_designation'=>$this->input->post('verifier_designation'),
			'remark_verifier_contact'=>$this->input->post('verifier_contact'),
			'remark_verifier_email'=>$this->input->post('verifier_email'),
			'remark_physical_visit'=>$this->input->post('physical_visit'),
			'verification_remarks'=>$this->input->post('verifier_remark'),
			'verification_fee'=>$this->input->post('verifier_fee'),
			'in_progress_remarks'=>$this->input->post('progress_remark'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		);
		  
		// echo json_encode($eduData);
		// exit();
		$this->db->where('candidate_id',$this->input->post('candidate_id')); 
		if ($this->db->update('education_details',$eduData)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('education_details');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('education_details','candidate_id',$candidate_id,$componentId,$userId);



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

			$eduData['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('education_details_log',$eduData);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}

	function update_remarks_directorship_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$directorship_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($directorship_check);
		// exit();

			$this->db->where('directorship_check_id',$this->input->post('directorship_check_id'));
		if ($this->db->update('directorship_check',$directorship_check)) {
			 
			$directorship_check_id = $this->input->post('directorship_check_id');
			$componentId = $this->utilModel->getComponentId('directorship_check');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('directorship_check','directorship_check_id',$directorship_check_id,$componentId,$userId);



			$directorship_check['directorship_check_id'] = $this->input->post('directorship_check_id');
			$this->db->insert('directorship_check_log',$directorship_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function update_remarks_adverse_database_media_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$adm_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($adm_check);
		// exit();

			$this->db->where('adverse_database_media_check_id',$this->input->post('adverse_database_media_check_id'));
		if ($this->db->update('adverse_database_media_check',$adm_check)) {
			
			$adverse_database_media_check_id = $this->input->post('adverse_database_media_check_id');
			$componentId = $this->utilModel->getComponentId('adverse_database_media_check');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('adverse_database_media_check','adverse_database_media_check_id',$adverse_database_media_check_id,$componentId,$userId);

			$adm_check['adverse_database_media_check_id'] = $this->input->post('adverse_database_media_check_id');
			$this->db->insert('adverse_database_media_check_log',$adm_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_remarks_global_sanctions_aml_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$sanctions_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($sanctions_check);
		// exit();

			$this->db->where('global_sanctions_aml_id',$this->input->post('global_sanctions_aml_id'));
		if ($this->db->update('global_sanctions_aml',$sanctions_check)) {
			
			$global_sanctions_aml_id = $this->input->post('global_sanctions_aml_id');
			$componentId = $this->utilModel->getComponentId('global_sanctions_aml');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('global_sanctions_aml','global_sanctions_aml_id',$global_sanctions_aml_id,$componentId,$userId);

			$sanctions_check['global_sanctions_aml_id'] = $this->input->post('global_sanctions_aml_id');
			$this->db->insert('global_sanctions_aml_log',$sanctions_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_remarks_covid_19(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$health_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($health_check);
		// exit();

			$this->db->where('covid_id',$this->input->post('covid_id'));
		if ($this->db->update('covid_19',$health_check)) {
			
			$covid_id = $this->input->post('covid_id');
			$componentId = $this->utilModel->getComponentId('covid_19');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('covid_19','covid_id',$covid_id,$componentId,$userId);

			$health_check['covid_id'] = $this->input->post('covid_id');
			$this->db->insert('covid_19_log',$health_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}
 

	function update_remarks_health_checkup(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$health_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($health_check);
		// exit();

			$this->db->where('health_checkup_id',$this->input->post('health_checkup_id'));
		if ($this->db->update('health_checkup',$health_check)) {
			
			$health_checkup_id = $this->input->post('health_checkup_id');
			$componentId = $this->utilModel->getComponentId('health_checkup');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('health_checkup','health_checkup_id',$health_checkup_id,$componentId,$userId);

			$health_check['health_checkup_id'] = $this->input->post('health_checkup_id');
			$this->db->insert('health_checkup_log',$health_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	// function update_remarks_adverse_database_media_check(){
	// 	$role = $this->input->post('userRole');
	// 	$outputQcStatus =  $this->input->post('output_status');

	// 	$op_action_status = explode(',',$outputQcStatus);
	// 	$analyst_status = explode(',',$this->input->post('action_status'));
		
	// 	foreach ($op_action_status as $key => $value) {
	// 		// echo $value."\r\n";
	// 		if ($value == '2') {
	// 			$analyst_status[$key] = '10';
	// 		}
	// 	}

		
	// 	$analyst_status = implode(',', $analyst_status);
	// 	$adm_check = array(
	// 		'remarks_updateed_by_role' => $this->input->post('userRole'),
	// 		'remarks_updateed_by_id' => $this->input->post('userID'),
	// 		'remark_country'=>$this->input->post('country'),
	// 		'in_progress_remarks'=>$this->input->post('progress_remarks'),
	// 		'verification_remarks'=>$this->input->post('verification_remarks'),
	// 		'insuff_remarks'=>$this->input->post('insuff_remarks'),
	// 		'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
	// 		'analyst_status'=>$analyst_status,
	// 		'output_status'=>$outputQcStatus,
	// 		'ouputqc_comment'=>$this->input->post('ouputQcComment')
 
	// 	); 
		
	// 	// echo json_encode($adm_check);
	// 	// exit();

	// 		$this->db->where('adverse_database_media_check_id',$this->input->post('adverse_database_media_check_id'));
	// 	if ($this->db->update('adverse_database_media_check',$adm_check)) {
			 
	// 		$adm_check['adverse_database_media_check_id'] = $this->input->post('adverse_database_media_check_id');
	// 		$this->db->insert('adverse_database_media_check_log',$adm_check);

	// 		return array('status'=>'1','msg'=>'success');
	// 	}else{
	// 		return array('status'=>'0','msg'=>'failled');
	// 	}
	// }

	function update_remarks_bankruptcy_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$adm_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($adm_check);
		// exit();

			$this->db->where('bankruptcy_id',$this->input->post('bankruptcy_id'));
		if ($this->db->update('bankruptcy',$adm_check)) {
			
			$bankruptcy_id = $this->input->post('bankruptcy_id');
			$componentId = $this->utilModel->getComponentId('bankruptcy');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('bankruptcy','bankruptcy_id',$bankruptcy_id,$componentId,$userId);
			 

			$adm_check['bankruptcy_id'] = $this->input->post('bankruptcy_id');
			$this->db->insert('bankruptcy_log',$adm_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_remarks_credit_cibil_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$adm_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($adm_check);
		// exit();

			$this->db->where('credit_id',$this->input->post('credit_id'));
		if ($this->db->update('credit_cibil',$adm_check)) {
			
			$credit_id = $this->input->post('credit_id');
			$componentId = $this->utilModel->getComponentId('credit_cibil');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('credit_cibil','credit_id',$credit_id,$componentId,$userId);
			

			$adm_check['credit_id'] = $this->input->post('credit_id');
			$this->db->insert('credit_cibil_log',$adm_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_remarks_cv_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$adm_check = array(
			'full_name'=>$this->input->post('candidate_full_name'),
		 	'contect_number'=>$this->input->post('contact_number'),
		 	'address'=>$this->input->post('candidate_address'),
		 	'education_detail'=>$this->input->post('education_details'),
		 	'employment_duration'=>$this->input->post('employement_duration'),
		 	'designation_held'=>$this->input->post('designation_held'),
		 	'complete_employment_info'=>$this->input->post('complete_emp_info'),
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($adm_check);
		// exit();

			$this->db->where('cv_id',$this->input->post('cv_id'));
		if ($this->db->update('cv_check',$adm_check)) {
			
			$cv_id = $this->input->post('cv_id');
			$componentId = $this->utilModel->getComponentId('cv_check');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('cv_check','cv_id',$cv_id,$componentId,$userId);
			

			$adm_check['cv_id'] = $this->input->post('cv_id');
			$this->db->insert('cv_check_log',$adm_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_remarks_driving_licence_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		foreach ($op_action_status as $key => $value) {
			// echo $value."\r\n";
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
		}

		
		$analyst_status = implode(',', $analyst_status);
		$adm_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($adm_check);
		// exit();

			$this->db->where('licence_id',$this->input->post('licence_id'));
		if ($this->db->update('driving_licence',$adm_check)) {

			$licence_id = $this->input->post('licence_id');
			$componentId = $this->utilModel->getComponentId('driving_licence');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('driving_licence','licence_id',$licence_id,$componentId,$userId);
			 
			$adm_check['licence_id'] = $this->input->post('licence_id');
			$this->db->insert('driving_licence_log',$adm_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function update_employment_gap_check(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('output_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status =$this->input->post('action_status');
		
		if ($outputQcStatus == '2' ) {
			$analyst_status = '10';
		}
		 
		$eg_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>date('Y-m-d H:i:s')
 
		); 
		
		// echo json_encode($eg_check);
		// exit();

			$this->db->where('gap_id',$this->input->post('gap_id'));
		if ($this->db->update('employment_gap_check',$eg_check)) {
			
			$gap_id = $this->input->post('gap_id');
			$componentId = $this->utilModel->getComponentId('employment_gap_check');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('employment_gap_check','gap_id',$gap_id,$componentId,$userId);
			 
			$eg_check['gap_id'] = $this->input->post('gap_id');
			$this->db->insert('employment_gap_check_log',$eg_check);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}



	function outputQcExists($candidate_id){
		$candidateData = $this->db->select('assigned_outputqc_id')->from('candidate')->where('candidate_id',$candidate_id)->get()->row_array();
		
		if($candidateData['assigned_outputqc_id'] == '0'){
			return '0';
		}
		
		return '1';
	}

	function get_all_states($id=''){
		if ($id !='') {
			return $this->db->where('country_id',$id)->get('states')->result_array();
		}else{
			return $this->db->order_by('country_id','ASC')->get('states')->result_array();
		}
	}

	function isSubmitedStatusChanged($candidateId){
		$is_submitted_status= array(
			'is_submitted'=>'3'
		);
		$this->db->where('candidate_id',$candidateId); 
		if ($this->db->update('candidate',$is_submitted_status)){

			$candidateDatat = $this->db->where('candidate_id',$candidateId)->get('candidate')->row_array();
			if($this->db->insert('candidate_log',$candidateDatat)){
				return '1';
			}else{
				return '3';
			}
			
		}else{
			return '0'; 
		}
	}


	/*new components*/



}	
?>