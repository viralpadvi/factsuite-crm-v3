<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
			<?php 
		    $content = '';
		     if (isset($log['additional'])) {
		                if ($log['additional'] == 1) {
		                 $content = $log['aad_on_suggestion'];
		                }}
		    ?>
				 
				<div class="row content-div-content-row-1">
					 <div class="col-12"><span class="input-main-hdr">Additional Documents</span></div>
					<div class="col-12"><span class="input-main-hdr"><?php echo $content; ?> *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				<span class="custom-file-name file-name file-name1" id="file1-error">
                  					 <?php
				                     $additional_docs = '';
				                       if (isset($user['additional_docs'])) {
				                       if (!in_array('no-file', explode(',', $user['additional_docs']))) {
				                         foreach (explode(',', $user['additional_docs']) as $key => $value) {
				                           if ($value !='') {
				                             echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"additional-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/additional-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
				                           }
				                         }
				                         $additional_docs = $user['additional_docs'];
				                       }}
				                       ?>
                  				</span>
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  					<input type="file" id="file1" name="file1" accept="image/*,application/pdf" class="input-file w-100" >
                  				<button class="btn btn-file-upload" for="file1">
                  					<img src="<?php echo base_url();?>assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<input type="hidden" value="<?php echo  $additional_docs; ?>" name="additional_docs" id="additional_docs">
                  		</div>
	                	</div>
					</div>
				</div>
				 
			 
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-driving-licence">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>


  <div class="modal fade " id="myModal-show" role="dialog">
 <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
        <div class="modal-header border-0">
          <h3 id="">View Document</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
         <div class="col-md-12 text-center" id="view-img"></div>
    </div>
          <div class="row p-5 mt-2">
              <div class="col-md-6" id="setupDownloadBtn">
                
              </div>
              <div id="view-edit-cancel-btn-div" class="col-md-6  text-right">
                <button class="btn bg-blu text-white exit-btn" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
        <!-- <div class="modal-footer border-0"></div> -->
      </div>
    </div>
</div>


<div class="modal fade " id="myModal-remove" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
         <div id="remove-caption"></div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center" id="button-area">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>

	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-additional.js" ></script>