<?php

namespace App\Repositories\RecyclerCategory;

use CodeIgniter\Database\Exceptions\DatabaseException;

class RecyclerCategoryRepository
{
    protected $db, $tabel, $primaryKey;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->tabel = $this->db->table('recycler_member_categorys');
        $this->primaryKey = 'id';
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
                ->where('status !=', 3)
                ->orderBy('id', 'DESC')
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
                ->set('status', $status)
                ->update();
        } catch (DatabaseException $e) {
            log_message('error', 'Database error while updating status: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            throw $e;
        }
    }
}
