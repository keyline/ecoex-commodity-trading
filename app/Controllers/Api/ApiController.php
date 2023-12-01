<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Libraries\CreatorJwt;
use App\Libraries\JWT;

class ApiController extends BaseController
{
    /* before login */
        public function getAppSetting(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $headerData            = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $generalSetting = $this->common_model->find_data('general_settings', 'row');
                if($generalSetting){
                    $apiResponse = [
                        'site_name'             => $generalSetting->site_name,
                        'site_phone'            => $generalSetting->site_phone,
                        'site_mail'             => $generalSetting->site_mail,
                        'site_url'              => $generalSetting->site_url,
                        'site_logo'             => getenv('app.uploadsURL').$generalSetting->site_logo,
                    ];
                }
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Data Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function getStaticPages(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['page_slug'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $page = $this->common_model->find_data('ecomm_pages', 'row', ['slug' => $requestData['page_slug']]);
                if($page){
                    $apiResponse = [
                        'page_title'                => $page->page_title,
                        'slug'                      => $page->slug,
                        'short_description'         => $page->short_description,
                        'long_description'          => $page->long_description,
                        'meta_title'                => $page->meta_title,
                        'meta_description'          => $page->meta_description,
                        'meta_keywords'             => $page->meta_keywords,
                    ];
                }
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Data Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function getProductCategory(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $headerData            = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $orderBy[0]     = ['field' => 'name', 'type' => 'ASC'];
                $rows           = $this->common_model->find_data('ecomm_product_categories', 'array', ['status' => 1], 'id,name', '', '', $orderBy);
                if($rows){
                    foreach($rows as $row){
                        $apiResponse[] = [
                            'id'                => $row->id,
                            'name'              => $row->name
                        ];
                    }
                }
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Data Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
        public function getMemberType(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $headerData            = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $orderBy[0]     = ['field' => 'name', 'type' => 'ASC'];
                $rows           = $this->common_model->find_data('ecomm_member_types', 'array', ['status' => 1], 'id,name', '', '', $orderBy);
                if($rows){
                    foreach($rows as $row){
                        $apiResponse[] = [
                            'id'                => $row->id,
                            'name'              => $row->name
                        ];
                    }
                }
                http_response_code(200);
                $apiStatus          = TRUE;
                $apiMessage         = 'Data Available !!!';
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
        }
    /* before login */
    /* authentication */
        // signup
        public function getCompanyDetails(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['gst_no'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $generalSetting = $this->common_model->find_data('general_settings', 'row');
                $gst_no         = $requestData['gst_no'];
                $checkGST       = $this->common_model->find_data('ecomm_users', 'row', ['gst_no' => $gst_no]);
                if($checkGST){
                    $apiStatus      = FALSE;
                    $apiMessage     = "GSTIN No. Already Exists !!!";
                } else {
                    $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://sheet.gstincheck.co.in/check/edb8e6902f3ca57767d04972cd7a1ad2/'.$gst_no);
                    curl_setopt($ch, CURLOPT_URL, 'https://sheet.gstincheck.co.in/check/'.$generalSetting->gst_api_code.'/'.$gst_no); //info@leylines.net
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = json_decode(curl_exec($ch));
                    if($response){
                        if($response->flag){
                            $gstResponse    = [
                                'trade_name'    => trim($response->data->tradeNam, " "),
                                'gstin'         => trim($response->data->gstin, " "),
                                'address'       => trim($response->data->pradr->adr, " "),
                                'holding_no'    => (($response->data->pradr->addr->bnm != '')?trim($response->data->pradr->addr->bnm, " "):trim($response->data->pradr->addr->flno, " ")),
                                'street'        => trim($response->data->pradr->addr->st, " "),
                                'district'      => trim($response->data->pradr->addr->dst, " "),
                                'state'         => trim($response->data->pradr->addr->stcd, " "),
                                'pincode'       => trim($response->data->pradr->addr->pncd, " "),
                                'location'      => trim($response->data->pradr->addr->loc, " "),
                            ];
                            $apiResponse    = $gstResponse;
                            // pr($apiResponse);
                            http_response_code(200);
                            $apiStatus          = TRUE;
                            $apiMessage         = "Company Details Available !!!";
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        } else {
                            http_response_code(400);
                            $apiStatus          = FALSE;
                            $apiMessage         = "Company Details Not Available !!!";
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        http_response_code(400);
                        $apiStatus          = FALSE;
                        $apiMessage         = "Not Valid GSTIN No. !!!";
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
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
        public function getCompanyDetails2(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['gst_no'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $generalSetting = $this->common_model->find_data('general_settings', 'row');
                $gst_no         = $requestData['gst_no'];
                $checkGST       = $this->common_model->find_data('ecoex_companies', 'row', ['gst_no' => $gst_no]);
                if($checkGST){
                    $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://sheet.gstincheck.co.in/check/edb8e6902f3ca57767d04972cd7a1ad2/'.$gst_no);
                    curl_setopt($ch, CURLOPT_URL, 'https://sheet.gstincheck.co.in/check/'.$generalSetting->gst_api_code.'/'.$gst_no); //info@leylines.net
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = json_decode(curl_exec($ch));
                    if($response){
                        if($response->flag){
                            $gstResponse    = [
                                'trade_name'    => trim($response->data->tradeNam, " "),
                                'gstin'         => trim($response->data->gstin, " "),
                                'address'       => trim($response->data->pradr->adr, " "),
                                'holding_no'    => (($response->data->pradr->addr->bnm != '')?trim($response->data->pradr->addr->bnm, " "):trim($response->data->pradr->addr->flno, " ")),
                                'street'        => trim($response->data->pradr->addr->st, " "),
                                'district'      => trim($response->data->pradr->addr->dst, " "),
                                'state'         => trim($response->data->pradr->addr->stcd, " "),
                                'pincode'       => trim($response->data->pradr->addr->pncd, " "),
                                'location'      => trim($response->data->pradr->addr->loc, " "),
                            ];
                            $apiResponse    = $gstResponse;
                            // pr($apiResponse);
                            http_response_code(200);
                            $apiStatus          = TRUE;
                            $apiMessage         = "Company Details Available !!!";
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        } else {
                            http_response_code(400);
                            $apiStatus          = FALSE;
                            $apiMessage         = "Company Details Not Available !!!";
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        http_response_code(400);
                        $apiStatus          = FALSE;
                        $apiMessage         = "Not Valid GSTIN No. !!!";
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://sheet.gstincheck.co.in/check/edb8e6902f3ca57767d04972cd7a1ad2/'.$gst_no);
                    curl_setopt($ch, CURLOPT_URL, 'https://sheet.gstincheck.co.in/check/'.$generalSetting->gst_api_code.'/'.$gst_no); //info@leylines.net
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = json_decode(curl_exec($ch));
                    if($response){
                        if($response->flag){
                            $gstResponse    = [
                                'trade_name'    => trim($response->data->tradeNam, " "),
                                'gstin'         => trim($response->data->gstin, " "),
                                'address'       => trim($response->data->pradr->adr, " "),
                                'holding_no'    => (($response->data->pradr->addr->bnm != '')?trim($response->data->pradr->addr->bnm, " "):trim($response->data->pradr->addr->flno, " ")),
                                'street'        => trim($response->data->pradr->addr->st, " "),
                                'district'      => trim($response->data->pradr->addr->dst, " "),
                                'state'         => trim($response->data->pradr->addr->stcd, " "),
                                'pincode'       => trim($response->data->pradr->addr->pncd, " "),
                                'location'      => trim($response->data->pradr->addr->loc, " "),
                            ];
                            $apiResponse    = $gstResponse;
                            // pr($apiResponse);
                            http_response_code(200);
                            $apiStatus          = TRUE;
                            $apiMessage         = "Company Details Available !!!";
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        } else {
                            http_response_code(400);
                            $apiStatus          = FALSE;
                            $apiMessage         = "Company Details Not Available !!!";
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        http_response_code(400);
                        $apiStatus          = FALSE;
                        $apiMessage         = "Not Valid GSTIN No. !!!";
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
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
        public function signup()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $requiredFields     = ['gst_no', 'company_name', 'full_address', 'district', 'state', 'pincode', 'location', 'email', 'phone', 'password', 'confirm_password', 'member_type'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $phone      = $requestData['phone'];
                $checkEmail = $this->common_model->find_data('ecomm_users', 'row', ['email' => $requestData['email']]);
                if(empty($checkEmail)){
                    $checkPhone = $this->common_model->find_data('ecomm_users', 'count', ['phone' => $phone]);
                    if($checkPhone <= 0){
                        if($requestData['password'] == $requestData['confirm_password']){
                            $remember_token = rand(100000,999999);
                            $mobile_otp     = rand(100000,999999);
                            $postData       = [
                                'gst_no'                    => $requestData['gst_no'],
                                'company_name'              => $requestData['company_name'],
                                'full_address'              => $requestData['full_address'],
                                'holding_no'                => $requestData['holding_no'],
                                'street'                    => $requestData['street'],
                                'district'                  => $requestData['district'],
                                'state'                     => $requestData['state'],
                                'pincode'                   => $requestData['pincode'],
                                'location'                  => $requestData['location'],
                                'email'                     => $requestData['email'],
                                'email_verified_at'         => date('Y-m-d H:i:s'),
                                'phone'                     => $phone,
                                'password'                  => md5($requestData['password']),
                                'remember_token'            => $remember_token,
                                'mobile_otp'                => $mobile_otp,
                                'member_type'               => $requestData['member_type']
                            ];
                            // pr($postData);
                            $getUser = $this->common_model->find_data('ecomm_users', 'row', ['email' => $requestData['email']]);
                            if(!$getUser){
                                $id = $this->common_model->save_data('ecomm_users', $postData, '', 'id');
                            } else {
                                $this->common_model->save_data('ecomm_users', $postData, $getUser->id, 'id');
                                $id = $getUser->id;
                            }
                            $getUser = $this->common_model->find_data('ecomm_users', 'row', ['id' => $id]);

                            $mailData                   = [
                                'id'            => $getUser->id,
                                'email'         => $getUser->email,
                                'otp'           => $remember_token,
                                'mobile_otp'    => $mobile_otp,
                            ];
                            /* send email */
                                $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                                $subject                    = $generalSetting->site_name.' :: Email Verify OTP For Signup';
                                $message                    = view('email-templates/otp',$mailData);
                                // echo $message;die;
                                $this->sendMail($getUser->email, $subject, $message);
                            /* send email */
                            /* send sms */
                                $memberType             = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $getUser->member_type], 'name');
                                $message = "Dear ".(($memberType)?$memberType->name:'ECOEX').", ".$mobile_otp." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                                $mobileNo = (($getUser)?$getUser->phone:'');
                                $this->sendSMS($mobileNo,$message);
                            /* send sms */

                            /* email log save */
                                $postData2 = [
                                    'name'                  => $getUser->company_name,
                                    'email'                 => $getUser->email,
                                    'subject'               => $subject,
                                    'message'               => $message
                                ];
                                $this->common_model->save_data('email_logs', $postData2, '', 'id');
                            /* email log save */

                            $apiResponse                        = $mailData;
                            
                            $apiStatus          = TRUE;
                            http_response_code(200);
                            $apiMessage         = 'Signup Partially Completed. Please Verify Email & Phone. Get Notify After Admin Approval !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                            
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(404);
                            $apiMessage         = 'Password & Confirm Password Does Not Matched !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'Phone Already Registered !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'Email Already Registered !!!';
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
        public function signupOTPResend()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $requiredFields     = ['id'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $getUser = $this->common_model->find_data('ecomm_users', 'row', ['id' => $requestData['id']]);
                if($getUser){
                    $remember_token = rand(100000,999999);
                    $mobile_otp     = rand(100000,999999);
                    $this->common_model->save_data('ecomm_users', ['remember_token' => $remember_token, 'mobile_otp' => $mobile_otp], $requestData['id'], 'id');
                    $mailData                   = [
                        'id'            => $getUser->id,
                        'email'         => $getUser->email,
                        'phone'         => $getUser->phone,
                        'otp'           => $remember_token,
                        'mobile_otp'    => $mobile_otp,
                    ];
                    /* send email */
                        $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                        $subject                    = $generalSetting->site_name.' :: Email Verify OTP For Signup';
                        $message                    = view('email-templates/otp',$mailData);
                        // echo $message;die;
                        $this->sendMail($getUser->email, $subject, $message);
                    /* send email */
                    /* send sms */
                        $memberType             = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $getUser->member_type], 'name');
                        $message = "Dear ".(($memberType)?$memberType->name:'ECOEX').", ".$mobile_otp." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                        $mobileNo = (($getUser)?$getUser->phone:'');
                        $this->sendSMS($mobileNo,$message);
                    /* send sms */

                    /* email log save */
                        $postData2 = [
                            'name'                  => $getUser->company_name,
                            'email'                 => $getUser->email,
                            'subject'               => $subject,
                            'message'               => $message
                        ];
                        $this->common_model->save_data('email_logs', $postData2, '', 'id');
                    /* email log save */

                    $apiResponse        = $mailData;
                    $apiStatus          = TRUE;
                    http_response_code(200);
                    $apiMessage         = 'OTP Resend To Email & SMS Successfully !!!';
                    $apiExtraField      = 'response_code';
                    $apiExtraData       = http_response_code();
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'User Not Found !!!';
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
        public function signupOTPVerify(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $requiredFields     = ['id'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $getUser = $this->common_model->find_data('ecomm_users', 'row', ['id' => $requestData['id']]);
                if($getUser){
                    $email_otp_input        = $requestData['email_otp_input'];
                    $mobile_otp_input       = $requestData['mobile_otp_input'];
                    $remember_token         = $getUser->remember_token;
                    $mobile_otp             = $getUser->mobile_otp;

                    if($email_otp_input == '' && $mobile_otp_input == ''){
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'Email Or Mobile OTP Required !!!';
                        $apiExtraField      = 'response_code';
                    } else {
                        /* email & mobile verify */
                            if(($email_otp_input != '') && ($mobile_otp_input != '')){
                                if($remember_token == $email_otp_input){
                                    if($mobile_otp == $mobile_otp_input){
                                        $this->common_model->save_data('ecomm_users', ['mobile_otp' => '', 'remember_token' => ''], $getUser->id, 'id');

                                        $apiResponse        = [
                                            'id'    => $getUser->id,
                                            'email' => $getUser->email,
                                            'phone' => $getUser->phone,
                                        ];
                                        $apiStatus                          = TRUE;
                                        http_response_code(200);
                                        $apiMessage                         = 'Email & Mobile OTP Validated Successfully !!!';
                                        $apiExtraField                      = 'response_code';
                                        $apiExtraData                       = http_response_code();
                                    } else {
                                        $apiStatus          = FALSE;
                                        http_response_code(404);
                                        $apiMessage         = 'Mobile OTP Mismatched !!!';
                                        $apiExtraField      = 'response_code';
                                    }
                                } else {
                                    $apiStatus          = FALSE;
                                    http_response_code(404);
                                    $apiMessage         = 'Email OTP Mismatched !!!';
                                    $apiExtraField      = 'response_code';
                                }
                            } else {
                                /* email verify */
                                    if($email_otp_input != ''){
                                        if($remember_token == $email_otp_input){
                                            $this->common_model->save_data('ecomm_users', ['remember_token' => ''], $getUser->id, 'id');
                                            $apiResponse        = [
                                                'id'    => $getUser->id,
                                                'email' => $getUser->email,
                                                'phone' => $getUser->phone,
                                            ];
                                            $apiStatus                          = TRUE;
                                            http_response_code(200);
                                            $apiMessage                         = 'Email OTP Validated Successfully !!!';
                                            $apiExtraField                      = 'response_code';
                                            $apiExtraData                       = http_response_code();
                                        } else {
                                            $apiStatus          = FALSE;
                                            http_response_code(404);
                                            $apiMessage         = 'Email OTP Mismatched !!!';
                                            $apiExtraField      = 'response_code';
                                        }
                                    }
                                /* email verify */
                                /* mobile verify */
                                    if($mobile_otp_input != ''){
                                        if($mobile_otp == $mobile_otp_input){
                                            $this->common_model->save_data('ecomm_users', ['mobile_otp' => ''], $getUser->id, 'id');
                                            $apiResponse        = [
                                                'id'    => $getUser->id,
                                                'email' => $getUser->email,
                                                'phone' => $getUser->phone,
                                            ];
                                            $apiStatus                          = TRUE;
                                            http_response_code(200);
                                            $apiMessage                         = 'Mobile OTP Validated Successfully !!!';
                                            $apiExtraField                      = 'response_code';
                                            $apiExtraData                       = http_response_code();
                                        } else {
                                            $apiStatus          = FALSE;
                                            http_response_code(404);
                                            $apiMessage         = 'Mobile OTP Mismatched !!!';
                                            $apiExtraField      = 'response_code';
                                        }
                                    }
                                /* mobile verify */
                            }
                        /* email & mobile verify */
                    }
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'User Not Found !!!';
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
        // signup
        // forgot password
        public function forgotPassword(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $requiredFields     = ['email'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $checkEmail = $this->common_model->find_data('ecomm_users', 'row', ['email' => $requestData['email']]);
                if($checkEmail){
                    $remember_token  = rand(100000,999999);
                    $this->common_model->save_data('ecomm_users', ['remember_token' => $remember_token], $checkEmail->id, 'id');
                    $mailData                   = [
                        'id'    => $checkEmail->id,
                        'email' => $checkEmail->email,
                        'otp'   => $remember_token,
                    ];
                    $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                    $subject                    = $generalSetting->site_name.' :: Forgot Password OTP';
                    $message                    = view('email-templates/otp',$mailData);
                    // echo $message;die;
                    $this->sendMail($requestData['email'], $subject, $message);

                    /* email log save */
                        $postData2 = [
                            'name'                  => $checkEmail->company_name,
                            'email'                 => $requestData['email'],
                            'subject'               => $subject,
                            'message'               => $message
                        ];
                        $this->common_model->save_data('email_logs', $postData2, '', 'id');
                    /* email log save */

                    $apiResponse                        = $mailData;
                    $apiStatus                          = TRUE;
                    http_response_code(200);
                    $apiMessage                         = 'OTP Sent To Email For Validation !!!';
                    $apiExtraField                      = 'response_code';
                    $apiExtraData                       = http_response_code();
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'Email Not Registered With Us !!!';
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
        public function validateOTP(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $requiredFields     = ['id', 'otp'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $getUser = $this->common_model->find_data('ecomm_users', 'row', ['id' => $requestData['id']]);
                if($getUser){
                    $remember_token  = $getUser->remember_token;
                    if($remember_token == $requestData['otp']){
                        $this->common_model->save_data('ecomm_users', ['remember_token' => ''], $getUser->id, 'id');
                        $apiResponse        = [
                            'id'    => $getUser->id,
                            'email' => $getUser->email
                        ];
                        $apiStatus                          = TRUE;
                        http_response_code(200);
                        $apiMessage                         = 'OTP Validated Successfully !!!';
                        $apiExtraField                      = 'response_code';
                        $apiExtraData                       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'OTP Mismatched !!!';
                        $apiExtraField      = 'response_code';
                    }
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'User Not Found !!!';
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
        public function resendOtp(){
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $requiredFields     = ['id'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $id         = $requestData['id'];
                $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $id]);
                if($getUser){
                    $remember_token = rand(100000,999999);
                    $postData = [
                        'remember_token'        => $remember_token
                    ];
                    $this->common_model->save_data('ecomm_users', ['remember_token' => $remember_token], $getUser->id, 'id');

                    $mailData                   = [
                        'id'    => $getUser->id,
                        'email' => $getUser->email,
                        'otp'   => $remember_token,
                    ];
                    $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                    $subject                    = $generalSetting->site_name.' :: Forgot Password OTP';
                    $message                    = view('email-templates/otp',$mailData);
                    // echo $message;die;
                    $this->sendMail($getUser->email, $subject, $message);

                    /* email log save */
                        $postData2 = [
                            'name'                  => $getUser->company_name,
                            'email'                 => $getUser->email,
                            'subject'               => $subject,
                            'message'               => $message
                        ];
                        $this->common_model->save_data('email_logs', $postData2, '', 'id');
                    /* email log save */

                    $apiResponse                        = $mailData;
                    $apiStatus                          = TRUE;
                    http_response_code(200);
                    $apiMessage                         = 'OTP Resend Successfully !!!';
                    $apiExtraField                      = 'response_code';
                    $apiExtraData                       = http_response_code();
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(400);
                    $apiMessage         = 'User Not Found !!!';
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
        public function resetPassword()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $requiredFields     = ['id', 'password', 'confirm_password'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                http_response_code(406);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $id         = $requestData['id'];
                $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $id]);
                if($getUser){
                    if($requestData['password'] == $requestData['confirm_password']){
                        $this->common_model->save_data('ecomm_users', ['password' => md5($requestData['password'])], $getUser->id, 'id');
                        
                        $mailData        = [
                            'id'                => $getUser->id,
                            'company_name'      => $getUser->company_name,
                            'email'             => $getUser->email
                        ];
                        $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                        $subject                    = $generalSetting->site_name.' :: Reset Password';
                        $message                    = view('email-templates/change-password',$mailData);
                        // echo $message;die;
                        $this->sendMail($getUser->email, $subject, $message);
                        
                        $apiStatus                          = TRUE;
                        http_response_code(200);
                        $apiMessage                         = 'Password Reset Successfully !!!';
                        $apiExtraField                      = 'response_code';
                        $apiExtraData                       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'Password & Confirm Password Not Matched !!!';
                        $apiExtraField      = 'response_code';
                    }
                } else {
                    $apiStatus          = FALSE;
                    http_response_code(404);
                    $apiMessage         = 'User Not Found !!!';
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
        // forgot password
        // signin
            public function signin()
            {
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['email', 'password', 'device_token'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){
                    $apiStatus          = FALSE;
                    $apiMessage         = 'All Data Are Not Present !!!';
                }
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $email                      = $requestData['email'];
                    $password                   = $requestData['password'];
                    $device_token               = $requestData['device_token'];
                    $fcm_token                  = $requestData['fcm_token'];
                    $device_type                = trim($headerData['Source'], "Source: ");
                    $checkUser                  = $this->common_model->find_data('ecomm_users', 'row', ['email' => $email, 'status>=' => 1]);
                    if($checkUser){
                        if(md5($password) == $checkUser->password){
                            $objOfJwt           = new CreatorJwt();
                            $app_access_token   = $objOfJwt->GenerateToken($checkUser->id, $checkUser->email, $checkUser->phone);
                            $user_id                        = $checkUser->id;
                            $fields     = [
                                'user_id'               => $user_id,
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            $checkUserTokenExist                  = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $app_access_token]);
                            if(!$checkUserTokenExist){
                                $this->common_model->save_data('ecomm_user_devices', $fields, '', 'id');
                            } else {
                                $this->common_model->save_data('ecomm_user_devices', $fields, $checkUserTokenExist->id, 'id');
                            }

                            $userActivityData = [
                                'user_email'        => $checkUser->email,
                                'user_name'         => $checkUser->company_name,
                                'activity_type'     => 1,
                                'user_type'         => 'USER',
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_details'  => $checkUser->type.' Sign In Success',
                            ];
                            // pr($userActivityData);
                            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');

                            $apiResponse = [
                                'user_id'               => $user_id,
                                'company_name'          => $checkUser->company_name,
                                'email'                 => $checkUser->email,
                                'phone'                 => $checkUser->phone,
                                'type'                  => $checkUser->type,
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            $apiStatus                          = TRUE;
                            $apiMessage                         = 'SignIn Successfully !!!';
                        } else {
                            $userActivityData = [
                                'user_email'        => $email,
                                'user_name'         => $checkUser->company_name,
                                'user_type'         => 'USER',
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_type'     => 0,
                                'activity_details'  => 'Invalid Password',
                            ];
                            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                            $apiStatus                          = FALSE;
                            $apiMessage                         = 'Invalid Password !!!';
                        }                   
                    } else {
                        $userActivityData = [
                            'user_email'        => $email,
                            'user_name'         => '',
                            'user_type'         => 'USER',
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize Your Email Address',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'We Don\'t Recognize You !!!';
                    }
                } else {
                    $apiStatus          = FALSE;
                    $apiMessage         = 'Unauthenticate Request !!!';
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
            }
            public function signinWithMobile()
            {
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['phone'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){
                    $apiStatus          = FALSE;
                    $apiMessage         = 'All Data Are Not Present !!!';
                }
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $phone                      = $requestData['phone'];
                    $checkUser                  = $this->common_model->find_data('ecomm_users', 'row', ['phone' => $phone, 'status>=' => 1]);
                    if($checkUser){
                        $mobile_otp = rand(100000,999999);
                        $postData = [
                            'mobile_otp'        => $mobile_otp
                        ];
                        $this->common_model->save_data('ecomm_users', ['mobile_otp' => $mobile_otp], $checkUser->id, 'id');
                        /* send sms */
                            $memberType             = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $checkUser->member_type], 'name');
                            $message = "Dear ".(($memberType)?$memberType->name:'ECOEX').", ".$mobile_otp." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                            $mobileNo = (($checkUser)?$checkUser->phone:'');
                            $this->sendSMS($mobileNo,$message);
                        /* send sms */
                        $mailData                   = [
                            'id'    => $checkUser->id,
                            'email' => $checkUser->email,
                            'phone' => $checkUser->phone,
                            'otp'   => $mobile_otp,
                        ];
                        $apiResponse                        = $mailData;
                        $apiStatus                          = TRUE;
                        $apiMessage                         = 'Please Enter OTP !!!';
                    } else {
                        $userActivityData = [
                            'user_email'        => '',
                            'user_name'         => '',
                            'user_type'         => 'USER',
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize Your Phone Number',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'We Don\'t Recognize You !!!';
                    }
                } else {
                    $apiStatus          = FALSE;
                    $apiMessage         = 'Unauthenticate Request !!!';
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
            }
            public function signinValidateMobile()
            {
                $apiStatus          = TRUE;
                $apiMessage         = '';
                $apiResponse        = [];
                $this->isJSON(file_get_contents('php://input'));
                $requestData        = $this->extract_json(file_get_contents('php://input'));
                $requiredFields     = ['phone', 'otp', 'device_token'];
                $headerData         = $this->request->headers();
                if (!$this->validateArray($requiredFields, $requestData)){
                    $apiStatus          = FALSE;
                    $apiMessage         = 'All Data Are Not Present !!!';
                }
                if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                    $phone                      = $requestData['phone'];
                    $otp                        = $requestData['otp'];
                    $device_token               = $requestData['device_token'];
                    $fcm_token                  = $requestData['fcm_token'];
                    $device_type                = trim($headerData['Source'], "Source: ");
                    $checkUser                  = $this->common_model->find_data('ecomm_users', 'row', ['phone' => $phone, 'status>=' => 1]);
                    if($checkUser){
                        if($otp == $checkUser->mobile_otp){
                            $objOfJwt           = new CreatorJwt();
                            $app_access_token   = $objOfJwt->GenerateToken($checkUser->id, $checkUser->email, $checkUser->phone);
                            $user_id                        = $checkUser->id;
                            $fields     = [
                                'user_id'               => $user_id,
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            $checkUserTokenExist                  = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $app_access_token]);
                            if(!$checkUserTokenExist){
                                $this->common_model->save_data('ecomm_user_devices', $fields, '', 'id');
                            } else {
                                $this->common_model->save_data('ecomm_user_devices', $fields, $checkUserTokenExist->id, 'id');
                            }

                            $userActivityData = [
                                'user_email'        => $checkUser->email,
                                'user_name'         => $checkUser->company_name,
                                'activity_type'     => 1,
                                'user_type'         => 'USER',
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_details'  => $checkUser->type.' Sign In Success',
                            ];
                            // pr($userActivityData);
                            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');

                            $apiResponse = [
                                'user_id'               => $user_id,
                                'company_name'          => $checkUser->company_name,
                                'email'                 => $checkUser->email,
                                'phone'                 => $checkUser->phone,
                                'type'                  => $checkUser->type,
                                'device_type'           => $device_type,
                                'device_token'          => $device_token,
                                'fcm_token'             => $fcm_token,
                                'app_access_token'      => $app_access_token,
                            ];
                            $this->common_model->save_data('ecomm_users', ['mobile_otp' => ''], $checkUser->id, 'id');
                            $apiStatus                          = TRUE;
                            $apiMessage                         = 'SignIn Successfully !!!';
                        } else {
                            $userActivityData = [
                                'user_email'        => $checkUser->email,
                                'user_name'         => $checkUser->company_name,
                                'user_type'         => 'USER',
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_type'     => 0,
                                'activity_details'  => 'OTP Mismatched !!!',
                            ];
                            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                            $apiStatus                          = FALSE;
                            $apiMessage                         = 'OTP Mismatched !!!';
                        }
                    } else {
                        $userActivityData = [
                            'user_email'        => $email,
                            'user_name'         => '',
                            'user_type'         => 'USER',
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize Your Phone Number',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                        $apiStatus                              = FALSE;
                        $apiMessage                             = 'We Don\'t Recognize You !!!';
                    }
                } else {
                    $apiStatus          = FALSE;
                    $apiMessage         = 'Unauthenticate Request !!!';
                }
                $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
            }
        // signin
    /* authentication */
    /* after login */
        public function signout()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                $checkUserTokenExist        = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $app_access_token, 'published' => 1]);
                // pr($checkUserTokenExist);
                if($checkUserTokenExist){
                    $user_id    = $checkUserTokenExist->user_id;
                    $checkUser  = $this->common_model->find_data('ecomm_users', 'row', ['id' => $user_id, 'status' => 1]);
                    /* user activity */
                        $userActivityData = [
                            'user_email'        => (($checkUser)?$checkUser->email:''),
                            'user_name'         => (($checkUser)?$checkUser->company_name:''),
                            'user_type'         => (($checkUser)?$checkUser->type:'USER'),
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 2,
                            'activity_details'  => 'Sign Out Successfully',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                    /* user activity */
                    $this->common_model->delete_data('ecomm_user_devices', $app_access_token, 'app_access_token');

                    $apiStatus                      = TRUE;
                    $apiMessage                     = 'Signout Successfully !!!';
                } else {
                    $apiStatus                      = FALSE;
                    $apiMessage                     = 'Something Went Wrong !!!';
                }               
            } else {
                $apiStatus          = FALSE;
                $apiMessage         = 'Unauthenticate Request !!!';
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function changePassword()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['old_password', 'new_password', 'confirm_password'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $old_password               = $requestData['old_password'];
                $new_password               = $requestData['new_password'];
                $confirm_password           = $requestData['confirm_password'];
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId]);
                    if($getUser){
                        if($getUser->password == md5($old_password)){
                            if($new_password == $confirm_password){
                                if($getUser->password != md5($new_password)){
                                    $fields = [
                                        'password'      => md5($new_password)
                                    ];
                                    $this->common_model->save_data('ecomm_users', $fields, $uId, 'id');
                                    $apiStatus          = TRUE;
                                    http_response_code(200);
                                    $apiMessage         = 'Password Updated Successfully !!!';
                                    $apiExtraField      = 'response_code';
                                    $apiExtraData       = http_response_code();
                                } else {
                                    $apiStatus          = FALSE;
                                    http_response_code(200);
                                    $apiMessage         = 'New & Existing Password Can\'t Be Same !!!';
                                    $apiExtraField      = 'response_code';
                                    $apiExtraData       = http_response_code();
                                }
                            } else {
                                $apiStatus          = FALSE;
                                http_response_code(200);
                                $apiMessage         = 'New & Confirm Password Doesn\'t Matched !!!';
                                $apiExtraField      = 'response_code';
                                $apiExtraData       = http_response_code();
                            }
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(200);
                            $apiMessage         = 'Existing Password Doesn\'t Matched !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getProfile()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId]);
                    if($getUser){
                        $memberType         = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $getUser->member_type], 'name');
                        $apiResponse        = [
                            'type'              => $getUser->type,
                            'gst_no'            => $getUser->gst_no,
                            'company_name'      => $getUser->company_name,
                            'full_address'      => $getUser->full_address,
                            'holding_no'        => $getUser->holding_no,
                            'street'            => $getUser->street,
                            'district'          => $getUser->district,
                            'state'             => $getUser->state,
                            'pincode'           => $getUser->pincode,
                            'location'          => $getUser->location,
                            'email'             => $getUser->email,
                            'phone'             => $getUser->phone,
                            'member_type'       => (($memberType)?$memberType->name:''),
                            'gst_certificate'   => (($getUser->gst_certificate != '')?getenv('app.uploadsURL').'user/'.$getUser->gst_certificate:''),
                            'contact_person_name'                   => $getUser->contact_person_name,
                            'contact_person_designation'            => $getUser->contact_person_designation,
                            'contact_person_document'               => (($getUser->contact_person_document != '')?getenv('app.uploadsURL').'user/'.$getUser->contact_person_document:''),
                            'bank_name'                             => $getUser->bank_name,
                            'branch_name'                           => $getUser->branch_name,
                            'ifsc_code'                             => $getUser->ifsc_code,
                            'account_type'                          => $getUser->account_type,
                            'account_number'                        => $getUser->account_number,
                            'cancelled_cheque'                      => (($getUser->cancelled_cheque != '')?getenv('app.uploadsURL').'user/'.$getUser->cancelled_cheque:''),
                        ];

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function updateProfile()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['type', 'gst_no', 'company_name', 'full_address', 'street', 'district', 'state', 'pincode', 'phone', 'gst_certificate', 'contact_person_name', 'contact_person_designation', 'contact_person_document'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $type                       = $requestData['type'];
                $gst_no                     = $requestData['gst_no'];
                $company_name               = $requestData['company_name'];
                $full_address               = $requestData['full_address'];
                $holding_no                 = $requestData['holding_no'];
                $street                     = $requestData['street'];
                $district                   = $requestData['district'];
                $state                      = $requestData['state'];
                $pincode                    = $requestData['pincode'];
                $location                   = $requestData['location'];
                $phone                      = $requestData['phone'];
                // $email                      = $requestData['email'];

                $gst_certificate                            = $requestData['gst_certificate'];
                $contact_person_name                        = $requestData['contact_person_name'];
                $contact_person_designation                 = $requestData['contact_person_designation'];
                $contact_person_document                    = $requestData['contact_person_document'];
                if($type == 'PLANT'){
                    $bank_name                                  = $requestData['bank_name'];
                    $branch_name                                = $requestData['branch_name'];
                    $ifsc_code                                  = $requestData['ifsc_code'];
                    $account_type                               = $requestData['account_type'];
                    $account_number                             = $requestData['account_number'];
                    $cancelled_cheque                           = $requestData['cancelled_cheque'];
                } else {
                    $bank_name                                  = '';
                    $branch_name                                = '';
                    $ifsc_code                                  = '';
                    $account_type                               = '';
                    $account_number                             = '';
                    $cancelled_cheque                           = '';
                }
                
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId]);
                    if($getUser){
                        $checkPhoneExist = $this->common_model->find_data('ecomm_users', 'row', ['phone' => $phone, 'id!=' => $uId]);
                        if($checkPhoneExist){
                            $apiStatus          = FALSE;
                            http_response_code(200);
                            $apiMessage         = 'Phone No. Already Exists. Please Use Other Phone No. !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        } else {
                            // pr($requestData);die;
                            /* gst certificate */
                                if(!empty($gst_certificate)){
                                    $gst_certificate    = $gst_certificate[0];
                                    $upload_type        = $gst_certificate['type'];
                                    if($upload_type == 'application/pdf'){
                                        $upload_base64      = $gst_certificate['base64'];
                                        $img                = $upload_base64;
                                        // $img            = $upload_file['base64'];
                                        // $img            = str_replace('data:application/pdf;base64,', '', $upload_file);
                                        // $img            = str_replace(' ', '+', $img);
                                        $data           = base64_decode($img);
                                        $fileName       = uniqid() . '.pdf';
                                        $file           = 'public/uploads/user/' . $fileName;
                                        $success        = file_put_contents($file, $data);
                                        $gst_docs       = $fileName;
                                    } else {
                                        $apiStatus          = FALSE;
                                        http_response_code(404);
                                        $apiMessage         = 'Please Upload Document in PDF Format !!!';
                                        $apiExtraField      = 'response_code';
                                        $apiExtraData       = http_response_code();
                                    }
                                } else {
                                    $gst_docs = $getUser->gst_certificate;
                                }
                            /* gst certificate */
                            /* pan card/company ID */
                                if(!empty($contact_person_document)){
                                    $contact_person_document    = $contact_person_document[0];
                                    $upload_type        = $contact_person_document['type'];
                                    if($upload_type == 'application/pdf'){
                                        $upload_base64      = $contact_person_document['base64'];
                                        $img                = $upload_base64;
                                        // $img            = $upload_file['base64'];
                                        // $img            = str_replace('data:application/pdf;base64,', '', $upload_file);
                                        // $img            = str_replace(' ', '+', $img);
                                        $data           = base64_decode($img);
                                        $fileName       = uniqid() . '.pdf';
                                        $file           = 'public/uploads/user/' . $fileName;
                                        $success        = file_put_contents($file, $data);
                                        $pan_docs       = $fileName;
                                    } else {
                                        $apiStatus          = FALSE;
                                        http_response_code(404);
                                        $apiMessage         = 'Please Upload Document in PDF Format !!!';
                                        $apiExtraField      = 'response_code';
                                        $apiExtraData       = http_response_code();
                                    }
                                } else {
                                    $pan_docs = $getUser->contact_person_document;
                                }
                            /* pan card/company ID */
                            /* cancelled cheque */
                                if(!empty($cancelled_cheque)){
                                    $cancelled_cheque    = $cancelled_cheque[0];
                                    $upload_type        = $cancelled_cheque['type'];
                                    if($upload_type == 'application/pdf'){
                                        $upload_base64      = $cancelled_cheque['base64'];
                                        $img                = $upload_base64;
                                        // $img            = $upload_file['base64'];
                                        // $img            = str_replace('data:application/pdf;base64,', '', $upload_file);
                                        // $img            = str_replace(' ', '+', $img);
                                        $data           = base64_decode($img);
                                        $fileName       = uniqid() . '.pdf';
                                        $file           = 'public/uploads/user/' . $fileName;
                                        $success        = file_put_contents($file, $data);
                                        $cheque_docs    = $fileName;
                                    } else {
                                        $apiStatus          = FALSE;
                                        http_response_code(404);
                                        $apiMessage         = 'Please Upload Document in PDF Format !!!';
                                        $apiExtraField      = 'response_code';
                                        $apiExtraData       = http_response_code();
                                    }
                                } else {
                                    $cheque_docs = $getUser->cancelled_cheque;
                                }
                            /* cancelled cheque */
                            $fields = [
                                'gst_no'                            => $gst_no,
                                'company_name'                      => $company_name,
                                'full_address'                      => $full_address,
                                'holding_no'                        => $holding_no,
                                'street'                            => $street,
                                'district'                          => $district,
                                'state'                             => $state,
                                'pincode'                           => $pincode,
                                'location'                          => $location,
                                'phone'                             => $phone,
                                // 'email'                          => $email,
                                'gst_certificate'                   => $gst_docs,
                                'contact_person_name'               => $contact_person_name,
                                'contact_person_designation'        => $contact_person_designation,
                                'contact_person_document'           => $pan_docs,
                                'bank_name'                         => $bank_name,
                                'branch_name'                       => $branch_name,
                                'ifsc_code'                         => $ifsc_code,
                                'account_type'                      => $account_type,
                                'account_number'                    => $account_number,
                                'cancelled_cheque'                  => $cheque_docs,
                            ];
                            // pr($fields);
                            $this->common_model->save_data('ecomm_users', $fields, $uId, 'id');
                            $apiStatus          = TRUE;
                            http_response_code(200);
                            $apiMessage         = 'Profle Updated Successfully !!!';
                            $apiExtraField      = 'response_code';
                            $apiExtraData       = http_response_code();
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function sendEmailOTP()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId, 'status' => 1]);
                    if($getUser){
                        
                        $remember_token = rand(100000,999999);
                        $postData = [
                            'remember_token'        => $remember_token
                        ];
                        $this->common_model->save_data('ecomm_users', ['remember_token' => $remember_token], $getUser->id, 'id');

                        $mailData                   = [
                            'id'    => $getUser->id,
                            'email' => $getUser->email,
                            'otp'   => $remember_token,
                        ];
                        $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                        $subject                    = $generalSetting->site_name.' :: Email Verify OTP';
                        $message                    = view('email-templates/otp',$mailData);
                        // echo $message;die;
                        // $this->sendMail($getUser->email, $subject, $message);

                        /* email log save */
                            $postData2 = [
                                'name'                  => $getUser->company_name,
                                'email'                 => $getUser->email,
                                'subject'               => $subject,
                                'message'               => $message
                            ];
                            $this->common_model->save_data('email_logs', $postData2, '', 'id');
                        /* email log save */

                        $apiResponse                        = $mailData;

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function verifyEmail()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['otp'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId, 'status' => 1]);
                    if($getUser){
                        $remember_token  = $getUser->remember_token;
                        if($remember_token == $requestData['otp']){
                            $this->common_model->save_data('ecomm_users', ['remember_token' => '', 'email_verify' => 1, 'email_verified_at' => date('Y-m-d H:i:s')], $getUser->id, 'id');
                            $apiResponse        = [
                                'id'    => $getUser->id,
                                'email' => $getUser->email
                            ];
                            $apiStatus                          = TRUE;
                            http_response_code(200);
                            $apiMessage                         = 'Email Verified Successfully !!!';
                            $apiExtraField                      = 'response_code';
                            $apiExtraData                       = http_response_code();
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(404);
                            $apiMessage         = 'OTP Mismatched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function sendMobileOTP()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId, 'status' => 1]);
                    if($getUser){
                        $mobile_otp = rand(100000,999999);
                        $postData = [
                            'mobile_otp'        => $mobile_otp
                        ];
                        $this->common_model->save_data('ecomm_users', ['mobile_otp' => $mobile_otp], $getUser->id, 'id');
                        /* send sms */
                            $memberType             = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $checkUser->member_type], 'name');
                            $message = "Dear ".(($memberType)?$memberType->name:'ECOEX').", ".$mobile_otp." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
                            $mobileNo = (($getUser)?$getUser->phone:'');
                            $this->sendSMS($mobileNo,$message);
                        /* send sms */
                        $mailData                   = [
                            'id'    => $getUser->id,
                            'email' => $getUser->email,
                            'phone' => $getUser->phone,
                            'otp'   => $mobile_otp,
                        ];
                        $apiResponse                        = $mailData;
                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function verifyMobile()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['otp'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId, 'status' => 1]);
                    if($getUser){
                        $mobile_otp  = $getUser->mobile_otp;
                        if($mobile_otp == $requestData['otp']){
                            $this->common_model->save_data('ecomm_users', ['mobile_otp' => '', 'phone_verify' => 1, 'phone_verified_at' => date('Y-m-d H:i:s')], $getUser->id, 'id');
                            $apiResponse        = [
                                'id'    => $getUser->id,
                                'email' => $getUser->email,
                                'phone' => $getUser->phone,
                            ];
                            $apiStatus                          = TRUE;
                            http_response_code(200);
                            $apiMessage                         = 'Mobile Verified Successfully !!!';
                            $apiExtraField                      = 'response_code';
                            $apiExtraData                       = http_response_code();
                        } else {
                            $apiStatus          = FALSE;
                            http_response_code(404);
                            $apiMessage         = 'OTP Mismatched !!!';
                            $apiExtraField      = 'response_code';
                        }
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }

        public function dashboard()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId]);
                    if($getUser){
                        $memberType         = $this->common_model->find_data('ecomm_member_types', 'row', ['id' => $getUser->member_type], 'name');
                        $step0_count        = $this->common_model->find_data('ecomm_enquires', 'count', ['plant_id' => $uId]);
                        $step1_count        = $this->common_model->find_data('ecomm_enquires', 'count', ['plant_id' => $uId, 'status' => 1]);
                        $step2_count        = $this->common_model->find_data('ecomm_enquires', 'count', ['plant_id' => $uId, 'status>=' => 2, 'status<=' => 7]);
                        $step3_count        = $this->common_model->find_data('ecomm_enquires', 'count', ['plant_id' => $uId, 'status' => 9]);
                        $step4_count        = $this->common_model->find_data('ecomm_enquires', 'count', ['plant_id' => $uId, 'status' => 8]);
                        $apiResponse        = [
                            'plant_id'          => $getUser->id,
                            'gst_no'            => $getUser->gst_no,
                            'company_name'      => $getUser->company_name,
                            'full_address'      => $getUser->full_address,
                            'holding_no'        => $getUser->holding_no,
                            'street'            => $getUser->street,
                            'district'          => $getUser->district,
                            'state'             => $getUser->state,
                            'pincode'           => $getUser->pincode,
                            'location'          => $getUser->location,
                            'email'             => $getUser->email,
                            'step0_label'       => 'Total',
                            'step1_label'       => 'Add Request',
                            'step2_label'       => 'In Process Request',
                            'step3_label'       => 'Rejected Request',
                            'step4_label'       => 'Close Request',
                            'step0_count'       => $step0_count,
                            'step1_count'       => $step1_count,
                            'step2_count'       => $step2_count,
                            'step3_count'       => $step3_count,
                            'step4_count'       => $step4_count,
                            'step1_percent'     => (($step0_count > 0)?(($step1_count / $step0_count) * 100):0),
                            'step2_percent'     => (($step0_count > 0)?(($step2_count / $step0_count) * 100):0),
                            'step3_percent'     => (($step0_count > 0)?(($step3_count / $step0_count) * 100):0),
                            'step4_percent'     => (($step0_count > 0)?(($step4_count / $step0_count) * 100):0),
                        ];

                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getProduct()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId]);
                    if($getUser){
                        $assignCategory = $this->common_model->find_data('ecomm_company_category', 'array', ['company_id' => $getUser->parent_id], 'category_id');
                        // pr($assignCategory);
                        if($assignCategory){
                            foreach($assignCategory as $assignCat){
                                $orderBy[0]     = ['field' => 'name', 'type' => 'ASC'];
                                $products       = $this->common_model->find_data('ecomm_products', 'array', ['status' => 1, 'category_id' => $assignCat->category_id], 'id,name,hsn_code', '', '', $orderBy);
                                if($products){
                                    foreach($products as $product){
                                        $apiResponse[]        = [
                                            'id'            => $product->id,
                                            'name'          => $product->name,
                                            'hsn_code'      => $product->hsn_code,
                                        ];
                                    }
                                }
                            }
                        }
                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
        public function getHSNCodeProduct()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));        
            $requiredFields     = ['product_id'];
            $headerData         = $this->request->headers();
            if (!$this->validateArray($requiredFields, $requestData)){              
                $apiStatus          = FALSE;
                $apiMessage         = 'All Data Are Not Present !!!';
            }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                $product_id                 = $requestData['product_id'];
                // pr($getTokenValue);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId]);
                    if($getUser){
                        $product       = $this->common_model->find_data('ecomm_products', 'row', ['status' => 1, 'id' => $product_id], 'id,name,hsn_code');
                        if($product){
                            $apiResponse        = [
                                'id'            => $product->id,
                                'name'          => $product->name,
                                'hsn_code'      => $product->hsn_code,
                            ];
                        }
                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
    /* after login */
    
    // process request
        public function processRequestList()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $headerData         = $this->request->headers();
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $Authorization              = $headerData['Authorization'];
                $app_access_token           = $this->extractToken($Authorization);
                $getTokenValue              = $this->tokenAuth($app_access_token);
                if($getTokenValue['status']){
                    $uId        = $getTokenValue['data'][1];
                    $expiry     = date('d/m/Y H:i:s', $getTokenValue['data'][4]);
                    $getUser    = $this->common_model->find_data('ecomm_users', 'row', ['id' => $uId]);
                    if($getUser){
                        $rows               = $this->common_model->find_data('ecomm_enquires', 'array', ['plant_id' => $uId]);
                        if($rows){
                            foreach($rows as $row){
                                $apiResponse[] = [
                                    'enq_id'        => $row->id,
                                    'enquiry_no'    => $row->enquiry_no,
                                    'status'        => $row->status,
                                    'created_at'    => date_format(date_create($row->created_at), "M d, Y h:i A"),
                                    'updated_at'    => date_format(date_create($row->updated_at), "M d, Y h:i A"),
                                ];
                            }
                        }
                        $apiStatus          = TRUE;
                        http_response_code(200);
                        $apiMessage         = 'Data Available !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    } else {
                        $apiStatus          = FALSE;
                        http_response_code(404);
                        $apiMessage         = 'User Not Found !!!';
                        $apiExtraField      = 'response_code';
                        $apiExtraData       = http_response_code();
                    }
                } else {
                    http_response_code($getTokenValue['data'][2]);
                    $apiStatus                      = FALSE;
                    $apiMessage                     = $this->getResponseCode(http_response_code());
                    $apiExtraField                  = 'response_code';
                    $apiExtraData                   = http_response_code();
                }               
            } else {
                http_response_code(400);
                $apiStatus          = FALSE;
                $apiMessage         = $this->getResponseCode(http_response_code());
                $apiExtraField      = 'response_code';
                $apiExtraData       = http_response_code();
            }
            $this->response_to_json($apiStatus, $apiMessage, $apiResponse);
        }
    // process request
    /*
    Get http response code
    Author : Subhomoy
    */
    private function getResponseCode($code = NULL){
        if ($code !== NULL) {
            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Unauthenticated Request !!!'; break;
                case 401: $text = 'Token Not Found !!!'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Token Has Expired !!!'; break;
                case 404: $text = 'User Not Found !!!'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'All Data Are Not Present !!!'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            header($protocol . ' ' . $code . ' ' . $text);
            $GLOBALS['http_response_code'] = $code;
        } else {
            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
            $text = '';
        }
        return $text;
    }
    /* extract header token */
    private function extractToken($token){
        $app_token = explode("Authorization: ", $token);
        $app_access_token = $app_token[1];
        return $app_access_token;
    }
    /* extract header token */
    /*
    Generate JWT tokens for authentication
    Author : Subhomoy
    */
    private static function generateToken($userId, $email, $phone){
        $token      = array(
            'id'                => $userId,
            'email'             => $email,
            'phone'             => $phone,
            'exp'               => time() + (30 * 24 * 60 * 60) // 30 days
        );
        // pr($token);
        return JWT::encode($token, TOKEN_SECRET, 'HS256');
    }
    /*
    Check Authentication
    Author : Subhomoy
    */
    private function tokenAuth($appAccessToken){
        $this->db   = \Config\Database::connect();
        $headers    = apache_request_headers();
        if (isset($appAccessToken) && !empty($appAccessToken)) :
            $userdata = $this->matchToken($appAccessToken);
            // echo $appAccessToken;
            if ($userdata['status']) :
                $checkToken =  $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $appAccessToken]);
                // echo $this->db->getLastQuery();
                // pr($checkToken);
                if (!empty($checkToken)) :
                    if ($userdata['data']->exp && $userdata['data']->exp > time()) :
                        $tokenStatus = array(TRUE, $userdata['data']->id, $userdata['data']->email, $userdata['data']->phone, $userdata['data']->exp);
                    else :
                        $tokenStatus = array(FALSE, 'Token Has Expired 1 !!!');
                    endif;
                else :
                    $tokenStatus = array(FALSE, 'Token Has Expired 2 !!!');
                endif;
            else :
                $tokenStatus = array(FALSE, 'Token Not Found !!!');
            endif;
        else :
            $tokenStatus = array(FALSE, 'Token Not Found In Request !!!');
        endif;
        if ($tokenStatus[0]) :
            $this->userId           = $tokenStatus[1];
            $this->userEmail        = $tokenStatus[2];
            $this->userMobile       = $tokenStatus[3];
            $this->userExpiry       = $tokenStatus[4];
            // pr($tokenStatus);
            return array('status' => TRUE, 'data' => $tokenStatus);
        else :
            return array('status' => FALSE, 'data' => $tokenStatus[1]);
            // $this->response_to_json(FALSE, $tokenStatus[1]);
        endif;
    }
    /*
    Match JWT token with user token saved in database
    Author : Subhomoy
    */
    private static function matchToken($token){
        // try{
        //     // $decoded    = JWT::decode($token, TOKEN_SECRET, 'HS256');
        //     $decoded    = JWT::decode($token, new Key(TOKEN_SECRET, 'HS256'));
        //     // pr($decoded);
        // } catch (\Exception $e) {
        //     //echo 'Caught exception: ',  $e->getMessage(), "\n";
        //     return array('status' => FALSE, 'data' => '');
        // }
        
        // return array('status' => TRUE, 'data' => $decoded);

        try{
            $key = "1234567890qwertyuiopmnbvcxzasdfghjkl";
            $decoded = JWT::decode($token, $key, array('HS256'));
            // $decodedData = (array) $decoded;
        } catch (\Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            return array('status' => FALSE, 'data' => '');
        }
        return array('status' => TRUE, 'data' => $decoded);
    }
}
