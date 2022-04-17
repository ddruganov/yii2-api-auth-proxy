<?php

namespace ddruganov\Yii2ApiAuthProxy\components;

use ddruganov\Yii2ApiEssentials\ExecutionResult;

interface AuthServiceInterface
{
    public const VERIFY_ENDPOINT = 'auth/verify';
    public const REFRESH_ENDPOINT = 'auth/refresh';
    public const LOGOUT_ENDPOINT = 'auth/logout';
    public const CHECK_PERMISSION_ENDPOINT = 'auth/check-permission';
    public const CURRENT_USER_ENDPOINT = 'auth/current-user';

    public function verify(string $accessToken): ExecutionResult;
    public function refresh(string $refreshToken): ExecutionResult;
    public function logout(string $accessToken): ExecutionResult;
    public function checkPermission(string $accessToken, string $permissionName): ExecutionResult;
    public function getUser(string $accessToken): AuthServiceUser;
}
