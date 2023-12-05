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
            <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
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
        <?php
            if($row){
              $category_id      = $row->category_id;
              $product_name     = $row->product_name;
              $hsn_code         = $row->hsn_code;
              $product_image    = $row->product_image;
            } else {
              $category_id      = '';
              $product_name     = '';
              $hsn_code         = '';
              $product_image    = '';
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="category_id" class="col-md-2 col-lg-2 col-form-label">Product Category</label>
                            <div class="col-md-10 col-lg-10">
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option value="" selected>Select Product Category</option>
                                    <?php if($cats){ foreach($cats as $st){?>
                                    <option value="<?=$st->id?>" <?=(($st->id == $category_id)?'selected':'')?>><?=$st->name?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="product_name" class="col-md-2 col-lg-2 col-form-label"><?=$title?> Name</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="product_name" class="form-control" id="product_name" value="<?=$product_name?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hsn_code" class="col-md-2 col-lg-2 col-form-label"><?=$title?> HSN Code</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="hsn_code" class="form-control" id="hsn_code" value="<?=$hsn_code?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="product_image" class="col-md-2 col-lg-2 col-form-label">Product Image</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="file" name="product_image" class="form-control" id="product_image">
                                <small class="text-info">* Only JPG, JPEG, ICO, SVG, PNG files are allowed</small><br>
                                <?php if($product_image != ''){?>
                                  <img src="<?=getenv('app.uploadsURL').'enquiry/'.$product_image?>" alt="<?=$product_name?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                <?php } else {?>
                                  <img src="<?=getenv('app.NO_IMG')?>" alt="<?=$product_name?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                <?php }?>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?=(($row)?'Save':'Add')?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>