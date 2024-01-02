<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row">
        <div class="col-xl-12">
            <?php if(session('success_message')){?>
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?=session('success_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
            <?php if(session('error_message')){?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?=session('error_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User Type<br>Role</th>
                                <th scope="col">Name<br>Employee No</th>
                                <th scope="col">Mobile<br>Email<br>Password</th>
                                <th scope="col">Present Address<br>Permanent Address</th>
                                <th scope="col">Team Members</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $sl=1; foreach($rows as $row){?>
                            <tr>
                                <th scope="row"><?=$sl++?></th>
                                <td>
                                    <!-- <?php if($row->user_type == 'U'){?>
                                      <span>Sub User</span>
                                    <?php } else {?>
                                      <span>CRM Manager</span>
                                    <?php }?> -->
                                    <span><?=$row->user_type?></span>
                                    <br>
                                    <?php
                                    $role = $common_model->find_data('ecoex_roles', 'row', ['id' => $row->role_id]);
                                    echo (($role)?$role->role_name:'');
                                    ?>
                                </td>
                                <td>
                                    <i class="fas fa-user-tie"></i> <?=$row->name?><br>
                                    <i class="fas fa-id-card"></i> <?=$row->employee_no?>
                                </td>
                                <td>
                                    <i class="fa fa-mobile"></i> <?=$row->mobileNo?><br>
                                    <i class="fa fa-envelope"></i> <?=$row->username?><br>
                                    <i class="fa fa-key"></i> <?=$row->original_password?>
                                </td>
                                <td>
                                    <i class="fa fa-map-pin"></i> <?=$row->present_address?><br><br>
                                    <i class="fa fa-map-marker"></i> <?=$row->permanent_address?>
                                </td>
                                <td>
                                    <?php
                                    $memberList = [];
                                    $team_members = json_decode($row->team_members);
                                    if(!empty($team_members)){ for($t=0;$t<count($team_members);$t++){
                                      $userDTL = $common_model->find_data('ecoex_admin_user', 'row', ['id' => $team_members[$t]]);
                                      $memberList[] = (($userDTL)?$userDTL->name:'');
                                    } }
                                    echo implode(", ", $memberList);
                                    ?>
                                </td>
                                <td>
                                    <a href="<?=base_url('admin/' . $controller_route . '/edit/'.encoded($row->$primary_key))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$title?>"><i class="fa fa-edit"></i></a>
                                    <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                    <?php if($row->status){?>
                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate <?=$title?>" onclick="return confirm('Do You Want To Deactivate This <?=$title?>');"><i class="fa fa-check"></i></a>
                                    <?php } else {?>
                                    <a href="<?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-warning btn-sm" title="Deactivate <?=$title?>" onclick="return confirm('Do You Want To Activate This <?=$title?>');"><i class="fa fa-times"></i></a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>