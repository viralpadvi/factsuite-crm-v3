<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div id="FS-candidate-mn" class="add-team">
         
      </div>
    </div>
  </div>
</section>
<section id="pg-cntr"> 
<div class="pg-cnt">
  <h2>Internal Chat</h2>
  <div id="FS-candidate-cnt" class="FS-candidate-cnt fs-candidate-cnt-2">
    <div class="row border-top border-dark">
      <div class="col-md-3 chat-list-div">
        <input type="text" class="form-control fld mt-2 w-100" placeholder="Search" id="search-internal-team" name="">
        <div id="get-internal-chat-list">
        <?php if (count($team)) {
            foreach ($team as $key => $value) { ?> 
              <div id="main_<?php echo $value['team_id'].'_'.$value['role']; ?>" class="col-md-12 mt-3 px-0">
                <div class="edit-pages-a card user-chat-list user-chat-list-card" data-id="<?php echo $value['team_id']; ?>" data-role="<?php echo $value['role']; ?>">
                  <div class="row">
                    <div class="col-md-2"> 
                      <div class="candate"><span class="chat-profile-img text-white text-center"><?php echo strtoupper($value['first_name'][0]); ?></span></div>
                    </div>
                    <div class="col-md-8 text-left">
                      <h6 class="card-pages-name mt-2 mb-1 pl-2"><?php echo ucwords($value['first_name'].' '.$value['last_name']); ?></h6> 
                      <span class="card-last-edited-date pl-2" id="home-page-total-case"><?php echo ucwords($value['role']); ?></span>
                    </div>
                     <div class="col-md-2 text-center">  
                      <span id="chat-<?php echo $value['team_id'].'_'.$value['role']; ?>" class="chat-count">0</span>
                    </div>
                  </div>
                </div>
              </div> 
        <?php } } ?>
        </div>
      </div>
      <div class="col-md-9 d-none" id="chat-history-div">
        <input type="hidden" id="current-active-user-id" value="0">
        <input type="hidden" id="current-active-user-role" value="0">
        <div class="w-100 mt-3 chat-msgs-div">
          <div class="m-1" id="get-internal-chat" ></div>
        </div>
        <div class="input-group my-3">
          <input type="text" class="form-control" id="internal-chat-input" placeholder="Type here ..">
          <div class="input-group-append">
            <input type="file" id="upload-file" name="upload-file[]" multiple="multiple" style="display: none;">
            <label id="btn-send-chat" class="btn bg-blu btn-submit-cancel" style="background: #F59E1D;" for="upload-file"><img src="<?php echo base_url()?>assets/dist/img/images/upload.png" style="height: 17px;"></label>
            <button id="btn-send-chat" class="btn bg-blu btn-submit-cancel" style="height: fit-content;"><i class="fa fa-paper-plane text-white" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 

</section>
<!--Content-->


   <!-- Delete Modal Starts -->
  <div class="modal fade" id="my-chat-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body modal-body-delete-coupon">
         <h6>Internal Chat Documents</h6>
          <div class="row"> 
              <div class="col-md-12 form-group" id="view-img">
                
               </div> 
            <div class="col-md-12"> 
            <div class="sbt-btns">
             <a href="#" data-dismiss="modal" class="bg-gry mb-1 btn-submit-cancel">Cancel</a> 
             <a href="#" id="save-chat-btn" onclick="save_internal_chat_last_value()" class="bg-blu btn-submit-cancel">Send</a>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Modal Ends -->
 
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/chat/internal-chat.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/common-validations.js"></script>