<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\RecyclerCategory\RecyclerCategoryService;

class RecyclerCategorysController extends BaseController
{
    public array $data;
    protected $service;
    public function __construct()
    {
        $session = \Config\Services::session();

        // Call login check 
        $this->checkAdminLogin($session);


        $this->data = [
            'session'               => $session,
            'title'                 => 'Recycler Category',
            'controller_route'      => 'recycler-category',
            'controller'            => 'RecyclerCategorysController',
            'table_name'            => 'recycler_member_categorys',
            'primary_key'           => 'id',
            'titel2'                => 'Recycler Category',
            'view_directory'        => 'recycler_category/'
        ];
        $this->service = new RecyclerCategoryService();
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
        $title                      = 'Recycler Category';
        $page_name                  = $this->data['view_directory'] . 'list';
        $this->data['rows']         = $this->service->getAllCategories();

        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function create()
    {
        $title                      = 'Add';
        $page_name                  = $this->data['view_directory'] . 'add-edit';

        $this->data['row']          = [];

        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function store()
    {
        helper(['form']);

        $id = $this->request->getPost('update_id');

        $validationRules = [
            'name' => [
                'label' => 'Name',
                'rules' => 'required'
            ]
        ];


        // Validate input
        if (!$this->validate($validationRules)) {
            // Validation failed
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        // Validation passed
        $formData = [
            'category_name' => $this->request->getPost('name'),
            'category_slug' => str_replace(' ', '-', $this->request->getPost('name')),
        ];


        try {
            // Delegate data insertion 
            $this->service->saveData($formData, $this->request->getPost('update_id'));
            return redirect()->to('admin/' . $this->data['controller_route'])->with('success_message', 'Form submitted successfully.');
        } catch (\Exception $e) {
            // Handle exceptions
            log_message('error', 'An error occurred in ' . __FILE__ . ' on line ' . __LINE__ . ': ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error_message', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function edit($id)
    {
        $title                      = 'Update';
        $page_name                  = $this->data['view_directory'] . 'add-edit';
        $this->data['row']          = $this->service->getCategoryById(decoded($id));
    
        echo $this->layout_after_login($title, $page_name, $this->data);
    }

    public function update($id)
    {
        // Code to update a notification
    }

    public function delete($id)
    {
        try {
            $this->service->statusUpdate(decoded($id), 3);
            return redirect()->to('admin/' . $this->data['controller_route'])->with('success_message', 'Deleted successfully!');
        } catch (\Exception $e) {
            log_message('error', 'Error during soft delete: ' . $e->getMessage());
            return redirect()->to('admin/' . $this->data['controller_route'])->with('error_message', 'Delete failed!');
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $this->service->statusUpdate(decoded($id), $status);
            return redirect()->to('admin/' . $this->data['controller_route'])->with('success_message', 'Status update successfully!');
        } catch (\Exception $e) {
            log_message('error', 'Error during soft delete: ' . $e->getMessage());
            return redirect()->to('admin/' . $this->data['controller_route'])->with('error_message', 'Status update failed!');
        }
    }
}
