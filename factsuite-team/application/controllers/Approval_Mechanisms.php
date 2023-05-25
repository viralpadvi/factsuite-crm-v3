<?php 

/**
 * 
 */
class Approval_Mechanisms extends CI_Controller
{
	
 	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('Approval_Mechanisms_Model');  
	}


 function index(){

 } 

 function get_notification_for_admin(){
 	$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}

 	$data = $this->Approval_Mechanisms_Model->get_approval_data($user);
 	echo json_encode($data);
 }

 function get_approval_notification(){
 		$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}

 	$data = $this->Approval_Mechanisms_Model->get_approval_notification($user);
 	echo json_encode($data);
 }

 function clear_the_notification(){
 	$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
 	$data = $this->Approval_Mechanisms_Model->clear_the_notification($user);

 	echo json_encode($data);
 }


 function client_adding_deletion(){ 
		$admin_data['userData'] = $this->session->userdata('logged-in-csm');
		$data['client'] = $this->db->where('is_master',0)->order_by('client_id','DESC')->get('tbl_client')->result_array();
		$this->load->view('csm/csm-common/header',$admin_data);
		$this->load->view('csm/csm-common/sidebar');
		$this->load->view('csm/approval/approval-common');
		$this->load->view('csm/approval/approval-mechanism',$data);
		$this->load->view('csm/csm-common/footer');
 }
 	function client_adding_rate(){ 
		$admin_data['userData'] = $this->session->userdata('logged-in-csm');
		$data['component'] = $this->db->get('components')->result_array();
		$data['client'] = $this->db->where('active_status',1)->order_by('client_id','DESC')->get('tbl_client')->result_array();
		$this->load->view('csm/csm-common/header',$admin_data);
		$this->load->view('csm/csm-common/sidebar');
		$this->load->view('csm/approval/approval-common');
		$this->load->view('csm/approval/approval-price',$data);
		$this->load->view('csm/csm-common/footer');
 }


 	function csm_approver_levels(){ 
		$admin_data['userData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$admin_data);
		$this->load->view('csm/csm-common/sidebar');
		// $this->load->view('csm/approval/approval-common');
		$this->load->view('csm/approval/admin-approval',$admin_data);
		$this->load->view('csm/csm-common/footer');
 	}


	function am_approver_levels(){ 
		$admin_data['userData'] = $this->session->userdata('logged-in-am'); 
		$this->load->view('am/am-common/header',$admin_data);
		$this->load->view('am/am-common/sidebar');
		// $this->load->view('am/approval/approval-common');
		$this->load->view('am/approval/admin-approval',$admin_data);
		$this->load->view('am/am-common/footer');
 }


 	function admin_approver_levels(){ 
		$admin_data['userData'] = $this->session->userdata('logged-in-admin'); 
		$this->load->view('admin/admin-common/header',$admin_data);
		$this->load->view('admin/admin-common/sidebar');
		// $this->load->view('csm/approval/approval-common')
		$this->load->view('csm/approval/admin-approval',$admin_data);

		$this->load->view('admin/admin-common/footer');
 	}

	function approval_finance_view(){ 
		$admin_data['userData'] = $this->session->userdata('logged-in-finance'); 
		$this->load->view('finance/finance-common/header',$admin_data);
		$this->load->view('finance/finance-common/sidebar');
		// $this->load->view('finance/approval/approval-common');
		$this->load->view('finance/approval/admin-approval' );
		$this->load->view('finance/finance-common/footer');
 	}

 	function get_approval_list_for_finance(){
 		$data = $this->Approval_Mechanisms_Model->get_approval_data_for_finance(); 
 		echo json_encode($data);
 	}


 function create_approval_for_client(){
 	$data = $this->Approval_Mechanisms_Model->create_approval_for_client();
 	echo json_encode($data);
 } 
 function get_approval_data(){ 
 	$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}

 	if ($this->input->post('verify_csm_request') == 1) { 
	 	$data = $this->Approval_Mechanisms_Model->get_approval_data($user);
	 	echo json_encode($data);
 	}
 } 

 function get_approval_data_am_csm(){ 
 	$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			} 

 	if ($this->input->post('verify_csm_request') == 1) { 
	 	$data = $this->Approval_Mechanisms_Model->get_list_of_the_approval($user); 
	 	echo json_encode($data);
 	}
 } 



 function update_approval_data(){
 	$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
 	$data = $this->Approval_Mechanisms_Model->update_approval_data($user);
	 	echo json_encode($data);
 }

 function update_approval_data_level_one(){
 	$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
 	$data = $this->Approval_Mechanisms_Model->approval_one_level($user);
	 	echo json_encode($data);
 }

 function update_approval_data_level_two(){
 	$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
 	$data = $this->Approval_Mechanisms_Model->approval_two_level($user);
	 	echo json_encode($data);
 }

 function get_approvals_data(){
 	$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			} 
 	$data = $this->Approval_Mechanisms_Model->get_approvals_data();

 	if($user['role'] !='admin') {
 		$this->db->where('approver_status',1)->where('team_id',$user['team_id']);
 	}
 	$data['team'] = $this->db->where('is_Active',1)->where('approver_status',1)->get('team_employee')->result_array();
 	$data['teams'] = $this->db->where('is_Active',1)->where('approver_status',1)->get('team_employee')->result_array();
 	$data['levels'] = $this->db->where("approve_id",$data['number_of_list'])->get("list_of_approval")->row_array();

 	if (in_array($data['number_of_list'],['1','2'])) {
	 		$data['client_data'] = $this->db->where('client_id',$data['link_account'])->get('tbl_client')->row_array();
	 	}else{
	 		$data['client_data'] = '';
	 	}
 
	 	echo json_encode($data);
 }

 function approval_for_client_fee(){
 	$data = $this->Approval_Mechanisms_Model->approval_for_client_fee();
 	echo json_encode($data);
 }

 function approval_for_crm_user(){
 	$data = $this->Approval_Mechanisms_Model->approval_for_crm_user();
 	echo json_encode($data);
 }

 function approval_for_am_user(){
 	$data = $this->Approval_Mechanisms_Model->approval_for_am_user();
 	echo json_encode($data);
 }

 function approval_for_rate_user(){
 	$data = $this->Approval_Mechanisms_Model->approval_for_rate_user();
 	echo json_encode($data);
 }


 function get_all_remarks(){ 
 	echo file_get_contents(base_url().'assets/custom-js/json/approval-mechanism.json');
 }

function get_reject_remarks(){
	echo file_get_contents(base_url().'assets/custom-js/json/approver-reject-dropdown.json'); 
}

 function update_approval_assign(){
 	$data = $this->Approval_Mechanisms_Model->update_approval_assign();
 	echo json_encode($data);
 }

 function update_approval_list_level(){
 	$data = $this->Approval_Mechanisms_Model->update_approval_list_level();
 	echo json_encode($data);
 }

 function get_list_of_value(){
 	$data = $this->db->where('approve_id',$this->input->post('id'))->get('list_of_approval')->row_array();
 	echo json_encode($data);
 }


}
 