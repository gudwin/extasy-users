<?php
namespace Extasy\Users\tests\Usecases;

use Extasy\Users\tests\BaseTest;
use Extasy\Users\tests\Samples\MemoryUsersRepository;
use \Extasy\Users\User;
use Extasy\Users\Usecases\GetUserInfo;

class GetUserInfoTest extends BaseTest
{
    const MarieLogin = 'Marie';
    const MailValue = 'test@test.com';
    /**
     * @var MemoryUsersRepository
     */
    protected $repository = null;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new MemoryUsersRepository();
        $this->repository->insert(new User(['login' => self::MarieLogin, 'email' => self::MailValue],
            $this->configurationRepository));

    }

    public function testWithEmptyFields()
    {
        $usecase = new GetUserInfo($this->repository->get(1), []);
        $result = $usecase->execute();
        $this->assertTrue(is_array($result));
        $this->assertEquals([], $result);

    }

    public function testWithSeveralFields()
    {
        $usecase = new GetUserInfo($this->repository->get(1), ['email']);
        $result = $usecase->execute();
        $this->assertTrue(is_array($result));
        $this->assertEquals(['email' => self::MailValue], $result);


        $usecase = new GetUserInfo($this->repository->get(1), ['login', 'email']);
        $result = $usecase->execute();
        $this->assertTrue(is_array($result));
        $this->assertEquals(['login' => self::MarieLogin, 'email' => self::MailValue], $result);
    }

}