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

var url_regex = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/,
	email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
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


	$("#street").on('keyup blur',valid_street); 
	$("#area").on('keyup blur',valid_area); 
	$("#address").on('keyup blur',valid_address); 
	$("#pincode").on('keyup blur',valid_pincode);
	$("#city").on('keyup blur change',valid_city);
	$("#state").on('keyup blur change',valid_state);
	// $("#country").on('keyup blur change',valid_countries);
	$("#house-flat").on('keyup blur',valid_house_flat);
	$("#land-mark").on('keyup blur',valid_land_mark);


$('#first-name').on('keyup blur',function(){
	valid_first_name();
});

$('#last-name').on('keyup blur',function(){
	valid_last_name();
});

$('#father-name').on('keyup blur',function(){
	valid_father_name();
});

$("#date-of-birth").on('keyup keydown input blur change',function(){
	valid_birth_date();
});

$("#nationality").on('keyup keydown input blur change',function(){
	valid_nationality();
});


$("#timepicker").on('keyup keydown input blur change',function(){
	valid_timepicker();
});


$("#timepicker2").on('keyup keydown input blur change',function(){
	valid_timepicker2();
});

/*$("#file1").on("change", handleFileSelect_candidate_aadhar);
$("#file2").on("change", handleFileSelect_candidate_pan);
$("#file3").on("change", handleFileSelect_candidate_proof);
$("#file4").on("change", handleFileSelect_candidate_bank); 

*/
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
 // $('#frame').attr('src',URL.createObjectURL(event.target.files[0]));
function handleFileSelect_candidate_bank(e){
	    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file4-error").html('');
        $(".file-name4").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	        		 var fileName = files[i].name; // get file name  
	        	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_bank_'+i+'"><span>'+fileName+' <a id="file_candidate_bank'+i+'" onclick="removeFile_candidate_bank('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image_bank('+i+',\'candidate_bank\')" ><i class="fa fa-eye"></i></a></span></div>';
	                candidate_bank.push(files[i]);
	                $(".file-name4").append(html);
	        	}
	           
	        }
	    } else {
	    	$("#file4-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file4').val('');
	    }
    } else {
        $("#file4-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}


function removeFile_candidate_bank(id) {

    var file = $('#file_candidate_bank'+id).data("file");
    for(var i = 0; i < candidate_bank.length; i++) {
        if(candidate_bank[i].name === file) {
            candidate_bank.splice(i,1); 
        }
    }
    if (candidate_bank.length == 0) {
    	$("#file4").val('');
    }
    $('#file_candidate_bank_'+id).remove(); 

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

function view_image_bank(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_bank[id]);
}
function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
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
			$('#first-name-error').html('');
			input_is_valid('#first-name');
		}
	} else {
		$('#first-name-error').html('<span class="text-danger error-msg-small">Please enter first name.</span>');
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
			$('#last-name-error').html('');
			input_is_valid('#last-name');
		}
	} else {
		$('#last-name-error').html('<span class="text-danger error-msg-small">Please add a last name.</span>');
		input_is_invalid('#last-name');
	}
}
 

function valid_father_name(){
	 
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
			$('#father-name-error').html('');
			input_is_valid('#father-name');
		}
	} else {
		$('#father-name-error').html('<span class="text-danger error-msg-small">Please add a father name.</span>');
		input_is_invalid('#father-name');
	}
}


function valid_birth_date(){
	var birthdate = $('#date-of-birth').val();
	if (birthdate != '') {
		$('#date-of-birth-error').html('');
		input_is_valid('#date-of-birth');
	} else {
		input_is_invalid('#date-of-birth');
		$('#date-of-birth-error').html('<span class="text-danger error-msg-small">Please enter your birth date.</span>');
	}	
}


function valid_nationality(){
	var nationality = $('#nationality').val();
	if (nationality != '') {
		$('#nationality-error').html('');
		input_is_valid('#nationality');
	} else {
		input_is_invalid('#nationality');
		$('#nationality-error').html('<span class="text-danger error-msg-small">Please enter your nationality.</span>');
	}	
}

function valid_timepicker(){
	var timepicker = $('#timepicker').val();
	if (timepicker != '') {
		$('#timepicker-error').html('');
		input_is_valid('#timepicker');
	} else {
		input_is_invalid('#timepicker');
		$('#timepicker-error').html('<span class="text-danger error-msg-small">Please select the time.</span>');
	}		
}


function valid_timepicker2(){
	var timepicker2 = $('#timepicker2').val();
	if (timepicker2 != '') {
		$('#timepicker2-error').html('');
		input_is_valid('#timepicker2');
	} else {
		input_is_invalid('#timepicker2');
		$('#timepicker2-error').html('<span class="text-danger error-msg-small">Please enter your timepicker.</span>');
	}		
}


$("#save-candidate-information").on('click',function(){
	save_candidate_details();
});

function save_candidate_details() {
	$("#warning-msg").html("")
	var first_name = $('#first-name').val();
	var last_name = $('#last-name').val();
	var father_name = $('#father-name').val();
	var birthdate = $('#date-of-birth').val();
	var nationality = $('#nationality').val();
	var timepicker = $('#start-hour').val()+':'+$('#start-minute').val();
	var timepicker2 = $('#end-hour').val()+':'+$('#end-minute').val();

	if(time_formate == '13') {
		timepicker += ' '+$('#start-type').val();
		timepicker2 += ' '+$('#end-type').val();
	}

	var employee_company = $("#employee-company").val();
	var education = $("#education").val();
	var university = $("#university").val();
	var social_media = $("#social_media").val();

	var gender = $("#gender").val();
	var marital = $("#maritial-status").val();	
	var title = $("#title").val(); 
	var state = $("#state").val(); 
	var city = $("#city").val(); 
	var pincode = $("#pincode").val(); 
	var address = $("#address").val(); 
	// var week = $("#preference-week").val(); 
	var week =[]; 
	$('.weeks:checked').each(function(){
		week.push($(this).val());
	})
	
	var house = $("#house-flat").val();
	var street = $("#street").val();
	var area = $("#area").val();
	/*candidate_aadhar
	candidate_pan
	candidate_proof
	candidate_bank*/ 
	$("#gender-error").html('');
	$("#marital-error").html('');
	$("#aadhar-error").html('');
	$("#pan-error").html('');
	$("#proof-error").html('');

	var communications = [];
	$(".communications:checked").each(function(){ 
		if ($(this).val() !='' && $(this).val() !=null) {
			communications.push($(this).val());
		}
	});
	
	if (first_name !='' &&
		last_name !='' &&
		father_name !='' &&
		birthdate !='' &&
		nationality !='' &&
		timepicker !='' &&
		timepicker2 !='' &&
		gender !=null &&
		marital !=null &&
		state !='' &&
		city !='' &&
		pincode !='' && pincode.length >= 6 &&
		house !='' &&
		street !='' &&
		area !='' &&
		title !='' /*&& candidate_aadhar.length > 0 &&  candidate_pan.length > 0 && candidate_proof.length > 0*/ ) {
	 
		var formdata = new FormData();
		formdata.append('url',0);
		formdata.append('week',week);
		formdata.append('first_name',first_name);
		formdata.append('last_name',last_name);
		formdata.append('father_name',father_name);
		formdata.append('birthdate',birthdate);
		formdata.append('nationality',nationality);
		formdata.append('timepicker',timepicker);
		formdata.append('timepicker2',timepicker2);
		formdata.append('gender',gender);
		formdata.append('title',title);
		formdata.append('marital',marital);
		formdata.append('state',state);
		formdata.append('city',city);
		formdata.append('pincode',pincode);
		formdata.append('address',address);
		
		formdata.append('house',house);
		formdata.append('street',street);
		formdata.append('area',area);
		formdata.append('communications',communications);

		formdata.append('employee_company',employee_company);
		formdata.append('education',education);
		formdata.append('university',university);
		formdata.append('social_media',social_media);

		formdata.append('link_request_from',link_request_from);
		/*if (candidate_aadhar.length > 0) {
			for (var i = 0; i < candidate_aadhar.length; i++) { 
				formdata.append('candidate_aadhar[]',candidate_aadhar[i]);
			}
		}else{
			formdata.append('candidate_aadhar[]','');
		}
		if (candidate_pan.length > 0) {
			for (var i = 0; i < candidate_pan.length; i++) { 
				formdata.append('candidate_pan[]',candidate_pan[i]);
			}
		}else{
			formdata.append('candidate_pan[]','');
		}
		if (candidate_proof.length > 0) {
			for (var i = 0; i < candidate_proof.length; i++) { 
				formdata.append('candidate_proof[]',candidate_proof[i]);
			}
		}else{
			formdata.append('candidate_proof[]','');
		}
		if (candidate_bank.length > 0) {
			for (var i = 0; i < candidate_bank.length; i++) { 
				formdata.append('candidate_bank[]',candidate_bank[i]);
			}
		}else{
			formdata.append('candidate_bank[]','');
		}*/

		$("#warning-msg").html("<span class='text-warning'>Please wait we are submitting the data.</span>");
		$("#save-candidate-information").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');


			$.ajax({
            	type: "POST",
				url: base_url+"candidate/update_candidate_info",
				data:formdata,
				dataType: 'json',
				contentType: false,
				processData: false,
              	success: function(data) {
					$("#warning-msg").html("");
					if (data.status == '1') {
						// toastr.success('successfully saved data.');  
						candidate_aadhar = [];
						candidate_pan = [];
						candidate_proof = [];
						candidate_bank = [];
						// $("#warning-msg").html("<span class='text-success error-msg-small'>Data successfully submitted.</span>")
						if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
							window.location.href=base_url+data.url;
						} else {
							window.location.href = base_url+'m-verification-steps';
						}
					}else{
						// $("#warning-msg").html("<span class='text-success error-msg-small'>Please enter Valid All Data.</span>")
						toastr.error('Something went wrong while save this data. Please try again.'); 	
					}
					$("#save-candidate-information").html('Save & Continue');
				}
            });
	}else{
		valid_first_name();
		valid_last_name();
		valid_father_name();
		valid_birth_date();
		valid_nationality();
		valid_timepicker();
		valid_timepicker2();
		valid_street();
			valid_area();
			// valid_address()
			valid_pincode();
			valid_city();
			valid_state();
			valid_house_flat();

		if (gender ==null) {
			$("#gender-error").html("<span class='text-danger'>Please select gender</span>")
		}
		if (marital ==null) {
			$("#marital-error").html("<span class='text-danger'>Please select maritial status</span>")
		} 
		/*if (candidate_aadhar.length == 0) {
			$("#aadhar-error").html("<span class='text-danger'>Please upload aadhar document</span>");
		}
		if (candidate_pan.length == 0) {
			$("#pan-error").html("<span class='text-danger'>Please upload pan card document</span>");
		}
		if (candidate_proof.length == 0) {
			$("#proof-error").html("<span class='text-danger'>Please upload any proof document</span>");
		}*/

	}
}


function valid_state() {
	$('#city').html("<option selected value=''>Select City/Town</option>");
	var state = $("#state").val();
	if (state !='') {
		var c_id = $("#state").children('option:selected').data('id');
		$.ajax({
            type: "POST",
            url: base_url+"candidate/get_selected_cities/"+c_id, 
            dataType: 'json', 
            success: function(data) {
              	var html = "<option selected value=''>Select City/Town</option>";
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
					}
				}
				$("#city").html(html);
            }
        });
		$("#state-error").html("");
		input_is_valid("#state");
	} else {
		$("#state-error").html("<span class='text-danger error-msg-small'>Please select valid state</span>");
		input_is_invalid("#state");
	}
}



function valid_house_flat(){
	var house_flat = $("#house-flat").val();
	if (house_flat !='') {
		$("#house-flat-error").html("");
		input_is_valid("#house-flat")
	}else{
		$("#house-flat-error").html("<span class='text-danger error-msg-small'>Please enter valid house flat</span>");
		input_is_invalid("#house-flat")
	}
}

function valid_address(){
	var address = $("#address").val();
	if (address !='') {
		$("#address-error").html("");
		input_is_valid("#address")
	}else{
		input_is_invalid("#address")
		$("#address-error").html("<span class='text-danger error-msg-small'>Please enter valid address</span>");
	}
}
function valid_pincode(){ 
	var pincode = $("#pincode").val();
	if (pincode !='') {
		if (isNaN(pincode)) {
			$("#pincode-error").html('<span class="text-danger error-msg-small">Pin code should be only numbers.</span>');
			$("#pincode").val(pincode.slice(0,-1));
			input_is_invalid("#pincode");
		} else if (pincode.length != 6) {
			$("#pincode-error").html('<span class="text-danger error-msg-small">Pin code should be of '+6+' digits.</span>');
			plenght = $("#pincode").val(pincode.slice(0,6));
			input_is_invalid("#pincode");
			if (plenght.length == 6) {
			$("#pincode-error").html('');
			input_is_valid("#pincode");	
			}
		} else {
			$("#pincode-error").html('');
			input_is_valid("#pincode");
		} 
		 
	}else{
		$("#pincode-error").html("<span class='text-danger error-msg-small'>Please enter valid pincode</span>");
		input_is_invalid("#pincode")
		 
	}
}
 
function valid_city(){
 
	var city = $("#city").val();
	if (city != '') {
		/*if (!alphabets_only.test(city)) {
			$("#city-error").html('<span class="text-danger error-msg-small">City should be only alphabets.</span>');
			$("#city").val(city.slice(0,-1));
			input_is_invalid("#city");
		} else*/ if (city.length > vendor_name_length) {
			$("#city-error").html('<span class="text-danger error-msg-small">City should be of max '+vendor_name_length+' characters.</span>');
			$("#city").val(city.slice(0,vendor_name_length));
			input_is_invalid("#city");
		} else {
			$("#city-error").html('');
			input_is_valid("#city");
		}
	} else {
		$("#city-error").html('<span class="text-danger error-msg-small">Please add a city.</span>');
		input_is_invalid("#city");
	}	
}


function valid_house_flat(){
	var house_flat = $("#house-flat").val();
	if (house_flat !='') {
		$("#house-flat-error").html("");
		input_is_valid("#house-flat")
	}else{
		$("#house-flat-error").html("<span class='text-danger error-msg-small'>Please select valid house flat</span>");
		input_is_invalid("#house-flat")
	}
}
function valid_land_mark(){
	var land_mark = $("#land-mark").val();
	if (land_mark !='') {
		$("#land-mark-error").html("");
		input_is_valid("#land-mark")
	}else{
		$("#land-mark-error").html("<span class='text-danger error-msg-small'>Please select valid land mark</span>");
		input_is_invalid("#land-mark")
	}
}

function valid_street(){
		var street = $("#street").val();
	if (street !='') {
		$("#street-error").html("");
		input_is_valid("#street")
	}else{
		$("#street-error").html("<span class='text-danger error-msg-small'>Please select valid street</span>");
		input_is_invalid("#street")
	}
}

function valid_area(){
		var area = $("#area").val();
	if (area !='') {
		$("#area-error").html("");
		input_is_valid("#area")
	}else{
		$("#area-error").html("<span class='text-danger error-msg-small'>Please select valid area</span>");
		input_is_invalid("#area")
	}
}
