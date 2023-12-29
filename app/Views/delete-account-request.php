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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <style type="text/css">    
        .toast-success {
            background-color: #000;
            color: #28a745 !important;
        }
        .toast-error {
            background-color: #000;
            color: #dc3545 !important;
        }
        .toast-warning {
            background-color: #000;
            color: #ffc107 !important;
        }
        .toast-info {
            background-color: #000;
            color: #007bff !important;
        }
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
                <?php if(session('success_message')){?>
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?=session('success_message')?>
                    </div>
                <?php }?>
                <?php if(session('error_message')){?>
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?=session('error_message')?>
                    </div>
                <?php }?>
                <input type="hidden" name="entity_name" id="entity_name">
                <div class="form-group mb-3">
                    <p class="fw-bold">Select User Type</p>
                    <input type="radio" id="user_type1" name="user_type" value="COMPANY" checked required><label for="user_type1" style="margin-left: 5px; margin-right: 10px;">COMPANY</label>
                    <input type="radio" id="user_type2" name="user_type" value="PLANT" required><label for="user_type2" style="margin-left: 5px; margin-right: 10px;">PLANT</label>
                    <input type="radio" id="user_type3" name="user_type" value="VENDOR" required><label for="user_type3" style="margin-left: 5px; margin-right: 10px;">VENDOR</label>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="fw-bold">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                    <button type="button" class="btn btn-primary btn-sm" id="email-otp-btn">Get Email OTP</button>
                    <input type="hidden" name="generated_email_otp" id="generated_email_otp">
                </div>
                <div class="form-group mb-3" id="email_otp_row">
                    <label for="email_otp" class="fw-bold">Email OTP</label>
                    <input type="text" class="form-control" id="email_otp" name="email_otp" placeholder="Email OTP" maxlength="6" minlength="6" required onkeypress="return isNumber(event)">
                    <button type="button" class="btn btn-info btn-sm" id="email-validate-btn">Validate Email OTP</button>
                    <input type="hidden" name="is_email_verify" id="is_email_verify" value="0">
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="fw-bold">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" maxlength="10" minlength="10" required onkeypress="return isNumber(event)">
                    <button type="button" class="btn btn-primary btn-sm" id="phone-otp-btn">Get Phone OTP</button>
                    <input type="hidden" name="generated_phone_otp" id="generated_phone_otp">
                </div>
                <div class="form-group mb-3" id="phone_otp_row">
                    <label for="phone_otp" class="fw-bold">Phone OTP</label>
                    <input type="text" class="form-control" id="phone_otp" name="phone_otp" placeholder="Phone OTP" maxlength="6" minlength="6" required onkeypress="return isNumber(event)">
                    <button type="button" class="btn btn-info btn-sm" id="phone-validate-btn">Validate Email OTP</button>
                    <input type="hidden" name="is_phone_verify" id="is_phone_verify" value="0">
                </div>
                <div class="form-group mb-3">
                    <label for="comments" class="fw-bold">Comments</label>
                    <textarea class="form-control" id="comments" name="comments" placeholder="Comments" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-success" id="submit-btn"><i class="fa fa-paper-plane"></i> Submit</button>
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
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script type="text/javascript">
    function toastAlert(type, message, redirectStatus = false, redirectUrl = ''){
        toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            "showDuration": "3000",
            "hideDuration": "1000000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr[type](message);
        if(redirectStatus){        
            setTimeout(function(){ window.location = redirectUrl; }, 3000);
        }
    }
    $(function(){
        $('#email_otp_row').hide();
        $('#phone_otp_row').hide();
        $('#submit-btn').attr('disabled', true);

        $('#email-otp-btn').on('click', function(){
            var user_type   = $('input[name="user_type"]:checked').val();
            var email       = $('#email').val();
            if(user_type != ''){
                if(email != ''){
                    let baseUrl = '<?=base_url()?>';
                    $.ajax({
                      type: "POST",
                      data: { user_type: user_type, email: email },
                      url: baseUrl+"/get-email-otp",
                      dataType: "JSON",
                      success: function(res){
                        if(res.success){
                            toastAlert('success', res.message);
                            $('#entity_name').val(res.data.entity_name);
                            $('#generated_email_otp').val(res.data.email_otp);
                            $('#email_otp_row').show();
                        } else {
                            toastAlert('error', res.message);
                        }
                      }
                    });
                } else {
                    toastAlert('error', 'Please Enter Email !!!');
                }
            } else {
                toastAlert('error', 'Please Select User Type !!!');
            }
        });
        $('#email-validate-btn').on('click', function(){
            var generated_email_otp         = parseInt($('#generated_email_otp').val());
            var email_otp                   = parseInt($('#email_otp').val());
            if(generated_email_otp == email_otp){
                toastAlert('success', 'Email OTP Validated !!!');
                $('#is_email_verify').val(1);
                if($('#is_phone_verify').val() == 1){
                    $('#submit-btn').attr('disabled', false);
                }
            } else {
                toastAlert('error', 'Email OTP Mismatched !!!');
                $('#email_otp').val('');
            }
        });

        $('#phone-otp-btn').on('click', function(){
            var user_type   = $('input[name="user_type"]:checked').val();
            var phone       = $('#phone').val();
            if(user_type != ''){
                if(phone != ''){
                    let baseUrl = '<?=base_url()?>';
                    $.ajax({
                      type: "POST",
                      data: { user_type: user_type, phone: phone },
                      url: baseUrl+"/get-phone-otp",
                      dataType: "JSON",
                      success: function(res){
                        if(res.success){
                            toastAlert('success', res.message);
                            $('#entity_name').val(res.data.entity_name);
                            $('#generated_phone_otp').val(res.data.phone_otp);
                            $('#phone_otp_row').show();
                        } else {
                            toastAlert('error', res.message);
                        }
                      }
                    });
                } else {
                    toastAlert('error', 'Please Enter Phone No. !!!');
                }
            } else {
                toastAlert('error', 'Please Select User Type !!!');
            }
        });
        $('#phone-validate-btn').on('click', function(){
            var generated_phone_otp         = parseInt($('#generated_phone_otp').val());
            var phone_otp                   = parseInt($('#phone_otp').val());
            if(generated_phone_otp == phone_otp){
                toastAlert('success', 'Phone OTP Validated !!!');
                $('#is_phone_verify').val(1);
                if($('#is_email_verify').val() == 1){
                    $('#submit-btn').attr('disabled', false);
                }
            } else {
                toastAlert('error', 'Phone OTP Mismatched !!!');
                $('#phone_otp').val('');
            }
        });

    })
</script>
</body>
</html>