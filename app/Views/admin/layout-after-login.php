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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha512-rRQtF4V2wtAvXsou4iUAs2kXHi3Lj9NE7xJR77DE7GHsxgY9RTWy93dzMXgDIG8ToiRTD45VsDNdTiUagOFeZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Template Main JS File -->
        <script src="<?=getenv('app.adminAssetsURL')?>assets/js/main.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.hide-message').delay(5000).fadeOut('slow');
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
        <link rel="stylesheet" href="<?=getenv('app.adminAssetsURL');?>assets/owl/owl3.css">
        <script src="<?=getenv('app.adminAssetsURL');?>assets/owl/owl-min.js"></script>
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


            jQuery(document).ready(function() {
                jQuery("#home-successstories").owlCarousel({
                    loop: true,
                    margin: 0,
                    dots: false,
                    nav: true,
                    autoplay: true,
                    autoplayTimeout: 2000,
                    autoplayHoverPause: true,
                    animateIn: 'fadeIn',
                    animateOut: 'fadeOut',
                    navText: ["<i class='zmdi zmdi-arrow-left'></i>", "<i class='zmdi zmdi-arrow-right'></i>"],
                    responsive: {
                        0: {
                            items: 1,
                        },
                        600: {
                            items: 1,
                        },
                        750: {
                            items: 1,
                        },
                        1000: {
                            items: 1,
                        },
                        1200: {
                            items: 1,
                        }
                    }
                });
            });

            // function getImageModal(enq_id){
            //     let baseUrl = '<?=base_url()?>';
            //     $.ajax({
            //       type: "POST",
            //       data: { enq_id: enq_id },
            //       url: baseUrl+"/admin/get-image-modal",
            //       dataType: "JSON",
            //       success: function(res){
            //         if(res.success){
            //           $('#enquiryImage').modal('show');
            //           $('#enquiryImageTitle').html(res.data.title);
            //           $('#enquiryImageBody').append(res.data.body);
            //         } else {
            //           $('#enquiryImage').modal('hide');
            //           $('#enquiryImageTitle').html('');
            //           $('#enquiryImageBody').html('');
            //         }
            //       }
            //     });
            // }
        </script>
        <script type="text/javascript">
            function copyToClipboard() {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($('#whatsapp_link').text()).select();
                console.log($temp.val($('#whatsapp_link').text()).select());
                document.execCommand("copy");
                $temp.remove();
                toastAlert("success", 'Link Copied To Clipboard !!!');
            }
        </script>
    </body>
</html>