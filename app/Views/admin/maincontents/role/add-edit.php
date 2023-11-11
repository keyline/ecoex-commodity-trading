<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<style type="text/css">
    .choices__list--multiple .choices__item {
        background-color: #48974e;
        border: 1px solid #48974e;
    }
</style>
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
              $role_id          = $row->id;
              $role_name        = $row->role_name;
            } else {
              $role_id          = 0;
              $role_name        = '';
            }
            ?>
        <div class="col-xl-12">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Role Name</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="role_name" class="form-control" id="role_name" value="<?=$role_name?>" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?=(($row)?'Save':'Add')?></button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Module Wise Access</h5>
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="width: 20%;">
                                <?php if($parentModules){ $sl=1; foreach($parentModules as $parentModule){?>
                                    <button class="nav-link <?=(($sl == 1)?'active':'')?>" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?=$parentModule->id?>" type="button" role="tab" aria-controls="v-pills-<?=$parentModule->id?>" aria-selected="<?=(($sl == 1)?'true':'false')?>"><?=$parentModule->module_name?></button>
                                <?php $sl++; } }?>
                            </div>
                            <div class="tab-content" id="v-pills-tabContent" style="width: 80%;">
                                <?php if($parentModules){ $sl=1; foreach($parentModules as $parentModule){?>
                                    <div class="tab-pane fade <?=(($sl == 1)?'show active':'')?>" id="v-pills-<?=$parentModule->id?>" role="tabpanel" aria-labelledby="v-pills-<?=$parentModule->id?>-tab">
                                        <div class="row">
                                            <?php
                                            $childModules = $common_model->find_data('ecoex_modules', 'array', ['parent_id' => $parentModule->id, 'published!=' => 3], 'id,module_name');
                                            if($childModules){ foreach($childModules as $childModule){
                                            ?>
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header bg-success text-white">
                                                            <?=$childModule->module_name?>
                                                            <input type="hidden" name="module_id[]" value="<?=$childModule->id?>">
                                                        </div>
                                                        <div class="card-body" style="padding:10px;">
                                                            <?php
                                                            $moduleFeatures = $common_model->find_data('ecoex_module_functions', 'array', ['module_id' => $childModule->id, 'published!=' => 3], 'function_id,function_name');
                                                            if($moduleFeatures){ foreach($moduleFeatures as $moduleFeature){
                                                                $checkFeatureChecked = $common_model->find_data('ecoex_role_module_function', 'count', ['role_id' => $role_id, 'module_id' => $childModule->id, 'function_id' => $moduleFeature->function_id, 'published!=' => 3]);
                                                            ?>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" name="function_id<?=$childModule->id?>[]" id="feature<?=$moduleFeature->function_id?>" value="<?=$moduleFeature->function_id?>" <?=(($checkFeatureChecked > 0)?'checked':'')?>>
                                                                <label class="form-check-label" for="feature<?=$moduleFeature->function_id?>"><?=$moduleFeature->function_name?></label>
                                                            </div>
                                                            <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } } else {?>
                                                <input type="hidden" name="module_id[]" value="<?=$parentModule->id?>">
                                                <?php
                                                $moduleFeatures = $common_model->find_data('ecoex_module_functions', 'array', ['module_id' => $parentModule->id, 'published!=' => 3], 'function_id,function_name');
                                                if($moduleFeatures){ foreach($moduleFeatures as $moduleFeature){
                                                    $checkFeatureChecked = $common_model->find_data('ecoex_role_module_function', 'count', ['role_id' => $role_id, 'module_id' => $parentModule->id, 'function_id' => $moduleFeature->function_id, 'published!=' => 3]);
                                                ?>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="function_id<?=$parentModule->id?>[]" id="feature<?=$moduleFeature->function_id?>" value="<?=$moduleFeature->function_id?>" <?=(($checkFeatureChecked > 0)?'checked':'')?>>
                                                    <label class="form-check-label" for="feature<?=$moduleFeature->function_id?>"><?=$moduleFeature->function_name?></label>
                                                </div>
                                                <?php } }?>
                                            <?php }?>
                                        </div>
                                    </div>
                                <?php $sl++; } }?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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