function view_document_modal(url){ 
    // var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src",url);

    let html = '';
     
    // html += '<a download class="btn bg-blu text-white" href="'+url+'">'
    // html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
    // html += '</a>';
    html += '<a class="btn bg-blu text-white mt-2" target="_blank" href="'+url+'">'
    html += '<i class="fa fa-eye" aria-hidden="true">&nbsp;View Document in separate tab</i>'
    html += '</a>';


    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}

function exist_view_image(image,path){
    $("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}

$("#view_vendor_log").on('click',function(){
  $("#view_vendor_log_dailog").modal('show');
  var component_id = $("#component_id").val();
  var case_id = $("#candidate_id_hidden").val(); 
  $.ajax({
    type: "POST",
      url: base_url+"admin_Vendor/get_all_vendor_logs", 
      data:{case_id:case_id,component_id:component_id},
      dataType: "json",
      success: function(data){ 
        // console.log(JSON.stringify(data));
    let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
          // var components = JSON.parse(data[i]['component_name']);
          html += '<tr>'; 
          html += '<td>'+j+'</td>';
          html += '<td>'+data[i]['vendor_name']+'</td>';  
          html += '<td>'+data[i]['component_name']+'</td>'; 
          html += '<td>'+data[i]['created_date']+'</td>'; 
          html += '</tr>'; 
       
          j++; 
        }
      }else{
        html+='<tr><td colspan="5" class="text-center">Not Found.</td></tr>'; 
    }
    $('#list_vendor_log_data').html(html); 
      } 
  });

});

/**/

 $("#view_mail_send_box").on('click',function(){
  $("#employee-SendMail").modal('show');
 });

 $('#employee-mail-box-btn').on('click',function(){
  $to_mail = $("#employee-to-mail").val();
  $subject = $("#employee-subject").val();
  $message = CKEDITOR.instances['employee-mail-box'].getData();

  if ($to_mail =='' || $subject  =='') {
    return false;
  }
  var formdata = new FormData();
    formdata.append('to',$to_mail);
    formdata.append('subject',$subject);
    formdata.append('message',$message);
  $.ajax({
          type: "POST",
          url: base_url+"analyst/sent_employee_mail",
          data:formdata,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(data) {
              $('#employee-SendMail').modal('hide');
              $("#employee-to-mail").val('');
             $("#employee-subject").val('');
              if (data.status == '1') {
                $('#action_status_error').html('')
                toastr.success('successfully sent mail.');   
              }else{
                toastr.error('Something went wrong while sent mail. Please try again.');   
              }  
          }
        });

 });

 