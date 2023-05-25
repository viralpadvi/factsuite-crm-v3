<?php

	class Common_User_Filled_Details_Component_Client_Clarifications_Model extends CI_Model {

		function raise_new_client_clarification($logged_in_user_details,$store_client_clarification_files) {
			$get_db_component_details = $this->db->select('component_name')->where('component_id',$this->input->post('component_id'))->get('components')->row_array();
			$add_data = array(
				'client_clarification_subject' => $this->input->post('client_clarification_subject'),
				'client_clarification_description' => $this->input->post('client_clarification_description'),
				'candidate_id' => $this->input->post('candidate_id'),
				'component_name' => $get_db_component_details['component_name'],
				'component_id' => $this->input->post('component_id'),
				'component_index' => $this->input->post('component_index'),
				'client_clarification_generated_by_id' => $logged_in_user_details['team_id'],
				'client_clarification_generated_by_role' => $logged_in_user_details['role']
			);

			if ($this->input->post('client_clarification_priority') != '') {
				$add_data['client_clarification_priority'] = $this->input->post('client_clarification_priority');
			}

			if ($this->input->post('client_clarification_classifications') != '') {
				$add_data['client_clarification_classifications'] = $this->input->post('client_clarification_classifications');
			}

			if ($store_client_clarification_files != '' && $store_client_clarification_files != 'no-file') {
				$add_data['client_clarification_attached_file'] = $store_client_clarification_files;
			}

			if($this->input->post('user_component_form_filled_id') != '') {
				$add_data['user_component_form_filled_id'] = $this->input->post('user_component_form_filled_id');
			}

			if ($this->db->insert('user_filled_details_component_client_clarification',$add_data)) {
				$clarification_id = $this->db->insert_id();

				$log_data = array(
					'user_filled_details_component_client_clarification_id' => $clarification_id,
					'client_clarification_description' => $this->input->post('client_clarification_description'),
					'candidate_id' => $this->input->post('candidate_id'),
					'component_name' => $get_db_component_details['component_name'],
					'component_id' => $this->input->post('component_id'),
					'component_index' => $this->input->post('component_index'),
					'client_clarification_generated_by_id' => $logged_in_user_details['team_id'],
					'client_clarification_generated_by_role' => $logged_in_user_details['role']
				);

				if ($this->input->post('client_clarification_priority') != '') {
					$log_data['client_clarification_priority'] = $this->input->post('client_clarification_priority');
				}

				if ($this->input->post('client_clarification_classifications') != '') {
					$log_data['client_clarification_classifications'] = $this->input->post('client_clarification_classifications');
				}

				if ($store_client_clarification_files != '' && $store_client_clarification_files != 'no-file') {
					$log_data['client_clarification_attached_file'] = $store_client_clarification_files;
				}

				if($this->input->post('user_component_form_filled_id') != '') {
					$log_data['user_component_form_filled_id'] = $this->input->post('user_component_form_filled_id');
				}

				$this->db->insert('user_filled_details_component_client_clarification_log',$log_data);

				return array('status'=>'1','message'=>'New client clarification has been raised successfully.');
			} else {
				return array('status'=>'0','message'=>'Something went wrong while raising the client clarification. Please try again');
			}
		}

		function check_candidate_id_request($variable_array) {
			$where_condition = array(
				'candidate_id' => $variable_array['candidate_id'],
				'client_id' => $variable_array['logged_in_user_details']['client_id']
			);
			return $this->db->select('COUNT(*) AS count')->where($where_condition)->get('candidate')->row_array();
		}

		function get_all_client_clarifications($variable_array) {
			$logged_in_user_details = $variable_array['logged_in_user_details'];
			$where_condition = array(
				'candidate_id' => $this->input->post('candidate_id'),
				'component_id' => $this->input->post('component_id'),
				'component_index' => $this->input->post('component_index')
				// 'user_component_form_filled_id' => $this->input->post('user_component_form_filled_id')
			);

			return $this->db->where($where_condition)->order_by('user_filled_details_component_client_clarification_id','DESC')->get('user_filled_details_component_client_clarification')->result_array();
		}

		function get_single_client_clarification_details($variable_array,$user_filled_details_component_client_clarification_id) {
			$where_condition = array(
				'user_filled_details_component_client_clarification_id' => $user_filled_details_component_client_clarification_id
			);

			$data['clarification_details'] = $this->db->where($where_condition)->get('user_filled_details_component_client_clarification')->row_array();
			if ($data['clarification_details'] != '') {
				$current_date_time = $this->custom_Util_Model->get_current_date_time();
				$update_data = array(
					'client_clarification_viewed_by_client_spoc_id' => $variable_array['logged_in_user_details']['spoc_id'],
					'client_clarification_viewed_by_client_status' => 1,
					'client_clarification_viewed_by_client_datetime' => $current_date_time
				);

				$this->db->where($where_condition)->update('user_filled_details_component_client_clarification',$update_data);
			}
			$data['team_details'] = $variable_array['logged_in_user_details'];
			return $data;
		}

		function get_single_client_clarifications_all_comments($variable_array) {
			$where_condition = array(
				'user_filled_details_component_client_clarification_id' => $this->input->post('user_filled_details_component_client_clarification_id')
			);

			$data['clarification_raised_by'] = $this->db->select('client_clarification_generated_by_id, client_clarification_generated_by_role')->where($where_condition)->get('user_filled_details_component_client_clarification')->row_array();
			$data['clarification_commet'] = $this->db->where($where_condition)->order_by('user_filled_details_component_client_clarification_comment_id','ASC')->get('user_filled_details_component_client_clarification_comment')->result_array();
			if (count($data['clarification_commet']) > 0) {
				$where_condition['comment_viewed_by_receiver_status'] = 0;
				$where_condition['component_client_clarification_commented_by_role != '] = 'client';
				if(count($this->db->where($where_condition)->get('user_filled_details_component_client_clarification_comment')->result_array()) > 0) {
					$current_date_time = $this->custom_Util_Model->get_current_date_time();
					$update_data = array(
						'comment_viewed_by_receiver_status' => 1,
						'comment_viewed_by_receiver_datatime' => $current_date_time
					);
					$this->db->where($where_condition)->update('user_filled_details_component_client_clarification_comment',$update_data);
				}
			}
			$data['raised_by_details'] = $variable_array['logged_in_user_details'];
			$data['client_list'] = $this->db->where('client_id',$variable_array['logged_in_user_details']['client_id'])->get('tbl_clientspocdetails')->result_array();
			return $data;
		}

		function add_new_client_clarification_comment($variable_array,$error_status = '') {
			$logged_in_user_details = $variable_array['logged_in_user_details'];
			$add_data = array(
				'user_filled_details_component_client_clarification_id' => $this->input->post('user_filled_details_component_client_clarification_id'),
				'component_client_clarification_commented_by_id' => $logged_in_user_details['spoc_id'],
				'component_client_clarification_commented_by_role' => 'client'
			);

			if ($error_status == '') {
				$add_data['user_filled_details_component_client_clarification_comment'] = $this->input->post('note_message');
			} else {
				$get_ticket_status_list = json_decode(file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json'),true);
				$error_status_type = '';
				foreach ($get_ticket_status_list as $key => $value) {
					if ($error_status == $value['id']) {
						$error_status_type = $value['status'];
					}
				}
				// $logged_in_user_details['first_name'].' '.$logged_in_user_details['last_name'].' (admin)
				$add_data['user_filled_details_component_client_clarification_comment'] = 'Changed error status to "'.$error_status_type.'"';
			}
			
			if ($this->db->insert('user_filled_details_component_client_clarification_comment',$add_data)) {
				$error_comment_id = $this->db->insert_id();
				return array('status'=>'1','message'=>'New client clarification comment has been raised successfully.','comment_id'=>$error_comment_id);
			} else {
				return array('status'=>'0','message'=>'Something went wrong while raising the client clarification comment. Please try again');
			}
		}

		function get_client_clarification_single_comment($variable_array) {
			$where_condition = array(
				'user_filled_details_component_client_clarification_comment_id' => $this->input->post('comment_id'),
				'user_filled_details_component_client_clarification_id' => $this->input->post('user_filled_details_component_client_clarification_id')
			);

			$where_condition_2 = array(
				'user_filled_details_component_client_clarification_id' => $this->input->post('user_filled_details_component_client_clarification_id')
			);

			$data['status'] = 1;
			$data['clarification_comment'] = $this->db->where($where_condition)->get('user_filled_details_component_client_clarification_comment')->row_array();
			$data['clarification_count'] = $this->db->select('COUNT(*) AS count')->where($where_condition_2)->get('user_filled_details_component_client_clarification_comment')->row_array();
			$data['comment_added_by'] = $variable_array['logged_in_user_details'];
			return $data;
		}

		function update_client_clarification_status($logged_in_user_details) {
			$where_condition = array(
				'user_filled_details_component_client_clarification_id' => $this->input->post('user_filled_details_component_client_clarification_id')
			);

			$userdata = array(
				'client_clarification_status' => $this->input->post('change_ticket_status')
			);

			if ($this->db->where($where_condition)->update('user_filled_details_component_client_clarification',$userdata)) {
				$ticket_comment = $this->add_new_client_clarification_comment($logged_in_user_details,$this->input->post('change_ticket_status'));
				$log_data = $this->db->where($where_condition)->get('user_filled_details_component_client_clarification')->row_array();
			
				$log_data_array = array(
					'user_filled_details_component_client_clarification_id' => $this->input->post('user_filled_details_component_client_clarification_id'),
					'candidate_id' => $log_data['candidate_id'],
					'component_id' => $log_data['component_id'],
					'component_index' => $log_data['component_index'],
					'user_component_form_filled_id' => $log_data['user_component_form_filled_id'],
					'client_clarification_subject' => $log_data['client_clarification_subject'],
					'client_clarification_description' => $log_data['client_clarification_description'],
					'client_clarification_priority' => $log_data['client_clarification_priority'],
					'client_clarification_classifications' => $log_data['client_clarification_classifications'],
					'client_clarification_attached_file' => $log_data['client_clarification_attached_file'],
					'client_clarification_status' => $log_data['client_clarification_status'],
					'client_clarification_generated_by_id' => $logged_in_user_details['team_id'],
					'client_clarification_generated_by_id' => $logged_in_user_details['role']
				);
				$this->db->insert('user_filled_details_component_client_clarification_log',$log_data_array);

				return array('status'=>'1','message'=>'Status updated successfully.','comment_id'=>$ticket_comment['comment_id']);
			} else {
				return array('status'=>'0','message'=>'Something went wrong while updating the status.');
			}
		}
	}	
?>