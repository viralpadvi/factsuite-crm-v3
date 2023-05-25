<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-bankruptcy';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Bankruptcy</div>
         <div class="pg-rgt">Step <?php echo array_search('18',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <?php 
         $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $credit = 1;
         if (isset($form_values['bankruptcy_check'][0])?$form_values['bankruptcy_check'][0]:0 > 0) {
            $credit = $form_values['bankruptcy_check'][0];
         } 
         $bankruptcy = isset($table['bankruptcy'])?$table['bankruptcy']:''; // $this->db->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->row_array(); ?>
         <input type="hidden" name="bankruptcy_id" value="<?php echo  isset($bankruptcy['bankruptcy_id'])?$bankruptcy['bankruptcy_id']:''; ?>" id="bankruptcy_id">
         <?php $document_type = json_decode(isset($bankruptcy['document_type'])?$bankruptcy['document_type']:'-',true);
            $bankruptcy_number = json_decode(isset($bankruptcy['bankruptcy_number'])?$bankruptcy['bankruptcy_number']:'-',true);
            $bankruptcy_doc = json_decode(isset($bankruptcy['bankruptcy_doc'])?$bankruptcy['bankruptcy_doc']:'no-file',true);
            $document_number = '';
            for ($i = 0; $i < $credit; $i++) {  
               $doc_type = isset($document_type[$i]['document_type'])?$document_type[$i]['document_type']:'-';
               $pan = '';
               $nric = '';
               if ($doc_type == 'Passport') {
                  $pan = 'selected';
               } else if ($doc_type == 'NRIC') {
                  $nric = 'selected';
               }
               $document_number = isset($bankruptcy_number[$i]['bankruptcy_number'])?$bankruptcy_number[$i]['bankruptcy_number']:'';
            ?>
            <div class="full-bx">
               <div class="pg-frm-hd">Document Type</div>
               <select class="fld document-type" id="document-type-<?php echo $i; ?>" onchange="check_document_type(<?php echo $i; ?>)">
                 <option value=""> Select Document Type</option>
                 <option <?php echo $pan; ?> value="Passport">Passport</option>
                 <option <?php echo $nric; ?> value="NRIC">NRIC</option> 
               </select>
               <div id="document-type-error-<?php echo $i; ?>"></div>
            </div>
            <div class="full-bx">
               <div class="pg-frm-hd">Document Number</div>
               <input type="text" class="fld document-number" id="document-number-<?php echo $i; ?>" value="<?php echo $document_number;?>" onkeyup="check_document_number(<?php echo $i; ?>)" onblur="check_document_number(<?php echo $i; ?>)">
               <div id="document-number-error-<?php echo $i; ?>"></div>
            </div>
         <?php } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="add-document-check" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/bankruptcy.js" ></script>