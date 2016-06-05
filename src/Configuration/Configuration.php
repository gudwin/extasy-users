<?php
namespace Extasy\Users\Configuration;

use \InvalidArgumentException;

/**
 * Class Configuration
 * @property array $fields
 * @property string $securityHash
 */
class Configuration
{
    protected $fields = [];

    protected $securityHash = '';

    protected function hasOwnProperty($name)
    {
        return in_array($name, ['fields', 'securityHash']);
    }

    public function __set($name, $value)
    {
        if ($this->hasOwnProperty($name)) {
            $this->$name = $value;
            return ;
        }

        throw new InvalidArgumentException(sprintf('Unknown property `%s`', $name));
    }

    public function __get($name)
    {
        if ($this->hasOwnProperty($name)) {
            return $this->$name;
        }
        throw new InvalidArgumentException(sprintf('Unknown property `%s`', $name));
    }

}