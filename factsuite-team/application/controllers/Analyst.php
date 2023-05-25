<?php

/**
 * Created 1-2-2021
 */
class Analyst extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');  
	  $this->load->model('inputQcModel');  
	  $this->load->model('emailModel');  
    $this->load->model('analystModel');  
	  $this->load->model('insuffAnalystModel');   
    $this->load->model('utilModel');   
    $this->load->model('componentModel');   
    $this->load->model('notificationModel');   
    $this->load->model('adminViewAllCaseModel');   
    $this->load->model('smsModel');   
    $this->load->model('admin_Vendor_Model');   
	  

	}

  function client_approval(){
    $this->check_analyst_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar',$sessionData);
    // $this->load->view('analyst/approval/approval-common');
    $this->load->view('analyst/approval/approval-mechanism');
    $this->load->view('analyst/analyst-common/footer');
  }

  function sent_employee_mail(){
    $data = $this->emailModel->send_mail($this->input->post('to'),$this->input->post('subject'),$this->input->post('message'));
    echo json_encode($data);
  }

	function check_analyst_login() {
 
		if(!$this->session->userdata('logged-in-analyst')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

  function view_process_guidline(){
    echo json_encode($this->analystModel->view_process_guidline());
  }

  function check_insuff_analyst_login() {
 
    if(!$this->session->userdata('logged-in-insuffanalyst')) {
      redirect($this->config->item('my_base_url').'login');
    }
  }

  function override_analyst_status(){
    echo json_encode($this->analystModel->override_analyst_status());
  }

  function assignedCaseList(){

    $this->check_analyst_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
     
    $data['case'] = $this->analystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']);

    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
   
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar',$sessionData);
    $this->load->view('analyst/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/all-assigned-case',$data);
    $this->load->view('analyst/analyst-common/footer');

  }

  function assignedCaseProgressList(){

    $this->check_analyst_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
    // echo $data['toatladata'] ;
    // exit();
    $data['case'] = $this->analystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']);

    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
   
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar',$sessionData);
    $this->load->view('analyst/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/assigned-in-progress',$data);
    $this->load->view('analyst/analyst-common/footer');

  }

  function assignedCaseCompletedList(){

    $this->check_analyst_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
    // echo $data['toatladata'] ;
    // exit();
    $data['case'] = $this->analystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']);

    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
   
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar',$sessionData);
    $this->load->view('analyst/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/assigned-completed',$data);
    $this->load->view('analyst/analyst-common/footer');

  }

  function assignedCasevendorList(){

    $this->check_analyst_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
    // echo $data['toatladata'] ;
    // exit();
    $data['case'] = $this->analystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']);

    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
   
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar',$sessionData);
    $this->load->view('analyst/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/vendor-assigned-cases',$data);
    $this->load->view('analyst/analyst-common/footer');

  }

  function view_process(){

    $this->check_analyst_login();
    $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
    // echo $data['toatladata'] ;
    // exit();  
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar',$sessionData);
    // $this->load->view('analyst/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/view-process-guidline',$data);
    $this->load->view('analyst/analyst-common/footer');
  }

  function assignedInsuffComponentList(){
    $this->check_insuff_analyst_login(); 
    $sessionData['sessionData'] = $this->session->userdata('logged-in-insuffanalyst');
    $sessionData['case'] = $this->insuffAnalystModel->getInsuffComponentForms($sessionData['sessionData']['team_id']); 
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar',$sessionData);
    // $this->load->view('analyst/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/all-assigned-insuff-component',$sessionData);
    $this->load->view('analyst/analyst-common/footer');
  }

  function assignedQcErrorComponentList(){

    $this->check_analyst_login();
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
    $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
    $data['case'] = $this->analystModel->getQcErrorComponentAna($sessionData['sessionData']['team_id']);
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar',$sessionData);
    $this->load->view('analyst/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/all-assigned-qc-error-component',$data);
    $this->load->view('analyst/analyst-common/footer');

  }

	function assignedSingleCase($candidate_id){
		// $this->check_analyst_login(); 
		$data['candidate_id'] = $candidate_id;
		$this->load->view('analyst/analyst-common/header');
		$this->load->view('analyst/analyst-common/sidebar',$data);
		$this->load->view('analyst/assigned-case/case-common',$data);
		$this->load->view('analyst/assigned-case/view-single-assigned-case',$data);
		$this->load->view('analyst/analyst-common/footer');			
	}

  function escalatory_cases() {
    $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
    $data['case'] = $this->analystModel->get_escalatory_cases($sessionData['sessionData']['team_id']);

    $data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
    $this->load->view('analyst/analyst-common/header',$sessionData);
    $this->load->view('analyst/analyst-common/sidebar');
    $this->load->view('analyst/assigned-case/case-common',$data);
    $this->load->view('analyst/assigned-case/escalatory-cases');
    $this->load->view('analyst/analyst-common/footer');
  }

	function singleComponentDetail($candidateId,$componentId,$index){
      $userId = '';
		  if($this->session->userdata('logged-in-analyst')){
        $analystUserInfo = $this->session->userdata('logged-in-analyst');
        $userId = $analystUserInfo['team_id'];
      }elseif ($this->session->userdata('logged-in-insuffanalyst')) {         
        $analystUserInfo = $this->session->userdata('logged-in-insuffanalyst');
        $userId = $analystUserInfo['team_id'];
      }
      // if($notificationInfo != '' && $notificationInfo != null){
        $notificationInfo = $this->db->where('assigned_team_id',$userId)->where('case_id',$candidateId)->where('case_index',$index)->where('component_id',$componentId)->get('notifications')->row_array();

        // echo $this->db->last_query();
        // print_r($notificationInfo);
        // exit();
        if($notificationInfo != null && $notificationInfo != ''){
          if($notificationInfo['notification_status'] == '0'){
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
      // }

		$data1 = $this->analystModel->singleComponentDetail($componentId,$candidateId);	 
		$pageName = $this->utilModel->getComponent_or_PageName($componentId);

		$data['componentData'] = $data1;
    $data['states'] = $this->analystModel->get_all_states(101);
    $data['countries'] = $this->analystModel->get_all_countries();
    // $data['cities'] = $this->componentModel->get_all_cities();
    if($componentId == '6' || $componentId == '10'){
      $data['currency'] = file_get_contents(base_url().'assets/custom-js/json/currency.json');
		}
    $data['gender_list'] = file_get_contents(base_url().'assets/custom-js/json/gender-list.json');
    $data['candidateIdLink']=$candidateId;
    $data['componentIdLink'] =$componentId;
    $data['toatladata']  = count($this->analystModel->getQcErrorComponent());
    $data['index'] = $index;

    if($componentId == '22'){
      $data['previous_employment'] = $this->db->where('candidate_id',$candidateId)->get('previous_employment')->row_array();
       $data['current_employment'] = $this->db->where('candidate_id',$candidateId)->get('current_employment')->row_array();
    }

    $userID ='';
    $userRole ='';
    if($this->session->userdata('logged-in-analyst')){
      $analystUser = $this->session->userdata('logged-in-analyst');
      $userID =$analystUser['team_id'];
      $userRole =$analystUser['role'];
    }
    else if($this->session->userdata('logged-in-insuffanalyst')){ 

      $analystUser = $this->session->userdata('logged-in-insuffanalyst');
      $userID =$analystUser['team_id'];
      $userRole =$analystUser['role'];
        // $courtRecordStatus = $componentData['analyst_status'];
    }
    $data['team_id'] = $userID;
    $data['component_id'] = $componentId;
    $data['vendor'] = $this->admin_Vendor_Model->get_all_vendor_list();

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
    $data['selected_datetime_format'] = $selected_datetime_format;
    
    $uploaded_loa = $this->db->select('signature_img')->where('candidate_id',$candidateId)->get('signature')->row_array();
    $document_uploaded_by = $this->db->where('candidate_id',$candidateId)->get('candidate')->row_array();
    $data['document_uploaded_by'] = $document_uploaded_by['document_uploaded_by'];
    $data['is_submitted'] = $document_uploaded_by['is_submitted'];
		$data['uploaded_loa'] = isset($uploaded_loa['signature_img'])?$uploaded_loa['signature_img']:"";
    $data['signature'] = isset($data1['signature'])?$data1['signature']:0;
		$url = base_url();
		$data['base_url'] = str_replace('factsuite-team/','',$url);
    

    $this->load->view('analyst/analyst-common/header');
		$this->load->view('analyst/analyst-common/sidebar',$data);
    if($userRole == 'analyst'){
      $this->load->view('analyst/assigned-case/case-common',$data);
    } 
		$this->load->view('analyst/assigned-case/component-pages/'.$pageName,$data);
		$this->load->view('analyst/analyst-common/footer');			
	}

  function get_all_priority_cases() {
    if (isset($_POST) && $this->input->post('verify_analyst_request') == '1' && $this->session->userdata('logged-in-analyst')) {
      $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
      echo json_encode(array('status'=>'1','case'=>$this->analystModel->get_escalatory_cases($sessionData['sessionData']['team_id']),'verification_status_list'=>json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true)));
    } else {
      echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
    }
  }

  function get_new_priority_cases_count() {
    if (isset($_POST) && $this->input->post('verify_analyst_request') == '1' && $this->session->userdata('logged-in-analyst')) {
      $sessionData['sessionData'] = $this->session->userdata('logged-in-analyst');
      echo json_encode(array('status'=>'1','new_cases_count'=>$this->analystModel->get_new_priority_cases_count($sessionData['sessionData']['team_id'])));
    } else {
      echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
    }
  }

  function getAssignedComponentNotification(){
    echo json_encode($this->notificationModel->getAssignedComponentNotification());
  }

	function getCaseAssignedComponent(){

		$data = $this->analystModel->getCaseAssignedComponent();		 
		echo json_encode($data);

	}

  function getQcErrorComponent(){

    $data = $this->analystModel->getQcErrorComponent();
    // exit();
    echo json_encode($data);

  }

	function insuffUpdateStatus(){
		
		$data = $this->analystModel->insuffUpdateStatus();
		echo json_encode($data);
	}

	function approveUpdateStatus(){
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		$componentname= $this->input->post('componentname');
		$data = $this->analystModel->approveUpdateStatus($candidate_id,$componentname,$component_id);
		echo json_encode($data);
	}

	function stopcheckUpdateStatus(){
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		$componentname= $this->input->post('componentname');
		$data = $this->analystModel->stopcheckUpdateStatus($candidate_id,$componentname,$component_id);
		echo json_encode($data);
	}
 	
 	function isAllComponentApproved($candidate_id = ''){
 		 
 		$dat = $this->analystModel->isAllComponentApproved($candidate_id);
 		echo json_encode($dat);
 	}

 	function update_remarks_candidate_criminal_check(){
    $this->admin_Vendor_Model->insert_vendor();
 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
 
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $remark_docs[] = 'no-file';
      } 
 		$data = $this->analystModel->update_remarks_candidate_criminal_check($client_docs);
		echo json_encode($data);	
 	}


  function update_remarks_candidate_civil_check(){
    $this->admin_Vendor_Model->insert_vendor();
    $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';
      $count = $this->input->post('count');
 
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $remark_docs[] = 'no-file';
      } 
    $data = $this->analystModel->update_remarks_candidate_civil_check($client_docs);
    echo json_encode($data);  
  }

 	function update_remarks_candidate_court_record(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	
      $this->admin_Vendor_Model->insert_vendor();
  
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      } 
 		$data = $this->analystModel->update_remarks_candidate_court_record($client_docs);
		echo json_encode($data);	
 	}

 	function update_remarks_candidate_permanent_address(){
 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
      $this->admin_Vendor_Model->insert_vendor();
     
    
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
 		$data = $this->analystModel->update_remarks_candidate_permanent_address($client_docs);
		echo json_encode($data); 		
 	}

 	function update_remarks_candidate_present_address(){
 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
 		$data = $this->analystModel->update_remarks_candidate_present_address($client_docs);
		echo json_encode($data); 		
 	}

 	function update_remarks_candidate_previous_address(){ 
 		// $this->check_analyst_login();

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	$this->admin_Vendor_Model->insert_vendor();

      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      } 
 		$data = $this->analystModel->update_remarks_candidate_previous_address($client_docs);
		echo json_encode($data); 		
 	}

 	function update_remarks_current_employment(){
 		// $this->check_analyst_login();
 				$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
 		$data = $this->analystModel->update_remarks_current_employment($client_docs);
		echo json_encode($data); 	
 	}

 	function update_remarks_previous_employment(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	$this->admin_Vendor_Model->insert_vendor();

      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      } 
 		// $this->check_analyst_login();
 		$data = $this->analystModel->update_remarks_previous_employment($client_docs);
		echo json_encode($data); 	
 	}

  function update_landlord_reference(){
    
    $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';
      $count = $this->input->post('count');
      
  
    if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            if ($file_ext !='pdf') { 
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          }else{
            $pdf = new Spatie\PdfToImage\Pdf($_FILES["remark_docs"]["tmp_name"]);

              foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
                $file_name = uniqid().date('YmdHis').'.jpg';
              $pdf->setPage($pageNumber)

                  ->saveImage($client_doc_dir.$file_name);
                    $client_docs[]= $file_name; 
              }
          }
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
               if ($file_ext !='pdf') { 
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
              }else{
              $pdf = new Spatie\PdfToImage\Pdf($_FILES["remark_docs"]["tmp_name"][$i]);

                foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
                  $file_name = uniqid().date('YmdHis').'.jpg';
                $pdf->setPage($pageNumber)

                    ->saveImage($client_doc_dir.$file_name);
                      $client_docs[]= $file_name; 
                }
            }
            
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      }
    // $this->check_analyst_login();
      $this->admin_Vendor_Model->insert_vendor();
    $data = $this->analystModel->update_landlord_reference($client_docs);
    echo json_encode($data);
  }

 	function update_reference(){

 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	
  
   if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      } 
 		// $this->check_analyst_login();
      $this->admin_Vendor_Model->insert_vendor();
 		$data = $this->analystModel->update_reference($client_docs);
 		echo json_encode($data);
 	}

 	function update_gd_remarks(){
 		// $this->check_analyst_login();
 				$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
    	if(!empty($_FILES['approved_doc']['name']) && count(array_filter($_FILES['approved_doc']['name'])) > 0){ 
      		$error =$_FILES["approved_doc"]["error"]; 
      		if(!is_array($_FILES["approved_doc"]["name"])) {
        		$file_ext = pathinfo($_FILES["approved_doc"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
            if ($file_ext !='pdf') { 
        		move_uploaded_file($_FILES["approved_doc"]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs[]= $fileName; 
          }else{
            $pdf = new Spatie\PdfToImage\Pdf($_FILES["approved_doc"]["tmp_name"]);

              foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
                $file_name = uniqid().date('YmdHis').'.jpg';
              $pdf->setPage($pageNumber)

                  ->saveImage($client_doc_dir.$file_name);
                    $client_docs[]= $file_name; 
              }
          }
      		} else {
        		$fileCount = count($_FILES["approved_doc"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$approved_doc_name = $_FILES["approved_doc"]["name"][$i];
          			$file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
               if ($file_ext !='pdf') { 
          			move_uploaded_file($_FILES["approved_doc"]["tmp_name"][$i],$client_doc_dir.$fileName);
          			$client_docs[]= $fileName; 
              }else{
              $pdf = new Spatie\PdfToImage\Pdf($_FILES["approved_doc"]["tmp_name"][$i]);

                foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
                  $file_name = uniqid().date('YmdHis').'.jpg';
                $pdf->setPage($pageNumber)

                    ->saveImage($client_doc_dir.$file_name);
                      $client_docs[]= $file_name; 
                }
            }

        		} 
      		}
		} else {
      		$client_docs[] = 'no-file';
    	}
 		$data = $this->analystModel->update_globalDb($client_docs);
 		echo json_encode($data);
 	}

  function update_social_remarks(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
    $data = $this->analystModel->update_social_remarks($client_docs);
    echo json_encode($data);
  }
  
 	function remarkForDrugTest(){
    $this->admin_Vendor_Model->insert_vendor();
 		$client_docs = array();
    	$client_doc_dir = '../uploads/remarks-docs/';
    	$count = $this->input->post('count');
    	   if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      } 		// $this->check_analyst_login();
 		$data = $this->analystModel->remarkForDrugTest($client_docs);
 		echo json_encode($data);
 	}

 	function remarkForDocuemtCheck(){
 		// $this->check_analyst_login();
 				$client_docs = array();
        $aadhar = array();
        $pan = array();
        $this->admin_Vendor_Model->insert_vendor();
    	$client_doc_dir = '../uploads/remarks-docs/';
 
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $remark_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $remark_docs[]= $fileName; 
            } 
          }
    } else {
          $remark_docs[] = 'no-file';
      }
 		$data = $this->analystModel->remarkForDocuemtCheck($remark_docs);
 		echo json_encode($data);
 	}

 	function remarkForEduCheck(){
    $this->admin_Vendor_Model->insert_vendor();
 		$client_docs = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
    	

      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      } 
 		// $this->check_analyst_login();
 		$data = $this->analystModel->remarkForEduCheck($client_docs);
 		echo json_encode($data);
 	}

 	function update_remarks_directorship_check(){
 		$approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
    	$this->admin_Vendor_Model->insert_vendor();

      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
 		// $this->check_analyst_login();
 		$data = $this->analystModel->update_remarks_directorship_check($approve_doc);
 		echo json_encode($data);
 	}

 	function update_remarks_global_sanctions_aml(){
 		$approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
    	
    $this->admin_Vendor_Model->insert_vendor();
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
 		// $this->check_analyst_login();
 		$data = $this->analystModel->update_remarks_global_sanctions_aml($approve_doc);
 		echo json_encode($data);
 	}

  
  function update_remarks_adverse_database_media_check(){
    $approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
      $this->admin_Vendor_Model->insert_vendor();

      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
    // $this->check_analyst_login();
    $data = $this->analystModel->update_remarks_adverse_database_media_check($approve_doc);
    echo json_encode($data);
  }
  function update_remarks_covid_19(){
    $approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
      $this->admin_Vendor_Model->insert_vendor();

      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
    // $this->check_analyst_login();
    $data = $this->analystModel->update_remarks_covid_19($approve_doc);
    echo json_encode($data);
  }
  
  function update_remarks_health_checkup(){
    $approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
      $this->admin_Vendor_Model->insert_vendor();

      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
    // $this->check_analyst_login();
    $data = $this->analystModel->update_remarks_health_checkup($approve_doc);
    echo json_encode($data);
  }
  

  function update_remarks_cv_check(){
    $approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
      
    $this->admin_Vendor_Model->insert_vendor();
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
    // $this->check_analyst_login();
    $data = $this->analystModel->update_remarks_cv_check($approve_doc);
    echo json_encode($data);
  }

  function update_remarks_driving_licence_check(){
    $approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
      
    $this->admin_Vendor_Model->insert_vendor();
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
    // $this->check_analyst_login();
    $data = $this->analystModel->update_remarks_driving_licence_check($approve_doc);
    echo json_encode($data);
  }

  function update_remarks_credit_cibil_check(){
    $approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
      
    $this->admin_Vendor_Model->insert_vendor();
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
    // $this->check_analyst_login();
    $data = $this->analystModel->update_remarks_credit_cibil_check($approve_doc);
    echo json_encode($data);
  }

   function update_remarks_bankruptcy_check(){
    $approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
      
$this->admin_Vendor_Model->insert_vendor();
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
    // $this->check_analyst_login();
    $data = $this->analystModel->update_remarks_bankruptcy_check($approve_doc);
    echo json_encode($data);
  }


  // update_employment_gap_check

   function update_employment_gap_check(){
    $approve_doc = array();
    $client_doc_dir = '../uploads/remarks-docs/';
    $count = $this->input->post('count');
        $this->admin_Vendor_Model->insert_vendor();

      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $approve_doc[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $approve_doc[]= $fileName; 
            } 
          }
    } else {
          $approve_doc[] = 'no-file';
    } 
    // $this->check_analyst_login();
    $data = $this->analystModel->update_employment_gap_check($approve_doc);
    echo json_encode($data);
  }


  function getMinimumTaskHandlerOutPutQC(){
    $data = $this->analystModel->isAllComponentApproved($this->input->post('candidate_id'));
    echo json_encode($data);
    
  }
  
  function isSubmitedStatusChanged(){
    $candidateId = $this->input->post('id');
    $data = $this->analystModel->isSubmitedStatusChanged($candidateId);
    echo json_encode($data);
  }


  function getInsuffComponentForms(){
    // $data = $this->insuffAnalystModel->getInsuffAnalystData();
    $data = $this->insuffAnalystModel->getInsuffComponentForms();
    echo json_encode($data);
  }
// http://localhost:8080/factsuite-crm-v2/factsuite-team/?/analyst/getInsuffComponentForms
  function getComponentForms(){
    // $data = $this->insuffAnalystModel->getInsuffAnalystData();
    $data = $this->analystModel->getInsuffComponentForms();
    echo json_encode($data);
  }

  function getQcErrorComponentAna(){
    $data = $this->analystModel->getQcErrorComponentAna();
    echo json_encode($data);   
  }


  function export_excel(){
    // $this->check_analyst_login(); 
    $data['components'] = $this->componentModel->get_component_details();
    $data['component'] = $this->session->userdata('logged-in-analyst');
    $data['insuffAnalystData'] = $this->session->userdata('logged-in-insuffanalyst');
    $this->load->view('analyst/analyst-common/header');
    $this->load->view('analyst/analyst-common/sidebar',$data);
    // $this->load->view('analyst/assigned-case/case-common',$data);
    if ($this->session->userdata('logged-in-insuffanalyst')) {
    $this->load->view('analyst/report/insuff-excel-report',$data);  
    }else{
       $this->load->view('analyst/report/excel-report',$data);  
    }
    $this->load->view('analyst/analyst-common/footer');     
  }

  // city // state 

  function get_selected_cities($cid=''){
     $data = $this->componentModel->get_all_cities($cid);
    echo json_encode($data); 
  }


  function isAnyComponentVerifiedClear($candidate_id){
    $candidate_status = $this->utilModel->isAnyComponentVerifiedClear($candidate_id);
    // $candidate_status = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id);
    // return $candidate_status;
    echo json_encode($candidate_status);
  }


  function internal_chat(){
    // $this->check_analyst_login();
    $data['title'] = "Internal Chat"; 
    $team = $this->session->userdata('logged-in-analyst');
     if($this->session->userdata('logged-in-insuffanalyst')) {
        $team = $this->session->userdata('logged-in-insuffanalyst');
      }
    $data['team'] = $this->db->where_not_in('team_id',$team['team_id'])->where('is_Active',1)->get('team_employee')->result_array();  
    $this->load->view('analyst/analyst-common/header');
    $this->load->view('analyst/analyst-common/sidebar');
    $this->load->view('admin/chat/internal-chat',$data);
    $this->load->view('analyst/analyst-common/footer');
  }

  /*new components */

    function update_sex_offender_remarks(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
    $data = $this->analystModel->update_sex_offender($client_docs);
    echo json_encode($data);
  }
 function update_politically_exposed_remarks(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
    $data = $this->analystModel->update_politically_exposed($client_docs);
    echo json_encode($data);
  }

    function update_india_civil_litigation_remarks(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
    $data = $this->analystModel->update_india_civil_litigation($client_docs);
    echo json_encode($data);
  }


    function update_mca_remarks(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
    $data = $this->analystModel->update_mca($client_docs);
    echo json_encode($data);
  }


    function update_gsa_remarks(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
    $data = $this->analystModel->update_gsa($client_docs);
    echo json_encode($data);
  }


  function update_oig_remarks(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
    $data = $this->analystModel->update_oig($client_docs);
    echo json_encode($data);
  }


  function update_nric_remarks(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
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
    $data = $this->analystModel->update_nric($client_docs);
    echo json_encode($data);
  }


  function update_remarks_candidate_right_to_work(){
    // $this->check_analyst_login();
        $client_docs = array();
      $client_doc_dir = '../uploads/remarks-docs/';

     $this->admin_Vendor_Model->insert_vendor();
    
      if(!empty($_FILES['remark_docs']['name']) && count(array_filter($_FILES['remark_docs']['name'])) > 0){ 
          $error =$_FILES["remark_docs"]["error"]; 
          if(!is_array($_FILES["remark_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["remark_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["remark_docs"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["remark_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["remark_docs"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["remark_docs"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      }
    $data = $this->analystModel->update_right_to_work($client_docs);
    echo json_encode($data);
  }




}