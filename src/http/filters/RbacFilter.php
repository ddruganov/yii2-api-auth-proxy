<?php

namespace ddruganov\Yii2ApiAuthProxy\http\filters;

use ddruganov\Yii2ApiAuthProxy\components\AccessTokenProviderInterface;
use ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface;
use Yii;
use yii\base\ActionFilter;

final class RbacFilter extends ActionFilter
{
    public array $rules = [];
    public array $exceptions = [];

    public function beforeAction($action)
    {
        if (in_array($this->getActionId($action), $this->exceptions)) {
            return parent::beforeAction($action);
        }

        $permissionName = $this->rules[$this->getActionId($action)] ?? null;

        /** @var \ddruganov\Yii2ApiAuthProxy\components\AccessTokenProviderInterface */
        $accessTokenProvider = Yii::$app->get(AccessTokenProviderInterface::class);

        /** @var \ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface */
        $authService = Yii::$app->get(AuthServiceInterface::class);

        $result = $authService->checkPermission($accessTokenProvider->getAccessToken(), $permissionName);
        if ($result->isSuccessful()) {
            return parent::beforeAction($action);
        }

        Yii::$app->getResponse()->data = $result;
        Yii::$app->getResponse()->setStatusCode(403);
        Yii::$app->end();
    }
}
