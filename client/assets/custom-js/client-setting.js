

function addtimezone() {
	var timezone = $("#add-timezone").val();
	var clock = $("#add-clock").val();
	var time_type = $("#add-time-type").val();
	var time_formate = $("#add-time-formate").val(); 
	if(timezone != '') {
		$('#timezone-error-msg-div').html('');
		$.ajax({
			type: "POST",
	  	url: base_url+"cases/add_timezone",
	  	data:{ 
	  		timezone:timezone,
	  		clock:clock,
	  		time_type:time_type,
	  		time_formate:time_formate,
	  	},
	  	dataType: "json",
	  	success: function(data) {
	   		$('#add_timezone').modal('hide'); 	
	      if (data.status =='1') { 
		      toastr.success('Timezone updated successfully.');
				} else {
		      toastr.error('Something went wrong with inserting the data. Please try again.');
				}
	    },
	    error: function(data) { 
	    	toastr.error('Something went wrong with inserting the data. Please try again.');
	    } 
	  });
	} else {
		$('#timezone-error-msg-div').html('<span class="text-danger error-msg-small">Please select a timezone.</span>');
		if(client_id != '') {
			$('#select-client-error').html('<span class="text-danger error-msg-small">Please fill the date.</span>');
		}
		 
	}
	
}

edit_timezone();
function edit_timezone() {  
  $.ajax({
    type: "POST",
    url: base_url+"cases/get_timezone/",  
    dataType: "json",
    success: function(data) {
    	if (data != '' && data != 'null' && data != null) {
    		// $("#edit-client_id").val(data[0].client_id);
				$("#add-timezone").val(data.timezone);
				$("#add-clock").val(data.clock_type);
				$("#add-time-type").val(data.time_formate);
				$("#add-time-formate").val(data.date_formate); 
    	}
    }
  });
}


function updateData(){ 
	var time_id = $("#time_id").val();
	var client_id = $("#edit-client_id").val();
	var timezone = $("#edit-timezone").val();
	var clock = $("#edit-clock").val();
	var time_type = $("#edit-time-type").val();
	var time_formate = $("#edit-time-formate").val(); 

	if(time_id != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"holiday/update_timezone",
	  	data:{
	  		time_id:time_id,
	  		client_id:client_id,
	  		timezone:timezone,
	  		clock:clock,
	  		time_type:time_type,
	  		time_formate:time_formate,
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#edit_timezone').modal('hide'); 	
	        if (data.status == '1') {
	        	load_data();
	        	  
		        toastr.success('Timezone successfully updated.');
			} else {
		         
		        toastr.error('Something went wrong with updating the data. Please try again.');
			} 
	    },
	    error: function(data){ 	
	    	toastr.error('Something went wrong with updating the data. Please try again.');
	    } 
	  });
	}else{
		if(time_id != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the date.</span>');
		}
		 
	}
	
}

 



function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"holiday/remove_timezone/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		// $('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Timezone deleted successfully.');
			} else {
		         
		        toastr.error('Something went wrong with deleting the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with deleting the data. Please try again.');
	    } 
	  });
	 
	
}




