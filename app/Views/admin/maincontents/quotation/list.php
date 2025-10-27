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
                        <div class="row mb-3">
                           <div class="col-md-3">
                                <select id="sortOption" class="form-control" style="width:200px;">
                                    <option value="">Sort By</option>
                                    <option value="rate_asc">Rate: Low → High</option>
                                    <option value="rate_desc">Rate: High → Low</option>
                                    <option value="qty_asc">Quantity: Low → High</option>
                                    <option value="qty_desc">Quantity: High → Low</option>
                                </select>
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
                                                <td data-order="<?= intval($row->rate) ?>"><h5><?= intval($row->rate)?> /<?=$row->unit?> </h5></td>
                                                <td data-order="<?= intval($row->qty) ?>"><h5><?= intval($row->qty) ?> <?=$row->unit?></h5></td>
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
                                                            <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->id). '/' . encoded($row->quotation_item_id)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i> Delete</a>
                                                            <br>
                                                        <?php } ?>
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
  // Reuse if already initialised by theme; otherwise init once.
  table = $('#simpletable').DataTable({
    retrieve: true,                 // ← avoids “Cannot reinitialise” if pre-inited
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    language: { emptyTable: 'No data found' },
    columnDefs: [
      { targets: 0, orderable: false, searchable: false }, // serial #
      { targets: 10, orderable: false }                    // Action
    ],
    deferRender: true
  });

  // Auto-number the first column on every draw (respects paging/search/order)
  table.on('draw.dt', function () {
    const info = table.page.info();
    table.column(0, { search: 'applied', order: 'applied' })
      .nodes()
      .each((cell, i) => { cell.innerHTML = info.start + i + 1; });
  }).draw(false);

  // Filter button
  $('#applyFilter').on('click', function () {
    const loc  = $('#filterLocation').val() || '';
    const item = $('#filterItem').val() || '';
    getStateLocation(loc, item);
  });
});

function getStateLocation(loc, item) {
  $('#tableLoader').show();  // loader OUTSIDE the table

  $.ajax({
    type: 'POST',
    url: baseUrl + 'admin/get-state-location',
    dataType: 'json',
    data: { loc, item },
    success: function (res) {
      if (res && res.success && Array.isArray(res.data) && res.data.length) {
        const rows = res.data.map(row => ([
          '', // serial # (filled by draw handler)
          `<h5>${row.quotation_no}</h5>`,
          `<h5>${row.scrap_name}</h5>`,
          `<h5>${parseInt(row.rate, 10)} /${row.unit}</h5>`,
          `<h5>${parseInt(row.qty, 10)} ${row.unit}</h5>`,
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
        table.page('first').draw(false); // keep pagination at 10 after filter
      } else {
        table.clear().draw(false);       // empty state, pagination intact
      }
    },
    error: function () {
      table.clear().draw(false);
      // optionally show a toast here
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

$('#sortOption').on('change', function () {
    let val = $(this).val();

    if (val == "rate_asc") {
        table.order([3, "asc"]).draw();  // 3 = Rate column index
    } 
    else if (val == "rate_desc") {
        table.order([3, "desc"]).draw();
    } 
    else if (val == "qty_asc") {
        table.order([4, "asc"]).draw();  // 4 = Quantity column index
    } 
    else if (val == "qty_desc") {
        table.order([4, "desc"]).draw();
    }
});
</script>

