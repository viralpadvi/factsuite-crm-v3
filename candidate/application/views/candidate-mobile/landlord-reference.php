<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-landload-reference';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Landlord Reference</div>
         <div class="pg-rgt">Step <?php echo array_search('23',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <input type="hidden" id="landload_id" value="<?php echo isset($table['landload_reference']['landload_id'])?$table['landload_reference']['landload_id']:''; ?>">
      <?php $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $total_ref = count($form_values['previous_landlord_reference_check']);

         if ($total_ref ==0) {
            $total_ref = 1;
         }
         if (isset($table['landload_reference']['landload_id'])) {
            $tenant_name = json_decode($table['landload_reference']['tenant_name'],true);
            $case_contact_no = json_decode($table['landload_reference']['case_contact_no'],true);
            $landlord_name = json_decode($table['landload_reference']['landlord_name'],true);
         }
         for ($i = 0; $i < $total_ref; $i++) { ?>
            <div class="pg-frm">
               <div class="pg-txt">
                  <div class="pg-lft">Landlord Reference <?php echo $i+1; ?></div>
                  <div class="clr"></div>
               </div>
               <div class="full-bx">
                  <label>Landlord Name <span>(Required)</span></label>
                  <input id="landlord-name-<?php echo $i; ?>" class="fld landlord-name" onkeyup="check_landlord_name(<?php echo $i; ?>)" onblur="check_landlord_name(<?php echo $i; ?>)" value="<?php echo isset($landlord_name[$i]['landlord_name'])?$landlord_name[$i]['landlord_name']:''; ?>" type="text">
                  <div id="landlord-name-error-<?php echo $i; ?>"></div> 
               </div>

               <div class="full-bx">
                  <label>Landlord Contact Number <span>(Required)</span></label>
                  <input id="landlord-contact-no-<?php echo $i; ?>" class="fld landlord-contact-no" onkeyup="check_landlord_contact_no(<?php echo $i; ?>)" onblur="check_landlord_contact_no(<?php echo $i; ?>)" value="<?php echo isset($case_contact_no[$i]['case_contact_no'])?$case_contact_no[$i]['case_contact_no']:''; ?>" type="text">
                  <div id="landlord-contact-no-error-<?php echo $i; ?>"></div>
               </div>

            </div>
            <hr>
         <?php } ?>
      <div id="save-data-error-msg"></div>
      <div class="text-center">
         <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
      </div>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/landlord-reference.js" ></script>