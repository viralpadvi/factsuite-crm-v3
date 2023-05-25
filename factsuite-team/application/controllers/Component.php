<?php
/**
 * Created Date 27-01-2021
 */
class Component extends CI_Controller
{
	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('componentModel');  
	}

	function index(){
		if ($this->session->userdata('logged-in-csm')) {
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar');
		}else{
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		}
		// $this->load->view('admin/component/add-component');
		$this->load->view('admin/component/view-component');
		$this->load->view('admin/admin-common/footer');
	}

	function get_component_list() {
		echo json_encode($this->componentModel->get_component_details());
	}

	function get_city_list($id='') {
		echo json_encode($this->componentModel->get_all_cities($id));
	}
	
	function insert_component(){
		$data = $this->componentModel->insert_component();
		echo json_encode($data);
	}

	function update_component() {
		$store_component_icon = 'no-file';
		$output_component_icon = '../uploads/component-icon/';
		
		if(isset($_FILES['component_icon'])) {
        	$error = $_FILES["component_icon"]["error"]; 
            if(!is_array($_FILES["component_icon"]["name"])) {
                $files_name = $_FILES["component_icon"]["name"];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                // $component_icon = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
                // $fileName = $component_icon.'.'.$file_ext;
                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
                move_uploaded_file($_FILES["component_icon"]["tmp_name"],$output_component_icon.$fileName);
                $store_component_icon = $fileName; 
            } else {
             	$fileCount = count($_FILES["component_icon"]["name"]);
              	for($i=0; $i < $fileCount; $i++) {
                 	$files_name = $_FILES["component_icon"]["name"][$i];
                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                	// $component_icon = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
                	// $fileName = $component_icon.'.'.$file_ext;
                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
                	move_uploaded_file($_FILES["component_icon"]["tmp_name"][$i],$output_component_icon.$fileName);
                	$store_component_icon[]= $fileName; 
              	}
            } 
        }
		
		$data = $this->componentModel->update_component($store_component_icon);
		echo json_encode($data);
	}
	
	function get_component_details($component_id = ''){
		$data = $this->componentModel->get_component_details($component_id);
		echo json_encode($data);
	}

	function remove_component($id){
		$data = $this->componentModel->remove_component($id);
		echo json_encode($data);
	}

	function insert_city(){
		// echo json_encode($_POST);
		$data = $this->componentModel->insert_city();
		echo json_encode($data);
	}

	
}