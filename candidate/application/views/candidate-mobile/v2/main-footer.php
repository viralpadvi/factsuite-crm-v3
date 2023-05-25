	<script src="<?php echo base_url()?>assets/custom-js/common-validations.js"></script>

	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- <script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<!-- <script src="assets/js/popper.min.js"></script> -->
  	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
	<!-- <script src="assets/js/bootstrap.min.js"></script> -->
	<script src="<?php echo base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
 
	<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
	<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment-with-locales.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.js"></script>

	<script>
	    var max_dob_date = new Date();
	        max_dob_date.setTime(max_dob_date.valueOf() - 16 * 365 * 24 * 60 * 60 * 1000);
	  
	    $('.mdate').bootstrapMaterialDatePicker({ 
	        maxDate: max_dob_date,
	        weekStart: 0, 
	        time: false, 
	        format: 'YYYY-MM-DD',
	    });
	  
	    $('.date-min-today').bootstrapMaterialDatePicker({ 
	        weekStart: 0, 
	        time: false,
	        format: 'YYYY-MM-DD',
	        minDate: moment()
	    });
	    
	    $('.date-for-candidate-aggreement-end-date').bootstrapMaterialDatePicker({
	        weekStart: 0,
	        time: false,
	        format: 'YYYY-MM-DD'
	    });

	    $('.date-for-candidate-aggreement-start-date').on('change', function() {
	        $('.date-for-candidate-aggreement-end-date').val('');
	    });

	    $('.date-for-candidate-aggreement-start-date').bootstrapMaterialDatePicker({ 
	        weekStart: 0, 
	        time: false,
	        format: 'YYYY-MM-DD',
	        // minDate: moment()
	    }).on('change keyup click focus', function(e, date) {
	        var minDate = new Date(date);
	        minDate.setDate(minDate.getDate() + 1);
	        $('.date-for-candidate-aggreement-end-date').bootstrapMaterialDatePicker('setMinDate', minDate);
	    });

	    $('.multi-form-date-for-candidate-aggreement-end-date').bootstrapMaterialDatePicker({
	        weekStart: 0,
	        time: false,
	        format: 'YYYY-MM-DD'
	    });

	    $('.multi-form-date-for-candidate-aggreement-start-date').on('change', function() {
	        var id = $(this).attr('id'),
	            form_number = id.split('-').pop();
	        $('#relieving-date-'+form_number).val('');
	    });

	    $('.multi-form-date-for-candidate-aggreement-start-date').bootstrapMaterialDatePicker({ 
	        weekStart: 0, 
	        time: false,
	        format: 'YYYY-MM-DD',
	        // minDate: moment()
	    }).on('change keyup click focus', function(e, date) {
	        var minDate = new Date(date);
	        minDate.setDate(minDate.getDate() + 1);
	        $('.multi-form-date-for-candidate-aggreement-end-date').bootstrapMaterialDatePicker('setMinDate', minDate);
	    });

	    $('.date-for-candidate-aggreement-start-date-new').bootstrapMaterialDatePicker({ 
	        weekStart: 0, 
	        time: false,
	        format: 'YYYY-MM-DD',
	        minDate: moment()
	    }).on('change keyup click focus', function(e, date) {
	        var minDate = new Date(date);
	        minDate.setDate(minDate.getDate() + 1);
	        $('.date-for-candidate-aggreement-end-date').bootstrapMaterialDatePicker('setMinDate', minDate);
	    });
	 
	    $('.date-for-joining-date').bootstrapMaterialDatePicker({ 
	        weekStart: 0, 
	        time: false,
	        format: 'YYYY-MM-DD',
	        maxDate:moment()
	    }).on('change keyup click focus', function(e, date) {
	        $('.date-for-relieving-date').bootstrapMaterialDatePicker('setMinDate', date);
	    });

	    $('.date-for-relieving-date').bootstrapMaterialDatePicker({
	        weekStart: 0,
	        time: false,
	        format: 'YYYY-MM-DD',
	        maxDate:moment()
	    });

	    $(document).ready(function() {
	        // $('input, textarea').spellAsYouType();
	        $('input, textarea').attr('spellcheck',true);
	    });
	</script>

	<script>
		$('body').on('click', function() {
			$('body').removeClass('bg-black-body');
			$('#dropdown-menu').removeClass('show');
		});

		$('#dropdown-hdr-btn').on('click', function() {
			setTimeout(function() { 
				$('body').addClass('bg-black-body');
				$('#dropdown-menu').addClass('show');
			}, 10);
		});
	</script>


	
</body>
</html>