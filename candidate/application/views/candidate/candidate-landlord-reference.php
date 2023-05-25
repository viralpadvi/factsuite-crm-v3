<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-landlord-reference';
   }
</script>

   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
      <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('23',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <input type="hidden" name="" id="landload_id" value="<?php echo isset($table['landload_reference']['landload_id'])?$table['landload_reference']['landload_id']:''; ?>">
          
         <div id="new_address">
         <?php 
             $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
               $total_ref = count($form_values['previous_landlord_reference_check']);
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo print_r($user);
             $refrence = 1; 

             if ($total_ref ==0) {
               $total_ref = 1;
             }

if (isset($table['landload_reference']['landload_id'])) {
 
$tenant_name = json_decode($table['landload_reference']['tenant_name'],true);
$case_contact_no = json_decode($table['landload_reference']['case_contact_no'],true);
$landlord_name = json_decode($table['landload_reference']['landlord_name'],true);
/*$tenancy_period = json_decode($table['landload_reference']['tenancy_period'],true);
$tenancy_period_comment = json_decode($table['landload_reference']['tenancy_period_comment'],true);
$monthly_rental_amount = json_decode($table['landload_reference']['monthly_rental_amount'],true);
$monthly_rental_amount_comment = json_decode($table['landload_reference']['monthly_rental_amount_comment'],true);
$occupants_property = json_decode($table['landload_reference']['occupants_property'],true);
$occupants_property_comment = json_decode($table['landload_reference']['occupants_property_comment'],true);
$tenant_consistently_pay_rent_on_time = json_decode($table['landload_reference']['tenant_consistently_pay_rent_on_time'],true);
$tenant_consistently_pay_rent_on_time_comment = json_decode($table['landload_reference']['tenant_consistently_pay_rent_on_time_comment'],true);
$utility_bills_paid_on_time = json_decode($table['landload_reference']['utility_bills_paid_on_time'],true);
$utility_bills_paid_on_time_comment = json_decode($table['landload_reference']['utility_bills_paid_on_time_comment'],true);
$rental_property = json_decode($table['landload_reference']['rental_property'],true);
$rental_property_comment = json_decode($table['landload_reference']['rental_property_comment'],true);
$maintenance_issues = json_decode($table['landload_reference']['maintenance_issues'],true);
$maintenance_issues_comment = json_decode($table['landload_reference']['maintenance_issues_comment'],true);
$tenant_leave = json_decode($table['landload_reference']['tenant_leave'],true);
$tenant_leave_comment = json_decode($table['landload_reference']['tenant_leave_comment'],true);
$tenant_rent_again = json_decode($table['landload_reference']['tenant_rent_again'],true);
$complaints_from_neighbors = json_decode($table['landload_reference']['complaints_from_neighbors'],true);
$complaints_from_neighbors_comment = json_decode($table['landload_reference']['complaints_from_neighbors_comment'],true);

$tenant_rent_again_comment = json_decode($table['landload_reference']['tenant_rent_again_comment'],true);
$any_pets = json_decode($table['landload_reference']['any_pets'],true);
$any_pets_comment = json_decode($table['landload_reference']['any_pets_comment'],true);
$food_preference = json_decode($table['landload_reference']['food_preference'],true);
$food_preference_comment = json_decode($table['landload_reference']['food_preference_comment'],true);
$spare_time = json_decode($table['landload_reference']['spare_time'],true);
$spare_time_comment = json_decode($table['landload_reference']['spare_time_comment'],true);
$overall_character = json_decode($table['landload_reference']['overall_character'],true);
$overall_character_comment   = json_decode($table['landload_reference']['overall_character_comment'],true);
*/
}

      for ($i=0; $i < $total_ref; $i++) {  
              ?>
              <div id="form">
              <h6 class="full-nam2">Landlord Reference</h6>
         <div class="row">
            <div class="col-md-4 d-none">
               <div class="pg-frm">
                  <label>Tenant Name</label>
                  <input name="tenant_name" id="tenant_name" class="fld form-control tenant_name" value="<?php echo isset($tenant_name[$i]['tenant_name'])?$tenant_name[$i]['tenant_name']:''; ?>" type="text">
                  <div id="tenant_name-error"></div>
               </div>
            </div>
             <div class="col-md-4">
               <div class="pg-frm">
                  <label>Landlord Name</label>
                  <input name="landlord_name" id="landlord_name<?php echo $i; ?>" class="fld form-control landlord_name" onkeyup="valid_name(<?php echo $i; ?>)" value="<?php echo isset($landlord_name[$i]['landlord_name'])?$landlord_name[$i]['landlord_name']:''; ?>" type="text">
                  <div id="landlord_name-error<?php echo $i; ?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Landlord Contact Number</label>
                  <input name="case_contact_no" id="case_contact_no<?php echo $i; ?>" class="fld form-control case_contact_no"  onkeyup="valid_contact_no(<?php echo $i; ?>)" value="<?php echo isset($case_contact_no[$i]['case_contact_no'])?$case_contact_no[$i]['case_contact_no']:''; ?>" type="text">
                  <div id="case_contact_no-error<?php echo $i; ?>"></div>
               </div>
            </div>
            
         </div>

         
 
         <hr>
         </div>

         <?php 
            }
         ?>
              
      </div>
         
         <div class="row">
          <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add_reference_landload" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>


<script src="<?php echo base_url(); ?>assets/custom-js/candidate/landload_reference.js" ></script>
