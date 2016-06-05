<?php


namespace Extasy\Users\Search;

use \InvalidArgumentException;

/**
 * Class SearchCondition
 * @package Extasy\Users
 * @property array $likeFields
 * @property array $fields
 * @property int $limit
 * @property int $offset
 */
class Request
{
    protected $likeFields = [];
    protected $fields = [];
    protected $limit = 10;
    protected $offset = 0;


    public function __get($name)
    {
        switch ($name) {
            case 'likeFields':
                return $this->likeFields;
                break;
            case 'fields':
                return $this->fields;
                break;
            case 'limit':
                return $this->limit;
                break;
            case 'offset':
                return $this->offset;
                break;
            default:
                throw new InvalidArgumentException(sprintf('Unknown property `%s`', $name));
        }
    }

    public function __isset($name)
    {
        if ($this->hasOwnProperty( $name )) {
            return !empty( $this->$name );
        }
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'fields':
                $this->fields = $value;
                break;
            case 'likeFields':
                $this->likeFields = $value;
                break;
            case 'limit':
                $this->limit = max(0, intval($value));
                break;
            case 'offset':
                $this->offset = max(0, intval($value));
                break;
            default:
                throw new InvalidArgumentException(sprintf('Unknown property `%s`', $name));
        }
    }

    protected function hasOwnProperty($propertyName)
    {
        $properties = ['fields', 'likeFields', 'limit', 'offset'];

        return in_array($propertyName, $properties);
    }
}