<?php

namespace App\Services\WhatsApp;

use App\Services\WhatsApp\WhatsAppException;
use Throwable;
use App\Libraries\RateLimiter;

class WhatsAppMessageService
{
    protected WhatsAppProviderInterface $provider;
    protected int $maxRetries = 3; // per message attempt

    public function __construct(WhatsAppProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Send WhatsApp messages for each enquiry item.
     *
     * @param string $recipient   Recipient phone number
     * @param array  $enquiryItems Array of items
     * @return array Results (success/failure) for each item
     */
    public function sendEnquiryMessages(array $recipients, array $enquiryItems): array
    {

        $allResults = [];

        foreach ($recipients as $recipient) {
            $results = [];

            if (!preg_match('/^[0-9]{10}$/', $recipient)) {
                log_message('error', "Invalid mobile skipped: {$recipient}");
                continue; // skip this number
            }


            foreach ($enquiryItems as $index => $item) {
                try {
                    $text     = $this->formatMessage($item);
                    $mediaUrl = json_decode($item['media_url'], true) ?: [];

                    $relevantData = [
                        'enquiry_id' => $item['enquiry_id'],
                        'product_id' => $item['enquiry_product_id'],
                    ];


                    $appUrl = getenv('app.baseURL');
                    $buildImgUrl = $appUrl . 'public/uploads/enquiry/' . $mediaUrl[0];



                    $sendResult = $this->provider->send($recipient, $text, $buildImgUrl, $relevantData);

                    $results[] = [
                        'item_index' => $index,
                        'recipient'  => $recipient,
                        'status'     => 'success',
                        'result'     => $sendResult,
                    ];
                } catch (WhatsAppException $e) {
                    log_message('error', "[WhatsApp] Failed sending to {$recipient}, item {$index}: " . $e->getMessage());

                    $results[] = [
                        'item_index' => $index,
                        'recipient'  => $recipient,
                        'status'     => 'failed',
                        'error'      => $e->getMessage(),
                        'provider_response' => $e->getProviderResponse(),
                    ];
                }

            }


            $allResults[$recipient] = $results;
        }

        return $allResults;

    }

    protected function formatMessage(array $item): string
    {
        return "Hello Buyer Partner \n"
             . "🚨 Have a look at New Deals open\n"
             . "for you today\n\n"
             . "📦 *Material*: {$item['material']}\n"
             . "⚖️ *Quantity*: {$item['qty']} {$item['unit_name']}\n"
             . "📍 *Location*: {$item['district']}, {$item['state']}\n"
             . "🪙 *Price Range*: ₹{$item['price_range']}\n\n"
             . "For More Details,\n"
             . "🔗 Please download our APP:\n"
             . "https://play.google.com/store/apps/details?id=com.ecoexvendor.keyline \n\n"
             . "📞 Helpline:  +911140346015";
    }

    public function sendWithRetry(string $recipient, array $enquiryItems, int $jobId)
    {

        $failedModel = new \App\Models\WhatsappFailedPayloadModel();

        $jobModel = new \App\Models\WhatsAppWorkerModel();

        $rateLimiter = new RateLimiter(); // <-- instantiate once




        $messageResults = [];
        $recipientFailed = false;

        foreach ($enquiryItems as $item) {
            try {


                $attempts = 0;
                $sent     = false;
                $error    = null;

                $sendResult = false; // initialize before retry loop

                $relevantData = [
                                        'enquiry_id' => $item['enquiry_id'],
                                        'product_id' => $item['enquiry_product_id'],
                                    ];




                /*if (!preg_match('/^[0-9]{10}$/', $recipient)) {
                    log_message('error', "Invalid mobile skipped: {$recipient}");
                    continue; // skip this number
                }*/


                $text     = $this->formatMessage($item);
                $mediaUrl = json_decode($item['media_url'], true) ?: [];


                $appUrl = getenv('app.baseURL');
                //$buildImgUrl = $appUrl . 'public/uploads/enquiry/' . $mediaUrl[0];

                $buildImgUrl = isset($mediaUrl[0]) ? $appUrl . 'public/uploads/enquiry/' . $mediaUrl[0] : null;




                while ($attempts < $this->maxRetries && !$sent) {
                    $attempts++;

                    // 🧩 RATE LIMITER HERE
                    $rateLimiter->throttle('whatsapp_api', 1, 1);
                    // means: max 1 request per second globally

                    try {

                        $sendResult = $this->provider->send($recipient, $text, $buildImgUrl, $relevantData);

                        if ($sendResult['success'] === true) {
                            $sent = true;
                        }

                    } catch (WhatsAppException $e) {
                        $sent = false;
                        log_message('error', "[WhatsApp] Failed sending to {$recipient}, attempt {$attempts}: " . $e->getMessage());

                        sleep(pow(2, $attempts)); // backoff: 2s, 4s, 8s


                        $error = $e->getMessage();
                    }
                }


                if (!$sent) {

                    $recipientFailed = true;

                    // Build the payload we want to retain for retry (replayable)
                    $failedPayload = [
                        'job_id'    => $jobId,
                        'recipient' => $recipient,
                        'payload'   => json_encode([
                            'item'     => $item,
                            'message'  => $text,
                            'mediaUrl' => $buildImgUrl,
                        ]),
                        'attempts'  => $attempts,
                        'last_error' => $error,
                        'created_at' => date('Y-m-d H:i:s'),
                        'item_id' => $item['enquiry_product_id'],
                    ];


                    // save via model
                    try {


                        $existing = $failedModel
                            ->where('job_id', $jobId)
                            ->where('recipient', $recipient)
                            ->where('item_id', $item['enquiry_product_id'])
                            ->first();

                        if ($existing) {

                            // retry failed again → update attempts + error
                            $failedModel->update($existing['id'], [
                                'attempts'   => $existing['attempts'] + 1,
                                'last_error' => $error,
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);

                        } else {

                            $failedModel->insert($failedPayload);

                        }



                        // Increment failed counter in job

                        $jobModel->set('failed', 'failed+1', false)
                                 ->where('id', $jobId)
                                 ->update();

                    } catch (\Exception $dbEx) {
                        // log DB failures but do not stop processing
                        log_message('error', "Failed to insert failed_payloads for {$recipient}: " . $dbEx->getMessage());
                    }


                }


            } catch (Throwable $th) {


                log_message('error', "Failed to insert failed_payloads for {$recipient} item id {$item['enquiry_product_id']}: " . $th->getMessage());


            }



            $messageResults[] = [
                'message'  => $text,
                'sent'     => $sendResult,
                'attempts' => $attempts,
                'error'    => $error,
            ];
            //end foreach items
        }

        return [
            'recipient' => $recipient,
            'status'    => $recipientFailed ? 'partial_failed' : 'success',
            'messages'  => $messageResults,
        ];


    }
}
