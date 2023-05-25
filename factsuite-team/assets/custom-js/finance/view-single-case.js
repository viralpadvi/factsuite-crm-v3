$(function () {
  $("#payment-status-date").datepicker();
});
function load_case(candidate_id) {
  sessionStorage.clear();
  $.ajax({
    type: "POST",
    url:
      base_url +
      "adminViewAllCase/getSingleAssignedCaseDetails/" +
      candidate_id,
    dataType: "json",
    success: function (all_data) {
      let html = "",
        data = all_data.candidate_details,
        selected_datetime_format = all_data.selected_datetime_format;
      if (data.length > 0) {
        var j = 1;
        
        $("#candidate-id").val(data[0]["candidate_id"]);
        $("#caseId").html(data[0]["candidate_id"]);
        $("#candidateName").html(data[0]["first_name"]);
        $("#clientName").html(data[0]["client_name"]);
        $("#camdidatephoneNumber").html(data[0]["phone_number"]);
        $("#packageName").html(data[0]["package_name"]);
        $("#camdidateEmailId").html(data[0]["email_id"]);
        $("#tatTotalDays").html(data[0]["left_tat_days"]);
        $("#tatStartDays").html(get_date_formate(data[0]["tat_start_date"]));
        $("#tatEndDays").html(get_date_formate(data[0]["tat_end_date"]));
        $("#tatPauseDays").html(get_date_formate(data[0]["tat_pause_date"]));
        $("#tatReStartDays").html(
          get_date_formate(data[0]["tat_re_start_date"])
        );

        payment_status = data[0]["candidate_details"]["payment_status"];
        payment_date = data[0]["candidate_details"]["payment_date"];
        console.log("payment_status:" + payment_status + " || " + payment_date);
        var pending = "";
        var clear = "";
        var payment_status_date = "-";
        var status_selected = "";
        if (payment_status == "0") {
          pending = "selected";
        } else if (payment_status == "1") {
          clear = "selected";
          payment_status_date = payment_date;
        } else {
          status_selected = "selected";
        }
        paymentStatus = "";
        paymentStatus +=
          '<select id="action_payment_status" name="payment_status" class="sel-finance-allcase">';
        paymentStatus +=
          "<option " + status_selected + ' value="2">Select Status</option>';
        paymentStatus += "<option " + pending + ' value="0">Pending</option>';
        paymentStatus += "<option " + clear + ' value="1">Clear</option>';
        paymentStatus += "</select>";

        $("#payment-status-span").html(paymentStatus);
        $("#payment-status-date").val(payment_status_date);

        if (data[0]["candidate_id"] != null && data[0]["candidate_id"] != "") {
          tatValue = "";
          if ((tat_status = data[0]["tat_pause_resume_status"] == 1)) {
            tatValue += '<span class="text-danger">Pause<span>';
            $("#btn_tat_name").html("Re-Start TAT");
            $("#btn_pause_re_start_tat").attr(
              "onclick",
              "tat_confirm_dialog(" + data[0]["candidate_id"] + ',"re_start")'
            );
          } else {
            tatValue += '<span class="text-success">Rolling<span>';
            $("#btn_tat_name").html("Pause TAT");
            $("#btn_pause_re_start_tat").attr(
              "onclick",
              "tat_confirm_dialog(" + data[0]["candidate_id"] + ',"pause")'
            );
          }
          $("#tatStatus").html(tatValue);

          $("#view_tat_log").attr(
            "onclick",
            "list_tat_log(" + data[0]["candidate_id"] + ")"
          );
        } else {
          $("#tat_btns").addClass("d-none");
        }

        if (data[0]["tat_start_date"] == "-") {
          $("#tat_btns").addClass("d-none");
        } else {
          $("#tat_btns").removeClass("d-none");
        }
        // camdidatepriority
        var priority,
          priority_check = "";

        if (data[0].priority == "0") {
          priority_check = "Low priority";
        } else if (data[0].priority == "1") {
          priority_check = "Medium priority";
        } else if (data[0].priority == "2") {
          priority_check = "High priority";
          $("#th-dynamic-status").html("Specialist Status");
          $("#th-dynamic-status-name").html("Assigned&nbsp;to&nbsp;specialist");
        }

        priority =
          '<label class="font-weight-bold">Priority: </label>&nbsp;' +
          priority_check;
        $("#priority-div").html(priority);

        var componentIds = ["14", "15", "19", "21", "22"],
          client_packages_list = JSON.parse(data[0].client_packages_list);

        for (var i = 0; i < data.length; i++) {
          var status = "",
            classStatus = "",
            fontAwsom = "",
            insuffDisable = "",
            approvDisable = "";
          // 0-pending, 1-filled Form(in progress), 2-completed, 3-insufficiency, 4-approve, 5-stop, 6-Unable to Verify, 7-Verified Discrepancy, 8-Client clarification, 9-Closed insufficiency

          // if(data[i].component_status != null && data[i].component_status != 'null' && data[i].component_status != ''){
          if (data[i].analyst_status == "0") {
            status = '<span class="text-warning">Not Initiated<span>';
            fontAwsom = '<i class="fa fa-exclamation">';
          } else if (data[i].analyst_status == "1") {
            status = '<span class="text-info">Not Initiated<span>';
            fontAwsom = '<i class="fa fa-check">';
          } else if (data[i].analyst_status == "2") {
            status = '<span class="text-success">Completed<span>';
          } else if (data[i].analyst_status == "3") {
            status = '<span class="text-danger">Insufficiency<span>';
          } else if (data[i].analyst_status == "4") {
            status = '<span class="text-success">Verified Clear<span>';
          } else if (data[i].analyst_status == "5") {
            status = '<span class="text-danger">Stop Check<span>';
          } else if (data[i].analyst_status == "6") {
            status = '<span class="text-danger">Unable to verify<span>';
          } else if (data[i].analyst_status == "7") {
            status = '<span class="text-danger">Verified discrepancy<span>';
          } else if (data[i].analyst_status == "8") {
            status = '<span class="text-danger">Client clarification<span>';
          } else if (data[i].analyst_status == "9") {
            status = '<span class="text-danger">Closed insufficiency<span>';
          } else if (data[i].analyst_status == "10") {
            status = '<span class="text-danger">QC Error<span>';
          } else if (data[i].analyst_status == "11") {
            status = '<span class="text-perpul">Insufficiency Clear<span>';
          }
          // } else {
          //     status = '<span class="text-warning">Pending<span>';
          //     fontAwsom = '<i class="fa fa-exclamation">'
          // }

          // inputQC Status;
          var inputQcStatus = "";
          if (data[i].status == "0") {
            inputQcStatus = '<span class="text-warning">Not Initiated<span>';
          } else if (data[i].status == "1") {
            inputQcStatus = '<span class="text-warning">Not Initiated<span>';
          } else if (data[i].status == "2") {
            inputQcStatus = '<span class="text-success">Completed<span>';
          } else if (data[i].status == "3") {
            inputQcStatus = '<span class="text-danger">Insufficiency<span>';
          } else if (data[i].status == "4") {
            inputQcStatus = '<span class="text-success">Verified Clear<span>';
          } else if (data[i].status == "5") {
            inputQcStatus = '<span class="text-danger">Stop Check<span>';
          } else if (data[i].status == "6") {
            inputQcStatus = '<span class="text-danger">Unable to verify<span>';
          } else if (data[i].status == "7") {
            inputQcStatus =
              '<span class="text-danger">Verified discrepancy<span>';
          } else if (data[i].status == "8") {
            inputQcStatus =
              '<span class="text-danger">Client clarification<span>';
          } else if (data[i].status == "9") {
            inputQcStatus =
              '<span class="text-danger">Closed insufficiency<span>';
          }

          var outPutQCStatus = "";

          if (data[i].output_status == "0") {
            outPutQCStatus = '<span class="text-warning">Not Initiated<span>';
          } else if (data[i].output_status == "1") {
            outPutQCStatus = '<span class="text-success">Approved<span>';
          } else if (data[i].output_status == "2") {
            outPutQCStatus = '<span class="text-danger">Rejected<span>';
          }

          html += '<tr id="tr_' + data[i].candidate_id + '">';
          html += "<td>" + j + "</td>";
          html +=
            "<td>" +
            data[i].component_name +
            " (Form " +
            data[i]["formNumber"] +
            ")</td>";
          var arg =
            data[i].candidate_id +
            "," +
            data[i].component_id +
            "," +
            data[i].position;

          var formValues = JSON.parse(data[i].form_values);
          var argWithName =
            data[i].candidate_id +
            "," +
            data[i].component_id +
            ",'" +
            data[i].component_name +
            "','" +
            data[i].first_name +
            "','" +
            data[i].email_id +
            "'";
          var component_amount = 0;
          for (var j = 0; j < client_packages_list.length; j++) {
            if (
              data[i].selected_package_id == client_packages_list[j].package_id
            ) {
              if (
                client_packages_list[j].component_id == data[i].component_id
              ) {
                var form_data = client_packages_list[j].form_data;
                for (var k = 0; k < form_data.length; k++) {
                  component_amount = parseFloat(form_data[k].form_value);
                }
              }
            }
          }
          html +=
            "<td class='text-center'><i class='fa fa-inr pr-1'></i>" +
            component_amount +
            "</td>";

          html +=
            '<td id="status_' +
            data[i].candidate_id +
            '">' +
            inputQcStatus +
            "</td>";
          html +=
            '<td id="status_' + data[i].candidate_id + '" >' + status + "</td>";

          html +=
            '<td id="insuf_name_' +
            i +
            '" >' +
            data[i].insuff_team_name +
            "</td>";
          var override_team_arg =
            data[i].candidate_id +
            "," +
            data[i].component_id +
            ",'" +
            data[i].component_name +
            "'," +
            data[i].position +
            "," +
            i;
          if (data[i].insuff_team_name != "-") {
            html += '<td id="emp_insuf_name_' + data[i].candidate_id + '" >';
            for (var e = 0; e < data[i].emp_data_insuff_analyst.length; e++) {
              if (
                data[i].insuff_team_id ==
                data[i].emp_data_insuff_analyst[e].team_id
              ) {
                html +=
                  data[i].emp_data_insuff_analyst[e].first_name +
                  "&nbsp;(" +
                  data[i].emp_data_insuff_analyst[e].role +
                  ")";
                break;
              }
            }
            html += "</td>";
          } else {
            html +=
              '<td id="emp_insuf_name_' + data[i].candidate_id + '" >-</td>';
          }

          html +=
            '<td id="analyst_name_' +
            i +
            '">' +
            data[i].assigned_team_name +
            "</td>";

          if (data[i].assigned_team_name != "-") {
            html += '<td id="emp_names_' + data[i].candidate_id + '" >';
            for (var e = 0; e < data[i].emp_data_analyst.length; e++) {
              if (
                data[i].assigned_team_id == data[i].emp_data_analyst[e].team_id
              ) {
                html +=
                  data[i].emp_data_analyst[e].first_name +
                  "&nbsp;(" +
                  data[i].emp_data_analyst[e].role +
                  ")";
                break;
              }
            }
            html += "</td>";
          } else {
            html += '<td id="emp_names_' + data[i].candidate_id + '" >-</td>';
          }
          html +=
            '<td id="status_' +
            data[i].candidate_id +
            '" >' +
            outPutQCStatus +
            "</td>";
          html += "</tr>";
          j++;
        }
      } else {
        html +=
          '<tr><td colspan="8" class="text-center">No Case Found.</td></tr>';
      }
      $("#get-case-data").html(html);
    },
  });
}

function payment_status_confirm() { 
    var candidate_id = $('#candidate-id').val();
    var p_status = $('#action_payment_status').val();
    var payment_date = $('#payment-status-date').val();
  console.log(candidate_id + " || " + p_status+"||"+payment_date);
//   return false;
  if (p_status == "2" || p_status == null) {
    // console.log('Please select pending or clear status.');
    toastr.error("Please select pending or clear status.");
  }else if(payment_date == '' || payment_date == '-'){
    toastr.error("Please select payment date.");
  } else {
    
    $("#payment_status_confirm_dialog").modal("show");
    $("#btnOverrideDiv").html(
      '<button onclick="payment_status_action()" id="btnInsuffi" class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>'
    );
  }
  // $('#payment_status_confirm_dialog').modal('show');
}

function payment_status_action() {
  // console.log('Confirm btn = '+candidate_id+' || '+p_status)
  var candidate_id = $('#candidate-id').val();
  var p_status = $('#action_payment_status').val();
  var payment_date = $('#payment-status-date').val();
  $.ajax({
    type: "POST",
    url: base_url + "adminViewAllCase/change_case_payment_stauts",
    data: {
      candidate_id: candidate_id,
      p_status: p_status,
      payment_date:payment_date
    },
    dataType: "json",
    success: function (all_data) {
      console.log(all_data.status);
      if (all_data.status == 1) {
        toastr.success("Payment status has been update successfully.");
        if (p_status == 1) {
          $("#payment-status-date").val(get_date_formate(all_data.date));
        } else {
          $("#payment-status-date").val("-");
        }
      } else {
        toastr.error("Payment status update failed.");
      }
      $("#payment_status_confirm_dialog").modal("hide");
    },
  });
}
function get_date_formate($param) {
  var it_works = $param;

  jQuery.ajax({
    type: "POST",
    url: base_url + "cases/get_date_formate",
    data: { curr_date: $param },
    success: function (data) {
      it_works = data;
    },
    async: false,
  });

  return it_works;
}
