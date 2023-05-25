<?php

	class Finance_Ticketing_System_Model extends CI_Model {

		function raise_new_ticket($store_ticket_files) {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
			$add_data = array(
				'ticket_created_by_role_id' => $logged_in_user_details['team_id'],
				'ticket_created_by_role' => $logged_in_user_details['role'],
				'ticket_subject' => $this->input->post('ticket_subject'),
				'ticket_description' => $this->input->post('ticket_description')
			);

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
				$admin_info = $this->session->userdata('logged-in-admin');

				$log_data = array(
					'ticket_id' => $ticket_id,
					'ticket_created_by_role_id' => $logged_in_user_details['team_id'],
					'ticket_created_by_role' => $logged_in_user_details['role'],
					'ticket_subject' => $this->input->post('ticket_subject'),
					'ticket_description' => $this->input->post('ticket_description'),
					'ticket_updated_by_role_id' => $logged_in_user_details['team_id'],
					'ticket_updated_by_role' => $logged_in_user_details['role']
				);

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
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
			$where_condition = array(
				'ticket_created_by_role_id' => $logged_in_user_details['team_id'],
				'ticket_created_by_role' => $logged_in_user_details['role']
			);

			return $this->db->where($where_condition)->order_by('ticket_id','DESC')->get('raise_a_ticket')->result_array();
		}

		function get_ticket_details($ticket_id) {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
			$data['ticket_details'] = $this->db->where('ticket_id',$ticket_id)->get('raise_a_ticket')->row_array();
			$data['team_details'] = $logged_in_user_details;
			return $data;
		}

		function get_single_ticket_all_comments() {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
			$where_condition = array(
				'ticket_id' => $this->input->post('ticket_id')
			);

			$data['ticket_raised_by'] = $this->db->select('ticket_created_by_role_id, ticket_created_by_role')->where($where_condition)->get('raise_a_ticket')->row_array();
			$data['ticket_comments'] = $this->db->where($where_condition)->order_by('raised_ticket_comments_id','ASC')->get('raised_ticket_comments')->result_array();
			$data['raised_by_details'] = $logged_in_user_details;
			return $data;
		}

		function add_new_ticket_comment($ticket_status = '') {
			$logged_in_user_details = $this->session->userdata('logged-in-finance');
			$add_data = array(
				'ticket_id' => $this->input->post('ticket_id'),
				'ticket_comment_by_id' => $logged_in_user_details['team_id'],
				'ticket_comment_by_role' => $logged_in_user_details['role']
			);

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

		function get_ticket_single_comment() {
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
			$data['comment_added_by'] = $this->teamModel->get_team_details($data['ticket_comment']['ticket_comment_by_id']);
			return $data;
		}

		function update_ticket_status() {
			$where_condition = array(
				'ticket_id' => $this->input->post('ticket_id')
			);

			$userdata = array(
				'ticket_status' => $this->input->post('change_ticket_status')
			);

			if ($this->db->where($where_condition)->update('raise_a_ticket',$userdata)) {
				$ticket_comment = $this->add_new_ticket_comment($this->input->post('change_ticket_status'));
				$log_data = $this->db->where($where_condition)->get('raise_a_ticket')->row_array();
			
				$admin_info = $this->session->userdata('logged-in-admin');
				$log_data_array = array(
					'ticket_id' => $this->input->post('ticket_id'),
					'ticket_created_by_role_id' => $admin_info['team_id'],
					'ticket_created_by_role' => $admin_info['role'],
					'ticket_subject' => $log_data['ticket_subject'],
					'ticket_description' => $log_data['ticket_description'],
					'ticket_updated_by_role_id' => $admin_info['team_id'],
					'ticket_updated_by_role' => $admin_info['role'],
					'ticket_priority' => $log_data['ticket_priority'],
					'ticket_classifications' => $log_data['ticket_classifications'],
					'ticket_attached_file' => $log_data['ticket_attached_file']
				);
				$this->db->insert('raise_a_ticket_log',$log_data_array);

				return array('status'=>'1','message'=>'Status updated successfully.','comment_id'=>$ticket_comment['comment_id']);
			} else {
				return array('status'=>'0','message'=>'Something went wrong while updating the status.');
			}
		}
	}	
?>