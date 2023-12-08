<!-- for inquiry tracking -->
  <style type="text/css">
    .progress-bar-wrapper ul.progress-bar {
        width: 100%;
        margin: 0;
        padding: 0;
        font-size: 0;
        list-style: none;
        background-color: #FFF;
        display: inline-block !important;
    }

    .progress-bar-wrapper li.section {
        display: inline-block !important;
        padding-top: 45px;
        font-size: 13px;
        font-weight: bold;
        line-height: 16px;
        color: gray;
        vertical-align: top;
        position: relative;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .progress-bar-wrapper li.section:before {
        content: 'x';
        position: absolute;
        top: 3px;
        left: calc(50% - 15px);
        z-index: 1;
        width: 30px;
        height: 30px;
        color: white;
        border: 2px solid white;
        border-radius: 17px;
        line-height: 26px;
        background: gray;
    }
    .progress-bar-wrapper .status-bar {
        height: 2px;
        background: gray;
        position: relative;
        top: 20px;
        margin: 0 auto;
    }
    .progress-bar-wrapper .current-status {
        height: 3px;
        width: 0;
        border-radius: 1px;
        background: #26a541;
    }

    @keyframes changeBackground {
        from {background: gray}
        to {background: #26a541}
    }

    .progress-bar-wrapper li.section.visited:before {
        content: '\2714';
        animation: changeBackground 3s linear;
        animation-fill-mode: forwards;
    }

    .progress-bar-wrapper li.section.visited.current:before {
        box-shadow: 0 0 0 2px #26a541;
    }
  </style>
<!-- for inquiry tracking -->
<style type="text/css">
  th:first-child, td:first-child
  {
    position:sticky;
    left:0px;
    background-color:grey;
    color: #FFF;
  }
</style>
<?php
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
</div>
<section class="section">
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
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <!-- inquiry flow tracking -->
                        <?php
                        if($row->status == 0){
                            $enquiryStatus = 'Pending';
                        } elseif($row->status == 1){
                            $enquiryStatus = 'Sent/Submitted';
                        } elseif($row->status == 2){
                            $enquiryStatus = 'Accepted/Rejected';
                        } elseif($row->status == 3){
                            $enquiryStatus = 'Pickup';
                        } elseif($row->status == 4){
                            $enquiryStatus = 'Vehicle Placed';
                        } elseif($row->status == 5){
                            $enquiryStatus = 'Vehicle Ready Despatch';
                        } elseif($row->status == 6){
                            $enquiryStatus = 'Material Lifted';
                        } elseif($row->status == 7){
                            $enquiryStatus = 'Invoiced';
                        } elseif($row->status == 8){
                            $enquiryStatus = 'Completed';
                        } elseif($row->status == 9){
                            $enquiryStatus = 'Rejected';
                        }                       
                        ?>
                        <div class="progress-bar-wrapper" style="margin-bottom: 10px;"></div>
                    <!-- inquiry flow tracking -->
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Company Name</h5>
                            <h6>
                                <?php
                                $getCompany = $common_model->find_data('ecoex_companies', 'row', ['id' => $row->company_id], 'company_name');
                                echo (($getCompany)?$getCompany->company_name:'');
                                ?>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Plant Name</h5>
                            <h6>
                                <?php
                                $getPlant = $common_model->find_data('ecomm_users', 'row', ['id' => $row->plant_id], 'company_name');
                                echo (($getPlant)?$getPlant->company_name:'');
                                ?>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">GPS Tracking Image</h5>
                            <h6>
                                <?php if($row->gps_tracking_image != ''){?>
                                    <a href="<?=getenv('app.uploadsURL').'enquiry/'.$row->gps_tracking_image?>" target="_blank"><img src="<?=getenv('app.uploadsURL').'enquiry/'.$row->gps_tracking_image?>" alt="<?=$row->enquiry_no?>" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;"></a>
                                <?php } else {?>
                                    <img src="<?=getenv('app.NO_IMAGE')?>" alt="<?=$row->enquiry_no?>" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;">
                                <?php }?>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Tentative Collection Date</h5>
                            <h6><?=date_format(date_create($row->tentative_collection_date), "M d, Y")?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Latitude</h5>
                            <h6><?=$row->latitude?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Longitude</h5>
                            <h6><?=$row->longitude?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Device Brand</h5>
                            <h6><?=$row->device_brand?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Device Model</h5>
                            <h6><?=$row->device_model?></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>HSN Code</th>
                                        <th>Image</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>New Product</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($enquiryProducts){ $slNo=1; foreach($enquiryProducts as $enquiryProduct){
                                        if($enquiryProduct->new_product){
                                            $productName    = $enquiryProduct->new_product_name;
                                            $productHSNCode = $enquiryProduct->new_hsn;
                                            $productImage   = (($enquiryProduct->new_product_image != '')?getenv('app.uploadsURL').'enquiry/'.$enquiryProduct->new_product_image:getenv('app.NO_IMG'));
                                        } else {
                                            $getProduct = $common_model->find_data('ecomm_products', 'row', ['id' => $enquiryProduct->product_id], 'name,hsn_code,product_image');
                                            $productName    = (($getProduct)?$getProduct->name:'');
                                            $productHSNCode = (($getProduct)?$getProduct->hsn_code:'');
                                            $productImage   = (($getProduct)?(($getProduct->product_image != '')?getenv('app.uploadsURL').'enquiry/'.$getProduct->product_image:$getProduct->product_image):getenv('app.NO_IMG'));
                                        }
                                    ?>
                                        <tr>
                                            <td><?=$slNo++?></td>
                                            <td><?=$productName?></td>
                                            <td><?=$productHSNCode?></td>
                                            <td><a href="<?=$productImage?>" target="_blank"><img src="<?=$productImage?>" class="img-thumbnail" style="width:100px; height: 100px;"></a></td>
                                            <td><?=$enquiryProduct->qty?></td>
                                            <td>
                                                <?php
                                                $unit               = $common_model->find_data('ecomm_units', 'row', ['id' => $enquiryProduct->unit], 'name');
                                                echo (($unit)?$unit->name:'');
                                                ?>
                                            </td>
                                            <td>
                                                <?php if($enquiryProduct->new_product){?>
                                                    <span class="badge bg-success">NEW</span>
                                                <?php } else {?>
                                                    <span class="badge bg-danger">EXISTING</span>
                                                <?php }?>
                                            </td>
                                            <td><?=$enquiryProduct->remarks?></td>
                                            <td>
                                                <?php if($enquiryProduct->status){?>
                                                    <span class="badge bg-success">APPROVED</span>
                                                <?php } else {?>
                                                    <span class="badge bg-danger">PENDING</span>
                                                <?php }?>
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

    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- progress bar -->
    <script src="<?=getenv('app.adminAssetsURL');?>assets/js/progress-bar.js"></script>
<!-- progress bar -->
<?php if($row->status != 9){?>
    <script type="text/javascript">
      //we can set animation delay as following in ms (default 1000)
      ProgressBar.singleStepAnimation = 700;
      ProgressBar.init(
        [   'Pending',
            'Sent/Submitted',
            'Accepted/Rejected',
            'Pickup',
            'Vehicle Placed',
            'Vehicle Ready Despatch',
            'Material Lifted',
            'Invoiced',
            'Completed'
        ],
        '<?=$enquiryStatus?>',
        'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
      );
    </script>
<?php } else {?>
    <script type="text/javascript">
      //we can set animation delay as following in ms (default 1000)
      ProgressBar.singleStepAnimation = 700;
      ProgressBar.init(
        [   'Pending',
            'Rejected'
        ],
        '<?=$enquiryStatus?>',
        'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
      );
    </script>
<?php }?>