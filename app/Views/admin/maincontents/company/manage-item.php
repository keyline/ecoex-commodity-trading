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
                            <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">Item<br>Category</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="text-success fw-bold" style="text-align: center;">Item Name</h6>
                            </div>
                            <!-- <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">Alias<br>(App)</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">Billing<br>Name</h6>
                            </div> -->
                            <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">HSN</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">GST</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">Rate</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">Price Range</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">Unit</h6>
                            </div>
                            
                            <div class="col-md-1">
                                <h6 class="text-success fw-bold" style="text-align: center;">Action</h6>
                            </div>
                        </div>
                        <div class="field_wrapper">
                            <?php if ($assignItems) {
                                foreach ($assignItems as $assignItem) { ?>
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
                                    <form method="POST" action="<?= base_url('admin/companies/approve-item') ?>" style="display: <?= $display ?>;" enctype="multipart/form-data">
                                        <input type="hidden" name="company_id" id="company_id" value="<?= $company_id ?>">
                                        <input type="hidden" name="id" value="<?= encoded($assignItem->id) ?>">
                                        <input type="hidden" name="redirect_link" value="<?= encoded(current_url()) ?>">
                                        <div class="row item-cover" style="margin-left: 0; margin-right: 0;">
                                            <div class="col-md-1 mb-3 mb-md-0">
                                                <select class="form-control" name="item_category[]">
                                                    <option value="" selected>Select</option>
                                                    <?php if ($cats) {
                                                        foreach ($cats as $cat) { ?>
                                                            <option value="<?= $cat->category_id ?>" <?= (($cat->category_id == $assignItem->item_category) ? 'selected' : '') ?>><?= $cat->category_alias ?></option>
                                                    <?php }
                                                        } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0">
                                                <input type="text" name="item_name_ecoex[]" class="form-control" placeholder="Item Ecoex" value="<?= $assignItem->item_name_ecoex ?>">
                                            </div>
                                            <!-- <div class="col-md-1 mb-3 mb-md-0">
                                                <input type="text" name="alias_name[]" class="form-control" placeholder="Alias Name" value="?= $assignItem->alias_name ?>">
                                            </div>
                                            <div class="col-md-1 mb-3 mb-md-0">
                                                <input type="text" name="billing_name[]" class="form-control" placeholder="Billing Name" value="?= $assignItem->billing_name ?>">
                                            </div> -->
                                            <div class="col-md-1 mb-3 mb-md-0">
                                                <input type="text" name="hsn[]" class="form-control" placeholder="HSN" value="<?= $assignItem->hsn ?>">
                                            </div>
                                            <div class="col-md-1 mb-3 mb-md-0">
                                                <select class="form-control" name="gst[]">
                                                    <option value="" selected>Select</option>
                                                    <option value="0" <?= (($assignItem->gst == 0) ? 'selected' : '') ?>>0 %</option>
                                                    <option value="5" <?= (($assignItem->gst == 5) ? 'selected' : '') ?>>5 %</option>
                                                    <option value="12" <?= (($assignItem->gst == 12) ? 'selected' : '') ?>>12 %</option>
                                                    <option value="18" <?= (($assignItem->gst == 18) ? 'selected' : '') ?>>18 %</option>
                                                    <option value="28" <?= (($assignItem->gst == 28) ? 'selected' : '') ?>>28 %</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1 mb-3 mb-md-0">
                                                <input type="text" name="rate[]" class="form-control" placeholder="Rate" value="<?= $assignItem->rate ?>">
                                            </div>
                                            <div class="col-md-1 mb-3 mb-md-0">
                                                <input type="text" name="price_range[]" class="form-control" placeholder="Price Range" value="<?= $assignItem->price_range ?>">
                                            </div>
                                            <div class="col-md-1 mb-3 mb-md-0">
                                                <select class="form-control" name="unit[]">
                                                    <option value="" selected>Select</option>
                                                    <?php if ($units) {
                                                        foreach ($units as $unit) { ?>
                                                            <option value="<?= $unit->id ?>" <?= (($unit->id == $assignItem->unit) ? 'selected' : '') ?>><?= $unit->name ?></option>
                                                    <?php }
                                                        } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0">
                                                <input type="file" name="icon" class="form-control" placeholder="Icon">
                                                <?php if ($assignItem->icon != '') { ?>
                                                    <img src="<?= getenv('app.uploadsURL') . 'product/' . $assignItem->icon ?>" alt="<?= $assignItem->item_name_ecoex ?>" class="img-thumbnail" style="width: 75px; height: 75px; margin-top: 10px;">
                                                <?php }?>
                                            </div>
                                            <div class="col-md-1 mb-3 mb-md-0">
                                                <?php if ($assignItem->status) { ?>
                                                    <p style="margin-bottom: 5px;"><span class="badge rounded-pill bg-success w-100" style="font-size: 9px; padding: 8px;"><i class="fa fa-check-circle"></i> APPROVED</span></p>
                                                    <?php if ($userType == 'MA') { ?>
                                                        <button type="submit" onclick="return confirm('Do You Want To Approve This Item ?');" class="btn btn-primary w-100 btn-sm p-2" style="font-size: 11px; padding: 8px !important; margin-bottom: 5px;"><i class="fa fa-edit"></i> Update</button>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if ($userType == 'MA') { ?>
                                                        <button type="submit" onclick="return confirm('Do You Want To Approve This Item ?');" class="btn btn-warning w-100" style="font-size: 11px; padding: 8px !important;margin-bottom: 5px;"><i class="fa fa-times-circle"></i> Click To Approve</button>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($userType == 'MA') { ?>
                                                    <a href="<?= base_url('admin/companies/manage-item-delete/' . encoded($assignItem->id)) ?>" class="btn btn-danger btn-sm w-100 remove_button ms-auto" title="Remove Item" onclick="return confirm('Do You Want To Remove This Item ?');"><i class="fa fa-trash"></i> Remove</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </form>
                            <?php }
                                } ?>
                            <?php if ($userType == 'MA') { ?>
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="company_id" id="company_id" value="<?= $company_id ?>">
                                    <input type="hidden" name="id" value="<?= encoded($company_id) ?>">
                                    <input type="hidden" name="redirect_link" value="<?= encoded(current_url()) ?>">
                                    <div class="row item-cover" style="margin-left: 0; margin-right: 0;">
                                        <div class="col-md-1 mb-3 mb-md-0">
                                            <select class="form-control" name="item_category[]">
                                                <option value="" selected>Select</option>
                                                <?php if ($cats) {
                                                    foreach ($cats as $cat) { ?>
                                                        <option value="<?= $cat->category_id ?>"><?= $cat->category_alias ?></option>
                                                <?php }
                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3 mb-md-0">
                                            <input type="text" name="item_name_ecoex[]" class="form-control" placeholder="Item Ecoex">
                                        </div>
                                        <!-- <div class="col-md-1 mb-3 mb-md-0">
                                            <input type="text" name="alias_name[]" class="form-control" placeholder="Alias Name">
                                        </div>
                                        <div class="col-md-1 mb-3 mb-md-0">
                                            <input type="text" name="billing_name[]" class="form-control" placeholder="Billing Name">
                                        </div> -->
                                        <div class="col-md-1 mb-3 mb-md-0">
                                            <input type="text" name="hsn[]" class="form-control" placeholder="HSN">
                                        </div>
                                        <div class="col-md-1 mb-3 mb-md-0">
                                            <select class="form-control" name="gst[]">
                                                <option value="" selected>Select</option>
                                                <option value="0">0 %</option>
                                                <option value="5">5 %</option>
                                                <option value="12">12 %</option>
                                                <option value="18">18 %</option>
                                                <option value="28">28 %</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-3 mb-md-0">
                                            <input type="text" name="rate[]" class="form-control" placeholder="Rate">
                                        </div>
                                        <div class="col-md-1 mb-3 mb-md-0">
                                            <input type="text" name="price_range[]" class="form-control" placeholder="Price Range">
                                        </div>
                                        <div class="col-md-1 mb-3 mb-md-0">
                                            <select class="form-control" name="unit[]">
                                                <option value="" selected>Select</option>
                                                <?php if ($units) {
                                                    foreach ($units as $unit) { ?>
                                                        <option value="<?= $unit->id ?>"><?= $unit->name ?></option>
                                                <?php }
                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3 mb-md-0">
                                            <input type="file" name="icon" class="form-control" placeholder="Icon">
                                        </div>
                                        <div class="col-md-1 mb-3 mb-md-0">
                                            <?php if ($userType == 'MA') { ?>
                                                <button type="submit" onclick="return confirm('Do You Want To Add This Item ?');" class="btn btn-success btn-sm" style="font-size: 11px; padding: 8px !important;"><i class="fa fa-check-circle"></i> Click To Add</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>

                        <!-- <div class="text-center">
                                <a href="javascript:void(0);" class="btn btn-success btn-sm add_button" title="Add New Item"><i class="fa fa-plus-circle"></i> Add More Items</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // $('input:text').prop('readOnly', true);
        $('input:checkbox').on('click', function() {
            if ($(this).prop('checked')) {
                $(this).parent().nextAll().find('input').prop('readOnly', false);
                $(this).parent().nextAll().find('input').focus();
                $(this).parent().nextAll().find('input').css('background', '#00800021');
                setTimeout(function() {
                    $(this).parent().nextAll().find('input').css('background', '#FFF');
                }, 3000);
            } else {
                $(this).parent().nextAll().find('input').prop('readOnly', true);
                $(this).parent().nextAll().find('input').css('background', '#FFF');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<form method="POST" action="<?= base_url('admin/companies/approve-item') ?>" enctype="multipart/form-data">\
                            <input type="hidden" name="company_id" id="company_id" value="<?= $company_id ?>">\
                            <input type="hidden" name="redirect_link" value="<?= encoded(current_url()) ?>">\
                            <div class="row item-cover" style="margin-left: 0; margin-right: 0;">\
                                <div class="col-md-1 mb-3 mb-md-0">\
                                    <select class="form-control" name="item_category[]">\
                                        <option value="" selected>Select</option>\
                                        <?php if ($cats) {
                                            foreach ($cats as $cat) { ?> <
            option value = "<?= $cat->category_id ?>" > <?= $cat->category_alias ?> < /option>\
    <?php }
                                            } ?>
        <
        /select>\ <
        /div>\ <
        div class = "col-md-2 mb-3 mb-md-0" > \
        <
        input type = "text"
    name = "item_name_ecoex[]"
    class = "form-control"
    placeholder = "Item Ecoex" > \
        <
        /div>\ <
        div class = "col-md-1 mb-3 mb-md-0" > \
        <
        input type = "text"
    name = "alias_name[]"
    class = "form-control"
    placeholder = "Alias Name" > \
        <
        /div>\ <
        div class = "col-md-1 mb-3 mb-md-0" > \
        <
        input type = "text"
    name = "billing_name[]"
    class = "form-control"
    placeholder = "Billing Name" > \
        <
        /div>\ <
        div class = "col-md-1 mb-3 mb-md-0" > \
        <
        input type = "text"
    name = "hsn[]"
    class = "form-control"
    placeholder = "HSN" > \
        <
        /div>\ <
        div class = "col-md-1 mb-3 mb-md-0" > \
        <
        select class = "form-control"
    name = "gst[]" > \
        <
        option value = ""
    selected > Select < /option>\ <
        option value = "0" > 0 % < /option>\ <
        option value = "5" > 5 % < /option>\ <
        option value = "12" > 12 % < /option>\ <
        option value = "18" > 18 % < /option>\ <
        option value = "28" > 28 % < /option>\ <
        /select>\ <
        /div>\ <
        div class = "col-md-1 mb-3 mb-md-0" > \
        <
        input type = "text"
    name = "rate[]"
    class = "form-control"
    placeholder = "Rate" > \
        <
        /div>\ <
        div class = "col-md-1 mb-3 mb-md-0" > \
        <
        select class = "form-control"
    name = "unit[]" > \
        <
        option value = ""
    selected > Select < /option>\
    <?php if ($units) {
        foreach ($units as $unit) { ?>
                <
                option value = "<?= $unit->id ?>" > <?= $unit->name ?> < /option>\
    <?php }
        } ?>
        <
        /select>\ <
        /div>\ <
        div class = "col-md-2 mb-3 mb-md-0" > \
        <
        input type = "file"
    name = "icon[]"
    class = "form-control"
    placeholder = "Icon" > \
        <
        /div>\ <
        div class = "col-md-1 mb-3 mb-md-0" > \
        <
        a href = "javascript:void(0);"
    class = "btn btn-danger btn-sm remove_button"
    title = "Remove Item" > < i class = "fa fa-trash" > < /i> Remove</a > \
        <
        /div>\ <
        /div>\ <
        /form>';
    var x = 1; //Initial field counter is 1

    // Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        } else {
            alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
        }
    });

    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });
    });
</script>