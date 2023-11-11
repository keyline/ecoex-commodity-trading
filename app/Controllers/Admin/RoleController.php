<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class RoleController extends BaseController {

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
            'title'                 => 'Role',
            'controller_route'      => 'roles',
            'controller'            => 'RoleController',
            'table_name'            => 'ecoex_roles',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'role/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['published!=' => 3], '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'role/add-edit';        
        $data['row']                = [];
        $data['parentModules']      = $this->common_model->find_data('ecoex_modules', 'array', ['parent_id' => 0, 'published' => 1]);
        $data['features']           = $this->common_model->find_data('ecoex_features', 'array', ['published' => 1]);
        if($this->request->getMethod() == 'post') {
            $postData   = array(
                'role_name'           => $this->request->getPost('role_name'),
            );
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);
            /* role module functions */
                $module_id = $this->request->getPost('module_id');
                if(!empty($module_id)){
                    for($mf=0;$mf<count($module_id);$mf++){
                        $function_id = $this->request->getPost('function_id'.$module_id[$mf]);
                        if(!empty($function_id)){
                            for($f=0;$f<count($function_id);$f++){
                                $fields = [
                                    'role_id'               => $record,
                                    'module_id'             => $module_id[$mf],
                                    'function_id'           => $function_id[$f],
                                ];
                                $this->data['model']->save_data('ecoex_role_module_function', $fields, '', 'function_id');
                            }
                        }
                    }
                }
            /* role module functions */
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
        $page_name                  = 'role/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $data['parentModules']      = $this->common_model->find_data('ecoex_modules', 'array', ['parent_id' => 0, 'published' => 1]);
        $data['features']           = $this->common_model->find_data('ecoex_features', 'array', ['published' => 1]);
        if($this->request->getMethod() == 'post') {
            // pr($this->request->getPost());
            $postData   = array(
                'role_name'           => $this->request->getPost('role_name'),
            );
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            /* module functions */
                $module_id = $this->request->getPost('module_id');
                if(!empty($module_id)){
                    $this->common_model->save_data('ecoex_role_module_function', ['published' => 3], $id, 'role_id');
                    for($mf=0;$mf<count($module_id);$mf++){
                        $function_id = $this->request->getPost('function_id'.$module_id[$mf]);
                        if(!empty($function_id)){
                            for($f=0;$f<count($function_id);$f++){
                                $checkRoleModuleFunctionExist = $this->common_model->find_data('ecoex_role_module_function', 'row', ['role_id' => $id, 'module_id' => $module_id[$mf], 'function_id' => $function_id[$f]]);
                                if($checkRoleModuleFunctionExist){ // update
                                    $fields = [
                                        'published'             => 1,
                                    ];
                                    $this->data['model']->save_data('ecoex_role_module_function', $fields, $checkRoleModuleFunctionExist->id, 'id');
                                } else { //insert
                                    $fields = [
                                        'role_id'               => $id,
                                        'module_id'             => $module_id[$mf],
                                        'function_id'           => $function_id[$f],
                                    ];
                                    $this->data['model']->save_data('ecoex_role_module_function', $fields, '', 'function_id');
                                }
                            }
                        }
                    }
                }
            /* module functions */
            $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function confirm_delete($id)
    {
        $id                         = decoded($id);
        $postData = array(
                            'published' => 3
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function change_status($id)
    {
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        if($data['row']->published){
            $published  = 0;
            $msg        = 'Deactivated';
        } else {
            $published  = 1;
            $msg        = 'Activated';
        }
        $postData = array(
                            'published' => $published
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
}