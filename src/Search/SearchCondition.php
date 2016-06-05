<?php


namespace Extasy\Users\Search;


class SearchCondition
{
    const EqualCondition = 0;
    const GreaterCondition = 1;
    const LowerCondition = 2;
    const NotEqualCondition = 3;

    protected $condition = null;
    protected $fieldName = '';
    protected $value = '';

    public function __construct($condition, $fieldName, $value)
    {
        $this->condition = $condition;
        $this->fieldName = $fieldName;
        $this->value = $value;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getValue()
    {
        return $this->value;
    }

}