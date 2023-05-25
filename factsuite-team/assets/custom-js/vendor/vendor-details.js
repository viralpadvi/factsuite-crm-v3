get_latest_selected_vendor();
function get_latest_selected_vendor() {
	$.ajax({
		type: "POST",
	  	url: base_url+"admin_Vendor/get_latest_selected_vendor_for_component_form", 
	  	data: {
	  		case_id : $("#candidate_id_hidden").val(),
	  		component_id : $("#component_id").val(),
	  		index : $('#componentIndex').val()},
	  	dataType: "json",
	  	success: function(data) {
	  		if (data != '' && data != null) {
	  			$('#vendor_name').val(data.vendor_id);
	  			$('#assigned-vendor-case-completion-latest-id').val(data.assign_id);
	  			$('#assigned-vendor-case-completion-date').val(data.case_completed_by_vendor_date);
	  			$('#assigned-vendor-case-completion-date-div').removeClass('d-none');
	  		}
	  	} 
	});
}

$('#assigned-vendor-case-completion-date-submit-btn').on('click', function() {
	submit_assigned_vendor_case_complition_date();
});

$('#assigned-vendor-case-completion-date').on('change', function() {
	check_assigned_vendor_case_competion_date();
});

function check_assigned_vendor_case_competion_date() {
	var variable_array = {};
	variable_array['input_id'] = '#assigned-vendor-case-completion-date';
	variable_array['error_msg_div_id'] = '#assigned-vendor-case-completion-date-error-msg-div';
	variable_array['empty_input_error_msg'] = 'Please select a date';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function submit_assigned_vendor_case_complition_date() {
	var check_assigned_vendor_case_competion_date_var = check_assigned_vendor_case_competion_date();
	if (check_assigned_vendor_case_competion_date_var == 1) {
		$.ajax({
			type: "POST",
		  	url: base_url+"admin_Vendor/update_assigned_vendor_case_completion_date", 
		  	data: {
		  		case_id : $("#candidate_id_hidden").val(),
		  		component_id : $("#component_id").val(),
		  		assign_id : $('#assigned-vendor-case-completion-latest-id').val(),
		  		case_completion_date : $('#assigned-vendor-case-completion-date').val(),
		  		index : $('#componentIndex').val()
		  	},
		  	dataType: "json",
		  	success: function(data) {
		  		if (data.status == 1) {
		  			toastr.success('Successfully saved data.');
		  		} else {
		  			toastr.error('Something went wrong while save this data. Please try again.');
		  		}
		  	} 
		});
	}
}

/*Approval Mech*/


function get_roles_person_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-roles-person-list", 
        dataType: "json",
        data : {
            verify_analyst_request : 1,
            role_type : $('#assigned-to-role').val()
        },
        success: function(data) {
            var html = '<option value="">Select Person</option>';
            if (data.all_persons.length > 0) {
                var all_persons = data.all_persons;
                for (var i = 0; i < all_persons.length; i++) {
                    html += '<option value="'+all_persons[i].team_id+'">'+all_persons[i].first_name+' '+all_persons[i].last_name+' ('+all_persons[i].team_employee_email+')</option>';
                }
            }
            $('#assigned-to-person').html(html);
        } 
    });
}


remarks_all();
function remarks_all() {
   
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
                if (data[i].status == '3') { 
                     html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
                }
            }
            $('#ticket_description').html(html);
        } 
    });
}



function get_all_approval_list() {
	$component = $("#component_id").val();
	$.ajax({
        type : "POST",
        url : base_url+"Approval_Mechanisms/get_approval_data",
        data : {
            verify_csm_request : 1,
            component_id : $component
        },
        dataType: "json",
        success: function(data) {
        	var all_tickets = data,
        		html = ''; 
            if (data.length > 0) {
                for (var i = 0; i < all_tickets.length; i++) {
                	var status = 'Requested';
                    if (all_tickets[i].final_approval_status =='1') {
                        status = 'Accepted';
                    }else if(all_tickets[i].final_approval_status =='2') {
                        status = 'Rejected';
                    }
                	 
                        var action = 'Creating';
                    if (all_tickets[i].type_of_action =='0') {
                        action = 'Creating';
                    }else if(all_tickets[i].type_of_action =='1') {
                        action = 'Deletion';
                    }
                     
                    html += '<tr class="case-filter" id="tr_'+all_tickets[i].approval_id+'">';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+(i+1)+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i].approval_id+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+action+'</td>';
                    html += '<td id="start_date'+all_tickets[i].approval_id+'">'+get_date_formate(all_tickets[i]['approval_created_date'])+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i]['remarks']+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i]['first_name']+' ('+all_tickets[i]['created_by_role']+')</td>';
                    html += '<td id="ticket-status-'+all_tickets[i].approval_id+'">'+status+'</td>';
                    // html += '<td class="text-center" id="view_ticket_details_'+all_tickets[i].approval_id+'"><a id="view_ticket_details_a'+all_tickets[i].approval_id+'" href="javascript:void(0)" onclick="view_ticket_details('+all_tickets[i].approval_id+')"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                    html += '</tr>';
                    } 
                }
             
            $('#view_approval_data_list').html(html);
        } 
    });
}



function get_date_formate($param){
    var it_works = $param;

jQuery.ajax({
  type: "POST",
  url: base_url+'custom_Util/get_actual_date_formate',
  data:{curr_date:$param},
  success: function (data) {
    it_works = data;
  }, 
  async: false 
}); 

return it_works;
}

 