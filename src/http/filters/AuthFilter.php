<?php

namespace ddruganov\Yii2ApiAuthProxy\http\filters;

use ddruganov\Yii2ApiAuthProxy\components\AccessTokenProviderInterface;
use ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface;
use Yii;
use yii\base\ActionFilter;

final class AuthFilter extends ActionFilter
{
    public array $exceptions = [];

    public function beforeAction($action)
    {
        if (in_array($this->getActionId($action), $this->exceptions)) {
            return parent::beforeAction($action);
        }

        /** @var \ddruganov\Yii2ApiAuthProxy\components\AccessTokenProviderInterface */
        $accessTokenProvider = Yii::$app->get(AccessTokenProviderInterface::class);

        /** @var \ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface */
        $authService = Yii::$app->get(AuthServiceInterface::class);

        $result = $authService->verify($accessTokenProvider->getAccessToken());
        if ($result->isSuccessful()) {
            return parent::beforeAction($action);
        }

        Yii::$app->getResponse()->data = $result;
        Yii::$app->getResponse()->setStatusCode(401);
        Yii::$app->end();
    }
}
