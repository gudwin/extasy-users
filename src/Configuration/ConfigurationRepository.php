<?php
namespace Extasy\Users\Configuration;


interface ConfigurationRepository
{
    /**
     * @return Configuration
     */
    public function read();

    /**
     * @param Configuration $configuration
     * @return mixed
     */
    public function write( Configuration $configuration );
}