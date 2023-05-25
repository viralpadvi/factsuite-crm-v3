<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-criminal-check';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Personal Information</div>
         <div class="pg-rgt">Step <?php echo array_search('1',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <input type="hidden" id="criminal_checks_id" value="<?php echo isset($table['criminal_checks']['criminal_check_id'])?$table['criminal_checks']['criminal_check_id']:''; ?>" name="">
         <?php  
            $form_values = json_decode($user['form_values'],true);
            $form_values = json_decode($form_values,true);
            $criminal_status = 1;
            if (isset($form_values['criminal_status'][0])?$form_values['criminal_status'][0]:0 > 0) {
               $criminal_status = $form_values['criminal_status'][0];
            } 
            $j =1;
            if (isset($table['criminal_checks']['address'])) {
               $address = json_decode($table['criminal_checks']['address'],true); 
               $states = json_decode($table['criminal_checks']['state'],true);
               $pin_code = json_decode($table['criminal_checks']['pin_code'],true);
               $city = json_decode($table['criminal_checks']['city'],true);
               $countries = json_decode($table['criminal_checks']['country'],true);
               for ($i=0; $i < $criminal_status; $i++) { ?>
                  <div class="pg-txt" id="form<?php echo $i; ?>">
                     <div class="pg-lft"><?php echo $j++; ?>. Address Details</div>
                     <div class="clr"></div>
                  </div>
                  <div class="full-bx">
                     <label>Address <span>(Required)</span></label>
                     <textarea class="fld form-control address" onkeyup="valid_address(<?php echo $i; ?>)" onblur="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea> 
                     <div id="address-error<?php echo $i; ?>"></div> 
                  </div>
                  <div class="full-bx">
                     <label>Pin Code <span>(Required)</span></label>
                     <input class="fld form-control pincode"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?php echo isset($pin_code[$i]['pincode'])?$pin_code[$i]['pincode']:''; ?>" onkeyup="valid_pincode(<?php echo $i; ?>)" onblur="valid_pincode(<?php echo $i; ?>)" id="pincode<?php echo $i; ?>" type="text">
                     <div id="pincode-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="full-bx">
                     <label>Country <span>(Required)</span></label>
                     <select class="fld form-control country select2" onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" >
                        <option value=''>Select Country</option>
                        <?php
                        $get_country = 'India';
                        if (isset($countries[$i]['country']) && $countries[$i]['country'] != '') {
                           $get_country = $countries[$i]['country'];
                        }
                        $c_id = '';
                        foreach ($country as $key1 => $val) {
                           if ($get_country == $val['name']) {
                              $c_id = $val['id'];
                              echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                           } else {
                              echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                           }
                        } ?>
                     </select> 
                     <div id="country-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="full-bx">
                     <label>State <span>(Required)</span></label>
                     <?php
                     if ($c_id != '') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                     } ?>
                     <select class="fld form-control state select2" onchange="valid_state(<?php echo $i; ?>)" id="state<?php echo $i; ?>" >
                        <option value=''>Select State</option>
                        <?php 
                        $get_state = 'Karnataka';
                        if (isset($states[$i]['state']) && $states[$i]['state'] != '') {
                           $get_state = $states[$i]['state'];
                        }
                        $city_id = '';
                        foreach ($state as $key1 => $val) {
                           if ($get_state == $val['name']) {
                              $city_id = $val['id'];
                              echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                           } else {
                              echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                           }
                        } ?>
                     </select> 
                     <div id="state-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="full-bx">
                     <label>City/Town <span>(Required)</span></label>
                     <select class="fld form-control city select2" onchange="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" >
                        <option value=''>Select City/Town</option>
                        <?php 
                        $get_city = 'Bengaluru';
                        if (isset($city[$i]['city']) && $city[$i]['city'] != '') {
                           $get_city = $city[$i]['city'];
                        }
                        $cities = $this->candidateModel->get_all_cities($city_id);
                        foreach ($cities as $key2 => $val) {
                           if ($get_city == $val['name']) { 
                              echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                           } else {
                              echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                           }
                        } ?>
                     </select> 
                     <div id="city-error<?php echo $i; ?>"></div>
                  </div>

            <?php } } else { 
               for ($i=0; $i < $criminal_status; $i++) { ?>
                   <div class="pg-txt" id="form<?php echo $i; ?>">
                     <div class="pg-lft"><?php echo $j++; ?>. Address Details</div>
                     <div class="clr"></div>
                  </div>
                  <div class="full-bx">
                     <label>Address <span>(Required)</span></label>
                     <textarea class="fld form-control address" onkeyup="valid_address(<?php echo $i; ?>)" onblur="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>"></textarea> 
                     <div id="address-error<?php echo $i; ?>"></div> 
                  </div>
                  <div class="full-bx">
                     <label>Pin Code <span>(Required)</span></label>
                     <input class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="valid_pincode(<?php echo $i; ?>)" onblur="valid_pincode(<?php echo $i; ?>)" id="pincode<?php echo $i; ?>" type="text">
                     <div id="pincode-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="full-bx">
                     <label>Country <span>(Required)</span></label>
                     <select class="fld form-control country select2" onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" >
                        <option selected value=''>Select Country</option>
                       <?php
                        $get_country = 'India';
                        if (isset($countries[$i]['country']) && $countries[$i]['country'] != '') {
                           $get_country = $countries[$i]['country'];
                        }
                        $c_id = '';
                        foreach ($country as $key1 => $val) {
                           if ($get_country == $val['name']) {
                              $c_id = $val['id'];
                              echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                           } else {
                              echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                           }
                        } ?>
                     </select> 
                     <div id="country-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="full-bx">
                     <label>State <span>(Required)</span></label>
                     <?php
                     if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                     } ?>
                     <select class="fld form-control state select2" onchange="valid_state(<?php echo $i; ?>)" id="state<?php echo $i; ?>" >
                        <option selected value=''>Select State</option>
                        <?php 
                        $get_state = 'Karnataka';
                        if (isset($states[$i]['state']) && $states[$i]['state'] != '') {
                           $get_state = $states[$i]['state'];
                        }
                        $city_id = '';
                        foreach ($state as $key1 => $val) {
                           if ($get_state == $val['name']) {
                              $city_id = $val['id'];
                              echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                           } else {
                              echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                           }
                        } ?>
                     </select> 
                     <div id="state-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="full-bx">
                     <label>City/Town <span>(Required)</span></label>
                     <select class="fld form-control city select2" onchange="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" >
                        <option selected value=''>Select City/Town</option>
                        <?php 
                        $get_city = 'Bengaluru';
                        if (isset($city[$i]['city']) && $city[$i]['city'] != '') {
                           $get_city = $city[$i]['city'];
                        }
                        $cities = $this->candidateModel->get_all_cities($city_id);
                        foreach ($cities as $key2 => $val) {
                           if ($get_city == $val['name']) { 
                              echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                           } else {
                              echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                           }
                        } ?>
                     </select> 
                     <div id="city-error<?php echo $i; ?>"></div>
                  </div>
            <?php } } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <button class="pg-nxt-btn" id="save-details-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/criminal-check.js" ></script>