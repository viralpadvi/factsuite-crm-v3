<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Common Validation -->
<script src="<?php echo base_url()?>assets/custom-js/common/common-validations.js"></script>

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
<script src="<?php echo base_url()?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url()?>assets/dist/js/pages/dashboard.js"></script>
<script src="<?php echo base_url()?>assets/dist/js/demo.js"></script>
<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>
<script>
  $('.select2').select2({
  // minimumInputLength: 3 // only start searching when the user has input 3 or more characters
});
</script>

<!-- DataTables  & Plugins -->
<script src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false, "lengthChange": true, "autoWidth": true,
      "buttons": ["csv", "excel", "pdf"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<!-- DataTables -->
<!-- <script src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script> -->
<!-- <script src="<?php echo base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> -->
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

$('.select2').select2({
  // minimumInputLength: 3 // only start searching when the user has input 3 or more characters
});

$('.location').select2({
        allowClear: true,
        escapeMarkup: function (markup) { return markup; },
        placeholder: "Search a Location.",
        language: {
            noResults: function () {
              $(".select2-results__options").show();
              var typed = $('.select2-search__field').val();
                 return "<label>"+typed+"</label><a class='btn btn-small btn-success' onclick='add_location(\""+typed+"\")'> Add</a>";
            }
        }
    }); 


$('.segments').select2({
        allowClear: true,
        escapeMarkup: function (markup) { return markup; },
        placeholder: "Search a Segment.",
         containerCssClass: "get-select-2_value",
         
        language: {
            noResults: function () { 
              $("#select2-segment-results").show();
               var typed = '';
               $('.select2-search__field').each(function(){
                if ($(this).val()!='' && $(this).val()!=null) {
                  typed = $(this).val();
                }
               })
                 return "<label>"+typed+"</label><a class='btn btn-small btn-success' onclick='add_segment(\""+typed+"\")'> Add</a>";
            }
        }
    }) 
 
$('.multi-select').select2({
  // minimumInputLength: 3 // only start searching when the user has input 3 or more characters
});
</script>
<!-- datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.js"></script>
<script>

  $('.multidate').bootstrapMaterialDatePicker({
  weekStart: 0, 
    time: false,
    format: 'YYYY-MM-DD',
});

  $('.mdate').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    format: 'YYYY-MM-DD',
    // format: 'DD-MM-YYYY'
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


  $('.date-for-analytics-end-date').bootstrapMaterialDatePicker({
    weekStart: 0,
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY',
    maxDate: moment(),
  });

  $('.holiday').bootstrapMaterialDatePicker({
    weekStart: 0,
    time: false,
    format: 'YYYY-MM-DD',
    minDate: moment(), 
  });

  $('.schedule-time').bootstrapMaterialDatePicker({
    weekStart: 0,
    time: false,
    format: 'YYYY-MM-DD',
    minDate: moment(), 
  });

  $('.date-for-analytics-start-date').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY',
    maxDate: moment()
  }).on('change', function(e, date) {
    $('.date-for-analytics-end-date').bootstrapMaterialDatePicker('setMinDate', date);
  });

  $('.timepicker-12-hr').bootstrapMaterialDatePicker({
    date: false,
    format: 'hh:mm a' 
  });

  $('.timepicker-24-hr').bootstrapMaterialDatePicker({
    date: false,
    format: 'HH:mm' 
  });
</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="<?php echo base_url(); ?>assets/admin/js/jquery-3.4.1.slim.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/admin/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>
<!-- <script language="javascript">
const n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
document.getElementById("FS-date").innerHTML = d + "/" + m + "/" + y;
</script> -->
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

<script>
$("#CheckAll").click(function () {
    $(".custom-control-input").prop('checked', $(this).prop('checked'));
});

// $('#timepicker').datetimepicker({
//   format: 'h:m A'
// });

$('.add_time').datetimepicker({
   datepicker:false,
   formatTime:"h:i a",

});
</script>
<!--  -->  
<!--  -->
</body>
</html>