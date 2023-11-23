<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class User extends BaseController {
	public function __construct()
    {
        
    }
    /* authentication */
        public function login() 
        { 
            if($this->request->getMethod() == 'post') {
                $input = $this->validate([
                    'username' => 'required',
                    'password' => 'required|min_length[6]'
                ]);
                if($input == true) {
                    $conditions = array(
                        'username'  => $this->request->getPost('username')
                        );
                    $checkEmail = $this->common_model->find_data('ecoex_admin_user', 'row', $conditions);
                    if($checkEmail) {
                        $user_type = $checkEmail->user_type;
                        $user_name = $checkEmail->name;
                        $user_role = $checkEmail->role_id;

                        if($checkEmail->status){
                            if($checkEmail->password == md5($this->request->getPost('password'))){
                                $session_data = array(
                                                    'user_id'           => $checkEmail->id,
                                                    'user_type'         => $checkEmail->user_type,
                                                    'username'          => $checkEmail->username,
                                                    'name'              => $checkEmail->name,
                                                    'email'             => $checkEmail->email,
                                                    'is_admin_login'    => 1
                                                    );
                                $this->session->set($session_data);
                                if($this->session->get('is_admin_login') == 1)
                                {
                                    $fields = array(
                                        'ip_address'        => $this->request->getIPAddress(),
                                        'last_login'        => date('d-m-Y h:i:s a'),
                                        'last_browser_used' => $this->request->getUserAgent()
                                    );
                                    $user_id = $checkEmail->id;
                                    $this->common_model->save_data('ecoex_admin_user',$fields,$user_id,'id');

                                    $userActivityData = [
                                        'user_email'        => $this->request->getPost('email'),
                                        'user_name'         => $user_name,
                                        'activity_type'     => 1,
                                        'user_type'         => 'MA',
                                        'ip_address'        => $this->request->getIPAddress(),
                                        'activity_details'  => 'Admin Sign In Success',
                                    ];
                                    $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                                    $this->session->setFlashdata('success_message', 'SignIn Success! Redirecting to dashboard !!!');
                                    return redirect()->to('/admin/dashboard');
                                }
                            } else {
                                $userActivityData = [
                                    'user_email'        => $this->request->getPost('email'),
                                    'user_name'         => $user_name,
                                    'user_type'         => 'MA',
                                    'ip_address'        => $this->request->getIPAddress(),
                                    'activity_type'     => 0,
                                    'activity_details'  => 'Invalid Password',
                                ];
                                $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                                $this->session->setFlashdata('error_message','Invalid Password !!!');
                                return redirect()->to(base_url("admin"));
                            }
                        } else {
                            $userActivityData = [
                                'user_email'        => $this->request->getPost('email'),
                                'user_name'         => $user_name,
                                'user_type'         => 'MA',
                                'ip_address'        => $this->request->getIPAddress(),
                                'activity_type'     => 0,
                                'activity_details'  => 'Account Deactivated',
                            ];
                            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                            $this->session->setFlashdata('error_message','Account Deactivated !!!');
                            return redirect()->to(base_url("admin"));
                        }
                    } else {
                        $userActivityData = [
                            'user_email'        => '',
                            'user_name'         => '',
                            'user_type'         => 'MA',
                            'ip_address'        => $this->request->getIPAddress(),
                            'activity_type'     => 0,
                            'activity_details'  => 'We Don\'t Recognize Your Email Address',
                        ];
                        $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
                        // $this->db                 = \Config\Database::connect();
                        // echo $this->db->getLastQuery();
                        // pr($userActivityData);
                        $this->session->setFlashdata('error_message','We Don\'t Recognize Your Email Address !!!');
                        return redirect()->to(base_url("admin"));
                    }                
                    
                } else {
                    $data['validation'] = $this->validator;
                }
            }
            
            $title      = 'Sign In';
            $page_name  = 'signin';
            $data       = [];
            echo $this->layout_before_login($title,$page_name,$data);
        }
        public function signout()
        {
            /* user activity */
            $userActivityData = [
                'user_email'        => $this->session->username,
                'user_name'         => 'Master Admin',
                'user_type'         => 'MA',
                'ip_address'        => $this->request->getIPAddress(),
                'activity_type'     => 2,
                'activity_details'  => 'Admin Sign Out Successfully',
            ];
            // pr($userActivityData);
            $this->common_model->save_data('user_activities', $userActivityData, '','activity_id');
            /* user activity */
            $this->session->destroy();
            $this->session->setFlashdata('success_message', 'Sign Out Successfully !!!');
            return redirect()->to('/admin');
        }
    /* authentication */
    /* forgot password */
        public function forgotPassword(){
            $title      = 'Forgot Password';
            $page_name  = 'forgot-password';
            $data       = [];
            if($this->request->getPost()){
                $email          = $this->request->getPost('username');
                $checkEmail     = $this->common_model->find_data('ecoex_admin_user', 'row', ['email' => $email, 'status' => 1]);
                if($checkEmail){
                    // otp mail send
                        $otp     =  rand(1000,9999);
                        $fields  =  ['otp' => $otp];
                        $this->common_model->save_data('ecoex_admin_user', $fields, $checkEmail->id, 'id');
                        $to         = $checkEmail->email;
                        $subject    = "Reset Password";
                        $message    = "Your Reset Password OTP is :" . $otp;
                        // echo $message;die;
                        // $this->common_model->sendEmail($email, $subject, $message);
                        $this->session->setFlashdata('success_message', 'OTP Successfully Sent On Registered Email !!!');
                        return redirect()->to(base_url('admin/verify-otp/'.encoded($checkEmail->id)));
                    // otp mail send
                } else {
                    $this->session->setFlashdata('error_message', 'Email Id Is Not Recognized !!!');
                    return redirect()->to(current_url());
                }
            }
            echo $this->layout_before_login($title,$page_name,$data);
        }
        public function verifyOtp($id){
            $id         = decoded($id);
            $title      = 'Verify OTP';
            $page_name  = 'verify-otp';
            $data       = [];
            if($this->request->getPost()){
                $otp            = $this->request->getPost('otp');
                $checkEmail     = $this->common_model->find_data('ecoex_admin_user', 'row', ['id' => $id, 'status' => 1]);
                if($checkEmail){
                    if($checkEmail->otp == $otp){
                        $this->common_model->save_data('ecoex_admin_user', ['otp' => 0], $id, 'id');
                        $this->session->setFlashdata('success_message', 'OTP Validated Successfully !!!');
                        return redirect()->to(base_url('admin/reset-password/'.encoded($id)));
                    } else {
                        $this->session->setFlashdata('error_message', 'Invalid OTP !!!');
                        return redirect()->to(current_url());
                    }                    
                } else {
                    $this->session->setFlashdata('error_message', 'User Not Found !!!');
                    return redirect()->to(current_url());
                }
            }
            echo $this->layout_before_login($title,$page_name,$data);
        }
        public function resetPassword($id){
            $id         = decoded($id);
            $title      = 'Reset Password';
            $page_name  = 'reset-password';
            $data       = [];
            if($this->request->getPost()){
                $password               = $this->request->getPost('password');
                $confirm_password       = $this->request->getPost('confirm_password');
                $checkEmail             = $this->common_model->find_data('ecoex_admin_user', 'row', ['id' => $id, 'status' => 1]);
                if($checkEmail){
                    if($password == $confirm_password){
                        $this->common_model->save_data('ecoex_admin_user', ['password' => md5($password), 'original_password' => $password, 'otp' => 0], $id, 'id');

                        $this->session->setFlashdata('success_message', 'Password Reset Successfully !!!');
                        return redirect()->to(base_url('admin'));
                    } else {
                        $this->session->setFlashdata('error_message', 'Password & Confirm Password Does Not Matched !!!');
                        return redirect()->to(current_url());
                    }                    
                } else {
                    $this->session->setFlashdata('error_message', 'User Not Found !!!');
                    return redirect()->to(current_url());
                }
            }
            echo $this->layout_before_login($title,$page_name,$data);
        }
    /* forgot password */
    /* dashboard */
        public function dashboard() 
        {
            // pr($this->session->get());
            if(!$this->session->get('is_admin_login')) {
                return redirect()->to('/admin');
            }
            $title      = 'Dashboard';
            $page_name  = 'dashboard';
            $data       = [];
            echo $this->layout_after_login($title,$page_name,$data);
        }
    /* dashboard */
    /* settings */
        public function settings()
        {
            if(!$this->session->get('is_admin_login')) {
                return redirect()->to('/admin');
            }
            $title                  = 'Settings';
            $page_name              = 'settings';
            $user_id                = $this->session->get('user_id');
            $data['admin']          = $this->common_model->find_data('ecoex_admin_user', 'row', ['id' => $user_id]);
            $data['setting']        = $this->common_model->find_data('general_settings', 'row', ['id' => 1]);
            echo $this->layout_after_login($title,$page_name,$data);
        }
        public function profileSetting()
        {
            $user_id                = $this->session->get('user_id');
            /* profile image */
                $file = $this->request->getFile('image');
                $originalName = $file->getClientName();
                $fieldName = 'image';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'','image');
                    if($upload_array['status']) {
                        $profile_image = $upload_array['newFilename'];
                    } else {
                        $this->session->setFlashdata('error_message', $upload_array['message']);
                        return redirect()->to('/admin/settings');
                    }
                } else {
                    $site_setting = $this->common_model->find_data('ecoex_admin_user','row');
                    $profile_image = $site_setting->profile_image;
                }
            /* profile image */
            $fields = [
                'name'              => $this->request->getPost('name'),
                'email'             => $this->request->getPost('email'),
                'username'          => $this->request->getPost('email'),
                'mobileNo'          => $this->request->getPost('mobile'),
                'profile_image'     => $profile_image,
            ];
            $this->common_model->save_data('ecoex_admin_user', $fields, $user_id, 'id');
            $this->session->setFlashdata('success_message', 'Profile Settings Updated Successfully !!!');
            return redirect()->to('/admin/settings');
        }
        public function generalSetting()
        {
            $user_id                = $this->session->get('user_id');
            /* logo */
                $file = $this->request->getFile('site_logo');
                $originalName = $file->getClientName();
                $fieldName = 'site_logo';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'','image');
                    if($upload_array['status']) {
                        $site_logo = $upload_array['newFilename'];
                    } else {
                        $this->session->setFlashdata('error_message', $upload_array['message']);
                        return redirect()->to('/admin/settings');
                    }
                } else {
                    $site_setting   = $this->common_model->find_data('general_settings','row');
                    $site_logo      = $site_setting->site_logo;
                }
            /* logo */
            /* footer logo */
                $file = $this->request->getFile('site_footer_logo');
                $originalName = $file->getClientName();
                $fieldName = 'site_footer_logo';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'','image');
                    if($upload_array['status']) {
                        $site_footer_logo = $upload_array['newFilename'];
                    } else {
                        $this->session->setFlashdata('error_message', $upload_array['message']);
                        return redirect()->to('/admin/settings');
                    }
                } else {
                    $site_setting           = $this->common_model->find_data('general_settings','row');
                    $site_footer_logo       = $site_setting->site_footer_logo;
                }
            /* footer logo */
            /* favicon */
                $file = $this->request->getFile('site_favicon');
                $originalName = $file->getClientName();
                $fieldName = 'site_favicon';
                if($file!='') {
                    $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'','image');
                    if($upload_array['status']) {
                        $site_favicon = $upload_array['newFilename'];
                    } else {
                        $this->session->setFlashdata('error_message', $upload_array['message']);
                        return redirect()->to('/admin/settings');
                    }
                } else {
                    $site_setting           = $this->common_model->find_data('general_settings','row');
                    $site_favicon       = $site_setting->site_favicon;
                }
            /* favicon */
            $fields = [
                'site_name'                     => $this->request->getPost('site_name'),
                'site_phone'                    => $this->request->getPost('site_phone'),
                'site_mail'                     => $this->request->getPost('site_mail'),
                'system_email'                  => $this->request->getPost('system_email'),
                'site_url'                      => $this->request->getPost('site_url'),
                'description'                   => $this->request->getPost('description'),
                'copyright_statement'           => $this->request->getPost('copyright_statement'),
                'google_map_api_code'           => $this->request->getPost('google_map_api_code'),
                'google_analytics_code'         => $this->request->getPost('google_analytics_code'),
                'google_pixel_code'             => $this->request->getPost('google_pixel_code'),
                'facebook_tracking_code'        => $this->request->getPost('facebook_tracking_code'),
                'theme_color'                   => $this->request->getPost('theme_color'),
                'font_color'                    => $this->request->getPost('font_color'),
                'twitter_profile'               => $this->request->getPost('twitter_profile'),
                'facebook_profile'              => $this->request->getPost('facebook_profile'),
                'instagram_profile'             => $this->request->getPost('instagram_profile'),
                'linkedin_profile'              => $this->request->getPost('linkedin_profile'),
                'youtube_profile'               => $this->request->getPost('youtube_profile'),
                'site_logo'                     => $site_logo,
                'site_footer_logo'              => $site_footer_logo,
                'site_favicon'                  => $site_favicon,
            ];
            $this->common_model->save_data('general_settings', $fields, 1, 'id');
            $this->session->setFlashdata('success_message', 'General Settings Updated Successfully !!!');
            return redirect()->to('/admin/settings');
        }
        public function changePassword()
        {
            $user_id                = $this->session->get('user_id');
            $profile                = $this->common_model->find_data('ecoex_admin_user', 'row', ['id' => $user_id]);
            $old_password           = $this->request->getPost('old_password');
            $new_password           = $this->request->getPost('new_password');
            $confirm_password       = $this->request->getPost('confirm_password');
            if($new_password == $confirm_password){
                if(md5($old_password) == $profile->password){
                    if($profile->password != md5($new_password)){
                        $fields = [
                            'password'                      => md5($this->request->getPost('new_password')),
                            'original_password'             => $this->request->getPost('new_password'),
                        ];
                        $this->common_model->save_data('ecoex_admin_user', $fields, $user_id, 'id');
                        $this->session->setFlashdata('success_message', 'Password Updated Successfully !!!');
                        return redirect()->to('/admin/settings');
                    } else {
                        $this->session->setFlashdata('error_message', 'New & Old Password Should Not Be Same !!!');
                        return redirect()->to('/admin/settings');
                    }
                } else {
                    $this->session->setFlashdata('error_message', 'Old Password Mismatched !!!');
                    return redirect()->to('/admin/settings');
                }
            } else {
                $this->session->setFlashdata('error_message', 'New & Confirm Password Mismatched !!!');
                return redirect()->to('/admin/settings');
            }
        }
        public function emailSetting()
        {
            $user_id                = $this->session->get('user_id');
            $fields = [
                'from_email'                => $this->request->getPost('from_email'),
                'from_name'                 => $this->request->getPost('from_name'),
                'smtp_host'                 => $this->request->getPost('smtp_host'),
                'smtp_username'             => $this->request->getPost('smtp_username'),
                'smtp_password'             => $this->request->getPost('smtp_password'),
                'smtp_port'                 => $this->request->getPost('smtp_port'),
            ];
            $this->common_model->save_data('general_settings', $fields, 1, 'id');
            $this->session->setFlashdata('success_message', 'Email Settings Updated Successfully !!!');
            return redirect()->to('/admin/settings');
        }
        public function smsSetting()
        {
            $user_id                = $this->session->get('user_id');
            $fields = [
                'sms_authentication_key'        => $this->request->getPost('sms_authentication_key'),
                'sms_sender_id'                 => $this->request->getPost('sms_sender_id'),
                'sms_base_url'                  => $this->request->getPost('sms_base_url'),
            ];
            $this->common_model->save_data('general_settings', $fields, 1, 'id');
            $this->session->setFlashdata('success_message', 'SMS Settings Updated Successfully !!!');
            return redirect()->to('/admin/settings');
        }
        public function footerSetting()
        {
            $user_id                = $this->session->get('user_id');
            // pr($this->request->getPost());
            $footer_text            = $this->request->getPost('footer_text');
            $footer_link_name       = $this->request->getPost('footer_link_name');
            $footer_link            = $this->request->getPost('footer_link');
            $footer_link_name2      = $this->request->getPost('footer_link_name2');
            $footer_link2           = $this->request->getPost('footer_link2');
            $footer_link_name3      = $this->request->getPost('footer_link_name3');
            $footer_link3           = $this->request->getPost('footer_link3');
            $fields = [
                'footer_text'                       => $footer_text,
                'footer_link_name'                  => json_encode(array_filter($footer_link_name)),
                'footer_link'                       => json_encode(array_filter($footer_link)),
                'footer_link_name2'                 => json_encode(array_filter($footer_link_name2)),
                'footer_link2'                      => json_encode(array_filter($footer_link2)),
                'footer_link_name3'                 => json_encode(array_filter($footer_link_name3)),
                'footer_link3'                      => json_encode(array_filter($footer_link3)),
            ];
            // pr($fields);
            $this->common_model->save_data('general_settings', $fields, 1, 'id');
            $this->session->setFlashdata('success_message', 'Footer Settings Updated Successfully !!!');
            return redirect()->to('/admin/settings');
        }
        public function seoSetting() 
        {
            $user_id                = $this->session->get('user_id');
            $fields = [
                'meta_title'                        => $this->request->getPost('meta_title'),
                'meta_description'                  => $this->request->getPost('meta_description'),
                'meta_keywords'                     => $this->request->getPost('meta_keywords'),
            ];
            $this->common_model->save_data('general_settings', $fields, 1, 'id');
            $this->session->setFlashdata('success_message', 'SEO Settings Updated Successfully !!!');
            return redirect()->to('/admin/settings');
        }
        public function paymentSetting()
        {
            $user_id                = $this->session->get('user_id');
            $fields = [
                'stripe_payment_type'               => $this->request->getPost('stripe_payment_type'),
                'stripe_sandbox_sk'                 => $this->request->getPost('stripe_sandbox_sk'),
                'stripe_sandbox_pk'                 => $this->request->getPost('stripe_sandbox_pk'),
                'stripe_live_sk'                    => $this->request->getPost('stripe_live_sk'),
                'stripe_live_pk'                    => $this->request->getPost('stripe_live_pk'),
            ];
            $this->common_model->save_data('general_settings', $fields, 1, 'id');
            $this->session->setFlashdata('success_message', 'Payment Settings Updated Successfully !!!');
            return redirect()->to('/admin/settings');
        }
        public function bankSetting()
        {
            $user_id                = $this->session->get('user_id');
            $fields = [
                'bank_name'                     => $this->request->getPost('bank_name'),
                'branch_name'                   => $this->request->getPost('branch_name'),
                'acc_no'                        => $this->request->getPost('acc_no'),
                'ifsc_code'                     => $this->request->getPost('ifsc_code'),
            ];
            $this->common_model->save_data('general_settings', $fields, 1, 'id');
            $this->session->setFlashdata('success_message', 'Bank Settings Updated Successfully !!!');
            return redirect()->to('/admin/settings');
        }
    /* settings */
    /* email logs */
        public function emailLogs() 
        {
            if(!$this->session->get('is_admin_login')) {
                return redirect()->to('/admin');
            }
            $title              = 'Email Logs';
            $page_name          = 'email-logs';
            $order_by[0]        = array('field' => 'id', 'type' => 'desc');
            $data['rows']       = $this->common_model->find_data('email_logs', 'array', '', '', '', '', $order_by);
            echo $this->layout_after_login($title,$page_name,$data);
        }
        public function emailLogsDetails($id) 
        {
            if(!$this->session->get('is_admin_login')) {
                return redirect()->to('/admin');
            }
            $id                 = decoded($id);
            $title              = 'Email Logs Details';
            $page_name          = 'email-logs-details';
            $data['row']        = $this->common_model->find_data('email_logs', 'row', ['id' => $id]);
            echo $this->layout_after_login($title,$page_name,$data);
        }
    /* email logs */
    /* login logs */
        public function loginLogs() 
        {
            if(!$this->session->get('is_admin_login')) {
                return redirect()->to('/admin');
            }
            $title              = 'Login Logs';
            $page_name          = 'login-logs';
            $order_by[0]        = array('field' => 'activity_id', 'type' => 'desc');
            $data['rows1']       = $this->common_model->find_data('user_activities', 'array', ['user_type' => 'MA'], '', '', '', $order_by);
            $data['rows2']       = $this->common_model->find_data('user_activities', 'array', ['user_type' => 'PLANT'], '', '', '', $order_by);
            $data['rows3']       = $this->common_model->find_data('user_activities', 'array', ['user_type' => 'HO'], '', '', '', $order_by);
            $data['rows4']       = $this->common_model->find_data('user_activities', 'array', ['user_type' => 'VENDOR'], '', '', '', $order_by);
            echo $this->layout_after_login($title,$page_name,$data);
        }
    /* login logs */
}