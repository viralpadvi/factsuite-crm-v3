  
function sendMial(candidate_id,component_id){
    // alert('Model')
    $('#sendMail').modal('show')
    $.ajax({
        type: "POST",
        url: base_url+"analyst/insuffUpdateStatus",
        data:{
            candidate_id:candidate_id,
            component_id:component_id
        },
        dataType: "json",
        success: function(data){ 

        }
    });
}
var candidate_aadhar =[];
$("#file1").on("change", handleFileSelect_candidate_aadhar);

function modalInsuffi(candidate_id,component_id,componentname,first_name,email_id){
    // var email_id = email_id;
    $('#modalInsuffi').modal('show')
    $('#componentNameInsuff').html('In '+componentname)
    $('#insuffMailDetail').val('Hi '+first_name+',\nWe noticed that your Address details provided are not sufficient to process your Back Ground Check initiated by your employer.')
    $('#btnInsuffiDiv').html('<button onclick="insufiincincyStatusUpdate('+candidate_id+','+component_id+',\''+componentname+'\',\''+email_id+'\')"  class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')
    
}
function insufiincincyStatusUpdate(candidate_id,component_id,componentname,email_id){
    // alert('Viral')
    // return false;
    var candidateUrl = $('#candidateUrl').val()
    var insuffMailDetail = $('#insuffMailDetail').val()

    

    // alert(candidate_aadhar);
    var ext = '';
    var inValidFileList = '';
    var validFileList = '';
    var flag = 0;

    for (var i = candidate_aadhar.length - 1; i >= 0; i--) {
        // alert(candidate_aadhar[i].name)
        ext =candidate_aadhar[i].name.split('.').pop().toLowerCase();

        if($.inArray(ext, ['pdf','png','jpg','jpeg']) != '-1') {
            validFileList += '<span class="text-success">'+candidate_aadhar[i].name+'</span><br>';
        }else{
            inValidFileList += '<span class="text-danger">'+candidate_aadhar[i].name+'</span><br>';
            flag = 1;
        }

        

    }
    $('#valid_files').removeClass('d-none');
    $('#valid-document').html(validFileList)
    if(flag == 1){
        $('#invalid_files').removeClass('d-none');
        $('#document-error').html(inValidFileList)
        candidate_aadhar =[];
        return false;
    }
    
    var formdata = new FormData();
    formdata.append('candidate_id',candidate_id);
    formdata.append('component_id',component_id);
    formdata.append('candidateUrl',candidateUrl);
    formdata.append('email_id',email_id);
    formdata.append('insuffMailDetail',insuffMailDetail);
    formdata.append('componentname',componentname);
    formdata.append('componentname',componentname);
     $.ajax({
        type: "POST",
        url: base_url+"analyst/insuffUpdateStatus", 
        data:formdata,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data){
            // alert('success');

            $('#modalInsuffi').modal('hide')
            if (data.status == '1') {
                loadAllAssignedCases()
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
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;

function handleFileSelect_candidate_aadhar(e){ 
    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
        $("#file1-error").html('');
        $("#file_list_1").html('');
        if (files[0].size <= client_document_size) {
            var html ='';
            for (var i = 0; i < files.length; i++) {
                var fileName = files[i].name; // get file name  

               
                
                html += '<span>'+j++ +')'+fileName+'</span><br>';
                
                  
                candidate_aadhar.push(files[i]);
            }
             alert(html)
            $("#file_list_1").html(html);
        } else {
            $("#file1-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
            $('#file1').val('');
        }
    } else {
        $("#file1-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function modalapprov(candidate_id,component_id,componentname,first_name,email_id){
    // alert('Model')
    $('#modalapprov').modal('show') 
    $('#componentNameApprove').html('In '+componentname)
    $('#insuffMailDetail').val('Hi '+first_name+',\nWe noticed that your Address details provided are not sufficient to process your Back Ground Check initiated by your employer.')
    $('#btnApproveDiv').html('<button onclick="approvUpdate('+candidate_id+','+component_id+',\''+componentname+'\')"  class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')
    
}
 
function approvUpdate(candidate_id,component_id,componentname){ 
    var approveComment = $('#approve-comment').val()

    // alert(approveComment)
     $.ajax({
        type: "POST",
        url: base_url+"analyst/approveUpdateStatus",
        data:{

            candidate_id:candidate_id,
            component_id:component_id,  
            componentname:componentname,
            approveComment:approveComment
        },
        dataType: "json",
        success: function(data){
            $('#modalapprov').modal('hide')
            if (data.status == '1') {
                loadAllAssignedCases()
                let html = "<span class='text-success'>Status updated</span>";
                $('#error-team').html(html);
                toastr.success('Status updated.');
                 
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


function modalStopCheck(candidate_id,component_id,componentname,first_name,email_id){
    // alert('Model')
    $('#modal-stopcheck').modal('show') 
    $('#componentNameApprove').html('In '+componentname)
    $('#insuffMailDetail').val('Hi '+first_name+',\nWe noticed that your Address details provided are not sufficient to process your Back Ground Check initiated by your employer.')
    $('#btnStopCheckDiv').html('<button onclick="stopcheckUpdate('+candidate_id+','+component_id+',\''+componentname+'\')"  class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')
    
}
 
function stopcheckUpdate(candidate_id,component_id,componentname){ 
    var approveComment = $('#approve-comment').val()

    // alert(approveComment)
     $.ajax({
        type: "POST",
        url: base_url+"analyst/stopcheckUpdateStatus",
        data:{

            candidate_id:candidate_id,
            component_id:component_id,  
            componentname:componentname,
            approveComment:approveComment
        },
        dataType: "json",
        success: function(data){
            $('#modal-stopcheck').modal('hide')
            if (data.status == '1') {
                loadAllAssignedCases()
                let html = "<span class='text-success'>Status updated</span>";
                $('#error-team').html(html);
                toastr.success('Status updated.');
                 
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

function getComponentBasedData(candidate_id,component_id){
    // alert(candidate_id+" : "+component_id)
    // return false;
    $.ajax({
        type: "POST",
        url: base_url+"inputQc/getComponentBasedData",
        data:{
            candidate_id:candidate_id,
            component_id:component_id
        },
        dataType: "json",
        success: function(data){  
            // console.log(JSON.stringify(data))
            switch(component_id){
                case 1:
                    criminal_checks(data)
                    break;
                case 2:
                    court_records(data)
                    break;
                case 3:
                    document_check(data)
                    break;
                case 4:
                    drugtest(data)
                    break;
                case 5:
                    globaldatabase(data)
                    break;
                case 6:
                    current_employment(data)
                    break;
                case 7:
                    education_details(data)
                    break;
                case 8:
                    present_address(data)
                    break;
                case 9:
                    permanent_address(data)
                    break;
                case 10:
                    previous_employment(data)
                    break;
                case 11:
                    reference(data)
                    break;
                case 13:
                    previous_address(data)
                    break;

                default:
                    break;
            }

        }
    });
}

function componentdData(candidate_id,component_id){
    // alert(candidate_id+" : "+component_id)
    // return false;
    $.ajax({
        type: "POST",
        url: base_url+"inputQc/getComponentBasedData",
        data:{
            candidate_id:candidate_id,
            component_id:component_id
        },
        dataType: "json",
        success: function(data){  
            // console.log(JSON.stringify(data))
            switch(component_id){
                case 1:
                    criminal_checks(data)
                    break;
                case 2:
                    court_records(data)
                    break;
                case 3:
                    document_check(data)
                    break;
                case 4:
                    drugtest(data)
                    break;
                case 5:
                    globaldatabase(data)
                    break;
                case 6:
                    current_employment(data)
                    break;
                case 7:
                    education_details(data)
                    break;
                case 8:
                    present_address(data)
                    break;
                case 9:
                    permanent_address(data)
                    break;
                case 10:
                    previous_employment(data)
                    break;
                case 11:
                    reference(data)
                    break;
                case 13:
                    previous_address(data)
                    break;

                default:
                    break;
            }

        }
    });
}

// diffrent check forms
function criminal_checks(data){ 

    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Criminal Check')
    // address pin_code city  state  approved_doc
    let html='';
    if(data.status != '0'){

        var address =  JSON.parse(data.component_data.address)
        var pin_code =  JSON.parse(data.component_data.pin_code)
        var city =  JSON.parse(data.component_data.city)
        var state =  JSON.parse(data.component_data.state)
        // alert(JSON.stringify(info))
        var j = 1;
        for (var i = 0; i < address.length; i++) {
       
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

function court_records(data){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Court records')
    let html='';
    if(data.status != '0'){
        var address =  JSON.parse(data.component_data.address)
        var pin_code =  JSON.parse(data.component_data.pin_code)
        var city =  JSON.parse(data.component_data.city)
        var state =  JSON.parse(data.component_data.state)
        var j = 1;
        for (var i = 0; i < address.length; i++) {

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

function document_check(data){ 
    console.log('document_check : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Document Check')

    let html='';
    if(data.status != '0'){
        
        // html += ' <div class="pg-cnt pl-0 pt-0">';
            // html += '      <div class="pg-txt-cntr">';
            // html += '         <div class="pg-steps  d-none">Step 2/6</div>';
            // html += '         <h6 class="full-nam2"> Address Details</h6>';
            // html += '         <div class="row">';
            // html += '            <div class="col-md-8">';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Address</label>';
            // html += '                  <textarea class="fld form-control readonly " rows="4" id="address">'+data.component_data.address+'</textarea>';
            // html += '               </div>';
            // html += '            </div>';

            // html += '            <div class="col-md-4">';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>Pin Code</label>';
            // html += '                  <input name="" readonly value="'+data.component_data.pin_code+'" class="fld form-control pincode" id="pincode" type="text">';
            // html += '               </div>';
            // html += '            </div>';

            // html += '         </div>';
            // html += '         <div class="row">';
            // html += '            <div class="col-md-4">';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>City/Town</label>';
            // html += '                  <input name="" readonly value="'+data.component_data.city+'" class="fld form-control city" id="city" type="text">';
            // html += '               </div>';
            // html += '            </div>';
            // html += '            <div class="col-md-4">';
            // html += '               <div class="pg-frm">';
            // html += '                  <label>State</label>';
            // html += '                  <input name="" readonly value="'+data.component_data.state+'"  class="fld form-control state" id="state" type="text">';
            // html += '               </div>';
            // html += '            </div>';
            // html += '         </div>';
                   
                   
                     
            // html += '         <div class="row">';
            // html += '            <div class="col-md-12">';
            // html += '               <div class="pg-submit text-right">';
            // html += '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
            // html += '               </div>';
            // html += '            </div>';
            // html += '         </div>';
            // html += '      </div>';
        // html += '   </div>';
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
        

        if(adhar_doc_length  > 0 ){
            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Adhar Card</div>';
                                // for loop will start 
            for (var i = 0; i < adhar_doc.length; i++) {

                if ((/\.(jpg|jpeg|png)$/i).test(adhar_doc[i])){
                    html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                    html += '                   <div class="image-selected-div">';
                    html += '                       <ul class="p-0 mb-0">';
                    html += '                           <li class="image-selected-name pb-0">'+adhar_doc[i]+'</li>'
                    html += '                           <li class="image-name-delete pb-0">';
                    html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_document_modal('+data.component_data.candidate_id+',\'aadhar-docs\')" data-view_docs="'+adhar_doc[i]+'" class="image-name-delete-a">';
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
                    html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/aadhar-docs/"+adhar_doc[i]+'" data-view_docs="'+adhar_doc[i]+'" class="image-name-delete-a">';
                    html += '                                   <i class="fa fa-arrow-down"></i>';
                    html += '                               </a>'; 
                    html += '                           </li>';
                    html += '                        </ul>';
                    html += '                   </div>';
                    html += '                 </div>';

                }
                
            }
                            // for loop will end 
            html += '            </div>';
            // html += '      /   </div>';

            if(pan_card_doc_length > 0 ){
               
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm-hd">PAN Card</div>';
                                    // for loop will start 
                for (var i = 0; i < pan_card_doc.length; i++) {
                        
                    if ((/\.(jpg|jpeg|png)$/i).test(pan_card_doc[i])){
                        html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                        html += '                   <div class="image-selected-div">';
                        html += '                       <ul class="p-0 mb-0">';
                        html += '                           <li class="image-selected-name pb-0">'+pan_card_doc[i]+'</li>'
                        html += '                           <li class="image-name-delete pb-0">';
                        html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_document_modal('+data.component_data.candidate_id+',\'pan-docs\')" data-view_docs="'+pan_card_doc[i]+'" class="image-name-delete-a">';
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
                        html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/aadhar-docs/"+pan_card_doc[i]+'" data-view_docs="'+pan_card_doc[i]+'" class="image-name-delete-a">';
                        html += '                                   <i class="fa fa-arrow-down"></i>';
                        html += '                               </a>'; 
                        html += '                           </li>';
                        html += '                        </ul>';
                        html += '                   </div>';
                        html += '                 </div>';

                    }

                }
                                // for loop will end  
                html += '        </div>';
            }


            if(passport_doc_length > 0 ){
             
            html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm-hd">Passport</div>';
                                // for loop will start passport_doc.length
                for (var i = 0; i < passport_doc.length; i++) {
                            
                    if ((/\.(jpg|jpeg|png)$/i).test(adhar_doc[i])){
                        html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                        html += '                   <div class="image-selected-div">';
                        html += '                       <ul class="p-0 mb-0">';
                        html += '                           <li class="image-selected-name pb-0">'+passport_doc[i]+'</li>'
                        html += '                           <li class="image-name-delete pb-0">';
                        html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_document_modal('+data.component_data.candidate_id+',\'proof-docs\')" data-view_docs="'+passport_doc[i]+'" class="image-name-delete-a">';
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
                        html += '                           <li class="image-selected-name pb-0">'+passport_doc[i]+'</li>'
                        html += '                           <li class="image-name-delete pb-0">';
                        html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+img_base_url+"../uploads/aadhar-docs/"+passport_doc[i]+'" data-view_docs="'+passport_doc[i]+'" class="image-name-delete-a">';
                        html += '                                   <i class="fa fa-arrow-down"></i>';
                        html += '                               </a>'; 
                        html += '                           </li>';
                        html += '                        </ul>';
                        html += '                   </div>';
                        html += '                 </div>';

                    }
                }
                                // for loop will end  
            html += '         </div>';
            }
                
            
            html += '      </div>';
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


function drugtest(data){ 
    // console.log('drugtest : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Drugtest')

    var address = JSON.parse(data.component_data.address)
    var candidate_name = JSON.parse(data.component_data.candidate_name)
    var father_name = JSON.parse(data.component_data.father_name)
    var dob = JSON.parse(data.component_data.dob)
    var mobile_number = JSON.parse(data.component_data.mobile_number) 

    let html='';
    if(data.status != '0'){
        for(var i=0;i<candidate_name.length;i++){
            html += ' <div class="pg-cnt pl-0 pt-0">';
            html += '      <div class="pg-txt-cntr">';
            html += '         <div class="pg-steps  d-none">Step 2/6</div>';
            html += '         <h6 class="full-nam2">Test Details</h6>';
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
            html += '   <hr>';
        }        
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

function globaldatabase(data){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Global database')

    let html='';
    if(data.status != '0'){
        
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

function current_employment(data){
    console.log("current_employment: "+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Current employment')

    let html='';

    html += '<div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">'; 
    html += '         <h6 class="full-nam2 d-none">CURRENT EMPLOYMENT</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>Desigination</label>';
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
    html += '         <div class="row">';
    html += '             <div class="col-md-5">';
    html += '                <div class="pg-frm-hd">Joining Date</div>';
    html += '             </div>';
    html += '             <div class="col-md-4">';
    html += '                <div class="pg-frm-hd">relieving date</div>';
    html += '             </div>';
    html += '         </div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += '               <div>&nbsp;</div>';
    html += '                <input name="" readonly="" value="'+data.component_data.joining_date+'"  class="fld form-control mdate" id="joining-date" type="text">';
     
    html += '            </div>';
    html += '            <div class="col-md-1">'; 
    html += '           </div>';
    html += '           <div class="col-md-3 ml-2">';
    html += '            <div>&nbsp;</div>';
    html += '                <input name="" readonly="" value="'+data.component_data.relieving_date+'"  class="fld form-control mdate" id="relieving-date" type="text">';
     
    html += '         </div>';
    html += '         </div>';
    html += '         <div class="row">';
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
    html += '                  <label>HR Contact Name</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_name+'"  class="fld form-control" id="hr-name" type="text">';
    html += '               </div>';
    html += '            </div>';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += '                  <label>HR Contact Number</label>';
    html += '                  <input name="" readonly="" value="'+data.component_data.reporting_manager_contact_number+'"  class="fld form-control" id="hr-contact" type="text">';
    html += '               </div>';
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

function education_details(data){ 
    console.log('education_details : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Education Details')
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
            for (var i = 0; i < type_of_degree.length; i++) {
                // alert(type_of_degree[i].type_of_degree)
            
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
                html += '         <div class="pg-frm-hd">DURATION OF STAY</div>';
                html += '         <div class="row">';
                html += '            <div class="col-md-3">';
                html += '                <div class="pg-frm">';
                html += '                  <!-- <label>College Name</label> -->';
                html += '                  <input name="" class="fld form-control start-date" value = "'+course_start_date[i].course_start_date+'" id="duration_of_stay" type="text">';
                html += '               </div>';
                 
                html += '            </div>';
                html += '           <div class="col-md-3">';
                html += '            <div class="pg-frm">';
                html += '               <label>Duration of Course</label>';
                html += '               <input class="duration_of_course fld form-control end-date" value = "'+course_end_date[i].course_end_date+'" >'; 
                html += '            </div>';
                html += '         </div>';
                if(type_of_course[i].type_of_course == 'part_time'){
                html += '         <div class="col-md-2 tp">';
                html += '            <div class="custom-control custom-radio custom-control-inline mrg-btm">';
                html += '               <input type="radio" checked class="custom-control-input part_time" name="customRadio" id="customRadio1">';
                html += '               <label class="custom-control-label pt-1" for="customRadio1">Part Time</label>';
                html += '            </div>';
                html += '         </div>';
                }else if(type_of_course[i].type_of_course == 'full_time'){
                html += '         <div class="col-md-2 tp">';
                html += '            <div class="custom-control custom-radio custom-control-inline mrg-btm">';
                html += '               <input type="radio" checked class="custom-control-input part_time" name="customRadio" id="customRadio2">';
                html += '               <label class="custom-control-label pt-1" for="customRadio2">Full Time</label>';
                html += '            </div>';
                html += '         </div>';
                }
                
                
                html += '         </div>';
                html += '         <div class="row">';
                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm">';
                html += '                  <label>Registration Roll Number</label>';
                html += '                  <input name="" class="fld registration_roll_number" value = "'+registration_roll_number[i].registration_roll_number+'" type="text">';
                html += '               </div>';
                html += '            </div>';
                html += '         </div>';
                html += '         <hr>'; 
                
                html += '      </div>';
                html += '   </div>';
            }
        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">all sem marksheet</div>';
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">degree convocation/ transcript of records</div>';
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">consolidate marksheet/ provisional degree certificate</div>';
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">10th / 12th mark card/ course completion certificate <span>(optional)</span></div>';
        html += '            </div>';
        html += '         </div>';
        }else{
            html += '         <div class="row">';
            html += '            <div class="col-md-12">';
            html += '               <h6 class="full-nam2">Data was not inserted perfectly.</h6>';
            html += '            </div>';
            html += '         </div>';
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

function present_address(data){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Present Address')
    
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
        html += '        <hr>';
         
        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">rental agreement/ driving License</div>';
        // html += '                   rental_agreement'
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Upload ration card <span>(optional)</span></div>';
        // html += '                   ration_card'    
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">upload government utility bill <span>(optional)</span></div>';
        // html += '                   gov_utility_bill'
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
        html += '         <div class="row">';
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

function permanent_address(data){ 
    // console.log('court_records : '+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Permanent address')
    let html ='';
    if(data.status > 0){
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps d-none">Step 2/6</div>';
        html += '         <h6 class="full-nam2">Permanent address</h6>';
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
        html += '        <hr>';
         
        html += '         <div class="row mt-3">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Rental agreement/ driving License</div>';
                            // for loop will start 
                for (var i = 0; i < 10; i++) {
                
                    html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                    html += '                   <div class="image-selected-div">';
                    html += '                       <ul class="p-0 mb-0">';
                    html += '                           <li class="image-selected-name pb-0">'+data.component_data.rental_agreement+'</li>'
                    html += '                           <li class="image-name-delete pb-0">';
                    html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal('+data.component_data.candidate_id+')" data-view_docs="'+data.component_data.rental_agreement+'" class="image-name-delete-a">';
                    html += '                                   <i class="fa fa-eye text-primary"></i>';
                    html += '                               </a>'; 
                    html += '                           </li>';
                    html += '                        </ul>';
                    html += '                   </div>';
                    html += '                 </div>';

                }
                        // for loop will end 
            
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Upload ration card <span>(optional)</span></div>';
             
                            // for loop will start 
                for (var i = 0; i < 10; i++) {

                    html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                    html += '                   <div class="image-selected-div">';
                    html += '                       <ul class="p-0 mb-0">';
                    html += '                           <li class="image-selected-name pb-0">'+data.component_data.ration_card+'</li>'
                    html += '                           <li class="image-name-delete pb-0">';

                    html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal('+data.component_data.candidate_id+')" data-view_docs="'+data.component_data.ration_card+'" class="image-name-delete-a">';
                    html += '                                   <i class="fa fa-eye text-primary"></i>';
                    html += '                               </a>'; 
                    
                    html += '                           </li>';
                    html += '                        </ul>';
                    html += '                   </div>';
                    html += '                 </div>';  

                }
                        // for loop will end    
            html += '            </div>';

            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">upload government utility bill <span>(optional)</span></div>';
             
                            // for loop will start 
                for (var i = 0; i < 10; i++) {

                    html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                    html += '                   <div class="image-selected-div">';
                    html += '                       <ul class="p-0 mb-0">';
                    html += '                           <li class="image-selected-name pb-0">'+data.component_data.gov_utility_bill+'</li>'
                    html += '                           <li class="image-name-delete pb-0">';
                    html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_docs_modal('+data.component_data.candidate_id+')" data-view_docs="'+data.component_data.gov_utility_bill+'" class="image-name-delete-a">';
                    html += '                                   <i class="fa fa-eye text-primary"></i>';
                    html += '                               </a>'; 
                    html += '                           </li>';
                    html += '                        </ul>';
                    html += '                   </div>';
                    html += '                 </div>';

                }
                    // for loop will end        
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
        html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
        html += '            </div>';
        html += '         </div>';
    }
    $('#component-detail').html(html);
}

function previous_employment(data){
    console.log("current_employment: "+JSON.stringify(data))
    $('#componentModal').modal('show')
    // $('#modal-headding').html('Previous employment')
    $('#modal-headding').html('')
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
    let html='';
    var j = 1;
    for(var i=0;i<desigination.length;i++){
        // alert(i)
        html += '<div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">'; 
        html += '         <h4 class="full-nam2">Previous Employment '+(j++)+'</h4>';
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>Desigination</label>';
        html += '                  <input name="" readonly="" value="'+desigination[i].desigination+'" class="fld form-control" id="designation" type="text">';
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
        html += '         <div class="row">';
        html += '             <div class="col-md-5">';
        html += '                <div class="pg-frm-hd">Joining Date</div>';
        html += '             </div>';
        html += '             <div class="col-md-4">';
        html += '                <div class="pg-frm-hd">relieving date</div>';
        html += '             </div>';
        html += '         </div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-3">';
        html += '               <div>&nbsp;</div>';
        html += '                <input name="" readonly="" value="'+joining_date[i].joining_date+'"  class="fld form-control mdate" id="joining-date" type="text">';
         
        html += '            </div>';
        html += '            <div class="col-md-1">'; 
        html += '           </div>';
        html += '           <div class="col-md-3 ml-2">';
        html += '            <div>&nbsp;</div>';
        html += '                <input name="" readonly="" value="'+relieving_date[i].relieving_date+'"  class="fld form-control mdate" id="relieving-date" type="text">';
         
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
        html += '                  <input name="" readonly="" value="'+reporting_manager_desigination[i].reporting_manager_desigination+'"  class="fld form-control" id="reporting-manager-designation" type="text">';
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
        html += '                  <label>HR Contact Name</label>';
        html += '                  <input name="" readonly="" value="'+hr_name[i].hr_name+'"  class="fld form-control" id="hr-name" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += '                  <label>HR Contact Number</label>';
        html += '                  <input name="" readonly="" value="'+hr_contact_number[i].hr_contact_number+'"  class="fld form-control" id="hr-contact" type="text">';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
     
        html += '      </div>';
        html += '   </div>';
    } 
        html += '         <div class="row">';
        html += '            <div class="col-md-12">';
        html += '               <div class="pg-submit text-right">';
        html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
        html += '               </div>';
        html += '            </div>';
        html += '         </div>';
    $('#component-detail').html(html) 
}

function reference(data){
    console.log("reference : "+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Reference detail')

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
        for (var i = 0; i < company_name_lenght; i++) { 

            html += '<h6 class="full-nam2">Reference '+(j++)+'</h6>';
            html += '         <div class="row">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Name</label>';
            html += '                  <input name="" readonly value="'+name[i]+'" class="fld form-control name" type="text">';
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
            html += '        <hr>';          
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

function previous_address(data){
    console.log("previous_address : "+JSON.stringify(data))
    $('#componentModal').modal('show')
    $('#modal-headding').html('Previous Address')
   
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
        for (var i = 0; i < state.length; i++) { 

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
            html += '         <div class="pg-frm-hd">DURATION OF STAY</div>';
            html += '         <div class="row">';
            html += '            <div class="col-md-3">';
            html += '                <div><label>Start Date</label></div>';
            html += '                <input name="" readonly value="'+nearest_landmark[i].nearest_landmark+'" class="fld form-control end-date" id="start-date" type="text">';
            html += '            </div>'; 
            html += '            <h6 class="To">TO</h6>';
            html += '           <div class="col-md-3">';
            html += '            <div><label>End Date</label></div>';
            html += '             <input name="" readonly value="'+street[i].street+'" class="fld form-control end-date" id="end-date" type="text">';
             
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
            html += '                  <input name="" readonly value="'+street[i].street+'" class="fld form-control" id="name" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Reletionship</label>';
            html += '                  <input name="" readonly value="'+street[i].street+'" class="fld form-control" id="relationship" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm">';
            html += '                  <label>Mobile Number</label>';
            html += '                  <input name="" readonly value="'+street[i].street+'" class="fld form-control" id="contact_no" type="text">';
            html += '               </div>';
            html += '            </div>';
            html += '         </div>';
            html += '        <hr>';
           
            html += '      </div>';
            html += '   </div>';
        }

        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">rental agreement/ driving License</div>';
             
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Upload ration card <span>(optional)</span></div>';
           
        html += '            </div>';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">upload government utility bill <span>(optional)</span></div>';
            
        html += '            </div>';
        html += '            <div class="col-md-3">';
                           
        html += '            </div>';
        html += '         </div>';
             
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
function view_docs_modal(documentName){ 
    var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src", img_base_url+"../uploads/rental-docs/"+image);

    let html = '';
     
    html += '<a download class="btn bg-blu text-white" href="'+img_base_url+"../uploads/rental-docs/"+image+'">'
    html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
    html += '</a>';

    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}


function view_document_modal(documentName,folderName){ 
    var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src", img_base_url+"../uploads/"+folderName+"/"+image);

    let html = '';
     
    html += '<a download class="btn bg-blu text-white" href="'+img_base_url+"../uploads/"+folderName+"/"+image+'">'
    html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
    html += '</a>';

        // html += '<div id="gallery-slider" class="carousel slide" data-ride="carousel" data-interval="false">';
        // html += '   <div class="carousel-inner">';
        // html += '       <div class="carousel-item active">';
        // html += '           <div class="gallery-slider-txt">';
        // html += '               <span>Image 1</span>';
        // html += '               <img src="http://localhost:8080/factsuitecrm/factsuite-team/assets/admin/images/FactSuite-logo.png" />';
        // html += '           </div>';
        // html += '       </div>';
        // html += '       <div class="carousel-item">';
        // html += '           <div class="gallery-slider-txt">';
        // html += '               <span>Image 2</span>';
        // html += '               <img src="http://localhost:8080/factsuitecrm/factsuite-team/assets/admin/images/FactSuite-logo.png" />';
        // html += '           </div>';
        // html += '       </div>';
        // html += '       <div class="carousel-item">';
        // html += '           <div class="gallery-slider-txt">';
        // html += '               <span>Image 3</span>';
        // html += '               <img src="http://localhost:8080/factsuitecrm/factsuite-team/assets/admin/images/FactSuite-logo.png" />';
        // html += '           </div>';
        // html += '       </div>';
        // html += '   </div>';
        // html += '   <!-- Left and right controls -->';
        // html += '   <a class="carousel-control-prev" href="#gallery-slider" data-slide="prev">';
        // html += '       <i class="fa fa-angle-left fa-2x text-dark"></i>';
        // html += '   </a>';
        // html += '   <a class="carousel-control-next" href="#gallery-slider" data-slide="next">';
        // html += '       <i class="fa fa-angle-right fa-2x text-dark"></i>';
        // html += '   </a>';
        // html += '</div>';



    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}