 					 <input name="" class="fld form-control sex_offender_id" value="<?php echo isset($table['sex_offender']['sex_offender_id'])?$table['sex_offender']['sex_offender_id']:''; ?>" id="sex_offender_id" type="hidden">
					<div class="row">
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  first-name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['sex_offender']['first_name'])?$table['sex_offender']['first_name']:$user['first_name']; ?>" id="first-name" type="text">
				                <span class="input-field-txt">First name </span>
                  				<div id="first-name-error">&nbsp;</div> 
				            </div>
						</div>
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['sex_offender']['last_name'])?$table['sex_offender']['last_name']:$user['last_name']; ?>" id="last-name" type="text">
				                <span class="input-field-txt">Last name </span>
                  				<div id="last-name-error">&nbsp;</div> 
				            </div>
						</div> 
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  mdate" disabled onblur="valid_date_of_birth()" onkeyup="valid_date_of_birth()" value="<?php echo isset($table['sex_offender']['dob'])?$table['sex_offender']['dob']:$user['date_of_birth']; ?>" id="date_of_birth" type="text">
				                <span class="input-field-txt">Date Of Birth </span>
                  				<div id="date_of_birth-error">&nbsp;</div> 
				            </div>
						</div>

						<?php
         		$male = '';
         		$female = '';
         		$single = '';
         		$married = '';
         		if (isset($user['gender'])) {
             		if ($user['gender'] != 'male') {
             			$female = 'selected';
             		} else {
              			$male = 'selected';
             		}
         		}

         		if(isset($user['marital_status'])) {
            		if ($user['marital_status']=='married') {
               			$married = 'selected';
             		} else {
               			$single = 'selected';
             		} 
         		} ?>
				<div class="col-md-4">
					<div class="pg-frm">
						<div class="input-wrap">
	      				<select id="gender" class="sign-in-input-field gender1" required>
	         				<option <?php echo $male; ?> value="male">Male</option>
	         				<option <?php echo $female; ?> value="female">Female</option>
	      				</select>
	      				<span class="input-field-txt">Gender</span>
	      				<div id="gender-error"></div>
	      			</div>
	            </div>
				</div>
						 
					</div>
				
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="candidate-sex-offender"  class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
 

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-sex-offender.js" ></script>
