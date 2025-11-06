<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style>
    .plant-list {
        list-style-type: disc;     /* Use dots as bullets */
        list-style-position: inside; /* Place dots inside content */
        font-size: 9px;           /* Smaller text */
        line-height: 1.4;          /* Slightly tighter spacing */
        margin: 0;                 /* Remove outer spacing */
        padding: 0;                /* Remove default padding */
        color: #333;               /* Optional - dark gray text */
    }
</style>

<div class="container-fluid">
    <div class="pagetitle">
        <h1><?=$page_header?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                <li class="breadcrumb-item active"><?=$page_header?></li>
            </ol>
        </nav>
    </div>
</div>
<section class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php if (session('success_message')) {?>
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?=session('success_message')?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }?>
                <?php if (session('error_message')) {?>
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?=session('error_message')?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }?>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-titles">
                            <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                        </h5>
                        <div class="table-responsive">
                            <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>User Type / Role</th>
                                        <th>Name / Employee No</th>
                                        <th>Mobile / Email / Password</th>
                                        <!-- <th>Present Address<br>Permanent Address</th>
                                        <th>Team Members</th> -->
                                        <th>Access Plants</th>
                                        <th>Access Vendors</th>
                                        <th width="12%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($rows) {
                                        $sl = 1;
                                        foreach ($rows as $row) {?>
                                    <tr>
                                        <th scope="row" class="text-center"><?=$sl++?></th>
                                        <td>
                                            <!-- <?php if ($row->user_type == 'U') {?>
                                            <span>Sub User</span>
                                            <?php } else {?>
                                            <span>CRM Manager</span>
                                            <?php }?> -->
                                            <span><?=$row->user_type?></span>
                                            <br>
                                            <?php
                                                $role = $common_model->find_data('ecoex_roles', 'row', ['id' => $row->role_id]);
                                            echo(($role) ? $role->role_name : '');
                                            ?>
                                        </td>
                                        <td>
                                            <i class="fas fa-user-tie"></i> <?=$row->name?><br>
                                            <?php if ($row->employee_no != '') {?><i class="fas fa-id-card"></i> <?=$row->employee_no?><?php }?>
                                        </td>
                                        <td>
                                            <i class="fa fa-mobile"></i> <?=$row->mobileNo?><br>
                                            <i class="fa fa-envelope"></i> <?=$row->username?><br>
                                            <i class="fa fa-key"></i> <?=$row->original_password?>
                                        </td>
                                        <!--<td>
                                            <i class="fa fa-map-pin"></i> <?=$row->present_address?><br><br>
                                            <i class="fa fa-map-marker"></i> <?=$row->permanent_address?>
                                        </td>
                                        <td>
                                            <?php
                                            $memberList = [];
                                            $team_members = json_decode($row->team_members);
                                            if (!empty($team_members)) {
                                                for ($t = 0;$t < count($team_members);$t++) {
                                                    $userDTL = $common_model->find_data('ecoex_admin_user', 'row', ['id' => $team_members[$t]]);
                                                    $memberList[] = (($userDTL) ? $userDTL->name : '');
                                                }
                                            }
                                            echo implode(", ", $memberList);
                                            ?>
                                        </td> -->
                                        <td>
                                            <a href="<?= base_url('admin/' . $controller_route . '/access-plant/' . encoded($row->$primary_key)) ?>" class="btn btn-warning btn-sm" title="Access Plant"><i class="fa fa-universal-access"></i> Access Plant</a><br><br>
                                            
                                            <?php
                                            $plant_ids = ($row->plant_ids != '') ? json_decode($row->plant_ids, true) : [];
                                            if (!empty($plant_ids)) {
                                                echo '<ul class="plant-list">';
                                                for ($k = 0;$k < count($plant_ids);$k++) {
                                                    $getPlant = $common_model->find_data('ecomm_users', 'row', ['id' => $plant_ids[$k]], 'plant_name');
                                                    echo '<li>' . (($getPlant) ? $getPlant->plant_name : '') . '</li>';
                                                }
                                                echo '</ul>';
                                            } else {
                                                echo '<span class="text-danger">No Plants</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/' . $controller_route . '/access-vendor/' . encoded($row->$primary_key)) ?>" class="btn btn-info btn-sm" title="Access Vendor"><i class="fa fa-universal-access"></i> Access Vendor</a><br><br>
                                            
                                            <?php
                                            $vendor_ids = ($row->vendor_ids != '') ? json_decode($row->vendor_ids, true) : [];
                                            if (!empty($vendor_ids)) {
                                                echo '<ul class="plant-list">';
                                                for ($j = 0;$j < count($vendor_ids);$j++) {
                                                    $getVendor = $common_model->find_data('ecomm_users', 'row', ['id' => $vendor_ids[$j]], 'company_name, contact_person_name');
                                                    echo '<li>' . (($getVendor) ? $getVendor->company_name : '') . ' (' . (($getVendor) ? $getVendor->contact_person_name : '') . ')</li>';
                                                }
                                                echo '</ul>';
                                            } else {
                                                echo '<span class="text-danger">No Vendors</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i></a>
                                            <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                            <?php if ($row->status) {?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i></a>
                                            <?php } else {?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i></a>
                                            <?php }?>
                                            <br>
                                            <a href="<?=base_url('admin/' . $controller_route . '/send-credentials/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm mt-2" title="Send Credential <?=$title?>" onclick="return confirm('Do You Want To Send Signin Credentials To This <?=$title?>');"><i class="fa fa-envelope"></i> Send Credentials</a>
                                        </td>
                                    </tr>
                                    <?php }
                                        }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>