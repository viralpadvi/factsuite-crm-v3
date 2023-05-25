</section>

<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url()?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url()?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url()?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url()?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url()?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url()?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
 
<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>
<script>
  $('.select2').select2({
  // minimumInputLength: 3 // only start searching when the user has input 3 or more characters
});
</script>

<script src="<?php echo base_url()?>assets/custom-js/common-validations.js"></script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.4.1.slim.min.js">d</script> -->
<script src="<?php echo base_url(); ?>assets/mobile/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datepicker.min.js"></script>
<script type="text/javascript">
    $('#timepicker').timepicker({
		format: 'hh:MM:TT'
        });
</script>
<script type="text/javascript">
    $('#timepicker0').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker1').timepicker({
		format: 'hh:MM:TT'
        });
     $('#timepicker2').timepicker({
    format: 'hh:MM:TT'
        });

    $('.reference-start-time').timepicker({
        format: 'hh:MM:TT'
    });

    $('.reference-end-time').timepicker({
        format: 'hh:MM:TT'
    });
</script>

<script type="text/javascript">
    $('#timepicker3').timepicker({
    format: 'hh:MM:TT'
        });
</script>
<script type="text/javascript">
    $('#timepicker4').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker5').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker6').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker7').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker8').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker9').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker10').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker11').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker12').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker13').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker14').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker15').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker16').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker17').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker18').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker19').timepicker({
    format: 'hh:MM:TT'
        });
    $('#timepicker20').timepicker({
    format: 'hh:MM:TT'
        });
     $('#timepicker21').timepicker({
    format: 'hh:MM:TT'
        });
      $('#timepicker22').timepicker({
    format: 'hh:MM:TT'
        });
       $('#timepicker23').timepicker({
    format: 'hh:MM:TT'
        });
        $('#timepicker24').timepicker({
    format: 'hh:MM:TT'
        });
         $('#timepicker25').timepicker({
    format: 'hh:MM:TT'
        });
</script>
<script>
/*$("#file1").change(function(){ 
  $(".file-name1").text(this.files[0].name);
});
$("#file2").change(function(){
  $(".file-name2").text(this.files[0].name);
});
$("#file3").change(function(){
  $(".file-name3").text(this.files[0].name);
});
$("#file4").change(function(){
  $(".file-name4").text(this.files[0].name);
});*/
</script>
<!-- datepicker -->
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
/*
  $('.end-date').bootstrapMaterialDatePicker({
   weekStart: 0, 
    time: false,
    format: 'YYYY-MM-DD',
  });

  $('.start-date').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    format: 'YYYY-MM-DD',
  }) 
*/ 
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
</body>
</html>