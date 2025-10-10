<?php

namespace App\Libraries;

use Config\Services;

class RateLimiter
{
    /**
     * Throttle API calls globally.
     *
     * @param string $key Unique key for the API or route, e.g. 'whatsapp_api'
     * @param int    $limit Number of allowed requests
     * @param int    $seconds Time window in seconds
     */
    public function throttle(string $key, int $limit, int $seconds): void
    {
        $cache = Services::cache();
        $now = time();

        $data = $cache->get($key);

        if (!$data) {
            // Initialize new rate window
            $data = [
                'count' => 1,
                'start' => $now,
            ];
            $cache->save($key, $data, $seconds);
            return;
        }

        // Within same window
        if (($now - $data['start']) < $seconds) {
            if ($data['count'] >= $limit) {
                // Wait until window resets
                $sleep = $seconds - ($now - $data['start']);
                log_message('info', "[RateLimiter] Throttling {$key}, sleeping {$sleep}s...");
                sleep($sleep);
                $cache->delete($key); // reset window
                return;
            }

            // Increment count
            $data['count']++;
            $cache->save($key, $data, $seconds);
        } else {
            // Expired window → reset
            $cache->save($key, ['count' => 1, 'start' => $now], $seconds);
        }
    }
}
