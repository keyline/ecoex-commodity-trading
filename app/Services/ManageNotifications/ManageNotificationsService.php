<?php

namespace App\Services\ManageNotifications;

use App\Repositories\Notifications\NotificationsRepository;

class ManageNotificationsService
{
    protected  $repository;
    private $platforms = ['ecoex_admin', 'company_admin', 'plant_app', 'vendor_app'];
    public function __construct()
    {
        $this->repository = new NotificationsRepository();
    }

    public function platformList(): array
    {
        $result = [];
        foreach ($this->platforms as $item) {
            $formatted = ucwords(str_replace('_', ' ', $item));
            $result[$item] = $formatted;
        }
        return $result;
    }

    public function functionality(): array
    {
        return $this->repository->FunctionalityList();
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

    public function getNotificationById(int $id)
    {
        $notification = $this->repository->getById($id);

        if ($notification) {
            return [
                'id'       => $notification->mn_id,
                'fun_id'   => $notification->mn_fun_id,
                'platform' =>$notification->fun_platform,
                'email'    => json_decode($notification->mn_email, true),
                'mn_ecoex_admin_email'  => $notification->mn_ecoex_admin_email,
                'mn_company_admin_email' => $notification->mn_company_admin_email,
                'mn_vendor_email' => $notification->mn_vendor_email,
                'mn_vendor_sms' => $notification->mn_vendor_sms,
                'mn_vendor_push' => $notification->mn_vendor_push,
                'mn_plant_email' => $notification->mn_plant_email,
                'mn_plant_sms' => $notification->mn_plant_sms,
                'mn_plant_push' => $notification->mn_plant_push,
                'status' => $notification->mn_status,
            ];
        }

        return [];
    }

    public function statusUpdate(int $id, $status): bool
    {
        return $this->repository->updateStatus($id, $status);
    }
}
