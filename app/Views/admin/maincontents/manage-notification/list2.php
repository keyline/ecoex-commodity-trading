<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<section class="section">
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
            <?php
            } ?>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= base_url('admin/' . $controller_route) ?>" enctype="multipart/form-data">
                        <?php foreach ($functionality as $func) {
                            $funId = $func->fun_id;
                            $updateId = $func->mn_id ?? 0;
                            $email = $func->mn_email ? json_decode($func->mn_email, true) : '';

                            $mn_ecoex_admin_email = $func->mn_ecoex_admin_email ?? '';
                            $mn_company_admin_email = $func->mn_company_admin_email ?? '';
                            $mn_vendor_email = $func->mn_vendor_email ?? '';
                            $mn_vendor_sms = $func->mn_vendor_sms ?? '';
                            $mn_vendor_push = $func->mn_vendor_push ?? '';
                            $mn_plant_email = $func->mn_plant_email ?? '';
                            $mn_plant_sms = $func->mn_plant_sms ?? '';
                            $mn_plant_push = $func->mn_plant_push ?? '';
                        ?>

                            <div class="row" style="border: 1px solid #ddd9d9;padding:3px;border-radius:5px;margin-top:15px">
                                <input type="hidden" name="update_id[<?= $funId ?>]" value="<?= $updateId ?>">
                                <div class="col-sm-3">
                                    <div>
                                        <label for="input-tags" class="col-form-label"> <strong><?= ucwords($func->fun_functionality_name) ?></strong> </label>
                                        <input type="hidden" name="functionality[<?= $funId ?>]" value="<?= $funId ?>">
                                        <div class="col-md-10 col-lg-10">
                                            <?php if (session('errors.functionality')): ?>
                                                <div class="text-danger"><?= session('errors.functionality') ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="">
                                            <small class="show-platform"><?= ucwords(str_replace('_', ' ', $func->fun_platform)) ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4 email-container">
                                    <!-- Email Input Tags -->
                                    <div class="row mb-3">
                                        <div>
                                            <label class="col-form-label">Emails</label>
                                            <div class="col-md-10 col-lg-10">
                                                <!-- Use classes instead of IDs -->
                                                <input type="text" class="form-control input-tags" placeholder="Type emails and press comma" />
                                                <div class="error-msg text-danger mt-1" style="display: none;">Invalid email format detected.</div>
                                                <div class="badge-container mt-2"></div>
                                                <input type="hidden" class="other_article_part_doi_no" name="mn_email[<?= $funId ?>]" value="<?= $email ?? '' ?>">
                                                <?php if (session('errors.mn_email')): ?>
                                                    <div class="text-danger"><?= session('errors.mn_email') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div>
                                        <!-- Notification Options -->
                                        <div class="row mb-3">
                                            <label class=" col-form-label">Notification Options:</label>
                                            <div class="">
                                                <!-- Email Options -->
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="mn_ecoex_admin_email[<?= $funId ?>]" value="1" <?= isset($mn_ecoex_admin_email) && $mn_ecoex_admin_email ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="mn_ecoex_admin_email">Ecoex Admin Email</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="mn_company_admin_email[<?= $funId ?>]" value="1" <?= isset($mn_company_admin_email) && $mn_company_admin_email ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="mn_company_admin_email">Company Admin Email</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="mn_vendor_email[<?= $funId ?>]" value="1" <?= isset($mn_vendor_email) && $mn_vendor_email ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="mn_vendor_email">Vendor Email</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="mn_plant_email[<?= $funId ?>]" value="1" <?= isset($mn_plant_email) && $mn_plant_email ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="mn_plant_email">Plant Email</label>
                                                </div>

                                                <!-- SMS Options -->
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="mn_vendor_sms[<?= $funId ?>]" value="1" <?= isset($mn_vendor_sms) && $mn_vendor_sms ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="mn_vendor_sms">Vendor SMS</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="mn_plant_sms[<?= $funId ?>]" value="1" <?= isset($mn_plant_sms) && $mn_plant_sms ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="mn_plant_sms">Plant SMS</label>
                                                </div>

                                                <!-- Push Notification Options -->
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="mn_vendor_push[<?= $funId ?>]" value="1" <?= isset($mn_vendor_push) && $mn_vendor_push ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="mn_vendor_push">Vendor Push</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="mn_plant_push[<?= $funId ?>]" value="1" <?= isset($mn_plant_push) && $mn_plant_push ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="mn_plant_push">Plant Push</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (session('errors')['functionality_' . $funId] ?? false): ?>
                                    <div class="text-danger text-center mt-1"><?= session('errors')['functionality_' . $funId] ?></div>
                                <?php endif; ?>
                            </div>


                        <?php } ?>


                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
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



        // email inputs
        // var tagsArray = [];
        // var beforeData = $('#other_article_part_doi_no').val();
        // if (beforeData.length > 0) {
        //     tagsArray = beforeData.split(',');
        //     tagsArray.forEach(function(tag) {
        //         $('#badge-container').append(
        //             '<span class="badge bg-primary text-white px-2 py-1 me-1 rounded-pill">' + tag +
        //             ' <span class="remove" data-tag="' + tag + '" style="cursor:pointer;">&times;</span></span>'
        //         );
        //     });
        // }

        // function isValidEmail(email) {
        //     var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //     return re.test(email);
        // }

        // $('#input-tags').on('input', function() {
        //     var input = $(this).val();
        //     if (input.includes(',')) {
        //         var tags = input.split(',');
        //         var invalidFound = false;
        //         tags.forEach(function(tag) {
        //             tag = tag.trim();
        //             if (tag.length > 0) {
        //                 if (isValidEmail(tag)) {
        //                     if (!tagsArray.includes(tag)) {
        //                         tagsArray.push(tag);
        //                         $('#badge-container').append(
        //                             '<span class="badge bg-primary text-white px-2 py-1 me-1 rounded-pill">' + tag +
        //                             ' <span class="remove" data-tag="' + tag + '" style="cursor:pointer;">&times;</span></span>'
        //                         );
        //                         $('#error-msg').hide();
        //                     }
        //                 } else {
        //                     invalidFound = true;
        //                 }
        //             }
        //         });
        //         $('#other_article_part_doi_no').val(tagsArray.join(','));
        //         $(this).val('');
        //         if (invalidFound) {
        //             $('#error-msg').show();
        //         } else {
        //             $('#error-msg').hide();
        //         }
        //     }
        // });

        // $(document).on('click', '.remove', function() {
        //     var tag = $(this).data('tag');
        //     tagsArray = tagsArray.filter(function(item) {
        //         return item !== tag;
        //     });
        //     $(this).parent().remove();
        //     $('#other_article_part_doi_no').val(tagsArray.join(','));
        // });



        // Utility function to validate an email address
        function isValidEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // When the page loads, initialize each email container with its pre-existing emails.
        $('.email-container').each(function() {
            var $container = $(this);
            var initialData = $container.find('.other_article_part_doi_no').val();
            var tagsArray = [];
            if (initialData && initialData.length > 0) {
                tagsArray = initialData.split(',');
                tagsArray.forEach(function(tag) {
                    $container.find('.badge-container').append(
                        '<span class="badge bg-primary text-white px-2 py-1 me-1 rounded-pill">' + tag +
                        ' <span class="remove" data-tag="' + tag + '" style="cursor:pointer;">&times;</span></span>'
                    );
                });
            }
            $container.data('tags', tagsArray); // store the tags array for this container
        });

        // Listen for input on any email input field
        $(document).on('input', '.input-tags', function() {
            var $input = $(this);
            var inputVal = $input.val();

            // Identify the container for this email input
            var $container = $input.closest('.email-container');
            var tagsArray = $container.data('tags') || [];
            var $badgeContainer = $container.find('.badge-container');
            var $errorMsg = $container.find('.error-msg');
            var $hiddenInput = $container.find('.other_article_part_doi_no');

            if (inputVal.includes(',')) {
                // Split the input by comma
                var tags = inputVal.split(',');
                var invalidFound = false;

                tags.forEach(function(tag) {
                    tag = tag.trim();
                    if (tag.length > 0) {
                        if (isValidEmail(tag)) {
                            if (tagsArray.indexOf(tag) === -1) {
                                tagsArray.push(tag);
                                // Append the badge for this email tag
                                $badgeContainer.append(
                                    '<span class="badge bg-primary text-white px-2 py-1 me-1 rounded-pill">' + tag +
                                    ' <span class="remove" data-tag="' + tag + '" style="cursor:pointer;">&times;</span></span>'
                                );
                                $errorMsg.hide();
                            }
                        } else {
                            invalidFound = true;
                        }
                    }
                });

                // Update the hidden input and data for the container
                $hiddenInput.val(tagsArray.join(','));
                $input.val('');
                $errorMsg.toggle(invalidFound);

                // Save the updated tags array in the container's data
                $container.data('tags', tagsArray);
            }
        });

        // Event delegation for removing tags
        $(document).on('click', '.remove', function() {
            // Find the email container for this remove button
            var $container = $(this).closest('.email-container');
            var tag = $(this).data('tag');
            var tagsArray = $container.data('tags') || [];

            // Remove the tag from the array and update the hidden input
            tagsArray = tagsArray.filter(function(item) {
                return item !== tag;
            });
            $container.find('.other_article_part_doi_no').val(tagsArray.join(','));

            // Remove the badge from the DOM
            $(this).closest('.badge').remove();

            // Update the container's data with the new array
            $container.data('tags', tagsArray);
        });

    });
</script>