load_component();

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

function load_component(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"package/get_package_details", 
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
        	html += '<td>'+data[i]['package_name']+'</td>';
        	html += '<td>'+data[i]['component_name']+'</td>';
        	if(data[i]['package_status'] == 1){
        		html += '<td>Activate</td>';
        	}else{
        		html += '<td>Deactivate</td>';
        	}
        	
        	html += '<td><a  onclick="edit_package('+data[i]['package_id']+')"  href="#"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</div><a onclick="removeData('+data[i]['package_id']+')" href="#"><img src="assets/admin/images/delete.png" /></a></td>';
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No team Found.</td></tr>'; 
    }
    $('#get-team-data').html(html); 
	  	} 
	});
}





function addPackage(){
	
	var component_ids = GetSelected();
	var package_name = $("#package_name").val();

	if(package_name != '' && component_ids.length > 0){
		$.ajax({
		type: "POST",
	  	url: base_url+"package/insert_package",
	  	data:{
	  		package_name:package_name,
	  		component_ids:component_ids
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_package').modal('hide'); 	
	        if (data.status == '1') {
	        	load_component();
	        	$("#package_name").val('')
	        	$("[name='componentCheck']").each(function (index, data) {
	        		data.checked = false;
			        // if (data.checked) { 
			        //     components.push(data.value); 
			        // }
    			}); 
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Package inserted successfully.');
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
		if(package_name != ''){
			$('#package-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the package name.</span>');
		}
		if(component_ids.length > 0){
			$('#package-price-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least one component.</span>');
		}
	}
	
}

function GetSelected() {
    var components = new Array();
    $("[name='componentCheck']").each(function (index, data) {
        if (data.checked) { 
            components.push(data.value); 
        }
    }); 
    return components;
}


function edit_package(id){
  $('#edit_package').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"package/get_single_component_name/"+id, 
    dataType: "json",
    success: function(data){ 
      var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
      $('#edit_package_id').val(id);

      let comp='';
       
      for (var i = 0; i < data['components'].length; i++) {

      		
      		var arr ='';
			if (data['package_data'][0].component_ids !='') {
				arr = data['package_data'][0].component_ids.split(',');
			}
      		if (jQuery.inArray(data['components'][i].component_id, arr)!='-1') {  
					 
				comp +='<div class="col-md-4">'
		      		comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
			      		comp +='<input checked type="checkbox" class="custom-control-input components" value="'+data['components'][i].component_id+'" name="componentCheck" id="editcomponentCheck'+data['components'][i].component_id+'" onclick="GetSelected()">'
			      		comp +='<label class="custom-control-label" for="editcomponentCheck'+data['components'][i].component_id+'">'+data['components'][i].component_name
			      		comp +='</label>'
		      		comp +=' </div>'
      			comp +=' </div>'

			}else{

				comp +='<div class="col-md-4">'
		      		comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
			      		comp +='<input type="checkbox" class="custom-control-input components" value="'+data['components'][i].component_id+'" name="componentCheck" id="editcomponentCheck'+data['components'][i].component_id+'" onclick="GetSelected()">'
			      		comp +='<label class="custom-control-label" for="editcomponentCheck'+data['components'][i].component_id+'">'+data['components'][i].component_name
			      		comp +='</label>'
		      		comp +=' </div>'
      			comp +=' </div>'

			} 
      		 
      		
      		 
      }
     $('#componentCheckbox').html(comp);   
    }
  });
}



function updateData(){
	var component_ids = GetSelected(); 
	var edit_package_name = $("#edit_package_name").val();
	var edit_package_id = $("#edit_package_id").val();

	if(package_name != '' && component_ids.length > 0){
		$.ajax({
		type: "POST",
	  	url: base_url+"package/update_package",
	  	data:{
	  		package_id:edit_package_id,
	  		package_name:edit_package_name,
	  		component_ids:component_ids
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#edit_package').modal('hide'); 	
	        if (data.status == '1') {
	        	load_component();
	        	  
		        toastr.success('Package updated successfully.');
			} else {
		         
		        toastr.error('Something went wrong with updating the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with updating the data. Please try again.');
	    } 
	  });
	}else{
		if(package_name != ''){
			$('#package-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the package name.</span>');
		}
		if(component_ids.length > 0){
			$('#package-price-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least one component.</span>');
		}
	}
	
}




function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"package/remove_package/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		$('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_component();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Component deleted successfully.');
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
