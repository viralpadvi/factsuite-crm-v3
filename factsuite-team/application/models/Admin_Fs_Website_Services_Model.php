<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Fs_Website_Services_Model extends CI_Model {

	function get_all_services() {
		return $this->db->order_by('service_order','ASC')->get('website_services')->result_array();
	}

	function check_new_service_name($service_name) {
		$get_service_name = $this->db->select('name')->get('website_services')->result_array();
		$count = 0;
		foreach ($get_service_name as $key => $value) {
			if (strtolower(str_replace(' ', '', $service_name)) == strtolower(str_replace(' ', '', $value['name']))) {
				$count++;
			}
		}
		return array('count'=>$count);
	}

	function check_update_service_name($service_id,$service_name) {
		$get_client_name = $this->db->select('name')->where_not_in('service_id',array($service_id))->get('website_services')->result_array();
		$count = 0;
		foreach ($get_client_name as $key => $value) {
			if (strtolower(str_replace(' ', '', $service_name)) == strtolower(str_replace(' ', '', $value['name']))) {
				$count++;
			}
		}
		return array('count'=>$count);
	}

	function add_new_service($thumbnail_image,$banner_image,$service_icon,$service_benefits_image) {
		$service_benefit_image_desc = explode(',',$this->input->post('service_benefits_image_input'));
		$store_service_benefit_image_details = [];

		$service_benefit_images_array = $service_benefits_image;
		$service_benefits_image = [];
		foreach (explode(',',$this->input->post('service_benefits_image_sorting_ids')) as $key => $value) {
			array_push($service_benefits_image, $service_benefit_images_array[$value]);
		}

		foreach ($service_benefits_image as $key => $value) {
			$store_service_benefit_image_details[$key]['service_benefit_image'] = $value;
		 	$store_service_benefit_image_details[$key]['service_benefit_image_desc'] = $service_benefit_image_desc[$key];
		}
		$update_data = array(
			'name' => $this->input->post('service_name'),
			'very_short_description' => $this->input->post('very_short_description'),
			'short_description' => $this->input->post('short_description'),
			'description' => $this->input->post('long_description'),
			'services_included_description' => $this->input->post('service_included_description'),
			'component_list' => $this->input->post('selected_component'),
			'maximum_checks' => $this->input->post('maximum_checks'),
			'thumbnail_image' => $thumbnail_image,
			'banner_image' => $banner_image,
			'service_icon' => $service_icon,
			'service_benefits' => json_encode($store_service_benefit_image_details),
			'service_for_self_check_status' => $this->input->post('is_self_check')
		);

		if ($this->db->insert('website_services',$update_data)) {
			
			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data = array(
				'service_id' => $this->db->insert_id(),
				'name' => $this->input->post('service_name'),
				'very_short_description' => $this->input->post('very_short_description'),
				'short_description' => $this->input->post('short_description'),
				'description' => $this->input->post('long_description'),
				'services_included_description' => $this->input->post('service_included_description'),
				'component_list' => $this->input->post('selected_component'),
				'maximum_checks' => $this->input->post('maximum_checks'),
				'thumbnail_image' => $thumbnail_image,
				'banner_image' => $banner_image,
				'service_icon' => $service_icon,
				'service_benefits' => json_encode($store_service_benefit_image_details),
				'service_for_self_check_status' => $this->input->post('is_self_check'),
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('website_services_log',$log_data);

			return array('status'=>'1','message'=>'Service has been added successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while adding the service. Please try again');
		}
	}

	function change_factsuite_website_service_status() {
		$userdata = array(
			'status'=>$this->input->post('changed_status')
		);

		if ($this->db->where('service_id',$this->input->post('id'))->update('website_services',$userdata)) {
			
			$log_data = $this->db->where('service_id',$this->input->post('id'))->get('website_services')->row_array();
			
			$status_log = '3';
			if ($this->input->post('changed_status') == 0) {
				$status_log = '4';
			}

			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data_array = array(
				'service_id' => $this->input->post('id'),
				'name' => $log_data['name'],
				'very_short_description' => $log_data['very_short_description'],
				'short_description' => $log_data['short_description'],
				'description' => $log_data['description'],
				'services_included_description' => $log_data['services_included_description'],
				'component_list' => $log_data['component_list'],
				'maximum_checks' => $log_data['maximum_checks'],
				'thumbnail_image' => $log_data['thumbnail_image'],
				'banner_image' => $log_data['banner_image'],
				'service_icon' => $log_data['service_icon'],
				'service_benefits' => $log_data['service_benefits'],
				'service_for_self_check_status' => $log_data['service_for_self_check_status'],
				'status' => $status_log,
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('website_services_log',$log_data_array);

			return array('status'=>'1','message'=>'Status updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the status.');
		}
	}

	function get_single_factsuite_website_service($service_id) {
		return $this->db->where('service_id',$service_id)->get('website_services')->row_array();
	}

	function update_factsuite_website_service($thumbnail_image,$banner_image,$service_icon,$service_benefits_image) {
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
			'very_short_description' => $this->input->post('very_short_description'),
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

		if ($service_icon != 'no-file') {
			$update_data['service_icon'] = $service_icon;
		}
		
		if ($this->db->where('service_id',$this->input->post('service_id'))->update('website_services',$update_data)) {
			
			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data = array(
				'name' => $this->input->post('service_name'),
				'very_short_description' => $this->input->post('very_short_description'),
				'short_description' => $this->input->post('short_description'),
				'description' => $this->input->post('long_description'),
				'services_included_description' => $this->input->post('service_included_description'),
				'component_list' => $this->input->post('selected_component'),
				'maximum_checks' => $this->input->post('maximum_checks'),
				'service_for_self_check_status' => $this->input->post('is_self_check'),
				'service_benefits' => json_encode($store_service_benefits_image_details),
				'thumbnail_image' => $thumbnail_image,
				'banner_image' => $banner_image,
				'service_icon' => $service_icon,
				'status' => '2',
				'added_or_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('website_services_log',$log_data);

			return array('status'=>'1','message'=>'Service has been updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the service. Please try again');
		}
	}

	function delete_factsuite_website_service() {
		$userdata = array(
			'service_id' => $this->input->post('service_id'),
		);

		$num_rows = $this->db->where($userdata)->get('website_services');

		if ($num_rows->num_rows() > 0) {
			$db_details = $num_rows->row_array();
			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data = array(
				'service_id' => $this->input->post('service_id'),
				'name'=>$db_details['name'],
				'very_short_description' => $db_details['very_short_description'],
				'short_description'=>$db_details['short_description'],
				'description'=>$db_details['description'],
				'services_included_description'=>$db_details['services_included_description'],
				'component_list'=>$db_details['component_list'],
				'maximum_checks'=>$db_details['maximum_checks'],
				'thumbnail_image'=>$db_details['thumbnail_image'],
				'banner_image'=>$db_details['banner_image'],
				'service_icon'=>$db_details['service_icon'],
				'service_benefits'=>$db_details['service_benefits'],
				'service_for_self_check_status'=>$db_details['service_for_self_check_status'],
				'status'=>'5',
				'added_or_updated_by_admin_id'=>$admin_info['team_id']
			);
			$this->db->insert('website_services_log',$log_data);

			if($this->db->where('service_id',$this->input->post('service_id'))->delete('website_services')) {
				return array('status'=>'1','message'=>'Service has been deleted successfully.');
			}
			return array('status'=>'0','message'=>'Something went wrong while deleting the service.');
		}
		return array('status'=>'0','message'=>'Something went wrong while deleting the service.');
	}

	function delete_factsuite_service_benefit() {
		$get_service_benefits = $this->db->select('service_benefits')->where('service_id',$this->input->post('service_id'))->get('website_services')->row_array();
		
		if ($get_service_benefits['service_benefits'] != null && $get_service_benefits['service_benefits'] != '') {
			$store_service_benefit_image_details = array();
			foreach(json_decode($get_service_benefits['service_benefits'],true) as $key => $value) {
				if($value['service_benefit_image'] != $this->input->post('image_name')) {
					$store_service_benefit_image_details[$key]['service_benefit_image'] = $value['service_benefit_image'];
		 			$store_service_benefit_image_details[$key]['service_benefit_image_desc'] = $value['service_benefit_image_desc'];
				}
			}

			$userdata = array(
				'service_benefits' => json_encode($store_service_benefit_image_details)
			);
			if ($this->db->where('service_id',$this->input->post('service_id'))->update('website_services',$userdata)) {
				$db_details = $this->db->where('service_id',$this->input->post('service_id'))->get('website_services')->row_array();
				$admin_info = $this->session->userdata('logged-in-admin');
				$log_data_array = array(
					'service_id' => $db_details['service_id'],
					'name' => $db_details['name'],
					'very_short_description' => $db_details['very_short_description'],
					'short_description' => $db_details['short_description'],
					'description' => $db_details['description'],
					'services_included_description' => $db_details['services_included_description'],
					'component_list' => $db_details['component_list'],
					'maximum_checks' => $db_details['maximum_checks'],
					'thumbnail_image' => $db_details['thumbnail_image'],
					'banner_image' => $db_details['banner_image'],
					'service_icon' => $db_details['service_icon'],
					'service_benefits' => $db_details['service_benefits'],
					'service_for_self_check_status' => $db_details['service_for_self_check_status'],
					'status' => '2',
					'added_or_updated_by_admin_id' => $admin_info['team_id']
				);
				$this->db->insert('website_services_log',$log_data_array);
				return array('status'=>'1','message'=>'Successfully Removed.');
			} else {
				return array('status'=>'0','message'=>'Failed Image remove.');
			}
		} else {
			return array('status'=>'0','message'=>'Failed Image remove.');
		}
	}

	function update_factsuite_website_service_sorting() {
 		$service_ids = $this->input->post('service_sorting_ids');
 		$s_ids = array();
 		foreach ($service_ids as $key => $ids) {
 			$row['service_id'] = $ids;
 			$row['service_order'] = $key + 1;
 			array_push($s_ids, $row);
 		}
 		
 		if ($this->db->update_batch('website_services',$s_ids, 'service_id')) {
 			$admin_info = $this->session->userdata('logged-in-admin');
 			$log_data = array(
 				'service_ids' => implode(',', $service_ids),
 				'service_sorted_by_admin_id' => $admin_info['team_id']
 			);
 			$this->db->insert('website_service_sorting_log',$log_data);

			return array('status'=>'1','message'=>'Successfully update short by orders.'); 
		} else {
			return array('status'=>'0','message'=>'Failed Update order by.');
		}
	}
}