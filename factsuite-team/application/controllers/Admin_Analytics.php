 
<?php 
class Admin_Analytics extends CI_Controller {
	
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
	  $this->load->model('admin_Analytics_Model');   

	}

	function get_all_client_manager_list(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','manager' => $this->teamModel->get_team_details()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}
	}
	function get_all_client_cases($page){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->get_all_client_cases($page)));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function get_currunt_day_data_counting($page){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->get_currunt_day_data_counting($page)));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function get_all_client_closure_cases($page){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->get_all_client_closure_cases($page)));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function get_currunt_day_closure_data_counting($page){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->get_currunt_day_closure_data_counting($page)));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function get_all_client_wise_progress_cases(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->get_all_client_wise_progress_cases()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}
	function get_all_client_wise_inventory_cases(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->get_all_client_wise_inventory_cases()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function get_all_tat_details(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->get_all_tat_details()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}
	function get_monthly_pending_cases(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->get_monthly_pending_cases()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function all_in_progress_analytics(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->all_in_progress_analytics()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}
	function all_in_progress_analytics_inventory(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->all_in_progress_analytics_inventory()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function all_close_cases_analytics(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->all_close_cases_analytics()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function all_component_ageing_in_progress_analytics(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->all_component_ageing_in_progress_analytics()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function all_component_ageing_completed_analytics(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->all_component_ageing_completed_analytics()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function all_component_ageing_pending_days_analytics(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->all_component_ageing_pending_days_analytics()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function all_component_ageing_completed_days_analytics(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->all_component_ageing_completed_days_analytics()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function component_wise_status_check(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->admin_Analytics_Model->component_wise_status_check()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}


}