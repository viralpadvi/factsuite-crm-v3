<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-previous-address';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Previous Address</div>
         <div class="pg-rgt">Step <?php echo array_search('12',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <input class="fld form-control" value="<?php echo isset($table['previous_address']['previos_address_id'])?$table['previous_address']['previos_address_id']:''; ?>" id="previos_address_id" type="hidden">
      <?php $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $previous_address = 1;
         if (isset($form_values['previous_address'][0])?$form_values['previous_address'][0]:0 > 0) {
            $previous_address = $form_values['previous_address'][0];
         } 
         $j = 1;
         if (isset($table['previous_address']['flat_no'])) {
            $contact_person_mobile_number = json_decode($table['previous_address']['contact_person_mobile_number'],true); 
            $flat_no = json_decode($table['previous_address']['flat_no'],true); 
            $street = json_decode($table['previous_address']['street'],true); 
            $area = json_decode($table['previous_address']['area'],true); 
            $city = json_decode($table['previous_address']['city'],true); 
            $pin_code = json_decode($table['previous_address']['pin_code'],true); 
            $nearest_landmark = json_decode($table['previous_address']['nearest_landmark'],true); 
            $states = json_decode($table['previous_address']['state'],true); 
            $countries = json_decode($table['previous_address']['country'],true); 
            $relationship = json_decode($table['previous_address']['contact_person_relationship'],true); 
            $duration_of_stay_start = json_decode($table['previous_address']['duration_of_stay_start'],true); 
            $duration_of_stay_end = json_decode($table['previous_address']['duration_of_stay_end'],true); 
            $contact_person_name = json_decode($table['previous_address']['contact_person_name'],true);  
            $codes = json_decode($table['previous_address']['code'],true);  

            $rental_agreement = json_decode($table['previous_address']['rental_agreement'],true);
            $ration_card = json_decode($table['previous_address']['ration_card'],true);
            $gov_utility_bill = json_decode($table['previous_address']['gov_utility_bill'],true);
         }
         for ($i = 0; $i < $previous_address; $i++) { ?>
            <div class="pg-frm">
               <div class="pg-txt">
                  <div class="pg-lft">Previous Address <?php echo $i+1; ?></div>
                  <div class="clr"></div>
               </div>
               <div class="row mt-3">
               <div class="col-md-12">
                  <div class="pg-frm-hd">Rental Agreement/ Driving License <span>(optional)</span></div>
                  <div id="fls">
                     <div class="form-group files">
                        <label class="btn" for="rental_agreement<?php echo $i; ?>"><a class="fl-btn ">Browse files</a></label>
                        <input id="rental_agreement<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n rental_agreement" multiple >
                        <div id="rental_agreement-img<?php echo $i; ?>"><?php
                           $rental = '';
                           if (isset($rental_agreement[$i])) {
                              if (!in_array('no-file', $rental_agreement[$i])) {
                                 foreach ($rental_agreement[$i] as $key => $value) {
                                    if ($value !='') {
                                       echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    }
                                 }
                                 $rental = $rental_agreement[$i];
                              }
                           } ?>
                        </div>
                       <input type="hidden" class="rental" value="<?php echo json_encode($rental); ?>">
                     </div>
                     <div id="rental_agreement-error<?php echo $i; ?>"></div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="pg-frm-hd">Upload Ration Card/ Aadhar Card <span>(optional)</span></div>
                  <div id="fls">
                     <div class="form-group files">
                        <label class="btn" for="ration_card<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                        <input id="ration_card<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n ration_card" multiple >
                        <div id="ration_card-img<?php echo $i; ?>"><?php
                           $ration = '';
                           if (isset($ration_card[$i])) {
                              if (!in_array('no-file', $ration_card[$i])) {
                                 foreach ($ration_card[$i] as $key => $value) { 
                                    if ($value !='') {
                                       echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    }
                                 }
                                 $ration = $ration_card[$i];
                              }
                           } ?>
                        </div>
                        <input type="hidden" class="ration" value="<?php echo json_encode($ration); ?>">
                     </div>
                     <div id="ration_card-error<?php echo $i; ?>"></div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="pg-frm-hd">Upload Government Utility Bill <span>(optional)</span></div>
                  <div id="fls">
                     <div class="form-group files">
                        <label class="btn" for="gov_utility_bill<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                        <input id="gov_utility_bill<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n gov_utility_bill" multiple >
                        <div id="gov_utility_bill-img<?php echo $i; ?>"><?php
                           $gov_utility = '';
                           if (isset($gov_utility_bill[$i])) {
                              if (!in_array('no-file',$gov_utility_bill[$i])) {
                                 foreach ($gov_utility_bill[$i] as $key => $value) { 
                                    if ($value !='') {
                                       echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    }
                                 }
                                 $gov_utility = $gov_utility_bill[$i];
                              }
                           } ?>
                        </div> 
                        <input type="hidden" class="gov_utility" value="<?php echo json_encode($gov_utility); ?>">
                     </div>
                     <div id="gov_utility_bill-error<?php echo $i; ?>"></div>
                  </div>
               </div>
            </div>
         <?php } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
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

<div class="modal fade" id="myModal-remove" role="dialog">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
         </div>
         <div class="modal-body">
            <div id="remove-caption"></div>
         </div>
         <div class="modal-footer">
            <div class="header-mn text-center" id="button-area">
               <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/previous-address-2.js" ></script>