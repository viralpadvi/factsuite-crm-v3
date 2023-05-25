<?php 
$header_txt = '';
if (stripos($_SERVER['REQUEST_URI'],'personal-information.php') !== false) {
	$header_txt = 'Personal Information';
} else if (stripos($_SERVER['REQUEST_URI'],'verification-form-components.php') !== false) {
	$header_txt = 'Verification Form';
} ?>
<?php include 'main-header.php';?>
<body class="bg-colored">
	<div class="container-fluid inner-page-hdr">
		<div class="row">
			<div class="col-md-9 hdr-check-name">
				<img src="<?php echo base_url(); ?>assets/images/arrow-left.svg"> <?php echo $header_txt;?>
			</div>
			<div class="col-md-3 hdr-steps">
				<span>Step 1/5</span>
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