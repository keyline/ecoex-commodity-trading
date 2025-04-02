<form method="POST" action="<?= base_url('admin/enquiry-requests/upload-invoice-by-ecoex-for-vendor') ?>" enctype="multipart/form-data" style="border: 1px solid #0080006e; border-radius: 10px; padding: 10px;">
    <input type="hidden" name="enq_id" value="<?= encoded($subenquiry->enq_id) ?>">
    <input type="hidden" name="sub_enquiry_no" value="<?= encoded($sub_enquiry_no) ?>">

    <!-- Container for dynamic invoice items -->
    <div id="invoiceItemsContainer">
        <div class="invoiceItem">
            <div class="form-group">
                <label for="vendor_invoice_amount">Vendor Invoice Amount</label>
                <input type="text" class="form-control" name="vendor_invoice_amount[]" required>
            </div>
            <div class="form-group">
                <label for="vendor_invoice_file">Vendor Invoice File</label>
                <input type="file" class="form-control" name="vendor_invoice_file[]" accept="application/pdf" required>
                <small class="text-primary">Only PDF file allowed</small>
            </div>
        </div>
    </div>

    <!-- Buttons to add or remove invoice items -->
    <div class="mt-2">
        <button type="button" id="addInvoiceItem" class="btn btn-info btn-sm">Add Invoice Item</button>
        <button type="button" id="removeInvoiceItem" class="btn btn-warning btn-sm">Remove Last Invoice Item</button>
    </div>

    <button type="submit" class="btn btn-success btn-sm mt-3"><i class="fas fa-file-invoice"></i> Upload Invoice</button>
</form>