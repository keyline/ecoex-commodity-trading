<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use Config\App;
use App\Services\WhatsApp\DigitalSmsWhatsAppProvider;
use App\Services\WhatsApp\WhatsAppMessageService;
use App\Models\WhatsappInteractionModel;
use Config\Database;

class WhatsappMessageController extends BaseController
{
    protected $data = [];
    protected $db;
    public function __construct()
    {

        $session = \Config\Services::session();
        if (!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }

        $model = new CommonModel();
        $this->db = Database::connect();



        $this->data = array(
                    'model'                 => $model,
                    'session'               => $session,
                    'title'                 => 'Whatsapp Notification Jobs',
                    'controller_route'      => 'whasapp',
                    'controller'            => 'WhatsappMessageController',
                    'table_name'            => 'ecomm_whatsapp_worker',
                    'primary_key'           => 'id'
                );


    }

    public function list()
    {
        $userType                   = $this->session->user_type;
        //$company_id                 = $this->session->company_id;
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'whatsapp/list';

        $model = new \App\Models\WhatsAppWorkerModel();
        $list = $model->findAll();
        $data['rows'] = $list;

        echo $this->layout_after_login($title, $page_name, $data);


    }

    public function retryList($jobId)
    {
        $failedModel = new \App\Models\WhatsappFailedPayloadModel();
        $jobModel    = new \App\Models\WhatsAppWorkerModel();

        $provider = new DigitalSmsWhatsAppProvider();
        $service = new WhatsAppMessageService($provider);

        //$service     = service('WhatsAppMessageService');

        $failedPayloads = $failedModel->where('job_id', $jobId)->findAll();

        if (empty($failedPayloads)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No failed payloads for this job'
            ]);
        }

        $results = [];
        foreach ($failedPayloads as $row) {
            $payload   = json_decode($row['payload'], true);
            $recipient = $row['recipient'];
            $item      = $payload['item'];

            $result = $service->sendWithRetry($recipient, [$item], $jobId);

            if ($result['status'] === 'success') {
                // ✅ Remove failed record
                $failedModel->delete($row['id']);

                // ✅ Decrement job's failed counter
                $jobModel->set('failed', 'failed-1', false)
                         ->where('id', $jobId)
                         ->update();
            } else {
                // ❌ Still failing → update attempts & error
                $failedModel->update($row['id'], [
                    'attempts'   => $row['attempts'] + 1,
                    'last_error' => json_encode($result['messages']),
                ]);
            }

            $results[] = $result;
        }


        return redirect()->back();


        /*return $this->response->setJSON([
            'status'  => 'success',
            'job_id'  => $jobId,
            'results' => $results
        ]);*/
    }

    public function incoming()
    {

        // ✅ Use the exact same token you entered in your Meta app dashboard
        $verify_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.KMUFsIDTnFmyG3nMiGM6H9FNFUROf3wh7SmqJp-QV30";

        $request = service('request');

        // =============================
        // 1️⃣ Handle GET: Webhook verification
        // =============================
        if ($request->getMethod() === 'get') {
            $mode = $request->getGet('hub_mode');
            $token = $request->getGet('hub_verify_token');
            $challenge = $request->getGet('hub_challenge');

            if ($mode === 'subscribe' && $token === $verify_token) {
                // Respond with the challenge in plain text
                return $this->response
                    ->setStatusCode(200)
                    ->setContentType('text/plain')
                    ->setBody($challenge);
            } else {
                return $this->response
                    ->setStatusCode(403)
                    ->setBody('Invalid verify token');
            }
        }

        // =============================
        // 2️⃣ Handle POST: Incoming WhatsApp messages
        // =============================
        if ($request->getMethod() === 'post') {
            $input = $request->getJSON(true);

            // Log incoming messages for debugging
            log_message('info', 'WhatsApp Webhook Received: ' . json_encode($input));

            // You can handle messages here, e.g. store to DB

            // Validate payload structure
            if (!isset($input['entry'][0]['changes'][0]['value']['messages'][0])) {
                log_message('warning', 'WhatsApp Webhook: No messages found in payload');

                return $this->response->setJSON(['status' => 'ignored'])->setStatusCode(200);

            }

            $value    = $input['entry'][0]['changes'][0]['value'];
            $message  = $value['messages'][0];
            $contact  = $value['contacts'][0] ?? [];

            // Extract details
            $wa_id    = $message['from'] ?? null;
            $userName = $contact['profile']['name'] ?? null;
            $buttonId = $message['interactive']['button_reply']['id'] ?? '';
            $timestamp = $message['timestamp'] ?? null;

            // Button ID format: <enquiry_id>_<product_id>_<action>
            $parts = explode('_', $buttonId);
            $enquiryId = $parts[0] ?? null;
            $productId = $parts[1] ?? null;
            $action    = $parts[2] ?? null;

            // Save to DB
            $model = new WhatsappInteractionModel();
            $model->insert([
                'enquiry_id'    => $enquiryId,
                'product_id'    => $productId,
                'wa_id'         => $wa_id,
                'user_name'     => $userName,
                'button_action' => $action,
                'raw_payload'   => json_encode($input),
            ]);

            $insertId = $model->getInsertID();


            log_message('info', 'WhatsApp Webhook data stored successfully : ' . json_encode($insertId));

            //return $this->respond(['status' => 'stored'], 200);


            return $this->response
                ->setStatusCode(200)
                ->setBody('EVENT_RECEIVED');
        }

        return $this->response
            ->setStatusCode(404)
            ->setBody('Unsupported method');

    }

    public function interactionList()
    {

        $userType                   = $this->session->user_type;
        //$company_id                 = $this->session->company_id;
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'whatsapp/interactionlist';

        $model = new WhatsappInteractionModel();
        $data['interactions'] = $model->orderBy('id', 'DESC')->findAll();

        //return view('whatsapp/interactionlist', $data);
        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function viewReport($id)
    {
        $model = new \App\Models\WhatsAppWorkerModel();
        $job = $model->where('enquiry_id', $id)->first();

        if (!$job) {
            return redirect()->back()->with('error_message', 'Whatsapp notification for this enquiry not found');
        }

        $data['moduleDetail'] = $this->data;
        $data['job'] = $job;
        $title                      = 'Manage ' . $this->data['title'];

        //enquiry details

        $builder = $this->db->table('ecomm_enquires ee');
        $builder->select("
                        ee.id   AS enquiry_id,
                        ci.id   AS enquiry_product_id,
                        ep.new_product_image AS media_url,
                        ep.qty,
                        ep.unit,
                        ci.price_range AS price_range,
                        ci.id   AS item_id,
                        ci.item_name_ecoex AS material,
                        u.plant_name,
                        u.district,
                        u.state,
                        unit.name AS unit_name,
                        ee.enquiry_no,
                        ee.created_at,
                        ee.status
                    ");
        $builder->join('ecomm_enquiry_products ep', 'ee.id = ep.enq_id');
        $builder->join('ecomm_company_items ci', 'ep.product_id = ci.id');
        $builder->join('ecomm_users u', 'ep.plant_id = u.id');
        $builder->join('ecomm_units unit', 'unit.id = ci.unit');
        $builder->where('ee.id', $id);
        $builder->orderBy('ep.id');

        $query   = $builder->get();
        $items = $query->getResultArray();

        $data['items'] = $items;
        $data['notificationStats'] = $this->getWhatsappStats($id);
        //getting whatsapp worker details

        $summary = array_reduce($data['notificationStats']['attempts'], function ($carry, $item) {
            $type = $item['send_type'];
            $carry[$type]['total_attempts'] = ($carry[$type]['total_attempts'] ?? 0) + (int)$item['total_attempts'];
            $carry[$type]['attempts_made']  = ($carry[$type]['attempts_made']  ?? 0) + 1;
            $carry[$type]['total_notified'] = ($carry[$type]['total_notified'] ?? 0) + (int)$item['total_notified'];
            return $carry;
        }, []);

        $data['notificationStats']['summary'] = $summary;
        $data['notificationStats']['distribution'] = $this->getNotificationDistribution($items[0]['state'] ?? null);

        $notInterested = $data['notificationStats']['coverage'][0]['not_interested_count'];
        $interested = $data['notificationStats']['coverage'][0]['interested_count'];
        //$pending = $data['notificationStats']['coverage'][0]['pending_count'];
        $total = $data['notificationStats']['summary']['state']['total_notified'] + $data['notificationStats']['summary']['pan_India']['total_notified'] + $data['notificationStats']['summary']['neighbour']['total_notified'];
        $pending = $total - ($interested + $notInterested);
        $interestedRate = $total > 0 ? round((($interested) / $total) * 100, 2) : 0;
        $notInterestedRate = $total > 0 ? round((($notInterested) / $total) * 100, 2) : 0;
        $pendingRate = $total > 0 ? round(($pending / $total) * 100, 2) : 0;

        $data['notificationStats']['interested_rate'] = $interestedRate;
        $data['notificationStats']['not_interested_rate'] = $notInterestedRate;
        $data['notificationStats']['pending_rate'] = $pendingRate;
        $data['notificationStats']['total'] = $total;
        $data['notificationStats']['pending'] = $pending;

        $title = 'WhatsApp Notification Report';
        $page_name = 'whatsapp/notification-report';

        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function getWhatsappStats($enquiryId)
    {
        $result = ['coverage' => [], 'attempts' => []];

        try {
            // 1. Notification coverage summary
            $builder1 = $this->db->table('ecomm_whatsapp_workers w');
            $builder1->select("
            w.enquiry_id,
            COUNT(DISTINCT w.id) AS total_sent,
            SUM(CASE WHEN i.button_action = 'Interested' THEN 1 ELSE 0 END) AS interested_count,
            SUM(CASE WHEN i.button_action = 'Not Interested' THEN 1 ELSE 0 END) AS not_interested_count,
            SUM(CASE WHEN (i.button_action IS NULL OR i.button_action = '') THEN 1 ELSE 0 END) AS pending_count");
            $builder1->join('whatsapp_interactions i', 'w.enquiry_id = i.enquiry_id', 'left');
            $builder1->where('w.enquiry_id', $enquiryId);
            $builder1->groupBy('w.enquiry_id');
            $builder1->orderBy('w.enquiry_id', 'DESC');
            $result['coverage'] = $builder1->get()->getResultArray();

            // 2. Attempts summary
            $builder2 = $this->db->table('ecomm_whatsapp_workers w');
            $builder2->select("
            DATE(w.created_at) AS created_date,
            w.send_type,
            COUNT(*) AS total_attempts,
            w.total_recipients AS total_notified,
            SUM(CASE WHEN w.send_type = 'state' THEN 1 ELSE 0 END) AS statewise_count,
            SUM(CASE WHEN w.send_type = 'pan_India' THEN 1 ELSE 0 END) AS pan_india_count,
            SUM(CASE WHEN w.send_type = 'neighbour' THEN 1 ELSE 0 END) AS neighbour_count            
            ");
            $builder2->groupBy('DATE(w.created_at)');
            $builder2->groupBy('w.send_type');
            $builder2->orderBy('DATE(w.created_at)', 'DESC');
            $result['attempts'] = $builder2->get()->getResultArray();

        } catch (\Throwable $e) {
            log_message('error', 'Error in getWhatsappStats: ' . $e->getMessage());
        }

        return $result;
    }

    public function getNotificationDistribution($state = null)
    {
        $db = \Config\Database::connect();

        // --- 1️⃣ Statewise Vendors ---
        $builder1 = $db->table('ecomm_users');
        $builder1->select('COUNT(*) AS count');
        $builder1->where('type', 'VENDOR');
        $builder1->where('phone <>', '');
        if (!empty($state)) {
            $builder1->where('state', $state);
        }
        $statewiseVendor = (int) $builder1->get()->getRow('count');

        // --- 2️⃣ Pan India Vendors ---
        $builder2 = $db->table('ecomm_users');
        $builder2->select('COUNT(*) AS count');
        $builder2->where('type', 'VENDOR');
        $builder2->where('phone <>', '');
        $panIndiaVendor = (int) $builder2->get()->getRow('count');

        // --- 3️⃣ Statewise Subscribers ---
        $builder3 = $db->table('subscribers');
        $builder3->select('COUNT(*) AS count');
        $builder3->where('phone <>', '');
        if (!empty($state)) {
            $builder3->where('state', $state);
        }
        $statewiseSubscriber = (int) $builder3->get()->getRow('count');

        // --- 4️⃣ Pan India Subscribers ---
        $builder4 = $db->table('subscribers');
        $builder4->select('COUNT(*) AS count');
        $builder4->where('phone <>', '');
        $panIndiaSubscriber = (int) $builder4->get()->getRow('count');

        // --- 5 Neighbourwise Vendors ---
        $builder5 = $db->table('ecomm_states');
        $builder5->select('name');
        $builder5->where('is_neighbour', 1);
        $builder5->where('status', 1);
        $getNeighbourStates = $builder5->get()->getResult();
        $neighbourStateList = [];
        if($getNeighbourStates){
            foreach($getNeighbourStates as $getNeighbourState){
                $neighbourStateList[] = $getNeighbourState->name;
            }
        }
        $neighbourStateString = implode(',', $neighbourStateList);

        $builder6 = $db->table('ecomm_users');
        $builder6->select('COUNT(*) AS count');
        $builder6->where('type', 'VENDOR');
        $builder6->where('phone <>', '');
        if (!empty($state)) {
            $builder6->whereIn('state', $neighbourStateString);
        }
        $neighbourVendor = (int) $builder6->get()->getRow('count');

        // --- Neighbourwise Subscribers ---
        $builder7 = $db->table('subscribers');
        $builder7->select('COUNT(*) AS count');
        $builder7->where('phone <>', '');
        if (!empty($state)) {
            $builder7->whereIn('state', $neighbourStateString);
        }
        $neighbourSubscriber = (int) $builder7->get()->getRow('count');

        // ✅ Return summary
        return [
            'statewise' => [
                'vendor_count'     => $statewiseVendor,
                'subscriber_count' => $statewiseSubscriber,
                'total'            => $statewiseVendor + $statewiseSubscriber,
            ],
            'pan_india' => [
                'vendor_count'     => $panIndiaVendor,
                'subscriber_count' => $panIndiaSubscriber,
                'total'            => $panIndiaVendor + $panIndiaSubscriber,
            ],
            
            'neighbour' => [
                'vendor_count'     => $neighbourVendor,
                'subscriber_count' => $neighbourSubscriber,
                'total'            => $neighbourVendor + $neighbourSubscriber,
            ],
        ];
    }

    /**
     * AJAX endpoint for tab data
     * URL: /notification-report/tabdata?job_id=123&type=interested|not_interested|pending
     */
    public function tabData()
    {
        $db = \Config\Database::connect();

        try {
            $jobId = (int) $this->request->getGet('job_id');
            $type  = $this->request->getGet('type') ?? 'interested';


            if (!$jobId || !in_array($type, ['interested', 'not_interested', 'pending'])) {

                return $this->response->setJSON(['status' => 'error', 'message' => 'invalid or missing parameter'])->setStatusCode(400);

            }

            //for pagination

            $page    = (int) $this->request->getGet('page') ?: 1;
            $perPage = (int) $this->request->getGet('per_page') ?: 10;
            $filter  = $this->request->getGet('filter') ?? 'all'; // vendor | subscriber | all
            $search  = trim($this->request->getGet('search') ?? '');


            if (!$jobId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Missing job_id'])->setStatusCode(400);
            }

            // ✅ Step 1: Get enquiry info
            $job = $this->db->table('ecomm_whatsapp_workers')->where('enquiry_id', $jobId)->get()->getRowArray();
            if (!$job) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid job_id'])->setStatusCode(404);
            }

            $enquiryId = $job['enquiry_id'];
            $sendType  = $job['send_type']; // state / pan_India // neighbour
            if ($sendType == 'state') {

                $builder = $this->db->table('ecomm_enquires enq');
                $builder->select('u.state');
                $builder->join('ecomm_users u', 'u.id = enq.plant_id');
                $builder->where('u.type', 'PLANT');
                $builder->where('enq.id', $enquiryId);

                $query = $builder->get();
                $result = $query->getRow();

                $state = $result->state;

            }
            //$state     = $job['state_type'] ?? null;

            if ($sendType == 'neighbour') {
                $builder5 = $db->table('ecomm_states');
                $builder5->select('name');
                $builder5->where('is_neighbour', 1);
                $builder5->where('status', 1);
                $getNeighbourStates = $builder5->get()->getResult();
                $neighbourStateList = [];
                if($getNeighbourStates){
                    foreach($getNeighbourStates as $getNeighbourState){
                        $neighbourStateList[] = $getNeighbourState->name;
                    }
                }
                $neighbourStateString = implode(',', $neighbourStateList);
            }



            // --- Build recipients UNION query (vendors + subscribers)
            $recipientBinds = [];


            $vendorSQL = "SELECT phone, 'Vendor' AS type, company_name AS company_name,  state
                      FROM ecomm_users
                      WHERE phone <> '' AND type = 'VENDOR'";
            $subscriberSQL = "SELECT phone, 'Subscriber' AS type, name AS company_name, state
                          FROM subscribers
                          WHERE phone <> ''";


            if ($sendType === 'state' && $state) {
                $vendorSQL .= " AND state = ?";
                $subscriberSQL .= " AND state = ?";
                $recipientBinds[] = $state;
                $recipientBinds[] = $state;
            }
            if ($sendType === 'neighbour') {
                $vendorSQL .= " AND state IN ?";
                $subscriberSQL .= " AND state IN ?";
                $recipientBinds[] = $neighbourStateString;
                $recipientBinds[] = $neighbourStateString;
            }

            // combine
            $unionRecipientsSQL = "({$vendorSQL}) UNION ALL ({$subscriberSQL})";


            // --- Build 'latest interaction per recipient+product' subquery (dedupe)
            // We select the latest interaction id per enquiry+wa_id+product_id using GROUP_CONCAT trick,
            // then join back by id to fetch button_action and created_at.
            $latestSubSql = "
            SELECT li.enquiry_id, li.wa_id, li.product_id, li.latest_time, li.latest_id
            FROM (
                SELECT i.enquiry_id,
                       i.wa_id,
                       i.product_id,
                       MAX(i.created_at) AS latest_time,
                       SUBSTRING_INDEX(GROUP_CONCAT(i.id ORDER BY i.created_at DESC), ',', 1) AS latest_id
                FROM whatsapp_interactions i
                WHERE i.enquiry_id = ?
                GROUP BY i.enquiry_id, i.wa_id, i.product_id
            ) li
        ";
            $latestBinds = [$enquiryId];

            // --- Compose main selectable SQL (without LIMIT)
            // We'll join recipients -> latest interactions (li) -> interaction details (wi) -> product details (ep->ci->unit)
            $mainSql = "
            SELECT 
                r.phone,
                r.type,
                r.company_name,
                r.state,
                wi.button_action AS response,
                wi.created_at AS response_time,
                wi.product_id,
                ci.item_name_ecoex AS product_name,
                ep.qty AS product_qty,
                unit.name AS unit_name
            FROM ({$unionRecipientsSQL}) AS r
            LEFT JOIN ({$latestSubSql}) AS li
                ON li.wa_id = r.phone
            LEFT JOIN whatsapp_interactions wi
                ON wi.id = li.latest_id
            LEFT JOIN ecomm_enquiry_products ep
                ON ep.id = wi.product_id AND ep.enq_id = ?
            LEFT JOIN ecomm_company_items ci
                ON ci.id = ep.product_id
            LEFT JOIN ecomm_units unit
                ON unit.id = ci.unit
        ";

            // Binds for mainSql: recipientBinds (if any) + latestBinds (enquiryId) + enquiryId for ep join
            $mainBinds = array_merge($recipientBinds, $latestBinds, [$enquiryId]);

            // --- Apply tab-specific filtering and optional filters (search / vendor/subscriber)
            $whereClauses = [];
            $whereBinds = [];

            // filter by tab type
            if ($type === 'interested') {
                $whereClauses[] = "wi.button_action = 'Interested'";
            } elseif ($type === 'not_interested') {
                $whereClauses[] = "wi.button_action = 'Not Interested'";
            } elseif ($type === 'pending') {
                // pending: no interaction or empty action for the latest interaction row
                $whereClauses[] = "(li.latest_id IS NULL OR wi.button_action IS NULL OR wi.button_action = '')";
            }

            // filter by recipient type (vendor/subscriber)
            if ($filter === 'vendor') {
                $whereClauses[] = "r.type = 'Vendor'";
            } elseif ($filter === 'subscriber') {
                $whereClauses[] = "r.type = 'Subscriber'";
            }

            // search -> on company or phone (use LIKE)
            if ($search !== '') {
                $whereClauses[] = " (r.company_name LIKE ? OR r.phone LIKE ?)";
                $whereBinds[] = '%' . $this->db->escapeLikeString($search) . '%';
                $whereBinds[] = '%' . $this->db->escapeLikeString($search) . '%';
            }

            // combine where
            if (!empty($whereClauses)) {
                $mainSql .= " WHERE " . implode(' AND ', $whereClauses);
            }

            // --- Count total (for pagination) -> wrap main sql into count
            $countSql = "SELECT COUNT(*) AS total_count FROM ({$mainSql}) AS t";
            $countBinds = array_merge($mainBinds, $whereBinds); // mainBinds already contains recipientBinds + latestBinds + enq id
            // Note: we must append the whereBinds after because they correspond to placeholders in WHERE.
            //$countBinds = array_merge($countBinds, $whereBinds);

            $countQuery = $this->db->query($countSql, $countBinds);
            $totalRows = (int) ($countQuery->getRowArray()['total_count'] ?? 0);

            $totalPages = $totalRows > 0 ? (int) ceil($totalRows / $perPage) : 1;
            $offset = ($page - 1) * $perPage;

            // --- Final paged SQL: add ORDER + LIMIT
            $pagedSql = $mainSql;
            // same WHERE already applied
            $pagedSql .= " ORDER BY (wi.created_at IS NULL), wi.created_at DESC, r.type, r.company_name";
            $pagedSql .= " LIMIT ? OFFSET ?";

            // final binds: mainBinds + whereBinds + [perPage, offset]
            $finalBinds = array_merge($mainBinds, $whereBinds, [$perPage, $offset]);

            $rows = $this->db->query($pagedSql, $finalBinds)->getResultArray();

            // format response_time for UI and normalize phone (optional)
            foreach ($rows as &$r) {
                $r['response_time_formatted'] = $r['response_time'] ? date('d-m-Y h:i A', strtotime($r['response_time'])) : null;
                // keep fields consistent for front-end
                $r['notification'] = ($sendType === 'state' && $state) ? 'State-wise' : 'Pan India';
            }
            unset($r);



            return $this->response->setJSON([
                'status' => 'success',
            'count' => $totalRows,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => $totalPages,
            'data' => $rows
            ])->setStatusCode(200);

        } catch (\Throwable $e) {
            log_message('error', 'NotificationReport::tabData error - ' . $e->getMessage());
            log_message('raw query', $mainSql);
            log_message('raw binds', json_encode($mainBinds));
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error loading tab data'])->setStatusCode(500);
        }
    }


}
