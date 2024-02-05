<?php

namespace App\Libraries;

/**
 *
 *
 */

class Utility
{
    /**
     * Formats a JsonResponse to an HTTP request.
     *
     * @param bool|null $status
     * @param string|null $message
     * @param array|null $data
     * @return array
     */
    public static final function getResponse(bool $status, ?string $message = 'Failed!', ?array $data = []):array
    {
        $response = [
            'status'  => $status,
            'message' => ($status) ? 'Success!' : $message
        ];
        return empty($data) ? $response : array_merge($response, ['data' => $data]);
    }
}
