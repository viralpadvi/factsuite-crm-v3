  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Raise Ticket</h3>
        <div class="sbt-btns">
          <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#add-new-ticket-modal"class="btn bg-blu btn-submit-cancel">Raise a Ticket</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sl No.</th> 
                <th>Ticket&nbsp;Id</th>  
                <th>Subject</th>  
                <th>Created&nbsp;Date</th>  
                <th>Status</th>  
                <th>Actions</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-all-tickets"></tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="add-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Raise a ticket</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2">
              <div class="col-sm-6">
                <label class="product-details-span-light">Select Role</label>
                <select class="form-control fld" id="assigned-to-role">
                  <option value="">Select Role</option>
                </select>
                <div id="assigned-to-role-error-msg-div"></div>
              </div>
              <div class="col-sm-6">
                <label class="product-details-span-light">Select Person</label>
                <select class="form-control fld" id="assigned-to-person">
                  <option value="">Select Person</option>
                </select>
                <div id="assigned-to-person-error-msg-div"></div>
              </div>
              <div class="col-sm-12">
                <label class="product-details-span-light">Subject</label>
                <input type="text" class="form-control" id="ticket-subject">
                <div id="ticket-subject-error-msg-div"></div>
              </div>
              <div class="col-md-12">
                <label class="product-details-span-light">Description</label>
                <!-- ckeditor -->
                <textarea class="fld" name="ticket_description" id="ticket_description" placeholder="Ticket Description"></textarea>
                <div id="ticket-description-error-msg-div"></div>
              </div>
              <div class="col-sm-6">
                <label class="product-details-span-light">Priority</label>
                <select class="form-control" id="ticket-priority"></select>
                <div id="ticket-priority-error-msg-div"></div>
              </div>
              <div class="col-sm-6">
                <label class="product-details-span-light">Classifications</label>
                <select class="form-control" id="ticket-classifications"></select>
                <div id="ticket-classifications-error-msg-div"></div>
              </div>
              <div class="col-sm-6 mt-2">
                <div class="add-vendor-bx2">
                  <label>Attach file</label>
                  <div class="form-group mb-0">
                    <input type="file" id="ticket-attach-file" name="ticket-attach-file">
                    <label class="btn upload-btn" for="ticket-attach-file">Upload</label>
                  </div>
                </div>
                <div id="ticket-attach-file-error-msg-div"></div>
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
<script src="<?php echo base_url() ?>assets/custom-js/tech-support/ticketing/raise-ticket.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/tech-support/ticketing/all-tickets.js"></script>