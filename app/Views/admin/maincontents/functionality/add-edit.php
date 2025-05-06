<?php
if (count($row)) {
    $updateId        = $row['id'];
    $name            = $row['name'];
    $platform        = $row['platform'];
    $rank            = $row['rank'];
} else {
    $updateId        = 0;
    $name            = '';
    $platform        = '';
    $rank            = '';
}
?>
<div class="container-fluid">
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
                        <form method="POST" action="<?= base_url(route_to('functionalities.store')) ?>" enctype="multipart/form-data">
                            <input type="hidden" name="update_id" value="<?= $updateId ?>">
    
                            <!-- Options rendered as radio buttons -->
                            <div class="row mb-3">
                                <label class="col-md-2 col-lg-2 col-form-label">Platform</label>
                                <div class="col-md-10 col-lg-10">
                                    <?php foreach ($platforms as $key => $label): ?>
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="platform"
                                                id="option_<?php echo $key; ?>"
                                                value="<?php echo $key; ?>"
                                                <?php echo ($platform === $key) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="option_<?php echo $key; ?>">
                                                <?php echo $label; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
    
                                    <?php if (session('errors.platform')): ?>
                                        <div class="text-danger"><?= session('errors.platform') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
    
    
                            <!-- Name Input Tags -->
                            <div class="row mb-3">
                                <label for="input-tags" class="col-md-2 col-lg-2 col-form-label">Functionality Name</label>
                                <div class="col-md-10 col-lg-10">
                                    <input type="text" id="input-tags" class="form-control" name="name" placeholder="Enter your functionality name" value="<?=$name?>"/>
    
                                    <?php if (session('errors.name')): ?>
                                        <div class="text-danger"><?= session('errors.name') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
    
                            <!-- Rank Input Tags -->
                            <div class="row mb-3">
                                <label for="input-tags" class="col-md-2 col-lg-2 col-form-label">Rank Number</label>
                                <div class="col-md-10 col-lg-10">
                                    <input type="text" id="input-tags" class="form-control" name="rank" placeholder="Rank number" value="<?=$rank?>"/>
                                    <?php if (session('errors.rank')): ?>
                                        <div class="text-danger"><?= session('errors.rank') ?></div>
                                    <?php endif; ?>
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