 	<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-right-to-work';
   }
</script>
<div class="container-fluid content-bg-color">
      <div class="content-div">
         <div class="row"></div>
   	 <input name="" class="fld form-control sex_offender_id" value="<?php echo isset($table['right_to_work']['right_to_work_id'])?$table['right_to_work']['right_to_work_id']:''; ?>" id="right_to_work_id" type="hidden">
 		<?php  
             $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $right_to_work = 1;
            if (isset($form_values['right_to_work'][0])?$form_values['right_to_work'][0]:0 > 0) {
               $right_to_work = count($form_values['right_to_work']);
             } 
             // echo $refrence;
             $j =1;
         if (isset($table['right_to_work']['first_name'])) {
            $document_number = json_decode($table['right_to_work']['document_number'],true);
            $mobile_number = json_decode($table['right_to_work']['mobile_number'],true);
            $first_name = json_decode($table['right_to_work']['first_name'],true);
            $last_name = json_decode($table['right_to_work']['last_name'],true);
            $dob = json_decode($table['right_to_work']['dob'],true);
            $gender = json_decode($table['right_to_work']['gender'],true); 
          }


           for ($i=0; $i < $right_to_work; $i++) { 
            $count_work = isset($form_values['right_to_work'][$i])?$form_values['right_to_work'][$i]:2;
            $doc = 'Aadhar Card';
            if ($count_work ==2) {
               $doc = 'Aadhar Card';
            }else if ($count_work ==3) {
               $doc = 'Passport';
            }else if ($count_work ==4) {
               $doc = 'Voter Id';
            }else if ($count_work ==5) {
               $doc = 'SSN';
            } 
           ?> 
                <div class="col-12"><span class="input-main-hdr">Right To Work</span></div> 
              <div class="row content-div-content-row-1">
               <div class="col-12"><span class="input-main-hdr"><?php echo $doc; ?>*</span></div>
            </div>
            <div class="row content-div-content-row">
               <div class="col-12">
                  <div class="input-wrap"> 
                     <input name="" class="sign-in-input-field document_number"  data-id="<?php echo $count_work; ?>" onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($document_number['document_number'])?$document_number['document_number']:$user['first_name']; ?>" id="document_number<?php echo $i; ?>" type="text" required>
                        <span class="input-field-txt"><?php echo $doc; ?> Number</span>
                        <div id="document_number-error<?php echo $i; ?>"></div>
                     </div>
               </div>
            </div>


            <?php  if ($count_work ==2) { ?>
             <div class="row content-div-content-row-1">
               <div class="col-12"><span class="input-main-hdr">Registered mobile number*</span></div>
            </div>
            <div class="row content-div-content-row">
               <div class="col-12">
                  <div class="input-wrap"> 
                     <input name="" class="sign-in-input-field mobile_number"   onkeyup="valid_contact(<?php echo $i;?>)" onblur="valid_contact(<?php echo $i;?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?php echo isset($document_number['mobile_number'])?$document_number['mobile_number']:''; ?>" id="mobile_number<?php echo $i; ?>" type="text" required>
                        <span class="input-field-txt">Mobile Number</span>
                        <div id="mobile_number-error<?php echo $i; ?>"></div>
                    </div>
               </div>
            </div>

              <?php  } ?>

           <div class="row content-div-content-row-1">
               <div class="col-12"><span class="input-main-hdr">First Name *</span></div>
            </div>
            <div class="row content-div-content-row">
               <div class="col-12">
                  <div class="input-wrap"> 
                     <input name="" class="sign-in-input-field first-name"   onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($first_name['first_name'])?$first_name['first_name']:$user['first_name']; ?>" id="first-name<?php echo $i; ?>" type="text" required>
                        <span class="input-field-txt">First Name</span>
                        <div id="first-name-error<?php echo $i; ?>"></div>
                     </div>
               </div>
            </div>
            <div class="row content-div-content-row">
               <div class="col-12"><span class="input-main-hdr">Last Name *</span></div>
            </div>
            <div class="row content-div-content-row">
               <div class="col-12">
                  <div class="input-wrap"> 
                        <input name="" class="sign-in-input-field last-name"   onkeyup="valid_last_name()" value="<?php echo isset($last_name['last_name'])?$last_name['last_name']:$user['last_name']; ?>" id="last-name<?php echo $i; ?>" type="text" required>
                        <span class="input-field-txt">Last Name</span> 
                        <div id="last-name-error<?php echo $i; ?>"></div>
                     </div>
               </div>
            </div> 
             
            <div class="row content-div-content-row">
               <div class="col-12"><span class="input-main-hdr">Date Of Birth *</span></div>
            </div>
            <div class="row content-div-content-row">
               <div class="col-12">
                  <div class="input-wrap">
                     <input type="text" class="sign-in-input-field mdate date_of_birth"  onblur="valid_date_of_birth()" onkeyup="valid_date_of_birth()" value="<?php echo isset($dob['dob'])?$dob['dob']:$user['date_of_birth']; ?>" id="date_of_birth<?php echo $i; ?>" type="text" required>
                        <span class="input-field-txt">Date Of Birth</span>
                        <div id="date_of_birth-error<?php echo $i; ?>"></div>
                     </div>
               </div>
            </div>
            <?php
               $male = '';
               $female = '';
               $single = '';
               $married = '';
               if (isset($gender['gender'])) {
                  if ($gender['gender'] != 'male') {
                     $female = 'selected';
                  } else {
                     $male = 'selected';
                  }
               }

                ?>

               <div class="row content-div-content-row">
               <div class="col-12"><span class="input-main-hdr">Gender *</span></div>
            </div>
            <div class="row content-div-content-row">
               <div class="col-12">
                  <div class="input-wrap">
                     <select id="gender<?php echo $i; ?>" class="sign-in-input-field gender" required>
                        <option <?php echo $male; ?> value="male">Male</option>
                        <option <?php echo $female; ?> value="female">Female</option>
                     </select>
                     <span class="input-field-txt">Gender</span>
                     <div id="gender-error<?php echo $i; ?>"></div>
                     </div>
               </div>
            </div> 


               <div class="col-md-10 mt-3">
               <label>Right To Work Documents</label>
                     <div class="row">
                        <div class="col-8">
                            <!-- id="right_to_work_docs-img<?php echo $i; ?>" -->
                           <span class="custom-file-name file-name" id="right_to_work_docs-error<?php echo $i; ?>">
                              <?php $rental = '';
                                 if (isset($right_to_work_docs[$i])) {
                                    if (!in_array('no-file', $right_to_work_docs[$i])) {
                                       foreach ($right_to_work_docs[$i] as $key => $value) {
                                          if ($value !='') {
                                             echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"right_to_work-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                          }
                                       }
                                       $rental = $right_to_work_docs[$i];
                                    }
                                 } ?>
                           </span>
                        </div>
                        <div class="col-4 custom-file-input-btn-div">
                           <div class="custom-file-input">
                           <input type="file" accept="image/*,application/pdf" id="right_to_work_docs<?php echo $i; ?>" name="right_to_work_docs<?php echo $i; ?>" class="input-file w-100 right_to_work_docs" multiple>
                           <button class="btn btn-file-upload" for="right_to_work_docs<?php echo $i; ?>">
                              <img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
                              Upload
                              </button>
                        </div>
                        <input type="hidden" class="rental" value="<?php echo json_encode($rental); ?>">
                     </div>
                     <div ></div>
                  </div>
            </div>


             <?php } ?>

         <div class="row">
            <!--  -->
            <div class="col-12"> 
            <button id="candidate-right-to-work"  class="save-btn"> 
                  Save & Continue
               </button>
            </div>
         </div>
      </div>
   </div>
   <script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-right-to-work.js" ></script>