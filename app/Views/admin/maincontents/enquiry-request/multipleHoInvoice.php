<form method="POST"
        action="<?= base_url('admin/enquiry-requests/upload-invoice-by-HO') ?>"
        enctype="multipart/form-data"
        style="border:1px solid #0066cc6e; border-radius:6px; padding:6px; font-size:12px;">
    <input type="hidden" name="enq_id"        value="<?= encoded($getEnquiry->id) ?>">
    <input type="hidden" name="sub_enquiry_no" value="<?= encoded($sub_enquiry_no) ?>">

    <div id="hoInvoiceItemsContainer">
      <div class="row gx-1 gy-1 mb-2 hoInvoiceItem"
           style="border:1px solid #66aaff; border-radius:4px; padding:5px;">
        <div class="col-3">
          <label style="font-size:11px;">Inv No</label>
          <input type="text"
                 class="form-control form-control-sm"
                 name="ho_inv_number[]"
                 required>
        </div>
        <div class="col-3">
          <label style="font-size:11px;">Date</label>
          <input type="date"
                 class="form-control form-control-sm"
                 name="ho_inv_date[]"
                 required>
        </div>
        <div class="col-2">
          <label style="font-size:11px;">Amt</label>
          <input type="text"
                 class="form-control form-control-sm"
                 name="ho_payable_amount[]"
                 oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^0+(\d)/, '$1').replace(/(\..*)\./g, '$1');"
                 required>
        </div>
        <div class="col-3">
          <label style="font-size:11px;">PDF</label>
          <input type="file"
                 class="form-control form-control-sm"
                 name="invoice_file_from_ho[]"
                 accept="application/pdf"
                 required>
        </div>
        <div class="col-1 text-end mt-4">
          <button type="button"
                  class="btn btn-success btn-sm add-ho-row"
                  style="padding:2px 6px;">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
    </div>

    <button type="submit"
            class="btn btn-primary btn-sm mt-1"
            style="font-size:12px;">
      <i class="fas fa-file-invoice"></i> Upload
    </button>
  </form>