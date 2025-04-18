<form method="POST" action="<?= base_url('admin/enquiry-requests/upload-invoice-by-ecoex-for-vendor') ?>" enctype="multipart/form-data" style="border: 1px solid #0080006e; border-radius: 10px; padding: 10px;">
    <input type="hidden" name="enq_id" value="<?= encoded($subenquiry->enq_id) ?>">
    <input type="hidden" name="sub_enquiry_no" value="<?= encoded($sub_enquiry_no) ?>">

    <div id="invoiceItemsContainer">
        <!-- Initial row with add button -->
        <div class="row mb-3 invoiceItem" style="border: 2px solid darkseagreen;margin: 1px;border-radius: 5px;">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="vendor_invoice_amount">Vendor Invoice Amount</label>
                    <input type="text" class="form-control" name="vendor_invoice_amount[]" required>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="vendor_invoice_file">Vendor Invoice File</label>
                    <input type="file" class="form-control" name="vendor_invoice_file[]" accept="application/pdf" required>
                    <small class="text-primary">Only PDF file allowed</small>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <button type="button" class="btn btn-success btn-sm add-row">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success btn-sm mt-3"><i class="fas fa-file-invoice"></i> Upload Invoice</button>
</form>