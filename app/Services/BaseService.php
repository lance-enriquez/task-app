<?php

namespace App\Services;

use GuzzleHttp\Client;

abstract class BaseService
{
    /**
     * Client object.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * BaseService constructor.
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('API_URL') . '/api']);
    }
}
