<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Http\Requests\RegisterRequest; // Assume you've created a form request for validation
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $userDTO = UserDTO::fromRegisterRequest($request->validated());
        $result = $this->authService->register($userDTO);

        return response()->json(['data' => $result], Response::HTTP_CREATED);
        
    }}
