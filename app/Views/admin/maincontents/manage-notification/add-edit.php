<?php
if (count($row)) {
    $updateId        = $row['id'];
    $platform        = $row['platform'];
    $fun_id          = $row['fun_id'];
    $email           = $row['email'];
    $mn_ecoex_admin_email = $row['mn_ecoex_admin_email'];
    $mn_company_admin_email = $row['mn_company_admin_email'];
    $mn_vendor_email = $row['mn_vendor_email'];
    $mn_vendor_sms = $row['mn_vendor_sms'];
    $mn_vendor_push = $row['mn_vendor_push'];
    $mn_plant_email = $row['mn_plant_email'];
    $mn_plant_sms = $row['mn_plant_sms'];
    $mn_plant_push = $row['mn_plant_push'];
} else {
    $updateId        = 0;
    $platform        = '';
    $fun_id          = '';
    $email           = '';
    $mn_fun_id       = '';
    $mn_ecoex_admin_email = '';
    $mn_company_admin_email = '';
    $mn_vendor_email = '';
    $mn_vendor_sms = '';
    $mn_vendor_push = '';
    $mn_plant_email = '';
    $mn_plant_sms = '';
    $mn_plant_push = '';
}

?>

<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '') ?>"><?= $titel2 ?></a></li>
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
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
                    <form method="POST" action="<?= base_url('admin/' . $controller_route) ?>" enctype="multipart/form-data">
                        <input type="hidden" name="update_id" value="<?= $updateId ?>">
                        <input type="hidden" id="fun_id" name="fun_id" value="<?= $fun_id ?>">

                        <div class="row mb-3">
                            <label for="input-tags" class="col-md-2 col-lg-2 col-form-label">Platform</label>
                            <div class="col-md-10 col-lg-10">

                                <!-- First dropdown for Platform -->
                                <select class="form-select" id="platform" name="platform" required>
                                    <option value="">Select Platform</option>
                                    <?php foreach ($platforms as $key => $label): ?>
                                        <option value="<?= $key ?>" <?= ($key == $platform) ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>


                                <?php if (session('errors.platform')): ?>
                                    <div class="text-danger"><?= session('errors.platform') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="input-tags" class="col-md-2 col-lg-2 col-form-label">Functionality</label>
                            <div class="col-md-10 col-lg-10">

                                <!-- Second dropdown for Functionality -->
                                <select class="form-select" id="functionality" name="functionality" required>
                                    <option value="">Select Functionality</option>
                                </select>

                                <?php if (session('errors.functionality')): ?>
                                    <div class="text-danger"><?= session('errors.functionality') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Email Input Tags -->
                        <div class="row mb-3">
                            <label for="input-tags" class="col-md-2 col-lg-2 col-form-label">Emails</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" id="input-tags" class="form-control" placeholder="Type emails and press comma" />
                                <div class="error-msg text-danger mt-1" id="error-msg" style="display: none;">Invalid email format detected.</div>
                                <div id="badge-container" class="mt-2"></div>
                                <input type="hidden" id="other_article_part_doi_no" name="mn_email" value="<?= $email ?? '' ?>">
                                <?php if (session('errors.mn_email')): ?>
                                    <div class="text-danger"><?= session('errors.mn_email') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <!-- Notification Options -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-lg-2 col-form-label">Notification Options</label>
                            <div class="col-md-10 col-lg-10">
                                <!-- Email Options -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_ecoex_admin_email" id="mn_ecoex_admin_email" value="1" <?= isset($mn_ecoex_admin_email) && $mn_ecoex_admin_email ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_ecoex_admin_email">Ecoex Admin Email</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_company_admin_email" id="mn_company_admin_email" value="1" <?= isset($mn_company_admin_email) && $mn_company_admin_email ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_company_admin_email">Company Admin Email</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_vendor_email" id="mn_vendor_email" value="1" <?= isset($mn_vendor_email) && $mn_vendor_email ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_vendor_email">Vendor Email</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_plant_email" id="mn_plant_email" value="1" <?= isset($mn_plant_email) && $mn_plant_email ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_plant_email">Plant Email</label>
                                </div>

                                <!-- SMS Options -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_vendor_sms" id="mn_vendor_sms" value="1" <?= isset($mn_vendor_sms) && $mn_vendor_sms ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_vendor_sms">Vendor SMS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_plant_sms" id="mn_plant_sms" value="1" <?= isset($mn_plant_sms) && $mn_plant_sms ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_plant_sms">Plant SMS</label>
                                </div>

                                <!-- Push Notification Options -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_vendor_push" id="mn_vendor_push" value="1" <?= isset($mn_vendor_push) && $mn_vendor_push ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_vendor_push">Vendor Push</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_plant_push" id="mn_plant_push" value="1" <?= isset($mn_plant_push) && $mn_plant_push ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_plant_push">Plant Push</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?= ((count($row)) ? 'Save' : 'Add') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var tagsArray = [];
        var beforeData = $('#other_article_part_doi_no').val();
        if (beforeData.length > 0) {
            tagsArray = beforeData.split(',');
            tagsArray.forEach(function(tag) {
                $('#badge-container').append(
                    '<span class="badge bg-primary text-white px-2 py-1 me-1 rounded-pill">' + tag +
                    ' <span class="remove" data-tag="' + tag + '" style="cursor:pointer;">&times;</span></span>'
                );
            });
        }

        function isValidEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        $('#input-tags').on('input', function() {
            var input = $(this).val();
            if (input.includes(',')) {
                var tags = input.split(',');
                var invalidFound = false;
                tags.forEach(function(tag) {
                    tag = tag.trim();
                    if (tag.length > 0) {
                        if (isValidEmail(tag)) {
                            if (!tagsArray.includes(tag)) {
                                tagsArray.push(tag);
                                $('#badge-container').append(
                                    '<span class="badge bg-primary text-white px-2 py-1 me-1 rounded-pill">' + tag +
                                    ' <span class="remove" data-tag="' + tag + '" style="cursor:pointer;">&times;</span></span>'
                                );
                                $('#error-msg').hide();
                            }
                        } else {
                            invalidFound = true;
                        }
                    }
                });
                $('#other_article_part_doi_no').val(tagsArray.join(','));
                $(this).val('');
                if (invalidFound) {
                    $('#error-msg').show();
                } else {
                    $('#error-msg').hide();
                }
            }
        });

        $(document).on('click', '.remove', function() {
            var tag = $(this).data('tag');
            tagsArray = tagsArray.filter(function(item) {
                return item !== tag;
            });
            $(this).parent().remove();
            $('#other_article_part_doi_no').val(tagsArray.join(','));
        });




        // drop down logic
        // Convert PHP array of objects to JSON
        var functionalities = <?php echo json_encode($functionality); ?>;

        // Group functionalities by their platform
        var functionalitiesByPlatform = {};
        $.each(functionalities, function(i, item) {
            if (!functionalitiesByPlatform[item.fun_platform]) {
                functionalitiesByPlatform[item.fun_platform] = [];
            }
            functionalitiesByPlatform[item.fun_platform].push(item);
        });


        // Listen for changes on the platform dropdown
        $('#platform').on('change', function() {
            var platform = $(this).val();
            var options = '<option value="">Select Functionality</option>';

            // Check if the selected platform has functionalities
            if (platform && functionalitiesByPlatform[platform]) {
                $.each(functionalitiesByPlatform[platform], function(i, item) {
                    options += '<option value="' + item.fun_id + '">' + item.fun_functionality_name + '</option>';
                });
            }
            // Update the functionality dropdown
            $('#functionality').html(options);
        });



        function populateFunctionalities(platform, fun_id = '', targetDropdownId = '#functionality') {

            var options = '<option value="">Select Functionality</option>';

            if (platform && functionalitiesByPlatform[platform]) {
                $.each(functionalitiesByPlatform[platform], function(i, item) {
                    var selected = (fun_id == item.fun_id) ? ' selected' : '';
                    options += '<option value="' + item.fun_id + '"' + selected + '>' + item.fun_functionality_name + '</option>';
                });
            }

            $(targetDropdownId).html(options);
        }


        var selectedPlatform = $('#platform').val();
        var fun_id = $("#fun_id").val();

        populateFunctionalities(selectedPlatform, fun_id);


    });
</script>