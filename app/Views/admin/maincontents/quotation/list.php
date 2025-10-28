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
    .quatation-filter-card {
        border: 1px dashed #48974e;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    .quatation-filter-card select{
        appearance: auto;
    }
    .quatation-filter-card .form-control{
        min-height: 37.6px;
    }
    .dt-length label{
        margin-left: 5px;
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
                        <div class="card quatation-filter-card">
                            <div class="card-body">
                                <div class="row flex-column-reverse flex-md-row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4 my-2">                                
                                                <select id="filterLocation" class="form-control">
                                                <option value="">Filter by Location</option>
                                                <?php foreach ($locations as $location) {?>
                                                <option value="<?=$location->location?>"><?=$location->location?></option>                                
                                                <?php } ?>
                                                <!-- add more -->
                                                </select>
                                            </div>
                                            <div class="col-md-4 my-2">
                                                <select id="filterItem" class="form-control">
                                                <option value="">Filter by Item Name</option>
                                                <?php foreach ($items as $item) {?>
                                                <option value="<?=$item->scrap_name?>"><?=$item->scrap_name?></option>
                                                <?php } ?>
                                                <!-- add more -->
                                                </select>
                                            </div>
                                            <div class="col-md-4 my-2">
                                                <button id="applyFilter" class="btn btn-outline-secondary">Apply Filter</button>
                                                <button id="resetFilter" class="btn btn-secondary" disabled>Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12 my-2">
                                                <select id="sortOption" class="form-control ms-auto" style="width:150px;">
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
                                                        <a href="<?= base_url('admin/' . $controller_route . '/view-detail/' . encoded($row->id)) ?>" class="btn btn-outline-info btn-sm" title="View <?= $title ?>"><i class="fa fa-info-circle"></i></a>
                                                    <?php } ?> 
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 107)) { ?>
                                                        <?php if ($userType == 'MA') { 
                                                            if($row->quotation_item_status != 1) {?>
                                                            <a href="<?= base_url('admin/' . $controller_route . '/delete/' . encoded($row->id). '/' . encoded($row->quotation_item_id)) ?>" class="btn btn-outline-danger btn-sm" title="Delete <?= $title ?>" onclick="return confirm('Do You Want To Delete This <?= $title ?>');"><i class="fa fa-trash"></i></a>
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
                                                            <!-- <h6 class="badge bg-success mt-2"><i class="fa fa-check-circle"></i> ACCEPTED</h6> -->
                                                        <?php } elseif ($row->quotation_item_status == 2) { ?>
                                                            <!-- <h6 class="badge bg-danger mt-2"><i class="fa fa-times-circle"></i> REJECTED</h6> -->
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
    document.addEventListener("DOMContentLoaded", function () {
    const rowsPerPage = 10;
    const table = document.getElementById("simpletable1");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));
    let filteredRows = [...rows]; // initial data (no filter)
    let currentPage = 1;
    let totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    let currentSort = "";

    function displayRows(page) {
        tbody.innerHTML = "";
        // 🔹 Sort before pagination
        let sortedRows = [...filteredRows];
        if (sortOption) {
            sortedRows.sort((a, b) => {
                const rateA = parseFloat(a.cells[3]?.innerText) || 0;
                const rateB = parseFloat(b.cells[3]?.innerText) || 0;
                const qtyA = parseFloat(a.cells[4]?.innerText) || 0;
                const qtyB = parseFloat(b.cells[4]?.innerText) || 0;

                switch (sortOption) {
                    case "rate_asc": return rateA - rateB;
                    case "rate_desc": return rateB - rateA;
                    case "qty_asc": return qtyA - qtyB;
                    case "qty_desc": return qtyB - qtyA;
                    default: return 0;
                }
            });
        }

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        // rows.forEach(row => row.style.display = "none"); // hide all
        // filteredRows.slice(start, end).forEach(row => row.style.display = ""); // show only page rows
        const paginatedRows = sortedRows.slice(start, end);

        paginatedRows.forEach(row => tbody.appendChild(row));

        totalPages = Math.ceil(sortedRows.length / rowsPerPage) || 1;
        updatePaginationInfo();
    }

    function updatePaginationInfo() {
        const pageInfo = document.querySelector(".pagination-info");
        pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        document.getElementById("prevBtn").disabled = currentPage === 1;
        document.getElementById("nextBtn").disabled = currentPage === totalPages;
    }

    function setupPagination() {
        const paginationContainer = document.createElement("div");
        paginationContainer.classList.add("pagination-container");
        paginationContainer.style.textAlign = "center";
        paginationContainer.style.marginTop = "20px";

        paginationContainer.innerHTML = `
        <button id="prevBtn" class="btn btn-outline-secondary btn-sm">« Prev</button>
        <span class="pagination-info" style="margin:0 10px;">Page ${currentPage} of ${totalPages}</span>
        <button id="nextBtn" class="btn btn-outline-secondary btn-sm">Next »</button>
        `;

        table.parentNode.appendChild(paginationContainer);

        document.getElementById("prevBtn").addEventListener("click", function () {
        if (currentPage > 1) {
            currentPage--;
            displayRows(currentPage);
            updatePaginationInfo();
        }
        });

        document.getElementById("nextBtn").addEventListener("click", function () {
        if (currentPage < totalPages) {
            currentPage++;
            displayRows(currentPage);
            updatePaginationInfo();
        }
        });
    }

    function applyFilter() {
        const locationVal = document.getElementById("filterLocation").value.toLowerCase();
        const itemVal = document.getElementById("filterItem").value.toLowerCase();
        const resetBtn = document.getElementById("resetFilter");

        filteredRows = rows.filter(row => {
            const locationText = row.cells[5]?.innerText.toLowerCase() || ""; // 6th column = Location
            const itemText = row.cells[2]?.innerText.toLowerCase() || "";     // 3rd column = Item Name

            const matchLocation = !locationVal || locationText.includes(locationVal);
            const matchItem = !itemVal || itemText.includes(itemVal);
            return matchLocation && matchItem;
        });

        currentPage = 1;
        totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;
        displayRows(currentPage);
        updatePaginationInfo();

        // ✅ Enable reset button only if filters were used
        if (locationVal || itemVal) {
            resetBtn.disabled = false;
            resetBtn.classList.remove("btn-secondary");
            resetBtn.classList.add("btn-danger");
        } else {
            resetBtn.disabled = true;
            resetBtn.classList.remove("btn-danger");
            resetBtn.classList.add("btn-secondary");
        }
    }

    function resetFilter() {
        document.getElementById("filterLocation").value = "";
        document.getElementById("filterItem").value = "";
        filteredRows = [...rows];
        currentPage = 1;
        totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        displayRows(currentPage);
        updatePaginationInfo();

        // ✅ Disable Reset button after reset
        const resetBtn = document.getElementById("resetFilter");
        resetBtn.disabled = true;
        resetBtn.classList.remove("btn-outline-danger");
        resetBtn.classList.add("btn-secondary");
    }

    // 🔹 Sorting handler
    document.getElementById("sortOption").addEventListener("change", function () {
        sortOption = this.value;
        currentPage = 1;
        displayRows(currentPage);
    });
    
    // Setup events
    document.getElementById("applyFilter").addEventListener("click", applyFilter);
    document.getElementById("resetFilter").addEventListener("click", resetFilter);
    // document.getElementById("sortOption").addEventListener("change", applySorting);

    // Initialize
    setupPagination();
    displayRows(currentPage);
    });
</script>



