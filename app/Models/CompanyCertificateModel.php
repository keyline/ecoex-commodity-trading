<?php

// ============================================
// COMPANY CERTIFICATE MODEL
// ============================================
// File: app/Models/CompanyCertificateModel.php

namespace App\Models;

use CodeIgniter\Model;

class CompanyCertificateModel extends Model
{
    protected $table = 'ecomm_company_certificates';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'company_id',
        'enquiry_id',
        'certificate_type',
        'certificate_file',
        'filename',
        'certificate_word_file',
        'word_filename',
        'created_at',
        'updated_at',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get certificate by enquiry ID
     */
    public function getCertificateByEnquiry($enquiryId, $certificateType = 1)
    {
        return $this->where('enquiry_id', $enquiryId)
                    ->where('certificate_type', $certificateType)
                    ->first();
    }

    /**
     * Delete old certificate file
     */
    public function deleteOldCertificate($id)
    {
        $certificate = $this->find($id);

        if ($certificate && !empty($certificate['certificate_file'])) {
            $filePath = FCPATH . 'uploads/certificates/' . $certificate['certificate_file'];
            if (file_exists($filePath)) {
                unlink($filePath);
                return true;
            }
        }

        return false;
    }
}
