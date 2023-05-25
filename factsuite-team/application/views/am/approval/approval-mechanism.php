<section id="pg-cntr">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Ops Executives- work allocation quota</h3>
        <div class="sbt-btns">
          <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#add-new-ticket-modal"class="btn bg-blu btn-submit-cancel">work allocation quota</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sl No.</th> 
                <th>Approval&nbsp;Id</th>  
                <th>Action Type</th>  
                <th>Created&nbsp;Date</th>  
                <th>Remarks</th>  
                <th>Status</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-all-tickets"></tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="add-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Ops Executives- work allocation quota</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2"> 
                <div class="col-sm-6">
                   <label class="product-details-span-light">Analyst/Specialist Name</label>
                   <input type="text" class="form-control" name="user-name" id="user-name">
                 </div>  
                 
              <div class="col-sm-6">
                <label class="product-details-span-light">Select Role</label>
                <select class="form-control fld" id="assigned-to-roles">
                  <option value="">Select Role</option>
                  <?php 
                  foreach ($roles as $key => $value) {
                    if (in_array(strtolower($value['role_name']),['analyst','specialist'])) { 
                    echo "<option value='".$value['role_name']."'>".$value['role_name']."</option>";
                    }
                  }
                  ?>
                </select>
                <div id="assigned-to-role-error-msg-div"></div>
              </div>
               
              <div class="col-md-12">
                <label class="product-details-span-light">Remarks</label>
                <!-- ckeditor -->
                <textarea class="fld" name="ticket_description" id="ticket_description" placeholder="Remarks"></textarea>
                <div id="ticket-description-error-msg-div"></div>
              </div>
              <div class="col-md-12">
                <label>Components / Skills</label>
                <div class="row" id="view-all-packages">
          <?php
          if (count($component) > 0) {
            $i = 0;
              foreach ($component as $key => $comp) {

               $component_name = $comp[$this->config->item('show_component_name')];
                 
 
              if ($comp['component_name'] =='Adverse Media/Media Database Check') {
                   $component_name = 'Adverse Media/Database Check ';
              }
                if ($comp['component_name'] =='Health Checkup Check') {
                   $component_name = 'Health Check ';
              }
                ?>

            <div class="col-md-4 mt-1">
          <div class="custom-control custom-checkbox custom-control-inline mrg">
      <input type="checkbox" class="custom-control-input package_components package_comp" name="package_components" data-component_name="<?php echo $comp['component_name']; ?>" value="<?php echo $comp['component_id']; ?>" id="customradioeducheckpackage<?php echo $comp['component_id']; ?>">
      <label class="custom-control-label" for="customradioeducheckpackage<?php echo $comp['component_id']; ?>"><?php echo $component_name; ?> </label>
      </div>
      <textarea class="remarks form-control" id="remarks<?php echo $comp['component_id']; ?>"></textarea>
          </div>

                <?php
              }
            }
          ?>
         </div>
              </div>
               
              <div class="col-sm-12">
                <div id="raise-ticket-error-msg-div"></div>
              </div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" id="raise-ticket-btn">Add</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->
 
</section>
<!--Content-->

<!-- custom-js -->
<script src="<?php echo base_url() ?>assets/custom-js/am/approval/create-approval.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/am/approval/all-approvals.js"></script>