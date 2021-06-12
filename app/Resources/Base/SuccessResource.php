<?php

namespace App\Resources\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SuccessResource extends JsonResource
{
    public static $wrap = false;
    private $message;
    private $code;

    /**
     * FailureResource constructor.
     *
     * @param $resource
     * @param string $message
     * @param int    $code
     */
    public function __construct($resource, $message = '', $code = Response::HTTP_OK)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->resource && is_array($this->resource) && isset($this->resource['data']) ?
            $this->resource : ['data' => $this->resource];

        if ($this->message && !empty($this->message)) {
            return array_merge(
                [
                'message' => $this->message,
                ],
                $data
            );
        }

        return $data;
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->code);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
