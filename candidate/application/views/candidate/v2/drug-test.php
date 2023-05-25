 					 <input type="hidden" id="drugtest_id" value="<?php echo isset($table['drugtest']['drugtest_id'])?$table['drugtest']['drugtest_id']:''; ?>" name="">

					 <?php
        $user_session_details = $this->session->userdata('logged-in-candidate');
         $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true); 
             $drug_test = 1;
            if (isset($form_values['drug_test'][0])?$form_values['drug_test'][0]:0 > 0) {
               $drug_test = count($form_values['drug_test']);
             }  
             $j =1;

             // var_dump($user);
             
        if (isset($table['drugtest']['candidate_name'])) {
            $candidate_name = json_decode($table['drugtest']['candidate_name'],true);
            $father_name = json_decode($table['drugtest']['father__name'],true);
            $dob = json_decode($table['drugtest']['dob'],true);
            $address = json_decode($table['drugtest']['address'],true);
            $mobile_number = json_decode($table['drugtest']['mobile_number'],true); 
            $codes = json_decode($table['drugtest']['code'],true);
            }  
             
           for ($i=0; $i < $drug_test; $i++) { 
             $court ='';
                if (isset($form_values['drug_test'][$i])?$form_values['drug_test'][$i]:'' !='') {
                   
                $court = $this->candidateModel->drug_test_type($form_values['drug_test'][$i]);
                }

                ?>
                <h2 class="component-name"><?php echo isset($court['drug_test_type_name'])?$court['drug_test_type_name']:'Panel'; ?> Details</h2>
					<div class="row">
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field  name" disabled  value="<?php echo isset($candidate_name[$i]['candidate_name'])?$candidate_name[$i]['candidate_name']:$user_session_details['first_name'].' '.$user_session_details['last_name']; ?>"onblur="valid_name(<?php echo $i; ?>)" onkeyup="valid_name(<?php echo $i; ?>)" id="name<?php echo $i; ?>" type="text"> 
				                <span class="input-field-txt">Candidate name </span>
                  				<div id="name-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field father_name" disabled  value="<?php echo isset($father_name[$i]['father_name'])?$father_name[$i]['father_name']:$user_session_details['father_name']; ?>" onblur="valid_father_name(<?php echo $i; ?>)" onkeyup="valid_father_name(<?php echo $i; ?>)" id="father_name<?php echo $i; ?>" type="text">
				                <span class="input-field-txt">Father's Name </span>
                  				<div id="father_name-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field  mdate"  disabled value="<?php echo isset($dob[$i]['dob'])?$dob[$i]['dob']:$user_session_details['date_of_birth']; ?>" onblur="valid_date_of_birth(<?php echo $i; ?>)" onchange="valid_date_of_birth(<?php echo $i; ?>)" onkeyup="valid_date_of_birth(<?php echo $i; ?>)" id="date_of_birth<?php echo $i; ?>" type="text">
				                <span class="input-field-txt">Date Of Birth </span>
                  				<div id="date_of_birth-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>

						 <div class="col-md-6">
							<div class="input-wrap">
				                 <textarea required="" class="sign-in-input-field address" onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="1" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea>
				                <span class="input-field-txt">Address </span>
                  				<div id="address-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>

						 <!--  -->
						<div class="col-md-2">
							<div class="input-wrap"> 
				                  <select required="" class="sign-in-input-field code" id="code">
						                <?php 
						                $ccode = isset($codes[$i]['code'])?$codes[$i]['code']:'';
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
				                 <input name="" required="" class="sign-in-input-field contact_number" value="<?php echo isset($mobile_number[$i]['mobile_number'])?$mobile_number[$i]['mobile_number']:''; ?>" onblur="valid_contact_number(<?php echo $i; ?>)" onkeyup="valid_contact_number(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact_number<?php echo $i; ?>" type="text">
				                <span class="input-field-txt">Contact Number </span>
                  				<div id="contact_number-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
 
						 
					</div>

				 <?php 
				 	}
				 ?>
				   
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add-drug-test" class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
 
<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-drug-test.js" ></script>
