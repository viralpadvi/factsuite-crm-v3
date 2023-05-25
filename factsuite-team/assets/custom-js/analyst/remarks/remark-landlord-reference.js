var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

 


$("#client-documents").on("change", handleFileSelect_candidate_aadhar);   


function handleFileSelect_candidate_aadhar(e){ 
	candidate_aadhar = [];
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
  
		// var period_of_stay = [];
	if(candidateInfo['tenancy_period'] != null){
		 tenancy_period = candidateInfo['tenancy_period'];
		tenancy_period = JSON.parse(tenancy_period)
	}else{
		 tenancy_period = []
	}	

$(".tenancy_period").each(function(){
	tenancy_period.push({tenancy_period:$(this).val()});
	var obj = {}
	obj['tenancy_period'] = $(this).val()
	tenancy_period[index] = obj
});

		// var period_of_stay = [];
	if(candidateInfo['tenancy_period_comment'] != null){
		 tenancy_period_comment = candidateInfo['tenancy_period_comment'];
		tenancy_period_comment = JSON.parse(tenancy_period_comment)
	}else{
		 tenancy_period_comment = []
	}	

$(".tenancy_period_comment").each(function(){
	// tenancy_period_comment.push({tenancy_period_comment:$(this).val()});
	var obj = {}
	obj['tenancy_period_comment'] = $(this).val()
	tenancy_period_comment[index] = obj
});

		// var period_of_stay = [];
	if(candidateInfo['monthly_rental_amount'] != null){
		 monthly_rental_amount = candidateInfo['monthly_rental_amount'];
		monthly_rental_amount = JSON.parse(monthly_rental_amount)
	}else{
		 monthly_rental_amount = []
	}	

$(".monthly_rental_amount").each(function(){
	// monthly_rental_amount.push({monthly_rental_amount:$(this).val()});
	var obj = {}
	obj['monthly_rental_amount'] = $(this).val()
	monthly_rental_amount[index] = obj
});

		// var period_of_stay = [];
	if(candidateInfo['monthly_rental_amount_comment'] != null){
		 monthly_rental_amount_comment = candidateInfo['monthly_rental_amount_comment'];
		monthly_rental_amount_comment = JSON.parse(monthly_rental_amount_comment)
	}else{
		 monthly_rental_amount_comment = []
	}	

$(".monthly_rental_amount_comment").each(function(){
	// monthly_rental_amount_comment.push({monthly_rental_amount_comment:$(this).val()});
	var obj = {}
	obj['monthly_rental_amount_comment'] = $(this).val()
	monthly_rental_amount_comment[index] = obj
});

		// var period_of_stay = [];
	if(candidateInfo['occupants_property'] != null){
		 occupants_property = candidateInfo['occupants_property'];
		occupants_property = JSON.parse(occupants_property)
	}else{
		 occupants_property = []
	}	

$(".occupants_property").each(function(){
	// occupants_property.push({occupants_property:$(this).val()});
	var obj = {}
	obj['occupants_property'] = $(this).val()
	occupants_property[index] = obj
});

		// var period_of_stay = [];
	if(candidateInfo['occupants_property_comment'] != null){
		 occupants_property_comment = candidateInfo['occupants_property_comment'];
		occupants_property_comment = JSON.parse(occupants_property_comment)
	}else{
		 occupants_property_comment = []
	}	

$(".occupants_property_comment").each(function(){
	// occupants_property_comment.push({occupants_property_comment:$(this).val()});
	var obj = {}
	obj['occupants_property_comment'] = $(this).val()
	occupants_property_comment[index] = obj
});

		// var period_of_stay = [];
	if(candidateInfo['tenant_consistently_pay_rent_on_time'] != null){
		 tenant_consistently_pay_rent_on_time = candidateInfo['tenant_consistently_pay_rent_on_time'];
		tenant_consistently_pay_rent_on_time = JSON.parse(tenant_consistently_pay_rent_on_time)
	}else{
		 tenant_consistently_pay_rent_on_time = []
	}	

$(".tenant_consistently_pay_rent_on_time").each(function(){
	// tenant_consistently_pay_rent_on_time.push({tenant_consistently_pay_rent_on_time:$(this).val()});
	var obj = {}
	obj['tenant_consistently_pay_rent_on_time'] = $(this).val()
	tenant_consistently_pay_rent_on_time[index] = obj
});

		// var period_of_stay = [];
	if(candidateInfo['tenant_consistently_pay_rent_on_time_comment'] != null){
		 tenant_consistently_pay_rent_on_time_comment = candidateInfo['tenant_consistently_pay_rent_on_time_comment'];
		tenant_consistently_pay_rent_on_time_comment = JSON.parse(tenant_consistently_pay_rent_on_time_comment)
	}else{
		 tenant_consistently_pay_rent_on_time_comment = []
	}	

$(".tenant_consistently_pay_rent_on_time_comment").each(function(){
	// tenant_consistently_pay_rent_on_time_comment.push({tenant_consistently_pay_rent_on_time_comment:$(this).val()});
	var obj = {}
	obj['tenant_consistently_pay_rent_on_time_comment'] = $(this).val()
	tenant_consistently_pay_rent_on_time_comment[index] = obj
});

if(candidateInfo['utility_bills_paid_on_time'] != null){
		 utility_bills_paid_on_time = candidateInfo['utility_bills_paid_on_time'];
		utility_bills_paid_on_time = JSON.parse(utility_bills_paid_on_time)
}else{
	 utility_bills_paid_on_time = []
} 
$(".utility_bills_paid_on_time").each(function(){
	// utility_bills_paid_on_time.push({utility_bills_paid_on_time:$(this).val()});
	var obj = {}
	obj['utility_bills_paid_on_time'] = $(this).val()
	utility_bills_paid_on_time[index] = obj
}); 


if(candidateInfo['utility_bills_paid_on_time_comment'] != null){
		 utility_bills_paid_on_time_comment = candidateInfo['utility_bills_paid_on_time_comment'];
		utility_bills_paid_on_time_comment = JSON.parse(utility_bills_paid_on_time_comment)
}else{
	 utility_bills_paid_on_time_comment = []
} 
$(".utility_bills_paid_on_time_comment").each(function(){
	// utility_bills_paid_on_time_comment.push({utility_bills_paid_on_time_comment:$(this).val()});
	var obj = {}
	obj['utility_bills_paid_on_time_comment'] = $(this).val()
	utility_bills_paid_on_time_comment[index] = obj
});

if(candidateInfo['rental_property'] != null){
		 rental_property = candidateInfo['rental_property'];
		rental_property = JSON.parse(rental_property)
}else{
	 rental_property = []
} 
$(".rental_property").each(function(){
	rental_property.push({rental_property:$(this).val()});
	var obj = {}
	obj['rental_property'] = $(this).val()
	rental_property[index] = obj
});

if(candidateInfo['rental_property_comment'] != null){
		 rental_property_comment = candidateInfo['rental_property_comment'];
		rental_property_comment = JSON.parse(rental_property_comment)
}else{
	 rental_property_comment = []
} 
$(".rental_property_comment").each(function(){
	// rental_property_comment.push({rental_property_comment:$(this).val()});
	var obj = {}
	obj['rental_property_comment'] = $(this).val()
	rental_property_comment[index] = obj
});

if(candidateInfo['maintenance_issues'] != null){
		 maintenance_issues = candidateInfo['maintenance_issues'];
		maintenance_issues = JSON.parse(maintenance_issues)
}else{
	 maintenance_issues = []
} 
$(".maintenance_issues").each(function(){
	// maintenance_issues.push({maintenance_issues:$(this).val()});
	var obj = {}
	obj['maintenance_issues'] = $(this).val()
	maintenance_issues[index] = obj
});

if(candidateInfo['maintenance_issues_comment'] != null){
		 maintenance_issues_comment = candidateInfo['maintenance_issues_comment'];
		maintenance_issues_comment = JSON.parse(maintenance_issues_comment)
}else{
	 maintenance_issues_comment = []
} 
$(".maintenance_issues_comment").each(function(){
	// maintenance_issues_comment.push({maintenance_issues_comment:$(this).val()});
	var obj = {}
	obj['maintenance_issues_comment'] = $(this).val()
	maintenance_issues_comment[index] = obj
});


if(candidateInfo['tenant_leave'] != null){
		 tenant_leave = candidateInfo['tenant_leave'];
		tenant_leave = JSON.parse(tenant_leave)
}else{
	 tenant_leave = []
} 
$(".tenant_leave").each(function(){
	// tenant_leave.push({tenant_leave:$(this).val()});
	var obj = {}
	obj['tenant_leave'] = $(this).val()
	tenant_leave[index] = obj
});


if(candidateInfo['tenant_leave_comment'] != null){
		 tenant_leave_comment = candidateInfo['tenant_leave_comment'];
		tenant_leave_comment = JSON.parse(tenant_leave_comment)
}else{
	 tenant_leave_comment = []
} 
$(".tenant_leave_comment").each(function(){
	// tenant_leave_comment.push({tenant_leave_comment:$(this).val()});
	var obj = {}
	obj['tenant_leave_comment'] = $(this).val()
	tenant_leave_comment[index] = obj
});


if(candidateInfo['tenant_rent_again'] != null){
		 tenant_rent_again = candidateInfo['tenant_rent_again'];
		tenant_rent_again = JSON.parse(tenant_rent_again)
}else{
	 tenant_rent_again = []
} 
$(".tenant_rent_again").each(function(){
	// tenant_rent_again.push({tenant_rent_again:$(this).val()});
	var obj = {}
	obj['tenant_rent_again'] = $(this).val()
	tenant_rent_again[index] = obj
});


if(candidateInfo['tenant_rent_again_comment'] != null){
		 tenant_rent_again_comment = candidateInfo['tenant_rent_again_comment'];
		tenant_rent_again_comment = JSON.parse(tenant_rent_again_comment)
}else{
	 tenant_rent_again_comment = []
} 
$(".tenant_rent_again_comment").each(function(){
	// tenant_rent_again_comment.push({tenant_rent_again_comment:$(this).val()});
	var obj = {}
	obj['tenant_rent_again_comment'] = $(this).val()
	tenant_rent_again_comment[index] = obj
});


if(candidateInfo['any_pets'] != null){
		 any_pets = candidateInfo['any_pets'];
		any_pets = JSON.parse(any_pets)
}else{
	 any_pets = []
} 
$(".any_pets").each(function(){
	// any_pets.push({any_pets:$(this).val()});
	var obj = {}
	obj['any_pets'] = $(this).val()
	any_pets[index] = obj
});


if(candidateInfo['any_pets_comment'] != null){
		 any_pets_comment = candidateInfo['any_pets_comment'];
		any_pets_comment = JSON.parse(any_pets_comment)
}else{
	 any_pets_comment = []
} 
$(".any_pets_comment").each(function(){
	// any_pets_comment.push({any_pets_comment:$(this).val()});
	var obj = {}
	obj['any_pets_comment'] = $(this).val()
	any_pets_comment[index] = obj
});


if(candidateInfo['food_preference'] != null){
		 food_preference = candidateInfo['food_preference'];
		food_preference = JSON.parse(food_preference)
}else{
	 food_preference = []
} 
$(".food_preference").each(function(){
	// food_preference.push({food_preference:$(this).val()});
	var obj = {}
	obj['food_preference'] = $(this).val()
	food_preference[index] = obj
});


if(candidateInfo['food_preference_comment'] != null){
		 food_preference_comment = candidateInfo['food_preference_comment'];
		food_preference_comment = JSON.parse(food_preference_comment)
}else{
	 food_preference_comment = []
} 
$(".food_preference_comment").each(function(){
	// food_preference_comment.push({food_preference_comment:$(this).val()});
	var obj = {}
	obj['food_preference_comment'] = $(this).val()
	food_preference_comment[index] = obj
});


if(candidateInfo['spare_time'] != null){
		 spare_time = candidateInfo['spare_time'];
		spare_time = JSON.parse(spare_time)
}else{
	 spare_time = []
} 
$(".spare_time").each(function(){
	// spare_time.push({spare_time:$(this).val()});
	var obj = {}
	obj['spare_time'] = $(this).val()
	spare_time[index] = obj
});


if(candidateInfo['spare_time_comment'] != null){
		 spare_time_comment = candidateInfo['spare_time_comment'];
		spare_time_comment = JSON.parse(spare_time_comment)
}else{
	 spare_time_comment = []
}
$(".spare_time_comment").each(function(){
	// spare_time_comment.push({spare_time_comment:$(this).val()});
	var obj = {}
	obj['spare_time_comment'] = $(this).val()
	spare_time_comment[index] = obj
});


if(candidateInfo['overall_character'] != null){
		 overall_character = candidateInfo['overall_character'];
		overall_character = JSON.parse(overall_character)
}else{
	 overall_character = []
}
$(".overall_character").each(function(){
	// overall_character.push({overall_character:$(this).val()});
	var obj = {}
	obj['overall_character'] = $(this).val()
	overall_character[index] = obj
});


if(candidateInfo['overall_character_comment'] != null){
		 overall_character_comment = candidateInfo['overall_character_comment'];
		overall_character_comment = JSON.parse(overall_character_comment)
	}else{
		 overall_character_comment = []
	}
$(".overall_character_comment").each(function(){
	// overall_character_comment.push({overall_character_comment:$(this).val()});
	var obj = {}
	obj['overall_character_comment'] = $(this).val()
	overall_character_comment[index] = obj
});


if(candidateInfo['complaints_from_neighbors'] != null){
		 complaints_from_neighbors = candidateInfo['complaints_from_neighbors'];
		complaints_from_neighbors = JSON.parse(complaints_from_neighbors)
	}else{
		 complaints_from_neighbors = []
	}
$(".complaints_from_neighbors").each(function(){
	// complaints_from_neighbors.push({complaints_from_neighbors:$(this).val()});
	var obj = {}
	obj['complaints_from_neighbors'] = $(this).val()
	complaints_from_neighbors[index] = obj
});

if(candidateInfo['complaints_from_neighbors_comment'] != null){
		 complaints_from_neighbors_comment = candidateInfo['complaints_from_neighbors_comment'];
		complaints_from_neighbors_comment = JSON.parse(complaints_from_neighbors_comment)
	}else{
		 complaints_from_neighbors_comment = []
	}
$(".complaints_from_neighbors_comment").each(function(){
	// complaints_from_neighbors_comment.push({complaints_from_neighbors_comment:$(this).val()});
	var obj = {}
	obj['complaints_from_neighbors_comment'] = $(this).val()
	complaints_from_neighbors_comment[index] = obj
});



 
		// var progress_remarks = [];
	if(candidateInfo['in_progress_remarks'] != null){
		var progress_remarks = candidateInfo['in_progress_remarks'];
		progress_remarks = JSON.parse(progress_remarks)
	}else{
		var progress_remarks = []
	}
	$(".progress_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // progress_remarks.push({progress_remarks : $(this).val()});
		 var obj = {}
			obj['progress_remarks'] = $(this).val()
			progress_remarks[index] = obj
		// }
	});
		// var insuff_remarks = [];
	if(candidateInfo['insuff_remarks'] != null){
		var insuff_remarks = candidateInfo['insuff_remarks'];
		insuff_remarks = JSON.parse(insuff_remarks)
	}else{
		var insuff_remarks = []
	}	
	$(".insuff_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // insuff_remarks.push({insuff_remarks : $(this).val()});
		 	var obj = {}
			obj['insuff_remarks'] = $(this).val()
			insuff_remarks[index] = obj
		// }
	});
	 
		// var verification_remarks = [];
	if(candidateInfo['verification_remarks'] != null){
		var verification_remarks = candidateInfo['verification_remarks'];
		verification_remarks = JSON.parse(verification_remarks)
	}else{
		var verification_remarks = []
	}
	$(".verification_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // verification_remarks.push({verification_remarks : $(this).val()});
		 	var obj = {}
			obj['verification_remarks'] = $(this).val()
			verification_remarks[index] = obj
		// }
	});

		// var closure_remarks = [];
	if(candidateInfo['closure_remarks'] != null){
		var closure_remarks = candidateInfo['closure_remarks'];
		closure_remarks = JSON.parse(closure_remarks)
	}else{
		var closure_remarks = []
	}
	$(".closure_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // closure_remarks.push({closure_remarks : $(this).val()});
		 	var obj = {}
			obj['closure_remarks'] = $(this).val()
			closure_remarks[index] = obj
		// }
	});

  var verified_date = [];
  $(".verified_date").each(function(){
    // state.push($(this).val());
    if ($(this).val() !='' && $(this).val() !=null) {
      // verification_remarks.push({verification_remarks : $(this).val()});
      var obj = {}
      obj['verified_date'] = $(this).val()
      verified_date[index] = obj
      // alert(JSON.stringify(verification_remarks))
    }
  }); 
 

	// alert(candidateInfo['verified_by'])
	if(candidateInfo['verified_by'] != null){
		var verified_by = candidateInfo['verified_by'];
		// alert()
		verified_by = JSON.parse(verified_by)
	}else{
		var verified_by = []
	}
	$(".verified_by").each(function(){
		
		var obj = {}
		obj['verified_by'] = $(this).val()
		verified_by[index] = obj
		 
	});

	var candidate_id_hidden = $("#candidate_id_hidden").val(); 
	// var action_status = $("#action_status").val(); 
	var action_status = $("#action_status").val();
	if(candidateInfo['analyst_status'] != null){
		var analyst_status = candidateInfo['analyst_status'].split(',');
		// analyst_status = JSON.parse(analyst_status)
	}else{
		var analyst_status = []
	}
	analyst_status[index] = action_status;
	var vendor_id = $('#vendor_name').val();
	
	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
	

		var landload_id = $("#landload_id").val();

 	var formdata = new FormData();
 		formdata.append('url',23);
		formdata.append('tenant_name',JSON.stringify(tenant_name));
		formdata.append('case_contact_no',JSON.stringify(case_contact_no));
		formdata.append('landlord_name',JSON.stringify(landlord_name));
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
	formdata.append('selected_component_status',action_status);



	var op_action_status = $('#op_action_status').val();
	if(op_action_status == null || op_action_status == '' || op_action_status == 'null'){
		formdata.append('op_action_status','0')	
	}else{
		formdata.append('op_action_status',op_action_status)
	}

 
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
          url: base_url+"analyst/update_landlord_reference",
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
          	}else{
          		toastr.error('Something went wrong while save this data. Please try again.'); 	
          	}
          	get_latest_selected_vendor();
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
 