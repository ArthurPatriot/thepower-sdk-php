<?php

namespace ThePower;

use GuzzleHttp\Client;
use ThePower\Enums\HttpMethod;
use ThePower\Exceptions\PowerApiException;

class PowerClient
{
    protected Client $client;

    /**
     * @param  string  $apiUrl
     * @param  array  $options
     */
    public function __construct(string $apiUrl, array $options = [])
    {
        $this->client = new Client([
            ...$options,
            'http_errors' => false,
            'base_uri' => trim($apiUrl, " \t\n\r\0\x0B\/").'/api/',
        ]);
    }

    /**
     * @param  HttpMethod  $method
     * @param  string  $path
     * @param  array  $payload
     * @return array
     * @throws PowerApiException
     */
    protected function request(HttpMethod $method, string $path, array $payload = []): array
    {
        try {
            $response = $this->client->request($method->value, $path, [
                $method === HttpMethod::GET ? 'query' : 'json' => $payload,
            ]);
        } catch (\Throwable $e) {
            throw new PowerApiException($e->getMessage(), $e->getCode());
        }

        $data = json_decode($response->getBody()->getContents(), true);

        if (empty($data[ 'ok' ]) || $data[ 'ok' ] !== true) {
            throw new PowerApiException($data[ 'msg' ], $data[ 'code' ]);
        }

        return $data;
    }

    /**
     * @return bool
     * @throws PowerApiException
     */
    public function status(): bool
    {
        $data = $this->request(HttpMethod::GET, 'status');

        return (bool) $data[ 'ok' ];
    }

    /**
     * @return array
     * @throws PowerApiException
     */
    public function nodeStatus(): array
    {
        $data = $this->request(HttpMethod::GET, 'node/status');

        return $data[ 'status' ];
    }

    /**
     * @return array
     * @throws PowerApiException
     */
    public function settings(): array
    {
        $data = $this->request(HttpMethod::GET, 'settings');

        return $data[ 'settings' ];
    }

    /**
     * @param  string  $hash
     * @return array
     * @throws PowerApiException
     */
    public function blockInfo(string $hash): array
    {
        $data = $this->request(HttpMethod::GET, 'blockinfo/'.$hash);

        return $data[ 'block' ];
    }

    /**
     * @param  string  $hash
     * @return array
     * @throws PowerApiException
     */
    public function block(string $hash): array
    {
        $data = $this->request(HttpMethod::GET, 'block/'.$hash);

        return $data[ 'block' ];
    }

    /**
     * @param  string  $address
     * @return array
     * @throws PowerApiException
     */
    public function where(string $address): array
    {
        return $this->request(HttpMethod::GET, 'where/'.$address);
    }

    /**
     * @param  string  $address
     * @return array
     * @throws PowerApiException
     */
    public function address(string $address): array
    {
        return $this->request(HttpMethod::GET, 'address/'.$address);
    }
}