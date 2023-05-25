<?php
/***
 * 01-02-2021	
 ***/
class InputQcModel extends CI_Model
{

	function getPackgeDetail(){

		 
		$result =  $this->db->where('package_status',1)->where('package_id',$this->input->post('id'))->get('packages')->row_array();
		 
			$component_names = array();  
			$comp_name = array();
			$row['package_name'] = $result['package_name'];
			$row['package_id'] = $result['package_id'];
			$row['package_status'] = $result['package_status'];
			$component_ids = explode(',', $result['component_ids']);
			$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();
			
			foreach ($component as $key1 => $com) {
				array_push($comp_name, $com['component_name']);
			}
			 
			$row['component_ids'] =  $component_ids;
			$row['component_name'] =  $comp_name;
			array_push($component_names, $row);
		 
		return $component_names;

	}

	function getPackage(){ 
		 
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

	function get_packages($client_id){ 
		$resultClient = $this->db->where('active_status',1)->where('client_id',$client_id)->get('tbl_client')->row_array();
		$package_ids = explode(',', isset($resultClient['packages'])?$resultClient['packages']:0); 
		return $package_name = $this->db->where('package_status',1)->where_in('package_id',$package_ids)->get('packages')->result_array();

	}

	function insertCase(){

		// return $_POST;
		$txtSmsStatus = '';
		// $login_otp = $this->smsModel->rendomNumber(4);
		// $otp = isset($login_otp) ? $login_otp : '0000';

		// $rand = rand();
		$get_candidate_otp_of_came_mobile_number = $this->db->select('otp_password, loginId')->where('phone_number',$this->input->post('phone_number'))->get('candidate')->result_array();
		$otp_list = [];
		$login_id_list = [];
		if (count($get_candidate_otp_of_came_mobile_number) > 0) { 
			foreach ($get_candidate_otp_of_came_mobile_number as $key => $value) {
				array_push($otp_list, $value['otp_password']);
				if ($value['loginId'] != '') {
					array_push($login_id_list, $value['loginId']);
				}
			}
		}
		
		$variable_array = array(
			'otp_list' => $otp_list,
			'otp_length' => $this->config->item('otp_to_candidate_length')
		);
		$login_otp = $this->utilModel->random_number_with_duplication_check($variable_array);

		// $variable_array = array(
		// 	'otp_list' => $login_id_list,
		// 	'otp_length' => $this->config->item('login_id_to_candidate_length')
		// );
		// $login_id = $this->utilModel->random_number_with_duplication_check($variable_array);

		$login_id = (substr($this->input->post('phone_number'), 0, 6)).''.$login_otp;

		$inputqc_info = $this->session->userdata('logged-in-inputqc');
		 
			$client_data = $this->db->where('client_id',$this->input->post('client_id'))->get('tbl_client')->row_array();

			// echo "uploaded_by : ".$this->input->post('document_uploaded_by');
			$uploaded_by = $this->input->post('document_uploaded_by');
			$sms_flag = 1;
			$name = ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name'));
			if($uploaded_by == 'candidate'){
				$uploaded_by_email_id = strtolower($this->input->post('email_id'));
			}else{
				$sms_flag = 0;
				$uploaded_by_email_id = strtolower($this->input->post('document_uploaded_by_email_id'));
				$name = $client_data['client_name'];
			}
			
			// Send Email To User Starts
			$candidate_email_subject = 'Candidate Verification Form';
			$templates = $this->db->where('client_id',0)->where('template_type','Initiate Case')->get('email-templates')->row_array();
				$email_message ='';
				if (isset($templates['template_content'])) { 
					$need_replace = ["@candidate_name","@client_name", "@link", "@candidate_phone_number", "@otp_or_password"];
					$replace_strings   = [ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name')),ucwords($client_data['client_name']), $this->config->item('candidate_url'), $this->config->item('phone_number'),$login_otp ];

					$email_message =  str_replace($need_replace, $replace_strings, $templates['template_content']);
					
			}else{
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
				$email_message .= "<p>Dear ".$name."</p>";
				$email_message .= '<p>Greetings from Factsuite!!</p>';
				if ($sms_flag ==1) { 
				$email_message .= '<p>'.ucwords($client_data['client_name']).' has partnered with Factsuite to conduct your background verification.</p>';
				$email_message .= '<p>To proceed with your verification, we request you to kindly fill the information as requested on the Factsuite CRM application.</p>';
				}else{
					$email_message .= '<p>To proceed with the '.ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name')).' verification, we request you to kindly fill the information as requested on the Factsuite CRM application.</p>';
				}
				$email_message .= '<p>In case of any queries, please reach out to us at help@factsuite.com</p>';
				// $email_message .= '<p>Please find your Login ID :'.$login_id.'</p>';
				$email_message .= '<p>Please find your Login Credentials mentioned below to access the FactSuite CRM:</p>';
				$email_message .= '<table>';
				$email_message .= '<th>CRM Link</th>';
				// $email_message .= '<th>Mobile Number</th>';
				$email_message .= '<th>Login ID</th>';
				$email_message .= '<th>OTP</th>';
				$email_message .= '<tr>';
				$email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
				// $email_message .= '<td>'.$this->input->post('phone_number').'</td>';
				$email_message .= '<td>'.$login_id.'</td>';
				$email_message .= '<td>'.$login_otp.'</td>';
				$email_message .= '<tr>';
				$email_message .= '</table>';
				$email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free screening of your profile.</p>';
				$email_message .= '<p><b>Yours sincerely,<br>';
				$email_message .= 'Team FactSuite</b></p>';
				$email_message .= '</body>';
			$email_message .= '</html>';
			// $send_email_to_user = $this->emailModel->send_mail($uploaded_by_email_id,$candidate_email_subject,$email_message);
			}
			// exit();
			$email_status = '';


			$ids = explode(',', $this->input->post('component_id'));
			$component  = array_unique($ids);
			asort($component);

		$notification = array('admin'=>'0','inputQc'=>'0','client'=>'0','outPutQc'=>'0');
		$inputqc = $this->getMinimumTaskHandlerInputQC();
		if ($this->input->post('inputqc')) {
			$inputqc = $this->input->post('inputqc');
		}
		$notification = json_encode($notification);
		$case_data = array(
			'client_id' =>$this->input->post('client_id'),
			'title' => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'father_name' => $this->input->post('father_name'),
			'country_code' => $this->input->post('country_code'),
			'phone_number' => $this->input->post('phone_number'),
			'loginId' => $login_id,
			'package_name' => $this->input->post('package_id'),
			'document_uploaded_by' => $this->input->post('document_uploaded_by'),
			'document_uploaded_by_email_id' => $this->input->post('document_uploaded_by_email_id'),
			'date_of_birth' => $this->input->post('date_of_birth'),
			'date_of_joining' => $this->input->post('date_of_joining'),
			'employee_id' => $this->input->post('employee_id'),
			'remark' => $this->input->post('remarks'),
			'email_id' => $this->input->post('email_id'),
			'alacarte_components' => $this->input->post('alacarte_components'),
			'package_components' => $this->input->post('package_component'),
			'component_ids' => implode(',', $component),
			'form_values' => json_encode($this->input->post('form_values')),
			'assigned_inputqc_id'=>$inputqc,
			'case_added_by_role'=>'inputqc',
			'case_added_by_id'=>$inputqc_info['team_id'],
			'is_submitted'=>0,
			'priority'=>$this->input->post('priority'),
			'segment'=>$this->input->post('segment'),
			'cost_center'=>$this->input->post('cost_center'),
			'otp_password'=>$login_otp,
			'new_case_added_notification'=> $notification
		); 
		// return $case_data;
		if($this->utilModel->isInputQcExits() == 1){
			if ($this->db->insert('candidate',$case_data)) {
				$insert_id = $this->db->insert_id();
				$smsStatus = '';
				$email_status = '';

				if($this->emailModel->send_mail($uploaded_by_email_id,$candidate_email_subject,$email_message)){
					$email_status = '1';
				}else{
					$email_status = '0'; 
				}	
				
				if ($sms_flag == 1) { 
					$smsStatus = $this->smsModel->send_sms($this->input->post('first_name'),$client_data['client_name'],$this->input->post('phone_number'),$login_otp,'1');
				}

				if($smsStatus == "200"){
					$txtSmsStatus = '1';
				}else{
					$txtSmsStatus = '0';

				}

				$case_data = array(
				'candidate_id'=>$insert_id,
				'client_id' =>$this->input->post('client_id'),
				'title' => $this->input->post('title'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'father_name' => $this->input->post('father_name'),
				'country_code' => $this->input->post('country_code'),
				'phone_number' => $this->input->post('phone_number'),
				'loginId' => $login_id,
				'package_name' => $this->input->post('package_id'),
				'document_uploaded_by' => $this->input->post('document_uploaded_by'),
				'document_uploaded_by_email_id' => $this->input->post('document_uploaded_by_email_id'),
				'date_of_birth' => $this->input->post('date_of_birth'),
				'date_of_joining' => $this->input->post('date_of_joining'),
				'employee_id' => $this->input->post('employee_id'),
				'remark' => $this->input->post('remarks'),
				'email_id' => $this->input->post('email_id'),
				'component_ids' => implode(',', $component),
				'form_values' => json_encode($this->input->post('form_values')),
				'package_components' => $this->input->post('package_component'),
				'alacarte_components' => $this->input->post('alacarte_components'),
				'assigned_inputqc_id'=>$inputqc,
				'case_added_by_role'=>'inputqc',
				'case_added_by_id'=>$inputqc_info['team_id'],
				'is_submitted'=>0,
				'priority'=>$this->input->post('priority'),
				'segment'=>$this->input->post('segment'),
				'cost_center'=>$this->input->post('cost_center'),
				'otp_password'=>$login_otp,
				'new_case_added_notification'=> $notification
				);

				if (strtolower($this->input->post('document_uploaded_by')) == 'inputqc') {
					$get_candidate_details = $this->db->where('candidate_id',$insert_id)->get('candidate')->row_array();
					$this->session->set_userdata('logged-in-candidate',$get_candidate_details);
					$component_ids = array();
					foreach (explode(',', $get_candidate_details['component_ids']) as $key => $value) {
						if (!in_array($value,array('14','15','19','21','24'))) { 
							array_push($component_ids,$value);
						}
					}
				 	$this->session->set_userdata('component_ids',implode(',', $component_ids));
					$this->session->set_userdata('is_submitted',1);
			 		$this->session->set_userdata('candidate_details_submitted_by','inputqc');
				}

				$this->db->insert('candidate_log',$case_data);
				return array('status'=>'1','msg'=>'success','email_status'=>$email_status,'smsStatus'=>$txtSmsStatus);
			}else{
				return array('status'=>'0','msg'=>'failled','email_status'=>$email_status,'smsStatus'=>$txtSmsStatus);
			}
		}else{
			return array('status'=>'2','msg'=>'Please, Enter first InputQC Or Team member.','email_status'=>'0','smsStatus'=>'0');
		}
	}




	function updateCase($date =''){
		$inputqc_info = $this->session->userdata('logged-in-inputqc');
		 
			$client_data = $this->db->where('client_id',$this->input->post('client_id'))->get('tbl_client')->row_array(); 

			$uploaded_by = $this->input->post('document_uploaded_by');
			if($uploaded_by == 'candidate'){
				$uploaded_by_email_id = strtolower($this->input->post('email_id'));
			}else{
				$uploaded_by_email_id = strtolower($this->input->post('document_uploaded_by_email_id'));
			}
			$candidate_data = $this->db->where('candidate_id',$this->input->post('candidate_id'))->get('candidate')->row_array();
			$case_re_initiation = '';
			$case_re_initiation_date = '';
			if($candidate_data['case_re_initiation_date'] !=''){
				$case_re_initiation_date =  date('d-m-Y');
				$case_re_initiation =  1;
			}

			if ($this->input->post('init') != 'update') { 
				/*array_push($case_re_initiation_date,date('d-m-Y'));
				array_push($case_re_initiation,1);*/
				$case_re_initiation_date =  date('d-m-Y');
				$case_re_initiation =  1;
			}
	 
			
			$candidate_email_subject = 'Candidate Verification Form';
 
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
				$email_message .= "<p>Dear ".$this->input->post('first_name')." ".$this->input->post('last_name')."</p>";
				$email_message .= '<p>Greetings from Factsuite!!</p>';
				$email_message .= '<p>'.$client_data['client_name'].' has partnered with Factsuite to conduct Employment Background Screening of prospective employees.</p>';
				$email_message .= '<p>To proceed with this activity, we request you to provide relevant details of your profile, as requested on the Factsuite CRM application.</p>';
				$email_message .= '<p>Please find your Login Credentials mentioned below-</p>';
				$email_message .= '<table>';
				$email_message .= '<th>CRM Link</th>';
				$email_message .= '<th>LoginId</th>';
				// $email_message .= '<th>OTP</th>';
				$email_message .= '<tr>';
				$email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
				$email_message .= '<td>'.$candidate_data['loginId'].'</td>';
				// $email_message .= '<td>-</td>'; 
				$email_message .= '<tr>';
				$email_message .= '</table>';
				$email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free screening of your profile.</p>';
				$email_message .= '<p><b>Yours sincerely,<br>';
				$email_message .= 'Team Factsuite</b></p>';
				$email_message .= '</body>';
				$email_message .= '</html>'; 

				$ids = explode(',', $this->input->post('component_id'));
				$component  = array_unique($ids);
				asort($component);

			
			 
			$email_status = '';
			$case_data = array(
			'client_id' =>$this->input->post('client_id'),
			'title' => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'father_name' => $this->input->post('father_name'),
			'country_code' => $this->input->post('country_code'),
			'phone_number' => $this->input->post('phone_number'),
			'package_name' => $this->input->post('package_id'),
			'document_uploaded_by' => $this->input->post('document_uploaded_by'),
			'document_uploaded_by_email_id' => $this->input->post('document_uploaded_by_email_id'),
			'date_of_birth' => $this->input->post('date_of_birth'),
			'date_of_joining' => $this->input->post('date_of_joining'),
			'employee_id' => $this->input->post('employee_id'),
			'remark' => $this->input->post('remarks'),
			'email_id' => $this->input->post('email_id'),
			'component_ids' => implode(',', $component), 
			'assigned_inputqc_id'=>$this->getMinimumTaskHandlerInputQC(),

			// 'case_added_by_role'=>'inputqc',
			// 'case_added_by_id'=>$inputqc_info['team_id'], 
			'alacarte_components' => $this->input->post('alacarte_components'),
			'package_components' => $this->input->post('package_component'),
			'segment'=>$this->input->post('segment'),
			'cost_center'=>$this->input->post('cost_center'),
			'updated_date'=>date('d-m-Y H:i:s'),
			'case_updated_by'=>$inputqc_info['team_id'], 
			'case_updated_by_role'=>'inputqc',
			'case_updated_by_date'=>date('d-m-Y H:i:s'),

		); 
			if ($this->input->post('init') != 'update') {
			$case_data['case_re_initiation'] = $case_re_initiation;
			$case_data['case_reinitiate'] = 1;
			$case_data['case_re_initiation_date'] = $case_re_initiation_date;
			$case_data['is_submitted'] = 0;

			$case_data['is_report_generated'] = 0;
			$case_data['report_generated_date'] = '';

			}
		if ($this->input->post('form_values') !='' && $this->input->post('form_values') !='{}') {
			$case_data['form_values'] = json_encode($this->input->post('form_values'));
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('candidate',$case_data)) {
			$email_status ='0';
			if($this->emailModel->send_mail($uploaded_by_email_id,$candidate_email_subject,$email_message)){
				$email_status = '1';	 
			}else{
				$email_status = '0'; 
			} 

			$this->db->insert('candidate_log',$case_data);

			return array('status'=>'1','msg'=>'success','email_status'=>$email_status);
		}else{
			return array('status'=>'0','msg'=>'failled','email_status'=>$email_status);
		}
	}

	function checkMobileNumerExits(){

		if ($this->input->post('candidate_id')) {
			$this->db->where('candidate_id !=',$this->input->post('candidate_id'));
		}
		$result = $this->db->where('phone_number',$this->input->post('number'))->get('candidate');
		if($result->num_rows() > 0){
			
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
			
		}
	}

	function get_all_cases(){
		// $inputqc_info = $this->session->userdata('logged-in-inputqc'); 
		// return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('case_added_by_role','inputqc')->where('case_added_by_id',$inputqc_info['team_id'])->order_by('priority DESC, candidate_id DESC')->get()->result_array();
		return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('case_added_by_role','inputqc')->order_by('priority DESC, candidate_id DESC')->get()->result_array();
	}

	function getAllAssignedCases(){
		$inputqc_info = $this->session->userdata('logged-in-inputqc'); 
		return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('assigned_inputqc_id',$inputqc_info['team_id'])->order_by('priority DESC, candidate_id DESC')->get()->result_array();
	} 

	function getAllAssignedmanualCases(){
		$inputqc_info = $this->session->userdata('logged-in-inputqc'); 
		$candidateData = $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('assigned_inputqc_id',$inputqc_info['team_id'])->order_by('priority DESC, candidate_id DESC')->get()->result_array();
	$data= array();
		if(count($candidateData) > 0) {
			foreach ($candidateData as $key => $candidateValue) {

				$row['candidate'] = $candidateValue; 
				
					if($candidateValue['tat_start_date'] != null && $candidateValue['report_generated_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != '' && $candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
						$restart_date = 0;
						$start_date = 0; 
							$start_date = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
					 
						$restart_date = $this->number_of_working_days($candidateValue['tat_re_start_date'],$candidateValue['report_generated_date']);
					 
						$total = $start_date + $restart_date;
						$row['left_tat_days'] = $total.' days';
	
					}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != '' && $candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
						$restart_date = 0;
						$start_date = 0;
						 if ($candidateValue['report_generated_date'] !='') { 
							$restart_date = $this->number_of_working_days($candidateValue['tat_re_start_date'],$candidateValue['report_generated_date']);
						 }else{
							 $restart_date = $this->number_of_working_days($candidateValue['tat_re_start_date'],date('d-m-Y'));
						 }
						 
						 
							$start_date = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
						 
						$total = $start_date + $restart_date;
						$row['left_tat_days'] = $total.' days';
	
					}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != ''){
						$restart_date = 0;
						$start_date = 0; 
						 
							$start_date = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
						 
						$total = $start_date + $restart_date;
						$row['left_tat_days'] = $total.' days';
	
					}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_start_date'] != ''){
							if ($candidateValue['report_generated_date'] !='' && $candidateValue['report_generated_date'] !=null) { 
	
							$row['left_tat_days'] = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['report_generated_date']).' days';
						}else{
							$row['left_tat_days'] = $this->number_of_working_days($candidateValue['tat_start_date'],date('d-m-Y')).' days';	
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

	function get_single_cases_detail($candidate_id=''){

		if ($candidate_id =='') {
			$candidate_id = $this->input->post('id');
		}

		return $this->db->select("candidate.*,tbl_client.client_name")->from("candidate")->where('candidate_id',$candidate_id)->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->get()->result_array();
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

	function getSingleAssignedCaseDetails($randomString) {
		 
		$candidate_id = $this->input->post('candidate_id');
		$statusPage = $this->input->post('statusPage');
 		// $this->db->where('candidate.candidate_id',$candidate_id); 
 		// $result = $this->db->select('candidate.*, tbl_client.client_name, packages.package_name')->from('candidate')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();
 		$result = $this->db->query("SELECT `candidate`.*, `tbl_client`.`client_name`, `packages`.`package_name` FROM `candidate` LEFT JOIN `tbl_client` ON `candidate`.`client_id` = `tbl_client`.`client_id` LEFT JOIN `packages` ON `candidate`.`package_name` = `packages`.`package_id` WHERE `candidate`.`candidate_id` =".$candidate_id)->row_array();

 		$component_ids = explode(',', $result['component_ids']);
 		
 		
 		$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();
		$case_data  = array();
 		
		$uploaded_loa = $this->db->select('signature_img')->where('candidate_id',$candidate_id)->get('signature')->row_array();
		$row['uploaded_loa'] = isset($uploaded_loa['signature_img'])?$uploaded_loa['signature_img']:'';
		
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
 			$row['contact_start_time'] = $result['contact_start_time']; 
 			$row['contact_end_time'] = $result['contact_end_time']; 
 			$row['date_of_birth'] = $result['date_of_birth']; 
 			$row['date_of_joining'] = $result['date_of_joining']; 
 			$row['employee_id'] = $result['employee_id']; 
 			$row['package_name'] = $result['package_name']; 
 			$row['remark'] = $result['remark']; 
 			$row['week'] = $result['week']; 
 			$row['priority'] = $result['priority']; 
 			$row['form_values'] = $result['form_values'];
 			if($statusPage == '2'){
 			 	$row['component_id_total'] = (count($component_id)+2); 
 			}
 			
 			$row['document_uploaded_by'] = $result['document_uploaded_by'];
 			$row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
 			$row['created_date'] = date('d-m-Y', strtotime($result['created_date']) );  
 			$row['is_submitted'] = $result['is_submitted'];  
 			$row['aaddhar_doc'] = $result['aaddhar_doc'];
 			$row['pancard_doc'] = $result['pancard_doc'];
 			$row['idproof_doc'] = $result['idproof_doc'];
 			$row['bankpassbook_doc'] = $result['bankpassbook_doc'];
 			$row['component_status'] = $this->getStatusFromComponent($result['candidate_id'],$value['component_id'],$statusPage);
 			array_push($case_data, $row);

 		}
		 
 		return $case_data;
	}

	function getStatusFromComponent($candidate_id,$component_id,$statusPage){
		$status = '';
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		$component_fill_date  = ''; 
		
		$result = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();

		if($statusPage == '0'){ 
			if(isset($result['status'])){
				$status = $result['status'];
			}else{
				$status = '0';
			}
		}elseif($statusPage == '2'){
			$status = $result;

		}else{
			if(isset($result['analyst_status'])){
			$status = $result['analyst_status'];
			}else{
				$status = '0';
			}
		}
		return $status;
	}

	

	function getComponentBasedData($candidate_id,$table_name){
		 $component_based = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
		
		if($component_based != '' ){
			$candidateInfo = $this->db->select('form_values,is_submitted')->from('candidate')->where('candidate_id',$candidate_id)->get()->row_array();
	 		$component_based['form_values'] = $candidateInfo['form_values'];
	 		$component_based['is_submitted'] = $candidateInfo['is_submitted'];
 		}

		return $component_based;

	}


	function insuffUpdateStatus($candidate_id,$table_name,$component_id){
		$priority = $this->input->post('priority');
		$position = $this->input->post('position');
		$status = $this->input->post('status');
		$candidateData = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
		$inputqc_id_rr = $this->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,$component_id,$priority);
		// echo "inputqc_id_rr".$inputqc_id_rr;
		$roles = $this->db->select('role')->from('team_employee')->where('team_id',$inputqc_id_rr)->get()->row_array();
		$candidateInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		$component_ids = ['14','15','19','21','22'];

		$date_insuff = date('d-m-Y H:i:s');
		// print_r($component_ids);
		if(in_array($component_id,$component_ids) !== -1){
			$form_value = json_decode($candidateInfo['form_values'],true);
			$form_value = json_decode($form_value,true);
			$form_value_count = isset($form_value[$table_name][0])?$form_value[$table_name][0]:1;
			$statusValues = array();

			for ($i=0; $i < $form_value_count; $i++) { 
				$statusValues[$i] = '0';
			}

			if($inputqc_id_rr != '0'){ 
				if($candidateData == 'null' || $candidateData == ''){
					// echo 'if condition';
					$other_status = implode(',', $statusValues);
					
					$inputqcStatus  = array();
					$inputqcStatus[$position] = '3';
					$inputqcStatus = implode(',',$inputqcStatus);

					$insuffAnalyst_ids =array();
					$insuffAnalyst_ids[$position] = $inputqc_id_rr;
					$insuffAnalyst_ids = implode(',',$insuffAnalyst_ids);

					$insuffAnalyst_roles =array();
					$insuffAnalyst_roles[$position] = $roles['role'];
					$insuffAnalyst_roles = implode(',',$analyst_roles);

					$inputqc_status_date = array();
					$inputqc_status_date[$position] = data('d-m-Y H:i:s');
					$insuff_date[$position] = data('d-m-Y H:i:s');
					$inputqc_status_date = implode(',',$inputqc_status_date);
					$componentsData = array(
						'candidate_id' => $candidate_id,
						'status' => $inputqcStatus,
						'analyst_status' => $other_status,
						'insuff_team_role' => $other_status,
						'insuff_team_id	' => $other_status,
						'output_status' => $other_status,
						'assigned_role' => $insuffAnalyst_roles,
						'assigned_team_id' => $insuffAnalyst_ids,
						'output_status' => $other_status,
						'inputqc_status_date' => implode(',', $inputqc_status_date),
						'insuff_created_date' => implode(',', $insuff_date)
					);

					// print_r($componentsData);
					// exit();
					if($this->db->insert($table_name,$componentsData)){
						$this->notificationCreate($candidate_id,$position,$component_id,'3',$inputqc_id_rr);
						$candidateData = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
						$this->db->insert($table_name.'_log',$componentsData);
						return array('status'=>'1','msg'=>'success');
					}else{
						return array('status'=>'0','msg'=>'failled');
					}

				}else{

					$oldStatusString = $candidateData['status']; 
					$assigned_role = $candidateData['insuff_team_role']; 
					$assigned_team_id = $candidateData['insuff_team_id'];  
					$inputqc_status_date = $candidateData['inputqc_status_date'];  
					$insuff_created_date = $candidateData['insuff_created_date'];  

					$inputqc_status_date = $this->updateArrayValueThroughIndex($inputqc_status_date,$position,date('d-m-Y H:i:s'));
					$insuff_created_date = $this->updateArrayValueThroughIndex($insuff_created_date,$position,date('d-m-Y H:i:s'));
					$newUpdatedString = $this->updateArrayValueThroughIndex($oldStatusString,$position,'3');

					
					$components_data = array(
							'inputqc_status_date' => $inputqc_status_date,
							'insuff_created_date' => $insuff_created_date,
							'status'=>$newUpdatedString, 
							'updated_date'=>$date_insuff
					);



					if (in_array($component_id,[6,8,9,25])) {
						$insufff = 'insuff_remarks';
						if ($component_id == 6) {
						$insufff = 'Insuff_remarks';
						}
						$components_data[$insufff] = $this->input->post('insuff_remarks');
						// $components_data['insuff_created_date'] = $date_insuff;
					}else{ 

						$insufff = 'insuff_remarks';
						if ($component_id == 10) {
						$insufff = 'Insuff_remarks';
						} 
						$remarks = json_decode($candidateData[$insufff],true);

						
							$compon = isset($form_value[$table_name])?$form_value[$table_name]:array(1);
						if ($table_name == 'education_details') {
							 	$compon = $form_value['highest_education'];
							 }
						if (in_array($compon, ['document_check','highest_education','drug_test'])) {
							$form_value_count = count($compon);
						} 
					$insuff_remarks = [];
					$insuff_date = [];

						for ($i=0; $i < $form_value_count; $i++) { 
							if ($i == $position) { 
								array_push($insuff_remarks,array('insuff_remarks'=>$this->input->post('insuff_remarks')));
								// array_push($insuff_date,$date_insuff);
							 }else{
							 	array_push($insuff_remarks,array('insuff_remarks'=>isset($remarks[$i]['insuff_remarks'])?$remarks[$i]['insuff_remarks']:''));
							 	// array_push($insuff_date,$date_insuff);
							 }
						}
					 $components_data[$insufff] = json_encode($insuff_remarks);
					 // $components_data['insuff_remarks'] = implode(',', $insuff_date);
				 
					}
 
					 
					$inputqc_id = $this->updateArrayValueThroughIndex($assigned_team_id,$position,$inputqc_id_rr);
					 
					if($inputqc_id_rr != '0' && $this->analystModel->InsuffAnalystAndSpecialistExists($candidate_id,$position,$table_name,$status) == '0'){
						
					  	$roles = $this->db->select('role')->from('team_employee')->where('team_id',$inputqc_id_rr)->get()->row_array();
					   	$role = $this->updateArrayValueThroughIndex($assigned_role,$position,$roles['role']);
						$components_data['insuff_team_role'] = $role;
						$components_data['insuff_team_id'] = $inputqc_id;
						
					} 

					 
					if($inputqc_id_rr != '0'){
						
						// echo json_encode($components_data);
						// exit();
						$this->db->where('candidate_id',$candidate_id);
						if ($this->db->update($table_name,$components_data)) {
							$this->notificationCreate($candidate_id,$position,$component_id,'3',$inputqc_id_rr);
							 
							$this->db->insert($table_name."_log",$components_data);
							return array('status'=>'1','msg'=>'success');
						}else{
							return array('status'=>'0','msg'=>'failled');
						}
					}else{
						$table_name = str_replace('_',' ',$table_name);
						return array('status'=>'2','msg'=>'we don\'t have skill '.$table_name.' with insuff analyst.' );
					}
				}

			}else{
				$table_name = str_replace('_',' ',$table_name);
				return array('status'=>'2','msg'=>'we don\'t have skill '.$table_name.' with insuff analyst.' );
			}
		}else{

		}
		

		 
	}

	function approveUpdateStatus($candidate_id,$table_name,$component_id){

		$priority = $this->input->post('priority');
		$position = $this->input->post('position');
		$status = $this->input->post('status');

		
		$component_ids = ['14','15','19','21','22'];

		$candidateData = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
		// $candidateInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		$candidateInfo = $this->db->select('*')->from('candidate')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->where('candidate_id',$candidate_id)->get()->row_array();
		$priority = isset($candidateInfo['priority'])?$candidateInfo['priority']:'0';
		if($priority == '0'){
			$tat_days = isset($candidateInfo['low_priority_days'])?$candidateInfo['low_priority_days']:'1';
		}elseif ($priority == '1') {
			$tat_days = isset($candidateInfo['medium_priority_days'])?$candidateInfo['medium_priority_days']:'1';
		}elseif ($priority == '2') {
			$tat_days = isset($candidateInfo['high_priority_days'])?$candidateInfo['high_priority_days']:'1';
		}
		 
		$tat_start_date = '';
		$tat_re_start_date = '';
		$tat_end_date = '';
		$tat_start_flag = '0';
		$tat_re_start_flag = '0';
		if($candidateInfo != null && $candidateInfo != ''){
			if($candidateInfo['tat_start_date'] == null){
				$tat_start_date = date('d-m-Y H:i:s');
				$tat_start_flag = '1';
				$tat_end_date = $this->addBusinessDays($tat_start_date,$tat_days, $holidays=array());

			}else{
				$tat_start_date = $candidateInfo['tat_start_date'];
				$tat_end_date = $this->addBusinessDays($tat_start_date,$tat_days, $holidays=array());
			}

			if($candidateInfo['tat_start_date'] !=null && $candidateInfo['tat_start_date'] != '' && $candidateInfo['tat_pause_date'] != null && $candidateInfo['tat_pause_date'] != '' ){
				$tat_re_start_date = date('d-m-Y H:i:s');
				$tat_re_start_flag = '1';
				$tat_end_date = $this->addBusinessDays($tat_re_start_date,$tat_days, $holidays=array());
			}
		} 

		$variable_array = array(
			'table_name' => $table_name,
			'component_id' => $component_id,
			'priority' => $priority,
			'segment' => $candidateInfo['segment'],
			'client_id' => $candidateInfo['client_id']
		);
 
		$analyst_id = 0;
		if($candidateData != 'null' || $candidateData != ''){
			foreach (explode(',', $candidateData['assigned_team_id']) as $a => $an) {
				if ($an !='' && $an !=0) {
					$analyst_id = $an; 
				}
			}
		}
		if ($analyst_id ==0) { 
			$analyst_id = $this->getMinimumTaskHandlerAnalyst($variable_array);
			$roles = $this->db->select('role')->from('team_employee')->where('team_id',$analyst_id)->get()->row_array();
			
			if ($analyst_id == '') {
				return array('status'=>'201','msg'=>'No Analyst / Specialist currently available for this specific set. Please contact admin to add the same.');
				exit();
			}

		}
		
		if(in_array($component_id,$component_ids) !== -1){

			 
			$form_value = json_decode($candidateInfo['form_values'],true);
			$form_value = json_decode($form_value,true);

			// print_r($form_value[$table_name][0]);
			$form_value_count = isset($form_value[$table_name][0])?$form_value[$table_name][0]:'0';
			$statusValues = array();
			$status_component_ids = ['19','21','22'];
			if(in_array($component_id,$status_component_ids) !== -1){
				$statusValues[0] = '0';
			}else{
				for ($i=0; $i < $form_value_count; $i++) { 
					$statusValues[$i] = '0';
				}
			}
			// echo "statusValues:  ";
			// print_r($statusValues);
			// exit();
			if($analyst_id != '0'){ 
				if($candidateData == 'null' || $candidateData == ''){
					// echo 'if condition';
					// exit();
					$other_status = implode(',', $statusValues);
					
					$inputqcStatus  = array();
					$inputqcStatus[$position] = '4';
					$inputqcStatus = implode(',',$inputqcStatus);

					$analyst_ids =array();
					$analyst_ids[$position] = $analyst_id;
					$analyst_ids = implode(',',$analyst_ids);

					$analyst_roles =array();
					$analyst_roles[$position] = $roles['role'];
					$analyst_roles = implode(',',$analyst_roles);

					$inputqc_status_date = array();
					$inputqc_status_date[$position] = date('d-m-Y H:i:s');
					$inputqc_status_date = implode(',',$inputqc_status_date);

					$componentsData = array(
						'candidate_id' => $candidate_id,
						'status' => $inputqcStatus,
						'inputqc_status_date' => $inputqc_status_date,
						'analyst_status' => $other_status,
						'insuff_team_role' => $other_status,
						'insuff_team_id	' => $other_status,
						'output_status' => $other_status,
						'assigned_role' => $analyst_roles,
						'assigned_team_id' => $analyst_ids,
						'output_status' => $other_status,
					);

					// print_r($componentsData);
					// exit();
					if($this->db->insert($table_name,$componentsData)){
						$this->notificationCreate($candidate_id,$position,$component_id,'4',$analyst_id);
						 
						if($tat_start_flag == '1'){
							$this->tatDateUpdate($candidate_id,$tat_start_date,'tat_start_date','','',$table_name,$position);
						}
						else if($tat_re_start_flag == '1'){
							$this->tatDateUpdate($candidate_id,$tat_re_start_date,'tat_re_start_date',$tat_end_date,$tat_days,$table_name,$position);
						}
						$candidateData = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
						$this->db->insert($table_name.'_log',$componentsData);
						return array('status'=>'1','msg'=>'success');
					}else{
						return array('status'=>'0','msg'=>'failled');
					}

				}else{

					// echo 'else condition';

					$oldStatusString = $candidateData['status']; 
					$assigned_role = $candidateData['assigned_role']; 
					$assigned_team_id = $candidateData['assigned_team_id']; 
					$newUpdatedString = $this->updateArrayValueThroughIndex($oldStatusString,$position,'4');
					$inputqc_status_date = $candidateData['inputqc_status_date'];  
					$date = date('d-m-Y H:i:s');
					$inputqc_status_date = $this->updateArrayValueThroughIndex($inputqc_status_date,$position,$date);
					

					$components_data = array(
					'inputqc_status_date' => $inputqc_status_date,
					'status'=>$newUpdatedString,
					'updated_date'=>date('d-m-Y H:i:s')
					 
					);

					if($this->analystModel->QcExists($candidate_id,$position,$table_name,$status) == '0'){

						
						$analyst_id = $this->updateArrayValueThroughIndex($assigned_team_id,$position,$analyst_id); 
						$role = $this->updateArrayValueThroughIndex($assigned_role,$position,$roles['role']);
						$components_data['assigned_role'] = $role;
						$components_data['assigned_team_id'] = $analyst_id;
					
					} 
	 			
					$user = $this->session->userdata('logged-in-inputqc');
					 
					$this->db->where('candidate_id',$candidate_id);
					if ($this->db->update($table_name,$components_data)) {
						$this->notificationCreate($candidate_id,$position,$component_id,'4',$analyst_id);
						if($tat_start_flag == '1'){
							$this->tatDateUpdate($candidate_id,$tat_start_date,'tat_start_date',$tat_end_date,'',$table_name,$position);
						}
						else if($tat_re_start_flag == '1'){
							$this->tatDateUpdate($candidate_id,$tat_re_start_date,'tat_re_start_date',$tat_end_date,$tat_days,$table_name,$position);
						}

						$candidateData = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
						$this->db->insert($table_name.'_log',$candidateData);

						return array('status'=>'1','msg'=>'success');
					}else{
						return array('status'=>'0','msg'=>'failled');
					}
				}

			}else{
				$table_name = str_replace('_',' ',$table_name);
				return array('status'=>'2','msg'=>'we don\'t have skill '.$table_name.' with analyst.' );
			}

		}else{

			if($analyst_id != '0'){
			
				// echo "\r\n QcExists : ".$this->analystModel->QcExists($candidate_id,$position,$table_name,$status);
				

				$oldStatusString = $candidateData['status']; 
				$assigned_role = $candidateData['assigned_role']; 
				$assigned_team_id = $candidateData['assigned_team_id']; 

				$newUpdatedString = $this->updateArrayValueThroughIndex($oldStatusString,$position,'4');
				
				

				$components_data = array(
				'inputqc_status_date' => $inputqc_status_date,
				'status'=>$newUpdatedString,
				'updated_date'=>date('d-m-Y H:i:s')
				 
				);

				if($this->analystModel->QcExists($candidate_id,$position,$table_name,$status) == '0'){
					
					$analyst_id = $this->updateArrayValueThroughIndex($assigned_team_id,$position,$analyst_id); 
					$role = $this->updateArrayValueThroughIndex($assigned_role,$position,$roles['role']);
					$components_data['assigned_role'] = $role;
					$components_data['assigned_team_id'] = $analyst_id;
				
				} 
 			
				$user = $this->session->userdata('logged-in-inputqc');
				 
				$this->db->where('candidate_id',$candidate_id);
				if ($this->db->update($table_name,$components_data)) {
					 
					if($tat_start_flag == '1'){
						$this->tatDateUpdate($candidate_id,$tat_start_date,'tat_start_date',$tat_end_date,'',$table_name,$position);
					}else if($tat_re_start_flag == '1'){
						$this->tatDateUpdate($candidate_id,$tat_re_start_date,'tat_re_start_date',$tat_end_date,$tat_days,$table_name,$position);
					}

					$this->db->insert($table_name."_log",$components_data);
					return array('status'=>'1','msg'=>'success');
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$table_name = str_replace('_',' ',$table_name);
				return array('status'=>'2','msg'=>'we don\'t have skill '.$table_name.' with analyst.' );
			}
		}
		
		  
	}


	function notificationCreate($case_id,$case_index,$component_id,$component_status,$assigned_team_id){
		// echo 'case_id:'.$case_id;
		// echo '<br>case_index:'.$case_index;
		// echo '<br>component_id:'.$component_id;
		// echo '<br>component_status:'.$component_status;
		// echo '<br>assigned_team_id:'.$assigned_team_id;
		$userInfo = $this->session->userdata('logged-in-inputqc');
	 	$raised_by_team_id =$userInfo['team_id'];
	 	$message ='';
	 	if($component_status == '3'){
	 		$message = $case_id.' number case id Raised Insuff from DataEntry Team.';
	 	}else{
			$message = $case_id.' number case id approved from DataEntry Team.';
	 	}
		$notificationData = array(
		'case_id'=>$case_id,
		'case_index'=>$case_index,
		'component_id'=>$component_id,
		'component_status'=>$component_status,
		'message'=>$message,
		'raised_by_team_id'=>$raised_by_team_id,
		'assigned_team_id'=>$assigned_team_id,		 
		'created_date'=>date('d-m-Y H:i:s'));
		
		if($this->db->insert('notifications',$notificationData)){
			return '1';
		}else{
			return '0';
		}

		 
	}


	function tatDateUpdate($candidate_id,$date,$tat_date_type,$tat_end_date,$tat_days='',$component_name='',$form_number=''){
 		$tat_date_details = array(
 			$tat_date_type => $date,
 			// 'tat_end_date' => $tat_end_date 
 		);

 		if($tat_date_type == 'tat_re_start_date'){
 			$candidate_info = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
 			$usedTatDays = $this->number_of_working_days($candidate_info['tat_start_date'],$candidate_info['tat_pause_date']);
 			$tat_days = $tat_days - $usedTatDays;
 			$tat_end_date = $this->addBusinessDays($date,$tat_days, $holidays=array()); 
 			$tat_date_details['tat_pause_resume_status'] = '2';
 			// $tat_date_details['tat_end_date'] = $tat_end_date;
 		}
 		if($this->db->where('candidate_id',$candidate_id)->update('candidate',$tat_date_details)){
 			$candidateData = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
 			$this->db->insert('candidate_log',$candidateData);
 			$userInfo = $this->session->userdata('logged-in-inputqc');
	 		$userData['team_id'] = $userInfo['team_id'];
			$userData['role'] = $userInfo['role'];
			$userData['team_employee_email'] = $userInfo['team_employee_email'];
			$userData = json_encode($userData);
		
 			$tat_log_data['candidate_id'] = $candidate_id;
 			$tat_log_data['tat_start_date'] = $candidateData['tat_start_date'];
 			$tat_log_data['tat_end_date'] =  $candidateData['tat_end_date'];
 			$tat_log_data['tat_pause_date'] =  $candidateData['tat_pause_date'];
 			$tat_log_data['tat_re_start_date'] =  $candidateData['tat_re_start_date'];
 			$tat_log_data['component_id'] =  $this->utilModel->getComponentId($component_name);
 			$tat_log_data['component_name'] =  $component_name;
 			$tat_log_data['form_number'] = $form_number;
 			$tat_log_data['user_detail'] = $userData;
 			$this->db->insert('tat_date_log',$tat_log_data); 
 			return '1'; 
 		}else{
 			return "0";
 		}
	} 


	


	function number_of_working_days($from, $to) {
	    $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
	    // $holidayDays = ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays
	    $holidayDays = []; # variable and fixed holidays

	    $from = new DateTime($from);
	    $to = new DateTime($to);
	    // $to->modify('+1 day');
	    $interval = new DateInterval('P1D');
	    $periods = new DatePeriod($from, $interval, $to);

	    $days = 0;
	    foreach ($periods as $period) {
	        if (!in_array($period->format('N'), $workingDays)) continue;
	        if (in_array($period->format('d-m-Y'), $holidayDays)) continue;
	        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
	        $days++;
	    }
	    return $days;
	}
 
	
	function addBusinessDays($startDate='', $businessDays='', $holidays=array()){
	 // function addBusinessDays(){
		$startDate=date("d-m-Y H:i:s");
		$businessDays=15;
		// $holidays=array('2021-08-25'); 
	    $date = strtotime($startDate);
	    $i = 0;
	    
	    while($i < $businessDays){

	        //get number of week day (1-7)
	        $day = date('N',$date);
	        //get just d-m-Y date
	        $dateYmd = date("d-m-Y",$date);

	        if($day < 6 && !in_array($dateYmd, $holidays)){
	            $i++;
	        }       
	        $date = strtotime($dateYmd . ' +1 day');
	    }       
	    // print_r(date("d-m-Y H:i:s"));
	    // echo "<br>";
    	// print_r(date('d-m-Y H:i:s',$date));
    	return date('d-m-Y H:i:s',$date);
	}



	function updateArrayValueThroughIndex($oldString,$pos,$newValue){
		// echo "<br>";
		// print_r($oldString);
		// echo "<br>";
		// print_r($pos);
		// echo "<br>";
		// print_r($newValue);
		// echo "<br>";
		$value = explode(',',$oldString);
		// $pos = 1;
		// $new = 9;
		$value[$pos] = $newValue; 
		$newString = implode(',',$value);
		return $newString;
	}


	function getMinimumTaskHandlerInputQC(){
 
		$count = array(); 
		$result = $this->db->select('team_id')->where('role','inputqc')->where('is_Active','1')->get('team_employee')->result_array(); 

		foreach ($result as $key => $value) {
			$candidate_detail = $this->db->where('is_submitted !=','2')->where('assigned_inputqc_id',$value['team_id'])->get('candidate')->num_rows();
			$row['team_id'] = $value['team_id'];
			$row['total'] = $candidate_detail;
			array_push($count, $row); 
		}
		
		$keys = array_column($count, 'total'); 
    	array_multisort($keys, SORT_ASC, $count); 
    	return $count[0]['team_id'];    	 
	}

	
	
	function getMinimumTaskHandlerAnalyst($variable_array) {
		$priority = isset($variable_array['priority']) ? $variable_array['priority'] : 0;
		$component_id = isset($variable_array['component_id']) ? $variable_array['component_id'] : 0;
		$table_name = isset($variable_array['table_name']) ? $variable_array['table_name'] : 'adverse_database_media_check';
		$segment = isset($variable_array['segment']) ? $variable_array['segment'] : 0;
		$client_id = isset($variable_array['client_id']) ? $variable_array['client_id'] : 0;

		$assigned_segment_query = '';
		if ($segment != '' && $segment != 0) {
			$assigned_segment_query = ' AND assigned_segments REGEXP '.$segment;
		}
		$pv_iv_status = '';
		if($client_id !=0 && in_array($component_id,['8','9','12'])){
			$client = $this->db->where('client_id',$client_id)->get('tbl_client')->row_array();
			 
			 if ($client['iverify_or_pv_status'] !=0 && $component_id == '8' ) {
			 	if ($client['iverify_or_pv_status'] =='1') {
			 		$pv_iv_status = ' AND present_address_iverify_status =1'; 
			 	}else{
			 		$pv_iv_status = ' AND present_address_pv_status =1'; 
			 	}
			 }else if ($client['iverify_or_pv_status'] !=0 && $component_id == '9' ) {
			 	if ($client['iverify_or_pv_status'] =='1') {
			 		$pv_iv_status = ' AND permanent_address_iverify_status =1'; 
			 	}else{
			 		$pv_iv_status = ' AND permanent_address_pv_status =1'; 
			 	}
			 }else if ($client['iverify_or_pv_status'] !=0 && $component_id == '12' ) {
			 	if ($client['iverify_or_pv_status'] =='1') {
			 		$pv_iv_status = ' AND previous_address_iverify_status =1'; 
			 	}else{
			 		$pv_iv_status = ' AND previous_address_pv_status =1'; 
			 	}
			 }  


		}

		$count = array(); 
		$team_id = '0'; 
		if($priority == '2'){
			// echo "if\n";
			$query = "SELECT * FROM `team_employee` where `role` ='specialist' AND `is_Active`='1' AND `skills` REGEXP ".$component_id.$assigned_segment_query.$pv_iv_status;
			// echo $query."\n";
			// exit();
		} else {
			// echo "else\n";
			$query = "SELECT * FROM `team_employee` where (`role` ='analyst' OR `role` ='specialist') AND `is_Active`='1' AND `skills` REGEXP ".$component_id.$assigned_segment_query.$pv_iv_status;
		}
		
		$result = $this->db->query($query)->result_array();  

		$newTeamIds = array();
		$team_id = '';
		if($this->db->query($query)->num_rows() > 0){
			
			foreach ($result as $key => $value) {
				// echo $value['team_id'].":".$value['skills']."\n";
				$skill = explode(',',$value['skills']);
				if (in_array($component_id,$skill)) {
					// echo $value['team_id'].":".$value['skills']."\n";
					array_push($newTeamIds,$value['team_id']);
				}
				 
			}

			// echo "\n";
			// print_r($newTeamIds);

			// exit();
			if(count($newTeamIds) > 0){
			// if($this->db->query($query)->num_rows() > 0){
				foreach ($newTeamIds as $key => $newTeamIds_value) {
					 
					$analyst_data = $this->db->query("SELECT * FROM ".$table_name." where `assigned_team_id` REGEXP ".$newTeamIds_value)->num_rows();//$this->db->where('assigned_team_id',$value['team_id'])->get($table_name)->num_rows();

					$row['team_id'] = $newTeamIds_value;
					$row['total'] = $analyst_data;

					array_push($count, $row); 
				}
				$keys = array_column($count, 'total'); 
	    		array_multisort($keys, SORT_ASC, $count);
	    		$team_id = $count[0]['team_id'];
			}
		}
    	// print_r($count);
		// echo $count[0]['team_id'];
    	return $team_id;    	 
	}
	function valid_phone_number($number){
		$result = $this->db->where('phone_number',$number)->get('candidate');
		if ($result->num_rows() > 0) {
			return array('status'=>'0','msg'=>'faliled');
		}else{
			 return array('status'=>'1','msg'=>'success');
		}
	}

	
	function insert_bulk_case($bulk_case){
		if (count($bulk_case) == 0) {
			return array('status'=>'0','msg'=>'faliled');
		}
		if ($this->db->insert_batch('candidate',$bulk_case)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'1','msg'=>'success');
		}
	}

	function getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,$component_id,$priority){
 		
		$count = array(); 
		$team_id = '0'; 
		
		// $query = "SELECT * FROM `team_employee` where (`role` ='insuff analyst' OR `role` ='insuff specialist') AND `is_Active`='1' AND `skills` REGEXP ".$component_id;
		$query = "SELECT * FROM `team_employee` where `role` ='insuff analyst' AND `is_Active`='1' AND `skills` REGEXP ".$component_id;
		 
 		
		$result = $this->db->query($query)->result_array();  
		$newTeamIds = array();
		if($this->db->query($query)->num_rows() > 0){

			foreach ($result as $key => $value) {
				// echo $value['team_id'].":".$value['skills']."\n";
				$skill = explode(',',$value['skills']);
				if (in_array($component_id,$skill)) {
					// echo $value['team_id'].":".$value['skills']."\n";
					array_push($newTeamIds,$value['team_id']);
				}
				 
			}
		
			if(count($newTeamIds) > 0){
				foreach ($result as $key => $value) {
					 
					$analyst_data = $this->db->query("SELECT * FROM ".$table_name." where `assigned_team_id` REGEXP ".$value['team_id'])->num_rows();//$this->db->where('assigned_team_id',$value['team_id'])->get($table_name)->num_rows();

					$row['team_id'] = $value['team_id'];
					$row['total'] = $analyst_data;

					array_push($count, $row); 
				}
				$keys = array_column($count, 'total'); 
	    		array_multisort($keys, SORT_ASC, $count);
	    		$team_id = $count[0]['team_id'];
			} 
		} 

    	return $team_id;    	 
	}

	 


	function add_request_form(){ 
		$user = $this->session->userdata('logged-in-inputqc');
		$client_id =  $this->input->post('client_id');
		$component_id = $this->input->post('comonent_id');
		$number_of_form = $this->input->post('number_of_form');
		$package_id = $this->input->post('package_id');
		$form_request = array(
		'client_id' => $client_id,
		'component_id' => $component_id,
		'package_id' => $package_id,
		'form_up_to' => $number_of_form,
		'added_by'=>$user['team_id'],
		'added_role' => $user['role'],
		); 
		// return $form_request;
		if ($this->db->insert('form_request',$form_request)) {
			 return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'faliled');
		}
	}


	function get_request_details(){
		$result = $this->db->get('form_request')->result_array();

		$request = array();
		foreach ($result as $key => $value) { 
			$clent = $this->db->where('client_id',$value['client_id'])->get('tbl_client')->row_array();  
			$client_name = $clent['client_name'];
			$name = '';
			if ($value['added_role'] !='client') {
				$clent = $this->db->where('team_id',$value['added_by'])->get('team_employee')->row_array();
				$name = $clent['first_name'];
			}else{
				$name =  $clent['client_name'];
			}
			$pack = $this->db->where('package_id',$value['package_id'])->get('packages')->row_array();
			$component = $this->db->where('component_id',$value['component_id'])->get('components')->row_array();
			$row['request_id'] = $value['request_id'];
			$row['client_id'] = $value['client_id'];
			$row['client_name'] =$client_name;
			$row['component_id'] = $value['component_id'];
			$row['component_name'] = $component['component_name'];
			$row['package_id'] = $value['package_id'];
			$row['package_name'] = $pack['package_name'];
			$row['form_up_to'] = $value['form_up_to'];
			$row['added_by'] = $value['added_by'];
			$row['added_by_name'] = $name;
			$row['added_role'] = $value['added_role'];
			$row['status'] = $value['status']; 

			array_push($request, $row);
		}

		return $request;
	}



	function remove_single_cases_detail(){
		$candidate_id = $this->input->post('id');
		if ($candidate_id =='' || $candidate_id == null) {
			return array('status'=>0,'msg'=>'failled');
		}
		if ($this->db->where('candidate_id',$candidate_id)->delete('candidate')) {
			return array('status'=>1,'msg'=>'success');
		}else{
			return array('status'=>0,'msg'=>'failled');
		}
	}


	function valid_mail() {
		if ($this->input->post('candidate_id')) {
			$this->db->where('candidate_id !=',$this->input->post('candidate_id'));
		}
		$result = $this->db->where('email_id',$this->input->post('email'))->get('candidate')->num_rows();
		if ($result > 0) {
			return array('status'=>'0','msg'=>'faliled');			
		} else {
			return array('status'=>'1','msg'=>'success');
		}
	}

	/* inputqc */

	function update_candidate_criminal_check(){
		$criminal_data = array( 
			'address'=>$this->input->post('address'),
			'pin_code'=>$this->input->post('pincode'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'), 
		);
 
		$result = '';
		 
			$this->db->where('criminal_check_id',$this->input->post('criminal_checks_id'));
			$result = $this->db->update('criminal_checks',$criminal_data);
 
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_candidate_court_record(){
		$court_record = array( 
			'address'=>$this->input->post('address'),
			'pin_code'=>$this->input->post('pincode'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'), 
		);
 
		$result = '';
		 
			$this->db->where('court_records_id',$this->input->post('court_records_id'));
			$result = $this->db->update('court_records',$court_record);
 
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_candidate_document_check(){
		$document_check = array( 
			'aadhar_number'=>$this->input->post('adhar_number'),
			'pan_number'=>$this->input->post('pancard'),
			'passport_number'=>$this->input->post('passport_number'), 
		);
 
		$result = '';
		 
			$this->db->where('document_check_id',$this->input->post('document_check_id'));
			$result = $this->db->update('document_check',$document_check);
 
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}



	function update_candidate_drug_test(){
		$drugtest = array( 
			'address'=>$this->input->post('address'),
			'candidate_name'=>$this->input->post('name'),
			'father__name'=>$this->input->post('father_name'),
			'dob'=>$this->input->post('date_of_birth'), 
			'mobile_number'=>$this->input->post('contact_no'), 
		);
 
		$result = '';
		 
			$this->db->where('drugtest_id',$this->input->post('drugtest_id'));
			$result = $this->db->update('drugtest',$drugtest);
 
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}



	function update_candidate_global(){
		$globaldatabase = array(  
			'candidate_name'=>$this->input->post('name'),
			'father_name'=>$this->input->post('father_name'),
			'dob'=>$this->input->post('date_of_birth'),  
		);
 
		$result = '';
		 
			$this->db->where('globaldatabase_id',$this->input->post('global_id'));
			$result = $this->db->update('globaldatabase',$globaldatabase);
 
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_employment(){
		$employment_data = array( 
			'desigination'=>$this->input->post('designation'), 
			'department'=>$this->input->post('department'), 
			'employee_id'=>$this->input->post('employee_id'), 
			'company_name'=>$this->input->post('company_name'), 
			'address'=>$this->input->post('address'), 
			'annual_ctc'=>$this->input->post('annual_ctc'), 
			'reason_for_leaving'=>$this->input->post('reasion'), 
			'joining_date'=>$this->input->post('joining_date'), 
			'relieving_date'=>$this->input->post('relieving_date'), 
			'reporting_manager_name'=>$this->input->post('manager_name'), 
			'reporting_manager_desigination'=>$this->input->post('manager_designation'), 
			'reporting_manager_contact_number'=>$this->input->post('manager_contact'),  
			'hr_name'=>$this->input->post('hr_name'),
			'hr_contact_number'=>$this->input->post('hr_contact'),  
		);
 
		$result = '';
		 
			$this->db->where('current_emp_id',$this->input->post('current_emp_id'));
			$result = $this->db->update('current_employment',$employment_data);
 
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}



	function update_candidate_present_address(){ 
		$present_data = array( 
			'flat_no'=>$this->input->post('house'),
			'street'=>$this->input->post('street'),
			'area'=>$this->input->post('area'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'pin_code'=>$this->input->post('pincode'), 
			'nearest_landmark'=>$this->input->post('land_mark'),
			'duration_of_stay_start'=>$this->input->post('start_date'),
			'duration_of_stay_end'=>$this->input->post('end_date'), 
			'contact_person_name'=>$this->input->post('name'),
			'contact_person_relationship'=>$this->input->post('relationship'),
			'contact_person_mobile_number'=> $this->input->post('contact_no'), 
		);

	 
	$result = '';
	 
			$this->db->where('present_address_id',$this->input->post('present_address_id'));
			$result = $this->db->update('present_address',$present_data);
 

		if ($result == true) {

		// if ( $this->db->insert('present_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


		function update_candidate_education_details(){
  
		$eduction_data = array( 
			'type_of_degree'=>$this->input->post('type_of_degree'),
			'major'=>$this->input->post('major'),
			'university_board'=>$this->input->post('university'),
			'college_school'=>$this->input->post('college_name'),
			'address_of_college_school'=>$this->input->post('address'),
			'course_start_date'=>$this->input->post('course_start_date'),
			'registration_roll_number'=>$this->input->post('registration_roll_number'), 
			'course_end_date'=>$this->input->post('course_end_date'),  
			'type_of_course'=>$this->input->post('time'),    
		);
 
		$result = ''; 
			$this->db->where('education_details_id',$this->input->post('education_details_id'));
			$result = $this->db->update('education_details',$eduction_data);
 
		if ($result == true) {
		// if ($this->db->insert('education_details',$eduction_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}




	function update_candidate_previous_address(){
		 
		$present_data = array( 
			'flat_no'=>$this->input->post('permenent_house'),
			'street'=>$this->input->post('permenent_street'),
			'area'=>$this->input->post('permenent_area'),
			'city'=>$this->input->post('permenent_city'),
			'pin_code'=>$this->input->post('permenent_pincode'), 
			'nearest_landmark'=>$this->input->post('permenent_land_mark'),
			'duration_of_stay_start'=>$this->input->post('permenent_start_date'),
			'duration_of_stay_end'=>$this->input->post('permenent_end_date'),
			'is_present'=>$this->input->post('permenent_present'),
			'contact_person_name'=>$this->input->post('permenent_name'),
			'contact_person_relationship'=>$this->input->post('permenent_relationship'),
			'contact_person_mobile_number'=> $this->input->post('permenent_contact_no'), 
		); 

	 
	$result = '';
		 
			$this->db->where('previos_address_id',$this->input->post('previos_address_id'));
			$result = $this->db->update('previous_address',$present_data);

			$insert_id = $this->input->post('previos_address_id');
		 
		if ($result == true) {

		// if ( $this->db->insert('previous_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}



	function update_candidate_previous_employment() { 
		$employment_data = array( 
			'desigination'=>$this->input->post('designation'), 
			'department'=>$this->input->post('department'), 
			'employee_id'=>$this->input->post('employee_id'), 
			'company_name'=>$this->input->post('company_name'), 
			'address'=>$this->input->post('address'), 
			'annual_ctc'=>$this->input->post('annual_ctc'), 
			'reason_for_leaving'=>$this->input->post('reasion'), 
			'joining_date'=>$this->input->post('joining_date'), 
			'relieving_date'=>$this->input->post('relieving_date'), 
			'reporting_manager_name'=>$this->input->post('manager_name'), 
			'reporting_manager_desigination'=>$this->input->post('manager_designation'), 
			'reporting_manager_contact_number'=>$this->input->post('manager_contact'), 
			'hr_name'=>$this->input->post('hr_name'),
			'hr_contact_number'=>$this->input->post('hr_contact'), 
		);

 
		$result = '';
	 
			$this->db->where('previous_emp_id',$this->input->post('previous_emp_id'));
			$result = $this->db->update('previous_employment',$employment_data);

	 
		if ($result == true) {
		// if ($this->db->insert('previous_employment',$employment_data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}


	}



	function update_candidate_reference(){ 
 
		$reference_data = array( 
			'name'=>$this->input->post('name'),
			'company_name'=>$this->input->post('company_name'),
			'designation'=>$this->input->post('designation'),
			'contact_number'=>$this->input->post('contact'), 
			'email_id'=>$this->input->post('email'),
			'years_of_association'=>$this->input->post('association'),
			'contact_start_time'=>$this->input->post('start_date'),
			'contact_end_time'=>$this->input->post('end_date'), 
		);


	$result = '';
		 
			$this->db->where('reference_id',$this->input->post('reference_id'));
			$result = $this->db->update('reference',$reference_data);
 
		if ($result == true) {
 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_address() { 
		$permenent_data = array( 
			'flat_no'=>$this->input->post('permenent_house'),
			'street'=>$this->input->post('permenent_street'),
			'area'=>$this->input->post('permenent_area'),
			'city'=>$this->input->post('permenent_city'),
			'state'=>$this->input->post('permenent_state'),
			'pin_code'=>$this->input->post('permenent_pincode'), 
			'nearest_landmark'=>$this->input->post('permenent_land_mark'),
			'duration_of_stay_start'=>$this->input->post('permenent_start_date'),
			'duration_of_stay_end'=>$this->input->post('permenent_end_date'),
			'is_present'=>$this->input->post('permenent_present'),
			'contact_person_name'=>$this->input->post('permenent_name'),
			'contact_person_relationship'=>$this->input->post('permenent_relationship'),
			'contact_person_mobile_number'=> $this->input->post('permenent_contact_no'), 
		);

		 
		$result = '';
			$this->db->where('permanent_address_id',$this->input->post('permanent_address_id'));
			$result = $this->db->update('permanent_address',$permenent_data);
 
		if ($result == true) {
			// if ( $this->db->insert('present_address',$present_data)) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
 
	}


 	 
}	
?>