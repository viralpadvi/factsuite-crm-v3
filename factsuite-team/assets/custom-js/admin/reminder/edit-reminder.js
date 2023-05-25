
// var i = 1;
	  		var j =1;
function view_schedule(id){
$.ajax({
		type: "POST",
	  	url: base_url+"client/get_all_schedule_data", 
	  	dataType: "json",
	  	data:{id:id},
	  	success: function(data){  
	  		// $("#sechedule-time-model").modal('show');
	  		// [{"sms":["Daily","Once"],"email":["Daily","Daily"],"ivrs":["Daily","Daily"]}]
	  		// `candidate_id`, `schedule_days`, `schedule_date`, `schedule_time`, `schedule_sms`, `schedule_email`, `schedule_ivrs`,

	  		var days= data['schedule_days'].split(',');
	  		// var days= JSON.parse(data['schedule_days']);
	  		var date= JSON.parse(data['schedule_date']);
	  		var time= JSON.parse(data['schedule_time']);
	  		var sms= JSON.parse(data['schedule_sms']);
	  		var email= JSON.parse(data['schedule_email']);
	  		var ivrs= JSON.parse(data['schedule_ivrs']);
	  		// alert(sms)
	  			var status = 'Pending'; 
	  		if (data['candidate_id'] == '0') {
	  			status = 'Init';
	  		}

	  		$("#schedule-status").html(status);
	  		$("#schedule-id").val(data['schedule_id']);
	  		$("#candidate").val(data['candidate_id']);

	  		var html ='';
	  		for (var i = 0; i < days.length; i++) {
	  			 
	  			html += '<tr>';
	  			html += '<td>'+ j++ +'</td>';
	  			html += '<td><input type="hidden" value="'+days[i]+'" class="schedule_days">'+days[i]+'</td>';
	  			html += '<td class="d-none"><input type="hidden" value="'+date[0]['sms'][i]+'" class="schedule_date"><input type="hidden" value="'+date[0]['email'][i]+'" class="email_schedule_date"><input type="hidden" value="'+date[0]['ivrs'][i]+'" class="ivrs_schedule_date"> SMS -'+date[0]['sms'][i]+' <br>Email - '+date[0]['email'][i]+'</td>';
	  			html += '<td><input type="hidden" value="'+time[0]['sms'][i]+'" class="schedule_time"><input type="hidden" value="'+time[0]['email'][i]+'" class="email_schedule_time"><input type="hidden" value="'+time[0]['ivrs'][i]+'" class="ivrs_schedule_time"> SMS -'+time[0]['sms'][i]+' <br>Email - '+time[0]['email'][i]+'</td>';
	  			html += '<td><input type="hidden" value="'+sms[i]+'" class="schedule_sms">'+sms[i]+'</td>';
	  			html += '<td><input type="hidden" value="'+email[i]+'" class="schedule_email">'+email[i]+'</td>';
	  			// html += '<td><input type="hidden" value="'+ivrs[i]+'" class="schedule_ivrs">'+ivrs[i]+'</td>';
	  			html += '</tr>';
	  		}
	  		// alert(html)
	  		$("#all-schedule-list").html(html);
	  	}
	  })
}


$("#sechedule-time").on('click',function(){
	$(".remove_class").remove();

sms = 0;
email = 0;
ivrs = 0;
	$("#sechedule-time-model").modal('show');
});
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
	var schedule_id = $("#schedule-id").val(); 

	// var candidate = $("#candidate").val(); 
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
	    	schedule_id : schedule_id, 
	    	candidate_id : candidate, 
	    	schedule_days : JSON.stringify(schedule_days),
	    	schedule_date : JSON.stringify(schedule_date),
	    	schedule_time : JSON.stringify(schedule_time),
	    	schedule_sms : JSON.stringify(schedule_sms),
	    	schedule_email : JSON.stringify(schedule_email),
	    	schedule_ivrs : JSON.stringify(schedule_ivrs),
	    },
	    success: function(data) {
	       if (data.status =='1') {
	           // $("#all-schedule-list").html('');
	           window.location.href = base_url+'factsuite-admin/view-email-sms-reminders';
		    }else{
		     
		    }
	    }
	});

});


