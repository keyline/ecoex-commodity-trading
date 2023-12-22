<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class CompanyController extends BaseController {

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
            'title'                 => 'Company',
            'controller_route'      => 'companies',
            'controller'            => 'CompanyController',
            'table_name'            => 'ecoex_companies',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'company/list';
        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['status!=' => 3, 'parent_id' => 0], '', '', '', $order_by);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'company/add-edit';        
        $data['row']                = [];
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
            /* CIN CERTIFICATE */
                $file = $this->request->getFile('cin_document');
                $originalName = $file->getClientName();
                $fieldName = 'cin_document';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','pdf');
                    if($upload_array['status']) {
                        $cin_document = $upload_array['newFilename'];
                    } else {
                        $cin_document = '';
                    }
                } else {
                    $cin_document = '';
                }
            /* CIN CERTIFICATE */
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
                'type'                  => 'COMPANY',
                'parent_id'             => 0,
                'gst_no'                => $this->request->getPost('gst_no'),
                'gst_certificate'       => $gst_certificate,
                'company_name'          => $this->request->getPost('company_name'),
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
                'contract_start'        => date_format(date_create($this->request->getPost('contract_start')), "Y-m-d"),
                'contract_end'          => date_format(date_create($this->request->getPost('contract_end')), "Y-m-d"),
                'cin_no'                => $this->request->getPost('cin_no'),
                'cin_document'          => $cin_document,
                'bank_name'             => $this->request->getPost('bank_name'),
                'branch_name'           => $this->request->getPost('branch_name'),
                'ifsc_code'             => $this->request->getPost('ifsc_code'),
                'account_type'          => $this->request->getPost('account_type'),
                'account_number'        => $this->request->getPost('account_number'),
                'cancelled_cheque'      => $cancelled_cheque,
                'status'                => 2,
            );
            // pr($postData);
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);

            // insert as a sub user of masteradmin of type COMPANY ADMIN
                $postData2   = array(
                    'user_type'                 => 'COMPANY',
                    'role_id'                   => 14,
                    'name'                      => $this->request->getPost('company_name'),
                    'mobileNo'                  => $this->request->getPost('phone'),
                    'username'                  => $this->request->getPost('email'),
                    'password'                  => md5($this->request->getPost('password')),
                    'original_password'         => $this->request->getPost('password'),
                    'email'                     => $this->request->getPost('email'),
                    'present_address'           => $this->request->getPost('full_address'),
                    'permanent_address'         => $this->request->getPost('full_address'),
                    'added_user'                => 1,
                    'updated_user'              => 1,
                );
                // pr($postData);
                $this->data['model']->save_data('ecoex_admin_user', $postData2, '', 'id');
            // insert as a sub user of masteradmin of type COMPANY ADMIN

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
        $page_name                  = 'company/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);

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
            /* CIN CERTIFICATE */
                $file = $this->request->getFile('cin_document');
                $originalName = $file->getClientName();
                $fieldName = 'cin_document';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'user','pdf');
                    if($upload_array['status']) {
                        $cin_document = $upload_array['newFilename'];
                    } else {
                        $cin_document = '';
                    }
                } else {
                    $cin_document = $data['row']->cin_document;
                }
            /* CIN CERTIFICATE */
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
                    'gst_no'                => $this->request->getPost('gst_no'),
                    'gst_certificate'       => $gst_certificate,
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
                    'contract_start'        => date_format(date_create($this->request->getPost('contract_start')), "Y-m-d"),
                    'contract_end'          => date_format(date_create($this->request->getPost('contract_end')), "Y-m-d"),
                    'cin_no'                => $this->request->getPost('cin_no'),
                    'cin_document'          => $cin_document,
                    'bank_name'             => $this->request->getPost('bank_name'),
                    'branch_name'           => $this->request->getPost('branch_name'),
                    'ifsc_code'             => $this->request->getPost('ifsc_code'),
                    'account_type'          => $this->request->getPost('account_type'),
                    'account_number'        => $this->request->getPost('account_number'),
                    'cancelled_cheque'      => $cancelled_cheque,
                );

                // insert as a sub user of masteradmin of type COMPANY ADMIN
                    $postData2   = array(
                        'user_type'                 => 'COMPANY',
                        'role_id'                   => 14,
                        'name'                      => $this->request->getPost('company_name'),
                        'mobileNo'                  => $this->request->getPost('phone'),
                        'username'                  => $this->request->getPost('email'),
                        'password'                  => md5($this->request->getPost('password')),
                        'original_password'         => $this->request->getPost('password'),
                        'email'                     => $this->request->getPost('email'),
                        'present_address'           => $this->request->getPost('full_address'),
                        'permanent_address'         => $this->request->getPost('full_address'),
                        'added_user'                => 1,
                        'updated_user'              => 1,
                    );
                // insert as a sub user of masteradmin of type COMPANY ADMIN
            } else {
                $postData   = array(
                    'gst_no'                => $this->request->getPost('gst_no'),
                    'gst_certificate'       => $gst_certificate,
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
                    'contract_start'        => date_format(date_create($this->request->getPost('contract_start')), "Y-m-d"),
                    'contract_end'          => date_format(date_create($this->request->getPost('contract_end')), "Y-m-d"),
                    'cin_no'                => $this->request->getPost('cin_no'),
                    'cin_document'          => $cin_document,
                    'bank_name'             => $this->request->getPost('bank_name'),
                    'branch_name'           => $this->request->getPost('branch_name'),
                    'ifsc_code'             => $this->request->getPost('ifsc_code'),
                    'account_type'          => $this->request->getPost('account_type'),
                    'account_number'        => $this->request->getPost('account_number'),
                    'cancelled_cheque'      => $cancelled_cheque,
                );

                // insert as a sub user of masteradmin of type COMPANY ADMIN
                    $postData2   = array(
                        'user_type'                 => 'COMPANY',
                        'role_id'                   => 14,
                        'name'                      => $this->request->getPost('company_name'),
                        'mobileNo'                  => $this->request->getPost('phone'),
                        'username'                  => $this->request->getPost('email'),
                        'email'                     => $this->request->getPost('email'),
                        'present_address'           => $this->request->getPost('full_address'),
                        'permanent_address'         => $this->request->getPost('full_address'),
                        'added_user'                => 1,
                        'updated_user'              => 1,
                    );
                // insert as a sub user of masteradmin of type COMPANY ADMIN
            }
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);

            $checkCompanySubuser = $this->common_model->find_data('ecoex_admin_user', 'row', ['email' => $this->request->getPost('email')]);
            if($checkCompanySubuser){
                $this->data['model']->save_data('ecoex_admin_user', $postData2, $checkCompanySubuser->id, 'id');
            } else {
                $this->data['model']->save_data('ecoex_admin_user', $postData2, '', 'id');
            }

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
        $page_name                  = 'company/details';        
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
        $requiredFields     = ['company_email'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)){              
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
            $checkData = $this->common_model->find_data('ecoex_companies', 'count', ['email' => $requestData['company_email'], 'status!=' => 3]);
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
        $requiredFields     = ['company_phone'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)){              
            http_response_code(406);
            $apiStatus          = FALSE;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
            $checkData = $this->common_model->find_data('ecoex_companies', 'count', ['phone' => $requestData['company_phone'], 'status!=' => 3]);
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

    public function assignCategory($id)
    {
        $id                         = decoded($id);
        $company                    = $this->common_model->find_data('ecoex_companies', 'row', ['id' => $id], 'company_name');
        $company_name               = (($company)?$company->company_name:'');
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Manage Product Category Of';
        $title                      = $data['action'].' '.$company_name;
        $page_name                  = 'company/assign-category';
        $data['cats']               = $this->common_model->find_data('ecomm_product_categories', 'array', ['status' => 1], 'id,name');
        $data['company_id']         = $id;
        $data['company_name']       = $company_name;

        $order_by[0]                = array('field' => 'id', 'type' => 'desc');
        $conditions                 = array('company_id' => $id, 'status' => 1);
        $data['assignCats']         = $this->data['model']->find_data('ecomm_company_category', 'array', $conditions, '', '', '', $order_by);
        
        if($this->request->getMethod() == 'post') {
            $company_id         = $this->request->getPost('company_id');
            $category_id        = $this->request->getPost('category_id');

            if(!empty($category_id)){
                $this->data['model']->save_data('ecomm_company_category', ['status' => 3], $company_id, 'company_id');
                for($k=0;$k<count($category_id);$k++){
                    $checkCompanyCategory = $this->common_model->find_data('ecomm_company_category', 'row', ['company_id' => $company_id, 'category_id' => $category_id[$k]]);
                    if($checkCompanyCategory){
                        // update
                        $postData   = array(
                            'status'                    => 1,
                        );
                        $this->data['model']->save_data('ecomm_company_category', $postData, $checkCompanyCategory->id, 'id');
                    } else {
                        // insert
                        $category_alias     = $this->request->getPost('category_alias'.$category_id[$k]);
                        $postData   = array(
                            'company_id'                => $company_id,
                            'category_id'               => $category_id[$k],
                            'category_alias'            => $category_alias,
                            'status'                    => 1,
                        );
                        $this->data['model']->save_data('ecomm_company_category', $postData, '', 'id');
                    }
                }
            }
            $this->session->setFlashdata('success_message', $this->data['title'].' Product Category Updated Successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }        
        echo $this->layout_after_login($title,$page_name,$data);
    }

    public function manageItem($id)
    {
        $id                         = decoded($id);
        $company                    = $this->common_model->find_data('ecoex_companies', 'row', ['id' => $id], 'company_name');
        $company_name               = (($company)?$company->company_name:'');
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Manage Items Of';
        $title                      = $data['action'].' '.$company_name;
        $page_name                  = 'company/manage-item';
        $data['company_id']         = $id;
        $data['company_name']       = $company_name;

        $orderBy[0]                 = ['field' => 'category_alias', 'type' => 'ASC'];
        $data['cats']               = $this->common_model->find_data('ecomm_company_category', 'array', ['status' => 1, 'company_id' => $id], 'category_id,category_alias', '', '', $orderBy);

        $orderBy[0]                 = ['field' => 'name', 'type' => 'ASC'];
        $data['units']              = $this->common_model->find_data('ecomm_units', 'array', ['status' => 1], 'id,name', '', '', $orderBy);

        $order_by[0]                = array('field' => 'id', 'type' => 'asc');
        $conditions                 = array('company_id' => $id, 'status!=' => 3);
        $data['assignItems']        = $this->data['model']->find_data('ecomm_company_items', 'array', $conditions, '', '', '', $order_by);
        
        if($this->request->getMethod() == 'post') {
            pr($this->request->getPost());
            $company_id             = $this->request->getPost('company_id');
            $item_category          = $this->request->getPost('item_category');
            $item_name_ecoex        = $this->request->getPost('item_name_ecoex');
            $alias_name             = $this->request->getPost('alias_name');
            $billing_name           = $this->request->getPost('billing_name');
            $hsn                    = $this->request->getPost('hsn');
            $gst                    = $this->request->getPost('gst');
            $rate                   = $this->request->getPost('rate');
            $unit                   = $this->request->getPost('unit');

            if(!empty($item_name_ecoex)){
                $this->data['model']->save_data('ecomm_company_items', ['status' => 3], $company_id, 'company_id');
                for($k=0;$k<count($item_name_ecoex);$k++){
                    $checkCompanyItem = $this->common_model->find_data('ecomm_company_items', 'row', ['company_id' => $company_id, 'item_name_ecoex' => $item_name_ecoex[$k]]);
                    if($checkCompanyItem){
                        // update
                        $postData   = array(
                            'status'                    => 1,
                        );
                        $this->data['model']->save_data('ecomm_company_items', $postData, $checkCompanyItem->id, 'id');
                    } else {
                        // insert
                        $postData   = array(
                            'company_id'                => $company_id,
                            'item_category'             => $item_category[$k],
                            'item_name_ecoex'           => $item_name_ecoex[$k],
                            'alias_name'                => $alias_name[$k],
                            'billing_name'              => $billing_name[$k],
                            'hsn'                       => $hsn[$k],
                            'gst'                       => $gst[$k],
                            'rate'                      => $rate[$k],
                            'unit'                      => $unit[$k],
                            'is_approved'               => 1,
                            'approved_date'             => date('Y-m-d H:i:s'),
                            'status'                    => 1,
                        );
                        // pr($postData);
                        $this->data['model']->save_data('ecomm_company_items', $postData, '', 'id');
                    }
                }
            }
            $this->session->setFlashdata('success_message', $this->data['title'].' Item Updated Successfully');
            return redirect()->to(current_url());
        }        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function approveItem()
    {
        $id             = decoded($this->request->getPost('id'));
        $redirectLink   = decoded($this->request->getPost('redirect_link'));
        $postData   = array(
            'item_category'             => $this->request->getPost('item_category')[0],
            'item_name_ecoex'           => $this->request->getPost('item_name_ecoex')[0],
            'alias_name'                => $this->request->getPost('alias_name')[0],
            'billing_name'              => $this->request->getPost('billing_name')[0],
            'hsn'                       => $this->request->getPost('hsn')[0],
            'gst'                       => $this->request->getPost('gst')[0],
            'rate'                      => $this->request->getPost('rate')[0],
            'unit'                      => $this->request->getPost('unit')[0]
        );
        $this->data['model']->save_data('ecomm_company_items', $postData, $id, 'id');

        $getItem        = $this->common_model->find_data('ecomm_company_items', 'row', ['id' => $id]);
        if($getItem){
            if(($getItem->item_category > 0) && ($getItem->alias_name != '') && ($getItem->billing_name != '') && ($getItem->hsn != '') && ($getItem->gst > 0) &&  ($getItem->rate > 0) && ($getItem->unit > 0)){
                /* company items */
                    $postData   = array(
                        'is_approved'               => 1,
                        'approved_date'             => date('Y-m-d H:i:s'),
                        'status'                    => 1,
                    );
                    $this->data['model']->save_data('ecomm_company_items', $postData, $id, 'id');
                /* company items */
                /* company Enquiry items */
                    $enq_id         = $getItem->enq_id;
                    $enq_product_id = $getItem->enq_product_id;
                    $product_id     = $id;
                    $postData   = array(
                        'product_id'                => $product_id,
                        'hsn'                       => $getItem->hsn,
                        'new_product_name'          => $getItem->alias_name,
                        'new_hsn'                   => $getItem->hsn,
                        'unit'                      => $getItem->unit,
                        'remarks'                   => 'Approved By Admin',
                        'status'                    => 1,
                        'approved_date'             => date('Y-m-d H:i:s')
                    );
                    $this->data['model']->save_data('ecomm_enquiry_products', $postData, $enq_product_id, 'id');
                /* company enquiry items */
                $this->session->setFlashdata('success_message', $this->data['title'].' Item Approved Successfully !!!');
                return redirect()->to($redirectLink);
            } else {
                $this->session->setFlashdata('error_message', $this->data['title'].' Item Category, Alias Name, Billing Name, HSN, GST, Rate, Unit Must Be Entered Before Get Approved !!!');
                return redirect()->to($redirectLink);
            }
        } else {
            $this->session->setFlashdata('error_message', $this->data['title'].' Item Not Found !!!');
            return redirect()->to($redirectLink);
        }
    }
}