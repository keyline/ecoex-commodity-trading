<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;
?>
<style type="text/css">
    .item-cover {
        border: 1px solid #008000c7;
        padding: 13px;
        border-radius: 7px;
        margin-bottom: 10px;
    }

    .item-cover-existing {
        border: 1px solid orange;
        padding: 13px;
        border-radius: 7px;
        margin-bottom: 10px;
    }
</style>
<div class="container-fluid">
    <div class="pagetitle">
        <h1><?= $page_header ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li>
                <li class="breadcrumb-item active"><?= $page_header ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- End Page Title -->
<section class="section profile">
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

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- <form method="POST" action="" enctype="multipart/form-data"> -->

                        <div class="row">
                            <div class="col-md-2">
                                <h6 class="text-success fw-bold">Company Name</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="text-success fw-bold">Item Name</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="text-success fw-bold">Item price</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="text-success fw-bold">Unit</h6>
                            </div>                                                    
                            <div class="col-md-2">
                                <h6 class="text-success fw-bold">Action</h6>
                            </div>
                        </div>
                        <div class="field_wrapper">
                            <?php if ($allItems) {
                                foreach ($allItems as $allItem) { ?>
                                    <?php
                                    if ($userType == 'MA') {
                                        $display = '';
                                    } else {
                                        if ($assignItem->status) {
                                            $display = '';
                                        } else {
                                            $display = 'none';
                                        }
                                    }
                                    ?>
                                    <?php $value = isset($priceMap[$allItem->id]) ? $priceMap[$allItem->id] : '';?>
                                    <form method="POST" action="" style="display: <?= $display ?>;" enctype="multipart/form-data">
                                        <input type="hidden" name="vendor_id" id="vendor_id" value="<?= $vendor_id ?>">                                        
                                        <input type="hidden" name="company_id" id="company_id" value="<?= $allItem->company_id ?>">                                        
                                        <input type="hidden" name="item_id" value="<?= $allItem->id ?>"> 
                                        <input type ="hidden" name="unit_id" value="<?= $allItem->unit ?>">
                                        <div class="row item-cover" style="margin-left: 0; margin-right: 0;">
                                            <div class="col-md-2 mb-3 mb-md-0">
                                                <?= $allItem->company_name ?>
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0">
                                                <?= $allItem->item_name_ecoex ?>
                                            </div>                                    
                                            <div class="col-md-2 mb-3 mb-md-0">
                                                <input type = "text" name ="item_price" value="<?= $value ?>" required />
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0">
                                               /<?= $allItem->unit_name ?>
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0">
                                                <?php if ($userType == 'MA') { ?>
                                                    <?php if (isset($priceMap[$allItem->id])): ?>
                                                    <button type="submit" onclick="return confirm('Do You Want To Update Price For This Item ?');" class="btn btn-warning w-100" style="font-size: 11px; padding: 8px !important;margin-bottom: 5px;"><i class="fa-solid fa-pen-circle"></i> Update Price</button>
                                                    <?php else: ?>
                                                    <button type="submit" onclick="return confirm('Do You Want To Save Price For This Item ?');" class="btn btn-success w-100" style="font-size: 11px; padding: 8px !important;margin-bottom: 5px;"><i class="fa fa-plus-circle"></i> Save Price</button>
                                                    <?php endif; ?>
                                                <?php } ?>
                                            </div>
                                        </div>                                                                                                                   
                                    </form>
                            <?php }
                                } ?>                            
                        </div>                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>