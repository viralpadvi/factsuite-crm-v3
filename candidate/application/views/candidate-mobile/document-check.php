<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-document-check';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Document Check</div>
         <div class="pg-rgt">Step <?php echo array_search('3',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <?php 
         $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $document_check = 1;
         if (isset($form_values['document_check'][0])?$form_values['document_check'][0]:0 > 0) {
            $document_check = count($form_values['document_check']);
         } ?>
            <input type="hidden" id="document_check_count" value="<?php echo $document_check; ?>" name="">
            <input type="hidden" id="document_check_id" value="<?php echo isset($table['document_check']['document_check_id'])?$table['document_check']['document_check_id']:''?>" name="">
                  <?php  if (in_array(3, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>
            <div class="full-bx">
               <label>Passport Number <span>(Required)</span></label>
               <input type="text"class="fld" name="passport_number" id="passport_number" value="<?php echo isset($table['document_check']['passport_number'])?$table['document_check']['passport_number']:''?>" >
               <div id="passport_number-error"></div>
            </div>
            <div class="full-bx">
               <label>Passport Number <span>(Required)</span></label>
            </div>
            <div class="full-bx">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name1">
                     <?php
                        $passport_doc = '';
                        if (isset($table['document_check'])) {
                           if (!in_array('no-file', explode(',', $table['document_check']['passport_doc']))) {
                              foreach (explode(',', $table['document_check']['passport_doc']) as $key => $value) {
                                 if ($value !='') {
                                    echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"proof-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    echo "<div id='proof{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"proof-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_proof_documents{$key}' onclick='removeFile_documents({$key},\"proof\")' data-path='proof-docs' data-field='passport_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/passport_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                 }
                              }
                              $passport_doc = $table['document_check']['passport_doc'];
                           }
                        } ?>
                     </div>
                     <input type="hidden" id="passport_doc" value="<?php echo $passport_doc; ?>">
                  </div>
               </div>
               <div id="file1-error"></div>
            </div>
         <?php } ?>

         <?php  if (in_array(1, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>
            <div class="full-bx">
               <label>Pan Card Number <span>(Required)</span></label>
               <input type="text" class="fld" name="pan_number" id="pan_number" value="<?php echo isset($table['document_check']['pan_number'])?$table['document_check']['pan_number']:''?>" >
               <div id="pan_number-error"></div>
            </div>
            <div class="full-bx">
               <label>Pan Card Number <span>(Required)</span></label>
            </div>
            <div class="full-bx">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>
                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name2">
                        <?php $pan_card_doc = '';
                           if (isset($table['document_check'])) {
                              if (!in_array('no-file', explode(',', $table['document_check']['pan_card_doc']))) {
                                 foreach (explode(',', $table['document_check']['pan_card_doc']) as $key => $value) {
                                    if ($value !='') { 
                                       echo "<div id='pan{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"pan-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_pan_documents{$key}' onclick='removeFile_documents({$key},\"pan\")' data-path='pan-docs' data-field='pan_card_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  <a href='".base_url()."../uploads/pan_card_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                    }
                                 }
                                 $pan_card_doc = $table['document_check']['pan_card_doc'];
                              }
                           } ?>
                     </div>
                     <input type="hidden" id="pan_card_doc" value="<?php echo $pan_card_doc; ?>">
                  </div>
               </div>
               <div id="file2-error"></div>
            </div>
         <?php } ?>

         <?php  if (in_array(2, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>
            <div class="full-bx">
               <label>Aadhar Card Number <span>(Required)</span></label>
               <input type="text" class="fld" name="aadhar_number" id="aadhar_number" value="<?php echo isset($table['document_check']['aadhar_number'])?$table['document_check']['aadhar_number']:''?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  >
               <div id="aadhar_number-error"></div>
            </div>
            <div class="full-bx">
               <label>Aadhar Card Number <span>(Required)</span></label>
            </div>
            <div class="full-bx">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>
                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name3">
                     <?php $adhar_doc = '';
                        if (isset($table['document_check'])) {
                           if (!in_array('no-file', explode(',', $table['document_check']['adhar_doc']))) {
                              foreach (explode(',', $table['document_check']['adhar_doc']) as $key => $value) {
                                 if ($value !='') {
                                    echo "<div id='aadhar{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"aadhar-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_aadhar_documents{$key}' onclick='removeFile_documents({$key},\"aadhar\")' data-path='aadhar-docs' data-field='adhar_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  <a href='".base_url()."../uploads/adhar_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                 }
                              }
                              $adhar_doc = $table['document_check']['adhar_doc'];
                           }
                        } ?>
                     </div>
                     <input type="hidden" id="adhar_doc" value="<?php echo $adhar_doc; ?>">
                  </div>
               </div>
               <div id="file3-error"></div>
            </div>
         <?php } ?>

         <?php  if (in_array(4, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>
            <div class="full-bx">
               <label>Voter Number <span>(Required)</span></label>
               <input type="text" class="fld" name="voter_id" id="voter_id" value="<?php echo isset($table['document_check']['voter_id'])?$table['document_check']['voter_id']:''?>"   >
               <div id="voter_id-error"></div>
            </div>
            <div class="full-bx">
               <label>Voter Number <span>(Required)</span></label>
            </div>
            <div class="full-bx">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file4"><a class="fl-btn">Browse files</a></label>
                     <input id="file4" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name4">
                     <?php $voter_doc = '';
                        if (isset($table['document_check'])) {
                           if (!in_array('no-file', explode(',', $table['document_check']['voter_doc']))) {
                              foreach (explode(',', $table['document_check']['voter_doc']) as $key => $value) {
                                 if ($value !='') {
                                    echo "<div id='voter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"voter-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_aadhar_documents{$key}' onclick='removeFile_documents({$key},\"voter\")' data-path='voter-docs' data-field='voter_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  <a href='".base_url()."../uploads/voter_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                 }
                              }
                              $voter_doc = $table['document_check']['voter_doc'];
                           }
                        } ?>
                     </div>
                     <input type="hidden" id="voter_doc" value="<?php echo $voter_doc; ?>">
                  </div>
               </div>
               <div id="file4-error"></div>
            </div>
         <?php } ?>


      </div>
      <div id="save-data-error-msg"></div>
      <button id="add-document-check" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-document-check.js" ></script>