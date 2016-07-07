<?php
namespace Extasy\Users\tests\Integration;

use Extasy\Users\Search\Request;
use Extasy\Users\SearchCondition;
use Extasy\Users\tests\BaseTest;
use Extasy\Users\RepositoryInterface;
use Extasy\Users\User as UserAccount;
use Extasy\Model\NotFoundException;

abstract class RepositoryTest extends BaseTest
{
    const Marie = 'marie';
    const Elen = 'elen';
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->createRepository();
        $this->setupInitialData();
    }

    protected function setupInitialData()
    {
        $this->repository->flush();
        $data = [
            new UserAccount(['login' => self::Marie], $this->configurationRepository),
            new UserAccount(['login' => self::Elen], $this->configurationRepository),
        ];
        $this->fixtureUsers( $data );
    }

    /**
     * @return RepositoryInterface
     */
    abstract protected function createRepository();

    /**
     * @expectedException \Extasy\Model\NotFoundException
     */
    public function testGetUnknown()
    {
        $this->repository->get(-1);
    }

    public function testGet()
    {
        $this->assertEquals(self::Marie, $this->repository->get(1)->login->getValue());
        $this->assertEquals(self::Elen, $this->repository->get(2)->login->getValue());
    }

    public function testInsert()
    {
        $fixture = 'hello';
        $newUser = new UserAccount(['login' => $fixture], $this->configurationRepository);
        $this->repository->insert($newUser);

        //
        $persistentUser = $this->repository->get($newUser->id->getValue());
        $this->assertEquals($fixture, $persistentUser->login->getValue());

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateNonPersistentUser() {
        $fixture = 'hello';
        $newUser = new UserAccount(['login' => $fixture], $this->configurationRepository);
        $this->repository->update( $newUser );
    }
    public function testUpdate()
    {
        $newName = 'Anna';
        $originalUser = $this->repository->get(1);
        $originalUser->login = $newName;
        $this->repository->update($originalUser);
        $persistentUser = $this->repository->get(1);
        $this->assertEquals($newName, $persistentUser->login->getValue());

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDeleteNonPersistentUser()
    {
        $this->repository->delete(new UserAccount(['login' => 'some_login'], $this->configurationRepository));
    }

    public function testDelete()
    {
        $user = $this->repository->get(1);
        $this->repository->delete($user);
        try {
            $this->repository->get(1);
            $this->fail('NotFoundException should be raised');
        } catch (NotFoundException $e) {

        } catch (\Exception $e) {
            $this->fail('NotFoundException should be raised');
        }
    }


    public function testFind()
    {
        $condition = new Request();
        $condition->fields = [
            'login' => self::Marie
        ];
        $found = $this->repository->find($condition);
        $this->assertEquals(self::Marie, $found[0]->login->getValue());
    }

    public function testFindWithOffsets()
    {
        $fixture = 'Hello world!';
        $configuration = $this->configurationRepository->read();
        $configuration->fields =['a' => '\\Extasy\\Model\\Columns\\Input'];

        $this->configurationRepository->write( $configuration );
        $data = [
            new UserAccount(['login' => self::Marie,'a' => $fixture], $this->configurationRepository),
            new UserAccount(['login' => self::Elen,'a' => $fixture ], $this->configurationRepository),
        ];
        $this->fixtureUsers( $data );

        $condition = new Request();
        $condition->fields = ['a' => $fixture];
        $condition->offset = 1;
        $condition->limit = 1;
        $result = $this->repository->find($condition);
        $this->assertEquals(1, sizeof($result));
        $this->assertEquals(self::Elen, $result[0]->login->getValue());
    }

    public function testFindOne()
    {
        $condition = new Request();
        $condition->fields =[
            'login' => self::Marie
        ];
        $condition->offset = 0;
        $condition->limit = 1;
        $result = $this->repository->findOne($condition);
        $this->assertEquals(self::Marie, $result->login->getValue());
    }
    protected function fixtureUsers( $data ) {

        foreach ($data as $user) {
            $this->repository->insert($user);
        }
    }
}