<?php

namespace App\Http\Controllers\Web;

use App\Libraries\Utility;
use App\Rules\RuleValidator;
use App\Rules\SaveTaskRule;
use App\Services\TaskService;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 *
 *
 */
class HomeController extends LoginController
{
    /**
     *
     *
     * @var TaskService
     */
    protected TaskService $taskService;

    /**
     *
     *
     * @param LoginService $loginService
     * @param TaskService $taskService
     */
    public function __construct(LoginService $loginService, TaskService $taskService)
    {
        parent::__construct($loginService);
        $this->taskService = $taskService;
    }

    /**
     *
     *
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTaskStatus(): JsonResponse
    {
        $response = $this->taskService->getTaskStatuses();
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
    public function getTask(Request $request): JsonResponse
    {
        $userId = session()->get('user_id');
        $apiToken = session()->get('api_token');
        $title = $request->get('title');
        $taskStatusIds = $request->get('task_status_ids');
        $response = $this->taskService->getTasks($userId, $apiToken, $title, $taskStatusIds);
        return response()->json($response);
    }

    /**
     *
     *
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function saveTask(SaveTaskRule $validation): JsonResponse
    {
        $userId = session()->get('user_id');
        $apiToken = session()->get('api_token');
        $taskId = request()->get('task_id');
        $title = request()->get('title');
        $taskStatusId = request()->get('task_status_id');
        $content = request()->get('content');
        $isDraft = (request()->get('is_draft') === "true");

        $validation = RuleValidator::validation($validation, request()->all());

        $response = (data_get($validation, 'status', false)) ?
            $this->taskService->saveTask($userId, $apiToken, $taskId, $taskStatusId, $title, $content, $isDraft) :
            Utility::getResponse(false, data_get($validation, 'message'));

        $status = data_get($response, 'status', false);
        $code = ($status) ? 200 : 403;

        return response()->json($response, $code);
    }

    /**
     *
     *
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function delete(Request $request): JsonResponse
    {
        $userId = session()->get('user_id');
        $taskId = $request->get('task_id');
        $apiToken = session()->get('api_token');
        $response = $this->taskService->delete($userId, $taskId, $apiToken);
        return response()->json($response);
    }

    /**
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function logout()
    {
        $userId = session()->get('user_id', 0);
        $apiToken = session()->get('api_token', '');
        session()->flush();
        $this->loginService->logout($userId, $apiToken);
        return redirect('/');
    }
}
