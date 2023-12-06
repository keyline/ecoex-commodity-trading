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
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Enquiry No.</th>
                                <th scope="col">Tentative Collection Date</th>
                                <th scope="col">Latitude<br>Longitude</th>
                                <th scope="col">Created At<br>Created By<br>Updated At<br>Updated By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $sl=1; foreach($rows as $row){?>
                            <tr>
                                <th scope="row"><?=$sl++?></th>
                                <td><?=$row->enquiry_no?></td>
                                <td><?=date_format(date_create($row->tentative_collection_date), "M d, Y")?></td>
                                <td><?=$row->latitude?><br><?=$row->longitude?></td>
                                <td>
                                    <h6>
                                        <?=(($row->created_at != '')?date_format(date_create($row->created_at), "M d, Y h:i A"):'')?><br>
                                        <?php
                                        if($row->created_by > 0){
                                            $adminUser = $common_model->find_data('ecomm_users', 'row', ['id' => $row->created_by], 'company_name');
                                        ?>
                                            <small><?=(($adminUser)?$adminUser->company_name:'')?></small>
                                        <?php }?>
                                        <hr>
                                    </h6>
                                    <h6>
                                        <?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d, Y h:i A"):'')?><br>
                                        <?php
                                        if($row->updated_by > 0){
                                            $adminUser = $common_model->find_data('ecomm_users', 'row', ['id' => $row->updated_by], 'company_name');
                                        ?>
                                            <small><?=(($adminUser)?$adminUser->company_name:'')?></small>
                                        <?php }?>
                                    </h6>
                                </td>
                                <td>
                                    <a href="<?=base_url('admin/' . $controller_route . '/view-detail/'.encoded($row->$primary_key))?>" class="btn btn-outline-info btn-sm" title="Edit <?=$title?>"><i class="fa fa-eye"></i></a>
                                    <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                    
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