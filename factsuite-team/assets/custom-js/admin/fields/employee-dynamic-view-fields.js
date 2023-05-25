load_field();

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

function load_field(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"dynamicFields/get_employee_field_values", 
	  	dataType: "json",
	  	success: function(data){ 
	  		// console.log(JSON.stringify(data));
		let html='';
		var count = $("#total_fields").val();
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) {  
        	var values = JSON.parse(data[i]['field_values']);
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	if (values.length > 0) {
        		for (var k = 0; k < count; k++) {
        			$vl = values[k]?values[k]:'';
        			html += '<td>'+$vl+'</td>'; 
        		}
        	}
        	html += '<td>'+data[i]['created_date'].split(' ')[0]+'</td>'; 
        	html += '<td>'+data[i]['updated_date'].split(' ')[0]+'</td>'; 
        	// html += '<td><a  onclick="edit_field_value('+data[i]['dynamic_id']+')"  href="#"><i class="fa fa-pencil"></i></a></td>'; 
        	 
         html += '</tr>'; 
			 
          j++; 
        }
      }else{
        // html+='<tr><td colspan="7" class="text-center">No team Found.</td></tr>'; 
    }
    $('#get-field-data').html(html); 
	  	} 
	});
}

 