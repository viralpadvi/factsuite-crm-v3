 					 <input name="" class="fld form-control gsa_id" value="<?php echo isset($table['gsa']['gsa_id'])?$table['gsa']['gsa_id']:''; ?>" id="gsa_id" type="hidden">
					<div class="row">
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  first-name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['gsa']['first_name'])?$table['gsa']['first_name']:$user['first_name']; ?>" id="first-name" type="text">
				                <span class="input-field-txt">First name </span>
                  				<div id="first-name-error">&nbsp;</div> 
				            </div>
						</div>
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['gsa']['last_name'])?$table['gsa']['last_name']:$user['last_name']; ?>" id="last-name" type="text">
				                <span class="input-field-txt">Last name </span>
                  				<div id="last-name-error">&nbsp;</div> 
				            </div>
						</div> 
						  
					</div>
				
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="candidate-gsa"  class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
 

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-gsa.js" ></script>
