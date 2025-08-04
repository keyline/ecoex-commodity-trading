<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="container-fluid">
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
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="container-fluid">
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
                    $name     = $row->name;
                    $icon     = $row->icon;
                } else {
                    $name     = '';
                    $icon     = '';
                }
                ?>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <label for="name" class="col-md-2 col-lg-2 col-form-label"><?=$title?> Name</label>
                                <div class="col-md-10 col-lg-10">
                                    <input type="text" name="name" class="form-control" id="name" value="<?=$name?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="icon" class="col-md-2 col-lg-2 col-form-label">Icon</label>
                                <div class="col-md-10 col-lg-10">
                                    <input type="file" name="icon" class="form-control" id="icon">
                                    <small class="text-info">* Only JPG, JPEG, ICO, SVG, PNG files are allowed</small><br>
                                    <?php if ($icon != '') { ?>
                                        <img src="<?= getenv('app.uploadsURL') . 'product/' . $icon ?>" alt="<?= $name ?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                    <?php } else { ?>
                                        <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $name ?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                    <?php } ?>
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
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>