function view_report(){
   window.open(base_url+'factsuite-client/htmlGenrateReport/'+candidate_id,'_blank');
}

function load_case(candidate_id) { 
    $.ajax({
        type: "POST",
        url: base_url+"cases/get_single_case/"+candidate_id,  
        dataType: "json",
        success: function(data) {
        let html = '';
        if (data.length > 0) {
            var j = 1,
                count_download_option = 0,
                download_report_html = '',
                $img = '';
            if (data[0]['additional_docs'] !=null && data[0]['additional_docs'] !='null' && data[0]['additional_docs'] !='') {
                $img = '<a download class="btn bg-blu btn-sm text-white mt-2" href="'+img_base_url+'../uploads/additional-docs/'+data[0]['additional_docs']+'">Additional Documents</a>';

                } 
                // alert(data[0].component_name)
                $('#caseId').html(data[0]['candidate_id']);
                $('#camdidateName').html(data[0]['first_name']+' '+data[0]['last_name']);
                $('#clientName').html(data[0]['employee_id'] != '' ? data[0]['employee_id'] : '-');
                $('#camdidatephoneNumber').html(data[0]['country_code']+'-'+data[0]['phone_number']);
                $('#packageName').html(data[0]['package_name'] != '' ? data[0]['package_name'] : '-');
                $('#camdidateEmailId').html(data[0]['email_id']); 
                $("#download-aditional-doc").html($img);
                if(data[0]['is_report_generated'] == 1 && data[0]['is_submitted'] == 2) {
                    $('#report-button').html('<a id="genrate_report" class="btn bg-blu btn-sm text-white d-none" href="'+base_url+'factsuite-client/htmlGenrateReport/'+candidate_id+'">View&nbsp;Report</a>&nbsp;<a id="genrate_report" class="btn bg-blu btn-sm text-white" href="'+base_url+'factsuite-client/htmlGenrateReport/'+candidate_id+'">Download&nbsp;Report</a>');
                    $('#report-button-2').html('<a id="genrate_report" class="btn custom-btn-1 d-none" href="'+base_url+'factsuite-client/htmlGenrateReport/'+candidate_id+'">View&nbsp;Report</a>&nbsp;<a id="genrate_report" class="btn custom-btn-1" href="'+base_url+'factsuite-client/htmlGenrateReport/'+candidate_id+'">Download&nbsp;Report<img class="pl-2" src="'+img_base_url+'assets/client/assets-v2/dist/img/download.svg"></a>');
                    download_report_html += '<a onclick="view_report()" id="genrate_report" class="dropdown-item" href="#">Download Report</a>';
                } else {  
                    if (data[0]['client_case_intrim_notification'] !='0') {
                        
                    download_report_html += '<a target="_blank" id="genrate_report" class="dropdown-item" href="'+base_url+'factsuite-client/generate-pdf-report/'+candidate_id+'">Interim Report</a>';
                    }
                    $('#report-button').html('<a id="genrate_report" class="btn bg-blu btn-sm text-white" href="'+base_url+'factsuite-client/generate-pdf-report/'+candidate_id+'">Download&nbsp;Interim&nbsp;Report</a>')
                    $('#report-button-2').html('<a id="genrate_report" class="btn custom-btn-1" href="'+base_url+'factsuite-client/generate-pdf-report/'+candidate_id+'">Download&nbsp;Interim&nbsp;Report<img class="pl-2" src="'+img_base_url+'assets/client/assets-v2/dist/img/download.svg"></a>');
                    count_download_option++;
                }
                
                var n = 1;
                for (var i = 0; i < data.length; i++) { 
                    var status = '';
                    var classStatus = '';
                    var fontAwsom='';
                    var insuffDisable = '';
                    var approvDisable = '';
                    // 0-pending 1-onprogress 2-completed 3-insufficiency 4-approved

                     // alert(data[i].component_data.analyst_status+'a')
                     // alert(data[i].component_data.output_status+'qc')

                        // var analystStatus = []; 
         
                        var analyst_status = '0'.split(','); 
                        var output_status = '0'.split(','); 
                        if (data[i].component_data !=null && data[i].component_data !='undefined') {
                            var analyst_status = data[i].component_data.analyst_status.split(','); 
                            var output_status = data[i].component_data.output_status.split(',');
                        }

                        var index = 0;
                        for (var k = 0; k < analyst_status.length; k++) {
                             // alert(data[i].component_name+":"+analyst_status[k]) 
                            var analystStatus ='';  
                            if (analyst_status[k] == '0') { 
                                analystStatus = '<span class="case-status case-status-2 text-warning">Not Initiated<span>';
                                fontAwsom = '<i class="fa fa-exclamation"></i>'
                            }else if (analyst_status[k] == '1') {
                                 
                                analystStatus = '<span class="case-status case-status-2 text-info">In Progress<span>';
                                // analystStatus = '<i class="fa fa-check"></i>'
                            }else if (analyst_status[k] == '2') {
                                 
                                analystStatus = '<span class="case-status case-status-2 text-success">Completed<span>';
                                
                            }else if (analyst_status[k]== '3') {
                                 
                                analystStatus = '<span class="case-status case-status-2 text-danger">Insufficiency<span>';
                                
                            }else if (analyst_status[k] == '4') {
                               
                                analystStatus = '<span class="case-status case-status-2 text-success">Verified Clear<span>';
                                
                            }else if (analyst_status[k] == '5') {
                               
                                analystStatus = '<span class="case-status case-status-2 text-danger">Stop Check<span>';
                                
                            }else if (analyst_status[k] == '6') {
                               
                                analystStatus = '<span class="case-status case-status-2 text-danger">Unable to Verify<span>';
                                
                            }else if (analyst_status[k] == '7') {
                               
                                analystStatus = '<span class="case-status case-status-2 text-danger">Verified Discrepancy<span>';
                               
                            }else if (analyst_status[k] == '8') {
                               
                                analystStatus = '<span class="case-status case-status-2 w-100 text-black">Client Clarification<span>';
                               
                            }else if (analyst_status[k] == '9') {
                               
                                analystStatus = '<span class="case-status case-status-2 text-danger">Closed Insufficiency<span>';
                                
                            } else if (analyst_status[k] == '11') {
                                analystStatus = '<span class="case-status case-status-2 text-warning">Insufficiency Clear<span>';  
                            } else {
                                analystStatus = '<span class="case-status case-status-2 text-info">In Progress<span>';
                            }

                            // console.log(JSON.stringify(analystStatus))
                            var formValues = JSON.parse(data[i].form_values);

                            var arg = data[i].candidate_id+','+data[i].component_id+','+data[i].priority+',"'+data[i].component_name+'",'+index;
                            index++;
                            var argNew = data[i].candidate_id+'/'+data[i].component_id;
                            var argWithName = data[i].candidate_id+','+data[i].component_id+',\''+data[i].component_name+'\',\''+data[i].first_name+'\',\''+data[i].email_id+'\'';
                            var from_all_cases = $('#from-all-cases').val()
                            html += '<tr id="tr_'+data[i].candidate_id+'">'; 
                            html += '<td>'+n+'</td>';
                            html += '<td>'+data[i].component_name+' '+index+'</td>';
                            html += '<td id="status'+data[i].candidate_id+'">'+analystStatus+'</td>';           
                            // html += '<td class="text-center"><a disabled href="'+base_url+'factsuite-outputqc/component-detail/'+argNew+'/'+from_all_cases+'" class="app-btn">View <i class="fas fa-angle-right"></i></a></td>';  
                            // html += '<td class="text-center"><a  class="app-btn btn btn-warning text-white" onclick="getComponentBasedData('+arg+')">View</i></a></td>';
                            // class='view-bg'
                            html += "<td class='text-center'><a id ='arg_"+i+"' data-object ='"+data[i].form_values+"' onclick='getComponentBasedData("+arg+","+formValues+")'><img src='"+img_base_url+"assets/client/assets-v2/dist/img/black-eye.svg'></a></td>";
                            if (request_from.toLowerCase() == 'client-clarification') {
                                // html += "<td class='text-center'><a id ='arg_"+i+"' data-object ='"+data[i].form_values+"' onclick='view_all_client_clarifications("+arg+","+formValues+")'><img src='"+img_base_url+"assets/client/assets-v2/dist/img/black-eye.svg'></a></td>";
                            }
                            html += "<td class='text-center'><a id ='arg_"+i+"' data-object ='"+data[i].form_values+"' onclick='view_all_client_clarifications("+arg+","+formValues+")'><img src='"+img_base_url+"assets/client/assets-v2/dist/img/black-eye.svg'></a></td>";
                            html += '</tr>';

                            n++;
                            // index++;              
                        }

                        priority = ''
                        priorityClass = ''
                        PrioritySelected = ''
                        lowPrioritySelected = ''
                        midPrioritySelected = ''
                        highPrioritySelected = ''

                        if(data[0].priority == '0') {
                            PrioritySelected = 'Low'
                            priorityClass = 'text-info font-weight-bold'
                            // lowPrioritySelected = 'selected'
                        } else if(data[0].priority == '1') {  
                            PrioritySelected = 'Medium'
                            priorityClass = 'text-warning font-weight-bold'
                            // midPrioritySelected = 'selected'
                        } else if(data[0].priority == '2') {  
                            PrioritySelected = 'High'
                            priorityClass = 'text-danger font-weight-bold'
                            // highPrioritySelected = 'selected'
                        }

                        priority += '<label class="font-weight-bold">Priority: </label>&nbsp;';
                        priority += '<span class="'+priorityClass+'">'+PrioritySelected+'</span>';
                        // priority += '<select id="action_status" name="carlist" class="sel-allcase" onchange="priority_status('+data[0]['candidate_id']+',this.value)">';
                        //     priority += '<option '+lowPrioritySelected+' value="0">Low priority</option>';
                        //     priority += '<option '+midPrioritySelected+' value="1">Medium priority</option>';
                        //     priority += '<option '+highPrioritySelected+' value="2">High priority</option>'; 
                        // priority += '</select>';
                        var priority_html_2 = '<label class="input-field-txt-2">Priority Level</label>';
                        priority_html_2 += '<div class="input-field input-field-2 '+priorityClass+'">'+PrioritySelected+'</div>';
                        $('#priority-div').html(priority);
                        $('#priority-div-2').html(priority_html_2);
                    j++;
                }

                if (access != 0) {
                    count_download_option++;
                    download_report_html += '<a target="_blank" id="genrate_report" class="dropdown-item" href="'+base_url+'cases/get_zip/'+candidate_id+'">Candidates Docs</a>';
                }

                if (count_download_option != 0) {
                    $('#download-report-dropdown-btn').removeClass('d-none');
                    $('#download-report-dropdown').html(download_report_html);
                }
            } else {
                html+='<tr><td colspan="4" class="text-center">No Case Found.</td></tr>'; 
            }
            $('#get-case-data').html(html); 
        } 
    });
}
 
function getComponentBasedData(candidate_id,component_id,priority,component_name,component_index,form_values){
   
    $.ajax({
        type: "POST",
        url: base_url+"cases/getComponentBasedData",
        data:{
            candidate_id:candidate_id,
            component_id:component_id
        },
        dataType: "json",
        success: function(data){  
            // console.log(JSON.stringify(data))
            switch(component_id){
                case 1:
                    criminal_checks(data,component_name)
                    break;
                case 2:
                    court_records(data,component_name)
                    break;
                case 3:
                    document_check(data,component_name)
                    break;
                case 4:
                    drugtest(data,component_name)
                    break;
                case 5:
                    globaldatabase(data,component_name)
                    break;
                case 6:
                    current_employment(data,component_name)
                    break;
                case 7:
                    education_details(data,component_name)
                    break;
                case 8:
                    present_address(data,component_name)
                    break;
                case 9:
                    permanent_address(data,component_name)
                    break;
                case 10:
                    previous_employment(data,component_name)
                    break;
                case 11:
                    reference(data,component_name)
                    break;
                case 12:
                    previous_address(data,component_name)
                    break;
                case 14:
                    directorship_check(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 15:
                    global_aml_sanctions(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 16:
                    driving_License(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 17:
                    credit_cibil_check(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 18:
                    bankruptcy_check(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 19:
                    adverse_database_media_check(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 20:
                    cv_check(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 21:
                    health_checkup_check(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 22:
                    employement_gap_check(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 23:
                    landload_reference(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 24:
                    covid_19(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                case 25:
                    social_media(data,priority,form_values,component_name,candidate_id,component_id)
                    break;
                 case 26:
                    civil_check(data,component_name)
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
function criminal_checks(data,component_name) {
    $('#insuff-comment-div').empty();
    $('#modal-headding').html(component_name);
    // address pin_code city  state  approved_doc
    let html = '';
    if(data.status != '0') {
        var address =  JSON.parse(data.component_data.address)
        var pin_code =  JSON.parse(data.component_data.pin_code)
        var city =  JSON.parse(data.component_data.city)
        var state =  JSON.parse(data.component_data.state)
        var insuff_remarks = '';
        var component_status = data.component_data.analyst_status.split(',');
        var j = 1;
        
        for (var i = 0; i < address.length; i++) {
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
                fontAwsom = '<i class="fa fa-check"></i>'
                rightClass ='bac-gr'
            }else if (component_status[i] == '2') {
                         
                form_status = '<span class="text-success">Completed<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else if (component_status[i] == '3') {
                         
                form_status = '<span class="text-danger">Insufficiency<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            }else if (component_status[i] == '4') {
                       
                form_status = '<span class="text-success">Verified Clear<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else{

                form_status = '<span class="text-danger">Wrong<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '<div class="pg-txt-cntr">';
            html += '<div class="pg-steps d-none">Step 2/6</div>';
            html += '<div class="row">';
            html += '<div class="col-md-6">';
            html += '<h6 class="full-nam2"> Address Details '+(j++)+'</h6> ';
            html += '</div>';
            html += '<div class="col-md-4 d-none">';
            html += '<label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-8">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea class="input-field" readonly rows="1" id="address">'+address[i].address+'</textarea>';
            html += '<span class="input-field-txt">Address</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+pin_code[i].pincode+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Pin Code</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+city[i].city+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">City/Town</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+state[i].state+'"  class="input-field" id="state" type="text">';
            html += '<span class="input-field-txt">State</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';  
            html += '</div>';
            html += '</div>';
            // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+1+'\',\'Criminal Check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+1+'\',\'Criminal Check\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            // alert(info[i].address)
            if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }

            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
        }
    } else {
        html += '<div class="row">';
        html += '<div class="col-md-12">';
        html += '<h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '</div>';
        html += '</div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}



// diffrent check forms
function civil_checks(data,component_name) {
    $('#insuff-comment-div').empty();
    $('#modal-headding').html(component_name);
    // address pin_code city  state  approved_doc
    let html = '';
    if(data.status != '0') {
        var address =  JSON.parse(data.component_data.address)
        var pin_code =  JSON.parse(data.component_data.pin_code)
        var city =  JSON.parse(data.component_data.city)
        var state =  JSON.parse(data.component_data.state)
        var insuff_remarks = '';
        var component_status = data.component_data.analyst_status.split(',');
        var j = 1;
        
        for (var i = 0; i < address.length; i++) {
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
                fontAwsom = '<i class="fa fa-check"></i>'
                rightClass ='bac-gr'
            }else if (component_status[i] == '2') {
                         
                form_status = '<span class="text-success">Completed<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else if (component_status[i] == '3') {
                         
                form_status = '<span class="text-danger">Insufficiency<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if (component_status[i] == '4') {
                       
                form_status = '<span class="text-success">Verified Clear<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else{

                form_status = '<span class="text-danger">Wrong<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '<div class="pg-txt-cntr">';
            html += '<div class="pg-steps d-none">Step 2/6</div>';
            html += '<div class="row">';
            html += '<div class="col-md-6">';
            html += '<h6 class="full-nam2"> Address Details '+(j++)+'</h6> ';
            html += '</div>';
            html += '<div class="col-md-4 d-none">';
            html += '<label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-8">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea class="input-field" readonly rows="1" id="address">'+address[i].address+'</textarea>';
            html += '<span class="input-field-txt">Address</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+pin_code[i].pincode+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Pin Code</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+city[i].city+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">City/Town</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+state[i].state+'"  class="input-field" id="state" type="text">';
            html += '<span class="input-field-txt">State</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';  
            html += '</div>';
            html += '</div>';
            // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+1+'\',\'Criminal Check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+1+'\',\'Criminal Check\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            // alert(info[i].address)
            if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }

            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
        }
    } else {
        html += '<div class="row">';
        html += '<div class="col-md-12">';
        html += '<h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '</div>';
        html += '</div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}

function court_records(data,component_name) {
    $('#modal-headding').html(component_name)
    let html='';
    if(data.status != '0'){
        var address =  JSON.parse(data.component_data.address)
        var pin_code =  JSON.parse(data.component_data.pin_code)
        var city =  JSON.parse(data.component_data.city)
        var state =  JSON.parse(data.component_data.state)
        var insuff_remarks = '';
        var component_status = data.component_data.analyst_status.split(',')
        var j = 1;
        if(address.length > 0){
            for (var i = 0; i < address.length; i++) {
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
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (component_status[i] == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (component_status[i] == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (component_status[i] == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-danger">Wrong<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }
                var errorMessage = 'This value was not enter by candidate.';
                var pinCode = errorMessage
                if(pin_code.length > i){
                    pinCode = pin_code[i].pincode
                } 
                html += ' <div class="pg-cnt pl-0 pt-0">';
                html += '<div class="pg-txt-cntr modal-component-details">';
                // html += '<h6 class="full-nam2"> Address Details '+(j++)+'</h6>';
                html += '<div class="row">';
                // html += '<div class="col-md-6">';
                // html += '<h6 class="full-nam2"> Court Record '+(j++)+'</h6> ';
                // html += '</div>';
                html += '<div class="col-md-4 d-none">';
                html += '<label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
                html += '</div>';
                html += '</div>';
                html += '<div class="row">';
                html += '<div class="col-md-8">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea class="input-field" readonly rows="1" id="address">'+address[i].address+'</textarea>';
                html += '<span class="input-field-txt">Address</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                html += '<div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+pinCode+'" class="input-field" id="pincode" type="text">';
                html += '<span class="input-field-txt">Pin Code</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                html += '<div class="row">';
                html += '<div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+city[i].city+'" class="input-field" id="city" type="text">';
                html += '<span class="input-field-txt">City/Town</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+state[i].state+'"  class="input-field" id="state" type="text">';
                html += '<span class="input-field-txt">State</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';  
                html += '</div>';
                html += '</div>';
                if (component_status[i] == '3') {
                    html += '<div class="row">';
                     html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                    html += '<div class="col-md-12">';
                    html += '<div class="input-wrap">';
                    html += '<div class="pg-frm">';
                    html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                    html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                }
                // html += '<button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+2+'\',\'court records\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
                // html += '<button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+2+'\',\'court records\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
                // html += '<hr>';
                html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
                // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            }
        }else{
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<h6 class="full-nam2">Incorrect details.</h6>';
            html += '</div>';
            html += '</div>';
        }
    }else{
        html += '<div class="row">';
        html += '<div class="col-md-12">';
        html += '<h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '</div>';
        html += '</div>';
    }
    $('#component-detail').html(html);
    $('#componentModal').modal('show');
}

function document_check(data,component_name) {
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){
        var formValues = JSON.parse(data.component_data.form_values)
        formValues = JSON.parse(formValues);
         
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
         
        var ssn_doc = data.component_data.ssn_doc
        if(ssn_doc == null || ssn_doc == ''){
            voter_doc_length = 0;
        }else{
            ssn_doc = ssn_doc.split(",");
            voter_doc_length = ssn_doc.length;
        }
            
        var inputQcStatus = data.component_data.analyst_status.split(',');
        var insuff_remarks = '';

        if(data.component_data.aadhar_number.length  > 0  && $.inArray('2',formValues.document_check) !== -1){
            
            var adharcardStatus = indexFromTheValue(formValues.document_check,'2')
            // if(inputQcStatus[adharcardStatus] == '1' )
            var insuffDisable = '';
            var approvDisable = '';
            var rightClass = '';
            var form_status = '';

            if (inputQcStatus[adharcardStatus] == '0') {
                             
                form_status = '<span class="text-warning">Pending</span>'; 
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if (inputQcStatus[adharcardStatus] == '1') {
                             
                form_status = '<span class="text-info">Form Filled</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                rightClass ='bac-gr'
            }else if (inputQcStatus[adharcardStatus] == '2') {
                             
                form_status = '<span class="text-success">Completed</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else if (inputQcStatus[adharcardStatus] == '3') {
                             
                form_status = '<span class="text-danger">Insufficiency</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if (inputQcStatus[adharcardStatus] == '4') {
                           
                form_status = '<span class="text-success">Verified Clear</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else{

                form_status = '<span class="text-danger">Wrong</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }


            html += '<div class="row mt-3">';
            html += '<div class="col-md-4">';
            // html += '<div class="pg-frm-hd">Aadhar Card</div>';
            // html += '                  <label class="font-weight-bold d-none">Status: </label>'+form_status;
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly class="input-field adhar_number" id="adhar_number" type="text" value="'+data.component_data.aadhar_number+'">';
            html += '<span class="input-field-txt">Aadhar Card</span>';
            html += '</div>';
            html += '</div>';
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
                     
                    // html += '   <hr>';
                    
                }
                // html += '   <button class="insuf-btn" id="insuf_btn_'+adharcardStatus+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+adharcardStatus+',\'double\')">Insufficiency</button>';                                                                                                    // modalInsuffi(candidate_id,component_id,componentname,priority,position,status)
                // html += '   <button class="app-btn" id="app_btn_'+adharcardStatus+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+adharcardStatus+',\'double\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            }else{
                html += '   <label class="font-weight-bold">Note: Attechment Not Found. </label><br>';
                // html += '   <button class="insuf-btn" desabled id="insuf_btn_'+passportStatus+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')">Insufficiency</button>';
                // html += '   <button class="app-btn" desabled id="app_btn_'+passportStatus+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')"><i id="app_btn_icon_'+passportStatus+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';

            }
            // for loop will end 
            html += '            </div>';
            if (inputQcStatus[adharcardStatus] == '3') {
                html += '<div class="col-md-12">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[adharcardStatus].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+adharcardStatus+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,adharcardStatus,'form-values');
        }
        
        if(data.component_data.pan_number.length > 0 && $.inArray('1',formValues.document_check) !== -1){

            var pancardStatus = indexFromTheValue(formValues.document_check,'1')

            var insuffDisable = '';
            var approvDisable = '';
            var rightClass = '';
            var form_status = '';

            if (inputQcStatus[pancardStatus] == '0') {
                             
                form_status = '<span class="text-warning">Pending</span>'; 
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if (inputQcStatus[pancardStatus] == '1') {
                             
                form_status = '<span class="text-info">Form Filled</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                rightClass ='bac-gr'
            }else if (inputQcStatus[pancardStatus] == '2') {
                             
                form_status = '<span class="text-success">Completed</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else if (inputQcStatus[pancardStatus] == '3') {
                             
                form_status = '<span class="text-danger">Insufficiency</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if (inputQcStatus[pancardStatus] == '4') {
                           
                form_status = '<span class="text-success">Verified Clear</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else{

                form_status = '<span class="text-danger">Wrong</span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
               
                html += '            <div class="col-md-4">';
                // html += '               <div class="pg-frm-hd">Pan Card</div>';
                // html += '                  <label class="font-weight-bold d-none">Status: </label>'+form_status;
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly class="input-field city" id="city" type="text" value="'+data.component_data.pan_number+'">';
                html += '<span class="input-field-txt">Pan Card</span>';
                html += '</div>';
                html += '</div>';
                                    // for loop will start 
                if(pan_card_doc != '' && pan_card_doc != null && data.component_data.pan_number !='' &&  data.component_data.pan_number !=null &&  data.component_data.pan_number !='undefined' ){
                    for (var i = 0; i < pan_card_doc.length; i++) {
                        var url = img_base_url+"../uploads/pan-docs/"+pan_card_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(pan_card_doc[i])){
                            html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
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
                            
                            html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
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
                        
                    }
                    // html += '   <button class="insuf-btn" id="insuf_btn_'+pancardStatus+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+pancardStatus+',\'double\')">Insufficiency</button>';
                    // html += '   <button class="app-btn" id="app_btn_'+pancardStatus+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+pancardStatus+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';

                }else{
                    html += '   <label class="font-weight-bold">Note: Attechment Not Found. </label><br>';
                    // html += '   <button class="insuf-btn" desabled id="insuf_btn_'+passportStatus+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')">Insufficiency</button>';
                    // html += '   <button class="app-btn" desabled id="app_btn_'+passportStatus+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')"><i id="app_btn_icon_'+passportStatus+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';

                }
                                // for loop will end  
                html += '        </div>';
            if (inputQcStatus[pancardStatus] == '3') {
                html += '<div class="col-md-12">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[pancardStatus].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }

            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+pancardStatus+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,pancardStatus,'form-values');
        }
        


        if(data.component_data.passport_number !='' && data.component_data.passport_number !=null && $.inArray('3',formValues.document_check) !== -1){

                var passportStatus = indexFromTheValue(formValues.document_check,'3')
                // alert(typeof formValues.document_check)
                // alert(formValues.document_check)
                // alert(formValues.document_check.indexOf('3'))
                var psinsuffDisable = '';
                var psapprovDisable = '';
                var rightClass = '';
                var form_status = '';
                // alert('passportStatus: '+passportStatus)
                if (inputQcStatus[passportStatus] == '0') {
                    // alert('0: '+passportStatus)              
                    form_status = '<span class="text-warning">Pending</span>'; 
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (inputQcStatus[passportStatus] == '1') {
                     // alert('1: '+passportStatus)              
                    form_status = '<span class="text-info">Form Filled</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    // psinsuffDisable = 'disabled'
                    // psapprovDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (inputQcStatus[passportStatus] == '2') {
                      // alert('2: '+passportStatus)             
                    form_status = '<span class="text-success">Completed</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (inputQcStatus[passportStatus] == '3') {
                     // alert('3: '+passportStatus)              
                    form_status = '<span class="text-danger">Insufficiency</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (inputQcStatus[passportStatus] == '4') {
                     // alert('4: '+passportStatus)            
                    form_status = '<span class="text-success">Verified Clear</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-danger">Wrong</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    rightClass ='bac-gy'
                }
             
                html += '<div class="col-md-4">';
                // html += '<div class="pg-frm-hd">Passport</div>';
                // html += '                  <label class="font-weight-bold d-none">Status: </label>'+form_status;
                // html += '<input name="" readonly class="fld form-control city" id="city" type="text" value="'+data.component_data.passport_number+'">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly class="input-field city" id="city" type="text" value="'+data.component_data.passport_number+'">';
                html += '<span class="input-field-txt">Passport</span>';
                html += '</div>';
                html += '</div>';
                                // for loop will start passport_doc.length
                if( passport_doc !='' && passport_doc !=null && data.component_data.passport_number !='' && data.component_data.passport_number !=null && data.component_data.passport_number !='undefined'){
                    for (var i = 0; i < passport_doc.length; i++) {
                        var url = img_base_url+"../uploads/proof-docs/"+passport_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(passport_doc[i])){
                            html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
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
                            
                            html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
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

                        // html += '   <button class="insuf-btn" id="insuf_btn_'+passportStatus+'" '+psinsuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')">Insufficiency</button>';
                        // html += '   <button class="app-btn" id="app_btn_'+passportStatus+'" '+psapprovDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')"><i id="app_btn_icon_'+passportStatus+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';

                    }
                }else{

                    html += '   <label class="font-weight-bold">Note: Attechment Not Found. </label><br>';
                    // html += '   <button class="insuf-btn" desabled id="insuf_btn_'+passportStatus+'" onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')">Insufficiency</button>';
                    // html += '   <button class="app-btn" desabled id="app_btn_'+passportStatus+'" onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')"><i id="app_btn_icon_'+passportStatus+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';

                }
                                // for loop will end  
            html += '         </div>';
            if (inputQcStatus[passportStatus] == '3') {
                html += '<div class="col-md-12">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[passportStatus].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+passportStatus+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,passportStatus,'form-values');  
            html += '      </div>';
        }

        if(data.component_data.voter_id !='' && data.component_data.voter_id !=null && $.inArray('4',formValues.document_check) !== -1){

                var passportStatus = indexFromTheValue(formValues.document_check,'3')
                // alert(typeof formValues.document_check)
                // alert(formValues.document_check)
                // alert(formValues.document_check.indexOf('3'))
                var psinsuffDisable = '';
                var psapprovDisable = '';
                var rightClass = '';
                var form_status = '';
                // alert('passportStatus: '+passportStatus)
                if (inputQcStatus[passportStatus] == '0') {
                    // alert('0: '+passportStatus)              
                    form_status = '<span class="text-warning">Pending</span>'; 
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (inputQcStatus[passportStatus] == '1') {
                     // alert('1: '+passportStatus)              
                    form_status = '<span class="text-info">Form Filled</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    // psinsuffDisable = 'disabled'
                    // psapprovDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (inputQcStatus[passportStatus] == '2') {
                      // alert('2: '+passportStatus)             
                    form_status = '<span class="text-success">Completed</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (inputQcStatus[passportStatus] == '3') {
                     // alert('3: '+passportStatus)              
                    form_status = '<span class="text-danger">Insufficiency</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (inputQcStatus[passportStatus] == '4') {
                     // alert('4: '+passportStatus)            
                    form_status = '<span class="text-success">Verified Clear</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-danger">Wrong</span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    psinsuffDisable = 'disabled'
                    psapprovDisable = 'disabled'
                    rightClass ='bac-gy'
                }
             
                html += '<div class="col-md-4">';
                // html += '<div class="pg-frm-hd">Passport</div>';
                // html += '                  <label class="font-weight-bold d-none">Status: </label>'+form_status;
                // html += '<input name="" readonly class="fld form-control city" id="city" type="text" value="'+data.component_data.voter_id+'">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly class="input-field city" id="city" type="text" value="'+data.component_data.voter_id+'">';
                html += '<span class="input-field-txt">Passport</span>';
                html += '</div>';
                html += '</div>';
                                // for loop will start passport_doc.length
                if( voter_doc !='' && voter_doc !=null && data.component_data.voter_id !='' && data.component_data.voter_id !=null && data.component_data.voter_id !='undefined'){
                    for (var i = 0; i < voter_doc.length; i++) {
                        var url = img_base_url+"../uploads/voter-docs/"+voter_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(voter_doc[i])){
                            html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
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
                            
                            html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
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

                        // html += '   <button class="insuf-btn" id="insuf_btn_'+passportStatus+'" '+psinsuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')">Insufficiency</button>';
                        // html += '   <button class="app-btn" id="app_btn_'+passportStatus+'" '+psapprovDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')"><i id="app_btn_icon_'+passportStatus+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';

                    }
                }else{

                    html += '   <label class="font-weight-bold">Note: Attechment Not Found. </label><br>';
                    // html += '   <button class="insuf-btn" desabled id="insuf_btn_'+passportStatus+'" onclick="modalInsuffi('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')">Insufficiency</button>';
                    // html += '   <button class="app-btn" desabled id="app_btn_'+passportStatus+'" onclick="modalapprov('+data.component_data.candidate_id+',\''+3+'\',\'Adhar card document check\',\''+priority+'\','+passportStatus+',\'double\')"><i id="app_btn_icon_'+passportStatus+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';

                }
                                // for loop will end  
            html += '         </div>';
            if (inputQcStatus[passportStatus] == '3') {
                html += '<div class="col-md-12">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[passportStatus].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+passportStatus+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,passportStatus,'form-values');   
            html += '      </div>';
        }


            if(data.component_data.ssn_number !='' && data.component_data.ssn_number !=null  && $.inArray('5',formValues.document_check) !== -1 ){
            
                 
                html += '            <div class="col-md-4">';
                // html += '               <div class="pg-frm-hd">SSN Number</div>';
                // html += '                  <label class="font-weight-bold">Status: </label>'+form_status;
                // html += '                  <input name="" readonly class="fld form-control city" id="city" type="text" value="'+data.component_data.ssn_number+'">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly class="input-field city" id="city" type="text" value="'+data.component_data.ssn_number+'">';
                html += '<span class="input-field-txt">SSN Number</span>';
                html += '</div>';
                html += '</div>';
                                // for loop will start passport_doc.length
                if( ssn_doc !='' && ssn_doc !=null && data.component_data.ssn_number !='' && data.component_data.ssn_number !=null && data.component_data.ssn_number !='undefined'){
            
                    for (var i = 0; i < ssn_doc.length; i++) {
            
                        var url = img_base_url+"../uploads/ssn_doc/"+ssn_doc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(ssn_doc[i])){
                            html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+ssn_doc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';

                        }else if((/\.(pdf)$/i).test(ssn_doc[i])){
                            
                            html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+ssn_doc[i]+'</li>'
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
             




        // /else{
        //     html += '         <div class="row">';
        //     html += '            <div class="col-md-12">';
        //     html += '               <h6 class="full-nam2">Incorrect Data</h6>';
        //     html += '            </div>';
        //     html += '         </div>'; 
        // }///////////// 
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }
    $('#component-detail').html(html);
    $('#componentModal').modal('show');
}

function drugtest(data,component_name) {
    $('#modal-headding').html(component_name)

    var address = JSON.parse(data.component_data.address)
    var candidate_name = JSON.parse(data.component_data.candidate_name)
    var father_name = JSON.parse(data.component_data.father__name)
    var dob = JSON.parse(data.component_data.dob)
    var mobile_number = JSON.parse(data.component_data.mobile_number)
    var insuff_remarks = '';
    var component_status = data.component_data.analyst_status.split(',')
    let html='';

    var form_values =  JSON.parse(data.component_data.form_values)
    var form_values =  JSON.parse(form_values)
    // alert(form_values['drug_test'].length)
    // console.log(candidate_name)
    // console.log(candidate_name.length)

    drugtestTypes = ['5-Panel','6-Panel','7-Panel','9-Panel','10-Panel','12-Panel']
    drugtestTypesIds = ['1','2','3','4','5']

    var j = 1;
    if(data.status != '0'){
        if(candidate_name.length > 0){
            for(var i=0;i < form_values['drug_test'].length;i++){
                 
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
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (component_status[i] == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (component_status[i] == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (component_status[i] == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{drugtest

                    form_status = '<span class="text-danger">Wrong<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

                drugtestTypesId = form_values['drug_test'][i];

                html += ' <div class="pg-cnt pl-0 pt-0">';
                html += '<div class="pg-txt-cntr">';
                html += '<div class="pg-steps  d-none">Step 2/6</div>';
                // html += '<h6 class="full-nam2">Test Details</h6>';
                html += '<div class="row">';
                html += '<div class="col-md-6">';
                if($.inArray(drugtestTypesId,drugtestTypes)){
                // alert(drugtestTypes[drugtestTypesIds.indexOf(drugtestTypesId)]) 
                    html += '<h6 class="full-nam2 font-weight-bold">Test Details '+drugtestTypes[drugtestTypesIds.indexOf(drugtestTypesId)]+'</h6> ';
                }
                
                html += '</div>';
                html += '<div class="col-md-4 d-none">';
                html += '<label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
                html += '</div>';
                html += '</div>';
                html += '<div class="row">';
                html += '<div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+candidate_name[i].candidate_name+'" class="input-field" id="pincode" type="text">';
                html += '<span class="input-field-txt">Candidate Name</label>';
                html += '</div>'; 
                html += '</div>';
                html += '</div>';

                html += '<div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+father_name[i].father_name+'" class="input-field" id="city" type="text">';
                html += '<span class="input-field-txt">Father Name</label>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+dob[i].dob+'" class="input-field" id="dob" type="text">';
                html += '<span class="input-field-txt">Date Of Birth(DOB)</label>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                html += '<div class="row">';
                html += '<div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+mobile_number[i].mobile_number+'" class="input-field" id="mobile_number" type="text">';
                html += '<span class="input-field-txt">Phone Number</label>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-6">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea class="input-field" readonly rows="2" id="address">'+address[i].address+'</textarea>';
                html += '<span class="input-field-txt">Address</label>';
                html += '</div>';
                html += '</div>';
                html += '</div>'; 
                html += '</div>';
                html += '</div>';
                html += '</div>';
                // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+4+'\',\'Drugtest\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
                // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+4+'\',\'Drugtest\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
                if (component_status[i] == '3') {
                    html += '<div class="col-md-12">';
                     html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                    html += '<div class="input-wrap">';
                    html += '<div class="pg-frm">';
                    html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                    html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                }
                html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
                // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            }
        }else{
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<h6 class="full-nam2">Incorrect Data</h6>';
            html += '</div>';
            html += '</div>'; 
        }
    }else{
        html += '<div class="row">';
        html += '<div class="col-md-12">';
        html += '<h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '</div>';
        html += '</div>';
    }
    $('#component-detail').html(html);
    $('#componentModal').modal('show');
}

function globaldatabase(data,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#modal-headding').html(component_name)
    var insuff_remarks = '';
    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-danger">Wrong<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
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
        html += '               <h6 class="full-nam2 font-weight-bold">Global Database Details</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.candidate_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Candidate Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '</div>';

        // html += '               <div class="pg-frm">';
        // html += '                  <label>Candidate Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        // html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.father_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Father Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
         html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.dob+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Date Of Birth(DOB)</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Date Of Birth(DOB)</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.dob+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
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
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}

function current_employment(data,component_name){
    // console.log("current_employment: "+JSON.stringify(data))
    $('#modal-headding').html(component_name);
    let html='';
    // alert(data.component_data.length)
    if(data.status != '0'){
        var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';
                var insuff_remarks = '';
 
                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled' 
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-danger">Wrong<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

        html += '<div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">'; 
         html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 d-none">Current Employment Details</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">'; 
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.desigination+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Designation</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Designation</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.desigination+'" class="fld form-control" id="designation" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.department+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Department</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Department</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.department+'"  class="fld form-control" id="department" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.employee_id+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Employee ID</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Employee ID</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.employee_id+'"  class="fld form-control" id="employee_id" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.company_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Company Name</span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

         html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.company_url+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Company Website</span>';
        html += '</div>';
        html += '</div>';
        html += '            </div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Company Name</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.company_name+'" class="fld form-control" id="company-name" type="text">';
        // html += '               </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<textarea readonly="" class="input-field" id="address" type="text">'+data.component_data.address+'</textarea>';
        // html += '<input readonly value="'+data.component_data.company_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Address</span>';
        html += '</div>';
        html += '</div>';
        // html += '                <div class="pg-frm">';
        // html += '                   <label>Address</label>';
        // html += '                   <textarea readonly="" class="add" id="address" type="text">'+data.component_data.address+'</textarea>';
        // html += '                </div>';
        html += '             </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.annual_ctc+'" class="input-field" id="pincode" type="text">';
        // html += '<input readonly value="'+data.component_data.company_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Annual CTC</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Annual CTC</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.annual_ctc+'" class="fld" id="annual-ctc" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-8">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.reason_for_leaving+'" class="input-field" id="pincode" type="text">';
        // html += '<input readonly value="'+data.component_data.company_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Reason For Leaving</span>';
        html += '</div>';
        html += '</div>';
        // html += '                <div class="pg-frm">';
        // html += '                   <label>Reason For Leaving</label>';
        // html += '                   <input name="" readonly="" value="'+data.component_data.reason_for_leaving+'" class="fld" id="reasion"  type="text">';
        // html += '                </div>';
        html += '             </div>';
        html += '         </div>';
        /*html += '         <div class="row">';
        html += '             <div class="col-md-5">';
        html += '                <div class="pg-frm-hd">Joining Date</div>';
        html += '             </div>';
        html += '             <div class="col-md-4">';
        html += '                <div class="pg-frm-hd">relieving date</div>';
        html += '             </div>';
        html += '         </div>';*/
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.joining_date+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Joining Date</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '               <label>Joining Date</label>';
        // html += '                <input name="" readonly="" value="'+data.component_data.joining_date+'"  class="fld form-control mdate" id="joining-date" type="text">';
         
        // html += '            </div>';
        html += '            </div>';
        html += '            <div class="col-md-1">'; 
        html += '           </div>';
        html += '           <div class="col-md-3">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.relieving_date+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Relieving Date</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '            <label>Relieving Date</label>';
        // html += '                <input name="" readonly="" value="'+data.component_data.relieving_date+'"  class="fld form-control mdate" id="relieving-date" type="text">';
         
        // html += '         </div>';
        html += '         </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.reporting_manager_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Reporting Manager Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Reporting Manager Name</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_name+'"  class="fld form-control" id="reporting-manager-name" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.reporting_manager_desigination+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Reporting Manager Designation</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Reporting Manager Designation</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_desigination+'"  class="fld form-control" id="reporting-manager-designation" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.reporting_manager_contact_number+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Reporting Manager Contact Number</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Reporting Manager Contact Number</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_contact_number+'"  class="fld form-control" id="reporting-manager-contact" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.reporting_manager_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">HR Contact Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>HR Contact Name</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_name+'"  class="fld form-control" id="hr-name" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
         html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.reporting_manager_contact_number+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">HR Contact Number</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>HR Contact Number</label>';
        // html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_contact_number+'"  class="fld form-control" id="hr-contact" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';

        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-6">';
        html += '               <div class="pg-frm-hd">Appointment Letter</div>';
            if(data.component_data.appointment_letter != null && data.component_data.appointment_letter != ''){
                    var appointment_letter = data.component_data.appointment_letter;
                    var appointment_letter = appointment_letter.split(",");
                    for (var i = 0; i < appointment_letter.length; i++) {
                        var url = img_base_url+"../uploads/appointment_letter/"+appointment_letter[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(appointment_letter[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+appointment_letter[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+appointment_letter[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(appointment_letter[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+appointment_letter[i]+'</li>'
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
        html += '            <div class="col-md-6">';
        html += '               <div class="pg-frm-hd">Experience Relieving Letter</div>';
         if(data.component_data.experience_relieving_letter != null && data.component_data.experience_relieving_letter != ''){
                    var experience_relieving_letter = data.component_data.experience_relieving_letter;
                    var experience_relieving_letter = experience_relieving_letter.split(",");
                    for (var k = 0; k < experience_relieving_letter.length; k++) {
                        var url = img_base_url+"../uploads/experience_relieving_letter/"+experience_relieving_letter[k]
                        if ((/\.(jpg|jpeg|png)$/i).test(experience_relieving_letter[k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+experience_relieving_letter[k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+experience_relieving_letter[k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(experience_relieving_letter[k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+experience_relieving_letter[k]+'</li>'
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
        html += '            <div class="col-md-6 mt-3">';
        html += '               <div class="pg-frm-hd">Pay Slip</div>';
         if( data.component_data.last_month_pay_slip != null && data.component_data.last_month_pay_slip != ''){
                    var last_month_pay_slip = data.component_data.last_month_pay_slip;
                    var last_month_pay_slip = last_month_pay_slip.split(",");
                    for (var k = 0; k < last_month_pay_slip.length; k++) {
                        var url = img_base_url+"../uploads/last_month_pay_slip/"+last_month_pay_slip[k]
                        if ((/\.(jpg|jpeg|png)$/i).test(last_month_pay_slip[k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+last_month_pay_slip[k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+last_month_pay_slip[k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(last_month_pay_slip[k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0  text-wrap">'+last_month_pay_slip[k]+'</li>'
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
        html += '            <div class="col-md-6 mt-3">';
        html += '               <div class="pg-frm-hd">Resignation Acceptance Letter/ Mail</div>';
         if(data.component_data.ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance != null && data.component_data.ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance != ''){
                    var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = data.component_data.ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance;
                    var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance.split(",");
                    for (var k = 0; k < ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance.length; k++) {
                        var url = img_base_url+"../uploads/bank_statement_resigngation_acceptance/"+ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k]
                        if ((/\.(jpg|jpeg|png)$/i).test(ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k]+'</li>'
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
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+6+'\',\'Current employment\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+6+'\',\'Current employment\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        html += '   <hr>';
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.Insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
        
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
        }
    html += '      </div>';
    html += '   </div>'; 

    $('#component-detail').html(html);
    $('#componentModal').modal('show');
}

function education_details(data,component_name){ 
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
        var insuff_remarks = '';
        var component_status = data.component_data.analyst_status.split(',')
        // if(data.component_data.year_of_passing != null || data.component_data.year_of_passing != ''){
        //  var year_of_passing = JSON.parse(data.component_data.year_of_passing)
        // }

        if(type_of_degree.length > 0){
            var j=1;
              var all_sem_marksheet = JSON.parse(data.component_data.all_sem_marksheet); 
              var convocation = JSON.parse(data.component_data.convocation);
              var marksheet_provisional_certificate = JSON.parse(data.component_data.marksheet_provisional_certificate);
              var ten_twelve_mark_card_certificate = JSON.parse(data.component_data.ten_twelve_mark_card_certificate);


            for (var i = 0; i < type_of_degree.length; i++) {
                // alert(type_of_degree[i].type_of_degree)
                
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
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (component_status[i] == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (component_status[i] == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (component_status[i] == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-danger">Wrong<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }

                html += '<div class="pg-cnt pl-0 pt-0">';
                html += '      <div class="pg-txt-cntr">';
                html += '         <div class="pg-steps d-none">Step 3/6</div>';
                html += '         <div class="row">';
                html += '            <div class="col-md-6">';
                html += '               <h6 class="full-nam2 font-weight-bold">Educational Details '+(j++)+' <span class="high"></span></h6>';
                html += '            </div>';
                html += '            <div class="col-md-4 d-none">';
                html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
                html += '            </div>';
                html += '         </div>'; 
                html += '         <div class="row">';
                html += '            <div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input name="" readonly value = "'+type_of_degree[i].type_of_degree+'" class="input-field" type="text">';
                html += '<span class="input-field-txt">Type of Degree</span>';
                html += '</div>';
                html += '</div>';
                // html += '               <div class="pg-frm">';
                // html += '                  <label>Type of Degree</label>';
                // html += '                  <input name="" readonly value = "'+type_of_degree[i].type_of_degree+'" class="fld form-control type_of_degree" type="text">';
                // html += '               </div>';
                html += '            </div>';
                html += '            <div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input name="" readonly  value = "'+major[i].major+'" class="input-field" type="text">';
                html += '<span class="input-field-txt">Major</span>';
                html += '</div>';
                html += '</div>';
                // html += '               <div class="pg-frm">';
                // html += '                  <label>Major</label>';
                // html += '                  <input name="" readonly   value = "'+major[i].major+'" class="fld form-control major" type="text">';
                // html += '               </div>';
                html += '            </div>';
                html += '            <div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input name="" readonly  value = "'+university_board[i].university_board+'" class="input-field" type="text">';
                html += '<span class="input-field-txt">University</span>';
                html += '</div>';
                html += '</div>';
                // html += '               <div class="pg-frm">';
                // html += '                  <label>University</label>';
                // html += '                  <input name="" readonly  value = "'+university_board[i].university_board+'" class="fld form-control university" type="text">';
                // html += '               </div>';
                html += '            </div>';
                html += '         </div>';
                html += '         <div class="row">';
                html += '            <div class="col-md-4">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input class="input-field" readonly rows="4" id="address" value="'+college_school[i].college_school+'">';
                html += '<span class="input-field-txt">College Name</span>';
                html += '</div>';
                html += '</div>';
                // html += '               <div class="pg-frm">';
                // html += '                  <label>College Name</label>';
                // html += '                  <input name="" readonly  value = "'+college_school[i].college_school+'" class="fld form-control college_name" type="text">';
                // html += '               </div>';
                html += '            </div>';
                html += '            <div class="col-md-8">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea class="input-field" readonly rows="4" id="address">'+address_of_college_school[i].address_of_college_school+'</textarea>';
                html += '<span class="input-field-txt">Address</span>';
                html += '</div>';
                html += '</div>';
                // html += '               <div class="pg-frm">';
                // html += '                  <label>Address</label>';
                // html += '                  <textarea readonly  class="add form-control address"  type="text">'+address_of_college_school[i].address_of_college_school+'</textarea>';
                // html += '               </div>';
                 $start ='';
                if (course_start_date.length > 0) {
                    $start = course_start_date[i].course_start_date;
                }
                $end ='';
                if (course_end_date.length > 0) {
                    $end = course_end_date[i].course_end_date;
                }
                html += '            </div>';
                html += '         </div>';
                html += '         <div class="pg-frm-hd">Duration Of Course</div>';
                html += '         <div class="row">';
                html += '            <div class="col-md-3">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input name=""readonly  class="input-field" value = "'+$start+'" id="duration_of_stay" type="text">';
                html += '<span class="input-field-txt">From</span>';
                html += '</div>';
                html += '</div>';
                // html += '                <div class="pg-frm">';
                // html += '                  <!-- <label>College Name</label> -->';
                // html += '                  <input name=""readonly   class="fld form-control start-date" value = "'+course_start_date[i].course_start_date+'" id="duration_of_stay" type="text">';
                // html += '               </div>';
                 
                html += '            </div>';
                html += '<div class="col-md-3">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input name=""readonly class="input-field" value = "'+$end+'" id="duration_of_stay" type="text">';
                html += '<span class="input-field-txt">To</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '         <div class="col-md-6 tp">'; 
                html += '         <div class="pg-frm-hd">Course Full / Part Time :</div>';
                html += '            <div class=" mrg-btm">';
                $corse = 'full_time';
                if (type_of_course.length > 0) {
                    $corse = type_of_course[i].type_of_course;
                }

                if($corse == 'part_time') {
                // html += '               <input type="radio" checked class="custom-control-input part_time" name="customRadio" id="customRadio1">';
                html += '               <span class="">Part Time</span>';
                }else if($corse == 'full_time') {
                // html += '               <input type="radio" checked class="custom-control-input part_time" name="customRadio" id="customRadio2">';
                html += '               <span class="">Full Time</span>';
                }
                html += '            </div>';
                html += '         </div>';
                
                
                html += '         </div>';
                html += '         <div class="row">';
                html += '            <div class="col-md-4">';
                 html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input name=""readonly class="input-field" value = "'+registration_roll_number[i].registration_roll_number+'" id="duration_of_stay" type="text">';
                html += '<span class="input-field-txt">Registration / Roll Number</span>';
                html += '</div>';
                html += '</div>';
                // html += '               <div class="pg-frm">';
                // html += '                  <label>Registration / Roll Number</label>';
                // html += '                  <input name="" readonly  class="fld registration_roll_number" value = "'+registration_roll_number[i].registration_roll_number+'" type="text">';
                // html += '               </div>';
                html += '            </div>';
                html += '         </div>';
                 
              
        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-6">';
        html += '               <div class="pg-frm-hd">All Sem Marksheet</div>';
        // alert(all_sem_marksheet[i])

       
            if(all_sem_marksheet[i] != "no-file" && all_sem_marksheet[i] != null && all_sem_marksheet[i] != '' && all_sem_marksheet[i].length > 0){
                    // var allSemMarksheetDoc = data.component_data.all_sem_marksheet;
                    // var allSemMarksheetDoc = allSemMarksheetDoc.split(",");
                    for (var k = 0; k < all_sem_marksheet[i].length; k++) {
                        var url = img_base_url+"../uploads/all-marksheet-docs/"+all_sem_marksheet[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(all_sem_marksheet[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+all_sem_marksheet[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+all_sem_marksheet[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(all_sem_marksheet[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+all_sem_marksheet[i][k]+'</li>'
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

        /* new images */


        html += '            <div class="col-md-6">';
        html += '               <div class="pg-frm-hd">Degree Convocation/ Transcript of Records</div>';
         if(convocation[i] != "no-file"  && convocation[i] != null && convocation[i] != ''){
                    // var convocation = [k]data.component_data.convocation;
                    // var convocation = [k]convocation.sp[k]lit(",");
                    for (var k = 0; k < convocation[i].length; k++) {
                        var url = img_base_url+"../uploads/convocation-docs/"+convocation[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(convocation[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocation[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+convocation[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(convocation[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocation[i][k]+'</li>'
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



        html += '<div class="col-md-6 mt-3">';
        html += '<div class="pg-frm-hd">Consolidate Marksheet/ Provisional Degree Certificate</div>'; 
         if(marksheet_provisional_certificate[i] != "undefined" && marksheet_provisional_certificate[i] != "no-file" && marksheet_provisional_certificate[i] != null && marksheet_provisional_certificate[i] != ''){
                    // var marksheet_provisional_certificate = [k]data.component_data.marksheet_provisional_certificate;
                    // var marksheet_provisional_certificate = [k]marksheet_provisional_certificate.sp[k]lit(",");
                    for (var k = 0; k < marksheet_provisional_certificate[i].length; k++) {
                        var url = img_base_url+"../uploads/marksheet-certi-docs/"+marksheet_provisional_certificate[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(marksheet_provisional_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+marksheet_provisional_certificate[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+marksheet_provisional_certificate[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(marksheet_provisional_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0  text-wrap">'+marksheet_provisional_certificate[i][k]+'</li>'
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
       

         html += '            <div class="col-md-6 mt-3">';
        html += '               <div class="pg-frm-hd">10th / 12th mark card/ Course Completion Certificate <span>(optional)</span></div>';
         if(ten_twelve_mark_card_certificate[i] != "no-file"  && ten_twelve_mark_card_certificate[i] != null && ten_twelve_mark_card_certificate[i] != ''){
                    // var ten_twelve_mark_card_certificate = [k]data.component_data.ten_twelve_mark_card_certificate;
                    // var ten_twelve_mark_card_certificate = [k]ten_twelve_mark_card_certificate.sp[k]lit(",");
                    for (var k = 0; k < ten_twelve_mark_card_certificate[i].length; k++) {
                        var url = img_base_url+"../uploads/ten-twelve-docs/"+ten_twelve_mark_card_certificate[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(ten_twelve_mark_card_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificate[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+ten_twelve_mark_card_certificate[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(ten_twelve_mark_card_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificate[i][k]+'</li>'
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



        /*end row*/
        html += '            </div>';

        /*end hr*/
                // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+7+'\',\'Education\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
                // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+7+'\',\'Education\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
                html += '      </div>';
                html += '   </div>';

                 if (component_status[i] == '3') {
                html += '<div class="col-md-12">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            
            }
           
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');


        // html += '         <div class="row mt-3">';
      /*  html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">all sem marksheet</div>';
            if(data.component_data.all_sem_marksheet != null || data.component_data.all_sem_marksheet != ''){
                    var allSemMarksheetDoc = data.component_data.all_sem_marksheet;
                    var allSemMarksheetDoc = allSemMarksheetDoc.split(",");
                    for (var i = 0; i < allSemMarksheetDoc.length; i++) {
                        var url = img_base_url+"../uploads/all-marksheet-docs/"+allSemMarksheetDoc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(allSemMarksheetDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+allSemMarksheetDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+allSemMarksheetDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(allSemMarksheetDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+allSemMarksheetDoc[i]+'</li>'
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
                        
        html += '            </div>';*/



       /* html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">degree convocation/ transcript of records</div>';
         if(data.component_data.convocation != null || data.component_data.convocation != ''){
                    var convocation = [k]data.component_data.convocation;
                    var convocation = [k]convocation.sp[k]lit(",");
                    for (var i = 0; i < convocation.le[k]ngth; i++) {
                        var url = img_base_url+"../uploads/convocation-docs/"+convocation[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(convocation[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocation[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+convocation[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(convocation[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocation[i][k]+'</li>'
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
        html += '            </div>';*/

    /*
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">consolidate marksheet/ provisional degree certificate</div>';
         if(data.component_data.marksheet_provisional_certificate != null || data.component_data.marksheet_provisional_certificate != ''){
                    var marksheet_provisional_certificate = [k]data.component_data.marksheet_provisional_certificate;
                    var marksheet_provisional_certificate = [k]marksheet_provisional_certificate.sp[k]lit(",");
                    for (var i = 0; i < marksheet_provisional_certificate.le[k]ngth; i++) {
                        var url = img_base_url+"../uploads/marksheet-certi-docs/"+marksheet_provisional_certificate[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(marksheet_provisional_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+marksheet_provisional_certificate[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+marksheet_provisional_certificate[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(marksheet_provisional_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0  text-wrap">'+marksheet_provisional_certificate[i][k]+'</li>'
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
        html += '            </div>';*/


       /* html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">10th / 12th mark card/ course completion certificate <span>(optional)</span></div>';
         if(data.component_data.ten_twelve_mark_card_certificate != null || data.component_data.ten_twelve_mark_card_certificate != ''){
                    var ten_twelve_mark_card_certificate = [k]data.component_data.ten_twelve_mark_card_certificate;
                    var ten_twelve_mark_card_certificate = [k]ten_twelve_mark_card_certificate.sp[k]lit(",");
                    for (var i = 0; i < ten_twelve_mark_card_certificate.le[k]ngth; i++) {
                        var url = img_base_url+"../uploads/ten-twelve-docs/"+ten_twelve_mark_card_certificate[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(ten_twelve_mark_card_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificate[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+ten_twelve_mark_card_certificate[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(ten_twelve_mark_card_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificate[i][k]+'</li>'
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
        html += '            </div>';*/
        // html += '         </div>';

        }else{
            html += '         <div class="row">';
            html += '            <div class="col-md-12">';
            html += '               <h6 class="full-nam2">Incorrect Data</h6>';
            html += '            </div>';
            html += '         </div>'; 
        }

    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }

    $('#component-detail').html(html);
}

function present_address(data,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    
    let html ='';
    if(data.status > 0){

        var form_status = '';
        var insuffDisable = '';
        var approvDisable = '';
        var rightClass = '';

        if (data.component_data.analyst_status == '0') {
                             
            form_status = '<span class="text-warning">Pending<span>'; 
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gy'
        }else if (data.component_data.analyst_status == '1') {
                             
            form_status = '<span class="text-info">Form Filled<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            rightClass ='bac-gr'
        }else if (data.component_data.analyst_status == '2') {
                             
            form_status = '<span class="text-success">Completed<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gr'
        }else if (data.component_data.analyst_status == '3') {
                             
            form_status = '<span class="text-danger">Insufficiency<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
        }else if (data.component_data.analyst_status == '4') {
                           
            form_status = '<span class="text-success">Verified Clear<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gr'
        }else{

            form_status = '<span class="text-danger">Wrong<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gy'
        }

        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps d-none">Step 2/6</div>'; 
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2">Present Address</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <label class="font-weight-bold d-none">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.flat_no+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">House/Flat No.</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>House/Flat No.</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.flat_no+'" class="fld form-control" id="house-flat" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.street+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Street/Road</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Street/Road</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.street+'" class="fld form-control" id="street" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.area+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Area</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Area</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.area+'" class="fld form-control" id="area" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.city+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">City/Town</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>City/Town</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.city+'" class="fld form-control" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.pin_code+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Pincode</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Pin Code</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.pin_code+'" class="fld form-control" id="pincode" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.nearest_landmark+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Nearest Landmark</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Nearest Landmark</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.nearest_landmark+'" class="fld form-control" id="land-mark" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="pg-frm-hd">Duration Of Stay</div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.duration_of_stay_start+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">From</span>';
        html += '</div>';
        html += '</div>';
        // html += '                <div><label>Start Date</label></div>';
        // html += '                <input name="" readonly value="'+data.component_data.duration_of_stay_start+'" class="fld form-control end-date" id="start-date" type="text">';
        html += '            </div>'; 
        // html += '            <h6 class="To">TO</h6>';
        html += '           <div class="col-md-3">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.duration_of_stay_end+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">To</span>';
        html += '</div>';
        html += '</div>';
        // html += '            <div><label>End Date</label></div>';
        // html += '             <input name="" readonly value="'+data.component_data.duration_of_stay_end+'" class="fld form-control end-date" id="end-date" type="text">';
         
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
        html += '         <div class="pg-frm-hd">Contact Person</div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.contact_person_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.contact_person_name+'" class="fld form-control" id="name" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.contact_person_relationship+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Relationship</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Relationship</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.contact_person_relationship+'" class="fld form-control" id="relationship" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.contact_person_mobile_number+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Mobile Number</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Mobile Number</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.contact_person_mobile_number+'" class="fld form-control" id="contact_no" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        // html += '   <button class="insuf-btn">Insufficiency</button>';
        // html += '   <button class="app-btn"><i class="fa fa-check bac-gr"></i> Approve</button>';
        // html += '   <hr>';
         
        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>';
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
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+rental_agreementDoc[i]+'" class="image-name-delete-a">';
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
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Ration Card</div>';
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
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+ration_cardDoc[i]+'" class="image-name-delete-a">';
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
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Government Utility Bill</div>';
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
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+gov_utility_billDoc[i]+'" class="image-name-delete-a">';
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
                       
        html += '            </div>';
        html += '         </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+8+'\',\'Present Address\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+8+'\',\'Present Address\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        html += '   <hr>';
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
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
        html += '      </div>';
        html += '   </div>';

    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }
    $('#component-detail').html(html);
}

function permanent_address(data,component_name){ 
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    let html ='';
    if(data.status > 0){

        var form_status = '';
        var insuffDisable = '';
        var approvDisable = '';
        var rightClass = '';

        if (data.component_data.analyst_status == '0') {
                             
            form_status = '<span class="text-warning">Pending<span>'; 
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gy'
        }else if (data.component_data.analyst_status == '1') {
                             
            form_status = '<span class="text-info">Form Filled<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            rightClass ='bac-gr'
        }else if (data.component_data.analyst_status == '2') {
                             
            form_status = '<span class="text-success">Completed<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gr'
        }else if (data.component_data.analyst_status == '3') {
                             
            form_status = '<span class="text-danger">Insufficiency<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
        }else if (data.component_data.analyst_status == '4') {
                           
            form_status = '<span class="text-success">Verified Clear<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gr'
        }else{

            form_status = '<span class="text-danger">Wrong<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gy'
        }

        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Permanent address</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2">Permanent address</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.flat_no+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">House/Flat No.</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>House/Flat No.</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.flat_no+'" class="fld form-control" id="house-flat" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.street+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Street/Road</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Street/Road</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.street+'" class="fld form-control" id="street" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.area+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Area</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Area</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.area+'" class="fld form-control" id="area" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.city+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">City/Town</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>City/Town</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.city+'" class="fld form-control" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.pin_code+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Pincode</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Pin Code</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.pin_code+'" class="fld form-control" id="pincode" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.nearest_landmark+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Nearest Landmark</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Nearest Landmark</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.nearest_landmark+'" class="fld form-control" id="land-mark" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="pg-frm-hd">Duration Of Stay</div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.duration_of_stay_start+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">From</span>';
        html += '</div>';
        html += '</div>';
        // html += '                <div><label>Start Date</label></div>';
        // html += '                <input name="" readonly value="'+data.component_data.duration_of_stay_start+'" class="fld form-control end-date" id="start-date" type="text">';
        html += '            </div>'; 
        // html += '            <h6 class="To">TO</h6>';
        html += '           <div class="col-md-3">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.duration_of_stay_end+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">To</span>';
        html += '</div>';
        html += '</div>';
        // html += '            <div><label>End Date</label></div>';
        // html += '             <input name="" readonly value="'+data.component_data.duration_of_stay_end+'" class="fld form-control end-date" id="end-date" type="text">';
         
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
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.contact_person_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.contact_person_name+'" class="fld form-control" id="name" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.contact_person_relationship+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Relationship</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Relationship</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.contact_person_relationship+'" class="fld form-control" id="relationship" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.contact_person_mobile_number+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Mobile Number</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Mobile Number</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.contact_person_mobile_number+'" class="fld form-control" id="contact_no" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        // html += '   <button class="insuf-btn">Insufficiency</button>';
        // html += '   <button class="app-btn"><i class="fa fa-check bac-gr"></i> Approve</button>';
        html += '   <hr>';
         
        html += '         <div class="row mt-3">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>';
                            // for loop will start 
                if(data.component_data.rental_agreement != null || data.component_data.rental_agreement != ''){
                    var reantAgreementDoc = data.component_data.rental_agreement;
                    var reantAgreementDoc = reantAgreementDoc.split(",");
                    for (var i = 0; i < reantAgreementDoc.length; i++) {
                        var url = img_base_url+"../uploads/rental-docs/"+reantAgreementDoc[i];
                        if ((/\.(jpg|jpeg|png)$/i).test(reantAgreementDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+reantAgreementDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+reantAgreementDoc[i]+'" class="image-name-delete-a">';
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
                        // for loop will end 
            
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Upload Ration Card <span>(optional)</span></div>';
             
                            // for loop will start 
            if(data.component_data.ration_card != null || data.component_data.ration_card != ''){
                    var rationCardDoc = data.component_data.ration_card;
                    var rationCardDoc = rationCardDoc.split(",");
                    for (var i = 0; i < rationCardDoc.length; i++) {
                        var url = img_base_url+"../uploads/ration-docs/"+rationCardDoc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(rationCardDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+rationCardDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+rationCardDoc[i]+'" class="image-name-delete-a">';
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
                        // for loop will end    ration_card
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Upload Government Utility Bill <span>(optional)</span></div>';
             
                if(data.component_data.gov_utility_bill != null || data.component_data.gov_utility_bill != ''){
                    var govUtilityBillDoc = data.component_data.gov_utility_bill;
                    var govUtilityBillDoc = govUtilityBillDoc.split(",");
                    for (var i = 0; i < govUtilityBillDoc.length; i++) {
                        var url = img_base_url+"../uploads/gov-docs/"+govUtilityBillDoc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(govUtilityBillDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+govUtilityBillDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+govUtilityBillDoc[i]+'" class="image-name-delete-a">';
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
                    // for loop will end  gov_utility_bill      
            html += '            </div>';
        html += '         </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+9+'\',\'Permanent Address\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+9+'\',\'Permanent Address\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        html += '   <hr>';
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
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
        html += '      </div>';
        html += '   </div>';

    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }
    $('#component-detail').html(html);
}

function previous_employment(data,component_name){
    // console.log("current_employment: "+JSON.stringify(data))
    $('#componentModal').modal('show')
    // $('#modal-headding').html(component_name)
    $('#modal-headding').html(component_name)
    var desigination =  JSON.parse(data.component_data.desigination)
    var department =  JSON.parse(data.component_data.department)
    var employee_id =  JSON.parse(data.component_data.employee_id)
    var company_name =  JSON.parse(data.component_data.company_name)
    var address =  JSON.parse(data.component_data.address)
    var annual_ctc =  JSON.parse(data.component_data.annual_ctc)
    var reason_for_leaving =  JSON.parse(data.component_data.reason_for_leaving)
    var joining_date =  JSON.parse(data.component_data.joining_date)
    var relieving_date =  JSON.parse(data.component_data.relieving_date)
    var reporting_manager_name =  JSON.parse(data.component_data.reporting_manager_name)
    var reporting_manager_desigination =  JSON.parse(data.component_data.reporting_manager_desigination)
    var reporting_manager_contact_number =  JSON.parse(data.component_data.reporting_manager_contact_number)
    var hr_name =  JSON.parse(data.component_data.hr_name)
    var hr_contact_number =  JSON.parse(data.component_data.hr_contact_number)
    var component_status = data.component_data.analyst_status.split(',')
    // alert(data.component_data.appointment_letter)
    var appointment_letter = JSON.parse(data.component_data.appointment_letter);
    var experience_relieving_letter = JSON.parse(data.component_data.experience_relieving_letter);
    var last_month_pay_slip = JSON.parse(data.component_data.last_month_pay_slip);
    var company_url = JSON.parse(data.component_data.company_url);
    var bank_statement_resigngation_acceptance = JSON.parse(data.component_data.bank_statement_resigngation_acceptance);
    // console.log(data.component_data);
    var insuff_remarks = '';

    let html='';
    var j = 1;
    for(var i=0;i<desigination.length;i++){
        // alert(i)
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
            fontAwsom = '<i class="fa fa-check"></i>'
            rightClass ='bac-gr'
        }else if (component_status[i] == '2') {
                             
            form_status = '<span class="text-success">Completed<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gr'

        }else if (component_status[i] == '3') {
                             
            form_status = '<span class="text-danger">Insufficiency<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            insuff_remarks = JSON.parse(data.component_data.Insuff_remarks);
        }else if (component_status[i] == '4') {
            
            form_status = '<span class="text-success">Verified Clear<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gr'
        
        }else{

            form_status = '<span class="text-danger">Wrong<span>';
            fontAwsom = '<i class="fa fa-check"></i>'
            insuffDisable = 'disabled'
            approvDisable = 'disabled'
            rightClass ='bac-gy'
        }

        html += '<div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">'; 
        // html += '         <h4 class="full-nam2">Previous Employment '+(j++)+'</h4>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2">Previous Employment '+(j++)+'</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+desigination[i].desigination+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Designation</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Designation</label>';
        // html += '                  <input name="" readonly="" value="'+desigination[i].desigination+'" class="fld form-control" id="designation" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+department[i].department+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Department</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Department</label>';
        // html += '                  <input name="" readonly="" value="'+department[i].department+'"  class="fld form-control" id="department" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+employee_id[i].employee_id+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Employee ID</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Employee ID</label>';
        // html += '                  <input name="" readonly="" value="'+employee_id[i].employee_id+'"  class="fld form-control" id="employee_id" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+company_name[i].company_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Company Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Company Name</label>';
        // html += '                  <input name="" readonly="" value="'+company_name[i].company_name+'" class="fld form-control" id="company-name" type="text">';
        // html += '               </div>';
        html += '            </div>';

        var urls = '';
        if (company_url !='' && company_url !=null && company_url !='undefined' && company_url !='[]') {
            urls = company_url[i].company_url;
        }

         html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+urls+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Company Website</span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '            <div class="col-md-8">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<textarea readonly="" class="input-field" id="address" type="text">'+address[i].address+'</textarea>';
        html += '<span class="input-field-txt">Address</span>';
        html += '</div>';
        html += '</div>';
        // html += '                <div class="pg-frm">';
        // html += '                   <label>Address</label>';
        // html += '                   <textarea readonly="" class="add" id="address" type="text">'+address[i].address+'</textarea>';
        // html += '                </div>';
        html += '             </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+annual_ctc[i].annual_ctc+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Annual CTC</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Annual CTC</label>';
        // html += '                  <input name="" readonly="" value="'+annual_ctc[i].annual_ctc+'" class="fld" id="annual-ctc" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-8">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+reason_for_leaving[i].reason_for_leaving+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Reason For Leaving</span>';
        html += '</div>';
        html += '</div>';
        // html += '                <div class="pg-frm">';
        // html += '                   <label>Reason For Leaving</label>';
        // html += '                   <input name="" readonly="" value="'+reason_for_leaving[i].reason_for_leaving+'" class="fld" id="reasion"  type="text">';
        // html += '                </div>';
        html += '             </div>';
        html += '         </div>';
        /*html += '         <div class="row">';
        html += '             <div class="col-md-5">';
        html += '                <div class="pg-frm-hd">Joining Date</div>';
        html += '             </div>';
        html += '             <div class="col-md-4">';
        html += '                <div class="pg-frm-hd">relieving date</div>';
        html += '             </div>';
        html += '         </div>';*/
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+joining_date[i].joining_date+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Joining Date</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '               <label>Joining Date</label>';
        // html += '                <input name="" readonly="" value="'+joining_date[i].joining_date+'"  class="fld form-control mdate" id="joining-date" type="text">';
         
        // html += '            </div>';
        html += '            </div>';
        html += '            <div class="col-md-1">'; 
        html += '           </div>';
        html += '           <div class="col-md-3">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+relieving_date[i].relieving_date+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Relieving Date</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '            <label>Relieving Date</label>';
        // html += '                <input name="" readonly="" value="'+relieving_date[i].relieving_date+'"  class="fld form-control mdate" id="relieving-date" type="text">';
         
        // html += '         </div>';
        html += '         </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+reporting_manager_name[i].reporting_manager_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Reporting Manager Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Reporting Manager Name</label>';
        // html += '                  <input name="" readonly="" value="'+reporting_manager_name[i].reporting_manager_name+'"  class="fld form-control" id="reporting-manager-name" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+reporting_manager_desigination[i].reporting_manager_desigination+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Reporting Manager Designation</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Reporting Manager Designation</label>';
        // html += '                  <input name="" readonly="" value="'+reporting_manager_desigination[i].reporting_manager_desigination+'"  class="fld form-control" id="reporting-manager-designation" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+reporting_manager_contact_number[i].reporting_manager_contact_number+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Reporting Manager Contact Number</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Reporting Manager Contact Number</label>';
        // html += '                  <input name="" readonly="" value="'+reporting_manager_contact_number[i].reporting_manager_contact_number+'"  class="fld form-control" id="reporting-manager-contact" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+hr_name[i].hr_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">HR Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>HR Contact Name</label>';
        // html += '                  <input name="" readonly="" value="'+hr_name[i].hr_name+'"  class="fld form-control" id="hr-name" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+hr_contact_number[i].hr_contact_number+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">HR Contact Number</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>HR Contact Number</label>';
        // html += '                  <input name="" readonly="" value="'+hr_contact_number[i].hr_contact_number+'"  class="fld form-control" id="hr-contact" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '         </div>';
     
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+10+'\',\'previous employment\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+10+'\',\'previous employment\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
      

          html += '         <div class="row mt-3">';
        html += '            <div class="col-md-6">';
        html += '               <div class="pg-frm-hd">Appointment Letter</div>'; 
            if(appointment_letter[i] != null || appointment_letter[i] != ''){
                    // var appointment_letter = data[k].component_data.appointment_letter;
                    // var appointment_letter = appointment_letter[k].split("[k],");
                    for (var k = 0; k < appointment_letter[i].length; k++) {
                        var url = img_base_url+"../uploads/appointment_letter/"+appointment_letter[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(appointment_letter[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+appointment_letter[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+appointment_letter[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(appointment_letter[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+appointment_letter[i][k]+'</li>'
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
        html += '            <div class="col-md-6">';
        html += '               <div class="pg-frm-hd">Experience Relieving Letter</div>';
            if(experience_relieving_letter[i] != null || experience_relieving_letter[i] != ''){
                    // var experience_relieving_letter = data[k].component_data.experience_relieving_letter;
                    // var experience_relieving_letter = experience_relieving_letter[k].split(",");
                    for (var k = 0; k < experience_relieving_letter[i].length; k++) {
                        var url = img_base_url+"../uploads/experience_relieving_letter/"+experience_relieving_letter[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(experience_relieving_letter[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+experience_relieving_letter[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+experience_relieving_letter[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(experience_relieving_letter[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+experience_relieving_letter[i][k]+'</li>'
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
        html += '            <div class="col-md-6 mt-3">';
        html += '               <div class="pg-frm-hd">Pay Slip</div>';
            if(last_month_pay_slip[i] != null || last_month_pay_slip[i]  != ''){
                    // var last_month_pay_slip = data[k].component_data.last_month_pay_slip;
                    // var last_month_pay_slip = last_month_pay_slip[k].split("[k],");
                    for (var k = 0; k < last_month_pay_slip[i].length; k++) {
                        var url = img_base_url+"../uploads/last_month_pay_slip/"+last_month_pay_slip[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(last_month_pay_slip[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+last_month_pay_slip[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+last_month_pay_slip[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(last_month_pay_slip[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0  text-wrap">'+last_month_pay_slip[i][k]+'</li>'
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
        html += '            <div class="col-md-6 mt-3">';
        html += '               <div class="pg-frm-hd">Resignation Acceptance Letter/ Mail</div>'; 

        if(bank_statement_resigngation_acceptance != ''){
            
            if(bank_statement_resigngation_acceptance[i] != 'null' && bank_statement_resigngation_acceptance[i] != null && data.component_data.bank_statement_resigngation_acceptance != ''){
                    // var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = data[k].component_data.bank_statement_resigngation_acceptance;
                    // var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k].split("[k],");
                    // alert(bank_statement_resigngation_acceptance[i])
                    for (var k = 0; k < bank_statement_resigngation_acceptance[i].length; k++) {
                        var url = img_base_url+"../uploads/bank_statement_resigngation_acceptance/"+bank_statement_resigngation_acceptance[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(bank_statement_resigngation_acceptance[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+bank_statement_resigngation_acceptance[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+bank_statement_resigngation_acceptance[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(bank_statement_resigngation_acceptance[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+bank_statement_resigngation_acceptance[i][k]+'</li>'
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
        }else{
            html += '               <div class="pg-frm-hd">There is no file </div>';
        }    
        html += '            </div>';
        html += '         </div>';

        if (component_status[i] == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');


        html += '   <hr>';
         
    }
    $('#component-detail').html(html) 
}

function reference(data,component_name){
    // console.log("reference : "+JSON.stringify(data))
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

    var component_status = data.component_data.analyst_status.split(',')
    var insuff_remarks = '';

    let html='';
    if(company_name_lenght > 0 ){
        var j=1;
        for (var i = 0; i < company_name_lenght; i++) { 
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
                fontAwsom = '<i class="fa fa-check"></i>'
                rightClass ='bac-gr'
            }else if (component_status[i] == '2') {
                                 
                form_status = '<span class="text-success">Completed<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'

            }else if (component_status[i] == '3') {
                                 
                form_status = '<span class="text-danger">Insufficiency<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if (component_status[i] == '4') {
                
                form_status = '<span class="text-success">Verified Clear<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            
            }else{

                form_status = '<span class="text-danger">Wrong<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            // html += '<h6 class="full-nam2">Reference '+(j++)+'</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Reference '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4 d-none">';
            html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+name[i]+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Name</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Name</label>';
            // html += '                  <input name="" readonly value="'+name[i]+'" class="fld form-control name" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+company_name[i]+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Company Name</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Company Name</label>';
            // html += '                  <input name="" readonly value="'+company_name[i]+'" class="fld form-control company-name" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+designation[i]+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Designation</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Designation</label>';
            // html += '                  <input name="" readonly value="'+designation[i]+'" class="fld form-control designation" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+contact_number[i]+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Contact Number</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Contact Number</label>';
            // html += '                  <input name="" readonly value="'+contact_number[i]+'" class="fld form-control contact" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+email_id[i]+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Email ID</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Email ID</label>';
            // html += '                  <input name="" readonly value="'+email_id[i]+'" class="fld form-control email" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-3">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+years_of_association[i]+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Years of Association</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Years of Association</label>';
            // html += '                  <input name="" readonly value="'+years_of_association[i]+'" class="fld form-control association" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '          <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <div class="pg-frm-hd">Preferred contact time</div>';
            html += '               <div class="row">';
            html += '                  <div class="col-md-5">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+contact_start_time[i]+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">From</span>';
            html += '</div>';
            html += '</div>';
            // html += '                     <div class="pg-frm">';
            // html += '                        <input type="text" readonly value="'+contact_start_time[i]+'" class="form-control fld start-time" id="timepicker" placeholder="Start time" name="pwd" >';
            // html += '                     </div>';
            html += '                  </div>';
            html += '<div class="col-md-5">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+contact_end_time[i]+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">To</span>';
            html += '</div>';
            html += '</div>';
            // html += '                     <div class="pg-frm">';
            // html += '                        <input type="text" readonly value="'+contact_end_time[i]+'" class="form-control fld end-time" id="timepicker2" placeholder="End time" name="pwd" >';
            // html += '                     </div>';
            html += '                  </div>';
            html += '               </div>';
            html += '            </div>';
            html += '          </div>';
            html += '         </div>';
            // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+11+'\',\'Reference\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+11+'\',\'Reference\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == '3') { 
                html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';        
        }
    }

    $('#component-detail').html(html) 
}

function previous_address(data,component_name){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // alert(data.component_data.flat_no)
   
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
    var component_status = data.component_data.analyst_status.split(',')
    // var state = JSON.parse(data.component_data.state)
    // var state = JSON.parse(data.component_data.state)
    // var state = JSON.parse(data.component_data.state)
    // var state = JSON.parse(data.component_data.state)
 
    var rental_agreement = JSON.parse(data.component_data.rental_agreement);
    var ration_card = JSON.parse(data.component_data.ration_card);
    var gov_utility_bill = JSON.parse(data.component_data.gov_utility_bill);
    var insuff_remarks = '';

    let html ='';
    var j = 1;
    if(data.status > 0){
        for (var i = 0; i < state.length; i++) {   

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
                fontAwsom = '<i class="fa fa-check"></i>'
                rightClass ='bac-gr'
            }else if (component_status[i] == '2') {
                                 
                form_status = '<span class="text-success">Completed<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'

            }else if (component_status[i] == '3') {
                                 
                form_status = '<span class="text-danger">Insufficiency<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if (component_status[i] == '4') {
                
                form_status = '<span class="text-success">Verified Clear<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            
            }else{

                form_status = '<span class="text-danger">Wrong<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }

            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '      <div class="pg-txt-cntr">';
            html += '         <div class="pg-steps d-none">Step 2/6</div>';
            html += '         <h6 class="full-nam2">Details</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Previous Addresses '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4 d-none">';
            html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+flat_no[i].flat_no+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">House/Flat No.</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>House/Flat No.</label>';
            // html += '                  <input name="" readonly value="'+flat_no[i].flat_no+'" class="fld form-control" id="house-flat" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+street[i].street+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Street/Road</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Street/Road</label>';
            // html += '                  <input name="" readonly value="'+street[i].street+'" class="fld form-control" id="street" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+area[i].area+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Area</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Area</label>';
            // html += '                  <input name="" readonly value="'+area[i].area+'" class="fld form-control" id="area" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+city[i].city+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">City/Town</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>City/Town</label>';
            // html += '                  <input name="" readonly value="'+city[i].city+'" class="fld form-control" id="city" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+pin_code[i].pin_code+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Pincode</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Pin Code</label>';
            // html += '                  <input name="" readonly value="'+pin_code[i].pin_code+'" class="fld form-control" id="pincode" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+state[i].state+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Nearest Landmark</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Nearest Landmark</label>';
            // html += '                  <input name="" readonly value="'+state[i].state+'" class="fld form-control" id="land-mark" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="pg-frm-hd">Duration Of Stay</div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-3">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+duration_of_stay_start[i].duration_of_stay_start+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">From</span>';
            html += '</div>';
            html += '</div>';
            // html += '                <div><label>Start Date</label></div>';
            // html += '                <input name="" readonly value="'+nearest_landmark[i].nearest_landmark+'" class="fld form-control end-date" id="start-date" type="text">';
            html += '            </div>'; 
            // html += '            <h6 class="To">TO</h6>';
            html += '           <div class="col-md-3">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">'; 
            html += '<input readonly value="'+duration_of_stay_end[i].duration_of_stay_end+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">To</span>';
            html += '</div>';
            html += '</div>';
            // html += '            <div><label>End Date</label></div>';
            // html += '             <input name="" readonly value="'+street[i].street+'" class="fld form-control end-date" id="end-date" type="text">';
             
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
            html += '         <div class="pg-frm-hd">Contact Person</div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+contact_person_name[i].contact_person_name+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Name</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Name</label>';
            // html += '                  <input name="" readonly value="'+street[i].street+'" class="fld form-control" id="name" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+contact_person_relationship[i].contact_person_relationship+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Relationship</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Relationship</label>';
            // html += '                  <input name="" readonly value="'+street[i].street+'" class="fld form-control" id="relationship" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+contact_person_mobile_number[i].contact_person_mobile_number+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Mobile Number</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Mobile Number</label>';
            // html += '                  <input name="" readonly value="'+street[i].street+'" class="fld form-control" id="contact_no" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '        <hr>';
           
            html += '      </div>';
            html += '   </div>';
            // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+12+'\',\'Previous employment\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+12+'\',\'Previous employment\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
          



        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>';
        // alert(data.component_data.rental_agreement) 
            if(rental_agreement[i] != null && rental_agreement[i] != 'no-file' && rental_agreement[i] != '' ){
                    // var reantAgreementDoc = data.component_data.rental_agreement;
                    // var reantAgreementDoc = reantAgreementDoc.split(",");
                    for (var k = 0; k < rental_agreement[i].length; k++) {
                        var url = img_base_url+"../uploads/rental-docs/"+rental_agreement[i][k];
                        if ((/\.(jpg|jpeg|png)$/i).test(rental_agreement[i][k]) && rental_agreement[i][k] != null && rental_agreement[i][k] != 'no-file' && rental_agreement[i][k] != '' ){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+rental_agreement[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+rental_agreement[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(rental_agreement[i][k]) && rental_agreement[i][k] != null && rental_agreement[i][k] != 'no-file' && rental_agreement[i][k] != '' ){
                            html += '<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '<div class="image-selected-div">';
                            html += '<ul class="p-0 mb-0">';
                            html += '<li class="image-selected-name pb-0">'+rental_agreement[i][k]+'</li>'
                            html += '<li class="image-name-delete pb-0">';
                            html += '<a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '<i class="fa fa-arrow-down"></i>';
                            html += '</a>'; 
                            html += '</li>';
                            html += '</ul>';
                            html += '</div>';
                            html += '</div>';
                        }
                    }
                }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
                }
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Ration Card</div>';
            if(ration_card[i] != null && ration_card[i] != 'no-file'){
                    // var rationCardDoc = data.component_data.ration_card;
                    // var rationCardDoc = rationCardDoc.split(",");
                    for (var k = 0; k < ration_card[i].length; k++) {
                        var url = img_base_url+"../uploads/ration-docs/"+ration_card[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(ration_card[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+ration_card[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+ration_card[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(ration_card[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+ration_card[i][k]+'</li>'
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
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Government Utility Bill</div>';
            if(gov_utility_bill[i] != null && gov_utility_bill[i] != 'no-file'){
                    // var govUtilityBillDoc = data.component_data.gov_utility_bill;
                    // var govUtilityBillDoc = govUtilityBillDoc.split(",");
                    for (var k = 0; k < gov_utility_bill[i].length; k++) {
                        var url = img_base_url+"../uploads/gov-docs/"+gov_utility_bill[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(gov_utility_bill[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+gov_utility_bill[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal(\''+url+'\')" data-view_docs="'+gov_utility_bill[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(gov_utility_bill[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0">'+gov_utility_bill[i][k]+'</li>'
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
            if (component_status[i] == '3') {
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '         </div>';
            html += '   <hr>'; 
        }
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }
    $('#component-detail').html(html);
}

function directorship_check(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    }
    var insuff_remarks = '';
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(candidate_id != '' || candidate_id != null){
        for (var i = 0; i < form_values['directorship_check'] ; i++) {
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4 d-none">';
            
            if(component_status[i] == '0'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold d-none">Status: </label>&nbsp;<span class="text-info d-none" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold d-none">Status: </label>&nbsp;<span class="text-success d-none" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold d-none">Status: </label>&nbsp;<span class="text-danger d-none" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold d-none">Status: </label>&nbsp;<span class="text-success d-none" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            // alert('insuffDisable:'+insuffDisable)
            // alert('approvDisable:'+approvDisable)
            html += '            </div>';
            html += '         </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == '3') {
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}

function global_aml_sanctions(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    }
    var insuff_remarks = '';

    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(candidate_id != '' || candidate_id != null){
        for (var i = 0; i < form_values['directorship_check'] ; i++) {
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4 d-none">';
            
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
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
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
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == '3') {
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}

function driving_License(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(JSON.stringify(data))
    // console.log(data)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    }
    var get_component_status = '';
    var insuff_remarks = '';
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
            html += '            <div class="col-md-4 d-none">';
            get_component_status = component_status[i];
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
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            
            html += '            </div>';
            html += '         </div>';
           
            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd"> </div>';
            // html += '                   <label class="font-weight-bold">Driving License Number: </label>'
            // html += '                   <input type="text" class="fld form-control" readonly value="'+data.component_data.licence_number+'" >'
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+data.component_data.licence_number+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Driving License Number</span>';
            html += '</div>';
            html += '</div>';
                if(data.component_data.licence_doc != null && data.component_data.licence_doc != ''){
                        var licence_doc = data.component_data.licence_doc;
                        var licence_doc = licence_doc.split(",");
                        for (var i = 0; i < licence_doc.length; i++) {
                            var url = img_base_url+"../uploads/licence-docs/"+licence_doc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(licence_doc[i])){
                                html += '                   <label class="font-weight-bold  mt-3">Driving License: </label>'
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
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (get_component_status == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+insuff_remarks[0].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}

function credit_cibil_check(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    // console.log(JSON.stringify(data))
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    var insuff_remarks = '';
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
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
        
        for (var i = 0; i < credit_number.length ; i++) {
            // alert(JSON.stringify(document_type[i]))
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4 d-none">';
            
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
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
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
            if(document_type[i].document_type != '' && document_type[i] != 'undefined'){
                html += '                   <label class="font-weight-bold">Document type: '+document_type[i].document_type+'</label>'
            }
            else{
                html += '                   <label class="font-weight-bold">Document type: -</label>'
            }
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+credit_number[i].credit_cibil_number+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">Document Number</span>';
            html += '</div>';
            html += '</div>';
            // html += '                   <input type="text" class="fld form-control" readonly value="'+credit_number[i].credit_cibil_number+'" >'                
            html += '            </div>';
            html += '        </div>';

            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+data.component_data.credit_country+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">Country</span>';
            html += '</div>';
            html += '</div>';
            // html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_country+'" >'                
            html += '            </div>';
            html += '            <div class="col-md-3">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+data.component_data.credit_state+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">State</span>';
            html += '</div>';
            html += '</div>';
            // html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_state+'" >'                
            html += '            </div>';
            
            html += '            <div class="col-md-3">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+data.component_data.credit_city+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">City</span>';
            html += '</div>';
            html += '</div>';
            // html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_city+'" >'                
            html += '            </div>';
            
            html += '            <div class="col-md-3">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+data.component_data.credit_pincode+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">Pincode</span>';
            html += '</div>';
            html += '</div>';
            // html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_pincode+'" >'                
            html += '            </div>';

            html += '            <div class="col-md-3 mt-2">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+data.component_data.credit_address+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">Address</span>';
            html += '</div>';
            html += '</div>';
            // html += '                   <input type="text" class="fld form-control"  value="'+data.component_data.credit_address+'" >'                
            html += '            </div>';
            html += '        </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}

function bankruptcy_check(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    // console.log(JSON.stringify(data))
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    } 
    var insuff_remarks = '';

    if(candidate_id != '' || candidate_id != null){
        // var formValues = JSON.parse(data.component_data.form_values)
        // var formValues = JSON.parse(formValues)
        // var craditFormValeuslength = formValues['credit_/ cibil check'].length

        
        var document_type = JSON.parse(data.component_data.document_type)
        var bankruptcy_number = JSON.parse(data.component_data.bankruptcy_number)
        // alert(JSON.stringify(bankruptcy_number))
        for (var i = 0; i < form_values['bankruptcy_check'] ; i++) {
            insuffDisable = '';
            approvDisable = '';
            rightClass = 'bac-gr';
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4 d-none">';
            
            if(component_status[i] == '0'){
                // alert(0)
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-warning" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                // alert(1)
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-info" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                // alert(2)
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                // alert(3)
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-danger" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if(component_status[i] == '4'){
                // alert(4)
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
            // html += '                   <input type="text" class="fld form-control" readonly value="'+bankruptcy_number[i].bankruptcy_number+'" >'                
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+bankruptcy_number[i].bankruptcy_number+'" class="input-field" id="city" type="text">';
            html += '<span class="input-field-txt">Number</span>';
            html += '</div>';
            html += '</div>';
            html += '            </div>';
            html += '        </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Bankruptcy\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Bankruptcy\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}

function adverse_database_media_check(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    }
    var insuff_remarks = '';
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    if(candidate_id != '' || candidate_id != null){
        for (var i = 0; i < form_values['directorship_check'] ; i++) {
            // alert()
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4 d-none">';
            
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
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
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
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
} 

function cv_check(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    // console.log(JSON.stringify(data.component_data.cv_doc))
    // alert(JSON.stringify(bankruptcy_number))
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    var checked_component_status = '';
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    }
    var insuff_remarks = '';
    insuffDisable = '';
    approvDisable = '';
    rightClass = 'bac-gr';
    // alert(candidate_id)
    if(candidate_id != '' && candidate_id != null){
        // alert('2.1')
        for (var i = 0; i < 1 ; i++) {
            // alert('2.2')
            html += '         <div class="row">';
            html += '            <div class="col-md-6">';
            html += '               <h6 class="full-nam2">Form '+(j++)+'</h6> ';
            html += '            </div>';
            html += '            <div class="col-md-4 d-none">';
            // alert('component_status: '+component_status[i])
            checked_component_status = component_status[i];
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
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            
            html += '            </div>';
            html += '         </div>';
           
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd"> </div>';
            html += '                   <label class="font-weight-bold d-none">Driving License Number: </label>'
            html += '                   <input type="text" class="d-none fld form-control" readonly value="'+data.component_data.licence_number+'" >'
                // alert(data.component_data.cv_doc)
                // alert('1.0')
                if(data.component_data.cv_doc != null && data.component_data.cv_doc != ''){
                    // alert('1.1')
                        var cv_doc = data.component_data.cv_doc;
                        var cv_doc = cv_doc.split(",");
                        for (var i = 0; i < cv_doc.length; i++) {
                            // alert('1.1'+i)
                            var url = img_base_url+"../uploads/cv-docs/"+cv_doc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(cv_doc[i])){
                                // alert('1.2'+i)
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
                                // alert('1.3'+i)
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+cv_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" target="_blank" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-arrow-down"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }
                        }
                }else{
                    // alert('1.4')
                        html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                // alert('1.5')            
            html += '            </div>';
            html += '        </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_" onclick="modalapprov('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (checked_component_status == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+insuff_remarks[0].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}

function health_checkup_check(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
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
            html += '            <div class="col-md-4 d-none">';
            
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
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Health checkup\',\''+priority+'\','+i+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}

function employement_gap_check(data,priority,form_values,component_name,candidate_id,component_id){ 
    // console.log('permanent_address : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    }
    var insuff_remarks = '';
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
            if (data.component_data.reason_for_gap !=null && data.component_data.reason_for_gap !='[]' && data.component_data.reason_for_gap !='') {
                emp = JSON.parse(data.component_data.reason_for_gap);
            }
               var empdate = '';
                if (data.component_data.duration_of_gap !=null && data.component_data.duration_of_gap !='[]' && data.component_data.duration_of_gap !='') {
                empdate = JSON.parse(data.component_data.duration_of_gap);
            }
 
            if (emp !='') {
                for (var n = 0; n < emp.length; n++) {
                  
                html += '            <div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+empdate[n]['date_gap']+'" class="input-field" id="pincode" type="text">';
                html += '<span class="input-field-txt">Gap Date Range</span>';
                html += '</div>';
                html += '</div>';
            // html += '            <label">Gap Date Range</label>'; 
            //  html += '                   <input type="text"  readonly class="fld form-control"  value="'+empdate[n]['date_gap']+'" >'                
                html += '            </div>';

            html += '            <div class="col-md-12">';
            html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<input readonly value="'+emp[n]['reason_for_gap']+'" class="input-field" id="pincode" type="text">';
                html += '<span class="input-field-txt">Gap Reason</span>';
                html += '</div>';
                html += '</div>';
            // html += '            <label">Gap Reason</label>'; 
            //  html += '                   <input type="text" class="fld form-control"  value="'+emp[n]['reason_for_gap']+'" >'                
                html += '            </div>';
                }
            }


            html += '            <div class="col-md-4 d-none">';
            
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
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
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
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';
        }
    }
    $('#component-detail').html(html)
}

function landload_reference(data,priority,form_values,component_name,candidate_id,component_id){
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
 
    var component_status = data.component_data.analyst_status.split(',');
    var insuff_remarks = '';
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
                fontAwsom = '<i class="fa fa-check"></i>'
                rightClass ='bac-gr'
            }else if (component_status[i] == '2') {
                                 
                form_status = '<span class="text-success">Completed<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'

            }else if (component_status[i] == '3') {
                                 
                form_status = '<span class="text-danger">Insufficiency<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if (component_status[i] == '4') {
                
                form_status = '<span class="text-success">Verified Clear<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            
            }else{

                form_status = '<span class="text-danger">Wrong<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
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
            html += '            <div class="col-md-4 d-none">';
            html += '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
            html += '            </div>';
            html += '         </div>';
            html += '         <div class="row">'; 
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Tenant Name</label>';
            // html += '                  <input name="" readonly value="'+tenant_name[i]['tenant_name']+'" class="fld form-control tenant_name" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+case_contact_no[i]['case_contact_no']+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Landlord Contact Number</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Landlord Contact Number</label>';
            // html += '                  <input name="" readonly value="'+case_contact_no[i]['case_contact_no']+'" class="fld form-control case_contact_no" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+$landlord+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Landlord Name</span>';
            html += '</div>';
            html += '</div>';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Landlord Name</label>';
            // html += '                  <input name="" readonly value="'+$landlord+'" class="fld form-control landlord_name" type="text">';
            // html += '               </div>';
            html += '            </div>';
            html += '         </div>'; 

            // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+23+'\',\'Landload Reference\',\''+priority+'\','+i+',\'double\')">Raise Insufficiency</button>';
            // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+23+'\',\'Landload Reference\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';        
        }
    }
    $('#component-detail').html(html) 
}

function social_media(data,priority,form_values,component_name,candidate_id,component_id){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)

    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else{

                    form_status = '<span class="text-danger">Wrong<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
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
        html += '               <label class="font-weight-bold d-none">Verification Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.candidate_name+'" class="input-field" id="city" type="text">';
        html += '<span class="input-field-txt">Candidate Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Candidate Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        // html += '               </div>'; 
        html += '            </div>';
 
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.dob+'" class="input-field" id="city" type="text">';
        html += '<span class="input-field-txt">Date Of Birth(DOB)</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Date Of Birth(DOB)</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.dob+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
        html += '            </div>';

         
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.employee_company_info+'" class="input-field" id="city" type="text">';
        html += '<span class="input-field-txt">Latest Employment Company Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Latest Employment Company name </label>';
        // html += '                  <input name="" readonly value="'+data.component_data.employee_company_info+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
        html += '            </div>';

         
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.education_info+'" class="input-field" id="city" type="text">';
        html += '<span class="input-field-txt">Highest Education College</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Highest Education College</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.education_info+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
        html += '            </div>';

         
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.university_info+'" class="input-field" id="city" type="text">';
        html += '<span class="input-field-txt">University Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                   <label>University name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.university_info+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
        html += '            </div>';

         
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.social_media_info+'" class="input-field" id="city" type="text">';
        html += '<span class="input-field-txt">Social Media Handles(If Any)</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                   <label> Social media handles if any</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.social_media_info+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
        html += '            </div>';


        html += '         </div>';
        if (data.component_data.analyst_status == 3) {
            html += '<div class="row">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="col-md-12">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';   
            html += '</div>'; 
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+25+'\',\'Social Media\',\''+priority+'\','+0+',\'single\')">Raise Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+25+'\',\'Social Media\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        html += '   <hr>';
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
}

function covid_19(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(data.status)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    }
    var insuff_remarks = '';
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
                html += '           <label class="font-weight-bold d-none">Verification Status: </label>&nbsp;<span class="text-warning d-none" id="form_status_'+i+'">Not Initiated</span>';
                // insuffDisable = 'disabled'
                // approvDisable = 'disabled'
                // rightClass ='bac-gy'    
            }else if(component_status[i] == '1'){
                html += '           <label class="font-weight-bold d-none">Verification Status: </label>&nbsp;<span class="text-info d-none" id="form_status_'+i+'">Form Filled</span>';

            }else if(component_status[i] == '2'){
                html += '           <label class="font-weight-bold d-none">Verification Status: </label>&nbsp;<span class="text-success d-none" id="form_status_'+i+'">Completed</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }else if(component_status[i] == '3'){
                html += '           <label class="font-weight-bold d-none">Verification Status: </label>&nbsp;<span class="text-danger d-none" id="form_status_'+i+'">Insufficiency</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
            }else if(component_status[i] == '4'){
                html += '           <label class="font-weight-bold d-none">Verification Status: </label>&nbsp;<span class="text-success d-none" id="form_status_'+i+'">Verified Clear</span>';
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            
            // alert('insuffDisable:'+insuffDisable)
            // alert('approvDisable:'+approvDisable)
            html += '            </div>';
            html += '         </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Covid-19\',\''+priority+'\','+i+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (component_status[i] == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}


/*new Component */


function sex_offender(data,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#modal-headding').html(component_name)
    var insuff_remarks = '';
    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '5') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Stop Check<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '6') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Unable to Verify<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '7') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Verified Discrepancy<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '8') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Client Clarification<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '9') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Closed Insufficiency<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                } else if (data.component_data.analyst_status == '11'){
                    analystStatus = '<span class="case-status case-status-2 text-perpul">Insufficiency Clear<span>'; 
                     form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr' 
                }else{
                     form_status = '<span class="case-status case-status-2 text-info">In Progress<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }

        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">Sex Offender</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.first_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">First Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '</div>';

        // html += '               <div class="pg-frm">';
        // html += '                  <label>Candidate Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        // html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.last_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Last Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
         html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.dob+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Date Of Birth(DOB)</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Date Of Birth(DOB)</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.dob+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
        html += '            </div>';


        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.gender+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Gender</span>';
        html += '</div>';
        html += '</div>';

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
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}
 

function politically_exposed(data,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#modal-headding').html(component_name)
    var insuff_remarks = '';
    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '5') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Stop Check<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '6') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Unable to Verify<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '7') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Verified Discrepancy<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '8') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Client Clarification<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '9') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Closed Insufficiency<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                } else if (data.component_data.analyst_status == '11'){
                    analystStatus = '<span class="case-status case-status-2 text-perpul">Insufficiency Clear<span>'; 
                     form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr' 
                }else{
                     form_status = '<span class="case-status case-status-2 text-info">In Progress<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }

        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">Politically Exposed Person</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.first_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">First Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '</div>';

        // html += '               <div class="pg-frm">';
        // html += '                  <label>Candidate Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        // html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.last_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Last Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
         html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.dob+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Date Of Birth(DOB)</span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-md-4">';
         html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<textarea readonly class="input-field" id="pincode" >'+data.component_data.dob+'</textarea>';
        html += '<span class="input-field-txt">Address</span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Date Of Birth(DOB)</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.dob+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
        html += '            </div>';


        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.gender+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Gender</span>';
        html += '</div>';
        html += '</div>';

        html += '         </div>';

      
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}




function india_civil_litigation(data,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#modal-headding').html(component_name)
    var insuff_remarks = '';
    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '5') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Stop Check<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '6') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Unable to Verify<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '7') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Verified Discrepancy<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '8') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Client Clarification<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '9') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Closed Insufficiency<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                } else if (data.component_data.analyst_status == '11'){
                    analystStatus = '<span class="case-status case-status-2 text-perpul">Insufficiency Clear<span>'; 
                     form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr' 
                }else{
                     form_status = '<span class="case-status case-status-2 text-info">In Progress<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }

        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">India Civil Litigation</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.first_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">First Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '</div>';

        // html += '               <div class="pg-frm">';
        // html += '                  <label>Candidate Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        // html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.last_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Last Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
         html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.dob+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Date Of Birth(DOB)</span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-md-4">';
         html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<textarea readonly class="input-field" id="pincode" >'+data.component_data.dob+'</textarea>';
        html += '<span class="input-field-txt">Address</span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Date Of Birth(DOB)</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.dob+'"  class="fld form-control state" id="state" type="text">';
        // html += '               </div>';
        html += '            </div>';


        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.gender+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Gender</span>';
        html += '</div>';
        html += '</div>';

        html += '         </div>';

      
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}


function gsa(data,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#modal-headding').html(component_name)
    var insuff_remarks = '';
    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '5') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Stop Check<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '6') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Unable to Verify<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '7') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Verified Discrepancy<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '8') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Client Clarification<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '9') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Closed Insufficiency<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                } else if (data.component_data.analyst_status == '11'){
                    analystStatus = '<span class="case-status case-status-2 text-perpul">Insufficiency Clear<span>'; 
                     form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr' 
                }else{
                     form_status = '<span class="case-status case-status-2 text-info">In Progress<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }

        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">GSA</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.first_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">First Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '</div>';

        // html += '               <div class="pg-frm">';
        // html += '                  <label>Candidate Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        // html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.last_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Last Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
          
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}


function oig(data,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#modal-headding').html(component_name)
    var insuff_remarks = '';
    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '5') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Stop Check<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '6') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Unable to Verify<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '7') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Verified Discrepancy<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '8') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Client Clarification<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '9') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Closed Insufficiency<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                } else if (data.component_data.analyst_status == '11'){
                    analystStatus = '<span class="case-status case-status-2 text-perpul">Insufficiency Clear<span>'; 
                     form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr' 
                }else{
                     form_status = '<span class="case-status case-status-2 text-info">In Progress<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }

        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">OIG</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.first_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">First Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '</div>';

        // html += '               <div class="pg-frm">';
        // html += '                  <label>Candidate Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        // html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.last_name+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Last Name</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
          
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}


function mca(data,priority,form_values,component_name,candidate_id,component_id){
    $('#componentModal').modal('show')
    $('#modal-headding').html(component_name)
    // console.log(JSON.stringify(data))
    // console.log(data)
    var html = '';
    var form_status = ''
    var component_status = '0'
    var j=1;
    if(data.status != '0'){
        var component_status = data.component_data.analyst_status.split(',');
    }
    var get_component_status = '';
    var insuff_remarks = '';
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
            html += '            <div class="col-md-4 d-none">';
            get_component_status = component_status[i];
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
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd"> </div>';
            // html += '                   <label class="font-weight-bold">Driving License Number: </label>'
            // html += '                   <input type="text" class="fld form-control" readonly value="'+data.component_data.licence_number+'" >'
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+data.component_data.organization_name+'" class="input-field" id="pincode" type="text">';
            html += '<span class="input-field-txt">Organization Name</span>';
            html += '</div>';
            html += '</div>';
                if(data.component_data.experiance_doc != null && data.component_data.experiance_doc != ''){
                        var experiance_doc = data.component_data.experiance_doc;
                        var experiance_doc = experiance_doc.split(",");
                        for (var i = 0; i < experiance_doc.length; i++) {
                            var url = img_base_url+"../uploads/mca-docs/"+experiance_doc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(experiance_doc[i])){
                                html += '                   <label class="font-weight-bold  mt-3">Experience/Relieving Letter For That Company: </label>'
                                html += '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+experiance_doc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+experiance_doc[i]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
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
                        }
                }else{
                        html += '               <div class="pg-frm-hd">There is no file </div>';
                }
                            
            html += '            </div>';
            html += '        </div>';
            // html += '   <button class="insuf-btn" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
            // html += '   <button class="app-btn" '+approvDisable+' id="app_btn_'+i+'" onclick="modalapprov('+candidate_id+','+component_id+',\'Driving License\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            if (get_component_status == 3) {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';   
                html += '</div>'; 
            }
            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
            html += '   <hr>';

        }
    }
    $('#component-detail').html(html)
}


// diffrent check forms
function right_to_work(data,component_name) {
    $('#insuff-comment-div').empty();
    $('#modal-headding').html(component_name);
    // address pin_code city  state  approved_doc
    let html = ''; 
    if(data.status != '0') {
        var document_number =  JSON.parse(data.component_data.document_number)
        var mobile_number =  JSON.parse(data.component_data.mobile_number)
        var first_name =  JSON.parse(data.component_data.first_name)
        var last_name =  JSON.parse(data.component_data.last_name)
        var dob =  JSON.parse(data.component_data.dob)
        var gender =  JSON.parse(data.component_data.gender)
        var insuff_remarks = '';
        var component_status = data.component_data.analyst_status.split(',');
        var j = 1;
          var form_values =  JSON.parse(data.component_data.form_values)
         var form_values =  JSON.parse(form_values)
        for (var i = 0; i < document_number.length; i++) {
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
                fontAwsom = '<i class="fa fa-check"></i>'
                rightClass ='bac-gr'
            }else if (component_status[i] == '2') {
                         
                form_status = '<span class="text-success">Completed<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else if (component_status[i] == '3') {
                         
                form_status = '<span class="text-danger">Insufficiency<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                insuff_remarks = JSON.parse(data.component_data.insuff_remarks); 
            }else if (component_status[i] == '4') {
                       
                form_status = '<span class="text-success">Verified Clear<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gr'
            }else{

                form_status = '<span class="text-danger">Wrong<span>';
                fontAwsom = '<i class="fa fa-check"></i>'
                insuffDisable = 'disabled'
                approvDisable = 'disabled'
                rightClass ='bac-gy'
            }
            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '<div class="pg-txt-cntr">';
            html += '<div class="pg-steps d-none">Step 2/6</div>';
            html += '<div class="row">';
            html += '<div class="col-md-6">';
            html += '<h6 class="full-nam2"> Address Details '+(j++)+'</h6> ';
            html += '</div>';
            html += '<div class="col-md-4 d-none">';
            html += '<label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_'+i+'">'+form_status+'</span>';
            html += '</div>';
            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea class="input-field" readonly rows="1" id="document_number">'+document_number[i].document_number+'</textarea>';
            html += '<span class="input-field-txt">Document Number</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            if (form_values.right_to_work[i] ==2) {
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+mobile_number[i].mobile_number+'" class="input-field" id="mobile_number" type="text">';
            html += '<span class="input-field-txt">Mobile Number</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            }

            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+first_name[i].first_name+'" class="input-field" id="first_name" type="text">';
            html += '<span class="input-field-txt">First Name</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+last_name[i].last_name+'" class="input-field" id="last_name" type="text">';
            html += '<span class="input-field-txt">Last Name</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '</div>';
            html += '<div class="row">';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+dob[i].dob+'" class="input-field" id="dob" type="text">';
            html += '<span class="input-field-txt">Date Of Birth</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-4">';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<input readonly value="'+gender[i].gender+'"  class="input-field" id="gender" type="text">';
            html += '<span class="input-field-txt">Gender</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';  
            html += '</div>';
            html += '</div>';
            // html += '   <button class="insuf-btn" id="insuf_btn_'+i+'" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+1+'\',\'Criminal Check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
            // html += '   <button class="app-btn" id="app_btn_'+i+'" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+1+'\',\'Criminal Check\',\''+priority+'\','+i+',\'double\')"><i id="app_btn_icon_'+i+'" class="fa fa-check '+rightClass+'"></i> Approve</button>';
            // alert(info[i].address)
            if (component_status[i] == '3') {
                html += '<div class="row">';
                 html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
                html += '<div class="col-md-12">';
                html += '<div class="input-wrap">';
                html += '<div class="pg-frm">';
                html += '<textarea readonly  class="input-field">'+insuff_remarks[i].insuff_remarks+'</textarea>';
                html += '<span class="input-field-txt">Insuff Remark Comment</span>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }

            html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-'+i+'"></div>';
            // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,i,'form-values');
        }
    } else {
        html += '<div class="row">';
        html += '<div class="col-md-12">';
        html += '<h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '</div>';
        html += '</div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}


function nric(data,component_name){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#modal-headding').html(component_name)
    var insuff_remarks = '';
    let html='';
    if(data.status != '0'){

                var form_status = '';
                var insuffDisable = '';
                var approvDisable = '';
                var rightClass = '';

                if (data.component_data.analyst_status == '0') {
                             
                    form_status = '<span class="text-warning">Pending<span>'; 
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gy'
                }else if (data.component_data.analyst_status == '1') {
                             
                    form_status = '<span class="text-info">Form Filled<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '2') {
                             
                    form_status = '<span class="text-success">Completed<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '3') {
                             
                    form_status = '<span class="text-danger">Insufficiency<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
                }else if (data.component_data.analyst_status == '4') {
                           
                    form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }else if (data.component_data.analyst_status == '5') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Stop Check<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '6') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Unable to Verify<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                }else if (data.component_data.analyst_status == '7') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Verified Discrepancy<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '8') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Client Clarification<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                   
                }else if (data.component_data.analyst_status == '9') {
                   
                    form_status = '<span class="case-status case-status-2 text-danger">Closed Insufficiency<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                    
                } else if (data.component_data.analyst_status == '11'){
                    analystStatus = '<span class="case-status case-status-2 text-perpul">Insufficiency Clear<span>'; 
                     form_status = '<span class="text-success">Verified Clear<span>';
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr' 
                }else{
                     form_status = '<span class="case-status case-status-2 text-info">In Progress<span>'; 
                    fontAwsom = '<i class="fa fa-check"></i>'
                    insuffDisable = 'disabled'
                    approvDisable = 'disabled'
                    rightClass ='bac-gr'
                }

        
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html += '               <h6 class="full-nam2 font-weight-bold">NRIC</h6> ';
        html += '            </div>';
        html += '            <div class="col-md-4 d-none">';
        html += '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status">'+form_status+'</span>';
        html += '            </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.nric_number+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">NRIC Number</span>';
        html += '</div>';
        html += '</div>';
        // html += '</div>';

        // html += '               <div class="pg-frm">';
        // html += '                  <label>Candidate Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.candidate_name+'" class="fld form-control pincode" id="pincode" type="text">';
        // html += '               </div>'; 
        html += '            </div>';

        html += '            <div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.joining_date+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Issue Date</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
          
        html += '<div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.end_date+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Expiry Date</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
         
        html += '<div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<input readonly value="'+data.component_data.gender+'" class="input-field" id="pincode" type="text">';
        html += '<span class="input-field-txt">Gender</span>';
        html += '</div>';
        html += '</div>';
        // html += '               <div class="pg-frm">';
        // html += '                  <label>Father Name</label>';
        // html += '                  <input name="" readonly value="'+data.component_data.father_name+'" class="fld form-control city" id="city" type="text">';
        // html += '               </div>';
        html += '            </div>';
          
        html += '      </div>';
        html += '   </div>';
        // html += '   <button class="insuf-btn" id="insuf_btn" '+insuffDisable+' onclick="modalInsuffi('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')">Insufficiency</button>';
        // html += '   <button class="app-btn" id="app_btn" '+approvDisable+' onclick="modalapprov('+data.component_data.candidate_id+',\''+5+'\',\'Global Database\',\''+priority+'\','+0+',\'single\')"><i id="app_btn_icon" class="fa fa-check '+rightClass+'"></i> Approve</button>';
        if (data.component_data.analyst_status == '3') {
            html += '<div class="col-md-12">';
             html += '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="input-wrap">';
            html += '<div class="pg-frm">';
            html += '<textarea readonly  class="input-field">'+data.component_data.insuff_remarks+'</textarea>';
            html += '<span class="input-field-txt">Insuff Remark Comment</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="table-responsive mt-3" id="client-clarification-log-list-div-0"></div>';
        // view_all_client_clarifications(data.component_data.candidate_id,data.component_id,0,component_name,0,'form-values');
    }else{
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <h6 class="full-nam2">Data has not been submitted yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }   
    $('#component-detail').html(html);
    $('#componentModal').modal('show')
}



function view_docs_modal(url){ 
    // var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src",url);

    let html = '';
     
    // html += '<a download class="btn bg-blu text-white" href="'+url+'">'
    // html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
    // html += '</a>';

    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}

function view_edu_docs_modal(url){ 
    // var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src", url);

    let html = '';
     
    // html += '<a download class="btn bg-blu text-white" href="'+url+'">'
    // html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
    // html += '</a>';

    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}

function indexFromTheValue(valueArray,searchingNumber){
     
    return valueArray.indexOf(searchingNumber)

}