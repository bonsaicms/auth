<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse as FailedPasswordResetLinkRequestResponseContract;

class FailedPasswordResetLinkRequestResponse implements FailedPasswordResetLinkRequestResponseContract
{
    use Traits\MapPasswordStatusToHttpCode;

    protected $passwordStatusHttpCodeMap = [
        Password::INVALID_USER => Response::HTTP_NO_CONTENT,
        Password::RESET_THROTTLED => Response::HTTP_TOO_MANY_REQUESTS,
    ];
}
