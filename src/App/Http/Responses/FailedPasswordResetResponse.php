<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\FailedPasswordResetResponse as FailedPasswordResetResponseContract;

class FailedPasswordResetResponse implements FailedPasswordResetResponseContract
{
    use Traits\MapPasswordStatusToHttpCode;

    protected $passwordStatusHttpCodeMap = [
        Password::INVALID_USER => Response::HTTP_BAD_REQUEST,
        Password::INVALID_TOKEN => Response::HTTP_BAD_REQUEST,
    ];
}
