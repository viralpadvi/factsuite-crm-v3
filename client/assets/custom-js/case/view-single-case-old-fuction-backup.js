function data(){

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
            if(address.length > 0){
                for (var i = 0; i < address.length; i++) {
                    var errorMessage = 'This value was not enter by candidate.';
                    var pinCode = errorMessage
                    if(pin_code.length > i){
                        pinCode = pin_code[i].pincode
                    } 
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
                    html += '                  <input name="" readonly value="'+pinCode+'" class="fld form-control pincode" id="pincode" type="text">';
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
            }else{
                html += '         <div class="row">';
                html += '            <div class="col-md-12">';
                html += '               <h6 class="full-nam2">Incorrect details.</h6>';
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

    function document_check(data){ 
        console.log('document_check : '+JSON.stringify(data))
        $('#componentModal').modal('show')
        $('#modal-headding').html('Document Check')

        let html='';
        if(data.status != '0'){
           
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
            }else{
                html += '         <div class="row">';
                html += '            <div class="col-md-12">';
                html += '               <h6 class="full-nam2">Incorrect Data</h6>';
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
            if(candidate_name.length > 0){
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
            }else{
                html += '         <div class="row">';
                html += '            <div class="col-md-12">';
                html += '               <h6 class="full-nam2">Incorrect Data</h6>';
                html += '            </div>';
                html += '         </div>'; 
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
        // alert(data.component_data.length)
        if(data.status != '0'){
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
            html += '               <div class="pg-frm-hd">Experience Relieving Letter</div>';
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
            html += '               <div class="pg-frm-hd">Last Month Pay Slip</div>';
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
            html += '               <div class="pg-frm-hd">Bank statement Resigngation Acceptance</div>';
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
        }else{
            html += '         <div class="row">';
            html += '            <div class="col-md-12">';
            html += '               <h6 class="full-nam2">Data is not submited yet.</h6>';
            html += '            </div>';
            html += '         </div>';
            }
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

                  var all_sem_marksheet = JSON.parse(data.component_data.all_sem_marksheet); 
                  var convocation = JSON.parse(data.component_data.convocation);
                  var marksheet_provisional_certificate = JSON.parse(data.component_data.marksheet_provisional_certificate);
                  var ten_twelve_mark_card_certificate = JSON.parse(data.component_data.ten_twelve_mark_card_certificate)
                  
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


                      html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd">all sem marksheet</div>';
            // alert(all_sem_marksheet[i])
                if(all_sem_marksheet[i] != null && all_sem_marksheet[i] != '' && all_sem_marksheet[i].length > 0){
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


            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd">degree convocation/ transcript of records</div>';
             if(convocation[i] != null || convocation[i] != ''){
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



            html += '<div class="col-md-3">';
            html += '<div class="pg-frm-hd">consolidate marksheet/ provisional degree certificate</div>';
             if(marksheet_provisional_certificate[i] != null || marksheet_provisional_certificate[i] != ''){
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


             html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd">10th / 12th mark card/ course completion certificate <span>(optional)</span></div>';
             if(ten_twelve_mark_card_certificate[i] != null || ten_twelve_mark_card_certificate[i] != ''){
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
     
                    html += '         <hr>'; 
                    
                    html += '      </div>';
                    html += '   </div>';
                }
          /*  html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
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
                            
            html += '            </div>';
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd">degree convocation/ transcript of records</div>';
             if(data.component_data.convocation != null || data.component_data.convocation != ''){
                        var convocationDoc = data.component_data.convocation;
                        var convocationDoc = convocationDoc.split(",");
                        for (var i = 0; i < convocationDoc.length; i++) {
                            var url = img_base_url+"../uploads/convocation-docs/"+convocationDoc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(convocationDoc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocationDoc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+convocationDoc[i]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(convocationDoc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocationDoc[i]+'</li>'
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
            html += '               <div class="pg-frm-hd">consolidate marksheet/ provisional degree certificate</div>';
             if(data.component_data.marksheet_provisional_certificate != null || data.component_data.marksheet_provisional_certificate != ''){
                        var marksheet_provisional_certificateDoc = data.component_data.marksheet_provisional_certificate;
                        var marksheet_provisional_certificateDoc = marksheet_provisional_certificateDoc.split(",");
                        for (var i = 0; i < marksheet_provisional_certificateDoc.length; i++) {
                            var url = img_base_url+"../uploads/marksheet-certi-docs/"+marksheet_provisional_certificateDoc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(marksheet_provisional_certificateDoc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+marksheet_provisional_certificateDoc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+marksheet_provisional_certificateDoc[i]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(marksheet_provisional_certificateDoc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0  text-wrap">'+marksheet_provisional_certificateDoc[i]+'</li>'
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
            html += '               <div class="pg-frm-hd">10th / 12th mark card/ course completion certificate <span>(optional)</span></div>';
             if(data.component_data.ten_twelve_mark_card_certificate != null || data.component_data.ten_twelve_mark_card_certificate != ''){
                        var ten_twelve_mark_card_certificatetDoc = data.component_data.ten_twelve_mark_card_certificate;
                        var ten_twelve_mark_card_certificatetDoc = ten_twelve_mark_card_certificatetDoc.split(",");
                        for (var i = 0; i < ten_twelve_mark_card_certificatetDoc.length; i++) {
                            var url = img_base_url+"../uploads/ten-twelve-docs/"+ten_twelve_mark_card_certificatetDoc[i]
                            if ((/\.(jpg|jpeg|png)$/i).test(ten_twelve_mark_card_certificatetDoc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificatetDoc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+ten_twelve_mark_card_certificatetDoc[i]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(ten_twelve_mark_card_certificatetDoc[i])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificatetDoc[i]+'</li>'
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
            html += '         </div>';*/
            }else{
                html += '         <div class="row">';
                html += '            <div class="col-md-12">';
                html += '               <h6 class="full-nam2">Incorrect Data</h6>';
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

    function permanent_address(data){ 
        console.log('permanent_address : '+JSON.stringify(data))
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
                            // for loop will end 
                
                html += '            </div>';

                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm-hd">Upload ration card <span>(optional)</span></div>';
                 
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
                            // for loop will end    ration_card
                html += '            </div>';

                html += '            <div class="col-md-4">';
                html += '               <div class="pg-frm-hd">upload government utility bill <span>(optional)</span></div>';
                 
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
        var hr_contact_number =  JSON.parse(data.component_data.hr_contact_number);

         var appointment_letter = JSON.parse(data.component_data.appointment_letter);
        var experience_relieving_letter = JSON.parse(data.component_data.experience_relieving_letter);
        var last_month_pay_slip = JSON.parse(data.component_data.last_month_pay_slip);
        var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = JSON.parse(data.component_data.bank_statement_resigngation_acceptance);
        

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



              html += '         <div class="row mt-3">';
            html += '            <div class="col-md-3">';
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
            html += '            <div class="col-md-3">';
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
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd">Last Month Pay Slip</div>';
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
            html += '            <div class="col-md-3">';
            html += '               <div class="pg-frm-hd">Bank statement Resigngation Acceptance</div>';
             if(ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[i] != null || data.component_data.ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance != ''){
                        // var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = data[k].component_data.bank_statement_resigngation_acceptance;
                        // var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k].split("[k],");
                        for (var k = 0; k < ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[i].length; k++) {
                            var url = img_base_url+"../uploads/bank_statement_resigngation_acceptance/"+ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[i][k]
                            if ((/\.(jpg|jpeg|png)$/i).test(ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[i][k])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[i][k]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[i][k]+'" class="image-name-delete-a">';
                                html += '                                   <i class="fa fa-eye text-primary"></i>';
                                html += '                               </a>'; 
                                html += '                           </li>';
                                html += '                        </ul>';
                                html += '                   </div>';
                                html += '                 </div>';
                            }else if((/\.(pdf)$/i).test(ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[i][k])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[i][k]+'</li>'
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

            html += '   <hr>';
             
        } 
           /* html += '         <div class="row mt-3">';
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
            html += '               <div class="pg-frm-hd">Experience Relieving Letter</div>';
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
            html += '               <div class="pg-frm-hd">Last Month Pay Slip</div>';
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
            html += '               <div class="pg-frm-hd">Bank statement Resigngation Acceptance</div>';
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
            html += '         </div>';*/
            html += '         <div class="row">';
            html += '            <div class="col-md-12">';
            html += '               <div class="pg-submit text-right">';
            html += '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white mt-2">CLOSE</button>';
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

           var rental_agreement = JSON.parse(data.component_data.rental_agreement);
                var ration_card = JSON.parse(data.component_data.ration_card);
                var gov_utility_bill = JSON.parse(data.component_data.gov_utility_bill);
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




            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">rental agreement/ driving License</div>';
            // alert(data.component_data.rental_agreement) 
                if(rental_agreement[i] != null && rental_agreement[i] != 'no-file' ){
                        // var reantAgreementDoc = data.component_data.rental_agreement;
                        // var reantAgreementDoc = reantAgreementDoc.split(",");
                        for (var k = 0; k < rental_agreement[i].length; k++) {
                            var url = img_base_url+"../uploads/rental-docs/"+rental_agreement[i][k];
                            if ((/\.(jpg|jpeg|png)$/i).test(rental_agreement[i][k])){
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
                            }else if((/\.(pdf)$/i).test(rental_agreement[i][k])){
                                html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                                html += '                   <div class="image-selected-div">';
                                html += '                       <ul class="p-0 mb-0">';
                                html += '                           <li class="image-selected-name pb-0">'+rental_agreement[i][k]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
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
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Ration card</div>';
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
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Government utility bill</div>';
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
            html += '            </div>';
     
            html += '         </div>';

            html +='<hr>'
            }
            /*
            html += '         <div class="row mt-3">';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">rental agreement/ driving License</div>';
            // alert(data.component_data.rental_agreement)
                if(data.component_data.rental_agreement != null && data.component_data.rental_agreement != 'no-file' ){
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
                                html += '                           <li class="image-selected-name pb-0">'+govUtilityBillDoc[i]+'</li>'
                                html += '                           <li class="image-name-delete pb-0">';
                                html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
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
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Ration card</div>';
                if(data.component_data.ration_card != null && data.component_data.ration_card != 'no-file'){
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
            html += '            </div>';
            html += '            <div class="col-md-4">';
            html += '               <div class="pg-frm-hd">Government utility bill</div>';
                if(data.component_data.gov_utility_bill != null && data.component_data.gov_utility_bill != 'no-file'){
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
            html += '            </div>';
     
            html += '         </div>';*/
                 
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

    function view_docs_modal(url){ 
        // var image = $('#docs_modal_file'+documentName).data('view_docs');
        $('#view-image').attr("src",url);

        let html = '';
         
        html += '<a download class="btn bg-blu text-white" href="'+url+'">'
        html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
        html += '</a>';

        $('#setupDownloadBtn').html(html)
        $('#view_image_modal').modal('show');
    }

    function view_edu_docs_modal(url){ 
        // var image = $('#docs_modal_file'+documentName).data('view_docs');
        $('#view-image').attr("src", url);

        let html = '';
         
        html += '<a download class="btn bg-blu text-white" href="'+url+'">'
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
     
        $('#setupDownloadBtn').html(html)
        $('#view_image_modal').modal('show');
    }
      

    function view_personal_document_modal(documentName,folderName){ 
        var image = $('#docs_modal_file'+documentName).data('view_docs');
        $('#view-image').attr("src", img_base_url+"../uploads/"+folderName+"/"+image);

        let html = '';
         
        html += '<a download class="btn bg-blu text-white" href="'+img_base_url+"../uploads/"+folderName+"/"+image+'">'
        html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
        html += '</a>'; 
        $('#setupDownloadBtn').html(html)
        $('#view_image_modal').modal('show');
    }
}