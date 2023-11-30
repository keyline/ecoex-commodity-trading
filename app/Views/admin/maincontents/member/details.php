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
            <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
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
                            <td>GST No.</td>
                            <td><?=$row->gst_no?></td>
                        </tr>
                        <tr>
                            <td>Company Name</td>
                            <td><?=$row->company_name?></td>
                        </tr>
                        <tr>
                            <td>Full Address</td>
                            <td><?=$row->full_address?></td>
                        </tr>
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
                        <!-- <tr>
                            <td>Location</td>
                            <td><?=$row->location?></td>
                        </tr> -->
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
                            <td><img src="<?=(($row->profile_image != '')?getenv('app.uploadsURL').'user/'.$row->profile_image:getenv('app.NO_IMAGE'))?>" class="img-thumbnail" style="width: 250px; height: auto;"></td>
                        </tr>
                        <tr>
                            <td>Member Type</td>
                            <td>
                                <?php 
                                $memberType = $common_model->find_data('ecomm_member_types', 'row', ['id' => $row->member_type], 'id,name');
                                echo (($memberType)?$memberType->name:'');
                                ?>
                            </td>
                        </tr>


                        <tr>
                            <td>GST Certificate</td>
                            <td>
                                <?php if($row->gst_certificate != ''){?>
                                    <a href="<?=getenv('app.uploadsURL').'user/'.$row->gst_certificate?>" class="badge bg-primary" target="_blank">View Document</a>
                                <?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td>Proprietor Name</td>
                            <td><?=$row->contact_person_name?></td>
                        </tr>
                        <tr>
                            <td>Proprietor Designation</td>
                            <td><?=$row->contact_person_designation?></td>
                        </tr>
                        <tr>
                            <td>Proprietor PAN Card</td>
                            <td>
                                <?php if($row->contact_person_document != ''){?>
                                    <a href="<?=getenv('app.uploadsURL').'user/'.$row->contact_person_document?>" class="badge bg-primary" target="_blank">View Document</a>
                                <?php }?>
                            </td>
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