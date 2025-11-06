<?php

use Config\Services;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function pr($data = array(), $mode = true)
{
    echo "<pre>";
    print_r($data);
    if ($mode) {
        die;
    }
}
if (! function_exists('test_method')) {
    function registration_mail($params)
    {
        $params['config'] = email_settings();
        sendmail($params);
        return 1;
    }
    function forgotpassword_mail($params)
    {
        $params['config'] = email_settings();
        sendmail($params);
        return 1;
    }
    function email_settings()
    {
        $config['protocol']    = 'smtp';
        // $config['smtp_host']    = 'mail.met-technologies.com';
        // $config['smtp_port']    = '25';
        //$config['smtp_user']    = 'developer.net@met-technologies.com';
        // $config['smtp_pass']    = 'Dot123@#$%';
        $config['smtp_host']    = 'ssl://mail.met-technologies.com';
        $config['smtp_port']    = '465';
        $config['smtp_user']    = 'developer.net@met-technologies.com';
        $config['smtp_pass']    = 'Dot123@#$%';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = true; // bool whether to validate email or not
        return $config;
    }
    function sendmail($data, $attach = '')
    {
        $obj = get_object();
        $obj->load->library('email');
        //print_r($data);die;
        $config['protocol']      = 'smtp';
        /*$config['smtp_host']     = 'ssl://mail.fitser.com';
          $config['smtp_port']     = '465';
          $config['smtp_user']    = 'test12@fitser.com';
          $config['smtp_pass']    = 'Test123@';*/
        $config['smtp_host']     = 'ssl://mail.met-technologies.com';
        $config['smtp_port']     = '465';
        $config['smtp_user']    = 'developer.net@met-technologies.com';
        $config['smtp_pass']    = 'Dot123@#$%';
        $config['charset']     = 'utf-8';
        $config['newline']     = "\r\n";
        $config['mailtype']  = 'html';
        $config['validation']  = true;
        $obj->email->initialize($config);

        if ($attach != '') {
            $obj->email->attach($attach);
        }
        $obj->email->set_crlf("\r\n");
        $obj->email->from($data['from_email'], $data['from_name']);
        $obj->email->to($data['to']);
        $obj->email->subject($data['subject']);
        $obj->email->message($data['message']);
        $obj->email->send();
        //echo $obj->email->print_debugger(); die;
        return true;
    }
    function get_user_role_type()
    {
        $user_role = get_object()->session->userdata('user_role');
        return $user_role;
    }
    function get_object()
    {
        $obj = &get_instance();
        return $obj;
    }
    function getStatusCahnge($id, $tbl, $tbl_column_name, $chng_status_colm, $status, $reason = null)
    {
        //echo $id."<br>".$tbl."<br>".$tbl_column_name."<br>".$chng_status_colm."<br>".$status;exit;
        $CI = get_instance();
        $condition                      = array();
        $udata                          = array();
        $resonse                        = '';
        $condition[$tbl_column_name]    = $id;
        $udata[$chng_status_colm]       = $status;
        if ($reason != null) {
            $udata['cancellation_reason'] = $reason;
        }
        $resonse                        = $CI->mcommon->update($tbl, $condition, $udata);
        //echo $CI->db->last_query(); die;
        return $resonse;
    }
    function RemoveSpecialChar($str)
    {
        $res = str_replace(array(
          '\'',
          '"',
          ',',
          ';',
          '<',
          '>',
          '?',
          '(',
          ')',
          '[',
          ']',
          '{',
          '}',
          '.',
          '\r',
          '\n'
        ), ' ', $str);
        return $res;
    }
    function time_difference($to_time)
    {
        $to_time = strtotime($to_time);
        $from_time = strtotime(date('Y-m-d H:i:s'));
        $time_diff = round(abs($to_time - $from_time) / 60, 0);
        if ($time_diff > 1440) {
            if ($time_diff > 525600) {
                $totalYears = ($time_diff / 1440) / 365;
                //echo $totalDays;die;
                $day_diff = round($totalYears, 0) . " years";
            } else {
                $day_diff = round(($time_diff / 1440), 0) . " days";
            }
        } else {
            if ($time_diff > 60) {
                $hours = round(($time_diff / 60), 0);
                $mins = round(($time_diff % 60), 0);
                $day_diff = $hours . " hours " . $mins . " mins";
            } else {
                $day_diff = $time_diff . " mins";
            }
        }
        return $day_diff;
    }
    /////////////////////////////////////new fn for time ago/////////////////////////////////////
    function time_ago($timestamp)
    {
        $time_ago        = strtotime($timestamp);
        $current_time    = time();
        $time_difference = $current_time - $time_ago;
        $seconds         = $time_difference;

        $minutes = round($seconds / 60); // value 60 is seconds
        $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
        $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
        $weeks   = round($seconds / 604800); // 7*24*60*60;
        $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
        $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

        if ($seconds <= 60) {
            return "Just Now";
        } elseif ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 minute ago";
            } else {
                return "$minutes minutes ago";
            }
        } elseif ($hours <= 24) {
            if ($hours == 1) {
                return "an hour ago";
            } else {
                return "$hours hrs ago";
            }
        } elseif ($days <= 7) {
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        } elseif ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        } elseif ($months <= 12) {
            if ($months == 1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        } else {

            if ($years == 1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }
    function encoded($param)
    {
        return urlencode(base64_encode($param));
    }
    function decoded($param)
    {
        return base64_decode(urldecode($param));
    }
    function getInquiryStatus($num)
    {
        if ($num == 0) {
            $inquiryStatus = 'Submit Inquiry';
        } elseif ($num == 1) {
            $inquiryStatus = 'Documents Uploaded';
        } elseif ($num == 2) {
            $inquiryStatus = 'Admin Approved';
        } elseif ($num == 3) {
            $inquiryStatus = 'Buyer Accept';
        } elseif ($num == 4) {
            $inquiryStatus = 'PO Uploaded';
        } elseif ($num == 5) {
            $inquiryStatus = 'Shared PO';
        } elseif ($num == 6) {
            $inquiryStatus = 'Admin Upload Invoices';
        } elseif ($num == 7) {
            $inquiryStatus = 'Buyer Payment Upload';
        } elseif ($num == 8) {
            $inquiryStatus = 'Admin Accept Payment';
        }
        return $inquiryStatus;
    }
    function perform_http_request($method, $url, $data = false)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); //If SSL Certificate Not Available, for example, I am calling from http://localhost URL
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    function curl_request_post($method, $url, $data = false)
    {
        $url = "https://trst01.in/api/blockchain/postData";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
          "Content-type: application/json",
          "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //pr($data);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        //pr($resp);
        return $resp;
    }
    function checkModuleFunctionAccess($module_id, $function_id)
    {
        $db = \Config\Database::connect();
        $session      = \Config\Services::session();
        $userId             = $session->get('userId');
        $adminUser          = $db->query("select * from ecoex_admin_user where id = '$userId'")->getRow();
        $checkExist         = $db->query("select * from ecoex_role_module_function where module_id = '$module_id' and role_id = '$adminUser->role_id' and function_id = '$function_id'")->getNumRows();
        //echo $db->getLastQuery();die;
        //print_r($checkExist);die;
        //echo $checkExist;die;
        if ($checkExist > 0) {
            return true;
        } else {
            return false;
        }
    }
    function weekdays($dayNo)
    {
        if ($dayNo == 0) {
            $day_name = 'Sunday';
        }
        if ($dayNo == 1) {
            $day_name = 'Monday';
        }
        if ($dayNo == 2) {
            $day_name = 'Tuesday';
        }
        if ($dayNo == 3) {
            $day_name = 'Wednesday';
        }
        if ($dayNo == 4) {
            $day_name = 'Thursday';
        }
        if ($dayNo == 5) {
            $day_name = 'Friday';
        }
        if ($dayNo == 6) {
            $day_name = 'Saturday';
        }
        return $day_name;
    }
    function monthName($monthNo)
    {
        if ($monthNo == 1) {
            $month_name = 'January';
        }
        if ($monthNo == 2) {
            $month_name = 'February';
        }
        if ($monthNo == 3) {
            $month_name = 'March';
        }
        if ($monthNo == 4) {
            $month_name = 'April';
        }
        if ($monthNo == 5) {
            $month_name = 'May';
        }
        if ($monthNo == 6) {
            $month_name = 'June';
        }
        if ($monthNo == 7) {
            $month_name = 'July';
        }
        if ($monthNo == 8) {
            $month_name = 'August';
        }
        if ($monthNo == 9) {
            $month_name = 'September';
        }
        if ($monthNo == 10) {
            $month_name = 'October';
        }
        if ($monthNo == 11) {
            $month_name = 'November';
        }
        if ($monthNo == 12) {
            $month_name = 'December';
        }
        return $month_name;
    }
    function monthShortName($monthNo)
    {
        if ($monthNo == 1) {
            $month_name = 'Jan';
        }
        if ($monthNo == 2) {
            $month_name = 'Feb';
        }
        if ($monthNo == 3) {
            $month_name = 'Mar';
        }
        if ($monthNo == 4) {
            $month_name = 'Apr';
        }
        if ($monthNo == 5) {
            $month_name = 'May';
        }
        if ($monthNo == 6) {
            $month_name = 'Jun';
        }
        if ($monthNo == 7) {
            $month_name = 'Jul';
        }
        if ($monthNo == 8) {
            $month_name = 'Aug';
        }
        if ($monthNo == 9) {
            $month_name = 'Sep';
        }
        if ($monthNo == 10) {
            $month_name = 'Oct';
        }
        if ($monthNo == 11) {
            $month_name = 'Nov';
        }
        if ($monthNo == 12) {
            $month_name = 'Dec';
        }
        return $month_name;
    }
    function lastdayMonth($monthNo)
    {
        $lastDay = 31;
        $currentMonth  = (int)$monthNo;
        if ($currentMonth == 1) {
            $lastDay = 31;
        }
        if ($currentMonth == 2) {
            $lastDay = 28;
        }
        if ($currentMonth == 3) {
            $lastDay = 31;
        }
        if ($currentMonth == 4) {
            $lastDay = 30;
        }
        if ($currentMonth == 5) {
            $lastDay = 31;
        }
        if ($currentMonth == 6) {
            $lastDay = 30;
        }
        if ($currentMonth == 7) {
            $lastDay = 31;
        }
        if ($currentMonth == 8) {
            $lastDay = 31;
        }
        if ($currentMonth == 9) {
            $lastDay = 30;
        }
        if ($currentMonth == 10) {
            $lastDay = 31;
        }
        if ($currentMonth == 11) {
            $lastDay = 30;
        }
        if ($currentMonth == 12) {
            $lastDay = 31;
        }
        return $lastDay;
    }
    function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string2 = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string3 = preg_replace('/-+/', '-', $string2);
        return strtolower($string3);
    }
    function weightConversion($weight, $from, $to = 'MT')
    {
        $convertedWeight = 0;
        if ($from == 'KG' && $to == 'MT') {
            $convertedWeight = ($weight * 0.001);
        } elseif ($from == 'MT' && $to == 'KG') {
            $convertedWeight = ($weight * 1000);
        }
        return $convertedWeight;
    }
}


// code added to send mail using service @Shubha75
if (!function_exists('send_mail')) {
    function send_mail($to, $subj, $body, $alt = '', $atts = [])
    {
        return service('mailer')->send($to, $subj, $body, $alt, $atts);
    }
}

if (!function_exists('getQtyWithUnitGroupedItems')) {
    function getQtyWithUnitGroupedItems($enquiry_id, $common_model = null)
    {
        // Define the join conditions
        $joins = [
            [
                'table' => 'ecomm_company_items',
                'table_master' => 'ecomm_sub_enquires',
                'field' => 'id',
                'field_table_master' => 'item_id',
                'type' => 'left'
            ]
        ];

        // Select with SUM and proper aliasing
        $select = 'ecomm_sub_enquires.item_id, 
               ecomm_company_items.alias_name,
               SUM(ecomm_sub_enquires.weighted_qty) as total_quantity,
               ecomm_sub_enquires.weighted_unit';

        // Group by item and unit
        $group_by = [
            'ecomm_sub_enquires.enq_id',

            'ecomm_sub_enquires.item_id',

        ];

        // Order by product name
        $order_by = [
            ['field' => 'ecomm_company_items.alias_name', 'type' => 'ASC']
        ];

        $conditions = ['ecomm_sub_enquires.enq_id' => $enquiry_id];

        $groupedItems = $common_model->find_data(
            'ecomm_sub_enquires',
            'array',
            $conditions,
            $select,
            $joins,
            $group_by,
            $order_by
        );

        return $groupedItems;
    }

    if (!function_exists('validateDate')) {
        // Validate date format (YYYY-MM-DD) if provided, else fallback
        function validateDate($date)
        {
            $d = DateTime::createFromFormat('Y-m-d', $date);
            return $d && $d->format('Y-m-d') === $date;
        }
    }


    if (!function_exists('getAllowedVendorIds')) {
        function getAllowedVendorIds($userId)
        {
            $db = \Config\Database::connect();
            $user = $db->table('ecoex_admin_user')
                ->select('vendor_ids')
                ->where('id', $userId)
                ->get()
                ->getRow();

            if ($user && !empty($user->vendor_ids)) {
                $ids = json_decode($user->vendor_ids, true);
                return array_filter($ids);
            }

            return [];
        }
    }


    if (!function_exists('getAllowedPlantIds')) {
        function getAllowedPlantIds($userId)
        {
            $db = \Config\Database::connect();
            $user = $db->table('ecoex_admin_user')
                ->select('plant_ids')
                ->where('id', $userId)
                ->get()
                ->getRow();

            if ($user && !empty($user->plant_ids)) {
                $ids = json_decode($user->plant_ids, true);
                return array_filter($ids);
            }

            return [];
        }
    }


}
