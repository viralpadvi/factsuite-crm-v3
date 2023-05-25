
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.min.css">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin"> 
        <h3>View All Cases</h3>
         <div class="row">
            <div class="col-md-8 text-right">
               
            </div>
            <div class="col-md-4 text-right d-none">
               <a class="btn bg-blu btn-submit" id="btn_pause_re_start_tat">
                  <span class="text-white" id="btn_tat_name">Pause TAT</span>
               </a>
               <a class="btn bg-blu btn-submit" id="btn_re_start_tat">
                  <span class="text-white" id="btn_tat_re_start_name">Restart TAT</span>
               </a>
            </div>
         </div>
         <div class="row my-3">
            <div class="col-md-2">
               <input type="checkbox" name="bulk-check-cases" id="bulk-check-cases">
               <label for="bulk-check-cases">Check All</label>
               <select class="w-50" id="filter-cases-number"></select>
            </div>
            <!-- <div class="col-md-2">
               <select class="form-control custom-iput-1" id="filter-cases-number"></select>
            </div> -->
            <div class="col-md-2">
               <div id="assign-to-dropdown-div" style="display:none">
                  <select class="form-control custom-iput-1" id="assign-to-dropdown">
                     <option value="">Select</option>
                     <option value="assign-to-inputqc">Assign to InputQC</option>
                     <option value="assign-to-outputqc">Assign to OutputQC</option>
                  </select>
               </div>
            </div>
            <div class="col-md-3">
               <div id="dropdown-2-div" style="display:none"></div>
            </div>
            <div class="col-md-3">
               <!-- <input class="form-control custom-iput-1" id="filter-input" autocomplete="off" type="search" placeholder="Search"> -->
               <textarea class="form-control custom-iput-1" rows="1" autocomplete="off" style="resize:none;" id="filter-input" placeholder="Search"></textarea>
            </div>
            <div class="col-md-2">
               <button class="send-btn mt-0 mr-0 btn-filter-search" id="all-case-filter-btn" onclick="get_priority_cases('filter_input')" autocomplete="off">Search</button>
            </div>
         </div>
         <div class="table-responsive mt-3" id="">
            <table class="table-fixed table table-striped">
               <thead class="table-fixed-thead thead-bd-color">
                 <tr>
                   <th>Select</th> 
                   <!-- <th>Sr No.</th>  -->
                   <th>Case Id</th> 
                   <th>Candidate Name</th> 
                   <th>Client Name</th> 
                   <th class="d-none">Social </th>
                   <th>Source</th> 
                   <!-- <th>Phone Number</th>   -->
                   <!-- <th>Email Id</th>  -->
                   <th>Priority</th>
                   <th>Assigned InputQC</th> 
                   <!-- <th>Re-Assigned InputQC</th>  -->
                   <th>Assigned OutputQC</th> 
                   <!-- <th>Re-Assigned OutputQC</th>  -->
                   <th>Verification Status</th> 
                   <th>Case Start Date</th>
                   <th>Case Completed Date</th>
                   <!-- <th>Total TAT days</th> -->
                   <th>Actual TAT Days</th>
                   <th>Actions</th>    
                   <!-- <th>Actions</th>     -->
                 </tr>
               </thead>
               <tbody class="table-fixed-tbody tbody-datatable" id="get-case-data"></tbody>
            </table>
         </div>
         <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-2 text-center" id="load-more-btn-div"></div>
            <div class="col-md-5"></div>
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
<!-- Popup Content -->
<!-- <form> -->
<div id="View" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="view-lft">
               <div class="view-hd">Individual Case Status</div>
               <div id="view-srch" class="">
                    <div class="input-group">
                        <input type="text" class="search-query form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button type="button">
                                <span class="fa fa-search"></span>
                            </button>
                        </span>
                     </div>
               </div>
               <div class="view-dtls">
                  <ul>
                     <li class="view-date">
                        Start Date <span id="case-date">12 Feb 2020</span>
                     </li>
                     <li  class="view-status">
                        Status <span id="case-status">On Progress</span>
                     </li>
                     <li class="view-days">
                        Days Left 3
                     </li>
                     <li class="view-deadline">
                       Dead Line <span id="case-end-date">18 Feb 2020</span>
                     </li>
                  </ul>
                  <div class="clr"></div>
               </div>
               <div class="view-bx">
                  <!-- <div class="view-bx-txt  "><span>3</span> of <span>8</span> Milestone Completed</div> -->
                   <!--Milestones-->
                  <div id="milestones" class="scrollbar-primary">
                    <ul id="milestones-ul" class="progressbar">
                        
                    </ul> 
                  </div>
                  <!--Milestones-->
               </div>
            </div>
            <div class="view-rgt">
               <div class="individual">
                  <div class="cls"><a href="#" data-dismiss="modal"><img src="<?php echo base_url(); ?>assets/admin/images/close.png" /></a></div>
                  <div class="individual-dtls">
                     <div class="individual-nm">
                        <!-- Progress bar 1 -->
                        <div class="progress" id="progress-data-value" data-value="29">
                           <img src="<?php echo base_url(); ?>assets/admin/images/candidate.png" />
                           <span class="progress-left">
                              <span class="progress-bar border-primary"></span>
                           </span>
                           <span class="progress-right">
                              <span class="progress-bar border-primary"></span>
                           </span>
                        <div id="progress-percentage" class="progress-value">0%</div>
                        </div>
                        <!-- END -->
                        <h3 id="candidate-name" class="text-capitalize">Ashish K</h3>
                        <h5>ID:<span id="candidate-id"></span></h5>
                     </div>
                     <div class="individual-txt">
                        <ul>
                           <li class=""><img src="<?php echo base_url(); ?>assets/admin/images/address.png" /> Riyatsa Emergent 10th floor Wework, Hebbal, Bangalore</li>
                           <li><img src="<?php echo base_url(); ?>assets/admin/images/phone.png" /><span id="phone-number"></span> </li>
                           <li><img src="<?php echo base_url(); ?>assets/admin/images/date.png" /><span id="date-of-birth">25 August 1992</span></li>
                           <li><img src="<?php echo base_url(); ?>assets/admin/images/id-card.png" /> <span id="Email-id">abc@gmail.com</span></li>
                           <li class=""><img src="<?php echo base_url(); ?>assets/admin/images/location.png" /> Bangalore Koramangala</li>
                        </ul>
                     </div>
                  </div>
                 <!--  <div class="comments">
                     <div class="comment-hd">
                        Comments
                     </div>
                     <div id="content-5" class="comment-bx custom-scrollbar-js">
                        <div class="comment-txt">
                           <ul>
                              <li>
                                 <img src="<?php echo base_url(); ?>assets/admin/images/comment-image.jpg" />
                                 <h5>@SWAGAT status needs to update before 12-2-09</h5>
                                 <span>Date: 17-02-2020 &nbsp; &nbsp; 12:00:17</span>
                              </li>
                              <li>
                                 <img src="<?php echo base_url(); ?>assets/admin/images/comment-image.jpg" />
                                 <h5>status needs to update before 12-2-09</h5>
                                 <span>Date: 17-02-2020 &nbsp; &nbsp; 12:00:17</span>
                              </li>
                              <li>
                                 <img src="<?php echo base_url(); ?>assets/admin/images/comment-image.jpg" />
                                 <h5>status needs to update before 12-2-09</h5>
                                 <span>Date: 17-02-2020 &nbsp; &nbsp; 12:00:17</span>
                              </li>
                              <li>
                                 <img src="<?php echo base_url(); ?>assets/admin/images/comment-image.jpg" />
                                 <h5>status needs to update before 12-2-09</h5>
                                 <span>Date: 17-02-2020 &nbsp; &nbsp; 12:00:17</span>
                              </li>
                              <li>
                                 <img src="<?php echo base_url(); ?>assets/admin/images/comment-image.jpg" />
                                 <h5>status needs to update before 12-2-09</h5>
                                 <span>Date: 17-02-2020 &nbsp; &nbsp; 12:00:17</span>
                              </li>
                              <li>
                                 <img src="<?php echo base_url(); ?>assets/admin/images/comment-image.jpg" />
                                 <h5>status needs to update before 12-2-09</h5>
                                 <span>Date: 17-02-2020 &nbsp; &nbsp; 12:00:17</span>
                              </li>
                              <li class="last">
                                 <img src="<?php echo base_url(); ?>assets/admin/images/comment-image.jpg" />
                                 <h5>status needs to update before 12-2-09</h5>
                                 <span>Date: 17-02-2020 &nbsp; &nbsp; 12:00:17</span>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="comment-type">
                        <div class="input-group mb-3">
                           <input type="email" class="form-control comment-fld" placeholder="@ Type your comment..." />
                           <div class="input-group-append">
                             <button class="btn comment-btn" type="button"><img src="<?php echo base_url(); ?>assets/admin/images/comments-button.png" /></button>
                           </div>
                        </div>
                     </div>
                  </div> -->
               </div>
            </div>
            <div class="clr"></div>
         </div>
      </div>
   </div>
</div>
<!-- </form> -->

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

 <!-- all case TAT confirm dailog -->
<div id="all_case_TAT_confirm_dailog" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-pending-bx">
            <h4 id="tat_hading" class="snd-mail-pop">Are you sure you want to pause the all case TAT?</h4>
            <div class="row">
               <div class="col-md-12 form-group">
                  <label>Please Enter your login password.</label>
                  </br>
                  <input type="hidden" name="login_email" 
                     value="<?php echo $session['team_employee_email']?>">
                  <input class="form-control" id="login_password" type="password" name="login_password" placeholder="Enter your login password" required>
               </div> 
            </div>
            <div class="row form-group">
               <div class="col-md-12 text-left">
                  <div id="password_error">
                  
                  </div>  
               </div>
            </div>
            <div class="row form-group">
               <div class="col-md-12 text-right">
                  <button id="all_case_tat_cancle" class="btn bg-blu btn-submit text-white" data-dismiss="modal">Cancel</button>
                  <button id="all_case_tat" onclick="update_all_case_tat()" class="btn bg-blu btn-submit text-white">Confirm</button>
               </div>    
            </div>
            <div class="clr"></div>
         </div>
      </div>
   </div>
</div> 

<!-- Bulk Assign modal Starts -->
<div id="bulk-override-assignment-cases-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <!-- <h3 class="snd-mail-pop">Override Assingment in Bulk</h3> -->
            <h4 id="">Are you sure you want to assign selected cases to <span id="bulk-assign-team-member-role"></span>-<span id="bulk-assign-team-member-name"></span>?</h4>
            <div id="bulk-assign-modal-error-msg-div"></div>
            <div>
               <button id="btn-bulk-upload-confirm" class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button>
               <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>   
            </div>
            <div class="clr"></div>
          </div>
       </div>
    </div>
</div>
<!-- Bulk Assign modal Ends -->


<div id="delete-case-modal" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="delete-case-txt-hdr">
               <h3 class="text-center">Delete Case: <span id="modal-hdr-delete-case-id"></span></h3>
            </div>
            <div class="raise-issue-cnt">
               <h3 class="delete-case-modal-txt">Are you sure you want to delete the case <span id="modal-confirm-txt-delete-case-id"></span>?</h3>
               <span class="delete-case-modal-note">* Note: By Deleting the case <span id="modal-confirm-note-txt-delete-case-id"></span>, all the details of the case will be erased permanently.</span>
               <div class="row mt-4">
                  <div class="col-md-12">
                     <label>Enter Password</label>
                     <input type="password" class="form-control fld w-100" placeholder="Enter Password" id="delete-case-verify-password">
                     <div id="delete-case-verify-password-error-msg-div"></div>
                     <div class="text-right mt-4">
                        <button class="btn btn-transparent" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger" id="delete-case-btn">Delete</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="<?php echo base_url() ?>assets/custom-js/admin/caseList/view-all-cases.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
  $("#content-5, #content-6").mCustomScrollbar({
    theme: "dark-thin"
  });
</script>