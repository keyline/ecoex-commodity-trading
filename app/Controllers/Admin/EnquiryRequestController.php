<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class EnquiryRequestController extends BaseController {

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
            'title'                 => 'Enquiry Request',
            'controller_route'      => 'enquiry-requests',
            'controller'            => 'EnquiryRequestController',
            'table_name'            => 'ecomm_enquires',
            'primary_key'           => 'id'
        );
    }
    public function list($status)
    {
        $status                     = decoded($status);
        $data['moduleDetail']       = $this->data;
        if($status == 0){
            $stepName = 'Request Pending';
        } elseif($status == 1){
            $stepName = 'Sent/Submitted';
        } elseif($status == 2){
            $stepName = 'Accepted/Rejected';
        } elseif($status == 3){
            $stepName = 'Pickup';
        } elseif($status == 4){
            $stepName = 'Vehicle Placed';
        } elseif($status == 5){
            $stepName = 'Vehicle Ready Despatch';
        } elseif($status == 6){
            $stepName = 'Material Lifted';
        } elseif($status == 7){
            $stepName = 'Invoiced';
        } elseif($status == 8){
            $stepName = 'Completed';
        } elseif($status == 9){
            $stepName = 'Rejected';
        }
        $title                      = 'Manage '.$this->data['title'] . ' : '.$stepName;
        $page_name                  = 'enquiry-request/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status' => $status], '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function viewDetail($enq_id)
    {
        $enq_id                     = decoded($enq_id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', ['id' => $enq_id]);
        $data['moduleDetail']       = $this->data;
        $data['enquiryStatus']      = (($data['row'])?$data['row']->status:1);
        $data['enquiryProducts']    = $this->data['model']->find_data('ecomm_enquiry_products', 'array', ['enq_id' => $enq_id]);

        $title                      = 'View Details Of '.$data['row']->enquiry_no;
        $page_name                  = 'enquiry-request/view-details';
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function confirm_delete($id)
    {
        $id                         = decoded($id);
        $postData = array(
                            'status' => 10
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
    public function accept_request($id)
    {
        $id                         = decoded($id);
        $postData = array(
                            'status'        => 1,
                            'accepted_date' => date('y-m-d H:i:s')
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' Accepted Successfully & Transfer To Sent/Submitted List !!!');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list/'.encoded(1));
    }
}