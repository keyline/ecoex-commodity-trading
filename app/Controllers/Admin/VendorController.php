<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class VendorController extends BaseController {

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
            'title'                 => 'Vendor',
            'controller_route'      => 'vendors',
            'controller'            => 'VendorController',
            'table_name'            => 'ecomm_users',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'member/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status!=' => 3, 'type' => 'VENDOR'], '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'member/add-edit';        
        $data['row']                = [];
        $data['memberTypes']        = $this->data['model']->find_data('ecomm_member_types', 'array', ['status' => 1]);

        if($this->request->getMethod() == 'post') {
            $postData   = array(
                'name'          => strtoupper($this->request->getPost('name')),
                'created_by'    => $this->session->get('user_id'),
            );
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);            
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function edit($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'member/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $data['memberTypes']        = $this->data['model']->find_data('ecomm_member_types', 'array', ['status' => 1]);

        if($this->request->getMethod() == 'post') {
            /* profile image */
                $file = $this->request->getFile('profile_image');
                $originalName = $file->getClientName();
                $fieldName = 'profile_image';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','image');
                    if($upload_array['status']) {
                        $profile_image = $upload_array['newFilename'];
                    } else {
                        $profile_image = $data['row']->profile_image;
                    }
                } else {
                    $profile_image = $data['row']->profile_image;
                }
            /* profile image */
            if($this->request->getPost('password') != ''){
                $postData   = array(
                    'gst_no'                => $this->request->getPost('gst_no'),
                    'company_name'          => $this->request->getPost('company_name'),
                    'full_address'          => $this->request->getPost('full_address'),
                    'holding_no'            => $this->request->getPost('holding_no'),
                    'street'                => $this->request->getPost('street'),
                    'district'              => $this->request->getPost('district'),
                    'state'                 => $this->request->getPost('state'),
                    'pincode'               => $this->request->getPost('pincode'),
                    'location'              => $this->request->getPost('location'),
                    'email'                 => $this->request->getPost('email'),
                    'phone'                 => $this->request->getPost('phone'),
                    'password'              => md5($this->request->getPost('password')),
                    'profile_image'         => $profile_image,
                    'member_type'           => $this->request->getPost('member_type'),
                );
            } else {
                $postData   = array(
                    'gst_no'                => $this->request->getPost('gst_no'),
                    'company_name'          => $this->request->getPost('company_name'),
                    'full_address'          => $this->request->getPost('full_address'),
                    'holding_no'            => $this->request->getPost('holding_no'),
                    'street'                => $this->request->getPost('street'),
                    'district'              => $this->request->getPost('district'),
                    'state'                 => $this->request->getPost('state'),
                    'pincode'               => $this->request->getPost('pincode'),
                    'location'              => $this->request->getPost('location'),
                    'email'                 => $this->request->getPost('email'),
                    'phone'                 => $this->request->getPost('phone'),
                    'profile_image'         => $profile_image,
                    'member_type'           => $this->request->getPost('member_type'),
                );
            }
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function confirm_delete($id)
    {
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
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        if($data['row']->status){
            $status  = 0;
            $msg        = 'Deactivated';
        } else {
            $email_verify           = $data['row']->email_verify;
            $phone_verify           = $data['row']->phone_verify;
            if(($email_verify == 1) && ($phone_verify == 1)){
                $status  = 2;
            } else {
                $status  = 1;
            }
            $msg        = 'Activated';

            /* approve mail send */
                $getUser = $data['row'];
                $requestData = [
                    'id'            => $getUser->id,
                    'email'         => $getUser->email,
                    'phone'         => $getUser->phone,
                    'company_name'  => $getUser->company_name,
                ];
                /* send email */
                    $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                    $subject                    = $generalSetting->site_name.' :: Account Approved';
                    $message                    = view('email-templates/signup',$requestData);
                    // echo $message;die;
                    $this->sendMail($requestData['email'], $subject, $message);
                /* send email */
                /* email log save */
                    $postData2 = [
                        'name'                  => $getUser->company_name,
                        'email'                 => $getUser->email,
                        'subject'               => $subject,
                        'message'               => $message
                    ];
                    $this->common_model->save_data('email_logs', $postData2, '', 'id');
                /* email log save */
            /* approve mail send */
        }
        $postData = array(
                            'status' => $status
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function view($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'View';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'member/details';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        echo $this->layout_after_login($title,$page_name,$data);
    }
}