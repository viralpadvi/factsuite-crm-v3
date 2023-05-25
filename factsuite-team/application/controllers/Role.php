<?php
/**
 * Created Date 28-01-2021
 */
class Role extends CI_Controller
{
	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('roleModel');  
	  $this->load->model('componentModel');  
	  $this->load->model('utilModel');  
	}

	function index(){
		// $data['components'] = $this->componentModel->get_component_details();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		// $this->load->view('admin/component/add-component');
		$this->load->view('admin/role/view-role');
		$this->load->view('admin/admin-common/footer');
	}

	function insert_role(){
 
		$data = $this->roleModel->insert_role();
		echo json_encode($data);
	}
	function get_role_details($role_id = ''){
		$data = $this->roleModel->get_role_details($role_id);
		echo json_encode($data);
	}


	function get_single_component_name($role_id = ''){
		$data['role_data'] = $this->roleModel->get_single_component_name($role_id);
		$data['components'] = $this->componentModel->get_component_details();
		echo json_encode($data);
	}

	function update_role(){
		$data = $this->roleModel->update_role();
		echo json_encode($data);
	}

	function remove_role($id){
		$data = $this->roleModel->remove_role($id);
		echo json_encode($data);
	}

	function get_info_candidate_ids(){ 
		$data = $this->roleModel->isAllComponentApproved();
		echo json_encode($data);
	}


}