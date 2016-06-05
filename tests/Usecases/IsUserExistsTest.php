<?php
namespace Extasy\Users\tests\Usecases;

use Extasy\Users\User;
use Extasy\Users\Usecases\IsUserExists;

use Extasy\Users\tests\BaseTest;
use Extasy\Users\tests\Samples\MemoryUsersRepository;

class IsUserExistsTest extends BaseTest
{
    const MarieLogin = 'marie';
    /**
     * @var MemoryUsersRepository
     */
    protected $usersRepository;

    public function setUp()
    {
        parent::setUp();

        $this->usersRepository = new MemoryUsersRepository();
        $this->usersRepository->insert(new User(['login' => self::MarieLogin], $this->configurationRepository));
    }

    public function testOnUnknownUser()
    {
        $usecase = new IsUserExists('some_unknown', $this->usersRepository);
        $this->assertFalse($usecase->execute());
    }

    public function testKnownUser()
    {
        $usecase = new IsUserExists(self::MarieLogin, $this->usersRepository);
        $this->assertTrue($usecase->execute());
    }
}