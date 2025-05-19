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
                <!-- <th>Weight</th>
                <th>Unit</th> -->
                <th>Vehicle No.</th>
            </tr>
        </thead>

        <tbody>
            <?php $sr = 1;
            foreach ($response['details_data'] as $enq): ?>
                <?php
                // format main invoice date
                $mainInvDate = date('d-m-Y', strtotime($enq['invoice_date']));

                // generate vendor invoice dates as line breaks
                $vendorDatesHtml = '<ul style="margin:0; padding-left:1em;">';
                $datesCount = count($enq['invoices']);
                foreach ($enq['invoices'] as $index => $inv) {
                    $lineBreak = ($index < $datesCount - 1) ? '<br>' : '';
                    $vendorDatesHtml .= '<li style="display:inline;">' . date('d-m-Y', strtotime($inv['date'])) . $lineBreak . '</li>';
                }
                $vendorDatesHtml .= '</ul>';

                // generate vendor invoice numbers as line breaks
                $vendorNumsHtml = '<ul style="margin:0; padding-left:1em;">';
                $numsCount = count($enq['invoices']);
                foreach ($enq['invoices'] as $index => $inv) {
                    $lineBreak = ($index < $numsCount - 1) ? '<br>' : '';
                    $vendorNumsHtml .= '<li style="display:inline;">' . esc($inv['number']) . $lineBreak . '</li>';
                }
                $vendorNumsHtml .= '</ul>';

                // generate vehicle numbers as line breaks
                $vehiclesHtml = '<ul style="margin:0; padding-left:1em;">';
                $vehCount = count($enq['vehicles']);
                foreach ($enq['vehicles'] as $index => $veh) {
                    $lineBreak = ($index < $vehCount - 1) ? '<br>' : '';
                    $vehiclesHtml .= '<li style="display:inline;">' . esc($veh) . $lineBreak . '</li>';
                }
                $vehiclesHtml .= '</ul>';
                ?>

                <tr class="no-break">
                    <!-- Primary details -->
                    <td><?= $sr++ ?></td>
                    <td><?= esc($enq['enquiry_no']) ?></td>
                    <td><?= esc($enq['plant_name']) ?></td>
                    <td class="date_td"><?= $mainInvDate ?></td>
                    <td><?= esc($enq['invoice_number']) ?></td>
                    <td><?= esc($enq['sub_enquiry_no']) ?></td>
                    <td><?= esc($enq['vendor_name']) ?></td>
                    <td class="date_td"><?= $vendorDatesHtml ?></td>
                    <td><?= $vendorNumsHtml ?></td>

                    <!-- Item columns -->
                    <td style="padding: 0;">
                        <!-- <ul style="margin:0; padding-left:1em;">
                            <?php $itemCount = count($enq['items']);
                            foreach ($enq['items'] as $idx => $item):
                                $lineBreak = ($idx < $itemCount - 1) ? '<br>' : ''; ?>
                                <li style="display:inline;height:max-content"><?= esc($item['item_name']) . $lineBreak ?></li>
                            <?php endforeach; ?>
                        </ul> -->
                        <table border-colslapse="collapse" style="width:100%; margin:0; border: none;">
                            
                            <?php $itemCount = count($enq['items']);
                            foreach ($enq['items'] as $idx => $item):
                                $lineBreak = ($idx < $itemCount - 1) ? '<br>' : ''; ?>
                                <tr>
                                    <td style="padding: 0 12px; border: none; border-bottom: 1px solid #000; border-right: 1px solid #000;"><?= esc($item['item_name']) . $lineBreak ?></td>
                                    <td style="padding: 0 12px; border: none; border-bottom: 1px solid #000; border-right: 1px solid #000;"><?= esc($item['weighted_qty']) . $lineBreak ?></td>
                                    <td style="padding: 0 12px; border: none; border-bottom: 1px solid #000; border-right: none" ; border-left: none"><?= esc($item['weighted_unit']) . $lineBreak ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- <tr>
                                <td style="padding: 0 15px; border: none; border-bottom: 1px solid #000; border-right: 1px solid #000;">item1 item item</td>
                                <td style="padding: 0 15px; border: none; border-bottom: 1px solid #000; border-right: 1px solid #000;">220</td>
                                <td style="padding: 0 15px; border: none; border-bottom: 1px solid #000;">KG</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 15px; border: none; border-bottom: 1px solid #000; border-right: 1px solid #000;">item1 item item</td>
                                <td style="padding: 0 15px; border: none; border-bottom: 1px solid #000; border-right: 1px solid #000;">220</td>
                                <td style="padding: 0 15px; border: none; border-bottom: 1px solid #000; border-right: none">KG</td>
                            </tr> -->
                        </table>
                    </td>
                    <!-- <td style="vertical-align:top;">
                        <ul style="margin:0; padding-left:1em;">
                            <?php foreach ($enq['items'] as $idx => $item):
                                $lineBreak = ($idx < $itemCount - 1) ? '<br>' : ''; ?>
                                <li style="display:inline;height:max-content"><?= esc($item['weighted_qty']) . $lineBreak ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td> -->
                    <!-- <td style="vertical-align:top;">
                        <ul style="margin:0; padding-left:1em;">
                            <?php foreach ($enq['items'] as $idx => $item):
                                $lineBreak = ($idx < $itemCount - 1) ? '<br>' : ''; ?>
                                <li style="display:inline;height:max-content"><?= esc($item['weighted_unit']) . $lineBreak ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td> -->
                    <td><?= $vehiclesHtml ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>


    </table>
</body>

</html>