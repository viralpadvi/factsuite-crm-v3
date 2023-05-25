<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-bankruptcy';
   }
</script>
<!-- candidate-credit-cibil.php -->

   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
     <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('18',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <h6 class="full-nam2"> Bankruptcy</h6>

         <?php 
          $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $credit = 1;
            if (isset($form_values['bankruptcy_check'][0])?$form_values['bankruptcy_check'][0]:0 > 0) {
               $credit = $form_values['bankruptcy_check'][0];
             } 
          $bankruptcy = isset($table['bankruptcy'])?$table['bankruptcy']:''; // $this->db->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->row_array();
          ?>
          <input type="hidden" name="bankruptcy_id" value="<?php echo  isset($bankruptcy['bankruptcy_id'])?$bankruptcy['bankruptcy_id']:''; ?>" id="bankruptcy_id">
         <?php 
          $document_type = json_decode(isset($bankruptcy['document_type'])?$bankruptcy['document_type']:'-',true);
         $bankruptcy_number = json_decode(isset($bankruptcy['bankruptcy_number'])?$bankruptcy['bankruptcy_number']:'-',true);
           $bankruptcy_doc = json_decode(isset($bankruptcy['bankruptcy_doc'])?$bankruptcy['bankruptcy_doc']:'no-file',true);
          for ($i=0; $i < $credit; $i++) {  
            $doc_type = isset($document_type[$i]['document_type'])?$document_type[$i]['document_type']:'-';
            $pan = '';
            $nric = '';
            if ($doc_type == 'Passport') {
              $pan = 'selected';
            }else if ($doc_type == 'NRIC') {
              $nric = 'selected';
            }
         ?>
         
         <div class="row mt-3">

           <div class="col-md-4">

               <div class="pg-frm-hd">Document Type</div>
               <select class="fld form-control document_type" id="credit_type<?php echo $i; ?>" >
                 <option value=""> Select Document Type</option>
                 <option <?php echo $pan; ?> value="Passport">Passport</option>
                 <option <?php echo $nric; ?> value="NRIC">NRIC</option> 
               </select>
                <div id="document_type-error<?php echo $i; ?>">&nbsp;</div>
              </div>
               
            <div class="col-md-4">
               <div class="pg-frm-hd">Document Number</div>
               <input type="text"class="fld form-control bankruptcy" name="bankruptcy" id="bankruptcy<?php echo $i; ?>" value="<?php echo isset($bankruptcy_number[$i]['bankruptcy_number'])?$bankruptcy_number[$i]['bankruptcy_number']:''; ?>" >
               <div id="bankruptcy-error<?php echo $i; ?>">&nbsp;</div>
            </div>
               
         </div>
          <div class="row mt-3 d-none">  
            <div class="col-md-4">
               <div class="pg-frm-hd">Bankruptcy Document </div>
            </div>
               
         </div>
         <div class="row d-none"> 

            <div class="col-md-4">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="bankruptcy_doc<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                     <input id="bankruptcy_doc<?php echo $i; ?>" type="file" style="display:none;" class="form-control fl-btn-n bankruptcy_doc" multiple >
                     <div id="bankruptcy_doc-docs-li<?php echo $i; ?>"> 
                       <?php
                     // $cv_doc = '';
                       if (isset($bankruptcy_doc[$i])) {
                       if (!in_array('no-file', $bankruptcy_doc[$i])) {
                         foreach ($bankruptcy_doc[$i] as $key => $value) {
                           if ($value !='') {
                             echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"bankruptcy\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"bankruptcy\")' data-path='bankruptcy' data-field='cv_check' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                           }
                         }
                         // $cv_doc = $cv_data['cv_doc'];
                       }}
                       ?>
                     </div>
                      
                  </div>
               </div>
               <div id="bankruptcy_doc-error-msg-div<?php echo $i; ?>"></div>
            </div>
              

         </div>
        <?php 
          }  
         ?>
       
         
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
    <div class="modal-dialog modal-md">
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


<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-bankruptcy.js" ></script>
