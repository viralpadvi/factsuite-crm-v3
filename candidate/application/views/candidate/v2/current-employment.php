					 <input required="" name="" class="fld form-control" value="<?php echo isset($table['current_employment']['current_emp_id'])?$table['current_employment']['current_emp_id']:''; ?>" id="current_emp_id" type="hidden">
					<div class="row">
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['desigination'])?$table['current_employment']['desigination']:''; ?>" id="designation" type="text"> 
				                <span class="input-field-txt">Designation </span>
                  				<div id="designation-error"></div> 
				            </div>
						</div>
						 <div class="col-md-4"> 
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['department'])?$table['current_employment']['department']:''; ?>" id="department" type="text">
				                <span class="input-field-txt">Department </span>
                  				<div id="department-error"></div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['employee_id'])?$table['current_employment']['employee_id']:''; ?>" id="employee_id" type="text">
				                <span class="input-field-txt">Employee ID </span>
                  				<div id="employee_id-error"></div> 
				            </div>
						</div>
						 <!--  -->
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['company_name'])?$table['current_employment']['company_name']:''; ?>" id="company-name" type="text">
				                <span class="input-field-txt">Company Name </span>
                  				<div id="company-name-error"></div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field company_url" value="<?php echo isset($table['current_employment']['company_url'])?$table['current_employment']['company_url']:'';?>" id="company_url"  type="text">
				                <span class="input-field-txt">Company Website </span>
                  				<div id="company_url-error"></div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <textarea class="sign-in-input-field" id="address" required="" rows="1"><?php echo isset($table['current_employment']['address'])?$table['current_employment']['address']:''; ?></textarea>
				                <span class="input-field-txt">Address </span>
                  				<div id="address-error"></div> 
				            </div>
						</div>

						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" id="annual-ctc" value="<?php echo isset($table['current_employment']['annual_ctc'])?$table['current_employment']['annual_ctc']:''; ?>" type="number">
				                <span class="input-field-txt">Annual CTC </span>
                  				<div id="annual-ctc-error"></div> 
				            </div>
						</div>

						 <div class="col-md-8">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" id="reasion"  value="<?php echo isset($table['current_employment']['reason_for_leaving'])?$table['current_employment']['reason_for_leaving']:''; ?>" type="text">
				                <span class="input-field-txt">Reason For Leaving </span>
                  				<div id="reasion-error"></div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field date-for-candidate-aggreement-start-date" id="joining-date" value="<?php echo isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:''; ?>" type="text"> 
				                <span class="input-field-txt">Joining Date </span>
                  				<div id="joining-date-error"></div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field date-for-candidate-aggreement-end-date" disabled required id="relieving-date" value="<?php echo isset($table['current_employment']['relieving_date'])?$table['current_employment']['relieving_date']:'';?>" type="text"> 
				                <span class="input-field-txt">Relieving Date </span>
                  				<div id="relieving-date-error"></div> 
				            </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Reporting Manager Details</label>
						</div>
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" id="reporting-manager-name" value="<?php echo isset($table['current_employment']['reporting_manager_name'])?$table['current_employment']['reporting_manager_name']:''; ?>" type="text">
				                <span class="input-field-txt">Name </span>
                  				<div id="reporting-manager-name-error"></div> 
				            </div>
						</div>
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" id="reporting-manager-designation" value="<?php echo isset($table['current_employment']['reporting_manager_desigination'])?$table['current_employment']['reporting_manager_desigination']:''; ?>" type="text">
				                <span class="input-field-txt">Designation </span>
                  				<div id="reporting-manager-designation-error"></div> 
				            </div>
						</div>
						 <div class="col-md-2">
							<div class="input-wrap"> 
						              <select class="sign-in-input-field code" id="code">
						                <?php
						                $ccode = isset($table['current_employment']['code'])?$table['current_employment']['code']:'';
						                foreach ($code['countries'] as $key => $value) {
						                   if ($ccode==$value['code']) {
						                    echo "<option selected >{$value['code']}</option>";
						                  }else{ 
						                  echo "<option>{$value['code']}</option>";
						                  }
						                }
						                ?>
						              </select>
				                <span class="input-field-txt">Code </span>  
				            </div>
						</div> 
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" id="reporting-manager-contact" value="<?php echo isset($table['current_employment']['reporting_manager_contact_number'])?$table['current_employment']['reporting_manager_contact_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text">
				                <span class="input-field-txt">Contact Number </span>
                  				<div id="reporting-manager-contact-error"></div> 
				            </div>
						</div> 

						<div class="col-md-6">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['reporting_manager_email_id'])?$table['current_employment']['reporting_manager_email_id']:''; ?>" id="reporting-manager-email-id" type="text">
				                <span class="input-field-txt">Email ID</span>
                  				<div id="reporting-manager-email-id-error"></div> 
				            </div>
						</div> 
						<div class="col-md-12">
							<label>HR Details</label>
						</div>
						<div class="col-md-5">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field" id="hr-name" value="<?php echo isset($table['current_employment']['hr_name'])?$table['current_employment']['hr_name']:''; ?>" type="text">
				                <span class="input-field-txt">Name </span>
                  				<div id="hr-name-error"></div> 
				            </div>
						</div> 

						<div class="col-md-2">
							<div class="input-wrap">
				                 <select class="sign-in-input-field hr-code" id="hr-code">
						                <?php
						                foreach ($code['countries'] as $key => $value) {
						                  echo "<option>{$value['code']}</option>";
						                }
						                ?>
						              </select>
				                <span class="input-field-txt">Code </span> 
				            </div>
						</div> 

						<div class="col-md-5">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field"  id="hr-contact" value="<?php echo isset($table['current_employment']['hr_contact_number'])?$table['current_employment']['hr_contact_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text">
				                <span class="input-field-txt">Contact Number </span>
                  				<div id="hr-contact-error"></div> 
				            </div>
						</div> 

						<div class="col-md-6">
							<div class="input-wrap">
				                 <input required="" class="sign-in-input-field" value="<?php echo isset($table['current_employment']['hr_email_id'])?$table['current_employment']['hr_email_id']:''; ?>" id="hr-email-id" type="text">
				                <span class="input-field-txt">Email ID </span>
                  				<div id="hr-email-id-error"></div> 
				            </div>
						</div> 


					</div>
				 
					<div class="row">
						<div class="col-md-10">
							<div class="pg-frm-hd">Appointment Letter</div>
							
		                  		<div class="row">
		                  			<div class="col-8">
		                  				 <div class="custom-file-name file-name1"><?php
			                     $appointment_letter = '';
			                       if (isset($table['current_employment'])) {
			                       if (!in_array('no-file', explode(',', $table['current_employment']['appointment_letter']))) {
			                         foreach (explode(',', $table['current_employment']['appointment_letter']) as $key => $value) {
			                           if ($value !='') {
			                            // <a id='remove_file_appointment_letter_documents{$key}' onclick='removeFile_documents({$key},\"appointment_letter\")' data-path='appointment_letter' data-field='appointment_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  
			                            echo "<div id='appointment_letter{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/appointment_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";

			                          }
			                         }
			                         $appointment_letter = $table['current_employment']['appointment_letter'];
			                       }}
			                       ?></div>
			                       <input type="hidden" id="appointment_letter" value="<?php echo $appointment_letter; ?>">
			                       <div id="appointment_letter-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  					<input type="file" id="file1" required="" name="file1" class="input-file w-100" accept="image/*,application/pdf" multiple>
		                  				<button class="btn btn-file-upload" for="file1">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Experience/Relieving Letter</div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				 <div class="custom-file-name file-name2"><?php
                     $experience_relieving_letter = '';
                       if (isset($table['current_employment'])) {
                       if (!in_array('no-file', explode(',', $table['current_employment']['experience_relieving_letter']))) {
                         foreach (explode(',', $table['current_employment']['experience_relieving_letter']) as $key => $value) {
                           if ($value !='') {
                            // <a id='remove_file_experience_relieving_letter_documents{$key}' onclick='removeFile_documents({$key},\"experience_relieving_letter\")' data-path='experience_relieving_letter' data-field='experience_relieving_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> 
                            echo "<div id='experience_relieving_letter{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"experience_relieving_letter\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/experience_relieving_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                         }
                         $experience_relieving_letter = $table['current_employment']['experience_relieving_letter'];
                       }}
                       ?></div>
                       <input type="hidden" id="experience_relieving_letter" value="<?php echo $experience_relieving_letter; ?>"> 
               				<div id="experience_relieving_letter-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" id="file2" required="" name="file2" class="input-file w-100" accept="image/*,application/pdf" multiple>
		                  				<button class="btn btn-file-upload" for="file2">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Last 3 Month Pay Slip</div> 
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name3"><?php
			                     $last_month_pay_slip = '';
			                       if (isset($table['current_employment'])) {
			                       if (!in_array('no-file', explode(',', $table['current_employment']['last_month_pay_slip']))) {
			                         foreach (explode(',', $table['current_employment']['last_month_pay_slip']) as $key => $value) {
			                           if ($value !='') {
			                            // <a id='remove_file_last_month_pay_slip_documents{$key}' onclick='removeFile_documents({$key},\"last_month_pay_slip\")' data-path='last_month_pay_slip' data-field='last_month_pay_slip' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> 
			                            echo "<div id='last_month_pay_slip{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"last_month_pay_slip\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/last_month_pay_slip/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
			                          }
			                         }
			                         $last_month_pay_slip = $table['current_employment']['last_month_pay_slip'];
			                       }}
			                       ?></div>
			                       <input type="hidden" id="last_month_pay_slip" value="<?php echo $last_month_pay_slip; ?>">
			                   
			               <div id="last_month_pay_slip-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" id="file3" required="" name="file3" class="input-file w-100" accept="image/*,application/pdf" multiple>
		                  				<button class="btn btn-file-upload" for="file3">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Bank Statement/ Resignation Acceptance <span>(optional)</span></div>
							
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name4"><?php
					                     $bank_statement_resigngation_acceptance = '';
					                       if (isset($table['current_employment'])) {
					                       if (!in_array('no-file', explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']))) {
					                         foreach (explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']) as $key => $value) {
					                           if ($value !='') {
					                           	 // <a id='remove_file_bank_statement_resigngation_acceptance_documents{$key}' onclick='removeFile_documents({$key},\"bank_statement_resigngation_acceptance\")' data-path='bank_statement_resigngation_acceptance' data-field='bank_statement_resigngation_acceptance' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> 
					                              echo "<div id='bank_statement_resigngation_acceptance{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"bank_statement_resigngation_acceptance\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/bank_statement_resigngation_acceptance/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
					                          }
					                         }
					                         $bank_statement_resigngation_acceptance = $table['current_employment']['bank_statement_resigngation_acceptance'];
					                       }}
					                       ?></div> 
					               <div id="bank-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  					<input type="file" id="file4" required="" name="file4" class="input-file w-100" accept="image/*,application/pdf" multiple >
		                  				<button class="btn btn-file-upload" for="file4">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add_employments"  class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

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
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-employment.js?v=<?php echo time(); ?>" ></script>
