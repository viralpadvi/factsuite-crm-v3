<?php 
   $client_name = '';
   if ($this->session->userdata('logged-in-client')) {
      $client_name = $this->session->userdata('logged-in-client')['client_name'];
   }
   $client_name = trim(str_replace(' ','-',$client_name));
?>  
   <div class="pg-cnt">
      <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <div id="FS-allcandidates">   
           <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
              <li class="nav-item" role="presentation">
               <a class="nav-link " href="<?php echo $this->config->item('my_base_url').$client_name;?>/bulk-upload" >Add Bulk Cases</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').$client_name;?>/view-bulk-upload" >View bulk</a>
              </li>
            </ul>
              
               <div>
                  <div class="allcandidates-bx">
                     <div class="table-responsive">
                        <table class="datatable table table-striped">
                           <thead class="thead-bd-color">
                              <tr>
                                 <th>Sr No.</th> 
                                 <th>Number of candidate</th>
                                 <th>Remarks</th>
                                 <th>Uploaded Files</th>  
                              </tr>
                           </thead>
                           <tbody class="tbody-datatable" id="get-bulk-upload-list"> 
                              <?php $i = 1;
                              if (count($bulk)) {
                                 foreach ($bulk as $key => $val) { ?>
                                    <tr>
                                       <td><?php echo $i++; ?></td>
                                       <td><?php echo $val['number_of_candidate']; ?></td> 
                                       <td><?php echo $val['client_remarks']; ?></td> 
                                       <td>
                                       <?php  
                                           echo "<span><a onclick='downloadAll(\"".$val['bulk_files']."\")' href='#".$val['bulk_files']."'><i class='fa fa-download'></i></a></span>";
                                      ?>
                                       </td>
                                    </tr>
                              <?php } } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
         </div>
      </div>
   </div>
</section>
<!--Content-->

<script>
   function downloadAll(files){
    if(files.length == 0) return;
    links = files.split(',');
   /* var theAnchor = $('<a />')
        .attr('href', img_base_url+'uploads/bulk-docs/'+file[1])
        .attr('download',img_base_url+'uploads/bulk-docs/'+file[0]);
    theAnchor[0].click(); 
    theAnchor.remove();
    downloadAll(files);*/
    for (var i = 0; i < links.length; i++) {
      var url =img_base_url+'../uploads/bulk-docs/'+links[i];
    /*var frame = document.createElement("iframe");
    frame.src = img_base_url+'../uploads/bulk-docs/'+links[i];
    frame["download"] = 1
    document.body.appendChild(frame); */
      var a = document.createElement("a");
  a.setAttribute('href', url);
  a.setAttribute('download', '');
  a.setAttribute('target', '_blank');
  a.click();
   a.remove();
    }
}
</script>

  