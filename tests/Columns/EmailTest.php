<?php


namespace Extasy\Login\tests\Columns;


use Extasy\Users\Columns\Email;
use Extasy\Users\tests\BaseTest;

class EmailTest extends BaseTest
{
    const EmailValue = 'new@email.com';

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInitWithNotAnEmail()
    {
        new Email('testColumn', [], 'bla-bla-bla');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetValueWithNotAnEmail()
    {
        $column = $this->factoryColumn();
        $column->setValue('bla-bla-bla');
    }

    public function testSetValue()
    {
        $column = $this->factoryColumn();
        $column->setValue(self::EmailValue);
        $this->assertEquals(self::EmailValue, $column->getValue());
    }

    /**
     * @return Email
     */
    protected function factoryColumn()
    {
        return new Email('testColumn', [], null);
    }
}