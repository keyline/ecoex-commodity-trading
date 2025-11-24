<!DOCTYPE html>
<html>

<head>
    <title>Report PDF</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1px;
            border: 1px solid #000;
            text-align: center;
            /* font-size: 12px; */
        }

        th {
            background-color: #f2f2f2;
            vertical-align: middle;

        }

        td {
            vertical-align: top;
        }

        h5 {
            text-align: center;
            margin-bottom: 20px;
        }

        tr.no-break,
        td.no-break {
            page-break-inside: avoid;
        }

        tbody tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }


        .date_td {
            width: 95px;
        }
    </style>

</head>

<body>
    <h6>Enquiry Report</h6>
    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Enquiry No.</th>
                <th>Company Name</th>
                <th>Plant Name</th>    
                <th>Assigned user</th>                              
                <th>Vehicle No.</th>
                <th>Material Lifted</th>
                <th>Quantity</th>                                                           
                <th>Vendor</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sr = 1;
            foreach ($response['details_data'] as $data): 
            ?>
            <tr>
                <td><?= $sr++; ?></td>

                <td><?= esc($data['enquiry_no']); ?></td>
                <td><?= esc($data['company_names']); ?></td>
                <td><?= esc($data['plant_names']); ?></td>

                <!-- These fields are already merged with <br> in controller -->
                <td><?= $data['assigned_users'] ?: '-'; ?></td>
                <td><?= $data['vehicle_registration_nos'] ?: '-'; ?></td>
                <td><?= $data['item_names'] ?: '-'; ?></td>
                <td><?= $data['weighted_qtys'] ?: '-'; ?></td>
                <td><?= $data['vendor_names'] ?: '-'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>