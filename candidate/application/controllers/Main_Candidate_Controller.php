<?php
/**
 * 
 */
class Main_Candidate_Controller extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url'); 
	  	$this->load->model('candidateModel');
	  	$this->load->model('check_Candidate_Login_Model');
	  	$this->load->model('candidate_Util_Model');
	}

	function index() {
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('login');
		} else {
			$data['county_code'] = file_get_contents(base_url().'assets/custom-js/json/country-code.json');
			$this->load->view('candidate/v2/sign-in-header');
			$this->load->view('candidate/v2/index',$data);
			$this->load->view('candidate/v2/sign-in-footer');
		}
	}

	function m_index() {
		// $this->load->view('candidate-mobile/index');
		$this->load->view('candidate-mobile/v2/sign-in-header-v2');
		$this->load->view('candidate-mobile/v2/index-v2');
		$this->load->view('candidate-mobile/v2/sign-in-footer-v2');
	}

	function m_get_started() {
		$this->load->view('candidate-mobile/get-started');	
	}

	function m_sign_in() {
		$data['county_code'] = file_get_contents(base_url().'assets/custom-js/json/country-code.json');
		// $this->load->view('candidate-mobile/sign-in');
		$this->load->view('candidate-mobile/v2/sign-in-header-v2');
		$this->load->view('candidate-mobile/v2/index-v2',$data);
		$this->load->view('candidate-mobile/v2/sign-in-footer-v2');
	}

	function sign_in_otp() {
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('sign-in-otp'); 
		} else {
			$data['county_code'] = file_get_contents(base_url().'assets/custom-js/json/country-code.json');
			$this->load->view('candidate/v2/sign-in-header');
			$this->load->view('candidate/v2/enter-otp',$data);
			$this->load->view('candidate/v2/sign-in-footer');
		}
	}

	function m_verify_otp() {
		// $this->load->view('candidate-mobile/verify-otp');
		$this->load->view('candidate-mobile/v2/sign-in-header-v2');
		$this->load->view('candidate-mobile/v2/otp-v2');
		$this->load->view('candidate-mobile/v2/sign-in-footer-v2');
	}

	function m_verification_steps() {
		$this->check_Candidate_Login_Model->check_candidate_login();
		$user = $this->session->userdata('logged-in-candidate');
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components();
		$this->load->view('candidate-mobile/v2/main-header');
		$this->load->view('candidate-mobile/v2/verification-steps',$data);
		$this->load->view('candidate-mobile/v2/main-footer');
	}

	function candidate_form_fill_data() {
		$this->check_Candidate_Login_Model->check_candidate_login();
		$user = $this->session->userdata('logged-in-candidate');
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries();  
		$data['state'] = $this->candidateModel->get_all_states(); 
		$data['get_timezone_details'] = $this->candidate_Util_Model->get_timezone_details();
		
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			// $this->load->view('candidate-common/sidebar',$data);
			$this->load->view('candidate/candidate-information',$data);
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/personal-information',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}

	function m_component_list() {
		$this->check_Candidate_Login_Model->check_candidate_login();
		$user = $this->session->userdata('logged-in-candidate');
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components();
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/candidate-selected-component-list');
			$this->load->view('candidate-common/mobile-footer');
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/verification-component-list',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function address_details() {
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(9,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			if ($data['is_submitted'] == '3' && in_array('9',explode(',', $data['component_ids']))) {
				$this->load->view('candidate/insuff/address-details-insuff',$data);
			} else { 
				$this->load->view('candidate/address-details',$data);
			}
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/permanent-address',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}

	function present_address_details(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(8,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			if ($data['is_submitted'] == '3' && in_array('8',explode(',', $data['component_ids']))) {
				$this->load->view('candidate/insuff/present-address-insuff',$data);
			}else{ 
				$this->load->view('candidate/present-address',$data);
			} 
			// $this->load->view('candidate/present-address',$data);
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/present-address',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}

	function previous_address_details(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(12,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			if ($data['is_submitted'] == '3' && in_array('12',explode(',', $data['component_ids']))) {
				$this->load->view('candidate/insuff/previous-address-insuff',$data);
			} else { 
				$this->load->view('candidate/previous-address',$data);
			} 
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/previous-address',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}

	function education_details(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(7,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components();
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states();  
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		 
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			 
			if ($data['is_submitted'] == '3' && in_array('7',explode(',', $data['component_ids']))) {
			$this->load->view('candidate/insuff/education-details-insuff',$data);
		}else{ 
			$this->load->view('candidate/education-details',$data);
		} 
			 
			$this->load->view('candidate-common/footer',$data);	
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/education',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}

	function employment_details(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(6,explode(',', $user['component_ids']))) {
			redirect(base_url()); 
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		 

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			 
			if ($data['is_submitted'] == '3' && in_array('6',explode(',', $data['component_ids']))) {
				$this->load->view('candidate/insuff/employment-details-insuff',$data);
			}else{ 
				$this->load->view('candidate/employment-details',$data);
			} 
			$this->load->view('candidate-common/footer',$data);	
		}else{
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/current-employment',$data);
			$this->load->view('candidate-common/footer-v2',$data);	
		}

		
	}

	function previous_employment_details(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(10,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
		 
			if ($data['is_submitted'] == '3' && in_array('10',explode(',', $data['component_ids']))) {
				$this->load->view('candidate/insuff/present-employment-details-insuff',$data);
			} else {
				$this->load->view('candidate/present-employment-details',$data);
			} 

			$this->load->view('candidate-common/footer',$data);	
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/previous-employment',$data);
			$this->load->view('candidate-common/footer-v2',$data);	
		}
	}
	
	function reference(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(11,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		 	

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			 
			if ($data['is_submitted'] == '3' && in_array('11',explode(',', $data['component_ids']))) {
			$this->load->view('candidate/insuff/reference-insuff',$data);
		}else{ 
			$this->load->view('candidate/reference',$data);
		} 
			 
			$this->load->view('candidate-common/footer',$data);	
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/reference',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}
	
	function court_record(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(2,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data); 
			if ($data['is_submitted'] == '3' && in_array('2',explode(',', $data['component_ids']))) {
				$this->load->view('candidate/insuff/court-record-insuff',$data);
			}else{ 
				$this->load->view('candidate/court-record',$data);
			} 
			
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/court-record',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}

	}
	
	function criminal_check(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(1,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		 
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			 
		if ($data['is_submitted'] == '3' && in_array('1',explode(',', $data['component_ids']))) {
			$this->load->view('candidate/insuff/criminal-check-insuff',$data);
		}else{ 
			$this->load->view('candidate/criminal-check',$data);
		}  
			 
			$this->load->view('candidate-common/footer',$data);	
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/criminal-check',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}
	

	function civil_check(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(26,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code; 
		 
		/*if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data); 
			$this->load->view('candidate/civil-check',$data); 
			$this->load->view('candidate-common/footer',$data);	
		} else {*/
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/civil-check',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		// }
	}
	

	function document_check(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(3,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		 

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data); 
			if ($data['is_submitted'] == '3' && in_array('3',explode(',', $data['component_ids']))) {
				$this->load->view('candidate/insuff/document-check-insuff',$data);
			}else{ 
				$this->load->view('candidate/document-check',$data);
			} 
			
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/document-check',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}

	}
	
	function drug_test(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(4,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
			

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			 
			if ($data['is_submitted'] == '3' && in_array('4',explode(',', $data['component_ids']))) {
				$this->load->view('candidate/insuff/drug-test-insuff',$data);
			}else{ 
				$this->load->view('candidate/drug-test',$data);
			} 
			
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/drug-test',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}

	}
	 	
	function global_database(){
		$user = $this->session->userdata('logged-in-candidate');
		if (!in_array(5,explode(',', $user['component_ids']))) {
			redirect(base_url());
		}
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
		$this->load->view('candidate-common/menu',$data);
		 
		if ($data['is_submitted'] == '3' && in_array('5',explode(',', $data['component_ids']))) {
			$this->load->view('candidate/insuff/global-database-insuff',$data);
		}else{ 
			$this->load->view('candidate/global-database',$data);
		} 
		
		$this->load->view('candidate-common/footer',$data);	
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/global-database',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}
	 
	function signature(){ 
		$user = $this->session->userdata('logged-in-candidate');
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states();
		$data['candidate_details'] = $this->db->where('candidate_id',$user['candidate_id'])->get('candidate')->row_array();
		$data['client_details'] = $this->db->select('client_name,tv_or_ebgv,signature')->where('client_id',$user['client_id'])->get('tbl_client')->row_array();

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			// $this->load->view('candidate-common/sidebar',$data);
			$this->load->view('candidate/signature',$data);
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/consent-form',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}	
	}

	/*new component add*/
	function candidate_driving_licence(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			// $this->load->view('candidate-common/sidebar',$data);
			$this->load->view('candidate/candidate-driving-licence',$data);
			$this->load->view('candidate-common/footer',$data);	
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/driving-license',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}

	function candidate_cv_check(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			// $this->load->view('candidate-common/sidebar',$data);
			$this->load->view('candidate/candidate-cv-check',$data);
			$this->load->view('candidate-common/footer',$data);	
		}else{
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/cv-check',$data);
			$this->load->view('candidate-common/footer-v2',$data);	
		}
		
	}

	function candidate_credit_cibil(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data); 
			if ($data['is_submitted'] == '3' && in_array('17',explode(',', $data['component_ids']))) {
			$this->load->view('candidate/insuff/candidate-credit-cibil-insuff',$data);
		}else{ 
			$this->load->view('candidate/candidate-credit-cibil',$data);
		}
			
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/credit',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}

	}
	function candidate_bankruptcy(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		 
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data); 
			if ($data['is_submitted'] == '3' && in_array('18',explode(',', $data['component_ids']))) {
			$this->load->view('candidate/insuff/candidate-bankruptcy-insuff',$data);
		}else{ 
			$this->load->view('candidate/candidate-bankruptcy',$data);
		}
			
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/benkruptcy',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}

	}
	function candidate_landload_reference(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
		$this->load->view('candidate-common/menu',$data);
		 
			$this->load->view('candidate/candidate-landlord-reference',$data);
		 
		$this->load->view('candidate-common/footer',$data);	
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/previous-landloard',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}

	function candidate_social_media(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			$this->load->view('candidate/candidate-social-media',$data);
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/social-media',$data);
			$this->load->view('candidate-common/footer-v2',$data);	
		}
	}

	function candidate_employee_gap_check(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
		 
			$this->load->view('candidate/employment-gap-check',$data);
		 
			$this->load->view('candidate-common/footer',$data);
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/employment-gap',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}
	}


	function candidate_additional(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted'); 
		$data['log'] = $this->db->where('client_id',$user['client_id'])->get('custom_logo')->row_array();
		

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/header',$data);
			$this->load->view('candidate-common/menu',$data);
			 
			$this->load->view('candidate/additional-docs',$data);
			 
			$this->load->view('candidate-common/footer',$data);	
		} else {
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/additional-doc',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		}

	}


	function candidate_sex_offender(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			 
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/sex-offender',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		 
	}

	function candidate_politically_exposed(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			 
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/politically_exposed',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		 
	}

	function candidate_india_civil_litigation(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			 
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/india_civil_litigation',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		 
	}

 
	function candidate_mca(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			 
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/mca',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		 
	}

 
	function candidate_gsa(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			 
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/gsa',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		 
	}

 
	function candidate_oig(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			 
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/oig',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		 
	}

 
	function candidate_right_to_work(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			 
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/right-to-work',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		 
	}

 
	function candidate_nric(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			 
			$this->load->view('candidate-common/header-v2',$data);
			$this->load->view('candidate-common/menu-v2',$data);
			$this->load->view('candidate/v2/nric',$data);
			$this->load->view('candidate-common/footer-v2',$data);
		 
	}

 

}