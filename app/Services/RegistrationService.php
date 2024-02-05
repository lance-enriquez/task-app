<?php

namespace App\Services;

use App\Libraries\Utility;
use GuzzleHttp\Exception\GuzzleException;

class RegistrationService extends BaseService
{
    /**
     *
     *
     * @param string $username
     * @param string $password
     * @return array
     */
    public function register(string $username, string $password): array
    {
        try {
            $response = $this->client->request('POST', 'user/save', [
                'json' => [
                    'username' => $username,
                    'password' => $password
                ]
            ])->getBody()
              ->getContents();
            return json_decode($response, true);
        } catch (\Exception | GuzzleException $e) {
            return Utility::getResponse(false, 'Error!');
        }
    }
}
