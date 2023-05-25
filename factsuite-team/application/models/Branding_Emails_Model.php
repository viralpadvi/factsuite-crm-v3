<?php
	class Branding_Emails_Model extends CI_Model {
		
		function __construct() {
			parent::__construct();
    		$this->load->model('load_Database_Model');  
		}

		function send_case_completed_mail_to_client($variable_array) {
			$client_name = $variable_array['client_name'];
			$candidate_details_added_from = $variable_array['candidate_details_added_from'];
			$contact_us_details = $variable_array['contact_us_details'];

			$client_email_message = '<!DOCTYPE html>';
			$client_email_message .= '<html>';
			$client_email_message .= '<head>';
			$client_email_message .= '<meta charset="utf-8">';
			$client_email_message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
			$client_email_message .= '</head>';
			$client_email_message .= '<body>';
			$client_email_message .= '<table class="main-table-class" style="max-width: 600.0px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tr class="mail-description-main-div" style="background: #e5f4f9;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  600.0px; " cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width :  100%; visibility :  visible; " id="1664442760896110003_imgsrc_url_0" src="'.base_url().'assets/images/email-branding-images/completion-of-case.png" width="100%">';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  550.0px; margin-top: 20px; margin-bottom: 20px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<div class="x_-1989897427mail-description" style="max-width: 550.0px; margin: 0px auto; color: rgb(93, 81, 117); font-size: 15px;">';
			$client_email_message .= '<p class="x_-1989897427mail-description-bold" style="font-weight: bold; color: rgb(61, 42, 86);">Hi '.$client_name.',</p>';
			$client_email_message .= '<p style="">Greetings from Factsuite!! <br style=""></p>';
			$client_email_message .= '<p style="">As informed earlier, our superheroes had been at work and collaborated with various teams to finish your verification process requirement as soon as possible. We thank you for your support during the verification process. <br style=""></p>';
			$client_email_message .= '<p style="">We are grateful for choosing us as your verification partner. <br style=""></p>';
			$client_email_message .= '<p style="">Please log in to your profile on our website <span class="mail-description-bold color-yellow" style="font-weight: bold; color: #f1a10e;">';
			if ($candidate_details_added_from == '0') {
				$client_email_message .= $this->config->item('factsuite_website_main_url');
			} else {
				$client_email_message .= base_url().'client';
			}
			$client_email_message .= '</span> and download the verification report.<br style=""></p>';
			$client_email_message .= '<p style="">In case of any queries, please reach out ot us at '.$this->config->item('email_for_mails').'<br style=""><b style="">Yours sincerely, <br style=""> Team FactSuite </b></p><br style="">';
			$client_email_message .= '</div>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '</tbody>';
			$client_email_message .= '</table>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '<tr>';
			$client_email_message .= '<td>';
			$client_email_message .= $this->get_branding_email_footer();

			return $client_email_message;
		}

		function send_email_to_candidate_for_pending_cases_series_1($variable_array) {
			$client_email_message = '<!DOCTYPE html>';
			$client_email_message .= '<html>';
			$client_email_message .= '<head>';
			$client_email_message .= '<meta charset="utf-8">';
			$client_email_message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
			$client_email_message .= '</head>';
			$client_email_message .= '<body>';
			$client_email_message .= '<table class="main-table-class" style="max-width: 600.0px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tr class="mail-description-main-div" style="background: #e5f4f9;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  600.0px; " cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width :  100%; visibility :  visible; " id="1664442760896110003_imgsrc_url_0" src="'.base_url().'assets/images/email-branding-images/email-to-candidate-for-not-filled-up-form-series-1.png" width="100%">';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  550.0px; margin-top: 20px; margin-bottom: 20px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<div class="x_-1989897427mail-description" style="max-width: 550.0px; margin: 0px auto; color: rgb(93, 81, 117); font-size: 15px;">';
			$client_email_message .= '<p class="x_-1989897427mail-description-bold" style="font-weight: bold; color: rgb(61, 42, 86);">Hi '.$variable_array['candidate_name'].',</p>';
			$client_email_message .= '<p style="">We have noticed that you haven’t completed your verification process initiated by '.$variable_array['client_name'].'. <br style=""></p>';
			$client_email_message .= '<p style="">Kindly click on the link '.$this->config->item('candidate_url').' to complete the task at the earliest. <br>Login by entering your Login ID : '.$variable_array['login_id'].' and password : '.$variable_array['otp'].'</p>';
			$client_email_message .= '<p style=""><br style=""><b style="">Thanks, <br style=""> Team FactSuite </b></p><br style="">';
			$client_email_message .= '</div>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '</tbody>';
			$client_email_message .= '</table>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '<tr>';
			$client_email_message .= '<td>';
			$client_email_message .= $this->get_branding_email_footer();

			return $client_email_message;
		}

		function send_email_to_candidate_for_pending_cases_series_2($variable_array) {
			$client_email_message = '<!DOCTYPE html>';
			$client_email_message .= '<html>';
			$client_email_message .= '<head>';
			$client_email_message .= '<meta charset="utf-8">';
			$client_email_message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
			$client_email_message .= '</head>';
			$client_email_message .= '<body>';
			$client_email_message .= '<table class="main-table-class" style="max-width: 600.0px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tr class="mail-description-main-div" style="background: #e5f4f9;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  600.0px; " cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width :  100%; visibility :  visible; " id="1664442760896110003_imgsrc_url_0" src="'.base_url().'assets/images/email-branding-images/email-to-candidate-for-not-filled-up-form-series-2.png" width="100%">';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  550.0px; margin-top: 20px; margin-bottom: 20px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<div class="x_-1989897427mail-description" style="max-width: 550.0px; margin: 0px auto; color: rgb(93, 81, 117); font-size: 15px;">';
			$client_email_message .= '<p class="x_-1989897427mail-description-bold" style="font-weight: bold; color: rgb(61, 42, 86);">Reminder!</p>';
			$client_email_message .= '<p class="x_-1989897427mail-description-bold" style="font-weight: bold; color: rgb(61, 42, 86);">Hi '.$variable_array['candidate_name'].',<br style=""></p>';
			$client_email_message .= '<p style="">We have noticed that you still haven’t completed your verification process initiated by '.$variable_array['client_name'].'. <br style=""></p>';
			$client_email_message .= '<p style="">Kindly click on the link '.$this->config->item('candidate_url').' to complete the task at the earliest.<br>Login by entering your Login ID : '.$variable_array['login_id'].' and password : '.$variable_array['otp'].'</p>';
			$client_email_message .= '<p style=""><br style=""><b style="">Thanks, <br style=""> Team FactSuite </b></p><br style="">';
			$client_email_message .= '</div>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '</tbody>';
			$client_email_message .= '</table>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '<tr>';
			$client_email_message .= '<td>';
			$client_email_message .= $this->get_branding_email_footer();

			return $client_email_message;
		}

		function send_email_to_candidate_for_pending_cases_series_3($variable_array) {
			$client_email_message = '<!DOCTYPE html>';
			$client_email_message .= '<html>';
			$client_email_message .= '<head>';
			$client_email_message .= '<meta charset="utf-8">';
			$client_email_message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
			$client_email_message .= '</head>';
			$client_email_message .= '<body>';
			$client_email_message .= '<table class="main-table-class" style="max-width: 600.0px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tr class="mail-description-main-div" style="background: #e5f4f9;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  600.0px; " cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width :  100%; visibility :  visible; " id="1664442760896110003_imgsrc_url_0" src="'.base_url().'assets/images/email-branding-images/email-to-candidate-for-not-filled-up-form-series-3.png" width="100%">';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  550.0px; margin-top: 20px; margin-bottom: 20px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<div class="x_-1989897427mail-description" style="max-width: 550.0px; margin: 0px auto; color: rgb(93, 81, 117); font-size: 15px;">';
			$client_email_message .= '<p class="x_-1989897427mail-description-bold" style="font-weight: bold; color: rgb(61, 42, 86);">Final Reminder!</p>';
			$client_email_message .= '<p class="x_-1989897427mail-description-bold" style="font-weight: bold; color: rgb(61, 42, 86);">Hi '.$variable_array['candidate_name'].',</p>';
			$client_email_message .= '<p style="">You have still not completed your verification process initiated by '.$variable_array['client_name'].'. <br style=""></p>';
			$client_email_message .= '<p style="">Kindly click on the link '.$this->config->item('candidate_url').' to complete the task immediately and have your verification completed. <br style="">Login by entering your Login ID : '.$variable_array['login_id'].' and password : '.$variable_array['otp'].'</p>';
			$client_email_message .= '<p style=""><br style=""><b style="">Thanks, <br style=""> Team FactSuite </b></p><br style="">';
			$client_email_message .= '</div>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '</tbody>';
			$client_email_message .= '</table>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '<tr>';
			$client_email_message .= '<td>';
			$client_email_message .= $this->get_branding_email_footer();

			return $client_email_message;
		}

		function send_email_to_client_for_pending_cases($variable_array) {
			$client_email_message = '<!DOCTYPE html>';
			$client_email_message .= '<html>';
			$client_email_message .= '<head>';
			$client_email_message .= '<meta charset="utf-8">';
			$client_email_message .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
			$client_email_message .= '</head>';
			$client_email_message .= '<body>';
			$client_email_message .= '<table class="main-table-class" style="max-width: 600.0px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tr class="mail-description-main-div" style="background: #e5f4f9;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  600.0px; " cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width :  100%; visibility :  visible; " id="1664442760896110003_imgsrc_url_0" src="'.base_url().'assets/images/email-branding-images/email-to-client-for-candidate-not-filled-up-form-after-series-3.png" width="100%">';
			$client_email_message .= '<table class="x_-1989897427main-table-class" style="max-width :  550.0px; margin-top: 20px; margin-bottom: 20px;" cellspacing="0" cellpadding="0" border="0" align="center">';
			$client_email_message .= '<tbody>';
			$client_email_message .= '<tr class="x_-1989897427mail-description-main-div" style="background: rgb(229, 244, 249) none repeat scroll 0% 0%;">';
			$client_email_message .= '<td>';
			$client_email_message .= '<div class="x_-1989897427mail-description" style="max-width: 550.0px; margin: 0px auto; color: rgb(93, 81, 117); font-size: 15px;">';
			$client_email_message .= '<p class="x_-1989897427mail-description-bold" style="font-weight: bold; color: rgb(61, 42, 86);">Hi '.$variable_array['client_name'].',</p>';
			$client_email_message .= '<p style="">Please note that the verification request initiated for '.$variable_array['candidate_name'].' is still not processed as the required information is pending from '.$variable_array['candidate_name'].'.<br style=""></p>';
			$client_email_message .= '<p style="">Kindly influence '.$variable_array['candidate_name'].' to submit the details immediately.</p>';
			$client_email_message .= '<p style=""><br style=""><b style="">Thanks, <br style=""> Team FactSuite </b></p><br style="">';
			$client_email_message .= '</div>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '</tbody>';
			$client_email_message .= '</table>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '<tr>';
			$client_email_message .= '<td>';
			$client_email_message .= $this->get_branding_email_footer();

			return $client_email_message;
		}

		function get_branding_email_footer() {
			$db_fs_website = $this->load_Database_Model->load_database();
			$contact_us_details = $db_fs_website->where('contact_us_id','1')->get('contact_us_details')->row_array();

			$client_email_message = '<div class="x_-1989897427footer" style="background: rgb(52, 31, 77) none repeat scroll 0% 0%; padding: 15px 0px; width: 100%; text-align: center; color: rgb(255, 255, 255);">';
			$client_email_message .= '<div class="x_-1989897427ftr-social-media-hdr" style="font-size: 15px;">follow us on social media for more updates: <br style="">';
			$client_email_message .= '</div>';
			$client_email_message .= '<table class="x_-1989897427ftr-social-media-tbl" style="width: 100%; margin: 10px auto;background: rgb(52, 31, 77) none repeat scroll 0% 0%;" align="center">';
			$client_email_message .= '<tbody style="">';
			  $client_email_message .= '<tr style="">';
			  $client_email_message .= '<td style="">';
			$client_email_message .= '<table class="x_-1989897427ftr-social-media-tbl" style="width: 30%; margin: 10px auto;background: rgb(52, 31, 77) none repeat scroll 0% 0%;" align="center">';
			$client_email_message .= '<tbody style="">';
			$client_email_message .= '<tr style="">';
			$client_email_message .= '<td style="">';
			$client_email_message .= '<a href="'.$contact_us_details['facebook_link'].'" style="">';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width: 100%; visibility: visible;" id="1664442760896110003_imgsrc_url_1" src="'.base_url().'assets/images/email-branding-images/facebook.png" width="100%">';
			$client_email_message .= '</a>';
			$client_email_message .= '<br style="">';
			$client_email_message .= '</td>';
			$client_email_message .= '<td style="">';
			$client_email_message .= '<a href="'.$contact_us_details['twitter_link'].'" style="">';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width: 100%; visibility: visible;" id="1664442760896110003_imgsrc_url_2" src="'.base_url().'assets/images/email-branding-images/twitter.png" width="100%">';
			$client_email_message .= '</a>';
			$client_email_message .= '<br style="">';
			$client_email_message .= '</td>';
			$client_email_message .= '<td style="">';
			$client_email_message .= '<a href="'.$contact_us_details['linkedin_link'].'" style="">';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width: 100%; visibility: visible;" id="1664442760896110003_imgsrc_url_3" src="'.base_url().'assets/images/email-branding-images/linkedin.png" width="100%">
			</a>';
			$client_email_message .= '<br style="">';
			$client_email_message .= '</td>';
			$client_email_message .= '<td style="">';
			$client_email_message .= '<a href="'.$contact_us_details['instagram_link'].'" style="">';
			$client_email_message .= '<img class="x_-1989897427w-100" style="width: 100%; visibility: visible;" id="1664442760896110003_imgsrc_url_4" src="'.base_url().'assets/images/email-branding-images/instagram.png" width="100%"></a>';
			$client_email_message .= '<br style="">';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '</tbody>';
			$client_email_message .= '</table>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '</tbody>';
			$client_email_message .= '</table>';
			$client_email_message .= '<div class="x_-1989897427ftr-copy" style="">Factsuite © '.date("Y").' All Rights Reserved <br style="">';
			$client_email_message .= '</div>';
			$client_email_message .= '</div>';
			$client_email_message .= '</td>';
			$client_email_message .= '</tr>';
			$client_email_message .= '</tbody>';
			$client_email_message .= '</table>';
			$client_email_message .= '</body>';
			$client_email_message .= '</html>';

			return $client_email_message;
		}
	}

?>