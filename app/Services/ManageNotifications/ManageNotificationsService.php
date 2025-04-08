<?php
namespace App\Services\ManageNotifications;

use App\Repositories\Notification\NotificationsRepository;

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
}
