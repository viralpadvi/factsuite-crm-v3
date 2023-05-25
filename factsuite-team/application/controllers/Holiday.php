<?php
/**
 * Created Date 28-01-2021
 */
class Holiday extends CI_Controller
{
	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url');   
	  $this->load->model('holidayModel');  
	}

	function index(){
		 
	}

	function get_holiday_details($holiday_id=''){
		$data = $this->holidayModel->get_holiday_details($holiday_id);
		echo json_encode($data);
	}

	function add_holiday(){
		$data = $this->holidayModel->insert_holiday();
		echo json_encode($data);
	}

	function update_holiday(){
		$data = $this->holidayModel->update_holiday();
		echo json_encode($data);
	}


	function remove_holiday($holiday_id){
		$data = $this->holidayModel->remove_holiday($holiday_id);
		echo json_encode($data);
	}

	function add_timezone(){
		$data = $this->holidayModel->add_timezone();
		echo json_encode($data);
	}

	function update_timezone(){
		$data = $this->holidayModel->update_timezone();
		echo json_encode($data);
	}

	function get_timezone_details(){
		$data = $this->holidayModel->get_timezone_details();
		echo json_encode($data);
	}


	function remove_timezone($time_id){
		$data = $this->holidayModel->remove_timezone($time_id);
		echo json_encode($data);
	}


	 
}