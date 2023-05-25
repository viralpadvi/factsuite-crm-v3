var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

 


$("#client-documents").on("change", handleFileSelect_candidate_aadhar);   


function handleFileSelect_candidate_aadhar(e){ 
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#selected-criminal-docs-li").html('');
        $("#criminal-upoad-docs-error-msg-div").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf|doc|docx|xlsx|xls)$/i).test(fileName)) {
	            	 html = '<div id="aadhar-file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="aadhar-file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_aadhar\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_aadhar.push(files[i]);
	                $("#criminal-upoad-docs-error-msg-div").append(html);
	        	} 
	        }
	    } else {
	    	$("#selected-criminal-docs-li").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents').val('');
	    }
    } else {
        $("#selected-criminal-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_aadhar(id) {

    var file = $('#aadhar-file_candidate_aadhar'+id).data("file");
    for(var i = 0; i < candidate_aadhar.length; i++) {
        if(candidate_aadhar[i].name === file) {
            candidate_aadhar.splice(i,1); 
        }
    }
    if (candidate_aadhar.length == 0) {
    	$("#client-documents").val('');
    }
    $('#aadhar-file_candidate_aadhar_'+id).remove(); 
}

 
function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };

         if(text =='candidate_aadhar'){ 
        reader.readAsDataURL(candidate_aadhar[id]);
        } 
}
// function exist_view_image(image,path){
// 	$("#myModal-show").modal('show'); 
//    $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
// }


// $('#submit-reference').click(function(){
// 	alert('Data')
// 	// $('#conformtionReferance').modal('show');
// });

$('#cancle-data-btn').on('click',function(){
	$("#warning-msg").html("");
})

var candidateInfo
function phpData(phpData){ 
	candidateInfo = phpData;
	// console.log(JSON.stringify(candidateInfo));
}

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtionReferance").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	reference();
	      	return false;
	    }
	}
});

$('#submit-reference-data').on('click',function(){
	reference();
});

function reference(){
	var index = $('#componentIndex').val()
	var priority = $('#priority').val()
	var reference_id = $('#reference_id').val();



	let tenant_name = [],
case_contact_no = [],
landlord_name = [],
tenancy_period = [],
tenancy_period_comment = [],
monthly_rental_amount = [],
monthly_rental_amount_comment = [],
occupants_property = [],
occupants_property_comment = [],
tenant_consistently_pay_rent_on_time = [],
tenant_consistently_pay_rent_on_time_comment = [],
utility_bills_paid_on_time  = [],
utility_bills_paid_on_time_comment = [],
rental_property = [],
rental_property_comment = [],
maintenance_issues = [],
maintenance_issues_comment = [],
tenant_leave = [],
tenant_leave_comment = [],
tenant_rent_again = [],
tenant_rent_again_comment = [],
any_pets = [],
any_pets_comment = [],
food_preference = [],
food_preference_comment = [], 
spare_time = [],
complaints_from_neighbors =[],
complaints_from_neighbors_comment =[],
spare_time_comment = [],
overall_character = [],
overall_character_comment = [];
  
	 
$(".tenancy_period").each(function(){
	tenancy_period.push({tenancy_period:$(this).val()}); 
});

	 
$(".tenancy_period_comment").each(function(){
	tenancy_period_comment.push({tenancy_period_comment:$(this).val()});
	 
});
 
$(".monthly_rental_amount").each(function(){
	monthly_rental_amount.push({monthly_rental_amount:$(this).val()});
	 
});

 
$(".monthly_rental_amount_comment").each(function(){
	monthly_rental_amount_comment.push({monthly_rental_amount_comment:$(this).val()});
	 
});
 
$(".occupants_property").each(function(){
	occupants_property.push({occupants_property:$(this).val()});
	 
});

 

$(".occupants_property_comment").each(function(){
	occupants_property_comment.push({occupants_property_comment:$(this).val()});
	 
});
 

$(".tenant_consistently_pay_rent_on_time").each(function(){
	tenant_consistently_pay_rent_on_time.push({tenant_consistently_pay_rent_on_time:$(this).val()});
	 
});
 

$(".tenant_consistently_pay_rent_on_time_comment").each(function(){
	tenant_consistently_pay_rent_on_time_comment.push({tenant_consistently_pay_rent_on_time_comment:$(this).val()});
	 
});
 
$(".utility_bills_paid_on_time").each(function(){
	utility_bills_paid_on_time.push({utility_bills_paid_on_time:$(this).val()});
	 
}); 

 
$(".utility_bills_paid_on_time_comment").each(function(){
	utility_bills_paid_on_time_comment.push({utility_bills_paid_on_time_comment:$(this).val()});
 
});
 
$(".rental_property").each(function(){
	rental_property.push({rental_property:$(this).val()});
	 
});
 
$(".rental_property_comment").each(function(){
	rental_property_comment.push({rental_property_comment:$(this).val()});
	 
});
 
$(".maintenance_issues").each(function(){
	maintenance_issues.push({maintenance_issues:$(this).val()});
	 
});
 
$(".maintenance_issues_comment").each(function(){
	maintenance_issues_comment.push({maintenance_issues_comment:$(this).val()});
	 
});
 
$(".tenant_leave").each(function(){
	tenant_leave.push({tenant_leave:$(this).val()});
	 
});
 
$(".tenant_leave_comment").each(function(){
	tenant_leave_comment.push({tenant_leave_comment:$(this).val()});
	 
});
 
$(".tenant_rent_again").each(function(){
	tenant_rent_again.push({tenant_rent_again:$(this).val()});
	 
});
 
$(".tenant_rent_again_comment").each(function(){
	tenant_rent_again_comment.push({tenant_rent_again_comment:$(this).val()});
	 
});
 
$(".any_pets").each(function(){
	any_pets.push({any_pets:$(this).val()});
	 
});
 
$(".any_pets_comment").each(function(){
	any_pets_comment.push({any_pets_comment:$(this).val()});
	 
});
 
$(".food_preference").each(function(){
	food_preference.push({food_preference:$(this).val()});
	 
});
 
$(".food_preference_comment").each(function(){
	food_preference_comment.push({food_preference_comment:$(this).val()});
	 
});
 
$(".spare_time").each(function(){
	spare_time.push({spare_time:$(this).val()});
	 
});
 
$(".spare_time_comment").each(function(){
	spare_time_comment.push({spare_time_comment:$(this).val()});
	 
});
 
$(".overall_character").each(function(){
	overall_character.push({overall_character:$(this).val()});
	 
});
 
$(".overall_character_comment").each(function(){
	overall_character_comment.push({overall_character_comment:$(this).val()});
	 
});
 
$(".complaints_from_neighbors").each(function(){
	complaints_from_neighbors.push({complaints_from_neighbors:$(this).val()});
	 
});
 
$(".complaints_from_neighbors_comment").each(function(){
	complaints_from_neighbors_comment.push({complaints_from_neighbors_comment:$(this).val()});
	 
});
 	var progress_remarks =[];
	$(".progress_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 progress_remarks.push({progress_remarks : $(this).val()});
		 
	});
	 var insuff_remarks = [];
	$(".insuff_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 insuff_remarks.push({insuff_remarks : $(this).val()});
		 	 
		// }
	});
	 
		var verification_remarks = [];
	 
	$(".verification_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 verification_remarks.push({verification_remarks : $(this).val()});
		 
		// }
	});

		var closure_remarks = [];
	 
	$(".closure_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 closure_remarks.push({closure_remarks : $(this).val()});
		 	 
		// }
	});

  var verified_date = [];
  $(".verified_date").each(function(){
    
      verified_date.push({verified_date : $(this).val()});
      
  }); 
 

	 var verified_by = [];
	$(".verified_by").each(function(){
		  verified_by.push({verified_by : $(this).val()});
		 
		 
	});

	var candidate_id_hidden = $("#candidate_id_hidden").val(); 
	// var action_status = $("#action_status").val(); 
	
	var analyst_status = [];
	$(".analyst_status").each(function(){ 
			analyst_status.push($(this).val()); 
	}); 

	var output_status = [];
	$(".op_action_status").each(function(){ 
			output_status.push($(this).val()); 
	});


	var vendor_id = $('#vendor_name').val();
	
	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
	

		var landload_id = $("#landload_id").val();

 	var formdata = new FormData();
 		formdata.append('url',23); 
		formdata.append('tenancy_period',JSON.stringify(tenancy_period));
		formdata.append('tenancy_period_comment',JSON.stringify(tenancy_period_comment));
		formdata.append('monthly_rental_amount',JSON.stringify(monthly_rental_amount));
		formdata.append('monthly_rental_amount_comment',JSON.stringify(monthly_rental_amount_comment));
		formdata.append('occupants_property',JSON.stringify(occupants_property));
		formdata.append('occupants_property_comment',JSON.stringify(occupants_property_comment));
		formdata.append('tenant_consistently_pay_rent_on_time',JSON.stringify(tenant_consistently_pay_rent_on_time));
		formdata.append('tenant_consistently_pay_rent_on_time_comment',JSON.stringify(tenant_consistently_pay_rent_on_time_comment));
		formdata.append('utility_bills_paid_on_time',JSON.stringify(utility_bills_paid_on_time));
		formdata.append('utility_bills_paid_on_time_comment',JSON.stringify(utility_bills_paid_on_time_comment));
		formdata.append('rental_property',JSON.stringify(rental_property));
		formdata.append('rental_property_comment',JSON.stringify(rental_property_comment));
		formdata.append('maintenance_issues',JSON.stringify(maintenance_issues));
		formdata.append('maintenance_issues_comment',JSON.stringify(maintenance_issues_comment));
		formdata.append('tenant_leave',JSON.stringify(tenant_leave));
		formdata.append('tenant_leave_comment',JSON.stringify(tenant_leave_comment));
		formdata.append('tenant_rent_again',JSON.stringify(tenant_rent_again));
		formdata.append('tenant_rent_again_comment',JSON.stringify(tenant_rent_again_comment));
		formdata.append('any_pets',JSON.stringify(any_pets));
		formdata.append('any_pets_comment',JSON.stringify(any_pets_comment));
		formdata.append('food_preference',JSON.stringify(food_preference));
		formdata.append('food_preference_comment',JSON.stringify(food_preference_comment));
		formdata.append('spare_time',JSON.stringify(spare_time));
		formdata.append('spare_time_comment',JSON.stringify(spare_time_comment));
		formdata.append('overall_character',JSON.stringify(overall_character));
		formdata.append('overall_character_comment',JSON.stringify(overall_character_comment));
		formdata.append('complaints_from_neighbors',JSON.stringify(complaints_from_neighbors));
		formdata.append('complaints_from_neighbors_comment',JSON.stringify(complaints_from_neighbors_comment));
 

	formdata.append('userID',userID);
	formdata.append('userRole',userRole); 

	formdata.append('insuff_remarks',JSON.stringify(insuff_remarks));
	formdata.append('verification_remarks',JSON.stringify(verification_remarks));
	formdata.append('verified_date',JSON.stringify(verified_date));
	formdata.append('closure_remarks',JSON.stringify(closure_remarks)); 
	formdata.append('candidate_id',candidate_id_hidden); 
	formdata.append('analyst_status',analyst_status); 
	formdata.append('count',candidate_aadhar.length);
	formdata.append('index',index);
	formdata.append('priority',priority);
	formdata.append('landload_id',landload_id);
	var component_id = $("#component_id").val();
		formdata.append('component_id',component_id);
	formdata.append('vendor_id',vendor_id);
	formdata.append('component_name','Landlord Reference');
	formdata.append('verified_by',JSON.stringify(verified_by));
	formdata.append('progress_remarks',JSON.stringify(progress_remarks));




	 
		formdata.append('op_action_status',output_status)
	 

 
	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('remark_docs[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('remark_docs[]','');
	} 
	 


	countOfCompanyName = $('#countOfCompanyName').val()
	// if( verification_remarks.length == countOfCompanyName){

	$.ajax({
        type: "POST",
          url: base_url+"outPutQc/update_landlord_reference",
          data:formdata,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(data) {
          	$('#conformtionReferance').modal('hide');
			if (data.status == '1') {
				toastr.success('successfully update data.');  
				$('.is-valid').removeClass('is-valid'); 
				$("#wait-message").html("");
				window.location.href = base_url+"factsuite-outputqc/assigned-view-case-detail/"+candidate_id_hidden;
          	}else{
          		toastr.error('Something went wrong while save this data. Please try again.'); 	
          	}
          	$("#warning-msg").html("");
          }
        });
	// }else{
	// 	$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
	// 	$('.verification_remarks').each(function(){
	// 		var MyID = $(this).attr("id"); 
	// 	    var number = MyID.match(/\d+/);  
	// 		varificationRemarks(number)
		     
	// 	});
	// }
}


function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}


function remove_form(){
	$("#form").remove();
}
function varificationRemarks(id){
	verification_remarks
	var verification_remarks = $("#verification_remarks"+id).val();
	if (verification_remarks !='') {
		$("#verification_remarks-error"+id).html("&nbsp;");
		input_is_valid("#verification_remarks"+id)
		return 1
	}else{
		input_is_invalid("#verification_remarks"+id)
		$("#verification_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Rremarks</span>");
		return 0
	}
}
 