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
                foreach($response['details_data'] as $data){ 
                // Ensure these are arrays, even if empty
                $vendor_names = $data['vendor_names'] ?? [];
                $item_names = $data['item_names'] ?? [];
                $weighted_qtys = $data['weighted_qtys'] ?? [];
                $weighted_units = $data['weighted_units'] ?? [];
                $vehicle_sets = $data['vehicle_registration_nos'] ?? [];

                // Find the max count across these arrays
                $rowCount = max(
                    count($vendor_names),
                    count($item_names),
                    count($weighted_qtys)                                    
                );

                // If no sub-data, still show one row
                if ($rowCount == 0) $rowCount = 1;
                ?>
                <?php for ($i = 0; $i < $rowCount; $i++) { ?>
                <tr>
                    <td><?= $sr++; ?></td>

                    <?php if ($i == 0) { ?>
                        <!-- Show enquiry-level data only once -->
                        <td rowspan="<?= $rowCount; ?>"><?= esc($data['enquiry_no']); ?></td>
                        <td rowspan="<?= $rowCount; ?>"><?= esc($data['company_names']); ?></td>
                        <td rowspan="<?= $rowCount; ?>"><?= esc($data['plant_names']); ?></td>
                        <td rowspan="<?= $rowCount; ?>"><?= esc($data['assigned_user']); ?></td>
                        <!-- <td></td> -->
                    <?php } ?>

                    <!-- Vehicle Numbers (each sub-enquiry has its own list) -->
                    <td>
                        <?php
                        $vehicles = $vehicle_sets[$i] ?? [];
                        if (!empty($vehicles)) {
                            echo implode('<br>', array_map('esc', $vehicles));
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td><?= esc($item_names[$i] ?? '-'); ?></td>
                    <td><?= esc($weighted_qtys[$i] ?? '-'); ?>/<?= esc($weighted_units[$i] ?? '-'); ?></td>
                    <td><?= esc($vendor_names[$i] ?? '-'); ?></td>
                </tr>
                <?php } ?>                              
            <?php } ?>                            
        </tbody>
    </table>

</body>

</html>