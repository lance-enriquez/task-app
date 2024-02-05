<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Libraries\Utility;
use Illuminate\Support\Arr;
use \Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 *
 *
 *
 */
class UserController
{
    /**
     *
     *
     * @var User
     */
    protected User $user;

    /**
     *
     * UserController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
            $username = $request->json('username');
            $password = $request->json('password');
            $status = $this->user->saveUser($username, $password);
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
    public function getUser(Request $request): JsonResponse
    {
        try {
            $userId = $request->get('user_id');
            $user = $this->user->getUserWithId($userId);
            $status = (!empty($user)) ?
                Utility::getResponse(true, null, $user->toArray()) :
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
    public function verify(Request $request): JsonResponse
    {
        try {
            $username = $request->json('username');
            $password = $request->json('password');
            $user = $this->user->checkPassword($username, $password);

            if (!is_null($user)) {
               $userId = Arr::get($user, 'user_id');
               return response()->json(Utility::getResponse(true, null, array_merge($user->toArray(), [
                    'api_token' => $this->user->generateApiToken($userId)
                ])));
            }

            return response()->json(Utility::getResponse(false));
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
    public function invalidate(Request $request): JsonResponse
    {
        try {
            $userId = $request->json('user_id');
            $apiToken = $request->json('api_token');
            $status = $this->user->validateApiToken($userId, $apiToken);

            if ($status) {
                $status = $this->user->clearApiToken($userId);
                return response()->json(Utility::getResponse($status));
            }

            return response()->json(Utility::getResponse(false));
        } catch (\Exception $e) {
            return response()->json(Utility::getResponse(false, $e->getMessage()));
        }
    }
}
