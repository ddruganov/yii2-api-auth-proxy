<?php

namespace tests\unit\tests;

use tests\unit\BaseUnitTest;

final class AuthServiceTest extends BaseUnitTest
{
    public function testVerify()
    {
        $result = $this->getAuthService()->verify($this->getAccessToken());
        $this->assertExecutionResultSuccessful($result);
    }

    public function testRefresh()
    {
        $result = $this->getAuthService()->refresh($this->getAccessToken());
        $this->assertExecutionResultSuccessful($result);
    }

    public function testCheckPermission()
    {
        $result = $this->getAuthService()->checkPermission($this->getAccessToken(), $this->getFaker()->word());
        $this->assertExecutionResultSuccessful($result);
    }

    public function testGetUser()
    {
        $user = $this->getAuthService()->getUser($this->getAccessToken());
        $this->assertNotNull($user);
        $this->assertIsNumeric($user->getId());
    }

    private function getAccessToken()
    {
        return 'CfDJ8OW5OI0CPGJBgSNlGwO0x4YF7qbYKVv7KOO-N0eFtDUzXOrL7F9Xd9W1otVi4ueJOkAmAhuoHFWNkqRaFD7zvAMHMSKncl6Vo5QXKmpvy6vqxOKxSURdIey8aZPRi3Nnhp2p9la-Al5xrVKz0lignRdcCHf3O7pF9zv_sNx_c_T7pUe3WsxaJEPX3t_9FO2Wjw';
    }
}
