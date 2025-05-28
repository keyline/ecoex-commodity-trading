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
                        <?php if ($common_model->checkModuleFunctionAccess(16, 112)) { ?>
                            <h5 class="card-titles">
                                <a href="<?= base_url('admin/' . $controller_route . '/add/') ?>" class="btn btn-outline-success btn-sm">Add <?= $title ?></a>
                            </h5>
                        <?php } ?>
                        <div class="table-responsive">
                            <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th>Type</th>
                                        <th>GST No</th>
                                        <th>Company Name</th>
                                        <th>Vendor Address</th>
                                        <th>Location</th>
                                        <th>Email</th>
                                        <th class="text-start">Phone</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $sl++ ?></th>
                                                <td>
                                                    <strong>
                                                        <?php
                                                        $memberType = $common_model->find_data('ecomm_member_types', 'row', ['id' => $row->member_type], 'name');
                                                        echo (($memberType) ? $memberType->name : '');
                                                        ?>
                                                    </strong>
                                                </td>
                                                <td><?= $row->gst_no ?></td>
                                                <td><?= $row->company_name ?></td>
                                                <td><?= wordwrap($row->full_address, 25, "<br>\n") ?></td>
                                                <td><?= $row->location ?></td>
                                                <td><?= $row->email ?></td>
                                                <td><?= $row->phone ?></td>
                                                <td class="text-center" width="12%">
                                                    <?php if ($common_model->checkModuleFunctionAccess(16, 85)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/edit/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-primary btn-sm" title="Edit <?= $title ?>"><i class="fa fa-edit"></i></a>
                                                    <?php } ?>
                                                    <?php if ($common_model->checkModuleFunctionAccess(16, 86)) { ?>
                                                        <a target="_blank" href="<?= base_url('admin/' . $controller_route . '/view/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-info btn-sm" title="View <?= $title ?>"><i class="fa fa-info-circle"></i></a>
                                                    <?php } ?>
                                                    <?php if ($common_model->checkModuleFunctionAccess(16, 84)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>
                                                    <?php if ($row->status) { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(16, 83)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/change-status/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-danger btn-sm" title="Activate <?= $title ?>" onclick="return confirm('Do You Want To Deactivate This <?= $title ?>');"><i class="fa fa-times"></i></a>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(16, 82)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/change-status/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-danger btn-sm mt-2" title="Deactivate <?= $title ?>" onclick="return confirm('Do You Want To Activate This <?= $title ?>');"><i class="fa fa-check"></i></a>
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