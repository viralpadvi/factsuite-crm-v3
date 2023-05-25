<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-cv-check';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">CV Check</div>
         <div class="pg-rgt">Step <?php echo array_search('20',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <?php 
            $cv_data = isset($table['cv_check'])?$table['cv_check']:'';
         ?>
         <div class="full-bx">
            <label>CV Check</label>
            <div id="fls">
               <div class="form-group files">
                  <input type="hidden" name="cv_id" value="<?php echo isset($cv_data['cv_id'])?$cv_data['cv_id']:''; ?>" id="cv_id">
                  <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                  <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                  <div class="file-name1"> 
                     <?php $cv_doc = '';
                     if (isset($cv_data['cv_doc'])) {
                        if (!in_array('no-file', explode(',', $cv_data['cv_doc']))) {
                           foreach (explode(',', $cv_data['cv_doc']) as $key => $value) {
                              if ($value !='') {
                                 echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"cv-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"cv\")' data-path='cv-docs' data-field='cv_check' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/cv-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                              }
                           }
                           $cv_doc = $cv_data['cv_doc'];
                        }
                     } ?>
                     <input type="hidden" value="<?php echo $cv_doc; ?>" id="uploaded-cv-docs">
                     </div> 
                  </div>
               </div>
               <div id="file1-error"></div>
         </div>
      </div>
      <div id="save-data-error-msg"></div>
      <button class="pg-nxt-btn" id="save-details-btn">Save &amp; Continue</button>
   </div>
</div>

<div class="modal fade " id="myModal-show" role="dialog">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
         </div>
         <div class="modal-body">
            <div id="view-img"></div>
         </div>
         <div class="modal-footer">
            <div class="header-mn text-center">
               <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
            </div>
         </div>
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

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/cv-check.js" ></script>