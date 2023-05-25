var time_count = 1;

load_role();

$('#team-submit-btn').on('click', function() {
	time_count = 1;
	clear_add_new_rule_input_fields();
	$('#add_holiday').modal('show');	
});

$('#sms-add-time').on('click', function() {
	add_new_time();
});

$('#edit-sms-add-time').on('click', function() {
    add_edit_new_time();
});

$("#end-status").on('change',function(){
	var val =  $(this).val(); 
	$("#interval-date-div").hide();
if (val != 'never') {
	$("#interval-date-div").show();
}
})
$("#edit-end-status").on('change',function(){
	var val =  $(this).val(); 
	$("#edit-interval-date-div").hide();
if (val != 'never') {
	$("#edit-interval-date-div").show();
}
})
$("#schedule-trigger").on('change',function(){
var val =  $(this).val(); 
if (val=='weekly') {
	$(".weeks").attr('checked',false);
	// $('#view-weeks').modal('show');
	$("#weeks-div").show();
	$("#div-months").hide();
			$("#multidates").show();
			$("#once-date-time").hide();
			$("#div-reminder-status").show();
}else if(val=='annually'){
		$("#weeks-div").hide();
		$("#div-months").hide();
			$("#multidates").show();
			$("#once-date-time").hide();
			$("#div-reminder-status").show();
}else if(val=='monthly'){
	$(".edit-months").attr('checked',false);
		$("#weeks-div").hide();
			$("#multidates").show();
			$("#div-months").show();
			$("#once-date-time").hide();
			$("#div-reminder-status").show();
}else if (val=='daily') {
$("#once-date-time").hide();
	$("#weeks-div").hide();
			$("#multidates").show();
			$("#div-months").hide();
			$("#div-reminder-status").show();
}else{

	$("#once-date-time").show();
	$("#weeks-div").hide();
			$("#multidates").hide();
			$("#div-months").hide();
			$("#div-reminder-status").hide();
			$("#interval-date-div").hide();
}
});
var count_total = 1;
$("#add-time-btn").on('click',function() {
	if (count_total <= 4) {
		var html_div ='';
		html_div +='<div class="col-sm-2">';
    html_div +='<label class="product-details-span-light">Time</label>';
    html_div +='<input type="time" class="fld times" name="time" id="time" placeholder="Select Date">';
    html_div +='<div id="time-error-msg-div"></div>  ';
  	html_div +='</div>';
  	count_total++;
  	$("#add-time-div").append(html_div)
	}
})

function add_new_time(request_from = '') {
	var is_true = 1,
			sleected_time_count = 0;
	$('.schedule-time-main-div').each(function() {
		sleected_time_count++;
	});

	if (sleected_time_count >= 5) {
		$('#max-time-add-error-msg-div').html('<span class="error-msg-small text-danger">Only max of 5 times can be added.</span>');
		return false;
	} else {
		$('#max-time-add-error-msg-div').html('');
	}
	if (clock_type == 1) {
		is_true = 0;
		$('.schedule-time-main-div').each(function() {
			var input_id = $(this).attr('id').split('-'),
				check_schedule_new_time = schedule_new_time(input_id[4]);

			if (check_schedule_new_time != 1) {
				is_true = 0;
			}
		});
	}
	// $('.schedule-new-time').each(function() {
	// 	var input_id = $(this).attr('id').split('-');
	// 	var check_schedule_new_time = schedule_new_time(input_id[2]);
	// 	if (check_schedule_new_time != 1) {
	// 		is_true = 0;
	// 	}
	// });
	
	if (request_from == '') {
		if(is_true == 1) {
			var variable_array = {};
				variable_array['id'] = time_count;
				variable_array['check_db_value'] = 0;
				variable_array['append'] = 1;
				variable_array['for_edit'] = 0;
			if (clock_type == 0) {
				variable_array['hrs-id'] = '#schedule-time-hrs-'+time_count;
				variable_array['min-id'] = '#schedule-time-min-'+time_count;
				variable_array['ampm-id'] = '#schedule-time-ampm-'+time_count;
			} else if (clock_type == 1) {
				variable_array['timepicker-id'] = '#schedule-time-'+time_count;
			}
			
			variable_array['ui-id'] = '#schedule-time-div';
			add_new_time_slot(variable_array);
			time_count++;
		}
	}

	return is_true;
}

function delete_time(id) {
	$('#schedule-time-main-div-'+id).remove();
}

function clear_add_new_rule_input_fields() {
	// $('#client-name, #case-type, #notification-name, #email-subject, #email-description, #rule-cirteria, #client-type').val('');
	// $('#add-new-rule-details-div').html('');
	time_count = 1;

	var variable_array = {};
		variable_array['id'] = 0;
		variable_array['check_db_value'] = 0;
		variable_array['append'] = 0;
		variable_array['for_edit'] = 0;
		variable_array['ui-id'] = '#schedule-time-div';
	if (clock_type == 0) {
		variable_array['hrs-id'] = '#schedule-time-hrs-0';
		variable_array['min-id'] = '#schedule-time-min-0';
		variable_array['ampm-id'] = '#schedule-time-ampm-0';
	} else if (clock_type == 1) {
		variable_array['timepicker-id'] = '#schedule-time-0';
	}
	add_new_time_slot(variable_array);
}

function add_new_time_slot(variable_array) {
	var id = variable_array['id'],
		edit_id = '',
		delete_btn_html = '',
		time_12_24_hr_format_class = ' timepicker-24-hr';

	if (variable_array['for_edit'] == 1) {
		edit_id = 'edit-';
	}

	if (clock_type == 1) {
		if (time_12_24_hr_format == 0) {
			time_12_24_hr_format_class = ' timepicker-12-hr';
		}
	}
	if (id != 0) {
    	delete_btn_html = '<span class="product-details-span-light product-details-span-light-small d-block">&nbsp;</span>';
    	delete_btn_html += '<button id="sms-add-time" class="btn btn-danger"';
    	if (variable_array['for_edit'] == 1) {
    		delete_btn_html += 'onclick="delete_edit_time('+id+')"';
    	} else {
    		delete_btn_html += 'onclick="delete_time('+id+')"';
    	}
    	delete_btn_html += '><i class="fa fa-trash"></i></button>';
    }
	var html = '<div class="col-md-5 '+edit_id+'schedule-time-main-div" id="'+edit_id+'schedule-time-main-div-'+id+'">';
		html += '<div class="row mt-3">';
	if (clock_type == 1) {
		html += '<div class="col-md-4">';
		html += '<span class="product-details-span-light product-details-span-light-small">Time</span>';
		html += '<input type="text" class="form-control'+time_12_24_hr_format_class+'" name="'+edit_id+'schedule-time-'+id+'" id="'+edit_id+'schedule-time-'+id+'" >';
	    html += '</div>';
	    html += '<div class="col-md-8">';
	    html += delete_btn_html;
	    html += '</div>';
	    html += '<div class="col-md-12" id="'+edit_id+'schedule-time-error-msg-div-'+id+'"></div>';
	    html += '</div></div>';

	    if (variable_array['append'] == 0) {
			$(variable_array['ui-id']).html(html);
	    } else {
	    	$(variable_array['ui-id']).append(html);
	    }
	} else if(clock_type == 0) {
		html += '<div class="col-md-3">';
		html += '<span class="product-details-span-light product-details-span-light-small">Hrs</span>';
		html += '<select class="form-control schedule-new-time-hrs schedule-time-select" name="'+edit_id+'schedule-time-hrs-'+id+'" id="'+edit_id+'schedule-time-hrs-'+id+'"></select>';
    	html += '</div>';
    	html += '<div class="col-md-3">';
		html += '<span class="product-details-span-light product-details-span-light-small">Min</span>';
		html += '<select class="form-control schedule-new-time-min schedule-time-select" name="'+edit_id+'schedule-time-min-'+id+'" id="'+edit_id+'schedule-time-min-'+id+'"></select>';
    	html += '</div>';
    	if (time_12_24_hr_format == 0) {
    		html += '<div class="col-md-3">';
			html += '<span class="product-details-span-light product-details-span-light-small">AM/PM</span>';
			html += '<select class="form-control schedule-new-time-ampm schedule-time-select" name="'+edit_id+'schedule-time-ampm-'+id+'" id="'+edit_id+'schedule-time-ampm-'+id+'"></select>';
	    	html += '</div>';
	    }
	    html += '<div class="col-md-3">';
	    html += delete_btn_html;
	    html += '</div>';
	    html += '</div></div>';

    	if (variable_array['append'] == 0) {
			$(variable_array['ui-id']).html(html);
    	} else {
    		$(variable_array['ui-id']).append(html);
    	}
		get_hours(variable_array);
		get_minutes(variable_array);
		if (time_12_24_hr_format == 0) {
			get_ampm(variable_array);
		}
	}
}

var edit_count_total = 1;
$("#add-time-btn").on('click',function() {
	if (edit_count_total <= 4) {
		var html_div ='';
		html_div +='<div class="col-sm-2">';
	    html_div +='<label class="product-details-span-light">Time</label>';
	    html_div +='<input type="time" class="fld edit-times" name="edit-time" id="edit-time" placeholder="Select Date">';
	    html_div +='<div id="time-error-msg-div"></div>  ';
	  	html_div +='</div>';
	  	edit_count_total++;
	  	$("#edit-add-time-div").append(html_div)
	}
});

function add_edit_new_time(request_from = '') {
   var is_true = 1,
		sleected_time_count = 0;
	$('.edit-schedule-time-main-div').each(function() {
		sleected_time_count++;
	});

	if (sleected_time_count >= 5) {
		$('#edit-max-time-add-error-msg-div').html('<span class="error-msg-small text-danger">Only max of 5 times can be added.</span>');
		return false;
	} else {
		$('#edit-max-time-add-error-msg-div').html('');
	};
    // $('.edit-schedule-new-time').each(function() {
    //     var input_id = $(this).attr('id').split('-');
    //     var check_schedule_new_time = schedule_edit_new_time(input_id[3]);
    //     if (check_schedule_new_time != 1) {
    //         is_true = 0;
    //     }
    // });
    if (clock_type == 1) {
        is_true = 0;
        $('.edit-schedule-time-main-div').each(function() {
            var input_id = $(this).attr('id').split('-'),
                check_schedule_new_time = schedule_new_time(input_id[5]);

            if (check_schedule_new_time != 1) {
                is_true = 0;
            }
        });
    }

    if (request_from == '') {
        if(is_true == 1) {
            var variable_array = {};
                variable_array['id'] = time_count;
                variable_array['check_db_value'] = 0;
                variable_array['append'] = 1;
                variable_array['for_edit'] = 1;
            if (clock_type == 0) {
                variable_array['hrs-id'] = '#edit-schedule-time-hrs-'+time_count;
                variable_array['min-id'] = '#edit-schedule-time-min-'+time_count;
                variable_array['ampm-id'] = '#edit-schedule-time-ampm-'+time_count;
            } else if (clock_type == 1) {
                variable_array['timepicker-id'] = '#edit-schedule-time-'+time_count;
            }
            variable_array['ui-id'] = '#edit-schedule-time-div';
            add_new_time_slot(variable_array);
            time_count++;
        }
    }

    return is_true;
}

function delete_edit_time(id) {
    $('#edit-schedule-time-main-div-'+id).remove();
    $('#edit-schedule-new-time-delete-div-'+id).remove();
}

$("#edit-schedule-trigger").on('change',function(){
var val =  $(this).val(); 
if (val=='weekly') {
	$(".weeks").attr('checked',false);
	// $('#view-weeks').modal('show');
	$("#edit-weeks-div").show();
	$("#edit-div-months").hide();
			$("#edit-multidates").show();
			$("#edit-once-date-time").hide();
			$("#edit-div-reminder-status").show();
}else if(val=='annually'){
		$("#edit-weeks-div").hide();
		$("#edit-div-months").hide();
			$("#edit-multidates").show();
			$("#edit-once-date-time").hide();
			$("#edit-div-reminder-status").show();
}else if(val=='monthly'){
	$(".edit-months").attr('checked',false);
		$("#edit-weeks-div").hide();
			$("#edit-multidates").show();
			$("#edit-div-months").show();
			$("#edit-once-date-time").hide();
			$("#edit-div-reminder-status").show();
}else if (val=='daily') {
$("#edit-once-date-time").hide();
	$("#edit-weeks-div").hide();
			$("#edit-multidates").show();
			$("#edit-div-months").hide();
			$("#edit-div-reminder-status").show();
}else{

	$("#edit-once-date-time").show();
	$("#edit-weeks-div").hide();
			$("#edit-multidates").hide();
			$("#edit-div-months").hide();
			$("#edit-div-reminder-status").hide();
			$("#edit-interval-date-div").hide();
}
});

$('#component_name').on('keyup blur',function(){
	var component_name = $('#component_name').val(); 
	if (component_name != '') {
		$('#component-name-error-msg-div').html('');
	} else {
		$('#component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
	}
}); 

$('#component_price').on('keyup blur',function(){
	var component_price = $('#component_price').val(); 
	if (component_price != '') {
		$('#component-price-error-msg-div').html('');
	} else {
		$('#component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component price.</span>');
	}
}); 


$('#edit_component_name').on('keyup blur',function(){
	var edit_component_name = $('#edit_component_name').val(); 
	if (edit_component_name != '') {
		$('#edit-component-name-error-msg-div').html('');
	} else {
		$('#edit-component-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component name.</span>');
	}
}); 

$('#edit_component_price').on('keyup blur',function(){
	var edit_component_price = $('#edit_component_price').val(); 
	if (edit_component_price != '') {
		$('#edit-component-price-error-msg-div').html('');
	} else {
		$('#edit-component-price-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the component price.</span>');
	}
}); 

function load_role() {
	sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"ScheduleReport/get_schedule_details", 
	  	dataType: "json",
	  	success: function(data) { 
	  		// console.log(JSON.stringify(data));
			let html='';
      		if (data.length > 0) {
	        	var j = 1;
	        	for (var i = 0; i < data.length; i++) { 
		        	// var components = JSON.parse(data[i]['component_name']);
		        	var date_time = '';
		        	if (data[i]['schedule_date_times'] !=null) {
		        		date_time = data[i]['schedule_date_time'].split(' ')[1];
		        	}
		        	html += '<tr>'; 
		        	html += '<td>'+j+'</td>';
		        	html += '<td>'+data[i]['schedule_date_times']+'</td>'; 
		        	html += '<td>'+data[i]['mail_subject']+'</td>'; 
		        	html += '<td>'+data[i]['mail_message_body']+'</td>'; 
		        	html += '<td><a  onclick="edit_holiday('+data[i]['schedule_id']+')"  href="javascript:void(0)"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</div><a onclick="removeData('+data[i]['schedule_id']+')" href="#"><i class="fa fa-trash"></i></td>';  
		        	html += '</tr>'; 
					 
		          j++; 
	        	}
	      	} else {
	        	html+='<tr><td colspan="2" class="text-center">No dates found.</td></tr>'; 
	    	}
	    	$('#get-team-data').html(html); 
	  	} 
	});
}

function schedule_new_time(id) {
	var variable_array = {};
	variable_array['input_id'] = '#schedule-time-'+id;
	variable_array['error_msg_div_id'] = '#schedule-time-error-msg-div-'+id;
	variable_array['empty_input_error_msg'] = 'Please add the time';
	return mandatory_any_input_with_no_limitation(variable_array);
}

function schedule_edit_new_time(id) {
    var variable_array = {};
    variable_array['input_id'] = '#edit-schedule-time-'+id;
    variable_array['error_msg_div_id'] = '#edit-schedule-time-eror-msg-div-'+id;
    variable_array['empty_input_error_msg'] = 'Please add the time';
    return mandatory_any_input_with_no_limitation(variable_array);
}

function addreporting() {
	var date_time = $("#date-time").val();
	var subject = $("#subject").val();
	var message = $("#message").val();
	var trigger = $("#schedule-trigger").val();
	var name = $("#report-name").val(); 
	var time = $("#time").val();
	var client_id = $("#client-id").val();
	var client_email = $("#client-id").find(':selected').attr('data-spoc');
	var fields = [];
	$(".report-fields:checked").each(function(){
		fields.push({name:$(this).data('field_name'),field:$(this).val()});
	});
	var times = [];
	$(".times").each(function() {
		if ($(this).val() != null && $(this).val() !='') {
			times.push($(this).val());
		}
	});

	$('.schedule-time-main-div').each(function() {
		var input_id = $(this).attr('id').split('-');
		if (time_12_24_hr_format == 1) {
			scheduled_time = $('#schedule-time-hrs-'+input_id[4]).val()+':'+$('#schedule-time-min-'+input_id[4]).val();
		} else {
			scheduled_time = $('#schedule-time-hrs-'+input_id[4]).val()+':'+$('#schedule-time-min-'+input_id[4]).val()+' '+$('#schedule-time-ampm-'+input_id[4]).val();
		}
		
		times.push(scheduled_time);
	});

	var selected_dates = $("#multi-select-date").val();
	var weeks = [];
	if (trigger == 'weekly') { 
		$(".weeks:checked").each(function(){
			weeks.push($(this).val());
		});
	} 
	var months = [];
	/*if (trigger == 'monthly') { 
		$(".months:checked").each(function(){
			months.push($(this).val());
		});
	}*/
	var additional = $("#additional-email").val();
	var end_status = $("#end-status").val();
	var end_interval = $("#end-interval").val();
	var week_reminder = $("#week-reminder").val();
	var month_weeks = $("#month-weeks").val();

	if( subject !='' && message !='' && fields.length > 0) {
		$.ajax({
			type: "POST",
	  		url: base_url+"ScheduleReport/add_reporting",
		  	data:{
		  		date_time:date_time,
		  		subject:subject,
		  		message:message,
		  		trigger:trigger,
		  		name:name,
		  		time:times.toString(),
		  		end_status:end_status,
		  		end_interval:end_interval,
		  		week_reminder:week_reminder,
		  		month_weeks:month_weeks,
		  		client_id:client_id,
		  		client_email:client_email,
		  		selected_dates:selected_dates,
		  		additional:additional,
		  		weeks:weeks.toString(),
		  		months:months.toString(),
		  		fields:JSON.stringify(fields),
		  		time_12_24_hr_format : time_12_24_hr_format,
		  		clock_type : clock_type
		  	},
		  	dataType: "json",
		  	success: function(data) {
		   		$('#add_holiday').modal('hide'); 	
		        if (data.status == '1') {
		        	load_role();
		        	$("#date-time").val('');
					$("#subject").val('');
					$("#message").val('');
					$("#report-name").val('');
					$("#schedule-trigger").val('');
					$(".report-fields").attr('checked',false);
					$("#additional-email").val();
					$("#end-status").val('');
					$("#end-interval").val('');
					$("#week-reminder").val('');
					$("#month-weeks").val('');

					var html_div ='';
						html_div +='<div class="col-sm-2">';
					    html_div +='<label class="product-details-span-light">Time</label>';
					    html_div +='<input type="time" class="fld times" name="time" id="time" placeholder="Select Date">';
					    html_div +='<div id="time-error-msg-div"></div>  ';
					  	html_div +='</div>'; 
						 $("#add-time-div").html(html_div)
		        	 
			        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
			        toastr.success('Reporing has been successfully inserted.');
				} else {
			        toastr.error('Something went wrong with inserting the data. Please try again.');
				} 
		    },
		    error: function(data) { 
		    	toastr.error('Something went wrong with inserting the data. Please try again.');
		    }
	  	});
	} else {
		if(date_time != '') {
			$('#date-time-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the Details.</span>');
		}
	}
	
}

var getKeyByLanguages = function(obj, lang) {
    var returnKey = -1;
    $.each(obj, function(key, info) {
        if (info.field == lang) {
           returnKey = key;
            return false; 
        };   
    });
    
    return returnKey;
}

function edit_holiday(id) { 
  $('#edit_holiday').modal('show');
  $.ajax({
    type: "POST",
    url: base_url+"ScheduleReport/get_single_schedule_details/"+id, 
    dataType: "json",
    success: function(data){ 
    	// console.log(JSON.stringify(data));
      	$("#edit-date-time").val(data.report.schedule_date_time);
      	$("#edit-multi-select-date").val(data.report.selected_dates);
		$("#edit-subject").val(data.report.mail_subject);
		$("#edit-message").val(data.report.mail_message_body);
		$("#edit-time").val(data.report.interval_time);
		var name = $("#edit-report-name").val(data.report.report_name);
		var name = $("#edit-client-id").data(data.report.client_id);
      	$('#edit_schedule_id').val(id); 

      	$("#edit-additional-email").val(data.report.additional_email);
		$("#edit-end-status").val(data.report.end_status);
		$("#edit-end-interval").val(data.report.end_interval);
		$("#edit-week-reminder").val(data.report.week_reminder_type);
		$("#edit-month-weeks").val(data.report.monthly_week);
		$("#edit-interval-date-div").hide()
		if (data.report.end_status =='date') {
			$("#edit-interval-date-div").show()
		}
		html_div ='';
		var in_time = data.report.interval_time.split(',');

		var variable_array = {};
          	variable_array['check_db_value'] = 1;
          	variable_array['append'] = 1;    
          	variable_array['for_edit'] = 1;
          	variable_array['ui-id'] = '#edit-schedule-time-div';
      	$('#edit-schedule-time-div').html('');
			for (var i = 0; i < in_time.length; i++) {
				// html_div +='<div class="col-sm-2">';
			    // html_div +='<label class="product-details-span-light">Time</label>';
			    // html_div +='<input type="time" class="fld edit-times" value="'+in_time[i]+'" name="edit-time" id="edit-time" placeholder="Select Date">';
			    // html_div +='<div id="time-error-msg-div"></div>  ';
			  	// html_div +='</div>';
			  	var selected_time = '';
			  	if (time_12_24_hr_format == 0) {
			  		selected_time = check_and_change_time_format(in_time[i]);
			  	} else {
			  		selected_time = in_time[i];
			  	}
		  		selected_time = selected_time.split(' ');
      			time = selected_time[0].split(':');
      			variable_array['id'] = i;
	      		if (clock_type == 0) {
	          		variable_array['hrs-id'] = '#edit-schedule-time-hrs-'+i;
	          		variable_array['min-id'] = '#edit-schedule-time-min-'+i;
	          		if (time_12_24_hr_format == 0) {
	          			variable_array['ampm-id'] = '#edit-schedule-time-ampm-'+i;
	          		}
	      		} else if (clock_type == 1) {
	          		variable_array['timepicker-id'] = '#edit-schedule-time-0';
	      		}
	          	variable_array['selected-hrs'] = time[0];
	          	variable_array['selected-min'] = time[1];
	          	if (time_12_24_hr_format == 0) {
	          		variable_array['selected-ampm'] =  selected_time[1];
	          	}
	      		add_new_time_slot(variable_array);
			}
			time_count = in_time.length;
			// $("#edit-add-time-div").html(html_div)

	      	var report_field = JSON.parse(data.report.report_fields);
	      	 
	  		var html = '';
	  		for (var i = 0; i < data.fields.length; i++) { 
	  			var ind = getKeyByLanguages(report_field,data.fields[i]['field']);
	  			$select = '';
	  			if (ind != -1) {
	  				$select = 'checked';
	  			}
	  		 	html +='<div class="custom-control custom-checkbox custom-control-inline">';
	        	html +='<input '+$select+' type="checkbox" class="custom-control-input edit-report-fields" data-field_name="'+data.fields[i]['name']+'" value="'+data.fields[i]['field']+'" name="c-ustomCheck" id="c-ustomCheck'+(i)+'">';
	        	html +='<label class="custom-control-label" for="c-ustomCheck'+(i)+'">'+data.fields[i]['name']+'</label>';
	     		html +='</div>';
	  		}
	  		// $(".edit-weeks").attr("checked",false);
	      	// $(".edit-months").attr("checked",false);
	      	$("#edit-schedule-trigger").val(data.report.interval_type)
	      	if (data.report.interval_type == 'weekly') { 
	      		$("#edit-weeks-div").show();
	      		if (data.report.selected_weeks !='' && data.report.selected_weeks !=null) {
	      		var selected_weeks = data.report.selected_weeks.split(',');
	      			for (var i = 0; i < selected_weeks.length; i++) {
	      				
	      				$(".edit-weeks").filter({"value":selected_weeks[i]}).attr("checked",true); 
	      			}
	      		}
	      	}
	      	if (data.report.interval_type == 'monthly') { 
						$("#edit-div-months").show();
						if (data.report.selected_months !='' && data.report.selected_months !=null) {
	      		var selected_months = data.report.selected_months.split(',');
	      			for (var i = 0; i < selected_months.length; i++) {
	      				
	      				$(".edit-months").filter({"value":selected_months[i]}).attr("checked",true); 
	      			}
	      		}
	      	} 

	      	if (data.report.interval_type != 'once') { 
				$("#edit-multidates").show();
				$('#edit-multi-select-date').val(data.report.selected_dates);
	      	}

	      	if (data.report.interval_type == 'once') { 
				$("#edit-div-reminder-status").hide();
				$("#edit-once-date-time").show(); 
	      	} else {
	      		$("#edit-div-reminder-status").show();
	      		$("#edit-once-date-time").hide(); 
	      	}

	      	var client = '';
	      	if (data.client.length > 0) {
	      		for (var i = 0; i < data.client.length; i++) {
	      			var select ='';
	      			if (data.client[i].client_id == data.report.client_id && data.client[i].spoc_email_id == data.report.client_email) {
	      				select = 'selected';
	      			}
	      			client += '<option '+select+' value="'+data.client[i].client_id+'" data-spoc="'+data.client[i].spoc_email_id+'">'+data.client[i].client_name+' ('+data.client[i].spoc_email_id+')</option>';
	      		}
	      	}

	      	$("#edit-client-id").html(client);
	      	$("#edit-reporting-fields").html(html);
	    }
  	});
}

function updateData() {
	var date_time = $("#edit-date-time").val();
	var subject = $("#edit-subject").val();
	var message = $("#edit-message").val();
	var schedule_id = $("#edit_schedule_id").val();
	var trigger = $("#edit-schedule-trigger").val();
	var name = $("#edit-report-name").val();
	var time = $("#edit-time").val();
	var client_id = $("#edit-client-id").val();
	var client_email = $("#edit-client-id").find(':selected').attr('data-spoc');

	var fields = [];
	$(".edit-report-fields:checked").each(function() {
		fields.push({name:$(this).data('field_name'),field:$(this).val()});
	});

	var times = [];
	$('.edit-schedule-time-main-div').each(function() {
	    var input_id = $(this).attr('id').split('-');
	    if (time_12_24_hr_format == 1) {
			scheduled_time = $('#edit-schedule-time-hrs-'+input_id[5]).val()+':'+$('#edit-schedule-time-min-'+input_id[5]).val();
		} else {
			scheduled_time = $('#edit-schedule-time-hrs-'+input_id[5]).val()+':'+$('#edit-schedule-time-min-'+input_id[5]).val()+' '+$('#edit-schedule-time-ampm-'+input_id[5]).val();
		}
	    times.push(scheduled_time);
	});
	// $(".edit-times").each(function(){
	// 	if ($(this).val() !='' && $(this).val() !=null) { 
	// 			times.push($(this).val());
	// 	}
	// 		});

	var selected_dates = $("#edit-multi-select-date").val();
	var weeks = [];
	if (trigger == 'weekly') { 
		$(".edit-weeks:checked").each(function() {
			weeks.push($(this).val());
		});
	} 
	var months = [];
	if (trigger == 'monthly') { 
		$(".edit-months:checked").each(function() {
			months.push($(this).val());
		});
	}

	var end_status = $("#edit-end-status").val();
	var end_interval = $("#edit-end-interval").val();
	var week_reminder = $("#edit-week-reminder").val();
	var month_weeks = $("#edit-month-weeks").val();
	var additional = $("#edit-additional-email").val();

	if(date_time != '' && subject != '' && message != '') {
		$.ajax({
			type: "POST",
	  		url: base_url+"ScheduleReport/update_reporting",
	  		data: {
		  		schedule_id:schedule_id,
		  		date_time:date_time,
		  		subject:subject,
		  		message:message,
		  		trigger:trigger,
		  		name:name,
		  		client_id:client_id,
		  		client_email:client_email,
		  		time:times.toString(),
		  		selected_dates:selected_dates,
		  		end_status:end_status,
		  		end_interval:end_interval,
		  		week_reminder:week_reminder,
		  		month_weeks:month_weeks,
		  		additional:additional,
		  		weeks:weeks.toString(),
		  		months:months.toString(),
		  		fields:JSON.stringify(fields),
		  		time_12_24_hr_format : time_12_24_hr_format,
		  		clock_type : clock_type
		  	},
		  	dataType: "json",
	  		success: function(data) {
	   			$('#edit_holiday').modal('hide'); 	
	        	if (data.status == '1') {
	        		load_role();
	        		$("#edit-date-time").val('');
					$("#edit-subject").val('');
					$("#edit-message").val('');
	        	 
		        	// $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        	toastr.success('Reporing has been successfully updated.');
				} else {
		        	toastr.error('Something went wrong with updating the data. Please try again.');
				}
	    	},
	    	error: function(data) {
	    		toastr.error('Something went wrong with updating the data. Please try again.');
	    	}
	  	});
	} else {
		if(date_time != '') {
			$('#date-time-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the Details.</span>');
		}
	}
}

function removeData(id){
		$.ajax({
	    type: "POST",
	    url: base_url+"ScheduleReport/remove_schedule/"+id, 
	    dataType: "json",
	    contentType: false,
		processData: false,
	    success: function(data){
	   		// $('#edit_component').modal('hide'); 	
	        if (data.status == '1') {
	        	load_role();
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('Schedule Reporting has been successfully deleted.');
			} else {
		         
		        toastr.error('Something went wrong with deleting the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	// $('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with deleting the data. Please try again.');
	    } 
	  });
}

function get_hours(variable_array) {
	var max_hours = 12;
	if (time_12_24_hr_format == 1) {
		max_hours = 23;
	}
	for (var i = 0; i <= max_hours; i++) {
		var value = i;
		if (i >= 0 && i <= 9) {
			value = '0'+i;
		}
		var selected = '';
		if (variable_array['check_db_value'] == 1) {
			if (variable_array['selected-hrs'] == value) {
				selected = ' selected';
			}
		}
		$(variable_array['hrs-id']).append('<option'+selected+' value="'+value+'">'+value+'</option>');
	}
}

function get_minutes(variable_array) {
	for (var i = 0; i <= 59; i++) {
		var value = i;
		if (i >= 0 && i <= 9) {
			value = '0'+i;
		}
		var selected = '';
		if (variable_array['check_db_value'] == 1) {
			if (parseInt(variable_array['selected-min']) == parseInt(value)) {
				selected = ' selected';
			}
		}
		$(variable_array['min-id']).append('<option'+selected+' value="'+value+'">'+value+'</option>');
	}
}

function get_ampm(variable_array) {
	var am_selected = '',
		pm_selected = '';
	if (variable_array['check_db_value'] == 1) {
		if (variable_array['selected-ampm'].toLowerCase() == 'am') {
			am_selected = ' selected';
		} else {
			pm_selected = ' selected';
		}
	}
	var html = '<option'+am_selected+' value="am">AM</option>';
		html += '<option'+pm_selected+' value="pm">PM</option>';
	$(variable_array['ampm-id']).html(html);
}

function check_and_change_time_format(in_time) {
	var time = in_time.split(':');
	var hrs = time[0] > 12 ? time[0] - 12 : time[0];
	var am_pm = time[0] >= 12 ? 'PM' : 'AM';

	if (hrs < 10) {
		hrs = '0'+hrs;
	}
	return hrs+':'+time[1]+' '+am_pm;
}