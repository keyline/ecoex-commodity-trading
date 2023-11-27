<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <?php if(session('success_message')){?>
            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                <?=session('success_message')?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
            <?php if(session('error_message')){?>
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                <?=session('error_message')?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
        </div>
        <?php
            if($row){
              $gst_no           = $row->gst_no;
              $company_name     = $row->company_name;
              $full_address     = $row->full_address;
              $holding_no       = $row->holding_no;
              $street           = $row->street;
              $district         = $row->district;
              $state            = $row->state;
              $pincode          = $row->pincode;
              $location         = $row->location;
              $email            = $row->email;
              $phone            = $row->phone;
              $password         = $row->password;
              $profile_image    = $row->profile_image;
            } else {
              $gst_no           = '';
              $company_name     = '';
              $full_address     = '';
              $holding_no       = '';
              $street           = '';
              $district         = '';
              $state            = '';
              $pincode          = '';
              $location         = '';
              $email            = '';
              $phone            = '';
              $password         = '';
              $profile_image    = '';
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="gst_no" class="col-md-2 col-lg-2 col-form-label">GST No.</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="gst_no" class="form-control" id="gst_no" value="<?=$gst_no?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="company_name" class="col-md-2 col-lg-2 col-form-label">Company Name</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="company_name" class="form-control" id="company_name" value="<?=$company_name?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="full_address" class="col-md-2 col-lg-2 col-form-label">Full Address</label>
                            <div class="col-md-10 col-lg-10">
                                <textarea name="full_address" class="form-control" id="full_address" required><?=$full_address?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="holding_no" class="col-md-2 col-lg-2 col-form-label">Holding No.</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="holding_no" class="form-control" id="holding_no" value="<?=$holding_no?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="street" class="col-md-2 col-lg-2 col-form-label">Street</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="street" class="form-control" id="street" value="<?=$street?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="district" class="col-md-2 col-lg-2 col-form-label">District</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="district" class="form-control" id="district" value="<?=$district?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="state" class="col-md-2 col-lg-2 col-form-label">State</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="state" class="form-control" id="state" value="<?=$state?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pincode" class="col-md-2 col-lg-2 col-form-label">Pincode</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="pincode" class="form-control" id="pincode" onkeypress="return isNumber(event)" maxlength="6" minlength="6" value="<?=$location?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="location" class="col-md-2 col-lg-2 col-form-label">Location</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="location" class="form-control" id="location" value="<?=$location?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-lg-2 col-form-label">Email</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="email" name="email" class="form-control" id="email" value="<?=$email?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-md-2 col-lg-2 col-form-label">Phone</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="phone" class="form-control" id="phone" value="<?=$phone?>" onkeypress="return isNumber(event)" maxlength="10" minlength="10" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-2 col-lg-2 col-form-label">Password</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="password" class="form-control" id="password" onkeypress="return isNumber(event)" maxlength="15" minlength="8" <?=(($row)?'':'required')?>>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="profile_image" class="col-md-2 col-lg-2 col-form-label">Profile Image</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="file" name="profile_image" class="form-control" id="profile_image">
                                <small class="text-info">* Only JPG, JPEG, ICO, SVG, PNG files are allowed</small><br>
                                <?php if($profile_image != ''){?>
                                  <img src="<?=getenv('app.uploadsURL').'user/'.$profile_image?>" alt="<?=$company_name?>" style="width: 130px; height: auto; margin-top: 10px;">
                                <?php } else {?>
                                  <img src="<?=getenv('app.NO_IMAGE')?>" alt="<?=$company_name?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                <?php }?>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?=(($row)?'Save':'Add')?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#gst_no').on('blur', function(){
            let gst_no = $('#gst_no').val();
            let url = '<?=base_url()?>';
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

            $.ajax(settings).done(function (response) {
                response = $.parseJSON(response);
                console.log(response.success);
                console.log(response.data.trade_name);
                if(response.success){
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