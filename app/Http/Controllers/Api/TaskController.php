<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Libraries\Utility;
use \Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 *
 *
 */
class TaskController
{
    /**
     *
     * @var Task
     */
    protected Task $task;

    /**
     * TaskController constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
        try {
            $userId = $request->json('user_id');
            $taskId = $request->json('task_id');
            $taskStatusId = $request->json('task_status_id');
            $title = $request->json('title');
            $content = $request->json('content');
            $isDraft = $request->json('is_draft');
            $status = $this->task->saveTask($userId, $taskId, $taskStatusId, $title, $content, $isDraft);
            return response()->json(Utility::getResponse($status));
        } catch (\Exception $e) {
            $message = ($e->getCode() === '23000') ? 'Duplicate entry!' : $e->getMessage();
            return response()->json(Utility::getResponse(false, $message));
        }
    }

    /**
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTasks(Request $request): JsonResponse
    {
        try {
            $userId = $request->get('user_id');
            $title = $request->get('title');
            $taskStatusIds = $request->get('task_status_ids', []);
            $tasks = $this->task->getUserTasks($userId, $title, $taskStatusIds)->toArray();
            $response = (!empty($tasks)) ?
                Utility::getResponse(true, null, $tasks) :
                Utility::getResponse(false);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(Utility::getResponse(false, $e->getMessage()));
        }
    }

    /**
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTrash(Request $request): JsonResponse
    {
        try {
            $userId = $request->get('user_id');
            $tasks = $this->task->getUserTrashTasks($userId)->toArray();
            $status = (!empty($tasks)) ?
                Utility::getResponse(true, null, $tasks) :
                Utility::getResponse(false);
            return response()->json($status);
        } catch (\Exception $e) {
            return response()->json(Utility::getResponse(false, $e->getMessage()));
        }
    }

    /**
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $userId = $request->json('user_id');
            $taskId = $request->json('task_id');
            $status = $this->task->deleteTask($userId, $taskId);
            return response()->json(Utility::getResponse($status));
        } catch (\Exception $e) {
            return response()->json(Utility::getResponse(false, $e->getMessage()));
        }
    }

    /**
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(Request $request): JsonResponse
    {
        try {
            $userId = $request->json('user_id');
            $taskId = $request->json('task_id');
            $status = $this->task->restoreTask($userId, $taskId);
            return response()->json(Utility::getResponse($status));
        } catch (\Exception $e) {
            return response()->json(Utility::getResponse(false, $e->getMessage()));
        }
    }
}
