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
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>Company Name</td>
                            <td>
                                <?php
                                $company = $common_model->find_data('ecoex_companies', 'row', ['id' => $row->parent_id], 'company_name');
                                echo (($company)?$company->company_name:'');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>GST No.</td>
                            <td><?=$row->gst_no?></td>
                        </tr>
                        <tr>
                            <td>Plant Name</td>
                            <td><?=$row->company_name?></td>
                        </tr>
                        <tr>
                            <td>Plant Address</td>
                            <td><?=$row->full_address?></td>
                        </tr>
                        <!-- <tr>
                            <td>Holding No.</td>
                            <td><?=$row->holding_no?></td>
                        </tr> -->
                        <tr>
                            <td>Street</td>
                            <td><?=$row->street?></td>
                        </tr>
                        <tr>
                            <td>District</td>
                            <td><?=$row->district?></td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td><?=$row->state?></td>
                        </tr>
                        <tr>
                            <td>Pincode</td>
                            <td><?=$row->pincode?></td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td><?=$row->location?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?=$row->email?></td>
                        </tr>
                        <tr>
                            <td>Email Verify</td>
                            <td><span class="badge <?=(($row->email_verify)?'bg-success':'bg-danger')?>"><?=(($row->email_verify)?'YES':'NO')?></span></td>
                        </tr>
                        <tr>
                            <td>Email Verify At</td>
                            <td><?=(($row->email_verified_at != '')?date_format(date_create($row->email_verified_at), "M d Y h:i A"):'')?></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td><?=$row->phone?></td>
                        </tr>
                        <tr>
                            <td>Phone Verify</td>
                            <td><span class="badge <?=(($row->phone_verify)?'bg-success':'bg-danger')?>"><?=(($row->phone_verify)?'YES':'NO')?></span></td>
                        </tr>
                        <tr>
                            <td>Phone Verify At</td>
                            <td><?=(($row->phone_verified_at != '')?date_format(date_create($row->phone_verified_at), "M d Y h:i A"):'')?></td>
                        </tr>
                        <tr>
                            <td>Profile Image</td>
                            <td><img src="<?=(($row->profile_image != '')?getenv('app.uploadsURL').'user/'.$row->profile_image:getenv('app.NO_IMAGE'))?>" class="img-thumbnail" style="width: 150px; height: auto;"></td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td><?=date_format(date_create($row->created_at), "M d Y h:i A")?></td>
                        </tr>
                        <tr>
                            <td>Updated At</td>
                            <td><?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d Y h:i A"):'')?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>