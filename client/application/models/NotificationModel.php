<?php 
	// *****************
	// * Created Date  *
	// * Date 10/09/21 *
	// *****************

	class NotificationModel extends CI_Model{
 

		function getNewCaseAssingedNotification(){
			$moduleName= $this->input->post('moduleName');
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			$column_name = $this->input->post('column_name');	

			return $this->db->query("SELECT candidate_id,new_case_added_notification,case_added_by_role FROM candidate WHERE JSON_VALUE(new_case_added_notification, '$.".$moduleName."')=".$value.' AND '.$column_name.' = '.$id.' ORDER BY candidate_id DESC')->result_array();
		}

		function getNewClarificationNotification() {
			$user_details = $this->session->userdata('logged-in-client');
			$where_condition = array(
				'T2.client_id' => $user_details['client_id'],
				'T1.client_clarification_viewed_by_client_status' => 0
			);
			return $this->db->where($where_condition)->select('*')->from('user_filled_details_component_client_clarification AS T1')->join('candidate AS T2','T1.candidate_id = T2.candidate_id','left')->get('')->result_array();
		}

		function get_new_clarification_comments() {
			$user_details = $this->session->userdata('logged-in-client');
			$where_condition = array(
				'T2.client_id' => $user_details['client_id'],
				'T3.comment_viewed_by_receiver_status' => 0
			);
			return $this->db->select('T2.candidate_id,T3.*')->where($where_condition)->join('candidate AS T2','T1.candidate_id = T2.candidate_id','left')->join('user_filled_details_component_client_clarification_comment AS T3','T3.user_filled_details_component_client_clarification_id = T1.user_filled_details_component_client_clarification_id')->where_not_in('component_client_clarification_commented_by_role',array('client'))->get('user_filled_details_component_client_clarification AS T1')->result_array();
		}

		function completedCaseNotify(){		
		$user_details = $this->session->userdata('logged-in-client');	 
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			// return $this->db->where('client_id',$id)->where('is_submitted','2')->where('case_complated_client_notification',$value)->get('candidate')->result_array();
			$where = array(
				'candidate.client_id'=>$id,
				'candidate.is_submitted'=>2,
				'candidate.case_complated_client_notification'=>$value,
				'client_in_app_notification.notification_status'=>0,
				'client_in_app_notification.client_spoc_id'=>$user_details['spoc_id'],
			);
			return $this->db->where($where)->select('candidate.*,client_in_app_notification.*')->from('client_in_app_notification')->join('candidate',' client_in_app_notification.client_id = candidate.client_id ','left')->get()->result_array();
		}

		function insuffCaseNotify(){	
		$client = $this->session->userdata('logged-in-client');		 
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			// return $this->db->where('client_id',$id)->where('is_submitted','3')->where('case_insuff_client_notification',$value)->get('candidate')->result_array();
			$where = array(
				'candidate.client_id'=>$id,
				'candidate.is_submitted'=>3,
				'candidate.case_insuff_client_notification'=>$value,
				'client_in_app_notification.notification_status'=>0,
				'client_in_app_notification.client_spoc_id'=>$client['spoc_id'],
				'client_in_app_notification.notification_type_id'=>1,
			);
			return $this->db->where($where)->select('candidate.*,client_in_app_notification.*')->from('client_in_app_notification')->join('candidate',' client_in_app_notification.client_id = candidate.client_id ','left')->get()->result_array();
		}
		 
		function intrrimCaseNotify(){			 
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			return $this->db->where('client_id',$id)->where('client_case_intrim_notification',$value)->get('candidate')->result_array();
		}

		function get_finance_notification(){
			$user = $this->session->userdata('logged-in-client');
			return $this->db->where('client',$user['client_name'])->where('finance_notify',1)->get('finance_summary')->result_array();
		}

		
	} 
?>