<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-driving-licence';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Driving licence</div>
         <div class="pg-rgt">Step <?php echo array_search('16',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <?php 
            $driving_data = isset($table['driving_licence'])?$table['driving_licence']:'';
         ?>
         <div class="full-bx">
            <label>Driving Licence Number</label>
            <input type="hidden"class="fld form-control" name="driving_licence_id" id="driving_licence_id" value="<?php echo isset($driving_data['licence_id'])?$driving_data['licence_id']:''; ?>" >
            <input type="text"class="fld form-control" name="driving_licence_number" id="driving_licence_number" value="<?php echo isset($driving_data['licence_number'])?$driving_data['licence_number']:''; ?>" >
            <div id="driving_licence_number-error"></div>
         </div>
         <div class="full-bx">
            <label>Driving licence</label>
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
                        }
                     } ?>
                     <input type="hidden" name="driving_licence_doc" value="<?php echo $licence_doc; ?>" id="driving_licence_doc">
                  </div>    
               </div>
            </div>
            <div id="file1-error"></div>
         </div>
      </div>
      <div id="save-data-error-msg"></div>
      <button class="pg-nxt-btn" id="add-driving-licence">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-driving-licence.js" ></script>