<?php
namespace Extasy\Users\tests\Samples;

use Extasy\Users\Configuration\ConfigurationRepository;
use Extasy\Users\Configuration\Configuration;
class MemoryConfigurationRepository implements ConfigurationRepository
{

    const securityHash = '123456';
    protected $confuguration = null;

    public function __construct()
    {

        $this->confuguration = new Configuration();
        $this->confuguration->fields = [
            'name' => '\\Extasy\\Model\\Columns\\Index'
        ];
        $this->confuguration->securityHash = self::securityHash;
    }
    public function read() {
        return $this->confuguration;
    }
    public function write( Configuration $configuration ) {
        $this->confuguration = $configuration;
    }
}