<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use BonsaiCms\Auth\FetchUserResponseContract;

class FetchUserResponse implements FetchUserResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request) {
        return new JsonResponse([
            'user' => $request->user()
        ], 200);
    }
}
