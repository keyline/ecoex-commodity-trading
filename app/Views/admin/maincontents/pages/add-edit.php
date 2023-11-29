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
              $page_title               = $row->page_title;
              $short_description        = $row->short_description;
              $long_description         = $row->long_description;
              $meta_title               = $row->meta_title;
              $meta_description         = $row->meta_description;
              $meta_keywords            = $row->meta_keywords;
            } else {
              $page_title               = '';
              $short_description        = '';
              $long_description         = '';
              $meta_title               = '';
              $meta_description         = '';
              $meta_keywords            = '';
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="page_title" class="col-md-2 col-lg-2 col-form-label"><?=$title?> Title</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="page_title" class="form-control" id="page_title" value="<?=$page_title?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="short_description" class="col-md-2 col-lg-2 col-form-label"><?=$title?> Short Description</label>
                            <div class="col-md-10 col-lg-10">
                                <textarea name="short_description" class="form-control ckeditor" id="short_description" rows="5" required><?=$short_description?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="long_description" class="col-md-2 col-lg-2 col-form-label"><?=$title?> Long Description</label>
                            <div class="col-md-10 col-lg-10">
                                <textarea name="long_description" class="form-control ckeditor" id="long_description" rows="5"><?=$long_description?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="meta_title" class="col-md-2 col-lg-2 col-form-label"><?=$title?> Meta Title</label>
                            <div class="col-md-10 col-lg-10">
                                <textarea name="meta_title" class="form-control" id="meta_title" rows="5"><?=$meta_title?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="meta_description" class="col-md-2 col-lg-2 col-form-label"><?=$title?> Meta Description</label>
                            <div class="col-md-10 col-lg-10">
                                <textarea name="meta_description" class="form-control" id="meta_description" rows="5"><?=$meta_description?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="meta_keywords" class="col-md-2 col-lg-2 col-form-label"><?=$title?> Meta Keywords</label>
                            <div class="col-md-10 col-lg-10">
                                <textarea name="meta_keywords" class="form-control" id="meta_keywords" rows="5"><?=$meta_keywords?></textarea>
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