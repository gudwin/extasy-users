<?php
namespace Extasy\Users\tests\Usecases;

use Extasy\Users\User;
use Extasy\Users\Usecases\SearchByLogin;

use Extasy\Users\tests\Samples\MemoryUsersRepository;
use Extasy\Users\tests\BaseTest;

class SearchByLoginTest extends BaseTest
{
    const MarieLogin = 'marie';
    const ClarieLogin = 'clari';
    const ClaraLogin = 'clara';
    /**
     * @var MemoryUsersRepository
     */
    protected $usersRepository;

    public function setUp()
    {
        parent::setUp();
        $this->usersRepository = new MemoryUsersRepository();
        $this->usersRepository->insert(new User(['login' => self::MarieLogin], $this->configurationRepository));
        $this->usersRepository->insert(new User(['login' => self::ClarieLogin], $this->configurationRepository));
        $this->usersRepository->insert(new User(['login' => self::ClaraLogin], $this->configurationRepository));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSearchWithSmallKeyPhrase()
    {
        $usecase = new SearchByLogin('a', $this->usersRepository);
        $usecase->execute();
    }

    public function testSearchUnknownUser()
    {
        $usecase = new SearchByLogin('some_unknown_login', $this->usersRepository);
        $result = $usecase->execute();
        $this->assertTrue(is_array($result));
        $this->assertEquals(0, sizeof($result));
    }

    public function testSearch()
    {
        $usecase = new SearchByLogin('ari', $this->usersRepository);
        $result = $usecase->execute();
        $this->assertTrue(is_array($result));
        $this->assertEquals(2, sizeof($result));
        //
        $usecase = new SearchByLogin(self::MarieLogin, $this->usersRepository);
        $result = $usecase->execute();
        $this->assertTrue(is_array($result));
        $this->assertEquals(1, sizeof($result));
        $this->assertEquals(self::MarieLogin, $result[0]->login->getValue());

    }

}