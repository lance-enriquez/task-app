<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrashController extends HomeController
{
    /**
     *
     *
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getTrash(): JsonResponse
    {
        $userId = session()->get('user_id');
        $apiToken = session()->get('api_token');
        $response = $this->taskService->getTrash($userId, $apiToken);
        return response()->json($response);
    }

    /**
     *
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function restoreTrash(Request $request): JsonResponse
    {
        $userId = session()->get('user_id');
        $taskId = $request->get('task_id');
        $apiToken = session()->get('api_token');
        $response = $this->taskService->restoreTrash($userId, $taskId, $apiToken);
        return response()->json($response);
    }
}
