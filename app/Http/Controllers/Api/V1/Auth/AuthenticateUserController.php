<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticateUserController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = User::whereEmail($request->email)->firstOrFail();
        $user['role'] = $user->getRoleNames()->toArray()[0];

        if (!$user->hasVerifiedEmail()) {
            return response()->json(
                [
                    'message' => 'Your email address is not verified.'
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        $token = $user->createToken('auth-token of ' . $user->name);

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' =>  "You have been logged out and no longer have access token"
        ]);
    }
}
