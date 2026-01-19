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

        $from_date_input = $this->request->getGet('from_date') ?? '';
        $to_date_input   = $this->request->getGet('to_date') ?? '';


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

            
            case 'custom_date':

                if (!empty($from_date_input) && !empty($to_date_input)) {

                    // Validate format (Y-m-d)
                    if (
                        preg_match('/^\d{4}-\d{2}-\d{2}$/', $from_date_input) &&
                        preg_match('/^\d{4}-\d{2}-\d{2}$/', $to_date_input)
                    ) {
                        $from_date = $from_date_input . ' 00:00:00';
                        $to_date   = $to_date_input . ' 23:59:59';

                        if (strtotime($from_date) > strtotime($to_date)) {
                            // fallback to today
                            $from_date = date('Y-m-d 00:00:00');
                            $to_date   = date('Y-m-d 23:59:59');
                        }

                    } else {
                        // Invalid format fallback i.e., fallback to today
                        $from_date = date('Y-m-d 00:00:00');
                        $to_date   = date('Y-m-d 23:59:59');
                    }

                    $data['from_date_input'] = $from_date_input;
                    $data['to_date_input'] = $to_date_input;

                } else {
                    
                    $from_date = '';
                    $to_date   = '';
                }

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

       
        // Subscribe Vendors 
        $builder = $db->table('subscribers');
        $builder->where('status !=', 3);

        if (!empty($from_date) && !empty($to_date)) 
        {
            $builder->where('created_at >=', $from_date);
            $builder->where('created_at <=', $to_date);
        }

        $data['subscribe_vendors'] = $builder->countAllResults();



        // admin_user data
        $builder = $db->table('ecoex_admin_user');
        $builder->where('user_type', 'MA');
        $builder->where('status !=', 3);
        $admin_user_data = $builder->get()->getResult();
        // dd($admin_user_data);

        $data['SUM_RequestSubmittedCount'] = 0;
        $data['SUM_AcceptRequestCount'] = 0;
        $data['SUM_VendorAllocatedCount'] = 0;
        $data['SUM_VendorAssignedCount'] = 0;
        $data['SUM_PickupScheduledCount'] = 0;
        $data['SUM_VehiclePlacedCount'] = 0;
        $data['SUM_MaterialWeighedCount'] = 0;
        $data['SUM_InvoicefromHOCount'] = 0;
        $data['SUM_InvoicetoVendorCount'] = 0;
        $data['SUM_PaymentreceivedfromVendorCount'] = 0;
        $data['SUM_VehicleDispatchedCount'] = 0;
        $data['SUM_PaymenttoHOCount'] = 0;
        $data['SUM_OrderCompleteCount'] = 0;


        foreach ($admin_user_data as $user)
        {
            if($user->user_type == 'MA')
            {
               $data['MA_name'] = $user->name ?? '';

               // Request Submitted
               $builder = $db->table('ecomm_enquires');
               $builder->where('status >=', 0);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('created_at >=', $from_date);
                   $builder->where('created_at <=', $to_date);
               }
               $data['MA_RequestSubmittedCount'] = $builder->countAllResults();
               $data['SUM_RequestSubmittedCount'] += $data['MA_RequestSubmittedCount'];


                // Accept Request
                $builder = $db->table('ecomm_enquires');
                $builder->where('status >=', 1);

                if (!empty($from_date) && !empty($to_date)) {

                    $builder->where("
                        STR_TO_DATE(
                            accepted_date,
                            CASE
                                WHEN LENGTH(SUBSTRING_INDEX(accepted_date, '-', 1)) = 2
                                THEN '%y-%m-%d %H:%i:%s'
                                ELSE '%Y-%m-%d %H:%i:%s'
                            END
                        ) BETWEEN '{$from_date}' AND '{$to_date}'
                    ");
                }

                $data['MA_AcceptRequestCount'] = $builder->countAllResults();
                $data['SUM_AcceptRequestCount'] += $data['MA_AcceptRequestCount'];


               // Vendor Allocated
               $builder = $db->table('ecomm_enquiry_vendor_shares');
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('created_at >=', $from_date);
                   $builder->where('created_at <=', $to_date);
               }
               $data['MA_VendorAllocatedCount'] = $builder->countAllResults();
               $data['SUM_VendorAllocatedCount'] += $data['MA_VendorAllocatedCount'];


               // dd($from_date, $to_date);
               // Vendor Assigned
               $builder = $db->table('ecomm_enquiry_vendor_quotations');
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('created_at >=', $from_date);
                   $builder->where('created_at <=', $to_date);
               }
               $data['MA_VendorAssignedCount'] = $builder->countAllResults();
               $data['SUM_VendorAssignedCount'] += $data['MA_VendorAssignedCount'];

               
               // Pickup Scheduled
               $builder = $db->table('ecomm_sub_enquires');
               $builder->where('status >=', 4.4);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('pickup_scheduled_date >=', $from_date);
                   $builder->where('pickup_scheduled_date <=', $to_date);
               }
               $data['MA_PickupScheduledCount'] = $builder->countAllResults();
               $data['SUM_PickupScheduledCount'] += $data['MA_PickupScheduledCount'];


               // Vehicle Placed
               $builder = $db->table('ecomm_sub_enquires');
               $builder->where('status >=', 5.5);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('vehicle_placed_date >=', $from_date);
                   $builder->where('vehicle_placed_date <=', $to_date);
               }
               $data['MA_VehiclePlacedCount'] = $builder->countAllResults();
               $data['SUM_VehiclePlacedCount'] += $data['MA_VehiclePlacedCount'];


               // Material Weighed
               $builder = $db->table('ecomm_sub_enquires');
               $builder->where('status >=', 6.6);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('material_weighted_date >=', $from_date);
                   $builder->where('material_weighted_date <=', $to_date);
               }
               $data['MA_MaterialWeighedCount'] = $builder->countAllResults();
               $data['SUM_MaterialWeighedCount'] += $data['MA_MaterialWeighedCount'];


               // Invoice from HO
               $builder = $db->table('ecomm_sub_enquires');
               $builder->where('status >=', 7.7);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('invoice_from_ho_date >=', $from_date);
                   $builder->where('invoice_from_ho_date <=', $to_date);
               }
               $data['MA_InvoicefromHOCount'] = $builder->countAllResults();
               $data['SUM_InvoicefromHOCount'] += $data['MA_InvoicefromHOCount'];


               // Invoice to Vendor
               $builder = $db->table('ecomm_sub_enquires');
               $builder->where('status >=', 8.8);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('invoice_to_vendor_date >=', $from_date);
                   $builder->where('invoice_to_vendor_date <=', $to_date);
               }
               $data['MA_InvoicetoVendorCount'] = $builder->countAllResults();
               $data['SUM_InvoicetoVendorCount'] += $data['MA_InvoicetoVendorCount'];


               // Payment received from Vendor
               $builder = $db->table('ecomm_sub_enquires');
               $builder->where('status >=', 9.9);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('vendor_payment_received_date >=', $from_date);
                   $builder->where('vendor_payment_received_date <=', $to_date);
               }
               $data['MA_PaymentreceivedfromVendorCount'] = $builder->countAllResults();
               $data['SUM_PaymentreceivedfromVendorCount'] += $data['MA_PaymentreceivedfromVendorCount'];
 

               // Vehicle Dispatched
               $builder = $db->table('ecomm_sub_enquires');
               $builder->where('status >=', 10.10);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('vehicle_dispatched_date >=', $from_date);
                   $builder->where('vehicle_dispatched_date <=', $to_date);
               }
               $data['MA_VehicleDispatchedCount'] = $builder->countAllResults();
               $data['SUM_VehicleDispatchedCount'] += $data['MA_VehicleDispatchedCount'];


               // Payment to HO
               $builder = $db->table('ecomm_enquires');
               $builder->where('status >=', 11);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('ho_approve_date >=', $from_date);
                   $builder->where('ho_approve_date <=', $to_date);
               }
               $data['MA_PaymenttoHOCount'] = $builder->countAllResults();
               $data['SUM_PaymenttoHOCount'] += $data['MA_PaymenttoHOCount'];
            

               // Order Complete
               $builder = $db->table('ecomm_enquires');
               $builder->where('status >=', 12);
               if (!empty($from_date) && !empty($to_date)) 
               {
                   $builder->where('order_complete_date >=', $from_date);
                   $builder->where('order_complete_date <=', $to_date);
               }
               $data['MA_OrderCompleteCount'] = $builder->countAllResults();
               $data['SUM_OrderCompleteCount'] += $data['MA_OrderCompleteCount'];

               
               
            }
        }



        $data['general_settings']   = $this->common_model->find_data('general_settings', 'row');
        $data['title']              = 'Analytics - ' . $data['general_settings']->site_name;
        $data['page_header']        = 'Analytics';
        return view('analytics', $data);
    }




    // public function wpMessage()
    // {
    //     $db = \Config\Database::connect();

        

    //     $data['general_settings']   = $this->common_model->find_data('general_settings', 'row');
    //     $data['title']              = 'Wp Message - ' . $data['general_settings']->site_name;
    //     $data['page_header']        = 'Wp Message';
    //     return view('wp-message', $data);
    // }


    public function wpMessage()
    {
        $db = \Config\Database::connect();
        helper(['form']);

        // Common data for GET & POST
        $data['general_settings'] = $this->common_model->find_data('general_settings', 'row');
        $data['title']            = 'Wp Message - ' . $data['general_settings']->site_name;
        $data['page_header']      = 'Wp Message';

        // ---------- HANDLE FORM SUBMISSION ----------
        if ($this->request->getMethod() === 'post') {

            /* -------------------------------
            * 1. GET & VALIDATE INPUTS
            * ------------------------------- */
            $phoneNo = trim($this->request->getPost('phone_no'));

            $phoneNo = preg_replace('/\D/', '', $phoneNo);
            if (strlen($phoneNo) === 10) {
                $phoneNo = '91' . $phoneNo;
            }


            $params = [];
            for ($i = 1; $i <= 4; $i++) {
                $paramVal = trim($this->request->getPost("param{$i}"));
                if ($paramVal !== '') {
                    $params[] = $paramVal;
                }
            }

            // Image
            $image = $this->request->getFile('image');

            if (!$phoneNo || !$image->isValid()) {
                return redirect()->back()->with('error', 'Phone number and image are mandatory');
            }


            /* -------------------------------
            * 2. IMAGE UPLOAD
            * ------------------------------- */
            $uploadPath = FCPATH . 'uploads/wp_image/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $newName = time() . '_' . $image->getRandomName();
            $image->move($uploadPath, $newName);

            if (!$image->hasMoved()) {
                return redirect()->back()->with('error', 'Image upload failed');
            }

            $imageUrl  = base_url('uploads/wp_image/' . $newName);
            $imageName = $newName;





            /* -------------------------------
            * 3. BUILD templateParams ARRAY
            * ------------------------------- */
            // WhatsApp API expects array values, not raw params
            // If 2 params submitted → array length = 2
            $templateParams = [];
            foreach ($params as $p) {
                $templateParams[] = $p;
            }

            /* -------------------------------
            * 4. PREPARE API PAYLOAD
            * ------------------------------- */
            $payload = [
                "apiKey"        => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY3ZTUyNDRjN2VlMTE0MGY3OTQ5MmZiZSIsIm5hbWUiOiJLZXlsaW5lIERpZ2lUZWNoIFB2dC4gTHRkLiIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2N2U1MjQ0YzdlZTExNDBmNzk0OTJmYjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTc0MzA3MDI4NH0.eFNVbyN63fAzdd_gtViD0JToL10R7nvgKiM6MFbQqow",
                "campaignName"  => "ecoex-test",
                "destination"   => $phoneNo,
                "userName"      => "Keyline DigiTech Pvt. Ltd.",
                "templateParams"=> $templateParams,
                "source"        => "new-landing-page form",
                "media"         => [
                    "url"      => $imageUrl,
                    "filename" => $imageName
                ],
                "buttons"       => [],
                "carouselCards" => [],
                "location"      => (object)[],
                "attributes"    => (object)[],
                "paramsFallbackValue" => [
                    "FirstName" => "user"
                ]
            ];

            dd($payload);

            /* -------------------------------
            * 5. SEND CURL REQUEST
            * ------------------------------- */
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL            => "https://backend.api-wa.co/campaign/smartping/api/v2",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_HTTPHEADER     => [
                    "Content-Type: application/json"
                ],
                CURLOPT_POSTFIELDS     => json_encode($payload)
            ]);

            $response = curl_exec($ch);
            $curlError = curl_error($ch);
            $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($curlError) {
                return redirect()->back()->with('error', 'Curl Error: ' . $curlError);
            }

            $responseData = json_decode($response, true);

            // DEBUG (temporarily)
            // log_message('error', print_r($responseData, true));

            if ($httpCode !== 200 || empty($responseData) || (isset($responseData['success']) && $responseData['success'] === false)) {
                return redirect()->back()->with(
                    'error',
                    'WhatsApp API Error: ' . ($responseData['message'] ?? 'Unknown error')
                );
            }

            return redirect()->back()->with('success', 'WhatsApp message sent successfully');

        }

        // ---------- LOAD VIEW (GET REQUEST) ----------
        return view('wp-message', $data);
    }




}
