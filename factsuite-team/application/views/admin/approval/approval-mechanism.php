<section id="pg-cntr">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Addition/ Deletion of CRM users</h3>
        <div class="sbt-btns">
          <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#add-new-ticket-modal"class="btn bg-blu btn-submit-cancel">Addition/ Deletion</a>
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
                <th>Created By</th>  
                <th>Status</th>    
                <th>View</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-all-tickets"></tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>


  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="new-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Approval Mechanism</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2"> 
               <div class="col-md-6" id="status_level_1" style="display:none;">
                <label>Level 1 Status :</label>
                <span id="level_one"></span>
              </div>
              <div class="col-md-6" id="status_level_2" style="display:none;">
                <label>Level 2 Status : </label>
                <span id="level_two"></span>
              </div>
              <div class="col-md-6" id="status_level_3" style="display:none;">
                <label>Level 3 Status : </label>
                <span id="level_three"></span>
              </div>
              <div class="col-md-6" >
                <label>Final Status : </label>
                <span id="final_status"></span>
              </div>
              
              <div class="col-sm-12">
                 <div>Created By: <span id="created_by"></span></div>
                 <div>Action Type: <span id="action_type"></span></div>
                 <div>Created Remarks: <span id="created_remarks"></span></div>
                 <div></div>
              </div>
                 
                 <div class="row" id="extra-details"></div>
                <div class="col-md-12" id="rejected_remarks"></div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Close</button> 
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->
 

  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="add-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Addition/ Deletion of CRM users</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2">
              <div class="col-sm-6">
                <label class="product-details-span-light">Approval Type</label>
                <select class="form-control fld" id="type-of-approval">
                  <option value="0">Addition</option>
                  <option value="1">Deletion</option>
                </select>
                <div id="type-of-approval-error-msg-div"></div>
              </div>
              <div class="col-md-6"></div>
              <div class="col-md-6">
                <label class="product-details-span-light">First Name</label>
                   <input type="text" class="form-control" name="first-name" id="first-name"> 
                 <select  class="form-control" name="exist-first-name" id="exist-first-name" style="display:none;">
                   <option value=""> Select User</option>
                     <?php 
                      foreach ($team as $key => $value) {
                        
                        echo "<option data-id='{$value['reporting_manager']}' data-first='{$value['first_name']}' data-last='{$value['last_name']}' data-email='{$value['team_employee_email']}'  data-role='{$value['role']}' value='{$value['team_id']}'>".$value['first_name']."(".$value['role'].")"."</option>";
                      
                      }
                     ?>
                   </select>
                   <div id="first-name-error"></div> 
              </div>
               <div class="col-md-6">
                <label class="product-details-span-light">Last Name</label>
                   <input type="text" class="form-control" name="last-name" id="last-name"> 
                   <div id="last-name-error"></div> 
              </div>
                <div class="col-sm-6">
                   <label class="product-details-span-light">Email Id</label>
                   <input type="text" class="form-control" name="user-name" id="user-name"> 
                   <div id="user-name-error"></div> 
                 </div> 
                 <div class="col-sm-6">
                   <label class="product-details-span-light">Designation</label>
                   <input type="text" class="form-control" name="designation" id="designation">
                   <div id="designation-error"></div> 
                 </div>
                  <div class="col-sm-6">
                   <label class="product-details-span-light">Mobile Number</label>
                   <input type="text" class="form-control" name="contact" id="contact">
                    <div id="contact-error"></div> 
                 </div>
                  <div class="col-sm-6">
                   <label class="product-details-span-light">Reporting Manager Name</label>
                   <!-- <input type="text" class="form-control" name="manager-name" id="manager-name"> -->
                   <select  class="form-control" name="manager-name" id="manager-name">
                   <option value=""> Select Manager</option>
                     <?php 
                      foreach ($team as $key => $value) {
                        
                        echo "<option data-name='{$value['first_name']}' value='{$value['team_id']}'>".$value['first_name']."(".$value['role'].")"."</option>";
                      
                      }
                     ?>
                   </select>
                   <div id="manager-name-error"></div> 
                 </div>
                 
              <div class="col-sm-6">
                <label class="product-details-span-light">Select Role</label>
                <select class="form-control fld" id="assigned-to-roles">
                  <option value="">Select Role</option>
                  <?php 
                  foreach ($roles as $key => $value) {
                    echo "<option value='".strtolower($value['role_name'])."'>".$value['role_name']."</option>";
                  }
                  ?>
                </select>
                <div id="assigned-to-role-error-msg-div"></div>
              </div>
               
              <div class="col-md-12">
                <label class="product-details-span-light">Remarks</label>
                <!-- ckeditor -->
                <!-- <textarea class="fld" name="ticket_description" id="ticket_description" placeholder="Remarks"></textarea> -->
                <select class="fld" name="ticket_description" id="ticket_description"></select>
                <div id="ticket-description-error-msg-div"></div>
              </div>
              <div class="col-md-12" id="additionals" style="display:none;">
                 <label class="product-details-span-light">Additional Remarks</label>
                 <textarea class="fld" name="additional_remarks" id="additional_remarks" placeholder="Additional Remarks"></textarea>
              </div>
              
              <div class="col-md-12">
                <label>Components / Skills</label>
                <div class="row" id="view-all-packages">
          <?php
          if (count($component) > 0) {
              foreach ($component as $key => $comp) {

               $component_name = $comp[$this->config->item('show_component_name')];
                 
 
              if ($comp['component_name'] =='Adverse Media/Media Database Check') {
                   $component_name = 'Adverse Media/Database Check ';
              }
                if ($comp['component_name'] =='Health Checkup Check') {
                   $component_name = 'Health Check ';
              }
                ?>

            <div class="col-md-3 mt-1">
          <div class="custom-control custom-checkbox custom-control-inline mrg">
      <input type="checkbox" class="custom-control-input package_components package_comp" name="package_components" data-component_name="<?php echo $comp['component_name']; ?>" value="<?php echo $comp['component_id']; ?>" id="customradioeducheckpackage<?php echo $comp['component_id']; ?>">
      <label class="custom-control-label" for="customradioeducheckpackage<?php echo $comp['component_id']; ?>"><?php echo $component_name; ?> </label>
      </div>
          </div>

                <?php
              }
            }
          ?>
          <div id="component-error-msg-div"></div>
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
<script src="<?php echo base_url() ?>assets/custom-js/admin/approval/create-approval.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/admin/approval/all-approvals.js"></script>