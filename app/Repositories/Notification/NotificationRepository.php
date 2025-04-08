<?php

namespace App\Repositories\Notification;

use CodeIgniter\Database\Exceptions\DatabaseException;

class NotificationsRepository
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function create(array $data)
    {
        try {
            // Start Transaction
            $this->db->transBegin();
            $this->db->table('manage_notification')->insert($data);
            $insertId = $this->db->insertID();
            // Commit the transaction
            $this->db->transCommit();
            return $insertId;
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            log_message('error', 'Transaction failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $this->db->transBegin();
            $this->db->table('manage_notification')->where('mn_id', $id)->update($data);
            $this->db->transCommit();
            return true;
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            log_message('error', 'Transaction failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
