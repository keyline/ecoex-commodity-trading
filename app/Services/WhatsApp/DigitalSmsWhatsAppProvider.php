<?php

namespace App\Services\WhatsApp;

class DigitalSmsWhatsAppProvider implements WhatsAppProviderInterface
{
    protected string $apiKey;
    protected string $baseUrl;


    public function __construct()
    {
        $this->apiKey  = getenv('whatsapp.digitalsms.api_key');   // e.g. abc123
        $this->baseUrl = getenv('whatsapp.digitalsms.base_url');   // e.g. https://yourdomain.com/api

    }

    public function send(string $to, string $text, ?string $mediaUrl = null): array
    {
        try {
            if (empty($this->apiKey) || empty($this->baseUrl)) {
                throw new WhatsAppException("WhatsApp API configuration missing.");
            }

            // Append media link if provided
            $msg = $text;
            /*if ($mediaUrl) {
                $img = "&img1=" . $mediaUrl;
            }*/

            $client = \Config\Services::curlrequest([
                'verify' => false,
                'timeout' => 30,
            ]);

            $params = [
                    'apikey' => $this->apiKey,
                    'mobile' => $to,
                    'msg'    => $msg,
                    //'img1'   => $mediaUrl ?? '',
                ];

            $response = $client->get($this->baseUrl, [
                'query' => $params
            ]);


            /*$ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);

            if ($resp === false) {
                $error = curl_error($ch);
                curl_close($ch);
                throw new WhatsAppException("cURL error: " . $error);
            }

            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);*/

            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                throw new WhatsAppException("API returned HTTP {$response->getStatusCode()}: {$response->getBody()}");
            }

            // If API returns JSON with status
            $json = json_decode($response->getBody(), true);
            if (is_array($json) && isset($json['status']) && $json['status'] !== 'success') {
                throw new WhatsAppException("API error: " . ($json['message'] ?? 'Unknown'));
            }
            //$reason = $response->getReasonPhrase();


            return [
                'success' => true,
                'provider_id' => $json['id'] ?? null,
                'response' => $response->getBody(),
            ];

        } catch (\Throwable $e) {

            log_message('error', "Requesting: " . $this->baseUrl . '?' . http_build_query($params));

            log_message('error', "[WhatsApp] Failed sending to {$to}: params " . json_encode($params) . ", error: " . $e->getMessage());
            log_message('error', "[WhatsApp] Full response: " . (json_encode($response->getBody()) ?? 'no response'));
            throw new WhatsAppException("Failed to send WhatsApp: " . $e->getMessage(), 0, $e);
        }
    }
}
