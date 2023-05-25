var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mobile_number_length = 10;


function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}


function btn_disabled(input_id) {
	$(input_id).removeAttr('onclick');
	$(input_id).removeAttr('onclick');
}

function btn_enabled(input_id) {
	$(input_id).attr("onclick","add_new_vendor()");
	$(input_id).attr("onclick","cancel_add_new_vedor()");
}


function checkMobileNumerExits(url,number){
	var isUniq = ''; 
	$candidate_id = $('#candidate_id').val();
	$.ajax({
	  type: 'POST',
	  async: false,
	  url: base_url+url,
	  data: {
	  	number : number,
	  	candidate_id:$candidate_id
	  },
	  dataType:'json',
	  success: function(data) {
	  	// JSON.parse()
	  	if (data.status == '1') {
	  		isUniq = true;
	  	}else{
	  		isUniq = false;
	  	}
	  }
	});
	 
	return isUniq;
}