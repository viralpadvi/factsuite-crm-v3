
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.min.css">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst"> 
        <h3>View All Components</h3>
          <div class="table-responsive mt-3" id="">
          <table class="table-fixed  datatable table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Case Id</th> 
                <th>Component Name</th> 
                <th>Candidate Name</th> 
                <!-- <th>Client Name</th>   -->
                <th>Employee Id</th>  
                <th>Phone Number</th>  
                <!-- <th>InputQC Stauts</th>  -->
                <th>Verification Status</th> 
                <!-- <th>View Progress</th> -->
                <!-- <th>View Details</th> -->
                <th>View Details</th>
                <!-- <th>Action</th> -->
                <!-- <th>Insufficiency</th>  
                <th>Approve</th>    -->
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable" id="get-case-data-1"> 
                <?php 
                 $i = 1; 
                    if (count($case) > 0) {
                        foreach ($case as $key => $value) {
                            $where = array('case_id'=>$value['candidate_id'],'component_id'=>$value['component_id'],'index_no'=>$value['index']);
                           $vendor_count = $this->db->where($where)->get('assign_case_to_vendor')->result_array();
                            if (count($vendor_count) > 0) { 

                             $inputQcStatus= '';
                    $analystQcStatus= '';

                    if ($value['status'] == '0' || $value['status'] == '1') {
                         
                        $inputQcStatus = '<span class="text-warning">Pending<span>'; 
                    }                     
                    else if ($value['status'] == '2') {
                         
                        $inputQcStatus = '<span class="text-success">Completed<span>';
                        
                    }else if ($value['status'] == '3') {
                         
                        $inputQcStatus = '<span class="text-danger">Insufficiency<span>';
                       
                    }else if ($value['status'] == '4') {
                       
                        $inputQcStatus = '<span class="text-success">Verified Clear<span>'; 
                         
                    }else if ($value['status'] == '5'){
                        $inputQcStatus = '<span class="text-danger">Stop Check<span>'; 
                         
                    }else{

                        $inputQcStatus = '<span class="text-success">Already approved<span>'; 

                    }



                    if ($value['analyst_status'] == '0' || $value['analyst_status'] == '1' || $value['analyst_status'] == '11') {
                         $override_status_arg = $value['candidate_id'].",".$value['component_id'].",'".$value['component_name']."','".$value['index']."',".$key;
                        $analystQcStatus = ''; 
                        $analystQcStatus .= '<select class="fld" class="analyst-status" onchange="status_override_analyst('.$override_status_arg.',this.id)" id="analyst-status'.$key.'">';
                       foreach ($verification_status as $vkey => $verification_val) {
                            $select = '';
                            if ($value['analyst_status'] == $verification_val['id']) {
                               $select = 'selected';
                            }
                           $analystQcStatus .= '<option '.$select.' value="'.$verification_val['id'].'"><span class="text-warning">'.$verification_val['status'].'<span></option>'; 
                       }
                       $analystQcStatus .= '</select>';
                        
                    }
                     
                    else if ($value['analyst_status'] == '2') {
                         
                        $analystQcStatus = '<span class="text-success">Completed<span>';
                        
                    }else if ($value['analyst_status'] == '3') {
                         
                        $analystQcStatus = '<span class="text-danger">Insufficiency<span>';
                       
                    }else if ($value['analyst_status'] == '4') {
                       
                        $analystQcStatus = '<span class="text-success">Verified Clear<span>'; 
                         
                    }else if ($value['analyst_status'] == '5'){
                        $analystQcStatus = '<span class="text-danger">Stop Check<span>'; 
                         
                    }else if ($value['analyst_status'] == '6'){
                        $analystQcStatus = '<span class="text-danger">Unable to verify<span>'; 
                         
                    }else if ($value['analyst_status'] == '7'){
                        $analystQcStatus = '<span class="text-danger">Verified discrepancy<span>'; 
                         
                    }else if ($value['analyst_status'] == '8'){
                        $analystQcStatus = '<span class="text-danger">Client clarification<span>'; 
                         
                    }else if ($value['analyst_status'] == '9'){
                        $analystQcStatus = '<span class="text-danger">Closed Insufficiency<span>'; 
                         
                    }else if ($value['analyst_status'] == '10'){
                        $analystQcStatus = '<span class="text-danger">QC Error<span>';
                    }else{

                        $analystQcStatus = '<span class="text-warning">Pending<span>'; 

                    }

                     $arg = $value['candidate_id'].'/'.$value['component_id'].'/'.$value['index'];
                     $form_number = $value['index'] + 1;
                     $candidate_name = $value['candidate_detail']['first_name']." ".$value['candidate_detail']['last_name'];

                    $code = isset($value['candidate_detail']['country_code'])?$value['candidate_detail']['country_code']:'+91';
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $value['candidate_id']; ?></td>
                                <td><?php echo $value['component_name'].' (form'.$form_number.')'; ?></td>
                                <td><?php echo $candidate_name; ?></td>
                                <td><?php echo $value['candidate_detail']['client_name']; ?></td>
                                <td><?php echo $code.' '.$value['candidate_detail']['phone_number']; ?></td>
                                <td><?php echo $analystQcStatus; ?></td>
                                <td><a href="<?php echo $this->config->item('my_base_url'); ?>factsuite-analyst/component-detail/<?php echo $arg; ?>" class="app-btn">View <i class="fas fa-angle-right"></i></a></td>
                            </tr>

                            <?php 
                            }
                        }
                        }
                 
                ?>
            </tbody>
          </table>
        </div>
     </div>
  </div>
</section>
<!--Content-->


<!-- Popup Content -->
<!-- <form> -->
<div id="SendMail" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="raise-issue-txt">
               <h3>Send Mail</h3>
               <ul>
                  <li>Case ID: <span>1245DGT</span></li>
                  <li>To: <span>finance@factsuite.com</span></li>
               </ul>
            </div>
            <div class="raise-issue-cnt">
               <textarea name="" cols="" rows="" class="fld2" placeholder="Message"></textarea>
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file1"><a class="fl-btn">UPLOAD DOCUMENT</a></label>
                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple>
                     <div class="file-name1"></div>
                  </div>
               </div>
               <div class="raise-issue-btn"><a href="#">Send</a></div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- </form> -->
 <div id="modalapprov" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
              <h3 class="snd-mail-pop">Approve</h3>
              <h4 id="componentNameApprove" class="pa-pop">Raise Insufficiency</h4>
              <textarea id="approve-comment" placeholder="Comment" class="message mt-1"></textarea>

              <div class="form-group w-100 mt-3">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
              </div>
              <!-- <h4>Do you want to Confirm?</h4> -->
              <div id="btnApproveDiv">
                    
              </div>
              <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>
 <div id="modal-stopcheck" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
              <h3 class="snd-mail-pop">Stop check</h3>
              <h4 id="componentNameApprove" class="pa-pop">Are you sure you want to <b>stop check</b>?</h4>
              <!-- <textarea id="approve-comment" placeholder="Comment" class="message mt-1"></textarea>

              <div class="form-group w-100 mt-3">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
              </div> -->
              <!-- <h4>Do you want to Confirm?</h4> -->
              <div id="btnStopCheckDiv">
                    
              </div>
              <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>
<div id="modalInsuffi" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Raise Insufficiency</h3>
            <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4>
            <!--  <h3 class="snd-mail-pop">Send Mail <img src="<?php echo base_url()?>assets/admin/images/email_open_100px.png" alt=""> </h3> -->
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID : 1245DGT</p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">From : analyst@factsuite.com</p>
                 </div>
             </div>
             <textarea class="message">Message...</textarea>
           <!--   <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" multiple type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div> -->
            <div id="fls" class="form-group w-100 mt-2">
                  <div class="form-group files">
                     <label class="upload-btn-pop" for="file1"><a class="fl-btn">UPLOAD DOCUMENT</a></label>

                     <input id="file1" type="file" style="display:none;" 
                            class="form-control fl-btn-n" multiple 
                            accept="image/jpg,image/png,image/jpeg,application/pdf" >

                     <div id="file_list_1" class="pa-pop">
                       
                     </div>

                  </div>
               </div> 
               <span id="valid_files" class="d-none text-suceess">Valid File List</span>
               <div id="valid-document">
                 
               </div>
               <span id="invalid_files" class="d-none text-danger">Invalid File List</span>
               <div id="document-error">
                 
               </div>
            <div id="btnInsuffiDiv">
                  
            </div>
                
            <div class="clr"></div>
          </div>
       </div>
    </div>
 </div> 
<div id="modalInsuffi" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <h3 class="snd-mail-pop">Raise Insufficiency</h3>
            <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4>
            <h4>Do you want to Confirm?</h4>
            <div id="btnInsuffiDiv">
                  
            </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

 <div id="modalPending" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Send Mail <img src="<?php echo base_url()?>assets/admin/images/email_open_100px.png" alt=""> </h3>
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID : 1245DGT</p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">From : analyst@factsuite.com</p>
                 </div>
             </div>
             <textarea class="message">Message...</textarea>
             <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Cancle</button>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Confirm</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

<div class="modal fade" id="view_image_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h3 id="">View Document</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
            <div class="col-md-3"></div>
            <div class="col-sm-6">
              <!-- <span>Sector Thumbnail Image: </span> -->
              <img class="w-100" id="view-image">
            </div> 
          </div>
          <div class="row p-5 mt-2">
              <div class="col-md-6" id="setupDownloadBtn">
                
              </div>
              <div id="view-edit-cancel-btn-div" class="col-md-6  text-right">
                <button class="btn bg-blu text-white" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
        <div class="modal-footer border-0"></div>
      </div>
    </div>
</div>

<!-- dynamic Component detail -->
<div id="componentModal" class="modal fade">
   <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="raise-issue-txt">
               <h3 id="modal-headding">Modal Heading</h3> 
            </div>
            <div class="raise-issue-cnt">
              <div id="component-detail">
                
              </div>
            </div>
         </div>
      </div>
   </div>
</div>


<script src="<?php echo base_url() ?>assets/custom-js/analyst/assigned-case/view-all-cases.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/assigned-case/view-single-case.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script>

  loadAllAssignedCases('<?php echo $sessionData['team_id'];?>')
  
  $("#content-5, #content-6").mCustomScrollbar({
    theme: "dark-thin"
  });

</script>

<!-- view-all-qc-error-component -->


<!-- priority_confirm_dailog -->
 <div id="override_confirm_dailog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <!-- <h3 class="snd-mail-pop">Override Assingment</h3> -->
            <!-- <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4> -->
            <h4>Do you want to override the Status?</h4>
            <div id="btnOverrideDiv">
              
            </div>
            <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

