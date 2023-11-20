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
            // $this->isJSON(file_get_contents('php://input'));
            // $requestData        = $this->extract_json(file_get_contents('php://input'));        
            // $requiredFields     = [];
            $headerData            = $this->request->headers();
            // if (!$this->validateArray($requiredFields, $requestData)){              
            //     http_response_code(406);
            //     $apiStatus          = FALSE;
            //     $apiMessage         = $this->getResponseCode(http_response_code());
            //     $apiExtraField      = 'response_code';
            //     $apiExtraData       = http_response_code();
            // }
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
            // $this->isJSON(file_get_contents('php://input'));
            // $requestData        = $this->extract_json(file_get_contents('php://input'));        
            // $requiredFields     = [];
            $headerData            = $this->request->headers();
            // if (!$this->validateArray($requiredFields, $requestData)){              
            //     http_response_code(406);
            //     $apiStatus          = FALSE;
            //     $apiMessage         = $this->getResponseCode(http_response_code());
            //     $apiExtraField      = 'response_code';
            //     $apiExtraData       = http_response_code();
            // }
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
            // $this->isJSON(file_get_contents('php://input'));
            // $requestData        = $this->extract_json(file_get_contents('php://input'));        
            // $requiredFields     = [];
            $headerData            = $this->request->headers();
            // if (!$this->validateArray($requiredFields, $requestData)){              
            //     http_response_code(406);
            //     $apiStatus          = FALSE;
            //     $apiMessage         = $this->getResponseCode(http_response_code());
            //     $apiExtraField      = 'response_code';
            //     $apiExtraData       = http_response_code();
            // }
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
        public function signup()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            $apiExtraField      = '';
            $apiExtraData       = '';
            $this->isJSON(file_get_contents('php://input'));
            $requestData        = $this->extract_json(file_get_contents('php://input'));
            $requiredFields     = ['gst_no', 'company_name', 'full_address', 'district', 'state', 'pincode', 'location', 'email', 'phone', 'password', 'confirm_password', 'product_category', 'member_type'];
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
                            $remember_token = rand(1000,9999);
                            $postData = [
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
                                'product_category'          => $requestData['product_category'],
                                'member_type'               => $requestData['member_type'],
                                'status'                    => 0,
                            ];
                            // pr($postData);
                            $id = $this->common_model->save_data('ecomm_users', $postData, '', 'id');
                            
                            /* email sent */
                                $generalSetting             = $this->common_model->find_data('general_settings', 'row');
                                $subject                    = $generalSetting->site_name.' :: Signup Complete';
                                $message                    = view('email-templates/signup',$postData);
                                // echo $message;die;
                                $this->sendMail($requestData['email'], $subject, $message);
                            /* email sent */
                            /* email log save */
                                $postData2 = [
                                    'name'                  => $requestData['company_name'],
                                    'email'                 => $requestData['email'],
                                    'subject'               => $subject,
                                    'message'               => $message
                                ];
                                $this->common_model->save_data('email_logs', $postData2, '', 'id');
                            /* email log save */
                            
                            $apiStatus          = TRUE;
                            http_response_code(200);
                            $apiMessage         = 'Signup Successfully. Get Notify After Admin Approval !!!';
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
                        // $this->sendMail('subhomoysamanta1989@gmail.com', $requestData['subject'], $requestData['message']);
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
                $checkUser                  = $this->common_model->find_data('ecomm_users', 'row', ['email' => $email, 'status' => 1]);
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
                        $checkUserTokenExist                  = $this->common_model->find_data('ecomm_user_devices', 'row', ['user_id' => $user_id, 'published' => 1, 'device_type' => $device_type, 'device_token' => $device_token]);
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
        public function signout()
        {
            $apiStatus          = TRUE;
            $apiMessage         = '';
            $apiResponse        = [];
            // $this->isJSON(file_get_contents('php://input'));
            // $requestData        = $this->extract_json(file_get_contents('php://input'));        
            // $requiredFields     = [];
            $headerData         = $this->request->headers();
            // if (!$this->validateArray($requiredFields, $requestData)){              
            //     $apiStatus          = FALSE;
            //     $apiMessage         = 'All Data Are Not Present !!!';
            // }           
            if($headerData['Key'] == 'Key: '.getenv('app.PROJECTKEY')){
                $app_access_token           = trim($headerData['Authorization'], "Authorization: ");
                $checkUserTokenExist        = $this->common_model->find_data('ecomm_user_devices', 'row', ['app_access_token' => $app_access_token, 'published' => 1]);
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
                        // pr($userActivityData);
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
    /* authentication */
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
        $headers = apache_request_headers();
        if (isset($appAccessToken) && !empty($appAccessToken)) :
            $userdata = $this->matchToken($appAccessToken);
            // pr($userdata);
            if ($userdata['status']) :
                $checkToken =  UserDevice::where('user_id', '=', $userdata['data']->id)->where('app_access_token', '=', $appAccessToken)->first();
                // echo $this->db->last_query();
                // pr($userdata);
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
