var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mobile_number_length = 10;
var url_regex = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
// var url_regex = regex = ((http|https):\/\/)?(www.)[a-zA-Z0-9@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&\/\/=]*);
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var client_docs =[];
var alphabets_only = /^[A-Za-z ]+$/;

var vendor_name_length = 100,
	city_name_length = 100,
	vendor_zip_code_length = 6,
	vendor_monthly_quota_length = 5, 
	vendor_document_size = 1000000,
	max_vendor_document_select = 6,
	vendor_manager_name_length = 200, 
	vendor_spoc_name_length = 200,
	vendor_first_name_length = 100,
	vendor_last_name_length = 100,
	vendor_user_name_length = 70,
	min_vendor_user_name_length = 8,
	password_length = 8,
	vendor_skill_tat_length = 3;

remarks_all();
function remarks_all() {  
    var flag =0; 
    $.ajax({
        type: "POST",
        url: base_url+"approval_Mechanisms/get_all_remarks", 
        dataType: "json",
        data : {
            verify_csm_request : 1
        },
        success: function(data) {

            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].status == '1' && data[i].flag == flag) { 
                     html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
                }
            }
            $('#ticket_description').html(html);
        } 
    });
}


$("#ticket_description").on('change',function(){
    if ($(this).val()=='Others') {
        $("#additionals").show();
    }else{
       $("#additionals").hide();  
    }
})


	$("#save_location").on('click',function(){
		 $.ajax({
            type: "POST",
              url: base_url+"client/insert_location/",
              data:{location:$('#location').val()},
              dataType: 'json', 
              success: function(data) {
                if (data.status == '1') {  
                	toastr.success('New add location has been successfully.');
                	  $("#div-location").hide()
                	sessionStorage.clear();  
                }else{ 
                	$("#package-component-error").html("");
                	toastr.error('Something went wrong while add location. Please try again.'); 
                }  
              }
          });
	});

	$("#save_segment").on('click',function(){
		 $.ajax({
            type: "POST",
              url: base_url+"client/insert_segment/",
              data:{segment:$('#segment').val()},
              dataType: 'json', 
              success: function(data) {
                if (data.status == '1') {  
                	toastr.success('New add segment has been successfully.');
                	 $("#div-segment").hide()
                	sessionStorage.clear();  
                }else{ 
                	$("#package-component-error").html("");
                	toastr.error('Something went wrong while add segment. Please try again.'); 
                }  
              }
          });
	});

	$("#insuff-client-notification").on('click', function() {
		$('#insuff-client-notification-types-error-msg-div').html('');
		if ($('#insuff-client-notification').is(':checked')) {
		 	$('#insuff-client-notification-types-div').removeClass('d-none');
		} else {
		 	$('#insuff-client-notification-types-div').addClass('d-none');
		 	$('.insuff-client-notification-type').prop('checked',false);
		}
	});

	$('.insuff-client-notification-type').on('click', function() {
		check_checked_insuff_client_notification_types_selected();
	});

	function check_checked_insuff_client_notification_types_selected() {
		var components_checked = $('input[name="insuff-client-notification-type[]"]:checked').length;
		if (components_checked > 0) {
			$('#insuff-client-notification-types-error-msg-div').html('');
			return 1;
		} else {
			$('#insuff-client-notification-types-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least 1 notification type.</span>');
			return 0;
		}
	}

	$("#client-clarification-client-notification").on('click', function() {
		$('#client-clarification-client-notification-types-error-msg-div').html('');
		if ($('#client-clarification-client-notification').is(':checked')) {
		 	$('#client-clarification-client-notification-types-div').removeClass('d-none');
		} else {
		 	$('#client-clarification-client-notification-types-div').addClass('d-none');
		 	$('.client-clarification-client-notification-type').prop('checked',false);
		}
	});

	$('.client-clarification-client-notification-type').on('click', function() {
		check_checked_client_clarification_client_notification_types_selected();
	});

	function check_checked_client_clarification_client_notification_types_selected() {
		var components_checked = $('input[name="client-clarification-client-notification-type[]"]:checked').length;
		if (components_checked > 0) {
			$('#client-clarification-client-notification-types-error-msg-div').html('');
			return 1;
		} else {
			$('#client-clarification-client-notification-types-error-msg-div').html('<span class="text-danger error-msg-small">Please select at least 1 notification type.</span>');
			return 0;
		}
	}

	$('.client-iverify-or-pv-type').on('click', function() {
		check_selected_iverify_or_pv_type_selected();
	});

	function check_selected_iverify_or_pv_type_selected() {
		var components_checked = $('input[name="client-iverify-or-pv-type"]:checked').length;
		if (components_checked > 0) {
			$('#client-iverify-or-pv-type-error-msg-div').html('');
			return 1;
		} else {
			$('#client-iverify-or-pv-type-error-msg-div').html('<span class="text-danger error-msg-small">Please select a type.</span>');
			return 0;
		}
	}

	// sessionStorage.setItem("total_amount", total_amount);
	// sessionStorage.getItem("total_amount");

	$('#client-industry').on('change',function(){
		// alert($(this).val())
		if($(this).val() == '101'){
			$('#li-other-industry').removeClass('d-none')
		}else{
			$('#li-other-industry').addClass('d-none')		
		}
	})

	set_value_form_1();
	function set_value_form_1(){
	var client_name = $("#client-name").val();
	var client_address = $("#client-address").val();
	var client_city = $("#client-city").val();
	var client_state = $('#client-state').val();
	var client_industry = $("#client-industry").val();
	var other_industry = 'none';
	if(client_industry == '101'){
		other_industry = $('#other_industry').val();
	}
	
	var client_website = $("#client-website").val();
	var master_account = $("#master-account").val();
	var account_manager = $("#account-manager").val();
	var manager_email = $("#manager-email").val();
	var manager_contact = $("#manager-contact").val();
	var zip = $('#client-zip').val();
	var is_master = $("#is_master:checked").val(); 
	var country = $('#country').val();


	if (sessionStorage.getItem("client_name")) {
		

	$("#client-name").val(sessionStorage.getItem("client_name"));
	$("#client-address").val(sessionStorage.getItem("client_address"));
	$('#client-state').val(sessionStorage.getItem("client_state")).trigger('change');
	valid_state()
	$("#client-city").val(sessionStorage.getItem("client_city"));
	$("#client-industry").val(sessionStorage.getItem("client_industry"));
	$("#other-industry").val(sessionStorage.getItem("other_industry"));
	$("#client-website").val(sessionStorage.getItem("client_website"));
	$("#master-account").val(sessionStorage.getItem("master_account"));
	$("#account-manager").val(sessionStorage.getItem("account_manager"));
	$("#manager-email").val(sessionStorage.getItem("manager_email"));
	$("#manager-contact").val(sessionStorage.getItem("manager_contact"));
	$('#client-zip').val(sessionStorage.getItem("zip"));
	$("#is_master:checked").val(); 
	$('#country').val(sessionStorage.getItem("country"));
	var spoc_name = sessionStorage.getItem("spo_name").split(',');
	var spo_email = sessionStorage.getItem("spo_email").split(',');
	var spo_contact = sessionStorage.getItem("spo_contact").split(',');
			 var row = '';
	if (spoc_name.length > 0 ) {
		$("#spo-details-div-error").html('');
		for (var i = 0; i < spoc_name.length; i++) {
		row +='<ul id="'+i+'">';
		row +='<li>';
		row +='<label>Name</label>';
		row +='<input type="text" class="form-control fld spo_name" value="'+spoc_name[i]+'" onkeyup="valid_spoc_name('+i+')" id="spoc-name'+i+'">';
		row +='<div id="spoc-name-error'+i+'">&nbsp;</div>';
		row +='</li>';
		row +='<li>';
		row +='<label>Email</label>';
		row +='<input type="email" class="form-control fld spo_email"  value="'+spo_email[i]+'" onkeyup="valid_spoc_email('+i+')" id="spoc-email'+i+'">';
		row +='<div id="spoc-email-error'+i+'">&nbsp;</div>';
		row +='</li>';
		row +='<li>';
		row +='<label>Phone Number</label>';
		row +='<input type="number" class="form-control fld spo_contact"  value="'+spo_contact[i]+'" onkeyup="valid_spoc_contact('+i+')" id="spoc-contact'+i+'">';
		row +='<div id="spoc-contact-error'+i+'">&nbsp;</div>';
		row +='</li>';
		row +='<li>';
		if (i==0) {
			row +=' <button class="btn btn-success" id="add-new"><i class="fa fa-plus"></i></button>';
		}else{

		row +='<button onclick="remove_tr('+i+')" class="btn btn-danger"><i class="fa fa-remove"></i></button>';
		}
		row +='<div>&nbsp;</div>';
		row +='</li>';
		row +='</ul>';

		}
	}
  		$("#spo-details-div").html(row); 


  		var comm = [];

  		if (sessionStorage.getItem("communications")) {
  			comm = sessionStorage.getItem("communications").split(',');
  		}
  		$(".communications").each(function(){
  			if ($.inArray($(this).val(),comm) !==-1) {  
  				$(this).attr('checked',true);
  			}
  		});

  		var fileName = [];
  		if (sessionStorage.getItem("communications")) {
  			fileName = sessionStorage.getItem("client_docs").split(',');
  		}
  		if (fileName.length > 0) {
  			var html ='';
  			for (var i = 0; i < fileName.length; i++) {
  				 html = '<div  class="image-selected-div mr-2 mb-2" id="file_client_documents_'+i+'"><span>'+fileName[i]+' <a onclick="exist_view_image(\''+fileName[i]+'\',\'client-docs\')" ><i class="fa fa-eye"></i></a></span></div>';
  			}
  			$("#client-upoad-docs-error-msg-div").html(html);
  		}


  		if (sessionStorage.getItem("is_master") == 0) {
  			$("#is_master").attr('checked',true);
  		}

  		if (sessionStorage.getItem("master_account") !=null && sessionStorage.getItem("master_account") !='undefined' && sessionStorage.getItem("master_account") !='0'&& sessionStorage.getItem("master_account") !='') {
  			$("#master-account").val(sessionStorage.getItem("master_account")); 
  		}else{
  			$("#master-account").prop('disabled',true);
  		}


	}
 

 //end of the session 
	}
 

	set_value_form_2();
	function set_value_form_2(){


	/*	sessionStorage.setItem("alacarte", JSON.stringify(alacarte));
	sessionStorage.setItem("alacarte_component",alacarte_component)
	sessionStorage.getItem("package_id")
	sessionStorage.setItem("package_name",package_name)*/
	if (sessionStorage.getItem("package_id")) {
		var package_id = sessionStorage.getItem("package_id").split(',');
		var package_name = sessionStorage.getItem("package_name").split(',');
		var html = '';
		for (var i = 0; i < package_id.length; i++) {
				html +='<div class="col-md-2 m-2 ml-4" id="package_div_'+package_id[i]+'">';
		html +='<div class="image-selected-div p-2"><a href="#" onclick="get_package_component_data('+package_id[i]+')">';
		html +='<input type="hidden" class="main_package_id" data-package_name="'+package_name[i]+'" id="main_package_id'+package_id[i]+'" value="'+package_id[i]+'" >'
		html +='<span class="font-weight-normal" id="package_name_'+package_id[i]+'">'+package_name[i]+'</span>'
		html +='</a>';
		html +='<div class="float-right"><a onclick="remove_package('+package_id[i]+')"><i class="fa fa-remove"></i></a></div>'
		html +='</div>';
		html +='</div>';
		}
		$("#get-packages").append(html);

		var alacarte = JSON.parse(sessionStorage.getItem("alacarte"));

		if (alacarte.length > 0) {
			var html = '';
			for (var i = 0; i < alacarte.length; i++) {
				html +='<div class="col-md-3 m-2 ml-4" id="alacarte_div_'+alacarte[i]['component_id']+'">';
				html +='<div class="image-selected-div p-1">';
				html +='<input type="hidden" class="alacarte_component_id" data-component_name="'+alacarte[i]['component_name']+'" id="alacarte_component_id'+alacarte[i]['component_id']+'" value="'+alacarte[i]['component_id']+'" >'
				html +='<span>'+alacarte[i]['component_name']+'</span>'
				html +='<div class="float-right"><a onclick="remove_alacarte('+alacarte[i]['component_id']+')"><i class="fa fa-remove"></i></a></div>'
				html +='</div>';
				html +='</div>';
			}
			$("#get-alacarte").html(html);
		}

	}



		 

	}


 set_form_value_3();
	function set_form_value_3(){
          	if (sessionStorage.getItem('package_components')) { 

		var package_components = JSON.parse(sessionStorage.getItem('package_components'))

	for (var n = 0; n < package_components.length; n++) {


			 $.ajax({
          type: "POST",
          url: base_url+"package/get_single_component/",
          data:{component_id:package_components[n].component_id},
          dataType: 'json', 
          async:false,
          success: function(data) { 
          	// if (data.pack.length > 0) {
          		// $('#tmp-packages').val(packages);
          	var html='';
          		var edu = '';
          		var drug = '';
          		var doc = '';
          		var form_ids = [];
          		for (var i = 0; i < package_components[n].form_data.length; i++) {
          			// package_components[n].form_data.length[i]
          			form_ids.push(package_components[n].form_data[i].form_id);
          		}


          		if (data.edu.length > 0) { 	
	          		for (var i = 0; i < data.edu.length; i++) { 
	          			var disable = '';
	          			if (i == 0) {
	          				disable = '';
	          			}
	          			var select = '';
	          			var form_value = '';
	          			if ($.inArray(data.edu[i]['education_type_id'],form_ids) !==-1) {
	          				var index = form_ids.indexOf(data.edu[i]['education_type_id']);
	          				select = 'checked';
	          				form_value = package_components[n].form_data[index].form_value;

	          			}
						edu +='<div class="col-md-2 mt-1">';
	          			// edu +='<span class="education_type_name" id="education_type_name'+i+'">'+data.edu[i]['education_type_name']+'</span><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
	          			edu +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						edu +='<input type="checkbox" '+select+' class="custom-control-input input_'+package_components[n].package_id+'_form_'+data.pack['component_id']+'" data-package_id="'+package_components[n].package_id+'" name="education_type_name'+data.edu[i]['education_type_id']+'" value="'+data.edu[i]['education_type_id']+'" id="customradiopackeducheckform_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'">';
						edu +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'">'+data.edu[i]['education_type_name']+'</label><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
						edu +='</div>';
	          			edu +='</div>';
	          			edu +='<div class="col-md-2 mt-1">';
						edu +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+' value="'+form_value+'"  onkeyup="get_form_input_value('+package_components[n].package_id+','+data.pack['component_id']+','+data.edu[i]['education_type_id']+')" class="form-control fld2 text_form_'+package_components[n].package_id+'_'+data.pack['component_id']+'" id="text_form_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'" >';
						edu +='</div>'; 
	          		}
          		}
          		
          		if (data.drug.length > 0) { 	
	          		for (var i = 0; i < data.drug.length; i++) { 

	          			var disable = '';
	          			if (i == 0) {
	          				disable = '';
	          			}
	          			var select = '';
	          			var form_value = '';
	          			if ($.inArray(data.drug[i]['drug_test_type_id'],form_ids) !==-1) {
	          				var index = form_ids.indexOf(data.edu[i]['education_type_id']);
	          				select = 'checked';
	          				form_value = package_components[n].form_data[index].form_value;

	          			}
						drug +='<div class="col-md-2 mt-1">';
	          			// drug +='<span class="drug_test_type_name" id="drug_test_type_name'+i+'">'+data.drug[i]['drug_test_type_name']+'</span><input type="hidden" class="form-control fld document_type_id" value="'+data.drug[i]['document_type_id']+'" id="document_type_id'+i+'" >';
	          			drug +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						drug +='<input type="checkbox" '+select+' class="custom-control-input input_'+package_components[n].package_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+package_components[n].package_id+'" name="drug_test_type_name'+data.drug[i]['drug_test_type_id']+'" value="'+data.drug[i]['drug_test_type_id']+'" id="customradiopackeducheckform_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'">';
						drug +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'">'+data.drug[i]['drug_test_type_name']+'</label><input type="hidden" class="form-control fld drug_test_type_id" value="'+data.drug[i]['drug_test_type_id']+'" id="drug_test_type_id'+i+'" >';
						drug +='</div>';
	          			drug +='</div>';
	          			drug +='<div class="col-md-2 mt-1">';
						drug +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+' value="'+form_value+'" onkeyup="get_form_input_value('+package_components[n].package_id+','+data.pack['component_id']+','+data.drug[i]['drug_test_type_id']+')" class="form-control fld2 text_form_'+package_components[n].package_id+'_'+data.pack['component_id']+'" id="text_form_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'" >';
						drug +='</div>'; 
	          		}
          		}

          		if (data.doc.length > 0) { 	
	          		for (var i = 0; i < data.doc.length; i++) {

	          			var disable = '';
	          			if (i == 0) {
	          				disable = '';
	          			}

	          			var select = '';
	          			var form_value = '';
	          			if ($.inArray(data.doc[i]['document_type_id'],form_ids) !==-1) {
	          				var index = form_ids.indexOf(data.edu[i]['education_type_id']);
	          				select = 'checked';
	          				form_value = package_components[n].form_data[index].form_value;

	          			}
	          			// data.doc[i]
	          			doc +='<div class="col-md-2 mt-1">';
	          			// doc +='<span class="document_type_name" id="document_type_name'+i+'">'+data.doc[i]['document_type_name']+'</span><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
	          			doc +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						doc +='<input type="checkbox" '+select+' class="custom-control-input input_'+package_components[n].package_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+package_components[n].package_id+'" name="document_type_name'+data.doc[i]['document_type_id']+'" value="'+data.doc[i]['document_type_id']+'" id="customradiopackeducheckform_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'">';
						doc +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'">'+data.doc[i]['document_type_name']+'</label><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
						doc +='</div>';
	          			doc +='</div>';
	          			doc +='<div class="col-md-2 mt-1">';
						doc +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+' value="'+form_value+'" onkeyup="get_form_input_value('+package_components[n].package_id+','+data.pack['component_id']+','+data.doc[i]['document_type_id']+')" class="form-control fld2 text_form_'+package_components[n].package_id+'_'+data.pack['component_id']+'" id="text_form_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'" >';
						doc +='</div>'; 
	          		}
          		}
          		// for (var i = 0; i < data.pack.length; i++) { 
					html +='<div class="row ul'+package_components[n].package_id+'">';

					html +='<div class="col-md-12" id="component-error-'+package_components[n].package_id+'_'+data.pack['component_id']+'">&nbsp;</div><br/>';

					html +='<div class="col-md-4 mt-1">';
					
					html +='<div class="custom-control custom-radio custom-control-inline mrg">';
					html +='<input type="radio" class="custom-control-input component_price_type" checked onchange="set_form_value(\''+package_components[n].package_id+'_'+data.pack['component_id']+'\',0)" name="component_price_type'+package_components[n].package_id+'_'+data.pack['component_id']+'" value="0" id="customradio'+package_components[n].package_id+'_'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customradio'+package_components[n].package_id+'_'+data.pack['component_id']+'">Form Base Price</label>';
					html +='</div>';

          			html +='</div>';
          			html +='<div class="col-md-4 mt-1">'; 

					html +='<div class="custom-control custom-radio custom-control-inline mrg">';
					html +='<input type="radio" class="custom-control-input component_price_type" onchange="set_form_value(\''+package_components[n].package_id+'_'+data.pack['component_id']+'\',1)" name="component_price_type'+package_components[n].package_id+'_'+data.pack['component_id']+'" value="1" id="customradio_'+package_components[n].package_id+'_'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customradio_'+package_components[n].package_id+'_'+data.pack['component_id']+'">Component Base Price</label>';
					html +='</div>';

          			html +='</div>';
          			html +='<div class="col-md-4 mt-1">';
					html +='';
					html +='</div>';


					html +='<div class="col-md-4 mt-1">';
					html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					html +='<input type="checkbox" disabled checked class="custom-control-input component_names" data-package_id="'+package_components[n].package_id+'" name="customCheck" value="'+data.pack['component_id']+'" data-component_name="'+data.pack['component_name']+'" id="customCheck'+package_components[n].package_id+'_'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customCheck'+package_components[n].package_id+'_'+data.pack['component_id']+'">'+data.pack['fs_crm_component_name']+'</label>';
					html +='</div>';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<label>Component Standard Price</label>';
					html +='<input type="hidden" class="form-control fld2 component_package_id"  value="'+package_components[n].package_id+'" id="component_package_ids'+package_components[n].package_id+'_'+data.pack['component_id']+'">';
					html +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data.pack.component_standard_price+'" id="component_standard_price'+package_components[n].package_id+'_'+data.pack['component_id']+'">';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<label>Client Standard Price</label>'
					html +='<input type="text" class="form-control fld2 component_price" value="'+package_components[n].component_price+'" id="component_price'+package_components[n].package_id+'_'+data.pack['component_id']+'" oninput="oninput_float(\''+package_components[n].package_id+'_'+data.pack['component_id']+'\')" onkeypress="return oninput_fun(event)" onkeyup="component_price(\''+package_components[n].package_id+'_'+data.pack['component_id']+'\')">';
					html +='</div>';
					if (data.pack['component_id'] == 3) {
					html +=doc;
					}else if(data.pack['component_id'] == 4){
					html +=drug;
					}else if(data.pack['component_id'] == 7){
					html +=edu;
					}else if (!jQuery.inArray(data.pack['component_id'], [3,4,7]) !== -1) {
					if (data.pack['form_threshold'] > 0) {
						var m=0;
						for (var k = 1; k <= data.pack['form_threshold']; k++) {
							var disable = 'disabled';
	          			if (package_components[n].form_data.length+1 == k) {
	          				disable = '';
	          			}	
	          			var select = '';
	          			var form_value = '';
	          			if (package_components[n].form_data.length >= k) {
	          				if (package_components[n].form_data[m].form_id == k) {
	          					select = 'checked';
	          					disable = '';
	          					form_value = package_components[n].form_data[m].form_value;
	          				}
	          			} 
	          			m++;
						html +='<div class="col-md-2 mt-1">'; 
	          			html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						html +='<input type="checkbox" '+select+' '+disable+' onchange="get_form_input_value('+package_components[n].package_id+','+data.pack['component_id']+','+k+')" class="custom-control-input input_'+package_components[n].package_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+package_components[n].package_id+'" name="form'+k+'" value="'+k+'" id="customradiopackeducheckform_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+k+'">';
						html +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+k+'">Form '+k+'</label><input type="hidden" class="form-control fld form" value="'+k+'" id="form_threshold'+k+'" >';
						html +='</div>';
	          			html +='</div>';
	          			html +='<div class="col-md-2 mt-1">';
						html +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+' value="'+form_value+'" onkeyup="get_form_input_value('+package_components[n].package_id+','+data.pack['component_id']+','+k+')" class="form-control fld2 text_form_'+package_components[n].package_id+'_'+data.pack['component_id']+'" id="text_form_'+package_components[n].package_id+'_'+data.pack['component_id']+'_'+k+'" >';
						html +='</div>'; 

							}
						}
					}
					html +='</div>';
					html +='<hr>';
					j++;
          		// }package_components.push({type_of_price:checkbox,component_id:component_id,component_name:component_name,package_id:package_id,component_standard_price:component_standard_price,component_price:component_price,form_data:form_data})
          	// }
          	$("#display-component-details").append(html);
          }
     	});
		}	


          }
	}


	function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img class='w-100' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
	}



function check_reccovery_password_match() {
	var password = $('#team-password').val();
	var confirm_password = $("#confirm-team-password").val();
	if (password != '' && confirm_password !='') {
		if(password == confirm_password){
            $("#new-confirm-password-error-msg-div").html("<span class='text-success error-msg'>Passwords are same</span>");
        } else {
            $("#new-confirm-password-error-msg-div").html("<span class='text-danger error-msg'>Passwords didnt matched.</span>");
        }
	} else {
		if (password == '') {
			$("#new-password-error-msg-div").html('<span class="text-danger error-msg">Please enter your password.</span>');
		} else {
			$("#new-password-error-msg-div").html('&nbsp;');
		}

		if (confirm_password == '') {
			$('#new-confirm-password-error-msg-div').html('<span class="text-danger error-msg">Please confirm your password.</span>');
		} else {
			$('#new-confirm-password-error-msg-div').html('&nbsp;');
		}
	}
}


 function oninput_float(id){
 	// var regex = /(?!^-)[^0-9.]/g;
    var component_price = $("#component_price"+id).val();
  // if (regex.test(component_price)){
      var component_prices = component_price.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1'); 
	$("#component_price"+id).val(component_prices); 
  // }
}


$(".communications:checked").each(function(){
	if ($(this).val() !=null && $(this).val() !='') {
		$("#communication-error").html("");
	}
})

function oninput_fun(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;
       	return ((k > 64 && k < 91) || k == 8 ||k == 46|| k == 32 || (k >= 48 && k <= 57));
}
 
$("#client-name").on('keyup blur',function() {
	valid_client_name();
});
$("#client-address").on('keyup blur',function() {
	valid_client_address();
});
$("#client-city").on('keyup blur change',function() {
	valid_client_city();
});

$('#client-state').on('change',function(){ 
	valid_state();
});

$("#client-industry").on('keyup blur',function() {
	valid_client_industry();
});

$("#client-website").on('keyup blur',function() {
	valid_client_website();
});

$("#master-account").on('change',function() {
	valid_client_master_account();
});

$("#account-manager").on('change',function(){
	valid_account_manager();
});

$("#manager-email").on('keyup blur',function() {
	valid_manager_email();
});

$("#manager-contact").on('keyup blur',function(){
	valid_manager_contact();
})

$('#user-name').on('keyup blur',function() {
	check_user_name();
});

$('#user-contact').on('keyup blur', function () {
	check_contact();
});

$('#first-name').on('keyup blur',function(){
	valid_first_name();
});

$('#last-name').on('keyup blur',function(){
	valid_last_name();
});


$('#packages').on('change',function(){ 
	valid_packages();
});


$('#alacarte').on('change',function(){ 
	valid_alacarte();
});


$("#user-password").on('keyup blur',function(){
	check_reccovery_password_match();
});
$("#confirm-team-password").on('keyup blur',function(){
	check_reccovery_password_match();
});
$("#client-zip").on('keyup blur',function(){
	valid_client_zip();
});

$("#client-documents").on("change", handleFileSelect_client_documents);


function handleFileSelect_client_documents(e) {
	// alert("hello")
	client_docs =[];
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var i = 1; 
    if (files.length <= max_client_document_select) {
        // $("#selected-client-docs-li").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name  
	           /* var html = '<div class="col-md-4 mt-1 mt-3" id="file_client_documents_'+i+'">'+
	                    '<div class="image-selected-div">'+
	                        '<ul>'+
	                            '<li>'+fileName+'</li>'+
	                            '<li>'+
	                                '<a id="file_client_documents'+i+'" onclick="removeFile_client_documents('+i+')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
	                            '</li>'+
	                        '</ul>'+
	                    '</div>'+
	                '</div>'; */
	                var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div  class="image-selected-div mr-2 mb-2" id="file_client_documents_'+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+i+'" onclick="removeFile_client_documents('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'client_docs\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                // candidate_aadhar.push(files[i]);
	                // $(".file-name1").append(html);
	        	} 
	                $("#selected-vendor-docs-li").append(html);
	                client_docs.push(files[i]);
	        }
	    } else {
	    	$("#client-upoad-docs-error-msg-div").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents').val('');
	    }
    } else {
        $("#selected-client-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}


function view_image(id,text){ 
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");   
	 	 if (typeof client_docs[id] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(client_docs[id]); 
	 }
	    
}
 

 function removeFile_client_documents(id) {
    var file = $('#file_client_documents'+id).data("file");
    for(var i = 0; i < client_docs.length; i++) {
        if(client_docs[i].name === file) {
            client_docs.splice(i,1); 
        }
    }
    $('#file_client_documents_'+id).remove();
    $("#client-documents").val('');
}


$("#clear-form").on('click',function(){
	// document.getElementByClass("form-control").value = '';
	$(".form-control").val('')
	$(".form-control").removeClass("is-valid");
})


function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(client_docs[id]);
}
 

function valid_spoc_name(id=''){
 
var spoc_name = $("#spoc-name"+id).val();
	if (spoc_name != '') {
		if (!alphabets_only.test(spoc_name)) {
			$("#spoc-name-error"+id).html('<span class="text-danger error-msg-small">SPOC name should be only alphabets.</span>');
			$("#spoc-name"+id).val(spoc_name.slice(0,-1));
			input_is_invalid("#spoc-name"+id);
		} else if (spoc_name.length > vendor_name_length) {
			$("#spoc-name-error"+id).html('<span class="text-danger error-msg-small">SPOC name should be of max '+vendor_name_length+' characters.</span>');
			$("#spoc-name"+id).val(spoc_name.slice(0,vendor_name_length));
			input_is_invalid("#spoc-name"+id);
		} else {
			$("#spoc-name-error"+id).html('&nbsp;') 
			input_is_valid("#spoc-name"+id);
		}
	} else {
		$("#spoc-name-error"+id).html('<span class="text-danger error-msg-small">Please enter your name.</span>');
		input_is_invalid("#spoc-name"+id);
	}
}


function valid_spoc_email(id=''){
	var spoc_email = $("#spoc-email"+id).val();

	if (spoc_email != '') {
	if(!regex.test(spoc_email)) {
			$('#spoc-email-error'+id).html("<span class='text-danger error-msg-small'>Please enter a valid email.</span>");
	    	input_is_invalid('#spoc-email'+id);
	    } else { 
		$.ajax({
	          type: "POST",
	          url: base_url+"client/valid_mail/",
	          data:{email:spoc_email},
	          dataType: 'json', 
	          success: function(data) {
	          	if (data.status =='1') {
	          		input_is_valid('#spoc-email'+id);
			        $('#spoc-email-error'+id).html("&nbsp;");
			    }else{
			    	input_is_invalid('#spoc-email'+id);
			    	// $("#spoc-email"+id).val('');
					$('#spoc-email-error'+id).html('<span class="text-danger error-msg-small">Entere email id already exists.</span>');
			    }
	          }
     	 });
	    }
	} else {
		input_is_invalid('#spoc-email'+id);
		$('#spoc-email-error'+id).html('<span class="text-danger error-msg-small">Please enter email id.</span>');
	}
}

function valid_spoc_contact(id=''){
	var spoc_contact = $("#spoc-contact"+id).val();
  	if (spoc_contact != '') {
    	if(spoc_contact.length > mobile_number_length) {
      		$('#spoc-contact-error'+id).html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
      		$('#spoc-contact'+id).val(spoc_contact.slice(0,mobile_number_length));
    	} else if (isNaN(spoc_contact)) {
      		$('#spoc-contact-error'+id).html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
      		$('#spoc-contact'+id).val(spoc_contact.slice(0,-1));
    	} else {
      		$('#spoc-contact-error'+id).html('&nbsp;');
      		input_is_valid('#spoc-contact'+id);
    	}
  	} else {
  		input_is_invalid('#spoc-contact'+id);
    	$('#spoc-contact-error'+id).html('<span class="text-danger error-msg-small">Please enter a valid phone number</span>');
  	}
}

 

function valid_client_zip() {
	var client_zip = $('#client-zip').val();
	if (client_zip != '') {
		if (isNaN(client_zip)) {
			$('#client-zip-error').html('<span class="text-danger error-msg-small">Zip code should be only numbers.</span>');
			$('#client-zip').val(client_zip.slice(0,-1));
			input_is_invalid('#client-zip');
		} else if (client_zip.length != client_zip_lenght) {
			$('#client-zip-error').html('<span class="text-danger error-msg-small">Zip code should be of '+client_zip_lenght+' digits.</span>');
			$('#client-zip').val(client_zip.slice(0,client_zip_lenght));
			input_is_invalid('#client-zip');
		} else {
			$('#client-zip-error').html('&nbsp;');
			input_is_valid('#client-zip');
		}
	} else {
		input_is_invalid('#client-zip');
		$('#client-zip-error').html('<span class="text-danger error-msg-small">Please enter the zip code</sapn>');
	}
}

function check_reccovery_password_match() {
	var password = $('#user-password').val();
	var confirm_password = $("#user-confirm-password").val();
	if (password != '' && confirm_password !='') {
		if(password == confirm_password){
			input_is_valid('#user-confirm-password');
            $("#user-confirm-password-error").html("<span class='text-success error-msg-small'>Passwords are same</span>");
        } else {
        	input_is_invalid('#user-confirm-password');
            $("#user-confirm-password-error").html("<span class='text-danger error-msg-small'>Passwords didn\'t matched.</span>");
        }
	} else {
		if (password == '') {
			input_is_invalid('#user-password');
			$("#user-password-error").html('<span class="text-danger error-msg-small">Please enter your password.</span>');
		} else {
			input_is_valid('#user-password');
			$("#user-password-error").html('&nbsp;');
		}

		if (confirm_password == '') {
			input_is_invalid('#user-confirm-password');
			$('#user-confirm-password-error').html('<span class="text-danger error-msg-small">Please confirm your password.</span>');
		} else {
			input_is_valid('#user-confirm-password');
			$('#user-confirm-password-error').html('&nbsp;');
		}
	}
}


function valid_client_name(){
 

	var client_name = $('#client-name').val();
	if (client_name != '') {
		 
			$('#client-name-error').html('&nbsp;');
			 
			input_is_valid('#client-name');
		 
	} else {
		$('#client-name-error').html('<span class="text-danger error-msg-small">Please add a client name.</span>');
		input_is_invalid('#client-name');
	}
}


function valid_client_address(){
	var address = $("#client-address").val();
	if (address != '') {
	     
	        $('#client-address-error').html("&nbsp;");
	        input_is_valid('#client-address');
	   
	} else {
		input_is_invalid('#client-address');
		$('#client-address-error').html('<span class="text-danger error-msg-small">Please enter client address.</span>');
	}	
}

function valid_client_city(){
 
	var city = $('#client-city').val();
	if (city != '') {
		if (!alphabets_only.test(city)) {
			$('#client-city-error').html('<span class="text-danger error-msg-small">client City should be only alphabets.</span>');
			$('#client-city').val(city.slice(0,-1));
			input_is_invalid('#client-city');
		} else if (city.length > vendor_name_length) {
			$('#client-city-error').html('<span class="text-danger error-msg-small">client City should be of max '+vendor_name_length+' characters.</span>');
			$('#client-city').val(city.slice(0,vendor_name_length));
			input_is_invalid('#client-city');
		} else {
			$('#client-city-error').html('&nbsp;');
			input_is_valid('#client-city');
		}
	} else {
		$('#client-city-error').html('<span class="text-danger error-msg-small">Please add a client City.</span>');
		input_is_invalid('#client-city');
	}	
}

function valid_state(request_from) {
	$("#client-city").html("<option selected value=''>Select City</option>");
	var state = $("#client-state").val();
	if (state != '') {
		var c_id = $("#client-state").children('option:selected').data('id');
		$.ajax({
        type: "POST",
          url: base_url+"client/get_selected_cities/"+c_id, 
          dataType: 'json', 
          success: function(data) {
          	var html = "<option selected value=''>Select City</option>";
			if (data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
				}
			}
			$("#client-city").html(html);
          }
        });
		$("#country-error").html("&nbsp;");
     
        $('#client-state-error').html("&nbsp;");
        input_is_valid('#client-state');
	   
	} else {
		if (request_from != 'changed_country') {
			input_is_invalid('#client-state');
			$('#client-state-error').html('<span class="text-danger error-msg-small">Please enter client state.</span>');
		}
	}	
}

function valid_client_industry(){
	var industry = $("#client-industry").val();
	if (industry != '') {
	     
	        $('#client-industry-error').html("&nbsp;");
	        input_is_valid('#client-industry');
	   
	} else {
		input_is_invalid('#client-industry');
		$('#client-industry-error').html('<span class="text-danger error-msg-small">Please enter client industry.</span>');
	}	
}

 
function valid_client_website() {
	var client_website = $('#client-website').val();
	if (client_website != '') {
		if (!url_regex.test(client_website)) {
			$('#client-website-error').html('<span class="text-danger error-msg-small">Please enter the correct URL.</span>');
			input_is_invalid('#client-website');
		} else {
			$('#client-website-error').html('&nbsp;');
			input_is_valid('#client-website');
		}
	} else {
		input_is_invalid('#client-website');
		$('#client-website-error').html('<span class="text-danger error-msg-small">Please enter the website URL.</span>');
	}
}

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}

function valid_client_master_account(){
	var master = $("#master-account").val();
	if (master != '') {
	     
	        $('#master-account-error').html("&nbsp;");
	        input_is_valid('#master-account');
	   
	} else {
		input_is_invalid('#master-account');
		$('#master-account-error').html('<span class="text-danger error-msg-small">Please select master account.</span>');
	}	
}

function valid_account_manager(){
	var manager = $("#account-manager").val();
	if (manager != '') {
	     
	        $('#account-manager-error').html("&nbsp;");
	        input_is_valid('#account-manager');

	        $.ajax({
	          type: "POST",
	          url: base_url+"client/get_single_manager_details/"+manager,  
	          dataType: 'json', 
	          success: function(data) {
	          	if (data !='') {
	          		$("#manager-email").val(data.team.team_employee_email);
	          		$('#manager-contact').val(data.team.contact_no);
			    }
	          }
     	 });
	   
	} else {
		input_is_invalid('#account-manager');
		$('#account-manager-error').html('<span class="text-danger error-msg-small">Please select Factsuite manager.</span>');
	}	
}

function valid_manager_email(){
	var user_email = $("#manager-email").val();
	if (user_email != '') {
	    if(!regex.test(user_email)) {
			$('#manager-email-error').html("<span class='text-danger error-msg-small'>Please enter a valid email.</span>");
	    	input_is_invalid('#manager-email');
	    } else { 
	      /*  $.ajax({
	          type: "POST",
	          url: base_url+"client/manager_valid_mail/",
	          data:{email:user_email},
	          dataType: 'json', 
	          success: function(data) {
	          	if (data.status =='1') {*/
	          		input_is_valid('#manager-email');
			      $('#manager-email-error').html("&nbsp;");
			     /* }else{
			    	input_is_invalid('#manager-email');
			    	// $("#spoc-email"+id).val('');
					$('#manager-email-error').html('<span class="text-danger error-msg">already available this mail.</span>');
			    }
	          }
     	 });*/
	    }
	} else {
		input_is_invalid('#manager-email');
		$('#manager-email-error').html('<span class="text-danger error-msg-small">Please enter email id.</span>');
	}
}

function valid_manager_contact(){
  	var user_contact = $('#manager-contact').val();
  	if (user_contact != '') {
    	if(user_contact.length > mobile_number_length) {
      		$('#manager-contact-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
      		$('#manager-contact').val(user_contact.slice(0,mobile_number_length));
    	} else if (isNaN(user_contact)) {
      		$('#manager-contact-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
      		$('#manager-contact').val(user_contact.slice(0,-1));
    	} else {
      		$('#manager-contact-error').html('&nbsp;');
      		input_is_valid('#manager-contact');
    	}
  	} else {
  		input_is_invalid('#manager-contact');
    	$('#manager-contact-error').html('<span class="text-danger error-msg-small">Please enter a valid phone number</span>');
  	}
}

function check_user_name(){
	var user_name = $("#user-name").val();
	if (user_name != '') {
	    if(user_name > 4) {
	    	input_is_invalid('#user-name');
			$('#user-name-error').html("<span class='text-danger error-msg-small'>please enter min 4 digit user name.</span>");
	    } else {
	        $('#user-name-error').html("&nbsp;");
	        input_is_valid('#user-name');
	    }
	} else {
		input_is_invalid('#user-name');
		$('#user-name-error').html('<span class="text-danger error-msg-small">Please enter user name.</span>');
	}	
}

function check_contact(){
  	var user_contact = $('#user-contact').val();
  	if (user_contact != '') {
    	if(user_contact.length > mobile_number_length) {
      		$('#user-contact-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
      		$('#user-contact').val(user_contact.slice(0,mobile_number_length));
    	} else if (isNaN(user_contact)) {
      		$('#user-contact-error').html('<span class="text-danger error-msg-small">Mobile number should be of 10 characters</span>');
      		$('#user-contact').val(user_contact.slice(0,-1));
    	} else {
      		$('#user-contact-error').html('&nbsp;');
      		input_is_valid('#user-contact');
    	}
  	} else {
  		input_is_invalid('#user-contact');
    	$('#user-contact-error').html('<span class="text-danger error-msg-small">Please enter a valid phone number</span>');
  	}
}

function valid_first_name(){
	 
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
		$('#first-name-error').html('<span class="text-danger error-msg-small">Please add a First Name.</span>');
		input_is_invalid('#first-name');
	}
}


function valid_last_name(){
	 
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
		$('#last-name-error').html('<span class="text-danger error-msg-small">Please add a Last Name.</span>');
		input_is_invalid('#last-name');
	}
}

var j = 0;

function valid_packages(){
	var packages = $('#packages').val();
	// alert(packages)
	var tmppackages = $('#tmp-packages').val();
	var tmp = [];
	if (tmppackages !='') {
		// alert(tmppackages)
		tmp = tmppackages.split(',');
	}
	var flg = 0;
	var pkg_id = 0;
	for (var i = 0; i < packages.length; i++) { 
		if(jQuery.inArray(packages[i], tmp) === -1) { 
			flg = 1;
			pkg_id = packages[i];
		}
		
	} 
 
	if (flg == 1) { 
		

		if (packages != '') {
		$('#packages-error').html('&nbsp;');
		input_is_valid('#packages'); 
		$.ajax({
          type: "POST",
          url: base_url+"package/get_package_component/",
          data:{package_id:pkg_id},
          dataType: 'json', 
          success: function(data) {
          	var html='';
          	if (data.pack.length > 0) {
          		$('#tmp-packages').val(packages);
          		var edu = '';
          		var drug = '';
          		var doc = '';
          		if (data.edu.length > 0) { 	
	          		for (var i = 0; i < data.edu.length; i++) { 
						edu +='<div class="col-md-3 mt-1">';
	          			// edu +='<span class="education_type_name" id="education_type_name'+i+'">'+data.edu[i]['education_type_name']+'</span><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
	          			edu +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						edu +='<input type="checkbox" class="custom-control-input education_type_name" name="education_type_name'+data.edu[i]['education_type_id']+'" value="'+data.edu[i]['education_type_id']+'" id="customradiopackeducheck'+data.edu[i]['education_type_id']+'">';
						edu +='<label class="custom-control-label" for="customradiopackeducheck'+data.edu[i]['education_type_id']+'">'+data.edu[i]['education_type_name']+'</label><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
						edu +='</div>';
	          			edu +='</div>';
	          			edu +='<div class="col-md-3 mt-1">';
						edu +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" class="form-control fld education_price" id="education_price'+i+'" >';
						edu +='</div>'; 
	          		}
          		}
          		
          		if (data.drug.length > 0) { 	
	          		for (var i = 0; i < data.drug.length; i++) { 
						drug +='<div class="col-md-3 mt-1">';
	          			// drug +='<span class="drug_test_type_name" id="drug_test_type_name'+i+'">'+data.drug[i]['drug_test_type_name']+'</span><input type="hidden" class="form-control fld document_type_id" value="'+data.drug[i]['document_type_id']+'" id="document_type_id'+i+'" >';
	          			drug +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						drug +='<input type="checkbox" class="custom-control-input drug_test_type_name" name="drug_test_type_name'+data.drug[i]['drug_test_type_id']+'" value="'+data.drug[i]['drug_test_type_id']+'" id="customradiopackdrugcheck'+data.drug[i]['drug_test_type_id']+'">';
						drug +='<label class="custom-control-label" for="customradiopackdrugcheck'+data.drug[i]['drug_test_type_id']+'">'+data.drug[i]['drug_test_type_name']+'</label><input type="hidden" class="form-control fld drug_test_type_id" value="'+data.drug[i]['drug_test_type_id']+'" id="drug_test_type_id'+i+'" >';
						drug +='</div>';
	          			drug +='</div>';
	          			drug +='<div class="col-md-3 mt-1">';
						drug +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" class="form-control fld drug_price" id="drug_price'+i+'" >';
						drug +='</div>'; 
	          		}
          		}

          		if (data.doc.length > 0) { 	
	          		for (var i = 0; i < data.doc.length; i++) {
	          			// data.doc[i]
	          			doc +='<div class="col-md-3 mt-1">';
	          			// doc +='<span class="document_type_name" id="document_type_name'+i+'">'+data.doc[i]['document_type_name']+'</span><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
	          			doc +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						doc +='<input type="checkbox" class="custom-control-input document_type_name" name="document_type_name'+data.doc[i]['document_type_id']+'" value="'+data.doc[i]['document_type_id']+'" id="customradiopackdoccheck'+data.doc[i]['document_type_id']+'">';
						doc +='<label class="custom-control-label" for="customradiopackdoccheck'+data.doc[i]['document_type_id']+'">'+data.doc[i]['document_type_name']+'</label><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
						doc +='</div>';
	          			doc +='</div>';
	          			doc +='<div class="col-md-3 mt-1">';
						doc +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" class="form-control fld document_price" id="document_price'+i+'" >';
						doc +='</div>'; 
	          		}
          		}
          		for (var i = 0; i < data.pack.length; i++) { 
					html +='<div class="row ul'+data.pack['package_id']+'">';

					html +='<div class="col-md-4 mt-1">';
					
					html +='<div class="custom-control custom-radio custom-control-inline mrg">';
					html +='<input type="radio" class="custom-control-input component_price_type" name="component_price_type'+data.pack['component_id']+'" value="'+data.pack['component_id']+'" id="customradio'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customradio'+data.pack['component_id']+'">Form Base Price</label>';
					html +='</div>';

          			html +='</div>';
          			html +='<div class="col-md-4 mt-1">'; 

					html +='<div class="custom-control custom-radio custom-control-inline mrg">';
					html +='<input type="radio" class="custom-control-input component_price_type" name="component_price_type'+data.pack['component_id']+'" value="'+data.pack['component_id']+'" id="customradio_'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customradio_'+data.pack['component_id']+'">Component Base Price</label>';
					html +='</div>';

          			html +='</div>';
          			html +='<div class="col-md-4 mt-1">';
					html +='';
					html +='</div>';


					html +='<div class="col-md-4 mt-1">';
					html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					html +='<input type="checkbox" disabled checked class="custom-control-input component_name" name="customCheck" value="'+data.pack['component_id']+'" id="customCheck'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customCheck'+data.pack['component_id']+'">'+data.pack['fs_crm_component_name']+'</label>';
					html +='</div>';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<input type="hidden" class="form-control fld2 component_package_id"  value="'+data.pack.package_id+'" id="component_package_id'+j+'">';
					html +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data.pack.component_standard_price+'" id="component_standard_price'+j+'">';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<input type="text" class="form-control fld component_price" id="component_price'+j+'" oninput="oninput_float('+j+')" onkeypress="return oninput_fun(event)" onkeyup="component_price('+j+')">';
					html +='</div>';
					if (data.pack['component_id'] == 3) {
					html +=doc;
					}else if(data.pack['component_id'] == 4){
					html +=drug;
					}else if(data.pack['component_id'] == 7){
					html +=edu;
					}else if (!jQuery.inArray(data.pack['component_id'], [3,4,7]) !== -1) {
						if (data.pack['form_threshold'] > 0) {
							for (var k = 1; k <= data.pack['form_threshold']; k++) {
								 
						html +='<div class="col-md-3 mt-1">'; 
	          			html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						html +='<input type="checkbox" class="custom-control-input form" name="form'+k+'" value="'+k+'" id="customradiopackeducheckform'+k+'">';
						html +='<label class="custom-control-label" for="customradiopackeducheckform'+k+'">'+data.pack['fs_crm_component_name']+' '+k+'</label><input type="hidden" class="form-control fld form" value="'+k+'" id="form_threshold'+k+'" >';
						html +='</div>';
	          			html +='</div>';
	          			html +='<div class="col-md-3 mt-1">';
						html +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" class="form-control fld text_form" id="text_form'+i+'" >';
						html +='</div>'; 

							}
						}
					}
					html +='</div>';
					html +='<hr>';
					j++;
          		}
          	}
          	$("#component-details").append(html);
          }
     	});
	} else {
		input_is_invalid('#packages');
		$('#packages-error').html('<span class="text-danger error-msg-small">Please select packages.</span>');
	}

	}else{
		for (var i = 0; i < tmp.length; i++) { 
		if(jQuery.inArray(tmp[i], packages) === -1) {
			pkg_id = tmp[i];
		}
		
	}
 
		
		$(".ul"+pkg_id).remove();
		$('#tmp-packages').val(packages);
		// component_price();
		 
	}
	 
	
}


function valid_alacarte(){
	var alacarte = $('#alacarte').val();
	// alert(packages)
	var tmpalacarte = $('#tmp-alacarte').val();
	var tmp = [];
	if (tmpalacarte !='') {
		// alert(tmppackages)
		tmp = tmpalacarte.split(',');
	}
	var flg = 0;
	var alacarte_id = 0;
	for (var i = 0; i < alacarte.length; i++) { 
		if(jQuery.inArray(alacarte[i], tmp) === -1) { 
			flg = 1;
			alacarte_id = alacarte[i];
		}
		
	} 
 
	if (flg == 1) { 
		
		if (alacarte != '') {
		$('#alacarte-error').html('&nbsp;');
		input_is_valid('#alacarte'); 
		$.ajax({
          type: "POST",
          url: base_url+"package/get_alacarte_component/",
          data:{alacarte_id:alacarte_id},
          dataType: 'json', 
          success: function(data) {
          	var html='';
          	if (data.pack.length > 0) {
          		$('#tmp-alacarte').val(alacarte);
          		var edu = '';
          		var drug = '';
          		var doc = '';
          		if (data.edu.length > 0) { 	
	          		for (var i = 0; i < data.edu.length; i++) { 
						edu +='<div class="col-md-3 mt-1">';
	          			// edu +='<span class="education_type_name" id="education_type_name'+i+'">'+data.edu[i]['education_type_name']+'</span><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
	          			edu +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						edu +='<input type="checkbox" class="custom-control-input education_type_name" name="education_type_name'+data.edu[i]['education_type_id']+'" value="'+data.edu[i]['education_type_id']+'" id="customradioeducheck'+data.edu[i]['education_type_id']+'">';
						edu +='<label class="custom-control-label" for="customradioeducheck'+data.edu[i]['education_type_id']+'">'+data.edu[i]['education_type_name']+'</label><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
						edu +='</div>';
	          			edu +='</div>';
	          			edu +='<div class="col-md-3 mt-1">';
						edu +='<input type="text" class="form-control fld education_price" id="education_price'+i+'" >';
						edu +='</div>'; 
	          		}
          		}
          		
          		if (data.drug.length > 0) { 	
	          		for (var i = 0; i < data.drug.length; i++) { 
						drug +='<div class="col-md-3 mt-1">';
	          			// drug +='<span class="drug_test_type_name" id="drug_test_type_name'+i+'">'+data.drug[i]['drug_test_type_name']+'</span><input type="hidden" class="form-control fld document_type_id" value="'+data.drug[i]['document_type_id']+'" id="document_type_id'+i+'" >';
	          			drug +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						drug +='<input type="checkbox" class="custom-control-input drug_test_type_name" name="drug_test_type_name'+data.drug[i]['drug_test_type_id']+'" value="'+data.drug[i]['drug_test_type_id']+'" id="customradiodrugcheck'+data.drug[i]['drug_test_type_id']+'">';
						drug +='<label class="custom-control-label" for="customradiodrugcheck'+data.drug[i]['drug_test_type_id']+'">'+data.drug[i]['drug_test_type_name']+'</label><input type="hidden" class="form-control fld drug_test_type_id" value="'+data.drug[i]['drug_test_type_id']+'" id="drug_test_type_id'+i+'" >';
						drug +='</div>';
	          			drug +='</div>';
	          			drug +='<div class="col-md-3 mt-1">';
						drug +='<input type="text" class="form-control fld drug_price" id="drug_price'+i+'" >';
						drug +='</div>'; 
	          		}
          		}

          		if (data.doc.length > 0) { 	
	          		for (var i = 0; i < data.doc.length; i++) {
	          			// data.doc[i]
	          			doc +='<div class="col-md-3 mt-1">';
	          			// doc +='<span class="document_type_name" id="document_type_name'+i+'">'+data.doc[i]['document_type_name']+'</span><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
	          			doc +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						doc +='<input type="checkbox" class="custom-control-input document_type_name" name="document_type_name'+data.doc[i]['document_type_id']+'" value="'+data.doc[i]['document_type_id']+'" id="customradiodoccheck'+data.doc[i]['document_type_id']+'">';
						doc +='<label class="custom-control-label" for="customradiodoccheck'+data.doc[i]['document_type_id']+'">'+data.doc[i]['document_type_name']+'</label><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
						doc +='</div>';
	          			doc +='</div>';
	          			doc +='<div class="col-md-3 mt-1">';
						doc +='<input type="text" class="form-control fld document_price" id="document_price'+i+'" >';
						doc +='</div>'; 
	          		}
          		}
          		for (var i = 0; i < data.pack.length; i++) { 
					html +='<div class="row alacarte-ul'+data.pack['package_id']+'">';

					html +='<div class="col-md-4 mt-1">';
					
					html +='<div class="custom-control custom-radio custom-control-inline mrg">';
					html +='<input type="radio" class="custom-control-input component_price_type" name="component_price_type'+data.pack['component_id']+'" value="'+data.pack['component_id']+'" id="customradio'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customradio'+data.pack['component_id']+'">Form Base Price</label>';
					html +='</div>';

          			html +='</div>';
          			html +='<div class="col-md-4 mt-1">'; 

					html +='<div class="custom-control custom-radio custom-control-inline mrg">';
					html +='<input type="radio" class="custom-control-input component_price_type" name="component_price_type'+data.pack['component_id']+'" value="'+data.pack['component_id']+'" id="customradio_'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customradio_'+data.pack['component_id']+'">Component Base Price</label>';
					html +='</div>';

          			html +='</div>';
          			html +='<div class="col-md-4 mt-1">';
					html +='';
					html +='</div>';


					html +='<div class="col-md-4 mt-1">';
					html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					html +='<input type="checkbox" disabled checked class="custom-control-input component_name" name="customCheck" value="'+data.pack['component_id']+'" id="customCheck'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customCheck'+data.pack['component_id']+'">'+data.pack['fs_crm_component_name']+'</label>';
					html +='</div>';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<input type="hidden" class="form-control fld2 component_package_id"  value="'+data.pack.package_id+'" id="component_package_id'+j+'">';
					html +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data.pack.component_standard_price+'" id="component_standard_price'+j+'">';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<input type="text" class="form-control fld component_price" id="component_price'+j+'" oninput="oninput_float('+j+')" onkeypress="return oninput_fun(event)" onkeyup="component_price('+j+')">';
					html +='</div>';
					if (data.pack['component_id'] == 3) {
					html +=doc;
					}else if(data.pack['component_id'] == 4){
					html +=drug;
					}else if(data.pack['component_id'] == 7){
					html +=edu;
					}else if (!jQuery.inArray(data.pack['component_id'], [3,4,7]) !== -1) {
						if (data.pack['form_threshold'] > 0) {
							for (var k = 1; k <= data.pack['form_threshold']; k++) {
								 
						html +='<div class="col-md-3 mt-1">'; 
	          			html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						html +='<input type="checkbox" class="custom-control-input form" name="form'+k+'" value="'+k+'" id="customradioeducheckform'+k+'">';
						html +='<label class="custom-control-label" for="customradioeducheckform'+k+'">Form '+k+'</label><input type="hidden" class="form-control fld form" value="'+k+'" id="form_threshold'+k+'" >';
						html +='</div>';
	          			html +='</div>';
	          			html +='<div class="col-md-3 mt-1">';
						html +='<input type="text" class="form-control fld text_form" id="text_form'+i+'" >';
						html +='</div>'; 

							}
						}
					}
					html +='</div>';
					html +='<hr>';
					j++;
          		}
          	}
          	$("#alacarte-component-details").append(html);
          }
     	});
	} else {
		input_is_invalid('#alacarte');
		$('#alacarte-error').html('<span class="text-danger error-msg-small">Please select alacarte.</span>');
	}

	}else{
		for (var i = 0; i < tmp.length; i++) { 
		if(jQuery.inArray(tmp[i], alacarte) === -1) {
			alacarte_id = tmp[i];
		}
		
	}
 
		
		$(".alacarte-ul"+alacarte_id).remove();
		$('#tmp-alacarte').val(alacarte);
		// component_price();
		 
	}
	 
	
}
/*function component_price_call(id){
	component_price(id)
}*/
function component_price(id){
	// var component_price = $("#component_price"+id).val();
	// var component_standard_price = $("#component_standard_price"+id).val();
	// // alert(component_standard_price)
	// 	var total = 0;
	// if (parseFloat(component_standard_price) >= parseFloat(component_price) && parseFloat(component_price) > 0) {
	// 	$("#component-price-error").html('&nbsp;');
	// 	$(".component_price").each(function(){ 
 //  			if ($(this).val() !='' && $(this).val() !=null) { 
 //  				  total += parseFloat($(this).val())
 //  			}else{
 //  				total += 0	
 //  			}
	// 	});
	// 	/*var sub_total = 0;
	// 	if (total.length > 0) {
	// 		sub_total = total
	// 	}*/
		
	// 	// alert(eval(total.join("+")))
	// 	input_is_valid("#component_price"+id);
	// }else{
	// 	input_is_invalid("#component_price"+id);
	// 	// $("#component_price"+id).val();
	// 	$("#component-price-error").html('<span class="text-danger error-msg-small">Please enter less or equal Standards Price</span>');
	// 	// component_price_call(id)
		
	// 	if (component_price =='' || component_price ==null) { 
	// 		$(".component_price").each(function(){ 
 //  			if ($(this).val() !='' && $(this).val() !=null) { 
 //  				  total += parseFloat($(this).val())
 //  			}else{
 //  				total += 0	
 //  			}
	// 	});
	// 	}
	// }

	// 	var total_html = '';
	// 		total_html +='<ul>';
	// 		total_html +='<li> ';
	// 		total_html +='</li>';
	// 		total_html +='<li>';
	// 		total_html +=' <label>Price for Client total</label>';
	// 		total_html +='</li>';
	// 		total_html +='<li>';
	// 		total_html +='<b>'+total+'</b>';
	// 		total_html +='</li>';
	// 		total_html +='</ul> ';

	// 	$("#component-total").html(total_html); 
}


$("#is_master").on('click',function(){
	var is_master = $("#is_master:checked").val();
	if (is_master !=null && is_master =='0') {
		$("#master-account").attr('disabled',true);
		$("#master-account").val('');
	}else{
		$("#master-account").attr('disabled',false);
	}
});




function save_client() {
	var client_name = $("#client-name").val();
	var client_address = $("#client-address").val();
	var client_city = $("#client-city").val();
	var client_state = $('#client-state').val();
	var client_industry = $("#client-industry").val();
	var other_industry = $("#other_industry").val();
	var client_website = $("#client-website").val();
	var master_account = $("#master-account").val();
	var account_manager = $("#account-manager").val();
	var manager_email = $("#manager-email").val();
	var manager_contact = $("#manager-contact").val();
	var zip = $('#client-zip').val();
	var is_master = $("#is_master:checked").val(); 
	var country = $('#country').val();
	var location = $("#location").val();
	var segment = $("#segment").val();
	var document_download_by_client = $('#document-download-by-client:checked').val();
	var notification_to_candidate = $('#notification-to-candidate:checked').val();
	// var user_contact = $('#user-contact').val();
	// var first_name = $('#first-name').val();
	// var last_name = $('#last-name').val();
	var package = $('#packages').val();
	// var password = $("#user-password").val();
	// var confirm_password = $("#confirm-team-password").val();
	var communications = [];
	$(".communications:checked").each(function(){ 
		if ($(this).val() !='' && $(this).val() !=null) {
			communications.push($(this).val());
		}
	});

	var component_package_id = [];
	$(".component_package_id").each(function(){ 
		if ($(this).val() !='' && $(this).val() !=null) {
			component_package_id.push($(this).val());
		}
	});

	var spo_name = [];
	$(".spo_name").each(function(){
		if($(this).val()==''){ 
		 	$("#spo-details-div-error").html('<span class="text-danger error-msg-small">Please enter the required fields</span>');
	      return false;
	    }
		if ($(this).val() !='' && $(this).val() !=null) {
			spo_name.push({name:$(this).val()});
		}
	});
	var spo_email = [];
	$(".spo_email").each(function(){
		if($(this).val()==''){ 
		 	$("#spo-details-div-error").html('<span class="text-danger error-msg-small">Please enter the required fields</span>');
	      return false;
	    }
		if ($(this).val() !='' && $(this).val() !=null) {
			spo_email.push({email:$(this).val()});
		}
	});
	var spo_contact = [];
	$(".spo_contact").each(function(){
		if($(this).val()==''){ 
		 	$("#spo-details-div-error").html('<span class="text-danger error-msg-small">Please enter the required fields</span>');
	      return false;
	    }
		if ($(this).val() !='' && $(this).val() !=null) {
			spo_contact.push($(this).val());
		}
	});

 	if(client_industry == '101' && (other_industry == '' || other_industry == null)){
		$("#other-industry-error").html('<span class="text-danger error-msg-small">Please fill industry name</span>');
		$('#other_industry').focus()
	    return false;
	}
	/*var component_name = [];
	$(".component_name").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
			component_name.push($(this).val());
		}
	});
	var component_standard_price = [];
	$(".component_standard_price").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
			component_standard_price.push($(this).val());
		}
	});*/
	/*var component_price = [];
	$(".component_price").each(function(){
		 if($(this).val()==''){ 
		 	$("#component-price-error").html('<span class="text-danger error-msg-small">Please fill All Client price required </span>');
	      return false;
	    }
		if ($(this).val() !='' && $(this).val() !=null) {
			component_price.push($(this).val());
		}
	});*/


 
	/*sessionStorage.setItem("client_name", client_name);
	sessionStorage.setItem("client_address", client_address);
	sessionStorage.setItem("client_city", client_city);
	sessionStorage.setItem("client_state", client_state);
	sessionStorage.setItem("client_industry", client_industry);
	sessionStorage.setItem("other_industry", other_industry);
	sessionStorage.setItem("client_website", client_website);
	sessionStorage.setItem("master_account", master_account);
	sessionStorage.setItem("account_manager", account_manager);
	sessionStorage.setItem("manager_email", manager_email);
	sessionStorage.setItem("manager_contact", manager_contact);
	// sessionStorage.setItem("package", package);
	sessionStorage.setItem("spo_name", spo_name);
	sessionStorage.setItem("spo_email", spo_email);
	sessionStorage.setItem("spo_contact", spo_contact);
	sessionStorage.setItem("communications", communications);
	sessionStorage.setItem("zip", zip);
	sessionStorage.setItem("is_master", is_master);
	sessionStorage.setItem("country", country);*/
	// sessionStorage.setItem("client_docs", JSON.stringify(client_docs));




	var formdata = new FormData();

	formdata.append('description',$("#ticket_description").val());
	 formdata.append('additional_remarks',$("#additional_remarks").val()); 
	formdata.append('client_name',client_name);
	formdata.append('client_address',client_address);
	formdata.append('client_city',client_city);
	formdata.append('client_state',client_state);
	formdata.append('client_industry',client_industry);
	formdata.append('client_website',client_website);
	formdata.append('master_account',master_account);
	formdata.append('account_manager',account_manager);
	formdata.append('manager_email',manager_email);

	formdata.append('manager_contact',manager_contact);
	formdata.append('package',package);
	formdata.append('spo_name',JSON.stringify(spo_name));
	formdata.append('spo_email',JSON.stringify(spo_email));
	formdata.append('spo_contact',spo_contact);
	formdata.append('communications',communications);
	formdata.append('zip',zip);
	formdata.append('location',location);
	formdata.append('segment',segment);
	if (is_master !=null && is_master =='1') {
		formdata.append('is_master',is_master);
	}
	formdata.append('document_download_by_client', (document_download_by_client != undefined) ? 1 : 0);
	formdata.append('notification_to_candidate', (notification_to_candidate != undefined) ? 1 : 0);
	formdata.append('iverify_or_pv_type', $('input[name="client-iverify-or-pv-type"]:checked').val());
	formdata.append('tv_or_ebgv', $('input[name="client-tv-ebgv"]:checked').val());
	formdata.append('signature', $('input[name="client-signature"]:checked').val());
	
	/*formdata.append('component_name',component_name);
	formdata.append('component_standard_price',component_standard_price);
	formdata.append('component_package_id',component_package_id);
	formdata.append('component_price',component_price);*/
	formdata.append('country',country);

	formdata.append('insuff_client_notification',0);
	var insuff_client_notification_to_client_checked_type_status = 1;
	var insuff_client_notification_to_client_checked_types = [];
	if ($('#insuff-client-notification').is(':checked')) {
		formdata.append('insuff_client_notification',1);
		insuff_client_notification_to_client_checked_type_status = check_checked_insuff_client_notification_types_selected();
		if (insuff_client_notification_to_client_checked_type_status == 1) {
			$('input[name="insuff-client-notification-type[]"]:checked').each(function(i) {
    		insuff_client_notification_to_client_checked_types[i] = $(this).val();
   		});
   		formdata.append('insuff_client_notification_to_client_checked_types',insuff_client_notification_to_client_checked_types);
		}
	}

	formdata.append('client_clarification_client_notification',0);
	var client_clarification_client_notification_to_client_checked_type_status = 1;
	var client_clarification_client_notification_to_client_checked_types = [];
	if ($('#client-clarification-client-notification').is(':checked')) {
		formdata.append('client_clarification_client_notification',1);
		client_clarification_client_notification_to_client_checked_type_status = check_checked_client_clarification_client_notification_types_selected();
		if (client_clarification_client_notification_to_client_checked_type_status == 1) {
			$('input[name="client-clarification-client-notification-type[]"]:checked').each(function(i) {
    		client_clarification_client_notification_to_client_checked_types[i] = $(this).val();
   		});
   		formdata.append('client_clarification_client_notification_to_client_checked_types',client_clarification_client_notification_to_client_checked_types);
		}
	}

	/*if (client_docs.length > 0) {
		for(var i=0, len=client_docs.length; i<len; i++) {
			formdata.append('files[]', client_docs[i]);
		}
	} else {
		formdata.append('files[]', '');
	}*/
	 // '<a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a><button onclick="save_client()" id="client-submit-btn" class="btn bg-blu btn-submit-cancel">SAVE &amp; NEXT</button>'

	// var btn = '<a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a><button onclick="save_client()" id="client-submit-btn" class="btn bg-blu btn-submit-cancel"><div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div> Submitting.</button>'
 

	if (client_name !='' &&
		client_address !='' &&
		client_city !='' &&
		client_state !='' &&
		client_industry !='' &&
		client_website !='' &&
		 // (is_master !=null || master_account !='' ) &&
		/*account_manager !='' &&
		manager_email !='' &&
		manager_contact !='' &&*/
		// package !='' &&
		spo_name .length > 0 &&
		spo_email .length > 0 &&
		spo_contact .length > 0 &&
		communications !='' &&
		zip !='' && insuff_client_notification_to_client_checked_type_status == 1 && client_clarification_client_notification_to_client_checked_type_status == 1 && $('input[name="client-iverify-or-pv-type"]:checked').length > 0) {

		$("#client-submit-btn").html('<div class="spinner-border spinner-border-sm text-success" role="status"><span class="sr-only">Loading...</span></div> Submitting..');
	$("#client-submit-btn").prop('disabled',true);

		// var formdata = new FormData();
	$("#communication-error").html("&nbsp;");

	if (client_docs.length > 0) {
		for(var i=0, len=client_docs.length; i<len; i++) {
			formdata.append('files[]', client_docs[i]);
		}
	} else {
		formdata.append('files[]', '');
	}

	$.ajax({
            type: "POST",
              url: base_url+"client/add_client_images/",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
              	sessionStorage.setItem("client_docs", data);
              	formdata.append('client_docs', data);
				// window.location.href = base_url+"factsuite-admin/add-new-client-select-packages";
              }
          })



	// }else{

	/*	var btn = 'Save & Next';

	$("#client-submit-btn").html(btn);
	$("#client-submit-btn").prop('disabled',false);

	if (communications.length == 0) {
    		$("#communication-error").html('<span class="text-danger error-msg-small">Please select atleast one</span>');
    	}
    	valid_client_name();
		valid_client_address();
		valid_client_city();
		valid_state();
		valid_client_industry();
		valid_client_website();
		// valid_client_master_account();
		if(is_master ==null || master_account =='' ){
			valid_client_master_account();
		}
		// valid_account_manager();
		// valid_manager_email();
		// valid_manager_contact();
		check_user_name();
		check_contact();
		valid_first_name();
		valid_last_name(); 
		// check_reccovery_password_match();
		valid_client_zip();
    }*/

		$("#client-error").html("<span class='text-warning error-msg-small'> Please wait while we are updating the data.</span>");
		$("#client-submit-btn").attr('disabled',true);

        $.ajax({
            type: "POST",
              url: base_url+"client/insert_client/",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
                if (data.status == '1') {  
                	toastr.success('New add client has been successfully.');
                	window.location.href = base_url+"factsuite-admin/edit-select-package-component-client/"+data.client_id; 
                	$("#client-name").val('');
					$("#client-address").val('');
					$("#client-city").val('');
					$('#client-state').val('');
					$("#client-industry").val('');
					$("#client-website").val('');
					$("#master-account").val(0);
					$("#account-manager").val('');
					$("#manager-email").val('');
					$("#manager-contact").val('');
					$('#client-zip').val('');
					$('#packages').val(''); 
					$(".communications:checked").each(function(){ 
						this.checked = false;
					});
					$("#selected-client-docs-li").html('');

					$(".spo_name").each(function(){ 
						$(this).val('')
					});
					$(".spo_email").each(function(){ 
						$(this).val('')
					});
					$(".spo_contact").each(function(){ 
						$(this).val('')
					});
					$('.is-valid').removeClass('is-valid');
					client_docs =[];
					$("#component-details").html('');
					$("#client-documents").val('')
					$("#selected-vendor-docs-li").html('');
					$("#component-total").html(''); 
					$(".is_master:checked").each(function(){ 
						this.checked = false;
					});

					$('#document-download-by-client').attr('disabled',false);
					$('#notification-to-candidate').attr('disabled',false);

                }else{ 
                	$("#client-error").html("");
                	toastr.error('Something went wrong while add client. Please try again.'); 
                } 
                $("#client-submit-btn").attr('disabled',false);
                $("#client-error").html('');
              }
          }); 

    }else{
    	if (communications.length == 0) {
    		$("#communication-error").html('<span class="text-danger error-msg-small">Please select min 1 required</span>');
    	}
    	valid_client_name();
		valid_client_address();
		valid_client_city();
		valid_state();
		valid_client_industry();
		valid_client_website();
		// valid_client_master_account();
		if(is_master ==null || master_account =='' ){
			valid_client_master_account();
		}
		// valid_account_manager();
		// valid_manager_email();
		// valid_manager_contact();
		check_user_name();
		check_contact();
		valid_first_name();
		valid_last_name();
		// valid_packages();
		check_reccovery_password_match();
		// check_reccovery_password_match();
		valid_client_zip();
		check_selected_iverify_or_pv_type_selected();
    }

}


 var i = 1;
   $("#add-new").click(function(){  
   		var is_true = true;
   	  $('.spo_name').each(function(){
	    if($(this).val()==''){ 
	      is_true = false;
	    }
	  });
	  $('.spo_email').each(function(){
	    if($(this).val()==''){ 
	      is_true = false;
	    }
	  });
	  $('.spo_contact').each(function(){
	    if($(this).val()==''){ 
	      is_true = false;
	    }
	  });
	  if (is_true == false) {
	  	return false;
	  }
    var row = '';
		row +='<ul id="'+i+'">';
		row +='<li>';
		row +='<label>Name</label>';
		row +='<input type="text" class="form-control fld spo_name" onkeyup="valid_spoc_name('+i+')" id="spoc-name'+i+'">';
		row +='<div id="spoc-name-error'+i+'">&nbsp;</div>';
		row +='</li>';
		row +='<li>';
		row +='<label>Email</label>';
		row +='<input type="email" class="form-control fld spo_email" onkeyup="valid_spoc_email('+i+')" id="spoc-email'+i+'">';
		row +='<div id="spoc-email-error'+i+'">&nbsp;</div>';
		row +='</li>';
		row +='<li>';
		row +='<label>Phone Number</label>';
		row +='<input type="number" class="form-control fld spo_contact" onkeyup="valid_spoc_contact('+i+')" id="spoc-contact'+i+'">';
		row +='<div id="spoc-contact-error'+i+'">&nbsp;</div>';
		row +='</li>';
		row +='<li>';
		row +='<button onclick="remove_tr('+i+')" class="btn btn-danger"><i class="fa fa-remove"></i></button>';
		row +='<div>&nbsp;</div>';
		row +='</li>';
		row +='</ul>';

  		$("#spo-details-div").append(row);     
        i++; 
    });
 
 function remove_tr(id){ 
   $("#"+id).remove(); 
 } 

$("#country").on('keyup blur change',valid_countries)
function valid_countries() { 
	var country = $("#country").val();
	$("#client-state").html('<option selected="" value="">Select State</option>');
	$("#client-city").html('<option selected="" value="">Select City</option>');
	if (country !='') {
		var c_id = $("#country").children('option:selected').data('id')
		
		$.ajax({
            type: "POST",
          	url: base_url+"client/get_selected_states/"+c_id, 
          	dataType: 'json', 
          	success: function(data) {
              	var html = "<option selected value=''>Select State</option>";
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
					}
				}
				$("#client-state").html(html);
				valid_state('changed_country');
            }
        });
		$("#country-error").html("&nbsp;");
		input_is_valid("#country")
	} else {
		$("#client-state").html('<option selected="" value="">Select State</option>');
		$("#client-city").html('<option selected="" value="">Select City</option>');
		$("#country-error").html("<span class='text-danger error-msg-small'>Please Select Valid country</span>");
		input_is_invalid("#country")
	}
}


$("#add-packages").on('click',function(){
	$("#view-package-data").modal('show');
	// alert(sessionStorage.getItem("spo_name"))
	$("#add-package_name").val('');
	 
	 $(".package_components:checked").prop('checked',false)
});

$("#add-alacarte").on('click',function(){
	$("#view-alacarte-data").modal('show');
	$(".alacarte_components:checked").prop('checked',false)
	$(".alacarte_component_id").each(function(){

			$("#customradioeduchealacarte"+$(this).val()).prop('checked',true);
		 
	})
});

/********************/
/*Start::PACKAGE area*/
/*******************/
$("#add-package-data").on('click',function(){
	$("#package-name-error-msg").html('').fadeIn();
var package = $("#add-package_name").val();
var component_ids = [];
$(".package_components:checked").each(function(){
	component_ids.push($(this).val());
}); 

if (package !='' && package !=null ) {

	$.ajax({
          type: "POST",
          url: base_url+"package/insert_package/",
          data:{
          	package_name:package,
          	component_ids:component_ids
          },
          dataType: 'json', 
          success: function(data) {
          		var html = '';

	// var package_id = [];
	// var package_name = [];
	// $(".package_name:checked").each(function(){
		/*alert($(this).val())
		alert($(this).data('alacarte_name'))*/
		html +='<div class="col-md-2 m-2 ml-4" id="package_div_'+data.package_id+'">';
		html +='<div class="image-selected-div p-2"><a href="#" onclick="get_package_component_data('+data.package_id+')">';
		html +='<input type="hidden" class="main_package_id" data-package_name="'+package+'" id="main_package_id'+data.package_id+'" value="'+data.package_id+'" >'
		html +='<span class="font-weight-normal" id="package_name_'+data.package_id+'">'+package+'</span>'
		html +='</a>';
		html +='<div class="float-right"><a onclick="remove_package('+data.package_id+')"><i class="fa fa-remove"></i></a></div>'
		html +='</div>';
		// package_id.push($(this).val());
		// package_name.push($(this).data('package_name'));
	// });
	// sessionStorage.setItem("package_id", package_id);
	// sessionStorage.setItem("package_name", package_name);
	$("#get-packages").append(html);
	$("#view-package-data").modal('hide');
          }
      });
}else{
	$("#package-name-error-msg").html("<span class='text-danger error-msg-small'> Please Enter Package name.</span>").fadeOut(10000);
}

});

function remove_package(package_id){
	$('#view-package-remove-modal').modal('show');

	$("#modal-package_id").val(package_id);

}



$("#package-remove-btn").on('click',function(){
	var package_id = $("#modal-package_id").val();
		$.ajax({
	    type: "POST",
	    url: base_url+"package/remove_package/"+package_id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		$('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	$("#package_div_"+package_id).remove();
	        	 $('#view-package-remove-modal').modal('hide');
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('package has been successfully removed.');
			} else {
		         
		        toastr.error('Something went wrong while deleting the package data. Please try again.');
			} 
	    },
	    error: function(data){
	       $('#view-package-remove-modal').modal('hide');
	    	toastr.error('Something went wrong while deleting the package data. Please try again.');
	    } 
	  });
 
});

/********************/
/*END::PACKAGE area*/
/*******************/

$("#add-alacarte-data").on('click',function(){ 
var html = '';
var alacarte = [];
	 
$(".alacarte_components:checked").each(function(){
	// component_ids = []
	html +='<div class="col-md-3 m-2 ml-4" id="alacarte_div_'+$(this).val()+'">';
	html +='<div class="image-selected-div p-1">';
	html +='<input type="hidden" class="alacarte_component_id" data-component_name="'+$(this).data('component_name')+'" id="alacarte_component_id'+$(this).val()+'" value="'+$(this).val()+'" >'
	html +='<span>'+$(this).data('component_name')+'</span>'
	html +='<div class="float-right"><a onclick="remove_alacarte('+$(this).val()+')"><i class="fa fa-remove"></i></a></div>'
	html +='</div>';
	html +='</div>';

	alacarte.push({component_id:$(this).val(),component_name:$(this).data('component_name')});
}); 

// alert(JSON.stringify(alacarte))
sessionStorage.setItem("alacarte", JSON.stringify(alacarte));
	$("#get-alacarte").html(html);
	$("#view-alacarte-data").modal('hide');
});


function remove_alacarte(alacarte_id){
 	$('#view-alacarte-remove-modal').modal('show'); 
	$("#modal-alacarte_id").val(alacarte_id);
}


$("#alacarte-remove-btn").on('click',function(){
	var alacarte_id = $("#modal-alacarte_id").val();
	   	$("#alacarte_div_"+alacarte_id).remove();
	    $('#view-alacarte-remove-modal').modal('hide'); 
		toastr.success('package successfully removed.'); 
});

/// 
function get_package_component_data(package_id){
	$("#view-component-data").modal('show');
$(".package_component_ids").attr('checked',false);
	$("#package-name-error-msg").html('').fadeIn();
	var package_name = $("#main_package_id"+package_id).data('package_name');
	$("#added_package_name").val(package_id); 
	$("#edit_package_name").val(package_name);

if (package_name =='' || package_name ==null) {

	$("#package-name-error-msg").html("<span class='text-danger error-msg-small'> Please Enter Package name.</span>").fadeOut(10000);
	return false;
}
	$.ajax({
          type: "POST",
          url: base_url+"package/get_package_component/",
          data:{package_id:package_id},
          dataType: 'json', 
          success: function(data) {
          	var html='';
          	if (data.pack.length > 0) {
          		for (var i = 0; i < data.pack.length; i++) { 
          			$("#package_component_ids"+data.pack[i].component_id).prop('checked',true);
          	/*	 
          	html +='<div class="col-md-3 mt-1">'; 
  			html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
			html +='<input type="checkbox" class="custom-control-input component_name" data-form_threshold="'+data.pack[i].form_threshold+'" data-component_standard_price="'+data.pack[i].component_standard_price+'" name="component_name'+data.pack[i].component_id+'" data-component_package_id="'+data.pack[i].package_id+'" data-component_name="'+data.pack[i].component_name+'" value="'+data.pack[i].component_id+'" id="customcheckcomponent'+data.pack[i].component_id+'">';
			html +='<label class="custom-control-label" for="customcheckcomponent'+data.pack[i].component_id+'">'+data.pack[i].component_name+'</label>';
			html +='</div>';
  			html +='</div>';*/

  			}

          	}
          	// $("#view-all-component").html(html);
          }
 	 });
}

/// package component 
 // var package_component = [];
$("#add-all-package-data").on('click',function(){

	var package_id = $("#added_package_name").val();
	var package_name = $("#edit_package_name").val();
var component_ids = [];
$(".package_component_ids:checked").each(function(){
	component_ids.push($(this).val())
	// package_component.push({component_id : $(this).val(),package_id:$(this).data('component_package_id') ,component_name:$(this).data('component_name'),form_threshold:$(this).data('form_threshold'),component_standard_price:$(this).data('component_standard_price') });
})

if (package_id !='' && component_ids.length > 0) {

$.ajax({
      type: "POST",
      url: base_url+"package/update_package/",
      data:{
      	package_id:package_id,
      	package_name:package_name,
      	component_ids:component_ids
      },
      dataType: 'json', 
      success: function(data) {
      	var html = '';
      	$("#package_name_"+package_id).val(package_name)
		$("#view-component-data").modal('hide');
	 }
	});

}

// sessionStorage.setItem("package_component", JSON.stringify(package_component));
})

function get_alacarte_component_data(alacart_id){
	$("#view-alacarte-component").modal('hide');

	$.ajax({
          type: "POST",
          url: base_url+"package/get_alacarte_component/",
          data:{alacarte_id:alacart_id},
          dataType: 'json', 
          success: function(data) {
          	var html='';
          	if (data.pack.length > 0) {
          		for (var i = 0; i < data.pack.length; i++) {
          		 
	          	html +='<div class="col-md-3 mt-1" id="alacarte_id'+data.pack[i].component_id+'">'; 
	  			html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
				html +='<input type="checkbox" class="custom-control-input alacart_component_name"  data-form_threshold="'+data.pack[i].form_threshold+'" data-component_standard_price="'+data.pack[i].component_standard_price+'"  name="alacart_component_name'+data.pack[i].component_id+'" data-component_alacart_id="'+data.pack[i].alacarte_id+'"  data-component_name="'+data.pack[i].component_name+'" value="'+data.pack[i].component_id+'" id="customcheckalacartcomponent'+data.pack[i].component_id+'">';
				html +='<label class="custom-control-label" for="customcheckalacartcomponent'+data.pack[i].component_id+'">'+data.pack[i].component_name+'</label>';
				html +='</div>';
	  			html +='</div>';

	  			}

          	}
          	$("#view-all-alacarte").html(html);
          }
 	 });
}

 var alacarte_component = [];
$("#add-all-alacarte-data").on('click',function(){

$(".alacart_component_name:checked").each(function(){
	alacarte_component.push({component_id : $(this).val(),alacarte_id:$(this).data('component_alacart_id') ,component_name:$(this).data('alacart_component_name'),form_threshold:$(this).data('form_threshold'),component_standard_price:$(this).data('component_standard_price') });

})
$("#view-alacarte-component").modal('show');
sessionStorage.setItem("alacarte_component", JSON.stringify(alacarte_component));
})

$("#client-save-package-component-btn").on('click',function(){
	$("#package-alacarte-error-msg").html('').fadeIn();
	var alacarte_component = [];
		var alacarte = [];
	$(".alacarte_component_id").each(function(){
		alacarte_component.push($(this).val());
	alacarte.push({component_id:$(this).val(),component_name:$(this).data('component_name')});
	});

	$("#client-save-package-component-btn").html('<div class="spinner-border spinner-border-sm text-success" role="status"><span class="sr-only">Loading...</span></div> Submitting..');
	$("#client-save-package-component-btn").prop('disabled',true);

	var package_id =[];
	var package_name =[];
	$(".main_package_id").each(function(){
		package_id.push($(this).val());
		package_name.push($(this).data('package_name'));
	});

	if ( alacarte_component.length == 0 && package_id.length == 0 ) {
		$("#client-save-package-component-btn").html('Save & Next');
	$("#client-save-package-component-btn").prop('disabled',false);

		$("#package-alacarte-error-msg").html("<span class='text-danger error-msg-small text-center'> Please add package / alacarte components</span>").fadeOut(10000);
		return false;
	}
	sessionStorage.setItem("alacarte", JSON.stringify(alacarte));
	sessionStorage.setItem("alacarte_component",alacarte_component)
	sessionStorage.setItem("package_id",package_id)
	sessionStorage.setItem("package_name",package_name)
	window.location.href = base_url+'factsuite-admin/add-client-component-packages';
});

get_packages()
function get_packages(){
	var package_id = '';
var package_name = '';
	if (sessionStorage.getItem("package_name")) {
		 package_id = sessionStorage.getItem("package_id").split(',');
	 package_name = sessionStorage.getItem("package_name").split(',');
	}
	
	// alert(package_id.length)
	// alert(sessionStorage.getItem("package_component"))
	var html ='';
		html +='<option value=""> Select Package </option>';
	if (package_id.length > 0) {

	for (var i = 0; i < package_id.length; i++) {
		
          	html +='<option data-package_id="'+package_id[i]+'" value="'+package_id[i]+'">'+package_name[i]+'</option>';

	}
	}
$("#component-package").html(html)
}

$("#component-package").on('change',function(){
	var package_id = $(this).val();

	var component = JSON.parse(sessionStorage.getItem("package_component"))
	// alert(component.length)

	$.ajax({
          type: "POST",
          url: base_url+"package/get_package_component/",
          data:{package_id:package_id},
          dataType: 'json', 
          success: function(data) {
          	var html = '<option value=""> Select Component </option>',
          		component_list = data.component_list;
          	if (data.pack.length > 0) {
          		for (var i = 0; i < data.pack.length; i++) {
          			var show_component_name = '';
          			var com = $('#customradio'+package_id+'_'+data.pack[i]['component_id']+':checked').val();
          			for (var j = 0; j < component_list.length; j++) {
          				if(component_list[j].component_id == data.pack[i]['component_id']) {
          					show_component_name = component_list[j].fs_crm_component_name;
          					break;
          				}
          			}
          			var disable = '';
          			if (com != null && com != '') {
          				disable = 'disabled';
          			}
          			html +='<option '+disable+' data-package_name="'+package_id+'" value="'+data.pack[i].component_id+'">'+show_component_name+'</option>';
  				}
          	}
          	$("#component-details").html(html);
        }
 	});
});





/* for the package component  */

$("#component-details").on('change',function(){


var package_id = $("#component-package").val();
var component_id = $(this).val();

if (component_id =='') {
return false;
}
// $(this).attr('disabled',true);
$("#component-details option[value='"+component_id+"']").attr("disabled",true);
$.ajax({
          type: "POST",
          url: base_url+"package/get_single_component/",
          data:{component_id:component_id},
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
					html +='<label class="custom-control-label" for="customCheck'+package_id+'_'+data.pack['component_id']+'">'+data.pack['fs_crm_component_name']+'</label>';
					html +='</div>';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<label>Component Standard Price</label>';
					html +='<input type="hidden" class="form-control fld2 component_package_id"  value="'+package_id+'" id="component_package_ids'+package_id+'_'+data.pack['component_id']+'">';
					html +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data.pack.component_standard_price+'" id="component_standard_price'+package_id+'_'+data.pack['component_id']+'">';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<label>Client Standard Price</label>'
					html +='<input type="text" class="form-control fld2 component_price" disabled id="component_price'+package_id+'_'+data.pack['component_id']+'" oninput="oninput_float(\''+package_id+'_'+data.pack['component_id']+'\')" onkeypress="return oninput_fun(event)" onkeyup="component_price(\''+package_id+'_'+data.pack['component_id']+'\')">';
					html +='</div>';
					if (data.pack['component_id'] == 3) {
					html +=doc;
					}else if(data.pack['component_id'] == 4){
					html +=drug;
					}else if(data.pack['component_id'] == 7){
					html +=edu;
					}else if (!jQuery.inArray(data.pack['component_id'], [3,4,7]) !== -1) {
					if (data.pack['form_threshold'] > 0) {
						for (var k = 1; k <= data.pack['form_threshold']; k++) {
							var disable = 'disabled';
	          			if (k == 1) {
	          				disable = '';
	          			}	 
						html +='<div class="col-md-2 mt-1">'; 
	          			html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						html +='<input type="checkbox" '+disable+' onchange="get_form_input_value_check('+package_id+','+data.pack['component_id']+','+k+')" class="custom-control-input input_'+package_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+package_id+'" name="form'+k+'" value="'+k+'" id="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+k+'">';
						html +='<label class="custom-control-label" for="customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+k+'">'+data.pack['fs_crm_component_name']+' '+k+'</label><input type="hidden" class="form-control fld form" value="'+k+'" id="form_threshold'+k+'" >';
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
function get_form_input_value_check(package,component,index){
var sum1 = parseInt(index);
	var sum = sum1+1;
	// alert(sum)
	var price_val = $("#customradio_"+package+"_"+component+":checked").val();
	var form_value = $('#text_form_'+package+'_'+component+'_'+index).val(); 
	var checkbox = $('#customradiopackeducheckform_'+package+'_'+component+'_'+index+':checked').val();
if(checkbox !='' && checkbox !=null){ 
	if (price_val == 1) { 
		  $('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('disabled',false);
		   $('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',false); 
		}else{
	 $('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',false); 
	}
}else{ 
	$('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',true);
	$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',true);
	// $('#text_form_'+package+'_'+component+'_'+sum1).val('');
	$('#text_form_'+package+'_'+component+'_'+sum).val('');
}

}

function get_form_input_value(package,component,index){
	
	var sum1 = parseInt(index);
	var sum = sum1+1;
	// alert(sum)
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
	}else{ 
		var radio = $('input[name="component_price_type'+package+'_'+component+'"]:checked').val();
		if (radio !='1') { 
			$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',true);
			$('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('disabled',true);
			// $('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('checked',false);
		}else{
			$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',false);
			$('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('disabled',false);
			// $('#customradiopackeducheckform_'+package+'_'+component+'_'+sum).prop('checked',true);
		}
	}
}else{
	$('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',true);
	$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',true);
}
var total = 0;
$('.text_form_'+package+'_'+component).each(function(){
	if ($(this).val() !='' && $(this).val() !=null) { 
		  total += parseFloat($(this).val())
	}else{
		total += 0	
	}
});




$('#component_price'+package+'_'+component).val(total);
	// customradiopackeducheckform_'+package_id+'_'+data.pack['component_id']+'_'+k+'
}


/* set form value type */
function set_form_value(component_id,status){
var package_id = $("#component-package").val();
if (status == '0') {
	$("#component_price"+component_id).attr('disabled',true);
	$('.text_form_'+component_id).show();
}else{
	$('.text_form_'+component_id).hide();
	$("#component_price"+component_id).attr('disabled',false);
}
}

function set_alacarte_form_value(component_id,status){
var package_id = 1;
if (status == '0') {
	$('.text_form_'+component_id).show();
	$("#component_price"+component_id).attr('disabled',true);
}else{
	$('.text_form_'+component_id).hide();
	$("#component_price"+component_id).attr('disabled',false);
}
}
// alacarte
$('#client-save-packages-component-btn').on('click',function(){

	$("#client-save-packages-component-btn").html('<div class="spinner-border spinner-border-sm text-success" role="status"><span class="sr-only">Loading...</span></div> Submitting..');
	$("#client-save-packages-component-btn").prop('disabled',true);
	package_components = [];
$("#package-component-error").html('').fadeIn();
	$("#package-component-error").html('').fadeIn();
	$(".component_names").each(function(){
		var component_id = $(this).val()
		var package_id = $(this).data('package_id')
		var component_name = $(this).data('component_name')

			var MyID = $(this).attr("id"); 
  			 var number = MyID.match(/\d+/); 


		var component_package_ids = $("#component_package_ids"+number).val();
		var component_standard_price = $("#component_standard_price"+package_id+'_'+component_id).val();
		var component_price = $("#component_price"+package_id+'_'+component_id).val();
		$('#component-error-'+package_id+'_'+component_id).html('').fadeIn();
		var checkbox = $('input[name="component_price_type'+package_id+'_'+component_id+'"]:checked').val();
		if ( component_price =='' || component_price ==null ) {

			$('#component-error-'+package_id+'_'+component_id).html('<span class="text-danger text-center error-msg-small">Please enter component client price.</span>').fadeOut(5000);
			$("#client-save-packages-component-btn").html('Save & Next');
				$("#client-save-packages-component-btn").prop('disabled',false);
			return false;
			
		}
		var form_data = []; 
		$(".input_"+package_id+"_form_"+component_id+":checked").each(function(){
			var form_id = $(this).val();
			var form_value = $("#text_form_"+package_id+"_"+component_id+"_"+form_id).val();
			var form_values ='';
			if (form_value !='') { 
				form_values = form_value;
			}else{
				if (checkbox != 1) {  
					$("#client-save-packages-component-btn").html('Save & Next');
				$("#client-save-packages-component-btn").prop('disabled',false);
				$('#component-error-'+package_id+'_'+component_id).html('<span class="text-danger text-center error-msg-small">Please enter form value.</span>').fadeOut(5000);
				return false;
				}
			}
			form_data.push({form_id:form_id,form_value:form_values});
		});
		package_components.push({type_of_price:checkbox,component_id:component_id,component_name:component_name,package_id:package_id,component_standard_price:component_standard_price,component_price:component_price,form_data:form_data})
	})

		

	// alert(JSON.stringify(package_components))
		
		// var component_package_id = sessionStorage.getItem("package_id");
	if (sessionStorage.getItem("package_id")) {
		$.ajax({
	          type: "POST",
	          url: base_url+"package/get_package_component_count/",
	          data:{package_id:sessionStorage.getItem("package_id")},
	          dataType: 'json', 
	          success: function(data) {
	          	 
	          	 if (data.length == package_components.length) {

	          	 sessionStorage.setItem("package_components",JSON.stringify(package_components));
	          	 window.location.href = base_url+'factsuite-admin/add-client-alacarte-component';
	          	 }else{
	          	 	$("#package-component-error").html('<span class="text-danger error-msg-small">Please fill the all package components. try again.</span>').fadeOut(5000);
	          	 }
	          }
	 	 });
	}

	
});

/*
$("#component-alacarte").on('change',function(){
	var alacarte_id = $(this).val();

		$.ajax({
          type: "POST",
          url: base_url+"package/get_alacarte_component/",
          data:{alacarte_id:alacarte_id},
          dataType: 'json', 
          success: function(data) {
          	var html='';
          	html +='<option value=""> Select Component </option>';
          	if (data.pack.length > 0) {
          		for (var i = 0; i < data.pack.length; i++) {
          		 
          	html +='<option data-alacarte_id="'+alacarte_id+'" value="'+data.pack[i].component_id+'">'+data.pack[i].component_name+'</option>';

  			}

          	}
          	$("#alacarte-component-details").html(html);
          }
 	 });

});*/
alacarte_components()
function alacarte_components(){
	var alacarte_component =[]; 
	if (sessionStorage.getItem("alacarte")) {

	alacarte_component = JSON.parse(sessionStorage.getItem("alacarte")) 
	}

	var html='';
          	html +='<option value=""> Select Component </option>';

	if (alacarte_component.length > 0) {
          		for (var i = 0; i < alacarte_component.length; i++) {
          		 
          	html +='<option value="'+alacarte_component[i].component_id+'">'+alacarte_component[i].component_name+'</option>';

  			}
}
$("#alacarte-component-details").html(html);
}


$("#alacarte-component-details").on('change',function(){
	var component_id = $(this).val();
$("#alacarte-component-details option[value='"+component_id+"']").attr("disabled",true);
	var alacarte_id = 1;
	var package_id = 1;
	$.ajax({
          type: "POST",
          url: base_url+"package/get_single_component/",
          data:{component_id:component_id},
          dataType: 'json', 
          success: function(data) {
          		var html='';
          	// if (data.pack.length > 0) {
          		// $('#tmp-alacarte').val(alacarte);
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
						edu +='<input type="checkbox" '+disable+' class="custom-control-input input_'+alacarte_id+'_form_'+data.pack['component_id']+'" data-package_id="'+alacarte_id+'" name="education_type_name'+data.edu[i]['education_type_id']+'" value="'+data.edu[i]['education_type_id']+'" id="customradiopackeducheck_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'">';
						edu +='<label class="custom-control-label" for="customradiopackeducheck_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'">'+data.edu[i]['education_type_name']+'</label><input type="hidden" class="form-control fld education_type_id" value="'+data.edu[i]['education_type_id']+'" id="education_type_id'+i+'" >';
						edu +='</div>';
	          			edu +='</div>';
	          			edu +='<div class="col-md-2 mt-1">';
						edu +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+' onkeyup="get_alacarte_form_input_value('+alacarte_id+','+data.pack['component_id']+','+data.edu[i]['education_type_id']+')" class="form-control fld2 text_form_'+alacarte_id+'_'+data.pack['component_id']+'" id="text_form_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.edu[i]['education_type_id']+'" >';
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
						drug +='<input type="checkbox" '+disable+' class="custom-control-input input_'+alacarte_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+alacarte_id+'" name="drug_test_type_name'+data.drug[i]['drug_test_type_id']+'" value="'+data.drug[i]['drug_test_type_id']+'" id="customradiopackeducheck_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'">';
						drug +='<label class="custom-control-label" for="customradiopackeducheck_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'">'+data.drug[i]['drug_test_type_name']+'</label><input type="hidden" class="form-control fld drug_test_type_id" value="'+data.drug[i]['drug_test_type_id']+'" id="drug_test_type_id'+i+'" >';
						drug +='</div>';
	          			drug +='</div>';
	          			drug +='<div class="col-md-2 mt-1">';
						drug +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+' onkeyup="get_alacarte_form_input_value('+alacarte_id+','+data.pack['component_id']+','+data.drug[i]['drug_test_type_id']+')" class="form-control fld2 text_form_'+alacarte_id+'_'+data.pack['component_id']+'" id="text_form_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.drug[i]['drug_test_type_id']+'" >';
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
						doc +='<input type="checkbox" '+disable+' class="custom-control-input input_'+alacarte_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+alacarte_id+'" name="document_type_name'+data.doc[i]['document_type_id']+'" value="'+data.doc[i]['document_type_id']+'" id="customradiopackeducheck_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'">';
						doc +='<label class="custom-control-label" for="customradiopackeducheck_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'">'+data.doc[i]['document_type_name']+'</label><input type="hidden" class="form-control fld document_type_id" value="'+data.doc[i]['document_type_id']+'" id="document_type_id'+i+'" >';
						doc +='</div>';
	          			doc +='</div>';
	          			doc +='<div class="col-md-2 mt-1">';
						doc +='<input type="text" '+disable+' onkeyup="get_alacarte_form_input_value('+alacarte_id+','+data.pack['component_id']+','+data.doc[i]['document_type_id']+')" class="form-control fld2 text_form_'+alacarte_id+'_'+data.pack['component_id']+'" id="text_form_'+alacarte_id+'_'+data.pack['component_id']+'_'+data.doc[i]['document_type_id']+'" >';
						doc +='</div>'; 
	          		}
          		}
          		// for (var i = 0; i < data.pack.length; i++) { 
					html +='<div class="row ul'+alacarte_id+'">';

						html +='<div class="col-md-12" id="component-error-'+alacarte_id+'_'+data.pack['component_id']+'"></div>';

					html +='<div class="col-md-4 mt-1">';
					
					html +='<div class="custom-control custom-radio custom-control-inline mrg">';
					html +='<input type="radio" class="custom-control-input component_price_type" checked onchange="set_alacarte_form_value(\''+alacarte_id+'_'+data.pack['component_id']+'\',0)" name="component_price_type'+alacarte_id+'_'+data.pack['component_id']+'" value="0" id="customradio'+alacarte_id+'_'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customradio'+alacarte_id+'_'+data.pack['component_id']+'">Form Base Price</label>';
					html +='</div>';

          			html +='</div>';
          			html +='<div class="col-md-4 mt-1">'; 
					
					html +='<div class="custom-control custom-radio custom-control-inline mrg">';
					html +='<input type="radio" class="custom-control-input component_price_type" onchange="set_alacarte_form_value(\''+alacarte_id+'_'+data.pack['component_id']+'\',1)" name="component_price_type'+alacarte_id+'_'+data.pack['component_id']+'" value="1" id="customradio_'+alacarte_id+'_'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customradio_'+alacarte_id+'_'+data.pack['component_id']+'">Component Base Price</label>';
					html +='</div>';

          			html +='</div>';
          			html +='<div class="col-md-4 mt-1">';
					html +='';
					html +='</div>';


					html +='<div class="col-md-4 mt-1">';
					html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					html +='<input type="checkbox" disabled checked class="custom-control-input component_names" data-package_id="'+alacarte_id+'" name="customCheck" value="'+data.pack['component_id']+'" data-component_name="'+data.pack['component_name']+'" id="customCheck'+alacarte_id+'_'+data.pack['component_id']+'">';
					html +='<label class="custom-control-label" for="customCheck'+j+'">'+data.pack['component_name']+'</label>';
					html +='</div>';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<label>Component Standard Price</label>';
					html +='<input type="hidden" class="form-control fld2 component_package_ids"  value="'+alacarte_id+'" id="component_package_ids'+alacarte_id+'_'+data.pack['component_id']+'">';
					html +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data.pack.component_standard_price+'" id="component_standard_price'+alacarte_id+'_'+data.pack['component_id']+'">';
					html +='</div>';
					html +='<div class="col-md-4 mt-1">';
					html +='<label>Client Standard Price</label>'
					html +='<input type="text" class="form-control fld2 component_price" disabled id="component_price'+alacarte_id+'_'+data.pack['component_id']+'" oninput="oninput_float(\''+alacarte_id+'_'+data.pack['component_id']+'\')" onkeypress="return oninput_fun(event)" onkeyup="component_price(\''+alacarte_id+'_'+data.pack['component_id']+'\')">';
					html +='</div>';
					if (data.pack['component_id'] == 3) {
					html +=doc;
					}else if(data.pack['component_id'] == 4){
					html +=drug;
					}else if(data.pack['component_id'] == 7){
					html +=edu;
					}else if (!jQuery.inArray(data.pack['component_id'], [3,4,7]) !== -1) {
					if (data.pack['form_threshold'] > 0) {
						for (var k = 1; k <= data.pack['form_threshold']; k++) {
							var disable = 'disabled';
	          			if (k == 1) {
	          				disable = '';
	          			}	 
						html +='<div class="col-md-2 mt-1">'; 
	          			html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
						html +='<input type="checkbox" '+disable+' onchange="get_alacarte_form_input_value_check('+alacarte_id+','+data.pack['component_id']+','+k+')" class="custom-control-input input_'+alacarte_id+'_form_'+data.pack['component_id']+'"  data-package_id="'+alacarte_id+'" name="form'+k+'" value="'+k+'" id="customradiopackeducheck_'+alacarte_id+'_'+data.pack['component_id']+'_'+k+'">';
						html +='<label class="custom-control-label" for="customradiopackeducheck_'+alacarte_id+'_'+data.pack['component_id']+'_'+k+'">Form '+k+'</label><input type="hidden" class="form-control fld form" value="'+k+'" id="form_threshold'+k+'" >';
						html +='</div>';
	          			html +='</div>';
	          			html +='<div class="col-md-2 mt-1">';
						html +='<input type="number"  min="0" oninput="this.value = Math.abs(this.value)" '+disable+' onkeyup="get_alacarte_form_input_value('+alacarte_id+','+data.pack['component_id']+','+k+')" class="form-control fld2 text_form_'+alacarte_id+'_'+data.pack['component_id']+'" id="text_form_'+alacarte_id+'_'+data.pack['component_id']+'_'+k+'" >';
						html +='</div>'; 

							}
						}
					}
					html +='</div>';
					html +='<hr>';
					j++;
          		// }
          	// }
          	$("#display-alacarte-component-details").prepend(html);
          }
     	});
});


function get_alacarte_form_input_value_check(package,component,index){
var sum1 = parseInt(index);
	var sum = sum1+1;
	// alert(sum)
	var price_val = $("#customradio_"+package+"_"+component+":checked").val();
	var form_value = $('#text_form_'+package+'_'+component+'_'+index).val(); 
	var checkbox = $('#customradiopackeducheck_'+package+'_'+component+'_'+index+':checked').val();
if(checkbox !='' && checkbox !=null){ 
	 $('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',false); 

	 if (price_val == 1) {  
		  $('#customradiopackeducheck_'+package+'_'+component+'_'+sum).prop('disabled',false);
		   $('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',false); 
		}else{
	 $('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',false); 
	}
}else{
	$('#text_form_'+package+'_'+component+'_'+sum1).prop('disabled',true);
	$('#text_form_'+package+'_'+component+'_'+sum).prop('disabled',true);
	$('#text_form_'+package+'_'+component+'_'+sum1).val('');
	$('#text_form_'+package+'_'+component+'_'+sum).val('');
}

}


function get_alacarte_form_input_value(alacarte,component,index){
	var sum1 = parseInt(index);
	var sum = sum1+1;
	var form_value = $('#text_form_'+alacarte+'_'+component+'_'+index).val();

	if (form_value !='' && form_value > 0 ) {  
		 $('#customradiopackeducheck_'+alacarte+'_'+component+'_'+index).prop('checked',true);
	}
	var checkbox = $('#customradiopackeducheck_'+alacarte+'_'+component+'_'+index+':checked').val();
	if(checkbox !='' && checkbox !=null){
		if (form_value !='' && form_value > 0 ) { 
			$('#text_form_'+alacarte+'_'+component+'_'+sum).attr('disabled',false);
			$('#customradiopackeducheck_'+alacarte+'_'+component+'_'+sum).attr('disabled',false);
			// $('#customradiopackeducheck_'+alacarte+'_'+component+'_'+sum).prop('checked',true);
		}else{
			// $('#text_form_'+alacarte+'_'+component+'_'+sum).attr('disabled',true);
			// $('#customradiopackeducheck_'+alacarte+'_'+component+'_'+sum).attr('disabled',true);

		var radio = $('input[name="component_price_type'+alacarte+'_'+component+'"]:checked').val();
		if (radio !='1') { 
			$('#text_form_'+alacarte+'_'+component+'_'+sum).prop('disabled',true);
			$('#customradiopackeducheck_'+alacarte+'_'+component+'_'+sum).prop('disabled',true);
			$('#customradiopackeducheck_'+alacarte+'_'+component+'_'+sum).prop('checked',false);
		}else{
			$('#text_form_'+alacarte+'_'+component+'_'+sum).prop('disabled',false);
			$('#customradiopackeducheck_'+alacarte+'_'+component+'_'+sum).prop('disabled',false);
			$('#customradiopackeducheck_'+alacarte+'_'+component+'_'+sum).prop('checked',true);
		}
	
		}
	}else{
		$('#text_form_'+alacarte+'_'+component+'_'+sum1).prop('disabled',true);
	$('#text_form_'+alacarte+'_'+component+'_'+sum).prop('disabled',true);
	$('#text_form_'+alacarte+'_'+component+'_'+sum1).val('');
	$('#text_form_'+alacarte+'_'+component+'_'+sum).val('');
	}
	var total = 0;
	$('.text_form_'+alacarte+'_'+component).each(function(){
		if ($(this).val() !='' && $(this).val() !=null) { 
			  total += parseFloat($(this).val())
		}else{
			total += 0	
		}
	});

	$('#component_price'+alacarte+'_'+component).val(total);
}

$("#client-save-alacarte-component-btn").on('click',function(){
	
	alacarte_component = [];
	$("#package-component-error").html('').fadeIn();
	var flag = 0;
	$(".component_names").each(function(){
		var component_id = $(this).val()
		var alacarte_id = $(this).data('package_id')
		var component_name = $(this).data('component_name');
		$('#component-error-'+alacarte_id+'_'+component_id).html('').fadeIn();

			var MyID = $(this).attr("id"); 
  			var number = MyID.match(/\d+/); 
		var component_package_ids = $('#component_package_ids'+alacarte_id+'_'+component_id).val();
		var component_standard_price = $('#component_standard_price'+alacarte_id+'_'+component_id).val();
		var component_price = $('#component_price'+alacarte_id+'_'+component_id).val();

		var checkbox = $('input[name="component_price_type'+alacarte_id+'_'+component_id+'"]:checked').val();
		if ( component_price =='' || component_price ==null ) {
			$("#client-save-alacarte-component-btn").html('Save & Next');
			$("#client-save-alacarte-component-btn").prop('disabled',false);
			$('#component-error-'+alacarte_id+'_'+component_id).html('<span class="text-danger text-center error-msg-small">Please enter component client price.</span>').fadeOut(5000);
			// return false;
			flag = 1;
		}
		var form_data = []; 
		$(".input_"+alacarte_id+"_form_"+component_id+":checked").each(function(){
			 $('#component-error-'+alacarte_id+'_'+component_id).html('').fadeIn();
			var form_id = $(this).val();
			var form_value = $("#text_form_"+alacarte_id+"_"+component_id+"_"+form_id).val()
			var form_values = '';
			if (form_value !='' && form_value !=null) { 
				form_values = form_value;
			}else{
				if (checkbox !=1) {

				$('#component-error-'+alacarte_id+'_'+component_id).html('<span class="text-danger error-msg-small">Please enter form value.</span>');

				flag = 1;
				}
				// return false;
			}
			form_data.push({form_id:form_id,form_value:form_values});

		});
		alacarte_component.push({type_of_price:checkbox,component_id:component_id,component_name:component_name,alacarte_id:alacarte_id,component_standard_price:component_standard_price,component_price:component_price,form_data:form_data})
	})

	if (flag == 1) { 
		return false;
	}
 




	var client_name = sessionStorage.getItem("client_name");
	var client_address = sessionStorage.getItem("client_address");
	var client_city = sessionStorage.getItem("client_city");
	var client_state = sessionStorage.getItem("client_state");
	var client_industry = sessionStorage.getItem("client_industry");
	var other_industry = sessionStorage.getItem("other_industry");
	var client_website = sessionStorage.getItem("client_website");
	var master_account = sessionStorage.getItem("master_account");
	var account_manager = sessionStorage.getItem("account_manager");
	var manager_email = sessionStorage.getItem("manager_email");
	var manager_contact = sessionStorage.getItem("manager_contact");
	var package = sessionStorage.getItem("package_id");
	var spo_name = sessionStorage.getItem("spo_name");
	var spo_email = sessionStorage.getItem("spo_email");
	var spo_contact = sessionStorage.getItem("spo_contact");
	var communications = sessionStorage.getItem("communications");
	var zip = sessionStorage.getItem("zip");
	var is_master = sessionStorage.getItem("is_master");
	var client_docs = sessionStorage.getItem("client_docs");
	var package_components = JSON.parse(sessionStorage.getItem("package_components"))
	var country = sessionStorage.getItem("country")

	var alacart = JSON.parse(sessionStorage.getItem("alacarte"));  



	if(alacart.length != alacarte_component.length ){ 
		$("#package-component-error").html('<span class="text-danger error-msg-small">Please Fill the valid all form values</span>');
		return false;
	}else if( package_components.length == 0){ 
		$("#package-component-error").html('<span class="text-danger error-msg-small">Please Fill the valid all form values</span>');
		return false;
	}

	$("#client-save-alacarte-component-btn").html('<div class="spinner-border spinner-border-sm text-success" role="status"><span class="sr-only">Loading...</span></div> Submitting..');
	$("#client-save-alacarte-component-btn").prop('disabled',true);

	sessionStorage.setItem("alacarte_component",JSON.stringify(alacarte_component));

	window.location.href = base_url+"factsuite-admin/add-client-tat-component";
 	
	// var formdata = new FormData();

	/*formdata.append('client_name',client_name);
	formdata.append('client_address',client_address);
	formdata.append('client_city',client_city);
	formdata.append('client_state',client_state);
	formdata.append('client_industry',client_industry);
	formdata.append('other_industry',other_industry);
	formdata.append('client_website',client_website);
	formdata.append('master_account',master_account);
	formdata.append('account_manager',account_manager);
	formdata.append('manager_email',manager_email);

	formdata.append('manager_contact',manager_contact);
	formdata.append('package',package);
	formdata.append('spo_name',spo_name);
	formdata.append('spo_email',spo_email);
	formdata.append('spo_contact',spo_contact);
	formdata.append('communications',communications);
	formdata.append('zip',zip);
	if (is_master !=null && is_master =='1') {
		formdata.append('is_master',is_master);
	}
	formdata.append('package_components',JSON.stringify(package_components));
	formdata.append('alacarte_components',JSON.stringify(alacarte_component)); 


	formdata.append('country',country);

	 
			formdata.append('client_docs', client_docs);

			$("#package-component-error").html('<span class="text-warning error-msg-small">Please wait while we are updating the data.</span>');
	 

	 $.ajax({
            type: "POST",
              url: base_url+"client/insert_client/",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
                if (data.status == '1') {  
                	toastr.success('New add client has been successfully.');
                		$("#package-component-error").html('<span class="text-success error-msg-small">New client has been successfully Added.</span>'); 

                	sessionStorage.clear(); 
                	window.location.href = base_url+'factsuite-admin/add-new-client';
                }else{ 
                	$("#package-component-error").html("");
                	toastr.error('Something went wrong while add client. Please try again.'); 
                }  
              }
          }); */

})