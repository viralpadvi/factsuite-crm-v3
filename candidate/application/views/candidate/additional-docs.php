<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      // window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-driving-licence';
   }
</script>

   <!--Page Content-->
   <!-- <form> -->
    <?php 
    $content = '';
     if (isset($log['additional'])) {
                if ($log['additional'] == 1) {
                 $content = $log['aad_on_suggestion'];
                }}
    ?>
   <div class="pg-cnt pt-3">
     <div class="pg-txt-cntr"> 
         <h6 class="full-nam2"> Additional Documents</h6>
           
         <div class="row mt-3">
               
            <div class="col-md-4">
               <div class="pg-frm-hd"><span><?php echo $content; ?></span></div>  
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
                      <input type="hidden" name="additional_docs" value="<?php echo $additional_docs; ?>" id="additional_docs">
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


<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-additional.js" ></script>
 