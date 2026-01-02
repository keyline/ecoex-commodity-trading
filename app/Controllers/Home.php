<?php

namespace App\Controllers;

use App\Services\UpcomingCollections\UpcomingCollectionService;

class Home extends BaseController
{
    public function index()
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings', 'row');
        $data['title']              = $data['general_settings']->site_name;
        $data['page_header']        = $data['general_settings']->site_name;
        $data['page_content']       = $this->common_model->find_data('ecomm_pages', 'row', ['id' => 3]);

        return view('launch-page', $data);
    }
    // enquiry request for whatsapp share
    public function enquiryRequest($id)
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings', 'row');
        $id                         = decoded($id);
        $data['enquiry']            = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $id]);
        return view('enquiry-request-details', $data);
    }
    public function deleteAccountRequest()
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings', 'row');
        $data['title']              = $data['general_settings']->site_name;
        $data['page_header']        = $data['general_settings']->site_name;
        $data['page_content']       = $this->common_model->find_data('ecomm_pages', 'row', ['id' => 3]);

        if ($this->request->getMethod() == 'post') {
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
    public function getEmailOTP()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $requestData        = $this->request->getPost();
        $user_type          = $requestData['user_type'];
        $email              = $requestData['email'];
        if ($user_type == 'COMPANY') {
            $tableName = 'ecoex_companies';
        } else {
            $tableName = 'ecomm_users';
        }
        $getEntity          = $this->common_model->find_data($tableName, 'row', ['email' => $email]);
        if ($getEntity) {
            $remember_token = rand(100000, 999999);
            /* send email */
            $mailData                   = [
                'id'            => $getEntity->id,
                'email'         => $getEntity->email,
                'phone'         => $getEntity->phone,
                'otp'           => $remember_token,
            ];
            $generalSetting             = $this->common_model->find_data('general_settings', 'row');
            $subject                    = $generalSetting->site_name . ' :: Email Verify OTP For Signup';
            $message                    = view('email-templates/otp', $mailData);
            $this->sendMail($email, $subject, $message);

            $apiResponse        = [
                'email_otp'     => $remember_token,
                'entity_name'   => (($getEntity) ? $getEntity->company_name : ''),
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
    public function getPhoneOTP()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $requestData        = $this->request->getPost();
        $user_type          = $requestData['user_type'];
        $phone              = $requestData['phone'];
        if ($user_type == 'COMPANY') {
            $tableName = 'ecoex_companies';
        } else {
            $tableName = 'ecomm_users';
        }
        $getEntity          = $this->common_model->find_data($tableName, 'row', ['phone' => $phone]);
        if ($getEntity) {
            $mobile_otp = rand(100000, 999999);
            /* send sms */
            $message = "Dear " . $user_type . ", " . $mobile_otp . " is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";
            $mobileNo = $phone;
            $this->sendSMS($mobileNo, $message);

            $apiResponse        = [
                'phone_otp'     => $mobile_otp,
                'entity_name'   => (($getEntity) ? $getEntity->company_name : ''),
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
    public function enquiryCron()
    {
        $data['general_settings']           = $this->common_model->find_data('general_settings', 'row');
        $data['filter_keyword']             = 'yesterday';
        $data['f_date']                     = date('Y-m-d', strtotime("-1 days"));
        $data['t_date']                     = date('Y-m-d', strtotime("-1 days"));
        $data['filter_keyword_text']        = date('M d, Y l', strtotime("-1 days"));
        $yesterday                          = date('Y-m-d', strtotime("-1 days"));
        $data['request_submit_count']       = $this->common_model->find_data('ecomm_enquires', 'count', ['created_at LIKE' => '%' . $yesterday . '%']);
        $data['request_accept_count']       = $this->common_model->find_data('ecomm_enquires', 'count', ['accepted_date LIKE' => '%' . $yesterday . '%']);
        $data['request_complete_count']     = $this->common_model->find_data('ecomm_enquires', 'count', ['order_complete_date LIKE' => '%' . $yesterday . '%']);

        $html = view('enquiry-cron', $data);
        /* mail functionality */
        $subject                    = $data['general_settings']->site_name . ' :: Enquiry Report on ' . $data['filter_keyword_text'];
        $message                    = $html;
        $this->sendMail($data['general_settings']->site_mail, $subject, $message);
        /* mail functionality */
        /* email log save */
        $postData2 = [
            'name'                  => $data['general_settings']->site_name,
            'email'                 => $data['general_settings']->site_mail,
            'subject'               => $subject,
            'message'               => $message
        ];
        $this->common_model->save_data('email_logs', $postData2, '', 'id');
        /* email log save */
    }

    public function upcomingCollectionCron()
    {
        $upcomingCollection =  new UpcomingCollectionService();

        try {
            $upcomingCollection->sendReminderEmail();
        } catch (\Exception $e) {
            dd($e->getMessage());
            throw $e->getMessage();
        }
    }

    public function info()
    {
        phpinfo();
    }

    public function getAllEnquiry()
    {
        $data['general_settings']   = $this->common_model->find_data('general_settings', 'row');
        // $data['enqs']            = $this->common_model->find_data('ecomm_enquires', 'array', ['status<' => 14], 'id,company_id,enquiry_no,status');
        $db = \Config\Database::connect();

        $builder = $db->table('ecomm_enquires E');

        $builder->select([
            'E.enquiry_no',
            'E.status AS enquiry_status',
            'C.company_name',
            'COUNT(DISTINCT SE.id) AS sub_enquiry_count',
            "GROUP_CONCAT(DISTINCT SE.sub_enquiry_no ORDER BY SE.sub_enquiry_no SEPARATOR ', ') AS sub_enquiry_nos",
            'COUNT(DISTINCT EP.id) AS enquiry_products_count',
            "GROUP_CONCAT(
                DISTINCT IF(EP.new_product = 1, EP.new_product_name, CONCAT('PRODUCT-ID-', EP.product_id))
                ORDER BY EP.id
                SEPARATOR ', '
            ) AS enquiry_product_name_list"
        ]);

        $builder->join('ecoex_companies C', 'C.id = E.company_id', 'left');
        $builder->join('ecomm_sub_enquires SE', 'SE.enq_id = E.id', 'left');
        $builder->join('ecomm_enquiry_products EP', 'EP.enq_id = E.id', 'left');

        $builder->where('E.status', 12);
        $builder->groupBy('E.id');
        $builder->orderBy('E.id', 'ASC');

        $data['enqs'] = $builder->get()->getResult();
        return view('enquiry-list', $data);
    }

    




    public function getAnalytics()
    {
        $filter = $this->request->getGet('filter_keyword') ?? 'today';

        switch ($filter) 
        {
            case '':
            case 'all':
                // ALL TIME
                $from_date = '';
                $to_date   = '';
                break;

            case 'yesterday':
                $from_date = date('Y-m-d 00:00:00', strtotime('-1 day'));
                $to_date   = date('Y-m-d 23:59:59', strtotime('-1 day'));
                break;

            case 'this_month':
                $from_date = date('Y-m-01 00:00:00');
                $to_date   = date('Y-m-t 23:59:59');
                break;

            case 'last_month':
                $from_date = date('Y-m-01 00:00:00', strtotime('first day of last month'));
                $to_date   = date('Y-m-t 23:59:59', strtotime('last day of last month'));
                break;

            case 'last_7_days':
                $from_date = date('Y-m-d 00:00:00', strtotime('-6 days'));
                $to_date   = date('Y-m-d 23:59:59');
                break;

            case 'last_30_days':
                $from_date = date('Y-m-d 00:00:00', strtotime('-29 days'));
                $to_date   = date('Y-m-d 23:59:59');
                break;

            case 'this_year':
                $from_date = date('Y-01-01 00:00:00');
                $to_date   = date('Y-12-31 23:59:59');
                break;

            case 'last_year':
                $from_date = date('Y-01-01 00:00:00', strtotime('-1 year'));
                $to_date   = date('Y-12-31 23:59:59', strtotime('-1 year'));
                break;

            case 'today':
            default:
                $from_date = date('Y-m-d 00:00:00');
                $to_date   = date('Y-m-d 23:59:59');
                break;
        }

        $data['from_date'] = $from_date;
        $data['to_date']   = $to_date;
        $data['filter']    = $filter;

        $db = \Config\Database::connect();

        // Companies
        $builder = $db->table('ecoex_companies');
        $builder->where('type', 'COMPANY');
        $builder->where('status !=', 3);

        if (!empty($from_date) && !empty($to_date)) 
        {
            $builder->where('created_at >=', $from_date);
            $builder->where('created_at <=', $to_date);
        }

        $data['companies'] = $builder->countAllResults();


        // Plants
        $builder = $db->table('ecomm_users');
        $builder->where('type', 'PLANT');
        $builder->where('status !=', 3);

        if (!empty($from_date) && !empty($to_date)) 
        {
            $builder->where('created_at >=', $from_date);
            $builder->where('created_at <=', $to_date);
        }

        $data['plants'] = $builder->countAllResults();


        // Vendors
        $builder = $db->table('ecomm_users');
        $builder->where('type', 'VENDOR');
        $builder->where('status !=', 3);

        if (!empty($from_date) && !empty($to_date)) 
        {
            $builder->where('created_at >=', $from_date);
            $builder->where('created_at <=', $to_date);
        }

        $data['vendors'] = $builder->countAllResults();

       
        







        $data['general_settings']   = $this->common_model->find_data('general_settings', 'row');
        $data['title']              = 'Analytics - ' . $data['general_settings']->site_name;
        $data['page_header']        = 'Analytics';
        return view('analytics', $data);
    }





}
