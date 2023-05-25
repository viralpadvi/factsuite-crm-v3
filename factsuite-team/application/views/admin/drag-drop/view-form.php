 
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt">
       
        <div class="table-responsive mt-3" id="">
          <table class="table-fixed  datatable table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Form Name</th>  
                <th class="d-none" >View Form</th>
                <th>Created Date</th>  
                <th>Edit</th>  
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable" id="get-form-data"> 
               <?php 
                  $i = 1;
                  if (count($form) > 0) {
                    foreach ($form as $key => $value) {
                       ?>
                       <tr>
                          <td><?php echo ($i++); ?></td>
                          <td><?php echo $value['form_name']; ?></td>
                          <td class="d-none" ><a class="btn btn-small btn-info" href="#" onclick="lord_json()"> <i class="fa fa-eye"></i></a> <?php echo $value['form_path']; ?></td>
                          <td><?php echo date('d-m-Y', strtotime($value['created_date'])); ?></td>
                           <td ><a class="btn btn-small btn-info" href="<?php echo $this->config->item('my_base_url');?>factsuite-admin/edit-form-builder/<?php echo $value['form_id']; ?>"> <i class="fa fa-pencil text-white"></i></a></td>
                       </tr>
                       <?php 
                    }
                  }
               ?>
            </tbody>
          </table>
        </div>
        <!--View Client Content-->
     </div>
  </div>
</section>
<!--Content-->

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
 

<!-- Delete Blog Modal Starts -->
  <div class="modal fade" id="delete-client-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h4 class="modal-title-edit-coupon modal-title-delete">Are you sure you want to  change client access?</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2">
            <div id="view-edit-cancel-btn-div" class="col-md-12 mt-2 text-center">
              <button class="btn btn-add btn-danger btn-delete text-white mt-0 modal-btn-gap" id="delete-client-btn">Delete</button>
              <button class="btn btn-default btn-close" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Delete Blog Modal Ends -->
<script src="<?php echo base_url() ?>assets/custom-js/form-builder/form-builder.min.js"></script> 
 <script src="<?php echo base_url() ?>assets/custom-js/form-builder/form-render.min.js"></script> 

<script>
   // const formData ='';
   function lord_json(){
       $.getJSON(img_base_url+'../uploads/jsonFile.json', function(data) {
         $("#myModal-show").modal('show'); 
         const escapeEl = document.createElement("textarea");
          const code = document.getElementById("view-img");
         // formData = data;
                // $("#view-img").formRender({ data });
                  const addLineBreaks = html => html.replace(new RegExp("><", "g"), ">\n<");

  // Grab markup and escape it
  const $view_img = $("<div/>");
  $view_img.formRender({ data });

  // set < code > innerText with escaped markup
  code.innerText = addLineBreaks($view_img.formRender("html"));

  hljs.highlightBlock(code);
               });
   }

  
</script>

 