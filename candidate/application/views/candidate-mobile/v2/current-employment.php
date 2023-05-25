
<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-employment';
   }
</script>
	<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
			<div class="row content-div-content-row-1">
				<div class="col-12"><span class="input-main-hdr">Designation *</span></div> 
			</div>
			<div class="row content-div-content-row">
				 <input name="" value="<?php echo isset($table['current_employment']['current_emp_id'])?$table['current_employment']['current_emp_id']:''; ?>" id="current_emp_id" type="hidden">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field " value="<?php echo isset($table['current_employment']['desigination'])?$table['current_employment']['desigination']:''; ?>" id="designation" type="text" required>
            		
		               <span class="input-field-txt">Designation</span>
           				 <div id="designation-error"></div> 
		            </div>
				</div>
				 
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Department *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['department'])?$table['current_employment']['department']:''; ?>" id="department" type="text" required>
		                <span class="input-field-txt">Department </span>
           				 <div id="department-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Employee ID *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['employee_id'])?$table['current_employment']['employee_id']:''; ?>" id="employee_id" type="text" required>
		                <span class="input-field-txt">Employee ID</span>
           				 <div id="employee_id-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Company Name *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['company_name'])?$table['current_employment']['company_name']:''; ?>" id="company-name" type="text" required>
		                <span class="input-field-txt">Company Name</span>
		                <div id="company-name-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Company Website *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['company_url'])?$table['current_employment']['company_url']:''; ?>" id="company_url" type="text" required>
		                <span class="input-field-txt"> Company Website</span>
		                <div id="company_url-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Address*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap"> 
		                <textarea class="sign-in-input-field" id="address" type="text" required><?php echo isset($table['current_employment']['address'])?$table['current_employment']['address']:''; ?></textarea>
		                <span class="input-field-txt">Enter Address</span>
		                <div id="address-error"></div>
		            </div>
				</div>
			</div>
			  
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Annual CTC *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="annual-ctc" value="<?php echo isset($table['current_employment']['annual_ctc'])?$table['current_employment']['annual_ctc']:''; ?>" type="number" required>
		                <span class="input-field-txt">Enter Annual CTC</span>
            			<div id="annual-ctc-error"></div> 
		            </div>
				</div>
			</div>

			<!--  -->
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Reason For Leaving *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="reasion" value="<?php echo isset($table['current_employment']['reason_for_leaving'])?$table['current_employment']['reason_for_leaving']:''; ?>" type="text" required>
		                <span class="input-field-txt">Enter Reason For Leaving</span>
            			<div id="reasion-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Joining Date *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field date-for-candidate-aggreement-start-date" id="joining-date" value="<?php echo isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:''; ?>" type="text" required> 
		                <span class="input-field-txt">Enter Joining Date</span>
            			<div id="joining-date-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Relieving Date *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field date-for-candidate-aggreement-end-date" disabled id="relieving-date" value="<?php echo isset($table['current_employment']['relieving_date'])?$table['current_employment']['relieving_date']:''; ?>" type="text" required> 
		                <span class="input-field-txt">Enter Relieving Date</span>
            		<div id="relieving-date-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Reporting Manager Name *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="reporting-manager-name" value="<?php echo isset($table['current_employment']['reporting_manager_name'])?$table['current_employment']['reporting_manager_name']:''; ?>" type="text" required>
		                <span class="input-field-txt">Enter Reporting Manager Name</span>
            			<div id="reporting-manager-name-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Reporting Manager Designation *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="reporting-manager-designation" value="<?php echo isset($table['current_employment']['reporting_manager_desigination'])?$table['current_employment']['reporting_manager_desigination']:''; ?>" type="text" required>
		                <span class="input-field-txt">Enter Reporting Manager Designation</span>
            		<div id="reporting-manager-designation-error"></div> 
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-3"><span class="input-main-hdr">Country Code *</span></div>
				<div class="col-9"><span class="input-main-hdr">Reporting Manager Contact Number *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-3">
					<div class="input-wrap">
		                <select class="sign-in-input-field code" id="code" required>
		                  <?php 
		                  $ccode = '+91';
		                  if (isset($codes[$i]['code']) && $codes[$i]['code'] != '') {
		                     $ccode = $codes[$i]['code'];
		                  }
		                  foreach ($code['countries'] as $key => $value) {
		                     if ($ccode==$value['code']) {
		                        echo "<option selected >{$value['code']}</option>";
		                     } else { 
		                        echo "<option>{$value['code']}</option>";
		                     }
		                  } ?>
		               </select>
		                <span class="input-field-txt">Code</span> 
		            </div>
				</div>
				<div class="col-9">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="reporting-manager-contact" value="<?php echo isset($table['current_employment']['reporting_manager_contact_number'])?$table['current_employment']['reporting_manager_contact_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text" required>
		                <span class="input-field-txt">Contact Number</span> 
               		<div id="reporting-manager-contact-error"></div>
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Reporting Manager Email ID *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['reporting_manager_email_id'])?$table['current_employment']['reporting_manager_email_id']:''; ?>" id="reporting-manager-email-id" type="text" required>
		                <span class="input-field-txt">Reporting Manager Email ID</span>
            		<div id="reporting-manager-email-id-error"></div> 
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">HR Contact Name *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="hr-name" value="<?php echo isset($table['current_employment']['hr_name'])?$table['current_employment']['hr_name']:''; ?>" type="text" required>
		                <span class="input-field-txt">HR Contact Name</span>
            		<div id="hr-name-error"></div> 
		            </div>
				</div>
			</div>


			<div class="row content-div-content-row-2">
				<div class="col-3"><span class="input-main-hdr">Country Code *</span></div>
				<div class="col-9"><span class="input-main-hdr">HR Contact Number *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-3">
					<div class="input-wrap">
		                <select class="sign-in-input-field code" id="hr-code" required>
		                  <?php 
		                  $ccode = '+91';
		                  if (isset($codes[$i]['code']) && $codes[$i]['code'] != '') {
		                     $ccode = $codes[$i]['code'];
		                  }
		                  foreach ($code['countries'] as $key => $value) {
		                     if ($ccode==$value['code']) {
		                        echo "<option selected >{$value['code']}</option>";
		                     } else { 
		                        echo "<option>{$value['code']}</option>";
		                     }
		                  } ?>
		               </select>
		                <span class="input-field-txt">Code</span> 
		            </div>
				</div>
				<div class="col-9">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="hr-contact" value="<?php echo isset($table['current_employment']['hr_contact_number'])?$table['current_employment']['hr_contact_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text" required>
		                <span class="input-field-txt">HR Contact Number</span> 
               		<div id="hr-contact-error"></div>
		            </div>
				</div>
			</div>


			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">HR Email ID *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['hr_email_id'])?$table['current_employment']['hr_email_id']:''; ?>" id="hr-email-id" type="text" required>
		                <span class="input-field-txt">HR Email ID</span>
            		<div id="hr-email-id-error"></div> 
		            </div>
				</div>
			</div>
			
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Appointment Letter  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				<span class="custom-file-name file-name1" id="">
                  					<?php $appointment_letter = '';
                       				if (isset($table['current_employment'])) {
                       					if (!in_array('no-file', explode(',', $table['current_employment']['appointment_letter']))) {
                         					foreach (explode(',', $table['current_employment']['appointment_letter']) as $key => $value) {
                           						if ($value !='') {
                            						echo "<div id='appointment_letter{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/appointment_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          						}
                         					}
                         					$appointment_letter = $table['current_employment']['appointment_letter'];
                       					}
                       				} ?>
                  				</span>
                  				<input type="hidden" id="appointment_letter" value="<?php echo $appointment_letter; ?>">
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  					<input type="file" accept="image/*,application/pdf" id="file1" name="file1" class="input-file w-100"  multiple>
                  				<button class="btn btn-file-upload" for="file1">
                  					<img src="assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<div class="col-12">
                  				<div id="appointment_letter-error"></div>
                  			</div>
                  		</div>
                	</div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Experience/Relieving Letter  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				<span class="custom-file-name file-name2" id="">
                  					<?php $experience_relieving_letter = '';
                       				if (isset($table['current_employment'])) {
                       					if (!in_array('no-file', explode(',', $table['current_employment']['experience_relieving_letter']))) {
                         					foreach (explode(',', $table['current_employment']['experience_relieving_letter']) as $key => $value) {
                           						if ($value !='') {
                            						echo "<div id='experience_relieving_letter{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"experience_relieving_letter\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/experience_relieving_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          						}
                         					}
                         					$experience_relieving_letter = $table['current_employment']['experience_relieving_letter'];
                       					}
                       				} ?>
                  				</span>
                  				<input type="hidden" id="experience_relieving_letter" value="<?php echo $experience_relieving_letter; ?>">
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  				<input type="file" accept="image/*,application/pdf" id="file2" name="file2" class="input-file w-100"  multiple>
                  				<button class="btn btn-file-upload" for="file2">
                  					<img src="assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<div class="col-12">
                  				<div id="experience_relieving_letter-error"></div>
                  			</div>
                  		</div>
                	</div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Last 3 Month Pay Slip  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				<span class="custom-file-name file-name3" id="">
                  					<?php $last_month_pay_slip = '';
                       				if (isset($table['current_employment'])) {
                       					if (!in_array('no-file', explode(',', $table['current_employment']['last_month_pay_slip']))) {
                         					foreach (explode(',', $table['current_employment']['last_month_pay_slip']) as $key => $value) {
                           						if ($value !='') {
                            						echo "<div id='last_month_pay_slip{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"last_month_pay_slip\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/last_month_pay_slip/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          						}
                         					}
                         					$last_month_pay_slip = $table['current_employment']['last_month_pay_slip'];
                       					}
                       				} ?>
                  				</span>
                  				<input type="hidden" id="last_month_pay_slip" value="<?php echo $last_month_pay_slip; ?>">
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  				<input type="file" accept="image/*,application/pdf" id="file3" name="file3" class="input-file w-100"  multiple>
                  				<button class="btn btn-file-upload" for="file3">
                  					<img src="assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<div class="col-12">
                  				<div id="last_month_pay_slip-error"></div>
                  			</div>
                  		</div>
                	</div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Bank Statement/ Resignation Acceptance  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				<span class="custom-file-name file-name4" id="">
                  					<?php $bank_statement_resigngation_acceptance = '';
                       				if (isset($table['current_employment'])) {
                       					if (!in_array('no-file', explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']))) {
                         					foreach (explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']) as $key => $value) {
                           						if ($value !='') { 
                              						echo "<div id='bank_statement_resigngation_acceptance{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"bank_statement_resigngation_acceptance\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/bank_statement_resigngation_acceptance/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          						}
                         					}
                         					$bank_statement_resigngation_acceptance = $table['current_employment']['bank_statement_resigngation_acceptance'];
                       					}
                       				} ?>
                  				</span>
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  					<input type="file" accept="image/*,application/pdf" id="file4" name="file4" class="input-file w-100"  multiple>
                  				<button class="btn btn-file-upload" for="file4">
                  					<img src="assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<div class="col-12">
                  				<div id="bank-error"></div>
                  			</div>
                  		</div>
                	</div>
				</div>
			</div>
			
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add_employments">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
<div class="modal fade view-document-modal" id="myModal-show" role="dialog">
 	<div class="modal-dialog modal-md modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
        	<div class="modal-header border-0">
          	<h3 id="">View Document</h4>
        	</div>
        	<div class="modal-body modal-body-edit-coupon">
          	<div class="row"> 
         		<div class="col-md-12 text-center view-img" id="view-img"></div>
    			</div>
          	<div class="row mt-3">
              	<div class="col-md-6" id="setupDownloadBtn"></div>
              	<div id="view-edit-cancel-btn-div" class="col-md-6 text-right">
                	<button class="btn btn-close-modal" data-dismiss="modal">Close</button>
              	</div>
            </div>
        	</div>
      </div>
   </div>
</div>
	<script> 
    	var candidate_info = <?php echo json_encode($user); ?>;
	</script>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-employment.js" ></script>