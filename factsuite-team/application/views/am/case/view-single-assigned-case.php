
  <div class="pg-cnt">
     <div id="FS-candidate-cnt">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/view-all-case-list" ><span class="text-white">Back</span></a>

          <div class="row mt-4">
            <div class="col-md-12">
              <label class="font-weight-bold">Case ID: </label>&nbsp;<span id="caseId">2</span>
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-6">
              <label class="font-weight-bold">Candidate Name: </label>&nbsp;<span id="candidateName">YashPanchal</span>
            </div>
            <div class="col-md-6">
              <label class="font-weight-bold">Client Name: </label>&nbsp;<span id="clientName">Hindustan Unilever Ltd</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label class="font-weight-bold">Phone Number: </label>&nbsp;<span id="camdidatephoneNumber">1234567890</span>
            </div>
            <div class="col-md-6">
              <label class="font-weight-bold">Package Name: </label>&nbsp;<span id="packageName">Hindustan</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label class="font-weight-bold">Email Id: </label>&nbsp;<span id="camdidateEmailId">abc@gmail.com</span>
            </div>
            <div class="col-md-6">
              <label class="font-weight-bold">DOB(Date Of Birth): </label>&nbsp;<span id="camdidateDob">abc@gmail.com</span>
            </div>
          </div>
          <div class="row">
            <div id="priority-div" class="col-md-4">
               <!-- priority dropdown in JS -->
            </div> 
            <div class="col-md-4">
                <label class="font-weight-bold">LOA &nbsp;&nbsp;&nbsp;<a target="_blank" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/candidate-loa-pdf/'.md5($candidate_id); ?>"><i class="fa fa-file-pdf-o"></i></a></label>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-12" id="personal_docuemnts_div">
               <button id="view_personal_docuemnts" class="btn bg-blu text-white float-right d-none">View Docuemnts</button>
            </div>
            
          </div>
          <div class="table-responsive mt-3" id="">
          <table class="table table-striped">
            <thead class="thead-bd-color">
             <tr>
                <th>Sr No.</th> 
                <th>Component</th>  
                <th>View Details</th>
                <?php $for_next_release = 0;
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
            <tbody class="tbody-datatable" id="get-case-data"> 
            </tbody>
          </table>
        </div>
     </div>
  </div>
</section>
<!--Content-->


<!-- Popup Content -->
<form>
<div id="sendMail" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Send Mail <img src="<?php echo base_url()?>assets/admin/images/email_open_100px.png" alt=""> </h3>
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID : 1245DGT</p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">From : analyst@factsuite.com</p>
                 </div>
             </div>
             <textarea class="message">Message...</textarea>
             <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Send</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
</div>
</form>
<!-- Popup Content -->

<!-- <div id="modalPending" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Send Mail <img src="<?php echo base_url()?>assets/admin/images/email_open_100px.png" alt=""> </h3>
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID : 1245DGT</p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">From : analyst@factsuite.com</p>
                 </div>
             </div>
             <textarea class="message">Message...</textarea>
             <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Cancle</button>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Confirm</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div> -->

 <div id="priority_confirm_dailog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <h3 class="snd-mail-pop">Priority Change</h3>
            <!-- <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4> -->
            <h4>Are you confirm?</h4>
            <div id="btnPriorityDiv">
                  
            </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

 <div id="modalInsuffi" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <h3 class="snd-mail-pop">Raise Insufficiency</h3>
            <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4>
            <h4>Are you confirm?</h4>
            <div id="btnInsuffiDiv">
                  
            </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

 <div id="modalapprov" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
              <h3 class="snd-mail-pop">Approve</h3>
              <h4 id="componentNameApprove" class="pa-pop">Raise Insufficiency</h4>
              <!-- <textarea id="approve-comment" placeholder="Comment" class="message mt-1"></textarea>

              <div class="form-group w-100 mt-3">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
              </div> -->
              <h4>Are you confirm?</h4>
              <div id="btnApproveDiv">
                    
              </div>
              <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>
  <!-- Delete Testimonials Modal Starts -->
  <div class="modal fade" id="edit-team-view">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div id="FS-candidate-cnt">
      
      
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Modal Ends -->

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

 


<div class="modal fade" id="view_image_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
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
        <div class="modal-footer border-0"></div>
      </div>
    </div>
</div>


<script src="<?php echo base_url() ?>assets/custom-js/am/view-single-case.js"></script>
<script>
 load_case(<?php echo $candidate_id;?>); 
</script>