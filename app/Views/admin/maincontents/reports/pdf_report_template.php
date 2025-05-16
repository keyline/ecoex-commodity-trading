<!DOCTYPE html>
<html>

<head>
    <title>Report PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
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
                <th>Item</th>
                <th>Weight</th>
                <th>Unit</th>
                <th>Vehicle No.</th>
            </tr>
        </thead>
        <tbody>
            <?php $sr = 1;
            foreach ($response['details_data'] as $enq): ?>
                <?php
                // how many rows needed for this group
                $rowCount = max(1, count($enq['items']));
                // format main invoice date
                $mainInvDate = date('d-m-Y', strtotime($enq['invoice_date']));
                // combine all vendor-invoice dates/nos into HTML line breaks
                $vendorDates = array_map(function ($inv) {
                    return date('d-m-Y', strtotime($inv['date']));
                }, $enq['invoices']);
                $vendorNums  = array_map(function ($inv) {
                    return esc($inv['number']);
                }, $enq['invoices']);
                $vendorDatesHtml = implode('<br>', $vendorDates);
                $vendorNumsHtml  = implode('<br>', $vendorNums);
                // vehicles
                $vehicles = implode('<br>', array_map('esc', $enq['vehicles']));
                ?>
                <?php foreach ($enq['items'] as $idx => $item): ?>
                    <tr class="no-break">
                        <?php if ($idx === 0): ?>
                            <td rowspan="<?= $rowCount ?>"><?= $sr++ ?></td>
                            <td rowspan="<?= $rowCount ?>"><?= esc($enq['enquiry_no']) ?></td>
                            <td rowspan="<?= $rowCount ?>"><?= esc($enq['plant_name']) ?></td>
                            <td rowspan="<?= $rowCount ?>"><?= $mainInvDate ?></td>
                            <td rowspan="<?= $rowCount ?>"><?= esc($enq['invoice_number']) ?></td>
                            <td rowspan="<?= $rowCount ?>"><?= esc($enq['sub_enquiry_no']) ?></td>
                            <td rowspan="<?= $rowCount ?>"><?= esc($enq['vendor_name']) ?></td>
                            <td rowspan="<?= $rowCount ?>"><?= $vendorDatesHtml ?></td>
                            <td rowspan="<?= $rowCount ?>"><?= $vendorNumsHtml ?></td>
                        <?php endif; ?>

                        <!-- item columns -->
                        <td><?= esc($item['item_name']) ?></td>
                        <td><?= esc($item['weighted_qty']) ?></td>
                        <td><?= esc($item['weighted_unit']) ?></td>

                        <?php if ($idx === 0): ?>
                            <td rowspan="<?= $rowCount ?>"><?= $vehicles ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>