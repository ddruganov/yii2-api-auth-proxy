<?php

namespace tests\unit;

use ddruganov\Yii2ApiAuthProxy\components\AccessTokenProviderInterface;
use ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface;
use ddruganov\Yii2ApiEssentials\testing\UnitTest;
use tests\components\faker\FakerFactory;
use tests\components\faker\Generator;
use tests\components\MockAccessTokenProvider;
use Yii;

abstract class BaseUnitTest extends UnitTest
{
    public string $fakerFactoryClass = FakerFactory::class;

    protected function _setUp()
    {
    }

    protected function _tearDown()
    {
    }

    protected function getFaker(): Generator
    {
        return parent::getFaker();
    }

    protected function getAuthService(): AuthServiceInterface
    {
        return Yii::$app->get(AuthServiceInterface::class);
    }

    protected function getAccessTokenProvider(): MockAccessTokenProvider
    {
        return Yii::$app->get(AccessTokenProviderInterface::class);
    }
}
