<style>
    #simpletable_wrapper .dt-layout-row.dt-layout-table {
        width: 100%;
        overflow: auto;
    }
</style>
<div class="container-fluid">
    <div class="pagetitle">
        <h1><?= $page_header ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
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
                        <div class="table-responsive">
                            <table id="simpletable" class="table globel_table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Recipient Type</th>
                                        <th>State</th>
                                        <th>Recipient Name</th>
                                        <th>Recipient Phone</th>
                                        <th>Status</th>
                                        <th>Sent On</th>                                       
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                if(!empty($child_whatsapp_arr))
                                {
                                    // dd($child_whatsapp_arr);
                                    // dd($child_whatsapp_arr[0]);
                                    $i = 1;
                                    foreach($child_whatsapp_arr[0] as $each_child_whatsapp_row)
                                    {
                                        // dd($each_child_whatsapp_row);
                                ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $each_child_whatsapp_row->recipient_type ?></td>
                                        <td><?= $each_child_whatsapp_row->state_name ?></td>
                                        <td><?= $each_child_whatsapp_row->recipient_name ?></td>
                                        <td><?= $each_child_whatsapp_row->recipient_phone ?></td>
                                        <td><?= $each_child_whatsapp_row->notification_status ?></td>
                                        <td><?= date_format(date_create($each_child_whatsapp_row->created_at), "M d, Y h:i A") ?></td>                                       
                                    </tr>
                                <?php $i++; }
                                } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>