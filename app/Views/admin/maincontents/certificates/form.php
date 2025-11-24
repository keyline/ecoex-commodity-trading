<style>
.item-row, .vendor-row {
    transition: all 0.3s ease;
}

.item-row:hover, .vendor-row:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card-body {
    padding: 1rem;
}
</style>
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
            <div class="card">
                <div class="card-header">
                    <h3>
                        <?= isset($certificate) ? 'Edit Certificate' : 'Generate Certificate' ?>
                        <?php if (isset($enquiry)): ?>
                            - Enquiry #<?= esc($enquiry['enquiry_no']) ?>
                        <?php elseif (isset($certificate)): ?>
                            - Enquiry #<?= esc($certificate['enquiry_no']) ?>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" 
                        action="<?= isset($certificate) ? base_url('admin/certificates/update/' . $certificate['id']) : base_url('admin/certificates/store') ?>"
                        id="certificateForm">
                        <?= csrf_field() ?>
                        
                        <?php if (isset($certificate)): ?>
                            <input type="hidden" name="_method" value="PUT">
                        <?php endif; ?>

                        <!-- Hidden Enquiry Number -->
                        <input type="hidden" name="enquiry_id" 
                            value="<?= esc($enquiry['enquiry_id'] ?? $certificate['enquiry_id'] ?? '') ?>">
                        <input type="hidden" name="enquiry_no" 
                            value="<?= esc($enquiry['enquiry_no'] ?? $certificate['enquiry_no'] ?? '') ?>"> 
                        <input type="hidden" name="company_id" 
                            value="<?= esc($enquiry['company_id'] ?? $certificate['company_id'] ?? '') ?>"> 

                        <!-- Enquiry & Certificate Info -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Enquiry Number</label>
                                <input type="text" class="form-control bg-light" 
                                    value="<?= esc($enquiry['enquiry_no'] ?? $certificate['enquiry_no'] ?? '') ?>" 
                                    readonly>
                            </div>
                            
                                <div class="col-md-6">
                                    <label class="form-label">Certificate Number (Ref. No.)</label>
                                    <input type="text" name="certificate_number" class="form-control bg-light" 
                                        value="<?= old('certificate_number', $certificate['certificate_number'] ?? '') ?>" 
                                        >
                                </div>
                            
                        </div>

                        <!-- Company Name (Changed from Client Name) -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Name *</label>
                                <input type="text" class="form-control" name="company_name" 
                                    value="<?= old('company_name', $enquiry['company_name'] ?? $certificate['company_name'] ?? '') ?>" 
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plant Name *</label>
                                <input type="text" class="form-control" name="plant_name" 
                                    value="<?= old('plant_name', $enquiry['plant_name'] ?? $certificate['plant_name'] ?? '') ?>" 
                                    required>
                            </div>
                        </div>

                        <!-- Plant Address & State -->
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Plant Address *</label>
                                <textarea class="form-control" name="plant_address" rows="3" required><?= old('plant_address', $enquiry['plant_address'] ?? $certificate['plant_address'] ?? '') ?></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Plant State *</label>
                                <input type="text" class="form-control" name="plant_state" 
                                    value="<?= old('plant_state', $enquiry['plant_state'] ?? $certificate['plant_state'] ?? '') ?>" 
                                    placeholder="e.g., Haryana" 
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Collection Date *</label>
                            <input type="date" class="form-control" name="collection_date" 
                                value="<?= old('collection_date', $enquiry['collection_date'] ?? $certificate['collection_date'] ?? '') ?>" 
                                required>
                        </div>

                        <hr>

                        <!-- Items Section (Editable) -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Items Collected</h5>
                            <button type="button" class="btn btn-success btn-sm" id="addItem">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>

                        <div id="itemsContainer">
                            <?php
                            $items = old('items', $enquiry['items'] ?? $certificate['items'] ?? []);
        if (empty($items)) {
            $items = [['description' => '', 'quantity' => '', 'unit' => 'Kgs']];
        }
        ?>
                            
                            <?php foreach ($items as $index => $item): ?>
                                <div class="item-row card mb-3" data-index="<?= $index ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label">Item Description *</label>
                                                <input type="text" 
                                                    class="form-control" 
                                                    name="items[<?= $index ?>][description]" 
                                                    value="<?= esc($item['description'] ?? $item['item_description'] ?? '') ?>" 
                                                    placeholder="e.g., Empty Plastic Can 25 Ltr Acetic Acid"
                                                    required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Quantity *</label>
                                                <input type="number" 
                                                    step="0.01" 
                                                    class="form-control" 
                                                    name="items[<?= $index ?>][quantity]" 
                                                    value="<?= esc($item['quantity'] ?? '') ?>" 
                                                    placeholder="0"
                                                    required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Unit *</label>
                                                <select class="form-control" name="items[<?= $index ?>][unit]" required>
                                                    <option value="Kgs" <?= ($item['unit'] ?? 'Kgs') === 'Kgs' ? 'selected' : '' ?>>Kgs</option>
                                                    <option value="Nos" <?= ($item['unit'] ?? '') === 'Nos' ? 'selected' : '' ?>>Nos</option>
                                                    <option value="Ltrs" <?= ($item['unit'] ?? '') === 'Ltrs' ? 'selected' : '' ?>>Ltrs</option>
                                                    <option value="Tons" <?= ($item['unit'] ?? '') === 'Tons' ? 'selected' : '' ?>>Tons</option>
                                                    <option value="Pcs" <?= ($item['unit'] ?? '') === 'Pcs' ? 'selected' : '' ?>>Pcs</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-item w-100">
                                                    <i class="fas fa-trash"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <hr>

                        <!-- Vendors Section (Editable) -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Shared Vendors</h5>
                            <button type="button" class="btn btn-success btn-sm" id="addVendor">
                                <i class="fas fa-plus"></i> Add Vendor
                            </button>
                        </div>

                        <div id="vendorsContainer">
                            <?php
        $vendors = old('vendors', $enquiry['shared_vendors'] ?? $certificate['vendors'] ?? []);
        if (empty($vendors)) {
            $vendors = [['vendor_id' => '', 'company_name' => '']];
        }
        ?>
                            
                            <?php foreach ($vendors as $index => $vendor): ?>
                                <div class="vendor-row card mb-3" data-index="<?= $index ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" 
                                                    class="form-control" 
                                                    name="vendors[<?= $index ?>][vendor_id]" 
                                                    value="<?= esc($vendor['vendor_id'] ?? '') ?>" 
                                                    placeholder="Optional">
                                            <!-- <div class="col-md-3">
                                                <label class="form-label">Vendor ID</label>
                                                <input type="text" 
                                                    class="form-control" 
                                                    name="vendors[<?= $index ?>][vendor_id]" 
                                                    value="<?= esc($vendor['vendor_id'] ?? '') ?>" 
                                                    placeholder="Optional">
                                            </div> -->
                                            <div class="col-md-5">
                                                <label class="form-label">Vendor Company Name *</label>
                                                <input type="text" 
                                                    class="form-control" 
                                                    name="vendors[<?= $index ?>][company_name]" 
                                                    value="<?= esc($vendor['company_name'] ?? '') ?>" 
                                                    placeholder="e.g., Ravi Traders"
                                                    required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">CTO</label>
                                                <input type="text" name="vendors[<?= $index ?>][cto]" id="vendor_cto_<?= $index ?>" class="form-control" value="<?= esc($vendor['cto'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-vendor w-100">
                                                    <i class="fas fa-trash"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <hr>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('certificates') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?= isset($certificate) ? 'Update Certificate' : 'Create Certificate' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- JavaScript for Dynamic Add/Remove -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = <?= count($items) ?>;
    let vendorIndex = <?= count($vendors) ?>;

    // ===========================
    // ITEMS MANAGEMENT
    // ===========================
    
    // Add Item
    document.getElementById('addItem').addEventListener('click', function() {
        const container = document.getElementById('itemsContainer');
        const itemHtml = `
            <div class="item-row card mb-3" data-index="${itemIndex}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label">Item Description *</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="items[${itemIndex}][description]" 
                                   placeholder="e.g., Empty Plastic Can 25 Ltr Acetic Acid"
                                   required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Quantity *</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   name="items[${itemIndex}][quantity]" 
                                   placeholder="0"
                                   required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Unit *</label>
                            <select class="form-control" name="items[${itemIndex}][unit]" required>
                                <option value="Kgs">Kgs</option>
                                <option value="Nos">Nos</option>
                                <option value="Ltrs">Ltrs</option>
                                <option value="Tons">Tons</option>
                                <option value="Pcs">Pcs</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-item w-100">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', itemHtml);
        itemIndex++;
    });

    // Remove Item
    document.getElementById('itemsContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            const itemRow = e.target.closest('.item-row');
            const itemsCount = document.querySelectorAll('.item-row').length;
            
            if (itemsCount > 1) {
                itemRow.remove();
            } else {
                alert('At least one item is required');
            }
        }
    });

    // ===========================
    // VENDORS MANAGEMENT
    // ===========================
    
    // Add Vendor
    document.getElementById('addVendor').addEventListener('click', function() {
        const container = document.getElementById('vendorsContainer');
        const vendorHtml = `
            <div class="vendor-row card mb-3" data-index="${vendorIndex}">
                <div class="card-body">
                    <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Vendor ID</label>
                                <input type="text" 
                                    class="form-control" 
                                    name="vendors[${vendorIndex}][vendor_id]" 
                                    placeholder="Optional">
                            </div>
                        <div class="col-md-4">
                            <label class="form-label">Vendor Company Name *</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="vendors[${vendorIndex}][company_name]" 
                                   placeholder="e.g., Ravi Traders"
                                   required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">CTO</label>
                            <input type="text" name="vendors[${vendorIndex}][cto]" 
                            id="vendor_cto_${vendorIndex}" 
                            class="form-control" 
                            required>

                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-vendor w-100">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', vendorHtml);
        vendorIndex++;
    });

    // Remove Vendor
    document.getElementById('vendorsContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-vendor')) {
            const vendorRow = e.target.closest('.vendor-row');
            const vendorsCount = document.querySelectorAll('.vendor-row').length;
            
            if (vendorsCount > 1) {
                vendorRow.remove();
            } else {
                alert('At least one vendor is required');
            }
        }
    });

    // ===========================
    // FORM VALIDATION
    // ===========================
    
    document.getElementById('certificateForm').addEventListener('submit', function(e) {
        const items = document.querySelectorAll('.item-row');
        const vendors = document.querySelectorAll('.vendor-row');
        
        if (items.length === 0) {
            e.preventDefault();
            alert('Please add at least one item');
            return false;
        }
        
        if (vendors.length === 0) {
            e.preventDefault();
            alert('Please add at least one vendor');
            return false;
        }
        
        return true;
    });
});
</script>