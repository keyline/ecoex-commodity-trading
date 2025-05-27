<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="container-fluid">
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
</div>
<section class="section">
        <div class="container-fluid">
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
                        <table class="table globel_table">
                            <tr>
                                <th>Company Name</th>
                                <td>
                                    <?php
                                    $company = $common_model->find_data('ecoex_companies', 'row', ['id' => $row->parent_id], 'company_name');
                                    echo (($company)?$company->company_name:'');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>GST No.</th>
                                <td><?=$row->gst_no?></td>
                            </tr>
                            <tr>
                                <th>Plant Name</th>
                                <td><?=$row->company_name?></td>
                            </tr>
                            <tr>
                                <th>Plant Address</th>
                                <td><?=$row->full_address?></td>
                            </tr>
                            <!-- <tr>
                                <td>Holding No.</td>
                                <td><?=$row->holding_no?></td>
                            </tr> -->
                            <tr>
                                <th>Street</th>
                                <td><?=$row->street?></td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td><?=$row->district?></td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td><?=$row->state?></td>
                            </tr>
                            <tr>
                                <th>Pincode</th>
                                <td><?=$row->pincode?></td>
                            </tr>
                            <!-- <tr>
                                <td>Location</td>
                                <td><?=$row->location?></td>
                            </tr> -->
                            <tr>
                                <th>Email</th>
                                <td><?=$row->email?></td>
                            </tr>
                            <tr>
                                <th>Email Verify</th>
                                <td><span class="badge <?=(($row->email_verify)?'bg-success':'bg-danger')?>"><?=(($row->email_verify)?'YES':'NO')?></span></td>
                            </tr>
                            <tr>
                                <th>Email Verify At</th>
                                <td><?=(($row->email_verified_at != '')?date_format(date_create($row->email_verified_at), "M d Y h:i A"):'')?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?=$row->phone?></td>
                            </tr>
                            <tr>
                                <th>Phone Verify</th>
                                <td><span class="badge <?=(($row->phone_verify)?'bg-success':'bg-danger')?>"><?=(($row->phone_verify)?'YES':'NO')?></span></td>
                            </tr>
                            <tr>
                                <th>Phone Verify At</th>
                                <td><?=(($row->phone_verified_at != '')?date_format(date_create($row->phone_verified_at), "M d Y h:i A"):'')?></td>
                            </tr>
                            <tr>
                                <th>Profile Image</th>
                                <td><img src="<?=(($row->profile_image != '')?getenv('app.uploadsURL').'user/'.$row->profile_image:getenv('app.NO_IMAGE'))?>" class="img-thumbnail" style="width: 250px; height: auto;"></td>
                            </tr>
                            <tr>
                                <th>GST Certificate</th>
                                <td>
                                    <?php if($row->gst_certificate != ''){?>
                                        <a href="<?=getenv('app.uploadsURL').'user/'.$row->gst_certificate?>" class="badge bg-primary" target="_blank">View Document</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <th>Designated Person Name</th>
                                <td><?=$row->contact_person_name?></td>
                            </tr>
                            <tr>
                                <th>Designated Person Designation</th>
                                <td><?=$row->contact_person_designation?></td>
                            </tr>
                            <tr>
                                <th>Designated Person PAN Card / Company ID</th>
                                <td>
                                    <?php if($row->contact_person_document != ''){?>
                                        <a href="<?=getenv('app.uploadsURL').'user/'.$row->contact_person_document?>" class="badge bg-primary" target="_blank">View Document</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <th>Bank Name</th>
                                <td><?=$row->bank_name?></td>
                            </tr>
                            <tr>
                                <th>Branch Name</th>
                                <td><?=$row->branch_name?></td>
                            </tr>
                            <tr>
                                <th>IFSC Code</th>
                                <td><?=$row->ifsc_code?></td>
                            </tr>
                            <tr>
                                <th>Account Type</th>
                                <td><?=$row->account_type?></td>
                            </tr>
                            <tr>
                                <th>Account No.</th>
                                <td><?=$row->account_number?></td>
                            </tr>
                            <tr>
                                <th>Cancelled Cheque</th>
                                <td>
                                    <?php if($row->cancelled_cheque != ''){?>
                                        <a href="<?=getenv('app.uploadsURL').'user/'.$row->cancelled_cheque?>" class="badge bg-primary" target="_blank">View Document</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td><?=date_format(date_create($row->created_at), "M d Y h:i A")?></td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td><?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d Y h:i A"):'')?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>