<div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex justify-content-center py-4">
                        <a href="<?=base_url('admin/')?>" class="logo d-flex align-items-center w-auto">
                        <img src="<?=getenv('app.uploadsURL').$general_settings->site_logo?>" alt="<?=$general_settings->site_name?>">
                        </a>
                    </div>
                    <!-- End Logo -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Retrieve to Your Account</h5>
                                <p class="text-center small">Enter otp to reset</p>
                            </div>
                            <?php if($session->getFlashdata('success_message')){?>
                            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                                <?=$session->getFlashdata('success_message')?>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php }?>
                            <?php if($session->getFlashdata('error_message')){?>
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                                <?=$session->getFlashdata('error_message')?>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php }?>
                            <form class="row g-3" method="POST" action="">
                                <div class="col-12">
                                    <label for="otp" class="form-label">OTP</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-key"></i></span>
                                        <input type="number" name="otp" class="form-control" id="otp" required>
                                        <div class="invalid-feedback">Please enter your OTP.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success w-100" type="submit">Submit</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0">Already Have Account? <a href="<?=base_url('/admin/')?>">Sign In</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="credits">
                        Maintained by <a href="https://keylines.net/">Keylines Digitech Pvt. Ltd.</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>