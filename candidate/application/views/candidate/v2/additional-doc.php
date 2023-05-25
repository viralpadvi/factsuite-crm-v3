 
 
          <h2 class="component-name">Additional Documents</h2>
          <?php 
        $content = '';
         if (isset($log['additional'])) {
                    if ($log['additional'] == 1) {
                     $content = $log['aad_on_suggestion'];
                    }}
        ?>
            <h6 class="component-name"><?php echo $content; ?> </h6>
          <div class="row">
            <div class="col-md-10">
                          <div class="row">
                            <div class="col-8">
                              <div class="custom-file-name file-name1"> 
                              <?php
                             $additional_docs = '';
                               if (isset($user['additional_docs'])) {
                               if (!in_array('no-file', explode(',', $user['additional_docs']))) {
                                 foreach (explode(',', $user['additional_docs']) as $key => $value) {
                                   if ($value !='') {
                                     echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"additional-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/additional-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                   }
                                 }
                                 $additional_docs = $user['additional_docs'];
                               }}
                               ?>
                               <input type="hidden" value="<?php echo  $additional_docs; ?>" name="additional_docs" id="additional_docs">
                     </div> 
                     </div> 
                   <div id="file1-error"> 
                            </div>
                            <div class="col-4 custom-file-input-btn-div">
                              <div class="custom-file-input">
                          <input type="file" id="file1" name="file1" class="input-file w-100" accept="image/*,application/pdf" multiple >
                              <button class="btn btn-file-upload" for="file1">
                                <img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
                                Upload
                              </button>
                            </div>
                          </div>
                      </div>
            </div>
          </div>

          <div class="row"> 
            <div class="col-md-7"></div>
            <div class="col-md-5">
              <button id="add-driving-licence" class="save-btn">Save &amp; Continue</button>
            </div>
          </div>

      </div>
      </div>
    </div>
  </div>
             
<div class="modal fade view-document-modal" id="myModal-show" role="dialog">
  <div class="modal-dialog modal-md modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
          <div class="modal-header border-0">
            <h3 id="">View Document</h4>
          </div>
          <div class="modal-body modal-body-edit-coupon">
            <div class="row"> 
            <div class="col-md-12 text-center view-img" id="view-img"></div>
          </div>
            <div class="row mt-3">
                <div class="col-md-6" id="setupDownloadBtn"></div>
                <div id="view-edit-cancel-btn-div" class="col-md-6 text-right">
                  <button class="btn btn-close-modal" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
      </div>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-additional.js" ></script>
 