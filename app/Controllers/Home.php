<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $data['title']              = $data['general_settings']->site_name;
        $data['page_header']        = $data['general_settings']->site_name;
        $data['page_content']       = $this->common_model->find_data('ecomm_pages', 'row', ['id' => 3]);

        return view('launch-page', $data);
    }
    // enquiry request for whatsapp share
    public function enquiryRequest($id)
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $id                         = decoded($id);
        $data['enquiry']            = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $id]);
        
        return view('enquiry-request-details', $data);
    }
    public function deleteAccountRequest()
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $data['title']              = $data['general_settings']->site_name;
        $data['page_header']        = $data['general_settings']->site_name;
        $data['page_content']       = $this->common_model->find_data('ecomm_pages', 'row', ['id' => 3]);

        if($this->request->getMethod() == 'post') {
            $postData   = array(
                'user_type'             => $this->request->getPost('user_type'),
                'entity_name'           => $this->request->getPost('entity_name'),
                'email'                 => $this->request->getPost('email'),
                'is_email_verify'       => $this->request->getPost('is_email_verify'),
                'phone'                 => $this->request->getPost('phone'),
                'is_phone_verify'       => $this->request->getPost('is_phone_verify'),
                'comments'              => $this->request->getPost('comments'),
            );
            // pr($postData);
            $this->common_model->save_data('ecomm_delete_account_requests', $postData, '', 'id');            
            $this->session->setFlashdata('success_message', 'Delete Account Request Submitted Successfully. We Will Update You Shortly !!!');
            return redirect()->to(current_url());
        }
        
        return view('delete-account-request', $data);
    }

    public function getEmailOTP(){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $requestData        = $this->request->getPost();
        $user_type          = $requestData['user_type'];
        $email              = $requestData['email'];
        if($user_type == 'COMPANY'){
            $tableName = 'ecoex_companies';
        } else {
            $tableName = 'ecomm_users';
        }
        $getEntity          = $this->common_model->find_data($tableName, 'row', ['email' => $email]);
        if($getEntity){
            $remember_token = rand(100000,999999);
            /* send email */
                $mailData                   = [
                    'id'            => $getEntity->id,
                    'email'         => $getEntity->email,
                    'phone'         => $getEntity->phone,
                    'otp'           => $remember_token,
                ];
                $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                $subject                    = $generalSetting->site_name.' :: Email Verify OTP For Signup';
                $message                    = view('email-templates/otp',$mailData);
                $this->sendMail($email, $subject, $message);

                $apiResponse        = [
                    'email_otp'     => $remember_token,
                    'entity_name'   => (($getEntity)?$getEntity->company_name:''),
                ];
                $apiStatus          = TRUE;
                $apiMessage         = 'OTP Sent To Email Successfully !!!';
            /* send email */
        } else {
            $apiStatus          = FALSE;
            $apiMessage         = 'We Don\'t Recognize You !!!';
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    }
    public function getPhoneOTP(){
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $requestData        = $this->request->getPost();
        $user_type          = $requestData['user_type'];
        $phone              = $requestData['phone'];
        if($user_type == 'COMPANY'){
            $tableName = 'ecoex_companies';
        } else {
            $tableName = 'ecomm_users';
        }
        $getEntity          = $this->common_model->find_data($tableName, 'row', ['phone' => $phone]);
        if($getEntity){
            $mobile_otp = rand(100000,999999);
            /* send sms */
                $message = "Dear ".$user_type.", ".$mobile_otp." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                $mobileNo = $phone;
                $this->sendSMS($mobileNo,$message);

                $apiResponse        = [
                    'phone_otp'     => $mobile_otp,
                    'entity_name'   => (($getEntity)?$getEntity->company_name:''),
                ];
                $apiStatus          = TRUE;
                $apiMessage         = 'OTP Sent To Phone Successfully !!!';
            /* send sms */
        } else {
            $apiStatus          = FALSE;
            $apiMessage         = 'We Don\'t Recognize You !!!';
        }
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
    }
}
