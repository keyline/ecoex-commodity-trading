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
                    <!-- <h5 class="card-title">
                        <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                    </h5> -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Enquiry No.</th>
                                <th scope="col">Product Category</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">HSN Code</th>
                                <th scope="col">Image</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Created At<br>Updated At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $sl=1; foreach($rows as $row){?>
                            <tr>
                                <th scope="row"><?=$sl++?></th>
                                <td>
                                    <?php
                                    $enquiry = $common_model->find_data('ecomm_enquires', 'row', ['id' => $row->enq_id]);
                                    echo (($enquiry)?$enquiry->enquiry_no:'');
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $productCategory = $common_model->find_data('ecomm_product_categories', 'row', ['id' => $row->category_id]);
                                    echo (($productCategory)?$productCategory->name:'');
                                    ?>
                                </td>
                                <td><?=$row->product_name?></td>
                                <td><?=$row->hsn_code?></td>
                                <td>
                                    <?php if($row->product_image != ''){?>
                                        <img src="<?=getenv('app.uploadsURL').'enquiry/'.$row->product_image?>" alt="<?=$row->product_name?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                    <?php } else {?>
                                        <img src="<?=getenv('app.NO_IMG')?>" alt="<?=$row->product_name?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                    <?php }?>
                                </td>
                                <td><?=$row->remarks?></td>
                                <td>
                                    <h6>
                                        <?=(($row->created_at != '')?date_format(date_create($row->created_at), "M d, Y h:i A"):'')?>
                                    </h6>
                                    <h6>
                                        <?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d, Y h:i A"):'')?>
                                    </h6>
                                </td>
                                <td>
                                    <?php if($row->status){?>
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm"><i class="fa fa-check"></i> APPROVED</a>
                                    <?php } else {?>
                                        <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-warning btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Approve This <?=$title?> ? Once You Approve This You Cant be Able To Edit Or Delete. Do You Want To Still Continue ?');"><i class="fa fa-times"></i> Click To Approve</a>
                                        <br><br>
                                        <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i> Delete</a>
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