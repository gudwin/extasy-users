<?php
namespace Extasy\Users\tests\Integration;

use PHPUnit_Framework_TestCase;
use Extasy\Users\Configuration\Configuration;
use Extasy\Users\Configuration\ConfigurationRepository;

abstract class ConfigurationRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ConfigurationRepository
     */
    protected $configurationRepository;

    /**
     * @return ConfigurationRepository
     */
    abstract protected function getConfigurationRepository();

    protected function setUp()
    {
        parent::setUp();
        $this->configurationRepository = $this->getConfigurationRepository();
    }
    public function testWriteAndGet() {
        $fixture = new Configuration();
        $fixture->fields = [
            'name' => '\\Extasy\\Model\\Columns\\Input',
            'surname' => '\\Extasy\\Model\\Columns\\Input'
        ];
        $this->configurationRepository->write( $fixture );

        $this->assertEquals( $fixture, $this->configurationRepository->read() );

        $anotherFixture = new Configuration();
        $anotherFixture->fields = [
            'name2' => '\\Extasy\\Model\\Columns\\Input',
            'surname2' => '\\Extasy\\Model\\Columns\\Input'
        ];
        $this->configurationRepository->write( $anotherFixture );

        $this->assertEquals( $anotherFixture, $this->configurationRepository->read() );

    }
}