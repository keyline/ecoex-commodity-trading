<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;
?>
<style>
    .cert-tabs .nav-link {
        font-weight: 600;
        border: 2px solid #d8d8d8;
        margin-right: 10px;
        border-radius: 8px;
        color: #333;
    }

    .cert-tabs .nav-link.active {
        background: #0d6efd;
        color: #fff !important;
        border-color: #0d6efd;
    }

    .upload-btn-corner {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
    }

    .upload-btn-corner .btn {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #198754;
        background: #fff;
        transition: all 0.3s ease;
    }

    .upload-btn-corner .btn:hover {
        background: #198754;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(25, 135, 84, 0.3);
    }

    .upload-btn-corner .btn i {
        font-size: 18px;
        color: #198754;
    }

    .upload-btn-corner .btn:hover i {
        color: #fff;
    }
</style>
<div class="container-fluid">
    <div class="pagetitle">
        <h1><?= $page_header ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li>
                <li class="breadcrumb-item active"><?= $page_header ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container py-4">
                            <div class="row justify-content-between">
                                <div class="col-md-6">
                                    <h5 class="card-titles mb-3">
                                        <strong>Monthly Certificates : <?= $company_name ?></strong>
                                    </h5>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group shadow-sm rounded-pill" style="overflow: hidden; max-width: 300px;float: right;">
                                        <input type="text" class="form-control border-0" placeholder="Search here" aria-label="Search" id="myInput">
                                        <span class="input-group-text bg-white border-0">
                                            <i class="bi bi-search"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <h5 class="card-titles mb-3">
                                        <a href="<?= base_url('admin/companies/upload-certificate/' . encoded($company_id)) ?>" class="btn btn-outline-success"><i class="fa fa-upload"></i> Upload Certificates</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="container py-4">
                            <ul class="nav nav-tabs cert-tabs mb-4" id="certificateTabs" role="tablist">
                                <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pending">Pending</button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#review">Review</button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#approved">Approved</button></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="pending">
                                    <div class="container py-4">
                                        <div class="row g-4" id="item-list">
                                            <?php
                                            $found = 0;
                                            if (!empty($certificates)) {
                                                foreach ($certificates as $certificate) {

                                                    if ($certificate->certificate_type != 1) {
                                                        continue;
                                                    }

                                                    $certificateModel = new \App\Models\CertificateModel();
                                                    $certificateData = $certificateModel->getCertificateByEnquiry($certificate->enquiry_id);

                                                    if ($certificateData['status'] == 'pending') {
                                                        $found++;
                                            ?>
                                                        <div class="col-md-4 productList">
                                                            <div class="card card-custom p-3">
                                                                <div class="card-body">
                                                                    <h6 class="text-muted mb-2 border-bottom">
                                                                        <?php
                                                                        if ($certificate->certificate_type) {
                                                                            $join[0] = ['table' => 'ecomm_users', 'field' => 'id', 'table_master' => 'ecomm_enquires', 'field_table_master' => 'plant_id', 'type' => 'inner'];
                                                                            $getEnquiryPlant = $common_model->find_data('ecomm_enquires', 'row', ['ecomm_enquires.id' => $certificate->enquiry_id], 'ecomm_users.plant_name', $join);

                                                                            echo (($getEnquiryPlant)?$getEnquiryPlant->plant_name:'');
                                                                        }
                                                                        ?>
                                                                    </h6>
                                                                    <small><?= $certificateData['enquiry_no'] ?></small>
                                                                    <h5 class="fw-bold mb-0"><?= $certificate->created_at ?></h5>

                                                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                                                        <a target="_blank" href="<?= base_url('admin/certificates/' . $certificateData['id']) ?>" class="text-decoration-none text-viewcolor">View</a>
                                                                        <a target="_blank" href="<?= base_url('admin/certificates/' . $certificateData['id'] . '/pdf/download') ?>" download="">
                                                                            <button class="btn btn-download download-icon px-3">Download</button>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                            <?php
                                                    }
                                                }
                                            }

                                            if ($found == 0) {
                                                echo '<h5 class="card-titles mb-3">There are no pending certificates</h5>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="review">
                                    <div class="container py-4">
                                        <div class="row g-4" id="item-list">
                                            <?php
                                            $found = 0;
                                            if (!empty($certificates)) {
                                                foreach ($certificates as $certificate) {

                                                    if ($certificate->certificate_type != 1) {
                                                        continue;
                                                    }

                                                    $certificateModel = new \App\Models\CertificateModel();
                                                    $certificateData = $certificateModel->getCertificateByEnquiry($certificate->enquiry_id);

                                                    if ($certificateData['status'] == 'review') {
                                                        $found++;
                                            ?>
                                                        <div class="col-md-4 productList">
                                                            <div class="card card-custom p-3">
                                                                <!-- <div class="upload-btn-corner">
                                    <a href="<?= base_url('admin/certificates/upload/certificate/' . encoded($company_id)) . '/' . encoded($certificate->enquiry_id) ?>" class="btn btn-outline-success" title="Upload New Certificate">
                                        <i class="fa fa-upload"></i>
                                    </a>
                                </div> -->

                                                                <div class="card-body">
                                                                    <h6 class="text-muted mb-2 border-bottom">
                                                                        <?php
                                                                        if ($certificate->certificate_type) {
                                                                            $join[0] = ['table' => 'ecomm_users', 'field' => 'id', 'table_master' => 'ecomm_enquires', 'field_table_master' => 'plant_id', 'type' => 'inner'];
                                                                            $getEnquiryPlant = $common_model->find_data('ecomm_enquires', 'row', ['ecomm_enquires.id' => $certificate->enquiry_id], 'ecomm_users.plant_name', $join);

                                                                            echo (($getEnquiryPlant)?$getEnquiryPlant->plant_name:'');
                                                                        }
                                                                        ?>
                                                                    </h6>
                                                                    <small><?= $certificateData['enquiry_no'] ?></small>
                                                                    <h5 class="fw-bold mb-0"><?= $certificate->created_at ?></h5>

                                                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                                                        <a target="_blank" href="<?= base_url('admin/certificates/' . $certificateData['id']) ?>" class="text-decoration-none text-viewcolor">View</a>
                                                                        <a target="_blank" href="<?= base_url('admin/certificates/' . $certificateData['id'] . '/pdf/download') ?>" download="">
                                                                            <button class="btn btn-download download-icon px-3">Download</button>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                            <?php
                                                    }
                                                }
                                            }

                                            if ($found == 0) {
                                                echo '<h5 class="card-titles mb-3">There are no certificates for review</h5>';
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="approved">
                                    <!-- <p>No approved certificates yet.</p> -->
                                    <div class="container py-4">
                                        <div class="row g-4" id="item-list">
                                            <?php if (!empty($certificates)) { ?>
                                                <!-- Empty Card -->
                                                <div class="col-md-4">
                                                    <div class="card card-custom card-empty">
                                                        <div class="card-body">
                                                            <a target="_blank" href="<?= base_url('admin/companies/certificate/download-all-zip/' . encoded($company_id)) ?>">
                                                                <button class="btn btn-download mb-2">Download Zip File</button>
                                                                <!-- <div class="text-muted">View Zip File</div> -->
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($certificates) {
                                                foreach ($certificates as $certificate) { ?>
                                                    <!-- Repeated Card -->

                                                    <!-- <div class="text-muted">Invoice No</div>
                                                            <h5 class="fw-bold mt-3 mb-0">128283</h5>
                                                            <div class="text-muted">Certificate No</div> -->
                                                    <?php
                                                    if ($certificate->certificate_type == 1) {
                                                        $certificateModel = new \App\Models\CertificateModel();
                                                        $certificateData = $certificateModel->getCertificateByEnquiry($certificate->enquiry_id);
                                                        if ($certificateData['status'] == 'approved') {

                                                    ?>
                                                            <div class="col-md-4 productList">
                                                                <div class="card card-custom p-3">
                                                                    <div class="card-body">
                                                                        <h6 class="text-muted mb-2 border-bottom">
                                                                            <?php
                                                                            if ($certificate->certificate_type) {
                                                                                $join[0] = ['table' => 'ecomm_users', 'field' => 'id', 'table_master' => 'ecomm_enquires', 'field_table_master' => 'plant_id', 'type' => 'inner'];
                                                                                $getEnquiryPlant = $common_model->find_data('ecomm_enquires', 'row', ['ecomm_enquires.id' => $certificate->enquiry_id], 'ecomm_users.plant_name', $join);

                                                                                echo (($getEnquiryPlant)?$getEnquiryPlant->plant_name:'');
                                                                            }
                                                                            ?>
                                                                        </h6>
                                                                        <small><?= $certificateData['enquiry_no'] ?></small>
                                                                        <h5 class="fw-bold mb-0"><?= $certificate->created_at ?></h5>
                                                                        <div class="d-flex justify-content-between align-items-center mt-4">
                                                                            <a target="_blank" href="<?= base_url('admin/certificates/' . $certificateData['id']) ?>" class="text-decoration-none text-viewcolor">View</a>
                                                                            <a target="_blank" href="<?= base_url('admin/certificates/' . $certificateData['id'] . '/pdf/download') ?>" download=""><button class="btn btn-download download-icon px-3">Download</button></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="col-md-4 productList">
                                                            <div class="card card-custom p-3">
                                                                <div class="card-body">
                                                                    <h6 class="text-muted mb-2 border-bottom"><?= $certificate->filename ?></h6>
                                                                    <h5 class="fw-bold mb-0"><?= $certificate->created_at ?></h5>
                                                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                                                        <a target="_blank" href="<?= base_url('public/uploads/certificate/' . $certificate->certificate_file) ?>" class="text-decoration-none text-viewcolor">View</a>
                                                                        <a target="_blank" href="<?= base_url('public/uploads/certificate/' . $certificate->certificate_file) ?>" download=""><button class="btn btn-download download-icon px-3">Download</button></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                <?php }
                                            } else { ?>
                                                <p>There are no certificate found with approved status</p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Sales -->
        <!-- End Recent Sales -->
</section>
<style>
    .border-bottom {
        border-bottom: 1px solid #e0e0e0 !important;
    }

    .card-custom {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
        border-radius: 12px;
        transition: 0.3s;
        /* min-height: 260px; */
        min-height: 185px;
        border: 1px solid #e3e3e3;
        background: #ebebeb;
    }

    .btn-download {
        background-color: #198754;
        color: #fff;
        border-radius: 6px;
    }

    .btn-download:hover {
        background-color: #00795f;
        color: #fff;
    }

    .text-viewcolor {
        color: #198754;
    }

    .card-body {
        font-size: 14px;
    }

    .download-icon::after {
        content: "➔";
        margin-left: 6px;
    }

    .card-empty {
        background-color: #fff;
        text-align: center;
        padding: 2rem 1rem;
    }

    .card-empty .card-body {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myInput").on("input", function() {
            var value = $(this).val().toLowerCase();
            //alert(value);
            $("#item-list .productList").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('.components > li > a').on('click', function() {
            $(this).parent('li').toggleClass('active');
        });

    });
</script>