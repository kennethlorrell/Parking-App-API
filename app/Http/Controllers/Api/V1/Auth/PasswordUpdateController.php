<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordUpdateController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request): JsonResponse
    {
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('validation.current_password')
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return response()->json([
            'message' => __('messages.password_successfully_updated'),
        ], Response::HTTP_ACCEPTED);
    }
}
