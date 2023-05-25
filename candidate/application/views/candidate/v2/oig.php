 					 <input name="" class="fld form-control oig_id" value="<?php echo isset($table['oig']['oig_id'])?$table['oig']['oig_id']:''; ?>" id="oig_id" type="hidden">
					<div class="row">
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  first-name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['oig']['first_name'])?$table['oig']['first_name']:$user['first_name']; ?>" id="first-name" type="text">
				                <span class="input-field-txt">First name </span>
                  				<div id="first-name-error">&nbsp;</div> 
				            </div>
						</div>
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['oig']['last_name'])?$table['oig']['last_name']:$user['last_name']; ?>" id="last-name" type="text">
				                <span class="input-field-txt">Last name </span>
                  				<div id="last-name-error">&nbsp;</div> 
				            </div>
						</div> 
						  
					</div>
				
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="candidate-oig"  class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
 

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-oig.js" ></script>
