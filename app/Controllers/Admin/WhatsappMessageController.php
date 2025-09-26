<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use Config\App;
use App\Services\WhatsApp\DigitalSmsWhatsAppProvider;
use App\Services\WhatsApp\WhatsAppMessageService;

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
}
