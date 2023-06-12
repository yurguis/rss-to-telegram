<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Feed;

use Laminas\Feed\Reader\Http\ClientInterface;
use Laminas\Feed\Reader\Http\Response;
use Laminas\Feed\Reader\Http\ResponseInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Client implements ClientInterface
{
    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function get($uri): ResponseInterface
    {
        $response = HttpClient::create()->request("GET", $uri, ['timeout' =>  180]);

        $headers = [];
        foreach ($response->getHeaders(false) as $name => $value) {
            $headers[$name] = array_shift($value);
        }

        return new Response(
            $response->getStatusCode(),
            $response->getContent(false),
            $headers
        );
    }
}