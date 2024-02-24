<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<style type="text/css">
    .choices__list--multiple .choices__item {
    background-color: #48974e;
    border: 1px solid #48974e;
    }
</style>
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
    font-size: 12px;
    font-weight: bold;
    line-height: 16px;
    color: gray;
    vertical-align: top;
    position: relative;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap: break-word;
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
    .home-successstories .owl-nav {
    position: absolute;
    top: 50%;
    transform: translate(0,-50%);
    width: 100%;
    display: block;
    }
    .home-successstories .owl-nav button {
    width: 50px;
    height: 50px;
    border: 2px solid #fff !important;
    color: #fff !important;
    font-size: 30px !important;
    border-radius: 50px;
    }
    .home-successstories .owl-nav button.owl-next {
    right: 0;
    position: absolute;
    }
    .sucess_boximg {
    height: 500px;
    object-fit: cover;
    overflow: hidden;
    }
    .sucess_boximg img {
    object-fit: cover;
    height: 100%;
    width: 100%;
    }
    th:first-child
    {
    position:sticky;
    left:0px;
    background-color:#dee2e6;
    color: #000;
    z-index: 1;
    }
    td:first-child
    {
    position:sticky;
    left:0px;
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
                        if($row->status == 3.3){
                            $enquiryStatus = 'Vendor Assigned';
                        } elseif($row->status == 4.4){
                            $enquiryStatus = 'Pickup Scheduled';
                        } elseif($row->status == 5.5){
                            $enquiryStatus = 'Vehicle Placed';
                        } elseif($row->status == 6.6){
                            $enquiryStatus = 'Material Weighed';
                        } elseif($row->status == 8.8){
                            $enquiryStatus = 'Invoice to Vendor';
                        } elseif($row->status == 9.9){
                            $enquiryStatus = 'Payment received from Vendor';
                        } elseif($row->status == 10.10){
                            $enquiryStatus = 'Vehicle Dispatched';
                        } elseif($row->status == 12.12){
                            $enquiryStatus = 'Order Complete';
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
                    <?php if($getEnquiry){?>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Enquiry No.</h5>
                                <h6><?=$getEnquiry->enquiry_no?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Sub Enquiry No.</h5>
                                <h6><?=$row->sub_enquiry_no?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Company Name</h5>
                                <h6>
                                    <?php
                                    $getCompany = $common_model->find_data('ecoex_companies', 'row', ['id' => $getEnquiry->company_id], 'company_name');
                                    echo (($getCompany)?$getCompany->company_name:'');
                                    ?>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Plant Name</h5>
                                <h6>
                                    <?php
                                    $getPlant = $common_model->find_data('ecomm_users', 'row', ['id' => $getEnquiry->plant_id], 'plant_name');
                                    echo (($getPlant)?$getPlant->plant_name:'');
                                    ?>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">GPS Tracking Image</h5>
                                <h6>
                                    <?php if($getEnquiry->gps_tracking_image != ''){?>
                                    <a href="<?=getenv('app.uploadsURL').'enquiry/'.$getEnquiry->gps_tracking_image?>" target="_blank"><img src="<?=getenv('app.uploadsURL').'enquiry/'.$getEnquiry->gps_tracking_image?>" alt="<?=$getEnquiry->enquiry_no?>" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;"></a>
                                    <?php } else {?>
                                    <img src="<?=getenv('app.NO_IMAGE')?>" alt="<?=$getEnquiry->enquiry_no?>" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;">
                                    <?php }?>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Tentative Collection Date</h5>
                                <h6><?=date_format(date_create($getEnquiry->tentative_collection_date), "M d, Y")?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Latitude</h5>
                                <h6><?=$getEnquiry->latitude?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Device Brand</h5>
                                <h6><?=$getEnquiry->device_brand?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Longitude</h5>
                                <h6><?=$getEnquiry->longitude?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Device Model</h5>
                                <h6><?=$getEnquiry->device_model?></h6>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-success text-light">
                    <h5>Enquiry Request Items</h5>
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>HSN</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($items){
                                            $sl=1;
                                            foreach($items as $row1){
                                                $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $row1->item_id], 'item_name_ecoex,hsn');
                                                $getEnquiryItem = $common_model->find_data('ecomm_enquiry_products', 'row', ['product_id' => $row1->item_id, 'enq_id' => $row1->enq_id], 'new_product_image,qty,unit');
                                                $getUnit = $common_model->find_data('ecomm_units', 'row', ['id' => (($getEnquiryItem)?$getEnquiryItem->unit:0)], 'name');

                                                $item_images     = [];
                                                if($getEnquiryItem){
                                                    $new_product_image  = json_decode($getEnquiryItem->new_product_image);
                                                    if(!empty($new_product_image)){
                                                        for($pi=0;$pi<count($new_product_image);$pi++){
                                                            $item_images[]     = [
                                                                'id'    => $pi,
                                                                'link'  => (($new_product_image[$pi] != '')?getenv('app.uploadsURL').'enquiry/'.$new_product_image[$pi]:getenv('app.NO_IMAGE'))
                                                            ];
                                                        }
                                                    }
                                                }

                                                // $items[]              = [
                                                //     'item_id'           => $row1->item_id,
                                                //     'item_name'         => (($getItem)?$getItem->item_name_ecoex:''),
                                                //     'item_hsn'          => (($getItem)?$getItem->hsn:''),
                                                //     'item_qty'          => (($getEnquiryItem)?$getEnquiryItem->qty:''),
                                                //     'item_unit'         => (($getUnit)?$getUnit->name:''),
                                                //     'item_quote_price'  => $row1->win_quote_price,
                                                //     'item_images'       => $item_images,
                                                // ];
                                        ?>
                                        <tr>
                                            <td><?=$sl++?></td>
                                            <td><?=(($getItem)?$getItem->item_name_ecoex:'')?></td>
                                            <td><?=(($getItem)?$getItem->hsn:'')?></td>
                                            <td><?=(($getEnquiryItem)?$getEnquiryItem->qty:'')?></td>
                                            <td><?=$row1->win_quote_price?></td>
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
    </div>
</section>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- progress bar -->
<script src="<?=getenv('app.adminAssetsURL');?>assets/js/progress-bar.js"></script>
<!-- progress bar -->
<?php if($row->status != 9){?>
<script type="text/javascript">
    //we can set animation delay as following in ms (default 1000)
    ProgressBar.singleStepAnimation = 700;
    ProgressBar.init(
      [   'Vendor Assigned',
          'Pickup Scheduled',
          'Vehicle Placed',
          'Material Weighed',
          'Invoice to Vendor',
          'Payment received from Vendor',
          'Vehicle Dispatched',
          'Order Complete'
      ],
      '<?=$enquiryStatus?>',
      'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
    );
</script>
<?php }?>