<?php
class Main_Mobile_Candidate_Controller extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url'); 
	  	$this->load->model('candidateModel');
	  	$this->load->model('main_Mobile_Candidate_Model');
	  	$this->load->model('candidate_Util_Model');
	  	$this->load->model('check_Candidate_Login_Model');
	}

	function m_component_list() {
		$this->check_Candidate_Login_Model->check_candidate_login();
		$user = $this->session->userdata('logged-in-candidate');
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components();
		$this->load->view('candidate-common/mobile-header',$data);
		$this->load->view('candidate-mobile/candidate-selected-component-list');
		$this->load->view('candidate-common/mobile-footer');
	}

	function m_candidate_information_step_1() {
		$this->check_Candidate_Login_Model->check_candidate_login();
		$user = $this->session->userdata('logged-in-candidate');
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries();  
		$data['state'] = $this->candidateModel->get_all_states();
		$data['get_timezone_details'] = $this->candidate_Util_Model->get_timezone_details();
		/*$this->load->view('candidate-common/mobile-header',$data);
		$this->load->view('candidate-mobile/personal-information-1',$data);
		$this->load->view('candidate-common/mobile-footer',$data);*/
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/mobile-personal-information-v2',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/mobile-personal-information-v2',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_candidate_1_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			$check_email = $this->candidate_Util_Model->check_candidate_email_id($this->input->post('email_id'));
			if ($check_email['count'] == 0) {
				echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_candidate_1_details()));
			} else {
				echo json_encode(array('status'=>'2','message'=>'Duplicacy detected in data.'));	
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_criminal_check() {
		$this->check_Candidate_Login_Model->check_candidate_login();
		$user = $this->session->userdata('logged-in-candidate');
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/criminal-check',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/criminal-check',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}


	function civil_check() {
		$this->check_Candidate_Login_Model->check_candidate_login();
		$user = $this->session->userdata('logged-in-candidate');
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
		$code = json_decode($this->candidateModel->country_code(),true); 
		$data['code'] = $code;
		/*if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/civil-check',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {*/
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/civil-check',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		// }
	}

	function m_document_check() {
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
			$this->load->view('candidate-common/mobile-header',$data); 
			$this->load->view('candidate-mobile/document-check',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/document-check',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function m_drug_test() {
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
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/drug-test',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/drug-test',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function m_gloal_database() {
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
			$this->load->view('candidate-common/mobile-header',$data); 
			$this->load->view('candidate-mobile/global-database',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/global-database',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function m_driving_licence() {
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states();
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/driving-licence',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/driving-licence',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function m_current_employment_1() {
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
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/current-employment-1',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/current-employment',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_current_employment_1_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_current_employment_1_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_current_employment_2() {
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
		$this->load->view('candidate-common/mobile-header',$data); 
		$this->load->view('candidate-mobile/current-employment-2',$data);
		$this->load->view('candidate-common/mobile-footer',$data);
	}

	function update_current_employment_2_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			$candidate_aadhar = array();
	      	$candidate_aadhar_dir = '../uploads/appointment_letter/';
	      	if(!empty($_FILES['candidate_aadhar']['name']) && count(array_filter($_FILES['candidate_aadhar']['name'])) > 0) { 
	          	$error =$_FILES["candidate_aadhar"]["error"]; 
	          	if(!is_array($_FILES["candidate_aadhar"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_aadhar"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"],$candidate_aadhar_dir.$fileName);
	            	$candidate_aadhar[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_aadhar"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_aadhar"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
	                	$candidate_aadhar[]= $fileName; 
	            	} 
	          	}
	    	} else {
	          	$candidate_aadhar[] = 'no-file';
	      	}

	        $candidate_pan = array();
	      	$candidate_pan_dir = '../uploads/experience_relieving_letter/';
	      	if(!empty($_FILES['candidate_pan']['name']) && count(array_filter($_FILES['candidate_pan']['name'])) > 0) { 
	          	$error =$_FILES["candidate_pan"]["error"]; 
	          	if(!is_array($_FILES["candidate_pan"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_pan"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_pan"]["tmp_name"],$candidate_pan_dir.$fileName);
	            	$candidate_pan[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_pan"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_pan"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_pan"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
	                	$candidate_pan[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_pan[] = 'no-file';
	    	}

	      	$candidate_proof = array();
	      	$candidate_proof_dir = '../uploads/last_month_pay_slip/';
	      	if(!empty($_FILES['candidate_proof']['name']) && count(array_filter($_FILES['candidate_proof']['name'])) > 0) { 
	          	$error =$_FILES["candidate_proof"]["error"]; 
	          	if(!is_array($_FILES["candidate_proof"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_proof"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_proof"]["tmp_name"],$candidate_proof_dir.$fileName);
	            	$candidate_proof[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_proof"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_proof"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_proof"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
	                	$candidate_proof[]= $fileName; 
	            	} 
	          	}
	    	} else {
	          	$candidate_proof[] = 'no-file';
	      	}

	      	$candidate_bank = array();
	      	$candidate_bank_dir = '../uploads/bank_statement_resigngation_acceptance/';    
	      	if(!empty($_FILES['candidate_bank']['name']) && count(array_filter($_FILES['candidate_bank']['name'])) > 0){ 
	          	$error =$_FILES["candidate_bank"]["error"]; 
	          	if(!is_array($_FILES["candidate_bank"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_bank"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_bank"]["tmp_name"],$candidate_bank_dir.$fileName);
	            	$candidate_bank[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_bank"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_bank"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_bank"]["tmp_name"][$i],$candidate_bank_dir.$fileName);
	                	$candidate_bank[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_bank[] = 'no-file';
	      	}

	      	echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_current_employment_2_details($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_bank)));
	    } else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_previous_employment_1() {
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
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/previous-employment-1',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/previous-employment',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_previous_employment_1_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_previous_employment_1_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_previous_employment_2() {
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
		$this->load->view('candidate-common/mobile-header',$data);
		$this->load->view('candidate-mobile/previous-employment-2',$data);
		$this->load->view('candidate-common/mobile-footer',$data);
	}

	function update_previous_employment_2_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			$candidate_aadhar = array();
      		$candidate_aadhar_dir = '../uploads/appointment_letter/';
 
	        $count = $this->input->post('count');
	        $count_pan = $this->input->post('count_pan');
	        $count_proof = $this->input->post('count_proof');
	        $count_bank = $this->input->post('count_bank');

	        for ($i=0; $i < $count; $i++) { 
      			$client_docs_obj = [];
      			if (isset($_FILES['candidate_aadhar'.$i])) {
        			if(!empty($_FILES['candidate_aadhar'.$i]['name']) && count(array_filter($_FILES['candidate_aadhar'.$i]['name'])) > 0){ 
          				$error = $_FILES["candidate_aadhar".$i]["error"]; 
          				if(!is_array($_FILES["candidate_aadhar".$i]["name"])) {
            				$file_ext = pathinfo($_FILES["candidate_aadhar".$i]["name"], PATHINFO_EXTENSION);
            				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            				move_uploaded_file($_FILES["candidate_aadhar".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
            				$client_docs_obj[]= $fileName; 
          				} else {
            				$fileCount = count($_FILES["candidate_aadhar".$i]["name"]);
            				for($j = 0; $j < $fileCount; $j++) {
                				$fileName = $_FILES["candidate_aadhar".$i]["name"][$j];
                				$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                				move_uploaded_file($_FILES["candidate_aadhar".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
                				$client_docs_obj[]= $fileName; 
            				}
          				}
    				} else {
          				$client_docs_obj[] = 'no-file';
      				}
      			}
      			$candidate_aadhar[] = $client_docs_obj;
     		}

     		$candidate_pan = array();
      		$candidate_pan_dir = '../uploads/experience_relieving_letter/';	
     		for ($i=0; $i < $count_pan; $i++) { 
      			$client_docs_obj = [];
      			if (isset($_FILES['candidate_pan'.$i])) {
        			if(!empty($_FILES['candidate_pan'.$i]['name']) && count(array_filter($_FILES['candidate_pan'.$i]['name'])) > 0){ 
          				$error = $_FILES["candidate_pan".$i]["error"]; 
          				if(!is_array($_FILES["candidate_pan".$i]["name"])) {
            				$file_ext = pathinfo($_FILES["candidate_pan".$i]["name"], PATHINFO_EXTENSION);
            				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            				move_uploaded_file($_FILES["candidate_pan".$i]["tmp_name"],$candidate_pan_dir.$fileName);
            				$client_docs_obj[] = $fileName; 
          				} else {
            				$fileCount = count($_FILES["candidate_pan".$i]["name"]);
            				for($j=0; $j < $fileCount; $j++) {
                				$fileName = $_FILES["candidate_pan".$i]["name"][$j];
                				$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                				move_uploaded_file($_FILES["candidate_pan".$i]["tmp_name"][$j],$candidate_pan_dir.$fileName);
                				$client_docs_obj[]= $fileName; 
            				}
          				}
    				} else {
          				$client_docs_obj[] = 'no-file';
      				}
      			}
      			$candidate_pan[] = $client_docs_obj;
     		}

     		$candidate_proof = array();
      		$candidate_proof_dir = '../uploads/last_month_pay_slip/';
      		for ($i=0; $i < $count_proof; $i++) { 
      			$client_docs_obj = [];
      			if (isset($_FILES['candidate_proof'.$i])) {
        			if(!empty($_FILES['candidate_proof'.$i]['name']) && count(array_filter($_FILES['candidate_proof'.$i]['name'])) > 0){ 
          				$error = $_FILES["candidate_proof".$i]["error"]; 
          				if(!is_array($_FILES["candidate_proof".$i]["name"])) {
            				$file_ext = pathinfo($_FILES["candidate_proof".$i]["name"], PATHINFO_EXTENSION);
            				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            				move_uploaded_file($_FILES["candidate_proof".$i]["tmp_name"],$candidate_proof_dir.$fileName);
            				$client_docs_obj[]= $fileName; 
          				} else {
            				$fileCount = count($_FILES["candidate_proof".$i]["name"]);
            				for($j = 0; $j < $fileCount; $j++) {
                				$fileName = $_FILES["candidate_proof".$i]["name"][$j];
                				$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                				move_uploaded_file($_FILES["candidate_proof".$i]["tmp_name"][$j],$candidate_proof_dir.$fileName);
                				$client_docs_obj[]= $fileName; 
            				}
          				}
    				} else {
          				$client_docs_obj[] = 'no-file';
      				}
      			}
      			$candidate_proof[] = $client_docs_obj;
     		}

     		$candidate_bank = array();
      		$candidate_bank_dir = '../uploads/bank_statement_resigngation_acceptance/';
      		for ($i=0; $i < $count_bank; $i++) { 
      			$client_docs_obj = [];
      			if (isset($_FILES['candidate_bank'.$i])) {
        			if(!empty($_FILES['candidate_bank'.$i]['name']) && count(array_filter($_FILES['candidate_bank'.$i]['name'])) > 0){ 
          				$error = $_FILES["candidate_bank".$i]["error"]; 
          				if(!is_array($_FILES["candidate_bank".$i]["name"])) {
            				$file_ext = pathinfo($_FILES["candidate_bank".$i]["name"], PATHINFO_EXTENSION);
            				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            				move_uploaded_file($_FILES["candidate_bank".$i]["tmp_name"],$candidate_bank_dir.$fileName);
            				$client_docs_obj[]= $fileName; 
          				} else {
            				$fileCount = count($_FILES["candidate_bank".$i]["name"]);
            				for($j=0; $j < $fileCount; $j++) {
                				$fileName = $_FILES["candidate_bank".$i]["name"][$j];
                				$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                				move_uploaded_file($_FILES["candidate_bank".$i]["tmp_name"][$j],$candidate_bank_dir.$fileName);
                				$client_docs_obj[]= $fileName; 
            				} 
          				}
    				} else {
          				$client_docs_obj[] = 'no-file';
      				}
      			}
      			$candidate_bank[] = $client_docs_obj;
     		}

			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_previous_employment_2_details($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_bank)));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_bankruptcy() {
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states();
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/bankruptcy',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/bankruptcy',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_bankruptcy_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_bankruptcy_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
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
		$this->load->view('candidate-common/header',$data);
		$this->load->view('candidate-common/menu',$data); 
		$this->load->view('candidate/address-details',$data);
		$this->load->view('candidate-common/footer',$data);	
	}

	function m_present_address_1() {
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
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/present-address-1',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/present-address',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_present_address_1_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_present_address_1_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_present_address_2() {
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

		$this->load->view('candidate-common/mobile-header',$data); 
		$this->load->view('candidate-mobile/present-address-2',$data);
		$this->load->view('candidate-common/mobile-footer',$data);
	}

	function update_present_address_2_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			$candidate_rental = array();
	      	$candidate_aadhar_dir = '../uploads/rental-docs/';
	      	if(!empty($_FILES['candidate_rental']['name']) && count(array_filter($_FILES['candidate_rental']['name'])) > 0){ 
	          	$error =$_FILES["candidate_rental"]["error"]; 
	          	if(!is_array($_FILES["candidate_rental"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_rental"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_rental"]["tmp_name"],$candidate_aadhar_dir.$fileName);
	            	$candidate_rental[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_rental"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_rental"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_rental"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
	                	$candidate_rental[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_rental[] = 'no-file';
	      	}

	      	$candidate_ration = array();
	      	$candidate_pan_dir = '../uploads/ration-docs/';
	      	if(!empty($_FILES['candidate_ration']['name']) && count(array_filter($_FILES['candidate_ration']['name'])) > 0){ 
	          	$error =$_FILES["candidate_ration"]["error"]; 
	          	if(!is_array($_FILES["candidate_ration"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_ration"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_ration"]["tmp_name"],$candidate_ration.$fileName);
	            	$candidate_pan[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_ration"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_ration"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_ration"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
	                	$candidate_ration[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_ration[] = 'no-file';
	      	}

	      	$candidate_gov = array();
	      	$candidate_proof_dir = '../uploads/gov-docs/';
	      	if(!empty($_FILES['candidate_gov']['name']) && count(array_filter($_FILES['candidate_gov']['name'])) > 0){ 
	          	$error =$_FILES["candidate_gov"]["error"]; 
	          	if(!is_array($_FILES["candidate_gov"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_gov"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_gov"]["tmp_name"],$candidate_proof_dir.$fileName);
	            	$candidate_gov[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_gov"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_gov"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_gov"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
	                	$candidate_gov[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_gov[] = 'no-file';
	      	}
	    	
	    	echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_present_address_2_details($candidate_rental,$candidate_ration,$candidate_gov)));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_reference() {
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
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/reference',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/reference',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}	
	}

	function update_reference_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_reference_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_previous_address_1() {
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
			$this->load->view('candidate-common/mobile-header',$data); 
			$this->load->view('candidate-mobile/previous-address-1',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/previous-address',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_previous_address_1_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_previous_address_1_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_previous_address_2() {
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

		$this->load->view('candidate-common/mobile-header',$data); 
		$this->load->view('candidate-mobile/previous-address-2',$data);
		$this->load->view('candidate-common/mobile-footer',$data);
	}

	function update_previous_address_2_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			$candidate_rental = array();
	      	$candidate_aadhar_dir = '../uploads/rental-docs/';

	      	for ($i=0; $i < $this->input->post('candidate_rental_count'); $i++) { 
	      		$client_docs_obj = [];
	      		if (isset($_FILES['candidate_rental'.$i])) {
	        		if(!empty($_FILES['candidate_rental'.$i]['name']) && count(array_filter($_FILES['candidate_rental'.$i]['name'])) > 0){ 
	          			$error =$_FILES["candidate_rental".$i]["error"]; 
	          			if(!is_array($_FILES["candidate_rental".$i]["name"])) {
	            			$file_ext = pathinfo($_FILES["candidate_rental".$i]["name"], PATHINFO_EXTENSION);
	            			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            			move_uploaded_file($_FILES["candidate_rental".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
	            			$client_docs_obj[]= $fileName; 
	          			} else {
	            			$fileCount = count($_FILES["candidate_rental".$i]["name"]);
	            			for($j=0; $j < $fileCount; $j++) {
	                			$fileName = $_FILES["candidate_rental".$i]["name"][$j];
	                			$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
	                			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                			move_uploaded_file($_FILES["candidate_rental".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
	                			$client_docs_obj[]= $fileName; 
	            			} 
	          			}
	    			} else {
	          			$client_docs_obj[] = 'no-file';
	      			}
	      		}
	      		$candidate_rental[] = $client_docs_obj;
	     	}

	     	$candidate_ration = array();
	      	$candidate_pan_dir = '../uploads/ration-docs/';

	      	for ($i=0; $i < $this->input->post('candidate_ration_count'); $i++) { 
	      		$client_docs_obj = [];
	      		if (isset($_FILES['candidate_ration'.$i])) {
	        		if(!empty($_FILES['candidate_ration'.$i]['name']) && count(array_filter($_FILES['candidate_ration'.$i]['name'])) > 0){ 
	          			$error =$_FILES["candidate_ration".$i]["error"]; 
	          			if(!is_array($_FILES["candidate_ration".$i]["name"])) {
	            			$file_ext = pathinfo($_FILES["candidate_ration".$i]["name"], PATHINFO_EXTENSION);
	            			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            			move_uploaded_file($_FILES["candidate_ration".$i]["tmp_name"],$candidate_pan_dir.$fileName);
	            			$client_docs_obj[]= $fileName; 
	          			} else {
	            			$fileCount = count($_FILES["candidate_ration".$i]["name"]);
	            			for($j=0; $j < $fileCount; $j++) {
	                			$fileName = $_FILES["candidate_ration".$i]["name"][$j];
	                			$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
	                			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                			move_uploaded_file($_FILES["candidate_ration".$i]["tmp_name"][$j],$candidate_pan_dir.$fileName);
	                			$client_docs_obj[]= $fileName; 
	            			}
	          			}
	    			} else {
	          			$client_docs_obj[] = 'no-file';
	      			}
	      		}
	      		$candidate_ration[] = $client_docs_obj;
	     	}

	     	$candidate_gov = array();
	      	$candidate_gov_dir = '../uploads/gov-docs/';
	      	for ($i=0; $i < $this->input->post('candidate_gov_count'); $i++) { 
	      		$client_docs_obj = [];
	      		if (isset($_FILES['candidate_gov'.$i])) {
	        		if(!empty($_FILES['candidate_gov'.$i]['name']) && count(array_filter($_FILES['candidate_gov'.$i]['name'])) > 0){ 
	          			$error =$_FILES["candidate_gov".$i]["error"]; 
	          			if(!is_array($_FILES["candidate_gov".$i]["name"])) {
	            			$file_ext = pathinfo($_FILES["candidate_gov".$i]["name"], PATHINFO_EXTENSION);
	            			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            			move_uploaded_file($_FILES["candidate_gov".$i]["tmp_name"],$candidate_gov_dir.$fileName);
	            			$client_docs_obj[]= $fileName; 
	          			} else {
	            			$fileCount = count($_FILES["candidate_gov".$i]["name"]);
	            			for($j=0; $j < $fileCount; $j++) {
	                			$fileName = $_FILES["candidate_gov".$i]["name"][$j];
	                			$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
	                			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                			move_uploaded_file($_FILES["candidate_gov".$i]["tmp_name"][$j],$candidate_gov_dir.$fileName);
	                			$client_docs_obj[]= $fileName; 
	            			}
	          			}
	    			} else {
	          			$client_docs_obj[] = 'no-file';
	      			}
	      		}
	      		$candidate_gov[] = $client_docs_obj;
	     	}

	     	echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_previous_address_2_details($candidate_rental,$candidate_ration,$candidate_gov)));
	     } else {
	     	echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
	     }
	}

	function m_court_record_1() {
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
			$this->load->view('candidate-common/mobile-header',$data); 
			$this->load->view('candidate-mobile/court-record-1',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/court-record',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_court_record_1_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_court_record_1_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_court_record_2() {
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

		$this->load->view('candidate-common/mobile-header',$data);
		$this->load->view('candidate-mobile/court-record-2',$data);
		$this->load->view('candidate-common/mobile-footer',$data);
	}

	function update_court_record_2_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			$candidate_aadhar = array();
	      	$candidate_aadhar_dir = '../uploads/address-docs/';
	      	if(!empty($_FILES['addresss']['name']) && count(array_filter($_FILES['addresss']['name'])) > 0){ 
	          	$error =$_FILES["addresss"]["error"];
	          	if(!is_array($_FILES["addresss"]["name"])) {
	            	$file_ext = pathinfo($_FILES["addresss"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["addresss"]["tmp_name"],$candidate_aadhar_dir.$fileName);
	            	$candidate_aadhar[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["addresss"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["addresss"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["addresss"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
	                	$candidate_aadhar[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_aadhar[] = 'no-file';
	      	}
	      	echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_court_record_2_details($candidate_aadhar)));
	    } else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_social_media() {
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states();

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/social-media',$data); 
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/social-media',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_social_media_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_social_media_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_credit_cibil() {
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 

		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/credit-cibil',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/credit-cibil',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_credit_cibil_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_credit_cibil_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_cv_check() {
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states();
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/cv-check',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/cv-check',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_cv_check() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			$cv_docs = array();
      		$cv_docs_dir = '../uploads/cv-docs/';
      		if(!empty($_FILES['cv_docs']['name']) && count(array_filter($_FILES['cv_docs']['name'])) > 0){ 
          		$error =$_FILES["cv_docs"]["error"]; 
          		if(!is_array($_FILES["cv_docs"]["name"])) {
            		$file_ext = pathinfo($_FILES["cv_docs"]["name"], PATHINFO_EXTENSION);
            		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            		move_uploaded_file($_FILES["cv_docs"]["tmp_name"],$cv_docs.$fileName);
            		$candidate_pan[]= $fileName; 
          		} else {
            		$fileCount = count($_FILES["cv_docs"]["name"]);
            		for($i=0; $i < $fileCount; $i++) {
                		$files_name = $_FILES["cv_docs"]["name"][$i];
                		$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                		move_uploaded_file($_FILES["cv_docs"]["tmp_name"][$i],$cv_docs_dir.$fileName);
                		$cv_docs[]= $fileName; 
            		} 
          		}
    		} else {
          		$cv_docs[] = 'no-file';
      		}
      		echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_cv_check($cv_docs)));
      	} else {
      		echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
      	}
	}

	function m_landlord_reference() {
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states();
		if ($this->config->item('live_ui_version') == 1) {
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/landlord-reference',$data); 
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/landlord-reference',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_landlord_reference_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_landlord_reference_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}
	
	function m_education_1() {
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
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/education-details-1',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/education-details',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_education_1_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_education_1_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_education_2() {
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

		$this->load->view('candidate-common/mobile-header',$data);
		$this->load->view('candidate-mobile/education-details-2',$data);
		$this->load->view('candidate-common/mobile-footer',$data);	
	}

	function update_education_2_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
            $count = $this->input->post('count');
            $pan_count = $this->input->post('pan_count'); 
            $proof_count = $this->input->post('proof_count');
            $bank_count = $this->input->post('bank_count');

            $all_sem_marksheet = array();
      		$all_sem_marksheet_dir = '../uploads/all-marksheet-docs/';
            for ($i = 0; $i < $count; $i++) { 
      			$client_docs_obj = [];
      			if (isset($_FILES['all_sem_marksheet'.$i])) {
        			if(!empty($_FILES['all_sem_marksheet'.$i]['name']) && count(array_filter($_FILES['all_sem_marksheet'.$i]['name'])) > 0){ 
          				$error = $_FILES["all_sem_marksheet".$i]["error"]; 
          				if(!is_array($_FILES["all_sem_marksheet".$i]["name"])) {
            				$file_ext = pathinfo($_FILES["all_sem_marksheet".$i]["name"], PATHINFO_EXTENSION);
            				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            				move_uploaded_file($_FILES["all_sem_marksheet".$i]["tmp_name"],$all_sem_marksheet_dir.$fileName);
            				$client_docs_obj[] = $fileName; 
          				} else {
            				$fileCount = count($_FILES["all_sem_marksheet".$i]["name"]);
            				for($j = 0; $j < $fileCount; $j++) {
                				$fileName = $_FILES["all_sem_marksheet".$i]["name"][$j];
                				$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                				move_uploaded_file($_FILES["all_sem_marksheet".$i]["tmp_name"][$j],$all_sem_marksheet_dir.$fileName);
                				$client_docs_obj[] = $fileName; 
            				}
          				}
    				} else {
          				$client_docs_obj[] = 'no-file';
      				}
      			}
      			$all_sem_marksheet[] = $client_docs_obj;
     		}

     		$convocation = array();
      		$convocation_dir = '../uploads/convocation-docs/';
      		for ($i = 0; $i < $pan_count; $i++) { 
      			$client_docs_obj = [];
      			if (isset($_FILES['convocation'.$i])) {
        			if(!empty($_FILES['convocation'.$i]['name']) && count(array_filter($_FILES['convocation'.$i]['name'])) > 0){ 
          				$error = $_FILES["convocation".$i]["error"]; 
          				if(!is_array($_FILES["convocation".$i]["name"])) {
            				$file_ext = pathinfo($_FILES["convocation".$i]["name"], PATHINFO_EXTENSION);
            				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            				move_uploaded_file($_FILES["convocation".$i]["tmp_name"],$convocation_dir.$fileName);
            				$client_docs_obj[] = $fileName; 
          				} else {
            				$fileCount = count($_FILES["convocation".$i]["name"]);
            				for($j = 0; $j < $fileCount; $j++) {
                				$fileName = $_FILES["convocation".$i]["name"][$j];
                				$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                				move_uploaded_file($_FILES["convocation".$i]["tmp_name"][$j],$convocation_dir.$fileName);
                				$client_docs_obj[] = $fileName; 
            				}
          				}
    				} else {
          				$client_docs_obj[] = 'no-file';
      				}
      			}
      			$convocation[] = $client_docs_obj;
     		}

     		$marksheet_provisional_certificate = array();
      		$marksheet_provisional_certificate_dir = '../uploads/marksheet-certi-docs/';
     		for ($i = 0; $i < $proof_count; $i++) {
      			$client_docs_obj = [];
      			if (isset($_FILES['marksheet_provisional_certificate'.$i])) {
        			if(!empty($_FILES['marksheet_provisional_certificate'.$i]['name']) && count(array_filter($_FILES['marksheet_provisional_certificate'.$i]['name'])) > 0) { 
          				$error = $_FILES["marksheet_provisional_certificate".$i]["error"]; 
          				if(!is_array($_FILES["marksheet_provisional_certificate".$i]["name"])) {
            				$file_ext = pathinfo($_FILES["marksheet_provisional_certificate".$i]["name"], PATHINFO_EXTENSION);
            				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            				move_uploaded_file($_FILES["marksheet_provisional_certificate".$i]["tmp_name"],$marksheet_provisional_certificate_dir.$fileName);
            				$client_docs_obj[] = $fileName; 
          				} else {
            				$fileCount = count($_FILES["marksheet_provisional_certificate".$i]["name"]);
            				for($j = 0; $j < $fileCount; $j++) {
                				$fileName = $_FILES["marksheet_provisional_certificate".$i]["name"][$j];
                				$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                				move_uploaded_file($_FILES["marksheet_provisional_certificate".$i]["tmp_name"][$j],$marksheet_provisional_certificate_dir.$fileName);
                				$client_docs_obj[] = $fileName; 
            				}
          				}
    				} else {
          				$client_docs_obj[] = 'no-file';
      				}
      			}
      			$marksheet_provisional_certificate[] = $client_docs_obj;
     		}

     		$ten_twelve_mark_card_certificate = array();
      		$ten_twelve_mark_card_certificate_dir = '../uploads/ten-twelve-docs/';
      		for ($i = 0; $i < $bank_count; $i++) { 
      			$client_docs_obj = [];
      			if (isset($_FILES['ten_twelve_mark_card_certificate'.$i])) {
        			if(!empty($_FILES['ten_twelve_mark_card_certificate'.$i]['name']) && count(array_filter($_FILES['ten_twelve_mark_card_certificate'.$i]['name'])) > 0){ 
          				$error = $_FILES["ten_twelve_mark_card_certificate".$i]["error"]; 
          				if(!is_array($_FILES["ten_twelve_mark_card_certificate".$i]["name"])) {
            				$file_ext = pathinfo($_FILES["ten_twelve_mark_card_certificate".$i]["name"], PATHINFO_EXTENSION);
            				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            				move_uploaded_file($_FILES["ten_twelve_mark_card_certificate".$i]["tmp_name"],$ten_twelve_mark_card_certificate_dir.$fileName);
            				$client_docs_obj[] = $fileName; 
          				} else {
            				$fileCount = count($_FILES["ten_twelve_mark_card_certificate".$i]["name"]);
            				for($j = 0; $j < $fileCount; $j++) {
                				$fileName = $_FILES["ten_twelve_mark_card_certificate".$i]["name"][$j];
                				$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                				$fileName = uniqid().date('YmdHis').'.'.$file_ext;
                				move_uploaded_file($_FILES["ten_twelve_mark_card_certificate".$i]["tmp_name"][$j],$ten_twelve_mark_card_certificate_dir.$fileName);
                				$client_docs_obj[] = $fileName; 
            				}
          				}
    				} else {
          				$client_docs_obj[] = 'no-file';
      				}
      			}
      			$ten_twelve_mark_card_certificate[] = $client_docs_obj;
     		}

			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_education_2_details($all_sem_marksheet,$convocation,$marksheet_provisional_certificate,$ten_twelve_mark_card_certificate)));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_consent_form() { 
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
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/education-details-1',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/consent-form',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}	
	}

	function m_permanent_address_1() {
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
			$this->load->view('candidate-common/mobile-header',$data);
			$this->load->view('candidate-mobile/permanent-address-1',$data);
			$this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/permanent-address',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}


	function candidate_additional(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted'); 
		$data['log'] = $this->db->where('client_id',$user['client_id'])->get('custom_logo')->row_array();
		 

		$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/additional-docs',$data);
			$this->load->view('candidate-mobile/v2/main-footer');	
	}

	function update_permanent_address_1_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_permanent_address_1_details()));
		} else {
			echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
		}
	}

	function m_permanent_address_2() {
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
		
		$this->load->view('candidate-common/mobile-header',$data);
		$this->load->view('candidate-mobile/permanent-address-2',$data);
		$this->load->view('candidate-common/mobile-footer',$data);
	}

	function employment_gap() {
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states();
		if ($this->config->item('live_ui_version') == 1) {
			// $this->load->view('candidate-common/mobile-header',$data);
			// $this->load->view('candidate-mobile/landlord-reference',$data); 
			// $this->load->view('candidate-common/mobile-footer',$data);
		} else {
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/employment-gap',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		}
	}

	function update_permanent_address_2_details() {
		if (isset($_POST) && $this->input->post('verify_candidate_request') == '1' && $this->session->userdata('logged-in-candidate')) {
			$candidate_rental = array();
	      	$candidate_aadhar_dir = '../uploads/rental-docs/';
	      	if(!empty($_FILES['candidate_rental']['name']) && count(array_filter($_FILES['candidate_rental']['name'])) > 0){ 
	          	$error =$_FILES["candidate_rental"]["error"]; 
	          	if(!is_array($_FILES["candidate_rental"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_rental"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_rental"]["tmp_name"],$candidate_aadhar_dir.$fileName);
	            	$candidate_rental[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_rental"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_rental"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_rental"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
	                	$candidate_rental[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_rental[] = 'no-file';
	      	}

	      	$candidate_ration = array();
	      	$candidate_pan_dir = '../uploads/ration-docs/';
	      	if(!empty($_FILES['candidate_ration']['name']) && count(array_filter($_FILES['candidate_ration']['name'])) > 0){ 
	          	$error =$_FILES["candidate_ration"]["error"]; 
	          	if(!is_array($_FILES["candidate_ration"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_ration"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_ration"]["tmp_name"],$candidate_ration.$fileName);
	            	$candidate_pan[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_ration"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_ration"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_ration"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
	                	$candidate_ration[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_ration[] = 'no-file';
	      	}

	      	$candidate_gov = array();
	      	$candidate_proof_dir = '../uploads/gov-docs/';
	      	if(!empty($_FILES['candidate_gov']['name']) && count(array_filter($_FILES['candidate_gov']['name'])) > 0){ 
	          	$error =$_FILES["candidate_gov"]["error"]; 
	          	if(!is_array($_FILES["candidate_gov"]["name"])) {
	            	$file_ext = pathinfo($_FILES["candidate_gov"]["name"], PATHINFO_EXTENSION);
	            	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	            	move_uploaded_file($_FILES["candidate_gov"]["tmp_name"],$candidate_proof_dir.$fileName);
	            	$candidate_gov[]= $fileName; 
	          	} else {
	            	$fileCount = count($_FILES["candidate_gov"]["name"]);
	            	for($i=0; $i < $fileCount; $i++) {
	                	$files_name = $_FILES["candidate_gov"]["name"][$i];
	                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
	                	$fileName = uniqid().date('YmdHis').'.'.$file_ext;
	                	move_uploaded_file($_FILES["candidate_gov"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
	                	$candidate_gov[]= $fileName; 
	            	}
	          	}
	    	} else {
	          	$candidate_gov[] = 'no-file';
	      	}

	      	echo json_encode(array('status'=>'1','candidate_details'=>$this->main_Mobile_Candidate_Model->update_permanent_address_2_details($candidate_rental,$candidate_ration,$candidate_gov)));
	    } else {
	    	echo json_encode(array('status'=>'0','message'=>'Bad Request Format'));
	    }
	}

	


	/*new components */


	function candidate_sex_offender(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			  
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/sex-offender',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		 
	}


	function candidate_politically_exposed(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			  
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/politically_exposed',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		 
	}

	function candidate_india_civil_litigation(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			  
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/india_civil_litigation',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		 
	}

	function candidate_mca(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			  
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/mca',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		 
	}

	function candidate_gsa(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			  
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/gsa',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		 
	}

	function candidate_oig(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			  
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/oig',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		 
	}

  	function candidate_right_to_work(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			  
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/right-to-work',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		 
	}

  	function candidate_nric(){
		$user = $this->session->userdata('logged-in-candidate'); 
		$data['user'] = $this->candidateModel->get_candidate_list($user['candidate_id']);
		$data['component_ids'] = $this->session->userdata('component_ids');
		$data['is_submitted'] = $this->session->userdata('is_submitted');
		$data['table'] = $this->candidateModel->all_components(); 
		$data['country'] = $this->candidateModel->get_all_countries(); 
		$data['state'] = $this->candidateModel->get_all_states(); 
			  
			$this->load->view('candidate-mobile/v2/main-header',$data);
			$this->load->view('candidate-mobile/v2/component-header',$data);
			$this->load->view('candidate-mobile/v2/nric',$data);
			$this->load->view('candidate-mobile/v2/main-footer');
		 
	}

  

}