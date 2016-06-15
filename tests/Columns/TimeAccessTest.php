<?php
namespace Extasy\Login\tests\Columns;

use Extasy\Users\tests\BaseTest;
use Extasy\Users\Columns\TimeAccess;
use Extasy\Users\Columns\TimeAccessException;

class TimeAccessTest extends BaseTest
{
    const SundayDate = '2016-06-19';

    protected function fixture()
    {
        return [
            ['day' => 0, 'time' => '08-17'],
            ['day' => 0, 'time' => '08-17'],
            ['day' => 0, 'time' => '08-17'],
            ['day' => 0, 'time' => '08-17'],
            ['day' => 0, 'time' => '08-17'],
            ['day' => 0, 'time' => '08-17'],
            ['day' => 1, 'time' => '08-17'],
        ];
    }

    public function testValueNormalized()
    {
        $column = $this->columnFactory();
        $returned = $column->getValue();
        $this->assertEquals(7, sizeof($returned));
        $this->assertTrue(isset($returned[0]['day']));
        $this->assertTrue(isset($returned[0]['time']));
    }

    /**
     * @expectedException \Extasy\Users\Columns\TimeAccessException
     */
    public function testValidateWithWrongDay()
    {
        $column = $this->columnFactory($this->fixture());
        $time = strtotime('2016-06-13');
        $column->validateAccessTime($time);
    }

    /**
     * @expectedException \Extasy\Users\Columns\TimeAccessException
     */
    public function testValidateWithWrongTime()
    {
        $column = $this->columnFactory($this->fixture());
        $wrongTime = self::SundayDate . ' 18:00:00';
        $column->validateAccessTime(strtotime($wrongTime));
    }

    public function testValidateTime()
    {
        $column = $this->columnFactory($this->fixture());
        $rightTime = self::SundayDate . ' 09:00:00';
        $column->validateAccessTime(strtotime($rightTime));
    }

    protected function columnFactory($value = null)
    {
        return new TimeAccess('test', [], $value);
    }
}