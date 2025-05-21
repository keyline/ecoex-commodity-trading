<?php

namespace App\Services\Enquiry;

use App\Repositories\Enquiry\VendorInvoiceRepository;
use App\Models\CommonModel;

class VendorInvoiceService
{
    protected VendorInvoiceRepository $repository;
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->repository    = new VendorInvoiceRepository();
    }


    /**
     * Handle the business logic for uploading an invoice by Ecoex for a vendor.
     *
     * @param array $postData - Form data (e.g., sub_enq_id, enq_id, vendor_invoice_amount)
     * @param object $file    - Uploaded file instance
     *
     * @return bool|string  - Returns the inserted record ID or false on failure.
     */
    public function uploadInvoiceByEcoexForVendor(array $postData, $files)
    {
        $enq_id                     = decoded($postData['enq_id']);
        $sub_enquiry_no             = decoded($postData['sub_enquiry_no']);
        // $invoice_amount          = $postData['vendor_invoice_amount'];
        $invoice_amount             = array_map(function ($val) {
            // Cast to float, format with 2 decimals, dot as decimal separator, no thousands sep
            return number_format((float)$val, 2, '.', '');
        },  $postData['vendor_invoice_amount']);
        $invoice_number             = $postData['vendor_inv_number'];
        $invoice_date               = $postData['vendor_inv_date'];
        $vendor_invoice_file        = [];
      

        try {
            $this->db->transStart();  // Start Transaction
            $subEnquiry = $this->repository->getSubEnquiry($sub_enquiry_no);

            if (!$subEnquiry) {
                throw new \Exception('Sub enquiry not found for the given sub enquiry number.');
            } else {

                /* vendor invoice */
                $uploadResult = $this->uploadMultipleFiles('vendor_invoice_file', 'enquiry', ['application/pdf'], 15);

                if (isset($uploadResult['error'])) {
                    throw new \Exception($uploadResult['error']);
                } else {
                    $vendor_invoice_file = $uploadResult['files'];
                }
                /* vendor invoice */

                $fields                     = [
                    'status'                           => 8.8,
                    'vendor_invoice_amount_arr'        => json_encode($invoice_amount),
                    'vendor_invoice_file_arr'          => json_encode($vendor_invoice_file),
                    'vendor_invoice_number_arr'        => json_encode($invoice_number),
                    'vendor_invoice_date_arr'          => json_encode($invoice_date),
                    'invoice_to_vendor_date'           => date('Y-m-d H:i:s'),
                ];

                $this->repository->updateData('ecomm_sub_enquires', $fields, 'sub_enquiry_no', $sub_enquiry_no);

                $this->repository->updateData('ecomm_enquires', ['status' => 8], 'id', $enq_id);

                $this->db->transComplete(); // Commit or Rollback based on status

                if ($this->db->transStatus() === FALSE) {
                    throw new \Exception("Transaction failed!");
                } else
                    return [
                        'status' => true,
                        'message' => 'Vendor invoice uploaded successfully.',
                        'data' => $subEnquiry,
                        'sub_enquiry_no' => $sub_enquiry_no,
                        'vendor_invoice_file' => $vendor_invoice_file,
                        'invoice_amount' => $invoice_amount,
                    ];
            }
        } catch (\Exception $error) {
            $this->db->transRollback();  // Rollback on error
            log_message('error', 'Invoice Upload Failed: ' . $error->getMessage());
            throw $error;
        }
    }


    protected function uploadMultipleFiles($fieldName, $uploadPath = 'enquiry', $allowedTypes = ['application/pdf'], $maxSizeMB = 15)
    {
        $uploadedFiles = [];
        $maxSize = $maxSizeMB * 1024 * 1024; // Convert MB to bytes
        $request = service('request'); // Get request instance
        $files = $request->getFileMultiple($fieldName);

        if (!$files) {
            return ['error' => 'No files uploaded.'];
        }

        try {
            // Ensure the directory exists
            $fullPath = 'public/uploads/' . $uploadPath;
            if (!is_dir($fullPath) && !mkdir($fullPath, 0777, true) && !is_dir($fullPath)) {
                throw new \Exception("Failed to create upload directory.");
            }

            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Validate file type
                    if (!in_array($file->getClientMimeType(), $allowedTypes)) {
                        throw new \Exception("Only PDF files are allowed!");
                    }

                    // Validate file size
                    if ($file->getSize() > $maxSize) {
                        throw new \Exception("File size exceeds {$maxSizeMB}MB!");
                    }

                    // Generate a unique file name
                    $newName = $file->getRandomName();

                    // Move the file to the destination
                    if (!$file->move($fullPath, $newName)) {
                        throw new \Exception("File upload failed.");
                    }

                    $uploadedFiles[] = $newName;
                }
            }

            return ['success' => true, 'files' => $uploadedFiles];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
