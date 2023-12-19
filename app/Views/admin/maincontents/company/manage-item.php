<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style type="text/css">
    .item-cover{
        border: 1px solid #00800047;
        padding: 13px;
        border-radius: 7px;
        margin-bottom: 10px;
    }
    .item-cover-existing{
        border: 1px solid orange;
        padding: 13px;
        border-radius: 7px;
        margin-bottom: 10px;
    }
</style>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
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
        
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="company_id" id="company_id" value="<?=$company_id?>">

                        <div class="row">
                            <div class="col-md-1">
                                <h6 class="fw-bold">Item<br>Category</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="fw-bold">Item Name<br>(Ecoex)</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="fw-bold">Alias<br>(App)</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="fw-bold">Billing<br>Name</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="fw-bold">HSN</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="fw-bold">GST</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="fw-bold">Rate</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="fw-bold">Unit</h6>
                            </div>
                            <div class="col-md-1">
                                <h6 class="fw-bold">Action</h6>
                            </div>
                        </div>
                        <div class="field_wrapper">
                            <?php if($assignItems){ foreach($assignItems as $assignItem){?>
                                <div class="row item-cover-existing">
                                    <div class="col-md-1">
                                        <select class="form-control" name="item_category[]">
                                            <option value="" selected>Select</option>
                                            <?php if($cats){ foreach($cats as $cat){?>
                                            <option value="<?=$cat->category_id?>" <?=(($cat->category_id == $assignItem->item_category)?'selected':'')?>><?=$cat->category_alias?></option>
                                            <?php } }?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="item_name_ecoex[]" class="form-control" placeholder="Item Ecoex" value="<?=$assignItem->item_name_ecoex?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="alias_name[]" class="form-control" placeholder="Alias Name" value="<?=$assignItem->alias_name?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="billing_name[]" class="form-control" placeholder="Billing Name" value="<?=$assignItem->billing_name?>">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="hsn[]" class="form-control" placeholder="HSN" value="<?=$assignItem->hsn?>">
                                    </div>
                                    <div class="col-md-1">
                                        <select class="form-control" name="gst[]">
                                            <option value="" selected>Select</option>
                                            <option value="0" <?=(($assignItem->gst == 0)?'selected':'')?>>0 %</option>
                                            <option value="5" <?=(($assignItem->gst == 5)?'selected':'')?>>5 %</option>
                                            <option value="12" <?=(($assignItem->gst == 12)?'selected':'')?>>12 %</option>
                                            <option value="18" <?=(($assignItem->gst == 18)?'selected':'')?>>18 %</option>
                                            <option value="28" <?=(($assignItem->gst == 28)?'selected':'')?>>28 %</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" name="rate[]" class="form-control" placeholder="Rate" value="<?=$assignItem->rate?>">
                                    </div>
                                    <div class="col-md-1">
                                        <select class="form-control" name="unit[]">
                                            <option value="" selected>Select</option>
                                            <?php if($units){ foreach($units as $unit){?>
                                            <option value="<?=$unit->id?>" <?=(($unit->id == $assignItem->unit)?'selected':'')?>><?=$unit->name?></option>
                                            <?php } }?>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0);" class="remove_button" title="Remove Item"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>
                                    </div>
                                </div>
                            <?php } }?>
                            <div class="row item-cover">
                                <div class="col-md-1">
                                    <select class="form-control" name="item_category[]">
                                        <option value="" selected>Select</option>
                                        <?php if($cats){ foreach($cats as $cat){?>
                                        <option value="<?=$cat->category_id?>"><?=$cat->category_alias?></option>
                                        <?php } }?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="item_name_ecoex[]" class="form-control" placeholder="Item Ecoex">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="alias_name[]" class="form-control" placeholder="Alias Name">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="billing_name[]" class="form-control" placeholder="Billing Name">
                                </div>
                                <div class="col-md-1">
                                    <input type="text" name="hsn[]" class="form-control" placeholder="HSN">
                                </div>
                                <div class="col-md-1">
                                    <select class="form-control" name="gst[]">
                                        <option value="" selected>Select</option>
                                        <option value="0">0 %</option>
                                        <option value="5">5 %</option>
                                        <option value="12">12 %</option>
                                        <option value="18">18 %</option>
                                        <option value="28">28 %</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" name="rate[]" class="form-control" placeholder="Rate">
                                </div>
                                <div class="col-md-1">
                                    <select class="form-control" name="unit[]">
                                        <option value="" selected>Select</option>
                                        <?php if($units){ foreach($units as $unit){?>
                                        <option value="<?=$unit->id?>"><?=$unit->name?></option>
                                        <?php } }?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <a href="javascript:void(0);" class="add_button" title="Add Item"><i class="fa fa-plus-circle fa-2x text-success"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // $('input:text').prop('readOnly', true);
        $('input:checkbox').on('click', function () {
            if ($(this).prop('checked')) {
                $(this).parent().nextAll().find('input').prop('readOnly', false);
                $(this).parent().nextAll().find('input').focus();
                $(this).parent().nextAll().find('input').css('background', '#00800021');
                setTimeout(function () {
                    $(this).parent().nextAll().find('input').css('background', '#FFF');
                }, 3000);
            } else {
                $(this).parent().nextAll().find('input').prop('readOnly', true);
                $(this).parent().nextAll().find('input').css('background', '#FFF');
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div class="row item-cover">\
                            <div class="col-md-1">\
                                <select class="form-control" name="item_category[]">\
                                    <option value="" selected>Select</option>\
                                    <?php if($cats){ foreach($cats as $cat){?>
                                    <option value="<?=$cat->category_id?>"><?=$cat->category_alias?></option>\
                                    <?php } }?>
                                </select>\
                            </div>\
                            <div class="col-md-2">\
                                <input type="text" name="item_name_ecoex[]" class="form-control" placeholder="Item Ecoex">\
                            </div>\
                            <div class="col-md-2">\
                                <input type="text" name="alias_name[]" class="form-control" placeholder="Alias Name">\
                            </div>\
                            <div class="col-md-2">\
                                <input type="text" name="billing_name[]" class="form-control" placeholder="Billing Name">\
                            </div>\
                            <div class="col-md-1">\
                                <input type="text" name="hsn[]" class="form-control" placeholder="HSN">\
                            </div>\
                            <div class="col-md-1">\
                                <select class="form-control" name="gst[]">\
                                    <option value="" selected>Select</option>\
                                    <option value="0">0 %</option>\
                                    <option value="5">5 %</option>\
                                    <option value="12">12 %</option>\
                                    <option value="18">18 %</option>\
                                    <option value="28">28 %</option>\
                                </select>\
                            </div>\
                            <div class="col-md-1">\
                                <input type="text" name="rate[]" class="form-control" placeholder="Rate">\
                            </div>\
                            <div class="col-md-1">\
                                <select class="form-control" name="unit[]">\
                                    <option value="" selected>Select</option>\
                                    <?php if($units){ foreach($units as $unit){?>
                                    <option value="<?=$unit->id?>"><?=$unit->name?></option>\
                                    <?php } }?>
                                </select>\
                            </div>\
                            <div class="col-md-1">\
                                <a href="javascript:void(0);" class="remove_button" title="Remove Item"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>\
                            </div>\
                        </div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        // Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increase field counter
                $(wrapper).append(fieldHTML); //Add field html
            }else{
                alert('A maximum of '+maxField+' fields are allowed to be added. ');
            }
        });
        
        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').parent('div').remove(); //Remove field html
            x--; //Decrease field counter
        });
    });
</script>