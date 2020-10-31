<?php

namespace App\Http\Responses\Traits;

use Illuminate\Http\Response;

trait MapPasswordStatusToHttpCode
{
    /**
     * The response status language key.
     *
     * @var string
     */
    protected $status;

    protected $fallbackHttpCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * Create a new response instance.
     *
     * @param  string  $status
     * @return void
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return new Response('', $this->resolveHttpStatus());
    }

    protected function resolveHttpStatus()
    {
        return $this->passwordStatusHttpCodeMap[$this->status] ?: $this->fallbackHttpCode;
    }
}
