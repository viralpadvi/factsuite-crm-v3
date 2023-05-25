<div class="row mb-3">
  <div class="col-md-1">
    <select class="filter-number-dropdown" id="filter-cases-number">
      <?php foreach (json_decode($filter_numbers) as $key => $value) {
        echo '<option value="'.$value.'">'.$value.'</option>';
      } ?>
    </select>
  </div>
  <div class="col-md-11">
    <div class="row">
      <div class="col-md-3"></div>
      <!-- <div class="col-md-5 custom-search-input-div">
        
      </div> -->
       <!-- custom-search-btns-div -->
      <div class="col-md-9 text-right">
        <div class="search-field d-inline-block w-50 pr-2">
          <input type="text" class="form-control" name="search-key" id="search-key" placeholder="Search Here..." />
        </div>
        <div class="search-button d-inline-block">
          <button type="button" id="search-filter-btn" class="btn custom-btn-1">Search</button>
          <button type="button" id="clear-filter-search-btn" class="btn btn-transperant ml-3">Clear</button>
        </div>
      </div>
    </div>
  </div>
</div>