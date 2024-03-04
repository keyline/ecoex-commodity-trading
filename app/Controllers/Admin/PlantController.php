<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class PlantController extends BaseController {

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
            'title'                 => 'Plant',
            'controller_route'      => 'plants',
            'controller'            => 'PlantController',
            'table_name'            => 'ecomm_users',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        if(!$this->common_model->checkModuleFunctionAccess(15,75)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $userType                   = $this->session->user_type;
        $company_id                 = $this->session->company_id;
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'plant/list';

        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        if($userType == 'MA'){
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT'];
        } elseif($userType == 'U'){
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT'];
        } else {
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT', 'parent_id' => $company_id];
        }
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', $conditions, '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        if(!$this->common_model->checkModuleFunctionAccess(15,115)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'plant/add-edit';        
        $data['row']                = [];
        $orderBy[0]                 = ['field' => 'company_name', 'type' => 'ASC'];
        $data['companyList']        = $this->data['model']->find_data('ecoex_companies', 'array', ['status!=' => 3, 'parent_id' => 0], '', '', '', $orderBy);
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
                        $profile_image = '';
                    }
                } else {
                    $profile_image = '';
                }
            /* profile image */
            /* GST CERTIFICATE */
                $file = $this->request->getFile('gst_certificate');
                $originalName = $file->getClientName();
                $fieldName = 'gst_certificate';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','pdf');
                    if($upload_array['status']) {
                        $gst_certificate = $upload_array['newFilename'];
                    } else {
                        $gst_certificate = '';
                    }
                } else {
                    $gst_certificate = '';
                }
            /* GST CERTIFICATE */
            /* PAN CARD */
                $file = $this->request->getFile('contact_person_document');
                $originalName = $file->getClientName();
                $fieldName = 'contact_person_document';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','pdf');
                    if($upload_array['status']) {
                        $contact_person_document = $upload_array['newFilename'];
                    } else {
                        $contact_person_document = '';
                    }
                } else {
                    $contact_person_document = '';
                }
            /* PAN CARD */
            /* cancelled cheque */
                $file = $this->request->getFile('cancelled_cheque');
                $originalName = $file->getClientName();
                $fieldName = 'cancelled_cheque';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','pdf');
                    if($upload_array['status']) {
                        $cancelled_cheque = $upload_array['newFilename'];
                    } else {
                        $cancelled_cheque = '';
                    }
                } else {
                    $cancelled_cheque = '';
                }
            /* cancelled cheque */
            $postData   = array(
                'type'                  => 'PLANT',
                'parent_id'             => $this->request->getPost('parent_id'),
                'gst_no'                => $this->request->getPost('gst_no'),
                'gst_certificate'       => $gst_certificate,
                'company_name'          => $this->request->getPost('company_name'),
                'plant_name'            => $this->request->getPost('plant_name'),
                'full_address'          => $this->request->getPost('full_address'),
                'holding_no'            => $this->request->getPost('holding_no'),
                'street'                => $this->request->getPost('street'),
                'district'              => $this->request->getPost('district'),
                'state'                 => $this->request->getPost('state'),
                'pincode'               => $this->request->getPost('pincode'),
                'location'              => $this->request->getPost('location'),
                'email'                 => $this->request->getPost('email'),
                'email_verify'          => 1,
                'email_verified_at'     => date('Y-m-d H:i:s'),
                'phone'                 => $this->request->getPost('phone'),
                'phone_verify'          => 1,
                'phone_verified_at'     => date('Y-m-d H:i:s'),
                'password'              => md5($this->request->getPost('password')),
                'profile_image'         => $profile_image,
                'contact_person_name'                       => $this->request->getPost('contact_person_name'),
                'contact_person_designation'                => $this->request->getPost('contact_person_designation'),
                'contact_person_document'                   => $contact_person_document,
                'bank_name'             => $this->request->getPost('bank_name'),
                'branch_name'           => $this->request->getPost('branch_name'),
                'ifsc_code'             => $this->request->getPost('ifsc_code'),
                'account_type'          => $this->request->getPost('account_type'),
                'account_number'        => $this->request->getPost('account_number'),
                'cancelled_cheque'      => $cancelled_cheque,
                'created_by'            => $this->session->user_id,
                'updated_by'            => $this->session->user_id,
                'status'                => 2,
            );
            // pr($postData);
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);            
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function edit($id)
    {
        if(!$this->common_model->checkModuleFunctionAccess(15,79)){
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
        $page_name                  = 'plant/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $orderBy[0]                 = ['field' => 'company_name', 'type' => 'ASC'];
        $data['companyList']        = $this->data['model']->find_data('ecoex_companies', 'array', ['status!=' => 3, 'parent_id' => 0], '', '', '', $orderBy);

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
            /* GST CERTIFICATE */
                $file = $this->request->getFile('gst_certificate');
                $originalName = $file->getClientName();
                $fieldName = 'gst_certificate';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','pdf');
                    if($upload_array['status']) {
                        $gst_certificate = $upload_array['newFilename'];
                    } else {
                        $gst_certificate = '';
                    }
                } else {
                    $gst_certificate = $data['row']->gst_certificate;
                }
            /* GST CERTIFICATE */
            /* PAN CARD */
                $file = $this->request->getFile('contact_person_document');
                $originalName = $file->getClientName();
                $fieldName = 'contact_person_document';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','pdf');
                    if($upload_array['status']) {
                        $contact_person_document = $upload_array['newFilename'];
                    } else {
                        $contact_person_document = '';
                    }
                } else {
                    $contact_person_document = $data['row']->contact_person_document;
                }
            /* PAN CARD */
            /* cancelled cheque */
                $file = $this->request->getFile('cancelled_cheque');
                $originalName = $file->getClientName();
                $fieldName = 'cancelled_cheque';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','pdf');
                    if($upload_array['status']) {
                        $cancelled_cheque = $upload_array['newFilename'];
                    } else {
                        $cancelled_cheque = '';
                    }
                } else {
                    $cancelled_cheque = $data['row']->cancelled_cheque;
                }
            /* cancelled cheque */
            if($this->request->getPost('password') != ''){
                $postData   = array(
                    'parent_id'             => $this->request->getPost('parent_id'),
                    'gst_no'                => $this->request->getPost('gst_no'),
                    'gst_certificate'       => $gst_certificate,
                    'company_name'          => $this->request->getPost('company_name'),
                    'plant_name'            => $this->request->getPost('plant_name'),
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
                    'contact_person_name'                       => $this->request->getPost('contact_person_name'),
                    'contact_person_designation'                => $this->request->getPost('contact_person_designation'),
                    'contact_person_document'                   => $contact_person_document,
                    'bank_name'             => $this->request->getPost('bank_name'),
                    'branch_name'           => $this->request->getPost('branch_name'),
                    'ifsc_code'             => $this->request->getPost('ifsc_code'),
                    'account_type'          => $this->request->getPost('account_type'),
                    'account_number'        => $this->request->getPost('account_number'),
                    'cancelled_cheque'      => $cancelled_cheque,
                    'created_by'            => $this->session->user_id,
                    'updated_by'            => $this->session->user_id,
                );
            } else {
                $postData   = array(
                    'parent_id'             => $this->request->getPost('parent_id'),
                    'gst_no'                => $this->request->getPost('gst_no'),
                    'gst_certificate'       => $gst_certificate,
                    'company_name'          => $this->request->getPost('company_name'),
                    'plant_name'            => $this->request->getPost('plant_name'),
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
                    'contact_person_name'                       => $this->request->getPost('contact_person_name'),
                    'contact_person_designation'                => $this->request->getPost('contact_person_designation'),
                    'contact_person_document'                   => $contact_person_document,
                    'bank_name'             => $this->request->getPost('bank_name'),
                    'branch_name'           => $this->request->getPost('branch_name'),
                    'ifsc_code'             => $this->request->getPost('ifsc_code'),
                    'account_type'          => $this->request->getPost('account_type'),
                    'account_number'        => $this->request->getPost('account_number'),
                    'cancelled_cheque'      => $cancelled_cheque,
                    'created_by'            => $this->session->user_id,
                    'updated_by'            => $this->session->user_id,
                );
            }
            pr($postData);
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
        if(!$this->common_model->checkModuleFunctionAccess(15,80)){
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';        
            echo $this->layout_after_login($title,$page_name,$data);
            exit;
        }
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'View';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'plant/details';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function check_email(){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));        
        $requiredFields     = ['plant_email'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)){              
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
            $checkData = $this->common_model->find_data('ecomm_users', 'count', ['email' => $requestData['plant_email'], 'status!=' => 3]);
            if($checkData > 0){
                http_response_code(200);
                $apiStatus          = FALSE;
                $apiMessage         = 'Email Already Exists. Try Other Email !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Email Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
        } else {
            http_response_code(400);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
    public function check_phone(){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));        
        $requiredFields     = ['plant_phone'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)){              
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
            $checkData = $this->common_model->find_data('ecomm_users', 'count', ['phone' => $requestData['plant_phone'], 'status!=' => 3]);
            if($checkData > 0){
                http_response_code(404);
                $apiStatus          = TRUE;
                $apiMessage         = 'Phone Already Exists. Try Other Phone !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Phone Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
        } else {
            http_response_code(400);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
}