<form method="POST"
    action="<?= base_url('admin/enquiry-requests/upload-invoice-by-ecoex-for-vendor') ?>"
    enctype="multipart/form-data"
    style="border: 1px solid #0080006e; border-radius: 10px; padding: 10px;">
    <input type="hidden" name="enq_id" value="<?= encoded($subenquiry->enq_id) ?>">
    <input type="hidden" name="sub_enquiry_no" value="<?= encoded($sub_enquiry_no) ?>">

    <!-- note: switched to class -->
    <div class="invoiceItemsContainer">
        <div class="row mb-3 invoiceItem" style="border: 2px solid darkseagreen; margin: 1px; border-radius: 5px;">
            <div class="col-3">
                <label style="font-size:11px;">Inv No</label>
                <input type="text" class="form-control form-control-sm" name="vendor_inv_number[]" required>
            </div>
            <div class="col-3">
                <label style="font-size:11px;">Date</label>
                <input type="date" class="form-control form-control-sm" name="vendor_inv_date[]" required>
            </div>
            <div class="col-2">
                <label style="font-size:11px;">Amt</label>
                <input type="text"
                    class="form-control form-control-sm"
                    name="vendor_invoice_amount[]"
                    oninput="this.value = this.value
                 .replace(/[^0-9.]/g, '')
                 .replace(/^0+(\d)/, '$1')
                 .replace(/(\..*)\./g, '$1');"
                    required>
            </div>
            <div class="col-3">
                <label style="font-size:11px;">PDF</label>
                <input type="file"
                    class="form-control form-control-sm"
                    name="vendor_invoice_file[]"
                    accept="application/pdf"
                    required>
                <small class="text-primary">Only PDF file allowed</small>
            </div>
            <div class="col-1 d-flex align-items-center">
                <button type="button" class="btn btn-success btn-sm add-row">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success btn-sm mt-3">
        <i class="fas fa-file-invoice"></i> Upload Invoice
    </button>
</form>