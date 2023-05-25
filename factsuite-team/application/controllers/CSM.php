<?php

/**
 * Created 12-3-2021
 */
class CSM extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');  
	  $this->load->model('specialistModel');  
	  $this->load->model('emailModel');  
	  $this->load->model('amModel');  
	  $this->load->model('analystModel');  
	  $this->load->model('inputQcModel');  
	  $this->load->model('adminViewAllCaseModel');  
	  $this->load->model('utilModel');  
	  $this->load->model('admin_Vendor_Model');  
	  $this->load->model('componentModel');  

	}

	function check_csm_login() {
 
		if(!$this->session->userdata('logged-in-csm')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function index(){
		$this->check_csm_login();
		// $sessionData['sessionData'] = $this->session->userdata('logged-in-am');
		// $data['case'] = $this->amModel->getComponentForms();  
		$data['tat'] = $this->db->get('tat')->row_array();
		$data['verification_status'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true);
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar');
		// $this->load->view('am/assigned-case/case-common');
		// $this->load->view('csm/case/all-case'); 
		$this->load->view('csm/case/csm-all-cases'); 
		// $this->load->view('am/case/all-selected-cases',$data);
		$this->load->view('csm/csm-common/footer');
	}

		function dashboard() {
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_client_details();
		$data['candidate'] = $this->clientModel->get_candidate_details();
		$data['components'] = $this->componentModel->get_component_details();
		// $this->check_admin_login();
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar',$data);
		$this->load->view('admin/dashboard/dashboard',$data);
		$this->load->view('csm/csm-common/footer');
	}




	function singleComponentDetails($candidateId,$componentId,$index){
      $userId = '';
		  if($this->session->userdata('logged-in-analyst')){
        $analystUserInfo = $this->session->userdata('logged-in-analyst');
        $userId = $analystUserInfo['team_id'];
      }elseif ($this->session->userdata('logged-in-insuffanalyst')) {         
        $analystUserInfo = $this->session->userdata('logged-in-insuffanalyst');
        $userId = $analystUserInfo['team_id'];
      }else if ($this->session->userdata('logged-in-am')) {
      	$analystUserInfo = $this->session->userdata('logged-in-am');
        $userId = $analystUserInfo['team_id'];
      }
      // if($notificationInfo != '' && $notificationInfo != null){
        $notificationInfo = $this->db->where('assigned_team_id',$userId)->where('case_id',$candidateId)->where('case_index',$index)->where('component_id',$componentId)->get('notifications')->row_array();

        // echo $this->db->last_query();
        // print_r($notificationInfo);
        // exit();
        if($notificationInfo != null && $notificationInfo != ''){
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
    }else if ($this->session->userdata('logged-in-am')) {
    	$analystUser = $this->session->userdata('logged-in-am');
      $userID =$analystUser['team_id'];
      $userRole =$analystUser['role'];
    }
    $data['team_id'] = $userID;
    $data['component_id'] = $componentId;
    $data['vendor'] = $this->admin_Vendor_Model->get_all_vendor_list();
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
    
    $this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar',$data);
    if($userRole == 'analyst'){
     $this->load->view('analyst/assigned-case/case-common',$data);
    } 
		$this->load->view('analyst/assigned-case/component-pages/'.$pageName,$data);
		$this->load->view('csm/csm-common/footer');		
	}



	function singleCase($candidate_id){
		$data['candidate_id'] = $candidate_id;
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar',$data);
		// $this->load->view('am/case/case-common',$data);
		$this->load->view('csm/case/view-single-assigned-case',$data);
		$this->load->view('csm/csm-common/footer');			
	}

	function viewbulkcases(){ 
		$data['bulk'] = $this->db->select('client_bulk_uploads.*,tbl_client.client_name')->from('client_bulk_uploads')->join('tbl_client','client_bulk_uploads.uploaded_by = tbl_client.client_id','left')->order_by('client_bulk_uploads.bulk_id','DESC')->get('')->result_array();
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar',$data);
		$this->load->view('am/case/case-common',$data);
		$this->load->view('inputqc/case/view-bulk-cases',$data);
		$this->load->view('csm/csm-common/footer');			
	}


	function internal_chat(){
		$this->check_csm_login();
		$data['title'] = "Internal Chat"; 
		$team = $this->session->userdata('logged-in-csm');
		$data['team'] = $this->db->where_not_in('team_id',$team['team_id'])->where('is_Active',1)->get('team_employee')->result_array();  
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar');
		$this->load->view('admin/chat/internal-chat',$data);
		$this->load->view('csm/csm-common/footer');
	}


	function caseList(){

		// $sessionData['sessionData'] = $this->session->userdata('logged-in-am');
		$data = $this->amModel->caseList();
		echo  json_encode($data);

	}


	function component(){ 
		 
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar');
		// $this->load->view('am/case/case-common');
		$this->load->view('admin/component/view-component');
		$this->load->view('csm/csm-common/footer');			
	}

	function add_city(){
		$this->check_csm_login();
		$data['states'] = $this->analystModel->get_all_states(101); 
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar');
		$this->load->view('admin/city/view-city',$data);
		$this->load->view('csm/csm-common/footer');		
	}


	function componentList(){
		$data = $this->amModel->componentList();
		echo  json_encode($data);
	}

	function getSingleAssignedCaseDetails($candidate_id){
		$data = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id);
		echo  json_encode($data);
	}

	function priorityUpdate(){
		$data = $this->amModel->priorityUpdate();
		echo  json_encode($data);
	}


	function override_team(){
		$data = $this->amModel->override_team();
		echo  json_encode($data);
	}

	function insuff_override_team(){
		$data = $this->amModel->insuff_override_team();
		echo  json_encode($data);
	}

	function overrideInputQc(){
		$data = $this->amModel->overrideInputQc();
		echo  json_encode($data);
	}
	
	function overrideOutputQc(){
		$data = $this->amModel->overrideOutputQc();
		echo  json_encode($data);
	}

	function singleComponentDetail($candidateId,$componentId){
		// echo $componentId." : ".$candidateId;
		$this->check_csm_login(); 
		$data = $this->analystModel->singleComponentDetail($componentId,$candidateId);
		// print_r($data); 
		// exit();
		$pageName = '';
		switch ($componentId) {
			
			case '1':
				$pageName = 'criminal_checks';
				
				break;

			case '2':
				$pageName = 'court_records';
				
				break;
			case '3':
				$pageName = 'document_check';
				break;

			case '4':
				$pageName = 'drugtest';
				break;

			case '5':
				$pageName = 'globaldatabase';
				break;

			case '6':
				$pageName = 'current_employment';
				break; 
			case '7':
				$pageName = 'education_details';
				break; 
			case '8':
				$pageName = 'present_address';
				break; 
			case '9':
				$pageName = 'permanent_address';
				break; 
			case '10':
				$pageName = 'previous_employment';
				break; 
			case '11':
				$pageName = 'reference';
				break; 
			case '12':
				$pageName = 'previous_address';
			default:
				 
				break;
		};
		// echo "<br>".$pageName;
		// exit();
		$data['componentData'] = $data;
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar',$data);
		// $this->load->view('analyst/assigned-case/case-common',$data);
		$this->load->view('analyst/assigned-case/component-pages/'.$pageName,$data);
		$this->load->view('csm/csm-common/footer');			
	}


	function getmultiAssignedCaseDetails($candidate_id){
		$data = $this->amModel->getmultiAssignedCaseDetails($candidate_id);
		// echo json_encode($data);
	}
}

?>