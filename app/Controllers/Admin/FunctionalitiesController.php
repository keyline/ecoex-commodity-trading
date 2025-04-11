<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\Functionality\FunctionalityService;
use Exception;

class FunctionalitiesController extends BaseController
{
    public array $data;
    protected $functionality;
    public function __construct()
    {
        $session = \Config\Services::session();

        // Call login check 
        $this->checkAdminLogin($session);

        // $model = new CommonModel();
        $this->data = [
            // 'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Functionality',
            'controller_route'      => 'functionalities',
            'controller'            => 'FunctionalitiesController',
            'table_name'            => 'functionalities',
            'primary_key'           => 'fun_id',
            'titel2'                => 'Functionality',
            'view_directory'        => 'functionality/'
        ];
        $this->functionality = new FunctionalityService();
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
        $title                      = 'Functionality';
        $page_name                  = $this->data['view_directory'] . 'list';
        $this->data['rows']         = $this->functionality->getAllNotifications();

        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function create()
    {
        $title                      = 'Add';
        $page_name                  = $this->data['view_directory'] . 'add-edit';
        $this->data['platforms']    = $this->functionality->platformList();
        $this->data['row']          = [];

        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function store()
    {
        helper(['form']);

        // $id = $this->request->getPost('update_id');
        $validationRules = [
            'platform' => [
                'label' => 'Platform',
                'rules' => 'required|alpha_dash|min_length[4]|max_length[20]'
            ],
            'name' => [
                'label' => 'Name',
                'rules' => 'required|alpha_space|min_length[3]|max_length[255]'
            ],
            'rank' => [
                'label' => 'Rank',
                'rules' => 'required|numeric|greater_than_equal_to[0]' # |is_unique[functionalities.fun_rank]
            ]
        ];

      



        // Validate input
        if (!$this->validate($validationRules)) {
            // Validation failed
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validation passed
        $formData = [
            'fun_platform' => $this->request->getPost('platform'),
            'fun_functionality_name' => $this->request->getPost('name'),
            'fun_rank' => $this->request->getPost('rank')
        ];


        try {
            // Delegate data insertion 
            $this->functionality->saveData($formData, $this->request->getPost('update_id'));
            return redirect()->to('admin/' . $this->data['controller_route'])->with('success_message', 'Form submitted successfully.');
        } catch (Exception $e) {
            // Handle exceptions
            log_message('error', 'An error occurred in ' . __FILE__ . ' on line ' . __LINE__ . ': ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error_message', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function edit($id)
    {
        $title                      = 'Update';
        $page_name                  = $this->data['view_directory'] . 'add-edit';
        $this->data['platforms']    = $this->functionality->platformList();
        $this->data['row']          = $this->functionality->getRowById(decoded($id));

        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function update($id)
    {
        // Code to update a notification
    }

    public function delete($id)
    {
        try {
            $this->functionality->statusUpdate(decoded($id), 3);
            return redirect()->to('admin/' . $this->data['controller_route'])->with('success_message', 'Deleted successfully!');
        } catch (\Exception $e) {
            log_message('error', 'Error during soft delete: ' . $e->getMessage());
            return redirect()->to('admin/' . $this->data['controller_route'])->with('error_message', 'Delete failed!');
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $this->functionality->statusUpdate(decoded($id), $status);
            return redirect()->to('admin/' . $this->data['controller_route'])->with('success_message', 'Status update successfully!');
        } catch (\Exception $e) {
            log_message('error', 'Error during soft delete: ' . $e->getMessage());
            return redirect()->to('admin/' . $this->data['controller_route'])->with('error_message', 'Status update failed!');
        }
    }
}
