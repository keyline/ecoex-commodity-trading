<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Repositories\Notification\NotificationsRepository;
use App\Repositories\Test\TestRepo;
use App\Services\ManageNotifications\ManageNotificationsService;
use Exception;

class ManageNotificationsController extends BaseController
{
    public array $data;
    private $model;  //This can be accessed by all class methods
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
       dd( new TestRepo());
    //    $repo= new NotificationsRepository();
   
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

        if ($this->request->getMethod() === 'post') {
            // Validate input
            if (!$this->validate($validationRules)) {
                // Validation failed
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Validation passed
            $formData = [
                'mn_email' => $this->request->getPost('mn_email'),
                'mn_is_vendor' => $this->request->getPost('mn_is_vendor') ? 1 : 0,
                'mn_is_ho' => $this->request->getPost('mn_is_ho') ? 1 : 0,
                'mn_is_sms_to_vendor' => $this->request->getPost('mn_is_sms_to_vendor') ? 1 : 0,
                'mn_is_push_notification' => $this->request->getPost('mn_is_push_notification') ? 1 : 0,
            ];


            try {
                // Delegate data insertion 
                $this->manageNotification->saveData($formData);
                return redirect()->to('admin/manage-notifications')->with('success_message', 'Form submitted successfully.');
            } catch (Exception $e) {
                // Handle exceptions
                log_message('error', 'An error occurred in ' . __FILE__ . ' on line ' . __LINE__ . ': ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error_message', 'An unexpected error occurred. Please try again later.');
            }
        }

        return view('your_form_view');
    }

    public function edit($id)
    {
        // Code to show form for editing a notification
    }

    public function update($id)
    {
        // Code to update a notification
    }

    public function delete($id)
    {
        // Code to delete a notification
    }
}
