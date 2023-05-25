var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mobile_number_length = 10;
var url_regex = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
// var url_regex = regex = ((http|https):\/\/)?(www.)[a-zA-Z0-9@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&\/\/=]*);
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var candidate_aadhar =[];
var candidate_pan =[];
var candidate_proof =[];
var candidate_bank =[];

var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	alphabets_only = /^[A-Za-z ]+$/,
	vendor_name_length = 100,
	city_name_length = 100,
	vendor_zip_code_length = 6,
	vendor_monthly_quota_length = 5,
	vendor_docs = [],
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


	$("#addresses").change(function(){ 
		if ($(this).prop('checked')) { 
			var i = 0; 
				$("#permenent-house-flat").val(candidate_info['candidate_flat_no']);
				$("#permenent-street").val(candidate_info['candidate_street']);
				$("#permenent-area").val(candidate_info['candidate_area']);
				$("#permenent-pincode").val(candidate_info['candidate_pincode']); 

		 
		}else{
			var i = 0;
			$("#permenent-street").val('');
				$("#permenent-area").val('');
				$("#permenent-pincode").val(''); 
		} 
	});



$("#file1").on("change", handleFileSelect_candidate_aadhar);
$("#file2").on("change", handleFileSelect_candidate_pan);
$("#file3").on("change", handleFileSelect_candidate_proof); 

$("#duration-of-stay-from-month").on("change", function() {
	check_duration_of_stay_from_date();
});

$("#duration-of-stay-from-year").on("change", function() {
	check_duration_of_stay_from_date();
});

$("#duration-of-stay-end-month").on("change", function() {
	check_duration_of_stay_end_date();
});

$("#duration-of-stay-end-year").on("change", function() {
	check_duration_of_stay_end_date();
});

function check_duration_of_stay_from_date() {
	var duration_of_stay_from_month_var = duration_of_stay_from_month();
	var duration_of_stay_from_year_var = duration_of_stay_from_year();

	if (duration_of_stay_from_month_var == '1' && duration_of_stay_from_year_var == '1') {
		$('#duration-of-stay-from-date-error').html('');
		return 1;
	} else {
		$('#duration-of-stay-from-date-error').html('<span class="d-block text-danger error-msg-small">Plesae select a date and month</span>');
		return 0;
	}
}

function check_duration_of_stay_end_date() {
	var duration_of_stay_end_month_var = duration_of_stay_end_month();
	var duration_of_stay_end_year_var = duration_of_stay_end_year();

	if (duration_of_stay_end_month_var == '1' && duration_of_stay_end_year_var == '1') {
		$('#duration-of-stay-to-date-error').html('');
		return 1;
	} else {
		$('#duration-of-stay-to-date-error').html('<span class="d-block text-danger error-msg-small">Plesae select a date and month</span>');
		return 0;
	}
}

function duration_of_stay_from_month() {
	var variable_array = {};
	variable_array['input_id'] = '#duration-of-stay-from-month';
	variable_array['error_msg_div_id'] = '#duration-of-stay-from-month-error-msg-div';
	variable_array['empty_input_error_msg'] = '';
	return mandatory_select(variable_array);
}

function duration_of_stay_from_year() {
	var variable_array = {};
	variable_array['input_id'] = '#duration-of-stay-from-year';
	variable_array['error_msg_div_id'] = '#duration-of-stay-from-year-error-msg-div';
	variable_array['empty_input_error_msg'] = '';
	return mandatory_select(variable_array);
}

function duration_of_stay_end_month() {
	var variable_array = {};
	variable_array['input_id'] = '#duration-of-stay-end-month';
	variable_array['error_msg_div_id'] = '#duration-of-stay-to-month-error-msg-div';
	variable_array['empty_input_error_msg'] = '';
	return mandatory_select(variable_array);
}

function duration_of_stay_end_year() {
	var variable_array = {};
	variable_array['input_id'] = '#duration-of-stay-end-year';
	variable_array['error_msg_div_id'] = '#duration-of-stay-to-year-error-msg-div';
	variable_array['empty_input_error_msg'] = '';
	return mandatory_select(variable_array);
}

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
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_aadhar\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_aadhar.push(files[i]);
	                $(".file-name1").append(html);
	        	} 
	        }
	    } else {
	    	$("#file1-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file1').val('');
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
    	$("#file1").val('');
    }
    $('#file_candidate_aadhar_'+id).remove(); 
}


function handleFileSelect_candidate_pan(e){
	    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file2-error").html('');
        $(".file-name2").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name  
	             	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_pan_'+i+'"><span>'+fileName+' <a id="file_candidate_pan'+i+'" onclick="removeFile_candidate_pan('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image_pan('+i+',\'candidate_pan\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]);
	                candidate_pan.push(files[i]);
	                $(".file-name2").append(html);
	        	} 
	        }
	    } else {
	    	$("#file2-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file2').val('');
	    }
    } else {
        $("#file2-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}


function removeFile_candidate_pan(id) {

    var file = $('#file_candidate_pan'+id).data("file");
    for(var i = 0; i < candidate_pan.length; i++) {
        if(candidate_pan[i].name === file) {
            candidate_pan.splice(i,1); 
        }
    }
    if (candidate_pan.length == 0) {
    	$("#file2").val('');
    }
    $('#file_candidate_pan_'+id).remove(); 
}

function handleFileSelect_candidate_proof(e){
	    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file3-error").html('');
        $(".file-name3").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	        		 var fileName = files[i].name; // get file name  
	        	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	  html = '<div id="file_candidate_proof_'+i+'"><span>'+fileName+' <a id="file_candidate_proof'+i+'" onclick="removeFile_candidate_proof('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image_proof('+i+',\'candidate_proof\')" ><i class="fa fa-eye"></i></a></span></div>';
	                candidate_proof.push(files[i]);
	                $(".file-name3").append(html); 
	        	} 
	        }
	    } else {
	    	$("#file3-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file3').val('');
	    }
    } else {
        $("#file3-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_proof(id) {

    var file = $('#file_candidate_proof'+id).data("file");
    for(var i = 0; i < candidate_proof.length; i++) {
        if(candidate_proof[i].name === file) {
            candidate_proof.splice(i,1); 
        }
    }
    if (candidate_proof.length == 0) {
    	$("#file3").val('');
    }
    $('#file_candidate_proof_'+id).remove(); 
} 


function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_aadhar[id]);
}


function view_image_pan(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_pan[id]);
}

function view_image_proof(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader(); 
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_proof[id]);
} 
function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}

function mandatory_select(variable_array) {
	var input_value = $(variable_array.input_id).val();
	if (input_value != '') {
		$(variable_array.error_msg_div_id).html('');
		return 1;
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}

 $("#add_address").on('click',function(){

 /*	var house = $("#house-flat").val();
 	var street = $("#street").val();
 	var area = $("#area").val();
 	var city = $("#city").val();
 	var pincode = $("#pincode").val();
 	var land_mark = $("#land-mark").val();
 	var start_date = $("#start-date").val();
 	var end_date = $("#end-date").val();
 	var present = $("#customCheck1:checked").val();
 	var name = $("#permenent-name").val();
 	var relationship = $("#relationship").val();
 	var contact_no = $("#contact_no").val();
*/
	var permanent_address_id = $("#permanent_address_id").val();
 	var permenent_house = $("#permenent-house-flat").val();
 	var permenent_street = $("#permenent-street").val();
 	var permenent_area = $("#permenent-area").val();
 	var permenent_city = $("#permenent-city").val();
 	var permenent_pincode = $("#permenent-pincode").val();
 	var permenent_land_mark = $("#permenent-land-mark").val();
 	var permenent_start_date = $("#permenent-start-date").val();
 	var permenent_end_date = $("#permenent-end-date").val();
 	var permenent_present = $("#permenent-customCheck1:checked").val();
 	var permenent_name = $("#permenent-name").val();
 	var permenent_relationship = $("#relationship").val();
 	var permenent_contact_no = $("#permenent-contact_no").val();
 	var code = $("#code").val();
 	var state = $("#state").val();
 	var country = $("#country").val();

 	var rental_agreement = $("#rental_agreement").val(); 

 	var check_duration_of_stay_from_date_var = check_duration_of_stay_from_date(),
 		check_duration_of_stay_end_date_var = check_duration_of_stay_end_date();

	if (permenent_house !='' &&
	country !='' &&
	permenent_street !='' &&
	permenent_area !='' &&
	permenent_city !='' &&
	state !='' &&
	permenent_pincode !='' &&
	permenent_land_mark !='' &&
	permenent_start_date !='' &&
	permenent_end_date !='' && 
	permenent_name !='' &&
	permenent_relationship !='' &&
	permenent_contact_no !='' &&
	check_duration_of_stay_from_date_var == 1 && 
	check_duration_of_stay_end_date_var == 1 &&
	state !='' ) {
		 // && (candidate_aadhar.length > 0 ||(rental_agreement !='' && rental_agreement !=null))
 	// alert("Hello")
$("#add_address").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

 	var formdata = new FormData();
	/*	formdata.append('house',house);
		formdata.append('street',street);
		formdata.append('area',area);
		formdata.append('city',city);
		formdata.append('pincode',pincode);
		formdata.append('land_mark',land_mark);
		formdata.append('start_date',start_date);
		formdata.append('end_date',end_date);
		formdata.append('present',present);
		formdata.append('name',name);
		formdata.append('relationship',relationship);
		formdata.append('contact_no',contact_no);*/
		formdata.append('url',9);
		formdata.append('permenent_house',permenent_house);
		formdata.append('permenent_street',permenent_street);
		formdata.append('permenent_area',permenent_area);
		formdata.append('permenent_city',permenent_city);
		formdata.append('permenent_pincode',permenent_pincode);
		formdata.append('permenent_land_mark',permenent_land_mark);
		formdata.append('permenent_start_date',permenent_start_date);
		formdata.append('permenent_end_date',permenent_end_date);
		formdata.append('start_month',$('#duration-of-stay-from-month').val());
		formdata.append('start_year',$('#duration-of-stay-from-year').val());
		formdata.append('end_month',$('#duration-of-stay-end-month').val());
		formdata.append('end_year',$('#duration-of-stay-end-year').val());
		formdata.append('permenent_present',permenent_present);
		formdata.append('permenent_name',permenent_name);
		formdata.append('permenent_relationship',permenent_relationship);
		formdata.append('permenent_contact_no',permenent_contact_no);
		formdata.append('code',code);
		formdata.append('state',state);
		formdata.append('country',country);
		formdata.append('link_request_from',link_request_from);
		
		if (permanent_address_id !='' && permanent_address_id !=null) {
			formdata.append('permanent_address_id',permanent_address_id);
		}

		if (candidate_aadhar.length > 0) {
			for (var i = 0; i < candidate_aadhar.length; i++) { 
				formdata.append('candidate_rental[]',candidate_aadhar[i]);
			}
		}else{
			formdata.append('candidate_rental[]','');
		}
		if (candidate_pan.length > 0) {
			for (var i = 0; i < candidate_pan.length; i++) { 
				formdata.append('candidate_ration[]',candidate_pan[i]);
			}
		}else{ 
			formdata.append('candidate_ration[]','');
		}
		if (candidate_proof.length > 0) {
			for (var i = 0; i < candidate_proof.length; i++) { 
				formdata.append('candidate_gov[]',candidate_proof[i]);
			}
		}else{
			formdata.append('candidate_gov[]','');
		} 


	$.ajax({
            type: "POST",
              url: base_url+"candidate/update_candidate_address",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
				if (data.status == '1') {
					// toastr.success('successfully saved data.');  
					window.location.href=base_url+data.url;
              	}else{
              		toastr.error('Something went wrong while saving the data. Please try again.'); 	
              	}
              	$("#add_address").html("Save & Continue");
              }
            });
		}else{

			valid_street()
			valid_area()
			valid_address()
			valid_pincode()
			valid_city()
			valid_state()
			valid_house_flat()
			valid_land_mark()
			valid_start_date()
			valid_end_date()
			valid_name()
			valid_relationship()
			valid_contact_no()
			valid_countries('add-data');

			if (candidate_aadhar.length == 0 && rental_agreement =='') {
				$(".file-name1").html("<span class='text-danger error-msg-small'>Please select atleast one file</span>");
			}
		}
 });
 

	$("#permenent-street").on('keyup blur',valid_street); 
	$("#permenent-area").on('keyup blur',valid_area); 
	$("#permenent-address").on('keyup blur',valid_address); 
	$("#permenent-pincode").on('keyup blur',valid_pincode);
	$("#permenent-city").on('keyup blur change',valid_city);
	$("#state").on('keyup blur change',valid_state);
	$("#country").on('keyup blur change',valid_countries);
	$("#permenent-house-flat").on('keyup blur',valid_house_flat);
	$("#permenent-land-mark").on('keyup blur',valid_land_mark);
	$("#permenent-start-date").on('keyup blur change',valid_start_date);
	$("#permenent-end-date").on('keyup blur change',valid_end_date);
	$("#permenent-name").on('keyup blur',valid_name);
	$("#relationship").on('keyup blur change',valid_relationship);
	$("#permenent-contact_no").on('keyup blur',valid_contact_no); 


function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}





function valid_address(){
	var address = $("#permenent-address").val();
	if (address !='') {
		$("#permenent-address-error").html("");
		input_is_valid("#permenent-address")
	}else{
		input_is_invalid("#permenent-address")
		$("#permenent-address-error").html("<span class='text-danger error-msg-small'>Please Enter valid address</span>");
	}
}
function valid_pincode(){ 
	var pincode = $("#permenent-pincode").val();
	if (pincode !='') {
		if (isNaN(pincode)) {
			$("#permenent-pincode-error").html('<span class="text-danger error-msg-small">Pin code should be only numbers.</span>');
			$("#permenent-pincode").val(pincode.slice(0,-1));
			input_is_invalid("#permenent-pincode");
		} else if (pincode.length != 6) {
			$("#permenent-pincode-error").html('<span class="text-danger error-msg-small">Pin code should be of '+6+' digits.</span>');
			var plenght = $("#permenent-pincode").val(pincode.slice(0,6));
			input_is_invalid("#permenent-pincode");
			if (plenght.length == 6) {
			$("#permenent-pincode-error").html('');
			input_is_valid("#permenent-pincode");	
			}
		} else {
			$("#permenent-pincode-error").html('');
			input_is_valid("#permenent-pincode");
		} 
	}else{
		$("#permenent-pincode-error").html("<span class='text-danger error-msg-small'>Please enter valid pincode</span>");
		input_is_invalid("#permenent-pincode")
	}
}
function valid_city(){
 
	var city = $("#permenent-city").val();
	if (city != '') {
		/*if (!alphabets_only.test(city)) {
			$("#permenent-city-error").html('<span class="text-danger error-msg-small">City should be only alphabets.</span>');
			$("#permenent-city").val(city.slice(0,-1));
			input_is_invalid("#permenent-city");
		} else*/ if (city.length > vendor_name_length) {
			$("#permenent-city-error").html('<span class="text-danger error-msg-small">City should be of max '+vendor_name_length+' characters.</span>');
			$("#permenent-city").val(city.slice(0,vendor_name_length));
			input_is_invalid("#permenent-city");
		} else {
			$("#permenent-city-error").html('');
			input_is_valid("#permenent-city");
		}
	} else {
		$("#permenent-city-error").html('<span class="text-danger error-msg-small">Please add a city.</span>');
		input_is_invalid("#permenent-city");
	}	
}
/*function valid_state(){
	var state = $("#state").val();
	if (state !='') {
		$("#state-error").html("");
		input_is_valid("#state")
	}else{
		$("#state-error").html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
		input_is_invalid("#state")
	}
}*/


function valid_state(){
	var state = $("#state").val();
	if (state !='') {
		var c_id = $("#state").children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"candidate/get_selected_cities/"+c_id, 
              dataType: 'json', 
              success: function(data) {
              	var html = '';
              	html +="<option>Select City</option>";
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
					}
				}
				$("#permenent-city").html(html);
              }
            });
		$("#state-error").html("");
		input_is_valid("#state")
	}else{
		$("#state-error").html("<span class='text-danger error-msg-small'>Please select valid state</span>");
		input_is_invalid("#state")
	}
}

function valid_house_flat(){
	var house_flat = $("#permenent-house-flat").val();
	if (house_flat !='') {
		$("#permenent-house-flat-error").html("");
		input_is_valid("#permenent-house-flat")
	}else{
		$("#permenent-house-flat-error").html("<span class='text-danger error-msg-small'>Please enter valid house flat</span>");
		input_is_invalid("#permenent-house-flat")
	}
}
function valid_land_mark(){
	var land_mark = $("#permenent-land-mark").val();
	if (land_mark !='') {
		$("#permenent-land-mark-error").html("");
		input_is_valid("#permenent-land-mark")
	}else{
		$("#permenent-land-mark-error").html("<span class='text-danger error-msg-small'>Please enter valid land mark</span>");
		input_is_invalid("#permenent-land-mark")
	}
}

function valid_street(){
		var street = $("#permenent-street").val();
	if (street !='') {
		$("#permenent-street-error").html("");
		input_is_valid("#permenent-street")
	}else{
		$("#permenent-street-error").html("<span class='text-danger error-msg-small'>Please enter valid street</span>");
		input_is_invalid("#permenent-street")
	}
}
function valid_area(){
		var area = $("#permenent-area").val();
	if (area !='') {
		$("#permenent-area-error").html("");
		input_is_valid("#permenent-area")
	}else{
		$("#permenent-area-error").html("<span class='text-danger error-msg-small'>Please enter valid area</span>");
		input_is_invalid("#permenent-area")
	}
}
 
function valid_name(){
	 
	var first_name = $("#permenent-name").val();
	if (first_name != '') {
		if (!alphabets_only.test(first_name)) {
			$("#permenent-name-error").html('<span class="text-danger error-msg-small">Name should be only alphabets.</span>');
			$("#permenent-name").val(first_name.slice(0,-1));
			input_is_invalid("#permenent-name");
		} else if (first_name.length > vendor_name_length) {
			$("#permenent-name-error").html('<span class="text-danger error-msg-small">Name should be of max '+vendor_name_length+' characters.</span>');
			$("#permenent-name").val(first_name.slice(0,vendor_name_length));
			input_is_invalid("#permenent-name");
		} else {
			$("#permenent-name-error").html('');
			input_is_valid("#permenent-name");
		}
	} else {
		$("#permenent-name-error").html('<span class="text-danger error-msg-small">Please enter name.</span>');
		input_is_invalid("#permenent-name");
	}
}

function valid_relationship(){
		var relationship = $("#relationship").val();
	if (relationship !='') {
		$("#relationship-error").html("");
		input_is_valid("#relationship")
	}else{
		$("#relationship-error").html("<span class='text-danger error-msg-small'>Please select valid relationship</span>");
		input_is_invalid("#relationship")
	}
}
function valid_contact_no(){
	var contact_no = $("#permenent-contact_no").val();
	if (contact_no !='') {
		if (isNaN(contact_no)) {
			$("#permenent-contact_no-error").html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
			$("#permenent-contact_no").val(contact_no.slice(0,-1));
			input_is_invalid("#permenent-contact_no");
		} else if (contact_no.length != 10) {
			$("#permenent-contact_no-error").html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
			var plenght = $("#permenent-contact_no").val(contact_no.slice(0,10));
			input_is_invalid("#permenent-contact_no");
			if (plenght.length == 10) {
			$("#permenent-contact_no-error").html('');
			input_is_valid("#permenent-contact_no");	
			}
		} else {
			$("#permenent-contact_no-error").html('');
			input_is_valid("#permenent-contact_no");
		} 
	}else{
		$("#permenent-contact_no-error").html("<span class='text-danger error-msg-small'>Please enter valid contact number</span>");
		input_is_invalid("#permenent-contact_no")
	}
}

function valid_start_date(){
	var start_date = $("#permenent-start-date").val();
	if (start_date !='') {
		$("#permenent-start-date-error").html("");
		input_is_valid("#permenent-start-date")
	}else{
		$("#permenent-start-date-error").html("<span class='text-danger error-msg-small'>Please select valid start date</span>");
		input_is_invalid("#permenent-start-date")
	}
}
function valid_end_date(){
	var end_date = $("#permenent-end-date").val(); 
	if (end_date !='') {
		$("#permenent-end-date-error").html("");
		input_is_valid("#permenent-end-date")
	}else{
		$("#permenent-end-date-error").html("<span class='text-danger error-msg-small'>Please select valid end date</span>");
		input_is_invalid("#permenent-end-date")
	}
}




function removeFile_documents(id,param){ 
	$("#myModal-remove").modal('show');
	$("#remove-caption").html("<h4 class='text-danger'>Are you sure removing this image?</h4>")
	$("#button-area").html('<a href="" data-dismiss="modal" class="exit-btn float-center text-center mr-1">Close</a><button class="btn btn-sm btn-danger text-white" onclick="image_remove('+id+',\''+param+'\')">remove</button>')

}


function image_remove(id,param){ 
var	table = 'permanent_address';
var image_name = $("#remove_file_"+param+"_documents"+id).data('file');
var path = $("#remove_file_"+param+"_documents"+id).data('path');
var image_field = $("#remove_file_"+param+"_documents"+id).data('field');

$.ajax({
        type: "POST",
          url: base_url+"candidate/remove_candidate_image",
          data:{table:table,image_field:image_field,path:path,image_name:image_name},
          dataType: 'json', 
          success: function(data) {
			if (data.status == '1') {
				toastr.success('Image removed successfully.');  
				$("#"+param+id).remove(); 
          	}else{
          		toastr.error('Something went wrong while removing the image. Please try again.'); 	
          	} 
          	$("#myModal-remove").modal('hide');
          }
    });
}


function valid_countries(request_from) {
	var country = $("#country").val();
	if (country != '') {
		if (request_from != 'add-data') {
			var c_id = $("#country").children('option:selected').data('id')
			
			$.ajax({
	            type: "POST",
	            url: base_url+"candidate/get_selected_states/"+c_id, 
	            dataType: 'json', 
	            success: function(data) {
	              	var html = '';
	              	html +="<option>Select State</option>";
					if (data.length > 0) {
						for (var i = 0; i < data.length; i++) {
							html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
						}
					}
					$("#state").html(html);
					valid_state();
	            }
	        });
		}
		$("#country-error").html("");
		input_is_valid("#country")
	}else{
		$("#country-error").html("<span class='text-danger error-msg-small'>Please select valid country</span>");
		input_is_invalid("#country")
	}
}