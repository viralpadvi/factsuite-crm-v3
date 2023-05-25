load_mandate();

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
        	 
        	
        	html += '<td ><a  onclick="edit_mandate('+data[i]['mandate_id']+')"  href="#"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</div></td>';
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



$('#client_name').on('change',function(){  
	getPackage($(this).val())
});
 

function getPackage(id){
	// alert(id)
	$.ajax({
		type: "POST",
	  	url: base_url+"inputQc/getPackage/", 
	  	data:{
	  		clinet_id:id
	  	},
	  	dataType: "json",
	  	success: function(data){ 
	  		
	  		var html = '';

	  		html += '<option selected value="">Select your package</option>';
	  		if(data.length > 0){ 
	  			for(var i=0; data[0].package_ids.length > i ;i++){
	  				html += '<option value="'+data[0].package_ids[i]+'">'+data[0].package_name[i]+'</option>';
	  			}

	  		}else{
	  			html += '<option value="">No package avilable</option>';
	  		}

	  		$('#package_id').html(html)
	  	}
	});

}


$('#package_id').on('change',function(){ 
	getPkgdata($(this).val())
	
});



function getPkgdata(id=''){ 


	var client_id  = $('#client_name').val();
	
	if(id != '' && client_id !=''){
	  $.ajax({
	    type: "POST",
	    url: base_url+"package/get_single_component_data/"+id+"/"+client_id, 
	    dataType: "json",
	    async:false,
	    success: function(data){ 
	    	console.log(JSON.stringify(data.client.package_components))
	    	var package_components = JSON.parse(data.client.package_components);
	    	// alert(package_components.length)
	    	

	      	var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
	      	
			
	      	// return false;
	      	$('#edit_package_id').val(id);
			var package = $('#package_id').val();
	      	let comp='';
	      
	      	for (var i = 0; i < package_components.length; i++) {
			if (package_components[i]['package_id'] == package) {
	      		
	      	/*	var arr ='';
				if (data['package_data'][0].component_ids !='') {
					arr = data['package_data'][0].component_ids.split(',');
				}
				
				let checked = ''; 
				let disabled ='disabled';
	      		let optionShowValue = 'Form';
	      		if (jQuery.inArray(data['components'][i].component_id, arr)!='-1') {  
					checked = 'checked';	 	
					disabled = '';

				} */


			    	var component =  package_components[i].component_name;
			    	var component_name = component.replaceAll(/\s+/g, '_').trim();
 
				
	      		comp +='<div class="col-md-4">'
			      	comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
				    comp +='<input   type="checkbox" data-component_name="'+package_components[i].component_name+'" onclick="select_skill_form('+package_components[i].component_id+')"';
					    comp +='class="custom-control-input components" value="'+package_components[i].component_id+'" ';
					    comp +='name="componentCheck" id="componentCheck'+package_components[i].component_id+'">';
				    comp +='<label class="custom-control-label" for="componentCheck'+package_components[i].component_id+'">'+package_components[i].component_name
					comp +='</label>'
			    comp +=' </div>'
			    // editcomponentCheck
			     comp += '<div>';
			     comp += '<input type="text" id="component-text-'+package_components[i].component_id+'" class="form-control" placeholder="Add Comment" >';

			     comp += '</div>';
				comp += ''
	      		comp +=' </div>'
	      	}}
	    	$('#components_ids').html(comp)
	    }
	  });
	 
	}else{
		let comp='';
		comp +='<div class="col-md-4">'
			
	    comp +=' </div>'
	    $('#components_ids').html(comp)
	}
}



function add_mandate(){
	 
	var client_name = $("#client_name").val();
	var package_id = $("#package_id").val();
	var description = CKEDITOR.instances['mandate-description'].getData();
	var instruction = CKEDITOR.instances['mandate-instruction'].getData();


	var component = [];
	$(".components:checked").each(function(){
		var id = $(this).val();
		var component_name = $(this).data('component_name');
		var form_value = $("#component-text-"+$(this).val()).val(); 
		component.push({component_id:$(this).val(),component_name:component_name,form_values:form_value});
	 
	}); 


	if(client_name != '' && description !='' && component.length > 0 && package_id !=''){
		$.ajax({
		type: "POST",
	  	url: base_url+"mandate/insert_mandate",
	  	data:{
	  		client_name:client_name,
	  		description:description,
	  		package_id:package_id,
	  		instruction:instruction,
	  		component:JSON.stringify(component)
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_mandate').modal('hide'); 	
	        if (data.status == '1') {
	        	load_mandate();
	        	$("#client_name").val('');
	        	$("#package_id").val('');
						CKEDITOR.instances['mandate-description'].setData('');
						$('#components_ids').html('')
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('mandate data successfully added.');
			} else {
		         
		        toastr.error('Something went wrong with inserting the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#add_mandate').modal('hide'); 	
	    	toastr.error('Something went wrong with inserting the data. Please try again.');
	    } 
	  });
	}else{
		if(role_name != ''){
			$('#mandate-name-error-msg-div').html('<span class="text-danger error-msg-small">Please select the Client name.</span>');
		}
		 
	}
	
}
 

function edit_mandate(id){
  $('#edit_mandate').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"mandate/get_mandate_details/"+id, 
    dataType: "json",
    success: function(data){ 
    	// console.log(JSON.stringify(data)); 

      	$('#edit_mandate_id').val(id); 
      	var client_name = $("#edit-client_name").val(data.client_id);
      	edit_package_name(data.client_id,data.package_id);
      	geteditPkgdata(data.package_id,data.component_comments)
			var description = CKEDITOR.instances['edit-mandate-description'].setData(data.mandate_description);
			var instruction = CKEDITOR.instances['edit-mandate-instruction'].setData(data.instruction);
    }
  });
}


function edit_package_name(client_id,package_id){ 
	$.ajax({
		type: "POST",
	  	url: base_url+"inputQc/getPackage/", 
	  	data:{
	  		clinet_id:client_id
	  	},
	  	dataType: "json",
	  	success: function(data){  
	  		var html = '';

	  		html += '<option selected value="">Select your package</option>';
	  		if(data.length > 0){ 
	  			for(var i=0; data[0].package_ids.length > i ;i++){
	  				$select = '';
	  				if (data[0].package_ids[i] == package_id) {
	  					$select = 'selected';
	  				}
	  				html += '<option '+$select+' value="'+data[0].package_ids[i]+'">'+data[0].package_name[i]+'</option>';
	  			}

	  		}else{
	  			html += '<option value="">No package avilable</option>';
	  		} 
	  		$('#edit-package_id').html(html)
	  	}
	});

}



function geteditPkgdata(id,components){ 
 $component = JSON.parse(components);
	var client_id  = $('#edit-client_name').val();
	
	if(id != '' && client_id !=''){ 
	  $.ajax({
	    type: "POST",
	    url: base_url+"package/get_single_component_data/"+id+"/"+client_id, 
	    dataType: "json",
	    async:false,
	    success: function(data){ 
	    	console.log(JSON.stringify(data.client.package_components))
	    	var package_components = JSON.parse(data.client.package_components);
	    	// alert(package_components.length)
	    	

	      	var edit_package_name = $('#edit_new_package_name').val(data['package_data'][0].package_name); 
	      	
			
	      	// return false;
	      	$('#edit_new_package_id').val(id);
			var package = $('#edit-package_id').val();
	      	let comp='';
	      
	      	for (var i = 0; i < package_components.length; i++) {
			if (package_components[i]['package_id'] == package) {
	      		
	      	/*	var arr ='';
				if (data['package_data'][0].component_ids !='') {
					arr = data['package_data'][0].component_ids.split(',');
				}
				
				let checked = ''; 
				let disabled ='disabled';
	      		let optionShowValue = 'Form';
	      		if (jQuery.inArray(data['components'][i].component_id, arr)!='-1') {  
					checked = 'checked';	 	
					disabled = '';

				} */


			    	var component =  package_components[i].component_name;
			    	var component_name = component.replaceAll(/\s+/g, '_').trim();
 	// let carIndex = $component.findIndex( filterCarObj=> 
    // filterCarObj['components_id'] === package_components[i].component_id);
  // let carIndex =	$component.indexOf(package_components[i].component_id)
  var index =getKeyByLanguages($component,package_components[i].component_id);
   //$component.map(function (component_ids) { return component_ids.components_id; }).indexOf("'"+package_components[i].component_id+"'");
				// alert(index);
				$select ='';
				$val = '';
				if (index !='-1') {
					$select = 'checked';
					$val = $component[index].form_values;
				}
	      		comp +='<div class="col-md-4">'
			      	comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
				    comp +='<input  '+$select+' type="checkbox" data-component_name="'+package_components[i].component_name+'" onclick="select_skill_form('+package_components[i].component_id+')"';
					    comp +='class="custom-control-input components" value="'+package_components[i].component_id+'" ';
					    comp +='name="componentCheck" id="componentCheck'+package_components[i].component_id+'">';
				    comp +='<label class="custom-control-label" for="componentCheck'+package_components[i].component_id+'">'+package_components[i].component_name
					comp +='</label>'
			    comp +=' </div>'
			    // editcomponentCheck
			     comp += '<div>';
			     comp += '<input type="text" value="'+$val+'" id="component-text-'+package_components[i].component_id+'" class="form-control" placeholder="Add Comment" >';

			     comp += '</div>';
				comp += ''
	      		comp +=' </div>'
	      	}}
	    	$('#edit_components_ids').html(comp)
	    }
	  });
	 
	}else{
		let comp='';
		comp +='<div class="col-md-4">'
			
	    comp +=' </div>'
	    $('#edit_components_ids').html(comp)
	}
}

var getKeyByLanguages = function(obj, lang) {
    var returnKey = -1;

    $.each(obj, function(key, info) {
        if (info.component_id == lang) {
           returnKey = key;
            return false; 
        };   
    });
    
    return returnKey;       
           
}

function updateData(){
	 var mandate = $('#edit_mandate_id').val(); 
		var client_name = $("#edit-client_name").val();
			var description = CKEDITOR.instances['edit-mandate-description'].getData();
			var instruction = CKEDITOR.instances['edit-mandate-instruction'].getData();
    	var package_id = $("#edit-package_id").val();

	var component = [];
	$(".components:checked").each(function(){
		var id = $(this).val();
		var component_name = $(this).data('component_name');
		var form_value = $("#component-text-"+$(this).val()).val(); 
		component.push({component_id:$(this).val(),component_name:component_name,form_values:form_value});
	 
	}); 

	if(mandate != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"mandate/update_mandate",
	  	data:{
	  		mandate_id:mandate,
	  		client_name:client_name,
	  		description:description,
	  		package_id:package_id,
	  		instruction:instruction,
	  		component:JSON.stringify(component) 
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#edit_mandate').modal('hide'); 	
	        if (data.status == '1') {
	        	component = [];
	        	$("#edit_components_ids").html('')
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
			$('#client-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the Client name.</span>');
		}
		 
	}
	
}




function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"role/remove_role/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		$('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Role deleted successfully.');
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
