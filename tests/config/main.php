<?php

use ddruganov\Yii2ApiAuthProxy\components\AccessTokenProviderInterface;
use ddruganov\Yii2ApiAuthProxy\components\AuthService;
use ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface;
use ddruganov\Yii2ApiAuthProxy\components\AuthServiceRequestInterface;
use tests\components\MockAccessTokenProvider;
use tests\components\MockAuthServiceRequest;

return [
    'id' => 'test',
    'basePath' => Yii::getAlias('@tests'),
    'components' => [
        AuthServiceInterface::class => AuthService::class,
        AuthServiceRequestInterface::class => MockAuthServiceRequest::class,
        AccessTokenProviderInterface::class => MockAccessTokenProvider::class
    ],
    'params' => [
        'authentication' => [
            'externalService' => [
                'baseApiUrl' => ''
            ]
        ]
    ]
];
