<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use Config\App;
use App\Services\WhatsApp\DigitalSmsWhatsAppProvider;
use App\Services\WhatsApp\WhatsAppMessageService;
use App\Models\WhatsappInteractionModel;

class WhatsappMessageController extends BaseController
{
    protected $data = [];
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
}
