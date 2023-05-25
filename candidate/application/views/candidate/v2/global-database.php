 					 <input name="" class="fld form-control global_id" value="<?php echo isset($table['globaldatabase']['globaldatabase_id'])?$table['globaldatabase']['globaldatabase_id']:''; ?>" id="global_id" type="hidden">
					<div class="row">
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['globaldatabase']['candidate_name'])?$table['globaldatabase']['candidate_name']:$user['first_name']; ?>" id="name" type="text">
				                <span class="input-field-txt">Candidate name </span>
                  				<div id="name-error">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field father_name" disabled onblur="valid_father_name()" onkeyup="valid_father_name()" value="<?php echo isset($table['globaldatabase']['father_name'])?$table['globaldatabase']['father_name']:$user['father_name']; ?>" id="father_name" type="text">
				                <span class="input-field-txt">Father's Name </span>
                  				<div id="father_name-error">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  mdate" disabled onblur="valid_date_of_birth()" onkeyup="valid_date_of_birth()" value="<?php echo isset($table['globaldatabase']['dob'])?$table['globaldatabase']['dob']:$user['date_of_birth']; ?>" id="date_of_birth" type="text">
				                <span class="input-field-txt">Date Of Birth </span>
                  				<div id="date_of_birth-error">&nbsp;</div> 
				            </div>
						</div>
						 
					</div>
				
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add-global-database"  class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
 

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-global-database.js" ></script>
