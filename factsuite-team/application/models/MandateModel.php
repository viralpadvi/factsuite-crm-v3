<?php
/**
 * 
 */
class MandateModel extends CI_Model
{

    function get_all_client_mandate(){
       return $this->db->select('client_madate.*,tbl_client.client_name,packages.package_name')->from('client_madate')->join('tbl_client','client_madate.client_id = tbl_client.client_id','left')->join('packages','client_madate.package_id = packages.package_id','left')->get()->result_array();
    }

    function get_mandate_details($id){
        $this->db->where('client_madate.mandate_id',$id);
         return $this->db->select('client_madate.*,tbl_client.client_name')->from('client_madate')->join('tbl_client','client_madate.client_id = tbl_client.client_id','left')->get()->row_array();
    }

    function insert_mandate(){
        $data = array(
            'client_id'=>$this->input->post('client_name'),
            'mandate_description'=>$this->input->post('description'),
            'package_id'=>$this->input->post('package_id'),
            'instruction'=>$this->input->post('instruction'),
            'component_comments'=>$this->input->post('component')
        );
        if ($this->db->insert('client_madate',$data)) {
            return array('status'=>'1','msg'=>'success');
        }else{
            return array('status'=>'0','msg'=>'failed');
        } 
    }

    function update_mandate(){
        $data = array(
            'client_id'=>$this->input->post('client_name'),
            'mandate_description'=>$this->input->post('description'),
            'package_id'=>$this->input->post('package_id'),
            'instruction'=>$this->input->post('instruction'),
            'component_comments'=>$this->input->post('component')
        );
        if ($this->db->where('mandate_id',$this->input->post('mandate_id'))->update('client_madate',$data)) {
            return array('status'=>'1','msg'=>'success');
        }else{
            return array('status'=>'0','msg'=>'failed');
        } 
    }
}
	