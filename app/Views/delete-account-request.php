<?php
use App\Models\CommonModel;
$this->common_model         = new CommonModel;
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquiry Request Deatils</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Favicons -->
    <link href="<?=getenv('app.uploadsURL').$general_settings->site_favicon?>" rel="icon">
    <link href="<?=getenv('app.uploadsURL'.$general_settings->site_favicon)?>" rel="apple-touch-icon">
    <link rel="stylesheet" href="<?=getenv('app.adminAssetsURL')?>lightbox/lightbox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .tablelook {
        padding-top: 10px;
        padding-bottom: 10px;
        border: 1px solid #dddd;
    }
    ul.d-flex.whatimgs {
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
    }
    .whatimgs li {
        margin: 5px;
    }
    .whatimgs img.example-image {
        max-width: 60px;
        border: 1px solid #999;
        height: 60px;
        width: 100%;
    }
    </style>
</head>
<body>
<div class="container mt-4">

    <h3 class="text-center">
        <img src="<?=getenv('app.uploadsURL').$general_settings->site_logo?>" alt="<?=$general_settings->site_name?>">
        <p class="mt-3">Delete Account Request</p>
    </h3>
    <div class=" justify-content-center d-flex">
        <div class="row col-md-8 col-sm-12 col-xs-12">
            <form method="POST" action="" style="border: 1px solid #48974e73;padding: 15px;border-radius: 5px;">
                <div class="form-group mb-3">
                    <label for="company_name" class="fw-bold">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="Email" class="fw-bold">Email</label>
                    <input type="text" class="form-control" id="Email" name="Email" placeholder="Email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="otp" class="fw-bold">OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="OTP" maxlength="4" required>
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="fw-bold">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" maxlength="10" minlength="10" required>
                </div>
                <div class="form-group mb-3">
                    <label for="address" class="fw-bold">Address</label>
                    <textarea class="form-control" id="address" name="address" placeholder="Address" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>  
    
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    
<script src="<?=getenv('app.adminAssetsURL')?>lightbox/lightbox.js"></script>
<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
</body>
</html>