<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class AdminSubUserController extends BaseController {

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
            'title'                 => 'Admin Sub User',
            'controller_route'      => 'sub-users',
            'controller'            => 'AdminSubUserController',
            'table_name'            => 'ecoex_admin_user',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'sub-users/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status!=' => 3], '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'sub-users/add-edit';        
        $data['row']                = [];
        $data['roles']              = $this->common_model->find_data('ecoex_roles', 'array', ['published' => 1]);
        $data['subusers']           = $this->common_model->find_data('ecoex_admin_user', 'array', ['status' => 1, 'user_type!=' => 'MA']);
        if($this->request->getMethod() == 'post') {
            // pr($this->request->getPost());
            /* inquiry number generate */
                $orderBy[0] = ['field' => 'id', 'type' => 'DESC'];
                $checkEmployee = $this->common_model->find_data('ecoex_admin_user', 'row', '', '', '', '', $orderBy);
                if($checkEmployee){
                    $slNo = $checkEmployee->sl_no+1;
                    $employee_nos = str_pad($slNo,4,0,STR_PAD_LEFT);
                    $employee_id = 'ECOEX-'.$employee_nos;
                } else {
                    $slNo = 1;
                    $employee_nos = str_pad($slNo,4,0,STR_PAD_LEFT);
                    $employee_id = 'ECOEX-'.$employee_nos;
                }
            /* inquiry number generate */
            $email = $this->request->getPost('email');
            $checkSubUser = $this->common_model->find_data('ecoex_admin_user', 'count', ['username' => $email]);
            if($checkSubUser <= 0){
                $team_members = $this->request->getPost('team_members');
                $postData = [
                        'sl_no'                       => $slNo,
                        'employee_no'                 => $employee_id,
                        'user_type'                   => $this->request->getPost('user_type'),
                        'team_members'                => (($team_members != '')?json_encode($this->request->getPost('team_members')):json_encode([])),
                        'role_id'                     => $this->request->getPost('role_id'),
                        'name'                        => $this->request->getPost('name'),
                        'mobileNo'                    => $this->request->getPost('mobileNo'),
                        'username'                    => $this->request->getPost('email'),
                        'password'                    => md5($this->request->getPost('password')),
                        'original_password'           => $this->request->getPost('password'),
                        'email'                       => $this->request->getPost('email'),
                        'present_address'             => $this->request->getPost('present_address'),
                        'permanent_address'           => $this->request->getPost('permanent_address'),
                        ];
                // pr($postData);
                $addUserData=$this->common_model->save_data('ecoex_admin_user', $postData, '', 'id');
                if($addUserData){
                    /* login credentials email */
                        $base = base_url('/admin');
                        $emailTemplate      = $this->common_model->find_data('ecoex_email_template', 'row', ['id' => 12]);
                        $to2                = $this->request->getPost('email');
                        $subject2           = "Welcome ".$this->request->getPost('name')." to Ecoex Portal";                        
                        $emailTemplate    = str_replace("{company}", $this->request->getPost('name'), $emailTemplate->content);
                        $emailTemplate1   = str_replace("{customer_email}", $this->request->getPost('email'), $emailTemplate);
                        $emailTemplate2   = str_replace("{password}", $this->request->getPost('password'), $emailTemplate1);
                        $message2         = str_replace("{login_link}", $base , $emailTemplate2);
                        // echo $message2;die;
                        $this->common_model->sendEmail($to2,$subject2,$message2);
                    /* login credentials email */
                }
                $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            } else {
                $this->session->setFlashdata('success_message', $this->data['title'].' already exists');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            }
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function edit($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'sub-users/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $data['roles']              = $this->common_model->find_data('ecoex_roles', 'array', ['published' => 1]);
        $data['subusers']           = $this->common_model->find_data('ecoex_admin_user', 'array', ['status' => 1, 'user_type!=' => 'MA']);
        if($this->request->getMethod() == 'post') {
            $email = $this->request->getPost('email');
            $checkSubUser = $this->common_model->find_data('ecoex_admin_user', 'count', ['username' => $email, 'id!=' => $id]);
            if($checkSubUser <= 0){
                $team_members = $this->request->getPost('team_members');
                $postData = [
                            'user_type'                   => $this->request->getPost('user_type'),
                            'team_members'                => (($team_members != '')?json_encode($this->request->getPost('team_members')):json_encode([])),
                            'role_id'                     => $this->request->getPost('role_id'),
                            'name'                        => $this->request->getPost('name'),
                            'mobileNo'                    => $this->request->getPost('mobileNo'),
                            'username'                    => $this->request->getPost('email'),
                            'password'                    => md5($this->request->getPost('password')),
                            'original_password'           => $this->request->getPost('password'),
                            'email'                       => $this->request->getPost('email'),
                            'present_address'             => $this->request->getPost('present_address'),
                            'permanent_address'           => $this->request->getPost('permanent_address'),
                            'updatedAt'                   => date('Y-m-d H:i:s')
                        ];
                // pr($postData);
                $this->common_model->save_data('ecoex_admin_user', $postData, $id, 'id');
                $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            } else {
                $this->session->setFlashdata('success_message', $this->data['title'].' already exists');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            }
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