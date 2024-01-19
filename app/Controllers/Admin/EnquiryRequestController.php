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
        $userType                   = $this->session->user_type;
        $company_id                 = $this->session->company_id;
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
        if($userType == 'MA'){
            $conditions                 = ['status' => $status];
        } else {
            $conditions                 = ['status' => $status, 'company_id' => $company_id];
        }
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', $conditions, '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function viewDetail($enq_id)
    {
        $enq_id                     = decoded($enq_id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', ['id' => $enq_id]);
        $data['moduleDetail']       = $this->data;
        $data['enquiryStatus']      = (($data['row'])?$data['row']->status:1);
        $data['enquiryProducts']    = $this->data['model']->find_data('ecomm_enquiry_products', 'array', ['enq_id' => $enq_id]);
        $data['enquiryPendingProducts']    = $this->data['model']->find_data('ecomm_enquiry_products', 'array', ['enq_id' => $enq_id, 'status' => 0]);

        $company_id                 = $data['row']->company_id;
        $orderBy[0]                 = ['field' => 'category_alias', 'type' => 'ASC'];
        $data['cats']               = $this->common_model->find_data('ecomm_company_category', 'array', ['status' => 1, 'company_id' => $company_id], 'category_id,category_alias', '', '', $orderBy);

        $orderBy[0]                 = ['field' => 'name', 'type' => 'ASC'];
        $data['units']              = $this->common_model->find_data('ecomm_units', 'array', ['status' => 1], 'id,name', '', '', $orderBy);

        $order_by[0]                = array('field' => 'id', 'type' => 'asc');
        $conditions                 = array('company_id' => $company_id, 'status!=' => 3);
        $data['assignItems']        = $this->data['model']->find_data('ecomm_company_items', 'array', $conditions, '', '', '', $order_by);

        $order_by[0]                = array('field' => 'company_name', 'type' => 'asc');
        $data['avlVendors']            = $this->data['model']->find_data('ecomm_users', 'array', ['type' => 'VENDOR', 'status>=' => 1], 'id,company_name', '', '', $order_by);

        if($this->request->getMethod() == 'post') {
            if($this->request->getPost('mode') == 'share_vendor'){
                $enq_id         = $this->request->getPost('enq_id');
                $company_id     = $this->request->getPost('company_id');
                $plant_id       = $this->request->getPost('plant_id');
                $vendors        = $this->request->getPost('vendors');
                if(!empty($vendors)){
                    for($v=0;$v<count($vendors);$v++){
                        $fields = [
                            'enq_id'        => $enq_id,
                            'company_id'    => $company_id,
                            'plant_id'      => $plant_id,
                            'vendor_id'     => $vendors[$v],
                        ];
                        $this->common_model->save_data('ecomm_enquiry_vendor_shares', $fields, '', 'id');
                        /* mail functionality */
                            $getVendor                  = $this->common_model->find_data('ecomm_users', 'row', ['id' => $vendors[$v]]);
                            $getEnquiry                 = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $enq_id]);
                            $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                            $subject                    = $generalSetting->site_name.' :: Enquiry Quotation Request Sent ('.(($getEnquiry)?$getEnquiry->enquiry_no:'').') ';
                            $message                    = view('email-templates/enquiry-request-for-quotation',$fields);
                            $this->sendMail($getVendor->email, $subject, $message);
                        /* mail functionality */
                        /* email log save */
                            $postData2 = [
                                'name'                  => $getVendor->company_name,
                                'email'                 => $getVendor->email,
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            $this->common_model->save_data('email_logs', $postData2, '', 'id');
                        /* email log save */
                        /* send push */
                            $getDeviceTokens            = $this->common_model->find_data('ecomm_user_devices', 'array', ['user_id' => $vendors[$v], 'fcm_token!=' => ''], 'fcm_token');
                            if($getDeviceTokens){
                                foreach($getDeviceTokens as $getDeviceToken){
                                    $fcm_token          = $getDeviceToken->fcm_token;
                                    $messageData = [
                                        'title'     => 'Enquiry Quotation Submission Invited',
                                        'body'      => 'Enquiry Request ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Quotation Submission Invited By EcoEx',
                                        'badge'     => 1,
                                        'sound'     => 'Default',
                                        'data'      => [],
                                    ];
                                    $this->pushNotification($fcm_token, $messageData);
                                    $users[]    = $vendors[$v];
                                    $pushData   = [
                                        'source'            => 'FROM APP',
                                        'title'             => 'Enquiry Quotation Submission Invited',
                                        'description'       => 'Enquiry Request ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Quotation Submission Invited By EcoEx',
                                        'user_type'         => 'VENDOR',
                                        'users'             => json_encode($users),
                                        'is_send'           => 1,
                                        'send_timestamp'    => date('Y-m-d H:i:s'),
                                        'status'            => 1,
                                    ];
                                    $this->common_model->save_data('notifications', $pushData, '', 'id');
                                }
                            }
                        /* send push */
                    }
                    $this->session->setFlashdata('success_message', $this->data['title'].'  Details Successfully Shared To Vendors For Quotation Invitation !!!');
                    return redirect()->to(current_url());
                } else {
                    $this->session->setFlashdata('error_message', 'Atleast One Vendor Needs To Be Select Before Share Details To Vendors !!!');
                    return redirect()->to(current_url());
                }
            }
        }

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
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list/'.encoded(0));
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
        $getEnquiry                 = $this->common_model->find_data($this->data['table_name'], 'row', ['id' => $id]);
        if($getEnquiry){
            $pendingItemCount       = $this->common_model->find_data('ecomm_enquiry_products', 'count', ['enq_id' => $id, 'status' => 0]);
            if($pendingItemCount <= 0){
                /* send push */
                    $getDeviceTokens            = $this->common_model->find_data('ecomm_user_devices', 'array', ['user_id' => $getEnquiry->plant_id, 'fcm_token!=' => ''], 'fcm_token');
                    if($getDeviceTokens){
                        foreach($getDeviceTokens as $getDeviceToken){
                            $fcm_token          = $getDeviceToken->fcm_token;
                            $messageData = [
                                'title'     => 'Enquiry Request Accepted',
                                'body'      => 'Enquiry Request ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Accepted By EcoEx',
                                'badge'     => 1,
                                'sound'     => 'Default',
                                'data'      => [],
                            ];
                            $this->pushNotification($fcm_token, $messageData);
                            $users[]    = $getEnquiry->plant_id;
                            $pushData   = [
                                'source'            => 'FROM APP',
                                'title'             => 'Enquiry Request Accepted',
                                'description'       => 'Enquiry Request ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Accepted By EcoEx',
                                'user_type'         => 'PLANT',
                                'users'             => json_encode($users),
                                'is_send'           => 1,
                                'send_timestamp'    => date('Y-m-d H:i:s'),
                                'status'            => 1,
                            ];
                        $this->common_model->save_data('notifications', $pushData, '', 'id');
                        }
                    }
                /* send push */
                $postData = array(
                                    'status'                    => 1,
                                    'enquiry_remarks'           => 'Approved By EcoEx',
                                    'accepted_date'             => date('y-m-d H:i:s')
                                );
                $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
                $this->session->setFlashdata('success_message', $this->data['title'].' Accepted Successfully & Transfer To Sent/Submitted List !!!');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list/'.encoded(1));
            } else {
                $this->session->setFlashdata('error_message', $pendingItemCount.' Pending Items In '.$getEnquiry->enquiry_no.'. Please Approve The Same Before Accept Enquiry Request !!!');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list/'.encoded(0));
            }
        } else {
            $this->session->setFlashdata('success_message', $this->data['title'].' Not Found !!!');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list/'.encoded(0));
        }
    }
    public function reject_request($id)
    {
        $id                         = decoded($id);
        $getEnquiry                 = $this->common_model->find_data($this->data['table_name'], 'row', ['id' => $id]);
        if($getEnquiry){
            /* send push */
                $getDeviceTokens            = $this->common_model->find_data('ecomm_user_devices', 'array', ['user_id' => $getEnquiry->plant_id, 'fcm_token!=' => ''], 'fcm_token');
                if($getDeviceTokens){
                    foreach($getDeviceTokens as $getDeviceToken){
                        $fcm_token          = $getDeviceToken->fcm_token;
                        $messageData = [
                            'title'     => 'Enquiry Request Rejected',
                            'body'      => 'Enquiry Request ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Rejected By EcoEx',
                            'badge'     => 1,
                            'sound'     => 'Default',
                            'data'      => [],
                        ];
                        $this->pushNotification($fcm_token, $messageData);
                        $users[]    = $getEnquiry->plant_id;
                        $pushData   = [
                            'source'            => 'FROM APP',
                            'title'             => 'Enquiry Request Rejected',
                            'description'       => 'Enquiry Request ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Rejected By EcoEx',
                            'user_type'         => 'PLANT',
                            'users'             => json_encode($users),
                            'is_send'           => 1,
                            'send_timestamp'    => date('Y-m-d H:i:s'),
                            'status'            => 1,
                        ];
                        $this->common_model->save_data('notifications', $pushData, '', 'id');
                    }
                }
            /* send push */
            $postData = array(
                                'status'                    => 9,
                                'enquiry_remarks'           => $this->request->getPost('enquiry_remarks'),
                                'accepted_date'             => date('Y-m-d H:i:s')
                            );
            $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);

            $postData2 = array(
                'enq_id'                    => $id,
                'remarks'                   => $this->request->getPost('enquiry_remarks'),
                'rejected_timestamp'        => date('Y-m-d H:i:s'),
                'status'                    => 9,
            );
            $updateData = $this->common_model->save_data('ecomm_rejected_requests',$postData2,'',$this->data['primary_key']);

            $this->session->setFlashdata('success_message', $this->data['title'].' Rejected Successfully & Transfer To Rejected List !!!');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list/'.encoded(9));
        } else {
            $this->session->setFlashdata('error_message', $this->data['title'].' Not Found !!!');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list/'.encoded(0));
        }
    }
    public function getRejectModal(){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $requestData        = $this->request->getPost();
        $enq_id             = $requestData['enq_id'];
        $getEnquiry         = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $enq_id]);
        $actionLink         = base_url('admin/' . $this->data['controller_route'] . '/reject-request/'.encoded($enq_id));
        $modalHeader        = '<h6>Reject Request : '.(($getEnquiry)?$getEnquiry->enquiry_no:'').'</h6>';
        $modalBody          =   '<form method="POST" action="'.$actionLink.'">
                                    <input type="hidden" name="enq_id" value="'.$enq_id.'">
                                    <div class="form-group mb-3">
                                        <label for="enquiry_remarks">Remarks</label>
                                        <textarea name="enquiry_remarks" id="enquiry_remarks" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                </form>';
        $apiResponse        = [
            'title' => $modalHeader,
            'body'  => $modalBody,
        ];
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    }
    public function getImageModal(){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $requestData        = $this->request->getPost();
        $enq_id             = $requestData['enq_id'];
        $getEnquiry         = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $enq_id]);
        $modalHeader        = '<b>Enquiry Request Images : '.(($getEnquiry)?$getEnquiry->enquiry_no:'').'</b>';
        $enqImages          = $this->common_model->find_data('ecomm_enquiry_products', 'array', ['enq_id' => $enq_id], 'new_product_image');
        $enquiryImages      = [];
        if($enqImages){
            foreach($enqImages as $enqImage){
                $new_product_images = json_decode($enqImage->new_product_image);
                if(!empty($new_product_images)){
                    for($i=0;$i<count($new_product_images);$i++){
                        $enquiryImages[]      = getenv('app.uploadsURL').'enquiry/'.$new_product_images[$i];
                    }
                }
            }
        }
        $engImageHTML = '';
        if(!empty($enquiryImages)){
            for($enqImg=0;$enqImg<count($enquiryImages);$enqImg++){
                $engImageHTML .= '<div class="item">
                                    <div class="sucess_boximg">
                                        <img src="'.$enquiryImages[$enqImg].'" class="img-fluid" alt="image">
                                    </div>
                                </div>';
            }
        }
        $modalBody          =   '<div id="home-successstories" class="owl-carousel owl-theme owl-loaded owl-drag">
                                '.$engImageHTML.'
                                </div>';
        // $modalBody = $engImageHTML;
        $apiResponse        = [
            'title' => $modalHeader,
            'body'  => $modalBody,
        ];
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    }
}