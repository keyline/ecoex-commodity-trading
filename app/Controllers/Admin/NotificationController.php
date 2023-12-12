<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class NotificationController extends BaseController {

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
            'title'                 => 'Notifications',
            'controller_route'      => 'notifications',
            'controller'            => 'NotificationController',
            'table_name'            => 'notifications',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'notification/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status!=' => 3], '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'notification/add-edit';        
        $data['row']                = [];
        if($this->request->getMethod() == 'post') {
            $users      = [];
            $user_type  = $this->request->getPost('user_type');
            $getUsers   = $this->common_model->find_data('ecomm_users', 'array', ['status!=' => 3, 'type' => $user_type], 'id');
            if($getUsers){
                foreach($getUsers as $getUser){
                    $users[]      = $getUser->id;
                }
            }
            $postData   = array(
                'title'             => $this->request->getPost('title'),
                'description'       => $this->request->getPost('description'),
                'user_type'         => $user_type,
                'users'             => json_encode($users),
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
        $page_name                  = 'notification/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);

        if($this->request->getMethod() == 'post') {
            $users      = [];
            $user_type  = $this->request->getPost('user_type');
            $getUsers   = $this->common_model->find_data('ecomm_users', 'array', ['status!=' => 3, 'type' => $user_type], 'id');
            if($getUsers){
                foreach($getUsers as $getUser){
                    $users[]      = $getUser->id;
                }
            }
            $postData   = array(
                'title'             => $this->request->getPost('title'),
                'description'       => $this->request->getPost('description'),
                'user_type'         => $user_type,
                'users'             => json_encode($users),
            );
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
    public function send($id)
    {
        $id                         = decoded($id);
        $getNotification            = $this->data['model']->find_data($this->data['table_name'], 'row', ['id' => $id]);
        if($getNotification){
            $users      = json_decode($getNotification->users);
            if(!empty($users)){
                for($n=0;$n<count($users);$n++){
                    $getDeviceToken            = $this->data['model']->find_data('ecomm_user_devices', 'array', ['user_id' => $users[$n], 'fcm_token!=' => ''], 'device_token');
                    if($getDeviceToken){
                        $device_token = $getDeviceToken->device_token;
                        if($device_token != ''){
                            $messageData = [
                                'title'     => $getNotification->title,
                                'body'      => $getNotification->description,
                                'badge'     => 1,
                                'sound'     => 'Default'
                            ];
                            $this->pushNotification($device_token, $messageData);
                        }
                    }
                }
            }
            $postData = array(
                                'status'            => 1,
                                'is_send'           => 1,
                                'send_timestamp'    => date('Y-m-d H:i:s'),
                            );
            $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' send successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        } else {
            $this->session->setFlashdata('error_message', $this->data['title'].' not found');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
    }
}