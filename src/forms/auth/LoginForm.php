<?php

namespace ddruganov\Yii2ApiAuthProxy\forms\auth;

use ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface;
use ddruganov\Yii2ApiEssentials\ExecutionResult;
use ddruganov\Yii2ApiEssentials\forms\Form;
use Yii;

final class LoginForm extends Form
{
    public ?string $accessToken = null;

    public function rules()
    {
        return [
            [['accessToken'], 'required'],
            [['accessToken'], 'string']
        ];
    }

    protected function _run(): ExecutionResult
    {
        $result = $this->getAuthService()->verify($this->accessToken);
        if (!$result->isSuccessful()) {
            return ExecutionResult::exception('Ошибка проверки валидности авторизации');
        }

        return ExecutionResult::success();
    }

    private function getAuthService(): AuthServiceInterface
    {
        return Yii::$app->get(AuthServiceInterface::class);
    }
}
