<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="container-fluid">
    <div class="pagetitle">
        <h1><?= $page_header ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $page_header ?></li>
            </ol>
        </nav>
    </div>
</div>
<section class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php if (session('success_message')) { ?>
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('success_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if (session('error_message')) { ?>
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('error_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php if ($common_model->checkModuleFunctionAccess(28, 143)) { ?>
                            <h5 class="card-titles">
                                <a href="<?= base_url('admin/' . $controller_route . '/add/') ?>" class="btn btn-outline-success btn-sm">Add <?= $title ?></a>
                            </h5>
                        <?php } ?>
                        <div class="table-responsive">
                            <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>State</th>
                                        <!-- <th>Created At / Created By<br>Updated At / Updated By</th> -->
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { ?>
                                            <tr>
                                                <th class="text-center" scope="row"><?= $sl++ ?></th>
                                                <td><?= $row->name ?></td>
                                                <td><?= $row->type ?></td>
                                                <td><?= $row->phone ?></td>
                                                <td><?= $row->email ?></td>
                                                <td><?= $row->state ?></td>
                                                <td width="12%" class="text-center">
                                                    <?php if ($common_model->checkModuleFunctionAccess(28, 145)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/edit/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-primary btn-sm" title="Edit <?= $title ?>"><i class="fa fa-edit"></i></a>
                                                    <?php } ?>
                                                    <?php if ($common_model->checkModuleFunctionAccess(28, 146)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>
                                                    <?php if ($row->status) { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(28, 148)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/change-status/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-success btn-sm" title="Activate <?= $title ?>" onclick="return confirm('Do You Want To Deactivate This <?= $title ?>');"><i class="fa fa-check"></i></a>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(28, 147)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/change-status/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?= $title ?>" onclick="return confirm('Do You Want To Activate This <?= $title ?>');"><i class="fa fa-times"></i></a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>