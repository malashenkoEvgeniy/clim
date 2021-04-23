<?php

namespace App\Helpers;

use GuzzleHttp\Client as cURL;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Emitter
 *
 * @package App\Helpers
 */
class Emitter
{
    
    /**
     * Send request by method GET
     *
     * @param string $endpoint
     * @return mixed
     */
    public static function get(string $endpoint)
    {
        $curl = new cURL();
        $response = $curl->get($endpoint);
        return static::generateAnswer($response);
    }
    
    /**
     * Send request by method POST
     *
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    public static function post(string $endpoint, array $data = [])
    {
        $curl = new cURL();
        $response = $curl->get($endpoint, $data);
        return static::generateAnswer($response);
    }
    
    /**
     * Generate answer to use from string in body
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    private static function generateAnswer(ResponseInterface $response)
    {
        return json_decode((string)$response->getBody(), 1);
    }
    
}
