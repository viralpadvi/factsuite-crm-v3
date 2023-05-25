function get_package_component_details(package_id) {
	$.ajax({
		type: "POST",
    	url: base_url+"factsuite-admin/get-single-factsuite-website-service-package-component-details",
    	dataType: "json",
    	data : {
    		verify_admin_request : 1,
    		package_id : package_id
    	},
    	success: function(data) {
			if (data.status == 1) {
				console.log(JSON.stringify(data));
				$('#modal-edit-service-package-component-id').val(package_id);
				var component_selected_html = '',
					components_included_details = [],
					components_included_details_array = [];
				if(data.service_package_details.component_details.components_included_details != '' && data.service_package_details.component_details.components_included_details != null) {
					components_included_details = JSON.parse(data.service_package_details.component_details.components_included_details);
					for (var i = 0; i < components_included_details.length; i++) {
						components_included_details_array.push(components_included_details[i].component_id);
					}
				}
				
				var selected_package_component_list = data.service_package_details.selected_package_component_list;
				if (components_included_details_array.length == 0) {
					component_selected_html = '<option value="">Select Component</option>';
				}
				for (var i = 0; i < selected_package_component_list.length; i++) {
					var disabled = '',
						selected = '';
					if (components_included_details_array.length > 0) {
						if(i == 0) {
							selected = 'selected';
						}
						if (jQuery.inArray(selected_package_component_list[i].component_id, components_included_details_array) !== -1) {
							disabled = 'disabled';
						}
					}
					component_selected_html += '<option value="'+selected_package_component_list[i].component_id+'" '+disabled+' '+selected+'>'+selected_package_component_list[i].component_name+'</option>';
				}
				$('#component-selected').html(component_selected_html);

				$('#display-component-details').empty();
				if (components_included_details.length > 0) {
					for (var i = 0; i < components_included_details.length; i++) {
						var type_of_price = (components_included_details[i].type_of_price == 1) ? components_included_details[i].type_of_price : 0,
							client_price = 'checked',
							check = '',
							style = "style='display:none;'";
						if (type_of_price != 1) {
							client_price = '';
							check = 'checked';
							style = '';
						}

						var html = '<div class="row ul'+components_included_details[i].package_id+'">';
						html += '<div id="component-error-'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'"></div>';
						html += '<div class="col-md-4 mt-1">';
						html += '<div class="custom-control custom-radio custom-control-inline mrg">';
						html += '<input type="radio" '+check+' class="custom-control-input component_price_type"  onchange="set_form_value('+components_included_details[i].package_id+'_'+components_included_details[i].component_id+',0)" name="component_price_type'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'" value="0" id="customradio_'+components_included_details[i].component_id+'">';
						html += '<label class="custom-control-label" for="customradio_'+components_included_details[i].component_id+'">Form Base Price</label></div></div>';
						html += '<div class="col-md-4 mt-1">';
						html += '<div class="custom-control custom-radio custom-control-inline mrg">';
						html += '<input type="radio" '+client_price+' class="custom-control-input component_price_type" onchange="set_form_value('+components_included_details[i].package_id+'_'+components_included_details[i].component_id+',1)" name="component_price_type'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'" value="1" id="customradio_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'">';
						html += '<label class="custom-control-label" for="customradio_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'?>">Component Base Price</label></div></div>';
						html += '<div class="col-md-4 mt-1"></div>';
						html += '<div class="col-md-4 mt-1">';
						html += '<div class="custom-control custom-checkbox custom-control-inline mrg">';
						html += '<input type="checkbox" disabled checked class="custom-control-input component_names" data-package_id="'+components_included_details[i].package_id+'" name="customCheck" value="'+components_included_details[i].component_id+'" data-component_name="'+components_included_details[i].component_name+'" id="customCheck'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'">';
						html += '<label class="custom-control-label" for="customCheck'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'">'+components_included_details[i].component_name+'</label></div></div>';
						html += '<div class="col-md-4 mt-1"><label>Component Standard Price</label>';
						html += '<input type="hidden" class="form-control fld2 component_package_id"  value="'+components_included_details[i].package_id+'" id="component_package_ids'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'">';
						var component_standard_price = 0;
						if (components_included_details[i].component_standard_price != '' && components_included_details[i].component_standard_price != null) {
							component_standard_price = components_included_details[i].component_standard_price;
						}
						html += '<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+component_standard_price+'" id="component_standard_price'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'"></div>';
						html += '<div class="col-md-4 mt-1"><label>Client Standard Price</label>';
						var component_price = 0;
						if (components_included_details[i].component_price != '' && components_included_details[i].component_price != null) {
							component_price = components_included_details[i].component_price;
						}
						html += '<input type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control fld2 component_price" value="'+components_included_details[i].component_price+'" id="component_price'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'" onkeypress="return oninput_fun(event)" onkeyup="component_price('+i+')"></div>';
						if (components_included_details[i].component_id == 3) {
							var document_type = data.service_package_details.document_type;
							if (document_type.length > 0) {
								for (var j = 0; j < document_type.length; j++) {
									var form_data = components_included_details[i].form_data.filter(p => p.form_id == document_type[j].document_type_id);
									var checked = '';
									var form_value = 0;
									if (form_data.length != 0) {
										checked = 'checked';
										if (components_included_details[i].form_data[j].form_value != '' && components_included_details[i].form_data[j].form_value != null) {
											form_value = components_included_details[i].form_data[j].form_value;
										}
									}
									html += '<div class="col-md-2 mt-1"><div class="custom-control custom-checkbox custom-control-inline mrg">';
									html += '<input type="checkbox" '+checked+' class="custom-control-input input_'+components_included_details[i].package_id+'_form_'+components_included_details[i].component_id+'"  data-package_id="'+components_included_details[i].package_id+'" name="form'+document_type[j].document_type_id+'" value="'+document_type[j].document_type_id+'" id="customradiopackeducheckform_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+document_type[j].document_type_id+'">';
									html += '<label class="custom-control-label" for="customradiopackeducheckform_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+document_type[j].document_type_id+'">'+document_type[j].document_type_name+'</label><input type="hidden" class="form-control fld form" value="'+document_type[j].document_type_id+'" id="form_threshold'+document_type[j].document_type_id+'"></div></div>';
									html += '<div class="col-md-2 mt-1">';
									html += '<input type="number" '+style+' min="0" oninput="this.value = Math.abs(this.value)" onkeyup="get_form_input_value('+components_included_details[i].package_id+','+components_included_details[i].component_id+','+document_type[j].document_type_id+')" class="form-control fld2 text_form_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'" value="'+form_value+'" id="text_form_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+document_type[j].document_type_id+'"></div>';
								}
							}
						} else if (components_included_details[i].component_id == 4) {
							var drug_test_type = data.service_package_details.drug_test_type;
							if (drug_test_type.length > 0) {
								for (var j = 0; j < drug_test_type.length; j++) {
									var form_data = components_included_details[i].form_data.filter(p => p.form_id == drug_test_type[j].drug_test_type_id);
									var checked = '';
									var form_value = 0;

									if (form_data.length != 0) {
										checked = 'checked';
										if (components_included_details[i].form_data[j].form_value != '' && components_included_details[i].form_data[j].form_value != null) {
											form_value = components_included_details[i].form_data[j].form_value;
										}
									}
									html += '<div class="col-md-2 mt-1"><div class="custom-control custom-checkbox custom-control-inline mrg">';
									html += '<input type="checkbox" '+checked+' class="custom-control-input input_'+components_included_details[i].package_id+'_form_'+components_included_details[i].component_id+'"  data-package_id="'+components_included_details[i].package_id+'" name="form'+drug_test_type[j].drug_test_type_id+'" value="'+drug_test_type[j].drug_test_type_id+'" id="customradiopackeducheckform_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+drug_test_type[j].drug_test_type_id+'">';
									html += '<label class="custom-control-label" for="customradiopackeducheckform_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+drug_test_type[j].drug_test_type_id+'"> '+drug_test_type[j].drug_test_type_name+'</label><input type="hidden" class="form-control fld form" value="'+drug_test_type[j].drug_test_type_id+'" id="form_threshold'+drug_test_type[j].drug_test_type_id+'" ></div></div>';
									html += '<div class="col-md-2 mt-1">';
									html += '<input type="number" '+style+' min="0" oninput="this.value = Math.abs(this.value)" onkeyup="get_form_input_value('+components_included_details[i].package_id+','+components_included_details[i].component_id+','+drug_test_type[j].drug_test_type_id+')" class="form-control fld2 text_form_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'" value="'+form_value+'" id="text_form_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+drug_test_type[j].drug_test_type_id+'"></div>';
								}
							}
						} else if (components_included_details[i].component_id == 7) {
							var education_type = data.service_package_details.education_type;
							if (education_type.length > 0) {
								for (var j = 0; j < education_type.length; j++) {
									var form_data = components_included_details[i].form_data.filter(p => p.form_id == education_type[j].education_type_id);
									var checked = '';
									var form_value = 0;

									if (form_data.length != 0) {
										checked = 'checked';
										if (components_included_details[i].form_data[j].form_value != '' && components_included_details[i].form_data[j].form_value != null) {
											form_value = components_included_details[i].form_data[j].form_value;
										}
									}
									html += '<div class="col-md-2 mt-1"><div class="custom-control custom-checkbox custom-control-inline mrg">';
									html += '<input type="checkbox" '+checked+' class="custom-control-input input_'+components_included_details[i].package_id+'_form_'+components_included_details[i].component_id+'"  data-package_id="'+components_included_details[i].package_id+'" name="form'+education_type[j].education_type_id+'" value="'+education_type[j].education_type_id+'" id="customradiopackeducheckform_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+education_type[j].education_type_id+'">';
									html += '<label class="custom-control-label" for="customradiopackeducheckform_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+education_type[j].education_type_id+'"> '+education_type[j].education_type_name+'</label><input type="hidden" class="form-control fld form" value="'+education_type[j].education_type_id+'" id="form_threshold'+education_type[j].education_type_id+'" ></div></div>';
									html += '<div class="col-md-2 mt-1">';
									html += '<input type="number" '+style+' min="0" oninput="this.value = Math.abs(this.value)" onkeyup="get_form_input_value('+components_included_details[i].package_id+','+components_included_details[i].component_id+','+education_type[j].education_type_id+')" class="form-control fld2 text_form_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'" value="'+form_value+'" id="text_form_'+components_included_details[i].package_id+'_'+components_included_details[i].component_id+'_'+education_type[j].education_type_id+'"></div>';
								}
							}
						} else if (jQuery.inArray(components_included_details[i].component_id, [3,4,7]) == -1) {
							var selected_package_component_list = data.service_package_details.selected_package_component_list;
							var threshold = 0;
							for (var j = 0; j < selected_package_component_list.length; j++) {
								if (components_included_details[i].component_id == selected_package_component_list[j].component_id) {
									threshold = selected_package_component_list[j].form_threshold;
									break;
								}
							}
							for (var j = 1; j <= threshold; j++) {
								
							}
						}
						html += ''

						$('#display-component-details').prepend(html);
					}
				}

				$('#edit-package-component-details-btn').attr('onclick','update_package_component_details('+package_id+')');

				$('#edit-package-component-details-modal').modal('show');
			} else {
				check_admin_login();
			}
		}     	
	});	
}