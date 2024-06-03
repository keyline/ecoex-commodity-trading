<?php
$user_type          = session('user_type');
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="pagetitle">
  <h1><?=$page_header?></h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
      <li class="breadcrumb-item active"><?=$page_header?></li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<section class="section profile">
  <div class="row">
    <div class="col-xl-12">
      <?php if(session('success_message')){?>
        <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
          <?=session('success_message')?>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php }?>
      <?php if(session('error_message')){?>
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
          <?=session('error_message')?>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php }?>
    </div>
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body pt-3">
          <form method="GET" action="" enctype="multipart/form-data">
            <input type="hidden" name="mode" value="advance_search">
            <div class="row mb-3 align-items-center">
                <div class="col-md-3 col-lg-3">
                  <label for="search_company_id">Company</label>
                  <select name="search_company_id" class="form-control" id="search_company_id" required>
                      <option value="" selected>Select Company</option>
                      <hr>
                      <?php if($companies){ foreach($companies as $row){?>
                          <option value="<?=$row->id?>" <?=(($search_company_id == $row->id)?'selected':'')?>><?=$row->company_name?></option>
                          <hr>
                      <?php } }?>
                  </select>
                </div>
                <div class="col-md-3 col-lg-3" id="day_type_row" style="display: <?=(($is_date_range == 1)?'none':'block')?>;">
                    <label for="search_day_id">Days</label>
                    <select name="search_day_id" class="form-control" id="search_day_id" required>
                        <!-- <option value="all" <?=(($search_day_id == 'all')?'selected':'')?>>All</option>
                        <hr>
                        <option value="today" <?=(($search_day_id == 'today')?'selected':'')?>>Today</option>
                        <hr>
                        <option value="yesterday" <?=(($search_day_id == 'yesterday')?'selected':'')?>>Yesterday</option>
                        <hr>
                        <option value="this_week" <?=(($search_day_id == 'this_week')?'selected':'')?>>This Week</option>
                        <hr>
                        <option value="last_week" <?=(($search_day_id == 'last_week')?'selected':'')?>>Last Week</option>
                        <hr> -->
                        <option value="this_month" <?=(($search_day_id == 'this_month')?'selected':'')?>>This Month</option>
                        <hr>
                        <option value="last_month" <?=(($search_day_id == 'last_month')?'selected':'')?>>Last Month</option>
                        <hr>
                        <!-- <option value="last_7_days" <?=(($search_day_id == 'last_7_days')?'selected':'')?>>Last 7 Days</option>
                        <hr>
                        <option value="last_30_days" <?=(($search_day_id == 'last_30_days')?'selected':'')?>>Last 30 Days</option>
                        <hr> -->
                    </select>
                </div>
                <div class="col-md-2 col-lg-2" style="margin-top: 18px;">
                    <label for="is_date_range">Date Range</label>
                    <input type="checkbox" id="is_date_range" name="is_date_range" <?=(($is_date_range == 1)?'checked':'')?>>
                </div>
                <div class="col-md-4 col-lg-4" id="day_range_row" style="display: <?=(($is_date_range == 1)?'block':'none')?>; margin-top: 18px;">
                    <div class="input-group input-daterange">
                        <label for="search_range_from">Custom Month Range</label>
                        <input type="month" id="search_range_from" name="search_range_from" class="form-control" value="<?=$search_range_from?>" max="<?=date('Y-m')?>" style="height: 40px;">
                        <span class="input-group-text">To</span>
                        <input type="month" id="search_range_to" name="search_range_to" class="form-control" value="<?=$search_range_to?>" max="<?=date('Y-m')?>" style="height: 40px;">
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                <?php if(!empty($response)){?>
                    <a href="<?=base_url('admin/reports/advance-search')?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                <?php }?>
            </div>
          </form>

          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Column Chart</h5>

                  <!-- Column Chart -->
                  <div id="columnChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#columnChart"), {
                        series: [{
                          name: 'Scrap Qty',
                          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                        }, {
                          name: 'Number Of Plant',
                          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                        }, {
                          name: 'Vehicle Count',
                          data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                        }],
                        chart: {
                          type: 'bar',
                          height: 350
                        },
                        plotOptions: {
                          bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                          },
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          show: true,
                          width: 2,
                          colors: ['transparent']
                        },
                        xaxis: {
                          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
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
                              return "$ " + val + " thousands"
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
</script>