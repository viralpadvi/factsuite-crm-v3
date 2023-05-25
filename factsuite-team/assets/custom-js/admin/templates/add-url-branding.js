
// getTatData();
$("#client_id").trigger('change')
function getTatData(client_id){
   $("#url").val(''); 
	$(".change_client_additional").prop("checked", false);
	$("#selected-vendor-docs-li").html('');
	if (client_id =='') {
		client_id = $("#client_id").val();
	}
	var templates = $("#templates").val();
	$.ajax({
		type:'POST',
		dataType:'json',
		url:base_url+"client/get_url_branding",
		data:{
			client_id:client_id,
			templates:templates,
		},
		success:function(data){    
				$("#url").val(data.url); 
		} 
	});
}
 
function confirmationDailg(){
	 
	var templates = $("#templates").val();
	var client_id = $("#client_id").val();
	var url = $("#url").val(); 
	var formdata = new FormData();
		formdata.append('client_id',client_id);
		formdata.append('url',url);
		formdata.append('templates',templates); 

	if(client_id != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"Client/add_url_branding",
	  	data:formdata,
      dataType: 'json',
      contentType: false,
      processData: false, 
	  	success: function(data){
	   		$('#add_holiday').modal('hide'); 	
	        if (data.status == '1') {
	        	$("#templates").val('')
	        	$("#client_id").val('')
	        	$("#url").val();  
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Consent Data is Updated.');
			} else {
		         
		        toastr.error('Something went wrong with inserting the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with inserting the data. Please try again.');
	    } 
	  });
	}else{
		if(client_id != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the details.</span>');
		}
		 
	}
	
}
 
