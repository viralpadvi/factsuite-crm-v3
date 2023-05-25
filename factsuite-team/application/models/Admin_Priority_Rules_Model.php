<?php

	class Admin_Priority_Rules_Model extends CI_Model {

		function add_new_rule() {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			$add_data = array(
				'show_cases_rule_client_id' => $this->input->post('client_name'),
				'show_cases_rule_criteria' => $this->input->post('rule_cirteria')
			);

			$criteria_rules = [];
			if ($this->input->post('rule_cirteria') == 1) {
				$criteria_rules = array(
					'remaining_days_type' => $this->input->post('remaining_days_type'),
					'remaining_days_value' => $this->input->post('remaining_days_value')
				);
			} else if($this->input->post('rule_cirteria') == 2) {
				$criteria_rules = array(
					'priority_type' => $this->input->post('priority_type')
				);
			}

			$add_data['show_cases_rules'] = json_encode($criteria_rules);
			
			if ($this->db->insert('show_cases_rule',$add_data)) {
				$show_cases_rule_id = $this->db->insert_id();
				
				$add_data['show_cases_rule_id'] = $show_cases_rule_id;
				$add_data['show_cases_rule_updated_by_id'] = $logged_in_user_details['team_id'];
				$add_data['show_cases_rule_updated_by_role'] = $logged_in_user_details['role'];
				
				$this->db->insert('show_cases_rule_log',$add_data);

				return array('status'=>'1','message'=>'New rule has been added successfully.','rule_id'=>$show_cases_rule_id);
			} else {
				return array('status'=>'0','message'=>'Something went wrong while adding the rule. Please try again');
			}
		}

		function get_all_tickets() {
			return $this->db->order_by('show_cases_rule_id','DESC')->get('show_cases_rule')->result_array();
		}

		function get_ticket_details($ticket_id) {
			$data['ticket_details'] = $this->db->where('ticket_id',$ticket_id)->get('raise_a_ticket')->row_array();
			if ($data['ticket_details']['ticket_created_by_role'] == 'client') {
				
			} else {
				$data['team_details'] = $this->teamModel->get_team_details($data['ticket_details']['ticket_created_by_role_id']);
			}
			return $data;
		}

		function change_rule_status() {
			$where_condition = array(
				'show_cases_rule_id' => $this->input->post('id')
			);

			$userdata = array(
				'show_cases_rule_status' => $this->input->post('changed_status')
			);

			if ($this->db->where($where_condition)->update('show_cases_rule',$userdata)) {
				$log_data = $this->db->where($where_condition)->get('show_cases_rule')->row_array();
			
				$admin_info = $this->session->userdata('logged-in-admin');
				$log_data_array = array(
					'show_cases_rule_id' => $this->input->post('id'),
					'show_cases_rule_client_id' => $log_data['show_cases_rule_client_id'],
					'show_cases_rule_criteria' => $log_data['show_cases_rule_criteria'],
					'show_cases_rules' => $log_data['show_cases_rules'],
					'show_cases_rule_status' => $log_data['show_cases_rule_status'],
					'show_cases_rule_updated_by_id' => $admin_info['team_id'],
					'show_cases_rule_updated_by_role' => $admin_info['role']
				);
				$this->db->insert('show_cases_rule_log',$log_data_array);

				return array('status'=>'1','message'=>'Status updated successfully.');
			} else {
				return array('status'=>'0','message'=>'Something went wrong while updating the status.');
			}
		}

		function get_single_rule_details() {
			$where_condition = array(
				'show_cases_rule_id' => $this->input->post('show_cases_rule_id')
			);

			return $this->db->where($where_condition)->get('show_cases_rule')->row_array();
		}

		function update_rule() {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			$update_data = array(
				'show_cases_rule_client_id' => $this->input->post('client_name'),
				'show_cases_rule_criteria' => $this->input->post('rule_cirteria')
			);

			$criteria_rules = [];
			if ($this->input->post('rule_cirteria') == 1) {
				$criteria_rules = array(
					'remaining_days_type' => $this->input->post('remaining_days_type'),
					'remaining_days_value' => $this->input->post('remaining_days_value')
				);
			} else if($this->input->post('rule_cirteria') == 2) {
				$criteria_rules = array(
					'priority_type' => $this->input->post('priority_type')
				);
			}

			$update_data['show_cases_rules'] = json_encode($criteria_rules);
			
			if ($this->db->where('show_cases_rule_id',$this->input->post('show_cases_rule_id'))->update('show_cases_rule',$update_data)) {				
				$update_data['show_cases_rule_id'] = $this->input->post('show_cases_rule_id');
				$update_data['show_cases_rule_updated_by_id'] = $logged_in_user_details['team_id'];
				$update_data['show_cases_rule_updated_by_role'] = $logged_in_user_details['role'];
				$update_data['show_cases_rule_status'] = 2;

				$this->db->insert('show_cases_rule_log',$update_data);

				return array('status'=>'1','message'=>'Rule has been updated successfully.');
			} else {
				return array('status'=>'0','message'=>'Something went wrong while updating the rule. Please try again');
			}
		}
	}	
?>