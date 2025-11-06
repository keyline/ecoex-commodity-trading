<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
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
                        <form id="vendorForm" method="post">
                            <!-- 🔍 Search Filters -->
                            <div class="mb-3">
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input type="text" id="searchVendorName" class="form-control" placeholder="Search Vendor Name" style="width: 25%;">
                                    <input type="text" id="searchType" class="form-control" placeholder="Search Vendor Type" style="width: 25%;">
                                    <input type="text" id="searchAddress" class="form-control" placeholder="Search Address" style="width: 25%;">
                                    <input type="text" id="searchState" class="form-control" placeholder="Search State" style="width: 25%;">
                                    <button type="button" class="btn btn-secondary" onclick="clearVendorSearch()">Clear</button>
                                </div>
                            </div>

                            <table class="table globel_table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="7%">
                                            #
                                            <input type="checkbox" id="select_all_vendors" onclick="toggleSelectAllVendors(this)">
                                        </th>
                                        <th>Type</th>
                                        <th> Name</th>
                                        <th> Address</th>
                                        <th> Location</th>
                                        <th> State</th>
                                    </tr>
                                </thead>
                                <tbody id="vendorTableBody">
                                    <?php if ($vendorLists) {
                                        $sl = 1;
                                        foreach ($vendorLists as $vendor) { ?>
                                            <tr>
                                                <th scope="row" class="text-center">
                                                    <?= $sl++ ?><br><br>
                                                    <input type="checkbox" class="vendor_checkbox" name="vendor_ids[]" value="<?= $vendor->id ?>"
                                                        <?= (in_array($vendor->id, (($row->vendor_ids != '') ? json_decode($row->vendor_ids) : [])) ? 'checked' : '') ?>>
                                                </th>
                                                
                                                <td>
                                                    <strong>
                                                        <?php

                                                        $memberType = $common_model->find_data('ecomm_member_types', 'row', ['id' => $vendor->member_type], 'name');
                                            echo(($memberType) ? $memberType->name : '');


                                            ?>
                                                    </strong>
                                                    <br>
                                                    <small>
                                                        <?php
                                            if ($vendor->recycler_category_id) {
                                                $rec_category = $common_model->find_data('recycler_member_categorys', 'row', ['id' => $vendor->recycler_category_id], 'category_name');
                                                echo(($rec_category) ? $rec_category->category_name : '');
                                            }
                                            ?>
                                                    </small>
                                                </td>
                                                <td><?= $vendor->company_name ?></td>
                                                <td><?= wordwrap($vendor->full_address, 25, "<br>\n") ?></td>
                                                <td><?= $vendor->location ?></td>
                                                <td><?= $vendor->state ?></td>
                                            </tr>
                                    <?php }
                                        } ?>
                                </tbody>
                            </table>

                            <!-- Hidden field to store JSON -->
                            <input type="hidden" name="vendor_ids_json" id="vendor_ids_json">

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // ✅ Select/Deselect All
    function toggleSelectAllVendors(source) {
        const checkboxes = document.querySelectorAll('.vendor_checkbox');
        checkboxes.forEach(chk => chk.checked = source.checked);
    }

    // ✅ Keep "Select All" synced
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select_all_vendors');
        const checkboxes = document.querySelectorAll('.vendor_checkbox');
        const rows = document.querySelectorAll('#vendorTableBody tr');

        // Keep "Select All" synced when individual boxes change
        checkboxes.forEach(chk => {
            chk.addEventListener('change', () => {
                selectAll.checked = Array.from(checkboxes).every(c => c.checked);
            });
        });

        // ✅ Make entire row clickable
        rows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Prevent double-toggle when clicking directly on checkbox
                if (e.target.type === 'checkbox') return;

                const checkbox = this.querySelector('.vendor_checkbox');
                checkbox.checked = !checkbox.checked;

                // Update select all checkbox
                selectAll.checked = Array.from(checkboxes).every(c => c.checked);
            });
        });
    });

    // ✅ Column-wise filtering
    const searchVendorName = document.getElementById('searchVendorName');
    const searchType = document.getElementById('searchType');
    const searchAddress = document.getElementById('searchAddress');
    const searchState = document.getElementById('searchState');

    function filterVendors() {
        debugger;
        const companyVal = searchVendorName.value.toLowerCase();
        const typeVal = searchType.value.toLowerCase();
        const addressVal = searchAddress.value.toLowerCase();
        const stateVal = searchState.value.toLowerCase();

        document.querySelectorAll('#vendorTableBody tr').forEach(row => {
            const type = row.cells[1].textContent.toLowerCase();
            
            const name = row.cells[2].textContent.toLowerCase();

            const address = row.cells[3].textContent.toLowerCase();
            const location = row.cells[4].textContent.toLowerCase();
            const state = row.cells[5].textContent.toLowerCase();

            if (type.includes(typeVal) && name.includes(companyVal) && address.includes(addressVal) && state.includes(stateVal)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    [searchVendorName, searchType, searchAddress, searchState].forEach(input => {
        input.addEventListener('keyup', filterVendors);
    });

    function clearVendorSearch() {
        // searchCompanyName.value = '';
        searchVendorName.value = '';
        searchType.value = '';
        searchAddress.value = '';
        searchState.value = '';
        filterVendors();
    }

    // ✅ Before submit — store selected vendor_ids as JSON
    document.getElementById('vendorForm').addEventListener('submit', function(e) {
        const selected = Array.from(document.querySelectorAll('.vendor_checkbox:checked'))
            .map(chk => chk.value);
        document.getElementById('vendor_ids_json').value = JSON.stringify(selected);
    });
</script>