<?php

namespace App\Http\Controllers\Web;

use App\Libraries\Utility;
use App\Rules\RegistrationFormRule;
use App\Rules\RuleValidator;
use App\Services\RegistrationService;

class RegistrationController
{
    /**
     *
     *
     * @var RegistrationService
     */
    protected RegistrationService $registrationService;

    /**
     * RegistrationController constructor.
     *
     * @param RegistrationService $registrationService
     */
    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     *
     *
     * @param RegistrationFormRule $validation
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function register(RegistrationFormRule $validation): mixed
    {
        $username = request()->get('username');
        $password = request()->get('password');

        $validation = RuleValidator::validation($validation, request()->all());

        $response = (data_get($validation, 'status', false)) ?
            $this->registrationService->register($username, $password) :
            Utility::getResponse(false, data_get($validation, 'message'));

        $status = data_get($response, 'status', false);
        $path = ($status) ? '/' : 'register';

        return redirect($path);
    }
}
