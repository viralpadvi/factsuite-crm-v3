<hr>
<div class="row">
  <div class="col-md-3">
    <label>Assign Vendor</label>
    <select id="vendor_name" name="vendor_name" class="fld">
      <option value="0">Select Vendor</option>
      <?php 
      foreach ($vendor as $k => $v) {
        echo "<option value='{$v['vendor_id']}'>{$v['vendor_name']}</option>";
      }
      ?>
    </select>
  </div>
  <div class="col-md-2 mt-2">
    <a class="btn bg-blu btn-submit mt-4 w-100" id="view_vendor_log"><span class="text-white">View Vendor Log</span></a>
  </div>
  <div class="col-md-6 d-none" id="assigned-vendor-case-completion-date-div">
    <div class="row">
      <input type="hidden" id="assigned-vendor-case-completion-latest-id">
      <div class="col-md-6">
        <label>Vendor Case Completion Date</label>
        <input type="text" class="fld date-max-today" id="assigned-vendor-case-completion-date">
        <div id="assigned-vendor-case-completion-date-error-msg-div"></div>
      </div>
      <div class="col-md-3 mt-2">
        <button class="btn bg-blu btn-submit mt-4 w-100 text-white" id="assigned-vendor-case-completion-date-submit-btn">Submit</button>
      </div>
    </div>
  </div> 
  <div class="col-md-1 mt-2"></div>
  <?php 
  if ($this->config->item('approval') =='1' && ! $this->session->userdata('logged-in-insuffanalyst')) { 
  ?>
  <div class="col-md-3 mt-2">
     <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#add-new-ticket-modal"class="btn bg-blu btn-submit-cancel mt-4  float-right"><span class="text-white">Additional Verification Fee</span></a>
  </div>
  <div class="col-md-3  mt-2">
     <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#view_approval_list"class="btn bg-blu btn-submit-cancel mt-4 float-left"><span class="text-white">View Additional Verification</span></a>
    
  </div>
<?php } ?>
</div>

<script src="<?php echo base_url() ?>assets/custom-js/vendor/vendor-details.js"></script>