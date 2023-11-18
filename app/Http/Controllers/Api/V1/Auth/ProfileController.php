<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Auth
 */
class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        return response()->json(
            $request->user()->only('name', 'email')
        );
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        auth()->user()->update($request->validated());

        return response()->json(
            $request->validated(),
            Response::HTTP_ACCEPTED
        );
    }
}
