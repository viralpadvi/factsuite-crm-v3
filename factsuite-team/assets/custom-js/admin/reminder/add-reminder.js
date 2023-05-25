

$("#sechedule-time").on('click',function(){
	$(".remove_class").remove();

sms = 0;
email = 0;
ivrs = 0;
	$("#sechedule-time-model").modal('show');
}); 
var i = 1;
$("#click-to-schedule-btn").on('click',function(){
/*	schedule-days
schedule-date
schedule-time
schedule-sms
schedule-email
schedule-ivrs
*/
var schedule_days = $("#schedule-days").val();
var schedule_date = $("#schedule-date").val();
// var schedule_time = $("#schedule-time").val();
var sms_time =[];
$(".sms_time").each(function(){
sms_time.push($(this).val());
});
var email_time =[];
$(".email_time").each(function(){
email_time.push($(this).val());
});
var ivrs_time =[];
$(".ivrs_time").each(function(){
ivrs_time.push($(this).val());
});

var schedule_time = sms_time.toString();
var email_schedule_time = email_time.toString();
var ivrs_schedule_time = ivrs_time.toString();
// var email_schedule_days = $("#email-schedule-days").val();
var email_schedule_date = $("#email-schedule-date").val();
// var email_schedule_time = $("#email-schedule-time").val();

// var ivrs_schedule_days = $("#ivrs-schedule-days").val();
var ivrs_schedule_date = $("#ivrs-schedule-date").val();
// var ivrs_schedule_time = $("#ivrs-schedule-time").val();

var schedule_sms = $("#schedule-sms:checked").val();
var schedule_email = $("#schedule-email:checked").val();
var schedule_ivrs = $("#schedule-ivrs:checked").val();


if (schedule_sms =='undefined' || schedule_sms ==null) {
	schedule_sms ='false';
}
if (schedule_email =='undefined' || schedule_email ==null) {
	schedule_email ='false';
}
if (schedule_ivrs =='undefined' || schedule_ivrs ==null) {
	schedule_ivrs ='false';
}
var html ='';

if (
	schedule_days =='' &&
schedule_date =='' &&
schedule_time =='' &&
(schedule_sms =='' ||
schedule_email =='' ||
schedule_ivrs =='')
	) {
	return false;
}

if (
	// email_schedule_days =='' &&
email_schedule_date =='' &&
email_schedule_time =='' &&
(schedule_sms =='' ||
schedule_email =='' ||
schedule_ivrs =='')
	) {
	return false;
}

if (
	// ivrs_schedule_days =='' &&
ivrs_schedule_date =='' &&
ivrs_schedule_time =='' &&
(schedule_sms =='' ||
schedule_email =='' ||
schedule_ivrs =='')
	) {
	return false;
}

var schedule_days_marge =  schedule_days;
var schedule_date_marge = 'SMS -'+schedule_date+' <br>Email - '+email_schedule_date
var schedule_time_marge = 'SMS -'+schedule_time+' <br>Email - '+email_schedule_time

html +="<tr>";
html +="<td>"+ i++ +"</td>";
html +="<td><input type='hidden' value='"+schedule_days+"' class='schedule_days'>"+ schedule_days_marge +"</td>";
html +="<td class='d-none'><input type='hidden' value='"+schedule_date+"' class='schedule_date'><input type='hidden' value='"+email_schedule_date+"' class='email_schedule_date'><input type='hidden' value='"+ivrs_schedule_date+"' class='ivrs_schedule_date'>"+ schedule_date_marge +"</td>";
html +="<td><input type='hidden' value='"+schedule_time+"' class='schedule_time'><input type='hidden' value='"+email_schedule_time+"' class='email_schedule_time'><input type='hidden' value='"+ivrs_schedule_time+"' class='ivrs_schedule_time'>"+ schedule_time_marge +"</td>";
html +="<td><input type='hidden' value='"+schedule_sms+"' class='schedule_sms'>"+ schedule_sms +"</td>";
html +="<td><input type='hidden' value='"+schedule_email+"' class='schedule_email'>"+ schedule_email +"</td>";
// html +="<td><input type='hidden' value='"+schedule_ivrs+"' class='schedule_ivrs'>"+ schedule_ivrs +"</td>";
html +="</tr>";

$("#all-schedule-list").append(html);

$("#schedule-days").val('');
$("#schedule-date").val('');
$("#schedule-time").val('');
$("#schedule-days").val('');
$("#email-schedule-date").val('');
$("#email-schedule-time").val('');
$("#email-schedule-days").val('');
$("#ivrs-schedule-date").val('');
$("#ivrs-schedule-time").val('');
$("#ivrs-schedule-sms").prop('checked',false);
$("#schedule-email").prop('checked',false);
$("#schedule-ivrs").prop('checked',false);
$("#sechedule-time-model").modal('hide');

});

$("#schedul-submit-btn").on('click',function(){

	var candidate = $("#candidate").val(); 
	var title = $("#schedule-title").val(); 
	var schedule_days =[];
	var schedule_date =[];
	var schedule_time =[];
var sms_days = [],
	sms_date = [],
	sms_time = [],
	email_days = [],
	email_date = [],
	email_time = [],
	ivrs_days = [],
	ivrs_date = [],
	ivrs_time = [];
	$(".schedule_days").each(function(){
		// alert($(this).val())
		sms_days.push($(this).val());
	});
	$(".schedule_date").each(function(){
		// alert($(this).val())
		sms_date.push($(this).val());
	});
	$(".schedule_time").each(function(){
		// alert($(this).val())
		sms_time.push($(this).val());
		/* var sms = $(this).val().split(','); 
		for (var i = 0; i < sms.length; i++) { 
			sms_time.push(sms[i]);
		}*/
	});
	/*	$(".email_schedule_days").each(function(){ 
		email_days.push($(this).val());
	});*/
	$(".email_schedule_date").each(function(){
		// alert($(this).val())
		email_date.push($(this).val());
	});
	$(".email_schedule_time").each(function(){
		// alert($(this).val())
		email_time.push($(this).val());
		/* var email = $(this).val().split(','); 
		for (var i = 0; i < email.length; i++) { 
			email_time.push(email[i]);
		}*/
	});
		/*$(".ivrs_schedule_days").each(function(){ 
		ivrs_days.push($(this).val());
	});*/
	$(".ivrs_schedule_date").each(function(){
		// alert($(this).val())
		ivrs_date.push($(this).val());
	});
	$(".ivrs_schedule_time").each(function(){
		// alert($(this).val())
		ivrs_time.push($(this).val());
		/* var ivrs = $(this).val().split(','); 
		for (var i = 0; i < ivrs.length; i++) { 
			ivrs_time.push(ivrs[i]);
		}*/
	});
	var schedule_sms =[];
	$(".schedule_sms").each(function(){
		// alert($(this).val())
		schedule_sms.push($(this).val());
	});
	var schedule_email =[];
	$(".schedule_email").each(function(){
		// alert($(this).val())
		schedule_email.push($(this).val());
	});
	var schedule_ivrs =[];
	$(".schedule_ivrs").each(function(){
		// alert($(this).val())
		schedule_ivrs.push($(this).val());
	});

schedule_days = sms_days.toString();
// schedule_days.push({sms:sms_days});
schedule_date.push({sms:sms_date,email:email_date,ivrs:ivrs_date});
schedule_time.push({sms:sms_time,email:email_time,ivrs:ivrs_time});



		$.ajax({
	    url: base_url+"client/add_schedule_candidate_sms_email",
	    type: "POST",
	   	dataType : 'JSON',
	   	data: {
	    	candidate_id : candidate, 
	    	schedule_days : schedule_days,
	    	title : title,
	    	schedule_date : JSON.stringify(schedule_date),
	    	schedule_time : JSON.stringify(schedule_time),
	    	schedule_sms : JSON.stringify(schedule_sms),
	    	schedule_email : JSON.stringify(schedule_email),
	    	schedule_ivrs : JSON.stringify(schedule_ivrs),
	    },
	    success: function(data) {
	       if (data.status =='1') {
	           $("#all-schedule-list").html('');
	           window.location.reload();
		    }else{
		     
		    }
	    }
	});

});
var sms = 0;
$("#sms-add-time").on('click',function(){
	if (sms==4) {
		return false;
	}
	var html = '';

	html +='<div class="col-md-2 remove_class">';
	html +='<label>&nbsp;</label>';
	html +='<input type="time" class="form-control sms_time">';
	html +='<div>';

	$("#sms-time").append(html);
	sms++;
});
var email = 0;
$("#email-add-time").on('click',function(){
	if (email==4) {
		return false;
	}
	var html = '';

	html +='<div class="col-md-2 remove_class">';
	html +='<label>&nbsp;</label>';
	html +='<input type="time" class="form-control email_time">';
	html +='<div>';

	$("#email-time").append(html);
	email++;
});
var ivrs = 0;
$("#ivrs-add-time").on('click',function(){
	if (ivrs==4) {
		return false;
	}
	var html = '';

	html +='<div class="col-md-2 remove_class">';
	html +='<label>&nbsp;</label>';
	html +='<input type="time" class="form-control ivrs_time">';
	html +='<div>';

	$("#ivrs-time").append(html);
	ivrs++;
});
