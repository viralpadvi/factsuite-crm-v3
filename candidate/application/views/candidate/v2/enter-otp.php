<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-verify-otp';
   }
   var link_request_from = '';
</script>

<div class="container sign-in-input-div">
	<div class="row">
		<div class="col-2"></div>
		<div class="col-2">
			<input type="text" class="sign-in-otp-input-field" id="otp1" maxlength="1" onkeyup="moveOnMax(this,'otp2')" autofocus oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
		</div>
		<div class="col-2">
			<input type="text" class="sign-in-otp-input-field" id="otp2" maxlength="1" onkeyup="moveOnMax(this,'otp3')" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
		</div>
		<div class="col-2">
			<input type="text" class="sign-in-otp-input-field" id="otp3" maxlength="1" onkeyup="moveOnMax(this,'otp4')" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
		</div>
		<div class="col-2">
			<input type="text" class="sign-in-otp-input-field" id="otp4" maxlength="1" onkeyup="moveOnMax(this,'otp1')" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
		</div>
		<div class="col-2"></div>
		<div class="col-1"></div>
		<div class="col-10">
			<span id="invelid-otp-error" class="text-danger"></span>
		</div>
		<div class="col-10 text-right">
			<div class="resend-otp-div">
				<?php $show_1 = 1;
              	if ($show_1 == 1) { ?>
              		<div id="otp-sec" class="resend-otp"></div>
               	<?php } ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-1"></div>
		<div class="col-10">
			<button class="sign-in-btn" id="sign-in-btn">Submit</button>
			<p class="rights-reserved-txt">
				Factsuite &#169; 2022 All Rights Reserved
			</p>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/login/candidate-otp.js"></script>