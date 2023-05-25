$('#component-selected').on('change', function() {
	var component_id = $(this).val();
	if (component_id =='') {
		return false;
	}
	$("#component-selected option[value='"+component_id+"']").attr("disabled",true);
	$.ajax({
        type: "POST",
        url: base_url+"factsuite-admin/get-selected-component-details-for-website-package",
        data:{
        	verify_admin_request : 1,
        	component_id : component_id
        },
        dataType: 'json', 
        success: function(data) {
          	var html='';
          	// if (data.pack.length > 0) {
          	// $('#tmp-packages').val(packages);
      		var edu = '';
      		var drug = '';
      		var doc = '';
      		if (data.edu.length > 0) { 	
          		for (var i = 0; i < data.edu.length; i++) { 
          			var disable = '';
          			if (i == 0) {
          				disable = '';
          			}
					edu +='<div class="col-md-2 mt-1">';
          			// edu +='<span class="education_type_name" id="education_type_name'+i+'">'+data.edu[i]['education_type_name']+'</span><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
          			edu +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					edu +='<input type="checkbox" '+disable+' class="custom-control-input input_'+package_id+'_form_'+data.pack['component_id']+'" data-package_id="'+package_id+'" name="education_type_name'+data.edu[i]['education_type_id']+'" value="'+data.edu[i]['education_type_id']+'" id="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'">';
					edu +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'">'+data.edu[i]['education_type_name']+'</label><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
					edu +='</div>';
          			edu +='</div>';
          			edu +='<div class="col-md-2 mt-1">';
					edu +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+'  onkeyup="get_form_input_value('+package_id+','+data.pack['component_id']+','+data.edu[i]['education_type_id']+')" class="form-control fld2 text_form_'+package_id+'_'+data.pack['component_id']+'" id="text_form_'+package_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'" >';
					edu +='</div>'; 
          		}
      		}
          		
      		if (data.drug.length > 0) {	
          		for (var i = 0; i < data.drug.length; i++) { 
          			var disable = '';
          			if (i == 0) {
          				disable = '';
          			}
					drug +='<div class="col-md-2 mt-1">';
          			// drug +='<span class="drug_test_type_name" id="drug_test_type_name'+i+'">'+data.drug[i]['drug_test_type_name']+'</span><input type="hidden" class="form-control fld document_type_id" value="'+data.drug[i]['document_type_id']+'" id="document_type_id'+i+'" >';
          			drug +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					drug +='<input type="checkbox" '+disable+' class="custom-control-input input_'+package_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+package_id+'" name="drug_test_type_name'+data.drug[i]['drug_test_type_id']+'" value="'+data.drug[i]['drug_test_type_id']+'" id="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'">';
					drug +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'">'+data.drug[i]['drug_test_type_name']+'</label><input type="hidden" class="form-control fld drug_test_type_id" value="'+data.drug[i]['drug_test_type_id']+'" id="drug_test_type_id'+i+'" >';
					drug +='</div>';
          			drug +='</div>';
          			drug +='<div class="col-md-2 mt-1">';
					drug +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+'  onkeyup="get_form_input_value('+package_id+','+data.pack['component_id']+','+data.drug[i]['drug_test_type_id']+')" class="form-control fld2 text_form_'+package_id+'_'+data.pack['component_id']+'" id="text_form_'+package_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'" >';
					drug +='</div>'; 
          		}
      		}

      		if (data.doc.length > 0) { 	
          		for (var i = 0; i < data.doc.length; i++) {
          			var disable = '';
          			if (i == 0) {
          				disable = '';
          			}
          			// data.doc[i]
          			doc +='<div class="col-md-2 mt-1">';
          			// doc +='<span class="document_type_name" id="document_type_name'+i+'">'+data.doc[i]['document_type_name']+'</span><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
          			doc +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					doc +='<input type="checkbox" '+disable+' class="custom-control-input input_'+package_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+package_id+'" name="document_type_name'+data.doc[i]['document_type_id']+'" value="'+data.doc[i]['document_type_id']+'" id="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'">';
					doc +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'">'+data.doc[i]['document_type_name']+'</label><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
					doc +='</div>';
          			doc +='</div>';
          			doc +='<div class="col-md-2 mt-1">';
					doc +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+'  onkeyup="get_form_input_value('+package_id+','+data.pack['component_id']+','+data.doc[i]['document_type_id']+')" class="form-control fld2 text_form_'+package_id+'_'+data.pack['component_id']+'" id="text_form_'+package_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'" >';
					doc +='</div>'; 
          		}
      		}
      		// for (var i = 0; i < data.pack.length; i++) { 
				html +='<div class="row ul'+package_id+'">';

				html +='<div class="col-md-12" id="component-error-'+package_id+'_'+data.pack['component_id']+'">&nbsp;</div><br/>';

				html +='<div class="col-md-4 mt-1">';
				
				html +='<div class="custom-control custom-radio custom-control-inline mrg">';
				html +='<input type="radio" class="custom-control-input component_price_type" checked onchange="set_form_value(\''+package_id+'_'+data.pack['component_id']+'\',0)" name="component_price_type'+package_id+'_'+data.pack['component_id']+'" value="0" id="customradio'+package_id+'_'+data.pack['component_id']+'">';
				html +='<label class="custom-control-label" for="customradio'+package_id+'_'+data.pack['component_id']+'">Form Base Price</label>';
				html +='</div>';

      			html +='</div>';
      			html +='<div class="col-md-4 mt-1">'; 

				html +='<div class="custom-control custom-radio custom-control-inline mrg">';
				html +='<input type="radio" class="custom-control-input component_price_type" onchange="set_form_value(\''+package_id+'_'+data.pack['component_id']+'\',1)" name="component_price_type'+package_id+'_'+data.pack['component_id']+'" value="1" id="customradio_'+package_id+'_'+data.pack['component_id']+'">';
				html +='<label class="custom-control-label" for="customradio_'+package_id+'_'+data.pack['component_id']+'">Component Base Price</label>';
				html +='</div>';

      			html +='</div>';
      			html +='<div class="col-md-4 mt-1">';
				html +='';
				html +='</div>';

				html +='<div class="col-md-4 mt-1">';
				html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
				html +='<input type="checkbox" disabled checked class="custom-control-input component_names" data-package_id="'+package_id+'" name="customCheck" value="'+data.pack['component_id']+'" data-component_name="'+data.pack['component_name']+'" id="customCheck'+package_id+'_'+data.pack['component_id']+'">';
				html +='<label class="custom-control-label" for="customCheck'+package_id+'_'+data.pack['component_id']+'">'+data.pack['component_name']+'</label>';
				html +='</div>';
				html +='</div>';
				html +='<div class="col-md-4 mt-1">';
				html +='<label>Component Standard Price</label>';
				html +='<input type="hidden" class="form-control fld2 component_package_id"  value="'+package_id+'" id="component_package_ids'+package_id+'_'+data.pack['component_id']+'">';
				html +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data.pack.component_standard_price+'" id="component_standard_price'+package_id+'_'+data.pack['component_id']+'">';
				html +='</div>';
				html +='<div class="col-md-4 mt-1">';
				html +='<label>Client Standard Price</label>'
				html +='<input type="number" class="form-control fld2 component_price" disabled id="component_price'+package_id+'_'+data.pack['component_id']+'" oninput="oninput_float(\''+package_id+'_'+data.pack['component_id']+'\')" onkeypress="return oninput_fun(event)" onkeyup="component_price(\''+package_id+'_'+data.pack['component_id']+'\')">';
				html +='</div>';
				if (data.pack['component_id'] == 3) {
					html += doc;
				} else if(data.pack['component_id'] == 4) {
					html += drug;
				} else if(data.pack['component_id'] == 7) {
					html += edu;
				} else if (!jQuery.inArray(data.pack['component_id'], [3,4,7]) !== -1) {
					if (data.pack['form_threshold'] > 0) {
						for (var k = 1; k <= data.pack['form_threshold']; k++) {
							var disable = 'disabled';
		          			if (k == 1) {
		          				disable = '';
		          			}	 
							html +='<div class="col-md-2 mt-1">'; 
		          			html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
							html +='<input type="checkbox" '+disable+' onchange="get_form_input_value_check('+package_id+','+data.pack['component_id']+','+k+')" class="custom-control-input input_'+package_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+package_id+'" name="form'+k+'" value="'+k+'" id="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+k+'">';
							html +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+k+'">Form '+k+'</label><input type="hidden" class="form-control fld form" value="'+k+'" id="form_threshold'+k+'" >';
							html +='</div>';
		          			html +='</div>';
		          			html +='<div class="col-md-2 mt-1">';
							html +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+' onkeyup="get_form_input_value('+package_id+','+data.pack['component_id']+','+k+')" class="form-control fld2 text_form_'+package_id+'_'+data.pack['component_id']+'" id="text_form_'+package_id+'_'+data.pack['component_id']+'_'+k+'" >';
							html +='</div>';
						}
					}
				}
				html +='</div>';
				html +='<hr>';
				j++;
      		// }
        // }
        $("#display-component-details").prepend(html);
        }
	});
});

function set_form_value(component_id,status) { 
	var package_id = $("#component-package").val(); 
	if (status == '0') {
		$('.text_form_'+component_id).show();  
		$("#component_price"+component_id).attr('disabled',true);
	} else {
		$('.text_form_'+component_id).hide();
		$("#component_price"+component_id).attr('disabled',false);
	}
	$(".text_form_3_4").hide()
}

function get_form_input_value_check(package,component,index) {
	var sum1 = parseInt(index);
	var sum = sum1 + 1;
	var price_val = $("#customradio_"+package+"_"+component+":checked").val();
	var form_value = $('#text_form_'+package+'_'+component+'_'+index).val(); 
	var checkbox = $('#customradiopackeducheckform_'+package+'_'+component+'_'+index+':checked').val();
	if(checkbox !='' && checkbox !=null){ 
		if (price_val == 1) { 
		  	$('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('disabled',false);
		   	$('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',false); 
		} else {
	 		$('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',false); 
		}
	} else { 
		$('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',true);
		$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',true);
		// $('#text_form_'+package+'_'+component+'_'+sum1).val('');
		$('#text_form_'+package+'_'+component+'_'+sum).val('');
	}
}

function get_form_input_value(package,component,index) {
	var sum1 = parseInt(index);
	var sum = sum1 + 1;
	var form_value = $('#text_form_'+package+'_'+component+'_'+index).val();
	if (form_value !='' && form_value > 0 ) {  
		$('#customradiopackeducheckform_'+package+'_'+component+'_'+index).prop('checked',true);
	}
	var checkbox = $('#customradiopackeducheckform_'+package+'_'+component+'_'+index+':checked').val();
	if(checkbox !='' && checkbox !=null){ 
		$('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',false);
		if (form_value !='' && form_value > 0 ) {  
			$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',false);
			$('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('disabled',false);
			// $('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('checked',true);
		} else { 
			var radio = $('input[name="component_price_type'+package+'_'+component+'"]:checked').val();
			if (radio !='1') { 
				$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',true);
				$('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('disabled',true);
				// $('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('checked',false);
			} else {
				$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',false);
				$('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('disabled',false);
				// $('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('checked',true);
			}
		}
	} else {
		$('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',true);
		$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',true);
	}
	var total = 0;
	$('.text_form_'+package+'_'+component).each(function() {
		if ($(this).val() !='' && $(this).val() !=null) { 
		  	total += parseFloat($(this).val())
		} else {
			total += 0	
		}
	});
	$('#component_price'+package+'_'+component).val(total);
	// customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+k+'
}

$('#client-save-packages-component-btn').on('click',function() {
	$("#package-component-error").fadeIn();
	var package_components = [];
	var added_component_list = [];
	$(".component_names").each(function() {
		var component_id = $(this).val()
		var package_id = $(this).data('package_id')
		var component_name = $(this).data('component_name')
		var MyID = $(this).attr("id");
  		var number = MyID.match(/\d+/); 
  		$('#component-error-'+package_id+'_'+component_id).fadeIn();
		var component_package_ids = $("#component_package_ids"+number).val();
		var component_standard_price = $("#component_standard_price"+package_id+'_'+component_id).val();
		var component_price = $("#component_price"+package_id+'_'+component_id).val();
		var form_data = []; 
		var checkbox =  $('input[name="component_price_type'+package_id+'_'+component_id+'"]:checked').val();

		if ( component_price =='' || component_price ==null ) {
			$('#component-error-'+package_id+'_'+component_id).html('<span class="text-danger text-center error-msg-small">Please enter component client price.</span>').fadeOut(5000);
			return false;
		}

		$(".input_"+package_id+"_form_"+component_id+":checked").each(function() {
			$('#component-error-'+package_id+'_'+component_id).html('');
			var form_id = $(this).val();
			var form_value = $("#text_form_"+package_id+"_"+component_id+"_"+form_id).val();
			var form_values = ''; 
			if (form_value != '' && form_value != null) { 
				form_values = form_value;
				$('#component-error-'+package_id+'_'+component_id).html('');
			} else {
				if (checkbox != 1) {
					$('#component-error-'+package_id+'_'+component_id).html('<span class="text-danger error-msg-small">Please enter form value.</span>');
					return false;
				}
			}
			form_data.push({form_id:form_id,form_value:form_values});
		});
		added_component_list.push(component_id);
		added_component_list = added_component_list.sort();
		added_component_list.sort(function(a, b) {
			return a - b;
		});
		package_components.push({type_of_price:checkbox,component_id:component_id,component_name:component_name,package_id:package_id,component_standard_price:component_standard_price,component_price:component_price,form_data:form_data})
	});

	$("#package-component-error").fadeIn(); 
	var missing_component_list = [];
	var selected_component_list_array = selected_component_list.split(',');
	if(added_component_list.length > 0) {
		selected_component_list_array.sort(function(a, b) {
    		return a - b;
		});
		missing_component_list = selected_component_list_array.filter((i => a => a !== added_component_list[i] || !++i)(0));
	} else {
		missing_component_list = selected_component_list_array;
		missing_component_list.sort(function(a, b) {
    		return a - b;
		});
	}

	if (package_components.length == 0) {
		return false;
		$("#package-component-error").html('<span class="text-danger">Please select and enter package component value.</span>');
	}

	if(missing_component_list != '') {
		if(missing_component_list.length > 0) {
			toastr.error('Please enter all the values for selected components of this service package.'); 
			return false;
		}
	}
	var formdata = new FormData();
	formdata.append('verify_admin_request',1);
	formdata.append('package_id',package_id);
	// formdata.append('package',package);
	formdata.append('package_components',JSON.stringify(package_components));
	$("#client-save-packages-component-btn").attr('disabled',true);
	$('#package-component-error').html('<span class="text-warning error-msg-small">Please wait while we are updating the component details.</span>');
    $.ajax({
		type: "POST",
		url: base_url+"factsuite-admin/add-new-component-details-for-website-package",
		data:formdata,
		dataType: 'json',
		contentType: false,
		processData: false,
		success: function(data) {
			$('#package-component-error').html('');
			$("#client-save-packages-component-btn").attr('disabled',false);
			if (data.status == '1') {  
				if(data.service_package_details.status == 1) {
					if (selected_alacarte_component_list != '') {
                		window.location.href = base_url+'factsuite-admin/edit-website-package-alacarte-component-details?package_id='+package_id;
					} else {
						toastr.success('Service package component details has been updated successfully.'); 
						setTimeout(function() { 
							window.location.href = base_url+'factsuite-admin/add-website-package';
						}, 2000);
					}
				} else {
					toastr.error('Something went wrong while updating the service package component details. Please try again.');
				}
            } else { 
                toastr.error('Something went wrong while product ordering. Please try again.'); 
                $("#package-component-error").html('<span class="text-danger error-msg-small">Please fill the all package components. try again.</span>').fadeOut(5000);
            } 
            $("#client-error").html("");
        },
        error : function(data) {
        	$('#package-component-error').html('');
        	$("#client-save-packages-component-btn").attr('disabled',false);
        	toastr.error('Something went wrong while updating the service package component details. Please try again.');
        }
    }); 
});