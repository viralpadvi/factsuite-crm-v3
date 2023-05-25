<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-global-database';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
				<input name="" class="fld form-control global_id" value="<?php echo isset($table['globaldatabase']['globaldatabase_id'])?$table['globaldatabase']['globaldatabase_id']:''; ?>" id="global_id" type="hidden">
				<div class="row content-div-content-row-1">
					 <div class="col-12"><span class="input-main-hdr">Global Database</span></div>
					<div class="col-12"><span class="input-main-hdr">Candidate Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap"> 
							<input name="" class="sign-in-input-field name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['globaldatabase']['candidate_name'])?$table['globaldatabase']['candidate_name']:$user['first_name']; ?>" id="name" type="text" required>
			            	<span class="input-field-txt">Candidate Name</span>
			            	<div id="name-error"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Father's Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap"> 
		                  <input name="" class="sign-in-input-field father_name" disabled onblur="valid_father_name()" onkeyup="valid_father_name()" value="<?php echo isset($table['globaldatabase']['father_name'])?$table['globaldatabase']['father_name']:$user['father_name']; ?>" id="father_name" type="text" required>
			            	<span class="input-field-txt">Father's Name</span> 
            				<div id="father_name-error"></div>
			         	</div>
					</div>
				</div>
				 
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Date Of Birth *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field mdate" disabled onblur="valid_date_of_birth()" onkeyup="valid_date_of_birth()" value="<?php echo isset($table['globaldatabase']['dob'])?$table['globaldatabase']['dob']:$user['date_of_birth']; ?>" id="date_of_birth" type="text" required>
			            	<span class="input-field-txt">Date Of Birth</span>
			            	<div id="date_of_birth-error"></div>
			         	</div>
					</div>
				</div>
				 
			 
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-global-database">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-global-database.js" ></script>