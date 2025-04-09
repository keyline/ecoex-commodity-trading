<?php

namespace App\Services\ManageNotifications;

use App\Repositories\Notifications\NotificationsRepository;

class ManageNotificationsService
{
    protected  $repository;

    public function __construct()
    {
        $this->repository = new NotificationsRepository();
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
                'id'    => $notification->mn_id,
                'email' => json_decode($notification->mn_email, true),
                'is_ho' => $notification->mn_is_ho,
                'is_push_notification' => $notification->mn_is_push_notification,
                'is_sms' => $notification->mn_is_sms_to_vendor,
                'is_vendor' => $notification->mn_is_vendor,
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
