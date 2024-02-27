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
        if(!$this->common_model->checkModuleFunctionAccess(23,104)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        
        $userType                   = $this->session->user_type;
        $company_id                 = $this->session->company_id;
        $status                     = decoded($status);
        $data['current_status']     = $status;
        $data['moduleDetail']       = $this->data;

        if($status == 0){
            $stepName = 'Request Submitted';
        } elseif($status == 1){
            $stepName = 'Accept Request';
        } elseif($status == 2){
            $stepName = 'Vendor Allocated';
        } elseif($status == 3){
            $stepName = 'Vendor Assigned';
        } elseif($status == 4){
            $stepName = 'Pickup Scheduled';
        } elseif($status == 5){
            $stepName = 'Vehicle Placed';
        } elseif($status == 6){
            $stepName = 'Material Weighed';
        } elseif($status == 7){
            $stepName = 'Invoice from HO';
        } elseif($status == 8){
            $stepName = 'Invoice to Vendor';
        } elseif($status == 9){
            $stepName = 'Payment received from Vendor';
        } elseif($status == 10){
            $stepName = 'Vehicle Dispatched';
        } elseif($status == 11){
            $stepName = 'Payment to HO';
        } elseif($status == 12){
            $stepName = 'Order Complete';
        } elseif($status == 13){
            $stepName = 'Reject Request';
        }

        $title                      = 'Manage '.$this->data['title'] . ' : '.$stepName;
        $page_name                  = 'enquiry-request/list';

        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        if($userType == 'MA'){
            $conditions                 = ['status' => $status];
        } elseif($userType == 'U'){
            $conditions                 = ['status' => $status];
        } else {
            $conditions                 = ['status' => $status, 'company_id' => $company_id];
        }
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', $conditions, '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function viewDetail($enq_id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(23,109)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $enq_id                     = decoded($enq_id);
        $data['enq_id']             = $enq_id;
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
        $data['avlVendors']         = $this->data['model']->find_data('ecomm_users', 'array', ['type' => 'VENDOR', 'status>=' => 1], 'id,company_name', '', '', $order_by);

        $data['sharedVendors']      = $this->common_model->find_data('ecomm_enquiry_vendor_shares', 'array', ['enq_id' => $enq_id]);

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
                        $this->common_model->save_data('ecomm_enquires', ['status' => 2], $enq_id, 'id');
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
    public function confirm_delete($id, $current_status)
    {
        if(!$this->common_model->checkModuleFunctionAccess(23,107)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $id                         = decoded($id);
        $postData = array(
                            'status' => 10
                        );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list/'.encoded($current_status));
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
    public function quotation_access($enq_id, $vendor_id)
    {
        $enq_id                     = decoded($enq_id);
        $getEnquiry                 = $this->data['model']->find_data('ecomm_enquires', 'row', ['id' => $enq_id]);
        $vendor_id                  = decoded($vendor_id);
        $data['row']                = $this->data['model']->find_data('ecomm_enquiry_vendor_shares', 'row', ['enq_id' => $enq_id, 'vendor_id' => $vendor_id]);
        if($data['row']){
            $id = $data['row']->id;
            if($data['row']->is_editable){
                $is_editable  = 0;
                $msg        = 'Access Closed';
            } else {
                $is_editable  = 1;
                $msg        = 'Access Opened';
            }
            $postData = array(
                                'is_editable' => $is_editable
                            );
            $updateData = $this->common_model->save_data('ecomm_enquiry_vendor_shares', $postData, $id, 'id');

            /* send push */
                $getDeviceTokens            = $this->common_model->find_data('ecomm_user_devices', 'array', ['user_id' => $vendor_id, 'fcm_token!=' => ''], 'fcm_token');
                if($getDeviceTokens){
                    foreach($getDeviceTokens as $getDeviceToken){
                        $fcm_token          = $getDeviceToken->fcm_token;
                        $messageData = [
                            'title'     => 'Enquiry Request Quotation Edit '.$msg,
                            'body'      => 'Enquiry Request ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Quotation Edit '.$msg.' By EcoEx',
                            'badge'     => 1,
                            'sound'     => 'Default',
                            'data'      => [],
                        ];
                        $this->pushNotification($fcm_token, $messageData);
                        $users[]    = $getEnquiry->plant_id;
                        $pushData   = [
                            'source'            => 'FROM APP',
                            'title'             => 'Enquiry Request Quotation Edit '.$msg,
                            'description'       => 'Enquiry Request ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Quotation Edit '.$msg.' By EcoEx',
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
            /* send mail */
                $fields = [
                    'enq_id'        => $enq_id,
                    'company_id'    => (($getEnquiry)?$getEnquiry->company_id:0),
                    'plant_id'      => (($getEnquiry)?$getEnquiry->plant_id:0),
                    'vendor_id'     => $vendor_id,
                    'msg'           => $msg,
                ];
                $getVendor                  = $this->common_model->find_data('ecomm_users', 'row', ['id' => $vendor_id]);
                $getEnquiry                 = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $enq_id]);
                $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                $subject                    = $generalSetting->site_name.' :: Enquiry Quotation Request Edit Access ('.(($getEnquiry)?$getEnquiry->enquiry_no:'').') ';
                $message                    = view('email-templates/enquiry-request-for-quotation-edit-access',$fields);
                $this->sendMail($getVendor->email, $subject, $message);
            /* send mail */

            $this->session->setFlashdata('success_message', 'Vendor Quotation Edit '.$msg.' Successfully !!!');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/view-detail/'.encoded($enq_id));
        } else {
            $this->session->setFlashdata('success_message', 'Enquiry Vendor Not Found !!!');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/view-detail/'.encoded($enq_id));
        }
    }
    public function accept_request($id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(23,110)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
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
        if(!$this->common_model->checkModuleFunctionAccess(23,111)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
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
                                'status'                    => 13,
                                'enquiry_remarks'           => $this->request->getPost('enquiry_remarks'),
                                'accepted_date'             => date('Y-m-d H:i:s')
                            );
            $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);

            $postData2 = array(
                'enq_id'                    => $id,
                'remarks'                   => $this->request->getPost('enquiry_remarks'),
                'rejected_timestamp'        => date('Y-m-d H:i:s'),
                'status'                    => 13,
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
    public function viewQuotationLogs($enq_id, $vendor_id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(23,109)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $enq_id                     = decoded($enq_id);
        $vendor_id                  = decoded($vendor_id);
        $data['enq_id']             = $enq_id;
        $data['vendor_id']          = $vendor_id;
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', ['id' => $enq_id]);
        $data['vendor']             = $this->data['model']->find_data('ecomm_users', 'row', ['id' => $vendor_id], 'id,company_name');
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
        $data['avlVendors']         = $this->data['model']->find_data('ecomm_users', 'array', ['type' => 'VENDOR', 'status>=' => 1], 'id,company_name', '', '', $order_by);

        $data['sharedVendors']      = $this->common_model->find_data('ecomm_enquiry_vendor_shares', 'array', ['enq_id' => $enq_id]);
        $data['enquiryItems']       = $this->common_model->find_data('ecomm_enquiry_products', 'array', ['enq_id' => $enq_id]);

        $title                      = 'View Quotation Logs Of '.(($data['vendor'])?$data['vendor']->company_name:'').' Within '.$data['row']->enquiry_no;
        $page_name                  = 'enquiry-request/view-quotation-logs';
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function vendorAllocation($enq_id, $vendor_id, $item_id){
        if(!$this->common_model->checkModuleFunctionAccess(23,109)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $enq_id                     = decoded($enq_id);
        $vendor_id                  = decoded($vendor_id);
        $item_id                    = decoded($item_id);
        $data['enq_id']             = $enq_id;
        $data['vendor_id']          = $vendor_id;
        $data['item_id']            = $item_id;

        $getEnquiry                 = $this->data['model']->find_data('ecomm_enquires', 'row', ['id' => $enq_id]);
        $getEnquiryProductCount     = $this->data['model']->find_data('ecomm_enquiry_products', 'count', ['enq_id' => $enq_id]);
        $getProduct                 = $this->data['model']->find_data('ecomm_company_items', 'row', ['id' => $item_id], 'id,item_name_ecoex');
        $getVendor                  = $this->data['model']->find_data('ecomm_users', 'row', ['id' => $vendor_id], 'id,company_name');
        $enquiry_no                 = (($getEnquiry)?$getEnquiry->enquiry_no:'');
        /* sl no*/
            $checkEnq = $this->common_model->find_data('ecomm_sub_enquires', 'row', ['enq_id' => $enq_id], 'sub_sl_no,vendor_id,max(sub_sl_no) as max_sub_sl_no');
            if($checkEnq->max_sub_sl_no != ''){
                $checkEnqVendor = $this->common_model->find_data('ecomm_sub_enquires', 'row', ['enq_id' => $enq_id, 'vendor_id' => $vendor_id], 'sub_sl_no,vendor_id');
                if($checkEnqVendor){
                    $sub_sl_no         = $checkEnqVendor->sub_sl_no;
                } else {
                    $sub_sl_no         = $checkEnq->max_sub_sl_no + 1;
                }
            } else {
                $sub_sl_no         = 0;
            }
            $alphabet       = range('A', 'Z');
            $getCharacter   = $alphabet[$sub_sl_no];
            $sub_enquiry_no = $enquiry_no.'-'.$getCharacter;
        /* sl no*/
        $getQuotation = $this->common_model->find_data("ecomm_enquiry_vendor_quotations", 'row', ['enq_id' => $enq_id, 'vendor_id' => $vendor_id, 'item_id' => $item_id]);
        $fields = [
            'enq_id'                    => $enq_id,
            'company_id'                => (($getEnquiry)?$getEnquiry->company_id:0),
            'plant_id'                  => (($getEnquiry)?$getEnquiry->plant_id:0),
            'enquiry_no'                => $enquiry_no,
            'vendor_id'                 => $vendor_id,
            'item_id'                   => $item_id,
            'sub_sl_no'                 => $sub_sl_no,
            'sub_enquiry_no'            => $sub_enquiry_no,
            'win_quote_price'           => (($getQuotation)?$getQuotation->quote_price:0),
            'status'                    => 3.3,
            'main_status'               => 3,
            'assigned_date'             => date('Y-m-d H:i:s'),
        ];
        $this->common_model->save_data('ecomm_sub_enquires', $fields, '', 'id');
        /* send push */
            $getDeviceTokens            = $this->common_model->find_data('ecomm_user_devices', 'array', ['user_id' => $vendor_id, 'fcm_token!=' => ''], 'fcm_token');
            if($getDeviceTokens){
                foreach($getDeviceTokens as $getDeviceToken){
                    $fcm_token          = $getDeviceToken->fcm_token;
                    $messageData = [
                        'title'     => 'Enquiry Assigned To You',
                        'body'      => 'Enquiry ('.$sub_enquiry_no.') Assigned To You By EcoEx',
                        'badge'     => 1,
                        'sound'     => 'Default',
                        'data'      => [],
                    ];
                    $this->pushNotification($fcm_token, $messageData);
                    $users[]    = $getEnquiry->plant_id;
                    $pushData   = [
                        'source'            => 'FROM APP',
                        'title'             => 'Enquiry Assigned To You',
                        'description'       => 'Enquiry ('.$sub_enquiry_no.') Assigned To You By EcoEx',
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
        /* send mail */
            $fields = [
                'enq_id'                => $enq_id,
                'company_id'            => (($getEnquiry)?$getEnquiry->company_id:0),
                'plant_id'              => (($getEnquiry)?$getEnquiry->plant_id:0),
                'vendor_id'             => $vendor_id,
                'sub_enquiry_no'        => $sub_enquiry_no,
                'msg'                   => 'Enquiry ('.$sub_enquiry_no.') Assigned To You By EcoEx',
            ];
            $getVendor                  = $this->common_model->find_data('ecomm_users', 'row', ['id' => $vendor_id]);
            $getEnquiry                 = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $enq_id]);
            $generalSetting             = $this->common_model->find_data('general_settings', 'row');
            $subject                    = $generalSetting->site_name.' :: Enquiry ('.(($getEnquiry)?$getEnquiry->enquiry_no:"").') Assigned To You By EcoEx';
            $message                    = view('email-templates/enquiry-request-assigned',$fields);
            $this->sendMail($getVendor->email, $subject, $message);
        /* send mail */

        $alreadyAllocatedCount     = $this->data['model']->find_data('ecomm_sub_enquires', 'count', ['enq_id' => $enq_id]);
        if($getEnquiryProductCount == $alreadyAllocatedCount){
            $this->common_model->save_data('ecomm_enquires', ['status' => 3], $enq_id, 'id');
        }

        $this->session->setFlashdata('success_message', 'Vendor '.(($getVendor)?$getVendor->company_name:"").' Successfully Assigned With '.(($getProduct)?$getProduct->item_name_ecoex:"").' Against '.$enquiry_no.' !!!');
        return redirect()->to(base_url('admin/enquiry-requests/view-detail/'.encoded($enq_id)));
    }

    /* process enquiry requests */
        public function processRequestList($enq_sub_status)
        {
            if(!$this->common_model->checkModuleFunctionAccess(23,109)){
                $data['action']             = 'Access Forbidden';
                $title                      = $data['action'].' '.$this->data['title'];
                $page_name                  = 'access-forbidden';        
                echo $this->layout_after_login($title,$page_name,$data);
                exit;
            }
            $userType                   = $this->session->user_type;
            $company_id                 = $this->session->company_id;
            $data['moduleDetail']       = $this->data;
            $enq_sub_status             = decoded($enq_sub_status);
            $data['enq_sub_status']     = $enq_sub_status;

            if($enq_sub_status == 3.3){
                $stepName = 'Vendor Assigned';
            } elseif($enq_sub_status == 4.4){
                $stepName = 'Pickup Scheduled';
            } elseif($enq_sub_status == 5.5){
                $stepName = 'Vehicle Placed';
            } elseif($enq_sub_status == 6.6){
                $stepName = 'Material Weighed';
            } elseif($enq_sub_status == 8.8){
                $stepName = 'Invoice to Vendor';
            } elseif($enq_sub_status == 9.9){
                $stepName = 'Payment received from Vendor';
            } elseif($enq_sub_status == 10.10){
                $stepName = 'Vehicle Dispatched';
            } elseif($enq_sub_status == 12.12){
                $stepName = 'Order Complete';
            }

            $title                      = 'Manage '.$this->data['title'] . ' : '.$stepName;
            $page_name                  = 'enquiry-request/process-request-list';

            $order_by[0]                    = array('field' => 'id', 'type' => 'desc');
            $groupBy[0]                     = 'enq_id,vendor_id';
            if($userType == 'MA'){
                $conditions                 = ['status' => (float)$enq_sub_status];
            } elseif($userType == 'U'){
                $conditions                 = ['status' => (float)$enq_sub_status];
            } else {
                $conditions                 = ['status' => (float)$enq_sub_status, 'company_id' => $company_id];
            }
            $data['rows']               = $this->data['model']->find_data('ecomm_sub_enquires', 'array', $conditions, '', '', $groupBy, $order_by);
            echo $this->layout_after_login($title,$page_name,$data);
        }
        public function viewProcessRequestDetail($sub_enquiry_no)
        {
            if(!$this->common_model->checkModuleFunctionAccess(23,109)){
                $data['action']             = 'Access Forbidden';
                $title                      = $data['action'].' '.$this->data['title'];
                $page_name                  = 'access-forbidden';        
                echo $this->layout_after_login($title,$page_name,$data);
                exit;
            }
            $userType                   = $this->session->user_type;
            $company_id                 = $this->session->company_id;
            $data['moduleDetail']       = $this->data;
            $sub_enquiry_no             = decoded($sub_enquiry_no);
            $data['sub_enquiry_no']     = $sub_enquiry_no;
            $conditions                 = ['sub_enquiry_no' => $sub_enquiry_no];
            $data['items']              = $this->data['model']->find_data('ecomm_sub_enquires', 'array', $conditions);
            $data['row']                = $this->data['model']->find_data('ecomm_sub_enquires', 'row', $conditions);
            $enq_sub_status             = (($data['row'])?$data['row']->status:0);

            if($enq_sub_status == 3.3){
                $stepName = 'Vendor Assigned';
            } elseif($enq_sub_status == 4.4){
                $stepName = 'Pickup Scheduled';
            } elseif($enq_sub_status == 5.5){
                $stepName = 'Vehicle Placed';
            } elseif($enq_sub_status == 6.6){
                $stepName = 'Material Weighed';
            } elseif($enq_sub_status == 8.8){
                $stepName = 'Invoice to Vendor';
            } elseif($enq_sub_status == 9.9){
                $stepName = 'Payment received from Vendor';
            } elseif($enq_sub_status == 10.10){
                $stepName = 'Vehicle Dispatched';
            } elseif($enq_sub_status == 12.12){
                $stepName = 'Order Complete';
            }

            $enq_id                     = (($data['row'])?$data['row']->enq_id:0);
            $data['enq_id']             = $enq_id;
            $data['getEnquiry']         = $this->data['model']->find_data($this->data['table_name'], 'row', ['id' => $enq_id]);

            $orderBy[0]                 = ['field' => 'id', 'type' => 'DESC'];
            $data['getPickupDates']     = $this->data['model']->find_data('ecomm_enquiry_vendor_pickup_schedule_logs', 'array', ['sub_enquiry_no' => $sub_enquiry_no], 'pickup_date_time,created_at', '', '', $orderBy);

            $title                      = 'Manage '.$this->data['title'] . ' : '.$stepName;
            $page_name                  = 'enquiry-request/process-request-details';
            echo $this->layout_after_login($title,$page_name,$data);
        }
        public function change_status_pickup_edit_access($sub_enquiry_no, $redirectLink)
        {
            $sub_enquiry_no             = decoded($sub_enquiry_no);
            $redirectLink               = decoded($redirectLink);
            $getSubEnquiry              = $this->data['model']->find_data('ecomm_sub_enquires', 'row', ['sub_enquiry_no' => $sub_enquiry_no]);
            $vendor_id                  = (($getSubEnquiry)?$getSubEnquiry->vendor_id:0);
            if($getSubEnquiry){
                if($getSubEnquiry->pickup_schedule_edit_access){
                    $pickup_schedule_edit_access    = 0;
                    $msg                            = 'Access Closed';
                } else {
                    $pickup_schedule_edit_access    = 1;
                    $msg                            = 'Access Opened';
                }
                $postData = array(
                                    'pickup_schedule_edit_access' => $pickup_schedule_edit_access
                                );
                $updateData = $this->common_model->save_data('ecomm_sub_enquires', $postData, $sub_enquiry_no, 'sub_enquiry_no');

                /* send push */
                    $getDeviceTokens            = $this->common_model->find_data('ecomm_user_devices', 'array', ['user_id' => $vendor_id, 'fcm_token!=' => ''], 'fcm_token');
                    if($getDeviceTokens){
                        foreach($getDeviceTokens as $getDeviceToken){
                            $fcm_token          = $getDeviceToken->fcm_token;
                            $messageData = [
                                'title'     => 'Pickup Schedule Date/Time Edit '.$msg,
                                'body'      => 'Sub Enquiry Request ('.$sub_enquiry_no.') Pickup Schedule Date/Time Edit '.$msg.' By EcoEx',
                                'badge'     => 1,
                                'sound'     => 'Default',
                                'data'      => [],
                            ];
                            $this->pushNotification($fcm_token, $messageData);
                            $users[]    = $getSubEnquiry->plant_id;
                            $pushData   = [
                                'source'            => 'FROM APP',
                                'title'             => 'Pickup Schedule Date/Time Edit '.$msg,
                                'description'       => 'Sub Enquiry Request ('.$sub_enquiry_no.') Pickup Schedule Date/Time Edit '.$msg.' By EcoEx',
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
                /* send mail */
                    $fields = [
                        'enq_id'                => $getSubEnquiry->enq_id,
                        'company_id'            => $getSubEnquiry->company_id,
                        'plant_id'              => $getSubEnquiry->plant_id,
                        'vendor_id'             => $vendor_id,
                        'sub_enquiry_no'        => $sub_enquiry_no,
                        'msg'                   => $msg,
                    ];
                    $getVendor                  = $this->common_model->find_data('ecomm_users', 'row', ['id' => $vendor_id]);
                    $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                    $subject                    = $generalSetting->site_name.' :: Sub Enquiry Pickup Schedule Date/Time Edit Access ('.$sub_enquiry_no.') ';
                    $message                    = view('email-templates/enquiry-request-for-pickup-scheduled-edit-access',$fields);
                    $this->sendMail((($getVendor)?$getVendor->email:''), $subject, $message);
                /* send mail */

                $this->session->setFlashdata('success_message', 'Pickup Schedule Date/Time Edit '.$msg.' Successfully !!!');
                return redirect()->to($redirectLink);
            } else {
                $this->session->setFlashdata('success_message', 'Sub Enquiry Not Found !!!');
                return redirect()->to($redirectLink);
            }
        }
        public function final_pickup_scheduled($sub_enquiry_no, $redirectLink)
        {
            $sub_enquiry_no             = decoded($sub_enquiry_no);
            $redirectLink               = decoded($redirectLink);
            $getSubEnquiry              = $this->data['model']->find_data('ecomm_sub_enquires', 'row', ['sub_enquiry_no' => $sub_enquiry_no]);
            $vendor_id                  = (($getSubEnquiry)?$getSubEnquiry->vendor_id:0);
            if($getSubEnquiry){
                $postData = array(
                                    'pickup_schedule_edit_access'   => 0,
                                    'is_pickup_final'               => 1,
                                    'status'                        => 4.4,
                                );
                $updateData = $this->common_model->save_data('ecomm_sub_enquires', $postData, $sub_enquiry_no, 'sub_enquiry_no');

                /* send push */
                    $getDeviceTokens            = $this->common_model->find_data('ecomm_user_devices', 'array', ['user_id' => $vendor_id, 'fcm_token!=' => ''], 'fcm_token');
                    if($getDeviceTokens){
                        foreach($getDeviceTokens as $getDeviceToken){
                            $fcm_token          = $getDeviceToken->fcm_token;
                            $messageData = [
                                'title'     => 'Pickup Schedule Date/Time Finalised',
                                'body'      => 'Sub Enquiry Request ('.$sub_enquiry_no.') Pickup Schedule Date/Time Edit Finalised By EcoEx',
                                'badge'     => 1,
                                'sound'     => 'Default',
                                'data'      => [],
                            ];
                            $this->pushNotification($fcm_token, $messageData);
                            $users[]    = $getSubEnquiry->plant_id;
                            $pushData   = [
                                'source'            => 'FROM APP',
                                'title'             => 'Pickup Schedule Date/Time Finalised',
                                'description'       => 'Sub Enquiry Request ('.$sub_enquiry_no.') Pickup Schedule Date/Time Edit Finalised By EcoEx',
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
                /* send mail */
                    $fields = [
                        'enq_id'                => $getSubEnquiry->enq_id,
                        'company_id'            => $getSubEnquiry->company_id,
                        'plant_id'              => $getSubEnquiry->plant_id,
                        'vendor_id'             => $vendor_id,
                        'sub_enquiry_no'        => $sub_enquiry_no,
                    ];
                    $getVendor                  = $this->common_model->find_data('ecomm_users', 'row', ['id' => $vendor_id]);
                    $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                    $subject                    = $generalSetting->site_name.' :: Sub Enquiry Pickup Schedule Date/Time Edit Access ('.$sub_enquiry_no.') ';
                    $message                    = view('email-templates/enquiry-request-for-pickup-scheduled-final',$fields);
                    $this->sendMail((($getVendor)?$getVendor->email:''), $subject, $message);
                /* send mail */

                $this->session->setFlashdata('success_message', 'Pickup Schedule Date/Time Finalised Successfully !!!');
                return redirect()->to($redirectLink);
            } else {
                $this->session->setFlashdata('success_message', 'Sub Enquiry Not Found !!!');
                return redirect()->to($redirectLink);
            }
        }
    /* process enquiry requests */
}