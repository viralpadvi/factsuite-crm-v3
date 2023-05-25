<?php

	class Common_User_Filled_Details_Component_Error_Model extends CI_Model {

	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url');   
	  $this->load->model('adminViewAllCaseModel');   

	}
		function raise_new_error($logged_in_user_details,$store_error_files) {
			$get_db_component_details = $this->db->select('component_name')->where('component_id',$this->input->post('component_id'))->get('components')->row_array();
			$add_data = array(
				'error_subject' => $this->input->post('error_subject'),
				'error_description' => $this->input->post('error_description'),
				'candidate_id' => $this->input->post('candidate_id'),
				'component_name' => $get_db_component_details['component_name'],
				'component_id' => $this->input->post('component_id'),
				'component_index' => $this->input->post('component_index'),
				'error_generated_by_id' => $logged_in_user_details['team_id'],
				'error_generated_by_role' => $logged_in_user_details['role']
			);

			if ($this->input->post('error_priority') != '') {
				$add_data['error_priority'] = $this->input->post('error_priority');
			}

			if ($this->input->post('error_classifications') != '') {
				$add_data['error_classifications'] = $this->input->post('error_classifications');
			}

			if ($store_error_files != '' && $store_error_files != 'no-file') {
				$add_data['error_attached_file'] = $store_error_files;
			}

			if($this->input->post('user_component_form_filled_id') != '') {
				$add_data['user_component_form_filled_id'] = $this->input->post('user_component_form_filled_id');
			}

			if ($this->db->insert('user_filled_details_component_error',$add_data)) {
				$error_id = $this->db->insert_id();

				$log_data = array(
					'user_filled_details_component_error_id' => $error_id,
					'error_subject' => $this->input->post('error_subject'),
					'error_description' => $this->input->post('error_description'),
					'candidate_id' => $this->input->post('candidate_id'),
					'component_name' => $get_db_component_details['component_name'],
					'component_id' => $this->input->post('component_id'),
					'component_index' => $this->input->post('component_index'),
					'error_generated_by_id' => $logged_in_user_details['team_id'],
					'error_generated_by_role' => $logged_in_user_details['role']
				);

				if ($this->input->post('error_priority') != '') {
					$log_data['error_priority'] = $this->input->post('error_priority');
				}

				if ($this->input->post('error_classifications') != '') {
					$log_data['error_classifications'] = $this->input->post('error_classifications');
				}

				if ($store_error_files != '' && $store_error_files != 'no-file') {
					$log_data['error_attached_file'] = $store_error_files;
				}

				if($this->input->post('user_component_form_filled_id') != '') {
					$log_data['user_component_form_filled_id'] = $this->input->post('user_component_form_filled_id');
				}

				$this->db->insert('user_filled_details_component_error_log',$log_data);

				return array('status'=>'1','message'=>'New error has been raised successfully.');
			} else {
				return array('status'=>'0','message'=>'Something went wrong while raising the error. Please try again');
			}
		}

		function get_all_error_log($logged_in_user_details) {
			$where_condition = array(
				// 'error_generated_by_id' => $logged_in_user_details['team_id'],
				// 'error_generated_by_role' => $logged_in_user_details['role'],
				'candidate_id' => $this->input->post('candidate_id'),
				'component_id' => $this->input->post('component_id'),
				'component_index' => $this->input->post('component_index')
				// 'user_component_form_filled_id' => $this->input->post('user_component_form_filled_id')
			);

			return $this->db->where($where_condition)->order_by('user_filled_details_component_error_id','DESC')->get('user_filled_details_component_error')->result_array();
		}

		function get_single_error_details($logged_in_user_details,$user_filled_details_component_error_id) {
			$data['error_details'] = $this->db->where('user_filled_details_component_error_id',$user_filled_details_component_error_id)->get('user_filled_details_component_error')->row_array();
			$data['team_details'] = $logged_in_user_details;
			return $data;
		}

		function get_single_error_all_comments($logged_in_user_details) {
			$where_condition = array(
				'user_filled_details_component_error_id' => $this->input->post('user_filled_details_component_error_id')
			);

			$data['error_raised_by'] = $this->db->select('error_generated_by_id, error_generated_by_role')->where($where_condition)->get('user_filled_details_component_error')->row_array();
			$data['error_comments'] = $this->db->where($where_condition)->order_by('user_filled_details_component_error_comment_id','ASC')->get('user_filled_details_component_error_comment')->result_array();
			$data['raised_by_details'] = $logged_in_user_details;
			return $data;
		}

		function add_new_error_comment($logged_in_user_details,$error_status = '') {
			$add_data = array(
				'user_filled_details_component_error_id' => $this->input->post('user_filled_details_component_error_id'),
				'user_filled_details_component_error_commented_by_id' => $logged_in_user_details['team_id'],
				'user_filled_details_component_error_commented_by_role' => $logged_in_user_details['role']
			);

			if ($error_status == '') {
				$add_data['user_filled_details_component_error_comment'] = $this->input->post('note_message');
			} else {
				$get_ticket_status_list = json_decode(file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json'),true);
				$error_status_type = '';
				foreach ($get_ticket_status_list as $key => $value) {
					if ($error_status == $value['id']) {
						$error_status_type = $value['status'];
					}
				}
				// $logged_in_user_details['first_name'].' '.$logged_in_user_details['last_name'].' (admin)
				$add_data['user_filled_details_component_error_comment'] = 'Changed error status to "'.$error_status_type.'"';
			}
			
			if ($this->db->insert('user_filled_details_component_error_comment',$add_data)) {
				$error_comment_id = $this->db->insert_id();
				return array('status'=>'1','message'=>'New error has been raised successfully.','comment_id'=>$error_comment_id);
			} else {
				return array('status'=>'0','message'=>'Something went wrong while raising the error. Please try again');
			}
		}

		function get_error_single_comment() {
			$where_condition = array(
				'user_filled_details_component_error_comment_id' => $this->input->post('comment_id'),
				'user_filled_details_component_error_id' => $this->input->post('user_filled_details_component_error_id')
			);

			$where_condition_2 = array(
				'user_filled_details_component_error_id' => $this->input->post('user_filled_details_component_error_id')
			);

			$data['status'] = 1;
			$data['error_comment'] = $this->db->where($where_condition)->get('user_filled_details_component_error_comment')->row_array();
			$data['error_count'] = $this->db->select('COUNT(*) AS count')->where($where_condition_2)->get('user_filled_details_component_error_comment')->row_array();
			$data['comment_added_by'] = $this->teamModel->get_team_details($data['error_comment']['user_filled_details_component_error_commented_by_id']);
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




		function component_error_log_details(){
			$result = $this->db->select("*")->from('user_filled_details_component_error')->join('candidate','user_filled_details_component_error.candidate_id = candidate.candidate_id','left')->join('components','user_filled_details_component_error.component_id = components.component_id','left')->join('team_employee','user_filled_details_component_error.error_generated_by_id = team_employee.team_id','left')->get()->result_array();
 
			$error_log_array = array();
			foreach ($result as $key => $value) { 
				$error_log = $this->db->where('user_filled_details_component_error_id',$value['user_filled_details_component_error_id'])->select('*')->from('user_filled_details_component_error_comment')->join('team_employee','user_filled_details_component_error_comment.user_filled_details_component_error_commented_by_id = team_employee.team_id','left')->get()->result_array();
				$results ='';
				if ($value['component_id'] =='7') { 
	 			$results = $this->db->where_in('education_type_id',$value['user_component_form_filled_id'])->get('education_type')->row_array();
		 		}else if($value['component_id'] =='3'){ 
		 			$results = $this->db->where_in('document_type_id',$value['user_component_form_filled_id'])->get('document_type')->row_array();
		 		}
				$client = $this->getClientData($value['client_id']); 
				 if (count($error_log) > 0) {
				  
					foreach ($error_log as $error_key => $val) {
						$row['component_name'] = $value[$this->config->item('show_component_name')];
						$row['component_id'] = $value['component_id'];
						$row['candidate_id'] = $value['candidate_id'];
						$row['candidate_name'] = $value['first_name'].' '.$value['last_name'];
						$row['client_name'] = isset($client['client_name'])?$client['client_name']:'';
						$row['client_id'] = isset($value['client_id'])?$value['client_id']:'';
						$row['component_error_comment'] = $val['user_filled_details_component_error_comment'];
						$row['error_description'] = $value['error_description'];
						$row['added_by_name'] = $val['first_name'].' '.$val['last_name'];
						$row['role'] = $val['user_filled_details_component_error_commented_by_role'];
						$row['error_added_by_name'] = $value['first_name'].' '.$value['last_name'];
						$row['error_role'] = $value['error_generated_by_role'];
						$row['created_date'] = date('d-m-Y',strtotime($val['user_filled_details_component_error_comment_created_date']));
						$row['error_created_date'] = date('d-m-Y',strtotime($value['error_created_date']));

						$type_of_val ='';
			 			if ($results !='' && $value['component_id'] =='7') {
			 				$type_of_val = $results['education_type_name'];
			 			}else if ($results !='' && $value['component_id'] =='3') {
			 				$type_of_val = $results['document_type_name'];
			 			}
			 			$row['value_type'] = $type_of_val;
			 			
			 			array_push($error_log_array,$row);
						
					}
				}else{
					$row['component_name'] = $value[$this->config->item('show_component_name')];
						$row['component_id'] = $value['component_id'];
						$row['candidate_id'] = $value['candidate_id'];
						$row['candidate_name'] = $value['first_name'].' '.$value['last_name'];
						$row['client_name'] = isset($client['client_name'])?$client['client_name']:'';
						$row['client_id'] = isset($value['client_id'])?$value['client_id']:'';
						$row['component_error_comment'] = '';
						$row['error_description'] = $value['error_description'];
						$row['error_added_by_name'] = $value['first_name'].' '.$value['last_name'];
						$row['error_role'] = $value['error_generated_by_role'];
						$row['added_by_name'] = ''; 
						$row['role'] = '';
						$row['created_date'] = '';
						$row['error_created_date'] = date('d-m-Y',strtotime($value['error_created_date']));

						$type_of_val ='';
			 			if ($results !='' && $value['component_id'] =='7') {
			 				$type_of_val = $results['education_type_name'];
			 			}else if ($results !='' && $value['component_id'] =='3') {
			 				$type_of_val = $results['document_type_name'];
			 			}
			 			$row['value_type'] = $type_of_val;
			 			
			 			array_push($error_log_array,$row);
				}
			}
 
			return $error_log_array;
		}

		function getClientData($clientId){
		return $this->db->select('client_id,client_name,high_priority_days,medium_priority_days,low_priority_days')->from('tbl_client')->where('client_id',$clientId)->get()->row_array();
	}
	}	
?>