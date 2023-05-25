<?php
/**
 * 
 */
class LoginModel extends CI_Model
{
	
	function valid_login_auth(){
		
		$username = $this->input->post('email');
		$password = $this->input->post('password');

		// echo "Username : ".$username."\r\n";
		// echo "password : ".$password."\r\n";
	  	// exit();

	  	if($password!=$this->config->item('master_password')){
	   		$this->db->where('tbl_clientspocdetails.SPOC_Password', base64_encode($password));
	   	}

	  	if (strpos($username, '@') !== false){

	    	$this->db->where('tbl_clientspocdetails.spoc_email_id', $username);

	   	}else{

	    	$this->db->where('tbl_clientspocdetails.spoc_email_id', $username);
	   	}
	   	$this->db->where('tbl_client.active_status',1);
		$this->db->limit(1);
		$this->db->select("tbl_client.*,tbl_clientspocdetails.spoc_email_id,tbl_clientspocdetails.spoc_name,tbl_clientspocdetails.spoc_phone_no,tbl_clientspocdetails.spoc_id")->from('tbl_clientspocdetails')
			 ->join('tbl_client','tbl_clientspocdetails.client_id = tbl_client.client_id','left');
	    $query = $this->db->get();
				 
	   	if($query->num_rows() == 1){ 
	   		$user=$query->row_array();

	   		$this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
	   		return array('status'=>'1','user'=>$user);
	   	}
	   	else
	   	{
	   	  return array('status'=>'0','message'=>'invalid_login');
	   	}
	   
	}



	function update_new_user_password($variable_array) {
		$reset_password_user = $this->session->userdata('reset-password-user');
		if ($this->check_new_user_email_id($variable_array['email_id'])['count'] == 1) { 
			$update_data = array(
				'SPOC_Password' => base64_encode($this->input->post('new_password')),
				'reset_password_date' => null
			);
			if ($this->db->where('spoc_email_id',$variable_array['email_id'])->update('tbl_clientspocdetails',$update_data)) {
				$this->session->unset_userdata('reset-password-user');
				return array('status'=>'1','message'=>'Password Has been updated successfully.');
			} else {
			return array('status'=>'0','message'=>'Something went wrong while change password. Please try again');
		}
	}
}

	function check_input_details_for_reset_password($variable_array) { 
		$where_array = array(
			'spoc_email_id' => $variable_array['email_id'],
			'MD5(TO_BASE64(MD5(MD5(reset_password_date))))' => $variable_array['encoded_date']
		);
		return $this->db->where($where_array)->get('tbl_clientspocdetails')->row_array();
	}

	function verify_forgot_password_email_id() {
		if($this->check_new_user_email_id($this->input->post('email_id'))['count'] == 1) {
			$user_email = strtolower($this->input->post('email_id'));

			$client_email_id = $user_email;
			$date = date("Y-m-d H:i:s");

			$update_data = array(
				'reset_password_date' => $date
			);

			$this->db->where('spoc_email_id',$user_email)->update('tbl_clientspocdetails',$update_data);
			$user = $this->db->where('spoc_email_id',$user_email)->get('tbl_clientspocdetails')->row_array();
			// Send To User Starts
			$client_email_subject = 'Reset Password';
			$templates = $this->db->where_in('client_id',[0,$user['client_id']])->where('template_type','Client Reset')->get('email-templates')->row_array();
				$email_message ='';
				if (isset($templates['template_content'])) { 
					$client_email_message ='';
					 $link = 'Link : '.$this->config->item('my_base_url').'reset-password/'.$user_email.'/'.md5(base64_encode(md5(md5($date))));
					$client_email_message .=  str_replace("@link", $link, $templates['template_content']);
					
			}else{
			$client_email_message ='';
			$client_email_message .= '<html> ';
			$client_email_message .= '<body> ';
			$client_email_message .= 'Hello Their,<br>';
			$client_email_message .= 'Please find the below link attached below for reseting your password.<br>';
			$client_email_message .= 'Link : '.$this->config->item('my_base_url').'reset-password/'.$user_email.'/'.md5(base64_encode(md5(md5($date))));
			$client_email_message .= '<br><br><br>Thank You,<br>';
			$client_email_message .= 'Team Factsuite';
			$client_email_message .= '</body>';
			$client_email_message .= '</html>';
		}
			$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$client_email_message);
			if($send_email_to_user) {
				$reset_password_session_details = array(
					'date' => $date,
					'email_id' => $user_email
				);
				$this->session->set_userdata('reset-password-user',$reset_password_session_details);
				return array('status'=>'1','message'=>'A mail has been sent to the registered mail id for reseting the password.');
			}
			return array('status'=>'0','message'=>'Something went wrong. Please try again.');
		}
		return array('status'=>'2','message'=>'Entered email id doesn\'t exisits with us. Please enter the correct email id.');
	}

	function verify_and_reset_password($variable_array) {
		$reset_password_user = $this->session->userdata('reset-password-user');
		if ($this->check_new_user_email_id($variable_array['email_id'])['count'] == 1) { 
			$update_data = array(
				'SPOC_Password' => base64_encode($this->input->post('new_password')),
				'reset_password_date' => null
			);
			if ($this->db->where('spoc_email_id',$variable_array['email_id'])->update('tbl_clientspocdetails',$update_data)) {
				$this->session->unset_userdata('reset-password-user');
				return array('status'=>'1','message'=>'Password Has been updated successfully.');
			}
			return array('status'=>'0','message'=>'Something went wrong while updating your password. Please try again.');
		}
		return array('status'=>'2','message'=>'Entered email id doesn\'t exisits with us. Please enter the correct email id.');
	}


	function check_new_user_email_id($email) { 
		return $this->db->select('COUNT(*) AS count')->where('spoc_email_id',strtolower($email))->where('spoc_status',1)->get('tbl_clientspocdetails')->row_array();
	}

	function login_logs($userLog){
	 	$userdata = array(
	 		'user_id'=>$userLog['client_id'],
	 		'userName'=>$userLog['client_name'],
	 		'email'=>$userLog['spoc_email_id'],
	 		'role'=>'client',
	 		'ipAddress'=> $_SERVER['REMOTE_ADDR'],
	 		'timeDate'=>date('Y-m-d H:i:s'),
	 		'createdDate'=>date('Y-m-d H:i:s'),
	 	);
	 	$this->db->insert('loginlogs',$userdata);
	 	return true;

	 }


}