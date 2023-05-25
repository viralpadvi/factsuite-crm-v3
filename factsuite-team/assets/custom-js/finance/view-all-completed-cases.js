$('#action-status').on('change', function() {
    get_all_selected_case_print();
});

$('#filter-cases-client-list').on('change', function() {
    get_all_completed_cases('client_search');
});

$('#filter-input').on('keyup', function() {
    var filter_input = $('#filter-input').val();
    if (filter_input == '') {
        get_all_completed_cases('filter_input');
    }
});

$('#filter-input').on('keypress', function(e) {
    var key = e.which;
    if (key == 13) {
        get_all_completed_cases('filter_input');
        return false;
    } 
});

$('#load-more-btn').on('click', function() {
    get_all_completed_cases('load_more');
});

$('#bulk-check-cases').on('click', function() {
    $('.candidate-list').prop('checked',false);
    if (this.checked == true) {
        var id = [];
        $('.candidate-list').each(function(i) {
            id[i] = $(this).val();
        });
        var check_length = id.length;
        // if (id.length > max_select_id_for_bulk_upload) {
        //    check_length = max_select_id_for_bulk_upload;
        // }

        for (var i = 0; i < check_length; i++) {
            $('#ids-'+id[i]).prop('checked',true);
        }
    } else {
        $('.candidate-list').prop('checked',false);
    }
});

get_filter_number_list();
function get_filter_number_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-finance/get-custom-filter-number-list", 
        dataType: "json",
        data : {
            verify_finance_request : 1
        },
        success: function(data) {
            var html = '';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i]+'">'+data[i]+'</option>';
            }
            $('#filter-cases-number').html(html);
            get_all_completed_cases();
        } 
    });
}

get_custom_actions_list();
function get_custom_actions_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-finance/get-custom-actions-list", 
        dataType: "json",
        data : {
            verify_finance_request : 1
        },
        success: function(data) {
            var html = '<option value="">Select</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i].code+'">'+data[i].name+'</option>';
            }
            $('#action-status').html(html);
        } 
    });
}

get_client_list();
function get_client_list() {
    $.ajax({
        type : "POST",
        url : base_url+"factsuite-finance/get-all-clients",
        data : {
            verify_finance_request : 1
        },
        dataType: "json",
        success: function(data) {
            var html = '<option value="" selected>All Clients</option>';
            if(data.all_clients.length > 0) {
                all_clients = data.all_clients;
                for (var i = 0; i < all_clients.length; i++) {
                    html += '<option value="'+all_clients[i].client_id+'">'+all_clients[i].client_name+'</option>';
                }
            }
            $('#filter-cases-client-list').html(html);
        } 
    });
}

function get_all_completed_cases(request_from = '') {
    $('#load-more-btn').html('<div class="spinner-border text-light spinner-border-load-more"></div>');
    $('#load-more-btn').removeAttr('onclick'); 

    if (request_from == 'filter_input' || request_from == 'client_search') {
        $('#get-case-data').html('');
        $('#all-case-filter-btn').html('<div class="spinner-border text-light spinner-border-load-more"></div>');
        $('#all-case-filter-btn').removeAttr('onclick');
    }

    var filter_number = $('#filter-cases-number').val(),
        filter_input = $('#filter-input').val(),
        client_list = $('#filter-cases-client-list').val(),
        candidate_id_list = [],
        candidate_numbers_shown = [];
    
    if (client_list.length == 0 || client_list == '') {
        client_list = '';
    }

    $('.case-filter').each(function() {
        candidate_id_list.push($(this).data("candidate_id"));
    });

    $('.case-filter').each(function() {
        candidate_numbers_shown.push($(this).data("candidate_display_number"));
    });


    

    $('#get-case-data').append('<tr id="spinner-indicator"><td colspan="8" class="text-center"><div class="spinner-border text-primary spinner-border-load-more"></div></td></tr>');
 var from = $("#from").val();
    var to = $("#to").val();
    var cases_type = $("#type-cases").val();
     
	$.ajax({
        type: "POST",
        url: base_url+"factsuite-finance/get-all-completed-cases", 
        dataType: "json",
        data : {
            candidate_id_list : candidate_id_list,
            client_list : client_list,
            filter_limit : filter_number,
            filter_input : filter_input,
            request_from : request_from,
            from : from,
            to : to,
            cases_type : cases_type,
            case_required_type : ['2'],
        },
        success: function(all_data) {
            let html = '',
                count = 1,
                data = all_data.all_cases,
                selected_datetime_format = all_data.selected_datetime_format;

            if (candidate_id_list.length > 0) {
                count = candidate_id_list.length + 1;
            }

            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) { 
                    var status = '<span class="text-success">Completed</span>',
                        classStatus = '',
                        fontAwsom = '<i class="fa fa-check">',
                        all_client_packages = JSON.parse(data[i].all_client_packages),
                        total_amount = 0;

                    for (var j = 0; j < all_client_packages.length; j++) {
                        if (all_client_packages[j].package_id == data[i].selected_package_id) {
                            var form_data = all_client_packages[j].form_data;
                            for (var k = 0; k < form_data.length; k++) {
                                form_value = (form_data[k].form_value != '') ? form_data[k].form_value : 0;
                                total_amount += parseFloat(form_value);
                            }
                        }
                    }

                    if (data[i]['case_submitted_date'] !=null && data[i]['case_submitted_date'] !='') {
                       $submitted_date = data[i]['case_submitted_date'];
                       // $submitted_date = data[i]['case_submitted_date'].split(' ')[0];
                    }else{
                       $submitted_date = data[i]['tat_start_date'];  
                       // $submitted_date = data[i]['tat_start_date'].split(' ')[0];  
                    }

                    html += '<tr class="case-filter" id="tr_'+data[i].candidate_id+'" data-candidate_id="'+data[i].candidate_id+'" data-candidate_display_number="'+count+'">';
                    html += '<td id="candidate_check'+data[i].candidate_id+'"><span class="tbody-th-span"><input type="checkbox" class="checkbox candidate-list" id="ids-'+data[i].candidate_id+'" name="ids[]" value="'+data[i].candidate_id+'"></span></td>';
                    html += '<td id="first_name'+data[i].candidate_id+'">'+count+'</td>';
                    html += '<td id="first_name'+data[i].candidate_id+'">'+data[i].candidate_id+'</td>';
                    html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
                    html += '<td id="client_name_'+data[i].candidate_id+'">'+data[i]['client_name']+'</td>';
                    html += '<td id="start_date'+data[i].candidate_id+'">'+moment($submitted_date).format(selected_datetime_format['js_code'])+'</td>';
                    html += '<td id="report_generated_date'+data[i].candidate_id+'">'+moment(data[i]['report_generated_date']).format(selected_datetime_format['js_code'])+'</td>';
                    html += '<td id="total_amount_'+data[i].candidate_id+'"><i class="fa fa-inr pr-1"></i>'+total_amount+'</td>';
                    html += '<td class"'+classStatus+'" id="status'+data[i].candidate_id+'">'+status+'</td>';
                    html += '<td class="text-center" id="genrate_'+data[i].candidate_id+'"><a id="genrate_report_'+data[i].candidate_id+'"  href="'+base_url+'factsuite-finance/view-case-details/'+data[i].candidate_id+'?request_from=ready-for-billing-cases"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                    html += '</tr>';
                    count++;
                }
            } else {
                if(request_from != 'load_more') {
                    html += '<tr><td colspan="8" class="text-center">No Case Found.</td></tr>'; 
                }
            }
            $('#spinner-indicator').remove();

            if ('load_more') {
                $('#get-case-data').append(html); 
            } else {
                $('#get-case-data').html(html); 
            }

            get_new_cases_count();

            $('#all-case-filter-btn').html('Search');
            $('#all-case-filter-btn').attr('onclick','get_all_completed_cases(\'filter_input\')');
        } 
    });
}

function get_new_cases_count() {
    var filter_input = $('#filter-input').val(),
        client_list = $('#filter-cases-client-list').val(),
        candidate_id_list = [];

    $('.case-filter').each(function() {
        candidate_id_list.push($(this).data("candidate_id"));
    });

    if (client_list.length == 0 || client_list == '') {
        client_list = '';
    }

    $.ajax({
        type : "POST",
        url : base_url+"factsuite-finance/get-new-cases-count",
        data : {
            candidate_id_list : candidate_id_list,
            filter_input : filter_input,
            client_list : client_list,
            case_required_type : ['2']
        },
        dataType: "json",
        success: function(data) {
            if (data.new_cases_count > 0) {
                $('#load-more-btn-div').html('<button class="send-btn mt-0 mr-0 btn-filter-search mt-2" id="load-more-btn" onclick="get_all_completed_cases(\'load_more\')">Load More</button>');
            } else {
                $('#load-more-btn-div').empty();
            }
        } 
    });
}

function get_all_selected_case_print() {
    var action = $("#action-status").val(),
        cases = [];
    
    $(".candidate-list:checked").each(function() {
        cases.push($(this).val());
    });

    if (cases.length > 0) {
       
        if (action == 'create_summary') {
            window.location.href = base_url+"factsuite-finance/get-finance-bills?cases="+btoa(cases);
        }else if (action == 'create_summary_status') {
             window.location.href = base_url+"factsuite-finance/get-finance-status?cases="+btoa(cases);
        }else if (action == 'create_summary_status_price') {
             window.location.href = base_url+"factsuite-finance/get-finance-status-and-price?cases="+btoa(cases);
        }
    } else {
        $("#action-status").val('');
        toastr.warning('Please select atlease one case.');
        // get_custom_actions_list();
    }
}