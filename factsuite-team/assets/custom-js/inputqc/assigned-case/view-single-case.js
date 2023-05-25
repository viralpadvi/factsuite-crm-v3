// load_case();
function randomString(length) {
  var result = "";
  var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  for (var i = length; i > 0; --i)
    result += chars[Math.floor(Math.random() * chars.length)];
  return result;
}
function load_case(candidate_id) {
  // alert(candidate_id)
  var statusPage = "0";
  var randomChars = randomString(7);
  $.ajax({
    type: "POST",
    url: base_url + "inputQc/getSingleAssignedCaseDetails/" + randomChars,
    data: {
      candidate_id: candidate_id,
      statusPage: statusPage,
    },
    dataType: "JSON",
    success: function (data) {
      // console.log(JSON.stringify(data))
      let html = "";
      if (data.length > 0) {
        var j = 1;
        // alert(data[0].component_name)
        $("#view_personal_docuemnts").addClass("d-none");
        $("#caseId").html(data[0]["candidate_id"]);
        $("#camdidateName").html(data[0]["first_name"]);
        $("#clientName").html(data[0]["client_name"]);
        $("#camdidatephoneNumber").html(data[0]["phone_number"]);
        $("#packageName").html(data[0]["package_name"]);
        $("#camdidateEmailId").html(data[0]["email_id"]);
        $("#camdidateDob").html(data[0]["date_of_birth"]);
        $("#remarks").html(data[0]["remark"]);
        $("#week").html(data[0]["week"]);
        $("#start_date").html(data[0]["contact_start_time"]);
        $("#end_date").html(data[0]["contact_end_time"]);
        var personal_document = [];
        
        if (data[0]["is_submitted"] == 0) {
        //   $("#candidate-loa").hide();
          $("#form-submited").html(
            "<span class='text-danger'>This Candidate hasn’t submitted the Verification form yet. Please check with candidate or client.</span>"
          );
        }
        // }else{
            // alert(data[0]["is_submitted"]+": "+data[0]['document_uploaded_by'])
            $('#candidate-loa').html('');
             if (data[0]['document_uploaded_by'].toLowerCase() == 'candidate' || data[0]['signature'] !='1') {
                $('#candidate-loa').html('LOA &nbsp;&nbsp;&nbsp;<a target="_blank" href="'+base_url+'factsuite-admin/candidate-loa-pdf/'+masked_candidate_id+'"><i class="fa fa-file-pdf-o"></i></a>');
            } else {
                
                if (data[0]['is_submitted'] != 0) {
                    if (data[0]['uploaded_loa'] != null && data[0]['uploaded_loa'] != 'null' ) {
                        $('#candidate-loa').html('LOA &nbsp;&nbsp;&nbsp;<a target="_blank" download href="'+img_base_url+'../uploads/doc_signs/'+data[0]['uploaded_loa']+'"><i class="fa fa-download"></i></a>');
                    } 
                }
            }
        // }

        personal_document.push({
          aaddhar_doc: data[0]["aaddhar_doc"],
          pancard_doc: data[0]["pancard_doc"],
          idproof_doc: data[0]["idproof_doc"],
          bankpassbook_doc: data[0]["bankpassbook_doc"],
        });

        // alert(JSON.stringify(personal_document))

        for (var i = 0; i < data.length; i++) {
          var status = "";
          var classStatus = "";
          var fontAwsom = "";
          var insuffDisable = "";
          var approvDisable = "";
          var rightClass = "";
          // 0-pending 1-onprogress 2-completed 3-insufficiency 4-approved
          // alert(data[i].component_status)
          // form_status = data[i].component_status.split(',')

          // console.log(jQuery.inArray("0", form_status))

          // if (jQuery.inArray(0, form_status) === -1) {
          //     status = '<span class="text-warning">Pending<span>';
          // }else if (jQuery.inArray(1, form_status) === -1) {
          //     status = '<span class="text-info">Form Filled<span>';
          // }else if (jQuery.inArray("2", form_status) === -1) {
          //     status = '<span class="text-success">Completed<span>';
          // }else if (jQuery.inArray("3", form_status) === -1) {
          //     status = '<span class="text-danger">Insufficiency<span>';
          // }else if (jQuery.inArray("4", form_status) === -1) {
          //     status = '<span class="text-success">Verified Clear<span>';
          // }else{
          //     status = '<span class="text-warning">Pending<span>';
          // }

          var ipQcStatus = [];
          var inputQcStatus = data[i].component_status.split(",");
          // console.log('inputQcStatus: '+inputQcStatus)
          n = 1;
          for (var k = 0; k < inputQcStatus.length; k++) {
            if (inputQcStatus[k] == "0") {
              ipQcStatus.push(
                "Form " +
                  n +
                  ': <span class="text-warning">Not initiated </span>'
              );
            } else if (inputQcStatus[k] == "1") {
              ipQcStatus.push(
                " Form " + n + ': <span class="text-info">Form Filled</span>'
              );
            } else if (inputQcStatus[k] == "2") {
              ipQcStatus.push(
                " Form " + n + ': <span class="text-success">Completed</span>'
              );
            } else if (inputQcStatus[k] == "3") {
              ipQcStatus.push(
                " Form " +
                  n +
                  ': <span class="text-danger">insufficiency</span>'
              );
            } else if (inputQcStatus[k] == "4") {
              ipQcStatus.push(
                " Form " +
                  n +
                  ': <span class="text-success">Verified Clear</span>'
              );
            } else {
              ipQcStatus.push(
                " Form " + n + ': <span class="text-warning">Pending</span>'
              );
            }
            n++;
          }

          html += '<tr id="tr_' + data[i].candidate_id + '">';
          html += "<td>" + j + "</td>";
          html += "<td>" + data[i].component_name + "</td>";

          // console.log(data[i].form_values)
          // var formValues = data[i].form_values;
          var formValues = JSON.parse(data[i].form_values);
          // console.log(formValues)

          var arg =
            data[i].candidate_id +
            "," +
            data[i].component_id +
            "," +
            data[i].priority +
            ',"' +
            data[i].component_name +
            '"';
          // alert(arg)
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
            "','" +
            data[i].priority +
            "'";
          html +=
            '<td id="status_' +
            data[i].candidate_id +
            '" id="status' +
            data[i].candidate_id +
            '">' +
            ipQcStatus +
            "</td>";
          // html += '<td class="text-center"><a href="#" onclick="getComponentBasedData('+arg+')"><i class="fa fa-eye"></i></a></td>';
          html +=
            "<td class='text-center'><a id ='arg_" +
            i +
            "' data-object ='" +
            data[i].form_values +
            "' onclick='getComponentBasedData(" +
            arg +
            "," +
            formValues +
            ")'><i class='fa fa-eye'></i></a></td>";
          html += "</tr>";

          j++;
        }
      } else {
        html +=
          '<tr><td colspan="8" class="text-center">No Case Found.</td></tr>';
      }
      $("#get-case-data").html(html);
      // personal_document
      var data1 = [{ a: 1, b: 2, c: 3 }];
      $("#view_personal_docuemnts").attr(
        "onclick",
        "personal_document_modal('" + data1 + "')"
      );
    },
  });
}

function test(b) {
  console.log(b);
  // var form_value = $('#arg_'+b).data('object');
  // console.log(form_value)
}

function sendMial(candidate_id, component_id) {
  // alert('Model')
  $("#sendMail").modal("show");
  $.ajax({
    type: "POST",
    url: base_url + "inputQc/insuffUpdateStatus",
    data: {
      candidate_id: candidate_id,
      component_id: component_id,
    },
    dataType: "json",
    success: function (data) {},
  });
}

function modalInsuffi(
  candidate_id,
  component_id,
  componentname,
  priority,
  position,
  status
) {
  var status_single_double = status;
  // alert('status: '+status)
  $("#modalInsuffi").modal("show");
  $("#componentNameInsuff").html("In " + componentname);
  // $('#insuffMailDetail').val('Hi '+first_name+',\nWe noticed that your Address details provided are not sufficient to process your Back Ground Check initiated by your employer.')
  $("#btnInsuffiDiv").html(
    '<button onclick="insufiincincyUpdate(' +
      candidate_id +
      "," +
      component_id +
      "," +
      priority +
      "," +
      position +
      ",'" +
      status_single_double +
      '\')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>'
  );
}
function findValueInArray(value, arr) {
  var result = "0";

  for (var i = 0; i < arr.length; i++) {
    var name = arr[i];
    if (name == value) {
      result = "1";
      break;
    }
  }

  return result;
}
function insufiincincyUpdate(
  candidate_id,
  component_id,
  priority,
  position,
  status
) {
  $("#insuf_btn_" + position).prop("disabled", true);
  $("#app_btn_" + position).prop("disabled", true);
  // alert(position)
  var insuff_remarks = $("#insuff_remarks").val();
  var candidateUrl = $("#candidateUrl").val();
  var insuffMailDetail = $("#insuffMailDetail").val();
  $.ajax({
    type: "POST",
    url: base_url + "inputQc/insuffUpdateStatus",
    data: {
      candidate_id: candidate_id,
      component_id: component_id,
      candidateUrl: candidateUrl,
      insuffMailDetail: insuffMailDetail,
      priority: priority,
      position: position,
      status: status,
      insuff_remarks: insuff_remarks,
    },
    dataType: "json",
    success: function (data) {
      $("#modalInsuffi").modal("hide");
      $("#insuff_remarks").val("");
      if (data.status == "1") {
        load_case(candidate_id);
        let html = "<span class='text-success'>Success data updated</span>";
        $("#error-team").html(html);
        toastr.success("New data has been updated successfully.");
        var componenet_ids = ["5", "6", "8", "9", "16"];

        if (
          position == 0 &&
          findValueInArray(component_id, componenet_ids) == "1"
        ) {
          $("#insuf_btn").prop("disabled", true);
          $("#app_btn").prop("disabled", true);
          $("#form_status").html(
            '<span class="text-danger">Insufficiency<span>'
          );
          $("#app_btn_icon").addClass("bac-gy");
        } else {
          // alert('not done')
          $("#insuf_btn_" + position).prop("disabled", true);
          $("#app_btn_" + position).prop("disabled", true);
          $("#form_status_" + position).html(
            '<span class="text-danger">Insufficiency<span>'
          );
          $("#app_btn_icon_" + position).addClass("bac-gy");
        }
      } else {
        // alert('very not done')
        let html = "<span class='text-danger'>Somthing went wrong.</span>";
        $("#error-team").html(html);
        toastr.error("New data has been updated failed.");
        $("#insuf_btn_" + position).prop("disabled", false);
        $("#app_btn_" + position).prop("disabled", false);
      }
    },
  });
}
function modalapprov(
  candidate_id,
  component_id,
  componentname,
  priority,
  position,
  status
) {
  // alert('status: '+status)
  var status_single_double = status;
  $("#modalapprov").modal("show");
  $("#componentNameApprove").html("In " + componentname);
  // $('#insuffMailDetail').val('Hi '+first_name+',\nWe noticed that your Address details provided are not sufficient to process your Back Ground Check initiated by your employer.')
  $("#btnApproveDiv").html(
    '<button onclick="approvUpdate(' +
      candidate_id +
      "," +
      component_id +
      "," +
      priority +
      "," +
      position +
      ",'" +
      status_single_double +
      '\')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>'
  );
}

function approvUpdate(candidate_id, component_id, priority, position, status) {
  var approveComment = $("#approve-comment").val();
  $("#insuf_btn_" + position).prop("disabled", true);
  $("#app_btn_" + position).prop("disabled", true);
  // alert(approveComment)
  $.ajax({
    type: "POST",
    url: base_url + "inputQc/approveUpdateStatus",
    data: {
      candidate_id: candidate_id,
      component_id: component_id,
      approveComment: approveComment,
      priority: priority,
      position: position,
      status: status,
    },
    dataType: "json",
    success: function (data) {
      $("#modalapprov").modal("hide");
      if (data.status == "1") {
        load_case(candidate_id);
        let html = "<span class='text-success'>Success data updated</span>";
        $("#error-team").html(html);
        toastr.success("New data has been updated successfully.");
        var componenet_ids = ["5", "6", "8", "9", "16"];
        // alert('position: '+position +'\n inArray: '+findValueInArray(component_id,componenet_ids))
        // return false
        if (
          status == "single" ||
          (position == 0 &&
            findValueInArray(component_id, componenet_ids) == "1")
        ) {
          // alert('done')
          $("#insuf_btn").prop("disabled", true);
          $("#app_btn").prop("disabled", true);
          $("#form_status").html(
            '<span class="text-success">Verified Clear<span>'
          );
          $("#app_btn_icon").addClass("bac-gr");
        } else {
          $("#insuf_btn_" + position).prop("disabled", true);
          $("#app_btn_" + position).prop("disabled", true);
          $("#form_status_" + position).html(
            '<span class="text-success">Verified Clear<span>'
          );
          $("#app_btn_icon_" + position).addClass("bac-gr");
        }
      } else if (data.status == "2") {
        $("#insuf_btn_" + position).prop("disabled", false);
        $("#app_btn_" + position).prop("disabled", false);
        toastr.error(data.msg);
      } else if (data.status == "201") {
        $("#insuf_btn_" + position).prop("disabled", false);
        $("#app_btn_" + position).prop("disabled", false);
        toastr.warning(data.msg);
      } else {
        $("#insuf_btn_" + position).prop("disabled", false);
        $("#app_btn_" + position).prop("disabled", false);
        // $('#status_'+candidate_id).html('<span class="text-success">Completed<span>')
        let html = "<span class='text-danger'>Somthing went wrong.</span>";
        $("#error-team").html(html);
        toastr.error("New data has been updated failed.");
      }
    },
  });
}

var none = "";
function getComponentBasedData(
  candidate_id,
  component_id,
  priority,
  component_name,
  form_values
) {
  // alert(form_values)
  $.ajax({
    type: "POST",
    url: base_url + "inputQc/getComponentBasedData",
    data: {
      candidate_id: candidate_id,
      component_id: component_id,
    },
    dataType: "json",
    success: function (data) {
      // console.log(JSON.stringify(data))
      none = "";
      $("#component-detail").html("");
      $("#modal-headding").html("");
      switch (component_id) {
        case 1:
          criminal_checks(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 2:
          court_records(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 3:
          document_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 4:
          drugtest(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 5:
          globaldatabase(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 6:
          current_employment(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 7:
          education_details(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 8:
          present_address(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 9:
          permanent_address(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 10:
          previous_employment(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 11:
          reference(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 12:
          previous_address(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 14:
          directorship_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 15:
          global_aml_sanctions(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 16:
          driving_License(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 17:
          credit_cibil_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 18:
          bankruptcy_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 19:
          adverse_database_media_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 20:
          cv_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 21:
          health_checkup_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 22:
          employement_gap_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 23:
          landlord_reference(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 24:
          covid_19(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 25:
          social_media(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 26:
          civil_check(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 27:
          right_to_work(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 28:
          sex_offender(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 29:
          politically_exposed(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 30:
          india_civil_litigation(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 31:
          mca(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 32:
          nric(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 33:
          gsa(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        case 34:
          oig(
            data,
            priority,
            component_name,
            form_values,
            candidate_id,
            component_id
          );
          break;
        default:
          break;
      }
    },
  });
}

// diffrent check forms
function civil_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  console.log("criminal_checks : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // address pin_code city  state  approved_doc
  let html = "";
  if (data.status != "0") {
    var address = JSON.parse(data.component_data.address);
    var pin_code = JSON.parse(data.component_data.pin_code);
    var city = JSON.parse(data.component_data.city);
    var state = JSON.parse(data.component_data.state);
    var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
    var component_status = data.component_data.status.split(",");
    // var component_status =  JSON.parse(data.component_data.status)
    // alert(JSON.stringify(info))
    var j = 1;

    html +=
      '<input name=""  value="' +
      data.component_data.civil_check_id +
      '" class="fld form-control" id="civil_check_id" type="hidden">';
    for (var i = 0; i < address.length; i++) {
      var form_status = "";
      var insuffDisable = "";
      var approvDisable = "";
      var rightClass = "";
      if (component_status[i] == "0") {
        form_status = '<span class="text-warning">Pending<span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "1") {
        form_status = '<span class="text-info">Form Filled<span>';
        fontAwsom = '<i class="fa fa-check">';
        rightClass = "bac-gr";
      } else if (component_status[i] == "2") {
        form_status = '<span class="text-success">Completed<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else if (component_status[i] == "3") {
        form_status = '<span class="text-danger">Insufficiency<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
      } else if (component_status[i] == "4") {
        form_status = '<span class="text-success">Verified Clear<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }
      html += ' <div class="pg-cnt pl-0 pt-0">';
      html += '      <div class="pg-txt-cntr">';
      html += '         <div class="pg-steps d-none">Step 2/6</div>';
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html +=
        '               <h6 class="full-nam2"> Address Details ' +
        j++ +
        "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html +=
        '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_' +
        i +
        '">' +
        form_status +
        "</span>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-8">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Address</label>";
      html +=
        '                  <textarea class="fld form-control criminal-address"  rows="4" id="address">' +
        address[i].address +
        "</textarea>";
      html += "               </div>";
      html += "            </div>";

      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Pin Code</label>";
      html +=
        '                  <input name=""  value="' +
        pin_code[i].pincode +
        '" class="fld form-control criminal-pincode" id="pincode" type="text">';
      html += "               </div>";
      html += "            </div>";

      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>City/Town</label>";
      html +=
        '                  <input name=""  value="' +
        city[i].city +
        '" class="fld form-control criminal-city" id="city" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>State</label>";
      html +=
        '                  <input name=""  value="' +
        state[i].state +
        '"  class="fld form-control criminal-state" id="state" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += "         </div>";
      html += "      </div>";
      html += "   </div>";

      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }
      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn ' +
          none +
          '" id="insuf_btn_' +
          i +
          '" ' +
          insuffDisable +
          ' onclick="modalInsuffi(' +
          data.component_data.candidate_id +
          ",'" +
          26 +
          "','Civil Check','" +
          priority +
          "'," +
          i +
          ",'double')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn ' +
          none +
          '" id="app_btn_' +
          i +
          '" ' +
          approvDisable +
          ' onclick="modalapprov(' +
          data.component_data.candidate_id +
          ",'" +
          26 +
          "','Civil Check','" +
          priority +
          "'," +
          i +
          ",'double')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
      // alert(info[i].address)
    }
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                 <button id="add_civil" onclick="add_civil()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

// diffrent check forms
function criminal_checks(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  console.log("criminal_checks : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // address pin_code city  state  approved_doc
  let html = "";
  if (data.status != "0") {
    var address = JSON.parse(data.component_data.address);
    var pin_code = JSON.parse(data.component_data.pin_code);
    var city = JSON.parse(data.component_data.city);
    var state = JSON.parse(data.component_data.state);
    var component_status = data.component_data.status.split(",");
    // var component_status =  JSON.parse(data.component_data.status)
    // alert(JSON.stringify(info))
    var j = 1;

    html +=
      '<input name=""  value="' +
      data.component_data.criminal_check_id +
      '" class="fld form-control" id="criminal_checks_id" type="hidden">';
    for (var i = 0; i < address.length; i++) {
      var form_status = "";
      var insuffDisable = "";
      var approvDisable = "";
      var rightClass = "";
      var none = "";
      var none_btn = "";
      if (component_status[i] == "0") {
        form_status = '<span class="text-warning">Pending<span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "1") {
        none = "d-none";
        form_status = '<span class="text-info">Form Filled<span>';
        fontAwsom = '<i class="fa fa-check">';
        rightClass = "bac-gr";
      } else if (component_status[i] == "2") {
        none_btn = "d-none";
        form_status = '<span class="text-success">Completed<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else if (component_status[i] == "3") {
        none_btn = "d-none";
        form_status = '<span class="text-danger">Insufficiency<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        none_btn = "d-none";
        form_status = '<span class="text-success">Verified Clear<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }
      html += ' <div class="pg-cnt pl-0 pt-0">';
      html += '      <div class="pg-txt-cntr">';
      html += '         <div class="pg-steps d-none">Step 2/6</div>';
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html +=
        '               <h6 class="full-nam2"> Address Details ' +
        j++ +
        "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html +=
        '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_' +
        i +
        '">' +
        form_status +
        "</span>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-8">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Address</label>";
      html +=
        '                  <textarea class="fld form-control criminal-address"  rows="4" id="address">' +
        address[i].address +
        "</textarea>";
      html += "               </div>";
      html += "            </div>";

      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Pin Code</label>";
      html +=
        '                  <input name=""  value="' +
        pin_code[i].pincode +
        '" class="fld form-control criminal-pincode" id="pincode" type="text">';
      html += "               </div>";
      html += "            </div>";

      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>City/Town</label>";
      html +=
        '                  <input name=""  value="' +
        city[i].city +
        '" class="fld form-control criminal-city" id="city" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>State</label>";
      html +=
        '                  <input name=""  value="' +
        state[i].state +
        '"  class="fld form-control criminal-state" id="state" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += "         </div>";
      html += "      </div>";
      html += "   </div>";
      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }
      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button  class="insuf-btn  ' +
          none +
          '" id="insuf_btn_' +
          i +
          '" ' +
          insuffDisable +
          ' onclick="modalInsuffi(' +
          data.component_data.candidate_id +
          ",'" +
          1 +
          "','Criminal Check','" +
          priority +
          "'," +
          i +
          ",'double')\">Raise Insufficiency</button>";
        html +=
          '   <button  class="app-btn  ' +
          none +
          '" id="app_btn_' +
          i +
          '" ' +
          approvDisable +
          ' onclick="modalapprov(' +
          data.component_data.candidate_id +
          ",'" +
          1 +
          "','Criminal Check','" +
          priority +
          "'," +
          i +
          ",'double')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
      // alert(info[i].address)
    }
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                 <button  id="add_criminal" onclick="add_criminal()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function court_records(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  let html = "";
  if (data.status != "0") {
    var address = JSON.parse(data.component_data.address);
    var pin_code = JSON.parse(data.component_data.pin_code);
    var city = JSON.parse(data.component_data.city);
    var state = JSON.parse(data.component_data.state);
    var address_proof_doc = JSON.parse(data.component_data.address_proof_doc);
    var component_status = data.component_data.status.split(",");
    var j = 1;
    html +=
      '<input name=""  value="' +
      data.component_data.court_records_id +
      '" class="fld form-control court_records_id" id="court_records_id" type="hidden">';
    if (address.length > 0) {
      for (var i = 0; i < address.length; i++) {
        var form_status = "";
        var insuffDisable = "";
        var approvDisable = "";
        var rightClass = "";
        var none = "";
        var none_btn = "";
        if (component_status[i] == "0") {
          form_status = '<span class="text-warning">Pending<span>';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gy";
        } else if (component_status[i] == "1") {
          none = "d-none";
          form_status = '<span class="text-info">Form Filled<span>';
          fontAwsom = '<i class="fa fa-check">';
          rightClass = "bac-gr";
        } else if (component_status[i] == "2") {
          none_btn = "d-none";
          form_status = '<span class="text-success">Completed<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gr";
        } else if (component_status[i] == "3") {
          none_btn = "d-none";
          form_status = '<span class="text-danger">Insufficiency<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
        } else if (component_status[i] == "4") {
          none_btn = "d-none";
          form_status = '<span class="text-success">Verified Clear<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gr";
        } else {
          form_status = '<span class="text-warning">Pending<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gy";
        }
        var errorMessage = "This value was not enter by candidate.";
        var pinCode = errorMessage;
        if (pin_code.length > i) {
          pinCode = pin_code[i].pincode;
        }
        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2"> Address Details '+(j++)+'</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html +=
          '               <h6 class="full-nam2"> Court Record ' +
          j++ +
          "</h6> ";
        html += "            </div>";
        html += '            <div class="col-md-4">';
        html +=
          '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_' +
          i +
          '">' +
          form_status +
          "</span>";
        html += "            </div>";
        html += "         </div>";
        html += '         <div class="row">';
        html += '            <div class="col-md-8">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Address</label>";
        html +=
          '                  <textarea class="fld form-control court-address"  rows="4" id="address">' +
          address[i].address +
          "</textarea>";
        html += "               </div>";
        html += "            </div>";

        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Pin Code</label>";
        html +=
          '                  <input name=""  value="' +
          pinCode +
          '" class="fld form-control court-pincode" id="pincode" type="text">';
        html += "               </div>";
        html += "            </div>";

        html += "         </div>";
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>City/Town</label>";
        html +=
          '                  <input name=""  value="' +
          city[i].city +
          '" class="fld form-control court-city" id="city" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>State</label>";
        html +=
          '                  <input name=""  value="' +
          state[i].state +
          '"  class="fld form-control court-state" id="state" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += "         </div>";
        html += "      </div>";

        if (component_status[i] == "3") {
          html += '<div class="row">';
          html +=
            '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
          html += '<div class="col-md-12">';
          html += "<label>Insuff Remark Comment</label>";
          html +=
            '<textarea readonly  class="input-field form-control">' +
            insuff_remarks[i].insuff_remarks +
            "</textarea>";
          html += "</div>";
          html += "</div>";
        }

        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">Address Proof</div>';
        if (address_proof_doc != null && address_proof_doc != "") {
          if (address_proof_doc[i] != null && address_proof_doc[i] != "") {
            var address_proof = address_proof_doc[i];
            var address_doc = address_proof.split(",");
            for (var n = 0; n < address_doc.length; n++) {
              var url =
                img_base_url + "../uploads/address-docs/" + address_doc[n];
              if (/\.(jpg|jpeg|png)$/i.test(address_doc[n])) {
                html +=
                  '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
                html += '                   <div class="image-selected-div">';
                html += '                       <ul class="p-0 mb-0">';
                html +=
                  '                           <li class="image-selected-name pb-0 text-wrap">' +
                  address_doc[n] +
                  "</li>";
                html +=
                  '                           <li class="image-name-delete pb-0">';
                html +=
                  '                               <a id="docs_modal_file' +
                  data.component_data.candidate_id +
                  '" onclick="view_edu_docs_modal(\'' +
                  url +
                  '\')" data-view_docs="' +
                  address_doc[n] +
                  '" class="image-name-delete-a">';
                html +=
                  '                                   <i class="fa fa-eye text-primary"></i>';
                html += "                               </a>";
                html +=
                  '                               <a download id="docs_modal_file' +
                  data.component_data.candidate_id +
                  '" href="' +
                  url +
                  '" class="image-name-delete-a">';
                html +=
                  '                                   <i class="fa fa-arrow-down"></i>';
                html += "                               </a>";
                html += "                           </li>";
                html += "                        </ul>";
                html += "                   </div>";
                html += "                 </div>";
              } else if (/\.(pdf)$/i.test(address_doc[n])) {
                html +=
                  '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
                html += '                   <div class="image-selected-div">';
                html += '                       <ul class="p-0 mb-0">';
                html +=
                  '                           <li class="image-selected-name pb-0 text-wrap">' +
                  address_doc[n] +
                  "</li>";
                html +=
                  '                           <li class="image-name-delete pb-0">';
                html +=
                  '                               <a download id="docs_modal_file' +
                  data.component_data.candidate_id +
                  '" href="' +
                  url +
                  '" class="image-name-delete-a">';
                html +=
                  '                                   <i class="fa fa-arrow-down"></i>';
                html += "                               </a>";
                html += "                           </li>";
                html += "                        </ul>";
                html += "                   </div>";
                html += "                 </div>";
              }
            }
          } else {
            html +=
              '               <div class="pg-frm-hd">There is no file </div>';
          }
        }

        html += "            </div>";
        html += "   </div>";

        if (data.component_data.is_submitted != "0") {
          html +=
            '   <button class="insuf-btn ' +
            none +
            '" id="insuf_btn_' +
            i +
            '" ' +
            insuffDisable +
            ' onclick="modalInsuffi(' +
            data.component_data.candidate_id +
            ",'" +
            2 +
            "','court records','" +
            priority +
            "'," +
            i +
            ",'double')\">Raise Insufficiency</button>";
          html +=
            '   <button class="app-btn ' +
            none +
            '" id="app_btn_' +
            i +
            '" ' +
            approvDisable +
            ' onclick="modalapprov(' +
            data.component_data.candidate_id +
            ",'" +
            2 +
            "','court records','" +
            priority +
            "'," +
            i +
            ",'double')\"><i id=\"app_btn_icon_" +
            i +
            '" class="fa fa-check ' +
            rightClass +
            '"></i> Approve</button>';
        }
        html += "   <hr>";
      }
    } else {
      html += '         <div class="row">';
      html += '            <div class="col-md-12">';
      html += '               <h6 class="full-nam2">Incorrect details.</h6>';
      html += "            </div>";
      html += "         </div>";
    }

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                 <button id="add_court" onclick="add_court()" class="btn bg-blu text-white ">Update</button>';
    html +=
      '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function document_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  console.log("document_check : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var formValues = JSON.parse(data.component_data.form_values);
    formValues = JSON.parse(formValues);

    var passport_doc = data.component_data.passport_doc;
    if (passport_doc == null || passport_doc == "") {
      passport_doc_length = 0;
    } else {
      passport_doc = passport_doc.split(",");
      passport_doc_length = passport_doc.length;
    }

    var pan_card_doc = data.component_data.pan_card_doc;
    if (pan_card_doc == null || pan_card_doc == "") {
      pan_card_doc_length = 0;
    } else {
      pan_card_doc = pan_card_doc.split(",");
      pan_card_doc_length = pan_card_doc.length;
    }

    var adhar_doc = data.component_data.adhar_doc;
    if (adhar_doc == null || adhar_doc == "") {
      adhar_doc_length = 0;
    } else {
      adhar_doc = adhar_doc.split(",");
      adhar_doc_length = adhar_doc.length;
    }

    var voter_doc = data.component_data.voter_doc;
    if (voter_doc == null || voter_doc == "") {
      adhar_doc_length = 0;
    } else {
      voter_doc = voter_doc.split(",");
      adhar_doc_length = voter_doc.length;
    }

    var ssn_doc = data.component_data.ssn_doc;
    if (ssn_doc == null || ssn_doc == "") {
      adhar_doc_length = 0;
    } else {
      ssn_doc = ssn_doc.split(",");
      adhar_doc_length = ssn_doc.length;
    }

    html +=
      '<input name=""  class="fld form-control document_check_id" id="document_check_id" type="hidden" value="' +
      data.component_data.document_check_id +
      '">';

    var inputQcStatus = data.component_data.status.split(",");

    // alert(inputQcStatus)

    // alert(typeof formValues.document_check)
    // alert('formValues.document_check : '+formValues.document_check)
    // alert('formValues.document_check haji ek var parse : '+JSON.parse(formValues.document_check))
    if (
      data.component_data.aadhar_number.length > 0 &&
      $.inArray("2", formValues.document_check) !== -1
    ) {
      var adharcardStatus = indexFromTheValue(formValues.document_check, "2");
      // if(inputQcStatus[adharcardStatus] == '1' )
      var insuffDisable = "";
      var approvDisable = "";
      var rightClass = "";
      var form_status = "";
      var none = "";
      var none_btn = "";
      if (inputQcStatus[adharcardStatus] == "0") {
        none = "d-none";
        form_status = '<span class="text-warning">Pending</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (inputQcStatus[adharcardStatus] == "1") {
        none = "d-none";
        form_status = '<span class="text-info">Form Filled</span>';
        fontAwsom = '<i class="fa fa-check">';
        rightClass = "bac-gr";
      } else if (inputQcStatus[adharcardStatus] == "2") {
        form_status = '<span class="text-success">Completed</span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else if (inputQcStatus[adharcardStatus] == "3") {
        form_status = '<span class="text-danger">Insufficiency</span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
      } else if (inputQcStatus[adharcardStatus] == "4") {
        form_status = '<span class="text-success">Verified Clear</span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending</span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      if (
        data.component_data.aadhar_number.length > 0 &&
        $.inArray("2", formValues.document_check) !== -1
      ) {
        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm-hd">Adhar Card</div>';
        html +=
          '                  <label class="font-weight-bold">Verification Status: </label>' +
          form_status;
        html +=
          '                  <input name=""  class="fld form-control adhar_number" id="adhar_number" type="text" value="' +
          data.component_data.aadhar_number +
          '">';
        // for loop will start
        if (
          adhar_doc != "" &&
          adhar_doc != null &&
          data.component_data.aadhar_number != "" &&
          data.component_data.aadhar_number != null &&
          data.component_data.aadhar_number != "undefined"
        ) {
          for (var i = 0; i < adhar_doc.length; i++) {
            var url = img_base_url + "../uploads/aadhar-docs/" + adhar_doc[i];

            if (/\.(jpg|jpeg|png)$/i.test(adhar_doc[i])) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0">' +
                adhar_doc[i] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a id="docs_modal_file' +
                data.component_data.candidate_id +
                '" onclick="view_edu_docs_modal(\'' +
                url +
                '\')" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-eye text-primary"></i>';
              html += "                               </a>";
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            } else if (/\.(pdf)$/i.test(adhar_doc[i])) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0">' +
                adhar_doc[i] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              // onclick="view_document_modal('+data.component_data.candidate_id+',\'aadhar-docs\')"
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            }

            // html += '   <hr>';
          }
          if (data.component_data.is_submitted != "0") {
            html +=
              '   <button class="insuf-btn ' +
              none +
              '" id="insuf_btn_' +
              adharcardStatus +
              '" ' +
              insuffDisable +
              ' onclick="modalInsuffi(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              adharcardStatus +
              ",'double')\">Raise Insufficiency</button>"; // modalInsuffi(candidate_id,component_id,componentname,priority,position,status)
            html +=
              '   <button class="app-btn ' +
              none +
              '" id="app_btn_' +
              adharcardStatus +
              '" ' +
              approvDisable +
              ' onclick="modalapprov(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              adharcardStatus +
              ',\'double\')"><i id="app_btn_icon" class="fa fa-check ' +
              rightClass +
              '"></i> Approve</button>';
          }
        } else {
          html +=
            '   <label class="font-weight-bold">Note: No attachment found. </label><br>';
          if (data.component_data.is_submitted != "0") {
            html +=
              '   <button class="insuf-btn ' +
              none +
              '" desabled id="insuf_btn_' +
              passportStatus +
              '" ' +
              insuffDisable +
              ' onclick="modalInsuffi(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              passportStatus +
              ",'double')\">Raise Insufficiency</button>";
            html +=
              '   <button class="app-btn ' +
              none +
              '" desabled id="app_btn_' +
              passportStatus +
              '" ' +
              approvDisable +
              ' onclick="modalapprov(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              passportStatus +
              ",'double')\"><i id=\"app_btn_icon_" +
              passportStatus +
              '" class="fa fa-check ' +
              rightClass +
              '"></i> Approve</button>';
          }
        }
      }
      // for loop will end
      html += "            </div>";
    }

    if (
      data.component_data.pan_number.length > 0 &&
      $.inArray("1", formValues.document_check) !== -1
    ) {
      var pancardStatus = indexFromTheValue(formValues.document_check, "1");

      var insuffDisable = "";
      var approvDisable = "";
      var rightClass = "";
      var form_status = "";
      var none = "";
      if (inputQcStatus[pancardStatus] == "0") {
        none = "d-none";
        form_status = '<span class="text-warning">Pending</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (inputQcStatus[pancardStatus] == "1") {
        none = "d-none";
        form_status = '<span class="text-info">Form Filled</span>';
        fontAwsom = '<i class="fa fa-check">';
        rightClass = "bac-gr";
      } else if (inputQcStatus[pancardStatus] == "2") {
        form_status = '<span class="text-success">Completed</span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else if (inputQcStatus[pancardStatus] == "3") {
        form_status = '<span class="text-danger">Insufficiency</span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
      } else if (inputQcStatus[pancardStatus] == "4") {
        form_status = '<span class="text-success">Verified Clear</span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending</span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm-hd">PAN Card</div>';
      html +=
        '                  <label class="font-weight-bold">Verification Status: </label>' +
        form_status;
      html +=
        '                  <input name=""  class="fld form-control pancard" id="pancard" type="text" value="' +
        data.component_data.pan_number +
        '">';
      // for loop will start
      if (
        pan_card_doc != "" &&
        pan_card_doc != null &&
        data.component_data.pan_number != "" &&
        data.component_data.pan_number != null &&
        data.component_data.pan_number != "undefined"
      ) {
        for (var i = 0; i < pan_card_doc.length; i++) {
          var url = img_base_url + "../uploads/pan-docs/" + pan_card_doc[i];
          if (/\.(jpg|jpeg|png)$/i.test(pan_card_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              pan_card_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(pan_card_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              pan_card_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
        }
        if (data.component_data.is_submitted != "0") {
          html +=
            '   <button class="insuf-btn ' +
            none +
            '" id="insuf_btn_' +
            pancardStatus +
            '" ' +
            insuffDisable +
            ' onclick="modalInsuffi(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            pancardStatus +
            ",'double')\">Raise Insufficiency</button>";
          html +=
            '   <button class="app-btn ' +
            none +
            '" id="app_btn_' +
            pancardStatus +
            '" ' +
            approvDisable +
            ' onclick="modalapprov(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            pancardStatus +
            ",'double')\"><i id=\"app_btn_icon_" +
            i +
            '" class="fa fa-check ' +
            rightClass +
            '"></i> Approve</button>';
        }
      } else {
        html +=
          '   <label class="font-weight-bold">Note: No attachment found. </label><br>';
        if (data.component_data.is_submitted != "0") {
          html +=
            '   <button class="insuf-btn ' +
            none +
            '" desabled id="insuf_btn_' +
            passportStatus +
            '" ' +
            insuffDisable +
            ' onclick="modalInsuffi(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            passportStatus +
            ",'double')\">Raise Insufficiency</button>";
          html +=
            '   <button class="app-btn ' +
            none +
            '" desabled id="app_btn_' +
            passportStatus +
            '" ' +
            approvDisable +
            ' onclick="modalapprov(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            passportStatus +
            ",'double')\"><i id=\"app_btn_icon_" +
            passportStatus +
            '" class="fa fa-check ' +
            rightClass +
            '"></i> Approve</button>';
        }
      }
      // for loop will end
      html += "        </div>";
    }

    if (
      data.component_data.passport_number != "" &&
      data.component_data.passport_number != null &&
      $.inArray("3", formValues.document_check) !== -1
    ) {
      var passportStatus = indexFromTheValue(formValues.document_check, "3");
      // alert(typeof formValues.document_check)
      // alert(formValues.document_check)
      // alert(formValues.document_check.indexOf('3'))
      var psinsuffDisable = "";
      var psapprovDisable = "";
      var rightClass = "";
      var form_status = "";
      var none = "";
      // alert('passportStatus: '+passportStatus)
      if (inputQcStatus[passportStatus] == "0") {
        // alert('0: '+passportStatus)
        none = "d-none";
        form_status = '<span class="text-warning">Pending</span>';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gy";
      } else if (inputQcStatus[passportStatus] == "1") {
        // alert('1: '+passportStatus)
        none = "d-none";
        form_status = '<span class="text-info">Form Filled</span>';
        fontAwsom = '<i class="fa fa-check">';
        // psinsuffDisable = 'disabled'
        // psapprovDisable = 'disabled'
        rightClass = "bac-gr";
      } else if (inputQcStatus[passportStatus] == "2") {
        // alert('2: '+passportStatus)
        form_status = '<span class="text-success">Completed</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gr";
      } else if (inputQcStatus[passportStatus] == "3") {
        // alert('3: '+passportStatus)
        form_status = '<span class="text-danger">Insufficiency</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
      } else if (inputQcStatus[passportStatus] == "4") {
        // alert('4: '+passportStatus)
        form_status = '<span class="text-success">Verified Clear</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm-hd">Passport</div>';
      html +=
        '                  <label class="font-weight-bold">Verification Status: </label>' +
        form_status;
      html +=
        '                  <input name=""  class="fld form-control passport_number" id="passport_number" type="text" value="' +
        data.component_data.passport_number +
        '">';
      // for loop will start passport_doc.length
      if (
        passport_doc != "" &&
        passport_doc != null &&
        data.component_data.passport_number != "" &&
        data.component_data.passport_number != null &&
        data.component_data.passport_number != "undefined"
      ) {
        for (var i = 0; i < passport_doc.length; i++) {
          var url = img_base_url + "../uploads/proof-docs/" + passport_doc[i];
          if (/\.(jpg|jpeg|png)$/i.test(passport_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              passport_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '"  class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(passport_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              passport_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '"  class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
          if (data.component_data.is_submitted != "0") {
            html +=
              '   <button class="insuf-btn ' +
              none +
              '" id="insuf_btn_' +
              passportStatus +
              '" ' +
              psinsuffDisable +
              ' onclick="modalInsuffi(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              passportStatus +
              ",'double')\">Raise Insufficiency</button>";
            html +=
              '   <button class="app-btn ' +
              none +
              '" id="app_btn_' +
              passportStatus +
              '" ' +
              psapprovDisable +
              ' onclick="modalapprov(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              passportStatus +
              ",'double')\"><i id=\"app_btn_icon_" +
              passportStatus +
              '" class="fa fa-check ' +
              rightClass +
              '"></i> Approve</button>';
          }
        }
      } else {
        html +=
          '   <label class="font-weight-bold">Note: No attachment found. </label><br>';
        if (data.component_data.is_submitted != "0") {
          html +=
            '   <button class="insuf-btn ' +
            none +
            '" desabled id="insuf_btn_' +
            passportStatus +
            '" onclick="modalInsuffi(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            passportStatus +
            ",'double')\">Raise Insufficiency</button>";
          html +=
            '   <button class="app-btn ' +
            none +
            '" desabled id="app_btn_' +
            passportStatus +
            '" onclick="modalapprov(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            passportStatus +
            ",'double')\"><i id=\"app_btn_icon_" +
            passportStatus +
            '" class="fa fa-check ' +
            rightClass +
            '"></i> Approve</button>';
        }
      }
      // for loop will end
      html += "         </div>";
      html += "      </div>";
    }

    if (
      data.component_data.voter_id != "" &&
      data.component_data.voter_id != null &&
      $.inArray("4", formValues.document_check) !== -1
    ) {
      var passportStatus = indexFromTheValue(formValues.document_check, "4");
      // alert(typeof formValues.document_check)
      // alert(formValues.document_check)
      // alert(formValues.document_check.indexOf('3'))
      var psinsuffDisable = "";
      var psapprovDisable = "";
      var rightClass = "";
      var form_status = "";
      var none = "";
      // alert('passportStatus: '+passportStatus)
      if (inputQcStatus[passportStatus] == "0") {
        // alert('0: '+passportStatus)
        none = "d-none";
        form_status = '<span class="text-warning">Pending</span>';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gy";
      } else if (inputQcStatus[passportStatus] == "1") {
        // alert('1: '+passportStatus)
        none = "d-none";
        form_status = '<span class="text-info">Form Filled</span>';
        fontAwsom = '<i class="fa fa-check">';
        // psinsuffDisable = 'disabled'
        // psapprovDisable = 'disabled'
        rightClass = "bac-gr";
      } else if (inputQcStatus[passportStatus] == "2") {
        // alert('2: '+passportStatus)
        form_status = '<span class="text-success">Completed</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gr";
      } else if (inputQcStatus[passportStatus] == "3") {
        // alert('3: '+passportStatus)
        form_status = '<span class="text-danger">Insufficiency</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
      } else if (inputQcStatus[passportStatus] == "4") {
        // alert('4: '+passportStatus)
        form_status = '<span class="text-success">Verified Clear</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm-hd">Voter Card</div>';
      html +=
        '                  <label class="font-weight-bold">Verification Status: </label>' +
        form_status;
      html +=
        '                  <input name=""  class="fld form-control city" id="city" type="text" value="' +
        data.component_data.voter_id +
        '">';
      // for loop will start passport_doc.length
      if (
        voter_doc != "" &&
        voter_doc != null &&
        data.component_data.voter_id != "" &&
        data.component_data.voter_id != null &&
        data.component_data.voter_id != "undefined"
      ) {
        for (var i = 0; i < voter_doc.length; i++) {
          var url = img_base_url + "../uploads/voter-docs/" + voter_doc[i];
          if (/\.(jpg|jpeg|png)$/i.test(voter_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              voter_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '"  class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(voter_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              voter_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '"  class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
          if (data.component_data.is_submitted != "0") {
            html +=
              '   <button class="insuf-btn ' +
              none +
              '" id="insuf_btn_' +
              passportStatus +
              '" ' +
              psinsuffDisable +
              ' onclick="modalInsuffi(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              passportStatus +
              ",'double')\">Raise Insufficiency</button>";
            html +=
              '   <button class="app-btn ' +
              none +
              '" id="app_btn_' +
              passportStatus +
              '" ' +
              psapprovDisable +
              ' onclick="modalapprov(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              passportStatus +
              ",'double')\"><i id=\"app_btn_icon_" +
              passportStatus +
              '" class="fa fa-check ' +
              rightClass +
              '"></i> Approve</button>';
          }
        }
      } else {
        html +=
          '   <label class="font-weight-bold">Note: No attachment found. </label><br>';
        if (data.component_data.is_submitted != "0") {
          html +=
            '   <button class="insuf-btn ' +
            none +
            '" desabled id="insuf_btn_' +
            passportStatus +
            '" onclick="modalInsuffi(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            passportStatus +
            ",'double')\">Raise Insufficiency</button>";
          html +=
            '   <button class="app-btn ' +
            none +
            '" desabled id="app_btn_' +
            passportStatus +
            '" onclick="modalapprov(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            passportStatus +
            ",'double')\"><i id=\"app_btn_icon_" +
            passportStatus +
            '" class="fa fa-check ' +
            rightClass +
            '"></i> Approve</button>';
        }
      }
      // for loop will end
      html += "         </div>";
      html += "      </div>";
    }

    if (
      data.component_data.ssn_number != "" &&
      data.component_data.ssn_number != null &&
      $.inArray("5", formValues.document_check) !== -1
    ) {
      var passportStatus = indexFromTheValue(formValues.document_check, "5");
      // alert(typeof formValues.document_check)
      // alert(formValues.document_check)
      // alert(formValues.document_check.indexOf('3'))
      var psinsuffDisable = "";
      var psapprovDisable = "";
      var rightClass = "";
      var form_status = "";
      var none = "";
      // alert('passportStatus: '+passportStatus)
      if (inputQcStatus[passportStatus] == "0") {
        // alert('0: '+passportStatus)
        none = "d-none";
        form_status = '<span class="text-warning">Pending</span>';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gy";
      } else if (inputQcStatus[passportStatus] == "1") {
        // alert('1: '+passportStatus)
        none = "d-none";
        form_status = '<span class="text-info">Form Filled</span>';
        fontAwsom = '<i class="fa fa-check">';
        // psinsuffDisable = 'disabled'
        // psapprovDisable = 'disabled'
        rightClass = "bac-gr";
      } else if (inputQcStatus[passportStatus] == "2") {
        // alert('2: '+passportStatus)
        form_status = '<span class="text-success">Completed</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gr";
      } else if (inputQcStatus[passportStatus] == "3") {
        // alert('3: '+passportStatus)
        form_status = '<span class="text-danger">Insufficiency</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
      } else if (inputQcStatus[passportStatus] == "4") {
        // alert('4: '+passportStatus)
        form_status = '<span class="text-success">Verified Clear</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending</span>';
        fontAwsom = '<i class="fa fa-check">';
        psinsuffDisable = "disabled";
        psapprovDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm-hd">SSN Card</div>';
      html +=
        '                  <label class="font-weight-bold">Verification Status: </label>' +
        form_status;
      html +=
        '                  <input name=""  class="fld form-control city" id="city" type="text" value="' +
        data.component_data.ssn_number +
        '">';
      // for loop will start passport_doc.length
      if (
        ssn_doc != "" &&
        ssn_doc != null &&
        data.component_data.ssn_number != "" &&
        data.component_data.ssn_number != null &&
        data.component_data.ssn_number != "undefined"
      ) {
        for (var i = 0; i < ssn_doc.length; i++) {
          var url = img_base_url + "../uploads/ssn_doc/" + ssn_doc[i];
          if (/\.(jpg|jpeg|png)$/i.test(ssn_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              ssn_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '"  class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(ssn_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              ssn_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '"  class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
          if (data.component_data.is_submitted != "0") {
            html +=
              '   <button class="insuf-btn ' +
              none +
              '" id="insuf_btn_' +
              passportStatus +
              '" ' +
              psinsuffDisable +
              ' onclick="modalInsuffi(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              passportStatus +
              ",'double')\">Raise Insufficiency</button>";
            html +=
              '   <button class="app-btn ' +
              none +
              '" id="app_btn_' +
              passportStatus +
              '" ' +
              psapprovDisable +
              ' onclick="modalapprov(' +
              data.component_data.candidate_id +
              ",'" +
              3 +
              "','Adhar card document check','" +
              priority +
              "'," +
              passportStatus +
              ",'double')\"><i id=\"app_btn_icon_" +
              passportStatus +
              '" class="fa fa-check ' +
              rightClass +
              '"></i> Approve</button>';
          }
        }
      } else {
        html +=
          '   <label class="font-weight-bold">Note: No attachment found. </label><br>';
        if (data.component_data.is_submitted != "0") {
          html +=
            '   <button class="insuf-btn ' +
            none +
            '" desabled id="insuf_btn_' +
            passportStatus +
            '" onclick="modalInsuffi(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            passportStatus +
            ",'double')\">Raise Insufficiency</button>";
          html +=
            '   <button class="app-btn ' +
            none +
            '" desabled id="app_btn_' +
            passportStatus +
            '" onclick="modalapprov(' +
            data.component_data.candidate_id +
            ",'" +
            3 +
            "','Adhar card document check','" +
            priority +
            "'," +
            passportStatus +
            ",'double')\"><i id=\"app_btn_icon_" +
            passportStatus +
            '" class="fa fa-check ' +
            rightClass +
            '"></i> Approve</button>';
        }
      }
      // for loop will end
      html += "         </div>";
      html += "      </div>";
    }

    // /else{
    //     html += '         <div class="row">';
    //     html += '            <div class="col-md-12">';
    //     html += '               <h6 class="full-nam2">Incorrect Data</h6>';
    //     html += '            </div>';
    //     html += '         </div>';
    // }/////////////
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  html += '         <div class="row">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                 <button id="add_document" onclick="add_document()" class="btn bg-blu text-white">Update</button>';
  html +=
    '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";
  $("#component-detail").html(html);
}

function drugtest(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  console.log("drugtest : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  var address = JSON.parse(data.component_data.address);
  var candidate_name = JSON.parse(data.component_data.candidate_name);
  var father_name = JSON.parse(data.component_data.father__name);
  var dob = JSON.parse(data.component_data.dob);
  var mobile_number = JSON.parse(data.component_data.mobile_number);
  var component_status = data.component_data.status.split(",");
  let html = "";

  var form_values = JSON.parse(data.component_data.form_values);
  var form_values = JSON.parse(form_values);
  // alert(form_values['drug_test'].length)
  // console.log(candidate_name)
  // console.log(candidate_name.length)

  drugtestTypes = [
    "5-Panel",
    "6-Panel",
    "7-Panel",
    "9-Panel",
    "10-Panel",
    "12-Panel",
  ];
  drugtestTypesIds = ["1", "2", "3", "4", "5", "6"];

  html +=
    '<input name=""  value="' +
    data.component_data.drugtest_id +
    '" class="fld form-control drugtest_id" id="drugtest_id" type="hidden">';
  var j = 1;
  if (data.status != "0") {
    if (candidate_name.length > 0) {
      for (var i = 0; i < form_values["drug_test"].length; i++) {
        var form_status = "";
        var insuffDisable = "";
        var approvDisable = "";
        var rightClass = "";
        var none = "";
        if (component_status[i] == "0") {
          none = "d-none";
          form_status = '<span class="text-warning">Pending<span>';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gy";
        } else if (component_status[i] == "1") {
          none = "d-none";
          form_status = '<span class="text-info">Form Filled<span>';
          fontAwsom = '<i class="fa fa-check">';
          rightClass = "bac-gr";
        } else if (component_status[i] == "2") {
          form_status = '<span class="text-success">Completed<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gr";
        } else if (component_status[i] == "3") {
          form_status = '<span class="text-danger">Insufficiency<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
        } else if (component_status[i] == "4") {
          form_status = '<span class="text-success">Verified Clear<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gr";
        } else {
          form_status = '<span class="text-warning">Pending<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gy";
        }

        drugtestTypesId = form_values["drug_test"][i];

        html += ' <div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps  d-none">Step 2/6</div>';
        // html += '         <h6 class="full-nam2">Test Details</h6>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        if ($.inArray(drugtestTypesId, drugtestTypes)) {
          // alert(drugtestTypes[drugtestTypesIds.indexOf(drugtestTypesId)])
          html +=
            '               <h6 class="full-nam2 font-weight-bold">Test Details ' +
            drugtestTypes[drugtestTypesIds.indexOf(drugtestTypesId)] +
            "</h6> ";
        }

        html += "            </div>";
        html += '            <div class="col-md-4">';
        html +=
          '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_' +
          i +
          '">' +
          form_status +
          "</span>";
        html += "            </div>";
        html += "         </div>";
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Candidate Name</label>";
        html +=
          '                  <input name=""  value="' +
          candidate_name[i].candidate_name +
          '" class="fld form-control drug-candidate_name" id="pincode" type="text">';
        html += "               </div>";
        html += "            </div>";

        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Father Name</label>";
        html +=
          '                  <input name=""  value="' +
          father_name[i].father_name +
          '" class="fld form-control drug-father_name" id="father_name" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Date Of Birth(DOB)</label>";
        html +=
          '                  <input name=""  value="' +
          dob[i].dob +
          '"  class="fld form-control drug-dob" id="dob" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += "         </div>";

        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Phone Number</label>";
        html +=
          '                  <input name=""  value="' +
          mobile_number[i].mobile_number +
          '"  class="fld form-control drug-mobile_number" id="mobile_number" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += '            <div class="col-md-6">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Address</label>";
        html +=
          '                  <textarea class="fld form-control drug-address"   rows="2" id="address">' +
          address[i].address +
          "</textarea>";
        html += "               </div>";
        html += "            </div>";
        html += "         </div>";
        html += "      </div>";
        html += "   </div>";

        if (component_status[i] == "3") {
          html += '<div class="row">';
          html +=
            '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
          html += '<div class="col-md-12">';
          html += "<label>Insuff Remark Comment</label>";
          html +=
            '<textarea readonly  class="input-field form-control">' +
            insuff_remarks[i].insuff_remarks +
            "</textarea>";
          html += "</div>";
          html += "</div>";
        }

        if (data.component_data.is_submitted != "0") {
          html +=
            '   <button class="insuf-btn ' +
            none +
            '" id="insuf_btn_' +
            i +
            '" ' +
            insuffDisable +
            ' onclick="modalInsuffi(' +
            data.component_data.candidate_id +
            ",'" +
            4 +
            "','Drugtest','" +
            priority +
            "'," +
            i +
            ",'double')\">Raise Insufficiency</button>";
          html +=
            '   <button class="app-btn ' +
            none +
            '" id="app_btn_' +
            i +
            '" ' +
            approvDisable +
            ' onclick="modalapprov(' +
            data.component_data.candidate_id +
            ",'" +
            4 +
            "','Drugtest','" +
            priority +
            "'," +
            i +
            ",'double')\"><i id=\"app_btn_icon_" +
            i +
            '" class="fa fa-check ' +
            rightClass +
            '"></i> Approve</button>';
        }
        html += "   <hr>";
      }
    } else {
      html += '         <div class="row">';
      html += '            <div class="col-md-12">';
      html += '               <h6 class="full-nam2">Incorrect Data</h6>';
      html += "            </div>";
      html += "         </div>";
    }
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_drug" onclick="add_drug()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function globaldatabase(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html +=
      '<input name=""  value="' +
      data.component_data.globaldatabase_id +
      '" class="fld form-control pincode" id="globaldatabase_id" type="hidden">';

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps  d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Test Details</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html +=
      '               <h6 class="full-nam2 font-weight-bold">Global Database Details</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Candidate Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.candidate_name +
      '" class="fld form-control global-candidate_name" id="global-candidate_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Father Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.father_name +
      '" class="fld form-control global-father_name" id="global-father_name" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Date Of Birth(DOB)</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.dob +
      '"  class="fld form-control global-dob" id="global-dob" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";

    html += '         <div class="row d-none">';
    html += '            <div class="col-md-4 d-none">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Phone Number</label>";
    // html += '                  <input name=""  value="'+data.component_data.mobile_number+'"  class="fld form-control state" id="state" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-6">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Address</label>";
    // html += '                  <textarea class="fld form-control"   rows="2" id="address">'+data.component_data.address+'</textarea>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn ' +
        none +
        '" id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        5 +
        "','Global Database','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn ' +
        none +
        '" id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        5 +
        "','Global Database','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function current_employment(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log("current_employment: "+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  // alert(data.component_data.length)
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html += '<div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html +=
      '               <h6 class="full-nam2 d-none">Global Database Details</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Desigination</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.current_emp_id +
      '" class="fld form-control" id="current_emp_id" type="hidden">';
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.desigination +
      '" class="fld form-control current-designation" id="current-designation" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Department</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.department +
      '"  class="fld form-control current-department" id="current-department" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Employee ID</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.employee_id +
      '"  class="fld form-control current-employee_id" id="current-employee_id" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Company Name</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.company_name +
      '" class="fld form-control" id="current-company-name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Company Website</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.company_url +
      '" class="fld form-control" id="current-company-url" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-8">';
    html += '                <div class="pg-frm">';
    html += "                   <label>Address</label>";
    html +=
      '                   <textarea ="" class="fla form-control" id="current-address" type="text">' +
      data.component_data.address +
      "</textarea>";
    html += "                </div>";
    html += "             </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Annual CTC</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.annual_ctc +
      '" class="fld" id="current-annual-ctc" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-8">';
    html += '                <div class="pg-frm">';
    html += "                   <label>Reason For Leaving</label>";
    html +=
      '                   <input name="" ="" value="' +
      data.component_data.reason_for_leaving +
      '" class="fld" id="current-reasion"  type="text">';
    html += "                </div>";
    html += "             </div>";
    html += "         </div>";
    /*   html += '         <div class="row">';
        html += '             <div class="col-md-5">';
        html += '                <div class="pg-frm-hd">Joining Date</div>';
        html += '             </div>';
        html += '             <div class="col-md-4">';
        html += '                <div class="pg-frm-hd">relieving date</div>';
        html += '             </div>';
        html += '         </div>';*/
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "               <label>Joining Date</label>";
    html +=
      '                <input name="" ="" value="' +
      data.component_data.joining_date +
      '"  class="fld form-control mdate" id="current-joining-date" type="text">';

    html += "            </div>";
    html += "            </div>";
    html += '            <div class="col-md-1">';
    html += "           </div>";
    html += '           <div class="col-md-3 ml-2">';
    html += '               <div class="pg-frm">';
    html += "            <label>Relieving Date</label>";
    html +=
      '                <input name="" ="" value="' +
      data.component_data.relieving_date +
      '"  class="fld form-control mdate" id="current-relieving-date" type="text">';

    html += "         </div>";
    html += "         </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reporting Manager Name</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.reporting_manager_name +
      '"  class="fld form-control" id="current-reporting-manager-name" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reporting Manager Designation</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.reporting_manager_desigination +
      '"  class="fld form-control" id="current-reporting-manager-designation" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reporting Manager Contact Number</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.reporting_manager_contact_number +
      '"  class="fld form-control" id="current-reporting-manager-contact" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reporting Manager Email</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.reporting_manager_email_id +
      '"  class="fld form-control" id="current-reporting-manager-contact" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>HR Contact Name</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.hr_name +
      '"  class="fld form-control" id="current-hr-name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>HR Contact Number</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.hr_contact_number +
      '"  class="fld form-control" id="current-hr-contact" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>HR Email ID</label>";
    html +=
      '                  <input name="" ="" value="' +
      data.component_data.hr_email_id +
      '"  class="fld form-control" id="current-hr-contact" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += "         </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.Insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }

    html += '         <div class="row mt-3">';
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm-hd">Appointment Letter</div>';
    if (
      data.component_data.appointment_letter != null &&
      data.component_data.appointment_letter != ""
    ) {
      var appointment_letter = data.component_data.appointment_letter;
      var appointment_letter = appointment_letter.split(",");
      for (var i = 0; i < appointment_letter.length; i++) {
        var url =
          img_base_url +
          "../uploads/appointment_letter/" +
          appointment_letter[i];
        if (/\.(jpg|jpeg|png)$/i.test(appointment_letter[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            appointment_letter[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            appointment_letter[i] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(appointment_letter[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            appointment_letter[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }

    html += "            </div>";
    html += '            <div class="col-md-3">';
    html +=
      '               <div class="pg-frm-hd">Experience/Relieving Letter</div>';
    if (
      data.component_data.experience_relieving_letter != null &&
      data.component_data.experience_relieving_letter != ""
    ) {
      var experience_relieving_letter =
        data.component_data.experience_relieving_letter;
      var experience_relieving_letter = experience_relieving_letter.split(",");
      for (var k = 0; k < experience_relieving_letter.length; k++) {
        var url =
          img_base_url +
          "../uploads/experience_relieving_letter/" +
          experience_relieving_letter[k];
        if (/\.(jpg|jpeg|png)$/i.test(experience_relieving_letter[k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            experience_relieving_letter[k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            experience_relieving_letter[k] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(experience_relieving_letter[k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            experience_relieving_letter[k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm-hd">Pay Slip</div>';
    if (
      data.component_data.last_month_pay_slip != null &&
      data.component_data.last_month_pay_slip != ""
    ) {
      var last_month_pay_slip = data.component_data.last_month_pay_slip;
      var last_month_pay_slip = last_month_pay_slip.split(",");
      for (var k = 0; k < last_month_pay_slip.length; k++) {
        var url =
          img_base_url +
          "../uploads/last_month_pay_slip/" +
          last_month_pay_slip[k];
        if (/\.(jpg|jpeg|png)$/i.test(last_month_pay_slip[k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            last_month_pay_slip[k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            last_month_pay_slip[k] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(last_month_pay_slip[k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0  text-wrap">' +
            last_month_pay_slip[k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    html += "            </div>";

    html += '            <div class="col-md-3">';
    html +=
      '               <div class="pg-frm-hd">Resignation Acceptance Letter/ Mail</div>';
    if (
      data.component_data
        .ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance !=
        null ||
      data.component_data
        .ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance !=
        ""
    ) {
      var bank_statement_resigngation_acceptance_doc =
        data.component_data.bank_statement_resigngation_acceptance;
      var bank_statement_resigngation_acceptance_doc =
        bank_statement_resigngation_acceptance_doc.split(",");
      for (
        var i = 0;
        i < bank_statement_resigngation_acceptance_doc.length;
        i++
      ) {
        var url =
          img_base_url +
          "../uploads/bank_statement_resigngation_acceptance/" +
          bank_statement_resigngation_acceptance_doc[i];
        if (
          /\.(jpg|jpeg|png)$/i.test(
            bank_statement_resigngation_acceptance_doc[i]
          )
        ) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            bank_statement_resigngation_acceptance_doc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            bank_statement_resigngation_acceptance_doc[i] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (
          /\.(pdf)$/i.test(bank_statement_resigngation_acceptance_doc[i])
        ) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            bank_statement_resigngation_acceptance_doc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }

    html += "            </div>";
    html += "         </div>";
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn ' +
        none +
        '" id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        6 +
        "','Current employment','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn ' +
        none +
        '" id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        6 +
        "','Current employment','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                  <button id="add_current_employments" onclick="add_current_employments()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  html += "      </div>";
  html += "   </div>";

  $("#component-detail").html(html);
}

function education_details(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('education_details : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // $('#component-detail').html('');
  let html = "";
  if (data.status > 0) {
    var type_of_degree = JSON.parse(data.component_data.type_of_degree);
    var major = JSON.parse(data.component_data.major);
    var university_board = JSON.parse(data.component_data.university_board);
    var college_school = JSON.parse(data.component_data.college_school);
    var address_of_college_school = JSON.parse(
      data.component_data.address_of_college_school
    );
    var course_start_date = JSON.parse(data.component_data.course_start_date);
    var course_end_date = JSON.parse(data.component_data.course_end_date);
    var registration_roll_number = JSON.parse(
      data.component_data.registration_roll_number
    );
    var type_of_course = JSON.parse(data.component_data.type_of_course);
    var component_status = data.component_data.status.split(",");
    // if(data.component_data.year_of_passing != null || data.component_data.year_of_passing != ''){
    //  var year_of_passing = JSON.parse(data.component_data.year_of_passing)
    // }

    if (type_of_degree.length > 0) {
      var j = 1;
      var all_sem_marksheet = JSON.parse(data.component_data.all_sem_marksheet);
      var convocation = JSON.parse(data.component_data.convocation);
      var marksheet_provisional_certificate = JSON.parse(
        data.component_data.marksheet_provisional_certificate
      );
      var ten_twelve_mark_card_certificate = JSON.parse(
        data.component_data.ten_twelve_mark_card_certificate
      );

      html +=
        '<input name=""  value = "' +
        data.component_data.education_details_id +
        '" class="fld form-control education_id" id="education_id" type="hidden">';

      for (var i = 0; i < type_of_degree.length; i++) {
        // alert(type_of_degree[i].type_of_degree)

        var form_status = "";
        var insuffDisable = "";
        var approvDisable = "";
        var rightClass = "";
        var none = "";
        if (component_status[i] == "0") {
          none = "d-none";
          form_status = '<span class="text-warning">Pending<span>';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gy";
        } else if (component_status[i] == "1") {
          none = "d-none";
          form_status = '<span class="text-info">Form Filled<span>';
          fontAwsom = '<i class="fa fa-check">';
          rightClass = "bac-gr";
        } else if (component_status[i] == "2") {
          form_status = '<span class="text-success">Completed<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gr";
        } else if (component_status[i] == "3") {
          form_status = '<span class="text-danger">Insufficiency<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          var component_status = data.component_data.analyst_status.split(",");
        } else if (component_status[i] == "4") {
          form_status = '<span class="text-success">Verified Clear<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gr";
        } else {
          form_status = '<span class="text-warning">Pending<span>';
          fontAwsom = '<i class="fa fa-check">';
          insuffDisable = "disabled";
          approvDisable = "disabled";
          rightClass = "bac-gy";
        }

        html += '<div class="pg-cnt pl-0 pt-0">';
        html += '      <div class="pg-txt-cntr">';
        html += '         <div class="pg-steps d-none">Step 3/6</div>';
        html += '         <div class="row">';
        html += '            <div class="col-md-6">';
        html +=
          '               <h6 class="full-nam2 font-weight-bold">EDUCATIONAL DETAILS ' +
          j++ +
          ' <span class="high"></span></h6>';
        html += "            </div>";
        html += '            <div class="col-md-4">';
        html +=
          '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_' +
          i +
          '">' +
          form_status +
          "</span>";
        html += "            </div>";
        html += "         </div>";
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Type of Degree</label>";
        html +=
          '                  <input name=""  value = "' +
          type_of_degree[i].type_of_degree +
          '" class="fld form-control education-type_of_degree" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Major</label>";
        html +=
          '                  <input name=""    value = "' +
          major[i].major +
          '" class="fld form-control education-major" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>University</label>";
        html +=
          '                  <input name=""   value = "' +
          university_board[i].university_board +
          '" class="fld form-control education-university" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += "         </div>";
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>School / College Name</label>";
        html +=
          '                  <input name=""   value = "' +
          college_school[i].college_school +
          '" class="fld form-control education-college_name" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += '            <div class="col-md-8">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Address</label>";
        html +=
          '                  <textarea   class="add form-control education-address"  type="text">' +
          address_of_college_school[i].address_of_college_school +
          "</textarea>";
        html += "               </div>";
        html += "            </div>";
        html += "         </div>";
        html +=
          '         <div class="pg-frm-hd"><label>Duration of Course</label></div>';
        html += '         <div class="row">';
        $start = "";
        if (course_start_date.length > 0) {
          if (type_of_degree.length == course_end_date.length) {
            $start = course_start_date[i].course_start_date;
          } else {
            $start = course_start_date[0].course_start_date;
          }
        }
        $end = "";
        if (course_end_date.length > 0) {
          if (type_of_degree.length == course_end_date.length) {
            $end = course_end_date[i].course_end_date;
          } else {
            $end = course_end_date[0].course_end_date;
          }
        }
        html += '            <div class="col-md-3">';
        html += '                <div class="pg-frm">';
        // html += '                  <label>DURATION OF STAY</label>';
        html +=
          '                  <input name=""   class="fld form-control education-start-date" value = "' +
          $start +
          '" id="duration_of_stay" type="text">';
        html += "               </div>";

        html += "            </div>";
        html += '           <div class="col-md-3">';
        html += '            <div class="pg-frm">';
        // html += '               <label>Duration of Course</label>';
        html +=
          '               <input class="duration_of_course fld form-control education-end-date"   value = "' +
          $end +
          '" >';
        html += "            </div>";
        html += "         </div>";
        $corse = "full_time";
        if (type_of_course.length > 0) {
          if (type_of_degree.length == type_of_course.length) {
            $corse = type_of_course[i].type_of_course;
          } else {
            $corse = type_of_course[0].type_of_course;
          }
        }
        if ($corse == "part_time") {
          html += '         <div class="col-md-2 tp">';
          html +=
            '            <div class="custom-control custom-radio custom-control-inline mrg-btm">';
          html +=
            '               <input type="radio" checked class="custom-control-input education-part_time" name="customRadio" value="part_time" id="customRadio1">';
          html +=
            '               <label class="custom-control-label pt-1" for="customRadio1">Part Time</label>';
          html += "            </div>";
          html += "         </div>";
        } else if ($corse == "full_time") {
          html += '         <div class="col-md-2 tp">';
          html +=
            '            <div class="custom-control custom-radio custom-control-inline mrg-btm">';
          html +=
            '               <input type="radio" checked class="custom-control-input education-part_time" name="customRadio" value="full_time" id="customRadio2">';
          html +=
            '               <label class="custom-control-label pt-1" for="customRadio2">Full Time</label>';
          html += "            </div>";
          html += "         </div>";
        }

        html += "         </div>";
        html += '         <div class="row">';
        html += '            <div class="col-md-4">';
        html += '               <div class="pg-frm">';
        html += "                  <label>Registration / Roll Number</label>";
        html +=
          '                  <input name=""   class="fld education-registration_roll_number" value = "' +
          registration_roll_number[i].registration_roll_number +
          '" type="text">';
        html += "               </div>";
        html += "            </div>";
        html += "         </div>";

        if (component_status[i] == "3") {
          html += '<div class="row">';
          html +=
            '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
          html += '<div class="col-md-12">';
          html += "<label>Insuff Remark Comment</label>";
          html +=
            '<textarea readonly  class="input-field form-control">' +
            insuff_remarks[i].insuff_remarks +
            "</textarea>";
          html += "</div>";
          html += "</div>";
        }

        html += '         <div class="row mt-3">';
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">All Sem Marksheet</div>';
        // alert(all_sem_marksheet[i])

        if (
          all_sem_marksheet[i] != "no-file" &&
          all_sem_marksheet[i] != null &&
          all_sem_marksheet[i] != "" &&
          all_sem_marksheet[i].length > 0
        ) {
          // var allSemMarksheetDoc = data.component_data.all_sem_marksheet;
          // var allSemMarksheetDoc = allSemMarksheetDoc.split(",");
          for (var k = 0; k < all_sem_marksheet[i].length; k++) {
            var url =
              img_base_url +
              "../uploads/all-marksheet-docs/" +
              all_sem_marksheet[i][k];
            if (/\.(jpg|jpeg|png)$/i.test(all_sem_marksheet[i][k])) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0 text-wrap">' +
                all_sem_marksheet[i][k] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a id="docs_modal_file' +
                data.component_data.candidate_id +
                '" onclick="view_edu_docs_modal(\'' +
                url +
                '\')" data-view_docs="' +
                all_sem_marksheet[i][k] +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-eye text-primary"></i>';
              html += "                               </a>";
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            } else if (/\.(pdf)$/i.test(all_sem_marksheet[i][k])) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0 text-wrap">' +
                all_sem_marksheet[i][k] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            }
          }
        } else {
          html +=
            '               <div class="pg-frm-hd">There is no file </div>';
        }

        html += "            </div>";

        /* new images */

        html += '            <div class="col-md-3">';
        html +=
          '               <div class="pg-frm-hd">Degree Convocation/ Transcript Of Records</div>';
        if (
          convocation[i] != "no-file" &&
          convocation[i] != null &&
          convocation[i] != ""
        ) {
          // var convocation = [k]data.component_data.convocation;
          // var convocation = [k]convocation.sp[k]lit(",");
          for (var k = 0; k < convocation[i].length; k++) {
            var url =
              img_base_url + "../uploads/convocation-docs/" + convocation[i][k];
            if (/\.(jpg|jpeg|png)$/i.test(convocation[i][k])) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0 text-wrap">' +
                convocation[i][k] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a id="docs_modal_file' +
                data.component_data.candidate_id +
                '" onclick="view_edu_docs_modal(\'' +
                url +
                '\')" data-view_docs="' +
                convocation[i][k] +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-eye text-primary"></i>';
              html += "                               </a>";
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            } else if (/\.(pdf)$/i.test(convocation[i][k])) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0 text-wrap">' +
                convocation[i][k] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            }
          }
        } else {
          html +=
            '               <div class="pg-frm-hd">There is no file </div>';
        }
        html += "            </div>";

        html += '<div class="col-md-3">';
        html +=
          '<div class="pg-frm-hd">Consolidate Marksheet/ Provisional Degree Certificate</div>';
        if (
          marksheet_provisional_certificate[i] != "undefined" &&
          marksheet_provisional_certificate[i] != "no-file" &&
          marksheet_provisional_certificate[i] != null &&
          marksheet_provisional_certificate[i] != ""
        ) {
          // var marksheet_provisional_certificate = [k]data.component_data.marksheet_provisional_certificate;
          // var marksheet_provisional_certificate = [k]marksheet_provisional_certificate.sp[k]lit(",");
          for (
            var k = 0;
            k < marksheet_provisional_certificate[i].length;
            k++
          ) {
            var url =
              img_base_url +
              "../uploads/marksheet-certi-docs/" +
              marksheet_provisional_certificate[i][k];
            if (
              /\.(jpg|jpeg|png)$/i.test(marksheet_provisional_certificate[i][k])
            ) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0 text-wrap">' +
                marksheet_provisional_certificate[i][k] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a id="docs_modal_file' +
                data.component_data.candidate_id +
                '" onclick="view_edu_docs_modal(\'' +
                url +
                '\')" data-view_docs="' +
                marksheet_provisional_certificate[i][k] +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-eye text-primary"></i>';
              html += "                               </a>";
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            } else if (
              /\.(pdf)$/i.test(marksheet_provisional_certificate[i][k])
            ) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0  text-wrap">' +
                marksheet_provisional_certificate[i][k] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            }
          }
        } else {
          html +=
            '               <div class="pg-frm-hd">There is no file </div>';
        }
        html += "            </div>";

        html += '            <div class="col-md-3">';
        html +=
          '               <div class="pg-frm-hd">10th / 12th Mark Card/ Course Completion Certificate <span>(optional)</span></div>';
        if (
          ten_twelve_mark_card_certificate[i] != "no-file" &&
          ten_twelve_mark_card_certificate[i] != null &&
          ten_twelve_mark_card_certificate[i] != ""
        ) {
          // var ten_twelve_mark_card_certificate = [k]data.component_data.ten_twelve_mark_card_certificate;
          // var ten_twelve_mark_card_certificate = [k]ten_twelve_mark_card_certificate.sp[k]lit(",");
          for (var k = 0; k < ten_twelve_mark_card_certificate[i].length; k++) {
            var url =
              img_base_url +
              "../uploads/ten-twelve-docs/" +
              ten_twelve_mark_card_certificate[i][k];
            if (
              /\.(jpg|jpeg|png)$/i.test(ten_twelve_mark_card_certificate[i][k])
            ) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0 text-wrap">' +
                ten_twelve_mark_card_certificate[i][k] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a id="docs_modal_file' +
                data.component_data.candidate_id +
                '" onclick="view_edu_docs_modal(\'' +
                url +
                '\')" data-view_docs="' +
                ten_twelve_mark_card_certificate[i][k] +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-eye text-primary"></i>';
              html += "                               </a>";
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            } else if (
              /\.(pdf)$/i.test(ten_twelve_mark_card_certificate[i][k])
            ) {
              html +=
                '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
              html += '                   <div class="image-selected-div">';
              html += '                       <ul class="p-0 mb-0">';
              html +=
                '                           <li class="image-selected-name pb-0 text-wrap">' +
                ten_twelve_mark_card_certificate[i][k] +
                "</li>";
              html +=
                '                           <li class="image-name-delete pb-0">';
              html +=
                '                               <a download id="docs_modal_file' +
                data.component_data.candidate_id +
                '" href="' +
                url +
                '" class="image-name-delete-a">';
              html +=
                '                                   <i class="fa fa-arrow-down"></i>';
              html += "                               </a>";
              html += "                           </li>";
              html += "                        </ul>";
              html += "                   </div>";
              html += "                 </div>";
            }
          }
        } else {
          html +=
            '               <div class="pg-frm-hd">There is no file </div>';
        }
        html += "            </div>";

        /*end row*/
        html += "            </div>";

        /*end hr*/
        if (data.component_data.is_submitted != "0") {
          html +=
            '   <button class="insuf-btn ' +
            none +
            '" id="insuf_btn_' +
            i +
            '" ' +
            insuffDisable +
            ' onclick="modalInsuffi(' +
            data.component_data.candidate_id +
            ",'" +
            7 +
            "','Education','" +
            priority +
            "'," +
            i +
            ",'double')\">Raise Insufficiency</button>";
          html +=
            '   <button class="app-btn ' +
            none +
            '" id="app_btn_' +
            i +
            '" ' +
            approvDisable +
            ' onclick="modalapprov(' +
            data.component_data.candidate_id +
            ",'" +
            7 +
            "','Education','" +
            priority +
            "'," +
            i +
            ",'double')\"><i id=\"app_btn_icon_" +
            i +
            '" class="fa fa-check ' +
            rightClass +
            '"></i> Approve</button>';
        }
        html += "   <hr>";

        html += "      </div>";
        html += "   </div>";
      }

      // html += '         <div class="row mt-3">';
      /*  html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">all sem marksheet</div>';
            if(data.component_data.all_sem_marksheet != null || data.component_data.all_sem_marksheet != ''){
                    var allSemMarksheetDoc = data.component_data.all_sem_marksheet;
                    var allSemMarksheetDoc = allSemMarksheetDoc.split(",");
                    for (var i = 0; i < allSemMarksheetDoc.length; i++) {
                        var url = img_base_url+"../uploads/all-marksheet-docs/"+allSemMarksheetDoc[i]
                        if ((/\.(jpg|jpeg|png)$/i).test(allSemMarksheetDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+allSemMarksheetDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+allSemMarksheetDoc[i]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(allSemMarksheetDoc[i])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+allSemMarksheetDoc[i]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
                        
        html += '            </div>';*/

      /* html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">degree convocation/ transcript of records</div>';
         if(data.component_data.convocation != null || data.component_data.convocation != ''){
                    var convocation = [k]data.component_data.convocation;
                    var convocation = [k]convocation.sp[k]lit(",");
                    for (var i = 0; i < convocation.le[k]ngth; i++) {
                        var url = img_base_url+"../uploads/convocation-docs/"+convocation[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(convocation[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocation[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+convocation[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(convocation[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+convocation[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';*/

      /*
        html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">consolidate marksheet/ provisional degree certificate</div>';
         if(data.component_data.marksheet_provisional_certificate != null || data.component_data.marksheet_provisional_certificate != ''){
                    var marksheet_provisional_certificate = [k]data.component_data.marksheet_provisional_certificate;
                    var marksheet_provisional_certificate = [k]marksheet_provisional_certificate.sp[k]lit(",");
                    for (var i = 0; i < marksheet_provisional_certificate.le[k]ngth; i++) {
                        var url = img_base_url+"../uploads/marksheet-certi-docs/"+marksheet_provisional_certificate[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(marksheet_provisional_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+marksheet_provisional_certificate[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+marksheet_provisional_certificate[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(marksheet_provisional_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0  text-wrap">'+marksheet_provisional_certificate[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';*/

      /* html += '            <div class="col-md-3">';
        html += '               <div class="pg-frm-hd">10th / 12th mark card/ course completion certificate <span>(optional)</span></div>';
         if(data.component_data.ten_twelve_mark_card_certificate != null || data.component_data.ten_twelve_mark_card_certificate != ''){
                    var ten_twelve_mark_card_certificate = [k]data.component_data.ten_twelve_mark_card_certificate;
                    var ten_twelve_mark_card_certificate = [k]ten_twelve_mark_card_certificate.sp[k]lit(",");
                    for (var i = 0; i < ten_twelve_mark_card_certificate.le[k]ngth; i++) {
                        var url = img_base_url+"../uploads/ten-twelve-docs/"+ten_twelve_mark_card_certificate[i][k]
                        if ((/\.(jpg|jpeg|png)$/i).test(ten_twelve_mark_card_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificate[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_edu_docs_modal(\''+url+'\')" data-view_docs="'+ten_twelve_mark_card_certificate[i][k]+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-eye text-primary"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }else if((/\.(pdf)$/i).test(ten_twelve_mark_card_certificate[i][k])){
                            html += '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">'
                            html += '                   <div class="image-selected-div">';
                            html += '                       <ul class="p-0 mb-0">';
                            html += '                           <li class="image-selected-name pb-0 text-wrap">'+ten_twelve_mark_card_certificate[i][k]+'</li>'
                            html += '                           <li class="image-name-delete pb-0">';
                            html += '                               <a download id="docs_modal_file'+data.component_data.candidate_id+'" href="'+url+'" class="image-name-delete-a">';
                            html += '                                   <i class="fa fa-arrow-down"></i>';
                            html += '                               </a>'; 
                            html += '                           </li>';
                            html += '                        </ul>';
                            html += '                   </div>';
                            html += '                 </div>';
                        }
                    }
            }else{
                    html += '               <div class="pg-frm-hd">There is no file </div>';
            }
        html += '            </div>';*/
      // html += '         </div>';
    } else {
      html += '         <div class="row">';
      html += '            <div class="col-md-12">';
      html += '               <h6 class="full-nam2">Incorrect Data</h6>';
      html += "            </div>";
      html += "         </div>";
    }
    html += '         <div class="row mt-2">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                 <button id="add_education" onclick="add_education()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }

  $("#component-detail").html(html);
}

function present_address(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  if (data.component_data == "undefined" || data.component_data == null) {
    $("#component-detail").html("<h3>Data not submitted yet.</h3>");
  }

  let html = "";
  if (data.status > 0) {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-danger">Not Initiate<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps d-none">Step 2/6</div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html += '               <h6 class="full-nam2">Present Address</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>House/Flat No.</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.present_address_id +
      '" class="fld form-control" id="present_address_id" type="hidden">';
    html +=
      '                  <input name=""  value="' +
      data.component_data.flat_no +
      '" class="fld form-control" id="present-house-flat" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Street/Road</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.street +
      '" class="fld form-control" id="present-street" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Area</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.area +
      '" class="fld form-control" id="present-area" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += ' <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>State</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.state +
      '" class="fld form-control" id="present-state" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>City/Town</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.city +
      '" class="fld form-control" id="present-city" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Pin Code</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.pin_code +
      '" class="fld form-control" id="present-pincode" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Nearest Landmark</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.nearest_landmark +
      '" class="fld form-control" id="present-land-mark" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="pg-frm-hd">DURATION OF STAY</div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += "                <div><label>Start Date</label></div>";
    html +=
      '                <input name=""  value="' +
      data.component_data.duration_of_stay_start +
      '" class="fld form-control end-date" id="present-start-date" type="text">';
    html += "            </div>";
    html += '            <h6 class="To">TO</h6>';
    html += '           <div class="col-md-3">';
    html += "            <div><label>End Date</label></div>";
    html +=
      '             <input name=""  value="' +
      data.component_data.duration_of_stay_end +
      '" class="fld form-control end-date" id="present-end-date" type="text">';

    html += "         </div>";
    html += '         <div class="col-md-2 tp d-none">';
    html +=
      '            <div class="custom-control custom-checkbox custom-control-inline mrg-btm">';
    html +=
      '               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">';
    html +=
      '               <label class="custom-control-label pt-1" for="customCheck1">Present</label>';
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="col-md-2 tp">';

    html += "         </div>";
    html += "         </div>";
    html += '         <div class="pg-frm-hd">CONTACT PERSON</div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.contact_person_name +
      '" class="fld form-control" id="present-name" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reletionship</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.contact_person_relationship +
      '" class="fld form-control" id="present-relationship" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Mobile Number</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.contact_person_mobile_number +
      '" class="fld form-control" id="present-contact_no" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    // html += '   <button class="insuf-btn '+none+'">Insufficiency</button>';
    // html += '   <button class="app-btn '+none+'"><i class="fa fa-check bac-gr"></i> Approve</button>';
    // html += '   <hr>';

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }

    html += '         <div class="row mt-3">';
    html += '            <div class="col-md-4">';
    html +=
      '               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>';
    // html += '                   rental_agreement'
    if (
      data.component_data.rental_agreement != null ||
      data.component_data.rental_agreement != ""
    ) {
      var rental_agreementDoc = data.component_data.rental_agreement;
      var rental_agreementDoc = rental_agreementDoc.split(",");
      for (var i = 0; i < rental_agreementDoc.length; i++) {
        var url =
          img_base_url + "../uploads/rental-docs/" + rental_agreementDoc[i];
        if (/\.(jpg|jpeg|png)$/i.test(rental_agreementDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            rental_agreementDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            rental_agreementDoc[i] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(rental_agreementDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            rental_agreementDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm-hd">Ration Card</div>';
    // html += '                   ration_card'
    if (
      data.component_data.ration_card != null ||
      data.component_data.ration_card != ""
    ) {
      var ration_cardDoc = data.component_data.ration_card;
      var ration_cardDoc = ration_cardDoc.split(",");
      for (var i = 0; i < ration_cardDoc.length; i++) {
        var url = img_base_url + "../uploads/ration-docs/" + ration_cardDoc[i];
        if (/\.(jpg|jpeg|png)$/i.test(ration_cardDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            ration_cardDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            ration_cardDoc[i] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(ration_cardDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            ration_cardDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <div class="pg-frm-hd">Government Utility Bill</div>';
    // html += '                   gov_utility_bill'
    if (
      data.component_data.gov_utility_bill != null ||
      data.component_data.gov_utility_bill != ""
    ) {
      var gov_utility_billDoc = data.component_data.gov_utility_bill;
      var gov_utility_billDoc = gov_utility_billDoc.split(",");
      for (var i = 0; i < gov_utility_billDoc.length; i++) {
        var url =
          img_base_url + "../uploads/gov-docs/" + gov_utility_billDoc[i];
        if (/\.(jpg|jpeg|png)$/i.test(gov_utility_billDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            gov_utility_billDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            gov_utility_billDoc[i] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(gov_utility_billDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            gov_utility_billDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    html += "            </div>";
    html += '            <div class="col-md-3">';

    html += "            </div>";
    html += "         </div>";
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn ' +
        none +
        '" id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        8 +
        "','Present Address','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn ' +
        none +
        '" id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        8 +
        "','Present Address','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += '               <div id="fls">';
    html += '                  <div class="form-group files d-none">';
    html +=
      '                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>';
    html +=
      '                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
    html += '                     <div class="file-name1"></div>';
    html += "                  </div>";
    html += "               </div>";
    html += '               <div id="file1-error"></div>';
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html += '               <div id="fls">';
    html += '                  <div class="form-group files d-none">';
    html +=
      '                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>';
    html +=
      '                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
    html += '                     <div class="file-name2"></div>';
    html += "                  </div>";
    html += "               </div>";
    html += '               <div id="file2-error"></div>';
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html += '               <div id="fls">';
    html += '                  <div class="form-group files d-none">';
    html +=
      '                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>';
    html +=
      '                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
    html += '                     <div class="file-name3"></div>';
    html += "                  </div>";
    html += "               </div>";
    html += '               <div id="file3-error"></div>';
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row mt-3">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                 <button id="add_present" onclick="add_present()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function permanent_address(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  console.log("permanent_address : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  let html = "";
  if (data.status > 0) {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Permanent address</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html += '               <h6 class="full-nam2">Permanent address</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>House/Flat No.</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.flat_no +
      '" class="fld form-control" id="permanent-house-flat" type="text">';
    html +=
      '                  <input name=""  value="' +
      data.component_data.permanent_address_id +
      '" class="fld form-control" id="permanent_address_id" type="hidden">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Street/Road</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.street +
      '" class="fld form-control" id="permanent-street" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Area</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.area +
      '" class="fld form-control" id="permanent-area" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>State</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.state +
      '" class="fld form-control" id="permanent-state" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>City/Town</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.city +
      '" class="fld form-control" id="permanent-city" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Pin Code</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.pin_code +
      '" class="fld form-control" id="permanent-pincode" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Nearest Landmark</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.nearest_landmark +
      '" class="fld form-control" id="permanent-land-mark" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="pg-frm-hd">DURATION OF STAY</div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += "                <div><label>Start Date</label></div>";
    html +=
      '                <input name=""  value="' +
      data.component_data.duration_of_stay_start +
      '" class="fld form-control end-date" id="permanent-start-date" type="text">';
    html += "            </div>";
    html += '            <h6 class="To">TO</h6>';
    html += '           <div class="col-md-3">';
    html += "            <div><label>End Date</label></div>";
    html +=
      '             <input name=""  value="' +
      data.component_data.duration_of_stay_end +
      '" class="fld form-control end-date" id="permanent-end-date" type="text">';

    html += "         </div>";
    html += '         <div class="col-md-2 tp d-none">';
    html +=
      '            <div class="custom-control custom-checkbox custom-control-inline mrg-btm">';
    html +=
      '               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">';
    html +=
      '               <label class="custom-control-label pt-1" for="customCheck1">Present</label>';
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="col-md-2 tp">';

    html += "         </div>";
    html += "         </div>";
    html += '         <div class="pg-frm-hd">CONTACT PERSON</div>';
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.contact_person_name +
      '" class="fld form-control" id="permanent-name" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reletionship</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.contact_person_relationship +
      '" class="fld form-control" id="permanent-relationship" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Mobile Number</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.contact_person_mobile_number +
      '" class="fld form-control" id="permanent-contact_no" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    // html += '   <button class="insuf-btn '+none+'">Insufficiency</button>';
    // html += '   <button class="app-btn '+none+'"><i class="fa fa-check bac-gr"></i> Approve</button>';
    html += "   <hr>";

    html += '         <div class="row mt-3">';
    html += '            <div class="col-md-4">';
    html +=
      '               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>';
    // for loop will start
    if (
      data.component_data.rental_agreement != null ||
      data.component_data.rental_agreement != ""
    ) {
      var reantAgreementDoc = data.component_data.rental_agreement;
      var reantAgreementDoc = reantAgreementDoc.split(",");
      for (var i = 0; i < reantAgreementDoc.length; i++) {
        var url =
          img_base_url + "../uploads/rental-docs/" + reantAgreementDoc[i];
        if (/\.(jpg|jpeg|png)$/i.test(reantAgreementDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0">' +
            reantAgreementDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            reantAgreementDoc[i] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(reantAgreementDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0">' +
            reantAgreementDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    // for loop will end

    html += "            </div>";

    html += '            <div class="col-md-4">';
    html +=
      '               <div class="pg-frm-hd">Upload Ration Card <span>(optional)</span></div>';

    // for loop will start
    if (
      data.component_data.ration_card != null ||
      data.component_data.ration_card != ""
    ) {
      var rationCardDoc = data.component_data.ration_card;
      var rationCardDoc = rationCardDoc.split(",");
      for (var i = 0; i < rationCardDoc.length; i++) {
        var url = img_base_url + "../uploads/ration-docs/" + rationCardDoc[i];
        if (/\.(jpg|jpeg|png)$/i.test(rationCardDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0">' +
            rationCardDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            rationCardDoc[i] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(rationCardDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0">' +
            rationCardDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '<div class="pg-frm-hd">There is no file </div>';
    }
    // for loop will end    ration_card
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html +=
      '               <div class="pg-frm-hd">Upload Government Utility Bill <span>(optional)</span></div>';

    if (
      data.component_data.gov_utility_bill != null ||
      data.component_data.gov_utility_bill != ""
    ) {
      var govUtilityBillDoc = data.component_data.gov_utility_bill;
      var govUtilityBillDoc = govUtilityBillDoc.split(",");
      for (var i = 0; i < govUtilityBillDoc.length; i++) {
        var url = img_base_url + "../uploads/gov-docs/" + govUtilityBillDoc[i];
        if (/\.(jpg|jpeg|png)$/i.test(govUtilityBillDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0">' +
            govUtilityBillDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            govUtilityBillDoc[i] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(govUtilityBillDoc[i])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0">' +
            govUtilityBillDoc[i] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    // for loop will end  gov_utility_bill
    html += "            </div>";
    html += "         </div>";
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn ' +
        none +
        '" id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        9 +
        "','Permanent Address','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn ' +
        none +
        '" id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        9 +
        "','Permanent Address','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += '               <div id="fls">';
    html += '                  <div class="form-group files d-none">';
    html +=
      '                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>';
    html +=
      '                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
    html += '                     <div class="file-name1"></div>';
    html += "                  </div>";
    html += "               </div>";
    html += '               <div id="file1-error"></div>';
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html += '               <div id="fls">';
    html += '                  <div class="form-group files d-none">';
    html +=
      '                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>';
    html +=
      '                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
    html += '                     <div class="file-name2"></div>';
    html += "                  </div>";
    html += "               </div>";
    html += '               <div id="file2-error"></div>';
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html += '               <div id="fls">';
    html += '                  <div class="form-group files d-none">';
    html +=
      '                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>';
    html +=
      '                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >';
    html += '                     <div class="file-name3"></div>';
    html += "                  </div>";
    html += "               </div>";
    html += '               <div id="file3-error"></div>';
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row mt-2">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                 <button id="add_permanent" onclick="add_permanent()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function previous_employment(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log("current_employment: "+JSON.stringify(data))
  $("#componentModal").modal("show");
  // $('#modal-headding').html('Previous employment')
  if (data.component_data == "undefined" || data.component_data == null) {
    $("#component-detail").html("<h3>Data not submitted yet.</h3>");
  }
  $("#modal-headding").html(component_name);
  var desigination = JSON.parse(data.component_data.desigination);
  var department = JSON.parse(data.component_data.department);
  var employee_id = JSON.parse(data.component_data.employee_id);
  var company_name = JSON.parse(data.component_data.company_name);
  var address = JSON.parse(data.component_data.address);
  var annual_ctc = JSON.parse(data.component_data.annual_ctc);
  var reason_for_leaving = JSON.parse(data.component_data.reason_for_leaving);
  var joining_date = JSON.parse(data.component_data.joining_date);
  var relieving_date = JSON.parse(data.component_data.relieving_date);
  var reporting_manager_name = JSON.parse(
    data.component_data.reporting_manager_name
  );
  var reporting_manager_desigination = JSON.parse(
    data.component_data.reporting_manager_desigination
  );
  var reporting_manager_contact_number = JSON.parse(
    data.component_data.reporting_manager_contact_number
  );
  var hr_name = JSON.parse(data.component_data.hr_name);
  var hr_contact_number = JSON.parse(data.component_data.hr_contact_number);
  var component_status = data.component_data.status.split(",");
  // alert(data.component_data.appointment_letter)
  var appointment_letter = JSON.parse(data.component_data.appointment_letter);
  var experience_relieving_letter = JSON.parse(
    data.component_data.experience_relieving_letter
  );
  var last_month_pay_slip = JSON.parse(data.component_data.last_month_pay_slip);
  var company_url = JSON.parse(data.component_data.company_url);
  var bank_statement_resigngation_acceptance = JSON.parse(
    data.component_data.bank_statement_resigngation_acceptance
  );
  var reporting_manager_email_id = JSON.parse(
    data.component_data.reporting_manager_email_id
  );
  var hr_email_id = JSON.parse(data.component_data.hr_email_id);

  let html = "";
  var j = 1;
  html +=
    '<input name="" ="" value="' +
    data.component_data.previous_emp_id +
    '" class="fld form-control" id="previous_employment_id" type="hidden">';
    var v = 1;
  for (var i = 0; i < desigination.length; i++) {
    // alert(i)
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (component_status[i] == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (component_status[i] == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (component_status[i] == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (component_status[i] == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      var insuff_remarks = JSON.parse(data.component_data.Insuff_remarks);
    } else if (component_status[i] == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html += '<div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    // html += '         <h4 class="full-nam2">Previous Employment '+(j++)+'</h4>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html +=
      '               <h6 class="full-nam2">Previous Employment ' +
      j++ +
      "</h6> ";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_' +
      i +
      '">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Desigination</label>";
    html +=
      '                  <input name="" ="" value="' +
      desigination[i].desigination +
      '" class="fld form-control previous-designation" id="previous-designation" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Department</label>";
    html +=
      '                  <input name="" ="" value="' +
      department[i].department +
      '"  class="fld form-control previous-department" id="previous-department" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Employee ID</label>";
    html +=
      '                  <input name="" ="" value="' +
      employee_id[i].employee_id +
      '"  class="fld form-control previous-employee_id" id="previous-employee_id" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Company Name</label>";
    var names = '';
     if (
      company_name != "" &&
      company_name != null &&
      company_name != "undefined" &&
      company_name != "[]"
    ) {
    if (v <= company_url.length) { 
      names = company_name[i].company_name;
       }
    }
    html +=
      '                  <input name="" ="" value="' +
      names +
      '" class="fld form-control previous-company-name" id="previous-company-name" type="text">';
    html += "               </div>";
    html += "            </div>";
    var urls = "";
    if (
      company_url != "" &&
      company_url != null &&
      company_url != "undefined" &&
      company_url != "[]"
    ) {
     
      urls = company_url[i].company_url;
    }
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Company Website</label>";
    html +=
      '                  <input name="" ="" value="' +
      urls +
      '" class="fld form-control previous-company-url" id="previous-company-url" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-8">';
    html += '                <div class="pg-frm">';
    html += "                   <label>Address</label>";
    html +=
      '                   <textarea ="" class="fla form-control previous-address" id="previous-address" type="text">' +
      address[i].address +
      "</textarea>";
    html += "                </div>";
    html += "             </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Annual CTC</label>";
    html +=
      '                  <input name="" ="" value="' +
      annual_ctc[i].annual_ctc +
      '" class="fld previous-annual-ctc" id="previous-annual-ctc" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-8">';
    html += '                <div class="pg-frm">';
    html += "                   <label>Reason For Leaving</label>";
    html +=
      '                   <input name="" ="" value="' +
      reason_for_leaving[i].reason_for_leaving +
      '" class="fld previous-reasion" id="previous-reasion"  type="text">';
    html += "                </div>";
    html += "             </div>";
    html += "         </div>";
    /*   html += '         <div class="row">';
        html += '             <div class="col-md-5">';
        html += '                <div class="pg-frm-hd">Joining Date</div>';
        html += '             </div>';
        html += '             <div class="col-md-4">';
        html += '                <div class="pg-frm-hd">relieving date</div>';
        html += '             </div>';
        html += '         </div>';*/
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "               <label>Joining Date</label>";
    html +=
      '                <input name="" ="" value="' +
      joining_date[i].joining_date +
      '"  class="fld form-control mdate previous-joining-date" id="previous-joining-date" type="text">';

    html += "            </div>";
    html += "            </div>";
    html += '            <div class="col-md-1">';
    html += "           </div>";
    html += '           <div class="col-md-3 ml-2">';
    html += '               <div class="pg-frm">';
    html += "            <label>Relieving Date</label>";
    html +=
      '                <input name="" ="" value="' +
      relieving_date[i].relieving_date +
      '"  class="fld form-control mdate previous-relieving-date" id="previous-relieving-date" type="text">';

    html += "         </div>";
    html += "         </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reporting Manager Name</label>";

    var manager_name = '';
     if (
      reporting_manager_name != "" &&
      reporting_manager_name != null &&
      reporting_manager_name != "undefined" &&
      reporting_manager_name != "[]"
    ) {
    if (v <= reporting_manager_name.length) { 
      manager_name = reporting_manager_name[i].reporting_manager_name;
       }
    }
    html +=
      '                  <input name="" ="" value="' +
      manager_name +
      '"  class="fld form-control previous-reporting-manager-name" id="previous-reporting-manager-name" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reporting Manager Designation</label>";
    html +=
      '                  <input name="" ="" value="' +
      reporting_manager_desigination[i].reporting_manager_desigination +
      '"  class="fld form-control previous-reporting-manager-designation" id="previous-reporting-manager-designation" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reporting Manager Contact Number</label>";
    html +=
      '                  <input name="" ="" value="' +
      reporting_manager_contact_number[i].reporting_manager_contact_number +
      '"  class="fld form-control previous-reporting-manager-contact" id="previous-reporting-manager-contact" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Reporting Manager Email Id</label>";
      var manager_email_id = '';
    if (reporting_manager_email_id.length > 0) {
      manager_email_id = reporting_manager_email_id[i].reporting_manager_email_id;
    }
    html +=
      '                  <input name="" ="" value="' +
       manager_email_id+
      '"  class="fld form-control previous-reporting-manager-contact" id="previous-reporting-manager-contact" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>HR Contact Name</label>";
    html +=
      '                  <input name="" ="" value="' +
      hr_name[i].hr_name +
      '"  class="fld form-control previous-hr-name" id="previous-hr-name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>HR Contact Number</label>";
    html +=
      '                  <input name="" ="" value="' +
      hr_contact_number[i].hr_contact_number +
      '"  class="fld form-control previous-hr-contact" id="previous-hr-contact" type="text">';
    html += "               </div>";
    html += "            </div>";
    var hr_email_ids = '';
    if (hr_email_id.length > 0) {
      hr_email_ids = hr_email_id[i].hr_email_id;
    }

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>HR Email Id</label>";
    html +=
      '                  <input name="" ="" value="' +hr_email_ids
       +
      '"  class="fld form-control previous-hr-contact" id="previous-hr-contact" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += "         </div>";

    html += "      </div>";
    html += "   </div>";

    v++;

    if (component_status[i] == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        insuff_remarks[i].insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }

    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn ' +
        none +
        '" id="insuf_btn_' +
        i +
        '" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        10 +
        "','previous employment','" +
        priority +
        "'," +
        i +
        ",'double')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn ' +
        none +
        '" id="app_btn_' +
        i +
        '" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        10 +
        "','previous employment','" +
        priority +
        "'," +
        i +
        ",'double')\"><i id=\"app_btn_icon_" +
        i +
        '" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }

    html += '         <div class="row mt-3">';
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm-hd">Appointment Letter</div>';
    if (appointment_letter[i] != null || appointment_letter[i] != "") {
      // var appointment_letter = data[k].component_data.appointment_letter;
      // var appointment_letter = appointment_letter[k].split("[k],");
      for (var k = 0; k < appointment_letter[i].length; k++) {
        var url =
          img_base_url +
          "../uploads/appointment_letter/" +
          appointment_letter[i][k];
        if (/\.(jpg|jpeg|png)$/i.test(appointment_letter[i][k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            appointment_letter[i][k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            appointment_letter[i][k] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(appointment_letter[i][k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            appointment_letter[i][k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }

    html += "            </div>";
    html += '            <div class="col-md-3">';
    html +=
      '               <div class="pg-frm-hd">Experience/Relieving Letter</div>';
    if (
      experience_relieving_letter[i] != null ||
      experience_relieving_letter[i] != ""
    ) {
      // var experience_relieving_letter = data[k].component_data.experience_relieving_letter;
      // var experience_relieving_letter = experience_relieving_letter[k].split(",");
      for (var k = 0; k < experience_relieving_letter[i].length; k++) {
        var url =
          img_base_url +
          "../uploads/experience_relieving_letter/" +
          experience_relieving_letter[i][k];
        if (/\.(jpg|jpeg|png)$/i.test(experience_relieving_letter[i][k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            experience_relieving_letter[i][k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            experience_relieving_letter[i][k] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(experience_relieving_letter[i][k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            experience_relieving_letter[i][k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html += '               <div class="pg-frm-hd">Pay Slip</div>';
    if (last_month_pay_slip[i] != null || last_month_pay_slip[i] != "") {
      // var last_month_pay_slip = data[k].component_data.last_month_pay_slip;
      // var last_month_pay_slip = last_month_pay_slip[k].split("[k],");
      for (var k = 0; k < last_month_pay_slip[i].length; k++) {
        var url =
          img_base_url +
          "../uploads/last_month_pay_slip/" +
          last_month_pay_slip[i][k];
        if (/\.(jpg|jpeg|png)$/i.test(last_month_pay_slip[i][k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0 text-wrap">' +
            last_month_pay_slip[i][k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a id="docs_modal_file' +
            data.component_data.candidate_id +
            '" onclick="view_edu_docs_modal(\'' +
            url +
            '\')" data-view_docs="' +
            last_month_pay_slip[i][k] +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-eye text-primary"></i>';
          html += "                               </a>";
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        } else if (/\.(pdf)$/i.test(last_month_pay_slip[i][k])) {
          html +=
            '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
          html += '                   <div class="image-selected-div">';
          html += '                       <ul class="p-0 mb-0">';
          html +=
            '                           <li class="image-selected-name pb-0  text-wrap">' +
            last_month_pay_slip[i][k] +
            "</li>";
          html +=
            '                           <li class="image-name-delete pb-0">';
          html +=
            '                               <a download id="docs_modal_file' +
            data.component_data.candidate_id +
            '" href="' +
            url +
            '" class="image-name-delete-a">';
          html +=
            '                                   <i class="fa fa-arrow-down"></i>';
          html += "                               </a>";
          html += "                           </li>";
          html += "                        </ul>";
          html += "                   </div>";
          html += "                 </div>";
        }
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    html += "            </div>";
    html += '            <div class="col-md-3">';
    html +=
      '               <div class="pg-frm-hd">Resignation Acceptance Letter/ Mail</div>';

    if (bank_statement_resigngation_acceptance != "") {
      if (
        bank_statement_resigngation_acceptance[i] != "null" &&
        bank_statement_resigngation_acceptance[i] != null &&
        data.component_data.bank_statement_resigngation_acceptance != ""
      ) {
        // var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = data[k].component_data.bank_statement_resigngation_acceptance;
        // var ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance = ten_twelve_mark_card_certificatebank_statement_resigngation_acceptance[k].split("[k],");
        // alert(bank_statement_resigngation_acceptance[i])
        for (
          var k = 0;
          k < bank_statement_resigngation_acceptance[i].length;
          k++
        ) {
          var url =
            img_base_url +
            "../uploads/bank_statement_resigngation_acceptance/" +
            bank_statement_resigngation_acceptance[i][k];
          if (
            /\.(jpg|jpeg|png)$/i.test(
              bank_statement_resigngation_acceptance[i][k]
            )
          ) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0 text-wrap">' +
              bank_statement_resigngation_acceptance[i][k] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" data-view_docs="' +
              bank_statement_resigngation_acceptance[i][k] +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (
            /\.(pdf)$/i.test(bank_statement_resigngation_acceptance[i][k])
          ) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0 text-wrap">' +
              bank_statement_resigngation_acceptance[i][k] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
        }
      } else {
        html += '               <div class="pg-frm-hd">There is no file </div>';
      }
    } else {
      html += '               <div class="pg-frm-hd">There is no file </div>';
    }
    html += "            </div>";
    html += "         </div>";

    html += "   <hr>";
  }

  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_previous_employments" onclick="add_previous_employments()" class="btn bg-blu text-white">Update</button>';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";
  $("#component-detail").html(html);
}

function reference(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  console.log("reference : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  var company_name = data.component_data.company_name;
  if (company_name != null || company_name != "") {
    company_name = company_name.split(",");
    company_name_lenght = company_name.length;
  } else {
    company_name_lenght = 0;
  }

  var name = data.component_data.name;
  if (name != null || company_name != "") {
    name = name.split(",");
    name_lenght = name.length;
  } else {
    name_lenght = 0;
  }

  var designation = data.component_data.designation;
  if (designation != null || designation != "") {
    designation = designation.split(",");
    designation_lenght = designation.length;
  } else {
    designation_lenght = 0;
  }

  var contact_number = data.component_data.contact_number;
  if (contact_number != null || contact_number != "") {
    contact_number = contact_number.split(",");
    contact_number_lenght = contact_number.length;
  } else {
    contact_number_lenght = 0;
  }

  var email_id = data.component_data.email_id;
  if (email_id != null || email_id != "") {
    email_id = email_id.split(",");
    email_id_lenght = email_id.length;
  } else {
    email_id_lenght = 0;
  }

  var years_of_association = data.component_data.years_of_association;
  if (years_of_association != null || years_of_association != "") {
    years_of_association = years_of_association.split(",");
    years_of_association_lenght = years_of_association.length;
  } else {
    years_of_association_lenght = 0;
  }

  var contact_start_time = data.component_data.contact_start_time;
  if (contact_start_time != null || contact_start_time != "") {
    contact_start_time = contact_start_time.split(",");
    contact_start_time_lenght = contact_start_time.length;
  } else {
    contact_start_time_lenght = 0;
  }

  var contact_end_time = data.component_data.contact_end_time;
  if (contact_end_time != null || contact_end_time != "") {
    contact_end_time = contact_end_time.split(",");
    contact_end_time_lenght = contact_end_time.length;
  } else {
    contact_end_time_lenght = 0;
  }

  var component_status = data.component_data.status.split(",");

  let html = "";
  if (company_name_lenght > 0) {
    var j = 1;
    html +=
      '<input name=""  value="' +
      data.component_data.reference_id +
      '" class="fld form-control" id="reference_id" type="hidden">';
    for (var i = 0; i < company_name_lenght; i++) {
      var form_status = "";
      var insuffDisable = "";
      var approvDisable = "";
      var rightClass = "";
      var none = "";
      if (component_status[i] == "0") {
        none = "d-none";
        form_status = '<span class="text-warning">Pending<span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "1") {
        none = "d-none";
        form_status = '<span class="text-info">Form Filled<span>';
        fontAwsom = '<i class="fa fa-check">';
        rightClass = "bac-gr";
      } else if (component_status[i] == "2") {
        form_status = '<span class="text-success">Completed<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else if (component_status[i] == "3") {
        form_status = '<span class="text-danger">Insufficiency<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        form_status = '<span class="text-success">Verified Clear<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      $name = name[i];
      if (!isNaN(name[i])) {
        $name = name[i + 1];
      }
      // html += '<h6 class="full-nam2">Reference '+(j++)+'</h6>';
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html +=
        '               <h6 class="full-nam2">Reference ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html +=
        '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_' +
        i +
        '">' +
        form_status +
        "</span>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Name</label>";
      html +=
        '                  <input name=""  value="' +
        $name +
        '" class="fld form-control name" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Company Name</label>";
      html +=
        '                  <input name=""  value="' +
        company_name[i] +
        '" class="fld form-control company-name" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Designation</label>";
      html +=
        '                  <input name=""  value="' +
        designation[i] +
        '" class="fld form-control designation" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Contact Number</label>";
      html +=
        '                  <input name=""  value="' +
        contact_number[i] +
        '" class="fld form-control contact" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Email ID</label>";
      html +=
        '                  <input name=""  value="' +
        email_id[i] +
        '" class="fld form-control email" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-3">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Years of Association</label>";
      html +=
        '                  <input name=""  value="' +
        years_of_association[i] +
        '" class="fld form-control association" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += "         </div>";
      html += '          <div class="row">';
      html += '            <div class="col-md-6">';
      html +=
        '               <div class="pg-frm-hd">Preferred contact time</div>';
      html += '               <div class="row">';
      html += '                  <div class="col-md-5">';
      html += '                     <div class="pg-frm">';
      html +=
        '                        <input type="text"  value="' +
        contact_start_time[i] +
        '" class="form-control fld start-time" id="timepicker" placeholder="Start time" name="pwd" >';
      html += "                     </div>";
      html += "                  </div>";
      html += '                  <div class="col-md-5">';
      html += '                     <div class="pg-frm">';
      html +=
        '                        <input type="text"  value="' +
        contact_end_time[i] +
        '" class="form-control fld end-time" id="timepicker2" placeholder="End time" name="pwd" >';
      html += "                     </div>";
      html += "                  </div>";
      html += "               </div>";
      html += "            </div>";
      html += "          </div>";
      html += "         </div>";

      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }

      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn ' +
          none +
          '" id="insuf_btn_' +
          i +
          '" ' +
          insuffDisable +
          ' onclick="modalInsuffi(' +
          data.component_data.candidate_id +
          ",'" +
          11 +
          "','Reference','" +
          priority +
          "'," +
          i +
          ",'double')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn ' +
          none +
          '" id="app_btn_' +
          i +
          '" ' +
          approvDisable +
          ' onclick="modalapprov(' +
          data.component_data.candidate_id +
          ",'" +
          11 +
          "','Reference','" +
          priority +
          "'," +
          i +
          ",'double')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
    }
  }
  html += '         <div class="row">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_reference" onclick="add_reference()" class="btn bg-blu text-white">Update</button>';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";

  $("#component-detail").html(html);
}

function previous_address(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log("previous_address : "+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  var flat_no = JSON.parse(data.component_data.flat_no);
  var street = JSON.parse(data.component_data.street);
  var area = JSON.parse(data.component_data.area);
  var city = JSON.parse(data.component_data.city);
  var pin_code = JSON.parse(data.component_data.pin_code);
  var state = JSON.parse(data.component_data.state);
  var nearest_landmark = JSON.parse(data.component_data.nearest_landmark);
  var duration_of_stay_start = JSON.parse(
    data.component_data.duration_of_stay_start
  );
  var duration_of_stay_end = JSON.parse(
    data.component_data.duration_of_stay_end
  );
  var contact_person_name = JSON.parse(data.component_data.contact_person_name);
  var contact_person_relationship = JSON.parse(
    data.component_data.contact_person_relationship
  );
  var contact_person_mobile_number = JSON.parse(
    data.component_data.contact_person_mobile_number
  );
  var component_status = data.component_data.status.split(",");
  // var state = JSON.parse(data.component_data.state)
  // var state = JSON.parse(data.component_data.state)
  // var state = JSON.parse(data.component_data.state)
  // var state = JSON.parse(data.component_data.state)

  var rental_agreement = JSON.parse(data.component_data.rental_agreement);
  var ration_card = JSON.parse(data.component_data.ration_card);
  var gov_utility_bill = JSON.parse(data.component_data.gov_utility_bill);
  let html = "";
  var j = 1;
  html +=
    '<input name=""  value="' +
    data.component_data.previos_address_id +
    '" class="fld form-control" id="previos_address_id" type="hidden">';
  if (data.status > 0) {
    for (var i = 0; i < state.length; i++) {
      var form_status = "";
      var insuffDisable = "";
      var approvDisable = "";
      var rightClass = "";
      var none = "";
      if (component_status[i] == "0") {
        none = "d-none";
        form_status = '<span class="text-warning">Pending<span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "1") {
        none = "d-none";
        form_status = '<span class="text-info">Form Filled<span>';
        fontAwsom = '<i class="fa fa-check">';
        rightClass = "bac-gr";
      } else if (component_status[i] == "2") {
        form_status = '<span class="text-success">Completed<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else if (component_status[i] == "3") {
        form_status = '<span class="text-danger">Insufficiency<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        form_status = '<span class="text-success">Verified Clear<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += ' <div class="pg-cnt pl-0 pt-0">';
      html += '      <div class="pg-txt-cntr">';
      html += '         <div class="pg-steps d-none">Step 2/6</div>';
      html += '         <h6 class="full-nam2">Details</h6>';
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html +=
        '               <h6 class="full-nam2">Previous Addresses ' +
        j++ +
        "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4 d-none">';
      html +=
        '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_' +
        i +
        '">' +
        form_status +
        "</span>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>House/Flat No.</label>";
      html +=
        '                  <input name=""  value="' +
        flat_no[i].flat_no +
        '" class="fld form-control house-flat" id="house-flat" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Street/Road</label>";
      html +=
        '                  <input name=""  value="' +
        street[i].street +
        '" class="fld form-control street" id="street" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Area</label>";
      html +=
        '                  <input name=""  value="' +
        area[i].area +
        '" class="fld form-control area" id="area" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>City/Town</label>";
      html +=
        '                  <input name=""  value="' +
        city[i].city +
        '" class="fld form-control city" id="city" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Pin Code</label>";
      html +=
        '                  <input name=""  value="' +
        pin_code[i].pin_code +
        '" class="fld form-control pincode" id="pincode" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Nearest Landmark</label>";
      html +=
        '                  <input name=""  value="' +
        state[i].state +
        '" class="fld form-control land-mark" id="land-mark" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="pg-frm-hd">DURATION OF STAY</div>';
      html += '         <div class="row">';
      html += '            <div class="col-md-3">';
      html += "                <div><label>Start Date</label></div>";
      html +=
        '                <input name=""  value="' +
        duration_of_stay_start[i].duration_of_stay_start +
        '" class="fld form-control start-date" id="start-date" type="text">';
      html += "            </div>";
      html += '            <h6 class="To">TO</h6>';
      html += '           <div class="col-md-3">';
      html += "            <div><label>End Date</label></div>";
      html +=
        '             <input name=""  value="' +
        duration_of_stay_end[i].duration_of_stay_end +
        '" class="fld form-control end-date" id="end-date" type="text">';

      html += "         </div>";
      html += '         <div class="col-md-2 tp d-none">';
      html +=
        '            <div class="custom-control custom-checkbox custom-control-inline mrg-btm">';
      html +=
        '               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">';
      html +=
        '               <label class="custom-control-label pt-1" for="customCheck1">Present</label>';
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="col-md-2 tp">';

      html += "         </div>";
      html += "         </div>";
      html += '         <div class="pg-frm-hd">CONTACT PERSON</div>';
      html += '         <div class="row">';
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Name</label>";
      html +=
        '                  <input name=""  value="' +
        contact_person_name[i].contact_person_name +
        '" class="fld form-control name" id="name" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Reletionship</label>";
      html +=
        '                  <input name=""  value="' +
        contact_person_relationship[i].contact_person_relationship +
        '" class="fld form-control relationship" id="relationship" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Mobile Number</label>";
      html +=
        '                  <input name=""  value="' +
        contact_person_mobile_number[i].contact_person_mobile_number +
        '" class="fld form-control contact_no" id="contact_no" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += "         </div>";
      html += "        <hr>";

      html += "      </div>";
      html += "   </div>";
      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }
      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn ' +
          none +
          '" id="insuf_btn_' +
          i +
          '" ' +
          insuffDisable +
          ' onclick="modalInsuffi(' +
          data.component_data.candidate_id +
          ",'" +
          12 +
          "','Previous employment','" +
          priority +
          "'," +
          i +
          ",'double')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn ' +
          none +
          '" id="app_btn_' +
          i +
          '" ' +
          approvDisable +
          ' onclick="modalapprov(' +
          data.component_data.candidate_id +
          ",'" +
          12 +
          "','Previous employment','" +
          priority +
          "'," +
          i +
          ",'double')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }

      html += '         <div class="row mt-3">';
      html += '            <div class="col-md-4">';
      html +=
        '               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>';
      // alert(data.component_data.rental_agreement)
      if (rental_agreement[i] != null && rental_agreement[i] != "no-file") {
        // var reantAgreementDoc = data.component_data.rental_agreement;
        // var reantAgreementDoc = reantAgreementDoc.split(",");
        for (var k = 0; k < rental_agreement[i].length; k++) {
          var url =
            img_base_url + "../uploads/rental-docs/" + rental_agreement[i][k];
          if (/\.(jpg|jpeg|png)$/i.test(rental_agreement[i][k])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              rental_agreement[i][k] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" data-view_docs="' +
              rental_agreement[i][k] +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(rental_agreement[i][k])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              rental_agreement[i][k] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
        }
      } else {
        html += '               <div class="pg-frm-hd">There is no file </div>';
      }
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm-hd">Ration Card</div>';
      if (ration_card[i] != null && ration_card[i] != "no-file") {
        // var rationCardDoc = data.component_data.ration_card;
        // var rationCardDoc = rationCardDoc.split(",");
        for (var k = 0; k < ration_card[i].length; k++) {
          var url =
            img_base_url + "../uploads/ration-docs/" + ration_card[i][k];
          if (/\.(jpg|jpeg|png)$/i.test(ration_card[i][k])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              ration_card[i][k] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" data-view_docs="' +
              ration_card[i][k] +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(ration_card[i][k])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              ration_card[i][k] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
        }
      } else {
        html += '               <div class="pg-frm-hd">There is no file </div>';
      }
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html +=
        '               <div class="pg-frm-hd">Government Utility Bill</div>';
      if (gov_utility_bill[i] != null && gov_utility_bill[i] != "no-file") {
        // var govUtilityBillDoc = data.component_data.gov_utility_bill;
        // var govUtilityBillDoc = govUtilityBillDoc.split(",");
        for (var k = 0; k < gov_utility_bill[i].length; k++) {
          var url =
            img_base_url + "../uploads/gov-docs/" + gov_utility_bill[i][k];
          if (/\.(jpg|jpeg|png)$/i.test(gov_utility_bill[i][k])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              gov_utility_bill[i][k] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" data-view_docs="' +
              gov_utility_bill[i][k] +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(gov_utility_bill[i][k])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0">' +
              gov_utility_bill[i][k] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
        }
      } else {
        html += '               <div class="pg-frm-hd">There is no file </div>';
      }
      html += "            </div>";

      html += "         </div>";

      html += "   <hr>";
    }

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                 <button id="add_address" onclick="add_address()" class="btn bg-blu text-white">Update</button>';
    html +=
      '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function directorship_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < form_values["directorship_check"]; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      // alert('insuffDisable:'+insuffDisable)
      // alert('approvDisable:'+approvDisable)
      html += "            </div>";
      html += "         </div>";
      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }
      // if (data.component_data.is_submitted !='0') {
      // html += '   <button class="insuf-btn '+none+'" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
      html +=
        '   <button class="app-btn ' +
        none +
        '" ' +
        approvDisable +
        ' id="app_btn_' +
        i +
        '" onclick="modalapprov(' +
        candidate_id +
        "," +
        component_id +
        ",'Directorship check','" +
        priority +
        "'," +
        i +
        ",'double')\"><i id=\"app_btn_icon_" +
        i +
        '" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
      // }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

function global_aml_sanctions(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // console.log(data.status)
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < 1; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      // alert('insuffDisable:'+insuffDisable)
      // alert('approvDisable:'+approvDisable)
      html += "            </div>";
      html += "         </div>";
      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }
      // if (data.component_data.is_submitted !='0') {
      // html += '   <button class="insuf-btn '+none+'" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
      html +=
        '   <button class="app-btn ' +
        none +
        '" ' +
        approvDisable +
        ' id="app_btn_' +
        i +
        '" onclick="modalapprov(' +
        candidate_id +
        "," +
        component_id +
        ",'Directorship check','" +
        priority +
        "'," +
        i +
        ",'double')\"><i id=\"app_btn_icon_" +
        i +
        '" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
      // }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

function driving_License(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // console.log(JSON.stringify(data))
  // console.log(data)
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < 1; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
        var licence = data.component_data.licence_number
          ? data.component_data.licence_number
          : "-";
        var licence_d = data.component_data.licence_doc
          ? data.component_data.licence_doc
          : "";
      }
      var licence = data.component_data.licence_number
        ? data.component_data.licence_number
        : "-";
      var licence_d = data.component_data.licence_doc
        ? data.component_data.licence_doc
        : "";

      html += "            </div>";
      html += "         </div>";

      html += '         <div class="row mt-3">';
      html += '            <div class="col-md-3">';
      html += '               <div class="pg-frm-hd"> </div>';
      html +=
        '                   <label class="font-weight-bold">Driving License Number: </label>';
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        licence +
        '" >';
      if (licence_d != null && licence_d != "") {
        var licence_doc = data.component_data.licence_doc;
        var licence_doc = licence_doc.split(",");
        for (var i = 0; i < licence_doc.length; i++) {
          var url = img_base_url + "../uploads/licence-docs/" + licence_doc[i];
          if (/\.(jpg|jpeg|png)$/i.test(licence_doc[i])) {
            html +=
              '                   <label class="font-weight-bold  mt-3">Driving License: </label>';
            html +=
              '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0 text-wrap">' +
              licence_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" data-view_docs="' +
              licence_doc[i] +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(licence_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0 text-wrap">' +
              licence_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
          if (component_status[i] == "3") {
            html += '<div class="row">';
            html +=
              '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="col-md-12">';
            html += "<label>Insuff Remark Comment</label>";
            html +=
              '<textarea readonly  class="input-field form-control">' +
              insuff_remarks[i].insuff_remarks +
              "</textarea>";
            html += "</div>";
            html += "</div>";
          }
        }
      } else {
        html += '               <div class="pg-frm-hd">There is no file </div>';
      }

      html += "            </div>";
      html += "        </div>";

      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn ' +
          none +
          '" ' +
          insuffDisable +
          ' id="insuf_btn_' +
          i +
          '" onclick="modalInsuffi(' +
          candidate_id +
          "," +
          component_id +
          ",'Driving License','" +
          priority +
          "'," +
          0 +
          ",'single')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn ' +
          none +
          '" ' +
          approvDisable +
          ' id="app_btn_' +
          i +
          '" onclick="modalapprov(' +
          candidate_id +
          "," +
          component_id +
          ",'Driving License','" +
          priority +
          "'," +
          0 +
          ",'single')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

function credit_cibil_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  if (data.component_data == "undefined" || data.component_data == null) {
    $("#component-detail").html("<h3>Data not submitted yet.</h3>");
  }
  // console.log(data.status)
  // console.log(JSON.stringify(data))
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    // var formValues = JSON.parse(data.component_data.form_values)
    // var formValues = JSON.parse(formValues)
    // var craditFormValeuslength = formValues['credit_/ cibil check'].length

    var credit_number = JSON.parse(data.component_data.credit_number);
    var document_type = JSON.parse(data.component_data.document_type);

    for (var i = 0; i < credit_number.length; i++) {
      // alert(JSON.stringify(document_type[i]))
      // alert()
      var none = "";
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row mt-3">';
      html += '            <div class="col-md-3">';
      html += '               <div class="pg-frm-hd"> </div>';
      if (
        document_type[i].document_type != "" &&
        document_type[i] != "undefined"
      ) {
        html +=
          '                   <label class="font-weight-bold">Document type: ' +
          document_type[i].document_type +
          "</label>";
      } else {
        html +=
          '                   <label class="font-weight-bold">Document type: -</label>';
      }
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        credit_number[i].credit_cibil_number +
        '" >';
      html += "            </div>";
      html += "        </div>";
      html += '         <div class="row mt-3">';
      html += '            <div class="col-md-3">';
      html += "            <label>Country<label>";
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        data.component_data.credit_country +
        '" >';
      html += "            </div>";
      html += '            <div class="col-md-3">';
      html += "            <label>State<label>";
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        data.component_data.credit_state +
        '" >';
      html += "            </div>";

      html += '            <div class="col-md-3">';
      html += "            <label>City<label>";
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        data.component_data.credit_city +
        '" >';
      html += "            </div>";

      html += '            <div class="col-md-3">';
      html += "            <label>Pincode<label>";
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        data.component_data.credit_pincode +
        '" >';
      html += "            </div>";

      html += '            <div class="col-md-3 mt-2">';
      html += "            <label>Address<label>";
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        data.component_data.credit_address +
        '" >';
      html += "            </div>";
      html += "        </div>";
      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }
      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn ' +
          none +
          '" ' +
          insuffDisable +
          ' id="insuf_btn_' +
          i +
          '" onclick="modalInsuffi(' +
          candidate_id +
          "," +
          component_id +
          ",'Driving License','" +
          priority +
          "'," +
          i +
          ",'double')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn ' +
          none +
          '" ' +
          approvDisable +
          ' id="app_btn_' +
          i +
          '" onclick="modalapprov(' +
          candidate_id +
          "," +
          component_id +
          ",'Driving License','" +
          priority +
          "'," +
          i +
          ",'double')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}
function bankruptcy_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // console.log(data.status)
  // console.log(JSON.stringify(data))
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }

  if (candidate_id != "" || candidate_id != null) {
    var formValues = JSON.parse(data.component_data.form_values);
    var formValues = JSON.parse(formValues);
    // var craditFormValeuslength = formValues['credit_/ cibil check'].length

    var document_type = JSON.parse(data.component_data.document_type);
    var bankruptcy_number = JSON.parse(data.component_data.bankruptcy_number);
    // alert(JSON.stringify(bankruptcy_number))
    for (var i = 0; i < form_values["bankruptcy_check"]; i++) {
      insuffDisable = "";
      approvDisable = "";
      rightClass = "bac-gr";
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        // alert(0)
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        // alert(1)
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        // alert(2)
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        // alert(3)
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "4") {
        // alert(4)
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row mt-3">';
      html += '            <div class="col-md-3">';
      html += '               <div class="pg-frm-hd"> </div>';
      html +=
        '                   <label class="font-weight-bold">Document type: ' +
        document_type[i].document_type +
        "</label>";
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        bankruptcy_number[i].bankruptcy_number +
        '" >';
      html += "            </div>";
      html += "        </div>";
      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }
      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn ' +
          none +
          '" ' +
          insuffDisable +
          ' id="insuf_btn_' +
          i +
          '" onclick="modalInsuffi(' +
          candidate_id +
          "," +
          component_id +
          ",'Bankruptcy','" +
          priority +
          "'," +
          i +
          ",'double')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn ' +
          none +
          '" ' +
          approvDisable +
          ' id="app_btn_' +
          i +
          '" onclick="modalapprov(' +
          candidate_id +
          "," +
          component_id +
          ",'Bankruptcy','" +
          priority +
          "'," +
          i +
          ",'double')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}
function adverse_database_media_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  // alert(JSON.stringify(form_values))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // console.log(data.status)
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  $adverse_database_media_check = form_values[
    "adverse_media/media_database check"
  ]
    ? form_values["adverse_media/media_database check"]
    : 1;
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < 1; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      // alert('insuffDisable:'+insuffDisable)
      // alert('approvDisable:'+approvDisable)
      html += "            </div>";
      html += "         </div>";
      // if (data.component_data.is_submitted !='0') {
      // html += '   <button class="insuf-btn '+none+'" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Raise Insufficiency</button>';
      html +=
        '   <button class="app-btn ' +
        none +
        '" ' +
        approvDisable +
        ' id="app_btn_' +
        i +
        '" onclick="modalapprov(' +
        candidate_id +
        "," +
        component_id +
        ",'Directorship check','" +
        priority +
        "'," +
        i +
        ",'double')\"><i id=\"app_btn_icon_" +
        i +
        '" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
      // }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

function cv_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // console.log(data.status)
  console.log(JSON.stringify(data));
  // alert(JSON.stringify(bankruptcy_number))
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < 1; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += "            </div>";
      html += "         </div>";

      html += '         <div class="row">';
      html += '            <div class="col-md-3">';
      html += '               <div class="pg-frm-hd"> </div>';
      html +=
        '                   <label class="font-weight-bold d-none">Driving License Number: </label>';
      html +=
        '                   <input type="text" class="d-none fld form-control"  value="' +
        data.component_data.licence_number +
        '" >';
      if (
        data.component_data.cv_doc != null &&
        data.component_data.cv_doc != ""
      ) {
        var cv_doc = data.component_data.cv_doc;
        var cv_doc = cv_doc.split(",");
        for (var i = 0; i < cv_doc.length; i++) {
          var url = img_base_url + "../uploads/cv-docs/" + cv_doc[i];
          if (/\.(jpg|jpeg|png)$/i.test(cv_doc[i])) {
            html +=
              '                   <label class="font-weight-bold">CV Document: </label>';
            html +=
              '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0 text-wrap">' +
              cv_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" data-view_docs="' +
              cv_doc[i] +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(cv_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0 text-wrap">' +
              cv_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
        }
      } else {
        html += '               <div class="pg-frm-hd">There is no file </div>';
      }

      html += "            </div>";
      html += "        </div>";
      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }
      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn ' +
          none +
          '" ' +
          insuffDisable +
          ' id="insuf_btn_" onclick="modalInsuffi(' +
          candidate_id +
          "," +
          component_id +
          ",'Driving License','" +
          priority +
          "'," +
          0 +
          ",'single')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn ' +
          none +
          '" ' +
          approvDisable +
          ' id="app_btn_" onclick="modalapprov(' +
          candidate_id +
          "," +
          component_id +
          ",'Driving License','" +
          priority +
          "'," +
          0 +
          ",'single')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

function health_checkup_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // console.log(data.status)
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < 1; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      // alert('insuffDisable:'+insuffDisable)
      // alert('approvDisable:'+approvDisable)
      html += "            </div>";
      html += "         </div>";
      // if (data.component_data.is_submitted !='0') {
      // html += '   <button class="insuf-btn '+none+'" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
      html +=
        '   <button class="app-btn ' +
        none +
        '" ' +
        approvDisable +
        ' id="app_btn_' +
        i +
        '" onclick="modalapprov(' +
        candidate_id +
        "," +
        component_id +
        ",'Health checkup','" +
        priority +
        "'," +
        i +
        ",'single')\"><i id=\"app_btn_icon_" +
        i +
        '" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
      // }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

function covid_19(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // console.log(data.status)
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < 1; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      // alert('insuffDisable:'+insuffDisable)
      // alert('approvDisable:'+approvDisable)
      html += "            </div>";
      html += "         </div>";
      // if (data.component_data.is_submitted !='0') {
      // html += '   <button class="insuf-btn '+none+'" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
      html +=
        '   <button class="app-btn ' +
        none +
        '" ' +
        approvDisable +
        ' id="app_btn_' +
        i +
        '" onclick="modalapprov(' +
        candidate_id +
        "," +
        component_id +
        ",'Covid-19','" +
        priority +
        "'," +
        i +
        ",'single')\"><i id=\"app_btn_icon_" +
        i +
        '" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
      // }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

function employement_gap_check(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  console.log("permanent_address : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < 1; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      var emp = "";
      if (
        data.component_data.reason_for_gap != null &&
        data.component_data.reason_for_gap != "[]" &&
        data.component_data.reason_for_gap != ""
      ) {
        emp = JSON.parse(data.component_data.reason_for_gap);
      }
      var empdate = "";
      if (
        data.component_data.duration_of_gap != null &&
        data.component_data.duration_of_gap != "[]" &&
        data.component_data.duration_of_gap != ""
      ) {
        empdate = JSON.parse(data.component_data.duration_of_gap);
      }

      if (emp != "") {
        for (var n = 0; n < emp.length; n++) {
          html += '            <div class="col-md-12">';
          html += '            <label">Gap Date Range</label>';
          html +=
            '                   <input type="text"  readonly class="fld form-control"  value="' +
            empdate[n]["date_gap"] +
            '" >';
          html += "            </div>";

          html += '            <div class="col-md-12">';
          html += '            <label">Gap Reason</label>';
          html +=
            '                   <input type="text" class="fld form-control"  value="' +
            emp[n]["reason_for_gap"] +
            '" >';
          html += "            </div>";
        }
      }

      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      // alert('insuffDisable:'+insuffDisable)
      // alert('approvDisable:'+approvDisable)
      html += "            </div>";
      html += "         </div>";
      if (data.component_data.is_submitted != "0") {
        // html += '   <button class="insuf-btn '+none+'" '+insuffDisable+' id="insuf_btn_'+i+'" onclick="modalInsuffi('+candidate_id+','+component_id+',\'Directorship check\',\''+priority+'\','+i+',\'double\')">Insufficiency</button>';
        html +=
          '   <button class="app-btn ' +
          none +
          '" ' +
          approvDisable +
          ' id="app_btn_' +
          i +
          '" onclick="modalapprov(' +
          candidate_id +
          "," +
          component_id +
          ",'Directorship check','" +
          priority +
          "'," +
          i +
          ",'double')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

function landlord_reference(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  console.log("permanent_address : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  var tenant_name = JSON.parse(data.component_data.tenant_name);
  if (tenant_name != null || tenant_name != "") {
    // tenant_name = JSON.parse(data.component_data.tenant_name);
    // $company_name_lenght = tenant_name.length
  } else {
    $company_name_lenght = 0;
  }

  var case_contact_no = data.component_data.case_contact_no;
  if (case_contact_no != null || landlord_name != "") {
    case_contact_no = JSON.parse(case_contact_no);
    // $name_lenght = case_contact_no.length
  } else {
    $name_lenght = 0;
  }

  var landlord_name = JSON.parse(data.component_data.landlord_name);
  if (landlord_name != null || landlord_name != "") {
    // landlord_name = JSON.parse(landlord_name);
    // $name_lenght = landlord_name.length
  } else {
    $name_lenght = 0;
  }

  var component_status = data.component_data.status.split(",");
  let html = "";
  if (component_status.length > 0) {
    var j = 1;
    for (var i = 0; i < component_status.length; i++) {
      var form_status = "";
      var insuffDisable = "";
      var approvDisable = "";
      var rightClass = "";
      if (component_status[i] == "0") {
        form_status = '<span class="text-warning">Pending<span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "1") {
        form_status = '<span class="text-info">Form Filled<span>';
        fontAwsom = '<i class="fa fa-check">';
        rightClass = "bac-gr";
      } else if (component_status[i] == "2") {
        form_status = '<span class="text-success">Completed<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else if (component_status[i] == "3") {
        form_status = '<span class="text-danger">Insufficiency<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        form_status = '<span class="text-success">Verified Clear<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }
      $landlord = "";
      if (landlord_name) {
        $landlord = landlord_name[i]["landlord_name"]
          ? landlord_name[i]["landlord_name"]
          : "";
      }
      $tlname = "";
      if (tenant_name) {
        $tlname = tenant_name[i]["tenant_name"]
          ? tenant_name[i]["tenant_name"]
          : "";
      }

      // html += '<h6 class="full-nam2">Reference '+(j++)+'</h6>';
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html +=
        '               <h6 class="full-nam2">Previous Landlord Reference Check ' +
        j++ +
        "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html +=
        '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status_' +
        i +
        '">' +
        form_status +
        "</span>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row">';
      html += '            <div class="col-md-4 d-none">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Tenant Name</label>";
      html +=
        '                  <input name=""  value="' +
        $tlname +
        '" class="fld form-control tenant_name" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Landlord Contact Number</label>";
      html +=
        '                  <input name=""  value="' +
        case_contact_no[i]["case_contact_no"] +
        '" class="fld form-control case_contact_no" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html += '               <div class="pg-frm">';
      html += "                  <label>Landlord Name</label>";
      html +=
        '                  <input name=""  value="' +
        $landlord +
        '" class="fld form-control landlord_name" type="text">';
      html += "               </div>";
      html += "            </div>";
      html += "         </div>";

      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html += "<label>Insuff Remark Comment</label>";
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }

      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn ' +
          none +
          '" id="insuf_btn_' +
          i +
          '" ' +
          insuffDisable +
          ' onclick="modalInsuffi(' +
          data.component_data.candidate_id +
          ",'" +
          23 +
          "','Landload Reference','" +
          priority +
          "'," +
          i +
          ",'double')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn ' +
          none +
          '" id="app_btn_' +
          i +
          '" ' +
          approvDisable +
          ' onclick="modalapprov(' +
          data.component_data.candidate_id +
          ",'" +
          23 +
          "','Landload Reference','" +
          priority +
          "'," +
          i +
          ",'double')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
    }
  }
  html += '         <div class="row">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";

  $("#component-detail").html(html);
}

function social_media(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";

    if (data.component_data.status == "0") {
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps  d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Test Details</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html +=
      '               <h6 class="full-nam2 font-weight-bold">Social Media Details</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Candidate Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.candidate_name +
      '" class="fld form-control pincode" id="pincode" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Date Of Birth(DOB)</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.dob +
      '"  class="fld form-control state" id="state" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Latest Employment Company name </label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.employee_company_info +
      '"  class="fld form-control state" id="state" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Highest Education College</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.education_info +
      '"  class="fld form-control state" id="state" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                   <label>University name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.university_info +
      '"  class="fld form-control state" id="state" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                   <label> Social media handles if any</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.social_media_info +
      '"  class="fld form-control state" id="state" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += "         </div>";

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";

    if (data.component_data.status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        insuff_remarks[i].insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn ' +
        none +
        '" id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        25 +
        "','Social Media','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn ' +
        none +
        '" id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        25 +
        "','Social Media','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

/*new component */

function sex_offender(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html +=
      '<input name=""  value="' +
      data.component_data.sex_offender_id +
      '" class="fld form-control pincode" id="sex_offender_id" type="hidden">';

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps  d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Test Details</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html +=
      '               <h6 class="full-nam2 font-weight-bold">Sex Offender</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>First Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.first_name +
      '" class="fld form-control global-first_name" id="global-first_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Last Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.last_name +
      '" class="fld form-control global-last_name" id="global-last_name" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Date Of Birth(DOB)</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.dob +
      '"  class="fld form-control global-dob" id="global-dob" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Gender</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.gender +
      '"  class="fld form-control global-gender" id="global-gender" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn " id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        28 +
        "','Sex Offender','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn " id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        28 +
        "','Sex Offender','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function politically_exposed(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html +=
      '<input name=""  value="' +
      data.component_data.politically_exposed_id +
      '" class="fld form-control pincode" id="politically_exposed_id" type="hidden">';

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps  d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Test Details</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html +=
      '               <h6 class="full-nam2 font-weight-bold">Politically Exposed Person</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>First Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.first_name +
      '" class="fld form-control global-first_name" id="global-first_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Last Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.last_name +
      '" class="fld form-control global-last_name" id="global-last_name" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Date Of Birth(DOB)</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.dob +
      '"  class="fld form-control global-dob" id="global-dob" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Gender</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.gender +
      '"  class="fld form-control global-gender" id="global-gender" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Gender</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.address +
      '"  class="fld form-control global-address" id="global-address" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn " id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        29 +
        "','Politically Exposed Person','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn " id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        29 +
        "','Politically Exposed Person','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function india_civil_litigation(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html +=
      '<input name=""  value="' +
      data.component_data.india_civil_litigation_id +
      '" class="fld form-control pincode" id="india_civil_litigation_id" type="hidden">';

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps  d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Test Details</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html +=
      '               <h6 class="full-nam2 font-weight-bold">India Civil Litigation</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>First Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.first_name +
      '" class="fld form-control global-first_name" id="global-first_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Last Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.last_name +
      '" class="fld form-control global-last_name" id="global-last_name" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Date Of Birth(DOB)</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.dob +
      '"  class="fld form-control global-dob" id="global-dob" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Gender</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.gender +
      '"  class="fld form-control global-gender" id="global-gender" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Gender</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.address +
      '"  class="fld form-control global-address" id="global-address" type="text">';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn " id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        30 +
        "','India Civil Litigation','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn " id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        30 +
        "','India Civil Litigation','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function gsa(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html +=
      '<input name=""  value="' +
      data.component_data.gsa_id +
      '" class="fld form-control pincode" id="gsa_id" type="hidden">';

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps  d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Test Details</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html += '               <h6 class="full-nam2 font-weight-bold">GSA</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>First Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.first_name +
      '" class="fld form-control global-first_name" id="global-first_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Last Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.last_name +
      '" class="fld form-control global-last_name" id="global-last_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += "         </div>";

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn " id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        33 +
        "','GSA','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn " id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        33 +
        "','GSA','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function oig(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html +=
      '<input name=""  value="' +
      data.component_data.oig_id +
      '" class="fld form-control pincode" id="oig_id" type="hidden">';

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps  d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Test Details</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html += '               <h6 class="full-nam2 font-weight-bold">OIG</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>First Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.first_name +
      '" class="fld form-control global-first_name" id="global-first_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Last Name</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.last_name +
      '" class="fld form-control global-last_name" id="global-last_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += "         </div>";

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn " id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        34 +
        "','OIG','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn " id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        34 +
        "','OIG','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function mca(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // console.log(JSON.stringify(data))
  // console.log(data)
  var html = "";
  var form_status = "";
  var component_status = "0";
  var j = 1;
  if (data.status != "0") {
    var component_status = data.component_data.status.split(",");
  }
  insuffDisable = "";
  approvDisable = "";
  rightClass = "bac-gr";
  if (candidate_id != "" || candidate_id != null) {
    for (var i = 0; i < 1; i++) {
      // alert()
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html += '               <h6 class="full-nam2">Form ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';

      if (component_status[i] == "0") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-warning" id="form_status_' +
          i +
          '">Not Initiated</span>';
        // insuffDisable = 'disabled'
        // approvDisable = 'disabled'
        // rightClass ='bac-gy'
      } else if (component_status[i] == "1") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-info" id="form_status_' +
          i +
          '">Form Filled</span>';
      } else if (component_status[i] == "2") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Completed</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "3") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-danger" id="form_status_' +
          i +
          '">Insufficiency</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
        var insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
      } else if (component_status[i] == "4") {
        html +=
          '           <label class="font-weight-bold">Verification Status: </label>&nbsp;<span class="text-success" id="form_status_' +
          i +
          '">Verified Clear</span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
        var organization_name = data.component_data.organization_name
          ? data.component_data.organization_name
          : "-";
        var licence_d = data.component_data.experiance_doc
          ? data.component_data.experiance_doc
          : "";
      }
      var organization_name = data.component_data.organization_name
        ? data.component_data.organization_name
        : "-";
      var licence_d = data.component_data.experiance_doc
        ? data.component_data.experiance_doc
        : "";

      html += "            </div>";
      html += "         </div>";

      html += '         <div class="row mt-3">';
      html += '            <div class="col-md-3">';
      html += '               <div class="pg-frm-hd"> </div>';
      html +=
        '                   <label class="font-weight-bold">Organization Name: </label>';
      html +=
        '                   <input type="text" class="fld form-control"  value="' +
        organization_name +
        '" >';
      if (licence_d != null && licence_d != "") {
        var experiance_doc = data.component_data.experiance_doc;
        var experiance_doc = experiance_doc.split(",");
        for (var i = 0; i < experiance_doc.length; i++) {
          var url = img_base_url + "../uploads/mca-docs/" + experiance_doc[i];
          if (/\.(jpg|jpeg|png)$/i.test(experiance_doc[i])) {
            html +=
              '                   <label class="font-weight-bold  mt-3">Driving License: </label>';
            html +=
              '                 <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0 text-wrap">' +
              experiance_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a id="docs_modal_file' +
              data.component_data.candidate_id +
              '" onclick="view_edu_docs_modal(\'' +
              url +
              '\')" data-view_docs="' +
              experiance_doc[i] +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-eye text-primary"></i>';
            html += "                               </a>";
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          } else if (/\.(pdf)$/i.test(experiance_doc[i])) {
            html +=
              '                 <div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">';
            html += '                   <div class="image-selected-div">';
            html += '                       <ul class="p-0 mb-0">';
            html +=
              '                           <li class="image-selected-name pb-0 text-wrap">' +
              experiance_doc[i] +
              "</li>";
            html +=
              '                           <li class="image-name-delete pb-0">';
            html +=
              '                               <a download id="docs_modal_file' +
              data.component_data.candidate_id +
              '" href="' +
              url +
              '" class="image-name-delete-a">';
            html +=
              '                                   <i class="fa fa-arrow-down"></i>';
            html += "                               </a>";
            html += "                           </li>";
            html += "                        </ul>";
            html += "                   </div>";
            html += "                 </div>";
          }
          if (component_status[i] == "3") {
            html += '<div class="row">';
            html +=
              '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
            html += '<div class="col-md-12">';
            html += "<label>Insuff Remark Comment</label>";
            html +=
              '<textarea readonly  class="input-field form-control">' +
              data.component_data.insuff_remarks +
              "</textarea>";
            html += "</div>";
            html += "</div>";
          }
        }
      } else {
        html += '               <div class="pg-frm-hd">There is no file </div>';
      }

      html += "            </div>";
      html += "        </div>";

      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn " ' +
          insuffDisable +
          ' id="insuf_btn_' +
          i +
          '" onclick="modalInsuffi(' +
          data.component_data.candidate_id +
          ",'" +
          31 +
          "','MCA','" +
          priority +
          "'," +
          0 +
          ",'single')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn " ' +
          approvDisable +
          ' id="app_btn_' +
          i +
          '" onclick="modalapprov(' +
          data.component_data.candidate_id +
          ",'" +
          31 +
          "','MCA','" +
          priority +
          "'," +
          0 +
          ",'single')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
      html += "   <hr>";
    }
  }
  html += '         <div class="row mt-2">';
  html += '            <div class="col-md-12">';
  html += '               <div class="pg-submit text-right">';
  html +=
    '                  <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
  html += "               </div>";
  html += "            </div>";
  html += "         </div>";

  // alert(html)
  $("#component-detail").html(html);
}

// diffrent check forms
function right_to_work(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id,
  form_values,
  candidate_id,
  component_id
) {
  console.log("court_records : " + JSON.stringify(data));
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);
  // address pin_code city  state  approved_doc
  let html = "";
  if (data.status != "0") {
    var form_values = JSON.parse(data.component_data.form_values);
    var form_values = JSON.parse(form_values);
    var document_number = JSON.parse(data.component_data.document_number);
    var mobile_number = JSON.parse(data.component_data.mobile_number);
    var first_name = JSON.parse(data.component_data.first_name);
    var last_name = JSON.parse(data.component_data.last_name);
    var dob = JSON.parse(data.component_data.dob);
    var gender = JSON.parse(data.component_data.gender);
    var insuff_remarks = "";
    var component_status = data.component_data.status.split(",");
    // alert(JSON.stringify(form_values['right_to_work']))
    var j = 1;
    // var i = postion;

    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";

    var insuff_remarks = "";
    if (component_status[i] == "3") {
      insuff_remarks = JSON.parse(data.component_data.insuff_remarks);
    }
    for (var i = 0; i < document_number.length; i++) {
      var form_status = "";
      var insuffDisable = "";
      var approvDisable = "";
      var rightClass = "";
      var none = "";
      if (component_status[i] == "0") {
        none = "d-none";
        form_status = '<span class="text-warning">Pending<span>';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      } else if (component_status[i] == "1") {
        none = "d-none";
        form_status = '<span class="text-info">Form Filled<span>';
        fontAwsom = '<i class="fa fa-check">';
        rightClass = "bac-gr";
      } else if (component_status[i] == "2") {
        form_status = '<span class="text-success">Completed<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else if (component_status[i] == "3") {
        form_status = '<span class="text-danger">Insufficiency<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        var insuff_remarks = JSON.parse(data.component_data.Insuff_remarks);
      } else if (component_status[i] == "4") {
        form_status = '<span class="text-success">Verified Clear<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gr";
      } else {
        form_status = '<span class="text-warning">Pending<span>';
        fontAwsom = '<i class="fa fa-check">';
        insuffDisable = "disabled";
        approvDisable = "disabled";
        rightClass = "bac-gy";
      }

      html += '<div class="pg-cnt pl-0 pt-0">';
      html += '      <div class="pg-txt-cntr">';
      // html += '         <h4 class="full-nam2">Previous Employment '+(j++)+'</h4>';
      html += '         <div class="row">';
      html += '            <div class="col-md-6">';
      html +=
        '               <h6 class="full-nam2">Right To Work ' + j++ + "</h6> ";
      html += "            </div>";
      html += '            <div class="col-md-4">';
      html +=
        '               <label class="font-weight-bold">Status: </label>&nbsp;<span id="form_status_' +
        i +
        '">' +
        form_status +
        "</span>";
      html += "            </div>";
      html += "         </div>";
      html += '         <div class="row">';
      html += '<div class="col-md-4">';
      html += '<div class="input-wrap">';
      html += '<div class="pg-frm">';
      html += '<span class="input-field-txt">Document Number</span>';
      html +=
        '<textarea class="input-field form-control" readonly rows="1" id="document_number">' +
        document_number[i].document_number +
        "</textarea>";
      html += "</div>";
      html += "</div>";
      html += "</div>";
      if (form_values.right_to_work[i] == 2) {
        html += '<div class="col-md-4">';
        html += '<div class="input-wrap">';
        html += '<div class="pg-frm">';
        html += '<span class="input-field-txt">Mobile Number</span>';
        html +=
          '<input readonly value="' +
          mobile_number[0].mobile_number +
          '" class="input-field form-control" id="mobile_number" type="text">';
        html += "</div>";
        html += "</div>";
        html += "</div>";
      }

      html += '<div class="col-md-4">';
      html += '<div class="input-wrap">';
      html += '<div class="pg-frm">';
      html += '<span class="input-field-txt">First Name</span>';
      html +=
        '<input readonly value="' +
        first_name[i].first_name +
        '" class="input-field form-control" id="first_name" type="text">';
      html += "</div>";
      html += "</div>";
      html += "</div>";

      html += '<div class="col-md-4">';
      html += '<div class="input-wrap">';
      html += '<div class="pg-frm">';
      html += '<span class="input-field-txt">Last Name</span>';
      html +=
        '<input readonly value="' +
        last_name[i].last_name +
        '" class="input-field form-control" id="last_name" type="text">';
      html += "</div>";
      html += "</div>";
      html += "</div>";

      html += "</div>";
      html += '<div class="row">';
      html += '<div class="col-md-4">';
      html += '<div class="input-wrap">';
      html += '<div class="pg-frm">';
      html += '<span class="input-field-txt">Date Of Birth</span>';
      html +=
        '<input readonly value="' +
        dob[i].dob +
        '" class="input-field form-control" id="dob" type="text">';
      html += "</div>";
      html += "</div>";
      html += "</div>";
      html += '<div class="col-md-4">';
      html += '<div class="input-wrap">';
      html += '<div class="pg-frm">';
      html += '<span class="input-field-txt">Gender</span>';
      html +=
        '<input readonly value="' +
        gender[i].gender +
        '"  class="input-field form-control" id="gender" type="text">';
      html += "</div>";
      html += "</div>";
      html += "</div>";
      html += "         </div>";
      html += "      </div>";
      html += "   </div>";
      // alert(info[i].address)

      if (component_status[i] == "3") {
        html += '<div class="row">';
        html +=
          '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
        html += '<div class="col-md-12">';
        html +=
          '<textarea readonly  class="input-field form-control">' +
          insuff_remarks[i].insuff_remarks +
          "</textarea>";
        html += "</div>";
        html += "</div>";
      }

      if (data.component_data.is_submitted != "0") {
        html +=
          '   <button class="insuf-btn " ' +
          insuffDisable +
          ' id="insuf_btn_' +
          i +
          '" onclick="modalInsuffi(' +
          data.component_data.candidate_id +
          ",'" +
          27 +
          "','Right To Work','" +
          priority +
          "'," +
          i +
          ",'single')\">Raise Insufficiency</button>";
        html +=
          '   <button class="app-btn " ' +
          approvDisable +
          ' id="app_btn_' +
          i +
          '" onclick="modalapprov(' +
          data.component_data.candidate_id +
          ",'" +
          27 +
          "','Right To Work','" +
          priority +
          "'," +
          i +
          ",'single')\"><i id=\"app_btn_icon_" +
          i +
          '" class="fa fa-check ' +
          rightClass +
          '"></i> Approve</button>';
      }
    }
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                 <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data is not submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function nric(
  data,
  priority,
  component_name,
  form_values,
  candidate_id,
  component_id
) {
  // console.log('court_records : '+JSON.stringify(data))
  $("#componentModal").modal("show");
  $("#modal-headding").html(component_name);

  let html = "";
  if (data.status != "0") {
    var form_status = "";
    var insuffDisable = "";
    var approvDisable = "";
    var rightClass = "";
    var none = "";
    if (data.component_data.status == "0") {
      none = "d-none";
      form_status = '<span class="text-warning">Pending<span>';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    } else if (data.component_data.status == "1") {
      none = "d-none";
      form_status = '<span class="text-info">Form Filled<span>';
      fontAwsom = '<i class="fa fa-check">';
      rightClass = "bac-gr";
    } else if (data.component_data.status == "2") {
      form_status = '<span class="text-success">Completed<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else if (data.component_data.status == "3") {
      form_status = '<span class="text-danger">Insufficiency<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
    } else if (data.component_data.status == "4") {
      form_status = '<span class="text-success">Verified Clear<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gr";
    } else {
      form_status = '<span class="text-warning">Pending<span>';
      fontAwsom = '<i class="fa fa-check">';
      insuffDisable = "disabled";
      approvDisable = "disabled";
      rightClass = "bac-gy";
    }

    html +=
      '<input name=""  value="' +
      data.component_data.oig_id +
      '" class="fld form-control pincode" id="oig_id" type="hidden">';

    html += ' <div class="pg-cnt pl-0 pt-0">';
    html += '      <div class="pg-txt-cntr">';
    html += '         <div class="pg-steps  d-none">Step 2/6</div>';
    // html += '         <h6 class="full-nam2">Test Details</h6>';
    html += '         <div class="row">';
    html += '            <div class="col-md-6">';
    html += '               <h6 class="full-nam2 font-weight-bold">NRIC</h6> ';
    html += "            </div>";
    html += '            <div class="col-md-4">';
    html +=
      '               <label class="font-weight-bold">Verification Status: </label>&nbsp;<span id="form_status">' +
      form_status +
      "</span>";
    html += "            </div>";
    html += "         </div>";
    html += '         <div class="row">';
    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>NRIC Number</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.nric_number +
      '" class="fld form-control global-first_name" id="global-first_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Joining Date</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.joining_date +
      '" class="fld form-control global-last_name" id="global-last_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Expiry Date</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.end_date +
      '" class="fld form-control global-last_name" id="global-last_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += '            <div class="col-md-4">';
    html += '               <div class="pg-frm">';
    html += "                  <label>Gender</label>";
    html +=
      '                  <input name=""  value="' +
      data.component_data.gender +
      '" class="fld form-control global-last_name" id="global-last_name" type="text">';
    html += "               </div>";
    html += "            </div>";

    html += "         </div>";

    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html += '               <div class="pg-submit text-right">';
    html +=
      '                <button id="add_global" onclick="add_global()" class="btn bg-blu text-white d-none">Update</button>';
    html +=
      '                <button id="add_employments" data-dismiss="modal" class="btn bg-blu text-white">CLOSE</button>';
    html += "               </div>";
    html += "            </div>";
    html += "         </div>";
    html += "      </div>";
    html += "   </div>";

    if (data.component_data.analyst_status == "3") {
      html += '<div class="row">';
      html +=
        '<div class="col-md-12"><div class="pg-frm-hd text-danger">Insuff Remark</div></div>';
      html += '<div class="col-md-12">';
      html += "<label>Insuff Remark Comment</label>";
      html +=
        '<textarea readonly  class="input-field form-control">' +
        data.component_data.insuff_remarks +
        "</textarea>";
      html += "</div>";
      html += "</div>";
    }
    if (data.component_data.is_submitted != "0") {
      html +=
        '   <button class="insuf-btn " id="insuf_btn" ' +
        insuffDisable +
        ' onclick="modalInsuffi(' +
        data.component_data.candidate_id +
        ",'" +
        32 +
        "','NRIC','" +
        priority +
        "'," +
        0 +
        ",'single')\">Raise Insufficiency</button>";
      html +=
        '   <button class="app-btn " id="app_btn" ' +
        approvDisable +
        ' onclick="modalapprov(' +
        data.component_data.candidate_id +
        ",'" +
        32 +
        "','NRIC','" +
        priority +
        "'," +
        0 +
        ',\'single\')"><i id="app_btn_icon" class="fa fa-check ' +
        rightClass +
        '"></i> Approve</button>';
    }
    html += "   <hr>";
  } else {
    html += '         <div class="row">';
    html += '            <div class="col-md-12">';
    html +=
      '               <h6 class="full-nam2">Data has not been submited yet.</h6>';
    html += "            </div>";
    html += "         </div>";
  }
  $("#component-detail").html(html);
}

function view_edu_docs_modal(url) {
  // var image = $('#docs_modal_file'+documentName).data('view_docs');
  $("#view-image").attr("src", url);

  let html = "";

  html += '<a download class="btn bg-blu text-white" href="' + url + '">';
  html += '<i class="fa fa-download" aria-hidden="true">Download</i>';
  html += "</a>";
  html +=
    '<a class="btn bg-blu text-white mt-2" target="_blank" href="' + url + '">';
  html +=
    '<i class="fa fa-eye" aria-hidden="true"> View document in separate tab</i>';
  html += "</a>";

  $("#setupDownloadBtn").html(html);
  $("#view_image_modal").modal("show");
}

// function view_document_modal(documentName,folderName){
//     var image = $('#docs_modal_file'+documentName).data('view_docs');
//     $('#view-image').attr("src", img_base_url+"../uploads/"+folderName+"/"+image);

//     let html = '';

//     html += '<a download class="btn bg-blu text-white" href="'+img_base_url+"../uploads/"+folderName+"/"+image+'">'
//     html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
//     html += '</a>';

//     $('#setupDownloadBtn').html(html)
//     $('#view_image_modal').modal('show');
// }

// function view_personal_document_modal(documentName,folderName){
//     var image = $('#docs_modal_file'+documentName).data('view_docs');
//     $('#view-image').attr("src", img_base_url+"../uploads/"+folderName+"/"+image);

//     let html = '';

//     html += '<a download class="btn bg-blu text-white" href="'+img_base_url+"../uploads/"+folderName+"/"+image+'">'
//     html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
//     html += '</a>';
//     $('#setupDownloadBtn').html(html)
//     $('#view_image_modal').modal('show');
// }

function indexFromTheValue(valueArray, searchingNumber) {
  return valueArray.indexOf(searchingNumber);
}

function add_criminal() {
  var address = [];
  $(".criminal-address").each(function () {
    // address['address']=$(this).val();
    // if ($(this).val() !='' && $(this).val() !=null) {
    address.push({ address: $(this).val() });
    // }
  });

  var pincode = [];
  $(".criminal-pincode").each(function () {
    // pincode.push($(this).val());
    // if ($(this).val() !='' && $(this).val() !=null) {
    pincode.push({ pincode: $(this).val() });
    // }
  });
  var city = [];
  $(".criminal-city").each(function () {
    // city.push($(this).val());
    // if ($(this).val() !='' && $(this).val() !=null) {
    city.push({ city: $(this).val() });
    // }
  });
  var state = [];
  $(".criminal-state").each(function () {
    // state.push($(this).val());
    // if ($(this).val() !='' && $(this).val() !=null) {
    state.push({ state: $(this).val() });
    // }
  });
  var country = [];
  $(".criminal-country").each(function () {
    // state.push($(this).val());
    // if ($(this).val() !='' && $(this).val() !=null) {
    country.push({ country: $(this).val() });
    // }
  });

  var criminal_checks_id = $("#criminal_checks_id").val();

  var formdata = new FormData();
  formdata.append("url", 1);
  formdata.append("address", JSON.stringify(address));
  formdata.append("pincode", JSON.stringify(pincode));
  formdata.append("city", JSON.stringify(city));
  formdata.append("state", JSON.stringify(state));
  formdata.append("country", JSON.stringify(country));

  if (criminal_checks_id != "" && criminal_checks_id != null) {
    formdata.append("criminal_checks_id", criminal_checks_id);
  }

  if (
    address.length > 0 &&
    pincode.length > 0 &&
    city.length > 0 &&
    state.length > 0
  ) {
    $("#add_criminal").html(
      '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
    );
    $("#warning-msg").html(
      "<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"
    );
    $.ajax({
      type: "POST",
      url: base_url + "inputQc/update_candidate_criminal_check",
      data: formdata,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (data) {
        if (data.status == "1") {
          toastr.success("successfully updated data.");
        } else {
          toastr.error(
            "Something went wrong while save this data. Please try again."
          );
        }
        $("#warning-msg").html("");
        $("#add_criminal").html("Update");
        $("#add_criminal").addClass("d-none");
        $(".insuf-btn").removeClass("d-none");
        $(".app-btn").removeClass("d-none");
      },
    });
  }
}

function add_court() {
  var address = [];
  $(".court-address").each(function () {
    // address['address']=$(this).val();
    // if ($(this).val() !='' && $(this).val() !=null) {
    address.push({ address: $(this).val() });
    // }
  });

  var pincode = [];
  $(".court-pincode").each(function () {
    // pincode.push($(this).val());
    // if ($(this).val() !='' && $(this).val() !=null) {
    pincode.push({ pincode: $(this).val() });
    // }
  });
  var city = [];
  $(".court-city").each(function () {
    // city.push($(this).val());
    // if ($(this).val() !='' && $(this).val() !=null) {
    city.push({ city: $(this).val() });
    // }
  });
  var state = [];
  $(".court-state").each(function () {
    // state.push($(this).val());
    // if ($(this).val() !='' && $(this).val() !=null) {
    state.push({ state: $(this).val() });
    // }
  });
  var country = [];
  $(".court-country").each(function () {
    // state.push($(this).val());
    // if ($(this).val() !='' && $(this).val() !=null) {
    country.push({ country: $(this).val() });
    // }
  });

  var court_records_id = $("#court_records_id").val();

  var formdata = new FormData();
  formdata.append("url", 1);
  formdata.append("address", JSON.stringify(address));
  formdata.append("pincode", JSON.stringify(pincode));
  formdata.append("city", JSON.stringify(city));
  formdata.append("state", JSON.stringify(state));
  formdata.append("country", JSON.stringify(country));

  if (court_records_id != "" && court_records_id != null) {
    formdata.append("court_records_id", court_records_id);
  }

  if (
    address.length > 0 &&
    pincode.length > 0 &&
    city.length > 0 &&
    state.length > 0
  ) {
    $("#add_court").html(
      '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
    );
    $("#warning-msg").html(
      "<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"
    );
    $.ajax({
      type: "POST",
      url: base_url + "inputQc/update_candidate_court_record",
      data: formdata,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (data) {
        if (data.status == "1") {
          toastr.success("successfully updated data.");
        } else {
          toastr.error(
            "Something went wrong while save this data. Please try again."
          );
        }
        $("#warning-msg").html("");
        $("#add_court").html("Update");
        $("#add_court").addClass("d-none");
        $(".insuf-btn").removeClass("d-none");
        $(".app-btn").removeClass("d-none");
      },
    });
  }
}

function add_document() {
  var document_check_id = $("#document_check_id").val();
  var adhar_number = $("#adhar_number").val();
  var pancard = $("#pancard").val();
  var passport_number = $("#passport_number").val();

  var formdata = new FormData();
  formdata.append("url", 1);
  formdata.append("adhar_number", adhar_number);
  formdata.append("pancard", pancard);
  formdata.append("passport_number", passport_number);

  if (document_check_id != "" && document_check_id != null) {
    formdata.append("document_check_id", document_check_id);
  }

  $("#add_document").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );
  $("#warning-msg").html(
    "<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"
  );
  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_document_check",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
      } else {
        toastr.error(
          "Something went wrong while save this data. Please try again."
        );
      }
      $("#warning-msg").html("");
      $("#add_document").html("Update");
      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}

/* drug */

function add_drug() {
  var address = [];
  $(".drug-address").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    address.push({ address: $(this).val() });
    // }
  });

  var contact_number = [];
  $(".drug-mobile_number").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    contact_number.push({ mobile_number: $(this).val() });
    // }
  });
  var name = [];
  $(".drug-candidate_name").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    name.push({ candidate_name: $(this).val() });
    // }
  });
  var date_of_birth = [];
  $(".drug-dob").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    date_of_birth.push({ dob: $(this).val() });
    // }
  });
  var father_name = [];
  $(".drug-father_name").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    father_name.push({ father_name: $(this).val() });
    // }
  });
  var drugtest_id = $("#drugtest_id").val();
  var formdata = new FormData();
  formdata.append("url", 4);
  formdata.append("address", JSON.stringify(address));
  formdata.append("name", JSON.stringify(name));
  formdata.append("father_name", JSON.stringify(father_name));
  formdata.append("date_of_birth", JSON.stringify(date_of_birth));
  formdata.append("contact_no", JSON.stringify(contact_number));

  if (drugtest_id != "" && drugtest_id != null) {
    formdata.append("drugtest_id", drugtest_id);
  }

  $("#add_drug").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );
  $("#warning-msg").html(
    "<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"
  );
  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_drug_test",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
      } else {
        toastr.error(
          "Something went wrong while save this data. Please try again."
        );
      }
      $("#warning-msg").html("");
      $("#add_drug").html("Update");
      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}

function add_global() {
  var name = [];
  $(".global-candidate_name").each(function () {
    name.push($(this).val());
  });
  var father_name = [];
  $(".global-father_name").each(function () {
    father_name.push($(this).val());
  });
  var date_of_birth = [];
  $(".global-dob").each(function () {
    date_of_birth.push($(this).val());
  });

  var global_id = $("#globaldatabase_id").val();

  if (name != "" && father_name != "" && date_of_birth != "") {
    var formdata = new FormData();
    formdata.append("url", 5);
    formdata.append("name", name);
    formdata.append("father_name", father_name);
    formdata.append("date_of_birth", date_of_birth);

    if (global_id != "" && global_id != null) {
      formdata.append("global_id", global_id);
    }
    $("#add-global-database").html(
      '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
    );

    $("#warning-msg").html(
      "<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"
    );
    $.ajax({
      type: "POST",
      url: base_url + "inputQc/update_candidate_global",
      data: formdata,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (data) {
        $(".insuf-btn").removeClass("d-none");
        $(".app-btn").removeClass("d-none");
        if (data.status == "1") {
          toastr.success("successfully updated data.");
        } else {
          toastr.error(
            "Something went wrong while saving the data. Please try again."
          );
        }
        $("#warning-msg").html("");
        $("#add-global-database").html("Save & Continue");
      },
    });
  }
}

function add_current_employments() {
  var designation = $("#current-designation").val();
  var department = $("#current-department").val();
  var employee_id = $("#current-employee_id").val();

  var company_name = $("#current-company-name").val();
  var address = $("#current-address").val();
  var annual_ctc = $("#current-annual-ctc").val();

  var reasion = $("#current-reasion").val();
  var joining_date = $("#current-joining-date").val();
  var relieving_date = $("#current-relieving-date").val();

  var manager_name = $("#current-reporting-manager-name").val();
  var manager_designation = $("#current-reporting-manager-designation").val();
  var manager_contact = $("#current-reporting-manager-contact").val();

  var hr_name = $("#current-hr-name").val();
  var hr_contact = $("#current-hr-contact").val();
  var hr_code = $("#current-hr-code").val();

  $("#add_current_employments").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );

  var formdata = new FormData();
  formdata.append("url", 6);
  formdata.append("designation", designation);
  formdata.append("department", department);
  formdata.append("employee_id", employee_id);
  formdata.append("company_name", company_name);
  formdata.append("address", address);
  formdata.append("annual_ctc", annual_ctc);
  formdata.append("reasion", reasion);
  formdata.append("joining_date", joining_date);
  formdata.append("relieving_date", relieving_date);
  formdata.append("manager_name", manager_name);
  formdata.append("manager_designation", manager_designation);
  formdata.append("manager_contact", manager_contact);
  formdata.append("hr_name", hr_name);
  formdata.append("hr_contact", hr_contact);

  var current_emp_id = $("#current_emp_id").val();
  if (current_emp_id != "" && current_emp_id != null) {
    formdata.append("current_emp_id", current_emp_id);
  }

  $("#warning-msg").html(
    "<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"
  );
  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_employment",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
      } else {
        toastr.error(
          "Something went wrong while save this data. Please try again."
        );
      }
      $("#warning-msg").html("");
      $("#add_current_employments").html("Update");
      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}

function add_education() {
  var time = [];
  $(".education-part_time:checked").each(function () {
    time.push({ type_of_course: $(this).val() });
  });

  var type_of_degree = [];
  $(".education-type_of_degree").each(function () {
    if ($(this).val() != "") {
      type_of_degree.push({ type_of_degree: $(this).val() });
    } else {
      type_of_degree.push({ type_of_degree: "-" });
    }
  });

  var major = [];
  $(".education-major").each(function () {
    if ($(this).val() != "") {
      major.push({ major: $(this).val() });
    } else {
      major.push({ major: "-" });
    }
  });

  var university = [];
  $(".education-university").each(function () {
    university.push({ university_board: $(this).val() });
  });

  var college_name = [];
  $(".education-college_name").each(function () {
    college_name.push({ college_school: $(this).val() });
  });

  var address = [];
  $(".education-address").each(function () {
    address.push({ address_of_college_school: $(this).val() });
  });

  var registration_roll_number = [];
  $(".education-registration_roll_number").each(function () {
    registration_roll_number.push({ registration_roll_number: $(this).val() });
  });

  var course_start_date = [];
  $(".education-start-date").each(function () {
    course_start_date.push({ course_start_date: $(this).val() });
  });

  var course_end_date = [];
  $(".education-end-date").each(function () {
    course_end_date.push({ course_end_date: $(this).val() });
  });

  var formdata = new FormData();
  formdata.append("url", 7);
  formdata.append("time", JSON.stringify(time));
  formdata.append("type_of_degree", JSON.stringify(type_of_degree));
  formdata.append("major", JSON.stringify(major));
  formdata.append("university", JSON.stringify(university));
  formdata.append("college_name", JSON.stringify(college_name));
  formdata.append("address", JSON.stringify(address));
  // formdata.append('duration_of_course',JSON.stringify(duration_of_course));
  formdata.append(
    "registration_roll_number",
    JSON.stringify(registration_roll_number)
  );
  formdata.append("course_start_date", JSON.stringify(course_start_date));
  formdata.append("course_end_date", JSON.stringify(course_end_date));

  var education_id = $("#education_id").val();
  if (education_id != "" && education_id != null) {
    formdata.append("education_details_id", education_id);
  }
  $("#add_education").attr("disabled", true);
  $("#add_education").css("pointer", "none");

  $("#warning-msg").html(
    "<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"
  );
  $("#add_education").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );

  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_education_details",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
        $("#add_education").html("Update");
      } else {
        toastr.error(
          "Something went wrong while save this data. Please try again."
        );
      }
      $("#warning-msg").html("");
      $("#add_education").attr("disabled", false);
      // $("#add_education").removeCss('pointer');

      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}

function add_present() {
  var house = $("#present-house-flat").val();
  var street = $("#present-street").val();
  var area = $("#present-area").val();
  var city = $("#present-city").val();
  var state = $("#present-state").val();
  var pincode = $("#present-pincode").val();
  var land_mark = $("#present-land-mark").val();
  var start_date = $("#present-start-date").val();
  var end_date = $("#present-end-date").val();
  var present = $("#present-customCheck1:checked").val();
  var name = $("#present-name").val();
  var relationship = $("#present-relationship").val();
  var contact_no = $("#present-contact_no").val();
  var code = $("#present-code").val();

  var rental_agreement = $("#rental_agreement").val();

  $("#add_present").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );

  var formdata = new FormData();
  formdata.append("url", 8);
  formdata.append("house", house);
  formdata.append("street", street);
  formdata.append("area", area);
  formdata.append("city", city);
  formdata.append("state", state);
  formdata.append("pincode", pincode);
  formdata.append("land_mark", land_mark);
  formdata.append("start_date", start_date);
  formdata.append("end_date", end_date);
  formdata.append("present", present);
  formdata.append("name", name);
  formdata.append("relationship", relationship);
  formdata.append("contact_no", contact_no);
  var present_address_id = $("#present_address_id").val();
  if (present_address_id != "" && present_address_id != null) {
    formdata.append("present_address_id", present_address_id);
  }

  $("#add_present").attr("disabled", true);
  $("#add_present").css("pointer", "none");
  $("#warning-msg").html(
    "<span class='text-warning error-msg-small' >Please wait we are submitting the data.</span>"
  );

  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_present_address",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
        $("#add_present").html("Update");
      } else {
        toastr.error(
          "Something went wrong while saving the data. Please try again."
        );
      }
      $("#add_present").attr("disabled", false);
      $("#add_present").css("pointer", "none");
      $("#warning-msg").html("");
      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}

/*parmanent address*/

function add_permanent() {
  var permanent_address_id = $("#permanent_address_id").val();
  var permenent_house = $("#permanent-house-flat").val();
  var permenent_street = $("#permanent-street").val();
  var permenent_area = $("#permanent-area").val();
  var permenent_city = $("#permanent-city").val();
  var permenent_state = $("#permanent-state").val();
  var permenent_pincode = $("#permanent-pincode").val();
  var permenent_land_mark = $("#permanent-land-mark").val();
  var permenent_start_date = $("#permanent-start-date").val();
  var permenent_end_date = $("#permanent-end-date").val();
  var permenent_present = $("#permanent-customCheck1:checked").val();
  var permenent_name = $("#permanent-name").val();
  var permenent_relationship = $("#permanent-relationship").val();
  var permenent_contact_no = $("#permanent-contact_no").val();
  $("#add_permanent").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );

  var formdata = new FormData();

  formdata.append("url", 9);
  formdata.append("permenent_house", permenent_house);
  formdata.append("permenent_street", permenent_street);
  formdata.append("permenent_area", permenent_area);
  formdata.append("permenent_city", permenent_city);
  formdata.append("permenent_state", permenent_state);
  formdata.append("permenent_pincode", permenent_pincode);
  formdata.append("permenent_land_mark", permenent_land_mark);
  formdata.append("permenent_start_date", permenent_start_date);
  formdata.append("permenent_end_date", permenent_end_date);
  formdata.append("permenent_present", permenent_present);
  formdata.append("permenent_name", permenent_name);
  formdata.append("permenent_relationship", permenent_relationship);
  formdata.append("permenent_contact_no", permenent_contact_no);
  if (permanent_address_id != "" && permanent_address_id != null) {
    formdata.append("permanent_address_id", permanent_address_id);
  }

  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_address",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
      } else {
        toastr.error(
          "Something went wrong while saving the data. Please try again."
        );
      }
      $("#add_permanent").html("Update");
      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}

function add_previous_employments() {
  var designation = [];
  $(".previous-designation").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    designation.push({ desigination: $(this).val() });
    // }
  });
  var department = [];
  $(".previous-department").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    department.push({ department: $(this).val() });
    // }
  });
  var employee_id = [];
  $(".previous-employee_id").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    employee_id.push({ employee_id: $(this).val() });
    // }
  });
  var company_name = [];
  $(".previous-company-name").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    company_name.push({ company_name: $(this).val() });
    // }
  });
  var address = [];
  $(".previous-address").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    address.push({ address: $(this).val() });
    // }
  });
  var annual_ctc = [];
  $(".previous-annual-ctc").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    annual_ctc.push({ annual_ctc: $(this).val() });
    // }
  });
  var reasion = [];
  $(".previous-reasion").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    reasion.push({ reason_for_leaving: $(this).val() });
    // }
  });
  var joining_date = [];
  $(".previous-joining-date").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    joining_date.push({ joining_date: $(this).val() });
    // }
  });
  var relieving_date = [];
  $(".previous-relieving-date").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    relieving_date.push({ relieving_date: $(this).val() });
    // }
  });
  var manager_name = [];
  $(".previous-reporting-manager-name").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    manager_name.push({ reporting_manager_name: $(this).val() });
    // }
  });
  var manager_designation = [];
  $(".previous-reporting-manager-designation").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    manager_designation.push({ reporting_manager_desigination: $(this).val() });
    // }
  });
  var manager_contact = [];
  $(".previous-reporting-manager-contact").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    manager_contact.push({ reporting_manager_contact_number: $(this).val() });
    // }
  });
  var hr_name = [];
  $(".previous-hr-name").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    hr_name.push({ hr_name: $(this).val() });
    // }
  });
  var hr_contact = [];
  $(".previous-hr-contact").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    hr_contact.push({ hr_contact_number: $(this).val() });
    // }
  });

  var code = [];
  $(".previous-code").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    code.push({ code: $(this).val() });
    // }
  });
  var hr_code = [];
  $(".previous-hr-code").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    hr_code.push({ hr_code: $(this).val() });
    // }
  });
  var appointment_letter = []; // $("#appointment_letter").val();
  var experience_relieving_letter = []; // $("#experience_relieving_letter").val();
  var last_month_pay_slip = []; // $("#last_month_pay_slip").val();

  $(".previous-appointment").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    appointment_letter.push({ appointment_letter: $(this).val() });
    // }
  });

  $(".previous-experience").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    experience_relieving_letter.push({
      experience_relieving_letter: $(this).val(),
    });
    // }
  });

  $(".previous-last_month").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    last_month_pay_slip.push({ last_month_pay_slip: $(this).val() });
    // }
  });

  var formdata = new FormData();
  formdata.append("url", 10);
  formdata.append("designation", JSON.stringify(designation));
  formdata.append("department", JSON.stringify(department));
  formdata.append("employee_id", JSON.stringify(employee_id));
  formdata.append("company_name", JSON.stringify(company_name));
  formdata.append("address", JSON.stringify(address));
  formdata.append("annual_ctc", JSON.stringify(annual_ctc));
  formdata.append("reasion", JSON.stringify(reasion));
  formdata.append("joining_date", JSON.stringify(joining_date));
  formdata.append("relieving_date", JSON.stringify(relieving_date));
  formdata.append("manager_name", JSON.stringify(manager_name));
  formdata.append("manager_designation", JSON.stringify(manager_designation));
  formdata.append("manager_contact", JSON.stringify(manager_contact));
  formdata.append("hr_name", JSON.stringify(hr_name));
  formdata.append("hr_contact", JSON.stringify(hr_contact));
  var previous_emp_id = $("#previous_emp_id").val();
  if (previous_emp_id != "" && previous_emp_id != null) {
    formdata.append("previous_emp_id", previous_emp_id);
  }

  $("#add_previous_employments").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );

  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_previous_employment",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
      } else {
        toastr.error(
          "Something went wrong while save this data. Please try again."
        );
      }
      $("#add_previous_employments").html("Update");
      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}

function add_reference() {
  var name = [];
  $(".name").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      name.push($(this).val());
    }
  });
  var company_name = [];
  $(".company-name").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      company_name.push($(this).val());
    }
  });
  var designation = [];
  $(".designation").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      designation.push($(this).val());
    }
  });
  var contact = [];
  $(".contact").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      contact.push($(this).val());
    }
  });
  var code = [];
  $(".code").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      code.push($(this).val());
    }
  });
  var email = [];
  $(".email").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      email.push($(this).val());
    }
  });
  var association = [];
  $(".association").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      association.push($(this).val());
    }
  });
  var start_date = [];
  $(".start-time").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      start_date.push($(this).val());
    }
  });
  var end_date = [];
  $(".end-time").each(function () {
    if ($(this).val() != "" && $(this).val() != null) {
      end_date.push($(this).val());
    }
  });

  var formdata = new FormData();
  formdata.append("url", 11);
  formdata.append("name", name);
  formdata.append("company_name", company_name);
  formdata.append("designation", designation);
  formdata.append("contact", contact);
  formdata.append("email", email);
  formdata.append("association", association);
  formdata.append("start_date", start_date);
  formdata.append("end_date", end_date);
  formdata.append("code", code);
  var reference_id = $("#reference_id").val();
  if (reference_id != "" && reference_id != null) {
    formdata.append("reference_id", reference_id);
  }

  $("#warning-msg").html(
    "<span class='text-warning'>Please wait we are submitting the data.</span>"
  );
  $("#add_reference").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );

  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_reference",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
      } else {
        toastr.error(
          "Something went wrong while save this data. Please try again."
        );
      }
      $("#warning-msg").html("");
      $("#add_reference").html("Update");
      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}

function add_address() {
  var flat_no = [];
  $(".house-flat").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    flat_no.push({ flat_no: $(this).val() });
    // }
  });
  var street = [];
  $(".street").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    street.push({ street: $(this).val() });
    // }
  });
  var area = [];
  $(".area").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    area.push({ area: $(this).val() });
    // }
  });
  var city = [];
  $(".city").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    city.push({ city: $(this).val() });
    // }
  });
  var pin_code = [];
  $(".pincode").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    pin_code.push({ pin_code: $(this).val() });
    // }
  });
  var nearest_landmark = [];
  $(".land-mark").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    nearest_landmark.push({ nearest_landmark: $(this).val() });
    // }
  });
  var state = [];
  $(".state").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    state.push({ state: $(this).val() });
    // }
  });
  var country = [];
  $(".country").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    country.push({ country: $(this).val() });
    // }
  });

  var contact_person_relationship = [];
  $(".relationship").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    contact_person_relationship.push({
      contact_person_relationship: $(this).val(),
    });
    // }
  });
  var duration_of_stay_start = [];
  $(".start-date").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    duration_of_stay_start.push({ duration_of_stay_start: $(this).val() });
    // }
  });
  var duration_of_stay_end = [];
  $(".end-date").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    duration_of_stay_end.push({ duration_of_stay_end: $(this).val() });
    // }
  });
  var contact_person_name = [];
  $(".name").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    contact_person_name.push({ contact_person_name: $(this).val() });
    // }
  });
  var contact_person_mobile_number = [];
  $(".contact_no").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    contact_person_mobile_number.push({
      contact_person_mobile_number: $(this).val(),
    });
    // }
  });
  var code = [];
  $(".code").each(function () {
    // if ($(this).val() !='' && $(this).val() !=null) {
    code.push({ code: $(this).val() });
    // }
  });

  var previos_address_id = $("#previos_address_id").val();

  var rental_agreement = []; //$("#rental_agreement").val();

  $(".rental").each(function () {
    if ($(this).val() != null) {
      rental_agreement.push($(this).val());
    }
  });

  var formdata = new FormData();

  formdata.append("url", 12);
  formdata.append("permenent_house", JSON.stringify(flat_no));
  formdata.append("permenent_street", JSON.stringify(street));
  formdata.append("permenent_area", JSON.stringify(area));
  formdata.append("permenent_city", JSON.stringify(city));
  formdata.append("permenent_pincode", JSON.stringify(pin_code));
  formdata.append("permenent_land_mark", JSON.stringify(nearest_landmark));
  formdata.append(
    "permenent_start_date",
    JSON.stringify(duration_of_stay_start)
  );
  formdata.append("permenent_end_date", JSON.stringify(duration_of_stay_end));
  formdata.append("permenent_name", JSON.stringify(contact_person_name));
  formdata.append(
    "permenent_relationship",
    JSON.stringify(contact_person_relationship)
  );
  formdata.append(
    "permenent_contact_no",
    JSON.stringify(contact_person_mobile_number)
  );

  formdata.append("previos_address_id", previos_address_id);

  $("#warning-msg").html(
    "<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"
  );
  $("#add_address").html(
    '<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...'
  );

  $.ajax({
    type: "POST",
    url: base_url + "inputQc/update_candidate_previous_address",
    data: formdata,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status == "1") {
        toastr.success("successfully updated data.");
      } else {
        toastr.error(
          "Something went wrong while save this data. Please try again."
        );
      }
      $("#warning-msg").html("");
      $("#add_address").html("Update");
      $(".insuf-btn").removeClass("d-none");
      $(".app-btn").removeClass("d-none");
    },
  });
}
