<?php 

class ScheduleReport extends CI_Controller {
	
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
	  $this->load->model('scheduleReportModel');

	}

	function add_reporting(){
		echo json_encode($this->scheduleReportModel->add_schedule_reporting());
	}

	function update_reporting(){
		echo json_encode($this->scheduleReportModel->update_reporting());
	}	
	function remove_schedule($id){
		echo json_encode($this->scheduleReportModel->remove_schedule($id));
	}
 
	function get_schedule_details(){
		echo json_encode($this->scheduleReportModel->get_schedule_details());
	}

	function get_single_schedule_details($id){
		$datas = $this->db->query('SELECT * FROM `tbl_client` LEFT JOIN tbl_clientspocdetails ON tbl_client.client_id = tbl_clientspocdetails.client_id where tbl_client.active_status =1')->result_array();
		echo json_encode(array('client'=>$datas,'report'=>$this->scheduleReportModel->get_single_schedule_details($id),'fields'=>json_decode(file_get_contents(base_url().'assets/custom-js/json/reporting-fields.json'),true)));
	}



}