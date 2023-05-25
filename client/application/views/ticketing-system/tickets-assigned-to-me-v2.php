  
            <div class="row">
              <div class="col-md-12 mt-3">
                <div class="table-responsive" id="get-all-tickets-list">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade custom-modal" id="add-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title">Raise a ticket</h4>
          <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2">
              <div class="col-sm-6">
                <label class="input-field-txt">Select Role</label>
                <select class="input-field" id="assigned-to-role">
                  <option value="">Select Role</option>
                </select>
                <div id="assigned-to-role-error-msg-div"></div>
              </div>
              <div class="col-sm-6">
                <label class="input-field-txt">Select Person</label>
                <select class="input-field" id="assigned-to-person">
                  <option value="">Select Person</option>
                </select>
                <div id="assigned-to-person-error-msg-div"></div>
              </div>
              <div class="col-sm-12">
                <label class="input-field-txt">Subject</label>
                <input type="text" class="input-field" id="ticket-subject">
                <div id="ticket-subject-error-msg-div"></div>
              </div>
              <div class="col-md-12">
                <label class="input-field-txt">Description</label>
                <!-- ckeditor -->
                <textarea class="input-field" name="ticket_description" id="ticket_description" placeholder="Ticket Description"></textarea>
                <div id="ticket-description-error-msg-div"></div>
              </div>
              <div class="col-sm-6">
                <label class="input-field-txt">Priority</label>
                <select class="input-field" id="ticket-priority"></select>
                <div id="ticket-priority-error-msg-div"></div>
              </div>
              <div class="col-sm-6">
                <label class="input-field-txt">Classifications</label>
                <select class="input-field" id="ticket-classifications"></select>
                <div id="ticket-classifications-error-msg-div"></div>
              </div>
              <div class="col-sm-6 mt-2">
                <div class="add-vendor-bx2">
                  <label class="input-field-txt">Attach file</label>
                  <div class="form-group mb-0">
                    <input type="file" id="ticket-attach-file" name="ticket-attach-file" class="fld">
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
          <button type="button" class="btn btn-close" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-submit" id="raise-ticket-btn">Add</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->

  <!-- View Ticket Details Modal Starts -->
  <div class="modal fade candidate-details-modal custom-modal" id="view-ticket-details-modal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header">
          <h4 class="modal-title">Ticket Details</h4>
          <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h6 class="modal-contact-history-txt">Overview</h6>
                  <div class="row">
                    <div class="col-md-12 ticket-subject">Subject : <span id="show-ticket-subject-modal">-</span></div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12">Description : <span id="show-ticket-description-modal">-</span></div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-4">
                      Status
                      <div id="show-ticket-status-modal" class="modal-show-ticket-status">-</div>
                      <div id="show-ticket-status-btn-modal"></div>
                    </div>
                    <div class="col-md-4">
                      Priority
                      <div id="show-ticket-priority-modal" class="modal-show-ticket-priority">-</div>
                    </div>
                    <div class="col-md-4">
                      Classifications
                      <div id="show-ticket-classification-modal" class="modal-show-ticket-classification">-</div>
                    </div>
                  </div>
                  <div class="row" id="raise-ticket-attached-modal-file-main-div"></div>
                </div>
              </div>
            </div>

            <div class="col-md-6 comments-div-2">
              <div class="card">
                <div class="card-body">
                  <div class="chat-timeline chat-timeline-2">
                    <div class="timeline timeline-inverse" id="timeline-chat"></div>
                  </div>
                </div>
                <div class="card-header">
                  <textarea id="note_message" class="form-control ticket-comment-input" rows="1" placeholder="Leave a Note Here..."></textarea>
                  <div id="note-message-error-msg-div"></div>
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                      <div class="mt-3 pb-3">
                        <button class="btn btn-transperant w-100" id="refresh-chat-btn">Refresh Chat</button>
                      </div>
                    </div>
                     <div class="col-md-4">
                      <div class="mt-3 pb-3">
                        <button class="btn btn-submit w-100" id="submit-new-note">Send</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
      
        </div>
      </div>
    </div>
  </div>
  <!-- View Ticket Details Modal Ends -->

<script>
  var site_url = 'factsuite-client/ticket-assign-to-me-pagination';
  var html = '<table class="table custom-table table-striped">';
      html += '<thead>';
      html += '<tr><th>Sl&nbsp;No.</th>';
      html += '<th>Role</th>';
      html += '<th>Subject</th>';
      html += '<th>Created&nbsp;Date</th>';
      html += '<th>Status</th>';
      html += '<th class="text-center">Actions</th>'; 
      html += '</thead>';
      html += '<tbody>';
      html += '<tr><td colspan="6" class="text-center"><div class="spinner-border text-muted custom-spinner"></div></td></tr>';
      html += '</tbody>';
      html += '</table>';
  var display_ui_id = '#get-all-tickets-list';
</script>
<!-- custom-js -->
<script src="<?php echo base_url() ?>assets/custom-js/ticketing/tickets-assigned-to-me.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/pagination/pagination.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/common-validation.js"></script>

<?php extract($_GET);
if (isset($tkt_id)) { ?>
  <script>
    view_ticket_details(<?php echo $tkt_id;?>);
  </script>
<?php } ?> 