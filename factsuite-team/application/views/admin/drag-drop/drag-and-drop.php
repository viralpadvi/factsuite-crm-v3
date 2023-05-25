 
<section id="pg-cntr"> 
<div class="pg-cnt"> 
<div style="margin-top: 200px;">
  <h5>Form Builder</h5> 
  <input type="text" id="form-name" class="fld col-md-6" placeholder="Enter Template Name." name="">
  <div id="form-name-error"></div>
</div>
<!-- Builder Wrap -->
   <!-- <div class="build-wrap form-wrapper-div"></div> -->

   <div id="build-wrap" class="my-2 " ></div>

<button class="btn bg-blu text-white" id="getJSON">Save Form</button>
<button class="btn btn-secondary text-white" id="show-data">Show Data</button>
<button class="btn btn-dark" id="trash">Clear</button>

<div class="render-wrap mb-4"></div>
</div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
 <script src="<?php echo base_url() ?>assets/custom-js/form-builder/form-builder.min.js"></script>  
 <script src="<?php echo base_url() ?>assets/custom-js/form-builder/form-render.min.js"></script>  
<script>
/*jQuery($ => {
  $('.build-wrap').formBuilder()
})*/
 // jQuery($ => {
 const fbEditor = document.getElementById('build-wrap') 
// const formBuilder = $(fbEditor).formBuilder({formData})

 var options = {
    showActionButtons: false,
    // defaultFields: formData
  };
 const formBuilder = $(fbEditor).formBuilder(options)

document.getElementById('getJSON').addEventListener('click', function() {
    var fm = formBuilder.actions.getData('json', true); 
    var form_name = $("#form-name").val();
      if (form_name !='' && form_name !=null && fm !='[]') { 
      save_json_data(fm);
      }else{
        $("#form-name-error").html("<span class='text-danger'>Please enter template name.</span>");
      }
});
document.getElementById('show-data').addEventListener('click', function() {
   formBuilder.actions.showData();
});
document.getElementById('trash').addEventListener('click', function() {
    formBuilder.actions.clearFields()
});
 
formBuilder.setData({formData});
function save_json_data(formData){
   $("#form-name-error").html("");
   var form_name = $("#form-name").val(); 
     $.ajax({  
            url:base_url+'team/save_json_data',  
            method: 'post',  
            dataType: 'json',  
            data: {js:formData,form_name:form_name},  
            success: function (data) {   
                toastr.success('successfully form update.')
                setInterval(function(){ 
                window.location.href = base_url+'factsuite-admin/view-form-builder';
                },2000)
            },  
            error: function (err) {   
                  
            }  
        }); 
}

/**
 * Toggles the edit mode for the demo
 * @return {Boolean} editMode
 */
function toggleEdit(editing) {
  document.body.classList.toggle("form-rendered", !editing);
}

document.getElementById("edit-form").onclick = function () {
  toggleEdit(true);
};
</script>

</section>
<!--Content--> 