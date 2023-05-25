load_mandate();

$('#component_name').on('keyup blur',function(){
	var component_name = $('#component_name').val(); 
	if (component_name != '') {
		$('#component-name-error-msg-div').html('');
	} else {
		$('#component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please enter component name.</span>');
	}
}); 

$('#component_price').on('keyup blur',function(){
	var component_price = $('#component_price').val(); 
	if (component_price != '') {
		$('#component-price-error-msg-div').html('');
	} else {
		$('#component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please enter component price.</span>');
	}
}); 


$('#edit_component_name').on('keyup blur',function(){
	var edit_component_name = $('#edit_component_name').val(); 
	if (edit_component_name != '') {
		$('#edit-component-name-error-msg-div').html('');
	} else {
		$('#edit-component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please enter component name.</span>');
	}
}); 

$('#edit_component_price').on('keyup blur',function(){
	var edit_component_price = $('#edit_component_price').val(); 
	if (edit_component_price != '') {
		$('#edit-component-price-error-msg-div').html('');
	} else {
		$('#edit-component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please enter component price.</span>');
	}
}); 

function load_mandate(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"mandate/get_all_client_mandate", 
	  	dataType: "json",
	  	success: function(data){ 
	  		console.log(JSON.stringify(data));
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	// var components = JSON.parse(data[i]['component_name']);
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+data[i]['client_name']+'</td>'; 
        	html += '<td>'+data[i]['package_name']+'</td>'; 
        	html += '<td>'+data[i].mandate_description+'</td>';
        	html += '<td>'+data[i].instruction+'</td>';
        	 
        	
        	html += '<td ><a  onclick="view_mandate('+data[i]['mandate_id']+')"  href="#"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;</div></td>';
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="4" class="text-center">No Mandate Found.</td></tr>'; 
    }
    $('#get-team-data').html(html); 
	  	} 
	});
}

 

function add_mandate(){
	 
	var client_name = $("#client_name").val();
	var description = CKEDITOR.instances['mandate-description'].getData();


	if(client_name != '' && description !=''){
		$.ajax({
		type: "POST",
	  	url: base_url+"mandate/insert_mandate",
	  	data:{
	  		client_name:client_name,
	  		description:description
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_mandate').modal('hide'); 	
	        if (data.status == '1') {
	        	load_mandate();
	        	$("#client_name").val('');
						CKEDITOR.instances['mandate-description'].setData('');
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Data are added successfully.');
			} else {
		         
		        toastr.error('Something went wrong with adding the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#add_mandate').modal('hide'); 	
	    	toastr.error('Something went wrong with adding the data. Please try again.');
	    } 
	  });
	}else{
		if(role_name != ''){
			$('#mandate-name-error-msg-div').html('<span class="text-danger error-msg-small">Please select the client name.</span>');
		}
		 
	}
	
}
 

function view_mandate(id){
  $('#edit_mandate').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"mandate/get_mandate_details/"+id, 
    dataType: "json",
    success: function(data){ 
    	// console.log(JSON.stringify(data)); 
    	$("#mandate-description-view").html(data.mandate_description); 
    	var component = JSON.parse(data.component_comments);
    	let comp = '';
    	if (component.length > 0) {
    		for (var i = 0; i < component.length; i++) {
    			
				// comp += '<label>Components</lable>';
	      		comp +='<div class="col-md-4">'
			      	comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
				    comp +='<input  checked disabled type="checkbox" data-component_name="'+component[i].component_name+'" onclick="select_skill_form('+component[i].component_id+')"';
					    comp +='class="custom-control-input components" value="'+component[i].component_id+'" ';
					    comp +='name="componentCheck" id="componentCheck'+component[i].component_id+'">';
				    comp +='<label class="custom-control-label" for="componentCheck'+component[i].component_id+'">'+component[i].component_name
					comp +='</label>'
			    comp +=' </div>'
			    // editcomponentCheck
			     comp += '<div>';
			     comp += '<input type="text" readonly value="'+component[i].form_values+'" id="component-text-'+component[i].component_id+'" class="form-control" placeholder="Add Comment" >';

			     comp += '</div>';
				comp += ''
	      		comp +=' </div>'
    		}
    	}

    	$("#mandate-component-view").html(comp);
      	 }
  });
}



function updateData(){
	 var mandate = $('#edit_mandate_id').val(); 
		var client_name = $("#edit-client_name").val();
			var description = CKEDITOR.instances['edit-mandate-description'].getData();
    

	if(mandate != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"mandate/update_mandate",
	  	data:{
	  		mandate_id:mandate,
	  		client_name:client_name,
	  		description:description 
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#edit_mandate').modal('hide'); 	
	        if (data.status == '1') {
	        	load_mandate();
	        	  
		        toastr.success('mandate successfully updated.');
			} else {
		         
		        toastr.error('Something went wrong with updating the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_mandate').modal('hide'); 	
	    	toastr.error('Something went wrong with updating the data. Please try again.');
	    } 
	  });
	}else{
		if(client_name != ''){
			$('#client-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the client name.</span>');
		}
		 
	}
	
}



 