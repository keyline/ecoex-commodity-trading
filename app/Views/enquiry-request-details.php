<?php
use App\Models\CommonModel;
$this->common_model         = new CommonModel;
$getPlant                   = $this->common_model->find_data('ecomm_users', 'row', ['id' => $enquiry->plant_id], 'plant_name,full_address');
$getEnquiryItems            = $this->common_model->find_data('ecomm_enquiry_products', 'array', ['enq_id' => $enquiry->id]);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquiry Request Deatils</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
<div class="container mt-4">
    <h3 class="text-center">Enquiry Request Details</h3>
    <div class=" justify-content-center d-flex">
        <div class="row col-md-8 ">
            <div class="col-md-4 tablelook">
                Request no
            </div>
            <div class="col-md-8 tablelook">
                <strong><?=$enquiry->enquiry_no?></strong>
            </div>

            <div class="col-md-4 tablelook">
                Tentative Collection Date
            </div>
            <div class="col-md-8 tablelook">
                <strong><?=date_format(date_create($enquiry->tentative_collection_date), "M d, Y")?></strong>
            </div>

            <div class="col-md-4 tablelook">
                GPS image
            </div>
            <div class="col-md-8 tablelook">
                <ul class="d-flex whatimgs">
                    <li>
                        <a class="example-image-link" href="<?=(($enquiry->gps_tracking_image != '')?getenv('app.uploadsURL').'enquiry/'.$enquiry->gps_tracking_image:getenv('app.NO_IMG'))?>" data-lightbox="example-set1" >
                            <img class="example-image" src="<?=(($enquiry->gps_tracking_image != '')?getenv('app.uploadsURL').'enquiry/'.$enquiry->gps_tracking_image:getenv('app.NO_IMG'))?>" alt="<?=$enquiry->enquiry_no?>"/>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 tablelook">
                Plant location
            </div>
            <div class="col-md-8 tablelook">
                <strong><?=(($getPlant)?$getPlant->plant_name:'')?></strong> <br>
                <strong><?=(($getPlant)?$getPlant->full_address:'')?></strong> <br>
                Latitude : <?=$enquiry->latitude?><br>
                Longitude : <?=$enquiry->longitude?>
            </div>

            <?php
            if($getEnquiryItems){ $sl=1; foreach($getEnquiryItems as $getEnquiryItem){
                $getItem            = $this->common_model->find_data('ecomm_company_items', 'row', ['id' => $getEnquiryItem->product_id], 'alias_name');
                $new_product_image  = json_decode($getEnquiryItem->new_product_image);
            ?>
                <div class="col-md-4 tablelook">
                    Item <?=$sl?>
                </div>
                <div class="col-md-8 tablelook">
                    <strong><?=(($getItem)?$getItem->alias_name:'')?></strong>
                </div>
                
                <div class="col-md-4 tablelook">
                    Item <?=$sl?> images
                </div>
                <div class="col-md-8 tablelook">
                    <ul class="d-flex whatimgs">
                        <?php if(!empty($new_product_image)){ for($i=0;$i<count($new_product_image);$i++){?>
                            <li>
                                <a class="example-image-link" href="<?=(($new_product_image[$i] != '')?getenv('app.uploadsURL').'enquiry/'.$new_product_image[$i]:getenv('app.NO_IMG'))?>" data-lightbox="example-set" data-title="<?=(($getItem)?$getItem->alias_name:'')?>">
                                    <img class="example-image" src="<?=(($new_product_image[$i] != '')?getenv('app.uploadsURL').'enquiry/'.$new_product_image[$i]:getenv('app.NO_IMG'))?>" alt="<?=(($getItem)?$getItem->alias_name:'')?>"/>
                                </a>
                            </li>
                        <?php } }?>
                        <!-- <li><a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-4.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-4.jpg" alt="" /></a></li>
                        <li><a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-5.jpg" data-lightbox="example-set" data-title="The next image in the set is preloaded as you're viewing."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-5.jpg" alt="" /></a></li>
                        <li><a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-6.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-6.jpg" alt="" /></a></li> -->
                    </ul>
                </div>
            <?php $sl++; } }?>
            <!-- <div class="col-md-4 tablelook">
                Auction start date and time
            </div>
            <div class="col-md-8 tablelook">
                <strong>Dec 20-12-23</strong>
            </div> -->
            <!-- <div class="col-md-4 tablelook">
                Auction end date and time
            </div>
            <div class="col-md-8 tablelook">
                <strong>Dec 26-12-23</strong>
            </div> -->
        </div>
    </div>
</div>  
    
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    
<script src="<?=getenv('app.adminAssetsURL')?>lightbox/lightbox.js"></script>
<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
</body>
</html>