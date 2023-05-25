<?php
/**
 * 
 */
class TeamModel extends CI_Model
{
	
	function get_team_details($team_id=''){
		$result ='';
		if ($team_id !='') { 
			$result = $this->db->where('team_id',$team_id)->get('team_employee')->row_array();
		}else{
			$result = $this->db->where('is_Active',1)->where('role','csm')->get('team_employee')->result_array();
		}
		return $result;
	}

	function get_team_list() {
		return $this->db->where('is_Active',1)->get('team_employee')->result_array();
	}

	function verify_and_reset_password(){
		$update_password = array(
			'team_employee_password'=>MD5($this->input->post('new_password'))
		);

		if ($this->db->where('team_id',$this->input->post('team_id'))->update('team_employee',$update_password)) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failled');
		}
	}
	
	function get_view_team($team_id=''){
		$result ='';
		if ($team_id !='') { 
			$result = $this->db->where('team_id',$team_id)->get('team_employee')->row_array();
		}else{
			$result = $this->db->where('is_Active',1)->order_by('team_id', 'desc')->get('team_employee')->result_array();
		}
		return $result;
	}

	function get_role_list() {
		$role_id = $this->input->post('role_id');
		if($role_id != '' && count($role_id) > 0) {
			$this->db->where_in('role',$role_id);
		}

		return $this->db->where('is_Active',1)->get('team_employee')->result_array();
	}

	function check_selected_team_member_role($role_id,$team_member_id) {
		$where_condition = array(
			'is_Active' => 1,
			'role' => $role_id,
			'team_id' => $team_member_id
		);
		return $this->db->where($where_condition)->get('team_employee')->row_array();		
	}

	function bulk_assign_cases_to_team_member() {
		$check_team_member = $this->check_selected_team_member_role($this->input->post('role_id'),$this->input->post('team_member_id'));
		if ($check_team_member != '') {
			$update_data = [];
			if ($this->input->post('role_id') == 'inputqc') {
				$update_data = array(
					'assigned_inputqc_id' => $this->input->post('team_member_id')
				);
			} else if($this->input->post('role_id') == 'outputqc') {
				$update_data = array(
					'assigned_outputqc_id' => $this->input->post('team_member_id')
				);
			}

			if ($this->db->where_in('candidate_id',$this->input->post('candidate_id_list'))->update('candidate',$update_data)) {
				return array('status'=>'1','message'=>'Assigned Successfully.');	
			} else {
				return array('status'=>'0','message'=>'Something went wrong.');	
			}
		} else {
			return array('status'=>'2','message'=>'Wrong Team Member selected');
		}
	}

	function duplicate_contact(){
		$result = $this->db->where('contact_no',$this->input->post('contact'))->get('team_employee')->num_rows();
		if ($result > 0) {
			return array('status'=>'0','msg'=>'failled');
		} else {
			return array('status'=>'1','msg'=>'success');
		}
	}
	function duplicate_email(){
		$result = $this->db->where('team_employee_email',$this->input->post('email'))->get('team_employee')->num_rows();
		if ($result > 0) {
			return array('status'=>'0','msg'=>'failled');
		}else{
		return array('status'=>'1','msg'=>'success');
		}
	}


	function get_team_all_details($team_id=''){
		$result = $this->get_view_team($team_id);
		// print_r($result);
		$team_data = array();
		if ($team_id !='') {
			$row['team_id'] = $result['team_id'];
				$row['first_name'] = $result['first_name'];
				$row['last_name'] = $result['last_name']; 
				$row['team_employee_email'] = $result['team_employee_email'];
				$row['contact_no'] = $result['contact_no'];
				$row['user_name'] = $result['user_name'];
				$row['team_employee_password'] = $result['team_employee_password'];
				$row['role'] = $result['role'];
				$row['skills'] = $result['skills'];
				if ($result['reporting_manager'] !='0' && $result['reporting_manager'] !='') {
					$manage = $this->db->where('team_id',$result['reporting_manager'])->select('team_employee.first_name')->from('team_employee')->get('')->row_array();
				}
				$row['reporting_manager'] = isset($manage['first_name'])?$manage['first_name']:'none';
				array_push($team_data, $row); 
		}else{
			foreach ($result as $key => $value) {
				$row['team_id'] = $value['team_id'];
				$row['first_name'] = $value['first_name'];
				$row['last_name'] = $value['last_name']; 
				$row['team_employee_email'] = $value['team_employee_email'];
				$row['contact_no'] = $value['contact_no'];
				$row['user_name'] = $value['user_name'];
				$row['team_employee_password'] = $value['team_employee_password'];
				$row['role'] = $value['role'];
				$row['skills'] = $value['skills'];
				if ($value['reporting_manager'] !='0' && $value['reporting_manager'] !='') {
					$manage = $this->db->where('team_id',$value['reporting_manager'])->select('team_employee.first_name')->from('team_employee')->get('')->row_array();
				}
				$row['reporting_manager'] = isset($manage['first_name'])?$manage['first_name']:'none';
				array_push($team_data, $row);
			}
		}
		return $team_data;
	}

	function insert_team(){
		$this->load->helper('string');
		$user = $this->session->userdata('logged-in-admin');
		$password = random_string('alnum', 8);
		$team_data = array(
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'), 
			'team_employee_email'=>$this->input->post('email'),
			'contact_no'=>$this->input->post('contact_no'),
			'user_name'=>$this->input->post('user_name'),
			'team_employee_password'=>MD5($password),
			'role'=>$this->input->post('role'), 
			'reporting_manager'=>$this->input->post('manager'),
		); 

		if ($this->input->post('skill')!==null) {
			$team_data['skills']=implode(',', $this->input->post('skill'));
		}
		if ($this->db->insert('team_employee',$team_data)) {
			$insert_id = $this->db->insert_id();
				
				$email_id = strtolower($this->input->post('email'));
				// Send To User Starts
				$email_subject = 'Credentials';
/*
				$client_email_message = '<html><body>';
				$client_email_message .= 'Hello : '.$this->input->post('first_name').'<br>';
				$client_email_message .= 'Your account has been created with factsuite team : <br>';
				$client_email_message .= 'Login using below credentials : <br>';
				$client_email_message .= 'Email ID : '.$email_id.'<br>';
				$client_email_message .= 'Password : '.$password.'<br>';
				$client_email_message .= 'Thank You,<br>';
				$client_email_message .= 'Team Factsuite';
				$client_email_message .= '</html></body>';*/
				$teamMail = '';
				// $teamMail .='<!DOCTYPE html>';
				$teamMail .='<html> ';
				$teamMail .='<head>';
				$teamMail .='<style>';
				$teamMail .='table {';
				$teamMail .='  font-family: arial, sans-serif;';
				$teamMail .='  border-collapse: collapse;';
				$teamMail .='  width: 100%;';
				$teamMail .='}';

				$teamMail .='td, th {';
				$teamMail .='  border: 1px solid #dddddd;';
				$teamMail .='  text-align: left;';
				$teamMail .='  padding: 8px;';
				$teamMail .='}';

				$teamMail .='tr:nth-child(even) {';
				$teamMail .='  background-color: #dddddd;';
				$teamMail .='}';
				$teamMail .='</style>';
				$teamMail .='</head>';
				$teamMail .='<body> ';
				$teamMail .='<p>Dear '.$this->input->post('first_name').' '.$this->input->post('last_name').',</p>';
				$teamMail .='<p>Greetings from Factsuite!!</p>';
				$teamMail .='<p>Please find your Login Credentials to access the Factsuite CRM application, mentioned below- </p>';
				 
				$teamMail .='<table>';
				$teamMail .='<th>CRM Link</th>';
				$teamMail .='<th>UserName</th>';
				$teamMail .='<th>Password</th>';
				$teamMail .='<tr>';
				$teamMail .='<td>'.$this->config->item('main_url').'</td>';
				$teamMail .='<td>'.$email_id.'</td>';
				$teamMail .='<td>'.$password.'</td>';
				$teamMail .='<tr>';
				$teamMail .='</table>';
				 
				$teamMail .='<p><b>Yours sincerely,<br>';
				$teamMail .='Team FactSuite</b></p>';
				$teamMail .='</body>';
				$teamMail .='</html>';

 
				$send_email_to_user = $this->emailModel->send_mail($email_id,$email_subject,$teamMail);
				// echo "<br><br>".$send_email_to_user;
			$team_log_data = array(
				'team_id'=>$insert_id,
				'first_name'=>$this->input->post('first_name'),
				'last_name'=>$this->input->post('last_name'), 
				'team_employee_email'=>$this->input->post('email'),
				'contact_no'=>$this->input->post('contact_no'),
				'user_name'=>$this->input->post('user_name'),
				'team_employee_password'=>MD5($this->input->post('password')),
				'role'=>$this->input->post('role'), 
				'reporting_manager'=>$this->input->post('manager'),
				'team_added_updated_by'=>$user['team_id'], 
			);
			if ($this->input->post('skill')!==null) {
			$team_log_data['skills']=implode(',', $this->input->post('skill'));
			}
			$this->db->insert('team_employee_log',$team_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_team(){
		$user = $this->session->userdata('logged-in-admin');
		$team_data = array( 
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'), 
			'team_employee_email'=>$this->input->post('email'),
			'contact_no'=>$this->input->post('contact_no'),
			'user_name'=>$this->input->post('user_name'),
			// 'team_employee_password'=>MD5($this->input->post('password')),
			'role'=>$this->input->post('role'), 
			'reporting_manager'=>$this->input->post('manager'),
		);
		if ($this->input->post('skill')!==null) {
			$team_data['skills']=implode(',', $this->input->post('skill'));
		}
		$this->db->where('team_id',$this->input->post('team_id'));
		if ($this->db->update('team_employee',$team_data)) {
			$team_log_data = array(
				'team_id'=>$this->input->post('team_id'), 
				'last_name'=>$this->input->post('last_name'),
				'first_name'=>$this->input->post('first_name'),
				'team_employee_email'=>$this->input->post('email'),
				'contact_no'=>$this->input->post('contact_no'),
				'user_name'=>$this->input->post('user_name'),
				// 'team_employee_password'=>MD5($this->input->post('password')),
				'role'=>$this->input->post('role'), 
				'reporting_manager'=>$this->input->post('manager'),
				'team_added_updated_by'=>$user['team_id'], 
				'action_status'=>2,
			);
			if ($this->input->post('skill')!==null) {
			$team_log_data['skills']=implode(',', $this->input->post('skill'));
			}
			$this->db->insert('team_employee_log',$team_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function remove_team(){
			$user = $this->session->userdata('logged-in-admin');
		$team_data = array(  
			'is_active'=>0,
		);
		$this->db->where('team_id',$this->input->post('team_id'));
		if ($this->db->update('team_employee',$team_data)) {
			$result = $this->get_team_details($this->input->post('team_id')); 
			$team_log_data = array(
				'team_id'=>$result['team_id'], 
				'last_name'=>$result['last_name'],
				'first_name'=>$result['first_name'],
				'team_employee_email'=>$result['team_employee_email'],
				'contact_no'=>$result['contact_no'],
				'user_name'=>$result['user_name'],
				'team_employee_password'=>$result['team_employee_password'],
				'role'=>$result['role'],
				'skills'=>$result['skills'],
				'reporting_manager'=>$result['reporting_manager'],  
				'action_status'=>0,
			);
			$this->db->insert('team_employee_log',$team_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


}