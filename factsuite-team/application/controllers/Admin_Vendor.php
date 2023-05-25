<?php

class Admin_Vendor extends CI_Controller {

	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->helper('string');
	  	$this->load->model('admin_Vendor_Model');
	  	$this->load->model('check_Login_Model');
	  	$this->load->model('emailModel');
	}

	function get_all_vendor_logs(){
		echo json_encode($this->admin_Vendor_Model->get_vendor_logs());
	}

	function get_latest_selected_vendor_for_component_form() {
		echo json_encode($this->admin_Vendor_Model->get_latest_selected_vendor_for_component_form());
	}

	function update_assigned_vendor_case_completion_date() {
		echo json_encode($this->admin_Vendor_Model->update_assigned_vendor_case_completion_date());	
	}
	
	function get_vendor_skills() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->get_vendor_skills());
	}

	function get_vendor_manager_list() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->get_vendor_manager_list());
	}

	function get_selected_vendor_manager_details() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->get_selected_vendor_manager_details($this->input->post('team_id')));
	}

	function check_new_vendor_spoc_email_id_exists() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->check_new_vendor_spoc_email_id_exists());
	}

	function add_new_vendor() {
		$this->check_Login_Model->check_admin_login_with_status();

		$vendor_doc_store_files = array();
    	$vendor_doc_output_dir = 'uploads/vendor-docs/';
    
    	if(!empty($_FILES['vendor_docs']['name']) && count(array_filter($_FILES['vendor_docs']['name'])) > 0){ 
      		$error =$_FILES["vendor_docs"]["error"]; 
      		if(!is_array($_FILES["vendor_docs"]["name"])) {
        		$file_ext = pathinfo($_FILES["vendor_docs"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["vendor_docs"]["tmp_name"],$vendor_doc_output_dir.$fileName);
        		$vendor_doc_store_files[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["vendor_docs"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["vendor_docs"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["vendor_docs"]["tmp_name"][$i],$vendor_doc_output_dir.$fileName);
          			$vendor_doc_store_files[]= $fileName; 
        		} 
      		}
		} else {
      		$vendor_doc_store_files = 'no-file';
    	}

		echo json_encode($this->admin_Vendor_Model->add_new_vendor($vendor_doc_store_files));
	}

	function get_active_vendor_list() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->get_vendor_list(1));
	}

	function get_inactive_vendor_list() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->get_vendor_list(0));
	}

	function get_all_vendor_list() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->get_all_vendor_list());
	}
	function change_vendor_status() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->change_vendor_status());
	}


	function get_single_vendor_details() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->get_single_vendor_details());
	}

	function remove_vendor_doc() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->remove_vendor_doc());	
	}

	function get_vendor_docs() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->get_vendor_docs($this->input->post('vendor_id')));
	}

	function check_update_vendor_spoc_email_id_exists() {
		$this->check_Login_Model->check_admin_login_with_status();
		echo json_encode($this->admin_Vendor_Model->check_update_vendor_spoc_email_id_exists());
	}

	function edit_vendor_details() {
		$this->check_Login_Model->check_admin_login_with_status();
		
		$vendor_doc_store_files = array();
    	$vendor_doc_output_dir = 'uploads/vendor-docs/';
    
    	if(!empty($_FILES['vendor_docs']['name']) && count(array_filter($_FILES['vendor_docs']['name'])) > 0){ 
      		$error =$_FILES["vendor_docs"]["error"]; 
      		if(!is_array($_FILES["vendor_docs"]["name"])) {
        		$file_ext = pathinfo($_FILES["vendor_docs"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["vendor_docs"]["tmp_name"],$vendor_doc_output_dir.$fileName);
        		$vendor_doc_store_files[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["vendor_docs"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["vendor_docs"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["vendor_docs"]["tmp_name"][$i],$vendor_doc_output_dir.$fileName);
          			$vendor_doc_store_files[]= $fileName; 
        		} 
      		}
		} else {
      		$vendor_doc_store_files = 'no-file';
    	}

		echo json_encode($this->admin_Vendor_Model->edit_vendor_details($vendor_doc_store_files));	
	}
}