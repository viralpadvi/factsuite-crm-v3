$(function() {
  /*--first time load--*/
  get_required_list(page_url=false);
  
  /*-- Search keyword--*/
  $(document).on('click', "#search-filter-btn", function(event) {
    get_required_list(page_url=false);
    event.preventDefault();
  });
  
  /*-- Reset Search--*/
  $(document).on('click', "#clear-filter-search-btn", function(event) {
    $("#search-key").val('');
    get_required_list(page_url=false);
    event.preventDefault();
  });
  
  /*-- Page click --*/
  $(document).on('click', ".pagination li a", function(event) {
    var page_url = $(this).attr('href');
    get_required_list(page_url);
    event.preventDefault();
  });

  $('#filter-cases-number').on('change', function(event) {
    get_required_list();
    event.preventDefault();
  });

  $('#search-key').on('keypress', function(event) {
    var key = event.which;
    if (key == 13) {
      get_required_list();
      event.preventDefault();
    }
  });
  
  /*-- create function ajaxlist --*/
  // function get_required_list(page_url = false) {
  //   $(display_ui_id).html((typeof html !== 'undefined' && html !== 'undefined') ? html : '');
  //   var search_key = $("#search-key").val(),
  //       filter_cases_number = $('#filter-cases-number').val();

  //   if(page_url == false) {
  //     var page_url = base_url+site_url;
  //   }
    
  //   $.ajax({
  //     type: "POST",
  //     url: page_url,
  //     data: {
  //       search_key : search_key,
  //       filter_cases_number : filter_cases_number,
  //       site_url : site_url,
  //       verify_client_request : 1
  //     },
  //     success: function(response) {
  //       $(display_ui_id).html(response);
  //     }
  //   });
  // }
});