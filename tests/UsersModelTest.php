<?php


namespace Extasy\Users\tests;

use Extasy\Users\User;

class UsersModelTest extends BaseTest
{
    public function testIsBanned()
    {
        $bannedUser = new User([], $this->configurationRepository);
        $bannedUser->confirmation_code = '123';
        $this->assertTrue($bannedUser->isBanned());
        $normalUser = new User([], $this->configurationRepository);
        $this->assertFalse($normalUser->isBanned());
    }
}