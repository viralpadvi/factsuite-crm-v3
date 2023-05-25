<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-social-media';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
				<input name="" class="fld form-control global_id" value="<?php echo isset($table['social_media']['social_media_id'])?$table['social_media']['social_media_id']:''; ?>" id="global_id" type="hidden">
				<div class="row content-div-content-row-1">
					<div class="col-12"><span class="input-main-hdr">Candidate Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field name" disabled required onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['social_media']['candidate_name'])?$table['social_media']['candidate_name']:$user['first_name']; ?>" id="name">
			            	<span class="input-field-txt">Candidate Name</span>
			            	<div id="name-error"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Date Of Birth *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field mdate" required  disabled onblur="valid_date_of_birth()" onkeyup="valid_date_of_birth()" value="<?php echo isset($table['social_media']['dob'])?$table['social_media']['dob']:$user['date_of_birth']; ?>" id="date_of_birth">
			            	<span class="input-field-txt">Date Of Birth</span>
			            	<div id="date_of_birth-error"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Latest Employment Company Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field" required name="employee-company" value="<?php echo isset($table['social_media']['employee_company_info'])?$table['social_media']['employee_company_info']:''; ?>" id="employee-company">
			            	<span class="input-field-txt">Latest Employment Company Name</span>
			            	<div id="employee-company-error"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Highest Education College Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field" required  name="education" value="<?php echo isset($table['social_media']['education_info'])?$table['social_media']['education_info']:''; ?>" id="education">
			            	<span class="input-field-txt">Highest Education College Name</span>
			            	<div id="education-error"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">University name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field" required name="university" value="<?php echo isset($table['social_media']['university_info'])?$table['social_media']['university_info']:''; ?>" id="university">
			            	<span class="input-field-txt">University name</span>
			            	<div id="university-error"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Social Media Handles (if any)</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field" required name="social_media_info" value="<?php echo isset($table['social_media']['social_media_info'])?$table['social_media']['social_media_info']:''; ?>" id="social_media_info">
			            	<span class="input-field-txt">Social Media Handles</span>
			            	<div id="social_media-error"></div>
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
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-social-media.js" ></script>