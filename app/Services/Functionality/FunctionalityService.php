<?php

namespace App\Services\Functionality;

use App\Repositories\Functionality\FunctionalityRepository;

class FunctionalityService
{
    protected  $repository;

    private $platforms = ['ecoex_admin', 'company_admin', 'plant_app', 'vendor_app'];

    public function __construct()
    {
        $this->repository = new FunctionalityRepository();
    }


    function platformList(): array
    {
        $result = [];
        foreach ($this->platforms as $item) {
            $formatted = ucwords(str_replace('_', ' ', $item));
            $result[$item] = $formatted;
        }
        return $result;
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

    public function getAllNotifications()
    {
        return $this->repository->list();
    }

    public function getRowById(int $id)
    {
        $row = $this->repository->getById($id);

        if ($row) {
            return [
                'id'       => $row->fun_id,
                'name'     => $row->fun_functionality_name,
                'platform' => $row->fun_platform,
                'rank'     => $row->fun_rank,
                'status'   => $row->fun_status,
            ];
        }

        return [];
    }

    public function statusUpdate(int $id, $status): bool
    {
        return $this->repository->updateStatus($id, $status);
    }
}
