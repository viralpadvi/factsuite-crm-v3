var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mobile_number_length = 10;
var url_regex = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
// var url_regex = regex = ((http|https):\/\/)?(www.)[a-zA-Z0-9@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&\/\/=]*);
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20; 
var alphabets_only = /^[A-Za-z ]+$/;
var vendor_name_length = 50;
var client_docs =[];
var selected = {};

// get_skills_list();
function get_skills_list() {
	$.ajax({
    	type:'ajax',
    	url: base_url+"cases/get_case_skills/",
    	dataType: 'JSON',
    	success: function(data) {
      		var html = '';
      		if(data.length > 0) {
        		for(var i = 0;i < data.length; i++) { 
                	html += '<div class="custom-control custom-checkbox custom-control-inline mrg">';
	                  html += '<input type="checkbox" class="custom-control-input skills" name="vendor-skills-'+data[i].component_id+'" id="vendor-skills-'+data[i].component_id+'" value="'+data[i].component_id+'">';
	                  html += '<label class="custom-control-label sub-clk" for="vendor-skills-'+data[i].component_id+'">'+data[i].component_name+'</label>';
	               html += '</div>';
        		}
      		} else {
        		html += '<div>No Component Available</div>';
      		}
      		$('#case-skills-list').html(html);
    	}
  	});
}
function GetSelected() {
    var components = new Array();
    $(".components:checked").each(function (index, data) {
        if (data.checked) { 
            components.push(data.value); 
        }
    }); 
    // alert(components)
    return components;
}

function get_checked_skills_list(id='') {
selected = {}
if(id != ''){
	$(".custom-control-input").prop('checked', false);
	$.ajax({
    	type:'ajax',
    	url: base_url+"cases/get_case_skills/"+id,
    dataType: "json",
	    async:false,
	    success: function(data){   
	    	// console.log(data.client.package_components)
	    	var package_components = JSON.parse(data.client.package_components);
	    	// alert(package_components.length)
	    	// console.log(JSON.stringify(data.package_data[0].education_type))

	      	var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
	      	
			
	      	// return false;
	      	$('#edit_package_id').val(id);

	      	let comp='';
	      
	      	for (var i = 0; i < package_components.length; i++) {
	      			if (package_components[i]['package_id'] == id) {
	      		
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
				    comp +='<input  checked type="checkbox" data-component_name="'+component_name+'" onclick="select_skill_form('+package_components[i].component_id+')"';
					    comp +='class="custom-control-input components" value="'+package_components[i].component_id+'" ';
					    comp +='name="componentCheck" id="componentCheck'+package_components[i].component_id+'">';
				    comp +='<label class="custom-control-label" for="componentCheck'+package_components[i].component_id+'">'+package_components[i].component_name
					comp +='</label>'
			    comp +=' </div>'
			    // editcomponentCheck
			    
			    // if(data['components'][i].drop_down_status == '1'){ 

			    	
			    	// Criminal Status

 

 
			    	if (package_components[i]['component_id'] == '3') {
			    		var doc_array = [];
			    		for (var k = 0; k < package_components[i].form_data.length; k++) {
			    			doc_array.push(package_components[i].form_data[k].form_id);
			    		}
					
			    		comp +='<div>'
							comp +='<select  multiple data-component_name="'+component_name+'" class="form-control fld  numberOfFomrs"';
							comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';
								// comp +='<option value="0">Select Document Type</option>';
								// var info = JSON.parse(data)
								for(var k=0;k < data.package_data[1]['documetn_type'].length;k++){
									if ($.inArray(data.package_data[1]['documetn_type'][k].document_type_id,doc_array) !==-1) { 
								  	  comp +='<option value="'+data.package_data[1]['documetn_type'][k].document_type_id+'">'+data.package_data[1]['documetn_type'][k].document_type_name+'</option>'
									}
								}	
							comp +='</select>'
							 comp +='<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>'
				    	comp +='</div>'

					}else if(package_components[i]['component_id'] == '4'){

						var doc_array = [];
			    		for (var k = 0; k < package_components[i].form_data.length; k++) {
			    			doc_array.push(package_components[i].form_data[k].form_id);
			    		}

						comp +='<div>'
							comp +='<select  multiple  data-component_name="'+component_name+'" class="form-control fld  numberOfFomrs"';
							comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';

						for(var k=0;k < data.package_data[1]['drug_test_type'].length;k++){
							if ($.inArray(data.package_data[1]['drug_test_type'][k].drug_test_type_id,doc_array) !==-1) { 
							    comp +='<option value="'+data.package_data[1]['drug_test_type'][k].drug_test_type_id+'">'+data.package_data[1]['drug_test_type'][k].drug_test_type_name+'</option>'
								}
							}

						comp +='</select>'
						 comp +='<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>'
			    	comp +='</div>'	
					}else if(package_components[i]['component_id'] == '7'){

						var doc_array = [];
			    		for (var k = 0; k < package_components[i].form_data.length; k++) {
			    			doc_array.push(package_components[i].form_data[k].form_id);
			    		}
							comp +='<div>'
							comp +='<select  multiple  data-component_name="'+component_name+'" class="form-control fld  numberOfFomrs"';
							comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'id="numberOfFomrs'+package_components[i].component_id+'">';
								// comp +='<option value="0">Select Document Type</option>';

								for(var k=0;k < data.package_data[1]['education_type'].length;k++){
									if ($.inArray(data.package_data[1]['education_type'][k].education_type_id,doc_array) !==-1) { 
									    comp +='<option value="'+data.package_data[1]['education_type'][k].education_type_id+'">'+data.package_data[1]['education_type'][k].education_type_name+'</option>'
									}
								}	
							comp +='</select>'
							comp +='<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>'
				    	comp +='</div>'
					}else if (!jQuery.inArray(package_components[i]['component_id'], ['3','4','7']) !== -1) {

						// var showOptiontValue = 'Forms';
						var showOptiontValue = package_components[i].fs_crm_component_name;
			    	var forLoopLength = package_components[i].form_data.length;

			    		if (package_components[i].component_name == 'Reference') {
			    			 showOptiontValue = 'Reference';
			    		}else if(package_components[i].component_name == 'Previous Employment'){
 							showOptiontValue = 'Previous Employment';
			    		}else if(package_components[i].component_name == 'Previous Address'){
			    			showOptiontValue = 'Previous Address';
			    		} 
						
			    		comp +='<div>'
							comp +='<select  data-component_name="'+component_name+'" class="form-control fld numberOfFomrs"';
							comp +='name="numberOfFomrs'+package_components[i].component_id+'"';
							comp += 'onChange="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp +='id="numberOfFomrs'+package_components[i].component_id+'">';
								// comp +='<option value="0">Select Number Of Reference</option>';

							if (forLoopLength > 0) {
								for(var k=1;k <= forLoopLength;k++){
								    comp +='<option value="'+k+'">'+k+' '+showOptiontValue+'</option>'
								}	
								comp +='<option value="more">Add More '+showOptiontValue+'</option>'

							}else{
								 comp +='<option value="'+1+'">'+1+' '+showOptiontValue+'</option>'
							}
							comp +='</select>'
							comp +='<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>'
				    	comp +='</div>' 
					}

					
				// }
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




function alacarte_components(id=''){ 

	// var id = $(this).val(); 
	$("#alacarte_components option[value='"+id+"']").attr("disabled",true);
	
	// if(id != ''){
	  $.ajax({
	    type: "POST",
	    url: base_url+"cases/get_case_skills/"+id, 
	    dataType: "json",
	    async:false,
	    success: function(data){ 
	    	// console.log(data.client.package_components)
	    	var package_components = JSON.parse(data.client.alacarte_components);
	    	// alert(package_components.length)
	    	// console.log(JSON.stringify(data.package_data[0].education_type))

	      	var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
	      	
			
	      	// return false;
	      	$('#edit_package_id').val(id);

	      	let comp='';
	      
	      	for (var i = 0; i < package_components.length; i++) {

	      		
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
				    comp +='<input  checked type="checkbox" ';
					    comp +='class="custom-control-input alacarte_component_names" data-component_name="'+component_name+'" value="'+package_components[i].component_id+'" ';
					    comp +='name="component_Check" id="component_Check'+package_components[i].component_id+'">';
				    comp +='<label class="custom-control-label" for="component_Check'+package_components[i].component_id+'">'+package_components[i].component_name
					comp +='</label>'
			    comp +=' </div>'
			    // editcomponentCheck
			    
			    // if(data['components'][i].drop_down_status == '1'){ 

			    	
			    	// Criminal Status

 
			
						var doc_array = [];
			    		for (var k = 0; k < package_components[i].form_data.length; k++) {
			    			doc_array.push(package_components[i].form_data[k].form_id);
			    		}
 
			    	if (package_components[i]['component_id'] == '3') {
					
			    		comp +='<div>'
							comp +='<select  data-component_name="'+component_name+'" multiple class="form-control fld  number_OfFomrs"';
							// comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="number_OfFomrs'+package_components[i].component_id+'"';
							comp += 'id="number_OfFomrs'+package_components[i].component_id+'">';
								// comp +='<option value="0">Select Document Type</option>';
								// var info = JSON.parse(data)
								for(var k=0;k < data.package_data[1]['documetn_type'].length;k++){
										if ($.inArray(data.package_data[1]['documetn_type'][k].document_type_id,doc_array) !==-1) { 
									    comp +='<option value="'+data.package_data[1]['documetn_type'][k].document_type_id+'">'+data.package_data[1]['documetn_type'][k].document_type_name+'</option>'
									}	
								}
							comp +='</select>'
							 comp +='<div id="number_OfFomrs-error'+package_components[i].component_id+'"></div>'
				    	comp +='</div>'

					}else if(package_components[i]['component_id'] == '4'){

						comp +='<div>'
							comp +='<select  data-component_name="'+component_name+'" multiple class="form-control fld  number_OfFomrs"';
							// comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="number_OfFomrs'+package_components[i].component_id+'"';
							comp += 'id="number_OfFomrs'+package_components[i].component_id+'">';

						for(var k=0;k < data.package_data[1]['drug_test_type'].length;k++){
							if ($.inArray(data.package_data[1]['drug_test_type'][k].drug_test_type_id,doc_array) !==-1) { 
							    comp +='<option value="'+data.package_data[1]['drug_test_type'][k].drug_test_type_id+'">'+data.package_data[1]['drug_test_type'][k].drug_test_type_name+'</option>'
							}
						}

						comp +='</select>'
						 comp +='<div id="number_OfFomrs-error'+package_components[i].component_id+'"></div>'
			    	comp +='</div>'	
					}else if(package_components[i]['component_id'] == '7'){
							comp +='<div>'
							comp +='<select  data-component_name="'+component_name+'" multiple class="form-control fld  number_OfFomrs"';
							// comp += 'onclick="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp += 'name="number_OfFomrs'+package_components[i].component_id+'"';
							comp += 'id="number_OfFomrs'+package_components[i].component_id+'">';
								// comp +='<option value="0">Select Document Type</option>';

								for(var k=0;k < data.package_data[1]['education_type'].length;k++){
										if ($.inArray(data.package_data[1]['education_type'][k].education_type_id,doc_array) !==-1) { 
									    comp +='<option value="'+data.package_data[1]['education_type'][k].education_type_id+'">'+data.package_data[1]['education_type'][k].education_type_name+'</option>'
									}
								}	
							comp +='</select>'
							comp +='<div id="number_OfFomrs-error'+package_components[i].component_id+'"></div>'
				    	comp +='</div>'
					}else if (!jQuery.inArray(package_components[i]['component_id'], [3,4,7]) !== -1) {

						var showOptiontValue = 'Forms';
			    	var forLoopLength = package_components[i].form_data.length;

			    		if (package_components[i].component_name == 'Reference') {
			    			 showOptiontValue = 'Reference';
			    		}else if(package_components[i].component_name == 'Previous Employment'){
 							showOptiontValue = 'Previous Employment';
			    		}else if(package_components[i].component_name == 'Previous Address'){
			    			showOptiontValue = 'Previous Address';
			    		} 
						
			    		comp +='<div>'
							comp +='<select  data-component_name="'+component_name+'" class="form-control fld number_OfFomrs"';
							comp +='name="number_OfFomrs'+package_components[i].component_id+'"';
							// comp += 'onChange="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
							comp +='id="number_OfFomrs'+package_components[i].component_id+'">';
								// comp +='<option value="0">Select Number Of Reference</option>';

								if (forLoopLength > 0) {
								for(var k=1;k <= forLoopLength;k++){
								    comp +='<option value="'+k+'">'+k+' '+showOptiontValue+'</option>'
								}	
								comp +='<option value="more">Add More '+showOptiontValue+'</option>'

							}else{
								 comp +='<option value="'+1+'">'+1+' '+showOptiontValue+'</option>'
							}

							comp +='</select>'
							comp +='<div id="number_OfFomrs-error'+package_components[i].component_id+'"></div>'
				    	comp +='</div>' 
					}

					
				// }
				comp += ''
	      		comp +=' </div>'
	      	}
	    	$('#alacarte_components_ids').prepend(comp)
	    }
	  });
	 
/*	}else{
		let comp='';
		comp +='<div class="col-md-4">'
			
	    comp +=' </div>'
	    $('#alacarte_components_ids').prepend(comp)
	}///*/
}



// get_package_list();
function get_package_list() {
	$.ajax({
    	type:'ajax',
    	url: base_url+"cases/get_case_package",
    	dataType: 'JSON',
    	success: function(data) {
      		var html = '';
      		if(data.length > 0) {
        			html +='<option value=""> Select Package</option>'
        		for(var i = 0;i < data.length; i++) { 
                	html += '<option value="'+data[i].package_id+'">'+data[i].package_name+'</option>'
        		}
      		} else {
        		html += '<option value="">No Package Available</option>';
      		}
      		$('#package').html(html);
    	}
  	});
}


function getValusFromSelect(id,component_name){
 
	var selectedObj = [];
	var obj=[] 
	$("#numberOfFomrs"+id+" option:selected").each(function(){
		if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
			obj.push($(this).val()) 
  		}
	}); 
	selected[component_name.toLowerCase()] = obj

	// alert(JSON.stringify(selected))
	  
}
 
function select_skill_form(id) {
    if($("input[name=componentCheck"+id+"]").prop('checked') == true) { 
    	$('#numberOfFomrs'+id).removeAttr("disabled")  
    	// $('#numberOfFomrs'+id).attr("disabled",false)  
    	// GetSelected() 
    	// alert('Checked')
    	// $('#numberOfFomrs'+id).attr("onchange","numberOfFormShoudNotBeZero("+id+")"); 
    	// $('#vendor-tat'+id).attr("blur","check_vendor_skill_tat("+id+")");
	} else {
		$('#numberOfFomrs'+id).attr("disabled",true)  
		$('#numberOfFomrs'+id).val('0');
		// $('#vendor-tat-error-msg-div'+id).html('&nbsp;');
		// $('#numberOfFomrs'+id).removeAttr("onchange");
		// $('#vendor-tat'+id).removeAttr("blur");
		// $('#vendor-tat'+id).removeClass("is-valid is-invalid");
	}
}
   

$('#first-name').on('keyup blur keydown',function(){
	valid_first_name();
});

$('#last-name').on('keyup blur keydown',function(){
	valid_last_name();
});

$('#father-name').on('keyup blur keydown',function(){
	valid_father_name();
});
$('#email-id').on('keyup blur',function(){
	valid_email();
});

$('#contact-no').on('keyup blur keydown',function(){
	valid_contact();
});

$("#birth-date").on('keyup keydown input blur change',function(){
	valid_birth_date();
});

$("#joining-date").on('keyup keydown input blur change',function(){
	valid_joining_date();
});

$('#employee-id').on('keyup blur',function(){
	valid_employee_date();
});

$('#remark').on('keyup blur',function(){
	valid_remark_date();
});

$('#package').on('change blur',function(){
	valid_package();
});


$('#document-uploader').on('change blur',function(){
	valid_document_uploader();
});

$("#client-email").on('change blur',valid_client_email);


function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}


function valid_first_name(){
	/*var first_name = $('#first-name').val();
	if (first_name != '') {
		$('#first-name-error').html('&nbsp;');
		input_is_valid('#first-name');
	} else {
		input_is_invalid('#first-name');
		$('#first-name-error').html('<span class="text-danger error-msg-small">Please enter your first name.</span>');
	}*/
	var first_name = $('#first-name').val();
	if (first_name != '') {
		if (!alphabets_only.test(first_name)) {
			$('#first-name-error').html('<span class="text-danger error-msg-small">First name should be only alphabets.</span>');
			$('#first-name').val(first_name.slice(0,-1));
			input_is_invalid('#first-name');
		} else if (first_name.length > vendor_name_length) {
			$('#first-name-error').html('<span class="text-danger error-msg-small">First name should be of max '+vendor_name_length+' characters.</span>');
			$('#first-name').val(first_name.slice(0,vendor_name_length));
			input_is_invalid('#first-name');
		} else {
			$('#first-name-error').html('&nbsp;');
			input_is_valid('#first-name');
		}
	} else {
		$('#first-name-error').html('<span class="text-danger error-msg-small">Please enter first name.</span>');
		input_is_invalid('#first-name');
	}	
}

function valid_package(){
		var package = $('#package').val();
	if (package != '') {
		$('#package-error').html('&nbsp;');
		input_is_valid('#package');

		get_checked_skills_list(package);

	} else {
		$(".custom-control-input").prop('checked', false);
		input_is_invalid('#package');
		$('#package-error').html('<span class="text-danger error-msg-small">Please select package.</span>');
	}
}

function valid_document_uploader(){
	var last_name = $('#document-uploader').val();
	$('#client-email-div').hide()
	if (last_name != '') {
		$('#document-uploader-error').html('&nbsp;');
		input_is_valid('#document-uploader');
		if (last_name=='client') {
			$('#client-email-div').show()
		}
	} else {
		input_is_invalid('#document-uploader');
		$('#document-uploader-error').html('<span class="text-danger error-msg-small">Please select uploader.</span>');
	}	
}

function valid_last_name(){
	/*var last_name = $('#last-name').val();
	if (last_name != '') {
		$('#last-name-error').html('&nbsp;');
		input_is_valid('#last-name');
	} else {
		input_is_invalid('#last-name');
		$('#last-name-error').html('<span class="text-danger error-msg-small">Please enter your last name.</span>');
	}*/
	var last_name = $('#last-name').val();
	if (last_name != '') {
		if (!alphabets_only.test(last_name)) {
			$('#last-name-error').html('<span class="text-danger error-msg-small">Last name should be only alphabets.</span>');
			$('#last-name').val(last_name.slice(0,-1));
			input_is_invalid('#last-name');
		} else if (last_name.length > vendor_name_length) {
			$('#last-name-error').html('<span class="text-danger error-msg-small">Last name should be of max '+vendor_name_length+' characters.</span>');
			$('#last-name').val(last_name.slice(0,vendor_name_length));
			input_is_invalid('#last-name');
		} else {
			$('#last-name-error').html('&nbsp;');
			input_is_valid('#last-name');
		}
	} else {
		$('#last-name-error').html('<span class="text-danger error-msg-small">Please enter last name.</span>');
		input_is_invalid('#last-name');
	}
}

function valid_birth_date(){
	var birthdate = $('#birth-date').val();
	if (birthdate != '') {
		$('#birth-date-error').html('&nbsp;');
		input_is_valid('#birth-date');
	} else {
		input_is_invalid('#birth-date');
		$('#birth-date-error').html('<span class="text-danger error-msg-small">Please enter birth date.</span>');
	}	
}

function valid_joining_date(){
	var birthdate = $('#joining-date').val();
	if (birthdate != '') {
		$('#joining-date-error').html('&nbsp;');
		input_is_valid('#joining-date');
	} else {
		input_is_invalid('#joining-date');
		$('#joining-date-error').html('<span class="text-danger error-msg-small">Please enter joining date.</span>');
	}	
}

function valid_employee_date(){
	var birthdate = $('#employee-id').val();
	if (birthdate != '') {
		$('#employee-id-error').html('&nbsp;');
		input_is_valid('#employee-id');
	} else {
		input_is_invalid('#employee-id');
		$('#employee-id-error').html('<span class="text-danger error-msg-small">Please enter employee-id.</span>');
	}	
}

function valid_remark_date(){
	var birthdate = $('#remark').val();
	if (birthdate != '') {
		$('#remark-error').html('&nbsp;');
		input_is_valid('#remark');
	} else {
		input_is_invalid('#remark');
		$('#remark-error').html('<span class="text-danger error-msg-small">Please enter remark.</span>');
	}	
}


function valid_father_name(){
	/*var father_name = $('#father-name').val();
	if (father_name != '') {
		$('#father-name-error').html('&nbsp;');
		input_is_valid('#father-name');
	} else {
		input_is_invalid('#father-name');
		$('#father-name-error').html('<span class="text-danger error-msg-small">Please enter father name.</span>');
	}*/

	var father_name = $('#father-name').val();
	if (father_name != '') {
		if (!alphabets_only.test(father_name)) {
			$('#father-name-error').html('<span class="text-danger error-msg-small">Father name should be only alphabets.</span>');
			$('#father-name').val(father_name.slice(0,-1));
			input_is_invalid('#father-name');
		} else if (father_name.length > vendor_name_length) {
			$('#father-name-error').html('<span class="text-danger error-msg-small">Father name should be of max '+vendor_name_length+' characters.</span>');
			$('#father-name').val(father_name.slice(0,vendor_name_length));
			input_is_invalid('#father-name');
		} else {
			$('#father-name-error').html('&nbsp;');
			input_is_valid('#father-name');
		}
	} else {
		$('#father-name-error').html('<span class="text-danger error-msg-small">Please enter father name.</span>');
		input_is_invalid('#father-name');
	}
}

function valid_email(){
	var email = $("#email-id").val(); 
	if (email != '') {
	if(!regex.test(email)) {
			$('#email-id-error').html("<span class='text-danger error-msg-small'>Please enter a valid email.</span>");
	    	input_is_invalid('#email-id');
	    } else { 
	    	valid_email_check(email);

	    }
	} else {
		input_is_invalid('#email-id');
		$('#email-id-error').html('<span class="text-danger error-msg-small">Please enter email id.</span>');
	}
}

function valid_client_email(){
	var client_email = $("#client-email").val();
		if (client_email != '') {
	if(!regex.test(client_email)) {
			$('#client-email-error').html("<span class='text-danger error-msg-small'>Please enter a valid email.</span>");
	    	input_is_invalid('#client-email');
	    } else { 
	    	// valid_email_check(client_email);

	    }
	} else {
		input_is_invalid('#client-email');
		$('#client-email-error').html('<span class="text-danger error-msg-small">Please enter email id.</span>');
	}
}

function valid_email_check(email){
	$candidate_id = $("#candidate_id").val();
	  $.ajax({
	          type: "POST",
	          url: base_url+"cases/valid_mail/",
	          data:{email:email,candidate_id:$candidate_id},
	          dataType: 'json', 
	          success: function(data) {

	          	if (data.status =='1') {
	          		$("#insert_data").attr('disabled',false);
	          		input_is_valid('#email-id');
			        $('#email-id-error').html("&nbsp;");
			    }else{
			    	$("#insert_data").attr('disabled',true);
			    	input_is_invalid('#email-id'); 
					$('#email-id-error').html('<span class="text-danger error-msg">This mail id already exists</span>');
			    }

	          }
     	 });
}

function valid_contact(){
  	var user_contact = $('#contact-no').val(); 

  	if (user_contact !='') {
		if (isNaN(user_contact)) {
			$("#contact-no-error").html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
			$("#contact-no").val(user_contact.slice(0,-1));
			input_is_invalid("#contact-no");
		} else if (user_contact.length != 10) {
			$("#contact-no-error").html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
			var puser_contact = $("#contact-no").val(user_contact.slice(0,10));
			input_is_invalid("#contact-no");
			if (puser_contact.length == 10) {
				valid_contact_check(puser_contact)
			$("#contact-no-error").html('&nbsp;');
			input_is_valid("#contact-no");	
			}
		} else {
			valid_contact_check(user_contact)
			$("#contact-no-error").html('&nbsp;');
			input_is_valid("#contact-no");
		} 
	}else{
		$("#contact-no-error").html("<span class='text-danger error-msg-small'>Please enter valid contact number</span>");
		input_is_invalid("#contact-no")
	}
}

function valid_contact_check(contact){
	$candidate_id = $("#candidate_id").val()
	  $.ajax({
	          type: "POST",
	          url: base_url+"cases/valid_phone_number/",
	          data:{contact:contact,candidate_id:$candidate_id},
	          dataType: 'json', 
	          success: function(data) {

	          	if (data.status =='1') {
	          		$("#insert_data").attr('disabled',false);
	          		input_is_valid("#contact-no");
			        $("#contact-no-error").html("&nbsp;");
			    }else{
			    	$("#insert_data").attr('disabled',true);
			    	input_is_invalid("#contact-no");
					$("#contact-no-error").html('<span class="text-danger error-msg">This contact number already exists</span>');
			    }

	          }
     	 });
}

function edit_case() {
	var candidate_id = $("#modal-edit-candidate-id").val();
	var title = $('#edit-title-v2').val();
	var first_name = $('#edit-first-name-v2').val();
	var last_name = $('#edit-last-name-v2').val();
	var father_name = $('#edit-father-name-v2').val();
	var birthdate = $('#edit-birth-date-v2').val();
	var email = $("#edit-email-id-v2").val();
	var country_code = $('#edit-country-code').val();
	var user_contact = $('#edit-contact-no-v2').val();
	var joining_date = $('#edit-joining-date-v2').val();
	var employee_id = $('#edit-employee-id-v2').val();
	var package = $('#edit-package-v2').val();
	var document_uploader = $('#edit-document-uploader-v2').val();
	var remark = $('#edit-remark-v2').val();
	var client_email = $('#client-email').val();

	var component_id = GetSelected();
	var skills = [];
	var package_component = [];
	$(".edit-components:checked").each(function(){
		// if ($(this).val() !='') {
		skills.push($(this).val());
		// alert($(this).data("component_name"))
		var component_name = $(this).data("component_name");
		 	component_name = component_name.replaceAll(' ','_')
		getValusFromSelect($(this).val(),component_name); 

		var form_value = $("#numberOfFomrs"+$(this).val()).val(); 
		package_component.push({component_id:$(this).val(),form_values:form_value});
		// }
	});
	if (package_component.length == 0) {

		return false;
	}
 	var alacarte_component = [];
	$(".alacarte_component_names:checked").each(function(){
		var id = $(this).val();
		var form_value = $("#number_OfFomrs"+$(this).val()).val();
		alacarte_component.push({component_id:$(this).val(),form_values:form_value});
		// component_id.push($(this).val());
		skills.push($(this).val());
		var component_name =$(this).data("component_name");
			component_name = component_name.replaceAll(' ','_')
			// getValusFromSelect($(this).val(),component_name);
		var obj = [];
		$("#number_OfFomrs"+id+" option:selected").each(function(){
			if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
				obj.push($(this).val()) 
				// $('#numberOfFomrs-error'+id).html('')
			  }
		}); 
		selected[component_name.toLowerCase()] = obj
	});

 	var form_values =  JSON.stringify(selected);
	
	var not_allowed = ['5','6','8','9'];
	var flag = 0;
	for (var i = 0; i < skills.length; i++) {
		if(jQuery.inArray(skills[i], not_allowed) === -1) { 
    		var comp_val = $("#numberOfFomrs"+skills[i]).val();
    		if (comp_val == 0 || comp_val == '') {
    			$('#numberOfFomrs-error'+skills[i]).html("<span class='text-danger error-msg-small'>Please select at least one.</span>");
    			flag = 1;
    		}
		}
	}

	if (flag == 1) { return false; }

	if (first_name !='' && package !='' && document_uploader !='' &&
		last_name !='' && birthdate !='' /*&& joining_date !='' && employee_id !='' &&
		remark !=''*/ && email !='' && regex.test(email) && user_contact !='' && user_contact.length ==10
		) 
	{  
		// $("#edit-case-step-error-msg-div").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		$("#edit-case-step-error-msg-div").html('<span class="d-block text-center text-danger error-msg-small">Please wait while we are updating the candidate details</span>');

		var formdata = new FormData();

		formdata.append('candidate_id',candidate_id);
		formdata.append('title',title);
		formdata.append('first_name',first_name);
		formdata.append('package',package);
		formdata.append('document_uploader',document_uploader);
		formdata.append('last_name',last_name);
		formdata.append('birthdate',birthdate);
		formdata.append('joining_date',joining_date);
		formdata.append('employee_id',employee_id);
		formdata.append('remark',remark);
		formdata.append('email',email);
		formdata.append('country_code',country_code); 
		formdata.append('user_contact',user_contact); 
		formdata.append('skills',skills); 
		formdata.append('father_name',father_name); 
		formdata.append('form_values',form_values); 
		formdata.append('client_email',client_email); 
		formdata.append('alacarte_components', JSON.stringify(alacarte_component)); 
		formdata.append('package_component', JSON.stringify(package_component)); 
		formdata.append('init', $("#case-init").val()); 
		$.ajax({
	        type: "POST",
	        url: base_url+"cases/update_case/",
	        data:formdata,
	        dataType: 'json',
	        contentType: false,
	        processData: false,
	        success: function(data) {
	            if (data.status == '1') {
					$('#modal-edit-case-v2').modal('hide');
					toastr.success('Candidate details has been updated successfully.'); 
					// window.location.href = base_url+'factsuite-client/all-cases';
					$('.is-valid').removeClass('is-valid');
					$('.is-invalid').removeClass('is-invalid');
					$("#edit-CheckAll").prop('checked', false);
	            } else {
	              	toastr.error('Something went wrong while updating the candidate details. Please try again.'); 	
	            }
	            $("#edit-case-step-error-msg-div").html('');
	        }
	    });
	 
	}
	//  else { 
	// 	valid_first_name();
	// 	valid_last_name();
	// 	valid_father_name();
	// 	valid_email();
	// 	valid_contact();
	// 	valid_birth_date();
	// 	// valid_joining_date();
	// 	// valid_employee_date();
	// 	// valid_remark_date();
	// 	valid_package();
	// 	valid_document_uploader();
	// }
}

function import_excel() {
	var files = $('#file1')[0].files[0];
	if (files != undefined) {
		$('#excel-error-msg-div').html('');

		var formdata = new FormData(); 
		formdata.append('files', files);
		
		$('#excel-error-msg-div').html('<span class="text-warning error-msg-small">Please wait while we are submitting the details</span>');
		$('#import_excel_file').prop('disabled',true);
		$('#import_excel_file').css('background','#b3b3b3');

		$.ajax({
			type: "POST",
		  	url: base_url+"cases/import_excel",
		  	data: formdata,
		  	dataType: "json",
		  	contentType: false,
		    processData: false,
		  	success: function(data){
		  		$('#excel-error-msg-div').html('');
		  		$('#import_excel_file').prop('disabled',false);
		  		$('#import_excel_file').css('background','#005799');
			  	if (data.status == '1') {
			  		toastr.success('New case has been added successfully.');
					$('#file1').val('');
			  	} else {
			  		toastr.error('Something went wrong while adding the case details. Please try again.');
		  		}
		  	} 
		});
	} else {
		$('#excel-error-msg-div').html('<span class="text-danger error-msg-small">Please select a valid excel sheet.</span>');
	}
}