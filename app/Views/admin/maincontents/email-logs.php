<?php
$user_type = session('user_type');
?>
<div class="pagetitle">
  <h1><?=$page_header?></h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
      <li class="breadcrumb-item active"><?=$page_header?></li>
    </ol>
  </nav>
</div><!-- End Page Title -->
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
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body pt-3">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($rows){ $sl=1; foreach($rows as $row){?>
                    <tr>
                        <th scope="row"><?=$sl++?></th>
                        <td><?=$row->name?></td>
                        <td><?=$row->email?></td>
                        <td><?=$row->subject?></td>
                        <td>
                          <?php if($common_model->checkModuleFunctionAccess(21,99)){?>
                            <a target="_blank" href="<?=base_url('admin/email-logs-details/'.encoded($row->id))?>" class="btn btn-outline-primary btn-sm" title="Edit <?=$row->subject?>"><i class="fa fa-info-circle"></i></a>
                          <?php } ?>
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