<?php

namespace App\Repositories\Notifications;

use CodeIgniter\Database\Exceptions\DatabaseException;

class NotificationsRepository
{
    protected $db, $tabel, $primaryKey;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->tabel = $this->db->table('manage_notification');
        $this->primaryKey = 'mn_id';
    }

    public function create(array $data)
    {
        try {
            // Start Transaction
            $this->db->transBegin();

            // Insert data into the table
            if (!$this->tabel->insert($data)) {
                // Get DB error if insert fails
                $error = $this->db->error();
                throw new \Exception('Insert failed: ' . $error['message']);
            }

            // Get insert ID
            $insertId = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            return $insertId;
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            log_message('error', 'Transaction failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            throw $e;
        }
    }

    public function update(int $id, array $data)
    {
        try {
            // Start transaction
            $this->db->transBegin();

            // Perform update
            $updated = $this->tabel->where($this->primaryKey, $id)->update($data);

            if (!$updated) {
                $error = $this->db->error();
                throw new \Exception('Update failed: ' . $error['message']);
            }

            // Commit transaction
            $this->db->transCommit();
            return true;
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            log_message('error', 'Transaction failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            throw $e;
        }
    }

    public function list()
    {
        try {
            // Fetch all records from the table
            return $this->tabel
                ->where('mn_status !=', 3)
                ->orderBy($this->primaryKey, 'DESC')
                ->get()
                ->getResult();
        } catch (DatabaseException $e) {
            log_message('error', 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            throw $e;
        }
    }


    public function getById($id)
    {
        try {
            return $this->tabel
                ->where($this->primaryKey, $id)
                ->get()
                ->getRow();
        } catch (DatabaseException $e) {
            log_message('error', 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            throw $e;
        }
    }


    public function updateStatus($id, $status)
    {
        try {
            return $this->tabel
                ->where($this->primaryKey, $id)
                ->set('mn_status', $status)
                ->update();
        } catch (DatabaseException $e) {
            log_message('error', 'Database error while updating status: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            throw $e;
        }
    }
}
