<?php
require APPPATH.'libraries/Clamav.php';
use Appwrite\ClamAV\Network;
use Appwrite\ClamAV\Pipe;
use PHPUnit\Framework\TestCase;
class TestMail extends CI_Controller
{
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url');   
	  $this->load->model('emailModel'); 
	  $this->load->library('clamav');  
	}

	function testVirus(){   
		/*if($this->clamav->scan("license.txt")) {
		    echo "YAY, file is safe!";
		} else {
		    echo "BOO, file is a virus!";
		}*/
	$clam = new Network('localhost', 3310); // Or use new Pipe() for unix socket

	$clam->ping(); // Check ClamAV is up and running

	$clam->version(); // Check ClamAV version

	$clam->fileScan('license.txt'); // Return true of false for file scan

	$clam->reload(); // Reload ClamAV database

	$clam->shutdown(); // Shutdown ClamAV
	}

	public function index(){

				$client_email_id = strtolower('viral.padvi@gmail.com');
				// Send To User Starts
				$client_email_subject = 'Credentials';

			/*	$client_email_message = '<html><body>';
				$client_email_message .= 'Hello : Test<br>';
				$client_email_message .= 'Your account has been created with factsuite team as client : <br>';
				$client_email_message .= 'Login using below credentials : <br>';
				$client_email_message .= 'Email ID : viral.padvi@gmail.com<br>';
				$client_email_message .= 'Password : 1234567<br>';
				$client_email_message .= 'Thank You,<br>';
				$client_email_message .= 'Team Factsuite Test';
				$client_email_message .= '</html></body>';*/

				$client_email_message = '';
				$client_email_message .= '<!DOCTYPE html>';
				$client_email_message .= '<html> ';
				$client_email_message .= '<head>';
				$client_email_message .= '<style>';
				$client_email_message .= 'table {';
				$client_email_message .= 'font-family: arial, sans-serif;';
				$client_email_message .= 'border-collapse: collapse;';
				$client_email_message .= 'width: 100%;';
				$client_email_message .= '}';

				$client_email_message .= 'td, th {';
				$client_email_message .= 'border: 1px solid #dddddd;';
				$client_email_message .= 'text-align: left;';
				$client_email_message .= 'padding: 8px;';
				$client_email_message .= '}';

				$client_email_message .= 'tr:nth-child(even) {';
				$client_email_message .= 'background-color: #dddddd;';
				$client_email_message .= '}';
				$client_email_message .= '</style>';
				$client_email_message .= '</head>';
				$client_email_message .= '<body> ';
				$client_email_message .= '<p>Dear “SPOC name”,</p>';
				$client_email_message .= '<p>Greetings from Factsuite!!</p>';
				$client_email_message .= '<p>At the outset we thank you for choosing Factsuite as your Employee Background Screening partner.</p>';
				$client_email_message .= '<p>We appreciate your business & hope to delight you with our efficient service offerings during our association.</p>';
				$client_email_message .= '<p>Please find the Login Credentials for your Factsuite CRM access, mentioned below- </p>';
				$client_email_message .= '<table>';
				$client_email_message .= '<th>CRM Link</th>';
				$client_email_message .= '<th>UserName</th>';
				$client_email_message .= '<th>Password</th>';
				$client_email_message .= '<tr>';
				$client_email_message .= '<td>http://localhost:8080/factsuitecrm/client</td>';
				$client_email_message .= '<td>dummy@gmail.com</td>';
				$client_email_message .= '<td>dummy@gmail</td>';
				$client_email_message .= '<tr>';
				$client_email_message .= '</table>';
				$client_email_message .= '<p><b>Yours sincerely,<br>';
				$client_email_message .= 'Team FactSuite</b></p>';
				$client_email_message .= '</body>';
				$client_email_message .= '</html>';
				$path = base_url().'../uploads/';
				$file = '3-viral_padvi-final-report.pdf';
				$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$client_email_message,$path,$file);

	}


	
}