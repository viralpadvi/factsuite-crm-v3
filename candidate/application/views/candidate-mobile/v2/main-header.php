<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
	<title>Candidate Details</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-v2.css">

	<!-- Toastr -->
  	<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  	<!-- Theme style --> 
  	<!-- overlayScrollbars -->
  	<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.min.css">
  	<!-- Daterange picker -->
  	<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.css">
  	<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/summernote/summernote-bs4.css"> -->
  	<!-- Select2 -->
  	<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2/css/select2.min.css">
	<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->

	<!-- Datepicker Css -->
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  	<link href="<?php echo base_url()?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

  	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  	
	<script>
  		var base_url = "<?php echo $this->config->item('my_base_url')?>";
  		var img_base_url = "<?php echo base_url()?>";
  		var link_request_from = 'link-for-mobile';
  		var link_base_url = "<?php echo $this->config->item('my_base_url')?>"+'factsuite-candidate/';
	</script>

	<!-- Suport Modal -->
	<div class="modal fade modal-support custom-modal" id="modal-support" role="dialog">
    	<div class="modal-dialog modal-dialog-bottom">
      		<div class="modal-content modal-content-top-radius">
        		<div class="modal-header">
          			<h4 class="modal-title">Support</h4>
          			<button type="button" class="close" data-dismiss="modal">
          				<img src="<?php echo base_url(); ?>assets/images/close.svg">
          			</button>
        		</div>
        		<div class="modal-body">
          			<p>For any communication You can drop a mail at <a class="link-a" href="javascript:void(0)">Factsuite@support.com</a> <!-- or call <a class="link-a no-underline" href="javascript:void(0)">@+91- 65325487856</a> -->.</p>
          			<hr>
        		</div>
      		</div>
    	</div>
  	</div>
</head>