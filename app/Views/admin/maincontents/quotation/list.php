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
                                        <th style="width: 5%;">Quotation No.</th>
                                        <th style="width: 5%;">Location</th>
                                        <th style="width: 5%;">Current Location</th>
                                        <th style="width: 5%;">Contact No.</th>
                                        <th style="width: 5%;">Quotaion Items (count)</th>                                        
                                        <th>Quotation Submitted</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { ?>
                                            <!-- ?php
                                            $approveProductCount                = $common_model->find_data('ecomm_enquiry_products', 'count', ['enq_id' => $row->id, 'status' => 1]);
                                            $disapproveProductCount             = $common_model->find_data('ecomm_enquiry_products', 'count', ['enq_id' => $row->id, 'status' => 0]);
                                            $company                            = $common_model->find_data('ecoex_companies', 'row', ['id' => $row->company_id]);
                                            $plant                              = $common_model->find_data('ecomm_users', 'row', ['id' => $row->plant_id]);
                                            ?> -->
                                            <tr>
                                                <th scope="row"><?= $sl++ ?></th>
                                                <td>
                                                    <h5><?= $row->quotation_no ?></h5>                                                    
                                                </td>
                                                <td>
                                                    <h5><?= ($row->location) ?> </h5>
                                                </td>
                                                <td>
                                                    <h5><?= ($row->current_location) ?> </h5>
                                                </td>
                                                <td>
                                                    <h5><?= ($row->contact_no) ?> </h5>
                                                </td>
                                                <td>
                                                    <h5><?= ($row->quotation_item_count) ?></h5>
                                                </td>                                                
                                                <td>
                                                    <h6>
                                                        <?= (($row->created_at != '') ? date_format(date_create($row->created_at), "M d, Y h:i A") : '') ?>
                                                    </h6>                                                    
                                                </td>                                                
                                                <td>
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 109)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/view-detail/' . encoded($row->$primary_key)) ?>" class="btn btn-outline-info btn-sm" title="View <?= $title ?>"><i class="fa fa-info-circle"></i> View Details</a>
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