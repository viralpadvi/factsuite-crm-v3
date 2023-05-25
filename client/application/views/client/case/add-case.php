 
   <div class="pg-cnt">
      <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <div id="FS-allcandidates">             
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane active" id="Addnewcase">
                       <!-- <form action="#"> -->
                  <div class="add-client-bx">
                     <h3>Candidate Details</h3>
                     <ul>
                        <li>
                           <label>Title</label>
                           <select class="fld form-control" id="title">
                              <option value="Mr">Mr</option>
                              <option value="Mrs">Mrs</option>
                              <option value="Miss">Miss</option>
                           </select>
                           <div>&nbsp;</div>
                        </li>
                        <li>
                           <label>First Name <span>(Required)</span></label>
                           <input type="text" class="fld form-control" id="first-name" >
                           <div id="first-name-error">&nbsp;</div>
                        </li>
                        <li class="all-bx wdt-18">
                           <label>Last Name <span>(Required)</span></label>
                           <input type="text" class="fld form-control" id="last-name" >
                           <div id="last-name-error">&nbsp;</div>
                        </li>
                        <li class="all-bx wdt-18">
                           <label>Father's Name <span>(Required)</span></label>
                           <input type="email" class="fld form-control"  id="father-name">
                           <div id="father-name-error">&nbsp;</div>
                        </li>
                        <li class="all-bx wdt-18">
                           <label>Phone Number</label>
                           <input type="text" class="fld form-control" id="contact-no" >
                           <div id="contact-no-error">&nbsp;</div>
                        </li>
                        <li class="all-bx wdt-18">
                           <label>Email ID</label>
                           <input type="text" class="fld form-control" id="email-id" >
                           <div id="email-id-error">&nbsp;</div>
                        </li>
                        <li class="wdt-30 all-bx2">
                           <label>Date of Birth</label>
                           <input type="text" name="date" class="fld form-control dob-date " id="birth-date">
                           <div id="birth-date-error">&nbsp;</div>
                        </li>
                        <li class="wdt-30 all-bx2">
                           <label>Joining Date</label> 
                           <input type="text" name="date" class="fld form-control date-for-vendor-aggreement-end-date" id="joining-date">
                           <div id="joining-date-error">&nbsp;</div>                           
                        </li>
                        <li class="wdt-18 all-bx">
                           <label>Employee ID</label>
                           <input type="text" class="fld form-control" id="employee-id">
                           <div id="employee-id-error">&nbsp;</div>
                        </li>
                        <li class="all-bx wdt-18">
                           <label>Package</label>
                           <select class="fld form-control" id="package">
                              <option>Select Package</option>
                           </select>
                           <div id="package-error">&nbsp;</div>
                        </li>
                        <li class="all-bx wdt-18 d-none">
                           <label>Alacarte Components</label>
                           <select class="form-control fld" id="alacarte_components" required="">
                            <option value="">Select Component</option>
                               <?php
                                  $alacarte_data = json_decode($single_client['alacarte_components'],true); 
                                  foreach ($alacarte_data as $key => $value) { 
                                       echo "<option value='{$value['component_id']}'>{$value['component_name']}</option>"; 
                                  }
                                  ?>
                           </select>
                           <!-- <input type="hidden" readonly="" class="form-control fld" id="package_id"> -->
                           <!-- <input type="text" readonly="" class="form-control fld" id="package_name"> -->
                           <div id="alacarte_components-error">&nbsp;</div>
                        </li> 
                        <li class="all-bx wdt-30">
                           <label>Remarks</label>
                           <input type="text" class="fld form-control" id="remark">
                           <div id="remark-error">&nbsp;</div>
                        </li>
                        <li class="all-bx wdt-18">
                           <label>Documents upload by  <span>(Required)</span></label>
                           <select class="fld form-control" id="document-uploader">
                              <option value="">Select Uploader</option>
                              <option value="client">client</option>
                              <option value="candidate">candidate</option>
                           </select>
                           <div id="document-uploader-error">&nbsp;</div>
                        </li>
                        <li class="all-bx wdt-30" id="client-email-div" style="display: none;" >
                           <label>Client Email</label>
                           <input type="text" class="fld form-control" value="<?php echo $single_client['spoc_email_id']; ?>" id="client-email">
                           <div id="client-email-error">&nbsp;</div>
                       </li>
                     </ul>  
 

                 <div class="add-team-bx d-none">
                   <h3>Bulk Case</h3>
                   <input type="file" class="fld" name="excel_upload" id="add-bulk-upload-case">
                 </div>

                           <div class="checks">
                             <h3>Verification Components</h3>
                             <div class="custom-control custom-checkbox custom-control-inline mrg">
                                <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll">
                                <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
                             </div>
                              
                             <div class="full-bx row" id="case-skills-list"> 
                             </div>

                             <div class="mt-2">
                              <h3>Alacarte Components</h3>
                            </div>
                             <div class="full-bx row" id="alacarte_components_ids">
                              
                            </div>

                          </div>
                          <div id="error-client"></div>
                           <div id="submit-button" class="sbt-btns">
                              <button type="button" onclick="import_excel()" class="btn bg-blu text-white d-none">Excel Data Submit</button> 
                              <button id="insert_data" onclick="add_case()" class="btn bg-blu text-white">Submit</button>
                           </div>

                       </div>
                       <!-- </form> -->
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Addbulkcase">
                       <!-- <form action="#"> -->
                       <div class="allcandidates-bx">
                          <p>
                             Hi, <br>
                             We support bulk uploading candidate/cases when they are uploaded through a specific Excel Format.
                             We recommend you downloading the Excel Sample by clicking the Download Sample button. Once downloaded, 
                             we recommend you filling the specific columns in the mentioned manner. <br><br>
                             Notes: <br>
                             1. We only support excel sheets on the above mentioned format. <br>
                             2. Columns like "Candidate First Name", "Candidate Last Name", "Date Of Birth", "Father's Name", Phone number are required. <br>
                             3. Please make sure you enter the Date of Birth and Date of joining in the specific format. <br>
                             4. For the checks you want to verify, you will have to type "YES" manually against those columns. Other checks will not be verified.
                          </p>
                          <div class="full-bx">
                              <a href="File Path" download="File Name"><button class="dwd-btn"><i class="fa fa-arrow-down"></i> Download Sample</button></a>
                                <div class="form-group wdt-40">
                                   <input type="file" id="file1" />
                                   <label class="btn upload-btn" for="file1"><a>Upload</a></label>
                                   <div class="file-name1"></div>
                                </div>
                                <div id="excel-error-msg-div">&nbsp;</div>
                                <!--<div class="form-group wdt-40">
                                   <label class="btn upload-btn" for="file1"><a>Upload</a></label>
                                   <input id="file1" type="file" style="display:none;" class="form-control">
                                   <div class="file-name1"></div>
                                </div>-->
                                <button onclick="import_excel()" id="import_excel_file" class="sbt-btn">Submit</button>
                          </div>
                       </div>
                       <!-- </form> -->
                    </div>
                 </div>
                 <!--All Candidates Content-->
              </div>
     </div>
   </div>
</section>
<!--Content-->


<div id="requiest_more_form" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="raise-issue-txt">
               <h3>Request Component More Form</h3> 
            </div>
            <div class="row mt-1">
              <div class="col-md-5">
                <label>Component Name :</label> 
              </div>
              <div class="col-md-7">
                <input type="hidden" name="request_comonent_id" id="request_comonent_id">
                 <span class="font-weight-bold" id="request_component_name">Criminal Status</span>
              </div>

               <div class="col-md-5 mt-1">
                <label>Form Up To :</label> 
              </div>
              <div class="col-md-7 mt-1">
                <input type="text" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  name="request_number_of_form" id="request_number_of_form" placeholder="Up to" > 
              </div>
            </div>
            <div class="row mt-1 text-right float-right">  
               <button type="button" class="btn btn-secondary btn-md mr-1" data-dismiss="modal">Close</button> 
               <div class="send-bx">
                  <button class="btn bg-blu btn-submit-cancel" id="request_form_submit">Submit</button>
               </div>
            </div>
            <!-- <div class="sbt-btns" id="form-button-area">
              <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a> 
              <button onclick="save_client()" id="client-submit-btn" class="btn bg-blu btn-submit-cancel">SAVE &amp; NEXT</button>
            </div> -->
         </div>
      </div>
   </div>
</div>
<script>
   var component_config_name = "<?php echo $this->config->item('show_component_name'); ?>";
</script>
<script src="<?php echo base_url() ?>assets/custom-js/case/add-case.js"></script>