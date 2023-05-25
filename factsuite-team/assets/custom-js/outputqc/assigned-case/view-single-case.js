// load_case(); 
/*$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    return results[1] || 0;
}
 */
function load_case(candidate_id){
    // alert(candidate_id)
	$.ajax({
		type: "POST",
	  	url: base_url+"outPutQc/getSingleAssignedCaseDetails/"+candidate_id,  
	  	dataType: "json",
	  	success: function(data){ 
        // console.log(JSON.stringify(data))
		let html='';
      if (data.length > 0) {
        var j = 1;
        // alert(data[0].client_name)
        $('#caseId').html(data[0]['candidate_id']);
        $('#camdidateName').html(data[0]['first_name']);
        $('#clientName').html(data[0]['client_name']);
        $('#camdidatephoneNumber').html(data[0]['phone_number']);
        $('#packageName').html(data[0]['package_name']);
        $('#camdidateEmailId').html(data[0]['email_id']);

        var style ='style="display:none;"'; 
        var style1 =''; 
        if (data[0]['is_report_generated']=='1') {
          style ='';  
          var style1 ='style="display:none;"'; 
        }
        var URL = base_url+'outPutQc/htmlGenrateReport/'+candidate_id;
        // var componentIds = ['16','17','18','20'];
        $('#report-button').html('<button class="btn bg-blu text-white" id="reportConfirmation" '+style1+' onclick="reportConfirmation(\''+candidate_id+'\',\''+URL+'\')">Generate&nbsp;Report</button>&nbsp;<a '+style+' id="final-report-generated" class="btn bg-blu text-white" target="_blank" href="'+base_url+'outPutQc/pdf/'+candidate_id+'">Download&nbsp;Report</a>')
        // $('#report-button').html('<a id="genrate_report" class="insuf-btn text-white" href="'+base_url+'outPutQc/htmlGenrateReport/'+candidate_id+'">Genrate&nbsp;Report</a>')
        var  m = 1;
        for (var i = 0; i < data.length; i++) { 
            // if($.inArray(data[i].component_id,componentIds) === -1){
                // alert('component id:'+data[i].component_id)
                var status = [];
                var classStatus = '';
                var fontAwsom='';
                var insuffDisable = '';
                var approvDisable = '';
                // 0-pending 1-onprogress 2-completed 3-insufficiency 4-approved
                // alert(data[i].component_data)
                var opStatus = []; 
                if(data[i].component_data != null){
                    if(data[i].component_data.analyst_status != null && data[i].component_data.analyst_status != ''){
                        // alert(data[i].component_data.analyst_status)
                        var analyst_status = data[i].component_data.analyst_status.split(',');
                       var  j = 1;
                       
                        for (var k = 0; k < analyst_status.length; k++) {
                          
                            if (analyst_status[k] == '0') {
                             status.push('Form '+j++ +': <span class="text-warning">Pending</span>');
                                
                                fontAwsom = '<i class="fa fa-exclamation">'
                                insuffDisable = 'disabled'
                                approvDisable = 'disabled'
                            }else if (analyst_status[k] == '1') {
                                 status.push('Form '+j++ +': <span class="text-info">Form Filled</span>');
                                // status = '<span class="text-info">Form Filled<span>';
                                fontAwsom = '<i class="fa fa-check">'
                            }else if (analyst_status[k] == '2') {
                                 status.push('Form '+j++ +': <span class="text-success">Completed</span>');
                                 
                                // status = '<span class="text-success">Completed<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled'
                                approvDisable = 'disabled'
                            }else if (analyst_status[k] == '3') {
                                 status.push('Form '+j++ +': <span class="text-danger">Insufficiency</span>');
                                 
                                // status = '<span class="text-danger">Insufficiency<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled'
                            }else if (analyst_status[k] == '4') {
                                 status.push('Form '+j++ +': <span class="text-success">Verified Clear</span>');
                               
                                // status = '<span class="text-success">Verified Clear<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled'
                                approvDisable = 'disabled'
                            }else if (analyst_status[k] == '5') {
                                 status.push('Form '+j++ +': <span class="text-danger">Stop Check</span>');
                                 
                                // status = '<span class="text-danger">Stop Check<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled'
                                approvDisable = 'disabled'
                            }else if (analyst_status[k] == '6') {
                                 status.push('Form '+j++ +': <span class="text-danger">Unable to verify</span>');
                               
                                // status = '<span class="text-danger">Unable to verify<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled'
                                approvDisable = 'disabled'
                            }else if (analyst_status[k] == '7') {
                                 status.push('Form '+j++ +': <span class="text-danger">Verified discrepancy</span>');
                               
                                // status = '<span class="text-danger">Verified discrepancy<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled'
                                approvDisable = 'disabled'
                            }else if (analyst_status[k] == '8') {
                                 status.push('Form '+j++ +': <span class="text-danger">Client clarification</span>');
                               
                                // status = '<span class="text-danger">Client clarification<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled'
                                approvDisable = 'disabled'
                            }else if (analyst_status[k] == '9') {
                                 status.push('Form '+j++ +': <span class="text-danger">Closed insufficiency</span>');
                               
                                // status = '<span class="text-danger">Closed insufficiency<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled' 
                                approvDisable = 'disabled'
                            }else if (analyst_status[k] == '10'){
                                 status.push('Form '+j++ +': <span class="text-danger">QC Error</span>');

                                // status = '<span class="text-danger">QC Error<span>';
                                fontAwsom = '<i class="fa fa-check">'
                                stopCheckSelected = 'selected';
                                actionDisabled ='disabled readonly'    
                            }else if (analyst_status[k] == '11'){
                             status.push('Form '+j++ +': <span class="text-perpul">Insufficiency Clear<span>');  
                             fontAwsom = '<i class="fa fa-check">'
                                insuffDisable = 'disabled'
                                approvDisable = 'disabled'
                            } 
                        }
                    }else{
                        status = '<span class="text-success">Wrong</span>';
                        fontAwsom = '<i class="fa fa-check">'
                        insuffDisable = 'disabled'
                        approvDisable = 'disabled'
                    }         

                    var output_status = data[i].component_data.output_status.split(',');
                    n=1;
                    for (var k = 0; k < output_status.length; k++) {
                        if(output_status[k] == '1'){
                            opStatus.push('Form '+n+': <span class="text-success">Approved</span>');
                        }else if(output_status[k] == '2'){
                            opStatus.push('Form '+n+': <span class="text-danger">Rejected</span>');
                        }else if(output_status[k] == '0'){
                            opStatus.push('Form '+n+': <span class="text-warning">Not Initiated</span>');
                        }else{
                           opStatus.push('Form '+n+': <span class="text-warning">pending</span>');  
                        }
                        n++;
                    }
                }else{
                    // $('#report-button').addClass('d-none')
                    opStatus.push('Form 0: <span class="text-danger">Error</span>'); 
                }

                priority = ''
                priorityClass = ''
                PrioritySelected = ''
                lowPrioritySelected = ''
                midPrioritySelected = ''
                highPrioritySelected = ''

                if(data[0].priority == '0'){
                    PrioritySelected = 'Low priority'
                    priorityClass = 'text-info font-weight-bold'
                    // lowPrioritySelected = 'selected'
                }else if(data[0].priority == '1'){  
                    PrioritySelected = 'Medium priority'
                    priorityClass = 'text-warning font-weight-bold'
                    // midPrioritySelected = 'selected'
                }else if(data[0].priority == '2'){  
                    PrioritySelected = 'High priority'
                    priorityClass = 'text-danger font-weight-bold'
                    // highPrioritySelected = 'selected'
                }



                priority += '<label class="font-weight-bold">Priority: </label>&nbsp;'
                priority += '<span class="'+priorityClass+'">'+PrioritySelected+'<span>'
                // priority += '<select id="action_status" name="carlist" class="sel-allcase" onchange="priority_status('+data[0]['candidate_id']+',this.value)">';
                //     priority += '<option '+lowPrioritySelected+' value="0">Low priority</option>';
                //     priority += '<option '+midPrioritySelected+' value="1">Medium priority</option>';
                //     priority += '<option '+highPrioritySelected+' value="2">High priority</option>'; 
                // priority += '</select>';


                $('#priority-div').html(priority);
               

                var arg = data[i].candidate_id+','+data[i].component_id;
                var argNew = data[i].candidate_id+'/'+data[i].component_id;
                var argWithName = data[i].candidate_id+','+data[i].component_id+',\''+data[i].component_name+'\',\''+data[i].first_name+'\',\''+data[i].email_id+'\'';
                var from_all_cases = $('#from-all-cases').val();

            	html += '<tr id="tr_'+data[i].candidate_id+'">'; 
            	html += '<td>'+ m++ +'</td>';
            	html += '<td>'+data[i].component_name+'</td>';
                html += '<td id="status'+data[i].candidate_id+'">'+status+'</td>';           
            	html += '<td id="opstatus'+data[i].candidate_id+'">'+opStatus+'</td>';      	 
                html += '<td class="text-center"><a href="'+base_url+'factsuite-outputqc/component-detail/'+argNew+'" class="app-btn">View <i class="fas fa-angle-right"></i></a></td>';  
            	html += '</tr>';

                j++;  
            }
        // }
      }else{
        html+='<tr><td colspan="4" class="text-center">No Case Found.</td></tr>'; 
    }
    $('#get-case-data').html(html); 
	  	} 
	});
}
 

function reportConfirmation(candidate_id,url){

    // alert('call')

    $.ajax({
        type: "POST",
        url: base_url+"outPutQc/checkOputputQcApprovedOrNot/",
        data:{
            candidate_id:candidate_id
        },
        dataType: "json",
        success: function(data){ 
            if(data.status == '1'){
                $('#conformtion').modal('show');
                $('#ask-quaction').html('Do you want to confirm?')
                html='';
                html += '<button class="btn bg-blu text-white" data-dismiss="modal" id="report-cancle">Close</button>'
                html += '<button class="btn bg-blu float-right text-white" onclick="reportConfirmationYes(\''+url+'\',\''+candidate_id+'\')" id="submit-report-status">Confirm</button>'

                $('#button-div').html(html)
            }else{
                $('#conformtion').modal('show');
                $('#ask-quaction').html(data.count+' components are pending to be approved to generate report.')
                html='';
                html += '<button class="btn bg-blu text-white float-right" data-dismiss="modal" id="report-cancle">Close</button>'
                // html += '<button class="btn bg-blu float-right text-white" onclick="reportConfirmationYes(\''+url+'\',\''+candidate_id+'\')" id="submit-report-status">Confirm</button>'

                $('#button-div').html(html)
            }
        }
    });

    // $('#conformtion').modal('show');
     
    // html='';
    // html += '<button class="btn bg-blu text-white" data-dismiss="modal" id="report-cancle">Close</button>'
    // html += '<button class="btn bg-blu float-right text-white" onclick="reportConfirmationYes(\''+url+'\',\''+candidate_id+'\')" id="submit-report-status">Confirm</button>'

    // $('#button-div').html(html)
}

function reportConfirmationYes(url,candidate_id){
    
    

    $('#wait-message').html('Please wait while we are updating the data.')
    $('#submit-report-status').attr('disabled',true);
    $('#report-cancle').attr('disabled',true);
    $('#submit-report-status').addClass('buttonload');
    $('#submit-report-status').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');

    $.ajax({
        type: "POST",
        url: base_url+"outPutQc/genrateReportStatus",
        data:{

            candidate_id:candidate_id,
        },
        dataType: "json",
        success: function(data){
            
            if (data.status == '1') {   
                $("#reportConfirmation").hide();
                $('#submit-report-status').attr('disabled',false);
                $('#report-cancle').attr('disabled',false);
                $('#submit-report-status').removeClass('buttonload');
                $('#submit-report-status').html('Confirm');         
                $('#conformtion').modal('hide');
                toastr.success('Report Generated Successfully.');
                $("#final-report-generated").show();
                // window.open(base_url+'outPutQc/htmlGenrateReport/'+candidate_id, "_blank");
                // window.location = base_url+'outPutQc/htmlGenrateReport/'+candidate_id;
            }else{
                $('#wait-message').html('Something went wrong report is not genrated.')
                $('#submit-report-status').addClass('buttonload');
                toastr.error('Something wen\'t wrong. report is not genrated.');   
            }

        }
    });
}