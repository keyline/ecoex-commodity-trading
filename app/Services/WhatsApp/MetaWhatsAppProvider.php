<?php

namespace App\Services\WhatsApp;

use Config\Services;

class MetaWhatsAppProvider implements WhatsAppProviderInterface
{
    protected string $baseUrl;
    protected string $phoneNumberId;
    protected string $accessToken;
    protected string $graphVersion;

    public function __construct()
    {


        $this->baseUrl = getenv('whatsapp.shuvadeep.base_url');
        $this->phoneNumberId = getenv('whatsapp.shuvadeep.phone_number_id');
        $this->accessToken = getenv('whatsapp.shuvadeep.access_token');
        $this->graphVersion = getenv('whatsapp.shuvadeep.graph_version') ?: 'v13.0';
    }

    public function send(string $to, string $text, ?string $mediaUrl = null, $data = []): array
    {
        try {
            if (empty($this->accessToken) || empty($this->baseUrl) || empty($this->phoneNumberId) || empty($this->graphVersion)) {
                throw new WhatsAppException("WhatsApp API configuration missing.");
            }


            // ✅ Build payload (from Meta sample)
            $payload = [
                'messaging_product' => 'whatsapp',
                'recipient_type'    => 'individual',
                'to'                => $to,
                'type'              => 'interactive',
                'interactive'       => [
                    'type'   => 'button',
                    'header' => [
                        'type'  => 'image',
                        'image' => [
                            // use provided media id or fallback
                            'link' =>  $mediaUrl ?: '' ,//'https://commodity.ecoex.market/public/uploads/enquiry/68d7b8c93d071.jpg' //
                        ],
                    ],
                    'body'   => [
                        'text' => $text
                    ],
                    'footer' => [
                        'text' => ''
                    ],
                    'action' => [
                        'buttons' => [
                            [
                                'type'  => 'reply',
                                'reply' => [
                                    'id'    => $data['enquiry_id'] .'_'. $data['product_id'] . '_interested',
                                    'title' => 'Interested',
                                ],
                            ],
                            [
                                'type'  => 'reply',
                                'reply' => [
                                    'id'    => $data['enquiry_id'] .'_'. $data['product_id'] .'_notinterested',
                                    'title' => 'Not Interested',
                                ],
                            ],
                        ],
                    ],
                ],
            ];

            // ✅ Send request using CodeIgniter HTTP client
            $client = Services::curlrequest();


            $response = $client->post($this->baseUrl . '/' . $this->graphVersion . '/' . $this->phoneNumberId . '/messages', [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => $payload,
                            'http_errors' => false, // prevent exceptions on 4xx/5xx
                        ]);

            $body = $response->getBody();
            $json = json_decode($body, true);


            return [
                            'success'     => $response->getStatusCode() >= 200 && $response->getStatusCode() < 300,
                            'provider_id' => $json['messages'][0]['id'] ?? null,
                            'response'    => $body,
                        ];



        } catch (\Throwable $th) {

            log_message('error', 'WhatsApp Send Error: ' . $th->getMessage());

            return [
                'success' => false,
                'error'   => $th->getMessage(),
            ];
        }

        return [];
    }
}
