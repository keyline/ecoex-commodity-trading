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
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Enquiry No.</th>
                                <th scope="col">Tentative Collection Date</th>
                                <th scope="col">Latitude<br>Longitude</th>
                                <th scope="col">Created At<br>Created By<br>Updated At<br>Updated By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $sl=1; foreach($rows as $row){?>
                                <?php
                                $approveProductCount               = $common_model->find_data('ecomm_enquiry_products', 'count', ['enq_id' => $row->id, 'status' => 1]);
                                $disapproveProductCount            = $common_model->find_data('ecomm_enquiry_products', 'count', ['enq_id' => $row->id, 'status' => 0]);
                                ?>
                                <tr>
                                    <th scope="row"><?=$sl++?></th>
                                    <td>
                                        <h5><?=$row->enquiry_no?></h5>
                                        <p><h6 class="badge bg-success"><?=$approveProductCount?> approved products</h6></p>
                                        <p><h6 class="badge bg-danger"><?=$disapproveProductCount?> pending approval</h6></p>
                                    </td>
                                    <td><?=date_format(date_create($row->tentative_collection_date), "M d, Y")?></td>
                                    <td><?=$row->latitude?><br><?=$row->longitude?></td>
                                    <td>
                                        <h6>
                                            <?=(($row->created_at != '')?date_format(date_create($row->created_at), "M d, Y h:i A"):'')?><br>
                                            <?php
                                            if($row->created_by > 0){
                                                $adminUser = $common_model->find_data('ecomm_users', 'row', ['id' => $row->created_by], 'company_name');
                                            ?>
                                                <small><?=(($adminUser)?$adminUser->company_name:'')?></small>
                                            <?php }?>
                                            <hr>
                                        </h6>
                                        <h6>
                                            <?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d, Y h:i A"):'')?><br>
                                            <?php
                                            if($row->updated_by > 0){
                                                $adminUser = $common_model->find_data('ecomm_users', 'row', ['id' => $row->updated_by], 'company_name');
                                            ?>
                                                <small><?=(($adminUser)?$adminUser->company_name:'')?></small>
                                            <?php }?>
                                        </h6>
                                    </td>
                                    <td>
                                        <?php if($common_model->checkModuleFunctionAccess(23,109)){?>
                                            <a href="<?=base_url('admin/' . $controller_route . '/view-detail/'.encoded($row->$primary_key))?>" class="btn btn-outline-info btn-sm" title="Edit <?=$title?>"><i class="fa fa-eye"></i> View Details</a>
                                            <br><br>
                                        <?php }?>
                                        <?php if($row->status == 0){?>
                                            <?php if($common_model->checkModuleFunctionAccess(23,107)){?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i> Delete</a>
                                                <br><br>
                                            <?php }?>
                                            <?php if($common_model->checkModuleFunctionAccess(23,110)){?>
                                                <a href="<?=base_url('admin/' . $controller_route . '/accept-request/'.encoded($row->$primary_key))?>" class="btn btn-success btn-sm" title="Accept <?=$title?>" onclick="return confirm('Do You Want To Accept This <?=$title?>');"><i class="fa fa-check"></i> Click To Accept</a>
                                            <?php }?>
                                            <?php if($common_model->checkModuleFunctionAccess(23,111)){?>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Reject <?=$title?>" onclick="getRejectModal(<?=$row->$primary_key?>);"><i class="fa fa-times"></i> Click To Reject</a>
                                            <?php }?>
                                        <?php } else {?>
                                            <?php if($row->status == 1){?>
                                                <h6 class="badge bg-success"><i class="fa fa-check-circle"></i> ACCEPTED</h6>
                                            <?php } elseif($row->status == 9){?>
                                                <h6 class="badge bg-danger"><i class="fa fa-times-circle"></i> REJECTED</h6>
                                            <?php }?>
                                            <p><?=(($row->accepted_date != '')?date_format(date_create($row->accepted_date), "M d, Y h:i A"):'')?></p>
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
<!-- reject request modal -->
    <div class="modal fade" id="rejectRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" id="rejectRequestTitle">
              
            </div>
            <div class="modal-body" id="rejectRequestBody">

            </div>
          </div>
        </div>
    </div>
<!-- reject request modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        
    });
    function getRejectModal(enq_id){
        let baseUrl = '<?=base_url()?>';
        $.ajax({
          type: "POST",
          data: { enq_id: enq_id },
          url: baseUrl+"/admin/get-reject-modal",
          dataType: "JSON",
          success: function(res){
            if(res.success){
              $('#rejectRequest').modal('show');
              $('#rejectRequestTitle').html(res.data.title);
              $('#rejectRequestBody').html(res.data.body);
            } else {
              $('#rejectRequest').modal('hide');
              $('#rejectRequestTitle').html('');
              $('#rejectRequestBody').html('');
            }
          }
        });
    }
</script>