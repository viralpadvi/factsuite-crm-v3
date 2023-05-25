<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-global-database';
   }
</script>
 
<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Global Database</div>
         <div class="pg-rgt">Step <?php echo array_search('5',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <div class="full-bx">
            <label>Candidate name</label>
            <input name="" class="fld form-control name"  disabled onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($table['globaldatabase']['candidate_name'])?$table['globaldatabase']['candidate_name']:$user['first_name']; ?>" id="name" type="text">
            <input name="" class="fld form-control global_id" value="<?php echo isset($table['globaldatabase']['globaldatabase_id'])?$table['globaldatabase']['globaldatabase_id']:''; ?>" id="global_id" type="hidden">
            <div id="name-error"></div>
         </div>
         <div class="full-bx">
            <label>Father's Name</label>
            <input name="" class="fld form-control father_name" disabled onblur="valid_father_name()" onkeyup="valid_father_name()" value="<?php echo isset($table['globaldatabase']['father_name'])?$table['globaldatabase']['father_name']:$user['father_name']; ?>" id="father_name" type="text">
            <div id="father_name-error"></div>
         </div>
         <div class="full-bx">
            <label>Date Of Birth</label>
            <input name="" class="fld form-control mdate" disabled onblur="valid_date_of_birth()" onkeyup="valid_date_of_birth()" value="<?php echo isset($table['globaldatabase']['dob'])?$table['globaldatabase']['dob']:$user['date_of_birth']; ?>" id="date_of_birth" type="text">
            <div id="date_of_birth-error"></div>
         </div>
      </div>
      <div id="save-data-error-msg"></div>
      <button class="pg-nxt-btn" id="add-global-database">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-global-database.js" ></script>