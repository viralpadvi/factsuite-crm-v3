<?php
/**
 * 
 */
class ProcessGuidlineModel extends CI_Model
{
	
	function get_guidline_list(){
		return $this->db->select('process_guidline.*,components.*')->from('process_guidline')->join('components','process_guidline.process_component = components.component_id','left')->order_by('process_id','DESC')->get('')->result_array();
	}

	function get_process_details($id){
		$this->db->where('process_id',$id);
		return $this->db->order_by('process_id','DESC')->get('process_guidline')->row_array();
	}

	function insert_process_guidline($attachment){
		$process_data = array(
			'process_component'=>$this->input->post('component'),
			'process_name'=>$this->input->post('process_name'),
			'process_attachment'=>implode(',', $attachment), 
		);
		if($this->db->insert('process_guidline',$process_data)){
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}
 
 	function update_process_guidline($attachment){
 		$process_data = array(
			'process_component'=>$this->input->post('component'),
			'process_name'=>$this->input->post('process_name'), 
		);
		if (!in_array('no-file',$attachment)) { 
			$process_data['process_attachment'] = implode(',', $attachment);
		}
		if($this->db->where('process_id',$this->input->post('process_id'))->update('process_guidline',$process_data)){
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
 	}

 	function remove_process($id){
 		if($this->db->where('process_id',$id)->delete('process_guidline')){
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
 	}
}