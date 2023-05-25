<?php

/**
 * 
 */
class Admin_Main_Controller extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');  
	  $this->load->model('componentModel');
	  $this->load->model('admin_Fs_Website_Service_Packages_Model');
	  $this->load->model('adminViewAllCaseModel');
	  $this->load->model('outPutQcModel');
	  $this->load->model('utilModel');
	  $this->load->model('admin_Analytics_Model');
	  $this->load->model('teamModel'); 
	  $this->load->model('analystModel');
	  $this->load->model('loginModel');
	  $this->load->model('form_builder'); 
	  $this->load->model('utilModel'); 
	}

	function approval_mechanism(){
		$this->check_admin_login();
		$data['component'] = $this->db->get('components')->result_array();
		$data['team'] = $this->db->where('is_Active',1)->get('team_employee')->result_array();
		$data['roles'] = $this->db->get('roles')->result_array();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/approval/approval-common');
		$this->load->view('admin/approval/approval-mechanism',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function admin_approval_mechanism(){
		$this->check_admin_login();
		$data['component'] = $this->db->get('components')->result_array();
		$data['roles'] = $this->db->get('roles')->result_array();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/approval/approval-common');
		$this->load->view('admin/approval/admin-approval',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function admin_list_of_approval(){
		$this->check_admin_login();
		$data['approval'] = $this->db->get('list_of_approval')->result_array(); 
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/approval/approval-common');
		$this->load->view('admin/approval/admin-approval-setting',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function chart_test(){
		$this->load->view('admin/chart/test');
	}

	function check_admin_login() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function index() {
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/index');
		$this->load->view('admin/admin-common/footer');
	}


	function login_logs() {
		$this->check_admin_login();
		$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
		$data['logs'] = $this->loginModel->get_login_logs($filter);

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
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/login-logs',$data);
		$this->load->view('admin/admin-common/footer');
	}


	function sms_email_reminder() {
		// $this->check_admin_login(); 
		$data['title'] = "";
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/email-sms/reminder-common',$data);
		$this->load->view('admin/email-sms/add-reminder',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function view_sms_email_reminder() {
		// $this->check_admin_login(); 
		$data['title'] = "";
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/email-sms/reminder-common',$data);
		$this->load->view('admin/email-sms/view-reminder',$data);
		$this->load->view('admin/admin-common/footer');
	}
	function edit_sms_email_reminder() {
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/email-sms/reminder-common',$data);
		$this->load->view('admin/email-sms/edit-reminder',$data);
		$this->load->view('admin/admin-common/footer');
	}


	function holiday() {
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/holiday/view-holiday');
		$this->load->view('admin/admin-common/footer');
	}

	function schedule_report_date_time() {
		$this->check_admin_login();
		$data['fields'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/reporting-fields.json'),true);
		$data['client'] = $this->db->query('SELECT * FROM `tbl_client` LEFT JOIN tbl_clientspocdetails ON tbl_client.client_id = tbl_clientspocdetails.client_id where tbl_client.active_status =1')->result_array();
		$variable_array = array(
			'clock_for' => 0 
		);
		$data['date_time_picker_type'] = $this->utilModel->get_time_format_details($variable_array);
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/schedule/schedule-report-date-time',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function dashboard() {
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_client_details();
		$data['candidate'] = $this->clientModel->get_candidate_details();
		$data['components'] = $this->componentModel->get_component_details();
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/dashboard/dashboard',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function receivals_analytics() {
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_client_details();
		$data['candidate'] = $this->clientModel->get_candidate_details();
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/dashboard/receivals-analytics',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function get_role_list() {
		echo json_encode($this->teamModel->get_role_list());
	}

	function check_selected_team_member_role() {
		echo json_encode($this->teamModel->check_selected_team_member_role($this->input->post('role_id'),$this->input->post('team_member_id')));
	}

	function bulk_assign_cases_to_team_member() {
		echo json_encode($this->teamModel->bulk_assign_cases_to_team_member());	
	}

	function total_closure_cases_analytics() {
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_client_details();
		$data['candidate'] = $this->clientModel->get_candidate_details();
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/dashboard/total-closure-analytics',$data);
		$this->load->view('admin/admin-common/footer');
	}

	/*factsuite team*/
	function add_team(){
		$this->check_admin_login();
		$data['team'] = $this->teamModel->get_csm_list();
		$data['role'] = $this->db->get('roles')->result_array();
		$data['approval'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/approval-title.json'),true);
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/team/add-team',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function view_team(){
		$this->check_admin_login();
		$data['approval'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/approval-title.json'),true);
		$data['role'] = $this->db->get('roles')->result_array();
		$data['team'] = $this->teamModel->get_team_all_details();
		$data['approval'] = json_decode(file_get_contents(base_url().'assets/custom-js/json/approval-title.json'),true);
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/team/view-team',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function edit_team($team_id){
		$this->check_admin_login();
		$data['team_list'] = $this->teamModel->get_team_details($team_id);
		$data['team'] = $this->teamModel->get_csm_list();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/team/edit-team',$data);
		$this->load->view('admin/admin-common/footer');
	}

	// Factsuite Vendor
	function add_new_vendor() {
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/vendor/vendor-common');
		$this->load->view('admin/vendor/add-vendor');
		$this->load->view('admin/admin-common/footer');
	}

	function view_all_vendor() {
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/vendor/vendor-common');
		$this->load->view('admin/vendor/view-all-vendors');
		$this->load->view('admin/admin-common/footer');
	}

	function view_all_active_vendor() {
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/vendor/vendor-common');
		$this->load->view('admin/vendor/view-all-vendor-common');
		$this->load->view('admin/vendor/view-active-vendors');
		$this->load->view('admin/admin-common/footer');
	}

	function view_all_inactive_vendor() {
		$this->check_admin_login();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/vendor/vendor-common');
		$this->load->view('admin/vendor/view-all-vendor-common');
		$this->load->view('admin/vendor/view-inactive-vendors');
		$this->load->view('admin/admin-common/footer');
	}

	// Factsuite Client

	function add_client() {
		// $this->check_admin_login();
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_master_client_details();
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['notification_types'] = file_get_contents(base_url().'assets/custom-js/json/notification-types.json'); 

		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
			$this->load->view('csm/csm-common/header',$data);
			$this->load->view('csm/csm-common/sidebar',$data);
		} else {
			$data['sessionData'] = $this->session->userdata('logged-in-admin');  
			$this->load->view('admin/admin-common/header',$data);
			$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common'); 
		$this->load->view('admin/client/add-client',$data);
		$this->load->view('admin/admin-common/footer');		
	}


	function add_client_select_package(){
		// $this->check_admin_login();
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_master_client_details();
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common'); 
		$this->load->view('admin/client/add-client-select-packages',$data);
		$this->load->view('admin/admin-common/footer');		
	}

	function add_client_package_component(){
		// $this->check_admin_login();
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_master_client_details();
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common'); 
		$this->load->view('admin/client/add-client-component-packages',$data);
		$this->load->view('admin/admin-common/footer');		
	}

	function add_client_alacarte_component(){
		// $this->check_admin_login();
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_master_client_details();
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common'); 
		$this->load->view('admin/client/add-client-alacarte-component',$data);
		$this->load->view('admin/admin-common/footer');		
	}

	function view_client(){
		// $this->check_admin_login();
		$data['client'] = $this->clientModel->get_master_client_details();
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['team'] = $this->teamModel->get_team_details();
		 $data['package'] = $this->packageModel->get_package_details(); 
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/view-client',$data);
		$this->load->view('admin/admin-common/footer');			
	}


	function edit_client($client_id) {
		// $this->check_admin_login();
		$data['client_id'] = $client_id;
		$data['team'] = $this->teamModel->get_team_details();
		$data['clients'] = $this->clientModel->get_master_client_details();
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		$data['notification_types'] = file_get_contents(base_url().'assets/custom-js/json/notification-types.json');
		
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
			$this->load->view('csm/csm-common/header',$data);
			$this->load->view('csm/csm-common/sidebar',$data);
		} else {
			$data['sessionData'] = $this->session->userdata('logged-in-admin');  
			$this->load->view('admin/admin-common/header',$data);
			$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/edit-client',$data);
		$this->load->view('admin/admin-common/footer');	
	}

	function edit_select_package_client($client_id){
		// $this->check_admin_login();
		$data['client_id'] = $client_id;
		$data['team'] = $this->teamModel->get_team_details();
		$data['clients'] = $this->clientModel->get_master_client_details();
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['clients'] = $this->clientModel->get_client_details();
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/edit-select-package-component-client',$data);
		$this->load->view('admin/admin-common/footer');	
	}

	function edit_client_component_packages($client_id){
		// $this->check_admin_login();
		$data['client_id'] = $client_id;
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['clients'] = $this->clientModel->get_master_client_details();
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/edit-client-component-packages',$data);
		$this->load->view('admin/admin-common/footer');	
	}

	function edit_client_alacarte_component($client_id){
		// $this->check_admin_login();
		$data['client_id'] = $client_id;
		$data['team'] = $this->teamModel->get_team_details();
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['clients'] = $this->clientModel->get_master_client_details();
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states();
		$data['city'] = $this->clientModel->get_all_cities();
		$data['package'] = $this->packageModel->get_package_details(); 
		$data['alacarte'] = $this->packageModel->get_alacarte_detail();
		$data['component'] = $this->db->get('components')->result_array();
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/edit-client-alacarte-component',$data);
		$this->load->view('admin/admin-common/footer');	
	}


	function bgv_interim_case(){
		$candidateInfo = $this->db->where('case_intrim_notification','1')->get('candidate')->result_array();
		foreach ($candidateInfo as $key => $value) {
		 	$updatedInfo = array('case_intrim_notification'=>'2','updated_date'=>date('Y-m-d H:i:s'));
			$this->db->where('candidate_id',$value['candidate_id']);
			if($this->db->update('candidate',$updatedInfo)){
				$updatedCandidatInfo = $this->db->where('candidate_id',$value['candidate_id'])->get('candidate')->row_array();
				$this->db->insert('candidate_log',$updatedCandidatInfo);
			}
		} 
		$data['case'] =  $this->outPutQcModel->isComponentCompletedCaseList();
		if ($this->session->userdata('logged-in-csm')) {
        $this->load->view('csm/csm-common/header');
        $this->load->view('csm/csm-common/sidebar');
        }else{
        $this->load->view('admin/admin-common/header');
        $this->load->view('admin/admin-common/sidebar');
        }
		$this->load->view('admin/bgv-report/case-common');
		$this->load->view('admin/bgv-report/all-case',$data);
		$this->load->view('admin/admin-common/footer');	
	}


	function bgv_completed_case(){
		$candidateInfo = $this->db->where('case_complated_notification','1')->get('candidate')->result_array();
		foreach ($candidateInfo as $key => $value) {
		 	$updatedInfo = array('case_complated_notification'=>'0','updated_date'=>date('Y-m-d H:i:s'));
			$this->db->where('candidate_id',$value['candidate_id']);
			if($this->db->update('candidate',$updatedInfo)){
				$updatedCandidatInfo = $this->db->where('candidate_id',$value['candidate_id'])->get('candidate')->row_array();
				$this->db->insert('candidate_log',$updatedCandidatInfo);
			}
		} 
			
		 $data['case'] =  $this->adminViewAllCaseModel->completedCaseList();
		if ($this->session->userdata('logged-in-csm')) {
        $this->load->view('csm/csm-common/header');
        $this->load->view('csm/csm-common/sidebar');
        }else{
        $this->load->view('admin/admin-common/header');
        $this->load->view('admin/admin-common/sidebar');
        }
		$this->load->view('admin/bgv-report/case-common');
		$this->load->view('admin/bgv-report/completed-case',$data);
		$this->load->view('admin/admin-common/footer');	
	}

	function preview_interim_report($candidate_id){
		// $this->check_outputqc_login(); 
		$data['candidate_data']=$this->outPutQcModel->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->outPutQcModel->all_components($candidate_id);
		$data['candidate_status'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id);
		// $this->load->view('outputqc/outputqc-common/header');
		// $this->load->view('outputqc/outputqc-common/sidebar',$data);
		// $this->load->view('outputqc/assigned-case/case-common',$data);
		$this->load->view('outputqc/report/interim_report_preview',$data);
		// $this->load->view('outputqc/report/success_report',$data);
		// $this->load->view('outputqc/outputqc-common/footer');
	}

	function interim_pdf($candidate_id){ 
		$data['title'] = "Generate PDF" ;
		$data['candidate'] = $this->outPutQcModel->candidateReportData($candidate_id);
		$data['candidate_id'] = $candidate_id;
		$data['table'] = $this->outPutQcModel->all_components($candidate_id);
		$data['candidate_status'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id); 
			
			// Use the below for new Report UI
		if ($this->config->item('production') ==1) { 
		$this->load->view('outputqc/report/interim_report_pdf',$data);
		}else{
		$this->load->view('outputqc/report/interim_report_pdf_v3',$data); 	
		}
	}

	function completedCaseList(){
		$data = $this->adminViewAllCaseModel->completedCaseList();
		echo json_encode($data);
	}

	function alacarte(){
		$data['components'] = $this->componentModel->get_component_details();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar'); 
		$this->load->view('admin/alacarte/add-view-alacarte',$data);
		$this->load->view('admin/admin-common/footer');
	}


	function requested_form(){
		$data['components'] = $this->componentModel->get_component_details();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar'); 
		$this->load->view('admin/request-form/component-requested-form',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function add_new_website_service() {
		$data['components'] = $this->componentModel->get_component_details();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/add-new-service',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function all_website_service() {
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/all-services');
		$this->load->view('admin/admin-common/footer');
	}

	function add_website_package() {
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/add-service-package');
		$this->load->view('admin/admin-common/footer');
	}

	function add_website_package_component_details() {
		extract($_GET);
		$data['package_details'] = $this->admin_Fs_Website_Service_Packages_Model->get_add_new_package_component_details($package_id);
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/add-website-package-component-details',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function add_website_package_alacarte_component_details() {
		extract($_GET);
		$data['package_details'] = $this->admin_Fs_Website_Service_Packages_Model->get_add_new_package_component_details($package_id);
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/add-website-package-alacarte-component-details',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function all_website_packages() {
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/all-website-packages');
		$this->load->view('admin/admin-common/footer');
	}

	function edit_website_package_details() {
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/edit-website-package-details');
		$this->load->view('admin/admin-common/footer');
	}

	function edit_website_package_components() {
		extract($_GET);
		$data['package'] = $this->admin_Fs_Website_Service_Packages_Model->get_single_factsuite_website_service_package($package_id); 
		// $data['alacarte'] = $this->admin_Fs_Website_Service_Packages_Model->get_alacarte_detail();
		$data['selected_package_component_list'] = $this->admin_Fs_Website_Service_Packages_Model->selected_package_component_list($package_id);
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/edit-website-package-components',$data);
		$this->load->view('admin/admin-common/footer');	
	}

	function edit_website_package_alacarte_component_details() {
		extract($_GET);
		$data['package'] = $this->admin_Fs_Website_Service_Packages_Model->get_single_factsuite_website_service_package($package_id); 
		// $data['alacarte'] = $this->admin_Fs_Website_Service_Packages_Model->get_alacarte_detail();
		$data['selected_package_component_list'] = $this->admin_Fs_Website_Service_Packages_Model->selected_package_component_list($package_id);
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/fs-main-website-services/fs-main-website-services-common');
		$this->load->view('admin/fs-main-website-services/edit-website-package-alacarte-component-details',$data);
		$this->load->view('admin/admin-common/footer');	
	}

	function export_excel(){
		// $this->check_admin_login();
		$data['components'] = $this->componentModel->get_component_details();
		$data['mis'] = $this->db->order_by('report_id','DESC')->get('mis-reports')->row_array();
		if ($this->session->userdata('logged-in-csm')) {
        $this->load->view('csm/csm-common/header');
        $this->load->view('csm/csm-common/sidebar');
        }else{
        $this->load->view('admin/admin-common/header');
        $this->load->view('admin/admin-common/sidebar');
        }
		$this->load->view('admin/report/excel-report',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function export_cases_allotted_to_vendor() {
		$data['components'] = $this->componentModel->get_component_details();
		if ($this->session->userdata('logged-in-csm')) {
        $this->load->view('csm/csm-common/header');
        $this->load->view('csm/csm-common/sidebar');
        }else{
        $this->load->view('admin/admin-common/header');
        $this->load->view('admin/admin-common/sidebar');
        }
        $this->load->view('admin/report/cases-allotted-to-vendor-export',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function output_export_excel(){
		// $this->check_admin_login();
		$data['components'] = $this->componentModel->get_component_details();
		if ($this->session->userdata('logged-in-csm')) {
        $this->load->view('csm/csm-common/header');
        $this->load->view('csm/csm-common/sidebar');
        }else{
        $this->load->view('admin/admin-common/header');
        $this->load->view('admin/admin-common/sidebar');
        }
		$this->load->view('admin/report/outputqc-excel-report',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function inputqc_export_excel(){
		// $this->check_admin_login();
		$data['components'] = $this->componentModel->get_component_details();
		if ($this->session->userdata('logged-in-csm')) {
        $this->load->view('csm/csm-common/header');
        $this->load->view('csm/csm-common/sidebar');
        }else{
        $this->load->view('admin/admin-common/header');
        $this->load->view('admin/admin-common/sidebar');
        }
		$this->load->view('admin/report/inputqc-excel-report',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function error_log_export_excel(){
		// $this->check_admin_login();
		$data['components'] = $this->componentModel->get_component_details();
		if ($this->session->userdata('logged-in-csm')) {
        $this->load->view('csm/csm-common/header');
        $this->load->view('csm/csm-common/sidebar');
        }else{
        $this->load->view('admin/admin-common/header');
        $this->load->view('admin/admin-common/sidebar');
        }
		$this->load->view('admin/report/error-log',$data);
		$this->load->view('admin/admin-common/footer');
	}

	function add_city(){
		$this->check_admin_login();
		$data['states'] = $this->analystModel->get_all_states(101); 
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/city/view-city',$data);
		$this->load->view('admin/admin-common/footer');
	}
 
	function email_templates(){
		$this->check_admin_login();
		$data['title'] = "Email Template";
		$data['clientInfo'] = $this->db->get('tbl_client')->result_array();
		$this->load->view('admin/admin-common/header'); 
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/template/common',$data);
		$this->load->view('admin/template/email-template',$data);
		$this->load->view('admin/admin-common/footer');
	}
  
	function url_branding(){
		$this->check_admin_login();
		$data['title'] = "URL Branding"; 
		$data['clientInfo'] = $this->db->get('tbl_client')->result_array();  
		$this->load->view('admin/admin-common/header'); 
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/template/common',$data);
		$this->load->view('admin/template/url-branding',$data);
		$this->load->view('admin/admin-common/footer');
	}
 

	function internal_chat(){
		$this->check_admin_login();
		$data['title'] = "URL Branding"; 
		$team = $this->session->userdata('logged-in-admin');
		$data['team'] = $this->db->where_not_in('team_id',$team['team_id'])->get('team_employee')->result_array();  
		$this->load->view('admin/admin-common/header'); 
		$this->load->view('admin/admin-common/sidebar'); 
		$this->load->view('admin/chat/internal-chat',$data);
		$this->load->view('admin/admin-common/footer');
	}
 
	function drag_and_drop(){
		$this->check_admin_login();
		$data['title'] = "Form Builder";  
		$this->load->view('admin/admin-common/header'); 
		$this->load->view('admin/admin-common/sidebar'); 
		$this->load->view('admin/drag-drop/common-builder');
		if ($this->config->item('formbuilder_version')=='2') { 
			$this->load->view('admin/drag-drop/form-builder-v2');
		}else{ 
			$this->load->view('admin/drag-drop/drag-and-drop');
		}
		$this->load->view('admin/admin-common/footer');
	}
 
	function view_drag_and_drop(){
		$this->check_admin_login();
		$data['form'] = $this->form_builder->get_forms();
		$this->load->view('admin/admin-common/header'); 
		$this->load->view('admin/admin-common/sidebar'); 
		$this->load->view('admin/drag-drop/common-builder');
		$this->load->view('admin/drag-drop/view-form',$data);
		$this->load->view('admin/admin-common/footer');
	}
 

	function edit_form_builder($id){
		$this->check_admin_login();
		$form = $this->form_builder->get_forms($id);
		$form_data = file_get_contents(base_url().'../uploads/form-builder/'.$form[0]['form_path']); 
		$data['form'] = $form_data;
		$data['details'] = isset($form[0])?$form[0]:array();
		$data['title'] = "Form Builder";  
		$this->load->view('admin/admin-common/header'); 
		$this->load->view('admin/admin-common/sidebar'); 
		$this->load->view('admin/drag-drop/common-builder',$data);
		$this->load->view('admin/drag-drop/edit-form',$data);
		$this->load->view('admin/admin-common/footer');
	}
 

 	function add_timezone(){
		$this->check_admin_login(); 
		$date_time = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json'),true);
		$form_data = file_get_contents(base_url().'assets/custom-js/json/timezone.json'); 
		$data['date_time'] = $date_time;
		$data['clientInfo'] = $this->db->get('tbl_client')->result_array(); 
		$data['timezone'] = json_decode($form_data,true);
		$this->load->view('admin/admin-common/header'); 
		$this->load->view('admin/admin-common/sidebar');  
		$this->load->view('admin/timezone/add-timezone',$data);
		$this->load->view('admin/admin-common/footer');
	}
 
 	function nomenclature(){
		$this->check_admin_login();  
		$data['title'] = '';
		$data['clientInfo'] = $this->db->get('tbl_client')->result_array();  
		$this->load->view('admin/admin-common/header'); 
		$this->load->view('admin/admin-common/sidebar');  
		$this->load->view('admin/nomenclature/view-color',$data);
		$this->load->view('admin/admin-common/footer');
	}
 

}