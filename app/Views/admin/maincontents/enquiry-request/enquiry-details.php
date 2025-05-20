<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<style type="text/css">
    .choices__list--multiple .choices__item {
        background-color: #48974e;
        border: 1px solid #48974e;
    }

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

    .edit_request_item_name {
        cursor: pointer;
        text-decoration: none;
    }

    .edit_request_item_name:hover {
        /* text-decoration: underline; */
        font-size: large;
    }


    /* item name edit */
    .inline-popup {
        position: absolute;
        background: #fff;
        border: 1px solid #ccc;
        padding: 6px;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 1000;
    }

    .inline-popup .popup-input {
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 4px 6px;
        width: 150px;
    }

    .inline-popup .fa {
        cursor: pointer;
        font-size: 1.1em;
    }

    /* item name edit */

    .input-group-text {
        width: 160px;
        background-color: #fff;
        border: none;
    }
</style>

<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;


$request_edit_fields = [
    'item_name' => 'Item Name',
    'item_alias_name' => 'Alias Name (App)',
    'item_billing_name' => 'Billing Name',
    'item_hsn_code' => 'HSN Code',
    'item_gst' => 'GST',
    'item_rate' => 'Rate',
    // 'item_qty' => 'Quantity',
    // 'item_remarks' => 'Remarks'
];
?>
<div class="container-fluid">
    <div class="pagetitle">
        <h1>
            <?= $page_header ?>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">
                    <?= $page_header ?>
                </li>
            </ol>
        </nav>
    </div>
</div>
<section class="section">
    <div class="container-fluid">
        <div class="row">
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
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <!-- inquiry flow tracking -->
                        <?php
                        if ($row->status == 0) {
                            $enquiryStatus = 'Request Submitted';
                        } elseif ($row->status == 1) {
                            $enquiryStatus = 'Accept Request';
                        } elseif ($row->status == 2) {
                            $enquiryStatus = 'Vendor Allocated';
                        } elseif ($row->status == 3) {
                            $enquiryStatus = 'Vendor Assigned';
                        } elseif ($row->status == 4) {
                            $enquiryStatus = 'Pickup Scheduled';
                        } elseif ($row->status == 5) {
                            $enquiryStatus = 'Vehicle Placed';
                        } elseif ($row->status == 6) {
                            $enquiryStatus = 'Material Weighed';
                        } elseif ($row->status == 7) {
                            $enquiryStatus = 'Invoice from HO';
                        } elseif ($row->status == 8) {
                            $enquiryStatus = 'Invoice to Vendor';
                        } elseif ($row->status == 9) {
                            $enquiryStatus = 'Payment received from Vendor';
                        } elseif ($row->status == 10) {
                            $enquiryStatus = 'Vehicle Dispatched';
                        } elseif ($row->status == 11) {
                            $enquiryStatus = 'Payment to HO';
                        } elseif ($row->status == 12) {
                            $enquiryStatus = 'Order Complete';
                        } elseif ($row->status == 13) {
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
                            <?php if ($userType == 'MA') { ?>
                                <div class="col-md-12 mb-3">
                                    <?php if ($row->status == 0) { ?>
                                        <?php if ($common_model->checkModuleFunctionAccess(23, 110)) { ?>
                                            <a href="<?= base_url('admin/' . $controller_route . '/accept-request/' . encoded($row->$primary_key)) ?>" class="btn btn-success btn-sm" title="Accept <?= $title ?>" onclick="return confirm('Do You Want To Accept This <?= $title ?>');"><i class="fa fa-check"></i> Click To Accept</a>
                                        <?php } ?>
                                        <?php if ($common_model->checkModuleFunctionAccess(23, 111)) { ?>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Reject <?= $title ?>" onclick="getRejectModal(<?= $row->$primary_key ?>);"><i class="fa fa-times"></i> Click To Reject</a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if ($row->status >= 1 && $row->status <= 12) { ?>
                                            <h6 class="badge bg-success"><i class="fa fa-check-circle"></i> ACCEPTED</h6>
                                            <p><?= (($row->accepted_date != '') ? date_format(date_create($row->accepted_date), "M d, Y h:i A") : '') ?></p>
                                            <!-- share to vendors panel -->
                                            <p>
                                                <?php if ($row->status >= 1 && $row->status <= 5) { ?>
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 116)) { ?>
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#shareModal"><i class="fa fa-share-alt"></i> Quotation Invitation To Vendors</button>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($common_model->checkModuleFunctionAccess(23, 117)) { ?>
                                                    <a data-bs-toggle="collapse" href="#sharedVendor" role="button" aria-expanded="false" aria-controls="sharedVendor" class="btn btn-primary btn-sm"><i class="fa fa-list-alt"></i> Click To View The Quotation Request Invited Vendors</a>
                                                    <?php $sharedLink = base_url('enquiry-request/' . encoded($row->id)); ?>
                                                <?php } ?>

                                                <?php $sharedLink = base_url('enquiry-request/' . encoded($row->id)); ?>
                                                <!-- <a href="whatsapp://send?text=<?= $sharedLink ?>" class="btn btn-warning btn-sm" data-action="share/whatsapp/share"><i class="fa fa-share-alt"></i> Share Details To Vendors via Whatsapp</a>
                                                <a href="" class="btn btn-warning btn-sm" onclick="copyToClipboard()"><i class="fa fa-copy"></i> Copy Whatsapp Link For Share</a>
                                                <span id="whatsapp_link" style="display: none;"><?= $sharedLink ?></span>
                                                <input type="hidden" placeholder="Paste here" /> -->
                                            </p>
                                            <div class="collapse" id="sharedVendor">
                                                <div class="card">
                                                    <div class="card-header bg-success text-light">
                                                        <h5>Enquiry Quotation Request Invited Vendors</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table globel_table">
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
                                                                    $conditions = [
                                                                        'enq_id' => $row->id,
                                                                        'status !=' => 3
                                                                    ];
                                                                    $invitedVendors = $common_model->find_data('ecomm_enquiry_vendor_shares', 'array', $conditions);
                                                                    if ($invitedVendors) {
                                                                        $sl = 1;
                                                                        foreach ($invitedVendors as $invitedVendor) {
                                                                            $getVendor = $common_model->find_data('ecomm_users', 'row', ['id' => $invitedVendor->vendor_id, 'type' => 'VENDOR'], 'gst_no,company_name,full_address,email,phone');
                                                                    ?>
                                                                            <tr>
                                                                                <td><?= $sl++ ?></td>
                                                                                <td><?= (($getVendor) ? $getVendor->company_name : '') ?></td>
                                                                                <td><?= (($getVendor) ? $getVendor->email : '') ?></td>
                                                                                <td><?= (($getVendor) ? $getVendor->phone : '') ?></td>
                                                                                <td><?= (($getVendor) ? $getVendor->gst_no : '') ?></td>
                                                                                <td><?= (($getVendor) ? $getVendor->full_address : '') ?></td>
                                                                                <td>
                                                                                    <?php if ($invitedVendor->status == 0) { ?>
                                                                                        <span class="badge bg-warning"><i class="fa-solid fa-clock"></i> PENDING</span>
                                                                                    <?php } elseif ($invitedVendor->status == 1) { ?>
                                                                                        <span class="badge bg-success"><i class="fa-solid fa-check-circle"></i> ACCEPTED</span>
                                                                                    <?php } elseif ($invitedVendor->status == 3) { ?>
                                                                                        <span class="badge bg-danger"><i class="fa-solid fa-times-circle"></i> REJECTED</span>
                                                                                    <?php } elseif ($invitedVendor->status == 4) { ?>
                                                                                        <?php if ($invitedVendor->is_quit_admin_approval == 1) { ?>
                                                                                            <span class="badge bg-danger"><i class="fa-solid fa-power-off"></i> QUITED</span>
                                                                                        <?php } elseif ($invitedVendor->is_quit_admin_approval == 0) { ?>
                                                                                            <a href="<?= base_url('admin/enquiry-requests/approve-vendor-quit/' . encoded($invitedVendor->enq_id) . '/' . encoded($invitedVendor->vendor_id)) ?>" class="btn btn-success btn-sm">Approve Quit</a>
                                                                                            <a href="<?= base_url('admin/enquiry-requests/reject-vendor-quit/' . encoded($invitedVendor->enq_id) . '/' . encoded($invitedVendor->vendor_id)) ?>" class="btn btn-danger btn-sm">Reject Quit</a>
                                                                                        <?php } elseif ($invitedVendor->is_quit_admin_approval == 3) { ?>
                                                                                            <span class="badge bg-danger"><i class="fa-solid fa-power-off"></i> QUIT REJECTED</span>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php if ($invitedVendor->status == 0) { ?>
                                                                                        <span class="text-warning fw-bold">Yet Not Action</span>
                                                                                    <?php } elseif ($invitedVendor->status == 1) { ?>
                                                                                        <span class="text-success fw-bold"><?= date_format(date_create($invitedVendor->updated_at), "M d, Y h:i A") ?></span>
                                                                                    <?php } elseif ($invitedVendor->status == 3) { ?>
                                                                                        <span class="text-danger fw-bold"><?= date_format(date_create($invitedVendor->updated_at), "M d, Y h:i A") ?></span>
                                                                                    <?php } elseif ($invitedVendor->status == 4) { ?>
                                                                                        <span class="text-danger fw-bold"><?= date_format(date_create($invitedVendor->updated_at), "M d, Y h:i A") ?></span>
                                                                                    <?php } ?>
                                                                                </td>
                                                                            </tr>
                                                                    <?php }
                                                                    } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- share to vendors panel -->
                                        <?php } elseif ($row->status == 13) { ?>
                                            <h6 class="badge bg-danger"><i class="fa fa-times-circle"></i> REJECTED</h6>
                                            <p><?= (($row->accepted_date != '') ? date_format(date_create($row->accepted_date), "M d, Y h:i A") : '') ?></p>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Company Name</h5>
                                <h6>
                                    <?php
                                    $getCompany = $common_model->find_data('ecoex_companies', 'row', ['id' => $row->company_id], 'company_name');
                                    echo (($getCompany) ? $getCompany->company_name : '');
                                    ?>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Plant Name</h5>
                                <h6>
                                    <?php
                                    $getPlant = $common_model->find_data('ecomm_users', 'row', ['id' => $row->plant_id], 'plant_name');
                                    echo (($getPlant) ? $getPlant->plant_name : '');
                                    ?>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">GPS Tracking Image</h5>
                                <h6>
                                    <div class="popup_gallery">
                                        <?php if ($row->gps_tracking_image != '') { ?>
                                            <a href="<?= getenv('app.uploadsURL') . 'enquiry/' . $row->gps_tracking_image ?>" target="_blank"><img src="<?= getenv('app.uploadsURL') . 'enquiry/' . $row->gps_tracking_image ?>" alt="<?= $row->enquiry_no ?>" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;"></a>
                                        <?php } else { ?>
                                            <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $row->enquiry_no ?>" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;">
                                        <?php } ?>
                                    </div>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Tentative Collection Date</h5>
                                <h6><?= date_format(date_create($row->tentative_collection_date), "M d, Y") ?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Latitude</h5>
                                <h6><?= $row->latitude ?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Device Brand</h5>
                                <h6><?= $row->device_brand ?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Longitude</h5>
                                <h6><?= $row->longitude ?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Device Model</h5>
                                <h6><?= $row->device_model ?></h6>
                            </div>
                            <?php if ($subenquires) { ?>
                                <div class="col-md-6">
                                    <h5 class="fw-bold text-success">Assigned Date</h5>
                                    <h6><?= date_format(date_create($subenquires[0]->assigned_date), "M d, Y h:i A") ?></h6>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="fw-bold text-success">Pickup Scheduled Date</h5>
                                    <h6>
                                        <?php
                                        if ($subenquires[0]->is_pickup_final) {
                                            echo date_format(date_create($subenquires[0]->pickup_scheduled_date), "M d, Y h:i A");
                                        }
                                        ?>
                                    </h6>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>


                <div class="material_accordion_section">
                    <div class="accordion" id="accordionExample">
                        <?php if ($common_model->checkModuleFunctionAccess(23, 118)) { ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Enquiry Request Items </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table globel_table">
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
                                                        <?php if (($userType == 'MA' && $row->status == 1)): ?>
                                                            <th></th>
                                                        <?php endif ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($enquiryProducts) {
                                                        $slNo = 1;
                                                        foreach ($enquiryProducts as $enquiryProduct) {

                                                            if ($enquiryProduct->new_product) {
                                                                $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryProduct->product_id], 'id,item_category,item_name_ecoex,alias_name,billing_name,item_images,hsn,gst,rate,unit');
                                                                if ($getItem) {
                                                                    $productName    = (($getItem) ? $getItem->item_name_ecoex : '');
                                                                    $productHSNCode = (($getItem) ? $getItem->hsn : '');
                                                                } else {
                                                                    $productName    = $enquiryProduct->new_product_name;
                                                                    $productHSNCode = $enquiryProduct->new_hsn;
                                                                }
                                                                // $productImage   = (($enquiryProduct->new_product_image != '')?getenv('app.uploadsURL').'enquiry/'.$enquiryProduct->new_product_image:getenv('app.NO_IMG'));
                                                            } else {
                                                                $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryProduct->product_id], 'id,item_category,item_name_ecoex,alias_name,billing_name,item_images,hsn,gst,rate,unit');
                                                                $productName    = (($getItem) ? $getItem->item_name_ecoex : '');
                                                                $productHSNCode = (($getItem) ? $getItem->hsn : '');
                                                                // $productImage   = (($getItem)?(($getItem->product_image != '')?getenv('app.uploadsURL').'enquiry/'.$getItem->product_image:$getItem->product_image):getenv('app.NO_IMG'));
                                                            }


                                                            if ($enquiryProduct->status) {
                                                                $bgColor = '#0080001a';
                                                            } else {
                                                                $bgColor = '#ff00001c';
                                                            }
                                                            ### @Shubha75 ###
                                                    ?>
                                                            <tr style="background-color: <?= $bgColor ?>;">
                                                                <th><?= $slNo++ ?></th>
                                                                <td>
                                                                    <?php
                                                                    if ($getItem) {
                                                                        $itemCategory               = $common_model->find_data('ecomm_product_categories', 'row', ['id' => $getItem->item_category], 'name');
                                                                        echo (($itemCategory) ? $itemCategory->name : '');
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td id="set_request_item_name<?= $enquiryProduct->product_id ?>">
                                                                    <?= $productName ?>
                                                                    <!-- <span class="fw-bold <?= ($userType == 'MA' && $row->status == 1) ? 'edit_request_item_name' : '' ?>" data-product_id='<?= $enquiryProduct->product_id ?>' id="set_request_item_name<?= $enquiryProduct->product_id ?>"><?= $productName ?></span><br> -->
                                                                    <!-- <a data-bs-toggle="collapse" href="#viewQuotations<?= $enquiryProduct->id ?>" role="button" aria-expanded="false" aria-controls="viewQuotations<?= $enquiryProduct->id ?>" class="badge bg-primary"><i class="fa fa-list-alt"></i> Click To View The Quotations</a> -->
                                                                    <!-- quotaion list -->
                                                                    <!-- quotaion list -->
                                                                </td>
                                                                <td id="set_request_alias_name<?= $enquiryProduct->product_id ?>">
                                                                    <?= (($getItem) ? $getItem->alias_name : '') ?>
                                                                </td>
                                                                <td id="set_request_billing_name<?= $enquiryProduct->product_id ?>">
                                                                    <?= (($getItem) ? $getItem->billing_name : '') ?>
                                                                </td>
                                                                <td id="set_request_HSN_code<?= $enquiryProduct->product_id ?>">
                                                                    <?= $productHSNCode ?>
                                                                </td>
                                                                <td id="set_request_gst<?= $enquiryProduct->product_id ?>">
                                                                    <?= (($getItem) ? $getItem->gst : '') ?>
                                                                </td>
                                                                <td id="set_request_rate<?= $enquiryProduct->product_id ?>">
                                                                    <?= (($getItem) ? $getItem->rate : '') ?>
                                                                </td>
                                                                <td id="set_request_qty<?= $enquiryProduct->product_id ?>">
                                                                    <?= $enquiryProduct->qty ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $unit               = $common_model->find_data('ecomm_units', 'row', ['id' => $getItem->unit], 'name');
                                                                    echo (($unit) ? $unit->name : '');
                                                                    ?>
                                                                </td>
                                                                <td id="set_request_remarks<?= $enquiryProduct->product_id ?>">
                                                                    <?= $enquiryProduct->remarks ?>
                                                                </td>
                                                                <td>
                                                                    <!-- <a href="" target="_blank"><img src="" class="img-thumbnail" style="width:100px; height: 100px;"></a> -->
                                                                    <!-- <p onclick="getImageModal(<?= $enquiryProduct->enq_id ?>);"><i class="fas fa-image"></i></p> -->
                                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#enquiryImageModal<?= $enquiryProduct->id ?>"><i class="fas fa-image"></i></button>
                                                                </td>
                                                                <td>
                                                                    <?php if ($enquiryProduct->status) { ?>
                                                                        <span class="badge bg-success">APPROVED</span>
                                                                    <?php } else { ?>
                                                                        <?php if ($common_model->checkModuleFunctionAccess(23, 108)) { ?>
                                                                            <span class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered<?= $enquiryProduct->id ?>" data-backdrop="static" data-keyboard="false">CLICK TO APPROVED</span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </td>
                                                                <?php if (($userType == 'MA' && $row->status == 1)): ?>
                                                                    <td>
                                                                        <span class="badge bg-warning  accepted_request_edit"
                                                                            style="cursor:pointer"
                                                                            data-product_id="<?= $enquiryProduct->product_id ?>"
                                                                            data-category="<?= $getItem->item_category ?>"
                                                                            data-unit="<?= $getItem->unit ?>">
                                                                            <i class="fas fa-pencil-alt"></i> Edit</span>
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($row->status >= 2) { ?>
                            <?php if ($userType == 'MA') { ?>
                                <?php if ($common_model->checkModuleFunctionAccess(23, 119)) { ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Quotations </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table globel_table">
                                                        <tr>
                                                            <th rowspan="2" class="text-center" style="vertical-align: middle;width: 10%;background: #a8cf45; color: #fff;">Items</th>
                                                            <?php
                                                            if ($sharedVendors) {
                                                                foreach ($sharedVendors as $sharedVendor) {
                                                                    $getVendor = $common_model->find_data('ecomm_users', 'row', ['id' => $sharedVendor->vendor_id], 'id,company_name');
                                                            ?>
                                                                    <th colspan="2" class="text-center w-25">
                                                                        <span><?= (($getVendor) ? $getVendor->company_name : '') ?></span>
                                                                        <?php if ($sharedVendor->is_editable) { ?>
                                                                            <a href="<?= base_url('admin/enquiry-requests/quotation-access/' . encoded($enq_id) . '/' . encoded($sharedVendor->vendor_id)) ?>" title="Access Close" onclick="return confirm('Do you want to access close of quotation submit for this vendor ?');"><i class="fas fa-unlock text-success"></i></a>
                                                                        <?php } else { ?>
                                                                            <a href="<?= base_url('admin/enquiry-requests/quotation-access/' . encoded($enq_id) . '/' . encoded($sharedVendor->vendor_id)) ?>" title="Access Open" onclick="return confirm('Do you want to access open quotation submit for this vendor ?');"><i class="fas fa-lock text-danger"></i></a>
                                                                        <?php } ?>
                                                                        <?php
                                                                        $submittedDates         = [];
                                                                        $checkQuotationSubmits  = $common_model->find_data('ecomm_enquiry_vendor_quotation_logs', 'array', ['enq_id' => $enq_id, 'vendor_id' => $sharedVendor->vendor_id, 'item_id' => $enquiryProducts[0]->product_id], 'created_at');
                                                                        if ($checkQuotationSubmits) {
                                                                            foreach ($checkQuotationSubmits as $checkQuotationSubmit) {
                                                                                $submittedDates[]         = date_format(date_create($checkQuotationSubmit->created_at), "M d, Y h:i A");
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <?php if (count($submittedDates) > 0) { ?>
                                                                            <p>
                                                                                <a href="<?= base_url('admin/enquiry-requests/view-quotation-logs/' . encoded($enq_id) . '/' . encoded($sharedVendor->vendor_id)) ?>" target="_blank" class="badge bg-success"><small>Submitted : <?= count($submittedDates) ?> time(s)</small></a>
                                                                            </p>
                                                                        <?php } ?>
                                                                    </th>
                                                            <?php }
                                                            } ?>
                                                        </tr>
                                                        <tr>
                                                            <?php
                                                            if ($sharedVendors) {
                                                                foreach ($sharedVendors as $sharedVendor) {
                                                                    $getVendor = $common_model->find_data('ecomm_users', 'row', ['id' => $sharedVendor->vendor_id], 'id,company_name');
                                                            ?>
                                                                    <th colspan="2" style="text-align: center;background-color: darkgrey;">Unit Price</th>
                                                                    <!-- <th style="text-align: center;background-color: darkgrey;">Qty</th> -->
                                                            <?php }
                                                            } ?>
                                                        </tr>
                                                        <?php
                                                        if ($enquiryProducts) {
                                                            foreach ($enquiryProducts as $enquiryProduct) {
                                                                $companyItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryProduct->product_id], 'id,item_name_ecoex');
                                                        ?>
                                                                <tr>
                                                                    <th rowspan="3" class="text-center" style="vertical-align: middle;"><?= (($companyItem) ? $companyItem->item_name_ecoex : '') ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <?php
                                                                    if ($sharedVendors) {
                                                                        foreach ($sharedVendors as $sharedVendor) {
                                                                            $getVendor      = $common_model->find_data('ecomm_users', 'row', ['id' => $sharedVendor->vendor_id], 'id,company_name');
                                                                            $getQuotePrice  = $common_model->find_data('ecomm_enquiry_vendor_quotations', 'row', ['enq_id' => $enq_id, 'vendor_id' => $sharedVendor->vendor_id, 'item_id' => $enquiryProduct->product_id, 'status' => 1], 'quote_price,qty,unit_name');
                                                                    ?>
                                                                            <td style="text-align:center;" colspan="2">
                                                                                <?php if ($getQuotePrice) { ?>
                                                                                    <?php if ($getQuotePrice->quote_price > 0) { ?>
                                                                                        <span><i class="fa fa-inr"></i> <?= $getQuotePrice->quote_price ?> / <?= $getQuotePrice->unit_name ?></span>
                                                                                    <?php } else { ?>
                                                                                        <span class="text-danger">NA</span>
                                                                                    <?php } ?>
                                                                                <?php } else { ?>
                                                                                    <small class="text-danger">Not Quote</small>
                                                                                <?php } ?>
                                                                            </td>
                                                                            <!-- <td style="text-align:center;">
                                                                        <?php if ($getQuotePrice) { ?>
                                                                            <span><?= $getQuotePrice->qty ?> <?= $getQuotePrice->unit_name ?></span>
                                                                        <?php } else { ?>
                                                                            <span class="text-danger">NA</span>
                                                                        <?php } ?>
                                                                    </td> -->
                                                                    <?php }
                                                                    } ?>
                                                                </tr>
                                                                <tr>
                                                                    <?php
                                                                    if ($sharedVendors) {
                                                                        foreach ($sharedVendors as $sharedVendor) {
                                                                            $getVendor      = $common_model->find_data('ecomm_users', 'row', ['id' => $sharedVendor->vendor_id], 'id,company_name');
                                                                            $vendor_name    = (($getVendor) ? $getVendor->company_name : '');
                                                                            $item_name      = (($companyItem) ? $companyItem->item_name_ecoex : '');
                                                                    ?>
                                                                            <td colspan="2" class="text-center">
                                                                                <?php
                                                                                $checkVendorAllocation = $common_model->find_data('ecomm_sub_enquires', 'row', ['enq_id' => $enq_id, 'item_id' => $enquiryProduct->product_id]);
                                                                                if (empty($checkVendorAllocation)) {
                                                                                ?>
                                                                                    <?php
                                                                                    $getQuotePriceCount  = $common_model->find_data('ecomm_enquiry_vendor_quotations', 'count', ['enq_id' => $enq_id, 'vendor_id' => $sharedVendor->vendor_id, 'item_id' => $enquiryProduct->product_id, 'status' => 1, 'quote_price>' => 0]);
                                                                                    // pr($getQuotePrice,0);
                                                                                    if ($getQuotePriceCount > 0) {
                                                                                    ?>
                                                                                        <?php if ($common_model->checkModuleFunctionAccess(23, 120)) { ?>
                                                                                            <a href="<?= base_url('admin/enquiry-requests/vendor-allocation/' . encoded($enq_id) . '/' . encoded($sharedVendor->vendor_id) . '/' . encoded($enquiryProduct->product_id)) ?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to allocate <?= $vendor_name ?> for <?= $item_name ?> ?');"><i class="fa fa-trophy"></i> Mark As Assigned</a>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                <?php } else { ?>
                                                                                    <?php if ($checkVendorAllocation->vendor_id == $sharedVendor->vendor_id) { ?>
                                                                                        <!-- win -->
                                                                                        <h6 class="text-success fw-bold"><small>ASSIGNED</small></h6>
                                                                                        <small class="fw-bold"><?= $checkVendorAllocation->sub_enquiry_no ?></small>
                                                                                    <?php } else { ?>
                                                                                        <!-- lost -->
                                                                                        <h6 class="text-danger fw-bold"><small>NOT ASSIGNED</small></h6>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </td>
                                                                    <?php }
                                                                    } ?>
                                                                </tr>
                                                        <?php }
                                                        } ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>


                <div class="material_accordion_section mt-3">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php if ($subenquires) {
                            $i = 1;
                            foreach ($subenquires as $subenquiry) { ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= (($i == 1) ? 'active' : '') ?>" id="subenquiry-tab" data-bs-toggle="tab" data-bs-target="#subenquiry-<?= $subenquiry->id ?>" type="button" role="tab" aria-controls="subenquiry" aria-selected="true"><?= $subenquiry->sub_enquiry_no ?></button>
                                </li>
                        <?php $i++;
                            }
                        } ?>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <?php if ($subenquires) {
                            $i = 1;
                            foreach ($subenquires as $subenquiry) { ?>
                                <?php
                                $getCompany     = $common_model->find_data('ecoex_companies', 'row', ['id' => $subenquiry->company_id], 'company_name');
                                $getPlant       = $common_model->find_data('ecomm_users', 'row', ['id' => $subenquiry->plant_id], 'plant_name');
                                $getVendor      = $common_model->find_data('ecomm_users', 'row', ['id' => $subenquiry->vendor_id], 'company_name');
                                $sub_enquiry_no = $subenquiry->sub_enquiry_no;
                                ?>
                                <div class="tab-pane fade <?= (($i == 1) ? 'show active' : '') ?>" id="subenquiry-<?= $subenquiry->id ?>" role="tabpanel" aria-labelledby="subenquiry-tab">
                                    <div class="row">
                                        <?php if ($userType == 'MA') { ?>
                                            <div class="col-md-3">
                                                <h5 class="fw-bold text-success">Company</h5>
                                                <h6>
                                                    <?= (($getCompany) ? $getCompany->company_name : '') ?>
                                                </h6>
                                            </div>
                                            <div class="col-md-3">
                                                <h5 class="fw-bold text-success">Plant</h5>
                                                <h6>
                                                    <?= (($getPlant) ? $getPlant->plant_name : '') ?>
                                                </h6>
                                            </div>
                                            <div class="col-md-3">
                                                <h5 class="fw-bold text-success">Vendor</h5>
                                                <h6>
                                                    <?= (($getVendor) ? $getVendor->company_name : '') ?>
                                                </h6>
                                            </div>
                                            <div class="col-md-3">
                                                <h5 class="fw-bold text-success">Is Quit</h5>
                                                <h6>
                                                    <?php if ($subenquiry->is_vendor_quit) { ?>
                                                        <a href="<?= base_url('admin/enquiry-requests/sub-enquiry-quit/' . $subenquiry->is_vendor_quit . '/' . $subenquiry->sub_enquiry_no . '/' . $subenquiry->enq_id) ?>" class="badge bg-danger">Click to cancel quit</a>
                                                        <h6><?= date_format(date_create($subenquiry->vendor_quit_timestamp), "M d, Y h:i A") ?></h6>
                                                    <?php } else { ?>
                                                        <a href="<?= base_url('admin/enquiry-requests/sub-enquiry-quit/' . $subenquiry->is_vendor_quit . '/' . $subenquiry->sub_enquiry_no . '/' . $subenquiry->enq_id) ?>" class="badge bg-success">Click to quit</a>
                                                    <?php } ?>
                                                </h6>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-6">
                                                <h5 class="fw-bold text-success">Company</h5>
                                                <h6>
                                                    <?= (($getCompany) ? $getCompany->company_name : '') ?>
                                                </h6>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="fw-bold text-success">Plant</h5>
                                                <h6>
                                                    <?= (($getPlant) ? $getPlant->plant_name : '') ?>
                                                </h6>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="accordion" id="accordionExample">
                                        <?php if ($userType == 'MA') { ?>
                                            <?php if ($common_model->checkModuleFunctionAccess(23, 124)) { ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading2">
                                                        <button class="accordion-button bg-success collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2"> Pickup Scheduled </button>
                                                    </h2>
                                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="table-responsive">
                                                                <table class="table globel_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Pickup Date/Time</th>
                                                                            <th>Pickup Schedule Remarks</th>
                                                                            <th>Submitted Date/Time</th>
                                                                            <th>Pickup Scheduled Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $orderBy[0]                 = ['field' => 'id', 'type' => 'DESC'];
                                                                        $getPickupDates             = $common_model->find_data('ecomm_enquiry_vendor_pickup_schedule_logs', 'array', ['sub_enquiry_no' => $sub_enquiry_no], 'pickup_date_time,created_at', '', '', $orderBy);
                                                                        ?>
                                                                        <?php if ($getPickupDates) {
                                                                            $sl = 1;
                                                                            foreach ($getPickupDates as $getPickupDate) { ?>
                                                                                <tr>
                                                                                    <td><?= $sl ?></td>
                                                                                    <td><?= date_format(date_create($getPickupDate->pickup_date_time), "M d, Y h:i A") ?></td>
                                                                                    <td>
                                                                                        <?php if ($sl == 1) { ?>
                                                                                            <?php if ($subenquiry->status == 3.3) { ?>
                                                                                                <form method="POST" action="" style="border: 1px solid #00885838;padding: 15px;border-radius: 15px;">
                                                                                                    <input type="hidden" name="mode" value="remarks">
                                                                                                    <input type="hidden" name="sub_enquiry_no" value="<?= $subenquiry->sub_enquiry_no ?>">
                                                                                                    <textarea class="form-control mb-3" name="pickup_schedule_remarks" placeholder="Enter Remarks"><?= $subenquiry->pickup_schedule_remarks ?></textarea>
                                                                                                    <button type="submit" class="btn btn-info btn-sm">Submit</button>
                                                                                                </form>
                                                                                            <?php } else { ?>
                                                                                                <?= $subenquiry->pickup_schedule_remarks ?>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    <td><?= date_format(date_create($getPickupDate->created_at), "M d, Y h:i A") ?></td>
                                                                                    <td>
                                                                                        <?php if ($sl == 1) { ?>
                                                                                            <?php
                                                                                            if ($subenquiry->is_pickup_final) {
                                                                                                echo date_format(date_create($subenquiry->pickup_scheduled_date), "M d, Y h:i A");
                                                                                            } else {
                                                                                            ?>
                                                                                                <h6 class="text-warning">Still Not Finalised</h6>
                                                                                                <p>
                                                                                                    <?php if ($subenquiry->pickup_schedule_edit_access) { ?>
                                                                                                        <a href="<?= base_url('admin/' . $controller_route . '/change-status-pickup-edit-access/' . encoded($subenquiry->sub_enquiry_no) . '/' . encoded(current_url())) ?>" class="btn btn-success btn-sm" title="Pickup Scheduled Edit Access Off" onclick="return confirm('Do you want to off pickup Scheduled edit access ?');"><i class="fa fa-check"></i> Pickup Schedule Edit Access On</a>
                                                                                                    <?php } else { ?>
                                                                                                        <a href="<?= base_url('admin/' . $controller_route . '/change-status-pickup-edit-access/' . encoded($subenquiry->sub_enquiry_no) . '/' . encoded(current_url())) ?>" class="btn btn-danger btn-sm" title="Pickup Scheduled Edit Access On" onclick="return confirm('Do you want to off pickup Scheduled edit access ?');"><i class="fa fa-times"></i> Pickup Schedule Edit Access Off</a>
                                                                                                    <?php } ?>
                                                                                                    <?php if ($subenquiry->pickup_scheduled_date != '') { ?>
                                                                                                        <a href="<?= base_url('admin/' . $controller_route . '/final-pickup-scheduled/' . encoded($subenquiry->sub_enquiry_no) . '/' . encoded(current_url())) ?>" class="btn btn-primary btn-sm" title="Final Pickup Scheduled <?= $title ?>" onclick="return confirm('Do you want to finalize this date of pickup material from vendor end ?');"><i class="fa fa-eye"></i> Make Final</a>
                                                                                                    <?php } ?>
                                                                                                </p>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php $sl++;
                                                                            }
                                                                        } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($common_model->checkModuleFunctionAccess(23, 125)) { ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button bg-success collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Vehicle Placed &nbsp;&nbsp; <span style="float: left; font-size: 14px">(<?= (($subenquiry) ? $subenquiry->no_of_vehicle : 0) ?> vehicles placed)</span> </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="table-responsive">
                                                                <table class="table globel_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Vehicle Number</th>
                                                                            <th>Vehicle Images</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $no_of_vehicle                      = (($subenquiry) ? $subenquiry->no_of_vehicle : 0);
                                                                        $vehicle_registration_nos           = (($subenquiry) ? json_decode($subenquiry->vehicle_registration_nos) : []);
                                                                        $vehicle_images                     = (($subenquiry) ? json_decode($subenquiry->vehicle_images) : []);
                                                                        $vehicles                           = [];
                                                                        if ($no_of_vehicle > 0) {
                                                                            for ($v = 0; $v < $no_of_vehicle; $v++) {
                                                                                $vehImags = [];
                                                                                if (count($vehicle_images[$v])) {
                                                                                    for ($p = 0; $p < count($vehicle_images[$v]); $p++) {
                                                                                        $vehImags[] = base_url('public/uploads/enquiry/' . $vehicle_images[$v][$p]);
                                                                                    }
                                                                                }
                                                                                $vehicles[] = [
                                                                                    'vehicle_no'    => $vehicle_registration_nos[$v],
                                                                                    'vehicle_img'   => $vehImags,
                                                                                ];
                                                                            }
                                                                        }
                                                                        $vehicles           = $vehicles;
                                                                        ?>
                                                                        <?php if ($vehicles) {
                                                                            $sl = 1;
                                                                            foreach ($vehicles as $vehicle) { ?>
                                                                                <tr>
                                                                                    <td><?= $sl++ ?></td>
                                                                                    <td><?= $vehicle['vehicle_no'] ?></td>
                                                                                    <td>
                                                                                        <div class="row">

                                                                                            <?php if ($vehicle['vehicle_img']) {
                                                                                                for ($v = 0; $v < count($vehicle['vehicle_img']); $v++) { ?>
                                                                                                    <div class="col-md-3 popup_gallery">
                                                                                                        <a href="<?= $vehicle['vehicle_img'][$v] ?>" download><img src="<?= $vehicle['vehicle_img'][$v] ?>" class="img-thumbnail" style="height:100px;width: 100%;"></a>
                                                                                                    </div>
                                                                                            <?php }
                                                                                            } ?>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php }
                                                                        } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($common_model->checkModuleFunctionAccess(23, 123)) { ?>
                                                <?php if ($row->status >= 5) {

                                                ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingFour">
                                                            <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Material Weighted </button>
                                                        </h2>
                                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <form method="POST" action="<?= base_url('admin/enquiry-requests/modify-approve-material-weight') ?>">
                                                                    <input type="hidden" name="sub_enquiry_no" value="<?= $sub_enquiry_no ?>">

                                                                    <div class="table-responsive">

                                                                        <table class="table globel_table">
                                                                            <thead>
                                                                                <!-- @Shubha75  new code  -->
                                                                                <tr class="text-center w-25">

                                                                                    <th rowspan="<?= ceil(count($vendors) / 7) ?>" class="text-center" style="vertical-align: middle;width: 10%;background: #a8cf45; color: #fff;">
                                                                                        Vendors
                                                                                    </th>

                                                                                    <?php foreach ($vendors as $index => $vendor): ?>
                                                                                        <?php if ($index > 0 && $index % 7 == 0): ?>
                                                                                </tr>
                                                                                <tr class="text-center w-25">
                                                                                <?php endif; ?>

                                                                                <td class="key">
                                                                                    <span><?= $vendor->company_name ?> (vendor)</span>

                                                                                    <?php if ($vendor->material_weighing_edit_vendor == 1) { ?>
                                                                                        <a href="<?= base_url('admin/enquiry-requests/material-weighted-access/' . encoded($enq_id) . '/' . encoded($vendor->vendor_id)) ?>" title="Access Open" onclick="return confirm('Do you want to access close of weighted info submit for this vendor ?');"><i class="fas fa-unlock text-success"></i></a>
                                                                                    <?php } else { ?>
                                                                                        <a href="<?= base_url('admin/enquiry-requests/material-weighted-access/' . encoded($enq_id) . '/' . encoded($vendor->vendor_id)) ?>" title="Access Close" onclick="return confirm('Do you want to access open weighted info submit for this vendor ?');"><i class="fas fa-lock text-danger"></i></a>
                                                                                    <?php } ?>

                                                                                    <p>
                                                                                        <a class="badge bg-success"><small>Submitted : <?= $vendor->submitted_times ?> time(s)</small></a>
                                                                                    </p>
                                                                                </td>
                                                                            <?php endforeach; ?>
                                                                                </tr>
                                                                                <!-- @Shubha75  new code end -->
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Item Name<br>(Ecoex)</th>
                                                                                    <th>Alias<br>(App)</th>
                                                                                    <th>Billing<br>Name</th>
                                                                                    <th>Weighted Qty</th>
                                                                                    <th>Vendor Submitted Material Weight</th>
                                                                                    <th>Plant Submitted Material Weight</th>
                                                                                    <th>Weight Slips</th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                ###########################
                                                                                // $materialWeights = $common_model->find_data('ecomm_sub_enquires', 'array', ['sub_enquiry_no' => $sub_enquiry_no]);
                                                                                $join = [
                                                                                    [
                                                                                        'table'               => 'ecomm_users',
                                                                                        'table_master'        => 'ecomm_sub_enquires',
                                                                                        'field'               => 'id',
                                                                                        'field_table_master'  => 'vendor_id',
                                                                                        'type'                => 'left'      // or 'inner' if you only want matching vendors
                                                                                    ]
                                                                                ];


                                                                                $select = 'ecomm_sub_enquires.*, ecomm_users.company_name';


                                                                                $where = ['sub_enquiry_no' => $sub_enquiry_no];


                                                                                $materialWeights = $common_model->find_data(
                                                                                    'ecomm_sub_enquires',   // main table
                                                                                    'array',                // return type
                                                                                    $where,                 // where
                                                                                    $select,                // select
                                                                                    $join                   // join
                                                                                );
                                                                                // echo "<pre>";
                                                                                // print_r($materialWeights);die;
                                                                                ?>
                                                                                <?php if ($materialWeights) {
                                                                                    $sl = 1;
                                                                                    foreach ($materialWeights as $materialWeight) {
                                                                                ?>
                                                                                        <?php
                                                                                        // var_dump($materialWeight->company_name);
                                                                                        // var_dump($materialWeight->material_weighing_edit_vendor_attempts);
                                                                                        $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $materialWeight->item_id], 'item_name_ecoex,hsn,alias_name,billing_name');
                                                                                        ?>


                                                                                        <tr>

                                                                                            <td><?= $sl++ ?></td>
                                                                                            <td><?= (($getItem) ? $getItem->item_name_ecoex : '') ?></td>
                                                                                            <td><?= (($getItem) ? $getItem->alias_name : '') ?></td>
                                                                                            <td><?= (($getItem) ? $getItem->billing_name : '') ?></td>
                                                                                            <td>
                                                                                                <span class="weight-label"><?= $materialWeight->weighted_qty ?></span>
                                                                                                <input type="text" name="weighted_qty[]" class="form-control weight-value" value="<?= $materialWeight->weighted_qty ?>" style="display: none;">
                                                                                                <?= $materialWeight->weighted_unit ?>
                                                                                            </td>
                                                                                            <td><?= (($materialWeight->material_weight_vendor_date != '') ? date_format(date_create($materialWeight->material_weight_vendor_date), "M d, Y h:i A") : '') ?></td>
                                                                                            <td><?= (($materialWeight->material_weight_plant_date != '') ? date_format(date_create($materialWeight->material_weight_plant_date), "M d, Y h:i A") : '') ?></td>
                                                                                            <td>
                                                                                                <div class="row">
                                                                                                    <?php
                                                                                                    $material_weighing_slips = json_decode($materialWeight->material_weighing_slips);
                                                                                                    ?>
                                                                                                    <?php if ($material_weighing_slips) {
                                                                                                        for ($v = 0; $v < count($material_weighing_slips); $v++) { ?>
                                                                                                            <div class="col-md-6 popup_gallery">
                                                                                                                <a href="<?= getenv('app.uploadsURL') . 'enquiry/' . $material_weighing_slips[$v] ?>" download><img src="<?= getenv('app.uploadsURL') . 'enquiry/' . $material_weighing_slips[$v] ?>" class="img-thumbnail" style="height:100px;width: 100px;"></a>
                                                                                                            </div>
                                                                                                    <?php }
                                                                                                    } ?>
                                                                                                </div>
                                                                                            </td>

                                                                                        </tr>
                                                                                <?php }
                                                                                } ?>
                                                                                <?php if ($subenquiry->is_plant_ecoex_confirm <= 0) { ?>
                                                                                    <tr>
                                                                                        <td colspan="4" style="text-align:center;">
                                                                                            <?php if ($common_model->checkModuleFunctionAccess(23, 126)) { ?>
                                                                                                <a href="<?= base_url('admin/enquiry-requests/approve-material-weight/' . encoded($sub_enquiry_no)) ?>" class="btn btn-success" onclick="return confirm('Do you want to approve this request ?');"><i class="fa fa-check-circle"></i> APPROVE</a>
                                                                                            <?php } ?>
                                                                                        </td>
                                                                                        <td colspan="4" style="text-align:center;">
                                                                                            <?php if ($common_model->checkModuleFunctionAccess(23, 127)) { ?>
                                                                                                <a href="javascript:void(0);" class="btn btn-primary" id="modify-btn" onclick="openMaterialWeightUpdate();"><i class="fa fa-edit"></i> EDIT</a>
                                                                                            <?php } ?>
                                                                                            <button type="submit" class="btn btn-primary" id="update-btn" style="display:none;"><i class="fa fa-edit"></i> UPDATE</button>
                                                                                            <a href="javascript:void(0);" class="btn btn-danger" id="cancel-btn" onclick="closeMaterialWeightUpdate();" style="display:none;"><i class="fa fa-times"></i> CANCEL</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } else { ?>
                                                                                    <tr>
                                                                                        <td colspan="8" style="text-align:center;">
                                                                                            <h6 class="badge bg-success">Material Weight Approved</h6>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($common_model->checkModuleFunctionAccess(23, 134)) { ?>
                                            <?php if ($row->status >= 6) { ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFive">
                                                        <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> Invoice From HO </button>
                                                    </h2>
                                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">

                                                            <?php if ($getEnquiry) { ?>
                                                                <div class="row mt-3">
                                                                    <div class="col-md-6 text-center">
                                                                        <?php if ($getEnquiry->is_invoice_from_ho == 0) { ?>
                                                                            <?php if ($userType == 'MA') { ?>
                                                                                <a href="<?= base_url('admin/enquiry-requests/request-invoice-to-HO-from-ecoex/' . encoded($getEnquiry->id) . '/' . encoded($sub_enquiry_no)) ?>" class="btn btn-warning btn-sm" onclick="return confirm('Do you want to sent request for invoice to HO ?');"><i class="fa-solid fa-code-pull-request"></i> Request For Invoice To HO</a>
                                                                            <?php } ?>
                                                                        <?php } elseif ($getEnquiry->is_invoice_from_ho >= 1) { ?>
                                                                            <h4 class="text-success fw-bold">Invoice Request Sent To HO Succesfully</h4>
                                                                            <h5><?= date_format(date_create($getEnquiry->invoice_from_ho_request_date), "M d, Y h:i A") ?></h5>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-md-6 text-center">
                                                                        <?php if ($getEnquiry->is_invoice_from_ho == 1) { ?>
                                                                            <h4 class="text-warning fw-bold">HO Still Not Uploaded Invoice</h4>
                                                                            <?php if ($userType == 'COMPANY') {
                                                                                include_once('./app/Views/admin/maincontents/enquiry-request/multipleHoInvoice.php');
                                                                            ?>
                                                                                <!-- old code 21_4_25 -->
                                                                                <!-- <form method="POST" action="<?= base_url('admin/enquiry-requests/upload-invoice-by-HO') ?>" enctype="multipart/form-data">
                                                                                    <input type="hidden" name="enq_id" value="<?= encoded($getEnquiry->id) ?>">
                                                                                    <input type="hidden" name="sub_enquiry_no" value="<?= encoded($sub_enquiry_no) ?>">
                                                                                    <div class="form-group">
                                                                                        <label for="ho_payable_amount">Invoice Amount</label>
                                                                                        <input type="text" class="form-control" name="ho_payable_amount" id="ho_payable_amount" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="invoice_file_from_ho">Vendor Invoice File</label>
                                                                                        <input type="file" class="form-control" name="invoice_file_from_ho" id="invoice_file_from_ho" accept="application/pdf" required>
                                                                                        <small class="text-primary">Only PDF file allowed</small>
                                                                                    </div>
                                                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-file-invoice"></i> Upload Invoice</button>
                                                                                </form> -->
                                                                                <!-- old code 21_4_25-->
                                                                            <?php } ?>
                                                                        <?php } elseif ($getEnquiry->is_invoice_from_ho == 2) {
                                                                            $ho_payable_amount_arr = json_decode($getEnquiry->ho_payable_amount_arr, true);
                                                                            $ho_invoice_file_arr = json_decode($getEnquiry->invoice_file_from_ho_arr, true);

                                                                        ?>
                                                                            <h4 class="text-success fw-bold">Invoice Uploaded By HO Succesfully</h4>

                                                                            <!-- <a download href="<?= getenv('app.uploadsURL') . 'enquiry/' . $getEnquiry->invoice_file_from_ho ?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to open invoice ?');"><i class="fas fa-download"></i> Download Invoice From HO</a>
                                                                            <h5><i class="fa fa-inr"></i> <?= $getEnquiry->ho_payable_amount ?></h5> -->



                                                                            <?php for ($i = 0; $i < count($ho_invoice_file_arr); $i++) { ?>

                                                                                <div class="invoice_div mb-3" style="margin-bottom: 5px; border: 1px solid #ccc; padding: 10px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; width: 300px; margin: auto; border-radius: 5px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); background: #f9f9f9;">
                                                                                    <h5 style="margin-bottom: 10px;"><i class="fa fa-inr"></i> <?= number_format($ho_payable_amount_arr[$i], 2) ?></h5>
                                                                                    <a download href="<?= getenv('app.uploadsURL') . 'enquiry/' . $ho_invoice_file_arr[$i] ?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to open invoice ?');" style="padding: 8px 12px; text-decoration: none;">
                                                                                        <i class="fas fa-download"></i>
                                                                                    </a>
                                                                                </div>

                                                                            <?php } ?>
                                                                            <h5><?= date_format(date_create($getEnquiry->invoice_from_ho_date), "M d, Y h:i A") ?></h5>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($common_model->checkModuleFunctionAccess(23, 135)) { ?>
                                            <?php if ($row->status >= 7) { ?>

                                                <?php if ($userType == 'MA') { ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingSix">
                                                            <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"> Invoice To Vendor </button>
                                                        </h2>
                                                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <?php if ($subenquiry) {
                                                                    $vendor_invoice_file_arr = json_decode($subenquiry->vendor_invoice_file_arr, true);
                                                                    $vendor_invoice_amount_arr = json_decode($subenquiry->vendor_invoice_amount_arr, true);
                                                                ?>
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-8 text-center">

                                                                            <?php
                                                                            if (!count($vendor_invoice_file_arr)) {
                                                                                include_once('./app/Views/admin/maincontents/enquiry-request/multipleVendorInvoice.php');
                                                                            ?>

                                                                                <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->

                                                                                <!-- backup _on 25-03-25  -->

                                                                                <!-- <form method="POST" action="<? // base_url('admin/enquiry-requests/upload-invoice-by-ecoex-for-vendor') 
                                                                                                                    ?>" enctype="multipart/form-data" style="border: 1px solid #0080006e;border-radius: 10px;padding: 10px;">
                                                                                    <input type="hidden" name="enq_id" value="<? // encoded($subenquiry->enq_id) 
                                                                                                                                ?>">
                                                                                    <input type="hidden" name="sub_enquiry_no" value="<? // encoded($sub_enquiry_no) 
                                                                                                                                        ?>">
                                                                                
                                                                                    <div class="invoiceItem">
                                                                                        <div class="form-group">
                                                                                            <label for="vendor_invoice_amount">Vendor Invoice Amount</label>
                                                                                            <input type="text" class="form-control" name="vendor_invoice_amount" id="vendor_invoice_amount" required>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="vendor_invoice_file">Vendor Invoice File</label>
                                                                                            <input type="file" class="form-control" name="vendor_invoice_file" id="vendor_invoice_file" accept="application/pdf" required>
                                                                                            <small class="text-primary">Only PDF file allowed</small>
                                                                                        </div>
                                                                                    </div>

                                                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-file-invoice"></i> Upload Invoice</button>
                                                                                </form> -->
                                                                                <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->



                                                                            <?php } else { ?>
                                                                                <h4 class="text-success fw-bold">Invoice Uploaded For Vendor Succesfully</h4>
                                                                                <h6><?= date_format(date_create($subenquiry->invoice_to_vendor_date), "M d, Y h:i A") ?></h6>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <div class="col-md-4 text-center">
                                                                            <?php
                                                                            if (count($vendor_invoice_file_arr)) { ?>
                                                                                <h4 class="text-success fw-bold">Invoice Uploaded By Ecoex Succesfully</h4>
                                                                                <!-- old code -->
                                                                                <!-- <a download href="<?= getenv('app.uploadsURL') . 'enquiry/' . $subenquiry->vendor_invoice_file ?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to open invoice ?');"><i class="fas fa-download"></i> Download Invoice From Vendor</a>
                                                                                <h5><i class="fa fa-inr"></i> <?= $subenquiry->vendor_invoice_amount ?></h5> -->
                                                                                <!-- new code update by shubha on 28/03/25 -->
                                                                                <?php for ($i = 0; $i < count($vendor_invoice_file_arr); $i++) { ?>

                                                                                    <div class="invoice_div mb-3" style="margin-bottom: 5px; border: 1px solid #ccc; padding: 10px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; width: 300px; margin: auto; border-radius: 5px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); background: #f9f9f9;">
                                                                                        <h5 style="margin-bottom: 10px;"><i class="fa fa-inr"></i> <?= number_format($vendor_invoice_amount_arr[$i], 2) ?></h5>
                                                                                        <a download href="<?= getenv('app.uploadsURL') . 'enquiry/' . $vendor_invoice_file_arr[$i] ?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to open invoice ?');" style="padding: 8px 12px; text-decoration: none;">
                                                                                            <i class="fas fa-download"></i>
                                                                                        </a>
                                                                                    </div>

                                                                                <?php } ?>



                                                                                <h6><?= date_format(date_create($subenquiry->invoice_to_vendor_date), "M d, Y h:i A") ?></h6>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($common_model->checkModuleFunctionAccess(23, 137)) { ?>
                                            <?php if ($row->status >= 8) { ?>
                                                <?php if ($userType == 'MA') { ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingSeven">
                                                            <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">Payment Received From Vendor </button>
                                                        </h2>
                                                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">

                                                                <?php
                                                                if ($subenquiry) { ?>
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-6 text-center">
                                                                            <?php if ($subenquiry->payment_amount <= 0) { ?>
                                                                                <h4 class="text-warning fw-bold">Payment Info Still Not Uploaded By Vendor</h4>
                                                                            <?php } else { ?>
                                                                                <h4 class="text-success fw-bold">Payment Info Uploaded By Vendor Succesfully</h4>
                                                                                <h5>Payment Amount : <?= $subenquiry->payment_amount ?></h5>
                                                                                <h6>Payment Date/Time : <?= date_format(date_create($subenquiry->payment_date), "M d, Y h:i A") ?></h6>
                                                                                <h6>Payment Mode : <?= $subenquiry->payment_mode ?></h6>
                                                                                <?php if ($subenquiry->payment_mode != 'CASH') { ?>
                                                                                    <h6>Transaction No. : <?= $subenquiry->txn_no ?></h6>
                                                                                    <h6>Transaction Screenshot :
                                                                                        <div class="popup_gallery">
                                                                                            <a target="_blank" href="<?= getenv('app.uploadsURL') . 'enquiry/' . $subenquiry->txn_screenshot ?>">
                                                                                                <img src="<?= getenv('app.uploadsURL') . 'enquiry/' . $subenquiry->txn_screenshot ?>" style="width: 200px; height: 200px;">
                                                                                            </a>
                                                                                        </div>
                                                                                    </h6>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <div class="col-md-6 text-center">
                                                                            <?php if ($subenquiry->payment_amount > 0) { ?>
                                                                                <?php if ($subenquiry->is_approve_vendor_payment == 0) { ?>
                                                                                    <a href="<?= base_url('admin/enquiry-requests/vendor-payment-approve/' . encoded($sub_enquiry_no)) ?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to approve vendor payment ?');"><i class="fas fa-check"></i> Approve Vendor Payment</a>
                                                                                <?php } else { ?>
                                                                                    <h4 class="text-success fw-bold">Vendor Payment Approved Successfully By Ecoex</h4>
                                                                                    <h5><i class="fa fa-inr"></i> <?= $subenquiry->payment_amount ?></h5>
                                                                                    <h6><?= date_format(date_create($subenquiry->vendor_payment_received_date), "M d, Y h:i A") ?></h6>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($row->status >= 10) { ?>
                                            <?php if ($common_model->checkModuleFunctionAccess(23, 139)) { ?>
                                                <?php if ($userType == 'MA') { ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingEight">
                                                            <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">Vehicle Despatch By Vendor</button>
                                                        </h2>
                                                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <?php if ($subenquiry) { ?>
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-6 text-center">
                                                                            <?php if ($subenquiry->vehicle_dispatched_date != '') { ?>
                                                                                <h4 class="text-success fw-bold">Vehicle Despatched By Vendor</h4>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <div class="col-md-6 text-center">
                                                                            <?php if ($subenquiry->vehicle_dispatched_date != '') { ?>
                                                                                <h6><?= date_format(date_create($subenquiry->vehicle_dispatched_date), "M d, Y h:i A") ?></h6>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($common_model->checkModuleFunctionAccess(23, 138)) { ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingNine">
                                                        <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">Payment To HO </button>
                                                    </h2>
                                                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <?php if ($getEnquiry) { ?>
                                                                <div class="row mt-3">
                                                                    <div class="col-md-6 text-center">
                                                                        <?php if ($getEnquiry->ecoex_submitted_date == '') { ?>
                                                                            <h4 class="text-warning fw-bold">Ecoex Still Not Payment To HO</h4>
                                                                            <?php if ($userType == 'MA') { ?>
                                                                                <form method="POST" action="<?= base_url('admin/enquiry-requests/upload-payment-by-ecoex-for-ho') ?>" enctype="multipart/form-data" style="border: 1px solid #0080006e;border-radius: 10px;padding: 10px;">
                                                                                    <input type="hidden" name="enq_id" value="<?= encoded($getEnquiry->id) ?>">
                                                                                    <input type="hidden" name="sub_enquiry_no" value="<?= encoded($sub_enquiry_no) ?>">
                                                                                    <div class="form-group">
                                                                                        <label for="ecoex_payment_amount" style="float: left; font-weight:bold;">Payment Amount</label>
                                                                                        <input type="text" class="form-control" name="ecoex_payment_amount" id="ecoex_payment_amount" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="ecoex_payment_date" style="float: left; font-weight:bold;">Payment Date/Time</label>
                                                                                        <input type="datetime-local" class="form-control" name="ecoex_payment_date" id="ecoex_payment_date" required>
                                                                                    </div>
                                                                                    <div class="form-group mb-3">
                                                                                        <label for="ecoex_payment_mode" style="float: left; font-weight:bold;">Payment Mode</label>
                                                                                        <select class="form-control" name="ecoex_payment_mode" id="ecoex_payment_mode" required onchange="getPaymentMode(this.value);">
                                                                                            <option value="" selected>Select Payment Mode</option>
                                                                                            <option value="CASH">CASH</option>
                                                                                            <option value="CHEQUE">CHEQUE</option>
                                                                                            <option value="NETBANKING">NETBANKING</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group online-payment" style="display:none;">
                                                                                        <label for="ecoex_txn_no" style="float: left; font-weight:bold;">Payment Txn No.</label>
                                                                                        <input type="text" class="form-control" name="ecoex_txn_no" id="ecoex_txn_no">
                                                                                    </div>
                                                                                    <div class="form-group mb-3 online-payment" style="display:none;">
                                                                                        <label for="ecoex_txn_screenshot" style="float: left; font-weight:bold;">Payment Screenshot</label>
                                                                                        <input type="file" class="form-control" name="ecoex_txn_screenshot" id="ecoex_txn_screenshot" accept="image/*">
                                                                                        <small class="text-primary" style="float: left;">Only image file allowed</small>
                                                                                    </div>
                                                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-inr"></i> Upload Payment Info</button>
                                                                                </form>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <h4 class="text-success fw-bold">Payment Info Uploaded By Ecoex Succesfully</h4>
                                                                            <h5>Payment Amount : <span class="text-success"><?= number_format($getEnquiry->ecoex_payment_amount, 2) ?></span></h5>
                                                                            <h5>Due Amount : <span class="text-danger"><?= number_format($getEnquiry->ecoex_due_amount, 2) ?></span></h5>
                                                                            <h6>Payment Date/Time : <?= date_format(date_create($getEnquiry->ecoex_payment_date), "M d, Y h:i A") ?></h6>
                                                                            <h6>Payment Mode : <?= $getEnquiry->ecoex_payment_mode ?></h6>
                                                                            <?php if ($getEnquiry->ecoex_payment_mode != 'CASH') { ?>
                                                                                <h6>Transaction No. : <?= $getEnquiry->ecoex_txn_no ?></h6>
                                                                                <h6>Transaction Screenshot :
                                                                                    <div class="popup_gallery">
                                                                                        <a target="_blank" href="<?= getenv('app.uploadsURL') . 'enquiry/' . $getEnquiry->ecoex_txn_screenshot ?>">
                                                                                            <img src="<?= getenv('app.uploadsURL') . 'enquiry/' . $getEnquiry->ecoex_txn_screenshot ?>" style="width: 200px; height: 200px;" class="img-thumbnail">
                                                                                            <a />
                                                                                    </div>
                                                                                </h6>

                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-md-6 text-center">
                                                                        <?php if ($getEnquiry->ecoex_submitted_date != '') { ?>
                                                                            <?php if (!$getEnquiry->is_ho_approve_ecoex_payment) { ?>
                                                                                <h4 class="text-warning fw-bold">Ecoex Payment Still Not Approved By HO</h4>
                                                                                <?php if ($userType == 'COMPANY') { ?>
                                                                                    <a href="<?= base_url('admin/enquiry-requests/approve-ecoex-payment-by-ho/' . encoded($getEnquiry->id) . '/' . encoded($sub_enquiry_no)) ?>" class="btn btn-success btn-sm" onclick="return confirm('Do you want to approve ecoex payment ?');"><i class="fas fa-check"></i> Approve Ecoex Payment</a>
                                                                                <?php } ?>
                                                                            <?php } else { ?>
                                                                                <h4 class="text-success fw-bold">Ecoex Payment Approved By HO</h4>
                                                                                <h6><?= date_format(date_create($getEnquiry->ho_approve_date), "M d, Y h:i A") ?></h6>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($common_model->checkModuleFunctionAccess(23, 136)) { ?>
                                            <?php if ($row->status >= 11) { ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingEleven">
                                                        <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">Enquiry Complete By Ecoex</button>
                                                    </h2>
                                                    <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <?php if ($row) { ?>
                                                                <div class="row mt-3">
                                                                    <div class="col-md-6 text-center">
                                                                        <?php if ($row->order_complete_date != '') { ?>
                                                                            <h4 class="text-success fw-bold">Enquiry Completed By Ecoex</h4>
                                                                        <?php } else { ?>
                                                                            <h4 class="text-warning fw-bold">Enquiry Yet Not Completed By Ecoex</h4>
                                                                            <?php if ($userType == 'MA') { ?>
                                                                                <a href="<?= base_url('admin/' . $controller_route . '/order-complete/' . encoded($row->$primary_key)) ?>" class="btn btn-success btn-sm" title="Complete <?= $title ?>" onclick="return confirm('Do You Want To Complete This <?= $title ?>');"><i class="fa-solid fa-flag-checkered"></i> Click To Complete Enquiry</a>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-md-6 text-center">
                                                                        <?php if ($row->order_complete_date != '') { ?>
                                                                            <h6><?= date_format(date_create($row->order_complete_date), "M d, Y h:i A") ?></h6>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                        <?php $i++;
                            }
                        } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!--  modal added by @Shubha75 for 'Enquiry Request Items'  -->


<div class="modal fade" id="enquiry_request_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong><?= $row->enquiry_no ?></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" id="enquiry_request_edit_form" action="<?= base_url('admin/api/items/rename') ?>">
                <div class="modal-body">
                    <input type="hidden" name="enquiry_request_product_id" value="0">



                    <div class="input-group mb-1 input-group-sm">
                        <span class="input-group-text">Categories</span>
                        <select class="form-control" name="category_id" id="category_id" required>
                            <option value="" disabled> Select </option>
                            <?php foreach ($product_categories as $key => $category) { ?>
                                <option value="<?= $category->id ?>"> <?= $category->name ?> </option>
                            <?php }  ?>
                        </select>
                    </div>

                    <div class="input-group mb-1 input-group-sm">
                        <span class="input-group-text">Unit</span>
                        <select class="form-control" name="unit_id" id="unit_id" required>
                            <option value="" disabled> Select </option>
                            <?php foreach ($product_units as $key => $unit) { ?>
                                <option value="<?= $unit->id ?>"> <?= $unit->name ?> </option>
                            <?php }  ?>
                        </select>
                    </div>

                    <?php foreach ($request_edit_fields as $name => $label): ?>
                        <div class="input-group mb-1 input-group-sm">
                            <span class="input-group-text"><?= $label ?></span>
                            <input type="text" name="<?= $name ?>" class="form-control" value="<?= htmlspecialchars($_POST[$name] ?? '') ?>" required>
                        </div>
                        <?php if (!empty($errors[$name])): ?>
                            <span class="text-danger small d-block mb-2"><?= $errors[$name] ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
                <div class="modal-footer">
                    <span id="status_message" class="me-auto hide-me text-success"></span>
                    </span>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- modal added by @Shubha75 'Enquiry Request Items' -->


<!-- share to vendor modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Share Details To Vendors : <?= $row->enquiry_no ?></strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="mode" value="share_vendor">
                    <input type="hidden" name="enq_id" value="<?= $row->id ?>">
                    <input type="hidden" name="company_id" value="<?= $row->company_id ?>">
                    <input type="hidden" name="plant_id" value="<?= $row->plant_id ?>">
                    <div class="form-group">
                        <label for="choices-multiple-remove-button">Vendors</label>
                        <select name="vendors[]" id="choices-multiple-remove-button" multiple>
                            <?php if ($avlVendors) {
                                foreach ($avlVendors as $avlvendor) { ?>
                                    <?php
                                    $checkVendorShare = $common_model->find_data('ecomm_enquiry_vendor_shares', 'count', ['enq_id' => $row->id, 'vendor_id' => $avlvendor->id]);
                                    if ($checkVendorShare <= 0) {
                                    ?>
                                        <option value="<?= $avlvendor->id ?>"><?= $avlvendor->company_name ?></option>
                                    <?php } ?>
                            <?php }
                            } ?>
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
<?php if ($enquiryPendingProducts) {
    $slNo = 1;
    foreach ($enquiryPendingProducts as $enquiryPendingProduct) {

?>
        <?php
        $getItem = $common_model->find_data('ecomm_company_items', 'row', ['enq_product_id' => $enquiryPendingProduct->id]);
        ?>
        <div class="modal fade" id="verticalycentered<?= $enquiryPendingProduct->id ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form method="POST" action="<?= base_url('admin/companies/approve-item') ?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enquiry Item Approve</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= (($getItem) ? encoded($getItem->id) : '') ?>">
                            <input type="hidden" name="redirect_link" value="<?= encoded(current_url()) ?>">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <select class="form-control" name="item_category[]" required>
                                        <option value="" selected>Select Category</option>
                                        <?php if ($cats) {
                                            foreach ($cats as $cat) { ?>
                                                <option value="<?= $cat->category_id ?>"><?= $cat->category_alias ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="item_name_ecoex[]" class="form-control" placeholder="Item Ecoex" value="<?= $getItem->item_name_ecoex ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="alias_name[]" class="form-control" placeholder="Alias Name" value="<?= $getItem->alias_name ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="billing_name[]" class="form-control" placeholder="Billing Name" value="<?= $getItem->billing_name ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="hsn[]" class="form-control" placeholder="HSN" value="<?= $getItem->hsn ?>" required>
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
                                    <input type="text" name="rate[]" class="form-control" placeholder="Rate" value="<?= $getItem->rate ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-control" name="unit[]" required>
                                        <option value="" selected>Select Unit</option>
                                        <?php if ($units) {
                                            foreach ($units as $unit) { ?>
                                                <option value="<?= $unit->id ?>" <?= (($unit->id == $enquiryPendingProduct->unit) ? 'selected' : '') ?>><?= $unit->name ?></option>
                                        <?php }
                                        } ?>
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
<?php }
} ?>
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
<?php if ($enquiryProducts) {
    $slNo = 1;
    foreach ($enquiryProducts as $enquiryProduct) { ?>
        <?php
        $enquiryImages      = [];
        $new_product_images = json_decode($enquiryProduct->new_product_image);
        if (!empty($new_product_images)) {
            for ($i = 0; $i < count($new_product_images); $i++) {
                $enquiryImages[]      = getenv('app.uploadsURL') . 'enquiry/' . $new_product_images[$i];
            }
        }
        ?>
        <div class="modal fade" id="enquiryImageModal<?= $enquiryProduct->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" id="enquiryImageTitle">
                        Enquiry Item Images : <?= $row->enquiry_no ?>
                    </div>
                    <div class="modal-body" id="enquiryImageBody">
                        <div id="" class="owl-carousel owl-theme owl-loaded home-successstories owl-drag">
                            <?php if (!empty($enquiryImages)) {
                                for ($enqImg = 0; $enqImg < count($enquiryImages); $enqImg++) { ?>
                                    <div class="item">
                                        <div class="sucess_boximg">
                                            <img src="<?= $enquiryImages[$enqImg] ?>" class="img-fluid" alt="image">
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php }
} ?>
<!-- image modal -->
<script src="<?= getenv('app.adminAssetsURL'); ?>assets/js/progress-bar.js"></script>
<!-- progress bar -->
<?php if ($row->status != 13) { ?>
    <script type="text/javascript">
        //we can set animation delay as following in ms (default 1000)
        ProgressBar.singleStepAnimation = 300;
        ProgressBar.init(
            ['Request Submitted',
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
                'Order Complete'
            ],
            '<?= $enquiryStatus ?>',
            'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
        );
    </script>
<?php } else { ?>
    <script type="text/javascript">
        //we can set animation delay as following in ms (default 1000)
        ProgressBar.singleStepAnimation = 300;
        ProgressBar.init(
            ['Request Submitted',
                'Reject Request'
            ],
            '<?= $enquiryStatus ?>',
            'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
        );
    </script>
<?php } ?>
<script type="text/javascript">
    function getRejectModal(enq_id) {
        let baseUrl = '<?= base_url() ?>';
        $.ajax({
            type: "POST",
            data: {
                enq_id: enq_id
            },
            url: baseUrl + "/admin/get-reject-modal",
            dataType: "JSON",
            success: function(res) {
                if (res.success) {
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
    $(document).ready(function() {
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount: 30,
            searchResultLimit: 30,
            renderChoiceLimit: 30
        });


        // Ho multi invoice
        $(function() {
            var hoMaxItems = 10; // max rows allowed

            // Add new HO row
            $('#hoInvoiceItemsContainer').on('click', '.add-ho-row', function() {
                var container = $('#hoInvoiceItemsContainer');
                var count = container.find('.hoInvoiceItem').length;

                if (count < hoMaxItems) {
                    // Clone the current row
                    var newRow = $(this).closest('.hoInvoiceItem').clone();
                    // Clear its inputs
                    newRow.find('input').val('');
                    // Change the plus button to minus
                    newRow.find('.add-ho-row')
                        .removeClass('btn-success add-ho-row')
                        .addClass('btn-danger remove-ho-row')
                        .html('<i class="fas fa-minus"></i>');
                    // Append
                    container.append(newRow);
                } else {
                    alert('Maximum of ' + hoMaxItems + ' invoice items allowed.');
                }
            });

            // Remove HO row
            $('#hoInvoiceItemsContainer').on('click', '.remove-ho-row', function() {
                var container = $('#hoInvoiceItemsContainer');
                // Always keep at least one
                if (container.find('.hoInvoiceItem').length > 1) {
                    $(this).closest('.hoInvoiceItem').remove();
                } else {
                    alert('At least one invoice item is required.');
                }
            });
        });

        // vendor multi invoice

        var maxItems = 10; // Maximum number of invoice items allowed

        // Add new row
        $('#invoiceItemsContainer').on('click', '.add-row', function() {
            var container = $('#invoiceItemsContainer');
            var itemCount = container.find('.invoiceItem').length;

            if (itemCount < maxItems) {
                var newRow = $(this).closest('.invoiceItem').clone();
                newRow.find('input').val(''); // Clear inputs
                // Change add button to remove button
                newRow.find('.add-row')
                    .removeClass('btn-success')
                    .addClass('btn-danger')
                    .html('<i class="fas fa-minus"></i>')
                    .removeClass('add-row')
                    .addClass('remove-row');
                container.append(newRow);
            } else {
                alert('Maximum of ' + maxItems + ' invoice items allowed.');
            }
        });

        // Remove row
        $('#invoiceItemsContainer').on('click', '.remove-row', function() {
            if ($('#invoiceItemsContainer .invoiceItem').length > 1) {
                $(this).closest('.invoiceItem').remove();
            } else {
                alert('At least one invoice item is required.');
            }
        });

        // vendor multi invoice

    });
</script>
<script type="text/javascript">
    function openMaterialWeightUpdate() {
        $('.weight-label').hide();
        $('.weight-value').show();
        $('#modify-btn').hide();
        $('#update-btn').show();
        $('#cancel-btn').show();
    }

    function closeMaterialWeightUpdate() {
        $('.weight-label').show();
        $('.weight-value').hide();
        $('#modify-btn').show();
        $('#update-btn').hide();
        $('#cancel-btn').hide();
    }

    function getPaymentMode(paymentMode) {
        if (paymentMode == 'CASH') {
            $('.online-payment').hide();
            $('#ecoex_txn_no').prop('required', false);
            $('#ecoex_txn_screenshot').prop('required', false);
        } else {
            $('.online-payment').show();
            $('#ecoex_txn_no').prop('required', true);
            $('#ecoex_txn_screenshot').prop('required', true);
        }
    }



    //  item name edit modal

    // $(function() {
    //     // 1. Show popup on span click
    //     $(document).on('click', '.edit_request_item_name', function() {
    //         var $span = $(this);
    //         var itemId = $span.data('product_id');
    //         var offset = $span.offset();
    //         var popup = $(`
    //   <div class="inline-popup">
    //     <input type="text" class="popup-input" placeholder="New name…">
    //     <i class="fa fa-check popup-confirm" data-product-id="${itemId}" title="Save"></i>
    //     <i class="fa fa-times popup-cancel" title="Cancel"></i>
    //   </div>
    // `);

    //         // Position below the span
    //         popup.css({
    //             top: offset.top + $span.outerHeight() + 5,
    //             left: offset.left
    //         });

    //         // Remove any existing popups and append
    //         $('.inline-popup').remove();
    //         $('body').append(popup);
    //         popup.find('.popup-input').focus();
    //     });

    //     //  remove popup only
    //     $(document).on('click', '.popup-cancel', function() {
    //         $(this).closest('.inline-popup').remove();
    //     });

    // save data
    // $(document).on('click', '.popup-confirm', function() {

    //     var $popup = $(this).closest('.inline-popup');
    //     var productId = $(this).data('product-id');

    //     var $span = $("#set_request_item_name" + productId);

    //     var newName = $popup.find('.popup-input').val().trim();



    //     if (!newName) {
    //         $popup.find('.popup-input').addClass('is-invalid');
    //         return;
    //     }

    //     // spinner state
    //     $(this)
    //         .removeClass('fa-check')
    //         .addClass('fa-spinner fa-spin')
    //         .off('click');

    //     var baseURL = '<?= base_url(); ?>';

    //     $.ajax({
    //             url: baseURL + 'admin/api/items/rename',
    //             method: 'POST',
    //             dataType: 'json',
    //             data: {
    //                 name: newName,
    //                 itemid: productId
    //             }
    //         })
    //         .done(function(res) {
    //             if (res.status) {
    //                 // update the original span’s text
    //                 $span.text(res.data.item_name_ecoex); // safe text update :contentReference[oaicite:6]{index=6}
    //             } else {
    //                 console.error('Update failed: ' + (res.message || 'Unknown error'));
    //             }
    //             $popup.remove();
    //         })
    //         .fail(function(jqXHR, textStatus) {
    //             console.error('AJAX error:', textStatus);
    //             alert('Error saving name');
    //             $popup.remove();
    //         });
    // });


    function getRequestProductValues(productId, category_id, unit_id) {
        const values = {
            item_name: $(`#set_request_item_name${productId}`).text().trim(),
            item_alias_name: $(`#set_request_alias_name${productId}`).text().trim(),
            item_billing_name: $(`#set_request_billing_name${productId}`).text().trim(),
            item_hsn_code: $(`#set_request_HSN_code${productId}`).text().trim(),
            item_gst: $(`#set_request_gst${productId}`).text().trim(),
            item_rate: $(`#set_request_rate${productId}`).text().trim(),
            item_qty: $(`#set_request_qty${productId}`).text().trim(),
            item_remarks: $(`#set_request_remarks${productId}`).text().trim(),
        };

        // Set the values to the select box fields
        $(`select[name="category_id"]`).val(category_id);
        $(`select[name="unit_id"]`).val(unit_id);

        // Now set the values to input fields by name
        for (const [name, value] of Object.entries(values)) {
            $(`input[name="${name}"]`).val(value);
        }

        // Also set the hidden product_id input
        $(`input[name="enquiry_request_product_id"]`).val(productId);

        // Show modal
        $('#enquiry_request_edit').modal('show');


    }

    // Validate input fields to allow only numbers and one decimal point
    $(document).on('input', 'input[name="item_gst"], input[name="item_rate"], input[name="item_qty"]', function() {
        let val = this.value;
        // Allow only digits and 1 decimal
        val = val.replace(/[^0-9.]/g, '');

        // Prevent more than one dot
        const parts = val.split('.');
        if (parts.length > 2) {
            val = parts[0] + '.' + parts.slice(1).join('');
        }

        // Prevent starting with dot
        if (val.startsWith('.')) {
            val = '0' + val;
        }

        this.value = val;
    });

    // set values & modal open
    $(document).on('click', '.accepted_request_edit', function() {
        let product_id = $(this).data('product_id');
        let category = $(this).data('category');
        let unit = $(this).data('unit');
        getRequestProductValues(product_id, category, unit);
    });

    // form submit for item data edit
    $(document).on('submit', '#enquiry_request_edit_form', function(e) {
        e.preventDefault();

        let $form = $(this);
        let formData = $form.serialize(); // Serialize the form data
        let actionUrl = $form.attr('action'); // Get the form's action attribute


        $.ajax({
            url: actionUrl,
            method: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {
                if (response.status) {
                    $('#enquiry_request_edit').modal('hide');
                    toastAlert('success', 'Item updated successfully!');

                    location.reload();


                    // Update UI with new data
                    // let productId = $(`input[name="enquiry_request_product_id"]`).val();
                    // $(`#set_request_item_name${productId}`).text(response.data.item_name_ecoex);
                    // $(`#set_request_alias_name${productId}`).text(response.data.item_alias_name);
                    // $(`#set_request_billing_name${productId}`).text(response.data.item_billing_name);
                    // $(`#set_request_HSN_code${productId}`).text(response.data.item_hsn_code);
                    // $(`#set_request_gst${productId}`).text(response.data.item_gst);
                    // $(`#set_request_rate${productId}`).text(response.data.item_rate);


                    // $(`#set_request_qty${productId}`).text(response.data.item_qty);
                    // $(`#set_request_remarks${productId}`).text(response.data.item_remarks);


                } else {
                    toastAlert('error', response.message);
                    console.error('Error updating :', response.message);

                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                // alert('An error occurred while updating the item name.');

            }
        });
    });
    //  item name edit modal 
</script>