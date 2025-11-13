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
                        <form id="plantForm" method="post">
                            <!-- 🔍 Search Filters -->
                            <div class="mb-3">
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input type="text" id="searchCompanyName" class="form-control" placeholder="Search Company Name" style="width: 25%;">
                                    <input type="text" id="searchPlantName" class="form-control" placeholder="Search Plant Name" style="width: 25%;">
                                    <input type="text" id="searchAddress" class="form-control" placeholder="Search Address" style="width: 25%;">
                                    <input type="text" id="searchState" class="form-control" placeholder="Search State" style="width: 25%;">
                                    <button type="button" class="btn btn-secondary" onclick="clearPlantSearch()">Clear</button>
                                </div>
                            </div>

                            <table class="table globel_table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="7%">
                                            #
                                            <input type="checkbox" id="select_all_plants" onclick="toggleSelectAllPlants(this)">
                                        </th>
                                        <th>Company Name</th>
                                        <th>Plant Name</th>
                                        <th>Plant Address</th>
                                        <th>Plant State</th>
                                    </tr>
                                </thead>
                                <tbody id="plantTableBody">
                                    <?php if ($plantLists) {
                                        $sl = 1;
                                        foreach ($plantLists as $plant) { ?>
                                            <tr>
                                                <th scope="row" class="text-center">
                                                    <?= $sl++ ?><br><br>
                                                    <input type="checkbox" class="plant_checkbox" name="plant_ids[]" value="<?= $plant->id ?>"
                                                        <?= (in_array($plant->id, (($row->plant_ids != '') ? json_decode($row->plant_ids) : [])) ? 'checked' : '') ?>>
                                                </th>
                                                <td>
                                                    <?php
                                                    $getCompany = $common_model->find_data('ecoex_companies', 'row', ['id' => $plant->parent_id], 'company_name');
                                                    echo (($getCompany)?$getCompany->company_name:'');
                                                    ?>
                                                </td>
                                                <td><?= $plant->plant_name ?></td>
                                                <td><?= $plant->full_address ?></td>
                                                <td><?= $plant->state ?></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>

                            <!-- Hidden field to store JSON -->
                            <input type="hidden" name="plant_ids_json" id="plant_ids_json">

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
    function toggleSelectAllPlants(source) {
        const checkboxes = document.querySelectorAll('.plant_checkbox');
        checkboxes.forEach(chk => chk.checked = source.checked);
    }

    // ✅ Keep "Select All" synced
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select_all_plants');
        const checkboxes = document.querySelectorAll('.plant_checkbox');
        const rows = document.querySelectorAll('#plantTableBody tr');

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

                const checkbox = this.querySelector('.plant_checkbox');
                checkbox.checked = !checkbox.checked;

                // Update select all checkbox
                selectAll.checked = Array.from(checkboxes).every(c => c.checked);
            });
        });
    });

    // ✅ Column-wise filtering
    const searchCompanyName = document.getElementById('searchCompanyName');
    const searchPlantName = document.getElementById('searchPlantName');
    const searchAddress = document.getElementById('searchAddress');
    const searchState = document.getElementById('searchState');

    function filterPlants() {
        const companyVal = searchCompanyName.value.toLowerCase();
        const nameVal = searchPlantName.value.toLowerCase();
        const addressVal = searchAddress.value.toLowerCase();
        const stateVal = searchState.value.toLowerCase();

        document.querySelectorAll('#plantTableBody tr').forEach(row => {
            const companyname = row.cells[1].textContent.toLowerCase();
            const name = row.cells[2].textContent.toLowerCase();
            const address = row.cells[3].textContent.toLowerCase();
            const state = row.cells[4].textContent.toLowerCase();

            if (companyname.includes(nameVal) && name.includes(nameVal) && address.includes(addressVal) && state.includes(stateVal)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    [searchCompanyName, searchPlantName, searchAddress, searchState].forEach(input => {
        input.addEventListener('keyup', filterPlants);
    });

    function clearPlantSearch() {
        searchCompanyName.value = '';
        searchPlantName.value = '';
        searchAddress.value = '';
        searchState.value = '';
        filterPlants();
    }

    // ✅ Before submit — store selected plant_ids as JSON
    document.getElementById('plantForm').addEventListener('submit', function(e) {
        const selected = Array.from(document.querySelectorAll('.plant_checkbox:checked'))
            .map(chk => chk.value);
        document.getElementById('plant_ids_json').value = JSON.stringify(selected);
    });
</script>