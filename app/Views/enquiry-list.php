<?php
use App\Models\CommonModel;
$this->common_model         = new CommonModel;
// $getPlant                   = $this->common_model->find_data('ecomm_users', 'row', ['id' => $enquiry->plant_id], 'plant_name,full_address');
// $getEnquiryItems            = $this->common_model->find_data('ecomm_enquiry_products', 'array', ['enq_id' => $enquiry->id]);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquiry List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Favicons -->
    <link href="<?=getenv('app.uploadsURL').$general_settings->site_favicon?>" rel="icon">
    <link href="<?=getenv('app.uploadsURL'.$general_settings->site_favicon)?>" rel="apple-touch-icon">
    <link rel="stylesheet" href="<?=getenv('app.adminAssetsURL')?>lightbox/lightbox.min.css">
    
    <style>
    .tablelook {
        padding-top: 10px;
        padding-bottom: 10px;
        border: 1px solid #dddd;
    }
    ul.d-flex.whatimgs {
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
    }
    .whatimgs li {
        margin: 5px;
    }
    .whatimgs img.example-image {
        max-width: 60px;
        border: 1px solid #999;
        height: 60px;
        width: 100%;
    }
    </style>
</head>
<body>
<div class="container-fluid mt-4">

    <h3 class="text-center">
        <img src="<?=getenv('app.uploadsURL').$general_settings->site_logo?>" alt="<?=$general_settings->site_name?>">
        <p class="mt-3">Enquiry List</p>
    </h3>
    <div class=" justify-content-center">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Enquiry No.</th>
                            <th>Company</th>
                            <th>Plant</th>
                            <th>Sub Enquiry Count</th>
                            <th>Sub Enquiries</th>
                            <th>Item Count</th>
                            <th>Items</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl=1;
                        if($enqs){ foreach($enqs as $enq){
                            if($enq->enquiry_products_count <= 0){
                        ?>
                                <tr>
                                    <td><?= $sl++ ?></td>
                                    <td><?= $enq->enquiry_no ?></td>
                                    <td><?= $enq->company_name ?></td>
                                    <td><?= $enq->plant_name ?></td>
                                    <td><?= $enq->sub_enquiry_count ?></td>
                                    <td><?= $enq->sub_enquiry_nos ?></td>
                                    <td <?= (($enq->enquiry_products_count <= 0)?'style="background-color:red;"':'') ?>><?= $enq->enquiry_products_count ?></td>
                                    <td><?= $enq->enquiry_product_name_list ?></td>
                                    <td><?= $enq->enquiry_status ?></td>
                                </tr>
                            <?php }?>
                        <?php } }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>  
    
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
