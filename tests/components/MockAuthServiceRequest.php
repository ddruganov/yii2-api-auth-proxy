<?php

namespace tests\components;

use ddruganov\Yii2ApiAuthProxy\components\AuthServiceInterface;
use ddruganov\Yii2ApiAuthProxy\components\AuthServiceRequestInterface;
use ddruganov\Yii2ApiEssentials\ExecutionResult;
use tests\components\faker\FakerFactory;

final class MockAuthServiceRequest implements AuthServiceRequestInterface
{
   public function make(string $method, string $url, array $data, ?string $accessToken = null): ExecutionResult
   {
      if (str_ends_with($url, AuthServiceInterface::CURRENT_USER_ENDPOINT)) {
         return ExecutionResult::success([
            'id' => FakerFactory::create()->numberBetween(1, 100)
         ]);
      }

      return ExecutionResult::success();
   }
}
