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
	  	url: base_url+"role/get_role_details", 
	  	dataType: "json",
	  	success: function(data){ 
	  		// console.log(JSON.stringify(data));
		let html='';
      if (data.length > 0) {
        var j = 1;
        var myarray = ['admin','inputqc','outputqc','analyst','specialist','insuff analyst','finance','am','csm'];
        for (var i = 0; i < data.length; i++) { 
        	// var components = JSON.parse(data[i]['component_name']);
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+data[i]['role_name']+'</td>'; 
        	if(data[i]['role_status'] == 1){
        		html += '<td>Active</td>';
        	}else{
        		html += '<td>Deactive</td>';
        	}
        	if(jQuery.inArray(data[i]['role_name'].toLowerCase(), myarray) == -1){ 
        		html += '<td><a  onclick="edit_role('+data[i]['role_id']+')"  href="#"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</div><a onclick="removeData('+data[i]['role_id']+')" href="#"><i class="fa fa-trash text-danger"></i></a></td>';
        	}else{
        		html += '<td></td>';
        	}
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No Role Found.</td></tr>'; 
    }
    $('#get-team-data').html(html); 
	  	} 
	});
}





function addrole(){
	 
	var role_name = $("#role_name").val();
	var client = [];
	$(".clients:checked").each(function(){
		client.push($(this).val());
	});

	var mandate = [];
	$(".mandate:checked").each(function(){
		mandate.push($(this).val());
	});
	var ticket = [];
	$(".ticket:checked").each(function(){
		ticket.push($(this).val());
	});
	var education = [];
	$(".education:checked").each(function(){
		education.push($(this).val());
	});
	var employment = [];
	$(".employment:checked").each(function(){
		employment.push($(this).val());
	});
	var teams = [];
	$(".teams:checked").each(function(){
		teams.push($(this).val());
	});
var bgv = $("#bgv:checked").val(); 
var cases = $("#cases:checked").val();
var mis = $("#mis:checked").val();
var component = $("#component:checked").val();
	var selected_role = JSON.stringify({'client':client,'cases':cases,'mis':mis,'component':component,'education':education,'employment':employment,'teams':teams,'bgv':bgv,'mandate':mandate,'ticket':ticket});
	if(role_name != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"role/insert_role",
	  	data:{
	  		role_name:role_name,
	  		selected_role:selected_role
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_role').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
	        	$("#role_name").val('')
	        	 
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Role successfully successfully inserted.');
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
		if(role_name != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the role name.</span>');
		}
		 
	}
	
}
 

function edit_role(id){
  $('#edit_role').modal('show');
$.ajax({
    type: "POST",
    url: base_url+"role/get_role_details/"+id, 
    dataType: "json",
    success: function(data){ 
    	console.log(JSON.stringify(data));
      	var edit_role_name = $('#edit_role_name').val(data.role_name); 
      	$('#edit_role_id').val(id); 

$("#edit-bgv").prop("checked",false);
$("#edit-cases").prop("checked",false);
$("#edit-component").prop("checked",false);
$("#edit-mis").prop("checked",false);
$(".edit-client").prop("checked",false);
$(".edit-mandate").prop("checked",false);
$(".edit-ticket").prop("checked",false);
$(".edit-teams").prop("checked",false);
$(".edit-education").prop("checked",false);
$(".edit-employment").prop("checked",false);
var client_data=[],
		education_data = [],
		employment_data = [],
		teams_data = [],
		mandate_data = [],
		ticket_data = [];
if (data.role_action !=null && data.role_action !='') {
	var parse = JSON.parse(data.role_action);
	if (parse.client.length > 0) {
		for (var i = 0; i < parse.client.length; i++) { 
		$("#edit-client"+parse.client[i]).prop("checked",true);
		}
	}

	if (parse.mandate.length > 0) {
		for (var i = 0; i < parse.mandate.length; i++) { 
		$("#edit-mandate"+parse.mandate[i]).prop("checked",true);
		}
	}


	if (parse.ticket.length > 0) {
		for (var i = 0; i < parse.ticket.length; i++) { 
		$("#edit-ticket"+parse.ticket[i]).prop("checked",true);
		}
	}
	
	
	if (parse.teams.length > 0) {
		for (var i = 0; i < parse.teams.length; i++) { 
		$("#edit-team"+parse.teams[i]).prop("checked",true);
		}
	}
	
	if (parse.education.length > 0) {
		for (var i = 0; i < parse.education.length; i++) { 
		$("#edit-education"+parse.education[i]).prop("checked",true);
		}
	}
	
	if (parse.employment.length > 0) {
		for (var i = 0; i < parse.employment.length; i++) { 
		$("#edit-employment"+parse.employment[i]).prop("checked",true);
		}
	}
	

}
 var bgv = '';
 var cases = '';
 var component = '';
 var mis = '';
 if(typeof parse.bgv !== "undefined") bgv = parse.bgv;
 if(typeof parse.cases !== "undefined") cases = parse.cases;
 if(typeof parse.component !== "undefined") component = parse.component;
 if(typeof parse.mis !== "undefined") mis = parse.mis;
 if (bgv ==3) {
		$("#edit-bgv").prop("checked",true);
	}
	if (cases ==3) {
		$("#edit-cases").prop("checked",true);
	}
	if (component ==3) {
		$("#edit-component").prop("checked",true);
	}
	if (mis ==3) {
		$("#edit-mis").prop("checked",true);
	}
 
    }
  });
}



function updateData(){
	 
	var edit_role_name = $("#edit_role_name").val();
	var edit_role_id = $("#edit_role_id").val();

	var client = [];
	$(".edit-clients:checked").each(function(){
		client.push($(this).val());
	});

	var mandate = [];
	$(".edit-mandate:checked").each(function(){
		mandate.push($(this).val());
	});
	var ticket = [];
	$(".edit-ticket:checked").each(function(){
		ticket.push($(this).val());
	});
	var education = [];
	$(".edit-education:checked").each(function(){
		education.push($(this).val());
	});
	var employment = [];
	$(".edit-employment:checked").each(function(){
		employment.push($(this).val());
	});
	var teams = [];
	$(".edit-teams:checked").each(function(){
		teams.push($(this).val());
	});
var bgv = $("#edit-bgv:checked").val(); 
var cases = $("#edit-cases:checked").val();
var mis = $("#edit-mis:checked").val();
var component = $("#edit-component:checked").val();
	var selected_role = JSON.stringify({'client':client,'cases':cases,'mis':mis,'component':component,'education':education,'employment':employment,'teams':teams,'bgv':bgv,'mandate':mandate,'ticket':ticket});
  
	if(role_name != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"role/update_role",
	  	data:{
	  		role_id:edit_role_id,
	  		role_name:edit_role_name, 
	  		selected_role:selected_role 
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#edit_role').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
	        	  
		        toastr.success('role updated successfully.');
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
		if(role_name != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the role name.</span>');
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
