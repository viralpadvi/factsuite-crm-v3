get_country_code();
function get_country_code() {
	$.ajax({
  		type: "POST",
  		url: base_url+"factsuite-inputqc/get-country-code-list", 
		dataType: 'json',
		contentType: false,
	    processData: false,
		success: function(data) {
			$('#country-code').html('<option value="+91">+91 (India)</option>');
			for (var i = 0; i < data.length; i++) {
				if (data[i].dial_code != '+91') {
					$('#country-code').append('<option value="'+data[i].dial_code+'">'+data[i].dial_code+' ('+data[i].name+')</option>');
				}
			}
  		}
	});
}

$("#edit-case-btn-v2-confirm").on('click',function(){
	$("#insert_data").attr('disabled',false);
})

$('#document_uploded_by_inputqc').hide()
$('#document_uploaded_by').on('change',function(){
	// if($(this).val() == 'inputqc'){
	// 	$('#document_uploded_by_inputqc').show()	
	// }else{
	// 	$('#document_uploded_by_inputqc').hide()
	// }
	
});

$('#client_id').on('change',function() {
	$('#cost-center').html('<option value="">Cost Center</option>');
	get_client_cost_center_list();
	clientIdChecke()
	getPackage($(this).val())
	// get_alacarte_data($(this).val())
	// get_alacarte_component($(this).val())
});

$('#title').on('change',function(){
	titleCheck()
});

$('#first_name').on('keyup blur',function(){
	firstNameCheck()
});

$('#last_name').on('keyup blur',function(){
	lastNameCheck()
});

$('#father_name').on('keyup blur',function(){
	fatherNameCheck()
});

$('#phone_number').on('keyup blur',function(){
	phoneNumberCheck()
});

$('#email_id').on('keyup blur',function(){
	emailIdCheck()
});

$('#document_uploded_by_email_id').on('keyup',function(){
	documentUploderEmailCheck()
});

$('#date_of_birth').on('change',function(){
	dobCheck()
});

$('#date_of_joining').on('change',function(){
	dojCheck()
});

$('#employee_id').on('keyup blur',function(){
	employeeIdCheck()
});

$('#remarks').on('keyup blur',function(){
	remarkCheck()
});

$('#document_uploaded_by').on('keyup blur',function(){
	documentUplodedBy()
});
 
$('#package_id').on('change',function(){
	packageId()
	getPkgdata($(this).val())
	
});


$('#priority').on('change',function(){
	case_priority();
})

function get_client_cost_center_list() {
	var html = '<option value="">Cost Center</option>';
	if ($('#client_id').val() != '') {
		$.ajax({
			type: "POST",
		  	url: base_url+"factsuite-inputqc/get-client-cost-center-list",
		  	data: {
		  		client_id : $('#client_id').val()
		  	},
		  	dataType: "json",
		  	success: function(data) {
		  		if(data.cost_center_list.length > 0) { 
		  			var cost_center_list = data.cost_center_list;
		  			for(var i = 0; cost_center_list.length > i ;i++){
		  				html += '<option value="'+cost_center_list[i].location_id+'">'+cost_center_list[i].location_name+'</option>';
		  			}
		  			$('#cost-center').html(html);
		  		}
		  	}
		});
	} else {
		$('#cost-center').html('<option value="">Cost Center</option>');
	}
}

function get_alacarte_data(id){
	// alert(id)
	$.ajax({
			type: "POST",
		  	url: base_url+"package/get_client_single_data/"+id, 
		  	dataType: "json",
		  	success: function(data){  
		  		var alacarte_components = JSON.parse(data.alacarte_components);
		  		
		  		var html = '';

		  		html += '<option selected value="">Select your package</option>';
		  		if(alacarte_components.length > 0){ 
		  			for(var i=0; alacarte_components.length > i ;i++){
		  				html += '<option value="'+alacarte_components[i].component_id+'">'+alacarte_components[i].component_name+'</option>';
		  			}

		  		}else{
		  			html += '<option value="">No component avilable</option>';
		  		}

		  		$('#alacarte_components').html(html)
		  	}
		});
}


$("#alacarte_components_ids").on('click','.number_OfFomrs',function(){ 
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


$("#request_form_submit").on('click',function(){
	$("#request_form_submit").attr('disabled',true);
	$("#request_form_submit").html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
	var request_comonent_id = $("#request_comonent_id").val();
	var request_number_of_form = $("#request_number_of_form").val();
	var package_id = $("#package_id").val();
	var client_id = $("#client_id").val();
	if (request_number_of_form =='') {
		return false;
	}

	$.ajax({
	          type: "POST",
	          url: base_url+"inputQc/add_request_form/",
	          data:{comonent_id:request_comonent_id,number_of_form:request_number_of_form,package_id:package_id,client_id:client_id},
	          dataType: 'json', 
	          success: function(data) { 
	          	if (data.status =='1') { 
	          		toastr.success('Successfully Form requesting.'); 
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
 

function getPkgdata(id=''){ 


	var client_id  = $('#client_id').val();
	
	if(id != '' && client_id !=''){
	  $.ajax({
	    type: "POST",
	    url: base_url+"package/get_single_component_data/"+id+"/"+client_id, 
	    dataType: "json",
	    async:false,
	    success: function(data){ 
	    	console.log(JSON.stringify(data.client.package_components))
	    	var package_components = JSON.parse(data.client.package_components);  
	    	
	    	var components = data.package_data[0];
	      	var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
	      	
			
	      	// return false;
	      	$('#edit_package_id').val(id);
			var package = $('#package_id').val();
	      	let comp='';
	      	var component_ids = data.package_data[0].component_ids.split(',');
	      	component_ids.reverse()
	      	for (var i = 0; i < package_components.length; i++) {
			if (package_components[i]['package_id'] == package) {
	      		
	      		var index_num = component_ids.indexOf(package_components[i].component_id);
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
				    comp +='<label class="custom-control-label" for="componentCheck'+package_components[i].component_id+'">'+components[component_config_name].split(',')[index_num]
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



function get_alacarte_component(id=''){ 

	// var id = $(this).val();
	var client_id  = $('#client_id').val();
	$("#alacarte_components option[value='"+id+"']").attr("disabled",true);
	
	if(id != '' && client_id !=''){
	  $.ajax({
	    type: "POST",
	    url: base_url+"package/get_single_component_data/"+id+"/"+client_id, 
	    dataType: "json",
	    async:false,
	    success: function(data){ 
	    	// console.log(data.client.package_components)
	    	
	    	var package_components = JSON.parse(data.client.alacarte_components);
	    	// alert(package_components.length)
	    	// console.log(JSON.stringify(data.package_data[1].education_type))

	      	// var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
	      	
			
	      	// return false;
	      	$('#edit_package_id').val(id);
	      	

	      	let comp='';
	      
	      	for (var i = 0; i < package_components.length; i++) {

	      		 
			    	var component =  package_components[i].component_name;
			    	var component_name = component.replaceAll(/\s+/g, '_').trim();
				
	      		comp +='<div class="col-md-4">'
			      	comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
				    comp +='<input  data-component_name="'+component_name+'" type="checkbox" ';
					    comp +='class="custom-control-input alacarte_component_names" value="'+package_components[i].component_id+'" ';
					    comp +='name="component_Check" id="component_Check'+package_components[i].component_id+'">';
				    comp +='<label class="custom-control-label" for="component_Check'+package_components[i].component_id+'">'+package_components[i][component_config_name]
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
	    	$('#alacarte_components_ids').html(comp)
	    }
	  });
	 
	}else{
		let comp='';
		comp +='<div class="col-md-4">'
			
	    comp +=' </div>'
	    $('#alacarte_components_ids').html(comp)
	}
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
 
function select_skill_form(id) {
    if($("input[id=componentCheck"+id+"]").prop('checked') == true) { 
    	$('#numberOfFomrs'+id).attr( "disabled", false )  
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
 
// function numberOfFormShoudNotBeZero(id){
// 	var formsValue = $('#numberOfFomrs'+id).val()

// 	if(formsValue > '0'){

// 	}
// }

function save_case(){
	// btn_disabled('#insert_data')


	$('#wait-message').html('Please,Wait we are saveing your data.')
	$('#wait-message').addClass('text-warning')
 	$('#insert_data').attr('disabled',true); 
 	$('#insert_data').addClass('buttonload');
 	$('#insert_data').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');

 

	var client_id = $('#client_id').val()
	var title = $('#title').val()
	var first_name = $('#first_name').val()
	var last_name = $('#last_name').val()
	var father_name = $('#father_name').val()
	var phone_number = $('#phone_number').val()
	var email_id = $('#email_id').val()
	var date_of_birth = $('#date_of_birth').val()
	var date_of_joining = $('#date_of_joining').val()
	var employee_id = $('#employee_id').val();
	var package_id = $('#package_id').val();
	var package_name = $('#package_name').val();
	var remarks = $('#remarks').val();
	var document_uploaded_by = $('#document_uploaded_by').val();
	var document_uploaded_by_email_id = $('#document_uploded_by_email_id').val();
	var priority = $('#priority').val();
	var cost_center = $('#cost-center').val();
	var segment = $('#segment').val();
	// if(document_uploaded_by != 'inputqc'){
	// 	document_uploaded_by_email_id = email_id
	// }
	var package_component = [];
	var skills = [];
	$(".components:checked").each(function(){
		var id = $(this).val();
		var form_value = $("#numberOfFomrs"+$(this).val()).val();
		var component_name = $("#numberOfFomrs"+$(this).val()).data('component_name');
		package_component.push({component_id:$(this).val(),form_values:form_value});
		var obj = [];
		skills.push(id); 

		$("#numberOfFomrs"+id+" option:selected").each(function(){
		if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
			obj.push($(this).val()) 
			$('#numberOfFomrs-error'+id).html('')
  		}
	}); 
		selected[component_name.toLowerCase()] = obj
	});


		var not_allowed = ['5','6','8','9'];
	var flag = 0;
	for (var i = 0; i < skills.length; i++) {
		if(jQuery.inArray(skills[i], not_allowed) === -1) { 
    		var comp_val = $("#numberOfFomrs"+skills[i]).val();
    		if (comp_val == 0 || comp_val == '' || comp_val == 'more') {
    			$('#numberOfFomrs-error'+skills[i]).html("<span class='text-danger error-msg-small'>Please select at list one valid value.</span>");
    			flag = 1;
    			$('#insert_data').attr('disabled',false); 
				$('#insert_data').removeClass('buttonload');
				$('#insert_data').html("SUBMIT &amp; SAVE");
				$('#wait-message').html('')
    		}
		}
	} 

	var component_id = GetSelected();
 	// alert("email_id: "+email_id)
 	// alert("document_uploaded_by_email_id: "+document_uploaded_by_email_id) 
 	var alacarte_component = [];
	$(".alacarte_component_names:checked").each(function(){
		var id = $(this).val();
		var form_value = $("#number_OfFomrs"+$(this).val()).val();
		var component_name = $(this).data('component_name');
		alacarte_component.push({component_id:$(this).val(),form_values:form_value});
		skills.push($(this).val());
		var obj = [];
		// obj.push(form_value); 
		$("#number_OfFomrs"+id+" option:selected").each(function(){
		if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0'&& $(this).val() != 'more') { 
			obj.push($(this).val()) 
			// $('#numberOfFomrs-error'+id).html('')
  		}
	}); 
		selected[component_name.toLowerCase()] = obj
	});


 	var form_values =  JSON.stringify(selected);

 	var inputqc = $("#inputqc-name").val();
 	 
	var formdata = new FormData();
	formdata.append('inputqc', inputqc);
	formdata.append('client_id', client_id);
	formdata.append('title', title);
	formdata.append('first_name',first_name );
	formdata.append('last_name', last_name);
	formdata.append('father_name', father_name);
	formdata.append('country_code', $('#country-code').val());
	formdata.append('phone_number',phone_number );
	formdata.append('email_id',email_id );
	formdata.append('date_of_birth',date_of_birth );
	formdata.append('date_of_joining', date_of_joining);
	formdata.append('employee_id', employee_id);
	formdata.append('package_id',package_id );
	formdata.append('package_name',package_name );
	formdata.append('remarks', remarks);
	formdata.append('document_uploaded_by',document_uploaded_by );
	formdata.append('document_uploaded_by_email_id', document_uploaded_by_email_id);
	formdata.append('component_id', skills);
	formdata.append('form_values', form_values); 
	formdata.append('segment', segment); 
	formdata.append('priority', priority); 
	formdata.append('cost_center',cost_center);
	formdata.append('alacarte_components', JSON.stringify(alacarte_component)); 
	formdata.append('package_component', JSON.stringify(package_component)); 


	if (flag == 1) { return false; }
	$('#CheckAll').prop('checked', false);
	// var mobielNumberUniq = checkMobileNumerExits('inputQc/checkMobileNumber',phone_number);
	/*if(mobielNumberUniq){
		input_is_invalid('#phone_number')
 		$('#contact-no-error').html('<span class="text-danger error-msg-small">This mobile number is already registered.</span>');
		  		$('#insert_data').attr('disabled',false); 
	$('#insert_data').removeClass('buttonload');
	$('#insert_data').html("SUBMIT &amp; SAVE");
	$('#wait-message').html('');
	
 	}else{*/
 		// alert('else')
	 	if(client_id != '0' && title != '' && first_name != '' && father_name != '' && 
			phone_number != '' && phone_number.length == 10 && email_id != '' && package_id != '' 
			&& remarks != '' && document_uploaded_by != '' &&  priority != '3'){

			if(document_uploaded_by.toLowerCase() == 'inputqc'){
				// if(document_uploaded_by_email_id != '' && regex.test(document_uploaded_by_email_id)){ 

					// insert 
					$.ajax({
						type: "POST",
					  	url: base_url+"inputQc/insertCase",
					  	data: formdata,
					  	dataType: "json",
					  	contentType: false,
			    		processData: false,
					  	success: function(data) {
					  		
							
						 	$('#insert_data').attr('disabled',false); 
						 	$('#insert_data').removeClass('buttonload');
						 	$('#insert_data').html("SUBMIT &amp; SAVE");
					 
					   		if (data.status == '1' ) {
					  			$('#wait-message').html('Case Inserted successfully.')
					  			$('#wait-message').addClass('text-success')


					  			$('.is-valid').removeClass('is-valid');
								$("#components_ids").html('')
					  			
						  		let html = "<span class='text-success'>Success data inserted</span>";
								$('#error-team').html(html);

								if(data.email_status == '1'){
									toastr.success('New data has been insert successfully.');
								}else if(data.email_status == '0'){
									toastr.success('New data has been insert successfully but email didn\'t send.');
								}
								
								 $(".alacarte_component_names").prop('checked',false);
								$("#client_id").val('0');
								$("#title").val('');
								$("#first_name").val('');
								$("#last_name").val('');
								$("#father_name").val('');
								$('#country-code').val('+91');
								$("#phone_number").val('');
								$("#email_id").val('');
								$("#date_of_birth").val('');
								$("#date_of_joining").val('');
								$("#employee_id").val('');
								$("#package_id").val('');
								$("#package_name").val('');
								$("#remarks").val('');
								$("#document_uploaded_by").val('candidate');
								$("#component_id").val('');
								$('#components_ids').html('')
								$('#priority').val('3')
								$('#client_id, #title, #first_name, #last_name, #father_name, #phone_number, #email_id, #date_of_birth, #date_of_joining, #employee_id, #package_id, #package_name, #remarks, #document_uploaded_by, #document_uploded_by_email_id').val('');
								$('#priority','#client_id, #title, #first_name, #last_name, #father_name, #phone_number, #email_id, #date_of_birth, #date_of_joining, #employee_id, #package_id, #package_name, #remarks, #document_uploaded_by, #document_uploded_by_email_id').removeClass('is-valid is-invalid'); 
						  	
						  		// <i class="fa fa-refresh fa-spin"></i><span> Loading</span>
						  		if(document_uploaded_by.toLowerCase() == 'inputqc') {
						  			window.location.href = candidate_url_for_redirecting_to_candidate_module;
						  		}
						  	} else {
						  		let html = "<span class='text-danger'>Somthing went wrong.</span>";
								$('#error-team').html(html);
													  		$('#insert_data').attr('disabled',false); 
							$('#insert_data').removeClass('buttonload');
							$('#insert_data').html("SUBMIT &amp; SAVE");
								toastr.error('New data has been insert failed.');
					  		}
				  		},
					  	error: function(data) {
					  		$('#insert_data').attr('disabled',false); 
							$('#insert_data').removeClass('buttonload');
							$('#insert_data').html("SUBMIT &amp; SAVE");
							$('#wait-message').html('')
							toastr.error('OOPS! Something went wrong while adding the case. Please try again.');
							// btn_enabled('#insert_data');
						}
				  	});
					// alert("inputqc")

				// }else{
				// 	documentUploderEmailCheck()
				// }
			}else{
				// insert
				$.ajax({
						type: "POST",
					  	url: base_url+"inputQc/insertCase",
					  	data: formdata,
					  	dataType: "json",
					  	contentType: false,
			    		processData: false,
					  	success: function(data) {
					  		$('#insert_data').attr('disabled',false); 
						 	$('#insert_data').removeClass('buttonload');
						 	$('#insert_data').html("SUBMIT &amp; SAVE");
					 		$('#wait-message').html('')
					  		
					  		if (data.status == '1') {
					  			$('#wait-message').html('Case Inserted successfully.')
					  			$('#wait-message').addClass('text-success')
						  		// let html = "<span class='text-success'>Success data inserted</span>";
								// $('#error-team').html(html);
								toastr.success('New data has been insert successfully.');
								$('.is-valid').removeClass('is-valid');
								$("#components_ids").html('')
								 
								$("#client_id").val('0');
								$("#title").val('');
								$("#first_name").val('');
								$("#last_name").val('');
								$("#father_name").val('');
								$("#phone_number").val('');
								$("#email_id").val('');
								$("#date_of_birth").val('');
								$("#date_of_joining").val('');
								$("#employee_id").val('');
								$("#package_id").val('');
								$("#package_name").val('');
								$("#remarks").val('');
								$("#document_uploaded_by").val('candidate');
								$("#component_id").val('');
								$("#priority").val('3');
								 
								$('#client_id, #title, #first_name, #last_name, #father_name, #phone_number, #email_id, #date_of_birth, #date_of_joining, #employee_id, #package_id, #package_name, #remarks, #document_uploaded_by, #document_uploded_by_email_id').val('');
								$('#priority','#client_id, #title, #first_name, #last_name, #father_name, #phone_number, #email_id, #date_of_birth, #date_of_joining, #employee_id, #package_id, #package_name, #remarks, #document_uploaded_by, #document_uploded_by_email_id').removeClass('is-valid is-invalid'); 
						  	
						  	} else {
						  		let html = "<span class='text-danger'>Somthing went wrong.</span>";
								$('#error-team').html(html);
								toastr.error('New data has been insert failed.');
					  		}
				  		},
					  	error: function(data) {
					  		$('#insert_data').attr('disabled',false); 
							$('#insert_data').removeClass('buttonload');
							$('#insert_data').html("SUBMIT &amp; SAVE");
							$('#wait-message').html('')
							toastr.error('OOPS! Something went wrong while adding the case. Please try again.');
							// btn_enabled('#insert_data');
						}
				  	});
			}
			  
		}else{
			$('#insert_data').attr('disabled',false); 
				$('#insert_data').removeClass('buttonload');
				$('#insert_data').html("SUBMIT &amp; SAVE");
				$('#wait-message').html('')
			toastr.error('OOPS! Something went wrong while adding the case. Please try again.');
			case_priority();
			clientIdChecke();
			titleCheck() 
			firstNameCheck() 
			lastNameCheck()
			fatherNameCheck() 
			phoneNumberCheck() 
			emailIdCheck() 
			dobCheck() 
			dojCheck() 
 			employeeIdCheck() 
			packageId() 
			remarkCheck()
			documentUplodedBy() 
							// btn_enabled('#insert_data');
		}
 	}
// }
 

function case_priority(){
	if($('#priority').val() == '3'){
		input_is_invalid('#priority')
		// $('#priority-error').html('select any one priority.')
		// $('#priority-error').addClass('text-danger')
	}else{
		input_is_valid('#priority')
		// $('#priority-error').html('&nbsp;')
		// $('#priority-error').removeClass('text-danger')
	}
}
function clientIdChecke(){
	if($('#client_id').val() == '0'){
		input_is_invalid('#client_id')
	}else{
		input_is_valid('#client_id')
	}
}
function titleCheck(){
	if($('#title').val() == ''){
		input_is_invalid('#title')
	}else{
		input_is_valid('#title')
	}
}

function firstNameCheck(){
	if($('#first_name').val() == ''){
		input_is_invalid('#first_name')
	}else{
		input_is_valid('#first_name')
	}
}

function lastNameCheck(){
	if($('#last_name').val() == ''){
		input_is_invalid('#last_name')
	}else{
		input_is_valid('#last_name')
	}
}

function fatherNameCheck(){
	if($('#father_name').val() == ''){
		input_is_invalid('#father_name')
	}else{
		input_is_valid('#father_name')
	}
}

function phoneNumberCheck(){
	var phone_number = $('#phone_number').val() 
	if(phone_number == ''){
		input_is_invalid('#phone_number')
	}else{
		if(isNaN(phone_number)) {
      		$('#contact-no-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 digit.</span>');
      		$(this).val(phone_number.slice(0,mobile_number_length));
      		input_is_invalid('#phone_number')

    	} else if (phone_number.length != mobile_number_length) {
    		$('#contact-no-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 digit.</span>');
      		$(this).val(phone_number.slice(0,mobile_number_length));
      		input_is_invalid('#phone_number')
      		
    	} else {
    		if(checkMobileNumerExits('inputQc/checkMobileNumber',phone_number)){
      			input_is_invalid('#phone_number')
 				$('#contact-no-error').html('<span class="text-danger error-msg-small">This mobile number is already registered.</span>');
	
      		}
      		$('#contact-no-error').html('&nbsp;');
      		input_is_valid("#phone_number")
      		
      		var mobielNumberUniq = checkMobileNumerExits('inputQc/checkMobileNumber',phone_number);
				if(mobielNumberUniq){
					input_is_invalid('#phone_number')
					$("#msg-for-the-warning").html('A case already exists with the entered mobile number you have entered.Do you want to create a duplicate?');
					$("#add-new-case-v2-confirm").modal('show');
			 		$('#contact-no-error').html('<span class="text-danger error-msg-small">This mobile number is already registered.</span>');
					  		$('#insert_data').attr('disabled',false); 
				$('#insert_data').removeClass('buttonload');
				$('#insert_data').html("SUBMIT &amp; SAVE");
				$('#wait-message').html('');
				
			 	}
    	}
	}
}

 function emailIdCheck(){
 	var email_id = $('#email_id').val();
	if(email_id == ''){
		input_is_invalid('#email_id')
	}else{
		 if(!regex.test(email_id)) {
	    	input_is_invalid("#email_id")
			$('#email-id-error').html("<span class='text-danger error-msg'>Please enter a valid email.</span>");
	    } else {
	        $('#email-id-error').html("&nbsp;");
	        input_is_valid("#email_id")
	    	valid_email_check(email_id);

	    }
		 
	}
 }


function valid_email_check(email){
	  $.ajax({
	          type: "POST",
	          url: base_url+"inputQc/valid_mail/",
	          data:{email:email},
	          dataType: 'json', 
	          success: function(data) {

	          	if (data.status =='1') {
	          		$("#insert_data").attr('disabled',false);
	          		input_is_valid('#email_id');
			        $('#email-id-error').html("&nbsp;");
			    }else{
			    	$("#msg-for-the-warning").html('A case already exists with the entered email ID you have entered.Do you want to create a duplicate?');
			    	$("#add-new-case-v2-confirm").modal('show');
			    	$("#insert_data").attr('disabled',true);
			    	input_is_invalid('#email_id'); 
					$('#email-id-error').html('<span class="text-danger error-msg">This email id already exists</span>');
			    }

	          }
     	 });
}



function documentUploderEmailCheck(){

	var email_id = $('#document_uploded_by_email_id').val();
	var email_regex = regex;
	if(email_id == ''){
		input_is_invalid('#document_uploded_by_email_id')
	}else{
		 if(!email_regex.test(email_id)) { 
			$('#inputqc-email-error').html("<span class='text-danger error-msg'>Please enter a valid email.</span>");
	    	input_is_invalid("#document_uploded_by_email_id")
	    } else { 
	        $('#inputqc-email-error').html("&nbsp;");
	        input_is_valid("#document_uploded_by_email_id")
	    }
		 
	}
}
 


function dobCheck(){
	if($('#date_of_birth').val() == ''){
		input_is_invalid('#date_of_birth')
	}else{
		input_is_valid('#date_of_birth')
	}
}
 


function dojCheck(){
	if($('#date_of_birth').val() == '' || $('#date_of_birth').val() == null){
		input_is_invalid('#date_of_birth')
	}else{
		input_is_valid('#date_of_birth')
	}
}
 


function employeeIdCheck(){
	if($('#employee_id').val() == ''){
		input_is_invalid('#employee_id')
	}else{
		input_is_valid('#employee_id')
	}
}

function packageId(){
	if($('#package_id').val() == '' || $('#package_id').val() == null){
		input_is_invalid('#package_id')
	}else{
		input_is_valid('#package_id')
	}
}

function remarkCheck(){
	if($('#remarks').val() == ''){ 
		input_is_invalid('#remarks')
	}else{
		input_is_valid('#remarks')
	}
}

function documentUplodedBy(){

	if($('#document_uploaded_by').val() == ''){
		input_is_invalid('#document_uploaded_by')
	}else{
		input_is_valid('#document_uploaded_by')
	}
}
 



function import_excel(){
	var files = $('#add-bulk-upload-case')[0].files[0];
	var client_id = $('#client_id').val()
	var package_id = $('#package_id').val();
	var package_name = $('#package_name').val();

	var package_component = [];
	var skills = [];
	$(".components:checked").each(function(){
		var id = $(this).val();
		var form_value = $("#numberOfFomrs"+$(this).val()).val();
		var component_name = $("#numberOfFomrs"+$(this).val()).data('component_name');
		package_component.push({component_id:$(this).val(),form_values:form_value});
		var obj = [];
		skills.push(id); 

		$("#numberOfFomrs"+id+" option:selected").each(function(){
		if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0') { 
			obj.push($(this).val()) 
			$('#numberOfFomrs-error'+id).html('')
  		}
	}); 
		selected[component_name.toLowerCase()] = obj
	});


		var not_allowed = ['5','6','8','9'];
	var flag = 0;
	for (var i = 0; i < skills.length; i++) {
		if(jQuery.inArray(skills[i], not_allowed) === -1) { 
    		var comp_val = $("#numberOfFomrs"+skills[i]).val();
    		if (comp_val == 0 || comp_val == '' || comp_val == 'more') {
    			$('#numberOfFomrs-error'+skills[i]).html("<span class='text-danger error-msg-small'>Please select at list one valid value.</span>");
    			flag = 1;
    			$('#insert_data').attr('disabled',false); 
				$('#insert_data').removeClass('buttonload');
				$('#insert_data').html("SUBMIT &amp; SAVE");
				$('#wait-message').html('')
    		}
		}
	} 

	var component_id = GetSelected();
 	// alert("email_id: "+email_id)
 	// alert("document_uploaded_by_email_id: "+document_uploaded_by_email_id) 
 	var alacarte_component = [];
	$(".alacarte_component_names:checked").each(function(){
		var id = $(this).val();
		var form_value = $("#number_OfFomrs"+$(this).val()).val();
		var component_name = $(this).data('component_name');
		alacarte_component.push({component_id:$(this).val(),form_values:form_value});
		skills.push($(this).val());
		var obj = [];
		// obj.push(form_value); 
		$("#number_OfFomrs"+id+" option:selected").each(function(){
		if ($(this).val() !='' && $(this).val() !=null && $(this).val() != '0'&& $(this).val() != 'more') { 
			obj.push($(this).val()) 
			// $('#numberOfFomrs-error'+id).html('')
  		}
	}); 
		selected[component_name.toLowerCase()] = obj
	});
	if (flag == 1) { return false; }

	if (files != undefined) {
		$('#wait-message').html('');
		var form_values = JSON.stringify(selected);
		var formdata = new FormData(); 
		formdata.append('files', files);
		formdata.append('client_id', client_id);
		formdata.append('package_id', package_id);
		formdata.append('package_name', package_name);
		formdata.append('component_id', skills);
		formdata.append('form_values', form_values); 
		formdata.append('alacarte_components', JSON.stringify(alacarte_component)); 
		formdata.append('package_component', JSON.stringify(package_component)); 
		
		$('#wait-message').html('<span class="text-warning error-msg-small">Please wait while we are submitting the details</span>');
		 
		$.ajax({
			type: "POST",
		  	url: base_url+"inputQc/import_excel",
		  	data: formdata,
		  	dataType: "json",
		  	contentType: false,
		    processData: false,
		  	success: function(data){
		  		$('#wait-message').html('');
		  		$('#import_excel_file').prop('disabled',false);
		  		$('#import_excel_file').css('background','#005799');
			  	if (data.status == '1') {
			  		toastr.success('New Cases Added successfully.');
					$('#add-bulk-upload-case').val('');
					 $(".alacarte_component_names").prop('checked',false);
								$("#client_id").val('0');
								$("#title").val('');
								$("#first_name").val('');
								$("#last_name").val('');
								$("#father_name").val('');
								$("#phone_number").val('');
								$("#email_id").val('');
								$("#date_of_birth").val('');
								$("#date_of_joining").val('');
								$("#employee_id").val('');
								$("#package_id").val('');
								$("#package_name").val('');
								$("#remarks").val('');
								$("#document_uploaded_by").val('candidate');
								$("#component_id").val('');
								$('#components_ids').html('')
								$('#priority').val('3')
								$('#client_id, #title, #first_name, #last_name, #father_name, #phone_number, #email_id, #date_of_birth, #date_of_joining, #employee_id, #package_id, #package_name, #remarks, #document_uploaded_by, #document_uploded_by_email_id').val('');
								$('#priority','#client_id, #title, #first_name, #last_name, #father_name, #phone_number, #email_id, #date_of_birth, #date_of_joining, #employee_id, #package_id, #package_name, #remarks, #document_uploaded_by, #document_uploded_by_email_id').removeClass('is-valid is-invalid'); 
						  	
			  	} else {
			  		toastr.error('OOPS! Something went wrong while adding the Product details. Please try again.');
		  		}
		  	} 
		});
	} else {
		$('#wait-message').html('<span class="text-danger error-msg-small">Please select a valid excel sheet.</span>');
	}
}


