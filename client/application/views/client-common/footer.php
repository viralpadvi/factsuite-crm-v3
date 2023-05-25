<!-- View Client Clarification Log Modal Starts -->
<div id="view-client-clarification-log-modal" class="modal fade">
  <div class="modal-dialog modal-dialog-centered modal-xl">
     <div class="modal-content">
     <!-- <div class="modal-lg"> -->
        <div class="modal-pending-bx">
          <h3 class="snd-mail-pop">Client Clarification Log List</h3>
          <div class="table-responsive mt-3" id="">
            <table class="table table-striped">
              <thead class="thead-bd-color">
                <tr>
                  <th>Sr No.</th>
                  <th>Subject</th>
                  <th>Status</th>
                  <th>Created Date</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody class="tbody-datatable" id="client-clarification-log-list"></tbody>
            </table>
          </div>
          <div id="btnOverrideDiv">
            <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Close</button>                  
          </div>
              
           <div class="clr"></div>
        </div>
     </div>
  </div>
</div>
<!-- View Client Clarification Log Modal Ends -->

<!-- View Client Clarification Log Details Modal Starts -->
<div class="modal fade candidate-details-modal" id="view-client-clarification-log-details-modal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content modal-content-view-collection-category">
      <div class="modal-header border-0">
        <h4 class="modal-title-edit-coupon">Client Clarification Details</h4>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body modal-body-edit-coupon">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h6 class="modal-contact-history-txt">Client Clarification Details</h6>
                <div class="row">
                  <div class="col-md-5">Status</div>
                  <div class="col-md-4" id="show-client-clarification-status-modal">-</div>
                  <div class="col-md-3" id="show-client-clarification-status-btn-modal"></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-5">Priority</div>
                  <div class="col-md-7" id="show-client-clarification-priority-modal">-</div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-5">Classifications</div>
                  <div class="col-md-7" id="show-client-clarification-classification-modal">-</div>
                </div>
                <div class="row" id="raise-client-clarification-attached-modal-file-main-div">
                  <div class="col-md-4">Classifications</div>
                  <div class="col-md-8" id="show-client-clarification-classification-modal">-</div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">Subject :</div>
                  <div class="col-md-12" id="show-client-clarification-subject-modal">-</div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">Description :</div>
                  <div class="col-md-12" id="show-client-clarification-description-modal">-</div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 comments-div">
            <div class="card">
              <div class="card-header">
                <h4><i class="fa fa-pencil"></i> New Note</h4>
                <hr>
                <textarea id="client_clarification_note_message" class="form-control" placeholder="Leave a note" rows="4"></textarea>
                <div id="client-clarification-note-message-error-msg-div"></div>
                <div class="row">
                  <div class="col-md-10"></div>
                  <div class="col-md-2">
                    <div class="text-right pr-4 mt-3 pb-3">
                      <button class="btn btn-comment" id="submit-client-clarification-new-note">Send</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body chat-timeline">
                <div class="extra-border">
                  <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                      <div class="text-right mt-2 pb-3">
                        <button class="btn btn-comment" id="refresh-client-clarification-chat-btn">Refresh Chat</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="timeline timeline-inverse" id="client-clarification-timeline-chat"></div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    
      </div>
    </div>
  </div>
</div>
<!-- View Client Clarification Log Details Modal Ends -->

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url()?>assets/custom-js/common-validation.js"></script>
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
 
<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>
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
    minDate: moment(),
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY'
  });

   $('.date-max-today').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    // format: 'DD-MM-YYYY',
    format: 'DD-MM-YYYY',
    maxDate: moment()
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
</script>
<script>
  var max_dob_date = new Date();
  max_dob_date.setTime(max_dob_date.valueOf() - 16 * 365 * 24 * 60 * 60 * 1000);

  $('.dob-date').bootstrapMaterialDatePicker({ 
    weekStart: 0, 
    time: false,
    // format: 'YYYY-MM-DD',
    format: 'DD-MM-YYYY',
    maxDate : max_dob_date 
  });


     //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('.reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'DD/MM/YYYY hh:mm A'
      }
    })
</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="<?php echo base_url(); ?>assets/client/js/jquery-3.4.1.slim.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/client/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/client/js/bootstrap.min.js"></script>
<script language="javascript">
// n =  new Date();
// y = n.getFullYear();
// m = n.getMonth() + 1;
// d = n.getDate();
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
$("#CheckAll").click(function () {
    $(".custom-control-input").prop('checked', $(this).prop('checked'));
});
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
</body>
</html>