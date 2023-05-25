
    <div class="pg-cnt">
        <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst"> 
            <h3>Priority Cases Components</h3>
            <div class="row my-3">
                <div class="col-md-2">
                   <select class="w-50" id="filter-cases-number"></select>
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-3">
                   <input class="form-control custom-iput-1" id="filter-input" type="text" placeholder="Search">
                </div>
                <div class="col-md-2">
                   <button class="send-btn mt-0 mr-0 btn-filter-search" id="all-case-filter-btn" onclick="get_all_cases('filter_input')">Search</button>
                </div>
             </div>
            <div class="table-responsive mt-3">
                <table class="table-fixed table table-striped">
                    <thead class="table-fixed-thead thead-bd-color">
                        <tr>
                        <th>Sr No.</th>
                        <th>Case Id</th>
                        <th>Component Name</th>
                        <th>Candidate Name</th>
                        <th>Client Name</th>
                        <th>Phone Number</th>
                        <th>Verification Status</th>
                        <th>View Details</th>
                      </tr>
                    </thead>
                    <tbody class="table-fixed-tbody tbody-datatable" id="get-priority-cases"></tbody>
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
 <div id="modalapprov" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
              <h3 class="snd-mail-pop">Approve</h3>
              <h4 id="componentNameApprove" class="pa-pop">Raise Insufficiency</h4>
              <textarea id="approve-comment" placeholder="Comment" class="message mt-1"></textarea>

              <div class="form-group w-100 mt-3">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
              </div>
              <!-- <h4>Do you want to Confirm?</h4> -->
              <div id="btnApproveDiv">
                    
              </div>
              <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>
 <div id="modal-stopcheck" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
              <h3 class="snd-mail-pop">Stop check</h3>
              <h4 id="componentNameApprove" class="pa-pop">Are you sure you want to <b>stop check</b>?</h4>
              <!-- <textarea id="approve-comment" placeholder="Comment" class="message mt-1"></textarea>

              <div class="form-group w-100 mt-3">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
              </div> -->
              <!-- <h4>Do you want to Confirm?</h4> -->
              <div id="btnStopCheckDiv">
                    
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
            <!--  <h3 class="snd-mail-pop">Send Mail <img src="<?php echo base_url()?>assets/admin/images/email_open_100px.png" alt=""> </h3> -->
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID : 1245DGT</p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">From : analyst@factsuite.com</p>
                 </div>
             </div>
             <textarea class="message">Message...</textarea>
           <!--   <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" multiple type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div> -->
            <div id="fls" class="form-group w-100 mt-2">
                  <div class="form-group files">
                     <label class="upload-btn-pop" for="file1"><a class="fl-btn">UPLOAD DOCUMENT</a></label>

                     <input id="file1" type="file" style="display:none;" 
                            class="form-control fl-btn-n" multiple 
                            accept="image/jpg,image/png,image/jpeg,application/pdf" >

                     <div id="file_list_1" class="pa-pop">
                       
                     </div>

                  </div>
               </div> 
               <span id="valid_files" class="d-none text-suceess">Valid File List</span>
               <div id="valid-document">
                 
               </div>
               <span id="invalid_files" class="d-none text-danger">Invalid File List</span>
               <div id="document-error">
                 
               </div>
            <div id="btnInsuffiDiv">
                  
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
            <h4>Do you want to Confirm?</h4>
            <div id="btnInsuffiDiv">
                  
            </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

 <div id="modalPending" class="modal fade">
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


<script src="<?php echo base_url() ?>assets/custom-js/analyst/assigned-case/view-all-cases.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/assigned-case/view-priority-cases.js"></script>

<script src="<?php echo base_url() ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script>

  loadAllAssignedCases('<?php echo $sessionData['team_id'];?>')
  
  $("#content-5, #content-6").mCustomScrollbar({
    theme: "dark-thin"
  });

</script>

<!-- view-all-qc-error-component -->


<!-- priority_confirm_dailog -->
 <div id="override_confirm_dailog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
            <!-- <h3 class="snd-mail-pop">Override Assingment</h3> -->
            <!-- <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4> -->
            <h4>Do you want to override the Status?</h4>
            <div id="btnOverrideDiv">
              
            </div>
            <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

