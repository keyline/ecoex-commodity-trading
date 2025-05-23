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
    <h6><?= $response['graph_title'] ?? 'Report' ?></h6>
    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Enquiry No.</th>
                <th>Plant Name</th>
                <th>Invoice Date</th>
                <th>Invoice No.</th>
                <th>Sub Enquiry No.</th>
                <th>Vendor</th>
                <th>Vendor Invoice Date</th>
                <th>Vendor Invoice No</th>
                <th style="width: 100px;">Item | Weight | Unit</th>
                <th>Vehicle No.</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sr = 1;
            foreach ($response['details_data'] as $enq):
                // main invoice date & numbers
                $mainInvDate = date('d-m-Y', strtotime($enq['invoice_date']));
                $mainInvNums = implode('<br>', array_map(fn($n) => esc($n), json_decode($enq['invoice_numbers'], true)));
            ?>
                <?php foreach ($enq['sub_enquires'] as $sub):
                    // vendor invoice dates & numbers
                    $vendorDates = array_map(fn($inv) => date('d-m-Y', strtotime($inv['date'])), $sub['invoice']);
                    $vendorNums  = array_map(fn($inv) => esc($inv['number']), $sub['invoice']);
                    $vendorDatesHtml = implode('<br>', $vendorDates);
                    $vendorNumsHtml  = implode('<br>', $vendorNums);

                    // vehicles
                    $vehiclesHtml = implode('<br>', array_map('esc', $sub['vehicles']));
                ?>
                    <tr class="no-break">
                        <!-- Primary enquiry details -->
                        <td><?= $sr++ ?></td>
                        <td><?= esc($enq['enquiry_no']) ?></td>
                        <td><?= esc($enq['plant_name']) ?></td>
                        <td class="date_td"><?= $mainInvDate ?></td>
                        <td><?= $mainInvNums ?></td>

                        <!-- Sub-enquiry details -->
                        <td><?= esc($sub['sub_enquiry_no']) ?></td>
                        <td><?= esc($sub['vendor_name']) ?></td>
                        <td class="date_td"><?= $vendorDatesHtml ?></td>
                        <td><?= $vendorNumsHtml ?></td>

                        <!-- Items inner table -->
                        <td style="padding: 0;">
                            <table border-colslapse="collapse" style="width:100%; margin:0; border: none;">
                                <?php foreach ($sub['items'] as $item): ?>
                                    <tr>
                                        <td style="padding: 0 12px; border: none; border-bottom: 1px solid #000; border-right: 1px solid #000;"><?= esc($item['item_name']) ?></td>
                                        <td style="padding: 0 12px; border: none; border-bottom: 1px solid #000; border-right: 1px solid #000;"><?= esc($item['weighted_qty']) ?></td>
                                        <td style="padding: 0 12px; border: none; border-bottom: 1px solid #000; border-right: none; border-left: none"><?= esc($item['weighted_unit']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>

                        <!-- Vehicles -->
                        <td><?= $vehiclesHtml ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>