<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ECOEX Commodity</title>
    <style>
        :root {
            --primary: #48974E;
            --secondary: #D1DE4D;
            --bg: #f5f7f6;
            --text: #1f2a1f;
        }

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5.h6,
        p,
        label {
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            margin: 0;
            padding: 20px;
            color: var(--text);
        }

        .container {
            max-width: 1400px;
            margin: auto;
            background: #fff;
            border-radius: 12px;
            padding: 18px;
        }

        .main_title {
            padding-bottom: 20px;
            color: var(--primary);
        }

        .commodity_box {
            max-width: 1400px;
            margin: auto;
            background: #fff;
            border: 2px solid var(--primary);
            border-radius: 12px;
            padding: 18px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
        }

        .actions .btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            cursor: pointer;
            margin-left: 10px;
        }

        .actions .btn.secondary {
            background: var(--secondary);
            color: #2f4f2f;
        }

        /* Title & Date filters */
        .title-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .title-row h1 {
            margin: 0;
            color: var(--primary);
            font-size: 22px;
        }

        /* Container */
        .date-filters {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
        }

        .filter-section {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            width: 100%;
        }

        /* Group */
        .date-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* Label */
        .filter-label {
            font-size: 14px;
            font-weight: 800;
            color: #48974E;
            letter-spacing: 0.4px;
        }

        /* Select box */
        .ecoex-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            min-width: 260px;
            padding: 10px 40px 10px 14px;

            font-size: 14px;
            font-weight: 600;
            color: #1f2a1f;

            background-color: #ffffff;
            border: 2px solid #48974E;
            border-radius: 10px;

            cursor: pointer;

            background-image:
                linear-gradient(45deg, transparent 50%, #48974E 50%),
                linear-gradient(135deg, #48974E 50%, transparent 50%);
            background-position:
                calc(100% - 18px) 50%,
                calc(100% - 12px) 50%;
            background-size:
                6px 6px,
                6px 6px;
            background-repeat: no-repeat;

            transition: all 0.2s ease-in-out;
        }

        /* Hover */
        .ecoex-select:hover {
            border-color: #3f8747;
        }

        /* Focus */
        .ecoex-select:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(209, 222, 77, 0.55);
        }

        /* Option styling (limited support but safe) */
        .ecoex-select option {
            font-weight: 600;
        }


        /* Cards row */
        .cards-row {
            display: grid;
            grid-template-columns: 260px repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 18px;
        }

        .card {
            border: 2px solid var(--primary);
            border-radius: 14px;
            padding: 14px;
            background: #fff;
            min-height: 100px;
        }

        .company-card {
            background: linear-gradient(180deg, rgba(72, 151, 78, 0.08), rgba(209, 222, 77, 0.10));
        }

        .card-title {
            font-weight: 600;
            color: var(--primary);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card-value {
            font-size: 20px;
            font-weight: 600;
            line-height: 1;
            color: #214321;
        }

        .card-sub {
            margin-top: 6px;
            font-size: 12px;
            color: #4b6a4b;
            font-weight: 600;
        }

        .filter-card input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 2px solid var(--primary);
            outline: none;
        }

        .filter-card input:focus {
            box-shadow: 0 0 0 4px rgba(209, 222, 77, 0.45);
        }

        /* Table */
        .table-section {
            border: 1px solid var(--primary);
            border-radius: 14px;
            overflow: hidden;
        }

        /* Make table scrollable for 14 columns */
        .table-wrap {
            overflow: auto;
            width: 100%;
        }

        table {
            width: max-content;
            /* important for horizontal scroll */
            min-width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: var(--primary);
            color: #fff;
            padding: 10px 5px;
            text-align: left;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 2;
            font-size: 12px;
        }

        tbody td,
        tfoot td {
            padding: 10px 5px;
            border-bottom: 1px solid #e5e5e5;
            white-space: nowrap;
            font-size: 12px;
        }
        tbody td:first-child{
            font-weight: 800;
        }
        tbody tr:hover {
            background: rgba(209, 222, 77, 0.35);
        }

        /* Total row */
        tfoot .total-row td {
            font-weight: 800;
            background: rgba(72, 151, 78, 0.10);
            border-top: 2px solid var(--primary);
            font-size: 12px;
        }

        tfoot .total-row td:first-child {
            color: var(--primary);
        }
        .date-group2 {
            display: flex;
            gap: 14px;
            align-items: center;
            padding: 10px 16px;
            background: rgba(72, 151, 78, 0.08);
            border: 1px solid rgba(72, 151, 78, 0.3);
            border-radius: 8px;
            width: fit-content;
            font-family: 'Segoe UI', sans-serif;
        }

        .date-group2 label {
            color: #48974e;
            font-size: 14px;
            font-weight: 600;
            background: #ffffff;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid rgba(72, 151, 78, 0.35);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            white-space: nowrap;
        }

        .date-group3 {
            display: flex;
            gap: 14px;
            align-items: center;
            padding: 10px 16px;
            background: rgba(72, 151, 78, 0.08);
            border: 1px solid rgba(72, 151, 78, 0.3);
            border-radius: 8px;
            width: fit-content;
            font-family: 'Segoe UI', sans-serif;
        }

        .date-group3 input[type="date"]{
            color: #48974e;
            font-size: 14px;
            font-weight: 600;
            background: #ffffff;
            padding: 5px 12px;
            border-radius: 6px;
            border: 1px solid rgba(72, 151, 78, 0.35);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            white-space: nowrap;
        }

        



        
        /* ============= PRINT STYLES ========== */
        @media print {

            /* Hide everything */
            .title-row,
            .logo-box{
                display: none;
            }
            .card-title {
                font-weight: 600;
                font-size: 20px;
            }

            .card-value {
                font-size: 18px;
                font-weight: 600;
            }
            /* Show only print area */

        }


        @media(max-width: 1199px) {
            .filter-section{
                flex-wrap: wrap;
            }
        }

        @media(max-width: 991px) {
            .cards-row {
                grid-template-columns: 260px repeat(1, 1fr);
            }
        }
        

       

        @media(max-width: 767px) {
            .date-filters{
                flex-wrap: wrap;
            }
            
            .date-group,
            .ecoex-select,
            .date-group2, 
            .date-group3{
                width: 100%;
            }
            .date-group2 label{
                width: 50%;
            }

            .date-group3 > div
            {
                width: 50%;
            }
            .date-group3 > div input
            {
                width: 100%;
            }



        }
        @media(max-width: 575px) {
            .cards-row{
                display: block;
            }
            .company-card{
                margin-bottom: 15px
            }
            .date-group2
            {
                flex-wrap: wrap;
            }
 
            .date-group2 label {
                width: 100%;
            }

           .date-group3 > div
            {
                width: 100%;
            }
        }

    </style>
</head>

<body>

    <div class="container">
        <div class="logo-box">
            <img src="https://commodity.ecoex.market/public/uploads/1700637387admin_leftlogo.png" alt="" style="text-align: center; margin: 0px auto 0; display: block;">
            <h1 class="main_title">ECOEX Commodity</h1>
        </div>
        <div class="commodity_box">
            <!-- Heading + Date filters -->
            <div class="title-row">
                <!-- Top actions -->
                <div class="date-filters">
                    <form method="GET" action="" name="PostName" class="filter-section">
                        <div class="date-group">
                            <input type="hidden" name="mode" value="filter">
                            <select class="form-control  ecoex-select" id="filter_keyword" name="filter_keyword" >

                                <option value="" <?= empty($filter) ? 'selected' : '' ?>>
                                    All Time
                                </option>

                                <option value="today" <?= ($filter == 'today') ? 'selected' : '' ?>>
                                    Today
                                </option>

                                <option value="yesterday" <?= ($filter == 'yesterday') ? 'selected' : '' ?>>
                                    Yesterday
                                </option>

                                <option value="this_month" <?= ($filter == 'this_month') ? 'selected' : '' ?>>
                                    This Month
                                </option>

                                <option value="last_month" <?= ($filter == 'last_month') ? 'selected' : '' ?>>
                                    Last Month
                                </option>

                                <option value="last_7_days" <?= ($filter == 'last_7_days') ? 'selected' : '' ?>>
                                    Last 7 Days
                                </option>

                                <option value="last_30_days" <?= ($filter == 'last_30_days') ? 'selected' : '' ?>>
                                    Last 30 Days
                                </option>

                                <option value="this_year" <?= ($filter == 'this_year') ? 'selected' : '' ?>>
                                    This Year
                                </option>

                                <option value="last_year" <?= ($filter == 'last_year') ? 'selected' : '' ?>>
                                    Last Year
                                </option>

                                <option value="custom_date" <?= ($filter == 'custom_date') ? 'selected' : '' ?>>
                                    Custom Date
                                </option>

                            </select>

                        </div>

                        <div class="date-group3 custom-date-box" style="display:none;">
                            <div>
                                <label class="filter-label">From </label>
                                <input type="date" id="from_date" name="from_date" value="<?= !empty($from_date_input) ? $from_date_input : '' ?>">
                            </div>
                            <div>
                                <label class="filter-label">To </label>
                                <input type="date" id="to_date" name="to_date" value="<?= !empty($to_date_input) ? $to_date_input : '' ?>">
                            </div>
                        </div>




                    </form>

                    


                    <?php if (!empty($from_date) && !empty($to_date)) { ?>
                        <div class="date-group2">
                            <label>
                                From: <?= date('d M Y', strtotime($from_date)) ?>
                            </label>
                            <label>
                                To: <?= date('d M Y', strtotime($to_date)) ?>
                            </label>
                        </div>
                    <?php } ?>

                    
                </div>
                <!-- <div class="header">
                    <div class="actions">
                        <button class="btn" onclick="printTable()">Print</button>
                        <button class="btn secondary">Download</button>
                    </div>
                </div> -->
            </div>
            <!-- Cards row (Company card + other card boxes) -->
            <div class="cards-row">

                <!-- Company card box -->
                <div class="card company-card">
                    <div class="card-title">Registered Companies</div>
                    <p class="card-value"><?= $companies ?></p>
                </div>

                <div class="card company-card">
                    <div class="card-title">Registered Plants</div>
                    <p class="card-value"><?= $plants ?></p>
                </div>

                <div class="card company-card">
                    <div class="card-title">Registered Vendors</div>
                    <p class="card-value"><?= $vendors ?></p>
                </div>
                <div class="card company-card">
                    <div class="card-title"> Subscribed Vendors</div>
                    <p class="card-value"><?= $subscribe_vendors ?></p>
                </div>

            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-section print-area" id="printArea">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Users</th>
                                    <th>Request <br/>Submitted</th>
                                    <th>Accept <br/>Request</th>
                                    <th>Vendor <br/>Allocated</th>
                                    <th>Vendor <br/>Assigned</th>
                                    <th>Pickup <br/>Scheduled</th>
                                    <th>Vehicle <br/>Placed</th>
                                    <th>Material <br/>Weighed</th>
                                    <th>Invoice <br/>from HO</th>
                                    <th>Invoice <br/>to Vendor</th>
                                    <th>Payment received <br/>from Vendor</th>
                                    <th>Vehicle <br/>Dispatched</th>
                                    <th>Payment <br/>to HO</th>
                                    <th>Order <br/>Complete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><?= $MA_name ?></td>
                                    <td><?= $MA_RequestSubmittedCount ?></td>
                                    <td><?= $MA_AcceptRequestCount ?></td>
                                    <td><?= $MA_VendorAllocatedCount ?></td>
                                    <td><?= $MA_VendorAssignedCount ?></td>
                                    <td><?= $MA_PickupScheduledCount ?></td>
                                    <td><?= $MA_VehiclePlacedCount ?></td>
                                    <td><?= $MA_MaterialWeighedCount ?></td>
                                    <td><?= $MA_InvoicefromHOCount ?></td>
                                    <td><?= $MA_InvoicetoVendorCount ?></td>
                                    <td><?= $MA_PaymentreceivedfromVendorCount ?></td>
                                    <td><?= $MA_VehicleDispatchedCount ?></td>
                                    <td><?= $MA_PaymenttoHOCount ?></td>
                                    <td><?= $MA_OrderCompleteCount ?></td>
                                </tr>
                                <!-- <tr>
                                    <td>Users</td>
                                    <td>Request Submitted</td>
                                    <td>Accept Request</td>
                                    <td>Vendor Allocated</td>
                                    <td>Vendor Assigned</td>
                                    <td>Pickup Scheduled</td>
                                    <td>Vehicle Placed</td>
                                    <td>Material Weighed</td>
                                    <td>Invoice from HO</td>
                                    <td>Invoice to Vendor</td>
                                    <td>Payment received from Vendor</td>
                                    <td>Vehicle Dispatched</td>
                                    <td>Payment to HO</td>
                                    <td>Order Complete</td>
                                </tr> -->
                                
                                
                            </tbody>

                            <!-- Total row -->
                            <tfoot>
                                <tr class="total-row">
                                    <td>TOTAL</td>
                                    <td><?= $SUM_RequestSubmittedCount ?></td>
                                    <td><?= $SUM_AcceptRequestCount ?></td>
                                    <td><?= $SUM_VendorAllocatedCount ?></td>
                                    <td><?= $SUM_VendorAssignedCount ?></td>
                                    <td><?= $SUM_PickupScheduledCount ?></td>
                                    <td><?= $SUM_VehiclePlacedCount ?></td>
                                    <td><?= $SUM_MaterialWeighedCount ?></td>
                                    <td><?= $SUM_InvoicefromHOCount ?></td>
                                    <td><?= $SUM_InvoicetoVendorCount ?></td>
                                    <td><?= $SUM_PaymentreceivedfromVendorCount ?></td>
                                    <td><?= $SUM_VehicleDispatchedCount ?></td>
                                    <td><?= $SUM_PaymenttoHOCount ?></td>
                                    <td><?= $SUM_OrderCompleteCount ?></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    const filterSelect   = document.getElementById('filter_keyword');
    const customDateBox  = document.querySelector('.custom-date-box');
    const fromDateInput  = document.getElementById('from_date');
    const toDateInput    = document.getElementById('to_date');
    const form           = filterSelect.form;

    function handleFilterChange() {
        const selectedValue = filterSelect.value;

        if (selectedValue === 'custom_date') {
            // Show inputs but DO NOT submit
            customDateBox.style.display = 'flex';
        } else {
            // Hide custom date inputs
            customDateBox.style.display = 'none';
            fromDateInput.value = '';
            toDateInput.value = '';

            // Existing behavior: auto submit for other filters
            form.submit();
        }
    }

    function autoSubmitIfValidDates() {
        const fromDate = fromDateInput.value;
        const toDate   = toDateInput.value;

        // Only proceed if both dates are selected
        if (!fromDate || !toDate) {
            return;
        }

        // Client-side validation
        if (fromDate > toDate) {
            alert('From date should not be greater than To date');
            toDateInput.value = '';
            return;
        }

        // Valid → submit form
        form.submit();
    }

    filterSelect.addEventListener('change', handleFilterChange);
    fromDateInput.addEventListener('change', autoSubmitIfValidDates);
    toDateInput.addEventListener('change', autoSubmitIfValidDates);

    // Handle page reload / back button
    document.addEventListener('DOMContentLoaded', function () {
        if (filterSelect.value === 'custom_date') {
            customDateBox.style.display = 'block';
        } else {
            customDateBox.style.display = 'none';
        }
    });
</script>



<script>
    function printTable() {
        window.print();
    }
</script>

</html>