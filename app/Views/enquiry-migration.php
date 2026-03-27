<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enquiry Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e8f5e9; /* Light green background */
        }

        .form-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        .btn-green {
            background-color: #66bb6a;
            color: white;
        }

        .btn-green:hover {
            background-color: #4caf50;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 300px;
            z-index: 9999;
        }

        .autohide {
            transition: opacity 0.5s ease;
        }
    </style>
</head>
<body>

<?php if (session('success_message')) { ?>
    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message autohide" role="alert">
        <?= session('success_message') ?>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
<?php if (session('error_message')) { ?>
    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message autohide" role="alert">
        <?= session('error_message') ?>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<div class="form-container">
    <h4 class="text-center mb-4">Enquiry Form</h4>

    <form method="post" action="">
        
        <div class="mb-3">
            <label class="form-label">Enquiry Number</label>
            <input 
                type="text" 
                name="enquiry_no" 
                id="enquiry_no" 
                class="form-control" 
                placeholder="Enter enquiry number"
                autocomplete="off"
                required
            >
        </div>

        <button type="submit" class="btn btn-green w-100">
            Submit
        </button>

    </form>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    setTimeout(function() {
        $('.autohide').fadeOut('slow');
    }, 3000);
</script>

</body>
</html>