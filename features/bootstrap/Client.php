<?php

declare(strict_types=1);

namespace Test;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;
use Test\Exception\ResponseWithErrorsException;
use GuzzleHttp\Exception\ClientException;

class Client
{
    private $guzzleClient;
    private $lastResponse;

    const THROW_IF_ERRORS = true;
    const DONT_THROW_IF_ERRORS = false;

    private function __construct(array $options)
    {
        $this->guzzleClient = new Guzzle($options);
    }

    public static function buildWithUrl(string $baseUrl): self
    {
        return new self([
            'base_uri' => $baseUrl,
            'connection_timeout' => 5,
        ]);
    }

    private function request(
        string $method,
        string $path,
        array $queryPraams,
        array $bodyParams,
        bool $throwIfErrors = self::THROW_IF_ERRORS
    ) {
        try {
            $response = $this->guzzleClient->request($method, $path, [
                'query' => $queryParams,
                'json' => $bodyParams,
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();

            $this->lastResponse = $response;
            if ($throwIfErrors) {
                throw $e;
            }
        }
        $this->lastResponse = $response;

        return $this->lastResponse;
    }

    public function get(
        string $path,
        array $queryParams = [],
        bool $throwIfErrors = self::THROW_IF_ERRORS
    ) {
        return $this->request(
            Request::METHOD_GET,
            $path,
            $queryParams,
            [],
            $throwIfErrors
        );
    }

    public function post(
        string $path,
        array $bodyParams = [],
        bool $throwIfErrors = self::THROW_IF_ERRORS
    ) {
        return $this->request(
            Request::METHOD_POST,
            $path,
            [],
            $bodyParams,
            $throwIfErrors
        );
    }

    public function decodeLastResponse()
    {
        return $this->decodeResponse($this->lastResponse);
    }

    public function decodeResponse(Response $response)
    {
        return json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
    }

    public function getLastResponseCode(): int
    {
        return $this->lastResponse->getStatusCode();
    }

    public function lastResponseHasErrors(): bool
    {
        $decoded = $this->decodeLastResponse();

        return isset($decoded['violations']) && !empty($decoded['violations']);
    }
}
