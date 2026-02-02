<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;
?>
<style>
    #simpletable_wrapper .dt-layout-row.dt-layout-table {
        width: 100%;
        overflow: auto;
    }
</style>
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
                                        <th>#</th>
                                        <th style="width: 5%;">Enquiry No.</th>
                                        <th style="width: 5%;">Company</th>
                                        <th style="width: 5%;">Plant</th>
                                        <th>Tentative Collection Date</th>
                                        <th>Created At<br>Created By<br>Updated At<br>Updated By</th>
                                        <!-- ?php if ($rows) {
                                            if ($rows[0]->status >= 11 && $rows[0]->status <= 12) { ?><th>Ecoex Payment<br>Approve Status<br>HO Approve<br>Enquiry Complete</th>?php }
                                            } ?> -->
                                        <?php if ($rows) {
                                            if ($rows[0]->status >= 10) { ?><th>Ecoex Payment<br>Approve Status<br>HO Approve<br>Enquiry Complete</th><?php }
                                                                                                                                                } ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { ?>
                                            <?php
                                            $approveProductCount                = $common_model->find_data('ecomm_enquiry_products', 'count', ['enq_id' => $row->id, 'status' => 1]);
                                            $disapproveProductCount             = $common_model->find_data('ecomm_enquiry_products', 'count', ['enq_id' => $row->id, 'status' => 0]);
                                            $company                            = $common_model->find_data('ecoex_companies', 'row', ['id' => $row->company_id]);
                                            $plant                              = $common_model->find_data('ecomm_users', 'row', ['id' => $row->plant_id]);
                                            $certificateData                    = $certificate_model->where('enquiry_id', $row->id)->first();
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $sl++ ?></th>
                                                <td>
                                                    <h5>
                                                        <a href="<?= site_url('admin/whatsapp-notification/report/' . $row->id) ?>">
                                                            <?= esc($row->enquiry_no) ?> </a>
                                                    </h5>

                                                    <h6 class="badge bg-success"><?= $approveProductCount ?> approved products</h6>
                                                    <br>
                                                    <h6 class="badge bg-danger"><?= $disapproveProductCount ?> pending approval</h6>
                                                </td>
                                                <td>
                                                    <h5><?= ($company) ? nl2br(wordwrap($company->company_name, 15, "\n", false)) : '' ?>
                                                    </h5>
                                                </td>
                                                <td>
                                                    <!-- <h6><?php // (($plant) ? $plant->plant_name : '')
                                                                ?></h6> -->
                                                    <h5><?= ($plant) ? nl2br(wordwrap($plant->plant_name, 15, "\n", false)) : '' ?>
                                                    </h5>
                                                </td>
                                                <td><?= date_format(date_create($row->tentative_collection_date), "M d, Y") ?></td>
                                                <td>
                                                    <h6>
                                                        <?= (($row->created_at != '') ? date_format(date_create($row->created_at), "M d, Y h:i A") : '') ?><br>
                                                        <?php
                                                        if ($row->created_by > 0) {
                                                            $actionUser = $common_model->find_data('ecomm_users', 'row', ['id' => $row->created_by], 'plant_name');
                                                        ?>
                                                            <small><?= ($actionUser) ? nl2br(wordwrap($actionUser->plant_name, 15, "\n", false)) : '' ?>
                                                            </small>
                                                        <?php } else { ?>
                                                            <small>Admin</small>
                                                        <?php } ?>
                                                        <hr>
                                                    </h6>
                                                    <h6>
                                                        <?= (($row->updated_at != '') ? date_format(date_create($row->updated_at), "M d, Y h:i A") : '') ?><br>
                                                        <?php
                                                        if ($row->updated_by > 0) {
                                                            $actionUser = $common_model->find_data('ecomm_users', 'row', ['id' => $row->updated_by], 'plant_name');
                                                        ?>
                                                            <small><?= ($actionUser) ? nl2br(wordwrap($actionUser->plant_name, 15, "\n", false)) : '' ?>
                                                            </small>
                                                        <?php } else { ?>
                                                            <small>Admin</small>
                                                        <?php } ?>
                                                    </h6>
                                                </td>
                                                <?php //if ($row->status >= 11 && $row->status <= 12 && $row->status <= 10) {
                                                ?>
                                                <?php if ($row->status >= 10) { ?>
                                                    <td>
                                                        <h6><?= (($row->ecoex_submitted_date != '') ? date_format(date_create($row->ecoex_submitted_date), "M d, Y h:i A") : '') ?></h6>

                                                        <?php //if ($row->is_ho_approve_ecoex_payment) {
                                                        ?>
                                                        <h6 class="badge bg-success">APPROVED</h6>
                                                        <h6><?= (($row->ho_approve_date != '') ? date_format(date_create($row->ho_approve_date), "M d, Y h:i A") : '') ?></h6>

                                                        <?php if ($row->order_complete_date == '') { ?>
                                                            <?php if ($userType == 'MA') { ?>
                                                                <a href="<?= base_url('admin/' . $controller_route . '/order-complete/' . encoded($row->$primary_key)) ?>" class="btn btn-success btn-sm" title="Complete <?= $title ?>" onclick="return confirm('Do You Want To Complete This <?= $title ?>');"><i class="fa-solid fa-flag-checkered"></i> Click To Complete</a>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <h6 class="badge bg-success">COMPLETED</h6>
                                                            <h6><?= (($row->order_complete_date != '') ? date_format(date_create($row->order_complete_date), "M d, Y h:i A") : '') ?></h6>
                                                        <?php } ?>
                                                        <!-- ?php } else { ?>
                                                            <h6 class="badge bg-warning">PENDING</h6>
                                                        ?php } ?> -->
                                                    </td>
                                                <?php } ?>
                                                <td>
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 109)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/enquiry-details/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-info btn-sm" title="View <?= $title ?>"><i class="fa fa-info-circle"></i> View Details</a>
                                                    <?php } ?>
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 107)) { ?>
                                                        <?php if ($userType == 'MA') { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->$primary_key) . '/' . $current_status) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i> Delete</a>
                                                            <br>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if ($row->status == 0) { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(23, 110)) { ?>
                                                            <?php if ($userType == 'MA') { ?>
                                                                <a href="<?= base_url('admin/' . $controller_route . '/accept-request/' . encoded($row->$primary_key)) ?>" class="btn btn-success btn-sm mt-2" title="Accept <?= $title ?>" onclick="return confirm('Do You Want To Accept This <?= $title ?>');"><i class="fa fa-check"></i> Click To Accept</a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(23, 111)) { ?>
                                                            <?php if ($userType == 'MA') { ?>
                                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm mt-2" title="Reject <?= $title ?>" onclick="getRejectModal(<?= $row->$primary_key ?>);"><i class="fa fa-times"></i> Click To Reject</a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <br>
                                                        <?php //if ($common_model->checkModuleFunctionAccess(23, 149)) { 
                                                        ?>
                                                        <?php //if ($userType == 'MA') { 
                                                        ?>
                                                        <!-- <a href="<?= base_url('admin/' . $controller_route . '/send-whatsapp-notification/' . encoded(97)) ?>" class="btn btn-success btn-sm mt-2" title="Send WhatsApp <?= $title ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i> Click To Send Notification</a> -->
                                                        <?php
                                                        pr($statusMap);
                                                        ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/send-whatsapp-notification-state/' . encoded($row->$primary_key)) ?>" class="btn btn-primary btn-sm mt-2" title="Send WhatsApp <?= $title ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i> Click To Send Notification to <?= $statusMap[$row->id]['state'] ?? '' ?> Vendors & Subscribers</a>
                                                        
                                                        <!-- <form id="whatsappNotifyForm<?= $row->$primary_key ?>" method="post" action="<?= base_url('admin/' . $controller_route . '/send-whatsapp-notification') ?>" style="display:inline;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="enquiry_id" value="<?= encoded($row->$primary_key) ?>">
                                                            <input type="hidden" name="send_type" value="state">
                                                            <button type="submit" class="btn btn-success btn-sm mt-2 whatsapp-notify-btn" title="Send WhatsApp <?= $title ?>" <?= (isset($statusMap[$row->id]['state']) && ($statusMap[$row->id]['state'] == 'processing' || $statusMap[$row->id]['state'] == 'pending')) ? 'disabled' : '' ?>>
                                                                <i class="fa-brands fa-whatsapp"></i> Send Notification To <?= $stateMap[$row->id] ?? '' ?> (<?= $statusMap[$row->id]['state'] ?? '' ?>)
                                                            </button>
                                                        </form>
                                                        <br> -->

                                                        <!-- <form id="whatsappNotifyForm<?= $row->$primary_key ?>" method="post" action="<?= base_url('admin/' . $controller_route . '/send-whatsapp-notification') ?>" style="display:inline;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="enquiry_id" value="<?= encoded($row->$primary_key) ?>">
                                                            <input type="hidden" name="send_type" value="pan_india">
                                                            <button type="submit" class="btn btn-success btn-sm mt-2 whatsapp-notify-btn" title="Send WhatsApp <?= $title ?>" <?= (isset($statusMap[$row->id]['pan_India']) && ($statusMap[$row->id]['pan_India'] == 'processing' || $statusMap[$row->id]['pan_India'] == 'pending')) ? 'disabled' : '' ?>>
                                                                <i class="fa-brands fa-whatsapp"></i> Send Notification To Pan India (<?= $statusMap[$row->id]['pan_India'] ?? '' ?>)
                                                            </button>
                                                        </form> -->
                                                        <br>

                                                        <!-- <form id="whatsappNotifyForm<?= $row->$primary_key ?>" method="post" action="<?= base_url('admin/' . $controller_route . '/send-whatsapp-notification') ?>" style="display:inline;">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="enquiry_id" value="<?= encoded($row->$primary_key) ?>">
                                                                    <input type="hidden" name="send_type" value="neighbour">
                                                                    <button type="submit" class="btn btn-success btn-sm mt-2 whatsapp-notify-btn" title="Send WhatsApp <?= $title ?>" <?= (isset($statusMap[$row->id]['neighbour']) && ($statusMap[$row->id]['neighbour'] == 'processing' || $statusMap[$row->id]['neighbour'] == 'pending')) ? 'disabled' : '' ?>>
                                                                        <i class="fa-brands fa-whatsapp"></i> Send Notification To Neighbour (<?= $statusMap[$row->id]['neighbour'] ?? '' ?>)
                                                                    </button>
                                                                </form> -->
                                                        <?php //} 
                                                        ?>
                                                        <?php //} 
                                                        ?>
                                                    <?php } else { ?>
                                                        <?php if ($row->status >= 1 && $row->status <= 12) { ?>
                                                            <h6 class="badge bg-success mt-2"><i class="fa fa-check-circle"></i> ACCEPTED</h6>
                                                            </br>
                                                            <!-- <a href="<?= base_url('admin/certificate/create'); ?>"><h6 class="badge bg-success mt-2"><i class="fa fa-flag-checkered"></i> Generate Certificate</h6></a> -->
                                                            <?php if ($row->status == 12) { ?>
                                                                <?php if ($common_model->checkModuleFunctionAccess(23, 155)) { ?>
                                                                    <form action="<?= base_url('admin/certificate/create'); ?>" method="post" class="d-inline">
                                                                        <?= csrf_field(); ?>
                                                                        <input type="hidden" name="company_id" value="<?= $row->company_id; ?>">
                                                                        <input type="hidden" name="enquiry_id" value="<?= $row->id; ?>">
                                                                        <input type="hidden" name="plant_id" value="<?= $row->plant_id; ?>">

                                                                        <button type="<?= empty($certificateData) ? 'submit' : '' ?>" class="badge bg-success mt-2 border-0">
                                                                            <i class="fa fa-flag-checkered"></i> Generate Certificate
                                                                        </button>
                                                                    </form>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } elseif ($row->status == 13) { ?>
                                                            <h6 class="badge bg-danger mt-2"><i class="fa fa-times-circle"></i> REJECTED</h6>
                                                        <?php } ?>
                                                        <?php if (!empty($certificateData['status'])): ?>
                                                            </br>
                                                            <h6 class="badge bg-info mt-2"><i class="fa fa-certificate"></i> <?= ucfirst($certificateData['status']); ?></h6>
                                                        <?php endif; ?>
                                                        <p><?= (($row->accepted_date != '') ? date_format(date_create($row->accepted_date), "M d, Y h:i A") : '') ?></p>

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
<!-- reject request modal -->
<div class="modal fade" id="rejectRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="rejectRequestTitle">

            </div>
            <div class="modal-body" id="rejectRequestBody">

            </div>
        </div>
    </div>
</div>
<!-- reject request modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {

    });

    function getRejectModal(enq_id) {
        let baseUrl = '<?= base_url() ?>';
        $.ajax({
            type: "POST",
            data: {
                enq_id: enq_id
            },
            url: baseUrl + "/admin/get-reject-modal",
            dataType: "JSON",
            success: function(res) {
                if (res.success) {
                    $('#rejectRequest').modal('show');
                    $('#rejectRequestTitle').html(res.data.title);
                    $('#rejectRequestBody').html(res.data.body);
                } else {
                    $('#rejectRequest').modal('hide');
                    $('#rejectRequestTitle').html('');
                    $('#rejectRequestBody').html('');
                }
            }
        });
    }
</script>