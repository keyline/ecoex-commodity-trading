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
              $user_type        = $row->user_type;
              $title            = $row->title;
              $description      = $row->description;
            } else {
              $user_type        = '';
              $title            = '';
              $description      = '';
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="user_type" class="col-md-2 col-lg-2 col-form-label">User Type</label>
                            <div class="col-md-10 col-lg-10">
                                <select name="user_type" class="form-control" id="user_type" required>
                                    <option value="" selected>Select User Type</option>
                                    <option value="PLANT" <?=(($user_type == 'PLANT')?'selected':'')?>>PLANT</option>
                                    <option value="VENDOR" <?=(($user_type == 'VENDOR')?'selected':'')?>>VENDOR</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-lg-2 col-form-label">Title</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="title" class="form-control" id="title" value="<?=$title?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-2 col-lg-2 col-form-label">Description</label>
                            <div class="col-md-10 col-lg-10">
                                <textarea name="description" class="form-control" id="description" rows="5" required><?=$description?></textarea>
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