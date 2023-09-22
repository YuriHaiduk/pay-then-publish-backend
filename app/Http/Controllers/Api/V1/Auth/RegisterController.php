<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\UserRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserRegisterRequest $request): JsonResponse
    {
        $userData = $request->validated();

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'role_id' => Role::ROLE_CLIENT
        ]);

        return response()->json([
            'access_token' => $user->createToken('client')->plainTextToken,
        ],Response::HTTP_CREATED);
    }
}
