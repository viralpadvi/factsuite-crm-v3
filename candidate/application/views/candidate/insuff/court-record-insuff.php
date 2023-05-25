
   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
      <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('2',array_values(explode(',', $component_ids)))+1 ?>/<?php echo count(explode(',', $component_ids))+1;?></div>
         <div id="new_address">
             <input type="hidden" id="court_records_id" value="<?php echo isset($table['court_records']['court_records_id'])?$table['court_records']['court_records_id']:''; ?>" name="">
            <?php 
                  $form_values = json_decode($user['form_values'],true);
                   $form_values = json_decode($form_values,true);
                   // echo $form_values['reference'][0];
                   // echo $form_values['previous_address'][0];
                   // echo json_encode($form_values['drug_test']);
                   // echo $user['form_values'];
                   $court_record = 1;
                  if (isset($form_values['court_record'][0])?$form_values['court_record'][0]:0 > 0) {
                     $court_record = $form_values['court_record'][0];
                   } 
                   // echo $refrence;
                   $j =1;
                  if (isset($table['court_records']['address'])) {
                     $address = json_decode($table['court_records']['address'],true); 
                     $states = json_decode($table['court_records']['state'],true);
                     $countries = json_decode($table['court_records']['country'],true);
                     $pin_code = json_decode($table['court_records']['pin_code'],true);
                     $city = json_decode($table['court_records']['city'],true);
                     $analyst_status = explode(',',$table['criminal_checks']['analyst_status']);
                  }
                      for ($i=0; $i < $court_record; $i++) { 
                        // echo $value['address']; 
                        $disabled = ''; 
                       
                       ?>
                        <h6 class="full-nam2"><?php echo $j++; ?>. Address Details</h6>
                        <div id="form<?php echo $i; ?>">
                         <div class="row">
                           <div class="col-md-8">
                              <div class="pg-frm"> 
                                 <label>Address</label>
                                 <textarea class="fld form-control address" <?php echo $disabled; ?> onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea> 
                                  <div id="address-error<?php echo $i; ?>">&nbsp;</div> 
                              </div>
                           </div>

                           <div class="col-md-4">
                              <div class="pg-frm">
                                 <label>Pin Code</label>
                                 <input name="" class="fld form-control pincode" <?php echo $disabled; ?> value="<?php echo isset($pin_code[$i]['pincode'])?$pin_code[$i]['pincode']:''; ?>"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="valid_pincode(<?php echo $i; ?>)" onkeyup="valid_pincode(<?php echo $i; ?>)" id="pincode<?php echo $i; ?>" type="text">
                                  <div id="pincode-error<?php echo $i; ?>">&nbsp;</div>
                              </div>
                           </div>

                        </div>
                        <div class="row">

                           <div class="col-md-4">
                             <div class="pg-frm">
                             <label>Country</label> 
                                 <select class="fld form-control country" <?php echo $disabled; ?> onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" >
                                    <?php
                                    $get_country = isset($countries[$i]['country'])?$countries[$i]['country']:'India';
                                    $c_id = '';
                                    foreach ($country as $key1 => $val) {
                                       if ($get_country == $val['name']) {
                                        $c_id = $val['id'];
                                          echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                                       }else{
                                          echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                                       }
                                    }
                                       
                                     ?>
                                 </select> 
                                 <div id="country-error<?php echo $i; ?>">&nbsp;</div>
                          </div>
                        </div>

                        
                            <div class="col-md-4">
                              <div class="pg-frm">
                                 <label>State</label>
                                 <?php
                                 if ($c_id !='') {
                                      $state = $this->candidateModel->get_all_states($c_id);  
                                    }
                                 ?>
                                 <select class="fld form-control state" <?php echo $disabled; ?> onchange="valid_state(<?php echo $i; ?>)"  id="state<?php echo $i; ?>" >
                                    <?php 
                                    $get_state = isset($states[$i]['state'])?$states[$i]['state']:'Gujarat';
                                    $city_id = '';
                                    foreach ($state as $key1 => $val) {
                                       if ($get_state == $val['name']) {
                                          $city_id = $val['id'];
                                          echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                                       }else{
                                          echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                                       }
                                    }
                                       
                                     ?>
                                 </select> 
                                 <div id="state-error<?php echo $i; ?>">&nbsp;</div>
                              </div>
                           </div>
                            <div class="col-md-4">
                              <div class="pg-frm">
                                 <label>City/Town</label>
                                 <!-- <input name="" class="fld form-control city" value="<?php echo isset($city[$i]['city'])?$city[$i]['city']:''; ?>"  onkeyup="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" type="text"> -->
                                  <select class="fld form-control city" <?php echo $disabled; ?> onchange="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" >
                                    <?php 
                                    $get_city = isset($city[$i]['city'])?$city[$i]['city']:'';
                                    $cities = $this->candidateModel->get_all_cities($city_id);
                                    foreach ($cities as $key2 => $val) {
                                       if ($get_city == $val['name']) { 
                                          echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                                       }else{
                                          echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                                       }
                                    }
                                       
                                     ?>
                                 </select> 
                                 <div id="city-error<?php echo $i; ?>">&nbsp;</div>
                              </div>
                           </div>
                           

                        </div>
                        <hr>
                     </div>
                        <?php 
                     }
                  
            ?> 
       </div>

         <!-- <div><button id="add-row"><i class="fa fa-plus"></i></button></div> -->
         
         <div class="row">
           <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add-court-record" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section> 
<script>
   var states = <?php echo json_encode($state); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/insuff/candidate-court-record-insuff.js" ></script>
 