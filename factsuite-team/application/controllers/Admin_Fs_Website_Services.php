<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Admin_Fs_Website_Services extends CI_Controller {
		
		function __construct() {
		  	parent::__construct();
		  	$this->load->database();
		  	$this->load->helper('url');
		  	$this->load->model('componentModel');
		  	$this->load->model('admin_Fs_Website_Services_Model');
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

		function check_new_service_name() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','check_duplication'=>$this->admin_Fs_Website_Services_Model->check_new_service_name($this->input->post('service_name'))));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function check_update_service_name() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','check_duplication'=>$this->admin_Fs_Website_Services_Model->check_update_service_name($this->input->post('service_id'),$this->input->post('service_name'))));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function add_new_service() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				$check_service_name = $this->admin_Fs_Website_Services_Model->check_new_service_name($this->input->post('service_name'));
				if ($check_service_name['count'] == 0) {
					$store_thumbnail_image = 'no-file';
					$output_thumbnail_image = '../uploads/factsuite-website-thumbnail-image/';

					$store_banner_image = 'no-file';
					$output_banner_image = '../uploads/factsuite-website-banner-image/';

					$store_service_icon = 'no-file';
					$output_service_icon = '../uploads/factsuite-website-service-icon/';

					$store_service_benefits_image = [];
					$output_service_benefits_image = '../uploads/factsuite-website-service-benefits-image/';

			        if(isset($_FILES['thumbnail_image'])) {
			        	$error = $_FILES["thumbnail_image"]["error"]; 
			            if(!is_array($_FILES["thumbnail_image"]["name"])) {
			                $files_name = $_FILES["thumbnail_image"]["name"];
			                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                // $thumbnail_image = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                // $fileName = $thumbnail_image.'.'.$file_ext;
			                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"],$output_thumbnail_image.$fileName);
			                $store_thumbnail_image = $fileName; 
			            } else {
			             	$fileCount = count($_FILES["thumbnail_image"]["name"]);
			              	for($i=0; $i < $fileCount; $i++) {
			                 	$files_name = $_FILES["thumbnail_image"]["name"][$i];
			                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                	// $thumbnail_image = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                	// $fileName = $thumbnail_image.'.'.$file_ext;
			                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                	move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"][$i],$output_thumbnail_image.$fileName);
			                	$store_thumbnail_image[]= $fileName; 
			              	}
			            } 
			        }

			        if(isset($_FILES['banner_image'])) {
			        	$error = $_FILES["banner_image"]["error"]; 
			            if(!is_array($_FILES["banner_image"]["name"])) {
			                $files_name = $_FILES["banner_image"]["name"];
			                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                // $banner_image = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                // $fileName = $banner_image.'.'.$file_ext;
			                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                move_uploaded_file($_FILES["banner_image"]["tmp_name"],$output_banner_image.$fileName);
			                $store_banner_image = $fileName; 
			            } else {
			             	$fileCount = count($_FILES["banner_image"]["name"]);
			              	for($i=0; $i < $fileCount; $i++) {
			                 	$files_name = $_FILES["banner_image"]["name"][$i];
			                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                	// $banner_image = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                	// $fileName = $banner_image.'.'.$file_ext;
			                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                	move_uploaded_file($_FILES["banner_image"]["tmp_name"][$i],$output_banner_image.$fileName);
			                	$store_banner_image[]= $fileName; 
			              	}
			            } 
			        }

			        if(isset($_FILES['service_icon'])) {
			        	$error = $_FILES["service_icon"]["error"]; 
			            if(!is_array($_FILES["service_icon"]["name"])) {
			                $files_name = $_FILES["service_icon"]["name"];
			                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                // $service_icon = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                // $fileName = $service_icon.'.'.$file_ext;
			                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                move_uploaded_file($_FILES["service_icon"]["tmp_name"],$output_service_icon.$fileName);
			                $store_service_icon = $fileName; 
			            } else {
			             	$fileCount = count($_FILES["service_icon"]["name"]);
			              	for($i=0; $i < $fileCount; $i++) {
			                 	$files_name = $_FILES["service_icon"]["name"][$i];
			                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                	// $service_icon = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                	// $fileName = $service_icon.'.'.$file_ext;
			                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                	move_uploaded_file($_FILES["service_icon"]["tmp_name"][$i],$output_service_icon.$fileName);
			                	$store_service_icon[]= $fileName; 
			              	}
			            } 
			        }

			        if(isset($_FILES['service_benefits'])) {
			        	$error = $_FILES["service_benefits"]["error"]; 
			            if(!is_array($_FILES["service_benefits"]["name"])) {
			                $files_name = $_FILES["service_benefits"]["name"];
			                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                // $service_benefits = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                // $fileName = $service_benefits.'.'.$file_ext;
			                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                move_uploaded_file($_FILES["service_benefits"]["tmp_name"],$output_service_benefits_image.$fileName);
			                $store_service_benefits_image = $fileName; 
			            } else {
			             	$fileCount = count($_FILES["service_benefits"]["name"]);
			              	for($i=0; $i < $fileCount; $i++) {
			                 	$files_name = $_FILES["service_benefits"]["name"][$i];
			                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                	// $service_benefits = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                	// $fileName = $service_benefits.'.'.$file_ext;
			                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                	move_uploaded_file($_FILES["service_benefits"]["tmp_name"][$i],$output_service_benefits_image.$fileName);
			                	$store_service_benefits_image[]= $fileName; 
			              	}
			            } 
			        } else {
			        	$store_service_benefits_image = 'no-file';
			        }

					echo json_encode(array('status'=>'1','service_details'=>$this->admin_Fs_Website_Services_Model->add_new_service($store_thumbnail_image,$store_banner_image,$store_service_icon,$store_service_benefits_image)));
				} else {
					echo json_encode(array('status'=>'2','message'=>'Entered service name already exists. Pelase enter new service name.'));
				}
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function update_factsuite_website_service() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				$check_service_name = $this->admin_Fs_Website_Services_Model->check_update_service_name($this->input->post('service_id'),$this->input->post('service_name'));
				if ($check_service_name['count'] == 0) {
					$store_thumbnail_image = 'no-file';
					$output_thumbnail_image = '../uploads/factsuite-website-thumbnail-image/';

					$store_banner_image = 'no-file';
					$output_banner_image = '../uploads/factsuite-website-banner-image/';

					$store_service_icon = 'no-file';
					$output_service_icon = '../uploads/factsuite-website-service-icon/';

					$store_service_benefits_image = [];
					$output_service_benefits_image = '../uploads/factsuite-website-service-benefits-image/';

			        if(isset($_FILES['thumbnail_image'])) {
			        	$error = $_FILES["thumbnail_image"]["error"]; 
			            if(!is_array($_FILES["thumbnail_image"]["name"])) {
			                $files_name = $_FILES["thumbnail_image"]["name"];
			                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                // $thumbnail_image = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                // $fileName = $thumbnail_image.'.'.$file_ext;
			                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"],$output_thumbnail_image.$fileName);
			                $store_thumbnail_image = $fileName; 
			            } else {
			             	$fileCount = count($_FILES["thumbnail_image"]["name"]);
			              	for($i=0; $i < $fileCount; $i++) {
			                 	$files_name = $_FILES["thumbnail_image"]["name"][$i];
			                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                	// $thumbnail_image = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                	// $fileName = $thumbnail_image.'.'.$file_ext;
			                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                	move_uploaded_file($_FILES["thumbnail_image"]["tmp_name"][$i],$output_thumbnail_image.$fileName);
			                	$store_thumbnail_image[]= $fileName; 
			              	}
			            } 
			        }

			        if(isset($_FILES['banner_image'])) {
			        	$error = $_FILES["banner_image"]["error"]; 
			            if(!is_array($_FILES["banner_image"]["name"])) {
			                $files_name = $_FILES["banner_image"]["name"];
			                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                // $banner_image = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                // $fileName = $banner_image.'.'.$file_ext;
			                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                move_uploaded_file($_FILES["banner_image"]["tmp_name"],$output_banner_image.$fileName);
			                $store_banner_image = $fileName; 
			            } else {
			             	$fileCount = count($_FILES["banner_image"]["name"]);
			              	for($i=0; $i < $fileCount; $i++) {
			                 	$files_name = $_FILES["banner_image"]["name"][$i];
			                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                	// $banner_image = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                	// $fileName = $banner_image.'.'.$file_ext;
			                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                	move_uploaded_file($_FILES["banner_image"]["tmp_name"][$i],$output_banner_image.$fileName);
			                	$store_banner_image[]= $fileName; 
			              	}
			            } 
			        }

			        if(isset($_FILES['service_icon'])) {
			        	$error = $_FILES["service_icon"]["error"]; 
			            if(!is_array($_FILES["service_icon"]["name"])) {
			                $files_name = $_FILES["service_icon"]["name"];
			                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                // $service_icon = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                // $fileName = $service_icon.'.'.$file_ext;
			                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                move_uploaded_file($_FILES["service_icon"]["tmp_name"],$output_service_icon.$fileName);
			                $store_service_icon = $fileName; 
			            } else {
			             	$fileCount = count($_FILES["service_icon"]["name"]);
			              	for($i=0; $i < $fileCount; $i++) {
			                 	$files_name = $_FILES["service_icon"]["name"][$i];
			                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                	// $service_icon = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                	// $fileName = $service_icon.'.'.$file_ext;
			                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                	move_uploaded_file($_FILES["service_icon"]["tmp_name"][$i],$output_service_icon.$fileName);
			                	$store_service_icon[]= $fileName; 
			              	}
			            } 
			        }
			        
			        if(isset($_FILES['service_benefits'])) {
			        	$error = $_FILES["service_benefits"]["error"]; 
			            if(!is_array($_FILES["service_benefits"]["name"])) {
			                $files_name = $_FILES["service_benefits"]["name"];
			                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                // $service_benefits = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                // $fileName = $service_benefits.'.'.$file_ext;
			                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                move_uploaded_file($_FILES["service_benefits"]["tmp_name"],$output_service_benefits_image.$fileName);
			                $store_service_benefits_image = $fileName; 
			            } else {
			             	$fileCount = count($_FILES["service_benefits"]["name"]);
			              	for($i=0; $i < $fileCount; $i++) {
			                 	$files_name = $_FILES["service_benefits"]["name"][$i];
			                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
			                	// $service_benefits = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
			                	// $fileName = $service_benefits.'.'.$file_ext;
			                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
			                	move_uploaded_file($_FILES["service_benefits"]["tmp_name"][$i],$output_service_benefits_image.$fileName);
			                	$store_service_benefits_image[]= $fileName; 
			              	}
			            } 
			        } else {
			        	$store_service_benefits_image = 'no-file';
			        }

					echo json_encode(array('status'=>'1','service_details'=>$this->admin_Fs_Website_Services_Model->update_factsuite_website_service($store_thumbnail_image,$store_banner_image,$store_service_icon,$store_service_benefits_image)));
				} else {
					echo json_encode(array('status'=>'2','message'=>'Entered client name already exists. Pelase enter new client name.'));
				}
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}
		
		function change_factsuite_website_service_status() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','return_status'=>$this->admin_Fs_Website_Services_Model->change_factsuite_website_service_status()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function get_single_factsuite_website_service() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','service_details'=>$this->admin_Fs_Website_Services_Model->get_single_factsuite_website_service($this->input->post('service_id')),'component_list'=>$this->componentModel->get_component_details()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function delete_factsuite_website_service() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','delete_image'=>$this->admin_Fs_Website_Services_Model->delete_factsuite_website_service()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function delete_factsuite_service_benefit() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','delete_image'=>$this->admin_Fs_Website_Services_Model->delete_factsuite_service_benefit()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}

		function update_factsuite_website_service_sorting() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','product_sort'=>$this->admin_Fs_Website_Services_Model->update_factsuite_website_service_sorting()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		}
	}
?>