<?php
namespace Extasy\Users\tests;

use PHPUnit_Framework_TestCase;
use Extasy\Users\Configuration\Configuration;
class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    protected $configuration;

    public function setUp()
    {
        parent::setUp();
        $this->configuration = new Configuration();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWriteUnknownField() {
        $this->configuration->xx = '123';
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testReadUnknownField() {
        $this->configuration->xx;
    }
    public function testReadAndWrite() {
        $fields = ['hello world'];
        $this->configuration->fields = $fields;

        $hash = '123';
        $this->configuration->securityHash = $hash;

        $this->assertEquals( $fields, $this->configuration->fields );
        $this->assertEquals( $hash, $this->configuration->securityHash );
    }
}