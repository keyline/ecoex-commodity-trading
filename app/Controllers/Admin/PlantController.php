<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;

class PlantController extends BaseController
{
    private $model;  //This can be accessed by all class methods
    public function __construct()
    {
        $session = \Config\Services::session();
        if (!$session->get('is_admin_login')) {
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
        if (!$this->common_model->checkModuleFunctionAccess(15, 75)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $userType                   = $this->session->user_type;
        $company_id                 = $this->session->company_id;
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'plant/list';

        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        if ($userType == 'MA') {
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT', 'gst_no!=' => ''];

            $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', $conditions, '', '', '', $order_by);

        } elseif ($userType == 'U') {
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT', 'gst_no!=' => ''];


            $allowedPlantIds = getAllowedPlantIds(session('user_id'));

            $data['allowedPlantIds']   = $allowedPlantIds;


            if (!empty($allowedPlantIds)) {

                $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', $conditions, '', '', '', $order_by);

                $data['rows'] = array_filter($data['rows'], function ($row) use ($allowedPlantIds) {
                    return in_array($row->id, $allowedPlantIds);
                });

                // Re-index array numerically (optional, for clean JSON)
                $data['rows'] = array_values($data['rows']);
            } else {
                $data['rows'] = [];
            }

        } else {
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT', 'parent_id' => $company_id, 'gst_no!=' => ''];

            $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', $conditions, '', '', '', $order_by);

        }







        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function temporaryList()
    {
        if (!$this->common_model->checkModuleFunctionAccess(15, 75)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $userType                   = $this->session->user_type;
        $company_id                 = $this->session->company_id;
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage Temporary '.$this->data['title'];
        $page_name                  = 'plant/temporary-list';

        $order_by[0]                = array('field' => $this->data['primary_key'], 'type' => 'desc');
        if ($userType == 'MA') {
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT', 'gst_no' => null];
        } elseif ($userType == 'U') {
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT', 'gst_no' => null];
        } else {
            $conditions                 = ['status!=' => 3, 'type' => 'PLANT', 'parent_id' => $company_id, 'gst_no' => ''];
        }
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', $conditions, '', '', '', $order_by);
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function add()
    {
        if (!$this->common_model->checkModuleFunctionAccess(15, 115)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'plant/add-edit';
        $data['row']                = [];
        $orderBy[0]                 = ['field' => 'company_name', 'type' => 'ASC'];
        $data['companyList']        = $this->data['model']->find_data('ecoex_companies', 'array', ['status!=' => 3, 'parent_id' => 0], '', '', '', $orderBy);
        if ($this->request->getMethod() == 'post') {
            /* profile image */
            $file = $this->request->getFile('profile_image');
            $originalName = $file->getClientName();
            $fieldName = 'profile_image';
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'image');
                if ($upload_array['status']) {
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
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'pdf');
                if ($upload_array['status']) {
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
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'pdf');
                if ($upload_array['status']) {
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
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'pdf');
                if ($upload_array['status']) {
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
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function edit($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(15, 79)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'plant/add-edit';
        $conditions                 = array($this->data['primary_key'] => $id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $orderBy[0]                 = ['field' => 'company_name', 'type' => 'ASC'];
        $data['companyList']        = $this->data['model']->find_data('ecoex_companies', 'array', ['status!=' => 3, 'parent_id' => 0], '', '', '', $orderBy);

        if ($this->request->getMethod() == 'post') {
            /* profile image */
            $file = $this->request->getFile('profile_image');
            $originalName = $file->getClientName();
            $fieldName = 'profile_image';
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'image');
                if ($upload_array['status']) {
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
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'pdf');
                if ($upload_array['status']) {
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
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'pdf');
                if ($upload_array['status']) {
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
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'user', 'pdf');
                if ($upload_array['status']) {
                    $cancelled_cheque = $upload_array['newFilename'];
                } else {
                    $cancelled_cheque = '';
                }
            } else {
                $cancelled_cheque = $data['row']->cancelled_cheque;
            }
            /* cancelled cheque */
            if ($this->request->getPost('password') != '') {
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
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function confirm_delete($id)
    {
        $id                         = decoded($id);
        $conditions                 = array($this->data['primary_key'] => $id);
        $getPlant                   = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        if ($getPlant) {
            $postData = array(
                                'status' => 3
                            );
            $updateData = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);

            if ($getPlant->gst_no != '') {
                $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
            } else {
                $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
                return redirect()->to('/admin/'.$this->data['controller_route'].'/temporary-list');
            }
        } else {
            $this->session->setFlashdata('success_message', $this->data['title'].' not found');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
    }
    public function change_status($id)
    {
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key'] => $id]);
        if ($data['row']->status) {
            $status  = 0;
            $msg        = 'Deactivated';
        } else {
            $email_verify           = $data['row']->email_verify;
            $phone_verify           = $data['row']->phone_verify;
            if (($email_verify == 1) && ($phone_verify == 1)) {
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
            $message                    = view('email-templates/signup', $requestData);
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
        $updateData = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);

        if ($data['row']->gst_no != '') {
            $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        } else {
            $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/temporary-list');
        }
    }
    public function view($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(15, 80)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'View';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'plant/details';
        $conditions                 = array($this->data['primary_key'] => $id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function check_email()
    {
        $apiStatus          = true;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['plant_email'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            http_response_code(406);
            $apiStatus          = false;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if ($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')) {
            $checkData = $this->common_model->find_data('ecomm_users', 'count', ['email' => $requestData['plant_email'], 'status!=' => 3]);
            if ($checkData > 0) {
                http_response_code(200);
                $apiStatus          = false;
                $apiMessage         = 'Email Already Exists. Try Other Email !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(200);
                $apiStatus          = true;
                $apiMessage         = 'Email Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
        } else {
            http_response_code(400);
            $apiStatus          = false;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }
    public function check_phone()
    {
        $apiStatus          = true;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $this->isJSON(file_get_contents('php://input'));
        $requestData        = $this->extract_json(file_get_contents('php://input'));
        $requiredFields     = ['plant_phone'];
        $headerData         = $this->request->headers();
        if (!$this->validateArray($requiredFields, $requestData)) {
            http_response_code(406);
            $apiStatus          = false;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        if ($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')) {
            $checkData = $this->common_model->find_data('ecomm_users', 'count', ['phone' => $requestData['plant_phone'], 'status!=' => 3]);
            if ($checkData > 0) {
                http_response_code(404);
                $apiStatus          = true;
                $apiMessage         = 'Phone Already Exists. Try Other Phone !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(200);
                $apiStatus          = true;
                $apiMessage         = 'Phone Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
        } else {
            http_response_code(400);
            $apiStatus          = false;
            $apiMessage         = $this->getResponseCode(http_response_code());
            $apiExtraField      = 'response_code';
            $apiExtraData       = http_response_code();
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }

    public function addWithoutGST()
    {
        if (!$this->common_model->checkModuleFunctionAccess(15, 115)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' Temporary '.$this->data['title'];
        $page_name                  = 'plant/add-edit-without-gst';
        $data['row']                = [];
        $orderBy[0]                 = ['field' => 'company_name', 'type' => 'ASC'];
        $data['companyList']        = $this->data['model']->find_data('ecoex_companies', 'array', ['status!=' => 3, 'parent_id' => 0, 'id' => 1], '', '', '', $orderBy);

        if ($this->request->getMethod() == 'post') {


            $postData   = array(
                'type'                  => 'PLANT',
                'parent_id'             => $this->request->getPost('parent_id'),
                'company_name'          => $this->request->getPost('company_name'),
                'plant_name'            => $this->request->getPost('plant_name'),
                'full_address'          => $this->request->getPost('full_address'),
                'holding_no'            => $this->request->getPost('holding_no'),
                'street'                => $this->request->getPost('street'),
                'district'              => $this->request->getPost('district'),
                'state'                 => $this->request->getPost('state'),
                'pincode'               => $this->request->getPost('pincode'),
                'location'              => $this->request->getPost('location'),
                'phone'                 => $this->request->getPost('phone'),
                'phone_verify'          => 1,
                'phone_verified_at'     => date('Y-m-d H:i:s'),
                // 'password'              => md5($this->request->getPost('password')),
                'created_by'            => $this->session->user_id,
                'updated_by'            => $this->session->user_id,
                'status'                => 2,
            );
            // pr($postData);
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/temporary-list');
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function createTemporaryEnquiry($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(15, 115)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Create';
        $title                      = $data['action'].' Temporary '.$this->data['title'] . ' Enquiry';
        $page_name                  = 'plant/create-temporary-enquiry';

        $conditions                 = array($this->data['primary_key'] => $id);
        $data['plant']              = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $parent_id                  = (($data['plant']) ? $data['plant']->parent_id : 0);

        $orderBy2[0]                = ['field' => 'item_name_ecoex', 'type' => 'ASC'];
        $data['items']              = $this->data['model']->find_data('ecomm_company_items', 'array', ['status' => 1, 'company_id' => $parent_id], 'id,item_name_ecoex', '', '', $orderBy2);

        if ($this->request->getMethod() == 'post') {
            $item_id            = $this->request->getPost('item_id');
            $qty                = $this->request->getPost('qty');
            $uploadedFiles      = $this->request->getFileMultiple('new_product_image');
            $uploadPath         = FCPATH . 'uploads/enquiry/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $imageNames = [];

            if ($uploadedFiles && is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        // Use random name (safe) or keep original with getClientName()
                        $newName = $file->getRandomName();
                        $file->move($uploadPath, $newName);

                        $imageNames[] = $newName;
                    }
                }
            }

            $plant_id       = $id;
            $company_id     = $parent_id;
            /* sl no*/
            $orderBy[0] = ['field' => 'id', 'type' => 'DESC'];
            $checkEnq = $this->common_model->find_data('ecomm_enquires', 'row', '', 'sl_no', '', '', $orderBy);
            if ($checkEnq) {
                // exist
                $sl_no              = $checkEnq->sl_no;
                $next_sl_no         = $sl_no + 1;
                $next_sl_no_string  = str_pad($next_sl_no, 7, 0, STR_PAD_LEFT);
                $enquiry_no         = 'ECOMM-' . $next_sl_no_string;
            } else {
                // not exist
                $next_sl_no         = 1;
                $next_sl_no_string  = str_pad($next_sl_no, 7, 0, STR_PAD_LEFT);
                $enquiry_no         = 'ECOMM-' . $next_sl_no_string;
            }
            /* sl no*/
            /* gps track image */
            $gps_tracking = '';
            /* gps track image */

            $fields1            = [
                'plant_id'                  => $plant_id,
                'company_id'                => $company_id,
                'sl_no'                     => $next_sl_no,
                'enquiry_no'                => $enquiry_no,
                'gps_tracking_image'        => $gps_tracking,
                'tentative_collection_date' => '',
                'latitude'                  => '',
                'longitude'                 => '',
                'device_brand'              => '',
                'device_model'              => '',
                'created_by'                => 0,
            ];
            // pr($fields1,0);
            $enq_id = $this->data['model']->save_data('ecomm_enquires', $fields1, '', 'id');

            if (!empty($item_id)) {
                for ($k = 0; $k < count($item_id); $k++) {
                    $getItem = $this->data['model']->find_data('ecomm_company_items', 'row', ['id' => $item_id[$k]], 'item_name_ecoex,hsn,unit');
                    $item_images = [];
                    $item_images[] = $imageNames[$k];
                    $fields2 = [
                        'enq_id'                        => $enq_id,
                        'plant_id'                      => $plant_id,
                        'company_id'                    => $company_id,
                        'sl_no'                         => $next_sl_no,
                        'new_product'                   => 0,
                        'product_id'                    => $item_id[$k],
                        'new_hsn'                       => (($getItem) ? $getItem->hsn : ''),
                        'qty'                           => $qty[$k],
                        'unit'                          => (($getItem) ? $getItem->unit : 0),
                        'new_product_image'             => json_encode($item_images),
                        'status'                        => 0,
                    ];
                    // pr($fields2,0);
                    $this->data['model']->save_data('ecomm_enquiry_products', $fields2, '', 'id');
                }
            }

            $this->session->setFlashdata('success_message', $this->data['title'].' enquiry created successfully');
            return redirect()->to('/admin/enquiry-requests/list/' . encoded(0));
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function createEnquiry($id)
    {
        if (!$this->common_model->checkModuleFunctionAccess(15, 115)) {
            $data['action']             = 'Access Forbidden';
            $title                      = $data['action'].' '.$this->data['title'];
            $page_name                  = 'access-forbidden';
            echo $this->layout_after_login($title, $page_name, $data);
            exit;
        }
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' Final '.$this->data['title'] . ' Enquiry';
        $page_name                  = 'plant/create-enquiry';

        $conditions                 = array($this->data['primary_key'] => $id);
        $data['plant']              = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);
        $parent_id                  = (($data['plant']) ? $data['plant']->parent_id : 0);
        $data['company']            = $this->data['model']->find_data('ecoex_companies', 'row', ['id' => $parent_id], 'company_name');

        $orderBy2[0]                = ['field' => 'item_name_ecoex', 'type' => 'ASC'];
        $data['items']              = $this->data['model']->find_data('ecomm_company_items', 'array', ['status' => 1, 'company_id' => $parent_id], 'id,item_name_ecoex', '', '', $orderBy2);

        if ($this->request->getMethod() == 'post') {
            $item_id            = $this->request->getPost('item_id');
            $qty                = $this->request->getPost('qty');
            $uploadedFiles      = $this->request->getFileMultiple('new_product_image');
            $uploadPath         = 'public/uploads/enquiry/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $imageNames = [];

            if ($uploadedFiles && is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        // Use random name (safe) or keep original with getClientName()
                        $newName = $file->getRandomName();
                        $file->move($uploadPath, $newName);

                        $imageNames[] = $newName;
                    }
                }
            }

            $plant_id       = $id;
            $company_id     = $parent_id;
            /* sl no*/
            $orderBy[0] = ['field' => 'id', 'type' => 'DESC'];
            $checkEnq = $this->common_model->find_data('ecomm_enquires', 'row', '', 'sl_no', '', '', $orderBy);
            if ($checkEnq) {
                // exist
                $sl_no              = $checkEnq->sl_no;
                $next_sl_no         = $sl_no + 1;
                $next_sl_no_string  = str_pad($next_sl_no, 7, 0, STR_PAD_LEFT);
                $enquiry_no         = 'ECOMM-' . $next_sl_no_string;
            } else {
                // not exist
                $next_sl_no         = 1;
                $next_sl_no_string  = str_pad($next_sl_no, 7, 0, STR_PAD_LEFT);
                $enquiry_no         = 'ECOMM-' . $next_sl_no_string;
            }
            /* sl no*/
            /* gps track image */
            $file = $this->request->getFile('gps_tracking_image');
            $originalName = $file->getClientName();
            $fieldName = 'gps_tracking_image';
            if ($file != '') {
                $upload_array = $this->common_model->upload_single_file($fieldName, $originalName, 'enquiry', 'image');
                if ($upload_array['status']) {
                    $gps_tracking_image = $upload_array['newFilename'];
                } else {
                    $this->session->setFlashdata('error_message', 'GPS image required');
                    return redirect(current_url());
                }
            } else {
                $this->session->setFlashdata('error_message', 'GPS image required');
                return redirect(current_url());
            }
            /* gps track image */

            $fields1            = [
                'plant_id'                  => $plant_id,
                'company_id'                => $company_id,
                'sl_no'                     => $next_sl_no,
                'enquiry_no'                => $enquiry_no,
                'gps_tracking_image'        => $gps_tracking_image,
                'tentative_collection_date' => $this->request->getPost('tentative_collection_date'),
                'latitude'                  => '',
                'longitude'                 => '',
                'device_brand'              => '',
                'device_model'              => '',
                'created_by'                => 0,
            ];
            $enq_id = $this->data['model']->save_data('ecomm_enquires', $fields1, '', 'id');

            if (!empty($item_id)) {
                for ($k = 0; $k < count($item_id); $k++) {
                    $getItem = $this->data['model']->find_data('ecomm_company_items', 'row', ['id' => $item_id[$k]], 'item_name_ecoex,hsn,unit');
                    $item_images = [];
                    $item_images[] = $imageNames[$k];
                    $fields2 = [
                        'enq_id'                        => $enq_id,
                        'plant_id'                      => $plant_id,
                        'company_id'                    => $company_id,
                        'sl_no'                         => $next_sl_no,
                        'new_product'                   => 0,
                        'product_id'                    => $item_id[$k],
                        'new_hsn'                       => (($getItem) ? $getItem->hsn : ''),
                        'qty'                           => $qty[$k],
                        'unit'                          => (($getItem) ? $getItem->unit : 0),
                        'new_product_image'             => json_encode($item_images),
                        'status'                        => 1,
                    ];
                    $this->data['model']->save_data('ecomm_enquiry_products', $fields2, '', 'id');
                }
            }

            $this->session->setFlashdata('success_message', $this->data['title'].' enquiry created successfully');
            return redirect()->to('/admin/enquiry-requests/list/' . encoded(0));
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
}
