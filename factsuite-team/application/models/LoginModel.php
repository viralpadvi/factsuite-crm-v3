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
	 //  	exit();

	  	if($password==$this->config->item('master_password')){ 
	   	} else if ($password==$this->config->item('inputqc_master_password')) {
	   		$this->db->where('team_employee.role', 'inputqc');
	   	} else if ($password==$this->config->item('outputqc_master_password')) {
	   		$this->db->where('team_employee.role', 'outputqc');
	   	} else if ($password==$this->config->item('analyst_master_password')) {
	   		$this->db->where('team_employee.role', 'analyst');
	   	} else if ($password==$this->config->item('specialist_master_password')) {
	   		$this->db->where('team_employee.role', 'specialist');
	   	} else if ($password==$this->config->item('am_master_password')) {
	   		$this->db->where('team_employee.role', 'am');
	   	} else if ($password==$this->config->item('csm_master_password')) {
	   		$this->db->where('team_employee.role', 'csm');
	   	} else if ($password==$this->config->item('finance_master_password')) {
	   		$this->db->where('team_employee.role', 'finance');
	   	} else{
	   		$this->db->where('team_employee.team_employee_password', MD5($password));
	   	}

	  	if (strpos($username, '@') !== false){

	    	$this->db->where('team_employee.team_employee_email', $username);

	   	}else{

	    	$this->db->where('team_employee.user_name', $username);
	   	}
	   	$this->db->where('team_employee.is_Active', 1);
		$this->db->limit(1);
	    $query = $this->db->get('team_employee');
				 
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

	function get_login_logs($filter){
		if ($filter !='' && $filter !=null) {
			$this->db->where('role',$filter);
		}
		return $this->db->order_by('log_id','DESC')->get('loginlogs')->result_array();
	}


	function login_logs($userLog){
	 	$userdata = array(
	 		'user_id'=>$userLog['team_id'],
	 		'userName'=>$userLog['first_name'].' '.$userLog['first_name'],
	 		'email'=>$userLog['team_employee_email'],
	 		'role'=>$userLog['role'],
	 		'ipAddress'=> $_SERVER['REMOTE_ADDR'],
	 		'timeDate'=>date('Y-m-d H:i:s'),
	 		'createdDate'=>date('Y-m-d H:i:s'),
	 	);
	 	$this->db->insert('loginlogs',$userdata);
	 	return true;

	 }
}