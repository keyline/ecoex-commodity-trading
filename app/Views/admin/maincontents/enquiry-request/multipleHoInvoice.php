<form method="POST" action="<?= base_url('admin/enquiry-requests/upload-invoice-by-HO') ?>" enctype="multipart/form-data" style="border: 1px solid #0066cc6e; border-radius: 10px; padding: 10px;">
  <input type="hidden" name="enq_id" value="<?= encoded($getEnquiry->id) ?>">
  <input type="hidden" name="sub_enquiry_no" value="<?= encoded($sub_enquiry_no) ?>">

  <div id="hoInvoiceItemsContainer">
    <!-- Initial row with add button -->
    <div class="row mb-3 hoInvoiceItem" style="border: 2px solid #66aaff; margin: 1px; border-radius: 5px;">
      <div class="col-md-4">
        <div class="form-group">
          <label for="ho_payable_amount">Invoice Amount</label>
          <input type="text" class="form-control" name="ho_payable_amount[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^0+(\d)/, '$1').replace(/(\..*)\./g, '$1');" required>
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group">
          <label for="invoice_file_from_ho">Invoice PDF</label>
          <input type="file" class="form-control" name="invoice_file_from_ho[]" accept="application/pdf" required>
          <small class="text-primary">Only PDF files allowed</small>
        </div>
      </div>
      <div class="col-md-3 d-flex align-items-center">
        <button type="button" class="btn btn-success btn-sm add-ho-row">
          <i class="fas fa-plus"></i>
        </button>
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-sm mt-3">
    <i class="fas fa-file-invoice"></i> Upload Invoice(s)
  </button>
</form>