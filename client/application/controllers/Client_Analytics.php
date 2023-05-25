 
<?php 
class Client_Analytics extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	/*  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');  
	  $this->load->model('inputQcModel');  
	  $this->load->model('emailModel');  
      $this->load->model('analystModel');  
	  $this->load->model('insuffAnalystModel');   
	  $this->load->model('componentModel');  */ 
      $this->load->model('utilModel');   
	  $this->load->model('client_Analytics_Model');   

	}

 
	function get_all_client_wise_inventory_cases(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->client_Analytics_Model->get_all_client_wise_inventory_cases()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function get_all_tat_details(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->client_Analytics_Model->get_all_tat_details()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}
	function get_monthly_pending_cases(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->client_Analytics_Model->get_monthly_pending_cases()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

	function all_in_progress_analytics(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->client_Analytics_Model->all_in_progress_analytics()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}
	function all_in_progress_analytics_inventory(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->client_Analytics_Model->all_in_progress_analytics_inventory()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}
	function get_data_yearly(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode($this->client_Analytics_Model->get_data_yearly());
		}else{
			echo json_encode(array());
			die();
		}	
	}

 
	function all_count_case_list_count(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') { 
			$data['inventry'] = $this->client_Analytics_Model->get_all_client_wise_inventory_cases();
			$data['total'] = $this->client_Analytics_Model->total_report_count();
			$data['report'] = $this->client_Analytics_Model->all_report_counts(); 
			 echo json_encode($data);
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}

 	function get_status_wise_case_summary_details() {
 		if (isset($_POST) && $this->input->post('is_admin') == '1') { 
			echo json_encode($this->client_Analytics_Model->get_status_wise_case_summary_details());
		} else {
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
 		}
 	}

}