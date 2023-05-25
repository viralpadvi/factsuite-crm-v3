// 
// Created Date 1-02-2021
// 
$('#document_uploded_by_inputqc').hide()
$('#document_uploaded_by').on('change',function(){
	if($(this).val() == 'inputqc'){
		$('#document_uploded_by_inputqc').show()	
	}else{
		$('#document_uploded_by_inputqc').hide()
	}
	
});

$('#client_id').on('change',function(){
	clientIdChecke()
	getPackage($(this).val())
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
      		$(this).val(phone_number.slice(0,-1));
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

	    }
		 
	}
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
	if($('#date_of_birth').val() == ''){
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
	if($('#package_id').val() == ''){
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

// function getPkgdatas(id){
// 	$.ajax({
// 		type: "POST",
// 	  	url: base_url+"inputQc/getPackageDetail/", 
// 	  	data:{
// 	  		id:id
// 	  	},
// 	  	dataType: "json",
// 	  	success: function(data){ 
// 			// console.log(JSON.stringify(data[0]['component_name']))
// 			let comp='';
				
// 			$('#package_id').val(data[0].package_id)
// 			$('#package_name').val(data[0].package_name)

// 			for (var i=0; i< data[0]['component_name'].length;i++) { 

// 	      		comp +='<div class="col-md-4">'
// 				    comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
// 					    comp +='<input checked type="checkbox" class="custom-control-input components" value="'+data[0]['component_ids'][i]+'" name="componentCheck" id="componentCheck'+data[0]['component_ids'][i]+'" onclick="GetSelected()">'
// 					    comp +='<label class="custom-control-label" for="editcomponentCheck'+data[0]['component_ids'][i]+'">'+data[0]['component_name'][i]
// 					    comp +='</label>'
// 				    comp +=' </div>'
// 		      	comp +=' </div>'
// 			}
// 			$('#components_ids').html(comp)
// 	  	}
// 	});
// }

function getPkgdata(id=''){ 
	
	if(id != ''){
	  $.ajax({
	    type: "POST",
	    url: base_url+"package/get_single_component_name/"+id, 
	    dataType: "json",
	    async:false,
	    success: function(data){ 
	      var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
	      $('#edit_package_id').val(id);

	      let comp='';
	       
	      for (var i = 0; i < data['components'].length; i++) {

	      		
	      		var arr ='';
				if (data['package_data'][0].component_ids !='') {
					arr = data['package_data'][0].component_ids.split(',');
				}
	      		if (jQuery.inArray(data['components'][i].component_id, arr)!='-1') {  
						 
					comp +='<div class="col-md-4">'
			      		comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
				      		comp +='<input checked type="checkbox" class="custom-control-input components" value="'+data['components'][i].component_id+'" name="componentCheck" id="editcomponentCheck'+data['components'][i].component_id+'" onclick="GetSelected()">'
				      		comp +='<label class="custom-control-label" for="editcomponentCheck'+data['components'][i].component_id+'">'+data['components'][i].component_name
				      		comp +='</label>'
			      		comp +=' </div>'
	      			comp +=' </div>'

				}else{

					comp +='<div class="col-md-4">'
			      		comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
				      		comp +='<input type="checkbox" class="custom-control-input components" value="'+data['components'][i].component_id+'" name="componentCheck" id="editcomponentCheck'+data['components'][i].component_id+'" onclick="GetSelected()">'
				      		comp +='<label class="custom-control-label" for="editcomponentCheck'+data['components'][i].component_id+'">'+data['components'][i].component_name
				      		comp +='</label>'
			      		comp +=' </div>'
	      			comp +=' </div>'

				} 
	      		 
	      		
	      		 
	      }
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
function save_case(){
	// btn_disabled('#insert_data')
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
	var component_id = GetSelected();
 
	var formdata = new FormData();
	formdata.append('client_id', client_id);
	formdata.append('title', title);
	formdata.append('first_name',first_name );
	formdata.append('last_name', last_name);
	formdata.append('father_name', father_name);
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
	formdata.append('component_id', component_id);
	 
	var mobielNumberUniq = checkMobileNumerExits('inputQc/checkMobileNumber',phone_number);
	if(mobielNumberUniq){
		input_is_invalid('#phone_number')
 		$('#contact-no-error').html('<span class="text-danger error-msg-small">This mobile number is already registered.</span>');
	
 	}else{
 		// alert('else')
	 	if(client_id != '0' && title != '' && first_name != '' && father_name != '' && 
			phone_number != '' && phone_number.length == 10 && email_id != '' && package_id != '' 
			&& remarks != '' && document_uploaded_by != '' ){

			if(document_uploaded_by.toLowerCase() == 'inputqc'){
				if(document_uploaded_by_email_id != '' && regex.test(document_uploaded_by_email_id)){
					//insert
					$.ajax({
						type: "POST",
					  	url: base_url+"inputQc/insertCase",
					  	data: formdata,
					  	dataType: "json",
					  	contentType: false,
			    		processData: false,
					  	success: function(data) {
					  		if (data.status == '1') {
						  		let html = "<span class='text-success'>Success data inserted</span>";
								$('#error-team').html(html);
								toastr.success('New data has been insert successfully.');
								$('.is-valid').removeClass('is-valid');
								$('.is-invalid').removeClass('is-invalid');
								 
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
								  
								$('#vendor-name, #vendor-address-line-1, #vendor-address-line-2, #vendor-city, #vendor-zip-code, #vendor-state, #vendor-website, #vendor-monthly-quota, #vendor-aggrement-start-date, #vendor-aggrement-end-date, #vendor-tat, #vendor-manager-name, #vendor-manager-email-id, #vendor-manager-mobile-number, #vendor-spoc-name, #vendor-spoc-email-id, #vendor-spoc-mobile-number').val('');
								$('#vendor-name, #vendor-address-line-1, #vendor-address-line-2, #vendor-city, #vendor-zip-code, #vendor-state, #vendor-website, #vendor-monthly-quota, #vendor-aggrement-start-date, #vendor-aggrement-end-date, #vendor-tat, #vendor-manager-name, #vendor-manager-email-id, #vendor-manager-mobile-number, #vendor-spoc-name, #vendor-spoc-email-id, #vendor-spoc-mobile-number').removeClass('is-valid is-invalid'); 
						  	} else {
						  		let html = "<span class='text-danger'>Somthing went wrong.</span>";
								$('#error-team').html(html);
								toastr.error('New data has been insert failed.');
					  		}
				  		},
					  	error: function(data) {
							toastr.error('OOPS! Something went wrong while adding the case. Please try again.');
							// btn_enabled('#insert_data');
						}
				  	});
					// alert("inputqc")

				}else{
					documentUploderEmailCheck()
				}
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
					  		if (data.status == '1') {
						  		let html = "<span class='text-success'>Success data inserted</span>";
								$('#error-team').html(html);
								toastr.success('New data has been insert successfully.');
								 
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
								  
								 
						  	} else {
						  		let html = "<span class='text-danger'>Somthing went wrong.</span>";
								$('#error-team').html(html);
								toastr.error('New data has been insert failed.');
					  		}
				  		},
					  	error: function(data) {
							toastr.error('OOPS! Something went wrong while adding the case. Please try again.');
							// btn_enabled('#insert_data');
						}
				  	});
			}
			  
		}else{
			toastr.error('OOPS! Something went wrong while adding the case. Please try again.');
							// btn_enabled('#insert_data');
		}
 	}
}
 