<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/sign-in';
   }
   var link_request_from = 'link-for-mobile';
</script> 
<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">

	<div class="container sign-in-bg">
		<img src="<?php echo base_url(); ?>assets/images/sign-in-bg.svg" class="sign-in-bg-img">
		<div class="text-center">
			<img src="<?php echo base_url(); ?>assets/images/otp-img.gif" class="sign-in-icon-img">
			<span class="e-form-txt">Sign in to fill the E form <br>application</span>
		</div>
		<div class="enter-mobile-number-otp-div enter-otp-main-div row">
			<div class="col-md-3 enter-mobile-number-otp-inner-div">
	            <input type="number" maxlength="1" class="sign-in-otp-input-field" id="otp1" onkeyup="moveOnMax(this,'otp2')" autofocus>
			</div>
			<div class="col-md-3 enter-mobile-number-otp-inner-div">
	            <input type="number" class="sign-in-otp-input-field" id="otp2" maxlength="1" onkeyup="moveOnMax(this,'otp3')">
			</div>
			<div class="col-md-3 enter-mobile-number-otp-inner-div">
	            <input type="number" class="sign-in-otp-input-field" id="otp3" maxlength="1" onkeyup="moveOnMax(this,'otp4')">
			</div>
			<div class="col-md-3 enter-mobile-number-otp-inner-div">
	            <input type="number" class="sign-in-otp-input-field" id="otp4" maxlength="1" onkeyup="moveOnMax(this,'otp5')">
			</div>
			<div class="col-md-12">
				 <div id="invelid-otp-error"></div>
			</div>
			<div class="resend-otp-div">
				<a id="otp-sec" class="resend-otp"></a>
			</div>
		</div>
		<div class="row sign-in-btn-div">
			<button class="sign-in-btn" id="sign-in-btn">
				Submit
			</button>
		</div>
	</div>

 
<script src="<?php echo base_url(); ?>assets/custom-js/login/candidate-otp.js"></script>

<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>