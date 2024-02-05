<?php

namespace App\Http\Controllers\Api;

use App\Libraries\Utility;
use App\Models\TaskStatus;
use Illuminate\Http\JsonResponse;

class TaskStatusController
{
    /**
     *
     *
     * @return JsonResponse
     */
    public function getTaskStatus(): JsonResponse
    {
        try {
            $response = TaskStatus::getTaskStatus()->toArray();
            return response()->json(Utility::getResponse(true, null, $response));
        } catch (\Exception $e) {
            return response()->json(Utility::getResponse(false));
        }
    }
}
