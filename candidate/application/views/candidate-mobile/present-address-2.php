<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-present-address';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Present Address</div>
         <div class="pg-rgt">Step <?php echo array_search('8',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <input name="" class="fld" value="<?php echo isset($table['present_address']['present_address_id'])?$table['present_address']['present_address_id']:''; ?>" id="present_address_id" type="hidden">
         <div class="full-bx">
            <label>Rental Agreement/ Driving License <span>(Optional)</span></label>
            <div id="fls">
               <div class="form-group files">
                  <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                  <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                  <div class="file-name1">
                     <?php $rental_agreement = '';
                     if (isset($table['present_address'])) {
                        if (!in_array('no-file', explode(',', $table['present_address']['rental_agreement']))) {
                           foreach (explode(',', $table['present_address']['rental_agreement']) as $key => $value) {
                              if ($value !='') {
                                 echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"rental\")' data-path='rental-docs' data-field='rental_agreement' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/rental-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                              }
                           }
                           $rental_agreement = $table['present_address']['rental_agreement'];
                        }
                     } ?>
                     </div>
                     <input type="hidden" id="rental_agreement" value="<?php echo $rental_agreement; ?>">
               </div>
            </div>
            <div id="file1-error"></div>
         </div>

         <div class="full-bx">
            <label>Upload Ration Card/ Aadhar Card <span>(Optional)</span></label>
            <div id="fls">
               <div class="form-group files">
                  <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>
                  <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                  <div class="file-name2">
                     <?php $ration_card = '';
                        if (isset($table['present_address'])) {
                           if (!in_array('no-file', explode(',', $table['present_address']['ration_card']))) {
                              foreach (explode(',', $table['present_address']['ration_card']) as $key => $value) { 
                                 if ($value !='') {
                                    echo "<div id='ration{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_ration_documents{$key}' onclick='removeFile_documents({$key},\"ration\")' data-path='ration-docs' data-field='ration_card' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/ration-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                 }
                              }
                              $ration_card = $table['present_address']['ration_card'];
                           }
                        } ?>
                     </div>
                     <input type="hidden" id="ration_card" value="<?php echo $ration_card; ?>">
                  </div>
               </div>
               <div id="file2-error"></div>
         </div>

         <div class="full-bx">
            <label>Upload Government Utility Bill <span>(Optional)</span></label>
            <div id="fls">
               <div class="form-group files">
                  <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>
                  <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                  <div class="file-name3">
                     <?php $gov_utility_bill = '';
                        if (isset($table['present_address'])) {
                           if (!in_array('no-file', explode(',', $table['present_address']['gov_utility_bill']))) {
                              foreach (explode(',', $table['present_address']['gov_utility_bill']) as $key => $value) { 
                                 if ($value !='') {
                                    echo "<div id='gov{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_gov_documents{$key}' onclick='removeFile_documents({$key},\"gov\")' data-path='gov-docs' data-field='gov_utility_bill' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/gov-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                 }
                              }
                              $gov_utility_bill = $table['present_address']['gov_utility_bill'];
                           }
                        } ?>
                     </div>
                  </div>
               </div>
               <div id="file3-error"></div>
         </div>
      </div>
      <!-- </div> -->
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<div class="modal fade " id="myModal-show" role="dialog">
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

<div class="modal fade " id="myModal-remove" role="dialog">
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

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/present-address-2.js" ></script>