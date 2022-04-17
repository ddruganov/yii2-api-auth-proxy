<?php

namespace ddruganov\Yii2ApiAuthProxy\http\controllers;

use ddruganov\Yii2ApiAuthProxy\collectors\user\CurrentUserCollector;
use ddruganov\Yii2ApiAuthProxy\forms\auth\LoginForm;
use ddruganov\Yii2ApiAuthProxy\forms\auth\LogoutForm;
use ddruganov\Yii2ApiAuthProxy\http\controllers\SecureApiController;
use ddruganov\Yii2ApiEssentials\http\actions\FormAction;
use yii\helpers\ArrayHelper;

class AuthController extends SecureApiController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'auth' => [
                'exceptions' => ['login', 'refresh']
            ],
            'rbac' => [
                'exceptions' => ['login', 'refresh'],
                'rules' => [
                    'current-user' => 'authenticate',
                    'logout' => 'authenticate'
                ]
            ]
        ]);
    }

    public function actions()
    {
        return [
            'login' => [
                'class' => FormAction::class,
                'formClass' => LoginForm::class
            ],
            'refresh' => [
                'class' => FormAction::class,
                'formClass' => RefreshForm::class
            ],
            'current-user' => [
                'class' => FormAction::class,
                'formClass' => CurrentUserCollector::class
            ],
            'logout' => [
                'class' => FormAction::class,
                'formClass' => LogoutForm::class
            ]
        ];
    }
}
