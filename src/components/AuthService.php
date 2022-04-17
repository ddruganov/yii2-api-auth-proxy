<?php

namespace ddruganov\Yii2ApiAuthProxy\components;

use ddruganov\Yii2ApiEssentials\ExecutionResult;
use Exception;
use Yii;

final class AuthService implements AuthServiceInterface
{
    private function getUrl()
    {
        return Yii::$app->params['authentication']['externalService']['url'];
    }

    public function verify(string $accessToken): ExecutionResult
    {
        return $this->request(AuthServiceRequestInterface::GET, self::VERIFY_ENDPOINT, [], $accessToken);
    }

    public function logout(string $accessToken): ExecutionResult
    {
        return $this->request(AuthServiceRequestInterface::POST, self::LOGOUT_ENDPOINT, [], $accessToken);
    }

    public function refresh(string $refreshToken): ExecutionResult
    {
        return $this->request(
            AuthServiceRequestInterface::POST,
            self::REFRESH_ENDPOINT,
            ['refreshToken' => $refreshToken]
        );
    }

    public function checkPermission(string $accessToken, string $permissionName): ExecutionResult
    {
        return $this->request(
            AuthServiceRequestInterface::POST,
            self::CHECK_PERMISSION_ENDPOINT,
            ['permissionName' => $permissionName],
            $accessToken
        );
    }

    public function getUserDataByAccessToken(string $accessToken): ExecutionResult
    {
        $result = $this->request(AuthServiceRequestInterface::GET, self::CURRENT_USER_ENDPOINT, [], $accessToken);

        if (!$result->isSuccessful()) {
            throw new Exception('Ошибка получения данных о пользователе с удалённого сервера');
        }

        return $result;
    }

    private function request(string $method, string $endpoint, array $data, ?string $accessToken = null): ExecutionResult
    {
        return Yii::$app->get(AuthServiceRequestInterface::class)->make(
            method: $method,
            url: "{$this->getUrl()}/$endpoint",
            data: $data,
            accessToken: $accessToken
        );
    }
}
