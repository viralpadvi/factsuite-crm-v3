<!-- /**
 * Created 1-2-2021
 */ -->
 
<style type="text/css">
   #select2-country-code-container {
      height: 40px;
      padding-top: 4px;
   }
</style>
<div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
      <div id="FS-allcandidates">
        <!--Add Client Content-->
        <div class="add-client-bx">
           <h3>Candidate details</h3>
           <?php foreach ($client as $key => $value) {
                // echo $client['0']['client_name']."\r\n";
           };?>
           <ul>
              <li>
                 <label>Client Name</label>
                 <select class="form-control fld select2" id="client_id" required="">
                    <option value="0">Select Client Name</option>
                    <?php
                      if (count($client) > 0) {
                        foreach ($client as $key => $value) { ?>
                           <!-- echo "<option value='{$value[0]['client_id']}'>{$value[0]['client_name']}</option>"; -->
                           <option value="<?php echo $value['client_id']?>"><?php echo $value['client_name']?></option>
                      <?php  }
                      }
                    ?>
                 </select>
                 <div id="client-id-error">&nbsp;</div>
              </li>
              <li>
                 <label>Title</label>
                 <select class="form-control fld" id="title">
                    <option value="">Select Title</option>
                    <option value="mr">Mr</option>
                    <option value="miss">Miss</option>
                    <option value="mrs">Mrs</option>
                 </select>
                 <div id="title-error">&nbsp;</div>
              </li>
              <li>
                 <label>First Name</label>
                 <input type="text" class="form-control fld" id="first_name" required="">
                 <div id="first_name_error">&nbsp;</div>
              </li>
              <li>
                 <label>Last Name</label>
                 <input type="text" class="form-control fld" id="last_name">
                 <div id="client-address-error">&nbsp;</div>
              </li>
              <li>
                 <label>Father's Name</label>
                 <input type="text" class="form-control fld" id="father_name" required="">
                 <div id="client-address-error">&nbsp;</div>
              </li>
              <li style="width: 10%;">
                  <label>Country Code</label>
                  <select class="form-control fld select2" id="country-code"></select>
                  <div id="country-code-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="number" class="form-control fld" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="phone_number" required="">
                 <div id="contact-no-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email Id</label>
                 <input type="text" class="form-control fld" id="email_id">
                 <div id="email-id-error">&nbsp;</div>
              </li>
              <li>
                <label>Date Of Birth</label>
                <input type="text" class="fld form-control dob-date" id="date_of_birth" name="date_of_birth">
                <div id="date-of-birth-error-msg-div">&nbsp;</div>
              </li>
              <li>
                <label>Joining Date</label>
                <input type="text" class="fld form-control mdate" id="date_of_joining" name="date_of_joining" >
                <div id="date-of-joining-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Employee ID</label>
                 <input type="text"  class="form-control fld" id="employee_id">
                 <div id="employee-id-error">&nbsp;</div>
              </li>
              <li>
                 <label>BGV Package Name</label>
                 <select class="form-control fld" id="package_id" required="">
                    
                 </select>
                 <!-- <input type="hidden" readonly="" class="form-control fld" id="package_id"> -->
                 <!-- <input type="text" readonly="" class="form-control fld" id="package_name"> -->
                 <div id="package-id-error">&nbsp;</div>
              </li>
               <li>
                 <label>Segment</label>
                 <select class="form-control fld" id="segment" required="">
                    <option value="">Select Segment</option>
                    <?php 
                      foreach ($segment as $key => $value) {
                       echo "<option value='".$value['id']."'>".$value['name']."</option>";
                      }
                    ?>
                 </select> 
                 <div id="segment-error">&nbsp;</div>
              </li> 
              <li>
                 <label>Cost Center</label>
                 <select class="form-control fld" id="cost-center">
                     <option value="">Cost Center</option>
                 </select> 
                 <div id="cost-center-error">&nbsp;</div>
              </li> 
              <li class="d-none">
                 <label>Alacarte Name</label>
                 <select class="form-control fld" id="alacarte_components" required="">
                    
                 </select>
                 <!-- <input type="hidden" readonly="" class="form-control fld" id="package_id"> -->
                 <!-- <input type="text" readonly="" class="form-control fld" id="package_name"> -->
                 <div id="alacarte_components-error">&nbsp;</div>
              </li> 

              <li>
                 <label>Remarks</label>
                 <input type="text" class="form-control fld" id="remarks">
                 <div id="remarks-error">&nbsp;</div>
              </li>
               
              <li>
                 <label>Documents uploaded by</label>
                 <select class="form-control fld" id="document_uploaded_by" required=""> 
                    <option value="candidate">Candidate</option>
                    <option value="inputqc">InputQC</option> 
                     
                 </select>
                 <div id="document-uploaded-by-error">&nbsp;</div>

                 
              </li>
              <li id="document_uploded_by_inputqc">
                 <label>InputQc Email Id</label>
                 <input type="text" class="fld form-control fld" id="document_uploded_by_email_id">
                 <div id="inputqc-email-error">&nbsp;</div>
              </li>
              <li>
                <label>Case Priority</label>
                <select class="fld form-control fld" id="priority">
                    <option value="3">Select Priority</option>
                    <option value="2" >High Priority</option>
                    <option value="1" >Medium Priority</option>
                    <option value="0" >Low Priority</option>
                </select>  
                <div id="priority-error">&nbsp;</div>
              </li>
              <li>
                <label>Assign InputQC</label>
                <select class="fld form-control fld" id="inputqc-name">
                    <?php 
                    if (count($inputqc) > 0) {
                       foreach ($inputqc as $key => $val) {
                          echo "<option value='{$val['team_id']}'>{$val['first_name']}</option>";
                       }
                    }
                    ?>
                </select>  
                <div id="inputqc-name-error">&nbsp;</div>
              </li>
           </ul> 
        </div>

        <div class="add-team-bx d-none">
          <h3>Bulk Case</h3>
          <input type="file" class="fld" name="excel_upload" id="add-bulk-upload-case">
        </div>

        <div class="add-team-bx">
          <!-- <h3>Components</h3> -->
           <h3>Components List</h3>
               <div class="custom-control custom-checkbox custom-control-inline mrg">
                  <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll">
                  <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
               </div>
          <ul > 
            <div class="row" id="components_ids">
              
            </div>
            <div class="mt-2">
              <h3>Alacarte Components</h3>
            </div>
             <div class="row" id="alacarte_components_ids">
              
            </div>
          </ul>
          <div id="vendor-skill-error-msg-div"></div>
          <div id="error-team"></div>
        </div>
        <div id="submit-button" class="sbt-btns">
            
          <button type="button" onclick="import_excel()" class="btn bg-blu text-white d-none">Excel Data Submit</button> 
          <button id="insert_data" onclick="save_case()" class="btn bg-blu text-white">SUBMIT &amp; SAVE</button>
          <div>
            <span id="wait-message"></span>
          </div>
           <!-- <button id="insert_data" onclick="save_case()" class="btn bg-blu btn-submit-cancel"></button>  -->
        </div>
        <!--Add Client Content-->
                
     </div>
  </div>
</section>
<!--Content-->

<div class="modal fade custom-modal add-new-case" id="add-new-case-v2-confirm">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal">X</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-0">
        <div class="row add-new-case-steps-tabs-div">
           <h4 class="modal-title m-2" id="msg-for-the-warning">A case already exists with the entered email ID you have entered.Do you want to create a duplicate?</h4>
         </div>
       </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn bg-blu text-white" data-dismiss="modal" >No</button>
        <button class="btn bg-blu text-white" data-dismiss="modal" id="edit-case-btn-v2-confirm">Yes</button>
      </div>

    </div>
  </div>
</div>


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
              <!-- <div class="send-bx"><button type="button" onclick="import_excel()" class="btn bg-blu text-white">Excel Data Submit</button> </div> -->
              <div class="send-bx"><button class="btn bg-blu text-white" id="request_form_submit">Submit</button></div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var component_config_name = "<?php echo $this->config->item('show_component_name'); ?>";
</script>
<!-- custom-js -->
<script src="<?php echo base_url();?>assets/custom-js/common/valid-invalid-input.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/inputqc/case/new-add-case.js"></script>
