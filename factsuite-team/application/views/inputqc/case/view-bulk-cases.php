
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt"> 
        <h3>View All Cases</h3>
          <div class="table-responsive mt-3" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Number Of Candidate</th> 
                <th>Client Name</th> 
                <th>Client Remarks</th> 
                <th>Cases</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data-1"> 
               <?php 
               $i = 1;
               if (count($bulk)) {
                  foreach ($bulk as $key => $val) {
                    ?>
                    <tr>
                       <td><?php echo $i++; ?></td>
                       <td><?php echo $val['number_of_candidate']; ?></td>
                       <td><?php echo $val['client_name']; ?></td>
                        <td><?php echo $val['client_remarks']; ?></td>
                       <td>
                          <?php  
                               echo "<span><a onclick='downloadAll(\"".$val['bulk_files']."\")' href='#".$val['bulk_files']."'><i class='fa fa-download'></i></a></span>";
                          
                         
                          ?>
                       </td>
                    </tr>
                    <?php 
                  }
               }
               ?>
            </tbody>
          </table>
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

 