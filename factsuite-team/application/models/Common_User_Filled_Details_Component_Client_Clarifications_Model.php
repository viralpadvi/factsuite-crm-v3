<?php

	class Common_User_Filled_Details_Component_Client_Clarifications_Model extends CI_Model {

		function get_new_client_clarification_comments_notifications($logged_in_user_details) {
			$where_condition = array(
				'T1.client_clarification_generated_by_id' => $logged_in_user_details['team_id'],
				'T1.client_clarification_generated_by_role' => $logged_in_user_details['role'],
				'T3.comment_viewed_by_receiver_status' => 0,
				'T3.component_client_clarification_commented_by_role' => 'client'
			);
			return $this->db->select('T1.*,T3.*')->where($where_condition)->join('candidate AS T2','T1.candidate_id = T2.candidate_id','left')->join('user_filled_details_component_client_clarification_comment AS T3','T3.user_filled_details_component_client_clarification_id = T1.user_filled_details_component_client_clarification_id')->get('user_filled_details_component_client_clarification AS T1')->result_array();
		}

		function raise_new_client_clarification($logged_in_user_details,$store_client_clarification_files) {
			// print_r($logged_in_user_details);
			// exit();
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

				$variable_array = array(
					'candidate_id' => $this->input->post('candidate_id')
				);
				$this->send_client_clarification_email_to_client($variable_array);
				return array('status'=>'1','message'=>'New client clarification has been raised successfully.');
			} else {
				return array('status'=>'0','message'=>'Something went wrong while raising the client clarification. Please try again');
			}
		}

		function get_all_client_clarifications($logged_in_user_details) {
			$where_condition = array(
				'candidate_id' => $this->input->post('candidate_id'),
				'component_id' => $this->input->post('component_id'),
				'component_index' => $this->input->post('component_index')
				// 'user_component_form_filled_id' => $this->input->post('user_component_form_filled_id')
			);

			if (strtolower($logged_in_user_details['role']) != 'admin') {
				$where_condition['client_clarification_generated_by_id'] = $logged_in_user_details['team_id'];
				$where_condition['client_clarification_generated_by_role'] = $logged_in_user_details['role'];
			}

			return $this->db->where($where_condition)->order_by('user_filled_details_component_client_clarification_id','DESC')->get('user_filled_details_component_client_clarification')->result_array();
		}

		function get_single_client_clarification_details($logged_in_user_details,$user_filled_details_component_client_clarification_id) {
			$data['clarification_details'] = $this->db->where('user_filled_details_component_client_clarification_id',$user_filled_details_component_client_clarification_id)->get('user_filled_details_component_client_clarification')->row_array();
			$data['team_details'] = $logged_in_user_details;
			return $data;
		}

		function get_single_client_clarifications_all_comments($logged_in_user_details) {
			$where_condition = array(
				'user_filled_details_component_client_clarification_id' => $this->input->post('user_filled_details_component_client_clarification_id')
			);

			$data['clarification_raised_by'] = $this->db->select('client_clarification_generated_by_id, client_clarification_generated_by_role')->where($where_condition)->get('user_filled_details_component_client_clarification')->row_array();
			$data['clarification_commet'] = $this->db->where($where_condition)->order_by('user_filled_details_component_client_clarification_comment_id','ASC')->get('user_filled_details_component_client_clarification_comment')->result_array();
			if ($data['clarification_raised_by']['client_clarification_generated_by_id'] == $logged_in_user_details['team_id'] && $data['clarification_raised_by']['client_clarification_generated_by_role'] == $logged_in_user_details['role']) {
				if (count($data['clarification_commet']) > 0) {
					$where_condition['comment_viewed_by_receiver_status'] = 0;
					$where_condition['component_client_clarification_commented_by_role'] = 'client';
					if(count($this->db->where($where_condition)->get('user_filled_details_component_client_clarification_comment')->result_array()) > 0) {
						$update_data = array(
							'comment_viewed_by_receiver_status' => 1,
							'comment_viewed_by_receiver_datatime' => $this->utilModel->get_current_date_time()
						);
						$this->db->where($where_condition)->update('user_filled_details_component_client_clarification_comment',$update_data);
					}
				}
			}
			$data['raised_by_details'] = $logged_in_user_details;
			
			$user_filled_details_component_client_clarification_id = $this->input->post('user_filled_details_component_client_clarification_id');
			$query = 'SELECT `client_id` FROM `candidate` WHERE `candidate_id` IN (SELECT `candidate_id` FROM `user_filled_details_component_client_clarification` WHERE `user_filled_details_component_client_clarification_id` = '.$user_filled_details_component_client_clarification_id.')';
			$get_client_id = $this->db->query($query)->row_array();

			$data['client_list'] = $this->db->where('client_id',$get_client_id['client_id'])->get('tbl_clientspocdetails')->result_array();
			return $data;
		}

		function add_new_client_clarification_comment($logged_in_user_details,$error_status = '') {
			$add_data = array(
				'user_filled_details_component_client_clarification_id' => $this->input->post('user_filled_details_component_client_clarification_id'),
				'component_client_clarification_commented_by_id' => $logged_in_user_details['team_id'],
				'component_client_clarification_commented_by_role' => $logged_in_user_details['role']
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

		function get_client_clarification_single_comment() {
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
			$data['comment_added_by'] = $this->teamModel->get_team_details($data['clarification_comment']['component_client_clarification_commented_by_id']);
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

		function send_client_clarification_email_to_client($variable_array) {
	 		$candidate_id = $variable_array['candidate_id'];
	 		$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('candidate')->row_array();
	 		if ($candidate_details != '') {
	 			$client_details = $this->db->where('client_id',$candidate_details['client_id'])->get('tbl_client')->row_array();
		 		if ($client_details['notification_to_client_for_client_clarification_status'] != '' && $client_details['notification_to_client_for_client_clarification_status'] != 0) {
		 			if (in_array(2, explode(',', $client_details['notification_to_client_for_client_clarification_types']))) {
		 				$where_condition = array(
		 					'client_id' => $candidate_details['client_id'],
		 					'template_satus' => 1
		 				);
		 				$get_client_clarification_email_template = $this->db->where($where_condition)->get('client_clarification_email_to_client_template')->row_array();
		 				if ($get_client_clarification_email_template != '') {
							$where_condition_2 = array(
								'client_id' => $candidate_details['client_id'],
								'spoc_status' => 1
							);
							$client_spoc_list = $this->db->where($where_condition_2)->get('tbl_clientspocdetails')->result_array();
							if (count($client_spoc_list) > 0) {
								foreach ($client_spoc_list as $key => $value) {
									$variable_array = array(
				 						'add_html_tags' => 1,
				 						'template' => $get_client_clarification_email_template['template'],
				 						'candidate_id' => $candidate_details['candidate_id'],
				 						'spoc_email_id' => $value['spoc_email_id']
				 					);
									$client_clarification_mail_to_client = $this->emailModel->dynamic_email_template_add_values($variable_array);
									$variable_array = array(
										'mail_to' => $value['spoc_email_id'],
										'mail_subject' => 'Client clarification raised for '.$candidate_details['first_name'].' '.$candidate_details['last_name'],
										'mail_message' => $client_clarification_mail_to_client['template'],
										'attachment_available' => 0
									);
									$this->emailModel->send_mail_v2($variable_array);
								}
							}
		 				}
		 			}
		 		}
	 		}
	 	}
	}	
?>