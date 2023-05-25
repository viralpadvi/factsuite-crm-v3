 
					<?php 
            $mca = isset($table['mca'])?$table['mca']:'';// $this->db->where('candidate_id',$user['candidate_id'])->get('driving_licence')->row_array();
            ?>
					<input type="hidden"class="fld form-control" name="mca_id" id="mca_id" value="<?php echo isset($mca['mca_id'])?$mca['mca_id']:''; ?>" >
					<div class="row">
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field" name="organization_name" id="organization_name" value="<?php echo isset($mca['organization_name'])?$mca['organization_name']:''; ?>" >
				                <span class="input-field-txt">Organization Name </span>
                  				<div id="organization_name-error">&nbsp;</div> 
				            </div>
						</div>
						  
					</div>
 
					<div class="row">
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Experience/Relieving Letter For That Company </div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name1"> 
                       <?php
                     $experiance_doc = '';
                       if (isset($mca['experiance_doc'])) {
                       if (!in_array('no-file', explode(',', $mca['experiance_doc']))) {
                         foreach (explode(',', $mca['experiance_doc']) as $key => $value) {
                           if ($value !='') {
                             echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"mca-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/mca-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           }
                         }
                         $experiance_doc = $mca['experiance_doc'];
                       }}
                       ?>
                      <input type="hidden" name="experiance_doc" value="<?php echo $experiance_doc; ?>" id="experiance_doc">
                     </div>
			                      <div id="file1-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  				<input type="file" id="file1" name="file1" class="input-file w-100" accept="image/*,application/pdf" multiple>
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
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add-mca"   class="save-btn">Save &amp; Continue</button>
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

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-mca.js" ></script>