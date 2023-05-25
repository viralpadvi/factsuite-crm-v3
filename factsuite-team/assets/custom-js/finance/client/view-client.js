load_client();
var tmp_i = 0;

function load_client(){
    sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"client/get_view_client", 
	  	dataType: "json",
	  	success: function(data){ 
		    let html='';
            if (data.length > 0) {
                var j = 1;
                for (var i = 0; i < data.length; i++) { 
                    var check = '',
                        candidate_notification_check = '';
                    if (data[i].client_access == 1) {
                        check = 'checked';   
                    }

                    if (data[i].candiate_notification_status == 1) {
                        candidate_notification_check = 'checked';   
                    }
                	html += '<tr id="tr_'+data[i].client_id+'">'; 
                	html += '<td>'+j+'</td>';
                	html += '<td id="client_name_'+data[i].client_id+'">'+data[i]['client_name']+'</td>';
                	html += '<td id="client_industry_'+data[i].client_id+'">'+data[i]['industry_name']+'</td>';
                	html += '<td id="client_city_'+data[i].client_id+'">'+data[i]['client_city']+'</td>';
                	html += '<td id="role_'+data[i].client_id+'">'+data[i]['poc_user_name']+'</td>';
                	html += '<td id="reporting_manager_'+data[i].client_id+'">'+data[i]['poc_user_email']+'</td>';
                    if (access == 1) {
                        html += '<td class="text-center"><a  href="'+base_url+'factsuite-finance/edit-client/'+data[i].client_id+'"><i class="fa fa-pencil"></i></a></div>&nbsp;&nbsp;&nbsp;</td>';
                    }else{
                        html += '<td></td>';  
                    }
                    // html += '<td class="text-center">';
                    // html += '<div class="custom-control custom-switch pl-0">';
                    // html += '<input type="checkbox" '+check+' onclick="change_client_status('+data[i].client_id+','+data[i].client_access+')" class="custom-control-input" id="change_client_status_'+data[i].client_id+'">';
                    // html += '<label class="custom-control-label" for="change_client_status_'+data[i].client_id+'"></label>';
                    // html += '</div>';
                    // html += '</td>';
                    // html += '<td class="text-center">';
                    // html += '<div class="custom-control custom-switch pl-0">';
                    // html += '<input type="checkbox" '+candidate_notification_check+' onclick="change_candiate_notification_status('+data[i].client_id+','+data[i].candiate_notification_status+')" class="custom-control-input" id="change-candidate-notification-status-'+data[i].client_id+'">';
                    // html += '<label class="custom-control-label" for="change-candidate-notification-status-'+data[i].client_id+'"></label>';
                    // html += '</div>';
                    // html += '</td>';
                	// html += '<td><a onclick="view_edit_team('+data[i].client_id+')" href="'+base_url+'factsuite-admin/edit-client/'+data[i].client_id+'"><i class="fa fa-pencil"></i></a></div><a onclick="remove_client_field('+data[i].client_id+')" href="#"  class=" ml-1 " ><i class="fa  fa-trash text-danger"></i></a></td>';
                	html += '</tr>';

                    j++; 
                }
            }else{
                html+='<tr><td colspan="7" class="text-center">Client Not Found.</td></tr>'; 
            }

            $('#get-client-data').html(html); 
            // component_price();
	  	} 
	});
}


function change_client_status(client_id,client_status) { 
    var changed_client_status = 0;

    if (client_status == 1) {
        changed_client_status = 0;
    } else if (client_status == 0) {
        changed_client_status = 1;
    } else {
        load_client();
        toastr.error('OOPS! Something went wrong. Please try again.')
        return false;
    }

    var variable_array = {};
    variable_array['id'] = client_id;
    variable_array['actual_status'] = client_status;
    variable_array['changed_status'] = changed_client_status;
    variable_array['ajax_call_url'] = 'factsuite-admin/change-client-access';
    variable_array['checkbox_id'] = '#change_client_status_'+client_id;
    variable_array['onclick_method_name'] = 'change_client_status';
    variable_array['success_message'] = 'client access has been updated successfully.';
    variable_array['error_message'] = 'Something went wrong updating the client access. Please try again.';
    variable_array['error_callback_function'] = 'load_client()';
    variable_array['ajax_pass_data'] = {verify_admin_request : 1, id : client_id, changed_status : changed_client_status};

    return change_status(variable_array);
}

function change_candiate_notification_status(client_id,status) {
    var changed_client_status = 0;

    if (status == 1) {
        changed_client_status = 0;
    } else if (status == 0) {
        changed_client_status = 1;
    } else {
        load_client();
        toastr.error('OOPS! Something went wrong. Please try again.fv dfvdfvdf')
        return false;
    }

    var variable_array = {};
    variable_array['id'] = client_id;
    variable_array['actual_status'] = status;
    variable_array['changed_status'] = changed_client_status;
    variable_array['ajax_call_url'] = 'factsuite-admin/change-candidate-notification-status';
    variable_array['checkbox_id'] = '#change-candidate-notification-status-'+client_id;
    variable_array['onclick_method_name'] = 'change_candiate_notification_status';
    variable_array['success_message'] = 'Candidate notification status has been updated successfully.';
    variable_array['error_message'] = 'Something went wrong updating the candidate notification status. Please try again.';
    variable_array['error_callback_function'] = 'load_client()';
    variable_array['ajax_pass_data'] = {verify_admin_request : 1, id : client_id, changed_status : changed_client_status};

    return change_status(variable_array);
}

function remove_client_field(client){
	$("#remove_client_id").val(client)
	$("#remove-client-view").modal('show')
}

function delete_client(){
    var client_id = $("#remove_client_id").val()
    $.ajax({
        type: "POST",
        url: base_url+"client/remove_client",
        data: {client_id:client_id},
        dataType: "json",
        success: function(data){ 
            if (data.status=='1') {
                $("#tr_"+client_id).remove();
            }
            $("#remove-client-view").modal('hide')
        }
     })
}

$("#is_master").on('click',function(){
    var is_master = $("#is_master:checked").val();
    // alert(is_master)
    if (is_master !=null && is_master =='0') {
        $("#master-account").attr('disabled',true);
        $("#master-account").val('');
    }else{
        $("#master-account").attr('disabled',false);
    }
});



function view_edit_team(client_id){ 
    $('#error-team').html('');
        $.ajax({
        type: "POST",
        url: base_url+"client/get_view_client_single/"+client_id, 
        dataType: "json",
        success: function(data){  
            $("#component-price-error").html('');
          $("#client-id").val(data.client.client_id);
          $("#client-name").val(data.client.client_name);
                    $("#client-address").val(data.client.client_address);
                    // $("#client-city").val(data.client.client_city);
                    $('#client-zip').val(data.client.client_zip);
                    $("#client-industry").val(data.client.client_industry);
                    $("#client-website").val(data.client.website); 
                    $("#manager-email").val(data.client.account_manager_email_id);
                    $("#manager-contact").val(data.client.account_contact_no);
                    $("#tmp-packages").val(data.client.packages);

                    if (data.client.is_master == '0') {
                        $("#is_master").val(0);
                        $("#is_master").attr('checked',true);
                        $("#master-account").attr('disabled',true)
                        $("#master-account").val('')
                    }else{
                      $("#is_master").val(0);
                        $("#is_master").attr('checked',false);
                        $("#master-account").attr('disabled',false)
                        // $("#master-account").val(data.client.is_master)
                    }
                    

                    var communications = [];
                        if (data.client.communications !='') {
                            communications = data.client.communications.split(',');
                        }
                        var images = [];
                        if (data.client.upload_doc_name !='' && data.client.upload_doc_name !='no-file' && data.client.upload_doc_name !=null) {
                            images = data.client.upload_doc_name.split(',');
                        }

                             var html = '';
                        for (var i = 0; i < images.length; i++) {
                            // images[i]
                              html += '<div class="col-md-4 mt-3" id="dbfile_client_documents_'+i+'">'+
                                '<div class="image-selected-div">'+ 
                                        images[i]+' <a id="file_client_documents'+i+'" onclick="exist_view_image(\''+images[i]+'\',\'client-docs\')" data-file="'+images[i]+'" class="image-name-delete-a"><i class="fa fa-eye text-info"></i></a><a id="remove_file_client_documents'+i+'" onclick="removeFile_documents('+i+')" data-file="'+images[i]+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
                                        /*'<li>'+
                                            '<a id="file_client_documents'+i+'" onclick="exist_view_image(\''+images[i]+'\',\'client-docs\')" data-file="'+images+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
                                        '</li>'+*/
                                    
                                '</div>'+
                            '</div>';
                        }
                        // alert(html)
                        $("#selected-vendor-docs-li").html(html);
                        $("#selected-vendor-docs").html('');

                      /*  $(".spo_name").each(function(){ 
                            $(this).val('')
                        });
                        $(".spo_email").each(function(){ 
                            $(this).val('')
                        });
                        $(".spo_contact").each(function(){ 
                            $(this).val('')
                        });*/
                        
                        client_docs =[];
                        $("#component-details").html('');

                        var html_country = '';
                for (var i = 0; i < data.country.length; i++) {
                if (data.state[i]['name'] == data.client.client_country) { 
                    html_country +='<option  data-id="'+data.country[i]['id']+'" selected value='+data.country[i]['name']+'>'+data.country[i]['name']+'</option>'
                }else{
                    html_country +='<option  data-id="'+data.country[i]['id']+'" value='+data.country[i]['name']+'>'+data.country[i]['name']+'</option>'
                }
            }  
            $('#country').html(html_country);

            var html ='';

            for (var i = 0; i < data.state.length; i++) {
                if (data.state[i]['name'] == data.client.client_state) { 
                    html +='<option  data-id="'+data.state[i]['id']+'" selected value='+data.state[i]['name']+'>'+data.state[i]['name']+'</option>'
                }else{
                    html +='<option  data-id="'+data.state[i]['id']+'" value='+data.state[i]['name']+'>'+data.state[i]['name']+'</option>'
                }
            }  
            $('#client-state').html(html);

            var account_manager_name = '';
            for (var i = 0; i < data.team.length; i++) {
                if (data.team[i].team_id == data.client.account_manager_name) { 
                    account_manager_name +='<option selected value='+data.team[i].team_id+'>'+data.team[i].first_name+'</option>'
                }else{
                    account_manager_name +='<option value='+data.team[i].team_id+'>'+data.team[i].first_name+'</option>'
                }
            }  

                     var html_city = '';
                for (var i = 0; i < data.country.length; i++) {
                if (data.state[i]['name'] == data.client.client_city) { 
                    html_city +='<option  data-id="'+data.city[i]['id']+'" selected value='+data.city[i]['name']+'>'+data.city[i]['name']+'</option>'
                }else{
                    html_city +='<option  data-id="'+data.city[i]['id']+'" value='+data.city[i]['name']+'>'+data.city[i]['name']+'</option>'
                }
            }  
            $('#client-city').html(html_country);

            $("#account-manager").html(account_manager_name);

            var master = '';
            for (var i = 0; i < data.master.length; i++) {
                if (data.master[i].client_id == data.client.is_master) { 
                    master +='<option selected value='+data.master[i].client_id+'>'+data.master[i].client_name+'</option>'
                }else{
                    master +='<option value='+data.master[i].client_id+'>'+data.master[i].client_name+'</option>'
                }
            }  
            $("#master-account").html(master); 
            var pack = [];
            if (data.client.packages !='') {
                pack = data.client.packages.split(',');
            }

            var package = '';
            for (var i = 0; i < data.package.length; i++) { 
                if (jQuery.inArray(data.package[i].package_id, pack)!='-1') {  
                    package +='<option selected value='+data.package[i].package_id+'>'+data.package[i].package_name+'</option>'
                }else{
                    package +='<option value='+data.package[i].package_id+'>'+data.package[i].package_name+'</option>'
                }
            }  
             $('#packages').html(package);  
            var comp='';
            var total = [];
            if (data.component.length > 0) {
                var str_price = JSON.parse(data.component[i].component_price);
                for (var i = 0; i < data.component.length; i++) { 
                    if (data.component[i].component_client_price !='' && data.component[i].component_client_price !=null) {
                        
                    total.push(data.component[i].component_client_price);
                    }else{
                      total.push(0);  
                    }
                    comp +='<ul class="ul'+data.component[i]['package_id']+'">';
                    comp +='<li>';
                    comp +='<div class="custom-control custom-checkbox custom-control-inline mrg">';
                    comp +='<input type="checkbox" disabled checked class="custom-control-input component_name" name="customCheck" value="'+data.component[i]['component_id']+'" id="customCheck5">';
                    comp +='<label class="custom-control-label" for="customCheck5">'+data.component[i]['component_name']+'</label>';
                    comp +='</div>';
                    comp +='</li>';
                    comp +='<li>';
                    comp +='<input type="hidden" class="form-control fld2 component_package_id"  value="'+data.component[i].package_id+'" id="component_package_id'+j+'">';
                    comp +='<input type="text" class="form-control fld2 component_standard_price" placeholder="INR 1000" readonly value="'+data.component[i].component_price+'" id="component_standard_price'+tmp_i+'">';
                    comp +='</li>';
                    comp +='<li>';
                    comp +='<input type="text" class="form-control fld component_price" id="component_price'+tmp_i+'" value="'+data.component[i].component_client_price+'" onkeyup="component_price('+tmp_i+')">';
                    comp +='</li>';
                    comp +='</ul>';
                    tmp_i++;
                }
            }
            $("#component-details").html(comp);

                var total_html = '';
            total_html +='<ul>';
            total_html +='<li> ';
            total_html +='</li>';
            total_html +='<li>';
            total_html +=' <label>Price for Client total</label>';
            total_html +='</li>';
            total_html +='<li>';
            total_html +='<b>'+eval(total.join("+"))+'</b>';
            total_html +='</li>';
            total_html +='</ul> ';

        $("#component-total").html(total_html);


            var row = '';
            if (data.spoc.length > 0) {
                for (var i = 0; i < data.spoc.length; i++) {
                    // data.spoc[i] 
                        row +='<ul id="'+i+'">';
                        row +='<li>';
                        row +='<label>Name</label>';
                        row +='<input type="hidden" class="form-control fld spo_id" value="'+data.spoc[i].spoc_id+'"  id="spoc-id'+i+'">';
                        row +='<input type="text" class="form-control fld spo_name" onkeyup="valid_spoc_name('+i+')" value="'+data.spoc[i].spoc_name+'"  id="spoc-name'+i+'">';
                        row +='<div id="spoc-name-error'+i+'">&nbsp;</div>';
                        row +='</li>';
                        row +='<li>';
                        row +='<label>Email</label>';
                        row +='<input type="email" class="form-control fld spo_email" disabled onkeyup="valid_spoc_email('+i+')" value="'+data.spoc[i].spoc_email_id+'" id="spoc-email'+i+'">';
                        row +='<div id="spoc-email-error'+i+'">&nbsp;</div>';
                        row +='</li>';
                        row +='<li>';
                        row +='<label>Phone Number</label>';
                        row +='<input type="number" class="form-control fld spo_contact" onkeyup="valid_spoc_contact('+i+')" value="'+data.spoc[i].spoc_phone_no+'"  id="spoc-contact'+i+'">';
                        row +='<div id="spoc-contact-error'+i+'">&nbsp;</div>';
                        row +='</li>';
                        row +='<li>';
                        // row +='<button onclick="remove_tr('+i+')" class="btn btn-danger"><i class="fa fa-remove"></i></button>';
                        row +='<div>&nbsp;</div>';
                        row +='</li>';
                        row +='</ul>';

                }
            }
         
        $("#spo-details-div").html(row); 

            var arr ='';
           
            $('.communications').each(function() {
                if (jQuery.inArray($(this).val(), communications)!='-1') {  
                    this.checked = true;
                }else{
                    this.checked = false;   
                }
            });
            $("#edit-client-view").modal('show');
        }
    })
}


