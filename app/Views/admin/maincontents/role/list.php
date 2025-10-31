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
                        <h5 class="card-titles">
                            <a href="<?= base_url('admin/' . $controller_route . '/add/') ?>" class="btn btn-outline-success btn-sm">Add <?= $title ?></a>
                        </h5>
                        <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center" width="7%">#</th>
                                    <th>Role Name</th>
                                    <th>Access Plants</th>
                                    <th class="text-center" width="12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($rows) {
                                    $sl = 1;
                                    foreach ($rows as $row) { ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $sl++ ?></th>
                                            <td><?= $row->role_name ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/' . $controller_route . '/access-plant/' . encoded($row->$primary_key)) ?>" class="btn btn-warning btn-sm" title="Access Plant"><i class="fa fa-universal-access"></i> Access Plant</a><br><br>
                                                <?php
                                                $plant_ids = ($row->plant_ids != '') ? json_decode($row->plant_ids, true) : [];
                                               
                                                if (!empty($plant_ids)) {
                                                    // sanitize
                                                    $plant_ids = array_map('intval', $plant_ids);
                                                    $plant_id_string = implode(',', $plant_ids);
                                                    $db = \Config\Database::connect();
                                                    $builder = $db->table('ecomm_users');
                                                    $builder->select('plant_name');
                                                    $builder->whereIn('id', $plant_id_string);
                                                    $builder->where('status', 1);
                                                    $query = $builder->get();

                                                    $plants = $query->getResult();
                                                    pr($plants);
                                                    $plant_names = [];

                                                    foreach ($plants as $p) {
                                                        $plant_names[] = $p->plant_name;
                                                    }

                                                    echo !empty($plant_names) ? implode(', ', $plant_names) : 'No Plants';
                                                } else {
                                                    echo 'No Plants';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/' . $controller_route . '/edit/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-primary btn-sm" title="Edit <?= $title ?>"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i></a>
                                                <?php if ($row->published) { ?>
                                                    <a href="<?= base_url('admin/' . $controller_route . '/change-status/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-success btn-sm" title="Activate <?= $title ?>" onclick="return confirm('Do You Want To Deactivate This <?= $title ?>');"><i class="fa fa-check"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('admin/' . $controller_route . '/change-status/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?= $title ?>" onclick="return confirm('Do You Want To Activate This <?= $title ?>');"><i class="fa fa-times"></i></a>
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
</section>