<?php

declare(strict_types=1);

namespace WolfShop\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use WolfShop\Http\Controllers\Controller;
use WolfShop\Http\Requests\Api\LoginUserRequest;
use WolfShop\Repositories\Eloquent\UserRepository;

class AuthController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
       //
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials.',
                'status' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->userRepository->findByEmail($request->input('email'));

        return response()->json([
            'message' => 'Authenticated.',
            'data' => [
                'token' => $this->userRepository->createPlainTextToken($user),
            ],
            'status' => Response::HTTP_OK,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json();
    }
}
