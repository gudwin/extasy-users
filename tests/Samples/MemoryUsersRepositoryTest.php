<?php


namespace Extasy\Users\tests\Samples;


use Extasy\Users\tests\Integration\RepositoryTest;

class MemoryUsersRepositoryTest extends RepositoryTest
{
    protected function createRepository()
    {
        return new MemoryUsersRepository();
    }
}