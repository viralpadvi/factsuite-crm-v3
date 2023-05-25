var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mobile_number_length = 10;
var url_regex = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
// var url_regex = regex = ((http|https):\/\/)?(www.)[a-zA-Z0-9@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&\/\/=]*);
var client_zip_lenght = 600;
var client_document_size = 2000000000000;
var max_client_document_select = 100;
var client_docs =[];
var alphabets_only = /^[A-Za-z ]+$/;
var vendor_name_length = 50;
 
var candidate_aadhar =[];
var candidate_pan =[];
var candidate_proof =[];
var candidate_bank =[];

var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

get_skills_list();
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
	                  html += '<label class="custom-control-label sub-clk" for="vendor-skills-'+data[i].component_id+'">'+data[i][component_config_name]+'</label>';
	               html += '</div>';
        		}
      		} else {
        		html += '<div class="col-md-12">No Component Available</div>';
      		}
      		$('#case-skills-list').html(html);
    	}
  	});
}

function GetSelected() {
    var components = new Array();
    $("[name='componentCheck']").each(function (index, data) {
        if (data.checked) { 
            components.push(data.value); 
        } 
    }); 
    // alert(components)
    return components;
}

function GetMonthName(monthNumber) {
    return months[monthNumber - 1];
}

$("#request_form_submit").on('click',function(){
	$("#request_form_submit").attr('disabled',true);
	$("#request_form_submit").html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
	var request_comonent_id = $("#request_comonent_id").val();
	var request_number_of_form = $("#request_number_of_form").val();
	var package_id = $("#package_id").val();
	var client_id = $("#client_id").val();

	$.ajax({
	          type: "POST",
	          url: base_url+"inputQc/add_request_form/",
	          data:{comonent_id:request_comonent_id,number_of_form:request_number_of_form,package_id:package_id,client_id:client_id},
	          dataType: 'json', 
	          success: function(data) { 
	          	if (data.status =='1') { 
	          		toastr.success('A candidate is added successfully.'); 
	          		$("#request_comonent_id").val('');
					$("#request_number_of_form").val('');
			    }else{ 
			    	toastr.error('Something went wrong while adding a candidate. Please try again.'); 	
			    }

			    $("#request_form_submit").attr('disabled',false);
	$("#request_form_submit").html('Submit');
	$("#requiest_more_form").modal('hide');

	          }
     	 });
});

function get_checked_skills_list(id='') {
	if(id != ''){
	// $(".custom-control-input").prop('checked', false);

		$.ajax({
	    	type:'ajax',
	    	url: base_url+"cases/get_case_skills/"+id,
	    	dataType: "json",
		    async:false,
		    success: function(data){  

		    	// console.log(data.client.package_components)
		    	var package_components = JSON.parse(data.client.package_components);
		    	// alert(JSON.stringify(data['package_data'][1].education_type))
		    	// console.log(JSON.stringify(data.package_data[0].education_type))
		    	var all_components = data.components;
		      	var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
		      	
				
		      	// return false;
		      	$('#edit_package_id').val(id);
		      	// var package = $('#package_id').val(id);

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
				    	show_component_name = ''; 
				    	for (var j = 0; j < all_components.length; j++) {
				    		if (package_components[i].component_id == all_components[j].component_id) {
				    			show_component_name = all_components[j].fs_crm_component_name;
				    			break;
				    		}
				    	}
		      		comp +='<div class="col-md-4">'
				      	comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
					    comp +='<input  checked type="checkbox"  data-component_name="'+component_name+'" onclick="select_skill_form('+package_components[i].component_id+')"';
						    comp +='class="custom-control-input components" value="'+package_components[i].component_id+'" ';
						    comp +='name="componentCheck" id="componentCheck'+package_components[i].component_id+'">';
					    comp +='<label class="custom-control-label" for="componentCheck'+package_components[i].component_id+'">'+show_component_name
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

				    	// 	if (package_components[i].component_name == 'Reference') {
				    	// 		 showOptiontValue = 'Reference';
				    	// 	}else if(package_components[i].component_name == 'Previous Employment'){
	 							// showOptiontValue = 'Previous Employment';
				    	// 	}else if(package_components[i].component_name == 'Previous Address'){
				    	// 		showOptiontValue = 'Previous Address';
				    	// 	} 
							
				    		comp +='<div>'
								comp +='<select  data-component_name="'+component_name+'" class="form-control fld numberOfFomrs"';
								comp +='name="numberOfFomrs'+package_components[i].component_id+'"';
								comp += 'onChange="getValusFromSelect('+package_components[i].component_id+',\''+component_name+'\')"';
								comp +='id="numberOfFomrs'+package_components[i].component_id+'">';
									// comp +='<option value="0">Select Number Of Reference</option>';

								if (forLoopLength > 0) {
									for(var k=1;k <= forLoopLength;k++){
									    comp +='<option value="'+k+'">'+show_component_name+' '+k+'</option>'
									}	
									comp +='<option value="more">Add More '+show_component_name+'</option>'

								}else{
									 comp +='<option value="'+1+'">'+show_component_name+' '+1+'</option>'
								}

								comp +='</select>'
								comp +='<div id="numberOfFomrs-error'+package_components[i].component_id+'"></div>'
					    	comp +='</div>' 
						}


						
					// }
					comp += ''
		      		comp +=' </div>'
		      	}}
		    	$('#case-skills-list').html(comp)
		    }
		  });
	 
	}else{
		let comp='';
		comp +='<div class="col-md-4">'
			
	    comp +=' </div>'
	    $('#case-skills-list').html(comp)
	}
}

get_alacarte_component();
function get_alacarte_component(id=''){ 
	// var id = $(this).val(); 
	$("#alacarte_components option[value='"+id+"']").attr("disabled",true);
	
 
	  $.ajax({
	    type: "POST",
	    url: base_url+"cases/get_case_skills/"+id, 
	    dataType: "json",
	    async:false,
	    success: function(data){  
		// alert(JSON.stringify(data['package_data'][0].documetn_type))

	    	// console.log(JSON.stringify(data))

	    	var package_components = JSON.parse(data.client.alacarte_components); 

	      	var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
	      	
			
	      	// return false;
	      	$('#edit_package_id').val(id);

	      	let comp=''; 
	      	if (package_components != null && package_components != '') { 
	      
	      	for (var i = 0; i < package_components.length; i++) {
 
			    	var component =  package_components[i].component_name;
			    	var component_name = component.replaceAll(/\s+/g, '_').trim();
	      		comp +='<div class="col-md-4">'
			      	comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
				    comp +='<input  type="checkbox" ';
					    comp +='class="custom-control-input alacarte_component_names" data-component_name="'+component_name+'" value="'+package_components[i].component_id+'" ';
					    comp +='name="component_Check" id="component_Check'+package_components[i].component_id+'">';
				    comp +='<label class="custom-control-label" for="component_Check'+package_components[i].component_id+'">'+package_components[i].component_name
					comp +='</label>'
			    comp +=' </div>' 

			    
 				
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

						// var showOptiontValue = 'Forms';
						var showOptiontValue = package_components[i].fs_crm_component_name;
			    	var forLoopLength = package_components[i].form_data.length;

			    	// 	if (package_components[i].component_name == 'Reference') {
			    	// 		 showOptiontValue = 'Reference';
			    	// 	}else if(package_components[i].component_name == 'Previous Employment'){
 							// showOptiontValue = 'Previous Employment';
			    	// 	}else if(package_components[i].component_name == 'Previous Address'){
			    	// 		showOptiontValue = 'Previous Address';
			    	// 	} 
						
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
	      	}}
	    	$('#alacarte_components_ids').prepend(comp)
	    }
	  });
	 
 
}


get_package_list();
function get_package_list() {
	$.ajax({
    	type:'ajax',
    	url: base_url+"cases/get_case_package",
    	dataType: 'JSON',
    	success: function(data) {
    		// alert(JSON.stringify(data))
      		var html = '';
      		if(data.length > 0) {
        			html +='<option value=""> Select Package</option>'
        		for(var i = 0;i < data.length; i++) { 
                	html += '<option value="'+data[i].package_id+'">'+data[i].package_name+'</option>'
        		}
      		} else {
        		html += '<option value="">No package Available</option>';
      		}
      		$('#package, #package-v2').html(html);
    	}
  	});
}


var selected = {};
function getValusFromSelect(id,component_name){
 var form = $("#numberOfFomrs"+id+" option:selected").val();
 if (form == 'more') {
 	$("#request_form_submit").attr('disabled',false);
	$("#request_form_submit").html('Submit');

 	var component__name = component_name.replaceAll('_',' ')
 	$("#requiest_more_form").modal('show');
 	$("#request_comonent_id").val(id);
$("#request_component_name").html(component__name);
 	return false;
 }
	var selectedObj = [];
	var obj=[] 
	$("#numberOfFomrs"+id+" option:selected").each(function(){
		if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
			obj.push($(this).val()) 
			$('#numberOfFomrs-error'+id).html('')
  		}
	}); 
	selected[component_name.toLowerCase()] = obj

	// alert(JSON.stringify(selected))
	  
}


$("#request_form_submit").on('click',function(){
	$("#request_form_submit").attr('disabled',true);
	$("#request_form_submit").html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
	var request_comonent_id = $("#request_comonent_id").val();
	var request_number_of_form = $("#request_number_of_form").val();
	var package_id = $("#package").val();

	$.ajax({
	          type: "POST",
	          url: base_url+"cases/add_request_form/",
	          data:{comonent_id:request_comonent_id,number_of_form:request_number_of_form,package_id:package_id},
	          dataType: 'json', 
	          success: function(data) { 
	          	if (data.status =='1') { 
	          		toastr.success('Successfully Form added.'); 
	          		$("#request_comonent_id").val('');
					$("#request_number_of_form").val('');
			    }else{ 
			    	toastr.error('Something went wrong while requesting form. Please try again.'); 	
			    }

			    $("#request_form_submit").attr('disabled',false);
	$("#request_form_submit").html('Submit');
	$("#requiest_more_form").modal('hide');

	          }
     	 });
});
 
function select_skill_form(id) { 
    if($("#componentCheck"+id).prop('checked') == true) {  
    	$('#numberOfFomrs'+id).prop( "disabled", false )  
    	GetSelected() 
    	// alert('Checked')
    	// $('#numberOfFomrs'+id).attr("onchange","numberOfFormShoudNotBeZero("+id+")"); 
    	// $('#vendor-tat'+id).attr("blur","check_vendor_skill_tat("+id+")");
	} else {
		$('#numberOfFomrs'+id).attr( "disabled", true )  
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


$('#document-uploader').on('change',function(){
	valid_document_uploader();
});

$("#client-email").on('keyup blur',function() {
	valid_client_email();
});

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}

function valid_first_name(){
/*	
	if (first_name != '') {
		$('#first-name-error').html('&nbsp;');
		input_is_valid('#first-name');
	} else {
		input_is_invalid('#first-name');
		$('#first-name-error').html('<span class="text-danger error-msg-small">Please enter your first name.</span>');
	}
*/

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
		$('#package-error').html('<span class="text-danger error-msg-small">Please Select package.</span>');
	}
}

function valid_document_uploader(){
	var last_name = $('#document-uploader').val();
	$('#client-email-div').hide();
	// $('#client-email').val('');
	$('#client-email-error').html('&nbsp;');
	if (last_name != '') {
		$('#document-uploader-error').html('&nbsp;');
		input_is_valid('#document-uploader');
		if (last_name=='client') {
			$('#client-email-div').hide()
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
	    	// valid_email_check(email);
	    	$('#email-id-error').html('&nbsp;');
	   		// valid_email_check(client_email);
	   		input_is_valid('#email-id');
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
	   		$('#client-email-error').html('&nbsp;');
	   		// valid_email_check(client_email);
	   		input_is_valid('#client-email');
	   	}
	} else {
		input_is_invalid('#client-email');
		$('#client-email-error').html('<span class="text-danger error-msg-small">Please enter a email.</span>');
	}
}

function valid_email_check(email){
	  $.ajax({
	          type: "POST",
	          url: base_url+"cases/valid_mail/",
	          data:{email:email},
	          dataType: 'json', 
	          success: function(data) {

	          	if (data.status =='1') {
	          		$("#insert_data").attr('disabled',false);
	          		input_is_valid('#email-id');
			        $('#email-id-error').html("&nbsp;");
			    }else{
			    	$("#insert_data").attr('disabled',true);
			    	input_is_invalid('#email-id'); 
					$('#email-id-error').html('<span class="text-danger error-msg">This email id already exists</span>');
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
				// valid_contact_check(puser_contact)
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
	  $.ajax({
	          type: "POST",
	          url: base_url+"cases/valid_phone_number/",
	          data:{contact:contact},
	          dataType: 'json', 
	          success: function(data) {

	          	if (data.status =='1') {
	          		input_is_valid("#contact-no");
			        $("#contact-no-error").html("&nbsp;");
			        $("#insert_data").attr('disabled',false);
			    }else{
			    	$("#insert_data").attr('disabled',true);
			    	input_is_invalid("#contact-no");
					$("#contact-no-error").html('<span class="text-danger error-msg-small">This contact is already available</span>');
			    }

	          }
     	 });
}

$(".number_OfFomrs").on('click',function(){

	var MyID = $(this).attr("id"); 
   var number = MyID.match(/\d+/); 
	var form = $("#number_OfFomrs"+number+" option:selected").val();
 if (form == 'more') {
 	$("#request_form_submit").attr('disabled',false);
	$("#request_form_submit").html('Submit');
	var component_name = $("#number_OfFomrs"+number).data('component_name');
	
 	var component__name = component_name.replaceAll('_',' ')
 	$("#requiest_more_form").modal('show');
 	$("#request_comonent_id").val(number);
$("#request_component_name").html(component__name);
 	// return false;
 }
});

function add_case(){
	var title = $('#title').val();
	var first_name = $('#first-name').val();
	var father_name = $('#father-name').val();
	var package = $('#package').val();
	var document_uploader = $('#document-uploader').val();
	var last_name = $('#last-name').val();
	var birthdate = $('#birth-date').val();
	var joining_date = $('#joining-date').val();
	var employee_id = $('#employee-id').val();
	var remark = $('#remark').val();
	var email = $("#email-id").val(); 
	var user_contact = $('#contact-no').val();
	var client_email = $('#client-email').val();

	var component_id = GetSelected();
	var skills = [];
	var package_component = [];
	$(".components:checked").each(function(){
		var id = $(this).val();
		if ($(this).val() !='') {
			skills.push($(this).val());
			var form_value = $("#numberOfFomrs"+$(this).val()).val();
		var component_name = $(this).data('component_name');
		 component_name = component_name.replaceAll(' ','_');
		package_component.push({component_id:$(this).val(),form_values:form_value});
		var obj = [];
		// obj.push(form_value); 
			var obj=[] 
	$("#numberOfFomrs"+id+" option:selected").each(function(){
		if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
			obj.push($(this).val()) 
			$('#numberOfFomrs-error'+id).html('')
  		}
	}); 
		selected[component_name.toLowerCase()] = obj
		}
	});

	 	var alacarte_component = [];
	$(".number_OfFomrs:checked").each(function(){
		var id = $(this).val();
		var form_value = $("#number_OfFomrs"+$(this).val()).val();
		skills.push($(this).val());
		var component_name = $(this).data('component_name');
		 component_name = component_name.replaceAll(' ','_');
		alacarte_component.push({component_id:$(this).val(),form_values:form_value});
		// component_id.push($(this).val());
		var obj = [];
		// obj.push(form_value); 
			var obj=[] 
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
 
	$('#CheckAll').prop('checked', false);

	/*	 	var alacarte_component = [];
	$(".alacarte_component_names:checked").each(function(){
		var form_value = $("#number_OfFomrs"+$(this).val()).val();
		alacarte_component.push({component_id:$(this).val(),form_values:form_value});
		// component_id.push($(this).val());
	});*/
	 

	if (first_name !='' && package !='' && document_uploader !='' &&
		last_name !='' && birthdate !='' /*&& joining_date !='' && employee_id !='' &&
		remark !=''*/ && email !='' && regex.test(email) && user_contact !='' && user_contact.length ==10
		) 
	{  

		$("#insert_data").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		$("#error-client").html('');
	var formdata = new FormData();

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
	formdata.append('user_contact',user_contact); 
	formdata.append('skills',skills); 
	formdata.append('father_name',father_name); 
	formdata.append('form_values',form_values); 
	formdata.append('client_email',client_email); 
	formdata.append('alacarte_components', JSON.stringify(alacarte_component)); 
	formdata.append('package_component', JSON.stringify(package_component)); 
	$.ajax({
            type: "POST",
              url: base_url+"cases/insert_case/",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
              	if (data.status == '1') {
              		$('#add-new-case').modal('hide');
					toastr.success('New case has been added successfully.'); 
					$('#first-name').val('');
					$('#package').val('');
					$("#father-name").val('');
					$('#document-uploader').val('');
					$('#last-name').val('');
					$('#birth-date').val('');
					$('#joining-date').val('');
					$('#employee-id').val('');
					$('#remark').val('');
					$("#email-id").val(''); 
					$('#contact-no').val('');
					$(".skills:checked").each(function(){
						this.checked = false;
					});

					$(".alacarte_component_names").prop('checked',false);

					$('.is-valid').removeClass('is-valid');
					$('.is-invalid').removeClass('is-invalid');
					$("#case-skills-list").html("");
					$('#client-email-div').show();
					$("#client-email").val('');
					if (document_uploader == 'client') {
						// window.open(candidate_url_for_redirecting_to_candidate_module);
						window.location.href = candidate_url_for_redirecting_to_candidate_module;
					}
					// view_all_cases();
					ajaxlist(page_url=false);
              	}else if(data.status == '2'){
					// let html = "<span class='text-danger'>"+data.msg+"</span>";
					// $('#error-team').html(html);
					toastr.error(data.msg+"Conect to admin");
				}else{
              		toastr.error('Something went wrong while adding a new case. Please try again.'); 	
              	}
              	$("#insert_data").html('Submit');
              }
    });
	 
	}else{ 
		valid_first_name();
		valid_last_name();
		valid_father_name();
		valid_email();
		valid_contact();
		valid_birth_date();
		// valid_joining_date();
		// valid_employee_date();
		// valid_remark_date();
		valid_package();
		valid_document_uploader();
	}
}

function import_excel_(){
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
			  		toastr.error('OOPS! Something went wrong while adding the case details. Please try again.');
		  		}
		  	} 
		});
	} else {
		$('#excel-error-msg-div').html('<span class="text-danger error-msg-small">Please select a valid excel sheet.</span>');
	}
}

function import_excel(){
	var files = $('#add-bulk-upload-case')[0].files[0];
	// var client_id = $('#client_id').val()
	var package_id = $('#package').val();
	var package_name = $('#package_name').val();

	var package_component = []; 
	var component_id = GetSelected();
	var skills = [];
	var package_component = [];
	$(".components:checked").each(function(){
		var id = $(this).val();
		if ($(this).val() !='') {
			skills.push($(this).val());
			var form_value = $("#numberOfFomrs"+$(this).val()).val();
		var component_name = $(this).data('component_name');
		 component_name = component_name.replaceAll(' ','_');
		package_component.push({component_id:$(this).val(),form_values:form_value});
		var obj = [];
		// obj.push(form_value); 
			var obj=[] 
	$("#numberOfFomrs"+id+" option:selected").each(function(){
		if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
			obj.push($(this).val()) 
			$('#numberOfFomrs-error'+id).html('')
  		}
	}); 
		selected[component_name.toLowerCase()] = obj
		}
	});

	 	var alacarte_component = [];
	$(".number_OfFomrs:checked").each(function(){
		var id = $(this).val();
		var form_value = $("#number_OfFomrs"+$(this).val()).val();
		skills.push($(this).val());
		var component_name = $(this).data('component_name');
		 component_name = component_name.replaceAll(' ','_');
		alacarte_component.push({component_id:$(this).val(),form_values:form_value});
		// component_id.push($(this).val());
		var obj = [];
		// obj.push(form_value); 
			var obj=[] 
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

	if (files != undefined) {
		$('#error-client').html('');
		// var form_values = JSON.stringify(selected);
		var formdata = new FormData(); 
		formdata.append('files', files);
		// formdata.append('client_id', client_id);
		formdata.append('package_id', package_id);
		formdata.append('package_name', package_name);
		formdata.append('component_id', skills);
		formdata.append('form_values', form_values); 
		formdata.append('alacarte_components', JSON.stringify(alacarte_component)); 
		formdata.append('package_component', JSON.stringify(package_component)); 
		
		$('#error-client').html('<span class="text-warning error-msg-small">Please wait while we are submitting the details</span>');
		 
		$.ajax({
			type: "POST",
		  	url: base_url+"cases/import_excel",
		  	data: formdata,
		  	dataType: "json",
		  	contentType: false,
		    processData: false,
		  	success: function(data){
		  		$('#error-client').html('');
		  		$('#import_excel_file').prop('disabled',false);
		  		$('#import_excel_file').css('background','#005799');
			  	if (data.status == '1') {
			  		toastr.success('New Cases Added successfully.');
					$('#add-bulk-upload-case').val('');
					$('#first-name').val('');
					$('#package').val('');
					$("#father-name").val('');
					$('#document-uploader').val('');
					$('#last-name').val('');
					$('#birth-date').val('');
					$('#joining-date').val('');
					$('#employee-id').val('');
					$('#remark').val('');
					$("#email-id").val(''); 
					$('#contact-no').val('');
						$(".skills:checked").each(function(){
							this.checked = false;
						});

						$(".alacarte_component_names").prop('checked',false);

						$('.is-valid').removeClass('is-valid');
								$('.is-invalid').removeClass('is-invalid');
					$("#case-skills-list").html("");
			  	} else {
			  		toastr.error('OOPS! Something went wrong while adding the Product details. Please try again.');
		  		}
		  	} 
		});
	} else {
		$('#error-client').html('<span class="text-danger error-msg-small">Please select a valid excel sheet.</span>');
	}
}

$("#add-bulk-upload-case").on("change", handleFileSelect_candidate_aadhar); 


function handleFileSelect_candidate_aadhar(e){ 
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file1-error").html('');
        $(".file-name1").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	// if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a> </span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_aadhar.push(files[i]);
	                $(".file-name1").append(html);
	        	// } 
	        }
	    } else {
	    	$("#file1-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#add-bulk-upload-case').val('');
	    }
    } else {
        $("#file1-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}


function removeFile_candidate_aadhar(id) {

    var file = $('#file_candidate_aadhar'+id).data("file");
    for(var i = 0; i < candidate_aadhar.length; i++) {
        if(candidate_aadhar[i].name === file) {
            candidate_aadhar.splice(i,1); 
        }
    }
    if (candidate_aadhar.length == 0) {
    	$("#add-bulk-upload-case").val('');
    }
    $('#file_candidate_aadhar_'+id).remove(); 
}

function add_bulk_cases(){

	var number_candidate = $("#number-of-candidate").val();
	var remarks = $("#client-remarks").val();
	var formdata = new FormData();
		if (candidate_aadhar.length > 0) {
			for (var i = 0; i < candidate_aadhar.length; i++) { 
				formdata.append('bulk_case[]',candidate_aadhar[i]);
			}
		}else{
			formdata.append('bulk_case[]','');
		}
			formdata.append('number_of_candidate',number_candidate);
			formdata.append('remarks',remarks);

			if (candidate_aadhar.length > 0 && number_candidate !='') {
				$("#insert_bulk_data").html("Submitting..");
				$("#insert_bulk_data").attr("disabled",true);
				$.ajax({
            type: "POST",
              url: base_url+"cases/upload_candidate_bulk",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
				if (data.status == '200') {
					candidate_aadhar =[]
					$('#add-bulk-case').modal('hide');
					$("#number-of-candidate").val(1);
					$("#add-bulk-upload-case").val('');
					$("#file1-error").html('');
					$(".file-name1").html('');
					$("#client-remarks").val('');
					toastr.success('Cases are added successfully.'); 
					// window.location.reload();
              	}else{
              		toastr.error('Something went wrong while saving the data. Please try again.'); 	
              	}
              	$("#insert_bulk_data").html("Submit");
              	$("#insert_bulk_data").attr("disabled",false);
              }
            });
			}
}


/**/
$('#view-bulk-case-btn').on('click', function() {
	view_all_bulk_uploads();		
});

function view_all_bulk_uploads() {
	var formdata = new FormData(); 
		formdata.append('verify_client_request', 1);

	$.ajax({
		type: "POST",
	  	url: base_url+"factsuite-client/get-all-bulk-uploads",
	  	data: formdata,
	  	dataType: "json",
	  	contentType: false,
	    processData: false,
	  	success: function(data){
		  	if (data.status == '1') {
		  		var html = '<tr><td colspan="4"><span class="d-block text-center">No Uploaded document found.</span></td></tr>';
				if (data.bulk.length > 0) {
					var cases = data.bulk,
					html = '';
					for (var i = 0; i < cases.length; i++) {
						html += '<tr>';
						html += '<td>'+(i+1)+'</td>';
						html += '<td>'+cases[i].number_of_candidate+'</td>';
						html += '<td>'+cases[i].client_remarks+'</td>';
						html += '<td><span><a onclick="downloadAll(\''+cases[i]['bulk_files']+'\')" href="#"'+cases[i].bulk_files+'"><i class="fa fa-download"></i></a></span></td>';
						html += '</tr>';
					}
				}

				$('#get-bulk-upload-list').html(html);
				$('#view-bulk-case').modal('show');
		  	} else {
		  		toastr.error('OOPS! Something went wrong. Please try again.');
	  		}
	  	} 
	});
}

function view_all_cases() {
	var formdata = new FormData(); 
		formdata.append('verify_client_request', 1);
		formdata.append('case_list_request_type',case_list_request_type);
	$.ajax({
		type: "POST",
	  	url: base_url+"factsuite-client/view-all-cases",
	  	data: formdata,
	  	dataType: "json",
	  	contentType: false,
	    processData: false,
	  	success: function(data) {
		  	if (data.status == '1') {
		  		var html = '<tr><td colspan="9"><span class="d-block text-center">No Case Found.</span></td></tr>';
				if (data.case.length > 0) {
					var cases_main = data.case,
					html = '';
					for (var i = 0; i < cases_main.length; i++) {
						var cases = cases_main[i].candidate;
						var status = '',
							d_none = '',
							case_submitted_date_time = cases.case_submitted_date ? cases.case_submitted_date : '';
							case_submitted_date = '';
							report_generated_date_time = cases.report_generated_date ? cases.report_generated_date : '';
							report_generated_date = '';

						if (cases.is_submitted == 0 || cases.is_submitted == 3) {
							status = '<span class="case-status case-pending">Pending</span>';
						} else if(cases.is_submitted == 1) {
							status = '<span class="case-status case-in-progress">Inprogress</span>';
						} else {
							status = '<span class="case-status case-completed">Completed</span>';
						}

						if (report_generated_date_time != '') {
							report_generated_date = report_generated_date_time.split(' ');
							report_generated_date = report_generated_date[0].split('-');
							// report_generated_date = GetMonthName(report_generated_date[1])+' '+report_generated_date[2]+' '+report_generated_date[0];
							report_generated_date = report_generated_date[2]+'/'+report_generated_date[1]+'/'+report_generated_date[0];
						}

						if (case_submitted_date_time != '') {
							case_submitted_date = case_submitted_date_time.split(' ');
							case_submitted_date = case_submitted_date[0].replaceAll("-", "/");
							// case_submitted_date = GetMonthName(case_submitted_date[1])+' '+case_submitted_date[2]+' '+case_submitted_date[0];
							// case_submitted_date = case_submitted_date[0]+'/'+case_submitted_date[1]+'/'+case_submitted_date[2];
						}

						priority = '';
                    	tat_days_color = '';
                    	tat_days = '';
                    	if(cases.priority == '0') {
                        	priority = '<span class="text-info font-weight-bold">Low</span>';
                        	tat_days_color = '<span class="text-info font-weight-bold">'+cases.low_priority_days+'</span>';
                        	tat_days = cases.low_priority_days;
                    	} else if(cases.priority == '1') {
                        	priority = '<span class="text-warning font-weight-bold">Medium</span>';
                        	tat_days_color = '<span class="text-warning font-weight-bold">'+cases.medium_priority_days+'</span>';
                        	tat_days = cases.medium_priority_days;
                    	} else if(cases.priority == '2') {
                         	tat_days = cases.high_priority_days;
                    	}

                    	// var tat_end_date_1 ='';
	                    // if(cases[i].tat_start_date != null && tat_days != null) {
	                    //     var tat_start_date = cases[i].tat_start_date.split(' ')[0];
	                    //     var tat_start_date = chnageDateFormat(tat_start_date);
	                    //     if(cases[i].tat_end_date != null && cases[i].tat_end_date != '') {
	                    //         var tat_end_date = cases[i].tat_end_date.split(' ')[0];
	                    //         tat_end_date_1 = cases[i].tat_end_date.split(' ')[0];
	                    //         var tat_end_date = chnageDateFormat(tat_end_date);
	                    //     } else {
	                    //         // var tat_end_date = getEndDate(tat_start_date,tat_days);
	                    //         var tat_end_date = workingDaysBetweenDate(tat_start_date,tat_days);
	                    //     }
	                    //     var todayDate = new Date().toJSON().slice(0,10).replace(/-/g,'/');
	                    // } else {
	                    //     var tat_start_date = '-';
	                    //     var tat_end_date = '-';
	                    // }

						html += '<tr>';
						html += '<td style="width: '+sr_no_width+';">'+(i+1)+'</td>';
						html += '<td class="text-capitalize" style="width: '+candidate_name_width+';">'+cases.first_name+'</td>';
						html += '<td style="width: '+candidate_name_width+';">'+cases.phone_number+'</td>';
						// html += '<td style="width: '+candidate_login_id_width+';">'+cases.loginId+'</td>';
						// html += '<td style="width: '+sr_no_width+';">'+cases.otp_password+'</td>';
						html += '<td style="width: '+package_name_width+';">'+cases.pack_name+'</td>';
						html += '<td style="width: '+employee_id_width+';">'+cases.employee_id+'</td>';
						html += '<td style="width: '+status_width+';">'+status+'</td>';
						html += '<td style="width: '+tat_start_date_width+';">'+cases_main[i].case_submitted_date+'</td>';
						html += '<td style="width: '+tat_end_date_width+';">'+cases_main[i].report_generated_date+'</td>';
						html += '<td style="width: '+tat_days_width+';">'+cases_main[i].left_tat_days+'</td>';
						html += '<td style="width: '+actions_width+';">';
						html += '<a href="'+base_url+'factsuite-client/view-single-case/'+cases.candidate_id+'?request_from='+request_from+'"><img src="'+img_base_url+'assets/client/assets-v2/dist/img/black-eye.svg"></a>';
						if (cases.is_submitted != 2 && cases.is_submitted != 1 && cases.candidate_details_added_from == 1) {
							html += '<a class="ml-3" href="javascript:void(0)" onclick="edit_candidate_details_modal('+cases.candidate_id+')"><i class="fa fa-pencil"></i></a>';
						}

						if (cases.is_submitted != 2 && cases.is_submitted != 1 && cases.document_uploaded_by =='client') {
							html += '<a target="_blank" class="ml-3" href="'+base_url+'cases/resume_pending_case/'+cases.candidate_id+'"><i class="fa fa-wpforms"></i></a>';
						}
						html += '</td>';
						html += '</tr>';
					}
				}

				$('#view-all-cases').html(html);
		  	} else {
		  		toastr.error('OOPS! Something went wrong while adding the Product details. Please try again.');
	  		}
	  	} 
	});
}

function downloadAll(files) {
    if(files.length == 0) return;
    links = files.split(',');
	for (var i = 0; i < links.length; i++) {
  		var url = img_base_url+'../uploads/bulk-docs/'+links[i];
  		var a = document.createElement("a");
			a.setAttribute('href', url);
			a.setAttribute('download', '');
			a.setAttribute('target', '_blank');
			a.click();
			a.remove();
    }
}


function chnageDateFormat(date) {
    let monthNames =["Jan","Feb","Mar","Apr",
                      "May","Jun","Jul","Aug",
                      "Sep", "Oct","Nov","Dec"];
     var custom_date = new Date(date);  
     custom_date = custom_date.getDate()+'-'+monthNames[custom_date.getMonth()]+'-'+custom_date.getFullYear(); 
     return custom_date;               
}

function getEndDate(startDate,noOfDaysToAdd){ 
    if (endDate <= startDate) {
        return "Wrong Date";
    }
    startDate = new Date(startDate.replace(/-/g, "/"));
    var endDate = "", count = 0;
    while(count < noOfDaysToAdd){
        endDate = new Date(startDate.setDate(startDate.getDate() + 1));
        if(endDate.getDay() != 0 && endDate.getDay() != 6){
           count++;
        }
    }
 
    return chnageDateFormat(endDate) ;
}

var function_count =0 
let workingDaysBetweenDates = (startDate, endDate) => {
// let workingDaysBetweenDates = (d0, d1) => {
  /* Two working days and an sunday (not working day) */
  // var holidays = ['2016-05-03', '2016-05-05', '2016-05-07'];
  // var startDate = parseDate(startDate);
  // var endDate = parseDate(endDate);  
    console.log('Count: '+ ++function_count)
    console.log('startDate: '+startDate)
    console.log('endDate: '+endDate)
// Validate input
  // if (endDate <= startDate) {
  //   return 0;
  // }

// Calculate days between dates
  var millisecondsPerDay = 86400 * 1000; // Day in milliseconds
  startDate.setHours(0, 0, 0, 1);  // Start just after midnight
  endDate.setHours(23, 59, 59, 999);  // End just before midnight
  var diff = endDate - startDate;  / Milliseconds between datetime objects    /
  var days = Math.ceil(diff / millisecondsPerDay);

  // Subtract two weekend days for every week in between
  var weeks = Math.floor(days / 7);
  days -= weeks * 2;

  // Handle special cases
  var startDay = startDate.getDay();
  var endDay = endDate.getDay();
    
  // Remove weekend not previously removed.   
  if (startDay - endDay > 1) {
    days -= 2;
  }
  // Remove start day if span starts on Sunday but ends before Saturday
  if (startDay == 0 && endDay != 6) {
    days--;  
  }
  // Remove end day if span ends on Saturday but starts after Sunday
  if (endDay == 6 && startDay != 0) {
    days--;
  }
  /* Here is the code */
  // holidays.forEach(day => {
  //   if ((day >= d0) && (day <= d1)) {
      /* If it is not saturday (6) or sunday (0), substract it */
  //     if ((parseDate(day).getDay() % 6) != 0) {
  //       days--;
  //     }
  //   }
  // });
  return days;
}



let workingDaysBetweenDate = (d0, d1) => {
  /* Two working days and an sunday (not working day) */
  // var holidays = $dates;
  var holidays = '';
  // alert(holidays)
  var startDate = parseDate(d0);
  var endDate = parseDate(d1);  

// Validate input
  if (endDate <= startDate) {
    return 0;
  }

// Calculate days between dates
  var millisecondsPerDay = 86400 * 1000; // Day in milliseconds
  startDate.setHours(0, 0, 0, 1);  // Start just after midnight
  endDate.setHours(23, 59, 59, 999);  // End just before midnight
  var diff = endDate - startDate;  // Milliseconds between datetime objects    
  var days = Math.ceil(diff / millisecondsPerDay);

  // Subtract two weekend days for every week in between
  var weeks = Math.floor(days / 7);
  days -= weeks * 2;

  // Handle special cases
  var startDay = startDate.getDay();
  var endDay = endDate.getDay();
    
  // Remove weekend not previously removed.   
  if (startDay - endDay > 1) {
    days -= 2;
  }
  // Remove start day if span starts on Sunday but ends before Saturday
  if (startDay == 0 && endDay != 6) {
    days--;  
  }
  // Remove end day if span ends on Saturday but starts after Sunday
  if (endDay == 6 && startDay != 0) {
    days--;
  }
  /* Here is the code */
  	if(holidays != '') {
	  	holidays.forEach(day => {
	    	if ((day >= d0) && (day <= d1)) {
	      		/* If it is not saturday (6) or sunday (0), substract it */
	      		if ((parseDate(day).getDay() % 6) != 0) {
	        		days--;
	      		}
	    	}
	  	});
  		return days;
	}

	return '-';
}

           
function parseDate(input) {
    // Transform date from text to date
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
  return new Date(parts[0], parts[1]-1, parts[2]); // months are 0-based
}

function differenceBetweenTwoDates(startDate,endDate){
    // var start = $('#start_date').val();
    // var end = $('#end_date').val();

    // // end - start returns difference in milliseconds 
    // var diff = new Date(end - start);

    // // get days
    // var days = diff/1000/60/60/24;


    var start = startDate;
    var end = endDate;

    var diffInDays = end.diff(start, 'days');

    if (diffInDays > 0)
    {
        return diffInDays;
    }
    else
    {
        return 0;
    }
}
