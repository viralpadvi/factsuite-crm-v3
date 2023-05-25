<!-- Common Validation -->
<script src="<?php echo base_url()?>assets/custom-js/common/common-validations.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
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
<!-- AdminLTE App -->
<!-- <script src="<?php //echo base_url()?>assets/dist/js/adminlte.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php// echo base_url()?>assets/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php //echo base_url()?>assets/dist/js/demo.js"></script> -->
<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>

<script src="<?php echo base_url()?>assets/admin/js/jquery.mousewheel.js"></script>
<!-- <script src="<?php echo base_url()?>assets/custom-js/common/common-field-validations.js"></script> -->
<script>
  $('.select2').select2({
  // minimumInputLength: 3 // only start searching when the user has input 3 or more characters
});
</script>
<script>
   jQuery(function ($) {
    $.fn.hScroll = function (amount) {
        amount = amount || 120;
        $(this).bind("DOMMouseScroll mousewheel", function (event) {
            var oEvent = event.originalEvent, 
                direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta, 
                position = $(this).scrollLeft();
            position += direction > 0 ? -amount : amount;
            $(this).scrollLeft(position);
            event.preventDefault();
        })
    };
});

$(document).ready(function() {
    $('#milestones').hScroll(60); // You can pass (optionally) scrolling amount
});
$(document).ready(function() {
    $('#course2').hScroll(60); // You can pass (optionally) scrolling amount
});
$(document).ready(function() {
    $('#course3').hScroll(60); // You can pass (optionally) scrolling amount
});
</script>
<script>
  $('.select2').select2({
  // minimumInputLength: 3 // only start searching when the user has input 3 or more characters
});
</script>

<!-- DataTables -->
<script src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $('.datatable').DataTable({
      "scrollY":"500px",
      "scrollCollapse": true,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
<!-- datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.js"></script>
<script>
  $('.mdate').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY'
  });
  $('.date-min-today').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY',
    minDate: moment()
  });

  $('.date-for-vendor-aggreement-end-date').bootstrapMaterialDatePicker({
    weekStart: 0,
    time: false,
    // format: 'YYYY-MM-DD'
    format: 'DD-MM-YYYY'
  });

  $('.date-for-vendor-aggreement-start-date').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY',
    minDate: moment()
  }).on('change', function(e, date) {
    $('.date-for-vendor-aggreement-end-date').bootstrapMaterialDatePicker('setMinDate', date);
  });
   var max_dob_date = new Date();
  max_dob_date.setTime(max_dob_date.valueOf() - 10 * 365 * 24 * 60 * 60 * 1000);

  $('.dob-date').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY',
    maxDate : max_dob_date 
  });

$('.only-year').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    format: 'YYYY',
    maxDate : moment()
  });

$('.date-for-candidate-aggreement-end-date').bootstrapMaterialDatePicker({
    weekStart: 0,
    time: false,
    // format: 'YYYY-MM-DD'
    format: 'DD-MM-YYYY'
  });

  $('.date-for-candidate-aggreement-start-date').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY',
    // minDate: moment()
  }).on('change keyup click focus', function(e, date) {
    $('.date-for-candidate-aggreement-end-date').bootstrapMaterialDatePicker('setMinDate', date);
  });
</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="<?php echo base_url(); ?>assets/admin/js/jquery-3.4.1.slim.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/admin/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>
<script language="javascript">
n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
// document.getElementById("FS-date").innerHTML = d + "/" + m + "/" + y;
</script>
<script language="javascript">
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    // add a zero in front of numbers<10
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('FS-time').innerHTML = h + ":" + m + ":" + s;
    t = setTimeout(function () {
        startTime()
    }, 500);
}
// startTime();
</script>
<script>
$("#file1").change(function(){
  $(".file-name1").text(this.files[0].name);
});
</script>
<script>
$('.accordian-body').on('show.bs.collapse', function () {
    $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        //.collapse('toggle')
})
</script>
<script>
function add(ths,sno){


for (var i=1;i<=5;i++){
var cur=document.getElementById("star"+i)
cur.className="fa fa-star"
}

for (var i=1;i<=sno;i++){
var cur=document.getElementById("star"+i)
if(cur.className=="fa fa-star")
{
cur.className="fa fa-star checked"
}
}

}
</script>
<script>
$(".side-mn > ul li a").each(function() {
    //console.log($(this).attr('href'));
    if ((window.location.pathname.indexOf($(this).attr('href'))) > -1) {
        $(this).parent().addClass('active');
    }
});

$(document).ready(function() {
    // $('input, textarea').spellAsYouType();
    $('input, textarea').attr('spellcheck',true);
});
</script>

<!--  -->  
<!--  -->
</body>
</html>