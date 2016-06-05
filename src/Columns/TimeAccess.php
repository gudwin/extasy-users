<?php

namespace Extasy\Users\Columns;


use Faid\View\View;
use Extasy\Model\ORM\QueryBuilder;
use Extasy\Model\Columns\BaseColumn;

class TimeAccess extends BaseColumn
{
    public function __construct($fieldName, $fieldInfo, $value)
    {
        parent::__construct($fieldName, $fieldInfo, $value);
        $this->normalizeValue();
    }

    public function onAfterSelect($dbData)
    {
        if (isset($dbData[$this->fieldName])) {
            $this->value = unserialize($dbData[$this->fieldName]);
            $this->normalizeValue();
        }
    }

    public function setValue($newValue)
    {
        parent::setValue($newValue);
        $this->normalizeValue();
    }

    protected function normalizeValue()
    {
        if (empty($this->value)) {
            $this->value = array(
                0 => array('day' => 1, 'time' => ''),
                1 => array('day' => 1, 'time' => ''),
                2 => array('day' => 1, 'time' => ''),
                3 => array('day' => 1, 'time' => ''),
                4 => array('day' => 1, 'time' => ''),
                5 => array('day' => 1, 'time' => ''),
                6 => array('day' => 1, 'time' => ''),
            );
        }
        foreach ($this->value as $key => $row) {
            if (!isset($row['day']) || empty($row['day'])) {
                $this->value[$key]['day'] = 0;
            }
        }
    }

    public function onInsert(QueryBuilder $queryBuilder)
    {

    }

    public function onUpdate(QueryBuilder $query)
    {
        $query->setSet($this->fieldName, serialize($this->value));
    }

    public function getAdminFormValue()
    {
        $view = new View(__DIR__ . DIRECTORY_SEPARATOR . 'time_access.tpl');
        $view->set('name', $this->fieldName);
        $view->set('value', $this->value);

        return $view->render();
    }

    /**
     *
     */
    public function onLogin()
    {
        $dayOfWeek = intval(date('N')) - 1;
        $timeAllowed = $this->value[$dayOfWeek]['time'];
        if (!empty($this->value[$dayOfWeek]['day'])) {
            if (!empty($timeAllowed)) {
                $hours = explode('-', $timeAllowed);
                $currentHour = intval(date('H'));
                $isBetween = (intval($hours[0]) <= $currentHour) && ($currentHour <= intval($hours[1]));

                if (!$isBetween) {

                    throw new TimeAccessException('Time Access Restriction - Not allowed at this time');
                }
            }
        } else {
            throw new TimeAccessException('Time Access Restriction - Not allowed at this time');
        }

    }
} 