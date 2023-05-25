  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Client Creation / Deletion</h3>
        <div class="sbt-btns">
          <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#add-new-ticket-modal"class="btn bg-blu btn-submit-cancel">Client Delete</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sl No.</th> 
                <th>Approval&nbsp;Id</th>  
                <th>Action Type</th>  
                <th>Created&nbsp;Date</th>  
                <th>Remarks</th>  
                <th>Created by</th>  
                <th>Status</th>    
                <th>View</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-all-tickets"></tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div> 

  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="new-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Approval Mechanism</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2" > 
                 <div class="col-md-6" id="status_level_1" style="display:none;">
                <label>Level 1 Status :</label>
                <span id="level_one"></span>
              </div>
              <div class="col-md-6" id="status_level_2" style="display:none;">
                <label>Level 2 Status : </label>
                <span id="level_two"></span>
              </div>
              <div class="col-md-6" id="status_level_3" style="display:none;">
                <label>Level 3 Status : </label>
                <span id="level_three"></span>
              </div>
              <div class="col-md-6" >
                <label>Final Status : </label>
                <span id="final_status"></span>
              </div>
              <div class="col-sm-12">
                 <div>Created By: <span id="created_by"></span></div>
                 <div>Action Type: <span id="action_type"></span></div>
                 <div>Created Remarks: <span id="created_remarks"></span></div>
                 <div></div>
              </div>
                 
                 <div class="row" id="extra-details"></div>
                 <div class="col-md-12" id="rejected_remarks"></div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Close</button> 
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->
 
  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="add-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Client Delete Request</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2">
               <div class="col-sm-6 d-none">
                <label class="product-details-span-light">Approval Type</label>
                <select class="form-control fld" id="type-of-approval"> 
                  <option value="1">Deletion</option>
                </select>
                <div id="type-of-approval-error-msg-div"></div>
              </div>
              <div class="col-md-6" id="new-user-name-div" style="display:none;">
                <label>Client Name</label>
                 <input type="text" class="form-control" name="new-user-name" id="new-user-name"> 
              </div>

              <div class="col-sm-6 d-none">
                <label class="product-details-span-light">Select Role</label>
                <select class="form-control fld" id="assigned-to-role">
                  <option value="">Select Role</option>
                </select>
                <div id="assigned-to-role-error-msg-div"></div>
              </div>
              <div class="col-md-6 mt-4" id="client-type" style="display:none;">
                <input type="radio" class="mt-3 radio-client" name="radio-client" value="master">Master Account 
                <input type="radio" class="mt-3 radio-client" id="radio-client" name="radio-client" value="child">Child Account 
              </div>
              <div class="col-sm-6" id="client-list" >
                <label class="product-details-span-light">Select Client</label>
                <?php $client = $this->db->where('client_status',1)->get('tbl_client')->result_array(); ?>
                <select class="form-control fld" id="assigned-to-person"> 
                  <option value="">Select Client</option>
                  <?php 
                  if (count($client) > 0) {
                    foreach ($client as $key => $value) {
                      echo "<option value='{$value['client_id']}'>{$value['client_name']}</option>";
                    }
                  }
                  ?>
                </select>
                <div id="assigned-to-person-error-msg-div"></div>
              </div>
                  
               <div class="col-sm-6" style="display:none;" id="master-client">
                   <label class="product-details-span-light">Client Name</label>
                   <select class="form-control" id="user-name" name="user-name">
                     <option value="">Select Client</option>
                     <?php 
                      foreach ($client as $key => $value) {
                        echo "<option data-master='{$value['is_master']}' value='{$value['client_id']}'>{$value['client_name']}</option>";
                      }
                      ?>
                   </select>
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

  <!-- View Ticket Details Modal Starts -->
  <div class="modal fade candidate-details-modal" id="view-ticket-details-modal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h4 class="modal-title-edit-coupon">Ticket Details</h4>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h6 class="modal-contact-history-txt">Ticket Details</h6>
                  <div class="row mb-4 total-connecting-attempts-div d-none">
                     <div class="col-md-4 text-center">
                      <div class="card">  
                        <span class="connection-type">Total Calls</span>
                        <span class="no-of-connection" id="show-total-call">0</span> 
                      </div> 
                    </div>
                    <!-- /.col -->
                     <div class="col-md-4 text-center">
                      <div class="card">  
                          <span class="connection-type">Total Email</span>
                          <span class="no-of-connection" id="show-total-sent-emails">0</span> 
                      </div> 
                    </div>
                    <!-- /.col -->
                     <div class="col-md-4 text-center">
                      <div class="card">  
                          <span class="connection-type">Total SMS</span>
                          <span class="no-of-connection" id="show-total-sent-sms">0</span> 
                      </div> 
                    </div>
                    <!-- /.col -->
                  </div>
                  <div class="row mt-2 modal-last-call d-none">
                    <div class="col-md-12">
                      <span class="modal-last-call-txt">Last Call Made</span>
                      <h6 class="modal-last-call-time" id="show-last-call-date-and-time">-</h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-5">Status</div>
                    <div class="col-md-4" id="show-ticket-status-modal">-</div>
                    <div class="col-md-3" id="show-ticket-status-btn-modal"></div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-5">Priority</div>
                    <div class="col-md-7" id="show-ticket-priority-modal">-</div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-5">Classifications</div>
                    <div class="col-md-7" id="show-ticket-classification-modal">-</div>
                  </div>
                  <div class="row" id="raise-ticket-attached-modal-file-main-div">
                    <div class="col-md-4">Classifications</div>
                    <div class="col-md-8" id="show-ticket-classification-modal">-</div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12">Subject :</div>
                    <div class="col-md-12" id="show-ticket-subject-modal">-</div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12">Description :</div>
                    <div class="col-md-12" id="show-ticket-description-modal">-</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 comments-div">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fa fa-pencil"></i> Add New Note</h4>
                  <hr>
                  <textarea id="note_message" class="form-control" placeholder="Leave a note" rows="4"></textarea>
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
  <!-- View Ticket Details Modal Ends -->

</section>
<!--Content-->

<!-- custom-js -->
<script src="<?php echo base_url() ?>assets/custom-js/csm/approval/create-approval.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/csm/approval/all-approvals.js"></script>