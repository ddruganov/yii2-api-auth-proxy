# yii2-api-auth-proxy

An authentication proxy component library that connects your app with the yii2-api-auth server

## Installation

`composer require ddruganov/yii2-api-auth-proxy`

## Configuration

1. Add this to your app's main config:

```php
...
    'components' => [
        AccessTokenProviderInterface::class => HeaderAccessTokenProvider::class,
        AuthServiceInterface::class => AuthService::class,
        AuthServiceRequestInterface::class => GuzzleAuthServiceRequest::class
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
        'externalService' => [
            'url' => 'https://server-that-has-yii2-api-auth-installed'
        ]
    ]
...
```

## How to use

-   `POST /auth/login` with an access token that you got from logging in on the yii2-api-auth server to check that your log in is valid
-   `POST /auth/refresh` with your refresh token to get a fresh pair of tokens form the main server
-   `POST /auth/logout` to send a logout request to the main server
-   Use `Yii::$app->get(AuthServiceInterface::class)->getUser()` to get the `ddruganov\Yii2ApiAuthProxy\components\AuthServiceUser`
-   Attach `AuthFilter` as a behavior to your `ApiController` to only allow authenticated users to access the endpoints
-   Attach `RbacFilter` as a behavior to your `ApiController` to only allow users with specific permissions to access the endpoints

### Extending `AuthServiceInterface::getUser()` example

```php
class YourAuthService extends Yii2ApiAuthProxyAuthService
{
    public function getUser(string $accessToken): YourAuthServiceUser
    {
        $baseUrl = Yii::$app->params['authentication']['externalService']['url'];

        $result = Yii::$app->get(AuthServiceRequestInterface::class)->make(
            method: AuthServiceRequestInterface::GET,
            url: $baseUrl . '/' . self::CURRENT_USER_ENDPOINT,
            data: [],
            accessToken: $accessToken
        );

        if (!$result->isSuccessful()) {
            throw new Exception('Error getting user from a remote auth server');
        }

        return new YourAuthServiceUser($result->getData());
    }
}
```
