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
    </body>
</html>