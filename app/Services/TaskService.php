<?php

namespace App\Services;

use App\Libraries\Utility;
use GuzzleHttp\Exception\GuzzleException;

class TaskService extends BaseService
{
    /**
     *
     *
     * @param int $userId
     * @param string $apiToken
     * @param int|null $taskId
     * @param int $taskStatusId
     * @param string $title
     * @param string $content
     * @param bool $isDraft
     * @return array
     * @throws GuzzleException
     */
    public function saveTask(int $userId, string $apiToken, ?int $taskId, int $taskStatusId, string $title, string $content, bool $isDraft): array
    {
        $response = $this->client->request('POST', 'task', [
            'json' => [
                'user_id'        => $userId,
                'api_token'      => $apiToken,
                'task_id'        => $taskId,
                'task_status_id' => $taskStatusId,
                'title'          => $title,
                'content'        => $content,
                'is_draft'       => $isDraft
            ]
        ])->getBody()
          ->getContents();
        return json_decode($response, true);
    }

    /**
     *
     *
     * @param int $userId
     * @param string $apiToken
     * @param string|null $title
     * @param array|null $taskStatusIds
     * @return array
     */
    public function getTasks(int $userId, string $apiToken, ?string $title = null, ?array $taskStatusIds = []): array
    {
        try {
            $response = $this->client->request('GET', 'task', [
                'query' => [
                    'user_id'         => $userId,
                    'api_token'       => $apiToken,
                    'title'           => $title,
                    'task_status_ids' => $taskStatusIds
                ]
            ])->getBody()
              ->getContents();
            $response = json_decode($response, true);
            return data_get($response, 'data', []);
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
    public function getTrash(int $userId, string $apiToken): array
    {
        try {
            $response = $this->client->request('GET', 'task/trash', [
                'query' => [
                    'user_id'   => $userId,
                    'api_token' => $apiToken
                ]
            ])->getBody()
              ->getContents();
            $response = json_decode($response, true);
            return data_get($response, 'data', []);
        } catch (\Exception | GuzzleException $e) {
            return Utility::getResponse(false, 'Error!');
        }
    }

    /**
     *
     *
     * @param int $userId
     * @param int $taskId
     * @param string $apiToken
     * @return array
     */
    public function restoreTrash(int $userId, int $taskId, string $apiToken): array
    {
        try {
            $response = $this->client->request('POST', 'task/trash/restore', [
                'json' => [
                    'user_id'   => $userId,
                    'task_id'   => $taskId,
                    'api_token' => $apiToken
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
     * @param int $userId
     * @param int $taskId
     * @param string $apiToken
     * @return array
     */
    public function delete(int $userId, int $taskId, string $apiToken): array
    {
        try {
            $response = $this->client->request('DELETE', 'task', [
                'json' => [
                    'user_id'   => $userId,
                    'task_id'   => $taskId,
                    'api_token' => $apiToken
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
     * @return array
     */
    public function getTaskStatuses(): array
    {
        try {
            $response = $this->client->request('GET', 'task/status')
                                     ->getBody()
                                     ->getContents();
            $response = json_decode($response, true);
            return data_get($response, 'data', []);
        } catch (\Exception | GuzzleException $e) {
            return Utility::getResponse(false, 'Error!');
        }
    }
}
