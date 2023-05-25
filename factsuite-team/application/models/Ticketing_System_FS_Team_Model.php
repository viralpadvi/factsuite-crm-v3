<?php

	class Ticketing_System_FS_Team_Model extends CI_Model {

		function get_ticket_notifications($variable_array) {
			$where_condition = [];
			if ($variable_array['type'] == 'fs_team') {
				$where_condition = array(
					'ticket_assigned_to_role_id' => $variable_array['logged_in_user_details']['team_id'],
					'ticket_assigned_to_role' => $variable_array['logged_in_user_details']['role']
				);
			}

			return $this->db->where($where_condition)->where_in('notification_status_for_assigned_to',array(0,2))->order_by('ticket_id','DESC')->get('raise_a_ticket')->result_array();
		}

		function get_logged_in_details($variable_array) {
			return $this->db->where('role_status','1')->where_not_in('role_id',[10])->get('roles')->result_array();
		}

		function get_roles_person_list($variable_array) {
			$where_condition = array(
				'role' => $variable_array['role_type'],
				'is_Active' => 1
			);
			if ($variable_array['role_type'] !='client') { 
			return $this->db->where($where_condition)->get('team_employee')->result_array();
			}

			$client_list = array();
			$result = $this->db->order_by('tbl_client.client_id','DESC')->where('active_status',1)->select('tbl_client.*, tbl_clientspocdetails.*')->from('tbl_client')->join('tbl_clientspocdetails','tbl_client.client_id = tbl_clientspocdetails.client_id','left')->get()->result_array();
			 
			 foreach ($result as $key => $value) {
			 	if ($value['client_name'] !=null) { 
				 	$row['team_id'] = $value['client_id'];
				 	$row['first_name'] = $value['client_name'];
				 	$row['last_name'] = '';
				 	$row['team_employee_email'] = $value['spoc_email_id'];
				 	array_push($client_list,$row);
			 	}
			 }

			 return $client_list;

		}

		function raise_new_ticket($variable_array,$store_ticket_files) {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
			$add_data = array(
				'ticket_assigned_to_role_id' => $this->input->post('assigned_to_person_id'),
				'ticket_assigned_to_role' => $this->input->post('assigned_to_role'),
				'ticket_subject' => $this->input->post('ticket_subject'),
				'ticket_description' => $this->input->post('ticket_description')
			);

			if ($variable_array['type'] == 'fs_team') {
				$add_data['ticket_created_by_role_id'] = $variable_array['logged_in_user_details']['team_id'];
				$add_data['ticket_created_by_role'] = $variable_array['logged_in_user_details']['role'];
			}

			if ($this->input->post('ticket_priority') != '') {
				$add_data['ticket_priority'] = $this->input->post('ticket_priority');
			}

			if ($this->input->post('ticket_classifications') != '') {
				$add_data['ticket_classifications'] = $this->input->post('ticket_classifications');
			}

			if ($store_ticket_files != '' && $store_ticket_files != 'no-file') {
				$add_data['ticket_attached_file'] = $store_ticket_files;
			}

			if ($this->db->insert('raise_a_ticket',$add_data)) {
				$ticket_id = $this->db->insert_id();

				$log_data = array(
					'ticket_id' => $ticket_id,
					'ticket_assigned_to_role_id' => $this->input->post('assigned_to_person_id'),
					'ticket_assigned_to_role' => $this->input->post('assigned_to_role'),
					'ticket_subject' => $this->input->post('ticket_subject'),
					'ticket_description' => $this->input->post('ticket_description'),
				);

				if ($variable_array['type'] == 'fs_team') {
					$log_data['ticket_created_by_role_id'] = $log_data['ticket_updated_by_role_id'] = $variable_array['logged_in_user_details']['team_id'];
					$log_data['ticket_created_by_role'] = $log_data['ticket_updated_by_role'] = $variable_array['logged_in_user_details']['role'];
				}

				if ($this->input->post('ticket_priority') != '') {
					$log_data['ticket_priority'] = $this->input->post('ticket_priority');
				}

				if ($this->input->post('ticket_classifications') != '') {
					$log_data['ticket_classifications'] = $this->input->post('ticket_classifications');
				}

				if ($store_ticket_files != '' && $store_ticket_files != 'no-file') {
					$log_data['ticket_attached_file'] = $store_ticket_files;
				}

				$this->db->insert('raise_a_ticket_log',$log_data);

				return array('status'=>'1','message'=>'New ticket has been raised successfully.');
			} else {
				return array('status'=>'0','message'=>'Something went wrong while raising the ticket. Please try again');
			}
		}

		function get_all_tickets() {
			return $this->db->order_by('ticket_id','DESC')->get('raise_a_ticket')->result_array();
		}

		function get_all_raised_tickets($variable_array) {
			$where_condition = [];
			if ($variable_array['type'] == 'fs_team') {
				$where_condition = array(
					'ticket_created_by_role_id' => $variable_array['logged_in_user_details']['team_id'],
					'ticket_created_by_role' => $variable_array['logged_in_user_details']['role'],
				);
			}

			return $this->db->where($where_condition)->order_by('ticket_id','DESC')->get('raise_a_ticket')->result_array();
		}

		function get_all_assigned_tickets($variable_array) {
			$where_condition = [];
			if ($variable_array['type'] == 'fs_team') {
				$where_condition = array(
					'ticket_assigned_to_role_id' => $variable_array['logged_in_user_details']['team_id'],
					'ticket_assigned_to_role' => $variable_array['logged_in_user_details']['role'],
				);
			}

			return $this->db->where($where_condition)->order_by('ticket_id','DESC')->get('raise_a_ticket')->result_array();
		}

		function get_ticket_details($variable_array) {
			$data['ticket_details'] = $this->db->where('ticket_id',$variable_array['ticket_id'])->get('raise_a_ticket')->row_array();
			$data['team_details'] = $variable_array['logged_in_user_details'];
			$data['created_by_details'] = $this->db->where('team_id',$data['ticket_details']['ticket_created_by_role_id'])->get('team_employee')->row_array();
			if ($data['ticket_details']['notification_status_for_assigned_to'] != 1) {
				if ($variable_array['type'] == 'fs_team') {
					if ($variable_array['logged_in_user_details']['team_id'] == $data['ticket_details']['ticket_assigned_to_role_id'] && $variable_array['logged_in_user_details']['role'] == $data['ticket_details']['ticket_assigned_to_role']) {
						$where_condition = array(
							'ticket_id' => $this->input->post('ticket_id')
						);

						$userdata = array(
							'notification_status_for_assigned_to' => 1
						);

						$this->db->where($where_condition)->update('raise_a_ticket',$userdata);
					}
				}
			}
			return $data;
		}

		function get_single_ticket_all_comments($variable_array) {
			$where_condition = array(
				'ticket_id' => $this->input->post('ticket_id')
			);

			$data['ticket_raised_by'] = $this->db->select('ticket_created_by_role_id, ticket_created_by_role')->where($where_condition)->get('raise_a_ticket')->row_array();
			$data['ticket_comments'] = $this->db->where($where_condition)->order_by('raised_ticket_comments_id','ASC')->get('raised_ticket_comments')->result_array();
			$data['raised_by_details'] = $variable_array['logged_in_user_details'];
			return $data;
		}

		function add_new_ticket_comment($variable_array,$ticket_status = '') {
			$add_data = array(
				'ticket_id' => $this->input->post('ticket_id')
			);

			if ($variable_array['type'] == 'fs_team') {
				$add_data['ticket_comment_by_id'] = $variable_array['logged_in_user_details']['team_id'];
				$add_data['ticket_comment_by_role'] = $variable_array['logged_in_user_details']['role'];
			}

			if ($ticket_status == '') {
				$add_data['ticket_comment'] = $this->input->post('note_message');
			} else {
				$get_ticket_status_list = json_decode(file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json'),true);
				$ticket_status_type = '';
				foreach ($get_ticket_status_list as $key => $value) {
					if ($ticket_status == $value['id']) {
						$ticket_status_type = $value['status'];
					}
				}
				// $logged_in_user_details['first_name'].' '.$logged_in_user_details['last_name'].' (admin)
				$add_data['ticket_comment'] = 'Changed ticket status to "'.$ticket_status_type.'"';
			}
			
			if ($this->db->insert('raised_ticket_comments',$add_data)) {
				$ticket_comment_id = $this->db->insert_id();
				return array('status'=>'1','message'=>'New ticket has been raised successfully.','comment_id'=>$ticket_comment_id);
			} else {
				return array('status'=>'0','message'=>'Something went wrong while raising the ticket. Please try again');
			}
		}

		function get_ticket_single_comment($variable_array) {
			$where_condition = array(
				'raised_ticket_comments_id' => $this->input->post('comment_id'),
				'ticket_id' => $this->input->post('ticket_id')
			);

			$where_condition_2 = array(
				'ticket_id' => $this->input->post('ticket_id')
			);

			$data['status'] = 1;
			$data['ticket_comment'] = $this->db->where($where_condition)->get('raised_ticket_comments')->row_array();
			$data['ticket_count'] = $this->db->select('COUNT(*) AS count')->where($where_condition_2)->get('raised_ticket_comments')->row_array();
			if ($variable_array['type'] == 'fs_team') {
				$data['comment_added_by'] = $this->teamModel->get_team_details($data['ticket_comment']['ticket_comment_by_id']);
			}
			return $data;
		}

		function update_ticket_status($variable_array) {
			$where_condition = array(
				'ticket_id' => $this->input->post('ticket_id')
			);

			$userdata = array(
				'ticket_status' => $this->input->post('change_ticket_status')
			);

			if ($this->input->post('change_ticket_status') == 3) {
				$userdata['notification_status_for_assigned_to'] = 2;
			}

			if ($this->db->where($where_condition)->update('raise_a_ticket',$userdata)) {
				$ticket_comment = $this->add_new_ticket_comment($variable_array,$this->input->post('change_ticket_status'));
				$log_data = $this->db->where($where_condition)->get('raise_a_ticket')->row_array();
			
				$log_data_array = array(
					'ticket_id' => $this->input->post('ticket_id'),
					'ticket_subject' => $log_data['ticket_subject'],
					'ticket_description' => $log_data['ticket_description'],
					'ticket_priority' => $log_data['ticket_priority'],
					'ticket_classifications' => $log_data['ticket_classifications'],
					'ticket_attached_file' => $log_data['ticket_attached_file']
				);

				if ($variable_array['type'] == 'fs_team') {
					$log_data_array['ticket_created_by_role_id'] = $log_data_array['ticket_updated_by_role_id'] = $variable_array['logged_in_user_details']['team_id'];
					$log_data_array['ticket_created_by_role'] = $log_data_array['ticket_updated_by_role'] = $variable_array['logged_in_user_details']['role'];
				}

				$this->db->insert('raise_a_ticket_log',$log_data_array);

				return array('status'=>'1','message'=>'Status updated successfully.','comment_id'=>$ticket_comment['comment_id']);
			} else {
				return array('status'=>'0','message'=>'Something went wrong while updating the status.');
			}
		}
	}	
?>