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
                                        <th class="text-center" width="5%">#Job Id</th>
                                        <th>Enquiry Id</th>
                                        <th>Status</th>
                                        <th>Total Recipient</th>
                                        <th>Total Messages</th>
                                        <th>Failed</th>
                                        <th>Created At<br>Started At</th>
                                        <th>Finished At</th>
                                        <th class="text-center" width="12%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { ?>
                                            <?php $data = json_decode($row['enquiry_meta'], true);?>

                                            <tr>
                                                <th scope="row" class="text-center"><?= $row['id'] ?></th>
                                                
                                                
                                                <td><?= $data['enquiry_no'] ?></td>
                                                <td><?= $row['status'] ?></td>
                                                <td><?= $row['total_recipients'] ?></td>
                                                <td><?= $row['total_messages'] ?></td>
                                                <td><?= $row['failed'] ?></td>
                                                <td>
                                                    <?= (($row['created_at'] != '') ? date_format(date_create($row['created_at']), "M d, Y h:i A") : '') ?><br>
                                                    <?= (($row['started_at'] != '') ? date_format(date_create($row['started_at']), "M d, Y h:i A") : '') ?>
                                                </td>
                                                <td>
                                                    <h6>
                                                        <?= (($row['finished_at'] != '') ? date_format(date_create($row['finished_at']), "M d, Y h:i A") : '') ?>
                                                        <hr>
                                                    </h6>
                                                    
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($row['failed'] > 0) {?>
                                                        <form action="<?= site_url('admin/whatsapp/failed/retry/' . $row['id']) ?>" method="post" style="display:inline;">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-info btn-sm">
                                                                Retry
                                                            </button>
                                                        </form>
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