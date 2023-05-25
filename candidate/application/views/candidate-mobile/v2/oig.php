<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-oig';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
				<input name="" class="fld form-control oig_id" value="<?php echo isset($table['oig']['oig_id'])?$table['oig']['oig_id']:''; ?>" id="oig_id" type="hidden">
				<div class="row content-div-content-row-1">
					 <div class="col-12"><span class="input-main-hdr">OIG</span></div>
					<div class="col-12"><span class="input-main-hdr">First Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap"> 
							<input name="" class="sign-in-input-field name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['oig']['first_name'])?$table['oig']['first_name']:$user['first_name']; ?>" id="first-name" type="text" required>
			            	<span class="input-field-txt">First Name</span>
			            	<div id="first-name-error"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Last Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap"> 
		                  <input name="" class="sign-in-input-field last_name" disabled  onkeyup="valid_last_name()" value="<?php echo isset($table['oig']['last_name'])?$table['oig']['last_name']:$user['last_name']; ?>" id="last-name" type="text" required>
			            	<span class="input-field-txt">Last Name</span> 
            				<div id="last-name-error"></div>
			         	</div>
					</div>
				</div>
				 
			<div class="row">
				<!-- disabled -->
				<div class="col-12"> 
				<button id="candidate-oig"  class="save-btn"> 
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-oig.js" ></script>