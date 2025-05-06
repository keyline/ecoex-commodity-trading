<?php
$userType           = $session->user_type;
?>
<div class="container-fluid">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Page Title -->
<section class="section dashboard">
    <form method="GET" name="PostName" action="<?=base_url('admin/dashboard-filter')?>">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <div style="border:1px solid #a8cf45; padding: 5px 10px; border-radius: 5px;">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <label for="filter_keyword">Filter Parameteres</label>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-control" id="filter_keyword" name="filter_keyword" onchange="PostName.submit()">
                                <option value="" <?=(($filter_keyword == '')?'selected':'')?>>All Time</option>
                                <option value="today" <?=(($filter_keyword == 'today')?'selected':'')?>>Today</option>
                                <option value="yesterday" <?=(($filter_keyword == 'yesterday')?'selected':'')?>>Yesterday</option>
                                <option value="this_month" <?=(($filter_keyword == 'this_month')?'selected':'')?>>This Month</option>
                                <option value="last_month" <?=(($filter_keyword == 'last_month')?'selected':'')?>>Last Month</option>
                                <option value="last_7_days" <?=(($filter_keyword == 'last_7_days')?'selected':'')?>>Last 7 Days</option>
                                <option value="last_30_days" <?=(($filter_keyword == 'last_30_days')?'selected':'')?>>Last 30 Days</option>
                                <option value="this_year" <?=(($filter_keyword == 'this_year')?'selected':'')?>>This Year</option>
                                <option value="last_year" <?=(($filter_keyword == 'last_year')?'selected':'')?>>Last Year</option>
                            </select>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="container-fluid">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <?php if($userType == 'MA'){?>
                        <!-- Companies Card -->
                        <div class="col-xxl-6 col-md-6">
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
                                    <h5 class="card-title">Companies <span>| <?=$filter_keyword_text?></span></h5>
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
                    <?php if($userType == 'U'){?>
                        <!-- Companies Card -->
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Companies <span>| <?=$filter_keyword_text?></span></h5>
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
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Plants <span>| <?=$filter_keyword_text?></span></h5>
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
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Vendors <span>| <?=$filter_keyword_text?></span></h5>
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
                    <?php if($userType == 'U'){?>
                        <!-- Vendors Card -->
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Vendors <span>| <?=$filter_keyword_text?></span></h5>
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
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Enquires <span>| <?=$filter_keyword_text?></span></h5>
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
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Pending Items <span>| <?=$filter_keyword_text?></span></h5>
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
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Item Categories <span>| <?=$filter_keyword_text?></span></h5>
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
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Item Sub-Categories <span>| <?=$filter_keyword_text?></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?=$companyCats?></h6>
                                            <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Item Categories Card -->
                        <?php if($itemCats){ foreach($itemCats as $itemCat){?>
                            <?php $getCompanyCats = $common_model->find_data('ecomm_company_category', 'array', ['category_id' => $itemCat->id], 'id,category_alias'); ?>
                            <!-- <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card" style="border: 1px solid #4a984f;height: 531px;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?=$itemCat->name?> <span>| <?=$filter_keyword_text?></span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-list-nested"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?=count($getCompanyCats)?></h6>
                                                <?php if($getCompanyCats){ foreach($getCompanyCats as $getCompanyCat){?>
                                                    <?php $getCompanyItem = $common_model->find_data('ecomm_company_items', 'count', ['item_category' => $getCompanyCat->id]); ?>
                                                    <p>
                                                        <i class="bi bi-arrow-right-short"></i>
                                                        <span class="text-muted small pt-2 ps-1"><?=$getCompanyCat->category_alias?></span>
                                                        <span class="text-success small pt-1 fw-bold"><?=$getCompanyItem?></span>
                                                        <hr>
                                                    </p>
                                                <?php } }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        <?php } }?>
                    <?php }?>
                    <?php if($userType == 'U'){?>
                        <!-- Item Categories Card -->
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Item Categories <span>| <?=$filter_keyword_text?></span></h5>
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
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Item Sub-Categories <span>| <?=$filter_keyword_text?></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?=$companyCats?></h6>
                                            <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Item Categories Card -->
                    <?php }?>
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
                        <h5 class="card-title">Enquiry Requests <span>| <?=$filter_keyword_text?></span></h5>
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
                                name: 'Enquiry Status',
                                type: 'pie',
                                color: [
                                    '#37A2DA',
                                    '#32C5E9',
                                    '#67E0E3',
                                    '#9FE6B8',
                                    '#FFDB5C',
                                    '#ff9f7f',
                                    '#fb7293',
                                    '#E062AE',
                                    '#E690D1',
                                    '#e7bcf3',
                                    '#9d96f5',
                                    '#8378EA',
                                    '#91cc75',
                                    '#ff9f7f'
                                ],
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
    </div>
    <!-- Recent Sales -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Recent Enquires <span>| <?=$filter_keyword_text?></span></h5>
                        <table class="table table-borderless datatable globel_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company</th>
                                    <th>Plant</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($recent_enquiries){ foreach($recent_enquiries as $recent_enquiry){
                                    $getCompany                 = $common_model->find_data('ecoex_companies', 'row', ['id' => $recent_enquiry->company_id], 'company_name');
                                    $getPlant                   = $common_model->find_data('ecomm_users', 'row', ['id' => $recent_enquiry->plant_id], 'plant_name');
                                ?>
                                    <tr>
                                        <th><a href="<?=base_url('admin/enquiry-requests/enquiry-details/'.encoded($recent_enquiry->id))?>">#<?=$recent_enquiry->enquiry_no?></a></th>
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
                                                $bgcolor        =   '#48974e3d';
                                                $fontcolor        =   '#48974e';
                                            } elseif($recent_enquiry->status == 1){
                                                $enquiryStatus  = 'Accept Request';
                                                $bgcolor        =   '#4154f138';
                                                $fontcolor        =   '#4154f1';
                                            } elseif($recent_enquiry->status == 2){
                                                $enquiryStatus  = 'Vendor Allocated';
                                                $bgcolor        =   '#48974e3d';
                                                $fontcolor        =   '#48974e';
                                            } elseif($recent_enquiry->status == 3){
                                                $enquiryStatus  = 'Vendor Assigned';
                                                $bgcolor        =   '#a8cf4596';
                                                $fontcolor        =   '#333';
                                            } elseif($recent_enquiry->status == 4){
                                                $enquiryStatus  = 'Pickup Scheduled';
                                                $bgcolor        =   '#ffecdf';
                                                $fontcolor        =   '#ff771d';
                                            } elseif($recent_enquiry->status == 5){
                                                $enquiryStatus  = 'Vehicle Placed';
                                                $bgcolor        =   '#ff3a025c';
                                                $fontcolor        =   '#ff3a02';
                                            } elseif($recent_enquiry->status == 6){
                                                $enquiryStatus  = 'Material Weighed';
                                                $bgcolor        =   '#4154f17a';
                                                $fontcolor        =   '#4154f1';
                                            } elseif($recent_enquiry->status == 7){
                                                $enquiryStatus  = 'Invoice from HO';
                                                $bgcolor        =   '#a8cf4530';
                                                $fontcolor        =   '#a8cf45';
                                            } elseif($recent_enquiry->status == 8){
                                                $enquiryStatus  = 'Invoice to Vendor';
                                                $bgcolor        =   '#f6f6fe';
                                                $fontcolor        =   '#4154f1';
                                            } elseif($recent_enquiry->status == 9){
                                                $enquiryStatus  = 'Payment received from Vendor';
                                                $bgcolor        =   '#FF6363';
                                                $fontcolor        =   '#ffffff';
                                            } elseif($recent_enquiry->status == 10){
                                                $enquiryStatus  = 'Vehicle Dispatched';
                                                $bgcolor        =   '#ff00002b';
                                                $fontcolor        =   '#ff0000';
                                            } elseif($recent_enquiry->status == 11){
                                                $enquiryStatus  = 'Payment to HO';
                                                $bgcolor        =   '#03A791';
                                                $fontcolor        =   '#fff';
                                            } elseif($recent_enquiry->status == 12){
                                                $enquiryStatus  = 'Order Complete';
                                                $bgcolor        =   '#1F7D53';
                                                $fontcolor        =   '#fff';
                                            } elseif($recent_enquiry->status == 13){
                                                $enquiryStatus  = 'Reject Request';
                                                $bgcolor        =   '#BE3144';
                                                $fontcolor        =   '#fff';
                                            } 
                                            ?>
                                            <span class="badge" style="background-color: <?=$bgcolor?>; color: <?=$fontcolor?>;padding: 5px 10px;"><?=$enquiryStatus?></span>
                                        </td>
                                    </tr>
                                <?php } }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- End Recent Sales -->
</section>
