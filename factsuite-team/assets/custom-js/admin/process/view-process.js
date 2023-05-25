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
	  	url: base_url+"Process_Guidline/view_process_guidline", 
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
        	html += '<td>'+data[i]['fs_crm_component_name']+'</td>'; 
        	html += '<td>'+data[i]['process_name']+'</td>'; 
        	html += '<td> <a target="_blank" href="'+img_base_url+'../uploads/process-docs/'+data[i]['process_attachment']+'" ><i class="fa fa-eye"></i></a></td>'; 
        	 
        	html += '<td ><a  onclick="edit_role('+data[i]['process_id']+')"  href="#"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</div><a onclick="removeData('+data[i]['process_id']+')" href="#"><i class="fa fa-trash"></i></a></td>';
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No Guideline Found.</td></tr>'; 
    }
    $('#get-team-data').html(html); 
	  	} 
	});
}





function addprocess(){
	 
	var process_name = $("#process_name").val();
	var component_name = $("#component_name").val();
	var attachment = $('#attachment')[0].files[0];

	var formdata = new FormData();
		formdata.append('process_name',process_name);
		formdata.append('component',component_name);
		formdata.append('attachment[]',attachment);

	if(process_name != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"Process_Guidline/add_process_guidline",
	  	data:formdata,
      dataType: 'json',
      contentType: false,
      processData: false, 
	  	success: function(data){
	   		$('#add_holiday').modal('hide'); 	
	        if (data.status == '1') {
	        	$("#process_name").val('')
	        	$("#component_name").val('')
	        	$("#attachment").val('')
	        	load_role();
	        	 candidate_aadhar = [];
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('process guidline inserted successfully.');
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
		if(process_name != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the process guidline.</span>');
		}
		 
	}
	
}
 

function edit_role(id){
  $('#edit_holiday').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"Process_Guidline/get_process_details/"+id, 
    dataType: "json",
    success: function(data){  
      	$('#edit_process_name').val(data.process_name); 
      	$('#edit_component_name').val(data.process_component);  
      	$('#edit_process_id').val(id); 
    }
  });
}

$("#edit_attachment").on("change", handleFileSelect_candidate_aadhar); 
$("#attachment").on("change", handleFileSelect_candidate_aadhar); 

var candidate_aadhar = [];
function handleFileSelect_candidate_aadhar(e){ 
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files);  
    var j = 1;  
    for (var i = 0; i < files.length; i++) { 
            candidate_aadhar.push(files[i]);  
    }  
}


function updateData(){
	 
	var process_id = $("#edit_process_id").val();
	var process_name = $("#edit_process_name").val();
	var component_name = $("#edit_component_name").val();
	var attachment = $('#edit_attachment')[0].files[0];

	var formdata = new FormData();
		formdata.append('process_id',process_id);
		formdata.append('process_name',process_name);
		formdata.append('component',component_name);
		if (candidate_aadhar.length > 0) {
			for (var i = 0; i < candidate_aadhar.length; i++) { 
				formdata.append('attachment[]',candidate_aadhar[i]);
			}
		}else{
			formdata.append('attachment[]','');
		}

	if(process_name != ''){
		$.ajax({
		type: "POST", 
	  	url: base_url+"Process_Guidline/edit_process_guidline",
	  	data:formdata,
      dataType: 'json',
      contentType: false,
      processData: false, 
	  	success: function(data){
	   		 $('#edit_holiday').modal('hide');
	        if (data.status == '1') {
	        	load_role();
	        	$("#edit_attachment").val('')
	        	  candidate_aadhar = [];
		        toastr.success('process updated successfully.');
			} else {
		         
		        toastr.error('Something went wrong with updating the data. Please try again.');
			} 
	    },
	    error: function(data){
	       $('#edit_holiday').modal('hide');	
	    	toastr.error('Something went wrong with updating the data. Please try again.');
	    } 
	  });
	}else{
		if(process_name != ''){
			$('#edit_process_name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the process.</span>');
		}
		 
	}
	
}




function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"Process_Guidline/remove_process/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){ 	
	        if (data.status == '1') {
	        	load_role();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('process deleted successfully.');
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
