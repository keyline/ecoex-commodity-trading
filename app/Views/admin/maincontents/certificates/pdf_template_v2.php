<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certificate - Karma Ecotech Limited</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<style>
    body {
        font-family: "Poppins", serif;
        margin: 60px;
        color: #000;
        line-height: 1.6;
    }
    .container {
        max-width: 800px;
        margin: auto;
        border: 1px solid #ccc;
        padding: 40px;
        background: #fff;
    }
    h1, h2, h3, h4 {
        margin: 0;
        padding: 0;
    }
    .ref {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .date {
        text-align: right;
        margin-bottom: 30px;
    }
    .title {
        text-align: center;
        text-decoration: underline;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .highlight {
        /* color: red; */
        font-weight: bold;
    }
    .section {
        margin-bottom: 15px;
    }
    ol {
        margin: 0;
        padding-left: 30px;
    }
    ol li {
        color: red;
        font-weight: bold;
    }
    .qty {
        color: #000;
        font-weight: normal;
        margin-left: 20px;
    }
    .footer {
        margin-top: 40px;
        line-height: 1.8;
    }
</style>
</head>
<body>

<div class="container">
    <div class="ref">Ref: <?= $certificate_number ?? '' ?></div>
    <div class="date">Date: <a href="#" style="color: #3366cc; text-decoration: none;"><?= date('d-m-Y', strtotime($issue_date ?? date('Y-m-d'))) ?></a></div>

    <div class="title">TO WHOM-SO-EVER IT MAY CONCERN</div>

    <p>
        This certificate confirms that Karma <b>Ecotech</b> Limited (<b>Ecoex</b>) collected scrap materials from 
        <span class="highlight"><?= esc($company_name) ?></span> on 
        <b><?= date('d-m-Y', strtotime($collection_date ?? date('Y-m-d'))) ?></b> at the following location:
    </p>

    <div class="section">
        <b>Plant Name</b> : <span class="highlight"><?= esc($plant_name) ?></span><br>
        <b>Plant Address</b> : <span class="highlight"><?= esc($plant_address) ?><?php if (!empty($plant_state)): ?>, <?= esc($plant_state) ?><?php endif; ?></span>
    </div>

    <div class="section">
        <b>Quantities Collected (in Nos & Kgs.)</b>
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
    </div>

    <p>
        Collected scrap materials including trademarked materials from 
        <span class="highlight"><?= esc($company_name) ?> plant</span> are being picked up by 
        <?php if (isset($vendors) && is_array($vendors) && !empty($vendors)): ?>
            <?php
            $vendorNames = array_map(function ($v) {
                return esc($v['company_name']);
            }, $vendors);

            if (count($vendorNames) === 1) {
                $vendorName = $vendorNames[0];
            } elseif (count($vendorNames) === 2) {
                $vendorName = $vendorNames[0] . ' and ' . $vendorNames[1];
            } else {
                $lastVendor = array_pop($vendorNames);
                $vendorName = implode(', ', $vendorNames) . ', and ' . $lastVendor;
            }
    ?>
        <?php else: ?>
            authorized vendors
        <?php endif; ?>
        <span class="highlight"><?= $vendorName ?? 'NA' ?></span> on behalf of Karma <b>Ecotech</b> Limited and sent to 
        <?php if (isset($vendors) && is_array($vendors) && count($vendors) > 0): ?>
            <?php
    // Use the last vendor or a specific recycler from vendors list
    $recycler = end($vendors);
            //echo esc($recycler['company_name']);
            ?>
        <?php else: ?>
            authorized recyclers
        <?php endif; ?>
        <span class="highlight"><?=  esc($recycler['company_name']) ?></span> Plastic Solutions (Recycler Listed in 
        <span class="highlight"><?= esc($plant_state ?? 'State') ?></span> State Pollution Control Board) for recycling purposes. 
        Karma <b>Ecotech</b> Limited (<b>Ecoex</b>) will channelize these materials according to industry standards.
    </p>

    <div class="footer">
        Sincerely,<br><br>
        For Karma <b>Ecotech</b> Limited<br>
        <br><br>
        Authorized Signatory
    </div>
</div>

</body>
</html>
