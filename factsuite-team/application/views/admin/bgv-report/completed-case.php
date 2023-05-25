
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.min.css">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst"> 
        <h3>View All Completed Cases</h3>
          <div class="table-responsive mt-3" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <!-- <th class="d-none">Sr No.</th>  -->
                <th>Case Id</th> 
                <th>Candidate Name</th> 
                <th>Client Name</th> 
                <th>Email Id</th> 
                <!-- <th>Phone Number</th>  
                <th>Email Id</th>  -->
                <th>Verification Status</th> 
                <!-- <th>View Progress</th> -->
                <th class="d-none">Generate&nbsp;Report</th>  
                <th>Download</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data"></tbody>
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
<!-- Popup Content -->
<!-- <form> -->
<div id="View" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="view-lft">
               <div class="view-hd">Individual Case Status</div>
               <div id="view-srch" class="d-none">
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
                  <div class="view-bx-txt  d-none"><span>3</span> of <span>8</span> Milestone Completed</div>
                  <!--Milestones-->
                  <div id="milestones" class="scrollbar-primary" >
                     <ul id="milestones-progressbar" class="progressbar">
                      <!-- class="scrollbar-primary" -->
                       <!-- <li class="active">
                          <div class="view-tp"><span class="view-bg1">Candidate Form</span></div>
                          <div class="view-nm">Updated By <span class="view-bg1">Candidate</span></div>
                          <div class="view-btm">
                             <span>Start</span> 12 Feb 2020
                          </div>
                       </li>
                       <li class="active">
                          <div class="view-tp"><span class="view-bg1">Address Check</span></div>
                          <div class="view-nm">Updated By <span class="view-bg1">FactSuite</span></div>
                          <div class="view-btm">
                             <span>Check 1</span> 13 Feb 2020
                          </div>
                       </li>
                       <li class="active">
                          <div class="view-tp"><span class="view-bg1">Court Check</span></div>
                          <div class="view-nm">Updated By <span class="view-bg1">Vendor</span></div>
                          <div class="view-btm">
                             <span>Chek 2</span> 14 Feb 2020
                          </div>
                       </li>
                       <li class="pending">
                          <div class="view-tp"><span class="view-bg2">Crime Check</span></div>
                          <div class="view-nm">Updated By <span class="view-bg2">Vendor</span></div>
                          <div class="view-btm">
                             <span>Chek 2</span> 14 Feb 2020
                          </div>
                       </li>
                       <li>
                          <div class="view-tp"><span>Certificate Check</span></div>
                       </li>
                       <li>
                          <div class="view-tp"><span>Education Check</span></div>
                       </li>
                       <li>
                          <div class="view-tp"><span>DOB Check</span></div>
                       </li>
                       <li class="deadline">
                          <div class="view-btm">
                             <span class="view-bg3">Dead Line </span> 18 Feb 2020
                          </div>
                       </li> -->
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
                        <div class="progress" data-value="100">
                           <img src="<?php echo base_url(); ?>assets/admin/images/candidate.png" />
                           <span class="progress-left">
                              <span class="progress-bar border-primary"></span>
                           </span>
                           <span class="progress-right">
                              <span class="progress-bar border-primary"></span>
                           </span>
                        <div id="progress-percentage" class="progress-value">30%</div>
                        </div>
                        <!-- END -->
                        <h3 id="candidate-name" class="text-capitalize">Ashish K</h3>
                        <h5>ID:<span id="candidate-id"></span></h5>
                     </div>
                     <div class="individual-txt">
                        <ul>
                           <li class="d-none"><img src="<?php echo base_url(); ?>assets/admin/images/address.png" /> Riyatsa Emergent 10th floor Wework, Hebbal, Bangalore</li>
                           <li><img src="<?php echo base_url(); ?>assets/admin/images/phone.png" /><span id="phone-number"></span> </li>
                           <li><img src="<?php echo base_url(); ?>assets/admin/images/date.png" /><span id="date-of-birth">25 August 1992</span></li>
                           <li><img src="<?php echo base_url(); ?>assets/admin/images/id-card.png" /> <span id="Email-id">abc@gmail.com</span></li>
                           <li class="d-none"><img src="<?php echo base_url(); ?>assets/admin/images/location.png" /> Bangalore Koramangala</li>
                        </ul>
                     </div>
                  </div> 
               </div>
            </div>
            <div class="clr"></div>
         </div>
      </div>
   </div>
</div>
<!-- </form> -->

<div id="generated-report-log-modal" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="view-hd">Generated Report Log</div>
            <div class="table-responsive">
               <table class="table table-striped">
                  <thead class="thead-bd-color">
                     <tr>
                        <th>Version</th>
                        <th>Generated By</th>
                        <th class="text-right">Download</th>  
                     </tr>
                  </thead>
                  <tbody class="tbody-datatable" id="get-generated-report-log-data"></tbody>
               </table>
            </div>
            <div class="container-fluid d-none">
               <div class="row mt-2">
                  <div class="col-md-9">
                     Download New Report
                  </div>
                  <div class="col-md-3 text-right" id="download-new-report-div-modal"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="<?php echo base_url() ?>assets/custom-js/admin/bgv-report/all-completed-case.js"></script>

<!-- <script src="<?php echo base_url() ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script> -->
<script>
  $("#content-5, #content-6").mCustomScrollbar({
    theme: "dark-thin"
  });

</script>