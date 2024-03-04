<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];

$userType                   = $session->user_type;
$company_id                 = $session->company_id;
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
              $parent_id        = $row->parent_id;
              $gst_no           = $row->gst_no;
              $gst_certificate  = $row->gst_certificate;
              $company_name     = $row->company_name;
              $plant_name      = $row->plant_name;
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
              $contact_person_name                  = $row->contact_person_name;
              $contact_person_designation           = $row->contact_person_designation;
              $contact_person_document              = $row->contact_person_document;
              $bank_name        = $row->bank_name;
              $branch_name      = $row->branch_name;
              $ifsc_code        = $row->ifsc_code;
              $account_type     = $row->account_type;
              $account_number   = $row->account_number;
              $cancelled_cheque = $row->cancelled_cheque;
            } else {
              $parent_id        = '';
              $gst_no           = '';
              $gst_certificate  = '';
              $company_name     = '';
              $plant_name      = '';
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
              $contact_person_name              = '';
              $contact_person_designation       = '';
              $contact_person_document          = '';
              $bank_name        = '';
              $branch_name      = '';
              $ifsc_code        = '';
              $account_type     = '';
              $account_number   = '';
              $cancelled_cheque = '';
            }
            ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <small class="text-danger">* (star) marks fields are mandatory</small>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="holding_no" id="holding_no" value="<?=$holding_no?>">
                        <input type="hidden" name="location" id="location" value="<?=$location?>">
                        <div class="row mb-3">
                            <?php if($userType == 'MA'){?>
                                <label for="parent_id" class="col-md-2 col-lg-2 col-form-label">Select Company <span class="text-danger">*</span></label>
                                <div class="col-md-10 col-lg-10">
                                    <select class="form-control" name="parent_id" id="parent_id" required>
                                        <option value="" selected>Select Company</option>
                                        <?php if($companyList){ foreach($companyList as $company){?>
                                        <option value="<?=$company->id?>" <?=(($company->id == $parent_id)?'selected':'')?>><?=$company->company_name?></option>
                                        <?php } }?>
                                    </select>
                                </div>
                            <?php } else {?>
                                <input type="hidden" class="form-control" name="parent_id" id="parent_id" value="<?=$company_id?>" required>
                            <?php }?>
                        </div>
                        <div class="row mb-3">
                            <label for="gst_no" class="col-md-2 col-lg-2 col-form-label">GST No. <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="gst_no" class="form-control" id="gst_no" value="<?=$gst_no?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="gst_certificate" class="col-md-2 col-lg-2 col-form-label">GST Certificate</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="file" name="gst_certificate" class="form-control" id="gst_certificate">
                                <small class="text-info">* Only pdf files are allowed</small><br>
                                <?php if($gst_certificate != ''){?>
                                    <a href="<?=getenv('app.uploadsURL').'user/'.$gst_certificate?>" class="badge bg-primary" target="_blank" title="<?=$company_name?>">View Document</a>
                                <?php }?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="company_name" class="col-md-2 col-lg-2 col-form-label">Parent Company Name <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="company_name" class="form-control" id="company_name" value="<?=$company_name?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="plant_name" class="col-md-2 col-lg-2 col-form-label">Plant Name <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="plant_name" class="form-control" id="plant_name" value="<?=$plant_name?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="full_address" class="col-md-2 col-lg-2 col-form-label">Plant Address <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <textarea name="full_address" class="form-control" id="full_address" required><?=$full_address?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="street" class="col-md-2 col-lg-2 col-form-label">Street <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="street" class="form-control" id="street" value="<?=$street?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="district" class="col-md-2 col-lg-2 col-form-label">District <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="district" class="form-control" id="district" value="<?=$district?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="state" class="col-md-2 col-lg-2 col-form-label">State <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="state" class="form-control" id="state" value="<?=$state?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pincode" class="col-md-2 col-lg-2 col-form-label">Pincode <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="pincode" class="form-control" id="pincode" onkeypress="return isNumber(event)" maxlength="6" minlength="6" value="<?=$pincode?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="plant_email" class="col-md-2 col-lg-2 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="email" name="email" class="form-control" id="plant_email" value="<?=$email?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="plant_phone" class="col-md-2 col-lg-2 col-form-label">Phone <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="phone" class="form-control" id="plant_phone" value="<?=$phone?>" onkeypress="return isNumber(event)" maxlength="10" minlength="10" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-2 col-lg-2 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="password" name="password" class="form-control" id="password" maxlength="15" minlength="8" <?=(($row)?'':'required')?>>
                                <?php if($row){?>
                                    <small class="text-info">* Please leave blank when you dont want to change password</small><br>
                                <?php }?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="profile_image" class="col-md-2 col-lg-2 col-form-label">Profile Image</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="file" name="profile_image" class="form-control" id="profile_image">
                                <small class="text-info">* Only JPG, JPEG, ICO, SVG, PNG files are allowed</small><br>
                                <?php if($profile_image != ''){?>
                                  <img src="<?=getenv('app.uploadsURL').'user/'.$profile_image?>" alt="<?=$company_name?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                <?php } else {?>
                                  <img src="<?=getenv('app.NO_IMAGE')?>" alt="<?=$company_name?>" class="img-thumbnail" style="width: 130px; height: auto; margin-top: 10px;">
                                <?php }?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_person_name" class="col-md-2 col-lg-2 col-form-label">Designated Person Name <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="contact_person_name" class="form-control" id="contact_person_name" value="<?=$contact_person_name?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="contact_person_designation" class="col-md-2 col-lg-2 col-form-label">Designated Person Designation <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="contact_person_designation" class="form-control" id="contact_person_designation" value="<?=$contact_person_designation?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="contact_person_document" class="col-md-2 col-lg-2 col-form-label">Designated Person PAN Card / Company ID</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="file" name="contact_person_document" class="form-control" id="contact_person_document">
                                <small class="text-info">* Only pdf files are allowed</small><br>
                                <?php if($contact_person_document != ''){?>
                                    <a href="<?=getenv('app.uploadsURL').'user/'.$contact_person_document?>" class="badge bg-primary" target="_blank" title="<?=$company_name?>">View Document</a>
                                <?php }?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="bank_name" class="col-md-2 col-lg-2 col-form-label">Bank Name</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="bank_name" class="form-control" id="bank_name" value="<?=$bank_name?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="branch_name" class="col-md-2 col-lg-2 col-form-label">Branch Name</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="branch_name" class="form-control" id="branch_name" value="<?=$branch_name?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ifsc_code" class="col-md-2 col-lg-2 col-form-label">IFSC Code</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="ifsc_code" class="form-control" id="ifsc_code" value="<?=$ifsc_code?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="account_type" class="col-md-2 col-lg-2 col-form-label">Account Type</label>
                            <div class="col-md-10 col-lg-10">
                                <select name="account_type" class="form-control" id="account_type">
                                    <option value="" selected>Select Account Type</option>
                                    <option value="SAVINGS" <?=(($account_type == 'SAVINGS')?'selected':'')?>>SAVINGS</option>
                                    <option value="CURRENT" <?=(($account_type == 'CURRENT')?'selected':'')?>>CURRENT</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="account_number" class="col-md-2 col-lg-2 col-form-label">Account No.</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" name="account_number" class="form-control" id="account_number" value="<?=$account_number?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cancelled_cheque" class="col-md-2 col-lg-2 col-form-label">Cancelled Cheque</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="file" name="cancelled_cheque" class="form-control" id="cancelled_cheque">
                                <small class="text-info">* Only pdf files are allowed</small><br>
                                <?php if($cancelled_cheque != ''){?>
                                    <a href="<?=getenv('app.uploadsURL').'user/'.$cancelled_cheque?>" class="badge bg-primary" target="_blank" title="<?=$company_name?>">View Document</a>
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