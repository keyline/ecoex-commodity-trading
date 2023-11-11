<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<style type="text/css">
    .choices__list--multiple .choices__item {
        background-color: #48974e;
        border: 1px solid #48974e;
    }
</style>
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
<!-- End Page Title -->
<section class="section profile">
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
        <?php
            if($row){
                $user_type              = $row->user_type;
                $team_members           = (($row->team_members != '')?json_decode($row->team_members):[]);
                $role_id                = $row->role_id;
                $name                   = $row->name;
                $mobileNo               = $row->mobileNo;
                $email                  = $row->email;
                $password               = $row->original_password;
                $present_address        = $row->present_address;
                $permanent_address      = $row->permanent_address;
            } else {
                $user_type              = '';
                $team_members           = [];
                $role_id                = '';
                $name                   = '';
                $mobileNo               = '';
                $email                  = '';
                $password               = '';
                $present_address        = '';
                $permanent_address      = '';
            }
        ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">User Type</label>
                            <div class="col-md-10 col-lg-10">
                                <select class="form-control" name="user_type" id="user_type" required>
                                    <option value="" selected>Select User Type</option>
                                    <option value="U" <?=(($user_type == 'U')?'selected':'')?>>Sub User</option>
                                    <option value="CRMU" <?=(($user_type == 'CRMU')?'selected':'')?>>CRM Manager</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Role</label>
                            <div class="col-md-10 col-lg-10">
                                <select class="form-control" name="role_id" id="role_id" required>
                                    <option value="" selected>Select Role</option>
                                    <?php if($roles){ foreach($roles as $role){?>
                                    <option value="<?=$role->id?>" <?=(($role->id == $role_id)?'selected':'')?>><?=$role->role_name?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Team Members</label>
                            <div class="col-md-10 col-lg-10">
                                <select class="form-control" name="team_members[]" id="choices-multiple-remove-button" multiple>
                                    <?php if($subusers){ foreach($subusers as $user){?>
                                    <option value="<?=$user->id?>" <?php if(in_array($user->id, $team_members)){?>selected<?php }?>><?=$user->name?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Name</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" class="form-control" name="name" id="name" value="<?=$name?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Email</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="email" class="form-control" name="email" id="email" value="<?=$email?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Mobile</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="text" class="form-control" name="mobileNo" id="mobileNo" value="<?=$mobileNo?>" maxlength="10" minlength="10" onkeypress="return isNumber(event)" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Present Address</label>
                            <div class="col-md-10 col-lg-10">
                                <textarea class="form-control" name="present_address" id="present_address" required><?=$present_address?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Permanent Address</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="checkbox" id="pre_eq_per">&nbsp;&nbsp;<label for="pre_eq_per">Same As Present Address</label>
                                <textarea class="form-control" name="permanent_address" id="permanent_address" required><?=$permanent_address?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role_name" class="col-md-2 col-lg-2 col-form-label">Password</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="password" class="form-control" name="password" id="password" value="<?=$password?>" minlength="8" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?=(($row)?'Save':'Add')?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function(){    
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
          removeItemButton: true,
          maxItemCount:10,
          searchResultLimit:10,
          renderChoiceLimit:10
        });     
    });

    $(function(){
        $('#pre_eq_per').click(function() {
            if($(this).is(':checked'))
                $('#permanent_address').val($('#present_address').val());
            else
                $('#permanent_address').val('');
        });

        $('#present_address').on('input', function(){
            if($('#pre_eq_per').is(':checked'))
                $('#permanent_address').val($('#present_address').val());
            else
                $('#permanent_address').val('');
        });
    });
</script>