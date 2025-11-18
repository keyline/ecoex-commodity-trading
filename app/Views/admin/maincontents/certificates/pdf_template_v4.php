<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?= esc($plant_name) ?></title>

<style>
/* ---------------- PAGE SETTINGS ---------------- */
@page {
    size: A4;
    /* margin: 10mm 15mm 2mm 15mm;   2mm bottom space for footer */
    margin: 5mm 30mm 2mm 30mm;
}

html {
    margin-bottom: 0;              /* ensures footer sits flush */
}

body {
    font-family: "Times New Roman", Times, serif;
    font-size: 12pt;
    line-height: 1.45;
    margin: 0;
    padding-top: 8mm;
    margin-bottom: 25mm;         /* space for footer */
}


/* ---------------- HEADER ---------------- */
.logo {
    text-align: center;
    margin-bottom: 12px;
}

.logo img {
    height: 50px;
}

.date-right {
    text-align: right;
    font-size: 12pt;
    margin-bottom: 12px;
}

.ref-number {
    font-size: 12pt;
    font-weight: bold;
    margin-bottom: 15px;
}

.title {
    text-align: center;
    font-size: 14pt;
    font-weight: bold;
    text-decoration: underline;
    margin: 18px 0;
}


/* ---------------- CONTENT ---------------- */
.content {
    font-size: 12pt;
    line-height: 1.5;
    text-align: justify;
    margin: 12px 0;
}

.plant-info {
    margin: 10px 0 12px;
}

.plant-row {
    display: table;
    width: 100%;
    margin-bottom: 6px;
}

.plant-label {
    display: table-cell;
    width: 140px;
}

.plant-value {
    display: table-cell;
}

/* ---------------- QUANTITIES ---------------- */
.quantities-title {
    font-size: 13pt;
    font-weight: bold;
    margin: 15px 0 10px 0;
}

.items-table {
    width: 100%;
    border-collapse: collapse;
    margin: 6px 0;
}

.items-table td {
    font-size: 12pt;
    font-weight: bold;
    padding: 4px 0;
    vertical-align: top;
}

/* Number column */
.items-table .num {
    width: 30px;
    text-align: left;
}

/* Item name column */
.items-table .name {
    padding-left: 6px;
    padding-right: 6px;
}

/* Quantity column */
.items-table .qty {
    width: 140px;        /* adjust to align exactly like screenshot */
    text-align: left;
}

/* ---------------- FOOTER TEXT BEFORE SIGNATURE ---------------- */
.footer-text {
    margin: 10px 0 15px 0;
    line-height: 1.45;
    text-align: justify;
}


/* ---------------- SIGNATURE ---------------- */
.signature-section {
    margin-top: 10px;
}

.company-name {
    margin-bottom: 8px;
}

.signature-image {
    height: 55px;
    margin: 5px 0;
}

.authorized-signatory {
    margin-top: 50px;   /* PERFECT spacing like sample */
    font-size: 12pt;
}


/* ---------------- FIXED FOOTER ---------------- */
.page-footer {
    position: fixed;
    bottom: 12mm;                /* EXACT bottom distance */
    left: 0;
    right: 0;
    text-align: center;
    font-size: 9pt;
}

.company-footer {
    font-size: 12pt;
    font-weight: bold;
    margin-bottom: 2px;
}

.company-subtitle {
    font-size: 9pt;
    margin-bottom: 3px;
}

.company-details div {
    margin: 1px 0;
}

/* Add this new CSS for the green line */
.green-line {
    position: fixed;
    bottom: 2mm;
    left: -30mm;      /* Negative left margin to extend beyond page margin */
    right: -30mm;     /* Negative right margin to extend beyond page margin */
    width: calc(100% + 60mm);  /* Full page width including margins */
    height: 4mm;
    background-color: #7CB342;
    margin: 0;
    padding: 0;
}

</style>
</head>

<body>

<!-- HEADER LOGO -->
<div class="logo">
    <img src="/public/uploads/1700637387admin_leftlogo.png">
</div>

<!-- DATE -->
<div class="date-right">
    Date: <?= date('d-m-Y', strtotime($issue_date ?? date('Y-m-d'))) ?>
</div>

<!-- REF NUMBER -->
<div class="ref-number">
    Ref: <?= $certificate_number ?? '' ?>
</div>

<!-- TITLE -->
<div class="title">TO WHOM-SO-EVER IT MAY CONCERN</div>

<!-- MAIN DESCRIPTION -->
<div class="content">
This certificate confirms that Karma Ecotech Limited (Ecoex) collected scrap materials 
from <strong><?= esc($company_name) ?> on <?= date('d-m-Y', strtotime($collection_date)) ?></strong> at the following location:
</div>

<!-- PLANT INFO -->
<div class="plant-info">
    <div class="plant-row">
        <div class="plant-label">Plant Name</div>
        <div class="plant-value">: <?= esc($plant_name) ?></div>
    </div>
    <div class="plant-row">
        <div class="plant-label">Plant Address</div>
        <div class="plant-value">: <?= esc($plant_address) ?></div>
    </div>
</div>

<!-- QUANTITIES TITLE -->
<div class="quantities-title">Quantities Collected (in Kgs):</div>

<!-- ITEM LIST -->
<table class="items-table">
<?php foreach ($items as $index => $item): ?>
<tr>
    <td class="num"><?= $index + 1 ?>.</td>
    <td class="name"><?= esc($item['item_description']) ?></td>
    <td class="qty">: <?= number_format($item['quantity']) ?> <?= esc($item['unit']) ?>.</td>
</tr>
<?php endforeach; ?>
</table>

<!-- FOOTER TEXT -->
<div class="footer-text">
Taken scrap materials including trademarked materials from <strong><?= esc($company_name) ?></strong>
plant are being picked up by <strong><?= esc($vendors[0]['company_name']) ?></strong> on behalf of Karma Ecotech Limited and sent to 
<strong><?= esc($vendors[0]['company_name']) ?></strong> (Recycler Listed in <?= esc($plant_state) ?> Pollution Control Board) 
for recycling purposes. Karma Ecotech Limited (Ecoex) will channelize these materials according to industry standards.
</div>

<!-- SIGNATURE SECTION -->
<div class="signature-section">
    <p>Sincerely,</p>
    <p class="company-name">For Karma Ecotech Limited</p>

    <?php if (!empty($signature_path)): ?>
        <img src="<?= WRITEPATH . 'uploads/signatures/' . $signature_path ?>" class="signature-image">
    <?php endif; ?>

    <p class="authorized-signatory">Authorized Signatory</p>
</div>

<!-- FIXED FOOTER -->
<div class="page-footer">
    <div class="company-footer">Karma Ecotech Limited</div>
    <div class="company-subtitle">(Formerly known as Karma Ecotech Private Limited)</div>
    <div class="company-details">
        <div>5C, 5th Floor, Hansalaya Building, Barakhamba Road, New Delhi - 110001</div>
        <div>info@ecoex.market | +91 84477 67568 | www.ecoex.market</div>
        <div>CIN No. U74999DL2018PLC339735</div>
    </div>
</div>
<div class="green-line"></div>
</body>
</html>
