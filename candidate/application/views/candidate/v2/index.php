<?php $login_id = 1;?>
<script>
   	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      	window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-sign-in';
   	}
</script>
<div class="container sign-in-input-div">
	<div class="row sign-in-input-inner-div">
		<div class="col-1"></div>
		<?php if ($login_id == 0) { ?>
			<div class="col-3 pr-0">
				<div class="input-wrap signin-input-wrap">
	                <select class="sign-in-input-field sign-in-input-field-2" required id="country-code">
						<option value="+91">+91 (India)</option>
						<?php foreach (json_decode($county_code,true) as $key => $value){
						if ($value['dial_code'] != '+91') { ?>
							<option value="<?php echo $value['dial_code'];?>"><?php echo $value['dial_code'].' ('.$value['name'].')';?></option>
						<?php } } ?>
					</select>
	                <span class="input-field-txt">Title</span>
	                <div id="first-name-error-v2"></div>
	            </div>
			</div>
		<?php } ?>
		<div class="col-10">
			<div class="input-wrap signin-input-wrap">
				<!-- sign-in-input-field-2 -->
                <input type="text" class="sign-in-input-field" id="contact-no" required="" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                <span class="input-field-txt">Enter Login ID</span>
                <div id="first-name-error-v2"></div>
            </div>
		</div>
		<div class="col-1"></div>
		<div class="col-1"></div>
		<div class="col-10">
			<div id="contact-no-error"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-1"></div>
		<div class="col-10">
			<button class="sign-in-btn" id="sign-in-btn">Proceed</button>
			<p class="rights-reserved-txt">
				Factsuite &#169; 2022 All Rights Reserved
			</p>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/login/candidate-login.js"></script>