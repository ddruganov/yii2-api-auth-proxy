<?php

namespace ddruganov\Yii2ApiAuthProxy\components;

interface AccessTokenProviderInterface
{
    public function getAccessToken(): string;
}
