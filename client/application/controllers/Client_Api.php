<?php
/**
 * 
 */
class Client_Api extends CI_Controller
{
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('caseModel');  
	  $this->load->model('utilModel');    
	  $this->load->model('emailModel');       
	  $this->load->model('smsModel');       
	  $this->load->model('loginModel');    
	  $this->load->model('notificationModel');   
	   $this->load->helper(array('form', 'url')); 
       $this->load->library('form_validation'); 
	}

	function check_admin_login() {
		if(!$this->session->userdata('logged-in-client')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function index(){
		$this->load->view('login');
	}

	function htmlGenrateReport($candidate_id) {
		$data['candidate_data']=$this->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->caseModel->all_components($candidate_id);
		$data['candidate_status'] = $this->caseModel->getSingleAssignedCaseDetail_s($candidate_id);
		/*$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar',$data);
		$this->load->view('client/case/case-common',$data);*/
		$this->load->view('client/report/success_report',$data);
		// $this->load->view('client-common/footer');		
	}

	function htmlGenratePDFReport($candidate_id){ 
		$data['candidate']=$this->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->caseModel->all_components($candidate_id);
		$data['candidate_status'] = $this->caseModel->getSingleAssignedCaseDetail_s($candidate_id);
		/*$this->load->view('client-common/header');
		$this->load->view('client-common/sidebar',$data);
		$this->load->view('client/case/case-common',$data);*/
		// $this->load->view('client/report/success_pdf_report',$data);
		$this->load->view('client/report/generate_final_report',$data);
		// $this->load->view('client-common/footer');		
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


	// external api
	function insert_case_api(){ 
			$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		 	$this->form_validation->set_rules('title', 'Title', 'required'); 
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('father_name', 'Father Name', 'required');
            $this->form_validation->set_rules('user_contact', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('package', 'Package Id', 'required');
            $this->form_validation->set_rules('reg[date_of_birth]', 'Date of birth', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]');
            $this->form_validation->set_rules('reg[date_of_joining]', 'Joining Date', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]'); 

            $this->form_validation->set_rules('employee_id', 'Employee Id', 'required');
            $this->form_validation->set_rules('remark', 'Remark', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('skills', 'component Ids', 'required');
            $this->form_validation->set_rules('form_values', 'form values', 'required');
            $this->form_validation->set_rules('package_component', 'package components', 'required');
            $this->form_validation->set_rules('client_email', 'document uploaded by email id', 'required');
 

            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }

		$data = getallheaders();
		// echo $data['Authorization'];
		$token = isset($data['Authorization'])?$data['Authorization']:'-';
		 $access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));  
		if ($access_token > 0) { 
			$data = $this->caseModel->insert_case_api();
			echo json_encode($data);
		}else{
			echo json_encode(array('status'=>'403','msg'=>'invalid token key'));
		}
	}

	// external api
	function update_case_api(){ 
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		$this->form_validation->set_rules('candidate_id', 'Candidate Id', 'required'); 
		$this->form_validation->set_rules('title', 'Title', 'required'); 
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('father_name', 'Father Name', 'required');
            $this->form_validation->set_rules('user_contact', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('package', 'Package Id', 'required');
            $this->form_validation->set_rules('reg[date_of_birth]', 'Date of birth', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]');
            $this->form_validation->set_rules('reg[date_of_joining]', 'Joining Date', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]'); 

            $this->form_validation->set_rules('employee_id', 'Employee Id', 'required');
            $this->form_validation->set_rules('remark', 'Remark', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('skills', 'component Ids', 'required');
            $this->form_validation->set_rules('form_values', 'form values', 'required');
            $this->form_validation->set_rules('package_component', 'package components', 'required');
            $this->form_validation->set_rules('client_email', 'document uploaded by email id', 'required');
 

            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }

		$data1 = getallheaders();
		// echo $data['Authorization']; 
		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) { 
			$valid_candidate = $this->caseModel->verify_valid_candidate();
			if ($valid_candidate['status'] == '202') {
				echo json_encode(array('status'=>'401','msg'=>'Unauthorized response User'));
				die();
			}
			$data = $this->caseModel->update_case_api();
			echo json_encode($data);
		}else{
			echo json_encode(array('status'=>'403','msg'=>'invalid token key'));
		}
	}

	function remove_case_api(){
		$data1 = getallheaders();
		// echo $data['Authorization']; 

		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) { 
			$valid_candidate = $this->caseModel->verify_valid_candidate();
			if ($valid_candidate['status'] == '202') {
				echo json_encode(array('status'=>'401','msg'=>'Unauthorized response User'));
				die();
			}
			$data = $this->caseModel->remove_case_api();
			echo json_encode($data);
		}else{
			echo json_encode(array('status'=>'403','msg'=>'invalid token key'));
		}
	}

	function get_client_details(){
		$data1 = getallheaders();
		// echo $data['Authorization']; 

		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) { 
			 $data['status'] = '200';
			 $data['client'] = $this->caseModel->get_single_client_details($this->input->post('client_id')); 
			$data['components'] = $this->caseModel->get_component_details();
			$data['package_data'] = $this->caseModel->get_single_component_name($data['client']['packages']);
			echo json_encode($data);
		}else{
			echo json_encode(array('status'=>'403','msg'=>'invalid token key'));
		}
	}



	function get_client_packages(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		  
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data1 = getallheaders();
		// echo $data['Authorization']; 

		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) { 
			$client = $this->caseModel->get_single_client_details($this->input->post('client_id')); 
			if ($client !=null && $client !='') { 
			 $data['status'] = '200';
			  $data['package_data'] = $this->caseModel->get_single_component_name($this->input->post('package_ids'));
			  echo json_encode($data);
			}else{
				echo json_encode(array('status'=>'402','msg'=>'Invalid client request'));	
			}
		}else{
			echo json_encode(array('status'=>'403','msg'=>'Invalid token key'));
		}
	}

	function add_client_packages(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		 	$this->form_validation->set_rules('package_name', 'Package Name', 'required');
		 	$this->form_validation->set_rules('component_ids', 'Component Ids', 'required'); 
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data1 = getallheaders(); 
		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) { 
			 $data['status'] = '200';
			  $data['package_data'] = $this->caseModel->add_client_packages();
			  echo json_encode($data);
			 
		}else{
			echo json_encode(array('status'=>'403','msg'=>'Invalid token key'));
		}
	}


	function remove_client_package(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		$this->form_validation->set_rules('package_id', 'Package Id', 'required'); 
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data1 = getallheaders(); 
		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) { 
			$client = $this->caseModel->get_single_client_details($this->input->post('client_id')); 
			if ($client !=null && $client !='') { 
			 $data['status'] = '200';
			  $data['package_data'] = $this->caseModel->remove_client_package();
			  echo json_encode($data);
			}else{ 
				echo json_encode(array('status'=>'402','msg'=>'Invalid client request'));	
			}
		}else{
			echo json_encode(array('status'=>'403','msg'=>'Invalid token key'));
		}
	}


	function get_client_components(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required');   
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data1 = getallheaders();
		// echo $data['Authorization']; 
 
		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) { 
			 $data['status'] = '200';
			  $data['components'] = $this->caseModel->get_component_details();
			  echo json_encode($data);
			 
		}else{
			echo json_encode(array('status'=>'403','msg'=>'Invalid token key'));
		}
	}
 
	function get_access_token(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		$this->form_validation->set_rules('client_name', 'Client Name', 'required'); 
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$client = $this->caseModel->get_single_client_details($this->input->post('client_id')); 
			if ($client !=null && $client !='' && $this->input->post('client_name') !='') { 
			 $data['status'] = '200';
			  $data['client_token'] = $this->caseModel->get_access_token();
			  echo json_encode($data);
			}else{ 
				echo json_encode(array('status'=>'402','msg'=>'Invalid client request'));	
			}
	}

	function valid_client_login(){
		$this->form_validation->set_rules('password', 'Password', 'required'); 
		$this->form_validation->set_rules('email', 'Email', 'required'); 
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data = $this->loginModel->valid_login_auth(); 
		if ($data['status']=='1') {   
			 $result = $data['user']; 
			 $package_components = json_decode($result['package_components'],true);
			 $alacarte_components = json_decode($result['alacarte_components'],true);
			 $user_data = array(
			 	'client_id'=>$result['client_id'],
			 	'client_name'=>$result['client_name'],
			 	'client_address'=>$result['client_address'],
			 	'client_city'=>$result['client_city'],
			 	'client_zip'=>$result['client_zip'],
			 	'client_state'=>$result['client_state'],
			 	'client_country'=>$result['client_country'],
			 	'account_manager_email_id'=>$result['account_manager_email_id'],
			 	'account_contact_no'=>$result['account_contact_no'],
			 	'spoc_id'=>$result['spoc_id'],
			 	'spoc_user_name'=>$result['poc_user_name'],
			 	'spoc_contact_number'=>$result['poc_contact_number'],
			 	'spoc_user_email'=>$result['poc_user_email'],
			 	'access_token'=>$result['access_token'],
			 	'package_ids'=>$result['packages'],
			 	'package_components'=>$package_components,
			 	'alacarte_components'=>$alacarte_components,
			 	'client_created_date'=>$result['client_created_date'],
			 	'client_updated_date'=>$result['client_updated_date'],
			 );

			 echo json_encode(array('status'=>'200','client_details'=>$user_data)); 
		}else{
			echo json_encode(array('status'=>'402','msg'=>'Invalid client request'));
		}
		 
	}


	
	function update_candidate_case_priority(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		$this->form_validation->set_rules('candidate_id', 'Candidate Id', 'required'); 
		$this->form_validation->set_rules('priority', 'Case Priority', 'required'); 
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data1 = getallheaders();
		// echo $data['Authorization']; 
 
		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) {  
			  $data = $this->caseModel->update_candidate_case_priority();
			  echo json_encode($data);
			 
		}else{
			echo json_encode(array('status'=>'403','msg'=>'Invalid token key'));
		}
	}



	
	function init_client_billing_payment(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		// $this->form_validation->set_rules('candidate_id', 'Candidate Id', 'required'); 
		// $this->form_validation->set_rules('priority', 'Case Priority', 'required'); 
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data1 = getallheaders();
		// echo $data['Authorization']; 
 
		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) {  
			  $data = $this->caseModel->init_client_billing_payment();
			  echo json_encode($data);
			 
		}else{
			echo json_encode(array('status'=>'403','msg'=>'Invalid token key'));
		}
	}

	
	function get_client_billing_payment(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		// $this->form_validation->set_rules('candidate_id', 'Candidate Id', 'required'); 
		// $this->form_validation->set_rules('priority', 'Case Priority', 'required'); 
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data1 = getallheaders();
		// echo $data['Authorization']; 
 
		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) {  
			  $data = $this->caseModel->get_client_billing_payment();
			  echo json_encode($data);
			 
		}else{
			echo json_encode(array('status'=>'403','msg'=>'Invalid token key'));
		}
	}
	
	function get_client_billing_payment_transactions(){
		$this->form_validation->set_rules('client_id', 'Client Id', 'required'); 
		// $this->form_validation->set_rules('candidate_id', 'Candidate Id', 'required'); 
		// $this->form_validation->set_rules('priority', 'Case Priority', 'required'); 
            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('status'=>'202','fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
			  die();
 
            }
		$data1 = getallheaders();
		// echo $data['Authorization']; 
 
		$token = isset($data1['Authorization'])?$data1['Authorization']:'-';
		$access_token = $this->caseModel->valid_access_token(trim(str_replace('Bearer', '', $token)));
		 
		if ($access_token > 0) {  
			  $data = $this->caseModel->get_client_billing_payment_transactions();
			  echo json_encode($data);
			 
		}else{
			echo json_encode(array('status'=>'403','msg'=>'Invalid token key'));
		}
	}


	function validate_form(){
		 // $this->load->helper(array('form', 'url'));

            // $this->load->library('form_validation');

             $this->form_validation->set_rules('title', 'Title', 'required'); 
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('father_name', 'Father Name', 'required');
            $this->form_validation->set_rules('user_contact', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('package', 'Package Id', 'required');
            $this->form_validation->set_rules('reg[date_of_birth]', 'Date of birth', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]');
            $this->form_validation->set_rules('reg[date_of_joining]', 'Joining Date', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]'); 

            $this->form_validation->set_rules('employee_id', 'Employee Id', 'required');
            $this->form_validation->set_rules('remark', 'Remark', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('skills', 'component Ids', 'required');
            $this->form_validation->set_rules('form_values', 'form values', 'required');
            $this->form_validation->set_rules('package_component', 'package components', 'required');
            $this->form_validation->set_rules('client_email', 'document uploaded by email id', 'required');
 

 

            if ($this->form_validation->run() == FALSE)
            {
               
			  $data = strip_tags($this->form_validation->error_string());
			  echo json_encode(array('fields'=>$data,'code' => 'form_validation_error', 'msg' => 'Some Fields are required'));
 
            }
	}

}

 