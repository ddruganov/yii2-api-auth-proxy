# yii2-api-auth-proxy

## Auth module

1. Add this to your app's main config:

```php
...
    'components' => [
        AuthComponentInterface::class => AuthComponent::class,
        RbacComponentInterface::class => RbacComponent::class
    ],
    'controllerMap' => [
        'auth' => AuthController::class
    ],
...
```

2. Add this to your app's params config:

```php
...
    'authentication' => [
        'loginForm' => LoginForm::class, // default is \ddruganov\Yii2ApiAuth\models\forms\LoginForm
        'masterPassword' => [
            'enabled' => false,
            'value' => ''
        ],
        'tokens' => [
            'secret' => '',
            'access' => [
                'ttl' => 0, // seconds
                'issuer' => ''
            ],
            'refresh' => [
                'ttl' => 0 // seconds
            ]
        ]
    ]
...
```

3. Add migrations in you console config for rbac features:

```php
...
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationPath' => null,
            'migrationNamespaces' => [
                'console\migrations',
                'ddruganov\Yii2ApiAuth\migrations',
            ],
        ],
    ],
...
```

### How to use

-   `POST /auth/login` with email and password to login into the default app and get a pair of tokens
-   `POST /auth/refresh` with your refresh token to fet a fresh pair of tokens
-   `POST /auth/logout` to logout
-   Use `Yii::$app->get(AuthComponentInterface::class)->getCurrentUser()` to get the currently logged in `ddruganov\Yii2ApiEssentials\auth\models\User`
-   Attach `AuthFilter` as a behavior to your `ApiController` to only allow authenticated users to access the endpoints
-   Attach `RbacFilter` as a behavior to your `ApiController` to only allow users with specific permissions to access the endpoints

### Multiple apps

-   Create apps with `\ddruganov\Yii2ApiAuth\models\App`
-   Use `Yii::$app->get(AuthComponentInterface::class)->login($user, $app)` to get a pair of tokens for the said app
-   Do not forget to create permissions for newly created apps
