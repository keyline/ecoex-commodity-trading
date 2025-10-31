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
                <li class="breadcrumb-item active"><?=$page_header?></li>
            </ol>
        </nav>
    </div>
</div>
<section class="section">
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table globel_table nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center" width="7%">#</th>
                                    <th>Plant Name</th>
                                    <th>Plant Address</th>
                                    <th>Plant State</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($plantLists){ $sl=1; foreach($plantLists as $plant){?>
                                <tr>
                                    <th scope="row" class="text-center">
                                        <?=$sl++?><br><br>
                                        <input type="checkbox" name="plant_ids[]" value="<?=$plant->id?>" <?=(in_array($plant->id, (($row->plant_ids != '')?json_decode($row->plant_ids):[]))?'checked':'')?>>
                                    </th>
                                    <td><?=$plant->plant_name?></td>
                                    <td><?=$plant->full_address?></td>
                                    <td><?=$plant->state?></td>
                                </tr>
                                <?php } }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>