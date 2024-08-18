<?php

namespace App\Utils;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Psr\Http\Message\ResponseInterface;

class HttpUtil
{
    protected $client;

    public function __construct($config = [])
    {
        $this->client = new \GuzzleHttp\Client($config);
    }

    private function handleErrorResponse(ClientException $e)
    {
        $response = $e->getResponse();
        $body = $response->getBody();

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Invalid HTTP response.',
            'errors' => json_decode($body->getContents())
        ], $response->getStatusCode()));
    }

    /**
     * Send a GET request.
     *
     * @param string $url
     * @param array $queryParams
     * @return ResponseInterface|HttpResponseException
     */
    public function get(string $url, array $queryParams = []): ?ResponseInterface
    {
        try {
            return $this->client->request('GET', $url, [
                'query' => $queryParams,
            ]);
        } catch (ClientException $e) {
            $this->handleErrorResponse($e);
        }
    }
}
