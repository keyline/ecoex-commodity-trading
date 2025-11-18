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
                <!-- custome date range -->                
                <div class="col-md-3 col-lg-3" id="day_range_row">
                  <div class="input-group input-daterange">
                    <input type="date" id="search_range_from" name="search_range_from" class="form-control" value="<?= $search_range_from ?>" style="height: 40px;" onchange="validateDateRange()">
                    <span class="input-group-text">To</span>
                    <input type="date" id="search_range_to" name="search_range_to" class="form-control" value="<?= $search_range_to?>" style="height: 40px;" onchange="validateDateRange()">
                  </div>
                </div>
                <!-- custome date range  end -->
                <div class="col-md-3 col-lg-3">
                  <select id="filterUser" name="user_name" class="form-control">
                  <option value="">Filter by User Name</option>
                  <option value="all user">All Users</option>
                  <?php foreach ($users as $user) {
                      if($userType == 'MA') { ?>
                  <option value="<?=$user->id?>"<?= ($search_user == $user->id) ? 'selected' : '' ?>  ><?=$user->name?></option>
                  <?php }  elseif($userType == 'U') {?>
                      <option value="<?=$user->id?>" <?= ($search_user == $user->id) ? 'selected' : '' ?> ><?=$user->name?></option>
                  <?php } } ?>
                  <!-- add more -->
                  </select>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                <?php if (!empty($is_search)) { ?>
                  <a href="<?= base_url('admin/enquiry-report') ?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                <?php } ?>
              </div>
            </form>
            <!-- serch form end  -->

            <!-- report start -->
            <?php if (count($response) && !is_null($response['details_data']) && count($response['details_data'])) { ?>
              <div class="row mt-3">

                <div class="d-flex p-2">
                  <a target="_blank" href="<?= base_url('admin/enquiry-report-export/pdf') . '?' . $_SERVER['QUERY_STRING'] ?>" class="btn btn-primary me-2"
                    title="Download PDF"
                    aria-label="Download PDF">
                    <i class="fa-solid fa-file-pdf fa-lg"></i>
                  </a>
                  <a target="_blank"
                    href="<?= base_url('admin/enquiry-report-export/excel') . '?' . $_SERVER['QUERY_STRING'] ?>"
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
                              <th>Company Name</th>
                              <th>Plant Name</th>    
                              <th>Assigned user</th>                              
                              <th>Vehicle No.</th>
                              <th>Material Lifted</th>
                              <th>Quantity</th>                                                           
                              <th>Vendor</th>                                                                          
                            </tr>
                          </thead>                          
                          <tbody>
                            <?php 
                            $sr = 1;
                            foreach ($response['details_data'] as $data): 
                            ?>
                            <tr>
                                <td><?= $sr++; ?></td>

                                <td><?= esc($data['enquiry_no']); ?></td>
                                <td><?= esc($data['company_names']); ?></td>
                                <td><?= esc($data['plant_names']); ?></td>

                                <!-- These fields are already merged with <br> in controller -->
                                <td><?= $data['assigned_users'] ?: '-'; ?></td>
                                <td><?= $data['vehicle_registration_nos'] ?: '-'; ?></td>
                                <td><?= $data['item_names'] ?: '-'; ?></td>
                                <td><?= $data['weighted_qtys'] ?: '-'; ?></td>
                                <td><?= $data['vendor_names'] ?: '-'; ?></td>
                            </tr>
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

  function validateDateRange() {
    const fromDate = document.getElementById("search_range_from").value;
    const toDate = document.getElementById("search_range_to").value;


    if (fromDate && toDate) {
      // For input type="date", the value is in yyyy-mm-dd format
      const fromDateObj = new Date(fromDate);
      const toDateObj = new Date(toDate);

      if (fromDateObj > toDateObj) {
        document.getElementById("search_range_to").value = "";
        toastAlert('error', 'From date cannot be greater than the To date.');
      }
    }
  }
</script>