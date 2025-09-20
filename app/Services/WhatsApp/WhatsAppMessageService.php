<?php

namespace App\Services\WhatsApp;

class WhatsAppMessageService
{
    protected WhatsAppProviderInterface $provider;

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

            foreach ($enquiryItems as $index => $item) {
                try {
                    $text     = $this->formatMessage($item);
                    $mediaUrl = json_decode($item['media_url'], true) ?: [];


                    $appUrl = getenv('app.baseURL');
                    $buildImgUrl = $appUrl . 'public/uploads/enquiries/' . $mediaUrl[0];



                    $sendResult = $this->provider->send($recipient, $text, $buildImgUrl);

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
        return "ECOEX Alerts 🚨\n"
             . "New Scrap Deal Available\n\n"
             . "📦 *Material*: {$item['material']}\n"
             . "⚖️ *Quantity*: {$item['qty']}\n"
             . "📍 *Location*: {$item['district']}, {$item['state']}\n"
             . "💰 *Price Range*: {$item['price_range']}/{$item['unit_name']}\n\n";
    }
}
