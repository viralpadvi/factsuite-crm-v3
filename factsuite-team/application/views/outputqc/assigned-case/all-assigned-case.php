
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.min.css">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst"> 
        <h3>View All Cases</h3>
          <div class="table-responsive mt-3" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <!-- <th class="d-none">Sr No.</th>  -->
                <th>Case Id</th> 
                <th>Candidate Name</th> 
                <th>Client Name</th> 
                <!-- <th>Package Name</th> 
                <th>Phone Number</th>   -->
                <th>Email Id</th> 
                <th>Varification Status</th> 
                <!-- <th>View Progress</th> -->
                <th>TAT Start Date</th>
                   <th>TAT End Date</th>
                   <!-- <th>Total TAT days</th> -->
                   <th>Actual TAT Days</th>
                <th>View Details</th>   
                <!-- <th>Report Genration</th> -->
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data-1">  
               <?php 
                  if (count($case) > 0 ) {
                    foreach ($case as $key => $value) {

                     $data['candidate_status'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($value['candidate']['candidate_id']);
                     // echo json_encode($data['candidate_status']);
                     $flag =0;
                     $flag1 =0;
                     $positive_status = array('4','5','6','7','9');
                     foreach ($data['candidate_status'] as $key2 => $val) {
                        if ($val['output_status'] =='2') {
                          $flag =1;
                        } 
                        if (!in_array($val['analyst_status'], $positive_status)) {
                          $flag1 =1;
                        }
                     }
                     if (in_array($value['candidate']['is_submitted'], ['1']) && $flag !=1 && $flag1 !=1) { 
                         $status = '';
                         $classStatus = '';
                         $fontAwsom='';
                     if ($value['candidate']['is_submitted'] == '0') { 
                            $classStatus = 'pending';
                            $fontAwsom = '<i class="fa fa-check">';
                        $status = '<span class="text-warning">Pending</span>';
                     }else if ($value['candidate']['is_submitted'] == '1') { 
                            $fontAwsom = '<i class="fa fa-check">';
                            $status = '<span class="text-info">Verified by Analyst / Specialist</span>';
                        }else if ($value['candidate']['is_submitted'] == '2') { 
                            $fontAwsom = '<i class="fa fa-check">';
                            $status = '<span class="text-success">Completed</span>';
                        }else{ 
                            $classStatus = 'pending';
                            $fontAwsom = '<i class="fa fa-check">';
                            $status = '<span class="text-warning">Pending</span>';
                        }
                       ?> 
            <tr id="tr_<?php echo $value['candidate']['candidate_id']; ?>">   
             <td id="first_name<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['candidate_id']; ?></td> 
             <td id="first_name<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['first_name']; ?> </td> 
             <td id="client_name_<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['client_name']; ?></td> 
             <td id="email_id<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['candidate']['email_id']; ?></td> 

                <td id="status<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $status; ?></td>

                <td id="email_id<?php echo $value['candidate']['tat_start_date']; ?>"><?php echo (isset($value['candidate']['tat_start_date']) && $value['candidate']['tat_start_date'] != '') ? date($selected_datetime_format['php_code'],strtotime($value['candidate']['tat_start_date'])) : '-'; ?></td>
                  <td id="email_id<?php echo $value['candidate']['candidate_id']; ?>"><?php echo (isset($value['candidate']['tat_end_date']) && $value['candidate']['tat_end_date'] != '') ? date($selected_datetime_format['php_code'],strtotime($value['candidate']['tat_end_date'])) : '-'; ?> </td>  
                  <td id="email_id<?php echo $value['candidate']['candidate_id']; ?>"><?php echo $value['left_tat_days']; ?></td> 

               <td class="text-center"><a href="<?php echo $this->config->item('my_base_url'); ?>factsuite-outputqc/assigned-view-case-detail/<?php echo $value['candidate']['candidate_id']; ?>" ><i class="fa fa-eye"></i></a></div></td>
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



<script src="<?php echo base_url() ?>assets/custom-js/outputqc/assigned-case/view-all-cases.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
  $("#content-5, #content-6").mCustomScrollbar({
    theme: "dark-thin"
  });

</script>