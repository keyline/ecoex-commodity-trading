<?php
$userType           = $session->user_type;
?>
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">
                <?php if($userType == 'MA'){?>
                    <!-- Companies Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <!-- <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> -->
                            <div class="card-body">
                                <h5 class="card-title">Companies <span>| All Time</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?=$company?></h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Companies Card -->
                <?php }?>
                <!-- Plants Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <!-- <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div> -->
                        <div class="card-body">
                            <h5 class="card-title">Plants <span>| All Time</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?=$plant?></h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Plants Card -->
                <?php if($userType == 'MA'){?>
                    <!-- Vendors Card -->
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <!-- <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> -->
                            <div class="card-body">
                                <h5 class="card-title">Vendors <span>| All Time</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?=$vendor?></h6>
                                        <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Vendors Card -->
                <?php }?>
                
                <!-- Enquires Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <!-- <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div> -->
                        <div class="card-body">
                            <h5 class="card-title">Enquires <span>| All Time</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?=$enquiry?></h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- End Enquires Card -->
                <!-- Pending Items Card -->
                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <!-- <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div> -->
                        <div class="card-body">
                            <h5 class="card-title">Pending Items <span>| All Time</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?=$pendingItem?></h6>
                                    <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Pending Items Card -->
                <?php if($userType == 'MA'){?>
                    <!-- Item Categories Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <!-- <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> -->
                            <div class="card-body">
                                <h5 class="card-title">Item Categories <span>| All Time</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?=$itemCategory?></h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Item Categories Card -->
                <?php }?>

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <!-- <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div> -->
                        <div class="card-body">
                            <h5 class="card-title">Recent Enquires <span>| All Time</span></h5>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Plant</th>
                                        <th scope="col">Items</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($recent_enquiries){ foreach($recent_enquiries as $recent_enquiry){
                                        $getCompany                 = $common_model->find_data('ecoex_companies', 'row', ['id' => $recent_enquiry->company_id], 'company_name');
                                        $getPlant                   = $common_model->find_data('ecomm_users', 'row', ['id' => $recent_enquiry->plant_id], 'plant_name');
                                    ?>
                                        <tr>
                                            <th scope="row"><a href="<?=base_url('admin/enquiry-requests/view-detail/'.encoded($recent_enquiry->id))?>">#<?=$recent_enquiry->enquiry_no?></a></th>
                                            <td><?=(($getCompany)?$getCompany->company_name:'')?></td>
                                            <td><?=(($getPlant)?$getPlant->plant_name:'')?></td>
                                            <td>
                                                <ul>
                                                    <?php
                                                    $getEnquiryItems            = $common_model->find_data('ecomm_enquiry_products', 'array', ['enq_id' => $recent_enquiry->id]);
                                                    if($getEnquiryItems){ $sl=1; foreach($getEnquiryItems as $getEnquiryItem){
                                                        $getItem                = $common_model->find_data('ecomm_company_items', 'row', ['id' => $getEnquiryItem->product_id], 'alias_name');
                                                    ?>
                                                    <li><?=(($getItem)?$getItem->alias_name:$getEnquiryItem->new_product_name)?></li>
                                                    <?php } }?>
                                                </ul>
                                            </td>
                                            <td>
                                                <?php
                                                if($recent_enquiry->status == 0){
                                                    $enquiryStatus  = 'Request Submitted';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 1){
                                                    $enquiryStatus  = 'Accept Request';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 2){
                                                    $enquiryStatus  = 'Vendor Allocated';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 3){
                                                    $enquiryStatus  = 'Vendor Assigned';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 4){
                                                    $enquiryStatus  = 'Pickup Scheduled';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 5){
                                                    $enquiryStatus  = 'Vehicle Placed';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 6){
                                                    $enquiryStatus  = 'Material Weighed';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 7){
                                                    $enquiryStatus  = 'Invoice from HO';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 8){
                                                    $enquiryStatus  = 'Invoice to Vendor';
                                                    $bgcolor        =   '#4154f1';
                                                } elseif($recent_enquiry->status == 9){
                                                    $enquiryStatus  = 'Payment received from Vendor';
                                                    $bgcolor        =   '#ff0000';
                                                } elseif($recent_enquiry->status == 10){
                                                    $enquiryStatus  = 'Vehicle Dispatched';
                                                    $bgcolor        =   '#ff0000';
                                                } elseif($recent_enquiry->status == 11){
                                                    $enquiryStatus  = 'Payment to HO';
                                                    $bgcolor        =   '#ff0000';
                                                } elseif($recent_enquiry->status == 12){
                                                    $enquiryStatus  = 'Order Complete';
                                                    $bgcolor        =   '#ff0000';
                                                } elseif($recent_enquiry->status == 13){
                                                    $enquiryStatus  = 'Reject Request';
                                                    $bgcolor        =   '#ff0000';
                                                } 
                                                ?>
                                                <span class="badge" style="background-color: <?=$bgcolor?>; color: #FFF;"><?=$enquiryStatus?></span>
                                            </td>
                                        </tr>
                                    <?php } }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Recent Sales -->
            </div>
        </div>
        <!-- End Left side columns -->
        <!-- Right side columns -->
        <div class="col-lg-4">
            <!-- Website Traffic -->
            <div class="card">
                <!-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div> -->
                <div class="card-body pb-0">
                    <h5 class="card-title">Enquiry Requests <span>| All Time</span></h5>
                    <div id="trafficChart" style="min-height: 800px;" class="echart"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                          echarts.init(document.querySelector("#trafficChart")).setOption({
                            tooltip: {
                              trigger: 'item'
                            },
                            legend: {
                              top: '10%',
                              left: 'center'
                            },
                            series: [{
                              name: 'Access From',
                              type: 'pie',
                              radius: ['30%', '50%'],
                              avoidLabelOverlap: true,
                              label: {
                                show: true,
                                position: 'center'
                              },
                              emphasis: {
                                label: {
                                  show: true,
                                  fontSize: '18',
                                  fontWeight: 'bold'
                                }
                              },
                              labelLine: {
                                show: true
                              },
                              data: [{
                                  value: <?=$step0_count?>,
                                  name: 'Request Submitted'
                                },
                                {
                                  value: <?=$step1_count?>,
                                  name: 'Accept Request'
                                },
                                {
                                  value: <?=$step2_count?>,
                                  name: 'Vendor Allocated'
                                },
                                {
                                  value: <?=$step3_count?>,
                                  name: 'Vendor Assigned'
                                },
                                {
                                  value: <?=$step4_count?>,
                                  name: 'Pickup Scheduled'
                                },
                                {
                                  value: <?=$step5_count?>,
                                  name: 'Vehicle Placed'
                                },
                                {
                                  value: <?=$step6_count?>,
                                  name: 'Material Weighed'
                                },
                                {
                                  value: <?=$step7_count?>,
                                  name: 'Invoice from HO'
                                },
                                {
                                  value: <?=$step8_count?>,
                                  name: 'Invoice to Vendor'
                                },
                                {
                                  value: <?=$step9_count?>,
                                  name: 'Payment received from Vendor'
                                },
                                {
                                  value: <?=$step10_count?>,
                                  name: 'Vehicle Dispatched'
                                },
                                {
                                  value: <?=$step11_count?>,
                                  name: 'Payment to HO'
                                },
                                {
                                  value: <?=$step12_count?>,
                                  name: 'Order Complete'
                                },
                                {
                                  value: <?=$step13_count?>,
                                  name: 'Reject Request'
                                }
                              ]
                            }]
                          });
                        });
                    </script>
                </div>
            </div>
            <!-- End Website Traffic -->
        </div>
        <!-- End Right side columns -->
    </div>
</section>
