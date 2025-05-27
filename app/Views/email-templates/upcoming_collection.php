<style type="text/css">
  /* Reset & base typography */
  body, table, td, p {
    margin: 0; padding: 0;
    font-family: Arial, sans-serif;
    color: #333333;
    line-height: 1.4;
  }

  /* Outer container with shadow & rounded corners */
  .email-container {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    background-color: #ffffff;
    border: 2px solid #0073e6;           /* brand accent */ 
    border-radius: 8px;                  /* soft corners */ 
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);/* subtle lift */ 
  }

  /* Header & Footer */
  .header, .footer {
    background-color: #f0f4f8;           /* light complementary */ 
    padding: 15px;
    text-align: center;
    font-size: 14px;
    color: #555555;
  }

  /* Body padding */
  .content {
    padding: 20px;
    font-size: 16px;
  }

  /* Detail table with zebra stripes */
  .details-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
  }
  .details-table th,
  .details-table td {
    border: 1px solid #dddddd;
    padding: 10px;
    font-size: 14px;
    text-align: left;
  }
  .details-table th {
    background-color: #0073e6;          /* header accent */ 
    color: #ffffff;
  }
  .details-table tr:nth-child(even) td {
    background-color: #f7f9fb;          /* zebra stripe */ 
  }

  /* Button */
  .button {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 24px;
    background-color: #0073e6;
    color: #ffffff !important;
    text-decoration: none;
    border-radius: 4px;
    font-size: 15px;
  }

  /* Responsive tweaks */
  @media only screen and (max-width: 480px) {
    .email-container { width: 100% !important; }
    .content, .details-table th, .details-table td {
      padding: 8px !important;
      font-size: 13px !important;
    }
    .button { width: 100% !important; box-sizing: border-box; text-align: center; }
  }
</style>



<body>
  <table class="email-container" cellspacing="0" cellpadding="0" role="presentation">
    <tr>
      <td class="content">
        <p>Hello, Mr Barua,</p>
        <p>Below are the upcoming enquiries:</p>

        <?php foreach ($data as $enquiry): ?>
          <p style="margin-top: 30px;">
            <strong>Enquiry No:</strong> <?= esc($enquiry['enquiry_no']) ?><br>
            <strong>Due In:</strong> <?= esc($enquiry['days_until']) ?> day(s)<br>
            <strong>Collection Date:</strong> <?= date('F j, Y', strtotime($enquiry['tentative_collection_date'])) ?><br>
            <strong>Plant:</strong> <?= esc($enquiry['plant_name']) ?><br>
            <!-- <strong>Company:</strong> <?// esc($enquiry['company_name']) ?> -->
          </p>

          <?php $subs = json_decode($enquiry['sub_enquiries']); ?>
          <?php if (!empty($subs)): ?>
            <table class="details-table" role="presentation">
              <thead>
                <tr>
                  <th>Vendor</th>
                  <th>Company</th>
                  <th>Item</th>
                  <th>Qty</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($subs as $sub): ?>
                  <tr>
                    <td><?= esc($sub->vendor_name) ?></td>
                    <td><?= esc($sub->vendor_company) ?></td>
                    <td><?= esc($sub->item_name) ?></td>
                    <td><?= esc(number_format($sub->weighted_qty, 2)) ?> <?= esc($sub->weighted_unit) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
          <hr>
        <?php endforeach; ?>

        <p style="margin-top: 30px;">Thank you,<br><strong>Ecoex team</strong></p>
      </td>
    </tr>
  </table>
</body>

