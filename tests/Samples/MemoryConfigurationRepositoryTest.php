<?php


namespace Extasy\Users\tests\Samples;


use Extasy\Users\tests\Integration\ConfigurationRepositoryTest;

class MemoryConfigurationRepositoryTest extends ConfigurationRepositoryTest
{
    protected function getConfigurationRepository() {
        return new MemoryConfigurationRepository();
    }
}