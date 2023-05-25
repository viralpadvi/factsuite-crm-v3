
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class SmsModel extends CI_Model {
	
	function send_sms($first_name,$client_name,$ph_number,$login_otp,$messageStatus) {
		$login_link = $this->config->item('candidate_link');
		$pass_data = '';
		if($messageStatus == '1'){
			// OTP message
			// $pass_data = 'Hi '.$first_name.', this verification is initiated by '.$client_name.' as part of your Background Verification Process. Kindly click on the link to complete the task. http://onelink.to/j4yv6q Login by entering your mobile number and password:'.$login_otp.'. Thanks, Team FactSuite';
			$pass_data = 'Hi '.$first_name.', this verification is initiated by '.$client_name.' as part of your employee/tenant/support staff background verification process. Kindly click on the link to complete the task '.$login_link.'. Log in by entering your mobile number and password: '.$login_otp.'. Thanks, Team FactSuite';

		}else if($messageStatus == '2'){
			// Insuff Message
			$pass_data = 'Hi '.$first_name.', Your Background Verification is on hold due to some missing documents/ information. Kindly click the link '.$login_link.' to update/upload the same, to help us complete your Background verification. Thanks, Team FactSuite';
			
		}
		
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => 'http://sms-alerts.servetel.in/api/v4/?api_key=A25b53c27773fb73f72a71c651134b73e&method=sms&message='.urlencode($pass_data).'&to=91'.$ph_number.'&sender=FACTSU',
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_FOLLOWLOCATION => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "POST",
	    ));
	    $response = curl_exec($curl);
	    $curl_response_data = json_decode($response,true);
	    
	    if(strtolower($curl_response_data['status']) == 'ok') {
	        return $status = '200';
	    } else { 
	    	return $status = '201';
	        // $sms_error_insert = "INSERT INTO `sms_email_error_log`(`error_type`, `candidate_id`)
	        //                     VALUES (1,'".$candidate_id."')";
	        // if(mysqli_query($conncetion,$sms_error_insert)){
	        //     echo $status = '201';
	        // } else {
	        //     echo $status = '202';
	        // }
	    }
	}



	function send_insuff_sms($first_name,$ph_number) {
		$login_link = $this->config->item('candidate_link');
	 
		// Insuff Message
		// $pass_data = 'Hi '.$first_name.', Your Background Verification is on hold due to some missing documents/ information. Kindly click the link http://onelink.to/j4yv6q to update/upload the same, to help us complete your Background verification. Thanks, Team FactSuite';
		$pass_data = 'Hi '.$first_name.', Your Background Verification is on hold due to some missing documents/ information. Kindly click the link '.$login_link.' to update/upload the same, to help us complete your Background verification. Thanks, Team FactSuite';
			
		 
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => 'http://sms-alerts.servetel.in/api/v4/?api_key=A25b53c27773fb73f72a71c651134b73e&method=sms&message='.urlencode($pass_data).'&to=91'.$ph_number.'&sender=FACTSU',
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_FOLLOWLOCATION => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "POST",
	    ));
	    $response = curl_exec($curl);
	    $curl_response_data = json_decode($response,true);
	    
	    if(strtolower($curl_response_data['status']) == 'ok') {
	        return $status = '200';
	    } else { 
	    	return $status = '201';
	        // $sms_error_insert = "INSERT INTO `sms_email_error_log`(`error_type`, `candidate_id`)
	        //                     VALUES (1,'".$candidate_id."')";
	        // if(mysqli_query($conncetion,$sms_error_insert)){
	        //     echo $status = '201';
	        // } else {
	        //     echo $status = '202';
	        // }
	    }
	}

/*report generate*/
	function send_complete_sms($first_name,$ph_number) {
		
	 
		// Insuff Message
		$pass_data = 'Hi '.$first_name.', we have completed your verification request. Please login to your profile on our website and download the verification report. Thanks, Team FactSuite';
			
		 
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => 'http://sms-alerts.servetel.in/api/v4/?api_key=A25b53c27773fb73f72a71c651134b73e&method=sms&message='.urlencode($pass_data).'&to=91'.$ph_number.'&sender=FACTSU',
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_FOLLOWLOCATION => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "POST",
	    ));
	    $response = curl_exec($curl);
	    $curl_response_data = json_decode($response,true);
	    
	    if(strtolower($curl_response_data['status']) == 'ok') {
	        return $status = '200';
	    } else { 
	    	return $status = '201';
	        // $sms_error_insert = "INSERT INTO `sms_email_error_log`(`error_type`, `candidate_id`)
	        //                     VALUES (1,'".$candidate_id."')";
	        // if(mysqli_query($conncetion,$sms_error_insert)){
	        //     echo $status = '201';
	        // } else {
	        //     echo $status = '202';
	        // }
	    }
	}



	function rendomNumber($digits){
		return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
    	 
	}
}