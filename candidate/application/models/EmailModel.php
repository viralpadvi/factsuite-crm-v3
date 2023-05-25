<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class EmailModel extends CI_Model {
	
	function send_mail($mail_to,$mail_subject,$mail_message) {
		$this->db->where('mail_id','1');
			$mail_result = $this->db->get('mail_details');
			$mail_data = $mail_result->row_array();

			if (strtolower($mail_to) == 'admin') {
				$mail_to = 'brunoi.tandel@riyatsa.com';
			}
			
			// Load Email Liberary
	 		/*$this->load->library('email');
			$config['protocol']=$mail_data['protocol'];
			$config['smtp_host']=$mail_data['smtp_host'];
			$config['smtp_user']=$mail_data['smtp_user'];
			$config['smtp_pass']=base64_decode($mail_data['smtp_pass']);
			$config['smtp_port']=$mail_data['smtp_port'];
			$config['smtp_timeout']=$mail_data['smtp_timeout'];
			$config['mailtype']='html';
			$config['starttls']=TRUE;
			$config['charset']  = 'utf-8';
			$config['newline']="\r\n";

			$this->email->initialize($config);
			$this->email->to($mail_to);
			$this->email->from($mail_data['smtp_user'],$mail_data['website_name']);

			$this->email->subject($mail_subject);
			$this->email->message($mail_message);
			$send_email = $this->email->send();*/
			// echo $this->email->print_debugger();
			// print_r($send_email);
			$mail = new PHPMailer();
			$mail->Encoding = "base64";
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.zeptomail.in";
			$mail->Port = 587;
			$mail->Username = "emailapikey";
			$mail->Password = 'PHtE6r0NFOC/jmN8+hcDsKDpEMOsZost+Lk0fwNPtocUX/cGGE1WqdopkWTmqhYvUaNKEKHIntg6uL6Us+PQImvrMW4ZXGqyqK3sx/VYSPOZsbq6x00YslgedETbU4HsetBi1C3TvtjdNA==';
			$mail->SMTPSecure = 'TLS';
			$mail->isSMTP();
			$mail->IsHTML(true);
			$mail->CharSet = "UTF-8";
			// $mail->From = "support@factsuite.com";
			$mail->From = "noreply@factsuite.com";
			$mail->addAddress($mail_to);
			$mail->Body=$mail_message;
			$mail->Subject=$mail_subject;    
			// $mail->SMTPDebug = 1;
			// $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str"; echo "<br>";};
			if(!$mail->Send()) {
				return array('status'=>0);
			} else {
				return array('status'=>1);
			}
	}

	function insuffMailToCandiate($candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id){
		$body_message="
				<html>
					<head>
						<style>
							table {
								font-family: arial, sans-serif;
								border-collapse: collapse;
								width: 100%;
							}

							td, th {
								border: 1px solid #dddddd;
								text-align: left;
								padding: 8px;
							}

							tr:nth-child(even) {
								background-color: #dddddd;
							}
						</style>
					</head>
					<body>
						<p>Dear “".$candidate_name."”,</p>
						<p>Greetings from Factsuite!!</p>
						<p>An Insufficiency has been reported for the below mentioned case-</p>
						 
						<table>
							<th>Insuff Raised Date</th>
							<th>Case #</th>
							<th>Candidate Name</th>
							<th>Component Name</th>
							<th>Insuff Remarks</th>
							<tr>
							<td>".date("d-M-Y")."</td>
							<td>".$candidate_id."</td>
							<td>".$candidate_name."</td>
							<td>".$component_name."</td>
							<td>".$insuff_remarks."</td>
							<tr>
						</table>
						<p>Kindly click the link ".$this->config->item('candidate_url')." to update/upload the same, to help us complete your Background verification, at the earliest.</p>
						<p><b>Yours sincerely,<br>
						Team FactSuite</b></p>
					</body>
				</html>				
		";
		if($this->send_mail($candidate_mail_id,"Insufficient Data",$body_message)){
			return "200";
		}else{
			return "201";
		}
	}

	function insuffMailToClient($component_names,$case_data){
		$tableRow = '';
		foreach ($case_data as $key => $value) {
			$tableRow .="	<tr>
					<td>".$value['tat_pause_date']."</td>
					<td>".$value['candidate_id']."</td>
					<td>".$value['first_name']." ".$value['last_name']."</td>
					<td>".$component_names[$key]['tat_pause_date']."</td>
					<td>".$value['tat_pause_date']."</td>
				<tr>";
		}
		$body_message="
				<html>
					<head>
						<style>
							table {
								font-family: arial, sans-serif;
								border-collapse: collapse;
								width: 100%;
							}

							td, th {
								border: 1px solid #dddddd;
								text-align: left;
								padding: 8px;
							}

							tr:nth-child(even) {
								background-color: #dddddd;
							}
						</style>
					</head>
					<body>
						<p>Dear “".$candidate_name."”,</p>
						<p>Greetings from Factsuite!!</p>
						<p>An Insufficiency has been reported for the below mentioned case-</p>
						 
						<table>
							<th>Insuff Raised Date</th>
							<th>Case #</th>
							<th>Candidate Name</th>
							<th>Component Name</th>
							<th>Insuff Remarks</th>
							<tr>
							<td>".date("d-M-Y")."</td>
							<td>".$candidate_id."</td>
							<td>".$candidate_name."</td>
							<td>".$component_name."</td>
							<td>".$insuff_remarks."</td>
							<tr>
						</table>
						<p>Kindly click the link ".$this->config->item('candidate_url')." to update/upload the same, to help us complete your Background verification, at the earliest.</p>
						<p><b>Yours sincerely,<br>
						Team FactSuite</b></p>
					</body>
				</html>				
		";
		if($this->send_mail($candidate_mail_id,"Insufficient Data",$body_message)){
			return "200";
		}else{
			return "201";
		}
	}
}