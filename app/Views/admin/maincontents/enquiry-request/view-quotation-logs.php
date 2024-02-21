<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row">
        <div class="col-xl-12">
            <?php if(session('success_message')){?>
            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                <?=session('success_message')?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
            <?php if(session('error_message')){?>
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                <?=session('error_message')?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
        </div>
        <div class="col-lg-12 mb-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Items</th>
                        <?php
                        $quotations = $common_model->find_data('ecomm_enquiry_vendor_quotation_logs', 'array', ['enq_id' => $enq_id, 'vendor_id' => $vendor_id, 'item_id' => $enquiryItems[0]->product_id], 'quote_price,unit_name,created_at');
                        if($quotations) { $k=1; foreach($quotations as $quotation){
                        ?>
                        <th>Quotation <?=$k++?><br><small><?=date_format(date_create($quotation->created_at), "M d, Y h:i A")?></small></th>
                        <?php } }?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($enquiryItems) { $sl=1; foreach($enquiryItems as $enquiryItem){
                        $getProduct = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryItem->product_id], 'id,item_name_ecoex');
                    ?>
                        <tr>
                            <td><?=$sl++?></td>
                            <td><?=(($getProduct)?$getProduct->item_name_ecoex:'')?></td>
                            <?php
                            $quotations = $common_model->find_data('ecomm_enquiry_vendor_quotation_logs', 'array', ['enq_id' => $enq_id, 'vendor_id' => $vendor_id, 'item_id' => $enquiryItem->product_id], 'quote_price,unit_name');
                            if($quotations) { $k=1; foreach($quotations as $quotation){
                            ?>
                                <td><?=$quotation->quote_price?> / <?=$quotation->unit_name?></td>
                            <?php } }?>
                        </tr>
                    <?php } }?>
                </tbody>
            </table>
        </div>
    </div>
</section>