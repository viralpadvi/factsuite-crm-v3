load_role();

function load_role(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"client/get_all_schedule_data",
	  	dataType: "json",
	  	success: function(data){  
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	// var components = JSON.parse(data[i]['component_name']);
        	var status = 'pending';
        	if (data[i]['candidate_id'] =='0') {
        		status = 'Init';
        	}
        	$title = data[i]['title'];
        	if (data[i]['title'] ==null || data[i]['title'] =='') {
        		$title =  '';
        	}
        	html += '<tr id="schedule_id'+data[i]['schedule_id']+'">'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+$title+'</td>'; 
        	if(data[i]['schedule_status'] == 1){
        		html += '<td>Active</td>';
        	}else{
        		html += '<td>Deactive</td>';
        	}
        	
        	html += '<td><a  onclick="view_schedule('+data[i]['schedule_id']+')"  href="#"><i class="fa fa-eye"></i></a></td>';
        	html += '<td><a  onclick="remove_schedule('+data[i]['schedule_id']+')"  href="#"><i class="fa fa-trash text-danger"></i></a></td>';
        	// <a onclick="removeData('+data[i]['schedule_id']+')" href="#"><img src="assets/admin/images/delete.png" /></a>
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="4" class="text-center">Not Found.</td></tr>'; 
    }
    $('#all-schedule-list').html(html); 
	  	} 
	});
}



function view_schedule(id){
$.ajax({
		type: "POST",
	  	url: base_url+"client/get_all_schedule_data", 
	  	dataType: "json",
	  	data:{id:id},
	  	success: function(data){  
	  		$("#sechedule-time-model").modal('show');
	  		// [{"sms":["Daily","Once"],"email":["Daily","Daily"],"ivrs":["Daily","Daily"]}]
	  		// `candidate_id`, `schedule_days`, `schedule_date`, `schedule_time`, `schedule_sms`, `schedule_email`, `schedule_ivrs`,

	  		var days= data['schedule_days'].split(',');
	  		// var days= JSON.parse(data['schedule_days']);
	  		var date= JSON.parse(data['schedule_date']);
	  		var time= JSON.parse(data['schedule_time']);
	  		var sms= JSON.parse(data['schedule_sms']);
	  		var email= JSON.parse(data['schedule_email']);
	  		// var ivrs= JSON.parse(data['schedule_ivrs']);
	  		// alert(sms[0])
	  			var status = 'Pending'; 
	  		if (data['candidate_id'] == '0') {
	  			status = 'Init';
	  		}

	  		$("#schedule-status").html(status);
	  		var html ='';
	  		var j =1;
	  		for (var i = 0; i < days.length; i++) {
	  			 
	  			html += '<tr>';
	  			html += '<td>'+ j++ +'</td>';
	  			html += '<td>'+days[i]+'</td>';
	  			// html += '<td> SMS -'+date[0]['sms'][i]+' <br>Email - '+date[0]['email'][i]+' <br>IVRS - '+date[0]['ivrs'][i]+'</td>';
	  			html += '<td> SMS -'+time[0]['sms'][i]+' <br>Email - '+time[0]['email'][i]+'</td>';
	  			html += '<td>'+sms[i]+'</td>';
	  			html += '<td>'+email[i]+'</td>';
	  			// html += '<td>'+ivrs[i]+'</td>';
	  			html += '</tr>';
	  		}
	  		// alert(html)
	  		$("#single-schedule-list").html(html);

	  		$("#click-to-schedule-btn").attr('onclick','redirect_schedule_link('+data['schedule_id']+')')
	  	}
	  })
}

function remove_schedule(schedule_id){
	$("#remove-modal").modal('show');
	$("#click-to-remove-btn").attr('onclick','remove_schedule_link('+schedule_id+')')
	
}

function remove_schedule_link(schedule_id){
	$.ajax({
		type: "POST",
	  	url: base_url+"client/remove_schedule_link", 
	  	dataType: "json",
	  	data:{id:schedule_id},
	  	success: function(data){  
	  			$("#remove-modal").modal('hide');
	  		 toastr.success('Data has been removed successfully.');
	  	  load_role();
	  	}
	  })
}

function redirect_schedule_link(id){
 window.location.href = base_url+"factsuite-admin/edit-email-sms-reminders?id="+id;
}

