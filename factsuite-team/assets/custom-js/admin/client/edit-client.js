 var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
// var mobile_number_length = 10;
var url_regex = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var client_docs =[];

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
	mobile_number_length = 10,
	vendor_spoc_name_length = 200,
	vendor_first_name_length = 100,
	vendor_last_name_length = 100,
	vendor_user_name_length = 70,
	min_vendor_user_name_length = 8,
	password_length = 8,
	vendor_skill_tat_length = 3;


$('#client-industry').on('change',function(){
	// alert($(this).val())
	if($(this).val() == '101'){
		$('#li-other-industry').removeClass('d-none')
	}else{
		$('#li-other-industry').addClass('d-none')		
	}
})


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

 
$("#client-name").on('keyup blur',function() {
	valid_client_name();
});
$("#client-address").on('keyup blur',function() {
	valid_client_address();
});
$("#client-city").on('keyup blur',function() {
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
	client_docs = [];
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var i = 1; 
    if (files.length <= max_client_document_select) {
        $("#selected-vendor-docs").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name  
	             html += '<div class="col-md-4 mt-3" id="file_client_documents_'+i+'">'+
	                    '<div class="image-selected-div">'+
	                        fileName+'<a id="file_client_documents'+i+'" onclick="removeFile_client_documents('+i+')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'client-docs\')" ><i class="fa fa-eye"></i></a>'+
	                           /* '<li>'+
	                                '<a id="file_client_documents'+i+'" onclick="removeFile_client_documents('+i+')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
	                            '</li>'+*/
	                        
	                    '</div>'+
	                '</div>';
	                client_docs.push(files[i]);
	        }
	                $("#selected-vendor-docs").append(html);
	    } else {
	    	$("#client-upoad-docs-error-msg-div").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents').val('');
	    }
    } else {
        $("#selected-client-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}

function view_image(id,text){ 
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");   
	 	 if (typeof client_docs[id] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
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


function removeFile_documents(id) {
    var file = $('#remove_file_client_documents'+id).data("file");
	   /* for(var i = 0; i < client_docs.length; i++) {
	        if(client_docs[i].name === file) {
	            client_docs.splice(i,1); 
	        }
	    }
	*/
	var client_id = $("#client-id").val();
    $.ajax({
	          type: "POST",
	          url: base_url+"client/remove_client_attachment/",
	          data:{file:file,client_id:client_id},
	          dataType: 'json', 
	          success: function(data) {
	          	if (data.status =='1') {
	          		 toastr.success('successfully file removed.'); 
   				 $('#dbfile_client_documents_'+id).remove(); 
			    }else{ 
			    }
	          }
     	 });
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
			$('#spoc-email-error'+id).html("<span class='text-danger error-msg'>Please enter a valid email.</span>");
	    	input_is_invalid('#spoc-email'+id);
	    } else { 
	    		input_is_valid('#spoc-email'+id);
			        $('#spoc-email-error'+id).html("&nbsp;");
		/*$.ajax({
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
					$('#spoc-email-error'+id).html('<span class="text-danger error-msg">already available this mail.</span>');
			    }
	          }
     	 });*/
	    }
	} else {
		input_is_invalid('#spoc-email'+id);
		$('#spoc-email-error'+id).html('<span class="text-danger error-msg">Please enter email id.</span>');
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
            $("#user-confirm-password-error").html("<span class='text-success error-msg'>Passwords are same</span>");
        } else {
        	input_is_invalid('#user-confirm-password');
            $("#user-confirm-password-error").html("<span class='text-danger error-msg'>Passwords didn\'t matched.</span>");
        }
	} else {
		if (password == '') {
			input_is_invalid('#user-password');
			$("#user-password-error").html('<span class="text-danger error-msg">Please enter your password.</span>');
		} else {
			input_is_valid('#user-password');
			$("#user-password-error").html('&nbsp;');
		}

		if (confirm_password == '') {
			input_is_invalid('#user-confirm-password');
			$('#user-confirm-password-error').html('<span class="text-danger error-msg">Please confirm your password.</span>');
		} else {
			input_is_valid('#user-confirm-password');
			$('#user-confirm-password-error').html('&nbsp;');
		}
	}
}


 

function valid_client_name(){
 

	var client_name = $('#client-name').val();
	if (client_name != '') {
		 
			$('#client-name-error').html('');
			 
			input_is_valid('#client-name');
		 
	} else {
		$('#client-name-error').html('<span class="text-danger error-msg-small">Please add a client Name.</span>');
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
		$('#client-address-error').html('<span class="text-danger error-msg">Please enter client address.</span>');
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

function valid_state(){
	var state = $("#client-state").val();
	if (state != '') {

		var c_id = $("#client-state").children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"client/get_selected_cities/"+c_id, 
              dataType: 'json', 
              success: function(data) {
              	var html = '';
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
		input_is_invalid('#client-state');
		$('#client-state-error').html('<span class="text-danger error-msg-small">Please enter client state.</span>');
	}	
}


function valid_client_industry(){
	var industry = $("#client-industry").val();
	if (industry != '') {
	     
	        $('#client-industry-error').html("&nbsp;");
	        input_is_valid('#client-industry');
	   
	} else {
		input_is_invalid('#client-industry');
		$('#client-industry-error').html('<span class="text-danger error-msg">Please enter client industry.</span>');
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
		$('#master-account-error').html('<span class="text-danger error-msg">Please select master account.</span>');
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
		$('#account-manager-error').html('<span class="text-danger error-msg">Please select Factsuite manager.</span>');
	}	
}

function valid_manager_email(){
	var user_email = $("#manager-email").val();
	if (user_email != '') {
	    if(!regex.test(user_email)) {
			$('#manager-email-error').html("<span class='text-danger error-msg'>Please enter a valid email.</span>");
	    	input_is_invalid('#manager-email');
	    } else { 
	    		input_is_valid('#manager-email');
			        $('#manager-email-error').html("&nbsp;");
	/*        $.ajax({
	          type: "POST",
	          url: base_url+"client/manager_valid_mail/",
	          data:{email:spoc_email},
	          dataType: 'json', 
	          success: function(data) {
	          	if (data.status =='1') {
	          		input_is_valid('#manager-email');
			        $('#manager-email-error').html("&nbsp;");
			    }else{
			    	input_is_invalid('#manager-email');
			    	// $("#spoc-email"+id).val('');
					$('#manager-email-error').html('<span class="text-danger error-msg">already available this mail.</span>');
			    }
	          }
     	 });*/
	    }
	} else {
		input_is_invalid('#manager-email');
		$('#manager-email-error').html('<span class="text-danger error-msg">Please enter email id.</span>');
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
			$('#user-name-error').html("<span class='text-danger error-msg'>please enter min 4 digit user name.</span>");
	    } else {
	        $('#user-name-error').html("&nbsp;");
	        input_is_valid('#user-name');
	    }
	} else {
		input_is_invalid('#user-name');
		$('#user-name-error').html('<span class="text-danger error-msg">Please enter user name.</span>');
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
		$('#first-name-error').html('&nbsp;');
		input_is_valid('#first-name');
	} else {
		input_is_invalid('#first-name');
		$('#first-name-error').html('<span class="text-danger error-msg">Please enter your first name.</span>');
	}
}


function valid_last_name(){
	var last_name = $('#last-name').val();
	if (last_name != '') {
		$('#last-name-error').html('&nbsp;');
		input_is_valid('#last-name');
	} else {
		input_is_invalid('#last-name');
		$('#last-name-error').html('<span class="text-danger error-msg">Please enter your last name.</span>');
	}
}
var j = tmp_i;
function valid_packages(){
	var packages = $('#packages').val(); 
	var tmppackages = $('#tmp-packages').val();
	var tmp = [];
	if (tmppackages !='') { 
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
          	if (data.length > 0) {
          		$('#tmp-packages').val(packages);
          		for (var i = 0; i < data.length; i++) { 
					html +='<ul class="ul'+data[i]['package_id']+'">';
					html +='<li>';
					html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					html +='<input type="checkbox" disabled checked class="custom-control-input component_name" name="customCheck" value="'+data[i]['component_id']+'" id="customCheck5">';
					html +='<label class="custom-control-label" for="customCheck5">'+data[i]['component_name']+'</label>';
					html +='</div>';
					html +='</li>';
					html +='<li>';
					html +='<input type="hidden" class="form-control fld2 component_package_id"  value="'+data[i].package_id+'" id="component_package_id'+j+'">';
					html +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data[i].component_standard_price+'" id="component_standard_price'+j+'">';
					html +='</li>';
					html +='<li>';
					html +='<input type="text" class="form-control fld component_price" id="component_price'+j+'" oninput="oninput_float('+j+')" onkeypress="return oninput_fun(event)" onkeyup="component_price('+j+')">';
					html +='</li>';
					html +='</ul>';
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
		component_price();
		 
	}
	 
	
}

/*function valid_packages(){
	var packages = $('#packages').val();
	if (packages != '') {
		$('#packages-error').html('&nbsp;');
		input_is_valid('#packages');

		$.ajax({
          type: "POST",
          url: base_url+"package/get_package_component/",
          data:{package_id:packages},
          dataType: 'json', 
          success: function(data) {
          	var html='';
          	if (data.length > 0) {
          		for (var i = 0; i < data.length; i++) { 
					html +='<ul>';
					html +='<li>';
					html +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
					html +='<input type="checkbox" disabled checked class="custom-control-input component_name" name="customCheck" value="'+data[i]['component_id']+'" id="customCheck5">';
					html +='<label class="custom-control-label" for="customCheck5">'+data[i]['component_name']+'</label>';
					html +='</div>';
					html +='</li>';
					html +='<li>';
					html +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data[i].component_standard_price+'" id="component_standard_price'+i+'">';
					html +='</li>';
					html +='<li>';
					html +='<input type="text" class="form-control fld component_price" id="component_price'+i+'"  oninput="oninput_float('+i+')" onkeypress="return oninput_fun(event)"  onkeyup="component_price('+i+')">';
					html +='</li>';
					html +='</ul>';
          		}
          	}
          	$("#component-details").html(html);
          	$("#component-total").html('');
          }
     	});
	} else {
		input_is_invalid('#packages');
		$('#packages-error').html('<span class="text-danger error-msg">Please select packages.</span>');
	}
}*/
/*function component_price_call(id){
	component_price(id)
}*/
function component_price(id){
	var component_price = $("#component_price"+id).val();
	var component_standard_price = $("#component_standard_price"+id).val();
	// alert(component_standard_price)
		var total = 0;
	if (parseFloat(component_standard_price) >= parseFloat(component_price) && parseFloat(component_price) > 0) {
		$("#component-price-error").html('&nbsp;');
		$(".component_price").each(function(){ 
  			if ($(this).val() !='' && $(this).val() !=null) { 
  				  total += parseFloat($(this).val())
  			}else{
  				total += 0	
  			}
		});
		/*var sub_total = 0;
		if (total.length > 0) {
			sub_total = total
		}*/
		
		// alert(eval(total.join("+")))
		input_is_valid("#component_price"+id);
	}else{
		input_is_invalid("#component_price"+id);
		// $("#component_price"+id).val();
		$("#component-price-error").html('<span class="text-danger error-msg-small">Please enter less or equal Standards Price</span>');
		// component_price_call(id)
		
		if (component_price =='' || component_price ==null) { 
			$(".component_price").each(function(){ 
  			if ($(this).val() !='' && $(this).val() !=null) { 
  				  total += parseFloat($(this).val())
  			}else{
  				total += 0	
  			}
		});
		}
	}

		var total_html = '';
			total_html +='<ul>';
			total_html +='<li> ';
			total_html +='</li>';
			total_html +='<li>';
			total_html +=' <label>Price for Client total</label>';
			total_html +='</li>';
			total_html +='<li>';
			total_html +='<b>'+parseFloat(total).toFixed(2)+'</b>';
			total_html +='</li>';
			total_html +='</ul> ';

		$("#component-total").html(total_html); 
}

 function oninput_float(id){
 	// var regex = /(?!^-)[^0-9.]/g;
    var component_price = $("#component_price"+id).val();
  // if (regex.test(component_price)){
      var component_prices = component_price.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1'); 
	$("#component_price"+id).val(component_prices); 
  // }
}

function oninput_fun(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;
       	return ((k > 64 && k < 91) || k == 8 ||k == 46|| k == 32 || (k >= 48 && k <= 57));
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


function save_client(){

	var client_id = $("#client-id").val();
	var client_name = $("#client-name").val();
	var client_address = $("#client-address").val();
	var client_city = $("#client-city").val();
	var country = $("#country").val();
	var client_state = $('#client-state').val();
	var client_industry = $("#client-industry").val();
	var client_website = $("#client-website").val();
	var master_account = $("#master-account").val();
	var account_manager = $("#account-manager").val();
	var manager_email = $("#manager-email").val();
	var manager_contact = $("#manager-contact").val();
	var zip = $('#client-zip').val();
	var is_master = $("#is_master:checked").val();
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
	var spo_id = [];
	$(".spo_id").each(function(){
		if($(this).val()==''){ 
		 	$("#spo-details-div-error").html('<span class="text-danger">Please All Field reqired</span>');
	      return false;
	    }
		if ($(this).val() !='' && $(this).val() !=null) {
			spo_id.push($(this).val());
		}
	});
 
	var spo_contact = [];
	$(".spo_contact").each(function(){
		if($(this).val()==''){ 
		 	$("#spo-details-div-error").html('<span class="text-danger">Please All Field reqired</span>');
	      return false;
	    }
		if ($(this).val() !='' && $(this).val() !=null) {
			spo_contact.push($(this).val());
		}
	});

	var component_name = [];
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
	});
	var component_price = [];
	$(".component_price").each(function(){
		 if($(this).val()==''){ 
		 	$("#component-price-error").html('<span class="text-danger">Please fill All Client price required </span>');
	      return false;
	    }
		if ($(this).val() !='' && $(this).val() !=null) {
			component_price.push($(this).val());
		}
	});

	var other_industry = 'none';
	if(client_industry == '101'){
		other_industry = $('#other_industry').val();
	}
 
	

	var formdata = new FormData();

	formdata.append('client_id',client_id);
	formdata.append('client_name',client_name);
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
	formdata.append('spo_id',spo_id);
	formdata.append('spo_name',JSON.stringify(spo_name));
	formdata.append('spo_email',JSON.stringify(spo_email));
	formdata.append('spo_contact',spo_contact);
	formdata.append('communications',communications);
	formdata.append('zip',zip);
	// formdata.append('files',client_docs);
	if (is_master !=null && is_master =='0') {
		formdata.append('is_master',is_master);
	}
	formdata.append('component_name',component_name);
	formdata.append('component_standard_price',component_standard_price);
	formdata.append('component_price',component_price);
	formdata.append('component_package_id',component_package_id);

	if (client_docs.length > 0) {
		for(var i=0, len=client_docs.length; i<len; i++) {
			formdata.append('files[]', client_docs[i]);
		}
	} else {
		formdata.append('files[]', '');
	}
	$("#communication-error").html("&nbsp;");

	if (client_name !='' &&
		client_address !='' &&
		client_city !='' &&
		client_state !='' &&
		client_industry !='' &&
		client_website !='' &&
		 (is_master  !=null || master_account !='') &&
		account_manager !='' &&
		manager_email !='' &&
		manager_contact !='' &&
		package !='' &&
		spo_name.length > 0 &&
		spo_email.length > 0 &&
		spo_contact.length > 0 &&
		communications !='' &&
		zip !='' &&
		component_name.length > 0 &&
		component_standard_price.length > 0 &&
		component_price.length > 0 ) {

		$("#client-error").html("<span class='text-warning'> Please wait while we are updating the data</span>");
		$("#client-submit-btn").attr('disabled',true);

        $.ajax({
            type: "POST",
              url: base_url+"client/update_client/",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
                if (data.status == '1') {  
                	toastr.success('New product order has been updated successfully.'); 
                	/*$("#client-name").val('');
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
						
						client_docs =[];
						$("#component-details").html('');*/
						load_client();

                }else{ 
                	toastr.error('Something went wrong while product ordering. Please try again.'); 
                } 
                 $("#edit-client-view").modal('hide');
                 $("#client-error").html("");
				$("#client-submit-btn").attr('disabled',false);
              }
          }); 

    }else{
    	if (communications.length == 0) {
    		$("#communication-error").html('<span class="text-danger">Please select min 1 required</span>');
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
		valid_account_manager();
		valid_manager_email();
		valid_manager_contact();
		check_user_name();
		// check_contact();
		// valid_first_name();
		// valid_last_name();
		valid_packages();
		check_reccovery_password_match();
		check_reccovery_password_match();
		valid_client_zip();
    }


}

 var i = 5;
   $("#add-new").on('click',function(){  
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


$("#country").on('blur change',valid_countries)
function valid_countries(){ 
	var country = $("#country").val();
	if (country !='') {
		var c_id = $("#country").children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"client/get_selected_states/"+c_id, 
              dataType: 'json', 
              success: function(data) {
              	var html = '';
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
					}
				}
				$("#client-state").html(html);
				 valid_state()
              }
            });
		$("#country-error").html("&nbsp;");
		input_is_valid("#country")
	}else{
		$("#country-error").html("<span class='text-danger error-msg-small'>Please Select Valid country</span>");
		input_is_invalid("#country")
	}
}