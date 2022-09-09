<?php

namespace App\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ResponseHelper
{
    /**
     * @description Return response
     *
     * @param $message
     * @param $code
     * @param array|null $body
     * @return JsonResponse
     */
    public function setResponse($message, $code, array $body = null): JsonResponse
    {
        $response = [
            'message' => $message,
            'code' => $code
        ];
        if (isset($body)) {
            $response['data'] = $body;
        }
        return response()->json($response);
    }

    /**
     * @description Return not found response
     *
     * @return JsonResponse
     */
    public function responseNotFound(): JsonResponse
    {
        return $this->setResponse(
            config('constant.message.not_found'),
            config('constant.status.not_found')
        );
    }

    /**
     * @description Return fail response
     *
     * @return JsonResponse
     */
    public function responseFail(): JsonResponse
    {
        return $this->setResponse(
            config('constant.message.fail'),
            config('constant.status.error')
        );
    }

    /**
     * @description Return exception response
     *
     * @return JsonResponse
     */
    public function responseException($exception): JsonResponse
    {
        Log::info($exception);
        return $this->setResponse(
            config('constant.message.exception'),
            config('constant.status.error')
        );
    }

    /**
     * @description Return success response
     *
     * @param null $data
     * @return JsonResponse
     */
    public function responseSuccess($data = null): JsonResponse
    {
        return $this->setResponse(
            config('constant.message.success'),
            config('constant.status.success'),
            $data
        );
    }
}
