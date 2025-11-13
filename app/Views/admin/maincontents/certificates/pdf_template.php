<!-- ============================================ -->
<!-- DYNAMIC PDF TEMPLATE - STRICT FORMATTING -->
<!-- ============================================ -->
<!-- File: app/Views/admin/maincontents/certificates/pdf_template.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Scrap Collection Certificate</title>
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }
        
        body {
            font-family: "Poppins", serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #000;
            margin: 60px;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80pt;
            color: #ff0000;
            opacity: 0.1;
            z-index: -1;
            font-weight: bold;
        }
        
        .header-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .header-left {
            display: table-cell;
            width: 50%;
            text-align: left;
            font-size: 11pt;
        }
        
        .header-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            font-size: 11pt;
        }
        
        .header-left strong,
        .header-right strong {
            font-weight: bold;
        }
        
        .title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 14pt;
            margin: 20px 0;
            letter-spacing: 0.5px;
        }
        
        .content {
            text-align: justify;
            margin: 20px 0;
            line-height: 1.8;
        }
        
        .content strong {
            font-weight: bold;
        }
        
        .plant-info {
            margin: 15px 0;
            line-height: 1.8;
        }
        
        .plant-info div {
            margin-bottom: 5px;
        }
        
        .quantities-title {
            font-weight: bold;
            margin: 20px 0 10px 0;
            font-size: 11pt;
        }
        
        .items-list {
            margin: 10px 0 10px 20px;
            padding-left: 20px;
            list-style-type: decimal;
        }
        
        .items-list li {
            margin: 8px 0;
            line-height: 1.6;
        }
        
        .items-list li strong {
            font-weight: bold;
        }
        
        .footer-text {
            margin: 20px 0;
            text-align: justify;
            line-height: 1.8;
        }
        
        .vendors-section {
            margin: 20px 0;
            line-height: 1.8;
        }
        
        .vendors-list {
            margin: 10px 0 10px 20px;
        }
        
        .vendor-item {
            margin: 5px 0;
        }
        
        .signature-section {
            margin-top: 50px;
        }
        
        .signature-section p {
            margin: 5px 0;
        }
        
        .signature-line {
            margin-top: 10px;
            font-weight: bold;
        }
        
        .signature-image {
            margin-top: 10px;
            height: 50px;
        }
        
        .footer-info {
            margin-top: 30px;
            font-size: 8pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- DRAFT Watermark -->
    <?php if (isset($status) && $status === 'draft'): ?>
        <!-- <div class="watermark">DRAFT</div> -->
    <?php endif; ?>

    <!-- Header with Ref Left and Date Right -->
    <div class="header-row">
        <div class="header-left">
            <strong>Ref:</strong> <?= $certificate_number ?? '' ?>
        </div>
        <div class="header-right">
            <strong>Date:</strong> <?= date('d-m-Y', strtotime($issue_date ?? date('Y-m-d'))) ?>
        </div>
    </div>

    <!-- Title -->
    <div class="title">
        TO WHOM-SO-EVER IT MAY CONCERN
    </div>

    <!-- Main Content -->
    <div class="content">
        This certificate confirms that Karma Ecotech Limited (Ecoex) collected
        scrap materials from <strong><?= esc($company_name) ?></strong> on
        <strong><?= date('d-m-Y', strtotime($collection_date)) ?></strong> at the following location:
    </div>

    <!-- Plant Information -->
    <div class="plant-info">
        <div>
            <strong>Plant Name:</strong> <?= esc($plant_name) ?>
        </div>
        <div>
            <strong>Plant Address:</strong> <?= esc($plant_address) ?><?php if (!empty($plant_state)): ?>, <?= esc($plant_state) ?><?php endif; ?>
        </div>
    </div>

    <!-- Quantities Title -->
    <div class="quantities-title">
        Quantities Collected (in Nos & Kgs.)
    </div>

    <!-- Items List -->
    <ol class="items-list">
        <?php if (isset($items) && is_array($items) && !empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <li>
                    <strong><?= esc($item['item_description'] ?? $item['description']) ?> : 
                    <?php
                    $quantity = $item['quantity'];
                $unit = $item['unit'];

                // Format quantity based on unit
                if (strtolower($unit) === 'nos' || strtolower($unit) === 'pcs') {
                    echo number_format($quantity, 0);
                } else {
                    echo number_format($quantity, 2);
                }
                ?> <?= esc($unit) ?>.</strong>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li><strong>No items specified.</strong></li>
        <?php endif; ?>
    </ol>

    <!-- Footer Text with Vendors -->
    <div class="footer-text">
        Collected scrap materials including trademarked materials from <strong><?= esc($company_name) ?></strong>
        plant are being picked up by 
        
        <?php if (isset($vendors) && is_array($vendors) && !empty($vendors)): ?>
            <?php
            $vendorNames = array_map(function ($v) {
                return esc($v['company_name']);
            }, $vendors);

            if (count($vendorNames) === 1) {
                echo $vendorNames[0];
            } elseif (count($vendorNames) === 2) {
                echo $vendorNames[0] . ' and ' . $vendorNames[1];
            } else {
                $lastVendor = array_pop($vendorNames);
                echo implode(', ', $vendorNames) . ', and ' . $lastVendor;
            }
    ?>
        <?php else: ?>
            authorized vendors
        <?php endif; ?>
        
        on behalf of Karma Ecotech Limited and sent to 
        
        <?php if (isset($vendors) && is_array($vendors) && count($vendors) > 0): ?>
            <?php
    // Use the last vendor or a specific recycler from vendors list
    $recycler = end($vendors);
            echo esc($recycler['company_name']);
            ?>
        <?php else: ?>
            authorized recyclers
        <?php endif; ?>
        
        (Recycler Listed in <?= esc($plant_state ?? 'State') ?> Pollution Control Board) for 
        recycling purposes. Karma Ecotech Limited (Ecoex) will channelize these materials according 
        to industry standards.
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <p>Sincerely,</p>
        
        <?php if (isset($signature_path) && !empty($signature_path)): ?>
            <?php
            $signaturePath = WRITEPATH . 'uploads/signatures/' . $signature_path;
            if (file_exists($signaturePath)):
                ?>
                <img src="<?= $signaturePath ?>" alt="Signature" class="signature-image">
            <?php endif; ?>
        <?php else: ?>
            <p style="margin-top: 30px;">&nbsp;</p>
        <?php endif; ?>
        
        <p style="margin-top: <?= (isset($signature_path) && !empty($signature_path)) ? '5px' : '0' ?>;">
            For Karma Ecotech Limited
        </p>
        
        <div class="signature-line">
            Authorized Signatory
        </div>
    </div>

    <!-- Footer Information (only for finalized) -->
    <?php if (isset($status) && $status === 'finalized'): ?>
        <div class="footer-info">
            <div style="margin-bottom: 5px;">
                <strong>Certificate Number:</strong> <?= $certificate_number ?> | 
                <strong>Enquiry Number:</strong> <?= $enquiry_no ?? 'N/A' ?>
            </div>
            <div>
                <strong>Finalized on:</strong> <?= isset($finalized_at) ? date('d-m-Y H:i', strtotime($finalized_at)) : date('d-m-Y H:i') ?> | 
                <strong>Version:</strong> <?= $version ?? '1' ?>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>

<!-- ============================================ -->
<!-- USAGE NOTES -->
<!-- ============================================ -->
<!--
Expected Data Structure:
------------------------
$data = [
    'certificate_number' => 'CERT-20251112-0001',
    'enquiry_no' => '1148',
    'issue_date' => '2025-11-12',
    'collection_date' => '2025-11-04',
    'client_name' => 'NOURISHCO BEVERAGES LIMITED',
    'plant_name' => 'Frontline Beverages & Agro',
    'plant_address' => 'SY NO. 169/2, PENUGANCHIPROLU VILLAGE, KRISHNA, NEAR VPR GARDENS',
    'plant_state' => 'Andhra Pradesh',
    'status' => 'draft', // or 'finalized'
    'version' => 1,
    'finalized_at' => '2025-11-12 10:30:00',
    'signature_path' => 'signature_123_1699876543.png',
    'items' => [
        [
            'item_description' => 'Label',
            'description' => 'Label', // fallback
            'quantity' => 4000.00,
            'unit' => 'Kgs'
        ],
        [
            'item_description' => 'Carton',
            'description' => 'Carton',
            'quantity' => 100.00,
            'unit' => 'Kgs'
        ]
    ],
    'vendors' => [
        [
            'vendor_id' => '456',
            'company_name' => 'KUNAL PLASTICS'
        ],
        [
            'vendor_id' => '789',
            'company_name' => 'Haryana Plastic Solutions'
        ]
    ]
];
