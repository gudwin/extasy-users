<?php
namespace Extasy\Login\tests\Columns;

use Extasy\Users\tests\BaseTest;
use Extasy\Users\Columns\Password;


class PasswordTest extends BaseTest
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWithoutHashField() {
        new Password('test',[],null);
    }
    public function testValueHashed() {
        $fixture = 123;
        $column = new Password('test',['hash' => 777],null );
        $column->setValue( $fixture );
        $this->assertNotEquals( $fixture, $column->getValue());
    }
    public function testValidatePassword( ) {
        $invalidValues = [
            'aaa123456!',
            'aa123456',
            'aa!',
            '123456!',
            'a1!',
        ];
        foreach ( $invalidValues as $value ) {
            try {
                Password::validatePassword( $value );
                $this->fail();
            } catch (\InvalidArgumentException $e ) {

            }
        }
        $validValue = 'a123456!';
        Password::validatePassword( $validValue );
    }
}