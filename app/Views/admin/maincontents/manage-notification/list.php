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
                    <?php if ($common_model->checkModuleFunctionAccess(19, 92)) { ?>
                        <h5 class="card-titles">
                            <a href="<?= base_url('admin/' . $controller_route . '/new/') ?>" class="btn btn-outline-success btn-sm">Add New</a>
                        </h5>
                    <?php } ?>
                    <?php if (!empty($rows)) { ?>
                        <div class="table-responsive">
                            <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                                <?php  } else {  ?>
                                <table id="" class="table table-striped table-bordered nowrap" style="width: 100%">
                                <?php }  ?>
    
    
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Mails</th>
                                        <th scope="col">Created At<br>Updated At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
    
                                    if (!empty($rows)): $sl = 0 ?>
                                        <?php foreach ($rows as $row): ?>
                                            <tr>
                                                <th scope="row"><?= ++$sl ?></th>
                                                <td><?= json_decode($row->mn_email, true) ?></td>
                                                <td>
                                                    <h6>
                                                        <?= (($row->mn_create_on != '') ? date_format(date_create($row->mn_create_on), "M d, Y h:i A") : '') ?><br>
                                                        <hr>
                                                    </h6>
                                                    <h6>
                                                        <?= (($row->mn_update_on != '') ? date_format(date_create($row->mn_update_on), "M d, Y h:i A") : '') ?>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <?php if ($common_model->checkModuleFunctionAccess(19, 92)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/' . encoded($row->mn_id) . '/edit') ?>" class="btn btn-outline-primary btn-sm" title="Edit <?= $title ?>"><i class="fa fa-edit"></i></a>
                                                    <?php } ?>
                                                    <?php if ($common_model->checkModuleFunctionAccess(19, 92)) { ?>
    
                                                        <form id="delete-form-<?= $row->mn_id ?>" method="POST" action="<?= base_url('admin/' . $controller_route . '/' . encoded($row->mn_id)) ?>" style="display:contents;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                        </form>
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-outline-danger btn-sm"
                                                            title="Delete <?= $title ?>"
                                                            onclick="if(confirm('Do you want to delete this <?= $title ?>?')) document.getElementById('delete-form-<?= $row->mn_id ?>').submit();">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
    
                                                    <?php if ($row->mn_status) { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(19, 92)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/status/' . encoded($row->mn_id) . '/0') ?>" class="btn btn-outline-success btn-sm" title="Activate <?= $title ?>" onclick="return confirm('Do You Want To Deactivate This <?= $title ?>');"><i class="fa fa-check"></i></a>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(19, 92)) { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/status/' . encoded($row->mn_id) . '/1') ?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?= $title ?>" onclick="return confirm('Do You Want To Activate This <?= $title ?>');"><i class="fa fa-times"></i></a>
                                                        <?php } ?>
                                                    <?php } ?>
    
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" style="text-align:center; color:red">No notifications found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>