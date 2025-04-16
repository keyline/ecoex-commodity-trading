<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;

use App\Services\ManageNotifications\ManageNotificationsService;
use Exception;

class ManageNotificationsController extends BaseController
{
    public array $data;

    protected $manageNotification;
    public function __construct()
    {
        $session = \Config\Services::session();

        // Call login check 
        $this->checkAdminLogin($session);

        $model = new CommonModel();
        $this->data = [
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Manage Notifications',
            'controller_route'      => 'manage-notifications',
            'controller'            => 'ManageNotificationsController',
            'table_name'            => 'manage_notification',
            'primary_key'           => 'mn_id',
            'titel2'                => 'Manage Notifications',
        ];
        $this->manageNotification = new ManageNotificationsService();
    }


    private function checkAdminLogin($session)
    {
        if (!$session->get('is_admin_login')) {
            // Force redirection immediately
            service('response')->redirect(base_url('/admin'))->send();
            exit; // Stop further execution
        }
    }


    public function index()
    {
        $title                       = 'Manage Notifications';
        $page_name                   = 'manage-notification/list2';
        $this->data['rows']          = $this->manageNotification->getAllNotifications();
        $this->data['functionality'] = $this->manageNotification->functionality();

        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function show($id)
    {
        // Code to display a specific notification
    }

    public function new()
    {
        $title                      = 'Add';
        $page_name                  = 'manage-notification/add-edit';
        $this->data['platforms']    = $this->manageNotification->platformList();
        $this->data['functionality'] = $this->manageNotification->functionality();
        $this->data['row']          = [];

        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function create()
    {
        $post = $this->request->getPost();

        $errors = [];

        $functionalityIds = $this->request->getPost('functionality') ?? [];
        $emails = $this->request->getPost('mn_email') ?? [];
        $update_id = $this->request->getPost('update_id') ?? [];

        $checkboxes = [
            'mn_ecoex_admin_email',
            'mn_company_admin_email',
            'mn_vendor_email',
            'mn_plant_email',
            'mn_vendor_sms',
            'mn_plant_sms',
            'mn_vendor_push',
            'mn_plant_push'
        ];

        foreach ($functionalityIds as $funId) {
            $email = trim($emails[$funId] ?? '');
            $checked = false;

            // Check if at least one checkbox is selected for this functionality
            foreach ($checkboxes as $checkbox) {
                if (isset($post[$checkbox][$funId])) {
                    $checked = true;
                    break;
                }
            }
            if ($email == '') {
                continue; // skip to next functionalityId
                // $errors["functionality_$funId"] = "You must fill email input.";
            }

            // Validation conditions
            if ($email !== '' && !$checked) {
                $errors["functionality_$funId"] = "You must select at least one notification method for emails.";
            }

            if ($checked && $email === '') {
                $errors["functionality_$funId"] = "Email is required when any notification option is selected.";
            }

            // Email format check 
            if ($email !== '') {
                $emailList = explode(',', $email);
                foreach ($emailList as $singleEmail) {
                    if (!filter_var(trim($singleEmail), FILTER_VALIDATE_EMAIL)) {
                        $errors["functionality_$funId"] = "Invalid email format for functionality ID: $funId";
                        break;
                    }
                }
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Validation passed
        foreach ($functionalityIds as $funId) {

            // Skip if email is blank
            $email = trim($emails[$funId] ?? '');
            if ($email === '') {
                continue; // skip to next functionalityId
            }

            $formData = [
                'mn_fun_id'               => $funId,
                'mn_email'                => json_encode($emails[$funId]) ?? null,
                'mn_ecoex_admin_email'    => isset($post['mn_ecoex_admin_email'][$funId]) ? 1 : 0,
                'mn_company_admin_email'  => isset($post['mn_company_admin_email'][$funId]) ? 1 : 0,
                'mn_vendor_email'         => isset($post['mn_vendor_email'][$funId]) ? 1 : 0,
                'mn_plant_email'          => isset($post['mn_plant_email'][$funId]) ? 1 : 0,
                'mn_vendor_sms'           => isset($post['mn_vendor_sms'][$funId]) ? 1 : 0,
                'mn_plant_sms'            => isset($post['mn_plant_sms'][$funId]) ? 1 : 0,
                'mn_vendor_push'          => isset($post['mn_vendor_push'][$funId]) ? 1 : 0,
                'mn_plant_push'           => isset($post['mn_plant_push'][$funId]) ? 1 : 0,
            ];


            try {
                // Data insertion 
                $this->manageNotification->saveData($formData, $update_id[$funId]);
            } catch (Exception $e) {
                // Handle exceptions
                log_message('error', 'An error occurred in ' . __FILE__ . ' on line ' . __LINE__ . ': ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error_message', 'An unexpected error occurred. Please try again later.|' . $e->getMessage());
            }
        }

        // After processing all records, do the redirect:
        return redirect()->to('admin/manage-notifications')
            ->with('success_message', 'Form submitted successfully.');
    }

    public function edit($id)
    {
        $title                      = 'Update';
        $page_name                  = 'manage-notification/add-edit';
        $this->data['row']          = $this->manageNotification->getNotificationById(decoded($id));
        $this->data['platforms']    = $this->manageNotification->platformList();
        $this->data['functionality'] = $this->manageNotification->functionality();
        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function update($id)
    {
        // Code to update a notification
    }

    public function delete($id)
    {
        try {
            $this->manageNotification->statusUpdate(decoded($id), 3);
            return redirect()->route('admin/manage-notifications')->with('success_message', 'Deleted successfully!');
        } catch (\Exception $e) {
            log_message('error', 'Error during soft delete: ' . $e->getMessage());
            return redirect()->route('admin/manage-notifications')->with('error_message', 'Delete failed!');
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $this->manageNotification->statusUpdate(decoded($id), $status);
            return redirect()->route('admin/manage-notifications')->with('success_message', 'Status update successfully!');
        } catch (\Exception $e) {
            log_message('error', 'Error during soft delete: ' . $e->getMessage());
            return redirect()->route('admin/manage-notifications')->with('error_message', 'Status update failed!');
        }
    }
}
