<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-social-media';
   }
</script>

   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
       <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('25',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <h6 class="full-nam2">Social Media Check Details</h6>
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
                  <input name="" class="fld form-control name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['social_media']['candidate_name'])?$table['social_media']['candidate_name']:$user['first_name']; ?>" id="name" type="text">
                  <input name="" class="fld form-control global_id" value="<?php echo isset($table['social_media']['social_media_id'])?$table['social_media']['social_media_id']:''; ?>" id="global_id" type="hidden">
                   <div id="name-error">&nbsp;</div>
               </div>
            </div> 
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Date Of Birth</label>
                  <input name="" class="fld form-control mdate" disabled onblur="valid_date_of_birth()" onkeyup="valid_date_of_birth()" value="<?php echo isset($table['social_media']['dob'])?$table['social_media']['dob']:$user['date_of_birth']; ?>" id="date_of_birth" type="text">
                   <div id="date_of_birth-error">&nbsp;</div>
               </div>
            </div>

            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Latest Employment Company name </label>
                  <input name="employee-company" class="fld form-control" value="<?php echo isset($table['social_media']['employee_company_info'])?$table['social_media']['employee_company_info']:''; ?>" id="employee-company" type="text">
                  <div id="employee-company-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Highest Education College Name</label>
                  <input name="education" class="fld form-control" value="<?php echo isset($table['social_media']['education_info'])?$table['social_media']['education_info']:''; ?>" id="education" type="text">
                  <div id="education-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>University name</label>
                  <input name="university" class="fld form-control" value="<?php echo isset($table['social_media']['university_info'])?$table['social_media']['university_info']:''; ?>" id="university" type="text">
                  <div id="university-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label> Social media handles (if any)</label>
                  <input name="social_media_info" class="fld form-control" value="<?php echo isset($table['social_media']['social_media_info'])?$table['social_media']['social_media_info']:''; ?>" id="social_media_info" type="text">
                  <div id="social_media-error">&nbsp;</div>
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

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-social-media.js" ></script>


 