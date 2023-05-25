

function addnomanclature(){
	 
	var client_id = $("#client_id").val();
	var all_report = $("#add-all").val();
	var red = $("#red").val();
	var green = $("#green").val();
	var orange = $("#orange").val(); 
	if(client_id != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"client/add_nomanclature",
	  	data:{
	  		client_id:client_id,
	  		all_report:all_report,
	  		red:red,
	  		green:green,
	  		orange:orange,
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_nomanclature').modal('hide'); 	
	        if (data.status == '1') {
	        	$("#client_id").val('');
				$("#all-report").val('');
				$("#red").val('');
				$("#green").val('');
				$("#orange").val(''); 
	        	 load_data();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Nomenclature has been successfully inserted.');
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


function edit_nomanclature(id){ 
  $('#edit_nomanclature').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"client/get_nomanclature_details/", 
    data:{nomenclature_id:id},
    dataType: "json",
    success: function(data){  
	      	$("#nomenclature_id").val(data[0].nomenclature_id);
			$("#edit-client_id").val(data[0].client_id);  
			var all_report = $("#edit-all").val(data[0].all_report);
	var red = $("#edit-red").val(data[0].red);
	var green = $("#edit-green").val(data[0].green);
	var orange = $("#edit-orange").val(data[0].orange); 

    }
  });
}


function updateData(){ 
	var nomanclature_id = $("#nomenclature_id").val();
	var client_id = $("#edit-client_id").val();
	var all_report = $("#edit-all").val();
	var red = $("#edit-red").val();
	var green = $("#edit-green").val();
	var orange = $("#edit-orange").val(); 
	if(client_id != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"client/update_nomanclature",
	  	data:{
	  		nomanclature_id:nomanclature_id,
	  		client_id:client_id,
	  		all_report:all_report,
	  		red:red,
	  		green:green,
	  		orange:orange,
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#edit_nomanclature').modal('hide'); 	
	        if (data.status == '1') {
	        	load_data();
	        	  
		        toastr.success('Nomenclature has been successfully updated.');
			} else {
		         
		        toastr.error('Something went wrong with updating the data. Please try again.');
			} 
	    },
	    error: function(data){ 	
	    	toastr.error('Something went wrong with updating the data. Please try again.');
	    } 
	  });
	}else{
		if(nomanclature_id != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the date.</span>');
		}
		 
	}
	
}


 load_data()
function load_data(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"client/get_nomanclature_details", 
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
        	html += '<td>'+data[i]['client_name']+'</td>'; 
        	html += '<td>'+data[i]['all_report']+'</td>'; 
        	html += '<td>'+data[i]['green']+'</td>'; 
        	html += '<td>'+data[i]['orange']+'</td>'; 
        	html += '<td>'+data[i]['red']+'</td>'; 
        		html += '<td><a  onclick="edit_nomanclature('+data[i]['nomenclature_id']+')"  href="#"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</div><a onclick="removeData('+data[i]['nomenclature_id']+')" href="#"><i class="fa fa-trash"></i></td>';  
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="2" class="text-center">No Data found.</td></tr>'; 
    }
    $('#get-team-data').html(html); 
	  	} 
	});
}




function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"client/remove_nomanclature/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		// $('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Nomenclature has been successfully deleted.');
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




