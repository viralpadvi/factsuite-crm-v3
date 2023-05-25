
   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
     <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('3',array_values(explode(',', $component_ids)))+1 ?>/<?php echo count(explode(',', $component_ids))+1;?></div>
         <h6 class="full-nam2"> Document Check</h6>
         <?php 
            $form_values = json_decode($user['form_values'],true);
                   $form_values = json_decode($form_values,true);
                   // echo $form_values['reference'][0];
                   // echo $form_values['previous_address'][0];
                   // echo json_encode($form_values['drug_test']);
                   // echo $user['form_values'];
                   $document_check = 1;
                  if (isset($form_values['document_check'][0])?$form_values['document_check'][0]:0 > 0) {
                     $document_check = count($form_values['document_check']);
                   } 
                   
         ?>
         <div class="row mt-3">
               <input type="hidden" id="document_check_count" value="<?php echo $document_check; ?>" name="">
               <input type="hidden" id="document_check_id" value="<?php echo isset($table['document_check']['document_check_id'])?$table['document_check']['document_check_id']:''?>" name="">
               <?php  if (in_array(3, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Passport Number</div>
               <input type="text"class="fld form-control" name="passport_number" id="passport_number" value="<?php echo isset($table['document_check']['passport_number'])?$table['document_check']['passport_number']:''?>" >
               <div id="passport_number-error">&nbsp;</div>
            </div>
               <?php } ?>
                <?php  if (in_array(1, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Pan Card Number </div>
               <input type="text" class="fld form-control" name="pan_number" id="pan_number" value="<?php echo isset($table['document_check']['pan_number'])?$table['document_check']['pan_number']:''?>" >
               <div id="pan_number-error">&nbsp;</div>
            </div>
             <?php } ?>
              <?php  if (in_array(2, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Aadhar Card Number</div>
               <input type="text" class="fld form-control" name="aadhar_number" id="aadhar_number" value="<?php echo isset($table['document_check']['aadhar_number'])?$table['document_check']['aadhar_number']:''?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  >
               <div id="aadhar_number-error">&nbsp;</div>
            </div>
             <?php } ?>
             <?php  if (in_array(4, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Voter Number</div>
               <input type="text" class="fld form-control" name="voter_id" id="voter_id" value="<?php echo isset($table['document_check']['voter_id'])?$table['document_check']['voter_id']:''?>"   >
               <div id="voter_id-error">&nbsp;</div>
            </div>
             <?php } ?>
                <?php  if (in_array(5, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">SSN Number</div>
               <input type="text" class="fld form-control" name="ssn_number" id="ssn_number" value="<?php echo isset($table['document_check']['ssn_number'])?$table['document_check']['ssn_number']:''?>"   >
               <div id="ssn_number-error">&nbsp;</div>
            </div>
             <?php } ?>
            
         </div>
          <div class="row mt-3"> 
               <?php  if (in_array(3, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Passport Number</div>
            </div>
               <?php } ?>
                <?php  if (in_array(1, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Pan Card Number </div>
            </div>
             <?php } ?>
              <?php  if (in_array(2, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Aadhar Card Number</div>
            </div>
             <?php } ?>
            
             <?php  if (in_array(4, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Voter Number</div>
            </div>
             <?php } ?> 
             
             <?php  if (in_array(5, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div class="pg-frm-hd">Upload SSN Card image</div>
            </div>
             <?php } ?> 
         </div>
         <div class="row">
             <?php  if (in_array(3, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
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
                             echo "<div id='proof{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"proof-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_proof_documents{$key}' onclick='removeFile_documents({$key},\"proof\")' data-path='proof-docs' data-field='passport_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                          }
                           
                         }
                          $passport_doc = $table['document_check']['passport_doc'];
                       }}
                       ?>
                     </div>
                     
                      <input type="hidden" id="passport_doc" value="<?php echo $passport_doc; ?>">
                  </div>
               </div>
               <div id="file1-error"></div>
            </div>
             <?php } ?>
              <?php  if (in_array(1, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>
                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name2"><?php
                     $pan_card_doc = '';
                       if (isset($table['document_check'])) {
                       if (!in_array('no-file', explode(',', $table['document_check']['pan_card_doc']))) {
                         foreach (explode(',', $table['document_check']['pan_card_doc']) as $key => $value) {
                           if ($value !='') { 
                             echo "<div id='pan{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"pan-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_pan_documents{$key}' onclick='removeFile_documents({$key},\"pan\")' data-path='pan-docs' data-field='pan_card_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                           }
                         }
                       $pan_card_doc = $table['document_check']['pan_card_doc'];
                       }} 
                       ?></div>
                        <input type="hidden" id="pan_card_doc" value="<?php echo $pan_card_doc; ?>">
                  </div>
               </div>
               <div id="file2-error"></div>
            </div>
             <?php } ?>
              <?php  if (in_array(2, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>
                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name3"><?php
                     $adhar_doc = '';
                       if (isset($table['document_check'])) {
                       if (!in_array('no-file', explode(',', $table['document_check']['adhar_doc']))) {
                         foreach (explode(',', $table['document_check']['adhar_doc']) as $key => $value) {
                           if ($value !='') {
                             echo "<div id='aadhar{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"aadhar-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_aadhar_documents{$key}' onclick='removeFile_documents({$key},\"aadhar\")' data-path='aadhar-docs' data-field='adhar_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                          }
                         }
                         $adhar_doc = $table['document_check']['adhar_doc'];
                       }}
                       ?></div>
                       <input type="hidden" id="adhar_doc" value="<?php echo $adhar_doc; ?>">
                  </div>
               </div>
               <div id="file3-error"></div>
            </div>
             <?php } ?>




              <?php  if (in_array(4, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file4"><a class="fl-btn">Browse files</a></label>
                     <input id="file4" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name4"><?php
                     $voter_doc = '';
                       if (isset($table['document_check'])) {
                       if (!in_array('no-file', explode(',', $table['document_check']['voter_doc']))) {
                         foreach (explode(',', $table['document_check']['voter_doc']) as $key => $value) {
                           if ($value !='') {
                             echo "<div id='voter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"voter-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_aadhar_documents{$key}' onclick='removeFile_documents({$key},\"voter\")' data-path='voter-docs' data-field='voter_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                          }
                         }
                         $voter_doc = $table['document_check']['voter_doc'];
                       }}
                       ?></div>
                       <input type="hidden" id="voter_doc" value="<?php echo $voter_doc; ?>">
                  </div>
               </div>
               <div id="file4-error"></div>
            </div>
             <?php } ?>


              <?php  if (in_array(5, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?> 
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file5"><a class="fl-btn">Browse files</a></label>
                     <input id="file5" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name5"><?php
                     $ssn_doc = '';
                       if (isset($table['document_check'])) {
                       if (!in_array('no-file', explode(',', $table['document_check']['ssn_doc']))) {
                         foreach (explode(',', $table['document_check']['ssn_doc']) as $key => $value) {
                           if ($value !='') {
                             echo "<div id='ssn{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ssn_doc\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_aadhar_documents{$key}' onclick='removeFile_documents({$key},\"ssn\")' data-path='ssn-docs' data-field='ssn_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  <a href='".base_url()."../uploads/ssn_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                         }
                         $ssn_doc = $table['document_check']['ssn_doc'];
                       }}
                       ?></div>
                       <input type="hidden" id="ssn_doc" value="<?php echo $ssn_doc; ?>">
                  </div>
               </div>
               <div id="file5-error"></div>
            </div>
             <?php } ?>


         </div>
       
       
         
         <div class="row">
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add-document-check" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>

  <div class="modal fade " id="myModal-show" role="dialog">
 <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
        <div class="modal-header border-0">
          <h3 id="">View Document</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
         <div class="col-md-12 text-center" id="view-img"></div>
    </div>
          <div class="row p-5 mt-2">
              <div class="col-md-6" id="setupDownloadBtn">
                
              </div>
              <div id="view-edit-cancel-btn-div" class="col-md-6  text-right">
                <button class="btn bg-blu text-white exit-btn" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
        <!-- <div class="modal-footer border-0"></div> -->
      </div>
    </div>
</div>



<div class="modal fade " id="myModal-remove" role="dialog">
    <div class="modal-dialog modal-md">
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


<script src="<?php echo base_url(); ?>assets/custom-js/candidate/insuff/candidate-document-check-insuff.js" ></script>
 