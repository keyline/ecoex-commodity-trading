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
                        <div class="row mb-3">
                            <div class="col-md-3">                                
                                <select id="filterLocation" class="form-control">
                                <option value="">Filter by Location</option>
                                <?php foreach ($locations as $location) {?>
                                <option value="<?=$location->location?>"><?=$location->location?></option>                                
                                <?php } ?>
                                <!-- add more -->
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="filterItem" class="form-control">
                                <option value="">Filter by Item Name</option>
                                <?php foreach ($items as $item) {?>
                                <option value="<?=$item->scrap_name?>"><?=$item->scrap_name?></option>
                                <?php } ?>
                                <!-- add more -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button id="applyFilter">Apply Filter</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>                                        
                                        <th style="width: 5%;">Quotation No.</th>
                                        <th style="width: 5%;">Quotation Item Name</th>
                                        <th style="width: 5%;">Quoted Rate</th>
                                        <th style="width: 5%;">Quantity</th>
                                        <th style="width: 5%;">Location</th>
                                        <th style="width: 5%;">Current Location</th>
                                        <th style="width: 5%;">Vendor Name</th>
                                        <th style="width: 5%;">Contact No.</th>                                                                              
                                        <th>Quotation Submitted</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { ?>                                            
                                            <tr>
                                                <th scope="row"><?= $sl++ ?></th>
                                                <td><h5><?= $row->quotation_no ?></h5></td>
                                                <td><h5><?= $row->scrap_name ?></h5></td>
                                                <td><h5><?= intval($row->rate)?> /<?=$row->unit?> </h5></td>
                                                <td><h5><?= intval($row->qty) ?> <?=$row->unit?></h5></td>
                                                <td><h5><?= ($row->location) ?> </h5></td>
                                                <td><h5><?= ($row->current_location) ?> </h5></td>
                                                <td><h5><?= ($row->vendor_name) ?> </h5></td>
                                                <td><h5><?= ($row->contact_no) ?> </h5></td>                                                                                             
                                                <td><h6><?= (($row->created_at != '') ? date_format(date_create($row->created_at), "M d, Y h:i A") : '') ?></h6></td>                                                
                                                <td>
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 109)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/view-detail/' . encoded($row->id)) ?>" class="btn btn-outline-info btn-sm" title="View <?= $title ?>"><i class="fa fa-info-circle"></i> View Details</a>
                                                    <?php } ?> 
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 107)) { ?>
                                                        <?php if ($userType == 'MA') { ?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->id)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i> Delete</a>
                                                            <br>
                                                        <?php } ?>
                                                    <?php } ?> 
                                                    <?php if ($row->status == 0) { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(23, 110)) { ?>
                                                            <?php if ($userType == 'MA') { ?>
                                                                <a href="<?= base_url('admin/' . $controller_route . '/accept-request/' . encoded($row->id)) ?>" class="btn btn-success btn-sm mt-2" title="Accept <?= $title ?>" onclick="return confirm('Do You Want To Accept This <?= $title ?>');"><i class="fa fa-check"></i> Click To Accept</a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(23, 111)) { ?>
                                                            <?php if ($userType == 'MA') { ?>
                                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm mt-2" title="Reject <?= $title ?>" onclick="getRejectModal(<?= $row->$primary_key ?>);"><i class="fa fa-times"></i> Click To Reject</a>
                                                            <?php } ?>
                                                        <?php } ?>                                                        
                                                    <?php } else { ?>
                                                        <?php if ($row->status == 1) { ?>
                                                            <h6 class="badge bg-success mt-2"><i class="fa fa-check-circle"></i> ACCEPTED</h6>
                                                        <?php } elseif ($row->status == 2) { ?>
                                                            <h6 class="badge bg-danger mt-2"><i class="fa fa-times-circle"></i> REJECTED</h6>
                                                        <?php } ?>
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

    $('#applyFilter').on('click', function () {
        let loc = $('#filterLocation').val();
        let item = $('#filterItem').val();
        getStateLocation(loc, item);
    });
    function getStateLocation(loc, item) {
        let baseUrl = '<?= base_url() ?>';
        $.ajax({
            type: "POST",
            data: {
                loc: loc,
                item: item
            },
            url: baseUrl + "admin/get-state-location",
            dataType: "JSON",
            beforeSend: function () {
                $("#simpletable").html('<tr><td colspan="11" class="text-center">Loading...</td></tr>');
            },
            success: function(res) {
                if (res.success && res.data.length > 0) {
                    let html = '';
                    let sl = 1;
                    $.each(res.data, function (i, row) {
                    html += `
                            <thead>
                                <tr>
                                    <th>#</th>                                        
                                    <th style="width: 5%;">Quotation No.</th>
                                    <th style="width: 5%;">Quotation Item Name</th>
                                    <th style="width: 5%;">Quoted Rate</th>
                                    <th style="width: 5%;">Quantity</th>
                                    <th style="width: 5%;">Location</th>
                                    <th style="width: 5%;">Current Location</th>
                                    <th style="width: 5%;">Vendor Name</th>
                                    <th style="width: 5%;">Contact No.</th>                                                                              
                                    <th>Quotation Submitted</th>                                        
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">${sl++}</th>
                                    <td><h5>${row.quotation_no}</h5></td>
                                    <td><h5>${row.scrap_name}</h5></td>
                                    <td><h5>${parseInt(row.rate)} /${row.unit}</h5></td>
                                    <td><h5>${parseInt(row.qty)} ${row.unit}</h5></td>
                                    <td><h5>${row.location}</h5></td>
                                    <td><h5>${row.current_location}</h5></td>
                                    <td><h5>${row.vendor_name}</h5></td>
                                    <td><h5>${row.contact_no}</h5></td>
                                    <td><h6>${(row.created_at ? formatDate(row.created_at) : '')}</h6></td>
                                    <td>
                                        <a href="${baseUrl}admin/quotations/view-detail/${row.id}" class="btn btn-outline-info btn-sm">
                                            <i class="fa fa-info-circle"></i> View
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        `;
                    });
                    $("#simpletable").html(html);
                } else {
                    $("#simpletable").html('<tr><td colspan="11" class="text-center text-danger">No data found</td></tr>');
                }
            },
            error: function() {
                $("#simpletable").html('<tr><td colspan="11" class="text-center text-danger">Something went wrong</td></tr>');
            }
        });
    }

    function formatDate(dateStr) {
    let date = new Date(dateStr);
    if (isNaN(date)) return ''; // handle invalid date

    // Format like: Oct 22, 2025 05:30 PM
    return date.toLocaleString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
}
</script>