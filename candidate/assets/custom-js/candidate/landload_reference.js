function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}



$("#add_reference_landload").on('click',function(){

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
var count = 0,
		contact_no_error_count = 0,
		contact_name_error_count = 0;
$(".tenant_name").each(function(){

	tenant_name.push({tenant_name:$(this).val()});
});
$(".case_contact_no").each(function(i){
	count++;
	if ($(this).val() !='') {
		case_contact_no.push({case_contact_no:$(this).val()});
		var valid_contact_no_var = valid_contact_no(i);
		if (valid_contact_no_var == 0) {
			contact_no_error_count++;
		}
	}
});
$(".landlord_name").each(function(i) {
	if ($(this).val() !='') {
		landlord_name.push({landlord_name:$(this).val()});
		var valid_name_var = valid_name(i);
		if (valid_name_var == 0) {
			contact_name_error_count++;
		}
	}
});

/*$(".tenancy_period").each(function(){
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
});*/



 	var formdata = new FormData();
 		formdata.append('url',23);
		formdata.append('tenant_name',JSON.stringify(tenant_name));
		formdata.append('case_contact_no',JSON.stringify(case_contact_no));
		formdata.append('landlord_name',JSON.stringify(landlord_name));
		/*formdata.append('tenancy_period',JSON.stringify(tenancy_period));
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
*/
var landload_id = $("#landload_id").val();
	if (landload_id !='' && landload_id !=null) {
		formdata.append('landload_id',landload_id);
	}
	formdata.append('link_request_from',link_request_from);
if (contact_no_error_count == 0 && contact_name_error_count == 0) {
$("#warning-msg").html("<span class='text-warning'>Please wait we are submitting the data.</span>");
$("#add_reference_landload").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$.ajax({
        type: "POST",
          url: base_url+"candidate/update_candidate_landload_reference",
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
          	$("#add_reference_landload").html("Save & Continue")
          }
        });
}

});



function valid_name(id=''){
		var landlord_name = $("#landlord_name"+id).val();
	if (landlord_name !='') {
		$("#landlord_name-error"+id).html("");
		input_is_valid("#landlord_name"+id)
		return 1;
	}else{
		$("#landlord_name-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid Landlord Name</span>");
		input_is_invalid("#landlord_name"+id)
		return 0;
	}
}


function valid_contact_no(id='') {
	var contact_no = $("#case_contact_no"+id).val();
	if (contact_no !='') {
		if (isNaN(contact_no)) {
			$("#case_contact_no-error"+id).html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
			$("#case_contact_no"+id).val(contact_no.slice(0,-1));
			input_is_invalid("#case_contact_no"+id);
			return 0;
		} else if (contact_no.length == 10) {
			$("#case_contact_no-error"+id).html('');
			input_is_valid("#case_contact_no"+id);	
			return 1;
		} else if(contact_no.length > 10 || contact_no.length < 10) {
			$("#case_contact_no-error"+id).html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
			plenght = $("#case_contact_no"+id).val(contact_no.slice(0,10));
			input_is_invalid("#case_contact_no"+id);
			return 0;
		} else {
			$("#case_contact_no-error"+id).html('');
			input_is_valid("#case_contact_no"+id);
			return 1;
		} 
	}else{
		$("#case_contact_no-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid contact number</span>");
		input_is_invalid("#case_contact_no"+id);
		return 0;
	}
}
