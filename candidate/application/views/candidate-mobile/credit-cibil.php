<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-credit-cibil';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Credit History</div>
         <div class="pg-rgt">Step <?php echo array_search('17',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <input type="hidden" name="credit_id" value="<?php echo  isset($credit_data['credit_id'])?$credit_data['credit_id']:''; ?>" id="credit_id">
      <div class="pg-frm">
          <input name="" class="fld form-control" value="<?php echo isset($table['previous_employment']['previous_emp_id'])?$table['previous_employment']['previous_emp_id']:''; ?>" id="previous_emp_id" type="hidden">
         
         <?php  
         $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $credit = 1;
         if (isset($form_values['credit_\/ cibil check'][0])?$form_values['credit_\/ cibil check'][0]:0 > 0) {
            $credit = $form_values['credit_\/ cibil check'][0];
         }
         $credit_data = isset($table['credit_cibil'])?$table['credit_cibil']:'';

         $document_type = json_decode(isset($credit_data['document_type'])?$credit_data['document_type']:'-',true);
         $credit_number = json_decode(isset($credit_data['credit_number'])?$credit_data['credit_number']:'-',true);
         $credit_cibil_doc = json_decode(isset($credit_data['credit_cibil_doc'])?$credit_data['credit_cibil_doc']:'no-file',true);

         for ($i = 0; $i < $credit; $i++) {
            $doc_type = isset($document_type[$i]['document_type'])?$document_type[$i]['document_type']:'-';
            $pan = '';
            $pass = '';
            $nric = '';
            if ($doc_type == 'Pan Card') {
               $pan = 'selected';
            } else if ($doc_type == 'NRIC') {
               $nric = 'selected';
            } else if ($doc_type == 'Passport') {
               $pass = 'selected';
            }
         ?>
            <div id="form"></div>
            <div class="full-bx">
               <label>Document Type <span>(Required)</span></label>
               <select class="fld document_type" id="document-type">
                  <option value=""> Select Document Type</option>
                  <option <?php echo $pan; ?> value="Pan Card">Pan Card</option>
                  <option <?php echo $nric; ?> value="NRIC">NRIC</option>
                  <option  <?php echo $pass; ?> value="Passport">Passport</option>
               </select>
               <div id="document-type-error"></div>
            </div>

            <div class="full-bx">
               <label>Document Number <span>(Required)</span></label>
               <input type="text" class="fld credit_cibil_number" id="credit-cibil-number" value="<?php echo isset($credit_number[$i]['credit_cibil_number'])?$credit_number[$i]['credit_cibil_number']:''; ?>" >
               <div id="credit-cibil-number-error"></div>
            </div>

            <div class="full-bx">
               <label>Country <span>(Required)</span></label>
               <select class="fld country select2" onchange="check_country()" id="country">
                  <option selected value=''>Select Country</option>
                  <?php $c_id = '';
                  foreach ($country as $key => $value) {
                     if ($user['nationality'] == $value['name'] ) {
                        $c_id = $value['id'];
                        echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                     } else {
                        if ($value['name'] =='India') {
                           $c_id = $value['id'];
                           echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                        }
                     }
                  } ?>
               </select> 
               <div id="country-error"></div>
            </div>

            <div class="full-bx">
               <label>State <span>(Required)</span></label>
               <?php
               if ($c_id !='') {
                  $state = $this->candidateModel->get_all_states($c_id);  
               }
               $city_id = ''; ?>
               <select class="fld state select2" onchange="check_state()" id="state">
                  <option selected value=''>Select State</option>
                  <?php $get = isset($table['credit_cibil']['credit_state'])?$table['credit_cibil']['credit_state']:'';
                  $get_state = isset($table['credit_cibil']['credit_state'])?$table['credit_cibil']['credit_state']:'Karnataka';
                  foreach ($state as $key1 => $val) {
                     if ($get == $val['name']) {
                        $city_id = $val['id'];
                        echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                     } else {
                        if ($get_state == $val['name']) {
                           $city_id = $val['id'];
                        }
                        echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                     }
                  } ?>
               </select> 
               <div id="state-error"></div>
            </div>

            <div class="full-bx">
               <label>City/Town <span>(Required)</span></label>
               <select class="fld city select2" onchange="check_city()" id="city">
                  <option selected value=''>Select City/Town</option>
                  <?php $get_city = isset($table['credit_cibil']['credit_city'])?$table['credit_cibil']['credit_city']:''; 
                  $cities = $this->candidateModel->get_all_cities($city_id);
                  foreach ($cities as $key2 => $val) {
                     if ($get_city == $val['name']) { 
                        echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                     } else {
                        echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                     }
                  } ?>
               </select> 
               <div id="city-error"></div>
            </div>

            <div class="full-bx">
               <label>Pin Code <span>(Required)</span></label>
               <input class="fld pincode" id="pincode" value="<?php echo isset($table['credit_cibil']['credit_pincode'])?$table['credit_cibil']['credit_pincode']:''; ?>" type="text">
               <div id="pincode-error"></div>
            </div>

            <div class="full-bx">
               <label>Permanent Address <span>(Required)</span></label>
               <textarea class="fld address" placeholder="Please enter valid address" rows="4" id="address"><?php echo isset($table['credit_cibil']['credit_address'])?$table['credit_cibil']['credit_address']:''; ?></textarea> 
               <div id="address-error"></div> 
            </div>
         <?php } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/credit-cibil.js" ></script>