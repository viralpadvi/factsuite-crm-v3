

function addtimezone(){
	  
	var timezone = $("#add-timezone").val();
	var clock = $("#add-clock").val();
	var time_type = $("#add-time-type").val();
	var time_formate = $("#add-time-formate").val(); 
	if(timezone != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"holiday/add_timezone",
	  	data:{ 
	  		timezone:timezone,
	  		clock:clock,
	  		time_type:time_type,
	  		time_formate:time_formate,
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_timezone').modal('hide'); 	
	        if (data.status == '1') { 
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Timezone has been successfully inserted.');
			} else {
		         
		        toastr.error('Something went wrong with inserting the data. Please try again.');
			} 
	    },
	    error: function(data){ 
	    	toastr.error('Something went wrong with inserting the data. Please try again.');
	    } 
	  });
	}else{
		if(client_id != ''){
			$('#select-client-error').html('<span class="text-danger error-msg-small">Please fill the date.</span>');
		}
		 
	}
	
}

edit_timezone()
function edit_timezone(){  
  $.ajax({
    type: "POST",
    url: base_url+"holiday/get_timezone_details/", 
    data:{time_id:0},
    dataType: "json",
    success: function(data){ 
    if (data.length > 0) {  
			$("#add-timezone").val(data[0].timezone);
			$("#add-clock").val(data[0].clock_type);
			$("#add-time-type").val(data[0]['12_24_hr_format']);
			$("#add-time-formate").val(data[0].date_formate); 
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
	        	  
		        toastr.success('Timezone has been successfully updated.');
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
		        toastr.success('Timezone has been successfully deleted.');
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




