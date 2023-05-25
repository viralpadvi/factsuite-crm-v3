<?php 

class DynamicModel extends CI_Model {
	
	function manage_and_insert_update_fields(){
	$field_result = '';
		$data = $this->db->order_by('field_id','DESC')->limit(1)->get('fs_fields')->row_array();
		if ($data !=null) {
			$array = explode(',', $data['field_name']);
			array_push($array,$this->input->post('field_name')); 
			$fields = implode(',', $array);
			$data_array = array(
				'field_name' =>$fields
			);
			$field_result = $this->db->where('field_id',$data['field_id'])->update('fs_fields',$data_array);
		}else{
			$data_array = array(
				'field_name' =>$this->input->post('field_name')
			);
			$field_result = $this->db->insert('fs_fields',$data_array);
		}

		if ($field_result) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function get_fields(){
		return $this->db->order_by('field_id','DESC')->limit(1)->get('fs_fields')->row_array();
	}


	function employment_fields($fields){
		$field_result = '';
		$data = $this->db->order_by('field_id','DESC')->limit(1)->get('fs_fields')->row_array();
		if ($data !=null) { 
			$data_array = array(
				'employment_fields' =>$fields
			);
			$field_result = $this->db->where('field_id',$data['field_id'])->update('fs_fields',$data_array);
		}else{
			$data_array = array(
				'employment_fields' =>$fields
			);
			$field_result = $this->db->insert('fs_fields',$data_array);
		}

		if ($field_result) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function field_name($fields){
		$field_result = '';
		$data = $this->db->order_by('field_id','DESC')->limit(1)->get('fs_fields')->row_array();
		if ($data !=null) { 
			$data_array = array(
				'field_name' =>$fields
			);
			$field_result = $this->db->where('field_id',$data['field_id'])->update('fs_fields',$data_array);
		}else{
			$data_array = array(
				'field_name' =>$fields
			);
			$field_result = $this->db->insert('fs_fields',$data_array);
		}

		if ($field_result) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function get_field_values(){
		return $this->db->order_by('dynamic_id','DESC')->get('dynamic_data')->result_array();
	}

	function get_field_details($id){
		return $this->db->where('dynamic_id',$id)->get('dynamic_data')->row_array();
	}



	function insert_field_values(){ 
		$data = array(
			'field_values'=>json_encode($this->input->post('field_value')),
			'created_date'=>date('d-m-Y'),
			'updated_date'=>date('d-m-Y')
		);

		if ($this->db->insert('dynamic_data',$data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function insert_batch_field_education($param){  
		if ($this->db->insert_batch('dynamic_data',$param)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function insert_batch_field_employer($param){  
		if ($this->db->insert_batch('employee_dynamic_data',$param)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_field_values(){ 
		$data = array(
			'field_values'=>json_encode($this->input->post('field_value')), 
			'updated_date'=>date('d-m-Y')
		);

		if ($this->db->where('dynamic_id',$this->input->post('dynamic_id'))->update('dynamic_data',$data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	/* employeee dynamic data */

	
	function manage_and_insert_update_employee_fields(){
	$field_result = '';
		$data = $this->db->order_by('field_id','DESC')->limit(1)->get('fs_fields')->row_array();
		if ($data !=null) { 
			$array = array();
			if (isset($data['employment_fields'])) { 
			$array = explode(',', $data['employment_fields']);
			}
			array_push($array,$this->input->post('field_name')); 
			$fields = implode(',', $array);
			$data_array = array(
				'employment_fields' =>$fields
			);
			$field_result = $this->db->where('field_id',$data['field_id'])->update('fs_fields',$data_array);
		}else{
			$data_array = array(
				'employment_fields' =>$this->input->post('field_name')
			);
			$field_result = $this->db->insert('fs_fields',$data_array);
		}

		if ($field_result) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function get_employee_field_values(){
		return $this->db->order_by('dynamic_id','DESC')->get('employee_dynamic_data')->result_array();
	}

	function get_employee_field_details($id){
		return $this->db->where('dynamic_id',$id)->get('employee_dynamic_data')->row_array();
	}



	function insert_employee_field_values(){ 
		$data = array(
			'field_values'=>json_encode($this->input->post('field_value')),
			'created_date'=>date('d-m-Y'),
			'updated_date'=>date('d-m-Y')
		);

		if ($this->db->insert('employee_dynamic_data',$data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function update_employee_field_values(){ 
		$data = array(
			'field_values'=>json_encode($this->input->post('field_value')), 
			'updated_date'=>date('d-m-Y')
		);

		if ($this->db->where('dynamic_id',$this->input->post('dynamic_id'))->update('employee_dynamic_data',$data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

}