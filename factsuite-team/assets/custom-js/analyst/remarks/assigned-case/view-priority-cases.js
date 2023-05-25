get_filter_number_list();
function get_filter_number_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-analyst/get-custom-filter-number-list", 
        dataType: "json",
        data : {
            verify_analyst_request : 1
        },
        success: function(data) {
            var html = '';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i]+'">'+data[i]+'</option>';
            }
            $('#filter-cases-number').html(html);
            get_priority_cases();
        } 
    });
}

function get_priority_cases(request_from = '') {
	$('#load-more-btn').html('<div class="spinner-border text-light spinner-border-load-more"></div>');
    $('#load-more-btn').removeAttr('onclick');

    if (request_from == 'filter_input' || request_from == 'bulk_reassigning') {
        $('#get-priority-cases').html('');
        $('#all-case-filter-btn').html('<div class="spinner-border text-light spinner-border-load-more"></div>');
        $('#all-case-filter-btn').removeAttr('onclick');
    }

    var filter_number = $('#filter-cases-number').val(),
        filter_input = $('#filter-input').val(),
        candidate_id_list = [],
        candidate_numbers_shown = [];

    $('.case-filter').each(function() {
        candidate_id_list.push($(this).data("candidate_id"));
    });

    $('.case-filter').each(function() {
        candidate_numbers_shown.push($(this).data("candidate_display_number"));
    });

    $('#get-priority-cases').append('<tr id="spinner-indicator"><td colspan="13" class="text-center"><div class="spinner-border text-primary spinner-border-load-more"></div></td></tr>');

	$.ajax({
        type: "POST",
        url: base_url+"factsuite-analyst/get-all-priority-cases",
        data:{
            verify_analyst_request : 1,
            candidate_id_list : candidate_id_list,
            filter_limit : filter_number,
            filter_input : filter_input,
        },
        dataType : "json",
        success: function(data) {
        	if(data.status == 1) {
        		var html = '<tr><td colspan="8"><span class="text-center d-block">No Case Found</span></td></tr>';
        		if (data.case.length > 0) {
        			var count = 1,
        				html = '';
        			if (candidate_id_list.length > 0) {
                    	count = candidate_id_list.length + 1;
                	}

        			var case_list = data.case,
        				verification_status = data.verification_status_list;

        			for (var i = 0; i < case_list.length; i++) {
        				var inputQcStatus = '',
        					analystQcStatus = '';

        				if (case_list[i].status == '0' || case_list[i].status == '1') {
                        	inputQcStatus = '<span class="text-warning">Pending<span>';
                    	} else if (case_list[i].status == '2') {
                        	inputQcStatus = '<span class="text-success">Completed<span>';
                    	} else if (case_list[i].status == '3') {
                        	inputQcStatus = '<span class="text-danger">Insufficiency<span>';
                    	} else if (case_list[i].status == '4') {
                        	inputQcStatus = '<span class="text-success">Verified Clear<span>';
                    	} else if (case_list[i].status == '5') {
                        	inputQcStatus = '<span class="text-danger">Stop Check<span>';
                    	} else {
                        	inputQcStatus = '<span class="text-success">Already approved<span>'; 
                    	}

                    	if (case_list[i].analyst_status == '0' || case_list[i].analyst_status == '1' || case_list[i].analyst_status == '11') {
                    		var override_status_arg = case_list[i].candidate_id+","+case_list[i].component_id+",'"+case_list[i].component_name+"','"+case_list[i].index+"',"+i,
                        		analystQcStatus = '';
                        		analystQcStatus += '<select class="fld" class="analyst-status" onchange="status_override_analyst('+override_status_arg+',this.id)" id="analyst-status'+i+'">';

                        	for (var j = 0; j < verification_status.length; j++) {
                        		var select = '';
                        		if (case_list[i].analyst_status == verification_status[j].id) {
                        			select = 'selected';
                        		}
                        		analystQcStatus += '<option '+select+' value="'+verification_status[j].id+'"><span class="text-warning">'+verification_status[j].status+'<span></option>';
                        	}
                        	analystQcStatus += '</select>';
                    	} else if (case_list[i].analyst_status == '2') {
                        	analystQcStatus = '<span class="text-success">Completed<span>';
                    	} else if (case_list[i].analyst_status == '3') {
                        	analystQcStatus = '<span class="text-danger">Insufficiency<span>';
                    	} else if (case_list[i].analyst_status == '4') {
                        	analystQcStatus = '<span class="text-success">Verified Clear<span>';
                    	} else if (case_list[i].analyst_status == '5') {
                        	analystQcStatus = '<span class="text-danger">Stop Check<span>';
                    	} else if (case_list[i].analyst_status == '6') {
                        	analystQcStatus = '<span class="text-danger">Unable to verify<span>';
                    	} else if (case_list[i].analyst_status == '7') {
                        	analystQcStatus = '<span class="text-danger">Verified discrepancy<span>';
                    	} else if (case_list[i].analyst_status == '8') {
                        	analystQcStatus = '<span class="text-danger">Client clarification<span>';
                    	} else if (case_list[i].analyst_status == '9') {
                        	analystQcStatus = '<span class="text-danger">Closed Insufficiency<span>';
                    	} else if (case_list[i].analyst_status == '10') {
                        	analystQcStatus = '<span class="text-danger">QC Error<span>';
                    	} else {
                        	analystQcStatus = '<span class="text-warning">Pending<span>'; 
                    	}

                    	var arg = case_list[i].candidate_id+'/'+case_list[i].component_id+'/'+case_list[i].index,
                     		form_number = case_list[i].index + 1,
                     		candidate_name = case_list[i].candidate_detail['first_name']+" "+case_list[i].candidate_detail['last_name'];
                     	
                 		html += '<tr class="case-filter" id="tr_'+case_list[i].candidate_id+'-'+case_list[i].component_id+'" data-candidate_id="'+case_list[i].candidate_id+'" data-component_id="'+case_list[i].component_id+'" data-candidate_display_number="'+count+'">';
                 		html += '<td>'+count+'</td>';
                 		html += '<td>'+case_list[i].candidate_id+'</td>';
                 		html += '<td>'+case_list[i].component_name+' (form'+form_number+')'+'</td>';
                 		html += '<td>'+candidate_name+'</td>';
                 		html += '<td>'+case_list[i].candidate_detail['client_name']+'</td>';
                 		html += '<td>'+case_list[i].candidate_detail['phone_number']+'</td>';
                 		html += '<td>'+analystQcStatus+'</td>';
                 		html += '<td><a href="'+base_url+'factsuite-analyst/component-detail/'+arg+'" class="app-btn">View <i class="fas fa-angle-right"></i></a></td>';
                 		html += '</tr>';

                 		count++;
        			}
        		}

        		$('#spinner-indicator').remove();

	            if (request_from == 'load_more') {
	                $('#get-priority-cases').append(html); 
	            } else {
	                $('#get-priority-cases').html(html); 
	            }

	            get_new_cases_count();

	            $('#all-case-filter-btn').html('Search');
	            $('#all-case-filter-btn').attr('onclick','get_priority_cases(\'filter_input\')');
        	}
        }
    });
}

function get_new_cases_count() {
    var filter_input = $('#filter-input').val(),
        candidate_id_list = [];

    $('.case-filter').each(function() {
        candidate_id_list.push($(this).data("candidate_id"));
    });

    $.ajax({
        type : "POST",
        url : base_url+"factsuite-analyst/get-new-priority-cases-count",
        data : {
        	verify_analyst_request : 1,
            candidate_id_list : candidate_id_list,
            filter_input : filter_input
        },
        dataType: "json",
        success: function(data) {
            if (data.new_cases_count > 0) {
                $('#load-more-btn-div').html('<button class="send-btn mt-0 mr-0 btn-filter-search" id="load-more-btn" onclick="get_priority_cases(\'load_more\')">Load More</button>');
            } else {
                $('#load-more-btn-div').empty();
            }
        } 
    });
}

$('#filter-input').on('keyup', function() {
    var filter_input = $('#filter-input').val();
    if (filter_input == '') {
        get_priority_cases('filter_input');
    }
});

$('#filter-input').on('keypress', function(e) {
    var key = e.which;
    if (key == 13) {
        get_priority_cases('filter_input');
        return false;
    }
});

$('#load-more-btn').on('click', function() {
    get_priority_cases('load_more');
});