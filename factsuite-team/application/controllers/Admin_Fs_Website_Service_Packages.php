<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Admin_Fs_Website_Service_Packages extends CI_Controller {
		
		function __construct() {
		  	parent::__construct();
		  	$this->load->database();
		  	$this->load->helper('url');
		  	$this->load->model('componentModel');
		  	$this->load->model('admin_Fs_Website_Service_Packages_Model');
		}

		function index() {
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
		}

		function get_all_services() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','services_list'=>$this->admin_Fs_Website_Services_Model->get_all_services()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function add_new_website_package() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','service_package_details'=>$this->admin_Fs_Website_Service_Packages_Model->add_new_website_package()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function get_selected_component_details_for_website_package() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				$data['pack'] = $this->componentModel->get_component_details($this->input->post('component_id'));
				$data['doc'] = $this->db->where('status',1)->get('document_type')->result_array();
				$data['edu'] = $this->db->where('status',1)->get('education_type')->result_array();
				$data['drug'] = $this->db->where('status',1)->get('drug_test_type')->result_array();
				echo json_encode($data);
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function add_new_component_details_for_website_package() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','service_package_details'=>$this->admin_Fs_Website_Service_Packages_Model->add_new_component_details_for_website_package()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function add_new_alacarte_component_details_for_website_package() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','service_package_details'=>$this->admin_Fs_Website_Service_Packages_Model->add_new_alacarte_component_details_for_website_package()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function get_all_website_service_packages() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','package_list'=>$this->admin_Fs_Website_Service_Packages_Model->get_all_website_service_packages()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function change_factsuite_website_service_package_status() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','return_status'=>$this->admin_Fs_Website_Service_Packages_Model->change_factsuite_website_service_package_status()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function delete_factsuite_website_service_package() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','delete_image'=>$this->admin_Fs_Website_Service_Packages_Model->delete_factsuite_website_service_package()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function update_factsuite_website_service_package_sorting() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','package_sort'=>$this->admin_Fs_Website_Service_Packages_Model->update_factsuite_website_service_package_sorting()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function get_single_factsuite_website_service_package() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','package_details'=>$this->admin_Fs_Website_Service_Packages_Model->get_single_factsuite_website_service_package($this->input->post('package_id')),'package_type_list'=>file_get_contents(base_url().'assets/custom-js/json/main-website-service-packages-type.json'),'component_list'=>$this->componentModel->get_component_details()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function update_website_package_details() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','service_package_details'=>$this->admin_Fs_Website_Service_Packages_Model->update_website_package_details()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function get_single_factsuite_website_service_package_component_details() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','service_package_details'=>$this->admin_Fs_Website_Service_Packages_Model->get_single_factsuite_website_service_package_component_details()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}
	}
?>