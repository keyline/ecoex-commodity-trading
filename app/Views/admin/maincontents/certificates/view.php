<div class="container-fluid">
    <div class="pagetitle">
        <h1><?= $page_header ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= base_url('admin/certificates/list/') ?>"><?= $title ?> List</a></li>
                <li class="breadcrumb-item active"><?= $page_header ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="section profile">
    <div class="container-fluid">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Certificate Details</h2>
                <div>
                    <a href="<?= base_url('admin/enquiry-requests/list/' . encoded(12)) ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    
                    <?php if ($certificate['status'] === 'pending' || $certificate['status'] === 'review'): ?>
                        <a href="<?= base_url('admin/certificates/' . $certificate['id'] . '/edit') ?>" 
                        class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    <?php endif; ?>
                    <?php if ($certificate['status'] === 'pending'): ?>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#finalizeModal">
                            <i class="fas fa-check"></i> Send For Review
                        </button>
                    <?php endif; ?>

                    <?php if ($certificate['status'] === 'review'): ?>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#finalizeModal_approve">
                            <i class="fas fa-check"></i> Approve Certificate
                        </button>
                    <?php endif; ?>
                    
                    
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-info alert-dismissible fade show">
                    <?= session()->getFlashdata('info') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Main Certificate Information -->
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Certificate Information</h5>
                            <?php if ($certificate['status'] === 'pending' || $certificate['status'] === 'review'): ?>
                                <!-- <span class="badge bg-warning text-dark">Draft - Version <?= $certificate['version'] ?></span> -->
                            <?php else: ?>
                                <span class="badge bg-success">Finalized - Version <?= $certificate['version'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Enquiry Number:</strong><br>
                                    <span class="text-muted"><?= esc($certificate['enquiry_no']) ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Certificate Number:</strong><br>
                                    <span class="text-muted"><?= esc($certificate['certificate_number']) ?></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Company Name:</strong><br>
                                    <span class="text-muted"><?= esc($certificate['company_name']) ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Plant Name:</strong><br>
                                    <span class="text-muted"><?= esc($certificate['plant_name']) ?></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <strong>Plant Address:</strong><br>
                                    <span class="text-muted"><?= nl2br(esc($certificate['plant_address'])) ?></span>
                                </div>
                                <div class="col-md-3">
                                    <strong>State:</strong><br>
                                    <span class="text-muted"><?= esc($certificate['plant_state'] ?? 'N/A') ?></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Collection Date:</strong><br>
                                    <span class="text-muted"><?= date('d M Y', strtotime($certificate['collection_date'])) ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Issue Date:</strong><br>
                                    <span class="text-muted"><?= date('d M Y', strtotime($certificate['issue_date'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Collected -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Items Collected</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Description</th>
                                            <th width="120" class="text-end">Quantity</th>
                                            <th width="80">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($certificate['items'])): ?>
                                            <?php foreach ($certificate['items'] as $index => $item): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= esc($item['item_description'] ?? $item['description']) ?></td>
                                                    <td class="text-end"><?= number_format($item['quantity'], 2) ?></td>
                                                    <td><span class="badge bg-secondary"><?= esc($item['unit']) ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr class="table-light fw-bold">
                                                <td colspan="2" class="text-end">Total Items:</td>
                                                <td class="text-end"><?= count($certificate['items']) ?></td>
                                                <td></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No items found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Shared Vendors -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Shared Vendors</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($certificate['vendors'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th width="100">Vendor ID</th>
                                                <th>Company Name</th>
                                                <th>CTO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($certificate['vendors'] as $index => $vendor): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td>
                                                        <?php if (!empty($vendor['vendor_id'])): ?>
                                                            <span class="badge bg-info"><?= esc($vendor['vendor_id']) ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= esc($vendor['company_name']) ?></td>
                                                    <td><?= esc($vendor['cto'] ?? 'N/A') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">No vendors associated with this certificate</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Status & Audit Info -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Status & Audit</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Status:</strong><br>
                                <?php if ($certificate['status'] === 'pending' || $certificate['status'] === 'review'): ?>
                                    <span class="badge bg-warning text-dark fs-6">
                                        <i class="fas fa-clock"></i> <?php echo ucfirst($certificate['status']); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle"></i> Approved
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- <div class="mb-3">
                                <strong>Version:</strong><br>
                                <span class="text-muted">v<?= $certificate['version'] ?></span>
                            </div> -->

                            <!-- <hr> -->

                            <div class="mb-3">
                                <strong>Created:</strong><br>
                                <span class="text-muted"><?= date('d M Y, h:i A', strtotime($certificate['created_at'])) ?></span>
                            </div>
                            
                            <?php if ($certificate['updated_at']): ?>
                                <div class="mb-3">
                                    <strong>Last Updated:</strong><br>
                                    <span class="text-muted"><?= date('d M Y, h:i A', strtotime($certificate['updated_at'])) ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($certificate['status'] === 'approved' && $certificate['finalized_at']): ?>
                                <div class="mb-3">
                                    <strong>Finalized:</strong><br>
                                    <span class="text-muted"><?= date('d M Y, h:i A', strtotime($certificate['finalized_at'])) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- PDF Preview -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">PDF Document</h5>
                        </div>
                        <div class="card-body text-center">
                            <i class="fas fa-file-pdf fa-5x text-danger mb-3"></i>
                            <p class="text-muted mb-3">
                                <?php if ($certificate['status'] === 'pending' || $certificate['status'] === 'review'): ?>
                                    Preview the certificate as PDF
                                <?php else: ?>
                                    Download the finalized certificate
                                <?php endif; ?>
                            </p>
                            <a href="<?= base_url('admin/certificates/' . $certificate['id'] . '/pdf/view') ?>" 
                            class="btn btn-danger w-100" target="_blank">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>
                    </div>
                    <!-- Word Document -->
                     <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Word Document</h5>
                        </div>
                        <div class="card-body text-center">
                            <i class="fas fa-file-word fa-5x text-primary mb-3"></i>
                            <p class="text-muted mb-3">
                                <?php if ($certificate['status'] === 'pending' || $certificate['status'] === 'review'): ?>
                                    Preview the certificate as Word document
                                <?php else: ?>
                                    Download the finalized certificate
                                <?php endif; ?>
                            </p>
                            <a href="<?= base_url('admin/certificates/' . $certificate['id'] . '/word/view') ?>" 
                            class="btn btn-primary w-100" target="_blank">
                                <i class="fas fa-download"></i> Download Word Document
                            </a>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Quick Stats</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-boxes text-primary"></i> Total Items:</span>
                                <strong><?= count($certificate['items'] ?? []) ?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-users text-success"></i> Total Vendors:</span>
                                <strong><?= count($certificate['vendors'] ?? []) ?></strong>
                            </div>
                            <!-- <div class="d-flex justify-content-between">
                                <span><i class="fas fa-history text-info"></i> Version:</span>
                                <strong>v<?= $certificate['version'] ?></strong>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Finalize Modal -->
<div class="modal fade" id="finalizeModal" tabindex="-1" aria-labelledby="finalizeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizeModalLabel">Send For Review Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </div>
                <p>Are you sure you want to send this certificate for review?</p>
                <!-- <p class="mb-0">Once reviewed:</p>
                <ul>
                    <li>The certificate cannot be edited</li>
                    <li>A final PDF will be generated</li>
                    <li>The status will be permanently set to "Approved"</li>
                </ul> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form method="POST" action="<?= base_url('/admin/certificates/' . $certificate['id'] . '/review') ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Yes, Send For Review Certificate
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Approve modal -->
 <div class="modal fade" id="finalizeModal_approve" tabindex="-1" aria-labelledby="finalizeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizeModalLabel">Approve Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </div>
                <p>Are you sure you want to approve the certificate ?</p>
                <!-- <p class="mb-0">Once reviewed:</p>
                <ul>
                    <li>The certificate cannot be edited</li>
                    <li>A final PDF will be generated</li>
                    <li>The status will be permanently set to "Approved"</li>
                </ul> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form method="POST" action="<?= base_url('/admin/certificates/' . $certificate['id'] . '/finalize') ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Yes, Approve the Certificate
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
// Disable submit buttons in modal forms to prevent double-click
document.addEventListener("submit", function (e) {
    if (e.target.closest(".modal")) {  // only modal forms
        const btn = e.target.querySelector("button[type=submit]");

        if (btn) {
            btn.disabled = true;
            btn.innerHTML = "<span class='spinner-border spinner-border-sm'></span> Processing...";
        }
    }
});
</script>
