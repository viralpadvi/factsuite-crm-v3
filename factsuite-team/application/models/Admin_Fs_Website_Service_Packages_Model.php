<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Fs_Website_Service_Packages_Model extends CI_Model {

	function get_all_services() {
		return $this->db->order_by('service_order','ASC')->get('website_services')->result_array();
	}

	function add_new_website_package() {
		$mark_as_most_popular = 0;
		if ($this->input->post('is_package_most_popular') == '1') {
			$mark_as_most_popular = 1;
		}

		$tat_and_price_array = array();
		$tat_days = explode(',',$this->input->post('tat_days_array'));
		$tat_price = explode(',',$this->input->post('tat_price_array'));

		foreach (explode(',', $this->input->post('tat_name_array')) as $key => $value) {
			$row['name'] = $value;
			$row['days'] = $tat_days[$key];
			$row['price'] = $tat_price[$key];
			array_push($tat_and_price_array,$row);
		}
		
		$add_data = array(
			'service_id' => $this->input->post('service_name'),
			'package_type' => $this->input->post('package_type'),
			'name' => $this->input->post('package_name'),
			'description' => $this->input->post('package_description'),
			'tat_and_price' => json_encode($tat_and_price_array),
			'mark_as_most_popular' => $mark_as_most_popular,
		);

		if ($this->db->insert('main_website_service_package',$add_data)) {
			$package_id = $this->db->insert_id();
			$admin_info = $this->session->userdata('logged-in-admin');

			$add_data = array(
				'package_id' => $package_id,
				'package_components' => $this->input->post('selected_package_component'),
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);

			if($this->input->post('selected_alacarte_package_component') != '') {
				$add_data['package_alacarte_components'] = $this->input->post('selected_alacarte_package_component');
			}

			$this->db->insert('temp_website_package_components',$add_data);

			$log_data = array(
				'package_id' => $package_id,
				'service_id' => $this->input->post('service_name'),
				'package_type' => $this->input->post('package_type'),
				'name' => $this->input->post('package_name'),
				'description' => $this->input->post('package_description'),
				'tat_and_price' => json_encode($tat_and_price_array),
				'mark_as_most_popular' => $mark_as_most_popular,
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('main_website_service_package_log',$log_data);

			return array('status'=>'1','message'=>'Service package has been added successfully.','package_id'=>md5(base64_encode(MD5(md5($package_id)))));
		} else {
			return array('status'=>'0','message'=>'Something went wrong while adding the service package. Please try again');
		}
	}

	function get_add_new_package_component_details($package_id) {
		$data['package_details'] = $this->db->where('MD5(TO_BASE64(MD5(MD5(package_id))))',$package_id)->get('main_website_service_package')->row_array();
		$data['service_name'] = $this->db->select('name')->where('service_id',$data['package_details']['service_id'])->get('website_services')->row_array();
		$data['package_selected_component_and_alacarte_list'] = $this->db->select('package_components, package_alacarte_components')->where('MD5(TO_BASE64(MD5(MD5(package_id))))',$package_id)->get('temp_website_package_components')->row_array();
		$data['selected_package_component_list'] = $this->db->where_in('component_id',explode(',',$data['package_selected_component_and_alacarte_list']['package_components']))->get('components')->result_array();
		$data['selected_package_alacarte_component_list'] = $this->db->where_in('component_id',explode(',',$data['package_selected_component_and_alacarte_list']['package_alacarte_components']))->get('components')->result_array();
		return $data;
	}

	function add_new_component_details_for_website_package() {
		$update_data = array(
			'components_included_details' => $this->input->post('package_components')
		);
		if ($this->db->where('package_id',$this->input->post('package_id'))->update('main_website_service_package',$update_data)) {
			
			$log_data = $this->db->where('package_id',$this->input->post('package_id'))->get('main_website_service_package')->row_array();
			
			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data_array = array(
				'service_id' => $log_data['service_id'],
				'package_type' => $log_data['package_type'],
				'name' => $log_data['name'],
				'description' => $log_data['description'],
				'tat_and_price' => $log_data['tat_and_price'],
				'components_included_details' => $this->input->post('package_components'),
				'mark_as_most_popular' => $log_data['mark_as_most_popular'],
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('main_website_service_package_log',$log_data_array);

			return array('status'=>'1','message'=>'Package component details added successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while adding the component details.');
		}
		var_dump($_POST);
	}

	function add_new_alacarte_component_details_for_website_package() {
		$update_data = array(
			'alacarte_component_included_details' => $this->input->post('alacarte_components')
		);
		if ($this->db->where('package_id',$this->input->post('package_id'))->update('main_website_service_package',$update_data)) {
			
			$log_data = $this->db->where('package_id',$this->input->post('package_id'))->get('main_website_service_package')->row_array();
			
			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data_array = array(
				'service_id' => $log_data['service_id'],
				'package_type' => $log_data['package_type'],
				'name' => $log_data['name'],
				'description' => $log_data['description'],
				'tat_and_price' => $log_data['tat_and_price'],
				'components_included_details' => $log_data['components_included_details'],
				'alacarte_component_included_details' => $this->input->post('alacarte_components'),
				'mark_as_most_popular' => $log_data['mark_as_most_popular'],
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('main_website_service_package_log',$log_data_array);

			return array('status'=>'1','message'=>'Package alacarte component details added successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while adding the alacarte component details.');
		}
		var_dump($_POST);
	}

	function get_all_website_service_packages() {
		return $this->db->where('service_id',$this->input->post('service_id'))->order_by('package_order','ASC')->get('main_website_service_package')->result_array();
	}

	function change_factsuite_website_service_package_status() {
		$userdata = array(
			'status' => $this->input->post('changed_status')
		);

		if ($this->db->where('package_id',$this->input->post('id'))->update('main_website_service_package',$userdata)) {
			
			$log_data = $this->db->where('package_id',$this->input->post('id'))->get('main_website_service_package')->row_array();
			
			$status_log = '3';
			if ($this->input->post('changed_status') == 0) {
				$status_log = '4';
			}

			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data_array = array(
				'package_id' => $this->input->post('id'),
				'service_id' => $log_data['service_id'],
				'package_type' => $log_data['package_type'],
				'name' => $log_data['name'],
				'description' => $log_data['description'],
				'tat_and_price' => $log_data['tat_and_price'],
				'components_included_details' => $log_data['components_included_details'],
				'alacarte_component_included_details' => $log_data['alacarte_component_included_details'],
				'mark_as_most_popular' => $log_data['mark_as_most_popular'],
				'status' => $status_log,
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('main_website_service_package_log',$log_data_array);

			return array('status'=>'1','message'=>'Status updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the status.');
		}
	}

	function get_single_factsuite_website_service_package($package_id) {
		return $this->db->select('T2.name AS service_name, T1.*')->from('main_website_service_package AS T1')->join('website_services AS T2','T1.service_id = T2.service_id','Left')->where('T1.package_id',$package_id)->get()->row_array();
	}

	function update_factsuite_website_service($thumbnail_image,$banner_image,$service_benefits_image) {
		$get_service_details = $this->db->where('service_id',$this->input->post('service_id'))->get('website_services')->row_array();

		$store_service_benefits_image_details = [];
		$added_service_benefits_image_input_array = explode(',',$this->input->post('added_service_benefit_image_input_array'));
		$service_benefits = json_decode($get_service_details['service_benefits'],true);
		
		if (count($service_benefits) > 0) {
			$pre_sort_service_benefit_images = [];
			foreach ($service_benefits as $key => $value) {
				array_push($pre_sort_service_benefit_images,$value['service_benefit_image']);
			}

			$service_benefit_images_array = $pre_sort_service_benefit_images;
			$pre_sort_service_benefit_images = [];
			foreach (explode(',',$this->input->post('service_benefit_image_sorting_ids')) as $key => $value) {
				array_push($pre_sort_service_benefit_images, $service_benefit_images_array[$value]);
			}

			$i = 0;
			foreach ($service_benefits as $key => $value) {
				$store_service_benefits_image_details[$i]['service_benefit_image'] = $pre_sort_service_benefit_images[$i];
			 	$store_service_benefits_image_details[$i]['service_benefit_image_desc'] = isset($added_service_benefits_image_input_array[$i]) ? $added_service_benefits_image_input_array[$i] : '';
			 	$i++;
			}
		}

		if ($this->input->post('service_benefits_image_input') != '' && $service_benefits_image != 'no-file') {
			$service_benefits_image_desc = explode(',',$this->input->post('service_benefits_image_input'));
			foreach ($service_benefits_image as $key => $value) {
				array_push($store_service_benefits_image_details, array('service_benefit_image'=>$value,'service_benefit_image_desc'=>$service_benefits_image_desc[$key]));
			}
		}

		$update_data = array(
			'name' => $this->input->post('service_name'),
			'short_description' => $this->input->post('short_description'),
			'description' => $this->input->post('long_description'),
			'services_included_description' => $this->input->post('service_included_description'),
			'component_list' => $this->input->post('selected_component'),
			'maximum_checks' => $this->input->post('maximum_checks'),
			'service_for_self_check_status' => $this->input->post('is_self_check'),
			'service_benefits' => json_encode($store_service_benefits_image_details)
		);

		if ($thumbnail_image != 'no-file') {
			$update_data['thumbnail_image'] = $thumbnail_image;
		}

		if ($banner_image != 'no-file') {
			$update_data['banner_image'] = $banner_image;
		}

		if ($this->db->where('service_id',$this->input->post('service_id'))->update('website_services',$update_data)) {
			
			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data = array(
				'name' => $this->input->post('service_name'),
				'short_description' => $this->input->post('short_description'),
				'description' => $this->input->post('long_description'),
				'services_included_description' => $this->input->post('service_included_description'),
				'component_list' => $this->input->post('selected_component'),
				'maximum_checks' => $this->input->post('maximum_checks'),
				'service_for_self_check_status' => $this->input->post('is_self_check'),
				'service_benefits' => json_encode($store_service_benefits_image_details),
				'thumbnail_image' => $thumbnail_image,
				'banner_image' => $banner_image,
				'status' => '2',
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('website_services_log',$log_data);

			return array('status'=>'1','message'=>'Service has been updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the service. Please try again');
		}
	}

	function delete_factsuite_website_service_package() {
		$userdata = array(
			'package_id' => $this->input->post('package_id'),
		);

		$num_rows = $this->db->where($userdata)->get('main_website_service_package');

		if ($num_rows->num_rows() > 0) {
			$db_details = $num_rows->row_array();
			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data = array(
				'package_id' => $this->input->post('package_id'),
				'service_id' => $db_details['service_id'],
				'package_type' => $db_details['package_type'],
				'name' => $db_details['name'],
				'description' => $db_details['description'],
				'tat_and_price' => $db_details['tat_and_price'],
				'components_included_details' => $db_details['components_included_details'],
				'alacarte_component_included_details' => $db_details['alacarte_component_included_details'],
				'mark_as_most_popular' => $db_details['mark_as_most_popular'],
				'status'=>'5',
				'added_or_updated_by_admin_id'=>$admin_info['team_id']
			);
			$this->db->insert('main_website_service_package_log',$log_data);

			if($this->db->where('package_id',$this->input->post('package_id'))->delete('main_website_service_package')) {
				return array('status'=>'1','message'=>'Service package has been deleted successfully.');
			}
			return array('status'=>'0','message'=>'Something went wrong while deleting the service package.');
		}
		return array('status'=>'0','message'=>'Something went wrong while deleting the service package.');
	}

	function update_factsuite_website_service_package_sorting() {
 		$package_ids = $this->input->post('package_sorting_ids');
 		$p_ids = array();
 		foreach ($package_ids as $key => $ids) {
 			$row['package_id'] = $ids;
 			$row['package_order'] = $key + 1;
 			array_push($p_ids, $row);
 		}
 		
 		if ($this->db->update_batch('main_website_service_package',$p_ids, 'package_id')) {
 			$admin_info = $this->session->userdata('logged-in-admin');
 			$log_data = array(
 				'package_ids' => implode(',', $package_ids),
 				'service_id' => $this->input->post('service_id'),
 				'sorted_by_admin_id' => $admin_info['team_id']
 			);
 			$this->db->insert('website_service_package_sorting_log',$log_data);

			return array('status'=>'1','message'=>'Successfully update short by orders.'); 
		} else {
			return array('status'=>'0','message'=>'Failed Update order by.');
		}
	}

	function update_website_package_details() {
		$db_details = $this->db->where('package_id',$this->input->post('package_id'))->get('main_website_service_package')->row_array();
		
		$mark_as_most_popular = 0;
		if ($this->input->post('is_package_most_popular') == '1') {
			$mark_as_most_popular = 1;
		}

		$tat_and_price_array = array();
		$tat_days = explode(',',$this->input->post('tat_days_array'));
		$tat_price = explode(',',$this->input->post('tat_price_array'));

		foreach (explode(',', $this->input->post('tat_name_array')) as $key => $value) {
			$row['name'] = $value;
			$row['days'] = $tat_days[$key];
			$row['price'] = $tat_price[$key];
			array_push($tat_and_price_array,$row);
		}
		
		$new_components_included_array = [];
		if ($db_details['components_included_details'] != '') {
			$db_components_included_details = json_decode($db_details['components_included_details'],true);
			$selected_package_component_list = explode(',',$this->input->post('selected_package_component'));
			if (count($db_components_included_details) > 0) {
				for ($i = 0; $i < count($db_components_included_details); $i++) {
					if (in_array($db_components_included_details[$i]['component_id'], $selected_package_component_list)) {
						array_push($new_components_included_array, $db_components_included_details[$i]);
					}
				}
			}
		}

		$new_alacarte_components_included_array = [];
		if($this->input->post('selected_alacarte_package_component') != '' && $db_details['alacarte_component_included_details']) {
			$db_alacarte_component_included_details = json_decode($db_details['alacarte_component_included_details'],true);
			$selected_alacarte_package_component = explode(',',$this->input->post('selected_alacarte_package_component'));
			for ($i = 0; $i < count($db_alacarte_component_included_details); $i++) {
				if (in_array($db_alacarte_component_included_details[$i]['component_id'], $selected_alacarte_package_component)) {
					array_push($new_alacarte_components_included_array, $db_alacarte_component_included_details[$i]);
				}
			}
		}

		$update_data = array(
			'package_type' => $this->input->post('package_type'),
			'name' => $this->input->post('package_name'),
			'description' => $this->input->post('package_description'),
			'tat_and_price' => json_encode($tat_and_price_array),
			'mark_as_most_popular' => $mark_as_most_popular,
		);

		$update_data['components_included_details'] = null;
		if (count($new_components_included_array) > 0)  {
			$update_data['components_included_details'] = json_encode($new_components_included_array);
		}

		$update_data['alacarte_component_included_details'] = null;
		if (count($new_alacarte_components_included_array) > 0)  {
			$update_data['alacarte_component_included_details'] = json_encode($new_alacarte_components_included_array);
		}
		
		if ($this->db->where('package_id',$this->input->post('package_id'))->update('main_website_service_package',$update_data)) {
			$admin_info = $this->session->userdata('logged-in-admin');

			$update_data = array(
				'package_components' => $this->input->post('selected_package_component'),
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);

			$update_data['package_alacarte_components'] = null;
			if($this->input->post('selected_alacarte_package_component') != '') {
				$update_data['package_alacarte_components'] = $this->input->post('selected_alacarte_package_component');
			}

			$this->db->where('package_id',$this->input->post('package_id'))->update('temp_website_package_components',$update_data);

			$log_data = array(
				'package_id' => $this->input->post('package_id'),
				'service_id' => $db_details['service_id'],
				'package_type' => $this->input->post('package_type'),
				'name' => $this->input->post('package_name'),
				'description' => $this->input->post('package_description'),
				'tat_and_price' => json_encode($tat_and_price_array),
				'mark_as_most_popular' => $mark_as_most_popular,
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$log_data['components_included_details'] = null;
			if (count($new_components_included_array) > 0)  {
				$log_data['components_included_details'] = json_encode($new_components_included_array);
			}

			$log_data['alacarte_component_included_details'] = null;
			if (count($new_alacarte_components_included_array) > 0)  {
				$log_data['alacarte_component_included_details'] = json_encode($new_alacarte_components_included_array);
			}
			$this->db->insert('main_website_service_package_log',$log_data);

			return array('status'=>'1','message'=>'Service package has been added successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while adding the service package. Please try again');
		}
	}

	function get_single_factsuite_website_service_package_component_details() {
		$data['component_details'] = $this->db->where('package_id',$this->input->post('package_id'))->get('main_website_service_package')->row_array();
		$data['package_selected_component_and_alacarte_list'] =  $this->db->where('package_id',$this->input->post('package_id'))->get('temp_website_package_components')->row_array();
		$data['selected_package_component_list'] = $this->db->where_in('component_id',explode(',',$data['package_selected_component_and_alacarte_list']['package_components']))->get('components')->result_array();
		$data['document_type'] = $this->db->get('document_type')->result_array();
		$data['drug_test_type'] = $this->db->get('drug_test_type')->result_array();
		$data['education_type'] = $this->db->get('education_type')->result_array();
		return $data;
	}

	function selected_package_component_list($package_id) {
		$data['package_selected_component_and_alacarte_list'] =  $this->db->where('package_id',$package_id)->get('temp_website_package_components')->row_array();
		$data['selected_package_component_list'] = $this->db->where_in('component_id',explode(',',$data['package_selected_component_and_alacarte_list']['package_components']))->get('components')->result_array();
		$data['selected_package_alacarte_component_list'] = $this->db->where_in('component_id',explode(',',$data['package_selected_component_and_alacarte_list']['package_alacarte_components']))->get('components')->result_array();
		return $data;
	}
}