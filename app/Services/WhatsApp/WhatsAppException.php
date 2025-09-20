<?php

namespace App\Services\WhatsApp;

use RuntimeException;
use Throwable;

/**
 * Class WhatsAppException
 *
 * Thrown when provider or service encounters an error while sending messages.
 * Keeps optional provider response for debugging/audit.
 */
class WhatsAppException extends RuntimeException
{
    /**
     * Raw response returned by provider (string/array|null)
     *
     * @var mixed
     */
    protected mixed $providerResponse;

    /**
     * WhatsAppException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param mixed $providerResponse
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, mixed $providerResponse = null)
    {
        parent::__construct($message, $code, $previous);
        $this->providerResponse = $providerResponse;
    }

    /**
     * Get raw provider response (if any).
     *
     * @return mixed
     */
    public function getProviderResponse(): mixed
    {
        return $this->providerResponse;
    }

    /**
     * Useful for structured logging.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'provider_response' => $this->providerResponse,
            'trace' => $this->getTraceAsString(),
        ];
    }
}
