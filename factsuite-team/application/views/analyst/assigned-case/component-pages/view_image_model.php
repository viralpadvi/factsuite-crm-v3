<div class="modal fade" id="view_image_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <!-- modal-content-view-collection-category -->
        <div class="modal-content">
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
            <!-- <div class="modal-footer border-0"></div> -->
        </div>
    </div>
</div>



<div class="modal fade " id="myModal-show" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
          <div class="modal-header border-0">
              <h3 id="">View Document</h4>
          </div>
          <div class="modal-body modal-body-edit-coupon">
              <div class="row mt-2">
                  <div class="col-md-12 text-center" id="view-img"></div>
              </div>
              <div class="row p-5 mt-2">
                  <div class="col-md-6" id="setupDownloadBtn">

                  </div>
                  <div id="view-edit-cancel-btn-div" class="col-md-6  text-right">
                      <button class="btn bg-blu text-white" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
          <!-- <div class="modal-footer border-0"></div> -->
      </div>
  </div>
</div>


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
                <div id="btnOverrideDiv">
                    <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4"
                        data-dismiss="modal">Close</button>
                </div>

                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Error Log Modal Starts -->
<div class="modal fade" id="add-new-error-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-edit">
            <div class="modal-header border-0">
                <h4 class="modal-title-edit-coupon-1">Raise an Error</h4>
            </div>

            <div class="modal-body modal-body-edit-coupon">
                <div class="tab-content">

                    <div class="row mt-2">
                        <!-- <div class="col-sm-12">
              <label class="product-details-span-light">Subject</label>
              <input type="text" class="form-control" id="error-subject">
              <div id="error-subject-error-msg-div"></div>
            </div> -->
                        <div class="col-md-12">
                            <label class="product-details-span-light">Description</label>
                            <textarea class="fld ckeditor" name="error_description" id="error_description"
                                placeholder="Error Description"></textarea>
                            <div id="error-description-error-msg-div"></div>
                        </div>
                        <!-- <div class="col-sm-6">
              <label class="product-details-span-light">Priority</label>
              <select class="form-control" id="error-priority"></select>
              <div id="error-priority-error-msg-div"></div>
            </div>
            <div class="col-sm-6">
              <label class="product-details-span-light">Classifications</label>
              <select class="form-control" id="error-classifications"></select>
              <div id="error-classifications-error-msg-div"></div>
            </div> -->
                        <div class="col-sm-6 mt-2">
                            <div class="add-vendor-bx2">
                                <label>Attach file</label>
                                <div class="form-group mb-0">
                                    <input type="file" id="error-attach-file" name="error-attach-file">
                                    <label class="btn upload-btn" for="error-attach-file">Upload</label>
                                </div>
                            </div>
                            <div id="error-attach-file-error-msg-div"></div>
                        </div>
                        <div class="col-sm-12">
                            <div id="raise-error-error-msg-div"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn bg-gry btn-close text-white" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn bg-blu btn-close text-white" id="raise-error-btn">Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Add New Error Log Ends -->

<!-- View Error Log Modal Starts -->
<div id="view-error-log-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- <div class="modal-lg"> -->
            <div class="modal-pending-bx">
                <h3 class="snd-mail-pop">Error Log List</h3>
                <div class="table-responsive mt-3" id="">
                    <table class="table table-striped">
                        <thead class="thead-bd-color">
                            <tr>
                                <th>Sr No.</th>
                                <th>Description</th>
                                <!-- <th>Status</th> -->
                                <th>Created Date</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-datatable" id="error-log-list"></tbody>
                    </table>
                </div>
                <div id="btnOverrideDiv">
                    <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4"
                        data-dismiss="modal">Close</button>
                </div>

                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
<!-- View Error Log Modal Ends -->

<!-- View Error Log Details Modal Starts -->
<div class="modal fade candidate-details-modal" id="view-error-log-details-modal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-view-collection-category">
            <div class="modal-header border-0">
                <h4 class="modal-title-edit-coupon">Error Details</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body modal-body-edit-coupon">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="modal-contact-history-txt">Error Details</h6>
                                <!-- <div class="row">
                  <div class="col-md-5">Status</div>
                  <div class="col-md-4" id="show-error-status-modal">-</div>
                  <div class="col-md-3" id="show-error-status-btn-modal"></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-5">Priority</div>
                  <div class="col-md-7" id="show-error-priority-modal">-</div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-5">Classifications</div>
                  <div class="col-md-7" id="show-error-classification-modal">-</div>
                </div>
                
                <div class="row mt-3">
                  <div class="col-md-12">Subject :</div>
                  <div class="col-md-12" id="show-error-subject-modal">-</div>
                </div> -->
                                <div class="row" id="raise-error-attached-modal-file-main-div"></div>
                                <div class="row mt-3">
                                    <div class="col-md-12">Description :</div>
                                    <div class="col-md-12" id="show-error-description-modal">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 comments-div">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fa fa-pencil"></i> New Note</h4>
                                <hr>
                                <textarea id="note_message" class="form-control" placeholder="Leave a note"
                                    rows="4"></textarea>
                                <div id="note-message-error-msg-div"></div>
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-4">
                                        <div class="text-right pr-4 mt-3 pb-3">
                                            <button class="btn btn-comment" id="refresh-chat-btn">Refresh Chat</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="text-right pr-4 mt-3 pb-3">
                                            <button class="btn btn-comment" id="submit-new-note">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body chat-timeline">
                                <div class="extra-border"></div>
                                <div class="timeline timeline-inverse" id="timeline-chat"></div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
        </div>
    </div>
</div>
<!-- View Error Log Details Modal Ends -->

<!-- Add New Client Clarification Modal Starts -->
<div class="modal fade" id="add-new-client-clarification-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-edit">
            <div class="modal-header border-0">
                <h4 class="modal-title-edit-coupon-1">Raise Client Clarification</h4>
            </div>

            <div class="modal-body modal-body-edit-coupon">
                <div class="tab-content">

                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <label class="product-details-span-light">Subject *</label>
                            <input type="text" class="form-control" id="client-clarification-subject">
                            <div id="client-clarification-subject-error-msg-div"></div>
                        </div>
                        <div class="col-md-12">
                            <label class="product-details-span-light">Description *</label>
                            <textarea class="fld w-100" name="client_clarification_description"
                                id="client_clarification_description" placeholder="Error Description"></textarea>
                            <div id="client-clarification-description-error-msg-div"></div>
                        </div>
                        <div class="col-sm-6">
                            <label class="product-details-span-light">Priority</label>
                            <select class="form-control" id="client-clarification-priority"></select>
                            <div id="client-clarification-priority-error-msg-div"></div>
                        </div>
                        <div class="col-sm-6">
                            <label class="product-details-span-light">Classifications</label>
                            <select class="form-control" id="client-clarification-classifications"></select>
                            <div id="client-clarification-classifications-error-msg-div"></div>
                        </div>
                        <div class="col-sm-6 mt-2">
                            <div class="add-vendor-bx2">
                                <label>Attach file</label>
                                <div class="form-group mb-0">
                                    <input type="file" id="client-clarification-attach-file"
                                        name="client-clarification-attach-file">
                                    <label class="btn upload-btn" for="client-clarification-attach-file">Upload</label>
                                </div>
                            </div>
                            <div id="client-clarification-attach-file-error-msg-div"></div>
                        </div>
                        <div class="col-sm-12">
                            <div id="raise-client-clarification-error-msg-div"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn bg-gry btn-close text-white" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn bg-blu btn-close text-white"
                    id="raise-client-clarification-btn">Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Add New Client Clarification Modal Ends -->

<!-- View Client Clarification Log Modal Starts -->
<div id="view-client-clarification-log-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- <div class="modal-lg"> -->
            <div class="modal-pending-bx">
                <h3 class="snd-mail-pop">Client Clarification Log List</h3>
                <div class="table-responsive mt-3" id="">
                    <table class="table table-striped">
                        <thead class="thead-bd-color">
                            <tr>
                                <th>Sr No.</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-datatable" id="client-clarification-log-list"></tbody>
                    </table>
                </div>
                <div id="btnOverrideDiv">
                    <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4"
                        data-dismiss="modal">Close</button>
                </div>

                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
<!-- View Client Clarification Log Modal Ends -->

<!-- View Client Clarification Log Details Modal Starts -->
<div class="modal fade candidate-details-modal" id="view-client-clarification-log-details-modal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-view-collection-category">
            <div class="modal-header border-0">
                <h4 class="modal-title-edit-coupon">Client Clarification Details</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body modal-body-edit-coupon">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="modal-contact-history-txt">Client Clarification Details</h6>
                                <div class="row">
                                    <div class="col-md-5">Status</div>
                                    <div class="col-md-4" id="show-client-clarification-status-modal">-</div>
                                    <div class="col-md-3" id="show-client-clarification-status-btn-modal"></div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5">Priority</div>
                                    <div class="col-md-7" id="show-client-clarification-priority-modal">-</div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5">Classifications</div>
                                    <div class="col-md-7" id="show-client-clarification-classification-modal">-</div>
                                </div>
                                <div class="row" id="raise-client-clarification-attached-modal-file-main-div">
                                    <div class="col-md-4">Classifications</div>
                                    <div class="col-md-8" id="show-client-clarification-classification-modal">-</div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">Subject :</div>
                                    <div class="col-md-12" id="show-client-clarification-subject-modal">-</div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">Description :</div>
                                    <div class="col-md-12" id="show-client-clarification-description-modal">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 comments-div">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fa fa-pencil"></i> New Note</h4>
                                <hr>
                                <textarea id="client_clarification_note_message" class="form-control"
                                    placeholder="Leave a note" rows="4"></textarea>
                                <div id="client-clarification-note-message-error-msg-div"></div>
                                <div class="row">
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                        <div class="text-right pr-4 mt-3 pb-3">
                                            <button class="btn btn-comment"
                                                id="submit-client-clarification-new-note">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body chat-timeline">
                                <div class="extra-border">
                                    <div class="row">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4">
                                            <div class="text-right mt-2 pb-3">
                                                <button class="btn btn-comment"
                                                    id="refresh-client-clarification-chat-btn">Refresh Chat</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline timeline-inverse" id="client-clarification-timeline-chat"></div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
        </div>
    </div>
</div>
<!-- View Client Clarification Log Details Modal Ends -->
<!-- View Error Log Details Modal Ends -->

<?php 
$component_id = isset($component_id)?$component_id:0;
$component = $this->db->where('component_id',$component_id)->get('components')->row_array();
$index = isset($index)?$index:'';
?>

 <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="add-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Additional Verification Fee</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2">
                <div class="col-sm-6">
                   <label class="product-details-span-light">Case ID</label>
                   <input type="text" class="form-control" value="<?php echo $candidateIdLink; ?>" name="case-id" id="case-id">
                 </div> 
                 <div class="col-sm-6">
                   <label class="product-details-span-light">Component Name</label>
                   <input type="text" class="form-control" name="component-name" value="<?php echo isset($component['component_name'])?$component['component_name']:''; ?>" id="component-name">
                   <input type="hidden" class="form-control" name="component-id" value="<?php echo isset($component['component_id'])?$component['component_id']:''; ?>" id="component-id">
                   <input type="hidden" class="form-control" name="component-index" value="<?php echo $index; ?>" id="component-index">
                 </div>
                  <div class="col-sm-4">
                   <label class="product-details-span-light">Currency</label>
                   <input type="text" class="form-control" name="currency" id="currency">
                 </div> 
                 <div class="col-sm-4">
                   <label class="product-details-span-light">Verification Fee Amount</label>
                   <input type="text" class="form-control" name="amount" id="amount">
                 </div> 
                 <div class="col-sm-4">
                   <label class="product-details-span-light">Institution/ Portal Name</label>
                   <input type="text" class="form-control" name="portal-name" id="portal-name">
                 </div>
              <div class="col-sm-6 d-none">
                <label class="product-details-span-light">Select Role</label>
                <select class="form-control fld" id="assigned-to-role">
                  <option value="">Select Role</option>
                  <option value="client">Client</option>
                </select>
                <div id="assigned-to-role-error-msg-div"></div>
              </div>
              
              <div class="col-sm-6 d-none" id="client-list">
                <label class="product-details-span-light">Select Person</label>
                <select class="form-control fld" id="assigned-to-person">
                  <option value="">Select Person</option>
                </select>
                <div id="assigned-to-person-error-msg-div"></div>
              </div> 
              <div class="col-md-12">
                <label class="product-details-span-light">Remarks</label>
                <!-- ckeditor -->
                <!-- <textarea class="fld" name="ticket_description" id="ticket_description" placeholder="Remarks"></textarea> -->
                <select class="fld" name="ticket_description" id="ticket_description"></select>
                <div id="ticket-description-error-msg-div"></div>
              </div>
              <div class="col-md-12" id="additionals" style="display:none;">
                 <label class="product-details-span-light">Additional Remarks</label>
                 <textarea class="fld" name="additional_remarks" id="additional_remarks" placeholder="Additional Remarks"></textarea>
              </div>
               
              <div class="col-sm-12">
                <div id="raise-ticket-error-msg-div"></div>
              </div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" id="raise-ticket-btn">Add</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->



<!-- view_approval_list -->
<div id="view_approval_list" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- <div class="modal-lg"> -->
            <div class="modal-pending-bx">
                <h3 class="snd-mail-pop">Approval Log List</h3>
                <div class="table-responsive mt-3" id="">
                    <table class="table table-striped">
                        <thead class="thead-bd-color">
                            <tr>
                                <th>Sl No.</th> 
                                <th>Approval&nbsp;Id</th>  
                                <th>Action Type</th>  
                                <th>Created&nbsp;Date</th>  
                                <th>Remarks</th>  
                                <th>From&nbsp;Assign&nbsp;Name</th>  
                                <th>Status</th> 
                            </tr>
                        </thead>
                        <tbody class="tbody-datatable" id="view_approval_data_list">
                            
                        </tbody>
                    </table>
                </div>
                <div id="btnOverrideDiv">
                    <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4"
                        data-dismiss="modal">Close</button>
                </div>

                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>


<?php  
$reporting_manager_email = '';
$joining_date = '';
$relieving_date = '';
$reason_for_leaving = '';
$reporting_manager_desigination = '';
$desigination = '';
$department = '';
$reporting_manager_name ='';
$employee_id ='';
$company_name = '';
$index = isset($index)?$index:'';
if (isset($componentData['current_emp_id']) && ($this->session->userdata('logged-in-outputqc') || $this->session->userdata('logged-in-specialist'))) {
  $reporting_manager_name = isset($componentData['reporting_manager_name'])?$componentData['reporting_manager_name']:'';
  $employee_id = isset($componentData['employee_id'])?$componentData['employee_id']:'';
  $reporting_manager_email = isset($componentData['hr_email_id'])?$componentData['hr_email_id']:'';
  $joining_date = isset($componentData['joining_date'])?$componentData['joining_date']:'';
$relieving_date = isset($componentData['relieving_date'])?$componentData['relieving_date']:'';
$reason_for_leaving = isset($componentData['reason_for_leaving'])?$componentData['reason_for_leaving']:'';
$company_name = isset($componentData['company_name'])?$componentData['company_name']:'';
$reporting_manager_desigination = isset($componentData['reporting_manager_desigination'])?$componentData['reporting_manager_desigination']:'';
$desigination = isset($componentData['desigination'])?$componentData['desigination']:'';
$department = isset($componentData['department'])?$componentData['department']:'';
}else if (isset($componentData['previous_emp_id'])) { 
 $reporting_manager_name1 = json_decode($componentData['reporting_manager_name'],true);
 $employee_id1 = json_decode($componentData['employee_id'],true);
 $reporting_manager_email_id1 = json_decode($componentData['hr_email_id'],true);
 $joining_date1 = json_decode($componentData['joining_date'],true);
 $relieving_date1 = json_decode($componentData['relieving_date'],true);
 $reason_for_leaving1 = json_decode($componentData['reason_for_leaving'],true);
 $reporting_manager_desigination1 = json_decode($componentData['reporting_manager_desigination'],true);
 $desigination1 = json_decode($componentData['desigination'],true);
 $department1 = json_decode($componentData['department'],true);
 $company_name1 = json_decode($componentData['company_name'],true); 

$reporting_manager_name = isset($reporting_manager_name1[$index]['reporting_manager_name'])?$reporting_manager_name1[$index]['reporting_manager_name']:'';
$company_name = isset($company_name1[$index]['company_name'])?$company_name1[$index]['company_name']:'';
$employee_id = isset($employee_id1[$index]['employee_id'])?$employee_id1[$index]['employee_id']:'';
$reporting_manager_email_id = isset($reporting_manager_email_id1[$index]['hr_email_id'])?$reporting_manager_email_id1[$index]['hr_email_id']:'';
$joining_date = isset($joining_date1[$index]['joining_date'])?$joining_date1[$index]['joining_date']:'';
$relieving_date = isset($relieving_date1[$index]['relieving_date'])?$relieving_date1[$index]['relieving_date']:'';
$reason_for_leaving = isset($reason_for_leaving1[$index]['reason_for_leaving'])?$reason_for_leaving1[$index]['reason_for_leaving']:'';
$reporting_manager_desigination = isset($reporting_manager_desigination1[$index]['reporting_manager_desigination'])?$reporting_manager_desigination1[$index]['reporting_manager_desigination']:'';
$desigination = isset($desigination1[$index]['desigination'])?$desigination1[$index]['desigination']:'';
$department = isset($department1[$index]['department'])?$department1[$index]['department']:'';


}

?>
<!-- Popup Content -->
<!-- <form> -->
<div id="employee-SendMail" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="raise-issue-txt">
                    <h3>Send Mail</h3>
                    <!-- <ul> <li>To: <span><input type="text" class="fld" name="employee-to-mail"></span></li>
                  <li>Subject: <span><input type="text" class="fld" name="employee-subject"></span></li>
               </ul> -->

                    <div class="row">
                        <div class="col-md-2">To:</div>
                        <div class="col-md-10"><input type="text" placeholder="Enter Email" class="fld"
                                id="employee-to-mail" value="<?php echo $reporting_manager_email; ?>"
                                name="employee-to-mail"></div>
                        <div class="col-md-2 mt-1">Subject:</div>
                        <div class="col-md-10 mt-1"><input type="text" placeholder="Enter Subject" class="fld"
                                id="employee-subject" name="employee-subject"></div>
                    </div>

                </div>
                <div class="raise-issue-cnt mt-2">
                    <textarea name="" cols="" rows="" class="fld2 ckeditor" id="employee-mail-box"
                        placeholder="Message">
                 <p>To,&nbsp;</p>

<p>The&nbsp;Human&nbsp;Resource&nbsp;Department&nbsp;</p>

<p>&nbsp;Greetings&nbsp;from&nbsp;Factsuite!&nbsp;</p>

<p>We&nbsp;are&nbsp;reaching&nbsp;out&nbsp;to&nbsp;you&nbsp;to&nbsp;conduct&nbsp;Employment&nbsp;Verification,&nbsp;on&nbsp;behalf&nbsp;of&nbsp;our&nbsp;client.&nbsp;</p>

<p>Factsuite&nbsp;conducts&nbsp;Background&nbsp;screening&nbsp;of&nbsp;Job&nbsp;applicants,&nbsp;to&nbsp;thoroughly&nbsp;verify&nbsp;their&nbsp;</p>

<p>credentials&nbsp;&amp;&nbsp;antecedents,&nbsp;to&nbsp;ascertain&nbsp;any&nbsp;information&nbsp;which&nbsp;is&nbsp;relevant&nbsp;to&nbsp;their&nbsp;application.&nbsp;To&nbsp;</p>

<p>know&nbsp;more&nbsp;about&nbsp;us&nbsp;kindly&nbsp;visit&nbsp;our&nbsp;website:Factsuite.com&nbsp;</p>

<p>This&nbsp;mail&nbsp;is&nbsp;with&nbsp;reference&nbsp;to&nbsp;the&nbsp;Employment&nbsp;Verification&nbsp;of&nbsp;<b> <?php echo $candidateName;?> </b>,&nbsp;who&nbsp;claims&nbsp;past&nbsp;</p>

<p>employment&nbsp;with&nbsp;your&nbsp;esteemed&nbsp;organization&nbsp;<?php echo $company_name;?>.&nbsp;We&nbsp;request&nbsp;you&nbsp;to&nbsp;verify&nbsp;the&nbsp;</p>

<p>below&nbsp;mentioned&nbsp;information&nbsp;related&nbsp;to&nbsp;<?php echo $candidateName;?>&rsquo;s&nbsp;service&nbsp;in&nbsp;your&nbsp;company&nbsp;and&nbsp;to&nbsp;</p>

<p>kindly&nbsp;authenticate&nbsp;the&nbsp;attached&nbsp;document.&nbsp;</p>

<p>We&nbsp;would&nbsp;appreciate&nbsp;any&nbsp;helpful&nbsp;comments&nbsp;you&nbsp;care&nbsp;to&nbsp;make&nbsp;in&nbsp;this&nbsp;regard,&nbsp;and&nbsp;the&nbsp;</p>

<p>information&nbsp;provided&nbsp;by&nbsp;you&nbsp;will&nbsp;be&nbsp;kept&nbsp;with&nbsp;strict&nbsp;confidence.&nbsp;&nbsp;</p>

<p>&nbsp;</p>

<table  border="1" cellpadding="1" cellspacing="1" style="width:500px">
  <tbody>
    <tr>
      <td>
      <p>Details&nbsp;</p>
      </td>
      <td colspan="2">
      <p>Applicant&nbsp;Supplied&nbsp;info&nbsp;</p>
      </td>
      <td>
      <p>HR&nbsp;Comments&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Employment&nbsp;Dates&nbsp;</p>
      </td>
      <td>
      <p>&nbsp;<?php echo $joining_date; ?></p>
      </td>
      <td>
      <p>&nbsp;<?php echo $relieving_date; ?></p>
      </td>
      <td>
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Designation&nbsp;&amp;&nbsp;department&nbsp;</p>
      </td>
      <td colspan="2">
      <p>&nbsp;<?php echo $desigination.'-'.$department;?></p>
      </td>
      <td>
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Employee&nbsp;Code&nbsp;</p>
      </td>
      <td colspan="2">
      <p>&nbsp;<?php echo $employee_id; ?></p>
      </td>
      <td>
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Supervisor&rsquo;s&nbsp;Name&nbsp;&amp;&nbsp;Designation&nbsp;</p>
      </td>
      <td colspan="2">
      <p>&nbsp;<?php echo $reporting_manager_name.'-'.$reporting_manager_desigination; ?></p>
      </td>
      <td>
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Remuneration&nbsp;</p>
      </td>
      <td colspan="2">
      <p>&nbsp;</p>
      </td>
      <td>
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Reason&nbsp;for&nbsp;Leaving&nbsp;</p>
      </td>
      <td colspan="2">
      <p>&nbsp;<?php echo $reason_for_leaving; ?></p>
      </td>
      <td>
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Eligible&nbsp;for&nbsp;Rehire&nbsp;</p>
      </td>
      <td colspan="2">
      <p>&nbsp;</p>
      </td>
      <td>
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Attendance&nbsp;&amp;&nbsp;Punctuality&nbsp;</p>
      </td>
      <td colspan="3">
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Job&nbsp;Performance&nbsp;(1-5)&nbsp;</p>
      </td>
      <td colspan="3">
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Exit&nbsp;formalities&nbsp;Pending&nbsp;or&nbsp;Completed&nbsp;</p>
      </td>
      <td colspan="3">
      <p>&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Any&nbsp;Disciplinary&nbsp;Issues&nbsp;</p>
      </td>
      <td colspan="3">
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Additional&nbsp;Comments&nbsp;</p>
      </td>
      <td colspan="3">
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Verifier&rsquo;s&nbsp;Name&nbsp;&amp;&nbsp;Designation&nbsp;</p>
      </td>
      <td colspan="3">
      <p>&nbsp;&nbsp;</p>
      </td>
    </tr>
  </tbody>
</table>

<p>Looking&nbsp;forward&nbsp;to&nbsp;an&nbsp;early&nbsp;response,&nbsp;as&nbsp;it&nbsp;would&nbsp;help&nbsp;conclude&nbsp;the&nbsp;candidate&rsquo;s&nbsp;recruitment&nbsp;</p>

<p>process.&nbsp;</p>

<p>Thanks&nbsp;&amp;&nbsp;Regards&nbsp;</p>

<p>Analyst/&nbsp;Specialist&nbsp;Signature&nbsp;</p>

               </textarea>

                    <div class="btn bg-blu btn-submit"><a id="employee-mail-box-btn" class="text-white"
                            href="#">Send</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </form> -->
<script type="text/javascript"> 
$('#assigned-to-role').on('change', function() { 
    if ($(this).val() !='') {
          get_roles_person_list();
    } 
});



$("#ticket_description").on('change',function(){
    if ($(this).val()=='Others') {
        $("#additionals").show();
    }else{
       $("#additionals").hide();  
    }
})


$("#raise-ticket-btn").on('click',function(){
   raise_new_ticket();
});

function raise_new_ticket() {
    var assigned_to_role = $('#assigned-to-role').val(),
        assigned_to_person = $('#assigned-to-person').val(),  
        ticket_description = $('#ticket_description').val(),
        ticket_priority = $('#ticket-priority').val(); 
        var radio_client = $('.radio-client:checked').val();
        var case_id = $("#case-id").val();
        var component_name = $("#component-name").val();
        var amount = $("#amount").val();
        var portal_name = $("#portal-name").val();
        var component_id = $("#component-id").val();
        var component_index = $("#component-index").val();
        var currency = $("#currency").val();

  
    if (ticket_description != '') {
        $('#ticket-classifications-error-msg-div').html('');
        $('#raise-ticket-btn').prop('disabled',true);
        $('#raise-ticket-error-msg-div').html('<span class="d-block text-warning error-msg text-center">Please wait while we are adding the Approval Request.</span>');

        var formdata = new FormData();
        formdata.append('verify_csm_request',1);
        formdata.append('assigned_to_role',assigned_to_role);
        formdata.append('assigned_to_person_id',assigned_to_person); 
        formdata.append('description',ticket_description);   
        formdata.append('case_id',case_id);   
        formdata.append('component_name',component_name);   
        formdata.append('component_id',component_id);   
        formdata.append('component_index',component_index);   
        formdata.append('amount',amount);   
        formdata.append('portal_name',portal_name);   
        formdata.append('currency',currency);   

        

        $.ajax({
            type: "POST",
            url: base_url+"approval_Mechanisms/approval_for_client_fee",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == '1') {
                    $('#raise-ticket-btn').prop('disabled',false);
                    $('#raise-ticket-error-msg-div').html('');
                    if (data.status == '1') {
                        toastr.success('Your ticket has been raised successfully.');
                        $('#add-new-ticket-modal').modal('hide');
                        $('#assigned-to-role').val('');
                        $('#assigned-to-person').html('<option value="">Select Person</option>');
                        $('#ticket-subject').val('');
                        // CKEDITOR.instances['ticket_description'].setData('');
                        $('#ticket_description').val();
                        $('#ticket-priority').val(''); 
                         var radio_client = $('.radio-client:checked').val('');
                        var case_id = $("#case-id").val('');
                        var component_name = $("#component-name").val('');
                        var amount = $("#amount").val('');
                        var portal_name = $("#portal-name").val('');
                        // get_all_raised_tickets();
                    } else {
                        toastr.error('Something went wrong while raising the ticket. Please try again.');
                    }
                } else {
                    check_admin_login();
                }
            },
            error: function(data) {
                $('#raise-ticket-btn').prop('disabled',false);
                $('#raise-ticket-error-msg-div').html('');
                toastr.error('Something went wrong while raising the ticket. Please try again.');
            }
        });
    } else {
        if (ticket_description == '') {
            $('#ticket-description-error-msg-div').html('<span class="text-danger error-msg-small">Please enter the ticket description.</span>');
        } else {
            $('#ticket-description-error-msg-div').html('');
        }
    }
}

get_all_approval_list();
</script>