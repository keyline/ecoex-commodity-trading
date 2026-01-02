<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ECOEX Commodity</title>
    <link rel="stylesheet" href="style.css" />
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
            gap: 12px;
        }

        /* Group */
        .date-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* Label */
        .filter-label {
            font-size: 12px;
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
            font-size: 25px;
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
        /* ================= PRINT STYLES ================= */
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
                    <div class="date-group">
                        <form method="GET" action="" name="PostName">
                            <input type="hidden" name="mode" value="filter">
                            <select class="form-control  ecoex-select" id="filter_keyword" name="filter_keyword"
                                onchange="PostName.submit()">
                                <option value="">All Time</option>
                                <option value="today" selected="">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="this_month">This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="last_7_days">Last 7 Days</option>
                                <option value="last_30_days">Last 30 Days</option>
                                <option value="this_year">This Year</option>
                                <option value="last_year">Last Year</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="header">
                    <div class="actions">
                        <button class="btn" onclick="printTable()">Print</button>
                        <button class="btn secondary">Download</button>
                    </div>
                </div>
            </div>
            <!-- Cards row (Company card + other card boxes) -->
            <div class="cards-row">

                <!-- Company card box -->
                <div class="card company-card">
                    <div class="card-title">Companies</div>
                    <p class="card-value">100</p>
                </div>

                <div class="card company-card">
                    <div class="card-title">Plants</div>
                    <p class="card-value">119</p>
                </div>

                <div class="card company-card">
                    <div class="card-title">Vendors</div>
                    <p class="card-value">635</p>
                </div>
                <div class="card company-card">
                    <div class="card-title"> Subscribe Vendors</div>
                    <p class="card-value">635</p>
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
                                    <td>Ram</td>
                                    <td>20</td>
                                    <td>30</td>
                                    <td>40</td>
                                    <td>50</td>
                                    <td>60</td>
                                    <td>70</td>
                                    <td>80</td>
                                    <td>90</td>
                                    <td>100</td>
                                    <td>110</td>
                                    <td>120</td>
                                    <td>130</td>
                                    <td>140</td>
                                </tr>
                                <tr>
                                    <td>Sam</td>
                                    <td>10</td>
                                    <td>15</td>
                                    <td>20</td>
                                    <td>25</td>
                                    <td>30</td>
                                    <td>35</td>
                                    <td>40</td>
                                    <td>45</td>
                                    <td>50</td>
                                    <td>55</td>
                                    <td>60</td>
                                    <td>65</td>
                                    <td>70</td>
                                </tr>
                                <tr>
                                    <td>Ram</td>
                                    <td>20</td>
                                    <td>30</td>
                                    <td>40</td>
                                    <td>50</td>
                                    <td>60</td>
                                    <td>70</td>
                                    <td>80</td>
                                    <td>90</td>
                                    <td>100</td>
                                    <td>110</td>
                                    <td>120</td>
                                    <td>130</td>
                                    <td>140</td>
                                </tr>
                            </tbody>

                            <!-- Total row -->
                            <tfoot>
                                <tr class="total-row">
                                    <td>TOTAL</td>
                                    <td>30</td>
                                    <td>45</td>
                                    <td>60</td>
                                    <td>75</td>
                                    <td>90</td>
                                    <td>105</td>
                                    <td>120</td>
                                    <td>135</td>
                                    <td>150</td>
                                    <td>165</td>
                                    <td>180</td>
                                    <td>195</td>
                                    <td>210</td>
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
    function printTable() {
        window.print();
    }
</script>

</html>