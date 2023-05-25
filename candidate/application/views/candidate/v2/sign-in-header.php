<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign In</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-desktop.css">

	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Toastr -->
  	<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  	
	<script>
  		var base_url = "<?php echo $this->config->item('my_base_url')?>",
  			img_base_url = "<?php echo base_url()?>";
	</script>
</head>
<body class="bg-colored">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-7 sign-in-bg-1">
				<div class="sign-in-left-section">
					<img src="<?php echo base_url(); ?>assets/images/desktop/sign-in-img.svg">
					<h2>Welcome to FactSuite</h2>
					<p>Factsuite employee background verification are quick and reliable.</p>
				</div>
			</div>
			<div class="col-md-5 sign-in-bg-2">
				<div class="sign-in-main-div">
					<img src="<?php echo base_url(); ?>assets/images/factsuite-logo.svg">
					<p class="fs-slogan">
						Better Decisions, Made easy
					</p>