<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\WhatsAppWorker;

class WhatsAppWorkerModel extends Model
{
    protected $table            = 'ecomm_whatsapp_workers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['enquiry_id','status','enquiry_meta','created_at','started_at','finished_at','last_error'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
    * Reserve a worker row (atomic update) and return it.
    * This is useful for safe concurrency without daemons or redis.
    * Notes: claimPending() uses DB transaction + conditional update to avoid races
    * when multiple CLI workers accidentally run
    * (we assume admin will run single CLI but this keeps safe if cron overlaps).
    */
    public function claimPending(): ?array
    {
        $db = $this->db;
        // Use transaction to claim one pending job.
        $db->transStart();


        // Find one with status 'pending'
        $row = $this->asArray()->where('status', 'pending')->orderBy('id', 'ASC')->limit(1)->get()->getRowArray();


        if (!$row) {
            $db->transComplete();
            return null;
        }


        // Attempt to update status to 'processing' only if current status still pending
        $builder = $db->table($this->table);
        $updated = $builder->set('status', 'processing')
        ->set('started_at', date('Y-m-d H:i:s'))
        ->where('id', $row['id'])
        ->where('status', 'pending')
        ->update();


        if ($db->affectedRows() === 0) {
            // lost race
            $db->transComplete();
            return null;
        }


        $db->transComplete();


        return $this->find($row['id']);
    }

    //Check enquiry exists
    public function enquiryExists($enquiryId): bool
    {
        return $this->where('enquiry_id', $enquiryId)->countAllResults() > 0;
    }
}
