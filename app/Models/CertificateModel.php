<?php

// ============================================
// 2. CERTIFICATE MODEL
// ============================================
// File: app/Models/CertificateModel.php

namespace App\Models;

use CodeIgniter\Model;

class CertificateModel extends Model
{
    protected $table = 'ecomm_certificates_data';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'enquiry_id','company_id','enquiry_no','certificate_number', 'company_name', 'plant_name', 'plant_address',
        'plant_state','collection_date', 'issue_date', 'status', 'version', 'signature_path',
        'pdf_path', 'word_path','finalized_at', 'finalized_by', 'created_by', 'updated_by', 'reviewed_at', 'reviewed_by'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /*protected $validationRules = [
        'certificate_number' => 'required|is_unique[ecomm_certificates_data.enquiry_id,id,{id}]',
        'vendor_name' => 'required|max_length[255]',
        'plant_name' => 'required|max_length[255]',
        'collection_date' => 'required|valid_date',
    ];*/

    /**
     * Get certificate by enquiry number
     */
    public function getCertificateByEnquiry($enquiryNo)
    {
        $certificate = $this->where('enquiry_id', $enquiryNo)->first();

        if (!$certificate) {
            return null;
        }

        $itemsModel = new CertificateItemModel();
        $certificate['items'] = $itemsModel->where('certificate_id', $certificate['id'])
                                           ->orderBy('sequence', 'ASC')
                                           ->findAll();

        return $certificate;
    }

    /**
     * Check if enquiry already has a certificate
     */
    public function enquiryExists($enquiryNo)
    {
        return $this->where('enquiry_id', $enquiryNo)->countAllResults() > 0;
    }

    /**
     * Check if certificate can be edited (must be draft status)
     */
    public function canEdit($enquiryNo)
    {
        $certificate = $this->where('enquiry_id', $enquiryNo)->first();
        return $certificate && $certificate['status'] === 'draft';
    }

    public function getCertificateWithItems($id)
    {
        $certificate = $this->find($id);
        if (!$certificate) {
            return null;
        }

        $itemsModel = new CertificateItemModel();
        $certificate['items'] = $itemsModel->where('certificate_id', $id)
                                           ->orderBy('sequence', 'ASC')
                                           ->findAll();

        return $certificate;
    }

    public function createVersion($certificateId, $changedBy, $notes = null)
    {

        $certificate = $this->getCertificateWithItems($certificateId);

        // Include vendors in snapshot
        $vendorModel = new CertificateVendorModel();
        $certificate['vendors'] = $vendorModel->where('certificate_id', $certificateId)
                                              ->findAll();

        $versionModel = new CertificateVersionModel();
        return $versionModel->insert([
            'certificate_id' => $certificateId,
            'version_number' => $certificate['version'],
            'data_snapshot' => json_encode($certificate),
            'changed_by' => $changedBy,
            'change_notes' => $notes,
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }

    public function finalizeCertificate($id, $userId)
    {
        if ($this->where('id', $id)->where('status', 'review')->countAllResults() === 0) {
            return false;
        }

        return $this->update($id, [
            'status' => 'approved',
            'finalized_at' => date('Y-m-d H:i:s'),
            'finalized_by' => $userId
        ]);
    }

    public function reviewCertificate($id, $userId)
    {
        if ($this->where('id', $id)->where('status', 'pending')->countAllResults() === 0) {
            return false;
        }

        return $this->update($id, [
            'status' => 'review',
            'reviewed_at' => date('Y-m-d H:i:s'),
            'reviewed_by' => $userId
        ]);

    }
}
