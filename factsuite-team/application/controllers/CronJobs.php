<?php
	
	/**
	 * 
	 */
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	class CronJobs extends CI_Controller
	{
		
		function __construct() {
			parent::__construct();
	  		$this->load->database();
	  		$this->load->helper('url'); 
	  		$this->load->model('teamModel');  
	  		$this->load->model('clientModel');  
	  		$this->load->model('packageModel');
	  		$this->load->model('inputQcModel');
	  		$this->load->model('emailModel');
    			$this->load->model('analystModel');
	  		$this->load->model('insuffAnalystModel');
    			$this->load->model('utilModel');
    			$this->load->model('componentModel');
    			$this->load->model('notificationModel');
    			$this->load->model('adminViewAllCaseModel');
    			$this->load->model('cronJobsModel');
    			$this->load->model('excel_Extract_Model');  
    			$this->load->model('branding_Emails_Model');  
		}

		// trigger pending outputqc pending assignments
		function outputqc_assignment(){
			$this->analystModel->trigger_outputqc_assignment();
		}

		// Insuff Mail to Client 
		public function insuff_case_list(){
			// echo "Time: ".time()."<br>";
			// echo "microtime: ".microtime();
			// exit();
			$this->cronJobsModel->insuff_case_list();
			// echo json_encode();
		}


		// Case upload acknowledgement to Client 
		public function today_case_uploaded_acknowledgement_list(){
			echo json_encode($this->cronJobsModel->today_case_uploaded_acknowledgement_list());
		}

		//BGV Report uploaded notification to Client
		public function completed_bgv_repot_case_list(){
			echo json_encode($this->cronJobsModel->completed_bgv_repot_case_list());	 
		}

		function get_daily_client_case_status(){
			echo json_encode($this->cronJobsModel->get_daily_client_case_status());
			$this->trigger_candidate_schedule_reporting();
		}

		function client_auomated_reminders() {
			echo json_encode($this->cronJobsModel->client_auomated_reminders()); 
		}


		function trigger_mail(){
			 
			$mail = array(/*array('candidate_name'=>'vaisakh UV','email'=>'vaisakh.uv@factsuite.com','login_id'=>'7990919233','OTP'=>'9233','client_name'=>'Riyatsa Infotech'),*/array('candidate_name'=>'Yash Panchal','login_id'=>'1984848072','email'=>'yash.panchal26@gmail.com','OTP'=>'2482','client_name'=>'Riyatsa Infotech'));
			foreach ($mail as $key => $value) {
					 
			$variable_array = array(
									'candidate_name' => $value['candidate_name'],
									'login_id' => $value['login_id'],
									'otp' => $value['OTP'],
									'client_name' => $value['client_name']
								);
			$email_subject = 'Submission of your documents for verification';
			$send_mail_message = $this->branding_Emails_Model->send_email_to_candidate_for_pending_cases_series_1($variable_array);
			$this->emailModel->send_mail($value['email'],$email_subject,$send_mail_message);
			$send_mail_message = $this->branding_Emails_Model->send_email_to_candidate_for_pending_cases_series_2($variable_array);
			$this->emailModel->send_mail($value['email'],$email_subject,$send_mail_message);
			$send_mail_message = $this->branding_Emails_Model->send_email_to_candidate_for_pending_cases_series_3($variable_array);
			$this->emailModel->send_mail($value['email'],$email_subject,$send_mail_message);
			$send_mail_message = $this->branding_Emails_Model->send_email_to_client_for_pending_cases($variable_array);
			$email_subject = 'Your verification request is still pending!';
			$this->emailModel->send_mail($value['email'],$email_subject,$send_mail_message);
			}
		
		}


		function trigger_candidate_schedule_reporting() {
			date_default_timezone_set("Asia/Kolkata");
			$query = "SELECT * FROM `schedule-sms-email-ivrs` WHERE `schedule_status` = 1";
			$query_db_conn = $this->db->query($query);
			if ($query_db_conn->num_rows() > 0) {
				 
            		$main_counter = 0;
		 		$result_data = $query_db_conn->result_array();
				foreach ($result_data as $key => $result) { 
					// echo $result['schedule_time'];
					// $date_array = json_decode($result['schedule_date'],true)[0];
					$time_array = json_decode($result['schedule_time'],true)[0];
			 		$minustime = date('H:i', strtotime("-1 minutes"));
					 $currtime = date('H:i');

					echo $result['schedule_time'].'<br>'; 

					// file_put_contents('log.txt',"rendered the log ".$currtime.PHP_EOL.PHP_EOL , FILE_APPEND|LOCK_EX);

					// echo json_encode($date_array['email']);
					$query_db_conn_candidate = $this->db->query('SELECT T2.client_name,T1.* FROM `candidate` AS T1 INNER JOIN `tbl_client` AS T2 ON T1.client_id = T2.client_id WHERE T1.is_submitted IN (0)')->result_array();
			 		foreach ($query_db_conn_candidate as $key => $query_result) {
						$candidate_created_date = explode(' ',$query_result['created_date']);
                  			$candidate_created = date_create($candidate_created_date[0]);
                  			if ($query_result['is_submitted'] == '0') {
                        			$candidate_created_date = explode(' ',$query_result['created_date']);
                        			$candidate_created = date_create($candidate_created_date[0]);
                  			}
                  			$current_date = date_create(date('Y-m-d'));
                  			$date_difference = date_diff($candidate_created,$current_date);
                  			$schedule_days = explode(',', $result['schedule_days']);
                  			$index = array_search($date_difference->format("%a"), $schedule_days);
                  			$time_sms = explode(',', $time_array['sms'][$index]);
                  			$time_email = explode(',', $time_array['email'][$index]);
						///sms
                  			 
						if (in_array($date_difference->format("%a"), $schedule_days)  && in_array($currtime,$time_sms)) {
                  				$pass_data = '';
                  				$message_count = 0;
                  				$pass_data = 'Hi '.$query_result['first_name'].', we have noticed that you have not completed your Address verification. Kindly click on the link '.$this->config->item('candidate_url').' to complete the task at the earliest and have your job offer confirmed.  Login by entering your mobile number and password:'.$query_result['otp_password'].'. Thanks, Team FactSuite';

                  				// if ($date_difference->format("%a") != 10) {
                      					
                      				// 	// $message_count++;
                  				// } else if ($date_difference->format("%a") == 10) {
                        			// 	$pass_data = 'FINAL REMINDER! Hi '.$query_result['first_name'].', you have ONLY 24 HOURS left to complete your Address Verification and have your job offer confirmed. Kindly click on the link to complete the check right away! '.$this->config->item('candidate_url').' Login by entering your mobile number and password:'.$query_result['otp_password'].'. Thanks, Team FactSuite';
                      				// 	// $message_count++;
                  				// }

				                  // if ($message_count != 0) {
				                        $curl = curl_init();
				                        curl_setopt_array($curl, array(
				                              CURLOPT_URL => 'http://sms-alerts.servetel.in/api/v4/?api_key=A25b53c27773fb73f72a71c651134b73e&method=sms&message='.urlencode($pass_data).'&to=91'.$query_result['phone_number'].'&sender=FACTSU',
				                              CURLOPT_RETURNTRANSFER => true,
				                              CURLOPT_ENCODING => "",
				                              CURLOPT_MAXREDIRS => 10,
				                              CURLOPT_TIMEOUT => 0,
				                              CURLOPT_FOLLOWLOCATION => true,
				                              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				                              CURLOPT_CUSTOMREQUEST => "POST",
				                        )); 
				                        $response = curl_exec($curl);
				                  // }
						}

					  
						///email
						if (in_array($date_difference->format("%a"), $schedule_days) && in_array($currtime,$time_email)) {
							echo "true";
							if ($query_result['email_id'] != '' && $query_result['email_id'] != null) {
								$send_mail_message = '';
								$email_subject = '';
								$send_mail_to_email_id = $query_result['email_id'];
								$send_mail_count = 0;
								$variable_array = array(
									'candidate_name' => $query_result['first_name'].' '.$query_result['last_name'],
									'login_id' => $query_result['loginId'],
									'otp' => $query_result['otp_password'],
									'client_name' => $query_result['client_name']
								);
								if (in_array(1, $schedule_days)) {
									$email_subject = 'Submission of your documents for verification';
									$send_mail_message = $this->branding_Emails_Model->send_email_to_candidate_for_pending_cases_series_1($variable_array);
									$send_mail_count++;
								} else if(in_array(3, $schedule_days)) {
									$email_subject = 'Submission of your documents for verification';
									$send_mail_message = $this->branding_Emails_Model->send_email_to_candidate_for_pending_cases_series_2($variable_array);
									$send_mail_count++;
								} else if (in_array(5, $schedule_days)) {
									$email_subject = 'Submission of your documents for verification';
									$send_mail_message = $this->branding_Emails_Model->send_email_to_candidate_for_pending_cases_series_3($variable_array);
									$send_mail_count++;
								} else if (in_array(7, $schedule_days)) {
									$email_subject = 'Your verification request is still pending!';
									$send_mail_message = $this->branding_Emails_Model->send_email_to_client_for_pending_cases($variable_array);
									if ($query_result['client_spoc_id'] != '') {
										$this->db->where('spoc_id',$query_result['client_spoc_id']);
									} else {
										$this->db->where('client_id',$query_result['client_id']);
									}
									$get_client_spoc_details = $this->db->get('tbl_clientspocdetails')->result_array();
									foreach ($get_client_spoc_details as $spoc_key => $spoc_value) {
										$this->emailModel->send_mail($spoc_value['spoc_email_id'],$email_subject,$send_mail_message);
									}

								}

								if ($send_mail_count != 0) {
									$this->emailModel->send_mail($send_mail_to_email_id,$email_subject,$send_mail_message);
								}
								// $this->emailModel->mailer($query_result['email_id'],$query_result['first_name'],$query_result['phone_number'],$query_result['client_name'],$query_result['otp_password']);
							}
						}
					}
				}
			}
		}
	}
?>