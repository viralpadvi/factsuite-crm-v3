<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      // window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-driving-licence';
   }
</script>

   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
     <div class="pg-txt-cntr">
         <div class="pg-steps">Step  <?php echo array_search('16',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <h6 class="full-nam2"> Driving license</h6>
          <?php 
            $driving_data = isset($table['driving_licence'])?$table['driving_licence']:'';// $this->db->where('candidate_id',$user['candidate_id'])->get('driving_licence')->row_array();
            ?>
         <div class="row mt-3">
               
            <div class="col-md-4">
               <div class="pg-frm-hd">Driving Licence Number</div>
               <input type="hidden"class="fld form-control" name="driving_licence_id" id="driving_licence_id" value="<?php echo isset($driving_data['licence_id'])?$driving_data['licence_id']:''; ?>" >
               <input type="text"class="fld form-control" name="driving_licence_number" id="driving_licence_number" value="<?php echo isset($driving_data['licence_number'])?$driving_data['licence_number']:''; ?>" >

               <div id="driving_licence_number-error">&nbsp;</div>
            </div>
               
         </div>
          <div class="row mt-3">  
            <div class="col-md-4">
               <div class="pg-frm-hd">Driving license </div>
            </div>
               
         </div>
         <div class="row"> 

            <div class="col-md-4">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name1"> 
                       <?php
                     $licence_doc = '';
                       if (isset($driving_data['licence_doc'])) {
                       if (!in_array('no-file', explode(',', $driving_data['licence_doc']))) {
                         foreach (explode(',', $driving_data['licence_doc']) as $key => $value) {
                           if ($value !='') {
                             echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"licence-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"licence\")' data-path='licence-docs' data-field='cv_check' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/licence-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           }
                         }
                         $licence_doc = $driving_data['licence_doc'];
                       }}
                       ?>
                      <input type="hidden" name="driving_licence_doc" value="<?php echo $licence_doc; ?>" id="driving_licence_doc">
                     </div>
                      
                  </div>
               </div>
               <div id="file1-error"></div>
            </div>
              

         </div>
       
       
         
         <div class="row">
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add-driving-licence" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>

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


<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-driving-licence.js" ></script>
 