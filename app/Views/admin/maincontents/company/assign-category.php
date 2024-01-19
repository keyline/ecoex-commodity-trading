<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;
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
        
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="company_id" id="company_id" value="<?=$company_id?>">
                        <div class="row">
                            <div class="col-md-2">
                                <h5 class="text-success fw-bold">Select</h5>
                            </div>
                            <div class="col-md-5">
                                <h5 class="text-success fw-bold">Product Category</h5>
                            </div>
                            <div class="col-md-5">
                                <h5 class="text-success fw-bold">Alias Name For <?=$company_name?></h5>
                            </div>
                        </div>
                        <?php if($cats){ foreach($cats as $cat){?>
                            <?php
                            $conditions         = ['company_id' => $company_id, 'category_id' => $cat->id, 'status' => 1];
                            $assignCat          = $common_model->find_data('ecomm_company_category', 'row', $conditions);
                            if($assignCat){
                                $category_id    = $assignCat->category_id;
                                $category_alias = $assignCat->category_alias;
                            } else {
                                $category_id    = '';
                                $category_alias = clean($cat->name).'-'.clean($company_name);
                            }
                            ?>
                            <div class="row" style="border:1px solid #0080003b; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                                <div class="col-md-2">
                                    <input type="checkbox" name="category_id[]" value="<?=$cat->id?>" id="category_id<?=$cat->id?>" <?=(($category_id != '')?'checked':'')?>>
                                </div>
                                <div class="col-md-5">
                                    <h6><label for="category_id<?=$cat->id?>"><?=$cat->name?></label></h6>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="category_alias<?=$cat->id?>" class="form-control" placeholder="Enter Alias For <?=$cat->name?>" id="category_alias<?=$cat->id?>" value="<?=$category_alias?>" <?=(($category_id == "")?'readonly':'')?>>
                                </div>
                            </div>
                        <?php } }?>
                        <?php if($userType == 'MA'){?>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Assign</button>
                            </div>
                        <?php }?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // $('input:text').prop('readOnly', true);

        $('input:checkbox').on('click', function () {
            if ($(this).prop('checked')) {
                $(this).parent().nextAll().find('input').prop('readOnly', false);
                $(this).parent().nextAll().find('input').focus();
                $(this).parent().nextAll().find('input').css('background', '#00800021');
                setTimeout(function () {
                    $(this).parent().nextAll().find('input').css('background', '#FFF');
                }, 3000);
            } else {
                $(this).parent().nextAll().find('input').prop('readOnly', true);
                $(this).parent().nextAll().find('input').css('background', '#FFF');
            }
        });
    });
</script>