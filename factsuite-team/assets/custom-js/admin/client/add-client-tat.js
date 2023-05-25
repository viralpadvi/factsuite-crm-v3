var flag = 1;
 
function allow_only_number(id,value){
	 $('#'+id).keydown(function(e)
        {

            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
}

function daysVaidation(id,value,type){
	var error = '';
	if(value <= 0){
		flag =1
		error ='<span class="text-danger error-msg-small">Please enter minimum 1 days.</span>'
	}else if(value > 365){
		flag = 1
		error = error ='<span class="text-danger error-msg-small">Not allow more then 365 days.</span>'
	}else{
		flag = 0
	}
	$('#'+type+'-priority-day-error').html(error)
}


function percentageVaidation(id,value,type){
	var error = '';
	if(value > 100){
		flag = 1
		error = error ='<span class="text-danger error-msg-small">Not allow more then 100 percentage.</span>'
	}else{
		flag = 0
	}
	$('#'+type+'-priority-percentage-error').html(error)
}
// getTatData();
$("#client_id").trigger('change')
function getTatData(client_id){
	if (client_id =='') {
		client_id = $("#client_id").val();
	}
	$.ajax({
		type:'POST',
		dataType:'json',
		url:base_url+"client/getClientTatData",
		data:{
			client_id:client_id
		},
		success:function(data){ 
			$('#low-percentage').val(data.low_priority_percentage)
			$('#low-days').val(data.low_priority_days)
			$('#medium-percentage').val(data.medium_priority_percentage)
			$('#medium-days').val(data.medium_priority_days)
			$('#high-percentage').val(data.high_priority_percentage)
			$('#high-days').val(data.high_priority_days)
		} 
	});
}

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtion").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	updateClientTat()
	      	return false;
	    }
	}
});


function confirmationDailg(){
	var low_priority_percentage = $('#low-percentage').val()
	var low_priority_days = $('#low-days').val()
	var medium_priority_percentage = $('#medium-percentage').val()
	var medium_priority_days = $('#medium-days').val()
	var high_priority_percentage = $('#high-percentage').val()
	var high_priority_days = $('#high-days').val()
	var client_id = $('#client_id').val()
	if(client_id != '' & client_id != null){
		if( low_priority_percentage != ''&& low_priority_days !='' && medium_priority_days != '' &&
		 medium_priority_percentage != '' && high_priority_days != '' && high_priority_percentage != '' ){
			$('#conformtion').modal('show');
		}else{
			// toastr.error('Something went wrong while save this data. Please try again.');   
			toastr.error('Please enter all data.');   
		}
	}else{
		$('#select-client-error').html('<span class="text-danger error-msg-small">Please select client.</span>')
	}
	
} 

function updateClientTat(){ 
	 
	var low_priority_percentage = $('#low-percentage').val()
	var low_priority_days = $('#low-days').val()
	var medium_priority_percentage = $('#medium-percentage').val()
	var medium_priority_days = $('#medium-days').val()
	var high_priority_percentage = $('#high-percentage').val()
	var high_priority_days = $('#high-days').val()
	var client_id = $('#client_id').val()
	if(client_id != '' && client_id != null){
		if( low_priority_percentage != ''&& low_priority_days !='' && medium_priority_days != '' &&
		 medium_priority_percentage != '' && high_priority_days != '' && high_priority_percentage != '' ){


		 	$.ajax({
			type:'POST',
			dataType:'json',
			url:base_url+"client/updateClientTat",
			data:{
				low_priority_percentage:low_priority_percentage,
				low_priority_days:low_priority_days,
				medium_priority_percentage:medium_priority_percentage,
				medium_priority_days:medium_priority_days,
				high_priority_percentage:high_priority_percentage,
				high_priority_days:high_priority_days,
				client_id:client_id
			},
			success:function(data){ 
				$('#conformtion').modal('hide');
				toastr.success('successfully update')
				$('#low-percentage').val('')
				$('#low-days').val('')
				$('#medium-percentage').val('')
				$('#medium-days').val('')
				$('#high-percentage').val('')
				$('#high-days').val('')
				$('#client_id').val('')
				sessionStorage.clear();
				if (client_id != '') {
					window.location.href = base_url+'factsuite-admin/send-credentials-to-client-spoc-page?client_id='+client_id;
				} else {
					window.location.href = base_url+'factsuite-admin/add-new-client';
				}
			} 
			}); 

		}else{
			// toastr.error('Something went wrong while save this data. Please try again.');   
			toastr.error('Please Enter Valid Data.');   
		}
	}else{
		toastr.error('Please select client.');
	}

}

// add final client data with TAT

function insertClientTat(){ 





	var client_name = sessionStorage.getItem("client_name");
	var client_address = sessionStorage.getItem("client_address");
	var client_city = sessionStorage.getItem("client_city");
	var client_state = sessionStorage.getItem("client_state");
	var client_industry = sessionStorage.getItem("client_industry");
	var other_industry = sessionStorage.getItem("other_industry");
	var client_website = sessionStorage.getItem("client_website");
	var master_account = sessionStorage.getItem("master_account");
	var account_manager = sessionStorage.getItem("account_manager");
	var manager_email = sessionStorage.getItem("manager_email");
	var manager_contact = sessionStorage.getItem("manager_contact");
	var package = sessionStorage.getItem("package_id");
	var spo_name = sessionStorage.getItem("spo_name");
	var spo_email = sessionStorage.getItem("spo_email");
	var spo_contact = sessionStorage.getItem("spo_contact");
	var communications = sessionStorage.getItem("communications");
	var zip = sessionStorage.getItem("zip");
	var is_master = sessionStorage.getItem("is_master");
	var client_docs = sessionStorage.getItem("client_docs");
	var package_components = JSON.parse(sessionStorage.getItem("package_components"));
	var country = sessionStorage.getItem("country");

	var alacart = sessionStorage.getItem("alacarte_component"); //JSON.parse(sessionStorage.getItem("alacarte")); 


	 
	var low_priority_percentage = $('#low-percentage').val()
	var low_priority_days = $('#low-days').val()
	var medium_priority_percentage = $('#medium-percentage').val()
	var medium_priority_days = $('#medium-days').val()
	var high_priority_percentage = $('#high-percentage').val()
	var high_priority_days = $('#high-days').val()
	var client_id = $('#client_id').val()
	 
		if(package_components.length !=0 && low_priority_percentage != ''&& low_priority_days !='' && medium_priority_days != '' &&
		 medium_priority_percentage != '' && high_priority_days != '' && high_priority_percentage != '' ){

		  
	var formdata = new FormData();

	formdata.append('low_priority_percentage',low_priority_percentage);
	formdata.append('low_priority_days',low_priority_days);
	formdata.append('medium_priority_days',medium_priority_days);
	formdata.append('medium_priority_percentage',medium_priority_percentage);
	formdata.append('high_priority_days',high_priority_days);
	formdata.append('high_priority_percentage',high_priority_percentage);
	//

	formdata.append('client_name',client_name);
	formdata.append('client_address',client_address);
	formdata.append('client_city',client_city);
	formdata.append('client_state',client_state);
	formdata.append('client_industry',client_industry);
	formdata.append('other_industry',other_industry);
	formdata.append('client_website',client_website);
	formdata.append('master_account',master_account);
	formdata.append('account_manager',account_manager);
	formdata.append('manager_email',manager_email);

	formdata.append('manager_contact',manager_contact);
	formdata.append('package',package);
	formdata.append('spo_name',spo_name);
	formdata.append('spo_email',spo_email);
	formdata.append('spo_contact',spo_contact);
	formdata.append('communications',communications);
	formdata.append('zip',zip);
	if (is_master !=null && is_master =='1') {
		formdata.append('is_master',is_master);
	}
	formdata.append('package_components',JSON.stringify(package_components));
	formdata.append('alacarte_components',alacart); 


	formdata.append('country',country);

	 
			formdata.append('client_docs', client_docs);

			$("#client-submit-btn").html('<div class="spinner-border spinner-border-sm text-success" role="status"><span class="sr-only">Loading...</span></div> Submitting..');
			$("#client-submit-btn").prop('disabled',true);

			$("#package-component-error").html('<span class="text-warning error-msg-small">Please wait while we are updating the data.</span>');
	 

	 $.ajax({
            type: "POST",
              url: base_url+"client/insert_client/",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
                if (data.status == '1') {  
                	toastr.success('New add client has been successfully.');
                		$("#package-component-error").html('<span class="text-success error-msg-small">New client has been successfully Added.</span>'); 

                	sessionStorage.clear(); 
                	window.location.href = base_url+'factsuite-admin/add-new-client';
                }else{ 
                	$("#package-component-error").html("");
                	toastr.error('Something went wrong while add client. Please try again.'); 
                }  

                $("#client-submit-btn").prop('disabled',true);
                $("#client-submit-btn").html('SAVE');
              }
          }); 


		 	/*$.ajax({
			type:'POST',
			dataType:'json',
			url:base_url+"client/updateClientTat",
			data:{
				low_priority_percentage:low_priority_percentage,
				low_priority_days:low_priority_days,
				medium_priority_percentage:medium_priority_percentage,
				medium_priority_days:medium_priority_days,
				high_priority_percentage:high_priority_percentage,
				high_priority_days:high_priority_days,
				client_id:client_id
			},
			success:function(data){ 
				$('#conformtion').modal('hide');
				toastr.success('successfully update')
				$('#low-percentage').val('')
				$('#low-days').val('')
				$('#medium-percentage').val('')
				$('#medium-days').val('')
				$('#high-percentage').val('')
				$('#high-days').val('')
				$('#client_id').val('')
			} 
			}); */

		}else{
			// toastr.error('Something went wrong while save this data. Please try again.');   
			toastr.error('Please Enter Valid Data.');   
		}
	 

}