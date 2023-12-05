<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class PendingProductController extends BaseController {

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
            'title'                 => 'Pending Product',
            'controller_route'      => 'pending-products',
            'controller'            => 'PendingProductController',
            'table_name'            => 'ecomm_pending_products',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'pending-products/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status!=' => 3], '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'pending-products/add-edit';        
        $data['row']                = [];
        $orderBy[0]                 = ['field' => 'name', 'type' => 'ASC'];
        $data['cats']               = $this->data['model']->find_data('ecomm_product_categories', 'array', ['status' => 1], 'id,name', '', '', $orderBy);
        if($this->request->getMethod() == 'post') {
            /* profile image */
                $file = $this->request->getFile('product_image');
                $originalName = $file->getClientName();
                $fieldName = 'product_image';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'enquiry','image');
                    if($upload_array['status']) {
                        $product_image = $upload_array['newFilename'];
                    } else {
                        $product_image = '';
                    }
                } else {
                    $product_image = '';
                }
            /* profile image */
            $postData   = array(
                'category_id'           => $this->request->getPost('category_id'),
                'name'                  => $this->request->getPost('name'),
                'hsn_code'              => $this->request->getPost('hsn_code'),
                'description'           => $this->request->getPost('description'),
                'product_image'         => $product_image,
                'created_by'            => $this->session->get('user_id'),
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
        $page_name                  = 'pending-products/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $orderBy[0]                 = ['field' => 'name', 'type' => 'ASC'];
        $data['cats']               = $this->data['model']->find_data('ecomm_product_categories', 'array', ['status' => 1], 'id,name', '', '', $orderBy);
        if($this->request->getMethod() == 'post') {
            /* profile image */
                $file = $this->request->getFile('product_image');
                $originalName = $file->getClientName();
                $fieldName = 'product_image';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'enquiry','image');
                    if($upload_array['status']) {
                        $product_image = $upload_array['newFilename'];
                    } else {
                        $product_image = $data['row']->product_image;
                    }
                } else {
                    $product_image = $data['row']->product_image;
                }
            /* profile image */
            $postData   = array(
                'category_id'           => $this->request->getPost('category_id'),
                'product_name'          => $this->request->getPost('product_name'),
                'hsn_code'              => $this->request->getPost('hsn_code'),
                'product_image'         => $product_image,
                'updated_by'            => $this->session->get('user_id'),
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
}