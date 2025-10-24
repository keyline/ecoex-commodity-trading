<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];

$userType                   = $session->user_type;
//$company_id                 = $session->company_id;
?>
<style type="text/css">
    .status-badge {
            font-size: 0.85rem;
            padding: 0.35rem 0.75rem;
        }
        .nav-tabs .nav-link {
            color: #495057;
            border: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        .nav-tabs .nav-link:hover {
            border-bottom-color: #667eea;
        }
        .nav-tabs .nav-link.active {
            color: #667eea;
            background: transparent;
            border-bottom-color: #667eea;
            font-weight: 600;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
        }
        .info-value {
            color: #6c757d;
        }
        .stat-card {
            border-left: 4px solid;
        }
        .stat-card.interested {
            border-left-color: #28a745;
        }
        .stat-card.not-interested {
            border-left-color: #dc3545;
        }
        .stat-card.pending {
            border-left-color: #ffc107;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .action-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

</style>
<div class="container-fluid">
    <div class="pagetitle">
        <h1><?= $page_header ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $page_header ?></li>
            </ol>
        </nav>
    </div>
</div>
<section class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php if (session('success_message')) { ?>
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('success_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if (session('error_message')) { ?>
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('error_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="mb-1">Enquiry Details</h2>
                                <!-- <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Enquiries</a></li>
                                        <li class="breadcrumb-item active">ENQ-2025-001</li>
                                    </ol>
                                </nav> -->
                            </div>
                            <div>
                                <!-- <button class="btn btn-outline-primary me-2"><i class="bi bi-printer"></i> Print</button> -->
                                <a class="btn btn-primary" href="<?= base_url('admin/whatsapp/logs') ?>"><i class="bi bi-whatsapp"></i> Resend Notifications</a>
                            </div>
                        </div>
                        <!-- Enquiry Status Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        
</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <span class="info-label">Enquiry ID:</span>
                                                <span class="info-value"><?= $items[0]['enquiry_no'] ?></span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="info-label">Product:</span>
                                                <span class="info-value"><?= implode(', ', array_map(fn ($r) => "{$r['material']}", $items)) ?></span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="info-label">Quantity:</span>
                                                <span class="info-value"><?= implode(', ', array_map(fn ($r) => "{$r['qty']} {$r['unit_name']}", $items)) ?></span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="info-label">Plant Location:</span>
                                                <span class="info-value"><?= $items[0]['district'] . ', ' . $items[0]['state'] ?></span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="info-label">Created On:</span>
                                                <span class="info-value"><?= date_format(date_create($items[0]['created_at']), 'd-m-Y h:i A') ?></span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="info-label">Status:</span>
                                                <span class="badge bg-success status-badge"><?= $items[0]['status'] > 0 && $items[0]['status'] != 12 && $items[0]['status'] != 13 ? 'Active' : 'Inactive' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-3">Notification Coverage</h6>
                                            <div class="d-flex justify-content-around">
                                                <div>
                                                    <div class="text-primary fs-3 fw-bold"><?= $notificationStats['summary']['state_wise']['total_notified'] ?? 0 ?></div>
                                                    <small class="text-muted">State-wise</small>
                                                </div>
                                                <div class="vr"></div>
                                                <div>
                                                    <div class="text-info fs-3 fw-bold"><?= $notificationStats['summary']['pan_india']['total_notified'] ?? 0 ?></div>
                                                    <small class="text-muted">Pan India</small>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-4" id="enquiryTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                <i class="bi bi-grid-3x3-gap"></i> Overview
                            </button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="interested-tab" data-type="interested" data-bs-toggle="tab" data-bs-target="#interested" type="button" role="tab">
                                <i class="bi bi-hand-thumbs-up"></i> Interested <span class="badge bg-success ms-2"><?= esc($notificationStats['coverage'][0]['interested_count']  ?? 0) ?></span>
                            </button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="not-interested-tab" data-type="not_interested" data-bs-toggle="tab" data-bs-target="#not-interested" type="button" role="tab">
                                <i class="bi bi-hand-thumbs-down"></i> Not Interested <span class="badge bg-danger ms-2"><?= esc($notificationStats['coverage'][0]['not_interested_count']  ?? 0) ?></span>
                            </button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pending-tab" data-type="pending" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                                <i class="bi bi-clock-history"></i> Pending <span class="badge bg-warning ms-2"><?= esc($notificationStats['pending'] ?? 0) ?></span>
                            </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="enquiryTabsContent">
                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <!-- TODO: Place your existing overview content or partial view here -->
                            <div class="row">
                                <!-- Statistics Cards -->
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card interested shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-muted mb-1">Interested</h6>
                                                    <h3 class="mb-0 text-success"><?= esc($notificationStats['coverage']['interested_count'] ?? 0) ?></h3>
                                                </div>
                                                <i class="bi bi-hand-thumbs-up fs-1 text-success opacity-25"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card not-interested shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-muted mb-1">Not Interested</h6>
                                                    <h3 class="mb-0 text-danger"><?= esc($notificationStats['coverage']['not_interested_count'] ?? 0) ?></h3>
                                                </div>
                                                <i class="bi bi-hand-thumbs-down fs-1 text-danger opacity-25"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card pending shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-muted mb-1">Pending Response</h6>
                                                    <h3 class="mb-0 text-warning"><?= esc($notificationStats['pending'] ?? 0) ?></h3>
                                                </div>
                                                <i class="bi bi-clock-history fs-1 text-warning opacity-25"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-muted mb-1">Total Notified</h6>
                                                    <h3 class="mb-0 text-primary"><?= esc($notificationStats['total']  ?? 0) ?></h3>
                                                </div>
                                                <i class="bi bi-send fs-1 text-primary opacity-25"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Quick Summary -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <i class="bi bi-diagram-3"></i> Notification Distribution
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td><i class="bi bi-geo-alt text-primary"></i> State-wise (<?= esc($items[0]['state'] ?? '') ?>)</td>
                                                        <td class="text-end"><strong><?= esc($notificationStats['distribution']['statewise']['vendor_count']) ?> Vendors</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="bi bi-geo-alt text-info"></i> Pan India</td>
                                                        <td class="text-end"><strong><?= esc($notificationStats['distribution']['pan_india']['vendor_count']) ?> Vendors</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="bi bi-person-check text-success"></i> Subscribers</td>
                                                        <td class="text-end"><strong><?= esc($notificationStats['distribution']['statewise']['subscriber_count'] ?? 0) ?> Users</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <i class="bi bi-clipboard-data"></i> Response Rate
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span>Interested (<?= $notificationStats['interested_rate']?>%)</span>
                                                    <span class="text-success"><?= $notificationStats['coverage'][0]['interested_count']?>/<?= $notificationStats['total']?></span>
                                                </div>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" style="width: <?= $notificationStats['interested_rate'] ?>%"><?= $notificationStats['interested_rate']?>%</div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span>Not Interested (<?= $notificationStats['not_interested_rate']?>%)</span>
                                                    <span class="text-danger"><?= $notificationStats['coverage'][0]['interested_count']?>/<?= $notificationStats['total']?></span>
                                                </div>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-danger" style="width: <?= $notificationStats['not_interested_rate'] ?>%"><?= $notificationStats['not_interested_rate']?>%</div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span>Pending (<?= $notificationStats['pending_rate']?>%)</span>
                                                    <span class="text-warning"><?= $notificationStats['pending']?>/<?= $notificationStats['total']?></span>
                                                </div>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-warning" style="width: <?= $notificationStats['pending_rate'] ?>%"><?= $notificationStats['pending_rate']?>%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>

                            <!-- Interested / Not Interested / Pending Tabs -->
                            <div class="tab-pane fade" id="interested" role="tabpanel">
                                <!-- Filter Buttons -->
                                 <input type="hidden" id="jobId" value="<?= esc($items[0]['enquiry_id']) ?>">
                                

                                <div id="interestedContainer">
                                    <!-- Your existing table + filter HTML goes here -->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="not-interested" role="tabpanel">
                                <input type="hidden" id="jobId" value="<?= esc($items[0]['enquiry_id']) ?>">
                                <div id="notInterestedContainer">
                                    <!-- Reuse same structure but will be replaced via JS -->
                                </div>

                                
                            </div>
                            <div class="tab-pane fade" id="pending" role="tabpanel">
                                <!-- Filter Buttons -->
                                 <input type="hidden" id="jobId" value="<?= esc($items[0]['enquiry_id']) ?>">
                                

                                <div id="pendingContainer">
                                    <!-- Reuse same structure but will be replaced via JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
  const jobId = document.getElementById('jobId').value;
  let state = {
    interested: { page: 1, perPage: 5, filter: 'all', search: '' },
    not_interested: { page: 1, perPage: 5, filter: 'all', search: '' },
    pending: { page: 1, perPage: 5, filter: 'all', search: '' }
  };

  document.querySelectorAll('.nav-link[data-type]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', e => {
      const type = e.target.dataset.type;
      if (['interested', 'not_interested', 'pending'].includes(type)) {
        loadTab(type);
      }
    });
  });

  //loadTab('interested'); // default load

  async function loadTab(type) {
    const container = document.getElementById(typeToContainer(type));
    const s = state[type];
    container.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-success"></div> Loading ${type}...</div>`;

    const params = new URLSearchParams({
      job_id: jobId,
      type: type,
      page: s.page,
      per_page: s.perPage,
      filter: s.filter,
      search: s.search
    });

    const res = await fetch(`/admin/notification-report/tabdata?${params.toString()}`);
    const json = await res.json();
    if (json.status !== 'success') {
      container.innerHTML = `<div class="alert alert-danger">${json.message}</div>`;
      return;
    }
    container.innerHTML = renderPaginatedTable(json.data, json, type);
  }

  function typeToContainer(type) {
    return {
      interested: 'interestedContainer',
      not_interested: 'notInterestedContainer',
      pending: 'pendingContainer'
    }[type];
  }

  function renderPaginatedTable(data, meta, type) {
    const vendorCount = data.filter(r => r.type === 'Vendor').length;
    const subscriberCount = data.filter(r => r.type === 'Subscriber').length;
    const totalCount = meta.count;

    return `
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-outline-success filter-btn" data-filter="all">
            <i class="bi bi-grid-3x3"></i> All (${totalCount})
          </button>
          <button type="button" class="btn btn-outline-success filter-btn" data-filter="vendor">
            <i class="bi bi-people"></i> Vendors (${vendorCount})
          </button>
          <button type="button" class="btn btn-outline-success filter-btn" data-filter="subscriber">
            <i class="bi bi-person-check"></i> Subscribers (${subscriberCount})
          </button>
        </div>
        <div><input type="text" class="form-control form-control-sm search-input" placeholder="Search by name, phone..." value="${state[type].search}"></div>
      </div>
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Type</th><th>Name / Company</th><th>Contact</th>
                  <th>Location</th><th>Product</th>
                  <th>Response Time</th><th>Action</th>
                </tr>
              </thead>
              <tbody>${data.map(r => renderRow(r)).join('')}</tbody>
            </table>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">Page ${meta.page} of ${meta.total_pages}</small>
            ${renderPagination(meta, type)}
          </div>
        </div>
      </div>`;
  }

  function renderPagination(meta, type) {
    let html = `<nav><ul class="pagination pagination-sm mb-0">`;
    html += `<li class="page-item ${meta.page === 1 ? 'disabled' : ''}">
              <a href="#" class="page-link" data-page="${meta.page - 1}" data-type="${type}">Previous</a></li>`;
    for (let i = 1; i <= meta.total_pages; i++) {
      html += `<li class="page-item ${i === meta.page ? 'active' : ''}">
                <a href="#" class="page-link" data-page="${i}" data-type="${type}">${i}</a></li>`;
    }
    html += `<li class="page-item ${meta.page === meta.total_pages ? 'disabled' : ''}">
              <a href="#" class="page-link" data-page="${meta.page + 1}" data-type="${type}">Next</a></li>`;
    html += `</ul></nav>`;
    return html;
  }

  function renderRow(r) {
    return `
      <tr>
        <td><span class="badge ${r.type === 'Vendor' ? 'bg-primary' : 'bg-secondary'}">${r.type}</span></td>
        <td><strong>${r.company_name ?? '-'}</strong></td>
        <td><i class="bi bi-telephone"></i> ${r.phone}<br>
            <small class="text-muted"><i class="bi bi-whatsapp text-success"></i> ${r.phone}</small></td>
        <td>${r.state ?? '-'}</td>
        <td>${r.product ?? '-'}</td>
        <td><small>${r.response_time ?? '-'}</small></td>
        <td><button class="btn btn-sm btn-outline-primary"><i class="bi bi-telephone"></i></button>
            
      </tr>`;
  }

  // Handle pagination click
  document.addEventListener('click', e => {
    const link = e.target.closest('.pagination a.page-link');
    if (!link) return;
    e.preventDefault();
    const type = link.dataset.type;
    const newPage = parseInt(link.dataset.page);
    state[type].page = newPage;
    loadTab(type);
  });

  // Handle filter click
  document.addEventListener('click', e => {
    const btn = e.target.closest('.filter-btn');
    if (!btn) return;
    const type = document.querySelector('.tab-pane.active').id.replace('-', '_');
    state[type].filter = btn.dataset.filter;
    state[type].page = 1;
    loadTab(type);
  });

  // Handle search input
  document.addEventListener('input', e => {
    if (!e.target.classList.contains('search-input')) return;
    const type = document.querySelector('.tab-pane.active').id.replace('-', '_');
    state[type].search = e.target.value.trim();
    state[type].page = 1;
    clearTimeout(state[type].searchDelay);
    state[type].searchDelay = setTimeout(() => loadTab(type), 500);
  });
});


</script>