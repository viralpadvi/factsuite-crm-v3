// load_case();

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

var for_next_release = 0;
function load_case(candidate_id){
     sessionStorage.clear(); 
    // alert(candidate_id)
    $.ajax({
        type: "POST",
        url: base_url+"adminViewAllCase/getSingleAssignedCaseDetails/"+candidate_id,  
        dataType: "json",
        success: function(all_data){
        let html = '',
            internal_tat_details_html = '',
            data = all_data.candidate_details,
            selected_datetime_format = all_data.selected_datetime_format;
        if (data.length > 0) {
            var j = 1;
            // alert(data[0].component_name)
            $('#caseId').html(data[0]['candidate_id']);
            $('#candidateName').html(data[0]['first_name']);
            $('#clientName').html(data[0]['client_name']);
            $('#camdidatephoneNumber').html(data[0]['phone_number']);
            $('#packageName').html(data[0]['package_name']);
            $('#camdidateEmailId').html(data[0]['email_id']);
            $('#tatTotalDays').html(data[0]['left_tat_days'])
            var tat_start_date = data[0]['tat_start_date'];
            if (data[0]['tat_start_date'] != '' && data[0]['tat_start_date'] != null && data[0]['tat_start_date'].toLowerCase() != 'na') {
                tat_start_date = get_date_formate(tat_start_date);
            }
            $('#tatStartDays').html(tat_start_date);
            var tat_end_date = data[0]['tat_end_date'];
            if (data[0]['tat_end_date'] != '' && data[0]['tat_end_date'] != null && data[0]['tat_end_date'].toLowerCase() != 'na') {
                tat_end_date = get_date_formate(tat_end_date);
            }
            $('#tatEndDays').html(tat_end_date);
            var tat_pause_date = data[0]['tat_pause_date'];
            if (data[0]['tat_pause_date'] != '' && data[0]['tat_pause_date'] != null && data[0]['tat_pause_date'].toLowerCase() != 'na') {
                tat_pause_date = get_date_formate(tat_pause_date);
            }
            $('#tatPauseDays').html(tat_pause_date);
            var tat_re_start_date = data[0]['tat_re_start_date'];
            if (data[0]['tat_re_start_date'] != '' && data[0]['tat_re_start_date'] != null && data[0]['tat_re_start_date'].toLowerCase() != 'na') {
                tat_re_start_date = get_date_formate(tat_re_start_date);
            }
            $('#tatReStartDays').html(tat_re_start_date);
            $('#remarks').html(data[0]['remark']);
            $('#preferred').html(data[0]['socials']);
            $('#week').html(data[0]['week']);
            $('#start_date').html(data[0]['start_time']);
            $('#end_date').html(data[0]['end_time']);
            $val = '<a href="#" onclick="get_call_details('+data[0]['candidate_id']+',\''+data[0]['first_name']+'\',\''+data[0]['last_name']+'\',\''+data[0]['phone_number']+'\')" class="btn bg-blu btn-submit text-warning first_name"><i class="fa fa-solid fa-phone"></i></a>';
            $("#call-to-candidate").html($val);
             $("#candidate_country").html(data[0]['candidate_details']['nationality']);
            $("#candidate_state").html(data[0]['candidate_details']['candidate_state']);
            $("#candidate_city").html(data[0]['candidate_details']['candidate_city']); 

            if (data[0]['is_submitted'] == 0) {
                $("#candidate-loa").hide();
            }


            if(data[0]['candidate_id'] != null && data[0]['candidate_id'] != ''){
                tatValue = '';
                if( tat_status = data[0]['tat_pause_resume_status'] == 1){
                    tatValue += '<span class="text-danger">Pause<span>';
                    $('#btn_tat_name').html('Re-Start TAT')
                    $('#btn_pause_re_start_tat').attr('onclick','tat_confirm_dialog('+data[0]['candidate_id']+',"re_start")')
                }else{
                    tatValue += '<span class="text-success">Rolling<span>';
                    $('#btn_tat_name').html('Pause TAT')
                    $('#btn_pause_re_start_tat').attr('onclick','tat_confirm_dialog('+data[0]['candidate_id']+',"pause")')
                }
                $('#tatStatus').html(tatValue)

                $('#view_tat_log').attr('onclick','list_tat_log('+data[0]['candidate_id']+')')
                
            }else{
                $('#tat_btns').addClass('d-none')
            }


            if(data[0]['tat_start_date'] == '-'){
                $('#tat_btns').addClass('d-none')
            }else{
                $('#tat_btns').removeClass('d-none')  
            }
            // camdidatepriority
            priority = ''
            priorityClass = ''
            lowPrioritySelected = ''
            midPrioritySelected = ''
            highPrioritySelected = ''

            if(data[0].priority == '0'){
                    // priority = 'Low priority'
                priorityClass = 'text-info font-weight-bold'
                lowPrioritySelected = 'selected'

            }else if(data[0].priority == '1'){  
                    // priority = 'Medium priority'
                priorityClass = 'text-warning font-weight-bold'
                midPrioritySelected = 'selected'
            }else if(data[0].priority == '2'){  
                    // priority = 'High priority'
                priorityClass = 'text-danger font-weight-bold'
                highPrioritySelected = 'selected'
                   
                $('#th-dynamic-status').html('Specialist Status');
                $('#th-dynamic-status-name').html('Assigned&nbsp;to&nbsp;specialist');
            }

            

            priority += '<label class="font-weight-bold">Priority: </label>&nbsp;'
            priority += '<select id="action_status" name="carlist" class="sel-allcase" onchange="priority_status('+data[0]['candidate_id']+',this.value,\'admin\',\'1\')">';
            priority += '<option '+lowPrioritySelected+' value="0">Low priority</option>';
            priority += '<option '+midPrioritySelected+' value="1">Medium priority</option>';
            priority += '<option '+highPrioritySelected+' value="2">High priority</option>'; 
            priority += '</select>';
            $('#priority-div').html(priority);



            var componentIds = ['14','15','19','21'];
            for (var i = 0; i < data.length; i++) { 
                var status = '';
                var classStatus = '';
                var fontAwsom='';
                var insuffDisable = '';
                var approvDisable = '';
                // 0-pending, 1-filled Form(in progress), 2-completed, 3-insufficiency, 4-approve, 5-stop, 6-Unable to Verify, 7-Verified Discrepancy, 8-Client clarification, 9-Closed insufficiency 
                

                // if(data[i].component_status != null && data[i].component_status != 'null' && data[i].component_status != ''){
                    // alert('if')
                    if (data[i].analyst_status == '0') {
                         
                        status = '<span class="text-warning">Not Initiated<span>';
                        fontAwsom = '<i class="fa fa-exclamation">'
                    }else if (data[i].analyst_status == '1') {
                         
                        status = '<span class="text-info">In Progress<span>';
                        fontAwsom = '<i class="fa fa-check">'
                    }else if (data[i].analyst_status == '2') {
                         
                        status = '<span class="text-success">Completed<span>';
                        
                    }else if (data[i].analyst_status== '3') {
                         
                        status = '<span class="text-danger">Insufficiency<span>';
                        
                    }else if (data[i].analyst_status == '4') {
                       
                        status = '<span class="text-success">Verified Clear<span>';
                        
                    }else if (data[i].analyst_status == '5') {
                       
                        status = '<span class="text-danger">Stop Check<span>';
                        
                    }else if (data[i].analyst_status == '6') {
                       
                        status = '<span class="text-danger">Unable to verify<span>';
                        
                    }else if (data[i].analyst_status == '7') {
                       
                        status = '<span class="text-danger">Verified discrepancy<span>';
                       
                    }else if (data[i].analyst_status == '8') {
                       
                        status = '<span class="text-danger">Client clarification<span>';
                       
                    }else if (data[i].analyst_status == '9') {
                       
                        status = '<span class="text-danger">Closed insufficiency<span>';
                        
                    }else if (data[i].analyst_status == '10'){
                        status = '<span class="text-danger">QC Error<span>'; 
                     
                    }else if (data[i].analyst_status == '11'){
                        status = '<span class="text-perpul">Insufficiency Clear<span>';  
                    }
                // }else{
                //     alert('else')
                //     status = '<span class="text-warning">Pending<span>';
                //     fontAwsom = '<i class="fa fa-exclamation">'
                // }
                
                // inputQC Status;
                inputQcStatus = ''
                if (data[i].status == '0') {
                         
                    inputQcStatus = '<span class="text-warning">Not Initiated<span>';
                        
                }else if (data[i].status == '1') {
                         
                    inputQcStatus = '<span class="text-warning">Not Initiated<span>';
                         
                }else if (data[i].status == '2') {
                         
                    inputQcStatus = '<span class="text-success">Completed<span>';
                        
                }else if (data[i].status== '3') {
                         
                    inputQcStatus = '<span class="text-danger">Insufficiency<span>';
                        
                }else if (data[i].status == '4') {
                       
                    inputQcStatus = '<span class="text-success">Verified Clear<span>';
                        
                }else if (data[i].status == '5') {
                       
                    inputQcStatus = '<span class="text-danger">Stop Check<span>';
                        
                }else if (data[i].status == '6') {
                       
                    inputQcStatus = '<span class="text-danger">Unable to verify<span>';
                        
                }else if (data[i].status == '7') {
                       
                    inputQcStatus = '<span class="text-danger">Verified discrepancy<span>';
                        
                }else if (data[i].status == '8') {
                       
                    inputQcStatus = '<span class="text-danger">Client clarification<span>';
                         
                }else if (data[i].status == '9') {
                       
                    inputQcStatus = '<span class="text-danger">Closed insufficiency<span>';
                        
                }
                
                // console.log('status '+i+':'+data[i].status);

                outPutQCStatus = ''

                if(data[i].output_status == '0'){
                    outPutQCStatus = '<span class="text-warning">Not Initiated<span>';
                }else if(data[i].output_status == '1'){
                    outPutQCStatus = '<span class="text-success">Approved<span>';
                }else if (data[i].output_status == '2') {
                    outPutQCStatus = '<span class="text-danger">Rejected<span>';
                } 
                
                // empDatalength = data[i].emp_data.length;


                html += '<tr id="tr_'+data[i].candidate_id+'">'; 
                html += '<td>'+j+'</td>';
                html += '<td>'+data[i].component_name+' (Form '+data[i]['formNumber']+')</td>';
                // html += 'td>'+data['formNumber']+'</td>';
                var arg = data[i].candidate_id+','+data[i].component_id+','+data[i].position+',"'+data[i].component_name+'"';

                var formValues = JSON.parse(data[i].form_values);
                var argWithName = data[i].candidate_id+','+data[i].component_id+',\''+data[i].component_name+'\',\''+data[i].first_name+'\',\''+data[i].email_id+'\'';
                if($.inArray(data[i].component_id,componentIds) === -1){
                    html += "<td class='text-center'><a id ='arg_"+i+"' data-object ='"+data[i].form_values+"' onclick='getComponentBasedData("+arg+","+formValues+")'><i class='fa fa-eye'></i></a></td>";
                }else{
                    html += '<td class="text-center"><a href="#" >-</a></td>';
                }
                if (for_next_release == 1) {
                    html += "<td class='text-center'><a id ='add-error-"+i+"' onclick='add_new_error_modal("+arg+")'><i class='fa fa-plus'></i></a></td>";
                    html += "<td class='text-center'><a id ='view-error-log-"+i+"' onclick='view_all_error_logs("+arg+")'><i class='fa fa-eye'></i></a></td>";
                    html += "<td class='text-center'><a id ='view-client-clarification-log-"+i+"' onclick='view_all_client_clarifications("+arg+")'><i class='fa fa-eye'></i></a></td>";
                }
                html += '<td id="status_'+data[i].candidate_id+'">'+inputQcStatus+'</td>';
                html += '<td id="status_'+data[i].candidate_id+'" >'+status+'</td>';

                html += '<td id="insuf_name_'+i+'" >'+data[i].insuff_team_name+'</td>';
                var override_team_arg = data[i].candidate_id+','+data[i].component_id+',\''+data[i].component_name+'\','+data[i].position+','+i;
                if(data[i].insuff_team_name != '-' || (data[i].analyst_status ==3)){ 
                    html += '<td id="emp_insuf_name_'+data[i].candidate_id+'" >'
                        html += '<select class="sel-allcase" id="override_insuf_team_'+i+'" onchange="insuff_override_team('+override_team_arg+',this.id)">'
                            html += '<option >Select</option>';
                            for (var e = 0; e < data[i].emp_data_insuff_analyst.length; e++) { 
                                // alert(data[i].insuff_team_id+":"+data[i].emp_data_insuff_analyst[e].team_id)
                                if(data[i].insuff_team_id == data[i].emp_data_insuff_analyst[e].team_id){                        
                                    html += '<option selected value="'+data[i].emp_data_insuff_analyst[e].team_id+'">'+data[i].emp_data_insuff_analyst[e].first_name+'&nbsp;('+data[i].emp_data_insuff_analyst[e].role+')</option>'                            
                                }else{

                                    html += '<option value="'+data[i].emp_data_insuff_analyst[e].team_id+'">'+data[i].emp_data_insuff_analyst[e].first_name+'&nbsp;('+data[i].emp_data_insuff_analyst[e].role+')</option>'                            
                                }    
                            }                                             
                        html += '</select>'
                    html += '</td>';
                } else {
                    html += '<td id="emp_insuf_name_'+data[i].candidate_id+'" >-'
                    html += '</td>';
                }

                html += '<td id="analyst_name_'+i+'">'+data[i].assigned_team_name+'</td>';

                if(data[i].assigned_team_name != '-'  || (data[i].analyst_status !='0' || data[i].analyst_status !='1')){
                    html += '<td id="emp_names_'+data[i].candidate_id+'" >'
                        html += '<select class="sel-allcase" id="override_team_'+i+'" onchange="override_team('+override_team_arg+',this.id)">'
                           html += '<option >Select</option>';
                            for (var e = 0; e < data[i].emp_data_analyst.length; e++) {  
                                if(data[i].assigned_team_id == data[i].emp_data_analyst[e].team_id){
                                    html += '<option selected value="'+data[i].emp_data_analyst[e].team_id+'">'+data[i].emp_data_analyst[e].first_name+'&nbsp;('+data[i].emp_data_analyst[e].role+')</option>'                            
                                }else{
                                    html += '<option value="'+data[i].emp_data_analyst[e].team_id+'">'+data[i].emp_data_analyst[e].first_name+'&nbsp;('+data[i].emp_data_analyst[e].role+')</option>'                            
                                }
                            }                                            
                        html += '</select>'
                    html += '</td>';
                } else {
                    html += '<td id="emp_names_'+data[i].candidate_id+'" >-</td>';
                }

                html += '<td id="status_'+data[i].candidate_id+'" >'+outPutQCStatus+'</td>';
                // if(analystName != 'null null'){
                  
                // }else{ 
                    
                // }
                
                // html += '<td id="first_name'+data[i].candidate_id+'"><button onclick="sendMial('+arg+')" class="snd-ml-btn"><img class="send-mail" src="'+img_base_url+'assets/admin/images/email_open_100px.png" alt=""> Send Mail</button></td>';
                // html += '<td id="client_name_'+data[i].candidate_id+'"><button id="insuff_'+data[i].candidate_id+'" '+insuffDisable+' onclick="modalInsuffi('+argWithName+')"  class="insuf-btn">Insufficiency</button></td>';
                // html += '<td id="phone_number'+data[i].candidate_id+'"><button id="approvr_'+data[i].candidate_id+'" '+approvDisable+' onclick="modalapprov('+argWithName+')"  class="app-btn"><i class="fa fa-check bac-gr"></i> Approve</button></td>';
                 
                html += '</tr>';

                internal_tat_details_html += '<tr>';
                internal_tat_details_html += '<td>'+j+'</td>';
                internal_tat_details_html += '<td>'+data[i].component_name+' (Form '+data[i]['formNumber']+')</td>';

                $('#assigned-to-input-qc-date').html(((data[0]['candidate_details']['created_date'] != '' && data[0]['candidate_details']['created_date'] != null) ? moment(data[0]['candidate_details']['created_date']).format(selected_datetime_format['js_code']) : "-"));
                var inputqc_status_date = '-',
                    inputqc_verification_days_taken = '-',
                    inputqc_status_date_time = '-';
                if(data[i].inputqc_status_date != '' && data[i].inputqc_status_date != null && data[i].inputqc_status_date != 'NA') {
                    inputqc_status_date = data[i].inputqc_status_date;
                    var case_submitted_date_time_splitted = '',
                        inputqc_status_date_time_splitted = inputqc_status_date.split(' ')[0],
                        case_submitted_date_splitted = case_submitted_date_time_splitted.split('-'),
                        inputqc_status_date_splitted = inputqc_status_date_time_splitted.split('-'),
                        case_submitted_date_time = new Date(case_submitted_date_splitted[1]+'/'+case_submitted_date_splitted[0]+'/'+case_submitted_date_splitted[2]),
                        inputqc_status_date_time = new Date(inputqc_status_date_splitted[1]+'/'+inputqc_status_date_splitted[0]+'/'+inputqc_status_date_splitted[2]),
                        inputqc_verification_days_taken = daysdifference(case_submitted_date_time,inputqc_status_date_time),
                        inputqc_status_date = moment(inputqc_status_date).format(selected_datetime_format['js_code']);
                   if (data[0]['candidate_details']['case_submitted_date'] !=null && data[0]['candidate_details']['case_submitted_date'] !='') {
                    case_submitted_date_time_splitted = data[0]['candidate_details']['case_submitted_date'].split(' ')[0];
                   }
                    if(inputqc_verification_days_taken > 1) {
                        inputqc_verification_days_taken += ' Days';
                    } else {
                        inputqc_verification_days_taken += ' Day';
                    }
                }
                $('#verified-by-input-qc-date').html(inputqc_status_date);
                $('#days-taken-input-qc').html(inputqc_verification_days_taken);

                var analyst_specialist_status_date = '-',
                    analyst_specialist_verification_days_taken = '-',
                    analyst_status_date_time = '-';
                if(data[i].inputqc_status_date != '' && data[i].inputqc_status_date != null && data[i].inputqc_status_date != 'NA' &&
                    data[i].analyst_status_date != '' && data[i].analyst_status_date != null && data[i].analyst_status_date != 'NA') {
                    analyst_specialist_status_date = data[i].analyst_status_date;
                    var analyst_status_date_time_splitted = analyst_specialist_status_date.split(' ')[0],
                        analyst_status_date_splitted = analyst_status_date_time_splitted.split('-'),
                        analyst_status_date_time = new Date(analyst_status_date_splitted[1]+'/'+analyst_status_date_splitted[0]+'/'+analyst_status_date_splitted[2]),
                        analyst_specialist_verification_days_taken = daysdifference(inputqc_status_date_time,analyst_status_date_time),
                        inputqc_status_date = moment(inputqc_status_date).format(selected_datetime_format['js_code']),
                        analyst_specialist_status_date = moment(analyst_specialist_status_date).format(selected_datetime_format['js_code']);
                    if(analyst_specialist_verification_days_taken > 1) {
                        analyst_specialist_verification_days_taken += ' Days';
                    } else {
                        analyst_specialist_verification_days_taken += ' Day';
                    }
                }

                $('#assigned-to-output-qc-date').html(inputqc_status_date);
                $('#verified-by-output-qc-date').html(analyst_specialist_status_date);
                $('#days-taken-output-qc').html(analyst_specialist_verification_days_taken);

                var outputqc_status_date = '-',
                    outputqc_verification_days_taken = '-',
                    outputqc_status_date_time = '-';
                if(data[i].analyst_status_date != '' && data[i].analyst_status_date != null && data[i].analyst_status_date != 'NA' &&
                    data[i].outputqc_status_date != '' && data[i].outputqc_status_date != null && data[i].outputqc_status_date != 'NA') {
                    outputqc_status_date = data[i].outputqc_status_date;
                    var outputqc_status_date_time_splitted = outputqc_status_date.split(' ')[0],
                        outputqc_status_date_splitted = outputqc_status_date_time_splitted.split('-'),
                        outputqc_status_date_time = new Date(outputqc_status_date_splitted[1]+'/'+outputqc_status_date_splitted[0]+'/'+outputqc_status_date_splitted[2]);
                        outputqc_verification_days_taken = daysdifference(analyst_status_date_time,outputqc_status_date_time);
                        outputqc_status_date = get_date_formate(outputqc_status_date);
                    if(outputqc_verification_days_taken > 1) {
                        outputqc_verification_days_taken += ' Days';
                    } else {
                        outputqc_verification_days_taken += ' Day';
                    }
                }
                internal_tat_details_html += '<td>'+analyst_specialist_status_date+'</td>';
                internal_tat_details_html += '<td>'+outputqc_status_date+'</td>';
                internal_tat_details_html += '<td>'+outputqc_verification_days_taken+'</td>';
                internal_tat_details_html += '</tr>'; 

              j++; 
            }
        }else{
            html+='<tr><td colspan="8" class="text-center">No Case Found.</td></tr>'; 
        }
            $('#get-case-data').html(html); 
            $('#view-internal-tat-details-table').html(internal_tat_details_html); 
        } 
    });
}


function list_tat_log(candidate_id){
    $('#view_tat_log_dailog').modal('show');
    var candidate_id = btoa(candidate_id);
    
    $.ajax({
        type: "POST",
        url: base_url+"adminViewAllCase/get_tat_log_data",
        data:{ 
            candidate_id:candidate_id
        },
        dataType: "json",
        success: function(data){
            console.log(JSON.stringify(data))
            var html = '';
            var j = 1;
            for (var i = 0; i < data.length; i++) {
                var formNumer = data[i].form_number;
                html += '<tr id="tr_'+data[i].tat_log_id+'">'; 
                    html += '<td>'+(j++)+'</td>'; 
                    html += '<td>'+data[i].tat_start_date+'</td>'; 
                    html += '<td>'+data[i].tat_pause_date+'</td>'; 
                    html += '<td>'+data[i].tat_re_start_date+'</td>'; 
                    html += '<td>'+data[i].tat_end_date+'</td>'; 
                    html += '<td>'+data[i].component_name.replace('_',' ')+'</td>'; 
                    html += '<td>'+(parseInt(formNumer)+1)+'</td>';
                    var empInfo = '';
                    var role = '';
                    var team_employee_email = '';
                    if(data[i].user_detail != null && data[i].user_detail != ''){
                        var empInfo = JSON.parse(data[i].user_detail)
                        role = empInfo['role']
                        team_employee_email = empInfo['team_employee_email']
                    }else{
                        role='-';
                        team_employee_email='-';
                    }
                    
                    html += '<td>'+role+'</td>';
                    html += '<td>'+team_employee_email+'</td>';
                html += '</tr>';
            }
           
            $('#list_tat_log_data').html(html)
            
                 
        },
        error: function (jqXHR, exception) {
            $('#all_case_tat_cancle').removeClass('disabled');
            $('#all_case_tat_cancle').prop('disabled',false);
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }

            $('#password_error').html(msg);
        }
    });    
}


function tat_confirm_dialog(candidate_id,type){
    $('#tat_confirm_dailog').modal('show');
    if(type == 'pause'){
        $('#tat_lable').html('TAT will pause')
    }else{
        $('#tat_lable').html('TAT will re-start')
    }
    var btnHtml = '';
    btnHtml += '<button onclick="tat_confirm_action('+candidate_id+',\''+type+'\')" class="btn bg-blu btn-submit text-white float-right">Confirm</button>'
    btnHtml += '<button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>'
    $('#btnTatDiv').html(btnHtml)    
}

function tat_confirm_action(candidate_id,type){
    $.ajax({
        type: "POST",
        url: base_url+"adminViewAllCase/tatDateUpdate",
        data:{
            type:type,
            candidate_id:candidate_id
        },
        dataType: "json",
        success: function(data){
            // console.log(JSON.stringify(data)) 
            // alert(data.status)
            $('#all_case_tat_cancle').removeClass('disabled');
            $('#all_case_tat_cancle').prop('disabled',false);
            $('#all_case_tat').removeClass('disabled');
            $('#all_case_tat').prop('disabled',false);
            $('#all_case_tat').html('Confirm')
            if(data.status){
                $('#tat_confirm_dailog').modal('hide');
                toastr.success('All case TAT updated successfully.');    
            }else{
                toastr.error('All case TAT update failed.');  
            }
                 
        },
        error: function (jqXHR, exception) {
            $('#all_case_tat_cancle').removeClass('disabled');
            $('#all_case_tat_cancle').prop('disabled',false);
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }

            $('#password_error').html(msg);
        }
    }); 
}

function override_team(candidate_id,component_id,component_name,postion,i,element_id){
    var team_id = $('#'+element_id).val(); 
    // alert('candidate_id:'+candidate_id+'\n component_id:'+component_id+'\n component_name:'+component_name+'\n postion:'+postion+'\n element_id:'+element_id+'\n team_id:'+team_id)

    $('#override_confirm_dailog').modal('show')
    $('#btnOverrideDiv').html('<button onclick="override_team_action('+candidate_id+',\''+component_id+'\',\''+component_name+'\',\''+postion+'\',\''+team_id+'\','+i+')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')
    

}
 
function override_team_action(candidate_id,component_id,component_name,postion,team_id,i){

    // alert('candidate_id:'+candidate_id+'\n component_id:'+component_id+'\n component_name:'+component_name+'\n postion:'+postion+'\n team_id:'+team_id)
     $.ajax({
        type: "POST",
        url: base_url+"am/override_team",
        data:{
            candidate_id:candidate_id,
            component_id:component_id,
            component_name:component_name,
            postion:postion,
            team_id:team_id
        },
        dataType: "json",
        success: function(data){ 
            $('#override_confirm_dailog').modal('hide')
            if (data.status == '1' && data.logStatus == '1') {
                $('#analyst_name_'+i).html(data.name)
                toastr.success('priority has been update successfully.'); 
            }else if(data.status == '1' && data.logStatus == '0') {
                toastr.error('assignment has been update successfully. but log data is not inserted.');
            }else{
                toastr.error('assignment status update failed.');
            }
        }
    });
}


function insuff_override_team(candidate_id,component_id,component_name,postion,i,element_id){
    var team_id = $('#'+element_id).val(); 
    // alert('candidate_id:'+candidate_id+'\n component_id:'+component_id+'\n component_name:'+component_name+'\n postion:'+postion+'\n element_id:'+element_id+'\n team_id:'+team_id)
    $('#override_confirm_dailog').modal('show')
    $('#btnOverrideDiv').html('<button onclick="insuff_override_team_action('+candidate_id+',\''+component_id+'\',\''+component_name+'\',\''+postion+'\',\''+team_id+'\','+i+')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')    
}
 
function insuff_override_team_action(candidate_id,component_id,component_name,postion,team_id,i){
    alert('candidate_id:'+candidate_id+'\n component_id:'+component_id+'\n component_name:'+component_name+'\n postion:'+postion+'\n team_id:'+team_id)
    $.ajax({
        type: "POST",
        url: base_url+"am/insuff_override_team",
        data:{
            candidate_id:candidate_id,
            component_id:component_id,
            component_name:component_name,
            postion:postion,
            team_id:team_id
        },
        dataType: "json",
        success: function(data){ 
            $('#override_confirm_dailog').modal('hide')
            if (data.status == '1' && data.logStatus == '1') {
                $('#insuf_name_'+i).html(data.name)
                toastr.success('priority has been update successfully.'); 
            }else if(data.status == '1' && data.logStatus == '0') {
                toastr.error('assignment has been update successfully. but log data is not inserted.');
            }else{
                toastr.error('assignment status update failed.');
            }
        }
    });
}


function priority_status(candidate_id,priority_value,role,team_id){ 

    $('#priority_confirm_dailog').modal('show')
    var p = $("#action_status").val(); 
    var priority ='';
     if(p == '0'){
                    priority = 'Low priority'
             
    }else if(p == '1'){  
            priority = 'Medium priority'
   
    }else if(p == '2'){  
            priority = 'High priority'
      
    } 
    $("#priority-div").html(priority);
    $('#btnPriorityDiv').html('<button onclick="priority_change_action('+candidate_id+',\''+priority_value+'\',\''+role+'\',\''+team_id+'\')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')
    
}

function priority_change_action(candidate_id,priority_value,role,team_id){
    // alert("candidate_id: "+candidate_id+" priority_value: "+priority_value)
    // $('#priority_confirm_dailog').modal('hide')

    $.ajax({
        type: "POST",
        url: base_url+"am/priorityUpdate",
        data:{
            candidate_id:candidate_id,
            priority_value:priority_value,
            role:role,
            team_id:team_id
        },
        dataType: "json",
        success: function(data){ 
            $('#priority_confirm_dailog').modal('hide')
            if (data.status == '1' && data.logStatus == '1') {
                toastr.success('Priority has been updated successfully.'); 
            }else if(data.status == '1' && data.logStatus == '0') {
                toastr.error('Priority has been update successfully. but log data is not inserted.');
            }else{
                toastr.error('Priority status update failed.');
            }
        }
    });
}

function sendMial(candidate_id,component_id){
    // alert('Model')
    $('#sendMail').modal('show')
    $.ajax({
        type: "POST",
        url: base_url+"inputQc/insuffUpdateStatus",
        data:{
            candidate_id:candidate_id,
            component_id:component_id
        },
        dataType: "json",
        success: function(data){ 

        }
    });
}

function modalInsuffi(candidate_id,component_id,componentname,first_name,email_id){
    // var email_id = email_id;
    $('#modalInsuffi').modal('show')
    $('#componentNameInsuff').html('In '+componentname)
    $('#insuffMailDetail').val('Hi '+first_name+',\nWe noticed that your Address details provided are not sufficient to process your Back Ground Check initiated by your employer.')
    $('#btnInsuffiDiv').html('<button onclick="insufiincincyUpdate('+candidate_id+','+component_id+',\''+email_id+'\')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Send</button>')
    
}
function insufiincincyUpdate(candidate_id,component_id,email_id){
    var candidateUrl = $('#candidateUrl').val()
    var insuffMailDetail = $('#insuffMailDetail').val()
     $.ajax({
        type: "POST",
        url: base_url+"inputQc/insuffUpdateStatus",
        data:{

            candidate_id:candidate_id,
            component_id:component_id,
            candidateUrl:candidateUrl,
            email_id:email_id,
            insuffMailDetail:insuffMailDetail
        },
        dataType: "json",
        success: function(data){
            $('#modalInsuffi').modal('hide')
            if (data.status == '1') {
                load_case(candidate_id)
                let html = "<span class='text-success'>Success data updated</span>";
                $('#error-team').html(html);
                toastr.success('New data has been update successfully.');
                 
            } else {
                let html = "<span class='text-danger'>Somthing went wrong.</span>";
                $('#error-team').html(html);
                toastr.error('New data has been update failed.');
            }
        }
    });
}
function modalapprov(candidate_id,component_id,componentname,first_name,email_id){
    // alert('Model')
    $('#modalapprov').modal('show') 
    $('#componentNameApprove').html('In '+componentname)
    $('#insuffMailDetail').val('Hi '+first_name+',\nWe noticed that your Address details provided are not sufficient to process your Back Ground Check initiated by your employer.')
    $('#btnApproveDiv').html('<button onclick="approvUpdate('+candidate_id+','+component_id+')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Send</button>')
    
}
 
function approvUpdate(candidate_id,component_id){ 
    var approveComment = $('#approve-comment').val()

    alert(approveComment)
     $.ajax({
        type: "POST",
        url: base_url+"inputQc/approveUpdateStatus",
        data:{

            candidate_id:candidate_id,
            component_id:component_id,  
            approveComment:approveComment
        },
        dataType: "json",
        success: function(data){
            $('#modalapprov').modal('hide')
            if (data.status == '1') {
                load_case(candidate_id)
                let html = "<span class='text-success'>Success data updated</span>";
                $('#error-team').html(html);
                toastr.success('New data has been update successfully.');
                 
            }else if(data.status == '2'){
                toastr.error(data.msg);
            }else {
                 // $('#status_'+candidate_id).html('<span class="text-success">Completed<span>')
                let html = "<span class='text-danger'>Somthing went wrong.</span>";
                $('#error-team').html(html);
                toastr.error('New data has been update failed.');
            }
        }
    });
}
function randomString(length) {
    var result = '';
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}
function getComponentBasedData(candidate_id,component_id,postion,component_name,form_values){
   
    $.ajax({
        type: "POST",
        url: base_url+"adminViewAllCase/getComponentBasedData/",
        data:{
            candidate_id:candidate_id,
            component_id:component_id,
            postion:postion
        },
        dataType: "json",
        success: function(data){  

            switch(component_id){
                case 1:
                    criminal_checks(data,postion,component_name)
                    break;
                case 2:
                    court_records(data,postion,component_name)
                    break;
                case 3:
                    document_check(data,postion,component_name)
                    break;
                case 4:
                    drugtest(data,postion,component_name)
                    break;
                case 5:
                    globaldatabase(data,postion,component_name)
                    break;
                case 6:
                    current_employment(data,postion,component_name)
                    break;
                case 7:
                    education_details(data,postion,component_name)
                    break;
                case 8:
                    present_address(data,postion,component_name)
                    break;
                case 9:
                    permanent_address(data,postion,component_name)
                    break;
                case 10:
                    previous_employment(data,postion,component_name)
                    break;
                case 11:
                    reference(data,postion,component_name)
                    break;
                case 12:
                    previous_address(data,postion,component_name)
                    break;
                case 14:
                    directorship_check(data,postion,component_name)
                    break;
                case 15:
                    global_aml_sanctions(data,postion,component_name)
                    break;
                case 16:
                    driving_License(data,postion,component_name)
                    break;
                case 17:
                    credit_cibil_check(data,postion,component_name)
                    break;
                case 18:
                    bankruptcy_check(data,postion,component_name)
                    break;
                case 19:
                    adverse_database_media_check(data,postion,component_name)
                    break;
                case 20:
                    cv_check(data,postion,component_name)
                    break;
                case 21:
                    health_checkup_check(data,postion,component_name)
                    break;
                case 22:
                    employement_gap_check(data,postion,component_name)
                    break;
                case 23:
                    landlord_reference(data,postion,component_name);
                    break;
                case 24:
                    covid_19(data,postion,component_name);
                    break;
                 case 25:
                    social_media(data,postion,component_name);
                    break;
                case 26:
                    civil_check(data,postion,component_name)
                    break;
                 case 27:
                    right_to_work(data,component_name)
                    break;
                case 28:
                    sex_offender(data,component_name)
                    break;
                case 29:
                    politically_exposed(data,component_name)
                    break;
                case 30:
                    india_civil_litigation(data,component_name)
                    break;
                case 31:
                    mca(data,component_name)
                    break;
                case 32:
                    nric(data,component_name)
                    break;
                case 33:
                    gsa(data,component_name)
                    break;
                case 34:
                    oig(data,component_name)
                    break;
                default:
                    break;
            }

        }
    });
}



// diffrent check forms
function civil_check(data,postion,component_name){ 

    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // address pin_code city  state  approved_doc
    let html='';
    if(data.status != '0'){

        var address =  JSON.parse(data.component_data.address)
        var pin_code =  JSON.parse(data.component_data.pin_code)
        var city =  JSON.parse(data.component_data.city)
        var state =  JSON.parse(data.component_data.state)
        // alert(JSON.stringify(info))
        var j = 1;
        var i = postion;
        // for (var i = 0; i < address.length; i++) {
       
            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '      <div class="pg-txt-cntr">';
            html += '         <div class="pg-steps d-none">Step 2/6</div>';
            html += '         <h6 class="full-nam2"> Address Details '+(j++)+'</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-8">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Address</label>';
            html += '                  <textarea class="fld form-control readonly " rows="4" id="address">'+address[i].address+'</textarea>';
            html += '               </div>';
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Pin Code</label>';
            html += '                  <input name="" readonly value="'+pin_code[i].pincode+'" class="fld form-control pincode" id="pincode" type="text">';
            html += '               </div>';
            html += '            </div>';

            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>City/Town</label>';
            html += '                  <input name="" readonly value="'+city[i].city+'" class="fld form-control city" id="city" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>State</label>';
            html += '                  <input name="" readonly value="'+state[i].state+'"  class="fld form-control state" id="state" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';  
            html += '      </div>';
            html += '   </div>';
            // alert(info[i].address)
        // }
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}



// diffrent check forms
function criminal_checks(data,postion,component_name){ 

    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // address pin_code city  state  approved_doc
    let html='';
    if(data.status != '0'){

        var address =  JSON.parse(data.component_data.address)
        var pin_code =  JSON.parse(data.component_data.pin_code)
        var city =  JSON.parse(data.component_data.city)
        var state =  JSON.parse(data.component_data.state)
        var component_status =   data.component_data.analyst_status.split(',');
        // alert(JSON.stringify(info))
        var j = 1;
        var i = postion;
  
            var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
        // for (var i = 0; i < address.length; i++) {
       
            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '      <div class="pg-txt-cntr">';
            html += '         <div class="pg-steps d-none">Step 2/6</div>';
            html += '         <h6 class="full-nam2"> Address Details '+(j++)+'</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-8">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Address</label>';
            html += '                  <textarea class="fld form-control readonly " rows="4" id="address">'+address[i].address+'</textarea>';
            html += '               </div>';
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Pin Code</label>';
            html += '                  <input name="" readonly value="'+pin_code[i].pincode+'" class="fld form-control pincode" id="pincode" type="text">';
            html += '               </div>';
            html += '            </div>';

            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>City/Town</label>';
            html += '                  <input name="" readonly value="'+city[i].city+'" class="fld form-control city" id="city" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>State</label>';
            html += '                  <input name="" readonly value="'+state[i].state+'"  class="fld form-control state" id="state" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';  
            html += '      </div>';
            html += '   </div>';
            // alert(info[i].address)

             if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

        // }
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}

function court_records(data,postion,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    let html='';
    if(data.status != '0'){
        var address =  JSON.parse(data.component_data.address)
        var pin_code =  JSON.parse(data.component_data.pin_code)

        var city =  JSON.parse(data.component_data.city)
        var state =  JSON.parse(data.component_data.state)
        var address_proof_doc =  JSON.parse(data.component_data.address_proof_doc)
        var component_status =   data.component_data.analyst_status.split(',');
        var insuff_remarks =  JSON.parse(data.component_data.insuff_remarks)
        var j = 1;
        var i = postion;
        // for (var i = 0; i < address.length; i++) {
         var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 

            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '      <div class="pg-txt-cntr">';
            html += '         <div class="pg-steps d-none">Step 2/6</div>';
            html += '         <h6 class="full-nam2"> Address Details '+(j++)+'</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-8">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Address Proof</label>';
            html += '                  <textarea class="fld form-control" readonly rows="4" id="address">'+address[i].address+'</textarea>';
            html += '               </div>';
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Pin Code</label>';
            html += '                  <input name="" readonly value="'+pin_code[i].pincode+'" class="fld form-control pincode" id="pincode" type="text">';
            html += '               </div>';
            html += '            </div>';

            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>City/Town</label>';
            html += '                  <input name="" readonly value="'+city[i].city+'" class="fld form-control city" id="city" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>State</label>';
            html += '                  <input name="" readonly value="'+state[i].state+'"  class="fld form-control state" id="state" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';  
            html += '      </div>';
            html += '   </div>';

              if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

             html += '         <div class="row mt-3">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Address Proof</div>';
            if(address_proof_doc[i] != null && address_proof_doc[i] != ''){
                    var address_proof = address_proof_doc[i];
                    var address_doc = address_proof.split(","); 
                    for (var n = 0; n < address_doc.length; n++) {
                        var url = img_base_url+"../uploads/address-docs/"+address_doc[n]
                        if ((/\.(jpg|jpeg|png)$/i).test(address_doc[n])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+address_doc[n]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+address_doc[n]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(address_doc[n])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+address_doc[n]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
                        
        html += '            </div>';
                html += '   </div>';

        // }
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
 
}
 
function document_check(data,postion,component_name){ 
    // console.log('document_check : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // alert(postion)
    let html='';
        if(data.status != '0'){
           

            var formValues = JSON.parse(data.component_data.form_values)
            formValues = JSON.parse(formValues);
            var component_status =  data.component_data.analyst_status.split(',');

             var insuff_remarks = '';
            if (component_status[position] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 

            var passport_doc = data.component_data.passport_doc
            if(passport_doc == null || passport_doc == ''){
                passport_doc_length= 0;
            }else{
                passport_doc = passport_doc.split(",")
                passport_doc_length = passport_doc.length
            }
            
            var pan_card_doc = data.component_data.pan_card_doc
            if(pan_card_doc == null || pan_card_doc == ''){
                pan_card_doc_length = 0;
            }else{
                pan_card_doc = pan_card_doc.split(",")
                pan_card_doc_length= pan_card_doc.length
            }
            

            var adhar_doc = data.component_data.adhar_doc
            if(adhar_doc == null || adhar_doc == ''){
                adhar_doc_length = 0;
            }else{
                adhar_doc = adhar_doc.split(",");
                adhar_doc_length = adhar_doc.length;
            }
             

            var voter_doc = data.component_data.voter_doc
            if(voter_doc == null || voter_doc == ''){
                voter_doc_length = 0;
            }else{
                voter_doc = voter_doc.split(",");
                voter_doc_length = voter_doc.length;
            }
                
            var inputQcStatus = data.component_data.status.split(',');

            // form_values
             
            if(data.component_data.aadhar_number.length  > 0  && $.inArray('2',formValues.document_check) !== -1){
               

                html += '         <div class="row mt-3">';
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm-hd">Adhar Card</div>'; 
                html += '                  <input name="" readonly class="fld form-control adhar_number" id="adhar_number" type="text" value="'+data.component_data.aadhar_number+'">';
                                    // for loop will start
                if(adhar_doc !='' && adhar_doc !=null && data.component_data.aadhar_number !='' && data.component_data.aadhar_number !=null && data.component_data.aadhar_number !='undefined' ){
                    
                    for (var i = 0; i < adhar_doc.length; i++) {
                      
                        var url = img_base_url+"../uploads/aadhar-docs/"+adhar_doc[i]

                        if ((/\.(jpg|jpeg|png)$/i).test(adhar_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+adhar_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';

                        }else if((/\.(pdf)$/i).test(adhar_doc[i])){

                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+adhar_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            // onclick="view_document_modal('+data.component_data.candidate_id+',\'aadhar-docs\')" 
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';

                        }  
                    } 
                }else{ 
                    html += '   <label class="font-weight-bold">Note: Attechment Not Found. </label><br>';
                }
                // for loop will end 
                html += '            </div>';
            }      

            if(data.component_data.pan_number.length > 0 && $.inArray('1',formValues.document_check) !== -1){
               
                   
                    html += '            <div class="col-md-4">';
                    html += '               <div class="pg-frm-hd">PAN Card</div>';
                    // html += '                  <label class="font-weight-bold">Status: </label>'+form_status;
                    html += '                  <input name="" readonly class="fld form-control city" id="city" type="text" value="'+data.component_data.pan_number+'">';
                                        // for loop will start 
                    if(pan_card_doc != '' && pan_card_doc != null && data.component_data.pan_number !='' &&  data.component_data.pan_number !=null &&  data.component_data.pan_number !='undefined' ){
                    
                        for (var i = 0; i < pan_card_doc.length; i++) {
                
                            var url = img_base_url+"../uploads/pan-docs/"+pan_card_doc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(pan_card_doc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+pan_card_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';

                            }else if((/\.(pdf)$/i).test(pan_card_doc[i])){
                                
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+pan_card_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';

                            }
                            // html += '   <button class="insuf-btn" id="insuf_btn_'+pancardStatus+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+pancardStatus+',\'double\')">Insufficiency</button>';
                            // html += '   <button class="app-btn" id="app_btn_'+pancardStatus+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+pancardStatus+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';


                        }
                    }else{
                
                        html += '   <label class="font-weight-bold">Note: Attechment Not Found. </label><br>';
                
                    }
                                    // for loop will end  
                    html += '        </div>';
            }


            if(data.component_data.passport_number !='' && data.component_data.passport_number !=null  && $.inArray('3',formValues.document_check) !== -1 ){
            
                 
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm-hd">Passport</div>';
                // html += '                  <label class="font-weight-bold">Status: </label>'+form_status;
                html += '                  <input name="" readonly class="fld form-control city" id="city" type="text" value="'+data.component_data.passport_number+'">';
                                // for loop will start passport_doc.length
                if( passport_doc !='' && passport_doc !=null && data.component_data.passport_number !='' && data.component_data.passport_number !=null && data.component_data.passport_number !='undefined'){
            
                    for (var i = 0; i < passport_doc.length; i++) {
            
                        var url = img_base_url+"../uploads/proof-docs/"+passport_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(passport_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+passport_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';

                        }else if((/\.(pdf)$/i).test(passport_doc[i])){
                            
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+passport_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'"  class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';

                        }
                    }
                }else{

                    html += '   <label class="font-weight-bold">Note: Attechment Not Found. </label><br>';
                }
                                // for loop will end  
                html += '         </div>';
            }
                
            
            if(data.component_data.voter_id !='' && data.component_data.voter_id !=null  && $.inArray('4',formValues.document_check) !== -1 ){
            
                 
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm-hd">Voter ID</div>';
                // html += '                  <label class="font-weight-bold">Status: </label>'+form_status;
                html += '                  <input name="" readonly class="fld form-control city" id="city" type="text" value="'+data.component_data.voter_id+'">';
                                // for loop will start passport_doc.length
                if( voter_doc !='' && voter_doc !=null && data.component_data.voter_id !='' && data.component_data.voter_id !=null && data.component_data.voter_id !='undefined'){
            
                    for (var i = 0; i < voter_doc.length; i++) {
            
                        var url = img_base_url+"../uploads/voter-docs/"+voter_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(voter_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+voter_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';

                        }else if((/\.(pdf)$/i).test(voter_doc[i])){
                            
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+voter_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'"  class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';

                        }
                    }
                }else{

                    html += '   <label class="font-weight-bold">Note: Attechment Not Found. </label><br>';
                }
                                // for loop will end  
                html += '         </div>';
            }
              
            html += '      </div>';

                if (component_status[position] == '3') {
                    html += '<div class="row">';
                     html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                    html += '<div class="col-md-12">';
                    html += '<label>Insuff Remark Comment</label>'; 
                    html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[position].insuff_remarks+'</textarea>'; 
                    html += '</div>';
                    html += '</div>';
                }
      
        html += '         <div class="row">';
            html += '            <div class="col-md-12">';
            html += '               <div class="pg-submit text-right">';
            html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}

function drugtest(data,position,component_name){ 
    console.log('drugtest : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    var formValues = JSON.parse(data.component_data.form_values)
    formValues = JSON.parse(formValues);
    var address = JSON.parse(data.component_data.address)
    var candidate_name = JSON.parse(data.component_data.candidate_name)
    var father_name = JSON.parse(data.component_data.father__name)
    var dob = JSON.parse(data.component_data.dob)
    var mobile_number = JSON.parse(data.component_data.mobile_number);

    

    drugtestTypes = ['5-Panel','6-Panel','7-Panel','9-Panel','10-Panel','12-Panel']
    drugtestTypesIds = ['1','2','3','4','5','6']

    let html='';
    if(data.status != '0'){
        var i = position;

         var component_status =  data.component_data.analyst_status.split(',');
var insuff_remarks =  JSON.parse(data.component_data.insuff_remarks);
var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
        drugtestTypesId = formValues['drug_test'][i];
        // for(var i=0;i<candidate_name.length;i++){
            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '      <div class="pg-txt-cntr">';
            html += '         <div class="pg-steps  d-none">Step 2/6</div>';
            if($.inArray(drugtestTypesId,drugtestTypes)){
                // alert(drugtestTypes[drugtestTypesIds.indexOf(drugtestTypesId)]) 
            html += '               <h6 class="full-nam2 font-weight-bold">Test Details '+drugtestTypes[drugtestTypesIds.indexOf(drugtestTypesId)]+'</h6> ';
            }
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Candidate Name</label>';
            html += '                  <input name="" readonly value="'+candidate_name[i].candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
            html += '               </div>'; 
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Father Name</label>';
            html += '                  <input name="" readonly value="'+father_name[i].father_name+'" class="fld form-control city" id="city" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Date Of Birth(DOB)</label>';
            html += '                  <input name="" readonly value="'+dob[i].dob+'"  class="fld form-control state" id="state" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';

            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Phone Number</label>';
            html += '                  <input name="" readonly value="'+mobile_number[i].mobile_number+'"  class="fld form-control state" id="state" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-6">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Address</label>';
            html += '                  <textarea class="fld form-control" readonly  rows="2" id="address">'+address[i].address+'</textarea>';
            html += '               </div>';
            html += '            </div>'; 
            html += '         </div>';
            html += '      </div>';
            html += '   </div>';

            if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
            html += '   <hr>';
        // }        
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
       
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}

function globaldatabase(data,position,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

        var component_status =  data.component_data.analyst_status; 
        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Candidate Name</label>';
        html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Father Name</label>';
        html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Date Of Birth(DOB)</label>';
        html += '                  <input name="" readonly value="'+data.component_data.dob+'"  class="fld form-control state" id="state" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';

        html += '         <div class="row d-none">';
        html += '            <div class="col-md-4 d-none">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Phone Number</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.mobile_number+'"  class="fld form-control state" id="state" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-6">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Address</label>';
        // html += '                  <textarea class="fld form-control" readonly  rows="2" id="address">'+data.component_data.address+'</textarea>';
        html += '               </div>';
        html += '            </div>'; 
        html += '         </div>';  

          if (component_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}

function current_employment(data,position,component_name){
    // console.log("current_employment: "+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';

    html += '<div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">'; 
    html += '         <h6 class="full-nam2 d-none">CURRENT EMPLOYMENT</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Designation</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.desigination+'" class="fld form-control" id="designation" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Department</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.department+'"  class="fld form-control" id="department" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Employee ID</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.employee_id+'"  class="fld form-control" id="employee_id" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '         </div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Company Name</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.company_name+'" class="fld form-control" id="company-name" type="text">';
    html += '               </div>';
    html += '            </div>';

        html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Company Website</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.company_url+'" class="fld form-control" id="company-name" type="text">';
    html += '               </div>';
    html += '            </div>';

    html += '            <div class="col-md-8">';
    html += '                <div class="pg-frm">';
    html += '                   <label>Address</label>';
    html += '                   <textarea readonly="" class="add" id="address" type="text">'+data.component_data.address+'</textarea>';
    html += '                </div>';
    html += '             </div>';
    html += '         </div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Annual CTC</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.annual_ctc+'" class="fld" id="annual-ctc" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '            <div class="col-md-8">';
    html += '                <div class="pg-frm">';
    html += '                   <label>Reason For Leaving</label>';
    html += '                   <input name="" readonly="" value="'+data.component_data.reason_for_leaving+'" class="fld" id="reasion"  type="text">';
    html += '                </div>';
    html += '             </div>';
    html += '         </div>';
  /*  html += '         <div class="row">';
    html += '             <div class="col-md-5">';
    html += '                <div class="pg-frm-hd">Joining Date</div>';
    html += '             </div>';
    html += '             <div class="col-md-4">';
    html += '                <div class="pg-frm-hd">relieving date</div>';
    html += '             </div>';
    html += '         </div>';*/
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
       html += '               <div class="pg-frm">';
    html += '               <label>Joining Date</label>';
    html += '                <input name="" readonly="" value="'+data.component_data.joining_date+'"  class="fld form-control mdate" id="joining-date" type="text">';
     
    html += '            </div>';
    html += '            </div>';
    html += '            <div class="col-md-1">'; 
    html += '           </div>';
    html += '           <div class="col-md-3 ml-2">';
    html += '               <div class="pg-frm">';
    html += '            <label>Relieving Date</label>';
    html += '                <input name="" readonly="" value="'+data.component_data.relieving_date+'"  class="fld form-control mdate" id="relieving-date" type="text">';
     
    html += '         </div>';
    html += '         </div>';
    html += '         </div>';
    html += '         <div class="row mt-2">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Reporting Manager Name</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_name+'"  class="fld form-control" id="reporting-manager-name" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Reporting Manager Designation</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_desigination+'"  class="fld form-control" id="reporting-manager-designation" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Reporting Manager Contact Number</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_contact_number+'"  class="fld form-control" id="reporting-manager-contact" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '         </div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>HR Name</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.hr_name+'"  class="fld form-control" id="hr-name" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>HR Contact Number</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.hr_contact_number+'"  class="fld form-control" id="hr-contact" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>HR Email</label>';
    html += '                  <input name="" readonly="" value="-"  class="fld form-control" id="hr-email" type="text">';
    html += '               </div>';
    html += '            </div>';
    
    html += '         </div>';

    var component_status =  data.component_data.analyst_status;

            if (component_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.Insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
    html += '         <div class="row mt-3">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Appointment Letter</div>';
            if(data.component_data.appointment_letter != null || data.component_data.appointment_letter != ''){
                    var appointment_letterDoc = data.component_data.appointment_letter;
                    var appointment_letterDoc = appointment_letterDoc.split(",");
                    for (var i = 0; i < appointment_letterDoc.length; i++) {
                        var url = img_base_url+"../uploads/appointment_letter/"+appointment_letterDoc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(appointment_letterDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+appointment_letterDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+appointment_letterDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(appointment_letterDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+appointment_letterDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
                        
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Experience/ Relieving Letter</div>';
         if(data.component_data.experience_relieving_letter != null || data.component_data.experience_relieving_letter != ''){
                    var experience_relieving_letter_Doc = data.component_data.experience_relieving_letter;
                    var experience_relieving_letter_Doc = experience_relieving_letter_Doc.split(",");
                    for (var i = 0; i < experience_relieving_letter_Doc.length; i++) {
                        var url = img_base_url+"../uploads/experience_relieving_letter/"+experience_relieving_letter_Doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(experience_relieving_letter_Doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+experience_relieving_letter_Doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+experience_relieving_letter_Doc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(experience_relieving_letter_Doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+experience_relieving_letter_Doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Pay Slip</div>';
         if(data.component_data.last_month_pay_slip != null || data.component_data.last_month_pay_slip != ''){
                    var last_month_pay_slip_doc = data.component_data.last_month_pay_slip;
                    var last_month_pay_slip_doc = last_month_pay_slip_doc.split(",");
                    for (var i = 0; i < last_month_pay_slip_doc.length; i++) {
                        var url = img_base_url+"../uploads/last_month_pay_slip/"+last_month_pay_slip_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(last_month_pay_slip_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+last_month_pay_slip_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+last_month_pay_slip_doc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(last_month_pay_slip_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0  text-wrap">'+last_month_pay_slip_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';

        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Resignation Acceptance Letter/ mail</div>';
         if(data.component_data.ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance != null || data.component_data.ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance != ''){
                    var bank_statement_resigngation_acceptance_doc = data.component_data.bank_statement_resigngation_acceptance;
                    var bank_statement_resigngation_acceptance_doc = bank_statement_resigngation_acceptance_doc.split(",");
                    for (var i = 0; i < bank_statement_resigngation_acceptance_doc.length; i++) {
                        var url = img_base_url+"../uploads/bank_statement_resigngation_acceptance/"+bank_statement_resigngation_acceptance_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(bank_statement_resigngation_acceptance_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+bank_statement_resigngation_acceptance_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+bank_statement_resigngation_acceptance_doc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(bank_statement_resigngation_acceptance_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+bank_statement_resigngation_acceptance_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
            
        html += '            </div>';
        html += '         </div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += '               </div>';
    html += '            </div>';
    html += '         </div>';
    html += '      </div>';
    html += '   </div>'; 

    $('#component-detail').html(html) 
}

function education_details(data,postion,component_name){ 
    // console.log('education_details : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // $('#component-detail').html('');
    let html='';
    if(data.status > 0){

        var type_of_degree = JSON.parse(data.component_data.type_of_degree)
        var major = JSON.parse(data.component_data.major)
        var university_board = JSON.parse(data.component_data.university_board)
        var college_school = JSON.parse(data.component_data.college_school)
        var address_of_college_school = JSON.parse(data.component_data.address_of_college_school)
        var course_start_date = JSON.parse(data.component_data.course_start_date)
        var course_end_date = JSON.parse(data.component_data.course_end_date)
        var registration_roll_number = JSON.parse(data.component_data.registration_roll_number)
        var type_of_course = JSON.parse(data.component_data.type_of_course)
        // if(data.component_data.year_of_passing != null || data.component_data.year_of_passing != ''){
        //  var year_of_passing = JSON.parse(data.component_data.year_of_passing)
        // }

        if(type_of_degree.length > 0){
            var j=1;
            var i = postion
            // for (var i = 0; i < type_of_degree.length; i++) {
                // alert(type_of_degree[i].type_of_degree)

             var component_status =  data.component_data.analyst_status.split(','); 
                var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
            
                html += '<div class="pg-cnt pl-0 pt-0">';
                html += '      <div class="pg-txt-cntr">';
                html += '         <div class="pg-steps d-none">Step 3/6</div>';
                if(j == 1){
                    html += '         <h6 class="full-nam2">EDUCATIONAL DETAILS '+(j++)+' <span class="high">(Highest Degree First)</span></h6>';
                }else{
                     html += '         <h6 class="full-nam2">EDUCATIONAL DETAILS '+(j++)+' <span class="high"></span></h6>';
                }
                
                html += '         <div class="row">';
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm">';
                html += '                  <label>Type of Degree</label>';
                html += '                  <input name="" value = "'+type_of_degree[i].type_of_degree+'" class="fld form-control type_of_degree" type="text">';
                html += '               </div>';
                html += '            </div>';
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm">';
                html += '                  <label>Major</label>';
                html += '                  <input name=""  value = "'+major[i].major+'" class="fld form-control major" type="text">';
                html += '               </div>';
                html += '            </div>';
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm">';
                html += '                  <label>University</label>';
                html += '                  <input name="" value = "'+university_board[i].university_board+'" class="fld form-control university" type="text">';
                html += '               </div>';
                html += '            </div>';
                html += '         </div>';
                html += '         <div class="row">';
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm">';
                html += '                  <label>College Name</label>';
                html += '                  <input name="" value = "'+college_school[i].college_school+'" class="fld form-control college_name" type="text">';
                html += '               </div>';
                html += '            </div>';
                html += '            <div class="col-md-8">';
                html += '               <div class="pg-frm">';
                html += '                  <label>Address</label>';
                html += '                  <textarea class="add form-control address"  type="text">'+address_of_college_school[i].address_of_college_school+'</textarea>';
                html += '               </div>';
                html += '            </div>';
                html += '         </div>';
                html += '         <div class="pg-frm-hd">Duration Of Course</div>';
                html += '         <div class="row">';
                $start ='';
                if (course_start_date.length > 0) {
                    $start = course_start_date[i].course_start_date;
                }
                $end ='';
                if (course_end_date.length > 0) {
                    $end = course_end_date[i].course_end_date;
                }
                html += '            <div class="col-md-3">';
                html += '                <div class="pg-frm">';
                // html += '                  <label>DURATION OF STAY</label>';
                html += '                  <input name=""   class="fld form-control education-start-date" value = "'+$start+'" id="duration_of_stay" type="text">';
                html += '               </div>';
                 
                html += '            </div>';
                html += '           <div class="col-md-3">';
                html += '            <div class="pg-frm">';
                // html += '               <label>Duration of Course</label>';
                html += '               <input class="duration_of_course fld form-control education-end-date"   value = "'+$end+'" >'; 
                html += '            </div>';
                html += '         </div>';
                $corse ='full_time';
                if (type_of_course.length > 0) {
                    $corse = type_of_course[i].type_of_course;
                }
                if($corse == 'part_time'){
                html += '         <div class="col-md-2 tp">';
                html += '            <div class="custom-control custom-radio custom-control-inline mrg-btm">';
                html += '               <input type="radio" checked class="custom-control-input education-part_time" name="customRadio" value="part_time" id="customRadio1">';
                html += '               <label class="custom-control-label pt-1" for="customRadio1">Part Time</label>';
                html += '            </div>';
                html += '         </div>';
                }else if($corse == 'full_time'){
                html += '         <div class="col-md-2 tp">';
                html += '            <div class="custom-control custom-radio custom-control-inline mrg-btm">';
                html += '               <input type="radio" checked class="custom-control-input education-part_time" name="customRadio" value="full_time" id="customRadio2">';
                html += '               <label class="custom-control-label pt-1" for="customRadio2">Full Time</label>';
                html += '            </div>';
                html += '         </div>';
                
                }
                
                
                html += '         </div>';
                html += '         <div class="row">';
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm">';
                html += '                  <label>Registration / Roll Number</label>';
                html += '                  <input name="" class="fld registration_roll_number" value = "'+registration_roll_number[i].registration_roll_number+'" type="text">';
                html += '               </div>';
                html += '            </div>';
                html += '         </div>';

                if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
                html += '         <hr>'; 
                
                html += '      </div>';
                html += '   </div>';
            // }
        // alert(type_of_degree[i].type_of_degree)
       
            html += '         <div class="row mt-3">';
            if(type_of_degree[i].type_of_degree != '12th' && type_of_degree[i].type_of_degree != '10th'){
                html += '            <div class="col-md-3">';
                html += '               <div class="pg-frm-hd">all sem marksheet</div>';
                if(data.component_data.all_sem_marksheet != null || data.component_data.all_sem_marksheet != ''){
                    var allSemMarksheetDoc = JSON.parse(data.component_data.all_sem_marksheet);
                    // var allSemMarksheetDoc = allSemMarksheetDoc.split(",");
                    for (var p = 0; p < allSemMarksheetDoc.length; p++) {
                        var url = img_base_url+"../uploads/all-marksheet-docs/"+allSemMarksheetDoc[p][i]
                        if ((/\.(jpg|jpeg|png)$/i).test(allSemMarksheetDoc[p][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+allSemMarksheetDoc[p][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+allSemMarksheetDoc[p][i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(allSemMarksheetDoc[p][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+allSemMarksheetDoc[i][p]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
                }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                                        
                html += '            </div>';
            }
            // alert(JSON.stringify(type_of_degree[i].type_of_degree))
            if(type_of_degree[i].type_of_degree != '12th' && type_of_degree[i].type_of_degree != '10th'){
                html += '            <div class="col-md-3">';
                html += '               <div class="pg-frm-hd">degree convocation/ transcript of records</div>';
                if(data.component_data.convocation != null || data.component_data.convocation != ''){
                    var convocationDoc = JSON.parse(data.component_data.convocation);
                    // var convocationDoc = convocationDoc.split(",");
                    // alert(convocationDoc)
                    for (var q = 0; q < convocationDoc.length; q++) {
                        var url = img_base_url+"../uploads/convocation-docs/"+convocationDoc[q][i]
                        if ((/\.(jpg|jpeg|png)$/i).test(convocationDoc[q][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocationDoc[q][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+convocationDoc[q][i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(convocationDoc[q][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocationDoc[q][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
            html += '            </div>';
            }

            if(type_of_degree[i].type_of_degree != '12th' && type_of_degree[i].type_of_degree != '10th'){
                html += '            <div class="col-md-3">';
                html += '               <div class="pg-frm-hd">consolidate marksheet/ provisional degree certificate</div>';
                if(data.component_data.marksheet_provisional_certificate != null || data.component_data.marksheet_provisional_certificate != ''){
                    var marksheet_provisional_certificateDoc = JSON.parse(data.component_data.marksheet_provisional_certificate);
                    // var marksheet_provisional_certificateDoc = marksheet_provisional_certificateDoc.split(",");
                    for (var s = 0; s < marksheet_provisional_certificateDoc.length; s++) {
                        var url = img_base_url+"../uploads/marksheet-certi-docs/"+marksheet_provisional_certificateDoc[s][i]
                        if ((/\.(jpg|jpeg|png)$/i).test(marksheet_provisional_certificateDoc[s][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+marksheet_provisional_certificateDoc[s][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+marksheet_provisional_certificateDoc[s][i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(marksheet_provisional_certificateDoc[s][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0  text-wrap">'+marksheet_provisional_certificateDoc[s][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }

                html += '            </div>';
            }
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd">10th / 12th mark card/ course completion certificate <span>(optional)</span></div>';
            if(data.component_data.ten_twelve_mark_card_certificate != null || data.component_data.ten_twelve_mark_card_certificate != ''){
                    var ten_twelve_mark_card_certificatetDoc = JSON.parse(data.component_data.ten_twelve_mark_card_certificate);
                    // var ten_twelve_mark_card_certificatetDoc = ten_twelve_mark_card_certificatetDoc.split(",");
                    for (var t = 0; t < ten_twelve_mark_card_certificatetDoc.length; t++) {
                        var url = img_base_url+"../uploads/ten-twelve-docs/"+ten_twelve_mark_card_certificatetDoc[t][i]
                        if ((/\.(jpg|jpeg|png)$/i).test(ten_twelve_mark_card_certificatetDoc[t][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificatetDoc[t][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+ten_twelve_mark_card_certificatetDoc[t][i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(ten_twelve_mark_card_certificatetDoc[t][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificatetDoc[t][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
            html += '            </div>';
            html += '         </div>';
        }else{
            html += '         <div class="row">';
            html += '            <div class="col-md-12">';
            html += '               <h6 class="full-nam2">Data was not inserted perfectly.</h6>'; 
            html += '            </div>';
            html += '         </div>';
        }
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';

    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }

    $('#component-detail').html(html);
}

function present_address(data,position,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    
    let html ='';
    if(data.status > 0){
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps d-none">Step 2/6</div>';
        html += '         <h6 class="full-nam2">PRESENT ADDRESS</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>House/Flat No.</label>';
        html += '                  <input name="" readonly value="'+data.component_data.flat_no+'" class="fld form-control" id="house-flat" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Street/Road</label>';
        html += '                  <input name="" readonly value="'+data.component_data.street+'" class="fld form-control" id="street" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Area</label>';
        html += '                  <input name="" readonly value="'+data.component_data.area+'" class="fld form-control" id="area" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>City/Town</label>';
        html += '                  <input name="" readonly value="'+data.component_data.city+'" class="fld form-control" id="city" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Pin Code</label>';
        html += '                  <input name="" readonly value="'+data.component_data.pin_code+'" class="fld form-control" id="pincode" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Nearest Landmark</label>';
        html += '                  <input name="" readonly value="'+data.component_data.nearest_landmark+'" class="fld form-control" id="land-mark" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="pg-frm-hd">DURATION OF STAY</div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '                <div><label>Start Date</label></div>';
        html += '                <input name="" readonly value="'+data.component_data.duration_of_stay_start+'" class="fld form-control end-date" id="start-date" type="text">';
        html += '            </div>'; 
        html += '            <h6 class="To">TO</h6>';
        html += '           <div class="col-md-3">';
        html += '            <div><label>End Date</label></div>';
        html += '             <input name="" readonly value="'+data.component_data.duration_of_stay_end+'" class="fld form-control end-date" id="end-date" type="text">';
         
        html += '         </div>';
        html += '         <div class="col-md-2 tp d-none">';
        html += '            <div class="custom-control custom-checkbox custom-control-inline mrg-btm">';
        html += '               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">';
        html += '               <label class="custom-control-label pt-1" for="customCheck1">Present</label>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="col-md-2 tp">';
                    
        html += '         </div>';
        html += '         </div>';
        html += '         <div class="pg-frm-hd">CONTACT PERSON</div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Name</label>';
        html += '                  <input name="" readonly value="'+data.component_data.contact_person_name+'" class="fld form-control" id="name" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Reletionship</label>';
        html += '                  <input name="" readonly value="'+data.component_data.contact_person_relationship+'" class="fld form-control" id="relationship" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Mobile Number</label>';
        html += '                  <input name="" readonly value="'+data.component_data.contact_person_mobile_number+'" class="fld form-control" id="contact_no" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';

         if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

        html += '        <hr>';
         
        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">rental agreement/ driving License</div>';
        // html += '                   rental_agreement'
            if(data.component_data.rental_agreement != null || data.component_data.rental_agreement != ''){
                    var rental_agreementDoc = data.component_data.rental_agreement;
                    var rental_agreementDoc = rental_agreementDoc.split(",");
                    for (var i = 0; i < rental_agreementDoc.length; i++) {
                         var url = img_base_url+"../uploads/rental-docs/"+rental_agreementDoc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(rental_agreementDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+rental_agreementDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+rental_agreementDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(rental_agreementDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+rental_agreementDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/rental-docs/"+rental_agreementDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Ration card</div>';
        // html += '                   ration_card'
        if(data.component_data.ration_card != null || data.component_data.ration_card != ''){
                    var ration_cardDoc = data.component_data.ration_card;
                    var ration_cardDoc = ration_cardDoc.split(",");
                    for (var i = 0; i < ration_cardDoc.length; i++) {
                        var url = img_base_url+"../uploads/ration-docs/"+ration_cardDoc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(ration_cardDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ration_cardDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+ration_cardDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(ration_cardDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ration_cardDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/ration-docs/"+ration_cardDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Government utility bill</div>';
        // html += '                   gov_utility_bill'
        if(data.component_data.gov_utility_bill != null || data.component_data.gov_utility_bill != ''){
                    var gov_utility_billDoc = data.component_data.gov_utility_bill;
                    var gov_utility_billDoc = gov_utility_billDoc.split(",");
                    for (var i = 0; i < gov_utility_billDoc.length; i++) {
                        var url = img_base_url+"../uploads/gov-docs/"+gov_utility_billDoc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(gov_utility_billDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+gov_utility_billDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+gov_utility_billDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(gov_utility_billDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+gov_utility_billDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/gov-docs/"+gov_utility_billDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';
        html += '            <div class="col-md-3">';
                       
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '               <div id="fls">';
        html += '                  <div class="form-group files d-none">';
        html += '                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>';
        html += '                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
        html += '                     <div class="file-name1"></div>';
        html += '                  </div>';
        html += '               </div>';
        html += '               <div id="file1-error"></div>';
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div id="fls">';
        html += '                  <div class="form-group files d-none">';
        html += '                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>';
        html += '                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
        html += '                     <div class="file-name2"></div>';
        html += '                  </div>';
        html += '               </div>';
        html += '               <div id="file2-error"></div>';
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div id="fls">';
        html += '                  <div class="form-group files d-none">';
        html += '                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>';
        html += '                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
        html += '                     <div class="file-name3"></div>';
        html += '                  </div>';
        html += '               </div>';
        html += '               <div id="file3-error"></div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }
    $('#component-detail').html(html);
}

function permanent_address(data,position,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    let html ='';
    if(data.status > 0){
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps d-none">Step 2/6</div>';
        html += '         <h6 class="full-nam2">Permanent Address</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>House/Flat No.</label>';
        html += '                  <input name="" readonly value="'+data.component_data.flat_no+'" class="fld form-control" id="house-flat" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Street/Road</label>';
        html += '                  <input name="" readonly value="'+data.component_data.street+'" class="fld form-control" id="street" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Area</label>';
        html += '                  <input name="" readonly value="'+data.component_data.area+'" class="fld form-control" id="area" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>City/Town</label>';
        html += '                  <input name="" readonly value="'+data.component_data.city+'" class="fld form-control" id="city" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Pin Code</label>';
        html += '                  <input name="" readonly value="'+data.component_data.pin_code+'" class="fld form-control" id="pincode" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Nearest Landmark</label>';
        html += '                  <input name="" readonly value="'+data.component_data.nearest_landmark+'" class="fld form-control" id="land-mark" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="pg-frm-hd">DURATION OF STAY</div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '                <div><label>Start Date</label></div>';
        html += '                <input name="" readonly value="'+data.component_data.duration_of_stay_start+'" class="fld form-control end-date" id="start-date" type="text">';
        html += '            </div>'; 
        html += '            <h6 class="To">TO</h6>';
        html += '           <div class="col-md-3">';
        html += '            <div><label>End Date</label></div>';
        html += '             <input name="" readonly value="'+data.component_data.duration_of_stay_end+'" class="fld form-control end-date" id="end-date" type="text">';
         
        html += '         </div>';
        html += '         <div class="col-md-2 tp d-none">';
        html += '            <div class="custom-control custom-checkbox custom-control-inline mrg-btm">';
        html += '               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">';
        html += '               <label class="custom-control-label pt-1" for="customCheck1">Present</label>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="col-md-2 tp">';
                    
        html += '         </div>';
        html += '         </div>';
        html += '         <div class="pg-frm-hd">CONTACT PERSON</div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Name</label>';
        html += '                  <input name="" readonly value="'+data.component_data.contact_person_name+'" class="fld form-control" id="name" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Relationship</label>';
        html += '                  <input name="" readonly value="'+data.component_data.contact_person_relationship+'" class="fld form-control" id="relationship" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Mobile Number</label>';
        html += '                  <input name="" readonly value="'+data.component_data.contact_person_mobile_number+'" class="fld form-control" id="contact_no" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';

         if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

        html += '        <hr>';
         
        html += '         <div class="row mt-3">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>';
                            // for loop will start 
                if(data.component_data.rental_agreement != null || data.component_data.rental_agreement != ''){
                    var reantAgreementDoc = data.component_data.rental_agreement;
                    var reantAgreementDoc = reantAgreementDoc.split(",");
                    for (var i = 0; i < reantAgreementDoc.length; i++) {
                        if ((/\.(jpg|jpeg|png)$/i).test(reantAgreementDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+reantAgreementDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal('+data.component_data.candidate_id+',\'rental-docs\')" data-view_docs="'+reantAgreementDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(reantAgreementDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+reantAgreementDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/rental-docs/"+reantAgreementDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
                }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                        // for loop will end 
            
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Upload Ration Card <span>(optional)</span></div>';
             
                            // for loop will start 
            if(data.component_data.ration_card != null || data.component_data.ration_card != ''){
                    var rationCardDoc = data.component_data.ration_card;
                    var rationCardDoc = rationCardDoc.split(",");
                    for (var i = 0; i < rationCardDoc.length; i++) {
                        if ((/\.(jpg|jpeg|png)$/i).test(rationCardDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+rationCardDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal('+data.component_data.candidate_id+',\'ration-docs\')" data-view_docs="'+rationCardDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(rationCardDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+rationCardDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/ration-docs/"+rationCardDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
 
                    }
                }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                        // for loop will end    ration_card
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Upload Government Utility Bill <span>(optional)</span></div>';
             
                if(data.component_data.gov_utility_bill != null || data.component_data.gov_utility_bill != ''){
                    var govUtilityBillDoc = data.component_data.gov_utility_bill;
                    var govUtilityBillDoc = govUtilityBillDoc.split(",");
                    for (var i = 0; i < govUtilityBillDoc.length; i++) {
                        if ((/\.(jpg|jpeg|png)$/i).test(govUtilityBillDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+govUtilityBillDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal('+data.component_data.candidate_id+',\'gov-docs\')" data-view_docs="'+govUtilityBillDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(govUtilityBillDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+govUtilityBillDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/gov-docs/"+govUtilityBillDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
                }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                    // for loop will end  gov_utility_bill      
            html += '            </div>';
        html += '         </div>';

        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '               <div id="fls">';
        html += '                  <div class="form-group files d-none">';
        html += '                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>';
        html += '                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
        html += '                     <div class="file-name1"></div>';
        html += '                  </div>';
        html += '               </div>';
        html += '               <div id="file1-error"></div>';
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div id="fls">';
        html += '                  <div class="form-group files d-none">';
        html += '                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>';
        html += '                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
        html += '                     <div class="file-name2"></div>';
        html += '                  </div>';
        html += '               </div>';
        html += '               <div id="file2-error"></div>';
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div id="fls">';
        html += '                  <div class="form-group files d-none">';
        html += '                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>';
        html += '                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
        html += '                     <div class="file-name3"></div>';
        html += '                  </div>';
        html += '               </div>';
        html += '               <div id="file3-error"></div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }
    $('#component-detail').html(html);
}


function previous_employment(data,postion,component_name){
    // console.log("current_employment: "+JSON.stringify(data))
    $('#componentModal').modal('show')
    // $('#modal-headding').html('Previous employment')
    $('#modal-headding').html(component_name)
    var designation =  JSON.parse(data.component_data.desigination)
    var department =  JSON.parse(data.component_data.department)
    var employee_id =  JSON.parse(data.component_data.employee_id)
    var company_name =  JSON.parse(data.component_data.company_name)
    var address =  JSON.parse(data.component_data.address)
    var annual_ctc =  JSON.parse(data.component_data.annual_ctc)
    var reason_for_leaving =  JSON.parse(data.component_data.reason_for_leaving)
    var joining_date =  JSON.parse(data.component_data.joining_date)
    var relieving_date =  JSON.parse(data.component_data.relieving_date)
    var reporting_manager_name =  JSON.parse(data.component_data.reporting_manager_name)
    var reporting_manager_Designation =  JSON.parse(data.component_data.reporting_manager_desigination)
    var reporting_manager_contact_number =  JSON.parse(data.component_data.reporting_manager_contact_number)
    var hr_name =  JSON.parse(data.component_data.hr_name)
    var hr_contact_number =  JSON.parse(data.component_data.hr_contact_number)
    var company_url =  JSON.parse(data.component_data.company_url)
    let html='';
    var j = 1;
    var i = postion;
    // for(var i=0;i<Designation.length;i++){
        // alert(i)
    var component_status =  data.component_data.analyst_status.split(','); 
    var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.Insuff_remarks); 
            } 

        html += '<div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">'; 
        html += '         <h4 class="full-nam2">Previous Employment '+(j++)+'</h4>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Designation</label>';
        html += '                  <input name="" readonly="" value="'+designation[i].desigination+'" class="fld form-control" id="designation" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Department</label>';
        html += '                  <input name="" readonly="" value="'+department[i].department+'"  class="fld form-control" id="department" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Employee ID</label>';
        html += '                  <input name="" readonly="" value="'+employee_id[i].employee_id+'"  class="fld form-control" id="employee_id" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Company Name</label>';
        html += '                  <input name="" readonly="" value="'+company_name[i].company_name+'" class="fld form-control" id="company-name" type="text">';
        html += '               </div>';
        html += '            </div>';

var urls = '';
        if (company_url !='' && company_url !=null && company_url !='undefined' && company_url !='[]') {
            urls = company_url[i].company_url;
        }
        
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Company Website</label>';
        html += '                  <input name="" readonly="" value="'+urls+'" class="fld form-control" id="company-name" type="text">';
        html += '               </div>';
        html += '            </div>';

        html += '            <div class="col-md-8">';
        html += '                <div class="pg-frm">';
        html += '                   <label>Address</label>';
        html += '                   <textarea readonly="" class="add" id="address" type="text">'+address[i].address+'</textarea>';
        html += '                </div>';
        html += '             </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Annual CTC</label>';
        html += '                  <input name="" readonly="" value="'+annual_ctc[i].annual_ctc+'" class="fld" id="annual-ctc" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-8">';
        html += '                <div class="pg-frm">';
        html += '                   <label>Reason For Leaving</label>';
        html += '                   <input name="" readonly="" value="'+reason_for_leaving[i].reason_for_leaving+'" class="fld" id="reasion"  type="text">';
        html += '                </div>';
        html += '             </div>';
        html += '         </div>';
/*        html += '         <div class="row">';
        html += '             <div class="col-md-5">';
        html += '                <div class="pg-frm-hd">Joining Date</div>';
        html += '             </div>';
        html += '             <div class="col-md-4">';
        html += '                <div class="pg-frm-hd">relieving date</div>';
        html += '             </div>';
        html += '         </div>';*/
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm">';
        html += '               <label>Joining Date</label>';
        html += '                <input name="" readonly="" value="'+joining_date[i].joining_date+'"  class="fld form-control mdate" id="joining-date" type="text">';
         
        html += '            </div>';
        html += '            </div>';
        html += '            <div class="col-md-1">'; 
        html += '           </div>';
        html += '           <div class="col-md-3 ml-2">';
        html += '               <div class="pg-frm">';
        html += '            <label>Relieving Date</label>';
        html += '                <input name="" readonly="" value="'+relieving_date[i].relieving_date+'"  class="fld form-control mdate" id="relieving-date" type="text">';
         
        html += '         </div>';
        html += '         </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Reporting Manager Name</label>';
        html += '                  <input name="" readonly="" value="'+reporting_manager_name[i].reporting_manager_name+'"  class="fld form-control" id="reporting-manager-name" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Reporting Manager Designation</label>';
        html += '                  <input name="" readonly="" value="'+reporting_manager_Designation[i].reporting_manager_desigination+'"  class="fld form-control" id="reporting-manager-designation" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Reporting Manager Contact Number</label>';
        html += '                  <input name="" readonly="" value="'+reporting_manager_contact_number[i].reporting_manager_contact_number+'"  class="fld form-control" id="reporting-manager-contact" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>HR Name</label>';
        html += '                  <input name="" readonly="" value="'+hr_name[i].hr_name+'"  class="fld form-control" id="hr-name" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>HR Contact Number</label>';
        html += '                  <input name="" readonly="" value="'+hr_contact_number[i].hr_contact_number+'"  class="fld form-control" id="hr-contact" type="text">';
        html += '               </div>';
        html += '            </div>';
          html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>HR Email</label>';
        html += '                  <input name="" readonly="" value="-"  class="fld form-control" id="hr-email" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
     
        html += '      </div>';
        html += '   </div>';

        if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
        }

        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Appointment Letter</div>';
            if(data.component_data.appointment_letter != null || data.component_data.appointment_letter != ''){
                    var appointment_letterDoc = JSON.parse(data.component_data.appointment_letter);
                    // var appointment_letterDoc = appointment_letterDoc.split(",");
                    // alert(appointment_letterDoc)
                    for (var a = 0; a < appointment_letterDoc.length; a++) {
                        var url = img_base_url+"../uploads/appointment_letter/"+appointment_letterDoc[a][i]
                        if ((/\.(jpg|jpeg|png)$/i).test(appointment_letterDoc[a][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+appointment_letterDoc[a][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+appointment_letterDoc[a][i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(appointment_letterDoc[a][i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+appointment_letterDoc[a][i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
                        
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Experience/ Relieving Letter</div>';
         if(data.component_data.experience_relieving_letter != null || data.component_data.experience_relieving_letter != ''){
                    var experience_relieving_letter_Doc = data.component_data.experience_relieving_letter;
                    var experience_relieving_letter_Doc = experience_relieving_letter_Doc.split(",");
                    for (var i = 0; i < experience_relieving_letter_Doc.length; i++) {
                        var url = img_base_url+"../uploads/experience_relieving_letter/"+experience_relieving_letter_Doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(experience_relieving_letter_Doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+experience_relieving_letter_Doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+experience_relieving_letter_Doc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(experience_relieving_letter_Doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+experience_relieving_letter_Doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Pay Slip</div>';
         if(data.component_data.last_month_pay_slip != null || data.component_data.last_month_pay_slip != ''){
                    var last_month_pay_slip_doc = data.component_data.last_month_pay_slip;
                    var last_month_pay_slip_doc = last_month_pay_slip_doc.split(",");
                    for (var i = 0; i < last_month_pay_slip_doc.length; i++) {
                        var url = img_base_url+"../uploads/last_month_pay_slip/"+last_month_pay_slip_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(last_month_pay_slip_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+last_month_pay_slip_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+last_month_pay_slip_doc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(last_month_pay_slip_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0  text-wrap">'+last_month_pay_slip_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Resignation Acceptance Letter/ mail</div>';
         if(data.component_data.ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance != null || data.component_data.ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance != ''){
                    var bank_statement_resigngation_acceptance_doc = data.component_data.bank_statement_resigngation_acceptance;
                    var bank_statement_resigngation_acceptance_doc = bank_statement_resigngation_acceptance_doc.split(",");
                    for (var i = 0; i < bank_statement_resigngation_acceptance_doc.length; i++) {
                        var url = img_base_url+"../uploads/bank_statement_resigngation_acceptance/"+bank_statement_resigngation_acceptance_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(bank_statement_resigngation_acceptance_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+bank_statement_resigngation_acceptance_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+bank_statement_resigngation_acceptance_doc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(bank_statement_resigngation_acceptance_doc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+bank_statement_resigngation_acceptance_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';
        html += '         </div>';
    // } 
        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    $('#component-detail').html(html) 
}

function reference(data,postion,component_name){
    console.log("reference : "+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    var company_name = data.component_data.company_name
    if(company_name != null || company_name != ''){
        company_name = company_name.split(',')
        company_name_lenght = company_name.length
    }else{
        company_name_lenght = 0
    }


    var name = data.component_data.name
    if(name != null || company_name != ''){
        name = name.split(',')
        name_lenght = name.length
    }else{
        name_lenght = 0
    }


    var designation = data.component_data.designation
    if(designation != null || designation != ''){
        designation = designation.split(',')
        designation_lenght = designation.length
    }else{
        designation_lenght = 0
    }


    var contact_number = data.component_data.contact_number
    if(contact_number != null || contact_number != ''){
        contact_number = contact_number.split(',')
        contact_number_lenght = contact_number.length
    }else{
        contact_number_lenght = 0
    }

    var email_id = data.component_data.email_id
    if(email_id != null || email_id != ''){
        email_id = email_id.split(',')
        email_id_lenght = email_id.length
    }else{
        email_id_lenght = 0
    }

    var years_of_association = data.component_data.years_of_association
    if(years_of_association != null || years_of_association != ''){
        years_of_association = years_of_association.split(',')
        years_of_association_lenght = years_of_association.length
    }else{
        years_of_association_lenght = 0
    }

    var contact_start_time = data.component_data.contact_start_time
    if(contact_start_time != null || contact_start_time != ''){
        contact_start_time = contact_start_time.split(',')
        contact_start_time_lenght = contact_start_time.length
    }else{
        contact_start_time_lenght = 0
    }

    var contact_end_time = data.component_data.contact_end_time
    if(contact_end_time != null || contact_end_time != ''){
        contact_end_time = contact_end_time.split(',')
        contact_end_time_lenght = contact_end_time.length
    }else{
        contact_end_time_lenght = 0
    }


    let html='';
    if(company_name_lenght > 0 ){
        var j=1;
        var i = postion;
        // for (var i = 0; i < company_name_lenght; i++) { 

         var component_status =  data.component_data.analyst_status.split(','); 
        var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 

        $name = name[i];
        if (!isNaN(name[i])) {
          $name = name[i+1];  
        }

            html += '<h6 class="full-nam2">Reference '+(j++)+'</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Name</label>';
            html += '                  <input name="" readonly value="'+$name+'" class="fld form-control name" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Company Name</label>';
            html += '                  <input name="" readonly value="'+company_name[i]+'" class="fld form-control company-name" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Designation</label>';
            html += '                  <input name="" readonly value="'+designation[i]+'" class="fld form-control designation" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Contact Number</label>';
            html += '                  <input name="" readonly value="'+contact_number[i]+'" class="fld form-control contact" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Email ID</label>';
            html += '                  <input name="" readonly value="'+email_id[i]+'" class="fld form-control email" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Years of Association</label>';
            html += '                  <input name="" readonly value="'+years_of_association[i]+'" class="fld form-control association" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '          <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <div class="pg-frm-hd">Preferred contact time</div>';
            html += '               <div class="row">';
            html += '                  <div class="col-md-5">';
            html += '                     <div class="pg-frm">';
            html += '                        <input type="text" readonly value="'+contact_start_time[i]+'" class="form-control fld start-time" id="timepicker" placeholder="Start time" name="pwd" >';
            html += '                     </div>';
            html += '                  </div>';
            html += '                  <div class="col-md-5">';
            html += '                     <div class="pg-frm">';
            html += '                        <input type="text" readonly value="'+contact_end_time[i]+'" class="form-control fld end-time" id="timepicker2" placeholder="End time" name="pwd" >';
            html += '                     </div>';
            html += '                  </div>';
            html += '               </div>';
            html += '            </div>';
            html += '          </div>';
            html += '         </div>';

            if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

            html += '        <hr>';          
        // }
    }
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += '               </div>';
    html += '            </div>';

    $('#component-detail').html(html) 
}

function previous_address(data,postion,component_name){
    console.log("previous_address : "+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
   
    var flat_no = JSON.parse(data.component_data.flat_no)
    var street = JSON.parse(data.component_data.street)
    var area = JSON.parse(data.component_data.area)
    var city = JSON.parse(data.component_data.city)
    var pin_code = JSON.parse(data.component_data.pin_code)
    var state = JSON.parse(data.component_data.state)
    var nearest_landmark = JSON.parse(data.component_data.nearest_landmark)
    var duration_of_stay_start = JSON.parse(data.component_data.duration_of_stay_start)
    var duration_of_stay_end = JSON.parse(data.component_data.duration_of_stay_end)
    var contact_person_name = JSON.parse(data.component_data.contact_person_name)
    var contact_person_relationship = JSON.parse(data.component_data.contact_person_relationship)
    var contact_person_mobile_number = JSON.parse(data.component_data.contact_person_mobile_number)
    // var state = JSON.parse(data.component_data.state)
    // var state = JSON.parse(data.component_data.state)
    // var state = JSON.parse(data.component_data.state)
    // var state = JSON.parse(data.component_data.state)
    let html ='';
    if(data.status > 0){
        // for (var i = 0; i < state.length; i++) { 
            var i = postion;

             var component_status =  data.component_data.analyst_status.split(','); 
            var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 

            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '      <div class="pg-txt-cntr">';
            html += '         <div class="pg-steps d-none">Step 2/6</div>';
            html += '         <h6 class="full-nam2">Details</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>House/Flat No.</label>';
            html += '                  <input name="" readonly value="'+flat_no[i].flat_no+'" class="fld form-control" id="house-flat" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Street/Road</label>';
            html += '                  <input name="" readonly value="'+street[i].street+'" class="fld form-control" id="street" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Area</label>';
            html += '                  <input name="" readonly value="'+area[i].area+'" class="fld form-control" id="area" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>City/Town</label>';
            html += '                  <input name="" readonly value="'+city[i].city+'" class="fld form-control" id="city" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Pin Code</label>';
            html += '                  <input name="" readonly value="'+pin_code[i].pin_code+'" class="fld form-control" id="pincode" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Nearest Landmark</label>';
            html += '                  <input name="" readonly value="'+state[i].state+'" class="fld form-control" id="land-mark" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="pg-frm-hd"><label>Duration of Course</label></div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-3">';
            html += '                <div><label>Start Date</label></div>';
            html += '                <input name="" readonly value="'+duration_of_stay_start[i].duration_of_stay_start+'" class="fld form-control end-date" id="start-date" type="text">';
            html += '            </div>'; 
            html += '            <h6 class="To">TO</h6>';
            html += '           <div class="col-md-3">';
            html += '            <div><label>End Date</label></div>';
            html += '             <input name="" readonly value="'+duration_of_stay_end[i].duration_of_stay_end+'" class="fld form-control end-date" id="end-date" type="text">';
             
            html += '         </div>';
            html += '         <div class="col-md-2 tp d-none">';
            html += '            <div class="custom-control custom-checkbox custom-control-inline mrg-btm">';
            html += '               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">';
            html += '               <label class="custom-control-label pt-1" for="customCheck1">Present</label>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="col-md-2 tp">';
                        
            html += '         </div>';
            html += '         </div>';
            html += '         <div class="pg-frm-hd">CONTACT PERSON</div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Name</label>';
            html += '                  <input name="" readonly value="'+contact_person_name[i].contact_person_name+'" class="fld form-control" id="name" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Reletionship</label>';
            html += '                  <input name="" readonly value="'+contact_person_relationship[i].contact_person_relationship+'" class="fld form-control" id="relationship" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Mobile Number</label>';
            html += '                  <input name="" readonly value="'+contact_person_mobile_number[i].contact_person_mobile_number+'" class="fld form-control" id="contact_no" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';

             if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

            html += '        <hr>';
           
            html += '      </div>';
            html += '   </div>';
        // }

        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">rental agreement/ driving License</div>';
        // alert(data.component_data.rental_agreement)
            if(data.component_data.rental_agreement != null && data.component_data.rental_agreement != 'no-file' ){
                    
                    var reantAgreementDoc = JSON.parse(data.component_data.rental_agreement);  
                    if(reantAgreementDoc[i].length > 0){
                        for (var j = 0; j < reantAgreementDoc[i].length; j++) {
                            if ((/\.(jpg|jpeg|png)$/i).test(reantAgreementDoc[i][j])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+reantAgreementDoc[i][j]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal('+data.component_data.candidate_id+',\'rental-docs\')" data-view_docs="'+reantAgreementDoc[j]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(reantAgreementDoc[i][j])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+govUtilityBillDoc[i][j]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/rental-docs/"+reantAgreementDoc[j]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down">';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }
                        }
                    }else{
                        html += '               <div class="pg-frm-hd">There is no file </div>';
                    }   
                }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
                }
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Ration card</div>';
            if(data.component_data.ration_card != null && data.component_data.ration_card != 'no-file'){
                    var rationCardDoc = JSON.parse(data.component_data.ration_card);
                    // var rationCardDoc = rationCardDoc.split(",");
                    if(rationCardDoc[i].length > 0){
                        for (var k = 0; k < rationCardDoc[i].length; k++) {
                            if ((/\.(jpg|jpeg|png)$/i).test(rationCardDoc[i][k])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+rationCardDoc[i][k]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal('+data.component_data.candidate_id+',\'ration-docs\')" data-view_docs="'+rationCardDoc[i][k]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(rationCardDoc[i][k])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+rationCardDoc[i][k]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/ration-docs/"+rationCardDoc[i][k]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down">';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }
     
                        }
                    }else{
                        html += '               <div class="pg-frm-hd">There is no file </div>';
                    }
                }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
                }
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Government utility bill</div>';
            if(data.component_data.gov_utility_bill != null && data.component_data.gov_utility_bill != 'no-file'){
                    // alert(data.component_data.gov_utility_bill)
                    var govUtilityBillDoc = JSON.parse(data.component_data.gov_utility_bill);
                    // alert(govUtilityBillDoc)
                    // var govUtilityBillDoc = govUtilityBillDoc.split(",");
                    if(rationCardDoc[i].length > 0){
                        for (var y = 0; y < govUtilityBillDoc[i].length; y++) {
                            if ((/\.(jpg|jpeg|png)$/i).test(govUtilityBillDoc[i][y])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+govUtilityBillDoc[i][y]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal('+data.component_data.candidate_id+',\'gov-docs\')" data-view_docs="'+govUtilityBillDoc[i][y]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(govUtilityBillDoc[i][y])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+govUtilityBillDoc[i][y]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/gov-docs/"+passport_doc[i][y]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down">';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }
                        }
                    }else{
                        html += '               <div class="pg-frm-hd">There is no file </div>';
                    }    
                }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
                }
        html += '            </div>';
 
        html += '         </div>';
             
        html += '         <div class="row">';
        html += '            <div class="col-md-12 mt-3">';
        html += '               <div class="pg-submit text-right">';
        html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';

    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }
    $('#component-detail').html(html);
}

function driving_License(data,position,component_name){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    // console.log(data)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.status.split(',');
    } 
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
             var component_status =  data.component_data.analyst_status.split(','); 
    if(candidate_id != '' || candidate_id != null){
        for (var i = 0; i < 1 ; i++) {
            // alert()

var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            
            if(component_status[i] == '0'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-info" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-danger" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            
            html += '            </div>';
            html += '         </div>';
           
            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd"> </div>';
            html += '                   <label class="font-weight-bold">driving License Number: </label>'
            html += '                   <input type="text" class="fld form-control" readonly value="'+data.component_data.licence_number+'" >'
                if(data.component_data.licence_doc != null && data.component_data.licence_doc != ''){
                        var licence_doc = data.component_data.licence_doc;
                        var licence_doc = licence_doc.split(",");
                        for (var i = 0; i < licence_doc.length; i++) {
                            var url = img_base_url+"../uploads/licence-docs/"+licence_doc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(licence_doc[i])){
                                html += '                   <label class="font-weight-bold  mt-3">driving License: </label>'
                                html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+licence_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+licence_doc[i]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(licence_doc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+licence_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }
                        }
                }else{
                        html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                            
            html += '            </div>';
            html += '        </div>';

            if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            
            html += '   <hr>';

        }
    }
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    
    // alert(html)
    $('#component-detail').html(html)
}

function credit_cibil_check(data,position,component_name){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    // console.log(JSON.stringify(data))
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.status.split(',');
    } 
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(candidate_id != '' || candidate_id != null){
        // var formValues = JSON.parse(data.component_data.form_values)
        // var formValues = JSON.parse(formValues)
        // var craditFormValeuslength = formValues['credit_/ cibil check'].length

        
        var credit_number = JSON.parse(data.component_data.credit_number)
        var document_type = JSON.parse(data.component_data.document_type)
        // alert(JSON.stringify(document_type))
        for (var i = 0; i < credit_number.length ; i++) { 
            var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4">';


            
            if(component_status[i] == '0'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-info" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-danger" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            
            html += '            </div>';
            html += '         </div>';             
            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd"> </div>';
            html += '                   <label class="font-weight-bold">Document type: '+document_type[i].document_type+'</label>'
            html += '                   <input type="text" class="fld form-control" readonly value="'+credit_number[i].credit_cibil_number+'" >'                
            html += '            </div>';
            html += '        </div>';
            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
             html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_country+'" >'                
                html += '            </div>';
            html += '            <div class="col-md-3">';
            html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_state+'" >'                
            html += '            </div>';
            
            html += '            <div class="col-md-3">';
            html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_city+'" >'                
            html += '            </div>';
            
            html += '            <div class="col-md-3">';
            html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_pincode+'" >'                
            html += '            </div>';

            html += '            <div class="col-md-3 mt-2">';
            html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_address+'" >'                
            html += '            </div>';
            html += '        </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
            html += '   <hr>';

        }
    }
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    
    // alert(html)
    $('#component-detail').html(html)
}

function bankruptcy_check(data,position,component_name){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    // console.log(JSON.stringify(data))
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.status.split(',');
    } 
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(candidate_id != '' || candidate_id != null){ 
        var formValues = JSON.parse(data.component_data.form_values)
         var form_values = JSON.parse(formValues)
        // var craditFormValeuslength = formValues['credit_/ cibil check'].length

        
        var document_type = JSON.parse(data.component_data.document_type)
        var bankruptcy_number = JSON.parse(data.component_data.bankruptcy_number)
        // alert(JSON.stringify(bankruptcy_number))
        for (var i = 0; i < form_values['bankruptcy_check'] ; i++) {
            // alert()

            var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 

            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            
            if(component_status[i] == '0'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-info" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-danger" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            
            html += '            </div>';
            html += '         </div>';             
            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd"> </div>';
            html += '                   <label class="font-weight-bold">Document type: '+document_type[i].document_type+'</label>'
            html += '                   <input type="text" class="fld form-control" readonly value="'+bankruptcy_number[i].bankruptcy_number+'" >'                
            html += '            </div>';
            html += '        </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Bankruptcy\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Bankruptcy\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

            html += '   <hr>';

        }
    }
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    
    // alert(html)
    $('#component-detail').html(html)
}

function cv_check(data,position,component_name){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    // console.log(JSON.stringify(data))
    // alert(JSON.stringify(bankruptcy_number))
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.status.split(',');
    } 
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(candidate_id != '' || candidate_id != null){
        for (var i = 0; i < 1 ; i++) {
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            
            if(component_status[i] == '0'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-info" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-danger" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            
            html += '            </div>';
            html += '         </div>';
           
            html += '         <div class="row">';
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd"> </div>';
            html += '                   <label class="font-weight-bold d-none">driving License Number: </label>'
            html += '                   <input type="text" class="d-none fld form-control" readonly value="'+data.component_data.licence_number+'" >'
                if(data.component_data.cv_doc != null && data.component_data.cv_doc != ''){
                        var cv_doc = data.component_data.cv_doc;
                        var cv_doc = cv_doc.split(",");
                        for (var i = 0; i < cv_doc.length; i++) {
                            var url = img_base_url+"../uploads/appointment_letter/"+cv_doc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(cv_doc[i])){
                                html += '                   <label class="font-weight-bold">CV Document: </label>'
                                html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+cv_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+cv_doc[i]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(cv_doc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+cv_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }
                            var insuff_remarks ='';
                             if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
        if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
                        }
                }else{
                        html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                            
            html += '            </div>';
            html += '        </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            
            html += '   <hr>';

        }
    }
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    
    // alert(html)
    $('#component-detail').html(html)
}

function employement_gap_check(data,position,component_name){ 
    console.log('permanent_address : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.status.split(',');
    } 
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(candidate_id != '' || candidate_id != null){
        for (var i = 0; i < 1 ; i++) {
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            var emp = '';
            if (data.component_data.reason_for_gap !=null) {
                emp = data.component_data.reason_for_gap;
            }
 
            html += '            <div class="col-md-12">';
            html += '            <label">Gap Reason</label>'; 
             html += '                   <input type="text" class="fld form-control"  value="'+emp+'" >'                
                html += '            </div>';
                
            html += '            <div class="col-md-4">';
            
            if(component_status[i] == '0'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-info" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-danger" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            // alert('insuffDisable:'+insuffDisable)
            // alert('approvDisable:'+approvDisable)
            html += '            </div>';
            html += '         </div>';

              var insuff_remarks ='';
                             if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
        if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            html += '   <hr>';

        }
    }
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    
    // alert(html)
    $('#component-detail').html(html)
}



function landlord_reference(data,position,component_name){ 
    // console.log('permanent_address : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    
    var tenant_name = JSON.parse(data.component_data.tenant_name);
    if(tenant_name != null || tenant_name != ''){
        // tenant_name = JSON.parse(data.component_data.tenant_name);
        // $company_name_lenght = tenant_name.length
    }else{
        $company_name_lenght = 0
    } 

    var case_contact_no = data.component_data.case_contact_no
    if(case_contact_no != null || landlord_name != ''){
        case_contact_no = JSON.parse(case_contact_no);
        // $name_lenght = case_contact_no.length
    }else{
        $name_lenght = 0
    }
 
    var landlord_name = JSON.parse(data.component_data.landlord_name);
    if(landlord_name != null || landlord_name != ''){
        // landlord_name = JSON.parse(landlord_name);
        // $name_lenght = landlord_name.length
    }else{
        $name_lenght = 0
    }
 
    var component_status = data.component_data.status.split(',') 
    let html='';
    if(tenant_name.length > 0 ){

        var j=1;
        for (var i = 0; i < tenant_name.length; i++) {  
            var form_status = '';
            var insuffDisable = '';
            var approvDisable = '';
            var rightClass = '';
            if (component_status[i] == '0') {

                form_status = '<span class="text-warning">Pending<span>'; 
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
                                 
            }else if (component_status[i] == '1') {
                                 
                form_status = '<span class="text-info">Form Filled<span>';
                fontAwsom = '<i class="fa fa-check">'
                rightClass ='bac-gr'
            }else if (component_status[i] == '2') {
                                 
                form_status = '<span class="text-success">Completed<span>';
                fontAwsom = '<i class="fa fa-check">'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'

            }else if (component_status[i] == '3') {
                                 
                form_status = '<span class="text-danger">Insufficiency<span>';
                fontAwsom = '<i class="fa fa-check">'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
            }else if (component_status[i] == '4') {
                
                form_status = '<span class="text-success">Verified Clear<span>';
                fontAwsom = '<i class="fa fa-check">'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            
            }else{

                form_status = '<span class="text-warning">pending<span>';
                fontAwsom = '<i class="fa fa-check">'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            $landlord ='';
            if (landlord_name) {

            $landlord = landlord_name[i]['landlord_name']?landlord_name[i]['landlord_name']:'';
            }
            // html += '<h6 class="full-nam2">Reference '+(j++)+'</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Previous Landlord Reference Check '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="row">'; 
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Landlord Contact Number</label>';
            html += '                  <input name="" readonly value="'+case_contact_no[i]['case_contact_no']+'" class="fld form-control case_contact_no" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Landlord Name</label>';
            html += '                  <input name="" readonly value="'+$landlord+'" class="fld form-control landlord_name" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>'; 

              var insuff_remarks ='';
                             if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
        if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

            // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+23+'\',\'Landload Reference\',\''+priority+'\','+i+',\'double\')">Raise Insufficiency</button>';
            // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+23+'\',\'Landload Reference\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            html += '   <hr>';        
        }
    }
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += '               </div>';
    html += '            </div>';

    $('#component-detail').html(html) 
}




function social_media(data,position,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                }else if (data.component_data.status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-warning">pending<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">Social Media Details</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Candidate Name</label>';
        html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        html += '               </div>'; 
        html += '            </div>';
 
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Date Of Birth(DOB)</label>';
        html += '                  <input name="" readonly value="'+data.component_data.dob+'"  class="fld form-control state" id="state" type="text">';
        html += '               </div>';
        html += '            </div>';

         
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Latest Employment Company name </label>';
        html += '                  <input name="" readonly value="'+data.component_data.employee_company_info+'"  class="fld form-control state" id="state" type="text">';
        html += '               </div>';
        html += '            </div>';

         
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Highest Education College</label>';
        html += '                  <input name="" readonly value="'+data.component_data.education_info+'"  class="fld form-control state" id="state" type="text">';
        html += '               </div>';
        html += '            </div>';

         
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                   <label>University name</label>';
        html += '                  <input name="" readonly value="'+data.component_data.university_info+'"  class="fld form-control state" id="state" type="text">';
        html += '               </div>';
        html += '            </div>';

         
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                   <label> Social media handles if any</label>';
        html += '                  <input name="" readonly value="'+data.component_data.social_media_info+'"  class="fld form-control state" id="state" type="text">';
        html += '               </div>';
        html += '            </div>';


        html += '         </div>';
           
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

         if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+25+'\',\'Social Media\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+25+'\',\'Social Media\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        html += '   <hr>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}


function covid_19(data,position,component_name){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.status.split(',');
    } 
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(data.component_data.candidate_id != '' || data.component_data.candidate_id != null){
        for (var i = 0; i < 1 ; i++) {
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            
            if(component_status[i] == '0'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            // alert('insuffDisable:'+insuffDisable)
            // alert('approvDisable:'+approvDisable)
            html += '            </div>';
            html += '         </div>';

            var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
        if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Covid-19\',\''+priority+'\','+i+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            html += '   <hr>';

        }
    }
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    
    // alert(html)
    $('#component-detail').html(html)
}



function view_docs_modal(url){ 
    // var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src",url);

    let html = '';
     
    html += '<a download class="btn bg-blu text-white" href="'+url+'">'
    html += '<i class="fa fa-download" aria-hidden="true"> Download</i>'
    html += '</a>';
    html += '<a class="btn bg-blu text-white mt-2" target="_blank" href="'+url+'">'
    html += '<i class="fa fa-eye" aria-hidden="true"> View Document in separate tab</i>'
    html += '</a>';


    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}

function view_edu_docs_modal(url){
    // alert(url) 
    // return false;
    // var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src", url);

    let html = '';
     
    html += '<a download class="btn bg-blu text-white" href="'+url+'">'
    html += '<i class="fa fa-download" aria-hidden="true"> Download</i>'
    html += '</a>';
    html += '<a class="btn bg-blu text-white mt-2" target="_blank" href="'+url+'">'
    html += '<i class="fa fa-eye" aria-hidden="true"> View Document in separate tab</i>'
    html += '</a>';

    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}



/*new component */


function sex_offender(data,priority,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';
                var none='';
                if (data.component_data.status == '0') {
                     none ='d-none';          
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.status == '1') {
                      none ='d-none';         
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                }else if (data.component_data.status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-warning">pending<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

        html += '<input name=""  value="'+data.component_data.sex_offender_id+'" class="fld form-control pincode" id="sex_offender_id" type="hidden">';
        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">Sex Offender</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>First Name</label>';
        html += '                  <input name=""  value="'+data.component_data.first_name+'" class="fld form-control global-first_name" id="global-first_name" type="text">';
        html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Last Name</label>';
        html += '                  <input name=""  value="'+data.component_data.last_name+'" class="fld form-control global-last_name" id="global-last_name" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Date Of Birth(DOB)</label>';
        html += '                  <input name=""  value="'+data.component_data.dob+'"  class="fld form-control global-dob" id="global-dob" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Gender</label>';
        html += '                  <input name=""  value="'+data.component_data.gender+'"  class="fld form-control global-gender" id="global-gender" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
          
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

          if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
        /* if (data.component_data.is_submitted !='0') { 
        html += '   <button class="insuf-btn '+none+'" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+28+'\',\'Sex Offender\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
        html += '   <button class="app-btn '+none+'" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+28+'\',\'Sex Offender\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        }*/
        html += '   <hr>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}



function politically_exposed(data,priority,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';
                var none='';
                if (data.component_data.status == '0') {
                     none ='d-none';          
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.status == '1') {
                      none ='d-none';         
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                }else if (data.component_data.status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-warning">pending<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

        html += '<input name=""  value="'+data.component_data.politically_exposed_id+'" class="fld form-control pincode" id="politically_exposed_id" type="hidden">';
        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">Politically Exposed Person</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>First Name</label>';
        html += '                  <input name=""  value="'+data.component_data.first_name+'" class="fld form-control global-first_name" id="global-first_name" type="text">';
        html += '               </div>'; 
        html += '            </div>';


        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Last Name</label>';
        html += '                  <input name=""  value="'+data.component_data.last_name+'" class="fld form-control global-last_name" id="global-last_name" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Date Of Birth(DOB)</label>';
        html += '                  <input name=""  value="'+data.component_data.dob+'"  class="fld form-control global-dob" id="global-dob" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Gender</label>';
        html += '                  <input name=""  value="'+data.component_data.gender+'"  class="fld form-control global-gender" id="global-gender" type="text">';
        html += '               </div>';
        html += '            </div>';
      html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Gender</label>';
        html += '                  <input name=""  value="'+data.component_data.address+'"  class="fld form-control global-address" id="global-address" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
          
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

          if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
        /* if (data.component_data.is_submitted !='0') { 
        html += '   <button class="insuf-btn '+none+'" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+29+'\',\'Politically Exposed Person\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
        html += '   <button class="app-btn '+none+'" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+29+'\',\'Politically Exposed Person\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        }*/
        html += '   <hr>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}



function india_civil_litigation(data,priority,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';
                var none='';
                if (data.component_data.status == '0') {
                     none ='d-none';          
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.status == '1') {
                      none ='d-none';         
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                }else if (data.component_data.status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-warning">pending<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

        html += '<input name=""  value="'+data.component_data.india_civil_litigation_id+'" class="fld form-control pincode" id="india_civil_litigation_id" type="hidden">';
        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">India Civil Litigation</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>First Name</label>';
        html += '                  <input name=""  value="'+data.component_data.first_name+'" class="fld form-control global-first_name" id="global-first_name" type="text">';
        html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Last Name</label>';
        html += '                  <input name=""  value="'+data.component_data.last_name+'" class="fld form-control global-last_name" id="global-last_name" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Date Of Birth(DOB)</label>';
        html += '                  <input name=""  value="'+data.component_data.dob+'"  class="fld form-control global-dob" id="global-dob" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Gender</label>';
        html += '                  <input name=""  value="'+data.component_data.gender+'"  class="fld form-control global-gender" id="global-gender" type="text">';
        html += '               </div>';
        html += '            </div>';
      html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Gender</label>';
        html += '                  <input name=""  value="'+data.component_data.address+'"  class="fld form-control global-address" id="global-address" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
          
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

          if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
         /*if (data.component_data.is_submitted !='0') { 
        html += '   <button class="insuf-btn '+none+'" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+30+'\',\'India Civil Litigation\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
        html += '   <button class="app-btn '+none+'" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+30+'\',\'India Civil Litigation\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        }*/
        html += '   <hr>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}




function gsa(data,priority,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';
                var none='';
                if (data.component_data.status == '0') {
                     none ='d-none';          
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.status == '1') {
                      none ='d-none';         
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                }else if (data.component_data.status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-warning">pending<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

        html += '<input name=""  value="'+data.component_data.gsa_id+'" class="fld form-control pincode" id="gsa_id" type="hidden">';
        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">GSA</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>First Name</label>';
        html += '                  <input name=""  value="'+data.component_data.first_name+'" class="fld form-control global-first_name" id="global-first_name" type="text">';
        html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Last Name</label>';
        html += '                  <input name=""  value="'+data.component_data.last_name+'" class="fld form-control global-last_name" id="global-last_name" type="text">';
        html += '               </div>';
        html += '            </div>';
        
        html += '         </div>';
          
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

          if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
        /* if (data.component_data.is_submitted !='0') { 
        html += '   <button class="insuf-btn '+none+'" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+33+'\',\'GSA\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
        html += '   <button class="app-btn '+none+'" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+33+'\',\'GSA\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        }*/
        html += '   <hr>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}




function gsa(data,priority,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';
                var none='';
                if (data.component_data.status == '0') {
                     none ='d-none';          
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.status == '1') {
                      none ='d-none';         
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                }else if (data.component_data.status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-warning">pending<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

        html += '<input name=""  value="'+data.component_data.oig_id+'" class="fld form-control pincode" id="oig_id" type="hidden">';
        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">OIG</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>First Name</label>';
        html += '                  <input name=""  value="'+data.component_data.first_name+'" class="fld form-control global-first_name" id="global-first_name" type="text">';
        html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Last Name</label>';
        html += '                  <input name=""  value="'+data.component_data.last_name+'" class="fld form-control global-last_name" id="global-last_name" type="text">';
        html += '               </div>';
        html += '            </div>';
        
        html += '         </div>';
          
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

          if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
       /*  if (data.component_data.is_submitted !='0') { 
        html += '   <button class="insuf-btn '+none+'" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+34+'\',\'OIG\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
        html += '   <button class="app-btn '+none+'" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+34+'\',\'OIG\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        }*/
        html += '   <hr>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}


function mca(data,priority,component_name,form_values,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(JSON.stringify(data))
    // console.log(data)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.status.split(',');
    } 
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(candidate_id != '' || candidate_id != null){
        for (var i = 0; i < 1; i++) {
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            
            if(component_status[i] == '0'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
                var  insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
                var organization_name = data.component_data.organization_name?data.component_data.organization_name:'-';
                var licence_d = data.component_data.experiance_doc?data.component_data.experiance_doc:'';
            }
            var organization_name = data.component_data.organization_name?data.component_data.organization_name:'-';
            var licence_d = data.component_data.experiance_doc?data.component_data.experiance_doc:'';
            
            html += '            </div>';
            html += '         </div>';
            
            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd"> </div>';
            html += '                   <label class="font-weight-bold">Organization Name: </label>'
            html += '                   <input type="text" class="fld form-control"  value="'+organization_name+'" >'
                if(licence_d != null && licence_d != ''){
                        var experiance_doc = data.component_data.experiance_doc;
                        var experiance_doc = experiance_doc.split(",");
                        for (var i = 0; i < experiance_doc.length; i++) {
                            var url = img_base_url+"../uploads/mca-docs/"+experiance_doc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(experiance_doc[i])){
                                html += '                   <label class="font-weight-bold  mt-3">Driving License: </label>'
                                html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+experiance_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+experiance_doc[i]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>';
                                 html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down"></i>';
                                html += '                               </a>';  
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(experiance_doc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+experiance_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }
                             if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
                        }
                }else{
                        html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                            
            html += '            </div>';
            html += '        </div>';

            /* if (data.component_data.is_submitted !='0') { 
            html += '   <button class="insuf-btn '+none+'" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'MCA\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
            html += '   <button class="app-btn '+none+'" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'MCA\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            }*/
            html += '   <hr>';

        }
    }
        html += '         <div class="row mt-2">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    
    // alert(html)
    $('#component-detail').html(html)
}



// diffrent check forms
function right_to_work(data,postion,component_name){ 

    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // address pin_code city  state  approved_doc
    let html='';
    if(data.status != '0'){

         var document_number =  JSON.parse(data.component_data.document_number)
        var mobile_number =  JSON.parse(data.component_data.mobile_number)
        var first_name =  JSON.parse(data.component_data.first_name)
        var last_name =  JSON.parse(data.component_data.last_name)
        var dob =  JSON.parse(data.component_data.dob)
        var gender =  JSON.parse(data.component_data.gender)
        var insuff_remarks = '';
        var component_status = data.component_data.analyst_status.split(',');
        // alert(JSON.stringify(info))
        var j = 1;
        var i = postion;
  
            var insuff_remarks = '';
            if (component_status[i] == '3') {
                
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            } 
        // for (var i = 0; i < address.length; i++) {
       
            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '      <div class="pg-txt-cntr">';
            html += '         <div class="pg-steps d-none">Step 2/6</div>';
            html += '         <h6 class="full-nam2"> Address Details '+(j++)+'</h6>';
             html += '<div class="row">';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<span class="input-field-txt">Document Number</span>';
            html += '<textarea class="input-field" readonly rows="1" id="document_number">'+document_number[i].document_number+'</textarea>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<span class="input-field-txt">Mobile Number</span>';
            html += '<input readonly value="'+mobile_number[i].mobile_number+'" class="input-field" id="mobile_number" type="text">';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<span class="input-field-txt">First Name</span>';
            html += '<input readonly value="'+first_name[i].first_name+'" class="input-field" id="first_name" type="text">';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<span class="input-field-txt">Last Name</span>';
            html += '<input readonly value="'+last_name[i].last_name+'" class="input-field" id="last_name" type="text">';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<span class="input-field-txt">Date Of Birth</span>';
            html += '<input readonly value="'+dob[i].dob+'" class="input-field" id="dob" type="text">';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<span class="input-field-txt">Gender</span>';
            html += '<input readonly value="'+gender[i].gender+'"  class="input-field" id="gender" type="text">';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '         </div>';  
            html += '      </div>';
            html += '   </div>';
            // alert(info[i].address)

             if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<textarea readonly  class="input-field form-control">'+insuff_remarks[i].insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }

        // }
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}


function nric(data,priority,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';
                var none='';
                if (data.component_data.status == '0') {
                     none ='d-none';          
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.status == '1') {
                      none ='d-none';         
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                }else if (data.component_data.status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-warning">pending<span>';
                    fontAwsom = '<i class="fa fa-check">'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

        html += '<input name=""  value="'+data.component_data.oig_id+'" class="fld form-control pincode" id="oig_id" type="hidden">';
        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">NRIC</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>NRIC Number</label>';
        html += '                  <input name=""  value="'+data.component_data.nric_number+'" class="fld form-control global-first_name" id="global-first_name" type="text">';
        html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Joining Date</label>';
        html += '                  <input name=""  value="'+data.component_data.joining_date+'" class="fld form-control global-last_name" id="global-last_name" type="text">';
        html += '               </div>';
        html += '            </div>'; 
        
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Expiry Date</label>';
        html += '                  <input name=""  value="'+data.component_data.end_date+'" class="fld form-control global-last_name" id="global-last_name" type="text">';
        html += '               </div>';
        html += '            </div>'; 
        
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Gender</label>';
        html += '                  <input name=""  value="'+data.component_data.gender+'" class="fld form-control global-last_name" id="global-last_name" type="text">';
        html += '               </div>';
        html += '            </div>'; 
        
        html += '         </div>';
           
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
        html += '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '      </div>';
        html += '   </div>';

          if (data.component_data.analyst_status == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<label>Insuff Remark Comment</label>'; 
                html += '<textarea readonly  class="input-field form-control">'+data.component_data.insuff_remarks+'</textarea>'; 
                html += '</div>';
                html += '</div>';
            }
       /*  if (data.component_data.is_submitted !='0') { 
        html += '   <button class="insuf-btn '+none+'" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+34+'\',\'OIG\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
        html += '   <button class="app-btn '+none+'" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+34+'\',\'OIG\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        }*/
        html += '   <hr>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}


function view_document_modal(documentName,folderName){ 
    var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src", img_base_url+"../uploads/"+folderName+"/"+image);

    let html = '';
     
    html += '<a download class="btn bg-blu text-white" href="'+img_base_url+"../uploads/"+folderName+"/"+image+'">'
    html += '<i class="fa fa-download" aria-hidden="true">Dwonload</i>'
    html += '</a>';
    html += '<a class="btn bg-blu text-white mt-2" target="_blank" href="'+url+'">'
    html += '<i class="fa fa-eye" aria-hidden="true">View Document in separate tab</i>'
    html += '</a>';
    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}
  

function view_personal_document_modal(documentName,folderName){ 
    var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src", img_base_url+"../uploads/"+folderName+"/"+image);

    let html = '';
     
    html += '<a download class="btn bg-blu text-white" href="'+img_base_url+"../uploads/"+folderName+"/"+image+'">'
    html += '<i class="fa fa-download" aria-hidden="true"> Dwonload</i>'
    html += '</a>'; 
    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}


$("#view_vendor_log").on('click',function(){
  $("#view_vendor_log_dailog").modal('show');
  var component_id = $("#component_id").val();
  var case_id = $("#candidate_id").val(); 
  $.ajax({
    type: "POST",
      url: base_url+"admin_Vendor/get_all_vendor_logs", 
      data:{case_id:case_id,component_id:component_id},
      dataType: "json",
      success: function(data){ 
        // console.log(JSON.stringify(data));
    let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
          // var components = JSON.parse(data[i]['component_name']);
          html += '<tr>'; 
          html += '<td>'+j+'</td>';
          html += '<td>'+data[i]['vendor_name']+'</td>';  
          html += '<td>'+data[i]['component_name']+'</td>'; 
          html += '<td>'+data[i]['created_date']+'</td>'; 
          html += '</tr>'; 
       
          j++; 
        }
      }else{
        html+='<tr><td colspan="5" class="text-center">Not Found.</td></tr>'; 
    }
    $('#list_vendor_log_data').html(html); 
      } 
  });

});
 