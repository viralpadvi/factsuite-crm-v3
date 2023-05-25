loadAllAssignedCases();



function loadAllAssignedCases(){
	$.ajax({
		type: "POST",
	  	url: base_url+"inputQc/getAllAssignedCases", 
	  	dataType: "json",
	  	success: function(data){ 
            // console.log(data)
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	var status = '';
            var classStatus = '';
            var fontAwsom='';
        	if (data[i].is_submitted == '0') {
                // status = 'Pending';
                classStatus = 'pending'
                fontAwsom = '<i class="fa fa-check">'
                status = '<span class="text-warning">Pending</span>';
            }else if (data[i].is_submitted == '1') {
                // status = 'Pending';
                classStatus = 'pending'
                fontAwsom = '<i class="fa fa-check">'
                status = '<span class="text-info">Form Filled</span>';
            }else if (data[i].is_submitted == '2') {
                // status = 'Pending';
                classStatus = 'pending'
                fontAwsom = '<i class="fa fa-check">'
                status = '<span class="text-success">Completed</span>';
            }else{
                // status = 'Completed';
                classStatus = 'pending'
                fontAwsom = '<i class="fa fa-check">'
                status = '<span class="text-warning">Pending</span>';
            }
            
            priority = ''
            priorityClass = ''
            PrioritySelected = ''
            lowPrioritySelected = ''
            midPrioritySelected = ''
            highPrioritySelected = ''

            if(data[i].priority == '0'){
                PrioritySelected = 'Low'
                priorityClass = 'text-info font-weight-bold'
                    // lowPrioritySelected = 'selected'
            }else if(data[i].priority == '1'){  
                PrioritySelected = 'Medium'
                priorityClass = 'text-warning font-weight-bold'
                    // midPrioritySelected = 'selected'
            }else if(data[i].priority == '2'){  
                PrioritySelected = 'High'
                priorityClass = 'text-danger font-weight-bold'
                    // highPrioritySelected = 'selected'
            }

            // priority += '<label class="font-weight-bold">Priority: </label>&nbsp;'
            priority += '<span class="'+priorityClass+'">'+PrioritySelected+'<span>'

        	html += '<tr id="tr_'+data[i].candidate_id+'">'; 
        	html += '<td class="d-none">'+j+'</td>';
            html += '<td id="first_name'+data[i].candidate_id+'">'+data[i].candidate_id+'</td>';
        	html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
        	html += '<td id="client_name_'+data[i].candidate_id+'">'+data[i]['client_name']+'</td>';
        	html += '<td id="package_name'+data[i].candidate_id+'">'+data[i]['package_name']+'</td>';
        	html += '<td id="phone_number'+data[i].candidate_id+'">'+data[i]['phone_number']+'</td>';
            html += '<td id="email_id'+data[i].candidate_id+'">'+data[i]['email_id']+'</td>';
        	html += '<td id="email_id'+data[i].candidate_id+'">'+priority+'</td>';
        	html += '<td class"'+classStatus+'" id="status'+data[i].candidate_id+'">'+status+'</td>';
             // href="'+base_url+"inputQc/get_single_cases_detail/"+encodeURIComponent(btoa(data[i].candidate_id))+'"
            // html += '<td class="text-center"><a href="#" onclick="view_case_progress('+data[i].candidate_id+')"><i class="fa fa-eye"></i></a></td>';
        	html += '<td class="text-center"><a href="'+base_url+'factsuite-inputqc/assigned-view-case-detail/'+data[i].candidate_id+'" ><i class="fa fa-eye"></i></a></div></td>';
            // html += '<td>';
            // html += '<div class="custom-control custom-switch d-inline" id="change_status_check_div_'+data[i].candidate_id +'">'+onclick="get_single_cases_detail('+data[i].candidate_id+')"
            //                         '<input type="checkbox" '+check+' onclick="change_vendor_status('+data[i].candidate_id +','+data[i].vendor_status+')" class="custom-control-input" id="change_candidate_status_'+data[i].candidate_id +'">'+
            //                         '<label class="custom-control-label" for="change_vendor_status_'+data[i].candidate_id +'"></label>'+
            //                     '</div>';
            // html += '<a href="javascript:void(0)" onclick="edit_vendor_details_modal('+data[i].candidate_id+')"><i class="fa fa-pencil fa-pencil-edit ml-2"></i></a>';
            // html += '</td>';
        	html += '</tr>';




          j++; 
        }
      }else{
        html+='<tr><td colspan="10" class="text-center">No Case Found.</td></tr>'; 
    }
    $('#get-case-data').html(html); 
	  	} 
	});
}


function get_single_cases_detail(id){

    $.ajax({
        type: "POST",
        url: base_url+"inputQc/get_single_cases_detail", 
        data:{
            id:id
        },
        dataType: "json",
        success: function(data){ 
            
        let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
            var status = '';
            if (data[i].is_submitted == '0') {
                // status = 'Pending';
                status = '<span class="text-warning">Pending</span>';
            }else{
                // status = 'Completed';
                status = '<span class="text-sucess">Completed</span>';
            }

            // if (data[i].vendor_status == '1') {
            //     check = 'checked';
            // } else {
            //     check = '';
            // }

            html += '<tr id="tr_'+data[i].candidate_id+'">'; 
            html += '<td>'+j+'</td>';
            html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
            html += '<td id="client_name_'+data[i].candidate_id+'">'+data[i]['client_name']+'</td>';
            html += '<td id="package_name'+data[i].candidate_id+'">'+data[i]['package_name']+'</td>';
            html += '<td id="phone_number'+data[i].candidate_id+'">'+data[i]['phone_number']+'</td>';
            html += '<td id="email_id'+data[i].candidate_id+'">'+data[i]['email_id']+'</td>';
            html += '<td id="status'+data[i].candidate_id+'">'+status+'</td>';
            html += '<td class="text-center"><a onclick="view_edit_team('+data[i].candidate_id+')" href="'+base_url+"inputQc/get_single_cases_detail/"+encodeURIComponent(btoa(data[i].candidate_id))+'"><i class="fa fa-eye"></i></a></div></td>';
            // html += '<td>';
            // html += '<div class="custom-control custom-switch d-inline" id="change_status_check_div_'+data[i].candidate_id +'">'+
            //                         '<input type="checkbox" '+check+' onclick="change_vendor_status('+data[i].candidate_id +','+data[i].vendor_status+')" class="custom-control-input" id="change_candidate_status_'+data[i].candidate_id +'">'+
            //                         '<label class="custom-control-label" for="change_vendor_status_'+data[i].candidate_id +'"></label>'+
            //                     '</div>';
            // html += '<a href="javascript:void(0)" onclick="edit_vendor_details_modal('+data[i].candidate_id+')"><i class="fa fa-pencil fa-pencil-edit ml-2"></i></a>';
            // html += '</td>';
            html += '</tr>';




          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No Case Found.</td></tr>'; 
    }
    $('#get-case-data').html(html); 
        } 
    });
}

function randomString(length) {
    var result = '';
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}

function view_case_progress(candidate_id){
    
     var statusPage = '2'
     var randomChars = randomString(7);
    $('#View').modal('show');
    $.ajax({
        type: "POST",
        url: base_url+"inputQc/getSingleAssignedCaseDetails/"+randomChars, 
        data:{
            candidate_id:candidate_id,
            statusPage:statusPage
        },
        dataType: "json",
        success: function(data){ 
            console.log(JSON.stringify(data))
            var date = new Date(); 
            date. setDate(date.getDate() + 10);
            // var pdate = date.split(' ') 
            var caseEndDate =  date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear();
            // roundProgress(data)       
            if (data.length > 0) {
                var caseStatus= ''
                if(data[0]['is_submitted'] == 0){
                    caseStatus = 'Pending'
                }else if(data[0]['is_submitted'] == 1){
                    caseStatus = 'In Progress'
                }else if(data[0]['is_submitted'] == 2){
                    caseStatus = 'Completed'
                }
                $('#candidate-id').html(data[0].candidate_id)
                $('#candidate-name').html(data[0]['title']+". "+data[0]['first_name']+" "+data[0]['last_name'])
                $('#phone-number').html(data[0]['phone_number'])
                $('#Email-id').html(data[0]['email_id'])
                $('#date-of-birth').html(data[0]['date_of_birth'])
                $('#case-date').html(data[0]['created_date'])
                $('#case-status').html(caseStatus)
                $('#case-end-date').html(caseEndDate)
                 
                let html='';
                html += '<li class="active">';
                html += '   <div class="view-tp">';
                html +=         '<span class="view-bg1 text-capitalize">Candidate Form</span>';
                html +=     '</div>';
                html += '   <div class="view-nm">Updated By';
                html +=         '<span class="view-bg1 text-capitalize">'+data[0]['document_uploaded_by']+'</span></div>';
                html += '   <div class="view-btm">';
                html += '       <span>Start</span>'+data[0]['created_date'];
                html += '   </div>';
                html += '</li>';
                html += '<li class="active">';
                html += '   <div class="view-tp">';
                html +=         '<span class="view-bg1 text-capitalize">Persional Info</span>';
                html +=     '</div>';
                html += '   <div class="view-nm">Updated By';
                html +=         '<span class="view-bg1 text-capitalize">'+data[0]['document_uploaded_by']+'</span></div>';
                html += '   <div class="view-btm">';
                html += '       <span>Start</span> 12 Feb 2020';
                html += '   </div>';
                html += '</li>';

                totalCompletedComponentIds = [];
                for(var i=0;i<data.length;i++){
                    var status ='';
                    if(data[i].component_status != null && data[i].component_status != ''){
                        if(data[i].component_status.analyst_status == '0'){
                            status = 'pending'
                        }else if(data[i].component_status.analyst_status == '1'){
                            status = 'pending'
                        }else if(data[i].component_status.analyst_status == '2'){
                            status = 'active'
                        }else if(data[i].component_status.analyst_status == '3'){
                            status = 'pending'
                        }else if(data[i].component_status.analyst_status == '4'){
                            status = 'active'
                            totalCompletedComponentIds.push(data[i].component_id)
                        }else if(data[i].component_status.analyst_status == '5'){
                            status = 'deadline'
                        }else if(data[i].component_status.analyst_status == '6'){
                            status = 'deadline'
                            totalCompletedComponentIds.push(data[i].component_id)
                        }else if(data[i].component_status.analyst_status == '7'){
                            status = 'pending'
                            totalCompletedComponentIds.push(data[i].component_id)
                        }else if(data[i].component_status.analyst_status == '8'){
                            status = 'pending'
                        }else if(data[i].component_status.analyst_status == '9'){
                            status = 'active'
                            totalCompletedComponentIds.push(data[i].component_id)
                        }
                    }else{
                       status = 'pending' 
                    }

                    componentCreatedDate = '';
                    if(data[i].component_status != null){
                        componentCreatedDate = data[i].component_status.created_date
                    }else{
                        componentCreatedDate = data[0]['created_date']
                    }
                    
                    html += '<li class="'+status+'">';
                    html += '   <div class="view-tp">';
                    html +=         '<span class="view-bg1 text-capitalize">'+data[i].component_name+'</span>';
                    html +=     '</div>';
                    html += '   <div class="view-nm">Updated By';
                    html +=         '<span class="view-bg1 text-capitalize">'+data[i].document_uploaded_by+'</span></div>';
                    html += '   <div class="view-btm">';
                    html += '       <span>Start</span>'+componentCreatedDate;
                    html += '   </div>';
                    html += '</li>';
                }
                // html += '<li class="deadline">';
                //     html += '<div class="view-btm">';
                //         html += '<span class="view-bg3">Dead Line </span>'+caseEndDate;
                //     html += '</div>';
                // html += '</li>';

                $('#milestones-ul').html(html)
                var percentageTotal = (parseInt(totalCompletedComponentIds.length+2)/data[0].component_id_total)*100
                percentageTotal = Math.round(percentageTotal,2);
                $('#progress-percentage').html(percentageTotal+"%") 
                roundProgress(parseInt(percentageTotal))
            }else{

            }

        }
    });
 }

function roundProgress(percentageTotal){ 
    
   $(".progress").each(function() {
        // alert(percentageTotal);
        // var value = $(this).attr('data-value');
        var value = percentageTotal
        var left = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');

        if (value > 0) {
          if (value <= 50) {
            // alert('if');
            right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
            left.css('transform', 'rotate(0deg)')
          } else {
            // alert('else');
            right.css('transform', 'rotate(180deg)')
            left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
          }
        }
    })
}
function percentageToDegrees(percentage) {
    return percentage / 100 * 360
}


  


// function get_single_cases_detail(id){}
