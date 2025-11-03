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
                                                <select id="filterVendor" class="form-control">
                                                <option value="">Filter by Vendor Name</option>
                                                <?php foreach ($vendors as $vendor) {?>
                                                <option value="<?=$vendor->vendor_name?>"><?=$vendor->vendor_name?></option>
                                                <?php } ?>
                                                <!-- add more -->
                                                </select>
                                            </div>
                                            <div class="col-md-3 my-2">
                                                <input type="date" id="filterStartDate" class="form-control" placeholder="Start Date">
                                            </div>
                                            <div class="col-md-3 my-2">
                                                <input type="date" id="filterEndDate" class="form-control" placeholder="End Date">
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
                        <div   div id="chartContainer"  style="width:60%; margin:auto; display:none;">
                            <canvas id="quotationChart"></canvas>
                        </div>
                        
                        <button id="exportExcel" class="btn btn-success mb-3">
                            <i class="fa fa-file-excel"></i> Export to Excel
                        </button>
                        <?php
                            // Step 1: Prepare data
                            $vendors = [];
                            $items = [];
                            $dataMap = [];                           

                            foreach ($graphs as $graph) {                                
                                $vendor = $graph->vendor_name;
                                $item = $graph->scrap_name;
                                $rate  = (float)$graph->rate;

                                if (!in_array($vendor, $vendors)) $vendors[] = $vendor;
                                if (!in_array($item, $items)) $items[] = $item;

                                // $dataMap[$vendor][$item] = $rate;              
                                if (!isset($dataMap[$vendor][$item]) || $rate > $dataMap[$vendor][$item]) {
                                    $dataMap[$vendor][$item] = $rate;
                                }                  
                            }
                            // echo "<pre>";
                            //     print_r($dataMap);
                            //     echo "</pre>";
                            ?>

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
                                                <td><h6><?= (($row->quotation_item_created_at != '') ? date_format(date_create($row->quotation_item_created_at), "M d, Y h:i A") : '') ?></h6></td>    
                                                <?php if($itemStatus == 1) {?>
                                                <td><h6><?= (($row->quotation_item_status == 1) ? date_format(date_create($row->active_time), "M d, Y h:i A") : '') ?></h6></td>
                                                <?php }elseif($itemStatus == 2) { ?>
                                                <td><h6><?= (($row->quotation_item_status == 2) ? date_format(date_create($row->reject_time), "M d, Y h:i A") : '') ?></h6></td>
                                                <?php } ?>                                          
                                                
                                                <td>
                                                    <?php if ($common_model->checkModuleFunctionAccess(23, 109)) { ?>
                                                        <a href="<?= base_url('admin/' . $controller_route . '/view-detail/' . encoded($row->id). '/' . encoded($row->quotation_item_id)) ?>" class="btn btn-outline-info btn-sm" title="View <?= $title ?>" target="_blank"><i class="fa fa-info-circle"></i></a>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    let mainChart;  

    const items = <?= json_encode($items) ?>;
    const vendors = <?= json_encode($vendors) ?>;
    const dataMap = <?= json_encode($dataMap) ?>;
    const totalVendors = vendors.length;

    // Step 2: Prepare datasets dynamically
    function renderMainChart() {
        const datasets = vendors.map((vendor, i) => ({
            label: vendor,
            data: items.map(item => dataMap[vendor]?.[item] ?? 0),
            backgroundColor: `hsl(${(i * 360) / totalVendors}, 70%, 50%)`
        }));

        // Step 3: Render chart
        const ctx = document.getElementById('quotationChart').getContext('2d');
        mainChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: items,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Rates by item Name and Vendor (Unit: KG)'
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Rate'
                        }
                    }
                }
            }
        });
    }
    // ✅ Call once on page load
    document.addEventListener("DOMContentLoaded", renderMainChart);
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let isInitialLoad = true;
        let quotationChart = null;
        const rowsPerPage = 10;
        const table = document.getElementById("simpletable1");
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));
        let filteredRows = [...rows]; // initial data (no filter)
        let currentPage = 1;
        let totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        let currentSort = "";

        // ===============================
        // Display rows (pagination + sort)
        // ===============================

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
            const paginatedRows = sortedRows.slice(start, end);
            paginatedRows.forEach(row => tbody.appendChild(row));

            totalPages = Math.ceil(sortedRows.length / rowsPerPage) || 1;
            updatePaginationInfo();
        // ✅ Wait for next tick, then update chart
            // requestAnimationFrame(() => updateChart());
            // ✅ Only update chart after filtering or pagination changes — not on initial load
            if (!isInitialLoad) {
                requestAnimationFrame(() => updateChart());
            }
        }

        // ===============================
        // Pagination setup
        // ===============================

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
            
        // ===============================
        // Filtering logic
        // ===============================
        function applyFilter() {
            const locationVal = document.getElementById("filterLocation").value.toLowerCase();
            const itemVal = document.getElementById("filterItem").value.toLowerCase();
            const vendorVal = document.getElementById("filterVendor").value.toLowerCase();
            const startDateVal = document.getElementById("filterStartDate").value;
            const endDateVal = document.getElementById("filterEndDate").value;
            const resetBtn = document.getElementById("resetFilter");

            filteredRows = rows.filter(row => {
                const locationText = row.cells[5]?.innerText.toLowerCase() || ""; // 6th column = Location
                const itemText = row.cells[2]?.innerText.toLowerCase() || "";     // 3rd column = Item Name
                const vendorText = row.cells[7]?.innerText.toLowerCase() || "";     // 8th column = Item Name
                const dateText = row.cells[9]?.innerText.trim() || ""; // 10th column = Quotation Submitted
                
                // 🗓️ Convert date string (2025-10-29 17:00:43) into Date object
                let rowDate = null;
                if (dateText) {
                    // Replace space with 'T' to make it ISO-compatible for Safari/Firefox
                    rowDate = new Date(dateText.replace(" ", "T"));
                }

                const startDate = startDateVal ? new Date(startDateVal + "T00:00:00") : null;
                const endDate = endDateVal ? new Date(endDateVal + "T23:59:59") : null;

                const matchLocation = !locationVal || locationText.includes(locationVal);
                const matchItem = !itemVal || itemText.includes(itemVal);
                const matchVendor = !vendorVal || vendorText.includes(vendorVal);
                let matchDate = true;
                if (startDate && rowDate) matchDate = rowDate >= startDate;
                if (endDate && rowDate) matchDate = matchDate && rowDate <= endDate;
                if ((startDate || endDate) && !rowDate) matchDate = false;

                return matchLocation && matchItem && matchVendor && matchDate;

                });

            currentPage = 1;
            totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;
            displayRows(currentPage);
            updatePaginationInfo();
            updateChart();

            // ✅ Enable reset button only if filters were used
            if (locationVal || itemVal || vendorVal || startDateVal || endDateVal) {
                resetBtn.disabled = false;
                resetBtn.classList.remove("btn-secondary");
                resetBtn.classList.add("btn-danger");
            } else {
                resetBtn.disabled = true;
                resetBtn.classList.remove("btn-danger");
                resetBtn.classList.add("btn-secondary");
            }
        }

        // ===============================
        // Reset filters
        // ===============================

        function resetFilter() {
            document.getElementById("filterLocation").value = "";
            document.getElementById("filterItem").value = "";
            document.getElementById("filterVendor").value = "";
            document.getElementById("filterStartDate").value = "";
            document.getElementById("filterEndDate").value = "";

            filteredRows = [...rows];
            currentPage = 1;
            totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            displayRows(currentPage);
            updatePaginationInfo();

            // ✅ Disable Reset button after reset
            const resetBtn = document.getElementById("resetFilter");
            resetBtn.disabled = true;
            resetBtn.classList.remove("btn-danger");
            resetBtn.classList.add("btn-secondary");

            // ✅ Restore main chart from other script
            renderMainChart();

            // ✅ Small delay to ensure DOM re-render
            // setTimeout(() => updateChart(true), 50);
        }

        // ===============================
        // Chart Update Logic
        // ===============================    

        function updateChart(useAll = false) {
            const chartContainer = document.getElementById("chartContainer"); // parent div of chart
            const ctx = document.getElementById("quotationChart").getContext("2d");
            const targetRows = useAll ? rows : Array.from(document.querySelectorAll("#simpletable1 tbody tr"));
            const chartData = {};

            targetRows.forEach(row => {
                const vendor = row.cells[7]?.innerText.trim(); // vendor_name
                const item = row.cells[2]?.innerText.trim();   // scrap_name
                const rateText = row.cells[3]?.innerText.trim(); // Quoted Rate (e.g. "23 /KG")

                // ✅ Extract numeric rate and unit
                const match = rateText.match(/([\d.]+)\s*\/?\s*([a-zA-Z]+)/);
                if (!match) return;

                const rate = parseFloat(match[1]);
                const unit = match[2].toLowerCase();

                // ✅ Include only if unit is "kg"
                if (unit !== 'kg') return;

                if (!chartData[item]) chartData[item] = {};
                if (!chartData[item][vendor] || rate > chartData[item][vendor]) {
                    chartData[item][vendor] = rate;
                }
            });

            const scraps = Object.keys(chartData);
            // ✅ If no items (no KG data or no filter matches), hide chart and exit
            if (scraps.length === 0) {
                if (quotationChart) quotationChart.destroy();
                chartContainer.style.display = "none"; // hide graph section
                return;
            } else {
                chartContainer.style.display = "block"; // show when data exists
            }
            
            const vendors = [...new Set(targetRows.map(r => r.cells[7]?.innerText.trim()))];
            const totalVendors = vendors.length;

            const datasets = vendors.map((vendor, i) => ({
                label: vendor,
                data: scraps.map(item => chartData[item][vendor] || 0),
                backgroundColor: `hsl(${(i * 360) / totalVendors}, 70%, 50%)`
            }));

            // const ctx = document.getElementById("quotationChart").getContext("2d");
            // if (quotationChart) quotationChart.destroy();
            // ✅ Destroy any previous chart before rendering a new one
            if (mainChart) {
                mainChart.destroy();
                mainChart = null;
            }

            // ✅ Destroy old filtered chart before recreating
            if (quotationChart) quotationChart.destroy();

            // ✅ Create new chart instance
            quotationChart = new Chart(ctx, {
                type: "bar",
                data: { labels: scraps, datasets },
                options: {
                    responsive: true,
                    plugins: {
                        title: { display: true, text: "Rates by Item Name and Vendor (Unit: KG) (filtered)" },
                        legend: { position: "bottom" },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: "Rate" }
                        }
                    }
                }
            });
        }
    
        // ===============================
        // Sorting
        // ===============================

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
        isInitialLoad = false; // ✅ Mark that first load is done
    });

    document.getElementById("exportExcel").addEventListener("click", function () {
    const table = document.getElementById("simpletable1");
    const headerCells = table.querySelectorAll("thead th");
    const wb = XLSX.utils.book_new();
    const ws_data = [];

    // 🔹 Collect headers except "Action"
    const headers = [];
    headerCells.forEach(th => {
        const text = th.innerText.trim();
        if (text.toLowerCase() !== "action") headers.push(text);
    });
    ws_data.push(headers);

    // 🔹 Determine which rows to export
    // Use your existing JS arrays, not DOM
    // 'filteredRows' contains all visible (filtered) rows
    // 'rows' contains all rows (original data)
    let exportRows = filteredRows.length ? filteredRows : rows;

    // 🔹 Add each row's cell text (skip Action column)
    exportRows.forEach(tr => {
        const rowData = [];
        const cells = tr.querySelectorAll("td, th");
        cells.forEach((td, i) => {
            const headerText = headerCells[i]?.innerText.trim().toLowerCase();
            if (headerText !== "action") {
                rowData.push(td.innerText.trim());
            }
        });
        ws_data.push(rowData);
    });

    // 🔹 Stop if no data
    if (ws_data.length <= 1) {
        alert("No data available to export.");
        return;
    }

    // 🔹 Create Excel sheet
    const ws = XLSX.utils.aoa_to_sheet(ws_data);
    XLSX.utils.book_append_sheet(wb, ws, "Quotation_Data");

    // 🔹 File name changes automatically
    const filename = (filteredRows.length && filteredRows.length !== rows.length)
        ? "Filtered_Quotation_Data.xlsx"
        : "All_Quotation_Data.xlsx";

    XLSX.writeFile(wb, filename);
});
</script>

<script>
//    document.getElementById("exportExcel").addEventListener("click", function () {
//     const table = document.getElementById("simpletable1");
//     const headerCells = table.querySelectorAll("thead th");
//     const allRows = Array.from(table.querySelectorAll("tbody tr"));

//     // Collect all rows, including hidden ones
//     let filteredRows = [];
//     let isFiltered = false;

//     allRows.forEach(tr => {
//         const style = window.getComputedStyle(tr);
//         const isVisible = style.display !== "none" && style.visibility !== "hidden";
//         if (isVisible) {
//             filteredRows.push(tr);
//         }
//     });

//     // If filtered rows are fewer than all, filtering is active
//     if (filteredRows.length < allRows.length) {
//         isFiltered = true;
//     } else {
//         // No filter applied → export all rows
//         filteredRows = allRows;
//     }

//     if (filteredRows.length === 0) {
//         alert("No data to export!");
//         return;
//     }

//     // Prepare workbook and worksheet data
//     const wb = XLSX.utils.book_new();
//     const ws_data = [];

//     // Extract headers (excluding Action)
//     const headers = [];
//     headerCells.forEach(th => {
//         const headerText = th.innerText.trim();
//         if (headerText.toLowerCase() !== "action") {
//             headers.push(headerText);
//         }
//     });
//     ws_data.push(headers);

//     // Add row data
//     filteredRows.forEach(tr => {
//         const rowData = [];
//         const cells = tr.querySelectorAll("td, th");
//         cells.forEach((td, index) => {
//             const headerText = headerCells[index]?.innerText.trim().toLowerCase();
//             if (headerText !== "action") {
//                 rowData.push(td.innerText.trim());
//             }
//         });
//         ws_data.push(rowData);
//     });

//     // Create worksheet and file
//     const ws = XLSX.utils.aoa_to_sheet(ws_data);
//     XLSX.utils.book_append_sheet(wb, ws, "Quotation_Data");

//     const filename = isFiltered
//         ? "Filtered_Quotation_Data.xlsx"
//         : "All_Quotation_Data.xlsx";

//     XLSX.writeFile(wb, filename);
// });




</script>




