<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$getCompany         = $common_model->find_data('ecoex_companies', 'row', ['id' => $rows[0]->company_id], 'company_name');
$getPlant           = $common_model->find_data('ecomm_users', 'row', ['id' => $rows[0]->plant_id], 'plant_name');
?>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <h5><?=(($getCompany)?$getCompany->company_name:'')?> : <?=(($getPlant)?$getPlant->plant_name:'')?></h5>
    <h5><?=$rows[0]->enquiry_no?></h5>
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
                                <th scope="col">Sub Enquiry No.</th>
                                <th scope="col">Assigned Vendor</th>
                                <th scope="col">Pickup Scheduled At</th>
                                <th scope="col">Activity At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $sl=1; foreach($rows as $row){?>
                                <tr>
                                    <th scope="row"><?=$sl++?></th>
                                    <td>
                                        <?=$row->sub_enquiry_no?>
                                        <?php
                                        $getSubEnquiryItems = $common_model->find_data('ecomm_sub_enquires', 'count', ['sub_enquiry_no' => $row->sub_enquiry_no]);
                                        ?>
                                        <p><h6 class="badge bg-success"><?=$getSubEnquiryItems?> product(s)</h6></p>
                                    </td>
                                    <td>
                                        <?php
                                        $getVendor = $common_model->find_data('ecomm_users', 'row', ['id' => $row->vendor_id], 'company_name');
                                        ?>
                                        <h6><?=(($getVendor)?$getVendor->company_name:'')?></h6>
                                    </td>
                                    <td>
                                        <?php
                                        if($row->is_pickup_final){
                                            echo (($row->pickup_scheduled_date != '')?date_format(date_create($row->pickup_scheduled_date), "M d, Y h:i A"):'');
                                        } else {
                                        ?>
                                            <p>
                                                <?php if($row->pickup_schedule_edit_access){?>
                                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status-pickup-edit-access/'.encoded($row->sub_enquiry_no).'/'.encoded(current_url()))?>" class="btn btn-success btn-sm" title="Pickup Scheduled Edit Access Off" onclick="return confirm('Do you want to off pickup Scheduled edit access ?');"><i class="fa fa-check"></i> Pickup Schedule Edit Access On</a>
                                                <?php } else {?>
                                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status-pickup-edit-access/'.encoded($row->sub_enquiry_no).'/'.encoded(current_url()))?>" class="btn btn-danger btn-sm" title="Pickup Scheduled Edit Access On" onclick="return confirm('Do you want to off pickup Scheduled edit access ?');"><i class="fa fa-times"></i> Pickup Schedule Edit Access Off</a>
                                                <?php }?>
                                                <?php if($row->pickup_scheduled_date != ''){?>
                                                    <a href="<?=base_url('admin/' . $controller_route . '/final-pickup-scheduled/'.encoded($row->sub_enquiry_no).'/'.encoded(current_url()))?>" class="btn btn-primary btn-sm" title="Final Pickup Scheduled <?=$title?>" onclick="return confirm('Do you want to finalize this date of pickup material from vendor end ?');"><i class="fa fa-eye"></i> Make Final</a>
                                                <?php }?>
                                            </p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span>
                                        <?php
                                        if($row->status == 3.3){
                                            echo (($row->assigned_date != '')?date_format(date_create($row->assigned_date), "M d, Y h:i A"):'');
                                        } elseif($row->status == 4.4){
                                            echo (($row->pickup_scheduled_date != '')?date_format(date_create($row->pickup_scheduled_date), "M d, Y h:i A"):'');
                                        } elseif($row->status == 5.5){
                                            echo (($row->vehicle_placed_date != '')?date_format(date_create($row->vehicle_placed_date), "M d, Y h:i A"):'');
                                        } elseif($row->status == 6.6){
                                            echo (($row->material_weighted_date != '')?date_format(date_create($row->material_weighted_date), "M d, Y h:i A"):'');
                                        } elseif($row->status == 8.8){
                                            echo (($row->invoice_to_vendor_date != '')?date_format(date_create($row->invoice_to_vendor_date), "M d, Y h:i A"):'');
                                        } elseif($row->status == 9.9){
                                            echo (($row->vendor_payment_received_date != '')?date_format(date_create($row->vendor_payment_received_date), "M d, Y h:i A"):'');
                                        } elseif($row->status == 10.10){
                                            echo (($row->vehicle_dispatched_date != '')?date_format(date_create($row->vehicle_dispatched_date), "M d, Y h:i A"):'');
                                        }
                                        ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($common_model->checkModuleFunctionAccess(23,109)){?>
                                            <a href="<?=base_url('admin/' . $controller_route . '/view-process-request-detail/'.encoded($row->sub_enquiry_no))?>" class="btn btn-outline-info btn-sm" title="View Details <?=$title?>"><i class="fa fa-eye"></i> Details</a>
                                            <br><br>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        
    });
</script>