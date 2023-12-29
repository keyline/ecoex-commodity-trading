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
                                <th scope="col">Type</th>
                                <th scope="col">Entity Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Comments</th>
                                <th scope="col">Created At<br>Updated At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $sl=1; foreach($rows as $row){?>
                            <tr>
                                <th scope="row"><?=$sl++?></th>
                                <td><?=$row->user_type?></td>
                                <td><?=$row->entity_name?></td>
                                <td>
                                    <?=$row->email?><br>
                                    <span class="badge <?=(($row->is_email_verify)?'bg-success':'bg-danger')?>"><?=(($row->is_email_verify)?'APPROVED':'PENDING')?></span>
                                </td>
                                <td>
                                    <?=$row->phone?><br>
                                    <span class="badge <?=(($row->is_phone_verify)?'bg-success':'bg-danger')?>"><?=(($row->is_phone_verify)?'APPROVED':'PENDING')?></span>
                                </td>
                                <td><?=$row->comments?></td>
                                <td>
                                    <h6>
                                        <?=(($row->created_at != '')?date_format(date_create($row->created_at), "M d, Y h:i A"):'')?><br>
                                        <hr>
                                    </h6>
                                    <h6>
                                        <?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d, Y h:i A"):'')?><br>
                                    </h6>
                                </td>
                                <td>
                                    <?php if($row->status){?>
                                        <!-- <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i></a> -->
                                        <span class="badge bg-success"><i class="fa fa-check"></i> APPROVED</span>
                                        <h6><?=date_format(date_create($row->approve_date), 'M d, Y h:i A')?></h6>
                                    <?php } else {?>
                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i> Click To Approve</a>
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