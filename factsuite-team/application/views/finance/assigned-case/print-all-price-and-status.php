<section id="pg-cntr">
  <!-- <div class="pg-hdr"> -->

   <div class="pg-cnt">
      <div id="FS-candidate-cnt" class="FS-candidate-cnt"> 
         <?php 
            $style = '';
             $summ = 'Create Summary'; 
             if (isset($_GET['flag'])) {
               $style = 'style="display:none;"';  
               $summ = 'View Summary';  
             }
             $id = 'style="display:none;"';
             $finance_row = '';
             if (isset($_GET['id'])) {
                $id = ''; 
               $finance_row = $this->finance_Cases_Model->get_all_finance_summary($_GET['id']);
             }

             $summary_id = isset($_GET['id'])?$_GET['id']:'';
         ?>
         <h3><?php echo $summ; ?></h3>
         <input type="hidden" value="<?php $_GET['cases']; ?>" id="get-all-cases" name="get-all-cases">
          <div class="sbt-btns" <?php echo $id; ?> >
          <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_fields"class="btn bg-blu btn-submit-cancel">Create&nbsp;Field</a>
          <!-- <a href="#" id="team-submit-btn-values" data-toggle="modal" data-target="#add_field_value_model"class="btn bg-blu btn-submit-cancel">Add&nbsp;Values</a> -->
        </div>
         <div class="table-responsive mt-3">
            <?php  
             $case = base64_decode($_GET['cases']); 

             $data_array = array();
             $data_array_price = array();
             $candidate_data = array();
             $analyst_data = array();
             $client = '';
             $client_id = '';
            foreach (explode(',', $case) as $key => $value) { 
               $data['candidate'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($value); 
               $analyst = array();
                  // $case_array = array();
                foreach ($data['candidate'] as $k => $val) {  
                     $price_val = json_decode($val['client_packages_list'],true);
                      $price_value =0;
                     foreach ($price_val as $pk => $pvalue) {
                        if ($val['component_id'] == $pvalue['component_id']) { 
                            $price_value = $pvalue['component_price'];
                        }
                     }


                  array_push($analyst,$val['analyst_status']);


                    $string_status = 'Verified Clear';
               if (in_array('0', $analyst)) {  
                    $string_status = 'Verified Pending'; 
                }else if (in_array('1', $analyst)) { 
                    $string_status = 'Verified Pending'; 
                }else if (in_array('2', $analyst)) { 
                        $string_status = 'Verified Clear'; 
                }else if (in_array('3', $analyst)) { 
                        $string_status = 'Insufficiency'; 
                }else if (in_array('4', $analyst)) { 
                    $string_status = 'Verified Clear'; 
                }else if (in_array('5', $analyst)) { 
                        $string_status = 'Stop Check'; 
                }else if (in_array('6', $analyst)) { 
                        $string_status = 'Unable to Verify'; 
                }else if (in_array('7', $analyst)) { 
                        $string_status = 'Verified Discrepancy'; 
                    
                }else if (in_array('8', $analyst)) { 
                        $string_status = 'Client Clarification'; 
                }else if (in_array('9', $analyst)) { 
                    $string_status = 'Closed insufficiency'; 
                }else if (in_array('10', $analyst)) { 
                    $string_status = 'QC-error';  
                      
                }
                  if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                     $candidate_data[$val['candidate_id']] = array( 
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $val['segment'],
                        'location' => $val['location'],
                        'father_name' => $val['father_name'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'case_submitted_date' => isset($val['candidate_details']['case_submitted_date'])?date($selected_datetime_format['php_code'],strtotime($val['candidate_details']['case_submitted_date'])):date($selected_datetime_format['php_code'],strtotime($val['tat_start_date'])),
                        'completed_date' => isset($val['candidate_details']['report_generated_date'])?date($selected_datetime_format['php_code'],strtotime($val['candidate_details']['report_generated_date'])):'',
                        $val['component_name'].' '.$val['formNumber']=>array('status'=>$string_status,'price'=>$price_value)
                     );

                     $client = $val['client_name'];
                     $client_id = $val['client_id'];
                  }else{
                    $candidate_data[$val['candidate_id']][$val['component_name'].' '.$val['formNumber']] = array('status'=>$string_status,'price'=>$price_value); 
                  }
                    if (!array_key_exists($val['component_name'].' '.$val['formNumber'], $data_array)) {
                     $data_array[$val['component_name'].' '.$val['formNumber']] = array($string_status);
                     $data_array_price[$val['component_name'].' '.$val['formNumber']] = array($price_value);
                    }else{
                     $data_array[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($string_status));
                     $data_array_price[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($price_value));
                    }

                 }

               

                array_push($analyst_data,$string_status);

                 // array_push($data_array,$case_array);
            }
            // echo json_encode($data_array); 
            
            ?>
            <div class="table-responsive">
               <input type="hidden" id="case_ids" name="case_ids" value="<?php echo $case; ?>">
               <input type="hidden" id="client_name" name="client_name" value="<?php echo $client; ?>">
               <input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
               <input type="hidden" id="summary_id" name="summary_id" value="<?php echo $summary_id; ?>">
               <input type="hidden" id="all-fields" name="all-fields" value="<?php echo isset($finance_row['created_fields'])?$finance_row['created_fields']:''; ?>">
            <table id="example1" class="table table-striped">
               <thead class="thead-bd-color">
                  <tr>
                     <th>Sr No</th> 
                      
                     <th>Submitted&nbsp;On</th> 
                     <th>Client&nbsp;Name</th> 
                     <th>Candidate&nbsp;Name</th> 
                     <th>Case&nbsp;ID</th> 
                     <th>Case&nbsp;Status</th>
                     <th>Completion&nbsp;Date</th>  
                     <th>Segment</th>  
                     <th>Employee ID</th>  
                     <th>Location</th>  
                     <th>Father Name</th>  
                     <th>Mobile Number</th>  
                     <?php 
                      $key_array = array();
                        foreach ($data_array as $key => $value) {
                           echo '<th>'.str_replace(" ","&nbsp;",$key).' Status</th>';
                           echo '<th>'.str_replace(" ","&nbsp;",$key).' Price</th>';
                           array_push($key_array,$key);
                        }
                        $count =array();
                        if (isset($finance_row['created_fields'])) {
                           $count = explode(',', $finance_row['created_fields']);
                           foreach ($count as $f => $fvalue) {
                             echo "<th>{$fvalue}</th>";
                           }
                        }
                     ?>
                     <th>Actions</th>
                  </tr>
               </thead>
               <!-- id="get-case-data-1" -->
               <tbody class="table-fixed-tbody tbody-datatable" id="get-case-data">
                  <?php
                  if (count($candidate_data) > 0) {  
                     $init = 0;
                     foreach ($candidate_data as $k => $val) {
                       
                     echo "<tr>";
                           echo '<td>'.($init+1).'</td>';
                           echo '<td>'.$val['case_submitted_date'].'</td>';
                           echo '<td>'.$val['client_name'].'</td>';
                           echo '<td>'.$val['candidate_name'].'</td>';
                           echo '<td>'.$val['candidate_id'].'</td>';
                           echo '<td>'.$analyst_data[$init].'</td>';
                           echo '<td>'.$val['completed_date'].'</td>';
                           echo '<td>'.$val['segment'].'</td>';
                           echo '<td>'.$val['employee_id'].'</td>';
                           echo '<td>'.$val['location'].'</td>';
                           echo '<td>'.$val['father_name'].'</td>';
                           echo '<td>'.$val['phone_number'].'</td>';
                           $a = 0;
                        foreach ($key_array as $key => $value) { 
                           $fields_id = isset($val[$value]['status'])?$val[$value]['status']:' '; 
                           $fields_id1 = isset($val[$value]['price'])?$val[$value]['price']:' ';
                            
                           echo '<td>'.$fields_id.'</td>';
                           echo '<td>'.$fields_id1.'</td>';
                        }
                        if (count($count) > 0) {
                        if (isset($finance_row['fields_data'])) {
                            
                        }else{
                            
                            foreach ($count as $c => $cvalue) {
                              $str = str_replace(' ','_',$cvalue);
                                echo "<td class='{$str}' id='{$str}{$init}'> </td>";  
                               }   
                           }
                        }

                         echo "<td><a onclick='edit_current_field({$init})'><i class='fa fa-pencil'></i></a> </td>";  
                        echo "</tr>";
                        $init++;
                     }
                    
                  }


                 /* if (count($candidate_data) > 0) {
                      echo "<tr>";
                           echo '<td>Total</td>';
                           echo '<td> </td>';
                           echo '<td> </td>';
                           echo '<td> </td>';
                           echo '<td> </td>';
                           echo '<td> </td>';
                           echo '<td> </td>';
                     foreach ($data_array as $key => $value) {
                          echo '<td>'.array_sum($value).'</td>';
                        }

                         if (count($count) > 0) {
                        if (isset($finance_row['fields_data'])) {
                            
                        }else{
                            
                            foreach ($count as $c => $cvalue) {
                                echo '<td> </td>';  
                               }   
                           }
                        }
                         echo '<td> </td>';
                     echo "</tr>";
                  }*/
                  ?>
               </tbody>
            </table>
            </div>
         </div>
         <input type="hidden" id="total_fields" name="total_fields" value="<?php echo count($count); ?>">
         <div class="row d-none">
            <div class="col-md-12 text-right" id="load-more-btn-div">
               <button id="save-finance-summery" class="btn bg-blu text-white">Save</button>
            </div>
         </div>
      </div>
   </div>
</section>
<!--Content-->




  <!-- Add role Modal Starts -->
  <div class="modal fade" id="add_fields">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Create&nbsp;Field</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Field Name</label>
                <input type="text" class="fld" name="field_name" id="field_name" placeholder="Enter Field Name">
                <div id="field-name-error-msg-div"></div>  
              </div>
              
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-field-btn" name="edit-field-close-btn" onclick="addfield()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->


  <!-- Add role Modal Starts -->
  <div class="modal fade" id="add_field_value_model">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Add Field Values</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2" id="add_field_values">
                
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-field-value-btn" name="edit-field-close-btn" onclick="addfieldvalues()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->



  <!-- Edit role Modal Starts -->
   <div class="modal fade" id="edit_field">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Edit Field Values</h4> 
        </div>
        <input type="hidden" name="edit_dynamic_id" id="edit_dynamic_id">
         <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2" id="edit_field_values"> 
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="updateData()">Update</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Coupon Modal Ends -->



<script src="<?php echo base_url() ?>assets/custom-js/finance/saved-finance-summary.js"></script>