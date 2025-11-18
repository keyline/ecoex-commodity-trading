<!-- ============================================ -->
<!-- DYNAMIC PDF TEMPLATE - ECOEX DESIGN -->
<!-- ============================================ -->
<!-- File: app/Views/admin/maincontents/certificates/pdf_template.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Scrap Collection Certificate</title>
    <style>
    /* Page box for PDF */
    @page {
        size: A4;
        /* margin: 8mm 15mm 10mm 15mm;   smaller top & bottom margins */
        margin: 6mm 15mm 8mm 15mm;
    }

    body {
        font-family: "Times New Roman", Times, serif;
        font-size: 12pt;
        line-height: 1.4;
        color: #000;
        margin: 0;
        padding: 6mm 0 0 0;           /* small top padding, no extra left/right */
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

    .logo {
        text-align: center;
        margin: 0 0 10px 0;           /* reduced space below logo */
    }

    .logo img {
        height: 50px;                 /* closer to sample certificate */
    }

    .date-right {
        text-align: right;
        margin: 0 0 12px 0;           /* pull date up & closer to logo */
        font-size: 12pt;
    }

    .ref-number {
        margin: 0 0 15px 0;
        font-size: 12pt;
        font-weight: bold;
    }

    .title {
        text-align: center;
        font-weight: bold;
        text-decoration: underline;
        font-size: 13pt;
        margin: 15px 0 18px 0;        /* much tighter than before */
        letter-spacing: 0.5px;
    }

    .content {
        text-align: justify;
        margin: 10px 0;
        line-height: 1.5;
        font-size: 12pt;
    }

    .content strong {
        font-weight: bold;
    }

    .plant-info {
        margin: 10px 0 12px 0;
        line-height: 1.5;
    }

    .plant-row {
        margin-bottom: 6px;
        display: table;
        width: 100%;
    }

    .plant-label {
        display: table-cell;
        width: 140px;
        font-weight: normal;
    }

    .plant-value {
        display: table-cell;
        padding-left: 10px;
    }

    .quantities-title {
        font-weight: bold;
        margin: 15px 0 10px 0;
        font-size: 13pt;
    }

    .items-section {
        margin: 10px 0 15px 0;
    }

    .item-row {
        margin: 6px 0;
        font-size: 12pt;
    }

    .item-row strong {
        font-weight: bold;
    }

    .footer-text {
        margin: 10px 0 12px 0;
        text-align: justify;
        line-height: 1.5;
        font-size: 12pt;
    }

    .signature-section {
        margin-top: 10px;
    }

    .signature-section p {
        margin: 0;
        line-height: 1.4;
    }

    .sincerely {
        margin-bottom: 20px;
    }

    .signature-image {
        height: 45px;
        margin: 5px 0;
    }

    .company-name {
        margin-top: 5px;
        margin-bottom: 10px;
    }

    .authorized-signatory {
        /* margin-top: 18px;
        font-weight: normal; */
        margin-top: 35px !important;
    }

    .page-footer {
    position: absolute;
    bottom: 2px;               /* 2px above page bottom */
    left: 0;
    right: 0;
    text-align: center;

    padding-bottom: 6px;       /* space above green line */
    }

    .page-footer::after {
    content: "";
    display: block;
    width: 100%;
    border-bottom: 4px solid #7CB342;   /* GREEN LINE BELOW FOOTER TEXT */
    margin-top: 6px;            /* space between footer text and green line */
    }

    .company-footer {
        font-weight: bold;
        font-size: 11pt;
        margin-bottom: 3px;
    }

    .company-subtitle {
        font-size: 9pt;
        margin-bottom: 2px;
    }

    .company-details {
        font-size: 9pt;
        line-height: 1.4;
    }

    .company-details div {
        margin: 1px 0;
    }

    .footer-info {
        margin-top: 6px;
        font-size: 8pt;
        color: #666;
        border-top: 1px solid #ccc;
        padding-top: 6px;
    }
</style>

</head>
<body>
    <!-- DRAFT Watermark -->
    <?php if (isset($status) && $status === 'draft'): ?>
        <!-- <div class="watermark">DRAFT</div> -->
    <?php endif; ?>

    <!-- Logo -->
    <div class="logo">
        <!-- Add logo image path here if available -->
         <img src="/public/uploads/1700637387admin_leftlogo.png" alt="Karma Ecotech Limited Logo">
        <!-- <div style="font-size: 32pt; font-weight: bold; color: #7CB342;">
            <span style="color: #4CAF50;">ECO</span><span style="color: #8BC34A;">EX</span>
        </div> -->
    </div>

    <!-- Date Right Aligned -->
    <div class="date-right">
        Date: <?= date('d-m-Y', strtotime($issue_date ?? date('Y-m-d'))) ?>
    </div>

    <!-- Reference Number Left Aligned -->
    <div class="ref-number">
        Ref: 
        <!-- <?= $certificate_number ?? '' ?> -->
    </div>

    <!-- Title -->
    <div class="title">
        TO WHOM-SO-EVER IT MAY CONCERN
    </div>

    <!-- Main Content -->
    <div class="content">
        This certificate confirms that Karma Ecotech Limited (Ecoex) collected scrap materials 
        from <strong><?= esc($company_name) ?> on <?= date('d-m-Y', strtotime($collection_date)) ?></strong> at the 
        following location:
    </div>

    <!-- Plant Information -->
    <div class="plant-info">
        <div class="plant-row">
            <div class="plant-label">Plant Name</div>
            <div class="plant-value">: <?= esc($plant_name) ?></div>
        </div>
        <div class="plant-row">
            <div class="plant-label">Plant Address</div>
            <div class="plant-value">: <?= esc($plant_address) ?><?php if (!empty($plant_state)): ?>, <?= esc($plant_state) ?><?php endif; ?></div>
        </div>
    </div>

    <!-- Quantities Title -->
    <div class="quantities-title">
        Quantities Collected (in Kgs):
    </div>

    <!-- Items List -->
    <div class="items-section">
        <?php if (isset($items) && is_array($items) && !empty($items)): ?>
            <?php foreach ($items as $index => $item): ?>
                <div class="item-row">
                    <strong><?= ($index + 1) ?>.&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($item['item_description'] ?? $item['description']) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
                    <?php
                    $quantity = $item['quantity'];
                $unit = $item['unit'];

                // Format quantity based on unit
                if (strtolower($unit) === 'nos' || strtolower($unit) === 'pcs') {
                    echo number_format($quantity, 0);
                } else {
                    echo number_format($quantity, 0);
                }
                ?> <?= esc($unit) ?>.</strong>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="item-row"><strong>No items specified.</strong></div>
        <?php endif; ?>
    </div>

    <!-- Footer Text with Vendors -->
    <div class="footer-text">
        Taken scrap materials including trademarked materials from <strong><?= esc($company_name) ?></strong> 
        plant are being picked up by 
        
        <?php if (isset($vendors) && is_array($vendors) && !empty($vendors)): ?>
            <?php
            $vendorNames = array_map(function ($v) {
                return esc($v['company_name']);
            }, $vendors);

            if (count($vendorNames) === 1) {
                echo '<strong>' . $vendorNames[0] . '</strong>';
            } elseif (count($vendorNames) === 2) {
                echo '<strong>' . $vendorNames[0] . '</strong> and <strong>' . $vendorNames[1] . '</strong>';
            } else {
                $lastVendor = array_pop($vendorNames);
                echo '<strong>' . implode('</strong>, <strong>', $vendorNames) . '</strong>, and <strong>' . $lastVendor . '</strong>';
            }
    ?>
        <?php else: ?>
            <strong>authorized vendors</strong>
        <?php endif; ?>
        
        on behalf of Karma Ecotech Limited and sent to 
        
        <?php if (isset($vendors) && is_array($vendors) && count($vendors) > 0): ?>
            <?php
    // Use the last vendor or a specific recycler from vendors list
    $recycler = end($vendors);
            echo '<strong>' . esc($recycler['company_name']) . '</strong>';
            ?>
        <?php else: ?>
            <strong>authorized recyclers</strong>
        <?php endif; ?>
        
        (Recycler Listed in <?= esc($plant_state ?? 'State') ?> Pollution Control Board) for 
        recycling purposes. Karma Ecotech Limited (Ecoex) will channelize these materials according 
        to industry standards
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <p class="sincerely">Sincerely,</p>
        
        <p class="company-name">For Karma Ecotech Limited</p>
        
        <?php if (isset($signature_path) && !empty($signature_path)): ?>
            <?php
            $signaturePath = WRITEPATH . 'uploads/signatures/' . $signature_path;
            if (file_exists($signaturePath)):
                ?>
                <img src="<?= $signaturePath ?>" alt="Signature" class="signature-image">
            <?php endif; ?>
        <?php endif; ?>
        
        <p class="authorized-signatory">Authorized Signatory</p>
    </div>

    <!-- Page Footer -->
    <div class="page-footer">
        <div class="company-footer">Karma Ecotech Limited</div>
        <div class="company-subtitle">(Formerly known as Karma Ecotech Private Limited)</div>
        <div class="company-details">
            <div>5C, 5th Floor, Hansalaya Building, Barakhamba Road, New Delhi - 110001</div>
            <div>info@ecoex.market | +91 84477 67568 | www.ecoex.market</div>
            <div>CIN No. U74999DL2018PLC339735</div>
        </div>
    </div>

    <!-- Certificate Footer Information (only for finalized) -->
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