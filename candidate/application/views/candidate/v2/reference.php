 
					 <input type="hidden" name="" id="reference_id" value="<?php echo isset($table['reference']['reference_id'])?$table['reference']['reference_id']:''; ?>">

					<?php  
             $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $refrence = 1;
            if (isset($form_values['reference'][0])?$form_values['reference'][0]:0 > 0) {
               $refrence = $form_values['reference'][0];
             } 
             // echo $refrence;
             $j =1;
         if (isset($table['reference']['name'])) {
            $company_name = explode(',', $table['reference']['company_name']);
            $designation = explode(',', $table['reference']['designation']);
            $contact_number = explode(',', $table['reference']['contact_number']);
            $email_id = explode(',', $table['reference']['email_id']);
            $years_of_association = explode(',', $table['reference']['years_of_association']);
            $contact_start_time = explode(',', $table['reference']['contact_start_time']);
            $contact_end_time = explode(',', $table['reference']['contact_end_time']); 
            $name = explode(',',$table['reference']['name']);
            $codes = explode(',',$table['reference']['code']);
          }


           for ($i=0; $i < $refrence; $i++) {   
              ?>
					<h2 class="component-name">Reference <?php echo $j;?></h2>
					<div class="row">
						<div class="col-md-4">
						<div class="input-wrap"> 
                 		 <input class="sign-in-input-field name" value="<?php echo isset($name[$i])?$name[$i]:''; ?>" onkeyup="valid_name(<?php echo $i;?>)" onblur="valid_name(<?php echo $i;?>)"  id="name<?php echo $i; ?>" type="text" required>
			            <span class="input-field-txt">Reference Name</span> 
                 		<div id="name-error<?php echo $i;?>"></div>
			         	</div>
					</div>
						 <div class="col-md-4">
						<div class="input-wrap"> 
                  		<input class="sign-in-input-field company-name" value="<?php echo isset($company_name[$i])?$company_name[$i]:''; ?>"  onkeyup="valid_company_name(<?php echo $i;?>)" onblur="valid_company_name(<?php echo $i;?>)"  id="company-name<?php echo $i; ?>" type="text" required>
			            	<span class="input-field-txt">Company Name</span>
                   		<div id="company-name-error<?php echo $i;?>"></div> 
			         	</div>
					</div>
						<div class="col-md-4">
						<div class="input-wrap">
							<input class="sign-in-input-field designation" value="<?php echo isset($designation[$i])?$designation[$i]:''; ?>" onkeyup="valid_designation(<?php echo $i;?>)" onblur="valid_designation(<?php echo $i;?>)"  id="designation<?php echo $i; ?>" type="text" required>
			            	<span class="input-field-txt">Designation</span>
                  		<div id="designation-error<?php echo $i;?>"></div> 
			         	</div>
					</div>
					<div class="col-md-2 pt-0">
						<div class="input-wrap">
							<select class="sign-in-input-field code" id="code" required>
                        <?php $ccode = isset($codes[$i])?$codes[$i]:'';
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

					<div class="col-md-4">
						<div class="input-wrap">
							<input class="sign-in-input-field contact" value="<?php echo isset($contact_number[$i])?$contact_number[$i]:''; ?>" onkeyup="valid_contact(<?php echo $i;?>)" onblur="valid_contact(<?php echo $i;?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact<?php echo $i; ?>" type="text" required>
			            	<span class="input-field-txt">Mobile Number</span>
                     		<div id="contact-error<?php echo $i;?>"></div> 
			         	</div>
					</div>
					<div class="col-md-6">
						<div class="input-wrap">
							<input  class="sign-in-input-field email" value="<?php echo isset($email_id[$i])?$email_id[$i]:''; ?>" onkeyup="valid_email(<?php echo $i;?>)" onblur="valid_email(<?php echo $i;?>)"  id="email<?php echo $i; ?>" type="text" required>
			            	<span class="input-field-txt">Email ID</span>
			            	<div id="email-error<?php echo $i;?>"></div>
			         	</div>
					</div>

					<div class="col-md-4">
						<div class="input-wrap">
							<input class="sign-in-input-field association" value="<?php echo isset($years_of_association[$i])?$years_of_association[$i]:''; ?>" onkeyup="valid_association(<?php echo $i;?>)" onblur="valid_association(<?php echo $i;?>)"  id="association<?php echo $i; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text" required>
			            	<span class="input-field-txt">Years of Association</span>
			            	<div id="association-error<?php echo $i;?>"></div>
			         	</div>
					</div>
					 <?php 

               $srt = explode(':', isset($contact_start_time[$i])?$contact_start_time[$i]:'');
               $end = explode(':', isset($contact_end_time[$i])?$contact_end_time[$i]:''); 

                ?> 
               <div class="col-md-12">Preferred Contact Time</div>
                 <div class="col-md-6">Start</div>
                 <div class="col-md-6">End</div>
                <div class="col-2">
						<div class="input-wrap">
							 <select id="start-hour" class="sign-in-input-field start-hour" required>
                        <?php 
                           for ($h=0; $h <= 12; $h++) { 
                              $a = $h;
                              if ($h < 10) {
                                 $a = '0'.$h;
                              }
                              $select = '';
                              if ($a ==$srt[0]) {
                                $select = 'selected';
                              }
                              echo "<option ".$select." value='".$a."'>".$a."</option>";
                           }
                        ?>
                     </select>
			         	</div>
					</div>
					<div class="col-2">
						<div class="input-wrap">
							 <select id="start-minute" class="sign-in-input-field start-minute" required>
                        <?php 
                           for ($h=0; $h <= 60; $h++) { 
                              $a = $h;
                              if ($h < 10) {
                                 $a = '0'.$h;
                              }
                              $select = '';
                              if ($a ==$srt[1]) {
                                $select = 'selected';
                              }
                              echo "<option ".$select." value='".$a."'>".$a."</option>";
                           }
                        ?>
                     </select>
						</div>
					</div>
					<div class="col-2">
						<div class="input-wrap">
							<select id="start-type" class="sign-in-input-field start-type">
                       
                        <option>AM</option>
                        <option>PM</option>
                     </select>
						</div>
					</div>
					<div class="col-2">
						<div class="input-wrap">
							 <select id="end-hour" class="sign-in-input-field end-hour" required>
                        <?php 
                           for ($h=0; $h <= 12; $h++) { 
                              $a = $h;
                              if ($h < 10) {
                                 $a = '0'.$h;
                              }
                              $select = '';
                              if ($a ==$end[0]) {
                                $select = 'selected';
                              }
                              echo "<option ".$select." value='".$a."'>".$a."</option>";
                           }
                        ?>
                     </select>
			         	</div>
					</div>
					<div class="col-2">
						<div class="input-wrap">
							 <select id="end-minute" class="sign-in-input-field end-minute" required>
                        <?php 
                           for ($h=0; $h <= 60; $h++) { 
                              $a = $h;
                              if ($h < 10) {
                                 $a = '0'.$h;
                              }
                              $select = '';
                              if ($a ==$end[1]) {
                                $select = 'selected';
                              }
                              echo "<option ".$select." value='".$a."'>".$a."</option>";
                           }
                        ?>
                     </select>
						</div>
					</div>
					<div class="col-2">
						<div class="input-wrap">
							<select id="end-type" class="sign-in-input-field end-type" required>
                       
                        <option>AM</option>
                        <option>PM</option>
                     </select>
						</div>
					</div>
						 <!--  --> 
					</div>

					<?php 
            }
         ?>

				 
					  
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button  id="add_reference"  class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

 

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/reference.js" ></script>
