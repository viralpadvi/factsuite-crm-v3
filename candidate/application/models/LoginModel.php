<?php
/**
 * 
 */
class LoginModel extends CI_Model {
	
	function valid_login_auth() {
		$where_condition = array(
			// 'candidate.country_code' => $this->input->post('country_code'),
			'T2.loginId' => $this->input->post('contact_no')
		);
		$query = $this->db->select('T2.first_name, T2.last_name, T2.loginId, T2.candidate_id, T2.otp_password, T2.is_submitted, T2.phone_number, T2.email_id, T1.client_name')->join('tbl_client AS T1','T2.client_id = T1.client_id')->where($where_condition)->get('candidate AS T2');
	 //    $this->db->where('candidate.phone_number', $this->input->post('contact_no'));
	 //    $this->db->or_where('candidate.loginId', $this->input->post('contact_no'));
		// $this->db->limit(1);
		// $this->db->select("candidate.*,tbl_client.client_name")->from('candidate');
		// $this->db->join('tbl_client','candidate.client_id = tbl_client.client_id');
	 //    $query = $this->db->get();
				 
	   	if($query->num_rows() >= 1) {
	   		$users = $query->row_array();
	   		if ($users['is_submitted'] != 1) {
	   			$this->session->set_userdata('phone_number',$users['phone_number']);
	   			$this->session->set_userdata('login_id',$this->input->post('contact_no'));
	   			$this->session->set_userdata('user_otps',$users);
	   			return array('status'=>'1');
	   		} else {
	   			return array('status'=>'2','message'=>'Datas already Submitted');
	   		}
	   	} else {
	   	  return array('status'=>'0','message'=>'invalid_login');
	   	}	
	}

	function checkedOtp() {
		$token = $this->input->post('token');
		$otps = $this->session->userdata('user_otps');
		$count = 0;
		$candidate_id = '';
		if($otps['otp_password'] == $token) {
			if ($otps['is_submitted'] == 1) {
				return array('status'=>'2','message'=>'Form already filled');
				die();
			} else {
				$count = 1;
				$candidate_id = $otps['candidate_id'];
			}
		}
		// foreach ($otps as $key => $value) {
		// 	if ($value['otp_password'] == $token) {
		// 		if ($value['is_submitted'] == 1) {
		// 			return array('status'=>'2','message'=>'Form already filled');
		// 			die();
		// 		} else {
		// 			$count = 1;
		// 			$candidate_id = $value['candidate_id'];
		// 		}
		// 		break;
		// 	}
		// }
		if($count == 1) {
			$query = $this->db->select("candidate.*,tbl_client.client_name")->where('candidate.candidate_id', $candidate_id)->join('tbl_client','candidate.client_id = tbl_client.client_id')->get('candidate')->row_array();
			$this->session->set_userdata('logged-in-candidate',$query);
			return array('status'=>'1','message'=>'success');
		} else {
			return array('status'=>'0','message'=>'fail');
		}
	}

	function login_logs($userLog){
	 	$userdata = array(
	 		'user_id'=>$userLog['candidate_id'],
	 		'userName'=>$userLog['first_name'].' '.$userLog['first_name'],
	 		'email'=>$userLog['email_id'],
	 		'role'=>'candidate',
	 		'ipAddress'=> $_SERVER['REMOTE_ADDR'],
	 		'timeDate'=>date('Y-m-d H:i:s'),
	 		'createdDate'=>date('Y-m-d H:i:s'),
	 	);
	 	$this->db->insert('loginlogs',$userdata);
	 	return true;

	 }
}