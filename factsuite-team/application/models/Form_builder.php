<?php
/** 
 * 12-03-2021	
 */
class Form_builder extends CI_Model
{

    function get_forms($id=''){
        if ($id !='') {
           $this->db->where('form_id',$id);
        }
       return $this->db->order_by('form_id','DESC')->get('form-builder')->result_array(); 
    }

 function insert_form_builder($form){ 
    $form = array(
        'form_name'=>$this->input->post('form_name'),
        'form_path'=>$form,
    );
    $result = false;
    if ($this->input->post('form_id')) {
      $result = $this->db->where('form_id',$this->input->post('form_id'))->update('form-builder',$form); 
    }else{
      $result = $this->db->insert('form-builder',$form); 
    }

    if ($result) {
        return array('status'=>'1','msg'=>'success');
    }else{
        return array('status'=>'0','msg'=>'failled');
    }
 }

}