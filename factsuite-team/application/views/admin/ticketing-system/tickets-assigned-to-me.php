  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Tickets Assigned to Me</h3>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sl No.</th>
                <th>Ticket&nbsp;Id</th>
                <th>Role</th>
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
            <div class="col-md-3">
              <!-- Profile Image -->
              <div class="card card-primary card-outline d-none">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="../uploads/images/candidate.png" alt="User profile picture">
                  </div>

                  <h3 class="profile-username text-center" id="ticket-raised-by-name"></h3>
                    <div class="row mb-4 connect-to-candidate-div">
                     <div class="col-md-4 text-center">
                      <div class="card">  
                        <span class="connect-way-icon" id="modal-click-to-call" data-toggle="modal" data-target="#click-to-call-candidate-modal">
                          <i class="fa fa-phone"></i>
                        </span>
                        <h6 class="connect-way-text">Call</h6> 
                      </div> 
                    </div>
                    <!-- /.col -->
                     <div class="col-md-4 text-center">
                      <div class="card">  
                          <span class="connect-way-icon" id="modal-click-to-mail" data-toggle="modal" data-target="#click-to-mail-candidate-modal"><i class="fa fa-envelope"></i></span>
                          <h6 class="connect-way-text">Email</h6> 
                      </div> 
                    </div>
                    <!-- /.col -->
                     <div class="col-md-4 text-center">
                      <div class="card">  
                          <span class="connect-way-icon" id="modal-click-to-sms" data-toggle="modal" data-target="#click-to-sms-candidate-modal"><i class="fa fa-comments"></i></span>
                          <h6 class="connect-way-text">SMS</h6> 
                      </div> 
                    </div>
                    <!-- /.col -->
                  </div>

                  <!-- <div class="text-center modal-case-status-div">
                    <span class="modal-case-status-txt">Ticket Status :</span> 
                    <span class="modal-case-status" id="show-ticket-status">-</span>
                  </div> -->
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- About Me Box -->
              <div class="card card-primary about-candidate-div mt-0">
                <div class="card-header pl-0">
                  <h3 class="card-title">About Assignee</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <strong>Full Name</strong>
                  <p class="text-muted" id="raised-ticket-about-full-name"></p>

                  <strong>Phone Number</strong>
                  <p class="text-muted" id="raised-ticket-about-phone-number"></p>

                  <strong>Email</strong>
                  <p class="text-muted" id="raised-ticket-about-email-id"></p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h6 class="modal-contact-history-txt">Ticket Details</h6>
                  <div class="modal-case-status-div">
                    <span class="modal-case-status-txt">Ticket Status :</span> 
                    <span class="modal-case-status" id="show-ticket-status">-</span>
                  </div>
                  <div class="row modal-last-call d-none">
                    <div class="col-md-12">
                      <span class="modal-last-call-txt">Last Call Made</span>
                      <h6 class="modal-last-call-time" id="show-last-call-date-and-time">-</h6>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-5">Status</div>
                    <div class="col-md-4" id="show-ticket-status-modal">-</div>
                    <div class="col-md-3" id="show-ticket-status-btn-modal">
                      <button class="btn btn-comment" id="update-ticket-status-btn">Save</button>
                    </div>
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

            <div class="col-md-5 comments-div">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fa fa-pencil"></i> Add New Note</h4>
                  <hr>
                  <textarea id="note_message" class="form-control" placeholder="Leave a note" rows="4"></textarea>
                  <div id="note-message-error-msg-div"></div>
                  <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-4">
                      <div class="text-right pr-4 mt-3 pb-3">
                        <button class="btn btn-comment" id="refresh-chat-btn">Refresh Chat</button>
                      </div>
                    </div>
                    <div class="col-md-3">
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
<script src="<?php echo base_url() ?>assets/custom-js/admin/ticketing/tickets-assigned-to-me.js"></script>

<?php 
  extract($_GET);
  if (isset($tkt_id)) { ?>
    <script>
      view_ticket_details(<?php echo $tkt_id;?>);
    </script>
  <?php }
?>