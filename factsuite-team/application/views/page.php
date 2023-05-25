<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div id="FS-candidate-mn" class="add-team">
         
      </div>
    </div>
  </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
     
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt">
          

          <div class="row">
    <div class="col-md-12">
      <h1><?php echo $title ?></h1>
    </div>
    <div class="col-md-1">
      <select class="w-100" id="filter-cases-number">
        <?php foreach (json_decode($filter_numbers) as $key => $value) {
          echo '<option value="'.$value.'">'.$value.'</option>';
        } ?>
      </select>
    </div>
    <div class="col-md-11">
      <div class="row ">
        <div class="col-md-10 custom-search-input-div">
          <div class="search-field">
            <input type="text" class="form-control" name="search_key" id="search_key" placeholder="Search by product name" />
          </div>
        </div>
        <div class="col-md-2 custom-search-btns-div">
          <div class="search-button">
            <button type="button" id="searchBtn" class="btn btn-info">Search</button>
            <button type="button" id="resetBtn" class="btn btn-warning">Clear</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-md-12">
      <div id="ajaxContent"></div>
    </div>
  </div>


     </div>
  </div>
 

</section>
<!--Content-->


<script>
  
  $(function() {
    
    /*--first time load--*/
    ajaxlist(page_url=false);
    
    /*-- Search keyword--*/
    $(document).on('click', "#searchBtn", function(event) {
      ajaxlist(page_url=false);
      event.preventDefault();
    });
    
    /*-- Reset Search--*/
    $(document).on('click', "#resetBtn", function(event) {
      $("#search_key").val('');
      ajaxlist(page_url=false);
      event.preventDefault();
    });
    
    /*-- Page click --*/
    $(document).on('click', ".pagination li a", function(event) {
      var page_url = $(this).attr('href');
      ajaxlist(page_url);
      event.preventDefault();
    });

    $('#filter-cases-number').on('change', function(event) {
      ajaxlist();
      event.preventDefault();
    })
    
    /*-- create function ajaxlist --*/
    function ajaxlist(page_url = false)
    {
      var search_key = $("#search_key").val(),
          filter_cases_number = $('#filter-cases-number').val(),  
          dataString = 'search_key=' + search_key;
      // var base_url = '<?php echo site_url('client/index_ajax/') ?>';
      
      if(page_url == false) {
        var page_url = base_url+'client/index_ajax/';
      }
      
      $.ajax({
        type: "POST",
        url: page_url,
        data: {
          search_key : search_key,
          filter_cases_number : filter_cases_number
        },
        success: function(response) {
          console.log(response);
          $("#ajaxContent").html(response);
        }
      });
    }
  });
  </script>