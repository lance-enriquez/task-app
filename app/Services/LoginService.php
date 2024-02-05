<?php

namespace App\Services;

use App\Libraries\Utility;
use GuzzleHttp\Exception\GuzzleException;

class LoginService extends BaseService
{
    /**
     *
     *
     * @param string $username
     * @param string $password
     * @return array
     */
    public function login(string $username, string $password): array
    {
        try {
            $response = $this->client->request('POST', 'user/verify', [
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

    /**
     *
     *
     * @param int $userId
     * @param string $apiToken
     * @return array
     */
    public function logout(int $userId, string $apiToken): array
    {
        try {
            $response = $this->client->request('POST', 'user/invalidate', [
                'json' => [
                    'user_id'   => $userId,
                    'api_token' => $apiToken
                ]
            ])->getBody()
              ->getContents();
            return json_decode($response, true);
        } catch (\Exception | GuzzleException $e) {
            return Utility::getResponse(false, 'Error!');
        }
    }
}
