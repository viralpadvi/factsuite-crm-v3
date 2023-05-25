<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

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

<title>Factsuite - Candidate</title>
</head>
<body>
  <!--  <div class="for-mobile">
      <div class="container only-for-desktop-txt-div">
         <h1>This platform currently supports login from a web browser only. Please use a Desktop browser to fill the form.</h1>
      </div>
   </div> -->
   <!-- class="for-desktop" -->
<div>
<header>
   <div class="header-lft">
      <div class="header-logo"><img src="<?php echo base_url(); ?>assets/images/FactSuite-logo.png" /></div>
   </div>
   <div class="header-rgt">
      <div class="header-mn">
         <button class="saved-btn d-none"><i class="fa fa-check"></i> Saved</button> 
         <a href="<?php echo $this->config->item('my_base_url')?>logout" id="logout-hdr" class="exit-btn">Exit</a>
      </div>
   </div>
   <div class="clr"></div>
</header>
<section id="page">

