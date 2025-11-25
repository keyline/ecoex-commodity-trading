<form method="POST"
    action="<?= base_url('admin/enquiry-requests/upload-payment-by-ecoex') ?>"
    enctype="multipart/form-data"
    style="border: 1px solid #0080006e; border-radius: 10px; padding: 10px;">
    <input type="hidden" name="enq_id" value="<?= encoded($subenquiry->enq_id) ?>">
    <input type="hidden" name="sub_enquiry_no" value="<?= encoded($sub_enquiry_no) ?>">
    <input type="hidden" class="form-control form-control-sm" value="" name="tax_no">

    <!-- note: switched to class -->
    <div class="invoiceItemsContainer">
        <div class="row mb-3 invoiceItem" style="border: 2px solid darkseagreen; margin: 1px; border-radius: 5px;">            
            <div class="col-2">
                <label style="font-size:11px;">Payment Amount</label>
                <input type="text"
                    class="form-control form-control-sm"
                    name="payment_amount"
                    oninput="this.value = this.value
                 .replace(/[^0-9.]/g, '')
                 .replace(/^0+(\d)/, '$1')
                 .replace(/(\..*)\./g, '$1');"
                    required>
            </div>
            <div class="col-3">
                <label style="font-size:11px;">Payment Mode</label>
                <select class="form-control form-control-sm" name="payment_mode" required>
                    <option value="">Select Payment Mode</option>
                    <option value="CASH">CASH</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="NETBANKING">NETBANKING</option>
                </select>
            </div>
            <div class="col-3">
                <label style="font-size:11px;">Payment Date</label>
                <input type="datetime-local" class="form-control form-control-sm" name="payment_date" required>
            </div>
            <!-- <div class="col-3">
                <label style="font-size:11px;">Tax no.</label>                
            </div> -->
            
            <div class="col-3">
                <label style="font-size:11px;">Tax Screenshot</label>
                <input 
                    type="file"
                    class="form-control form-control-sm"
                    name="tax_screenshot_file"
                    accept="image/*"
                    required
                >
                <small class="text-primary">Only image files allowed (JPG, JPEG, PNG, GIF, WEBP)</small>
            </div>           
        </div>
    </div>

    <button type="submit" class="btn btn-success btn-sm mt-3">
        <i class="fas fa-file-invoice"></i> Upload Payment Details
    </button>
</form>