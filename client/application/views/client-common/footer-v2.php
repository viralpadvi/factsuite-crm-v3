</div>
<?php $client_name = '';
  if ($this->session->userdata('logged-in-client')) {
    $client_name = strtolower($this->session->userdata('logged-in-client')['client_name']);
  } 
  $client_name = trim(str_replace(' ','-',$client_name));
  ?>

<!-- View Client Clarification Log Modal Starts -->
<div id="view-client-clarification-log-modal" class="modal fade custom-modal">
  <div class="modal-dialog modal-dialog-centered modal-xl">
     <div class="modal-content">
      <div class="modal-header border-0">
        <h4 class="modal-title-edit-coupon modal-title">Client Clarification Log List</h4>
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>
      <div class="modal-body modal-body-edit-coupon">
        <div class="modal-pending-bx">
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
            <!-- <button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Close</button> -->
          </div>
              
           <div class="clr"></div>
        </div>
      </div>
  </div>
</div>
<!-- View Client Clarification Log Modal Ends -->

<!-- View Client Clarification Log Details Modal Starts -->
<div class="modal fade candidate-details-modal custom-modal" id="view-client-clarification-log-details-modal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content modal-content-view-collection-category">
      <div class="modal-header">
        <h4 class="modal-title">Client Clarification Details</h4>
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>
      <div class="modal-body modal-body-edit-coupon">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h6 class="modal-contact-history-txt">Overview</h6>
                <div class="row">
                  <div class="col-md-12 ticket-subject">Subject : <span id="show-client-clarification-subject-modal">-</span></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">Description : <span id="show-client-clarification-description-modal">-</span></div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-4">
                    Status
                    <div id="show-client-clarification-status-modal" class="modal-show-ticket-status">-</div>
                    <div id="show-client-clarification-status-btn-modal"></div>
                  </div>
                  <div class="col-md-4">
                    Priority
                    <div id="show-client-clarification-priority-modal" class="modal-show-ticket-priority">-</div>
                  </div>
                  <div class="col-md-4">
                    Classifications
                    <div id="show-client-clarification-classification-modal" class="modal-show-ticket-classification">-</div>
                  </div>
                </div>
                <div class="row" id="raise-client-clarification-attached-modal-file-main-div"></div>
              </div>
            </div>
          </div>

          <div class="col-md-6 comments-div-2">
            <div class="card">
              <div class="card-body">
                <div class="chat-timeline chat-timeline-2">
                  <div class="timeline timeline-inverse" id="client-clarification-timeline-chat"></div>
                </div>
              </div>
              <div class="card-header">
                <textarea id="client_clarification_note_message" class="form-control ticket-comment-input" rows="1" placeholder="Leave a Note Here..."></textarea>
                <div id="note-message-error-msg-div"></div>
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-4">
                    <div class="mt-3 pb-3">
                      <button class="btn btn-transperant w-100" id="refresh-client-clarification-chat-btn">Refresh Chat</button>
                    </div>
                  </div>
                   <div class="col-md-4">
                    <div class="mt-3 pb-3">
                      <button class="btn btn-submit w-100" id="submit-client-clarification-new-note">Send</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
    
      </div>
    </div>
  </div>
</div>
<!-- View Client Clarification Log Details Modal Ends -->

  <!-- /.content-wrapper -->
  <footer class="main-footer text-center d-none">
    <strong>Copyright &copy; <?php echo date("Y");?> Factsuite. All rights reserved.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<!-- <script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script> -->
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
<!-- datepicker -->
<script src="<?php echo base_url()?>assets/client/lib/duDatepicker.min.js"></script>
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
<script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.js"></script>
<script>
  
  $('.only-time-12-hr-frmt').bootstrapMaterialDatePicker({
    // date: false,
    time: true,
    shortTime: true,
    format: 'HH:mm a'
  });

  $('#schedule-time-0').bootstrapMaterialDatePicker({
      date: false,
      // shortTime: false,
      shortTime: true,
      format: 'HH:mm',
    });

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
    $('#reservationdatetime').datetimepicker({icons: { time: 'far fa-clock' } });

    //Date range picker
    $('.reservation').daterangepicker({
      locale: {
        format: 'DD/MM/YYYY'
      }
    })
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'DD/MM/YYYY hh:mm A'
      }
    })

    $('.vkbjh').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'hh:mm A'
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
  $(this).closest("table").find(".collapse.in").not(this)
})
</script>
<script>
function add(ths,sno) {
  for (var i=1;i<=5;i++) {
    var cur = document.getElementById("star"+i),
        cur.className="fa fa-star";
  }

  for (var i=1;i<=sno;i++) {
    var cur=document.getElementById("star"+i);
    if(cur.className=="fa fa-star") {
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
  if ((window.location.pathname.indexOf($(this).attr('href'))) > -1) {
    $(this).parent().addClass('active');
  }
});

$(document).ready(function() {
  $('input, textarea').attr('spellcheck',true);
});

$('#pushmenu').on('click', function() {
  $('body').toggleClass("sidebar-collapse");
  $.ajax({
    type:'ajax',
    url: base_url+"sidebar/sidebar-toggle",
    dataType: 'JSON',
    success: function(data) {}
  });
});
</script>

<script type="text/javascript">
    

    window.onload = function () {
     var input = document.querySelector('#from-date-recievals1').addEventListener('datechanged', function(e) {
        console.log('New date', e.data, this.value)
      })
      

      duDatepicker('#from-date-recievals1', {
        format: 'd/mm/yyyy', range: true, clearBtn: true,
        // disabledDays: ['Sat', 'Sun'],
        events: {
          dateChanged: function (data) {
            // log('From: ' + data.dateFrom + '\nTo: ' + data.dateTo)
          },
          onRangeFormat: function (from, to) {
            var fromFormat = 'd/mm/yyyy', toFormat = 'd/mm/yyyy';

            if (from.getMonth() === to.getMonth() && from.getFullYear() === to.getFullYear()) {
              fromFormat = 'd/mm/yyyy'
              toFormat = 'd/mm/yyyy'
            } else if (from.getFullYear() === to.getFullYear()) {
              fromFormat = 'd/mm/yyyy'
              toFormat = 'd/mm/yyyy'
            }

            return from.getTime() === to.getTime() ?
              this.formatDate(from, 'd/mm/yyyy') :
              [this.formatDate(from, fromFormat), this.formatDate(to, toFormat)].join('-');
          }
        }
      });

      
 
      // duDatepicker('#daterange', 'setValue', 'August 2, 2020-August 5, 2020')
    }


    function get_required_list(page_url = false) {
      $(display_ui_id).html((typeof html !== 'undefined' && html !== 'undefined') ? html : '');
      var search_key = $("#search-key").val(),
          filter_cases_number = $('#filter-cases-number').val();

      if(page_url == false) {
        var page_url = base_url+site_url;
      }
      
      var formdata = new FormData();

      formdata.append('search_key',search_key);
      formdata.append('filter_cases_number',filter_cases_number);
      formdata.append('site_url',site_url);
      formdata.append('verify_client_request',1);

      <?php if (strtolower(uri_string()) == 'factsuite-client/all-cases' || strtolower(uri_string()) == $client_name.'/all-cases') { ?>
        formdata.append('case_list_request_type','all');
      <?php } else if (strtolower(uri_string()) == 'factsuite-client/insuff-cases' || strtolower(uri_string()) == $client_name.'/insuff-cases') { ?>
        formdata.append('case_list_request_type','insuff');
      <?php } else if (strtolower(uri_string()) == 'factsuite-client/client-clarification-cases' || strtolower(uri_string()) == $client_name.'/client-clarification-cases') { ?>
        formdata.append('case_list_request_type','client-clarification');
      <?php } ?>
      
      $.ajax({
        type: "POST",
        url: page_url,
        data: formdata,
        contentType: false,
        processData: false,
        success: function(response) {
          $(display_ui_id).html(response);
        }
      });
    }
  </script>
</body>
</html>