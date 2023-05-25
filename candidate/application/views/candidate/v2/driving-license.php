 
					<?php 
            $driving_data = isset($table['driving_licence'])?$table['driving_licence']:'';// $this->db->where('candidate_id',$user['candidate_id'])->get('driving_licence')->row_array();
            ?>
					<input type="hidden"class="fld form-control" name="driving_licence_id" id="driving_licence_id" value="<?php echo isset($driving_data['licence_id'])?$driving_data['licence_id']:''; ?>" >
					<div class="row">
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field" name="driving_licence_number" id="driving_licence_number" value="<?php echo isset($driving_data['licence_number'])?$driving_data['licence_number']:''; ?>" >
				                <span class="input-field-txt">Driving Licence Number </span>
                  				<div id="driving_licence_number-error">&nbsp;</div> 
				            </div>
						</div>
						  
					</div>
 
					<div class="row">
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Driving license </div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name1"> 
                       <?php
                     $licence_doc = '';
                       if (isset($driving_data['licence_doc'])) {
                       if (!in_array('no-file', explode(',', $driving_data['licence_doc']))) {
                         foreach (explode(',', $driving_data['licence_doc']) as $key => $value) {
                           if ($value !='') {
                             echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"licence-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/licence-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           }
                         }
                         $licence_doc = $driving_data['licence_doc'];
                       }}
                       ?>
                      <input type="hidden" name="driving_licence_doc" value="<?php echo $licence_doc; ?>" id="driving_licence_doc">
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
							<button id="add-driving-licence"   class="save-btn">Save &amp; Continue</button>
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
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-driving-licence.js" ></script>