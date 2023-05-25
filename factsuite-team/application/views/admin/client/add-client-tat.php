<div class="pg-cnt">
   <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
      <h3>Percentage and TimeFrame</h3>
      <div class="row d-none">
         <div class="col-md-4">
            <label>Select Your Client</label>
            <select class="fld form-control select2">
               <option>1</option>
               <option>2</option>
               <option>3</option>
               <option>4</option>
               <option>5</option>
               <option>6</option>
            </select>             
            <div id="select-client-error">&nbsp;</div>                          
         </div>              
      </div>
      <div class="row">
         <div class="col-md-4">
            <label class="add-client-bx">Low priority</label>
            <div class="row">
               <div class="col-md-6">
                  <label>Percentage</label>
                  <input type="number" min="0" max="100"class="form-control fld priority" onkeyup="percentageVaidation(this.id,this.value,'low')" id="low-percentage" name="low-percentage"> 
                  <div id="low-priority-percentage-error">&nbsp;</div>                          
               </div>
               <div class="col-md-6">
                  <label>Days</label>
                  <input type="number" min="0" max="365"class="form-control fld priority" onkeyup="daysVaidation(this.id,this.value,'low')" onkeydown="allow_only_number(this.id,this.value)" id="low-days" name="low-days">                        
                  <div id="low-priority-day-error">&nbsp;</div>
               </div>
               <span class=""></span>
            </div>
         </div>
         <div class="col-md-4">
            <label class="add-client-bx">Medium priority</label>
            <div class="row">
               <div class="col-md-6">
                  <label>Percentage</label>
                  <input type="number" min="0" max="100"class="form-control fld priority" id="medium-percentage" name="medium-percentage" onkeyup="percentageVaidation(this.id,this.value,'medium')">
                  <div id="medium-priority-percentage-error">&nbsp;</div>
               </div>
               <div class="col-md-6">
                  <label>Days</label>
                  <input type="number"min="0" max="365"class="form-control fld priority" id="medium-days" name="medium-days" onkeyup="daysVaidation(this.id,this.value,'medium')" onkeydown="allow_only_number(this.id,this.value)">
                  <div id="medium-priority-day-error">&nbsp;</div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <label class="add-client-bx">High priority</label>
            <div class="row">
               <div class="col-md-6">
                  <label>Percentage</label>
                  <input type="number" min="0" max="100" class="form-control fld priority" id="high-percentage" name="high-percentage" onkeyup="percentageVaidation(this.id,this.value,'high')">
                  <div id="high-priority-percentage-error">&nbsp;</div>

               </div>
               <div class="col-md-6">
                  <label>Days</label>
                  <input type="number" min="0" max="365"class="form-control fld priority" id="high-days" name="high-days" onkeyup="daysVaidation(this.id,this.value,'high')" onkeydown="allow_only_number(this.id,this.value)">
                
                  <div id="high-priority-day-error">&nbsp;</div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 text-right">
            <div id="package-component-error"></div>
            <div class="sbt-btns" id="form-button-area">
               <input type="hidden" min="0" max="365"class="form-control fld clietn_id" id="clietn-id" name="clietn-id">
               <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a> 
               <button onclick="insertClientTat()" id="client-submit-btn" class="btn bg-blu btn-submit-cancel">SAVE</button>
            </div>
         </div>
      </div>
   </div>
</div>
</section>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client/add-client-tat.js"></script>