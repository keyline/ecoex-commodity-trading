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
              <tr>
                <td>Name</td>
                <td><?=$row->name?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?=$row->email?></td>
              </tr>
              <tr>
                <td>Subject</td>
                <td><?=$row->subject?></td>
              </tr>
              <tr>
                <td>Message</td>
                <td><?=$row->message?></td>
              </tr>
              <tr>
                <td>Date/Time</td>
                <td><?=date_format(date_create($row->created_at), "M d, Y h:i A")?></td>
              </tr>
            </table>
        </div>
      </div>
    </div>
  </div>
</section>