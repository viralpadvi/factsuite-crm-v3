<?php $login_id = 1;?>
<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>';
   }
</script> 
	<div class="container sign-in-bg">
		<img src="assets/images/sign-in-bg.svg" class="sign-in-bg-img">
		<div class="text-center">
			<img src="assets/images/sign-in-img.gif" class="sign-in-icon-img">
			<span class="e-form-txt">Sign in to fill the E form <br>application</span>
		</div>
		<div class="enter-mobile-number-otp-div row">
			<?php if ($login_id == 0) { ?>
				<div class="col-md-3 enter-mobile-number-select-country-code-div">
					<select class="sign-in-input-field" id="country-code">
						<option value="+91">+91 (India)</option>
						<?php foreach (json_decode($county_code,true) as $key => $value){
							if ($value['dial_code'] != '+91') { ?>
							<option value="<?php echo $value['dial_code'];?>"><?php echo $value['dial_code'].' ('.$value['name'].')';?></option>
						<?php } } ?>
					</select>
				</div>
			<?php } ?>
			<!-- enter-mobile-number-enter-mobile-number-div -->
			<div class="col-md-12">
				<div class="input-wrap">
	                <input type="text" class="sign-in-input-field" id="contact-no" required="" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
	                <span class="input-field-txt">Enter Login ID</span>
	                <div id="contact-no-error"></div>
	            </div>
			</div>
		</div>
		<div class="row sign-in-btn-div">
			<span>We’ll send you a OTP to sign in.</span>
			<!-- disabled -->
			<button class="sign-in-btn" id="sign-in-btn">
				<img src="assets/images/sign-in-otp-btn-img.svg">
				Send OTP
			</button>
		</div>
	</div>


<script src="<?php echo base_url(); ?>assets/custom-js/login/candidate-login.js"></script>