<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];

$userType                   = $session->user_type;
$company_id                 = $session->company_id;
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
                    <?php if($common_model->checkModuleFunctionAccess(14,63)){?>
                        <h5 class="card-title">
                            <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                        </h5>
                    <?php }?>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <!-- <th scope="col">Type</th> -->
                                <th scope="col">GST No.<br>Company Name</th>
                                <th scope="col">Company Address<br>Location</th>
                                <th scope="col">Contact Person Name<br>Email<br>Phone</th>
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
                                <td><?=$row->ho_contact_person_name?><br><?=$row->email?><br><?=$row->phone?></td>
                                <td>
                                    <?=(($row->contract_start != '')?date_format(date_create($row->contract_start), "M d, Y"):'')?><br>
                                    <?=(($row->contract_end != '')?date_format(date_create($row->contract_end), "M d, Y"):'')?>
                                </td>
                                <td>
                                    <?php if($common_model->checkModuleFunctionAccess(14,71)){?>
                                        <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i></a>
                                    <?php }?>
                                    <?php if($common_model->checkModuleFunctionAccess(14,72)){?>
                                        <a target="_blank" href="<?=base_url('admin/' . $controller_route . '/view/'.encoded($row->$primary_key))?>" class="btn btn-outline-info btn-sm" title="View <?=$title?>"><i class="fa fa-info-circle"></i></a>
                                    <?php }?>
                                    <?php //if($userType == 'MA'){?>
                                        <?php if($common_model->checkModuleFunctionAccess(14,70)){?>
                                            <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                            <br><br>
                                        <?php }?>
                                        <?php if($row->status){?>
                                            <?php if($common_model->checkModuleFunctionAccess(14,69)){?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i> Click To Disapprove</a>
                                            <?php }?>
                                        <?php } else {?>
                                            <?php if($common_model->checkModuleFunctionAccess(14,68)){?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i> Click To Approve</a>
                                            <?php }?>
                                        <?php }?>
                                    <?php //}?>
                                    <br><br>
                                    <?php
                                    $assignedCategoryCount = $common_model->find_data('ecomm_company_category', 'count', ['company_id' => $row->$primary_key, 'status!=' => 3]);
                                    if($assignedCategoryCount > 0){
                                        $assignCategoryText = '('.$assignedCategoryCount.')';
                                    } else {
                                        $assignCategoryText = '';
                                    }

                                    $assignedItemCount = $common_model->find_data('ecomm_company_items', 'count', ['company_id' => $row->$primary_key, 'status!=' => 3]);
                                    if($assignedItemCount > 0){
                                        $assignItemText = '('.$assignedItemCount.')';
                                    } else {
                                        $assignItemText = '';
                                    }
                                    ?>
                                    <?php if($common_model->checkModuleFunctionAccess(14,73)){?>
                                        <a href="<?=base_url('admin/' . $controller_route . '/assign-category/'.encoded($row->$primary_key))?>" class="btn btn-info btn-sm" title="Manage Item Category"><i class="fa fa-tasks"></i> Categories <?=$assignCategoryText?></a>
                                        <br><br>
                                    <?php }?>
                                    <?php if($common_model->checkModuleFunctionAccess(14,74)){?>
                                        <a href="<?=base_url('admin/' . $controller_route . '/manage-item/'.encoded($row->$primary_key))?>" class="btn btn-info btn-sm" title="Manage Item"><i class="fa fa-tasks"></i> Items <?=$assignItemText?></a>
                                        <br><br>
                                    <?php }?>
                                    <?php if($common_model->checkModuleFunctionAccess(14,114)){?>
                                        <a href="<?=base_url('admin/' . $controller_route . '/send-credentials/'.encoded($row->$primary_key))?>" class="btn btn-success btn-sm" title="Send Credential <?=$title?>" onclick="return confirm('Do You Want To Send Signin Credentials To This <?=$title?>');"><i class="fa fa-envelope"></i> Send Credentials</a>
                                    <?php }?>
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