<?php

namespace App\Services\RecyclerCategory;

use App\Repositories\RecyclerCategory\RecyclerCategoryRepository;

class RecyclerCategoryService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new RecyclerCategoryRepository();
    }

    public function saveData(array $postData, int $updateId = 0): int
    {
        try {
            if ($updateId) {
                $this->repository->update($updateId, $postData);
                return $updateId;
            } else {
                return $this->repository->create($postData);
            }
        } catch (\Exception $error) {
            // Handle exceptions as needed
            throw $error;
        }
    }

    public function getAllCategories()
    {
        return $this->repository->list();
    }

    public function getCategoryById(int $id)
    {
        return $this->repository->getById($id);
    }

    public function statusUpdate(int $id, $status): bool
    {
        return $this->repository->updateStatus($id, $status);
    }
}
