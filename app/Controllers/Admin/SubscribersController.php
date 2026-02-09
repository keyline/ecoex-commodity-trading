<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class SubscribersController extends BaseController {

    private $model;  //This can be accessed by all class methods
	public function __construct()
    {
        $session = \Config\Services::session();
        if(!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }
        $model = new CommonModel();
        $this->data = array(
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Subscriber',
            'controller_route'      => 'subscriber',
            'controller'            => 'SubscribersController',
            'table_name'            => 'subscribers',
            'primary_key'           => 'id'
        );
    }

    public function list()
    {
        if(!$this->common_model->checkModuleFunctionAccess(28,143)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }

        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');

        $data['moduleDetail']       = $this->data;
        $data['action']             = 'List';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'subscribers/list';        
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status!=' => 3], '', '', '', $order_by);        
        
        echo $this->layout_after_login($title,$page_name,$data);
    }

    public function add()
    {
        if(!$this->data['model']->checkModuleFunctionAccess(28,143)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }

        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'subscribers/add-edit';        
        $data['row']                = [];

        $order_by2[0]               = array('field' => 'name', 'type' => 'ASC');
        $data['states']             = $this->data['model']->find_data('ecomm_states', 'array', ['status' => 1], 'name', '', '', $order_by2);

        if($this->request->getMethod() == "post")
        {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'max_length[255]',
                    'errors' => [
                        // 'required' => 'Email is required.',
                        // 'valid_email' => 'Please enter a valid email address.',
                        // 'is_unique' => 'This email is already subscribed.',
                        // 'max_length' => 'Email cannot exceed 255 characters.'
                    ]
                ],
                'name' => [
                    'label' => 'Name',
                    'rules' => 'required|max_length[100]',
                    'errors' => [
                        'required' => 'Name is required.',
                        'max_length' => 'Name cannot exceed 100 characters.'
                    ]
                ],
                'phone' => [
                    'label' => 'Phone',
                    'rules' => 'required|max_length[10]|numeric|is_unique[subscribers.phone]',
                    'errors' => [
                        'required' => 'Phone number is required.',
                        'max_length' => 'Phone number cannot exceed 10 characters.',
                        'is_unique' => 'This phone number is already subscribed.',
                        'numeric' => 'Phone number must contain only numbers.'
                    ]
                ],
                'state' => [
                    'label' => 'State',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'State is required.'
                    ]
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $data['validation'] = $validation;
                //$data['row'] = $this->request->getPost();
            } else {
                $postData = [
                    'email' => $this->request->getPost('email'),
                    'name' => $this->request->getPost('name'),
                    'phone' => $this->request->getPost('phone'),
                    'type' => $this->request->getPost('type'),
                    'state' => $this->request->getPost('state'),
                    'remarks' => $this->request->getPost('remarks'),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);
                $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            }
        }

        echo $this->layout_after_login($title,$page_name,$data);
    }

    public function edit($id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(28,145)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'subscribers/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);

        $order_by2[0]               = array('field' => 'name', 'type' => 'ASC');
        $data['states']             = $this->data['model']->find_data('ecomm_states', 'array', ['status' => 1], 'name', '', '', $order_by2);

        if($this->request->getMethod() == 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                // 'email' => [
                //     'label' => 'Email',
                //     'rules' => "valid_email|max_length[255]",
                //     'errors' => [
                //         // 'required' => 'Email is required.',
                //         // 'valid_email' => 'Please enter a valid email address.',
                //         // 'is_unique' => 'This email is already subscribed.',
                //         'max_length' => 'Email cannot exceed 255 characters.'
                //     ]
                // ],
                'name' => [
                    'label' => 'Name',
                    'rules' => 'required|max_length[100]',
                    'errors' => [
                        'required' => 'Name is required.',
                        'max_length' => 'Name cannot exceed 100 characters.'
                    ]
                    ],
                'phone' => [
                    'label' => 'Phone',
                    'rules' => "required|max_length[10]|numeric|is_unique[subscribers.phone,id,{$id}]",
                    'errors' => [
                        'required' => 'Phone number is required.',
                        'max_length' => 'Phone number cannot exceed 10 characters.',
                        'numeric' => 'Phone number must contain only numbers.',
                        'is_unique' => 'This phone number is already subscribed.'
                    ]
                ],
                'state' => [
                    'label' => 'State',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'State is required.'
                    ]
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $data['validation'] = $validation;
                //$data['row'] = $this->request->getPost();
            } else {
                $postData = [
                    'email' => $this->request->getPost('email'),
                    'name' => $this->request->getPost('name'),
                    'phone' => $this->request->getPost('phone'),
                    'type' => $this->request->getPost('type'),
                    'state' => $this->request->getPost('state'),
                    'remarks' => $this->request->getPost('remarks'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);
                $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            }

        }
        echo $this->layout_after_login($title,$page_name,$data);
    }

    public function confirm_delete($id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(28,146)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $id                         = decoded($id);
        $postData = array(
                            'status' => 3
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }

    public function change_status($id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(28,148)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }

        if(!$this->common_model->checkModuleFunctionAccess(28,147)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        if($data['row']->status){
            $status  = 0;
            $msg        = 'Deactivated';
        } else {
            //$email_verify           = $data['row']->email_verify;
            //$phone_verify           = $data['row']->phone_verify;
            $status  = 1;
            $msg        = 'Activated';

            
        }
        $postData = array(
                            'status' => $status
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }

}