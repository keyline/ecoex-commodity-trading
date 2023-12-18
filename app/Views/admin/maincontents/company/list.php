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
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<section class="section">
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
                    <h5 class="card-title">
                        <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <!-- <th scope="col">Type</th> -->
                                <th scope="col">GST No.<br>Company Name</th>
                                <th scope="col">Company Address<br>Location</th>
                                <th scope="col">Email<br>Phone</th>
                                <th scope="col">Contact Start<br>End</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $sl=1; foreach($rows as $row){?>
                            <tr>
                                <th scope="row"><?=$sl++?></th>
                                <!-- <td><?=$row->type?></td> -->
                                <td><?=$row->gst_no?><br><b><?=$row->company_name?></b></td>
                                <td><?=wordwrap($row->full_address,25,"<br>\n")?><br><?=$row->location?></td>
                                <td><?=$row->email?><br><?=$row->phone?></td>
                                <td>
                                    <?=(($row->contract_start != '')?date_format(date_create($row->contract_start), "M d, Y"):'')?><br>
                                    <?=(($row->contract_end != '')?date_format(date_create($row->contract_end), "M d, Y"):'')?>
                                </td>
                                <td>
                                    <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i></a>
                                    <a target="_blank" href="<?=base_url('admin/' . $controller_route . '/view/'.encoded($row->$primary_key))?>" class="btn btn-outline-info btn-sm" title="View <?=$title?>"><i class="fa fa-info-circle"></i></a>
                                    <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                    <br><br>
                                    <?php if($row->status){?>
                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i> Click To Disapprove</a>
                                    <?php } else {?>
                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i> Click To Approve</a>
                                    <?php }?>
                                    <br><br>
                                    <?php
                                    $assignedCategoryCount = $common_model->find_data('ecomm_company_category', 'count', ['company_id' => $row->$primary_key, 'status!=' => 3]);
                                    if($assignedCategoryCount > 0){
                                        $assignCategoryText = '<br>('.$assignedCategoryCount.' categories)';
                                    } else {
                                        $assignCategoryText = '';
                                    }
                                    ?>
                                    <a href="<?=base_url('admin/' . $controller_route . '/assign-category/'.encoded($row->$primary_key))?>" class="btn btn-warning btn-sm" title="Manage Product Category"><i class="fa fa-tasks"></i> Product Category <?=$assignCategoryText?></a>
                                </td>
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>