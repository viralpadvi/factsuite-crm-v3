<?php
/**
 * 
 */
class CandidateLogin extends CI_Controller
{

	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url'); 
	  	$this->load->model('loginModel'); 
	  	$this->load->model('candidateModel'); 
	  	$this->load->model('emailModel'); 
	  	$this->load->model('smsModel'); 
	  	$this->load->model('check_Candidate_Login_Model');
	}

	function valid_login_auth() {
		$data = $this->loginModel->valid_login_auth();
		if ($data['status'] == '1') {
			// if ($data['user']['is_submitted'] == '0' || $data['user']['is_submitted'] == '3') {
			// 	// $this->trigger_sms_email($data['user']);
			// 	$this->loginModel->login_logs($data['user']);
			// 	$this->session->set_userdata('logged-in-candidate',$data['user']);
			// }
		}
		echo json_encode($data);
	}

	function logout() {
		$redirect_url = $this->config->item('my_base_url');
		
		$user = $this->session->userdata('logged-in-candidate');
		if (strtolower($user['document_uploaded_by']) == 'client') {
			$redirect_url = $this->config->item('client_url_for_redirecting_to_client_module');
		} else if(strtolower($user['document_uploaded_by']) == 'inputqc') {
			$redirect_url = $this->config->item('inputqc_url_for_redirecting_to_client_module');
		}
		// print_r($redirect_url);
		// exit();
		$this->session->unset_userdata('logged-in-candidate');
		$this->session->unset_userdata('candidate_details_submitted_by');
 		redirect($redirect_url);
	}

	function checkedOtp() {
		// $this->check_Candidate_Login_Model->check_candidate_login();
		$data = $this->loginModel->checkedOtp();
		$user = $this->session->userdata('logged-in-candidate');
		$link_request_from = $this->input->post('link_request_from') ? $this->input->post('link_request_from') : '';
		if ($data['status'] == '1') { 
			$data['user_name'] = strtolower(trim($user['first_name']).'-'.trim($user['last_name']));
			if ($user['is_submitted'] != '3' && $user['case_reinitiate'] !='1') {
				 
				$component_ids = array();
				$redirect = '0';
				$table = $this->candidateModel->all_components($user['candidate_id']); 
				foreach (explode(',', $user['component_ids']) as $key => $value) {
					if (!in_array($value,array('14','15','19','21','24'))) { 
						array_push($component_ids,$value);
						$tabl = $this->candidateModel->getComponent_or_PageName($value);
						$criminal_checks = explode(',', isset($table[$tabl]['analyst_status'])?$table[$tabl]['analyst_status']:'NA');
						if ($redirect =='0' && in_array('NA', $criminal_checks)) {
							$redirect = $value;
						} 

					}
				}
			 	$this->session->set_userdata('component_ids',implode(',', $component_ids));
			 	$data['is_submitted'] = '1';
			 	$data['redirect_url'] = '';
			 	if ($user['personal_information_form_filled_by_candidate_status'] == 1) {
			 		$data['redirect_url'] = $this->candidateModel->redirect_url($redirect,$link_request_from);
			 	}
			 	$this->session->set_userdata('is_submitted',1);
			} else {

				$table = $this->candidateModel->all_components($user['candidate_id']); 
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
				$data['redirect_url'] = $this->candidateModel->redirect_url(isset($status[0])?$status[0]:0,$link_request_from);
			}	 
		}
		echo json_encode($data);
	}

	function resend_otp() {
		// $this->check_Candidate_Login_Model->check_candidate_login();
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('user_otps')) {
			$this->trigger_sms_email($this->session->userdata('user_otps'));
			echo json_encode(array('status'=>'1','message'=>'OTP sent successfully'));
		} else {
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
		}
	}

	function trigger_sms_email($data) {
		$client_email_id = strtolower($data['email_id']);
		// Send To User Starts
		$client_email_subject = 'Get Password – Verification Process - FactSuite';
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
		$email_message .= "<p>Dear ".$data['first_name']." ".$data['last_name']."</p>";
		$email_message .= '<p>Greetings from Factsuite!!</p>';
		$email_message .= '<p>'.$data['client_name'].' has partnered with Factsuite to conduct your background verification.</p>';
		$email_message .= '<p>To proceed with your verification, we request you to kindly fill the information as requested on the Factsuite CRM application.</p>';
		$email_message .= '<p>In case of any queries, please reach out to us at help@factsuite.com</p>';
		$email_message .= '<p>Please find your Login Credentials mentioned below to access the FactSuite CRM:</p>';
		$email_message .= '<table>';
		$email_message .= '<th>CRM Link</th>';
		$email_message .= '<th>Mobile Number</th>';
		$email_message .= '<th>Login ID</th>';
		$email_message .= '<th>OTP</th>';
		$email_message .= '<tr>';
		$email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
		$email_message .= '<td>'.$data['phone_number'].'</td>';
		$email_message .= '<td>'.$data['loginId'].'</td>';
		$email_message .= '<td>'.$data['otp_password'].'</td>';//http://localhost:8080/factsuitecrm/
		$email_message .= '<tr>';
		$email_message .= '</table>';
		$email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free verification of your profile.</p>';
		$email_message .= '<p><b>Yours sincerely,<br>';
		$email_message .= 'Team FactSuite</b></p>';
		$email_message .= '</body>';
		$email_message .= '</html>';

		$smsStatus = $this->smsModel->send_sms($data['first_name'],$data['client_name'],$data['phone_number'],$data['otp_password'],'1');
		$this->emailModel->send_mail($client_email_id,$client_email_subject,$email_message);
	}
}