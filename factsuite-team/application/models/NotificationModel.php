<?php 
	// *****************
	// * Created Date  *
	// * Date 08/09/21 *
	// *****************

	class NotificationModel extends CI_Model{

		function getNewAddedCaseNotification(){

			$moduleName= $this->input->post('moduleName');
			$value= $this->input->post('value');

			return $this->db->query("SELECT candidate_id,new_case_added_notification,case_added_by_role FROM candidate WHERE new_case_added_notification REGEXP '\"".$moduleName."\": \"".$value."\"' ORDER BY candidate_id DESC")->result_array();

		}


		function getNewCaseAssingedNotification(){

			$moduleName= $this->input->post('moduleName');
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			$column_name = $this->input->post('column_name');

			return $this->db->query("SELECT candidate_id,new_case_added_notification,case_added_by_role FROM candidate WHERE new_case_added_notification REGEXP '\"".$moduleName."\": \"".$value."\"' AND ".$column_name." = ".$id." ORDER BY candidate_id DESC")->result_array();

		}


		function getFormFilledNotification(){
			$id = $this->input->post('id');
			$value = $this->input->post('value');
			return $this->db->where('assigned_inputqc_id',$id)->where('form_filld_notification',$value)->get('candidate')->result_array();
		}

		function getAssignedComponentNotification(){
			$id = $this->input->post('id');		
			$status = $this->input->post('value');
			return $this->db->where('assigned_team_id',$id)->where('component_status',$status)->where('notification_status','0')->where('manually_seen','0')->get('notifications')->result_array();	
			// echo $this->db->last_query();
		}


		// function notificationCreate($case_id,$case_index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message){
		function notificationCreate($tbl_name,$tbl_column_name,$tbl_id,$component_id,$team_id){
		 	$componentInfo = $this->db->where($tbl_column_name,$tbl_id)->get($tbl_name)->row_array();
		 	 
		 	$analyst_status = $componentInfo['analyst_status'];	
		 	$analyst_status = explode(',',$analyst_status);
		 	$assigned_team_id = $componentInfo['assigned_team_id'];
		 	$assigned_team_id = explode(',',$assigned_team_id);
		 	$notificationBatchData = array();

		 	foreach ($analyst_status as $key => $value) {
		 		 
		 		if($value == '10'){
		 			$notificationData = array(
						'case_id'=>$componentInfo['candidate_id'],
						'case_index'=>$key,
						'component_id'=>$component_id,
						'component_status'=>$value,
						'message'=>"Qc Error genrated from OutputQc.",
						'raised_by_team_id'=>$team_id,
						'assigned_team_id'=>$assigned_team_id[$key],		 
						'created_date'=>date('Y-m-d H:i:s')
					);
		 			array_push($notificationBatchData, $notificationData);
		 		}
		 		
		 	}
		 	 
		 	// print_r(count($notificationBatchData));

			if(count($notificationBatchData) != 0 && $this->db->insert_batch('notifications',$notificationBatchData)){
				return '1';
			}else{
				return '0';
			}		 
		}
		

		function completedCaseNotify(){			 
			$value = $this->input->post('value');
			return $this->db->where('is_submitted','2')->where('case_complated_notification',$value)->get('candidate')->result_array();
		}

		function intrimNotify($role,$analyst_status,$candidate_id){
			$exception = '';
			// try{
				if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status != '3'){
					// echo "1.0</br>";
					$candidate_info_tmp = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
					// echo "1.1</br>";
					// echo $candidate_info_tmp['case_intrim_notification']."</br>";
					if($candidate_info_tmp['case_intrim_notification'] != '1' && $candidate_info_tmp['case_intrim_notification'] != '2' && $candidate_info_tmp['client_case_intrim_notification'] != '1' && $candidate_info_tmp['client_case_intrim_notification'] != '2'){
						// echo "1.3</br>";
						$positive_status = array('4','5','6','7','9');
						// echo "1.4</br>";
						if(in_array($analyst_status,$positive_status)){
							// echo "1.5</br>";
							$componentStatus = $this->utilModel->isAnyComponentVerifiedClear($candidate_id);
							if($componentStatus == '0'){
								// echo "1.6</br>";
								$updateInfo = array('case_intrim_notification' => '1','client_case_intrim_notification' => '1','updated_date'=>date('Y-m-d H:i:s'));
								if($this->db->where('candidate_id',$candidate_id)->update('candidate',$updateInfo)){
									// echo "1.7</br>";
									$updatedCandidateInfo = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
									$this->db->insert('candidate_log',$updatedCandidateInfo);
								}
									 
							}	
						}
					}
				}
			// }catch(Exception $exception){
			// 	$exception = $exception;
			// }
		}


		function intrrimCaseNotify(){			 
			$value = $this->input->post('value');
			return $this->db->where('case_intrim_notification',$value)->get('candidate')->result_array();
		}



		function create_insuff_analyst_notification($case_id,$case_index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message){ 

		 	$notificationData = array(
				'case_id'=>$case_id,
				'case_index'=>$case_index,
				'component_id'=>$component_id,
				'component_status'=>$component_status,
				'message'=> $message,
				'assigned_team_id'=>$assigned_team_id,
				'raised_by_team_id' => $raised_by_team_id,		 
				'created_date'=>date('Y-m-d H:i:s')
			);
		 	  		 
			if($this->db->insert('notifications',$notificationData)){
				// print_r($this->db->last_query()); 
				return '1';
			}else{
				// print_r($this->db->last_query()); 
				return '0';
			}		 
		}

		function outPutQcNewCaseNotify(){			 
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			return $this->db->where('assigned_outputqc_id',$id)->where('assigned_outputqc_notification',$value)->order_by('candidate_id','DESC')->get('candidate')->result_array();
			// echo $this->db->last_query();
		}


		function outPutQcClearComponentErrorNotify(){
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			return $this->db->where('assigned_team_id',$id)->where('notification_status',$value)->get('notifications')->result_array();
			// echo $this->db->last_query();
		}
	}
?>