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
        $title                      = 'Manage Notifications';
        $page_name                  = 'manage-notification/list';
        $this->data['rows']         = $this->manageNotification->getAllNotifications();

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
        $this->data['row']          = [];
        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function create()
    {
        helper(['form']);
        // Define validation rules
        $validationRules = [
            'mn_email' => [
                'label' => 'Email',
                'rules' => [
                    'required',
                    function ($str) {
                        // Split the string into individual emails
                        $emails = array_map('trim', explode(',', $str));
                        // Validate each email address
                        foreach ($emails as $email) {
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                return false;
                            }
                        }
                        return true;
                    }
                ],
                'errors' => [
                    'required' => 'The {field} field is required.',
                    'custom'   => 'One or more email addresses are invalid.'
                ]
            ],
            // Optional checkboxes
            'mn_is_vendor' => [
                'label' => 'Is Vendor',
                'rules' => 'permit_empty|in_list[1]',
                'errors' => [
                    'in_list' => 'Invalid selection for {field}.',
                ],
            ],
            'mn_is_ho' => [
                'label' => 'Is Head Office',
                'rules' => 'permit_empty|in_list[1]',
                'errors' => [
                    'in_list' => 'Invalid selection for {field}.',
                ],
            ],
            'mn_is_sms_to_vendor' => [
                'label' => 'Send SMS to Vendor',
                'rules' => 'permit_empty|in_list[1]',
                'errors' => [
                    'in_list' => 'Invalid selection for {field}.',
                ],
            ],
            'mn_is_push_notification' => [
                'label' => 'Push Notification',
                'rules' => 'permit_empty|in_list[1]',
                'errors' => [
                    'in_list' => 'Invalid selection for {field}.',
                ],
            ],
        ];


        // Validate input
        if (!$this->validate($validationRules)) {
            // Validation failed
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validation passed
        $formData = [
            'mn_email' => json_encode($this->request->getPost('mn_email')),
            'mn_is_vendor' => $this->request->getPost('mn_is_vendor') ? 1 : 0,
            'mn_is_ho' => $this->request->getPost('mn_is_ho') ? 1 : 0,
            'mn_is_sms_to_vendor' => $this->request->getPost('mn_is_sms_to_vendor') ? 1 : 0,
            'mn_is_push_notification' => $this->request->getPost('mn_is_push_notification') ? 1 : 0,
        ];


        try {
            // Delegate data insertion 
            $this->manageNotification->saveData($formData, $this->request->getPost('update_id'));
            return redirect()->to('admin/manage-notifications')->with('success_message', 'Form submitted successfully.');
        } catch (Exception $e) {
            // Handle exceptions
            log_message('error', 'An error occurred in ' . __FILE__ . ' on line ' . __LINE__ . ': ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error_message', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function edit($id)
    {
        $title                      = 'Update';
        $page_name                  = 'manage-notification/add-edit';
        $this->data['row']          = $this->manageNotification->getNotificationById(decoded($id));

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
