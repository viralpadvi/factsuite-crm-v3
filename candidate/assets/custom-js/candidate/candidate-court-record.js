// alert(JSON.stringify(states))

var url_regex = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/,
	email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	alphabets_only = /^[A-Za-z ]+$/,
	vendor_name_length = 100,
	city_name_length = 100,
	vendor_zip_code_length = 6,
	vendor_monthly_quota_length = 5,
	address = [],
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

	var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;


	$("#addresses").change(function(){
		// alert($(this).prop('checked'))
		if ($(this).prop('checked')) { 
			var i = 0;
				var address =candidate_info['candidate_flat_no']+', '+candidate_info['candidate_street']+', '+candidate_info['candidate_area'];
			$(".address").each(function(){
				$(this).val(address); 
				$("#pincode"+i).val(candidate_info['candidate_pincode']); 
				$("#country"+i).val(candidate_info['nationality']); 
				// $("#state"+i).val(candidate_info['candidate_state']); 
				// $("#city"+i).val(candidate_info['candidate_city']); 
				i++;
			});
		}else{
			var i = 0;
			$(".address").each(function(){
				$(this).val(''); 
				$("#pincode"+i).val(''); 
				$("#country"+i).val(''); 
				$("#state"+i).val(''); 
				$("#city"+i).val(''); 
				i++;
			});
		} 
	});


$("#file1").on("change", handleFileSelect_address);


function handleFileSelect_address(e){ 
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
	            	 html = '<div id="file_address_'+i+'"><span>'+fileName+' <a id="file_address'+i+'" onclick="removeFile_address('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'address\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                address.push(files[i]);
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


function removeFile_address(id) {

    var file = $('#file_address'+id).data("file");
    for(var i = 0; i < address.length; i++) {
        if(address[i].name === file) {
            address.splice(i,1); 
        }
    }
    if (address.length == 0) {
    	$("#file1").val('');
    }
    $('#file_address_'+id).remove(); 
}


function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(address[id]);
}


function exist_view_image(image,path){
    $("#myModal-show").modal('show'); 
   $("#view-img").html("<img src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}

	
var j =5;
$("#add-row").on('click',function(){
 
var html = '';
html +='<div id="form'+j+'">';
html +='<div class="row">';
html +='<div class="col-md-8">';
html +='<div class="pg-frm">';
html +='<label>Address</label>';
html +='<textarea class="fld form-control address" rows="4" id="address"></textarea>';
html +='<input type="hidden" id="court_records_id"  name="">';
html +='</div>';
html +='</div>';

html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Pin Code</label>';
html +='<input name="" class="fld form-control pincode"  id="pincode" type="text">';
html +='</div>';
html +='</div>';

html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>City/Town</label>';
html +='<input name="" class="fld form-control city"  id="city" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>State</label>';
html +='<select class="fld form-control state" id="state" >';
for (var i = 0; i < states.length; i++) {
	html +='<option value="'+states[i]+'">'+states[i]+'</option>';
}
html +='</select>'; 
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<label></label>';
html +='<button onclick="remove_form('+j+')" ><i class="fa fa-trash"></i></button>';
html +='</div>';
html +='</div>';
html +='<hr>';
html +='</div>';
$("#new_address").append(html);
i++;
});


$("#add-court-record").on('click',function(){ 
 
	var address_ = [];
	var count_court = 0;
	$(".address").each(function(){
		count_court++;
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 address_.push({address : $(this).val()});
		}
	});
	 
	var pincode = [];
	$(".pincode").each(function(){
		// pincode.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		 pincode.push({pincode : $(this).val()});
		}
	});
	var city = [];
	$(".city").each(function(){
		// city.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		city.push({city : $(this).val()});
		}
	});
	var state = [];
	$(".state").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		state.push({state : $(this).val()});
		}
	}); 
	var country = [];
	$(".country").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		country.push({country : $(this).val()});
		}
	}); 
	var court_records_id = $("#court_records_id").val();
	var formdata = new FormData();
	formdata.append('url',2);
	formdata.append('address',JSON.stringify(address_));
	formdata.append('pincode',JSON.stringify(pincode));
	formdata.append('city',JSON.stringify(city));
	formdata.append('state',JSON.stringify(state));
	formdata.append('country',JSON.stringify(country));
	formdata.append('link_request_from',link_request_from);
	if (court_records_id !='' && court_records_id !=null) {
		formdata.append('court_records_id',court_records_id); 
	}


        if (address.length > 0) {
            for (var i = 0; i < address.length; i++) { 
                formdata.append('addresss[]',address[i]);
            }
        }else{
            formdata.append('addresss[]','');
        	$("#file1-error").html('<span class="text-danger error-msg-small">Please select a min 1 file.</span>');
 
        } 
	
	if (address_.length >0 &&
	pincode.length >0 && 
	city.length >0 && 
	state.length >0 && 
	country.length >0 &&  
	address_.length ==count_court && 
	pincode.length ==count_court && 
	city.length ==count_court && 
	state.length ==count_court && 
	country.length ==count_court && 
	state.length ==count_court && ( address.length > 0 || $("#cv_doc").val() !='') ) {
		$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
		$("#add-court-record").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
	$.ajax({
        type: "POST",
          url: base_url+"candidate/update_candidate_court_record",
          data:formdata,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(data) {
			if (data.status == '1') {
				// toastr.success('successfully saved data.');  
				window.location.href=base_url+data.url;
          	}else{
          		toastr.error('Something went wrong while save this data. Please try again.'); 	
          	}
          	$("#warning-msg").html("");
          	$("#add-court-record").html('Save & Continue');
          }
        });
	}else{
	$(".address").each(function(){
		var MyID = $(this).attr("id"); 
   var number = MyID.match(/\d+/); 
   valid_address(number)
	}); 
	$(".pincode").each(function(){
		var MyID = $(this).attr("id"); 
   var number = MyID.match(/\d+/); 
   valid_pincode(number)
	}); 
	$(".city").each(function(){
		var MyID = $(this).attr("id"); 
   var number = MyID.match(/\d+/); 
   // valid_city(number)
	});
	$(".state").each(function(){ 
		var MyID = $(this).attr("id"); 
   	var number = MyID.match(/\d+/); 
   	// valid_state(number)
	}); 
}

});

function remove_form(id){
	$("#form"+id).remove();
}


function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}


function remove_form(id){
	$("#form"+id).remove();
}

function valid_address(id){
	var address = $("#address"+id).val();
	if (address !='') {
		$("#address-error"+id).html("");
		input_is_valid("#address"+id)
	}else{
		input_is_invalid("#address"+id)
		$("#address-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid address</span>");
	}
};
function valid_pincode(id){ 
	var pincode = $("#pincode"+id).val();
	if (pincode !='') {
		if (isNaN(pincode)) {
			$("#pincode-error"+id).html('<span class="text-danger error-msg-small">Pin code should be only numbers.</span>');
			$("#pincode"+id).val(pincode.slice(0,-1));
			input_is_invalid("#pincode"+id);
		} else if (pincode.length != 6) {
			$("#pincode-error"+id).html('<span class="text-danger error-msg-small">Pin code should be of '+6+' digits.</span>');
			var plenght = $("#pincode"+id).val(pincode.slice(0,6));
			input_is_invalid("#pincode"+id);

			if (plenght.length == 6) {
			$("#pincode-error"+id).html('');
			input_is_valid("#pincode"+id);	
			}
		} else {
			$("#pincode-error"+id).html('');
			input_is_valid("#pincode"+id);
		} 
	}else{
		$("#pincode-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid pincode</span>");
		input_is_invalid("#pincode"+id)
	}
};

function valid_city(id){
 

	var city = $("#city"+id).val();
	if (city != '') {
		/*if (!alphabets_only.test(city)) {
			$("#city-error"+id).html('<span class="text-danger error-msg-small">city name should be only alphabets.</span>');
			$("#city"+id).val(city.slice(0,-1));
			input_is_invalid("#city"+id)
		} else*/ if (city.length > vendor_name_length) {
			$("#city-error"+id).html('<span class="text-danger error-msg-small">City name should be of max '+vendor_name_length+' characters.</span>');
			$("#city"+id).val(city.slice(0,vendor_name_length));
			input_is_invalid("#city"+id)
		} else {
			$("#city-error"+id).html('');
			input_is_valid("#city"+id)
		}
	} else {
		$("#city-error"+id).html('<span class="text-danger error-msg-small">Please add a city name.</span>');
		input_is_invalid("#city"+id)
	}
};
/*function valid_state(id){
	var state = $("#state"+id).val();
	if (state !='') {
		$("#state-error"+id).html("");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
		input_is_invalid("#state"+id)
	}
}
*/

function valid_state(id) {
	$('#city'+id).html("<option selected value=''>Select City/Town</option>");
	var state = $("#state"+id).val();
	if (state !='') {
		var c_id = $("#state"+id).children('option:selected').data('id');
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
				$("#city"+id).html(html);
      }
    });
		$("#state-error"+id).html("");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please select valid state</span>");
		input_is_invalid("#state"+id)
	}
}

function valid_countries(id) {
	var country = $("#country"+id).val();
	$('#state'+id).html("<option selected value=''>Select State</option>");
	$('#city'+id).html("<option selected value=''>Select City/Town</option>");
	if (country != '') {
		var c_id = $("#country"+id).children('option:selected').data('id');
		$.ajax({
      type: "POST",
     	url: base_url+"candidate/get_selected_states/"+c_id, 
      dataType: 'json', 
      success: function(data) {
        var html = "<option selected value=''>Select State</option>";
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
					}
				}
				$("#state"+id).html(html);
				// valid_state(id);
      }
    });
		$("#country-error"+id).html("");
		input_is_valid("#country"+id)
	} else {
		$("#country-error"+id).html("<span class='text-danger error-msg-small'>Please select valid country</span>");
		input_is_invalid("#country"+id)
	}
}