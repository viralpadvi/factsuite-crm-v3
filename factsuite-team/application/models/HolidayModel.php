<?php
/**
 * 28-01-2021	
 */
class HolidayModel extends CI_Model
{
	function get_holiday_details($holiday_id=''){
		$result ='';
		if ($holiday_id !='') { 
			$result = $this->db->where('holiday_id',$holiday_id)->get('tat_holidays')->row_array();
		}else{
			$result = $this->db->select('*')->from('tat_holidays')->get()->result_array();
		}
		return $result;
	}
	function insert_holiday(){
 		$holiday_data = array(
 			'holiday_date' =>$this->input->post('holiday')
 		); 
		if ($this->db->insert('tat_holidays',$holiday_data)) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

 	function update_holiday(){
 		$this->db->where('holiday_id',$this->input->post('holiday_id'));
 		$holiday_data = array(
 			'holiday_date' =>$this->input->post('holiday_date')
 		); 
		if ($this->db->update('tat_holidays',$holiday_data)) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

 	function remove_holiday($holiday_id){
 		$this->db->where('holiday_id',$holiday_id);
 		
		if ($this->db->delete('tat_holidays')) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}
// SELECT `time_id`, `module`, `clock_type`, `12_24_hr_format`, `time_formate`, `date_formate`, `timezone`, `created_date`, `updated_date` FROM `timezones` WHERE 1
	function add_timezone(){
		$time_zone = array( 
 			'module' =>0,
 			'timezone' =>$this->input->post('timezone'),
 			'clock_type' =>$this->input->post('clock'),
 			'12_24_hr_format' =>$this->input->post('time_type'),
 			'date_formate' =>$this->input->post('time_formate'),
 			'created_date' =>date('d-m-Y H:i'),
 			'updated_date' =>date('d-m-Y H:i')
 		); 
		$this->session->unset_userdata('time');
 		$count = $this->db->where('module',0)->get('timezones')->num_rows();
 			$result = false;
 			if ($count > 0) {
 				$result = $this->db->where('module',0)->update('timezones',$time_zone);
 			}else{
 				$result = $this->db->insert('timezones',$time_zone);
 			}
		if ($result) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_timezone(){
		$time_zone = array(
 			'client_id' =>$this->input->post('client_id'),
 			'timezone' =>$this->input->post('timezone'),
 			'clock_type' =>$this->input->post('clock'),
 			'time_formate' =>$this->input->post('time_type'),
 			'date_formate' =>$this->input->post('time_formate'), 
 			'updated_date' =>date('d-m-Y H:i')
 		); 
		if ($this->db->where('time_id',$this->input->post('time_id'))->update('timezones',$time_zone)) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function get_timezone_details(){ 
			$this->db->where('timezones.module',0);
		 
		return $this->db->select("timezones.*")->get('timezones')->result_array();
	}

	function remove_timezone($time_id){
 		$this->db->where('time_id',$time_id);
 		
		if ($this->db->delete('timezones')) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

}
