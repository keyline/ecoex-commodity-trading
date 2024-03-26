<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<style type="text/css">
    .choices__list--multiple .choices__item {
    background-color: #48974e;
    border: 1px solid #48974e;
    }
</style>
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
    	font-size: 10px;
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
     from {
    background: gray
    }
     to {
    background: #26a541
    }
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
    	transform: translate(0, -50%);
    	width: 100%;
    	display: block;
    }
    .home-successstories .owl-nav button {
    	width: 50px;
    	height: 50px;
    	border: 2px solid #fff !important;
    	color: #fff !important;
    	font-size: 22px !important;
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
    .material_accordion_section button.accordion-button {
    	color: #fff;
    	font-size: 18px;
    }
    .material_accordion_section .accordion-button::after {
    	font-family: "Font Awesome 5 Free";
    	font-weight: 900;
    	content: "\f078";
    ";
    	position: absolute;
    	right: 5px;
    	color: #fff;
    	background-image: none;
    }
    .material_accordion_section .tab-content {
        padding: 30px;
        background: #fff;
        border: 1px solid #ddd;
        border-top: none;
    }
    .material_accordion_section .nav-tabs .nav-item .nav-link {
        background: #f2f2f2;
        margin-right: 8px;
        color: #000;
    }
    .material_accordion_section .nav-tabs .nav-item .nav-link.active {
        background: #FF9800;
        color: #fff;
    }
</style>
<?php
    $title              = $moduleDetail['title'];
    $primary_key        = $moduleDetail['primary_key'];
    $controller_route   = $moduleDetail['controller_route'];
?>
<div class="pagetitle">
  <h1>
    <?=$page_header?>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
      <li class="breadcrumb-item active">
        <?=$page_header?>
      </li>
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
                        $enquiryStatus = 'Request Submitted';
                    } elseif($row->status == 1){
                        $enquiryStatus = 'Accept Request';
                    } elseif($row->status == 2){
                        $enquiryStatus = 'Vendor Allocated';
                    } elseif($row->status == 3){
                        $enquiryStatus = 'Vendor Assigned';
                    } elseif($row->status == 4){
                        $enquiryStatus = 'Pickup Scheduled';
                    } elseif($row->status == 5){
                        $enquiryStatus = 'Vehicle Placed';
                    } elseif($row->status == 6){
                        $enquiryStatus = 'Material Weighed';
                    } elseif($row->status == 7){
                        $enquiryStatus = 'Invoice from HO';
                    } elseif($row->status == 8){
                        $enquiryStatus = 'Invoice to Vendor';
                    } elseif($row->status == 9){
                        $enquiryStatus = 'Payment received from Vendor';
                    } elseif($row->status == 10){
                        $enquiryStatus = 'Vehicle Dispatched';
                    } elseif($row->status == 11){
                        $enquiryStatus = 'Payment to HO';
                    } elseif($row->status == 12){
                        $enquiryStatus = 'Order Complete';
                    } elseif($row->status == 13){
                        $enquiryStatus = 'Reject Request';
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
                    <div class="col-md-12 mb-3">
                        <?php if($row->status == 0){?>
                            <a href="<?=base_url('admin/' . $controller_route . '/accept-request/'.encoded($row->$primary_key))?>" class="btn btn-success btn-sm" title="Accept <?=$title?>" onclick="return confirm('Do You Want To Accept This <?=$title?>');"><i class="fa fa-check"></i> Click To Accept</a>
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Reject <?=$title?>" onclick="getRejectModal(<?=$row->$primary_key?>);"><i class="fa fa-times"></i> Click To Reject</a>
                        <?php } else {?>
                            <?php if($row->status == 1){?>
                                <h6 class="badge bg-success"><i class="fa fa-check-circle"></i> ACCEPTED</h6>
                                <p><?=(($row->accepted_date != '')?date_format(date_create($row->accepted_date), "M d, Y h:i A"):'')?></p>
                                <!-- share to vendors panel -->
                                    <p>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#shareModal"><i class="fa fa-share-alt"></i> Quotation Invitation To Vendors</button>
                                        <a data-bs-toggle="collapse" href="#sharedVendor" role="button" aria-expanded="false" aria-controls="sharedVendor" class="btn btn-primary btn-sm"><i class="fa fa-list-alt"></i> Click To View The Quotation Request Invited Vendors</a>
                                        <?php $sharedLink = base_url('enquiry-request/'.encoded($row->id));?>
                                    </p>
                                    <div class="collapse" id="sharedVendor">
                                        <div class="card">
                                            <div class="card-header bg-success text-light">
                                                <h5>Enquiry Quotation Request Invited Vendors</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-striped table-hovered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>GST No.</th>
                                                            <th>Location</th>
                                                            <th>Request Status</th>
                                                            <th>Action Date/Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $invitedVendors = $common_model->find_data('ecomm_enquiry_vendor_shares', 'array', ['enq_id' => $row->id]);
                                                            if($invitedVendors){ $sl=1; foreach($invitedVendors as $invitedVendor){
                                                                $getVendor = $common_model->find_data('ecomm_users', 'row', ['id' => $invitedVendor->vendor_id, 'type' => 'VENDOR'], 'gst_no,company_name,full_address,email,phone');
                                                            ?>
                                                        <tr>
                                                            <td><?=$sl++?></td>
                                                            <td><?=(($getVendor)?$getVendor->company_name:'')?></td>
                                                            <td><?=(($getVendor)?$getVendor->email:'')?></td>
                                                            <td><?=(($getVendor)?$getVendor->phone:'')?></td>
                                                            <td><?=(($getVendor)?$getVendor->gst_no:'')?></td>
                                                            <td><?=(($getVendor)?$getVendor->full_address:'')?></td>
                                                            <td>
                                                                <?php if($invitedVendor->status == 0){?>
                                                                <span class="badge bg-warning"><i class="fa-solid fa-clock"></i> PENDING</span>
                                                                <?php } elseif($invitedVendor->status == 1){?>
                                                                <span class="badge bg-success"><i class="fa-solid fa-check-circle"></i> ACCEPTED</span>
                                                                <?php } elseif($invitedVendor->status == 3){?>
                                                                <span class="badge bg-danger"><i class="fa-solid fa-times-circle"></i> REJECTED</span>
                                                                <?php }?>
                                                            </td>
                                                            <td>
                                                                <?php if($invitedVendor->status == 0){?>
                                                                <span class="text-warning fw-bold">Yet Not Action</span>
                                                                <?php } elseif($invitedVendor->status == 1){?>
                                                                <span class="text-success fw-bold"><?=date_format(date_create($invitedVendor->updated_at), "M d, Y")?></span>
                                                                <?php } elseif($invitedVendor->status == 3){?>
                                                                <span class="text-danger fw-bold"><?=date_format(date_create($invitedVendor->updated_at), "M d, Y")?></span>
                                                                <?php }?>
                                                            </td>
                                                        </tr>
                                                        <?php } }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <!-- share to vendors panel -->
                            <?php } elseif($row->status == 9){?>
                                <h6 class="badge bg-danger"><i class="fa fa-times-circle"></i> REJECTED</h6>
                                <p><?=(($row->accepted_date != '')?date_format(date_create($row->accepted_date), "M d, Y h:i A"):'')?></p>
                            <?php }?>
                        <?php }?>
                    </div>

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
                            $getPlant = $common_model->find_data('ecomm_users', 'row', ['id' => $row->plant_id], 'plant_name');
                            echo (($getPlant)?$getPlant->plant_name:'');
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
                        <h5 class="fw-bold text-success">Device Brand</h5>
                        <h6><?=$row->device_brand?></h6>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold text-success">Longitude</h5>
                        <h6><?=$row->longitude?></h6>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold text-success">Device Model</h5>
                        <h6><?=$row->device_model?></h6>
                    </div>
                    <?php if($subenquires){?>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Assigned Date</h5>
                            <h6><?=date_format(date_create($subenquires[0]->assigned_date), "M d, Y h:i A")?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Pickup Scheduled Date</h5>
                            <h6>
                                <?php
                                if($subenquires[0]->is_pickup_final){
                                    echo date_format(date_create($subenquires[0]->pickup_scheduled_date), "M d, Y h:i A");
                                }
                                ?>
                            </h6>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>

        <div class="material_accordion_section">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Enquiry Request Items </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item<br>Category</th>
                                            <th>Item Name<br>(Ecoex)</th>
                                            <th>Alias<br>(App)</th>
                                            <th>Billing<br>Name</th>
                                            <th>HSN</th>
                                            <th>GST</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>Remarks</th>
                                            <th>Images</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($enquiryProducts){ $slNo=1; foreach($enquiryProducts as $enquiryProduct){
                                                if($enquiryProduct->new_product){
                                                    $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryProduct->product_id], 'id,item_category,item_name_ecoex,alias_name,billing_name,item_images,hsn,gst,rate,unit');
                                                    if($getItem){
                                                        $productName    = (($getItem)?$getItem->item_name_ecoex:'');
                                                        $productHSNCode = (($getItem)?$getItem->hsn:'');
                                                    } else {
                                                        $productName    = $enquiryProduct->new_product_name;
                                                        $productHSNCode = $enquiryProduct->new_hsn;
                                                    }
                                                    // $productImage   = (($enquiryProduct->new_product_image != '')?getenv('app.uploadsURL').'enquiry/'.$enquiryProduct->new_product_image:getenv('app.NO_IMG'));
                                                } else {
                                                    $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryProduct->product_id], 'id,item_category,item_name_ecoex,alias_name,billing_name,item_images,hsn,gst,rate,unit');
                                                    $productName    = (($getItem)?$getItem->item_name_ecoex:'');
                                                    $productHSNCode = (($getItem)?$getItem->hsn:'');
                                                    // $productImage   = (($getItem)?(($getItem->product_image != '')?getenv('app.uploadsURL').'enquiry/'.$getItem->product_image:$getItem->product_image):getenv('app.NO_IMG'));
                                                }
                                                if($enquiryProduct->status){
                                                    $bgColor = '#0080001a';
                                                } else {
                                                    $bgColor = '#ff00001c';
                                                }
                                            ?>
                                        <tr style="background-color: <?=$bgColor?>;">
                                            <th><?=$slNo++?></th>
                                            <td>
                                                <?php
                                                    if($getItem){
                                                        $itemCategory               = $common_model->find_data('ecomm_product_categories', 'row', ['id' => $getItem->item_category], 'name');
                                                        echo (($itemCategory)?$itemCategory->name:'');
                                                    }
                                                    ?>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><?=$productName?></span><br>
                                                <!-- <a data-bs-toggle="collapse" href="#viewQuotations<?=$enquiryProduct->id?>" role="button" aria-expanded="false" aria-controls="viewQuotations<?=$enquiryProduct->id?>" class="badge bg-primary"><i class="fa fa-list-alt"></i> Click To View The Quotations</a> -->
                                                <!-- quotaion list -->
                                                <!-- quotaion list -->
                                            </td>
                                            <td><?=(($getItem)?$getItem->alias_name:'')?></td>
                                            <td><?=(($getItem)?$getItem->billing_name:'')?></td>
                                            <td><?=$productHSNCode?></td>
                                            <td><?=(($getItem)?$getItem->gst:'')?></td>
                                            <td><?=(($getItem)?$getItem->rate:'')?></td>
                                            <td><?=$enquiryProduct->qty?></td>
                                            <td>
                                                <?php
                                                    $unit               = $common_model->find_data('ecomm_units', 'row', ['id' => $enquiryProduct->unit], 'name');
                                                    echo (($unit)?$unit->name:'');
                                                    ?>
                                            </td>
                                            <td><?=$enquiryProduct->remarks?></td>
                                            <td>
                                                <!-- <a href="" target="_blank"><img src="" class="img-thumbnail" style="width:100px; height: 100px;"></a> -->
                                                <!-- <p onclick="getImageModal(<?=$enquiryProduct->enq_id?>);"><i class="fas fa-image"></i></p> -->
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#enquiryImageModal<?=$enquiryProduct->id?>"><i class="fas fa-image"></i></button>
                                            </td>
                                            <td>
                                                <?php if($enquiryProduct->status){?>
                                                <span class="badge bg-success">APPROVED</span>
                                                <?php } else {?>
                                                <?php if($common_model->checkModuleFunctionAccess(23,108)){?>
                                                <span class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered<?=$enquiryProduct->id?>" data-backdrop="static" data-keyboard="false">CLICK TO APPROVED</span>
                                                <?php }?>
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
                <?php if($row->status >= 2){?>                                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Quotations </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                    <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th rowspan="2" class="text-center" style="vertical-align: middle;width: 10%;background: #a8e7ae;">Items</th>
                                            <?php
                                            if($sharedVendors) { foreach($sharedVendors as $sharedVendor){
                                                $getVendor = $common_model->find_data('ecomm_users', 'row', ['id' => $sharedVendor->vendor_id], 'id,company_name');
                                            ?>
                                                <th colspan="2" class="text-center w-25">
                                                    <span><?=(($getVendor)?$getVendor->company_name:'')?></span>
                                                    <?php if($sharedVendor->is_editable){?>
                                                        <a href="<?=base_url('admin/enquiry-requests/quotation-access/'.encoded($enq_id).'/'.encoded($sharedVendor->vendor_id))?>" title="Access Close" onclick="return confirm('Do you want to access close of quotation submit for this vendor ?');"><i class="fas fa-unlock text-success"></i></a>
                                                    <?php } else {?>
                                                        <a href="<?=base_url('admin/enquiry-requests/quotation-access/'.encoded($enq_id).'/'.encoded($sharedVendor->vendor_id))?>" title="Access Open" onclick="return confirm('Do you want to access open quotation submit for this vendor ?');"><i class="fas fa-lock text-danger"></i></a>
                                                    <?php }?>
                                                    <?php
                                                    $submittedDates         = [];
                                                    $checkQuotationSubmits  = $common_model->find_data('ecomm_enquiry_vendor_quotation_logs', 'array', ['enq_id' => $enq_id, 'vendor_id' => $sharedVendor->vendor_id, 'item_id' => $enquiryProducts[0]->product_id], 'created_at');
                                                    if($checkQuotationSubmits){
                                                        foreach($checkQuotationSubmits as $checkQuotationSubmit){
                                                            $submittedDates[]         = date_format(date_create($checkQuotationSubmit->created_at), "M d, Y h:i A");
                                                        }
                                                    }
                                                    ?>
                                                    <?php if(count($submittedDates) > 0){?>
                                                        <p>
                                                            <a href="<?=base_url('admin/enquiry-requests/view-quotation-logs/'.encoded($enq_id).'/'.encoded($sharedVendor->vendor_id))?>" target="_blank" class="badge bg-success"><small>Submitted : <?=count($submittedDates)?> time(s)</small></a>
                                                        </p>
                                                    <?php }?>
                                                </th>
                                            <?php } }?>
                                        </tr>
                                        <tr>
                                            <?php
                                            if($sharedVendors) { foreach($sharedVendors as $sharedVendor){
                                                $getVendor = $common_model->find_data('ecomm_users', 'row', ['id' => $sharedVendor->vendor_id], 'id,company_name');
                                            ?>
                                                <th colspan="2" style="text-align: center;background-color: darkgrey;">Unit Price</th>
                                                <!-- <th style="text-align: center;background-color: darkgrey;">Qty</th> -->
                                            <?php } }?>
                                        </tr>
                                        <?php
                                        if($enquiryProducts){ foreach($enquiryProducts as $enquiryProduct){
                                            $companyItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryProduct->product_id], 'id,item_name_ecoex');
                                        ?>
                                            <tr>
                                                <th rowspan="3" class="text-center" style="vertical-align: middle;"><?=(($companyItem)?$companyItem->item_name_ecoex:'')?></th>
                                            </tr>
                                            <tr>
                                                <?php
                                                if($sharedVendors) { foreach($sharedVendors as $sharedVendor){
                                                    $getVendor      = $common_model->find_data('ecomm_users', 'row', ['id' => $sharedVendor->vendor_id], 'id,company_name');
                                                    $getQuotePrice  = $common_model->find_data('ecomm_enquiry_vendor_quotations', 'row', ['enq_id' => $enq_id, 'vendor_id' => $sharedVendor->vendor_id, 'item_id' => $enquiryProduct->product_id, 'status' => 1], 'quote_price,qty,unit_name');
                                                ?>
                                                    <td style="text-align:center;" colspan="2">
                                                        <?php if($getQuotePrice){?>
                                                            <?php if($getQuotePrice->quote_price > 0){?>
                                                                <span><i class="fa fa-inr"></i> <?=$getQuotePrice->quote_price?> / <?=$getQuotePrice->unit_name?></span>
                                                            <?php } else {?>
                                                                <span>NA</span>
                                                            <?php }?>
                                                        <?php } else {?>
                                                            <small class="text-danger">Not Quote</small>
                                                        <?php }?>
                                                    </td>
                                                    <!-- <td style="text-align:center;">
                                                        <?php if($getQuotePrice){?>
                                                            <span><?=$getQuotePrice->qty?> <?=$getQuotePrice->unit_name?></span>
                                                        <?php } else {?>
                                                            <span class="text-danger">NA</span>
                                                        <?php }?>
                                                    </td> -->
                                                <?php } }?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if($sharedVendors) { foreach($sharedVendors as $sharedVendor){
                                                    $getVendor      = $common_model->find_data('ecomm_users', 'row', ['id' => $sharedVendor->vendor_id], 'id,company_name');
                                                    $vendor_name    = (($getVendor)?$getVendor->company_name:'');
                                                    $item_name      = (($companyItem)?$companyItem->item_name_ecoex:'');
                                                ?>
                                                    <td colspan="2" class="text-center">
                                                        <?php
                                                        $checkVendorAllocation = $common_model->find_data('ecomm_sub_enquires', 'row', ['enq_id' => $enq_id, 'item_id' => $enquiryProduct->product_id]);
                                                        if(empty($checkVendorAllocation)){
                                                        ?>
                                                            <?php
                                                            $getQuotePriceCount  = $common_model->find_data('ecomm_enquiry_vendor_quotations', 'count', ['enq_id' => $enq_id, 'vendor_id' => $sharedVendor->vendor_id, 'item_id' => $enquiryProduct->product_id, 'status' => 1, 'quote_price>' => 0]);
                                                            // pr($getQuotePrice,0);
                                                            if($getQuotePriceCount > 0){
                                                            ?>
                                                                <a href="<?=base_url('admin/enquiry-requests/vendor-allocation/'.encoded($enq_id).'/'.encoded($sharedVendor->vendor_id).'/'.encoded($enquiryProduct->product_id))?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to allocate <?=$vendor_name?> for <?=$item_name?> ?');"><i class="fa fa-trophy"></i> Mark As Assigned</a>
                                                            <?php }?>
                                                        <?php } else {?>
                                                            <?php if($checkVendorAllocation->vendor_id == $sharedVendor->vendor_id){?>
                                                                <!-- win -->
                                                                <h6 class="text-success fw-bold"><small>ASSIGNED</small></h6>
                                                                <small class="fw-bold"><?=$checkVendorAllocation->sub_enquiry_no?></small>
                                                            <?php } else {?>
                                                                <!-- lost -->
                                                                <h6 class="text-danger fw-bold"><small>NOT ASSIGNED</small></h6>
                                                            <?php }?>
                                                        <?php }?>
                                                    </td>
                                                <?php } }?>
                                            </tr>
                                        <?php } }?>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>

        <div class="material_accordion_section mt-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <?php if($subenquires){ $i=1; foreach($subenquires as $subenquiry){?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?=(($i == 1)?'active':'')?>" id="subenquiry-tab" data-bs-toggle="tab" data-bs-target="#subenquiry-<?=$subenquiry->id?>" type="button" role="tab" aria-controls="subenquiry" aria-selected="true"><?=$subenquiry->sub_enquiry_no?></button>
                    </li>
                <?php $i++; } }?>
            </ul>
            <div class="tab-content" id="myTabContent">
                <?php if($subenquires){ $i=1; foreach($subenquires as $subenquiry){?>
                    <?php
                    $getCompany     = $common_model->find_data('ecoex_companies', 'row', ['id' => $subenquiry->company_id], 'company_name');
                    $getVendor      = $common_model->find_data('ecomm_users', 'row', ['id' => $subenquiry->vendor_id], 'company_name');
                    $sub_enquiry_no = $subenquiry->sub_enquiry_no;
                    ?>
                    <div class="tab-pane fade <?=(($i == 1)?'show active':'')?>" id="subenquiry-<?=$subenquiry->id?>" role="tabpanel" aria-labelledby="subenquiry-tab">
                        <div class="row">
                            <div class="col-md-6">
                              <h5 class="fw-bold text-success">Enquiry No.</h5>
                              <h6><?=$subenquiry->sub_enquiry_no?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Company / Plant</h5>
                                <h6>
                                    <?=(($getCompany)?$getCompany->company_name:'')?><br>
                                    <?=(($getVendor)?$getVendor->company_name:'')?>
                                </h6>
                            </div>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button bg-success collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Pickup Scheduled </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Pickup Date/Time</th>
                                                <th>Submitted Date/Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $orderBy[0]                 = ['field' => 'id', 'type' => 'DESC'];
                                            $getPickupDates             = $common_model->find_data('ecomm_enquiry_vendor_pickup_schedule_logs', 'array', ['sub_enquiry_no' => $sub_enquiry_no], 'pickup_date_time,created_at', '', '', $orderBy);
                                            ?>
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
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button bg-success collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Vehicle Placed &nbsp;&nbsp; <span style="float: left; font-size: 14px">(1 vehicles placed)</span> </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Vehicle Number</th>
                                        <th>Vehicle Images</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td>1</td>
                                        <td>WB02AA2574</td>
                                        <td><div class="row">
                                            <div class="col-md-3"> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec0523dfcd6.jpg" download=""><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec0523dfcd6.jpg" class="img-thumbnail" style="height:100px;width: 100%;"></a> </div>
                                            <div class="col-md-3"> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec0523e15a9.jpg" download=""><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec0523e15a9.jpg" class="img-thumbnail" style="height:100px;width: 100%;"></a> </div>
                                            </div></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Material Weighted </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form method="POST" action="http://localhost/ecoex-commodity-trading/admin/enquiry-requests/modify-approve-material-weight">
                                    <input type="hidden" name="sub_enquiry_no" value="ECOMM-0000059-B">
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
                                        <tr>
                                            <td>1</td>
                                            <td>Digital Marketing</td>
                                            <td><span class="weight-label">75.00</span>
                                            <input type="text" name="weighted_qty[]" class="form-control weight-value" value="75.00" style="display: none;"></td>
                                            <td>Mar 09, 2024 12:18 PM</td>
                                            <td>Mar 09, 2024 12:32 PM</td>
                                            <td><div class="row">
                                                <div class="col-md-6"> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec063e972d1.jpg" download=""><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec063e972d1.jpg" class="img-thumbnail" style="height:100px;width: 100px;"></a> </div>
                                                <div class="col-md-6"> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec098b430ee.jpg" download=""><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec098b430ee.jpg" class="img-thumbnail" style="height:100px;width: 100px;"></a> </div>
                                            </div></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align:center;"><h6 class="badge bg-success">Material Weight Approved</h6></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </form>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> Invoice From HO </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row mt-3">
                                    <div class="col-md-6 text-center"> <a href="http://localhost/ecoex-commodity-trading/admin/enquiry-requests/request-invoice-to-HO-from-ecoex/NTk=/RUNPTU0tMDAwMDA1OS1C" class="btn btn-warning btn-sm" onclick="return confirm('Do you want to sent request for invoice to HO ?');"><i class="fa-solid fa-code-pull-request"></i> Request For Invoice To HO</a> </div>
                                    <div class="col-md-6 text-center"> </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $i++; } }?>
            </div>
        
        </div>
    </div>
  </div>
</section>

<!-- share to vendor modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Share Details To Vendors : <?=$row->enquiry_no?></strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="mode" value="share_vendor">
                        <input type="hidden" name="enq_id" value="<?=$row->id?>">
                        <input type="hidden" name="company_id" value="<?=$row->company_id?>">
                        <input type="hidden" name="plant_id" value="<?=$row->plant_id?>">
                        <div class="form-group">
                            <label for="choices-multiple-remove-button">Vendors</label>
                            <select name="vendors[]" id="choices-multiple-remove-button" multiple>
                                <?php if($avlVendors){ foreach($avlVendors as $avlvendor){?>
                                <?php
                                    $checkVendorShare = $common_model->find_data('ecomm_enquiry_vendor_shares', 'count', ['enq_id' => $row->id, 'vendor_id' => $avlvendor->id]);
                                    if($checkVendorShare <= 0){
                                    ?>
                                <option value="<?=$avlvendor->id?>"><?=$avlvendor->company_name?></option>
                                <?php }?>
                                <?php } }?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Share</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!-- share to vendor modal -->
<!-- item approve modal-->
    <?php if($enquiryPendingProducts){ $slNo=1; foreach($enquiryPendingProducts as $enquiryPendingProduct){?>
    <?php
        $getItem = $common_model->find_data('ecomm_company_items', 'row', ['enq_product_id' => $enquiryPendingProduct->id]);
        ?>
    <div class="modal fade" id="verticalycentered<?=$enquiryPendingProduct->id?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="<?=base_url('admin/companies/approve-item')?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enquiry Item Approve</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?=(($getItem)?encoded($getItem->id):'')?>">
                        <input type="hidden" name="redirect_link" value="<?=encoded(current_url())?>">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <select class="form-control" name="item_category[]" required>
                                    <option value="" selected>Select Category</option>
                                    <?php if($cats){ foreach($cats as $cat){?>
                                    <option value="<?=$cat->category_id?>"><?=$cat->category_alias?></option>
                                    <?php } }?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="item_name_ecoex[]" class="form-control" placeholder="Item Ecoex" value="<?=$getItem->item_name_ecoex?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="alias_name[]" class="form-control" placeholder="Alias Name" value="<?=$getItem->alias_name?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="billing_name[]" class="form-control" placeholder="Billing Name" value="<?=$getItem->billing_name?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="hsn[]" class="form-control" placeholder="HSN" value="<?=$getItem->hsn?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select class="form-control" name="gst[]" required>
                                    <option value="" selected>Select GST</option>
                                    <option value="0">0 %</option>
                                    <option value="5">5 %</option>
                                    <option value="12">12 %</option>
                                    <option value="18">18 %</option>
                                    <option value="28">28 %</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="rate[]" class="form-control" placeholder="Rate" value="<?=$getItem->rate?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select class="form-control" name="unit[]" required>
                                    <option value="" selected>Select Unit</option>
                                    <?php if($units){ foreach($units as $unit){?>
                                    <option value="<?=$unit->id?>" <?=(($unit->id == $enquiryPendingProduct->unit)?'selected':'')?>><?=$unit->name?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">APPROVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php } }?>
<!-- item approve modal-->
<!-- reject request modal -->
    <div class="modal fade" id="rejectRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="rejectRequestTitle">
                </div>
                <div class="modal-body" id="rejectRequestBody">
                </div>
            </div>
        </div>
    </div>
<!-- reject request modal -->
<!-- image modal -->
    <?php if($enquiryProducts){ $slNo=1; foreach($enquiryProducts as $enquiryProduct){?>
    <?php
        $enquiryImages      = [];
        $new_product_images = json_decode($enquiryProduct->new_product_image);
        if(!empty($new_product_images)){
            for($i=0;$i<count($new_product_images);$i++){
                $enquiryImages[]      = getenv('app.uploadsURL').'enquiry/'.$new_product_images[$i];
            }
        } 
        ?>
    <div class="modal fade" id="enquiryImageModal<?=$enquiryProduct->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="enquiryImageTitle">
                    Enquiry Item Images : <?=$row->enquiry_no?>
                </div>
                <div class="modal-body" id="enquiryImageBody">
                    <div id="" class="owl-carousel owl-theme owl-loaded home-successstories owl-drag">
                        <?php if(!empty($enquiryImages)){ for($enqImg=0;$enqImg<count($enquiryImages);$enqImg++){?>
                        <div class="item">
                            <div class="sucess_boximg">
                                <img src="<?=$enquiryImages[$enqImg]?>" class="img-fluid" alt="image">
                            </div>
                        </div>
                        <?php } }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } }?>
<!-- image modal -->
<script src="<?=getenv('app.adminAssetsURL');?>assets/js/progress-bar.js"></script>
<!-- progress bar -->
<?php if($row->status != 9){?>
<script type="text/javascript">
    //we can set animation delay as following in ms (default 1000)
    ProgressBar.singleStepAnimation = 700;
    ProgressBar.init(
      [   'Request Submitted',
          'Accept Request',
          'Vendor Allocated',
          'Vendor Assigned',
          'Pickup Scheduled',
          'Vehicle Placed',
          'Material Weighed',
          'Invoice from HO',
          'Invoice to Vendor',
          'Payment received from Vendor',
          'Vehicle Dispatched',
          'Payment to HO',
          'Order Complete',
          'Reject Request'
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
      [   'Request Submitted',
          'Reject Request'
      ],
      '<?=$enquiryStatus?>',
      'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
    );
</script>
<?php }?>
<script type="text/javascript">
    function getRejectModal(enq_id){
        let baseUrl = '<?=base_url()?>';
        $.ajax({
          type: "POST",
          data: { enq_id: enq_id },
          url: baseUrl+"/admin/get-reject-modal",
          dataType: "JSON",
          success: function(res){
            if(res.success){
              $('#rejectRequest').modal('show');
              $('#rejectRequestTitle').html(res.data.title);
              $('#rejectRequestBody').html(res.data.body);
            } else {
              $('#rejectRequest').modal('hide');
              $('#rejectRequestTitle').html('');
              $('#rejectRequestBody').html('');
            }
          }
        });
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){    
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount:30,
            searchResultLimit:30,
            renderChoiceLimit:30
        });     
    });
</script>
