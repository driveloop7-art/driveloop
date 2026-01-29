<?php

namespace App\Modules\Api\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Verified;
use App\Modules\Api\Response\ApiResponser;

class VerifyEmailController extends Controller
{
    use ApiResponser;

    public function sendNotification(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->success(null, __('Email already verified'));
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->success(null, __('Email verification link sent'));
    }

    public function verifyNotification(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->success(null, __('Email already verified'));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->success(null, __('Email verified'));
    }
}