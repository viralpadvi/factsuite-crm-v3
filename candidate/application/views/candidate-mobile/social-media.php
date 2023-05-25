<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-social-media';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Social Media Check</div>
         <div class="pg-rgt">Step <?php echo array_search('25',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <div class="full-bx">
            <label>Candidate name</label>
            <input class="fld name" disabled value="<?php echo isset($table['social_media']['candidate_name'])?$table['social_media']['candidate_name']:$user['first_name'];?>" id="name" type="text">
         </div>
         <div class="full-bx">
            <label>Latest Employment Company name <span>(Required)</span></label>
            <input class="fld" value="<?php echo isset($table['social_media']['employee_company_info'])?$table['social_media']['employee_company_info']:''; ?>" id="latest-employement-company-name" type="text">
            <div id="latest-employement-company-name-error"></div>
         </div>
         <div class="full-bx">
            <label>Highest Education College Name <span>(Required)</span></label>
            <input class="fld" value="<?php echo isset($table['social_media']['education_info'])?$table['social_media']['education_info']:''; ?>" id="highest-education-college-name" type="text">
            <div id="highest-education-college-name-error"></div>
         </div>
         <div class="full-bx">
            <label>University name <span>(Required)</span></label>
            <input class="fld" value="<?php echo isset($table['social_media']['university_info'])?$table['social_media']['university_info']:''; ?>" id="university-name" type="text">
            <div id="university-name-error"></div>
         </div>
         <div class="full-bx">
            <label>Social media handles <span>(if any)</span></label>
            <input class="fld" value="<?php echo isset($table['social_media']['social_media_info'])?$table['social_media']['social_media_info']:''; ?>" id="social-media" type="text">
            <div id="social-media-error"></div>
         </div>
      </div>
      <div id="save-data-error-msg"></div>
      <button class="pg-nxt-btn" id="save-details-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/social-media.js"></script>