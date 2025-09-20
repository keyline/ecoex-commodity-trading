<?php

namespace App\Services\WhatsApp;

interface WhatsAppProviderInterface
{
    /**
     * Send a WhatsApp message to a recipient.
     * @param string $to        Recipient phone number (E.164 format, e.g., +919812345678)
     * @param string $text      Message body (can include emojis, line breaks)
     * @param string|null $mediaUrl Optional image/media URL
     * @return array ['success' => bool, 'provider_id' => ?string, 'error' => ?string]
     */
    public function send(string $to, string $text, ?string $mediaUrl = null): array;
}
