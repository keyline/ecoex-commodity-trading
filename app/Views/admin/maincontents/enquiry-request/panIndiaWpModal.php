<style>
    .form-check-input:checked {
        background-color: #28a745; 
        border-color: #28a745;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .panIndiaWpModal .modal-header {
        background: linear-gradient(135deg, #a3c2b0, #e3f1ec);
        border-bottom: none;
    }

    .panIndiaWpModal .modal-title {
        font-weight: bold;
    }

    .panIndiaWpModal tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #fafff6; 
    }

    /* .panIndiaWpModal tbody tr:hover {
        background-color: #bad1c4;
    } */

    .form-check-input {
        cursor: pointer;
    }

    .panIndiaWpModal .btn-close {
        font-size: 30px;
    }

</style>



<form action="<?= base_url('admin/enquiry-requests/send-pan-india-wp') ?>" method="POST">

    <div class="modal fade panIndiaWpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog
        modal-xl
        modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Notification to pan India Vendors & Subscribers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?php if(!empty($stateWiseArr)) { 
                    // pr($stateWiseArr);
                ?>
                    
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center pb-1">                       
                        </div>

                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                        <th>State</th>
                                        <th class="text-center">No. Of Vendors</th>
                                        <th class="text-center">No. Of Subscribers</th>                                   
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                
                                    <?php
                                        $i = 1;
                                        foreach($stateWiseArr as $eachState) {  
                                    ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <input type="checkbox"
                                                name="stateArr[]" 
                                                class="form-check-input" 
                                                value="<?= encoded($eachState['state']) ?>">
                                            </td>
                                            <td><?= $eachState['state'] ?></td>
                                            <td class="text-center"><?= $eachState['VendorsCount'] ?></td>
                                            <td class="text-center"><?= $eachState['SubscribersCount'] ?></td>                                   
                                        </tr>
                                    <?php $i++; } ?>
                                

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success mx-auto">Submit</button> 
                    </div>
                    
                <?php } else { ?>

                    <div class="d-flex justify-content-center align-items-center"
                        style="height: 100%; min-height: 200px; padding-bottom: 24px;">
                        <p class="fw-semibold text-danger m-0" style="font-size: 12px;">No records available</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <input type="hidden" name="enquiry_id" value="<?= $enquiry_id ?>">
    <input type="hidden" name="current_status" value="<?= $current_status ?>">

</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function()
    {
        // "Select All" checkbox
        $('#selectAll').on('change', function() {
            $('input[name="stateArr[]"]').prop('checked', this.checked);
        });

        // prevent submit if nothing selected
        $('form').on('submit', function (e) {
            if ($('input[name="stateArr[]"]:checked').length === 0) {
                e.preventDefault();
                alert('Please select at least one state !!!');
            }
        });


    });
</script>