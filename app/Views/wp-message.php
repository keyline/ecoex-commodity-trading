<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= esc($title) ?></title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4fff6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wp-card {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .wp-header {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            color: #fff;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }

        .wp-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            color: #2e7d32;
        }

        .btn-green {
            background: #2e7d32;
            border-color: #2e7d32;
            font-weight: 600;
        }

        .btn-green:hover {
            background: #256528;
            border-color: #256528;
        }

        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card wp-card">
                    <div class="wp-header">
                        <h4><?= esc($page_header) ?></h4>
                        <small>Send WhatsApp Message</small>
                    </div>

                    <div class="card-body p-4">
                        <form action="" method="post" enctype="multipart/form-data">

                            <?= csrf_field() ?>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label class="form-label">Phone No. <span class="text-danger">*</span></label>
                                <input type="tel" name="phone_no" class="form-control"
                                    placeholder="Enter phone number" required>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label class="form-label">Image Upload <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>

                            <!-- Params Row 1 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Param 1</label>
                                    <input type="text" name="param1" class="form-control"
                                        placeholder="Param 1">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Param 2</label>
                                    <input type="text" name="param2" class="form-control"
                                        placeholder="Param 2">
                                </div>
                            </div>

                            <!-- Params Row 2 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Param 3</label>
                                    <input type="text" name="param3" class="form-control"
                                        placeholder="Param 3">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Param 4</label>
                                    <input type="text" name="param4" class="form-control"
                                        placeholder="Param 4">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-green btn-lg">
                                    Send Message
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
