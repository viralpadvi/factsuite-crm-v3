  <?php 
    extract($_GET);
  ?>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt pt-3">
        <!--Add Client Content-->
         <div class=""> 
           <a href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/edit-website-package-details?package_id=<?php echo $package_id; ?>" class="btn bg-blu btn-submit-cancel text-white"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="add-client-bx">
           <h3>Package Details</h3>
           <div class="card">
            <div class="row p-3">
              <div class="col-md-6">
                  <label>Service Name : </label>
                  <label><?php echo $package['service_name'];?></label>
              </div>
              <div class="col-md-6">
                  <label>Package Name : </label>
                  <label><?php echo $package['name'];?></label>
              </div>
              <div class="col-md-6 mt-3">
                  <label>Package Type : </label>
                  <label><?php echo $package['package_type'];?></label>
              </div>
              <div class="col-md-6 mt-3">
                <label>Select Component : </label>
                <?php 
                  $selected_package_components = explode(',',$selected_package_component_list['package_selected_component_and_alacarte_list']['package_alacarte_components']);
                ?>
                <?php 
                  $selected_components_array = [];
                  $test_array = [];
                  if ($package['alacarte_component_included_details'] != '') {
                    foreach (json_decode($package['alacarte_component_included_details'],true) as $key => $value) { 
                      array_push($selected_components_array,$value['component_id']);
                    }
                  }
                ?>
                <select class="form-control fld auto-width" id="alacarte-component-details" >
                  <?php
                  foreach ($selected_package_component_list['selected_package_alacarte_component_list'] as $key => $value) { 
                    $disabled = '';
                    $selected = '';
                    if (in_array($value['component_id'],$selected_components_array)) {
                      $disabled = 'disabled';
                    }
                    if ($key == 0) {
                      $selected = 'selected';
                    }
                  ?>
                  <option value="<?php echo $value['component_id']?>" <?php echo $disabled;?> <?php echo $selected; ?>><?php echo $value['component_name']?></option>
                  <?php } ?>
                </select>
                </div>
             </div>
            </div>
           <div id="display-alacarte-component-details">
             <?php 
              $j = 1;
              if ($package['alacarte_component_included_details'] != '') {
              $alacarte_component = json_decode($package['alacarte_component_included_details'],true);
                if (count($alacarte_component) > 0) {
                  foreach ($alacarte_component as $key => $com) { 
                    $thresold =  $this->packageModel->single_component_details($com['component_id']);
                   // echo json_encode($thresold['form_threshold']);

                    $type_of_price = isset($com['type_of_price'])?$com['type_of_price']:0;
                   $client_price = 'checked';
                   $check = '';
                   $style ="style='display:none;'";
                   if ($type_of_price !='1') {
                      $client_price = '';
                   $check = 'checked';
                    $style = "";
                   }
                    ?>
        <div class="row ul<?php echo $com['alacarte_id']; ?>">
          <div class="col-md-12" id="component-error-<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>"></div>
          <div class="col-md-4 mt-1">
          
          <div class="custom-control custom-radio custom-control-inline mrg">
          <input type="radio" <?php echo $check; ?> class="custom-control-input component_price_type" onchange="set_alacarte_form_value('<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>',0)" name="component_price_type<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>" value="0" id="customradio<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>">
          <label class="custom-control-label" for="customradio<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>">Form Base Price</label>
          </div>

                </div>
                <div class="col-md-4 mt-1"> 

          <div class="custom-control custom-radio custom-control-inline mrg">
          <input type="radio" <?php echo $client_price; ?> class="custom-control-input component_price_type" onchange="set_alacarte_form_value('<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>',1)" name="component_price_type<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>" value="1" id="customradio<?php echo $com['component_id']; ?>">
          <label class="custom-control-label" for="customradio<?php echo  $com['component_id']; ?>">Component Base Price</label>
          </div>

                </div>
                <div class="col-md-4 mt-1"> 
          </div>


          <div class="col-md-4 mt-1">
          <div class="custom-control custom-checkbox custom-control-inline mrg">
          <input type="checkbox" disabled checked class="custom-control-input component_names" data-package_id="<?php echo $com['alacarte_id']; ?>" name="customCheck" value="<?php echo $com['component_id']; ?>" data-component_name="<?php echo $com['component_name']; ?>" id="customCheck<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>">
          <label class="custom-control-label" for="customCheck<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>"><?php echo $com['component_name']; ?></label>
          </div>
          </div>
          <div class="col-md-4 mt-1">
        <label>Component Standard Price</label>
          <input type="hidden" class="form-control fld2 component_package_id"  value="<?php echo $com['alacarte_id']; ?>" id="component_package_ids<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>">
          <input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="<?php echo isset($com['component_standard_price'])?$com['component_standard_price']:0; ?>" id="component_standard_price<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>">
          </div>
          <div class="col-md-4 mt-1">
        <label>Client Standard Price</label>
          <input type="number"  min="0" oninput="this.value = Math.abs(this.value)" class="form-control fld2 component_price" value="<?php echo isset($com['component_price'])?$com['component_price']:0; ?>" id="component_price<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>" oninput="oninput_float(<?php echo $key; ?>)" onkeypress="return oninput_fun(event)" onkeyup="component_price(<?php echo $key; ?>)">
          </div>

          <?php
          // echo count($com['form_data']);

          if ($com['component_id'] == 3) {
          
              $doc = $this->db->get('document_type')->result_array();
            
            if ($doc > 0) {
            $n =1;
            foreach ($doc as $f => $for) { 

              // echo json_encode($com['form_data']);

           $keys = array_search($for['document_type_id'],array_column($com['form_data'], 'form_id'));
           $checked = '';
           $form_id =  isset($com['form_data'][$keys]['form_id'])?$com['form_data'][$keys]['form_id']:'-';
              if ($form_id == $for['document_type_id']) {
              $checked ='checked';
              }
                 ?>
            <div class="col-md-2 mt-1"> 
                  <div class="custom-control custom-checkbox custom-control-inline mrg">
            <input type="checkbox" <?php echo $checked; ?> class="custom-control-input input_<?php echo $com['alacarte_id'].'_form_'.$com['component_id']; ?>"  data-package_id="<?php echo $com['alacarte_id'] ?>" name="form<?php echo $for['document_type_id']; ?>" value="<?php echo $for['document_type_id']; ?>" id="customradiopackeducheckform_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['document_type_id']; ?>">
            <label class="custom-control-label" for="customradiopackeducheckform_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['document_type_id']; ?>"> <?php echo $for['document_type_name']; ?></label><input type="hidden" class="form-control fld form" value="<?php echo $for['document_type_id']; ?>" id="form_threshold<?php echo $for['document_type_id']; ?>" >
            </div>
                  </div>
                  <div class="col-md-2 mt-1" >
            <input type="number" <?php echo $style; ?>  min="0" oninput="this.value = Math.abs(this.value)" onkeyup="get_form_input_value(<?php echo $com['alacarte_id']; ?>,<?php echo $com['component_id']; ?>,<?php echo $for['document_type_id']; ?>)" class="form-control fld2 text_form_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>" value="<?php echo isset($com['form_data'][$keys]['form_value'])?$com['form_data'][$keys]['form_value']:0;?>" id="text_form_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['document_type_id']; ?>" >
            </div> 

            <?php
            $n++;
              }
            }
          }else if($com['component_id'] == 4){
          // html +=drug;
             // echo json_encode($com['form_data']);
              $drug = $this->db->get('drug_test_type')->result_array();
            if ($drug > 0) {
            $n =1;
            foreach ($drug as $f => $for) { 

              $keys = array_search($for['drug_test_type_id'],array_column($com['form_data'], 'form_id'));
           $checked = '';
            $form_id =  isset($com['form_data'][$keys]['form_id'])?$com['form_data'][$keys]['form_id']:'-';
               $form_value = '';
              if ( $form_id == $for['drug_test_type_id']) {
              $checked ='checked';
              $form_value = isset($com['form_data'][$keys]['form_value'])?$com['form_data'][$keys]['form_value']:0;
              }

              
                 ?>
            <div class="col-md-2 mt-1"> 
                  <div class="custom-control custom-checkbox custom-control-inline mrg">
            <input type="checkbox" <?php echo $checked; ?> class="custom-control-input input_<?php echo $com['alacarte_id'].'_form_'.$com['component_id']; ?>"  data-package_id="<?php echo $com['alacarte_id'] ?>" name="form<?php echo $for['drug_test_type_id']; ?>" value="<?php echo $for['drug_test_type_id']; ?>" id="customradiopackeducheckform_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['drug_test_type_id']; ?>">
            <label class="custom-control-label" for="customradiopackeducheckform_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['drug_test_type_id']; ?>"> <?php echo $for['drug_test_type_name']; ?></label><input type="hidden" class="form-control fld form" value="<?php echo $for['drug_test_type_id']; ?>" id="form_threshold<?php echo $for['drug_test_type_id']; ?>" >
            </div>
                  </div>
                  <div class="col-md-2 mt-1" >
            <input type="number" <?php echo $style; ?>  min="0" oninput="this.value = Math.abs(this.value)" onkeyup="get_form_input_value(<?php echo $com['alacarte_id']; ?>,<?php echo $com['component_id']; ?>,<?php echo $for['drug_test_type_id']; ?>)" class="form-control fld2 text_form_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>" value="<?php echo  $form_value;?>" id="text_form_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['drug_test_type_id']; ?>" >
            </div> 

            <?php
              $n++;
              }
            }
          }else if($com['component_id'] == 7){
          // html +=edu;

              $edu = $this->db->get('education_type')->result_array();
             if ($edu  > 0) {
            $n =1;
            foreach ($edu  as $f => $for) { 
                 
              $keys = array_search($for['education_type_id'],array_column($com['form_data'], 'form_id'));
           $checked = '';
            $form_id =  isset($com['form_data'][$keys]['form_id'])?$com['form_data'][$keys]['form_id']:'-';
               $form_value = '';
              if ( $form_id == $for['education_type_id']) {
              $form_value = isset($com['form_data'][$keys]['form_value'])?$com['form_data'][$keys]['form_value']:0;
              $checked ='checked';
              }

          
                 ?>
            <div class="col-md-2 mt-1"> 
                  <div class="custom-control custom-checkbox custom-control-inline mrg">
            <input type="checkbox" <?php echo $checked; ?> class="custom-control-input input_<?php echo $com['alacarte_id'].'_form_'.$com['component_id']; ?>"  data-package_id="<?php echo $com['alacarte_id'] ?>" name="form<?php echo $for['education_type_id']; ?>" value="<?php echo $for['education_type_id']; ?>" id="customradiopackeducheckform_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['education_type_id']; ?>">
            <label class="custom-control-label" for="customradiopackeducheckform_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['education_type_id']; ?>"> <?php echo $for['education_type_name']; ?></label><input type="hidden" class="form-control fld form" value="<?php echo $for['education_type_id']; ?>" id="form_threshold<?php echo $for['education_type_id']; ?>" >
            </div>
                  </div>
                  <div class="col-md-2 mt-1" >
            <input type="number" <?php echo $style; ?>  min="0" oninput="this.value = Math.abs(this.value)"  onkeyup="get_form_input_value(<?php echo $com['alacarte_id']; ?>,<?php echo $com['component_id']; ?>,<?php echo $for['education_type_id']; ?>)" class="form-control fld2 text_form_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>" value="<?php echo $form_value;?>" id="text_form_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $for['education_type_id']; ?>" >
            </div> 

            <?php
              $n++;
              }
            }
           }else if (!in_array($com['component_id'], [3,4,7])) {
          if ($thresold['form_threshold'] > 0) {
            $n =1;
            // foreach ($com['form_data'] as $f => $for) { 
            for ($i=1; $i <= $thresold['form_threshold']; $i++) { 

              $keys = array_search($i,array_column($com['form_data'], 'form_id'));
           $checked = '';
              $disabled = '';
              $form_value = '';
              $form_id = isset($com['form_data'][$keys]['form_id'])?$com['form_data'][$keys]['form_id']:'0';
              if ($form_id == $i) {
              $form_value = isset($com['form_data'][$keys]['form_value'])?$com['form_data'][$keys]['form_value']:0;
              $checked ='checked';
              }else{
                $disabled = 'disabled';

              } 
            
                 ?>
            <div class="col-md-2 mt-1"> 
                  <div class="custom-control custom-checkbox custom-control-inline mrg">
            <input type="checkbox" onchange="get_form_input_value_check(<?php echo $com['alacarte_id']; ?>,<?php echo $com['component_id']; ?>,<?php echo $i; ?>)"  <?php echo $checked; echo $disabled; ?> class="custom-control-input input_<?php echo $com['alacarte_id'].'_form_'.$com['component_id']; ?>"  data-package_id="<?php echo $com['alacarte_id'] ?>" name="form<?php echo $i; ?>" value="<?php echo $i; ?>" id="customradiopackeducheckform_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $i; ?>">
            <label class="custom-control-label" for="customradiopackeducheckform_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $i; ?>">Form <?php echo $i; ?></label><input type="hidden" class="form-control fld form" value="<?php echo $i; ?>" id="form_threshold<?php echo $i; ?>" >
            </div>
                  </div>
                  <div class="col-md-2 mt-1" >
            <input type="number" <?php echo $style; ?>  min="0" oninput="this.value = Math.abs(this.value)" <?php  echo $disabled; ?>  onkeyup="get_form_input_value(<?php echo $com['alacarte_id']; ?>,<?php echo $com['component_id']; ?>,<?php echo $i; ?>)" class="form-control fld2 text_form_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>" value="<?php echo $form_value;?>" id="text_form_<?php echo $com['alacarte_id'].'_'.$com['component_id']; ?>_<?php echo $i; ?>" >
            </div> 

            <?php
               $n++;
              }
            }
          }
          ?>



           </div>
           <hr>
        <?php
        $j = $key;
      }
    }
  }
 ?>
          



</div>

      
         <div id="package-component-error"></div>  
        <div class="sbt-btns">
          <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel d-none">CANCEL</a>
          <button id="add-website-service-alacarte-component-btn" class="btn bg-blu btn-submit-cancel">SAVE</button>
        </div>
        <!--Add Client Content-->
     </div>
  </div>
</section>
<!--Content-->

   <div class="modal fade" id="cancel-form-modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
        <h4> Are you sure want to cancel this form ?</h4>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
               <a href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-all-client" id="add-all-alacarte-data" class="btn bg-blu btn-submit-cancel text-white">submit</a>
           </div>
        </div>
      </div>
    </div>
  </div>

 
  <!--  -->
   <div class="modal fade" id="view-component-data" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Package Components</h4>
        </div>
        <div class="modal-body">
         <div class="row" id="view-all-component">
         
         </div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
              
            <button id="add-all-package-data" class="btn bg-blu btn-submit-cancel text-white">submit</button>
               
           </div>
        </div>
      </div>
    </div>
  </div>
 
<script>
  var j = <?php echo $j;?>;
  var package_id = <?php echo $package_id;?>;
  var selected_component_list = '<?php echo $selected_package_component_list['package_selected_component_and_alacarte_list']['package_components'];?>';
  var selected_alacarte_component_list = '<?php echo $selected_package_component_list['package_selected_component_and_alacarte_list']['package_alacarte_components'];?>';
</script>
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/common-validations.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/factsuite-website/service-package/update-package-alacarte-component-details.js"></script>