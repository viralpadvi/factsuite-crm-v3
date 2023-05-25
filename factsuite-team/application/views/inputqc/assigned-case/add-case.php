<!-- /**
 * Created 1-2-2021
 */ -->
<div class="pg-cnt">
     <div id="FS-candidate-cnt">
      <div id="FS-allcandidates">
        <!--Add Client Content-->
        <div class="add-client-bx">
           <h3>basic client details</h3>
           <?php foreach ($client as $key => $value) {
                // echo $client['0']['client_name']."\r\n";
           };?>
           <ul>
              <li>
                 <label>Client Name</label>
                 <select class="form-control fld" id="client_id" required="">
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
                 <label>Father Name</label>
                 <input type="text" class="form-control fld" id="father_name" required="">
                 <div id="client-address-error">&nbsp;</div>
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
                <label>Date Of Joining</label>
                <input type="text" class="fld form-control mdate" id="date_of_joining" name="date_of_joining" >
                <div id="date-of-joining-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Employee ID</label>
                 <input type="text"  class="form-control fld" id="employee_id">
                 <div id="employee-id-error">&nbsp;</div>
              </li>
              <li>
                 <label>Package Name</label>
                 <select class="form-control fld" id="package_id" required="">
                    
                 </select>
                 <!-- <input type="hidden" readonly="" class="form-control fld" id="package_id"> -->
                 <!-- <input type="text" readonly="" class="form-control fld" id="package_name"> -->
                 <div id="package-id-error">&nbsp;</div>
              </li> 

              <li>
                 <label>Remarks</label>
                 <input type="text" class="form-control fld" id="remarks">
                 <div id="remarks-error">&nbsp;</div>
              </li>
               
              <li>
                 <label>Documents upload by</label>
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
           </ul> 
        </div>
        
        <div class="add-team-bx">
          <h3>Components</h3>
          <ul > 
            <div class="row" id="components_ids">
              
            </div>
          </ul>
          <div id="vendor-skill-error-msg-div"></div>
          <div id="error-team"></div>
        </div>
        <div class="sbt-btns">
           <a href="#" onclick="GetSelected()" class="btn bg-gry btn-submit-cancel">CANCEL</a> 
           <button id="insert_data" onclick="save_case()" class="btn bg-blu btn-submit-cancel">SUBMIT &amp; SAVE</button> 
        </div>
        <!--Add Client Content-->
                
     </div>
  </div>
</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url();?>assets/custom-js/common/valid-invalid-input.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/inputqc/case/add-case.js"></script>