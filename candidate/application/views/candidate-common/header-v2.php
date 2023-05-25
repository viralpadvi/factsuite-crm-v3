<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Personal Information</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-desktop.css">

	<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

<!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.min.css"> 

<!-- plug -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->  
  <!-- JQVMap -->
  <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/jqvmap/jqvmap.min.css"> -->
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  <!-- Theme style --> 
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/summernote/summernote-bs4.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2/css/select2.min.css">

  <!-- Font Awesome FA -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Datatables -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  
  <!-- Datepicker Css -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo base_url()?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url()?>assets/custom-js/common-validations.js"></script>
<script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";
  var link_request_from = '';
</script>

 <!-- jQuery -->
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>

</head>
<body class="bg-colored">
	<div id="bg-black" class="bg-black"></div>

	<header class="body-header">
   		<div class="container-fluid">
      		<div class="header-cnt">
         		<nav id="navbar-nav" class="navbar navbar-expand-xl navbar-light navbar-not-scrolled">
            		<a class="navbar-brand" href="#">
               			<img id="hdr-logo" class="hdr-logo" src="<?php echo base_url(); ?>assets/images/factsuite-logo.svg">
            		</a>
            		<div id="navbarNav" class="collapse navbar-collapse">
               			<div class="navbar-nav ml-auto" id="hdr-navbar-main-div">
                  			<div class="nav-item">
                     			<div class="dropdown dropdown-hdr-1">
									<button class="dropdown-hdr-btn dropdown-toggle" id="dropdown-hdr-btn" data-toggle="dropdown" aria-expanded="false">
										<span class="support-txt-hdr">Support</span>
										<img src="<?php echo base_url(); ?>assets/images/hdr-name-initial-dropdown-chevron-down.svg">
									</button>
									<ul class="dropdown-menu" id="dropdown-menu">
										<div class="dropdown-txt-hdr">Facing Trouble or Need Help..?</div>
								        <li class="dropdown-support d-none">
								        	<a href="tel:<?php echo $this->config->item('support_contact_country_code').$this->config->item('support_contact_number');?>">
								        		<div class="row">
								        			<div class="col-4">
								        				<img src="<?php echo base_url(); ?>assets/images/desktop/call-support.svg">
								        			</div>
								        			<div class="col-8 pl-0">
								        				<span class="small-txt">Call Us @</span><br>
								        				<span class="weighted-txt">
								        					<?php echo $this->config->item('support_contact_country_code').'-'.$this->config->item('support_contact_number');?></span>
								        			</div>
								        		</div>
								        	</a>
								        </li>
								        <li class="dropdown-support">
								        	<a href="mailto:<?php echo $this->config->item('support_email_id');?>">
								        		<div class="row">
								        			<div class="col-4">
								        				<img src="<?php echo base_url(); ?>assets/images/desktop/mail-support.svg">
								        			</div>
								        			<div class="col-8 pl-0">
								        				<span class="small-txt">Reach out on mail</span><br>
								        				<span class="weighted-txt"><?php echo $this->config->item('support_email_id');?></span>
								        			</div>
								        		</div>
								        	</a>
								        </li>
								    </ul>
								</div>
                  			</div>
                  			<div class="nav-item">
                     			<a class="nav-link sign-out-btn-hdr" href="<?php echo $this->config->item('my_base_url')?>logout">
                     				<span>Sign Out</span> <img src="<?php echo base_url(); ?>assets/images/desktop/logout.svg">
                     			</a>
                  			</div>
						</div>
            		</div>
      			</nav>
      		</div>
   		</div>
	</header>
