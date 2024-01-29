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
      <div class="card">
        <div class="card-body pt-3">
            <h2 class="text-danger fw-bold text-center">You don't have access to this page</h2>
            <h4 class="text-center"><a class="btn btn-outline-danger" href="<?=base_url('admin/dashboard')?>"><i class="fa fa-undo"></i> Return To Dashboard</a></h4>
        </div>
      </div>
    </div>
  </div>
</section>