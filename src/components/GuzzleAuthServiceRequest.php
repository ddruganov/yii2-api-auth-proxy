<?php

namespace ddruganov\Yii2ApiAuthProxy\components;

use ddruganov\Yii2ApiEssentials\ExecutionResult;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use yii\helpers\Json;

final class GuzzleAuthServiceRequest implements AuthServiceRequestInterface
{
    public function make(string $method, string $url, array $data, ?string $accessToken = null): ExecutionResult
    {
        $config = [
            'http_errors' => false
        ];

        if ($data) {
            if ($method === self::GET) {
                $url .= '?' . http_build_query($data);
            } else {
                $config[RequestOptions::JSON] = $data;
            }
        }

        if ($accessToken) {
            $config['headers'] = [
                'Authorization' => "Bearer $accessToken"
            ];
        }

        $client = new Client();
        $response = $client->request($method, $url, $config);

        $json = $response->getBody()->getContents();
        $data = Json::decode($json);
        return ExecutionResult::fromArray($data);
    }
}
