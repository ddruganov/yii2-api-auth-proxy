<?php

namespace ddruganov\Yii2ApiAuthProxy\forms\auth;

use ddruganov\Yii2ApiAuthProxy\components\AccessTokenProviderInterface;
use ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface;
use ddruganov\Yii2ApiEssentials\ExecutionResult;
use ddruganov\Yii2ApiEssentials\forms\Form;
use Yii;

final class LogoutForm extends Form
{
    protected function _run(): ExecutionResult
    {
        $result = $this->getAuthService()->logout($this->getAccessTokenProvider()->getAccessToken());
        if (!$result->isSuccessful()) {
            return ExecutionResult::exception('Ошибка выхода из аккаунта');
        }

        return ExecutionResult::success();
    }

    private function getAccessTokenProvider(): AccessTokenProviderInterface
    {
        return Yii::$app->get(AccessTokenProviderInterface::class);
    }

    private function getAuthService(): AuthServiceInterface
    {
        return Yii::$app->get(AuthServiceInterface::class);
    }
}
