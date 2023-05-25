<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-credit-cibil';
   }
</script>

<!-- candidate-credit-cibil.php -->

   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
     <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('17',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
          <span> <input type="checkbox" id="addresses" name=""> Copy details mentioned in personal details </span>
          
         <h6 class="full-nam2"> Credit History</h6>


         <?php 
           $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $credit = 1;
            if (isset($form_values['credit_\/ cibil check'][0])?$form_values['credit_\/ cibil check'][0]:0 > 0) {
               $credit = $form_values['credit_\/ cibil check'][0];
             } 

          $credit_data =  isset($table['credit_cibil'])?$table['credit_cibil']:'';//$this->db->where('candidate_id',$table['credit_cibil']['credit_id'])->get('credit_cibil')->row_array();
          ?>
          <input type="hidden" name="credit_id" value="<?php echo  isset($credit_data['credit_id'])?$credit_data['credit_id']:''; ?>" id="credit_id">
          <?php
           $document_type = json_decode(isset($credit_data['document_type'])?$credit_data['document_type']:'-',true);
           $credit_number = json_decode(isset($credit_data['credit_number'])?$credit_data['credit_number']:'-',true);
           $credit_cibil_doc = json_decode(isset($credit_data['credit_cibil_doc'])?$credit_data['credit_cibil_doc']:'no-file',true);
           // echo json_encode($credit_cibil_doc);
         	for ($i=0; $i < $credit; $i++) {   
             $doc_type = isset($document_type[$i]['document_type'])?$document_type[$i]['document_type']:'-';
            $pan = '';
            $pass = '';
            $nric = '';
            if ($doc_type == 'Pan Card') {
              $pan = 'selected';
            }else if ($doc_type == 'NRIC') {
              $nric = 'selected';
            }else if ($doc_type == 'Passport') {
              $pass = 'selected';
            }
         ?>
         
         <div class="row mt-3">
               
            <div class="col-md-4">

               <div class="pg-frm-hd">Document Type</div>
               <select class="fld form-control document_type" id="document_type<?php echo $i; ?>" >
                 <option value=""> Select Document Type</option>
                 <option <?php echo $pan; ?> value="Pan Card">Pan Card</option>
                 <option <?php echo $nric; ?> value="NRIC">NRIC</option>
                 <option  <?php echo $pass; ?> value="Passport">Passport</option>
               </select>
                <div id="document_type-error<?php echo $i; ?>">&nbsp;</div>
            </div>

            <div class="col-md-4">
               <div class="pg-frm-hd">Document Number</div>
               <input type="text"class="fld form-control credit_cibil_number" name="credit_cibil_number" id="credit_cibil_number<?php echo $i; ?>" value="<?php echo isset($credit_number[$i]['credit_cibil_number'])?$credit_number[$i]['credit_cibil_number']:''; ?>" >
               <div id="credit_cibil_number-error<?php echo $i; ?>">&nbsp;</div>
 
            </div>
               
         </div>

          <div class="row">
            
            <div class="col-md-3">
               <label class="pg-frm-hd-1">Country</label>
               <!-- <div class="pg-frm"> -->
                  <select class="fld form-control" id="nationality" >
                     <option value="">Select Country</option>
                     <?php
                        $c_id = '';
                      foreach ($country as $key => $value) {
                        if ($user['nationality'] == $value['name'] ) {
                           $c_id = $value['id'];
                          echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                        }else{
                          if ($value['name'] =='India') {
                           $c_id = $value['id'];
                            echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                          }
                          // echo "<option data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                        }
                      }
                     ?>
                  </select>
                  <div id="nationality-error">&nbsp;</div>
               <!-- </div>  -->
            </div>
               <div class="col-md-4">
                <div class="pg-frm-hd-1">
                   <label>State</label>
                   <?php
                   if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                      }
                      $city_id ='';
                   ?>
                   <select class="fld form-control state select2" onchange="valid_state()" id="state" >
                     <option selected value=''>Select State</option>
                      <?php 
                      $get = isset($table['credit_cibil']['credit_state'])?$table['credit_cibil']['credit_state']:'';
                      $get_state = isset($table['credit_cibil']['credit_state'])?$table['credit_cibil']['credit_state']:'Karnataka';
                      foreach ($state as $key1 => $val) {
                         if ($get == $val['name']) {
                          $city_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                           if ($get_state == $val['name']) {
                           $city_id = $val['id'];
                           }
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                    <div id="state-error"></div>
                </div>
             </div>
              <div class="col-md-3">
                <div class="pg-frm-hd-1">
                   <label>City/Town</label>
                   <!-- <input name="" class="fld form-control city" value="<?php echo isset($city[$i]['city'])?$city[$i]['city']:''; ?>"  onkeyup="valid_city()" id="city" type="text"> -->
                    <select class="fld form-control city select2" id="city" >
                     <option selected value=''>Select City/Town</option>
                     <?php 
                      $get_city = isset($table['credit_cibil']['credit_city'])?$table['credit_cibil']['credit_city']:''; 
                      $cities = $this->candidateModel->get_all_cities($city_id);
                      foreach ($cities as $key2 => $val) {
                         if ($get_city == $val['name']) { 
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                    
                   <div id="city-error">&nbsp;</div>
                </div>
             </div>
              <div class="col-md-3">
               <div class="pg-frm-hd-1">
                  <label>Pin Code</label>
                  <input name="" class="fld form-control" id="pincode" value="<?php echo isset($table['credit_cibil']['credit_pincode'])?$table['credit_cibil']['credit_pincode']:''; ?>" type="text">
                  <div id="pincode-error">&nbsp;</div>
               </div>
            </div>
             <div class="col-md-4">
               <div class="pg-frm"> 
                  <label>Permanent Address</label>
                  <textarea class="fld form-control address" placeholder="Please enter valid address" onkeyup="valid_address()" rows="4" id="address"><?php echo isset($table['credit_cibil']['credit_address'])?$table['credit_cibil']['credit_address']:''; ?></textarea> 
                   <div id="address-error">&nbsp;</div> 
               </div>
            </div>
         </div>
          <div class="row mt-3 d-none">  
            <div class="col-md-4">
               <div class="pg-frm-hd">Credit / Cibil Document </div>
            </div>
               
         </div>
         <div class="row d-none"> 

            <div class="col-md-4">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="credit_cibil<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                     <input id="credit_cibil<?php echo $i; ?>" type="file" style="display:none;" class="form-control fl-btn-n credit_cibil" multiple >
                     <div id="credit_cibil-docs-li<?php echo $i; ?>"> 
                       <?php
                     // $cv_doc = '';
                       if (isset($credit_cibil_doc[$i])) {
                       if (!in_array('no-file', $credit_cibil_doc[$i])) {
                         foreach ($credit_cibil_doc[$i] as $key => $value) {
                           if ($value !='') {
                             echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"credit-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"credit\")' data-path='credit-docs' data-field='cv_check' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                           }
                         }
                         // $cv_doc = $cv_data['cv_doc'];
                       }}
                       ?>
                     </div>
                      
                  </div>
               </div>
               <div id="credit_cibil-error-msg-div<?php echo $i; ?>"></div>
            </div>
              

         </div>
        <?php 
         	}  
         ?>
       
         
         <div class="row">
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add-credit-cibil" class="pg-submit-btn">Save &amp; Continue</button> 
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
<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-credit-cibil.js" ></script>
