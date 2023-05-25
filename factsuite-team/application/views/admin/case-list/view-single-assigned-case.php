
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <!-- <h3>Case Detail</h3> -->
          <input type="hidden" name="candidate_id" value="<?php echo $candidate_id; ?>" id="candidate_id">
          <?php 
          if(!$this->session->userdata('logged-in-csm')) {
          ?>
          <a class="btn bg-blu btn-submit-cancel" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-all-case-list" ><span class="text-white">Back</span></a>
        <?php } ?>
          <h5 class="mt-3" style="color: #381653;">Personal Details</h5>
          <div class="row ">
            <div class="col-md-4">
              <label class="font-weight-bold">Case ID: </label>&nbsp;<span id="caseId"></span>
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="font-weight-bold">Candidate Name: </label>&nbsp;<span id="candidateName">-</span>
            </div> 
            <div class="col-md-4">
              <label class="font-weight-bold">Client Name: </label>&nbsp;<span id="clientName">-</span>
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">Employee Id: </label>&nbsp;<span id="employee_id">-</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="font-weight-bold">Phone Number: </label>&nbsp;<span id="camdidatephoneNumber">-</span>
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">Package Name: </label>&nbsp;<span id="packageName">-</span>
            </div>
          </div>
           <div class="row">
            <div class="col-md-4">
              <label class="font-weight-bold">Country: </label>&nbsp;<span id="candidate_country">-</span>
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">State: </label>&nbsp;<span id="candidate_state">-</span>
            </div>
             <div class="col-md-4">
              <label class="font-weight-bold">City: </label>&nbsp;<span id="candidate_city">-</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="font-weight-bold">Email Id: </label>&nbsp;<span id="camdidateEmailId">-</span>
            </div>
            <div id="priority-div" class="col-md-4">
               <!-- priority dropdown in JS -->
            </div>
            <div class="col-md-4" >
              <label class="font-weight-bold" id="candidate-loa"></label>
            </div> 
            <div class="col-md-4">
              <label class="font-weight-bold">Remarks :</label><span id="remarks">-</span>
            </div> 
             <div class="col-md-8">
              <label class="font-weight-bold">Preferred Contact Days :</label><span id="week">-</span>
            </div> 


             <div class="col-md-4">
              <label class="font-weight-bold">Preferred Contact Start Time :</label><span id="start_date">-</span>
            </div> 
            <div class="col-md-6">
              <label class="font-weight-bold">Preferred Contact End Time :</label><span id="end_date">-</span>
            </div> 

             <div class="col-md-4">
              <label class="font-weight-bold">Contact Preferred :</label><span id="preferred">-</span>
            </div> 

             <div class="col-md-4">
              <label class="font-weight-bold">Report Generated :</label><span id="is_report_generated">-</span>
            </div> 
            
            
             <div class="col-md-4">
              <label class="font-weight-bold">Report Generated Date:</label><span id="report_generated_date">-</span>
            </div> 
            
            
             <div class="col-md-4">
              <label class="font-weight-bold">Call to Candidate :</label><span id="call-to-candidate">-</span>
            </div> 
            
            
          </div>
          <hr>
          <h5 class="mt-3" style="color: #381653;">TAT Details</h5>
          <div class="row">
            <div class="col-md-4">
              <label class="font-weight-bold">TAT Status: </label>&nbsp;<span id="tatStatus">-</span>
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">TAT Total Days: </label>&nbsp;<span id="tatTotalDays">-</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="font-weight-bold">Tat Start Date: </label>&nbsp;<span id="tatStartDays">-</span>
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">Tat End Date: </label>&nbsp;<span id="tatEndDays">-</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="font-weight-bold">Tat Pause Date: </label>&nbsp;<span id="tatPauseDays">-</span>
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">Tat Re-Start Date: </label>&nbsp;<span id="tatReStartDays">-</span>
            </div>
          </div>
          <h5 class="mt-3" style="color: #381653;">Internal TAT Details</h5>
          <div class="row">
            <div class="col-md-6">
              <div>
                <label class="font-weight-bold">Case Assigned to InputQC Date: </label>&nbsp;<span id="assigned-to-input-qc-date">-</span>
              </div>
              <div>
                <label class="font-weight-bold">Case Verified by InputQC Date: </label>&nbsp;<span id="verified-by-input-qc-date">-</span>
              </div>
              <div>
                <label class="font-weight-bold">Days Taken by InputQC: </label>&nbsp;<span id="days-taken-input-qc">-</span>
              </div>
            </div>
            <div class="col-md-6">
              <div>
                <label class="font-weight-bold">Case Assigned to OutputQc Date: </label>&nbsp;<span id="assigned-to-output-qc-date">-</span>
              </div>
              <div>
                <label class="font-weight-bold">Case Verified by OutputQc Date: </label>&nbsp;<span id="verified-by-output-qc-date">-</span>
              </div>
              <div>
                <label class="font-weight-bold">Days Taken by OutputQc: </label>&nbsp;<span id="days-taken-output-qc">-</span>
              </div>
            </div>
          </div>
          <div class="row" id="tat_btns">
            <div class="col-md-4 d-none">
              <a class="btn bg-blu btn-submit d-none" id="btn_pause_re_start_tat"><span class="text-white" id="btn_tat_name">Pause TAT</span></a>
            </div>
            <div class="col-md-4">
              <a class="btn bg-blu btn-submit" id="view_tat_log"><span class="text-white" id="btn_tat_name">View TAT Log</span></a>
            </div>
            <div class="col-md-4"> 
              <a class="btn bg-blu btn-submit" id="view-internal-tat-details" data-toggle="modal" data-target="#view-internal-tat-details-modal"><span class="text-white">Internal TAT Details</span></a>
            </div>  
            <div class="col-md-4 d-none"> 
              <a class="btn bg-blu btn-submit" id="view_vendor_log"><span class="text-white" id="btn_tat_name_">View Vendor Log</span></a>
            </div> 
          </div>
        <div class="table-responsive mt-3" id="">
          <table class="table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component</th>  
                <th>View Details</th>
                <?php $for_next_release = 1;
                  if ($for_next_release == 1) { ?>
                  <th>Raise Error</th>
                  <th>View Error Logs</th>
                  <th>View Client Clarifications</th>
                <?php } ?>
                <th>Data Entry Status</th>

                <th id="th-dynamic-statuss">Verification Status</th>  
                <th id="th-dynamic-status-insuff-name">Assigned&nbsp;to&nbsp;Insuff analyst</th> 
                <th id="th-dynamic-emp-insuff-analyst-name">Override Assignment Insuff analyst</th> 
                <th id="th-dynamic-status-analyst-name">Assigned&nbsp;to&nbsp;analyst/Specialist</th>
                <th id="th-dynamic-emp-analyst-name" width="15%">Assignment</th>
                <th>Quality Check Status</th>  
               
               <!--   <th>Approve</th>  --> 
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable" id="get-case-data"> 
            </tbody>
          </table>
        </div>
     </div>
  </div>
</section>
<!--Content-->


 <!-- view_tat_log_dailog -->
 <div id="view_vendor_log_dailog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
       <div class="modal-content">
       <!-- <div class="modal-lg"> -->
          <div class="modal-pending-bx">
            <h3 class="snd-mail-pop">Vendor Log List</h3>
            <div class="table-responsive mt-3" id="">
              <table class="table table-striped">
                <thead class="thead-bd-color">
                  <tr>
                    <th>Sr No.</th> 
                    <th>Vendor Name</th>  
                    <th>Component Name</th>
                    <th>Date</th> 
                  </tr>
                </thead>
                <tbody class="tbody-datatable" id="list_vendor_log_data"> 
                  <tr>
                    <td>Sr No.</td> 
                    <td>Vendor</td>  
                    <td>Component</td>
                    <td>start Date</td> 
                  </tr>
                </tbody>
              </table>
            </div>
            <div id="btnOverrideDiv1">
              <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Close</button>                  
            </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>


 <!-- View Internal Tat Details -->
 <div id="view-internal-tat-details-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
       <div class="modal-content">
       <!-- <div class="modal-lg"> -->
          <div class="modal-pending-bx">
            <h3 class="snd-mail-pop">Internal TAT Details</h3>
            <div class="table-responsive mt-3" id="">
              <table class="table table-striped">
                <thead class="thead-bd-color">
                  <tr>
                    <th>Sr No.</th> 
                    <th>Component Name</th>
                    <th>Case Assigned to Analyst/Specialist Date</th>
                    <th>Case Verified by Analyst/Specialist Date</th>
                    <th>Days Taken by Analyst/Specialist</th>
                  </tr>
                </thead>
                <tbody class="tbody-datatable" id="view-internal-tat-details-table"></tbody>
              </table>
            </div>
            <div id="btnOverrideDiv1">
              <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Close</button>                  
            </div>
                
             <div class="clr"></div>
          </div>
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

<!-- priority_confirm_dailog -->
 <div id="priority_confirm_dailog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <h3 class="snd-mail-pop">Priority Change</h3>
            <!-- <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4> -->
            <h4>Do you want to change the case priority?</h4>
            <div id="btnPriorityDiv">
                  
            </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

 <!-- priority_confirm_dailog -->
 <div id="tat_confirm_dailog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <h3 class="snd-mail-pop" id="tat_lable">TAT Change</h3>
            <!-- <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4> -->
            <h4>Do you want to Confirm?</h4>
            <div id="btnTatDiv">
                  
            </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

<!-- priority_confirm_dailog -->
 <div id="override_confirm_dailog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <!-- <h3 class="snd-mail-pop">Override Assingment</h3> -->
            <!-- <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4> -->
            <h4>Do you want to override the assignment?</h4>
            <div id="btnOverrideDiv">
              
            </div>
            <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>


 <!-- view_tat_log_dailog -->
 <div id="view_tat_log_dailog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
       <div class="modal-content">
       <!-- <div class="modal-lg"> -->
          <div class="modal-pending-bx">
            <h3 class="snd-mail-pop">TAT Log List</h3>
            <div class="table-responsive mt-3" id="">
              <table class="table table-striped">
                <thead class="thead-bd-color">
                  <tr>
                    <th>Sr No.</th> 
                    <th>TAT Start Date</th>  
                    <th>TAT Pause Date</th>
                    <th>TAT Re-start Date</th>
                    <th>TAT End Date</th>
                    <th>Name Of Component</th>
                    <th>Forms</th>
                    <th>Role</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody class="tbody-datatable" id="list_tat_log_data"> 
                  <tr>
                    <td>Sr No.</td> 
                    <td>TAT Start Date</td>  
                    <td>TAT Pause Date</td>
                    <td>TAT Re-start Date</td>
                    <td>TAT End Date</td>
                    <td>Name Of Component</td>
                    <td>Forms</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div id="btnOverrideDiv">
              <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Close</button>                  
            </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

 <div class="modal fade" id="view_image_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h3 class="text-white" id="">View Document</h4>
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

<!-- Add New Product Modal Ends -->

<div class="modal fade" id="click-to-call-candidate-modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Click to call</h4>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Are you Sure you want to call :<br>
        <span class="font-weight-bold" id="click-to-call-show-candidate-name"></span> on 
        +91-<span class="font-weight-bold" id="click-to-call-show-candidate-phone-number"></span>
        <div id="manual-call-sms"></div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-success" id="click-to-call-btn"></button>
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>
<script>
  var for_next_release = '<?php echo $for_next_release ;?>',
      masked_candidate_id = '<?php echo md5($candidate_id);?>';
</script>
<script src="<?php echo base_url() ?>assets/custom-js/admin/caseList/view-single-case.js"></script> 

<?php if ($for_next_release == 1) { ?>
<script src="<?php echo base_url() ?>assets/custom-js/admin/component-error/raise-error.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/admin/component-error/all-errors.js"></script>

<script src="<?php echo base_url() ?>assets/custom-js/admin/client-clarification/raise-clarification.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/admin/client-clarification/all-clarifications.js"></script>
<?php } ?>

<script>
 load_case(<?php echo $candidate_id;?>); 
</script>