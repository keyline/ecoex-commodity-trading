<div class="modal fade panIndiaWpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog
      modal-xl
      modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h5 class="modal-title">Send Notification to pan India Vendors & Subscribers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- @if (!empty()) -->
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center pb-1">                       
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                    <th>State</th>
                                    <th>No. Of Vendors</th>
                                    <th>No. Of Subscribers</th>                                   
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                        name="[]" 
                                        class="form-check-input" 
                                        value="">
                                    </td>
                                    <td>State</td>
                                    <td>No. Of Vendors</td>
                                    <td>No. Of Subscribers</td>                                   
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            <!-- @else -->
                <div class="d-flex justify-content-center align-items-center"
                    style="height: 100%; min-height: 200px; padding-bottom: 24px;">
                    <p class="fw-semibold text-danger m-0" style="font-size: 12px;">No records available</p>
                </div>
            <!-- @endif -->
        </div>
    </div>
</div>