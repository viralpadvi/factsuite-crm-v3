<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-court-record';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Previous Address</div>
         <div class="pg-rgt">Step <?php echo array_search('2',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <input type="hidden" id="court_records_id" value="<?php echo isset($table['court_records']['court_records_id'])?$table['court_records']['court_records_id']:''; ?>" name="">
      <?php $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $court_record = 1;
         if (isset($form_values['court_record'][0])?$form_values['court_record'][0]:0 > 0) {
            $court_record = $form_values['court_record'][0];
         }  
         $j = 1;
         if (isset($table['court_records']['address'])) {
            $address = json_decode($table['court_records']['address'],true); 
            $states = json_decode($table['court_records']['state'],true);
            $countries = json_decode($table['court_records']['country'],true);
            $pin_code = json_decode($table['court_records']['pin_code'],true);
            $city = json_decode($table['court_records']['city'],true);
            $address_proof_doc = json_decode($table['court_records']['address_proof_doc'],true);
         }
         for ($i = 0; $i < $court_record; $i++) { ?>
            <div class="pg-frm">
               <div class="pg-txt">
                  <div class="pg-lft">Address Details <?php echo $i+1; ?></div>
                  <div class="clr"></div>
               </div>
               <div class="full-bx">
                  <label>Address Proof <span>(optional)</span></label>
                  <div id="fls">
                     <div class="form-group files"> 
                        <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                        <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                        <div class="file-name1"> 
                           <?php $cv_doc = '';
                           if (isset($address_proof_doc[$i])) {  
                              if (!in_array('no-file', explode(',', $address_proof_doc[$i]))) {
                                 foreach (explode(',', $address_proof_doc[$i]) as $key => $value) {
                                    if ($value !='') {
                                       echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"address-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/address-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                    }
                                 }
                                 $cv_doc = $address_proof_doc[$i];
                              }
                           } ?>
                           <input type="hidden" value="<?php echo  $cv_doc; ?>" name="court_doc" id="cv_doc">
                        </div>
                     </div>
                     <div id="file1-error"></div>
                  </div>
               </div>

            </div>
         <?php } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <div class="text-center">
         <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
      </div>
   </div>
</div>

<div class="modal fade" id="myModal-show" role="dialog">
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

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/court-record-2.js" ></script>