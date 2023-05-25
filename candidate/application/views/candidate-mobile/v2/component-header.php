<?php 
$header_txt = '';
$client_name = isset($client_name) ? $client_name : '';
$steps_count = '2';
if (strtolower(uri_string()) == 'm-candidate-information-step-1' || strtolower(uri_string()) == $client_name.'/m-candidate-information-step-1') {
    $header_txt = 'Personal Information';
    $steps_count = '1';
} else if (strtolower(uri_string()) == 'm-criminal-check' || strtolower(uri_string()) == $client_name.'/m-criminal-check') {
    $header_txt = 'Criminal Background Verification';
} else if (strtolower(uri_string()) == 'm-court-record-1' || strtolower(uri_string()) == $client_name.'/m-court-record-1') {
    $header_txt = 'Court Record';
} else if (strtolower(uri_string()) == 'm-document-check' || strtolower(uri_string()) == $client_name.'/m-document-check') {
    $header_txt = 'Document Check';
} else if (strtolower(uri_string()) == 'm-bankruptcy' || strtolower(uri_string()) == $client_name.'/m-bankruptcy') {
    $header_txt = 'Bankruptcy Records Search';
} else if (strtolower(uri_string()) == 'm-cv-check' || strtolower(uri_string()) == $client_name.'/m-cv-check') {
    $header_txt = 'CV Check';
} else if (strtolower(uri_string()) == 'm-landlord-reference' || strtolower(uri_string()) == $client_name.'/m-landlord-reference') {
    $header_txt = 'Previous Landlord Reference Check';
} else if (strtolower(uri_string()) == 'm-social-media' || strtolower(uri_string()) == $client_name.'/m-social-media') {
    $header_txt = 'Social Media Check';
} else if (strtolower(uri_string()) == 'm-credit-cibil' || strtolower(uri_string()) == $client_name.'/m-credit-cibil') {
    $header_txt = 'Credit History Check';
} else if (strtolower(uri_string()) == 'm-education-1' || strtolower(uri_string()) == $client_name.'/m-education-1') {
    $header_txt = 'Education Verification';
} else if (strtolower(uri_string()) == 'm-employment-gap' || strtolower(uri_string()) == $client_name.'/m-employment-gap') {
    $header_txt = 'Employment Gap check';
} else if (strtolower(uri_string()) == 'm-document-check' || strtolower(uri_string()) == $client_name.'/m-document-check') {
    $header_txt = 'Identity Verification';
} else if (strtolower(uri_string()) == 'm-drug-test' || strtolower(uri_string()) == $client_name.'/m-drug-test') {
    $header_txt = 'Drug Test';
} else if (strtolower(uri_string()) == 'm-global-database' || strtolower(uri_string()) == $client_name.'/m-global-database') {
    $header_txt = 'Global Database Check';
} else if (strtolower(uri_string()) == 'm-current-employment-1' || strtolower(uri_string()) == $client_name.'/m-current-employment-1') {
    $header_txt = 'Current Employment Verification';
} else if (strtolower(uri_string()) == 'm-present-address-1' || strtolower(uri_string()) == $client_name.'/m-present-address-1') {
    $header_txt = 'Present Address Verification';
} else if (strtolower(uri_string()) == 'm-permanent-address-1' || strtolower(uri_string()) == $client_name.'/m-permanent-address-1') {
    $header_txt = 'Permanent Address Verification';
} else if (strtolower(uri_string()) == 'm-previous-employment-1' || strtolower(uri_string()) == $client_name.'/m-previous-employment-1') {
    $header_txt = 'Previous Employment Verification';
} else if (strtolower(uri_string()) == 'm-reference' || strtolower(uri_string()) == $client_name.'/m-reference') {
    $header_txt = 'Reference Check';
} else if (strtolower(uri_string()) == 'm-previous-address-1' || strtolower(uri_string()) == $client_name.'/m-previous-address-1') {
    $header_txt = 'Previous Address Verification';
} else if (strtolower(uri_string()) == 'm-driving-licence' || strtolower(uri_string()) == $client_name.'/m-driving-licence') {
    $header_txt = 'Driving License';
} else if (strtolower(uri_string()) == 'm-additional' || strtolower(uri_string()) == $client_name.'/m-additional') {
    $header_txt = 'Additional Document';
} else if (strtolower(uri_string()) == 'm-consent-form' || strtolower(uri_string()) == $client_name.'/m-consent-form') {
    $header_txt = 'Consent Form';
    $steps_count = '3';
} ?>

<body class="bg-colored">
	<div class="container-fluid inner-page-hdr">
		<div class="row">
			<div class="col-md-9 hdr-check-name">
				<a href="<?php echo $this->config->item('my_base_url');?>m-verification-steps"><img src="<?php echo base_url(); ?>assets/images/arrow-left.svg"></a> <?php echo $header_txt;?>
			</div>
			<div class="col-md-3 hdr-steps">
				<span>Step <?php echo $steps_count;?>/3</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 hdr-support-div">
				<span data-toggle="modal" data-target="#modal-support">
					<img src="<?php echo base_url(); ?>assets/images/support-headphones.svg"> Support
				</span>
			</div>
		</div>
	</div>