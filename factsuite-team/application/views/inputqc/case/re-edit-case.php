<style type="text/css">
   #select2-country-code-container {
      height: 40px;
      padding-top: 4px;
   }
</style>
<section id="pg-cntr">
  <div class="pg-hdr">
      
     </div>
     <!--Nav Tabs-->
  </div>

<div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst">
         <a class="btn bg-blu text-white" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/assigned-case-list" > Back </a>
      <div id="FS-allcandidates">
        <!--Add Client Content-->
        <div class="add-client-bx">
           <h3> client details</h3>
           <?php foreach ($client as $key => $value) {
                // echo $client['0']['client_name']."\r\n";
           };?>
           <ul>
              <li>
                 <label>Client Name</label>
                 <select class="form-control fld select2" id="client_id" required="">
                    <option value="0">Select Client Name</option>
                    <?php
                      if (count($client) > 0) {

                        foreach ($client as $key => $value) { ?>
                           <!-- echo "<option value='{$value[0]['client_id']}'>{$value[0]['client_name']}</option>"; -->
                           <option <?php if ($case[0]['client_id'] == $value['client_id']){ echo "selected";} ?> value="<?php echo $value['client_id']?>"><?php echo $value['client_name']?></option>
                      <?php  }
                      }
                    ?>
                 </select>
                 <div id="client-id-error">&nbsp;</div>
              </li>
 
            <li>
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
                 <div id="title-error">&nbsp;</div>
              </li>
              <li>
                 <label>First Name</label>
                 <input type="hidden" class="form-control fld" value="<?php echo $case[0]['candidate_id']; ?>" id="candidate_id" >
                 <input type="text" class="form-control fld" value="<?php echo $case[0]['first_name']; ?>" id="first_name" required="">
                 <div id="first_name_error">&nbsp;</div>
              </li>
              <li>
                 <label>Last Name</label>
                 <input type="text" class="form-control fld" value="<?php echo $case[0]['last_name']; ?>"  id="last_name">
                 <div id="client-address-error">&nbsp;</div>
              </li>
              <li>
                 <label>Father's Name</label>
                 <input type="text" class="form-control fld" value="<?php echo $case[0]['father_name']; ?>"  id="father_name" required="">
                 <div id="client-address-error">&nbsp;</div>
              </li>
              <li style="width: 10%;">
                  <label>Country Code</label>
                  <select class="form-control fld select2" id="country-code">
                      <?php 
                        $country_code_list = json_decode($country_code_list,true);
                        foreach ($country_code_list as $key => $value) {
                            $selected = '';
                            if ($value['dial_code'] == $case[0]['country_code']) {
                                $selected = ' selected';
                            }
                        ?>
                        <option<?php echo $selected;?> value="<?php echo $value['dial_code'];?>"><?php echo $value['dial_code'].' ('.$value['name'].')';?></option>
                        <?php } ?>
                  </select>
                  <div id="country-code-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="number" class="form-control fld" value="<?php echo $case[0]['phone_number']; ?>"  id="phone_number" required="">
                 <div id="contact-no-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email Id</label>
                 <input type="text" class="form-control fld" value="<?php echo $case[0]['email_id']; ?>"  id="email_id">
                 <div id="email-id-error">&nbsp;</div>
              </li>
              <li>
                <label>Date Of Birth</label>
                <input type="text" class="fld form-control dob-date" id="date_of_birth" value="<?php echo $case[0]['date_of_birth']; ?>"  name="date_of_birth">
                <div id="date-of-birth-error-msg-div">&nbsp;</div>
              </li>
              <li>
                <label>Date Of Joining</label>
                <input type="text" class="fld form-control mdate" id="date_of_joining" value="<?php echo $case[0]['date_of_joining']; ?>"  name="date_of_joining" >
                <div id="date-of-joining-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Employee ID</label>
                 <input type="text"  class="form-control fld" value="<?php echo $case[0]['employee_id']; ?>" id="employee_id">
                 <div id="employee-id-error">&nbsp;</div>
              </li>
              <li> 
                 <label>BGV Package Name</label>
                 <select class="form-control fld" id="package_id" required="">
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
                 <!-- <input type="hidden" readonly="" class="form-control fld" id="package_id"> -->
                 <!-- <input type="text" readonly="" class="form-control fld" id="package_name"> -->
                 <div id="package-id-error">&nbsp;</div>
              </li> 
              <li>
                  <label>Segment</label>
                 <select class="form-control fld" id="segment" required="">

                    <?php 
                        foreach ($segment as $key1 => $value) {
                            $select ='';
                        if ($case[0]['segment'] == $value['id']) {
                           $select = 'selected';
                        }
                         echo "<option ".$select." value='".$value['id']."'>".$value['name']."</option>";
                        }
                      ?>
                 </select> 
                 <div id="segment-error">&nbsp;</div>
              </li>
              <li>
                 <label>Cost Center</label>
                 <select class="form-control fld" id="cost-center">
                    <option value="">Cost Center</option>
                    <?php 
                        foreach ($client_cost_centers as $key => $value) {
                            $selected = '';
                            if ($value['location_id'] == $case[0]['cost_center']) {
                                $selected = ' selected';
                            }
                            echo "<option".$selected." value='".$value['location_id']."'>".$value['location_name']."</option>";
                        }
                      ?>
                 </select> 
                 <div id="cost-center-error">&nbsp;</div>
              </li> 
              <li class="d-none"> 
                 <label>Alacarte Name</label>
                 <select class="form-control fld" id="alacarte_components" required="">
                    <?php
                    $alacarte_data = json_decode($single_client['alacarte_components'],true); 
                    foreach ($alacarte_data as $key => $value) { 
                         echo "<option value='{$value['component_id']}'>{$value['component_name']}</option>"; 
                    }
                    ?>
                 </select>
                 <!-- <input type="hidden" readonly="" class="form-control fld" id="package_id"> -->
                 <!-- <input type="text" readonly="" class="form-control fld" id="package_name"> -->
                 <div id="alacarte_components-id-error">&nbsp;</div>
              </li> 

              <li>
                 <label>Remarks</label>
                 <input type="text" class="form-control fld" value="<?php echo $case[0]['remark']; ?>" id="remarks">
                 <div id="remarks-error">&nbsp;</div>
              </li>
               
              <li>
                 <label>Documents uploaded by</label>
                 <select class="form-control fld" id="document_uploaded_by" required=""> 
                    <option <?php if ($case[0]['document_uploaded_by']=='candidate') {
                      echo "selected";
                    }?> value="candidate">Candidate</option>
                    <option <?php if ($case[0]['document_uploaded_by']=='inputqc') {
                      echo "selected";
                    }?> value="inputqc">InputQC</option> 
                     
                 </select>
                 <div id="document-uploaded-by-error">&nbsp;</div>

                 
              </li>
              
              <li id="document_uploded_by_inputqc" <?php if ($case[0]['document_uploaded_by'] == 'candidate' || $case[0]['document_uploaded_by'] == 'inputqc') {
                     echo "style='display:none;'";
                    }?> >
                 <label>InputQc Email Id</label>
                 <input type="text" class="fld form-control fld" value="<?php echo $case[0]['document_uploaded_by_email_id']; ?>"  id="document_uploded_by_email_id">
                 <div id="inputqc-email-error">&nbsp;</div>
              </li>
              <li>
                <label>Case Priority</label>
                <?php 
                  $high_priority = '';
                  $midum_priority = '';
                  $low_priotiy = '';
                  $default_priority = '';
                  if($case[0]['priority'] == '0'){
                    $low_priotiy = 'selected';
                  }else if($case[0]['priority'] == '1'){
                    $midum_priority = 'selected';
                  }else if($case[0]['priority'] == '2'){
                    $high_priority = 'selected';
                  }else{
                    $default_priority = 'selected';
                  }
                ?>

                <select class="fld form-control fld" id="priority">
                    <option <?php echo $default_priority ?> value="3">Select Priority</option>
                    <option <?php echo $high_priority ?> value="2" >High Priority</option>
                    <option <?php echo $midum_priority ?> value="1" >Medium Priority</option>
                    <option <?php echo $low_priotiy ?> value="0" >Low Priority</option>
                </select>  
                <div id="priority-error">&nbsp;</div>
              </li>

           </ul> 
        </div> 
        <div class="add-team-bx">
            <label>Case Update Type</label>
            <select class="form-control input-txt col-md-2" required name="update_status" id="update_status"> 
                  <option value="update">Update</option> 
                  <option value="re-init">Re-Initiation</option> 
                </select>
        </div>
         
        <div class="add-team-bx" id="all-component-list" style="display:none">
          <!-- <h3>Components</h3> -->
           <h3>Components List</h3>
             <div class="custom-control custom-checkbox custom-control-inline mrg">
                <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll">
                <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
             </div>
          <ul > 
            <div class="row" id="components_ids">
               <?php  
                                   $form_values = json_decode($case[0]['form_values'],true);
                                 $form_values = json_decode($form_values,true); 
                                 // echo json_encode( $form_values);
                                  $pack_case = json_decode($case[0]['package_components'],true); 
                                  // $com_ids = array();//explode(',', $case[0]['component_ids']);
                                   $com_ids = explode(',', $case[0]['component_ids']);

                                 /* if ($pack_case !=null) {
                                    foreach ($pack_case as $al => $val) {
                                    array_push($com_ids, $val['component_id']);
                                  }
                                  }*/

                                  $single_client_data = json_decode($single_client['package_components'],true); 

                                    foreach ($single_client_data as $key => $value) { 

                                        if ($case[0]['package_name'] ==  $value['package_id'] || $single_client['client_id'] =='162') { 


                                    $doc_array = array(); 
                                    if (count($value['form_data']) > 0) { 
                                         foreach ($value['form_data'] as $fr => $val) {
                                             array_push($doc_array,$val['form_id']);
                                         }
                                    }

                                       $index = array_search($value['component_id'],array_values($com_ids)); 
                                      $selected = '';
                                      $disable ='disabled';
                                      $disables ='';
                                      if ($value['component_id']==$com_ids[$index]) {
                                         $selected = 'checked';
                                         $disable ='disabled';
                                         $disables ='disabled';
                                      }


                                        $component =  $value['component_name'];
                                $component_name = str_replace(" ","_",$component);
                                      ?>



 
                                <div class="col-md-4">
                                            <div class=" custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" <?php echo $selected;?> <?php echo $disables; ?> onclick="select_skill_form(<?php echo $value['component_id']; ?>)"
                                            class="custom-control-input components"  data-component_name="<?php echo $component_name; ?>" value="<?php echo $value['component_id']; ?>"  name="componentCheck<?php echo $value['component_id']; ?>" id="componentCheck<?php echo $value['component_id']; ?>">
                                          <label class="custom-control-label" for="componentCheck<?php echo $value['component_id']; ?>"><?php echo $value['component_name']; ?> </label>
                                         </div>
                          <?php           
                              // if($value['drop_down_status'] == '1'){ 

                                $showOptiontValue = 'Forms';
                                $forLoopLength =  1;

                                if (count($value['form_data']) > 0) {
                                   $forLoopLength =  count($value['form_data']);
                                }
                                // Criminal Status

                               

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
                                    <!-- <option value="0">Select Number of Addresses</option> -->
                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($criminal_status == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$k} {$showOptiontValue}</option>";
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
                                    <!-- <option value="0">Select Number of Addresses</option> -->
                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                        $selected = '';
                                      if ($court_record == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$k} {$showOptiontValue}</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>
                                <?php
                                }

                                // Document Check
                                if($value['component_name'] == 'Document Check'){  
                                  ?>
                                  <div>
                                  <select <?php echo $disable; ?> multiple class="form-control fld  numberOfFomrs"
                                    onclick="getValusFromSelect('<?php echo $value['component_id']; ?>','<?php echo $component_name; ?>')"
                                    name="numberOfFomrs<?php echo $value['component_id']; ?>"
                                    id="numberOfFomrs<?php echo $value['component_id']; ?>"> 
                                    <!-- <option value="0">Select Document Type</option> -->
                                     <?php

                                     $doc = isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:'-';
                                   foreach ($component_type['documetn_type'] as $docs => $val) {  
                                    $select_doc = isset($doc[$docs])?$doc[$docs]:'';
                                      $selected = '';
                                      if ($val['document_type_id'] == $select_doc) {
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
                                    $drugg = isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:array();
                                   foreach ($component_type['drug_test_type'] as $drug => $drugval) {  
                                    $selected ='';
                                     if (in_array($drugval['drug_test_type_id'],$drugg)) {
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
                                    <!-- <option value="0">Select Document Type</option> -->

                                    <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                         $selected = '';
                                      if ($previous_address == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$k} Previous Address</option>";
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
                                    <!-- <option value="0">Select Document Type</option> -->

                                    <?php
                                    $educ = isset($pack_case[$index]['form_values'])?$pack_case[$index]['form_values']:'-';
                                   foreach ($component_type['education_type'] as $edu => $eduval) { 
                                    $selected =''; 
                                     if (in_array($eduval['education_type_id'],$educ)) {
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
                                    <!-- <option value="0">Select Number Of Previous Employment</option>  -->
                                     <?php
                                    for($k=1;$k <= $forLoopLength ;$k++){
                                         $selected = '';
                                      if ($previous_employment == $k) {
                                        $selected = 'selected';
                                      }
                                        echo "<option {$selected} value='{$k}'>{$k} Previous Employment</option>";
                                    } 
                                    ?>
                                  </select>
                                  <div id="numberOfFomrs-error<?php echo $value['component_id']; ?>"></div>
                                  </div>

                                  <?php
                                } 

                     

                                // Reference
                                if($value['component_name'] == 'Reference' ){  
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
                                        echo "<option {$selected} value='{$k}'>{$k} Reference</option>";
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
                                        echo "<option {$selected} value='{$k}'>{$k} Directorship</option>";
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
                                        echo "<option {$selected} value='{$k}'>{$k} Global Sanctions/ AML</option>";
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
                                        echo "<option {$selected} value='{$k}'>{$k} Credit / Cibil Check</option>";
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
                                        echo "<option {$selected} value='{$k}'>{$k} Bankruptcy Check</option>";
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
                                    }   }
                                  ?>
                            </div>

                            <div class="mt-2">
                              <h3>Alacarte Components</h3>
                            </div>
                             <div class="row" id="alacarte_components_ids">
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

                                    foreach ($single_client_data as $key => $value) { 
                                      $selected = '';
                                      $disable ='';
                                      if (in_array($value['component_id'], $com_ids)) {
                                         $selected = 'checked';
                                         $disable ='';
                                      }

                                        $doc_array = array(); 
                                        if (count($value['form_data']) > 0) { 
                                             foreach ($value['form_data'] as $fr => $val) {
                                                 array_push($doc_array,$val['form_id']);
                                             }
                                        }

                                      $index = array_search($value['component_id'], $com_ids); 
                                       $component =  $value['component_name'];
                                $component_name = str_replace(" ","_",$component);
                                      ?>

 
                                <div class="col-md-4">
                                            <div class=" custom-control custom-checkbox custom-control-inline">
                                          <input type="checkbox" <?php echo $selected; ?> onclick="select_skill_form(<?php echo $value['component_id']; ?>)"
                                            class="custom-control-input alacarte_component_names"  data-component_name="<?php echo $component_name; ?>" value="<?php echo $value['component_id']; ?>"  name="componentCheck<?php echo $value['component_id']; ?>" id="componentCheck<?php echo $value['component_id']; ?>">
                                          <label class="custom-control-label" for="componentCheck<?php echo $value['component_id']; ?>"><?php echo $value['component_name']; ?> </label>
                                         </div>
                          <?php           
                              // if($value['drop_down_status'] == '1'){ 
                               $index = array_search($value['component_id'],array_values($com_ids)); 
                                $showOptiontValue = 'Forms';
                                $forLoopLength = count($value['form_data']);
                                // Criminal Status

                                

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
                                        echo "<option {$selected} value='{$k}'>{$k} {$showOptiontValue}</option>";
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
                                        echo "<option {$selected} value='{$k}'>{$k} {$showOptiontValue}</option>";
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
                                     $docu = isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:'';
                                   foreach ($component_type['documetn_type'] as $doc => $val) { 
                                      $selected = '';
                                      if (in_array($val['document_type_id'], $docu) ) {
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
                                    $drugg = isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:array();
                                   foreach ($component_type['drug_test_type'] as $drug => $drugval) {  
                                    $selected ='';

                                     if (in_array($drugval['drug_test_type_id'], $drugg)) {
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
                                        echo "<option {$selected} value='{$k}'>{$k} Previous Address</option>";
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
                                    $educ =  isset($alacarte[$index]['form_values'])?$alacarte[$index]['form_values']:array();
                                   foreach ($component_type['education_type'] as $edu => $eduval) { 
                                    $selected ='';
                                     if (in_array($eduval['education_type_id'],$educ)) {
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
                                        echo "<option {$selected} value='{$k}'>{$k} Previous Employment</option>";
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
                                        echo "<option {$selected} value='{$k}'>{$k} Reference</option>";
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
                                  ?>
            </div>  

          </ul>
          <div id="vendor-skill-error-msg-div"></div>
          <div id="error-team"></div>
        </div>
        <div id="submit-button" class="sbt-btns">
            
          <!--  <a href="#" onclick="getValusFromSelect()" class="btn bg-gry btn-submit-cancel">CANCEL</a>  -->
           <!-- <button id="_re_insert_data" onclick="save_case('<?php echo date('d-m-Y')?>')" class="btn bg-blu btn-submit-cancel"><span id="btn-txt">Re - initiatetion</span></button>  -->
           <button id="insert_data" onclick="save_case()" class="btn bg-blu btn-submit-cancel"><span id="btn-txt">SUBMIT &amp; SAVE</span></button> 
           <!-- <button id="insert_data" onclick="save_case()" class="btn bg-blu btn-submit-cancel"></button>  -->
        </div>
        <!--Add Client Content-->
                
     </div> 
  </div>
</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url();?>assets/custom-js/common/valid-invalid-input.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/inputqc/case/re-edit-case.js"></script>
