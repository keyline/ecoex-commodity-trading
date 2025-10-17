<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];

$userType                   = $session->user_type;
//$company_id                 = $session->company_id;
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
                        
                        <div class="table-responsive">
                            <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                                <thead>
                                    <tr>                               
                                        <th class="text-center" width="5%">ID</th>
                                        <th>Enquiry ID</th>
                                        <th>Product ID</th>
                                        <th>User</th>
                                        <th>WhatsApp</th>
                                        <th>Action</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($interactions as $row): ?>
                                      <tr>
                                        <td><?= esc($row['id']) ?></td>
                                        <td><?= esc($row['enquiry_id']) ?></td>
                                        <td><?= esc($row['product_id']) ?></td>
                                        <td><?= esc($row['user_name']) ?></td>
                                        <td><?= esc($row['wa_id']) ?></td>
                                        <td><?= ucfirst(esc($row['button_action'])) ?></td>
                                        <td><?= esc($row['created_at']) ?></td>
                                      </tr>
                                      <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>