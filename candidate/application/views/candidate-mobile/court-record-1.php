<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-court-record';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Previous Address</div>
         <div class="pg-rgt">Step <?php echo array_search('2',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <input type="hidden" id="court_records_id" value="<?php echo isset($table['court_records']['court_records_id'])?$table['court_records']['court_records_id']:''; ?>" name="">
      <?php $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $court_record = 1;
         if (isset($form_values['court_record'][0])?$form_values['court_record'][0]:0 > 0) {
            $court_record = $form_values['court_record'][0];
         }  
         $j = 1;
         if (isset($table['court_records']['address'])) {
            $address = json_decode($table['court_records']['address'],true); 
            $states = json_decode($table['court_records']['state'],true);
            $countries = json_decode($table['court_records']['country'],true);
            $pin_code = json_decode($table['court_records']['pin_code'],true);
            $city = json_decode($table['court_records']['city'],true);
            $address_proof_doc = json_decode($table['court_records']['address_proof_doc'],true);
         }
         for ($i = 0; $i < $court_record; $i++) { ?>
            <div class="pg-frm">
               <div class="pg-txt">
                  <div class="pg-lft">Address Details <?php echo $i+1; ?></div>
                  <div class="clr"></div>
               </div>
               <div class="full-bx">
                  <label>Address <span>(Required)</span></label>
                  <textarea class="fld address" onblur="check_address(<?php echo $i; ?>)" onkeyup="check_address(<?php echo $i; ?>)" rows="3" id="address-<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea> 
                  <div id="address-error-<?php echo $i; ?>"></div> 
               </div>

               <div class="full-bx">
                  <label>Pin Code <span>(Required)</span></label>
                  <input class="fld pincode" value="<?php echo isset($pin_code[$i]['pincode'])?$pin_code[$i]['pincode']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="check_pincode(<?php echo $i; ?>)" onkeyup="check_pincode(<?php echo $i; ?>)" id="pincode-<?php echo $i; ?>" type="text">
                  <div id="pincode-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>Country <span>(Required)</span></label>
                  <select class="fld country select2" onchange="check_country(<?php echo $i; ?>)" id="country-<?php echo $i; ?>">
                     <option selected value=''>Select Country</option>
                     <?php
                     $get_country = isset($countries[$i]['country'])?$countries[$i]['country']:'India';
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
                  <div id="country-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>State <span>(Required)</span></label>
                  <?php
                  if ($c_id !='') {
                     $state = $this->candidateModel->get_all_states($c_id);  
                  } ?>
                  <select class="fld state select2" onchange="check_state(<?php echo $i; ?>)" id="state-<?php echo $i; ?>">
                     <option selected value=''>Select State</option>
                     <?php $get_state = isset($states[$i]['state'])?$states[$i]['state']:'Gujarat';
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
                  <div id="state-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>City/Town <span>(Required)</span></label>
                  <select class="fld city select2" onchange="check_city(<?php echo $i; ?>)" id="city-<?php echo $i; ?>">
                     <option selected value=''>Select City/Town</option>
                     <?php $get_city = isset($city[$i]['city'])?$city[$i]['city']:'';
                     $cities = $this->candidateModel->get_all_cities($city_id);
                     foreach ($cities as $key2 => $val) {
                        if ($get_city == $val['name']) { 
                           echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                        } else {
                           echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                        }
                     } ?>
                  </select> 
                  <div id="city-error-<?php echo $i; ?>"></div>
               </div>

            </div>
         <?php } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <div class="text-center">
         <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
      </div>
   </div>
</div>

<div class="modal fade" id="myModal-show" role="dialog">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
         </div>
         <div class="modal-body">
            <div id="view-img"></div>
         </div>
         <div class="modal-footer">
            <div class="header-mn text-center">
               <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/court-record-1.js" ></script>