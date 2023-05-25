<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team">
            <ul class="nav nav-tabs nav-justified">
                
               <li class="nav-item">
                  <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'component'; ?>">Component</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'package'; ?>">Package</a>
               </li>
                <li class="nav-item d-none">
                  <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'factsuite-admin/factsuite-alacarte'; ?>">Alacarte</a>
               </li>
               
            </ul>
         </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
     <!-- <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
            
           <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'component'; ?>">Component</a>
           </li>
           <li class="nav-item">
              <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'package'; ?>">Package</a>
           </li>
            <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'factsuite-admin/factsuite-alacarte'; ?>">Alacarte</a>
           </li>
           <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
           </li>
        </ul>
     </div> -->
     <!--Nav Tabs-->
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt"  class="FS-candidate-cnt">
         <h3>Package Details</h3>
        <div class="sbt-btns">
          <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_package"class="btn bg-blu btn-submit-cancel">ADD&nbsp;PACKAGE</a>
        </div>
        <div class="table-responsive mt-3" id="">
          <table class="table-fixed datatable1 table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Package&nbsp;Name</th> 
                <th>Component&nbsp;List</th>  
                <th>Package&nbsp;Status</th>  
                <th>Edit</th>  
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable" id="get-team-data"> 
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add package Modal Starts -->
  <div class="modal fade" id="add_package">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Add&nbsp;Package</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Package Name</label>
                <input type="text" class="fld" name="package_name" id="package_name" placeholder="Enter Package Name">
                <div id="package-name-error-msg-div"></div>  
              </div>
              
            </div>
            <div class="row mt-2">
              <div class="col-sm-12">
                <label class="product-details-span-light">Select Components</label>
                  <div class="row">
                  <?php
                    $i =0;
                    
                    foreach ($components as $value) {
                     
                  ?> 
                  
                    <div class="col-md-4">
                      
                      <div class=" custom-control custom-checkbox custom-control-inline">
                        <input  type="checkbox" 
                                class="custom-control-input components" 
                                value="<?php echo $value['component_id']?>" 
                                name="componentCheck" 
                                id="componentCheck<?php echo $value['component_id']?>"
                                onclick = "GetSelected()">

                        <label class="custom-control-label" for="componentCheck<?php echo $value['component_id']?>">
                          <?php echo $value['component_name']?>
                        </label>
                      </div>
                    </div>
                    
                    
                  <?php
                      $i++;
                    }
                  ?>
                   </div>
                <div id="package-price-error-msg-div"></div>  
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-blu btn-close text-white" id="edit-package-close-btn" name="add-package-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-package-btn" name="edit-package-close-btn" onclick="addPackage()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;package</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add package Modal Ends -->


  <!-- Edit package Modal Starts -->
   <div class="modal fade" id="edit_package">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Edit&nbsp;Package</h4> 
        </div>
        <input type="hidden" name="edit_package_id" id="edit_package_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-12">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Package Name</label>
                <input type="text" class="fld" name="edit_package_name" id="edit_package_name" placeholder="Enter package Name">
                <div id="edit-package-name-error-msg-div"></div>  
              </div>
              
              
            </div>
            
             
          </div>
          <div class="row mt-2">
              <div class="col-sm-12">
                <label class="product-details-span-light">Select Components</label>
                  <div class="row" id="componentCheckbox">
                    <div class="col-md-4">
                       
                    </div>
                   </div>
                <div id="package-price-error-msg-div"></div>  
              </div>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-blu btn-close text-white" id="edit-package-close-btn" name="add-package-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-package-btn" name="edit-package-close-btn" onclick="updateData()">Update</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;package</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Coupon Modal Ends -->

</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/package/view-package.js"></script> 
