<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Internal_chat extends CI_Model {

	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	}

	function get_internal_chat_details($user){
		$where = "( (to_id=".$this->input->post('to_id')." AND to_role='".$this->input->post('to_role')."' AND from_id=".$user['team_id']." AND from_role='".$user['role']."' ) OR (to_id=".$user['team_id']." AND to_role='".$user['role']."' AND from_id=".$this->input->post('to_id')." AND from_role='".$this->input->post('to_role')."' ) )";

		$where_read = "(from_id=".$this->input->post('to_id')." AND from_role='".$this->input->post('to_role')."' AND to_id=".$user['team_id']." AND to_role='".$user['role']."' )  AND read_status=0 ";
		$update_read_date = array(
			'read_status'=>1,
			'read_date'=>date('d-m-Y H:i:s')
		);
		$update = $this->db->where($where_read)->update('internal-chat',$update_read_date);

		if ($this->input->post('last_value')) {
			 $this->db->where('chat_id > ',$this->input->post('last_value'));
		}
		return $this->db->order_by('chat_id','')->where($where)->get('internal-chat')->result_array();
	}

	function insert_interna_chat($user){
		$internal_chat = array(
			'to_id'=>$this->input->post('to_id'),
			'to_role'=>$this->input->post('to_role'),
			'from_id'=>$user['team_id'],
			'from_role'=>$user['role'],
			'message_type'=>'text',
			'message'=>$this->input->post('message'),
			'ip_address'=>$_SERVER['REMOTE_ADDR'],
		);

		if ($this->db->insert('internal-chat',$internal_chat)) {
			$where = "(to_id=".$this->input->post('to_id')." AND to_role='".$this->input->post('to_role')."' AND from_id=".$user['team_id']." AND from_role='".$user['role']."' )";
		$chat_id = $this->db->order_by('chat_id','DESC')->where($where)->get('internal-chat')->row_array();
			return array('status'=>'1','msg'=>'success','chat'=>$chat_id);
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function get_number_of_chats($user){
		$where = "( to_id=".$user['team_id']." AND to_role='".$user['role']."' AND read_status=0 )";
		return $this->db->where($where)->get('internal-chat')->result_array();
	}

	function get_number_of_chats_selected_user($user){
		$where = "( `internal-chat`.to_id =".$user['team_id']." AND `internal-chat`.to_role= '".$user['role']."' AND `internal-chat`.read_status = 0 )";
		return $this->db->order_by('`internal-chat`.chat_created_date','')->where($where)->select('count(`internal-chat`.chat_id) as total,`internal-chat`.*, team_employee.first_name,team_employee.last_name,team_employee.team_id,team_employee.role')->join('team_employee',' `internal-chat`.`from_id` = team_employee.team_id ','left')->get('internal-chat')->result_array();
	}

	function get_internal_team($team){
		$where = "team_id !=".$team['team_id']." AND is_Active=1 ";
		if ($this->input->post('input') !='' && $this->input->post('input') !=null && $this->input->post('input') != 'undefined') {
		$where .="AND (first_name LIKE '%".$this->input->post('input')."%' OR last_name LIKE '%".$this->input->post('input')."%' OR role LIKE '%".$this->input->post('input')."%' )"; 	
		}
		return $this->db->where($where)->get('team_employee')->result_array();  
	}




	function insert_internal_chat_attachment($user,$attachments){
		$internal_chat = array(
			'to_id'=>$this->input->post('to_id'),
			'to_role'=>$this->input->post('to_role'),
			'from_id'=>$user['team_id'],
			'from_role'=>$user['role'],
			'message_type'=>'file',
			'message'=>implode(',', $attachments),
			'ip_address'=>$_SERVER['REMOTE_ADDR'],
		);

		if ($this->db->insert('internal-chat',$internal_chat)) {
			$where = "(to_id=".$this->input->post('to_id')." AND to_role='".$this->input->post('to_role')."' AND from_id=".$user['team_id']." AND from_role='".$user['role']."' )";
		$chat_id = $this->db->order_by('chat_id','DESC')->where($where)->get('internal-chat')->row_array();
			return array('status'=>'1','msg'=>'success','chat'=>$chat_id);
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


}
 