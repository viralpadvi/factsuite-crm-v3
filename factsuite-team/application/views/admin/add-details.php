       <section id="pg-hdr">
   <div class="container-fluid"> 
          <div class="tab-content">
            <div class="col-sm-6 float-right"></div>
             <div class="col-sm-4">
                <span class="product-details-span-light">Impoert</span> 
                  <input type="file" id="add-bulk-upload-case" name="add-bulk-upload-case" class="input-file w-50" >
                  
                </div>
                <div class="row" id="selected-banner-video-div"></div>
                <a href="#" class="btn btn-info" onclick="import_excel()">Submit</a>
              </div> 
              <div class="col-sm-12">
             <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Category</th>
                <th>Company Name</th>  
                <th>User Name</th> 
                <th>Email Id</th>  
                <th>Contact</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data-1"> 
              <?php 
              $i = 1;
              print_r($details);
              foreach ($details as $key => $value) {
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $value['category']; ?></td>
                  <td><?php echo $value['company']; ?></td>
                  <td><?php echo $value['user_name']; ?></td>
                  <td><?php echo $value['email']; ?></td>
                  <td><?php echo $value['contact']; ?></td> 
                </tr>
                <?php 
              }
              ?>
            </tbody>
          </table>
        </div> 
              
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<!-- View Banner Image / Video Modal Starts -->
  <div class="modal fade" id="view-banner-image-or-video-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h4 class="modal-title-edit-coupon">Banner <span id="banner-image-or-model-hdr-span"></span></h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2">
            <div class="col-md-3"></div>
            <div class="col-sm-6" id="banner-image-or-video-modal-div">
              <img class="w-100" >
            </div>
            <div id="view-edit-cancel-btn-div" class="col-md-12 mt-2 text-right">
              <button class="btn btn-default btn-close" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- View Banner Image / Video Modal Ends -->

<!-- View We Enabled Description Modal Starts -->
  <div class="modal fade" id="view-we-enabled-description-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h4 class="modal-title-edit-coupon">We Enable Description</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row">
            <div class="col-sm-12">
              <span class="product-details-span-light">Description(We Enable)</span>
              <input type="text" class="input-txt" name="edit-we-enable-description" id="edit-we-enable-description" placeholder="Description(We Enable)">
              <div id="edit-we-enable-description-error-msg-div"></div>
            </div>
            <div class="col-sm-12" id="edit-we-enable-description-main-error-msg-div"></div>
          </div>
          <div id="view-edit-cancel-btn-div" class="col-md-12 mt-2 text-right">
            <button class="btn btn-default btn-close" data-dismiss="modal">Close</button>
            <button class="btn btn-add btn-update text-white mt-0 modal-btn-gap" id="update-edit-we-enable-description-btn" name="update-edit-we-enable-description-btn">Save</button>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- View We Enabled Description Modal Ends -->

<!-- Delete We Enabled Description Modal Starts -->
  <div class="modal fade" id="delete-we-enabled-description-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h4 class="modal-title-edit-coupon modal-title-delete">Are you sure you want to delete the <span id="delete-we-enabled-description-hdr-span"></span> Description?</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2">
            <div class="col-md-3"></div>
            <div class="col-sm-6">
              <img class="w-100" id="gse-or-mhe-image-modal-img">
            </div>
            <div id="view-edit-cancel-btn-div" class="col-md-12 mt-2 text-center">
              <button class="btn btn-default btn-close" data-dismiss="modal">Close</button>
              <button class="btn btn-add btn-danger btn-delete text-white mt-0 modal-btn-gap" id="delete-we-enabled-description-btn">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Delete We Enabled Description Modal Ends -->

<script src="<?php echo base_url()?>assets/admin/myntra/add-details.js"></script>