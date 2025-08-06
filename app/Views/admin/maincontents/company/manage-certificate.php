<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;
?>
<div class="container-fluid">
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
                                        <strong>Nourishco Certificates</strong>
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group shadow-sm rounded-pill" style="overflow: hidden; max-width: 300px;float: right;">
                                      <input type="text" class="form-control border-0" placeholder="Search here" aria-label="Search">
                                      <span class="input-group-text bg-white border-0">
                                        <i class="bi bi-search"></i>
                                      </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container py-4">
                          <div class="row g-4">

                            <!-- Repeated Card -->
                            <div class="col-md-4">
                              <div class="card card-custom p-3">
                                <div class="card-body">
                                  <h6 class="text-muted mb-2 border-bottom">Parsva Packers Limited</h6>
                                  <h5 class="fw-bold mb-0">S1938383883</h5>
                                  <div class="text-muted">Invoice No</div>
                                  <h5 class="fw-bold mt-3 mb-0">128283</h5>
                                  <div class="text-muted">Certificate No</div>
                                  <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="#" class="text-decoration-none text-viewcolor">View</a>
                                    <button class="btn btn-download download-icon px-3">Download</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Repeat 4x -->
                            <div class="col-md-4">
                              <div class="card card-custom p-3">
                                <div class="card-body">
                                  <h6 class="text-muted mb-2 border-bottom">Parsva Packers Limited</h6>
                                  <h5 class="fw-bold mb-0">S1938383883</h5>
                                  <div class="text-muted">Invoice No</div>
                                  <h5 class="fw-bold mt-3 mb-0">128283</h5>
                                  <div class="text-muted">Certificate No</div>
                                  <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="#" class="text-decoration-none text-viewcolor">View</a>
                                    <button class="btn btn-download download-icon px-3">Download</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="card card-custom p-3">
                                <div class="card-body">
                                  <h6 class="text-muted mb-2 border-bottom">Parsva Packers Limited</h6>
                                  <h5 class="fw-bold mb-0">S1938383883</h5>
                                  <div class="text-muted">Invoice No</div>
                                  <h5 class="fw-bold mt-3 mb-0">128283</h5>
                                  <div class="text-muted">Certificate No</div>
                                  <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="#" class="text-decoration-none text-viewcolor">View</a>
                                    <button class="btn btn-download download-icon px-3">Download</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="card card-custom p-3">
                                <div class="card-body">
                                  <h6 class="text-muted mb-2 border-bottom">Parsva Packers Limited</h6>
                                  <h5 class="fw-bold mb-0">S1938383883</h5>
                                  <div class="text-muted">Invoice No</div>
                                  <h5 class="fw-bold mt-3 mb-0">128283</h5>
                                  <div class="text-muted">Certificate No</div>
                                  <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="#" class="text-decoration-none text-viewcolor">View</a>
                                    <button class="btn btn-download download-icon px-3">Download</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Empty Card -->
                            <div class="col-md-4">
                              <div class="card card-custom card-empty">
                                <div class="card-body">
                                    <button class="btn btn-download mb-2">Download Zip File</button>
                                    <div class="text-muted">View Zip File</div>
                                </div>
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
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  border: none;
  border-radius: 12px;
  transition: 0.3s;
    min-height: 260px;
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
.text-viewcolor{
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