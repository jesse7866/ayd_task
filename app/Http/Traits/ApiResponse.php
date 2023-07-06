<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

trait ApiResponse
{
    /**
     * Http Code
     * @var int
     */
    protected int $statusCode = ResponseCode::HTTP_OK;

    /**
     * Set http response code
     *
     * @param int $responseCode
     */
    public function setStatusCode(int $responseCode)
    {
        $this->statusCode = $responseCode;

        return $this;
    }

    /**
     * Respond with a created response and associate a location if provided.
     *
     * @param null|string $location
     * @param null $content
     * @return Response
     */
    public function created(string $location = null, $content = null): Response
    {
        $response = new Response($content);
        $response->setStatusCode(ResponseCode::HTTP_CREATED);

        if (!is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Respond with a no content response.
     *
     * @return Response
     */
    public function noContent(): Response
    {
        $response = new Response(null);

        return $response->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }

    /**
     * Return a json response.
     *
     * @param string $msg message
     * @param mixed $data
     * @param array $headers
     * @return Response
     */
    public function success(mixed $data, string $msg = 'success', array $headers = []): Response
    {
        $content['code'] = 0;

        if (!is_array($data)) {
            if ($data instanceof Collection) {
                $data = $data->toArray();
            } elseif (is_object($data)) {
                $data = (object)$data;
            } elseif (empty($data) || count($data) == 0) {
                $data = new \stdClass();
            } else {
                $data = 'Data format is must be Collection 、 Array or Object';
            }
        } elseif (empty($data) || count($data) == 0) {
            $data = new \stdClass();
        }

        $content['msg'] = $msg;
        $content['data'] = $data;

        $response = new Response($content, ResponseCode::HTTP_OK, $headers);

        return $response->withHeaders(['Content-type' => 'application/json; charset=utf-8']);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param int $code
     * @param array $data
     * @return void
     */
    public function error(string $message, int $code = Response::HTTP_BAD_REQUEST, array $data = [])
    {
        $response = response([
            'code'    => $code,
            'message' => $message,
            'data'    => empty($data) ? new \stdClass() : $data
        ]);
        if ($this->statusCode) {
            $response = $response->setStatusCode($this->statusCode);
        }

        throw new HttpResponseException($response);
    }
}
