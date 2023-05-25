var max_img_size = 10000000,
    new_ticket_attach_file_array = [];

get_ticket_priority_list();
function get_ticket_priority_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-ticket-priority-list", 
        dataType: "json",
        data : {
            verify_csm_request : 1 
        },
        success: function(data) {
            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i].id+'">'+data[i].priority+'</option>';
            }
            $('#ticket-priority').html(html);
        } 
    });
}




$('#user-name').on('change',function(){  
    getPackage($(this).val());

    var master = $(this).find(':selected').data('master');
    $('.radio-client').attr('checked', false);
    if (master !='0') { 
        $('input:radio[name="radio-client"]').filter('[value="child"]').attr('checked', true);
    }else{
         $('input:radio[name="radio-client"]').filter('[value="master"]').attr('checked', true);
    }
});
 

function getPackage(id){
    // alert(id)
    $.ajax({
        type: "POST",
        url: base_url+"inputQc/getPackage/", 
        data:{
            clinet_id:id
        },
        dataType: "json",
        success: function(data){ 
            
            var html = '';

            html += '<option selected value="">Select your package</option>';
            if(data.length > 0){ 
                for(var i=0; data[0].package_ids.length > i ;i++){
                    html += '<option value="'+data[0].package_ids[i]+'">'+data[0].package_name[i]+'</option>';
                }

            }else{
                html += '<option value="">No package avilable</option>';
            }

            $('#package_id').html(html)
        }
    });

}


$('#package_id').on('change',function(){ 
    getPkgdata($(this).val());
    check_assigned_to_package();
    
});



function getPkgdata(id=''){  
    var client_id  = $('#user-name').val();
    
    if(id != '' && client_id !=''){
      $.ajax({
        type: "POST",
        url: base_url+"package/get_single_component_data/"+id+"/"+client_id, 
        dataType: "json",
        async:false,
        success: function(data){ 
            console.log(JSON.stringify(data.client.package_components))
            var package_components = JSON.parse(data.client.package_components);
            // alert(package_components.length)
            

            var edit_package_name = $('#edit_package_name').val(data['package_data'][0].package_name); 
            
            
            // return false;
            $('#edit_package_id').val(id);
            var package = $('#package_id').val();
            let comp='';
          
            for (var i = 0; i < package_components.length; i++) {
            if (package_components[i]['package_id'] == package) {
           
                    var component =  package_components[i].component_name;
                    var component_name = component.replaceAll(/\s+/g, '_').trim();
                    console.log(JSON.stringify(package_components))
 
                
                comp +='<div class="col-md-4">'
                    comp +='<div class=" custom-control custom-checkbox custom-control-inline">'
                    comp +='<input   type="checkbox" data-component_name="'+package_components[i].component_name+'"  data-component_price="'+package_components[i].component_price+'" onclick="select_skill_form('+package_components[i].component_id+')"';
                        comp +='class="custom-control-input components package_components package_comp" value="'+package_components[i].component_id+'" ';
                        comp +='name="componentCheck" id="componentCheck'+package_components[i].component_id+'">';
                    comp +='<label class="custom-control-label" for="componentCheck'+package_components[i].component_id+'">'+package_components[i].component_name
                    comp +='</label>'
                comp +=' </div>'
                // editcomponentCheck
                 comp += '<div>';
                 comp += '<input type="text" id="remarks'+package_components[i].component_id+'" class="form-control remarks" placeholder="Add Price" >';
                 comp += '<label>Current Price: '+package_components[i].component_price+'</label>';

                 comp += '</div>';
                comp += ''
                comp +=' </div>'
            }}
            $('#view-all-packages').html(comp)
        }
      });
     
    }else{
        let comp='';
        comp +='<div class="col-md-4">'
            
        comp +=' </div>'
        $('#view-all-packages').html(comp)
    }
}




$("#type-of-approval").on('change',function(){
remarks_all();
})

remarks_all();
function remarks_all() {
    var type_of_approval = $('#type-of-approval').val();  
    var flag =0;
    if (type_of_approval =='1') {
         flag =1;
    }

    $.ajax({
        type: "POST",
        url: base_url+"approval_Mechanisms/get_all_remarks", 
        dataType: "json",
        data : {
            verify_csm_request : 1
        },
        success: function(data) {

            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].status == '2' && data[i].flag == flag) { 
                     html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
                }
            }
            $('#ticket_description').html(html);
        } 
    });
}

$("#ticket_description").on('change',function(){
    if ($(this).val()=='Others') {
        $("#additionals").show();
    }else{
       $("#additionals").hide();  
    }
      $('#ticket-description-error-msg-div').html('');
})


get_all_raised_tickets();
function get_all_raised_tickets() {
    $.ajax({
        type : "POST",
        url : base_url+"Approval_Mechanisms/get_approval_data",
        data : {
            verify_csm_request : 1,
            rate : 1,
            list_of_approval:2

        },
        dataType: "json",
        success: function(data) {
            var all_tickets = data,
                html = '';

            if (data.length > 0) {
                for (var i = 0; i < all_tickets.length; i++) {
                       var status_one = 'Pending';
                    if (all_tickets[i].level_one_status =='1') {
                        status_one = 'Accepted';
                    }else if(all_tickets[i].level_one_status =='2') {
                        status_one = 'Rejected';
                    }
                     
                     var status_two = 'Pending';
                    if (all_tickets[i].level_two_status =='1') {
                        status_two = 'Accepted';
                    }else if(all_tickets[i].level_two_status =='2') {
                        status_two = 'Rejected';
                    }
                     
                     var status = 'Pending';
                    if (all_tickets[i].final_approval_status =='1') {
                        status = 'Accepted';
                    }else if(all_tickets[i].final_approval_status =='2') {
                        status = 'Rejected';
                    }
                     
                        var action = 'Creating';
                    if (all_tickets[i].type_of_action =='0') {
                        action = 'Creating';
                    }else if(all_tickets[i].type_of_action =='1') {
                        action = 'Deletion';
                    }else if(all_tickets[i].type_of_action =='3') {
                        action = 'Rate';
                    }
                     
                    html += '<tr class="case-filter" id="tr_'+all_tickets[i].approval_id+'">';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+(i+1)+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i].approval_id+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+action+'</td>';
                    html += '<td id="start_date'+all_tickets[i].approval_id+'">'+all_tickets[i]['approval_created_date']+'</td>';
                    html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i]['remarks']+'</td>';
                   html += '<td id="first_name'+all_tickets[i].approval_id+'">'+all_tickets[i]['team_name']+' ('+all_tickets[i].created_by_role+')</td>';
                     
                    html += '<td id="ticket-status-'+all_tickets[i].approval_id+'">'+status+'</td>';
                    html += '<td class="text-center" id="view_ticket_details_'+all_tickets[i].approval_id+'"><a id="view_ticket_details_a'+all_tickets[i].approval_id+'" href="javascript:void(0)" onclick="view_ticket_details('+all_tickets[i].approval_id+')"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';

                    // html += '<td class="text-center" id="view_ticket_details_'+all_tickets[i].approval_id+'"><a id="view_ticket_details_a'+all_tickets[i].approval_id+'" href="javascript:void(0)" onclick="view_ticket_details('+all_tickets[i].approval_id+')"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
                    html += '</tr>';
                    } 
                }
             
            $('#get-all-tickets').html(html);
        } 
    });
}

function view_ticket_details(approval_id) {
    $.ajax({
        type : "POST",
        url : base_url+"Approval_Mechanisms/get_approvals_data",
        data : {
            approval_id : approval_id,
            verify_csm_request : 1
        },
        dataType: "json",
        success: function(data) {
                var action = 'Creating';
                    if (data.type_of_action =='0') {
                        action = 'Creating';
                    }else if(data.type_of_action =='1') {
                        action = 'Deletion';
                    }else if(data.type_of_action =='3' && data.created_by_role =='csm') {
                        action = 'Rate';  
                    }else if(data.created_by_role =='analyst' || data.created_by_role =='specialist'){
                        action = 'Fee';
                    }

                     if (data.levels !='') {
                        j =1;
                        for (var i = 0; i < data.levels.levels; i++) { 
                            $("#status_level_"+j++).show();
                        }
                    }


                    

                        var access = [];
                            var level_one = '';
                            var level_two = '';
                            var level_tree = '';
                    if (data.teams.length > 0) {
                        var team = data.teams;
                        for (var i = 0; i < team.length; i++) {
                            if (team[i].approval_access_level !='' && team[i].approval_access_level !=null) {
                                access = team[i].approval_access_level.split(',');
                           
                            for (var k = 0; k < access.length; k++) {
                                 if (1== access[k]) { 
                                var select ='';
                                if (team[i].team_id == data.level_one_id) {
                                  
                               level_one += '( '+team[i].first_name+' )'; 
                                }
                            }
                            if (2== access[k]) {
                                var selecte ='';
                                if (team[i].team_id == data.level_two_id) {
                                   level_two += '( '+team[i].first_name+' )'; 
                                } 
                            }
                            if (3== access[k]) {
                                var selected ='';
                                if (team[i].team_id == data.approved_by) {
                                     level_tree += '( '+team[i].first_name+' )'; 
                                } 
                            }

                            }
                            }

                           


                        }
                    }

                       var status_one = 'Pending';
                    if (data.level_one_status =='1') {
                        status_one = 'Accepted';
                    }else if(data.level_one_status =='2') {
                        status_one = 'Rejected';
                    }
                     
                     var status_two = 'Pending';
                    if (data.level_two_status =='1') {
                        status_two = 'Accepted';
                    }else if(data.level_two_status =='2') {
                        status_two = 'Rejected';
                    }

                     var status_three = 'Pending';
                    if (data.approval_status =='1') {
                        status_three = 'Accepted';
                    }else if(data.approval_status =='2') {
                        status_three = 'Rejected';
                    }
                     
                     var status = 'Pending';
                    if (data.final_approval_status =='1') {
                        status = 'Accepted';
                    }else if(data.final_approval_status =='2') {
                        status = 'Rejected';
                    }

                            $("#level_one").html(status_one+level_one);
                            $("#level_two").html(status_two+level_two);
                            $("#level_three").html(status_three+level_tree);
                            $("#final_status").html(status);

                    var html = '';
                       let comp = '';
                        if (data.final_approval_status =='2') {
                            var rem = data.approve_remarks;
                            if (data.approve_additional_remarks !=null) {
                                rem += data.approve_additional_remarks;
                            }
                            $("#rejected_remarks").html("Rejected Remarks: "+rem);
                        }
                    comp += '<label>Details : </lable>';
                    if(data.type_of_action =='3' && data.created_by_role =='csm'){
                       var component = JSON.parse(data.components);
                        if (component.length > 0) {
                            for (var i = 0; i < component.length; i++) {
                               var parse = 0;
                                if (parseFloat(component[i].component_price).toFixed(2) > parseFloat(component[i].form_values).toFixed(2)) { 
                                   parse = ( (parseFloat(component[i].component_price).toFixed(2) - parseFloat(component[i].form_values).toFixed(2)) / parseFloat(component[i].component_price).toFixed(2) ) * 100;
                                }else{
                                    parse = ( (parseFloat(component[i].component_price).toFixed(2) - parseFloat(component[i].form_values).toFixed(2)) / parseFloat(component[i].component_price).toFixed(2) ) * 100;
                                   // parse = (parseFloat(component[i].form_values).toFixed(2) * parseFloat(component[i].component_price).toFixed(2))  / 100 ; 
                                  // parse = Math.round(((parseFloat(component[i].form_values).toFixed(2) * parseFloat(component[i].component_price).toFixed(2)) / 100)); 
                                }
                                
                                // comp += '<label>Components</lable>';
                                comp +='<div class="col-md-4">'
                                    comp +='<div class=" custom-control">' 
                                    comp +='<label   >'+component[i].component_name
                                    comp +='</label>' 
                                 comp += '</div>'; 
                                 comp += '<div  class=" custom-control">'; 
                                 comp += '<input type="text" readonly value="'+component[i].form_values+'" id="component-text-'+component[i].component_id+'" class="form-control" placeholder="Add Comment" >';
                                 comp +='<label class="" > Current '+component[i].component_price+' ( '+parse+' % )'
                                    comp +='</label>'
                                 comp += '</div>'; 
                                 comp += '</div>'; 
                            }
                        } 
                    }else if(data.created_by_role =='analyst' || data.created_by_role =='specialist'){
                         comp +='<div class="col-md-12">';
                        
                          comp += '</div>'; 
                         comp +='<div class="col-md-4">'
                                comp +='<div class=" custom-control">' 
                                comp +='<label   >'+data.component_name
                                comp +='</label>' 
                                 comp += '</div>'; 
                                 comp += '<div  class=" custom-control">'; 
                                 comp += '<input type="text" readonly value="'+data.amount+'"  class="form-control"  >';
                                 comp +='<label class="" > Currency '+data.currency
                                    comp +='</label>'
                                 comp += '</div>'; 
                                 comp += '</div>';
                    }else if(data.created_by_role.trim() =='it administrator'){
                          var component = JSON.parse(data.components);
                        if (component.length > 0) { 
                         comp +='<div class=" custom-control">First Name: '+data.first_name+'</div><br>'
                         comp +='<div class=" custom-control">Last Name: '+data.last_name+'</div><br>'
                         comp +='<div class=" custom-control">Email: '+data.user_name+'</div><br>' 
                             
                    } 
                    } 

                    var remarks = data.remarks;
                    if (remarks =='Others') {
                        remarks = data.remarks+'('+data.additional_remarks+')';
                    }

                 console.log(JSON.stringify(data))
             $("#created_by").html(data.team_name+' ('+data.created_by_role+')'); 
              $("#action_type").html(action); 
               $("#created_remarks").html(remarks); 
                   
                $("#approver-remarks").val(data.approve_remarks)

                if (data.number_of_list =='1' || data.number_of_list =='1' ) {
                    if (data.client_data !='') {
                         var htm  = "<div class='custom-control'> Client Name :</div>"+data.client_data.client_name;
                        $("#extra-details").html(htm);
                    }
                }else{
                    $("#extra-details").html(comp);
                }


            $("#new-new-ticket-modal").modal('show');
             $("#edit-role-close-btn").show();  
                   $("#raise-ticket-btn").show();
                if (data.approval_status =='0') {
                    $("#edit-role-close-btn").attr('onclick','approve_the_mechanism('+approval_id+',2)');
                    $("#raise-ticket-btn").attr('onclick','approve_the_mechanism('+approval_id+',1)');
                }else if(data.approval_status =='1'){
                   $("#edit-role-close-btn").hide();  
                   $("#raise-ticket-btn").html('Accepted');
                }else if(data.approval_status =='2'){
                   $("#edit-role-close-btn").html('Rejected'); 
                   $("#raise-ticket-btn").hide();
                }
           } 
    });
}


$(".radio-client").on('change',function(){
    var radio = $(this).val();
    if (radio == 'master') {
       $("#client-list").hide(); 
        }else{
          $("#client-list").show();   
        }
});

  /*$("#type-of-approval").on('change',function(){
        var type = $(this).val();
        
        if (type == 0) {
           $("#client-list").hide(); 
           $("#client-type").show();
        }else{
          $("#client-list").show();   
          $("#client-type").hide();
        }
    });*/
get_ticket_classification_list();
function get_ticket_classification_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-ticket-classification-list",
        data : {
            verify_csm_request : 1
        },
        dataType: "json",
        success: function(data) {
            var html = '<option value="">None</option>';
            for (var i = 0; i < data.length; i++) {
                html += '<option value="'+data[i]+'">'+data[i]+'</option>';
            }
            $('#ticket-classifications').html(html);
        } 
    });
}

get_roles_list();
function get_roles_list() {
   /* $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-roles-list", 
        dataType: "json",
        data : {
            verify_csm_request : 1
        },
        success: function(data) {
            if (data.all_roles.length > 0) {
                var all_roles = data.all_roles;
                for (var i = 0; i < all_roles.length; i++) {
                    html += '<option value="'+all_roles[i].role_name+'">'+all_roles[i].role_name+'</option>';
                }
            }*/
            var html = '<option value="">Select Role</option>';
                html += '<option value="client">Client</option>';
            $('#assigned-to-role').html(html);
      /*  } 
    });*/
}

function get_roles_person_list() {
    $.ajax({
        type: "POST",
        url: base_url+"factsuite-csm/get-roles-person-list", 
        dataType: "json",
        data : {
            verify_analyst_request : 1,
            role_type : $('#assigned-to-role').val()
        },
        success: function(data) {
            var html = '<option value="">Select Person</option>';
            if (data.all_persons.length > 0) {
                var all_persons = data.all_persons;
                for (var i = 0; i < all_persons.length; i++) {
                    html += '<option value="'+all_persons[i].team_id+'">'+all_persons[i].first_name+' '+all_persons[i].last_name+' ('+all_persons[i].team_employee_email+')</option>';
                }
            }
            $('#assigned-to-person').html(html);
        } 
    });
}

$('#assigned-to-role').on('change', function() {
    check_assigned_to_role();
});

$('#assigned-to-person').on('change', function() {
    check_assigned_to_person();
});

$('#ticket-subject').on('keyup blur', function() {
    check_ticket_subject();
});

$("#ticket-attach-file").on("change", handle_file_select_new_ticket_attach_file);

$('#raise-ticket-btn').on('click', function() {
    raise_new_ticket();
});

function check_assigned_to_role() {
    var variable_array = {};
    variable_array['input_id'] = '#assigned-to-role';
    variable_array['error_msg_div_id'] = '#assigned-to-role-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please select a role.';
    var mandatory_select_var = mandatory_select(variable_array);
    if (mandatory_select_var == 1) {
        get_roles_person_list();
    } else {
        $('#assigned-to-person').html('<option value="">Select Person</option>');
    }
    return mandatory_select_var;
}

function check_assigned_to_person() {
    var variable_array = {};
    variable_array['input_id'] = '#user-name';
    variable_array['error_msg_div_id'] = '#user-name-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please select a Client.';
    return mandatory_select(variable_array);
}

function check_assigned_to_package() {
    var variable_array = {};
    variable_array['input_id'] = '#package_id';
    variable_array['error_msg_div_id'] = '#package_id-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please select a Package.';
    return mandatory_select(variable_array);
}

function check_ticket_subject() {
    var variable_array = {};
    variable_array['input_id'] = '#ticket-subject';
    variable_array['error_msg_div_id'] = '#ticket-subject-error-msg-div';
    variable_array['empty_input_error_msg'] = 'Please enter the text subject';
    return mandatory_any_input_with_no_limitation(variable_array);
}

function handle_file_select_new_ticket_attach_file(e) {
    new_ticket_attach_file_array = [];
    var variable_array = {};
    variable_array['e'] = e;
    variable_array['file_id'] = '#ticket-attach-file';
    variable_array['show_image_name_msg_div_id'] = '#ticket-attach-file-error-msg-div';
    variable_array['storedFiles_array'] = new_ticket_attach_file_array;
    variable_array['col_type'] = 'col-md-12';
    variable_array['file_ui_id'] = 'file_new_ticket_attach';
    variable_array['file_size'] = max_img_size;
    variable_array['exceeding_max_length_error_msg'] = 'Attached file should be of max 1MB';
    return not_mandatory_single_file_upload(variable_array);
}

function raise_new_ticket() { 

        var type = $('#type-of-approval').val();
        var ticket_description = $('#ticket_description').val(); 
        var user_name = $("#user-name").val();  
        var additional_remarks = $("#additional_remarks").val();  
        var client_type = $(".radio-client:checked").val();
        
        var components = [];
        $('.package_components:checked').each(function(){
            components.push($(this).val());
        });


    var component = [];
    $(".package_components:checked").each(function(){
        var id = $(this).val();
        var component_name = $(this).data('component_name');
        var component_price = $(this).data('component_price');
        var form_value = $("#remarks"+$(this).val()).val(); 
        if (form_value !='') { 
            $('#component-error-msg-div').html('');
        component.push({component_id:$(this).val(),component_name:component_name,form_values:form_value,component_price:component_price});
        }else{
             $('#component-error-msg-div').html('<span class="text-danger error-msg-small">Please enter selected checks with the new price.</span>');
        }
     
    }); 
    var  check_assigned_to_person_var = check_assigned_to_person();
    var  check_assigned_to_package_var = check_assigned_to_package();
   
    if ( ticket_description != '' && check_assigned_to_person_var && check_assigned_to_package_var && component.length > 0) {
        $('#ticket-classifications-error-msg-div').html('');
        $('#raise-ticket-btn').prop('disabled',true);
        $('#raise-ticket-error-msg-div').html('<span class="d-block text-warning error-msg text-center">Please wait while we are adding the Approval Request.</span>');

        var formdata = new FormData();
        formdata.append('verify_csm_request',1);
        formdata.append('client_type',client_type); 
        formdata.append('description',ticket_description);   
        formdata.append('user_name',user_name);    
        formdata.append('additional_remarks',additional_remarks);    
        formdata.append('components',JSON.stringify(component));  

        $.ajax({
            type: "POST",
            url: base_url+"approval_Mechanisms/approval_for_rate_user",
            data:formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == '1') {
                    $('#raise-ticket-btn').prop('disabled',false);
                    $('#raise-ticket-error-msg-div').html('');
                    if (data.status == '1') {
                        toastr.success('Your Request has been raised successfully.');
                        $('#add-new-ticket-modal').modal('hide');
                        $('#assigned-to-role').val('');
                        $('#type-of-approval').val('');
                        $('#ticket_description').val(''); 
                        $("#user-name").val('');
                        $("#designation").val('');
                        $("#manager-name").val('');
                        $("#assigned-to-roles").val('');
                        $('.package_components').attr('checked',false);
                        get_all_raised_tickets();
                    } else {
                        toastr.error('Something went wrong while raising the Request. Please try again.');
                    }
                } else {
                    check_admin_login();
                }
            },
            error: function(data) {
                $('#raise-ticket-btn').prop('disabled',false);
                $('#raise-ticket-error-msg-div').html('');
                toastr.error('Something went wrong while raising the Data. Please try again.');
            }
        });
    } else {
        if (ticket_description == '') {
            $('#ticket-description-error-msg-div').html('<span class="text-danger error-msg-small">Please select the Remarks.</span>');
        } else {
            $('#ticket-description-error-msg-div').html('');
        }

        if (component.length == 0) {
             $('#component-error-msg-div').html('<span class="text-danger error-msg-small">Please select checks min 1 required.</span>');
        }
    }
}