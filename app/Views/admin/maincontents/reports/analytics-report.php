<?php
$user_type          = session('user_type');
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="container-fluid">
  <div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
        <li class="breadcrumb-item active"><?=$page_header?></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
</div>
<section class="section profile">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12">
        <?php if (session('success_message')) {?>
          <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
            <?=session('success_message')?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php }?>
        <?php if (session('error_message')) {?>
          <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
            <?=session('error_message')?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php }?>
      </div>
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body pt-3">
            <span class="text-danger">Star (*) marks fields are mandatory</span>
            <form method="GET" action="" enctype="multipart/form-data">
              <input type="hidden" name="mode" value="advance_search">
              <div class="row mb-3 align-items-center">
                  <div class="col-md-2 col-lg-4 mb-2">
                    <label for="search_user_type">User Type<span class="text-danger">*</span></label>
                    <select name="search_user_type" class="form-control" id="search_user_type" required>
                        <option value="" selected>Select User</option>
                        <hr>
                        <option value="all" <?=(($search_user_type == 'all') ? 'selected' : '')?>>All</option>
                        <hr>
                        <option value="commodity_manager_vp" <?=(($search_user_type == 'commodity_manager_vp') ? 'selected' : '')?>>Commodity Manager VP</option>
                        <hr>
                        <option value="industrial_commodity_user" <?=(($search_user_type == 'industrial_commodity_user') ? 'selected' : '')?>>Commodity User</option>
                        <hr>
                    </select>
                  </div>
                  <div class="col-md-2 col-lg-4 mb-2">
                    <label for="search_company_id">Company <span class="text-danger">*</span></label>
                    <select name="search_company_id" class="form-control" id="search_company_id" required>
                        <option value="" selected>Select Company</option>
                        <hr>
                        
                    </select>
                  </div>
                  <div class="col-md-2 col-lg-4 mb-2">
                    <label for="search_unit_id">Unit <span class="text-danger">*</span></label>
                    <select name="search_unit_id" class="form-control" id="search_unit_id" required>
                        <option value="" selected>Select Unit</option>
                        <hr>
                        <?php if ($units) {
                            foreach ($units as $row) {?>
                            <option value="<?=$row->name?>" <?=(($search_unit_id == $row->name) ? 'selected' : '')?>><?=$row->name?></option>
                            <hr>
                        <?php }
                            }?>
                    </select>
                  </div>
                  <div class="col-md-2 col-lg-4 mb-2">
                    <label for="search_product_id">Item</label>
                    <select name="search_product_id" class="form-control" id="search_product_id">
                        
                    </select>
                  </div>
                  <div class="col-md-2 col-lg-4 mb-2" id="day_type_row" style="display: <?=(($is_date_range == 1) ? 'none' : 'block')?>;">
                      <label for="search_day_id">Days</label>
                      <select name="search_day_id" class="form-control" id="search_day_id" required>
                          <!-- <option value="all" <?=(($search_day_id == 'all') ? 'selected' : '')?>>All</option> -->
                          <hr>
                          <option value="today" <?=(($search_day_id == 'today') ? 'selected' : '')?>>Today</option>
                          <hr>
                          <option value="yesterday" <?=(($search_day_id == 'yesterday') ? 'selected' : '')?>>Yesterday</option>
                          <hr>
                          <option value="this_week" <?=(($search_day_id == 'this_week') ? 'selected' : '')?>>This Week</option>
                          <hr>
                          <option value="last_week" <?=(($search_day_id == 'last_week') ? 'selected' : '')?>>Last Week</option>
                          <hr>
                          <option value="this_month" <?=(($search_day_id == 'this_month') ? 'selected' : '')?>>This Month</option>
                          <hr>
                          <option value="last_month" <?=(($search_day_id == 'last_month') ? 'selected' : '')?>>Last Month</option>
                          <hr>
                          <option value="last_six_month" <?=(($search_day_id == 'last_six_month') ? 'selected' : '')?>>Last Six Months</option>
                          <hr>
                          <option value="this_fy_year" <?=(($search_day_id == 'this_fy_year') ? 'selected' : '')?>>This Fy. Year</option>
                          <hr>
                          <!-- <option value="last_7_days" <?=(($search_day_id == 'last_7_days') ? 'selected' : '')?>>Last 7 Days</option>
                          <hr>
                          <option value="last_30_days" <?=(($search_day_id == 'last_30_days') ? 'selected' : '')?>>Last 30 Days</option>
                          <hr> -->
                      </select>
                  </div>
                  <div class="col-md-3 col-lg-3" style="margin-top: 18px;">
                      <label for="is_date_range">Date Range</label>
                      <input type="checkbox" id="is_date_range" name="is_date_range" <?=(($is_date_range == 1) ? 'checked' : '')?>>
                  </div>
                  <div class="col-md-3 col-lg-3" id="day_range_row" style="display: <?=(($is_date_range == 1) ? 'block' : 'none')?>; margin-top: 18px;">
                      <div class="input-group input-daterange">
                          <input type="date" id="search_range_from" name="search_range_from" class="form-control" value="<?=$search_range_from?>" max="<?=date('Y-m-d')?>" style="height: 40px;">
                          <span class="input-group-text">To</span>
                          <input type="date" id="search_range_to" name="search_range_to" class="form-control" value="<?=$search_range_to?>" max="<?=date('Y-m-d')?>" style="height: 40px;">
                      </div>
                  </div>
                  
              </div>
              <div class="text-center">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                  <?php if (!empty($is_search)) {?>
                      <a href="<?=base_url('admin/reports/analytics-report')?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                  <?php }?>
              </div>
            </form>
            <?php
            if ($response) {
                $month_year_name  = array_column($response['records'], 'month_year_name');
                $scrap_qty        = array_column($response['records'], 'scrap_qty');
                $no_of_plant      = array_column($response['records'], 'no_of_plant');
                $vehicle_count    = array_column($response['records'], 'vehicle_count');
                $details_data     = $response['details_data'];
                ?>
              <div class="row mt-3">
                <div class="col-lg-12 col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><?=$response['graph_title']?> 
                        <small class="text-danger" style="font-size: 12px;color: red !important;">( In graph scrap qty show in <?=$search_unit_id?> )</small>
                      </h5>
  
                      <!-- Column Chart -->
                      <div id="columnChart1"></div>
  
                      <script>
                        var convertedUnit = '<?=$convertedUnit?>';
                        document.addEventListener("DOMContentLoaded", () => {
                          new ApexCharts(document.querySelector("#columnChart1"), {
                            series: [{
                              name: 'Scrap Qty',
                              data: [<?=implode(', ', $scrap_qty);?>]
                            }, {
                              name: 'Number Of Plant',
                              data: [<?=implode(', ', $no_of_plant);?>]
                            }, {
                              name: 'Vehicle Count',
                              data: [<?=implode(', ', $vehicle_count);?>]
                            }],
                            chart: {
                              type: 'bar',
                              height: 550
                            },
                            plotOptions: {
                              bar: {
                                horizontal: false,
                                columnWidth: '75%',
                                endingShape: 'rounded'
                              },
                            },
                            colors: [ // this array contains different color code for each data
                              "#13d8aa",
                              "#f48024",
                              "#A5978B"
                            ],
                            dataLabels: {
                              enabled: true
                            },
                            stroke: {
                              show: true,
                              width: 2,
                              colors: ['transparent']
                            },
                            xaxis: {
                              categories: [<?=implode(", ", $month_year_name);?>],
                            },
                            yaxis: {
                              title: {
                                text: 'Number'
                              }
                            },
                            fill: {
                              opacity: 1
                            },
                            tooltip: {
                              y: {
                                formatter: function(val) {
                                  // return "$ " + val + " thousands"
                                  // return val + " " + convertedUnit
                                  return val
                                }
                              }
                            }
                          }).render();
                        });
                      </script>
                      <!-- End Column Chart -->
  
                    </div>
                  </div>
                </div>
              </div>
              <?php if ($details_data) { ?>
                <div class="row mt-3">
                  <div class="col-lg-12 col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Details Data</h5>
                        <div class="table-responsive">
                          <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Enquiry No.</th>
                                <th>Sub Enquiry No.</th>
                                <th>Item Name</th>
                                <th>Weighted Qty</th>
                                <th>Weighted Unit</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $sl_no = 1;
                  $tot_weight_qty = 0;
                  foreach ($details_data as $details) {?>
                                <tr>
                                  <td><?=$sl_no++?></td>
                                  <td><a href="<?=base_url('admin/enquiry-requests/enquiry-details/'.encoded($details['enq_id']))?>" target="_blank"><?=$details['enquiry_no']?></a></td>
                                  <td><?=$details['sub_enquiry_no']?></td>
                                  <td><?=$details['item_name']?></td>
                                  <td><?=$details['weighted_qty']?></td>
                                  <td><?=$details['weighted_unit']?></td>
                                </tr>
                              <?php $tot_weight_qty += $details['weighted_qty'];
                  } ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="4" style="text-align: right; font-size: 13px;">Total</th>
                                <th><?=number_format($tot_weight_qty, 3)?></th>
                                <!-- <th><?=$convertedUnit?></th> -->
                                <th style="font-size: 12px;">KG</th>
                              </tr>
                              <tr>
                                <th colspan="4" style="text-align: right; font-size: 13px;">Total</th>
                                <th><?=number_format(($tot_weight_qty / 1000), 3)?></th>
                                <!-- <th><?=$convertedUnit?></th> -->
                                <th style="font-size: 12px;">MT</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
  $("#is_date_range").click(function() {
    if($(this).is(":checked")) {
        $("#day_range_row").show();
        $("#day_type_row").hide();
    } else {
        $("#day_range_row").hide();
        $("#day_type_row").show();
    }
  });
  $(function(){

    var base_url          = '<?=base_url()?>';
    var search_company_id = '<?=$search_company_id?>';
    var search_product_id = parseInt('<?=$search_product_id?>');
    $.ajax({
        type: "POST",
        url: base_url + "admin/reports/get-company-product",
        data: {company_id : search_company_id},
        dataType: "JSON",
        beforeSend: function () {
          
        },
        success: function (rply) {
          $("#search_product_id").empty();
          if(rply.success){
            selected = '';
            if(search_product_id == 'all'){
              selected = 'selected';
            }
            let html = '<option value="all" ' + selected + '>All</option><hr>';
            $.each(rply.data, function(key, item) {
              if(parseInt(search_product_id) == item.id){
                selected = 'selected';
              } else {
                selected = '';
              }
              html += '<option value="' + item.id + '"' + selected + '>' + item.name + ' (' + item.unit + ')</option><hr>';
            });
            $("#search_product_id").html(html);
          }else{
            
          }
        }
    });

    $('#search_company_id').on('change', function(){
      var base_url          = '<?=base_url()?>';
      var search_company_id = $('#search_company_id').val();
      $.ajax({
          type: "POST",
          url: base_url + "admin/reports/get-company-product",
          data: {company_id : search_company_id},
          dataType: "JSON",
          beforeSend: function () {
            
          },
          success: function (rply) {
            $("#search_product_id").empty();
            if(rply.success){
                let html = '<option value="all" selected>All</option><hr>';
                $.each(rply.data, function(key, item) {
                  html += '<option value="' + item.id + '">' + item.name + ' (' + item.unit + ')</option><hr>';
                });
                $("#search_product_id").html(html);
            }else{
              
            }
          }
      });
    });
  })
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  debugger;
  const fromInput = document.getElementById('search_range_from');
  const toInput   = document.getElementById('search_range_to');

  function validateDates() {
  debugger;
    const from = new Date(fromInput.value);
    const to   = new Date(toInput.value);
    const today = new Date();

    // Reset any previous styles
    fromInput.classList.remove('is-invalid');
    toInput.classList.remove('is-invalid');

    if (!fromInput.value || !toInput.value) return; // wait until both selected

    if (from > to) {
      alert("❌ 'From' date cannot be later than 'To' date.");
      fromInput.classList.add('is-invalid');
      toInput.classList.add('is-invalid');
      return false;
    }

    if (to > today) {
      alert("❌ 'To' date cannot be in the future.");
      toInput.classList.add('is-invalid');
      return false;
    }

    return true;
  }

  fromInput.addEventListener('change', validateDates);
  toInput.addEventListener('change', validateDates);

  
});
</script>
<script>
$(document).ready(function() {
  const preselectedUserType = '<?= $search_user_type ?? '' ?>';
  const preselectedCompany  = '<?= $search_company_id ?? '' ?>';

  function loadCompanies(userType, selectedCompany = '') {
    if (!userType) return;

    $.ajax({
      url: '<?= base_url('admin/getCompaniesByUserType') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        user_type: userType,
        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
      },
      success: function(response) {
        const dropdown = $('#search_company_id');
        dropdown.empty().append('<option value="">-- Select Company --</option>');

        if (response.status === 'success' && response.data.length > 0) {
          response.data.forEach(function(c) {
            const selected = (selectedCompany == c.id) ? 'selected' : '';
            dropdown.append(`<option value="${c.id}" ${selected}>${c.company_name}</option>`);
          });
        } else {
          dropdown.append('<option value="">No companies found</option>');
        }
      },
      error: function() {
        $('#company_id').html('<option value="">Error loading companies</option>');
      }
    });
  }

  // 1️⃣ Trigger AJAX on user_type change
  $('#search_user_type').on('change', function() {
    loadCompanies($(this).val());
  });

  // 2️⃣ Trigger AJAX automatically if user_type was already selected before reload
  if (preselectedUserType) {
    loadCompanies(preselectedUserType, preselectedCompany);
  }

  
});
</script>