<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];

$userType                   = $session->user_type;
$company_id                 = $session->company_id;
?>
<div class="container-fluid">
    <div class="pagetitle">
        <h1><?= $page_header ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li>
                <li class="breadcrumb-item active"><?= $page_header ?></li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php if (session('success_message')) { ?>
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('success_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if (session('error_message')) { ?>
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('error_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <small class="text-danger mb-0 mb-md-2 d-block">* (star) marks fields are mandatory</small>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-4 text-center">
                                    <label>Company</label>
                                    <h6><?= (($company) ? $company->company_name : '') ?></h6>
                                </div>
                                <div class="col-md-6 mb-4 text-center">
                                    <label>Plant</label>
                                    <h6><?= (($plant) ? $plant->plant_name : '') ?></h6>
                                </div>

                                <!-- items -->
                                <div class="col-md-12 mb-4 text-center">
                                    <button type="button" class="btn btn-info btn-sm mt-4 add_button">Add Item For Enquiry</button>
                                </div>
                                <div class="col-md-12 mb-4 text-center">
                                    <div class="field_wrapper">

                                    </div>
                                </div>
                                <!-- items -->

                                <div class="col-md-6 mb-4 text-center">
                                    <label>Tentative Collection Date</label>
                                    <input type="date" name="tentative_collection_date" id="tentative_collection_date" min="<?= date('Y-m-d', strtotime('-1 week')) ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-4 text-center">
                                    <label>GPS Image</label>
                                    <input type="file" name="gps_tracking_image" id="gps_tracking_image" class="form-control" required>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('#gst_no').on('blur', function() {
            let gst_no = $('#gst_no').val();
            let url = '<?= base_url() ?>';
            var settings = {
                "url": url + "api/get-company-details2",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "key": "4e1c3ee6861ac425437fa8b662651cde",
                    "source": "ANDROID",
                    "Content-Type": "application/json",
                    "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                },
                "data": JSON.stringify({
                    "gst_no": gst_no
                }),
            };

            $.ajax(settings).done(function(response) {
                response = $.parseJSON(response);
                console.log(response.success);
                console.log(response.data.trade_name);
                if (response.success) {
                    $('#company_name').val(response.data.trade_name);
                    $('#full_address').val(response.data.address);
                    $('#holding_no').val(response.data.holding_no);
                    $('#street').val(response.data.street);
                    $('#district').val(response.data.district);
                    $('#state').val(response.data.state);
                    $('#pincode').val(response.data.pincode);
                    $('#location').val(response.data.location);
                }
            });
        });
    })
</script>
<script type="text/javascript">
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script>
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = `<div class="row" style="border: 1px solid #022b6d; padding: 10px;margin-bottom: 5px;border-radius:10px;">
                            <div class="col-md-4">
                                <select class="form-select" name="item_id[]" required>
                                    <option value="" selected>Select Item</option>
                                    <?php if ($items) {
                                        foreach ($items as $item) { ?>
                                        <option value="<?= $item->id ?>"><?= $item->item_name_ecoex ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="qty[]" placeholder="Item Tentative Qty" required>
                            </div>
                            <div class="col-md-4">
                                <input type="file" class="form-control" name="new_product_image[]" placeholder="Item Image" required>
                            </div>
                            <div class="col-md-1">
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm remove_button" style="background: #FFF;">❌</a>
                            </div>
                        </div>`; //New input field html 
        var x = 1; //Initial field counter is 1

        // Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increase field counter
                $(wrapper).append(fieldHTML); //Add field html
            } else {
                alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
            }
        });

        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove(); //Remove field html
            x--; //Decrease field counter
        });
    });
</script>