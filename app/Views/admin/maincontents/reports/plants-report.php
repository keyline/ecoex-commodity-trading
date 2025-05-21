<div class="container-fluid">
  <div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
        <li class="breadcrumb-item active"><?= $page_header ?></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
</div>
<section class="section profile">

  <div class="container-fluid">
    <div class="row">
      <!-- alert msg start -->
      <div class="col-xl-12">
        <?php if (session('success_message')) { ?>
          <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
            <?= session('success_message') ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php } ?>
        <?php if (session('error_message')) { ?>
          <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
            <?= session('error_message') ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php } ?>
      </div>
      <!-- alert msg end -->
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body pt-3">
            <!-- serch form start  -->
            <span class="text-danger">Star (*) marks fields are mandatory</span>
            <form method="GET" action="" enctype="multipart/form-data">
              <input type="hidden" name="mode" value="advance_search">
              <div class="row mb-3 align-items-center">
                <!-- company dropdown -->
                <div class="col-md-2 col-lg-4 mb-2">
                  <label for="search_company_id">Company <span class="text-danger">*</span></label>
                  <select name="search_company_id" class="form-control" id="search_company_id" required>
                    <option value="" selected>Select Company</option>
                    <hr>
                    <?php if (!is_null($companies)) {

                      foreach ($companies as $row) { ?>
                        <option value="<?= $row['id'] ?>" <?= (($search_company_id == $row['id']) ? 'selected' : '') ?>><?= $row['company_name'] ?></option>
                        <hr>
                    <?php }
                    } ?>
                  </select>
                </div>

                <!-- week & month dropdown -->
                <div class="col-md-2 col-lg-4 mb-2" id="day_type_row" style="display: <?= (($is_date_range == 1) ? 'none' : 'block') ?>;">
                  <label for="search_day_id">Days</label>
                  <select name="search_day_id" class="form-control" id="search_day_id" required>
                    <option value="this_week" <?= (($search_day_id == 'this_week') ? 'selected' : '') ?>>Weekly</option>
                    <hr>

                    <option value="this_month" <?= (($search_day_id == 'this_month') ? 'selected' : '') ?>>Monthly</option>

                  </select>
                </div>
                <!-- custome date range -->
                <div class="col-md-3 col-lg-3" style="margin-top: 18px;">
                  <label for="is_date_range">Date Range</label>
                  <input type="checkbox" id="is_date_range" name="is_date_range" <?= (($is_date_range == 1) ? 'checked' : '') ?>>
                </div>
                <div class="col-md-3 col-lg-3" id="day_range_row" style="display: <?= (($is_date_range == 1) ? 'block' : 'none') ?>; margin-top: 18px;">
                  <div class="input-group input-daterange">
                    <input type="month" id="search_range_from" name="search_range_from" class="form-control datepicker" value="<?= $search_range_from ?>" style="height: 40px;" onchange="validateDateRange()">
                    <span class="input-group-text">To</span>
                    <input type="month" id="search_range_to" name="search_range_to" class="form-control datepicker" value="<?= $search_range_to ?>" style="height: 40px;" onchange="validateDateRange()">
                  </div>
                </div>
                <!-- custome date range  end -->
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                <?php if (!empty($is_search)) { ?>
                  <a href="<?= base_url('admin/company-report') ?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                <?php } ?>
              </div>
            </form>
            <!-- serch form end  -->

            <!-- report start -->
            <?php if (count($response) && !is_null($response['details_data']) && count($response['details_data'])) { ?>
              <div class="row mt-3">

                <div class="d-flex p-2">
                  <a target="_blank"
                    href="<?= base_url('admin/company-report-export/pdf') . '?' . $_SERVER['QUERY_STRING'] ?>"
                    class="btn btn-primary me-2"
                    title="Download PDF"
                    aria-label="Download PDF">
                    <i class="fa-solid fa-file-pdf fa-lg"></i>
                  </a>
                  <a target="_blank"
                    href="<?= base_url('admin/company-report-export/excel') . '?' . $_SERVER['QUERY_STRING'] ?>"
                    class="btn btn-success"
                    title="Download Excel"
                    aria-label="Download Excel">
                    <i class="fa-solid fa-file-excel fa-lg"></i>
                  </a>
                </div>



                <div class="col-lg-12 col-md-12">

                  <div class="card">

                    <div class="card-body">
                      <h5 class="card-title"><?= $response['graph_title'] ?? 'Report' ?></h5>

                      <div class="table-responsive">
                        <table id="" class="table globel_table nowrap" style="width: 100%">
                          <thead>
                            <tr>
                              <th>Sr. No.</th>
                              <th>Enquiry No.</th>
                              <th>Plant Name</th>
                              <th>Invoice Date</th>
                              <th>Invoice No.</th>
                              <th>Sub Enquiry No.</th>
                              <th>Vendor</th>
                              <th>Vendor Invoice Date</th>
                              <th>Vendor Invoice No</th>
                              <th>Item</th>
                              <th>Weight</th>
                              <th>Unit</th>
                              <th>Vehicle No.</th>
                            </tr>
                          </thead>
                          <!--use ul li-->
                          <!-- <tbody>
                            <?php $sr = 1; ?>
                            <?php foreach ($response['details_data'] as $enq): ?>
                              <tr>
                                <td><?= $sr++ ?></td>
                                <td><?= esc($enq['enquiry_no']) ?></td>
                                <td><?= esc($enq['plant_name']) ?></td>
                                <td><?= date('d-m-Y', strtotime($enq['invoice_date'])) ?></td>
                                <td><?= esc($enq['invoice_number']) ?></td>
                                <td><?= esc($enq['sub_enquiry_no']) ?></td>
                                <td><?= esc($enq['vendor_name']) ?></td>

                             
                                <td>
                                  <ul style="margin:0; padding-left:1em; list-style:disc;">
                                    <?php foreach ($enq['invoices'] as $inv): ?>
                                      <li><?= date('d-m-Y', strtotime($inv['date'])) ?></li>
                                    <?php endforeach; ?>
                                  </ul>
                                </td>

                             
                                <td>
                                  <ul style="margin:0; padding-left:1em; list-style:disc;">
                                    <?php foreach ($enq['invoices'] as $inv): ?>
                                      <li><?= esc($inv['number']) ?></li>
                                    <?php endforeach; ?>
                                  </ul>
                                </td>

                             
                                <td>
                                  <ul style="margin:0; padding-left:1em; list-style:disc;">
                                    <?php foreach ($enq['items'] as $item): ?>
                                      <li><?= esc($item['item_name']) ?></li>
                                    <?php endforeach; ?>
                                  </ul>
                                </td>

                               
                                <td>
                                  <ul style="margin:0; padding-left:1em; list-style:disc;">
                                    <?php foreach ($enq['items'] as $item): ?>
                                      <li><?= esc($item['weighted_qty']) ?></li>
                                    <?php endforeach; ?>
                                  </ul>
                                </td>

                              
                                <td>
                                  <ul style="margin:0; padding-left:1em; list-style:disc;">
                                    <?php foreach ($enq['items'] as $item): ?>
                                      <li><?= esc($item['weighted_unit']) ?></li>
                                    <?php endforeach; ?>
                                  </ul>
                                </td>

                                
                                <td>
                                  <ul style="margin:0; padding-left:1em; list-style:disc;">
                                    <?php foreach ($enq['vehicles'] as $veh): ?>
                                      <li><?= esc($veh) ?></li>
                                    <?php endforeach; ?>
                                  </ul>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody> -->

                          <tbody>

                            <?php $sr = 1;
                            foreach ($response['details_data'] as $enq): ?>
                              <?php
                              // how many rows needed for this group
                              $rowCount = max(1, count($enq['items']));
                              // format main invoice date
                              $mainInvDate = date('d-m-Y', strtotime($enq['invoice_date']));
                              // combine all vendor-invoice dates/nos into HTML line breaks
                              $vendorDates = array_map(function ($inv) {
                                return date('d-m-Y', strtotime($inv['date']));
                              }, $enq['invoices']);
                              $vendorNums  = array_map(function ($inv) {
                                return esc($inv['number']);
                              }, $enq['invoices']);
                              $vendorDatesHtml = implode('<br>', $vendorDates);
                              $vendorNumsHtml  = implode('<br>', $vendorNums);
                              // vehicles
                              $vehicles = implode('<br>', array_map('esc', $enq['vehicles']));
                              ?>
                              <?php foreach ($enq['items'] as $idx => $item): ?>
                                <tr>
                                  <?php if ($idx === 0): ?>
                                    <td rowspan="<?= $rowCount ?>"><?= $sr++ ?></td>
                                    <td rowspan="<?= $rowCount ?>"><?= esc($enq['enquiry_no']) ?></td>
                                    <td rowspan="<?= $rowCount ?>"><?= esc($enq['plant_name']) ?></td>
                                    <td rowspan="<?= $rowCount ?>"><?= $mainInvDate ?></td>
                                    <td rowspan="<?= $rowCount ?>"><?= esc($enq['invoice_number']) ?></td>
                                    <td rowspan="<?= $rowCount ?>"><?= esc($enq['sub_enquiry_no']) ?></td>
                                    <td rowspan="<?= $rowCount ?>"><?= esc($enq['vendor_name']) ?></td>
                                    <td rowspan="<?= $rowCount ?>"><?= $vendorDatesHtml ?></td>
                                    <td rowspan="<?= $rowCount ?>"><?= $vendorNumsHtml ?></td>
                                  <?php endif; ?>

                                  <!-- item columns -->
                                  <td><?= esc($item['item_name']) ?></td>
                                  <td><?= esc($item['weighted_qty']) ?></td>
                                  <td><?= esc($item['weighted_unit']) ?></td>

                                  <?php if ($idx === 0): ?>
                                    <td rowspan="<?= $rowCount ?>"><?= $vehicles ?></td>
                                  <?php endif; ?>
                                </tr>
                              <?php endforeach; ?>
                            <?php endforeach; ?>
                          </tbody>

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } else { ?>
              <div class="text-center text-danger m-5">
                <p>Records Not found </p>
              </div>
            <?php } ?>
            <!-- report end -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
  $("#is_date_range").click(function() {
    if ($(this).is(":checked")) {
      $("#day_range_row").show();
      $("#day_type_row").hide();
    } else {
      $("#day_range_row").hide();
      $("#day_type_row").show();
    }
  });

  function validateDateRange() {
    const fromDate = document.getElementById("search_range_from").value;
    const toDate = document.getElementById("search_range_to").value;


    if (fromDate && toDate) {
      // Parse the dates from the DD-MM-YYYY format
      const [fromDay, fromMonth, fromYear] = fromDate.split('-').map(Number);
      const [toDay, toMonth, toYear] = toDate.split('-').map(Number);
      // Create Date objects for comparison
      const fromDateObj = new Date(fromYear, fromMonth - 1, fromDay); // Month is 0-indexed
      const toDateObj = new Date(toYear, toMonth - 1, toDay);
      // Compare the dates
      if (fromDateObj > toDateObj) {
        document.getElementById("search_range_to").value = "";
        toastAlert('error', 'From date cannot be greater than the To date.');
      }
    }
  }
</script>