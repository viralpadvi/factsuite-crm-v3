<?php
/**
 * Created Date 28-01-2021
 */
class Package extends CI_Controller
{
	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('packageModel');  
	  $this->load->model('componentModel');  
	}

	function index(){
		$data['components'] = $this->componentModel->get_component_details();
		if ($this->session->userdata('logged-in-csm')) {
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar');
		}else{
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		}
		// $this->load->view('admin/component/add-component');
		$this->load->view('admin/package/view-package',$data);
		$this->load->view('admin/admin-common/footer');
	} 


	function insert_package(){
		$data = $this->packageModel->insert_package();
		echo json_encode($data);
	}
	function insert_alacarte(){
		$data = $this->packageModel->insert_alacarte();
		echo json_encode($data);
	}
	function get_package_details(){
		$data = $this->packageModel->get_component_name();
		echo json_encode($data);
	}

	function get_alacarte_details(){
		$data = $this->packageModel->get_alacarte_details();
		echo json_encode($data);
	}

	function get_single_component_data($package_id,$client_id){
		$data['client'] = $this->packageModel->get_single_client($client_id);
		$data['package_data'] = $this->packageModel->get_single_component_name($package_id);
		$data['components'] = $this->componentModel->get_component_details();
		echo json_encode($data);
	}

	function get_client_single_data($id){ 
		$data = $this->packageModel->get_single_client($id);
		echo json_encode($data);
	}

	function get_single_component_name($package_id = ''){
		$data['package_data'] = $this->packageModel->get_single_component_name($package_id);
		$data['components'] = $this->componentModel->get_component_details();
		echo json_encode($data);
	}

	function get_single_alacarte_component_name($alacarte_id = ''){
		$data['alacarte_data'] = $this->packageModel->get_single_alacarte_component_name($alacarte_id);
		$data['components'] = $this->componentModel->get_component_details();
		echo json_encode($data);
	}

	function get_package_component(){
		  
		 
		$data['pack'] = $this->packageModel->get_package_components($this->input->post('package_id'));
		$data['doc'] = $this->db->where('status',1)->get('document_type')->result_array();
		$data['edu'] = $this->db->where('status',1)->get('education_type')->result_array();
		$data['drug'] = $this->db->where('status',1)->get('drug_test_type')->result_array();
		$data['component_list'] = $this->db->get('components')->result_array();
		echo json_encode($data);
	}


	/*get package details */
	function get_package_component_count(){
		$data = $this->packageModel->get_package_components($this->input->post('package_id'));
		echo json_encode($data);
	}


	function get_single_component(){
		$data['pack'] = $this->packageModel->get_single_component($this->input->post('component_id'));
		$data['doc'] = $this->db->where('status',1)->get('document_type')->result_array();
		$data['edu'] = $this->db->where('status',1)->get('education_type')->result_array();
		$data['drug'] = $this->db->where('status',1)->get('drug_test_type')->result_array();
		echo json_encode($data);
	}

	function get_alacarte_component(){ 
		$data['pack'] = $this->packageModel->get_alacarte_component($this->input->post('alacarte_id'));
		$data['doc'] = $this->db->where('status',1)->get('document_type')->result_array();
		$data['edu'] = $this->db->where('status',1)->get('education_type')->result_array();
		$data['drug'] = $this->db->where('status',1)->get('drug_test_type')->result_array();
		echo json_encode($data);
	}

	function update_package(){
		$data = $this->packageModel->update_package();
		echo json_encode($data);
	}

	function remove_package($id){
		$data = $this->packageModel->remove_package($id);
		echo json_encode($data);
	}

	function update_alacarte(){
		$data = $this->packageModel->update_alacarte();
		echo json_encode($data);
	}

	function remove_alacarte($id){
		$data = $this->packageModel->remove_alacarte($id);
		echo json_encode($data);
	}

	function remove_package_data($package_id,$client_id){
		$data = $this->packageModel->remove_package_data($package_id,$client_id);
		echo json_encode($data);
	}

	function remove_alacarte_data($component_id,$client_id){
		$data = $this->packageModel->remove_alacarte_data($component_id,$client_id);
		echo json_encode($data);
	}


}