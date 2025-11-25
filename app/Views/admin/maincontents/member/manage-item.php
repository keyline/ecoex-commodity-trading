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

                        <!-- 🔍 Search Filters -->
                        <div class="mb-3">
                            <div style="display: flex; gap: 10px; align-items: center;">
                                <input type="text" id="searchCompanyName" class="form-control" placeholder="Search Company Name" style="width: 25%;">
                                <input type="text" id="searchItemName" class="form-control" placeholder="Search Item Name" style="width: 25%;">
                                <input type="text" id="searchItemPrice" class="form-control" placeholder="Search Item Price" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 25%;">                                            
                                <button type="button" class="btn btn-secondary" onclick="clearPlantSearch()">Clear</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                               <div class="vendor_items">
                                <div class="row">
                                    <div class="col-md-2">
                                        <h6 class="table_text fw-bold">Company Name</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="table_text fw-bold">Item Name</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="table_text fw-bold">Item price</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="table_text fw-bold">Unit</h6>
                                    </div>                                                    
                                    <div class="col-md-2">
                                        <h6 class="table_text fw-bold">Action</h6>
                                    </div>
                                </div>
                               </div> 
                            </div>                            
                        </div>                        
                        <div class="field_wrapper">
                            <?php if ($allItems) {
                                foreach ($allItems as $allItem) { ?>
                                    <?php
                                    if ($userType == 'MA') {
                                        $display = '';
                                    } else {
                                        if ($allItem->status) {
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
                                                <input type = "text" class="form-control" name ="item_price" value="<?= $value ?>" required inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0">
                                               /<?= $allItem->unit_name ?>
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0">
                                                <?php if ($userType == 'MA') { ?>
                                                    <?php if (isset($priceMap[$allItem->id])): ?>
                                                    <button type="submit" onclick="return confirm('Do You Want To Update Price For This Item ?');" class="btn btn-warning " style="font-size: 11px; padding: 8px !important;margin-bottom: 5px;"><i class="fa fa-paper-plane"></i> Update Price</button>
                                                    <?php else: ?>
                                                    <button type="submit" onclick="return confirm('Do You Want To Save Price For This Item ?');" class="btn btn-success " style="font-size: 11px; padding: 8px !important;margin-bottom: 5px;"><i class="fa fa-paper-plane"></i> Save Price</button>
                                                    <?php endif; ?>
                                                    <?php if ($allItem->status) { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(16, 83)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/change-item-status/' . encoded($allItem->id) .'/'. encoded($vendor_id)) ?>" class="btn btn-outline-success btn-sm" title="Activate <?= $title ?>" onclick="return confirm('Do You Want To Deactivate This <?= $title ?>');"><i class="fa fa-check"></i> Click to Deactivated </a>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(16, 82)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/change-item-status/' . encoded($allItem->id) .'/'. encoded($vendor_id)) ?>" class="btn btn-outline-danger btn-sm" title="Deactivate <?= $title ?>" onclick="return confirm('Do You Want To Activate This <?= $title ?>');"><i class="fa fa-times"></i> Click to Activated</a>
                                                        <?php } ?>
                                                    <?php } ?>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        const searchCompanyInput = document.getElementById("searchCompanyName");
        const searchItemNameInput = document.getElementById("searchItemName");
        const searchItemPriceInput = document.getElementById("searchItemPrice");

        function filterItems() {
            let companyVal = searchCompanyInput.value.toLowerCase();
            let itemVal = searchItemNameInput.value.toLowerCase();
            let priceVal = searchItemPriceInput.value.toLowerCase();

            let rows = document.querySelectorAll(".item-cover");

            rows.forEach(row => {

                let columns = row.querySelectorAll("div");

                let companyCol = columns[0]?.innerText.toLowerCase();
                let itemCol = columns[1]?.innerText.toLowerCase();
                let priceCol = columns[2]?.querySelector("input")?.value.toLowerCase();

                let matchCompany = companyCol.includes(companyVal);
                let matchItem = itemCol.includes(itemVal);
                let matchPrice = priceCol.includes(priceVal);

                if (matchCompany && matchItem && matchPrice) {
                    row.style.display = "flex";
                } else {
                    row.style.display = "none";
                }

            });
        }

        searchCompanyInput.addEventListener("keyup", filterItems);
        searchItemNameInput.addEventListener("keyup", filterItems);
        searchItemPriceInput.addEventListener("keyup", filterItems);
    });

    function clearPlantSearch() {
        document.getElementById("searchCompanyName").value = "";
        document.getElementById("searchItemName").value = "";
        document.getElementById("searchItemPrice").value = "";

        document.querySelectorAll(".item-cover").forEach(row => {
            row.style.display = "flex";
        });
    }
</script>
