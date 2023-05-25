var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

 

$(".client-documents").on("change", handleFileSelect_candidate_aadhar); 


function handleFileSelect_candidate_aadhar(e){ 
		var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#selected-criminal-docs-li"+number).html('');
        $("#criminal-upoad-docs-error-msg-div"+number).html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
        	var obj = [];
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            // alert(number)
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_aadhar_'+number+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+number+i+'" onclick="removeFile_candidate_aadhar('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+number+','+i+',\'candidate_aadhar'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                obj.push(files[i]);
	                $("#criminal-upoad-docs-error-msg-div"+number).append(html);
	        	}

	        }
	        candidate_aadhar.push({[number]:obj}); 
	    } else {
	    	$("#selected-criminal-docs-li"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents'+number).val('');
	    }
    } else {
        $("#selected-criminal-docs-li"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_aadhar(num,id) {
var tmp_array = [];
    var file = $('#file_candidate_aadhar'+num+id).data("file");
    for(var i = 0; i < candidate_aadhar.length; i++) {
    	if (typeof candidate_aadhar[i][num] !='undefined') {
    		var count = candidate_aadhar[i][num].length;
    		var obj = [];
		for (var b = 0; b < count; b++) { 
			if (candidate_aadhar[i][num][b].name !== file) { 
				obj.push(candidate_aadhar[i][num][b])
			} 
		} 
		tmp_array.push({[num]:obj})
	}else{
		tmp_array.push(candidate_aadhar[i])
	}

    }

    candidate_aadhar = tmp_array; 

    if (candidate_aadhar.length == 0) {
    	$("#client-documents"+num).val('');
    }
    $('#file_candidate_aadhar_'+num+id).remove(); 
}

function view_image(num,id,text){ 
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	 for (var i = 0; i < candidate_aadhar.length; i++) {
	 	 if (typeof candidate_aadhar[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(candidate_aadhar[i][num][id]);
	 	 }
	 }
	    
}
function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}


$("#add-criminal-check").on('click',function(){ 
 

	var address = [];
	$(".address").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 address.push({address : $(this).val()});
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
	var insuff_remarks = [];
	$(".insuff_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		insuff_remarks.push({insuff_remarks : $(this).val()});
		}
	}); 
	var progress_remarks = [];
	$(".progress_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		progress_remarks.push({progress_remarks : $(this).val()});
		}
	}); 
	var verification_remarks = [];
	$(".verification_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		verification_remarks.push({verification_remarks : $(this).val()});
		}
	}); 
	var closure_remarks = [];
	$(".closure_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		closure_remarks.push({closure_remarks : $(this).val()});
		}
	}); 
	var criminal_check_id = $("#criminal_check_id").val();
	var action_status = $("#action_status").val();
	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
	var formdata = new FormData();
	formdata.append('userID',userID);
	formdata.append('userRole',userRole);
	formdata.append('address',JSON.stringify(address));
	formdata.append('pincode',JSON.stringify(pincode));
	formdata.append('city',JSON.stringify(city));
	formdata.append('state',JSON.stringify(state));
	formdata.append('insuff_remarks',JSON.stringify(insuff_remarks));
	formdata.append('progress_remarks',JSON.stringify(progress_remarks));
	formdata.append('verification_remarks',JSON.stringify(verification_remarks));
	formdata.append('closure_remarks',JSON.stringify(closure_remarks));
	formdata.append('criminal_check_id',criminal_check_id);
	formdata.append('action_status',action_status);
	formdata.append('count',candidate_aadhar.length);
	var op_action_status = $('#op_action_status').val()
	if(op_action_status == null || op_action_status == ''){
		formdata.append('op_action_status','0')	
	}else{
		formdata.append('op_action_status',op_action_status)
	}

	var candidate_id_hidden = $('#candidate_id_hidden').val()
	formdata.append('candidate_id',candidate_id_hidden);
	
	if (candidate_aadhar.length > 0) {
		var a = 0;
		$.each(candidate_aadhar,function(index,value){ 
			$.each(value,function(index,val){ 
			if (candidate_aadhar[a][index].length > 0) {
			for (var c = 0; c < candidate_aadhar[a][index].length; c++) {
					formdata.append('approved_doc'+a+'[]',candidate_aadhar[a][index][c]); 
					// alert(candidate_aadhar[a][index][c].name)
			} 	
			}else{
				// alert("false 1")
				formdata.append('approved_doc[]','');
			}
		});
			a++;
		});
 
	}else{
		formdata.append('approved_doc[]','');
		// alert("false 2")
	} 

	// return false;
	 
	addressCount = $('#addressCount').val();

	if (verification_remarks.length == addressCount) {
		$("#warning-msg").html("<span class='text-warning'>Please wait while we are updating the data.</span>");
		$.ajax({
            type: "POST",
              url: base_url+"analyst/update_remarks_candidate_criminal_check",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
              	$("#wait-message").html("");
				if (data.status == '1') {
					toastr.success('successfully saved data.');   
					$('.is-valid').removeClass('is-valid');
              	}else{
              		toastr.error('Something went wrong while save this data. Please try again.'); 	
              	}
              	$("#warning-msg").html("");
              	$('#conformtion').modal('hide');
              }
        });
	}else{
		$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
		$(".address").each(function(){
			var MyID = $(this).attr("id"); 
		   	var number = MyID.match(/\d+/); 
			valid_verification_remarks(number)
		}); 
		 
	}
	

});


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
		$("#address-error"+id).html("&nbsp;");
		input_is_valid("#address"+id)
	}else{
		input_is_invalid("#address"+id)
		$("#address-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid address</span>");
	}
}

function valid_pincode(id){ 
	var pincode = $("#pincode"+id).val();
	if (pincode !='') {
		if (isNaN(pincode)) {
			$("#pincode-error"+id).html('<span class="text-danger error-msg-small">pin code should be only numbers.</span>');
			$("#pincode"+id).val(pincode.slice(0,-1));
			input_is_invalid("#pincode"+id);
		} else if (pincode.length != 6) {
			$("#pincode-error"+id).html('<span class="text-danger error-msg-small">pin code should be of '+6+' digits.</span>');
			plenght = $("#pincode"+id).val(pincode.slice(0,6));
			input_is_invalid("#pincode"+id);
			if (plenght.length == 6) {
			$("#pincode-error"+id).html('&nbsp;');
			input_is_valid("#pincode"+id);	
			}
		} else {
			$("#pincode-error"+id).html('&nbsp;');
			input_is_valid("#pincode"+id);
		} 
	}else{
		$("#pincode-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid pincode</span>");
		input_is_invalid("#pincode"+id)
	}
}
function valid_city(id){
	var city = $("#city"+id).val();
	if (city !='') {
		$("#city-error"+id).html("&nbsp;");
		input_is_valid("#city"+id)
	}else{
		$("#city-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid city</span>");
		input_is_invalid("#city"+id)
	}
}
function valid_state(id){
	var state = $("#state"+id).val();
	if (state !='') {
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid state</span>");
		input_is_invalid("#state"+id)
	}
}

function valid_insuff_remarks(id){
	var insuff_remarks = $("#insuff_remarks"+id).val();
	if (insuff_remarks !='') {
		$("#insuff_remarks-error"+id).html("&nbsp;");
		input_is_valid("#insuff_remarks"+id)
	}else{
		$("#insuff_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Insff Remarks</span>");
		input_is_invalid("#insuff_remarks"+id)
	}
}

function valid_progress_remarks(id){
	var progress_remarks = $("#progress_remarks"+id).val();
	if (progress_remarks !='') {
		$("#progress_remarks-error"+id).html("&nbsp;");
		input_is_valid("#progress_remarks"+id)
	}else{
		$("#progress_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Progress Remarks</span>");
		input_is_invalid("#progress_remarks"+id)
	}
}

function valid_verification_remarks(id){
	var verification_remarks = $("#verification_remarks"+id).val();
	if (verification_remarks !='') {
		$("#verification_remarks-error"+id).html("&nbsp;");
		input_is_valid("#verification_remarks"+id)
	}else{
		$("#verification_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Verification Remarks</span>");
		input_is_invalid("#verification_remarks"+id)
	}
}

function valid_closure_remarks(id){
	var closure_remarks = $("#closure_remarks"+id).val();
	if (closure_remarks !='') {
		$("#closure_remarks-error"+id).html("&nbsp;");
		input_is_valid("#closure_remarks"+id)
	}else{
		$("#closure_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Closure Remarks</span>");
		input_is_invalid("#closure_remarks"+id)
	}
}