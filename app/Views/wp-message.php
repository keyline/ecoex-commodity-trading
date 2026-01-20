<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f4fff6; }
        .card-header { background: #198754; color: #fff; }
        .required { color: red; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h4><?= $page_header ?></h4>
        </div>

        <div class="card-body">

            <!-- ✅ FLASH MESSAGES -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">


                <div class="mb-3">
                    <label>Campaign Name <span class="required">*</span></label>
                    <input type="text" name="campaignName" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Destination (with country code) <span class="required">*</span></label>
                    <input type="text" name="destination" class="form-control" placeholder="+919XXXXXXXXX" required>
                </div>

                <div class="mb-3">
                    <label>User Name <span class="required">*</span></label>
                    <input type="text" name="userName" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Source</label>
                    <input type="text" name="source" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Template Params (comma separated)</label>
                    <input type="text" name="templateParams" class="form-control" placeholder="Surajit,ORD-1023,18-Jan-2026,EcoEx Team">
                </div>

                <div class="mb-3">
                    <label>Media Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">
                    Send WhatsApp Message
                </button>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
