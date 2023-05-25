<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-global-database';
   }
</script>

   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
       <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('5',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <h6 class="full-nam2">Global Database Check Details</h6>
         <!-- <div class="row"> -->
        <!--     <div class="col-md-8">
               <div class="pg-frm">
                  <label>Address</label>
                  <textarea class="fld form-control address" rows="4" id="address"></textarea>
               </div>
            </div>

            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Pin Code</label>
                  <input name="" class="fld form-control pincode" id="pincode" type="text">
               </div>
            </div>

         </div> -->
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Candidate name</label>
                  <input name="" class="fld form-control name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['globaldatabase']['candidate_name'])?$table['globaldatabase']['candidate_name']:$user['first_name']; ?>" id="name" type="text">
                  <input name="" class="fld form-control global_id" value="<?php echo isset($table['globaldatabase']['globaldatabase_id'])?$table['globaldatabase']['globaldatabase_id']:''; ?>" id="global_id" type="hidden">
                   <div id="name-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Father's Name</label>
                  <input name="" class="fld form-control father_name" disabled onblur="valid_father_name()" onkeyup="valid_father_name()" value="<?php echo isset($table['globaldatabase']['father_name'])?$table['globaldatabase']['father_name']:$user['father_name']; ?>" id="father_name" type="text">
                   <div id="father_name-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Date Of Birth</label>
                  <input name="" class="fld form-control mdate" disabled onblur="valid_date_of_birth()" onkeyup="valid_date_of_birth()" value="<?php echo isset($table['globaldatabase']['dob'])?$table['globaldatabase']['dob']:$user['date_of_birth']; ?>" id="date_of_birth" type="text">
                   <div id="date_of_birth-error">&nbsp;</div>
               </div>
            </div>
         </div>
       
       
         
         <div class="row">
            <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add-global-database" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-global-database.js" ></script>
 