<p>Hello,</p>
<p>Your enquiry <strong><?= esc($enquiry->enquiry_no) ?></strong> is due in <strong><?= esc($days_until) ?></strong> day(s), on <strong><?= date('F j, Y', strtotime($enquiry->tentative_collection_date)) ?></strong>.</p>
<p>Thank you!</p>
