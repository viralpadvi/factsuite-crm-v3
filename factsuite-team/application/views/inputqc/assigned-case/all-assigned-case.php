
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.min.css">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt"> 
        <h3>View All Assigned Cases</h3>
          <div class="table-responsive mt-3" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th class="d-none">Sr No.</th> 
                <th>Case Id</th> 
                <th>Candidate Name</th> 
                <th>Client Name</th> 
                <th>Package Name</th> 
                <th>Phone Number</th>  
                <th>Login Id</th> 
                <th>OTP</th> 
                <th>Case Priority</th> 
                <th>Case Status</th> 
                <!-- <th>View Progress</th> -->
                <th>Case Start Date</th>
                   <th>Case Completed Date</th>
                   <!-- <th>Total TAT days</th> -->
                   <th>Actual TAT Days</th>
                <th>View Details</th>    
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data-1">
            <?php  
            $holidays = $this->db->get('tat_holidays')->result_array();
            $holiday = array();
            if (count($holidays)) {
               foreach ($holidays as $key => $val) {
                  array_push($holiday,$val['holiday_date']);
               }
            }
                  if (count($case) > 0 ) {
                    foreach ($case as $key => $value) {

                            $status = ''; 
                        $classStatus = ''; 
                        $fontAwsom='';
            if ($value['candidate']['is_submitted'] == '0') {
                // $status = 'Pending 
                $classStatus = 'pending';
                $fontAwsom = '<i class="fa fa-check">';
                $status = '<span class="text-warning">Not Initiated</span> ';
            }else if ($value['candidate']['is_submitted'] == '1') {
                // $status = 'Pending 
                // $classStatus = 'pending'
                $fontAwsom = '<i class="fa fa-check">';
                $status = '<span class="text-info">In Progress</span> ';
            }else if ($value['candidate']['is_submitted'] == '2') {
                // $status = 'Pending 
                // $classStatus = 'pending'
                $fontAwsom = '<i class="fa fa-check">';
                $status = '<span class="text-success">Completed</span>'; 
            }else{
                // $status = 'Completed 
                $classStatus = 'pending';
                $fontAwsom = '<i class="fa fa-check">';
                $status = '<span class="text-warning">Pending</span>'; 
            }


             $priority = '';
            $priorityClass = '';
            $PrioritySelected = '';
            $lowPrioritySelected = '';
            $midPrioritySelected = '';
            $highPrioritySelected = '';

            if($value['candidate']['priority'] == '0'){
                $PrioritySelected = 'Low';
                $priorityClass = 'text-info font-weight-bold';
                    // lowPrioritySelected = 'selected'
            }else if($value['candidate']['priority'] == '1'){  
                $PrioritySelected = 'Medium';
                $priorityClass = 'text-warning font-weight-bold';
                    // midPrioritySelected = 'selected'
            }else if($value['candidate']['priority'] == '2'){  
                $PrioritySelected = 'High';
                $priorityClass = 'text-danger font-weight-bold';
                    // highPrioritySelected = 'selected'
            }
            $days = 0;
            if ($value['candidate']['tat_end_date'] !='' && $value['candidate']['tat_end_date'] !=null && $value['candidate']['tat_start_date'] !='' && $value['candidate']['tat_start_date'] !=null ) {
              $days = (int)$this->utilModel->getWorkingDays($value['candidate']['tat_start_date'],$value['candidate']['tat_end_date'],$holiday);
            }


            $tat_end_date_1 ='';
           if($value['candidate']['tat_start_date'] != null) {
               $tat_start_date= explode(' ',$value['candidate']['tat_start_date'])[0];
               $tat_start_date= $tat_start_date;
               if($value['candidate']['tat_end_date'] != null && $value['candidate']['tat_end_date'] != '') {
                   $tat_end_date= explode(' ',$value['candidate']['tat_end_date'])[0];
                   $tat_end_date_1 = explode(' ',$value['candidate']['tat_end_date'])[0];
                   $tat_end_date= $tat_end_date;
               } else {
                   // var tat_end_date = getEndDate(tat_start_date,tat_days);
                   $days = (int)$this->utilModel->getWorkingDays($value['candidate']['tat_start_date'],$value['candidate']['tat_end_date'],$holiday);

               }
               $todayDate = date('Y-m-d');
           } else {
               $tat_start_date = '-';
               $tat_end_date = '-';
           }
           $report_generated = isset($value['candidate']['report_generated_date'])?$value['candidate']['report_generated_date']:'';
           $report_generated_date = '';
           if ($report_generated !='' && $report_generated !=null) {
              $report_generated_date = $this->utilModel->get_actual_date_formate($report_generated);
           }

           $case_submitted = isset($value['candidate']['case_submitted_date'])?$value['candidate']['case_submitted_date']:$value['candidate']['tat_start_date'];
           $case_submitted_date = '';
           if ($case_submitted !='' && $case_submitted !=null) {
              $case_submitted_date = $this->utilModel->get_actual_date_formate($case_submitted);
           }

             $priority = '<span class="'.$priorityClass.'">'.$PrioritySelected.'<span>';
                       ?> 
            <tr id="tr_<?php echo $value['candidate']['candidate_id']; ?>">   
            <td class="d-none"></td>
            <td id="first_name<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['candidate_id']; ?></td> 
            <td id="first_name<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['first_name']; ?> </td> 
            <td id="client_name_<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['client_name']; ?></td> 
            <td id="package_name<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['package_name']; ?></td>
            <td id="phone_number<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['phone_number']; ?></td>
            <td id="login_id<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['loginId']; ?></td> 
            <td id="otp<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['otp_password']; ?></td> 

            <td id="status<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $priority; ?></td>
            <td id="status<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $status; ?></td> 
            <td id="email_id<?php echo $value['candidate']['tat_start_date']; ?>"><?php echo $case_submitted_date; ?></td> 
            <td id="email_id<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $report_generated_date; ?></td>  
            <td id="email_id<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['left_tat_days']; ?></td>  

            <td class="text-center">
               <a target="_blank" class="ml-3" href="<?php echo $this->config->item('my_base_url');?>factsuite-inputqc/re-edit-case/<?php echo $value['candidate']['candidate_id']; ?>"><i class="fa fa-pencil"></i></a>

               <a href="<?php echo $this->config->item('my_base_url'); ?>factsuite-inputqc/assigned-view-case-detail/<?php echo $value['candidate']['candidate_id']; ?>" ><i class="fa fa-eye"></i></a>
               <?php if ($value['candidate']['is_submitted'] != 2 && $value['candidate']['is_submitted'] != 1 && strtolower($value['candidate']['document_uploaded_by']) == 'inputqc') { ?>
                  <a target="_blank" class="ml-3" href="<?php echo $this->config->item('my_base_url');?>factsuite-inputqc/resume-case/<?php echo $value['candidate']['candidate_id']; ?>"><i class="fa fa-wpforms"></i></a>
                  
               <?php } ?>
            </td>
           </tr> 
                       <?php 
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
                        Case Start Date <span id="case-date">12 Feb 2020</span>
                     </li>
                     <li  class="view-status">
                       Verification Status <span id="case-status">On Progress</span>
                     </li>
                     <li class="view-days">
                       TAT Ends In:   3
                     </li>
                     <li class="view-deadline">
                       TAT DeadLine <span id="case-end-date">18 Feb 2020</span>
                     </li>
                  </ul>
                  <div class="clr"></div>
               </div>
               <div class="view-bx">
                  <!-- <div class="view-bx-txt  d-none"><span>3</span> of <span>8</span> Milestone Completed</div> -->
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
                        <h5>Case ID:<span id="candidate-id"></span></h5>
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



<script src="<?php echo base_url() ?>assets/custom-js/inputqc/assigned-case/view-all-cases.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
  $("#content-5, #content-6").mCustomScrollbar({
    theme: "dark-thin"
  });

</script>