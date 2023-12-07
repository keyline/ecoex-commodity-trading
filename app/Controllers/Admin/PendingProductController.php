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
                'remarks'               => $this->request->getPost('remarks'),
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

        /* insert product in product master */
            $fields = [
                'category_id'       => $data['row']->category_id,
                'name'              => $data['row']->product_name,
                'description'       => '',
                'hsn_code'          => $data['row']->hsn_code,
                'product_image'     => $data['row']->product_image,
                'created_by'        => 1,
                'updated_by'        => 1,
            ];
            // pr($fields);
            $product_id = $this->common_model->save_data('ecomm_products', $fields, '', 'id');
        /* insert product in product master */

        $postData = array(
                            'status'        => $status,
                            'product_id'    => $product_id,
                            'approved_date' => date('Y-m-d H:i:s'),
                        );
        $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);

        /* update product id in enquiry products */
            $fields2 = [
                'new_product'       => 0,
                'product_id'        => $product_id,
                'hsn'               => $data['row']->hsn_code,
                'remarks'           => $data['row']->remarks,
                'status'            => 1,
                'approved_date'     => date('Y-m-d H:i:s'),
            ];
            // pr($fields2);
            $this->common_model->save_data('ecomm_enquiry_products', $fields2, $data['row']->enq_product_id, 'id');
        /* update product id in enquiry products */

        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
}