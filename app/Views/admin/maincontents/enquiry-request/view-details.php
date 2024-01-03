<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

<style type="text/css">
    .choices__list--multiple .choices__item {
        background-color: #48974e;
        border: 1px solid #48974e;
    }
</style>

<!-- for inquiry tracking -->
  <style type="text/css">
    .progress-bar-wrapper ul.progress-bar {
        width: 100%;
        margin: 0;
        padding: 0;
        font-size: 0;
        list-style: none;
        background-color: #FFF;
        display: inline-block !important;
    }

    .progress-bar-wrapper li.section {
        display: inline-block !important;
        padding-top: 45px;
        font-size: 13px;
        font-weight: bold;
        line-height: 16px;
        color: gray;
        vertical-align: top;
        position: relative;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .progress-bar-wrapper li.section:before {
        content: 'x';
        position: absolute;
        top: 3px;
        left: calc(50% - 15px);
        z-index: 1;
        width: 30px;
        height: 30px;
        color: white;
        border: 2px solid white;
        border-radius: 17px;
        line-height: 26px;
        background: gray;
    }
    .progress-bar-wrapper .status-bar {
        height: 2px;
        background: gray;
        position: relative;
        top: 20px;
        margin: 0 auto;
    }
    .progress-bar-wrapper .current-status {
        height: 3px;
        width: 0;
        border-radius: 1px;
        background: #26a541;
    }

    @keyframes changeBackground {
        from {background: gray}
        to {background: #26a541}
    }

    .progress-bar-wrapper li.section.visited:before {
        content: '\2714';
        animation: changeBackground 3s linear;
        animation-fill-mode: forwards;
    }

    .progress-bar-wrapper li.section.visited.current:before {
        box-shadow: 0 0 0 2px #26a541;
    }

    .home-successstories .owl-nav {
        position: absolute;
        top: 50%;
        transform: translate(0,-50%);
        width: 100%;
        display: block;
    }
    .home-successstories .owl-nav button {
        width: 50px;
        height: 50px;
        border: 2px solid #fff !important;
        color: #fff !important;
        font-size: 22px !important;
        border-radius: 50px;
    }
    .home-successstories .owl-nav button.owl-next {
        right: 0;
        position: absolute;
    }

    .sucess_boximg {
        height: 500px;
        object-fit: cover;
        overflow: hidden;
    }
    .sucess_boximg img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
  </style>
<!-- for inquiry tracking -->
<style type="text/css">
  th:first-child, td:first-child
  {
    position:sticky;
    left:0px;
    background-color:grey;
    color: #FFF;
  }
</style>
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
            <div class="card">
                <div class="card-body">
                    <!-- inquiry flow tracking -->
                        <?php
                        if($row->status == 0){
                            $enquiryStatus = 'Pending';
                        } elseif($row->status == 1){
                            $enquiryStatus = 'Sent/Submitted';
                        } elseif($row->status == 2){
                            $enquiryStatus = 'Accepted/Rejected';
                        } elseif($row->status == 3){
                            $enquiryStatus = 'Pickup';
                        } elseif($row->status == 4){
                            $enquiryStatus = 'Vehicle Placed';
                        } elseif($row->status == 5){
                            $enquiryStatus = 'Vehicle Ready Despatch';
                        } elseif($row->status == 6){
                            $enquiryStatus = 'Material Lifted';
                        } elseif($row->status == 7){
                            $enquiryStatus = 'Invoiced';
                        } elseif($row->status == 8){
                            $enquiryStatus = 'Completed';
                        } elseif($row->status == 9){
                            $enquiryStatus = 'Rejected';
                        }
                        ?>
                        <div class="progress-bar-wrapper" style="margin-bottom: 10px;"></div>
                    <!-- inquiry flow tracking -->
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12 mb-3">
                            <?php if($row->status == 0){?>
                                <a href="<?=base_url('admin/' . $controller_route . '/accept-request/'.encoded($row->$primary_key))?>" class="btn btn-success btn-sm" title="Accept <?=$title?>" onclick="return confirm('Do You Want To Accept This <?=$title?>');"><i class="fa fa-check"></i> Click To Accept</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Reject <?=$title?>" onclick="getRejectModal(<?=$row->$primary_key?>);"><i class="fa fa-times"></i> Click To Reject</a>
                            <?php } else {?>
                                <?php if($row->status == 1){?>
                                    <h6 class="badge bg-success"><i class="fa fa-check-circle"></i> ACCEPTED</h6>
                                    <p><?=(($row->accepted_date != '')?date_format(date_create($row->accepted_date), "M d, Y h:i A"):'')?></p>

                                    <!-- share to vendors panel -->
                                        <p>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#shareModal"><i class="fa fa-share-alt"></i> Quotation Invitation To Vendors</button>
                                            <a href="" class="btn btn-info btn-sm" data-action="share/whatsapp/share"><i class="fa fa-list-alt"></i> Shared Quotation Invitation To Vendors</a>
                                        </p>
                                    <!-- share to vendors panel -->
                                    <!-- share to vendors via whatsapp -->
                                        <p>
                                            <?php
                                            $sharedLink = base_url('enquiry-request/'.encoded($row->id));
                                            ?>
                                            <a href="whatsapp://send?text=<?=$sharedLink?>" class="btn btn-primary btn-sm" data-action="share/whatsapp/share"><i class="fa fa-share-alt"></i> Share Details To Vendors via Whatsapp</a>
                                            <a href="" class="btn btn-primary btn-sm" onclick="copyToClipboard()"><i class="fa fa-copy"></i> Copy Whatsapp Link For Share</a>
                                            <span id="whatsapp_link" style="display: none;"><?=$sharedLink?></span>
                                            <input type="hidden" placeholder="Paste here" />
                                        </p>
                                    <!-- share to vendors via whatsapp -->
                                <?php } elseif($row->status == 9){?>
                                    <h6 class="badge bg-danger"><i class="fa fa-times-circle"></i> REJECTED</h6>
                                    <p><?=(($row->accepted_date != '')?date_format(date_create($row->accepted_date), "M d, Y h:i A"):'')?></p>
                                <?php }?>
                                
                            <?php }?>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Company Name</h5>
                            <h6>
                                <?php
                                $getCompany = $common_model->find_data('ecoex_companies', 'row', ['id' => $row->company_id], 'company_name');
                                echo (($getCompany)?$getCompany->company_name:'');
                                ?>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Plant Name</h5>
                            <h6>
                                <?php
                                $getPlant = $common_model->find_data('ecomm_users', 'row', ['id' => $row->plant_id], 'company_name');
                                echo (($getPlant)?$getPlant->company_name:'');
                                ?>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">GPS Tracking Image</h5>
                            <h6>
                                <?php if($row->gps_tracking_image != ''){?>
                                    <a href="<?=getenv('app.uploadsURL').'enquiry/'.$row->gps_tracking_image?>" target="_blank"><img src="<?=getenv('app.uploadsURL').'enquiry/'.$row->gps_tracking_image?>" alt="<?=$row->enquiry_no?>" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;"></a>
                                <?php } else {?>
                                    <img src="<?=getenv('app.NO_IMAGE')?>" alt="<?=$row->enquiry_no?>" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;">
                                <?php }?>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Tentative Collection Date</h5>
                            <h6><?=date_format(date_create($row->tentative_collection_date), "M d, Y")?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Latitude</h5>
                            <h6><?=$row->latitude?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Device Brand</h5>
                            <h6><?=$row->device_brand?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Longitude</h5>
                            <h6><?=$row->longitude?></h6>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success">Device Model</h5>
                            <h6><?=$row->device_model?></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item<br>Category</th>
                                            <th>Item Name<br>(Ecoex)</th>
                                            <th>Alias<br>(App)</th>
                                            <th>Billing<br>Name</th>
                                            <th>HSN</th>
                                            <th>GST</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>Remarks</th>
                                            <th>Images</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($enquiryProducts){ $slNo=1; foreach($enquiryProducts as $enquiryProduct){
                                            if($enquiryProduct->new_product){
                                                $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryProduct->product_id], 'id,item_category,item_name_ecoex,alias_name,billing_name,item_images,hsn,gst,rate,unit');
                                                if($getItem){
                                                    $productName    = (($getItem)?$getItem->item_name_ecoex:'');
                                                    $productHSNCode = (($getItem)?$getItem->hsn:'');
                                                } else {
                                                    $productName    = $enquiryProduct->new_product_name;
                                                    $productHSNCode = $enquiryProduct->new_hsn;
                                                }
                                                // $productImage   = (($enquiryProduct->new_product_image != '')?getenv('app.uploadsURL').'enquiry/'.$enquiryProduct->new_product_image:getenv('app.NO_IMG'));
                                            } else {
                                                $getItem = $common_model->find_data('ecomm_company_items', 'row', ['id' => $enquiryProduct->product_id], 'id,item_category,item_name_ecoex,alias_name,billing_name,item_images,hsn,gst,rate,unit');
                                                $productName    = (($getItem)?$getItem->item_name_ecoex:'');
                                                $productHSNCode = (($getItem)?$getItem->hsn:'');
                                                // $productImage   = (($getItem)?(($getItem->product_image != '')?getenv('app.uploadsURL').'enquiry/'.$getItem->product_image:$getItem->product_image):getenv('app.NO_IMG'));
                                            }
                                            if($enquiryProduct->status){
                                                $bgColor = '#0080001a';
                                            } else {
                                                $bgColor = '#ff00001c';
                                            }
                                        ?>
                                            <tr style="background-color: <?=$bgColor?>;">
                                                <th><?=$slNo++?></th>
                                                <td>
                                                    <?php
                                                    if($getItem){
                                                        $itemCategory               = $common_model->find_data('ecomm_product_categories', 'row', ['id' => $getItem->item_category], 'name');
                                                        echo (($itemCategory)?$itemCategory->name:'');
                                                    }
                                                    ?>
                                                </td>
                                                <td><?=$productName?></td>
                                                <td><?=(($getItem)?$getItem->alias_name:'')?></td>
                                                <td><?=(($getItem)?$getItem->billing_name:'')?></td>
                                                <td><?=$productHSNCode?></td>
                                                <td><?=(($getItem)?$getItem->gst:'')?></td>
                                                <td><?=(($getItem)?$getItem->rate:'')?></td>
                                                <td><?=$enquiryProduct->qty?></td>
                                                <td>
                                                    <?php
                                                    $unit               = $common_model->find_data('ecomm_units', 'row', ['id' => $enquiryProduct->unit], 'name');
                                                    echo (($unit)?$unit->name:'');
                                                    ?>
                                                </td>
                                                <td><?=$enquiryProduct->remarks?></td>
                                                <td>
                                                    <!-- <a href="" target="_blank"><img src="" class="img-thumbnail" style="width:100px; height: 100px;"></a> -->
                                                    <!-- <p onclick="getImageModal(<?=$enquiryProduct->enq_id?>);"><i class="fas fa-image"></i></p> -->
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#enquiryImageModal<?=$enquiryProduct->id?>"><i class="fas fa-image"></i></button>
                                                </td>
                                                <td>
                                                    <?php if($enquiryProduct->status){?>
                                                        <span class="badge bg-success">APPROVED</span>
                                                    <?php } else {?>
                                                        <span class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered<?=$enquiryProduct->id?>" data-backdrop="static" data-keyboard="false">CLICK TO APPROVED</span>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php } }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- share to vendor modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Share Details To Vendors : <?=$row->enquiry_no?></strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="mode" value="share_vendor">
                        <input type="hidden" name="enq_id" value="<?=$row->id?>">
                        <input type="hidden" name="company_id" value="<?=$row->company_id?>">
                        <input type="hidden" name="plant_id" value="<?=$row->plant_id?>">
                        <div class="form-group">
                            <label for="choices-multiple-remove-button">Vendors</label>
                            <select name="vendors[]" id="choices-multiple-remove-button" multiple>
                                <?php if($avlVendors){ foreach($avlVendors as $avlvendor){?>
                                    <?php
                                    $checkVendorShare = $common_model->find_data('ecomm_enquiry_vendor_shares', 'count', ['enq_id' => $row->id, 'vendor_id' => $avlvendor->id]);
                                    if($checkVendorShare <= 0){
                                    ?>
                                        <option value="<?=$avlvendor->id?>"><?=$avlvendor->company_name?></option>
                                    <?php }?>
                                <?php } }?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Share</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!-- share to vendor modal -->
<!-- item approve modal-->
    <?php if($enquiryPendingProducts){ $slNo=1; foreach($enquiryPendingProducts as $enquiryPendingProduct){?>
    <?php
    $getItem = $common_model->find_data('ecomm_company_items', 'row', ['enq_product_id' => $enquiryPendingProduct->id]);
    ?>
    <div class="modal fade" id="verticalycentered<?=$enquiryPendingProduct->id?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="<?=base_url('admin/companies/approve-item')?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enquiry Item Approve</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?=(($getItem)?encoded($getItem->id):'')?>">
                        <input type="hidden" name="redirect_link" value="<?=encoded(current_url())?>">

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <select class="form-control" name="item_category[]" required>
                                    <option value="" selected>Select Category</option>
                                    <?php if($cats){ foreach($cats as $cat){?>
                                    <option value="<?=$cat->category_id?>"><?=$cat->category_alias?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        
                            <div class="col-md-6 mb-3">
                                <input type="text" name="item_name_ecoex[]" class="form-control" placeholder="Item Ecoex" value="<?=$getItem->item_name_ecoex?>" required>
                            </div>
                        
                            <div class="col-md-6 mb-3">
                                <input type="text" name="alias_name[]" class="form-control" placeholder="Alias Name" value="<?=$getItem->alias_name?>" required>
                            </div>
                        
                            <div class="col-md-6 mb-3">
                                <input type="text" name="billing_name[]" class="form-control" placeholder="Billing Name" value="<?=$getItem->billing_name?>" required>
                            </div>
                        
                            <div class="col-md-6 mb-3">
                                <input type="text" name="hsn[]" class="form-control" placeholder="HSN" value="<?=$getItem->hsn?>" required>
                            </div>
                        
                            <div class="col-md-6 mb-3">
                                <select class="form-control" name="gst[]" required>
                                    <option value="" selected>Select GST</option>
                                    <option value="0">0 %</option>
                                    <option value="5">5 %</option>
                                    <option value="12">12 %</option>
                                    <option value="18">18 %</option>
                                    <option value="28">28 %</option>
                                </select>
                            </div>
                        
                            <div class="col-md-6 mb-3">
                                <input type="text" name="rate[]" class="form-control" placeholder="Rate" value="<?=$getItem->rate?>" required>
                            </div>
                        
                            <div class="col-md-6 mb-3">
                                <select class="form-control" name="unit[]" required>
                                    <option value="" selected>Select Unit</option>
                                    <?php if($units){ foreach($units as $unit){?>
                                    <option value="<?=$unit->id?>" <?=(($unit->id == $enquiryPendingProduct->unit)?'selected':'')?>><?=$unit->name?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">APPROVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php } }?>
<!-- item approve modal-->
<!-- reject request modal -->
    <div class="modal fade" id="rejectRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header" id="rejectRequestTitle">
              
            </div>
            <div class="modal-body" id="rejectRequestBody">

            </div>
          </div>
        </div>
    </div>
<!-- reject request modal -->
<!-- image modal -->
    <?php if($enquiryProducts){ $slNo=1; foreach($enquiryProducts as $enquiryProduct){?>
        <?php
        $enquiryImages      = [];
        $new_product_images = json_decode($enquiryProduct->new_product_image);
        if(!empty($new_product_images)){
            for($i=0;$i<count($new_product_images);$i++){
                $enquiryImages[]      = getenv('app.uploadsURL').'enquiry/'.$new_product_images[$i];
            }
        } 
        ?>
        <div class="modal fade" id="enquiryImageModal<?=$enquiryProduct->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header" id="enquiryImageTitle">
                  Enquiry Item Images : <?=$row->enquiry_no?>
                </div>
                <div class="modal-body" id="enquiryImageBody">
                    <div id="" class="owl-carousel owl-theme owl-loaded home-successstories owl-drag">
                        <?php if(!empty($enquiryImages)){ for($enqImg=0;$enqImg<count($enquiryImages);$enqImg++){?>
                            <div class="item">
                                <div class="sucess_boximg">
                                    <img src="<?=$enquiryImages[$enqImg]?>" class="img-fluid" alt="image">
                                </div>
                            </div>
                        <?php } }?>
                    </div>
                </div>
              </div>
            </div>
        </div>
    <?php } }?>
<!-- image modal -->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- progress bar -->
<script src="<?=getenv('app.adminAssetsURL');?>assets/js/progress-bar.js"></script>
<!-- progress bar -->

<?php if($row->status != 9){?>
    <script type="text/javascript">
      //we can set animation delay as following in ms (default 1000)
      ProgressBar.singleStepAnimation = 700;
      ProgressBar.init(
        [   'Pending',
            'Sent/Submitted',
            'Accepted/Rejected',
            'Pickup',
            'Vehicle Placed',
            'Vehicle Ready Despatch',
            'Material Lifted',
            'Invoiced',
            'Completed'
        ],
        '<?=$enquiryStatus?>',
        'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
      );
    </script>
<?php } else {?>
    <script type="text/javascript">
      //we can set animation delay as following in ms (default 1000)
      ProgressBar.singleStepAnimation = 700;
      ProgressBar.init(
        [   'Pending',
            'Rejected'
        ],
        '<?=$enquiryStatus?>',
        'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
      );
    </script>
<?php }?>
<script type="text/javascript">
    function getRejectModal(enq_id){
        let baseUrl = '<?=base_url()?>';
        $.ajax({
          type: "POST",
          data: { enq_id: enq_id },
          url: baseUrl+"/admin/get-reject-modal",
          dataType: "JSON",
          success: function(res){
            if(res.success){
              $('#rejectRequest').modal('show');
              $('#rejectRequestTitle').html(res.data.title);
              $('#rejectRequestBody').html(res.data.body);
            } else {
              $('#rejectRequest').modal('hide');
              $('#rejectRequestTitle').html('');
              $('#rejectRequestBody').html('');
            }
          }
        });
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){    
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount:30,
            searchResultLimit:30,
            renderChoiceLimit:30
        });     
    });
</script>