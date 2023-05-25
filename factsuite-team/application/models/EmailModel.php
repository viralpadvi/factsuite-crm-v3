<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class EmailModel extends CI_Model {
	
	function get_mail_details($version = 1) {
		if($version == 1) {
			return $this->db->get('mail_details')->row_array();
		} else {
			return $this->db->get('mail_details_2')->row_array();
		}
	}

	function send_mail($mail_to,$mail_subject,$mail_message,$path='',$file='') {
		$mail_details = $this->get_mail_details(2);

		if (strtolower($mail_to) == 'admin') {
			$mail_to = 'viral@riyatsa.com';
		}
 
		
		$mail = new PHPMailer();
		$mail->Encoding = $mail_details['encoding'];
		$mail->SMTPAuth = true;
		$mail->Host = $mail_details['host'];
		$mail->Port = $mail_details['port'];
		$mail->Username = $mail_details['username'];
		$mail->Password = $mail_details['password'];
		$mail->SMTPSecure = $mail_details['smtp_secure'];
		$mail->isSMTP();
		$mail->IsHTML(true);
		$mail->CharSet = $mail_details['charset'];
		// $mail->From = "support@factsuite.com";
		$mail->From = $mail_details['from_mail_id'];
		$mail->addAddress(strtolower($mail_to));
		$mail->Body=$mail_message;
		$mail->Subject=$mail_subject; 
		if ($path !='' && $file !='') { 
			$mail->AddAttachment( $path.$file , $file); 
		}  
		// $mail->SMTPDebug = 1;
		// $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str"; echo "<br>";};
		if(!$mail->Send()) {
		    // echo "Mail sending failed";
		} else {
		    // echo "Successfully sent";
		    // return array('status'=>0);
		}
		return array('status'=>1);
	}

	function send_mail_v2($variable_array) {
		$mail_details = $this->get_mail_details(2);

		if (strtolower($variable_array['mail_to']) == 'admin') {
			$mail_to = 'brunoi.tandel@riyatsa.com';
		}
		
		$mail = new PHPMailer();
		$mail->Encoding = $mail_details['encoding'];
		$mail->SMTPAuth = true;
		$mail->Host = $mail_details['host'];
		$mail->Port = $mail_details['port'];
		$mail->Username = $mail_details['username'];
		$mail->Password = $mail_details['password'];
		$mail->SMTPSecure = $mail_details['smtp_secure'];
		$mail->isSMTP();
		$mail->IsHTML(true);
		$mail->CharSet = $mail_details['charset'];
		$mail->From = $mail_details['from_mail_id'];
		$mail->addAddress($variable_array['mail_to']);
		$mail->Body = $variable_array['mail_message'];
		$mail->Subject = $variable_array['mail_subject'];
		if (isset($variable_array['attachment_available']) && $variable_array['attachment_available'] == 1 && isset($variable_array['attachment_files']) && $variable_array['attachment_files'] != '') {
			$mail->addAttachment($variable_array['attachment_files'].$variable_array['attach_file_name']);
		}
		// $mail->SMTPDebug = 1;
		// $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str"; echo "<br>";};
		if($mail->Send()) {
			return 1;
		} else {
			return 0;
		}
	}

	function send_mail_v3($variable_array) {
		$mail_details = $this->get_mail_details(2);

		$mail_to = $variable_array['mail_to'];
		if ($variable_array['mail_to'] == 'admin') {
			$mail_to = 'brunoi.tandel@riyatsa.com';
		}
		
		$mail = new PHPMailer();
		$mail->Encoding = $mail_details['encoding'];
		$mail->SMTPAuth = true;
		$mail->Host = $mail_details['host'];
		$mail->Port = $mail_details['port'];
		$mail->Username = $mail_details['username'];
		$mail->Password = $mail_details['password'];
		$mail->SMTPSecure = $mail_details['smtp_secure'];
		$mail->isSMTP();
		$mail->IsHTML(true);
		$mail->CharSet = $mail_details['charset'];
		$mail->From = $mail_details['from_mail_id'];
		foreach ($mail_to as $key => $value) {
			$mail->addAddress($value);
		}
		$mail->Body = $variable_array['mail_message'];
		if (isset($variable_array['add_to_cc']) && $variable_array['add_to_cc'] == 1) {
			$mail->AddCC($variable_array['cc_mail_id']);
		}
		$mail->Subject = $variable_array['mail_subject'];
		if (isset($variable_array['attachment_available']) && $variable_array['attachment_available'] == 1 && isset($variable_array['attachment_file_link']) && $variable_array['attachment_file_link'] != '') {
			$mail->addAttachment($variable_array['attachment_file_link'].$variable_array['attach_file_name']);
		}
		// $mail->SMTPDebug = 1;
		// $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str"; echo "<br>";};
		if($mail->Send()) {
			return 1;
		} else {
			return 0;
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
				</html>";
		if($this->send_mail($candidate_mail_id,"Insufficient Data",$body_message)){
			return "200";
		} else {
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
				</html>";
		if($this->send_mail($candidate_mail_id,"Insufficient Data",$body_message)){
			return "200";
		} else {
			return "201";
		}
	}

	function mailler($v1,$v2,$v3,$v4,$v5){
		$email_message ='';
			$email_message .= '<html> ';
				$email_message .= '<head>';
				$email_message .= '<style>';
				$email_message .= 'table {';
				$email_message .= 'font-family: arial, sans-serif;';
				$email_message .= 'border-collapse: collapse;';
				$email_message .= 'width: 100%;';
				$email_message .= '}';

				$email_message .= 'td, th {';
				$email_message .= 'border: 1px solid #dddddd;';
				$email_message .= 'text-align: left;';
				$email_message .= 'padding: 8px;';
				$email_message .= '}';

				$email_message .= 'tr:nth-child(even) {';
				$email_message .= 'background-color: #dddddd;';
				$email_message .= '}';
				$email_message .= '</style>';
				$email_message .= '</head>';
				$email_message .= '<body> ';
				$email_message .= "<p>Dear ".$name."</p>";
				$email_message .= '<p>Greetings from Factsuite!!</p>';
				 
					$email_message .= '<p>To proceed with the '.ucwords($v1).' verification, we request you to kindly fill the information as requested on the Factsuite CRM application.</p>';
			 
				$email_message .= '<p>In case of any queries, please reach out to us at help@factsuite.com</p>'; 
				$email_message .= '<p>Please find your Login Credentials mentioned below to access the FactSuite CRM:</p>';
				$email_message .= '<table>';
				$email_message .= '<th>CRM Link</th>';
				$email_message .= '<th>Mobile Number</th>';
				$email_message .= '<th>OTP</th>';
				$email_message .= '<tr>';
				$email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
				$email_message .= '<td>'.$v3.'</td>';
				$email_message .= '<td>'.$v5.'</td>';
				$email_message .= '<tr>';
				$email_message .= '</table>';
				$email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free screening of your profile.</p>';
				$email_message .= '<p><b>Yours sincerely,<br>';
				$email_message .= 'Team FactSuite</b></p>';
				$email_message .= '</body>';
			$email_message .= '</html>';


			$this->send_mail($v1,"Form Fill Reminder",$email_message,$path='',$file='');
	}

	function dynamic_email_template_add_values($variable_array) {
		$start_html = $end_html = '';
		if (isset($variable_array['add_html_tags']) && $variable_array['add_html_tags'] == 1) {
			$start_html = '<!DOCTYPE html>';
			$start_html .= '<html>';
			$start_html .= '<head>';
			$start_html .= '<title>Page Title</title>';
			$start_html .= '</head>';
			$start_html .= '<body>';

			$end_html = '</body></html>';
		}

		$form_fields = json_decode(file_get_contents(base_url().'assets/custom-js/json/form-fields.json'),true);
		$form_fields_id  = array_column($form_fields, 'id');
		array_multisort($form_fields_id, SORT_ASC, $form_fields);

		$replace_strings = [];
		$replace_strings_dynamic_data = [];

		$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('candidate')->row_array();
		if ($candidate_details != '') {
			$client_details = $this->db->where('client_id',$candidate_details['client_id'])->get('tbl_client')->row_array();

			foreach ($form_fields as $key => $value) {
				array_push($replace_strings, $this->config->item('form_field_prefix').$value['show_field_name']);
				if ($value['id'] == 1) {
					array_push($replace_strings_dynamic_data, $candidate_details['first_name']);
				} else if ($value['id'] == 2) {
					array_push($replace_strings_dynamic_data, $candidate_details['last_name']);
				} else if ($value['id'] == 3) {
					array_push($replace_strings_dynamic_data, $candidate_details['father_name']);
				} else if ($value['id'] == 4) {
					array_push($replace_strings_dynamic_data, $candidate_details['phone_number']);
				} else if ($value['id'] == 5) {
					array_push($replace_strings_dynamic_data, $candidate_details['email_id']);
				} else if ($value['id'] == 6) {
					array_push($replace_strings_dynamic_data, $candidate_details['employee_id']);
				} else if ($value['id'] == 7) {
					array_push($replace_strings_dynamic_data, $client_details['client_name']);
				} else if ($value['id'] == 8) {
					array_push($replace_strings_dynamic_data, isset($variable_array['spoc_email_id']) ? $variable_array['spoc_email_id'] : ' ');
				} else if ($value['id'] == 9) {
					array_push($replace_strings_dynamic_data, $this->config->item('candidate_url'));
				} else if ($value['id'] == 10) {
					array_push($replace_strings_dynamic_data, $candidate_details['first_name'].' '.$candidate_details['last_name']);
				} else if ($value['id'] == 11) {
					array_push($replace_strings_dynamic_data, $candidate_details['otp_password']);
				} else if ($value['id'] == 12) {
					array_push($replace_strings_dynamic_data, $candidate_details['loginId']);
				}
			}
		}
		
		$email_message =  str_replace($replace_strings, $replace_strings_dynamic_data, $variable_array['template']);
		$variable_array_1 = array(
			'template' => $start_html.$email_message.$end_html
		);
		return $variable_array_1;
	}
}