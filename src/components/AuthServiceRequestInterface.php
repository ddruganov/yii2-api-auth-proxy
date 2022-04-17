<?php

namespace ddruganov\Yii2ApiAuthProxy\components;

use ddruganov\Yii2ApiEssentials\ExecutionResult;

interface AuthServiceRequestInterface
{
    public const GET = 'get';
    public const POST = 'post';

    public function make(string $method, string $url, array $data, ?string $accessToken = null): ExecutionResult;
}
