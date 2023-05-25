$(function () {
  $("#payment-datepicker").datepicker();
});

$("#action-status").on("change", function () {
  get_all_selected_case_print();
});

$("#filter-cases-client-list").on("change", function () {
  get_all_cases("client_search");
});

$("#filter-input").on("keyup", function () {
  var filter_input = $("#filter-input").val();
  if (filter_input == "") {
    get_all_cases("filter_input");
  }
});

$("#filter-input").on("keypress", function (e) {
  var key = e.which;
  if (key == 13) {
    get_all_cases("filter_input");
    return false;
  }
});

$("#load-more-btn").on("click", function () {
  get_all_cases("load_more");
});

$("#bulk-check-cases").on("click", function () {
  $(".candidate-list").prop("checked", false);
  if (this.checked == true) {
    var id = [];
    $(".candidate-list").each(function (i) {
      id[i] = $(this).val();
    });
    var check_length = id.length;
    // if (id.length > max_select_id_for_bulk_upload) {
    //    check_length = max_select_id_for_bulk_upload;
    // }

    for (var i = 0; i < check_length; i++) {
      $("#ids-" + id[i]).prop("checked", true);
    }
  } else {
    $(".candidate-list").prop("checked", false);
  }
});

$("#save-finance-summery").on("click", function () {
  $candidate = $("#case_ids").val();
  $client = $("#client_name").val();
  $client_id = $("#client_id").val();

  $.ajax({
    type: "POST",
    url: base_url + "factsuite-finance/save-finance-case-summary",
    dataType: "json",
    data: { candidate: $candidate, client: $client, client_id: $client_id },
    success: function (data) {
      let html = "";
      if (data.status == "1") {
        toastr.success("Summary has successfully saved.");
        $("#load-more-btn-div").hide();
        window.location.href =
          base_url +
          "factsuite-finance/get-finance-bills?cases=" +
          btoa($candidate) +
          "&&id=" +
          data.id;
      } else {
        // html+='<tr><td colspan="10" class="text-center">No Case Found.</td></tr>';
      }
      toastr.success("success.");
    },
  });
});

get_filter_number_list();
function get_filter_number_list() {
  $.ajax({
    type: "POST",
    url: base_url + "factsuite-finance/get-custom-filter-number-list",
    dataType: "json",
    data: {
      verify_finance_request: 1,
    },
    success: function (data) {
      var html = "";
      for (var i = 0; i < data.length; i++) {
        html += '<option value="' + data[i] + '">' + data[i] + "</option>";
      }
      $("#filter-cases-number").html(html);
      get_all_cases();
    },
  });
}

get_client_list();
function get_client_list() {
  $.ajax({
    type: "POST",
    url: base_url + "factsuite-finance/get-all-clients",
    data: {
      verify_finance_request: 1,
    },
    dataType: "json",
    success: function (data) {
      var html = '<option value="" selected>All Clients</option>';
      if (data.all_clients.length > 0) {
        all_clients = data.all_clients;
        for (var i = 0; i < all_clients.length; i++) {
          html +=
            '<option value="' +
            all_clients[i].client_id +
            '">' +
            all_clients[i].client_name +
            "</option>";
        }
      }
      $("#filter-cases-client-list").html(html);
    },
  });
}

function get_all_cases(request_from = "") {
  $("#load-more-btn").html(
    '<div class="spinner-border text-light spinner-border-load-more"></div>'
  );
  $("#load-more-btn").removeAttr("onclick");

  if (
    request_from == "client_search" ||
    request_from == "status_update_failed"
  ) {
    $("#get-case-data").html("");
    $("#all-case-filter-btn").html(
      '<div class="spinner-border text-light spinner-border-load-more"></div>'
    );
    $("#all-case-filter-btn").removeAttr("onclick");
  }

  var filter_number = $("#filter-cases-number").val(),
    client_list = $("#filter-cases-client-list").val(),
    summary_id_list = [],
    candidate_numbers_shown = [];

  if (client_list.length == 0 || client_list == "") {
    client_list = "";
  }

  $(".case-filter").each(function () {
    summary_id_list.push($(this).data("summary_id"));
  });

  $(".case-filter").each(function () {
    candidate_numbers_shown.push($(this).data("candidate_display_number"));
  });

  $("#get-case-data").append(
    '<tr id="spinner-indicator"><td colspan="8" class="text-center"><div class="spinner-border text-primary spinner-border-load-more"></div></td></tr>'
  );

  $.ajax({
    type: "POST",
    url: base_url + "factsuite-finance/get-all-saved-summary",
    data: {
      summary_id_list: summary_id_list,
      client_list: client_list,
      filter_limit: filter_number,
      request_from: request_from,
    },
    dataType: "json",
    success: function (all_data) {
      let html = "",
        count = 1,
        data = all_data.all_cases,
        selected_datetime_format = all_data.selected_datetime_format;

      if (summary_id_list.length > 0) {
        count = summary_id_list.length + 1;
      }

      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
          var status = "";
          if (data[i].finance_status == 1) {
            status = "checked";
          }
          html +=
            '<tr class="case-filter" id="tr_' +
            data[i].summary_id +
            '" data-summary_id="' +
            data[i].summary_id +
            '" data-candidate_display_number="' +
            count +
            '">';
          html +=
            '<td><span class="tbody-th-span"><input type="checkbox" class="checkbox candidate-list" id="ids-' +
            data[i].summary_id +
            '" name="ids[]" value="' +
            data[i].summary_id +
            '"></span></td>';
          html +=
            '<td id="first_name' + data[i].summary_id + '">' + count + "</td>";
          html +=
            '<td id="first_name' +
            data[i].summary_id +
            '">' +
            data[i]["client"] +
            "</td>";
          html +=
            '<td id="start_date' +
            data[i].summary_id +
            '">' +
            moment(data[i]["summary_created_date"]).format(
              selected_datetime_format["js_code"]
            ) +
            "</td>";
          html +=
            '<td class="text-center"><a href="' +
            base_url +
            "factsuite-finance/get-finance-bills?cases=" +
            btoa(data[i].candidate_ids) +
            "&flag=1&id=" +
            data[i].summary_id +
            '"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
          html += '<td><div class="custom-control custom-switch d-inline">';
          html +=
            '<input type="checkbox" ' +
            status +
            ' onclick="summary_status(' +
            data[i].summary_id +
            "," +
            data[i].finance_status +
            ')" class="custom-control-input" id="change_show_to_client_status_' +
            data[i].summary_id +
            '"> <label class="custom-control-label" for="change_show_to_client_status_' +
            data[i].summary_id +
            '"></label>';
          html += "</div></td>";
          html += "</tr>";

          count++;
        }
      } else {
        if (request_from != "load_more") {
          html +=
            '<tr><td colspan="8" class="text-center">No Case Found.</td></tr>';
        }
      }
      // setTimeout(function() {
      $("#spinner-indicator").remove();

      if ("load_more") {
        $("#get-case-data").append(html);
      } else {
        $("#get-case-data").html(html);
      }

      get_new_cases_count();

      $("#all-case-filter-btn").html("Search");
      $("#all-case-filter-btn").attr(
        "onclick",
        "get_all_cases('filter_input')"
      );
      // }, 1500);
    },
  });
}

function get_new_cases_count() {
  var client_list = $("#filter-cases-client-list").val(),
    summary_id_list = [];

  $(".case-filter").each(function () {
    summary_id_list.push($(this).data("summary_id"));
  });

  if (client_list.length == 0 || client_list == "") {
    client_list = "";
  }

  $.ajax({
    type: "POST",
    url: base_url + "factsuite-finance/get-new-cases-summary-count",
    data: {
      summary_id_list: summary_id_list,
      client_list: client_list,
    },
    dataType: "json",
    success: function (data) {
      if (data.new_summary_count > 0) {
        $("#load-more-btn-div").html(
          '<button class="send-btn mt-0 mr-0 btn-filter-search mt-2" id="load-more-btn" onclick="get_all_cases(\'load_more\')">Load More</button>'
        );
      } else {
        $("#load-more-btn-div").empty();
      }
    },
  });
}

function addfield() {
  var field_name = $("#field_name").val();
  var summary_id = $("#summary_id").val();

  if (field_name != "") {
    $.ajax({
      type: "POST",
      url:
        base_url +
        "factsuite-finance/save-selected-finance-case-summary/" +
        summary_id,
      data: {
        field_name: field_name,
      },
      dataType: "json",
      success: function (data) {
        $("#add_fields").modal("hide");

        if (data.status == "1") {
          $("#field_name").val("");
          toastr.success("New field added successfully.");
          // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
          window.location.reload();
        } else {
          toastr.error(
            "Something went wrong while adding the data. Please try again."
          );
        }
        toastr.success("field inserted successfully.");
      },
      error: function (data) {
        $("#edit_component").modal("hide");
        toastr.error(
          "Something went wrong while adding the data. Please try again."
        );
      },
    });
  } else {
    if (field_name != "") {
      $("#field-name-error-msg-div").html(
        '<span class="text-danger error-msg-small">Please enter field name.</span>'
      );
    }
  }
}

function edit_current_field(id) {
  var count = $("#total_fields").val();
  $fields = $("#all-fields").val();
  var name = $fields.split(",");
  $("#edit_dynamic_id").val(id);
  let html = "";
  for (var i = 0; i < count; i++) {
    $val = $("#" + name[i].replace(" ", "_") + id).html();
    html += '<div class="col-sm-12">';
    html += '<h6 class="product-details-span-light">' + name[i] + "</h6>";
    html +=
      '<input type="text" class="fld field_name_value" name="field_name_value" value="' +
      $val +
      '"  placeholder="Enter ' +
      name[i] +
      ' Value">';
    html += '<div id="field-name-error-msg-div"></div>';
    html += "</div>";
  }

  $("#edit_field_values").html(html);
  $("#edit_field").modal("show");
}

function updateData() {
  var count = $("#total_fields").val();
  $fields = $("#all-fields").val();
  var name = $fields.split(",");
  var id = $("#edit_dynamic_id").val();
  var summary_id = $("#summary_id").val();
  $i = 0;
  $(".field_name_value").each(function () {
    field_value.push($(this).val());
    $("#" + name[$i].replace(" ", "_") + id).html($(this).val());
    $i++;
  });

  $.ajax({
    type: "POST",
    url:
      base_url +
      "factsuite-finance/save-selected-finance-case-summary-value/" +
      summary_id,
    data: {
      field_value: field_value,
      count: count,
      index_id: index_id,
      summary_id: summary_id,
    },
    dataType: "json",
    success: function (data) {
      $("#add_fields").modal("hide");

      if (data.status == "1") {
        $("#field_name").val("");
        toastr.success("New field added successfully.");
        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
        window.location.reload();
      } else {
        toastr.error(
          "Something went wrong while adding the data. Please try again."
        );
      }
    },
    error: function (data) {
      $("#edit_component").modal("hide");
      toastr.error(
        "Something went wrong while adding the data. Please try again."
      );
    },
  });
  $("#edit_field").modal("hide");
}

function summary_status(id, status) {
  var c_status = 0;

  if (status == 1) {
    c_status = 0;
  } else if (status == 0) {
    c_status = 1;
  } else {
    get_all_client_logo();
    toastr.error("OOPS! Something went wrong. Please try again.");
    return false;
  }

  var variable_array = {};
  variable_array["id"] = id;
  variable_array["actual_status"] = status;
  variable_array["changed_status"] = c_status;
  variable_array["ajax_call_url"] = "finance/statussummary/" + id;
  variable_array["checkbox_id"] = "#change_show_to_client_status_" + id;
  variable_array["onclick_method_name"] = "summary_status";
  variable_array["success_message"] = "Status has been updated successfully.";
  variable_array["error_message"] =
    "Something went wrong updating the status. Please try again.";
  variable_array["error_callback_function"] =
    "get_all_cases('status_update_failed')";
  variable_array["ajax_pass_data"] = {
    verify_admin_request: 1,
    id: id,
    summarystatus: c_status,
  };

  return change_status(variable_array);
}

$(function () {
  $("#paymetn-status-action").on('click', function () {

    // alert($("option:selected", this).text());
    var p_status = $('#payment-status').val(); 
    var payment_date = $("#payment-datepicker").val();
    var summery_ids = [];
    var i = 0; 
    $("input[name='ids[]']:checked").each(function () {
      // alert($(this).val());
      summery_ids[i] = $(this).val();
      i++;
    });
    var count = summery_ids.length;
    // alert(count);
    if (p_status == 2) {
      toastr.error("Please select Pending or Clear status");
    }else if(payment_date == ''){
      toastr.error("Please select date.");
    } else {
      if (count > 0) {
        $.ajax({
          type: "POST",
          url: base_url + "adminViewAllCase/change_case_payment_stauts",
          data: {
            payment_date:payment_date,
            p_status: p_status,
            count: count,
            summery_ids: summery_ids,
          },
          dataType: "json",
          success: function (all_data) {
            if (all_data.status == 1) {
              toastr.success('Payment status has been update successfully.');
            } else {
              toastr.error('Payment status update failed.');
            }
          },
        });
      } else {
        toastr.error("Please select at least one summery");
      }
    }
  });
});
