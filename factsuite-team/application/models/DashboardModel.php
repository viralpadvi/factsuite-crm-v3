<?php
/** 
 * 06-09-2021	
 */
class DashboardModel extends CI_Model{


    function caseInventory(){
        $caseDetail['totalCase']=$this->db->get('candidate')->num_rows();
    }
    
}

?>