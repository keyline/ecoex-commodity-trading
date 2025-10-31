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
    font-size: 10px;
    font-weight: bold;
    line-height: 16px;
    color: gray;
    vertical-align: top;
    position: relative;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap: break-word;
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
.material_accordion_section button.accordion-button {
    color: #fff;
    font-size: 18px;
}
.material_accordion_section .accordion-button::after{
    font-family: "Font Awesome 5 Free"; 
    font-weight: 900; 
    content: "\f078";";
    position: absolute;
    right: 5px;
    color: #fff;
    background-image: none;
} 
</style>
<!-- for inquiry tracking -->
<style type="text/css">
    th:first-child
    {
    position:sticky;
    left:0px;
    background-color:#dee2e6;
    color: #000;
    z-index: 1;
    }
    td:first-child
    {
    position:sticky;
    left:0px;
    }
</style>
<?php
    $title              = $moduleDetail['title'];
    $primary_key        = $moduleDetail['primary_key'];
    $controller_route   = $moduleDetail['controller_route'];
    ?>
<div class="container-fluid">
    <div class="pagetitle">
        <h1><?=$page_header?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                <li class="breadcrumb-item active"><?=$page_header?></li>
            </ol>
        </nav>
    </div>
</div>    
<section class="section">
    <div class="container-fluid">
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
                        <div class="row mt-3">                            
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Contact No.</h5>
                                <h6>
                                    <?php                                        
                                        echo (($row)?$row->contact_no:'');
                                        ?>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Location</h5>
                                <h6>
                                    <?php                                        
                                        echo (($row)?$row->location:'');
                                        ?>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Current Location</h5>
                                <h6>     
                                    <?php                                        
                                        echo (($row)?$row->current_location:'');
                                        ?>                               
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Notes</h5>
                                <h6>
                                    <?php                                        
                                        echo (($row)?$row->notes:'');
                                        ?>
                                </h6>                                
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Quotation Items</h5>
                                <?php
                                $scrap_names = array_column(json_decode(json_encode($quotation_items), true), 'scrap_name');                                
                                ?>
                                <h6><?php echo implode(', ', $scrap_names);?></h6>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-success">Quotation Submitted Date</h5>
                                <h6><?=date_format(date_create($row->created_at), "M d, Y")?></h6>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="material_accordion_section">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Enquiry Request Items </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table globel_table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Vendor Contact No.</th>
                                                    <th>Quoted Rate</th>
                                                    <th>Location</th>
                                                    <th>Quantity</th>
                                                    <th>Quotation Submitted Date</th>  
                                                    <th>Notes</th>                                                                                                      
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if($quotation_items){ $slNo=1; foreach($quotation_items as $quotation_item){                                                        
                                                    ?>
                                                <tr style="background-color: #0080001a;">
                                                    <th><?=$slNo++?></th>
                                                    <td><?=$row->contact_no?></td>
                                                    <!-- <td>?=intval($quotation_item->rate)?>/?=$quotation_item->unit?> <a href="?= base_url('admin/' . $controller_route . '/edit_rate/' . encoded($quotation_item->id)) ?>"> <i class="fa-solid fa-pen-to-square"></i></a></td> -->
                                                    <td>
                                                        <span class="rate-text"><?= intval($quotation_item->rate) ?>/<?= $quotation_item->unit ?></span>
                                                        <?php 
                                                            if($quotation_item->status != 2){ ?>
                                                                <a href="javascript:void(0);" class="edit-rate" data-id="<?= $quotation_item->id ?>">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                            <?php } ?>                                                    
                                                        <form class="rate-form d-none" method="post" action="<?= base_url('admin/update_rate') ?>">
                                                            <input type="hidden" name="id" value="<?= $quotation_item->id ?>">
                                                            <input type="number" name="rate" value="<?= intval($quotation_item->rate) ?>" class="form-control form-control-sm rate-input" style="width: 80px; display:inline-block;">
                                                            <button type="submit" class="btn btn-sm btn-success save-rate"><i class="fa-solid fa-check"></i></button>
                                                            <button type="button" class="btn btn-sm btn-secondary cancel-rate"><i class="fa-solid fa-xmark"></i></button>
                                                        </form>
                                                    </td>
                                                    <td><?=$row->location?></td>
                                                    <td><?=intval($quotation_item->qty)?> <?=$quotation_item->unit?></td>
                                                    <td><?=date_format(date_create($row->created_at), "M d, Y")?></td>
                                                    <td><?=$row->notes?></td>                                                    
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
            
        </div>
    </div>
</section>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- progress bar -->
<script src="<?=getenv('app.adminAssetsURL');?>assets/js/progress-bar.js"></script>
<!-- progress bar -->
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
<script>
    $(document).on('click', '.edit-rate', function() {
        let td = $(this).closest('td');
        td.find('.rate-text').hide();
        td.find('.edit-rate').hide();
        td.find('.rate-form').removeClass('d-none');
    });

    $(document).on('click', '.cancel-rate', function() {
        let td = $(this).closest('td');
        td.find('.rate-form').addClass('d-none');
        td.find('.rate-text').show();
        td.find('.edit-rate').show();
    });

    $(document).on('submit', '.rate-form', function(e) {
        e.preventDefault();
        let form = $(this);
        let id = form.find('input[name="id"]').val();
        let rate = form.find('input[name="rate"]').val();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: { id: id, rate: rate },
            success: function(response) {
                try {
                    let res = (typeof response === 'object') ? response : JSON.parse(response);
                    if (res.status) {
                        // ✅ Reload page to show updated rate + success message
                        location.reload();
                    } else {
                        alert("Failed to update rate.");
                    }
                } catch (err) {
                    console.error("Invalid JSON response:", response);
                }
            },
            error: function() {
                alert("Error occurred while updating rate.");
            }
        });
    });

</script>