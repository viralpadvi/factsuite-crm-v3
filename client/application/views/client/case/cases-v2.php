<?php 
  $status_width = '16%';
  $sr_no_width = '4%';
  $candidate_name_width = '9%';
  $package_name_width = '10%';
  $employee_id_width = '7%';
  $tat_start_date_width = '7%';
  $tat_end_date_width = '7%';
  $tat_days_width = '5%';
  $actions_width = '20%';
  $candidate_login_id_width = '10%';
?>
<script>
  var status_width = '<?php echo $status_width;?>',
    sr_no_width = '<?php echo $sr_no_width;?>',
    candidate_name_width = '<?php echo $candidate_name_width;?>',
    package_name_width = '<?php echo $package_name_width;?>',
    employee_id_width = '<?php echo $employee_id_width;?>',
    tat_start_date_width = '<?php echo $tat_start_date_width;?>',
    tat_end_date_width = '<?php echo $tat_end_date_width;?>',
    tat_days_width = '<?php echo $tat_days_width;?>',
    actions_width = '<?php echo $actions_width;?>',
    candidate_login_id_width = '<?php echo $candidate_login_id_width;?>';
</script>

<h1 class="m-0 text-dark">All Cases</h1>
          </div>
          <div class="col-sm-9 text-right">
            <button type="button" class="btn custom-btn-1" data-toggle="modal" onclick="get_download()"><i class="fa fa-download"></i> Download Report</button>
            <button type="button" class="btn custom-btn-1" data-toggle="modal" data-target="#add-new-case-v2"><i class="fa fa-plus"></i> Add New Case</button>
            <button type="button" class="btn btn-transperant" data-toggle="modal" data-target="#add-bulk-case"><i class="fa fa-plus"></i> Add Bulk Cases</button>
            <button type="button" class="btn btn-transperant" id="view-bulk-case-btn"><i class="fa fa-eye"></i> View Bulk Cases</button>
          </div>
        </div>
      </div>
    </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section class="col-lg-12">
          <div class="card kpi-div">
            <div class="card-body">
              <div class="tab-content p-0">
                <?php $this->load->view('client/pagination/search-bar-and-filter-dropdown-hdr');?>
                <div class="table-responsive" id="view-all-cases"></div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>

<div class="modal fade custom-modal" id="add-new-case">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Case</h4>
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div class="row">
         <div class="col-md-1">
          <!-- <span class="input-field-txt">Title*</span> -->
          <div class="input-wrap">
            <select class="input-field" id="title">
              <option value="Mr">Mr</option>
              <option value="Mrs">Mrs</option>
              <option value="Miss">Miss</option>
            </select>
          </div>
         </div>
         <div class="col-md-4">
          <div class="input-wrap">
            <span class="input-field-txt">Enter First Name*</span>
            <input type="text" class="input-field" id="first-name">
          </div>
          <div id="first-name-error">&nbsp;</div>
         </div>
         <div class="col-md-4">
          <span class="input-field-txt">Enter Last Name*</span>
          <input type="text" class="input-field" id="last-name">
          <div id="last-name-error">&nbsp;</div>
         </div>
         <div class="col-md-3">
          <span class="input-field-txt">Enter Fathers Name*</span>
          <input type="text" class="input-field" id="father-name">
          <div id="father-name-error">&nbsp;</div>
         </div>
         <div class="col-md-4">
          <span class="input-field-txt">Enter Email ID*</span>
          <input type="text" class="input-field" id="email-id">
          <div id="email-id-error">&nbsp;</div>
         </div>
         <div class="col-md-4">
          <span class="input-field-txt">Enter Phone Number*</span>
          <input type="text" class="input-field" id="contact-no">
          <div id="contact-no-error">&nbsp;</div>
         </div>
         <div class="col-md-4">
          <span class="input-field-txt">Enter DOB*</span>
          <input type="text" class="input-field dob-date" name="date" id="birth-date">
          <div id="birth-date-error">&nbsp;</div>
         </div>
         <div class="col-md-4">
          <span class="input-field-txt">Joining Date</span>
          <input type="text" class="input-field date-for-vendor-aggreement-end-date" name="date">
          <div id="joining-date-error">&nbsp;</div>
         </div>
         <div class="col-md-4">
          <span class="input-field-txt">Employee ID</span>
          <input type="text" class="input-field" id="employee-id"0>
          <div id="employee-id-error">&nbsp;</div>
         </div>
         <div class="col-md-4">
          <span class="input-field-txt">Select Package*</span>
          <select class="input-field" id="package">
            <option>Select Package</option>
          </select>
          <div id="package-error">&nbsp;</div>
         </div>
         
         <div class="col-md-4">
          <span class="input-field-txt">Documents upload by*</span>
          <select class="input-field" id="document-uploader">
            <option value="">Select Uploader</option>
            <option value="client">client</option>
            <option value="candidate">candidate</option>
          </select>
          <div id="document-uploader-error">&nbsp;</div>
         </div>

          <div class="col-md-4">
          <span class="input-field-txt">Remarks</span>
          <input type="text" class="input-field" id="remark">
          <div id="remark-error">&nbsp;</div>
         </div> 
         <div class="col-md-4" id="client-email-div" style="display: none;">
          <span class="input-field-txt">Client Email*</span>
          <input type="text" class="input-field" value="<?php echo $single_client['spoc_email_id']; ?>" id="client-email">
          <div id="client-email-error">&nbsp;</div>
         </div>
         <div class="col-md-12">
            <span class="verification-components-txt">Verification Components</span>
            <div class="custom-control custom-checkbox custom-control-inline mrg">
              <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll" spellcheck="true">
              <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
            </div>
            <div class="row" id="case-skills-list"></div>
         </div>
       </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-submit" id="insert_data" onclick="add_case()">Submit</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade custom-modal add-new-case" id="add-new-case-v2">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Case</h4>
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-0">
        <div class="row add-new-case-steps-tabs-div">
          <div class="col-md-4 pr-0">
            <span id="add-new-case-step-1" class="active">1. Personal Information</span>
          </div>
          <div class="col-md-4 px-0">
            <span id="add-new-case-step-2">2. Package Information</span>
          </div>
          <div class="col-md-4 pl-0">
            <span id="add-new-case-step-3">3. Verification Component</span>
          </div>
        </div>
        <div class="add-new-case-steps-div" id="add-new-case-step-1-tab">
          <div class="row">
            <div class="col-md-2">
              <div class="input-wrap">
                <!-- <span class="input-field-txt">Title*</span> -->
                <select class="input-field" id="title-v2">
                  <option value="Mr">Mr</option>
                  <option value="Mrs">Mrs</option>
                  <option value="Miss">Miss</option>
                </select>
              </div>
            </div>
            <div class="col-md-5">
              <div class="input-wrap">
                <input type="text" class="input-field" id="first-name-v2" required>
                <span class="input-field-txt">Enter First Name*</span>
                <div id="first-name-error-v2"></div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="input-wrap">
                <input type="text" class="input-field" id="last-name-v2" required>
                <span class="input-field-txt">Enter Last Name*</span>
                <div id="last-name-error-v2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-wrap">
                <input type="text" class="input-field" id="father-name-v2" required>
                <span class="input-field-txt">Enter Father's Name*</span>
                <div id="father-name-error-v2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-wrap">
                <input type="text" class="input-field dob-date" name="date" id="birth-date-v2" required>
                <span class="input-field-txt">Enter DOB*</span>
                <div id="birth-date-error-v2"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="input-wrap">
                <input type="text" class="input-field" id="email-id-v2" required>
                <span class="input-field-txt">Enter Email ID*</span>
                <div id="email-id-error-v2"></div>
              </div>
            </div>
            <div class="col-md-3">
              <select class="input-field" id="country-code"></select>
            </div>
            <div class="col-md-9">
              <div class="input-wrap">
                <input type="text" class="input-field" id="contact-no-v2" required>
                <span class="input-field-txt">Enter Phone Number*</span>
                <div id="contact-no-error-v2"></div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="input-wrap">
                <input type="text" class="input-field date-for-vendor-aggreement-end-date" name="joining-date-v2" id="joining-date-v2" required>
                <span class="input-field-txt">Joining Date</span>
                <div id="joining-date-error-v2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-wrap">
                <input type="text" class="input-field" id="employee-id-v2" required>
                <span class="input-field-txt">Employee ID</span>
                <div id="employee-id-error-v2"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="input-wrap"> 
                <select class="input-field" id="segment">
                  <option value="">Select Segment</option>
                  <?php 
                    foreach ($segment as $key => $value) {
                     echo "<option value='".$value['id']."'>".$value['name']."</option>";
                    }
                  ?>
                </select>
                <div id="segment-error"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="input-wrap"> 
                <select class="input-field" id="cost-center">
                  <option value="">Cost Center</option>
                  <?php 
                    foreach ($client_cost_centers as $key => $value) {
                     echo "<option value='".$value['location_id']."'>".$value['location_name']."</option>";
                    }
                  ?>
                </select>
                <div id="cost-center-error"></div>
              </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <button class="btn btn-submit w-100 mt-4" id="add-new-case-step-1-next-btn">Next</button>
            </div>
          </div>
        </div>
        <div class="add-new-case-steps-div d-none" id="add-new-case-step-2-tab">
          <div class="row">
            <div class="col-md-6">
              <span class="input-field-txt">Select Package*</span>
              <select class="input-field" id="package-v2">
                <option>Select Package</option>
              </select>
              <div id="package-error-v2"></div>
            </div>
            <div class="col-md-6">
              <span class="input-field-txt">Documents upload by*</span>
              <select class="input-field" id="document-uploader-v2">
                <option value="">Select Uploader</option>
                <option value="client">client</option>
                <option value="candidate">candidate</option>
              </select>
              <div id="document-uploader-error-v2"></div>
            </div>
            
            <div class="col-md-12">
              <div class="input-wrap input-wrap-2">
                <input type="text" class="input-field" id="remark-v2" required>
                <span class="input-field-txt">Remarks</span>
                <div id="remark-error-v2"></div>
              </div>
            </div>
            <div class="col-md-4" id="client-email-div-v2" style="display: none;">
              <div class="input-wrap">
                <input type="text" class="input-field" value="<?php echo $single_client['spoc_email_id']; ?>" id="client-email-v2" required>
                <span class="input-field-txt">Client Email*</span>
                <div id="client-email-error-v2">&nbsp;</div>
              </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
              <button class="btn btn-transperant w-100 mt-4" id="add-new-case-back-to-step-1-btn">Go Back</button>
            </div>
            <div class="col-md-3">
              <button class="btn btn-submit w-100 mt-4" id="add-new-case-step-2-next-btn">Next</button>
            </div>
          </div>
        </div>
        <div class="add-new-case-steps-div d-none" id="add-new-case-step-3-tab">
          <div class="row">
            <div class="col-md-12">
              <span class="verification-components-txt">Verification Components</span>
              <div class="custom-control custom-checkbox custom-control-inline mrg">
                <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll" spellcheck="true">
                <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
              </div>
              <div class="row" id="case-skills-list-v2"></div>
            </div>
            <div class="col-md-12 text-center" id="add-new-case-step-error-msg-div"></div>
            <div class="col-md-3 mt-4"></div>
            <div class="col-md-3 mt-4">
              <button class="btn btn-transperant w-100" id="add-new-case-back-to-step-2-btn">Go Back</button>
            </div>
            <div class="col-md-3 mt-4">
              <button class="btn btn-submit w-100" id="add-new-case-btn-v2">Submit</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        
      </div>

    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="add-bulk-case">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Bulk Cases</h4>
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div class="row">
         <div class="col-md-4"> 
            <!-- <span class="input-field-txt">Bulk Case</span> -->
            <input type="file" class="fld" name="excel_upload" id="add-bulk-upload-case" multiple="" spellcheck="true">
            <div class="file-name1"></div>
            <div id="file1-error"></div>
          </div>
          <div class="col-md-4">
            <div class="input-wrap">
              <input type="number" class="input-field" value="1" id="number-of-candidate" spellcheck="true" required>
              <span class="input-field-txt">Number Of Candidate</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-wrap">
              <input type="text" class="input-field" id="client-remarks" spellcheck="true" required>
              <span class="input-field-txt">Client Remarks</span>
            </div>
          </div>
       </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-submit" id="insert_bulk_data" onclick="add_bulk_cases()">Submit</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="view-bulk-case">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">View Bulk Cases</h4>
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div class="table-responsive">
          <table class="table custom-table table-striped">
            <thead>
              <tr>
                <th>Sr No.</th> 
                <th>Number of candidate</th>
                <th>Remarks</th>
                <th>Uploaded Files</th>
              </tr>
            </thead>
            <tbody id="get-bulk-upload-list"></tbody>
          </table>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer"></div>

    </div>
  </div>
</div>

<div class="modal fade custom-modal add-new-case" id="modal-edit-case-v2">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Case</h4>
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>
      <input type="hidden" id="modal-edit-candidate-id">
      <!-- Modal body -->
      <div class="modal-body p-0">
        <div class="row add-new-case-steps-tabs-div">
          <div class="col-md-4 pr-0">
            <span id="edit-case-step-1" class="active">1. Personal Information</span>
          </div>
          <div class="col-md-4 px-0">
            <span id="edit-case-step-2">2. Package Information</span>
          </div>
          <div class="col-md-4 pl-0">
            <span id="edit-case-step-3">3. Verification Component</span>
          </div>
        </div>
        <div class="add-new-case-steps-div" id="edit-case-step-1-tab">
          <div class="row">
            <div class="col-md-2">
              <!-- <span class="input-field-txt">Title*</span> -->
              <select class="input-field" id="edit-title-v2"></select>
            </div>
            <div class="col-md-5">
              <div class="input-wrap">
                <input type="text" class="input-field" id="edit-first-name-v2" required>
                <span class="input-field-txt">Enter First Name*</span>
                <div id="edit-first-name-error-v2"></div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="input-wrap">
                <input type="text" class="input-field" id="edit-last-name-v2" required>
                <span class="input-field-txt">Enter Last Name*</span>
                <div id="edit-last-name-error-v2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-wrap">
                <input type="text" class="input-field" id="edit-father-name-v2" required>
                <span class="input-field-txt">Enter Father's Name*</span>
                <div id="edit-father-name-error-v2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-wrap">
                <input type="text" class="input-field dob-date" name="date" id="edit-birth-date-v2"  required>
                <span class="input-field-txt">Enter DOB*</span>
                <div id="edit-birth-date-error-v2"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="input-wrap">
                <input type="text" class="input-field" id="edit-email-id-v2" required>
                <span class="input-field-txt">Enter Email ID*</span>
                <div id="edit-email-id-error-v2"></div>
              </div>
            </div>
            <div class="col-md-3">
              <select class="input-field" id="edit-country-code"></select>
            </div>
            <div class="col-md-9">
              <div class="input-wrap">
                <input type="text" class="input-field" id="edit-contact-no-v2" required>
                <span class="input-field-txt">Enter Phone Number*</span>
                <div id="edit-contact-no-error-v2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-wrap">
                <input type="text" class="input-field date-for-vendor-aggreement-end-date" name="joining-date-v2" id="edit-joining-date-v2" required>
                <span class="input-field-txt">Joining Date</span>
                <div id="edit-joining-date-error-v2"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-wrap">
                <input type="text" class="input-field" id="edit-employee-id-v2" required>
                <span class="input-field-txt">Employee ID</span>
                <div id="edit-employee-id-error-v2"></div>
              </div>
            </div>
            <div class="col-md-12">
               <div class="input-wrap input-wrap-2"> 
                <select class="input-field" id="edit-segment">
                  <option value="">Select Segment</option>
                  <?php 
                    foreach ($segment as $key => $value) {
                     echo "<option value='".$value['id']."'>".$value['name']."</option>";
                    }
                  ?>
                </select>
                <div id="edit-segment-error"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="input-wrap"> 
                <select class="input-field" id="edit-cost-center">
                  <option value="">Cost Center</option>
                  <?php 
                    foreach ($client_cost_centers as $key => $value) {
                     echo "<option value='".$value['location_id']."'>".$value['location_name']."</option>";
                    }
                  ?>
                </select>
                <div id="edit-cost-center-error"></div>
              </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <button class="btn btn-submit w-100 mt-4" id="edit-case-step-1-next-btn">Next</button>
            </div>
          </div>
        </div>
        <div class="add-new-case-steps-div d-none" id="edit-case-step-2-tab">
          <div class="row">
            <div class="col-md-6">
              <span class="input-field-txt">Select Package*</span>
              <select class="input-field" id="edit-package-v2">
                <option>Select Package</option>
              </select>
              <div id="edit-package-error-v2"></div>
            </div>
            <div class="col-md-6">
              <span class="input-field-txt">Documents upload by*</span>
              <select class="input-field" id="edit-document-uploader-v2">
                <option value="">Select Uploader</option>
                <option value="client">client</option>
                <option value="candidate">candidate</option>
              </select>
              <div id="edit-document-uploader-error-v2"></div>
            </div>
             
            <div class="col-md-12 ">
              <div class="input-wrap input-wrap-2">
                <input type="text" class="input-field" id="edit-remark-v2" required>
                <span class="input-field-txt">Remarks</span>
                <div id="edit-remark-error-v2"></div>
              </div>
            </div>
            <div class="col-md-4" id="client-email-div-v2" style="display: none;">
              <span class="input-field-txt">Client Email*</span>
              <input type="text" class="input-field" value="<?php echo $single_client['spoc_email_id']; ?>" id="edit-client-email-v2">
              <div id="edit-client-email-error-v2">&nbsp;</div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3">
              <button class="btn btn-transperant w-100 mt-4" id="edit-case-back-to-step-1-btn">Go Back</button>
            </div>
            <div class="col-md-3">
              <button class="btn btn-submit w-100 mt-4" id="edit-case-step-2-next-btn">Next</button>
            </div>
          </div>
        </div>
        <div class="add-new-case-steps-div d-none" id="edit-case-step-3-tab">
          <div class="row">
            <div class="col-md-12">
              <span class="verification-components-txt">Verification Components</span>
              <div class="custom-control custom-checkbox custom-control-inline mrg">
                <input type="checkbox" class="custom-control-input" name="edit-customCheck" id="edit-CheckAll" spellcheck="true">
                <label class="custom-control-label" for="edit-CheckAll"><strong>Select All</strong></label>
              </div>
              <div class="row" id="edit-case-skills-list-v2"></div>
            </div>
            <div class="col-md-12 text-center" id="edit-case-step-error-msg-div"></div>
            <div class="col-md-3 mt-4"></div>
            <div class="col-md-3 mt-4">
              <button class="btn btn-transperant w-100" id="edit-case-back-to-step-2-btn">Go Back</button>
            </div>
            <div class="col-md-3 mt-4">
              <button class="btn btn-submit w-100" id="edit-case-btn-v2">Submit</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        
      </div>

    </div>
  </div>
</div>


<div class="modal fade custom-modal add-new-case" id="add-new-case-v2-confirm">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header"> 
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-0">
        <div class="row add-new-case-steps-tabs-div">
           <h4 class="modal-title m-2" id="msg-for-the-warning">A case already exists with the email ID you have entered.Do you want to create a duplicate?</h4>
         </div>
       </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn custom-btn-1" data-dismiss="modal" >No</button>
        <button class="btn btn-submit" data-dismiss="modal" id="edit-case-btn-v2-confirm">Yes</button>
      </div>

    </div>
  </div>
</div>


<script>
   var component_config_name = "<?php echo $this->config->item('show_component_name'); ?>";
</script>

<script>
  // view_all_cases();
</script>
<script>
  var site_url = 'factsuite-client/get-all-cases';
  var html = '<table class="table custom-table table-striped">';
      html += '<thead>';
      html += '<tr><th>Sr&nbsp;No.</th>';
      html += '<th>Candidate</th>';
      html += '<th>Mobile&nbsp;Number</th>';
      html += '<th>Package</th>';
      html += '<th>Employee&nbsp;ID</th>';
      html += '<th class="text-center">Status</th>';
      html += '<th>Start&nbsp;Date</th>';
      html += '<th>End&nbsp;Date</th>';
      html += '<th>TAT&nbsp;Days</th>';
      html += '<th>Actions</th></tr>';
      html += '</thead>';
      html += '<tbody>';
      html += '<tr><td colspan="10" class="text-center"><div class="spinner-border text-muted custom-spinner"></div></td></tr>';
      html += '</tbody>';
      html += '</table>';
  var display_ui_id = '#view-all-cases',
      request_from = 'all-cases';
</script>
<script src="<?php echo base_url() ?>assets/custom-js/pagination/pagination.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url() ?>assets/custom-js/case/add-case.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url() ?>assets/custom-js/case/add-case-v2.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url() ?>assets/custom-js/case/edit-case-v2.js?v=<?php echo time(); ?>"></script>