<?php
if (count($row)) {
    $updateId        = $row['id'];
    $email           = $row['email'];
    $is_ho           = $row['is_ho'];
    $is_push         = $row['is_push_notification'];
    $is_sms          = $row['is_sms'];
    $is_vendor       = $row['is_vendor'];
} else {
    $updateId        = 0;
    $email           = '';
    $is_ho           = '';
    $is_push         = '';
    $is_sms          = '';
    $is_vendor       = '';
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

                        <div class="row mb-3">
                            <label for="input-tags" class="col-md-2 col-lg-2 col-form-label">Platform</label>
                            <div class="col-md-10 col-lg-10">

                                <select class="form-select" aria-label="Default select example">
                                    <option selected value="">Select</option>
                                </select>
                                <?php if (session('errors.mn_email')): ?>
                                    <div class="text-danger"><?= session('errors.mn_email') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="input-tags" class="col-md-2 col-lg-2 col-form-label">Functionality</label>
                            <div class="col-md-10 col-lg-10">

                                <select class="form-select" aria-label="Default select example">
                                    <option selected value="">Select</option>
                                </select>
                                <?php if (session('errors.mn_email')): ?>
                                    <div class="text-danger"><?= session('errors.mn_email') ?></div>
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


                        <!-- Options -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-lg-2 col-form-label">Options</label>
                            <div class="col-md-10 col-lg-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_is_vendor" id="mn_is_vendor" value="1" <?= isset($is_vendor) && $is_vendor ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_is_vendor">Is Vendor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_is_ho" id="mn_is_ho" value="1" <?= isset($is_ho) && $is_ho ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_is_ho">Is Head Office</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_is_sms_to_vendor" id="mn_is_sms_to_vendor" value="1" <?= isset($is_sms) && $is_sms ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_is_sms_to_vendor">Send SMS to Vendor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mn_is_push_notification" id="mn_is_push_notification" value="1" <?= isset($is_push) && $is_push ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mn_is_push_notification">Push Notification</label>
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
    });
</script>