
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">

            <a class="btn bg-blu btn-sm" href="<?php echo $this->config->item('my_base_url')?>factsuite-client/all-cases" ><span class="text-white">Back</span></a>
               <div id="FS-allcandidates" class="mt-2">
                 
                 <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="Addnewcase">
                       <!-- <form action="#"> -->
                       <div class="allcandidates-bx">
                           <h3>Candidate Details</h3>
                           <Ul class="add-client-bx">
                              <li class="all-bx wdt-7">
                                <label>Title</label>
                                 <?php
                                   // print_r($case);
                                    $mr ='';
                                    $miss ='';
                                    $mrs ='';
                                    if (strtolower($case[0]['title'])=='mrs') {
                                      $mrs ='selected';
                                    }else if(strtolower($case[0]['title'])=='miss'){
                                      $miss ='selected';
                                    }else{
                                      $mr ='selected';
                                    }
                                   ?>
                                   <select class="form-control fld" id="title">
                                      <option value="">Select Title</option>
                                      <option <?php echo $mr; ?> value="mr">Mr</option>
                                      <option <?php echo $miss; ?> value="miss">Miss</option>
                                      <option <?php echo $mrs; ?> value="mrs">Mrs</option>
                                       
                                   </select>
                                 <div>&nbsp;</div>
                              </li>
                             <li class="all-bx wdt-18">
                                <label>First Name <span>(Required)</span></label> 
                                <input type="hidden" class="form-control fld" value="<?php echo $case[0]['candidate_id']; ?>" id="candidate_id" >
                                 <input type="text" class="form-control fld" value="<?php echo $case[0]['first_name']; ?>" id="first-name" required="">
                                <div id="first-name-error">&nbsp;</div>
                             </li>
                             <li class="all-bx wdt-18">
                                <label>Last Name <span>(Required)</span></label> 
                                 <input type="text" class="form-control fld" value="<?php echo $case[0]['last_name']; ?>"  id="last-name">
                                <div id="last-name-error">&nbsp;</div>
                             </li>
                             <li class="all-bx wdt-18">
                                <label>Father's Name <span>(Required)</span></label> 
                                 <input type="text" class="form-control fld" value="<?php echo $case[0]['father_name']; ?>"  id="father-name" required="">
                                <div id="father-name-error">&nbsp;</div>
                             </li>
                             <li class="all-bx wdt-18">
                                <label>Phone Number</label> 
                                <input type="number" class="form-control fld" value="<?php echo $case[0]['phone_number']; ?>"  id="contact-no" required="">
                                <div id="contact-no-error">&nbsp;</div>
                             </li>
                             <li class="all-bx wdt-18">
                                <label>Email ID</label> 
                                <input type="text" class="form-control fld" value="<?php echo $case[0]['email_id']; ?>"  id="email-id">
                                <div id="email-id-error">&nbsp;</div>
                             </li>
                             <li class="wdt-30 all-bx2">
                                <label>Date of Birth</label>
                                 <input type="text" class="fld form-control dob-date" id="birth-date" value="<?php echo $case[0]['date_of_birth']; ?>"  name="date">
                                 <div id="birth-date-error">&nbsp;</div>                                
                             </li>
                             <li class="wdt-30 all-bx2">
                                 <label>Joining Date</label>
                                
                                   <!-- <input type="text" name="joining_date" class="fld form-control date-max-today" id="joining-date"> -->
                                    <input type="text" class="fld form-control date-for-vendor-aggreement-end-date" id="joining-date" value="<?php echo $case[0]['date_of_joining']; ?>"  name="joining-date" >
                                   <div id="joining-date-error">&nbsp;</div> 
                                 
                             </li>
                             <li class="wdt-18 all-bx">
                                <label>Employee ID</label>
                                <!-- <input type="text" class="fld form-control" id="employee-id"> -->
                                <input type="text"  class="form-control fld" value="<?php echo $case[0]['employee_id']; ?>" id="employee-id">
                                <div id="employee-id-error">&nbsp;</div>
                             </li>
                          
                           
                             <li class="all-bx wdt-18">
                                <label>Package</label> 
                                <select class="fld form-control" id="package">
                                   <option>Select Package</option>
                                    <?php 
                                    foreach ($package as $key => $value) {
                                      if ($case[0]['package_name'] == $value['package_id']) {
                                       echo "<option selected value='{$value['package_id']}'>{$value['package_name']}</option>";
                                      }else{
                                         echo "<option value='{$value['package_id']}'>{$value['package_name']}</option>";
                                      }
                                    }
                                    ?>
                                </select>
                                <div id="package-error">&nbsp;</div>
                             </li>

                             <div class="all-bx wdt-18  d-none">
                              <label>Alacarte Name</label>
                           <select class="form-control fld" id="alacarte_components" required="">
                            <option value="">Select Component</option>
                               <?php
                                  $alacarte_data = json_decode($single_client['alacarte_components'],true); 
                                  foreach ($alacarte_data as $key => $value) { 
                                       echo "<option value='{$value['component_id']}'>{$value['component_name']}</option>"; 
                                  }
                                  ?>
                           </select>
                           <!-- <input type="hidden" readonly="" class="form-control fld" id="package_id"> -->
                           <!-- <input type="text" readonly="" class="form-control fld" id="package_name"> -->
                           <div id="alacarte_components-error">&nbsp;</div>
                             </div>
                              <li class="all-bx wdt-30">
                                <label>Remarks</label>
                                <!-- <input type="text" class="fld form-control" id="remark"> -->
                                <input type="text" class="form-control fld" value="<?php echo $case[0]['remark']; ?>" id="remark">
                                <div id="remark-error">&nbsp;</div>
                              </li>

                              <li class="all-bx wdt-18">
                                <label>Documents upload by  <span>(Required)</span></label>
                                <select class="fld form-control" id="document-uploader">
                                  <option value="">Select Uploader</option>
                                   <option <?php if ($case[0]['document_uploaded_by']=='client') {
                                      echo "selected";
                                    }?> value="client">client</option>
                                                   <option <?php if ($case[0]['document_uploaded_by']=='candidate') {
                                      echo "selected";
                                    }?> value="candidate">candidate</option>
                                </select>
                                <div id="document-uploader-error">&nbsp;</div>
                             </li>
                              <li class="all-bx wdt-30" id="client-email-div" style="display: none;" >
                                <label>Client Email</label>
                                <input type="text" class="fld form-control" value="<?php echo $case[0]['document_uploaded_by_email_id']; ?>" id="client-email">
                                <div id="client-email-error">&nbsp;</div>
                             </li>
                          
                           <li class="all-bx wdt-18">
                                <label>Select Case Action</label>
                                <select class="fld form-control" id="case-init">
                                    <!-- <option value="0">Update</option> -->
                                    <option value="1">Re - Initiation</option>
                                </select>
                                <div id="-error">&nbsp;</div>
                             </li>
                          
                          <div class="checks">
                             <h3>Verification Components</h3>
                             <div class="custom-control custom-checkbox custom-control-inline mrg">
                                <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll">
                                <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
                             </div>
                             <?php $get_all_compoents = $this->db->get('components')->result_array();?>
                             <div class="full-bx row" id="case-skills-list"> 
                               <?php  
                                   $form_values = json_decode($case[0]['form_values'],true);
                                 $form_values = json_decode($form_values,true); 
                                 // echo json_encode( $form_values);
                                   $pack_case = json_decode($case[0]['package_components'],true); 
                                  $com_ids = array();//explode(',', $case[0]['component_ids']);

                                  if ($pack_case !=null) {
                                    foreach ($pack_case as $al => $val) {
                                    array_push($com_ids, $val['component_id']);
                                  }
                                  }
                                  $single_client_data = json_decode($single_client['package_components'],true); 


                                    foreach ($single_client_data as $key => $value) {

                                         if ($case[0]['package_name'] ==  $value['package_id']) { 

                                    $index = array_search($value['component_id'],array_values($com_ids)); 
                                          $in_array = isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:array();
                                      $condition = array();
                                         if(is_array($in_array)){
                                             $condition = $in_array;
                                          }else{
                                            array_push($condition,$in_array);
                                          }

                                      $doc_array = array(); 
                                    if (count($value['form_data']) > 0) { 
                                         foreach ($value['form_data'] as $fr => $val) {
                                             array_push($doc_array,$val['form_id']);
                                         }
                                    }

                                      $selected = '';
                                      $disable ='disabled';
                                      if (in_array($value['component_id'], $com_ids)) {
                                         $selected = 'checked';
                                         $disable ='';
                                      }
                                      ?>

                                    <?php $show_component_name = ''; 
                                        for ($i = 0; $i < count($get_all_compoents); $i++) {
                                        if ($get_all_compoents[$i]['component_id'] == $value['component_id']) {
                                            $show_component_name = $get_all_compoents[$i]['fs_crm_component_name'];
                                            break;
                                        }     
                                    } ?>
                                <div class="col-md-4">
                                    <div class=" custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" <?php echo $selected;?> onclick="select_skill_form(<?php echo $value['component_id']; ?>)"
                                            class="custom-control-input components"   data-component_name="<?php echo $value['component_name']; ?>" value="<?php echo $value['component_id']; ?>"  name="componentCheck<?php echo $value['component_id']; ?>" id="componentCheck<?php echo $value['component_id']; ?>">
                                        <label class="custom-control-label" for="componentCheck<?php echo $value['component_id']; ?>"><?php echo $show_component_name; ?> </label>
                                    </div>
                          <?php    
                                $showOptiontValue = 'Forms';
                                // $showOptiontValue = $value['fs_crm_component_name'];
                                $forLoopLength =  1;

                                if (count($value['form_data']) > 0) {
                                   $forLoopLength =  count($value['form_data']);
                                }

                                $component =  $value['component_name'];
                                $component_name = str_replace(" ","_",$component);

                                if($value['component_name'] == 'Criminal Status' ){
                                // alert('Criminal')
                                  // onChange="getValusFromSelect()"
                                   $criminal_status = 0;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $criminal_status = $pack_case[$index]['form_values'];
                                 } 
                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs"
                                    name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onChange="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    id="numberOfFomrs<?php echo $value['component_id']; ?>" > 
                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($criminal_status == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                  <?php
                                } 

                                 if($value['component_name'] == 'Court Record' ){
                                // alert('Criminal')
                                  // onChange="getValusFromSelect()"

                                 $court_record = 0;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $court_record = $pack_case[$index]['form_values'];
                                 } 
                                  ?>

                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs"
                                    name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onChange="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    id="numberOfFomrs<?php echo $value['component_id']; ?>"> 
                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($court_record == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                <?php
                                }


                                // Document Check
                                if($value['component_name'] == 'Document Check' ){

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> multiple class="form-control fld  numberOfFomrs"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    id="numberOfFomrs<?php echo $value['component_id']; ?>">  
                                     <?php

                                   foreach ($component_type['documetn_type'] as $doc => $val) { 
                                      $selected = '';
                                       
                                        

                                      if (in_array($val['document_type_id'], $condition)) {
                                        $selected = 'selected';
                                      }
                                      if (in_array($val['document_type_id'], $doc_array)) { 
                                        echo "<option {$selected} value='{$val['document_type_id']}'>{$val['document_type_name']}</option>";
                                      }
                                    } 
                                    ?>
                                  </select>
                                   
                                  </div>
                                <?php
                                } 

                                // Drug Test
                                if($value['component_name'] == 'Drug Test' ){
                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> multiple class="form-control fld numberOfFomrs" name="numberOfFomrs<?php echo $value['component_id']; ?>" onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    id="numberOfFomrs<?php echo $value['component_id']; ?>">  

                                    <?php
                                   foreach ($component_type['drug_test_type'] as $drug => $drugval) {  
                                    $selected ='';
                                     if (in_array($drugval['drug_test_type_id'], $condition)) {
                                        $selected = 'selected';
                                      }
                                        if (in_array($drugval['drug_test_type_id'],$doc_array)) {
                                        
                                        echo "<option {$selected} value='{$drugval['drug_test_type_id']}'>{$drugval['drug_test_type_name']}</option>";
                                      }
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>

                              <?php
                                } 

                                // Global Database
                                if($value['component_name'] == 'Previous Address' ){
                                 
                                 $previous_address = 0;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $previous_address = $pack_case[$index]['form_values'];
                                 } 
                                 ?> 
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs" 
                                    name="numberOfFomrs" 
                                    onChange="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    id="numberOfFomrs<?php echo $value['component_id']; ?>">  

                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                         $selected = '';
                                      if ($previous_address == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                <?php
                                } 



                                // Highest Education
                                if($value['component_name'] == 'Highest Education' ){

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> multiple class="form-control fld numberOfFomrs"
                                  name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="numberOfFomrs<?php echo $value['component_id']; ?>"> 

                                    <?php
                                   foreach ($component_type['education_type'] as $edu => $eduval) { 
                                    $selected ='';
                                     if (in_array($eduval['education_type_id'], $condition)) {
                                        $selected = 'selected';
                                      }
                                      if (in_array($eduval['education_type_id'],$doc_array)) {
                                          // code...
                                        echo "<option {$selected} value='{$eduval['education_type_id']}'>{$eduval['education_type_name']}</option>";
                                      }
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                              <?php
                                } 


                                // Previous Employment
                                if($value['component_name'] == 'Previous Employment' ){ 
                                 $previous_employment = 0;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $previous_employment = $pack_case[$index]['form_values'];
                                 } 
                                ?>

                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs"
                                  name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="numberOfFomrs<?php echo $value['component_id']; ?>"> 
                                     <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                         $selected = '';
                                      if ($previous_employment == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>

                                  <?php
                                } 

                     

                                // Reference
                                if($value['component_name'] == 'Reference' ){  
                                 $refrence = 0;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $refrence = $pack_case[$index]['form_values'];
                                 } 

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs"
                                  name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="numberOfFomrs<?php echo $value['component_id']; ?>" >
                                    <!-- <option value="0">Select Number Of Reference</option> -->

                                   <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($refrence == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                  <?php
                                } 
                                

                                
                              // Reference  111
                                if($value['component_name'] == 'Directorship Check' ){  
                                 $refrence = 1;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $refrence = $pack_case[$index]['form_values'];
                                 } 

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs"
                                  name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="numberOfFomrs<?php echo $value['component_id']; ?>" >
                                    <!-- <option value="0">Select Number Of Reference</option> -->

                                   <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($refrence == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                  <?php
                                } 



                                //2

                                  // Reference
                                if($value['component_name'] == 'Global Sanctions/ AML' ){  
                                 $refrence = 1;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $refrence = $pack_case[$index]['form_values'];
                                 } 

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs"
                                  name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="numberOfFomrs<?php echo $value['component_id']; ?>" >
                                    <!-- <option value="0">Select Number Of Reference</option> -->

                                   <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($refrence == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                  <?php
                                } 



                                //
                                  // Reference
                                if($value['component_name'] == 'Credit / Cibil Check' ){  
                                 $refrence = 1;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $refrence = $pack_case[$index]['form_values'];
                                 } 

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs"
                                  name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="numberOfFomrs<?php echo $value['component_id']; ?>" >
                                    <!-- <option value="0">Select Number Of Reference</option> -->

                                   <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($refrence == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                  <?php
                                } 




                                //4
                                  // Reference
                                if($value['component_name'] == 'Bankruptcy Check' ){  
                                 $refrence = 1;
                                if (isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:0 > 0) {
                                   $refrence = $pack_case[$index]['form_values'];
                                 } 

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld numberOfFomrs"
                                  name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="numberOfFomrs<?php echo $value['component_id']; ?>" >
                                    <!-- <option value="0">Select Number Of Reference</option> -->

                                   <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($refrence == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                  <?php
                                } 

                                ?> 
 
                      
                               </div>
                              <?php
                            }}
                          ?>
                             </div>

             <div class="mt-2">
              <h3>Alacarte Components</h3>
            </div>
             <div class="row full-bx" id="alacarte_components_ids">
              <?php  
                                   $form_values = json_decode($case[0]['form_values'],true);
                                 $form_values = json_decode($form_values,true); 
                                 // echo json_encode( $form_values);
                                 $alacarte = json_decode($case[0]['alacarte_components'],true); 
                                  $com_ids = array();//explode(',', $case[0]['component_ids']);

                                  if ($alacarte !=null) {
                                    foreach ($alacarte as $al => $val) {
                                    array_push($com_ids, $val['component_id']);
                                  }
                                  }

                                  $single_client_data = json_decode($single_client['alacarte_components'],true);  
                                  if($single_client_data != '' && count($single_client_data) > 0) {
                                    foreach ($single_client_data as $key => $value) { 
                                        // $index = array_search($value['component_id'],array_keys($com_ids)); 

                                      $selected = '';
                                      $disable ='';
                                      if (in_array($value['component_id'], $com_ids)) {
                                         $selected = 'checked';
                                         $disable ='';
                                      }
                                      ?>

                                        <?php $show_component_name = ''; 
                                            for ($i = 0; $i < count($get_all_compoents); $i++) {
                                            if ($get_all_compoents[$i]['component_id'] == $value['component_id']) {
                                                $show_component_name = $get_all_compoents[$i]['fs_crm_component_name'];
                                                break;
                                            }     
                                        } ?>
                                <div class="col-md-4">
                                            <div class=" custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" <?php echo $selected; ?> onclick="select_skill_form(<?php echo $value['component_id']; ?>)"
                                            class="custom-control-input alacarte_component_names"  data-component_name="<?php echo $value['component_name']; ?>" value="<?php echo $value['component_id']; ?>"  name="componentCheck<?php echo $value['component_id']; ?>" id="componentCheck<?php echo $value['component_id']; ?>">
                                          <label class="custom-control-label" for="componentCheck<?php echo $value['component_id']; ?>"><?php echo $show_component_name; ?> </label>
                                         </div>
                          <?php           
                              // if($value['drop_down_status'] == '1'){ 
                               $index = array_search($value['component_id'],array_values($com_ids)); 
                                $doc_array = array(); 
                                        if (count($value['form_data']) > 0) { 
                                             foreach ($value['form_data'] as $fr => $val) {
                                                 array_push($doc_array,$val['form_id']);
                                             }
                                        }
                                $showOptiontValue = 'Forms';
                                $forLoopLength = count($value['form_data']);
                                // Criminal Status

                                 $component =  $value['component_name'];
                                $component_name = str_replace(" ","_",$component);

                                if($value['component_name'] == 'Criminal Status' ){
                                // alert('Criminal')
                                  // onChange="getValusFromSelect()"
                                   $criminal_status = 0;
                                if (isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:0 > 0) {
                                   $criminal_status = $alacarte[$index]['form_values'];
                                 } 
                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld number_OfFomrs"
                                    name="number_OfFomrs<?php echo $value['component_id']; ?>"
                                    onChange="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    id="number_OfFomrs<?php echo $value['component_id']; ?>" >
                                    <!-- <option value="0">Select Number of Addresses</option> -->
                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($criminal_status == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="number_OfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                  <?php
                                } 

                                 if($value['component_name'] == 'Court Record' ){
                                // alert('Criminal')
                                  // onChange="getValusFromSelect()"

                                 $court_record = 0;
                                if (isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:0 > 0) {
                                   $court_record = $alacarte[$index]['form_values'];
                                 } 
                                  ?>

                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld number_OfFomrs"
                                    name="number_OfFomrs<?php echo $value['component_id']; ?>"
                                    onChange="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    id="number_OfFomrs<?php echo $value['component_id']; ?>">
                                    <!-- <option value="0">Select Number of Addresses</option> -->
                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($court_record == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="number_OfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                <?php
                                }


                                // Document Check
                                if($value['component_name'] == 'Document Check' ){
                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> multiple class="form-control fld  number_OfFomrs"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    name="number_OfFomrs<?php echo $value['component_id']; ?>"
                                    id="number_OfFomrs<?php echo $value['component_id']; ?>"> 
                                    <!-- <option value="0">Select Document Type</option> -->
                                     <?php

                                   foreach ($component_type['documetn_type'] as $doc => $val) { 
                                      $selected = '';
                                      if (in_array($val['document_type_id'], isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:array())) {
                                        $selected = 'selected';
                                      }
                                       if (in_array($val['document_type_id'], $doc_array)) {
                                          // code...
                                        echo "<option {$selected} value='{$val['document_type_id']}'>{$val['document_type_name']}</option>";
                                      }
                                    } 
                                    ?>
                                  </select>
                                   
                                  </div>
                                <?php
                                } 

                                // Drug Test
                                if($value['component_name'] == 'Drug Test' ){
                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> multiple class="form-control fld number_OfFomrs" name="number_OfFomrs<?php echo $value['component_id']; ?>" onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    id="number_OfFomrs<?php echo $value['component_id']; ?>"> 
                                    <!-- <option value="0">Select Document Type</option> -->

                                    <?php
                                   foreach ($component_type['drug_test_type'] as $drug => $drugval) {  
                                    $selected ='';
                                     if (in_array($drugval['drug_test_type_id'], isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:array())) {
                                        $selected = 'selected';
                                      }
                                         if (in_array($drugval['drug_test_type_id'], $doc_array)) {
                                        echo "<option {$selected} value='{$drugval['drug_test_type_id']}'>{$drugval['drug_test_type_name']}</option>";
                                        }
                                    } 
                                    ?>
                                  </select>
                                  <div id="number_OfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>

                              <?php
                                } 

                                // Global Database
                                if($value['component_name'] == 'Previous Address' ){
                                 
                                 $previous_address = 0;
                                if (isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:0 > 0) {
                                   $previous_address = $alacarte[$index]['form_values'];
                                 } 
                                 ?> 
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld number_OfFomrs" 
                                    name="number_OfFomrs" 
                                    onChange="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    id="number_OfFomrs<?php echo $value['component_id']; ?>"> 
                                    <!-- <option value="0">Select Document Type</option> -->

                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                         $selected = '';
                                      if ($previous_address == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="number_OfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                <?php
                                } 



                                // Highest Education
                                if($value['component_name'] == 'Highest Education' ){

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> multiple class="form-control fld number_OfFomrs"
                                  name="number_OfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="number_OfFomrs<?php echo $value['component_id']; ?>">
                                    <!-- <option value="0">Select Document Type</option> -->

                                    <?php
                                   foreach ($component_type['education_type'] as $edu => $eduval) { 
                                    $selected ='';
                                     if (in_array($eduval['education_type_id'], isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:array())) {
                                        $selected = 'selected';
                                      }
                                        if (in_array($eduval['education_type_id'], $doc_array)) {
                                        echo "<option {$selected} value='{$eduval['education_type_id']}'>{$eduval['education_type_name']}</option>";
                                        }
                                    } 
                                    ?>
                                  </select>
                                  <div id="number_OfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                              <?php
                                } 


                                // Previous Employment
                                if($value['component_name'] == 'Previous Employment' ){ 
                                 $previous_employment = 0;
                                if (isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:0 > 0) {
                                   $previous_employment = $alacarte[$index]['form_values'];
                                 } 
                                ?>

                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld number_OfFomrs"
                                  name="number_OfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="number_OfFomrs<?php echo $value['component_id']; ?>">
                                    <!-- <option value="0">Select Number Of Previous Employment</option>  -->
                                     <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                         $selected = '';
                                      if ($previous_employment == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}/option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="number_OfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>

                                  <?php
                                } 

                     

                                // Reference
                                if($value['component_name'] == 'Reference' ){  
                                 $refrence = 0;
                                if (isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:0 > 0) {
                                   $refrence = $alacarte[$index]['form_values'];
                                 } 

                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> class="form-control fld number_OfFomrs"
                                  name="number_OfFomrs<?php echo $value['component_id']; ?>"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                  id="number_OfFomrs<?php echo $value['component_id']; ?>" >
                                    <!-- <option value="0">Select Number Of Reference</option> -->

                                   <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($refrence == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$show_component_name} {$k}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="number_OfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                  <?php
                                } 
                                ?>

 
                              
                                       </div>
                                      <?php
                                    }
                                }
                                  ?>
            </div>  


                          </div>
                         <!--  <div class="send-bx"><button onclick="add_case()" class="sbt-btn">Submit</button></div> -->
                          <div id="submit-button" class="sbt-btns">
                              <button id="insert_data" onclick="add_case()" class="btn bg-blu text-white">Submit</button>
                           </div>
                       </div>
                       <!-- </form> -->
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Addbulkcase">
                       <form action="#">
                       <div class="allcandidates-bx">
                          <p>
                             Hi, <br>
                             We support bulk uploading candidate/cases when they are uploaded through a specific Excel Format.
                             We recommend you downloading the Excel Sample by clicking the Download Sample button. Once downloaded, 
                             we recommend you filling the specific columns in the mentioned manner. <br><br>
                             Notes: <br>
                             1. We only support excel sheets on the above mentioned format. <br>
                             2. Columns like "Candidate First Name", "Candidate Last Name", "Date Of Birth", "Father's Name", Phone number are required. <br>
                             3. Please make sure you enter the Date of Birth and Date of joining in the specific format. <br>
                             4. For the checks you want to verify, you will have to type "YES" manually against those columns. Other checks will not be verified.
                          </p>
                          <div class="full-bx">
                                <a href="File Path" download="File Name"><button class="dwd-btn"><i class="fa fa-arrow-down"></i> Download Sample</button></a>
                                <div class="form-group wdt-40">
                                   <input type="file" id="file1" />
                                   <label class="btn upload-btn" for="file1"><a>Upload</a></label>
                                   <div class="file-name1"></div>
                                </div>
                                <div id="excel-error-msg-div">&nbsp;</div>
                                <!--<div class="form-group wdt-40">
                                   <label class="btn upload-btn" for="file1"><a>Upload</a></label>
                                   <input id="file1" type="file" style="display:none;" class="form-control">
                                   <div class="file-name1"></div>
                                </div>-->
                                <button onclick="import_excel()" id="import_excel_file" class="sbt-btn">Submit</button>
                          </div>
                       </div>
                       </form>
                    </div>
                 </div>
                 <!--All Candidates Content-->
              </div>
     </div>
  </div>
</section>
<!--Content-->

<script src="<?php echo base_url() ?>assets/custom-js/case/edit-case.js"></script>