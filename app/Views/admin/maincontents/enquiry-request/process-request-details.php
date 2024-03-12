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
                        } elseif($row->status == 7.7){
                            $enquiryStatus = 'Invoice from HO';
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
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Assigned Date</h5>
                                <h6><?=date_format(date_create($row->assigned_date), "M d, Y h:i A")?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Pickup Scheduled Date</h5>
                                <h6>
                                    <?php
                                    if($row->is_pickup_final){
                                        echo date_format(date_create($row->pickup_scheduled_date), "M d, Y h:i A");
                                    } else {
                                    ?>
                                        <h6 class="text-warning">Still Not Finalised</h6>
                                        <p>
                                            <?php if($row->pickup_schedule_edit_access){?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status-pickup-edit-access/'.encoded($row->sub_enquiry_no).'/'.encoded(current_url()))?>" class="btn btn-success btn-sm" title="Pickup Scheduled Edit Access Off" onclick="return confirm('Do you want to off pickup Scheduled edit access ?');"><i class="fa fa-check"></i> Pickup Schedule Edit Access On</a>
                                            <?php } else {?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status-pickup-edit-access/'.encoded($row->sub_enquiry_no).'/'.encoded(current_url()))?>" class="btn btn-danger btn-sm" title="Pickup Scheduled Edit Access On" onclick="return confirm('Do you want to off pickup Scheduled edit access ?');"><i class="fa fa-times"></i> Pickup Schedule Edit Access Off</a>
                                            <?php }?>
                                            <?php if($row->pickup_scheduled_date != ''){?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/final-pickup-scheduled/'.encoded($row->sub_enquiry_no).'/'.encoded(current_url()))?>" class="btn btn-primary btn-sm" title="Final Pickup Scheduled <?=$title?>" onclick="return confirm('Do you want to finalize this date of pickup material from vendor end ?');"><i class="fa fa-eye"></i> Make Final</a>
                                            <?php }?>
                                        </p>
                                    <?php }
                                    ?>
                                </h6>
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

            <div class="card">
                <div class="card-header bg-success text-light">
                    <h5>Pickup Scheduled</h5>
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pickup Date/Time</th>
                                        <th>Submitted Date/Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($getPickupDates){ $sl=1; foreach($getPickupDates as $getPickupDate){?>
                                        <tr>
                                            <td><?=$sl++?></td>
                                            <td><?=date_format(date_create($getPickupDate->pickup_date_time), "M d, Y h:i A")?></td>
                                            <td><?=date_format(date_create($getPickupDate->created_at), "M d, Y h:i A")?></td>
                                        </tr>
                                    <?php } }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-light">
                    <h5>Vehicle Placed <span style="float: right;"><?=count($vehicles)?> vehicles placed</span></h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vehicle Number</th>
                                <th>Vehicle Images</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($vehicles){ $sl=1; foreach($vehicles as $vehicle){?>
                                <tr>
                                    <td><?=$sl++?></td>
                                    <td><?=$vehicle['vehicle_no']?></td>
                                    <td>
                                        <div class="row">
                                            <?php if($vehicle['vehicle_img']){ for($v=0;$v<count($vehicle['vehicle_img']);$v++){?>
                                                <div class="col-md-3">
                                                    <a href="<?=$vehicle['vehicle_img'][$v]?>" download><img src="<?=$vehicle['vehicle_img'][$v]?>" class="img-thumbnail" style="height:100px;width: 100%;"></a>
                                                </div>
                                            <?php } }?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } }?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($row->status >= 5.5){?>
                <div class="card">
                    <div class="card-header bg-success text-light">
                        <h5>Material Weighted</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?=base_url('admin/enquiry-requests/modify-approve-material-weight')?>">
                            <input type="hidden" name="sub_enquiry_no" value="<?=$sub_enquiry_no?>">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Weighted Qty</th>
                                        <th>Vendor Submitted Material Weight</th>
                                        <th>Plant Submitted Material Weight</th>
                                        <th>Weight Slips</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($materialWeights){ $sl=1; foreach($materialWeights as $materialWeight){?>
                                        <?php
                                        $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $row1->item_id], 'item_name_ecoex,hsn');
                                        ?>
                                        <tr>
                                            <td><?=$sl++?></td>
                                            <td><?=(($getItem)?$getItem->item_name_ecoex:'')?></td>
                                            <td>
                                                <span class="weight-label"><?=$materialWeight->weighted_qty?></span>
                                                <input type="text" name="weighted_qty[]" class="form-control weight-value" value="<?=$materialWeight->weighted_qty?>" style="display: none;">
                                                <?=$materialWeight->weighted_unit?>
                                            </td>
                                            <td><?=(($materialWeight->material_weight_vendor_date != '')?date_format(date_create($materialWeight->material_weight_vendor_date), "M d, Y h:i A"):'')?></td>
                                            <td><?=(($materialWeight->material_weight_plant_date != '')?date_format(date_create($materialWeight->material_weight_plant_date), "M d, Y h:i A"):'')?></td>
                                            <td>
                                                <div class="row">
                                                    <?php
                                                    $material_weighing_slips = json_decode($materialWeight->material_weighing_slips);
                                                    ?>
                                                    <?php if($material_weighing_slips){ for($v=0;$v<count($material_weighing_slips);$v++){?>
                                                        <div class="col-md-6">
                                                            <a href="<?=getenv('app.uploadsURL').'enquiry/'.$material_weighing_slips[$v]?>" download><img src="<?=getenv('app.uploadsURL').'enquiry/'.$material_weighing_slips[$v]?>" class="img-thumbnail" style="height:100px;width: 100px;"></a>
                                                        </div>
                                                    <?php } }?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } }?>
                                    <?php if($row->is_plant_ecoex_confirm <= 0){?>
                                        <tr>
                                            <td colspan="3" style="text-align:center;">
                                                <a href="<?=base_url('admin/enquiry-requests/approve-material-weight/'.encoded($sub_enquiry_no))?>" class="btn btn-success" onclick="return confirm('Do you want to approve this request ?');"><i class="fa fa-check-circle"></i> APPROVE</a>
                                            </td>
                                            <td colspan="3" style="text-align:center;">
                                                <a href="javascript:void(0);" class="btn btn-primary" id="modify-btn" onclick="openMaterialWeightUpdate();"><i class="fa fa-edit"></i> MODIFY</a>
                                                <button type="submit" class="btn btn-primary" id="update-btn" style="display:none;"><i class="fa fa-edit"></i> UPDATE</button>
                                                <a href="javascript:void(0);" class="btn btn-danger" id="cancel-btn" onclick="closeMaterialWeightUpdate();" style="display:none;"><i class="fa fa-times"></i> CANCEL</a>
                                            </td>
                                        </tr>
                                    <?php } else {?>
                                        <tr>
                                            <td colspan="6" style="text-align:center;">
                                                <h6 class="badge bg-success">Material Weight Approved</h6>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            <?php }?>
            <?php
            $userType           = $session->user_type;
            ?>
            <?php if($row->status >= 6.6){?>
                <div class="card">
                    <div class="card-header bg-success text-light">
                        <h5>Invoice From HO</h5>
                    </div>
                    <div class="card-body">
                        <?php if($getEnquiry){?>
                            <div class="row mt-3">
                                <div class="col-md-6 text-center">
                                    <?php if($getEnquiry->is_invoice_from_ho == 0){?>
                                        <a href="<?=base_url('admin/enquiry-requests/request-invoice-to-HO-from-ecoex/'.encoded($getEnquiry->id).'/'.encoded($sub_enquiry_no))?>" class="btn btn-warning btn-sm" onclick="return confirm('Do you want to sent request for invoice to HO ?');"><i class="fa-solid fa-code-pull-request"></i> Request For Invoice To HO</a>
                                    <?php } elseif($getEnquiry->is_invoice_from_ho >= 1){?>
                                        <h4 class="text-success fw-bold">Invoice Request Sent To HO Succesfully</h4>
                                        <h5><?=date_format(date_create($getEnquiry->invoice_from_ho_request_date), "M d, Y h:i A")?></h5>
                                    <?php }?>
                                </div>
                                <div class="col-md-6 text-center">
                                    <?php if($getEnquiry->is_invoice_from_ho == 1){?>
                                        <h4 class="text-warning fw-bold">HO Still Not Uploaded Invoice</h4>
                                        <?php if($userType == 'COMPANY'){?>
                                            <form method="POST" action="<?=base_url('admin/enquiry-requests/upload-invoice-by-HO')?>" enctype="multipart/form-data">
                                                <input type="hidden" name="enq_id" value="<?=encoded($getEnquiry->id)?>">
                                                <input type="hidden" name="sub_enquiry_no" value="<?=encoded($sub_enquiry_no)?>">
                                                <div class="form-group">
                                                    <input type="file" class="form-control" name="invoice_file_from_ho" accept="application/pdf" required>
                                                    <small class="text-primary">Only PDF file allowed</small>
                                                </div>
                                                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-file-invoice"></i> Upload Invoice</button>
                                            </form>
                                        <?php }?>
                                    <?php } elseif($getEnquiry->is_invoice_from_ho == 2){?>
                                        <h4 class="text-success fw-bold">Invoice Uploaded By HO Succesfully</h4>
                                        <a download href="<?=getenv('app.uploadsURL').'enquiry/'.$getEnquiry->invoice_file_from_ho?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to open invoice ?');"><i class="fas fa-download"></i> Download Invoice From HO</a>
                                        <h5><?=date_format(date_create($getEnquiry->invoice_from_ho_date), "M d, Y h:i A")?></h5>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            <?php }?>

            <?php if($row->status >= 7.7){?>
                <?php if($userType == 'MA'){?>
                    <div class="card">
                        <div class="card-header bg-success text-light">
                            <h5>Invoice To Vendor</h5>
                        </div>
                        <div class="card-body">
                            <?php if($row){?>
                                <div class="row mt-3">
                                    <div class="col-md-6 text-center">
                                        <?php if($row->vendor_invoice_file == ''){?>
                                            
                                                <form method="POST" action="<?=base_url('admin/enquiry-requests/upload-invoice-by-ecoex-for-vendor')?>" enctype="multipart/form-data" style="border: 1px solid #0080006e;border-radius: 10px;padding: 10px;">
                                                    <input type="hidden" name="enq_id" value="<?=encoded($row->enq_id)?>">
                                                    <input type="hidden" name="sub_enquiry_no" value="<?=encoded($sub_enquiry_no)?>">
                                                    <div class="form-group">
                                                        <label for="vendor_invoice_amount">Vendor Invoice Amount</label>
                                                        <input type="text" class="form-control" name="vendor_invoice_amount" id="vendor_invoice_amount" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="vendor_invoice_file">Vendor Invoice File</label>
                                                        <input type="file" class="form-control" name="vendor_invoice_file" id="vendor_invoice_file" accept="application/pdf" required>
                                                        <small class="text-primary">Only PDF file allowed</small>
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-file-invoice"></i> Upload Invoice</button>
                                                </form>
                                            
                                        <?php } else {?>
                                            <h4 class="text-success fw-bold">Invoice Uploaded For Vendor Succesfully</h4>
                                            <h6><?=date_format(date_create($row->invoice_to_vendor_date), "M d, Y h:i A")?></h6>
                                        <?php }?>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <?php if($row->vendor_invoice_file != ''){?>
                                            <h4 class="text-success fw-bold">Invoice Uploaded By Ecoex Succesfully</h4>
                                            <a download href="<?=getenv('app.uploadsURL').'enquiry/'.$row->vendor_invoice_file?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to open invoice ?');"><i class="fas fa-download"></i> Download Invoice From Vendor</a>
                                            <h5><i class="fa fa-inr"></i> <?=$row->vendor_invoice_amount?></h5>
                                            <h6><?=date_format(date_create($row->invoice_to_vendor_date), "M d, Y h:i A")?></h6>
                                        <?php }?>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>
            <?php }?> 

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
          'Invoice from HO',
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
<script type="text/javascript">
    function openMaterialWeightUpdate(){
        $('.weight-label').hide();
        $('.weight-value').show();
        $('#modify-btn').hide();
        $('#update-btn').show();
        $('#cancel-btn').show();
    }
    function closeMaterialWeightUpdate(){
        $('.weight-label').show();
        $('.weight-value').hide();
        $('#modify-btn').show();
        $('#update-btn').hide();
        $('#cancel-btn').hide();
    }
</script>