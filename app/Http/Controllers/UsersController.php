<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Http\services\UserService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UsersController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    /**
     * @param UserStoreRequest $request
     * @return ResponseFactory|Response
     */
    public function store(UserStoreRequest $request)
    {
        $response = $this->userService->createUser($request->validated());

        return response(new UserResource($response), 201);
    }
}
