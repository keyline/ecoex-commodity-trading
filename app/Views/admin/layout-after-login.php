<!DOCTYPE html>
<html lang="en">
    <head>
        <?=$head?>
    </head>
    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">
            <?=$header?>
        </header>
        <!-- End Header -->
        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">
            <?=$sidebar?>
        </aside>
        <!-- End Sidebar-->
        <main id="main" class="main">
            <?=$maincontent?>
        </main>
        <!-- End #main -->
        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <?=$footer?>
        </footer>
        <!-- End Footer -->
        <a href="javascript:void(0);" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
        <!-- Vendor JS Files -->
        <script src="<?=getenv('app.adminAssetsURL')?>assets/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="<?=getenv('app.adminAssetsURL')?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?=getenv('app.adminAssetsURL')?>assets/vendor/chart.js/chart.umd.js"></script>
        <script src="<?=getenv('app.adminAssetsURL')?>assets/vendor/echarts/echarts.min.js"></script>
        <script src="<?=getenv('app.adminAssetsURL')?>assets/vendor/quill/quill.min.js"></script>
        <script src="<?=getenv('app.adminAssetsURL')?>assets/vendor/simple-datatables/simple-datatables.js"></script>
        <script src="<?=getenv('app.adminAssetsURL')?>assets/vendor/tinymce/tinymce.min.js"></script>
        <script src="<?=getenv('app.adminAssetsURL')?>assets/vendor/php-email-form/validate.js"></script>
        <!-- Template Main JS File -->
        <script src="<?=getenv('app.adminAssetsURL')?>assets/js/main.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.hide-message').delay(5000).fadeOut('slow');
            });
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
                $('#company_email').on('blur', function(){
                    let company_email = $('#company_email').val();
                    let url = '<?=base_url()?>';
                    var settings = {
                      "url": url + "admin/companies/check-email",
                      "method": "POST",
                      "timeout": 0,
                      "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                      },
                      "data": JSON.stringify({
                        "company_email": company_email
                      }),
                    };

                    $.ajax(settings).done(function (response) {
                        response = $.parseJSON(response);
                        if(response.success){
                            toastAlert('success', response.message);
                        } else {
                            toastAlert('error', response.message);
                            $('#company_email').val('');
                        }
                    });
                });
                $('#company_phone').on('blur', function(){
                    let company_phone = $('#company_phone').val();
                    let url = '<?=base_url()?>';
                    var settings = {
                      "url": url + "admin/companies/check-phone",
                      "method": "POST",
                      "timeout": 0,
                      "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                      },
                      "data": JSON.stringify({
                        "company_phone": company_phone
                      }),
                    };

                    $.ajax(settings).done(function (response) {
                        response = $.parseJSON(response);
                        if(response.success){
                            toastAlert('success', response.message);
                        } else {
                            toastAlert('error', response.message);
                            $('#company_phone').val('');
                        }
                    });
                });

                $('#plant_email').on('blur', function(){
                    let plant_email = $('#plant_email').val();
                    let url = '<?=base_url()?>';
                    var settings = {
                      "url": url + "admin/plants/check-email",
                      "method": "POST",
                      "timeout": 0,
                      "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                      },
                      "data": JSON.stringify({
                        "plant_email": plant_email
                      }),
                    };

                    $.ajax(settings).done(function (response) {
                        response = $.parseJSON(response);
                        if(response.success){
                            toastAlert('success', response.message);
                        } else {
                            toastAlert('error', response.message);
                            $('#plant_email').val('');
                        }
                    });
                });
                $('#plant_phone').on('blur', function(){
                    let plant_phone = $('#plant_phone').val();
                    let url = '<?=base_url()?>';
                    var settings = {
                      "url": url + "admin/plants/check-phone",
                      "method": "POST",
                      "timeout": 0,
                      "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                      },
                      "data": JSON.stringify({
                        "plant_phone": plant_phone
                      }),
                    };

                    $.ajax(settings).done(function (response) {
                        response = $.parseJSON(response);
                        if(response.success){
                            toastAlert('success', response.message);
                        } else {
                            toastAlert('error', response.message);
                            $('#plant_phone').val('');
                        }
                    });
                });

                $('#vendor_email').on('blur', function(){
                    let vendor_email = $('#vendor_email').val();
                    let url = '<?=base_url()?>';
                    var settings = {
                      "url": url + "admin/vendors/check-email",
                      "method": "POST",
                      "timeout": 0,
                      "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                      },
                      "data": JSON.stringify({
                        "vendor_email": vendor_email
                      }),
                    };

                    $.ajax(settings).done(function (response) {
                        response = $.parseJSON(response);
                        if(response.success){
                            toastAlert('success', response.message);
                        } else {
                            toastAlert('error', response.message);
                            $('#vendor_email').val('');
                        }
                    });
                });
                $('#vendor_phone').on('blur', function(){
                    let vendor_phone = $('#vendor_phone').val();
                    let url = '<?=base_url()?>';
                    var settings = {
                      "url": url + "admin/vendors/check-phone",
                      "method": "POST",
                      "timeout": 0,
                      "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                      },
                      "data": JSON.stringify({
                        "vendor_phone": vendor_phone
                      }),
                    };

                    $.ajax(settings).done(function (response) {
                        response = $.parseJSON(response);
                        if(response.success){
                            toastAlert('success', response.message);
                        } else {
                            toastAlert('error', response.message);
                            $('#vendor_phone').val('');
                        }
                    });
                });
            })
        </script>
    </body>
</html>