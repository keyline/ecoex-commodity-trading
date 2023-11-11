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
              $module_id        = $row->id;
              $parent_id        = $row->parent_id;
              $module_name      = $row->module_name;
            } else {
              $module_id        = 0;
              $parent_id        = '';
              $module_name      = '';
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="parent_id" class="col-md-2 col-lg-2 col-form-label">Parent Module</label>
                            <div class="col-md-10 col-lg-10">
                                <select name="parent_id" class="form-control" id="parent_id">
                                    <option value="" selected>Select Parent Module</option>
                                    <?php if($parentModules){ foreach($parentModules as $parentModule){?>
                                        <option value="<?=$parentModule->id?>" <?=(($parent_id == $parentModule->id)?'selected':'')?>><?=$parentModule->module_name?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="module_name" class="col-md-2 col-lg-2 col-form-label">Module Name</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="module_name" class="form-control" id="module_name" value="<?=$module_name?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="module_functions" class="col-md-2 col-lg-2 col-form-label">Functions</label>
                            <div class="col-md-10 col-lg-10">
                                <?php
                                $moduleFunctions    = [];
                                $module_functions   = $common_model->find_data('ecoex_module_functions', 'array', ['module_id' => $module_id, 'published!=' => 3], 'function_name');
                                if($module_functions){
                                    foreach($module_functions as $module_function){
                                        $moduleFunctions[]    = $module_function->function_name;
                                    }
                                }
                                ?>
                                <select class="form-control" name="module_functions[]" id="choices-multiple-remove-button" multiple>
                                    <?php if($features){ foreach($features as $feature){?>
                                    <?php
                                    if(in_array($feature->feature_name, $moduleFunctions)){
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }
                                    ?>
                                    <option value="<?=$feature->feature_name?>" <?=$selected?>><?=$feature->feature_name?></option>
                                    <?php } }?>
                                </select>
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