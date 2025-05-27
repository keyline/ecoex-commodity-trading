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
                        <div class="table-responsive">
                            <table class="table globel_table">
                                <tr>
                                    <th>GST No.</th>
                                    <td><?=$row->gst_no?></td>
                                </tr>
                                <tr>
                                    <th>Company Name</th>
                                    <td><?=$row->company_name?></td>
                                </tr>
                                <tr>
                                    <th>Full Address</th>
                                    <td><?=$row->full_address?></td>
                                </tr>
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
                                    <td>Lochtion</td>
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
                                    <th>Alternate Email 1</th>
                                    <td><?=$row->alternate_email1?></td>
                                </tr>
                                <tr>
                                    <th>Alternate Email 2</th>
                                    <td><?=$row->alternate_email2?></td>
                                </tr>
                                <tr>
                                    <th>Alternate Email 3</th>
                                    <td><?=$row->alternate_email3?></td>
                                </tr>
                                <tr>
                                    <th>Alternate Email 4</th>
                                    <td><?=$row->alternate_email4?></td>
                                </tr>
                                <tr>
                                    <th>Alternate Email 5</th>
                                    <td><?=$row->alternate_email5?></td>
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
                                    <th>Contract Start</th>
                                    <td><?=(($row->contract_start != '')?date_format(date_create($row->contract_start), "M d Y"):'')?></td>
                                </tr>
                                <tr>
                                    <th>Contract End</th>
                                    <td><?=(($row->contract_end != '')?date_format(date_create($row->contract_end), "M d Y"):'')?></td>
                                </tr>
                                <tr>
                                    <th>Company Contact Person Name</th>
                                    <td><?=$row->ho_contact_person_name?></td>
                                </tr>
                                <tr>
                                    <th>Agreement Document</th>
                                    <td>
                                        <?php if($row->agreement_document != ''){?>
                                            <a href="<?=getenv('app.uploadsURL').'user/'.$row->agreement_document?>" class="badge bg-primary" target="_blank">View Document</a>
                                        <?php }?>
                                    </td>
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
                                    <th>CIN No.</th>
                                    <td><?=$row->cin_no?></td>
                                </tr>
                                <tr>
                                    <th>CIN Document</th>
                                    <td>
                                        <?php if($row->cin_document != ''){?>
                                            <a href="<?=getenv('app.uploadsURL').'user/'.$row->cin_document?>" class="badge bg-primary" target="_blank">View Document</a>
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
    </div>
</section>