<?php
namespace Extasy\Users\Configuration;


interface ConfigurationRepository
{
    public function read();
    public function write( Configuration $configuration );
}