<?php

namespace ddruganov\Yii2ApiAuthProxy\http\controllers;

use ddruganov\Yii2ApiAuthProxy\http\filters\AuthFilter;
use ddruganov\Yii2ApiAuthProxy\http\filters\RbacFilter;
use ddruganov\Yii2ApiEssentials\http\controllers\ApiController;
use yii\helpers\ArrayHelper;

abstract class SecureApiController extends ApiController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'auth' => [
                'class' => AuthFilter::class
            ],
            'rbac' => [
                'class' => RbacFilter::class
            ]
        ]);
    }
}
