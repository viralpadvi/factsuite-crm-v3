load_role();

$('#component_name').on('keyup blur',function(){
	var component_name = $('#component_name').val(); 
	if (component_name != '') {
		$('#component-name-error-msg-div').html('');
	} else {
		$('#component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
	}
}); 

$('#component_price').on('keyup blur',function(){
	var component_price = $('#component_price').val(); 
	if (component_price != '') {
		$('#component-price-error-msg-div').html('');
	} else {
		$('#component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component price.</span>');
	}
}); 


$('#edit_component_name').on('keyup blur',function(){
	var edit_component_name = $('#edit_component_name').val(); 
	if (edit_component_name != '') {
		$('#edit-component-name-error-msg-div').html('');
	} else {
		$('#edit-component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
	}
}); 

$('#edit_component_price').on('keyup blur',function(){
	var edit_component_price = $('#edit_component_price').val(); 
	if (edit_component_price != '') {
		$('#edit-component-price-error-msg-div').html('');
	} else {
		$('#edit-component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component price.</span>');
	}
}); 

function load_role(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"holiday/get_holiday_details", 
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
        	html += '<td>'+moment(data[i]['holiday_date']).format('DD/MM/YYYY')+'</td>'; 
        	html += '<td><a  onclick="edit_holiday('+data[i]['holiday_id']+')"  href="#"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</div><a onclick="removeData('+data[i]['holiday_id']+')" href="#"><i class="fa fa-trash"></i></td>';  
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="2" class="text-center">No dates found.</td></tr>'; 
    }
    $('#get-team-data').html(html); 
	  	} 
	});
}





function addholiday(){
	 
	var holiday = $("#holiday").val();

	if(holiday != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"holiday/add_holiday",
	  	data:{
	  		holiday:holiday
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_holiday').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
	        	$("#holiday").val('')
	        	 
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Holiday date inserted successfully.');
			} else {
		         
		        toastr.error('Something went wrong with inserting the data. Please try again.');
			} 
	    },
	    error: function(data){ 
	    	toastr.error('Something went wrong with inserting the data. Please try again.');
	    } 
	  });
	}else{
		if(holiday != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the date.</span>');
		}
		 
	}
	
}




function edit_holiday(id){ 
  $('#edit_holiday').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"holiday/get_holiday_details/"+id, 
    dataType: "json",
    success: function(data){ 
    	// console.log(JSON.stringify(data));
      	var holiday_date = $('#edit_holiday_date').val(data.holiday_date); 
      	$('#edit_holiday_id').val(id); 
    }
  });
}



function updateData(){
	 
	var holiday_date = $("#edit_holiday_date").val();
	var edit_holiday_id = $("#edit_holiday_id").val();

	if(holiday_date != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"holiday/update_holiday",
	  	data:{
	  		holiday_id:edit_holiday_id,
	  		holiday_date:holiday_date 
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#edit_holiday').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
	        	  
		        toastr.success('holiday successfully updated.');
			} else {
		         
		        toastr.error('Something went wrong with updating the data. Please try again.');
			} 
	    },
	    error: function(data){ 	
	    	toastr.error('Something went wrong with updating the data. Please try again.');
	    } 
	  });
	}else{
		if(holiday_date != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the date.</span>');
		}
		 
	}
	
}




function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"holiday/remove_holiday/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		// $('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('holiday deleted successfully.');
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

  