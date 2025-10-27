<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;
?>
<style>
    #simpletable1_wrapper .dt-layout-row.dt-layout-table {
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
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4">                                
                                        <select id="filterLocation" class="form-control">
                                        <option value="">Filter by Location</option>
                                        <?php foreach ($locations as $location) {?>
                                        <option value="<?=$location->location?>"><?=$location->location?></option>                                
                                        <?php } ?>
                                        <!-- add more -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="filterItem" class="form-control">
                                        <option value="">Filter by Item Name</option>
                                        <?php foreach ($items as $item) {?>
                                        <option value="<?=$item->scrap_name?>"><?=$item->scrap_name?></option>
                                        <?php } ?>
                                        <!-- add more -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="applyFilter" class="btn btn-outline-secondary">Apply Filter</button>
                                        <button id="resetFilter" class="btn btn-secondary" disabled>Reset</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select id="sortOption" class="form-control" style="width:150px;">
                                            <option value="">Sort By</option>
                                            <option value="rate_asc">Rate: Low → High</option>
                                            <option value="rate_desc">Rate: High → Low</option>
                                            <option value="qty_asc">Quantity: Low → High</option>
                                            <option value="qty_desc">Quantity: High → Low</option>
                                        </select>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                           
                        </div>
                        <div class="table-responsive">
                            <table id="simpletable1" class="table globel_table nowrap" style="width: 100%">
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
                                        <?php foreach ($rows as $row) {
                                            $itemStatus = $row->quotation_item_status;
                                            if($itemStatus == 1) {?>
                                            <th>Active Timestamp</th>
                                       <?php }elseif($itemStatus == 2) { ?>
                                            <th>Reject Timestamp</th>
                                      <?php } }?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) { $itemStatus = $row->quotation_item_status;?>                                            
                                            <tr>
                                                <th scope="row"><?= $sl++ ?></th>
                                                <td><h5><?= $row->quotation_no ?></h5></td>
                                                <td><h5><?= $row->scrap_name ?></h5></td>
                                                <td data-order="<?= intval($row->rate) ?>"><h5><?= intval($row->rate)?> /<?=$row->unit?> </h5></td>
                                                <td data-order="<?= intval($row->qty) ?>"><h5><?= intval($row->qty) ?> <?=$row->unit?></h5></td>
                                                <td><h5><?= ($row->location) ?> </h5></td>
                                                <td><h5><?= ($row->current_location) ?> </h5></td>
                                                <td><h5><?= ($row->vendor_name) ?> </h5></td>
                                                <td><h5><?= ($row->contact_no) ?> </h5></td>                                                                                             
                                                <td><h6><?= (($row->created_at != '') ? date_format(date_create($row->created_at), "M d, Y h:i A") : '') ?></h6></td>    
                                                <?php if($itemStatus == 1) {?>
                                                <td><h6><?= (($row->quotation_item_status == 1) ? date_format(date_create($row->active_time), "M d, Y h:i A") : '') ?></h6></td>
                                                <?php }elseif($itemStatus == 2) { ?>
                                                <td><h6><?= (($row->quotation_item_status == 2) ? date_format(date_create($row->reject_time), "M d, Y h:i A") : '') ?></h6></td>
                                                <?php } ?>                                          
                                                
                                                <td>
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 109)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/view-detail/' . encoded($row->id)) ?>" class="btn btn-outline-info btn-sm" title="View <?= $title ?>"><i class="fa fa-info-circle"></i> View Details</a>
                                                    <?php } ?> 
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 107)) { ?>
                                                        <?php if ($userType == 'MA') { 
                                                            if($row->quotation_item_status != 1) {?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->id). '/' . encoded($row->quotation_item_id)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i> Delete</a>
                                                            <br>
                                                        <?php } } ?>
                                                    <?php } ?> 
                                                    <?php if ($row->quotation_item_status == 0) { ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(23, 110)) { ?>
                                                            <?php if ($userType == 'MA') { ?>
                                                                <a href="<?= base_url('admin/' . $controller_route . '/accept-request/' . encoded($row->quotation_item_id)) ?>" class="btn btn-success btn-sm mt-2" title="Accept <?= $title ?>" onclick="return confirm('Do You Want To Accept This <?= $title ?>');"><i class="fa fa-check"></i> Click To Accept</a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php if ($common_model->checkModuleFunctionAccess(23, 111)) { ?>
                                                            <?php if ($userType == 'MA') { ?>
                                                                <!-- <a href="javascript:void(0);" class="btn btn-danger btn-sm mt-2" title="Reject <?= $title ?>" onclick="getRejectModal(<?= $row->$primary_key ?>);"><i class="fa fa-times"></i> Click To Reject</a> -->
                                                                <a href="<?= base_url('admin/' . $controller_route . '/reject-request/' . encoded($row->quotation_item_id)) ?>" class="btn btn-danger btn-sm mt-2" title="Reject <?= $title ?>" onclick="return confirm('Do You Want To Reject This <?= $title ?>');"><i class="fa fa-times"></i> Click To Reject</a>
                                                            <?php } ?>
                                                        <?php } ?>                                                        
                                                    <?php } else { ?>
                                                        <?php if ($row->quotation_item_status == 1) { ?>
                                                            <h6 class="badge bg-success mt-2"><i class="fa fa-check-circle"></i> ACCEPTED</h6>
                                                        <?php } elseif ($row->quotation_item_status == 2) { ?>
                                                            <h6 class="badge bg-danger mt-2"><i class="fa fa-times-circle"></i> REJECTED</h6>
                                                        <?php } ?>
                                                        <!-- <p>?= (($row->accepted_date != '') ? date_format(date_create($row->accepted_date), "M d, Y h:i A") : '') ?></p> -->
                                                    <?php } ?>                                                  
                                                </td>
                                            </tr>
                                    <?php }
                                        } ?>
                                </tbody>
                            </table>
                            <div id="tableLoader" style="display:none">Loading…</div>
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

<script>
const baseUrl = '<?= base_url() ?>';
let table;

$(function () {
  table = $('#simpletable1').DataTable({
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    language: { emptyTable: 'No data found' },
    columnDefs: [
      { targets: 0, orderable: false, searchable: false }, // serial #
      { targets: 10, orderable: false }                    // Action
    ],
    deferRender: true
  });

  // Auto numbering
  table.on('draw.dt', function () {
    const info = table.page.info();
    table.column(0, { search: 'applied', order: 'applied' })
      .nodes()
      .each((cell, i) => { cell.innerHTML = info.start + i + 1; });
  }).draw(false);

  // 🔹 Watch dropdown changes to enable/disable Reset button
  $('#filterLocation, #filterItem').on('change', function () {
    const hasFilter = $('#filterLocation').val() || $('#filterItem').val();
    $('#resetFilter').prop('disabled', !hasFilter);
  });

  $('#applyFilter').on('click', function () {
    const loc  = $('#filterLocation').val() || '';
    const item = $('#filterItem').val() || '';
    getStateLocation(loc, item);
  });
  // 🔹 Reset Filter button
  $('#resetFilter').on('click', function () {
    $('#filterLocation').val('');
    $('#filterItem').val('');
    $('#resetFilter').prop('disabled', true);

     location.reload();
  });
});

function getStateLocation(loc, item) {
  $('#tableLoader').show();

  $.ajax({
    type: 'POST',
    url: baseUrl + 'admin/get-state-location',
    dataType: 'json',
    data: { loc, item },
    success:function (res) {
        console.log('Response data:', res.data);

      if (res && res.success && Array.isArray(res.data) && res.data.length) {
        const rows = res.data.map((row, index) => ([
          index + 1,
          `<h5>${row.quotation_no}</h5>`,
          `<h5>${row.scrap_name}</h5>`,
          `<h5>${parseFloat(row.rate).toFixed(2)} /${row.unit}</h5>`,
          `<h5>${parseFloat(row.qty).toFixed(2)} ${row.unit}</h5>`,
          `<h5>${row.location}</h5>`,
          `<h5>${row.current_location}</h5>`,
          `<h5>${row.vendor_name}</h5>`,
          `<h5>${row.contact_no}</h5>`,
          `<h6>${row.created_at ? formatDate(row.created_at) : ''}</h6>`,
          `<a href="${baseUrl}admin/quotations/view-detail/${row.id}" 
              class="btn btn-outline-info btn-sm">
              <i class="fa fa-info-circle"></i> View
           </a>`
        ]));

        table.clear();
        table.rows.add(rows);
        table.page('first').draw(false);
      } else {
        table.clear().draw(false);
      }
    },
    error: function () {
      table.clear().draw(false);
    },
    complete: function () {
      $('#tableLoader').hide();
    }
  });
}

function formatDate(dateStr) {
  const d = new Date(dateStr);
  if (isNaN(d)) return '';
  return d.toLocaleString('en-US', {
    month: 'short', day: '2-digit', year: 'numeric',
    hour: '2-digit', minute: '2-digit', hour12: true
  });
}

</script>

