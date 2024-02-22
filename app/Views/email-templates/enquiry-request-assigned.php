<?php
use App\Models\CommonModel;
$this->common_model         = new CommonModel;
$generalSetting             = $this->common_model->find_data('general_settings', 'row');
$getEnquiry                 = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $enq_id]);
$company                    = $this->common_model->find_data('ecoex_companies', 'row', ['id' => $company_id]);
$plant                      = $this->common_model->find_data('ecomm_users', 'row', ['id' => $plant_id]);
$getVendor                  = $this->common_model->find_data('ecomm_users', 'row', ['id' => $vendor_id]);
?>
<!doctype html>
<html lang="en">
  <head>
    <title><?=$generalSetting->site_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body style="padding: 0; margin: 0; box-sizing: border-box;">
    <section style="padding: 80px 0; height: 80vh; margin: 0 15px;">
        <div style="max-width: 600px; background: #ffffff; margin: 0 auto; border-radius: 15px; padding: 20px 15px; box-shadow: 0 0 30px -5px #ccc;">
          <div style="text-align: center;">
              <img src="<?=getenv('app.uploadsURL').$generalSetting->site_logo?>" alt="" style=" width: 100%; max-width: 250px;">
          </div>
          <div>
            <h3 style="text-align: center; font-size: 25px; color: #5c5b5b; font-family: sans-serif;">Hi, Welcome <?=(($plant)?$getVendor->company_name:'')?>!</h3>
            <h4 style="text-align: center; font-size: 15px; color: green; font-family: sans-serif;">Enquiry Request Assigned</h4>
            <h5 style="text-align: center; font-size: 15px; color: green; font-family: sans-serif;">Please Check App For This</h5>
            <table style="width: 100%;  border-spacing: 2px;">
              <tbody>
                <tr>
                  <th style="background: #3e9854; color: #fff; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Company Name</th>
                  <td style="padding: 10px; background: #89b33c; text-align: left; color: #fff;font-family: sans-serif;font-size: 15px; font-weight: 600;"><?=(($company)?$company->company_name:'')?></td>
                </tr>
                <tr>
                  <th style="background: #3e9854; color: #fff; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Plant Name</th>
                  <td style="padding: 10px; background: #89b33c; text-align: left; color: #fff;font-family: sans-serif;font-size: 15px; font-weight: 600;"><?=(($plant)?$plant->plant_name:'')?></td>
                </tr>
                <tr>
                  <th style="background: #3e9854; color: #fff; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Enquiry No.</th>
                  <td style="padding: 10px; background: #89b33c; text-align: left; color: #fff;font-family: sans-serif;font-size: 15px; font-weight: 600;"><?=(($getEnquiry)?$getEnquiry->enquiry_no:'')?></td>
                </tr>
                <tr>
                  <th style="background: #3e9854; color: #fff; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Sub Enquiry No.</th>
                  <td style="padding: 10px; background: #89b33c; text-align: left; color: #fff;font-family: sans-serif;font-size: 15px; font-weight: 600;"><?=$sub_enquiry_no?></td>
                </tr>
                <tr>
                  <td colspan="2" style="padding: 10px; background: #89b33c; text-align: left; color: #fff;font-family: sans-serif;font-size: 15px; font-weight: 600; text-align:center">ITEMS</td>
                </tr>
                <tr>
                  <td colspan="2" style="padding: 10px; background: #89b33c; text-align: left; color: #fff;font-family: sans-serif;font-size: 15px; font-weight: 600; text-align:center">
                    <table cellpadding="5" cellspacing="3" style="width: 100%;  border-spacing: 2px; border-collapse:collapse;">
                      <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>HSN</th>
                        <th>Qty</th>
                        <th>Unit</th>
                      </tr>
                      <?php
                      $enqItems = $this->common_model->find_data('ecomm_sub_enquires', 'array', ['enq_id' => $enq_id, 'vendor_id' => $vendor_id]);
                      if($enqItems){ $sl=1; foreach($enqItems as $enqItem){
                        $getEnquiryProduct                 = $this->common_model->find_data('ecomm_enquiry_products', 'row', ['enq_id' => $enq_id, 'product_id' => $enqItem->item_id]);
                        $getItem = $this->common_model->find_data('ecomm_company_items', 'row', ['id' => $enqItem->item_id]);
                        $getUnit = $this->common_model->find_data('ecomm_units', 'row', ['id' => (($getItem)?$getItem->unit:$enqItem->unit)], 'name');
                      ?>
                        <tr>
                          <td><?=$sl++?></td>
                          <td><?=(($getItem)?$getItem->item_name_ecoex:'')?></td>
                          <td><?=(($getItem)?$getItem->hsn:'')?></td>
                          <td><?=(($getEnquiryProduct)?$getEnquiryProduct->qty:'')?></td>
                          <td><?=(($getUnit)?$getUnit->name:'')?></td>
                        </tr>
                      <?php } }?>
                    </table>
                </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div style="border-top: 2px solid #ccc; margin-top: 50px; text-align: center; font-family: sans-serif;">
          <div style="text-align: center; margin: 15px 0 10px;">All right reserved: © <?=date('Y')?> <?=$generalSetting->site_name?></div>
        </div>
      </div>
    </section>
  </body>
</html>