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
                        <!-- 🔍 Search Filters -->
                        <div class="mb-3">
                            <div style="display: flex; gap: 10px; align-items: center;">
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
                                        <input type="checkbox" id="select_all_plants" onclick="toggleSelectAllPlants(this)">
                                        #
                                    </th>
                                    <th>Plant Name</th>
                                    <th>Plant Address</th>
                                    <th>Plant State</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($plantLists) {
                                    $sl = 1;
                                    foreach ($plantLists as $plant) { ?>
                                        <tr>
                                            <th scope="row" class="text-center">
                                                <?= $sl++ ?><br><br>
                                                <input type="checkbox" class="plant_checkbox" name="plant_ids[]" value="<?= $plant->id ?>" <?= (in_array($plant->id, (($row->plant_ids != '') ? json_decode($row->plant_ids) : [])) ? 'checked' : '') ?>>
                                            </th>
                                            <td><?= $plant->plant_name ?></td>
                                            <td><?= $plant->full_address ?></td>
                                            <td><?= $plant->state ?></td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // ✅ Toggle select/deselect all plants
    function toggleSelectAllPlants(source) {
        const checkboxes = document.querySelectorAll('.plant_checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = source.checked);
    }

    // ✅ Optional: Update "Select All" checkbox automatically 
    // when individual checkboxes are changed
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select_all_plants');
        const checkboxes = document.querySelectorAll('.plant_checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // If any box unchecked → uncheck "Select All"
                // If all boxes checked → check "Select All"
                selectAll.checked = Array.from(checkboxes).every(chk => chk.checked);
            });
        });
    });

    // ✅ Column-wise filtering
    const searchPlantName = document.getElementById('searchPlantName');
    const searchAddress = document.getElementById('searchAddress');
    const searchState = document.getElementById('searchState');

    function filterPlants() {
        const nameVal = searchPlantName.value.toLowerCase();
        const addressVal = searchAddress.value.toLowerCase();
        const stateVal = searchState.value.toLowerCase();

        document.querySelectorAll('#plantTableBody tr').forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const address = row.cells[2].textContent.toLowerCase();
            const state = row.cells[3].textContent.toLowerCase();

            if (name.includes(nameVal) && address.includes(addressVal) && state.includes(stateVal)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    [searchPlantName, searchAddress, searchState].forEach(input => {
        input.addEventListener('keyup', filterPlants);
    });

    function clearPlantSearch() {
        searchPlantName.value = '';
        searchAddress.value = '';
        searchState.value = '';
        filterPlants();
    }
</script>