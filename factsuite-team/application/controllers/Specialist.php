<?php

/**
 * Created 12-4-2021
 */
class Specialist extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');  
	  $this->load->model('inputQcModel');  
	  $this->load->model('emailModel');  
    $this->load->model('specialistModel');  
	  $this->load->model('analystModel');  
	  $this->load->model('utilModel');
	  $this->load->model('componentModel');
	  $this->load->model('admin_Vendor_Model');
	  

	}

	function check_specialist_login() {
 
		if(!$this->session->userdata('logged-in-specialist')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	
  function client_approval(){
    $this->check_specialist_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-specialist');
    $this->load->view('specialist/specialist-common/header',$sessionData);
    $this->load->view('specialist/specialist-common/sidebar',$sessionData);
    // $this->load->view('analyst/approval/approval-common');
    $this->load->view('specialist/approval/approval-mechanism');
    $this->load->view('specialist/specialist-common/footer');
  }


	  function view_process(){

    $this->check_specialist_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-specialist');
    $data['toatladata']  = count($this->specialistModel->getQcErrorComponent());
    // echo $data['toatladata'] ;
    // exit();  
    $this->load->view('specialist/specialist-common/header',$sessionData);
    $this->load->view('specialist/specialist-common/sidebar',$sessionData);
    // $this->load->view('specialist/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/view-process-guidline',$data);
    $this->load->view('specialist/specialist-common/footer');
  }

	function assignedCaseList(){

		$this->check_specialist_login();
		$sessionData['sessionData'] = $this->session->userdata('logged-in-specialist'); 
    $data['toatladata']  = count($this->specialistModel->getQcErrorComponent());
    $data['assign_component'] = $this->analystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']);
    // echo $data['toatladata'] ;
    // exit();
    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
		$this->load->view('specialist/specialist-common/header',$sessionData);
		$this->load->view('specialist/specialist-common/sidebar');
		$this->load->view('specialist/assigned-case/case-common',$data);
		$this->load->view('specialist/assigned-case/all-assigned-case',$data);
		$this->load->view('specialist/specialist-common/footer');

	}


  function assignedCaseProgressList(){

		$this->check_specialist_login();
		$sessionData['sessionData'] = $this->session->userdata('logged-in-specialist'); 
    $data['toatladata']  = count($this->specialistModel->getQcErrorComponent());
    $data['case'] = $this->analystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']);
    // echo $data['toatladata'] ;
    // exit();
    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
   
    $this->load->view('specialist/specialist-common/header',$sessionData);
    $this->load->view('specialist/specialist-common/sidebar',$sessionData);
    $this->load->view('specialist/assigned-case/case-common',$data);
    $this->load->view('specialist/assigned-case/assigned-in-progress',$data);
    $this->load->view('specialist/specialist-common/footer');

  }

  function assignedCaseCompletedList(){

		$this->check_specialist_login();
		$sessionData['sessionData'] = $this->session->userdata('logged-in-specialist'); 
    $data['toatladata']  = count($this->specialistModel->getQcErrorComponent());
    $data['case'] = $this->analystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']);
    // echo $data['toatladata'] ;
    // exit();
    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
   
    $this->load->view('specialist/specialist-common/header',$sessionData);
    $this->load->view('specialist/specialist-common/sidebar',$sessionData);
    $this->load->view('specialist/assigned-case/case-common',$data);
    $this->load->view('specialist/assigned-case/assigned-completed',$data);
    $this->load->view('specialist/specialist-common/footer');

  }

   function assignedCasevendorList(){

    $this->check_specialist_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-specialist');
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
    // echo $data['toatladata'] ;
    // exit();
    $data['case'] = $this->analystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']);

    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
   
     $this->load->view('specialist/specialist-common/header',$sessionData);
    $this->load->view('specialist/specialist-common/sidebar',$sessionData);
    $this->load->view('specialist/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/vendor-assigned-cases',$data);
    $this->load->view('specialist/specialist-common/footer');

  }

  function assignedQcErrorComponentList(){

    $this->check_specialist_login();
    $data['toatladata']  = count($this->specialistModel->getQcErrorComponent());
    $sessionData['sessionData'] = $this->session->userdata('logged-in-specialist');
     $data['assign_component'] = $this->analystModel->getQcErrorComponentAna($sessionData['sessionData']['team_id']);
    $this->load->view('specialist/specialist-common/header',$sessionData);
    $this->load->view('specialist/specialist-common/sidebar');
    $this->load->view('specialist/assigned-case/case-common',$data);
    $this->load->view('specialist/assigned-case/all-assigned-qc-error-component',$data);
    $this->load->view('specialist/specialist-common/footer');

  }

	function assignedSingleCase($candidate_id){
		$this->check_specialist_login(); 
		$data['candidate_id'] = $candidate_id;		
		$this->load->view('specialist/specialist-common/header');
		$this->load->view('specialist/specialist-common/sidebar',$data);
		$this->load->view('specialist/assigned-case/case-common',$data);
		$this->load->view('specialist/assigned-case/view-single-assigned-case',$data);
		$this->load->view('specialist/specialist-common/footer');			
	}

	function singleComponentDetail($candidateId,$componentId,$index){
		// echo $componentId." : ".$candidateId;
		$this->check_specialist_login(); 
		$spelcialistUser = $this->session->userdata('logged-in-specialist');
		$userId = $spelcialistUser['team_id'];
		$notificationInfo = $this->db->where('assigned_team_id',$userId)->where('case_id',$candidateId)->where('case_index',$index)->where('component_id',$componentId)->get('notifications')->row_array();
      	// print_r($notificationInfo);
		// echo $this->db->last_query();
		// exit();
			if($notificationInfo != '' && $notificationInfo != null){
	      if($notificationInfo['notification_status'] == '0' && $notificationInfo['manually_seen'] == '0'){
	        $notificationDetailUpdate = array(
	          'notification_status'=>'1',
	          'manually_seen'=>'1',
	          'updated_date'=>date('Y-m-d H:i:s')          
	        );

	        $this->db->where('notification_id',$notificationInfo['notification_id']);
	        if($this->db->update('notifications',$notificationDetailUpdate)){
	          // echo 'ok';
	        } 
	      }
    	}	

		$data1 = $this->analystModel->singleComponentDetail($componentId,$candidateId);
		// print_r($data); 
		// exit();
		$pageName = $this->utilModel->getComponent_or_PageName($componentId);
		 
		$specialistUser = $this->session->userdata('logged-in-specialist');
    	$userID =$specialistUser['team_id'];
    	$userRole =$specialistUser['role'];

		if($componentId == '22'){
		$data['previous_employment'] = $this->db->where('candidate_id',$candidateId)->get('previous_employment')->row_array();
		$data['current_employment'] = $this->db->where('candidate_id',$candidateId)->get('current_employment')->row_array();
		}
		// echo '<pre>';
		// print_r($data1);
		// exit;
		$data['componentData'] = $data1; 
		$data['countries'] = $this->analystModel->get_all_countries();
    	$data['states'] = $this->analystModel->get_all_states(101);
		// $data['cities'] = $this->componentModel->get_all_cities();
		if($componentId == '6' || $componentId == '10'){
      		$data['currency'] = file_get_contents(base_url().'assets/custom-js/json/currency.json');
		}
		$data['candidateIdLink']=$candidateId;
		$data['componentIdLink'] =$componentId;
		$data['index'] = $index;
		$data['team_id'] = $userID;
		$data['component_id'] = $componentId;
		$data['vendor'] = $this->admin_Vendor_Model->get_all_vendor_list();
		$data['toatladata']  = count($this->analystModel->getQcErrorComponent());

		

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

		$uploaded_loa = $this->db->select('signature_img')->where('candidate_id',$candidateId)->get('signature')->row_array();
		$document_uploaded_by = $this->db->where('candidate_id',$candidateId)->get('candidate')->row_array();
    	$data['document_uploaded_by'] = $document_uploaded_by['document_uploaded_by'];
    	$data['is_submitted'] = $document_uploaded_by['is_submitted'];
		$data['uploaded_loa'] = isset($uploaded_loa['signature_img'])?$uploaded_loa['signature_img']:'';
    	$data['selected_datetime_format'] = $selected_datetime_format;
		$url = base_url();
		$data['base_url'] = str_replace('factsuite-team/','',$url);
		$data['signature'] = isset($data1['signature'])?$data1['signature']:0;
		 
    	$this->load->view('specialist/specialist-common/header');
		$this->load->view('specialist/specialist-common/sidebar',$data);
		$this->load->view('specialist/assigned-case/case-common',$data);
		$this->load->view('analyst/assigned-case/component-pages/'.$pageName,$data);  
		$this->load->view('specialist/specialist-common/footer');			
	}
 
	function getCaseAssignedComponent(){

		$data = $this->specialistModel->getCaseAssignedComponent();
		// exit();
		echo json_encode($data);

	}

  function getQcErrorComponent(){

    $data = $this->analystModel->getQcErrorComponent();
    // exit();
    echo json_encode($data);

  }

	function insuffUpdateStatus(){
		
		$data = $this->specialistModel->insuffUpdateStatus();
		echo json_encode($data);
	}

	function approveUpdateStatus(){
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		$componentname= $this->input->post('componentname');
		$data = $this->specialistModel->approveUpdateStatus($candidate_id,$componentname,$component_id);
		echo json_encode($data);
	}

	function stopcheckUpdateStatus(){
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		$componentname= $this->input->post('componentname');
		$data = $this->specialistModel->stopcheckUpdateStatus($candidate_id,$componentname,$component_id);
		echo json_encode($data);
	}
 	
 	// function isAllComponentApproved($candidate_id = '4'){
 		 
 	// 	$dat = $this->specialistModel->isAllComponentApproved($candidate_id);
 	// 	echo json_encode($dat);
 	// }

 	function update_remarks_candidate_criminal_check(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	

     for ($i=0; $i < $count; $i++) { 
     	$client_docs_obj = [];
     	if (isset($_FILES['approved_doc'.$i])) {
     		if(!empty($_FILES['approved_doc'.$i]['name']) && count(array_filter($_FILES['approved_doc'.$i]['name'])) > 0){ 
      		$error =$_FILES["approved_doc".$i]["error"]; 
      		if(!is_array($_FILES["approved_doc".$i]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc".$i]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs_obj[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc".$i]["name"]);
        		for($j=0; $j < $fileCount; $j++) {
          			$approved_doc_name = $_FILES["approved_doc".$i]["name"][$j];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"][$j],$client_doc_dir.$fileName);
          			$client_docs_obj[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs_obj[] = 'no-file';
    	}
     	}
     	
    	$client_docs[] = $client_docs_obj;
     }
 
 
 		$data = $this->specialistModel->update_remarks_candidate_criminal_check($client_docs);
		echo json_encode($data);	
 	}

 	function update_remarks_candidate_court_record(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	

     for ($i=0; $i < $count; $i++) { 
     	$client_docs_obj = [];
     	if (isset($_FILES['approved_doc'.$i])) {
     		if(!empty($_FILES['approved_doc'.$i]['name']) && count(array_filter($_FILES['approved_doc'.$i]['name'])) > 0){ 
      		$error =$_FILES["approved_doc".$i]["error"]; 
      		if(!is_array($_FILES["approved_doc".$i]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc".$i]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs_obj[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc".$i]["name"]);
        		for($j=0; $j < $fileCount; $j++) {
          			$approved_doc_name = $_FILES["approved_doc".$i]["name"][$j];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"][$j],$client_doc_dir.$fileName);
          			$client_docs_obj[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs_obj[] = 'no-file';
    	}
     	}
     	
    	$client_docs[] = $client_docs_obj;
     }

 		$data = $this->specialistModel->update_remarks_candidate_court_record($client_docs);
		echo json_encode($data);	
 	}

 	function update_remarks_candidate_permanent_address(){
 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';

     
    
    	if(!empty($_FILES['approved_doc']['name']) && count(array_filter($_FILES['approved_doc']['name'])) > 0){ 
      		$error =$_FILES["approved_doc"]["error"]; 
      		if(!is_array($_FILES["approved_doc"]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc"]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$approved_doc_name = $_FILES["approved_doc"]["name"][$i];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc"]["tmp_name"][$i],$client_doc_dir.$fileName);
          			$client_docs[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs[] = 'no-file';
    	}
 		$data = $this->specialistModel->update_remarks_candidate_permanent_address($client_docs);
		echo json_encode($data); 		
 	}

 	function update_remarks_candidate_present_address(){
 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';

     
    
    	if(!empty($_FILES['approved_doc']['name']) && count(array_filter($_FILES['approved_doc']['name'])) > 0){ 
      		$error =$_FILES["approved_doc"]["error"]; 
      		if(!is_array($_FILES["approved_doc"]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc"]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$approved_doc_name = $_FILES["approved_doc"]["name"][$i];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc"]["tmp_name"][$i],$client_doc_dir.$fileName);
          			$client_docs[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs[] = 'no-file';
    	}
 		$data = $this->specialistModel->update_remarks_candidate_present_address($client_docs);
		echo json_encode($data); 		
 	}

 	function update_remarks_candidate_previous_address(){ 
 		// $this->check_specialist_login();

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	

     for ($i=0; $i < $count; $i++) { 
     	$client_docs_obj = [];
     	if (isset($_FILES['approved_doc'.$i])) {
     		if(!empty($_FILES['approved_doc'.$i]['name']) && count(array_filter($_FILES['approved_doc'.$i]['name'])) > 0){ 
      		$error =$_FILES["approved_doc".$i]["error"]; 
      		if(!is_array($_FILES["approved_doc".$i]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc".$i]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs_obj[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc".$i]["name"]);
        		for($j=0; $j < $fileCount; $j++) {
          			$approved_doc_name = $_FILES["approved_doc".$i]["name"][$j];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"][$j],$client_doc_dir.$fileName);
          			$client_docs_obj[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs_obj[] = 'no-file';
    	}
     	}
     	
    	$client_docs[] = $client_docs_obj;
     }


 		$data = $this->specialistModel->update_remarks_candidate_previous_address($client_docs);
		echo json_encode($data); 		
 	}

 	function update_remarks_current_employment(){
 		// $this->check_specialist_login();
 				$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';

     
    
    	if(!empty($_FILES['approved_doc']['name']) && count(array_filter($_FILES['approved_doc']['name'])) > 0){ 
      		$error =$_FILES["approved_doc"]["error"]; 
      		if(!is_array($_FILES["approved_doc"]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc"]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$approved_doc_name = $_FILES["approved_doc"]["name"][$i];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc"]["tmp_name"][$i],$client_doc_dir.$fileName);
          			$client_docs[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs[] = 'no-file';
    	}
 		$data = $this->specialistModel->update_remarks_current_employment($client_docs);
		echo json_encode($data); 	
 	}

 	function update_remarks_previous_employment(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	

     for ($i=0; $i < $count; $i++) { 
     	$client_docs_obj = [];
     	if (isset($_FILES['approved_doc'.$i])) {
     		if(!empty($_FILES['approved_doc'.$i]['name']) && count(array_filter($_FILES['approved_doc'.$i]['name'])) > 0){ 
      		$error =$_FILES["approved_doc".$i]["error"]; 
      		if(!is_array($_FILES["approved_doc".$i]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc".$i]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs_obj[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc".$i]["name"]);
        		for($j=0; $j < $fileCount; $j++) {
          			$approved_doc_name = $_FILES["approved_doc".$i]["name"][$j];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"][$j],$client_doc_dir.$fileName);
          			$client_docs_obj[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs_obj[] = 'no-file';
    	}
     	}
     	
    	$client_docs[] = $client_docs_obj;
     }
 		// $this->check_specialist_login();
 		$data = $this->specialistModel->update_remarks_previous_employment($client_docs);
		echo json_encode($data); 	
 	}

 	function update_reference(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	

     for ($i=0; $i < $count; $i++) { 
     	$client_docs_obj = [];
     	if (isset($_FILES['approved_doc'.$i])) {
     		if(!empty($_FILES['approved_doc'.$i]['name']) && count(array_filter($_FILES['approved_doc'.$i]['name'])) > 0){ 
      		$error =$_FILES["approved_doc".$i]["error"]; 
      		if(!is_array($_FILES["approved_doc".$i]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc".$i]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs_obj[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc".$i]["name"]);
        		for($j=0; $j < $fileCount; $j++) {
          			$approved_doc_name = $_FILES["approved_doc".$i]["name"][$j];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"][$j],$client_doc_dir.$fileName);
          			$client_docs_obj[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs_obj[] = 'no-file';
    	}
     	}
     	
    	$client_docs[] = $client_docs_obj;
     }
 		// $this->check_specialist_login();
 		$data = $this->specialistModel->update_reference($client_docs);
 		echo json_encode($data);
 	}

 	function update_gd_remarks(){
 		// $this->check_specialist_login();
 				$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';

     
    
    	if(!empty($_FILES['approved_doc']['name']) && count(array_filter($_FILES['approved_doc']['name'])) > 0){ 
      		$error =$_FILES["approved_doc"]["error"]; 
      		if(!is_array($_FILES["approved_doc"]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc"]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$approved_doc_name = $_FILES["approved_doc"]["name"][$i];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc"]["tmp_name"][$i],$client_doc_dir.$fileName);
          			$client_docs[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs[] = 'no-file';
    	}
 		$data = $this->specialistModel->update_globalDb($client_docs);
 		echo json_encode($data);
 	}

 	function remarkForDrugTest(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	

     for ($i=0; $i < $count; $i++) { 
     	$client_docs_obj = [];
     	if (isset($_FILES['approved_doc'.$i])) {
     		if(!empty($_FILES['approved_doc'.$i]['name']) && count(array_filter($_FILES['approved_doc'.$i]['name'])) > 0){ 
      		$error =$_FILES["approved_doc".$i]["error"]; 
      		if(!is_array($_FILES["approved_doc".$i]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc".$i]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs_obj[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc".$i]["name"]);
        		for($j=0; $j < $fileCount; $j++) {
          			$approved_doc_name = $_FILES["approved_doc".$i]["name"][$j];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"][$j],$client_doc_dir.$fileName);
          			$client_docs_obj[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs_obj[] = 'no-file';
    	}
     	}
     	
    	$client_docs[] = $client_docs_obj;
     }
 		// $this->check_specialist_login();
 		$data = $this->specialistModel->remarkForDrugTest($client_docs);
 		echo json_encode($data);
 	}

 	function remarkForDocuemtCheck(){
 		// $this->check_specialist_login();
 				$client_docs = array();
        $aadhar = array();
        $pan = array();
    	$client_doc_dir = '../uploads/remarks-docs/';

     
    
    	if(!empty($_FILES['approved_doc']['name']) && count(array_filter($_FILES['approved_doc']['name'])) > 0){ 
      		$error =$_FILES["approved_doc"]["error"]; 
      		if(!is_array($_FILES["approved_doc"]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc"]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$approved_doc_name = $_FILES["approved_doc"]["name"][$i];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc"]["tmp_name"][$i],$client_doc_dir.$fileName);
          			$client_docs[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs[] = 'no-file';
    	}

      if(!empty($_FILES['candidate_pan']['name']) && count(array_filter($_FILES['candidate_pan']['name'])) > 0){ 
          $error =$_FILES["candidate_pan"]["error"]; 
          if(!is_array($_FILES["candidate_pan"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_pan"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_pan"]["tmp_name"],$client_doc_dir.$fileName);
            $pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_pan"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["candidate_pan"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_pan"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $pan[]= $fileName; 
            } 
          }
    } else {
          $pan[] = 'no-file';
      }


      if(!empty($_FILES['candidate_aadhar']['name']) && count(array_filter($_FILES['candidate_aadhar']['name'])) > 0){ 
          $error =$_FILES["candidate_aadhar"]["error"]; 
          if(!is_array($_FILES["candidate_aadhar"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_aadhar"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"],$client_doc_dir.$fileName);
            $aadhar[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_aadhar"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["candidate_aadhar"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $aadhar[]= $fileName; 
            } 
          }
    } else {
          $aadhar[] = 'no-file';
      }
 		$data = $this->specialistModel->remarkForDocuemtCheck($aadhar,$pan,$client_docs);
 		echo json_encode($data);
 	}

 	function remarkForEduCheck(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	

     for ($i=0; $i < $count; $i++) { 
     	$client_docs_obj = [];
     	if (isset($_FILES['approved_doc'.$i])) {
     		if(!empty($_FILES['approved_doc'.$i]['name']) && count(array_filter($_FILES['approved_doc'.$i]['name'])) > 0){ 
      		$error =$_FILES["approved_doc".$i]["error"]; 
      		if(!is_array($_FILES["approved_doc".$i]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc".$i]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs_obj[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["approved_doc".$i]["name"]);
        		for($j=0; $j < $fileCount; $j++) {
          			$approved_doc_name = $_FILES["approved_doc".$i]["name"][$j];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["approved_doc".$i]["tmp_name"][$j],$client_doc_dir.$fileName);
          			$client_docs_obj[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs_obj[] = 'no-file';
    	}
     	}
     	
    	$client_docs[] = $client_docs_obj;
     }
 		// $this->check_specialist_login();
 		$data = $this->specialistModel->remarkForEduCheck($client_docs);
 		echo json_encode($data);
 	}

  function getMinimumTaskHandlerOutPutQC(){
    $data = $this->specialistModel->isAllComponentApproved('4');
    echo json_encode($data);
    // $array = [21,65,45,34,22];
    // if(!array_intersect([21,22,23,24], $array)) {
    //  print "true";
    // } else {
    //  print "false";
    // }
  }



  function export_excel(){
    // $this->check_analyst_login(); 
    $data['components'] = $this->componentModel->get_component_details();
      $data['component'] = $this->session->userdata('logged-in-specialist');  
    $this->load->view('specialist/specialist-common/header',$data);
		$this->load->view('specialist/specialist-common/sidebar');
		$this->load->view('analyst/report/excel-report',$data);
		$this->load->view('specialist/specialist-common/footer');
  }

  
  function internal_chat(){
    $this->check_specialist_login();
    $data['title'] = "Internal Chat"; 
    $team = $this->session->userdata('logged-in-specialist');
    $data['team'] = $this->db->where_not_in('team_id',$team['team_id'])->where('is_Active',1)->get('team_employee')->result_array();  
    $this->load->view('specialist/specialist-common/header');
    $this->load->view('specialist/specialist-common/sidebar');
    $this->load->view('admin/chat/internal-chat',$data);
    $this->load->view('specialist/specialist-common/footer');
  }

 
} 