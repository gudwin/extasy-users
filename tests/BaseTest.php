<?php
namespace Extasy\Users\tests;

use PHPUnit_Framework_TestCase;
use Extasy\Users\Configuration\ConfigurationRepository;
use Extasy\Users\tests\Samples\MemoryConfigurationRepository;
abstract class BaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigurationRepository
     */
    protected $configurationRepository = null;
    public function setUp()
    {
        parent::setUp();
        $this->configurationRepository = new MemoryConfigurationRepository();
    }
}